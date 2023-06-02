<?

	Class TY {
	    private $supplierid, $appUsername, $appPassword, $parameters, $client;
	    public $debug = false;
	    
	    public function __construct() {
	    	/*
	    	$this->supplierid 		= "123186";
	        $this->appUsername 		= "fdmr88mmENgzImphGcYv";
	        $this->appPassword 		= "dwcsId2IFAs0D1zAfUmF";
	        */
	        $this->supplierid 		= "661534";
	        $this->appUsername 		= "8kYLshBHutUk1YTrCmMT";
	        $this->appPassword 		= "C93jG5dthbFyMgckOQ0r";
	        $this->parameters 		= ['auth' => ['appUsername' => $this->appUsername, 'appPassword' => $this->appPassword]];
	    }
	    
	    public function setUrl($url) {
	        self::$client = new \SoapClient($url);
	    }
	 	
	 	public function getKargo(){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/shipment-providers");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function getKategoriler(){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/product-categories");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function getKategoriOzellikler($kategori_id = ""){
			if(empty($kategori_id)) return "Kategori Yok!";
			
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/product-categories/$kategori_id/attributes");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function getMarkaId($marka = ""){			
			if(empty($marka)) return "Marka Yok!";
			
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw//brands/by-name?name=$marka");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function getSaticiAdresler(){
			
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/addresses");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json'));
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function getUrunlerOnayli(){			
			echo 
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/products?approved=true");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json'));
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function getUrunBarkod($barcode = ""){			
			if(empty($barcode)) return "Barkod Yok!";
			
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/products?barcode=$barcode");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json'));
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function setUrun($uruns = array()){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/v2/products");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json', 'PUT: createProducts'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($uruns));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function setUrunGuncelle($uruns = array()){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/v2/products");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json', 'PUT: updateProducts'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($uruns));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function setStokFiyatGuncelle(){
			/*
			{
			  "items": [
			    {
			      "barcode": "8680000000",
			      "quantity": 100,
			      "salePrice": 112.85,
			      "listPrice": 113.85
			    }
			  ]
			}
			result
			{
			    "batchRequestId": "fa75dfd5-6ce6-4730-a09e-97563500000-1529854840"
			}
			*/
			
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/products/price-and-inventory");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function getUrunKontrol($batchRequestId = ""){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/products/batch-requests/$batchRequestId");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function getSiparisler(){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/orders");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function getSiparislerFiltreli($startDate, $endDate){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/orders?status={$status}&startDate={$startDate}&endDate={$endDate}&orderByField=CreatedDate&orderByDirection=DESC&size=100");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
		
		public function setSiparisStatusGuncelle($id, $lines){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://api.trendyol.com/sapigw/suppliers/{$this->supplierid}/shipment-packages/{$id}");
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($this->appUsername .":". $this->appPassword),'Content-Type: application/json', 'PUT: updatePackage'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			
			return json_decode($result);
		}
	    
	}