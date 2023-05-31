<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/asset/PhpSpreadSheet-master/AnyFolder/PhpOffice/autoload.php');
	// PhpOffice\PhpSpreadsheet\IOFactory
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL); //E_ERROR | E_WARNING
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
	    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load($excel_adi);
	} catch(Exception $e) {
	    die('Dosya Çalıştırma Hatası: "'.pathinfo($excel_adi,PATHINFO_BASENAME).'": '.$e->getMessage());
	}
	
	/*
	$sheet = $objPHPExcel->getSheet(0);
	echo $highestRow = $sheet->getHighestRow();
	echo $highestColumn = $sheet->getHighestColumn();
	*/
	
	$rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
	
	$filtre = array();
	$sql = "SELECT * FROM MARKA WHERE 1";
	$rows_marka2 = $cdbPDO->rows($sql, $filtre);
	foreach($rows_marka2 as $key => $row_marka2){
		$rows_marka[$row_marka2->MARKA]	= $row_marka2;
	}
	
	$filtre = array();
	$sql = "TRUNCATE YP_LISTE";
	$cdbPDO->rowsCount($sql, $filtre);
	
	foreach($rows as $key => $row){
		if($key === 0) continue;
		if($key === 1) continue;
		$row_o = (object) $row;
		//echo $row->B;
		$filtre = array();
		$sql = "INSERT INTO YP_LISTE SET 	MARKA_ID 			= :MARKA_ID, 
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
											KAYIT_YAPAN			= :KAYIT_YAPAN, 
											TARIH				= NOW(),
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
		$filtre[":KAYIT_YAPAN"]		= $_SESSION['kullanici'];
		$cdbPDO->rowsCount($sql, $filtre);
		//echo $cdbPDO->getSQL($sql, $filtre) . ";<br>";
	}
	
	$filtre = array();
	$sql = "UPDATE EXCEL SET CALISMA_TARIH = NOW(), SAY = SAY + 1 WHERE ID = :ID";
	$filtre[":ID"]	= $row_excel->ID;
	$cdbPDO->rowsCount($sql, $filtre);
	
	echo "Kayıt Yapıldı.";
	
