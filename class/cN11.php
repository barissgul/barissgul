<?

	Class N11 {
	    protected static $appKey, $appSecret, $parameters, $client;
	    public $debug = false;
	    
	    public function __construct() {
	        self::$appKey 		= "141beb6a-ebca-426d-a69d-208adf389913";
	        self::$appSecret 	= "vdOGcdi92UUIOyf9";
	        self::$parameters 	= ['auth' => ['appKey' => self::$appKey, 'appSecret' => self::$appSecret]];
	    }
	    
	    public function setUrl($url) {
	        self::$client = new \SoapClient($url);
	    }
	 
	    public function GetTopLevelCategories() {
	        $this->setUrl('https://api.n11.com/ws/CategoryService.wsdl');
	        return self::$client->GetTopLevelCategories(self::$parameters);
	    }
	 
	    public function GetCities() {
	        $this->setUrl('https://api.n11.com/ws/CityService.wsdl');
	        return self::$client->GetCities(self::$parameters);
	    }
	 
	    public function GetProductList($itemsPerPage, $currentPage) {
	        $this->setUrl('https://api.n11.com/ws/ProductService.wsdl');
	        self::$parameters['pagingData'] = ['itemsPerPage' => $itemsPerPage, 'currentPage' => $currentPage];
	        return self::$client->GetProductList(self::$parameters);
	    }
	 
	    public function GetProductBySellerCode($sellerCode) {
	        $this->setUrl('https://api.n11.com/ws/ProductService.wsdl');
	        self::$parameters['sellerCode'] = $sellerCode;
	        return self::$client->GetProductBySellerCode(self::$parameters);
	    }
	 
	    public function SaveProduct(array $product = Array()) {
	        $this->setUrl('https://api.n11.com/ws/ProductService.wsdl');
	        self::$parameters['product'] = $product;
	        return self::$client->SaveProduct(self::$parameters);
	    }
	 
	    public function DeleteProductBySellerCode($sellerCode) {
	        $this->setUrl('https://api.n11.com/ws/ProductService.wsdl');
	        self::$parameters['productSellerCode'] = $sellerCode;
	        return self::$client->DeleteProductBySellerCode(self::$parameters);
	    }
	    
	    public function OrderList(array $searchData = Array()) {
	        $this->setUrl('https://api.n11.com/ws/OrderService.wsdl');
	        self::$parameters['searchData'] = $searchData;
	        return self::$client->OrderList(self::$parameters);
	    }
	    
	    public function Siparisler($searchData) {
	    	$searchData = json_decode(json_encode($searchData), true);
	    	
			$this->setUrl('https://api.n11.com/ws/OrderService.wsdl');
			self::$parameters['searchData'] = $searchData;
			return self::$client->DetailedOrderList(self::$parameters);
		}

	    public function OrderDetail(array $orderDetail = Array()) {
	        $this->setUrl('https://api.n11.com/ws/OrderService.wsdl');
	        self::$parameters['orderRequest'] = $orderDetail;
	        return self::$client->OrderDetail(self::$parameters);
	    }
	 	
	 	public function OrderItemAccept(array $orderItemList = Array()) {
			$this->setUrl('https://api.n11.com/ws/OrderService.wsdl');
			self::$parameters['orderItemList'] = $orderItemList;
			return self::$client->OrderItemAccept(self::$parameters);
		}

	    public function __destruct() {
	        if ($this->debug) {
	            print_r(self::$parameters);
	        }
	    }   
	}