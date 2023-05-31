<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	error_reporting(1);
	ini_set('max_execution_time', 300);
	//ini_set('memory_limit', '-1');
	
	$Alfabe = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	
	$excel_adi = $_REQUEST['EXCEL_YOL'];
	$excel_tur = $_REQUEST['TUR'];
	
	if(strlen($excel_adi) < 10 OR !in_array($excel_tur,array('ARAC_DEGER_LISTESI'))){
		echo "Dosya Adı: $excel_adi, Dosya türü: $excel_tur <br> izin verimeyen dosya yazma!";
		die();
	}
	
	die("Durduruldu!");
	
	$excel_adi = $_SERVER['DOCUMENT_ROOT'] . "/img/excel/". $excel_adi;
	
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
	
	$rows_excel = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
	//var_dump2($rows_excel);
	
	foreach($rows_excel as $key => $row_excel){
		if($key === 0) continue;
		if($key === 1) continue;
		$row = (object) $row_excel;
		//echo $row->B;
		$filtre = array();
		$sql = "INSERT INTO ARAC_DEGER_LISTESI SET 	AB_MARKA_KODU 	= :AB_MARKA_KODU, 
													AB_TIP_KODU 	= :AB_TIP_KODU, 
													MARKA 			= TRIM(:MARKA), 
													MODEL 			= TRIM(:MODEL), 
													Y2018 			= :Y2018, 
													Y2017 			= :Y2017, 
													Y2016 			= :Y2016,
													Y2015 			= :Y2015,
													Y2014 			= :Y2014,
													Y2013 			= :Y2013,
													Y2012 			= :Y2012,
													Y2011 			= :Y2011,
													Y2010 			= :Y2010,
													Y2009 			= :Y2009,
													Y2008 			= :Y2008,
													Y2007 			= :Y2007,
													Y2006 			= :Y2006,
													Y2005 			= :Y2005, 
													Y2004 			= :Y2004
													";
		$filtre[":AB_MARKA_KODU"]	= $row->A;
		$filtre[":AB_TIP_KODU"]		= $row->B;
		$filtre[":MARKA"]			= $row->C;
		$filtre[":MODEL"]			= $row->D;
		$filtre[":Y2018"]			= $row->E;
		$filtre[":Y2017"]			= $row->F;
		$filtre[":Y2016"]			= $row->G;
		$filtre[":Y2015"]			= $row->H;
		$filtre[":Y2014"]			= $row->I;
		$filtre[":Y2013"]			= $row->J;
		$filtre[":Y2012"]			= $row->K;
		$filtre[":Y2011"]			= $row->L;
		$filtre[":Y2010"]			= $row->M;
		$filtre[":Y2009"]			= $row->N;
		$filtre[":Y2008"]			= $row->O;
		$filtre[":Y2007"]			= $row->P;
		$filtre[":Y2006"]			= $row->Q;
		$filtre[":Y2005"]			= $row->R;
		$filtre[":Y2004"]			= $row->S;
		echo $cdbPDO->getSQL($sql, $filtre) . ";<br>";
		//$cdbPDO->rowsCount($sql, $filtre);
	}
	
