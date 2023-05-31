<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	ini_set('max_execution_time', 300);

	$ID = 7;
	echo date("Y-m-d H:i:s").__LINE__."<br>";
	$filtre	= array();
	$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
	$filtre[":ID"] 	= $ID;
	$row = $cdbPDO->row($sql, $filtre); 
	
	$filtre	= array();
	$sql = "SELECT * FROM CARI WHERE ID = :ID";
	$filtre[":ID"] 	= $row->CARI_ID;
	$row_cari = $cdbPDO->row($sql, $filtre); 
	
	$filtre	= array();
	$sql = "SELECT * FROM KULLANICI WHERE ID = :ID";
	$filtre[":ID"] 	= $row_cari->TEMSILCI_ID;
	$row_temsilci = $cdbPDO->row($sql, $filtre); 
	
	$filtre	= array();
	$sql = "SELECT * FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID ORDER BY SIRA ASC";
	$filtre[":CARI_HAREKET_ID"] 	= $row->ID;
	$rows_detay = $cdbPDO->rows($sql, $filtre); 
	
	
	$Alfabe = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
   
  	$objPHPExcel = new PHPExcel();
  	
	$objPHPExcel->getProperties()->setCreator("TRPARTS")
								 ->setLastModifiedBy("TRPARTS");
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('Sayfa1');	  
	
	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1')->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1')->getStyle('A1:G1')->getFont()->setSize(22)->setBold(true);
	$objPHPExcel->getActiveSheet()->mergeCells('A2:B2')->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->mergeCells('C2:G2')->getStyle('C2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->mergeCells('A3:B3')->getStyle('A3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->mergeCells('C3:G3')->getStyle('C3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->mergeCells('A4:B4')->getStyle('A4:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->mergeCells('C4:G4')->getStyle('C4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->mergeCells('A5:B5')->getStyle('A4:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->mergeCells('C5:G5')->getStyle('C4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->mergeCells('A10:G10')->getStyle('A10:G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->mergeCells('A10:G10')->getStyle('A10:G10')->getFont()->setSize(16);
	$objPHPExcel->getActiveSheet()->mergeCells('A10:G10')->getStyle('A10:G10')->getFont()->setSize(22)->setBold(true);
	
	$objPHPExcel->getActiveSheet()->setCellValue("A1", "Sipariş Listesi");
	$objPHPExcel->getActiveSheet()->setCellValue("A2", "Sipariş No :");
	$objPHPExcel->getActiveSheet()->setCellValue("C2", $row->ID);
	$objPHPExcel->getActiveSheet()->setCellValue("A3", "Cari :");	
	$objPHPExcel->getActiveSheet()->setCellValue("C3", $row_cari->CARI);
	$objPHPExcel->getActiveSheet()->setCellValue("A4", "Sipariş Tarih :");
	$objPHPExcel->getActiveSheet()->setCellValue("C4", $row->TARIH);
	$objPHPExcel->getActiveSheet()->setCellValue("A5", "Temsilci :");
	$objPHPExcel->getActiveSheet()->setCellValue("C5", $row_temsilci->UNVAN);
	
	$objPHPExcel->getActiveSheet()->setCellValue("A10", "Parça Listesi");
	$objPHPExcel->getActiveSheet()->setCellValue("A11", "#");
	$objPHPExcel->getActiveSheet()->setCellValue("B11", "Parça Kodu");
	$objPHPExcel->getActiveSheet()->setCellValue("C11", "Oem Kodu");
	$objPHPExcel->getActiveSheet()->setCellValue("D11", "Parça Adı");
	$objPHPExcel->getActiveSheet()->setCellValue("E11", "Fiyat");
	$objPHPExcel->getActiveSheet()->setCellValue("F11", "Adet");
	$objPHPExcel->getActiveSheet()->setCellValue("G11", "Tutar");
	
	foreach($rows_detay as $key => $row_detay){
		$objPHPExcel->getActiveSheet()->setCellValue("A".($key+12), $row_detay->SIRA );	
		$objPHPExcel->getActiveSheet()->setCellValue("B".($key+12), $row_detay->PARCA_KODU );	
		$objPHPExcel->getActiveSheet()->setCellValue("C".($key+12), $row_detay->OEM_KODU );	
		$objPHPExcel->getActiveSheet()->setCellValue("D".($key+12), $row_detay->PARCA_ADI );	
		$objPHPExcel->getActiveSheet()->setCellValue("E".($key+12), FormatSayi::nokta2($row_detay->FIYAT) );	
		$objPHPExcel->getActiveSheet()->setCellValue("F".($key+12), $row_detay->ADET );	
		$objPHPExcel->getActiveSheet()->setCellValue("G".($key+12), FormatSayi::nokta2($row_detay->TUTAR) );	
	}
	//echo date("Y-m-d H:i:s").__LINE__."<br>";
	// Redirect output to a client’s web browser (Excel5)
	/*
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename=Siparis{$row->ID}.xlsx");
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter->save("/talep/Siparis{$row->ID}.xlsx");
	*/
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save(str_replace(__FILE__,$_SERVER['DOCUMENT_ROOT'] ."/musteri/Siparis{$row->ID}.xlsx",__FILE__));		
	//echo date("Y-m-d H:i:s").__LINE__."<br>";
	//var_dump2("https://order.tr.parts/musteri/Siparis{$row->ID}.xlsx");
	//var_dump2($_SERVER['DOCUMENT_ROOT'] . '/musteri/Siparis{$row->ID}.xlsx');
	
	//$sonuc = $cMail->Gonder2("info@boryaz.com", "Sipariş", "Sipariş Oluşturuldu","", $_SERVER['DOCUMENT_ROOT'] . "/musteri/Siparis{$row->ID}.xlsx", "Siparis{$row->ID}.xlsx");
	
	echo date("Y-m-d H:i:s").__LINE__."<br>";
	