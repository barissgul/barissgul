<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows = $cUyumsoft->fncGelenFaturalarList(); var_dump2($rows);die();
	//$rows = $cUyumsoft->fncGelenFatura("D767B79A-8E86-4AB2-8FE3-39B4BB760CD2"); var_dump2($rows);die();
	
	
	
	$fatura = $cUyumsoft->fncGelenFaturaGoster();
	//var_dump2($fatura);
	header('Content-type: application/pdf');
	//header('Content-Disposition: attachment; filename="service.pdf"');
	echo ($fatura);
	die();
	
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
	
	
	// Birincisi
	
	 
	
	$client 	= new SoapClient("http://efatura.uyumsoft.com.tr/Services/BasicIntegration?singleWsdl", $options);
	
	$client->__getTypes();      
	$client->__getFunctions(); 
	
	$params["userInfo"]["Username"] 	= 'PashaMotorlu_WebServis';
	$params["userInfo"]["Password"] 	= 'Jz$qEbcH';
	$params["query"] = 1;
	$params["query"] = 1;
	
	try{
		$sonuc = $client->GetInboxInvoicesData($params);	
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	
	if($sonuc->GetInboxInvoicesDataResult->IsSucceded == true){
		foreach($sonuc->GetInboxInvoicesDataResult->Value->Items as $key => $row_fatura){
			
			$plainXML 		= mungXML(trim($row_fatura->Data) );
			$arrayResult 	= json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
			$rows[$key]->PROFILE_ID 		= $arrayResult["cbc_ProfileID"];
			$rows[$key]->FATURA_KESEN 		= $arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PartyName"]["cbc_Name"];
			$rows[$key]->TCK 				= $arrayResult["cac_AccountingSupplierParty"]["cac_Party"]["cac_PartyIdentification"][0]["cbc_ID"];
			$rows[$key]->FATURA_NO 			= $arrayResult["cbc_ID"];
			$rows[$key]->FATURA_ID 			= $arrayResult["cbc_UUID"];
			$rows[$key]->FATURA_TARIH 		= $arrayResult["cbc_IssueDate"];
			$rows[$key]->FATURA_SAAT 		= $arrayResult["cbc_IssueTime"];
			$rows[$key]->FATURA_TIP 		= $arrayResult["cbc_InvoiceTypeCode"];
			$rows[$key]->FATURA_KDV			= $arrayResult["cac_TaxTotal"]["cac_TaxSubtotal"]["cbc_TaxAmount"];
			$rows[$key]->FATURA_KDV_ORAN	= $arrayResult["cac_TaxTotal"]["cac_TaxSubtotal"]["cbc_Percent"];
			$rows[$key]->FATURA_TUTAR		= $arrayResult["cac_LegalMonetaryTotal"]["cbc_PayableAmount"];
			$rows[$key]->KALEM_SAYISI		= $arrayResult["cbc_LineCountNumeric"];
			
			if($rows[$key]->KALEM_SAYISI == 1){
				$rows[$key]->PARCA[0]->ID 					= $arrayResult["cac_InvoiceLine"]["cbc_ID"];
				$rows[$key]->PARCA[0]->PARCA_KODU 			= trim($arrayResult["cac_InvoiceLine"]["cac_Item"]["cbc_Name"]);
				$rows[$key]->PARCA[0]->PARCA_ADI 			= $arrayResult["cac_InvoiceLine"]["cbc_Note"];
				$rows[$key]->PARCA[0]->ADET 				= $arrayResult["cac_InvoiceLine"]["cbc_InvoicedQuantity"];
				$rows[$key]->PARCA[0]->TUTAR 				= $arrayResult["cac_InvoiceLine"]["cbc_LineExtensionAmount"];
			} else {
				
				foreach($arrayResult["cac_InvoiceLine"] as $key2 => $row_satir){
					$rows[$key]->PARCA[$key2]->ID 					= $row_satir["cbc_ID"];
					$rows[$key]->PARCA[$key2]->PARCA_KODU 			= $row_satir["cac_Item"]["cbc_Name"];
					$rows[$key]->PARCA[$key2]->PARCA_ADI 			= $row_satir["cbc_Note"];
					$rows[$key]->PARCA[$key2]->ADET 				= $row_satir["cbc_InvoicedQuantity"];
					$rows[$key]->PARCA[$key2]->TUTAR 				= $row_satir["cac_Price"]["cbc_PriceAmount"];
					
				}
				
			}
			
		}
		
	}
	
	
	var_dump2($rows);

