<?

class tableData{
	
	private $cdbPDO;
	private $dbPDO;
	private $rowss;
    private $rows;
    private $sql;
    private $sqls;
    private $sayfa;
    private $excel;
    private $excelDosyaAdi;
    private $post;
    private $filtre;
    private $tumData;
    private $sayfaIlk;
    private $sayfaSon;		
    private $sayfaAdet;	
    private $sayfaUstYazi;	
    private $sayfaAltYazi;	
    private $dataa = 15;
	
	function __construct($cdbPDO) {
        $this->cdbPDO 	= $cdbPDO;
	}
	
	// Sql kodunun ne olduğunun öğrenmesi adına debug için kullanmaya
    public function setTemizle(){
        $this->secim = "";
		$this->tumu = "";
		$this->name = "";
		$this->tumuValue = "";
        $this->tumuName = "";
        $this->clss = "";
        
    }
    
    // setPost("Plaka","34")
    public function setOnePost($post, $val){
        $this->post[$post] = $val;
        return $this;
    }
    
    // setPost($_REQUEST) ile tüm parametreleri alma
    public function setPost($post){
        $this->post = $post;
        return $this;
    }
    
    // çalıştırılacak function u belirleme
    public function setSayfa($sayfa){
        $this->sayfa = $sayfa;
        return $this;
        
    }	
    
    // excelOut alınacak Sutün bilgileri
    public function setExcel($excel){
        $this->excel = $excel;
        return $this;
        
    }	

	// excel Başlıgı
    public function setExcelDosyaAdi($excelDosyaAdi){
        $this->excelDosyaAdi = $excelDosyaAdi;
        return $this;
        
    }
    
    public function setTrim(){
		foreach($_REQUEST as $key => $val){
			if(is_array($val)){
				foreach($val as $key2 => $valval){
					if(is_array($val)){
						foreach($valval as $key3 => $valvalval){
							$_REQUEST[$key][$key2][$key3]	= trim($valvalval);
						}
					}
					$_REQUEST[$key][$key2]	= trim($valval);
				}
			} else {
				$_REQUEST[$key]	= trim($val);	
			}
			
		}
		
	}
    
    // foksiyonu çalıştır
    public function Uygula(){
    	if(!method_exists($this, $this->sayfa)){
			echo "İstenen Tablo fonksiyon bulunamadı. Tablo: " . $this->sayfa;
		}
		
		if(!$_REQUEST['filtre']) return $this;
		
		$this->setTrim();
		$this->{$this->sayfa}();
        return $this;
        
    }
    
    /*
    <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true"><i class="far fa-arrow-alt-to-left"></i></span></a></li>
    <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true"><i class="far fa-arrow-alt-left"></i></span></a></li>
    <li class="page-item active" aria-current="page"><span class="page-link">1<span class="sr-only">(current)</span></span></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true"><i class="far fa-arrow-alt-right"></i></span></a></li>
    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true"><i class="far fa-arrow-alt-to-right"></i></span></a></li>
    */
    
    // sayfalama için mutlak
    public function setSayfalama1($sayfa, $sayfaToplam, $sayfaAdet) { 

		//Sayfalama için ekledim.
		if(intval($sayfa)<=0 || intval($sayfaToplam)<($sayfa-1)*$sayfaAdet) $sayfa = 1;
		if(intval($sayfaAdet)<=0) $sayfaAdet = 20;
		$sayfaIlk 	= ($sayfa-1) * $sayfaAdet;
		$sayfaSon 	= $sayfa * $sayfaAdet;
		
		$sayfaSayisi = ceil($sayfaToplam/$sayfaAdet);
		$sayfaAltYazi = "";
		for($i = 1; $i <= $sayfaSayisi; $i++){
			if($i==$sayfa) {
				$sayfaAltYazi .= "<li class=\"page-item active\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$i,'')\" aria-label=\"Previous\"> $i </a></li>";
			} else {
				$sayfaAltYazi .= "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$i,'')\" aria-label=\"Previous\"> $i </a></li>";
			}			
			
			if($i%50 == 0) $sayfaAltYazi .= "<br>";
		}
		if($sayfaToplam>0) {
			$sayfaUstYazi = $sayfaToplam . " Sonuç içinde " . ($sayfaIlk+1) . " - " . (($sayfaToplam>$sayfaSon)?$sayfaSon:$sayfaToplam) . " arası sonuçlar"; 
			$sayfaOnceki  = $sayfa - 1;
			$sayfaSonraki = $sayfa + 1; 
			if($sayfa == 1){
				$sayfaAltYazi = "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',1,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-left\"></i></a></li>" . $sayfaAltYazi;
			} else{
				$sayfaAltYazi = "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$sayfaOnceki,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-to-left\"></i></a></li>" . $sayfaAltYazi;
			}
			if($sayfa == $sayfaSayisi){
				$sayfaAltYazi = $sayfaAltYazi . "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$sayfaSayisi,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-right\"></i></a></li>";
			} else{
				$sayfaAltYazi = $sayfaAltYazi . "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$sayfaSonraki,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-right\"></i></a></li>";
			}
			$sayfaAltYazi = "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',1,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-to-left\"></i></a></li>" . $sayfaAltYazi;
			$sayfaAltYazi = $sayfaAltYazi . "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$sayfaSayisi,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-to-right\"></i></a></li>";
			
		} else {
			$sayfaUstYazi = "0 Kayıt Bulundu... ";		
			
		}
		
		$this->sayfaUstYazi = $sayfaUstYazi;
		$this->sayfaAltYazi = $sayfaAltYazi;
		$this->sayfaIlk = $sayfaIlk;
		$this->sayfaSon = $sayfaSon;
		$this->sayfaAdet = $sayfaAdet;
		$this->sayfa = $sayfa;
		
		
	}	
		
	public function setSayfalama2($sayfa, $sayfaToplam, $sayfaAdet) { 

		//Sayfalama için ekledim.
		if(intval($sayfa)<=0 || intval($sayfaToplam)<($sayfa-1)*$sayfaAdet) $sayfa = 1;
		if(intval($sayfaAdet)<=0) $sayfaAdet = 20;
		$sayfaIlk 	= ($sayfa-1) * $sayfaAdet;
		$sayfaSon 	= $sayfa * $sayfaAdet;
		
		$sayfaSayisi = ceil($sayfaToplam/$sayfaAdet);
		$sayfaAltYazi = "";
		
		if($sayfaSayisi > 26){
			$bas_i	= $sayfa - 13 + ($sayfa < 13 ? 13 - $bas_i : 0 );
			$bas_i	= $sayfa < 13 ? 1 : $sayfa - 13;
			$bas_ucnokta	= ($bas_i) > 1 ? "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',1,'')\" aria-label=\"Previous\"> ... </a></li>" : "";
			
			$bit_i	= $sayfa + 13 + ($sayfa < 13 ? 13 - $sayfa : 0);
			$bit_i	= $bit_i > $sayfaSayisi ? $sayfaSayisi : $bit_i;
			$bit_ucnokta	= ($bit_i) < $sayfaSayisi ? "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$sayfaSayisi,'')\" aria-label=\"Previous\"> ... </a></li>" : "";
		} else {
			$bas_i 	= 1;
			$bit_i	= $sayfaSayisi;
		}
			
		for($i = $bas_i; $i <= $bit_i; $i++){
			if($i==$sayfa) {
				$sayfaAltYazi .= "<li class=\"page-item active\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$i,'')\" aria-label=\"Previous\"> $i </a></li>";
			} else {
				$sayfaAltYazi .= "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$i,'')\" aria-label=\"Previous\"> $i </a></li>";
			}
		}
		
		if($sayfaToplam>0) {
			$sayfaUstYazi = $sayfaToplam . " Sonuç içinde " . ($sayfaIlk+1) . " - " . (($sayfaToplam>$sayfaSon)?$sayfaSon:$sayfaToplam) . " arası sonuçlar"; 
			$sayfaOnceki  = $sayfa - 1;
			$sayfaSonraki = $sayfa + 1; 
			
			if($sayfa == 1){
				$sayfaAltYazi = "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',1,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-left\"></i></a></li>" . $sayfaAltYazi;
			} else{
				$sayfaAltYazi = "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$sayfaOnceki,'')\" aria-label=\"Previous\"> <i class=\"far fa-arrow-alt-left\"></i> </a></li>" . $bas_ucnokta . $sayfaAltYazi;
			}
			
			if($sayfa == $sayfaSayisi){
				$sayfaAltYazi = $sayfaAltYazi . "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$sayfaSayisi,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-right\"></i></a></li>";
			} else{
				$sayfaAltYazi = $sayfaAltYazi . $bit_ucnokta . "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$sayfaSonraki,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-right\"></i></a></li>";
			}
			
			$sayfaAltYazi = "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',1,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-to-left\"></i></a></li>" . $sayfaAltYazi;
			$sayfaAltYazi = $sayfaAltYazi . "<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:fsubmit('form',$sayfaSayisi,'')\" aria-label=\"Previous\"><i class=\"far fa-arrow-alt-to-right\"></i></a></li>";
			
		} else {
			$sayfaUstYazi = "0 Kayıt Bulundu... ";		
			
		}
		
		$this->sayfaUstYazi = $sayfaUstYazi;
		$this->sayfaAltYazi = $sayfaAltYazi;
		$this->sayfaIlk = $sayfaIlk;
		$this->sayfaSon = $sayfaSon;
		$this->sayfaAdet = $sayfaAdet;
		$this->sayfa = $sayfa;
		
	}
	
	// sayfalama için mutlak
    public function setSayfalama3($sayfa, $sayfaToplam, $sayfaAdet) { 

		//Sayfalama için ekledim.
		if(intval($sayfa)<=0 || intval($sayfaToplam)<($sayfa-1)*$sayfaAdet) $sayfa = 1;
		if(intval($sayfaAdet)<=0) $sayfaAdet = 20;
		$sayfaIlk 	= ($sayfa-1) * $sayfaAdet;
		$sayfaSon 	= $sayfa * $sayfaAdet;
		
		$sayfaSayisi = ceil($sayfaToplam/$sayfaAdet);
		$sayfaAltYazi = "";
		
		if($sayfaSayisi > 26){
			$bas_i	= $sayfa - 13 + ($sayfa < 13 ? 13 - $bas_i : 0 );
			$bas_i	= $sayfa < 13 ? 1 : $sayfa - 13;
			$bas_ucnokta	= ($bas_i) > 1 ? "<li><a href=\"javascript:fsubmit('form',1,'')\"> ... </a></li>" : "";
			
			$bit_i	= $sayfa + 13 + ($sayfa < 13 ? 13 - $sayfa : 0);
			$bit_i	= $bit_i > $sayfaSayisi ? $sayfaSayisi : $bit_i;
			$bit_ucnokta	= ($bit_i) < $sayfaSayisi ? "<li><a href=\"javascript:fsubmit('form',$sayfaSayisi,'')\"> ... </a></li>" : "";
		} else {
			$bas_i 	= 1;
			$bit_i	= $sayfaSayisi;
		}
			
		for($i = $bas_i; $i <= $bit_i; $i++){
			if($i==$sayfa) 
				$sayfaAltYazi .= "<li class=\"active\"><a href=\"javascript:void(0)\">$i</a></li>";	
			else 
				$sayfaAltYazi .= "<li><a href=\"javascript:fsubmit('form',$i,'')\">$i</a></li>";	
			
			//if($i%50 == 0) $sayfaAltYazi .= "<br>";
		}
		if($sayfaToplam>0) {
			$sayfaUstYazi = $sayfaToplam . " Sonuç içinde " . ($sayfaIlk+1) . " - " . (($sayfaToplam>$sayfaSon)?$sayfaSon:$sayfaToplam) . " arası sonuçlar"; 
			$sayfaOnceki  = $sayfa - 1;
			$sayfaSonraki = $sayfa + 1; 
			if($sayfa == 1){
				$sayfaAltYazi = "<li><a href=\"javascript:fsubmit('form',1,'')\"> <i class='glyphicon glyphicon-backward'></i> </a></li>" .  $sayfaAltYazi;	
			} else{
				$sayfaAltYazi = "<li><a href=\"javascript:fsubmit('form',$sayfaOnceki,'')\"> <i class='glyphicon glyphicon-backward'></i> </a></li>" . $bas_ucnokta . $sayfaAltYazi;
			}
			if($sayfa == $sayfaSayisi){
				$sayfaAltYazi = $sayfaAltYazi . "<li><a href=\"javascript:fsubmit('form',$sayfaSayisi,'')\"> <i class='glyphicon glyphicon-forward'></i> </a></li>";
			} else{
				$sayfaAltYazi = $sayfaAltYazi . $bit_ucnokta . "<li><a href=\"javascript:fsubmit('form',$sayfaSonraki,'')\"> <i class='glyphicon glyphicon-forward'></i> </a></li>";
			}			
			$sayfaAltYazi = "<li><a href=\"javascript:fsubmit('form',1,'')\"> <i class='glyphicon glyphicon-fast-backward'></i> </a> </li>" . $sayfaAltYazi;
			$sayfaAltYazi = $sayfaAltYazi . "<li><a href=\"javascript:fsubmit('form',$sayfaSayisi,'')\"> <i class='glyphicon glyphicon-fast-forward'></i> </a></li>";
			
		} else {
			$sayfaUstYazi = "0 Kayıt Bulundu... ";		
			
		}
		
		$this->sayfaUstYazi = $sayfaUstYazi;
		$this->sayfaAltYazi = $sayfaAltYazi;
		$this->sayfaIlk = $sayfaIlk;
		$this->sayfaSon = $sayfaSon;
		$this->sayfaAdet = $sayfaAdet;
		$this->sayfa = $sayfa;
		
	}
	
	public function getSayfaUstYazi() { 
		return $this->sayfaUstYazi;
	}
	
	public function getSayfaAltYazi() { 
		return $this->sayfaAltYazi;
	}
	
	public function getSayfaIlk() { 
		return $this->sayfaIlk;
	}
	
	public function getSayfaSon() { 
		return $this->sayfaSon;
	}
	
	public function getSayfaAdet() { 
		return $this->sayfaAdet;
	}
	
	public function getSayfa() { 
		return $this->sayfa;
	}
        
    // sadece dataların çıplak olarak dönmesini sağlıyor
    public function getTable(){
    	$this->tumData["rowss"] 		= $this->rowss;
    	$this->tumData["rows"] 			= $this->rows;
    	$this->tumData["sayfaIlk"] 		= $this->sayfaIlk;
    	$this->tumData["sayfaSon"] 		= $this->sayfaSon;
    	$this->tumData["sayfaAdet"] 	= $this->sayfaAdet;
    	$this->tumData["sayfaUstYazi"] 	= $this->sayfaUstYazi;
    	$this->tumData["sayfaAltYazi"] 	= $this->sayfaAltYazi;
    	$this->tumData["sql"] 			= $this->cdbPDO->getSQL($this->sql, $this->filtre);
    	$this->tumData["sqls"] 			= $this->cdbPDO->getSQL($this->sqls, $this->filtre);
    	$this->tumData["excel"] 		= $this->excel;
    	$this->tumData["excelDosyaAdi"] = ($this->excelDosyaAdi)?$this->excelDosyaAdi:date("YmdHis");
        return $this->tumData;
    }
    
    // Sql kodunun ne olduğunun öğrenmesi adına debug için kullanmaya
    public function getSql(){
    	return $this->cdbPDO->getSQL($this->sql, $this->filtre);	
    }
	
	// Gönderilen kriterlerin alınması
    public function getPost(){
        return $this->post;
    }
    
    // Sadece dataların alınması
    public function getRows(){
        return $this->rows;
    }
	
	public function sayfaSatisFaturalar(){
		
		$filtre = array();
		$sql = "SELECT
					CH.*,
					(CH.TUTAR - CH.KDV_TUTAR) AS KDVSIZ_TUTAR,
					FK.FINANS_KALEMI,
					C.CARI,
					C.KOD AS CARI_KOD,
					C.CARI_KOD AS CARI_KODU,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					OK.ODEME_KANALI
				FROM CARI_HAREKET AS CH
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
				WHERE CH.HAREKET_ID = 1
                ";
		
		if($_REQUEST['fatura_no']) {
			$sql.=" AND CH.FATURA_NO LIKE :FATURA_NO";
			$filtre[":FATURA_NO"] = "%" . $_REQUEST['fatura_no'] . "%";
		}
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_NO";
			$filtre[":TALEP_NO"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['islem_no'] > 0) {
			$sql.=" AND CH.ID = :ISLEM_NO";
			$filtre[":ISLEM_NO"] = $_REQUEST['islem_no'];
		}
		
		if($_REQUEST['fatura_durum_id'] > 0) {
			$sql.=" AND CH.FATURA_DURUM_ID = :FATURA_DURUM_ID";
			$filtre[":FATURA_DURUM_ID"] = $_REQUEST['fatura_durum_id'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['fatura_kes'] > 0) {
			$sql.=" AND CH.FATURA_KES = :FATURA_KES";
			$filtre[":FATURA_KES"] = $_REQUEST['fatura_kes'];
		}
		
		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['fatura_tarih'] AND $_REQUEST['fatura_tarih_var']) {
			$tarih = explode(",", $_REQUEST['fatura_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['siralama'] == 2){
			$sql.=" ORDER BY CH.FATURA_TARIH ASC, CH.FATURA_NO ASC";	
		} else {
			$sql.=" ORDER BY CH.FATURA_TARIH DESC, CH.FATURA_NO DESC";
		}
		
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 400);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaAlisFaturalar(){
		
		$filtre = array();
		$sql = "SELECT
					CH.*,
					FK.FINANS_KALEMI,
					(CH.TUTAR - CH.KDV_TUTAR) AS KDVSIZ_TUTAR,
					C.CARI,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					C.CARI_KOD AS CARI_KODU,
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY
				FROM CARI_HAREKET AS CH
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
				WHERE CH.HAREKET_ID = 2
                ";
		
		if($_REQUEST['fatura_no']) {
			$sql.=" AND CH.FATURA_NO LIKE :FATURA_NO";
			$filtre[":FATURA_NO"] = "%" . $_REQUEST['fatura_no'];
		}
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_NO";
			$filtre[":TALEP_NO"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['islem_no'] > 0) {
			$sql.=" AND CH.ID = :ISLEM_NO";
			$filtre[":ISLEM_NO"] = $_REQUEST['islem_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['fatura_kes'] > 0) {
			$sql.=" AND CH.FATURA_KES = :FATURA_KES";
			$filtre[":FATURA_KES"] = $_REQUEST['fatura_kes'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['fatura_tarih'] AND $_REQUEST['fatura_tarih_var']) {
			$tarih = explode(",", $_REQUEST['fatura_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.=" ORDER BY CH.FATURA_TARIH DESC, CH.TARIH DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 400);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaVadesiGelmisFaturalar(){
		
		$filtre = array();
		$sql = "SELECT
					CH.*,
					FK.FINANS_KALEMI,
					C.CARI,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					C.CARI_KOD AS CARI_KODU,
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY,
					H.HAREKET
				FROM CARI_HAREKET AS CH
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
					LEFT JOIN HAREKET AS H ON H.ID = CH.HAREKET_ID
				WHERE CH.HAREKET_ID IN(1,2)
                ";
		
		if($_REQUEST['fatura_no']) {
			$sql.=" AND CH.FATURA_NO LIKE :FATURA_NO";
			$filtre[":FATURA_NO"] = "%" . $_REQUEST['fatura_no'];
		}
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_NO";
			$filtre[":TALEP_NO"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['islem_no'] > 0) {
			$sql.=" AND CH.ID = :ISLEM_NO";
			$filtre[":ISLEM_NO"] = $_REQUEST['islem_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['fatura_tarih'] AND $_REQUEST['fatura_tarih_var']) {
			$tarih = explode(",", $_REQUEST['fatura_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['vade_tarih'] AND $_REQUEST['vade_tarih_var']) {
			$tarih = explode(",", $_REQUEST['vade_tarih']);	
			$sql.=" AND DATE(CH.VADE_TARIH) >= :VADE_TARIH1 AND DATE(CH.VADE_TARIH) <= :VADE_TARIH2";
			$filtre[":VADE_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":VADE_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST["borc_alacak"] > 0){
			if($_REQUEST["borc_alacak"] == 1){
				$sql.=" AND CH.HAREKET_ID = :HAREKET_ID";
				$filtre[":HAREKET_ID"] = 2;
			} else if($_REQUEST["borc_alacak"] == 2){
				$sql.=" AND CH.HAREKET_ID = :HAREKET_ID";
				$filtre[":HAREKET_ID"] = 1;
			}
		}
		
		$sql.=" ORDER BY CH.FATURA_TARIH DESC, CH.TARIH DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 150);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaCariHareketler(){
		
		$filtre = array();
		$sql = "SELECT
					CH.*,
					FK.FINANS_KALEMI,
					C.CARI,
					C.PARA_BIRIM,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY,
					H.HAREKET,
					FD.FATURA_DURUM
				FROM CARI_HAREKET AS CH
					LEFT JOIN HAREKET AS H ON H.ID = CH.HAREKET_ID
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
					LEFT JOIN FATURA_DURUM AS FD ON FD.ID = CH.FATURA_DURUM_ID
				WHERE 1
                ";
		if($_REQUEST['islem_no']) {
			$sql.=" AND CH.ID LIKE :ISLEM_NO";
			$filtre[":ISLEM_NO"] = "%" . $_REQUEST['islem_no'];
		}
		
		if($_REQUEST['fatura_no']) {
			$sql.=" AND CH.FATURA_NO LIKE :FATURA_NO";
			$filtre[":FATURA_NO"] = "%" . $_REQUEST['fatura_no'];
		}
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_NO";
			$filtre[":TALEP_NO"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['fatura_durum_id'] > 0) {
			$sql.=" AND CH.FATURA_DURUM_ID = :FATURA_DURUM_ID";
			$filtre[":FATURA_DURUM_ID"] = $_REQUEST['fatura_durum_id'];
		}
		
		if($_REQUEST['hareket_id'] > 0) {
			$sql.=" AND CH.HAREKET_ID = :HAREKET_ID";
			$filtre[":HAREKET_ID"] = $_REQUEST['hareket_id'];
		}
		
		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['odeme_kanali_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_ID = :ODEME_KANALI_ID";
			$filtre[":ODEME_KANALI_ID"] = $_REQUEST['odeme_kanali_id'];
		}
		
		if($_REQUEST['odeme_kanali_detay_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_DETAY_ID = :ODEME_KANALI_DETAY_ID";
			$filtre[":ODEME_KANALI_DETAY_ID"] = $_REQUEST['odeme_kanali_detay_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['fatura_tarih'] AND $_REQUEST['fatura_tarih_var']) {
			$tarih = explode(",", $_REQUEST['fatura_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		fncSqlCariHareket($sql, $filtre);
		
		$sql.=" ORDER BY CH.ID DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 150);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaStokAramaLog(){
		
		$filtre = array();
		$sql = "SELECT
					SA.*,
					C.CARI,
					K.UNVAN AS KULLANICI
				FROM STOK_ARAMA AS SA
					LEFT JOIN CARI AS C ON C.ID = SA.CARI_ID
					LEFT JOIN KULLANICI AS K ON K.ID = SA.KULLANICI_ID
				WHERE 1
				ORDER BY SA.TARIH DESC
                ";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 1000);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaCariHareketDetaylar(){
		
		$filtre = array();
		$sql = "SELECT
					CHD.*,
					CH.HAREKET_ID,
					CH.KOD AS CARI_HAREKET_KOD,
					FK.FINANS_KALEMI,
					C.CARI,
					C.PARA_BIRIM,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					H.HAREKET,
					FD.FATURA_DURUM,
					TC.CARI AS TEDARIKCI
				FROM CARI_HAREKET_DETAY AS CHD
					INNER JOIN CARI_HAREKET AS CH ON CH.ID = CHD.CARI_HAREKET_ID
					LEFT JOIN HAREKET AS H ON H.ID = CH.HAREKET_ID
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN CARI AS TC ON TC.ID = CHD.TEDARIKCI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN FATURA_DURUM AS FD ON FD.ID = CH.FATURA_DURUM_ID
				WHERE 1
                ";
		if($_REQUEST['islem_no']) {
			$sql.=" AND CH.ID LIKE :ISLEM_NO";
			$filtre[":ISLEM_NO"] = "%" . $_REQUEST['islem_no'];
		}
		
		if($_REQUEST['fatura_no']) {
			$sql.=" AND CH.FATURA_NO LIKE :FATURA_NO";
			$filtre[":FATURA_NO"] = "%" . $_REQUEST['fatura_no'];
		}
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_NO";
			$filtre[":TALEP_NO"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['parca_kodu']) {
			$sql.=" AND CHD.PARCA_KODU LIKE :PARCA_KODU";
			$filtre[":PARCA_KODU"] = "%" . $_REQUEST['parca_kodu'] . "%";
		}
		
		if($_REQUEST['oem_kodu']) {
			$sql.=" AND CHD.OEM_KODU LIKE :OEM_KODU";
			$filtre[":OEM_KODU"] = "%" . $_REQUEST['oem_kodu'] . "%";
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['tedarikci_id'] > 0) {
			$sql.=" AND CH.TEDARIKCI_ID = :TEDARIKCI_ID";
			$filtre[":TEDARIKCI_ID"] = $_REQUEST['tedarikci_id'];
		}
		
		if($_REQUEST['fatura_durum_id'] > 0) {
			$sql.=" AND CH.FATURA_DURUM_ID = :FATURA_DURUM_ID";
			$filtre[":FATURA_DURUM_ID"] = $_REQUEST['fatura_durum_id'];
		}
		
		if($_REQUEST['hareket_id'] > 0) {
			$sql.=" AND CH.HAREKET_ID = :HAREKET_ID";
			$filtre[":HAREKET_ID"] = $_REQUEST['hareket_id'];
		}
		
		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['odeme_kanali_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_ID = :ODEME_KANALI_ID";
			$filtre[":ODEME_KANALI_ID"] = $_REQUEST['odeme_kanali_id'];
		}
		
		if($_REQUEST['odeme_kanali_detay_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_DETAY_ID = :ODEME_KANALI_DETAY_ID";
			$filtre[":ODEME_KANALI_DETAY_ID"] = $_REQUEST['odeme_kanali_detay_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['fatura_tarih'] AND $_REQUEST['fatura_tarih_var']) {
			$tarih = explode(",", $_REQUEST['fatura_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		fncSqlCariHareket($sql, $filtre);
		
		$sql.=" ORDER BY CH.ID DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 150);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaSenetTakip(){
		
		$filtre = array();
		$sql = "SELECT
					CH.*,
					FK.FINANS_KALEMI,
					C.CARI,
					C.KOD AS CARI_KOD,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY,
					H.HAREKET
				FROM CARI_HAREKET AS CH
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN HAREKET AS H ON H.ID = CH.HAREKET_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
				WHERE CH.ODEME_KANALI_ID IN(4,5)
                ";
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_NO";
			$filtre[":TALEP_NO"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['odeme_kanali_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_ID = :ODEME_KANALI_ID";
			$filtre[":ODEME_KANALI_ID"] = $_REQUEST['odeme_kanali_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['odeme_tarih'] AND $_REQUEST['odeme_tarih_var']) {
			$tarih = explode(",", $_REQUEST['odeme_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.=" ORDER BY CH.TARIH DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 150);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaTahsilatlar(){
		
		$filtre = array();
		$sql = "SELECT
					CH.*,
					FK.FINANS_KALEMI,
					C.CARI,
					C.KOD AS CARI_KOD,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY
				FROM CARI_HAREKET AS CH
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
				WHERE CH.HAREKET_ID = 3
                ";
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_NO";
			$filtre[":TALEP_NO"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['islem_no']) {
			$sql.=" AND CH.ID LIKE :ISLEM_NO";
			$filtre[":ISLEM_NO"] = "%" . $_REQUEST['islem_no'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['odeme_kanali_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_ID = :ODEME_KANALI_ID";
			$filtre[":ODEME_KANALI_ID"] = $_REQUEST['odeme_kanali_id'];
		}
		
		if($_REQUEST['odeme_kanali_detay_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_DETAY_ID = :ODEME_KANALI_DETAY_ID";
			$filtre[":ODEME_KANALI_DETAY_ID"] = $_REQUEST['odeme_kanali_detay_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['odeme_tarih'] AND $_REQUEST['odeme_tarih_var']) {
			$tarih = explode(",", $_REQUEST['odeme_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.=" ORDER BY CH.TARIH DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 150);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaTediyeler(){
		
		$filtre = array();
		$sql = "SELECT
					CH.*,
					FK.FINANS_KALEMI,
					C.CARI,
					C.KOD AS CARI_KOD,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY,
					(CH.TUTAR / ((100 + FK.KDV) / 100)) KDVSIZ_TUTAR,
					((CH.TUTAR / (100 + FK.KDV)) * FK.KDV) KDV_TUTAR
				FROM CARI_HAREKET AS CH
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
				WHERE CH.HAREKET_ID = 4
                ";
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_NO";
			$filtre[":TALEP_NO"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['odeme_kanali_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_ID = :ODEME_KANALI_ID";
			$filtre[":ODEME_KANALI_ID"] = $_REQUEST['odeme_kanali_id'];
		}
		
		if($_REQUEST['odeme_kanali_detay_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_DETAY_ID = :ODEME_KANALI_DETAY_ID";
			$filtre[":ODEME_KANALI_DETAY_ID"] = $_REQUEST['odeme_kanali_detay_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['odeme_tarih'] AND $_REQUEST['odeme_tarih_var']) {
			$tarih = explode(",", $_REQUEST['odeme_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.=" ORDER BY CH.TARIH DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 150);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaEkstreOzet(){
		
		$filtre = array();
		$sql = "SELECT
					CH.CARI_ID,
					SUM(IF(CH.HAREKET_ID IN(1,4), -1, 1) * CH.TUTAR) AS TUTAR,
					SUM(CASE
							WHEN CH.HAREKET_ID IN(1) AND DATE_ADD(CH.FATURA_TARIH, INTERVAL C.VADE DAY) < :VADE_TARIH THEN -1 * CH.TUTAR
							WHEN CH.HAREKET_ID IN(4) THEN -1 * CH.TUTAR
							WHEN CH.HAREKET_ID IN(2,3) THEN 1 * CH.TUTAR
							ELSE 0
						END) AS GECMIS_TUTAR,
					C.CARI,
					C.KOD,
					C.KOD AS CARI_KOD,
					C.CARI_KOD AS CARI_KODU,
					SUM(IF(CH.HAREKET_ID IN(1,4), 1, 0)) AS SATIS_SAY,
					SUM(IF(CH.HAREKET_ID IN(2,3), 1, 0)) AS ALIS_SAY,
					MAX(CH.TARIH) AS TARIH
				FROM CARI_HAREKET AS CH
					LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
				WHERE C.CARI_TURU NOT IN('PERSONEL')
                ";
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_ID";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}

		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['cari_turu'] AND $_REQUEST['cari_turu'] != -1) {
			$sql.=" AND C.CARI_TURU = :CARI_TURU";
			$filtre[":CARI_TURU"] = $_REQUEST['cari_turu'];
		}
		
		if($_REQUEST['odeme_kanali_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_ID = :ODEME_KANALI_ID";
			$filtre[":ODEME_KANALI_ID"] = $_REQUEST['odeme_kanali_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
				
		if($_REQUEST['odeme_tarih'] AND $_REQUEST['odeme_tarih_var']) {
			$tarih = explode(",", $_REQUEST['odeme_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		/*
		if($_REQUEST['vade_tarih']) {
			$sql.=" AND DATE(CH.VADE_TARIH) <= :VADE_TARIH";
			
		}
		*/
		
		$filtre[":VADE_TARIH"] 	= FormatTarih::nokta2db($_REQUEST['vade_tarih']);
		
		$sql.=" GROUP BY CH.CARI_ID";
		
		if($_REQUEST["borc_alacak"] > 0){
			if($_REQUEST["borc_alacak"] == 1){
				$sql.= " HAVING TUTAR >= 1";
			} else if($_REQUEST["borc_alacak"] == 2){
				$sql.= " HAVING TUTAR <= -1";
			}
		} else {
			//$sql.= " HAVING TUTAR <= -1 OR TUTAR >= 1";
		}
		
		$sql.=" ORDER BY C.CARI_KOD ASC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 200);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaPersonelEkstreOzet(){
		
		$filtre = array();
		$sql = "SELECT
					C.ID,
					C.KOD,
					C.CARI,
					C.CARI_KOD,
					C.MAAS,
					IF(C.MAAS_DONEM = 2, 'HAFTALIK', 'AYLIK') AS MAAS_DONEM,
					DU.DURUM,
					SUM(IF(CH.HAREKET_ID IN(1,4), -1, 1) * CH.TUTAR) AS TUTAR,
					SUM(IF(CH.HAREKET_ID IN(1,4) AND MONTH(CH.FATURA_TARIH) = MONTH(CURDATE()), 1, 0) * CH.TUTAR) AS VERILEN_AVANS,
					MAX(CH.TARIH) AS TARIH,
					D.DEPARTMAN,
					G.GOREV
				FROM CARI AS C
					LEFT JOIN CARI_HAREKET AS CH ON CH.CARI_ID = C.ID
					LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN DEPARTMAN AS D ON D.ID = C.DEPARTMAN_ID
					LEFT JOIN GOREV AS G ON G.ID = C.GOREV_ID
					LEFT JOIN DURUM AS DU ON DU.ID = C.DURUM
				WHERE C.CARI_TURU = 'PERSONEL' AND C.DURUM = 1
                ";
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_ID";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND CH.DOSYA_NO LIKE :DOSYA_NO";
			$filtre[":DOSYA_NO"] = "%" . $_REQUEST['dosya_no'] . "%";
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}

		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['odeme_kanali_id'] > 0) {
			$sql.=" AND CH.ODEME_KANALI_ID = :ODEME_KANALI_ID";
			$filtre[":ODEME_KANALI_ID"] = $_REQUEST['odeme_kanali_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
				
		if($_REQUEST['odeme_tarih'] AND $_REQUEST['odeme_tarih_var']) {
			$tarih = explode(",", $_REQUEST['odeme_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}

		$sql.=" GROUP BY C.ID ORDER BY CH.TARIH, CH.CARI_ID DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 100);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaEktre(){
		
		$filtre = array();
		$sql = "SELECT
					CH.*,
					IF(CH.HAREKET_ID IN(1,4), -1, 0) * CH.TUTAR AS BORC,
					IF(CH.HAREKET_ID IN(1,4), 0, 1) * CH.TUTAR AS ALACAK,
					0 AS BAKIYE,
					IF(CH.HAREKET_ID IN(1,4), -1, 1) * CH.TUTAR AS TUTAR,
					FK.FINANS_KALEMI,
					C.CARI,
					C.KOD,
					C.CARI_KOD,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					H.HAREKET,
					IF(CH.FATURA_NO = '', CH.ID, CH.FATURA_NO) AS FATURA_NO
					-- DATE_ADD(CH.FATURA_TARIH, INTERVAL C.VADE DAY) AS VADE_TARIH
				FROM CARI_HAREKET AS CH
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID	
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN HAREKET AS H ON H.ID = CH.HAREKET_ID
				WHERE 1
                ";
        if($_REQUEST['kod'] == ""){
			$sql.= " AND C.KOD IS NULL";
		} else {
			$sql.= " AND C.KOD = :KOD";
			$filtre[":KOD"] = $_REQUEST['kod'];	
		}     
       	
		if($_REQUEST['talep_no']) {
			$sql.=" AND CH.TALEP_ID LIKE :TALEP_ID";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['talep_no'] . "%";
		}
		
		if($_REQUEST['hizmet_id'] > 0) {
			$sql=" AND T.HIZMET_ID = :HIZMET_ID";
			$filtre[":HIZMET_ID"] = $_REQUEST['hizmet_id'];
		}
		
		if($_REQUEST['finans_kalemi_id'] > 0) {
			$sql.=" AND CH.FINANS_KALEMI_ID = :FINANS_KALEMI_ID";
			$filtre[":FINANS_KALEMI_ID"] = $_REQUEST['finans_kalemi_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['fatura_tarih'] AND $_REQUEST['fatura_tarih_var']) {
			$tarih = explode(",", $_REQUEST['fatura_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.=" ORDER BY CH.FATURA_TARIH ASC, CH.ID ASC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 10000);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaStoklar(){
		
		$filtre = array();
		$sql = "SELECT
					CHD.PARCA_KODU,
					CHD.PARCA_ADI,
					SUM(IF(CH.HAREKET_ID IN(2), CHD.ADET, -1 * CHD.ADET)) AS ADET
				FROM CARI_HAREKET_DETAY AS CHD
					LEFT JOIN CARI_HAREKET AS CH ON CH.ID = CHD.CARI_HAREKET_ID
				WHERE 1
                ";
		
		if($_REQUEST['parca_kodu']) {
			$sql.=" AND CHD.PARCA_KODU LIKE :PARCA_KODU";
			$filtre[":PARCA_KODU"] = "%" . $_REQUEST['parca_kodu'] . "%";
		}
		
		if($_REQUEST['parca_adi']) {
			$sql.=" AND CHD.PARCA_ADI LIKE :PARCA_ADI";
			$filtre[":PARCA_ADI"] = "%" . $_REQUEST['parca_adi'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND CH.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}

		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.=" GROUP BY CHD.PARCA_KODU ORDER BY CHD.PARCA_ADI";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 30);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
		
	public function sayfaKisiler(){
		
		$filtre = array();
		$sql = "SELECT
					K.ID,
					CONCAT_WS(' ', K.AD, K.SOYAD) AS AD_SOYAD,
					M.MESLEK,
					K.TEL,
					K.CEPTEL,
					K.ADRES,
					K.EMAIL,
					D.DURUM,
					K.TARIH
				FROM KISI AS K
					LEFT JOIN DURUM AS D ON D.ID = K.DURUM
					LEFT JOIN MESLEK AS M ON M.ID = K.MESLEK_ID
				WHERE 1 = 1
                ";
		if($_REQUEST['id']) {
			$sql.=" AND K.ID = :ID";
			$filtre[":ID"] = $_REQUEST['id'];
		}
		
		if($_REQUEST['ad']) {
			$sql.=" AND K.AD LIKE :AD";
			$filtre[":AD"] = "%" . $_REQUEST['ad'] . "%";
		}
		
		if($_REQUEST['soyad']) {
			$sql.=" AND K.SOYAD LIKE :SOYAD";
			$filtre[":SOYAD"] = "%" . $_REQUEST['soyad'] . "%";
		}
		
		if($_REQUEST['ceptel']) {
			$sql.=" AND K.CEPTEL = :CEPTEL";
			$filtre[":CEPTEL"] = $_REQUEST['ceptel'];
		}
		
		if(in_array($_REQUEST['durum'], array('0','1'))) {
			$sql.=" AND K.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['meslek_id'] > 0) {
			$sql.=" AND K.MESLEK_ID = :MESLEK_ID";
			$filtre[":MESLEK_ID"] = $_REQUEST['meslek_id'];
		}
		   	
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 10);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaKullanicilarLog(){
		
		$filtre = array();
        $sql = "SELECT
        			L.ID,
        			L.KULLANICI,
        			L.SIFRE,
        			L.TARIH,
        			L.IP,
        			L.ULKE,
        			L.IL,
        			K.AD,
        			K.SOYAD,
        			Y.YETKI,
        			D.DURUM
        		FROM KULLANICI_LOG AS L
        			LEFT JOIN DURUM AS D ON D.ID = L.DURUM
        			LEFT JOIN KULLANICI AS K ON K.KULLANICI = L.KULLANICI
        			LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
        		WHERE L.KULLANICI NOT IN('ADMIN')
        		
				";
		if($_REQUEST['kullanici']){
			$sql.=" AND K.KULLANICI LIKE :KULLANICI";
			$filtre[":KULLANICI"] = "%" . $_REQUEST['kullanici'] . "%";
		}
		
		if($_REQUEST['ad']){
			$sql.=" AND K.AD LIKE :AD";
			$filtre[":AD"] = "%" . $_REQUEST['ad'] . "%";
		}
		
		if($_REQUEST['soyad']){
			$sql.=" AND K.SOYAD LIKE :SOYAD";
			$filtre[":SOYAD"] = "%" . $_REQUEST['soyad'] . "%";
		}
		
		if(in_array($_REQUEST['durum'], array('0','1'))){
			$sql.=" AND K.DURUM = :DURUM";
			$filtre[":DURUM"] =  $_REQUEST['durum'];
		}
		
		if($_REQUEST['yetki'] > 0){
			$sql.=" AND K.YETKI_ID = :YETKI_ID";
			$filtre[":YETKI_ID"] = $_REQUEST['yetki'];
		}
		
		$sql.=" ORDER BY L.TARIH DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaIslemLog(){
		
		$filtre = array();
        $sql = "SELECT
        			L.ID,
        			L.TABLO,
        			L.ISLEM,
        			CONCAT_WS(' ', K.AD, K.SOYAD, '-', L.KULLANICI) AS KULLANICI,
        			L.SAYFA,
        			L.TARIH,
        			L.SORGU,
        			L.ROW,
        			I.IHALE_NO
        		FROM ISLEM_LOG AS L
        			LEFT JOIN KULLANICI AS K ON K.KULLANICI = L.KULLANICI
        			LEFT JOIN IHALE AS I ON I.ID = L.IHALE_ID
        		WHERE 1
				";
		if($_REQUEST['ihale_no']){
			$sql.=" AND I.IHALE_NO = :IHALE_NO";
			$filtre[":IHALE_NO"] = $_REQUEST['ihale_no'];
		}
		
		if($_REQUEST['islem']){
			$sql.=" AND L.ISLEM LIKE :ISLEM";
			$filtre[":ISLEM"] = "%" . $_REQUEST['islem'] . "%";
		}
		
		if($_REQUEST['kullanici'] AND $_REQUEST['kullanici'] != -1){
			$sql.=" AND L.KULLANICI = :KULLANICI";
			$filtre[":KULLANICI"] = $_REQUEST['kullanici'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(L.TARIH) >= :TARIH1 AND DATE(L.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.=" ORDER BY L.TARIH DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaEntegrasyonLog(){
		
		$filtre = array();
        $sql = "SELECT
        			E.*,
        			ET.TIP,
        			K.KULLANICI,
        			K.AD,
        			K.SOYAD,
        			T.ID
        		FROM ENTEGRASYON AS E
        			LEFT JOIN KULLANICI AS K ON K.ID = E.KULLANICI_ID
        			LEFT JOIN ENTEGRASYON_TIP AS ET ON ET.ID = E.TIP_ID
        			LEFT JOIN TALEP AS T ON T.ID = E.NO_ID
        		WHERE 1
				";
		if($_REQUEST['ihale_no']){
			$sql.=" AND E.NO = :NO";
			$filtre[":NO"] = $_REQUEST['ihale_no'];
		}
		
		if($_REQUEST['tip_id'] > 0){
			$sql.=" AND E.TIP_ID = :TIP_ID";
			$filtre[":TIP_ID"] = $_REQUEST['tip_id'];
		}
		
		if($_REQUEST['durum'] != -1 AND isset($_REQUEST['durum'])){
			$sql.=" AND E.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['kullanici'] AND $_REQUEST['kullanici'] != -1){
			$sql.=" AND E.KULLANICI = :KULLANICI";
			$filtre[":KULLANICI"] = $_REQUEST['kullanici'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(E.TARIH) >= :TARIH1 AND DATE(E.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
				
		$sql.=" ORDER BY E.TARIH DESC";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 10);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
	public function sayfaKullanicilar(){
		
		$filtre = array();
		$sql = "SELECT
					K.ID,
					K.KOD,
					K.AD,
					K.SOYAD,
					K.KULLANICI,
					K.SIFRE,
					K.TARIH,
					K.MAIL,
					K.CEPTEL,
					K.TEL,
					K.GTARIH,
					K.YETKI_ID,
					K.ADRES,
					K.TARIH,
					K.UNVAN,
					Y.YETKI,
					I.IL,
					D.DURUM,
					C.CARI,
					C.CARI_KOD,
					C.KOD AS CARI_KOD
				FROM KULLANICI AS K
					LEFT JOIN DURUM AS D ON D.ID = K.DURUM
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN IL AS I ON I.ID = K.IL_ID
					LEFT JOIN CARI AS C ON C.ID = K.CARI_ID
				WHERE K.ID NOT IN(1)
				";
		
		if($_REQUEST['ad']) {
			$sql.=" AND K.AD LIKE :AD";
			$filtre[":AD"] = "%" . $_REQUEST['ad'] . "%";
		}
		
		if($_REQUEST['soyad']) {
			$sql.=" AND K.SOYAD LIKE :SOYAD";
			$filtre[":SOYAD"] = "%" . $_REQUEST['soyad'] . "%";
		}
		
		if($_REQUEST['unvan']) {
			$sql.=" AND K.UNVAN LIKE :UNVAN";
			$filtre[":UNVAN"] = "%" . $_REQUEST['unvan'] . "%";
		}
		
		if($_REQUEST['kullanici']) {
			$sql.=" AND K.KULLANICI LIKE :KULLANICI";
			$filtre[":KULLANICI"] = "%" . $_REQUEST['kullanici'] . "%";
		}
		
		if($_REQUEST['yetki_id']>0) {
			$sql.=" AND K.YETKI_ID = :YETKI_ID";
			$filtre[":YETKI_ID"] = $_REQUEST['yetki_id'];
		}
		
		if(count($_GET['arac_alim_turu_id']) > 0){
			$sql.=" AND FIND_IN_SET(K.ARAC_ALIM_TURU_ID,'".implode($_GET['arac_alim_turu_id'],',')."')";
		}
		
		if($_REQUEST['il_id'] > 0) {
			$sql.=" AND K.IL_ID = :IL_ID";
			$filtre[":IL_ID"] = $_REQUEST['il_id'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND K.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['durum'] >= 0 AND isset($_REQUEST['durum'])) {
			$sql.=" AND K.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(K.TARIH) >= :TARIH1 AND DATE(K.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(K.GTARIH) >= :GTARIH1 AND DATE(K.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		
		if($_REQUEST['sozlesme'] >= 0 AND isset($_REQUEST['sozlesme'])) {
			$sql.=" AND K.SOZLESME = :SOZLESME";
			$filtre[":SOZLESME"] = $_REQUEST['sozlesme'];
		}
		
		if($_REQUEST['teklif_durum'] >= 0 AND isset($_REQUEST['teklif_durum'])) {
			$sql.=" AND K.TEKLIF_DURUM = :TEKLIF_DURUM";
			$filtre[":TEKLIF_DURUM"] = $_REQUEST['teklif_durum'];
		}
		
		$sql.= " ORDER BY K.AD";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaUyeIsyerleri(){
		
		$filtre = array();
		$sql = "SELECT
					K.ID,
					K.KOD,
					K.AD,
					K.SOYAD,
					K.KULLANICI,
					K.SIFRE,
					K.TARIH,
					K.MAIL,
					K.CEPTEL,
					K.TEL,
					K.GTARIH,
					K.YETKI_ID,
					K.ADRES,
					K.TARIH,
					K.UNVAN,
					Y.YETKI,
					FT.FIRMA_TURU,
					M.UNVAN AS MUSTERI,
					I.IL,
					D.DURUM
				FROM UYE_ISYERI AS K
					LEFT JOIN DURUM AS D ON D.ID = K.DURUM
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN MUSTERI AS M ON M.ID = K.MUSTERI_ID
					LEFT JOIN FIRMA_TURU AS FT ON FT.ID = K.FIRMA_TURU
					LEFT JOIN IL AS I ON I.ID = K.IL_ID
				WHERE K.ID NOT IN(1)
				";
		
		if($_REQUEST['ad']) {
			$sql.=" AND K.AD LIKE :AD";
			$filtre[":AD"] = "%" . $_REQUEST['ad'] . "%";
		}
		
		if($_REQUEST['soyad']) {
			$sql.=" AND K.SOYAD LIKE :SOYAD";
			$filtre[":SOYAD"] = "%" . $_REQUEST['soyad'] . "%";
		}
		
		if($_REQUEST['unvan']) {
			$sql.=" AND K.UNVAN LIKE :UNVAN";
			$filtre[":UNVAN"] = "%" . $_REQUEST['unvan'] . "%";
		}
		
		if($_REQUEST['kullanici']) {
			$sql.=" AND K.KULLANICI LIKE :KULLANICI";
			$filtre[":KULLANICI"] = "%" . $_REQUEST['kullanici'] . "%";
		}
		
		if($_REQUEST['yetki_id']>0) {
			$sql.=" AND K.YETKI_ID = :YETKI_ID";
			$filtre[":YETKI_ID"] = $_REQUEST['yetki_id'];
		}
		
		if(count($_GET['arac_alim_turu_id']) > 0){
			$sql.=" AND FIND_IN_SET(K.ARAC_ALIM_TURU_ID,'".implode($_GET['arac_alim_turu_id'],',')."')";
		}
		
		if($_REQUEST['il_id'] > 0) {
			$sql.=" AND K.IL_ID = :IL_ID";
			$filtre[":IL_ID"] = $_REQUEST['il_id'];
		}
		
		if($_REQUEST['durum'] >= 0) {
			$sql.=" AND K.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(K.TARIH) >= :TARIH1 AND DATE(K.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(K.GTARIH) >= :GTARIH1 AND DATE(K.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		
		if($_REQUEST['sozlesme'] >= 0 AND isset($_REQUEST['sozlesme'])) {
			$sql.=" AND K.SOZLESME = :SOZLESME";
			$filtre[":SOZLESME"] = $_REQUEST['sozlesme'];
		}
		
		if($_REQUEST['teklif_durum'] >= 0 AND isset($_REQUEST['teklif_durum'])) {
			$sql.=" AND K.TEKLIF_DURUM = :TEKLIF_DURUM";
			$filtre[":TEKLIF_DURUM"] = $_REQUEST['teklif_durum'];
		}
		
		$sql.= " ORDER BY K.AD";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaKullanici(){
		
		$filtre = array();
		$sql = "SELECT
					ID,
					AD,
					SOYAD,
					KULLANICI,
					SIFRE,
					TARIH,
					YETKI_ID,
					DURUM,
					IF(DURUM=1, 'AKTİF', 'PASİF') AS DURUM_TEXT,
					MAIL,
					TEL,
					UPDATE_TARIH
				FROM KULLANICI
				WHERE DURUM = :DURUM
					AND ID = :ID
				";
				
        $filtre[":DURUM"] 		= 1;
        $filtre[":ID"]			= $_SESSION['kullanici_id'];
       
        $rows = $this->cdbPDO->rows($sql, $filtre);
     
		$this->SetTemizle();
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->filtre 	= $filtre;
		return $this;
		
	}
  
    public function sayfaKullaniciGunlukRapor(){
		
		$filtre = array();
		$sql = "SELECT
					S.KULLANICI_ID,
        			K.KULLANICI,
        			Y.YETKI,
        			DATE_FORMAT(S.TARIH,'%m%d') AS AYGUN,
        			DATE_FORMAT(S.TARIH,'%Y-%m-%d') AS TARIH,
        			MONTH(S.TARIH) AS AY, 
        			DAY(S.TARIH) AS GUN, 
        			COUNT(*) AS SAYI, 
        			SUM(S.TUTAR) AS TUTAR, 
        			AVG(S.TUTAR) AS ORTALAMA 
        		FROM SIPARIS AS S
        			LEFT JOIN KULLANICI AS K ON K.ID = S.KULLANICI_ID
        			LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
        		WHERE S.TARIH > DATE_ADD(NOW(), INTERVAL -1 MONTH)
        		GROUP BY DATE_FORMAT(S.TARIH,'%m%d'), S.KULLANICI_ID
        		ORDER BY AYGUN DESC, KULLANICI ASC
        		";
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$sqls = strstr($sql, " LIMIT ", true);
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= (strlen($sqls)>0) ? $sqls : $sql;
        $this->filtre 	= $filtre;
            
		return $this;
		
	}
	
	public function sayfaKullaniciHaftalikRapor(){
		
		$filtre = array();
		$sql = "SELECT
		 			S.KULLANICI_ID,
        			K.KULLANICI,
        			Y.YETKI,
        			ADDDATE(DATE(S.TARIH), INTERVAL 1-DAYOFWEEK(DATE(S.TARIH)) DAY) BAS_TARIH,
					ADDDATE(DATE(S.TARIH), INTERVAL 7-DAYOFWEEK(DATE(S.TARIH)) DAY) BIT_TARIH,
        			DATE_FORMAT(S.TARIH,'%V') AS HAFTA,
        			YEAR(S.TARIH) AS YIL,
        			MONTH(S.TARIH) AS AY, 
        			COUNT(*) AS SAYI, 
        			SUM(S.TUTAR) AS TUTAR, 
        			AVG(S.TUTAR) AS ORTALAMA 
        		FROM SIPARIS AS S
        			LEFT JOIN KULLANICI AS K ON K.ID = S.KULLANICI_ID
        			LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
        		WHERE S.TARIH > DATE_ADD(NOW(), INTERVAL -1 MONTH)
        		GROUP BY DATE_FORMAT(S.TARIH,'%V'), S.KULLANICI_ID
        		ORDER BY HAFTA DESC, KULLANICI ASC;
				";		
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$sqls = strstr($sql, " LIMIT ", true);
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= (strlen($sqls)>0) ? $sqls : $sql;
        $this->filtre 	= $filtre;
            
		return $this;
		
	}
	
	public function sayfaKullaniciAylikRapor(){
		
		$filtre = array();
		$sql = "SELECT
					S.KULLANICI_ID,
        			K.KULLANICI,
        			Y.YETKI,
        			DATE_FORMAT(S.TARIH,'%Y-%m-01') AS BAS_TARIH,
        			LAST_DAY(S.TARIH) AS BIT_TARIH,
        			DATE_FORMAT(S.TARIH,'%Y%m') AS YILAY,
        			YEAR(S.TARIH) AS YIL, 
        			MONTH(S.TARIH) AS AY, 
        			COUNT(*) AS SAYI, 
        			SUM(S.TUTAR) AS TUTAR, 
        			AVG(S.TUTAR) AS ORTALAMA 
        		FROM SIPARIS AS S
        			LEFT JOIN KULLANICI AS K ON K.ID = S.KULLANICI_ID
        			LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
        		WHERE DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -12 MONTH), '%Y%m') <= DATE_FORMAT(S.TARIH, '%Y%m')
        		GROUP BY YEAR(S.TARIH), MONTH(S.TARIH), S.KULLANICI_ID
        		ORDER BY YILAY DESC, KULLANICI ASC;
				";
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$sqls = strstr($sql, " LIMIT ", true);
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= (strlen($sqls)>0) ? $sqls : $sql;
        $this->filtre 	= $filtre;
            
		return $this;
		
	}
	
	public function sayfaKullaniciYillikRapor(){
		
		$filtre = array();
		$sql = "SELECT
					S.KULLANICI_ID,
        			K.KULLANICI,
        			Y.YETKI,
        			YEAR(S.TARIH) AS YIL,
        			COUNT(*) AS SAYI, 
        			SUM(S.TUTAR) AS TUTAR, 
        			AVG(S.TUTAR) AS ORTALAMA 
        		FROM SIPARIS AS S
        			LEFT JOIN KULLANICI AS K ON K.ID = S.KULLANICI_ID
        			LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
        		WHERE DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -2 YEAR), '%Y%m') <= DATE_FORMAT(S.TARIH, '%Y%m')
        		GROUP BY YEAR(S.TARIH), S.KULLANICI_ID
        		ORDER BY YIL DESC, KULLANICI ASC;
				";	
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$sqls = strstr($sql, " LIMIT ", true);
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= (strlen($sqls)>0) ? $sqls : $sql;
        $this->filtre 	= $filtre;
            
		return $this;
		
	}
	
	public function sayfaAraclar(){
		
		$filtre = array();
		$sql = "SELECT 
					A.*,
					MA.MARKA,
					MO.MODEL,
					V.VITES,
					Y.YAKIT,
					A.DURUM
				FROM ARAC AS A
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN VITES AS V ON V.ID = A.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = A.YAKIT_ID
				WHERE 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['plaka']) {
			$sql.=" AND A.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND A.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['vites_id'] > 0) {
			$sql.=" AND A.VITES_ID = :VITES_ID";
			$filtre[":VITES_ID"] = $_REQUEST['vites_id'];
		}
		
		if($_REQUEST['yakit_id'] > 0) {
			$sql.=" AND A.YAKIT_ID = :YAKIT_ID";
			$filtre[":YAKIT_ID"] = $_REQUEST['yakit_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(A.TARIH) >= :TARIH1 AND DATE(A.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['durum'] >= 0 AND isset($_REQUEST['durum'])) {
			$sql.=" AND A.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['muayene_tarih'] AND $_REQUEST['muayene_tarih_var']) {
			$tarih = explode(",", $_REQUEST['muayene_tarih']);	
			$sql.=" AND DATE(A.MUAYENE_TARIH) >= :MUAYENE_TARIH1 AND DATE(A.MUAYENE_TARIH) <= :MUAYENE_TARIH2";
			$filtre[":MUAYENE_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":MUAYENE_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['trafik_bit_tarih'] AND $_REQUEST['trafik_bit_tarih_var']) {
			$tarih = explode(",", $_REQUEST['trafik_bit_tarih']);	
			$sql.=" AND DATE(A.TRAFIK_BIT_TARIH) >= :TRAFIK_BIT_TARIH1 AND DATE(A.TRAFIK_BIT_TARIH) <= :TRAFIK_BIT_TARIH2";
			$filtre[":TRAFIK_BIT_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TRAFIK_BIT_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['kasko_bit_tarih'] AND $_REQUEST['kasko_bit_tarih_var']) {
			$tarih = explode(",", $_REQUEST['kasko_bit_tarih']);	
			$sql.=" AND DATE(A.KASKO_BIT_TARIH) >= :KASKO_BIT_TARIH1 AND DATE(A.KASKO_BIT_TARIH) <= :KASKO_BIT_TARIH2";
			$filtre[":KASKO_BIT_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":KASKO_BIT_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY A.PLAKA";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 100);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaHgs(){
		
		$filtre = array();
		$sql = "SELECT 
					H.*
				FROM HGS AS H
				WHERE 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['plaka']) {
			$sql.=" AND H.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['kontrol_edildi'] >= 0 AND isset($_REQUEST['kontrol_edildi'])) {
			$sql.=" AND H.KONTROL_EDILDI = :KONTROL_EDILDI";
			$filtre[":KONTROL_EDILDI"] = $_REQUEST['kontrol_edildi'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(A.TARIH) >= :TARIH1 AND DATE(A.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY H.GIRIS_TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaKiralamalar(){
		
		$filtre = array();
		$sql = "SELECT 
					K.*,
					CASE 
						WHEN SUREC_ID = 10 THEN DATEDIFF(K.IADE_TARIH, K.VERILIS_TARIH)
						ELSE DATEDIFF(CURDATE(), K.VERILIS_TARIH)
					END AS KALAN_GUN,
					CASE 
						WHEN SUREC_ID = 10 THEN K.SON_KM - K.ILK_KM
						ELSE 0
					END AS FARK_KM,
					CASE 
						WHEN SUREC_ID = 10 THEN 'BITTI'
						WHEN SUREC_ID = 2 THEN 'KONTROL'
						ELSE 'MUSTERIDE'
					END AS SUREC,
					A.MODEL_YILI,
					A.SEGMENT,
					MA.MARKA,
					MO.MODEL,
					V.VITES_KISA AS VITES,
					Y.YAKIT,
					C.CARI
				FROM KIRALAMA AS K
					LEFT JOIN ARAC AS A ON A.ID = K.ARAC_ID
					LEFT JOIN CARI AS C ON C.ID = K.CARI_ID
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN VITES AS V ON V.ID = A.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = A.YAKIT_ID
				WHERE 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['kiralama_id']) {
			$sql.=" AND K.ID = :ID";
			$filtre[":ID"] = $_REQUEST['kiralama_id'];
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND K.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND A.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['vites_id'] > 0) {
			$sql.=" AND A.VITES_ID = :VITES_ID";
			$filtre[":VITES_ID"] = $_REQUEST['vites_id'];
		}
		
		if($_REQUEST['yakit_id'] > 0) {
			$sql.=" AND A.YAKIT_ID = :YAKIT_ID";
			$filtre[":YAKIT_ID"] = $_REQUEST['yakit_id'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND K.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND K.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['verilis_tarih'] AND $_REQUEST['verilis_tarih_var']) {
			$tarih = explode(",", $_REQUEST['verilis_tarih']);	
			$sql.=" AND DATE(K.VERILIS_TARIH) >= :VERILIS_TARIH1 AND DATE(K.VERILIS_TARIH) <= :VERILIS_TARIH2";
			$filtre[":VERILIS_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":VERILIS_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['tahmini_iade_tarih'] AND $_REQUEST['tahmini_iade_tarih_var']) {
			$tarih = explode(",", $_REQUEST['tahmini_iade_tarih']);	
			$sql.=" AND DATE(K.TAHMINI_IADE_TARIH) >= :TAHMINI_IADE_TARIH1 AND DATE(K.TAHMINI_IADE_TARIH) <= :TAHMINI_IADE_TARIH2";
			$filtre[":TAHMINI_IADE_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TAHMINI_IADE_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['iade_tarih'] AND $_REQUEST['iade_tarih_var']) {
			$tarih = explode(",", $_REQUEST['iade_tarih']);	
			$sql.=" AND DATE(K.IADE_TARIH) >= :IADE_TARIH1 AND DATE(K.IADE_TARIH) <= :IADE_TARIH2";
			$filtre[":IADE_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":IADE_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['fatura_kesim_tarih'] AND $_REQUEST['fatura_kesim_tarih_var']) {
			$tarih = explode(",", $_REQUEST['fatura_kesim_tarih']);	
			$sql.=" AND DATE(K.FATURA_KESIM_TARIH) >= :FATURA_KESIM_TARIH1 AND DATE(K.FATURA_KESIM_TARIH) <= :FATURA_KESIM_TARIH2";
			$filtre[":FATURA_KESIM_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_KESIM_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY A.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        //var_dump2($this->cdbPDO->getSQL($sql, $filtre));
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaDonusler(){
		
		$filtre = array();
		if($_REQUEST['id'] > 0) {
			$sql_ek1.=" AND K.ID = :ID";
			$sql_ek2.=" AND TI.ID = :ID";
			$filtre[":ID"] = $_REQUEST['id'];
		}
		
		if($_REQUEST['plaka']) {
			$sql_ek1.=" AND K.PLAKA LIKE :PLAKA";
			$sql_ek2.=" AND TI.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['iade_tarih'] AND $_REQUEST['iade_tarih_var']) {
			$tarih = explode(",", $_REQUEST['iade_tarih']);	
			$sql_ek1.=" AND DATE(K.IADE_TARIH) >= :IADE_TARIH1 AND DATE(K.IADE_TARIH) <= :IADE_TARIH2";
			$sql_ek2.=" AND DATE(TI.IADE_TARIH) >= :IADE_TARIH1 AND DATE(TI.IADE_TARIH) <= :IADE_TARIH2";
			$filtre[":IADE_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":IADE_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['ceza_tarih']) {
			$sql_ek1.=" AND DATE(K.VERILIS_TARIH) <= :CEZA_TARIH AND (:CEZA_TARIH <= DATE(K.IADE_TARIH) OR K.IADE_TARIH IS NULL OR K.IADE_TARIH = '0000-00-00')";
			$sql_ek2.=" AND DATE(TI.VERILIS_TARIH) <= :CEZA_TARIH AND (:CEZA_TARIH <= DATE(TI.IADE_TARIH) OR TI.IADE_TARIH IS NULL OR TI.IADE_TARIH = '0000-00-00')";
			$filtre[":CEZA_TARIH"] 	= FormatTarih::nokta2db($_REQUEST['ceza_tarih']);
		}
		
		$sql = "SELECT 
					K.ID,
					K.KOD,
					K.TARIH,
					K.PLAKA,
                    K.ILK_KM,
                    K.SON_KM,
                    K.TAHMINI_IADE_TARIH,
                    K.TAHMINI_IADE_SAAT,
                    K.VERILIS_TARIH,
                    K.VERILIS_SAAT,
                    K.IADE_TARIH,
                    K.IADE_SAAT,
                    'KIRALAMA' AS TUR,
					CASE 
						WHEN SUREC_ID = 10 THEN DATEDIFF(K.IADE_TARIH, K.VERILIS_TARIH)
						ELSE DATEDIFF(CURDATE(), K.VERILIS_TARIH)
					END AS KALAN_GUN,
					CASE 
						WHEN SUREC_ID = 10 THEN K.SON_KM - K.ILK_KM
						ELSE 0
					END AS FARK_KM,
					CASE 
						WHEN SUREC_ID = 10 THEN 'BITTI'
						WHEN SUREC_ID = 2 THEN 'KONTROL'
						ELSE 'MUSTERIDE'
					END AS SUREC,
					A.MODEL_YILI,
					A.SEGMENT,
					MA.MARKA,
					MO.MODEL,
					V.VITES_KISA AS VITES,
					Y.YAKIT,
					C.CARI
				FROM KIRALAMA AS K
					LEFT JOIN ARAC AS A ON A.ID = K.ARAC_ID
					LEFT JOIN CARI AS C ON C.ID = K.CARI_ID
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN VITES AS V ON V.ID = A.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = A.YAKIT_ID
				WHERE 1 $sql_ek1
				UNION 
				SELECT 
					TI.ID,
					TI.KOD,
					TI.TARIH,
					TI.PLAKA,
					TI.ILK_KM,
                    TI.SON_KM,
                    TI.TAHMINI_IADE_TARIH,
                    TI.TAHMINI_IADE_SAAT,
                    TI.VERILIS_TARIH,
                    TI.VERILIS_SAAT,
                    TI.IADE_TARIH,
                    TI.IADE_SAAT,
                    'IKAME' AS TUR,
					CASE 
						WHEN TI.SUREC_ID = 10 THEN 0
						ELSE DATEDIFF(TI.TAHMINI_IADE_TARIH, CURDATE())
					END AS KALAN_GUN,
					CASE 
						WHEN TI.SUREC_ID = 10 THEN TI.SON_KM - TI.ILK_KM
						ELSE 0
					END AS FARK_KM,
					'' AS SUREC,
					A.MODEL_YILI,
					A.SEGMENT,
					MA.MARKA,
					MO.MODEL,
					V.VITES_KISA AS VITES,
					Y.YAKIT,
					C.CARI
				FROM TALEP_IKAME AS TI
					LEFT JOIN ARAC AS A ON A.ID = TI.ARAC_ID
					LEFT JOIN TALEP AS T ON T.ID = TI.TALEP_ID
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN VITES AS V ON V.ID = A.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = A.YAKIT_ID
				WHERE 1 $sql_ek2
				";
		
		fncSqlTalep($sql, $filtre);
		
		$sql.= " ORDER BY IADE_TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        //var_dump2($this->cdbPDO->getSQL($sql, $filtre));
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaIkameler(){
		
		$filtre = array();
		$sql = "SELECT 
					TI.*,
					CASE 
						WHEN TI.SUREC_ID = 10 THEN 0
						ELSE DATEDIFF(TI.TAHMINI_IADE_TARIH, CURDATE())
					END AS KALAN_GUN,
					CASE 
						WHEN TI.SUREC_ID = 10 THEN TI.SON_KM - TI.ILK_KM
						ELSE 0
					END AS FARK_KM,
					A.MODEL_YILI,
					A.SEGMENT,
					MA.MARKA,
					MO.MODEL,
					V.VITES_KISA AS VITES,
					Y.YAKIT,
					C.CARI,
					T.PLAKA AS HASARLI_PLAKA
				FROM TALEP_IKAME AS TI
					LEFT JOIN ARAC AS A ON A.ID = TI.ARAC_ID
					LEFT JOIN TALEP AS T ON T.ID = TI.TALEP_ID
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN VITES AS V ON V.ID = A.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = A.YAKIT_ID
				WHERE 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['plaka']) {
			$sql.=" AND TI.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND A.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['vites_id'] > 0) {
			$sql.=" AND A.VITES_ID = :VITES_ID";
			$filtre[":VITES_ID"] = $_REQUEST['vites_id'];
		}
		
		if($_REQUEST['yakit_id'] > 0) {
			$sql.=" AND A.YAKIT_ID = :YAKIT_ID";
			$filtre[":YAKIT_ID"] = $_REQUEST['yakit_id'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['verilis_tarih'] AND $_REQUEST['verilis_tarih_var']) {
			$tarih = explode(",", $_REQUEST['verilis_tarih']);	
			$sql.=" AND DATE(TI.VERILIS_TARIH) >= :VERILIS_TARIH1 AND DATE(TI.VERILIS_TARIH) <= :VERILIS_TARIH2";
			$filtre[":VERILIS_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":VERILIS_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['tahmini_iade_tarih'] AND $_REQUEST['tahmini_iade_tarih_var']) {
			$tarih = explode(",", $_REQUEST['tahmini_iade_tarih']);	
			$sql.=" AND DATE(TI.TAHMINI_IADE_TARIH) >= :TAHMINI_IADE_TARIH1 AND DATE(TI.TAHMINI_IADE_TARIH) <= :TAHMINI_IADE_TARIH2";
			$filtre[":TAHMINI_IADE_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TAHMINI_IADE_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['iade_tarih'] AND $_REQUEST['iade_tarih_var']) {
			$tarih = explode(",", $_REQUEST['iade_tarih']);	
			$sql.=" AND DATE(TI.IADE_TARIH) >= :IADE_TARIH1 AND DATE(TI.IADE_TARIH) <= :IADE_TARIH2";
			$filtre[":IADE_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":IADE_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY TI.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        //var_dump2($this->cdbPDO->getSQL($sql, $filtre));
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaCariler(){
		
		$filtre = array();
		$sql = "SELECT 
					C.*,
					D.DURUM,
					IL.IL,
					ILCE.ILCE,
					CT.CARI_TANIM,
					TK.UNVAN AS MUSTERI_TEMSILCISI,
					U.ULKE
				FROM CARI AS C
					LEFT JOIN MUSTERI_TIPI AS MT ON MT.ID = C.MUSTERI_TIPI
					LEFT JOIN IL AS IL ON IL.ID = C.IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = C.ILCE_ID
					LEFT JOIN CARI_TURU AS CT ON CT.CARI_TURU = C.CARI_TURU
					LEFT JOIN DURUM AS D ON D.ID = C.DURUM
					LEFT JOIN KULLANICI AS TK ON TK.ID = C.TEMSILCI_ID
					LEFT JOIN ULKE AS U ON U.ID = C.ULKE_ID
				WHERE C.CARI_TURU NOT IN('PERSONEL')
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['ad']) {
			$sql.=" AND C.AD LIKE :AD";
			$filtre[":AD"] = "%" . $_REQUEST['ad'] . "%";
		}
		
		if($_REQUEST['soyad']) {
			$sql.=" AND C.SOYAD LIKE :SOYAD";
			$filtre[":SOYAD"] = "%" . $_REQUEST['soyad'] . "%";
		}
		
		if($_REQUEST['cari']) {
			$sql.=" AND C.CARI LIKE :CARI";
			$filtre[":CARI"] = "%" . $_REQUEST['cari'] . "%";
		}
		
		if($_REQUEST['cari_kod']) {
			$sql.=" AND C.CARI_KOD LIKE :CARI_KOD";
			$filtre[":CARI_KOD"] = "%" . $_REQUEST['cari_kod'] . "%";
		}
		
		if($_REQUEST['ozel_kod1']) {
			$sql.=" AND C.OZEL_KOD1 LIKE :OZEL_KOD1";
			$filtre[":OZEL_KOD1"] = "%" . $_REQUEST['ozel_kod1'] . "%";
		}
		
		if($_REQUEST['ozel_kod2']) {
			$sql.=" AND C.OZEL_KOD2 LIKE :OZEL_KOD2";
			$filtre[":OZEL_KOD2"] = "%" . $_REQUEST['ozel_kod2'] . "%";
		}
		
		if($_REQUEST['tck']) {
			$sql.=" AND C.TCK = :TCK";
			$filtre[":TCK"] = $_REQUEST['tck'];
		}
		
		if($_REQUEST['cari_turu'] AND $_REQUEST['cari_turu'] != -1) {
			$sql.=" AND C.CARI_TURU = :CARI_TURU";
			$filtre[":CARI_TURU"] = $_REQUEST['cari_turu'];
		}
		
		if($_REQUEST['durum'] >= 0) {
			$sql.=" AND C.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(C.TARIH) >= :TARIH1 AND DATE(C.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(C.GTARIH) >= :GTARIH1 AND DATE(C.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY C.CARI";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaPersoneller(){
		
		$filtre = array();
		$sql = "SELECT 
					C.*,
					D.DURUM,
					IL.IL,
					ILCE.ILCE,
					IF(C.MAAS_DONEM = 2, 'HAFTALIK', 'AYLIK') AS MAAS_DONEM,
					DE.DEPARTMAN,
					G.GOREV
				FROM CARI AS C
					LEFT JOIN MUSTERI_TIPI AS MT ON MT.ID = C.MUSTERI_TIPI
					LEFT JOIN IL AS IL ON IL.ID = C.IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = C.ILCE_ID
					LEFT JOIN DURUM AS D ON D.ID = C.DURUM
					LEFT JOIN DEPARTMAN AS DE ON DE.ID = C.DEPARTMAN_ID
					LEFT JOIN GOREV AS G ON G.ID = C.GOREV_ID
				WHERE C.CARI_TURU = 'PERSONEL'
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['ad']) {
			$sql.=" AND C.AD LIKE :AD";
			$filtre[":AD"] = "%" . $_REQUEST['ad'] . "%";
		}
		
		if($_REQUEST['soyad']) {
			$sql.=" AND C.SOYAD LIKE :SOYAD";
			$filtre[":SOYAD"] = "%" . $_REQUEST['soyad'] . "%";
		}
		
		if($_REQUEST['cari']) {
			$sql.=" AND C.CARI LIKE :CARI";
			$filtre[":CARI"] = "%" . $_REQUEST['cari'] . "%";
		}
		
		if($_REQUEST['cari_kod']) {
			$sql.=" AND C.CARI_KOD LIKE :CARI_KOD";
			$filtre[":CARI_KOD"] = "%" . $_REQUEST['cari_kod'] . "%";
		}
		
		if($_REQUEST['tck']) {
			$sql.=" AND M.TCK = :TCK";
			$filtre[":TCK"] = $_REQUEST['tck'];
		}
		
		if($_REQUEST['cari_turu'] AND $_REQUEST['cari_turu'] != -1) {
			$sql.=" AND C.CARI_TURU = :CARI_TURU";
			$filtre[":CARI_TURU"] = $_REQUEST['cari_turu'];
		}
		
		if($_REQUEST['durum'] >= 0 AND isset($_REQUEST['durum'])) {
			$sql.=" AND C.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(C.TARIH) >= :TARIH1 AND DATE(C.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(C.GTARIH) >= :GTARIH1 AND DATE(C.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY FIELD(C.DURUM,1,0), C.CARI_KOD";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 100);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaValeler(){
		
		$filtre = array();
		$sql = "SELECT 
					K.*,
					CONCAT_WS(' ', K.AD, K.SOYAD) AS ADI_SOYADI,
					D.DURUM,
					IL.IL,
					ILCE.ILCE
				FROM KULLANICI AS K
					LEFT JOIN IL AS IL ON IL.ID = K.IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = K.ILCE_ID
					LEFT JOIN DURUM AS D ON D.ID = K.DURUM
				WHERE K.YETKI_ID = 10
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['unvan']) {
			$sql.=" AND K.UNVAN LIKE :AD";
			$filtre[":UNVAN"] = "%" . $_REQUEST['unvan'] . "%";
		}
		
		if($_REQUEST['tck']) {
			$sql.=" AND K.TCK = :TCK";
			$filtre[":TCK"] = $_REQUEST['tck'];
		}
		
		if($_REQUEST['durum'] >= 0) {
			$sql.=" AND K.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['il_id'] > 0) {
			$sql.=" AND K.IL_ID = :IL_ID";
			$filtre[":IL_ID"] = $_REQUEST['il_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(K.TARIH) >= :TARIH1 AND DATE(K.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(K.GTARIH) >= :GTARIH1 AND DATE(K.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY K.UNVAN";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaServisler(){
		
		$filtre = array();
		$sql = "SELECT 
					K.*,
					CONCAT_WS(' ', K.AD, K.SOYAD) AS ADI_SOYADI,
					D.DURUM,
					IL.IL,
					ILCE.ILCE,
					SZ.UNVAN AS SERVIS_ZINCIR,
					ST.SERVIS_TURU
				FROM KULLANICI AS K
					LEFT JOIN IL AS IL ON IL.ID = K.IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = K.ILCE_ID
					LEFT JOIN DURUM AS D ON D.ID = K.DURUM
					LEFT JOIN SERVIS_ZINCIR AS SZ ON SZ.ID = K.SERVIS_ZINCIR_ID
					LEFT JOIN SERVIS_TURU AS ST ON ST.ID = K.SERVIS_TURU
				WHERE K.YETKI_ID = 11
				";
		
		fncSqlKullanici($sql, $filtre);
		
		if($_REQUEST['unvan']) {
			$sql.=" AND K.UNVAN LIKE :UNVAN";
			$filtre[":UNVAN"] = "%" . $_REQUEST['unvan'] . "%";
		}
		
		if($_REQUEST['tck']) {
			$sql.=" AND K.TCK = :TCK";
			$filtre[":TCK"] = $_REQUEST['tck'];
		}
		
		if($_REQUEST['durum'] >= 0) {
			$sql.=" AND K.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['il_id'] > 0) {
			$sql.=" AND K.IL_ID = :IL_ID";
			$filtre[":IL_ID"] = $_REQUEST['il_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(K.TARIH) >= :TARIH1 AND DATE(K.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(K.GTARIH) >= :GTARIH1 AND DATE(K.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY K.UNVAN";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaZincirServisler(){
		
		$filtre = array();
		$sql = "SELECT 
					K.*,
					CONCAT_WS(' ', K.AD, K.SOYAD) AS ADI_SOYADI,
					D.DURUM,
					IL.IL,
					ILCE.ILCE,
					Y.YETKI
				FROM KULLANICI AS K
					LEFT JOIN IL AS IL ON IL.ID = K.IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = K.ILCE_ID
					LEFT JOIN DURUM AS D ON D.ID = K.DURUM
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
				WHERE K.YETKI_ID IN(20,21)
				";
		
		fncSqlKullanici($sql, $filtre);
		
		if($_REQUEST['unvan']) {
			$sql.=" AND K.UNVAN LIKE :AD";
			$filtre[":UNVAN"] = "%" . $_REQUEST['unvan'] . "%";
		}
		
		if($_REQUEST['tck']) {
			$sql.=" AND K.TCK = :TCK";
			$filtre[":TCK"] = $_REQUEST['tck'];
		}
		
		if($_REQUEST['durum'] >= 0) {
			$sql.=" AND K.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['il_id'] > 0) {
			$sql.=" AND K.IL_ID = :IL_ID";
			$filtre[":IL_ID"] = $_REQUEST['il_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(K.TARIH) >= :TARIH1 AND DATE(K.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(K.GTARIH) >= :GTARIH1 AND DATE(K.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY K.UNVAN";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaMuayeneIstasyonlari(){
		
		$filtre = array();
		$sql = "SELECT 
					MI.*,
					D.DURUM,
					IL.IL,
					ILCE.ILCE
				FROM MUAYENE_ISTASYONU AS MI
					LEFT JOIN IL AS IL ON IL.ID = MI.IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = MI.ILCE_ID
					LEFT JOIN DURUM AS D ON D.ID = MI.DURUM
				WHERE 1
				";
		
		fncSqlKullanici($sql, $filtre);
		
		if($_REQUEST['ad']) {
			$sql.=" AND K.AD LIKE :AD";
			$filtre[":AD"] = "%" . $_REQUEST['ad'] . "%";
		}
		
		if($_REQUEST['soyad']) {
			$sql.=" AND K.SOYAD LIKE :SOYAD";
			$filtre[":SOYAD"] = "%" . $_REQUEST['soyad'] . "%";
		}
		
		if($_REQUEST['unvan']) {
			$sql.=" AND K.UNVAN LIKE :UNVAN";
			$filtre[":UNVAN"] = "%" . $_REQUEST['unvan'] . "%";
		}
		
		if($_REQUEST['kullanici']) {
			$sql.=" AND K.KULLANICI LIKE :KULLANICI";
			$filtre[":KULLANICI"] = "%" . $_REQUEST['kullanici'] . "%";
		}
		
		if($_REQUEST['yetki_id']>0) {
			$sql.=" AND K.YETKI_ID = :YETKI_ID";
			$filtre[":YETKI_ID"] = $_REQUEST['yetki_id'];
		}
		
		if(count($_GET['arac_alim_turu_id']) > 0){
			$sql.=" AND FIND_IN_SET(K.ARAC_ALIM_TURU_ID,'".implode($_GET['arac_alim_turu_id'],',')."')";
		}
		
		if($_REQUEST['il_id'] > 0) {
			$sql.=" AND K.IL_ID = :IL_ID";
			$filtre[":IL_ID"] = $_REQUEST['il_id'];
		}
		
		if($_REQUEST['durum'] >= 0) {
			$sql.=" AND K.DURUM = :DURUM";
			$filtre[":DURUM"] = $_REQUEST['durum'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(K.TARIH) >= :TARIH1 AND DATE(K.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(K.GTARIH) >= :GTARIH1 AND DATE(K.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		
		if($_REQUEST['sozlesme'] >= 0 AND isset($_REQUEST['sozlesme'])) {
			$sql.=" AND K.SOZLESME = :SOZLESME";
			$filtre[":SOZLESME"] = $_REQUEST['sozlesme'];
		}
		
		if($_REQUEST['teklif_durum'] >= 0 AND isset($_REQUEST['teklif_durum'])) {
			$sql.=" AND K.TEKLIF_DURUM = :TEKLIF_DURUM";
			$filtre[":TEKLIF_DURUM"] = $_REQUEST['teklif_durum'];
		}
		
		$sql.= " ORDER BY MI.MUAYENE_ISTASYONU";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaBanner(){
		
		$filtre = array();
		$sql = "SELECT
					B.*,
					M.MARKA AS MARKA,
					M.RESIM_URL AS RESIM,
					P.PARCA_ADI AS PARCA,
					D.DURUM
				FROM BANNER_LOGO AS B
					LEFT JOIN DURUM AS D ON D.ID = B.DURUM
					LEFT JOIN MARKA AS M ON M.ID = B.MARKA_ID
					LEFT JOIN PARCA AS P ON P.ID = B.PARCA_ID
				WHERE 1
				";
		
		$sql.= " ORDER BY ID ASC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaTalepGenisRapor(){
		
		$filtre = array();
		$sql = "SELECT 
					T.*,
					MA.MARKA,
					MO.MODEL,
					S.SUREC,
					C.CARI,
					TS.KULLANICI AS SORUMLU
				FROM TALEP AS T
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
					LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
					LEFT JOIN KULLANICI AS TS ON TS.ID = T.SORUMLU_ID
				WHERE 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no'] > 0) {
			$sql.=" AND T.DOSYA_NO = :DOSYA_NO";
			$filtre[":DOSYA_NO"] = $_REQUEST['dosya_no'];
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['surec_id'] == 11){
			$sql.=" AND T.SUREC_ID IN(3,4,5,6)";
		} else if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['sorumlu_id'] > 0) {
			$sql.=" AND T.SORUMLU_ID = :SORUMLU_ID";
			$filtre[":SORUMLU_ID"] = $_REQUEST['sorumlu_id'];
		}	
		
		if($_REQUEST['servis_bolum'] AND $_REQUEST['servis_bolum'] != -1) {
			$sql.=" AND T.SERVIS_BOLUM = :SERVIS_BOLUM";
			$filtre[":SERVIS_BOLUM"] = $_REQUEST['servis_bolum'];
		}	
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['randevu_tarih'] AND $_REQUEST['randevu_tarih_var']) {
			$tarih = explode(",", $_REQUEST['randevu_tarih']);	
			$sql.=" AND DATE(T.RANDEVU_TARIH) >= :RANDEVU_TARIH1 AND DATE(T.RANDEVU_TARIH) <= :RANDEVU_TARIH2";
			$filtre[":RANDEVU_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":RANDEVU_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['arac_gelis_tarih'] AND $_REQUEST['arac_gelis_tarih_var']) {
			$tarih = explode(",", $_REQUEST['arac_gelis_tarih']);	
			$sql.=" AND DATE(T.ARAC_GELIS_TARIH) >= :ARAC_GELIS_TARIH1 AND DATE(T.ARAC_GELIS_TARIH) <= :ARAC_GELIS_TARIH2";
			$filtre[":ARAC_GELIS_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":ARAC_GELIS_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['tahmini_teslim_tarih'] AND $_REQUEST['tahmini_teslim_tarih_var']) {
			$tarih = explode(",", $_REQUEST['tahmini_teslim_tarih']);	
			$sql.=" AND DATE(T.TAHMINI_TESLIM_TARIH) >= :TAHMINI_TESLIM_TARIH1 AND DATE(T.TAHMINI_TESLIM_TARIH) <= :TAHMINI_TESLIM_TARIH2";
			$filtre[":TAHMINI_TESLIM_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TAHMINI_TESLIM_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['teslim_tarih'] AND $_REQUEST['teslim_tarih_var']) {
			$tarih = explode(",", $_REQUEST['teslim_tarih']);	
			$sql.=" AND DATE(T.TESLIM_EDILDI_TARIH) >= :TESLIM_EDILDI_TARIH1 AND DATE(T.TESLIM_EDILDI_TARIH) <= :TESLIM_EDILDI_TARIH2";
			$filtre[":TESLIM_EDILDI_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TESLIM_EDILDI_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY T.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaSigortaBilgileriRapor(){
		
		$filtre = array();
		$sql = "SELECT 
					T.ID,
					T.KOD,
					T.DOSYA_NO,
					T.SIGORTA_SEKLI,
					T.RUHSAT_SAHIBI,
					T.SIGORTALI_TEL,
					T.SIGORTALI_TCK,
					T.TARIH,
					T.PLAKA,
					SI.FIRMA AS SIGORTA,
					C.CARI,
					S.SUREC
				FROM TALEP AS T
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
					LEFT JOIN FIRMA AS SI ON SI.ID = T.SIGORTA_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
				WHERE 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no'] > 0) {
			$sql.=" AND T.DOSYA_NO = :DOSYA_NO";
			$filtre[":DOSYA_NO"] = $_REQUEST['dosya_no'];
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['sigorta_id'] > 0) {
			$sql.=" AND T.SIGORTA_ID = :SIGORTA_ID";
			$filtre[":SIGORTA_ID"] = $_REQUEST['sigorta_id'];
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['surec_id'] == 11){
			$sql.=" AND T.SUREC_ID IN(3,4,5,6)";
		} else if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['sorumlu_id'] > 0) {
			$sql.=" AND T.SORUMLU_ID = :SORUMLU_ID";
			$filtre[":SORUMLU_ID"] = $_REQUEST['sorumlu_id'];
		}	
		
		if($_REQUEST['servis_bolum'] AND $_REQUEST['servis_bolum'] != -1) {
			$sql.=" AND T.SERVIS_BOLUM = :SERVIS_BOLUM";
			$filtre[":SERVIS_BOLUM"] = $_REQUEST['servis_bolum'];
		}	
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['teslim_tarih'] AND $_REQUEST['teslim_tarih_var']) {
			$tarih = explode(",", $_REQUEST['teslim_tarih']);	
			$sql.=" AND DATE(T.TESLIM_EDILDI_TARIH) >= :TESLIM_EDILDI_TARIH1 AND DATE(T.TESLIM_EDILDI_TARIH) <= :TESLIM_EDILDI_TARIH2";
			$filtre[":TESLIM_EDILDI_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TESLIM_EDILDI_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY T.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaSigortaOdemeBekleyenRapor(){
		
		$filtre = array();
		$sql = "SELECT 
					T.ID,
					T.KOD,
					T.DOSYA_NO,
					T.SIGORTA_SEKLI,
					T.RUHSAT_SAHIBI,
					T.SIGORTALI_TEL,
					T.SIGORTALI_TCK,
					T.TARIH,
					T.PLAKA,
					T.FATURA_NO,
					T.FATURA_TARIH,
					T.FATURA_TUTAR,
					T.SIGORTA_ODEME_TALIMAT_TARIH,
					SI.FIRMA AS SIGORTA,
					C.CARI,
					C.TCK,
					S.SUREC,
					(T.SIGORTA_ODEME_TUTAR1 + T.SIGORTA_ODEME_TUTAR2 + T.SIGORTA_ODEME_TUTAR3 + T.SIGORTA_ODEME_TUTAR4 + T.SIGORTA_ODEME_TUTAR5) AS ODEME_TUTAR,
					(T.FATURA_TUTAR - (T.SIGORTA_ODEME_TUTAR1 + T.SIGORTA_ODEME_TUTAR2 + T.SIGORTA_ODEME_TUTAR3 + T.SIGORTA_ODEME_TUTAR4 + T.SIGORTA_ODEME_TUTAR5)) AS KALAN_TUTAR,
					CASE
						WHEN T.SIGORTA_ODEME_TUTAR5 > 0 THEN 5
						WHEN T.SIGORTA_ODEME_TUTAR4 > 0 THEN 4
						WHEN T.SIGORTA_ODEME_TUTAR3 > 0 THEN 3
						WHEN T.SIGORTA_ODEME_TUTAR2 > 0 THEN 2
						WHEN T.SIGORTA_ODEME_TUTAR1 > 0 THEN 1
						ELSE 0
					END ODEME_SAY
				FROM TALEP AS T
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
					LEFT JOIN FIRMA AS SI ON SI.ID = T.SIGORTA_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
				WHERE T.SIGORTA_ID > 0 
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no'] > 0) {
			$sql.=" AND T.DOSYA_NO = :DOSYA_NO";
			$filtre[":DOSYA_NO"] = $_REQUEST['dosya_no'];
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['sigorta_id'] > 0) {
			$sql.=" AND T.SIGORTA_ID = :SIGORTA_ID";
			$filtre[":SIGORTA_ID"] = $_REQUEST['sigorta_id'];
		}
		
		if($_REQUEST['muhasebe_surec_id'] > 0) {
			$sql.=" AND T.MUHASEBE_SUREC_ID = :MUHASEBE_SUREC_ID";
			$filtre[":MUHASEBE_SUREC_ID"] = $_REQUEST['muhasebe_surec_id'];
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['surec_id'] == 11){
			$sql.=" AND T.SUREC_ID IN(3,4,5,6)";
		} else if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['sorumlu_id'] > 0) {
			$sql.=" AND T.SORUMLU_ID = :SORUMLU_ID";
			$filtre[":SORUMLU_ID"] = $_REQUEST['sorumlu_id'];
		}	
		
		if($_REQUEST['servis_bolum'] AND $_REQUEST['servis_bolum'] != -1) {
			$sql.=" AND T.SERVIS_BOLUM = :SERVIS_BOLUM";
			$filtre[":SERVIS_BOLUM"] = $_REQUEST['servis_bolum'];
		}	
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['teslim_tarih'] AND $_REQUEST['teslim_tarih_var']) {
			$tarih = explode(",", $_REQUEST['teslim_tarih']);	
			$sql.=" AND DATE(T.TESLIM_EDILDI_TARIH) >= :TESLIM_EDILDI_TARIH1 AND DATE(T.TESLIM_EDILDI_TARIH) <= :TESLIM_EDILDI_TARIH2";
			$filtre[":TESLIM_EDILDI_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TESLIM_EDILDI_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY T.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaAlisFaturaRapor(){
		
		$filtre = array();
		$sql = "SELECT 
					T.ID,
					T.KOD,
					CH.FATURA_KES,
					CH.DOSYA_NO,
					CASE
						WHEN T.FATURA_KES = 1 THEN 'Fatura'
						WHEN T.FATURA_KES = 2 THEN 'İrsaliye'
						ELSE ''
					END AS FATURA_KES,
					T.TARIH,
					CH.PLAKA,
					CH.ID AS FATURA_ID,
					CH.KOD AS FATURA_KOD,
					CH.FATURA_NO,
					CH.FATURA_TARIH,
					CH.TUTAR AS FATURA_TUTAR,
					(CH.TUTAR / 1.18 * 0.18) AS FATURA_KDV,
					CH.ACIKLAMA,
					C.CARI,
					S.SUREC,
					FK.FINANS_KALEMI,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN
				FROM CARI_HAREKET AS CH
					LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
				WHERE CH.HAREKET_ID = 2
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no'] > 0) {
			$sql.=" AND T.DOSYA_NO = :DOSYA_NO";
			$filtre[":DOSYA_NO"] = $_REQUEST['dosya_no'];
		}
		
		if($_REQUEST['fatura_no']) {
			$sql.=" AND T.FATURA_NO LIKE :FATURA_NO";
			$filtre[":FATURA_NO"] = "%" . $_REQUEST['fatura_no'];
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['sigorta_id'] > 0) {
			$sql.=" AND T.SIGORTA_ID = :SIGORTA_ID";
			$filtre[":SIGORTA_ID"] = $_REQUEST['sigorta_id'];
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['surec_id'] == 11){
			$sql.=" AND T.SUREC_ID IN(3,4,5,6)";
		} else if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['sorumlu_id'] > 0) {
			$sql.=" AND T.SORUMLU_ID = :SORUMLU_ID";
			$filtre[":SORUMLU_ID"] = $_REQUEST['sorumlu_id'];
		}	
		
		if($_REQUEST['servis_bolum'] AND $_REQUEST['servis_bolum'] != -1) {
			$sql.=" AND T.SERVIS_BOLUM = :SERVIS_BOLUM";
			$filtre[":SERVIS_BOLUM"] = $_REQUEST['servis_bolum'];
		}	
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(CH.GTARIH) >= :GTARIH1 AND DATE(CH.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['fatura_tarih'] AND $_REQUEST['fatura_tarih_var']) {
			$tarih = explode(",", $_REQUEST['fatura_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY CH.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaSatisFaturaRapor(){
		
		$filtre = array();
		$sql = "SELECT 
					T.ID,
					T.KOD,
					CH.FATURA_KES,
					CH.DOSYA_NO,
					CASE
						WHEN T.FATURA_KES = 1 THEN 'Fatura'
						WHEN T.FATURA_KES = 2 THEN 'İrsaliye'
						ELSE ''
					END AS FATURA_KES,
					T.TARIH,
					CH.PLAKA,
					CH.ID AS FATURA_ID,
					CH.KOD AS FATURA_KOD,
					CH.FATURA_NO,
					CH.FATURA_TARIH,
					CH.TUTAR AS FATURA_TUTAR,
					(CH.TUTAR / 1.18 * 0.18) AS FATURA_KDV,
					CH.ACIKLAMA,
					C.CARI,
					S.SUREC,
					FK.FINANS_KALEMI,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN
				FROM CARI_HAREKET AS CH
					LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
				WHERE CH.HAREKET_ID = 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR CH.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND CH.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no'] > 0) {
			$sql.=" AND CH.DOSYA_NO = :DOSYA_NO";
			$filtre[":DOSYA_NO"] = $_REQUEST['dosya_no'];
		}
		
		if($_REQUEST['fatura_no']) {
			$sql.=" AND CH.FATURA_NO LIKE :FATURA_NO";
			$filtre[":FATURA_NO"] = "%" . $_REQUEST['fatura_no'];
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['sigorta_id'] > 0) {
			$sql.=" AND T.SIGORTA_ID = :SIGORTA_ID";
			$filtre[":SIGORTA_ID"] = $_REQUEST['sigorta_id'];
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['surec_id'] == 11){
			$sql.=" AND T.SUREC_ID IN(3,4,5,6)";
		} else if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['sorumlu_id'] > 0) {
			$sql.=" AND T.SORUMLU_ID = :SORUMLU_ID";
			$filtre[":SORUMLU_ID"] = $_REQUEST['sorumlu_id'];
		}	
		
		if($_REQUEST['servis_bolum'] AND $_REQUEST['servis_bolum'] != -1) {
			$sql.=" AND T.SERVIS_BOLUM = :SERVIS_BOLUM";
			$filtre[":SERVIS_BOLUM"] = $_REQUEST['servis_bolum'];
		}	
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(CH.TARIH) >= :TARIH1 AND DATE(CH.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(CH.GTARIH) >= :GTARIH1 AND DATE(CH.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['fatura_tarih'] AND $_REQUEST['fatura_tarih_var']) {
			$tarih = explode(",", $_REQUEST['fatura_tarih']);	
			$sql.=" AND DATE(CH.FATURA_TARIH) >= :FATURA_TARIH1 AND DATE(CH.FATURA_TARIH) <= :FATURA_TARIH2";
			$filtre[":FATURA_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":FATURA_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY CH.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaAlisSatisRapor(){
		
		$filtre = array();
		$sql = "SELECT 
					P.PARCA_ADI,
					P.PARCA_KODU,
					P.ADET,
					P.ID AS PARCA_ID,
					P.TALEP_ID,
					P.SIPARIS_TARIH,
					P.ALIS,
					P.TUTAR,
					T.ID,
					T.KOD,
					T.PLAKA,
					T.DOSYA_NO,
					T.SERVIS_BOLUM,
					T.TESLIM_EDILDI_TARIH,
					S.SUREC
				FROM PARCA AS P
					LEFT JOIN TALEP AS T ON T.ID = P.TALEP_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
				WHERE 1=1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['musteri_tipi'] AND $_REQUEST['musteri_tipi'] != -1) {
			$sql.=" AND T.MUSTERI_TIPI = :MUSTERI_TIPI";
			$filtre[":MUSTERI_TIPI"] = $_REQUEST['musteri_tipi'];
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['dosya_no']) {
			$sql.=" AND T.DOSYA_NO = :DOSYA_NO";
			$filtre[":DOSYA_NO"] = $_REQUEST['dosya_no'];
		}
		
		if($_REQUEST['parca_adi']) {
			$sql.=" AND P.PARCA_ADI LIKE :PARCA_ADI";
			$filtre[":PARCA_ADI"] = "%" . $_REQUEST['parca_adi'] . "%";
		}
		
		if($_REQUEST['parca_kodu']) {
			$sql.=" AND P.PARCA_KODU LIKE :PARCA_KODU";
			$filtre[":PARCA_KODU"] = "%" . $_REQUEST['parca_kodu'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['servis_il_id'] > 0) {
			$sql.=" AND T.SERVIS_IL_ID = :SERVIS_IL_ID";
			$filtre[":SERVIS_IL_ID"] = $_REQUEST['servis_il_id'];
		}
		
		if($_REQUEST['hizmet_id'] > 0) {
			$sql.=" AND T.HIZMET_ID = :HIZMET_ID";
			$filtre[":HIZMET_ID"] = $_REQUEST['hizmet_id'];
		}
		
		if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['teslim_tarih'] AND $_REQUEST['teslim_tarih_var']) {
			$tarih = explode(",", $_REQUEST['teslim_tarih']);	
			$sql.=" AND DATE(T.TESLIM_EDILDI_TARIH) >= :TESLIM_EDILDI_TARIH1 AND DATE(T.TESLIM_EDILDI_TARIH) <= :TESLIM_EDILDI_TARIH2";
			$filtre[":TESLIM_EDILDI_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TESLIM_EDILDI_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY T.ID, P.PARCA_ADI DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 200);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaServisIkameTakip(){
		
		$filtre = array();
		$sql = "SELECT 
					T.*,
					MA.MARKA,
					MO.MODEL,
					C.CARI,
					S.SUREC,
					CASE
						WHEN T.IKAME_VEREN_ID = 1 THEN 'Servis'
						WHEN T.IKAME_VEREN_ID = 2 THEN 'Dışardan'
						ELSE ''
					END AS IKAME_VEREN
				FROM TALEP AS T
					LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
				WHERE T.SUREC_ID < 10 AND T.IKAME_ID > 0
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['musteri_tipi'] AND $_REQUEST['musteri_tipi'] != -1) {
			$sql.=" AND T.MUSTERI_TIPI = :MUSTERI_TIPI";
			$filtre[":MUSTERI_TIPI"] = $_REQUEST['musteri_tipi'];
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['servis_il_id'] > 0) {
			$sql.=" AND T.SERVIS_IL_ID = :SERVIS_IL_ID";
			$filtre[":SERVIS_IL_ID"] = $_REQUEST['servis_il_id'];
		}
		
		if($_REQUEST['hizmet_id'] > 0) {
			$sql.=" AND T.HIZMET_ID = :HIZMET_ID";
			$filtre[":HIZMET_ID"] = $_REQUEST['hizmet_id'];
		}
		
		if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY T.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 200);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaIkameTakip(){
		
		$filtre = array();
		$sql = "SELECT 
					A.PLAKA,
					A.SURUCU_AD,
					MA.MARKA,
					MO.MODEL,
					S.SUREC,
					T.ID AS TALEP_ID,
					T.ID,
					T.KOD,
					T.ID AS TALEP_NO,										
					TI.ID AS IKAME_ID,
					TI.KOD AS IKAME_KOD,
					TI.SUREC_ID,
					KI.ID AS KIRALAMA_ID,
					KI.KOD AS KIRALAMA_KOD,
					KI.SUREC_ID,
					CASE 
						WHEN KI.ID > 0 THEN 'KIRALAMA'
						WHEN TI.ID > 0 THEN 'IKAME'
						ELSE 'BOS'
					END AS DURUM,
					CASE 
						WHEN KI.ID > 0 THEN KI.VERILIS_TARIH
						WHEN TI.ID > 0 THEN T.IKAME_VERILIS_TARIH
						ELSE ''
					END AS VERILIS_TARIH,
					CASE 
						WHEN KI.ID > 0 THEN KI.TAHMINI_IADE_TARIH
						WHEN TI.ID > 0 THEN T.IKAME_GELIS_TARIH
						ELSE ''
					END AS GELIS_TARIH,
					CASE 
						WHEN KI.ID > 0 THEN DATEDIFF(KI.TAHMINI_IADE_TARIH, CURDATE())
						WHEN TI.ID > 0 THEN DATEDIFF(T.IKAME_GELIS_TARIH, CURDATE())
						ELSE ''
					END AS KALAN_GUN,
					CASE 
						WHEN KI.ID > 0 THEN KI.SURUCU_AD_SOYAD
						WHEN T.ID > 0 THEN T.PLAKA
						ELSE A.SURUCU_AD
					END AS SURUCU
				FROM ARAC AS A
					LEFT JOIN TALEP_IKAME AS TI ON TI.ARAC_ID = A.ID AND TI.SUREC_ID = 2
					LEFT JOIN KIRALAMA AS KI ON KI.ARAC_ID = A.ID AND KI.SUREC_ID = 2
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN TALEP AS T ON T.ID = TI.TALEP_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
				WHERE A.DURUM = 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['musteri_tipi'] AND $_REQUEST['musteri_tipi'] != -1) {
			$sql.=" AND T.MUSTERI_TIPI = :MUSTERI_TIPI";
			$filtre[":MUSTERI_TIPI"] = $_REQUEST['musteri_tipi'];
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['servis_il_id'] > 0) {
			$sql.=" AND T.SERVIS_IL_ID = :SERVIS_IL_ID";
			$filtre[":SERVIS_IL_ID"] = $_REQUEST['servis_il_id'];
		}
		
		if($_REQUEST['hizmet_id'] > 0) {
			$sql.=" AND T.HIZMET_ID = :HIZMET_ID";
			$filtre[":HIZMET_ID"] = $_REQUEST['hizmet_id'];
		}
		
		if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY A.PLAKA DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 200);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaKiralamaTakip(){
		
		$filtre = array();
		$sql = "SELECT 
					A.ID,
					A.KOD,
					A.PLAKA,
					A.SURUCU_AD,
					MA.MARKA,
					MO.MODEL,
					KI.VERILIS_TARIH,
					KI.TAHMINI_IADE_TARIH,
					KI.IADE_TARIH,
					KI.SUREC_ID,
					KI.SURUCU_TEL,
					C.CARI,
					CASE 
						WHEN KI.ID > 0 THEN 'KIRALAMA'
						WHEN TI.ID > 0 THEN 'IKAME'
						ELSE 'BOS'
					END AS DURUM,
					CASE 
						WHEN KI.ID > 0 THEN KI.VERILIS_TARIH
						WHEN TI.ID > 0 THEN T.IKAME_VERILIS_TARIH
						ELSE ''
					END AS VERILIS_TARIH,
					CASE 
						WHEN KI.ID > 0 THEN KI.TAHMINI_IADE_TARIH
						WHEN TI.ID > 0 THEN T.IKAME_GELIS_TARIH
						ELSE ''
					END AS GELIS_TARIH,
					CASE 
						WHEN KI.ID > 0 THEN DATEDIFF(KI.TAHMINI_IADE_TARIH, CURDATE())
						WHEN TI.ID > 0 THEN DATEDIFF(T.IKAME_GELIS_TARIH, CURDATE())
						ELSE ''
					END AS KALAN_GUN,
					CASE 
						WHEN KI.ID > 0 THEN KI.FATURA_KESIM_TARIH
						WHEN TI.ID > 0 THEN ''
						ELSE ''
					END AS FATURA_KESIM_TARIH,
					CASE 
						WHEN KI.ID > 0 THEN KI.SURUCU_AD_SOYAD
						WHEN T.ID > 0 THEN T.PLAKA
						ELSE A.SURUCU_AD
					END AS SURUCU,
					KI.ID AS KIRALAMA_ID,
					KI.KOD AS KIRALAMA_KOD
				FROM ARAC AS A 
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN TALEP_IKAME AS TI ON TI.ARAC_ID = A.ID AND TI.SUREC_ID = 2
					LEFT JOIN TALEP AS T ON T.ID = TI.TALEP_ID
					LEFT JOIN KIRALAMA AS KI ON KI.ARAC_ID = A.ID AND KI.SUREC_ID = 2
					LEFT JOIN CARI AS C ON C.ID = KI.CARI_ID
				WHERE A.DURUM = 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['musteri_tipi'] AND $_REQUEST['musteri_tipi'] != -1) {
			$sql.=" AND T.MUSTERI_TIPI = :MUSTERI_TIPI";
			$filtre[":MUSTERI_TIPI"] = $_REQUEST['musteri_tipi'];
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['servis_il_id'] > 0) {
			$sql.=" AND T.SERVIS_IL_ID = :SERVIS_IL_ID";
			$filtre[":SERVIS_IL_ID"] = $_REQUEST['servis_il_id'];
		}
		
		if($_REQUEST['hizmet_id'] > 0) {
			$sql.=" AND T.HIZMET_ID = :HIZMET_ID";
			$filtre[":HIZMET_ID"] = $_REQUEST['hizmet_id'];
		}
		
		if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY MA.MARKA, MO.MODEL ";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 200);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaSozlesmeTakip(){
		
		$filtre = array();
		$sql = "SELECT 
					S.*,
					C.CARI,
					(SELECT GROUP_CONCAT(SD.PLAKA) FROM SOZLESME_DETAY AS SD WHERE SD.SOZLESME_ID = S.ID) AS PLAKALAR
				FROM SOZLESME AS S
					LEFT JOIN CARI AS C ON C.ID = S.CARI_ID
				WHERE 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['musteri_tipi'] AND $_REQUEST['musteri_tipi'] != -1) {
			$sql.=" AND T.MUSTERI_TIPI = :MUSTERI_TIPI";
			$filtre[":MUSTERI_TIPI"] = $_REQUEST['musteri_tipi'];
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['servis_il_id'] > 0) {
			$sql.=" AND T.SERVIS_IL_ID = :SERVIS_IL_ID";
			$filtre[":SERVIS_IL_ID"] = $_REQUEST['servis_il_id'];
		}
		
		if($_REQUEST['hizmet_id'] > 0) {
			$sql.=" AND T.HIZMET_ID = :HIZMET_ID";
			$filtre[":HIZMET_ID"] = $_REQUEST['hizmet_id'];
		}
		
		if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY S.ID DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 200);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaParcaTakip(){
		
		$filtre = array();
		$sql = "SELECT 
					P.PARCA_ADI,
					P.PARCA_KODU,
					P.ADET,
					P.ID AS PARCA_ID,
					P.TALEP_ID,
					P.SIPARIS_TARIH,
					T.ID,
					T.KOD,
					T.PLAKA,
					T.ARAC_GELIS_TARIH,
					T.TAHMINI_TESLIM_TARIH,
					MA.MARKA,
					MO.MODEL,
					C.CARI,
					S.SUREC,
					COUNT(P.ID) AS PARCA_SAYISI
				FROM PARCA AS P
					LEFT JOIN TALEP AS T ON T.ID = P.TALEP_ID
					LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
				WHERE T.SUREC_ID < 10 
					AND P.TEDARIKCI IN (1,2) 
					AND P.GELDI_TARIH IS NULL
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['musteri_tipi'] AND $_REQUEST['musteri_tipi'] != -1) {
			$sql.=" AND T.MUSTERI_TIPI = :MUSTERI_TIPI";
			$filtre[":MUSTERI_TIPI"] = $_REQUEST['musteri_tipi'];
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['servis_il_id'] > 0) {
			$sql.=" AND T.SERVIS_IL_ID = :SERVIS_IL_ID";
			$filtre[":SERVIS_IL_ID"] = $_REQUEST['servis_il_id'];
		}
		
		if($_REQUEST['hizmet_id'] > 0) {
			$sql.=" AND T.HIZMET_ID = :HIZMET_ID";
			$filtre[":HIZMET_ID"] = $_REQUEST['hizmet_id'];
		}
		
		if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " GROUP BY T.ID, P.TEDARIKCI ORDER BY T.ID, P.PARCA_ADI DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 200);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaTalepTakip(){
		
		$filtre = array();
		$sql = "SELECT 
					T.*,
					MA.MARKA,
					MO.MODEL,
					C.CARI,
					S.SUREC,
					TS.KULLANICI AS SORUMLU
				FROM TALEP AS T
					LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
					LEFT JOIN KULLANICI AS TS ON TS.ID = T.SORUMLU_ID
				WHERE T.SUREC_ID < 10
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['musteri_tipi'] AND $_REQUEST['musteri_tipi'] != -1) {
			$sql.=" AND T.MUSTERI_TIPI = :MUSTERI_TIPI";
			$filtre[":MUSTERI_TIPI"] = $_REQUEST['musteri_tipi'];
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['servis_il_id'] > 0) {
			$sql.=" AND T.SERVIS_IL_ID = :SERVIS_IL_ID";
			$filtre[":SERVIS_IL_ID"] = $_REQUEST['servis_il_id'];
		}
		
		if($_REQUEST['hizmet_id'] > 0) {
			$sql.=" AND T.HIZMET_ID = :HIZMET_ID";
			$filtre[":HIZMET_ID"] = $_REQUEST['hizmet_id'];
		}
		
		if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY T.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 200);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaOdemeTakip(){
		
		$filtre = array();
		$sql = "SELECT 
					T.*,
					MA.MARKA,
					MO.MODEL,
					C.CARI,
					S.SUREC
				FROM TALEP AS T
					LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
				WHERE T.SUREC_ID IN(6,10) 
					AND T.MUHASEBE_SUREC_ID = 1
				";
		
		fncSqlTalep($sql, $filtre);
		
		if($_REQUEST['arama_q']) {
			$sql.=" AND (T.ID LIKE :TALEP_ID OR T.PLAKA LIKE :PLAKA)";
			$filtre[":TALEP_ID"] = "%" . $_REQUEST['arama_q'] . "%";			
			$filtre[":PLAKA"] = "%" . $_REQUEST['arama_q'] . "%";
		}
		
		if($_REQUEST['talep_no'] > 0) {
			$sql.=" AND T.ID = :ID";
			$filtre[":ID"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":CARI_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['musteri_tipi'] AND $_REQUEST['musteri_tipi'] != -1) {
			$sql.=" AND T.MUSTERI_TIPI = :MUSTERI_TIPI";
			$filtre[":MUSTERI_TIPI"] = $_REQUEST['musteri_tipi'];
		}
		
		if($_REQUEST['plaka']) {
			$sql.=" AND T.PLAKA LIKE :PLAKA";
			$filtre[":PLAKA"] = "%" . $_REQUEST['plaka'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['servis_il_id'] > 0) {
			$sql.=" AND T.SERVIS_IL_ID = :SERVIS_IL_ID";
			$filtre[":SERVIS_IL_ID"] = $_REQUEST['servis_il_id'];
		}
		
		if($_REQUEST['hizmet_id'] > 0) {
			$sql.=" AND T.HIZMET_ID = :HIZMET_ID";
			$filtre[":HIZMET_ID"] = $_REQUEST['hizmet_id'];
		}
		
		if($_REQUEST['surec_id'] > 0) {
			$sql.=" AND T.SUREC_ID = :SUREC_ID";
			$filtre[":SUREC_ID"] = $_REQUEST['surec_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['gtarih'] AND $_REQUEST['gtarih_var']) {
			$tarih = explode(",", $_REQUEST['gtarih']);	
			$sql.=" AND DATE(T.GTARIH) >= :GTARIH1 AND DATE(T.GTARIH) <= :GTARIH2";
			$filtre[":GTARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":GTARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY T.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 200);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	} 
	
	public function sayfaExcelListe(){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.TARIH,
					E.TUR,
					E.EXCEL,
					E.EXCEL_ILK,
					E.NOTU,
					E.DURUM,
					E.SIPARIS_ID,
					IF(E.DURUM=1, 'AKTİF', 'PASİF') AS DURUM_TEXT,
					K.KULLANICI AS YUKLEYEN,
					CONCAT('excel/', E.EXCEL) AS YOL
				FROM EXCEL AS E
					LEFT JOIN KULLANICI AS K ON K.ID = E.YUKLEYEN_ID
				WHERE E.DURUM = :DURUM
				ORDER BY E.TARIH DESC
				";	
		
		$filtre[":DURUM"] 		= 1;
		
		$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->cdbPDO->setSayfalama(@$_REQUEST["sayfa"], $rowsCount, 1000);
        $this->sayfaIlk		= $this->cdbPDO->getSayfaIlk();		
        $this->sayfaSon		= $this->cdbPDO->getSayfaSon();	
        $this->sayfaAdet	= $this->cdbPDO->getSayfaAdet(); 
        $this->sayfaUstYazi	= $this->cdbPDO->getSayfaUstYazi();	
        $this->sayfaAltYazi	= $this->cdbPDO->getSayfaAltYazi();
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
            
		return $this;
		
	}
	
	public function sayfaEntegrasyonListe(){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.TUR,
					E.TARIH,
					E.BITIS_TARIH,
					TIMESTAMPDIFF(MINUTE, E.TARIH, E.BITIS_TARIH) AS FARK,
					E.DURUM,
					IF(E.DURUM=1, 'BAŞARILI', 'BAŞARISIZ') AS DURUM_TEXT,
					E.ACIKLAMA
				FROM ENTEGRASYON AS E
				WHERE 1=1
				ORDER BY E.TARIH DESC
				";	
		
		$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->cdbPDO->setSayfalama(@$_REQUEST["sayfa"], $rowsCount, 100);
        $this->sayfaIlk		= $this->cdbPDO->getSayfaIlk();		
        $this->sayfaSon		= $this->cdbPDO->getSayfaSon();	
        $this->sayfaAdet	= $this->cdbPDO->getSayfaAdet(); 
        $this->sayfaUstYazi	= $this->cdbPDO->getSayfaUstYazi();	
        $this->sayfaAltYazi	= $this->cdbPDO->getSayfaAltYazi();
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
            
		return $this;
		
	}
	
	public function sayfaEntegrasyonDetay(){
		
		$filtre = array();
		$sql = "SELECT
					ED.ID,
					ED.ISLEM,
					ED.ENTEGRASYON_ID,
					ED.ISLEM,
					ED.URUN_ID,
					ED.MUSTERI_ID,
					ED.TARIH,
					U.URUN_KOD,
					U.URUN
				FROM ENTEGRASYON_DETAY AS ED
					LEFT JOIN URUN AS U ON U.ID = ED.URUN_ID
				WHERE ED.ENTEGRASYON_ID = :ID
				ORDER BY ED.ID
				";	
		$filtre[":ID"] 		= $_REQUEST['id'];
		 
		$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
        
        $this->cdbPDO->setSayfalama(@$_REQUEST["sayfa"], $rowsCount, 1000);
        $this->sayfaIlk		= $this->cdbPDO->getSayfaIlk();		
        $this->sayfaSon		= $this->cdbPDO->getSayfaSon();	
        $this->sayfaAdet	= $this->cdbPDO->getSayfaAdet(); 
        $this->sayfaUstYazi	= $this->cdbPDO->getSayfaUstYazi();	
        $this->sayfaAltYazi	= $this->cdbPDO->getSayfaAltYazi();
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
            
		return $this;
		
	}
	
	public function sayfaSon6AylikRapor(){
		
		$filtre = array();
		$sql = "SELECT
        			DATE_FORMAT(S.TARIH,'%Y%m') AS AYYIL,
        			MONTH(S.TARIH) AS AY,
        			YEAR(S.TARIH) AS YIL,
        			COUNT(*) AS SAYI, 
        			SUM(S.TUTAR) AS TUTAR, 
        			AVG(S.TUTAR) AS ORTALAMA,
        			GROUP_CONCAT(S.ID ORDER BY S.ID) AS SIPARIS_IDS
        		FROM SIPARIS AS S
        			LEFT JOIN KULLANICI AS K ON K.ID = S.KULLANICI_ID
        			LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
        		WHERE S.TARIH > DATE_ADD(NOW(), INTERVAL -6 MONTH)
        		GROUP BY DATE_FORMAT(S.TARIH,'%Y%m')
        		ORDER BY 1 DESC;
				";	
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$sqls = strstr($sql, " LIMIT ", true);
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= (strlen($sqls)>0) ? $sqls : $sql;
        $this->filtre 	= $filtre;
            
		return $this;
		
	}
	
	public function sayfaSon30GunlukRapor(){
		
		$filtre = array();
		$sql = "SELECT        			
        			DATE_FORMAT(S.TARIH,'%m%d') AS AYGUN,
        			DATE_FORMAT(S.TARIH,'%Y-%m-%d') AS TARIH,
        			MONTH(S.TARIH) AS AY, 
        			DAY(S.TARIH) AS GUN, 
        			COUNT(*) AS SAYI, 
        			SUM(S.TUTAR) AS TUTAR, 
        			AVG(S.TUTAR) AS ORTALAMA,
        			GROUP_CONCAT(S.ID ORDER BY S.ID) AS SIPARIS_IDS
        		FROM SIPARIS AS S
        			LEFT JOIN KULLANICI AS K ON K.ID = S.KULLANICI_ID
        			LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
        		WHERE S.TARIH > DATE_ADD(NOW(), INTERVAL -1 MONTH)
        		GROUP BY DATE_FORMAT(S.TARIH,'%m%d'), S.KULLANICI_ID
        		ORDER BY AYGUN DESC, KULLANICI ASC";
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$sqls = strstr($sql, " LIMIT ", true);
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= (strlen($sqls)>0) ? $sqls : $sql;
        $this->filtre 	= $filtre;
            
		return $this;
		
	}
	
	public function sayfaYpOrjinalParcaListe(){
		
		$filtre = array();
		$sql = "SELECT
					Y.*,
					MA.MARKA,
					PT.PARCA_TIPI,
					TC.CARI AS TEDARIKCI
				FROM YP_LISTE AS Y
					LEFT JOIN MARKA AS MA ON MA.ID = Y.MARKA_ID
					LEFT JOIN PARCA_TIPI AS PT ON PT.ID = Y.PARCA_TIPI_ID
					LEFT JOIN CARI AS TC ON TC.ID = Y.TEDARIKCI_ID
				WHERE Y.PARCA_TIPI_ID = 1
				";
		
		if($_SESSION['yetki_id'] == 3){
			$sql.=" AND Y.TEDARIKCI_ID = :TEDARIKCI_ID";
			$filtre[":TEDARIKCI_ID"] = $_SESSION['cari_id'];
		}
		
		if($_REQUEST['tedarikci_id'] > 0){
			$sql.=" AND Y.TEDARIKCI_ID = :TEDARIKCI_ID";
			$filtre[":TEDARIKCI_ID"] = $_REQUEST['tedarikci_id'];
		}
		
		if($_REQUEST['id']) {
			$sql.=" AND Y.ID = :ID";
			$filtre[":ID"] = $_REQUEST['id'];
		}
		
		if($_REQUEST['oem_kodu']) {
			$sql.=" AND Y.OEM_KODU LIKE :OEM_KODU";
			$filtre[":OEM_KODU"] = "%" . $_REQUEST['oem_kodu'] . "%";
		}
		
		if($_REQUEST['parca_kodu']) {
			$sql.=" AND Y.PARCA_KODU LIKE :PARCA_KODU";
			$filtre[":PARCA_KODU"] = "%" . $_REQUEST['parca_kodu'] . "%";
		}
		
		if($_REQUEST['parca_adi']) {
			$sql.=" AND Y.PARCA_ADI LIKE :PARCA_ADI";
			$filtre[":PARCA_ADI"] = "%" . $_REQUEST['parca_adi'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND MA.ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['parca_tipi_id'] > 0) {
			$sql.=" AND Y.PARCA_TIPI_ID = :PARCA_TIPI_ID";
			$filtre[":PARCA_TIPI_ID"] = $_REQUEST['parca_tipi_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(Y.TARIH) >= :TARIH1 AND DATE(Y.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY Y.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
		if(TRUE){
			list($sql1, $sql2) = explode('FROM YP_LISTE', $sqls);
			$sql_say = "SELECT COUNT(*) AS SAY FROM YP_LISTE " . $sql2;
			$rowsCount =  $this->cdbPDO->row($sql_say, $filtre)->SAY;
		} else {
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);	
		}		
        
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaParcaListesi(){
		
		$filtre = array();
		$sql = "SELECT
					Y.*,
					MA.MARKA,
					PT.PARCA_TIPI,
					TC.CARI AS TEDARIKCI
				FROM YP_LISTE AS Y
					LEFT JOIN MARKA AS MA ON MA.ID = Y.MARKA_ID
					LEFT JOIN PARCA_TIPI AS PT ON PT.ID = Y.PARCA_TIPI_ID
					LEFT JOIN CARI AS TC ON TC.ID = Y.TEDARIKCI_ID
				WHERE 1
				";
		
		if($_SESSION['yetki_id'] == 3){
			$sql.=" AND Y.TEDARIKCI_ID = :TEDARIKCI_ID";
			$filtre[":TEDARIKCI_ID"] = $_SESSION['cari_id'];
		} else if($_REQUEST['tedarikci_id'] > 0){
			$sql.=" AND Y.TEDARIKCI_ID = :TEDARIKCI_ID";
			$filtre[":TEDARIKCI_ID"] = $_REQUEST['tedarikci_id'];
		}
		
		if($_REQUEST['id']) {
			$sql.=" AND Y.ID = :ID";
			$filtre[":ID"] = $_REQUEST['id'];
		}
		
		if($_REQUEST['uuid']) {
			$sql.=" AND Y.UUID = :UUID";
			$filtre[":UUID"] = $_REQUEST['uuid'];
		}
		
		if($_REQUEST['oem_kodu']) {
			$sql.=" AND Y.OEM_KODU LIKE :OEM_KODU";
			$filtre[":OEM_KODU"] = "%" . $_REQUEST['oem_kodu'] . "%";
		}
		
		if($_REQUEST['parca_kodu']) {
			$sql.=" AND Y.PARCA_KODU LIKE :PARCA_KODU";
			$filtre[":PARCA_KODU"] = "%" . $_REQUEST['parca_kodu'] . "%";
		}
		
		if($_REQUEST['parca_adi']) {
			$sql.=" AND Y.PARCA_ADI LIKE :PARCA_ADI";
			$filtre[":PARCA_ADI"] = "%" . $_REQUEST['parca_adi'] . "%";
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND MA.ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['stok_var']) {
			$sql.=" AND Y.STOK = 1";			
		}
		
		if($_REQUEST['kampanyali']) {
			$sql.=" AND Y.KAMPANYALI = 1";			
		}
		
		if($_REQUEST['parca_tipi_id'] > 0) {
			$sql.=" AND Y.PARCA_TIPI_ID = :PARCA_TIPI_ID";
			$filtre[":PARCA_TIPI_ID"] = $_REQUEST['parca_tipi_id'];
		}
		
		if($_REQUEST['parca_marka_id'] > 0) {
			$sql.=" AND Y.PARCA_MARKA_ID = :PARCA_MARKA_ID";
			$filtre[":PARCA_MARKA_ID"] = $_REQUEST['parca_marka_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(Y.TARIH) >= :TARIH1 AND DATE(Y.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " ORDER BY Y.TARIH DESC";
		// FIELD(YETKI_ID,1,2,4,3,4,5,6)
        
        $sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
		if(TRUE){
			list($sql1, $sql2) = explode('FROM YP_LISTE', $sqls);
			$sql_say = "SELECT COUNT(*) AS SAY FROM YP_LISTE " . $sql2;
			$rowsCount =  $this->cdbPDO->row($sql_say, $filtre)->SAY;
		} else {
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);	
		}
		
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
        
		return $this;
		
	}
	
	public function sayfaStokStoklar(){
		
		$filtre = array();
		$sql = "SELECT
					S.*,
					REPLACE(S.OEM_KODU,',',', ') AS OEM_KODU,
					CONCAT('stok/',YEAR(S.TARIH),'/',SR.STOK_ID,'/',SR.RESIM_ADI) AS URL,
					PM.PARCA_MARKA
				FROM STOK AS S 
					LEFT JOIN STOK_RESIM AS SR ON SR.STOK_ID = S.ID AND SR.SIRA = 1
					LEFT JOIN PARCA_MARKA AS PM ON PM.ID = S.PARCA_MARKA_ID
				WHERE 1 
                ";
		
		if($_REQUEST['kategori_id'] > 0) {
			$sql.=" AND S.KATEGORI_ID = :KATEGORI_ID";
			$filtre[":KATEGORI_ID"] = $_REQUEST['kategori_id'];
		}
		
		if($_REQUEST['kodu']) {
			$sql.=" AND S.KODU LIKE :KODU";
			$filtre[":KODU"] = "%" . $_REQUEST['kodu'] . "%";
		}
		
		if($_REQUEST['oem_kodu']) {
			$sql.=" AND S.OEM_KODU LIKE :OEM_KODU";
			$filtre[":OEM_KODU"] = "%" . $_REQUEST['oem_kodu'] . "%";
		}
		
		if($_REQUEST['stok']) {
			$sql.=" AND S.STOK LIKE :STOK";
			$filtre[":STOK"] = "%" . $_REQUEST['stok'] . "%";
		}
		
		if($_REQUEST['aciklama']) {
			$sql.=" AND S.ACIKLAMA LIKE :ACIKLAMA";
			$filtre[":ACIKLAMA"] = "%" . $_REQUEST['aciklama'] . "%";
		}
		
		if($_REQUEST['barkod']) {
			$sql.=" AND S.BARKOD LIKE :BARKOD";
			$filtre[":BARKOD"] = "%" . $_REQUEST['barkod'] . "%";
		}
		
		if($_REQUEST['parca_turu_id'] > 0) {
			$sql.=" AND S.PARCA_TURU_ID = :PARCA_TURU_ID";
			$filtre[":PARCA_TURU_ID"] = $_REQUEST['parca_turu_id'];
		}
				
		if($_REQUEST['katalog_parca_id'] > 0) {
			$sql.=" AND S.KATALOG_PARCA_ID = :KATALOG_PARCA_ID";
			$filtre[":KATALOG_PARCA_ID"] = $_REQUEST['katalog_parca_id'];
		}
		
		if($_REQUEST['stok_katalog'] >= 0 AND isset($_REQUEST['stok_katalog'])) {
			$sql.=" AND S.STOK_KATALOG = :STOK_KATALOG";
			$filtre[":STOK_KATALOG"] = $_REQUEST['stok_katalog'];
		}		
		
		if($_REQUEST['stok_durum'] == 1) {
			$sql.=" AND CS.ADET <= 0";
		} else if($_REQUEST['stok_durum'] == 2) {
			$sql.=" AND CS.ADET < 5";
		} else if($_REQUEST['stok_durum'] == 3) {
			$sql.=" AND CS.ADET > 0";
		} else if($_REQUEST['stok_durum'] == 4) {
			$sql.=" AND CS.ADET = 0";
		}
		
		if(in_array($_REQUEST['durum'], array('0','1'))){
			$sql.=" AND S.DURUM = :DURUM";
			$filtre[":DURUM"] =  $_REQUEST['durum'];
		}
		
		if($_REQUEST['tarih']){
			$sql.=" HAVING STOK_HAREKET_TARIH < :TARIH AND ADET2 > 0 AND CS.SATIS_ADET <= 0";
			$filtre[":TARIH"] =  FormatTarih::nokta2db($_REQUEST['tarih']);
		}
		
		$sql.=" ORDER BY S.ID";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
		if(TRUE){
			list($sql1, $sql2) = explode('FROM STOK', $sqls);
			$sql_say = "SELECT COUNT(*) AS SAY FROM STOK" . $sql2;
			$rowsCount =  $this->cdbPDO->row($sql_say, $filtre)->SAY;
		} else {
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);	
		}
		
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}

	public function sayfaUrunler(){
		
		$filtre = array();
		$sql = "SELECT
					S.*,
					REPLACE(S.OEM_KODU,',',', ') AS OEM_KODU,
					CONCAT('stok/',YEAR(S.TARIH),'/',SR.STOK_ID,'/',SR.RESIM_ADI) AS URL,
					PM.PARCA_MARKA
				FROM STOK AS S 
					LEFT JOIN STOK_RESIM AS SR ON SR.STOK_ID = S.ID AND SR.SIRA = 1
					LEFT JOIN PARCA_MARKA AS PM ON PM.ID = S.PARCA_MARKA_ID
				WHERE 1 
                ";
		
		if($_REQUEST['kategori_id'] > 0) {
			$sql.=" AND S.KATEGORI_ID = :KATEGORI_ID";
			$filtre[":KATEGORI_ID"] = $_REQUEST['kategori_id'];
		}
		
		if($_REQUEST['kodu']) {
			$sql.=" AND S.KODU LIKE :KODU";
			$filtre[":KODU"] = "%" . $_REQUEST['kodu'] . "%";
		}
		
		if($_REQUEST['oem_kodu']) {
			$sql.=" AND S.OEM_KODU LIKE :OEM_KODU";
			$filtre[":OEM_KODU"] = "%" . $_REQUEST['oem_kodu'] . "%";
		}
		
		if($_REQUEST['urun']) {
			$sql.=" AND S.STOK LIKE :URUN";
			$filtre[":URUN"] = "%" . $_REQUEST['urun'] . "%";
		}
		
		if($_REQUEST['aciklama']) {
			$sql.=" AND S.ACIKLAMA LIKE :ACIKLAMA";
			$filtre[":ACIKLAMA"] = "%" . $_REQUEST['aciklama'] . "%";
		}
		
		if($_REQUEST['barkod']) {
			$sql.=" AND S.BARKOD LIKE :BARKOD";
			$filtre[":BARKOD"] = "%" . $_REQUEST['barkod'] . "%";
		}
		
		if($_REQUEST['parca_turu_id'] > 0) {
			$sql.=" AND S.PARCA_TURU_ID = :PARCA_TURU_ID";
			$filtre[":PARCA_TURU_ID"] = $_REQUEST['parca_turu_id'];
		}
				
		if($_REQUEST['katalog_parca_id'] > 0) {
			$sql.=" AND S.KATALOG_PARCA_ID = :KATALOG_PARCA_ID";
			$filtre[":KATALOG_PARCA_ID"] = $_REQUEST['katalog_parca_id'];
		}
		
		if($_REQUEST['stok_katalog'] >= 0 AND isset($_REQUEST['stok_katalog'])) {
			$sql.=" AND S.STOK_KATALOG = :STOK_KATALOG";
			$filtre[":STOK_KATALOG"] = $_REQUEST['stok_katalog'];
		}		
		
		if($_REQUEST['stok_durum'] == 1) {
			$sql.=" AND CS.ADET <= 0";
		} else if($_REQUEST['stok_durum'] == 2) {
			$sql.=" AND CS.ADET < 5";
		} else if($_REQUEST['stok_durum'] == 3) {
			$sql.=" AND CS.ADET > 0";
		} else if($_REQUEST['stok_durum'] == 4) {
			$sql.=" AND CS.ADET = 0";
		}
		
		if(in_array($_REQUEST['durum'], array('0','1'))){
			$sql.=" AND S.DURUM = :DURUM";
			$filtre[":DURUM"] =  $_REQUEST['durum'];
		}
		
		if($_REQUEST['tarih']){
			$sql.=" HAVING STOK_HAREKET_TARIH < :TARIH AND ADET2 > 0 AND CS.SATIS_ADET <= 0";
			$filtre[":TARIH"] =  FormatTarih::nokta2db($_REQUEST['tarih']);
		}
		
		$sql.=" ORDER BY S.ID";
		
       	$sqls = strstr($sql, " LIMIT ", true);
		$sqls = (strlen($sqls)>0) ? $sqls : $sql;
		
		//Sayfalama için ekledim.
		if(TRUE){
			list($sql1, $sql2) = explode('FROM STOK', $sqls);
			$sql_say = "SELECT COUNT(*) AS SAY FROM STOK" . $sql2;
			$rowsCount =  $this->cdbPDO->row($sql_say, $filtre)->SAY;
		} else {
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);	
		}
		
        $this->setSayfalama2(@$_REQUEST["sayfa"], $rowsCount, 20);
		
		//Sayfalamaya göre dataların çekilmesi
        $sql  .= " LIMIT $this->sayfaIlk, $this->sayfaAdet";        
        
        $rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		
		$this->rows 	= $rows;
        $this->sql 		= $sql;
        $this->sqls		= $sqls;
        $this->filtre 	= $filtre;
		
		return $this;
		
	}
	
}

?>