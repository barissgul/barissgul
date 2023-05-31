<?

	class Hgs {	
		public $api_key = "647204-8ef2a6-331aeb-0d4934-627f90";
		public $secret = "ad8349-946eef-d7dee9-bd9608-6e4079";	
		public $token;
		public $name;
		public $email;
		public $success;		
		
		function __construct() {
	       
	        
		}
		
		public function login($postFields = array()){
			$postFields["api_key"]	= $this->api_key;
			$postFields["secret"]	= $this->secret;
			
			$post = http_build_query($postFields, '=', '&');
	    	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.hgskurumsal.com/api/auth");
			curl_setopt($ch, CURLOPT_SSLVERSION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    $result = curl_exec($ch);
		    curl_close($ch);
		    
		    $result_json = json_decode($result);
		    
		    $this->token = $result_json->token;
		    $this->name = $result_json->name;
		    $this->email = $result_json->email;
		    $this->success = $result_json->success;
			
			if(!$this->success){
				echo __FUNCTION__ . " Hatalı!"; die();
			}
			
			return $this->token;
		}
	    
	    public function firmalar($postFields = array()){
	    	if(!$this->success){
				$this->login();	
			}
	    	
	    	$header[] = 'Authorization: '. $this->token;
	    	
			$post = http_build_query($postFields, '=', '&');
	    	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.hgskurumsal.com/api/firms");
			curl_setopt($ch, CURLOPT_SSLVERSION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		    curl_setopt($ch, CURLOPT_POST, 0);
		    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    $result = curl_exec($ch);
		    curl_close($ch);
		    
		    $result_json = json_decode($result);
		    
		    if(!$result_json->success){
				echo __FUNCTION__ . " Hatalı!"; die();
			}
			
		   	return $result_json->firms;
			
		}
		
		public function dashboard($postFields = array()){
			if(!$this->success){
				$this->login();	
			}
	    	
	    	$header[] = 'Authorization: '. $this->token;
	    	
			$post = http_build_query($postFields, '=', '&');
	    	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.hgskurumsal.com/api/dashboard?" . $post);
			curl_setopt($ch, CURLOPT_SSLVERSION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		    curl_setopt($ch, CURLOPT_POST, 0);
		    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    $result = curl_exec($ch);
		    curl_close($ch);
		    
		    $result_json = json_decode($result);
		    
		    
		    if(!$result_json->success){
				echo __FUNCTION__ . " Hatalı!"; die();
			}
			
		   	return $result_json->firms;
			
		}
		
		public function araclar($postFields = array()){
			if(!$this->success){
				$this->login();	
			}
	    	
	    	$header[] = 'Authorization: '. $this->token;
	    	
			$post = http_build_query($postFields, '=', '&');
	    	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.hgskurumsal.com/api/vehicle?" . $post);
			curl_setopt($ch, CURLOPT_SSLVERSION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		    curl_setopt($ch, CURLOPT_POST, 0);
		    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    $result = curl_exec($ch);
		    curl_close($ch);
		    
		    $result_json = json_decode($result);
		    
		    
		    if(!$result_json->success){
				echo __FUNCTION__  . " Hatalı!"; die();
			}
			
		   	return $result_json;
			
		}
		
		public function gecisler($postFields = array()){
			if(!$this->success){
				$this->login();	
			}
	    	
	    	$header[] = 'Authorization: '. $this->token;
	    	
			$post = http_build_query($postFields, '=', '&');
	    	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.hgskurumsal.com/api/transitions/all?" . $post);
			curl_setopt($ch, CURLOPT_SSLVERSION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		    curl_setopt($ch, CURLOPT_POST, 0);
		    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    $result = curl_exec($ch);
		    curl_close($ch);
		    
		    $result_json = json_decode($result);
		    
		    if(!$result_json->success){
				echo __FUNCTION__ . " Hatalı!"; die();
			}
			
		   	return $result_json->data;
			
		}
		
	}

?>