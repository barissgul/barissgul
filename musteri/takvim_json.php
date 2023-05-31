<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$filtre = array();
	$sql = "SELECT 
				CONCAT(C.CARI, '\n', IFNULL(IL.IL,''), '/', IFNULL(ILCE.ILCE,''), ' - ', CH.ID, '\n') AS title,
				CONCAT_WS(' ', DATE(CH.TARIH), '08:00') AS start,
				DATE(CH.TARIH) AS start2,
				'border-primary bg-primary-500 text-white' AS className,
				CONCAT('/finans/popup_fatura.do?route=finans/popup_fatura&id=', CH.ID, '&kod=', CH.KOD) AS url
			FROM CARI_HAREKET AS CH
				LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID				
				LEFT JOIN IL AS IL ON IL.ID = C.IL_ID
				LEFT JOIN ILCE AS ILCE ON ILCE.ID = C.ILCE_ID
			WHERE CH.FATURA_DURUM_ID IN(1,2,3)
				AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2
			"; //T.SUREC_ID IN(1,2,3)
	/*		
	if($_SESSION['cari_id'] > 0){
		$sql.= " AND CH.CARI_ID = :CARI_ID";
		$filtre[":CARI_ID"]			= $_SESSION['cari_id'];	
	}
	*/
	$filtre[":TARIH1"]	= FormatTarih::Date($_REQUEST["start"]);
	$filtre[":TARIH2"]	= FormatTarih::Date($_REQUEST["end"]);
		
	fncSqlCariHareket($sql, $filtre);
	
	$sql.=" ORDER BY 1 DESC"; 
	$rows = $cdbPDO->rows($sql, $filtre);
	
	//var_dump2($cdbPDO->getSQL($sql, $filtre));
	
	echo json_encode($rows);
	