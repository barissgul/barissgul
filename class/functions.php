<?
	function toplama(){
		return 2+3;
	}
	
	function session_kontrol(){
		if(!isset($_SESSION["kullanici_id"]) OR $_SESSION["session_kontrol"] != md5($_SESSION["kullanici_id"].$_SESSION["yetki_id"].$_SESSION["domain"]) OR is_null($_SESSION["session_kontrol"])) { 
			//header("Location: giris.php", TRUE, 301); exit;
			$sayfa_url = urlencode($_SERVER['REQUEST_URI']);
			echo "<script type='text/javascript'>window.top.location='/giris.do';</script>"; exit;
		}
		
	}
	
	function yetki_kontrol(){
		if(!in_array($_SESSION["yetki_id"], array(1,2,3))) { 
			echo "Yetki Hatası!"; exit;
		}
		
	}
	
	function fncOtoLogin(){
		if($_REQUEST['key'] != "8793dd869e0de20c8674db2f78a42923"){
			return false;
		}
		
		return true;
	}
	
	function kod_kontrol($row){
		if($_REQUEST["kod"] != $row->KOD AND !fncOtoLogin()) { 
			//header("Location: giris.php", TRUE, 301); exit;
			echo "Kod Hatası!"; exit;
		}
		
	}
	
	function fncEkstrePopupLink($row){
		$str = "javascript:fncPopup('/finans/ekstre.do?route=finans/ekstre&kod=:CARI_KOD&filtre=1','POPUP_EKSTRE',1100,850);";
		$str = str_replace(':CARI_KOD', $row->CARI_KOD, $str);
		return $str;
	}
	
	function fncServisPopupLink($row){
		//$str = "javascript:fncPopup('/talep/popup_servis.do?route=talep/popup_servis&id=:ID&kod=:KOD','POPUP_SERVIS',1100,850);";
		$str = "/talep/talep.do?route=talep/talep_listesi&id=:ID&kod=:KOD";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncOzetPopupLink($row){
		$str = "javascript:fncPopup('/talep/popup_ozet.do?route=talep/popup_ozet&id=:ID&kod=:KOD','POPUP_OZET',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncFaturaPopupLink($row){
		$str = "javascript:fncPopup('/finans/popup_fatura.do?route=finans/popup_fatura&id=:ID&kod=:KOD','POPUP_FATURA',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncOdemePopupLink($row){
		$str = "javascript:fncPopup('/finans/popup_odeme.do?route=finans/popup_odeme&id=:ID&kod=:KOD','POPUP_ODEME',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncYPPopupLink($row){
		$str = "javascript:fncPopup('/yedek_parca/popup_yp.do?route=finans/popup_yp&uuid=:UUID','POPUP_YP',1000,700);";
		$str = str_replace(':UUID', $row->UUID, $str);
		return $str;
	}
	
	function fncKabulFormuPopupLink($row){
		$str = "javascript:fncPopup('/talep/popup_kabul_formu.do?route=talep/popup_kabul_formu&id=:ID&kod=:KOD','POPUP_ARAC_KABUL',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncIsEmriPopupLink($row){
		$str = "javascript:fncPopup('/talep/popup_is_emri.do?route=talep/popup_is_emri&id=:ID&kod=:KOD','POPUP_IS_EMRI',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncTeslimIbraPopupLink($row){
		$str = "javascript:fncPopup('/talep/popup_teslim_ibra.do?route=talep/popup_teslim_ibra&id=:ID&kod=:KOD','POPUP_TESLIM_IBRA',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncCariPopupLink($row){
		$str = "javascript:fncPopup('/tanimlama/popup_cari.do?route=talep/popup_cari&id=:ID&kod=:KOD','POPUP_CARI',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncCariNotPopupLink($row){
		$str = "javascript:fncPopup('/finans/popup_cari_not.do?route=talep/popup_cari&id=:ID&kod=:KOD','POPUP_CARI_NOT',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncHizmetLink2($row, $row_hizmet){
		$str = $row_hizmet->HIZMET_URL;
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncEFaturaPopupLink($row){
		$str = "javascript:fncPopup('/finans/popup_efatura.do?route=finans/popup_efatura&uuid=:UUID&fatura_no=:FATURA_NO&hareket_id=:HAREKET_ID','POPUP_EFATURA',1100,850);";
		$str = str_replace(':UUID', $row->EFATURA_UUID, $str);
		$str = str_replace(':FATURA_NO', $row->FATURA_NO, $str);
		$str = str_replace(':HAREKET_ID', $row->HAREKET_ID > 0 ? $row->HAREKET_ID : 1, $str);
		return $str;
	}
	
	function fncKiralamaLink($row){
		$str = "/kiralama/kiralama.do?route=kiralama/kiralama_takip&id=:ID&kod=:KOD";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncKiralamaFormuPopupLink($row){
		$str = "javascript:fncPopup('/kiralama/popup_kiralama_formu.do?route=kiralama/popup_kiralama_formu&id=:ID&kod=:KOD','POPUP_KIRALAMA_FORMU',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	function fncIkameFormuPopupLink($row){
		$str = "javascript:fncPopup('/ikame/popup_ikame_formu.do?route=ikame/popup_ikame_formu&id=:ID&kod=:KOD','POPUP_IKAME_FORMU',1100,850);";
		$str = str_replace(':ID', $row->ID, $str);
		$str = str_replace(':KOD', $row->KOD, $str);
		return $str;
	}
	
	// Kullanıcıların diğer siparişleri görmesi engelleme
	function siparis_kontrol($SIPARIS_KULLANICI_ID){
		if(in_array($_SESSION['yetki_id'],array(3)) AND $_SESSION['kullanici_id'] != $SIPARIS_KULLANICI_ID) {
			echo "Sayfaya yetkisiz giriş!";
			exit;
		}
		
	}
	
	function fncUrlTemizle($url){
		$arr = parse_url($url, PHP_URL_PATH);
		return $arr;
	}
	
	function sayfa_kontrol(){
		global $cdbPDO;
		$datetime1 	= new DateTime($_SESSION["menu_tarih"]);
		$datetime2 	= new DateTime(date("Y-m-d H:i:s"));
		$interval 	= $datetime1->diff($datetime2);
		$saat		= $interval->format('%h');
		$dakika		= $interval->format('%i');
		//var_dump2($_SESSION["menu"]);
		if($saat>=1 OR $_REQUEST['menu_yenile']==1){
			if(in_array($_SESSION["yetki_id"],array(1))){
				$sql = "SELECT 
							*
						FROM MENU AS M
							LEFT JOIN KULLANICI_MENU AS KM ON KM.MENU_ID = M.ID
						WHERE M.DURUM = 1
						GROUP BY M.ID ORDER BY M.SIRA ASC
						";
			} else {
				$sql = "SELECT 
							*
						FROM MENU AS M
							LEFT JOIN KULLANICI_MENU AS KM ON KM.MENU_ID = M.ID
						WHERE M.DURUM = 1 AND KM.KULLANICI_ID = '" . $_SESSION["kullanici_id"] . "'
						GROUP BY M.ID ORDER BY KM.SIRA ASC
						";
			}
			
			$_SESSION["menu"] 		= $cdbPDO->rows($sql, array());
			$_SESSION["menu_tarih"]	= date("Y-m-d H:i:s");
			//echo "Menü yenilendi."; saat başı çaşır
		}
		//var_dump2($_SERVER);
		//$adres = explode('/',$_SERVER["PHP_SELF"]);
		$adres = explode('/',$_SERVER["REQUEST_URI"]);
		$url   = $adres[count($adres)-1];
		$sayfa = explode('?',$url);
		$sayfa = $sayfa[0];
		
		foreach($_SESSION["menu"] as $row){
			if($row->LINK == $sayfa) { 
				$BASARILI = TRUE;
				break;
			}
		}
		if(!$BASARILI){
			echo "İzinsiz Giriş!"; die();
		}
	}
	
	function pathNav($url){
		$arr = explode('/', $_SERVER['REQUEST_URI']);
		$str = $arr[count($arr)-1];
		if($url == $str) return "active";
	}
	
	function dateDifference($date_1 , $date_2 , $differenceFormat = '%d Gün %h Saat %i Dakika' ) {
	    $datetime1 = date_create($date_1);
	    $datetime2 = date_create($date_2);
	    $interval = date_diff($datetime1, $datetime2);
	    return $interval->format($differenceFormat);
	}
	
	function fncVarYok($deger){
		if($deger == 1){
			$str = "VAR";
		} else {
			$str = "---";
		}
		return $str;
	}
	
	function var_dump2($str) {
		echo "<pre>";
		var_dump($str);
		echo "</pre>";
		
	}
	
	function dbg(){
	    if ($_SERVER['REMOTE_ADDR']=="127.0.0.1" OR	preg_match('/^10.10.8./',$_SERVER['REMOTE_ADDR']) ){
	        return true;
	    }else{
	        return false;
	    }
	}
	
	//ekrana düzgün şekilde ve göster/gizle şeklinde gösterilmesinin sağlanması
	function dbgSQL($sql, $filtre=array() ){
		$random = rand();
  		if(dbg()) {
			if(count($filtre)==0) {
				
				echo "
					<div>
						<img src='../img/sql-icon.png' onclick='$(\"#dbg$random\").toggle();' style='cursor: pointer' width='25' height='25' >
						<div id='dbg$random' style='display: none; font-size: 9px; text-align: left'> 
							<pre>
							". SqlFormatter::format($sql) ."
							</pre>
						</div>
					</div>	
					";
				
			}else{
				
				$sql_echo = $sql;
				foreach($filtre as $key => $value){
					//$sql_echo = str_replace($key, "'".$value."'", $sql_echo);
					$sql_echo = preg_replace('/'.$key.'\b/', "'$value'", $sql_echo);
				}
				echo "
					<div>
						<img src='../img/sql-icon.png' onclick='$(\"#dbg$random\").toggle();' style='cursor: pointer' width='25' height='25' >
						<div id='dbg$random' style='display: none; font-size: 9px; text-align: left'>
							<pre>
							". SqlFormatter::format($sql_echo) ."
							</pre>
						</div>
					</div>	
					";
			}
		}
	}
	
	//ekrana düzgün şekilde ve göster/gizle şeklinde gösterilmesinin sağlanması
	function dbgGoster($arr){
		$random = rand();
  		if(dbg()) {
			if(count($arr)==0) {
				
				echo "
					<div>
						<img src='../img/sql-icon.png' onclick='$(\"#dbg$random\").toggle();' style='cursor: pointer' width='25' height='25' >
						<div id='dbg$random' style='display: none; font-size: 9px; text-align: left'> 
							<pre> $arr </pre>
						</div>
					</div>	
					";
				
			}else{
				
				echo "
					<div>
						<img src='../img/sql-icon.png' onclick='$(\"#dbg$random\").toggle();' style='cursor: pointer' width='25' height='25' >
						<div id='dbg$random' style='display: none; font-size: 9px; text-align: left'>
							<pre>". var_export($arr, true) ."</pre>
						</div>
					</div>	
					";
					
			}
		}
	}
	
	function sifrele($ID){
		$crypt = new Crypt();
		$crypt->setKey('Fatih Gül');
		$crypt->setData($ID);
		return $crypt->encrypt();
	}
	
	function sifre_coz($DATA){
		$crypt = new Crypt();
		$crypt->setKey('Fatih Gül');
		$crypt->setData($DATA);
		return $crypt->decrypt();
	}
	
	function kullanici_log_sayfa($DURUM = TRUE){
		global $cdbPDO;
		
		if($DURUM){
			//$_SERVER["REQUEST_URI"]
			$sayfa 			= $_SERVER['REQUEST_URI'];
			$geldigi_sayfa	= $_SERVER['HTTP_REFERER'];
			$filtre	= array();
			
			$sql = "INSERT INTO KULLANICI_LOG_SAYFA SET SAYFA = :SAYFA, 
														GELDIGI_SAYFA = :GELDIGI_SAYFA, 
														SESSION_ID = :SESSION_ID, 
														KULLANICI_LOG_ID = :KULLANICI_LOG_ID";
			$filtre[":SAYFA"] 				= $_SERVER['REQUEST_URI'];
			$filtre[":GELDIGI_SAYFA"] 		= $_SERVER['HTTP_REFERER'];
			$filtre[":SESSION_ID"] 			= session_id();
			$filtre[":KULLANICI_LOG_ID"] 	= $_SESSION['log_id'];
			$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
			
		}
			
	}
	
	function admin_tema() {
		//return "skin-yellow-light";
		return "skin-blue";
		return "skin-yellow-light sidebar-collapse sidebar-mini";
	}
	
	function routeActive($route){
		if(empty($_REQUEST['route'])) return "";
		
		$hedef 	= explode("/", $route);
		$kaynak	= explode("/", $_REQUEST['route']);
		if($hedef[0] == $kaynak[0] AND count($hedef) == 1 ){
			return "active";
		} 
		
		if($hedef[1] == $kaynak[1]){
			return "active";
		}
		
	}
	
	function bubbleSort($arr, $kolon, $order, $tip = "INT") {
		
		if($tip == "INT"){
			
			if(trim(strtoupper($order)) == "DESC"){
				$size = count($arr);
			    for ($i=0; $i<$size; $i++) {
			        for ($j=0; $j<$size-1-$i; $j++) {
			            if ($arr[$j+1]->{$kolon} > $arr[$j]->{$kolon}) {
			                $tmp = $arr[$j];
						    $arr[$j] = $arr[$j+1];
						    $arr[$j+1] = $tmp;
			            }
			        }
			    }
			    
			} else {
				$size = count($arr);
			    for ($i=0; $i<$size; $i++) {
			        for ($j=0; $j<$size-1-$i; $j++) {
			            if ($arr[$j+1]->{$kolon} < $arr[$j]->{$kolon}) {
			                $tmp = $arr[$j];
						    $arr[$j] = $arr[$j+1];
						    $arr[$j+1] = $tmp;
			            }
			        }
			    }
			}
			
		} else {
		    
		    if(trim(strtoupper($order)) == "DESC"){
				$size = count($arr);
			    for ($i=0; $i<$size; $i++) {
			        for ($j=0; $j<$size-1-$i; $j++) {
			            if (strtotime($arr[$j+1]->{$kolon}) > strtotime($arr[$j]->{$kolon})) {
			                $tmp = $arr[$j];
						    $arr[$j] = $arr[$j+1];
						    $arr[$j+1] = $tmp;
			            }
			        }
			    }
			    
			} else {
				$size = count($arr);
			    for ($i=0; $i<$size; $i++) {
			        for ($j=0; $j<$size-1-$i; $j++) {
			            if (strtotime($arr[$j+1]->{$kolon}) < strtotime($arr[$j]->{$kolon})) {
			                $tmp = $arr[$j];
						    $arr[$j] = $arr[$j+1];
						    $arr[$j+1] = $tmp;
			            }
			        }
			    }
			}
			
		}
	    
	    return $arr;
	}
	
	function indirimOrani($indirimsiz, $indirimli){
		$oran = ($indirimli * 100 / $indirimsiz) - 100;
		if(intval($oran) <= 0) $oran = 0;
		return ($oran) . "%";
	}
	
	function ziyaretUrun($DURUM = TRUE){
		global $cdbPDO;
		
		if($DURUM == FALSE OR strlen($_REQUEST['id2'])<3) return FALSE;
		
		$adres 			= explode('/',$_SERVER["REQUEST_URI"]);
		$url   			= $adres[count($adres)-1];
		$sayfa_adi		= explode('?',$url);
		$sayfa_uzantili	= explode('.',$sayfa_adi[0]);
		$sayfa			= $sayfa_uzantili[0];
		$uzanti			= $sayfa_uzantili[1];
		
		if(in_array('admin',$adres)){
			return FALSE;
		}
		
		if($sayfa == "urun_detay"){
			$filtre	= array();
			$sql = "INSERT INTO ZIYARET_URUN SET 	URUN_ID			= (SELECT ID FROM URUN WHERE ID2 = :ID2 LIMIT 1),
													KULLANICI_ID 	= :KULLANICI_ID
													";
			$filtre[":ID2"] 			= ($_REQUEST['id2']) ? $_REQUEST['id2'] : 1;
			$filtre[":KULLANICI_ID"] 	= ($_SESSION['kullanici_id'] > 0) ? $_SESSION['kullanici_id'] : 0;			
			$rowsCount = $cdbPDO->rowsCount($sql, $filtre);
		}
		
	}
	
	function temizUrl($str) {
		$ozelHarfler = array(
			'a' => array('á','à','â','ä','ã'),
			'A' => array('Ã','Ä','Â','À','Á'),
			'e' => array('é','è','ê','ë'),
			'E' => array('Ë','É','È','Ê'),
			'i' => array('í','ì','î','ï','ı'),
			'I' => array('Î','Í','Ì','İ','Ï'),
			'o' => array('ó','ò','ô','ö','õ'),
			'O' => array('Õ','Ö','Ô','Ò','Ó'),
			'u' => array('ú','ù','û','ü'),
			'U' => array('Ú','Û','Ù','Ü'),
			'c' => array('ç'),
			'C' => array('Ç'),
			's' => array('ş'),
			'S' => array('Ş'),
			'n' => array('ñ'),
			'N' => array('Ñ'),
			'y' => array('ÿ'),
			'Y' => array('Ÿ')
		);
 		
		$ozelKarakterler = array ('#', '$', '%', '^', '&', '*', '!', '~', '"', '\'', '=', '?', '/', '[', ']', '(', ')', '|', '<', '>', ';', ':', '\\', ', ');
		$str = str_replace($ozelKarakterler, '', $str);
		$str = str_replace(' ', '_', $str);
		foreach($ozelHarfler as $harf => $ozeller){
			foreach($ozeller as $tektek){
				$str = str_replace($tektek, $harf, $str);
			}
		}
		$str = preg_replace("/[^a-zA-Z0-9\-\.]/", "_", $str);
		$str = strtolower($str);
		return $str;
		
	}
	
	function arrayIndex($rows){
		$rows_yeni = array();
		
		foreach($rows as $key => $row){
			$rows_yeni[$row->ID]	= $row;
		}
		
		return $rows_yeni;
		
	}
	
	function kategoriSql($arrRequest = array()) {
		global $cdbPDO;
		
		// Kategorilerin alınması
    	$filtre = array();
		$sql = "SELECT K2.ID FROM KATEGORI K
					LEFT JOIN KATEGORI AS K2 ON K2.KATEGORI_ID = K.ID OR K2.ID = K.ID
				WHERE K.DURUM = 1
				";
		if($arrRequest["ID"]){
			$sql.=" AND K.ID = :ID";
			$filtre[":ID"] = $arrRequest['ID'];
		}
		
		if($arrRequest["ID2"]){
			$sql.=" AND K.ID2 = :ID2";
			$filtre[":ID2"] = $arrRequest['ID2'];
		}
		
		$rows_kategori = $cdbPDO->rows($sql, $filtre);
		
		foreach($rows_kategori as $key => $row_kategori){
			$arr_kategori_ids[] = " FIND_IN_SET({$row_kategori->ID}, U.KATEGORI_IDS) ";
		}
		$sonuc =" AND (" . implode('OR', $arr_kategori_ids) . ")";
		
		return $sonuc;
		
	}
	
	function kategoriAltKatergori($arrRequest = array()) {
		global $cdbPDO;
		
		// Kategorilerin alınması
    	$filtre = array();
		$sql = "SELECT K2.ID FROM KATEGORI K
					LEFT JOIN KATEGORI AS K2 ON K2.KATEGORI_ID = K.ID OR K2.ID = K.ID
				WHERE K.DURUM = 1
				";
		if($arrRequest["ID"]){
			$sql.=" AND K.ID = :ID";
			$filtre[":ID"] = $arrRequest['ID'];
		}
		
		if($arrRequest["ID2"]){
			$sql.=" AND K.ID2 = :ID2";
			$filtre[":ID2"] = $arrRequest['ID2'];
		}
		
		$rows_kategori = $cdbPDO->rows($sql, $filtre);
		
		foreach($rows_kategori as $key => $row_kategori){
			$arr_kategori_ids[] = $row_kategori->ID;
		}
		
		if(count($arr_kategori_ids) > 0){
			$sonuc =" AND K.ID IN(" . implode(',', $arr_kategori_ids) . ")";
		}		
		
		return $sonuc;
		
	}
	
	function fncCariKoduUret($arrRequest = array()) {
		global $cdbPDO;
		$row = $cdbPDO->row("SELECT MAX(ID) AS MAX_ID FROM CARI");
		$cari_kodu = "MARINA" . str_pad($row->MAX_ID+1,6,"0",STR_PAD_LEFT);
		return $cari_kodu;
	}
	
	function fncSozlesme(){
		global $cdbPDO;
		global $row_site;
		
		$SOZLESME 	= $row_site->KULLANICI_SOZLESMESI;
		$SOZLESME	= str_replace("{NUMBER}", "12345", $SOZLESME);
		$SOZLESME	= str_replace("{DATE}", date("Y-m-d"), $SOZLESME);
		//$SOZLESME	= str_replace("\t", "", $SOZLESME);
		
		return $SOZLESME;
	}
	
	function fncActive($tab = 1, $ilk = 0){
		if($_REQUEST['tab'] == $tab OR $ilk == 1){
			return "active";
		}
	}
	
	function fncSurecActive($surec, $deger){
		if($surec == $deger){
			return "active";
		}
	}
	
	
	function fncMaliKodTre($str){
		$str = str_replace(' ', '_', $str);
		return $str;
		
	}
	
	function fncMaliKodBosluk($str){
		$str = str_replace('_', ' ', $str);
		return $str;
		
	}
	
	function fncSayi($sayi){
		$sayi = trim($sayi);
		$sayi = str_replace('.', '', $sayi);
		$sayi = str_replace(',', '.', $sayi);
		return $sayi;
	}
	
	function fncKodKontrol($row = array()){
		if($row->KOD != $_REQUEST['kod']){
			echo "Kod Hatası!"; die();
		}
	}
	
	function fncSifreUret($uzunluk = 8) {
	   	//$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
	   	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    	$sifre = substr( str_shuffle( $chars ), 0, $uzunluk );
    	return $sifre;
	}
	
	function dil($str){
		global $cdbPDO;
		
		//$_COOKIE['dil'] = "ENG";
		
		$str = trim($str);
		
		if($_SESSION['dil'] == "TR" OR !isset($_SESSION['dil']) OR is_null($_SESSION['dil'])){
			return $str;
			
		} else if(isset($_SESSION[$_SESSION['dil']][$str])){
			return $_SESSION[$_SESSION['dil']][$str];
			
		} else if(!isset($_SESSION[$_SESSION['dil']][$str])){
			$filtre	= array();
			$sql = "INSERT INTO DIL SET TR = :TR, ENG = CONCAT('X ',:TR,' X'), RUS = CONCAT('X ',:TR,' X'), SAYFA = :SAYFA";
			$filtre[":TR"] 		= $str;
			$filtre[":SAYFA"] 	= $_SERVER['PHP_SELF'];
			$cdbPDO->rowsCount($sql, $filtre);
			
			$str = $_SESSION[$_SESSION['dil']][$str]	 = "XX " . $str . " XX";
			
			return $str;
			
		} else {
			return $_SESSION[$_SESSION['dil']][$str];	
			
		}
	}
	
	function dil__($str){
		global $cdbPDO;
		
		//$_COOKIE['dil'] = "ENG";
		
		$str = trim($str);
		
		if($_COOKIE['dil'] == "TR" OR !isset($_COOKIE['dil'])){
			return $str;
			
		} else if(isset($_SESSION[$_COOKIE['dil']][$str])){
			return $_SESSION[$_COOKIE['dil']][$str];
			
		} else if(!isset($_SESSION[$_COOKIE['dil']][$str])){
			$filtre	= array();
			$sql = "INSERT INTO DIL SET TR = :TR, SAYFA = :SAYFA";
			$filtre[":TR"] 		= $str;
			$filtre[":SAYFA"] 	= $_SERVER['PHP_SELF'];
			$cdbPDO->rowsCount($sql, $filtre);
			
			$str = $_SESSION[$_COOKIE['dil']][$str]	 = "XX " . $str . " XX";
			
			return $str;
			
		} else {
			return $_SESSION[$_COOKIE['dil']][$str];	
			
		}
	}
	
	function dil2($str){
		return $str;
	}
	
	function err(){
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}
	
	function fncSqlCari(&$sql, &$filtre){
		if($_SESSION['yetki_id'] == 3){			
			$sql.=" AND C.TEMSILCI_ID = :TEMSILCI_ID";
			$filtre[":TEMSILCI_ID"] = $_SESSION['kullanici_id'];
			
		} else if(in_array($_SESSION['yetki_id'], array(4,8))){			
			$sql.=" AND C.ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_SESSION['cari_id'];
			
		} else if($_SESSION['yetki_id'] == 5){			
			
			
		} 
		
		return array($sql, $filtre);
		
	}
	
	function fncSqlTalep(&$sql, &$filtre){
		if(in_array($_SESSION['yetki_id'], array(6,9))){
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_SESSION['filo_id'];
			
		}
		
	}
	
	function fncSqlCariHareket(&$sql, &$filtre){
		if(in_array($_SESSION['yetki_id'], array(4,8))){
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_SESSION['cari_id'];
		} else if(in_array($_SESSION['yetki_id'], array(3))){
			$sql.=" AND C.TEMSILCI_ID = :TEMSILCI_ID";
			$filtre[":TEMSILCI_ID"] = $_SESSION['kullanici_id'];
		}
		
	}
	
	function fncSqlCariHareketCari(&$sql, &$filtre){
		if(in_array($_SESSION['yetki_id'], array(4,8))){
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_SESSION['cari_id'];
		} else if(in_array($_SESSION['yetki_id'], array(3))){
			$sql.=" AND C.TEMSILCI_ID = :TEMSILCI_ID";
			$filtre[":TEMSILCI_ID"] = $_SESSION['kullanici_id'];
		}	
	}
	
	function fncSqlArac(&$sql, &$filtre){
		if(in_array($_SESSION['yetki_id'], array(6,9))){
			$sql.=" AND A.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_SESSION['filo_id'];
			
		}
		
	}
	
	
	function fncSqlKullanici(&$sql, &$filtre){
		if($_SESSION['hizmet_noktasi'] == 1){			
			$sql.=" AND T.SERVIS_ID = :SERVIS_ID";
			$filtre[":SERVIS_ID"] = $_SESSION['kullanici_id'];
			
		}	
		
	}
	
	function fncMutabakatSms($IHALE_ID){
		global $cdbPDO, $cSms;
		
		$filtre = array();
		$sql = "SELECT
					I.ID,
                    I.IHALE_NO,
                    MA.MARKA,
                    MO.MODEL,
					IC.CEVAPLAYAN_ID,
                    K.ID AS KULLANICI_ID,
                    CONCAT_WS(' ', K.AD, K.SOYAD) AS AD_SOYAD,
                    K.AD,
                    K.SOYAD,
                    K.CEPTEL
				FROM IHALE AS I
					LEFT JOIN MARKA AS MA ON MA.ID = I.MARKA_ID
                    LEFT JOIN MODEL AS MO ON MO.ID = I.MODEL_ID
					LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID AND IC.ENB = 1
					LEFT JOIN KULLANICI AS K ON K.ID = IC.CEVAPLAYAN_ID
				WHERE I.ID = :ID
				";
		$filtre[":ID"] 			= $IHALE_ID;
		$row = $cdbPDO->row($sql, $filtre);
		
		if(is_null($row->KULLANICI_ID) OR strlen($row->CEPTEL) != 14 ){
			return "";
		}
		
		$filtre = array();
		$sql = "SELECT
					SK.ID,
					SK.SMS_KALIBI
				FROM SMS_KALIBI AS SK
				WHERE SK.ID = :ID
				";
		$filtre[":ID"] 			= 2;
		$row_sms_kalibi = $cdbPDO->row($sql, $filtre);
		
		$row->MODEL		= FormatYazi::kisalt($row->MODEL, 10);
		$row_sms_kalibi->SMS_KALIBI = str_replace('{IHALE_NO}', $row->IHALE_NO, $row_sms_kalibi->SMS_KALIBI);
		$row_sms_kalibi->SMS_KALIBI = str_replace('{MARKA}', $row->MARKA, $row_sms_kalibi->SMS_KALIBI);
		$row_sms_kalibi->SMS_KALIBI = str_replace('{MODEL}', $row->MODEL, $row_sms_kalibi->SMS_KALIBI);
		
		$filtre	= array();
		$sql = "INSERT INTO DUYURU SET 	ALICILAR 			= :ALICILAR,
		 								YAYINLAYAN_ID 		= :YAYINLAYAN_ID,
		 								BASLIK				= :BASLIK,
		 								KONU				= :KONU,
		 								DUYURU_BAS_TARIH	= CURDATE(),
		 								DUYURU_BIT_TARIH	= CURDATE(),
		 								GONDERIM_SEKLI		= :GONDERIM_SEKLI
										";
		$filtre[":ALICILAR"] 			= $row->KULLANICI_ID;
		$filtre[":YAYINLAYAN_ID"] 		= $_SESSION['kullanici_id'];
		$filtre[":BASLIK"] 				= $row->IHALE_NO ." - ". $row->AD_SOYAD;
		$filtre[":KONU"] 				= nl2br($row_sms_kalibi->SMS_KALIBI);
		$filtre[":GONDERIM_SEKLI"] 		= "SMS";
		$mesaj_id = $cdbPDO->lastInsertId($sql, $filtre);
		
		$result = $cSms->soapGonder(FormatTel::smsTemizle($row->CEPTEL), "FINAL YZLM", $row_sms_kalibi->SMS_KALIBI);
		
	}
	
	function is_pdf($file){
		$arr = explode('.', $file);
		if(strtoupper($arr[count($arr)-1]) == "PDF"){
			return true;
		}
		return false;
	}

	function fncSorumluAta($TALEP_ID){
		global $cdbPDO;
		
		$filtre	= array();
		$sql = "SELECT 
					K.ID,
					K.KULLANICI,
					TS.ATAMA_TARIHI
				FROM KULLANICI AS K 
					LEFT JOIN (SELECT SORUMLU_ID, MAX(ATAMA_TARIHI) AS ATAMA_TARIHI FROM TALEP_SORUMLU GROUP BY SORUMLU_ID) AS TS ON TS.SORUMLU_ID = K.ID
				WHERE K.YETKI_ID = 3 AND K.DURUM = 1
				ORDER BY TS.ATAMA_TARIHI
				LIMIT 1
				";
		$row = $cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "INSERT INTO TALEP_SORUMLU SET TALEP_ID = :TALEP_ID, SORUMLU_ID = :SORUMLU_ID";
		$filtre[":TALEP_ID"] 		= $TALEP_ID;
		$filtre[":SORUMLU_ID"] 		= $row->ID;
		$cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET SORUMLU_ID = :SORUMLU_ID WHERE ID = :ID";
		$filtre[":SORUMLU_ID"]		= $row->ID;
		$filtre[":ID"] 				= $TALEP_ID;
		$cdbPDO->rowsCount($sql, $filtre);
		return $row->ID;
		
	}
	
	function fncResimSirala($IHALE_ID){
		global $cdbPDO;
		
		$filtre	= array();
		$sql = "SELECT ID FROM IHALE_RESIM WHERE IHALE_ID = :IHALE_ID AND EVRAK_ID = 0 ORDER BY SIRA, TARIH ASC";
		$filtre[":IHALE_ID"]	= $IHALE_ID;
		$rows_resim = $cdbPDO->rows($sql, $filtre);
		
		foreach($rows_resim as $key => $row_resim){
			$filtre	= array();
			$sql = "UPDATE IHALE_RESIM SET SIRA = :SIRA WHERE ID = :ID";
			$filtre[":SIRA"]		= ($key+1);
			$filtre[":ID"]			= $row_resim->ID;
			$cdbPDO->rowsCount($sql, $filtre);
		}
		
	}
	
	function fncLink(){
		$str = $_SERVER['REQUEST_URI'];
		return $str;
	}
	
	function fncFormKey(){
		$key = md5(md5(session_id()));
		return $key;
	}
	
	function fncHizmetSurecYaz($row){
		if(is_null($row->ID)){
			return "";
		}
		
		return '&nbsp;<span class="badge badge-warning">'. $row->SUREC. '</span>';
	}
	
	// https://github.com/tazotodua/useful-php-scripts 
	function EXPORT_DATABASE($host, $user, $pass, $name, $tables = false, $backup_name = false, $download = true){
		set_time_limit(3000); $mysqli = new mysqli($host,$user,$pass,$name); $mysqli->select_db($name); $mysqli->query("SET NAMES 'utf8'");
		$queryTables = 
		$mysqli->query('SHOW TABLES'); 
		while($row = $queryTables->fetch_row()) { 
			$target_tables[] = $row[0]; 
		}	
		
		if($tables !== false) { 
			$target_tables = array_intersect( $target_tables, $tables); 
		} 
		
		$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
		foreach($target_tables as $table){
			if (empty($table)){ continue; } 
			$result	= $mysqli->query('SELECT * FROM `'.$table.'`');  	$fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows; 	$res = $mysqli->query('SHOW CREATE TABLE '.$table);	$TableMLine=$res->fetch_row(); 
			$content .= "\n\n".$TableMLine[1].";\n\n";   $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
			for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
				while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
					if ($st_counter%100 == 0 || $st_counter == 0 )	{$content .= "\nINSERT INTO ".$table." VALUES";}
						$content .= "\n(";    for($j=0; $j<$fields_amount; $j++){ $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ;}  else{$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}   }        $content .=")";
					//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
					if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";}	$st_counter=$st_counter+1;
				}
			} $content .="\n\n\n";
		}
		$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
		$backup_name = $backup_name ? $backup_name : $name ."_". date('Y-m-d') . "_" . date('H-i-s') . '.sql';
		ob_get_clean(); 
		if($download){
			header('Content-Type: application/octet-stream');  
			header("Content-Transfer-Encoding: Binary");  
			header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );    
			header("Content-disposition: attachment; filename=\"".$backup_name."\""); 	
		} else {
			file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/cron/" . $backup_name, $content);	
		}
		//echo $content; exit;
	}
	
	function IMPORT_TABLES($host,$user,$pass,$dbname, $sql_file_OR_content){
		set_time_limit(3000);
		$SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ?  $sql_file_OR_content : file_get_contents($sql_file_OR_content)  );  
		$allLines = explode("\n",$SQL_CONTENT); 
		$mysqli = new mysqli($host, $user, $pass, $dbname); if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();} 
			$zzzzzz = $mysqli->query('SET foreign_key_checks = 0');	        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n". $SQL_CONTENT, $target_tables); foreach ($target_tables[2] as $table){$mysqli->query('DROP TABLE IF EXISTS '.$table);}         $zzzzzz = $mysqli->query('SET foreign_key_checks = 1');    $mysqli->query("SET NAMES 'utf8'");	
		$templine = '';	// Temporary variable, used to store current query
		foreach ($allLines as $line)	{											// Loop through each line
			if (substr($line, 0, 2) != '--' && $line != '') {$templine .= $line; 	// (if it is not a comment..) Add this line to the current segment
				if (substr(trim($line), -1, 1) == ';') {		// If it has a semicolon at the end, it's the end of the query
					if(!$mysqli->query($templine)){ print('Error performing query \'<strong>' . $templine . '\': ' . $mysqli->error . '<br /><br />');  }  $templine = ''; // set variable to empty, to start picking up the lines after ";"
				}
			}
		}	return 'Importing finished. Now, Delete the import file.';
	}   //see also export.php 
	
	
	function fncYaziKucult($keyword){
		$low = array('a','b','c','ç','d','e','f','g','ğ','h','ı','i','j','k','l','m','n','o','ö','p','r','s','ş','t','u','ü','v','y','z','q','w','x');
		$upp = array('A','B','C','Ç','D','E','F','G','Ğ','H','I','İ','J','K','L','M','N','O','Ö','P','R','S','Ş','T','U','Ü','V','Y','Z','Q','W','X');
		$keyword = str_replace( $upp, $low, $keyword );
		$keyword = function_exists( 'mb_strtolower' ) ? mb_strtolower( $keyword ) : $keyword;
		return $keyword;
	}
	
	function fncYaziBuyult($keyword){
		$low = array('a','b','c','ç','d','e','f','g','ğ','h','ı','i','j','k','l','m','n','o','ö','p','r','s','ş','t','u','ü','v','y','z','q','w','x');
		$upp = array('A','B','C','Ç','D','E','F','G','Ğ','H','I','İ','J','K','L','M','N','O','Ö','P','R','S','Ş','T','U','Ü','V','Y','Z','Q','W','X');
		$keyword = str_replace( $low, $upp, $keyword );
		$keyword = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $keyword ) : $keyword;
		return $keyword;
	}
	
	function mungXML($xml)
	{
	    $obj = SimpleXML_Load_String($xml);
	    if ($obj === FALSE) return $xml;

	    // GET NAMESPACES, IF ANY
	    $nss = $obj->getNamespaces(TRUE);
	    if (empty($nss)) return $xml;

	    // CHANGE ns: INTO ns_
	    $nsm = array_keys($nss);
	    foreach ($nsm as $key)
	    {
	        // A REGULAR EXPRESSION TO MUNG THE XML
	        $rgx
	        = '#'               // REGEX DELIMITER
	        . '('               // GROUP PATTERN 1
	        . '\<'              // LOCATE A LEFT WICKET
	        . '/?'              // MAYBE FOLLOWED BY A SLASH
	        . preg_quote($key)  // THE NAMESPACE
	        . ')'               // END GROUP PATTERN
	        . '('               // GROUP PATTERN 2
	        . ':{1}'            // A COLON (EXACTLY ONE)
	        . ')'               // END GROUP PATTERN
	        . '#'               // REGEX DELIMITER
	        ;
	        // INSERT THE UNDERSCORE INTO THE TAG NAME
	        $rep
	        = '$1'          // BACKREFERENCE TO GROUP 1
	        . '_'           // LITERAL UNDERSCORE IN PLACE OF GROUP 2
	        ;
	        // PERFORM THE REPLACEMENT
	        $xml =  preg_replace($rgx, $rep, $xml);
	    }
	    return $xml;
	}
	
	function GUID() {
	    if (function_exists('com_create_guid') === true) {
	        return trim(com_create_guid(), '{}');
	    }
	    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	function fncCurl($url, $postFields, $strCookie, $header = ""){
	   	//$post 	= http_build_query($postFields, '=', '&');
		$post = "draw=3&columns%5B0%5D%5Bdata%5D=plate_no&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=product_no&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=sub_firm_name&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=entry_date&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=exit_date&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B5%5D%5Bdata%5D=entry_station&columns%5B5%5D%5Bname%5D=&columns%5B5%5D%5Bsearchable%5D=true&columns%5B5%5D%5Borderable%5D=true&columns%5B5%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B5%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B6%5D%5Bdata%5D=exit_station&columns%5B6%5D%5Bname%5D=&columns%5B6%5D%5Bsearchable%5D=true&columns%5B6%5D%5Borderable%5D=true&columns%5B6%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B6%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B7%5D%5Bdata%5D=highway&columns%5B7%5D%5Bname%5D=&columns%5B7%5D%5Bsearchable%5D=true&columns%5B7%5D%5Borderable%5D=true&columns%5B7%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B7%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B8%5D%5Bdata%5D=fee&columns%5B8%5D%5Bname%5D=&columns%5B8%5D%5Bsearchable%5D=true&columns%5B8%5D%5Borderable%5D=true&columns%5B8%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B8%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B9%5D%5Bdata%5D=product_no&columns%5B9%5D%5Bname%5D=&columns%5B9%5D%5Bsearchable%5D=true&columns%5B9%5D%5Borderable%5D=false&columns%5B9%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B9%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=3&order%5B0%5D%5Bdir%5D=desc&start=0&length=10&search%5Bvalue%5D=&search%5Bregex%5D=false&plate_no=&start_date=2020-11-25&end_date=2020-12-02";
		$post = urldecode($post);
		/*
		curl_setopt($ch, CURLOPT_AUTOREFERER , TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION  , TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER  , TRUE);
		*/
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31');
		curl_setopt($ch, CURLOPT_SSLVERSION, 1);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_COOKIE, $strCookie );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
	
	function fncCurlGet($url, $postFields, $strCookie = "", $header = ""){
	   	$post 	= http_build_query($postFields, '=', '&');
	   	
		$curl = curl_init();
		curl_setopt_array($curl, array(
		 	CURLOPT_URL => $url,
		  	CURLOPT_HTTPHEADER => array("Host:,"),
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_ENCODING => '',
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 10,
		  	CURLOPT_FOLLOWLOCATION => true,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);

		curl_close($curl);
		var_dump2($response);
		return $response;
	}
	
	function fncSozlesmeNo($row){
		return FormatTarih::Yil($row->SOZLESME_TARIH) . FormatTarih::Ay($row->SOZLESME_TARIH) . str_pad($row->ID,4,"0",STR_PAD_LEFT);
	}
	
	function fncTalepMailGonder($ID){
		global $cdbPDO, $cMail;
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $ID;
		$row = $cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $row->CARI_ID;
		$row_cari = $cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT * FROM KULLANICI WHERE ID = :ID";
		$filtre[":ID"] 	= $row_cari->TEMSILCI_ID;
		$row_temsilci = $cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID ORDER BY SIRA ASC";
		$filtre[":CARI_HAREKET_ID"] 	= $row->ID;
		$rows_detay = $cdbPDO->rows($sql, $filtre); 
		
		
		$Alfabe = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
	   
	  	$objPHPExcel = new PHPExcel();
	  	
		$objPHPExcel->getProperties()->setCreator("TRPARTS")
									 ->setLastModifiedBy("TRPARTS");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Sayfa1');	  
		
		$objPHPExcel->getActiveSheet()->mergeCells('A1:G1')->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:G1')->getStyle('A1:G1')->getFont()->setSize(22)->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells('A2:B2')->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->mergeCells('C2:G2')->getStyle('C2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->mergeCells('A3:B3')->getStyle('A3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->mergeCells('C3:G3')->getStyle('C3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->mergeCells('A4:B4')->getStyle('A4:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->mergeCells('C4:G4')->getStyle('C4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->mergeCells('A5:B5')->getStyle('A4:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->mergeCells('C5:G5')->getStyle('C4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->mergeCells('A10:G10')->getStyle('A10:G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A10:G10')->getStyle('A10:G10')->getFont()->setSize(16);
		$objPHPExcel->getActiveSheet()->mergeCells('A10:G10')->getStyle('A10:G10')->getFont()->setSize(22)->setBold(true);
		
		$objPHPExcel->getActiveSheet()->setCellValue("A1", "Sipariş Listesi");
		$objPHPExcel->getActiveSheet()->setCellValue("A2", "Sipariş No :");
		$objPHPExcel->getActiveSheet()->setCellValue("C2", $row->ID);
		$objPHPExcel->getActiveSheet()->setCellValue("A3", "Cari :");	
		$objPHPExcel->getActiveSheet()->setCellValue("C3", $row_cari->CARI);
		$objPHPExcel->getActiveSheet()->setCellValue("A4", "Sipariş Tarih :");
		$objPHPExcel->getActiveSheet()->setCellValue("C4", $row->TARIH);
		$objPHPExcel->getActiveSheet()->setCellValue("A5", "Temsilci :");
		$objPHPExcel->getActiveSheet()->setCellValue("C5", $row_temsilci->UNVAN);
		
		$objPHPExcel->getActiveSheet()->setCellValue("A10", "Parça Listesi");
		$objPHPExcel->getActiveSheet()->setCellValue("A11", "#");
		$objPHPExcel->getActiveSheet()->setCellValue("B11", "Parça Kodu");
		$objPHPExcel->getActiveSheet()->setCellValue("C11", "Oem Kodu");
		$objPHPExcel->getActiveSheet()->setCellValue("D11", "Parça Adı");
		$objPHPExcel->getActiveSheet()->setCellValue("E11", "Fiyat");
		$objPHPExcel->getActiveSheet()->setCellValue("F11", "Adet");
		$objPHPExcel->getActiveSheet()->setCellValue("G11", "Tutar");
		
		foreach($rows_detay as $key => $row_detay){
			$objPHPExcel->getActiveSheet()->setCellValue("A".($key+12), $row_detay->SIRA );	
			$objPHPExcel->getActiveSheet()->setCellValue("B".($key+12), $row_detay->PARCA_KODU );	
			$objPHPExcel->getActiveSheet()->setCellValue("C".($key+12), $row_detay->OEM_KODU );	
			$objPHPExcel->getActiveSheet()->setCellValue("D".($key+12), $row_detay->PARCA_ADI );	
			$objPHPExcel->getActiveSheet()->setCellValue("E".($key+12), FormatSayi::nokta2($row_detay->FIYAT) );	
			$objPHPExcel->getActiveSheet()->setCellValue("F".($key+12), $row_detay->ADET );	
			$objPHPExcel->getActiveSheet()->setCellValue("G".($key+12), FormatSayi::nokta2($row_detay->TUTAR) );	
		}
		
		// Redirect output to a client’s web browser (Excel5)
		/*
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;filename=Siparis{$row->ID}.xlsx");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter->save("/talep/Siparis{$row->ID}.xlsx");
		*/
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace(__FILE__,$_SERVER['DOCUMENT_ROOT'] ."/musteri/Siparis{$row->ID}.xlsx",__FILE__));		
		
		$sonuc = $cMail->Gonder2("info@boryaz.com", "Sipariş", "Sipariş Oluşturuldu","", $_SERVER['DOCUMENT_ROOT'] . "/musteri/Siparis{$row->ID}.xlsx", "Siparis{$row->ID}.xlsx");
		
		return $sonuc;
	}
	
	function fncMarka($str){
		$str = trim($str);
		
		if(strlen(str_replace("ALFA ROMEO","",$str)) != strlen($str)){
			$ID = 3;
		} else if(strlen(str_replace("ASTON MARTIN","",$str)) != strlen($str)){
			$ID = 6;
		} else if(strlen(str_replace("AUDI","",$str)) != strlen($str)){
			$ID = 8;
		} else if(strlen(str_replace("BENTLEY","",$str)) != strlen($str)){
			$ID = 10;
		} else if(strlen(str_replace("BMC","",$str)) != strlen($str)){
			$ID = 124;
		} else if(strlen(str_replace("BMW","",$str)) != strlen($str)){
			$ID = 12;
		} else if(strlen(str_replace("BUGATTI","",$str)) != strlen($str)){
			$ID = 14;
		} else if(strlen(str_replace("CADILLAC","",$str)) != strlen($str)){
			$ID = 18;
		} else if(strlen(str_replace("CHERY","",$str)) != strlen($str)){
			$ID = 20;
		}  else if(strlen(str_replace("CHEVROLET","",$str)) != strlen($str)){
			$ID = 21;
		}  else if(strlen(str_replace("CHRYSLER","",$str)) != strlen($str)){
			$ID = 143;
		} else if(strlen(str_replace("CITROEN","",$str)) != strlen($str)){
			$ID = 23;
		} else if(strlen(str_replace("DACIA","",$str)) != strlen($str)){
			$ID = 25;
		} else if(strlen(str_replace("DAIHATSU","",$str)) != strlen($str)){
			$ID = 27;
		} else if(strlen(str_replace("DFM","",$str)) != strlen($str)){
			$ID = 141;
		} else if(strlen(str_replace("FERRARI","",$str)) != strlen($str)){
			$ID = 33;
		} else if(strlen(str_replace("FIAT","",$str)) != strlen($str)){
			$ID = 34;
		} else if(strlen(str_replace("FORD","",$str)) != strlen($str)){
			$ID = 37;
		} else if(strlen(str_replace("GEELY","",$str)) != strlen($str)){
			$ID = 40;
		} else if(strlen(str_replace("GONOW","",$str)) != strlen($str)){
			$ID = 42;
		} else if(strlen(str_replace("HONDA","",$str)) != strlen($str)){
			$ID = 50;
		} else if(strlen(str_replace("HYUNDAI","",$str)) != strlen($str)){
			$ID = 54;
		} else if(strlen(str_replace("INFINITI","",$str)) != strlen($str)){
			$ID = 56;
		} else if(strlen(str_replace("ISUZU","",$str)) != strlen($str)){
			$ID = 59;
		} else if(strlen(str_replace("IVECO","",$str)) != strlen($str)){
			$ID = 19;
		} else if(strlen(str_replace("JAGUAR","",$str)) != strlen($str)){
			$ID = 61;
		} else if(strlen(str_replace("JEEP","",$str)) != strlen($str)){
			$ID = 22;
		} else if(strlen(str_replace("KIA","",$str)) != strlen($str)){
			$ID = 64;
		} else if(strlen(str_replace("LADA","",$str)) != strlen($str)){
			$ID = 67;
		} else if(strlen(str_replace("LAMBORGHINI","",$str)) != strlen($str)){
			$ID = 68;
		} else if(strlen(str_replace("LANCIA","",$str)) != strlen($str)){
			$ID = 69;
		} else if(strlen(str_replace("LAND ROVER","",$str)) != strlen($str)){
			$ID = 70;
		} else if(strlen(str_replace("LEXUS","",$str)) != strlen($str)){
			$ID = 71;
		} else if(strlen(str_replace("MAHINDRA","",$str)) != strlen($str)){
			$ID = 74;
		} else if(strlen(str_replace("MAN","",$str)) != strlen($str)){
			$ID = 75;
		} else if(strlen(str_replace("MASERATI","",$str)) != strlen($str)){
			$ID = 76;
		} else if(strlen(str_replace("MAZDA","",$str)) != strlen($str)){
			$ID = 78;
		} else if(strlen(str_replace("MERCEDES","",$str)) != strlen($str)){
			$ID = 81;
		} else if(strlen(str_replace("MINI","",$str)) != strlen($str)){
			$ID = 84;
		} else if(strlen(str_replace("MITSUBISHI","",$str)) != strlen($str)){
			$ID = 85;
		} else if(strlen(str_replace("NISSAN","",$str)) != strlen($str)){
			$ID = 90;
		} else if(strlen(str_replace("OPEL","",$str)) != strlen($str)){
			$ID = 91;
		} else if(strlen(str_replace("PEUGEOT","",$str)) != strlen($str)){
			$ID = 95;
		} else if(strlen(str_replace("PORSCHE","",$str)) != strlen($str)){
			$ID = 100;
		} else if(strlen(str_replace("RANGE ROVER","",$str)) != strlen($str)){
			$ID = 103;
		} else if(strlen(str_replace("RENAULT","",$str)) != strlen($str)){
			$ID = 104;
		} else if(strlen(str_replace("SAAB","",$str)) != strlen($str)){
			$ID = 144;
		} else if(strlen(str_replace("SCANIA","",$str)) != strlen($str)){
			$ID = 108;
		} else if(strlen(str_replace("SEAT","",$str)) != strlen($str)){
			$ID = 112;
		} else if(strlen(str_replace("SKODA","",$str)) != strlen($str)){
			$ID = 116;
		} else if(strlen(str_replace("SSANGYONG","",$str)) != strlen($str)){
			$ID = 119;
		} else if(strlen(str_replace("SUBARU","",$str)) != strlen($str)){
			$ID = 120;
		} else if(strlen(str_replace("SUZUKI","",$str)) != strlen($str)){
			$ID = 121;
		} else if(strlen(str_replace("TATA","",$str)) != strlen($str)){
			$ID = 123;
		} else if(strlen(str_replace("TESLA","",$str)) != strlen($str)){
			$ID = 127;
		} else if(strlen(str_replace("TOYOTA","",$str)) != strlen($str)){
			$ID = 131;
		} else if(strlen(str_replace("VOLKSWAGEN","",$str)) != strlen($str)){
			$ID = 137;
		} else if(strlen(str_replace("VOLVO","",$str)) != strlen($str)){
			$ID = 138;
		} else if(strlen(str_replace("WIESMANN","",$str)) != strlen($str)){
			$ID = 140;
		} else {
			$ID = 0;
		}
		
		return $ID;
	}
	
	function fncTedarikciAlisFiyat($row_cari, $alis){
		$alis = trim($alis);
		$fiyat = $alis * ((100 - $row_cari->ISKONTO1)/100) * ((100 - $row_cari->ISKONTO2)/100) * ((100 - $row_cari->ISKONTO3)/100);
		return $fiyat;
	}
	
	function fncTedarikciSatisFiyat($row_cari, $alis){
		$alis = trim($alis);
		$fiyat = $alis * ((100 - $row_cari->ISKONTO1)/100) * ((100 - $row_cari->ISKONTO2)/100) * ((100 - $row_cari->ISKONTO3)/100) * ((100 + $row_cari->KAR_ORANI)/100);
		return $fiyat;
	}
	
	function fncCariParaBirimGoster($fiyat, $para_birimi, $rows_doviz, $alis_satis = 1){
		if($_SESSION['cari_id'] > 0 AND count($rows_doviz) > 0){
			if($para_birimi == "USD"){
				$fiyat = $fiyat / $rows_doviz->DOLAR->ALIS;
			} else if($para_birimi == "EUR"){
				$fiyat = $fiyat / $rows_doviz->EURO->ALIS;
			} else if($para_birimi == "GBP"){
				$fiyat = $fiyat / $rows_doviz->STERLIN->ALIS;
			} else {
				$fiyat = $fiyat;
			}
		}
		
		return FormatSayi::sayi($fiyat,2);
	}
	
	function fncDurumSpan($durum){
		if($durum == "0"){
			$html = '<span class="badge badge-danger">Pasif</span>';
		} else if($durum == "1"){
			$html = '<span class="badge badge-success">Aktif</span>';
		}
		
		return $html;
	}
	