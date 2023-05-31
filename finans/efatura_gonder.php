<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	//@ini_set('default_charset', 'UTF-8');
	
	$row 				= $cSubData->getTalep($_REQUEST);
	$row_cari			= $cSubData->getTalepCari($_REQUEST);
	$rows_parca			= $cSubData->getTalepParcalar($_REQUEST);
	
	// Wsdl Bilgileri
    $row_wsdl->URL 			= "http://efatura-test.uyumsoft.com.tr/Services/BasicIntegration?singleWsdl";
	$row_wsdl->KULLANICI 	= "Uyumsoft";
	$row_wsdl->SIFRE		= "Uyumsoft";
	
	// Gönderici Bilgileri
	$row_site->FIRMA_ADI	= "PASHA Motorlu Araçlar San. Tic. Ltd. Şti.";
	$row_site->ADRES		= "Muratpaşa Mh. Rami Kışla Cad. No:97/1-1 Bayrampaşa / İSTANBUL";
	$row_site->TCK			= "9000068418";
	$row_site->VD			= "BAYRAMPAŞA";
	$row_site->FIRMA_NO		= "1/17";
	$row_site->FIRMA_ILCE	= "BAYRAMPAŞA";
	$row_site->FIRMA_IL		= "İSTANBUL";
		
	// Fatura Bilgileri
	$row->FATURA_TARIH		= date("Y-m-d");
	$row->FATURA_SAAT		= date("H:i:s");	
	$row->FATURA_KDV		= 18;
	$row->ACIKLAMA			= $row->ID; 
	$row->FATURA_ISIM		= "{$row->PLAKA}_{$row->ID}_PASHAOTO"; 
	$row->FATURA_NOT		= $row->PLAKA;
	$row->FATURA_KDV_TUTAR	= FormatSayi::nokta2($row->FATURA_TUTAR * ($row->FATURA_KDV / 100));
	$row->FATURA_NET_TUTAR	= FormatSayi::nokta2($row->FATURA_TUTAR - $row->FATURA_KDV_TUTAR);
		
	if(strlen($row_cari->TCK) == 10) {
		$row_cari->TCKN_VKN	= "VKN";
		$xml_cari	='						
			<PartyName>
			<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_cari->CARI.'</Name>
			</PartyName>';
	} else if(strlen($row_cari->TCK) == 11) {
		$row_cari->TCKN_VKN	= "TCKN";
		$xml_cari	='						
			<Person>
			<FirstName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_cari->AD.'</FirstName>
			<FamilyName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_cari->SOYAD.'</FamilyName>
		      </Person>';
	}
	
	//var_dump2($row_cari);die();
	
	$row_wsdl->KALEM = "";
	foreach($rows_parca as $key => $row_parca){
		$row_wsdl->KALEM.= '
						<InvoiceLine xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
							<ID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">1</ID>
							<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">Satır Notu</Note>
							<InvoicedQuantity unitCode="NIU" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">1</InvoicedQuantity>
							<LineExtensionAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_parca->FIYAT.'</LineExtensionAmount>
							
							<AllowanceCharge>
								<ChargeIndicator xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">false</ChargeIndicator>
								<Amount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></Amount>
							</AllowanceCharge>
							
							<TaxTotal>
								<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></TaxAmount>
								<TaxSubtotal>
									<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. ($row_parca->TUTAR - $row_parca->ISKONTOLU) .'</TaxAmount>
									<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. 18 .'</Percent>
									<TaxCategory>
										<TaxExemptionReason xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">12345 sayılı kanuna istinaden</TaxExemptionReason>
										<TaxScheme>
											<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">KDV</Name>
											<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">0015</TaxTypeCode>
										</TaxScheme>
									</TaxCategory>
								</TaxSubtotal>
							</TaxTotal>
							<Item>
								<Description xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">Açıklama 1</Description>
								<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_parca->PARCA_ADI.'</Name>
								<BrandName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></BrandName>
								<ModelName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></ModelName>
								<BuyersItemIdentification>
									<ID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></ID>
								</BuyersItemIdentification>
								<SellersItemIdentification>
									<ID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></ID>
								</SellersItemIdentification>
								<ManufacturersItemIdentification>
									<ID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></ID>
								</ManufacturersItemIdentification>
							</Item>
							<Price>
								<PriceAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_parca->TUTAR.'</PriceAmount>
							</Price>
						</InvoiceLine>
						';
	}
	
	$row_wsdl->XML	='<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
	<s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		<SendInvoice xmlns="http://tempuri.org/">
			<userInfo Username="'.$row_wsdl->KULLANICI.'" Password="'.$row_wsdl->SIFRE.'"/>
			<invoices>
				<InvoiceInfo LocalDocumentId="">
					<Invoice>
						<ProfileID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">TICARIFATURA</ProfileID>
						<ID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"/>
						<CopyIndicator xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">false</CopyIndicator>
						<IssueDate xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_TARIH.'</IssueDate>
						<IssueTime xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_SAAT.'</IssueTime>
						<InvoiceTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">SATIS</InvoiceTypeCode>
						<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_NOT.'</Note>
						<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></Note>					
						<DocumentCurrencyCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">TRY</DocumentCurrencyCode>
						<PricingCurrencyCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">TRY</PricingCurrencyCode>
						<LineCountNumeric xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">2</LineCountNumeric>
						<OrderReference xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
						    <ID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$rezervno.'</ID>
							<IssueDate xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_TARIH.'</IssueDate>
						</OrderReference>
						<AccountingSupplierParty xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
							<Party>
								<PartyIdentification>
									<ID schemeID="VKN" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_site->TCK.'</ID>
								</PartyIdentification>
								<PartyIdentification>
									<ID schemeID="MERSISNO" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></ID>
								</PartyIdentification>
								<PartyIdentification>
									<ID schemeID="TICARETSICILNO" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></ID>
								</PartyIdentification>
								<PartyName>
									<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_site->FIRMA_ADI.'</Name>
								</PartyName>
								<PostalAddress>
									<Room xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_site->FIRMA_NO.'</Room>
									<StreetName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_site->ADRES.'</StreetName>
									<BuildingNumber xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_site->FIRMA_NO.'</BuildingNumber>
									<CitySubdivisionName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_site->FIRMA_ILCE.'</CitySubdivisionName>
									<CityName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_site->FIRMA_IL.'</CityName>
									<Country>
										<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">Türkiye</Name>
									</Country>
								</PostalAddress>
								<PartyTaxScheme>
									<TaxScheme>
										<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_site->VD.'</Name>
									</TaxScheme>
								</PartyTaxScheme>
							</Party>
						</AccountingSupplierParty>
						<AccountingCustomerParty xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
							<Party>
								<PartyIdentification>
									<ID schemeID="'.$row_cari->TCKN_VKN.'" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_cari->TCK.'</ID>
								</PartyIdentification>
								'.$xml_cari.'
								<PostalAddress>
									<Room xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></Room>
									<StreetName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_cari->ADRES.'</StreetName>
									<BuildingNumber xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></BuildingNumber>
									<CitySubdivisionName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></CitySubdivisionName>
									<CityName xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></CityName>
									<Country>
										<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">Türkiye</Name>
									</Country>
								</PostalAddress>
								<PartyTaxScheme>
									<TaxScheme>
										<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_cari->VD.'</Name>
									</TaxScheme>
								</PartyTaxScheme>
								<Contact>
									<Telephone xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_cari->CEPTEL.'</Telephone>
									<Telefax xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></Telefax>
									<ElectronicMail xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_cari->MAIL.'</ElectronicMail>
								</Contact>
							</Party>
						</AccountingCustomerParty>					
						<TaxTotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
							<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_KDV_TUTAR.'</TaxAmount>
							<TaxSubtotal>
								<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_KDV_TUTAR.'</TaxAmount>
								<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_KDV.'</Percent>
								<TaxCategory>
									<TaxScheme>
										<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">KDV</Name>
										<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">0015</TaxTypeCode>
									</TaxScheme>
								</TaxCategory>
							</TaxSubtotal>
						</TaxTotal>
						
						<LegalMonetaryTotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
							<LineExtensionAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_NET_TUTAR.'</LineExtensionAmount>
							<TaxExclusiveAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_NET_TUTAR.'</TaxExclusiveAmount>
							<TaxInclusiveAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_TUTAR.'</TaxInclusiveAmount>
							<AllowanceTotalAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></AllowanceTotalAmount>
							<PayableAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_TUTAR.'</PayableAmount>
						</LegalMonetaryTotal>
						'. $row_wsdl->KALEM .'
					</Invoice>
					<TargetCustomer '.$row_cari->TCKN_VKN.'="'.$row_cari->TCK.'" Alias="defaultpk" Title="'.$row->FATURA_ISIM.'"/>
					<EArchiveInvoiceInfo DeliveryType="Electronic"/>
					<Scenario>Automated</Scenario>
				</InvoiceInfo>
			</invoices>
		</SendInvoice>
	</s:Body>
	</s:Envelope>';

	//var_dump2($row_wsdl->XML);
	
    $row_wsdl->BASLIK 		= array("Content-type: text/xml;charset=\"utf-8\"",
   									"Accept: text/xml",
   									"Cache-Control: no-cache",
   									"Pragma: no-cache",
				                    "Content-length: ".strlen($row_wsdl->XML),
				                    "SOAPAction: http://tempuri.org/IBasicIntegration/SendInvoice" 
				                	);
				                	
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $row_wsdl->URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $row_wsdl->KULLANICI.":".$row_wsdl->SIFRE);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPGET, false);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $row_wsdl->XML);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $row_wsdl->BASLIK); 
   	$result = curl_exec($ch); 
    curl_close($ch);
	
    $result = str_replace("<s:Body","<body",$result);
	$result = str_replace("</s:Body","</body>",$result);
    $result = simplexml_load_string($result);

    $sonuc	= $result->body->SendInvoiceResponse->SendInvoiceResult["IsSucceded"];
	$hata	= $result->body->SendInvoiceResponse->SendInvoiceResult["Message"];
	$efatid	= $result->body->SendInvoiceResponse->SendInvoiceResult->Value["Id"];
	$efatno	= $result->body->SendInvoiceResponse->SendInvoiceResult->Value["Number"];

	if($sonuc=='true') {
		echo "<p style='text-align:center; font-size:25px; font-weight:600; margin-top:25px; font-family:Arial, Helvetica, sans-serif;color:#090;'> FATURA BAŞARIYLA OLUŞTURULDU </p><p style='text-align:center;font-family:Arial, Helvetica, sans-serif; '><b>Fatur No:</b> $efatno<br>Fatur ID:</b> $efatid</p>";
	} else {
		echo "<p style='text-align:center; font-size:25px; font-weight:600;margin-top:25px; font-family:Arial, Helvetica, sans-serif; color:red;'> İŞLEM SIRASINDA HATA OLUŞTU </p><p style='text-align:center;font-family:Arial, Helvetica, sans-serif; '><b>Hata:</b>". $hata ."</p>";
	}

