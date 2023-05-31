<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	ini_set('max_execution_time', 300);

	//$sonuc = $cMail->Gonder("info@boryaz.com", "Sipariş", "Sipariş Oluşturuldu");
	
	//var_dump2($sonuc);
	
	$rows_stock = json_decode(file_get_contents("https://kokpit.dinamik.online:8181/operation/getStockList?api_username=$USERNAME&api_password=$PASSWORD&api_marka=ATIK"));
	var_dump2($rows_stock);