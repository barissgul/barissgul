<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	ini_set('max_execution_time', 300);
	// file_get_contents("http://trparts.bor.com/finans/popup_fatura.do?route=finans/popup_fatura&id=7&kod=9b6388a75a8cd643afdc2eac624cfcc4")
	$table = file_get_contents("http://trparts.bor.com/finans/popup_fatura.do?route=finans/popup_fatura&id=7&kod=9b6388a75a8cd643afdc2eac624cfcc4");
	
	$tmpfile = tempnam(sys_get_temp_dir(), 'html');
	file_put_contents($tmpfile, $table);

	// insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
	$objPHPExcel     = new PHPExcel();
	$excelHTMLReader = PHPExcel_IOFactory::createReader('HTML');
	$excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);
	$objPHPExcel->getActiveSheet()->setTitle('any name you want'); // Change sheet's title if you want

	unlink($tmpfile); // delete temporary file because it isn't needed anymore

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
	header('Content-Disposition: attachment;filename=deneme.xlsx'); // specify the download file name
	header('Cache-Control: max-age=0');

	// Creates a writer to output the $objPHPExcel's content
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save(str_replace(__FILE__,$_SERVER['DOCUMENT_ROOT'] ."/musteri/Siparis.xlsx",__FILE__));		

	echo date("Y-m-d H:i:s").__LINE__."<br>";
	