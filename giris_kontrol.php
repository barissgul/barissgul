<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	
	if(!empty($_REQUEST["kullanici"]) AND strlen($_REQUEST["kod"]) > 30){
		$filtre = array();
		$sql = "SELECT 
					K.ID,
					K.KULLANICI,
					K.SIFRE
				FROM KULLANICI AS K
				WHERE K.KULLANICI = :KULLANICI AND K.KOD = :KOD";
		$filtre[":KULLANICI"]	= $_REQUEST["kullanici"];
		$filtre[":KOD"]			= $_REQUEST["kod"];
		$row = $cdbPDO->row($sql, $filtre);
		
		if($row->ID > 0){
			$_REQUEST['kullanici'] 	= $row->KULLANICI;
			$_REQUEST['sifre'] 		= $row->SIFRE;
			$_POST					= $_REQUEST;
			$_REQUEST["oto_login"] 	= 1;
		}
	}
	
	if(empty($_POST)){
		$sonuc = array();
		$sonuc["HATA"] 			= TRUE;
		$sonuc["ACIKLAMA"] 		= "Hata!";
		echo json_encode($sonuc); die();
	}
	
	if(!isset($_REQUEST['kullanici']) OR !isset($_REQUEST['sifre'])){
		$sonuc = array();
		$sonuc["HATA"] 			= TRUE;
		$sonuc["ACIKLAMA"] 		= "Kullanıcı Bilgileri Eksik!";
		echo json_encode($sonuc); die();
	}
	
	if(FALSE){
		$sonuc = array();
		$sonuc["HATA"] 			= TRUE;
		$sonuc["ACIKLAMA"] 		= "Hata!";
		sleep(3);
		echo json_encode($sonuc); die();
	}
	
	// Server ip ve domain kontrolü
	if(!(($_SERVER['SERVER_NAME'] == "auto.com" AND $_SERVER['SERVER_ADDR'] == "127.0.0.1")
		OR ($_SERVER['SERVER_NAME'] == "b2b.boryaz.com" AND $_SERVER['SERVER_ADDR'] == "104.247.161.117")
		
		)){
		$sonuc = array();
		$sonuc["HATA"] 			= TRUE;
		$sonuc["ACIKLAMA"] 		= "Yasak Giriş!". $_SERVER['SERVER_ADDR'];
		sleep(3);
		echo json_encode($sonuc); die();
	}
	
	@session_start();
	$kullanici		= mb_strtoupper($_REQUEST["kullanici"]);
	$sifre	 		= $_REQUEST["sifre"];
	$session_id		= session_id();
	session_regenerate_id(true);
	$ip				= $_SERVER['REMOTE_ADDR'];
	
	$row_ip = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

	$filtre = array();
	$sql = "INSERT INTO KULLANICI_LOG SET KULLANICI = :KULLANICI, SIFRE = :SIFRE, SESSION_ID = :SESSION_ID, IP = :IP, KIMLIK = :KIMLIK, DIL = :DIL, ULKE = :ULKE, IL = :IL";
	$filtre[":KULLANICI"]	= $kullanici;
	$filtre[":SIFRE"]		= $sifre;
	$filtre[":SESSION_ID"]	= $session_id;
	$filtre[":IP"]			= $ip;
	$filtre[":KIMLIK"]		= $_SERVER['HTTP_USER_AGENT'];
	$filtre[":DIL"]			= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$filtre[":ULKE"]		= $row_ip->country; //geoip_country_name_by_name($ip);
	$filtre[":IL"]			= $row_ip->city;
	$log_id = $cdbPDO->lastInsertId($sql, $filtre);
	
	if ($log_id > 0) { 
		$filtre = array();
		$sql = "SELECT 
					K.*,
					Y.HIZMET_NOKTASI
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
				WHERE K.DURUM = 1 AND K.KULLANICI = :KULLANICI AND (K.SIFRE = :SIFRE OR K.SIFRE2 = :SIFRE)";
		$filtre[":KULLANICI"]	= $kullanici;
		$filtre[":SIFRE"]		= $sifre;
		$row = $cdbPDO->row($sql, $filtre);
		
		if($row->ID > 0 ){
			$_SESSION["kullanici_id"] 		= $row->ID;
			$_SESSION["kullanici"] 			= $row->KULLANICI;
			$_SESSION["sifre"] 				= md5($row->SIFRE);
			$_SESSION["kullanici_adsoyad"]	= $row->AD . " " . $row->SOYAD;
			$_SESSION["yetki_id"]			= $row->YETKI_ID;
			$_SESSION["cari_id"]			= $row->CARI_ID;
			$_SESSION["hizmet_noktasi"]		= $row->HIZMET_NOKTASI;
			$_SESSION["ozel_kod1"]			= $row->OZEL_KOD1;
			$_SESSION["ozel_kod2"]			= $row->OZEL_KOD2;
			$_SESSION["ozel_kod3"]			= $row->OZEL_KOD3;
			$_SESSION["ozel_kod4"]			= $row->OZEL_KOD4;
			$_SESSION["domain"]				= $_SERVER['SERVER_NAME'];
			$_SESSION["session_kontrol"]	= md5($_SESSION["kullanici_id"].$_SESSION["yetki_id"].$_SESSION["domain"]);
			$_SESSION["menu_tarih"]			= date("Y-m-d H:i:s");
			$_SESSION["session_tarih"]		= date("Y-m-d H:i:s");
			if($_REQUEST["hatirla"] == 1){
				setcookie("0205kullanici", $row->KULLANICI, time() + (60*60*24*7));
				setcookie("0205sifre", $row->SIFRE, time() + (60*60*24*7));
			} else{
				setcookie("0205kullanici", "", time() + 1);
				setcookie("0205sifre", "", time() + 1);
			}
			setcookie("menu", 1);
			setcookie("dil", "TR");
			
			$filtre = array();
			$sql = "UPDATE KULLANICI SET GTARIH = NOW() WHERE ID = :ID";
			$filtre[":ID"]		= $_SESSION["kullanici_id"];
			$cdbPDO->rowsCount($sql, $filtre);
			
			$filtre = array();
			$sql = "SELECT ID, TR, ENG, RUS FROM DIL WHERE 1";
			$rows_dil = $cdbPDO->rows($sql, $filtre);
			foreach($rows_dil as $key => $row_dil){
				$_SESSION["ENG"][$row_dil->TR]	= $row_dil->ENG;
				$_SESSION["RUS"][$row_dil->TR]	= $row_dil->RUS;
			}
			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Giriş Yapıldı.";
			
			if($_REQUEST["oto_login"] == 1){
				$sonuc["URL"] 		= "/index.do";
				?><script>location.href = '/index.do';</script><?
				die();
			} else if($_REQUEST['sayfa_url']){
				$sonuc["URL"] 		= $_REQUEST['sayfa_url'];
			} else {
				$sonuc["URL"] 		= "/index.do";
			}
			
			echo json_encode($sonuc);
			
		} else {
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı Bilgileri Hatalı!";
			echo json_encode($sonuc);
			
		}
		
		$filtre = array();
		$sql = "UPDATE KULLANICI_LOG SET DURUM = :DURUM WHERE ID = :ID";
		$filtre[":DURUM"]	= ($sonuc["HATA"]) ? 0 : 1;;
		$filtre[":ID"]		= $log_id;
		$cdbPDO->rowsCount($sql, $filtre);
		
		
		$_SESSION['log_id'] = $log_id;
	
	} else {
		$sonuc["HATA"] 		= TRUE;
		$sonuc["ACIKLAMA"] 	= "DB erişim yok!";
		echo json_encode($sonuc);
		
	}
?>