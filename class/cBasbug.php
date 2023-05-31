<?

	class Basbug {		
		private $cdbPDO;
		private $cMail;
		public $Token;
		
		function __construct($cdbPDO, $cMail) {
			$this->cdbPDO 	= $cdbPDO;
			$this->cMail	= $cMail;
		}
		
		function fncBaglan(){
			$options = array(
				'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
				'style'=>SOAP_RPC,
				'use'=>SOAP_ENCODED,
				'soap_version'=>SOAP_1_1,
				'cache_wsdl'=>WSDL_CACHE_NONE,
				'connection_timeout'=>60,
				'trace'=>true,
				'encoding'=>'UTF-8',
				'exceptions'=>true,
			);
			
			$this->client 	= new SoapClient("http://servis.basbug.com.tr/api/B2B/Giris", $options);
			
		}
		
		function fncFonksiyonlar(){
			$this->fncBaglan();
			return $this->client->__getFunctions(); 
		}
		
		function fncFonksiyonDetaylar(){
			$this->fncBaglan();
			return $this->client->__getTypes();
		}
		
		function fncGiris($KULLANICI, $SIFRE){
			$post["KullaniciAd"]	= $KULLANICI;
			$post["Sifre"]			= $SIFRE;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://servis.basbug.com.tr/api/B2B/Giris");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Content-Length: ' . strlen(json_encode($post))));
			$result = curl_exec($ch);
			curl_close($ch);
			
			$sonuc = json_decode($result);
			
			if($sonuc->Durum == true){
				$this->Token = $sonuc->Data->Token;
			}
		  	return $sonuc;
		  	
		}
	    
	    function fncMalzemeAra($post){
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://servis.basbug.com.tr/api/Malzeme/MalzemeAra");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Content-Length: ' . strlen(json_encode($post)), "Token:".$this->Token));
			$result = curl_exec($ch);
			curl_close($ch);
			
			$sonuc = json_decode($result);
			
		  	return $sonuc;
		  	
		}
		
		function fncFiyatGetir($post){
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://servis.basbug.com.tr/api/Malzeme/FiyatGetir");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Content-Length: ' . strlen(json_encode($post)), "Token:".$this->Token));
			$result = curl_exec($ch);
			curl_close($ch);
			
			$sonuc = json_decode($result);
			
		  	return $sonuc;
		  	
		}
		
		function fncMalzemeleriGetir($post){
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://servis.basbug.com.tr/api/Malzeme/MalzemeleriGetir");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Content-Length: ' . strlen(json_encode($post)), "Token:".$this->Token));
			$result = curl_exec($ch);
			curl_close($ch);
			
			$sonuc = json_decode($result);
			
		  	return $sonuc;
		  	
		}
		
		function fncStokGetir($post){
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://servis.basbug.com.tr/api/Malzeme/StokGetir");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Content-Length: ' . strlen(json_encode($post)), "Token:".$this->Token));
			$result = curl_exec($ch);
			curl_close($ch);
			
			$sonuc = json_decode($result);
			
		  	return $sonuc;
		  	
		}
		
		
		function fncDovizBilgisiGetir($post){
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://servis.basbug.com.tr/api/Malzeme/DovizBilgisiGetir");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type:application/json','Content-Length: ' . strlen(json_encode($post)), "Token:".$this->Token));
			$result = curl_exec($ch);
			curl_close($ch);
			
			$sonuc = json_decode($result);
			
		  	return $sonuc;
		  	
		}
		
	}

?>