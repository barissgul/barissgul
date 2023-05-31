<?
	//header('Content-Type: text/html; charset=utf-8');
	class Entegrasyon {
		public $Istemci;
		public $sonuc; 
		public $cdbPDO;
		public $cSubData;
		
		function __construct($cdbPDO_UTF8, $cMail, $cSubData) {
			$this->cdbPDO 		= $cdbPDO_UTF8;
			$this->cMail 		= $cMail;
			$this->cSubData 	= $cSubData;
		    
		}
		
		function soapAyar(){
			$options = array( 
					'login'				=>"user",
	                'password'			=>"GB+sU[!7fxyZY%:OZ{*E>G=c$",
	                'trace'				=>1,
	                'exceptions'		=>1,
	                'connection_timeout'=>10,
	                'cache_wsdl'		=>WSDL_CACHE_NONE
	         	); 
	         	
	        return $options;
	        
		}
		
		// Sabit Kullanılan fonksiyonlar
		function gidenXML(){
			return $this->Istemci->__getLastRequest();
			
		}
		function gelenXML(){
			return $this->Istemci->__getLastResponse();
			
		}
		
		private function setBaglan(){
			try{
		    	$this->Istemci 	= new SoapClient('http://192.168.1.100/LogoObjectService?singleWsdl', $this->soapAyar()); 
			} catch (Exception $e) {
				$this->cMail->Gonder("baarisgull@gmail.com", "Entegrasyon Sorun", $e);
			}
		}
		
		// Özel fonksiyon 
		private function getTarihParcala($tarih) {
			list($date, $time) 					= explode('T', $tarih);
			list($yil, $ay, $gun) 				= explode('-', $date);
			list($saat, $dakika, $saniye) 		= explode(':', $time);
			
			return array($yil, $ay, $gun, $saat, $dakika, $saniye);
			
		}
		
		public function getFaturaGonder($id) {
			$this->setBaglan();
			
			$row = $this->cSubData->getFaturaXml(array("id"=>$id));
			
			$send = new StdClass();
			$send->dataType 		= 19;
			$send->dataReference 	= 0;
			$send->dataXML		 	= $row->XML;
			$send->paramXML			= $row->PARAM_XML;
			$send->errorString		= "";
			$send->status			= 32;
			$send->LbsLoadPass		= "";
			$send->FirmNr			= 17;
			$send->securityCode		= "Simal";
			
			try{
				$Data 	= $this->Istemci->AppendDataObject($send);
			} catch (SoapFault $e){
				print_r($e);
			}
			
			
			if($Data->status == 4) {
				echo "Hata:" . $Data->errorString;
			}
			
			$Data->row = $row;
			
			return $Data;
			
		}
		
		public function getOdemeGonder($id) {
			$this->setBaglan();
			
			$row = $this->cSubData->getOdemeXml(array("id"=>$id));
			
			$send = new StdClass();
			$send->dataType 		= $row->DATA_TYPE;;
			$send->dataReference 	= 0;
			$send->dataXML		 	= $row->XML;
			$send->paramXML			= $row->PARAM_XML;
			$send->errorString		= "";
			$send->status			= 32;
			$send->LbsLoadPass		= "";
			$send->FirmNr			= 17;
			$send->securityCode		= "Simal";
			
			try{
				$Data 	= $this->Istemci->AppendDataObject($send);
			} catch (SoapFault $e){
				print_r($e);
			}
			
			
			if($Data->status == 4) {
				echo "Hata:" . $Data->errorString;
			}
			
			return $Data;
			
		}
		
		/*
		public function getFaturaOku($id) {
			$this->setBaglan();
			
			$send = new StdClass();
			$send->dataType 		= 19;
			$send->dataReference 	= 6;
			$send->dataXML		 	= "";
			$send->paramXML			= "";
			$send->errorString		= "";
			$send->status			= 32;
			$send->LbsLoadPass		= "";
			$send->FirmNr			= 17;
			$send->securityCode		= "Simal";
			
			try{
				$Data 	= $this->Istemci->ReadDataObject($send);
			} catch (SoapFault $e){
				print_r($e);
			}
			
			
			if($Data->status == 4) {
				echo "Hata:" . $Data->errorString;
			}
			
			return $Data;
			
		}
		
		public function getFaturaSil($referans_id) {
			$this->setBaglan();
			
			$send = new StdClass();
			$send->dataType 		= 19;
			$send->dataReference 	= $referans_id;
			$send->errorString		= "";
			$send->status			= 32;
			$send->LbsLoadPass		= "";
			$send->FirmNr			= 17;
			$send->securityCode		= "Simal";
			
			try{
				$Data 	= $this->Istemci->DeleteDataObject($send);
			} catch (SoapFault $e){
				print_r($e);
			}
			
			
			if($Data->status == 4) {
				echo "Hata:" . $Data->errorString;
			}
			
			return $Data;
			
		}	
		*/
		
	}
