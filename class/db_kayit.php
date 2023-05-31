<?
################################################	
# 			db Kayit - Database Insert-Update-Delete				#
# 				ConquerorRose - rosesoft						#
#				Fatih Gül - 16.01.2013						#
# 		phpbaris.com - rosesoft.wordpress.com						#
# 	En alt kısımda örnek function olarak oluşturuldu.					#
################################################

	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	
	//echo var_dump($_POST['adet']); die();
		
	if(isset($_REQUEST["islem"])) {
		$sonuc 	= array();
		$islem 	= $_REQUEST["islem"];
		
	} else { 
		$sonuc["HATA"] 		= TRUE;
		$sonuc["ACIKLAMA"] 	= "Giriş Yasak.".$_REQUEST["islem"];
		echo json_encode($sonuc); die();
		
	}
	
	if(!in_array($islem, array('kullanici_ekle'))) {
		if(!$_SESSION['kullanici_id']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Üye olmalısınız!";
			echo json_encode($sonuc); die();
		}
	}
	
	if(!method_exists($cKayit, $islem)) {
		$sonuc["HATA"] 		= TRUE;
		$sonuc["ACIKLAMA"] 	= "Fonksiyon bulunamadı.";
		echo json_encode($sonuc); die();
	}
	
	$sonuc = $cKayit->{$islem}();
	
	echo json_encode($sonuc); die();
	
?>