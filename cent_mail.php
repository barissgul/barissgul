<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	ini_set('max_execution_time', 300);

	
	$sonuc = $cMail->Gonder("info@boryaz.com",'SLM', 'Merhaba');
	var_dump2($sonuc);