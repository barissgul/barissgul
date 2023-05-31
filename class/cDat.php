<?

	Class Dat {
	    public $customerId, $username, $password, $signature;
	    public $debug = false;
	    
	    public function __construct($cdbPDO) {
	        $this->customerId 			= "3800513";
	        $this->customerSignature 	= "878B4E1ED7FA7FC211F9931388A3E83983770CD92DF5BA6CD492C0F131A7191C";
	        $this->username 			= "boryazkb";
	        $this->password 			= "boryazkb01";
	        $this->signature 			= "BE9735DCB643516E3829C1192085E961CCA4495A0FECEF16B1CA557F85575FB4";
	        $this->cdbPDO				= $cdbPDO;
	    }
	    
	    function fncFonksiyonlar(){
			$this->fncBaglan();
			return $this->client->__getFunctions(); 
		}
		
		function fncFonksiyonDetaylar(){
			$this->fncBaglan();
			return $this->client->__getTypes();
		}
	    
	    public function setBaglan($url) {
	        
	    }
	 
	    public function getLogin2() {
	        $this->client = new \SoapClient('http://www.dat.de/PartsInfo/services/Authentication?wsdl');

	        $params->customerLogin				= $this->username;
	        $params->customerNumber				= $this->customerId;
	        $params->customerSignature			= $this->customerSignature;
	        $params->interfacePartnerNumber		= $this->customerId;
	        $params->interfacePartnerSignature	= $this->signature;
	        $params->productVariant				= "";
	        
	        $result = $this->client->doLogin(array("request"=>$params));
	        
	        $this->sessionID	= $result->sessionID;
	        
	        return $result;
	    }
	    
	    public function getLogin($yeni = 0) {
	    	
	    	if(strlen($_SESSION['sessionID']) > 1 AND $yeni == 0) {
				return $_SESSION['sessionID'];
			}
	    	
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/PartsInfo/services/Authentication?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:aut="http://sphinx.dat.de/services/Authentication">
										<soapenv:Header/>
										<soapenv:Body>
											<aut:doLogin>
												<request>
													<customerLogin>'.$this->username.'</customerLogin>
													<customerNumber>'.$this->customerId.'</customerNumber>
													<customerSignature>'.$this->customerSignature.'</customerSignature>
													<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
													<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
													<productVariant></productVariant>
												</request>
											</aut:doLogin>
										</soapenv:Body>
									</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($response);
			//var_dump2($result);
			if(strlen($result->S_Body->ns1_doLoginResponse->sessionID) > 0){
				$_SESSION['sessionID']	= $result->S_Body->ns1_doLoginResponse->sessionID;	
			}
			
	        return $result->S_Body->ns1_doLoginResponse->sessionID;
	    }
	    
	    public function getToken($yeni = 0) {
	    	
	    	if(strlen($_SESSION['datToken']) > 1 AND date('Y-m-d H:i:s', strtotime("-28 minute" )) < $_SESSION['datTokenTarih'] AND $yeni == 0) {
				return $_SESSION['datToken'];
			}
	    	
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/PartsInfo/services/Authentication?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:aut="http://sphinx.dat.de/services/Authentication">
										<soapenv:Header/>
										<soapenv:Body>
											<aut:generateToken>
												<request>
													<customerLogin>'.$this->username.'</customerLogin>
													<customerNumber>'.$this->customerId.'</customerNumber>
													<customerPassword>'.$this->password.'</customerPassword>
													<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
													<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
													<productVariant></productVariant>
												</request>
										</aut:generateToken>
										</soapenv:Body>
									</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($response);
			//var_dump2($result);
			if(strlen($result->S_Body->ns1_generateTokenResponse->token) > 0){
				$_SESSION['datToken']		= $result->S_Body->ns1_generateTokenResponse->token;	
				$_SESSION['datTokenTarih']	= date("Y-m-d H:i:s");
			}
			
	        return $result->S_Body->ns1_generateTokenResponse->token;
	    }
	    
	    public function getVehicleIdentificationByVin($sasi_no) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/VehicleRepairOnline/services/VehicleIdentificationService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleIdentificationService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getVehicleIdentificationByVin>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTime></constructionTime>
													<coverage>ALL</coverage>
													<restriction>ALL</restriction>
													<vin>'.$sasi_no.'</vin>
												</request>
											</veh:getVehicleIdentificationByVin>
										</soapenv:Body>
									</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				return $result->S_Body->ns1_getVehicleIdentificationByVinResponse->VXS->ns1_Dossier;		
			}
	        
	    }
	    
	    public function getDosyaOlustur($dosya_no, $sasi_no, $datecode, $plaka) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/VehicleRepairOnline/services/VehicleRepairService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleRepairService" xmlns:vxs="http://www.dat.de/vxs">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:importDossier>
											<request>
												<crud>CREATE</crud>
												<dossiers>
													<vxs:Dossier>
														<vxs:Description>A'.$dosya_no.'</vxs:Description>
														<vxs:DossierType>repair</vxs:DossierType>
														<vxs:Language>tr</vxs:Language>
														<vxs:Country>TR</vxs:Country>
														<vxs:Vehicle>
															<vxs:VehicleIdentNumber>'.$sasi_no.'</vxs:VehicleIdentNumber>
															<vxs:DatECode>'.$datecode.'</vxs:DatECode>
															<vxs:RegistrationData>
																<vxs:LicenseNumber>'.$plaka.'</vxs:LicenseNumber>
															</vxs:RegistrationData>
														</vxs:Vehicle>
													</vxs:Dossier>
												</dossiers>
												<locale country="tr" datCountryIndicator="TR" language="tr"/>
											</request>
											</veh:importDossier>
										</soapenv:Body>
									</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));			
			
			$filtre = array();
			$sql = "INSERT INTO KATALOG_LOG SET DOSYA_NO = :DOSYA_NO, SASI_NO = :SASI_NO, PLAKA = :PLAKA, LOG = :LOG, LOG_TURU = :LOG_TURU";
			$filtre[":DOSYA_NO"]	= $dosya_no;
			$filtre[":SASI_NO"] 	= $sasi_no;
			$filtre[":PLAKA"] 		= $plaka;
			$filtre[":LOG"] 		= json_encode($result);
			$filtre[":LOG_TURU"] 	= "DOSYA_ACMA";
			$this->cdbPDO->rowsCount($sql, $filtre);
			//var_dump2($response);
			//var_dump2($result);
	        
	        if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				return $result->S_Body->ns1_importDossierResponse;
			}
	        
	    }
	    
	    public function getCalculationResults($contract_id) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/VehicleRepairOnline/services/VehicleRepairService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleRepairService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getCalculationResults>
												<contractID>'.$contract_id.'</contractID>
												<locale country="TR" datCountryIndicator="TR" language="tr"/>
											</veh:getCalculationResults>
										</soapenv:Body>
									</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));			
			
			//var_dump2($response);
			//var_dump2($result->S_Body->ns4_getCalculationResultsResponse->calculationResult->ns1_Dossier);
	        
	        return $result->S_Body->ns1_getCalculationResultsResponse->calculationResult->ns1_Dossier; //ns1_CalcResultToUse
	    }
	    
	    public function __getVehicleIdentificationByVin($params) {
	        $this->client = new \SoapClient('http://www.dat.de/VehicleRepairOnline/services/VehicleIdentificationService?wsdl');
			
	        $header->customerLogin				= $this->username;
	        $header->customerNumber				= $this->customerId;
	        $header->customerSignature			= $this->customerSignature;
	        $header->interfacePartnerNumber		= $this->customerId;
	        $header->interfacePartnerSignature	= $this->signature;
	        
	        $this->client->__setSoapHeaders(array($header));
	        
	        $params->customerLogin				= $this->username;
	        $params->customerNumber				= $this->customerId;
	        $params->customerNumber				= $this->customerId;
	        $params->customerNumber				= $this->customerId;
	        
	        
			$result = $this->client->__soapCall("getVehicleIdentificationByVin", array("request"=>$params));
			
	        var_dump2($result);
	        
	        
	        return $result;
	    }
	    
	    // ADIM 01 Araç Türü
	    public function datAracTipi($arr = array()) {
			$curl = curl_init();
			
			//$this->getLogin(0);
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getVehicleTypes>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<restriction>ALL</restriction>
												</request>
											</veh:getVehicleTypes>
										</soapenv:Body>
									</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				foreach($result->S_Body->ns1_getVehicleTypesResponse->vehicleType as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;		
			}
	        
	    }
	    
	    // ADIM 02 Marka
	    public function datMarkalar($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getManufacturers>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom></constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
												</request>
											</veh:getManufacturers>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				if(!is_array($result->S_Body->ns1_getManufacturersResponse->manufacturer)) {
					$rows_yeni[] = $result->S_Body->ns1_getManufacturersResponse->manufacturer; 
				} else {
					$rows_yeni = $result->S_Body->ns1_getManufacturersResponse->manufacturer;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;
			}
	        
	    }
	    
	    // ADIM 03 Model
	    public function datModeller($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getBaseModels>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom></constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
												</request>
											</veh:getBaseModels>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				if(!is_array($result->S_Body->ns1_getBaseModelsResponse->baseModel)) {
					$rows_yeni[] = $result->S_Body->ns1_getBaseModelsResponse->baseModel; 
				} else {
					$rows_yeni = $result->S_Body->ns1_getBaseModelsResponse->baseModel;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;
			}
	        
	    }
	 	
	 	// ADIM 04 Paket
	 	public function datAltModeller($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getSubModels>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom></constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
													<baseModel>'.$arr['model_id'].'</baseModel>
												</request>
											</veh:getSubModels>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				if(!is_array($result->S_Body->ns1_getSubModelsResponse->subModel)) {
					$rows_yeni[] = $result->S_Body->ns1_getSubModelsResponse->subModel; 
				} else {
					$rows_yeni = $result->S_Body->ns1_getSubModelsResponse->subModel;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;
			}
	        
	    }
	    
	    // ADIM 05 Motor
	    public function datMotorlar($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getEngineOptions>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom></constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
													<baseModel>'.$arr['model_id'].'</baseModel>
													<subModel>'.$arr['alt_model_id'].'</subModel>
													<availableOptions></availableOptions>
												</request>
											</veh:getEngineOptions>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				
				if(!is_array($result->S_Body->ns1_getEngineOptionsResponse->engineOption)) {
					$rows_yeni[] = $result->S_Body->ns1_getEngineOptionsResponse->engineOption; 
				} else {
					$rows_yeni = $result->S_Body->ns1_getEngineOptionsResponse->engineOption;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;		
			}
	        
	    }
	    
	    // ADIM 06 Kaporta
	    public function datKaportalar($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getCarBodyOptions>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom></constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
													<baseModel>'.$arr['model_id'].'</baseModel>
													<subModel>'.$arr['alt_model_id'].'</subModel>
													<availableOptions></availableOptions>
												</request>
											</veh:getCarBodyOptions>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				
				if(!is_array($result->S_Body->ns1_getCarBodyOptionsResponse->carBodyOption)) {
					$rows_yeni[] = $result->S_Body->ns1_getCarBodyOptionsResponse->carBodyOption; 
				} else {
					$rows_yeni = $result->S_Body->ns1_getCarBodyOptionsResponse->carBodyOption;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;			
			}
	        
	    }
	    
	    // ADIM 07 Şanzuman
	    public function datSanzimanlar($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getGearingOptions>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom></constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
													<baseModel>'.$arr['model_id'].'</baseModel>
													<subModel>'.$arr['alt_model_id'].'</subModel>
													<availableOptions></availableOptions>
												</request>
											</veh:getGearingOptions>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				
				if(!is_array($result->S_Body->ns1_getGearingOptionsResponse->gearingOption)) {
					$rows_yeni[] = $result->S_Body->ns1_getGearingOptionsResponse->gearingOption; 
				} else {
					$rows_yeni = $result->S_Body->ns1_getGearingOptionsResponse->gearingOption;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;		
			}
	        
	    }
	    
	    // ADIM 08 Donanım Şekli 
	    public function datDonanimlar($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getEquipmentLineOptions>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom></constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
													<baseModel>'.$arr['model_id'].'</baseModel>
													<subModel>'.$arr['alt_model_id'].'</subModel>
													<availableOptions></availableOptions>
												</request>
											</veh:getEquipmentLineOptions>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				//return $result->S_Body->S_Fault;
				return $rows;
			} else {
				if(!is_array($result->S_Body->ns1_getEquipmentLineOptionsResponse->equipmentLineOption)) {
					$rows_yeni[] = $result->S_Body->ns1_getEquipmentLineOptionsResponse->equipmentLineOption; 
				} else {
					$rows_yeni = $result->S_Body->ns1_getEquipmentLineOptionsResponse->equipmentLineOption;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;
			}
	        
	    }
	    
	    // ADIM 08.1 AKS Mesafesi
	    public function datAkslar($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getWheelBaseOptions>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom></constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
													<baseModel>'.$arr['model_id'].'</baseModel>
													<subModel>'.$arr['alt_model_id'].'</subModel>
													<availableOptions></availableOptions>
												</request>
											</veh:getWheelBaseOptions >
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				//return $result->S_Body->S_Fault;
				return $rows;
			} else {
				if(!is_array($result->S_Body->ns1_getWheelBaseOptionsResponse->wheelBaseOption)) {
					$rows_yeni[] = $result->S_Body->ns1_getWheelBaseOptionsResponse->wheelBaseOption; 
				} else {
					$rows_yeni = $result->S_Body->ns1_getWheelBaseOptionsResponse->wheelBaseOption;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;
			}
	        
	    }
	    
	    // ADIM 08.2 Tahrik Türü 
	    public function datTahrikTurler($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:getTypeOfDriveOptions>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom></constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
													<baseModel>'.$arr['model_id'].'</baseModel>
													<subModel>'.$arr['alt_model_id'].'</subModel>
													<availableOptions></availableOptions>
												</request>
											</veh:getTypeOfDriveOptions>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				//return $result->S_Body->S_Fault;
				return $rows;
			} else {
				if(!is_array($result->S_Body->ns1_getTypeOfDriveOptionsResponse->typeOfDriveOption)) {
					$rows_yeni[] = $result->S_Body->ns1_getTypeOfDriveOptionsResponse->typeOfDriveOption; 
				} else {
					$rows_yeni = $result->S_Body->ns1_getTypeOfDriveOptionsResponse->typeOfDriveOption;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row->{"@attributes"}->key;
					$rows[$key]->AD  =	$row->{"@attributes"}->value;
				}
				
				return $rows;
			}
	        
	    }
	    
	    // ADIM 09 DATECODE
	    public function datCodeler($arr = array()) {
			$curl = curl_init();
			
			
			if($arr['alt_model_id'] > 0){
				$filtre = array();
				$sql = "SELECT
							K.*
						FROM KATALOG_DAT AS K
						WHERE K.KATEGORI_ID = :KATEGORI_ID
							AND K.MARKA_ID = :MARKA_ID
							AND K.MODEL_ID = :MODEL_ID
							AND K.ALT_MODEL_ID = :ALT_MODEL_ID
						";
				$filtre[":KATEGORI_ID"]	= $arr['arac_tipi_id'];
				$filtre[":MARKA_ID"]	= $arr['marka_id'];
				$filtre[":MODEL_ID"]	= $arr['model_id'];
				$filtre[":ALT_MODEL_ID"]= $arr['alt_model_id'];
				$row = $this->cdbPDO->row($sql, $filtre);
				
				$row_tarih = $this->datTarih(array("tarih"=>$row->MODEL_YILI_BAS."-03-01"));
				
			}
			
			if($arr['donanim_id'] > 0) {
				$str_donanim = '<selectedOptions>'.$arr['donanim_id'].'</selectedOptions>';
			}
			
			if($arr['aks_id'] > 0){
				$str_aks = '<selectedOptions>'.$arr['aks_id'].'</selectedOptions>';
			}
			
			if($arr['tahrik_turu_id'] > 0){
				$str_tahrik_turu = '<selectedOptions>'.$arr['tahrik_turu_id'].'</selectedOptions>';
			}
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/VehicleSelectionService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:compileDatECode>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom>'.$row_tarih.'</constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
													<baseModel>'.$arr['model_id'].'</baseModel>
													<subModel>'.$arr['alt_model_id'].'</subModel>
													<selectedOptions>'.$arr['motor_id'].'</selectedOptions>
													<selectedOptions>'.$arr['kaporta_id'].'</selectedOptions>
													<selectedOptions>'.$arr['sanziman_id'].'</selectedOptions>
													'.$str_donanim.'
													'.$str_aks.'
													'.$str_tahrik_turu.'
												</request>
											</veh:compileDatECode>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			/*
			var_dump2('<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:veh="http://sphinx.dat.de/services/VehicleSelectionService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<veh:compileDatECode>
												<request>
													<locale country="tr" datCountryIndicator="tr" language="tr"/>
													<token>'.$_SESSION['datToken'].'</token>
													<constructionTimeFrom>'.$row_tarih.'</constructionTimeFrom>
													<constructionTimeTo></constructionTimeTo>
													<restriction>ALL</restriction>
													<vehicleType>'.$arr['arac_tipi_id'].'</vehicleType>
													<manufacturer>'.$arr['marka_id'].'</manufacturer>
													<baseModel>'.$arr['model_id'].'</baseModel>
													<subModel>'.$arr['alt_model_id'].'</subModel>
													<selectedOptions>'.$arr['motor_id'].'</selectedOptions>
													<selectedOptions>'.$arr['kaporta_id'].'</selectedOptions>
													<selectedOptions>'.$arr['sanziman_id'].'</selectedOptions>
													<selectedOptions>'.$arr['aks_id'].'</selectedOptions>
													<selectedOptions>'.$arr['tahrik_turu_id'].'</selectedOptions>
												</request>
											</veh:compileDatECode>
										</soapenv:Body>
										</soapenv:Envelope>');
									
			*/
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				if(!is_array($result->S_Body->ns1_compileDatECodeResponse->datECode)) {
					$rows_yeni[] = $result->S_Body->ns1_compileDatECodeResponse->datECode; 
				} else {
					$rows_yeni = $result->S_Body->ns1_compileDatECodeResponse->datECode;
				}
				
				foreach($rows_yeni as $key => $row){
					$rows[$key]->ID  =	$row;
					$rows[$key]->AD  =	$row;
				}
				
				return $rows;	
			}
	        
	    }
	    
	    // ADIM 10 Resim
	    public function getVehicleImagesN($datecode) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://www.dat.de/DATECodeSelection/services/VehicleImagery?wsdl ',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
									    <Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</Header>
									    <Body>
									        <getVehicleImagesN xmlns="http://sphinx.dat.de/services/VehicleImagery">
									            <request xmlns="">
									                <aspect>ALL</aspect>
									                <datECode>'.$datecode.'</datECode>
									                <imageType>PICTURE</imageType>
									            </request>
									        </getVehicleImagesN>
									    </Body>
									</Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($response);
			
			if(isset($result->S_Body->S_Fault)){
				return $result->S_Body->S_Fault;
			} else {
				return $result->S_Body->ns1_getVehicleImagesNResponse->vehicleImagesN->images;		
			}
			
	    }
	    
	    // ADIM 11 CONSTRUCTIME
	    public function datTarih($arr = array()) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://www.dat.de/DATECodeSelection/services/ConversionFunctionsService?wsdl',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://sphinx.dat.de/services/ConversionFunctionsService">
										<soapenv:Header>
											<customerLogin>'.$this->username.'</customerLogin>
											<customerNumber>'.$this->customerId.'</customerNumber>
											<customerSignature>'.$this->customerSignature.'</customerSignature>
											<interfacePartnerNumber>'.$this->customerId.'</interfacePartnerNumber>
											<interfacePartnerSignature>'.$this->signature.'</interfacePartnerSignature>
										</soapenv:Header>
										<soapenv:Body>
											<date2ConstructionTime>
												<request>
													<date>'.$arr['tarih'].'</date>
												</request>
											</date2ConstructionTime>
										</soapenv:Body>
										</soapenv:Envelope>
									',
				CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/xml'
				),
			));
			
			$response = curl_exec($curl);
			
			$plainXML = mungXML( trim($response) );
			$result = json_decode(str_replace(array('ns2_','ns3_','ns4_','ns5_','ns6_','ns7_','ns8_','ns9_'), 'ns1_', json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA))));
			
			//var_dump2($session_id);
			//var_dump2($result);
			
			if(isset($result->S_Body->S_Fault)){
				return "";
			} else {				
				return $result->S_Body->ns1_date2ConstructionTimeResponse->constructionTime;	
			}
	        
	    }
	    
	    
	 	public function __Login(){
			$this->client->__setSoapHeaders(array($authHeader));
			$response = $this->client->__soapCall("getVehicleIdentificationByVin", $params);
		}
	   
		
	    public function __destruct() {
	    	
			
	        if ($this->debug) {
	            print_r(self::$params);
	        }
	    }   
	}