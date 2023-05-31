<?

	class Mail {
		
		private $cdbPDO;
		private $mail;
		
		function __construct($cdbPDO) {
	        $this->cdbPDO 		= $cdbPDO;
	        
		}
		
		public function curlCalistir($input_xml, $islem = ''){
	    	$headers = array('Content-type: text/xml'); 
	    	$adres = 'http://doguscam.com/01simple.php?';
	    	
			$ch = curl_init();
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        //curl_setopt($ch, CURLOPT_HEADER, 1);
	        curl_setopt($ch, CURLOPT_URL, $adres);
	        $result_xml = curl_exec($ch);
	        curl_close($ch);	        
	    	
		}
		
	    public function Gonder($kime = "", $konu = "", $icerik = "", $kimden = "", $cc = ""){
	    	
	    	if(!is_array($kime)){
	    		$kime = explode(';', str_replace(",",";",$kime));
	    	}
	    	
	    	if(!is_array($cc)){
	    		$cc = explode(';', str_replace(",",";",$cc));
	    	}
	    	
	    	$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = 'mail.otoservisci.com';
			$mail->Port = 587;
			$mail->Username = 'bilgi@otoservisci.com';
			$mail->Password = '797877aq!A';
			$mail->SetLanguage("tr");
			$mail->setFrom($mail->Username, 'TRParts');
			
			if(is_array($kime)){
		    	foreach($kime as $k => $v){
					$mail->AddAddress($v); 		
				}				
			} else {
				$mail->AddAddress($kime); 
			}
			
			if(is_array($cc)){
		    	foreach($cc as $email){
					$mail->addCC($email); 		
				}				
			} else {
				$mail->AddAddress($cc); 
			}
			
			$mail->CharSet = 'UTF-8';
			$mail->Subject = $konu;
			$mail->msgHTML($icerik);
			
			//$mail->AddAttachment("../01simple.xls", "siparis.xls"); 
			if($mail->send()) {
			    //echo 'Mail gönderildi!';
			    return TRUE;
			} else {
			    echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
			    return FALSE;
			}
	    	
	    }
	    
	    public function Gonder__($kime = "", $konu = "", $icerik = "", $kimden = "", $cc = ""){
	    	
	    	if(!is_array($kime)){
	    		$kime = explode(';', str_replace(",",";",$kime));
	    	}
	    	
	    	if(!is_array($cc)){
	    		$cc = explode(';', str_replace(",",";",$cc));
	    	}
	    	
	    	$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = 'mail.otoservisci.com';
			$mail->Port = 587;
			$mail->Username = 'bilgi@otoservisci.com';
			$mail->Password = '797877aq!A';
			$mail->SetLanguage("tr");
			$mail->setFrom($mail->Username, 'Trparts');
			
			if(is_array($kime)){
		    	foreach($kime as $k => $v){
					$mail->AddAddress($v); 		
				}				
			} else {
				$mail->AddAddress($kime); 
			}
			
			if(is_array($cc)){
		    	foreach($cc as $email){
					$mail->addCC($email); 		
				}				
			} else {
				$mail->AddAddress($cc); 
			}
			
			$mail->CharSet = 'UTF-8';
			$mail->Subject = $konu;
			$mail->msgHTML($icerik);
			
			//$mail->AddAttachment("../01simple.xls", "siparis.xls"); 
			if($mail->send()) {
			    //echo 'Mail gönderildi!';
			    return TRUE;
			} else {
			    echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
			    return FALSE;
			}
	    	
	    }
	    
	    public function Gonder2($kime, $konu, $icerik, $kimden = "", $dosya_url, $dosya_ad){
	    	
	    	$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = 'mail.tr.parts';
			$mail->Port = 587; //587
			$mail->Username = 'order@tr.parts';
			$mail->Password = 'TRparts1453.';
			$mail->SetLanguage("tr");
			$mail->setFrom($mail->Username, 'TRParts');
			
			if(is_array($kime)){
		    	foreach($kime as $k => $v){
					$mail->AddAddress($v); 		
				}				
			} else {
				$mail->AddAddress($kime); 
			}
			
			if(is_array($cc)){
		    	foreach($cc as $email){
					$mail->addCC($email); 		
				}				
			} else {
				$mail->AddAddress($cc); 
			}
			
			$mail->CharSet = 'UTF-8';
			$mail->Subject = $konu;
			$mail->msgHTML($icerik);
			
			$mail->AddAttachment($dosya_url, $dosya_ad); 
			//$mail->AddStringAttachment($dosya_url, $dosya_ad);
			
			if($mail->Send()) {
			    //echo 'Mail gönderildi!';
			    return TRUE;
			} else {
			    echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
			    return FALSE;
			}
	    	
	    	/*
	    	$mail->addReplyTo('fgul@otoanaliz.net', 'Fatih Gül');
	    	$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');
			$mail->ContentType 	= "text/html";
		    $mail->Encoding		= "base64";
		    $mail->AddStringAttachment($str, "$d", "base64", "application/octet-stream"); 
	    	*/
	    	
	    }
	    
	    public function Calisiyor(){
			echo "Çalışıyor.";
			
		}
	    
	}

	/*
	$cMail->Gonder($kime, $konu, $icerik, $kimden);
    mail($kime, $konu, $icerik,"From:HATA - $adres<optimumhata@otoanaliz.net>\nMIME-Version: 1.0\nContent-Type: text/plain; charset=iso-8859-9\n") ;
    
    */
?>