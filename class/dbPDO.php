<?
class dbPDO {

	private $sayfaUstYazi;
	private $sayfaAltYazi;
	private $sayfaIlk;
	private $sayfaSon;
	private $sayfaAdet;
	private $sayfa;	
	public $dbPDO;
		
	public function __construct() {
			
	}
	
	public function dbBaglan($HOST, $DB, $USR, $PSW){ 
		try {
			$dbPDO = new PDO(
							'mysql:host='.$HOST.';port=3306;dbname='.$DB.';', 
							$USR, 
							$PSW,
							array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;")
							);
			//SET sql_mode = ''
            //$dbPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
			//$dbPDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            //$dbh = new PDO('mysql:unix_socket=/tmp/mysql.sock;dbname='.DB.';', USR, PSW); 
            $dbPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //error açılması
            $dbPDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // default obje olarak belirlenmesi
		    $dbPDO->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
		    $this->dbPDO = $dbPDO;
		    return $dbPDO;
		    
		} catch (PDOException $e) {
		    print "Hata!: " . $e->getMessage() . "<br/>";
		    die();
		    
		}
		
	}
	
	public function getdbPDO(){
		return $this->dbPDO;
	}
	
	
	public function hataMail($dbPDO, $stmt, $sql, $filtre=array(), $kime='baarisgull@gmail.com', $ekran="1") { 
		global $cMail;
		
	   	$icerik_arr = array();
	   	$sql_hata	= array();
	   	
	   	$sql_hata	= $stmt->errorInfo();
	   	$adresarr 	= explode(".",$_SERVER['SERVER_NAME']);
	   	$adres 		= $adresarr[0].".".$adresarr[1];  
	   	$sorgu		= $this->getSQL($sql, $filtre);
	    		    
	   	$konu	= "SQL HATASI - ".$sql_hata[2];
	    $icerik_arr[]	= "!!!Hata Oluştu!!!";
	    $icerik_arr[]	= "Username: ".$_SESSION['kullanici'];
	    $icerik_arr[]	= "IP: ".$_SERVER['REMOTE_ADDR'];
	    $icerik_arr[]	= "Adres: ".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	    $icerik_arr[]	= "Geldigi Sayfa: ".$_SERVER['HTTP_REFERER'];
	    $icerik_arr[]	= "Sorgu: ".$sorgu;
	    $icerik_arr[]	= "Filtre: ".json_encode($filtre);
	    $icerik_arr[]	= "Sql: ".$sql;
	    $icerik_arr[]	= "Hata: ".$sql_hata[2];
	    $icerik			= implode("\n", $icerik_arr); 
	    //mail($kime, $konu, $icerik,"From:HATA - $adres<baarisgull@gmail.com>\nMIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\n");
	    $cMail->Gonder($kime,$konu,$icerik);
	    
	    if($ekran){
		    $icerik_arr[0]	= "<b>Beklenmeyen bir hata oluştu! Bu hatanın oluştuğuna dair bilgi yetkililere iletildi ve en kısa sürede çözülecektir.</b>";
		    $icerik			= implode('<br>', $icerik_arr);	    
		   	//$stmt->debugDumpParams();
		   	echo   "<div class='col-md-12'> 
		   				<div class='alert alert-danger' role='alert'> 
		   					<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
		   					$icerik 
		   				</div> 
		   			</div>";
	   	}
	   	
	   	die(); 
	
	} 
	
	public function getSQL($sql = "", $filtre = array()){
		if(count($filtre)==0) return $sql;
		
		$sql_echo = $sql;
		foreach($filtre as $key => $value){
			//$sql_echo = str_replace($key, "'$value'", $sql_echo);
			$sql_echo = preg_replace('/'.$key.'\b/', "'$value'", $sql_echo);
		}
		return $sql_echo;
		
	}
	
	public function SQL($sql = "", $filtre = array()){
		
		if(dbg()) {
			if(count($filtre)==0) { 
				echo "
					<div>
						<img src='../images/sql-icon.png' onclick='$(\"#dbg\").toggle();' style='cursor: pointer' width='25' height='25' >
						<div id='dbg' style='display: none;'>
							$sql
						</div>
					</div>	
					";
				
			}else{
				
				$sql_echo = $sql;
				foreach($filtre as $key => $value){
					$sql_echo = preg_replace('/'.$key.'\b/', "'$value'", $sql_echo);
				}
				
				echo "
					<div>
						<img src='../images/sql-icon.png' onclick='$(\"#dbg\").toggle();' style='cursor: pointer' width='25' height='25' >
						<div id='dbg' style='display: none;'>
							$sql_echo
						</div>
					</div>	
					";
			}
		}
		
	}
	
	public function row($sql = "", $filtre = array()){
		
		$stmt = $this->dbPDO->prepare($sql);
		if (!$stmt->execute($filtre)) { $this->hataMail($this->dbPDO, $stmt, $sql, $filtre);}	
		return $stmt->fetchObject();
		
	}
	
	public function rows($sql = "", $filtre = array()){
		$stmt = $this->dbPDO->prepare($sql);
		if (!$stmt->execute($filtre)) { $this->hataMail($this->dbPDO, $stmt, $sql, $filtre);}
		return $stmt->fetchAll();
		
	}
	
	public function rowsCount($sql = "", $filtre = array()){
		$stmt = $this->dbPDO->prepare($sql);
		if (!$stmt->execute($filtre)) { $this->hataMail($this->dbPDO, $stmt, $sql, $filtre);}	
		return $stmt->rowCount();
		
	}
	
	public function lastInsertId($sql = "", $filtre = array()){
		$stmt = $this->dbPDO->prepare($sql);
		if (!$stmt->execute($filtre)) { $this->hataMail($this->dbPDO, $stmt, $sql, $filtre);}	
		return $this->dbPDO->lastInsertId();
		
	}
	
}

class dbMsql {

	private $sayfaUstYazi;
	private $sayfaAltYazi;
	private $sayfaIlk;
	private $sayfaSon;
	private $sayfaAdet;
	private $sayfa;	
	public $dbPDO;
		
	public function __construct() {
			
	}
	
	public function dbBaglan($HOST, $DB, $USR, $PSW){
		//return FALSE;
		
		try {
			/*
			if($_SERVER['REMOTE_ADDR'] == "127.0.0.1"){
				$CON = "sqlsrv:server=$HOST;database=$DB;";
			} else{
				$CON = "dblib:host=$HOST;dbname=$DB;charset=UTF-8;";
			}	
			*/
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				$HOST = str_replace(':', ',', $HOST);
			    $CON = "sqlsrv:server=$HOST;database=$DB;";
			} else {
			    $CON = "dblib:host=$HOST;dbname=$DB;charset=UTF-8;";
			}
			
			$dbPDO = new PDO(
							$CON,
							$USR, 
							$PSW,
							array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
							);
            //$dbPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
			//$dbPDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            //$dbh = new PDO('mysql:unix_socket=/tmp/mysql.sock;dbname='.DB.';', USR, PSW); 
            $dbPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //error açılması
            $dbPDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // default obje olarak belirlenmesi
		    
		    $this->dbPDO = $dbPDO;
		    return $dbPDO;
		    
		} catch (PDOException $e) {
		    print "Hata!: " . $e->getMessage() . "<br/>";
		    die();
		    
		}
		
	}
	
	public function getdbPDO(){
		return $this->dbPDO;
	}
	
	
	public function hataMail($dbPDO, $stmt, $sql, $filtre=array(), $kime='baarisgull@gmail.com', $ekran="1") { 
		global $cMail;
		
	   	$icerik_arr = array();
	   	$sql_hata	= array();
	   	
	   	$sql_hata	= $stmt->errorInfo();
	   	$adresarr 	= explode(".",$_SERVER['SERVER_NAME']);
	   	$adres 		= $adresarr[0].".".$adresarr[1];  
	   	$sorgu		= $this->getSQL($sql, $filtre);
	    		    
	    $konu	= "SQL HATASI - ".$sql_hata[2];
	    $icerik_arr[]	= "Beklenmeyen bir hata oluştu! Bu hatanın oluştuğuna dair bilgi yetkililere iletildi ve en kısa sürede çözülecektir.";
	    $icerik_arr[]	= "Username: ".$_SESSION['kullanici'];
	    $icerik_arr[]	= "IP: ".$_SERVER['REMOTE_ADDR'];
	    $icerik_arr[]	= "Adres: ".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	    $icerik_arr[]	= "Geldigi Sayfa: ".$_SERVER['HTTP_REFERER'];
	    $icerik_arr[]	= "Sorgu: ".$sorgu;
	    $icerik_arr[]	= "Filtre: ".json_encode($filtre);
	    $icerik_arr[]	= "Sql: ".$sql;
	    $icerik_arr[]	= "Hata: ".$sql_hata[2];
	    $icerik			= implode("\n", $icerik_arr); 
	    mail($kime, $konu, $icerik,"From:HATA - $adres<baarisgull@gmail.com>\nMIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\n");
	    $cMail->Gonder($kime,$konu,$icerik);
	    
	    if($ekran){
		    $icerik_arr[0]	= "<b>Beklenmeyen bir hata oluştu! Bu hatanın oluştuğuna dair bilgi yetkililere iletildi ve en kısa sürede çözülecektir.</b>";
		    $icerik			= implode('<br>', $icerik_arr);	    
		   	//$stmt->debugDumpParams();
		   	echo   "<div class='col-md-12'> 
		   				<div class='alert alert-danger' role='alert'> 
		   					<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
		   					$icerik 
		   				</div> 
		   			</div>";
	   	}
	   	
	   	die(); 
	
	} 
	
	public function getSQL($sql = "", $filtre = array()){
		if(count($filtre)==0) return $sql;
		
		$sql_echo = $sql;
		foreach($filtre as $key => $value){
			//$sql_echo = str_replace($key, "'$value'", $sql_echo);
			$sql_echo = preg_replace('/'.$key.'\b/', "'$value'", $sql_echo);
		}
		return $sql_echo;
		
	}
	
	public function SQL($sql = "", $filtre = array()){
		
		if(dbg()) {
			if(count($filtre)==0) { 
				echo "
					<div>
						<img src='../images/sql-icon.png' onclick='$(\"#dbg\").toggle();' style='cursor: pointer' width='25' height='25' >
						<div id='dbg' style='display: none;'>
							$sql
						</div>
					</div>	
					";
				
			}else{
				
				$sql_echo = $sql;
				foreach($filtre as $key => $value){
					$sql_echo = preg_replace('/'.$key.'\b/', "'$value'", $sql_echo);
				}
				
				echo "
					<div>
						<img src='../images/sql-icon.png' onclick='$(\"#dbg\").toggle();' style='cursor: pointer' width='25' height='25' >
						<div id='dbg' style='display: none;'>
							$sql_echo
						</div>
					</div>	
					";
			}
		}
		
	}
	
	public function row($sql = "", $filtre = array()){
		$stmt = $this->dbPDO->prepare($sql);
		if (!$stmt->execute($filtre)) { $this->hataMail($this->dbPDO, $stmt, $sql, $filtre);}	
		return $stmt->fetchObject();
		
	}
	
	public function rows($sql = "", $filtre = array()){
		$stmt = $this->dbPDO->prepare($sql);
		if (!$stmt->execute($filtre)) { $this->hataMail($this->dbPDO, $stmt, $sql, $filtre);}	
		return $stmt->fetchAll();
		
	}
	
	public function rowsCount($sql = "", $filtre = array()){
		$stmt = $this->dbPDO->prepare($sql);
		if (!$stmt->execute($filtre)) { $this->hataMail($this->dbPDO, $stmt, $sql, $filtre);}	
		return $stmt->rowCount();
		
	}
	
	public function lastInsertId($sql = "", $filtre = array()){
		$stmt = $this->dbPDO->prepare($sql);
		if (!$stmt->execute($filtre)) { $this->hataMail($this->dbPDO, $stmt, $sql, $filtre);}	
		return $this->dbPDO->lastInsertId();
		
	}
	
}


	/*
	Kullanım 1
	$sql = "SELECT HS.SORUMLU, CONCAT(HS.SORUMLU,'# ',U.NAME) AS SORUMLU_AD 
			FROM HKMEKS_SORUMLULAR HS 
			INNER JOIN USERS U ON U.U_NAME=HS.SORUMLU ORDER BY 2";
	$stmt = $dbPDO->prepare($sql); 
	if (!$stmt->execute()) { $cdbPDO->hataMail($dbPDO, $stmt, $sql);}
	while ($row = $stmt->fetchObject()) {
		 ?> <option value="<?=$row->SORUMLU ?>" <?=($MARKA_ID==$row->SORUMLU)?' selected':'' ?> ><?=$row->SORUMLU_AD ?></option> <? 
	}
	
	Kullanım 2
	$sql   	.= " LIMIT 0, 5000";					
	$stmt = $dbPDO->prepare($sql); 	
	
	if (!$stmt->execute($filtre)) { $cdbPDO->hataMail($dbPDO, $stmt, $sql, $filtre);}				
	$cdbPDO->SQL($sql, $filtre);
	
	
	*/


 ?>