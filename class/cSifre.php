<?

	class Sifre {		
		private $cCrypt;
		function __construct($cCrypt) {
	       	$this->cCrypt = $cCrypt;
			//$cCrypt->setComplexTypes(TRUE);
			
		}
		
		public function getSifrele($str) {
			$this->cCrypt->setKey('eff99cfe6876008c6a6e080e4a382be2');
			$this->cCrypt->setData($str);
			$val = urlencode($this->cCrypt->encrypt());
			return $val;
			
		}
		
		public function getCoz($str){
			$this->cCrypt->setKey('eff99cfe6876008c6a6e080e4a382be2');
			$this->cCrypt->setData(urldecode($str));
			$val = $this->cCrypt->decrypt();
			return $val;
			
		}
		
		public function getCozTumu(){
			$this->cCrypt->setKey('eff99cfe6876008c6a6e080e4a382be2');
			foreach($_REQUEST as $key => $val){
				$this->cCrypt->setData(urldecode($val));
				$_REQUEST[$key] = $this->cCrypt->decrypt();
			}
			
		}
	    
	}

?>