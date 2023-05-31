<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	//session_kontrol();
	
	$files = glob($_SERVER['DOCUMENT_ROOT'] . '/cron/*.{sql}', GLOB_BRACE);
	foreach($files as $key=> $file) {
		$tarih = date("Y-m-d", strtotime("-4 day"));
	  	//echo $key . ". " . $file . "<br>";
	  	if(strpos($file, $tarih) !== false){
		  	unlink($file);
		}
	}
		
	$filtre = array();
	$sql = "SELECT GROUP_CONCAT(TABLE_NAME) AS TABLE_NAME FROM information_schema.tables WHERE TABLE_SCHEMA IN('otoservisci_pasha') AND TABLE_NAME NOT IN('ISLEM_LOG')";
	$row = $cdbPDO->row($sql, $filtre);
	
	EXPORT_DATABASE(HOST, USR, PSW, DB, explode(',',$row->TABLE_NAME), FALSE, FALSE);
	
	
	
	
	//IMPORT_TABLES(HOST, USR, PSW, DB, "MARINA___(16-33-56_10-11-2018).sql");