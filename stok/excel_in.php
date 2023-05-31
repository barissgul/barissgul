<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	header('Content-Type: text/html; charset=utf-8');
	/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ERROR | E_WARNING);
	*/
	ini_set('max_execution_time', 3000);
	ini_set("memory_limit", "-1");
	set_time_limit(0);
	
	$Alfabe = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	
	$filtre = array();
	$sql = "SELECT * FROM EXCEL WHERE ID = :ID AND KOD = :KOD";
	$filtre[":ID"] 		= $_REQUEST['id'];
	$filtre[":KOD"] 	= $_REQUEST['kod'];
	$row_excel = $cdbPDO->row($sql, $filtre);
	
	$excel_adi = $row_excel->EXCEL;
	$excel_tur = $row_excel->TUR;
	$TEDARIKCI_ID = $row_excel->TEDARIKCI_ID;
	
	
	if(is_null($row_excel->ID)){
		echo "Dosya bulunamadı!";
		die();
	}
	
	if($row_excel->ONAY == 0){
		echo "Liste onaylanmamış!";
		die();
	}
	
	if(strlen($excel_adi) < 10 OR !in_array($excel_tur,array('STOK'))){
		echo "<b>Dosya Adı:</b> $excel_adi, <b>Dosya Türü:</b> $excel_tur <br> izin verimeyen dosya türü!";
		die();
	}
	
	$excel_adi = $cSabit->imgPathFolder("excel") . date("/Y/m/") . $excel_adi;
	
	try {
	    $excel_uzanti 	= PHPExcel_IOFactory::identify($excel_adi);
	    $objReader 		= PHPExcel_IOFactory::createReader($excel_uzanti);
	    $objPHPExcel 	= $objReader->load($excel_adi);
	} catch(Exception $e) {
	    die('Dosya Çalıştırma Hatası: "'.pathinfo($excel_adi,PATHINFO_BASENAME).'": '.$e->getMessage());
	}
	
	/*
	$sheet = $objPHPExcel->getSheet(0);
	echo $highestRow = $sheet->getHighestRow();
	echo $highestColumn = $sheet->getHighestColumn();
	*/
	
	$rows = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
	//var_dump2($rows);
	
	$row_cari 	= $cSubData->getCari(array("id"=>$TEDARIKCI_ID));
	$rows_pm 	= $cSubData->getParcaMarkalar(array());	
	//$rows_marka = $cSubData->getAracMarkalar(array());
	$rows_yp 	= $cSubData->getStokParcalar();
	
	$arr_eklenen = array();
	foreach($rows as $key => $row){
		if($key === 0) continue;
		if($key === 1) continue;
		$row_o = (object) $row;
		//echo $row->B;
		
		if(strlen(trim($row_o->A)) <= 0) break;
		$row_o->B = trim(fncYaziBuyult(str_replace("\xc2\xa0", '', str_replace('&nbsp',' ',$row_o->B))));
		$row_o->C = trim(fncYaziBuyult(str_replace("\xc2\xa0", '', str_replace('&nbsp',' ',$row_o->C))));
		$row_o->D = trim(fncYaziBuyult(str_replace("\xc2\xa0", '', str_replace('&nbsp',' ',$row_o->D))));
		/*
		if(trim($row_o->N) == "OTOKOC") $TEDARIKCI_ID = 2;
		else $TEDARIKCI_ID = 0;
		*/
		if(in_array($row_o->B."_".$row_o->C, $arr_eklenen)) continue;
		
		if(is_null($rows_yp[$row_o->B."_".$row_o->C]->ID)){
			$arr_eklenen[] = $row_o->B."_".$row_o->C;
			
			$filtre = array();
			$sql = "INSERT INTO STOK SET 	PARCA_MARKA 		= :PARCA_MARKA, 
											PARCA_MARKA_ID		= :PARCA_MARKA_ID,
											KODU	 			= :KODU, 
											OEM_KODU 			= :OEM_KODU, 
											MUADIL_KODUS		= :MUADIL_KODUS,
											STOK				= :STOK,
											ALIS_FIYAT			= :ALIS_FIYAT,
											SATIS_FIYAT 		= :SATIS_FIYAT, 
											PARA_BIRIM			= :PARA_BIRIM, 
											BIRIM 				= :BIRIM, 
											ADET 				= :ADET, 
											DURUM 				= :DURUM,
											KAYIT_YAPAN			= :KAYIT_YAPAN, 
											TARIH				= NOW(),
											EXCEL_ID			= :EXCEL_ID
											";
			$filtre[":PARCA_MARKA_ID"]	= $rows_pm[trim($row_o->A)]->PARCA_MARKA_ID;;
			$filtre[":PARCA_MARKA"]		= trim($row_o->A);
			$filtre[":KODU"]			= trim($row_o->B);
			$filtre[":OEM_KODU"]		= trim($row_o->C);
			$filtre[":MUADIL_KODUS"]	= $row_o->D;
			$filtre[":STOK"]			= trim($row_o->E);
			$filtre[":ALIS_FIYAT"]		= trim($row_o->F);
			$filtre[":SATIS_FIYAT"]		= trim($row_o->F); //str_replace(',','.',str_replace('.','',$row_o->F));
			$filtre[":PARA_BIRIM"]		= "TL"; //$row_o->H;
			$filtre[":BIRIM"]			= "ADET"; //$row_o->I;
			$filtre[":ADET"]			= $row_o->G;
			$filtre[":DURUM"]			= $row_o->H;
			$filtre[":KAYIT_YAPAN"]		= $_SESSION['kullanici'];
			$filtre[":EXCEL_ID"]		= $row_excel->ID;
			$cdbPDO->rowsCount($sql, $filtre);
			//echo $cdbPDO->getSQL($sql, $filtre) . ";<br>";
			$YENI++;	
			
		} else {
			
			$filtre = array();
			$sql = "UPDATE STOK SET PARCA_MARKA 		= :PARCA_MARKA, 
									PARCA_MARKA_ID		= :PARCA_MARKA_ID,
									KODU	 			= :KODU, 
									OEM_KODU 			= :OEM_KODU, 
									MUADIL_KODUS		= :MUADIL_KODUS,
									STOK				= :STOK,
									ALIS_FIYAT			= :ALIS_FIYAT,
									SATIS_FIYAT 		= :SATIS_FIYAT, 
									PARA_BIRIM			= :PARA_BIRIM, 
									BIRIM 				= :BIRIM, 
									ADET 				= :ADET, 
									DURUM 				= :DURUM,
									KAYIT_YAPAN			= :KAYIT_YAPAN, 
									TARIH				= NOW(),
									EXCEL_ID			= :EXCEL_ID
								WHERE ID = :ID
								";
			$filtre[":PARCA_MARKA_ID"]	= $rows_pm[trim($row_o->A)]->PARCA_MARKA_ID;;
			$filtre[":PARCA_MARKA"]		= trim($row_o->A);
			$filtre[":KODU"]			= trim($row_o->B);
			$filtre[":OEM_KODU"]		= trim($row_o->C);
			$filtre[":MUADIL_KODUS"]	= $row_o->D;
			$filtre[":STOK"]			= trim($row_o->E);
			$filtre[":ALIS_FIYAT"]		= trim($row_o->F);
			$filtre[":SATIS_FIYAT"]		= trim($row_o->F); //str_replace(',','.',str_replace('.','',$row_o->F));
			$filtre[":PARA_BIRIM"]		= "TL"; //$row_o->H;
			$filtre[":BIRIM"]			= "ADET"; //$row_o->I;
			$filtre[":ADET"]			= $row_o->G;
			$filtre[":DURUM"]			= $row_o->H;
			$filtre[":KAYIT_YAPAN"]		= $_SESSION['kullanici'];
			$filtre[":EXCEL_ID"]		= $row_excel->ID;
			$filtre[":ID"]				= $rows_yp[$row_o->B."_".$row_o->C]->ID;
			$cdbPDO->rowsCount($sql, $filtre);
			$ESKI++;
			
		}
		
	}
	
	$filtre = array();
	$sql = "UPDATE EXCEL SET CALISMA_TARIH = NOW(), SAY = SAY + 1 WHERE ID = :ID";
	$filtre[":ID"]	= $row_excel->ID;
	$cdbPDO->rowsCount($sql, $filtre);
	
	echo "$YENI adet yeni eklendi. $ESKI adet güncellendi.";
	
