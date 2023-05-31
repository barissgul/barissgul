<?
   	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');   
   	//session_kontrol();
   	ini_set('max_execution_time', 3000);
	ini_set("memory_limit", "-1");
   	$Alfabe = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
       
  	$objPHPExcel = new PHPExcel();
  	
	$objPHPExcel->getProperties()->setCreator("GülYazılım Pert")
								 ->setLastModifiedBy("GülYazılım Pert");
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('Sayfa1');	  
	
    $Table 			= $_SESSION["Table"];
    $Excel 			= $Table["excel"];
    $ExcelDosyaAdi	= $Table["excelDosyaAdi"];
	$sql 			= $Table["sqls"];
	
	if(!empty($Table["sqls"])) {
		$rows = $cdbPDO->rows($sql);
	}
	
    
	
	//var_dump( $Table["excelSayfasi"] );	
	//Excel Başlıkların yazılması
	for($i = 1; $i <= Count($Excel); $i++){
		$objPHPExcel->getActiveSheet()->setCellValue($Alfabe[$i]."1", $Excel[$i-1]->Baslik );
	}
	
	// Excel satırların teker teker yazılması
	$j = 1;
	foreach($rows as $key=>$row) {
		$j++;
		for($i = 1; $i <= Count($Excel); $i++){
			$Kolon = $Excel[$i-1]->Kolon;			
			if($Kolon == 'SIRA'){
				$Hucre = $j - 1;
			} else {
				$Hucre = $row->$Kolon;
			}
			
			if($Excel[$i-1]->VeriTipi == "format1"){
				$Hucre = FormatTarih::tarih($Hucre);
			}
			
			if($Excel[$i-1]->VeriTipi == "Bakiye"){
				$BAKIYE += $row->BORC + $row->ALACAK;
				$Hucre = $BAKIYE;
			}
			
			if($Excel[$i-1]->VeriTipi == "FormatSayi::virgul2"){
				$Hucre = FormatSayi::virgul2($Hucre);
			}
			
			if($Excel[$i-1]->VeriTipi == "FormatSayi::nokta2"){
				$Hucre = FormatSayi::nokta2($Hucre);
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue($Alfabe[$i].$j, $Hucre );
			
		}
		
	}
		
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename=$ExcelDosyaAdi.xls");
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');   	
 
 ?>
