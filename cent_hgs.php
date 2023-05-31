<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	ini_set('max_execution_time', 300);

	
	$rows_firma = $cHgs->firmalar();
	var_dump2($rows_firma);die();
	
	foreach($rows_firma as $key => $row_firma){
		//$rows_daboard[] = $cHgs->dashboard(array("firm_id"=>$row_firma->id));
		//$rows_daboard[] = $cHgs->araclar(array("firm_id"=>$row_firma->id, "limit"=>100));
		$rows_daboard[] = $cHgs->gecisler(array("firm_id"=>$row_firma->id, "start_date"=>date("Y-m-d", strtotime("-1 day")), "end_date"=>date("Y-m-d"),"limit"=>100 ));	
	}
	
	
	
	
	var_dump2($rows_daboard);