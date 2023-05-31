<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	ini_set('max_execution_time', 300);

	
	function fncCurl($url, $postFields, $strCookie, $header = ""){
	   	$post 	= http_build_query($postFields, '=', '&');
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSLVERSION, 1);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_COOKIE, $strCookie );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
	
	
	$rows		= fncCurl("https://www.sahibinden.com/kategori/otomobil", $sendFields, "");
	
	var_dump2($rows);
	