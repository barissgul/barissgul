<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	//session_kontrol();
	ini_set('max_execution_time', 300);
	
	$rows_banka			= $cSubData->getBankalar();
	//var_dump2($_SESSION);
	
	$xml = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');
	
	foreach ($xml->Currency as $Currency) {
	    
	    if ($Currency['Kod'] == "USD") {
	        // USD ALIŞ-SATIŞ
	        $DOLAR_ALIS 			= $Currency->ForexBuying;
	        $DOLAR_SATIS 			= $Currency->ForexSelling;
	    	// USD EFEKTİF ALIŞ-SATIŞ    
	        $DOLAR_ALIS_EFEKTIF 	= $Currency->BanknoteBuying;
	        $DOLAR_SATIS_EFEKTIF 	= $Currency->BanknoteSelling;
	    }
	    
	    if ($Currency['Kod'] == "EUR") {
	        // EURO ALIŞ-SATIŞ
	        $EURO_ALIS 				= $Currency->ForexBuying;
	        $EURO_SATIS 			= $Currency->ForexSelling;
	        // EURO EFEKTİF ALIŞ-SATIŞ
	        $EURO_ALIS_EFEKTIF 		= $Currency->BanknoteBuying;
	        $EURO_SATIS_EFEKTIF 	= $Currency->BanknoteSelling;
	    }
	    
	    if ($Currency['Kod'] == "GBP") {
	        // STERLİN ALIŞ-SATIŞ
	        $STERLIN_ALIS 			= $Currency->ForexBuying;
	        $STERLIN_SATIS 			= $Currency->ForexSelling;
	        // STERLİN EFEKTİF ALIŞ-SATIŞ
	        $STERLIN_ALIS_EFEKTIF 	= $Currency->BanknoteBuying;
	        $STERLIN_SATIS_EFEKTIF 	= $Currency->BanknoteSelling;
	    }
	    
	}
	
	/*
	$filtre = array();
	$sql = "SELECT * FROM DOVIZ WHERE DOVIZ = 'DOLAR' AND TARIH = :TARIH";
	$filtre[":TARIH"] = FormatTarih::nokta2db(trim($xml['Tarih']));
	$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
	*/
	if($xml['Tarih']){
		$filtre = array();
		$sql = "REPLACE INTO DOVIZ SET 	TARIH 		= :TARIH,
										DOVIZ 		= 'DOLAR', 
										ALIS 		= :ALIS, 
										SATIS		= :SATIS,
										ALIS_EFEK	= :ALIS_EFEK, 
										SATIS_EFEK	= :SATIS_EFEK
										";
		$filtre[":TARIH"] 			= FormatTarih::nokta2db(trim($xml['Tarih']));
		$filtre[":ALIS"] 			= $DOLAR_ALIS;
		$filtre[":SATIS"] 			= $DOLAR_SATIS;
		$filtre[":ALIS_EFEK"] 		= $DOLAR_ALIS_EFEKTIF;
		$filtre[":SATIS_EFEK"] 		= $DOLAR_SATIS_EFEKTIF;
		$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
		
		$filtre = array();
		$sql = "REPLACE INTO DOVIZ SET 	TARIH 		= :TARIH,
										DOVIZ 		= 'EURO', 
										ALIS 		= :ALIS, 
										SATIS		= :SATIS,
										ALIS_EFEK 	= :ALIS_EFEK, 
										SATIS_EFEK	= :SATIS_EFEK
										";
		$filtre[":TARIH"] 			= FormatTarih::nokta2db(trim($xml['Tarih']));
		$filtre[":ALIS"] 			= $EURO_ALIS;
		$filtre[":SATIS"] 			= $EURO_SATIS;
		$filtre[":ALIS_EFEK"] 		= $EURO_ALIS_EFEKTIF;
		$filtre[":SATIS_EFEK"] 		= $EURO_SATIS_EFEKTIF;
		$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
		
		$filtre = array();
		$sql = "REPLACE INTO DOVIZ SET 	TARIH 		= :TARIH,
										DOVIZ 		= 'STERLIN', 
										ALIS 		= :ALIS, 
										SATIS		= :SATIS,
										ALIS_EFEK 	= :ALIS_EFEK, 
										SATIS_EFEK	= :SATIS_EFEK
										";
		$filtre[":TARIH"] 			= FormatTarih::nokta2db(trim($xml['Tarih']));
		$filtre[":ALIS"] 			= $STERLIN_ALIS;
		$filtre[":SATIS"] 			= $STERLIN_SATIS;
		$filtre[":ALIS_EFEK"] 		= $STERLIN_ALIS_EFEKTIF;
		$filtre[":SATIS_EFEK"] 		= $STERLIN_SATIS_EFEKTIF;
		$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
		
		$filtre = array();
		$sql = "INSERT INTO ENTEGRASYON SET TIP_ID 			= :TIP_ID,
											NO	 			= :NO, 
											NO_ID 			= :NO_ID, 
											DURUM			= :DURUM,
											ACIKLAMA		= :ACIKLAMA,
											GIDEN_XML		= :GIDEN_XML,
											GELEN_XML		= :GELEN_XML,
											TARIH			= NOW(),
											KULLANICI_ID	= :KULLANICI_ID
											";
		$filtre[":TIP_ID"] 			= 4;
		$filtre[":NO"] 				= 0;
		$filtre[":NO_ID"] 			= 0;
		$filtre[":DURUM"] 			= 1;
		$filtre[":ACIKLAMA"] 		= date("Y-m-d") . " tarihinde döviz alındı";
		$filtre[":GIDEN_XML"] 		= "";
		$filtre[":GELEN_XML"] 		= $xml;
		$filtre[":KULLANICI_ID"] 	= $_SESSION["kullanici_id"];
		$ENTEGRASYON_ID = $cdbPDO->lastInsertId($sql, $filtre);
		
		echo "Alındı";
	} 
	
	