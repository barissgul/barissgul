<?

	Class GG {
	    public $debug = false;
	    
	    public function __construct() {
	    	list($usec, $sec) = explode(" ", microtime());
	    	
	        $this->gg_kullanici = "gulgulyaz";
	        $this->gg_sifre		= "E5DSnPe2AxXPkBfgHCEgDdf6ET22HFAV";
	        $this->devID 		= "u4JWDMpKUCJRM8UScV3T";
	       	$this->apiKey 		= "9yEtmhVrHxHvAAYpJgmJxaX98kz4KWAE";
	        $this->apiSecretKey	= "WA62WvGkawmkqcGZ";
	        $this->time 		= round(((float)$usec + (float)$sec) * 100).'0';
	       	$this->sign 		= md5($this->apiKey . $this->apiSecretKey . $this->time);
	        
	    }
	    
	    public function curlCalistir($postFields, $islem = ''){
	    	$post = http_build_query($postFields, '=', '&');
	    	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://drd.optimumcozum.com/api/otokoc.php?ISLEM=dosyaParcalar&KEY=b12ffc455b30e7a84a66d1bb5696f1ae&DB=ALD&ID=160');
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	        $result = curl_exec($ch);
	        curl_close($ch);
	        if($islem=="wsEkFatura0"){
				$this->cMail->Gonder('optimumhata@otoanaliz.net', "GIDEN:" . $islem, $post);
	        }
	        
	        $result = json_decode($result);
	       	if($result->success != 1){
				$this->cMail->Gonder('optimumhata@otoanaliz.net', "GIDEN:" . $islem, $post);
			}
			
		}
		
	    public function setUrl($url) {
	    	$options = array(
			    'login' => $this->gg_kullanici,
			    'password' => $this->gg_sifre,
			    'authentication' => SOAP_AUTHENTICATION_BASIC
			);
	        $this->client = new \SoapClient($url, $options);
	    }
	    
	    public function getProduct($productId, $itemId) {
	        $this->setUrl('https://dev.gittigidiyor.com:8443/listingapi/ws/IndividualProductService?wsdl');
	        
	        $request->apiKey		= $this->apiKey;
	  		$request->sign 			= $this->sign;
	        $request->time 			= $this->time;
	        $request->productId		= $productId;
	        $request->itemId 		= $itemId;
	        $request->lang			= "tr";
	        
	        try {
	            $response = $this->client->__soapCall("getProduct", (array)$request);
	        } catch (\SoapFault $fault) {
	            var_dump2($fault);
	        } catch (\Exception $e) {
	            echo $e->getCode().': '.$e->getMessage();
	        }
	        
	        return $response;
	        
	    }
	 
	 	public function getProducts($bas = 0, $adet = 5, $status = 'A', $withData = false) {
	        $this->setUrl('https://dev.gittigidiyor.com:8443/listingapi/ws/IndividualProductService?wsdl');	        
	  			
	  		$request->apiKey		= $this->apiKey;
	  		$request->sign 			= $this->sign;
	        $request->time 			= $this->time;
	        $request->startOffSet	= $bas;
	        $request->rowCount 		= $adet;
	        $request->status 		= $status;
	        $request->withData 		= $withData;
	        $request->lang			= "tr";
	        
	        try {
	            $response = $this->client->__soapCall("getProducts", (array)$request);
	        } catch (\SoapFault $fault) {
	            var_dump2($fault);
	        } catch (\Exception $e) {
	            echo $e->getCode().': '.$e->getMessage();
	        }
        	
	        return $response;
	        
	    }
	     
	    public function getCategories($startOffset = 100, $rowCount = 100, $withSpecs = false) {
	        $this->setUrl('http://dev.gittigidiyor.com:8080/listingapi/ws/CategoryService?wsdl');
	        
	        $request->startOffSet	= $startOffset;
	        $request->rowCount 		= $rowCount;
	        $request->withSpecs 	= $withSpecs;
	        $request->withDeepest 	= true;
	        $request->withCatalog 	= true;
	        $request->lang 			= tr;
	        
	      	 try {
	            $response = $this->client->__soapCall("getCategories", (array)$request);
	        } catch (\SoapFault $fault) {
	            var_dump2($fault);
	        } catch (\Exception $e) {
	            echo $e->getCode().': '.$e->getMessage();
	        }
        	
	        return $response;
	        
	    }
	    
	    public function getCategory($categoryCode = "rg1bp", $withSpecs = true) {
	        $this->setUrl('http://dev.gittigidiyor.com:8080/listingapi/ws/CategoryService?wsdl');
	        
	        $request->categoryCode	= $categoryCode;
	        $request->withSpecs 	= $withSpecs;
	        $request->withDeepest 	= true;
	        $request->withCatalog 	= true;
	        $request->lang 			= tr;
	        
	      	 try {
	            $response = $this->client->__soapCall("getCategory", (array)$request);
	        } catch (\SoapFault $fault) {
	            var_dump2($fault);
	        } catch (\Exception $e) {
	            echo $e->getCode().': '.$e->getMessage();
	        }
        	
	        return $response;
	        
	    }
	    
	    public function getCities($startOffSet = 0, $rowCount = 100) {
	    	$this->setUrl('http://dev.gittigidiyor.com:8080/listingapi/ws/CityService?wsdl');
	        
	        $request->startOffSet	= $startOffSet;
	        $request->rowCount 		= $rowCount;
	        $request->lang 			= tr;
	        
	      	 try {
	            $response = $this->client->__soapCall("getCities", (array)$request);
	        } catch (\SoapFault $fault) {
	            var_dump2($fault);
	        } catch (\Exception $e) {
	            echo $e->getCode().': '.$e->getMessage();
	        }
        	
	        return $response;
	        
	    }
	    
	    public function getCity($code = 34) {
	    	$this->setUrl('http://dev.gittigidiyor.com:8080/listingapi/ws/CityService?wsdl');
	        
	        $request->code	= $code;
	        $request->lang 	= tr;
	        
	      	 try {
	            $response = $this->client->__soapCall("getCity", (array)$request);
	        } catch (\SoapFault $fault) {
	            var_dump2($fault);
	        } catch (\Exception $e) {
	            echo $e->getCode().': '.$e->getMessage();
	        }
        	
	        return $response;
	        
	    }
	    
	    public function insertProduct($itemId, array $product = Array()) {
	        $this->setUrl('https://dev.gittigidiyor.com:8443/listingapi/ws/IndividualProductService?wsdl');	        
	  			
	  		$request->apiKey			= $this->apiKey;
	  		$request->sign 				= $this->sign;
	        $request->time 				= $this->time;
	        $request->itemId			= $itemId;
	        $request->product 			= $product;
	        $request->forceToSpecEntry 	= false;
	        $request->nextDateOption 	= false;
	        $request->lang				= "tr";
	        
	        try {
	            $response = $this->client->__soapCall("insertProduct", (array)$request);
	        } catch (\SoapFault $fault) {
	            var_dump2($fault);
	        } catch (\Exception $e) {
	            echo $e->getCode().': '.$e->getMessage();
	        }
        	
	        return $response;
	        
	    }
	    
	    public function updateProduct($itemId, $productId, array $product = Array()) {
	        $this->setUrl('https://dev.gittigidiyor.com:8443/listingapi/ws/IndividualProductService?wsdl');	        
	  			
	  		$request->apiKey			= $this->apiKey;
	  		$request->sign 				= $this->sign;
	        $request->time 				= $this->time;
	        $request->itemId			= $itemId;
	        $request->productId 		= $productId;
	        $request->product 			= $product;
	        $request->onSale 			= false;
	        $request->forceToSpecEntry 	= false;
	        $request->nextDateOption 	= false;
	        $request->lang				= "tr";
	        
	        try {
	            $response = $this->client->__soapCall("updateProduct", (array)$request);
	        } catch (\SoapFault $fault) {
	            var_dump2($fault);
	        } catch (\Exception $e) {
	            echo $e->getCode().': '.$e->getMessage();
	        }
        	
	        return $response;
	        
	    }
	    
	    public function __destruct() {
	        if ($this->debug) {
	            print_r($this->parameters);
	        }
	    }   
	}