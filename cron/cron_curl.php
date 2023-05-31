<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	ini_set('max_execution_time', 300);
	
	/*
	$url	= "http://localhost:11286/api/depoes/getAll"; 
	//$post	= "{}";
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	curl_close($ch);
	
	var_dump2($result);
	//$result = json_decode($result);
	*/
	
	
	
	$url	= "http://localhost:11286/api/depoes/update"; 
	$post	= '{"Id":29,"Durum":1,"OzelGrupId1":1,"DepoKodu":"yeni","Adi":"update depo","Aciklama":"burası updte alanıdır","Varsayilan":1}';
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(json_decode($post)));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	curl_close($ch);
	
	var_dump2($result);
	//$result = json_decode($result)
	
		