<?

class comboData extends Basic {
	
	private $cdbPDO;
    private $rows;
    private $sql;
	private $secilen;
	private $tumuValue;
	private $tumuName;
	private $name;
	private $class;
	private $data;
	
	function __construct($cdbPDO) {
        $this->cdbPDO 	= $cdbPDO;
	}
	
	// Sql kodunun ne olduğunun öğrenmesi adına debug için kullanmaya
    private function setTemizle(){
        $this->secim = "";
		$this->tumu = "";
		$this->name = "";
		$this->tumuValue = "";
        $this->tumuName = "";
        $this->clss = "";
        $this->data = "";
        
    }
    
	// sadece dataların çıplak olarak dönmesini sağlıyor
    public function getData(){
        return $this->rows;
    }
    
    // seçilen datanın gösterilmesi
    public function setSecilen($secilen = ""){
    	
    	if(!empty($secilen) OR $secilen == "0") {
    		if(is_array($secilen)){
				$this->secilen = $secilen;
				
			}else if(strrpos($secilen,',')){
				$this->secilen = explode(',', $secilen);
							
			}else {
				$this->secilen = $secilen;	
			}
    		
    	} else {
			$this->secilen = -1;
		}
    	
        return $this;
    }
    
    // name verme için radio, checkbox
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    
     // Class bilgisini verme için radio, checkbox
    public function setClass($class){
        $this->class = $class;
        return $this;
    }
    
    // Tümü seçeneği değerlerinin olup olmaması
    public function setTumu($tumuValue = "", $tumuName = ""){
    	
    	if(empty($tumuValue)){
			$this->data .= "<option value='-1'>-- " . dil("Tümü") . " --</option>";
			
		} else{
			$this->data .= "<option value='$tumuValue'> $tumuName </option>";
			
		}        
        return $this;
        
    }
    
    // Tümü seçeneği değerlerinin boş olması
    public function setTumu2(){
        
        $this->data .= "<option value='-1'> " . dil("Tümü") . " </option>";
        
        return $this;
        
    }
    
    // Seçiniz seçeneği değerlerinin olup olmaması
    public function setSeciniz($tumuValue = "", $tumuName = ""){
    	
    	if(empty($tumuValue)){
			$this->data .= "<option value='-1'>-- ". dil("Seçiniz") ." --</option>";
			
		} else{
			$this->data .= "<option value='$tumuValue'>". dil($tumuName) . "</option>";
			
		}        
        return $this;
        
    }

	// <option></option> olarak ekrana basılmasına hazır haline getirilmesi 
    public function getSelect($value, $d, $title = "TITLE"){
        	
        foreach($this->rows as $key=>$row) {
        	if(is_array($this->secilen)){
				if( in_array($row->$value, $this->secilen) )
	        		$this->data .= "<option value=".$row->$value." title='".$row->$title."' selected >".$row->$d."</option>";
	        	else 
	        		$this->data .= "<option value=".$row->$value." title='".$row->$title."' >".$row->$d."</option>";
				
			} else {
				if( ($this->secilen == $row->$value AND isset($this->secilen)) OR in_array($row->$value, $this->secilen) )
	        		$this->data .= "<option value=".$row->$value." title='".$row->$title."' selected >".$row->$d."</option>";
	        	else 
	        		$this->data .= "<option value=".$row->$value." title='".$row->$title."' >".$row->$d."</option>";
			}
        	
        }
        return $this->data;
        
    }
    
    public function getMultiSelect($value, $d, $title = "TITLE"){
        
        foreach($this->rows as $key=>$row){
        	if($arr[$row->YETKI]){
				array_push($arr[$row->YETKI], [$d=>$row->$d, $value=>$row->$value]);
			}else{
				$arr[$row->YETKI] = array([$d=>$row->$d, $value=>$row->$value]);
			}
		}
        
        foreach($arr as $key=>$row) {
        	$this->data .= "<optgroup label='".$key."'>";
        	foreach($row as $k =>$v){
	    		$this->data .= "<option value=".$v[$value]." title='".$v[$title]."' >".$v[$d]."</option>";
			}
			$this->data .= "</optgroup>";
        }
        
        return $this->data;
        
    } 
        
    // <input type="checkbox" name="checkbox" value="1" checked>1
    public function getCheckbox($value, $d){
        
        foreach($this->rows as $key=>$row) {
        	if($this->secilen == $row->$value)
        		$this->data .= "<label> <input type='checkbox' class='".$this->clss."' name='".$this->name."' value=".$row->$value." checked>".$row->$d."</label>";
        	else 
        		$this->data .= "<label> <input type='checkbox' class='".$this->clss."' name='".$this->name."' value=".$row->$value.">".$row->$d."</label>";
        }
        return $this->data;
    }       
    
    // <input type="radio" name="radio" value="1" checked>1 
    public function getRadio($value, $d){
        
        foreach($this->rows as $key=>$row) {
        	if($this->secilen == $row->$value)
        		$this->data .= "<label> <input type='radio' class='".$this->clss."' name='".$this->name."' value=".$row->$value." checked>".$row->$d."</label>";
        	else 
        		$this->data .= "<label> <input type='radio' class='".$this->clss."' name='".$this->name."' value=".$row->$value.">".$row->$d."</label>";
        }
        return $this->data;
    }       
	
	// Sql kodunun ne olduğunun öğrenmesi adına debug için kullanmaya
    public function getSql(){
        return $this->sql;
    }
	
	public function getText($fnc, $id){
		$rows2 = $this->{$fnc}()->rows;
		foreach($rows2 as $key => $row2){
			$rows[$row2->ID]	= $row2->AD;
		}
		
		return $rows[2];
			
	}
	
	public function Kdv(){
		
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "0";
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "1";
		$rows[2]->ID  = "8";
		$rows[2]->AD  = "8";
		$rows[3]->ID  = "18";
		$rows[3]->AD  = "18";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function IkameTalebi(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Araç İstiyor";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "İstemiyor";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Tedarikci(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Servis Tedarik";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Sigorta Tedarik";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function MiniOnarımFirmalari(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "AutoKing";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "RS";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ParcaSayisi(){
		
		$k = 0;
		for($i = 0; $i <= 100; $i+=5){
			$rows[$k]->ID  = $i;
			$rows[$k]->AD  = $i;
			$k++;
		}
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function CevapDurum(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Cevaplı";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Cevapsız";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function TeslimNoktasi(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Servis";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Adresi manuel";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function AracHasarDurumu(){
		
		$rows[0]->ID  = "ARIZALI";
		$rows[0]->AD  = "Arızalı";
		$rows[1]->ID  = "HASARLI";
		$rows[1]->AD  = "Hasarlı";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function FavoriDurum(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Favorilerim";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Favorilerim Hariç";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function KazanmaDurum(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Kazandıklarım";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "İkinci olduklarım";
		$rows[2]->ID  = "3";
		$rows[2]->AD  = "Kaybettiklerim";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function BorcAlacak(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Borçlarım";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Alacaklarım";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Durumlar(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Aktif";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Pasif";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ParcaTip(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "OEM";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "OES";
		$rows[2]->ID  = "3";
		$rows[2]->AD  = "AM";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function KontrolEdildi(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Edildi";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Edilmedi";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function BakimOnarimKararlari(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Servis Geri";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Onarım Yapılsın";
		$rows[2]->ID  = "3";
		$rows[2]->AD  = "Onarım Red";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function EFatura(){
		
		$rows[0]->ID  = "E";
		$rows[0]->AD  = "E-Fatura";
		$rows[1]->ID  = "N";
		$rows[1]->AD  = "Normal";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function FaturaKes(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Fatura";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "İrsaliye";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function FaturaSiralama(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Fatura Tarih Azalan";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Fatura Tarih Artan";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function FaturaOdeme(){
		
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Ödenmedi";
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Ödendi";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ServisAdresSecimi(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Ev";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "İş";
		$rows[2]->ID  = "3";
		$rows[2]->AD  = "Kendim Seçeceğim";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}

	public function SigortaSekli(){
		
		$rows[0]->ID  = "T";
		$rows[0]->AD  = "Trafik";
		$rows[1]->ID  = "K";
		$rows[1]->AD  = "Kasko";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function IkameVeren(){
		
		$rows[0]->ID  = 1;
		$rows[0]->AD  = "Servis";
		$rows[1]->ID  = 2;
		$rows[1]->AD  = "Dışardan";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Vade(){
		
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "0";
		$rows[1]->ID  = "15";
		$rows[1]->AD  = "15";
		$rows[2]->ID  = "20";
		$rows[2]->AD  = "20";
		$rows[3]->ID  = "25";
		$rows[3]->AD  = "25";
		$rows[4]->ID  = "30";
		$rows[4]->AD  = "30";
		$rows[5]->ID  = "35";
		$rows[5]->AD  = "35";
		$rows[6]->ID  = "40";
		$rows[6]->AD  = "40";
		$rows[7]->ID  = "45";
		$rows[7]->AD  = "45";
		$rows[8]->ID  = "60";
		$rows[8]->AD  = "60";
		$rows[9]->ID  = "75";
		$rows[9]->AD  = "75";
		$rows[10]->ID  = "90";
		$rows[10]->AD  = "90";
		$rows[11]->ID  = "120";
		$rows[11]->AD  = "120";		
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
		
	public function MusteriTipi(){
		
		$rows[0]->ID  = "B";
		$rows[0]->AD  = "Bireysel (Şahış Şirketi)";
		$rows[1]->ID  = "K";
		$rows[1]->AD  = "Kurumsal (Vergi No)";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function TeklifDurumlar(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Versin";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Veremesin";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Sozlesme(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Var";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Yok";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Lastik(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Yaz";
		$rows[2]->ID  = "2";
		$rows[2]->AD  = "Kış";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function YedekAnahtar(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Var";
		$rows[0]->ID  = "2";
		$rows[0]->AD  = "Yok";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function PersoneleAracDurum(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Verildi";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Alındı";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function OdemeYapildi(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Ödeme Yapıldı";
		$rows[0]->ID  = "2";
		$rows[0]->AD  = "Ödeme Yok";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Bakim(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Var";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Yok";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Onarim(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Var";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Yok";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ValeHizmeti(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Var";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Yok";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function LastikSayisi(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "1";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "2";
		$rows[2]->ID  = "3";
		$rows[2]->AD  = "3";
		$rows[3]->ID  = "4";
		$rows[3]->AD  = "4";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	
	public function Entegrasyon(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Yapıldı";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Bekliyor";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function OtoyolGecis(){
		
		$rows[0]->ID  = "HGS";
		$rows[0]->AD  = "HGS";
		$rows[1]->ID  = "OGS";
		$rows[1]->AD  = "OGS";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function MailGondermeDurum(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Gönderilsin";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "İstemiyorum";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function SmsGondermeDurum(){
		
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Gönderilsin";
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "İstemiyorum";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function KiralamaSurec(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Müşteride";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Kontrol";
		$rows[2]->ID  = "10";
		$rows[2]->AD  = "Bitti";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
		
	public function Yil(){
		for($i = date("Y"); $i > date("Y")-3; $i--){
			$rows[$i]->ID  = $i;
			$rows[$i]->AD  = $i;
		}
		
		$this->SetTemizle();
		$this->rows = $rows;
		$this->sql = $sql;
		return $this;
	}
	
	public function Ay(){
		for($i = 1; $i <= 12; $i++){
			$rows[$i]->ID  = $i;
			$rows[$i]->AD  = $i;
		}
		
		$this->SetTemizle();
		$this->rows = $rows;
		$this->sql = $sql;
		return $this;
	}	
	
	public function Yil2(){
		for($i = date("Y"); $i < date("Y")+16; $i++){
			$rows[$i]->ID  = $i;
			$rows[$i]->AD  = $i;
		}
		
		$this->SetTemizle();
		$this->rows = $rows;
		$this->sql = $sql;
		return $this;
	}
	
	public function IhbarSure(){
		
		$k = 0;
		for($i = 0; $i <= 60; $i=$i+5){
			$rows[$k]->ID  = $i;
			$rows[$k]->AD  = $i;
			$k++;
		}
				
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Iskonto(){
		
		$k = 0;
		for($i = 0; $i <= 10; $i++){
			$rows[$k]->ID  = $i;
			$rows[$k]->AD  = $i;
			$k++;
		}
				
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Taksit(){
		
		$k = 0;
		for($i = 1; $i <= 120; $i++){
			$rows[$k]->ID  = $i;
			$rows[$k]->AD  = $i;
			$k++;
		}
				
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Oncelik(){
		
		$k = 0;
		for($i = 1; $i <= 10; $i++){
			$rows[$k]->ID  = $i;
			$rows[$k]->AD  = $i;
			$k++;
		}
				
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function StoksuzDurum(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Göster";
		$rows[1]->ID  = "0";
		$rows[1]->AD  = "Gizle";
				
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Evli(){
		
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Bekar";
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Evli";
				
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function EsiCalisiyor(){
		
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Hayır";
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Evet";
				
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ParaBirim(){
		
		$rows[0]->ID  = "TRY";
		$rows[0]->AD  = "TRY";
		$rows[1]->ID  = "USD";
		$rows[1]->AD  = "USD";
		$rows[2]->ID  = "EUR";
		$rows[2]->AD  = "EUR";
		$rows[3]->ID  = "GBP";
		$rows[3]->AD  = "GBP";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function MaasDonem(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Aylık";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Haftalık";
				
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function CocukSayisi(){
		
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "0";
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "1";
		$rows[2]->ID  = "2";
		$rows[2]->AD  = "2";
		$rows[3]->ID  = "3";
		$rows[3]->AD  = "3";
		$rows[4]->ID  = "4";
		$rows[4]->AD  = "4";
		$rows[5]->ID  = "5";
		$rows[5]->AD  = "5";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Sira(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "1";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "2";
		$rows[2]->ID  = "3";
		$rows[2]->AD  = "3";
		$rows[3]->ID  = "4";
		$rows[3]->AD  = "4";
				
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ResimSira($arrRequest = array()){
		
		for($i = 0; $i <= $arrRequest["RESIM_SAYISI"]; $i++){
			$rows[$i]->ID  = $i;
			$rows[$i]->AD  = $i;
		}
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function SayfaBasina(){
		
		$rows[0]->ID  = "5";
		$rows[0]->AD  = "Sayfada 5";
		$rows[1]->ID  = "10";
		$rows[1]->AD  = "Sayfada 10";
		$rows[2]->ID  = "20";
		$rows[2]->AD  = "Sayfada 20";
		$rows[3]->ID  = "50";
		$rows[3]->AD  = "Sayfada 50";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function SayfaSiralama(){
		
		$rows[0]->ID  = "1";
		$rows[0]->AD  = "Ürün Adı";
		$rows[1]->ID  = "2";
		$rows[1]->AD  = "Fiyat";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function YorumDurumlari(){
		
		$rows[0]->ID  = "0";
		$rows[0]->AD  = "Bekliyor";
		$rows[1]->ID  = "1";
		$rows[1]->AD  = "Onaylı";
		$rows[2]->ID  = "2";
		$rows[2]->AD  = "Red";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ServisBolum(){
		
		$rows[0]->ID  = "HASAR";
		$rows[0]->AD  = "HASAR";
		$rows[1]->ID  = "BAKIM";
		$rows[1]->AD  = "BAKIM";
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function FaturaSayisi(){
		
		for($i = 10; $i <= 200; $i=$i+10){
			$rows[$i]->ID  = $i;
			$rows[$i]->AD  = $i;
		}
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Gun(){
		
		for($i = 1; $i <= 31; $i++){
			$rows[$i]->ID  = $i;
			$rows[$i]->AD  = $i;
		}
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Segmentler(){
		
		$filtre = array();
		$sql = "SELECT
        			S.ID,
        			S.SEGMENT AS AD
				FROM SEGMENT AS S
				WHERE S.DURUM = 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Markalar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			M.ID,
        			M.MARKA AS AD
				FROM MARKA AS M
				WHERE M.DURUM = 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}

	public function Parcalar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			P.ID,
        			P.PARCA_ADI AS AD
				FROM PARCA AS P
				WHERE P.DURUM = 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Tedarikciler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			C.ID,
        			C.CARI AS AD
				FROM CARI AS C
				WHERE C.DURUM = 1 AND C.CARI_TURU = 'ALIM'
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Hizmetler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			H.ID,
        			H.HIZMET AS AD
				FROM HIZMET AS H
				WHERE H.DURUM = 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function HizmetSurecler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			S.ID,
        			S.SUREC AS AD
				FROM SUREC AS S
				WHERE S.HIZMET_ID = :HIZMET_ID 
					AND S.DURUM = 1
				ORDER BY 2
                ";		
		$filtre[":HIZMET_ID"]	= $arrRequest["hizmet_id"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Markalar2($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			M.ID,
        			M.MARKA AS AD
				FROM MARKA AS M
					INNER JOIN TALEP AS T ON T.MARKA_ID = M.ID
				WHERE M.DURUM = 1
				GROUP BY M.ID
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function MarkaModeller($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			M.ID,
        			M.MODEL AS AD
				FROM MODEL AS M
				WHERE M.DURUM = 1
					AND M.MARKA_ID = :MARKA_ID
				ORDER BY 2
                ";		
		$filtre[":MARKA_ID"] = $arrRequest["marka_id"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Modeller($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			M.ID,
        			M.MODEL AS AD
				FROM MODEL AS M
				WHERE M.DURUM = 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function YansitmaTip($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			Y.ID,
        			Y.YANSITMA_TIP AS AD
				FROM YANSITMA_TIP AS Y
				WHERE Y.DURUM = 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function FaturaDurumlar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			FD.ID,
        			FD.FATURA_DURUM AS AD
				FROM FATURA_DURUM AS FD
				WHERE 1
				ORDER BY FD.ID
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Bankalar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			B.ID,
        			CONCAT_WS(' - ',B.BANKA,B.PARA_BIRIM) AS AD
				FROM BANKA AS B
				WHERE B.DURUM = 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function LastikIslemTipi(){
		
		$filtre = array();
		$sql = "SELECT
        			M.ID,
        			M.LASTIK_ISLEM_TIPI AS AD
				FROM LASTIK_ISLEM_TIPI AS M
				WHERE M.DURUM = 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ModelYillari($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			MY.ID,
        			MY.MODEL_YILI AS AD
				FROM MODEL_YILI AS MY
				WHERE MY.DURUM = 1
				ORDER BY 2 DESC
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function KullanimTuru($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			KT.ID,
        			KT.KULLANIM_TURU AS AD
				FROM KULLANIM_TURU AS KT
				WHERE KT.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function SigortaTuru($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			ST.ID,
        			ST.SIGORTA_TURU AS AD
				FROM SIGORTA_TURU AS ST
				WHERE ST.DURUM = 1
				ORDER BY FIELD(ST.ID, 2, 1, 3)
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function YakitTuru($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			Y.ID,
        			Y.YAKIT AS AD
				FROM YAKIT AS Y
				WHERE Y.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function LastikEbat($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			LE.ID,
        			LE.LASTIK_EBAT AS AD
				FROM LASTIK_EBAT AS LE
				WHERE LE.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function LastikMarkalar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			LM.ID,
        			CONCAT_wS(' - ', LM.LASTIK_MARKA, LM.ANA_MARKA) AS AD
				FROM LASTIK_MARKA AS LM
				WHERE LM.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function RuhsatSahibi($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			R.ID,
        			R.RUHSAT_SAHIBI AS AD
				FROM RUHSAT_SAHIBI AS R
				WHERE R.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function FirmaRedNedeni($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			FRN.ID,
        			FRN.FIRMA_RED_NEDENI AS AD
				FROM FIRMA_RED_NEDENI AS FRN
				WHERE FRN.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function VitesTuru($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			V.ID,
        			V.VITES AS AD
				FROM VITES AS V
				WHERE V.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function ServisRedNedenleri($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			N.ID,
        			N.RED_NEDENI AS AD
				FROM RED_NEDENI AS N
				WHERE N.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function UyeIsyerleri($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			N.ID,
        			N.UNVAN AS AD
				FROM UYE_ISYERI AS N
				WHERE N.DURUM = 1
                ";		
		if($arrRequest["uye_isyeri_tipi"]){
			$sql.=" AND N.YETKI_ID = :YETKI_ID";
			$filtre[":YETKI_ID"] = $arrRequest["uye_isyeri_tipi"];
		}
		$sql.=" ORDER BY 2";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
		
	public function Cariler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			C.ID,
        			CONCAT_WS(' - ', C.CARI, C.CARI_KOD, C.TCK) AS AD
				FROM CARI AS C
				WHERE C.DURUM = 1
                ";		
		if($arrRequest["yetki_id"] == 4){
			$sql.=" AND C.CARI_TURU = 'SATIM'";
		}
		
		fncSqlCari($sql, $filtre);
		
		$sql.=" ORDER BY 2";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Musteriler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			C.ID,
        			C.KOD,
        			CONCAT_WS(' - ', C.CARI, K.UNVAN) AS AD
				FROM CARI AS C
					LEFT JOIN KULLANICI AS K ON K.ID = C.TEMSILCI_ID
				WHERE C.DURUM = 1 AND C.CARI_TURU = 'SATIM'
                ";		
		
		if(strlen($arrRequest['kod'])> 3){
			$sql.= " AND C.KOD = :KOD";
			$filtre[":KOD"]	 = $arrRequest["kod"];
		}
		
		fncSqlCari($sql, $filtre);
		
		$sql.=" ORDER BY 3";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function TeslimSekli($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			TS.KOD ID,
        			TS.TESLIM_SEKLI AS AD
				FROM TESLIM_SEKLI AS TS
				WHERE 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Personeller($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			C.ID,
        			CONCAT_WS(' - ', C.CARI, C.CARI_KOD, C.TCK) AS AD
				FROM CARI AS C
				WHERE C.DURUM = 1 AND C.CARI_TURU IN('PERSONEL')
				ORDER BY 2
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function MusteriAraclar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			A.ID,
        			CONCAT_WS(' ', A.PLAKA, '-', MA.MARKA, MO.MODEL, A.MODEL_YILI) AS AD
				FROM ARAC AS A
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
				WHERE A.MUSTERI_ID = :MUSTERI_ID
				ORDER BY 2
                ";		
		$filtre[":MUSTERI_ID"] = $arrRequest["musteri_id"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	
	public function IkameAraclar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			A.ID,
        			CONCAT_WS(' ', A.PLAKA, '-', MA.MARKA, MO.MODEL, A.MODEL_YILI) AS AD
				FROM ARAC AS A
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN TALEP AS T ON T.IKAME_ARAC_ID = A.ID
				WHERE A.DURUM = 1 
				ORDER BY 2
                ";		// AND T.ID IS NULL
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function AcikTalepler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			T.ID,
        			CONCAT_WS(' - ', T.ID, T.PLAKA, C.CARI) AS AD
				FROM TALEP AS T
					LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
				WHERE T.SUREC_ID < 10
				ORDER BY 2
                ";		// AND T.ID IS NULL
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
		
	public function HasarSekli($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			HS.ID,
        			HS.HASAR_SEKLI AS AD
				FROM HASAR_SEKLI AS HS
				WHERE HS.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function FisTur($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			FT.ID,
        			FT.FIS_TUR AS AD
				FROM FIS_TUR AS FT
				WHERE FT.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function ServisTuru($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			ST.ID,
        			ST.SERVIS_TURU AS AD
				FROM SERVIS_TURU AS ST
				WHERE 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Tevkifatkar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			T.ID,
        			T.TEVKIFAT AS AD
				FROM TEVKIFAT AS T
				WHERE T.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function ModelBakimPaketler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			BP.ID,
        			BP.KM,
        			BP.BAKIM_PAKET,
        			CONCAT_WS(' ', BP.KM, BP.BAKIM_PAKET) AS AD
				FROM BAKIM_PAKET AS BP
				WHERE BP.MARKA_ID = :MARKA_ID
					AND BP.MODEL_ID = :MODEL_ID
				ORDER BY 2
                ";		
		$filtre[":MARKA_ID"] = $arrRequest['marka_id'];
		$filtre[":MODEL_ID"] = $arrRequest['model_id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows as $key => $row){
			$row->AD = FormatSayi::sayi($row->AD) ." ". $row->BAKIM_PAKET;
		}
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function OtoYikamacilar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			K.ID,
        			K.UNVAN AS AD
				FROM KULLANICI AS K
				WHERE K.YETKI_ID = 16
                ORDER BY 2
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Servisler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			K.ID,
        			K.UNVAN AS AD
				FROM KULLANICI AS K
				WHERE K.YETKI_ID = 11
                ";
                
		if($arrRequest['cam_hizmeti'] > 0){
			$sql.= " AND K.CAM_HIZMETI = :CAM_HIZMETI";
			$filtre[":CAM_HIZMETI"] = $arrRequest['cam_hizmeti'];	
		}
		
		if($arrRequest['lastik_hizmeti'] > 0){
			$sql.= " AND K.LASTIK_HIZMETI = :LASTIK_HIZMETI";
			$filtre[":LASTIK_HIZMETI"] = $arrRequest['lastik_hizmeti'];	
		}
		
		if($arrRequest['lastik_otel_hizmeti'] > 0){
			$sql.= " AND K.LASTIK_OTEL_HIZMETI = :LASTIK_OTEL_HIZMETI";
			$filtre[":LASTIK_OTEL_HIZMETI"] = $arrRequest['lastik_otel_hizmeti'];	
		}
		
		if($arrRequest['onarim_hizmeti'] > 0){
			$sql.= " AND K.ONARIM_HIZMETI = :ONARIM_HIZMETI";
			$filtre[":ONARIM_HIZMETI"] = $arrRequest['onarim_hizmeti'];	
		}
		
		if($arrRequest['bakim_hizmeti'] > 0){
			$sql.= " AND K.BAKIM_HIZMETI = :BAKIM_HIZMETI";
			$filtre[":BAKIM_HIZMETI"] = $arrRequest['bakim_hizmeti'];	
		}
		
		if($arrRequest['aku_hizmeti'] > 0){
			$sql.= " AND K.AKU_HIZMETI = :AKU_HIZMETI";
			$filtre[":AKU_HIZMETI"] = $arrRequest['aku_hizmeti'];	
		}
		
		$sql.= " ORDER BY 2";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function IlServisler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			K.ID,
        			K.UNVAN AS AD
				FROM KULLANICI AS K
				WHERE K.IL_ID = :IL_ID
					AND K.YETKI_ID = 11
                ";
		$filtre[":IL_ID"] = $arrRequest['il_id'];
		if($arrRequest['bakim_hizmeti'] == 1){
			$sql.=" AND K.BAKIM_HIZMETI = 1";
		} else if($arrRequest['aku_hizmeti'] == 1){
			$sql.=" AND K.AKU_HIZMETI = 1";
		} else{
			$sql.=" AND 1=2";
		}
		
		$sql.=" ORDER BY 2";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
		
	public function Temsilciler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			K.ID,
        			K.UNVAN AS AD
				FROM KULLANICI AS K
				WHERE K.YETKI_ID IN(2,3,6) 
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function ServisDurumu($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			SD.ID,
        			SD.SERVIS_DURUMU AS AD
				FROM SERVIS_DURUMU AS SD
				WHERE 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Surecler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			S.ID,
        			S.SUREC AS AD
				FROM SUREC AS S
				WHERE 1
				ORDER BY S.SIRA
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}

	public function MuhasebeSurecler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			S.ID,
        			S.MUHASEBE_SUREC AS AD
				FROM MUHASEBE_SUREC AS S
				WHERE 1
				ORDER BY 1
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}

	public function Bayraklar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			B.ID,
        			B.BAYRAK AS AD
				FROM BAYRAK AS B
					LEFT JOIN DURUM AS D ON D.ID = B.DURUM
				WHERE B.DURUM = 1
				ORDER BY B.ID
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Renkler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			R.ID,
        			R.RENK AS AD
				FROM RENK AS R
					LEFT JOIN DURUM AS D ON D.ID = R.DURUM
				WHERE R.DURUM = 1
				ORDER BY R.ID
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Temalar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			T.ID,
        			T.TEMA AS AD
				FROM TEMA AS T
					LEFT JOIN DURUM AS D ON D.ID = T.DURUM
				WHERE T.DURUM = 1
				ORDER BY T.TEMA
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function FontBoyutlar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			T.ID,
        			T.FONT_BOYUT AS AD
				FROM FONT_BOYUT AS T
				WHERE T.DURUM = 1
				ORDER BY T.ID
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function ParcaMarkalarTedarikci($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			PM.ID,
        			PM.PARCA_MARKA AS AD
				FROM PARCA_MARKA AS PM
					INNER JOIN (SELECT PARCA_MARKA_ID, PARCA_MARKA FROM YP_LISTE WHERE TEDARIKCI_ID = :TEDARIKCI_ID GROUP BY PARCA_MARKA_ID) AS Y ON Y.PARCA_MARKA_ID = PM.ID
				WHERE PM.DURUM = 1
				ORDER BY 2
                ";		
		$filtre[":TEDARIKCI_ID"] = $arrRequest['tedarikci_id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function ParcaMarkalar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			PM.ID,
        			PM.PARCA_MARKA AS AD
				FROM PARCA_MARKA AS PM
				WHERE PM.DURUM = 1
				ORDER BY 2
                ";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	
	public function VergiDairesi($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			VD.ID,
        			VD.VERGI_DAIRESI AS AD
				FROM VERGI_DAIRESI AS VD
				WHERE VD.DURUM = 1
				ORDER BY 2
                ";		
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Ulkeler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					ID,
					ULKE AS AD
				FROM ULKE
                ORDER BY 2";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function ServisZincirler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					SZ.ID,
					SZ.UNVAN AS AD
				FROM SERVIS_ZINCIR AS SZ
                ORDER BY 2
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function BakimFiyatlar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					B.ID,
					B.FIYAT,
					SZ.SERVIS_ZINCIR
				FROM BAKIM_PAKET_FIYAT AS B	
					LEFT JOIN SERVIS_ZINCIR AS SZ ON SZ.ID = B.SERVIS_ZINCIR_ID
				WHERE B.BAKIM_PAKET_ID = :BAKIM_PAKET_ID
               
                ";
       	$filtre[":BAKIM_PAKET_ID"] = $arrRequest['bakim_paket_id'];
       	if($_REQUEST["servis_turu"] == "Y"){
			$sql.=" AND B.SERVIS_ZINCIR_ID IN(1)";
		} else {
			$sql.=" AND B.SERVIS_ZINCIR_ID IN(2,3,4)";
		}
		$sql.=" ORDER BY B.FIYAT DESC";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows as $key=>$row) {
	        $rows[$key]->AD	= $row->FIYAT ." - ". $row->SERVIS_ZINCIR;
        }
        
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function AkuMarkalar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					A.ID,
					A.AKU_MARKA AS AD
				FROM AKU_MARKA AS A
                ORDER BY 2
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Firmalar2($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					F.ID,
					F.FIRMA AS AD
				FROM FIRMA AS F
                WHERE F.DURUM = 1
                ORDER BY 2
                ";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Departmanlar($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					D.ID,
					D.DEPARTMAN AS AD
				FROM DEPARTMAN AS D
                WHERE D.DURUM = 1
                ORDER BY 2
                ";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Gorevler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					G.ID,
					G.GOREV AS AD
				FROM GOREV AS G
                WHERE G.DURUM = 1
                ORDER BY 2
                ";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Iller($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					ID,
					IL AS AD
				FROM IL
				WHERE 1
                ";
		if($arrRequest['ulke_id'] > 0){
			$sql.= " AND ULKE_ID = :ULKE_ID";
			$filtre[":ULKE_ID"] = $arrRequest['ulke_id'];
		}
		
		$sql.= " ORDER BY 2";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Ilceler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					ILCE.ID,
					ILCE.ILCE AS AD
				FROM ILCE AS ILCE
				WHERE ILCE.IL_ID = :IL_ID
                ORDER BY 2
                ";
		$filtre[":IL_ID"] = $arrRequest['il_id'];
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Ilceler2(){
		$filtre = array();
		$sql = "SELECT
					ILCE.ID,
					CONCAT_WS(' - ', IL.IL, ILCE.ILCE) AS AD
				FROM ILCE AS ILCE
					LEFT JOIN IL AS IL ON IL.ID = ILCE.IL_ID
                ORDER BY 2, 1
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function UlkedeIlIlceler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					CONCAT_WS('_', IL.ID, IFNULL(ILCE.ID,0)) AS ID,
					CONCAT_WS(' - ', IL.IL, ILCE.ILCE) AS AD
				FROM IL 
					LEFT JOIN ILCE ON ILCE.IL_ID = IL.ID
				WHERE IL.ULKE_ID = 1
                ORDER BY 2, 1
                ";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function IldeIlceler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					ILCE.ID,
					CONCAT_WS(' - ', IL.IL, ILCE.ILCE) AS AD
				FROM ILCE AS ILCE
					LEFT JOIN IL AS IL ON IL.ID = ILCE.ID
				WHERE ILCE.ID = :ID
                ORDER BY 2, 1
                ";
		$filtre[":ID"]		= $arrRequest["il_id"];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Yetkiler($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					Y.ID,
					Y.YETKI AS AD
				FROM YETKI AS Y
				WHERE FIND_IN_SET(:YETKI_ID, Y.YETKI_IDS)
				ORDER BY 2
                ";
                
		$filtre[":YETKI_ID"]		= $_SESSION["yetki_id"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function KullaniciTipi($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					Y.ID,
					Y.KULLANICI_TIPI AS AD
				FROM KULLANICI_TIPI AS Y
				WHERE Y.DURUM = 1
				ORDER BY 2
                ";
                
		$filtre[":YETKI_ID"]		= $_SESSION["yetki_id"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function YetkilerTumu(){
		$filtre = array();
		$sql = "SELECT
					Y.ID,
					Y.YETKI AS AD
				FROM YETKI AS Y
				WHERE 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Yetkiler0($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					Y.ID,
					Y.YETKI AS AD
				FROM YETKI AS Y
				WHERE Y.HIZMET_NOKTASI = 0 AND Y.DURUM = 1
				ORDER BY 2
                ";
                
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Yetkiler1($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					Y.ID,
					Y.YETKI AS AD
				FROM YETKI AS Y
				WHERE Y.HIZMET_NOKTASI = 1 AND Y.DURUM = 1
				ORDER BY 2
                ";
                
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Yetkiler2($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					Y.ID,
					Y.YETKI AS AD
				FROM YETKI AS Y
				WHERE Y.HIZMET_NOKTASI = 2 AND Y.DURUM = 1
				ORDER BY 2
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Yetkiler11($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					Y.ID,
					Y.YETKI AS AD
				FROM YETKI AS Y
				WHERE Y.HIZMET_NOKTASI = 1 AND Y.DURUM = 1 AND Y.ROL = 1
				ORDER BY 2
                ";
                
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function CalismaSaatler(){
		$filtre = array();
		$sql = "SELECT
					CS.ID,
					CS.CALISMA_SAAT AS AD,
					CS.CALISMA_SAAT2 AS AD2
				FROM CALISMA_SAAT AS CS
				WHERE CS.DURUM = 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function CalismaGunler(){
		$filtre = array();
		$sql = "SELECT
					CG.ID,
					CG.CALISMA_GUN AS AD
				FROM CALISMA_GUN AS CG
				WHERE CS.DURUM = 1
                ORDER BY 1
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function CariHesapTipleri(){
		$filtre = array();
		$sql = "SELECT 
					CHT.ID,
					CHT.CARI_HESAP_TIP AS AD
				FROM CARI_HESAP_TIP AS CHT
				WHERE 1
				ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function FirmaTuru(){
		$filtre = array();
		$sql = "SELECT 
					FT.ID,
					FT.FIRMA_TURU AS AD
				FROM FIRMA_TURU AS FT
				WHERE 1
				ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Meslekler(){
		$filtre = array();
		$sql = "SELECT
					M.ID,
					M.MESLEK AS AD
				FROM MESLEK AS M
				WHERE 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function EntegrasyonTipleri(){
		$filtre = array();
		$sql = "SELECT
					ET.ID,
					ET.TIP AS AD
				FROM ENTEGRASYON_TIP AS ET
				WHERE 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function MenuSira(){
		$filtre = array();
		$sql = "SELECT
					COUNT(*) AS TOPLAM
				FROM MENU
                ";
			
		$row = $this->cdbPDO->row($sql, $filtre);
		for($i = 0; $i < $row->TOPLAM ; $i++){
			$rows2[$i]->ID  = $i+1;
			$rows2[$i]->AD  = $i+1;
		}
		
		$this->SetTemizle();
		$this->rows = $rows2;
        $this->sql = $sql;
		return $this;
	}
	
	public function IhbarSuresi(){
		
		for($i = 0; $i < 100 ; $i++){
			$rows2[$i]->ID  = $i;
			$rows2[$i]->AD  = $i;
		}
		
		$this->SetTemizle();
		$this->rows = $rows2;
        $this->sql = $sql;
		return $this;
	}
	
	public function Kullanicilar(){
		$filtre = array();
		$sql = "SELECT
					K.ID,
					K.YETKI_ID,
					Y.YETKI,
					K.KULLANICI AS AD,
					CONCAT_WS(' ', K.AD, K.SOYAD) AS ADSOYAD,
					CONCAT(K.AD, ' ', K.SOYAD, ' (', K.KULLANICI, ')') AS ADSOYAD2
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
				WHERE K.DURUM = 1
                ORDER BY K.YETKI_ID";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Sorumlular(){
		$filtre = array();
		$sql = "SELECT
					K.ID,
					K.KULLANICI AS AD,
					CONCAT_WS(' ', K.AD, K.SOYAD) AS ADSOYAD,
					CONCAT(K.AD, ' ', K.SOYAD, ' (', K.KULLANICI, ')') AS ADSOYAD2
				FROM KULLANICI AS K
				WHERE K.DURUM = 1 AND K.YETKI_ID IN(2,3)
                ORDER BY 2";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
		$this->sql = $sql;
		return $this;
	}
	
	public function AracAlimTurleri(){
		$filtre = array();
		$sql = "SELECT
					AAT.ID,
					AAT.TUR AS AD
				FROM ARAC_ALIM_TURU AS AAT
                ORDER BY TUR";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function OdemeKanallari(){
		$filtre = array();
		$sql = "SELECT
					OK.ID,
					OK.ODEME_KANALI AS AD
				FROM ODEME_KANALI AS OK
				WHERE OK.DURUM = 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function OdemeKanaliDetay($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
					OKD.ID,
					OKD.ODEME_KANALI_DETAY AS AD
				FROM ODEME_KANALI_DETAY AS OKD
				WHERE OKD.DURUM = 1 AND OKD.ODEME_KANALI_ID = :ODEME_KANALI_ID
                ORDER BY 2
                ";
		$filtre[":ODEME_KANALI_ID"]	= $arrRequest["odeme_kanali_id"];	
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function OdemeKanalDetaylar(){
		$filtre = array();
		$sql = "SELECT
					OKD.ID,
					CONCAT_WS(' - ', OK.ODEME_KANALI, OKD.ODEME_KANALI_DETAY) AS AD
				FROM ODEME_KANALI_DETAY AS OKD
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = OKD.ODEME_KANALI_ID
				WHERE OKD.DURUM = 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function ParaBirimi(){
		
		$filtre = array();
		$sql = "SELECT
					PB.DOVIZ AS ID,
					PB.PARA_BIRIMI AS AD
				FROM PARA_BIRIMI AS PB
				WHERE 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function SigortaFirmalari(){
		
		$filtre = array();
		$sql = "SELECT
					F.ID,
					F.FIRMA AS AD
				FROM FIRMA AS F
				WHERE F.SIGORTA_FILO = 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	
	public function SigortaFilo(){
		
		$filtre = array();
		$sql = "SELECT
					SF.ID,
					SF.SIGORTA_FILO AS AD
				FROM SIGORTA_FILO AS SF
				WHERE 1
                ";
		/*
		if($_SESSION['yetki_id'] == 4){
			$sql.= " AND SF.ID = :ID";
			$filtre[":ID"] = 1;
		} else if($_SESSION['yetki_id'] == 5){
			$sql.= " AND SF.ID = :ID";
			$filtre[":ID"] = 2;
		}
		*/
		
		$sql.= " ORDER BY 2";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Evraklar(){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.EVRAK AS AD
				FROM EVRAK AS E
				WHERE 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ResimTurleri($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.EVRAK AS AD
				FROM EVRAK AS E
				WHERE E.ID < 10 
                ORDER BY FIELD(E.ID, 2, 3, 4, 5)
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function IkameResimTurleri($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.EVRAK AS AD
				FROM EVRAK AS E
				WHERE E.EVRAK_BOLUM_ID = 3
                ORDER BY EVRAK DESC
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function IkameEvrakTurleri($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.EVRAK AS AD
				FROM EVRAK AS E
				WHERE E.EVRAK_BOLUM_ID = 6
                ORDER BY EVRAK DESC
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function KiralamaResimTurleri($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.EVRAK AS AD
				FROM EVRAK AS E
				WHERE E.EVRAK_BOLUM_ID = 5
                ORDER BY EVRAK DESC
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function KiralamaEvrakTurleri($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.EVRAK AS AD
				FROM EVRAK AS E
				WHERE E.EVRAK_BOLUM_ID = 6
                ORDER BY EVRAK DESC
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	
	public function EvrakTurleri($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.EVRAK AS AD
				FROM EVRAK AS E
				WHERE E.ID > 9 AND E.HASAR = :HASAR
                ORDER BY 2
                ";
		$filtre[":HASAR"]	= $arrRequest["HASAR"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function EvrakTurleriArac(){
		
		$filtre = array();
		$sql = "SELECT
					E.ID,
					E.EVRAK AS AD
				FROM EVRAK AS E
				WHERE E.ID > 9 AND HASAR = 0
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function Hareket(){
		
		$filtre = array();
		$sql = "SELECT
					H.ID,
					H.HAREKET AS AD
				FROM HAREKET AS H
				WHERE 1
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function FinansKalemi(){
		
		$filtre = array();
		$sql = "SELECT
					FK.ID,
					FK.FINANS_KALEMI AS AD
				FROM FINANS_KALEMI AS FK
				WHERE GELIR IN(1,2,3)
                ORDER BY FK.SIRA
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
		
	public function FinansKalemiGelir(){
		
		$filtre = array();
		$sql = "SELECT
					FK.ID,
					FK.FINANS_KALEMI AS AD
				FROM FINANS_KALEMI AS FK
				WHERE GELIR IN(1,3)
                ORDER BY FK.SIRA
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function FinansKalemiGider(){
		
		$filtre = array();
		$sql = "SELECT
					FK.ID,
					FK.FINANS_KALEMI AS AD
				FROM FINANS_KALEMI AS FK
				WHERE GELIR IN(2,3)
                ORDER BY 2
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function KdvFisEkle(){
		
		$filtre = array();
		$sql = "SELECT
					KV.ID,
					KV.ORAN AS ORAN
				FROM KDV AS KV
				WHERE KV.ID IN(1)
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function SmsKalibi(){
		
		$filtre = array();
		$sql = "SELECT
					SK.ID,
					CONCAT_WS(' - ', SK.ID, SK.SMS_KALIBI) AS AD
				FROM SMS_KALIBI AS SK
				WHERE 1
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function TalepDosyalari(){
		
		$filtre = array();
		$sql = "SELECT
					T.ID,
					CONCAT(T.ID, ' - ', T.PLAKA, ' - ', DATE_FORMAT(DATE(T.TARIH), '%d.%m.%Y')) AS AD
				FROM TALEP AS T
				WHERE T.TARIH > DATE_ADD(NOW(), INTERVAL -3 MONTH)
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function TalepDosyalariOdeme(){
		
		$filtre = array();
		$sql = "SELECT
					T.ID,
					CONCAT(T.ID, ' - ', T.PLAKA, ' - ', DATE_FORMAT(DATE(T.TARIH), '%d.%m.%Y')) AS AD
				FROM CARI_HAREKET AS CH
					LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID				
				WHERE CH.HAREKET_ID = 1 AND CH.ODEME = 0
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function FisKayitYapan(){
		$filtre = array();
		$sql = "SELECT
					K.ID,
					CONCAT(K.AD, ' ', K.SOYAD, ' (', K.KULLANICI, ')') AS AD
				FROM KULLANICI AS K
				WHERE K.DURUM = 1 
					AND K.YETKI_ID = 3
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
		$this->sql = $sql;
		return $this;
	}
	
	public function CariTuru(){
		
		$filtre = array();
		$sql = "SELECT
					CT.CARI_TURU AS ID,
					CT.CARI_TANIM AS AD
				FROM CARI_TURU AS CT
				WHERE CT.DURUM = 1
				ORDER BY FIELD(CT.CARI_TURU, 'SATIM') DESC, 1
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
		$this->sql = $sql;
		return $this;
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
		
	}
	
	public function ParcaTipi($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			PT.ID,
        			PT.PARCA_TIPI AS AD
				FROM PARCA_TIPI AS PT
				WHERE 1
                ";
        if(in_array($arrRequest['parca_tipi_id'],array(1,2))){
			$sql.=" AND PT.ID IN(1,2)";
		}
		$sql.=" ORDER BY PT.SIRA";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
	public function Kategoriler($arrRequest = array()){
		$filtre = array();
		$sql = "SELECT
        			K.ID,
        			K.KATEGORI AS AD
				FROM KATEGORI AS K
				WHERE K.DURUM = 1
                ORDER BY 2
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$this->SetTemizle();
		$this->rows = $rows;
        $this->sql = $sql;
		return $this;
	}
	
}

	/*
	<?=$cCombo->Iller()->setSecilen($il_id)->setSeciniz()->getSelect("ID","AD")?>
	<?=$cCombo->Ilceler()->setSecilen($ilce_id)->setSeciniz()->getSelect("ID","AD")?>
	<?=$cCombo->Kategoriler()->setSecilen($kategoriler)->getSelect("ID","AD")?>
	<?=$cCombo->Durumlar()->setSecilen($durum)->getSelect("ID","AD")?>
	<?=$cCombo->Yetkiler()->setSecilen()->setSeciniz()->getSelect("ID","AD")?>
	<?=$cCombo->Surecler()->setSecilen()->getSelect("ID","AD")?>
	<?=$cCombo->SayfaBasina()->setSecilen()->getSelect("ID","AD")?>
	
	*/	
	