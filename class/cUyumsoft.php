<?

	class Uyumsoft {		
		private $cdbPDO;
		private $cMail;
		private $rSite;
		
		function __construct($cdbPDO, $cMail, $cSubData, $row_site) {
			$this->cdbPDO 	= $cdbPDO;
			$this->cMail	= $cMail;
			$this->rSite	= $row_site;
		}
		
		public static function tarih($tarih){
			$arr = explode("T", $tarih);
			return $arr[0] ." ". $arr[1];
		}
		
		public static function saat($tarih){
			$arr = explode(".", $tarih);
			return $arr[0];
		}
		
		public static function temizle($str){
			if(is_array($str)){
				return $str[0];
			}
			return trim($str);
		}
		
		public static function kayit_tarih($str){
			if(is_array($str)){
				return self::temizle($str[0]["cbc_IssueDate"]);
			}
			return self::temizle($str["cbc_IssueDate"]);
		}
		
		public static function fatura_not($str){
			if(is_array($str)){
				return implode(', ', $str);
			}
			return self::temizle($str);
		}
		
		public static function kayit_tarih_($str){
			if(is_array($str)){
				return self::temizle($str[0]->IssueDate->_);
			}
			return self::temizle($str->IssueDate->_);
		}
		
		public static function fatura_not_($str){
			if(is_array($str)){
				return implode(', ', $str);
			}
			return self::temizle($str);
		}
		
		function fncBaglan(){
			$options = array(
				'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
				'style'=>SOAP_RPC,
				'use'=>SOAP_ENCODED,
				'soap_version'=>SOAP_1_1,
				'cache_wsdl'=>WSDL_CACHE_NONE,
				'connection_timeout'=>15,
				'trace'=>true,
				'encoding'=>'UTF-8',
				'exceptions'=>true,
			);
			
			$this->client 	= new SoapClient("http://efatura.uyumsoft.com.tr/Services/BasicIntegration?singleWsdl", $options);
			
			$this->userInfo["Username"] 	= $this->rSite->UYUMSOFT_WSDL_KULLANICI;
			$this->userInfo["Password"] 	= $this->rSite->UYUMSOFT_WSDL_SIFRE;
			
		}
		
		function fncFonksiyonlar(){
			$this->fncBaglan();
			return $this->client->__getFunctions(); 
		}
		
		function fncFonksiyonDetaylar(){
			$this->fncBaglan();
			return $this->client->__getTypes();
		}
		
		function fncGelenFaturalar($limit = 10, $gondere_vkn = null, $alici_vkn = null, $baslangicTarih = null, $bitisTarih = null, $crbaslangicTarih = null, $crbitisTarih = null, $fatura_no = null, $fatura_uuid = null){
			$this->fncBaglan();
			
			if(!is_null($crbaslangicTarih) AND strlen($crbaslangicTarih) > 2){
				$query["ExecutionStartDate"]	= $crbaslangicTarih . ($crbaslangicTarih==$crbitisTarih ? "T00:00:00" : "T23:59:59");	
			}
			if(!is_null($crbitisTarih) AND strlen($crbitisTarih) > 2){
				$query["ExecutionEndDate"]	= $crbitisTarih . "T23:59:59";
			}
			
			if(!is_null($fatura_no) AND strlen($fatura_no)> 2){
				$query["query"]["InvoiceNumbers"][0]		= $fatura_no;
			}
			
			if(!is_null($fatura_uuid) AND strlen($fatura_uuid) > 2){
				$query["query"]["InvoiceIds"]			= $fatura_uuid;
			}
			
			$CartItem = array('CartItem' => array('_' => '', 'CartGUID'=>$value1, 'Requestor'=>$value2));
			$CartMessage = array('CartItem' => array('_' => $CartItem, 'MouserPartNumber'=>$value3, 'Quantity'=>$value4));
			
			$params = array('userInfo' => $this->userInfo, 'query' => array('_' => $query, 'PageSize'=>50));
			var_dump2($params);
			try{
				$sonuc = $this->client->GetInboxInvoicesData($params);	
			} catch (Exception $e) {
				echo $e->getMessage(); die();
			}
			//var_dump2($this->client);
			if($sonuc->GetInboxInvoicesDataResult->IsSucceded == true){
				foreach($sonuc->GetInboxInvoicesDataResult->Value->Items as $key => $row_fatura){
					
					$plainXML 		= mungXML(trim($row_fatura->Data) );
					$arrayResult 	= json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
					
						$rows[$key]->GONDEREN			= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PartyName"]["cbc_Name"]);;
						$rows[$key]->GONDEREN_VKN 		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PartyIdentification"][0]["cbc_ID"]);
			            $rows[$key]->GONDEREN_ADRES		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PostalAddress"]["cbc_StreetName"]);
			            $rows[$key]->GONDEREN_BINA		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PostalAddress"]["cbc_BuildingName"]);
			            $rows[$key]->GONDEREN_KAPI_NO	= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PostalAddress"]["cbc_BuildingNumber"]);
			            $rows[$key]->GONDEREN_ILCE		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PostalAddress"]["cbc_CitySubdivisionName"]);
			            $rows[$key]->GONDEREN_IL		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PostalAddress"]["cbc_CityName"]);
			            $rows[$key]->GONDEREN_ULKE		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PostalAddress"]["cac_Country"]["cbc_Name"]);
			            $rows[$key]->GONDEREN_VD		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PartyTaxScheme"]["cac_TaxScheme"]["cbc_Name"]);
			            $rows[$key]->GONDEREN_TEL		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_Contact"]["cbc_Telephone"]);
			            $rows[$key]->GONDEREN_FAX		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_Contact"]["cbc_Telefax"]);
			            $rows[$key]->GONDEREN_EMAIL		= self::temizle($arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_Contact"]["cbc_ElectronicMail"]);
			            
			            $rows[$key]->ALICI				= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_PartyName"]["cbc_Name"]);;
						$rows[$key]->ALICI_VKN 			= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_PartyIdentification"][0]["cbc_ID"]);
			            $rows[$key]->ALICI_ADRES		= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_PostalAddress"]["cbc_StreetName"]);
			            $rows[$key]->ALICI_BINA			= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_PostalAddress"]["cbc_BuildingName"]);
			            $rows[$key]->ALICI_KAPI_NO		= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_PostalAddress"]["cbc_BuildingNumber"]);
			            $rows[$key]->ALICI_ILCE			= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_PostalAddress"]["cbc_CitySubdivisionName"]);
			            $rows[$key]->ALICI_IL			= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_PostalAddress"]["cbc_CityName"]);
			            $rows[$key]->ALICI_ULKE			= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_PostalAddress"]["cac_Country"]["cbc_Name"]);
			            $rows[$key]->ALICI_VD			= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_PartyTaxScheme"]["cac_TaxScheme"]["cbc_Name"]);
			            $rows[$key]->ALICI_TEL			= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_Contact"]["cbc_Telephone"]);
			            $rows[$key]->ALICI_FAX			= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_Contact"]["cbc_Telefax"]);
			            $rows[$key]->ALICI_EMAIL		= self::temizle($arrayResult["cac_AccountingCustomerParty"]["cac_Party"]["cac_Contact"]["cbc_ElectronicMail"]);            
			            
			            $rows[$key]->ODEME_GUNU			= self::temizle($arrayResult["cac_PaymentMeans"]["cbc_PaymentDueDate"]);
			            $rows[$key]->KAYIT_TARIH		= self::kayit_tarih($arrayResult["cac_AdditionalDocumentReference"]);
			            $rows[$key]->FATURA_NOT			= self::fatura_not($arrayResult["cbc_Note"]);
			            
						$rows[$key]->PROFILE_ID 		= $arrayResult["cbc_ProfileID"];
						$rows[$key]->FATURA_NO 			= $arrayResult["cbc_ID"];
						$rows[$key]->FATURA_UUID 		= $arrayResult["cbc_UUID"];
						$rows[$key]->FATURA_TARIH 		= $arrayResult["cbc_IssueDate"];
						$rows[$key]->FATURA_SAAT 		= self::saat($arrayResult["cbc_IssueTime"]);
						$rows[$key]->FATURA_TIP 		= $arrayResult["cbc_InvoiceTypeCode"];
						$rows[$key]->FATURA_KDV			= self::temizle($arrayResult["cac_TaxTotal"]["cac_TaxSubtotal"]["cbc_TaxAmount"]);
						$rows[$key]->FATURA_KDV_ORAN	= self::temizle($arrayResult["cac_TaxTotal"]["cac_TaxSubtotal"]["cbc_Percent"]);
						$rows[$key]->FATURA_KDV_KODU	= self::temizle($arrayResult["cac_TaxTotal"]["cac_TaxSubtotal"]["cac_TaxCategory"]["cac_TaxScheme"]["cbc_TaxTypeCode"]);
						$rows[$key]->FATURA_FIYAT		= self::temizle($arrayResult["cac_LegalMonetaryTotal"]["cbc_LineExtensionAmount"]);
						$rows[$key]->FATURA_ISKONTO		= self::temizle($arrayResult["cac_LegalMonetaryTotal"]["cbc_AllowanceTotalAmount"]);
						$rows[$key]->FATURA_KDVSIZ		= self::temizle($arrayResult["cac_LegalMonetaryTotal"]["cbc_TaxExclusiveAmount"]);
						$rows[$key]->FATURA_KDVLI		= self::temizle($arrayResult["cac_LegalMonetaryTotal"]["cbc_TaxInclusiveAmount"]);
						$rows[$key]->FATURA_TUTAR		= self::temizle($arrayResult["cac_LegalMonetaryTotal"]["cbc_PayableAmount"]);
						$rows[$key]->KALEM_SAYISI		= $arrayResult["cbc_LineCountNumeric"];
						
						$rows_satir = array();
						if($rows[$key]->KALEM_SAYISI == 1){
							$rows_satir[0]	= $arrayResult["cac_InvoiceLine"];
						} else {
							$rows_satir		= $arrayResult["cac_InvoiceLine"];
						}
						
						foreach($rows_satir as $key2 => $row_satir){
							$rows[$key]->PARCA[$key2]->ID 					= $row_satir["cbc_ID"];
							$rows[$key]->PARCA[$key2]->PARCA_KODU 			= self::temizle($row_satir["cac_Item"]["cac_SellersItemIdentification"]["cbc_ID"]);
							$rows[$key]->PARCA[$key2]->PARCA_ADI 			= self::temizle($row_satir["cac_Item"]["cbc_Name"] ." ". $row_satir["cbc_Note"]);
							$rows[$key]->PARCA[$key2]->KDV_ORAN	 			= self::temizle($row_satir["cac_TaxTotal"]["cac_TaxSubtotal"]["cbc_Percent"]);
							$rows[$key]->PARCA[$key2]->KDV	 				= self::temizle($row_satir["cac_TaxTotal"]["cac_TaxSubtotal"]["cbc_TaxAmount"]);
							$rows[$key]->PARCA[$key2]->ADET 				= self::temizle($row_satir["cbc_InvoicedQuantity"]);
							$rows[$key]->PARCA[$key2]->FIYAT 				= self::temizle($row_satir["cac_Price"]["cbc_PriceAmount"]);
							$rows[$key]->PARCA[$key2]->TUTAR 				= self::temizle($row_satir["cac_TaxTotal"]["cac_TaxSubtotal"]["cbc_TaxableAmount"]);
							//var_dump2($row_satir);
							foreach($row_satir["cac_AllowanceCharge"] as $key3 => $row_satir_iskonto){
								if(!is_numeric($key3)) continue;
								$rows[$key]->PARCA[$key2]->ISKONTO[$key3]->ORAN		= self::temizle($row_satir_iskonto["cbc_MultiplierFactorNumeric"]);
								$rows[$key]->PARCA[$key2]->ISKONTO[$key3]->TUTAR	= self::temizle($row_satir_iskonto["cbc_Amount"]);
							}
							
						}
					
				}
				
			}
			
			return $rows;
			
		}
		
		function fncGelenFaturalarList($limit = 100, $baslangicTarih = null, $bitisTarih = null, $crbaslangicTarih = null, $crbitisTarih = null, $InvoiceIds = null, $InvoiceNumbers = null){
			$this->fncBaglan();
			
			$params["userInfo"]	= $this->userInfo;
			if(!is_null($baslangicTarih) AND strlen($baslangicTarih) > 2){
				$params["query"]["ExecutionStartDate"]	= date('Y-m-d', strtotime($baslangicTarih . " -1 day" )) . "T23:59:59.000";	
			}
			if(!is_null($bitisTarih) AND strlen($bitisTarih) > 2){
				$params["query"]["ExecutionEndDate"]	= $bitisTarih . "T23:59:59.000";
			}
			
			if(!is_null($crbaslangicTarih) AND strlen($crbaslangicTarih) > 2){
				$params["query"]["CreateStartDate"]	= date('Y-m-d', strtotime($crbaslangicTarih . " -1 day" )) . "T23:59:59.000";	
			}
			if(!is_null($crbitisTarih) AND strlen($crbitisTarih) > 2){
				$params["query"]["CreateEndDate"]		= $crbitisTarih ."T23:59:59.000";
			}
			
			if(!is_null($InvoiceIds) AND strlen($InvoiceIds)> 2){
				$params["query"]["InvoiceIds"]			= $InvoiceIds;
			}
			
			if(!is_null($InvoiceNumbers) AND strlen($InvoiceNumbers) > 2){
				$params["query"]["InvoiceNumbers"]		= $InvoiceNumbers;
			}
			
			$params["query"]["SortColumn"]		= "CreateDate";
			$params["query"]["SortMode"]		= "Descending";
			$params["query"]["PageSize"]		= $limit;
			
			try{
				$sonuc = $this->client->GetInboxInvoiceList($params);	
			} catch (Exception $e) {
				echo $e->getMessage(); die();
			}
			
			if($sonuc->GetInboxInvoiceListResult->IsSucceded == true){
				foreach($sonuc->GetInboxInvoiceListResult->Value->Items as $key => $row_fatura){					
					$rows[$key]->GONDEREN			= $row_fatura->TargetTitle;
					$rows[$key]->GONDEREN_VKN 		= $row_fatura->TargetTcknVkn;
		            
		            $rows[$key]->KAYIT_TARIH		= self::tarih($row_fatura->CreateDateUtc);
		            $rows[$key]->STATUS				= $row_fatura->Status;
		            $rows[$key]->ENVELOPESTATUS 	= $row_fatura->EnvelopeStatus;
		            
					$rows[$key]->PROFILE_ID 		= $row_fatura->Type;
					$rows[$key]->FATURA_NO 			= $row_fatura->InvoiceId;
					$rows[$key]->FATURA_UUID 		= $row_fatura->DocumentId;
					$rows[$key]->FATURA_TARIH 		= self::tarih($row_fatura->ExecutionDate);
					$rows[$key]->FATURA_TIP 		= $row_fatura->Type;
					$rows[$key]->FATURA_KDV			= $row_fatura->TaxTotal;
					$rows[$key]->FATURA_KDVSIZ		= $row_fatura->TaxExclusiveAmount; 
					$rows[$key]->FATURA_TUTAR		= $row_fatura->PayableAmount;	
				}
				
			}
			
			return $rows;
			
		}
		
		function fncGelenFatura($uuid){
			$this->fncBaglan();
			
			$params["userInfo"]		= $this->userInfo;
			$params["invoiceId"] 	= $uuid;
			
			try{
				$sonuc = $this->client->GetInboxInvoice($params);	
			} catch (Exception $e) {
				echo $e->getMessage(); die();
			}
			
			if($sonuc->GetInboxInvoiceResult->IsSucceded == true){
				$fatura = $sonuc->GetInboxInvoiceResult->Value->Invoice;
			}
			
			$row->GONDEREN			= $fatura->AccountingSupplierParty->Party->PartyName->Name->_;
			$row->GONDEREN_VKN 		= is_array($fatura->AccountingSupplierParty->Party->PartyIdentification) ? $fatura->AccountingSupplierParty->Party->PartyIdentification[0]->ID->_ : $fatura->AccountingSupplierParty->Party->PartyIdentification->ID->_;
		    $row->GONDEREN_ADRES	= $fatura->AccountingSupplierParty->Party->PostalAddress->StreetName->_;
		    $row->GONDEREN_BINA		= $fatura->AccountingSupplierParty->Party->PostalAddress->BuildingName->_;
		    $row->GONDEREN_KAPI_NO	= $fatura->AccountingSupplierParty->Party->PostalAddress->BuildingNumber->_;
		    $row->GONDEREN_ILCE		= $fatura->AccountingSupplierParty->Party->PostalAddress->CitySubdivisionName->_;
		    $row->GONDEREN_IL		= $fatura->AccountingSupplierParty->Party->PostalAddress->CityName->_;
		    $row->GONDEREN_ULKE		= $fatura->AccountingSupplierParty->Party->PostalAddress->Country->Name->_;
		    $row->GONDEREN_VD		= $fatura->AccountingSupplierParty->Party->PartyTaxScheme->TaxScheme->Name->_;
		    $row->GONDEREN_TEL		= $fatura->AccountingSupplierParty->Party->Contact->Telephone->_;
		    $row->GONDEREN_FAX		= $fatura->AccountingSupplierParty->Party->Contact->Telefax->_;
		    $row->GONDEREN_EMAIL	= $fatura->AccountingSupplierParty->Party->Contact->ElectronicMail->_;
		    
		    $row->ALICI				= $fatura->AccountingCustomerParty->Party->PartyName->Name->_;
		    $row->ALICI_VKN 		= is_array($fatura->AccountingCustomerParty->Party->PartyIdentification) ? $fatura->AccountingCustomerParty->Party->PartyIdentification[0]->ID->_ : $fatura->AccountingCustomerParty->Party->PartyIdentification->ID->_;
		    $row->ALICI_ADRES		= $fatura->AccountingCustomerParty->Party->PostalAddress->StreetName->_;
		    $row->ALICI_BINA		= $fatura->AccountingCustomerParty->Party->PostalAddress->BuildingName->_;
		    $row->ALICI_KAPI_NO		= $fatura->AccountingCustomerParty->Party->PostalAddress->BuildingNumber->_;
		    $row->ALICI_ILCE		= $fatura->AccountingCustomerParty->Party->PostalAddress->CitySubdivisionName->_;
		    $row->ALICI_IL			= $fatura->AccountingCustomerParty->Party->PostalAddress->CityName->_;
		    $row->ALICI_ULKE		= $fatura->AccountingCustomerParty->Party->PostalAddress->Country->Name->_;
		    $row->ALICI_VD			= trim($fatura->AccountingCustomerParty->Party->PartyTaxScheme->TaxScheme->Name->_);
		    $row->ALICI_TEL			= $fatura->AccountingCustomerParty->Party->Contact->Telephone->_;
		    $row->ALICI_FAX			= $fatura->AccountingCustomerParty->Party->Contact->Telefax->_;
		    $row->ALICI_EMAIL		= $fatura->AccountingCustomerParty->Party->Contact->ElectronicMail->_;            
		    
		    $row->VADE_TARIH		= $fatura->PaymentMeans->PaymentDueDate->_;
		    //$row->KAYIT_TARIH		= self::kayit_tarih_($fatura->AdditionalDocumentReference);
		    //$row->FATURA_NOT		= self::fatura_not_($fatura->Note);
		    
			$row->PROFILE_ID 		= $fatura->ProfileID->_;
			$row->FATURA_NO 		= $fatura->ID->_;
			$row->FATURA_UUID 		= $fatura->UUID->_;
			$row->FATURA_TARIH 		= $fatura->IssueDate->_;
			$row->FATURA_SAAT 		= self::saat($fatura->IssueTime->_);
			$row->FATURA_TIP 		= $fatura->InvoiceTypeCode->_;
			$row->FATURA_KDV		= $fatura->TaxTotal->TaxSubtotal->TaxAmount->_;
			$row->FATURA_KDV_ORAN	= $fatura->TaxTotal->TaxSubtotal->Percent->_;
			$row->FATURA_KDV_KODU	= $fatura->TaxTotal->TaxSubtotal->TaxCategory->TaxScheme->TaxTypeCode->_;
			$row->FATURA_FIYAT		= $fatura->LegalMonetaryTotal->LineExtensionAmount->_;
			$row->FATURA_ISKONTO	= $fatura->LegalMonetaryTotal->AllowanceTotalAmount->_;
			$row->FATURA_KDVSIZ		= $fatura->LegalMonetaryTotal->TaxExclusiveAmount->_;
			$row->FATURA_KDVLI		= $fatura->LegalMonetaryTotal->TaxInclusiveAmount->_;
			$row->FATURA_TUTAR		= $fatura->LegalMonetaryTotal->PayableAmount->_;
			$row->KALEM_SAYISI		= $fatura->LineCountNumeric->_;
			
			if($row->KALEM_SAYISI == 1){ 
				$rows_satir[0]	= $fatura->InvoiceLine;
			} else {
				$rows_satir		= $fatura->InvoiceLine;
			}
			
			foreach($rows_satir as $key2 => $row_satir){
				
				$row->PARCA[$key2]->ID 				= $row_satir->ID->_;
				$row->PARCA[$key2]->PARCA_KODU 		= $row_satir->Item->SellersItemIdentification->ID->_;
				$row->PARCA[$key2]->PARCA_ADI 		= $row_satir->Item->Name->_ . " " . $row_satir->Item->Description->_;
				$row->PARCA[$key2]->KDV_ORAN	 	= $row_satir->TaxTotal->TaxSubtotal->Percent->_;
				$row->PARCA[$key2]->KDV	 			= $row_satir->TaxTotal->TaxSubtotal->TaxAmount->_;
				$row->PARCA[$key2]->ADET 			= $row_satir->InvoicedQuantity->_;
				$row->PARCA[$key2]->TUTAR 			= $row_satir->Price->PriceAmount->_;
				foreach($row_satir->AllowanceCharge as $key3 => $row_satir_iskonto){
					if(!is_numeric($key3)) continue;
					$row->PARCA[$key2]->ISKONTO[$key3]->ORAN	= $row_satir_iskonto->MultiplierFactorNumeric->_;
					$row->PARCA[$key2]->ISKONTO[$key3]->TUTAR	= $row_satir_iskonto->Amount->_;
				}
				
			}
			
			return $row;
			
		}
		
		function fncGelenFaturaGoster($uuid){
			$this->fncBaglan();
			
			$params["userInfo"]		= $this->userInfo;
			$params["invoiceId"] 	= $uuid;
			
			try{
				$sonuc = $this->client->GetInboxInvoicePdf($params);	
			} catch (Exception $e) {
				echo $e->getMessage(); die();
			}
			
			if($sonuc->GetInboxInvoicePdfResult->IsSucceded == true){
				$fatura = $sonuc->GetInboxInvoicePdfResult->Value->Data;
			}
			
			return $fatura;
			
		}
		
		function fncGidenFaturaGoster($uuid){
			$this->fncBaglan();
			
			$params["userInfo"]		= $this->userInfo;
			$params["invoiceId"] 	= $uuid;
			
			try{
				$sonuc = $this->client->GetOutboxInvoicePdf($params);	
			} catch (Exception $e) {
				echo $e->getMessage(); die();
			}
			
			if($sonuc->GetOutboxInvoicePdfResult->IsSucceded == true){
				$fatura = $sonuc->GetOutboxInvoicePdfResult->Value->Data;
			}
			
			return $fatura;
			
		}
		
	    
	}

?>