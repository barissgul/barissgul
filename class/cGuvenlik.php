<?
/*
* Güvenlik yetki bazlı erişim sağlanması yada sağlanmaması için yaptım. Yetki16 dediğiniz e Yetkisi 16 olan kullanıcılara
*/

class Guvenlik {
	private $cdbPDO;
	private $sayfa;
	
	function __construct($cdbPDO) {
		$this->cdbPDO 	= $cdbPDO;
		$this->Temizle();
		$this->Yetki();
	}
	
	function Temizle(){
		$this->sayfa = $_SERVER['PHP_SELF'];
		
	}
	
	/*
	1	Admin
	2	Yönetici
	3	Satış Temsilcisi
	4	Müşteri
	5	Satınalma Sorumlusu
	*/
	function Yetki(){
		if($_SESSION['yetki_id'] == 4){
			$this->Yetki4();	
		}
		
	}
	
	function Yetki4() {
		$sayfalar = array();
		$sayfalar[] = '/kullanici/kullanicilar.php';
		
		//sayfa yoksa hata 
		if(in_array($this->sayfa,$sayfalar)){
			$this->Hata();
		}	
		
	}	
	
	function Hata(){
		echo "<b>Güvenlik Uyarısı:</b> Sayfa erişim hakkınız yok"; 
		die();
		
	}
	
}
