<?

	class Sms {
		private $cdbPDO;
		private $cMail;
		private $username;
		private $password;
		
		function __construct($cdbPDO, $cMail) {
			$this->cdbPDO 	= $cdbPDO;
			$this->cMail	= $cMail;
			
			$this->username		= "8503054235";
			$this->password		= "N1-R1KN6";
			$this->company		= "GULYAZ.";
			$this->encoding		= "TR";
		}
		
		private function fncSonuc($result){
			
			if($result->return > 1230){
				$sonuc->hata	 	= 0;
				$sonuc->aciklama	= "Başarılı.";
				
			} else if($result->return == 1000){
				$sonuc->hata	 	= 0;
				$sonuc->aciklama	= "Başarılı. (Zamanlı)";	
				
			} else if($result->return == 20){
				$sonuc->hata		= 20;
				$sonuc->aciklama	= "Mesaj metninde ki problemden dolayı gönderilemediğini veya standart maksimum mesaj karakter sayısını geçtiğini ifade eder.";	
				
			} else if($result->return == 30){
				$sonuc->hata 		= 30;
				$sonuc->aciklama	= "Geçersiz kullanıcı adı , şifre veya kullanıcınızın API erişim izninin olmadığını gösterir.";	
				
			} else if($result->return == 40){
				$sonuc->hata_kodu 	= 40;
				$sonuc->hata		= "Mesaj başlığınızın (gönderici adınızın) sistemde tanımlı olmadığını ifade eder. Gönderici adlarınızı API ile sorgulayarak kontrol edebilirsiniz.";	
				
			} else if($result->return == 70){
				$sonuc->hata_kodu 	= 70;
				$sonuc->hata		= "Hatalı sorgulama. Gönderdiğiniz parametrelerden birisi hatalı veya zorunlu alanlardan birinin eksik olduğunu ifade eder.";	
				
			} else if($result->return == 80){
				$sonuc->hata_kodu 	= 80;
				$sonuc->hata		= "Gönderim sınır aşımı.";
				
			} else if($result->return == 100 OR $result->return == 101){
				$sonuc->hata_kodu 	= 80;
				$sonuc->hata		= "Gönderim sınır aşımı.";	
				
			}
			
			return $sonuc;
			
		}
		
		public function soapGonder($tel, $baslik, $mesaj){
			
			try {
			 	$client = new SoapClient("http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl");
				$parametre["username"]	= $this->username;
				$parametre["password"] 	= $this->password;
				$parametre["company"] 	= $this->company;
				$parametre["gsm"] 		= $tel;
				$parametre["header"] 	= $baslik;
				$parametre["msg"] 		= $mesaj;
				$parametre["encoding"] 	= $this->encoding;
				$parametre["startdate"] = date('dmYHi');
				$parametre["stopdate"] 	= date('dmYHi', strtotime('+1 day'));
				$result = $client->sms_gonder_1n($parametre);
			  
			} catch (Exception $exc) { 
			  	echo "Soap Hatasi Olustu: " . $exc->getMessage();
			}
			
			$sonuc = self::fncSonuc($result);
			
			return $sonuc;
			
		}
		
		public function soapBakiye(){
			try {
			 	$client = new SoapClient("http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl");
				$parametre["username"]	= $this->username;
				$parametre["password"] 	= $this->password;
				$result = $client->kredi($parametre);
			  
			} catch (Exception $exc) { 
			  	echo "Soap Hatasi Olustu: " . $exc->getMessage();
			}
			
			$sonuc = self::fncSonuc($result);
			
			return $sonuc;
			
		}
		
		public function apiGonder($tel, $baslik, $mesaj){
	  		
	  		$mesaj 		= rawurlencode(html_entity_decode($mesaj, ENT_COMPAT, "UTF-8")); 
			$baslik 	= rawurlencode(html_entity_decode($baslik, ENT_COMPAT, "UTF-8")); 
			
			$postFields = array();
			$postFields["usercode"] = $this->username; 
			$postFields["password"] = $this->password; 
			$postFields["company"] 	= $this->company;
			$postFields["gsmno"] 	= $tel; 
			$postFields["msgheader"]= $baslik; 
			$postFields["message"] 	= $mesaj; 
			$postFields["startdate"]= $this->startdate; 
			$postFields["stopdate"] = $this->stopdate;
			$post = http_build_query($postFields, '=', '&');
			
			echo $url;
	    	
		    $ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_URL, "http://api.netgsm.com.tr/bulkhttppost.asp");
			curl_setopt($ch, CURLOPT_SSLVERSION, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		    curl_setopt($ch, CURLOPT_POST, 0);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    $result = curl_exec($ch);
		    curl_close($ch);
		    
		    return $result;
		    
		}
		
		public function soapTumFonksiyonlar() {
			$client = new SoapClient("http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl");
			
			echo "Karsi sunucudaki kullanilabilir metodlar:<br/>";
			$allMethods = $client->__getFunctions();
			var_dump2($allMethods);
			  	
			echo "Karsi sunucudaki kullanilabilir Alanları:<br/>";
			$allTypes = $client->__getTypes();
			var_dump2($allTypes);
			
		}
		
	}
	