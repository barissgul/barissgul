<?

class subData {
	
	private $cdbPDO;
	private $cMail;
	
	function __construct($cdbPDO, $cMail, $cCurl) {
        $this->cdbPDO 	= $cdbPDO;
        $this->cMail 	= $cMail;
        $this->cCurl 	= $cCurl;
	}
	
	// $cSubData->fncIslemLog($ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "TABLE", "SAYFA");
	function fncIslemLog ($ID, $KAYIT_SQL, $ROW, $ISLEM, $TABLO, $SAYFA){
		//$SORGU 	= mysql_escape_string($KAYIT_SQL);
		$SORGU 	= trim(preg_replace('/\s\s+/', ' ', $KAYIT_SQL));
		$ROW_JSON = json_encode($ROW);
		
		$filtre = array();
		$sql = "INSERT INTO ISLEM_LOG SET 	TALEP_ID	= :TALEP_ID, 
											SAYFA		= :SAYFA, 
											TABLO		= :TABLO, 
											ISLEM		= :ISLEM, 
											KULLANICI	= :KULLANICI, 
											SORGU		= :SORGU, 	
											ROW			= :ROW_JSON
											";
		$filtre[":TALEP_ID"] 	= $ID;
		$filtre[":SAYFA"] 		= $SAYFA;
		$filtre[":TABLO"] 		= $TABLO;
		$filtre[":ISLEM"] 		= $ISLEM;
		$filtre[":KULLANICI"] 	= @$_SESSION['kullanici'];
		$filtre[":SORGU"] 		= $SORGU;
		$filtre[":ROW_JSON"] 	= $ROW_JSON;
		$this->cdbPDO->rowsCount($sql, $filtre);
		
	}
	
    private function setTemizle(){
        
    }
    
    public function getTedarikciListesi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			C.*,
        			T.URUN_SAYISI
				FROM CARI AS C
					LEFT JOIN (SELECT TEDARIKCI_ID, COUNT(*) AS URUN_SAYISI FROM YP_LISTE GROUP BY TEDARIKCI_ID) AS T ON T.TEDARIKCI_ID = C.ID
				WHERE C.DURUM = 1 AND C.CARI_TURU = 'ALIM'
				ORDER BY C.CARI
				";
				
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getOturumListe($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			*
				FROM FIRMA AS F
				WHERE F.DURUM = 1
				ORDER BY F.FIRMA
				";
				
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getFirmalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			F.*
				FROM FIRMA AS F
				WHERE F.DURUM = 1
				ORDER BY F.FIRMA
				";
				
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getAracDurumlar($arrRequest = array()){
    	
    	$filtre = array();
       	$sql = "SELECT 
					A.PLAKA AS ID,
					TI.ID AS IKAME_ID,
					TI.KOD AS IKAME_KOD,
					KI.ID AS KIRALAMA_ID,
					KI.KOD AS KIRALAMA_KOD,
					CASE 
						WHEN KI.ID > 0 THEN 'KIRALAMA'
						WHEN TI.ID > 0 THEN 'IKAME'
						ELSE 'BOS'
					END AS DURUM
				FROM ARAC AS A
					LEFT JOIN TALEP_IKAME AS TI ON TI.ARAC_ID = A.ID AND TI.SUREC_ID = 2
					LEFT JOIN KIRALAMA AS KI ON KI.ARAC_ID = A.ID AND KI.SUREC_ID = 2					
				WHERE A.DURUM = 1
				";
				
		$rows = $this->cdbPDO->rows($sql, $filtre);
		$rows = arrayIndex($rows);
		return $rows;
		
    }
    
    public function getAlisFatura($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.*
				FROM CARI_HAREKET AS CH
				WHERE CH.HAREKET_ID = 2 AND CH.ID = :ID
				LIMIT 1
				";
		$filtre[":ID"] = $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getEfaturaNatra($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.*,
        			CH.FATURA_NO AS ID
				FROM CARI_HAREKET AS CH
				WHERE CH.HAREKET_ID = 2 AND FIND_IN_SET(CH.FATURA_NO,:FATURA_NOLAR)
				";
		$filtre[":FATURA_NOLAR"] 	= $arrRequest['fatura_nolar'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		//var_dump2($rows);
		$rows = arrayIndex($rows);
		return $rows;
    }
    
    public function getEfaturaGelenIptal($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			EGI.*,
        			EGI.FATURA_NO AS ID
				FROM EFATURA_GELEN_IPTAL AS EGI
				WHERE FIND_IN_SET(EGI.FATURA_NO,:FATURA_NOLAR)
				";
		$filtre[":FATURA_NOLAR"] 	= $arrRequest['fatura_nolar'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		//var_dump2($rows);
		$rows = arrayIndex($rows);
		return $rows;
    }
    
    public function getSatisFatura($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.*
				FROM CARI_HAREKET AS CH
				WHERE CH.HAREKET_ID = 1 AND CH.ID = :ID
				LIMIT 1
				";
		$filtre[":ID"] = $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getSozlesme($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			S.*
				FROM SOZLESME AS S
				WHERE S.ID = :ID
				LIMIT 1
				";
		$filtre[":ID"] = $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
     public function getSozlesmeDetay($arrRequest = array()){
    	$filtre = array();
        $sql = "SELECT
        			SD.*,
        			A.SASI_NO,
        			MA.MARKA,
					MO.MODEL,
					V.VITES,
					Y.YAKIT,
					A.DURUM,
					R.RENK
				FROM SOZLESME_DETAY AS SD
					LEFT JOIN ARAC AS A ON A.PLAKA = SD.PLAKA
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN VITES AS V ON V.ID = A.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = A.YAKIT_ID
					LEFT JOIN RENK AS R ON R.ID = A.RENK_ID
				WHERE SD.SOZLESME_ID = :SOZLESME_ID
				";
		$filtre[":SOZLESME_ID"] = $arrRequest['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getVirman($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			V.*
				FROM VIRMAN AS V
				WHERE V.ID = :ID
				LIMIT 1
				";
		$filtre[":ID"] = $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getCariAktarmalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CA.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN
				FROM CARI_AKTARMA AS CA
					LEFT JOIN KULLANICI AS K ON K.ID = CA.KAYIT_YAPAN_ID
				WHERE 1
				ORDER BY TARIH DESC
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getTahsilat($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN
				FROM CARI_HAREKET AS CH
					LEFT JOIN KULLANICI AS K ON K.ID = CH.KAYIT_YAPAN_ID
				WHERE CH.HAREKET_ID = 3 AND CH.ID = :ID
				LIMIT 1
				";
		$filtre[":ID"] = $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getYedekParca($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			YP.*
				FROM YP_LISTE AS YP
				WHERE YP.UUID = :UUID
				LIMIT 1
				";
		$filtre[":UUID"] = $arrRequest['uuid'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getTediye($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN
				FROM CARI_HAREKET AS CH
					LEFT JOIN KULLANICI AS K ON K.ID = CH.KAYIT_YAPAN_ID
				WHERE CH.HAREKET_ID = 4 AND CH.ID = :ID
				LIMIT 1
				";
		$filtre[":ID"] = $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getSessionKullanici($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT('kullanici/', KR.RESIM_ADI) AS RESIM_URL,
        			Y.YETKI,
					K.*,
					CONCAT(K.AD, ' ', K.SOYAD) AS ADSOYAD,
					T.TEMA,
        			T.TEXT_COLOR,
        			T.ARKA_PLAN,
        			FB.FONT_BOYUT_CLASS,
        			C.CARI
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN TEMA AS T ON T.ID = K.TEMA_ID
					LEFT JOIN KULLANICI_RESIM AS KR ON KR.KULLANICI_ID = K.ID AND KR.DURUM = 1
					LEFT JOIN FONT_BOYUT AS FB ON FB.ID = K.FONT_BOYUT_ID
					LEFT JOIN CARI AS C ON C.ID = K.CARI_ID
				WHERE K.ID = :KULLANICI_ID
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
			
		$row = $this->cdbPDO->row($sql, $filtre);
		if(!$_SESSION['kullanici_id']){
			$row->RESIM_URL	= "kullanici_giremez.jpg";
		}
		
		return $row;
		
    }
    
    public function getProfil($arrRequest = array()){
		$filtre = array();
        $sql = "SELECT
        			Y.YETKI,
					CONCAT(K.AD, ' ', K.SOYAD) AS ADSOYAD,
					K.UNVAN,
					K.TEL,
					K.MAIL,
					K.CEPTEL,
					K.ADRES,
					K.KULLANICI
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
				WHERE K.ID = :KULLANICI_ID
				";
		$filtre[":KULLANICI_ID"] = $_REQUEST['id'];
			
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
	}
    
    public function getSessionCari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			C.KULLANICI_ID,
        			C.UNVAN,
        			C.IBAN,
        			C.ADRES,
        			C.VERGI_DAIRESI_ID
				FROM CARI AS C
				WHERE C.KULLANICI_ID = :KULLANICI_ID
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
			
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
   	
    public function getEvraklar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			E.*,
        			D.DURUM
				FROM EVRAK AS E
					LEFT JOIN DURUM AS D ON D.ID = E.DURUM
				WHERE 1
				ORDER BY E.ID
				";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getMarkalar($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                   M.ID,
                   M.MARKA,
                   M.RESIM_URL,
                   M.TSRB_MARKA_KODU,
                   D.DURUM
                FROM MARKA AS M
                	LEFT JOIN DURUM AS D ON D.ID = M.DURUM
                WHERE 1
                ORDER BY M.MARKA
                ";
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getModeller($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                   	MO.*,
                   	MA.MARKA,
                   	V.VITES,
                   	Y.YAKIT,
                   	D.DURUM
                FROM MODEL AS MO
                	LEFT JOIN DURUM AS D ON D.ID = MO.DURUM
                	LEFT JOIN MARKA AS MA ON MA.ID = MO.MARKA_ID
                	LEFT JOIN VITES AS V ON V.ID = MO.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = MO.YAKIT_ID
                WHERE 1
                
                ";
        if($arrRequest['marka_id']){
			$sql.= " AND MO.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $arrRequest["marka_id"];
		}
		$sql.= " ORDER BY MO.MODEL";
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getToplantilar($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                  	T.*,
                  	K.UNVAN AS KAYIT_EDEN
                FROM TOPLANTI AS T
                	LEFT JOIN KULLANICI AS K ON K.ID = T.KAYIT_EDEN_ID
                WHERE 1
                ORDER BY T.TOPLANTI_TARIH DESC
                ";
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getMusteriTemsilcileri($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                   	K.*,
                   	Y.YETKI
                FROM KULLANICI AS K
                	LEFT JOIN DURUM AS D ON D.ID = K.DURUM
                	LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
                WHERE K.YETKI_ID = 4
                ORDER BY K.UNVAN
                ";
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getServisZincirler($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                   	K.*,
                   	Y.YETKI,
                   	ST.SERVIS_TURU
                FROM KULLANICI AS K
                	LEFT JOIN DURUM AS D ON D.ID = K.DURUM
                	LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
                	LEFT JOIN SERVIS_TURU AS ST ON ST.ID = K.SERVIS_TURU
                WHERE K.YETKI_ID IN(20,21)
                ORDER BY K.UNVAN
                ";
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getBakimGruplari($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                   	BG.ID,
                   	BG.BAKIM_GRUP,
                   	BG.BAKIM_GRUP_ALTYAZI
                FROM BAKIM_GRUP AS BG
                WHERE 1
                ORDER BY 2
                ";
		
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getBakimPaketleri($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                   BP.*
                FROM BAKIM_PAKET AS BP
                WHERE BP.MODEL_ID = :MODEL_ID
                ORDER BY BP.KM
                ";
		$filtre[":MODEL_ID"] = $arrRequest["model_id"];		
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getModel($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                   MO.*,
                   MA.MARKA
                FROM MODEL AS MO
                	LEFT JOIN MARKA AS MA ON MA.ID = MO.MARKA_ID
                WHERE MO.ID = :ID
                ";
		$filtre[":ID"] = $arrRequest["id"];
        $row = $this->cdbPDO->row($sql, $filtre);
        
        return $row;
        
    }
    
    public function getHizmetTuru($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			H.*,
        			HMK.MUHASEBE_KODU,
        			HMK.MALI_KODU,
        			D.DURUM
				FROM HIZMET AS H
					LEFT JOIN DURUM AS D ON D.ID = H.DURUM
					LEFT JOIN HIZMET_MALI_KODU AS HMK ON HMK.ID = H.MALI_KODU_ID
				WHERE 1
				ORDER BY H.HIZMET
				";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariHizmetler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			H.*,
        			D.DURUM
				FROM HIZMET AS H
					LEFT JOIN DURUM AS D ON D.ID = H.DURUM
				WHERE H.DURUM = 1 AND H.TIP = 2
				ORDER BY H.HIZMET
				";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getMeslek($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			M.*,
        			D.DURUM
				FROM MESLEK AS M
					LEFT JOIN DURUM AS D ON D.ID = M.DURUM
				WHERE 1
				ORDER BY M.ID
				";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getOdemeKanallari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			OK.*,
        			D.DURUM
				FROM ODEME_KANALI AS OK
					LEFT JOIN DURUM AS D ON D.ID = OK.DURUM
				WHERE 1
				ORDER BY OK.ID
				";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getOdemeKanaliDetaylari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			OKD.*,
        			OK.ODEME_KANALI,
        			D.DURUM
				FROM ODEME_KANALI_DETAY AS OKD
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = OKD.ODEME_KANALI_ID
					LEFT JOIN DURUM AS D ON D.ID = OKD.DURUM
				WHERE 1
				ORDER BY OKD.SIRA ASC
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getKampanyalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.*,
        			D.DURUM
				FROM KAMPANYA AS K
					LEFT JOIN DURUM AS D ON D.ID = K.DURUM				
				WHERE 1
				ORDER BY K.ID
				";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
     
    public function getFiyat($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			F.*,
        			CONCAT_WS('_', F.BAS, F.BIT, F.GUN) AS ANAHTAR
				FROM FIYAT AS F
				WHERE DURUM = 1
				";
		if($arrRequest['opsiyon_id'] > 0){
			$sql.=" AND F.OPSIYON_ID = :OPSIYON_ID";
			$filtre[":OPSIYON_ID"]	= $arrRequest['opsiyon_id'];
		}
		
		if($arrRequest['gun'] > 0){
			$sql.=" AND F.GUN = :GUN";
			$filtre[":GUN"]	= $arrRequest['gun'];
		}
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows as $key => $row){
			$rows2[$row->ANAHTAR] = $row;
		}
		
		
		return $rows2;
    }
    
    public function getKullanici($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT('kullanici/', KR.RESIM_ADI) AS RESIM_URL,
        			Y.YETKI,
					K.*,
					C.CARI
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN KULLANICI_RESIM AS KR ON KR.KULLANICI_ID = K.ID AND KR.DURUM = 1
					LEFT JOIN CARI AS C ON C.ID = K.CARI_ID
				WHERE K.ID = :KULLANICI_ID
				";
		$filtre[":KULLANICI_ID"] = $_REQUEST['id'];
			
		$row = $this->cdbPDO->row($sql, $filtre);
		if(!$_SESSION['kullanici_id']){
			$row->RESIM_URL	= "kullanici_giremez.jpg";
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		return $row;
		
    }
    
    public function getUlkeler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			U.*
				FROM ULKE AS U
				WHERE 1
				";
		
		if($arrRequest['id']){
			$sql.=" AND U.ID = :ID";
			$filtre[":ID"] = $arrRequest['id'];	
		}
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getIller($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					IL.*,
					U.ULKE
				FROM IL AS IL
					LEFT JOIN ULKE AS U ON U.ID = IL.ULKE_ID
				WHERE 1 = 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
 	
 	public function getIlceler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					ILCE.*,
					IL.ULKE_ID,
					IL.IL,
					U.ULKE
				FROM ILCE AS ILCE
					LEFT JOIN IL AS IL ON IL.ID = ILCE.IL_ID
					LEFT JOIN ULKE AS U ON U.ID = IL.ULKE_ID
				WHERE 1 = 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getKullanicilarLog($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			L.ID,
        			L.KULLANICI,
        			L.SIFRE,
        			L.TARIH,
        			L.IP,
        			K.AD,
        			K.SOYAD,
        			Y.YETKI,
        			D.DURUM
        		FROM KULLANICI_LOG AS L
        			LEFT JOIN DURUM AS D ON D.ID = L.DURUM
        			LEFT JOIN KULLANICI AS K ON K.KULLANICI = L.KULLANICI
        			LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
        		WHERE 1
        		
				";
		if($arrRequest['kullanici']){
			$sql.=" AND K.KULLANICI LIKE :KULLANICI";
			$filtre[":KULLANICI"] = "%" . $arrRequest['kullanici'] . "%";
		}
		
		if($arrRequest['ad']){
			$sql.=" AND K.AD LIKE :AD";
			$filtre[":AD"] = "%" . $arrRequest['ad'] . "%";
		}
		
		if($arrRequest['soyad']){
			$sql.=" AND K.SOYAD LIKE :SOYAD";
			$filtre[":SOYAD"] = "%" . $arrRequest['soyad'] . "%";
		}
		
		if(in_array($arrRequest['durum'], array('0','1'))){
			$sql.=" AND K.DURUM = :DURUM";
			$filtre[":DURUM"] =  $arrRequest['durum'];
		}
		
		if($arrRequest['yetki'] > 0){
			$sql.=" AND K.YETKI_ID = :YETKI_ID";
			$filtre[":YETKI_ID"] = $arrRequest['yetki'];
		}
		
		$sql.=" ORDER BY L.TARIH DESC LIMIT 500";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getRenkler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			R.ID,
        			R.RENK,
        			R.RENK_KOD,
        			R.TARIH,
        			D.DURUM
				FROM RENK AS R
					LEFT JOIN DURUM AS D ON D.ID = R.DURUM
				WHERE 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getYetkiler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			Y.ID,
        			Y.YETKI,
        			Y.ACIKLAMA,
        			D.DURUM
				FROM YETKI AS Y
					LEFT JOIN DURUM AS D ON D.ID = Y.DURUM
				WHERE Y.ID NOT IN(1)
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getMenuler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			M.ID,
        			M.MENU,
        			M.LINK,
        			M.TITLE,
        			M.SIRA,
        			M.ROUTE,
        			M.YETKI_IDS,
        			(SELECT GROUP_CONCAT(Y.YETKI) AS SS FROM YETKI AS Y WHERE FIND_IN_SET(Y.ID, M.YETKI_IDS)) AS YETKIS,
        			D.DURUM
				FROM MENU AS M
					LEFT JOIN DURUM AS D ON D.ID = M.DURUM
				WHERE 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getMeslekler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			M.*
				FROM MESLEK AS M
				WHERE M.DURUM = 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getGorevler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			G.*
				FROM GOREV AS G
				WHERE G.DURUM = 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getBayraklar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			BA.ID,
        			BA.BAYRAK,
        			BA.ICON,
        			D.DURUM
				FROM BAYRAK AS BA
					LEFT JOIN DURUM AS D ON D.ID = BA.DURUM
				WHERE 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
	
	public function getBakimGrupModeller($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			BGM.*,
        			MA.MARKA,
        			MO.MODEL
				FROM BAKIM_GRUP_MODEL AS BGM
					LEFT JOIN MODEL AS MO ON MO.ID = BGM.MODEL_ID
					LEFT JOIN MARKA AS MA ON MA.ID = MO.MARKA_ID
				WHERE BGM.BAKIM_GRUP_ID = :ID
				";
		$filtre[":ID"]	 = $arrRequest["id"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
	
	public function getArac($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			A.*
				FROM ARAC AS A
				WHERE A.ID = :ID
				";
		$filtre[":ID"]	 = $arrRequest["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getCari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			C.*,
        			IL.IL,
        			U.ULKE
				FROM CARI AS C
					LEFT JOIN ULKE AS U ON U.ID = C.ULKE_ID
					LEFT JOIN IL AS IL ON IL.ID = IL_ID
				WHERE 1
				";
		if(strlen($arrRequest['kod'])> 3){
			$sql.= " AND C.KOD = :KOD";
			$filtre[":KOD"]	 = $arrRequest["kod"];
		} else {
			$sql.= " AND C.ID = :ID";
			$filtre[":ID"]	 = $arrRequest["id"];	
		}
		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getCariSiparisler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			C.*
				FROM CARI AS C
				WHERE C.ID = :ID
				";
		$filtre[":ID"]	 = $arrRequest["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getCariArabalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			T.ID,
        			T.PLAKA,
        			T.MODEL_YILI,
        			T.TARIH,
        			MA.MARKA,
        			MO.MODEL,
        			S.SUREC
				FROM TALEP AS T
					LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
				WHERE T.CARI_ID = :CARI_ID
				";
		$filtre[":CARI_ID"]	 = $arrRequest["id"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getVale($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.*
				FROM KULLANICI AS K
				WHERE K.YETKI_ID = 10
					AND K.ID = :ID
				";
		$filtre[":ID"]	 = $arrRequest["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$row->CALISMA_GUNSAAT = explode(',', $row->CALISMA_GUNSAAT);
		
		return $row;
    }
    
    public function getServis($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.*
				FROM KULLANICI AS K
				WHERE K.YETKI_ID = 11
					AND K.ID = :ID
				";
		$filtre[":ID"]	 = $arrRequest["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getServisZincir($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.*,
        			Y.YETKI
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
				WHERE K.YETKI_ID IN(20,21)
					AND K.ID = :ID
				";
		$filtre[":ID"]	 = $arrRequest["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getBakimGrup($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			BG.*
				FROM BAKIM_GRUP AS BG
				WHERE BG.ID = :ID
				";
		$filtre[":ID"]	 = $arrRequest["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getMuayeneIstasyonu($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			M.*
				FROM MUAYENE_ISTASYONU AS M
				WHERE M.ID = :ID
				";
		$filtre[":ID"]	 = $arrRequest["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
	public function getSayKullanici($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			MAX(ID) AS SAY,
        			K.YETKI_ID
				FROM KULLANICI AS K
				WHERE K.YETKI_ID = :YETKI_ID
				";
		$filtre[":YETKI_ID"] = $arrRequest['yetki_id'];	
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$row->KULLANICI	= "OK" . str_pad( $arrRequest['yetki_id'],2,"0",STR_PAD_LEFT) . str_pad($row->SAY+11,4,"0",STR_PAD_LEFT);
		$row->SIFRE		= fncSifreUret();
		$row->DISABLED	= "readonly";
		
		return $row;
    }
   
    public function getBaglamaUcretKayitsiz($arrRequest = array()){
    	
    	$M2 = str_replace(",",".",$arrRequest["en"]) * str_replace(",",".",$arrRequest["boy"]);
		if($M2 < 24) $M2 = 24;
		
    	$filtre = array();
        $sql = "SELECT * FROM FIYAT WHERE :M2 BETWEEN BAS AND BIT";
        $filtre[":M2"] = $M2;
		$rows_fiyat = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows_fiyat as $key => $row_fiyat){
			$arr_fiyat[$row_fiyat->GUN] = $row_fiyat;
		}
		
		$filtre = array();
        $sql = "SELECT
        			KA.*
				FROM KAMPANYA AS KA
				WHERE ID = :ID
				";
		$filtre[":ID"] = $arrRequest['kampanya_id'];
		$row_kampanya = $this->cdbPDO->row($sql, $filtre);
			
		$filtre = array();
		$sql = "SELECT DATEDIFF(:SOZLESME_BIT_TARIH, :SOZLESME_BAS_TARIH) AS GUN_SAYISI";
		$sozlesme_tarih = explode(",", $arrRequest['sozlesme_tarih']);
		$filtre[":SOZLESME_BAS_TARIH"] = trim(FormatTarih::tre2db(trim($sozlesme_tarih[0])));
		$filtre[":SOZLESME_BIT_TARIH"] = trim(FormatTarih::tre2db(trim($sozlesme_tarih[1])));
		$row_hesap = $this->cdbPDO->row($sql, $filtre);
		
		//var_dump2($row_hesap);
		
		$row->FIYAT_TABLO	= $rows_fiyat;
		$row->GUN_TOPLAM 	= $row_hesap->GUN_SAYISI;
		
		$GUN_SAYISI 	= $row_hesap->GUN_SAYISI - $_REQUEST['gunlukten'];
		$row->YIL		= intval($GUN_SAYISI / 365);
		$GUN_SAYISI		= $GUN_SAYISI - ($row->YIL * 365);
		$row->AY6		= intval($GUN_SAYISI / 182);
		$GUN_SAYISI		= $GUN_SAYISI - ($row->AY6 * 182);
		$row->AY3		= intval($GUN_SAYISI / 91);
		$GUN_SAYISI		= $GUN_SAYISI - ($row->AY3 * 91);
		$row->AY		= intval($GUN_SAYISI / 31);
		$GUN_SAYISI		= $GUN_SAYISI - ($row->AY * 31);
		$row->GUN 		= $GUN_SAYISI + $_REQUEST['gunlukten'];
		
		$ucret_sistem 	= $row->GUN * $arr_fiyat["1"]->KATSAYI + $row->AY * $arr_fiyat["31"]->KATSAYI + $row->AY3 * $arr_fiyat["91"]->KATSAYI + $row->AY6 * $arr_fiyat["182"]->KATSAYI + $row->YIL * $arr_fiyat["365"]->KATSAYI;
		$ucret_sistem	= $ucret_sistem * $M2 * (100 - $row_kampanya->ISKONTO) / 100;
		$row->UCRET_SISTEM	= FormatSayi::tamsayi($ucret_sistem);
		
		return $row;
    }
    
    public function getPuntolar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			B.PUNTO,
        			COUNT(*) AS TOPLAM
				FROM BAGLAMA AS B
				WHERE 1
				GROUP BY B.PUNTO
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getSiralar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			B.ID,
        			B.PUNTO,
        			B.SIRA,
        			B.BAGLAMA
				FROM BAGLAMA AS B
				WHERE 1
				ORDER BY B.PUNTO, B.SIRA
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
   
    public function getKargoFirmalari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			KF.ID,
        			KF.KARGO_FIRMASI,
        			KF.TARIH,
        			KF.SIRA,
        			D.DURUM
				FROM KARGO_FIRMASI AS KF
					LEFT JOIN DURUM AS D ON D.ID = KF.DURUM
				WHERE 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getBankalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			B.ID,
        			B.BANKA,
        			B.MALI_KODU_ID,
        			B.SIRA,
        			D.DURUM
				FROM BANKA AS B
					LEFT JOIN DURUM AS D ON D.ID = B.DURUM
				WHERE 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getEntegrasyonFaturalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			F.*
				FROM FATURA AS F
				WHERE F.ENTEGRASYON = 0
				LIMIT 1
				";
		if($arrRequest["id"] > 0){
			$sql.=" AND F.ID = :ID";
			$filtre[":ID"]	 = $arrRequest["id"];
		}
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getEntegrasyonOdemeler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			O.*
				FROM ODEME AS O
				WHERE O.ENTEGRASYON = 0
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getFaturaEntegrasyon($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			E.*
				FROM ENTEGRASYON AS E
				WHERE E.TIP_ID = 1 
					AND E.NO_ID = :FATURA_ID
				ORDER BY E.TARIH DESC
				";
		$filtre[":FATURA_ID"]	= $arrRequest['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getOdemeEntegrasyon($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			E.*
				FROM ENTEGRASYON AS E
				WHERE E.TIP_ID = 2
					AND E.NO_ID = :ODEME_ID
				ORDER BY E.TARIH DESC
				";
		$filtre[":ODEME_ID"]	= $arrRequest['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getSite($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT_WS('_', S.IL_ID, S.ILCE_ID) AS ILILCE_ID,
        			S.*
				FROM SITE AS S
				WHERE 1
				LIMIT 1
				";
		$row = $this->cdbPDO->row($sql, $filtre);
		
		//$row->BANNER 	= "";
		$row->BANNER_W	= 800;
		$row->BANNER_H	= 350;
		return $row;
		
    }
    
    public function getUrunSayisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			COUNT(*) AS SAY
				FROM YP_LISTE AS YP
				";
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getMenu($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			M.*
				FROM MENU AS M
				WHERE FIND_IN_SET(:YETKI_ID, M.YETKI_IDS)
					AND M.DURUM = 1
				ORDER BY M.SIRA
				";
		$filtre[":YETKI_ID"]	= $_SESSION['yetki_id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows as $key => $row){
			$d = explode('/', $row->ROUTE);
			if(strpos($row->LINK, '?') === false)	$row->LINK.= "?route=" . $row->ROUTE; 
			else 									$row->LINK.= "&route=" . $row->ROUTE; 	
			
			$rows2[$d[0]][]	= $row;
		}
		
		
		return $rows2;
		
    }
    
    public function getAnaMenu($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			A.*
				FROM ANAMENU AS A
				WHERE A.DURUM = 1
				ORDER BY A.SIRA
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getLinklerim($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			L.*
				FROM LINK AS L
				WHERE L.DURUM = 1
				ORDER BY L.LINK_ADI
				";
		// AND L.EKLEYEN_ID = :EKLEYEN_ID $filtre[":EKLEYEN_ID"]	= $_SESSION['kullanici_id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getSiteLogo($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			SR.*
				FROM SITE_RESIM AS SR
				WHERE DURUM = 1
				ORDER BY TARIH DESC
				LIMIT 1
				";
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getSehreGoreIhaleSayisi(){
    	
    	$filtre = array();
	    $sql = "SELECT
	    			COUNT(I.ID) AS SAYI,
	    			I.SERVIS_IL_ID AS PLAKA
				FROM IHALE AS I
				WHERE I.SUREC_ID = 3
				";
				
		fncSqlYetki($sql, $filtre);
		
		$sql.=" GROUP BY SERVIS_IL_ID";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
	}
	
	public function getSayiIhale(){
		if(in_array($_SESSION['yetki_id'], array(1,2,3))){
			
			$filtre = array();
			$sql = "SELECT 	(SELECT COUNT(*) FROM IHALE_FAVORI WHERE KULLANICI_ID = :KULLANICI_ID AND IHALE_ID IN (SELECT ID FROM IHALE WHERE SUREC_ID = 3)) AS FAVORI_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID=I.ID WHERE IC.CEVAPLAYAN_ID = :KULLANICI_ID AND I.SUREC_ID = 3) AS TEKLIFLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BAS_TARIH) = CURDATE() AND SUREC_ID = 3) AS BUGUN_BASLAYANLAR_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BIT_TARIH) = CURDATE() AND SUREC_ID = 3) AS BUGUN_BITECEKLER_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BIT_TARIH) = ADDDATE(CURDATE(), INTERVAL +1 DAY) AND SUREC_ID = 3) AS YARIN_BITECEKLER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_INCELE AS II ON II.IHALE_ID = I.ID WHERE II.INCELEYEN_ID = :KULLANICI_ID AND I.SUREC_ID = 3) AS INCELEDIKLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 3) AS TUM_IHALELER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 4) AS BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I WHERE DATE(I.IHALE_BIT_TARIH) = CURDATE() AND I.SUREC_ID = 5) AS BUGUN_BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 5) AS FIRMADAN_SONUC_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 6) AS FIRMADAN_RED_ALANLAR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 7) AS MUTABAKAT_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 8) AS ARAC_SAHIBINDEN_EVRAK_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 9) AS MUSAVIRLIK_ISLEMLERI_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 11) AS ODEME_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 12) AS NOTER_SATISI_BEKLIYOR
						";
			$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
			$row = $this->cdbPDO->row($sql, $filtre);
			
		} else 	if(in_array($_SESSION['yetki_id'], array(4,5))){
			
			$filtre = array();
			$sql = "SELECT 	(SELECT COUNT(*) FROM IHALE_FAVORI WHERE KULLANICI_ID = :KULLANICI_ID AND IHALE_ID IN (SELECT ID FROM IHALE WHERE SUREC_ID = 3)) AS FAVORI_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID=I.ID WHERE IC.CEVAPLAYAN_ID = :KULLANICI_ID AND I.SUREC_ID = 3) AS TEKLIFLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BAS_TARIH) = CURDATE() AND SUREC_ID = 3 AND FIRMA_ID = :FIRMA_ID) AS BUGUN_BASLAYANLAR_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BIT_TARIH) = CURDATE() AND SUREC_ID = 3 AND FIRMA_ID = :FIRMA_ID) AS BUGUN_BITECEKLER_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BIT_TARIH) = ADDDATE(CURDATE(), INTERVAL +1 DAY) AND SUREC_ID = 3) AS YARIN_BITECEKLER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_INCELE AS II ON II.IHALE_ID = I.ID WHERE II.INCELEYEN_ID = :KULLANICI_ID AND I.SUREC_ID=3) AS INCELEDIKLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 3 AND FIRMA_ID = :FIRMA_ID) AS TUM_IHALELER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 4 AND I.FIRMA_ID =:FIRMA_ID) AS BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I WHERE DATE(I.IHALE_BIT_TARIH) = CURDATE() AND I.SUREC_ID = 5) AS BUGUN_BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 5 AND I.FIRMA_ID =:FIRMA_ID) AS FIRMADAN_SONUC_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 7 AND I.FIRMA_ID =:FIRMA_ID) AS MUTABAKAT_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 8 AND I.FIRMA_ID =:FIRMA_ID) AS ARAC_SAHIBINDEN_EVRAK_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 9 AND I.FIRMA_ID =:FIRMA_ID) AS MUSAVIRLIK_ISLEMLERI_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 11 AND I.FIRMA_ID =:FIRMA_ID) AS ODEME_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 12 AND I.FIRMA_ID =:FIRMA_ID) AS NOTER_SATISI_BEKLIYOR
						";
			$filtre[":FIRMA_ID"] 		= $_SESSION['firma_id'];
			$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
			$row = $this->cdbPDO->row($sql, $filtre);
			
		} else if($_SESSION['yetki_id'] == 6){
			
			$filtre = array();
			$sql = "SELECT 	(SELECT COUNT(*) FROM IHALE_FAVORI WHERE KULLANICI_ID = :KULLANICI_ID AND IHALE_ID IN (SELECT ID FROM IHALE WHERE SUREC_ID = 3)) AS FAVORI_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID=I.ID WHERE IC.CEVAPLAYAN_ID = :KULLANICI_ID AND I.SUREC_ID = 3) AS TEKLIFLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BAS_TARIH) = CURDATE() AND SUREC_ID = 3 AND (IHALE_METODU_ID = 1 OR IHALE_METODU_ID = 2)) AS BUGUN_BASLAYANLAR_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BIT_TARIH) = CURDATE() AND SUREC_ID = 3 AND (IHALE_METODU_ID = 1 OR IHALE_METODU_ID = 2)) AS BUGUN_BITECEKLER_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BIT_TARIH) = ADDDATE(CURDATE(), INTERVAL +1 DAY) AND SUREC_ID = 3 AND (IHALE_METODU_ID = 1 OR IHALE_METODU_ID = 2)) AS YARIN_BITECEKLER_SAY,							
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_INCELE AS II ON II.IHALE_ID = I.ID WHERE II.INCELEYEN_ID = :KULLANICI_ID AND I.SUREC_ID=3) AS INCELEDIKLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 3 AND (IHALE_METODU_ID = 1 OR IHALE_METODU_ID = 2)) AS TUM_IHALELER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 4 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 5 AND DATE(I.IHALE_BIT_TARIH) = CURDATE() AND IC.ENB = 1 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS BUGUN_BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 5 AND IC.ENB = 1 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS FIRMADAN_SONUC_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 7 AND IK.KAZANAN_ID =:KULLANICI_ID) AS MUTABAKAT_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 8 AND IK.KAZANAN_ID =:KULLANICI_ID) AS ARAC_SAHIBINDEN_EVRAK_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 9 AND IK.KAZANAN_ID =:KULLANICI_ID) AS MUSAVIRLIK_ISLEMLERI_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 11 AND IK.KAZANAN_ID =:KULLANICI_ID) AS ODEME_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 12 AND IK.KAZANAN_ID =:KULLANICI_ID) AS NOTER_SATISI_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 15 AND IK.KAZANAN_ID =:KULLANICI_ID) AS KAZANDIKLARIM,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 6 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS FIRMADAN_RED_ALANLAR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 15 AND IK.IKINCI_KAZANAN_ID =:KULLANICI_ID) AS IKINCI_OLDUKLARIM,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = IC.IHALE_ID WHERE I.SUREC_ID = 15 AND IK.KAZANAN_ID != :KULLANICI_ID AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS KAYBEDILENLER
						";
			$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
			$row = $this->cdbPDO->row($sql, $filtre);
		
		} else if($_SESSION['yetki_id'] == 7){
			
			$filtre = array();
			$sql = "SELECT 	(SELECT COUNT(*) FROM IHALE_FAVORI WHERE KULLANICI_ID = :KULLANICI_ID AND IHALE_ID IN (SELECT ID FROM IHALE WHERE SUREC_ID = 3)) AS FAVORI_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID=I.ID WHERE IC.CEVAPLAYAN_ID = :KULLANICI_ID AND I.SUREC_ID = 3) AS TEKLIFLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BAS_TARIH) = CURDATE() AND SUREC_ID = 3 AND (IHALE_METODU_ID = 1 OR IHALE_METODU_ID = 3)) AS BUGUN_BASLAYANLAR_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BIT_TARIH) = CURDATE() AND SUREC_ID = 3 AND (IHALE_METODU_ID = 1 OR IHALE_METODU_ID = 3)) AS BUGUN_BITECEKLER_SAY,
							(SELECT COUNT(*) FROM IHALE WHERE DATE(IHALE_BIT_TARIH) = ADDDATE(CURDATE(), INTERVAL +1 DAY) AND SUREC_ID = 3 AND (IHALE_METODU_ID = 1 OR IHALE_METODU_ID = 3)) AS YARIN_BITECEKLER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_INCELE AS II ON II.IHALE_ID = I.ID WHERE II.INCELEYEN_ID = :KULLANICI_ID AND I.SUREC_ID=3) AS INCELEDIKLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 3 AND (IHALE_METODU_ID = 1 OR IHALE_METODU_ID = 3)) AS TUM_IHALELER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 4 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 5 AND DATE(I.IHALE_BIT_TARIH) = CURDATE() AND IC.ENB = 1 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS BUGUN_BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 5 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS FIRMADAN_SONUC_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 7 AND IK.KAZANAN_ID =:KULLANICI_ID) AS MUTABAKAT_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 8 AND IK.KAZANAN_ID =:KULLANICI_ID) AS ARAC_SAHIBINDEN_EVRAK_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 9 AND IK.KAZANAN_ID =:KULLANICI_ID) AS MUSAVIRLIK_ISLEMLERI_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 11 AND IK.KAZANAN_ID =:KULLANICI_ID) AS ODEME_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 12 AND IK.KAZANAN_ID =:KULLANICI_ID) AS NOTER_SATISI_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 15 AND IK.KAZANAN_ID =:KULLANICI_ID) AS KAZANDIKLARIM,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 15 AND IK.IKINCI_KAZANAN_ID =:KULLANICI_ID) AS IKINCI_OLDUKLARIM,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = IC.IHALE_ID WHERE I.SUREC_ID = 15 AND IK.KAZANAN_ID != :KULLANICI_ID AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS KAYBEDILENLER
						";
			$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
			$row = $this->cdbPDO->row($sql, $filtre);
			
		} else if($_SESSION['yetki_id'] == 10){
			$filtre = array();
			$sql = "SELECT 	(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_FAVORI AS IFA ON IFA.IHALE_ID = I.ID WHERE IFA.KULLANICI_ID = :KULLANICI_ID AND I.SUREC_ID = 3) AS FAVORI_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE IC.CEVAPLAYAN_ID = :KULLANICI_ID AND I.SUREC_ID = 3) AS TEKLIFLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE DATE(I.IHALE_BAS_TARIH) = CURDATE() AND I.SUREC_ID = 3 AND (I.IHALE_METODU_ID = 1 OR I.IHALE_METODU_ID = 2)) AS BUGUN_BASLAYANLAR_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE DATE(I.IHALE_BIT_TARIH) = CURDATE() AND I.SUREC_ID = 3 AND (I.IHALE_METODU_ID = 1 OR I.IHALE_METODU_ID = 2)) AS BUGUN_BITECEKLER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE DATE(I.IHALE_BIT_TARIH) = ADDDATE(CURDATE(), INTERVAL +1 DAY) AND I.SUREC_ID = 3 AND (I.IHALE_METODU_ID = 1 OR I.IHALE_METODU_ID = 2)) AS YARIN_BITECEKLER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_INCELE AS II ON II.IHALE_ID = I.ID WHERE II.INCELEYEN_ID = :KULLANICI_ID AND I.SUREC_ID=3) AS INCELEDIKLERIM_SAY,
							(SELECT COUNT(*) FROM IHALE AS I WHERE I.SUREC_ID = 3 AND (IHALE_METODU_ID = 1 OR IHALE_METODU_ID = 2)) AS TUM_IHALELER_SAY,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 4 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 5 AND DATE(I.IHALE_BIT_TARIH) = CURDATE() AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS BITEN_IHALELER,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 5 AND IC.ENB = 1 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS FIRMADAN_SONUC_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 7 AND IK.KAZANAN_ID =:KULLANICI_ID) AS MUTABAKAT_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 8 AND IK.KAZANAN_ID =:KULLANICI_ID) AS ARAC_SAHIBINDEN_EVRAK_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 9 AND IK.KAZANAN_ID =:KULLANICI_ID) AS MUSAVIRLIK_ISLEMLERI_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 11 AND IK.KAZANAN_ID =:KULLANICI_ID) AS ODEME_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 12 AND IK.KAZANAN_ID =:KULLANICI_ID) AS NOTER_SATISI_BEKLIYOR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 15 AND IK.KAZANAN_ID =:KULLANICI_ID) AS KAZANDIKLARIM,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID WHERE I.SUREC_ID = 6 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS FIRMADAN_RED_ALANLAR,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID WHERE I.SUREC_ID = 15 AND IK.IKINCI_KAZANAN_ID =:KULLANICI_ID) AS IKINCI_OLDUKLARIM,
							(SELECT COUNT(*) FROM IHALE AS I LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = IC.IHALE_ID AND IK.KAZANAN_ID != :KULLANICI_ID WHERE I.SUREC_ID = 15 AND IC.CEVAPLAYAN_ID =:KULLANICI_ID) AS KAYBEDILENLER
						";
			$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
			$row = $this->cdbPDO->row($sql, $filtre);
		}
		
		
		return $row;
		
	}
    
    public function getIhale($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			ADL.*
				FROM IHALE AS I
					LEFT JOIN MARKA AS MA ON MA.ID = I.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = I.MODEL_ID
					LEFT JOIN ARAC_DEGER_LISTESI AS ADL ON ADL.AB_MARKA_KODU = MA.AB_MARKA_KODU AND ADL.AB_TIP_KODU = MO.AB_TIP_KODU		
				WHERE I.ID = :ID
				";
		$filtre[":ID"] 				= $arrRequest['id'];
		$row_ihale = $this->cdbPDO->row($sql, $filtre);
		// DATE_FORMAT(DATE_ADD(I.IHALE_BIT_TARIH, INTERVAL -3 MINUTE), '%Y/%m/%d %H:%i:%s') AS KALAN_SURE_TARIH,
    	$filtre = array();
        $sql = "SELECT
        			I.*,
        			MA.MARKA,
        			MO.MODEL,
        			CONCAT_WS(' ', KK.AD, KK.SOYAD) AS KAYIT_YAPAN,
        			KK.YETKI_ID AS KAYIT_YAPAN_YETKI_ID,
        			V.VITES,
        			Y.YAKIT,
        			ST.SIGORTA_TURU,
        			KT.KULLANIM_TURU,
        			HS.HASAR_SEKLI,
        			CASE 
        				WHEN I.SIGORTA_FILO_ID = 1 THEN SI.SIGORTA
        				WHEN I.SIGORTA_FILO_ID = 2 THEN F.FILO
        			END AS FIRMA,
        			DATE_FORMAT(I.IHALE_BIT_TARIH, '%Y/%m/%d %H:%i:%s') AS KALAN_SURE_TARIH,
        			IFA.IHALE_ID AS FAVORI,
        			ISO.SORUMLU_ID,
        			ISO.KONTROL_ONAY,
        			ISO.KONTROL_GELIS_TARIH,
        			ISO.KONTROL_ONAY_TARIH,
        			ISO.ATAMA_TARIHI,
        			CONCAT_WS(' ', KS.AD, KS.SOYAD) AS SORUMLU,
        			CONCAT_WS(' ', KIK.AD, KIK.SOYAD) AS KAZANAN,
        			KIK.YETKI_ID AS KAZANAN_YETKI_ID,
        			KS.CEPTEL AS SORUMLU_CEPTEL,
        			KIK.TCK_VKN AS KAZANAN_TCK,
					IK.KAZANAN_SOVTAJ,
					IK.KAZANAN_ID,
        			IC.SOVTAJ,
        			S.SUREC,
        			IM.IHALE_METODU,
        			ISE.IHALE_SEKLI,
        			SD.SERVIS_DURUMU,
        			STU.SERVIS_TURU,
        			IL.IL AS SERVIS_IL,
        			CONCAT_WS('/', '', 'img', 'ihale', YEAR(I.TARIH), I.IHALE_NO, IR.RESIM_ADI) AS RESIM_URL,
        			ILCE.ILCE AS SERVIS_ILCE,
        			IF(CONCAT(DATE(I.IHALE_BIT_TARIH), ' 18:00:00') < NOW(), 1, 0) AS IHALE_BITTI_GOSTER
				FROM IHALE AS I
					LEFT JOIN MARKA AS MA ON MA.ID = I.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = I.MODEL_ID
					LEFT JOIN ARAC_DEGER_LISTESI AS ADL ON ADL.AB_MARKA_KODU = MA.AB_MARKA_KODU AND ADL.AB_TIP_KODU = MO.AB_TIP_KODU
					LEFT JOIN KULLANICI AS KK ON KK.ID = I.KAYIT_YAPAN_ID
					LEFT JOIN VITES AS V ON V.ID = I.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = I.YAKIT_ID
					LEFT JOIN SIGORTA_TURU AS ST ON ST.ID = I.SIGORTA_TURU_ID
					LEFT JOIN KULLANIM_TURU AS KT ON KT.ID = I.KULLANIM_TURU_ID
					LEFT JOIN HASAR_SEKLI AS HS ON HS.ID = I.HASAR_SEKLI_ID
					LEFT JOIN SIGORTA AS SI ON SI.ID = I.FIRMA_ID
					LEFT JOIN FILO AS F ON F.ID = I.FIRMA_ID
					LEFT JOIN IHALE_FAVORI AS IFA ON IFA.IHALE_ID = I.ID AND IFA.KULLANICI_ID = :KULLANICI_ID
					LEFT JOIN IHALE_SORUMLUSU AS ISO ON ISO.IHALE_ID = I.ID
					LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID
					LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID AND IC.CEVAPLAYAN_ID = :KULLANICI_ID
					LEFT JOIN KULLANICI AS KIK ON KIK.ID = IK.KAZANAN_ID
					LEFT JOIN KULLANICI AS KS ON KS.ID = ISO.SORUMLU_ID
					LEFT JOIN SUREC AS S ON S.ID = I.SUREC_ID
					LEFT JOIN IHALE_RESIM AS IR ON IR.IHALE_ID = I.ID AND IR.SIRA = 1
					LEFT JOIN IHALE_METODU AS IM ON IM.ID = I.IHALE_METODU_ID
					LEFT JOIN IHALE_SEKLI AS ISE ON ISE.ID = I.IHALE_SEKLI_ID
					LEFT JOIN SERVIS_DURUMU AS SD ON SD.ID = I.SERVIS_DURUMU_ID
					LEFT JOIN SERVIS_TURU AS STU ON STU.ID = I.SERVIS_TURU_ID
					LEFT JOIN IL AS IL ON IL.ID = I.SERVIS_IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = I.SERVIS_ILCE_ID
					LEFT JOIN FIRMA_RED_NEDENI AS FRN ON FRN.ID = I.FIRMA_RED_NEDENI_ID
				WHERE I.ID = :ID
				";
		$filtre[":ID"] 				= $arrRequest['id'];
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if($row->MODEL_YILI > 2003){
        	$row->KASKO_DEGERI = $row_ihale->{"Y".$row->MODEL_YILI};
		}
		
		$filtre = array();
		$sql = "SELECT I.ID, I.KOD FROM IHALE AS I WHERE I.ID < :ID AND I.SUREC_ID = :SUREC_ID";
		$filtre[":ID"] 			= $arrRequest['id'];
		$filtre[":SUREC_ID"] 	= $row->SUREC_ID;
		fncSqlYetki($sql, $filtre);
		$sql.=" ORDER BY I.ID DESC LIMIT 1";
		$row_min = $this->cdbPDO->row($sql, $filtre);
		$row->ONCEKI_IHALE_ID 	= $row_min->ID;
		$row->ONCEKI_IHALE_KOD 	= $row_min->KOD;
		
		$filtre = array();
		$sql = "SELECT I.ID, I.KOD FROM IHALE AS I WHERE I.ID > :ID AND I.SUREC_ID = :SUREC_ID";
		$filtre[":ID"] 			= $arrRequest['id'];
		$filtre[":SUREC_ID"] 	= $row->SUREC_ID;
		fncSqlYetki($sql, $filtre);
		$sql.=" ORDER BY I.ID ASC LIMIT 1";
		$row_max = $this->cdbPDO->row($sql, $filtre);
		$row->SONRAKI_IHALE_ID 	= $row_max->ID;
		$row->SONRAKI_IHALE_KOD = $row_max->KOD;
		
		return $row;
    }
    
    public function getHaber($arrRequest = array()){		
    	
    	$filtre = array();
        $sql = "SELECT * FROM HABER WHERE ID = :ID";
		$filtre[":ID"] 				= $arrRequest['haber_id'];
		$row = $this->cdbPDO->row($sql, $filtre);
				
		return $row;
    }
    
    public function getHaberler($arrRequest = array()){		
    	
    	$filtre = array();
        $sql = "SELECT * FROM HABER ORDER BY ID DESC";
		$rows = $this->cdbPDO->rows($sql, $filtre);
				
		return $rows;
    }
    
    public function getIhaleBenzer($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			I.ID,
        			I.KOD,
        			I.KM,
        			I.IHALE_NO,
        			I.SUREC_ID,
        			I.IHALE_BIT_TARIH,
        			MA.MARKA,
        			MO.MODEL,
        			I.MODEL_YILI,
        			IC.SOVTAJ,
        			V.VITES,
        			Y.YAKIT
				FROM IHALE_BENZER AS IB
					LEFT JOIN IHALE AS I ON I.ID = IB.IHALE_BENZER_ID 
					LEFT JOIN MARKA AS MA ON MA.ID = I.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = I.MODEL_ID
					LEFT JOIN VITES AS V ON V.ID = I.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = I.YAKIT_ID
					LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID AND IC.ENB = 1
				WHERE IB.IHALE_ID = :IHALE_ID
				ORDER BY I.MODEL_YILI DESC, IC.SOVTAJ DESC
				";
		$filtre[":IHALE_ID"] 	= $arrRequest['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getSon10Teklif($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			IC.SOVTAJ,
        			IC.ENB AS SOVTAJ_SIRA,
        			IC.TARIH AS SOVTAJ_TARIH,
        			I.ID,
        			I.KOD,
        			I.KM,
        			I.IHALE_NO,
        			I.IHALE_BIT_TARIH,
        			MA.MARKA,
        			MO.MODEL,
        			I.MODEL_YILI,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS TEKLIF_VEREN
				FROM IHALE_CEVAP AS IC  
					LEFT JOIN IHALE AS I ON I.ID = IC.IHALE_ID 
					LEFT JOIN MARKA AS MA ON MA.ID = I.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = I.MODEL_ID
					LEFT JOIN KULLANICI AS K ON K.ID = IC.CEVAPLAYAN_ID
				WHERE DATE_ADD(NOW(), INTERVAL -1 MONTH) > IC.TARIH
				ORDER BY IC.TARIH DESC
				LIMIT 10
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getSon10Incele($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			II.SON_GIRIS_TARIH,
        			II.SAY,
        			I.ID,
        			I.KOD,
        			I.KM,
        			I.IHALE_NO,
        			I.IHALE_BIT_TARIH,
        			MA.MARKA,
        			MO.MODEL,
        			I.MODEL_YILI,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS TEKLIF_VEREN,
        			IF(CONCAT(DATE(I.IHALE_BIT_TARIH), ' 18:00:00') < NOW(), 1, 0) AS IHALE_BITTI_GOSTER,
        			IC.SOVTAJ
				FROM IHALE_INCELE AS II  
					LEFT JOIN IHALE AS I ON I.ID = II.IHALE_ID 
					LEFT JOIN MARKA AS MA ON MA.ID = I.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = I.MODEL_ID
					LEFT JOIN KULLANICI AS K ON K.ID = II.INCELEYEN_ID
					LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = II.IHALE_ID AND IC.CEVAPLAYAN_ID = II.INCELEYEN_ID
				WHERE DATE_ADD(NOW(), INTERVAL -1 MONTH) > II.SON_GIRIS_TARIH
				ORDER BY II.SON_GIRIS_TARIH DESC
				LIMIT 30
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getSon10Teklifim($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			IC.SOVTAJ,
        			IC.ENB AS SOVTAJ_SIRA,
        			IC.TARIH AS SOVTAJ_TARIH,
        			I.ID,
        			I.KOD,
        			I.KM,
        			I.IHALE_NO,
        			I.IHALE_BIT_TARIH,
        			MA.MARKA,
        			MO.MODEL,
        			I.MODEL_YILI
				FROM IHALE_CEVAP AS IC  
					LEFT JOIN IHALE AS I ON I.ID = IC.IHALE_ID 
					LEFT JOIN MARKA AS MA ON MA.ID = I.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = I.MODEL_ID
				WHERE DATE_ADD(NOW(), INTERVAL -1 MONTH) > IC.TARIH
				ORDER BY IC.TARIH DESC
				LIMIT 10
				";
		$filtre[":IHALE_ID"] 		= $arrRequest['id'];
		$filtre[":CEVAPLAYAN_ID"] 	= $_SESSION['kullanici_id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getIhaleTeklifler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			IC.*,
        			CONCAT_WS(' ', KIC.AD, KIC.SOYAD) AS TEKLIF_VEREN,
        			KIC.AD,
        			KIC.SOYAD,
        			KIC.CEPTEL,
        			KIC.PERT_YONETICI_ID,
				    IK.KAZANAN_ID,
					IK.KAZANAN_SOVTAJ
				FROM IHALE_CEVAP AS IC
					LEFT JOIN KULLANICI AS KIC ON KIC.ID = IC.CEVAPLAYAN_ID
					LEFT JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = IC.IHALE_ID AND IK.KAZANAN_ID = IC.CEVAPLAYAN_ID
				WHERE IC.IHALE_ID = :ID
				ORDER BY IC.SOVTAJ DESC
				";
		$filtre[":ID"] 			= $arrRequest['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getIhalePertTeklifler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			IC.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS TEKLIF_VEREN
				FROM IHALE_CEVAP AS IC
					LEFT JOIN KULLANICI AS K ON K.ID = IC.CEVAPLAYAN_ID
				WHERE IC.IHALE_ID = :ID AND K.YETKI_ID = 6
				ORDER BY IC.SOVTAJ DESC
				";
		$filtre[":ID"] 			= $arrRequest['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getIhaleOnarimTeklifler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			IC.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS TEKLIF_VEREN
				FROM IHALE_CEVAP AS IC
					LEFT JOIN KULLANICI AS K ON K.ID = IC.CEVAPLAYAN_ID
				WHERE IC.IHALE_ID = :ID AND K.YETKI_ID = 7
				ORDER BY IC.SOVTAJ
				";
		$filtre[":ID"] 			= $arrRequest['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getIhaleKazanan($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			IK.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS TEKLIF_VEREN,
        			K.YETKI_ID
				FROM IHALE_KAZANAN AS IK
					LEFT JOIN KULLANICI AS K ON K.ID = IK.KAZANAN_ID
				WHERE IK.IHALE_ID = :ID
				";
		$filtre[":ID"] 			= $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getPertciler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.ID,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS ADSOYAD,
        			Y.YETKI
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
				WHERE K.YETKI_ID = 6
				ORDER BY 2 DESC
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getPertcilerMesajAtan($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.ID,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS ADSOYAD,
        			Y.YETKI,
        			Y.ID AS YETKI_ID
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN IHALE_MESAJ AS IM ON IM.KIMDEN_ID = K.ID
				WHERE IM.IHALE_ID = :ID
				ORDER BY 2 DESC
				";
		$filtre[":ID"] 		= $arrRequest['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getIhaleCevap($arrRequest = array()){
    	
    	if($_SESSION['yetki_id'] == 1){
			$filtre	= array();
			$sql = "SELECT
						IC.ID AS IC_ID,
						IC.SOVTAJ AS SOVTAJ,
						IC.TARIH AS IC_TARIH,
						IC.ACIKLAMA AS IC_ACIKLAMA,
						K.ID AS K_ID,
						K.AD AS K_AD,
						K.SOYAD AS K_SOYAD
					FROM IHALE_CEVAP AS IC
						LEFT JOIN KULLANICI AS K ON K.ID = IC.CEVAPLAYAN_ID
					WHERE IC.IHALE_ID = :IHALE_ID
					ORDER BY IC.TARIH";
			$filtre[":IHALE_ID"] 		= $arrRequest['id'];
			$rows = $this->cdbPDO->rows($sql, $filtre);
		}else{
			$filtre	= array();
			$sql = "SELECT
						IC.ID AS IC_ID,
						IC.SOVTAJ AS SOVTAJ,
						IC.TARIH AS IC_TARIH,
						IC.ACIKLAMA AS IC_ACIKLAMA,
						K.ID AS K_ID,
						K.AD AS K_AD,
						K.SOYAD AS K_SOYAD
					FROM IHALE_CEVAP AS IC
						LEFT JOIN KULLANICI AS K ON K.ID = IC.CEVAPLAYAN_ID
					WHERE IC.IHALE_ID = :IHALE_ID AND IC.CEVAPLAYAN_ID = :CEVAPLAYAN_ID";
			$filtre[":IHALE_ID"] 		= $arrRequest['id'];
			$filtre[":CEVAPLAYAN_ID"] 	= $_SESSION['kullanici_id'];
			$rows = $this->cdbPDO->rows($sql, $filtre);
		}
		
		return $rows;
    }
    
    public function getIhaleCevapEnb($arrRequest = array()){
    	
    	$filtre	= array();
		$sql = "SELECT * FROM IHALE_CEVAP WHERE IHALE_ID = :IHALE_ID AND YETKI_ID = 6 ORDER BY SOVTAJ DESC LIMIT 1";
		$filtre[":IHALE_ID"] 		= $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		return $row;
    }
    
    public function getIhaleCevapEnk($arrRequest = array()){
    	
    	$filtre	= array();
		$sql = "SELECT * FROM IHALE_CEVAP WHERE IHALE_ID = :IHALE_ID AND YETKI_ID = 7 ORDER BY SOVTAJ ASC LIMIT 1";
		$filtre[":IHALE_ID"] 		= $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		return $row;
    }

    public function getIhaleCevapTeklifim($arrRequest = array()){
    	
    	$filtre	= array();
		$sql = "SELECT * FROM IHALE_CEVAP WHERE IHALE_ID = :IHALE_ID ORDER BY SOVTAJ DESC";
		$filtre[":IHALE_ID"] 		= $arrRequest['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre); 
		
    	foreach($rows as $key => $row){
			if($row->CEVAPLAYAN_ID == $_SESSION['kullanici_id']){
				$row->SIRA_TEXT = "(teklifiniz sıralamada " . ($key+1) . ". olmuştur.)";
				return $row;
			}
		}
		
		/*
    	$filtre	= array();
		$sql = "SELECT IC.*, IC. FROM IHALE_CEVAP AS IC WHERE IHALE_ID = :IHALE_ID AND CEVAPLAYAN_ID = :KULLANICI_ID ORDER BY SOVTAJ ASC LIMIT 1";
		$filtre[":IHALE_ID"] 		= $arrRequest['id'];
		$filtre[":KULLANICI_ID"]	= $_SESSION['kullanici_id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		*/
		
		return array();
    }
    
    public function getIhaleMesajlar($arrRequest = array()){
    	
    	$filtre	= array();
		$sql = "SELECT 
					IM.*,
					CONCAT_WS(' ', K1.AD, K1.SOYAD) AS KIMDEN,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KIME,
					K1.YETKI_ID AS KIMDEN_YETKI_ID,
					K2.YETKI_ID AS KIME_YETKI_ID
				FROM IHALE_MESAJ AS IM
					LEFT JOIN KULLANICI AS K1 ON K1.ID = IM.KIMDEN_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = IM.KIME_ID
				WHERE IM.IHALE_ID = :IHALE_ID 
					AND (IM.KIMDEN_ID = :KIMDEN_ID OR IM.KIME_ID = :KIME_ID)
				ORDER BY IM.TARIH
				";
		$filtre[":IHALE_ID"] 		= $arrRequest['id'];
		if(in_array($_SESSION['yetki_id'], array(6,7))){
			$filtre[":KIME_ID"] 		= $_SESSION['kullanici_id'];
			$filtre[":KIMDEN_ID"] 		= $_SESSION['kullanici_id'];
		} else {
			$filtre[":KIME_ID"] 		= $arrRequest['kime_id'];
			$filtre[":KIMDEN_ID"] 		= $arrRequest['kime_id'];
		}
		
		
		$rows = $this->cdbPDO->rows($sql, $filtre); 
		//var_dump2($this->cdbPDO->getSQL($sql, $filtre));
		return $rows;
    }
    
    public function getIhaleOkunmamisMesaj($arrRequest = array()){
    	
    	$filtre	= array();
		$sql = "SELECT
					IM.ID,
					IM.MESAJ,
					IM.TARIH,
					IM.IHALE_ID,
					CONCAT_WS(' ', K1.AD, K1.SOYAD) AS KIMDEN,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KIME,
					CONCAT('/ihale/yazisma.do?route=ihale/yazisma&id=', IM.IHALE_ID, '&kime_id=', IM.KIMDEN_ID) AS LINK,
					CONCAT('kullanici/', KR.RESIM_ADI) AS KIMDEN_RESIM_URL
				FROM IHALE_MESAJ AS IM
					LEFT JOIN KULLANICI AS K1 ON K1.ID = IM.KIMDEN_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = IM.KIME_ID
					LEFT JOIN KULLANICI_RESIM AS KR ON KR.KULLANICI_ID = K1.ID AND KR.DURUM = 1
				WHERE IM.OKUNDU = 0
					AND IM.KIME_ID = :KIME_ID
				";
		$filtre[":KIME_ID"] 		= $_SESSION['kullanici_id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre); 
		
		return $rows;
    }
    
    public function getIhaleMesajSay($arrRequest = array()){
    	
    	$filtre	= array();
		$sql = "SELECT
					IM.KIMDEN_ID,
					COUNT(K1.ID) AS MESAJ_SAY,
					SUM(IF(IM.OKUNDU=1,0,1)) AS OKUNMADI_SAY
				FROM IHALE_MESAJ AS IM
					LEFT JOIN KULLANICI AS K1 ON K1.ID = IM.KIMDEN_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = IM.KIME_ID
				WHERE IM.IHALE_ID = :IHALE_ID 					
				GROUP BY IM.KIMDEN_ID
				";
		$filtre[":IHALE_ID"] 		= $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre); 
		
		foreach($rows as $key => $row){
			$arr[$row->KIMDEN_ID] = $row;
		}
		
		return $arr;
    }
    
    public function getFavorilerim($arrRequest = array()){
    	
    	$filtre	= array();
		$sql = "SELECT 
					F.*,
					F.IHALE_ID AS ID 
				FROM IHALE_FAVORI AS F 
				WHERE F.KULLANICI_ID = :KULLANICI_ID
				";
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$rows = $this->cdbPDO->rows($sql, $filtre); 
		
		return $rows;
    }
    
    public function getFatura($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN,
        			F.*
				FROM FATURA AS F
					LEFT JOIN KULLANICI AS K ON K.ID = F.KULLANICI_ID
				WHERE F.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getTalepFatura($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN,
        			F.*
				FROM FATURA AS F
					LEFT JOIN KULLANICI AS K ON K.ID = F.KAYIT_YAPAN_ID
				WHERE F.TALEP_ID = :TALEP_ID
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getTalep($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			T.*,
        			S.SUREC,
        			C.CARI,
        			C.CARI_KOD,
        			C.TCK,
        			C.VD,
        			C.ADRES CARI_ADRES,
        			C.CEPTEL AS CARI_CEPTEL,
        			C.TEL AS CARI_TEL,
        			MA.MARKA,
        			MO.MODEL,
        			DATE_FORMAT(DATE_ADD(T.TARIH, INTERVAL 1 DAY), '%Y/%m/%d %H:%i:%s') AS KALAN_SURE_TARIH,
        			Y.YAKIT,
        			V.VITES,
        			SI.FIRMA AS SIGORTA_FIRMASI,
        			CONCAT_WS(' ', TA.AD, TA.SOYAD) AS TALEP_ACAN,
        			CONCAT_WS(' ', TS.AD, TS.SOYAD) AS SORUMLU,
        			CASE 
        				WHEN T.FATURA_KES = 1 THEN 'Fatura'
        				WHEN T.FATURA_KES = 2 THEN 'İrsaliye'
        				ELSE ''
        			END FATURA_KES_TEXT,
        			F.FIRMA AS SIGORTA_FIRMA
				FROM TALEP AS T
					LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
					LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
					LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = T.YAKIT_TURU
					LEFT JOIN VITES AS V ON V.ID = T.VITES_TURU
					LEFT JOIN (SELECT * FROM FIRMA WHERE SIGORTA_FILO = 1) AS SI ON SI.ID = T.SIGORTA_ID
					LEFT JOIN KULLANICI AS TA ON TA.ID = T.EKLEYEN_ID
					LEFT JOIN KULLANICI AS TS ON TS.ID = T.SORUMLU_ID
					LEFT JOIN FIRMA AS F ON F.ID = T.SIGORTA_ID
				WHERE T.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getKiralama($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.*,
        			A.MODEL_YILI,
        			MA.MARKA,
        			MO.MODEL,
        			C.CARI,
        			C.KOD AS CARI_KOD,
        			CASE
        				WHEN K.SUREC_ID = 10 THEN 'Park'
        				ELSE 'Müşteri'
        			END AS SUREC,
        			CONCAT_WS(' ', TA.AD, TA.SOYAD) AS KIRALAMA_ACAN
				FROM KIRALAMA AS K
					LEFT JOIN ARAC AS A ON A.ID = K.ARAC_ID
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN CARI AS C ON C.ID = K.CARI_ID
					LEFT JOIN KULLANICI AS TA ON TA.ID = K.EKLEYEN_ID
				WHERE K.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getIkame($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TI.*,
        			A.MODEL_YILI,
        			MA.MARKA,
        			MO.MODEL,
        			CASE
        				WHEN T.SUREC_ID = 10 THEN 'Park'
        				ELSE 'Müşteri'
        			END AS SUREC,
        			CONCAT_WS(' ', TA.AD, TA.SOYAD) AS KIRALAMA_ACAN,
        			T.ID AS TALEP_ID,
        			T.PLAKA AS TALEP_PLAKA,
        			MAT.MARKA AS TALEP_MARKA,
        			MOT.MODEL AS TALEP_MODEL
				FROM TALEP_IKAME AS TI
					LEFT JOIN TALEP AS T ON T.ID = TI.TALEP_ID
					LEFT JOIN ARAC AS A ON A.ID = TI.ARAC_ID					
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN MARKA AS MAT ON MAT.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MOT ON MOT.ID = T.MODEL_ID
					LEFT JOIN KULLANICI AS TA ON TA.ID = TI.EKLEYEN_ID
				WHERE TI.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getTalepSikayetler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			S.*,
        			S.SIRA AS ID
				FROM SIKAYET AS S
				WHERE S.TALEP_ID = :TALEP_ID
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getKiralamaYansitmalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			KY.*,
        			KY.SIRA AS ID,
        			CH.ID AS CH_ID,
        			CH.KOD AS CH_KOD
				FROM KIRALAMA_YANSITMA AS KY
					LEFT JOIN CARI_HAREKET AS CH ON CH.YANSITMA_ID = KY.ID
				WHERE KY.KIRALAMA_ID = :KIRALAMA_ID
				";
		$filtre[":KIRALAMA_ID"] = $arrRequest['id'];		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getIkameYansitmalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			KY.*,
        			KY.SIRA AS ID
				FROM KIRALAMA_YANSITMA AS KY
				WHERE KY.KIRALAMA_ID = :KIRALAMA_ID
				";
		$filtre[":KIRALAMA_ID"] = $arrRequest['id'];		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getTalepKontroller($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.ID,
        			K.KONTROL,
        			TK.*
				FROM KONTROL AS K
					LEFT JOIN TALEP_KONTROL AS TK ON TK.KONTROL_ID = K.ID AND TK.TALEP_ID = :TALEP_ID
				WHERE 1
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getTalepParcalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			P.*,
        			P.ID AS PARCA_ID
				FROM PARCA AS P
				WHERE P.TALEP_ID = :TALEP_ID
				ORDER BY P.SIRA
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariHareketDetay($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			P.*,
        			P.ID AS PARCA_ID,
        			P.SIRA AS ID,
        			TC.CARI AS TEDARIKCI
				FROM CARI_HAREKET_DETAY AS P
					LEFT JOIN CARI AS TC ON TC.ID = P.TEDARIKCI_ID
				WHERE P.CARI_HAREKET_ID = :CARI_HAREKET_ID
				ORDER BY P.SIRA
				";
		$filtre[":CARI_HAREKET_ID"] = $arrRequest['id'];	
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getStoklar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			P.PARCA_KODU,
        			P.PARCA_ADI,
        			P.FIYAT
				FROM CARI_HAREKET_DETAY AS P
				WHERE 1
				GROUP BY P.PARCA_KODU
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAraclar($arrRequest = array()){
    	
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
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariHareket($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.*,
        			C.CARI,
        			C.CARI_KOD,
        			OK.ODEME_KANALI,
        			OKD.ODEME_KANALI_DETAY,
        			H.HAREKET,
        			FK.KDV
				FROM CARI_HAREKET AS CH
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN HAREKET AS H ON H.ID = CH.HAREKET_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID 
				WHERE CH.ID = :ID
				GROUP BY CH.ID DESC
				";
		$filtre[":ID"] = $arrRequest['id'];	
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getTalepCariHareket($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.*,
        			C.CARI,
        			C.CARI_KOD,
        			OK.ODEME_KANALI,
        			OKD.ODEME_KANALI_DETAY,
        			H.HAREKET
				FROM CARI_HAREKET AS CH
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN HAREKET AS H ON H.ID = CH.HAREKET_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
				WHERE CH.TALEP_ID = :TALEP_ID
				GROUP BY CH.ID DESC
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];	
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getStokDetaylar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.HAREKET_ID,
        			CH.PLAKA,
        			CHD.PARCA_KODU,
        			CHD.PARCA_ADI,
        			IF(CH.HAREKET_ID IN(1), CHD.FIYAT, 0) AS ALIS,
        			IF(CH.HAREKET_ID IN(2), CHD.FIYAT, 0) AS SATIS,
        			C.CARI,
        			DATE(CH.TARIH) AS TARIH
				FROM CARI_HAREKET_DETAY AS CHD
					LEFT JOIN CARI_HAREKET AS CH ON CH.ID = CHD.CARI_HAREKET_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
				WHERE CHD.PARCA_KODU = :PARCA_KODU
				ORDER BY CH.TARIH
				";
		$filtre[":PARCA_KODU"] = $arrRequest['parca_kodu'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getHesapOzet($arrRequest = array()){
    	
    	$filtre = array();
		$sql = "SELECT
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY,
					SUM(IF(CH.HAREKET_ID IN(3), CH.TUTAR, 0)) AS TAHSILAT,
					SUM(IF(CH.HAREKET_ID IN(4), CH.TUTAR, 0)) AS TEDIYE,
					SUM(IF(CH.HAREKET_ID IN(3), CH.TUTAR, -1 * CH.TUTAR )) AS BAKIYE
				FROM CARI_HAREKET AS CH
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
				WHERE CH.HAREKET_ID IN(3,4)
				GROUP BY CH.ODEME_KANALI_DETAY_ID ORDER BY OK.ODEME_KANALI
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getKasaOzet($arrRequest = array()){
    	
    	$filtre = array();
		$sql = "SELECT
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY,
					SUM(IF(CH.HAREKET_ID IN(1,3), CH.TUTAR, 0)) AS TAHSILAT,
					SUM(IF(CH.HAREKET_ID IN(2,4), CH.TUTAR, 0)) AS TEDIYE,
					SUM(IF(CH.HAREKET_ID IN(1,3), CH.TUTAR, -1 * CH.TUTAR )) AS BAKIYE
				FROM CARI_HAREKET AS CH
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
				WHERE 1
                ";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getTalepIscilikler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			P.*,
        			P.ID AS PARCA_ID
				FROM ISCILIK AS P
				WHERE P.TALEP_ID = :TALEP_ID
				ORDER BY P.SIRA
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getTalepIkameler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TI.*,
        			MA.MARKA,
        			MO.MODEL
				FROM TALEP_IKAME AS TI
					LEFT JOIN ARAC AS A ON A.ID = TI.ARAC_ID
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
				WHERE TI.TALEP_ID = :TALEP_ID
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getTalepIkame($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			A.*,
        			MA.MARKA,
        			MO.MODEL
				FROM TALEP AS T
					LEFT JOIN ARAC AS A ON A.ID = T.IKAME_ARAC_ID
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
				WHERE T.ID = :TALEP_ID
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getTalepTemsilcisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.KULLANICI,
        			CONCAT(K.AD, ' ', K.SOYAD) AS ADSOYAD,
        			K.UNVAN,
        			K.TEL,
        			K.CEPTEL,
        			K.CEPTEL2,
        			K.MAIL
				FROM TALEP AS T
					LEFT JOIN KULLANICI AS K ON K.ID = T.MUSTERI_TEMSILCISI_ID
				WHERE T.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getTalepArac($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			A.ID,
        			A.PLAKA,
        			A.MODEL_YILI,
        			A.SASI_NO,
        			A.MOTOR_NO,
        			A.SURUCU_TCK,
        			A.SURUCU_AD,
        			A.SURUCU_SOYAD,
        			A.SURUCU_TEL,
        			A.SURUCU_CEPTEL,
        			A.SURUCU_MAIL,
        			MA.MARKA,
        			MO.MODEL
				FROM TALEP AS T
					LEFT JOIN ARAC AS A ON A.ID = T.ARAC_ID
					LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
				WHERE T.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getTalepServis($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.ID,
        			K.UNVAN,
        			K.TEL,
        			K.CEPTEL,
        			K.CEPTEL2,
        			K.SERVIS_TURU,
        			IL.IL AS SERVIS_IL,
        			ILCE.ILCE AS SERVIS_ILCE
				FROM TALEP AS T
					LEFT JOIN KULLANICI AS K ON K.ID = T.SERVIS_ID
					LEFT JOIN IL ON IL.ID = K.IL_ID
					LEFT JOIN ILCE ON ILCE.ID = K.ILCE_ID
				WHERE T.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getTalepVale($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			V.ID,
        			V.UNVAN,
        			V.TEL,
        			V.CEPTEL,
        			V.CEPTEL2,
        			VACS.CALISMA_SAAT AS VALE_ALIS_SAAT,
        			VAIL.IL AS VALE_ALIS_IL,
        			VAILCE.ILCE AS VALE_ALIS_ILCE,
        			VTCS.CALISMA_SAAT AS VALE_TESLIM_SAAT,
        			VTIL.IL AS VALE_TESLIM_IL,
        			VTILCE.ILCE AS VALE_TESLIM_ILCE
				FROM TALEP AS T
					LEFT JOIN CALISMA_SAAT AS VACS ON VACS.ID = T.VALE_ALIS_SAAT
					LEFT JOIN IL AS VAIL ON VAIL.ID = T.VALE_ALIS_IL_ID
					LEFT JOIN ILCE AS VAILCE ON VAILCE.ID = T.VALE_ALIS_ILCE_ID
					LEFT JOIN CALISMA_SAAT AS VTCS ON VTCS.ID = T.VALE_TESLIM_SAAT
					LEFT JOIN IL AS VTIL ON VTIL.ID = T.VALE_TESLIM_IL_ID
					LEFT JOIN ILCE AS VTILCE ON VTILCE.ID = T.VALE_TESLIM_ILCE_ID
					LEFT JOIN KULLANICI AS V ON V.ID = T.VALE_ID
				WHERE T.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getHizmetNoktalari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.ID,
        			K.UNVAN,
        			K.CEPTEL,
        			K.CEPTEL2,
        			CONCAT_WS(' - ', IL.IL, ILCE.ILCE) AS IL_ILCE,
        			Y.YETKI
				FROM TALEP AS T
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN IL ON IL.ID = K.IL_ID
					LEFT JOIN ILCE ON ILCE.ID = K.ILCE_ID
				WHERE Y.HIZMET_NOKTASI = 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getTalepServisZincirFiyati($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					B.ID,
					B.FIYAT,
					B.SERVIS_ZINCIR_ID,
					SZ.UNVAN AS SERVIS_ZINCIR
				FROM BAKIM_PAKET_FIYAT AS B	
					LEFT JOIN SERVIS_ZINCIR AS SZ ON SZ.ID = B.SERVIS_ZINCIR_ID
				WHERE B.BAKIM_PAKET_ID = :BAKIM_PAKET_ID
					AND SZ.SERVIS_TURU = :SERVIS_TURU
				ORDER BY B.FIYAT DESC
				";
		$filtre[":BAKIM_PAKET_ID"] 	= $arrRequest['bakim_paket_id'];
		$filtre[":SERVIS_TURU"] 	= $arrRequest['servis_turu'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$rows_zincir = array();
		foreach($rows as $key => $row){
			$filtre = array();
	        $sql = "SELECT
	        			K.ID,
						K.UNVAN AS AD
					FROM KULLANICI AS K	
					WHERE K.YETKI_ID = 11
						AND K.BAKIM_HIZMETI = 1
						AND K.SERVIS_ZINCIR_ID = :SERVIS_ZINCIR_ID
						AND K.IL_ID = :IL_ID
					ORDER BY K.UNVAN
					";
			$filtre[":SERVIS_ZINCIR_ID"] 	= $row->SERVIS_ZINCIR_ID;
			$filtre[":IL_ID"] 				= $arrRequest['servis_il_id'];
			$rows_servis = $this->cdbPDO->rows($sql, $filtre);
			if(count($rows_servis) > 0){
				$rows_zincir[$row->SERVIS_ZINCIR_ID]->SERVIS_ZINCIR	= $row->SERVIS_ZINCIR . " - " . FormatSayi::sayi($row->FIYAT,0) ." TL";
				foreach($rows_servis as $key2 => $row_servis){
					$rows_zincir[$row->SERVIS_ZINCIR_ID]->SERVIS[$row_servis->ID]	= $row_servis;
				}
			}
		}
        
		return $rows_zincir;
		
    }
    
    public function getHgsler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.ID,
        			K.UNVAN,
        			K.CEPTEL,
        			K.CEPTEL2,
        			CONCAT_WS(' - ', IL.IL, ILCE.ILCE) AS IL_ILCE,
        			Y.YETKI
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN IL ON IL.ID = K.IL_ID
					LEFT JOIN ILCE ON ILCE.ID = K.ILCE_ID
				WHERE Y.HIZMET_NOKTASI = 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    
    public function getCezalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.ID,
        			K.UNVAN,
        			K.CEPTEL,
        			K.CEPTEL2,
        			CONCAT_WS(' - ', IL.IL, ILCE.ILCE) AS IL_ILCE,
        			Y.YETKI
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN IL ON IL.ID = K.IL_ID
					LEFT JOIN ILCE ON ILCE.ID = K.ILCE_ID
				WHERE Y.HIZMET_NOKTASI = 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getModulYakitlar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			MH.*,
        			AF.UNVAN AS AKARYAKIT
				FROM MODUL_HIZMET AS MH
					LEFT JOIN KULLANICI AS K ON K.ID = MH.KAYIT_YAPAN_ID
					LEFT JOIN (SELECT * FROM KULLANICI WHERE YETKI_ID = 17) AS AF ON AF.ID = MH.AKARYAKIT_ID
				WHERE MH.HIZMET_ID = 30 
					AND MH.MUSTERI_ID = :MUSTERI_ID
				";
		
		$filtre[":MUSTERI_ID"]	= $arrRequest["musteri_id"];
		
		if($arrRequest["arac_id"] > 0){
			$sql.= " AND MH.ARAC_ID = :ARAC_ID";
			$filtre[":ARAC_ID"]		= $arrRequest["arac_id"];	
		}
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getModulMuayeneler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			MH.*
				FROM MODUL_HIZMET AS MH
					LEFT JOIN KULLANICI AS K ON K.ID = MH.KAYIT_YAPAN_ID
				WHERE MH.HIZMET_ID = 22 
					AND MH.MUSTERI_ID = :MUSTERI_ID
				";
		
		$filtre[":MUSTERI_ID"]	= $arrRequest["musteri_id"];
		
		if($arrRequest["arac_id"] > 0){
			$sql.= " AND MH.ARAC_ID = :ARAC_ID";
			$filtre[":ARAC_ID"]		= $arrRequest["arac_id"];	
		}
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getModulBakimlar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			MH.*
				FROM MODUL_HIZMET AS MH
					LEFT JOIN KULLANICI AS K ON K.ID = MH.KAYIT_YAPAN_ID
				WHERE MH.HIZMET_ID = 11 
					AND MH.MUSTERI_ID = :MUSTERI_ID
				";
		
		$filtre[":MUSTERI_ID"]	= $arrRequest["musteri_id"];
		
		if($arrRequest["arac_id"] > 0){
			$sql.= " AND MH.ARAC_ID = :ARAC_ID";
			$filtre[":ARAC_ID"]		= $arrRequest["arac_id"];	
		}
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getModulHgsler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			MH.*
				FROM MODUL_HIZMET AS MH
					LEFT JOIN KULLANICI AS K ON K.ID = MH.KAYIT_YAPAN_ID
				WHERE MH.HIZMET_ID = 23 
					AND MH.MUSTERI_ID = :MUSTERI_ID
				";
		
		$filtre[":MUSTERI_ID"]	= $arrRequest["musteri_id"];
		
		if($arrRequest["arac_id"] > 0){
			$sql.= " AND MH.ARAC_ID = :ARAC_ID";
			$filtre[":ARAC_ID"]		= $arrRequest["arac_id"];	
		}
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getVergiler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.ID,
        			K.UNVAN,
        			K.CEPTEL,
        			K.CEPTEL2,
        			CONCAT_WS(' - ', IL.IL, ILCE.ILCE) AS IL_ILCE,
        			Y.YETKI
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN IL ON IL.ID = K.IL_ID
					LEFT JOIN ILCE ON ILCE.ID = K.ILCE_ID
				WHERE Y.HIZMET_NOKTASI = 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getFaturaCariHareket($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CMK.MALI_KODU,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN,
        			CH.*
				FROM CARI_HAREKET AS CH					
					LEFT JOIN KULLANICI AS K ON K.ID = CH.KULLANICI_ID
					LEFT JOIN CARI_MALI_KODU AS CMK ON CMK.ID = H.MALI_KODU_ID
				WHERE CH.FATURA_ID = :FATURA_ID
				";
		$filtre[":FATURA_ID"] = $arrRequest['id'];		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    // Günlük Bas
    public function getGunlukTahsilat($arrRequest = array()){
    	
    	$tarih = explode(",", $_REQUEST['tarih']);
			
    	$filtre = array();
        $sql = "SELECT 
        			CH.*,
        			T.ID AS TALEP_NO,
        			OKD.ODEME_KANALI_DETAY,
        			C.CARI
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID        			
        			LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        			LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
        		WHERE CH.HAREKET_ID = 3
        			AND DATE(CH.FATURA_TARIH) >= :TARIH1
        			AND DATE(CH.FATURA_TARIH) <= :TARIH2
        			AND CH.ODEME_KANALI_ID > 0
        		ORDER BY CH.FATURA_TARIH DESC, OKD.SIRA ASC
				";
		$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
		$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getGunlukTahsilatToplam($arrRequest = array()){
    	
    	$tarih = explode(",", $_REQUEST['tarih']);
    	
    	$filtre = array();
        $sql = "SELECT 
        			SUM(CH.TUTAR) AS TUTAR,
        			OKD.ODEME_KANALI_DETAY
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        		WHERE CH.HAREKET_ID = 3
        			AND DATE(CH.FATURA_TARIH) >= :TARIH1
        			AND DATE(CH.FATURA_TARIH) <= :TARIH2
        			AND CH.ODEME_KANALI_ID > 0
        		GROUP BY CH.ODEME_KANALI_DETAY_ID
        		ORDER BY OKD.SIRA ASC
				";
		$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
		$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getGunlukTediye($arrRequest = array()){
    	
    	$tarih = explode(",", $_REQUEST['tarih']);
    	
    	$filtre = array();
        $sql = "SELECT 
        			CH.*,
        			T.ID AS TALEP_NO,
        			OKD.ODEME_KANALI_DETAY,
        			C.CARI
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        			LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
        		WHERE CH.HAREKET_ID = 4
        			AND DATE(CH.FATURA_TARIH) >= :TARIH1
        			AND DATE(CH.FATURA_TARIH) <= :TARIH2
        		ORDER BY CH.FATURA_TARIH DESC, OKD.SIRA ASC
				";
		$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
		$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getGunlukTediyeToplam($arrRequest = array()){
    	
    	$tarih = explode(",", $_REQUEST['tarih']);
    	
    	$filtre = array();
        $sql = "SELECT 
        			SUM(CH.TUTAR) AS TUTAR,
        			OKD.ODEME_KANALI_DETAY
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        		WHERE CH.HAREKET_ID = 4
        			AND DATE(CH.FATURA_TARIH) >= :TARIH1
        			AND DATE(CH.FATURA_TARIH) <= :TARIH2
        		GROUP BY CH.ODEME_KANALI_DETAY_ID
        		ORDER BY OKD.SIRA ASC
				";
		$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
		$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getKasalarGunluk($arrRequest = array()){
    	
    	$tarih = explode(",", $_REQUEST['tarih']);
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.ODEME_KANALI_ID,
        			CH.ODEME_KANALI_DETAY_ID,
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY,
					SUM(IF(CH.HAREKET_ID IN(3), CH.TUTAR, 0)) AS TAHSILAT,
					SUM(IF(CH.HAREKET_ID IN(4), CH.TUTAR, 0)) AS TEDIYE,
					SUM(IF(CH.HAREKET_ID IN(3), CH.TUTAR, -1 * CH.TUTAR )) AS BAKIYE,
					OKD.SIRA,
					OKD.LIMIT
				FROM CARI_HAREKET AS CH
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
				WHERE CH.HAREKET_ID IN(3,4)
        			AND DATE(CH.FATURA_TARIH) <= :TARIH2
				GROUP BY CH.ODEME_KANALI_DETAY_ID 
				ORDER BY OKD.SIRA ASC, OKD.ODEME_KANALI_DETAY
				";
		$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    // Günlük Bit 
    
    public function getKasalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.ODEME_KANALI_ID,
        			CH.ODEME_KANALI_DETAY_ID,
					OK.ODEME_KANALI,
					OKD.ODEME_KANALI_DETAY,
					SUM(IF(CH.HAREKET_ID IN(3), CH.TUTAR, 0)) AS TAHSILAT,
					SUM(IF(CH.HAREKET_ID IN(4), CH.TUTAR, 0)) AS TEDIYE,
					SUM(IF(CH.HAREKET_ID IN(3), CH.TUTAR, -1 * CH.TUTAR )) AS BAKIYE
				FROM CARI_HAREKET AS CH
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
				WHERE CH.HAREKET_ID IN(3,4)
				GROUP BY OKD.SIRA ASC, OKD.ODEME_KANALI_DETAY
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikAlis($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			CH.*,
        			T.ID AS TALEP_NO,
        			FK.FINANS_KALEMI
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
        		WHERE CH.HAREKET_ID = 2
        			AND YEAR(CH.TARIH) = :YIL
        			AND MONTH(CH.TARIH) = :AY
        		ORDER BY CH.TARIH DESC
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikAlisToplam($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			SUM(CH.TUTAR) AS TUTAR,
        			FK.FINANS_KALEMI
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
        		WHERE CH.HAREKET_ID = 2
        			AND YEAR(CH.TARIH) = :YIL
        			AND MONTH(CH.TARIH) = :AY
        		GROUP BY CH.FINANS_KALEMI_ID
        		ORDER BY 2
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikSatis($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			CH.*,
        			T.ID AS TALEP_NO,
        			FK.FINANS_KALEMI
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
        		WHERE CH.HAREKET_ID = 1
        			AND YEAR(CH.TARIH) = :YIL
        			AND MONTH(CH.TARIH) = :AY
        		ORDER BY CH.TARIH DESC
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikSatisToplam($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			SUM(CH.TUTAR) AS TUTAR,
        			FK.FINANS_KALEMI
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
        		WHERE CH.HAREKET_ID = 1
        			AND YEAR(CH.TARIH) = :YIL
        			AND MONTH(CH.TARIH) = :AY
        		GROUP BY CH.FINANS_KALEMI_ID
        		ORDER BY 2
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikTahsilat($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			CH.*,
        			T.ID AS TALEP_NO,
        			OKD.ODEME_KANALI_DETAY,
        			C.CARI
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        			LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
        		WHERE CH.HAREKET_ID = 3
        			AND YEAR(CH.TARIH) = :YIL
        			AND MONTH(CH.TARIH) = :AY
        		ORDER BY CH.TARIH DESC
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikTahsilatToplam($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			SUM(CH.TUTAR) AS TUTAR,
        			OKD.ODEME_KANALI_DETAY
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        		WHERE CH.HAREKET_ID = 3
        			AND YEAR(CH.TARIH) = :YIL
        			AND MONTH(CH.TARIH) = :AY
        		GROUP BY CH.ODEME_KANALI_DETAY_ID
        		ORDER BY 2
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikTediye($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			CH.*,
        			T.ID AS TALEP_NO,
        			OKD.ODEME_KANALI_DETAY,
        			C.CARI
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        			LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
        		WHERE CH.HAREKET_ID = 4
        			AND YEAR(CH.TARIH) = :YIL
        			AND MONTH(CH.TARIH) = :AY
        		ORDER BY CH.TARIH DESC
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikTediyeToplam($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			SUM(CH.TUTAR) AS TUTAR,
        			OKD.ODEME_KANALI_DETAY
        		FROM CARI_HAREKET AS CH
        			LEFT JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        		WHERE CH.HAREKET_ID = 4
        			AND YEAR(CH.TARIH) = :YIL
        			AND MONTH(CH.TARIH) = :AY
        		GROUP BY CH.ODEME_KANALI_DETAY_ID
        		ORDER BY 2
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikPrim($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			CH.TALEP_ID,
        			CH.FATURA_NO,
        			CH.FATURA_TARIH,
        			SUM(I.ISKONTOLU) AS TUTAR
        		FROM CARI_HAREKET AS CH
        			INNER JOIN TALEP AS T ON T.ID = CH.TALEP_ID
        			INNER JOIN ISCILIK AS I ON I.TALEP_ID = T.ID
        			LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        			LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
        		WHERE CH.HAREKET_ID = 1
        			AND YEAR(CH.FATURA_TARIH) = :YIL
        			AND MONTH(CH.FATURA_TARIH) = :AY
        		GROUP BY T.ID
        		HAVING TUTAR > 0
        		ORDER BY CH.TARIH DESC
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikPersonelCezalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			PC.*
        		FROM PERSONEL_CEZA AS PC
        		WHERE YEAR(PC.CEZA_TARIH) = :YIL
        			AND MONTH(PC.CEZA_TARIH) = :AY
        		GROUP BY PC.ID
        		ORDER BY PC.TARIH DESC
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikPrimSerdar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			CH.TALEP_ID,
        			CH.FATURA_NO,
        			CH.FATURA_TARIH,
        			SUM(I.ISKONTOLU) AS TUTAR
        		FROM otoservisci_serdar.CARI_HAREKET AS CH
        			INNER JOIN otoservisci_serdar.TALEP AS T ON T.ID = CH.TALEP_ID
        			INNER JOIN otoservisci_serdar.ISCILIK AS I ON I.TALEP_ID = T.ID
        			LEFT JOIN otoservisci_serdar.ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
        			LEFT JOIN otoservisci_serdar.CARI AS C ON C.ID = CH.CARI_ID
        		WHERE CH.HAREKET_ID = 1
        			AND YEAR(CH.FATURA_TARIH) = :YIL
        			AND MONTH(CH.FATURA_TARIH) = :AY
        		GROUP BY T.ID
        		HAVING TUTAR > 0
        		ORDER BY CH.TARIH DESC
				";
		$filtre[":YIL"] = $arrRequest['yil'];
		$filtre[":AY"] 	= $arrRequest['ay'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    
    public function getFaturaXml($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN,
        			DATE(F.TARIH) AS DATE,
        			F.*
				FROM FATURA AS F
					LEFT JOIN KULLANICI AS K ON K.ID = F.KULLANICI_ID
				WHERE F.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row_fatura = $this->cdbPDO->row($sql, $filtre);
		
    	$filtre = array();
        $sql = "SELECT
        			CMK.MALI_KODU,
        			H.KDV,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN,
        			CH.*
				FROM CARI_HAREKET AS CH
					LEFT JOIN KULLANICI AS K ON K.ID = CH.KULLANICI_ID
					LEFT JOIN CARI_MALI_KODU AS CMK ON CMK.ID = H.MALI_KODU_ID
				WHERE CH.FATURA_ID = :FATURA_ID
				";
		$filtre[":FATURA_ID"] = $arrRequest['id'];		
		$rows_detay = $this->cdbPDO->rows($sql, $filtre);
		
		$TRANSACTIONS = "";
		foreach($rows_detay as $key => $row_detay){
			$TRANSACTIONS.= '<TRANSACTION>
							    <TYPE>4</TYPE>
							    <MASTER_CODE>' . $row_detay->MALI_KODU . '</MASTER_CODE>
							    <QUANTITY>1</QUANTITY>
							    <PRICE>' . $row_detay->TUTAR . '</PRICE>
							    <DESCRIPTION>' . $row_detay->ACIKLAMA . '</DESCRIPTION>
							    <UNIT_CODE>06</UNIT_CODE>
							    <UNIT_CONV1>1</UNIT_CONV1>
							    <UNIT_CONV2>1</UNIT_CONV2>
							    <VAT_RATE>' . $row_detay->KDV . '</VAT_RATE>
					    	</TRANSACTION>
					    	';
		}
		
		$row->FATURA_NO	= $row_fatura->FATURA_NO;
		
		$row->XML = '<?xml version="1.0" encoding="ISO-8859-9"?>
					<SALES_INVOICES>
					  <INVOICE DBOP="INS">
					    <TYPE>9</TYPE>
					    <NUMBER>{NUMBER}</NUMBER>
					    <DATE>{DATE}</DATE>
					    <DOC_NUMBER>{DOC_NUMBER}</DOC_NUMBER>
					    <AUXIL_CODE>MRN</AUXIL_CODE>
					    <ARP_CODE>{MALI_KOD}</ARP_CODE>
					    <NOTES1>{NOTES1}</NOTES1>
					    <NOTES2>{NOTES2}</NOTES2>					    
					    <DISPATCHES>
					    </DISPATCHES>
					    <TRANSACTIONS>'.$TRANSACTIONS.'</TRANSACTIONS>
					    <DOC_DATE>{DATE}</DOC_DATE>
					    <EINVOICE>1</EINVOICE>
					    <PROFILE_ID>1</PROFILE_ID>
					    <EBOOK_DOCTYPE>99</EBOOK_DOCTYPE>
					  </INVOICE>
					</SALES_INVOICES>
					';
		//TYPE-(4-Hizmet,0-Malzeme)
		//NOTES1 50 karakter 
		//DESCRIPTION 50 karakter
		
		// FillAccCodes muhasebeleme kodu doldurur
		$paramXML	=  '<?xml version="1.0" encoding="utf-16"?>
						<Parameters>
							<ReplicMode>0</ReplicMode>
							<CheckParams>1</CheckParams>
							<CheckRight>1</CheckRight>
							<ApplyCampaign>0</ApplyCampaign>
							<ApplyCondition>0</ApplyCondition>
							<FillAccCodes>1</FillAccCodes>
							<FormSeriLotLines>0</FormSeriLotLines>
							<GetStockLinePrice>0</GetStockLinePrice>
							<ExportAllData>0</ExportAllData>
							<Validation>0</Validation>
							<CheckApproveDate>1</CheckApproveDate>
							<Period>1</Period>
						</Parameters>';
		$row->PARAM_XML	= $paramXML;
		
		$row->XML	= str_replace("{NUMBER}", $row_fatura->FATURA_NO, $row->XML);
		$row->XML	= str_replace("{DATE}", FormatTarih::db2nokta($row_fatura->DATE), $row->XML);
		$row->XML	= str_replace("{DOC_NUMBER}", $row_fatura->FATURA_NO, $row->XML);
		$row->XML	= str_replace("{MALI_KOD}", "L2408", $row->XML);
		$row->XML	= str_replace("{NOTES1}", FormatYazi::kisalt($row_fatura->ACIKLAMA,50), $row->XML);
		$row->XML	= str_replace("{NOTES2}", "", $row->XML);
		
		$row->XML	= str_replace("\t", "", $row->XML);
		
		return $row;
    }
    
    public function getOdemeXml($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN,
        			DATE(O.TAHSILAT_TARIHI) AS DATE,
        			T.TEKNE_ADI,
        			PB.LOGO_ID,
        			O.DOVIZ,
        			O.ACIKLAMA,
        			O.ODEME_KODU,
        			O.ODENEN_TUTAR,
        			O.ODEME_KANALI_ID,
        			CMK.MALI_KODU AS CARI_MALI_KODU,
        			OMK.MALI_KODU AS ODEME_MALI_KODU
				FROM ODEME AS O
					LEFT JOIN KULLANICI AS K ON K.ID = O.KULLANICI_ID
                    LEFT JOIN TEKNE AS T ON T.ID = O.TEKNE_ID
                    LEFT JOIN CARI_MALI_KODU AS CMK ON CMK.MALI_KODU = T.MALI_KODU_ID
                    LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = O.ODEME_KANALI_DETAY_ID
                    LEFT JOIN ODEME_MALI_KODU AS OMK ON OMK.MALI_KODU = OKD.MALI_KODU_ID
                    LEFT JOIN PARA_BIRIMI AS PB ON PB.DOVIZ = O.DOVIZ
				WHERE O.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$row_odeme = $this->cdbPDO->row($sql, $filtre);
		
		$filtre = array();
	    $sql = "SELECT
	       			D.ALIS
				FROM DOVIZ AS D
				WHERE TARIH = :TARIH AND DOVIZ = :DOVIZ
				";
		$filtre[":TARIH"] = $row_odeme->DATE;
		$filtre[":DOVIZ"] = $row_odeme->DOVIZ;
		$row_doviz = $this->cdbPDO->row($sql, $filtre);
		$row_doviz->KUR		= ($row_odeme->DOVIZ == "TL" ? 1 : $row_doviz->ALIS);
		
		$row->ODEME_KODU = $row_odeme->ODEME_KODU;
		 
		if($row_odeme->ODEME_KANALI_ID == 1){ //Kredi Kartı DATA_TYPE:31
			$row->XML = '<?xml version="1.0" encoding="ISO-8859-9"?>
						<ARP_VOUCHERS>
						  <ARP_VOUCHER DBOP="INS" >
						    <NUMBER>~</NUMBER>
						    <DATE>{DATE}</DATE>
						    <TYPE>70</TYPE>
						    <TOTAL_CREDIT>{TOTAL_CREDIT}</TOTAL_CREDIT>
						    <ARP_CODE>{ARP_CODE}</ARP_CODE>
						    <BANKACC_CODE>{BANKACC_CODE}</BANKACC_CODE>
						    <TRANSACTIONS>
						      <TRANSACTION>
						        <ARP_CODE>{ARP_CODE}</ARP_CODE>
						        <TRANNO>~</TRANNO>
						        <CREDIT>{TOTAL_CREDIT}</CREDIT>
						        <BANKACC_CODE>{BANKACC_CODE}</BANKACC_CODE>
						      </TRANSACTION>
						    </TRANSACTIONS>
						  </ARP_VOUCHER>
						</ARP_VOUCHERS>
						';
			
			//$row->XML	= str_replace("{NUMBER}", $row_odeme->ODEME_NO, $row->XML);
			$row->XML	= str_replace("{DATE}", FormatTarih::db2nokta($row_odeme->DATE), $row->XML);
			$row->XML	= str_replace("{TOTAL_CREDIT}", $row_odeme->ODENEN_TUTAR, $row->XML);
			$row->XML	= str_replace("{ARP_CODE}", $row_odeme->CARI_MALI_KODU, $row->XML);
			$row->XML	= str_replace("{BANKACC_CODE}", $row_odeme->ODEME_MALI_KODU, $row->XML);
			$row->XML	= str_replace("\t", "", $row->XML);
			
			$row->DATA_TYPE = 31;
			
		} else if($row_odeme->ODEME_KANALI_ID == 2){ //Havale DATA_TYPE:24  fiş satır DESCRIPTION = 200  NOTES1 ve NOTES2=50
			$row->XML = '<?xml version="1.0" encoding="ISO-8859-9"?>
						<BANK_VOUCHERS>
						  <BANK_VOUCHER DBOP="INS" >
						    <DATE>{DATE}</DATE>
						    <NUMBER>~</NUMBER>
						    <TYPE>3</TYPE>
						    <NOTES1>{NOTES1}</NOTES1>
						    <NOTES2>{NOTES2}</NOTES2>
						    <TRANSACTIONS>
						      <TRANSACTION>
						        <TYPE>1</TYPE>
						        <TRANNO>~</TRANNO>
						        <BANKACC_CODE>{BANKACC_CODE}</BANKACC_CODE>
						        <ARP_CODE>PVALE</ARP_CODE>
						        <TRCODE>3</TRCODE>
						        <MODULENR>7</MODULENR>
						        <DESCRIPTION>{DESCRIPTION}</DESCRIPTION>
						        <DEBIT>{DEBIT}</DEBIT>
						        <AMOUNT>{DEBIT}</AMOUNT>
						      </TRANSACTION>
						    </TRANSACTIONS>
						    <EBOOK_DOCTYPE>99</EBOOK_DOCTYPE>
						  </BANK_VOUCHER>
						</BANK_VOUCHERS>
						';
			
			$row->XML	= str_replace("{DATE}", FormatTarih::db2nokta($row_odeme->DATE), $row->XML);
			$row->XML	= str_replace("{NOTES1}", FormatYazi::kisalt($row_odeme->ACIKLAMA,200), $row->XML);
			$row->XML	= str_replace("{NOTES2}", "", $row->XML);
			$row->XML	= str_replace("{BANKACC_CODE}", $row_odeme->ODEME_MALI_KODU, $row->XML);
			$row->XML	= str_replace("{DESCRIPTION}", FormatYazi::kisalt($row_odeme->ACIKLAMA,200), $row->XML);
			$row->XML	= str_replace("{DEBIT}", $row_odeme->ODENEN_TUTAR, $row->XML);
			$row->XML	= str_replace("\t", "", $row->XML);
			
			$row->DATA_TYPE = 24;
		
		} else if($row_odeme->ODEME_KANALI_ID == 3){ // Nakit DATA_TYPE:29
			$row->XML = '<?xml version="1.0" encoding="ISO-8859-9"?>
						<SD_TRANSACTIONS>
						  <SD_TRANSACTION DBOP="INS" >
						    <TYPE>11</TYPE>
						    <SD_CODE>{SD_CODE}</SD_CODE>
						    <DATE>{DATE}</DATE>
						    <NUMBER>~</NUMBER>
						    <MASTER_TITLE>{MASTER_TITLE}</MASTER_TITLE>
						    <DESCRIPTION>{DESCRIPTION}</DESCRIPTION>
						    <AMOUNT>{AMOUNT}</AMOUNT>
						    <CURR_TRANS>1</CURR_TRANS>
						    <ATTACHMENT_ARP>
						      <TRANSACTION>
						        <ARP_CODE>{ARP_CODE}</ARP_CODE>
						        <TRANNO>~</TRANNO>
						        <DOC_NUMBER>{DOC_NUMBER}</DOC_NUMBER>
						        <DESCRIPTION>{DESCRIPTION}</DESCRIPTION>
						        <CREDIT>{AMOUNT}</CREDIT>
						        <CURR_TRANS>{CURR_TRANS}</CURR_TRANS>
						        <TC_XRATE>{TC_XRATE}</TC_XRATE>
						        <TC_AMOUNT>{TC_AMOUNT}</TC_AMOUNT>
						        <RC_XRATE>{TC_XRATE}</RC_XRATE>
						        <RC_AMOUNT>{TC_AMOUNT}</RC_AMOUNT>
						        <CURRSEL_TRANS>2</CURRSEL_TRANS>
						      </TRANSACTION>
						    </ATTACHMENT_ARP>
						    <DOC_NUMBER>9704</DOC_NUMBER>
						    <EBOOK_DOCTYPE>99</EBOOK_DOCTYPE>
						  </SD_TRANSACTION>
						</SD_TRANSACTIONS>
						';
			
			$row->XML	= str_replace("{SD_CODE}", $row_odeme->ODEME_MALI_KODU, $row->XML);
			$row->XML	= str_replace("{DATE}", FormatTarih::db2nokta($row_odeme->DATE), $row->XML);
			$row->XML	= str_replace("{MASTER_TITLE}", $row_odeme->TEKNE_ADI, $row->XML);
			$row->XML	= str_replace("{DESCRIPTION}", $row_odeme->ACIKLAMA, $row->XML);
			$row->XML	= str_replace("{AMOUNT}", $row_odeme->ODENEN_TUTAR, $row->XML);
			$row->XML	= str_replace("{ARP_CODE}", $row_odeme->CARI_MALI_KODU, $row->XML);
			$row->XML	= str_replace("{DOC_NUMBER}", $row_odeme->ODEME_KODU, $row->XML);
			
			$row->XML	= str_replace("{CURR_TRANS}", $row_odeme->LOGO_ID, $row->XML); //ParaBirimi 1
			$row->XML	= str_replace("{TC_XRATE}", $row_doviz->KUR, $row->XML); //Kur 3.51
			$row->XML	= str_replace("{TC_AMOUNT}", $row_odeme->ODENEN_TUTAR, $row->XML); //Verilen Miktar 70
			
			$row->XML	= str_replace("\t", "", $row->XML);
			
			$row->DATA_TYPE = 29;
			
		} else if($row_odeme->ODEME_KANALI_ID == 4){ //Çek
			//Şuanda yapılmayacak
			
		}
		
		// FillAccCodes muhasebeleme kodu doldurur
		$paramXML	=  '<?xml version="1.0" encoding="utf-16"?>
						<Parameters>
							<ReplicMode>0</ReplicMode>
							<CheckParams>1</CheckParams>
							<CheckRight>1</CheckRight>
							<ApplyCampaign>0</ApplyCampaign>
							<ApplyCondition>0</ApplyCondition>
							<FillAccCodes>1</FillAccCodes>
							<FormSeriLotLines>0</FormSeriLotLines>
							<GetStockLinePrice>0</GetStockLinePrice>
							<ExportAllData>0</ExportAllData>
							<Validation>0</Validation>
							<CheckApproveDate>1</CheckApproveDate>
							<Period>1</Period>
						</Parameters>';
		$row->PARAM_XML	= $paramXML;
		
		return $row;
		
    }
    
    public function getIhaleRayicler($arrRequest = array()){
		$filtre = array();
        $sql = "SELECT
        			RB.*
				FROM RAYIC_BELIRLEME AS RB
				WHERE RB.IHALE_ID =:ID
				";
		$filtre[":ID"] = $arrRequest['id'];		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
	}
	
	public function getDuyurular($arrRequest = array()){
		$filtre = array();
        $sql = "SELECT
        			D.*
				FROM DUYURU AS D
				WHERE 1
				";
				
		if(in_array($_SESSION['yetki_id'], array(4,5,6,7,8))){
			$sql .= " AND FIND_IN_SET(:ID, D.ALICILAR)";
			$filtre[":ID"] = $_SESSION['kullanici_id'];	
		}
		
		$sql.=" ORDER BY D.TARIH DESC";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
	}
	
	public function getDuyurularYeni($arrRequest = array()){
		$filtre = array();
        $sql = "SELECT
        			*
				FROM DUYURU
				WHERE 1
				";
				
		$sql .= " AND FIND_IN_SET(:ID, ALICILAR) AND NOT FIND_IN_SET(:ID, GORENLER)";
		$filtre[":ID"] = $_SESSION['kullanici_id'];	
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
	}
	
	public function getOdemeBekliyor($arrRequest = array()){
		$filtre = array();
        $sql = "SELECT 
					I.PERTCI_ODEME_TARIH,
					I.IHALE_NO,
					I.ID,
					I.KOD,
				    I.PLAKA,
				    MA.MARKA,
				    MO.MODEL,
				    IC.SOVTAJ
				FROM IHALE AS I 
					INNER JOIN IHALE_KAZANAN AS IK ON IK.IHALE_ID = I.ID
					LEFT JOIN MARKA AS MA ON MA.ID = I.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = I.MODEL_ID
					LEFT JOIN IHALE_CEVAP AS IC ON IC.IHALE_ID = I.ID AND IC.CEVAPLAYAN_ID = IK.KAZANAN_ID
				WHERE I.SUREC_ID IN(5,7,8,9,10,11) 
					AND IK.KAZANAN_ID = :KAZANAN_ID
					AND I.PERTCI_ODEME_YAPILDI = 0
					AND I.PERTCI_ODEME_TARIH != ''
				ORDER BY I.PERTCI_ODEME_TARIH ASC
				";
				
		$filtre[":KAZANAN_ID"] = $_SESSION['kullanici_id'];	
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
	}
	
	
	public function getCezaSorgulamalar($arrRequest = array()){
		$filtre = array();
        $sql = "SELECT
        			*
				FROM CEZA_SORGULAMA
					WHERE 1
				";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
	}
	
	public function getCezaSorgulama($arrRequest = array()){
		$filtre = array();
        $sql = "SELECT
        			*
				FROM CEZA_SORGULAMA
					WHERE ID = :ID
				";
		$filtre[':ID']		= $arrRequest['id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
	}
	
	public function getBasvurular(){
		$filtre = array();
        $sql = "SELECT
        			B.*,
        			BD.BASVURU_DURUM
				FROM BASVURU AS B
					LEFT JOIN BASVURU_DURUM AS BD ON BD.ID = B.DURUM_ID
				WHERE 1
				ORDER BY B.TARIH DESC
				";	
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
	}
    
    public function getKisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.*
				FROM KISI AS K
					LEFT JOIN DURUM AS D ON D.ID = K.DURUM
				WHERE K.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];	
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$row->ONCEKI_KISI_ID 	= $this->cdbPDO->row("SELECT MAX(ID) AS ID FROM KISI WHERE ID < :ID", array(":ID"=>$row->ID))->ID;
		$row->SONRAKI_KISI_ID	= $this->cdbPDO->row("SELECT MIN(ID) AS ID FROM KISI WHERE ID > :ID", array(":ID"=>$row->ID))->ID;
		
		
		
		return $row;
    }
    
    public function getCariHareketResimler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CHR.ID,
        			CHR.SIRA,
        			CHR.RESIM_ADI,
        			CHR.EVRAK_ID,
        			CONCAT('cari_hareket/', YEAR(CH.TARIH), '/', CH.ID, '/', CHR.RESIM_ADI) AS URL,
        			CHR.TARIH,
        			CHR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			CHR.DURUM,
        			E.EVRAK
				FROM CARI_HAREKET_RESIM AS CHR
					LEFT JOIN EVRAK AS E ON E.ID = CHR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = CHR.EKLEYEN_ID
					LEFT JOIN CARI_HAREKET AS CH ON CH.ID = CHR.CARI_HAREKET_ID
				WHERE CHR.CARI_HAREKET_ID = :CARI_HAREKET_ID 
				ORDER BY CHR.EVRAK_ID, CHR.TARIH
				";
		$filtre[":CARI_HAREKET_ID"] = $arrRequest['id'];
		
		if($arrRequest['limit'] > 0){
			$sql.=" LIMIT " . $arrRequest['limit'];
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
		
    }
    
    public function getSiteBanner($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			SR.ID,
        			SR.SIRA,
        			SR.RESIM_ADI,
        			CONCAT('banner/', SR.RESIM_ADI) AS URL,
        			SR.TARIH,
        			SR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			SR.DURUM
				FROM SITE_BANNER AS SR
					LEFT JOIN KULLANICI AS K ON K.ID = SR.EKLEYEN_ID
				WHERE 1
				ORDER BY SR.SIRA
				LIMIT 1
				";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }

    public function getLogoBanner($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			B.*,
        			M.MARKA,
        			M.ID,
        			M.RESIM_URL
				FROM BANNER_LOGO AS B
					LEFT JOIN MARKA AS M ON M.ID = B.MARKA_ID
					LEFT JOIN PARCA AS P ON P.ID = B.PARCA_ID
				WHERE 1
				ORDER BY B.SIRA ASC
				LIMIT 6
				";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }

    public function getLogoParcalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			B.*,
        			M.MARKA,
        			P.ID,
        			P.PARCA_ADI,
        			P.PARCA_KODU,
        			M.RESIM_URL AS RESIM
				FROM BANNER_LOGO AS B
					LEFT JOIN MARKA AS M ON M.ID = B.MARKA_ID
					LEFT JOIN PARCA AS P ON P.ID = B.PARCA_ID
				WHERE B.ID = :ID
				";
			
		$filtre[":ID"] = $arrRequest["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
        
        return $row;
		
    }
    
    public function getTalepResimler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TR.ID,
        			TR.SIRA,
        			TR.RESIM_ADI,
        			TR.EVRAK_ID,
        			CONCAT('talep/', YEAR(T.TARIH), '/', T.ID, '/', TR.RESIM_ADI) AS URL,
        			TR.TARIH,
        			TR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			TR.DURUM,
        			E.EVRAK
				FROM TALEP_RESIM AS TR
					LEFT JOIN EVRAK AS E ON E.ID = TR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = TR.EKLEYEN_ID
					LEFT JOIN TALEP AS T ON T.ID = TR.TALEP_ID
				WHERE TR.TALEP_ID = :TALEP_ID 
					AND TR.EVRAK_ID < 10
				ORDER BY TR.EVRAK_ID, TR.TARIH
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];
		
		if($arrRequest['limit'] > 0){
			$sql.=" LIMIT " . $arrRequest['limit'];
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getTalepEvraklar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TR.ID,
        			TR.SIRA,
        			TR.RESIM_ADI,
        			TR.EVRAK_ID,
        			CONCAT('talep/', YEAR(T.TARIH), '/', T.ID, '/', TR.RESIM_ADI) AS URL,
        			TR.TARIH,
        			TR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			TR.DURUM,
        			E.EVRAK
				FROM TALEP_RESIM AS TR
					LEFT JOIN EVRAK AS E ON E.ID = TR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = TR.EKLEYEN_ID
					LEFT JOIN TALEP AS T ON T.ID = TR.TALEP_ID
				WHERE TR.TALEP_ID = :TALEP_ID 
					AND TR.EVRAK_ID > 9
				ORDER BY TR.SIRA, TR.TARIH
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];
		
		if($arrRequest['limit'] > 0){
			$sql.=" LIMIT " . $arrRequest['limit'];
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getCariEvraklar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TR.ID,
        			TR.SIRA,
        			TR.RESIM_ADI,
        			TR.EVRAK_ID,
        			CONCAT('cari/', YEAR(C.TARIH), '/', C.ID, '/', TR.RESIM_ADI) AS URL,
        			TR.TARIH,
        			TR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			TR.DURUM,
        			E.EVRAK
				FROM CARI_RESIM AS TR
					LEFT JOIN EVRAK AS E ON E.ID = TR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = TR.EKLEYEN_ID
					LEFT JOIN CARI AS C ON C.ID = TR.CARI_ID
				WHERE TR.CARI_ID = :CARI_ID 
				ORDER BY TR.DURUM DESC, TR.SIRA
				";
		$filtre[":CARI_ID"] = $arrRequest['id'];
		
		if($arrRequest['limit'] > 0){
			$sql.=" LIMIT " . $arrRequest['limit'];
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getKiralamaResimler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TR.ID,
        			TR.SIRA,
        			TR.RESIM_ADI,
        			TR.EVRAK_ID,
        			CONCAT('kiralama/', YEAR(T.TARIH), '/', T.ID, '/', TR.RESIM_ADI) AS URL,
        			TR.TARIH,
        			TR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			TR.DURUM,
        			E.EVRAK
				FROM KIRALAMA_RESIM AS TR
					LEFT JOIN EVRAK AS E ON E.ID = TR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = TR.EKLEYEN_ID
					LEFT JOIN KIRALAMA AS T ON T.ID = TR.KIRALAMA_ID
				WHERE TR.KIRALAMA_ID = :KIRALAMA_ID 
					AND TR.DURUM IN(0,1)
					AND E.EVRAK_BOLUM_ID = 5
				ORDER BY TR.EVRAK_ID
				";
		$filtre[":KIRALAMA_ID"] = $arrRequest['id'];
		
		if($arrRequest['limit'] > 0){
			$sql.=" LIMIT " . $arrRequest['limit'];
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getKiralamaEvraklar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TR.ID,
        			TR.SIRA,
        			TR.RESIM_ADI,
        			TR.EVRAK_ID,
        			CONCAT('kiralama/', YEAR(T.TARIH), '/', T.ID, '/', TR.RESIM_ADI) AS URL,
        			TR.TARIH,
        			TR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			TR.DURUM,
        			E.EVRAK
				FROM KIRALAMA_RESIM AS TR
					LEFT JOIN EVRAK AS E ON E.ID = TR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = TR.EKLEYEN_ID
					LEFT JOIN KIRALAMA AS T ON T.ID = TR.KIRALAMA_ID
				WHERE TR.KIRALAMA_ID = :KIRALAMA_ID 
					AND TR.DURUM IN(0,1)
					AND E.EVRAK_BOLUM_ID = 6
				ORDER BY TR.DURUM DESC, TR.SIRA
				";
		$filtre[":KIRALAMA_ID"] = $arrRequest['id'];
		
		if($arrRequest['limit'] > 0){
			$sql.=" LIMIT " . $arrRequest['limit'];
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getIkameResimler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TR.ID,
        			TR.SIRA,
        			TR.RESIM_ADI,
        			TR.EVRAK_ID,
        			CONCAT('ikame/', YEAR(T.TARIH), '/', T.ID, '/', TR.RESIM_ADI) AS URL,
        			TR.TARIH,
        			TR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			TR.DURUM,
        			E.EVRAK
				FROM IKAME_RESIM AS TR
					LEFT JOIN EVRAK AS E ON E.ID = TR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = TR.EKLEYEN_ID
					LEFT JOIN TALEP_IKAME AS T ON T.ID = TR.IKAME_ID
				WHERE TR.IKAME_ID = :IKAME_ID 
					AND TR.DURUM IN(0,1)
					AND E.EVRAK_BOLUM_ID = 3
				ORDER BY TR.EVRAK_ID
				";
		$filtre[":IKAME_ID"] = $arrRequest['id'];
		
		if($arrRequest['limit'] > 0){
			$sql.=" LIMIT " . $arrRequest['limit'];
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getIkameEvraklar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TR.ID,
        			TR.SIRA,
        			TR.RESIM_ADI,
        			TR.EVRAK_ID,
        			CONCAT('ikame/', YEAR(T.TARIH), '/', T.ID, '/', TR.RESIM_ADI) AS URL,
        			TR.TARIH,
        			TR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			TR.DURUM,
        			E.EVRAK
				FROM IKAME_RESIM AS TR
					LEFT JOIN EVRAK AS E ON E.ID = TR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = TR.EKLEYEN_ID
					LEFT JOIN TALEP_IKAME AS T ON T.ID = TR.IKAME_ID
				WHERE TR.IKAME_ID = :IKAME_ID 
					AND TR.DURUM IN(0,1)
					AND E.EVRAK_BOLUM_ID = 4
				ORDER BY TR.DURUM DESC, TR.SIRA
				";
		$filtre[":IKAME_ID"] = $arrRequest['id'];
		
		if($arrRequest['limit'] > 0){
			$sql.=" LIMIT " . $arrRequest['limit'];
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getAracEvraklar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TR.ID,
        			TR.SIRA,
        			TR.RESIM_ADI,
        			TR.EVRAK_ID,
        			CONCAT('arac/', YEAR(A.TARIH), '/', A.ID, '/', TR.RESIM_ADI) AS URL,
        			TR.TARIH,
        			TR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			TR.DURUM,
        			E.EVRAK
				FROM ARAC_RESIM AS TR
					LEFT JOIN EVRAK AS E ON E.ID = TR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = TR.EKLEYEN_ID
					LEFT JOIN ARAC AS A ON A.ID = TR.ARAC_ID
				WHERE TR.ARAC_ID = :ARAC_ID 
					AND TR.DURUM IN(0,1)
					AND TR.EVRAK_ID > 9
				ORDER BY TR.TARIH DESC
				";
		$filtre[":ARAC_ID"] = $arrRequest['id'];
		
		if($arrRequest['limit'] > 0){
			$sql.=" LIMIT " . $arrRequest['limit'];
		}
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getAracGelirGider($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					CH.*,
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
				WHERE CH.PLAKA = :PLAKA AND CH.HAREKET_ID IN(1,3)
				ORDER BY CH.FATURA_TARIH DESC, CH.FATURA_NO DESC			
				";
		$filtre[":PLAKA"] = $arrRequest['plaka'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getAracGelirGiderDetay($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					CH.*,
					IF(CH.HAREKET_ID IN(1,4), -1, 1) * CH.TUTAR AS TUTAR,
					FK.FINANS_KALEMI,
					C.CARI,
					C.KOD,
					C.CARI_KOD,
					CONCAT_WS(' ', K2.AD, K2.SOYAD) AS KAYIT_YAPAN,
					H.HAREKET,
					IF(CH.FATURA_NO = '', CH.ID, CH.FATURA_NO) AS FATURA_NO
					-- DATE_ADD(CH.FATURA_TARIH, INTERVAL C.VADE DAY) AS VADE_TARIH
				FROM CARI_HAREKET_DETAY AS CHD
					LEFT JOIN CARI_HAREKET AS CH ON CH.ID = CHD.CARI_HAREKET_ID
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID	
					LEFT JOIN KULLANICI AS K2 ON K2.ID = CH.KAYIT_YAPAN_ID
					LEFT JOIN HAREKET AS H ON H.ID = CH.HAREKET_ID
				WHERE CHD.PARCA_KODU = :PLAKA AND CH.HAREKET_ID IN(1,3)
				ORDER BY CH.FATURA_TARIH DESC, CH.FATURA_NO DESC			
				";
		$filtre[":PLAKA"] = $arrRequest['plaka'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getAracGelirGiderMasraf($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					CH.*,
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
				WHERE CH.PLAKA = :PLAKA AND CH.HAREKET_ID IN(2,4)
				ORDER BY CH.FATURA_TARIH DESC, CH.FATURA_NO DESC				
				";
		$filtre[":PLAKA"] = $arrRequest['plaka'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getSiteResimler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			GR.ID,
        			GR.SIRA,
        			CONCAT('site/', GR.RESIM_ADI) AS RESIM_URL,
        			GR.TARIH,
        			GR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			GR.DURUM
				FROM SITE_RESIM AS GR
					LEFT JOIN KULLANICI AS K ON K.ID = GR.EKLEYEN_ID
				WHERE GR.DURUM IN(0,1)
				ORDER BY GR.SIRA
				";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getGirisResimler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			GR.ID,
        			GR.SIRA,
        			CONCAT('site/', GR.RESIM_ADI) AS RESIM_URL,
        			GR.TARIH,
        			GR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			GR.DURUM
				FROM GIRIS_RESIM AS GR
					LEFT JOIN KULLANICI AS K ON K.ID = GR.EKLEYEN_ID
				WHERE GR.DURUM IN(0,1)
				ORDER BY GR.SIRA
				";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getTalepNotlari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TN.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN
				FROM TALEP_NOTU AS TN
					LEFT JOIN KULLANICI AS K ON K.ID = TN.KULLANICI_ID
				WHERE TN.TALEP_ID = :TALEP_ID
				ORDER BY TN.TARIH DESC
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getCariNotlari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TN.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN
				FROM CARI_NOTU AS TN
					LEFT JOIN KULLANICI AS K ON K.ID = TN.KULLANICI_ID
				WHERE TN.CARI_ID = :CARI_ID
				ORDER BY TN.TARIH DESC
				";
		$filtre[":CARI_ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getTalepCari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			C.*
				FROM CARI AS C
					INNER JOIN TALEP AS T ON T.CARI_ID = C.ID
				WHERE T.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		return $row;
		
    }
    
    public function getCariHareketCari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			C.*
				FROM CARI AS C
					INNER JOIN CARI_HAREKET AS CH ON CH.CARI_ID = C.ID
				WHERE CH.ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		return $row;
		
    }
    
    public function getKiralamaNotlari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TN.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN
				FROM KIRALAMA_NOTU AS TN
					LEFT JOIN KULLANICI AS K ON K.ID = TN.KULLANICI_ID
				WHERE TN.KIRALAMA_ID = :KIRALAMA_ID
				ORDER BY TN.TARIH DESC
				";
		$filtre[":KIRALAMA_ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getAracNotlari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TN.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN
				FROM ARAC_NOTU AS TN
					LEFT JOIN KULLANICI AS K ON K.ID = TN.KULLANICI_ID
				WHERE TN.ARAC_ID = :ARAC_ID
				ORDER BY TN.TARIH DESC
				";
		$filtre[":ARAC_ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getIkameNotlari($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TN.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN
				FROM IKAME_NOTU AS TN
					LEFT JOIN KULLANICI AS K ON K.ID = TN.KULLANICI_ID
				WHERE TN.IKAME_ID = :IKAME_ID
				ORDER BY TN.TARIH DESC
				";
		$filtre[":IKAME_ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getEksperler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			T.EKSPER,
        			T.EKSPER_MAIL,
        			T.EKSPER_TEL
				FROM TALEP AS T
				WHERE T.EKSPER != ''
				GROUP BY T.EKSPER
				ORDER BY 1 DESC
				";
		//$filtre[":TALEP_ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getTalepYazisma($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TY.*,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN
				FROM TALEP_YAZISMA AS TY
					LEFT JOIN KULLANICI AS K ON K.ID = TY.KULLANICI_ID
				WHERE TY.TALEP_ID = :TALEP_ID
				ORDER BY TY.TARIH DESC
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getTeklifler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			AT.*,
        			CASE
        				WHEN AT.SIGORTA_ID > 0 THEN S.SIGORTA
        				ELSE AT.ACIKLAMA
        			END ACIKLAMA,
        			K.UNVAN AS TEKLIF_VEREN
				FROM ARAC_TEKLIF AS AT
					LEFT JOIN KULLANICI AS K ON K.ID = AT.TEKLIF_VEREN_ID
					LEFT JOIN SIGORTA AS S ON S.ID = AT.SIGORTA_ID
				WHERE TALEP_ID = :TALEP_ID
				ORDER BY AT.TARIH DESC
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getSurecler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			S.ID,
        			S.SUREC
				FROM SUREC AS S
				WHERE S.HIZMET_ID = :HIZMET_ID
				ORDER BY S.SIRA ASC
				";
		$filtre[":HIZMET_ID"] = $arrRequest['hizmet_id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getTalepAnketSorular($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			A.ID,
        			A.ANKET_SORU
				FROM ANKET_SORU AS A
				WHERE A.DURUM = 1
				ORDER BY 2 DESC
				";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getTalepAnketCevaplar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			A.ID,
        			A.ANKET_SORU_ID,
        			A.CEVAP
				FROM ANKET_CEVAP AS A
				WHERE A.TALEP_ID = :TALEP_ID AND A.DURUM = 1
				ORDER BY 2 DESC
				";
		$filtre[":TALEP_ID"] = $arrRequest['id'];
		$rows2 = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows2 as $key => $row){
			$rows[$row->ANKET_SORU_ID]	= $row;
		}
		
		return $rows;
		
    }
    
     public function getTalepCariHareketler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.ID,
        			CH.TALEP_ID,
        			CH.ACIKLAMA,
        			CH.TUTAR
				FROM CARI_HAREKET AS CH
				WHERE CH.TALEP_ID = :ID
				";
		$filtre[":ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getIhaleParcalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			IP.*
				FROM IHALE_PARCA AS IP
				WHERE IP.IHALE_ID = :IHALE_ID
				ORDER BY 1
				";
		$filtre[":IHALE_ID"] = $arrRequest['id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getGirisResim($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			GR.ID,
        			GR.SIRA,
        			CONCAT('site/', GR.RESIM_ADI) AS RESIM_URL,
        			GR.TARIH,
        			GR.RESIM_ADI_ILK,
        			GR.DURUM
				FROM GIRIS_RESIM AS GR
				WHERE GR.DURUM = 1
				";
			
		$row = $this->cdbPDO->row($sql, $filtre);
		return $row;
		
    }
    
    public function getKullaniciResimler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			KR.ID,
        			CONCAT('kullanici/', KR.RESIM_ADI) AS RESIM_URL,
        			KR.TARIH,
        			KR.RESIM_ADI_ILK,
        			KR.DURUM
				FROM KULLANICI AS K
					LEFT JOIN KULLANICI_RESIM AS KR ON KR.KULLANICI_ID = K.ID
				WHERE K.DURUM IN(0,1)
					AND K.ID = :ID
				ORDER BY 1
				";
		$filtre[":ID"] = $arrRequest['id'];
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getKullaniciAdresler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			KA.ADRES_ADI,
        			IL.IL,
        			ILCE.ILCE,
        			KA.ADRES,
        			KA.TARIH
				FROM KULLANICI_ADRES AS KA
					LEFT JOIN IL AS IL ON IL.ID = KA.IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = KA.ILCE_ID
				WHERE KA.KULLANICI_ID = :ID
				ORDER BY 1
				";
		$filtre[":ID"] = $arrRequest['id'];
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getSessionKullaniciResimler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			KR.ID,
        			CONCAT('kullanici/', KR.RESIM_ADI) AS RESIM_URL,
        			KR.TARIH,
        			KR.RESIM_ADI_ILK,
        			KR.DURUM
				FROM KULLANICI AS K
					LEFT JOIN KULLANICI_RESIM AS KR ON KR.KULLANICI_ID = K.ID
				WHERE K.DURUM IN(0,1)
					AND K.ID = :ID
				ORDER BY 1
				";
		$filtre[":ID"] = $_SESSION['kullanici_id'];
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getMesajOkumamisSay($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					COUNT(*) AS TOPLAM
				FROM MESAJ AS M
					LEFT JOIN KULLANICI AS K ON K.ID = M.KIMDEN_ID
					LEFT JOIN KULLANICI AS KK ON KK.ID = M.KIMDEN_ID
				WHERE M.KIME_ID = :KULLANICI_ID AND M.ALICI_DURUM = 1
					AND M.OKUNDU = 0
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		return $row->TOPLAM;
		
    }
    
    public function getMesajGelenSay($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					COUNT(*) AS TOPLAM
				FROM MESAJ AS M
					LEFT JOIN KULLANICI AS K ON K.ID = M.KIMDEN_ID
					LEFT JOIN KULLANICI AS KK ON KK.ID = M.KIMDEN_ID
				WHERE M.KIME_ID = :KULLANICI_ID
					AND M.ALICI_DURUM = 1
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		return $row->TOPLAM;
		
    }
    
    public function getMesajGidenSay($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					COUNT(*) AS TOPLAM
				FROM MESAJ AS M
					LEFT JOIN KULLANICI AS K ON K.ID = M.KIMDEN_ID
					LEFT JOIN KULLANICI AS KK ON KK.ID = M.KIMDEN_ID
				WHERE M.KIMDEN_ID = :KULLANICI_ID 
					AND M.GONDEREN_DURUM = 1
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		return $row->TOPLAM;
		
    }
    
    public function getMesajCopSay($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					COUNT(*) AS TOPLAM
				FROM MESAJ AS M
					LEFT JOIN KULLANICI AS K ON K.ID = M.KIMDEN_ID
					LEFT JOIN KULLANICI AS KK ON KK.ID = M.KIMDEN_ID
				WHERE (M.KIMDEN_ID = :KULLANICI_ID AND M.GONDEREN_DURUM = 0)
					OR (M.KIME_ID = :KULLANICI_ID AND M.ALICI_DURUM = 0)
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		return $row->TOPLAM;
		
    }
    
    public function getMesajGelenOkunmamis($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT('kullanici/', KR.RESIM_ADI) AS KIMDEN_RESIM_URL,
        			CONCAT('/mesaj/oku.do?route=mesaj/oku&id=', M.ID) AS LINK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KIMDEN,
        			CONCAT_WS(' ', KK.AD, KK.SOYAD) AS KIME,
        			IF(TIMESTAMPDIFF(MINUTE, M.TARIH, NOW()) <60, CONCAT_WS(' ',TIMESTAMPDIFF(MINUTE, M.TARIH, NOW()),'dak'), CONCAT_WS(' ',TIMESTAMPDIFF(HOUR, M.TARIH, NOW()),'saat')) AS GECEN_SURE,
					M.*
				FROM MESAJ AS M
					LEFT JOIN KULLANICI AS K ON K.ID = M.KIMDEN_ID
					LEFT JOIN KULLANICI AS KK ON KK.ID = M.KIME_ID
					LEFT JOIN KULLANICI_RESIM AS KR ON KR.KULLANICI_ID = K.ID AND KR.DURUM = 1
				WHERE M.KIME_ID = :KULLANICI_ID AND M.ALICI_DURUM = 1 AND M.OKUNDU = 0
				LIMIT 500
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getMesajGelen($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KIMDEN,
        			CONCAT_WS(' ', KK.AD, KK.SOYAD) AS KIME,
					M.*
				FROM MESAJ AS M
					LEFT JOIN KULLANICI AS K ON K.ID = M.KIMDEN_ID
					LEFT JOIN KULLANICI AS KK ON KK.ID = M.KIME_ID
				WHERE M.KIME_ID = :KULLANICI_ID AND M.ALICI_DURUM = 1
				ORDER BY M.TARIH DESC
				LIMIT 500
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getMesajGiden($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KIMDEN,
        			CONCAT_WS(' ', KK.AD, KK.SOYAD) AS KIME,
        			CASE 
        				WHEN TIMESTAMPDIFF(MINUTE, M.TARIH, NOW()) < 60 THEN CONCAT_WS(' ', TIMESTAMPDIFF(MINUTE, M.TARIH, NOW()),' dak önce')
        				WHEN TIMESTAMPDIFF(HOUR, M.TARIH, NOW()) < 24 THEN CONCAT_WS(' ', TIMESTAMPDIFF(HOUR, M.TARIH, NOW()),' saat önce')
        				ELSE DATE_FORMAT(M.TARIH, '%d.%m.%Y %H:%i') 
        			END AS GECEN_SURE,
					M.*
				FROM MESAJ AS M
					LEFT JOIN KULLANICI AS K ON K.ID = M.KIMDEN_ID
					LEFT JOIN KULLANICI AS KK ON KK.ID = M.KIME_ID
				WHERE M.KIMDEN_ID = :KULLANICI_ID AND M.GONDEREN_DURUM = 1
				ORDER BY M.TARIH DESC
				LIMIT 500
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getMesajCop($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			-- IF(M.KIMDEN_ID = :KULLANICI_ID, CONCAT_WS(' ', KK.AD, KK.SOYAD), CONCAT_WS(' ', K.AD, K.SOYAD)) AS YAZAN,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KIMDEN,
        			CONCAT_WS(' ', KK.AD, KK.SOYAD) AS KIME,
					M.*
				FROM MESAJ AS M
					LEFT JOIN KULLANICI AS K ON K.ID = M.KIMDEN_ID
					LEFT JOIN KULLANICI AS KK ON KK.ID = M.KIME_ID
				WHERE (M.KIMDEN_ID = :KULLANICI_ID AND M.GONDEREN_DURUM = 0)
					OR (M.KIME_ID = :KULLANICI_ID AND M.ALICI_DURUM = 0)
				ORDER BY M.TARIH DESC
				LIMIT 500
				";
		$filtre[":KULLANICI_ID"] = $_SESSION['kullanici_id'];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getMesaj($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS KIMDEN,
        			CONCAT_WS(' ', KK.AD, KK.SOYAD) AS KIME,
					M.*
				FROM MESAJ AS M
					LEFT JOIN KULLANICI AS K ON K.ID = M.KIMDEN_ID
					LEFT JOIN KULLANICI AS KK ON KK.ID = M.KIME_ID
				WHERE M.ID = :ID
				";
		$filtre[":ID"] = $_REQUEST['id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		/*
		$row->ONCEKI_MESAJ_ID 	= $this->cdbPDO->row("SELECT MAX(ID) AS ID FROM MESAJ WHERE ID < :ID", array(":ID"=>$row->ID))->ID;
		$row->SONRAKI_MESAJ_ID	= $this->cdbPDO->row("SELECT MIN(ID) AS ID FROM MESAJ WHERE ID > :ID", array(":ID"=>$row->ID))->ID;
		*/
		return $row;
		
    }
     
    public function getPersoneller($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
					C.*,
					D.DURUM,
					IL.IL,
					ILCE.ILCE,
					IF(C.MAAS_DONEM = 2, 'HAFTALIK', 'AYLIK') AS MAAS_DONEM,
					DE.DEPARTMAN,
					G.GOREV,
					G.PRIM_ORAN
				FROM CARI AS C
					LEFT JOIN MUSTERI_TIPI AS MT ON MT.ID = C.MUSTERI_TIPI
					LEFT JOIN IL AS IL ON IL.ID = C.IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = C.ILCE_ID
					LEFT JOIN DURUM AS D ON D.ID = C.DURUM
					LEFT JOIN DEPARTMAN AS DE ON DE.ID = C.DEPARTMAN_ID
					LEFT JOIN GOREV AS G ON G.ID = C.GOREV_ID
				WHERE C.CARI_TURU = 'PERSONEL' 
					AND C.DURUM = 1
				ORDER BY G.GOREV 
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getKullaniciSayisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			IFNULL(COUNT(*),0) TOPLAM
				FROM KULLANICI AS K
					LEFT JOIN YETKI AS Y ON Y.ID = K.YETKI_ID
					LEFT JOIN KULLANICI_RESIM AS KR ON KR.KULLANICI_ID = K.ID AND KR.DURUM = 1
				WHERE K.YETKI_ID = 3
				";
			
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getSureclerSayisi($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    S.ID,
                    COUNT(I.ID) TOPLAM
                FROM SUREC AS S
                    LEFT JOIN IHALE AS I ON I.SUREC_ID = S.ID
                WHERE 1
                GROUP BY S.ID
                ";
            
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getTalepSurecSayisi($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    T.SUREC_ID AS ID,
                    COUNT(T.ID) TOPLAM,
                    S.SUREC
                FROM TALEP AS T
                	LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
                WHERE 1
                ";
        
        fncSqlTalep($sql, $filtre);
        
        $sql.= " GROUP BY T.SUREC_ID";
        $rows = $this->cdbPDO->rows($sql, $filtre);
       	$rows = arrayIndex($rows);
        
        return $rows;
        
    }
    
    public function getFaturaDurumSayisi($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    CH.FATURA_DURUM_ID AS ID,
                    COUNT(CH.ID) TOPLAM,
                    FD.FATURA_DURUM
                FROM CARI_HAREKET AS CH
                	LEFT JOIN FATURA_DURUM AS FD ON FD.ID = CH.FATURA_DURUM_ID
                	LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
                WHERE 1
                ";
        
        fncSqlCariHareketCari($sql, $filtre);
        
        $sql.= " GROUP BY CH.FATURA_DURUM_ID";
        $rows = $this->cdbPDO->rows($sql, $filtre);
       	$rows = arrayIndex($rows);
        
        return $rows;
        
    }
    
    public function getBugunTeslimEdildi($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    COUNT(T.ID) AS TOPLAM
                FROM TALEP AS T
                WHERE T.TESLIM_TARIH = CURDATE()
                ";
        
         fncSqlTalep($sql, $filtre);
         
        $row = $this->cdbPDO->row($sql, $filtre);
        
        return $row->TOPLAM;
        
    }
    
    public function getYarinTeslimOlacak($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    COUNT(T.ID) AS TOPLAM
                FROM TALEP AS T
                WHERE T.TAHMINI_TESLIM_TARIH = DATE_ADD(CURDATE(), INTERVAL +1 DAY)
                ";
        
        fncSqlTalep($sql, $filtre);
         
        $row = $this->cdbPDO->row($sql, $filtre);
        
        return $row->TOPLAM;
        
    }
    
    public function getMuayeneSon10gun($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    COUNT(A.ID) AS TOPLAM
                FROM ARAC AS A
                WHERE A.MUAYENE_TARIH >= DATE_ADD(CURDATE(), INTERVAL -10 DAY) AND A.MUAYENE_TARIH <= DATE_ADD(CURDATE(), INTERVAL +10 DAY)
                	AND A.DURUM  = 1
                ";
        
        fncSqlArac($sql, $filtre);
         
        $row = $this->cdbPDO->row($sql, $filtre);
        
        return $row->TOPLAM;
        
    }
    
     public function getTrafikSon10gun($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    COUNT(A.ID) AS TOPLAM
                FROM ARAC AS A
                WHERE A.TRAFIK_BIT_TARIH >= DATE_ADD(CURDATE(), INTERVAL -10 DAY) AND A.TRAFIK_BIT_TARIH <= DATE_ADD(CURDATE(), INTERVAL +10 DAY)
                	AND A.DURUM  = 1
                ";
        
        fncSqlArac($sql, $filtre);
        
        $row = $this->cdbPDO->row($sql, $filtre);
        
        return $row->TOPLAM;
        
    }
    
    public function getKaskoSon10gun($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    COUNT(A.ID) AS TOPLAM
                FROM ARAC AS A
                WHERE A.KASKO_BIT_TARIH >= DATE_ADD(CURDATE(), INTERVAL -10 DAY) AND A.KASKO_BIT_TARIH <= DATE_ADD(CURDATE(), INTERVAL +10 DAY)
                	AND A.DURUM  = 1
                ";
        
        fncSqlArac($sql, $filtre);
        
        $row = $this->cdbPDO->row($sql, $filtre);
        
        return $row->TOPLAM;
        
    }
    
    public function getHizmetTalep($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    T.*,
                    C.CARI,
                    S.SUREC,
                    MA.MARKA,
                    MO.MODEL
                FROM TALEP AS T
                	LEFT JOIN CARI AS C ON C.ID = T.CARI_ID
                	LEFT JOIN SUREC AS S ON S.ID = T.SUREC_ID
                	LEFT JOIN MARKA AS MA ON MA.ID = T.MARKA_ID
                	LEFT JOIN MODEL AS MO ON MO.ID = T.MODEL_ID
                WHERE T.GTARIH > DATE_ADD(CURDATE(), INTERVAL -48 HOUR) AND T.SUREC_ID < 10
                ";
        
        fncSqlTalep($sql, $filtre);
        
        $sql.= " ORDER BY T.GTARIH DESC LIMIT 100";
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getVadesiGecmisTop3($arrRequest = array()){
        
        $filtre = array();
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
					AND CH.VADE_TARIH >= DATE_ADD(CURDATE(), INTERVAL -3 DAY) 
					AND CH.VADE_TARIH <= DATE_ADD(CURDATE(), INTERVAL 0 DAY) 
                ";
        
        fncSqlTalep($sql, $filtre);
        
        $sql.= " ORDER BY CH.FATURA_TARIH DESC, CH.TARIH DESC LIMIT 100";
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
        
    }
    
    public function getYetki($arrRequest = array()){
        
        $filtre = array();
        $sql = "SELECT
                    Y.*
                FROM YETKI AS Y
                WHERE 1
                GROUP BY 1
                ";
            
        $rows = $this->cdbPDO->rows($sql, $filtre);
        foreach($rows as $key => $row){
			$arr[$row->ID] = $row;
		}
		
        return $arr;
        
    }
    
    public function getIhaleHazirlaniyorSayisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					COUNT(*) AS TOPLAM
				FROM IHALE AS I
				WHERE I.SUREC_ID = 1
				";
		
		fncSqlYetki($sql, $filtre);
			
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getIhaleKontrolBekliyorSayisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					COUNT(*) AS TOPLAM
				FROM IHALE AS I
				WHERE I.SUREC_ID = 2
				";
		
		fncSqlYetki($sql, $filtre);
			
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getZiyaretSayfaSayisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			COUNT(*) TOPLAM
				FROM KULLANICI_LOG_SAYFA AS KLS
				WHERE 1
				";
			
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }
    
    public function getZiyaretSayfa($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			*
				FROM KULLANICI_LOG_SAYFA AS KLS
				WHERE 1
				";
		
		if($arrRequest['sayfa']){
			$sql.=" AND KLS.SAYFA LIKE :SAYFA";
			$filtre[':SAYFA'] = "%" . $arrRequest['sayfa'] . "%";
		}
		
		if($arrRequest['geldigi_sayfa']){
			$sql.=" AND KLS.GELDIGI_SAYFA LIKE :GELDIGI_SAYFA";
			$filtre[':GELDIGI_SAYFA'] = "%" . $arrRequest['geldigi_sayfa'] . "%";
		}
		
		$sql.=" ORDER BY KLS.TARIH DESC LIMIT 1000";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    } 
    
    public function getAnlikDoviz($arrRequest = array()){
    	
    	$dolar 	= $this->cCurl->Cek("http://www.doviz.com/api/v1/currencies/USD/latest", $postFields, "DOLAR");
    	$euro 	= $this->cCurl->Cek("http://www.doviz.com/api/v1/currencies/EUR/latest", $postFields, "EURO");
    	
    	$sonuc->DOLAR->SATIS 	= $dolar->selling;
    	$sonuc->DOLAR->ALIS 	= $dolar->buying;
    	$sonuc->EURO->SATIS		= $euro->selling;
    	$sonuc->EURO->ALIS		= $euro->buying;
		
		return $sonuc;
		
    }
    
    public function getDoviz($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			D.*
        		FROM DOVIZ AS D
        		ORDER BY D.TARIH 
        		DESC LIMIT 3
				";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		foreach($rows as $key => $row){
			$rows2->{$row->DOVIZ}	= $row;
		}
		
		return $rows2;
		
    }
    
    public function getDovizGecmis($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT 
        			* 
        		FROM DOVIZ 
        		WHERE TARIH >= ADDDATE(CURDATE(), INTERVAL -1 MONTH)
        		ORDER BY TARIH DESC
				";
			
		$rows2 = $this->cdbPDO->rows($sql, $filtre);
		foreach($rows2 as $key => $row2){
			if($row2->DOVIZ == "DOLAR"){
				$rows[$row2->TARIH]->DOLAR_ALIS		= $row2->ALIS;	
				$rows[$row2->TARIH]->DOLAR_SATIS	= $row2->SATIS;	
			} else if($row2->DOVIZ == "EURO"){
				$rows[$row2->TARIH]->EURO_ALIS		= $row2->ALIS;	
				$rows[$row2->TARIH]->EURO_SATIS		= $row2->SATIS;	
			} else if($row2->DOVIZ == "STERLIN"){
				$rows[$row2->TARIH]->STERLIN_ALIS	= $row2->ALIS;	
				$rows[$row2->TARIH]->STERLIN_SATIS	= $row2->SATIS;	
			}
			
		}
		
		return $rows;
		
    }
    
    public function getFislerBugun($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					F.*,
					F.FIS_NO,
					CONCAT_WS(' ', K.AD, K.SOYAD) AS KAYIT_YAPAN,
					(F.TUTAR * (F.KDV / (100 + F.KDV))) AS KDV_TUTAR				
				FROM FIS AS F
					LEFT JOIN KULLANICI AS K ON K.ID = F.KAYIT_YAPAN_ID
				WHERE DATE(F.KAYIT_TARIH) = CURDATE()
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getParaBirimi($arrRequest = array()){
    	
    	$filtre = array();
		$sql = "SELECT
					PB.DOVIZ,
					CONCAT(PB.PARA_BIRIMI, ' - ', IFNULL(D.ALIS,1)) AS PARA_BIRIMI,
					IFNULL(D.ALIS,1) AS ALIS
				FROM PARA_BIRIMI AS PB
					LEFT JOIN (SELECT * FROM DOVIZ ORDER BY TARIH DESC LIMIT 3) AS D ON D.DOVIZ = PB.DOVIZ
				WHERE 1
                ORDER BY LOGO_ID
                ";
			
		$rows = $this->cdbPDO->rows($sql, $filtre);
		foreach($rows as $key => $row){
			$rows2->{$row->DOVIZ}	= $row;
		}
		
		return $rows2;
		
    }
    
    public function getTalepSayisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			COUNT(T.ID) AS SAY
				FROM TALEP AS T
					LEFT JOIN TALEP_SORUMLU AS TS ON TS.TALEP_ID = T.ID
				WHERE 1
				";
		
		fncSqlYetki($sql, $filtre);
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND T.ID = :TALEP_NO";
			$filtre[":TALEP_NO"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":FIRMA_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['arac_gelis_tarih'] AND $_REQUEST['arac_gelis_tarih_var']) {
			$tarih = explode(",", $_REQUEST['arac_gelis_tarih']);	
			$sql.=" AND DATE(T.ARAC_GELIS_TARIH) >= :ARAC_GELIS_TARIH1 AND DATE(T.ARAC_GELIS_TARIH) <= :ARAC_GELIS_TARIH2";
			$filtre[":ARAC_GELIS_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":ARAC_GELIS_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['teslim_edildi_tarih'] AND $_REQUEST['teslim_edildi_tarih_var']) {
			$tarih = explode(",", $_REQUEST['teslim_edildi_tarih']);	
			$sql.=" AND DATE(T.TESLIM_EDILDI_TARIH) >= :TESLIM_EDILDI_TARIH1 AND DATE(T.TESLIM_EDILDI_TARIH) <= :TESLIM_EDILDI_TARIH2";
			$filtre[":TESLIM_EDILDI_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TESLIM_EDILDI_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row->SAY;
    }
    
    public function getTeslimEdildiSayisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			COUNT(T.ID) AS SAY
				FROM TALEP AS T
					LEFT JOIN TALEP_SORUMLU AS TS ON TS.TALEP_ID = T.ID
				WHERE T.SUREC_ID = 10 AND T.TESLIM_EDILDI_TARIH >= DATE_FORMAT(ADDDATE(CURDATE(), INTERVAL -5 MONTH), '%Y-%m-01')
				";
		
		fncSqlYetki($sql, $filtre);
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND T.ID = :TALEP_NO";
			$filtre[":TALEP_NO"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":FIRMA_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['arac_gelis_tarih'] AND $_REQUEST['arac_gelis_tarih_var']) {
			$tarih = explode(",", $_REQUEST['arac_gelis_tarih']);	
			$sql.=" AND DATE(T.ARAC_GELIS_TARIH) >= :ARAC_GELIS_TARIH1 AND DATE(T.ARAC_GELIS_TARIH) <= :ARAC_GELIS_TARIH2";
			$filtre[":ARAC_GELIS_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":ARAC_GELIS_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['teslim_edildi_tarih'] AND $_REQUEST['teslim_edildi_tarih_var']) {
			$tarih = explode(",", $_REQUEST['teslim_edildi_tarih']);	
			$sql.=" AND DATE(T.TESLIM_EDILDI_TARIH) >= :TESLIM_EDILDI_TARIH1 AND DATE(T.TESLIM_EDILDI_TARIH) <= :TESLIM_EDILDI_TARIH2";
			$filtre[":TESLIM_EDILDI_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TESLIM_EDILDI_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row->SAY;
    }
    
    public function getAylikTalepSayisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					YEAR(T.ARAC_GELIS_TARIH) YIL, 
				    MONTH(T.ARAC_GELIS_TARIH) AY,
				    COUNT(*) AS SAY
				FROM TALEP AS T
				WHERE DATE(T.ARAC_GELIS_TARIH) >= DATE_FORMAT(ADDDATE(CURDATE(), INTERVAL -5 MONTH), '%Y-%m-01')
				";
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND T.ID = :TALEP_NO";
			$filtre[":TALEP_NO"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":FIRMA_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['tarih'] AND $_REQUEST['tarih_var']) {
			$tarih = explode(",", $_REQUEST['tarih']);	
			$sql.=" AND DATE(T.TARIH) >= :TARIH1 AND DATE(T.TARIH) <= :TARIH2";
			$filtre[":TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['arac_gelis_tarih'] AND $_REQUEST['arac_gelis_tarih_var']) {
			$tarih = explode(",", $_REQUEST['arac_gelis_tarih']);	
			$sql.=" AND DATE(T.ARAC_GELIS_TARIH) >= :ARAC_GELIS_TARIH1 AND DATE(T.ARAC_GELIS_TARIH) <= :ARAC_GELIS_TARIH2";
			$filtre[":ARAC_GELIS_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":ARAC_GELIS_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['teslim_edildi_tarih'] AND $_REQUEST['teslim_edildi_tarih_var']) {
			$tarih = explode(",", $_REQUEST['teslim_edildi_tarih']);	
			$sql.=" AND DATE(T.TESLIM_EDILDI_TARIH) >= :TESLIM_EDILDI_TARIH1 AND DATE(T.TESLIM_EDILDI_TARIH) <= :TESLIM_EDILDI_TARIH2";
			$filtre[":TESLIM_EDILDI_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TESLIM_EDILDI_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " GROUP BY YEAR(T.ARAC_GELIS_TARIH), MONTH(T.ARAC_GELIS_TARIH)";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getAylikTalepTeslimSayisi($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
					YEAR(T.TESLIM_EDILDI_TARIH) YIL, 
				    MONTH(T.TESLIM_EDILDI_TARIH) AY,
				    COUNT(*) AS SAY
				FROM TALEP AS T
				WHERE DATE(T.TESLIM_EDILDI_TARIH) >= DATE_FORMAT(ADDDATE(CURDATE(), INTERVAL -5 MONTH), '%Y-%m-01')
				";
		
		if($_REQUEST['talep_no']) {
			$sql.=" AND T.ID = :TALEP_NO";
			$filtre[":TALEP_NO"] = $_REQUEST['talep_no'];
		}
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND T.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['cari_id'] > 0) {
			$sql.=" AND T.CARI_ID = :CARI_ID";
			$filtre[":FIRMA_ID"] = $_REQUEST['cari_id'];
		}
		
		if($_REQUEST['arac_gelis_tarih'] AND $_REQUEST['arac_gelis_tarih_var']) {
			$tarih = explode(",", $_REQUEST['arac_gelis_tarih']);	
			$sql.=" AND DATE(T.ARAC_GELIS_TARIH) >= :ARAC_GELIS_TARIH1 AND DATE(T.ARAC_GELIS_TARIH) <= :ARAC_GELIS_TARIH2";
			$filtre[":ARAC_GELIS_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":ARAC_GELIS_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		if($_REQUEST['teslim_edildi_tarih'] AND $_REQUEST['teslim_edildi_tarih_var']) {
			$tarih = explode(",", $_REQUEST['teslim_edildi_tarih']);	
			$sql.=" AND DATE(T.TESLIM_EDILDI_TARIH) >= :TESLIM_EDILDI_TARIH1 AND DATE(T.TESLIM_EDILDI_TARIH) <= :TESLIM_EDILDI_TARIH2";
			$filtre[":TESLIM_EDILDI_TARIH1"] 	= trim(FormatTarih::tre2db(trim($tarih[0])));
			$filtre[":TESLIM_EDILDI_TARIH2"] 	= trim(FormatTarih::tre2db(trim($tarih[1])));
		}
		
		$sql.= " GROUP BY YEAR(T.TESLIM_EDILDI_TARIH), MONTH(T.TESLIM_EDILDI_TARIH)";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariKod($arrRequest = array()){
		$filtre = array();
        $sql = "SELECT
					C.*
				FROM CARI AS C
				WHERE C.KOD = :KOD
				";
		$filtre[":KOD"] = $_REQUEST['kod'];
			
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
	}
	
    public function getKullaniciKod($arrRequest = array()){
		$filtre = array();
        $sql = "SELECT
					CONCAT(K.AD, ' ', K.SOYAD) AS ADSOYAD,
					K.MAIL,
					K.CEPTEL,
					K.ADRES,
					K.KULLANICI
				FROM KULLANICI AS K
				WHERE K.KOD = :KOD
				";
		$filtre[":KOD"] = $_REQUEST['kod'];
			
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
	}
	
	public function getTopluUrunExceller($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			E.ID,
        			CONCAT('excel/', E.EXCEL) AS YOL,
        			E.EXCEL,
        			E.TARIH,
        			E.EXCEL_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS YUKLEYEN
				FROM EXCEL AS E
					LEFT JOIN KULLANICI AS K ON K.ID = E.YUKLEYEN_ID
				WHERE E.DURUM = 1
				ORDER BY E.TARIH
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
	
	public function getGunler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CG.ID,
        			CG.CALISMA_GUN,
        			LPAD(CG.ID,2,0) AS ID2
				FROM CALISMA_GUN AS CG
				WHERE CG.DURUM = 1
				ORDER BY 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getSaatler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CS.ID,
        			CS.CALISMA_SAAT,
        			LPAD(CS.ID,2,0) AS ID2
				FROM CALISMA_SAAT AS CS
				WHERE CS.DURUM = 1
				ORDER BY 1
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
		
    }
    
    public function getGun(){
		$rows[0]->ID	= 1;
		$rows[0]->AD	= "Gün";
		$rows[1]->ID	= 31;
		$rows[1]->AD	= "Ay";
		$rows[2]->ID	= 91;
		$rows[2]->AD	= "3 Ay";
		$rows[3]->ID	= 182;
		$rows[3]->AD	= "6 Ay";
		$rows[4]->ID	= 365;
		$rows[4]->AD	= "Yıl";
		
		return $rows;	
	}
	
	public function getMetre(){
		$rows[0]->BAS	= 0;
		$rows[0]->BIT	= 66;
		$rows[1]->BAS	= 66;
		$rows[1]->BIT	= 76;
		$rows[2]->BAS	= 76;
		$rows[2]->BIT	= 96;
		$rows[3]->BAS	= 96;
		$rows[3]->BIT	= 136;
		$rows[4]->BAS	= 136;
		$rows[4]->BIT	= 266;
		$rows[5]->BAS	= 266;
		$rows[5]->BIT	= 311;
		$rows[6]->BAS	= 311;
		$rows[6]->BIT	= 1000000;
		
		return $rows;	
	}
	
	public function getMusteriArabalar($arrRequest = array()){
		
		$filtre = array();
		$sql = "SELECT 
					A.*,
					MA.MARKA,
					MO.MODEL,
					V.VITES,
					Y.YAKIT,
					ME.MESLEK AS SURUCU_MESLEK
				FROM ARAC AS A
					LEFT JOIN MARKA AS MA ON MA.ID = A.MARKA_ID
					LEFT JOIN MODEL AS MO ON MO.ID = A.MODEL_ID
					LEFT JOIN VITES AS V ON V.ID = A.VITES_ID
					LEFT JOIN YAKIT AS Y ON Y.ID = A.YAKIT_ID
					LEFT JOIN MESLEK AS ME ON ME.ID = A.SURUCU_MESLEK_ID
				WHERE A.MUSTERI_ID = :MUSTERI_ID
				";
				
        $filtre[":MUSTERI_ID"]	= 10; //$_SESSION['musteri_id'];
        $rows = $this->cdbPDO->rows($sql, $filtre);
        
        return $rows;
	}
	
	public function getStokAramaKelimeToplam(){
    	
    	$filtre = array();
        $sql = "SELECT
        			SA.KELIME,
        			COUNT(*) AS SAY
				FROM STOK_ARAMA AS SA
				WHERE 1
				GROUP BY SA.KELIME
				ORDER BY SAY DESC
				LIMIT 10
				";		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
	
	public function getSepetSay(){
    	
    	$filtre = array();
        $sql = "SELECT
        			COUNT(*) AS SAY
				FROM SEPET AS S
				WHERE S.CARI_ID = :CARI_ID
				";
		$filtre[":CARI_ID"] = $_SESSION['cari_id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
	public function getSepet($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			SE.*,
        			SC.CARI,
        			SC.PARA_BIRIM,
        			PM.PARCA_MARKA
				FROM SEPET AS SE
					LEFT JOIN CARI AS SC ON SC.ID = SE.CARI_ID
					LEFT JOIN STOK AS S ON S.ID = SE.STOK_ID
					LEFT JOIN PARCA_MARKA AS PM ON PM.ID = S.PARCA_MARKA_ID
				WHERE SE.CARI_ID = :CARI_ID
				";
				
		$filtre[":CARI_ID"] = $_SESSION['cari_id'];	
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getSepetTumu($arrRequest = array()){
    	
    	if(in_array($_SESSION['yetki_id'], array(3,6))){
			$filtre = array();
	        $sql = "SELECT GROUP_CONCAT(C.ID) AS CARI_IDS FROM CARI AS C WHERE C.TEMSILCI_ID = :TEMSILCI_ID";
			$filtre[":TEMSILCI_ID"] = $_SESSION['kullanici_id'];
			$row_temsilci = $this->cdbPDO->row($sql, $filtre);
		}
    	
    	$filtre = array();
        $sql = "SELECT
        			S.*,
        			SC.CARI
				FROM SEPET AS S
					LEFT JOIN CARI AS SC ON SC.ID = S.CARI_ID
				WHERE 1
				";
		
		if(in_array($_SESSION['yetki_id'], array(3,6)) AND strlen($row_temsilci->CARI_IDS) > 0){
			$sql.= " AND FIND_IN_SET(SC.ID, :CARI_IDS)";
			$filtre[":CARI_IDS"] = $row_temsilci->CARI_IDS;
		}
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariTemsilci(){
    	
    	$filtre = array();
        $sql = "SELECT
        			K.*,
        			CONCAT('kullanici/', KR.RESIM_ADI) AS RESIM_URL
				FROM KULLANICI AS K
					INNER JOIN CARI AS C ON C.TEMSILCI_ID = K.ID
					LEFT JOIN KULLANICI_RESIM AS KR ON KR.KULLANICI_ID = K.ID AND KR.DURUM = 1
				WHERE C.ID = :CARI_ID
				";
		$filtre[":CARI_ID"] = $_SESSION['cari_id'];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getCariSiparisOzet($arrRequest = array()){
    	global $cdbMsql;
    		
    	$filtre = array();
		$sql = "SELECT * FROM LOGO.dbo.B2B_SiparisPaketlemeOzet WHERE CariKod = :CARI_KOD";
		$filtre[":CARI_KOD"]	= $arrRequest['cari_kod'];		
		$row = $cdbMsql->row($sql, $filtre);
		
		return $row;
    }
    
    public function getCariSiparisOzetSorumlu($arrRequest = array()){
    	global $cdbMsql;
    		
    	$filtre = array();
		$sql = "SELECT * FROM LOGO.dbo.B2B_SiparisPaketlemeOzet WHERE 1=1";
		
		if(in_array($_SESSION['yetki_id'],array(3,5))){
			$sql.= " AND Satici = :OZEL_KOD1";
			$filtre[":OZEL_KOD1"]	= $_SESSION['ozel_kod1'];		
		}
		
		$rows = $cdbMsql->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariSiparisPaketlemeDetay($arrRequest = array()){
    	global $cdbMsql;
    		
    	$filtre = array();
		$sql = "SELECT * FROM LOGO.dbo.B2B_SiparisPaketlemeDetay WHERE CariKod = :CARI_KOD";
		$filtre[":CARI_KOD"]	= $arrRequest['cari_kod'];		
		$rows = $cdbMsql->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariBakiye($arrRequest = array()){
    	global $cdbMsql;
    		
    	$filtre = array();
		$sql = "SELECT * FROM LOGO.dbo.B2B_CariBakiye WHERE 1=1";
		
		if(strlen($arrRequest['grup_kod']) > 0){
			$sql.= " AND GrupSirketiKodu = :GRUP_KOD";
			$filtre[":GRUP_KOD"]	= $arrRequest['grup_kod'];			
		} else {
			$sql.= " AND CariKod = :CARI_KOD";
			$filtre[":CARI_KOD"]	= $arrRequest['cari_kod'];		
		}
		
		$rows = $cdbMsql->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariEkstre($arrRequest = array()){
    	global $cdbMsql;
    		
    	$filtre = array();
		$sql = "SELECT * FROM LOGO.dbo.B2B_CariEkstre WHERE 1=1";
		
		if(strlen($arrRequest['grup_kod']) > 0){
			$sql.= " AND GrupSirketiKodu = :GRUP_KOD";
			$filtre[":GRUP_KOD"]	= $arrRequest['grup_kod'];			
		} else {
			$sql.= " AND CariKod = :CARI_KOD";
			$filtre[":CARI_KOD"]	= $arrRequest['cari_kod'];		
		}
		
		$rows = $cdbMsql->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariArsiv($arrRequest = array()){
    	global $cdbMsql;
    		
    	$filtre = array();
		$sql = "SELECT * FROM LOGO.dbo.B2B_DetayliSatisRaporu WHERE 1=1";
		
		if(strlen($arrRequest['grup_kod']) > 0){
			$sql.= " AND GrupSirketiKodu = :GRUP_KOD";
			$filtre[":GRUP_KOD"]	= $arrRequest['grup_kod'];			
		} else {
			$sql.= " AND CariKod = :CARI_KOD";
			$filtre[":CARI_KOD"]	= $arrRequest['cari_kod'];		
		}
		
		$rows = $cdbMsql->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariPaletOzet($arrRequest = array()){
    	global $cdbMsql;
    		
    	$filtre = array();
		$sql = "SELECT * FROM LOGO.dbo.B2B_PaletOzet WHERE 1=1";
		
		if(strlen($arrRequest['grup_kod']) > 0){
			$sql.= " AND GrupSirketiKodu = :GRUP_KOD";
			$filtre[":GRUP_KOD"]	= $arrRequest['grup_kod'];			
		} else {
			$sql.= " AND CariKod = :CARI_KOD";
			$filtre[":CARI_KOD"]	= $arrRequest['cari_kod'];		
		}
		
		$rows = $cdbMsql->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getCariPaletDetay($arrRequest = array()){
    	global $cdbMsql;
    		
    	$filtre = array();
		$sql = "SELECT * FROM LOGO.dbo.B2B_packlistdetay WHERE 1=1";
		
		if(strlen($arrRequest['grup_kod']) > 0){
			$sql.= " AND GroupCode = :GRUP_KOD";
			$filtre[":GRUP_KOD"]	= $arrRequest['grup_kod'];			
		} else {
			$sql.= " AND arpCode = :CARI_KOD";
			$filtre[":CARI_KOD"]	= $arrRequest['cari_kod'];		
		}
		//var_dump2($cdbMsql->getSQL($sql, $filtre));
		$rows = $cdbMsql->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getSiparisler10($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			CH.*,
        			C.CARI,
        			C.CARI_KOD,
        			OK.ODEME_KANALI,
        			OKD.ODEME_KANALI_DETAY,
        			H.HAREKET,
        			FK.KDV,
        			FD.FATURA_DURUM
				FROM CARI_HAREKET AS CH
					LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					LEFT JOIN HAREKET AS H ON H.ID = CH.HAREKET_ID
					LEFT JOIN ODEME_KANALI AS OK ON OK.ID = CH.ODEME_KANALI_ID
					LEFT JOIN ODEME_KANALI_DETAY AS OKD ON OKD.ID = CH.ODEME_KANALI_DETAY_ID
					LEFT JOIN FINANS_KALEMI AS FK ON FK.ID = CH.FINANS_KALEMI_ID
					LEFT JOIN FATURA_DURUM AS FD ON FD.ID = CH.FATURA_DURUM_ID
				WHERE CH.CARI_ID = :CARI_ID
				ORDER BY CH.ID DESC
				LIMIT 10
				";
		$filtre[":CARI_ID"] = $_SESSION['cari_id'];	
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getExceller($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			E.ID,
        			CONCAT('excel/', YEAR(E.TARIH), '/', LPAD(MONTH(E.TARIH),2,0), '/', E.EXCEL) AS URL,
        			E.EXCEL,
        			E.TARIH,
        			E.CALISMA_TARIH,
        			E.EXCEL_ILK,
        			E.TUR,
        			E.SAY,
        			E.KOD,
        			E.ONAY,
        			E.ONAY_TARIH,
        			E.ACIKLAMA,
        			E.LISTE_KAR_ORANI,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS YUKLEYEN,
        			CONCAT_WS(' ', K2.AD, K2.SOYAD) AS ONAYLAYAN,
        			PT.PARCA_TIPI,
        			TC.CARI AS TEDARIKCI
				FROM EXCEL AS E
					LEFT JOIN KULLANICI AS K ON K.ID = E.YUKLEYEN_ID
					LEFT JOIN KULLANICI AS K2 ON K2.ID = E.ONAYLAYAN_ID
					LEFT JOIN PARCA_TIPI AS PT ON PT.ID = E.PARCA_TIPI_ID
					LEFT JOIN CARI AS TC ON TC.ID = E.TEDARIKCI_ID
				WHERE E.DURUM = 1
				";
				
		
		$sql.=" ORDER BY E.TARIH DESC
				LIMIT 100";
				
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getStokParcalar($arrRequest = array()){
    	
    	$filtre	= array();
		$sql = "SELECT 
					S.*,
					CONCAT_WS('_',S.KODU,S.OEM_KODU) AS ID
				FROM STOK AS S
				WHERE 1
				";
		//$filtre[":TEDARIKCI_ID"] 	= $arrRequest['tedarikci_id'];
		
		$rows2 = $this->cdbPDO->rows($sql, $filtre); 
		$rows = arrayIndex($rows2);
		
		return $rows;
		
    }
    
    public function getParcaMarkalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			PM.PARCA_MARKA AS ID,
        			PM.ID AS PARCA_MARKA_ID,
        			PM.PARCA_MARKA
				FROM PARCA_MARKA AS PM
				WHERE 1
				ORDER BY PM.PARCA_MARKA ASC
				";
				
		$rows2 = $this->cdbPDO->rows($sql, $filtre);
		$rows = arrayIndex($rows2);
		
		return $rows;
		
    }
    
    public function getParcaMarkalar2($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			PM.*
				FROM PARCA_MARKA AS PM
				WHERE 1
				ORDER BY PM.PARCA_MARKA ASC
				";
				
		$rows2 = $this->cdbPDO->rows($sql, $filtre);
		$rows = arrayIndex($rows2);
		
		return $rows;
		
    }
    
    public function getAracMarkalar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			MA.MARKA AS ID,
        			MA.ID AS MARKA_ID,
        			MA.MARKA
				FROM MARKA AS MA
				WHERE 1
				ORDER BY MA.MARKA ASC
				";
				
		$rows2 = $this->cdbPDO->rows($sql, $filtre);
		$rows = arrayIndex($rows2);
		
		return $rows;
		
    }
    
    public function getBanka($arrRequest = array()){
    	
    	$filtre = array();
		$sql = "SELECT
        			B.*
				FROM BANKA AS B
				WHERE B.ID = :ID
                ";		
        $filtre[":ID"] = $arrRequest['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
		
    }

    public function getBannerParcalar($arrRequest = array()){
    	
    	$filtre = array();
		$sql = "SELECT
        			S.*,
        			S.STOK AS AD,
        			S.KODU AS KODU,
        			M.MARKA AS MARKA
				FROM STOK AS S
					LEFT JOIN MARKA AS M ON M.ID = S.PARCA_MARKA_ID
				WHERE 1 AND S.PARCA_MARKA_ID = :ID
                ";		
        
		$filtre[":ID"]	 	= $arrRequest["id"];
		if($_REQUEST['oem_kodu']) {
			$sql.=" AND S.OEM_KODU LIKE :OEM_KODU";
			$filtre[":OEM_KODU"] = "%" . $_REQUEST['oem_kodu'] . "%";
		}

		if($_REQUEST['kodu']) {
			$sql.=" AND S.KODU LIKE :KODU";
			$filtre[":KODU"] = "%" . $_REQUEST['kodu'] . "%";
		}

		if($_REQUEST['stok']) {
			$sql.=" AND S.STOK LIKE :STOK";
			$filtre[":STOK"] = "%" . $_REQUEST['stok'] . "%";
		}

		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
    public function getStok($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			S.*,
        			K.KATEGORI,
        			CONCAT('stok/',YEAR(SR.TARIH),'/',SR.STOK_ID,'/',SR.RESIM_ADI) AS URL
				FROM STOK AS S
					LEFT JOIN KATEGORI AS K ON K.ID = S.KATEGORI_ID
					LEFT JOIN STOK_RESIM AS SR ON SR.STOK_ID = S.ID AND SR.SIRA = 1
				WHERE 1
				";
		
		if($arrRequest["kodu"]){
			$sql.= " AND S.KODU = :KODU";
			$filtre[":KODU"]	 = $arrRequest["kodu"];
		} else {
			$sql.= " AND S.ID = :ID";
			$filtre[":ID"]	 	= $arrRequest["id"];
		}
		
		$row = $this->cdbPDO->row($sql, $filtre);
		
		return $row;
    }
    
    public function getStokResimler($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			TR.ID,
        			TR.SIRA,
        			TR.RESIM_ADI,
        			TR.EVRAK_ID,
        			TR.RESIM_ACIKLAMA,
        			CONCAT('stok/', YEAR(S.TARIH), '/',TR.STOK_ID,'/', TR.RESIM_ADI) AS URL,
        			TR.TARIH,
        			TR.RESIM_ADI_ILK,
        			CONCAT_WS(' ', K.AD, K.SOYAD) AS EKLEYEN,
        			TR.DURUM,
        			E.EVRAK
				FROM STOK_RESIM AS TR
					LEFT JOIN EVRAK AS E ON E.ID = TR.EVRAK_ID
					LEFT JOIN KULLANICI AS K ON K.ID = TR.EKLEYEN_ID
					LEFT JOIN STOK AS S ON S.ID = TR.STOK_ID
				WHERE TR.STOK_ID = :STOK_ID 
				ORDER BY TR.DURUM DESC, TR.SIRA
				";
		$filtre[":STOK_ID"] = $arrRequest['id'];
		
		//echo $this->cdbPDO->getSQL($sql, $filtre);
		$rows = $this->cdbPDO->rows($sql, $filtre);
		return $rows;
		
    }
    
    public function getStokKataloglar($arrRequest = array()){
    	
    	$filtre = array();
        $sql = "SELECT
        			SK.STOK_KATALOG_ID,
        			SK.STOK_ID,
        			K.*
				FROM STOK_KATALOG AS SK
					INNER JOIN KATALOG AS K ON K.ID = SK.STOK_KATALOG_ID
					LEFT JOIN STOK AS S ON S.ID = SK.STOK_ID
				WHERE 1
				
				";
		if($arrRequest["kodu"]){
			$sql.= " AND S.KODU = :KODU";
			$filtre[":KODU"]	 = $arrRequest["kodu"];
		} else {
			$sql.= " AND SK.STOK_ID = :ID";
			$filtre[":ID"]	 	= $arrRequest["id"];
		}
		
		$sql.= " ORDER BY K.MARKA, K.MODEL, K.MODEL_TIPI, K.YIL_BAS, K.YIL_BIT";
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		return $rows;
    }
    
}