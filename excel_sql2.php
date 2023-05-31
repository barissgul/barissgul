<?
   	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');   
   	$Alfabe = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
       
  	$objPHPExcel = new PHPExcel();
  	
	$objPHPExcel->getProperties()->setCreator("DogusCam")
								 ->setLastModifiedBy("DogusCam");
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('Sayfa1');	  
	
    $Table 			= $_SESSION["Table"];
    $Excel 			= $Table["excel"];
    $ExcelDosyaAdi	= $Table["excelDosyaAdi"];
	$sql 			= $Table["sqls"];
	
    $rows = $cdbPDO->rows($sql, array());
	
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
			$objPHPExcel->getActiveSheet()->setCellValue($Alfabe[$i].$j, $row->$Kolon );
		}
		
	}
		
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');   	
 
 ?>
