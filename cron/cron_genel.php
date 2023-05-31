<?
   	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
  	require_once ($_SERVER['DOCUMENT_ROOT'] . '/asset/simple_html_dom/simple_html_dom.php');
  	ini_set('max_execution_time', 3000);
  	define('MAX_FILE_SIZE', 60000000);
  	ini_set("memory_limit", "-1");
  	/*
  	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	*/
	
	
	
	$filtre = array();
	$sql = "UPDATE SITE SET STOK_SAYISI = (SELECT COUNT(*) AS SAY FROM YP_LISTE), GENEL_CRON_TARIH = NOW() WHERE ID = 2";
	$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
	
	$filtre = array();
	$sql = "SELECT 
				PM.*,
				PM.ID AS PARCA_MARKA_ID,
				PM.PARCA_MARKA AS ID
			FROM PARCA_MARKA AS PM
			WHERE 1
			";
	$rows_marka2 = $cdbPDO->rows($sql, $filtre);
	$rows_marka = arrayIndex($rows_marka2);
	
	$filtre = array();
	$sql = "SELECT PARCA_MARKA_ID, PARCA_MARKA FROM YP_LISTE WHERE 1 GROUP BY PARCA_MARKA ORDER BY PARCA_MARKA";
	$rows_marka_yeni = $cdbPDO->rows($sql, $filtre);
	
	foreach($rows_marka_yeni as $key => $row_marka_yeni){
		if(isset($rows_marka[$row_marka_yeni->PARCA_MARKA])) continue;
		
		$filtre = array();
		$sql = "INSERT INTO PARCA_MARKA SET PARCA_MARKA = :PARCA_MARKA, DURUM = 1";
		$filtre[":PARCA_MARKA"]	= $row_marka_yeni->PARCA_MARKA;
		$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
	}
	
	$filtre = array();
	$sql = "UPDATE YP_LISTE AS Y 
				LEFT JOIN PARCA_MARKA AS PM ON PM.PARCA_MARKA = Y.PARCA_MARKA
			SET Y.PARCA_MARKA_ID = PM.ID
			WHERE Y.PARCA_MARKA_ID IS NULL
			";
	$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
	
	$filtre = array();
	$sql = "UPDATE YP_LISTE AS YP 
				LEFT JOIN CARI AS TC ON TC.ID = YP.TEDARIKCI_ID
			SET YP.DURUM = IF(FIND_IN_SET(YP.PARCA_MARKA_ID, IFNULL(TC.PARCA_MARKA_IDS,'')) OR (TC.STOKSUZ_DURUM = 0 AND YP.STOK = 0), 0, 1)
			WHERE YP.DURUM != IF(FIND_IN_SET(YP.PARCA_MARKA_ID, IFNULL(TC.PARCA_MARKA_IDS,'')) OR (TC.STOKSUZ_DURUM = 0 AND YP.STOK = 0), 0, 1)
			";
	$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
	
	$filtre = array();
	$sql = "UPDATE YP_LISTE AS YP SET YP.KELIME = CONCAT_WS('|',REPLACE(REPLACE(YP.PARCA_KODU,'.',''),' ',''), REPLACE(REPLACE(YP.OEM_KODU,'.',''),' ','')) WHERE YP.KELIME IS NULL";
	$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
	
	/*
	$filtre = array();
	$sql = "UPDATE YP_LISTE AS YP 
				LEFT JOIN CARI AS C ON C.ID = YP.TEDARIKCI_ID
			SET YP.ALIS_FIYAT = YP.ALIS_FIYAT_ILK * ((100 - C.ISKONTO1)/100) * ((100 - C.ISKONTO2)/100) * ((100 - C.ISKONTO3)/100), 
				YP.SATIS_FIYAT = YP.ALIS_FIYAT_ILK * ((100 - C.ISKONTO1)/100) * ((100 - C.ISKONTO2)/100) * ((100 - C.ISKONTO3)/100) * ((100 + C.KAR_ORANI) / 100)
			WHERE CEIL(YP.ALIS_FIYAT) != CEIL(YP.ALIS_FIYAT_ILK * ((100 - C.ISKONTO1)/100) * ((100 - C.ISKONTO2)/100) * ((100 - C.ISKONTO3)/100))
				AND YP.ALIS_FIYAT_ILK > 0
			";
	$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
	*/
	
	echo "Bitti";