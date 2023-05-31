<?	
	//extract($_REQUEST, EXTR_OVERWRITE, "wddx");
	
	class kontrol {
		protected $cdbPDO;
		protected $cMail;
		
		function __construct($class) {
			global $dbPDO, $cdbPDO, $cMail;
			$this->cdbPDO 			= $cdbPDO;
			$this->cMail 			= $cMail;
			
			self::kontrolKey($_REQUEST['KEY']);
			self::kontrolIslem($class, $_REQUEST['ISLEM']);	
			
			$this->{$_REQUEST['ISLEM']}();
		}
		
		function kontrolKey($key){
			if(empty($key)){
				$sonuc = array(	'hata'=>true,
								'data'=>'KEY parametresi yok!'); 
				echo json_encode($sonuc); die();
				
			} else if($key != "f57b0e103c26735ae640efa685e2f871"){ //SELECT MD5(MD5("TRPARTSFATİH"));
				$sonuc = array(	'hata'=>true,
								'data'=>'KEY yanlış!'); 
				var_dump2($key);
				echo json_encode($sonuc); die();
				
			}	
		}		
		
		function kontrolIslem($class, $islem){
			if(empty($islem)){
				$sonuc = array(	'hata'=>true,
								'data'=>'ISLEM parametresi yok!'); 
				echo json_encode($sonuc); die();
				
			} else if(!method_exists($class, $islem)){
				$sonuc = array(	'hata'=>true,
								'data'=>'ISLEM yanlış!'); 
				echo json_encode($sonuc);die();
				
			}
		}
		
		function kontrolId($degisken){
			if(empty($_REQUEST[$degisken])){
				$sonuc = array(	'hata'=>true,
								'data'=>"$degisken parametresi yok"); 
				echo json_encode($sonuc);
				die();
				
			}
			
		}
		
	}
	
	