<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	if($_REQUEST['hareket_id'] == 1){
		$fatura = $cUyumsoft->fncGidenFaturaGoster($_REQUEST['uuid']);
		//var_dump2($fatura);
		header('Content-type: application/pdf');
		header('Content-disposition: filename="'. $_REQUEST['fatura_no'] .'.pdf"');

		//header('Content-Disposition: attachment; filename="service.pdf"');
		echo ($fatura);	
		
	} else if($_REQUEST['hareket_id'] == "2"){
		$fatura = $cUyumsoft->fncGelenFaturaGoster($_REQUEST['uuid']);
		//var_dump2($fatura);
		header('Content-type: application/pdf');
		header('Content-disposition: filename="'. $_REQUEST['fatura_no'] .'.pdf"');
		//header('Content-Disposition: attachment; filename="service.pdf"');
		echo ($fatura);
		
	}
	
	
	