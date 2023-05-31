<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	
	$filtre = array();
	$sql = "SELECT
				T.ID,
				T.PLAKA,
				YEAR(T.TARIH) AS YIL,
				MA.MARKA
			FROM TALEP AS T
				LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
			WHERE T.ID = :ID
			";
	$filtre[":ID"]	= $_REQUEST['id'];
	$row = $cdbPDO->row($sql, $filtre);
	
	foreach($_REQUEST['resim_sec'] as $key => $value){
		$ids[] = $key;
	}
	
	foreach($_REQUEST['evrak_sec'] as $key => $value){
		$ids[] = $key;
	}
	
	//var_dump2($ids);
	
	$filtre = array();
	$sql = "SELECT
				TR.ID,
				TR.RESIM_ADI,
				TR.RESIM_ADI_ILK
			FROM TALEP_RESIM AS TR
			WHERE TR.TALEP_ID = :TALEP_ID AND FIND_IN_SET(TR.ID,:IDS)
			";
	$filtre[":TALEP_ID"]	= $row->ID;
	$filtre[":IDS"]			= implode(',', $ids);
	$rows_resim = $cdbPDO->rows($sql, $filtre);
	
	if(count($rows_resim) == 0){
		echo "Seçili Resim Bulunamadı!";
		die();
	}
	
	$zip_adi = $row->PLAKA ." - ". $row->MARKA . ".zip";
	$klasor  = $cSabit->imgPathFolder("talep") . $row->YIL . "/" . $row->ID . "/";
	$klasor2 = $row->PLAKA ." - ". $row->MARKA . "/";
	
	unlink($_SERVER['DOCUMENT_ROOT'] . "/talep/" . $zip_adi); 
	
	$zip = new ZipArchive; 
	if ($zip -> open($zip_adi, ZipArchive::CREATE) === TRUE) { 
	    
	    $zip->addEmptyDir($klasor2); 
	    
	    foreach($rows_resim as $key => $row_resim){
	        echo $row_resim->RESIM_ADI;
	        if (is_file($klasor.$row_resim->RESIM_ADI)) {
				$zip->addFile($klasor.$row_resim->RESIM_ADI, $klasor2.$row_resim->RESIM_ADI);
				echo " var.";
			}
	        echo "<br>";  
		}
		
	    $zip->close(); 	    
		
	    echo 'Zip Oluştu. <a href="/talep/'. $zip_adi .'"> İndir </a>'; 
		
	} else { 
	    echo 'Hata Zip Bulunamadı!'; 
	} 