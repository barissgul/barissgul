<?
   	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');   
   	$Alfabe = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
    
    if($_REQUEST["tablo"] == "fatura"){
		$row			= $cSubData->getFaturaXml($_REQUEST);	
		$DOSYA_ADI = $row->FATURA_NO;
	} else if($_REQUEST["tablo"] == "odeme"){
		$row			= $cSubData->getOdemeXml($_REQUEST);
		$DOSYA_ADI = $row->ODEME_KODU;
	}
	
 	header('Content-Type: application/xml; charset=utf-8');
    header("Content-Disposition: attachment;filename=$DOSYA_ADI.xml");
 	echo $row->XML;
 	
 ?>
