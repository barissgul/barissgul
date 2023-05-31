<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$filtre = array();
	$sql = "SELECT
				YEAR(I.TARIH) AS YIL,
				I.IHALE_NO
			FROM IHALE AS I
			WHERE I.ID = :ID
			";
	$filtre[":ID"]	= $_REQUEST['id'];
	$row = $cdbPDO->row($sql, $filtre);
		
	$zip_adi = $row->IHALE_NO . ".zip";
	$klasor = $_SERVER['DOCUMENT_ROOT'] . "/img/ihale/" . $row->YIL . "/" . $row->IHALE_NO . "/";

	$zip = new ZipArchive; 
	if ($zip -> open($zip_adi, ZipArchive::CREATE) === TRUE) { 
	    $dir = preg_replace('/[\/]{2,}/', '/', $klasor."/"); 
	    
	    $dirs = array($dir); 
	    while (count($dirs)) { 
	        $dir = current($dirs); 
	        $zip->addEmptyDir($dir); 
	        
	        $dh = opendir($dir); 
	        while($file = readdir($dh)) { 
	            if ($file != '.' && $file != '..'){
	            	echo $file;
	                if (is_file($dir.$file)) {
						$zip->addFile($dir.$file, $dir.$file);
						echo " var.";
					} elseif (is_dir($file)) {
						$dirs[] = $dir.$file."/"; 
					}
	                echo "<br>";  
	            } 
	        } 
	        closedir($dh); 
	        array_shift($dirs); 
	    } 
	    
	    $zip->close(); 
		
	    echo 'Zip Oluştu. <a href="/ihale/'. $zip_adi .'"> İndir </a>'; 
		
	} else { 
	    echo 'Hata Zip Bulunamadı!'; 
	} 