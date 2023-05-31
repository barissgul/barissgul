<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	header('Content-Type: text/html; charset=utf-8');
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ERROR | E_WARNING);
	ini_set('max_execution_time', 3000);
	ini_set("memory_limit", "-1");
	set_time_limit(0);
	
	$Alfabe = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	
	$filtre = array();
	$sql = "SELECT * FROM EXCEL WHERE ID = :ID AND KOD = :KOD";
	$filtre[":ID"] 		= $_REQUEST['id'];
	$filtre[":KOD"] 	= $_REQUEST['kod'];
	$row_excel = $cdbPDO->row($sql, $filtre);
	
	$excel_adi = $row_excel->EXCEL;
	$excel_tur = $row_excel->TUR;
	
	if(is_null($row_excel->ID)){
		echo "Dosya bulunamadı!";
		die();
	}
	
	if($row_excel->ONAY == 0){
		echo "Liste onaylanmamış!";
		die();
	}
	
	if(strlen($excel_adi) < 10 OR !in_array($excel_tur,array('YP_LISTE'))){
		echo "<b>Dosya Adı:</b> $excel_adi, <b>Dosya Türü:</b> $excel_tur <br> izin verimeyen dosya türü!";
		die();
	}
	
	$excel_adi = $cSabit->imgPathFolder("excel") . date("/Y/m/") . $excel_adi;
	
	try {
	    $excel_uzanti 	= PHPExcel_IOFactory::identify($excel_adi);
	    $objReader 		= PHPExcel_IOFactory::createReader($excel_uzanti);
	    $objPHPExcel 	= $objReader->load($excel_adi);
	} catch(Exception $e) {
	    die('Dosya Çalıştırma Hatası: "'.pathinfo($excel_adi,PATHINFO_BASENAME).'": '.$e->getMessage());
	}
	
	/*
	$sheet = $objPHPExcel->getSheet(0);
	echo $highestRow = $sheet->getHighestRow();
	echo $highestColumn = $sheet->getHighestColumn();
	*/
	
	$rows = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
	//var_dump2($rows);
	
	$filtre = array();
	$sql = "SELECT * FROM MARKA WHERE 1";
	$rows_marka2 = $cdbPDO->rows($sql, $filtre);
	foreach($rows_marka2 as $key => $row_marka2){
		$rows_marka[$row_marka2->MARKA]	= $row_marka2;
	}
	
	/*
	$filtre = array();
	$sql = "TRUNCATE YP_LISTE";
	$cdbPDO->rowsCount($sql, $filtre);
	*/
	
	if($row_excel->PARCA_TIPI_ID == 1){
		foreach($rows as $key => $row){
			if($key === 0) continue;
			if($key === 1) continue;
			$row_o = (object) $row;
			//echo $row->B;
			
			if(strlen(trim($row_o->A)) <= 0) break;
			/*
			if(trim($row_o->N) == "OTOKOC") $TEDARIKCI_ID = 2;
			else $TEDARIKCI_ID = 0;
			*/
			
			$filtre = array();
			$sql = "REPLACE INTO YP_LISTE SET 	MARKA_ID 			= :MARKA_ID, 
												PARCA_KODU 			= :PARCA_KODU, 
												OEM_KODU 			= :OEM_KODU, 
												REFERANS_KODU		= :REFERANS_KODU,
												PARCA_ADI			= :PARCA_ADI,
												ALIS_FIYAT			= :ALIS_FIYAT,
												SATIS_FIYAT 		= :SATIS_FIYAT, 
												PARA_BIRIM			= :PARA_BIRIM, 
												BIRIM 				= :BIRIM, 
												ADET 				= :ADET, 
												DURUM 				= :DURUM,
												PARCA_MARKA 		= :PARCA_MARKA, 
												PARCA_MARKA_ID		= :PARCA_MARKA_ID,
												BASLA_TARIH			= :BASLA_TARIH,
												BITIS_TARIH			= :BITIS_TARIH,
												TEDARIKCI_ID		= :TEDARIKCI_ID,
												STOK				= :STOK,
												KAMPANYALI			= :KAMPANYALI,
												ULKE				= :ULKE,
												ULKE_ID				= :ULKE_ID,
												PARCA_TIPI_ID		= :PARCA_TIPI_ID,
												KAYIT_YAPAN			= :KAYIT_YAPAN, 
												TARIH				= NOW(),
												UUID				= MD5(CONCAT(:TEDARIKCI_ID,:OEM_KODU,:PARCA_KODU,:REFERANS_KODU))
												";
			$filtre[":MARKA_ID"]		= $rows_marka[trim($row_o->A)]->ID;
			$filtre[":PARCA_KODU"]		= trim($row_o->B);
			$filtre[":OEM_KODU"]		= trim($row_o->C);
			$filtre[":REFERANS_KODU"]	= trim($row_o->D);
			$filtre[":PARCA_ADI"]		= trim($row_o->E);
			$filtre[":ALIS_FIYAT"]		= trim($row_o->F); //str_replace(',','.',str_replace('.','',$row_o->F));
			$filtre[":SATIS_FIYAT"]		= trim($row_o->F + ($row_o->F * ($row_excel->LISTE_KAR_ORANI / 100))); //str_replace(',','.',str_replace('.','',$row_o->F));
			$filtre[":PARA_BIRIM"]		= $row_o->G;
			$filtre[":BIRIM"]			= $row_o->H;
			$filtre[":ADET"]			= $row_o->I;
			$filtre[":DURUM"]			= $row_o->K;
			$filtre[":PARCA_MARKA"]		= "ORJINAL";
			$filtre[":PARCA_MARKA_ID"]	= 0;
			$filtre[":BASLA_TARIH"]		= FormatTarih::n2db($row_o->L);
			$filtre[":BITIS_TARIH"]		= FormatTarih::n2db($row_o->M);
			$filtre[":TEDARIKCI_ID"]	= $row_excel->TEDARIKCI_ID;
			$filtre[":STOK"]			= trim($row_o->O);
			$filtre[":KAMPANYALI"]		= trim($row_o->P);
			$filtre[":ULKE"]			= "";
			$filtre[":ULKE_ID"]			= 0;
			$filtre[":PARCA_TIPI_ID"]	= $row_excel->PARCA_TIPI_ID;
			$filtre[":KAYIT_YAPAN"]		= $_SESSION['kullanici'];
			$cdbPDO->rowsCount($sql, $filtre);
			//echo $cdbPDO->getSQL($sql, $filtre) . ";<br>";
			$row_toplam++;
		}
			
	} else {
		foreach($rows as $key => $row){
			if($key === 0) continue;
			if($key === 1) continue;
			$row_o = (object) $row;
			//echo $row->B;
			
			/*
			$filtre = array();
			$sql = "REPLACE INTO YP_LISTE SET 	MARKA_ID 			= :MARKA_ID, 
												OEM_KODU 			= :OEM_KODU, 
												PARCA_KODU 			= :PARCA_KODU, 
												PARCA_ADI			= :PARCA_ADI,
												ALIS_FIYAT			= :ALIS_FIYAT,
												SATIS_FIYAT 		= :SATIS_FIYAT, 
												BIRIM 				= :BIRIM, 
												PARCA_MARKA 		= :PARCA_MARKA, 
												PARCA_MARKA_ID		= :PARCA_MARKA_ID,
												ULKE				= :ULKE,
												ULKE_ID				= :ULKE_ID,
												PARCA_TIPI_ID		= :PARCA_TIPI_ID,
												KAYIT_YAPAN			= :KAYIT_YAPAN, 
												TARIH				= NOW(),
												UUID				= MD5(CONCAT(:TEDARIKCI_ID,:OEM_KODU,:PARCA_KODU,:REFERANS_KODU)),
												DURUM 				= 1
												";
			$filtre[":MARKA_ID"]		= $rows_marka[trim($row_o->A)]->ID;
			$filtre[":OEM_KODU"]		= trim($row_o->B);
			$filtre[":PARCA_KODU"]		= trim($row_o->C);
			$filtre[":PARCA_ADI"]		= trim($row_o->D);
			$filtre[":ALIS_FIYAT"]		= $row_o->E;
			$filtre[":SATIS_FIYAT"]		= $row_o->F;
			$filtre[":BIRIM"]			= $row_o->G;
			$filtre[":PARCA_MARKA"]		= $row_o->H;
			$filtre[":PARCA_MARKA_ID"]	= $row_o->I;
			$filtre[":ULKE"]			= $row_o->J;
			$filtre[":ULKE_ID"]			= $row_o->K;
			$filtre[":PARCA_TIPI_ID"]	= $row_excel->PARCA_TIPI_ID;
			$filtre[":KAYIT_YAPAN"]		= $_SESSION['kullanici'];
			$cdbPDO->rowsCount($sql, $filtre);
			//echo $cdbPDO->getSQL($sql, $filtre) . ";<br>";
			$row_toplam++;
			*/
		}
	}
	
	$filtre = array();
	$sql = "UPDATE EXCEL SET CALISMA_TARIH = NOW(), SAY = SAY + 1 WHERE ID = :ID";
	$filtre[":ID"]	= $row_excel->ID;
	$cdbPDO->rowsCount($sql, $filtre);
	
	echo "$row_toplam adet kayıt yapıldı.";
	
