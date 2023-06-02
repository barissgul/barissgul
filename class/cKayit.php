<?
ini_set('max_input_vars', 5000);
error_reporting(1);
class dbKayit {
	private $cdbPDO;
	private $cMail;
	private $cSms;
	private $cSubData;
	private $cCurl;
	private $cSabit;
	private $rSite;
	private $cEntegrasyon;
	private $cSimpleImage;
	
	function __construct() {
		global $cdbPDO, $cMail, $cSms, $cSubData, $cCurl, $cSabit, $row_site, $cEntegrasyon, $cSimpleImage;
		$this->cdbPDO 		= $cdbPDO;
		$this->cMail 		= $cMail;
		$this->cSms 		= $cSms;
		$this->cSubData 	= $cSubData;
		$this->cCurl 		= $cCurl;
		$this->cSabit 		= $cSabit;
		$this->rSite 		= $row_site;
		$this->cEntegrasyon	= $cEntegrasyon;
		$this->cSimpleImage	= $cSimpleImage;
		
	}
	
	// $this->fncIslemLog($ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "TABLE", "SAYFA");
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
		$filtre[":KULLANICI"] 	= $_SESSION['kullanici'];
		$filtre[":SORGU"] 		= $SORGU;
		$filtre[":ROW_JSON"] 	= $ROW_JSON;
		$this->cdbPDO->rowsCount($sql, $filtre);
		
	}
	
	function gunluk_kasa_mail_gonder(){
		
		$rows_kasa		= $this->cSubData->getKasalar($_REQUEST);
		
		$icerik =  '<style>
						html, body, table {
						    font-family: "Times New Roman", Times, serif;
						    font-size: 10px;
						}
						#customers {
						  font-family: "Times New Roman", Times, serif;
						  border-collapse: collapse;
						  width: 100%;
						}

						#customers td, #customers td {
						  border: 1px solid #ddd;
						  padding: 8px;
						}

						#customers tbody tr:nth-child(even){background-color: #f2f2f2;}

						#customers tbody tr:hover {background-color: #ddd;}

						#customers thead td {
						  padding-top: 3px;
						  padding-bottom: 3px;
						  background-color: #4CAF50;
						  color: white;
						}
					</style>
					<table id="customers">
						<thead>
							<tr>
								<td colspan="5" align="center"> <b> KASALAR </b> </td>
							</tr>
					  		<tr>
								<td align="left"> <b> Ödeme Kanalı </b> </td>
								<td align="left"> <b> Kasa </b> </td>
								<td align="right"> <b> Tahsilat </b> </td>
								<td align="right"> <b> Tediye </b> </td>
								<td align="right"> <b> Bakiye </b> </td>
							</tr>
						</thead>
						<tbody>';
					  		
		foreach($rows_kasa as $key => $row_kasa){
			$row_kasa_toplam->TAHSILAT 	+= $row_kasa->TAHSILAT;
			$row_kasa_toplam->TEDIYE 	+= $row_kasa->TEDIYE;
			$row_kasa_toplam->BAKIYE 	+= $row_kasa->BAKIYE;
			
			$icerik.=  '<tr>
							<td align="left"> '. $row_kasa->ODEME_KANALI .' </td>
							<td align="left"> '. $row_kasa->ODEME_KANALI_DETAY .' </td>
							<td align="right"> '. FormatSayi::sayi($row_kasa->TAHSILAT) .' </td>
							<td align="right"> '. FormatSayi::sayi($row_kasa->TEDIYE) .' </td>
							<td align="right"> '. FormatSayi::sayi($row_kasa->BAKIYE) .' </td>
						</tr>';
		}
		
		$icerik.=  '</tbody>
						<tfoot>
							<tr>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="right"> '. FormatSayi::sayi($row_kasa_toplam->TAHSILAT,2) .' </td>
								<td align="right"> '. FormatSayi::sayi($row_kasa_toplam->TEDIYE,2) .' </td>
								<td align="right"> '. FormatSayi::sayi($row_kasa_toplam->BAKIYE,2) .' </td>
							</tr>
						</tfoot>
					</table>';
		$icerik.=  '<br><br>';
		
		$rows_tahsilat 	= $this->cSubData->getGunlukTahsilat($_REQUEST);
		$icerik.=  '<table id="customers">
						<thead>
							<tr>
								<td colspan="8" align="center"> <b> TAHSİLATLAR </b> </td>
							</tr>
							<tr class="bg-primary-gradient">
								<td align="center"> <b> İşlem No </b> </td>
								<td> <b> Cari </b> </td>
								<td> <b> Plaka </b> </td>
								<td align="center"> <b> Tarih </b> </td>
								<td> <b> Ödeme Kanalı </b> </td>
								<td> <b> Açıklama </b> </td>
								<td align="center"> <b> Kayıt Tarih </b> </td>
								<td align="right"> <b> Tutar </b> </td>
							</tr>
						</thead>
						<tbody>';
		foreach($rows_tahsilat as $key => $row_tahsilat){
			$row_tahsilat_toplam->TUTAR += $row_tahsilat->TUTAR;
			$icerik.=  '<tr>
							<td align="center">'. $row_tahsilat->ID .' </td>
							<td> '. $row_tahsilat->CARI .' </td>
							<td> '. $row_tahsilat->PLAKA .' </td>
							<td align="center"> '. FormatTarih::tarih($row_tahsilat->FATURA_TARIH) .' </td>
							<td> '. $row_tahsilat->ODEME_KANALI_DETAY .' </a> </td>
							<td> '. $row_tahsilat->ACIKLAMA .' </td>
							<td align="center"> '. FormatTarih::tarih($row_tahsilat->TARIH) .' </td>
							<td align="right"> '. FormatSayi::sayi($row_tahsilat->TUTAR,2) .' </td>
						</tr>';
		}		
		$icerik.=  '</tbody>
						<tfoot>
							<tr>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="right"> '. FormatSayi::sayi($row_tahsilat_toplam->TUTAR,2) .' </td>
							</tr>
						</tfoot>
					</table>';
		
		$rows_tediye	= $this->cSubData->getGunlukTediye($_REQUEST);
		$icerik.=  '<table id="customers">
						<thead>
							<tr>
								<td colspan="8" align="center"> <b> TEDİYELER </b> </td>
							</tr>
					  		<tr class="bg-primary-gradient">
								<td align="center"> <b> İşlem No </b> </td>
								<td> <b> Cari </b> </td>
								<td> <b> Plaka </b> </td>
								<td align="center"> <b> Tarih </b> </td>
								<td> <b> Ödeme Kanalı </b> </td>
								<td> <b> Açıklama </b> </td>
								<td align="center"> <b> Kayıt Tarih </b> </td>
								<td align="right"> <b> Tutar </b> </td>
							</tr>
						</thead>
						<tbody>';
		foreach($rows_tediye as $key => $row_tediye){
			$row_tediye_toplam->TUTAR += $row_tediye->TUTAR;
			$icerik.=  '<tr>
							<td align="center">'. $row_tediye->ID .' </td>
							<td> '. $row_tediye->CARI .' </td>
							<td> '. $row_tediye->PLAKA .' </td>
							<td align="center"> '. FormatTarih::tarih($row_tediye->FATURA_TARIH) .' </td>
							<td> '. $row_tediye->ODEME_KANALI_DETAY .' </a> </td>
							<td> '. $row_tediye->ACIKLAMA .' </td>
							<td align="center" nowrap> '. FormatTarih::tarih($row_tediye->TARIH).' </td>
							<td align="right"> '. FormatSayi::sayi($row_tediye->TUTAR,2) .' </td>
						</tr>';
		}
		$icerik.=  '</tbody>
						<tfoot>
							<tr>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="left"> </td>
								<td align="right"> '. FormatSayi::sayi($row_tediye_toplam->TUTAR,2) .' </td>
							</tr>
						</tfoot>
					</table>';
							  	
		//$cMail->Gonder(, "CRON_IHALEYI_BITIR" . date("Y-m-d H:i:s"), implode(',', $arr));
		$this->cMail->Gonder("baris@boryaz.com", $_REQUEST["tarih"] . " Kasa", $icerik);
		// 
		
		$sonuc["HATA"] 		= FALSE;
		$sonuc["ACIKLAMA"] 	= "Mail Gönderildi.";
		return $sonuc;
			
	}
	
	function ceza_sorgulama_doldur() {
		$filtre	= array();
		$sql = "SELECT *,
					CONCAT_WS(' / ', IL.IL, ILCE.ILCE) AS IL_ILCE,
					CASE CS.ODEME_DURUMU
        				WHEN 0 THEN 'Ödenmedi'
        				ELSE 'Ödendi'
        			END AS ODEME_DURUMU_STRING
				FROM CEZA_SORGULAMA AS CS
					LEFT JOIN IL AS IL ON IL.ID = CS.IL_ID
					LEFT JOIN ILCE AS ILCE ON ILCE.ID = CS.ILCE_ID
				WHERE CS.ID = :ID
				";
		$filtre[":ID"] 		= $_REQUEST["id"];
		
		$row = $this->cdbPDO->row($sql, $filtre);
		
        
        if(count($row)>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["SORGU"] 	= $row;
			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
        return $sonuc;
        
	}
	
	public function talep_mail_gonder() {
		if(1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= dil("Kapatıldı.");
		 	return $sonuc;
		}
		
		$result = fncTalepMailGonder($_REQUEST['id']);
        
        $sonuc["HATA"] 		= FALSE;
		$sonuc["ACIKLAMA"] 	= dil("Talep Mail Gönderildi.");
		
        return $sonuc;
        
	}
	
	public function ceza_sorgulama_ekle(){
		$filtre	= array();
		$sql = "INSERT INTO CEZA_SORGULAMA SET 	PLAKA	 			= :PLAKA,
												TUTANAK_SERI_NO 	= :TUTANAK_SERI_NO,
												TUTANAK_SIRA_NO		= :TUTANAK_SIRA_NO,
												CEZA_MADDESI	 	= :CEZA_MADDESI,
												CEZA_TUTARI		 	= :CEZA_TUTARI,
												KESILDIGI_YER		= :KESILDIGI_YER,
												CEZA_TARIHI			= :CEZA_TARIHI,
												DUZENLEYEN_BIRIM	= :DUZENLEYEN_BIRIM,
												IL_ID				= :IL_ID,
												ILCE_ID				= :ILCE_ID,
												TEBLIG_TARIHI		= :TEBLIG_TARIHI,
												UNVAN				= :UNVAN,
												VERGI_NO			= :VERGI_NO,
												ODEME_DURUMU		= :ODEME_DURUMU,
												ODEME_TARIHI		= :ODEME_TARIHI,
												KAYIT_YAPAN_ID		= :KULLANICI_ID,
												TARIH				= NOW()
											";
		$filtre[":PLAKA"] 				= $_REQUEST["plaka"];
		$filtre[":TUTANAK_SERI_NO"] 	= $_REQUEST["tutanak_seri_no"];
		$filtre[":TUTANAK_SIRA_NO"] 	= $_REQUEST["tutanak_sira_no"];
		$filtre[":CEZA_MADDESI"] 		= $_REQUEST["ceza_maddesi"];
		$filtre[":CEZA_TUTARI"] 		= $_REQUEST["ceza_tutari"];
		$filtre[":KESILDIGI_YER"] 		= $_REQUEST["kesildigi_yer"];
		$filtre[":CEZA_TARIHI"] 		= $_REQUEST["ceza_tarihi"] . " " . $_REQUEST["ceza_saati"];
		$filtre[":DUZENLEYEN_BIRIM"]	= $_REQUEST["duzenleyen_birim"];
		$filtre[":IL_ID"]				= $_REQUEST["il_id"];
		$filtre[":ILCE_ID"] 			= $_REQUEST["ilce_id"];
		$filtre[":TEBLIG_TARIHI"] 		= $_REQUEST["teblig_tarihi"];
		$filtre[":UNVAN"] 				= $_REQUEST["unvan"];
		$filtre[":VERGI_NO"] 			= $_REQUEST["vergi_no"];
		$filtre[":ODEME_DURUMU"] 		= $_REQUEST["odeme_durumu"];
		$filtre[":ODEME_TARIHI"] 		= $_REQUEST["odeme_tarihi"];
		$filtre[":KULLANICI_ID"] 		= $_SESSION["kullanici_id"];
		
		$CEZA_SORGULAMA_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		if($CEZA_SORGULAMA_ID>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function ceza_sorgulama_sil(){
		$filtre	= array();
		$sql = "DELETE FROM CEZA_SORGULAMA WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	
	public function talep_randevu_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		if($_REQUEST["randevu_tarih"] == ""){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Randevu tarihi seçiniz!";	
			return $sonuc;
		}
		
		if(!preg_match('/^[A-Za-z0-9]{3,20}$/', $_REQUEST["plaka"])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Plaka sadece harf ve rakamlardan oluşmalı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP WHERE PLAKA = :PLAKA AND ID != :ID AND SUREC_ID < 10";
		$filtre[":PLAKA"] 	= trim($_REQUEST["plaka"]);
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row_ayni = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_ayni->ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Daha önceki bu plaka randevu verilmiş!";	
			return $sonuc;
		}
		
		if(is_null($row->ID)){
			
			$filtre	= array();
			$sql = "INSERT INTO TALEP SET	SUREC_ID			= 1,
											PLAKA 				= :PLAKA,
											SERVIS_BOLUM		= 'HASAR',
											RANDEVU_TARIH		= :RANDEVU_TARIH,
											RANDEVU_SAAT 		= :RANDEVU_SAAT,
											RANDEVU_ACIKLAMA	= :RANDEVU_ACIKLAMA,
											EKLEYEN_ID			= :EKLEYEN_ID,
											TARIH 				= NOW(),
											KOD					= MD5(NOW()),
											GTARIH				= NOW()
											";
			$filtre[":PLAKA"] 				= trim(strtoupper($_REQUEST["plaka"]));
			$filtre[":RANDEVU_TARIH"]		= FormatTarih::nokta2db($_REQUEST["randevu_tarih"]);
			$filtre[":RANDEVU_SAAT"] 		= $_REQUEST["randevu_saat"];
			$filtre[":RANDEVU_ACIKLAMA"]	= trim($_REQUEST["randevu_aciklama"]);
			$filtre[":EKLEYEN_ID"] 			= $_SESSION["kullanici_id"];
			$TALEP_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
			
			$filtre	= array();
			$sql = "SELECT ID, KOD FROM TALEP WHERE ID = :ID";
			$filtre[":ID"] 		= $TALEP_ID;
			$row = $this->cdbPDO->row($sql, $filtre);
			
		} else {
			
			if($_REQUEST["kod"] != $row->KOD){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE TALEP SET	PLAKA 				= :PLAKA,
										RANDEVU_TARIH		= :RANDEVU_TARIH,
										RANDEVU_SAAT 		= :RANDEVU_SAAT,
										RANDEVU_ACIKLAMA	= :RANDEVU_ACIKLAMA,
										GTARIH 				= NOW()
									WHERE ID = :ID
									";
			$filtre[":PLAKA"] 				= trim(strtoupper($_REQUEST["plaka"]));			
			$filtre[":RANDEVU_TARIH"]		= FormatTarih::nokta2db($_REQUEST["randevu_tarih"]);
			$filtre[":RANDEVU_SAAT"] 		= $_REQUEST["randevu_saat"];
			$filtre[":RANDEVU_ACIKLAMA"]	= trim($_REQUEST["randevu_aciklama"]);
			$filtre[":ID"] 					= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		}
		
		if($row->ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["URL"] 		= "/talep/talep.do?route=talep/talep_listesi&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function arac_kaydet(){
		
		if(strlen($_REQUEST["sahibi_tck"]) < 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ruhsat Sahibi TCK / VKN giriniz!";
			return $sonuc;
		}	
		
		if(strlen($_REQUEST["sahibi_ad"]) < 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ruhsat Sahibi Ad giriniz!";
			return $sonuc;
		}	
		
		if(strlen($_REQUEST["sahibi_soyad"]) < 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ruhsat Sahibi Soyad giriniz!";
			return $sonuc;
		}	
		
		if(strlen($_REQUEST["plaka"]) < 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Plaka giriniz!";
			return $sonuc;
		}
		
		if($_REQUEST["marka_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Marka seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["model_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Model seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["model_yili"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Model Yılı seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["segment"] == -1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Segment seçiniz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["trafik_bit_tarih"]) != 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Trafiik Bitiş tarihi seçiniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM ARAC WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			
			$filtre	= array();
			$sql = "SELECT ID, PLAKA FROM ARAC WHERE PLAKA = :PLAKA";
			$filtre[":PLAKA"] 		= trim($_REQUEST["plaka"]);
			$row_ayni = $this->cdbPDO->row($sql, $filtre);
			
			if($row_ayni->ID > 0){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= $row->PLAKA . " araç listenizde zaten kayıtlı!";
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "INSERT INTO ARAC SET	PLAKA 				= :PLAKA,
											MARKA_ID			= :MARKA_ID,
											MODEL_ID 			= :MODEL_ID,
											MODEL_YILI 			= :MODEL_YILI,
											SEGMENT				= :SEGMENT,
											YAKIT_ID			= :YAKIT_ID,
											VITES_ID 			= :VITES_ID,
											SASI_NO 			= :SASI_NO,
											MOTOR_NO 			= :MOTOR_NO,
											SON_KM				= :SON_KM,
											MUAYENE_TARIH		= :MUAYENE_TARIH,
											TRAFIK_BIT_TARIH	= :TRAFIK_BIT_TARIH,
											KASKO_BIT_TARIH		= :KASKO_BIT_TARIH,
											RUHSAT_SERI_NO		= :RUHSAT_SERI_NO,
											RUHSAT_SIRA_NO		= :RUHSAT_SIRA_NO,
											SAHIBI_TCK			= :SAHIBI_TCK,
											SAHIBI_AD			= :SAHIBI_AD,
											SAHIBI_SOYAD		= :SAHIBI_SOYAD,
											SAHIBI_MESLEK_ID	= :SAHIBI_MESLEK_ID,
											SAHIBI_TEL			= :SAHIBI_TEL,
											SAHIBI_CEPTEL		= :SAHIBI_CEPTEL,
											SAHIBI_MAIL			= :SAHIBI_MAIL,
											SAHIBI_IL_ID		= :SAHIBI_IL_ID,
											SAHIBI_ILCE_ID		= :SAHIBI_ILCE_ID,
											SAHIBI_ADRES		= :SAHIBI_ADRES,
											EKLEYEN_ID			= :EKLEYEN_ID,
											YEDEK_ANAHTAR		= :YEDEK_ANAHTAR,
											LASTIK_EBAT_ID		= :LASTIK_EBAT_ID,
											LASTIK_MARKA_ID		= :LASTIK_MARKA_ID,
											LASTIK				= :LASTIK,
											RENK_ID				= :RENK_ID,
											DURUM				= :DURUM,
											TARIH 				= NOW(),
											KOD					= MD5(NOW())
											";
			$filtre[":PLAKA"] 				= trim($_REQUEST["plaka"]);
			$filtre[":MARKA_ID"] 			= $_REQUEST["marka_id"];
			$filtre[":MODEL_ID"]			= $_REQUEST["model_id"];
			$filtre[":MODEL_YILI"]			= $_REQUEST["model_yili"];
			$filtre[":SEGMENT"]				= $_REQUEST["segment"];
			$filtre[":YAKIT_ID"]			= $_REQUEST["yakit_id"];
			$filtre[":VITES_ID"]			= $_REQUEST["vites_id"];
			$filtre[":SASI_NO"]				= trim($_REQUEST["sasi_no"]);
			$filtre[":MOTOR_NO"]			= trim($_REQUEST["motor_no"]);
			$filtre[":SON_KM"]				= FormatSayi::sayi2db($_REQUEST["son_km"]);
			$filtre[":MUAYENE_TARIH"]		= FormatTarih::nokta2db($_REQUEST["muayene_tarih"]);
			$filtre[":TRAFIK_BIT_TARIH"]	= FormatTarih::nokta2db($_REQUEST["trafik_bit_tarih"]);
			$filtre[":KASKO_BIT_TARIH"]		= FormatTarih::nokta2db($_REQUEST["kasko_bit_tarih"]);
			$filtre[":RUHSAT_SERI_NO"]		= $_REQUEST["ruhsat_seri_no"];
			$filtre[":RUHSAT_SIRA_NO"]		= $_REQUEST["ruhsat_sira_no"];
			$filtre[":SAHIBI_TCK"]			= $_REQUEST["sahibi_tck"];
			$filtre[":SAHIBI_AD"]			= $_REQUEST["sahibi_ad"];
			$filtre[":SAHIBI_SOYAD"]		= $_REQUEST["sahibi_soyad"];
			$filtre[":SAHIBI_MESLEK_ID"]	= $_REQUEST["sahibi_meslek_id"];
			$filtre[":SAHIBI_TEL"]			= $_REQUEST["sahibi_tel"];
			$filtre[":SAHIBI_CEPTEL"]		= $_REQUEST["sahibi_ceptel"];
			$filtre[":SAHIBI_MAIL"]			= $_REQUEST["sahibi_mail"];
			$filtre[":SAHIBI_IL_ID"]		= $_REQUEST["sahibi_il_id"];
			$filtre[":SAHIBI_ILCE_ID"]		= $_REQUEST["sahibi_ilce_id"];
			$filtre[":SAHIBI_ADRES"]		= $_REQUEST["sahibi_adres"];
			$filtre[":EKLEYEN_ID"] 			= $_SESSION["kullanici_id"];
			$filtre[":YEDEK_ANAHTAR"]		= $_REQUEST["yedek_anahtar"];
			$filtre[":LASTIK_EBAT_ID"]		= $_REQUEST["lastik_ebat_id"];
			$filtre[":LASTIK_MARKA_ID"]		= $_REQUEST["lastik_marka_id"];
			$filtre[":LASTIK"]				= $_REQUEST["lastik"];
			$filtre[":RENK_ID"]				= $_REQUEST["renk_id"];
			$filtre[":DURUM"] 				= $_REQUEST["durum"] ? 1 : 0;
			$ARAC_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
			
			$filtre	= array();
			$sql = "SELECT ID, KOD FROM ARAC WHERE ID = :ID";
			$filtre[":ID"] 		= $ARAC_ID;
			$row = $this->cdbPDO->row($sql, $filtre);
			
		} else {
			
			if($_REQUEST["kod"] != $row->KOD){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE ARAC SET		PLAKA 				= :PLAKA,
										MARKA_ID			= :MARKA_ID,
										MODEL_ID 			= :MODEL_ID,
										MODEL_YILI 			= :MODEL_YILI,
										SEGMENT				= :SEGMENT,
										YAKIT_ID			= :YAKIT_ID,
										VITES_ID 			= :VITES_ID,
										SASI_NO 			= :SASI_NO,
										MOTOR_NO 			= :MOTOR_NO,
										SON_KM				= :SON_KM,
										MUAYENE_TARIH		= :MUAYENE_TARIH,
										TRAFIK_BIT_TARIH	= :TRAFIK_BIT_TARIH,
										KASKO_BIT_TARIH		= :KASKO_BIT_TARIH,										
										RUHSAT_SERI_NO		= :RUHSAT_SERI_NO,
										RUHSAT_SIRA_NO		= :RUHSAT_SIRA_NO,
										SAHIBI_TCK			= :SAHIBI_TCK,
										SAHIBI_AD			= :SAHIBI_AD,
										SAHIBI_SOYAD		= :SAHIBI_SOYAD,
										SAHIBI_MESLEK_ID	= :SAHIBI_MESLEK_ID,
										SAHIBI_TEL			= :SAHIBI_TEL,
										SAHIBI_CEPTEL		= :SAHIBI_CEPTEL,
										SAHIBI_MAIL			= :SAHIBI_MAIL,
										SAHIBI_IL_ID		= :SAHIBI_IL_ID,
										SAHIBI_ILCE_ID		= :SAHIBI_ILCE_ID,
										SAHIBI_ADRES		= :SAHIBI_ADRES,
										YEDEK_ANAHTAR		= :YEDEK_ANAHTAR,
										LASTIK_EBAT_ID		= :LASTIK_EBAT_ID,
										LASTIK_MARKA_ID		= :LASTIK_MARKA_ID,
										LASTIK				= :LASTIK,
										RENK_ID				= :RENK_ID,
										DURUM				= :DURUM,
										GTARIH 				= NOW()
									WHERE ID = :ID
									";
			$filtre[":PLAKA"] 				= trim($_REQUEST["plaka"]);
			$filtre[":MARKA_ID"] 			= $_REQUEST["marka_id"];
			$filtre[":MODEL_ID"]			= $_REQUEST["model_id"];
			$filtre[":MODEL_YILI"]			= $_REQUEST["model_yili"];
			$filtre[":SEGMENT"]				= $_REQUEST["segment"];
			$filtre[":YAKIT_ID"]			= $_REQUEST["yakit_id"];
			$filtre[":VITES_ID"]			= $_REQUEST["vites_id"];
			$filtre[":SASI_NO"]				= trim($_REQUEST["sasi_no"]);
			$filtre[":MOTOR_NO"]			= trim($_REQUEST["motor_no"]);
			$filtre[":SON_KM"]				= FormatSayi::sayi2db($_REQUEST["son_km"]);
			$filtre[":MUAYENE_TARIH"]		= FormatTarih::nokta2db($_REQUEST["muayene_tarih"]);
			$filtre[":TRAFIK_BIT_TARIH"]	= FormatTarih::nokta2db($_REQUEST["trafik_bit_tarih"]);
			$filtre[":KASKO_BIT_TARIH"]		= FormatTarih::nokta2db($_REQUEST["kasko_bit_tarih"]);
			$filtre[":RUHSAT_SERI_NO"]		= $_REQUEST["ruhsat_seri_no"];
			$filtre[":RUHSAT_SIRA_NO"]		= $_REQUEST["ruhsat_sira_no"];
			$filtre[":SAHIBI_TCK"]			= $_REQUEST["sahibi_tck"];
			$filtre[":SAHIBI_AD"]			= $_REQUEST["sahibi_ad"];
			$filtre[":SAHIBI_SOYAD"]		= $_REQUEST["sahibi_soyad"];
			$filtre[":SAHIBI_MESLEK_ID"]	= $_REQUEST["sahibi_meslek_id"];
			$filtre[":SAHIBI_TEL"]			= $_REQUEST["sahibi_tel"];
			$filtre[":SAHIBI_CEPTEL"]		= $_REQUEST["sahibi_ceptel"];
			$filtre[":SAHIBI_MAIL"]			= $_REQUEST["sahibi_mail"];
			$filtre[":SAHIBI_IL_ID"]		= $_REQUEST["sahibi_il_id"];
			$filtre[":SAHIBI_ILCE_ID"]		= $_REQUEST["sahibi_ilce_id"];
			$filtre[":SAHIBI_ADRES"]		= $_REQUEST["sahibi_adres"];
			$filtre[":YEDEK_ANAHTAR"]		= $_REQUEST["yedek_anahtar"];
			$filtre[":LASTIK_EBAT_ID"]		= $_REQUEST["lastik_ebat_id"];
			$filtre[":LASTIK_MARKA_ID"]		= $_REQUEST["lastik_marka_id"];
			$filtre[":LASTIK"]				= $_REQUEST["lastik"];
			$filtre[":RENK_ID"]				= $_REQUEST["renk_id"];
			$filtre[":DURUM"] 				= $_REQUEST["durum"] ? 1 : 0;
			$filtre[":ID"] 					= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		}
		
		if($ARAC_ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["YENI"] 		= 1;
			$sonuc["URL"] 		= "/kiralama/arac.do?route=kiralama/arac_listesi&id={$row->ID}&kod={$row->KOD}";
		} else if($row->ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["URL"] 		= "/kiralama/arac.do?route=kiralama/arac_listesi&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function arac_surucu_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM ARAC WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Araç bulunamadı!";
			return $sonuc;
		}
			
		if($_REQUEST["kod"] != $row->KOD){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";
			return $sonuc;
		}
			
		$filtre	= array();
		$sql = "UPDATE ARAC SET		SURUCU_TCK			= :SURUCU_TCK,
									SURUCU_AD			= :SURUCU_AD,
									SURUCU_SOYAD		= :SURUCU_SOYAD,
									SURUCU_MESLEK_ID	= :SURUCU_MESLEK_ID,
									SURUCU_TEL			= :SURUCU_TEL,
									SURUCU_CEPTEL		= :SURUCU_CEPTEL,
									SURUCU_MAIL			= :SURUCU_MAIL,
									SURUCU_IL_ID		= :SURUCU_IL_ID,
									SURUCU_ILCE_ID		= :SURUCU_ILCE_ID,
									SURUCU_ADRES		= :SURUCU_ADRES,
									SURUCU_IS_IL_ID		= :SURUCU_IS_IL_ID,
									SURUCU_IS_ILCE_ID	= :SURUCU_IS_ILCE_ID,
									SURUCU_IS_ADRES		= :SURUCU_IS_ADRES,
									GTARIH 				= NOW()
								WHERE ID = :ID
								";
		$filtre[":SURUCU_TCK"]			= $_REQUEST["surucu_tck"];
		$filtre[":SURUCU_AD"]			= $_REQUEST["surucu_ad"];
		$filtre[":SURUCU_SOYAD"]		= $_REQUEST["surucu_soyad"];
		$filtre[":SURUCU_MESLEK_ID"]	= $_REQUEST["surucu_meslek_id"];
		$filtre[":SURUCU_TEL"]			= $_REQUEST["surucu_tel"];
		$filtre[":SURUCU_CEPTEL"]		= $_REQUEST["surucu_ceptel"];
		$filtre[":SURUCU_MAIL"]			= $_REQUEST["surucu_mail"];
		$filtre[":SURUCU_IL_ID"]		= $_REQUEST["surucu_il_id"];
		$filtre[":SURUCU_ILCE_ID"]		= $_REQUEST["surucu_ilce_id"];
		$filtre[":SURUCU_ADRES"]		= $_REQUEST["surucu_adres"];
		$filtre[":SURUCU_IS_IL_ID"]		= $_REQUEST["surucu_is_il_id"];
		$filtre[":SURUCU_IS_ILCE_ID"]	= $_REQUEST["surucu_is_ilce_id"];
		$filtre[":SURUCU_IS_ADRES"]		= $_REQUEST["surucu_is_adres"];
		$filtre[":ID"] 					= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($row->ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			//$sonuc["URL"] 		= "/kiralama/arac.do?route=kiralama/arac_listesi&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function cari_kaydet(){
		
		if($_REQUEST["cari_turu"] == -1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Türü seçiniz!";
			return $sonuc;
		}	
		
		/*
		if(strlen($_REQUEST["tck"]) != 11 AND $_REQUEST["musteri_tipi"] == "B"){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "TCK giriniz! 11 haneli olmalı";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["tck"]) != 10 AND $_REQUEST["musteri_tipi"] == "K"){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "VKN giriniz! 10 haneli olmalı";
			return $sonuc;
		}
		*/
		
		if(strlen($_REQUEST["tck"]) < 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "TCK / VKN giriniz!";
			return $sonuc;
		}	
		
		if(strlen($_REQUEST["cari"]) < 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari ismini giriniz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["ceptel"]) < 17){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "CepTel giriniz!";
			return $sonuc;
		}
		
		if($_REQUEST["ulke_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Adres Ülke seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["il_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Adres İl seçiniz!";
			return $sonuc;
		}	
		
		if($_REQUEST["ilce_id"] <= 0 AND $_REQUEST["ulke_id"] == 213){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Adres İlçe seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["vade"] < 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Vade seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["para_birim"] == -1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "<b>Para Birimi</b> seçiniz!";
			return $sonuc;
		}
		
		/*
		$filtre	= array();
		$sql = "SELECT ID FROM CARI WHERE TCK = :TCK AND ID != :ID";
		$filtre[":TCK"] 	= $_REQUEST["tck"];
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row_cari_ayni = $this->cdbPDO->row($sql, $filtre);
		
		if($row_cari_ayni->ID > 0 AND $_REQUEST["id"] > 0 AND $_REQUEST["tck"] != "11111111111"){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aynı TCK/VKN ile daha önce kayıt açılmış!";
			return $sonuc;
		}	
		*/
		
		$filtre	= array();
		$sql = "SELECT MALI_KOD FROM CARI_TURU WHERE CARI_TURU = :CARI_TURU";
		$filtre[":CARI_TURU"] 	= $_REQUEST["cari_turu"];
		$row_cari_turu = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			
			$filtre	= array();
			$sql = "INSERT INTO CARI SET	CARI_TURU		= :CARI_TURU,
											MUSTERI_TIPI	= :MUSTERI_TIPI,
											TCK 			= :TCK,
											CARI			= :CARI,
											VD		 		= :VD,
											AD 				= :AD,
											SOYAD 			= :SOYAD,
											BANKA_ID		= :BANKA_ID,
											IBAN			= :IBAN,
											MAIL			= :MAIL,
											CEPTEL			= :CEPTEL,
											CEPTEL2			= :CEPTEL2,
											TEL				= :TEL,
											ADRES			= :ADRES,
											ULKE_ID			= :ULKE_ID,
											IL_ID 			= :IL_ID,
											ILCE_ID 		= :ILCE_ID,
											DURUM			= :DURUM,
											MAIL_GONDER		= :MAIL_GONDER,
											SMS_GONDER		= :SMS_GONDER,
											FONT_BOYUT_ID	= :FONT_BOYUT_ID,
											TEMA_ID			= :TEMA_ID,
											OZEL_KOD1		= :OZEL_KOD1,
											OZEL_KOD2		= :OZEL_KOD2,
											OZEL_KOD3		= :OZEL_KOD3,
											OZEL_KOD4		= :OZEL_KOD4,
											PARA_BIRIM		= :PARA_BIRIM,
											KAR_ORANI		= :KAR_ORANI,
											TEMSILCI_ID		= :TEMSILCI_ID,
											EKLEYEN_ID		= :EKLEYEN_ID,
											VADE			= :VADE,
											TARIH 			= NOW(),
											KOD				= MD5(NOW())
											";
			$filtre[":CARI_TURU"]		= $_REQUEST["cari_turu"];
			$filtre[":MUSTERI_TIPI"]	= $_REQUEST["musteri_tipi"];
			$filtre[":TCK"] 			= trim($_REQUEST["tck"]);
			$filtre[":CARI"]			= trim($_REQUEST["cari"]);
			$filtre[":VD"]				= $_REQUEST["vd"];
			$filtre[":AD"]				= $_REQUEST["ad"];
			$filtre[":SOYAD"]			= $_REQUEST["soyad"];
			$filtre[":BANKA_ID"]		= $_REQUEST["banka_id"];
			$filtre[":IBAN"]			= $_REQUEST["iban"];
			$filtre[":MAIL"]			= $_REQUEST["mail"];
			$filtre[":CEPTEL"]			= $_REQUEST["ceptel"];
			$filtre[":CEPTEL2"]			= $_REQUEST["ceptel2"];
			$filtre[":TEL"]				= $_REQUEST["tel"];
			$filtre[":ADRES"]			= $_REQUEST["adres"];
			$filtre[":ULKE_ID"]			= $_REQUEST["ulke_id"];
			$filtre[":IL_ID"]			= $_REQUEST["il_id"];
			$filtre[":ILCE_ID"]			= $_REQUEST["ilce_id"];
			$filtre[":DURUM"]			= $_REQUEST["durum"] ? 1 : 0;
			$filtre[":MAIL_GONDER"]		= $_REQUEST["mail_gonder"] ? 1 : 0;
			$filtre[":SMS_GONDER"]		= $_REQUEST["sms_gonder"] ? 1 : 0;
			$filtre[":FONT_BOYUT_ID"]	= $_REQUEST["font_boyut_id"];
			$filtre[":TEMA_ID"]			= $_REQUEST["tema_id"];
			$filtre[":OZEL_KOD1"] 		= $_REQUEST["ozel_kod1"];
			$filtre[":OZEL_KOD2"] 		= $_REQUEST["ozel_kod2"];
			$filtre[":OZEL_KOD3"] 		= $_REQUEST["ozel_kod3"];
			$filtre[":OZEL_KOD4"] 		= $_REQUEST["ozel_kod4"];
			$filtre[":PARA_BIRIM"] 		= $_REQUEST["para_birim"];
			$filtre[":KAR_ORANI"] 		= FormatSayi::sayi2db($_REQUEST["kar_orani"]);
			$filtre[":VADE"] 			= $_REQUEST["vade"];
			$filtre[":TEMSILCI_ID"] 	= $_REQUEST["temsilci_id"];
			$filtre[":EKLEYEN_ID"] 		= $_SESSION["kullanici_id"];
			$MUSTERI_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
			
			$filtre	= array();
			$sql = "UPDATE CARI SET CARI_KOD = CONCAT(:MALI_KOD, LPAD(ID,4,0)) WHERE ID = :ID";
			$filtre[":MALI_KOD"] 	= $row_cari_turu->MALI_KOD;
			$filtre[":ID"] 			= $MUSTERI_ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
			$filtre	= array();
			$sql = "SELECT ID, KOD FROM CARI WHERE ID = :ID";
			$filtre[":ID"] 		= $MUSTERI_ID;
			$row = $this->cdbPDO->row($sql, $filtre);
			
		} else {
			
			if($_REQUEST["kod"] != $row->KOD){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE CARI SET		CARI_TURU		= :CARI_TURU,
										MUSTERI_TIPI 	= :MUSTERI_TIPI,
										TCK 			= :TCK,
										CARI			= :CARI,
										VD		 		= :VD,
										AD 				= :AD,
										SOYAD 			= :SOYAD,
										BANKA_ID		= :BANKA_ID,
										IBAN			= :IBAN,
										MAIL			= :MAIL,
										CEPTEL			= :CEPTEL,
										CEPTEL2			= :CEPTEL2,
										TEL				= :TEL,
										ADRES			= :ADRES,
										ULKE_ID			= :ULKE_ID,
										IL_ID 			= :IL_ID,
										ILCE_ID 		= :ILCE_ID,
										DURUM			= :DURUM,
										MAIL_GONDER		= :MAIL_GONDER,
										SMS_GONDER		= :SMS_GONDER,
										FONT_BOYUT_ID	= :FONT_BOYUT_ID,
										TEMA_ID			= :TEMA_ID,
										OZEL_KOD1		= :OZEL_KOD1,
										OZEL_KOD2		= :OZEL_KOD2,
										OZEL_KOD3		= :OZEL_KOD3,
										OZEL_KOD4		= :OZEL_KOD4,
										PARA_BIRIM		= :PARA_BIRIM,
										KAR_ORANI		= :KAR_ORANI,
										VADE			= :VADE,
										CARI_KOD 		= CONCAT(:MALI_KOD, LPAD(ID,4,0)),
										TEMSILCI_ID		= :TEMSILCI_ID,
										GTARIH 			= NOW()
									WHERE ID = :ID
									";
			$filtre[":CARI_TURU"]		= $_REQUEST["cari_turu"];
			$filtre[":MUSTERI_TIPI"]	= $_REQUEST["musteri_tipi"];
			$filtre[":TCK"] 			= trim($_REQUEST["tck"]);
			$filtre[":CARI"]			= trim($_REQUEST["cari"]);
			$filtre[":VD"]				= $_REQUEST["vd"];
			$filtre[":AD"]				= $_REQUEST["ad"];
			$filtre[":SOYAD"]			= $_REQUEST["soyad"];
			$filtre[":BANKA_ID"]		= $_REQUEST["banka_id"];
			$filtre[":IBAN"]			= $_REQUEST["iban"];
			$filtre[":MAIL"]			= $_REQUEST["mail"];
			$filtre[":CEPTEL"]			= $_REQUEST["ceptel"];
			$filtre[":CEPTEL2"]			= $_REQUEST["ceptel2"];
			$filtre[":TEL"]				= $_REQUEST["tel"];
			$filtre[":ADRES"]			= $_REQUEST["adres"];
			$filtre[":ULKE_ID"]			= $_REQUEST["ulke_id"];
			$filtre[":IL_ID"]			= $_REQUEST["il_id"];
			$filtre[":ILCE_ID"]			= $_REQUEST["ilce_id"];
			$filtre[":DURUM"]			= $_REQUEST["durum"] ? 1 : 0;
			$filtre[":MAIL_GONDER"]		= $_REQUEST["mail_gonder"] ? 1 : 0;
			$filtre[":SMS_GONDER"]		= $_REQUEST["sms_gonder"] ? 1 : 0;
			$filtre[":FONT_BOYUT_ID"]	= $_REQUEST["font_boyut_id"];
			$filtre[":TEMA_ID"]			= $_REQUEST["tema_id"];
			$filtre[":OZEL_KOD1"] 		= $_REQUEST["ozel_kod1"];
			$filtre[":OZEL_KOD2"] 		= $_REQUEST["ozel_kod2"];
			$filtre[":OZEL_KOD3"] 		= $_REQUEST["ozel_kod3"];
			$filtre[":OZEL_KOD4"] 		= $_REQUEST["ozel_kod4"];
			$filtre[":PARA_BIRIM"] 		= $_REQUEST["para_birim"];
			$filtre[":KAR_ORANI"] 		= FormatSayi::sayi2db($_REQUEST["kar_orani"]);
			$filtre[":MALI_KOD"] 		= $row_cari_turu->MALI_KOD;
			$filtre[":VADE"] 			= $_REQUEST["vade"];
			$filtre[":TEMSILCI_ID"] 	= $_REQUEST["temsilci_id"];
			$filtre[":ID"] 				= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		}
		
		if($row->ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["URL"] 		= "/cari/cari.do?route=cari/cari_listesi&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function cari_tedarikci_kaydet(){		
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari bulunamadı!";
			return $sonuc;
		}
		
		if($_REQUEST["kod"] != $row->KOD){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";
			return $sonuc;
		}
			
		$filtre	= array();
		$sql = "UPDATE CARI SET		ISKONTO1		= :ISKONTO1,
									ISKONTO2 		= :ISKONTO2,
									ISKONTO3 		= :ISKONTO3,
									PARCA_MARKA_IDS	= :PARCA_MARKA_IDS,
									STOKSUZ_DURUM	= :STOKSUZ_DURUM,
									GTARIH 			= NOW()
								WHERE ID = :ID
								";
		$filtre[":ISKONTO1"] 		= FormatSayi::sayi2db($_REQUEST["iskonto1"]);
		$filtre[":ISKONTO2"] 		= FormatSayi::sayi2db($_REQUEST["iskonto2"]);
		$filtre[":ISKONTO3"] 		= FormatSayi::sayi2db($_REQUEST["iskonto3"]);
		$filtre[":PARCA_MARKA_IDS"] = implode(',',$_REQUEST["parca_marka_ids"]);
		$filtre[":STOKSUZ_DURUM"] 	= $_REQUEST["stoksuz_durum"];
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE YP_LISTE SET DURUM 		= IF(FIND_IN_SET(PARCA_MARKA_ID, :PARCA_MARKA_IDS), 1, 0), 
									SATIS_FIYAT = ALIS_FIYAT * ((100 - :ISKONTO1)/100) * ((100 - :ISKONTO2)/100) * ((100 - :ISKONTO3)/100) * ((100 + :KAR_ORANI)/100)
								WHERE TEDARIKCI_ID = :TEDARIKCI_ID
								";
		$filtre[":PARCA_MARKA_IDS"] = implode(',',$_REQUEST["parca_marka_ids"]);
		$filtre[":ISKONTO1"] 		= FormatSayi::sayi2db($_REQUEST["iskonto1"]);
		$filtre[":ISKONTO2"] 		= FormatSayi::sayi2db($_REQUEST["iskonto2"]);
		$filtre[":ISKONTO3"] 		= FormatSayi::sayi2db($_REQUEST["iskonto3"]);
		$filtre[":KAR_ORANI"] 		= $row->KAR_ORANI;
		$filtre[":TEDARIKCI_ID"] 	= $row->ID;
		$this->cdbPDO->rowsCount($sql, $filtre);
		
		if($_REQUEST["stoksuz_durum"] == "0"){
			$filtre	= array();
			$sql = "UPDATE YP_LISTE SET DURUM = 0 WHERE TEDARIKCI_ID = :TEDARIKCI_ID AND STOK = 0";
			$filtre[":TEDARIKCI_ID"] 	= $row->ID;
			$this->cdbPDO->rowsCount($sql, $filtre);	
		}
		
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
	}
	
	public function personel_maas_kaydet(){
		
		if($_REQUEST["evli"] < 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Evli/Bekar durumunu seçiniz!";
			return $sonuc;
		}	
		
		if($_REQUEST["esi_calisiyor"] < 0 AND $_REQUEST["evli"] == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Eşi Çalışıyor durumunu seçiniz!";
			return $sonuc;
		}	
		
		if($_REQUEST["cocuk_sayisi"] < 0 AND $_REQUEST["evli"] == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Çoçuk sayısını seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["maas_net"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Maaş giriniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT ID, TUTAR FROM AGI WHERE EVLI = :EVLI AND ESI_CALISIYOR = :ESI_CALISIYOR AND COCUK_SAYISI = :COCUK_SAYISI";
		$filtre[":EVLI"] 			= $_REQUEST["evli"];
		$filtre[":ESI_CALISIYOR"] 	= $_REQUEST["esi_calisiyor"];
		$filtre[":COCUK_SAYISI"] 	= $_REQUEST["cocuk_sayisi"];
		$row_agi = $this->cdbPDO->row($sql, $filtre);
			
		if($_REQUEST["kod"] != $row->KOD){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE CARI SET		EVLI			= :EVLI,
									ESI_CALISIYOR 	= :ESI_CALISIYOR,
									COCUK_SAYISI	= :COCUK_SAYISI,
									MAAS_NET		= :MAAS_NET,
									MAAS 			= :MAAS,
									GTARIH 			= NOW()
								WHERE ID = :ID
								";
		$filtre[":EVLI"]			= $_REQUEST["evli"];
		$filtre[":ESI_CALISIYOR"]	= $_REQUEST["esi_calisiyor"];
		$filtre[":COCUK_SAYISI"]	= $_REQUEST["cocuk_sayisi"];
		$filtre[":MAAS_NET"]		= FormatSayi::sayi2db($_REQUEST["maas_net"]);
		$filtre[":MAAS"]			= FormatSayi::sayi2db($_REQUEST["maas_net"]) + $row_agi->TUTAR;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($row->ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function muayene_istasyonu_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT ID FROM MUAYENE_ISTASYONU WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			
			$filtre	= array();
			$sql = "INSERT INTO MUAYENE_ISTASYONU SET	MUAYENE_ISTASYONU 	= :MUAYENE_ISTASYONU,
														MAIL				= :MAIL,
														TEL 				= :TEL,
														TEL2 				= :TEL2,
														IL_ID 				= :IL_ID,
														ILCE_ID 			= :ILCE_ID,
														ADRES				= :ADRES,
														TARIH 				= NOW()
														";
			$filtre[":MUAYENE_ISTASYONU"] 	= $_REQUEST["muayene_istasyonu"];
			$filtre[":MAIL"] 				= $_REQUEST["mail"];
			$filtre[":TEL"]					= $_REQUEST["tel"];
			$filtre[":TEL2"]				= $_REQUEST["tel2"];
			$filtre[":IL_ID"]				= $_REQUEST["il_id"];
			$filtre[":ILCE_ID"]				= $_REQUEST["ilce_id"];
			$filtre[":ADRES"]				= $_REQUEST["adres"];
			$ISTASYON_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
			
		} else {
			
			$filtre	= array();
			$sql = "UPDATE MUAYENE_ISTASYONU SET	MUAYENE_ISTASYONU 	= :MUAYENE_ISTASYONU,
													MAIL				= :MAIL,
													TEL 				= :TEL,
													TEL2 				= :TEL2,
													IL_ID 				= :IL_ID,
													ILCE_ID 			= :ILCE_ID,
													ADRES				= :ADRES
												WHERE ID = :ID
												";
			$filtre[":MUAYENE_ISTASYONU"] 	= $_REQUEST["muayene_istasyonu"];
			$filtre[":MAIL"] 				= $_REQUEST["mail"];
			$filtre[":TEL"]					= $_REQUEST["tel"];
			$filtre[":TEL2"]				= $_REQUEST["tel2"];
			$filtre[":IL_ID"]				= $_REQUEST["il_id"];
			$filtre[":ILCE_ID"]				= $_REQUEST["ilce_id"];
			$filtre[":ADRES"]				= $_REQUEST["adres"];
			$filtre[":ID"] 					= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			$ISTASYON_ID = $row->ID;
			
		}
		
		if($ISTASYON_ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["URL"] 		= "/tanimlama/muayene_istasyonu.do?route=tanimlama/muayene_istasyonlari&id={$ISTASYON_ID}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function model_bakim_paket_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT ID, MARKA_ID FROM MODEL WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row_model = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM BAKIM_PAKET WHERE MARKA_ID = :MARKA_ID AND MODEL_ID = :MODEL_ID";
		$filtre[":MARKA_ID"] 		= $row_model->MARKA_ID;
		$filtre[":MODEL_ID"] 		= $row_model->ID;
		$rows_bakim = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows_bakim as $key => $row_bakim){
			$rows_bakim_baket[$row_bakim->SIRA]	= $row_bakim;
		}
		
		if(count(array_unique($_REQUEST["km"])) == count($_REQUEST["km"])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aynı KM de olanlar var!";
			return $sonuc;
		}		
		
		for($i = 1; $i <= 20; $i++){
			if(count($rows_bakim) > 0) {
				$filtre	= array();
				$sql = "UPDATE BAKIM_PAKET SET	KM 				= :KM,
												BAKIM_PAKET 	= :BAKIM_PAKET,
												ACIKLAMA 		= :ACIKLAMA
										WHERE ID = :ID
										";
				$filtre[":KM"]				= FormatSayi::sayi2db($_REQUEST["km"][$i]);
				$filtre[":BAKIM_PAKET"]		= $_REQUEST["bakim_paket"][$i];
				$filtre[":ACIKLAMA"]		= $_REQUEST["aciklama"][$i];
				$filtre[":ID"] 				= $rows_bakim_baket[$i]->ID;
				$BAKIM_PAKET_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
				
			} else {
				$filtre	= array();
				$sql = "INSERT INTO BAKIM_PAKET SET	MARKA_ID	 	= :MARKA_ID,
													MODEL_ID		= :MODEL_ID,
													SIRA			= :SIRA,
													KM 				= :KM,
													BAKIM_PAKET 	= :BAKIM_PAKET,
													ACIKLAMA 		= :ACIKLAMA,
													DURUM			= 1
													";
				$filtre[":MARKA_ID"] 		= $row_model->MARKA_ID;
				$filtre[":MODEL_ID"] 		= $row_model->ID;
				$filtre[":SIRA"]			= $i;
				$filtre[":KM"]				= FormatSayi::sayi2db($_REQUEST["km"][$i]);
				$filtre[":BAKIM_PAKET"]		= $_REQUEST["bakim_paket"][$i];
				$filtre[":ACIKLAMA"]		= $_REQUEST["aciklama"][$i];
				$BAKIM_PAKET_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
				
			}
			
		}
		
		if(TRUE){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	
	public function marka_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM MARKA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["MARKA"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function marka_kaydet(){
		
        $filtre	= array();
        $sql = "UPDATE MARKA SET	MARKA 		= :MARKA,
        							RESIM_URL	= :RESIM_URL,
								    DURUM		= :DURUM
							WHERE ID = :ID
							";
        $filtre[":MARKA"] 		= trim($_REQUEST["marka"]);
        $filtre[":RESIM_URL"] 	= trim($_REQUEST["resim_url"]);
        $filtre[":DURUM"] 		= $_REQUEST["durum"];
        $filtre[":ID"] 			= $_REQUEST["id"];
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
        if($rowsCount>0){
            $sonuc["HATA"] 		= FALSE;
            $sonuc["ACIKLAMA"] 	= "Kaydedildi.";
        }else{
            $sonuc["HATA"] 		= TRUE;
            $sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
        }
		
        return $sonuc;
		
    }	

    public function marka_ekle(){
		
        $filtre	= array();
        $sql = "INSERT INTO MARKA SET	MARKA 		= :MARKA,
        								RESIM_URL	= :RESIM_URL,
										DURUM		= :DURUM
										";
        $filtre[":MARKA"] 		= trim($_REQUEST["marka"]);
        $filtre[":RESIM_URL"] 	= trim($_REQUEST["resim_url"]);
        $filtre[":DURUM"] 		= $_REQUEST["durum"];
        $marka_id = $this->cdbPDO->lastInsertId($sql, $filtre);
        
        if($marka_id > 0){
            $sonuc["HATA"] 		= FALSE;
            $sonuc["ACIKLAMA"] 	= "Kaydedildi.";
        }else{
            $sonuc["HATA"] 		= TRUE;
            $sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
        }
		
        return $sonuc;
		
    }
    
    public function parca_marka_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM PARCA_MARKA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bulundu.";
			$sonuc["ROW"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function parca_marka_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT * FROM PARCA_TIPI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["tip"];
		$row_pm = $this->cdbPDO->row($sql, $filtre); 
		
        $filtre	= array();
        $sql = "UPDATE PARCA_MARKA SET	PARCA_MARKA 	= :PARCA_MARKA,
	        							TIP				= :TIP,
	        							PARCA_TIPI_ID	= :PARCA_TIPI_ID,
									    DURUM			= :DURUM
								WHERE ID = :ID
								";
        $filtre[":PARCA_MARKA"]		= trim($_REQUEST["parca_marka"]);
        $filtre[":TIP"] 			= $row_pm->PARCA_TIPI;
        $filtre[":PARCA_TIPI_ID"] 	= $row_pm->ID;
        $filtre[":DURUM"] 			= $_REQUEST["durum"];
        $filtre[":ID"] 				= $_REQUEST["id"];
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM PARCA_MARKA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
        if($rowsCount>0){
            $sonuc["HATA"] 		= FALSE;
            $sonuc["ACIKLAMA"] 	= "Kaydedildi.";
            $sonuc["ROW"]		= $row;
        }else{
            $sonuc["HATA"] 		= TRUE;
            $sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
        }
		
        return $sonuc;
		
    }	

    public function parca_marka_ekle(){
		
        $filtre	= array();
        $sql = "INSERT INTO PARCA_MARKA SET	PARCA_MARKA 	= :PARCA_MARKA,
	        								TIP				= :TIP,
	        								PARCA_TIPI_ID	= :PARCA_TIPI_ID,
											DURUM			= :DURUM
											";
        $filtre[":PARCA_MARKA"] 	= trim($_REQUEST["parca_marka"]);
        $filtre[":TIP"] 			= $row_pm->PARCA_TIPI;
        $filtre[":PARCA_TIPI_ID"] 	= $row_pm->ID;
        $filtre[":DURUM"] 			= $_REQUEST["durum"];
        $marka_id = $this->cdbPDO->lastInsertId($sql, $filtre);
        
        $filtre	= array();
		$sql = "SELECT * FROM PARCA_MARKA WHERE ID = :ID";
		$filtre[":ID"] 	= $marka_id;
		$row = $this->cdbPDO->row($sql, $filtre); 
		
        if($marka_id > 0){
            $sonuc["HATA"] 		= FALSE;
            $sonuc["ACIKLAMA"] 	= "Kaydedildi.";
            $sonuc["ROW"]		= $row;
        }else{
            $sonuc["HATA"] 		= TRUE;
            $sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
        }
		
        return $sonuc;
		
    }
    
    public function model_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM MODEL WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["DATA"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function model_kaydet(){
		
		if($_REQUEST["marka_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Marka seçiniz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["model"]) <= 2){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Model yazınız!";
			return $sonuc;
		}
		
		if($_REQUEST["vites_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Vites seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["yakit_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yakıt seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["bit_yil"] < $_REQUEST["bas_yil"]){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bitiş yılı başlangıç yılından önce olamaz!";
			return $sonuc;
		}
		
        $filtre	= array();
        $sql = "UPDATE MODEL SET	MARKA_ID		= :MARKA_ID,
        							MODEL 			= :MODEL,
        							GRUP			= :GRUP,
        							VITES_ID		= :VITES_ID,
        							YAKIT_ID		= :YAKIT_ID,
        							RESIM_URL		= :RESIM_URL,
        							TSRB_MARKA_KODU	= :TSRB_MARKA_KODU,
        							TSRB_TIP_KODU	= :TSRB_TIP_KODU,
        							BAS_YIL			= :BAS_YIL,
        							BIT_YIL			= :BIT_YIL,
								    DURUM			= :DURUM
							WHERE ID = :ID
							";
		$filtre[":MARKA_ID"] 		= $_REQUEST["marka_id"];
        $filtre[":MODEL"] 			= trim($_REQUEST["model"]);
        $filtre[":GRUP"] 			= trim($_REQUEST["grup"]);
        $filtre[":VITES_ID"] 		= $_REQUEST["vites_id"];
        $filtre[":YAKIT_ID"] 		= $_REQUEST["yakit_id"];
        $filtre[":RESIM_URL"] 		= trim($_REQUEST["resim_url"]);
        $filtre[":TSRB_MARKA_KODU"] = trim($_REQUEST["tsrb_marka_kodu"]);
        $filtre[":TSRB_TIP_KODU"] 	= trim($_REQUEST["tsrb_tip_kodu"]);
        $filtre[":BAS_YIL"] 		= trim($_REQUEST["bas_yil"]);
        $filtre[":BIT_YIL"] 		= trim($_REQUEST["bit_yil"]);
        $filtre[":DURUM"] 			= $_REQUEST["durum"];
        $filtre[":ID"] 				= $_REQUEST["id"];
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
        if($rowsCount>0){
            $sonuc["HATA"] 		= FALSE;
            $sonuc["ACIKLAMA"] 	= "Kaydedildi.";
        }else{
            $sonuc["HATA"] 		= TRUE;
            $sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
        }
		
        return $sonuc;
		
    }	

    public function model_ekle(){
		
		if($_REQUEST["marka_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Marka seçiniz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["model"]) <= 2){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Model yazınız!";
			return $sonuc;
		}
		
		if($_REQUEST["vites_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Vites seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["yakit_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yakıt seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["bit_yil"] < $_REQUEST["bas_yil"]){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bitiş yılı başlangıç yılından önce olamaz!";
			return $sonuc;
		}
		
        $filtre	= array();
        $sql = "INSERT INTO MODEL SET	MARKA_ID		= :MARKA_ID,
	        							MODEL 			= :MODEL,
	        							GRUP			= :GRUP,
	        							VITES_ID		= :VITES_ID,
	        							YAKIT_ID		= :YAKIT_ID,
	        							RESIM_URL		= :RESIM_URL,
	        							TSRB_MARKA_KODU	= :TSRB_MARKA_KODU,
	        							TSRB_TIP_KODU	= :TSRB_TIP_KODU,
	        							BAS_YIL			= :BAS_YIL,
	        							BIT_YIL			= :BIT_YIL,
									    DURUM			= :DURUM
										";
        $filtre[":MARKA_ID"] 		= $_REQUEST["marka_id"];
        $filtre[":MODEL"] 			= trim($_REQUEST["model"]);
        $filtre[":GRUP"] 			= trim($_REQUEST["grup"]);
        $filtre[":VITES_ID"] 		= $_REQUEST["vites_id"];
        $filtre[":YAKIT_ID"] 		= $_REQUEST["yakit_id"];
        $filtre[":RESIM_URL"] 		= trim($_REQUEST["resim_url"]);
        $filtre[":TSRB_MARKA_KODU"] = trim($_REQUEST["tsrb_marka_kodu"]);
        $filtre[":TSRB_TIP_KODU"] 	= trim($_REQUEST["tsrb_tip_kodu"]);
        $filtre[":BAS_YIL"] 		= trim($_REQUEST["bas_yil"]);
        $filtre[":BIT_YIL"] 		= trim($_REQUEST["bit_yil"]);
        $filtre[":DURUM"] 			= $_REQUEST["durum"];
        $model_id = $this->cdbPDO->lastInsertId($sql, $filtre);
        
        if($model_id > 0){
            $sonuc["HATA"] 		= FALSE;
            $sonuc["ACIKLAMA"] 	= "Kaydedildi.";
        }else{
            $sonuc["HATA"] 		= TRUE;
            $sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
        }
		
        return $sonuc;
		
    }
    
	public function toplanti_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM TOPLANTI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		$row->TOPLANTI_TARIH	= FormatTarih::tarih($row->TOPLANTI_TARIH);
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["DATA"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
    public function toplanti_kaydet(){
    	
        $filtre	= array();
        $sql = "UPDATE TOPLANTI SET	FIRMA				= :FIRMA,
		        					KONU 				= :KONU,
		        					ACIKLAMA			= :ACIKLAMA,
		        					GORUSULEN_KISI		= :GORUSULEN_KISI,
		        					GORUSULEN_KISI_TEL	= :GORUSULEN_KISI_TEL,
		        					TOPLANTI_TARIH		= :TOPLANTI_TARIH,
		        					DURUM				= 1
		        			WHERE ID = :ID
							";
        $filtre[":FIRMA"] 				= trim($_REQUEST["firma"]);
        $filtre[":KONU"] 				= trim($_REQUEST["konu"]);
        $filtre[":ACIKLAMA"] 			= trim($_REQUEST["aciklama"]);
        $filtre[":GORUSULEN_KISI"] 		= trim($_REQUEST["gorusulen_kisi"]);
        $filtre[":GORUSULEN_KISI_TEL"] 	= trim($_REQUEST["gorusulen_kisi_tel"]);
        $filtre[":TOPLANTI_TARIH"] 		= $_REQUEST["toplanti_tarih"];
        $filtre[":ID"] 					= $_REQUEST["id"];
        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
        if($rowsCount>0){
            $sonuc["HATA"] 		= FALSE;
            $sonuc["ACIKLAMA"] 	= "Kaydedildi.";
        }else{
            $sonuc["HATA"] 		= TRUE;
            $sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
        }
		
        return $sonuc;
		
    }	

    public function toplanti_ekle(){
		
        $filtre	= array();
        $sql = "INSERT INTO TOPLANTI SET	FIRMA				= :FIRMA,
		        							KONU 				= :KONU,
		        							ACIKLAMA			= :ACIKLAMA,
		        							GORUSULEN_KISI		= :GORUSULEN_KISI,
		        							GORUSULEN_KISI_TEL	= :GORUSULEN_KISI_TEL,
		        							TOPLANTI_TARIH		= :TOPLANTI_TARIH,
		        							KAYIT_EDEN_ID		= :KAYIT_EDEN_ID,
		        							DURUM				= 1
											";
        $filtre[":FIRMA"] 				= trim($_REQUEST["firma"]);
        $filtre[":KONU"] 				= trim($_REQUEST["konu"]);
        $filtre[":ACIKLAMA"] 			= trim($_REQUEST["aciklama"]);
        $filtre[":GORUSULEN_KISI"] 		= trim($_REQUEST["gorusulen_kisi"]);
        $filtre[":GORUSULEN_KISI_TEL"] 	= trim($_REQUEST["gorusulen_kisi_tel"]);
        $filtre[":TOPLANTI_TARIH"] 		= $_REQUEST["toplanti_tarih"];
        $filtre[":KAYIT_EDEN_ID"] 		= $_SESSION["kullanici_id"];
        $toplanti_id = $this->cdbPDO->lastInsertId($sql, $filtre);
        
        if($toplanti_id > 0){
            $sonuc["HATA"] 		= FALSE;
            $sonuc["ACIKLAMA"] 	= "Kaydedildi.";
        }else{
            $sonuc["HATA"] 		= TRUE;
            $sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
        }
		
        return $sonuc;
		
    }
	
	public function cari_hareket_sil(){
		
		if($this->rSite->MUHASEBE_SIFRE != $_REQUEST["sifre"]){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Şifre Hatalı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Hareket bulunamadı!";
			return $sonuc;
		}
		
		if($row->PLAKA == "Virman" AND $row->CARI_ID == 0){
			$filtre	= array();
			$sql = "SELECT * FROM VIRMAN WHERE BORC_CARI_HAREKET_ID = :ID OR ALACAK_CARI_HAREKET_ID = :ID";
			$filtre[":ID"] 		= $_REQUEST["id"];
			$row_virman = $this->cdbPDO->row($sql, $filtre);
			
			$filtre	= array();
			$sql = "DELETE FROM CARI_HAREKET WHERE ID = :ID";
			$filtre[":ID"] 		= $row_virman->BORC_CARI_HAREKET_ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
			$filtre	= array();
			$sql = "DELETE FROM CARI_HAREKET WHERE ID = :ID";
			$filtre[":ID"] 		= $row_virman->ALACAK_CARI_HAREKET_ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		} else {
			$filtre	= array();
			$sql = "DELETE FROM CARI_HAREKET WHERE ID = :ID";
			$filtre[":ID"] 		= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
			$filtre	= array();
			$sql = "DELETE FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID";
			$filtre[":CARI_HAREKET_ID"] 		= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function cari_hareket_onayla(){
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Hareket bulunamadı!";
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET FATURA_DURUM_ID = 2 WHERE ID = :ID";
		$filtre[":ID"] 		= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Onaylandı.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	
	public function talep_fatura_bagini_kopar(){
		
		if($this->rSite->MUHASEBE_SIFRE != $_REQUEST["sifre"]){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Şifre Hatalı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 		= $row->ID;
		$row_ch = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row_ch->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura bulunamadı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET TALEP_ID = 0 WHERE ID = :ID";
		$filtre[":ID"] 		= $row_ch->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET FATURA_NO = '', EFATURA_UUID = '', FATURA_ACIKLAMA = '', FATURA_TARIH = NULL WHERE ID = :ID";
		$filtre[":ID"] 		= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bağı koparıldı.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function sigorta_firmasi_ekle(){
		$filtre	= array();
		$sql = "INSERT INTO SIGORTA SET SIGORTA = :SIGORTA";
		$filtre[":SIGORTA"] 		= $_REQUEST["sigorta"];
		$SIGORTA = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM SIGORTA WHERE ID = :ID";
		$filtre[":ID"] 		= $SIGORTA;
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if($SIGORTA>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["SIGORTA"] = $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function filo_firmasi_ekle(){
		$filtre	= array();
		$sql = "INSERT INTO FILO SET FILO = :FILO";
		$filtre[":FILO"] 		= $_REQUEST["filo"];
		$FILO = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM FILO WHERE ID = :ID";
		$filtre[":ID"] 		= $FILO;
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if($FILO>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["FILO"] = $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function duyuru_sil(){
		$filtre	= array();
		$sql = "DELETE FROM DUYURU WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function basvuru_sil(){
		$filtre	= array();
		$sql = "DELETE FROM BASVURU WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function basvuru_cevap_kaydet(){
		$filtre	= array();
		$sql = "UPDATE BASVURU SET CEVAP = :CEVAP, DURUM_ID = :DURUM_ID WHERE ID = :ID";
		$filtre[":DURUM_ID"] 	= 2;
		$filtre[":CEVAP"] 		= trim($_REQUEST["cevap"]);
		$filtre[":ID"] 			= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Yapıldı.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function ihale_sil(){
		$filtre	= array();
		$sql = "DELETE FROM IHALE WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
			$sonuc["KULLANICI_ID"] = $KULLANICI_ID;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
		
	public function kullanici_ekle(){
		
		$filtre	= array();
		$sql = "SELECT ID FROM YETKI WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["yetki_id"];
		$row_yetki = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row_yetki->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yetki seçimi yapınız!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["kullanici"]) < 3 OR strlen($_REQUEST["sifre"]) < 6){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı Adı min:3, şifre min:6 karakter olmalı!";
			return $sonuc;
		}
		
		if(!preg_match('/^[A-Za-z][A-Za-z0-9]{3,20}$/', $_REQUEST["kullanici"])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı Adı sadece harf ve rakamlardan oluşmalı!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["unvan"]) < 2 && 1==2){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ünvan min:3 karakter olmalı!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["ceptel"]) < 17){ //AND !preg_match('/^(5/i', $_REQUEST["ceptel"])
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cep telefonu giriniz!";
			return $sonuc;
		}
		
		if($_REQUEST["tema_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tema seçiniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM KULLANICI WHERE KULLANICI = :KULLANICI";
		$filtre[":KULLANICI"]	= mb_strtoupper($_REQUEST["kullanici"]);
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		if($rowsCount>0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı adı daha önce kullanılmış!";
			return $sonuc;
		}
		
		if($_REQUEST['sifre'] != $_REQUEST['sifre2']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Şifreler uyuşmuyor!";
			return $sonuc;
		}
		
		if(!$_REQUEST['okudum']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kuralları onaylayın!";
			return $sonuc;
		}
		
		if(in_array($_REQUEST['yetki_id'],array(4)) AND $_REQUEST['cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tedarikçi carisi seçiniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO KULLANICI SET 	YETKI_ID 			= :YETKI_ID,											
											TCK					= :TCK,
											UNVAN				= :UNVAN,
											AD 					= :AD,
											SOYAD 				= :SOYAD,
											KULLANICI 			= :KULLANICI,
											SIFRE 				= :SIFRE,
											MAIL 				= :MAIL,
											CEPTEL				= :CEPTEL,
											CEPTEL2				= :CEPTEL2,
											SKYPE				= :SKYPE,
											TEL					= :TEL,											
											ADRES				= :ADRES, 
											IL_ID				= :IL_ID,
											ILCE_ID				= :ILCE_ID,	
											OZEL_KOD1			= :OZEL_KOD1,
											OZEL_KOD2			= :OZEL_KOD2,
											OZEL_KOD3			= :OZEL_KOD3,
											OZEL_KOD4			= :OZEL_KOD4,
											DURUM 				= :DURUM,
											CARI_ID				= :CARI_ID,
											MAIL_GONDER			= :MAIL_GONDER,
											SMS_GONDER			= :SMS_GONDER,
											FONT_BOYUT_ID		= :FONT_BOYUT_ID,
											TEMA_ID				= :TEMA_ID,
											TARIH 				= NOW(),
											KOD 				= MD5(NOW())
											";
		$filtre[":YETKI_ID"] 			= $row_yetki->ID;
		$filtre[":TCK"] 				= $_REQUEST["tck"];
		$filtre[":UNVAN"] 				= trim($_REQUEST["ad"]) ." ". trim($_REQUEST["soyad"]); 
		$filtre[":AD"]					= trim($_REQUEST["ad"]);
		$filtre[":SOYAD"] 				= trim($_REQUEST["soyad"]);
		$filtre[":KULLANICI"]			= mb_strtoupper($_REQUEST["kullanici"]);
		$filtre[":SIFRE"] 				= $_REQUEST["sifre"];
		$filtre[":MAIL"] 				= $_REQUEST["mail"];
		$filtre[":CEPTEL"] 				= $_REQUEST["ceptel"];
		$filtre[":CEPTEL2"] 			= $_REQUEST["ceptel2"];
		$filtre[":SKYPE"] 				= trim($_REQUEST["skype"]);
		$filtre[":TEL"] 				= $_REQUEST["tel"];
		$filtre[":ADRES"] 				= $_REQUEST["adres"];
		$filtre[":IL_ID"] 				= $_REQUEST["il_id"];
		$filtre[":ILCE_ID"] 			= $_REQUEST["ilce_id"];
		$filtre[":OZEL_KOD1"] 			= $_REQUEST["ozel_kod1"];
		$filtre[":OZEL_KOD2"] 			= $_REQUEST["ozel_kod2"];
		$filtre[":OZEL_KOD3"] 			= $_REQUEST["ozel_kod3"];
		$filtre[":OZEL_KOD4"] 			= $_REQUEST["ozel_kod4"];
		$filtre[":CARI_ID"] 			= $_REQUEST["cari_id"];
		$filtre[":DURUM"] 				= $_REQUEST["durum"] ? 1 : 0;
		$filtre[":MAIL_GONDER"]			= $_REQUEST["mail_gonder"] ? 1 : 0;
		$filtre[":SMS_GONDER"]			= $_REQUEST["sms_gonder"] ? 1 : 0;
		$filtre[":FONT_BOYUT_ID"] 		= $_REQUEST["font_boyut_id"];
		$filtre[":TEMA_ID"] 			= $_REQUEST["tema_id"];
		$KULLANICI_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		if($KULLANICI_ID > 0) {
			$filtre	= array();
			$sql = "SELECT ID, KOD, YETKI_ID, UNVAN FROM KULLANICI WHERE ID = :ID";
			$filtre[":ID"] 		= $KULLANICI_ID;
			$row = $this->cdbPDO->row($sql, $filtre);
			
			$filtre	= array();
			$sql = "INSERT INTO KULLANICI_RESIM SET KULLANICI_ID 	= :KULLANICI_ID,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK
													";
			$filtre[':KULLANICI_ID']	= $KULLANICI_ID;
			$filtre[':RESIM_ADI']		= "14699786047205.jpg";
			$filtre[':RESIM_ADI_ILK']	= "14699786047205.jpg";
			$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
		}
		
		if($KULLANICI_ID>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi. Kullanıcı adı ile giriş yapabilir.";
			$sonuc["URL"] 		= "/kullanici/duzenle.do?route=kullanici/kullanicilar&id={$row->ID}&kod={$row->KOD}"; //$_SERVER["HTTP_REFERER"]; // 
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function kullanici_adres_ekle(){
		
		if($_REQUEST["id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı bulunamadı!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["adres_adi"]) < 2){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Adres adı min:3 karakter olmalı!";
			return $sonuc;
		}		
		
		if($_REQUEST["adres_il_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İl seçim yapınız!";
			return $sonuc;
		}
		
		if($_REQUEST["adres_ilce_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İlçe seçim yapınız!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["adres_adres"]) < 2){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Adres giriniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO KULLANICI_ADRES SET 	KULLANICI_ID 		= :KULLANICI_ID,
													ADRES_ADI			= :ADRES_ADI,
													IL_ID				= :IL_ID,
													ILCE_ID				= :ILCE_ID,
													ADRES				= :ADRES,
													DURUM				= 1
													";
		$filtre[":KULLANICI_ID"]	= $_REQUEST["id"];
		$filtre[":ADRES_ADI"] 		= trim($_REQUEST["adres_adi"]);
		$filtre[":IL_ID"]			= $_REQUEST["adres_il_id"];
		$filtre[":ILCE_ID"]			= $_REQUEST["adres_ilce_id"];
		$filtre[":ADRES"]			= trim($_REQUEST["adres_adres"]);
		$KULLANICI_ADRES_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		if($KULLANICI_ADRES_ID>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function kullanici_kaydet(){
		
		if(strlen($_REQUEST["ceptel"]) < 17){ //AND !preg_match('/^(5/i', $_REQUEST["ceptel"])
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cep telefonu giriniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE KULLANICI SET 	FIRMA_TURU			= :FIRMA_TURU,
										TCK					= :TCK,
										UNVAN				= :UNVAN,
										AD					= :AD,
										SOYAD				= :SOYAD,
										MAIL				= :MAIL,
										CEPTEL				= :CEPTEL,
										CEPTEL2				= :CEPTEL2,
										SKYPE				= :SKYPE,
										TEL					= :TEL,
										ADRES				= :ADRES,
										IL_ID				= :IL_ID,
										ILCE_ID				= :ILCE_ID,
										OZEL_KOD1			= :OZEL_KOD1,
										OZEL_KOD2			= :OZEL_KOD2,
										OZEL_KOD3			= :OZEL_KOD3,
										OZEL_KOD4			= :OZEL_KOD4,
										DURUM				= :DURUM,
										MAIL_GONDER			= :MAIL_GONDER,
										SMS_GONDER			= :SMS_GONDER,
										FONT_BOYUT_ID		= :FONT_BOYUT_ID,
										TEMA_ID				= :TEMA_ID,
										GTARIH				= NOW()						
								WHERE ID = :ID
								";
		$filtre[":FIRMA_TURU"]			= $_REQUEST["firma_turu"];
		$filtre[":TCK"] 				= $_REQUEST["tck"];
		$filtre[":UNVAN"] 				= trim($_REQUEST["unvan"]);
		$filtre[":AD"] 					= trim($_REQUEST["ad"]);
		$filtre[":SOYAD"] 				= trim($_REQUEST["soyad"]);
		$filtre[":MAIL"] 				= trim($_REQUEST["mail"]);
		$filtre[":CEPTEL"] 				= $_REQUEST["ceptel"];
		$filtre[":CEPTEL2"] 			= $_REQUEST["ceptel2"];
		$filtre[":SKYPE"] 				= trim($_REQUEST["skype"]);
		$filtre[":TEL"] 				= $_REQUEST["tel"];
		$filtre[":ADRES"] 				= trim($_REQUEST["adres"]);
		$filtre[":IL_ID"] 				= $_REQUEST["il_id"];
		$filtre[":ILCE_ID"] 			= $_REQUEST["ilce_id"];
		$filtre[":OZEL_KOD1"] 			= $_REQUEST["ozel_kod1"];
		$filtre[":OZEL_KOD2"] 			= $_REQUEST["ozel_kod2"];
		$filtre[":OZEL_KOD3"] 			= $_REQUEST["ozel_kod3"];
		$filtre[":OZEL_KOD4"] 			= $_REQUEST["ozel_kod4"];
		$filtre[":DURUM"] 				= $_REQUEST["durum"] ? 1 : 0;
		$filtre[":MAIL_GONDER"] 		= $_REQUEST["mail_gonder"] ? 1 : 0;
		$filtre[":SMS_GONDER"] 			= $_REQUEST["sms_gonder"] ? 1 : 0;
		$filtre[":FONT_BOYUT_ID"] 		= $_REQUEST["font_boyut_id"];
		$filtre[":TEMA_ID"] 			= $_REQUEST["tema_id"];
		$filtre[":ID"] 					= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["URL"] 		= $_SERVER["HTTP_REFERER"];
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function resim_goster(){
		
		//Resmi gösterme timestamp
		$filtre	= array();
		$sql = " SELECT * FROM IHALE_RESIM WHERE ID = :ID";
		
		if($_REQUEST["id"]){
			$filtre[":ID"] 		= $_REQUEST["id"];
		}
		
		$row = $this->cdbPDO->row($sql, $filtre);		
		
		$RESIM 	= $row->RESIM_ADI;
		$resim 	= file_get_contents("../img/ihale/$RESIM");
        $data 	= base64_encode($resim); 
        
        $sonuc["HATA"] 			= FALSE;
		$sonuc["ACIKLAMA"] 		= "Kayıt Eklendi";
		$sonuc["RESIM_DATA"] 	= $data;
		
		return $sonuc;
		
	}
	
	public function kullanici_bilgilerini_guncelle(){
		
		if(!$_SESSION['kullanici_id']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı bulunamadı!";
			return $sonuc;
		}
		
		if($_REQUEST['sifre'] != $_REQUEST['sifre2']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Şifre uyuşmuyor!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE KULLANICI SET 	GTARIH 		= NOW(),
										AD			= :AD,
										SOYAD		= :SOYAD
										";
		if($_REQUEST['sifre']){
			$sql.=",SIFRE	= :SIFRE";
			$filtre[":SIFRE"] 				= $_REQUEST['sifre'];
		}
		
		$sql.=" WHERE ID = :ID";
		
		$filtre[":ID"] 			= $_SESSION['kullanici_id'];
		$filtre[":AD"] 			= $_REQUEST['ad'];
		$filtre[":SOYAD"] 		= $_REQUEST['soyad'];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Guncellendi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function mesaj_yaz(){
		
		if($_REQUEST['kime_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kime gönderileceği seçiniz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['baslik']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Başlık en az 3 krakter olmalıdır!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['konu']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Konu kısmı en az 3 karakter olmalıdır!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO MESAJ SET 	KIME_ID 		= :KIME_ID,
		 								KIMDEN_ID 		= :KIMDEN_ID,
		 								BASLIK			= :BASLIK,
		 								KONU			= :KONU
										";
		$filtre[":KIME_ID"] 		= $_REQUEST['kime_id'];
		$filtre[":KIMDEN_ID"] 		= $_SESSION['kullanici_id'];
		$filtre[":BASLIK"] 			= $_REQUEST['baslik'];
		$filtre[":KONU"] 			= $_REQUEST['konu'];
		$mesaj_id = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		if($mesaj_id > 0){
			//$this->fncIslemLog($mesaj_id, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "MESAJ", "cKayıt");
			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Mesaj iletildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function duyuru_yayinla(){
		
		if(empty($_REQUEST['kime_id'])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kime gönderileceği seçiniz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['baslik']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Başlık en az 3 krakter olmalıdır!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['konu']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Konu kısmı en az 3 karakter olmalıdır!";
			return $sonuc;
		}
		
		$arr_ki = implode(',', $_REQUEST['kime_id']);
		
		$filtre	= array();
		$sql = "INSERT INTO DUYURU SET 	ALICILAR 			= :ALICILAR,
		 								YAYINLAYAN_ID 		= :YAYINLAYAN_ID,
		 								BASLIK				= :BASLIK,
		 								KONU				= :KONU,
		 								DUYURU_BAS_TARIH	= :DUYURU_BAS_TARIH,
		 								DUYURU_BIT_TARIH	= :DUYURU_BIT_TARIH,
		 								TARIH				= NOW(),
		 								GORENLER			= 0
										";
		$filtre[":ALICILAR"] 			= $arr_ki;
		$filtre[":YAYINLAYAN_ID"] 		= $_SESSION['kullanici_id'];
		$filtre[":BASLIK"] 				= $_REQUEST['baslik'];
		$filtre[":KONU"] 				= $_REQUEST['konu'];
		$filtre[":DUYURU_BAS_TARIH"] 	= FormatTarih::tre2db($_REQUEST['duyuru_bas_tarih']);
		$filtre[":DUYURU_BIT_TARIH"] 	= FormatTarih::tre2db($_REQUEST['duyuru_bit_tarih']);
		$mesaj_id = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		if($mesaj_id > 0){
			//$this->fncIslemLog($mesaj_id, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "MESAJ", "cKayıt");
			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Mesaj iletildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function sms_gonder(){
		
		if($_REQUEST['sms_kalibi_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "SMS Kalıbı seçiniz!";
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT
					SK.ID,
					SK.SMS_KALIBI
				FROM SMS_KALIBI AS SK
				WHERE SK.ID = :ID
				";
		$filtre[":ID"] 			= $_REQUEST['sms_kalibi_id'];
		$row_sms_kalibi = $this->cdbPDO->row($sql, $filtre);
		
		if(in_array($row_sms_kalibi->ID, array(2,3))){
			
			if($_REQUEST['ihale_id'] <= 0){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "İhale seçiniz!";
				return $sonuc;
			}
			
			if(strlen($_REQUEST['gonderilecek_kisi']) <= 3){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Gönderilecek Kişi yok!";
				return $sonuc;
			}
			
			$filtre = array();
			$sql = "SELECT
						I.ID,
	                    I.IHALE_NO,
	                    MA.MARKA,
	                    MO.MODEL,
						IC.CEVAPLAYAN_ID,
	                    K.ID AS KULLANICI_ID,
	                    CONCAT(' ', K.AD, K.SOYAD) AS AD_SOYAD,
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
			$filtre[":ID"] 			= $_REQUEST['ihale_id'];
			$row = $this->cdbPDO->row($sql, $filtre);
			
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
			$mesaj_id = $this->cdbPDO->lastInsertId($sql, $filtre);
			
			$this->cSms->soapGonder(FormatTel::smsTemizle($row->CEPTEL), "FINAL YZLM", $row_sms_kalibi->SMS_KALIBI);
			
		} else if(in_array($row_sms_kalibi->ID, array(4))){
			ini_set('max_execution_time', 300);
			
			$filtre = array();
			$sql = "SELECT
						SUM(IF(I.IHALE_SEKLI_ID = 1, 1, 0)) AS BUGUN_PLAKALI_ADET,
						COUNT(*) AS BUGUN_IHALE_ADET
					FROM IHALE AS I
					WHERE DATE(I.IHALE_BIT_TARIH) = CURDATE()
					";
			$row = $this->cdbPDO->row($sql, $filtre);
			
			$row->MODEL		= FormatYazi::kisalt($row->MODEL, 10);
			$row_sms_kalibi->SMS_KALIBI = str_replace('{BUGUN_PLAKALI_ADET}', $row->BUGUN_PLAKALI_ADET, $row_sms_kalibi->SMS_KALIBI);
			$row_sms_kalibi->SMS_KALIBI = str_replace('{BUGUN_IHALE_ADET}', $row->BUGUN_IHALE_ADET, $row_sms_kalibi->SMS_KALIBI);
			
			$rows_kullanici = $this->cdbPDO->rows("SELECT ID, CEPTEL FROM KULLANICI WHERE YETKI_ID = 6 AND DURUM = 1 AND LENGTH(CEPTEL) = 14 AND SMS_GONDER = 1");
			foreach($rows_kullanici as $key => $row_kullanici){
				$ALICILAR[] = $row_kullanici->ID;
				$this->cSms->soapGonder(FormatTel::smsTemizle($row_kullanici->CEPTEL), "FINAL YZLM", $row_sms_kalibi->SMS_KALIBI);
			}
			
			if(count($ALICILAR) > 0){
				$filtre	= array();
				$sql = "INSERT INTO DUYURU SET 	ALICILAR 			= :ALICILAR,
				 								YAYINLAYAN_ID 		= :YAYINLAYAN_ID,
				 								BASLIK				= :BASLIK,
				 								KONU				= :KONU,
				 								DUYURU_BAS_TARIH	= CURDATE(),
				 								DUYURU_BIT_TARIH	= CURDATE(),
				 								GONDERIM_SEKLI		= :GONDERIM_SEKLI
												";
				$filtre[":ALICILAR"] 			= implode(',', $ALICILAR);
				$filtre[":YAYINLAYAN_ID"] 		= $_SESSION['kullanici_id'];
				$filtre[":BASLIK"] 				= date("Y-m-d");
				$filtre[":KONU"] 				= nl2br($row_sms_kalibi->SMS_KALIBI);
				$filtre[":GONDERIM_SEKLI"] 		= "SMS";
				$mesaj_id = $this->cdbPDO->lastInsertId($sql, $filtre);
			}
			
		}
		
		if($mesaj_id > 0){			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Mesaj Gönderildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function mesaj_ilet(){
		
		if($_REQUEST['kime_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kime gönderileceği seçiniz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['baslik']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Başlık en az 3 krakter olmalıdır!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['konu']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Konu kısmı en az 3 karakter olmalıdır!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO MESAJ SET 	KIME_ID 		= :KIME_ID,
		 								KIMDEN_ID 		= :KIMDEN_ID,
		 								BASLIK			= :BASLIK,
		 								KONU			= :KONU,
		 								ILET_MESAJ_ID	= :ILET_MESAJ_ID
										";
		$filtre[":KIME_ID"] 		= $_REQUEST['kime_id'];
		$filtre[":KIMDEN_ID"] 		= $_SESSION['kullanici_id'];
		$filtre[":BASLIK"] 			= $_REQUEST['baslik'];
		$filtre[":KONU"] 			= $_REQUEST['konu'];
		$filtre[":ILET_MESAJ_ID"] 	= $_REQUEST['ilet_mesaj_id'];
		$mesaj_id = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		if($mesaj_id > 0){
			//$this->fncIslemLog($mesaj_id, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "MESAJ", "cKayıt");
			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Mesaj iletildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function link_ekle(){
		
		if(strlen($_REQUEST['link_adi']) < 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Link adı en az 3 harfden oluşmaludır!!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['link']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Filtre butonuna basıldıktan sonra bunu yapmalısınız!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO LINK SET 	EKLEYEN_ID 		= :EKLEYEN_ID,
		 								LINK_ADI 		= :LINK_ADI,
		 								LINK			= :LINK
										";
		$filtre[":EKLEYEN_ID"] 		= $_SESSION['kullanici_id'];
		$filtre[":LINK_ADI"] 		= $_REQUEST['link_adi'];
		$filtre[":LINK"] 			= $_REQUEST['link'];
		$link_id = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		if($link_id > 0){			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Link eklendi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function link_sil(){
		/*
		$filtre	= array();
		$sql = "DELETE FROM LINK WHERE ID = :ID AND EKLEYEN_ID = :EKLEYEN_ID";
		$filtre[":ID"] 			= $_REQUEST["id"];
		$filtre[":EKLEYEN_ID"] 	= $_SESSION["kullanici_id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		*/
		
		$filtre	= array();
		$sql = "UPDATE LINK SET DURUM = 0 WHERE ID = :ID AND EKLEYEN_ID = :EKLEYEN_ID";
		$filtre[":ID"] 			= $_REQUEST["id"];
		$filtre[":EKLEYEN_ID"] 	= $_SESSION["kullanici_id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function ihale_cevap_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM IHALE_CEVAP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["CEVAP"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	
	
	
	public function bayrak_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM BAYRAK WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["BAYRAK"]	= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function bayrak_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE BAYRAK SET 	BAYRAK 		= :BAYRAK, 
									ICON 		= :ICON,
									DURUM		= :DURUM
								WHERE ID = :ID	
								";
		$filtre[":BAYRAK"] 		= trim($_REQUEST["bayrak"]);
		$filtre[":ICON"] 		= trim($_REQUEST["icon"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];	
		$filtre[":ID"] 			= $_REQUEST["id"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function bayrak_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO BAYRAK SET 	BAYRAK 		= :BAYRAK, 
										ICON 		= :ICON,
										DURUM		= :DURUM
									";
		$filtre[":BAYRAK"] 	= trim($_REQUEST["bayrak"]);
		$filtre[":ICON"] 		= trim($_REQUEST["icon"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];
		
		$bayrak_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($bayrak_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function ulke_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM ULKE WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["ULKE"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function ulke_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE ULKE SET 	ULKE 		= :ULKE, 
									TR 			= :TR,
									ENG			= :ENG,
									DURUM		= :DURUM
								WHERE ID = :ID	
								";
		$filtre[":ULKE"] 		= trim($_REQUEST["ulke"]);
		$filtre[":TR"] 			= trim($_REQUEST["tr"]);
		$filtre[":ENG"] 		= trim($_REQUEST["eng"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];	
		$filtre[":ID"] 			= $_REQUEST["id"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function ulke_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO ULKE SET 	ULKE 		= :ULKE, 
										TR 			= :TR,
										ENG			= :ENG,
										DURUM		= :DURUM
										";
		$filtre[":ULKE"] 		= trim($_REQUEST["ulke"]);
		$filtre[":TR"] 			= trim($_REQUEST["tr"]);
		$filtre[":ENG"] 		= trim($_REQUEST["eng"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];
		
		$ulke_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($ulke_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function il_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM IL WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["IL"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function il_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE IL SET 	IL 			= :IL, 
								ULKE_ID		= :ULKE_ID,
								KODU		= :KODU,
								DURUM		= :DURUM
							WHERE ID = :ID	
							";
		$filtre[":IL"] 			= trim($_REQUEST["il"]);
		$filtre[":ULKE_ID"] 	= trim($_REQUEST["ulke_id"]);
		$filtre[":KODU"] 		= trim($_REQUEST["kodu"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];	
		$filtre[":ID"] 			= $_REQUEST["id"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function il_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO IL SET 	IL 			= :IL, 
									ULKE_ID		= :ULKE_ID,
									KODU		= :KODU,
									DURUM		= :DURUM
									";
		$filtre[":IL"] 			= trim($_REQUEST["il"]);
		$filtre[":ULKE_ID"] 	= trim($_REQUEST["ulke_id"]);
		$filtre[":KODU"] 		= trim($_REQUEST["kodu"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];	
		
		$il_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($il_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function ilce_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM ILCE WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["ILCE"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function ilce_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE ILCE SET ILCE 		= :ILCE, 
								IL_ID		= :IL_ID,
								DURUM		= :DURUM
							WHERE ID = :ID	
							";
		$filtre[":ILCE"] 		= trim($_REQUEST["ilce"]);
		$filtre[":IL_ID"] 		= trim($_REQUEST["il_id"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];	
		$filtre[":ID"] 			= $_REQUEST["id"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function ilce_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO ILCE SET 	ILCE 		= :ILCE, 
										IL_ID		= :IL_ID,
										DURUM		= :DURUM
										";
		$filtre[":ILCE"] 		= trim($_REQUEST["ilce"]);
		$filtre[":IL_ID"] 		= trim($_REQUEST["il_id"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];	
		
		$ilce_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($ilce_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function renk_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM RENK WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["RENK"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function renk_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE RENK SET TARIH = NOW() ";
		if($_REQUEST["renk"]){
			$sql.= ", RENK = :RENK";
			$filtre[":RENK"] 		= trim($_REQUEST["renk"]);	
		}
		
		if($_REQUEST["renk_kod"]){
			$sql.= ", RENK_KOD = :RENK_KOD";
			$filtre[":RENK_KOD"] 		= trim($_REQUEST["renk_kod"]);	
		}									
		
		if(in_array($_REQUEST["durum"],array(0,1))){
			$sql.= ", DURUM = :DURUM";
			$filtre[":DURUM"] 		= trim($_REQUEST["durum"]);	
		}
		
		$sql .= " WHERE ID = :ID";
		
		if($_REQUEST["id"]){
			$filtre[":ID"] 		= $_REQUEST["id"];
		}
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function renk_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO RENK SET TARIH = NOW() ";
		if($_REQUEST["renk"]){
			$sql.= ", RENK = :RENK";
			$filtre[":RENK"] 		= trim($_REQUEST["renk"]);	
		}										
		
		if($_REQUEST["renk_kod"]){
			$sql.= ", RENK_KOD = :RENK_KOD";
			$filtre[":RENK_KOD"] 		= trim($_REQUEST["renk_kod"]);	
		}	
		
		if(in_array($_REQUEST["durum"],array(0,1))){
			$sql.= ", DURUM = :DURUM";
			$filtre[":DURUM"] 		= trim($_REQUEST["durum"]);	
		}
		
		if($_REQUEST["sira"]){
			$sql.= ", SIRA = :SIRA";
			$filtre[":SIRA"] 		= trim($_REQUEST["sira"]);	
		}
		
		$renk_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($renk_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function boyut_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM BOYUT WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["BOYUT"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function talep_evrak_turu_degistir(){
		
		if($_REQUEST['evrak_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Evrak türü seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim Bulunmadı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE TALEP_RESIM SET EVRAK_ID = :EVRAK_ID WHERE ID = :ID LIMIT 1";
		$filtre[":EVRAK_ID"] 	= $_REQUEST["evrak_id"];
		$filtre[":ID"] 			= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function kiralama_evrak_turu_degistir(){
		
		if($_REQUEST['evrak_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Evrak türü seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim Bulunmadı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE KIRALAMA_RESIM SET EVRAK_ID = :EVRAK_ID WHERE ID = :ID LIMIT 1";
		$filtre[":EVRAK_ID"] 	= $_REQUEST["evrak_id"];
		$filtre[":ID"] 			= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function ikame_evrak_turu_degistir(){
		
		if($_REQUEST['evrak_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Evrak türü seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim Bulunmadı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE IKAME_RESIM SET EVRAK_ID = :EVRAK_ID WHERE ID = :ID LIMIT 1";
		$filtre[":EVRAK_ID"] 	= $_REQUEST["evrak_id"];
		$filtre[":ID"] 			= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function arac_evrak_turu_degistir(){
		
		if($_REQUEST['evrak_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Evrak türü seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim Bulunmadı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE ARAC_RESIM SET EVRAK_ID = :EVRAK_ID WHERE ID = :ID LIMIT 1";
		$filtre[":EVRAK_ID"] 	= $_REQUEST["evrak_id"];
		$filtre[":ID"] 			= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function kargo_firmasi_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM KARGO_FIRMASI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 			= FALSE;
			$sonuc["ACIKLAMA"] 		= "Kaydedildi.";
			$sonuc["KARGO_FIRMASI"]	= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function kargo_firmasi_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE KARGO_FIRMASI SET TARIH = NOW() ";
		if($_REQUEST["kargo_firmasi"]){
			$sql.= ", KARGO_FIRMASI = :KARGO_FIRMASI";
			$filtre[":KARGO_FIRMASI"] 		= trim($_REQUEST["kargo_firmasi"]);	
		}
		
		if(in_array($_REQUEST["durum"],array(0,1))){
			$sql.= ", DURUM = :DURUM";
			$filtre[":DURUM"] 		= trim($_REQUEST["durum"]);	
		}
		
		if($_REQUEST["sira"]){
			$sql.= ", SIRA = :SIRA";
			$filtre[":SIRA"] 		= trim($_REQUEST["sira"]);	
		}
		
		$sql .= " WHERE ID = :ID";
		
		if($_REQUEST["id"]){
			$filtre[":ID"] 		= $_REQUEST["id"];
		}
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function kargo_firmasi_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO KARGO_FIRMASI SET TARIH = NOW() ";
		if($_REQUEST["kargo_firmasi"]){
			$sql.= ", KARGO_FIRMASI = :KARGO_FIRMASI";
			$filtre[":KARGO_FIRMASI"] 		= trim($_REQUEST["kargo_firmasi"]);	
		}										
		
		if(in_array($_REQUEST["durum"],array(0,1))){
			$sql.= ", DURUM = :DURUM";
			$filtre[":DURUM"] 		= trim($_REQUEST["durum"]);	
		}
		
		if($_REQUEST["sira"]){
			$sql.= ", SIRA = :SIRA";
			$filtre[":SIRA"] 		= trim($_REQUEST["sira"]);	
		}
		
		if($_REQUEST["sira"]){
			$sql.= ", SIRA = :SIRA";
			$filtre[":SIRA"] 		= trim($_REQUEST["sira"]);	
		}
		
		$renk_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($renk_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function banka_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM BANKA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["BANKA"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function banka_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE BANKA SET 	BANKA 		= :BANKA,
									MALI_KODU	= :MALI_KODU,
									DURUM 		= :DURUM,
									SIRA 		= :SIRA
								WHERE ID = :ID
								";
		$filtre[":BANKA"] 		= trim($_REQUEST["banka"]);	
		$filtre[":MALI_KODU"] 	= trim($_REQUEST["mali_kodu"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];	
		$filtre[":SIRA"] 		= $_REQUEST["sira"];	
		$filtre[":ID"] 			= $_REQUEST["id"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function banka_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO BANKA SET 	BANKA 			= :BANKA,
										MALI_KODU_ID	= :MALI_KODU_ID,
										DURUM 			= :DURUM,
										SIRA 			= :SIRA
										";
		$filtre[":BANKA"] 		= trim($_REQUEST["banka"]);
		$filtre[":MALI_KODU_ID"]= $_REQUEST["mali_kodu_id"];											
		$filtre[":DURUM"] 		= $_REQUEST["durum"];	
		$filtre[":SIRA"] 		= $_REQUEST["sira"];
		
		$banka_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($banka_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function kampanya_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM KAMPANYA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["KAMPANYA"]	= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function kampanya_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT * FROM KAMPANYA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE KAMPANYA SET KAMPANYA 	= :KAMPANYA,
									ISKONTO		= :ISKONTO,
									DURUM		= :DURUM
								WHERE ID = :ID
								";
		$filtre[":KAMPANYA"] 		= trim($_REQUEST["kampanya"]);
		$filtre[":ISKONTO"] 		= str_replace(',', '.', trim($_REQUEST["iskonto"]));
		$filtre[":DURUM"] 			= $_REQUEST["durum"];
		$filtre[":ID"] 				= $_REQUEST["id"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if(TRUE){
			$this->fncIslemLog($row->ID, $row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "KAMPANYA", "cKayit");
			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function kampanya_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO KAMPANYA SET 	KAMPANYA 	= :KAMPANYA,
											ISKONTO		= :ISKONTO,
											DURUM		= :DURUM
											";
		$filtre[":KAMPANYA"] 		= trim($_REQUEST["kampanya"]);
		$filtre[":ISKONTO"] 		= str_replace(',', '.', trim($_REQUEST["iskonto"]));
		$filtre[":DURUM"] 			= $_REQUEST["durum"];
						
		$kampanya_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($kampanya_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function site_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE SITE SET BASLIK 			= :BASLIK,
								ALTBASLIK		= :ALTBASLIK,
								TITLE			= :TITLE,
								FIRMA_ADI		= :FIRMA_ADI,
								WEBSITE_URL		= :WEBSITE_URL,
								LOGO			= :LOGO,
								LOGO2			= :LOGO2,
								URL				= :URL,
								TANIM			= :TANIM,
								ALTYAZI			= :ALTYAZI,
								SAHIBI			= :SAHIBI,
								TCK				= :TCK,
								KURULUS_TARIHI	= :KURULUS_TARIHI,
								CALISMA_SAATLERI= :CALISMA_SAATLERI,
								TEMA_ID			= :TEMA_ID,
								FATURA_NO		= :FATURA_NO
							WHERE 1
							LIMIT 1
							";
		$filtre[":BASLIK"] 			= trim($_REQUEST["baslik"]);
		$filtre[":ALTBASLIK"] 		= trim($_REQUEST["altbaslik"]);
		$filtre[":TITLE"] 			= trim($_REQUEST["title"]);
		$filtre[":FIRMA_ADI"] 		= trim($_REQUEST["firma_adi"]);
		$filtre[":WEBSITE_URL"] 	= trim($_REQUEST["website_url"]);
		$filtre[":LOGO"] 			= trim($_REQUEST["logo"]);
		$filtre[":LOGO2"] 			= trim($_REQUEST["logo2"]);
		$filtre[":URL"] 			= trim($_REQUEST["url"]);
		$filtre[":TANIM"] 			= trim($_REQUEST["tanim"]);
		$filtre[":ALTYAZI"] 		= trim($_REQUEST["altyazi"]);
		$filtre[":SAHIBI"] 			= trim($_REQUEST["sahibi"]);
		$filtre[":TCK"] 			= trim($_REQUEST["tck"]);
		$filtre[":KURULUS_TARIHI"] 	= FormatTarih::nokta2db($_REQUEST["kurulus_tarihi"]);
		$filtre[":CALISMA_SAATLERI"]= trim($_REQUEST["calisma_saatleri"]);
		$filtre[":TEMA_ID"]			= $_REQUEST["tema_id"];
		$filtre[":FATURA_NO"] 		= trim($_REQUEST["fatura_no"]);		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function site_parametre_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE SITE SET MAKSIMUM_ISKONTO 	= :MAKSIMUM_ISKONTO,
								TEKNE_RISK_LIMITI	= :TEKNE_RISK_LIMITI,
								CARI_RISK_LIMITI	= :CARI_RISK_LIMITI,
								IHBAR_SURESI		= :IHBAR_SURESI
							WHERE ID = 1
							";
		$filtre[":MAKSIMUM_ISKONTO"] 	= $_REQUEST["maksimum_iskonto"];
		$filtre[":TEKNE_RISK_LIMITI"] 	= $_REQUEST["tekne_risk_limiti"];
		$filtre[":CARI_RISK_LIMITI"] 	= $_REQUEST["cari_risk_limiti"];
		$filtre[":IHBAR_SURESI"] 		= $_REQUEST["ihbar_suresi"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function site_banner_yukle(){
		$say = 0;
		
		$YOL 			= $this->cSabit->imgPathFolder("banner");
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		foreach($_FILES['site_banner']['name'] as $key => $resim){
			$DOSYA_TAM_AD	= $_FILES['site_banner']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['site_banner']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['site_banner']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				// kapak resminin yüklenmesi
				$filtre	= array();
				$sql = "INSERT INTO SITE_BANNER SET EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= 1,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													DURUM			= 0
													";
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;
				
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
			
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.".$say;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı yada yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function site_resim_yukle(){
		$say = 0;
		
		$YOL 			= $this->cSabit->imgPathFolder("site");
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		foreach($_FILES['site_resim']['name'] as $key => $resim){
			$DOSYA_TAM_AD	= $_FILES['site_resim']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['site_resim']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['site_resim']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				// kapak resminin yüklenmesi
				$filtre	= array();
				$sql = "INSERT INTO SITE_RESIM SET 	SITE_ID 		= :SITE_ID,
													EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= 1,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													DURUM			= 0
													";
				$filtre[':SITE_ID']			= 1;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;
				
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
			
		if($say>0){
			$sonuc["SITE_ID"] 	= 1;
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.".$say;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı yada yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function giris_resim_yukle(){
		$say = 0;
		
		$YOL 			= $this->cSabit->imgPathFolder("site");
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		foreach($_FILES['giris_resim']['name'] as $key => $resim){
			$DOSYA_TAM_AD	= $_FILES['giris_resim']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['giris_resim']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['giris_resim']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				// kapak resminin yüklenmesi
				$filtre	= array();
				$sql = "INSERT INTO GIRIS_RESIM SET EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= 1,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													DURUM			= 0
													";
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;
				
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
			
		if($say>0){
			$sonuc["SITE_ID"] 	= 1;
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.".$say;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı yada yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function talep_resim_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(T.TARIH) AS YIL,
					T.ID
				FROM TALEP AS T
				WHERE T.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("talep") . $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['talep_resim']['name'] as $key => $resim){
			
			$DOSYA_TAM_AD	= $_FILES['talep_resim']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['talep_resim']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['talep_resim']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO TALEP_RESIM SET	TALEP_ID		= :TALEP_ID,
													EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= 2,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													EVRAK_ID		= :EVRAK_ID,		
													DURUM			= 0
													";
				$filtre[':TALEP_ID']		= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;				
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;
	}
	
	public function cari_hareket_resim_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(CH.TARIH) AS YIL,
					CH.ID
				FROM CARI_HAREKET AS CH
				WHERE CH.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("cari_hareket") . $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['cari_hareket_resim']['name'] as $key => $resim){
			
			$DOSYA_TAM_AD	= $_FILES['cari_hareket_resim']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['cari_hareket_resim']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['cari_hareket_resim']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO CARI_HAREKET_RESIM SET	CARI_HAREKET_ID	= :CARI_HAREKET_ID,
															EKLEYEN_ID 		= :EKLEYEN_ID,
															RESIM_BASLIK 	= :RESIM_BASLIK,
															RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
															SIRA 			= 2,
															RESIM_ADI		= :RESIM_ADI,
															RESIM_ADI_ILK	= :RESIM_ADI_ILK,
															EVRAK_ID		= :EVRAK_ID,		
															DURUM			= 0
															";
				$filtre[':CARI_HAREKET_ID']	= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;				
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
		
		if($say > 0){
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET RESIM_VAR = 1 WHERE ID = :ID";
			$filtre[":ID"] 	= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;
	}
	
	public function stok_resim_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(S.TARIH) AS YIL,
					S.ID
				FROM STOK AS S
				WHERE S.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("stok") . $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['stok_resim']['name'] as $key => $resim){
			
			$DOSYA_TAM_AD	= $_FILES['stok_resim']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['stok_resim']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['stok_resim']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$filtre	= array();
				$sql = "SELECT IFNULL(MAX(SIRA),0)+1 AS SIRA FROM STOK_RESIM WHERE STOK_ID = :STOK_ID";
				$filtre[":STOK_ID"] 	= $row->ID;
				$row_sira = $this->cdbPDO->row($sql, $filtre);
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO STOK_RESIM SET	STOK_ID			= :STOK_ID,
													EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= :SIRA,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													EVRAK_ID		= :EVRAK_ID,		
													DURUM			= 0
															";
				$filtre[':STOK_ID']	= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':SIRA']			= $row_sira->SIRA;
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;				
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
		
		if($say > 0 AND FALSE){
			$filtre	= array();
			$sql = "UPDATE STOK SET RESIM_VAR = 1 WHERE ID = :ID";
			$filtre[":ID"] 	= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;
	}
	
	public function talep_evrak_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(T.TARIH) AS YIL,
					T.ID
				FROM TALEP AS T
				WHERE T.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("talep") . $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['talep_evrak']['name'] as $key => $resim){
			$DOSYA_TAM_AD	= $_FILES['talep_evrak']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['talep_evrak']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['talep_evrak']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO TALEP_RESIM SET	TALEP_ID		= :TALEP_ID,
													EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= 2,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													EVRAK_ID		= :EVRAK_ID,		
													DURUM			= 0
													";
				$filtre[':TALEP_ID']		= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];		
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
				
				if($_REQUEST['evrak_id'] == 12){
					$filtre	= array();
					$sql = "UPDATE TALEP SET 	SUREC_ID			= 3,
												ARAC_SERVISTE_TARIH	= NOW(),	
												GTARIH				= NOW()
										WHERE ID = :ID AND SUREC_ID IN(1,2)
										";
					$filtre[":ID"] 				= $row->ID;
					$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				}
			}
		}
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function talep_resim_dondur_90(){
		
		$filtre = array();
		$sql = "SELECT
					YEAR(T.TARIH) AS YIL,
					TR.RESIM_ADI,
					TR.TALEP_ID
				FROM TALEP_RESIM AS TR
					LEFT JOIN TALEP AS T ON T.ID = IR.TALEP_ID
				WHERE TR.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
	    
	    $this->cSimpleImage->fromFile($this->cSabit->imgPathFolder("talep") . $row->YIL . "/" . $row->TALEP_ID . "/" . $row->RESIM_ADI)
							->rotate(90)
							->toFile($this->cSabit->imgPathFolder("talep") . $row->YIL . "/" . $row->TALEP_ID . "/" . $row->RESIM_ADI);
		chmod($YOL, 0755);		
		
		if(TRUE){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi." .$_REQUEST['id'];
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hata!";
		}
		
		return $sonuc;	
	}
	
	public function arac_evrak_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(A.TARIH) AS YIL,
					A.ID
				FROM ARAC AS A
				WHERE A.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("arac") . $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['arac_evrak']['name'] as $key => $resim){
			$DOSYA_TAM_AD	= $_FILES['arac_evrak']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['arac_evrak']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['arac_evrak']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO ARAC_RESIM SET	ARAC_ID			= :ARAC_ID,
													EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= 2,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													EVRAK_ID		= :EVRAK_ID,		
													DURUM			= 0
													";
				$filtre[':ARAC_ID']			= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];		
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function kiralama_resim_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(K.TARIH) AS YIL,
					K.ID
				FROM KIRALAMA AS K
				WHERE K.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("kiralama") . $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['kiralama_resim']['name'] as $key => $resim){
			
			$DOSYA_TAM_AD	= $_FILES['kiralama_resim']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['kiralama_resim']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['kiralama_resim']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO KIRALAMA_RESIM SET	KIRALAMA_ID		= :KIRALAMA_ID,
														EKLEYEN_ID 		= :EKLEYEN_ID,
														RESIM_BASLIK 	= :RESIM_BASLIK,
														RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
														SIRA 			= 2,
														RESIM_ADI		= :RESIM_ADI,
														RESIM_ADI_ILK	= :RESIM_ADI_ILK,
														EVRAK_ID		= :EVRAK_ID,		
														DURUM			= 0
														";
				$filtre[':KIRALAMA_ID']		= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;				
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function cari_evrak_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(C.TARIH) AS YIL,
					C.ID
				FROM CARI AS C
				WHERE C.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("cari"). $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['cari_evrak']['name'] as $key => $resim){
			$DOSYA_TAM_AD	= $_FILES['cari_evrak']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['cari_evrak']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['cari_evrak']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO CARI_RESIM SET	CARI_ID			= :CARI_ID,
													EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= 2,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													EVRAK_ID		= :EVRAK_ID,		
													DURUM			= 0
													";
				$filtre[':CARI_ID']			= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];		
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function kiralama_evrak_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(K.TARIH) AS YIL,
					K.ID
				FROM KIRALAMA AS K
				WHERE K.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("kiralama") . $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['kiralama_evrak']['name'] as $key => $resim){
			$DOSYA_TAM_AD	= $_FILES['kiralama_evrak']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['kiralama_evrak']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['kiralama_evrak']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO KIRALAMA_RESIM SET	KIRALAMA_ID		= :KIRALAMA_ID,
														EKLEYEN_ID 		= :EKLEYEN_ID,
														RESIM_BASLIK 	= :RESIM_BASLIK,
														RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
														SIRA 			= 2,
														RESIM_ADI		= :RESIM_ADI,
														RESIM_ADI_ILK	= :RESIM_ADI_ILK,
														EVRAK_ID		= :EVRAK_ID,		
														DURUM			= 0
														";
				$filtre[':KIRALAMA_ID']		= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];		
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
				/*
				if($_REQUEST['evrak_id'] == 12){
					$filtre	= array();
					$sql = "UPDATE KIRALAMA SET 	SUREC_ID			= 3,
													ARAC_SERVISTE_TARIH	= NOW(),	
													GTARIH				= NOW()
											WHERE ID = :ID AND SUREC_ID IN(1,2)
											";
					$filtre[":ID"] 				= $row->ID;
					$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				}
				*/
			}
		}
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function ikame_resim_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(I.TARIH) AS YIL,
					I.ID
				FROM TALEP_IKAME AS I
				WHERE I.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("ikame") . $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['ikame_resim']['name'] as $key => $resim){
			
			$DOSYA_TAM_AD	= $_FILES['ikame_resim']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['ikame_resim']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['ikame_resim']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO IKAME_RESIM SET	IKAME_ID		= :IKAME_ID,
													EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= 2,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													EVRAK_ID		= :EVRAK_ID,		
													DURUM			= 0
													";
				$filtre[':IKAME_ID']		= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;				
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
			}
		}
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function ikame_evrak_yukle(){
		$say = 0;
		
		$filtre = array();
		$sql = "SELECT
					YEAR(I.TARIH) AS YIL,
					I.ID
				FROM TALEP_IKAME AS I
				WHERE I.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("ikame") . $row->YIL . "/" . $row->ID . "/";
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
		foreach($_FILES['ikame_evrak']['name'] as $key => $resim){
			$DOSYA_TAM_AD	= $_FILES['ikame_evrak']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['ikame_evrak']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['ikame_evrak']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				
				$row_ir->SAY++; 
				
				$filtre	= array();
				$sql = "INSERT INTO IKAME_RESIM SET	IKAME_ID		= :IKAME_ID,
													EKLEYEN_ID 		= :EKLEYEN_ID,
													RESIM_BASLIK 	= :RESIM_BASLIK,
													RESIM_ACIKLAMA 	= :RESIM_ACIKLAMA,
													SIRA 			= 2,
													RESIM_ADI		= :RESIM_ADI,
													RESIM_ADI_ILK	= :RESIM_ADI_ILK,
													EVRAK_ID		= :EVRAK_ID,		
													DURUM			= 0
													";
				$filtre[':IKAME_ID']		= $row->ID;
				$filtre[':EKLEYEN_ID']		= $_SESSION['kullanici_id'];
				$filtre[':RESIM_BASLIK']	= "";
				$filtre[':RESIM_ACIKLAMA']	= "";
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;
				$filtre[':EVRAK_ID']		= $_REQUEST['evrak_id'];		
				$resim_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($resim_id > 0){
					$say++;	
				}
				/*
				if($_REQUEST['evrak_id'] == 12){
					$filtre	= array();
					$sql = "UPDATE IKAME SET 	SUREC_ID			= 3,
												ARAC_SERVISTE_TARIH	= NOW(),	
												GTARIH				= NOW()
										WHERE ID = :ID AND SUREC_ID IN(1,2)
										";
					$filtre[":ID"] 				= $row->ID;
					$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				}
				*/
			}
		}
		
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı ya da yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function excel_yukle(){
		$say = 0;
		
		$YOL 			= $this->cSabit->imgPathFolder("excel");
		if(!file_exists($YOL)){
			mkdir($YOL, 0777, true);
		}
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		$DOSYA_TAM_AD	= $_FILES['excel']['name'];
		$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		$DOSYA_AD 		= $DOSYA[0]; 
		$DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		
		list($usec, $sec)= explode(' ',microtime());  
	  	$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  	$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		
		copy($_FILES['excel']['tmp_name'], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
		chmod($YOL . $TIMESTAMP, 0755);
		unlink($_FILES['excel']['tmp_name']); 
		
		if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
			// kapak resminin yüklenmesi
			$filtre	= array();
			$sql = "INSERT INTO EXCEL SET	YUKLEYEN_ID 	= :YUKLEYEN_ID,
											EXCEL		 	= :EXCEL,
											EXCEL_ILK	 	= :EXCEL_ILK,
											TUR	 			= :TUR
											";
			$filtre[':YUKLEYEN_ID']		= $_SESSION['kullanici_id'];
			$filtre[':EXCEL']			= $TIMESTAMP . "." . $DOSYA_UZANTI;
			$filtre[':EXCEL_ILK']		= $DOSYA_TAM_AD;			
			$filtre[':TUR']			= 2;
			$excel_id = $this->cdbPDO->lastInsertId($sql, $filtre);
			
			if($excel_id > 0){
				$say++;	
			}
		}
		
		//$this->fncIslemLog($_REQUEST['ihale_id'], $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "IHALE_RESIM", "cKayıt");
			
		if($say>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.".$say;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Diğer resim bulunamadı yada yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	
	public function haber_resim_yukle(){
		
		$YOL 			= $this->cSabit->imgPathFolder("haber");
		if(!file_exists($YOL)){
			mkdir($YOL, 0777, true);
		}
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		$DOSYA_TAM_AD	= $_FILES['resim']['name'];
		$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		$DOSYA_AD 		= $DOSYA[0]; 
		$DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		
		list($usec, $sec)= explode(' ',microtime());  
	  	$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  	$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		
		copy($_FILES['resim']['tmp_name'], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
		chmod($YOL . $TIMESTAMP, 0755);
		unlink($_FILES['resim']['tmp_name']); 
		
		if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
			// kapak resminin yüklenmesi
			if(isset($_REQUEST['haber_id'])){
				$filtre	= array();
				$sql = "UPDATE HABER SET RESIM_URL = :RESIM_URL WHERE ID = :ID";
				$filtre[':ID']				= $_REQUEST['haber_id'];
				$filtre[':RESIM_URL']		= $TIMESTAMP .".". $DOSYA_UZANTI;
				
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
				if($rowsCount > 0){
					$sonuc["RESIM_ADI"]	= $TIMESTAMP .".". $DOSYA_UZANTI;
					$sonuc["HATA"] 		= FALSE;
					$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
				}else{
					$sonuc["HATA"] 		= TRUE;
					$sonuc["ACIKLAMA"] 	= "Bir hata oluştu!";
				}
			}else{
				$sonuc["RESIM_ADI"]	= $TIMESTAMP .".". $DOSYA_UZANTI;
				$sonuc["HATA"] 		= FALSE;
				$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			}
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bir hata oluştu!";
		}
		
		if($sonuc["HATA"] == FALSE){
			$this->fncIslemLog($TIMESTAMP .".". $DOSYA_UZANTI, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "HABER_RESIM", "cKayıt");
		}
		
		return $sonuc;	
	}
	
	public function haber_resim_sil(){		
		$YOL 			= $this->cSabit->imgPathFolder("haber");
		
		if(!$_REQUEST['resim_url']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		if($_REQUEST['haber_id']){
			$filtre	= array();
			$sql = "UPDATE HABER SET RESIM_URL = '' WHERE ID = :ID";
			$filtre[":ID"] 			= $_REQUEST['haber_id'];
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			if($rowsCount>0){
				unlink($YOL . $_REQUEST['resim_url']);
				$sonuc["HATA"] 		= FALSE;
				$sonuc["ACIKLAMA"] 	= "Silindi.";
			}else{
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
			}
			
		}else{
			unlink($YOL . $_REQUEST['resim_url']);
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}
			
		return $sonuc;
	}
	
	public function stok_resim_sil(){
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		/*
		if(!in_array($_SESSION['yetki_id'],array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		*/
		
		
		$filtre = array();
		$sql = "SELECT
					YEAR(S.TARIH) AS YIL,
					S.ID,					
					TR.RESIM_ADI,
					TR.SIRA,
					TR.DURUM,
					TR.STOK_ID
				FROM STOK_RESIM AS TR
					LEFT JOIN STOK AS S ON S.ID = TR.STOK_ID
				WHERE TR.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim bulunamadı!";	
			return $sonuc;
		}
		
		$sira = $row->SIRA;
		$stok_id = $row->STOK_ID;
		
		$filtre	= array();
		$sql = "DELETE FROM STOK_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	

		//Silinen resmin sira numarasından büyük resimlerin sirası bir sayı azaltılıyor...
		$filtre	= array();
		$sql = "UPDATE STOK_RESIM SET SIRA = SIRA - 1 WHERE STOK_ID = :STOK_ID AND SIRA > :SIRA";
		$filtre[":STOK_ID"] 		= $stok_id;
		$filtre[":SIRA"] 			= $sira;
		$this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
			$YOL 			= $this->cSabit->imgPathFolder("stok") . $row->YIL . "/" . $row->STOK_ID . "/";
			unlink($YOL . $row->RESIM_ADI);
			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function haber_ekle(){
		
		if(strlen($_REQUEST['baslik']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Başlık en az 3 krakter olmalıdır!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['konu']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Konu kısmı en az 3 karakter olmalıdır!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO HABER SET 	EKLEYEN_ID 		= :EKLEYEN_ID,
		 								BASLIK			= :BASLIK,
		 								KONU			= :KONU,
		 								RESIM_URL		= :RESIM_URL,
		 								TARIH			= NOW()
										";

		$filtre[":EKLEYEN_ID"] 		= $_SESSION['kullanici_id'];
		$filtre[":BASLIK"] 			= $_REQUEST['baslik'];
		$filtre[":KONU"] 			= $_REQUEST['konu'];
		$filtre[":RESIM_URL"]		= $_REQUEST['resim_url'];
		$haber_id = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		if($haber_id > 0){
			//$this->fncIslemLog($mesaj_id, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "MESAJ", "cKayıt");
			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Haber eklendi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function haber_duzenle(){
		
		if(count($_REQUEST['haber_id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler eksik!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['baslik']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Başlık en az 3 krakter olmalıdır!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['konu']) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Konu kısmı en az 3 karakter olmalıdır!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE	 HABER SET 		BASLIK			= :BASLIK,
		 								KONU			= :KONU,
		 								RESIM_URL		= :RESIM_URL,
		 								TARIH			= NOW()
		 				WHERE ID = :ID
										";

		$filtre[":ID"] 			= $_REQUEST['haber_id'];
		$filtre[":BASLIK"] 			= $_REQUEST['baslik'];
		$filtre[":KONU"] 			= $_REQUEST['konu'];
		$filtre[":RESIM_URL"]		= $_REQUEST['resim_url'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			//$this->fncIslemLog($mesaj_id, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "MESAJ", "cKayıt");
			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Haber düzenlendi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}

	public function haber_sil(){
		$filtre	= array();
		$sql = "DELETE FROM HABER WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["haber_id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$YOL 			= $this->cSabit->imgPathFolder("haber");
		
		if($rowsCount>0){
			unlink($YOL . $_REQUEST['resim_url']);
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
			$sonuc["KULLANICI_ID"] = $KULLANICI_ID;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function logo_resim_sil(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM SITE_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->DURUM == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aktif olan resim silinemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM SITE_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function logo_resim_aktif(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE SITE_RESIM SET DURUM = 0 WHERE DURUM IN(0,1)";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE SITE_RESIM SET DURUM = 1 WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function stok_resim_aktif(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE STOK_RESIM SET SIRA = 1 WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM STOK_RESIM WHERE STOK_ID = :STOK_ID AND ID != :ID ORDER BY SIRA";
		$filtre[":STOK_ID"] 	= $_REQUEST['stok_id'];
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rows = $this->cdbPDO->rows($sql, $filtre); 
		
		foreach($rows as $key => $row){
			$filtre	= array();
			$sql = "UPDATE STOK_RESIM SET SIRA = :SIRA WHERE ID = :ID";
			$filtre[":SIRA"] 		= $key+2;
			$filtre[":ID"] 			= $row->ID;
			$this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function giris_resim_sil(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM GIRIS_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->DURUM == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aktif olan resim silinemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM GIRIS_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function giris_resim_aktif(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE GIRIS_RESIM SET DURUM = 0 WHERE DURUM IN(0,1)";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE GIRIS_RESIM SET DURUM = 1 WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function site_banner_sil(){
		
		$YOL 			= $this->cSabit->imgPathFolder("banner");
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM SITE_BANNER WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->DURUM == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aktif olan resim silinemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM SITE_BANNER WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			unlink($YOL . $row->RESIM_ADI);
			
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function site_banner_aktif(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
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
				WHERE SR.ID = :ID
				";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE SITE_BANNER SET DURUM = 0 WHERE DURUM IN(0,1)";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE SITE_BANNER SET DURUM = 1 WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE SITE SET BANNER = :BANNER WHERE 1";
		$filtre[":BANNER"] 			= $this->cSabit->imgPath($row->URL);
		$this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function kullanici_resim_sil(){
		
		$YOL 			= $this->cSabit->imgPathFolder("kullanici");
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		
		$filtre	= array();
		$sql = "SELECT * FROM KULLANICI_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->DURUM == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aktif olan resim silinemez!";
			return $sonuc;
		}
		
		if(in_array($row->RESIM_ADI, array("14699786047205.jpg", "15072258471704.jpg"))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ön tanımlı resimler silinemez!";
			return $sonuc;
		}
		
		unlink($YOL . $row->RESIM_ADI);
		
		$filtre	= array();
		$sql = "DELETE FROM KULLANICI_RESIM  WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function talep_resim_sil(){
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		if(!in_array($_SESSION['yetki_id'],array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT
					YEAR(I.TARIH) AS YIL,
					IR.RESIM_ADI,
					IR.SIRA,
					IR.DURUM,
					IR.TALEP_ID
				FROM TALEP_RESIM AS IR
					LEFT JOIN TALEP AS I ON I.ID = IR.TALEP_ID
				WHERE IR.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$sira = $row->SIRA;
		$talep_id = $row->TALEP_ID;
		
		if($row->DURUM == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aktif olan resim silinemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM TALEP_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	

		//Silinen resmin sira numarasından büyük resimlerin sirası bir sayı azaltılıyor...
		$filtre	= array();
		$sql = "UPDATE TALEP_RESIM SET SIRA = SIRA - 1 WHERE TALEP_ID = :TALEP_ID AND SIRA > :SIRA";
		$filtre[":TALEP_ID"] 		= $talep_id;
		$filtre[":SIRA"] 			= $sira;
		$this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
			$YOL 			= $this->cSabit->imgPathFolder("talep") . $row->YIL . "/" . $row->TALEP_ID . "/";
			unlink($YOL . $row->RESIM_ADI);
			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function cari_evrak_sil(){
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		if(!in_array($_SESSION['yetki_id'],array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT
					YEAR(C.TARIH) AS YIL,
					IR.RESIM_ADI,
					IR.SIRA,
					IR.DURUM,
					IR.CARI_ID
				FROM CARI_RESIM AS IR
					LEFT JOIN CARI AS C ON C.ID = IR.CARI_ID
				WHERE IR.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$sira = $row->SIRA;
		$cari_id = $row->CARI_ID;
		
		if($row->DURUM == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aktif olan resim silinemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM CARI_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	

		//Silinen resmin sira numarasından büyük resimlerin sirası bir sayı azaltılıyor...
		$filtre	= array();
		$sql = "UPDATE CARI_RESIM SET SIRA = SIRA - 1 WHERE CARI_ID = :CARI_ID AND SIRA > :SIRA";
		$filtre[":CARI_ID"] 		= $cari_id;
		$filtre[":SIRA"] 			= $sira;
		$this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
			$YOL 			= $this->cSabit->imgPathFolder("cari"). $row->YIL . "/" . $row->CARI_ID . "/";
			unlink($YOL . $row->RESIM_ADI);
			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function cari_hareket_resim_sil(){
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT
					YEAR(CH.TARIH) AS YIL,
					CHR.RESIM_ADI,
					CHR.SIRA,
					CHR.DURUM,
					CHR.CARI_HAREKET_ID
				FROM CARI_HAREKET_RESIM AS CHR
					LEFT JOIN CARI_HAREKET AS CH ON CH.ID = CHR.CARI_HAREKET_ID
				WHERE CHR.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$sira = $row->SIRA;
		$cari_hareket_id = $row->CARI_HAREKET_ID;
		
		if($row->DURUM == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aktif olan resim silinemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM CARI_HAREKET_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
	
		//Silinen resmin sira numarasından büyük resimlerin sirası bir sayı azaltılıyor...
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET_RESIM SET SIRA = SIRA - 1 WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID AND SIRA > :SIRA";
		$filtre[":CARI_HAREKET_ID"] = $cari_hareket_id;
		$filtre[":SIRA"] 			= $sira;
		$this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
			$YOL 			= $this->cSabit->imgPathFolder("cari_hareket") . $row->YIL . "/" . $row->CARI_HAREKET_ID . "/";
			unlink($YOL . $row->RESIM_ADI);
			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function kiralama_resim_sil(){
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		if(!in_array($_SESSION['yetki_id'],array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT
					YEAR(I.TARIH) AS YIL,
					IR.RESIM_ADI,
					IR.SIRA,
					IR.DURUM,
					IR.KIRALAMA_ID
				FROM KIRALAMA_RESIM AS IR
					LEFT JOIN KIRALAMA AS I ON I.ID = IR.KIRALAMA_ID
				WHERE IR.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$sira = $row->SIRA;
		$kiralama_id = $row->KIRALAMA_ID;
		
		if($row->DURUM == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aktif olan resim silinemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM KIRALAMA_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	

		//Silinen resmin sira numarasından büyük resimlerin sirası bir sayı azaltılıyor...
		$filtre	= array();
		$sql = "UPDATE KIRALAMA_RESIM SET SIRA = SIRA - 1 WHERE KIRALAMA_ID = :KIRALAMA_ID AND SIRA > :SIRA";
		$filtre[":KIRALAMA_ID"] 	= $kiralama_id;
		$filtre[":SIRA"] 			= $sira;
		$this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
			$YOL 			= $this->cSabit->imgPathFolder("kiralama") . $row->YIL . "/" . $row->KIRALAMA_ID . "/";
			unlink($YOL . $row->RESIM_ADI);
			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function arac_resim_sil(){
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek resim seçilmemiş!";
			return $sonuc;
		}
		
		if(!in_array($_SESSION['yetki_id'],array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT
					YEAR(A.TARIH) AS YIL,
					IR.RESIM_ADI,
					IR.SIRA,
					IR.DURUM,
					IR.ARAC_ID
				FROM ARAC_RESIM AS IR
					LEFT JOIN ARAC AS A ON A.ID = IR.ARAC_ID
				WHERE IR.ID = :ID
				";
		$filtre[":ID"]	= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$sira = $row->SIRA;
		$arac_id = $row->ARAC_ID;
		
		if($row->DURUM == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aktif olan resim silinemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM ARAC_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	

		//Silinen resmin sira numarasından büyük resimlerin sirası bir sayı azaltılıyor...
		$filtre	= array();
		$sql = "UPDATE ARAC_RESIM SET SIRA = SIRA - 1 WHERE ARAC_ID = :ARAC_ID AND SIRA > :SIRA";
		$filtre[":ARAC_ID"] 		= $arac_id;
		$filtre[":SIRA"] 			= $sira;
		$this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
			$YOL 			= $this->cSabit->imgPathFolder("arac") . $row->YIL . "/" . $row->ARAC_ID . "/";
			unlink($YOL . $row->RESIM_ADI);
			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function kiralama_toplu_resim_sil(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, YEAR(TARIH) AS YIL FROM KIRALAMA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		
		foreach($_REQUEST['resim_sec'] as $key => $value){
			$ids[] = $key;
		}
		
		$filtre = array();
		$sql = "SELECT
					KR.ID,
					KR.RESIM_ADI,
					KR.RESIM_ADI_ILK
				FROM KIRALAMA_RESIM AS KR
				WHERE KR.KIRALAMA_ID = :KIRALAMA_ID AND FIND_IN_SET(KR.ID,:IDS)
				";
		$filtre[":KIRALAMA_ID"]	= $row->ID;
		$filtre[":IDS"]			= implode(',', $ids);
		$rows_resim = $this->cdbPDO->rows($sql, $filtre);
		
		if(count($rows_resim) == 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Seçili Resim Bulunamadı!";
			return $sonuc;
		}
		
		foreach($rows_resim as $key => $row_resim){
			$filtre	= array();
			$sql = "DELETE FROM KIRALAMA_RESIM WHERE ID = :ID";
			$filtre[":ID"] 			= $row_resim->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
			
			$YOL 			= $this->cSabit->imgPathFolder("kiralama") . $row->YIL . "/" . $row->ID . "/";
			unlink($YOL . $row_resim->RESIM_ADI);
			
		}
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function talep_toplu_resim_sil(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID, YEAR(TARIH) AS YIL FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		
		foreach($_REQUEST['resim_sec'] as $key => $value){
			$ids[] = $key;
		}
		
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
		$rows_resim = $this->cdbPDO->rows($sql, $filtre);
		
		if(count($rows_resim) == 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Seçili Resim Bulunamadı!";
			return $sonuc;
		}
		
		foreach($rows_resim as $key => $row_resim){
			$filtre	= array();
			$sql = "DELETE FROM TALEP_RESIM WHERE ID = :ID";
			$filtre[":ID"] 			= $row_resim->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
			
			$YOL 			= $this->cSabit->imgPathFolder("talep") . $row->YIL . "/" . $row->ID . "/";
			unlink($YOL . $row_resim->RESIM_ADI);
			
		}
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}

	public function ihale_resim_aktif(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM IHALE_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE IHALE_RESIM SET DURUM = 0 WHERE IHALE_ID = :IHALE_ID";
		$filtre[":IHALE_ID"] 	= $row->IHALE_ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE IHALE_RESIM SET DURUM = 1 WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function ihale_resim_sira_degistir(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM IHALE_RESIM WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if($_REQUEST['sira'] == 1){
			/*
			$filtre	= array();
			$sql = "SELECT COUNT(*) AS SAY FROM IHALE_RESIM WHERE IHALE_ID = :IHALE_ID";
			$filtre[":IHALE_ID"] 	= $row->IHALE_ID;
			$row_ir = $this->cdbPDO->row($sql, $filtre);
			*/
			$filtre = array();
			$sql = "UPDATE IHALE_RESIM SET SIRA = :SIRA WHERE SIRA = 1 AND IHALE_ID = :IHALE_ID";
			$filtre[":SIRA"] 		= 2;
			$filtre[":IHALE_ID"] 	= $row->IHALE_ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		}
		
		$filtre = array();
		$sql = "UPDATE IHALE_RESIM SET SIRA = :SIRA WHERE ID = :ID";
		$filtre[":SIRA"] 		= $_REQUEST['sira'];
		$filtre[":ID"] 			= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		$sonuc["HATA"] 		= FALSE;
		$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			
		return $sonuc;
		
	}
	
	public function kullanici_resim_aktif(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT KULLANICI_ID FROM KULLANICI_RESIM WHERE ID  = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE KULLANICI_RESIM SET DURUM = 0 WHERE DURUM IN(0,1) AND KULLANICI_ID = :KULLANICI_ID";
		$filtre[":KULLANICI_ID"] 	= $row->KULLANICI_ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE KULLANICI_RESIM SET DURUM = 1 WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function tema_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE SITE SET TEMA_ID			= :TEMA_ID
							WHERE 1
							LIMIT 1
							";
		$filtre[":TEMA_ID"] 		= trim($_REQUEST["tema_id"]);
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function genel_ayarlar_aciklama_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE SITE SET KULLANICI_SOZLESMESI		= :KULLANICI_SOZLESMESI,
								HAKKINDA					= :HAKKINDA,
								DIKKAT_EDILMESI_GEREKENLER	= :DIKKAT_EDILMESI_GEREKENLER,
								SUREC_ACIKLAMASI			= :SUREC_ACIKLAMASI
							WHERE 1
							LIMIT 1
							";
		$filtre[":KULLANICI_SOZLESMESI"] 		= trim($_REQUEST["kullanici_sozlesmesi"]);
		$filtre[":HAKKINDA"] 					= trim($_REQUEST["hakkinda"]);
		$filtre[":DIKKAT_EDILMESI_GEREKENLER"]	= trim($_REQUEST["dikkat_edilmesi_gerekenler"]);
		$filtre[":SUREC_ACIKLAMASI"]			= trim($_REQUEST["surec_aciklamasi"]);
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function iletisim_kaydet(){
		
		$ililce_id 	= explode('_', $_REQUEST['ililce_id']);
		$il_id		= $ililce_id[0];
		$ilce_id	= $ililce_id[1];
		
		$filtre	= array();
		$sql = "SELECT ID, ILCE FROM ILCE WHERE ID = :ID";
		$filtre[":ID"] 	= $ilce_id;
		$row_ilce = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE SITE SET ADRES		= :ADRES,
								ULKE_ID		= :ULKE_ID,
								ILCE		= :ILCE,
								IL_ID		= :IL_ID,
								ILCE_ID		= :ILCE_ID,
								TEL1		= :TEL1,
								TEL2		= :TEL2,
								FAKS		= :FAKS,
								MAIL		= :MAIL
							WHERE 1
							LIMIT 1
							";
		$filtre[":ADRES"] 		= trim($_REQUEST["adres"]);
		$filtre[":ULKE_ID"] 	= $_REQUEST["ulke_id"];
		$filtre[":ILCE"] 		= $row_ilce->ILCE;
		$filtre[":IL_ID"] 		= $il_id;
		$filtre[":ILCE_ID"] 	= $ilce_id;
		$filtre[":TEL1"] 		= $_REQUEST["tel1"];
		$filtre[":TEL2"] 		= $_REQUEST["tel2"];
		$filtre[":FAKS"] 		= $_REQUEST["faks"];
		$filtre[":MAIL"] 		= trim($_REQUEST["mail"]);
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function sosyal_ag_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE SITE SET FACEBOOK_VAR		= :FACEBOOK_VAR,
								FACEBOOK_ADRES		= :FACEBOOK_ADRES,
								TWITTER_VAR			= :TWITTER_VAR,
								TWITTER_ADRES		= :TWITTER_ADRES,
								PINTEREST_VAR		= :PINTEREST_VAR,
								PINTEREST_ADRES		= :PINTEREST_ADRES,
								GOOGLEPLUS_VAR		= :GOOGLEPLUS_VAR,
								GOOGLEPLUS_ADRES	= :GOOGLEPLUS_ADRES
							WHERE ID = 1
							LIMIT 1
							";
		$filtre[":FACEBOOK_VAR"] 		= ($_REQUEST["facebook_var"]) ? 1 : 0;
		$filtre[":FACEBOOK_ADRES"] 		= $_REQUEST["facebook_adres"];
		$filtre[":TWITTER_VAR"] 		= ($_REQUEST["twitter_var"]) ? 1 : 0;
		$filtre[":TWITTER_ADRES"] 		= $_REQUEST["twitter_adres"];
		$filtre[":PINTEREST_VAR"] 		= ($_REQUEST["pinterest_var"]) ? 1 : 0;
		$filtre[":PINTEREST_ADRES"] 	= $_REQUEST["pinterest_adres"];
		$filtre[":GOOGLEPLUS_VAR"] 		= ($_REQUEST["googleplus_var"]) ? 1 : 0;
		$filtre[":GOOGLEPLUS_ADRES"] 	= $_REQUEST["googleplus_adres"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function kullanici_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM KULLANICI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["KULLANICI"]	= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function hesabim_kaydet(){
		
		if(strlen($_REQUEST["sifre"]) < 6){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı Adı min:3, şifre min:6 karakter olmalı!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["unvan"]) < 2){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ünvan giriniz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST["ceptel"]) < 17){ //!preg_match('/^(5/i', $_REQUEST["ceptel"])
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cep telefonu giriniz!";
			return $sonuc;
		}
		
		if($_REQUEST["tema_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tema seçiniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE KULLANICI SET AD				= :AD,
									SOYAD			= :SOYAD,
									SIFRE			= :SIFRE,
									MAIL			= :MAIL,
									CEPTEL			= :CEPTEL,
									CEPTEL2			= :CEPTEL2,
									TEL				= :TEL,
									MAIL_GONDER		= :MAIL_GONDER,
									SMS_GONDER		= :SMS_GONDER,
									TEMA_ID			= :TEMA_ID,
									FONT_BOYUT_ID	= :FONT_BOYUT_ID,
									UNVAN			= :UNVAN,
									ADRES			= :ADRES,
									VD				= :VD,
									IBAN			= :IBAN,
									VERGI_DAIRESI_ID= :VERGI_DAIRESI_ID,
									GTARIH			= NOW()
							WHERE ID = :ID
							";
		$filtre[":AD"] 				= trim($_REQUEST["ad"]);
		$filtre[":SOYAD"] 			= trim($_REQUEST["soyad"]);
		$filtre[":SIFRE"] 			= $_REQUEST["sifre"];
		$filtre[":MAIL"] 			= trim($_REQUEST["mail"]);
		$filtre[":CEPTEL"] 			= $_REQUEST["ceptel"];
		$filtre[":CEPTEL2"] 		= $_REQUEST["ceptel2"];
		$filtre[":TEL"] 			= $_REQUEST["tel"];
		$filtre[":MAIL_GONDER"] 	= $_REQUEST["mail_gonder"];
		$filtre[":SMS_GONDER"] 		= $_REQUEST["sms_gonder"];
		$filtre[":TEMA_ID"] 		= $_REQUEST["tema_id"];
		$filtre[":FONT_BOYUT_ID"] 	= $_REQUEST["font_boyut_id"];
		$filtre[":MAIL"] 			= trim($_REQUEST["mail"]);
		$filtre[":UNVAN"] 			= trim($_REQUEST["unvan"]);
		$filtre[":ADRES"] 			= trim($_REQUEST["adres"]);
		$filtre[":VD"] 				= trim($_REQUEST["vd"]);
		$filtre[":IBAN"] 			= trim($_REQUEST["iban"]);
		$filtre[":VERGI_DAIRESI_ID"]= $_REQUEST["vergi_dairesi_id"];
		$filtre[":ID"] 				= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		if(strlen($_REQUEST['plaka']) < 4){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Plaka giriniz!";	
			return $sonuc;
		}
		
		if($_REQUEST['servis_bolum'] == -1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Servis Bölüm seçiniz!";	
			return $sonuc;
		}
		
		if($_REQUEST['cari_id'] == -1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari seçiniz!";	
			return $sonuc;
		}
		
		if($_REQUEST['marka_id'] < 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Marka seçiniz!";	
			return $sonuc;
		}
		
		if($_REQUEST['model_id'] < 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Model seçiniz!";	
			return $sonuc;
		}
		
		if($_REQUEST['model_yili'] < 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Model Yılı giriniz!";	
			return $sonuc;
		}
		
		if($_REQUEST['km'] < 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "KM giriniz!";	
			return $sonuc;
		}
		
		if(empty($_REQUEST['tahmini_teslim_tarih'])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tahmini Teslim Tarihi giriniz!";	
			return $sonuc;
		}
		
		if($_REQUEST['tahmini_teslim_saat'] == -1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tahmini Teslim Saati giriniz!";	
			return $sonuc;
		}
		
		if(!preg_match('/^[A-Za-z0-9]{3,20}$/', $_REQUEST["plaka"])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Plaka sadece harf ve rakamlardan oluşmalı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		if(is_null($row->ID) AND $_REQUEST['ayni_plaka'] == "0"){
			$filtre	= array();
			$sql = "SELECT ID, KOD, PLAKA, TARIH FROM TALEP WHERE PLAKA = :PLAKA AND SUREC_ID < 10";
			$filtre[":PLAKA"] 	= $_REQUEST["plaka"];
			$row_ayni = $this->cdbPDO->row($sql, $filtre); 
			
			if($row_ayni->ID > 0){
				$sonuc["HATA"] 			= TRUE;
				$sonuc["AYNI_PLAKA"] 	= 1;
				$sonuc["ACIKLAMA"] 		= "<b>" . $row_ayni->PLAKA . "</b> plakanın <b>". FormatTarih::tarih($row_ayni->TARIH) ."</b> tarihinde açılmış dosyası var!<br> Devam etmek istiyorsanız tekrar kaydet butonuna basınız.";	
				return $sonuc;
			}		
		}
		
		if(is_null($row->ID)){
			$filtre	= array();
			$sql = "SELECT ID, KOD, PLAKA, TARIH, KM FROM TALEP WHERE PLAKA = :PLAKA ORDER BY TARIH DESC LIMIT 1";
			$filtre[":PLAKA"] 	= $_REQUEST["plaka"];
			$row_km = $this->cdbPDO->row($sql, $filtre); 
			
			if($row_km->KM > FormatSayi::sayi2db($_REQUEST['km'])){
				$sonuc["HATA"] 			= TRUE;
				$sonuc["AYNI_PLAKA"] 	= 1;
				$sonuc["ACIKLAMA"] 		= "<b>" . $row_km->PLAKA . "</b> plakanın <b>". FormatTarih::tarih($row_km->TARIH) ."</b> tarihinde açılmış dosyası var!<br> KM <b>". FormatSayi::sayi($row_km->KM,0) ."</b> den düşük olamaz!";	
				return $sonuc;
			}
		}
		
		if(!in_array($_SESSION['kullanici'],array("ADMIN"))){
			$filtre	= array();
			$sql = "SELECT ID, KOD FROM TALEP WHERE PLAKA = :PLAKA AND ID != :ID AND KM > :KM";
			$filtre[":PLAKA"] 	= trim($_REQUEST["plaka"]);
			$filtre[":ID"] 		= $_REQUEST["id"];
			$filtre[":KM"] 		= FormatSayi::sayi2db($_REQUEST["km"]);
			$row_km = $this->cdbPDO->row($sql, $filtre); 
		
			if($row_km->ID > 0){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Daha önceki km den küçük olamaz!";	
				return $sonuc;
			}
		}
		
		if(is_null($row->ID)){
			
			$filtre	= array();
			$sql = "INSERT INTO TALEP SET 	PLAKA					= :PLAKA,
											SERVIS_BOLUM			= :SERVIS_BOLUM,
											CARI_ID					= :CARI_ID,
											SURUCU_AD_SOYAD			= :SURUCU_AD_SOYAD,
											SURUCU_TEL				= :SURUCU_TEL,
											SUREC_ID				= :SUREC_ID,
											MARKA_ID				= :MARKA_ID,
											MODEL_ID				= :MODEL_ID,
											MODEL_YILI				= :MODEL_YILI,
											VITES_TURU				= :VITES_TURU,
											YAKIT_TURU				= :YAKIT_TURU,
											SASI_NO					= :SASI_NO,
											MOTOR_NO				= :MOTOR_NO,
											KM						= :KM,
											ADRES_IL_ID				= :ADRES_IL_ID,
											ADRES_ILCE_ID			= :ADRES_ILCE_ID,
											ARAC_GELIS_TARIH		= :ARAC_GELIS_TARIH,
											ARAC_GELIS_SAAT			= :ARAC_GELIS_SAAT,
											TAHMINI_TESLIM_TARIH	= :TAHMINI_TESLIM_TARIH,
											TAHMINI_TESLIM_SAAT		= :TAHMINI_TESLIM_SAAT,
			                            	TALEP					= :TALEP,
											ADRES					= :ADRES,
											IKAME_TALEBI			= :IKAME_TALEBI,
											IKAME_VEREN_ID			= :IKAME_VEREN_ID,
			                            	ONCELIK					= :ONCELIK,
			                            	SIKAYET_SAYISI			= :SIKAYET_SAYISI,
											EKLEYEN_ID				= :EKLEYEN_ID,
											TARIH					= NOW(),
											KOD						= MD5(NOW()),
											GTARIH					= NOW()											
											";
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST["plaka"]));
			$filtre[":SERVIS_BOLUM"] 			= $_REQUEST["servis_bolum"];
			$filtre[":CARI_ID"] 				= $_REQUEST["cari_id"];
			$filtre[":SURUCU_AD_SOYAD"] 		= trim($_REQUEST["surucu_ad_soyad"]);
			$filtre[":SURUCU_TEL"] 				= $_REQUEST["surucu_tel"];
			$filtre[":SUREC_ID"] 				= 3;
			$filtre[":MARKA_ID"] 				= $_REQUEST["marka_id"];
			$filtre[":MODEL_ID"] 				= $_REQUEST["model_id"];
			$filtre[":MODEL_YILI"] 				= $_REQUEST["model_yili"];
			$filtre[":VITES_TURU"] 				= $_REQUEST["vites_turu"];
			$filtre[":YAKIT_TURU"] 				= $_REQUEST["yakit_turu"];
			$filtre[":SASI_NO"] 				= $_REQUEST["sasi_no"];
			$filtre[":MOTOR_NO"] 				= $_REQUEST["motor_no"];
			$filtre[":KM"] 						= FormatSayi::sayi2db($_REQUEST["km"]);
			$filtre[":ADRES_IL_ID"] 			= $_REQUEST["adres_il_id"];
			$filtre[":ADRES_ILCE_ID"] 			= $_REQUEST["adres_ilce_id"];
			$filtre[":ARAC_GELIS_TARIH"] 		= FormatTarih::nokta2db($_REQUEST["arac_gelis_tarih"]);
			$filtre[":ARAC_GELIS_SAAT"] 		= $_REQUEST["arac_gelis_saat"];
			$filtre[":TAHMINI_TESLIM_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["tahmini_teslim_tarih"]);
			$filtre[":TAHMINI_TESLIM_SAAT"] 	= $_REQUEST["tahmini_teslim_saat"];
			$filtre[":TALEP"] 					= trim($_REQUEST["talep"]);
			$filtre[":ADRES"] 					= trim($_REQUEST["adres"]);
			$filtre[":IKAME_TALEBI"] 			= $_REQUEST["ikame_talebi"];
			$filtre[":IKAME_VEREN_ID"] 			= $_REQUEST["ikame_veren_id"];
			$filtre[":ONCELIK"] 				= $_REQUEST["oncelik"];
			$filtre[":SIKAYET_SAYISI"] 			= $_REQUEST["sikayet_sayisi"];
			$filtre[":EKLEYEN_ID"] 				= $_SESSION["kullanici_id"];
			$talep_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
			$filtre	= array();
			$sql = "SELECT * FROM TALEP WHERE ID = :ID";
			$filtre[":ID"] 	= $talep_id;
			$row = $this->cdbPDO->row($sql, $filtre); 
			
			fncSorumluAta($row->ID);
			
		} else {
			
			if($row->KOD != $_REQUEST['kod']){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE TALEP SET 	PLAKA					= :PLAKA,
										SERVIS_BOLUM			= :SERVIS_BOLUM,
										CARI_ID					= :CARI_ID,
										SURUCU_AD_SOYAD			= :SURUCU_AD_SOYAD,
										SURUCU_TEL				= :SURUCU_TEL,
			                            MARKA_ID				= :MARKA_ID,
			                            MODEL_ID				= :MODEL_ID,
			                            MODEL_YILI				= :MODEL_YILI,
			                            VITES_TURU				= :VITES_TURU,
			                            YAKIT_TURU				= :YAKIT_TURU,
			                            SASI_NO					= :SASI_NO,
										MOTOR_NO				= :MOTOR_NO,
			                            KM						= :KM,
			                            ADRES_IL_ID				= :ADRES_IL_ID,
			                            ADRES_ILCE_ID			= :ADRES_ILCE_ID,
			                            ARAC_GELIS_TARIH		= :ARAC_GELIS_TARIH,
			                            ARAC_GELIS_SAAT			= :ARAC_GELIS_SAAT,
			                            TAHMINI_TESLIM_TARIH	= :TAHMINI_TESLIM_TARIH,
			                            TAHMINI_TESLIM_SAAT		= :TAHMINI_TESLIM_SAAT,
			                            TALEP					= :TALEP,
			                            ADRES					= :ADRES,
			                            IKAME_TALEBI			= :IKAME_TALEBI,
			                            IKAME_VEREN_ID			= :IKAME_VEREN_ID,
			                            ONCELIK					= :ONCELIK,
			                            SIKAYET_SAYISI			= :SIKAYET_SAYISI,
										GTARIH					= NOW()
								WHERE ID = :ID
								";
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST["plaka"]));
			$filtre[":SERVIS_BOLUM"] 			= $_REQUEST["servis_bolum"];
			$filtre[":CARI_ID"] 				= $_REQUEST["cari_id"];
			$filtre[":SURUCU_AD_SOYAD"] 		= trim($_REQUEST["surucu_ad_soyad"]);
			$filtre[":SURUCU_TEL"] 				= $_REQUEST["surucu_tel"];
			$filtre[":MARKA_ID"] 				= $_REQUEST["marka_id"];
			$filtre[":MODEL_ID"] 				= $_REQUEST["model_id"];
			$filtre[":MODEL_YILI"] 				= $_REQUEST["model_yili"];
			$filtre[":VITES_TURU"] 				= $_REQUEST["vites_turu"];
			$filtre[":YAKIT_TURU"] 				= $_REQUEST["yakit_turu"];
			$filtre[":SASI_NO"] 				= $_REQUEST["sasi_no"];
			$filtre[":MOTOR_NO"] 				= $_REQUEST["motor_no"];
			$filtre[":KM"] 						= FormatSayi::sayi2db($_REQUEST["km"]);
			$filtre[":ADRES_IL_ID"] 			= $_REQUEST["adres_il_id"];
			$filtre[":ADRES_ILCE_ID"] 			= $_REQUEST["adres_ilce_id"];
			$filtre[":ARAC_GELIS_TARIH"] 		= FormatTarih::nokta2db($_REQUEST["arac_gelis_tarih"]);
			$filtre[":ARAC_GELIS_SAAT"] 		= $_REQUEST["arac_gelis_saat"];
			$filtre[":TAHMINI_TESLIM_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["tahmini_teslim_tarih"]);
			$filtre[":TAHMINI_TESLIM_SAAT"] 	= $_REQUEST["tahmini_teslim_saat"];
			$filtre[":TALEP"] 					= trim($_REQUEST["talep"]);
			$filtre[":ADRES"] 					= trim($_REQUEST["adres"]);
			$filtre[":IKAME_TALEBI"] 			= $_REQUEST["ikame_talebi"];
			$filtre[":IKAME_VEREN_ID"] 			= $_REQUEST["ikame_veren_id"];
			$filtre[":ONCELIK"] 				= $_REQUEST["oncelik"];
			$filtre[":SIKAYET_SAYISI"] 			= $_REQUEST["sikayet_sayisi"];
			$filtre[":ID"] 						= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		}	
		
		if($talep_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi. Talep No: $talep_id";
			$sonuc["URL"] 		= "/talep/talep.do?route=talep/talep_listesi&id={$row->ID}&kod={$row->KOD}";
		} else if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Talep Kaydedildi.";
			$sonuc["URL"] 		= "/talep/talep.do?route=talep/talep_listesi&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_sikayet_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM SIKAYET WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$rows_sikayet2 = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows_sikayet2 as $key => $row_sikayet2){
			$rows_sikayet[$row_sikayet2->SIRA]	= $row_sikayet2;
		}
		
		foreach($_REQUEST["sikayet"] as $key => $sikayet){
			if(strlen(trim($sikayet)) <= 0) continue;
			$sira++;
			
			if(is_null($rows_sikayet[$sira]->ID)){
				$filtre	= array();
				$sql = "INSERT INTO SIKAYET SET TALEP_ID = :TALEP_ID, SIRA = :SIRA, SIKAYET = :SIKAYET, COZUM = :COZUM, DURUM = :DURUM, TARIH = NOW(), GTARIH = NOW()";
				$filtre[":TALEP_ID"] 	= $row->ID;
				$filtre[":SIRA"] 		= $sira;
				$filtre[":SIKAYET"] 	= trim($_REQUEST["sikayet"][$key]);
				$filtre[":COZUM"] 		= trim($_REQUEST["cozum"][$key]);
				$filtre[":DURUM"] 		= $_REQUEST["durum"][$key] == 1 ? 1 : 0;
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
			} else if($rows_sikayet[$sira]->ID > 0){
				$filtre	= array();
				$sql = "UPDATE SIKAYET SET SIRA = :SIRA, SIKAYET = :SIKAYET, COZUM = :COZUM, DURUM = :DURUM, GTARIH = NOW() WHERE ID = :ID";
				$filtre[":SIRA"] 		= $sira;
				$filtre[":SIKAYET"] 	= trim($_REQUEST["sikayet"][$key]);
				$filtre[":COZUM"] 		= trim($_REQUEST["cozum"][$key]);
				$filtre[":DURUM"] 		= $_REQUEST["durum"][$key] == 1 ? 1 : 0;
				$filtre[":ID"] 			= $rows_sikayet[$sira]->ID;
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
			}
			
		}
		
		if(is_null($sira)){
			$filtre	= array();
			$sql = "DELETE FROM SIKAYET WHERE TALEP_ID = :TALEP_ID";
			$filtre[":TALEP_ID"] 	= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}	
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_ekspertiz_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID,ORAN FROM TEVKIFAT WHERE ID = :ID";
		$filtre[":ID"] 	= $row->TEVKIFAT_ID;
		$row_tevkifat = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_tevkifat->ID > 0){
			$KDV_CARPAN = $row_tevkifat->ORAN;
		} else {
			$KDV_CARPAN = 1.18;
		}
		
		//Yedek Parça
		$filtre	= array();
		$sql = "SELECT * FROM PARCA WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$rows_parca2 = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows_parca2 as $key => $row_parca2){
			$rows_parca[$row_parca2->SIRA]	= $row_parca2;
		}
		
		$KALEM_SAYISI = 0;
		$sira = 0;
		foreach($_REQUEST["yp_parca_kodu"] as $key => $parca_kodu){
			if(strlen(trim($parca_kodu)) <= 0 AND strlen(trim($_REQUEST["yp_parca_adi"][$key])) <= 0) continue;
			$sira++;
			
			if(is_null($rows_parca[$sira]->ID)){
				$filtre	= array();
				$sql = "INSERT INTO PARCA SET TALEP_ID = :TALEP_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, ALIS = :ALIS, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, TEDARIKCI = :TEDARIKCI, SIPARIS_TARIH = :SIPARIS_TARIH, KDV = :KDV, GTARIH = NOW()";
				$filtre[":TALEP_ID"] 		= $row->ID;
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PARCA_KODU"] 		= trim($_REQUEST["yp_parca_kodu"][$key]);
				$filtre[":PARCA_ADI"] 		= trim($_REQUEST["yp_parca_adi"][$key]);
				$filtre[":ADET"] 			= FormatSayi::sayi2db($_REQUEST["yp_adet"][$key]);
				$filtre[":ALIS"] 			= FormatSayi::sayi2db($_REQUEST["yp_alis"][$key]);
				$filtre[":FIYAT"] 			= FormatSayi::sayi2db($_REQUEST["yp_fiyat"][$key]);
				$filtre[":ISKONTO"] 		= FormatSayi::sayi2db($_REQUEST["yp_iskonto"][$key]);
				$filtre[":ISKONTOLU"] 		= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) ;
				$filtre[":TUTAR"] 			= $filtre[":ADET"] * $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) * (($_REQUEST["yp_kdv"][$key] == "18") ? $KDV_CARPAN : 1);
				$filtre[":TEDARIKCI"] 		= $_REQUEST["yp_tedarikci"][$key];
				$filtre[":SIPARIS_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["yp_siparis_tarih"][$key]);
				$filtre[":KDV"] 			= ($_REQUEST["yp_kdv"][$key] == "18") ? 18 : 0;
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
			} else if($rows_parca[$sira]->ID > 0){
				$filtre	= array();
				$sql = "UPDATE PARCA SET SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, ALIS = :ALIS, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, TEDARIKCI = :TEDARIKCI, GTARIH = NOW(), SIPARIS_TARIH = :SIPARIS_TARIH, KDV = :KDV WHERE ID = :ID";
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PARCA_KODU"] 		= trim($_REQUEST["yp_parca_kodu"][$key]);
				$filtre[":PARCA_ADI"] 		= trim($_REQUEST["yp_parca_adi"][$key]);
				$filtre[":ADET"] 			= FormatSayi::sayi2db($_REQUEST["yp_adet"][$key]);
				$filtre[":ALIS"] 			= FormatSayi::sayi2db($_REQUEST["yp_alis"][$key]);
				$filtre[":FIYAT"] 			= FormatSayi::sayi2db($_REQUEST["yp_fiyat"][$key]);
				$filtre[":ISKONTO"] 		= FormatSayi::sayi2db($_REQUEST["yp_iskonto"][$key]);
				$filtre[":ISKONTOLU"] 		= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) ;
				$filtre[":TUTAR"] 			= $filtre[":ADET"] * $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) * (($_REQUEST["yp_kdv"][$key] == "18") ? $KDV_CARPAN : 1);
				$filtre[":TEDARIKCI"] 		= $_REQUEST["yp_tedarikci"][$key];
				$filtre[":SIPARIS_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["yp_siparis_tarih"][$key]);
				$filtre[":KDV"] 			= ($_REQUEST["yp_kdv"][$key] == "18") ? 18 : 0;
				$filtre[":ID"] 				= $rows_parca[$sira]->ID;
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
			}
			
		}
		
		$KALEM_SAYISI += $sira;
		
		if($sira == "0"){
			$filtre	= array();
			$sql = "DELETE FROM PARCA WHERE TALEP_ID = :TALEP_ID";
			$filtre[":TALEP_ID"] 	= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		} else {
			$filtre	= array();
			$sql = "DELETE FROM PARCA WHERE TALEP_ID = :TALEP_ID AND SIRA > :SIRA";
			$filtre[":TALEP_ID"] 	= $row->ID;
			$filtre[":SIRA"] 			= $sira;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		// İşçilik
		$filtre	= array();
		$sql = "SELECT * FROM ISCILIK WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$rows_iscilik2 = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows_iscilik2 as $key => $row_iscilik2){
			$rows_iscilik[$row_iscilik2->SIRA]	= $row_iscilik2;
		}
		
		$sira = 0;
		foreach($_REQUEST["is_parca_kodu"] as $key => $parca_kodu){
			if(strlen(trim($parca_kodu)) <= 0 AND strlen(trim($_REQUEST["is_parca_adi"][$key])) <= 0) continue;
			$sira++;
			
			if(is_null($rows_iscilik[$sira]->ID)){
				$filtre	= array();
				$sql = "INSERT INTO ISCILIK SET TALEP_ID = :TALEP_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ALIS = :ALIS, ONARIM = :ONARIM, BOYA = :BOYA, SOKTAK = :SOKTAK, FIYAT = :FIYAT, ISKONTO = :ISKONTO, TUTAR = :TUTAR, KDV = :KDV, ISKONTOLU = :ISKONTOLU, GTARIH = NOW()";
				$filtre[":TALEP_ID"] 		= $row->ID;
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PARCA_KODU"] 		= trim($_REQUEST["is_parca_kodu"][$key]);
				$filtre[":PARCA_ADI"] 		= trim($_REQUEST["is_parca_adi"][$key]);
				$filtre[":ALIS"] 			= FormatSayi::sayi2db($_REQUEST["is_alis"][$key]);
				$filtre[":ONARIM"] 			= FormatSayi::sayi2db($_REQUEST["is_onarim"][$key]);
				$filtre[":BOYA"] 			= FormatSayi::sayi2db($_REQUEST["is_boya"][$key]);
				$filtre[":SOKTAK"] 			= FormatSayi::sayi2db($_REQUEST["is_soktak"][$key]);
				$filtre[":FIYAT"] 			= $filtre[":ONARIM"] + $filtre[":BOYA"] + $filtre[":SOKTAK"];
				$filtre[":ISKONTO"] 		= FormatSayi::sayi2db($_REQUEST["is_iskonto"][$key]);
				$filtre[":ISKONTOLU"] 		= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) ;
				$filtre[":TUTAR"] 			= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) * (($_REQUEST["is_kdv"][$key] == "18") ? $KDV_CARPAN : 1);
				$filtre[":KDV"] 			= ($_REQUEST["is_kdv"][$key] == "18") ? 18 : 0;
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
			} else if($rows_iscilik[$sira]->ID > 0){
				$filtre	= array();
				$sql = "UPDATE ISCILIK SET SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ALIS = :ALIS, ONARIM = :ONARIM, BOYA = :BOYA, SOKTAK = :SOKTAK, FIYAT = :FIYAT, ISKONTO = :ISKONTO, TUTAR = :TUTAR, KDV = :KDV, ISKONTOLU = :ISKONTOLU, GTARIH = NOW() WHERE ID = :ID";
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PARCA_KODU"] 		= trim($_REQUEST["is_parca_kodu"][$key]);
				$filtre[":PARCA_ADI"] 		= trim($_REQUEST["is_parca_adi"][$key]);
				$filtre[":ALIS"] 			= FormatSayi::sayi2db($_REQUEST["is_alis"][$key]);
				$filtre[":ONARIM"] 			= FormatSayi::sayi2db($_REQUEST["is_onarim"][$key]);
				$filtre[":BOYA"] 			= FormatSayi::sayi2db($_REQUEST["is_boya"][$key]);
				$filtre[":SOKTAK"] 			= FormatSayi::sayi2db($_REQUEST["is_soktak"][$key]);
				$filtre[":FIYAT"] 			= $filtre[":ONARIM"] + $filtre[":BOYA"] + $filtre[":SOKTAK"];
				$filtre[":ISKONTO"] 		= FormatSayi::sayi2db($_REQUEST["is_iskonto"][$key]);
				$filtre[":ISKONTOLU"] 		= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) ;
				$filtre[":TUTAR"] 			= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) * (($_REQUEST["is_kdv"][$key] == "18") ? $KDV_CARPAN : 1);
				$filtre[":KDV"] 			= ($_REQUEST["is_kdv"][$key] == "18") ? 18 : 0;
				$filtre[":ID"] 				= $rows_iscilik[$sira]->ID;
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
			}
			
		}
		
		$KALEM_SAYISI += $sira;
		
		if($sira == "0"){
			$filtre	= array();
			$sql = "DELETE FROM ISCILIK WHERE TALEP_ID = :TALEP_ID";
			$filtre[":TALEP_ID"] 	= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		} else {
			$filtre	= array();
			$sql = "DELETE FROM ISCILIK WHERE TALEP_ID = :TALEP_ID AND SIRA > :SIRA";
			$filtre[":TALEP_ID"] 	= $row->ID;
			$filtre[":SIRA"] 		= $sira;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}	
		
		$filtre	= array();
		$sql = "SELECT SUM(TUTAR) AS ODENECEK_TUTAR FROM PARCA WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_yp_tutar = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT SUM(TUTAR) AS ODENECEK_TUTAR FROM ISCILIK WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_is_tutar = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET ODENECEK_TUTAR = :ODENECEK_TUTAR, FATURA_TUTAR = :ODENECEK_TUTAR, KALEM_SAYISI = :KALEM_SAYISI, GTARIH = NOW() WHERE ID = :ID";
		$filtre[":ODENECEK_TUTAR"] 	= $row_yp_tutar->ODENECEK_TUTAR + $row_is_tutar->ODENECEK_TUTAR;
		$filtre[":KALEM_SAYISI"] 	= $KALEM_SAYISI;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Ekspertiz Bilgileri Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_sorumlu_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SORUMLU_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
			
		$filtre	= array();
		$sql = "UPDATE TALEP SET SORUMLU_ID = :SORUMLU_ID WHERE ID = :ID";
		$filtre[":SORUMLU_ID"] 		= $_REQUEST["sorumlu_id"];
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE TALEP_SORUMLU SET SORUMLU_ID = :SORUMLU_ID WHERE TALEP_ID = :TALEP_ID";
		$filtre[":SORUMLU_ID"] 		= $_REQUEST["sorumlu_id"];
		$filtre[":TALEP_ID"] 		= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	

	public function ekspertiz_parca_geldi(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
			
		$filtre	= array();
		$sql = "UPDATE PARCA SET DURUM = 2, GELDI_TARIH = NOW() WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["parca_id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function ekspertiz_parca_sil(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, SIRA, TALEP_ID FROM PARCA WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["parca_id"];
		$row_parca = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row_parca->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Parça bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM PARCA WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["parca_id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		// Tutar Hesabı
		$filtre	= array();
		$sql = "UPDATE PARCA SET SIRA = SIRA-1 WHERE TALEP_ID = :TALEP_ID AND SIRA > :SIRA";
		$filtre[":TALEP_ID"] 	= $row_parca->TALEP_ID;
		$filtre[":SIRA"] 		= $row_parca->SIRA;
		$this->cdbPDO->row($sql, $filtre); 
				
		$filtre	= array();
		$sql = "SELECT SUM(TUTAR) AS ODENECEK_TUTAR FROM PARCA WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_yp_tutar = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT SUM(TUTAR) AS ODENECEK_TUTAR FROM ISCILIK WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_is_tutar = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET ODENECEK_TUTAR = :ODENECEK_TUTAR, FATURA_TUTAR = :ODENECEK_TUTAR, GTARIH = NOW() WHERE ID = :ID";
		$filtre[":ODENECEK_TUTAR"] 	= $row_yp_tutar->ODENECEK_TUTAR + $row_is_tutar->ODENECEK_TUTAR;
		$filtre[":ID"] 				= $row->ID;
		$this->cdbPDO->rowsCount($sql, $filtre);
		// Tutar Hesabı
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function ekspertiz_iscilik_sil(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, SIRA, TALEP_ID FROM ISCILIK WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["parca_id"];
		$row_parca = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row_parca->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Parça bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM ISCILIK WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["parca_id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		// Tutar Hesabı
		$filtre	= array();
		$sql = "UPDATE ISCILIK SET SIRA = SIRA-1 WHERE TALEP_ID = :TALEP_ID AND SIRA > :SIRA";
		$filtre[":TALEP_ID"] 	= $row_parca->TALEP_ID;
		$filtre[":SIRA"] 		= $row_parca->SIRA;
		$this->cdbPDO->row($sql, $filtre); 
				
		$filtre	= array();
		$sql = "SELECT SUM(TUTAR) AS ODENECEK_TUTAR FROM PARCA WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_yp_tutar = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT SUM(TUTAR) AS ODENECEK_TUTAR FROM ISCILIK WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_is_tutar = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET ODENECEK_TUTAR = :ODENECEK_TUTAR,  FATURA_TUTAR = :ODENECEK_TUTAR,  GTARIH = NOW() WHERE ID = :ID";
		$filtre[":ODENECEK_TUTAR"] 	= $row_yp_tutar->ODENECEK_TUTAR + $row_is_tutar->ODENECEK_TUTAR;
		$filtre[":ID"] 				= $row->ID;
		$this->cdbPDO->rowsCount($sql, $filtre);
		// Tutar Hesabı
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function sigorta_bilgileri_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
			
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	DOSYA_NO					= :DOSYA_NO,
									SIGORTA_ID					= :SIGORTA_ID,
									SIGORTA_SEKLI				= :SIGORTA_SEKLI,
		                            RUHSAT_SAHIBI				= :RUHSAT_SAHIBI,
		                            SIGORTALI_TEL				= :SIGORTALI_TEL,
		                            SIGORTALI_TCK				= :SIGORTALI_TCK,
		                            EKSPER						= :EKSPER,
		                            EKSPER_TEL					= :EKSPER_TEL,
		                            EKSPER_MAIL					= :EKSPER_MAIL,
		                            SIGORTA_ODEME_TUTAR1		= :SIGORTA_ODEME_TUTAR1,
		                            SIGORTA_ODEME_TARIH1		= :SIGORTA_ODEME_TARIH1,
		                            SIGORTA_ODEME_ACIKLAMA1		= :SIGORTA_ODEME_ACIKLAMA1,
		                            SIGORTA_ODEME_TUTAR2		= :SIGORTA_ODEME_TUTAR2,
		                            SIGORTA_ODEME_TARIH2		= :SIGORTA_ODEME_TARIH2,
		                            SIGORTA_ODEME_ACIKLAMA2		= :SIGORTA_ODEME_ACIKLAMA2,
		                            SIGORTA_ODEME_TUTAR3		= :SIGORTA_ODEME_TUTAR3,
		                            SIGORTA_ODEME_TARIH3		= :SIGORTA_ODEME_TARIH3,
		                            SIGORTA_ODEME_ACIKLAMA3		= :SIGORTA_ODEME_ACIKLAMA3,
		                            SIGORTA_ODEME_TUTAR4		= :SIGORTA_ODEME_TUTAR4,
		                            SIGORTA_ODEME_TARIH4		= :SIGORTA_ODEME_TARIH4,
		                            SIGORTA_ODEME_ACIKLAMA4		= :SIGORTA_ODEME_ACIKLAMA4,
		                            SIGORTA_ODEME_TUTAR5		= :SIGORTA_ODEME_TUTAR5,
		                            SIGORTA_ODEME_TARIH5		= :SIGORTA_ODEME_TARIH5,
		                            SIGORTA_ODEME_ACIKLAMA5		= :SIGORTA_ODEME_ACIKLAMA5,
		                            SIGORTA_NOT					= :SIGORTA_NOT,
		                            SIGORTA_ODEME_TALIMAT_TARIH	= :SIGORTA_ODEME_TALIMAT_TARIH,
									GTARIH						= NOW()
							WHERE ID = :ID
							";
		$filtre[":DOSYA_NO"] 					= trim(strtoupper($_REQUEST["dosya_no"]));
		$filtre[":SIGORTA_ID"] 					= $_REQUEST["sigorta_id"];
		$filtre[":SIGORTA_SEKLI"] 				= ($_REQUEST["sigorta_sekli"] == -1) ? '' : $_REQUEST["sigorta_sekli"];
		$filtre[":RUHSAT_SAHIBI"] 				= trim($_REQUEST["ruhsat_sahibi"]);
		$filtre[":SIGORTALI_TEL"] 				= $_REQUEST["sigortali_tel"];
		$filtre[":SIGORTALI_TCK"] 				= $_REQUEST["sigortali_tck"];
		$filtre[":EKSPER"] 						= $_REQUEST["eksper"];
		$filtre[":EKSPER_TEL"] 					= $_REQUEST["eksper_tel"];
		$filtre[":EKSPER_MAIL"] 				= trim($_REQUEST["eksper_mail"]);
		$filtre[":SIGORTA_ODEME_TUTAR1"] 		= FormatSayi::sayi2db($_REQUEST["sigorta_odeme_tutar1"]);
		$filtre[":SIGORTA_ODEME_TARIH1"] 		= FormatTarih::nokta2db($_REQUEST["sigorta_odeme_tarih1"]);
		$filtre[":SIGORTA_ODEME_ACIKLAMA1"] 	= trim($_REQUEST["sigorta_odeme_aciklama1"]);
		$filtre[":SIGORTA_ODEME_TUTAR2"] 		= FormatSayi::sayi2db($_REQUEST["sigorta_odeme_tutar2"]);
		$filtre[":SIGORTA_ODEME_TARIH2"] 		= FormatTarih::nokta2db($_REQUEST["sigorta_odeme_tarih2"]);
		$filtre[":SIGORTA_ODEME_ACIKLAMA2"] 	= trim($_REQUEST["sigorta_odeme_aciklama2"]);
		$filtre[":SIGORTA_ODEME_TUTAR3"] 		= FormatSayi::sayi2db($_REQUEST["sigorta_odeme_tutar3"]);
		$filtre[":SIGORTA_ODEME_TARIH3"] 		= FormatTarih::nokta2db($_REQUEST["sigorta_odeme_tarih3"]);
		$filtre[":SIGORTA_ODEME_ACIKLAMA3"] 	= trim($_REQUEST["sigorta_odeme_aciklama3"]);
		$filtre[":SIGORTA_ODEME_TUTAR4"] 		= FormatSayi::sayi2db($_REQUEST["sigorta_odeme_tutar4"]);
		$filtre[":SIGORTA_ODEME_TARIH4"] 		= FormatTarih::nokta2db($_REQUEST["sigorta_odeme_tarih4"]);
		$filtre[":SIGORTA_ODEME_ACIKLAMA4"] 	= trim($_REQUEST["sigorta_odeme_aciklama4"]);
		$filtre[":SIGORTA_ODEME_TUTAR5"] 		= FormatSayi::sayi2db($_REQUEST["sigorta_odeme_tutar5"]);
		$filtre[":SIGORTA_ODEME_TARIH5"] 		= FormatTarih::nokta2db($_REQUEST["sigorta_odeme_tarih5"]);
		$filtre[":SIGORTA_ODEME_ACIKLAMA5"] 	= trim($_REQUEST["sigorta_odeme_aciklama5"]);
		$filtre[":SIGORTA_NOT"] 				= trim($_REQUEST["sigorta_not"]);
		$filtre[":SIGORTA_ODEME_TALIMAT_TARIH"]	= FormatTarih::nokta2db($_REQUEST["sigorta_odeme_talimat_tarih"]);
		$filtre[":ID"] 							= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Sigorta Bilgileri Kaydedildi.";
			//$sonuc["URL"] 		= "/talep/popup_servis.do?route=talep/talep_listesi&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_kontrol_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		/*
		if($row->SUREC_ID < 5){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kontrol Sürecine gelmeden işlem yapılamaz!";	
			return $sonuc;
		}
		*/
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kontrol Sürecini geçtiği için işlem yapılamaz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID FROM KONTROL WHERE 1";
		$rows_kontrol = $this->cdbPDO->rows($sql, $filtre); 
		
		foreach($rows_kontrol as $key => $row_kontrol){		
			$filtre	= array();
			$sql = "REPLACE INTO TALEP_KONTROL SET TALEP_ID = :TALEP_ID, KONTROL_ID = :KONTROL_ID, ISLEM_SONRASI = :ISLEM_SONRASI, DURUM = :DURUM";
			$filtre[":TALEP_ID"] 		= $row->ID;
			$filtre[":KONTROL_ID"] 		= $row_kontrol->ID;
			$filtre[":ISLEM_SONRASI"] 	= trim($_REQUEST["islem_sonrasi"][$row_kontrol->ID]);
			$filtre[":DURUM"] 			= $_REQUEST["durum"][$row_kontrol->ID] == 1 ? 1 : 0;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET KONTROL_ACIKLAMA = :KONTROL_ACIKLAMA, GTARIH = NOW() WHERE ID = :ID";
		$filtre[":KONTROL_ACIKLAMA"] = trim($_REQUEST["kontrol_aciklama"]);
		$filtre[":ID"] 				 = $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);	
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_fatura_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		if(strlen($_REQUEST['fatura_no']) != 16 AND $_REQUEST["fatura_kes"] == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Fatura No' 16 hane olmalı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT
					CH.ID,
					CH.FATURA_NO
				FROM CARI_HAREKET AS CH
				WHERE CH.HAREKET_ID = 1 AND CH.FATURA_NO = :FATURA_NO AND CH.TALEP_ID != :TALEP_ID
				";
		$filtre[":FATURA_NO"] 	= trim($_REQUEST["fatura_no"]);
		$filtre[":TALEP_ID"] 	= $_REQUEST["id"];
		$row_ayni = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_ayni->ID > 0 AND $_REQUEST["fatura_kes"] == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "{$row_ayni->FATURA_NO} fatura daha önce girilmiş!!!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
			
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	FATURA_NO				= :FATURA_NO,
									FATURA_TARIH			= :FATURA_TARIH,
									FATURA_TUTAR			= :FATURA_TUTAR,
		                            FATURA_ACIKLAMA			= :FATURA_ACIKLAMA,
		                            FATURA_KES				= :FATURA_KES,
		                            FATURA_ODEME			= :FATURA_ODEME,
		                            TEVKIFAT_ID				= :TEVKIFAT_ID
							WHERE ID = :ID
							";
		$filtre[":FATURA_NO"] 		= ($_REQUEST["fatura_kes"] == '2') ? "IRS".str_pad($row->ID, 13, "0", STR_PAD_LEFT) : trim($_REQUEST["fatura_no"]);
		$filtre[":FATURA_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["fatura_tarih"]);
		$filtre[":FATURA_TUTAR"] 	= FormatSayi::sayi2db($_REQUEST["fatura_tutar"]);
		$filtre[":FATURA_ACIKLAMA"] = trim($_REQUEST["fatura_aciklama"]);
		$filtre[":FATURA_KES"]		= $_REQUEST["fatura_kes"];
		$filtre[":FATURA_ODEME"]	= $_REQUEST["fatura_odeme"];
		$filtre[":TEVKIFAT_ID"]		= $_REQUEST["tevkifat_id"];
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($_REQUEST["fatura_kes"] == '1'){
			$filtre	= array();
			$sql = "UPDATE SITE SET FATURA_NO = :FATURA_NO WHERE SUBSTR(FATURA_NO, 4, 13) < SUBSTR(:FATURA_NO, 4, 13) LIMIT 1";
			$filtre[":FATURA_NO"] 		= trim($_REQUEST['fatura_no']);
			$this->cdbPDO->rowsCount($sql, $filtre); 
		}
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Fatura Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function ekspertiz_kopyala_coz(){
		
		$data = trim($_REQUEST["data"]);
		$rows = preg_split('/\r\n|[\r\n]/', $_POST['data']);
		
		foreach($rows as $key => $row){
			//$cols = preg_split('/\s+/', $row);
			$cols = preg_split("/[\t]/", $row);
			//$rows_data[$key]->SATIR  = $row;
			$rows_data[$key]->PARCA_KODU	= $cols[0];
			$rows_data[$key]->PARCA_ID  	= $cols[1];
			$rows_data[$key]->PARCA		  	= $cols[2];
			$rows_data[$key]->DIGER  		= $cols[3];
			$rows_data[$key]->SOKTAK  		= str_replace('.',',',str_replace(',','',$cols[4]));
			$rows_data[$key]->TAMIR  		= str_replace('.',',',str_replace(',','',$cols[5]));
			$rows_data[$key]->BOYA  		= str_replace('.',',',str_replace(',','',$cols[6]));
			$rows_data[$key]->TOPLAM  		= str_replace('.',',',str_replace(',','',$cols[7]));
			$rows_data[$key]->ISKONTO  		= str_replace('.',',',str_replace(',','',$cols[8]));
		}
		
		
		$sonuc["HATA"] 		= FALSE;
		$sonuc["ACIKLAMA"] 	= "Ekspertiz Çözüldü.";
		$sonuc["DATA"] 		= $rows_data;
		
		return $sonuc;
		
	}
	
	public function ekspertiz_maintenarena_kopyala_coz(){
		
		$data = trim($_REQUEST["data"]);
		$arr_str = explode('İşçilik Kodu', $_POST['data']);
		
		$i = -1;
		$rows_yp = preg_split('/\t\r\n|[\t][\r\n]/', $arr_str[0]);
		foreach($rows_yp as $key => $row){
			if($key == 0) continue;
			$i++;
			//$cols = preg_split('/\s+/', $row);
			$cols = preg_split("/[\t]/", $row);
			//var_dump2($cols);
			$arr_parca_kodu = explode(' ', $cols[1]);
			//$rows_data[$i]->SATIR  = $row;
			$rows_data_yp[$i]->PARCA_KODU	= $arr_parca_kodu[count($arr_parca_kodu)-1];
			$rows_data_yp[$i]->PARCA		= $cols[2];
			$rows_data_yp[$i]->ADET  		= FormatSayi::sayi($cols[3]);
			$rows_data_yp[$i]->FIYAT  		= FormatSayi::sayi($cols[11]) == 0 ? FormatSayi::sayi($cols[5]) : FormatSayi::sayi($cols[11]);
			$rows_data_yp[$i]->ISKONTO  	= FormatSayi::sayi($cols[8]);
			$rows_data_yp[$i]->TUTAR  		= FormatSayi::sayi($cols[11]);
		}
		
		$i = -1;
		$rows_is = preg_split('/\t\r\n|[\t][\r\n]/', $arr_str[1]);
		foreach($rows_is as $key => $row){
			if($key == 0) continue;
			$i++;
			//$cols = preg_split('/\s+/', $row);
			$cols = preg_split("/[\t]/", $row);
			//var_dump2($cols);
			//$rows_data[$i]->SATIR  = $row;
			$rows_data_is[$i]->PARCA_KODU	= $cols[0]; //"ISCILIK".($key); //$cols[0];
			$rows_data_is[$i]->PARCA		= $cols[1];
			$rows_data_is[$i]->TAMIR  		= FormatSayi::sayi(str_replace(',','',$cols[7]));
			$rows_data_is[$i]->SOKTAK		= 0;
			$rows_data_is[$i]->BOYA			= 0;
			$rows_data_is[$i]->FIYAT	  	= FormatSayi::sayi(str_replace(',','',$cols[7]));
			$rows_data_is[$i]->ISKONTO  	= FormatSayi::sayi(str_replace('%','',$cols[8]));
			$rows_data_is[$i]->TUTAR  		= FormatSayi::sayi(str_replace(',','',$cols[9]));
		}
		
		$sonuc["HATA"] 		= FALSE;
		$sonuc["ACIKLAMA"] 	= "Ekspertiz Çözüldü.";
		$sonuc["DATA_YP"] 	= $rows_data_yp;
		$sonuc["DATA_IS"] 	= $rows_data_is;
		return $sonuc;
		
	}
	
	public function hgs_kopyala_coz(){
		
		$data = trim($_REQUEST["data"]);
		$rows = preg_split('/\r\n|[\r\n]/', $_POST['data']);
		
		foreach($rows as $key => $row){
			//$cols = preg_split('/\s+/', $row);
			$cols = preg_split("/[\t]/", $row);
			//$rows_data[$key]->SATIR  = $row;
			$rows_data[$key]->PLAKA			= trim($cols[0]);
			$rows_data[$key]->HGS_NO  		= trim($cols[1]);
			$rows_data[$key]->ALT_FIRMA		= trim($cols[2]);
			$rows_data[$key]->GIRIS_TARIH  	= FormatTarih::tre2db($cols[3]);
			$rows_data[$key]->CIKIS_TARIH  	= FormatTarih::tre2db($cols[4]);
			$rows_data[$key]->GIRIS_NOKTASI = trim($cols[5]);
			$rows_data[$key]->CIKIS_NOKTASI = trim($cols[6]);
			$rows_data[$key]->KARAYOLU  	= trim($cols[7]);
			$rows_data[$key]->TUTAR  		= str_replace(',','.',str_replace('.','',$cols[8]));
		}
		
		foreach($rows_data as $key => $row){
			$filtre	= array();
			$sql = "SELECT ID, PLAKA FROM HGS WHERE PLAKA = :PLAKA AND CIKIS_TARIH = :CIKIS_TARIH";
			$filtre[":PLAKA"] 			= $row->PLAKA;
			$filtre[":CIKIS_TARIH"] 	= $row->CIKIS_TARIH;
			$rows_ayni = $this->cdbPDO->row($sql, $filtre); 
			
			if(is_null($rows_ayni->ID) AND strlen($row->PLAKA) > 1){
				$filtre	= array();
				$sql = "INSERT INTO HGS SET PLAKA			= :PLAKA,
											HGS_NO			= :HGS_NO,
											ALT_FIRMA		= :ALT_FIRMA,
											GIRIS_TARIH		= :GIRIS_TARIH,
											CIKIS_TARIH		= :CIKIS_TARIH,
											GIRIS_NOKTASI	= :GIRIS_NOKTASI,
											CIKIS_NOKTASI	= :CIKIS_NOKTASI,
											KARAYOLU		= :KARAYOLU,
											TUTAR			= :TUTAR,
											TARIH			= NOW()											
											";					
				$filtre[":PLAKA"] 			= $row->PLAKA;
				$filtre[":HGS_NO"] 			= $row->HGS_NO;
				$filtre[":ALT_FIRMA"] 		= $row->ALT_FIRMA;
				$filtre[":GIRIS_TARIH"] 	= ($row->GIRIS_TARIH == "1899-12-31 23:26:39" ? $row->CIKIS_TARIH : $row->GIRIS_TARIH);
				$filtre[":CIKIS_TARIH"] 	= $row->CIKIS_TARIH;
				$filtre[":GIRIS_NOKTASI"] 	= $row->GIRIS_NOKTASI;
				$filtre[":CIKIS_NOKTASI"] 	= $row->CIKIS_NOKTASI;
				$filtre[":KARAYOLU"] 		= $row->KARAYOLU;
				$filtre[":TUTAR"] 			= $row->TUTAR;
				$this->cdbPDO->rowsCount($sql, $filtre);
			} 
		}
		
		$filtre	= array();
		$sql = "UPDATE HGS SET GIRIS_TARIH = CIKIS_TARIH WHERE GIRIS_TARIH = '0000-00-00 00:00:00'";
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
		$sonuc["HATA"] 		= FALSE;
		$sonuc["ACIKLAMA"] 	= "HGS Çözüldü.";
		
		return $sonuc;
		
	}
	
	public function hgs_kontrol_edildi(){
		
		$filtre	= array();
		$sql = "UPDATE HGS SET KONTROL_EDILDI = 1 WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST['id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_ikame_disardan_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		if($_REQUEST['ikame_gun'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İkame gün '0' dan büyük olmalı!";
			return $sonuc;
		}
		
		if(FormatSayi::sayi2db($_REQUEST["ikame_maliyet"]) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İkame maliyet '0' dan büyük olmalı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
			
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	IKAME_GUN				= :IKAME_GUN,
									IKAME_MALIYET			= :IKAME_MALIYET
							WHERE ID = :ID
							";
		$filtre[":IKAME_GUN"]		= $_REQUEST["ikame_gun"];
		$filtre[":IKAME_MALIYET"] 	= FormatSayi::sayi2db($_REQUEST["ikame_maliyet"]);
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "İkame Maliyet Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	/*
	public function talep_ikame_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		if($_REQUEST['ikame_veren_id'] <= 0 ){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İkame vereni seçiniz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		$TARIH_KONTROL = 0;
		foreach($_REQUEST["arac_id"] as $key => $arac_id){
			if(FormatTarih::nokta2db($_REQUEST["ikame_gelis_tarih"][$key]) < FormatTarih::nokta2db($_REQUEST["ikame_verilis_tarih"][$key])){
				$TARIH_KONTROL++;
			}
		}
		if($TARIH_KONTROL > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Veriliş Tarihi Alış Tarihinden büyük !";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM TALEP_IKAME WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$rows_ikame2 = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows_ikame2 as $key => $row_ikame2){
			$rows_ikame[$row_ikame2->SIRA]	= $row_ikame2;
		}		
		
		foreach($_REQUEST["arac_id"] as $key => $arac_id){
			if($arac_id <= 0) continue;
			$sira++;
			
			$filtre	= array();
			$sql = "SELECT * FROM ARAC WHERE ID = :ID";
			$filtre[":ID"] 	= $_REQUEST["arac_id"][$key];
			$row_arac = $this->cdbPDO->row($sql, $filtre);
			
			if(is_null($rows_ikame[$sira]->ID)){
				$filtre	= array();
				$sql = "INSERT INTO TALEP_IKAME SET TALEP_ID 			= :TALEP_ID, 
													SIRA 				= :SIRA, 
													ARAC_ID 			= :ARAC_ID, 
													PLAKA				= :PLAKA,
													IKAME_VERILIS_TARIH = :IKAME_VERILIS_TARIH, 
													IKAME_VERILIS_SAAT 	= :IKAME_VERILIS_SAAT, 
													IKAME_GELIS_TARIH 	= :IKAME_GELIS_TARIH, 
													IKAME_GELIS_SAAT	= :IKAME_GELIS_SAAT,
													IKAME_KESIN_TARIH 	= :IKAME_KESIN_TARIH,
													KOD					= MD5(NOW())
													";
				$filtre[":TALEP_ID"] 			= $row->ID;
				$filtre[":SIRA"] 				= $sira;
				$filtre[":ARAC_ID"] 			= $row_arac->ID;
				$filtre[":PLAKA"] 				= $row_arac->PLAKA;
				$filtre[":IKAME_VERILIS_TARIH"] = FormatTarih::nokta2db($_REQUEST["ikame_verilis_tarih"][$key]);
				$filtre[":IKAME_VERILIS_SAAT"] 	= $_REQUEST["ikame_verilis_saat"][$key];
				$filtre[":IKAME_GELIS_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["ikame_gelis_tarih"][$key]);
				$filtre[":IKAME_KESIN_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["ikame_kesin_tarih"][$key]);
				$filtre[":IKAME_GELIS_SAAT"] 	= $_REQUEST["ikame_gelis_saat"][$key];
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
			} else if($rows_ikame[$sira]->ID > 0){
				$filtre	= array();
				$sql = "UPDATE TALEP_IKAME SET 	SIRA 				= :SIRA, 
												ARAC_ID 			= :ARAC_ID, 
												PLAKA				= :PLAKA,
												IKAME_VERILIS_TARIH = :IKAME_VERILIS_TARIH, 
												IKAME_VERILIS_SAAT 	= :IKAME_VERILIS_SAAT, 
												IKAME_GELIS_TARIH 	= :IKAME_GELIS_TARIH,
												IKAME_GELIS_SAAT	= :IKAME_GELIS_SAAT,
												IKAME_KESIN_TARIH 	= :IKAME_KESIN_TARIH
											WHERE ID = :ID
											";
				$filtre[":SIRA"] 				= $sira;
				$filtre[":ARAC_ID"] 			= $row_arac->ID;
				$filtre[":PLAKA"] 				= $row_arac->PLAKA;
				$filtre[":IKAME_VERILIS_TARIH"] = FormatTarih::nokta2db($_REQUEST["ikame_verilis_tarih"][$key]);
				$filtre[":IKAME_VERILIS_SAAT"] 	= $_REQUEST["ikame_verilis_saat"][$key];
				$filtre[":IKAME_GELIS_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["ikame_gelis_tarih"][$key]);
				$filtre[":IKAME_KESIN_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["ikame_kesin_tarih"][$key]);
				$filtre[":IKAME_GELIS_SAAT"] 	= $_REQUEST["ikame_gelis_saat"][$key];
				$filtre[":ID"] 					= $rows_ikame[$sira]->ID;
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
			}
			
		}
		
		$filtre	= array();
		$sql = "DELETE FROM TALEP_IKAME WHERE TALEP_ID = :TALEP_ID AND SIRA > :SIRA";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$filtre[":SIRA"] 		= $sira;
		$this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM TALEP_IKAME WHERE TALEP_ID = :TALEP_ID ORDER BY ID DESC LIMIT 1";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_ikame_arac = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT ID, PLAKA FROM ARAC WHERE ID = :ID";
		$filtre[":ID"] 	= $row_ikame_arac->ARAC_ID;
		$row_arac = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	IKAME_ID				= :IKAME_ID,
									IKAME_ARAC_ID			= :IKAME_ARAC_ID,
									IKAME_PLAKA				= :IKAME_PLAKA,
									IKAME_VEREN_ID			= :IKAME_VEREN_ID,
									IKAME_VERILIS_TARIH		= :IKAME_VERILIS_TARIH,
									IKAME_VERILIS_SAAT		= :IKAME_VERILIS_SAAT,
									IKAME_GELIS_TARIH		= :IKAME_GELIS_TARIH,
									IKAME_KESIN_TARIH		= :IKAME_KESIN_TARIH,
									GTARIH					= NOW()
							WHERE ID = :ID
							";
		$filtre[":IKAME_ID"] 			= $row_ikame_arac->ID;
		$filtre[":IKAME_ARAC_ID"] 		= $row_arac->ID;
		$filtre[":IKAME_PLAKA"] 		= $row_arac->PLAKA;
		$filtre[":IKAME_VEREN_ID"] 		= $_REQUEST["ikame_veren_id"];
		$filtre[":IKAME_VERILIS_TARIH"] = $row_ikame_arac->IKAME_VERILIS_TARIH;
		$filtre[":IKAME_VERILIS_SAAT"] 	= $row_ikame_arac->IKAME_VERILIS_SAAT;
		$filtre[":IKAME_GELIS_TARIH"] 	= $row_ikame_arac->IKAME_GELIS_TARIH;
		$filtre[":IKAME_KESIN_TARIH"] 	= $row_ikame_arac->IKAME_KESIN_TARIH;
		$filtre[":ID"] 					= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "İkame Bilgileri Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	*/
	
	public function plaka_arac_bul(){
		
		$filtre	= array();
		$sql = "SELECT * FROM TALEP WHERE PLAKA = :PLAKA AND ID != :ID ORDER BY ID DESC";
		$filtre[":PLAKA"] 	= $_REQUEST["plaka"];
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->ID > 0){
			$sonuc["HATA"] 				= FALSE;
			$sonuc["ACIKLAMA"]			= "Kayıt bulundu.";
			$sonuc["ID"] 				= $row->ID;
			$sonuc["CARI_ID"] 			= $row->CARI_ID;
			$sonuc["MARKA_ID"] 			= $row->MARKA_ID;
			$sonuc["MODEL_ID"] 			= $row->MODEL_ID;
			$sonuc["MODEL_YILI"] 		= $row->MODEL_YILI;
			$sonuc["SURUCU_AD_SOYAD"] 	= $row->SURUCU_AD_SOYAD;
			$sonuc["SURUCU_TEL"] 		= $row->SURUCU_TEL;
			$sonuc["YAKIT_TURU"] 		= $row->YAKIT_TURU;
			$sonuc["VITES_TURU"] 		= $row->VITES_TURU;
			$sonuc["SASI_NO"] 			= $row->SASI_NO;
			$sonuc["MOTOR_NO"] 			= $row->MOTOR_NO;
			$sonuc["ADRES"] 			= $row->ADRES;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= $_REQUEST["plaka"] . " plakalı araç bulunamadı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_talep_bul(){
		
		$filtre	= array();
		$sql = "SELECT ID, CARI_ID, PLAKA FROM TALEP WHERE ID = :ID";		
		$filtre[":ID"] 		= trim($_REQUEST["talep_no"]);
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->ID > 0){
			$sonuc["HATA"] 				= FALSE;
			$sonuc["ACIKLAMA"]			= $row->PLAKA . " bulundu.";			
			$sonuc["CARI_ID"] 			= $row->CARI_ID;
			$sonuc["PLAKA"] 			= $row->PLAKA;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kayıt bulunamadı!";
		}
		
		return $sonuc;
		
	}
	
	public function sigortali_bilgilerini_bul(){
		
		$filtre	= array();
		$sql = "SELECT ID, SIGORTALI_TEL, RUHSAT_SAHIBI FROM TALEP WHERE SIGORTALI_TCK = :SIGORTALI_TCK AND ID != :ID ORDER BY ID DESC";
		$filtre[":SIGORTALI_TCK"] 	= $_REQUEST["sigortali_tck"];
		$filtre[":ID"] 				= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->ID > 0){
			$sonuc["HATA"] 				= FALSE;
			$sonuc["ACIKLAMA"]			= "Kayıt bulundu.";
			$sonuc["SIGORTALI_TEL"] 	= $row->SIGORTALI_TEL;
			$sonuc["RUHSAT_SAHIBI"] 	= $row->RUHSAT_SAHIBI;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= $_REQUEST["sigortali_tck"] . " bilgileri bulunamadı!";
		}
		
		return $sonuc;
		
	}
	
	public function ruhsat_sahibi_bilgilerini_bul(){
		
		$filtre	= array();
		$sql = "SELECT CARI_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 				= $_REQUEST["id"];
		$row_talep = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT ID, CARI, CEPTEL, TCK FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 				= $row_talep->CARI_ID;
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->ID > 0){
			$sonuc["HATA"] 				= FALSE;
			$sonuc["ACIKLAMA"]			= "Kayıt bulundu.";
			$sonuc["SIGORTALI_TEL"] 	= $row->CEPTEL;
			$sonuc["RUHSAT_SAHIBI"] 	= $row->CARI;
			$sonuc["SIGORTALI_TCK"] 	= $row->TCK;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari bilgileri bulunamadı!";
		}
		
		return $sonuc;
		
	}
	
	public function yeni_fatura_no_bul(){
		/*
		$filtre	= array();
		$sql = "SELECT ID, CONCAT(SUBSTR(FATURA_NO, 1, 3), SUBSTR(FATURA_NO, 4, LENGTH(FATURA_NO) - 3) + 1) AS FATURA_NO FROM TALEP WHERE FATURA_NO LIKE '%GIB%' ORDER BY FATURA_NO DESC LIMIT 1";
		$row = $this->cdbPDO->row($sql, $filtre); 
		*/
		
		$filtre	= array();
		$sql = "SELECT ID, CONCAT(SUBSTR(FATURA_NO, 1, 3), SUBSTR(FATURA_NO, 4, LENGTH(FATURA_NO) - 3) + 1) AS FATURA_NO FROM SITE WHERE 1";
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->ID > 0){
			$sonuc["HATA"] 				= FALSE;
			$sonuc["ACIKLAMA"]			= "Kayıt bulundu.";
			$sonuc["FATURA_NO"] 		= $row->FATURA_NO;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura No Hatası!";
		}
		
		return $sonuc;
		
	}
	
	public function yeni_fatura_no_kontrol(){		
		$filtre	= array();
		$sql = "SELECT
					CH.ID,
					CH.FATURA_NO
				FROM CARI_HAREKET AS CH
				WHERE CH.HAREKET_ID = :HAREKET_ID AND CH.FATURA_NO = :FATURA_NO AND CH.ID != :ID 
				";
		$filtre[":HAREKET_ID"] 	= $_REQUEST["hareket_id"];
		$filtre[":FATURA_NO"] 	= trim($_REQUEST["fatura_no"]);
		$filtre[":ID"] 			= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"]	= "Aynı Fatura No daha önce girilmiş!!!";
			$sonuc["FATURA_NO"] = $row->FATURA_NO;
		}else{
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Fatura No Yok";
		}
		
		return $sonuc;
		
	}
	
	public function tahmini_iade_tarih_al(){
		
		$filtre	= array();
		$sql = "SELECT ID, TAHMINI_TESLIM_TARIH, TAHMINI_TESLIM_SAAT FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->ID > 0){
			$sonuc["HATA"] 					= FALSE;
			$sonuc["ACIKLAMA"]				= "Kayıt bulundu.";
			$sonuc["TAHMINI_TESLIM_TARIH"] 	= FormatTarih::tarih($row->TAHMINI_TESLIM_TARIH);
			$sonuc["TAHMINI_TESLIM_SAAT"] 	= str_pad($row->TAHMINI_TESLIM_SAAT, 2, "0", STR_PAD_LEFT) . ":00";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";
		}
		
		return $sonuc;
		
	}	
	
	public function talep_toplu_iskonto_uygula(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		if($_REQUEST['toplu_iskonto'] > 100 ){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İskonto 100 den fazla olamaz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE PARCA SET ISKONTO = :TOPLU_ISKONTO, TUTAR = FIYAT * ADET * (100 - :TOPLU_ISKONTO) / 100 WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TOPLU_ISKONTO"] 	= FormatSayi::sayi2db($_REQUEST["toplu_iskonto"]);
		$filtre[":TALEP_ID"] 		= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT SUM(TUTAR) AS ODENECEK_TUTAR FROM PARCA WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_tutar = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET TOPLU_ISKONTO = :TOPLU_ISKONTO, ODENECEK_TUTAR = :ODENECEK_TUTAR, GTARIH = NOW() WHERE ID = :ID";
		$filtre[":TOPLU_ISKONTO"] 	= FormatSayi::sayi2db($_REQUEST["toplu_iskonto"]);
		$filtre[":ODENECEK_TUTAR"] 	= $row_tutar->ODENECEK_TUTAR;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_toplu_siparis_tarih_uygula(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		if($_REQUEST['toplu_iskonto'] > 100 ){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İskonto 100 den fazla olamaz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE PARCA SET SIPARIS_TARIH = :SIPARIS_TARIH WHERE TALEP_ID = :TALEP_ID";
		$filtre[":SIPARIS_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["toplu_siparis_tarih"]);
		$filtre[":TALEP_ID"] 		= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET TOPLU_SIPARIS_TARIH = :TOPLU_SIPARIS_TARIH, GTARIH = NOW() WHERE ID = :ID";
		$filtre[":TOPLU_SIPARIS_TARIH"] = FormatTarih::nokta2db($_REQUEST["toplu_siparis_tarih"]);
		$filtre[":ID"] 					= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}	
	
	public function talep_sil(){
		
		if(!in_array($_SESSION['yetki_id'], array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Randevuluya çevirme yetkiniz yok!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(!in_array($row->SUREC_ID, array(1,2,3))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Araç Seviste,Araç Bekliyor yada Randevulu' olması gerekiyor!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}	
	
	public function talep_randevulu(){
		
		if(!in_array($_SESSION['yetki_id'], array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Randevuluya çevirme yetkiniz yok!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(!in_array($row->SUREC_ID, array(1,2,3))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Araç Bekliyor yada Randevulu' olması gerekiyor!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	SUREC_ID			= :SUREC_ID,
									ARAC_SERVISTE_TARIH	= NULL,	
									GTARIH				= NOW()
							WHERE ID = :ID
							";
		$filtre[":SUREC_ID"] 		= 1;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
		
	public function talep_arac_serviste(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(!in_array($row->SUREC_ID, array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Araç Bekliyor yada Randevulu' olması gerekiyor!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	SUREC_ID			= :SUREC_ID,
									ARAC_SERVISTE_TARIH	= NOW(),	
									GTARIH				= NOW()
							WHERE ID = :ID
							";
		$filtre[":SUREC_ID"] 		= 3;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_tamire_baslandi(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID, SURUCU_AD_SOYAD, PLAKA, SURUCU_TEL, TAMIR_BAS_TARIH FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID != 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Araç Serviste' olması gerekiyor!";	
			return $sonuc;
		}
		
		if(strlen($row->SURUCU_TEL) == 14 AND is_null($row->TAMIR_BAS_TARIH)){
			$filtre = array();
			$sql = "SELECT
						SK.ID,
						SK.SMS_KALIBI
					FROM SMS_KALIBI AS SK
					WHERE SK.ID = 2
					";
			$row_sms_kalibi = $this->cdbPDO->row($sql, $filtre);
			$row_sms_kalibi->SMS_KALIBI = str_replace('{ADSOYAD}', $row->SURUCU_AD_SOYAD, $row_sms_kalibi->SMS_KALIBI);
			$row_sms_kalibi->SMS_KALIBI = str_replace('{PLAKA}', $row->PLAKA, $row_sms_kalibi->SMS_KALIBI);
			$result = $this->cSms->soapGonder(FormatTel::smsTemizle($row->SURUCU_TEL), "BORYAZ", $row_sms_kalibi->SMS_KALIBI);
		}
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	SUREC_ID			= :SUREC_ID,
									TAMIR_BAS_TARIH		= NOW(),	
									GTARIH				= NOW()
							WHERE ID = :ID
							";
		$filtre[":SUREC_ID"] 		= 4;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
		
	public function talep_tamir_bitti(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID != 4){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Tamire Başlandı' olması gerekiyor!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	SUREC_ID			= :SUREC_ID,
									TAMIR_BIT_TARIH		= NOW(),	
									GTARIH				= NOW()
							WHERE ID = :ID
							";
		$filtre[":SUREC_ID"] 		= 5;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_teslime_hazir(){
		/*
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		*/
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID, CARI_ID, ODENECEK_TUTAR, PLAKA, DOSYA_NO, FATURA_NO, FATURA_TARIH, SURUCU_AD_SOYAD, SURUCU_TEL, TESLIME_HAZIR_TARIH, EFATURA_UUID, FATURA_KES FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->CARI_ID <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		/*
		if($row->SUREC_ID != 5 AND !in_array($_SESSION['kullanici'],array("ADMIN"))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Kontrol Bekliyor' olması gerekiyor!";	
			return $sonuc;
		}
		*/
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	SUREC_ID			= :SUREC_ID,
									TESLIME_HAZIR_TARIH	= NOW(),	
									GTARIH				= NOW()
							WHERE ID = :ID
							";
		$filtre[":SUREC_ID"] 		= 6;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT ID, VADE FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $row->CARI_ID;
		$row_cari = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM CARI_HAREKET WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_ch = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row_ch->ID)){
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID			= 1,
													FINANS_KALEMI_ID	= :FINANS_KALEMI_ID,
													ODEME_KANALI_ID		= :ODEME_KANALI_ID,
													TALEP_ID			= :TALEP_ID,
													CARI_ID				= :CARI_ID,
													TUTAR				= :TUTAR,
													KDV_TUTAR			= IF(:FATURA_KES = 2, 0, (:TUTAR / 118 * 18)),
													FATURA_NO			= :FATURA_NO,
													FATURA_TARIH		= :FATURA_TARIH,
													VADE_TARIH			= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
													PLAKA				= :PLAKA,
													DOSYA_NO			= :DOSYA_NO,
													EFATURA_UUID		= :EFATURA_UUID,
													FATURA_KES			= :FATURA_KES,
													ACIKLAMA			= :ACIKLAMA,
													KAYIT_YAPAN_ID		= :KAYIT_YAPAN_ID,
													TARIH				= NOW(),
													KOD					= MD5(NOW())
													";
			$filtre[":FINANS_KALEMI_ID"] 	= 1;
			$filtre[":ODEME_KANALI_ID"] 	= NULL;			
			$filtre[":TALEP_ID"] 			= $row->ID;
			$filtre[":CARI_ID"] 			= $row->CARI_ID;
			$filtre[":TUTAR"] 				= $row->ODENECEK_TUTAR;
			$filtre[":FATURA_NO"] 			= $row->FATURA_NO;
			$filtre[":FATURA_TARIH"] 		= $row->FATURA_TARIH;
			$filtre[":VADE"] 				= $row_cari->VADE;
			$filtre[":PLAKA"] 				= $row->PLAKA;
			$filtre[":DOSYA_NO"] 			= $row->DOSYA_NO;
			$filtre[":EFATURA_UUID"] 		= $row->EFATURA_UUID;
			$filtre[":FATURA_KES"] 			= $row->FATURA_KES;
			$filtre[":ACIKLAMA"] 			= "Otomatik";
			$filtre[":KAYIT_YAPAN_ID"] 		= $_SESSION['kullanici_id'];
			$this->cdbPDO->rowsCount($sql, $filtre); 
			
		} else {
						
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET FINANS_KALEMI_ID	= :FINANS_KALEMI_ID,
											ODEME_KANALI_ID		= :ODEME_KANALI_ID,
											TALEP_ID			= :TALEP_ID,
											CARI_ID				= :CARI_ID,
											TUTAR				= :TUTAR,
											KDV_TUTAR			= IF(:FATURA_KES = 2, 0, (:TUTAR / 118 * 18)),
											FATURA_NO			= :FATURA_NO,
											FATURA_TARIH		= :FATURA_TARIH,
											VADE_TARIH			= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
											PLAKA				= :PLAKA,
											DOSYA_NO			= :DOSYA_NO,
											EFATURA_UUID		= :EFATURA_UUID,
											FATURA_KES			= :FATURA_KES,
											ACIKLAMA			= :ACIKLAMA
									WHERE ID = :ID
									";
			$filtre[":FINANS_KALEMI_ID"] 	= 1;
			$filtre[":ODEME_KANALI_ID"] 	= NULL;			
			$filtre[":TALEP_ID"] 			= $row->ID;
			$filtre[":CARI_ID"] 			= $row->CARI_ID;
			$filtre[":TUTAR"] 				= $row->ODENECEK_TUTAR;
			$filtre[":FATURA_NO"] 			= $row->FATURA_NO;
			$filtre[":FATURA_TARIH"] 		= $row->FATURA_TARIH;
			$filtre[":VADE"] 				= $row_cari->VADE;
			$filtre[":PLAKA"] 				= $row->PLAKA;
			$filtre[":DOSYA_NO"] 			= $row->DOSYA_NO;
			$filtre[":EFATURA_UUID"] 		= $row->EFATURA_UUID;
			$filtre[":FATURA_KES"] 			= $row->FATURA_KES;
			$filtre[":ACIKLAMA"] 			= "Otomatik";
			$filtre[":ID"] 					= $row_ch->ID;
			$this->cdbPDO->rowsCount($sql, $filtre); 
			
		}
		
		if(strlen($row->SURUCU_TEL) == 14 AND is_null($row->TESLIME_HAZIR_TARIH) AND $_REQUEST['sms'] == 1){
			$filtre = array();
			$sql = "SELECT
						SK.ID,
						SK.SMS_KALIBI
					FROM SMS_KALIBI AS SK
					WHERE SK.ID = 3
					";
			$row_sms_kalibi = $this->cdbPDO->row($sql, $filtre);
			$row_sms_kalibi->SMS_KALIBI = str_replace('{ADSOYAD}', $row->SURUCU_AD_SOYAD, $row_sms_kalibi->SMS_KALIBI);
			$row_sms_kalibi->SMS_KALIBI = str_replace('{PLAKA}', $row->PLAKA, $row_sms_kalibi->SMS_KALIBI);
			$result = $this->cSms->soapGonder(FormatTel::smsTemizle($row->SURUCU_TEL), "BORYAZ", $row_sms_kalibi->SMS_KALIBI);
		}
		
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "TALEP", "cKayıt");
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function alt_dosya_ac(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->CARI_ID <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO TALEP SET";
		foreach($row as $key => $value){
			if(!in_array($key, array("ID", "TARIH", "KOD", "DOSYA_NO"))){
				$sql.= " $key = :$key,";
				$filtre[":$key"] 	= $value;
			}
		}
		$sql = substr($sql,0,strlen($sql)-1);
		$TALEP_ID = $this->cdbPDO->lastInsertId($sql, $filtre);	
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	UST_TALEP_ID 		= :UST_TALEP_ID, 
									SUREC_ID 			= 3,
									IKAME_ID			= NULL,
									IKAME_ARAC_ID		= NULL,
									IKAME_PLAKA			= NULL,
									IKAME_ARAC_BILGI	= NULL,
									IKAME_VERILIS_TARIH	= NULL,
									IKAME_VERILIS_SAAT	= NULL,
									IKAME_GELIS_TARIH	= NULL,
									IKAME_GELIS_SAAT	= NULL,
									IKAME_KESIN_TARIH	= NULL,
									ODENECEK_TUTAR		= 0,
									FATURA_NO			= NULL,
									FATURA_TARIH		= NULL,
									FATURA_TUTAR		= NULL,
									FATURA_ACIKLAMA		= NULL,
									EFATURA_UUID		= NULL,
									KALEM_SAYISI		= 0,
									TARIH 				= NOW(), 
									KOD 				= MD5(NOW()) 
								WHERE ID = :ID
								";
		$filtre[":UST_TALEP_ID"] 	= $row->ID;
		$filtre[":ID"] 				= $TALEP_ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "TALEP", "cKayıt");
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 				= $TALEP_ID;
		$row_yeni = $this->cdbPDO->row($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";		
			$sonuc["URL"] 		= "/talep/talep.do?route=talep/servis&id={$row_yeni->ID}&kod={$row_yeni->KOD}";	
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_teslim_edildi(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID, CARI_ID, PLAKA, DOSYA_NO, FATURA_TUTAR, FATURA_NO, FATURA_TARIH, IKAME_VEREN_ID, IKAME_MALIYET, EFATURA_UUID, FATURA_KES FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID != 6){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslime Hazır' olması gerekiyor!";	
			return $sonuc;
		}
		
		if(strlen($row->FATURA_NO) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura No girmeden dosya teslim edildiye getirilemez!";	
			return $sonuc;
		}
		
		if($row->FATURA_TARIH == "" OR $row->FATURA_TARIH == "0000-00-00"){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Tarihi giriniz!";	
			return $sonuc;
		}
		
		if($row->CARI_ID <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari olmadan 'teslim edildi' getirilemez!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, VADE FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $row->CARI_ID;
		$row_cari = $this->cdbPDO->row($sql, $filtre); 
		
		// Cari Hareket ID
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM CARI_HAREKET WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_ch = $this->cdbPDO->row($sql, $filtre); 
		$cari_ch_id = $row_ch->ID;
		
		if(is_null($row_ch->ID)){
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID			= 1,
													FINANS_KALEMI_ID	= :FINANS_KALEMI_ID,
													ODEME_KANALI_ID		= :ODEME_KANALI_ID,
													TALEP_ID			= :TALEP_ID,
													CARI_ID				= :CARI_ID,
													TUTAR				= :TUTAR,
													KDV_TUTAR			= IF(:FATURA_KES = 2, 0, (:TUTAR / 118 * 18)),
													FATURA_NO			= :FATURA_NO,
													FATURA_TARIH		= :FATURA_TARIH,
													VADE_TARIH			= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
													PLAKA				= :PLAKA,
													DOSYA_NO			= :DOSYA_NO,
													EFATURA_UUID		= :EFATURA_UUID,
													FATURA_KES			= :FATURA_KES,
													ACIKLAMA			= :ACIKLAMA,
													TEVKIFAT_ID			= :TEVKIFAT_ID,
													KAYIT_YAPAN_ID		= :KAYIT_YAPAN_ID,
													TARIH				= NOW(),
													KOD					= MD5(NOW())
													";
			$filtre[":FINANS_KALEMI_ID"] 	= 1;
			$filtre[":ODEME_KANALI_ID"] 	= NULL;			
			$filtre[":TALEP_ID"] 			= $row->ID;
			$filtre[":CARI_ID"] 			= $row->CARI_ID;
			$filtre[":TUTAR"] 				= $row->FATURA_TUTAR;
			$filtre[":FATURA_NO"] 			= $row->FATURA_NO;
			$filtre[":FATURA_TARIH"] 		= $row->FATURA_TARIH;
			$filtre[":VADE"] 				= $row_cari->VADE;
			$filtre[":PLAKA"] 				= $row->PLAKA;
			$filtre[":DOSYA_NO"] 			= $row->DOSYA_NO;
			$filtre[":EFATURA_UUID"] 		= $row->EFATURA_UUID;
			$filtre[":FATURA_KES"] 			= $row->FATURA_KES;
			$filtre[":ACIKLAMA"] 			= "Otomatik";
			$filtre[":TEVKIFAT_ID"] 		= $row->TEVKIFAT_ID;
			$filtre[":KAYIT_YAPAN_ID"] 		= $_SESSION['kullanici_id'];
			$cari_ch_id = $this->cdbPDO->lastInsertId($sql, $filtre);
			
		} else {
						
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET FINANS_KALEMI_ID	= :FINANS_KALEMI_ID,
											ODEME_KANALI_ID		= :ODEME_KANALI_ID,
											TALEP_ID			= :TALEP_ID,
											CARI_ID				= :CARI_ID,
											TUTAR				= :TUTAR,
											KDV_TUTAR			= IF(:FATURA_KES = 2, 0, (:TUTAR / 118 * 18)),
											FATURA_NO			= :FATURA_NO,
											FATURA_TARIH		= :FATURA_TARIH,
											VADE_TARIH			= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
											PLAKA				= :PLAKA,
											DOSYA_NO			= :DOSYA_NO,
											EFATURA_UUID		= :EFATURA_UUID,
											FATURA_KES			= :FATURA_KES,
											ACIKLAMA			= :ACIKLAMA,
											TEVKIFAT_ID			= :TEVKIFAT_ID
									WHERE ID = :ID
									";
			$filtre[":FINANS_KALEMI_ID"] 	= 1;
			$filtre[":ODEME_KANALI_ID"] 	= NULL;			
			$filtre[":TALEP_ID"] 			= $row->ID;
			$filtre[":CARI_ID"] 			= $row->CARI_ID;
			$filtre[":TUTAR"] 				= $row->FATURA_TUTAR;
			$filtre[":FATURA_NO"] 			= $row->FATURA_NO;
			$filtre[":FATURA_TARIH"] 		= $row->FATURA_TARIH;
			$filtre[":VADE"] 				= $row_cari->VADE;
			$filtre[":PLAKA"] 				= $row->PLAKA;
			$filtre[":DOSYA_NO"] 			= $row->DOSYA_NO;
			$filtre[":EFATURA_UUID"] 		= $row->EFATURA_UUID;
			$filtre[":FATURA_KES"] 			= $row->FATURA_KES;
			$filtre[":ACIKLAMA"] 			= "Otomatik";
			$filtre[":TEVKIFAT_ID"] 		= $row->TEVKIFAT_ID;
			$filtre[":ID"] 					= $row_ch->ID;
			$this->cdbPDO->rowsCount($sql, $filtre); 
			
		}
		
		// Cari Hareket Detay ID
		$filtre	= array();
		$sql = "DELETE FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID";
		$filtre[":CARI_HAREKET_ID"] 	= $cari_ch_id;
		$this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM PARCA WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$rows_parca = $this->cdbPDO->rows($sql, $filtre); 
		
		$sira = 0;
		foreach($rows_parca as $key => $row_parca){
			$sira++;
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET_DETAY SET CARI_HAREKET_ID = :CARI_HAREKET_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, KDV = :KDV, GTARIH = NOW()";
			$filtre[":CARI_HAREKET_ID"] = $cari_ch_id;
			$filtre[":SIRA"] 			= $sira;
			$filtre[":PARCA_KODU"] 		= $row_parca->PARCA_KODU;
			$filtre[":PARCA_ADI"] 		= $row_parca->PARCA_ADI;
			$filtre[":ADET"] 			= $row_parca->ADET;
			$filtre[":FIYAT"] 			= $row_parca->FIYAT;
			$filtre[":ISKONTO"] 		= $row_parca->ISKONTO;
			$filtre[":ISKONTOLU"] 		= $row_parca->ISKONTOLU;
			$filtre[":TUTAR"] 			= $row_parca->TUTAR;
			$filtre[":KDV"] 			= $row_parca->KDV;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM ISCILIK WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$rows_iscilik = $this->cdbPDO->rows($sql, $filtre); 
		
		foreach($rows_iscilik as $key => $row_parca){
			$sira++;		
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET_DETAY SET CARI_HAREKET_ID = :CARI_HAREKET_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, KDV = :KDV, GTARIH = NOW()";
			$filtre[":CARI_HAREKET_ID"] = $cari_ch_id;
			$filtre[":SIRA"] 			= $sira;
			$filtre[":PARCA_KODU"] 		= $row_parca->PARCA_KODU;
			$filtre[":PARCA_ADI"] 		= $row_parca->PARCA_ADI;
			$filtre[":ADET"] 			= $row_parca->ADET;
			$filtre[":FIYAT"] 			= $row_parca->FIYAT;
			$filtre[":ISKONTO"] 		= $row_parca->ISKONTO;
			$filtre[":ISKONTOLU"] 		= $row_parca->ISKONTOLU;
			$filtre[":TUTAR"] 			= $row_parca->TUTAR;
			$filtre[":KDV"] 			= $row_parca->KDV;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		// İkame Baş
		if($row->IKAME_VEREN_ID == 2 AND $row->IKAME_MALIYET > 0){
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 2,
													FINANS_KALEMI_ID		= 6,
													FATURA_NO				= '',
													FATURA_TARIH			= CURDATE(),
													TUTAR					= :TUTAR,
													KDV_TUTAR				= (:TUTAR / 118 * 18),
													CARI_ID					= 1,
													ARAC_ID					= 0,
													PLAKA					= :PLAKA,
													ACIKLAMA				= :ACIKLAMA,
													KALEM_SAYISI			= 1,
													KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
													TARIH					= NOW(),
													KOD						= MD5(NOW())
													";
			$filtre[":TUTAR"] 					= $row->IKAME_MALIYET * 1.18;
			$filtre[":PLAKA"] 					= $row->PLAKA;
			$filtre[":ACIKLAMA"] 				= $row->ID . " İKAME MALİYET";
			$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];			
			$cari_ch_ikame_id = $this->cdbPDO->lastInsertId($sql, $filtre);
			
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET_DETAY SET CARI_HAREKET_ID = :CARI_HAREKET_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, KDV = :KDV, GTARIH = NOW()";
			$filtre[":CARI_HAREKET_ID"] = $cari_ch_ikame_id;
			$filtre[":SIRA"] 			= 1;
			$filtre[":PARCA_KODU"] 		= "";
			$filtre[":PARCA_ADI"] 		=  $row->ID . " İKAME MALİYET";
			$filtre[":ADET"] 			= 1;
			$filtre[":FIYAT"] 			= $row->IKAME_MALIYET;
			$filtre[":ISKONTO"] 		= 0;
			$filtre[":ISKONTOLU"] 		= $row->IKAME_MALIYET;
			$filtre[":TUTAR"] 			= $row->IKAME_MALIYET * 1.18;
			$filtre[":KDV"] 			= 1;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET KALEM_SAYISI = :KALEM_SAYISI WHERE ID = :ID";
		$filtre[":KALEM_SAYISI"] 		= ceil($sira / 5) * 5;
		$filtre[":ID"] 					= $row_ch->ID;
		$this->cdbPDO->rowsCount($sql, $filtre); 
		
		// Talep Baş
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	IKAME_ID				= 0,
									IKAME_ARAC_ID			= 0,
									IKAME_PLAKA				= '',
									IKAME_VERILIS_TARIH		= NULL,
									IKAME_VERILIS_SAAT		= 0,
									IKAME_GELIS_TARIH		= NULL,
									IKAME_GELIS_SAAT		= 0,
									SUREC_ID				= :SUREC_ID,
									TESLIM_EDILDI_TARIH		= NOW(),	
									GTARIH					= NOW()
							WHERE ID = :ID
							";
		$filtre[":SUREC_ID"] 		= 10;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "TALEP", "cKayıt");
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_odeme_yapildi(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,5))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID != 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslime Edildi' olması gerekiyor!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	MUHASEBE_SUREC_ID	= :MUHASEBE_SUREC_ID,
									ODEME_YAPILDI_TARIH	= NOW(),	
									GTARIH				= NOW()
							WHERE ID = :ID
							";
		$filtre[":MUHASEBE_SUREC_ID"] 	= 3;
		$filtre[":ID"] 					= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_iptal(){
		
		if(!in_array($_SESSION['kullanici'],array("ADMIN"))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep İptal yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID, CARI_ID, PLAKA, DOSYA_NO, FATURA_TUTAR, FATURA_NO, FATURA_TARIH, IKAME_VEREN_ID, IKAME_MALIYET FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM CARI_HAREKET WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$row_ch = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "DELETE FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID";
		$filtre[":CARI_HAREKET_ID"] 	= $row_ch->ID;
		$this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "DELETE FROM CARI_HAREKET WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$this->cdbPDO->rowsCount($sql, $filtre); 
		
		// Talep Baş
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	IPTAL					= 1,
									IKAME_ID				= 0,
									IKAME_ARAC_ID			= 0,
									IKAME_PLAKA				= '',
									IKAME_VERILIS_TARIH		= NULL,
									IKAME_VERILIS_SAAT		= 0,
									IKAME_GELIS_TARIH		= NULL,
									IKAME_GELIS_SAAT		= 0,
									SUREC_ID				= :SUREC_ID,
									TESLIM_EDILDI_TARIH		= NOW(),	
									GTARIH					= NOW()
							WHERE ID = :ID
							";
		$filtre[":SUREC_ID"] 		= 10;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "TALEP", "cKayıt");
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function gelen_efatura_aktar(){
		global $cUyumsoft;
		
		$row_efatura = $cUyumsoft->fncGelenFatura($_REQUEST["uuid"]);
		//var_dump2($row_efatura);die(); //json_decode(html_entity_decode($_REQUEST['data']));
		$row_efatura->GONDEREN_VKN = $_REQUEST["vkn"];
		
		if(strlen($row_efatura->FATURA_NO) != 16){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura No girmeden dosya teslim edildiye getirilemez!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE HAREKET_ID = 2 AND FATURA_NO = :FATURA_NO";
		$filtre[":FATURA_NO"] 		= $row_efatura->FATURA_NO;
		$row_kontrol = $this->cdbPDO->row($sql, $filtre); 
		
		if(!is_null($row_kontrol->FATURA_NO)){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Daha önce entegre edilmiş! Fatura No: ". $row_kontrol->FATURA_NO;
			return $sonuc;
		}		
		
		if($row_efatura->FATURA_TARIH == "" OR $row_efatura->FATURA_TARIH == "0000-00-00"){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Tarihi giriniz!";	
			return $sonuc;
		}
		
		//if($row_efatura->GONDEREN_VKN == "0380052062355414") $row_efatura->GONDEREN_VKN = "3800520623";
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE TCK = :TCK";
		$filtre[":TCK"] 		= $row_efatura->GONDEREN_VKN;
		$row_cari = $this->cdbPDO->row($sql, $filtre); 
		
		// 8590491872 TTNET
		// 8770013406 TürkTelekom
		// 1790617537 Boğaziçi
		if(in_array($row_efatura->GONDEREN_VKN, array("8590491872", "8770013406", "0179061753700017","1790617537","7320068060","9250451691","8370544006", "2530759503", "9860008925"))){
			$filtre	= array();
			$sql = "SELECT * FROM CARI WHERE ID = 101";
			$row_cari = $this->cdbPDO->row($sql, $filtre); 
		}
		
		if($row_cari->ID <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Bulunamadı! VKN: ". $row_efatura->GONDEREN_VKN . ", Firma: ". $row_efatura->GONDEREN;	
			return $sonuc;
		}
		
		// Cari Hareket ID
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID			= 2,
												FINANS_KALEMI_ID	= :FINANS_KALEMI_ID,
												ODEME_KANALI_ID		= :ODEME_KANALI_ID,
												CARI_ID				= :CARI_ID,
												TUTAR				= :TUTAR,
												KDV_TUTAR			= IF(:KDV = 1, (:TUTAR / 101 * 1), (:TUTAR / 118 * 18)),
												FATURA_NO			= :FATURA_NO,
												FATURA_TARIH		= :FATURA_TARIH,
												EFATURA_UUID		= :EFATURA_UUID,
												FATURA_KES			= :FATURA_KES,
												ACIKLAMA			= :ACIKLAMA,
												VADE_TARIH			= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
												KAYIT_YAPAN_ID		= :KAYIT_YAPAN_ID,
												TARIH				= NOW(),
												KOD					= MD5(NOW())
												";
		$filtre[":FINANS_KALEMI_ID"] 	= 1;
		$filtre[":ODEME_KANALI_ID"] 	= NULL;			
		$filtre[":CARI_ID"] 			= $row_cari->ID;
		$filtre[":TUTAR"] 				= $row_efatura->FATURA_TUTAR;
		$filtre[":KDV"] 				= $row_efatura->FATURA_KDV_ORAN;
		$filtre[":FATURA_NO"] 			= $row_efatura->FATURA_NO;
		$filtre[":FATURA_TARIH"] 		= $row_efatura->FATURA_TARIH;
		$filtre[":EFATURA_UUID"] 		= $row_efatura->FATURA_UUID;
		$filtre[":FATURA_KES"] 			= 1;
		$filtre[":ACIKLAMA"] 			= "Otomatik " . $row_efatura->GONDEREN;
		$filtre[":VADE"] 				= 15;
		$filtre[":KAYIT_YAPAN_ID"] 		= $_SESSION['kullanici_id'];
		$cari_ch_id = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		$sira = 0;
		foreach($row_efatura->PARCA as $key => $row_parca){
			$sira++;
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET_DETAY SET CARI_HAREKET_ID = :CARI_HAREKET_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, KDV = :KDV, GTARIH = NOW()";
			$filtre[":CARI_HAREKET_ID"] = $cari_ch_id;
			$filtre[":SIRA"] 			= $sira;
			$filtre[":PARCA_KODU"] 		= $row_parca->PARCA_KODU;
			$filtre[":PARCA_ADI"] 		= $row_parca->PARCA_ADI;
			$filtre[":ADET"] 			= $row_parca->ADET;
			$filtre[":FIYAT"] 			= $row_parca->TUTAR;
			$filtre[":ISKONTO"] 		= 0;
			$filtre[":ISKONTOLU"] 		= $row_parca->TUTAR;
			$filtre[":TUTAR"] 			= $row_parca->TUTAR + $row_parca->KDV;
			$filtre[":KDV"] 			= $row_parca->KDV_ORAN;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		$this->fncIslemLog($cari_ch_id, $this->cdbPDO->getSQL($sql, $filtre), $row_efatura, __FUNCTION__, "CARI_HAREKET", "cKayıt");
		
		if($cari_ch_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi. ". 
			$sonuc["FATURA_NO"] = $row_efatura->FATURA_NO;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function gelen_efatura_iptal(){
		global $cUyumsoft;
		
		// Cari Hareket ID
		$filtre	= array();
		$sql = "REPLACE INTO EFATURA_GELEN_IPTAL SET 	FATURA_NO	= :FATURA_NO,
														FATURA_UUID	= :FATURA_UUID,
														FATURA_VKN	= :FATURA_VKN
														";
		$filtre[":FATURA_NO"] 		= $_REQUEST["fatura_no"];
		$filtre[":FATURA_UUID"] 	= $_REQUEST["uuid"];			
		$filtre[":FATURA_VKN"] 		= $_REQUEST["vkn"];
		$rowsCount = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		if(1){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi. ". 
			$sonuc["FATURA_NO"] = "İptal Edildi!";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function surec_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM SUREC WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["SUREC"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function bakim_grup_model_ekle(){
		
		if($_REQUEST["id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bakım Grup Id bulunamadı!";
			return $sonuc;
		}
		
		if($_REQUEST["marka_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Marka seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["model_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Model seçiniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "REPLACE INTO BAKIM_GRUP_MODEL SET BAKIM_GRUP_ID = :BAKIM_GRUP_ID, MODEL_ID = :MODEL_ID";
		$filtre[":BAKIM_GRUP_ID"] 	= $_REQUEST["id"];
		$filtre[":MODEL_ID"] 		= $_REQUEST["model_id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function bakim_grup_model_sil(){
		
		if($_REQUEST["id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bakım Grup Id bulunamadı!";
			return $sonuc;
		}
		
		if($_REQUEST["model_id"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Model seçiniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM BAKIM_GRUP_MODEL WHERE BAKIM_GRUP_ID = :BAKIM_GRUP_ID AND MODEL_ID = :MODEL_ID";
		$filtre[":BAKIM_GRUP_ID"] 	= $_REQUEST["id"];
		$filtre[":MODEL_ID"] 		= $_REQUEST["model_id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}	
	
	public function evrak_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO EVRAK SET 	EVRAK			= :EVRAK,
										DURUM			= :DURUM
										";
		$filtre[":EVRAK"] 			= trim($_REQUEST["evrak"]);
		$filtre[":DURUM"] 			= $_REQUEST["durum"];
		
		$evrak_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($evrak_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["EVRAK_ID"] 	= $evrak_id;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function evrak_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE EVRAK SET 	EVRAK			= :EVRAK,
									DURUM			= :DURUM
								WHERE ID = :ID
								";
		$filtre[":EVRAK"] 			= trim($_REQUEST["evrak"]);
		$filtre[":DURUM"] 			= $_REQUEST["durum"];
		$filtre[":ID"] 				= $_REQUEST["id"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function evrak_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM EVRAK WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["EVRAK"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function menu_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM MENU WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["MENU"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function menu_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE MENU SET	MENU 			= :MENU,
								LINK			= :LINK,
								TITLE			= :TITLE,
								SIRA			= :SIRA,
								ROUTE			= :ROUTE,
								YETKI_IDS		= :YETKI_IDS,
								DURUM			= :DURUM
							WHERE ID = :ID
							LIMIT 1
							";
		$filtre[":MENU"] 		= trim($_REQUEST["menu"]);	
		$filtre[":LINK"] 		= trim($_REQUEST["link"]);	
		$filtre[":TITLE"]		= trim($_REQUEST["title"]);	
		$filtre[":SIRA"] 		= $_REQUEST["sira"];
		$filtre[":ROUTE"] 		= trim($_REQUEST["route"]);
		$filtre[":YETKI_IDS"] 	= "1," . implode(',', $_REQUEST["yetki_ids"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];
		$filtre[":ID"] 			= $_REQUEST["id"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function menu_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO MENU SET	MENU 			= :MENU,
										LINK			= :LINK,
										TITLE			= :TITLE,
										ROUTE			= :ROUTE,
										SIRA			= :SIRA,
										YETKI_IDS		= :YETKI_IDS,
										DURUM			= :DURUM
										";
		$filtre[":MENU"] 		= trim($_REQUEST["menu"]);	
		$filtre[":LINK"] 		= trim($_REQUEST["link"]);	
		$filtre[":TITLE"]		= trim($_REQUEST["title"]);	
		$filtre[":SIRA"] 		= $_REQUEST["sira"];
		$filtre[":ROUTE"] 		= trim($_REQUEST["route"]);
		$filtre[":YETKI_IDS"] 	= "1," . implode(',', $_REQUEST["yetki_ids"]);
		$filtre[":DURUM"] 		= $_REQUEST["durum"];
		
		$menu_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($menu_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function yetki_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM YETKI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["YETKI"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function yetki_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO YETKI SET	YETKI 			= :YETKI,
										DURUM			= :DURUM,
										ACIKLAMA		= :ACIKLAMA
										";
		$filtre[":YETKI"] 		= trim($_REQUEST["yetki"]);	
		$filtre[":DURUM"] 		= $_REQUEST["durum"];
		$filtre[":ACIKLAMA"]	= $_REQUEST["aciklama"];
		
		$yetki_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($yetki_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function yetki_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE YETKI SET 	YETKI 			= :YETKI,
									DURUM			= :DURUM,
									ACIKLAMA		= :ACIKLAMA
							WHERE ID = :ID
							";
		$filtre[":YETKI"] 		= trim($_REQUEST["yetki"]);	
		$filtre[":DURUM"] 		= $_REQUEST["durum"];
		$filtre[":ACIKLAMA"]	= $_REQUEST["aciklama"];
		$filtre[":ID"] 			= $_REQUEST["id"];
		
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function gorev_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM GOREV WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["GOREV"]	= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function gorev_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO YETKI SET	GOREV 			= :GOREV,
										DURUM			= :DURUM,
										PRIM_ORAN		= :PRIM_ORAN
										";
		$filtre[":GOREV"] 		= trim($_REQUEST["gorev"]);	
		$filtre[":DURUM"] 		= $_REQUEST["durum"];
		$filtre[":PRIM_ORAN"]	= $_REQUEST["prim_oran"];
		$meslek_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($meslek_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function gorev_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE GOREV SET 	GOREV 			= :GOREV,
									DURUM			= :DURUM,
									PRIM_ORAN		= :PRIM_ORAN
							WHERE ID = :ID
							";
		$filtre[":GOREV"] 		= trim($_REQUEST["gorev"]);	
		$filtre[":DURUM"] 		= $_REQUEST["durum"];
		$filtre[":PRIM_ORAN"]	= $_REQUEST["prim_oran"];
		$filtre[":ID"] 			= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function odeme_kanali_detay_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM ODEME_KANALI_DETAY WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["ROW"]		= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function odeme_kanali_detay_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO ODEME_KANALI_DETAY SET	ODEME_KANALI_ID		= :ODEME_KANALI_ID,
													ODEME_KANALI_DETAY 	= :ODEME_KANALI_DETAY,
													SIRA				= :SIRA,
													`LIMIT`				= :LIMIT,
													DURUM				= :DURUM													
													";
		$filtre[":ODEME_KANALI_ID"] 	= $_REQUEST["odeme_kanali_id"];	
		$filtre[":ODEME_KANALI_DETAY"] 	= trim($_REQUEST["odeme_kanali_detay"]);	
		$filtre[":SIRA"] 				= trim($_REQUEST["sira"]);	
		$filtre[":LIMIT"] 				= FormatSayi::sayi2db($_REQUEST["limit"]);	
		$filtre[":DURUM"] 				= $_REQUEST["durum"];		
		$okd_id = $this->cdbPDO->lastInsertId($sql, $filtre); 
			
		if($okd_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function odeme_kanali_detay_kaydet(){
		
		$filtre	= array();
		$sql = "UPDATE ODEME_KANALI_DETAY SET 	ODEME_KANALI_DETAY	= :ODEME_KANALI_DETAY,
												SIRA				= :SIRA,
												`LIMIT`				= :LIMIT,
												DURUM				= :DURUM
										WHERE ID = :ID
										";
		$filtre[":ODEME_KANALI_DETAY"] 	= trim($_REQUEST["odeme_kanali_detay"]);	
		$filtre[":SIRA"] 				= trim($_REQUEST["sira"]);	
		$filtre[":LIMIT"] 				= FormatSayi::sayi2db($_REQUEST["limit"]);	
		$filtre[":DURUM"] 				= $_REQUEST["durum"];		
		$filtre[":ID"] 					= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	function cari_doldur() {
		$filtre	= array();
		$sql = "SELECT
					C.ID,
					C.CARI AS AD
				FROM CARI AS C
				WHERE C.DURUM = 1
                ORDER BY 2
				";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$html = "";
		$html.= "<option value='-1' >-- Seçiniz --</option>";
		foreach($rows as $key=>$row) {
	        $html .= "<option value=".$row->ID." >".$row->AD."</option>";
        }
        
        if(count($rows)>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["HTML"] 		= $html;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
        return $sonuc;
        
	}
	
	
	function odeme_kanali_detay_doldur() {
		$filtre	= array();
		$sql = "SELECT
					OKD.ID,
					OKD.ODEME_KANALI_DETAY AS AD
				FROM ODEME_KANALI_DETAY AS OKD
				WHERE OKD.ODEME_KANALI_ID = :ODEME_KANALI_ID
                ORDER BY 2
				";
		$filtre[":ODEME_KANALI_ID"]	= $_REQUEST['odeme_kanali_id'];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$html = "";
		
		if(count($rows) > 1){
			$html.= "<option value='-1' >-- Seçiniz --</option>";	
		}
		if(count($rows) == 0){
			$html.= "<option value='-1' >-- Seçiniz --</option>";	
		}
		foreach($rows as $key=>$row) {
	        $html .= "<option value=".$row->ID." >".$row->AD."</option>";
        }
        
        if(TRUE){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["HTML"] 		= $html;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
        return $sonuc;
        
	}
	
	function odeme_kanali_detay_doldur2() {
		
		$html = "";
		$html.= "<option value='-1' >-- Seçiniz --</option>";
		
		if($_REQUEST['odeme_kanali_id'] == 4){ //Çek
			$filtre	= array();
			$sql = "SELECT 
						CH.ID, 
						C.CARI, 
						CH.SENET_NO,
						CH.TUTAR 
					FROM CARI_HAREKET AS CH 
						LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					WHERE CH.HAREKET_ID = 3 AND CH.ODEME_KANALI_ID = 4 AND CH.SENET_DURUM = 0
					";
			$rows = $this->cdbPDO->rows($sql, $filtre);
			foreach($rows as $key => $row){
				$rows[$key]->AD = $row->CARI ." - ". $row->SENET_NO ." - ". FormatSayi::sayi($row->TUTAR);
			}
			
			
		} else if($_REQUEST['odeme_kanali_id'] == 5){ //Senet
			$filtre	= array();
			$sql = "SELECT 
						CH.ID, 
						C.CARI, 
						CH.SENET_NO,
						CH.TUTAR 
					FROM CARI_HAREKET AS CH 
						LEFT JOIN CARI AS C ON C.ID = CH.CARI_ID
					WHERE CH.HAREKET_ID = 3 AND CH.ODEME_KANALI_ID = 5 AND CH.SENET_DURUM = 0
					";
			$rows = $this->cdbPDO->rows($sql, $filtre);
			foreach($rows as $key => $row){
				$rows[$key]->AD = $row->CARI ." - ". $row->SENET_NO ." - ". FormatSayi::sayi($row->TUTAR);
			}
			
		} else { //Diğer
			$filtre	= array();
			$sql = "SELECT
						OKD.ID,
						OKD.ODEME_KANALI_DETAY AS AD
					FROM ODEME_KANALI_DETAY AS OKD
					WHERE OKD.ODEME_KANALI_ID = :ODEME_KANALI_ID
	                ORDER BY 2
					";
			$filtre[":ODEME_KANALI_ID"]	= $_REQUEST['odeme_kanali_id'];
			$rows = $this->cdbPDO->rows($sql, $filtre);
		}
        
        foreach($rows as $key=>$row) {
		    $html .= "<option value=".$row->ID." >".$row->AD."</option>";
	    }
	        
        if( TRUE){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["HTML"] 		= $html;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
        return $sonuc;
        
	}
	
	function senet_doldur() {
		
		
		$filtre	= array();
		$sql = "SELECT 
					CH.ID,
					CH.SENET_NO,
					CH.SENET_VADE_TARIH,
					CH.SENET_TARIH,
					CH.SENET_SAHIBI,
					CH.SENET_BORCLU,
					CH.SENET_HESAP_NO,
					CH.FATURA_TARIH,
					CH.TUTAR
				FROM CARI_HAREKET AS CH 
				WHERE CH.ID = :ID
				";
		$filtre[":ID"] 		= $_REQUEST["cari_hareket_id"];
		$row = $this->cdbPDO->row($sql, $filtre);
	        
        if($row->ID > 0){
			$sonuc["HATA"] 				= FALSE;
			$sonuc["ACIKLAMA"] 			= "Kaydedildi.";
			$sonuc["SENET_NO"] 			= $row->SENET_NO;
			$sonuc["SENET_VADE_TARIH"] 	= FormatTarih::tarih($row->SENET_VADE_TARIH);
			$sonuc["SENET_TARIH"] 		= FormatTarih::tarih($row->SENET_TARIH);
			$sonuc["SENET_SAHIBI"] 		= $row->SENET_SAHIBI;
			$sonuc["SENET_BORCLU"] 		= $row->SENET_BORCLU;
			$sonuc["SENET_HESAP_NO"] 	= $row->SENET_HESAP_NO;
			$sonuc["FATURA_TARIH"] 		= FormatTarih::tarih($row->FATURA_TARIH);
			$sonuc["TUTAR"] 			= FormatSayi::sayi($row->TUTAR);
			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
        return $sonuc;
        
	}
	
	function il_doldur() {
		$filtre	= array();
		$sql = "SELECT
					I.ID,
					I.IL AS AD
				FROM IL AS I
				WHERE I.ULKE_ID = :ULKE_ID
                ORDER BY 2
				";
		$filtre[":ULKE_ID"] 		= $_REQUEST["ulke_id"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$html = "";
		$html.= "<option value='-1' >-- Seçiniz --</option>";
		foreach($rows as $key=>$row) {
	        $html .= "<option value=".$row->ID." >".$row->AD."</option>";
        }
        
        if(count($rows)>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "İller dolduruldu.";
			$sonuc["HTML"] 		= $html;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İl Bulunamadı!";
		}
		
        return $sonuc;
        
	}
	
	function ilce_doldur() {
		$filtre	= array();
		$sql = "SELECT
					I.ID,
					I.ILCE AS AD
				FROM ILCE AS I
				WHERE I.IL_ID = :IL_ID
                ORDER BY 2
				";
		$filtre[":IL_ID"] 		= $_REQUEST["il_id"];
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$html = "";
		$html.= "<option value='-1' >-- Seçiniz --</option>";
		foreach($rows as $key=>$row) {
	        $html .= "<option value=".$row->ID." >".$row->AD."</option>";
        }
        
        if(count($rows)>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["HTML"] 		= $html;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İlçe bulunamadı!";
		}
		
        return $sonuc;
        
	}
	
	function model_doldur() {
		$filtre	= array();
		$sql = "SELECT
					ID,
					M.MODEL AS AD
				FROM MODEL AS M
				WHERE M.MARKA_ID = :MARKA_ID
                ORDER BY 2
				";
		$filtre[":MARKA_ID"] 		= $_REQUEST["marka_id"];
		
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$html = "";
		foreach($rows as $key=>$row) {
	        $html .= "<option value=".$row->ID." >".$row->AD."</option>";
        }
        
        if(count($rows)>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["HTML"] 		= $html;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
        return $sonuc;
        
	}
	
	
	
	function il_servis_doldur() {
		
		$filtre	= array();
		$sql = "SELECT
        			K.ID,
        			K.UNVAN AS AD
				FROM KULLANICI AS K
				WHERE K.IL_ID = :IL_ID 			
				";
				
		$filtre[":IL_ID"] 		= $_REQUEST['il_id'];
		if($_REQUEST['bakim_hizmeti'] == 1){
			$sql.=" AND K.YETKI_ID = 11 AND K.BAKIM_HIZMETI = 1";
			
			$row_fiyat= $this->cdbPDO->row("SELECT SERVIS_ZINCIR_ID FROM BAKIM_PAKET_FIYAT WHERE ID = :ID", array(":ID"=>$_REQUEST["bakim_fiyat_id"])); 
			
			$sql.=" AND K.SERVIS_ZINCIR_ID = :SERVIS_ZINCIR_ID";
			$filtre[":SERVIS_ZINCIR_ID"] 	= $row_fiyat->SERVIS_ZINCIR_ID;
		}
		
		if($_REQUEST['servis'] == 1){
			$sql.=" AND K.YETKI_ID = 11";
		}
		
		$sql.=" ORDER BY 2";
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$html = "";
		$html.= "<option value='-1' >-- Seçiniz --</option>";
		foreach($rows as $key=>$row) {
	        $html .= "<option value=".$row->ID." >". $row->AD ."</option>";
        }
        
        if(count($rows) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["HTML"] 		= $html;
		} else if($_REQUEST['il_id'] == -1){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Seçiniz";
			$sonuc["HTML"] 		= $html;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Servis Bulunamadı!";
		}
		
        return $sonuc;
        
	}
	
	function servis_bilgisi() {
		
		$filtre	= array();
		$sql = "SELECT
        			K.ID,
        			K.IL_ID,
        			K.ILCE_ID,
        			K.ADRES
				FROM KULLANICI AS K
				WHERE K.ID = :ID 			
				";
		$filtre[":ID"] 		= $_REQUEST['id'];		
		$row_servis = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT
					I.ID,
					I.ILCE AS AD
				FROM ILCE AS I
				WHERE I.IL_ID = :IL_ID
                ORDER BY 2
				";
		$filtre[":IL_ID"] 		= $row_servis->IL_ID;
		$rows = $this->cdbPDO->rows($sql, $filtre);
		
		$html = "";
		$html.= "<option value='-1' >-- Seçiniz --</option>";
		foreach($rows as $key=>$row) {
	        $html .= "<option value=".$row->ID." >".$row->AD."</option>";
        }
        
        if($row_servis->ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["ADRES"] 	= $row_servis->ADRES;
			$sonuc["IL_ID"] 	= $row_servis->IL_ID;
			$sonuc["ILCE_ID"] 	= $row_servis->ILCE_ID;
			$sonuc["ILCE"] 		= $html;
		} else if($row_servis->IL_ID <= 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Seçiniz";
			$sonuc["ADRES"] 	= $row_servis->ADRES;
			$sonuc["IL_ID"] 	= $row_servis->IL_ID;
			$sonuc["ILCE_ID"] 	= $row_servis->ILCE_ID;
			$sonuc["ILCE"] 		= $html;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Servis Bulunamadı!";
		}
		
        return $sonuc;
        
	}
	
	public function mesaj_sil(){
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek mesaj seçilmemiş!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM MESAJ WHERE ID = :ID";
		$filtre[':ID']			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if($row->KIME_ID == $_SESSION['kullanici_id']){
			$filtre	= array();
			$sql = "UPDATE MESAJ SET ALICI_DURUM = 0, ALICI_SILME_TARIH = NOW() WHERE ID = :ID";
			$filtre[':ID']			= $_REQUEST['id'];
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		}else{
			$filtre	= array();
			$sql = "UPDATE MESAJ SET GONDEREN_DURUM = 0, GONDEREN_SILME_TARIH = NOW() WHERE ID = :ID";
			$filtre[':ID']			= $_REQUEST['id'];
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		}
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Mesaj silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function mesajlari_sil(){
		
		if(count($_REQUEST['id']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek mesaj seçilmemiş!";
			return $sonuc;
		}
		
		foreach($_REQUEST['id'] as $key => $id){
			$filtre	= array();
			$sql = "SELECT * FROM MESAJ WHERE ID = :ID";
			$filtre[':ID']			= $id;
			$row = $this->cdbPDO->row($sql, $filtre);
			
			if($row->KIME_ID == $_SESSION['kullanici_id']){
				$filtre	= array();
				$sql = "UPDATE MESAJ SET ALICI_DURUM = 0, ALICI_SILME_TARIH = NOW() WHERE ID = :ID";
				$filtre[':ID']			= $id;
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			}else{
				$filtre	= array();
				$sql = "UPDATE MESAJ SET GONDEREN_DURUM = 0, GONDEREN_SILME_TARIH = NOW() WHERE ID = :ID";
				$filtre[':ID']			= $id;
				$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			}
		}		
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Mesaj(lar) Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function kullanici_resim_yukle(){
		$say = 0;
		
		$YOL 			= $this->cSabit->imgPathFolder("kullanici");
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		
		foreach($_FILES['kullanici_resim']['name'] as $key => $resim){
			$DOSYA_TAM_AD	= $_FILES['kullanici_resim']['name'][$key];
			$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
		    $DOSYA_AD 		= $DOSYA[0]; 
		    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]); 
		    
		    list($usec, $sec)= explode(' ',microtime());  
	  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
	  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
		   
		    copy($_FILES['kullanici_resim']['tmp_name'][$key], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
			chmod($YOL . $TIMESTAMP, 0755);
			unlink($_FILES['kullanici_resim']['tmp_name'][$key]); 
			
			if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
				// kapak resminin yüklenmesi
				$filtre	= array();
				$sql = "INSERT INTO KULLANICI_RESIM SET KULLANICI_ID 	= :KULLANICI_ID,
														RESIM_ADI		= :RESIM_ADI,
														RESIM_ADI_ILK	= :RESIM_ADI_ILK,
														DURUM			= 0,
														TARIH			= NOW()
														";
				$filtre[':KULLANICI_ID']	= $_REQUEST['id'];
				$filtre[':RESIM_ADI']		= $TIMESTAMP . "." . $DOSYA_UZANTI;
				$filtre[':RESIM_ADI_ILK']	= $DOSYA_TAM_AD;				
				
				$kullanici_id = $this->cdbPDO->lastInsertId($sql, $filtre);
				
				if($kullanici_id > 0){
					$say++;	
				}
			}
		}
			
		if($say>0){
			$sonuc["KULLANICI_ID"] 	= $_REQUEST['id'];
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.".$say;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Resim bulunamadı yada yüklenemedi!";
		}
		
		return $sonuc;	
	}
	
	public function sifre_sms_gonder(){
		
		$filtre	= array();
		$sql = "SELECT ID, CEPTEL, KULLANICI, SIFRE, CONCAT_WS(' ', AD, SOYAD) AS ADSOYAD FROM KULLANICI WHERE ID = :ID AND KOD = :KOD";
		$filtre[":ID"]	= $_REQUEST["id"];
		$filtre[":KOD"]	= $_REQUEST["kod"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı bulunamadı!";
			return $sonuc;
		}
		
		if(strlen($row->CEPTEL) != 14){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı CEPTEL hatalı!";
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT
					SK.ID,
					SK.SMS_KALIBI
				FROM SMS_KALIBI AS SK
				WHERE SK.ID = :ID
				";
		$filtre[":ID"] 	= 5;
		$row_sms_kalibi = $this->cdbPDO->row($sql, $filtre);
		
		$row_sms_kalibi->SMS_KALIBI = str_replace('{ADSOYAD}', $row->ADSOYAD, $row_sms_kalibi->SMS_KALIBI);
		$row_sms_kalibi->SMS_KALIBI = str_replace('{KULLANICI}', $row->KULLANICI, $row_sms_kalibi->SMS_KALIBI);
		$row_sms_kalibi->SMS_KALIBI = str_replace('{SIFRE}', $row->SIFRE, $row_sms_kalibi->SMS_KALIBI);
		
		$result = $this->cSms->soapGonder(FormatTel::smsTemizle($row->CEPTEL), "BORYAZ", $row_sms_kalibi->SMS_KALIBI);
			
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "KULLANICI", "cKayit");
		
		if($row->ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "SMS gönderildi.";
			$sonuc["ID"]		= $row_ihale->ID;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function sifre_mail_gonder(){
		
		$filtre	= array();
		$sql = "SELECT ID, CEPTEL, KULLANICI, SIFRE, CONCAT_WS(' ', AD, SOYAD) AS ADSOYAD, MAIL FROM KULLANICI WHERE ID = :ID AND KOD = :KOD";
		$filtre[":ID"]	= $_REQUEST["id"];
		$filtre[":KOD"]	= $_REQUEST["kod"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı bulunamadı!";
			return $sonuc;
		}
		
		if(strlen($row->CEPTEL) != 14){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı CEPTEL hatalı!";
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT
					SK.ID,
					SK.SMS_KALIBI
				FROM SMS_KALIBI AS SK
				WHERE SK.ID = :ID
				";
		$filtre[":ID"] 	= 5;
		$row_sms_kalibi = $this->cdbPDO->row($sql, $filtre);
		
		$row_sms_kalibi->SMS_KALIBI = str_replace('{ADSOYAD}', $row->ADSOYAD, $row_sms_kalibi->SMS_KALIBI);
		$row_sms_kalibi->SMS_KALIBI = str_replace('{KULLANICI}', $row->KULLANICI, $row_sms_kalibi->SMS_KALIBI);
		$row_sms_kalibi->SMS_KALIBI = str_replace('{SIFRE}', $row->SIFRE, $row_sms_kalibi->SMS_KALIBI);
		$row_sms_kalibi->SMS_KALIBI = str_replace('\n', "<br>", $row_sms_kalibi->SMS_KALIBI);
		
		$this->cMail->Gonder($row->MAIL, "Şifre Bilgisi", $row_sms_kalibi->SMS_KALIBI);	
		
		if($row->ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Mail gönderildi.";
			$sonuc["ID"]		= $row_ihale->ID;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function favori(){
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İhale bulunamdı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM IHALE WHERE ID = :ID";
		$filtre[":ID"]	= $_REQUEST["id"];
		$row_ihale = $this->cdbPDO->row($sql, $filtre);
		
		if($row_ihale->SUREC_ID != 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İhale aktif olmadığı için favorilere eklenemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM IHALE_FAVORI WHERE IHALE_ID = :IHALE_ID AND KULLANICI_ID = :KULLANICI_ID";
		$filtre[":IHALE_ID"] 		= $_REQUEST['id'];
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$row_favori = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row_favori->IHALE_ID)){
			$filtre	= array();
			$sql = "INSERT INTO IHALE_FAVORI SET 	IHALE_ID			= :IHALE_ID,
													KULLANICI_ID		= :KULLANICI_ID,
											 		TARIH				= NOW()
											 		";
			$filtre[":IHALE_ID"] 		= $_REQUEST['id'];
			$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			$TITLE = "Favoriden Çıkar";
			
		} else {
			$filtre	= array();
			$sql = "DELETE FROM IHALE_FAVORI WHERE IHALE_ID = :IHALE_ID AND KULLANICI_ID = :KULLANICI_ID";
			$filtre[":IHALE_ID"] 		= $_REQUEST['id'];
			$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			$TITLE = "Favorime Ekle";
			
		}
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Favori.";
			$sonuc["ID"]		= $row_ihale->ID;
			$sonuc["TITLE"]		= $TITLE;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function hesabim_tema_secimi(){
		
		$filtre	= array();
		$sql = "UPDATE KULLANICI SET TEMA_ID = :TEMA_ID WHERE ID = :ID";
		$filtre[":TEMA_ID"] 	= $_REQUEST['tema_id'];
		$filtre[":ID"] 			= $_SESSION['kullanici_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Yapıldı.";
		}else{
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function ihale_incelendi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM IHALE_INCELE WHERE IHALE_ID = :IHALE_ID AND INCELEYEN_ID = :INCELEYEN_ID";
		$filtre[":IHALE_ID"] 		= $_REQUEST["id"];
		$filtre[":INCELEYEN_ID"] 	= $_SESSION['kullanici_id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$filtre	= array();
			$sql = "INSERT INTO IHALE_INCELE SET IHALE_ID = :IHALE_ID, INCELEYEN_ID = :INCELEYEN_ID, SON_GIRIS_TARIH = NOW()";
			$filtre[":IHALE_ID"] 			= $_REQUEST['id'];
			$filtre[":INCELEYEN_ID"] 		= $_SESSION['kullanici_id'];
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		} else {
			$filtre	= array();
			$sql = "UPDATE IHALE_INCELE SET SON_GIRIS_TARIH = NOW(), SAY = SAY + 1 WHERE ID = :ID";
			$filtre[":ID"] 				= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		}
		
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function mesaj_okundu(){
		
		if($_REQUEST['id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Mesaj bulunamdı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM MESAJ WHERE ID = :ID";
		$filtre[":ID"]	= $_REQUEST["id"];
		$row_mesaj = $this->cdbPDO->row($sql, $filtre);
		
		if($row_mesaj->KIME_ID != $_SESSION['kullanici_id']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Mesaj sahibi siz değilsiniz!";
			return $sonuc;
		}
		
		if($row_mesaj->OKUNDU == "0"){
			$filtre	= array();
			$sql = "UPDATE MESAJ SET OKUNDU = 1, OKUNDU_TARIH = NOW() WHERE ID = :ID AND KIME_ID = :KIME_ID";
			$filtre[":ID"] 			= $_REQUEST['id'];
			$filtre[":KIME_ID"] 	= $_SESSION['kullanici_id'];
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		}
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Mesaj okundu.";
		}else{
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function duyuru_goruldu(){
		
		$filtre	= array();
		$sql = "UPDATE DUYURU SET GORENLER = CONCAT_WS(',',GORENLER, :KULLANICI_ID) WHERE ID = :ID";
		$filtre[":ID"] 				= $_REQUEST['id'];
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Duyuru goruldu.";
		}else{
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function talep_notu_sil(){
		
		if(!in_array($_SESSION['yetki_id'], array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yöneticiden başka kimse silemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID FROM TALEP_NOTU WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["talep_notu_id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep Notu bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM TALEP_NOTU WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['talep_notu_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	
	public function talep_notu_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(strlen($_REQUEST['talep_notu']) <= 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep notu boş bırakılamaz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO TALEP_NOTU SET 	TALEP_ID		= :TALEP_ID,
											TALEP_NOTU		= :TALEP_NOTU,
											KULLANICI_ID	= :KULLANICI_ID
										 	";
		$filtre[":TALEP_ID"] 		= $_REQUEST['id'];
		$filtre[":TALEP_NOTU"] 		= trim($_REQUEST['talep_notu']);
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function cari_notu_sil(){
		
		if(!in_array($_SESSION['yetki_id'], array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yöneticiden başka kimse silemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID FROM CARI_NOTU WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["cari_notu_id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Notu bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM CARI_NOTU WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['cari_notu_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	
	public function cari_notu_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(strlen($_REQUEST['cari_notu']) <= 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari notu boş bırakılamaz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_NOTU SET 	CARI_ID			= :CARI_ID,
											CARI_NOTU		= :CARI_NOTU,
											KULLANICI_ID	= :KULLANICI_ID
										 	";
		$filtre[":CARI_ID"] 		= $_REQUEST['id'];
		$filtre[":CARI_NOTU"] 		= trim($_REQUEST['cari_notu']);
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_satis_fatura_kaydet(){
		
		if($_REQUEST['cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari seçilmemiş!";
			return $sonuc;
		}
		
		if($_REQUEST['finans_kalemi_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Finans kalem seçiniz!";
			return $sonuc;
		}
		/*
		if(strlen($_REQUEST['fatura_no']) <= 0 AND $_REQUEST['fatura_kes'] == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura No giriniz!";
			return $sonuc;
		}
		*/
		if(str_replace('-','',trim($_REQUEST['fatura_tarih'])) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Tarih giriniz!";
			return $sonuc;
		}
		
		foreach($_REQUEST["yp_parca_kodu"] as $key => $parca_kodu){
			if(strlen(trim($parca_kodu)) <= 0 AND strlen(trim($_REQUEST["yp_parca_adi"][$key])) <= 0) continue;
			$KALEM_SAYISI++;
			$KALEM_FIYAT += FormatSayi::sayi2db($_REQUEST["yp_fiyat"][$key]);
			$KALEM_TUTAR += $_REQUEST["yp_adet"][$key] * FormatSayi::sayi2db($_REQUEST["yp_fiyat"][$key]) * ((100 - FormatSayi::sayi2db($_REQUEST["yp_iskonto"][$key])) / 100) * (1 + ($_REQUEST["yp_kdv"][$key] / 100));		
		}
		
		if($KALEM_SAYISI <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kalem sayısı '0' dan büyük olmalı!";
			return $sonuc;
		}
		
		if($KALEM_FIYAT <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura tutarı '0' TL olamaz!";
			return $sonuc;
		}
		/*
		$filtre	= array();
		$sql = "SELECT
					CH.ID,
					CH.FATURA_NO
				FROM CARI_HAREKET AS CH
				WHERE CH.HAREKET_ID = 1 AND CH.FATURA_NO = :FATURA_NO AND CH.ID != :ID 
				";
		$filtre[":FATURA_NO"] 	= trim($_REQUEST["fatura_no"]);
		$filtre[":ID"] 			= $_REQUEST["id"];
		$row_ayni = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_ayni->ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "{$row_ayni->FATURA_NO} fatura daha önce girilmiş!!!";	
			return $sonuc;
		}
		*/
		
		$filtre	= array();
		$sql = "SELECT ID,ORAN FROM TEVKIFAT WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST['tevkifat_id'];
		$row_tevkifat = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_tevkifat->ID > 0){
			$KDV_CARPAN = $row_tevkifat->ORAN;
			$KDV_ORAN	= ($row_tevkifat->ORAN - 1) * 100;
		} else {
			$KDV_CARPAN = 1.18;
		}
		
		$filtre	= array();
		$sql = "SELECT
					CH.ID,
					CH.FATURA_NO
				FROM CARI_HAREKET AS CH
				WHERE CH.HAREKET_ID = 1 AND CH.CARI_ID = :CARI_ID AND CH.FATURA_NO = :FATURA_NO AND TUTAR = :TUTAR AND CH.ID != :ID 
				";
		$filtre[":CARI_ID"] 	= $_REQUEST["cari_id"];
		$filtre[":FATURA_NO"] 	= trim($_REQUEST["fatura_no"]);
		$filtre[":TUTAR"] 		= $KALEM_TUTAR;
		$filtre[":ID"] 			= $_REQUEST["id"];
		$row_ayni = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_ayni->ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cariye, Fatura No ile aynı tutar daha önce girilmiş!!!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, VADE FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["cari_id"];
		$row_cari = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, TALEP_ID FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 1,
													FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
													ODEME_KANALI_ID			= :ODEME_KANALI_ID,
													ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
													FATURA_NO				= :FATURA_NO,
													FATURA_TARIH			= :FATURA_TARIH,
													VADE_TARIH				= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
													CARI_ID					= :CARI_ID,
													PLAKA					= :PLAKA,
													ACIKLAMA				= :ACIKLAMA,
													KALEM_SAYISI			= :KALEM_SAYISI,
													FATURA_KES				= :FATURA_KES,
													FATURA_DURUM_ID			= :FATURA_DURUM_ID,
													KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
													TARIH					= NOW(),
													KOD						= MD5(NOW())
													";
			$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
			$filtre[":ODEME_KANALI_ID"] 		= $_REQUEST['odeme_kanali_id'];
			$filtre[":ODEME_KANALI_DETAY_ID"] 	= $_REQUEST['odeme_kanali_detay_id'];
			$filtre[":FATURA_NO"] 				= trim($_REQUEST["fatura_no"]);
			$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
			$filtre[":VADE"] 					= $row_cari->VADE;
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":KALEM_SAYISI"] 			= $KALEM_SAYISI;
			$filtre[":FATURA_KES"] 				= $_REQUEST['fatura_kes'];
			$filtre[":FATURA_DURUM_ID"] 		= $_REQUEST['fatura_durum_id'];
			$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
			$cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
			if($_REQUEST["fatura_kes"] == '2'){
				$filtre	= array();
				$sql = "UPDATE CARI_HAREKET SET FATURA_NO = :FATURA_NO WHERE ID = :ID";
				$filtre[":FATURA_NO"] 	= "IRS". str_pad($cari_hareket_id, 13, "0", STR_PAD_LEFT);
				$filtre[":ID"] 			= $cari_hareket_id;
				$this->cdbPDO->rowsCount($sql, $filtre);	
			}
			
			$filtre	= array();
			$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
			$filtre[":ID"] 	= $cari_hareket_id;
			$row = $this->cdbPDO->row($sql, $filtre); 
			
		} else {
			
			if(is_null($row->ID)){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Cari Hareket bulunamadı!";	
				return $sonuc;
			}
			
			if($row->KOD != $_REQUEST['kod']){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
											ODEME_KANALI_ID			= :ODEME_KANALI_ID,
											ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
											FATURA_NO				= :FATURA_NO,
											FATURA_TARIH			= :FATURA_TARIH,
											VADE_TARIH				= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
											CARI_ID					= :CARI_ID,
											PLAKA					= :PLAKA,
											ACIKLAMA				= :ACIKLAMA,
											KALEM_SAYISI			= :KALEM_SAYISI,
											FATURA_KES				= :FATURA_KES,
											FATURA_DURUM_ID			= :FATURA_DURUM_ID
									WHERE ID = :ID
									";
			$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
			$filtre[":ODEME_KANALI_ID"] 		= $_REQUEST['odeme_kanali_id'];
			$filtre[":ODEME_KANALI_DETAY_ID"] 	= $_REQUEST['odeme_kanali_detay_id'];
			$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
			$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
			$filtre[":VADE"] 					= $row_cari->VADE;
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":KALEM_SAYISI"] 			= $KALEM_SAYISI;
			$filtre[":FATURA_KES"] 				= $_REQUEST['fatura_kes'];
			$filtre[":FATURA_DURUM_ID"] 		= $_REQUEST['fatura_durum_id'];
			$filtre[":ID"] 						= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		}
		
		$filtre	= array();
		$sql = "SELECT (1 + (KDV / 100)) AS KDV_CARPAN, KDV FROM FINANS_KALEMI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["finans_kalemi_id"];
		$row_finans_kalemi = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID";
		$filtre[":CARI_HAREKET_ID"] 	= $row->ID;
		$rows_chd2 = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows_chd2 as $key => $row_chd2){
			$rows_chd[$row_chd2->SIRA]	= $row_chd2;
		}
		
		$sira = 0;
		foreach($_REQUEST["yp_parca_kodu"] as $key => $parca_kodu){
			if(strlen(trim($parca_kodu)) <= 0 AND strlen(trim($_REQUEST["yp_parca_adi"][$key])) <= 0) continue;
			$sira++;
			
			if(is_null($rows_chd[$sira]->ID)){
				$filtre	= array();
				$sql = "INSERT INTO CARI_HAREKET_DETAY SET CARI_HAREKET_ID = :CARI_HAREKET_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, ALIS = :ALIS, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, KDV = :KDV, GTARIH = NOW()";
				$filtre[":CARI_HAREKET_ID"] = $row->ID;
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PARCA_KODU"] 		= trim($_REQUEST["yp_parca_kodu"][$key]);
				$filtre[":OEM_KODU"] 		= trim($_REQUEST["yp_oem_kodu"][$key]);
				$filtre[":PARCA_ADI"] 		= trim($_REQUEST["yp_parca_adi"][$key]);
				$filtre[":ADET"] 			= FormatSayi::sayi2db($_REQUEST["yp_adet"][$key]);
				$filtre[":ALIS"] 			= FormatSayi::sayi2db($_REQUEST["yp_alis"][$key]);
				$filtre[":FIYAT"] 			= FormatSayi::sayi2db($_REQUEST["yp_fiyat"][$key]);
				$filtre[":ISKONTO"] 		= FormatSayi::sayi2db($_REQUEST["yp_iskonto"][$key]);
				$filtre[":ISKONTOLU"] 		= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) ;
				$filtre[":TUTAR"] 			= $filtre[":ADET"] * $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) * (1 + ($row_tevkifat->ID > 0 ? ($KDV_CARPAN-1) : ($_REQUEST["yp_kdv"][$key] / 100)));
				$filtre[":KDV"] 			= $_REQUEST["yp_kdv"][$key];
				$chd_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
				
			} else if($rows_chd[$sira]->ID > 0){
				
				$filtre	= array();
				$sql = "UPDATE CARI_HAREKET_DETAY SET SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, OEM_KODU = :OEM_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, ALIS = :ALIS, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, GTARIH = NOW(), KDV = :KDV WHERE ID = :ID";
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PARCA_KODU"] 		= trim($_REQUEST["yp_parca_kodu"][$key]);
				$filtre[":OEM_KODU"] 		= trim($_REQUEST["yp_oem_kodu"][$key]);
				$filtre[":PARCA_ADI"] 		= trim($_REQUEST["yp_parca_adi"][$key]);
				$filtre[":ADET"] 			= FormatSayi::sayi2db($_REQUEST["yp_adet"][$key]);
				$filtre[":ALIS"] 			= FormatSayi::sayi2db($_REQUEST["yp_alis"][$key]);
				$filtre[":FIYAT"] 			= FormatSayi::sayi2db($_REQUEST["yp_fiyat"][$key]);
				$filtre[":ISKONTO"] 		= FormatSayi::sayi2db($_REQUEST["yp_iskonto"][$key]);
				$filtre[":ISKONTOLU"] 		= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) ;
				$filtre[":TUTAR"] 			= $filtre[":ADET"] * $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) * (1 + ($row_tevkifat->ID > 0 ? ($KDV_CARPAN-1) : ($_REQUEST["yp_kdv"][$key] / 100)));
				$filtre[":KDV"] 			= $_REQUEST["yp_kdv"][$key];
				$filtre[":ID"] 				= $rows_chd[$sira]->ID;
				$this->cdbPDO->rowsCount($sql, $filtre);
				$chd_id	= $rows_chd[$sira]->ID;
			}
			
			$chd_ids[] = $chd_id;
			
		}
		
		$filtre	= array();
		$sql = "DELETE FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID AND !FIND_IN_SET(ID, :IDS)";
		$filtre[":CARI_HAREKET_ID"] = $row->ID;
		$filtre[":IDS"] 			= implode(',', $chd_ids);
		$this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET TUTAR 		= IF(FINANS_KALEMI_ID = 14, 0, (SELECT SUM(TUTAR) AS TUTAR FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :ID)),
										KDV_TUTAR 	= IF(FINANS_KALEMI_ID IN(11,14) OR FATURA_KES = 2, 0, (SELECT SUM(TUTAR / (100 + KDV) * KDV) AS TUTAR FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :ID))
									WHERE ID = :ID
									";
		$filtre[":ID"] 				= $row->ID;
		$this->cdbPDO->rowsCount($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE SITE SET FATURA_NO = :FATURA_NO WHERE SUBSTR(FATURA_NO, 4, 13) < SUBSTR(:FATURA_NO, 4, 13) LIMIT 1";
		$filtre[":FATURA_NO"] 		= trim($_REQUEST['fatura_no']);
		$this->cdbPDO->rowsCount($sql, $filtre); 
			
		if(true){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
			$sonuc["URL"] 		= "/finans/satis_fatura.do?route=finans/satis_faturalar&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_alis_fatura_kaydet(){
		
		if($_REQUEST['cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari seçilmemiş!";
			return $sonuc;
		}
		
		if($_REQUEST['finans_kalemi_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Finans kalem seçiniz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['fatura_no']) <= 0 AND $_REQUEST['fatura_kes'] == 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura No giriniz!";
			return $sonuc;
		}
		
		if(str_replace('-','',trim($_REQUEST['fatura_tarih'])) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Tarih giriniz!";
			return $sonuc;
		}
		
		foreach($_REQUEST["yp_parca_kodu"] as $key => $parca_kodu){
			if(strlen(trim($parca_kodu)) <= 0 AND strlen(trim($_REQUEST["yp_parca_adi"][$key])) <= 0) continue;
			$KALEM_SAYISI++;
			$KALEM_FIYAT += FormatSayi::sayi2db($_REQUEST["yp_fiyat"][$key]);		
		}
		
		if($KALEM_SAYISI <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kalem sayısı '0' dan büyük olmalı!";
			return $sonuc;
		}
		
		if($KALEM_FIYAT <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura tutarı '0' TL olamaz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT
					CH.ID,
					CH.FATURA_NO
				FROM CARI_HAREKET AS CH
				WHERE CH.HAREKET_ID = 2 AND CH.FATURA_TARIH = :FATURA_TARIH AND CH.FATURA_NO = :FATURA_NO AND CH.ID != :ID 
				";
		$filtre[":FATURA_TARIH"] 	= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
		$filtre[":FATURA_NO"] 		= trim($_REQUEST["fatura_no"]);
		$filtre[":ID"] 				= $_REQUEST["id"];
		$row_ayni = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_ayni->ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "{$row_ayni->FATURA_NO} fatura daha önce girilmiş!!!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT
					CH.ID,
					CH.FATURA_NO
				FROM CARI_HAREKET AS CH
				WHERE CH.HAREKET_ID = 2 AND CH.CARI_ID = :CARI_ID AND CH.FATURA_NO = :FATURA_NO AND CH.ID != :ID 
				";
		$filtre[":CARI_ID"] 	= $_REQUEST["cari_id"];
		$filtre[":FATURA_NO"] 	= trim($_REQUEST["fatura_no"]);
		$filtre[":ID"] 			= $_REQUEST["id"];
		$row_ayni = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_ayni->ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cariye, Fatura No ile aynı tutar daha önce girilmiş!!!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, VADE FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["cari_id"];
		$row_cari = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, TALEP_ID, FATURA_NO FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 2,
													FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
													FATURA_NO				= :FATURA_NO,
													FATURA_TARIH			= :FATURA_TARIH,
													VADE_TARIH				= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
													CARI_ID					= :CARI_ID,
													ARAC_ID					= :ARAC_ID,
													PLAKA					= :PLAKA,
													ACIKLAMA				= :ACIKLAMA,
													KALEM_SAYISI			= :KALEM_SAYISI,
													FATURA_KES				= :FATURA_KES,
													KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
													TARIH					= NOW(),
													KOD						= MD5(NOW())
													";
			$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
			$filtre[":FATURA_NO"] 				= trim($_REQUEST["fatura_no"]);
			$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
			$filtre[":VADE"] 					= $row_cari->VADE;
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":ARAC_ID"] 				= in_array($_REQUEST['finans_kalemi_id'], array(3,4)) ? $_REQUEST['arac_id'] : 0;
			$filtre[":PLAKA"] 					= trim($_REQUEST['plaka']);
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":KALEM_SAYISI"] 			= $_REQUEST['kalem_sayisi'];
			$filtre[":FATURA_KES"] 				= $_REQUEST['fatura_kes'];
			$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];			
			$cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
			if($_REQUEST["fatura_kes"] == '2'){
				$filtre	= array();
				$sql = "UPDATE CARI_HAREKET SET FATURA_NO = :FATURA_NO WHERE ID = :ID";
				$filtre[":FATURA_NO"] 	= "IRS". str_pad($cari_hareket_id, 13, "0", STR_PAD_LEFT);
				$filtre[":ID"] 			= $cari_hareket_id;
				$this->cdbPDO->rowsCount($sql, $filtre);	
			}
			
			$filtre	= array();
			$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
			$filtre[":ID"] 	= $cari_hareket_id;
			$row = $this->cdbPDO->row($sql, $filtre); 
			
		} else {
			
			if(is_null($row->ID)){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Cari Hareket bulunamadı!";	
				return $sonuc;
			}
			
			if($row->KOD != $_REQUEST['kod']){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
											FATURA_NO				= :FATURA_NO,
											FATURA_TARIH			= :FATURA_TARIH,
											VADE_TARIH				= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
											CARI_ID					= :CARI_ID,
											ARAC_ID					= :ARAC_ID,
											PLAKA					= :PLAKA,
											ACIKLAMA				= :ACIKLAMA,
											KALEM_SAYISI			= :KALEM_SAYISI,
											FATURA_KES				= :FATURA_KES
									WHERE ID = :ID
									";
			$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
			$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);
			$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
			$filtre[":VADE"] 					= $row_cari->VADE;
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":ARAC_ID"] 				= in_array($_REQUEST['finans_kalemi_id'], array(3,4)) ? $_REQUEST['arac_id'] : 0;
			$filtre[":PLAKA"] 					= trim($_REQUEST['plaka']);
			$filtre[":KALEM_SAYISI"] 			= $_REQUEST['kalem_sayisi'];
			$filtre[":FATURA_KES"] 				= $_REQUEST['fatura_kes'];
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":ID"] 						= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		}
		
		$filtre	= array();
		$sql = "SELECT (1 + (KDV / 100)) AS KDV_CARPAN, KDV FROM FINANS_KALEMI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["finans_kalemi_id"];
		$row_finans_kalemi = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID";
		$filtre[":CARI_HAREKET_ID"] 	= $row->ID;
		$rows_chd2 = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows_chd2 as $key => $row_chd2){
			$rows_chd[$row_chd2->SIRA]	= $row_chd2;
		}
		
		$sira = 0;
		foreach($_REQUEST["yp_parca_kodu"] as $key => $parca_kodu){
			if(strlen(trim($parca_kodu)) <= 0 AND strlen(trim($_REQUEST["yp_parca_adi"][$key])) <= 0) continue;
			$sira++;
			
			if(is_null($rows_chd[$sira]->ID)){
				$filtre	= array();
				$sql = "INSERT INTO CARI_HAREKET_DETAY SET CARI_HAREKET_ID = :CARI_HAREKET_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, KDV = :KDV, GTARIH = NOW()";
				$filtre[":CARI_HAREKET_ID"] = $row->ID;
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PARCA_KODU"] 		= trim($_REQUEST["yp_parca_kodu"][$key]);
				$filtre[":PARCA_ADI"] 		= trim($_REQUEST["yp_parca_adi"][$key]);
				$filtre[":ADET"] 			= FormatSayi::sayi2db($_REQUEST["yp_adet"][$key]);
				$filtre[":FIYAT"] 			= FormatSayi::sayi2db($_REQUEST["yp_fiyat"][$key]);
				$filtre[":ISKONTO"] 		= FormatSayi::sayi2db($_REQUEST["yp_iskonto"][$key]);
				$filtre[":ISKONTOLU"] 		= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) ;
				$filtre[":TUTAR"] 			= $filtre[":ADET"] * $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) * (1 + ($_REQUEST["yp_kdv"][$key] / 100));
				$filtre[":KDV"] 			= $_REQUEST["yp_kdv"][$key];
				$chd_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
				
			} else if($rows_chd[$sira]->ID > 0){
				$filtre	= array();
				$sql = "UPDATE CARI_HAREKET_DETAY SET SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, GTARIH = NOW(), KDV = :KDV WHERE ID = :ID";
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PARCA_KODU"] 		= trim($_REQUEST["yp_parca_kodu"][$key]);
				$filtre[":PARCA_ADI"] 		= trim($_REQUEST["yp_parca_adi"][$key]);
				$filtre[":ADET"] 			= FormatSayi::sayi2db($_REQUEST["yp_adet"][$key]);
				$filtre[":FIYAT"] 			= FormatSayi::sayi2db($_REQUEST["yp_fiyat"][$key]);
				$filtre[":ISKONTO"] 		= FormatSayi::sayi2db($_REQUEST["yp_iskonto"][$key]);
				$filtre[":ISKONTOLU"] 		= $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) ;
				$filtre[":TUTAR"] 			= $filtre[":ADET"] * $filtre[":FIYAT"] * ((100 - $filtre[":ISKONTO"]) / 100) * (1 + ($_REQUEST["yp_kdv"][$key] / 100));
				$filtre[":KDV"] 			= $_REQUEST["yp_kdv"][$key];
				$filtre[":ID"] 				= $rows_chd[$sira]->ID;
				$this->cdbPDO->rowsCount($sql, $filtre);
				$chd_id	= $rows_chd[$sira]->ID;
			}
			
			$chd_ids[] = $chd_id;
			
		}
		
		$filtre	= array();
		$sql = "DELETE FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID AND !FIND_IN_SET(ID, :IDS)";
		$filtre[":CARI_HAREKET_ID"] = $row->ID;
		$filtre[":IDS"] 			= implode(',', $chd_ids);
		$this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET TUTAR 		= IF(FINANS_KALEMI_ID = 14, 0, (SELECT SUM(TUTAR) AS TUTAR FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :ID)),
										KDV_TUTAR 	= IF(FINANS_KALEMI_ID IN(11,14) OR FATURA_KES = 2, 0, (SELECT SUM(TUTAR / (100 + KDV) * KDV) AS TUTAR FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :ID))
									WHERE ID = :ID
									";
		$filtre[":ID"] 				= $row->ID;
		$this->cdbPDO->rowsCount($sql, $filtre); 
		
		if(true){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
			//$sonuc["URL"] 		= "/finans/alis_fatura.do?route=finans/alis_faturalar&id={$row->ID}&kod={$row->KOD}";
			$sonuc["URL"] 		= "/finans/alis_faturalar.do?route=finans/alis_faturalar&filtre=1&fatura_no={$row->FATURA_NO}";
			$sonuc["TITLE"]		= $TITLE;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_tahsilat_kaydet(){
		
		if($_REQUEST['cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari seçilmemiş!";
			return $sonuc;
		}
			
		if($_REQUEST['odeme_kanali_detay_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ödeme Kanalı seçiniz!";
			return $sonuc;
		}
		
		if(str_replace('-','',trim($_REQUEST['fatura_tarih'])) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Tarih giriniz!";
			return $sonuc;
		}
		
		if($_REQUEST['tutar'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ödeme 0 tl olamaz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, TALEP_ID, CARI_ID FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->TALEP_ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bu kayıt otomatik oluşturulduğundan değiştirilemez!";
			return $sonuc;
		}
		
		if($row->CARI_ID == "0"){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bu kayıt virman kaydı olarak oluşturulduğundan değiştirilemez!";
			return $sonuc;
		}
		
		if(is_null($row->ID)){
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 3,
													FINANS_KALEMI_ID		= 0,
													ODEME_KANALI_ID			= :ODEME_KANALI_ID,
													ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
													FATURA_NO				= :FATURA_NO,
													FATURA_TARIH			= :FATURA_TARIH,
													CARI_ID					= :CARI_ID,
													TUTAR					= :TUTAR,
													PLAKA					= :PLAKA,
													ACIKLAMA				= :ACIKLAMA,
													SENET_NO				= :SENET_NO,
													SENET_VADE_TARIH		= :SENET_VADE_TARIH,
													SENET_TARIH				= :SENET_TARIH,
													SENET_SAHIBI			= :SENET_SAHIBI,
													SENET_BORCLU			= :SENET_BORCLU,
													SENET_HESAP_NO			= :SENET_HESAP_NO,
													KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
													TARIH					= NOW(),
													KOD						= MD5(NOW())
													";
			$filtre[":ODEME_KANALI_ID"] 		= $_REQUEST['odeme_kanali_id'];
			$filtre[":ODEME_KANALI_DETAY_ID"] 	= $_REQUEST['odeme_kanali_detay_id'];
			$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
			$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":SENET_NO"] 				= trim($_REQUEST['senet_no']); 
			$filtre[":SENET_VADE_TARIH"] 		= FormatTarih::nokta2db($_REQUEST['senet_vade_tarih']);
			$filtre[":SENET_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['senet_tarih']);
			$filtre[":SENET_SAHIBI"] 			= trim($_REQUEST['senet_sahibi']);
			$filtre[":SENET_BORCLU"] 			= trim($_REQUEST['senet_borclu']);
			$filtre[":SENET_HESAP_NO"] 			= trim($_REQUEST['senet_hesap_no']);
			$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
			$cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
		} else {
			
			if(is_null($row->ID)){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Cari Hareket bulunamadı!";	
				return $sonuc;
			}
			
			if($row->KOD != $_REQUEST['kod']){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET ODEME_KANALI_ID			= :ODEME_KANALI_ID,
											ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
											FATURA_NO				= :FATURA_NO,
											FATURA_TARIH			= :FATURA_TARIH,
											CARI_ID					= :CARI_ID,
											TUTAR					= :TUTAR,
											PLAKA					= :PLAKA,
											ACIKLAMA				= :ACIKLAMA,
											SENET_NO				= :SENET_NO,
											SENET_VADE_TARIH		= :SENET_VADE_TARIH,
											SENET_TARIH				= :SENET_TARIH,
											SENET_SAHIBI			= :SENET_SAHIBI,
											SENET_BORCLU			= :SENET_BORCLU,
											SENET_HESAP_NO			= :SENET_HESAP_NO
									WHERE ID = :ID
									";
			$filtre[":ODEME_KANALI_ID"] 		= $_REQUEST['odeme_kanali_id'];
			$filtre[":ODEME_KANALI_DETAY_ID"] 	= $_REQUEST['odeme_kanali_detay_id'];
			$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
			$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":SENET_NO"] 				= trim($_REQUEST['senet_no']);
			$filtre[":SENET_VADE_TARIH"] 		= FormatTarih::nokta2db($_REQUEST['senet_vade_tarih']);
			$filtre[":SENET_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['senet_tarih']);
			$filtre[":SENET_SAHIBI"] 			= trim($_REQUEST['senet_sahibi']);
			$filtre[":SENET_BORCLU"] 			= trim($_REQUEST['senet_borclu']);
			$filtre[":SENET_HESAP_NO"] 			= trim($_REQUEST['senet_hesap_no']);
			$filtre[":ID"] 						= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		}	
		
		if($cari_hareket_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi. İşlem No: ". $cari_hareket_id;
		} else if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_tediye_kaydet(){
		
		if($_REQUEST['cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari seçilmemiş!";
			return $sonuc;
		}
			
		if($_REQUEST['odeme_kanali_detay_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ödeme Kanalı seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST['finans_kalemi_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Finans Kalemi seçiniz!";
			return $sonuc;
		}
		
		if(str_replace('-','',trim($_REQUEST['fatura_tarih'])) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Tarih giriniz!";
			return $sonuc;
		}
		
		if($_REQUEST['tutar'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ödeme 0 tl olamaz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, TALEP_ID, CARI_ID FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->TALEP_ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bu kayıt otomatik oluşturulduğundan değiştirilemez!";
			return $sonuc;
		}
		
		if($row->CARI_ID == "0"){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bu kayıt virman kaydı olarak oluşturulduğundan değiştirilemez!";
			return $sonuc;
		}
		
		if(in_array($_REQUEST['odeme_kanali_id'],array(4,5)) AND $_REQUEST['odeme_kanali_detay_id'] > 5){ // Çek, Senet
			$SENET_CARI_HAREKET_ID = $_REQUEST['odeme_kanali_detay_id'];
			$_REQUEST['odeme_kanali_detay_id'] = $_REQUEST['odeme_kanali_id'];
		}
		
		if(is_null($row->ID)){
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 4,
													ODEME_KANALI_ID			= :ODEME_KANALI_ID,
													ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
													FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
													FATURA_NO				= :FATURA_NO,
													FATURA_TARIH			= :FATURA_TARIH,
													CARI_ID					= :CARI_ID,
													TUTAR					= :TUTAR,
													PLAKA					= :PLAKA,
													ACIKLAMA				= :ACIKLAMA,
													SENET_NO				= :SENET_NO,
													SENET_VADE_TARIH		= :SENET_VADE_TARIH,
													SENET_TARIH				= :SENET_TARIH,
													SENET_SAHIBI			= :SENET_SAHIBI,
													SENET_BORCLU			= :SENET_BORCLU,
													SENET_HESAP_NO			= :SENET_HESAP_NO,
													KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
													TARIH					= NOW(),
													KOD						= MD5(NOW())
													";
			$filtre[":ODEME_KANALI_ID"] 		= $_REQUEST['odeme_kanali_id'];
			$filtre[":ODEME_KANALI_DETAY_ID"] 	= $_REQUEST['odeme_kanali_detay_id'];
			$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
			$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
			$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":SENET_NO"] 				= trim($_REQUEST['senet_no']);
			$filtre[":SENET_VADE_TARIH"] 		= FormatTarih::nokta2db($_REQUEST['senet_vade_tarih']);
			$filtre[":SENET_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['senet_tarih']);
			$filtre[":SENET_SAHIBI"] 			= trim($_REQUEST['senet_sahibi']);
			$filtre[":SENET_BORCLU"] 			= trim($_REQUEST['senet_borclu']);
			$filtre[":SENET_HESAP_NO"] 			= trim($_REQUEST['senet_hesap_no']);
			$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
			$cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
		} else {
			
			if(is_null($row->ID)){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Cari Hareket bulunamadı!";	
				return $sonuc;
			}
			
			if($row->KOD != $_REQUEST['kod']){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET ODEME_KANALI_ID			= :ODEME_KANALI_ID,
											ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
											FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
											FATURA_NO				= :FATURA_NO,
											FATURA_TARIH			= :FATURA_TARIH,
											CARI_ID					= :CARI_ID,
											TUTAR					= :TUTAR,
											PLAKA					= :PLAKA,
											ACIKLAMA				= :ACIKLAMA,
											SENET_NO				= :SENET_NO,
											SENET_VADE_TARIH		= :SENET_VADE_TARIH,
											SENET_TARIH				= :SENET_TARIH,
											SENET_SAHIBI			= :SENET_SAHIBI,
											SENET_BORCLU			= :SENET_BORCLU,
											SENET_HESAP_NO			= :SENET_HESAP_NO
									WHERE ID = :ID
									";
			$filtre[":ODEME_KANALI_ID"] 		= $_REQUEST['odeme_kanali_id'];
			$filtre[":ODEME_KANALI_DETAY_ID"] 	= $_REQUEST['odeme_kanali_detay_id'];
			$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
			$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
			$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":SENET_NO"] 				= trim($_REQUEST['senet_no']);
			$filtre[":SENET_VADE_TARIH"] 		= FormatTarih::nokta2db($_REQUEST['senet_vade_tarih']);
			$filtre[":SENET_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['senet_tarih']);
			$filtre[":SENET_SAHIBI"] 			= trim($_REQUEST['senet_sahibi']);
			$filtre[":SENET_BORCLU"] 			= trim($_REQUEST['senet_borclu']);
			$filtre[":SENET_HESAP_NO"] 			= trim($_REQUEST['senet_hesap_no']);			
			$filtre[":ID"] 						= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		}
		
		if(in_array($_REQUEST['odeme_kanali_id'],array(4,5)) AND $SENET_CARI_HAREKET_ID > 5){ // Çek, Senet			
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET SENET_DURUM	= 1 WHERE ID = :ID AND ODEME_KANALI_ID IN (4,5)";
			$filtre[":ID"] 		= $SENET_CARI_HAREKET_ID;
			$this->cdbPDO->rowsCount($sql, $filtre); 
			
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET SENET_CARI_HAREKET_ID = :SENET_CARI_HAREKET_ID WHERE ID = :ID AND ODEME_KANALI_ID IN (4,5)";
			$filtre[":SENET_CARI_HAREKET_ID"] 	= $SENET_CARI_HAREKET_ID;
			$filtre[":ID"] 						= $cari_hareket_id > 0 ? $cari_hareket_id : $row->ID;
			$this->cdbPDO->rowsCount($sql, $filtre); 
		}
				
		
		if($cari_hareket_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi. İşlem No: ". $cari_hareket_id;
		} else if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_kasa_virman_ekle(){
		
		if($_REQUEST['borc_kasa_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Borç Kasa seçiniz!";
			return $sonuc;
		}
			
		if($_REQUEST['alacak_kasa_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Alacak Kasa seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST['borc_kasa_id'] == $_REQUEST['alacak_kasa_id']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Borç - Alacak Kasa aynı olamaz!";
			return $sonuc;
		}
		
		if($_REQUEST['tutar'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tutar 0 tl olamaz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM ODEME_KANALI_DETAY WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["borc_kasa_id"];
		$row_borc = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM ODEME_KANALI_DETAY WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["alacak_kasa_id"];
		$row_alacak = $this->cdbPDO->row($sql, $filtre); 
		
		$this->cdbPDO->dbPDO->beginTransaction();
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 4,
												FINANS_KALEMI_ID		= 0,
												ODEME_KANALI_ID			= :ODEME_KANALI_ID,
												ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
												PLAKA					= :PLAKA,
												FATURA_NO				= :FATURA_NO,
												FATURA_TARIH			= :FATURA_TARIH,
												CARI_ID					= :CARI_ID,
												TUTAR					= :TUTAR,
												ACIKLAMA				= :ACIKLAMA,
												KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
												TARIH					= NOW(),
												KOD						= MD5(NOW())
												";
		$filtre[":ODEME_KANALI_ID"] 		= $row_borc->ODEME_KANALI_ID;
		$filtre[":ODEME_KANALI_DETAY_ID"] 	= $row_borc->ID;
		$filtre[":PLAKA"] 					= "Kasa Virman";	
		$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
		$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
		$filtre[":CARI_ID"] 				= 0;
		$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
		$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
		$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
		$borc_cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 3,
												FINANS_KALEMI_ID		= 0,
												ODEME_KANALI_ID			= :ODEME_KANALI_ID,
												ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
												PLAKA					= :PLAKA,
												FATURA_NO				= :FATURA_NO,
												FATURA_TARIH			= :FATURA_TARIH,
												CARI_ID					= :CARI_ID,
												TUTAR					= :TUTAR,
												ACIKLAMA				= :ACIKLAMA,
												KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
												TARIH					= NOW(),
												KOD						= MD5(NOW())
												";
		$filtre[":ODEME_KANALI_ID"] 		= $row_alacak->ODEME_KANALI_ID;
		$filtre[":ODEME_KANALI_DETAY_ID"] 	= $row_alacak->ID;
		$filtre[":PLAKA"] 					= "Kasa Virman";	
		$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
		$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
		$filtre[":CARI_ID"] 				= 0;
		$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
		$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
		$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
		$alacak_cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
		
		$filtre	= array();
		$sql = "INSERT INTO VIRMAN SET 	BORC_ID					= :BORC_ID,
										BORC_CARI_HAREKET_ID	= :BORC_CARI_HAREKET_ID,
										ALACAK_ID				= :ALACAK_ID,
										ALACAK_CARI_HAREKET_ID	= :ALACAK_CARI_HAREKET_ID,
										FATURA_NO				= :FATURA_NO,
										FATURA_TARIH			= :FATURA_TARIH,
										TUTAR					= :TUTAR,
										ACIKLAMA				= :ACIKLAMA,
										VIRMAN_TURU				= :VIRMAN_TURU,
										KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
										TARIH					= NOW(),
										KOD						= MD5(NOW())
										";
		$filtre[":BORC_ID"] 				= $row_borc->ID;
		$filtre[":BORC_CARI_HAREKET_ID"] 	= $borc_cari_hareket_id;
		$filtre[":ALACAK_ID"] 				= $row_alacak->ID;
		$filtre[":ALACAK_CARI_HAREKET_ID"] 	= $alacak_cari_hareket_id;
		$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
		$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
		$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
		$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
		$filtre[":VIRMAN_TURU"] 			= 'KASA';
		$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
		$virman_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
		
		$filtre	= array();
		$sql = "SELECT * FROM VIRMAN WHERE ID = :ID";
		$filtre[":ID"] 	= $virman_id;
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->ID > 0){
			$this->cdbPDO->dbPDO->commit();
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
			$sonuc["URL"] 		= "/finans/virman_dekontu.do?route=finans/virman_dekontu&id={$row->ID}&kod={$row->KOD}";
		}else{
			$this->cdbPDO->dbPDO->rollback();
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_cari_virman_ekle(){
		
		if($_REQUEST['borc_cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Borç Cari seçiniz!";
			return $sonuc;
		}
			
		if($_REQUEST['alacak_cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Alacak Cari seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST['borc_cari_id'] == $_REQUEST['alacak_cari_id']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Borç - Alacak Cari aynı olamaz!";
			return $sonuc;
		}
		
		if($_REQUEST['tutar'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tutar 0 tl olamaz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["borc_cari_id"];
		$row_borc = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["alacak_cari_id"];
		$row_alacak = $this->cdbPDO->row($sql, $filtre); 
		
		$this->cdbPDO->dbPDO->beginTransaction();
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 4,
												FINANS_KALEMI_ID		= 0,
												ODEME_KANALI_ID			= :ODEME_KANALI_ID,
												ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
												PLAKA					= :PLAKA,
												FATURA_NO				= :FATURA_NO,
												FATURA_TARIH			= :FATURA_TARIH,
												CARI_ID					= :CARI_ID,
												TUTAR					= :TUTAR,
												ACIKLAMA				= :ACIKLAMA,
												KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
												TARIH					= NOW(),
												KOD						= MD5(NOW())
												";
		$filtre[":ODEME_KANALI_ID"] 		= 3;
		$filtre[":ODEME_KANALI_DETAY_ID"] 	= 3;
		$filtre[":PLAKA"] 					= "Cari Virman";	
		$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
		$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
		$filtre[":CARI_ID"] 				= $row_borc->ID;
		$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
		$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
		$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
		$borc_cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 3,
												FINANS_KALEMI_ID		= 0,
												ODEME_KANALI_ID			= :ODEME_KANALI_ID,
												ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
												PLAKA					= :PLAKA,
												FATURA_NO				= :FATURA_NO,
												FATURA_TARIH			= :FATURA_TARIH,
												CARI_ID					= :CARI_ID,
												TUTAR					= :TUTAR,
												ACIKLAMA				= :ACIKLAMA,
												KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
												TARIH					= NOW(),
												KOD						= MD5(NOW())
												";
		$filtre[":ODEME_KANALI_ID"] 		= 3;
		$filtre[":ODEME_KANALI_DETAY_ID"] 	= 3;
		$filtre[":PLAKA"] 					= "Cari Virman";	
		$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
		$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
		$filtre[":CARI_ID"] 				= $row_alacak->ID;
		$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
		$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
		$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
		$alacak_cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
		
		$filtre	= array();
		$sql = "INSERT INTO VIRMAN SET 	BORC_ID					= :BORC_ID,
										BORC_CARI_HAREKET_ID	= :BORC_CARI_HAREKET_ID,
										ALACAK_ID				= :ALACAK_ID,
										ALACAK_CARI_HAREKET_ID	= :ALACAK_CARI_HAREKET_ID,
										FATURA_NO				= :FATURA_NO,
										FATURA_TARIH			= :FATURA_TARIH,
										TUTAR					= :TUTAR,
										ACIKLAMA				= :ACIKLAMA,
										VIRMAN_TURU				= :VIRMAN_TURU,
										KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
										TARIH					= NOW(),
										KOD						= MD5(NOW())
										";
		$filtre[":BORC_ID"] 				= $row_borc->ID;
		$filtre[":BORC_CARI_HAREKET_ID"] 	= $borc_cari_hareket_id;
		$filtre[":ALACAK_ID"] 				= $row_alacak->ID;
		$filtre[":ALACAK_CARI_HAREKET_ID"] 	= $alacak_cari_hareket_id;
		$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
		$filtre[":FATURA_TARIH"] 			= ($_REQUEST['fatura_tarih'] == "" ? NULL : FormatTarih::nokta2db($_REQUEST['fatura_tarih']));
		$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
		$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
		$filtre[":VIRMAN_TURU"] 			= 'CARI';
		$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
		$virman_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
		
		$filtre	= array();
		$sql = "SELECT * FROM VIRMAN WHERE ID = :ID";
		$filtre[":ID"] 	= $virman_id;
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->ID > 0){
			$this->cdbPDO->dbPDO->commit();
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
			$sonuc["URL"] 		= "/finans/virman_dekontu.do?route=finans/virman_dekontu&id={$row->ID}&kod={$row->KOD}";
		}else{
			$this->cdbPDO->dbPDO->rollback();
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_cari_aktar(){
		
		if($this->rSite->MUHASEBE_SIFRE != $_REQUEST["sifre"]){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Şifre Hatalı!";
			return $sonuc;
		}
		
		if($_REQUEST['eski_cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Borç Cari seçiniz!";
			return $sonuc;
		}
			
		if($_REQUEST['yeni_cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Alacak Cari seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST['eski_cari_id'] == $_REQUEST['yeni_cari_id']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Eski - Yeni Cari aynı olamaz!";
			return $sonuc;
		}
		
		if(strlen($_REQUEST['aciklama']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Açıklama giriniz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["eski_cari_id"];
		$row_eski = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["yeni_cari_id"];
		$row_yeni = $this->cdbPDO->row($sql, $filtre); 
		
		$this->cdbPDO->dbPDO->beginTransaction();
		
		$filtre	= array();
		$sql = "SELECT GROUP_CONCAT(ID) AS IDS FROM CARI_HAREKET WHERE CARI_ID = :ESKI_CARI_ID";
		$filtre[":ESKI_CARI_ID"] 	= $row_eski->ID;
		$row_ch = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT GROUP_CONCAT(ID) AS IDS FROM TALEP WHERE CARI_ID = :ESKI_CARI_ID";
		$filtre[":ESKI_CARI_ID"] 	= $row_eski->ID;
		$row_talep = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_AKTARMA SET 	ESKI_CARI_ID			= :ESKI_CARI_ID,
												YENI_CARI_ID			= :YENI_CARI_ID,
												ACIKLAMA				= :ACIKLAMA,
												CARI_HAREKET_IDS		= :CARI_HAREKET_IDS,
												TALEP_IDS				= :TALEP_IDS,
												KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID
												";
		$filtre[":ESKI_CARI_ID"] 			= $row_eski->ID;
		$filtre[":YENI_CARI_ID"] 			= $row_yeni->ID;
		$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);	
		$filtre[":CARI_HAREKET_IDS"] 		= $row_ch->IDS;
		$filtre[":TALEP_IDS"] 				= $row_talep->IDS;
		$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
		$this->cdbPDO->rowsCount($sql, $filtre);  
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET CARI_ID = :YENI_CARI_ID	WHERE CARI_ID = :ESKI_CARI_ID";
		$filtre[":ESKI_CARI_ID"] 			= $row_eski->ID;
		$filtre[":YENI_CARI_ID"] 			= $row_yeni->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET CARI_ID = :YENI_CARI_ID WHERE CARI_ID = :ESKI_CARI_ID";
		$filtre[":ESKI_CARI_ID"] 			= $row_eski->ID;
		$filtre[":YENI_CARI_ID"] 			= $row_yeni->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);  
		
		$filtre	= array();
		$sql = "DELETE FROM CARI WHERE ID = :ESKI_CARI_ID";
		$filtre[":ESKI_CARI_ID"] 			= $row_eski->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$this->cdbPDO->dbPDO->commit();
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Cari Hareketler Taşındı.";
			$sonuc["URL"] 		= "/finans/cari_hareketler.do?route=finans/cari_hareketler&cari_id={$row_yeni->ID}&filtre=1";
		}else{
			$this->cdbPDO->dbPDO->rollback();
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_borc_dekontu_kaydet(){
		
		if($_REQUEST['cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari seçilmemiş!";
			return $sonuc;
		}
		
		if(str_replace('-','',trim($_REQUEST['fatura_tarih'])) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Borç Tarih giriniz!";
			return $sonuc;
		}
		
		if($_REQUEST['tutar'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ödeme 0 tl olamaz!";
			return $sonuc;
		}
		
		if($_REQUEST['finans_kalemi_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Finans kalem seçiniz!";
			return $sonuc;
		}
		/*
		if(strlen($_REQUEST['fatura_no']) > 0 AND $_REQUEST["taksit"] > 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Alanını boş bırakınız otomatik doldurulacak!";
			return $sonuc;
		}
		*/
		if($_REQUEST["taksit"] > 1){
			for($i = 0; $i < $_REQUEST["taksit"]; $i++){
				$filtre	= array();
				$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 4,
														FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
														ODEME_KANALI_ID			= :ODEME_KANALI_ID,
														ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
														FATURA_NO				= :FATURA_NO,
														FATURA_TARIH			= DATE_ADD(:FATURA_TARIH, INTERVAL :ARTI MONTH),
														CARI_ID					= :CARI_ID,
														TUTAR					= :TUTAR,
														PLAKA					= :PLAKA,
														ACIKLAMA				= :ACIKLAMA,
														TAKSIT					= :TAKSIT,
														KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
														TARIH					= NOW(),
														KOD						= MD5(NOW())
														";
				$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
				$filtre[":ODEME_KANALI_ID"] 		= 0;
				$filtre[":ODEME_KANALI_DETAY_ID"] 	= 0;
				$filtre[":FATURA_NO"] 				= $_REQUEST['taksit'] ."TAKSIT". str_pad(($i+1), 3, "0", STR_PAD_LEFT);
				$filtre[":FATURA_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['fatura_tarih']);
				$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
				$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
				$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
				$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
				$filtre[":TAKSIT"] 					= $_REQUEST['taksit'];
				$filtre[":ARTI"] 					= $i;
				$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
				$cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			}
			
		} else {
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 4,
													FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
													ODEME_KANALI_ID			= :ODEME_KANALI_ID,
													ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
													FATURA_NO				= :FATURA_NO,
													FATURA_TARIH			= :FATURA_TARIH,
													CARI_ID					= :CARI_ID,
													TUTAR					= :TUTAR,
													PLAKA					= :PLAKA,
													ACIKLAMA				= :ACIKLAMA,
													KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
													TARIH					= NOW(),
													KOD						= MD5(NOW())
													";
			$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
			$filtre[":ODEME_KANALI_ID"] 		= 0;
			$filtre[":ODEME_KANALI_DETAY_ID"] 	= 0;
			$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
			$filtre[":FATURA_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['fatura_tarih']);
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
			$cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $cari_hareket_id;
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if($cari_hareket_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi. İşlem No: ". $cari_hareket_id;
			//$sonuc["URL"] 		= "/finans/tediye.do?route=finans/tediye&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_alacak_dekontu_kaydet(){
		
		if($_REQUEST['cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari seçilmemiş!";
			return $sonuc;
		}
		
		if(str_replace('-','',trim($_REQUEST['fatura_tarih'])) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Borç Tarih giriniz!";
			return $sonuc;
		}
		
		if($_REQUEST['tutar'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ödeme 0 tl olamaz!";
			return $sonuc;
		}
		
		if($_REQUEST['finans_kalemi_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Finans kalem seçiniz!";
			return $sonuc;
		}
		
		if($_REQUEST["taksit"] > 1){
			for($i = 0; $i < $_REQUEST["taksit"]; $i++){
				$filtre	= array();
				$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 3,
														FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
														ODEME_KANALI_ID			= :ODEME_KANALI_ID,
														ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
														FATURA_NO				= :FATURA_NO,
														FATURA_TARIH			= DATE_ADD(:FATURA_TARIH, INTERVAL :ARTI MONTH),
														CARI_ID					= :CARI_ID,
														TUTAR					= :TUTAR,
														PLAKA					= :PLAKA,
														ACIKLAMA				= :ACIKLAMA,
														TAKSIT					= :TAKSIT,
														KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
														TARIH					= NOW(),
														KOD						= MD5(NOW())
														";
				$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
				$filtre[":ODEME_KANALI_ID"] 		= 0;
				$filtre[":ODEME_KANALI_DETAY_ID"] 	= 0;
				$filtre[":FATURA_NO"] 				= $_REQUEST['taksit'] ."TAKSIT". str_pad(($i+1), 3, "0", STR_PAD_LEFT);
				$filtre[":FATURA_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['fatura_tarih']);
				$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
				$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
				$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
				$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
				$filtre[":TAKSIT"] 					= $_REQUEST['taksit'];
				$filtre[":ARTI"] 					= $i;
				$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
				$cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			}
			
		} else {
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 3,
													FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
													ODEME_KANALI_ID			= :ODEME_KANALI_ID,
													ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
													FATURA_NO				= :FATURA_NO,
													FATURA_TARIH			= :FATURA_TARIH,
													CARI_ID					= :CARI_ID,
													TUTAR					= :TUTAR,
													PLAKA					= :PLAKA,
													ACIKLAMA				= :ACIKLAMA,
													KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
													TARIH					= NOW(),
													KOD						= MD5(NOW())
													";
			$filtre[":FINANS_KALEMI_ID"] 		= $_REQUEST['finans_kalemi_id'];
			$filtre[":ODEME_KANALI_ID"] 		= 0;
			$filtre[":ODEME_KANALI_DETAY_ID"] 	= 0;
			$filtre[":FATURA_NO"] 				= trim($_REQUEST['fatura_no']);	
			$filtre[":FATURA_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['fatura_tarih']);
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":TUTAR"] 					= fncSayi($_REQUEST['tutar']);
			$filtre[":PLAKA"] 					= trim(strtoupper($_REQUEST['plaka']));
			$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
			$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
			$cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $cari_hareket_id;
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if($cari_hareket_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi. İşlem No: ". $cari_hareket_id;
			//$sonuc["URL"] 		= "/finans/tediye.do?route=finans/tediye&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_fis_ekle(){
		
		if($_REQUEST['fis_no'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fiş No giriniz!";
			return $sonuc;
		}
		
		$TUTAR = 0;
		for($i = 1; $i <= 6; $i++){
			$TUTAR += fncSayi($_REQUEST['tutar'.$i]);
		}
		
		if($TUTAR <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fiş 0 tl olamaz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO FIS SET FIS_NO				= :FIS_NO,
									FIS_TUR_ID			= :FIS_TUR_ID,
									TUTAR				= :TUTAR,
									KDV					= :KDV,
									TARIH				= :TARIH,
									KAYIT_YAPAN_ID		= :KAYIT_YAPAN_ID,
									ACIKLAMA			= :ACIKLAMA
									";			
		$filtre[":FIS_NO"] 				= trim($_REQUEST['fis_no']);
		$filtre[":FIS_TUR_ID"] 			= $_REQUEST['fis_tur_id'];
		$filtre[":TUTAR"] 				= $TUTAR;
		$filtre[":KDV"] 				= $_REQUEST['kdv'];
		$filtre[":TARIH"] 				= FormatTarih::tre2db($_REQUEST['tarih']);
		$filtre[":KAYIT_YAPAN_ID"] 		= $_REQUEST['kayit_yapan_id'];
		$filtre[":ACIKLAMA"] 			= trim($_REQUEST['aciklama']);
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 			
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Fiş Kayıt Edildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_fis_coklu_ekle(){
		
		for($i = 0; $i < 20; $i++){		
			if(strlen(trim($_REQUEST['fis_no'][$i])) == 0 AND fncSayi($_REQUEST['tutar']) <= 0) continue;
			$filtre	= array();
			$sql = "INSERT INTO FIS SET FIS_NO				= :FIS_NO,
										FIS_TUR_ID			= :FIS_TUR_ID,
										TUTAR				= :TUTAR,
										KDV					= :KDV,
										TARIH				= :TARIH,
										KAYIT_YAPAN_ID		= :KAYIT_YAPAN_ID,
										ACIKLAMA			= :ACIKLAMA
										";			
			$filtre[":FIS_NO"] 				= trim($_REQUEST['fis_no'][$i]);
			$filtre[":FIS_TUR_ID"] 			= $_REQUEST['fis_tur_id'][$i];
			$filtre[":TUTAR"] 				= fncSayi($_REQUEST['tutar'][$i]);
			$filtre[":KDV"] 				= $_REQUEST['kdv'][$i];
			$filtre[":TARIH"] 				= FormatTarih::tre2db($_REQUEST['tarih'][$i]);
			$filtre[":KAYIT_YAPAN_ID"] 		= $_REQUEST['kayit_yapan_id'][$i];
			$filtre[":ACIKLAMA"] 			= trim($_REQUEST['aciklama'][$i]);
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 			
			
			if($rowsCount > 0){
				$rows_eklenen[] = $i;
			}
			
		}
		
		if(count($rows_eklenen) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= count($rows_eklenen) . " adet Fiş Kayıt Edildi.";
			$sonuc["ROWS"] 		= $rows_eklenen;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function finans_fis_sil(){
		$filtre	= array();
		$sql = "DELETE FROM FIS WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function kiralama_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,8))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		if(empty($_REQUEST['tahmini_iade_tarih'])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tahmini İade tarihi giriniz!";	
			return $sonuc;
		}
		/*
		if($_REQUEST['lastik'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Lastik türü seçiniz!";	
			return $sonuc;
		}
		
		if($_REQUEST['yedek_anahtar'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yedek Anahtar durumunu seçiniz!";	
			return $sonuc;
		}
		*/
		if(FormatSayi::sayi2db($_REQUEST["son_km"]) > 0 AND FormatSayi::sayi2db($_REQUEST["son_km"]) < FormatSayi::sayi2db($_REQUEST["ilk_km"])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Son KM, ilk KM den büyük olmalı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, PLAKA FROM ARAC WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["arac_id"];
		$row_arac = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row_arac->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Araç bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["cari_id"];
		$row_cari = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row_cari->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM KIRALAMA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->SUREC_ID == 10 AND !in_array($_SESSION['kullanici'], array("ADMIN"))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		if(is_null($row->ID) AND $_REQUEST['ayni_plaka'] == "0" AND FALSE){
			$filtre	= array();
			$sql = "SELECT ID, KOD, PLAKA, TARIH FROM KIRALAMA WHERE PLAKA = :PLAKA AND SUREC_ID < 10";
			$filtre[":PLAKA"] 	= $_REQUEST["plaka"];
			$row_ayni = $this->cdbPDO->row($sql, $filtre); 
			
			if($row_ayni->ID > 0){
				$sonuc["HATA"] 			= TRUE;
				$sonuc["AYNI_PLAKA"] 	= 1;
				$sonuc["ACIKLAMA"] 		= "<b>" . $row_ayni->PLAKA . "</b> plakanın <b>". FormatTarih::tarih($row_ayni->TARIH) ."</b> tarihinde açılmış dosyası var!<br> Devam etmek istiyorsanız tekrar kaydet butonuna basınız.";	
				return $sonuc;
			}
		}
		
		if(TRUE){
			$filtre	= array();
			$sql = "SELECT ID, KOD, PLAKA, TARIH FROM KIRALAMA WHERE ID != :ID AND ARAC_ID = :ARAC_ID AND SUREC_ID < 10 LIMIT 1";
			$filtre[":ID"] 			= $_REQUEST["id"];
			$filtre[":ARAC_ID"] 	= $_REQUEST["arac_id"];
			$row_acik = $this->cdbPDO->row($sql, $filtre); 
			
			if($row_acik->ID > 0 AND !in_array($_SESSION['kullanici'], array("ADMIN"))){
				$sonuc["HATA"] 			= TRUE;
				$sonuc["ACIKLAMA"] 		= "<b>" . $row_acik->PLAKA . "</b> plakanın <b>". FormatTarih::tarih($row_acik->TARIH) ."</b> tarihinde açılmış kiralama var!";	
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "SELECT ID, KOD, PLAKA, TARIH FROM TALEP_IKAME WHERE ARAC_ID = :ARAC_ID AND SUREC_ID < 10 LIMIT 1";
			$filtre[":ARAC_ID"] 	= $_REQUEST["arac_id"];
			$row_acik = $this->cdbPDO->row($sql, $filtre); 
			
			if($row_acik->ID > 0 AND !in_array($_SESSION['kullanici'], array("ADMIN"))){
				$sonuc["HATA"] 			= TRUE;
				$sonuc["ACIKLAMA"] 		= "<b>" . $row_acik->PLAKA . "</b> plakanın <b>". FormatTarih::tarih($row_acik->TARIH) ."</b> tarihinde bu araç ikamesi bulunmaktadır";	
				return $sonuc;
			}
		}	
		
		if(is_null($row->ID)){
			
			$filtre	= array();
			$sql = "INSERT INTO KIRALAMA SET 	PLAKA				= :PLAKA,
												ARAC_ID				= :ARAC_ID,
												CARI_ID				= :CARI_ID,
												SURUCU_AD_SOYAD		= :SURUCU_AD_SOYAD,
												SURUCU_TEL			= :SURUCU_TEL,
												SUREC_ID			= :SUREC_ID,
												ILK_KM				= :ILK_KM,
												SON_KM				= :SON_KM,
												VERILIS_TARIH		= :VERILIS_TARIH,
												VERILIS_SAAT		= :VERILIS_SAAT,
												IADE_TARIH			= :IADE_TARIH,
												IADE_SAAT			= :IADE_SAAT,
												TAHMINI_IADE_TARIH	= :TAHMINI_IADE_TARIH,
												TAHMINI_IADE_SAAT	= :TAHMINI_IADE_SAAT,
				                            	TALEP				= :TALEP,
				                            	SURUCU_IL_ID		= :SURUCU_IL_ID,
												SURUCU_ILCE_ID		= :SURUCU_ILCE_ID,
												SURUCU_ADRES		= :SURUCU_ADRES,
												LASTIK				= :LASTIK,
												YEDEK_ANAHTAR		= :YEDEK_ANAHTAR,
												ISKONTO				= :ISKONTO,
												ODENECEK_TUTAR		= :ODENECEK_TUTAR,
												FATURA_KESIM_TARIH	= :FATURA_KESIM_TARIH,
												EKLEYEN_ID			= :EKLEYEN_ID,
												TARIH				= NOW(),
												KOD					= MD5(NOW()),
												GTARIH				= NOW()											
												";
			$filtre[":PLAKA"] 					= $row_arac->PLAKA;
			$filtre[":ARAC_ID"] 				= $_REQUEST["arac_id"];
			$filtre[":CARI_ID"] 				= $_REQUEST["cari_id"];
			$filtre[":SURUCU_AD_SOYAD"] 		= trim($_REQUEST["surucu_ad_soyad"]);
			$filtre[":SURUCU_TEL"] 				= $_REQUEST["surucu_tel"];
			$filtre[":SUREC_ID"] 				= 2;
			$filtre[":ILK_KM"] 					= FormatSayi::sayi2db($_REQUEST["ilk_km"]);
			$filtre[":SON_KM"] 					= FormatSayi::sayi2db($_REQUEST["son_km"]);
			$filtre[":VERILIS_TARIH"] 			= FormatTarih::nokta2db($_REQUEST["verilis_tarih"]);
			$filtre[":VERILIS_SAAT"] 			= $_REQUEST["verilis_saat"];
			$filtre[":IADE_TARIH"] 				= FormatTarih::nokta2db($_REQUEST["iade_tarih"]);
			$filtre[":IADE_SAAT"] 				= $_REQUEST["iade_saat"];
			$filtre[":TAHMINI_IADE_TARIH"] 		= FormatTarih::nokta2db($_REQUEST["tahmini_iade_tarih"]);
			$filtre[":TAHMINI_IADE_SAAT"] 		= $_REQUEST["tahmini_iade_saat"];
			$filtre[":TALEP"] 					= trim($_REQUEST["talep"]);
			$filtre[":SURUCU_IL_ID"] 			= $_REQUEST["surucu_il_id"];
			$filtre[":SURUCU_ILCE_ID"] 			= $_REQUEST["surucu_ilce_id"];
			$filtre[":SURUCU_ADRES"] 			= trim($_REQUEST["surucu_adres"]);
			$filtre[":LASTIK"]					= $_REQUEST["lastik"];
			$filtre[":YEDEK_ANAHTAR"]			= $_REQUEST["yedek_anahtar"];
			$filtre[":ISKONTO"] 				= FormatSayi::sayi2db($_REQUEST["iskonto"]);
			$filtre[":ODENECEK_TUTAR"] 			= FormatSayi::sayi2db($_REQUEST["odenecek_tutar"]);
			$filtre[":FATURA_KESIM_TARIH"] 		= FormatTarih::nokta2db($_REQUEST["fatura_kesim_tarih"]);
			$filtre[":EKLEYEN_ID"] 				= $_SESSION["kullanici_id"];
			$kiralama_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
			$filtre	= array();
			$sql = "SELECT * FROM KIRALAMA WHERE ID = :ID";
			$filtre[":ID"] 	= $kiralama_id;
			$row = $this->cdbPDO->row($sql, $filtre); 
			
		} else {
			
			if($row->KOD != $_REQUEST['kod']){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE KIRALAMA SET PLAKA				= :PLAKA,
										ARAC_ID				= :ARAC_ID,
										CARI_ID				= :CARI_ID,
										SURUCU_AD_SOYAD		= :SURUCU_AD_SOYAD,
										SURUCU_TEL			= :SURUCU_TEL,
										SUREC_ID			= :SUREC_ID,
										ILK_KM				= :ILK_KM,
										SON_KM				= :SON_KM,
										VERILIS_TARIH		= :VERILIS_TARIH,
										VERILIS_SAAT		= :VERILIS_SAAT,
										IADE_TARIH			= :IADE_TARIH,
										IADE_SAAT			= :IADE_SAAT,
										TAHMINI_IADE_TARIH	= :TAHMINI_IADE_TARIH,
										TAHMINI_IADE_SAAT	= :TAHMINI_IADE_SAAT,
				                        TALEP				= :TALEP,
				                        SURUCU_IL_ID		= :SURUCU_IL_ID,
										SURUCU_ILCE_ID		= :SURUCU_ILCE_ID,
										SURUCU_ADRES		= :SURUCU_ADRES,
										LASTIK				= :LASTIK,
										YEDEK_ANAHTAR		= :YEDEK_ANAHTAR,
										ODENECEK_TUTAR		= :ODENECEK_TUTAR,
										FATURA_KESIM_TARIH	= :FATURA_KESIM_TARIH,
										GTARIH				= NOW()			
								WHERE ID = :ID
								";
			$filtre[":PLAKA"] 					= $row_arac->PLAKA;
			$filtre[":ARAC_ID"] 				= $_REQUEST["arac_id"];
			$filtre[":CARI_ID"] 				= $_REQUEST["cari_id"];
			$filtre[":SURUCU_AD_SOYAD"] 		= trim($_REQUEST["surucu_ad_soyad"]);
			$filtre[":SURUCU_TEL"] 				= $_REQUEST["surucu_tel"];
			$filtre[":SUREC_ID"] 				= 2;
			$filtre[":ILK_KM"] 					= FormatSayi::sayi2db($_REQUEST["ilk_km"]);
			$filtre[":SON_KM"] 					= FormatSayi::sayi2db($_REQUEST["son_km"]);
			$filtre[":VERILIS_TARIH"] 			= FormatTarih::nokta2db($_REQUEST["verilis_tarih"]);
			$filtre[":VERILIS_SAAT"] 			= $_REQUEST["verilis_saat"];
			$filtre[":IADE_TARIH"] 				= FormatTarih::nokta2db($_REQUEST["iade_tarih"]);
			$filtre[":IADE_SAAT"] 				= $_REQUEST["iade_saat"];
			$filtre[":TAHMINI_IADE_TARIH"] 		= FormatTarih::nokta2db($_REQUEST["tahmini_iade_tarih"]);
			$filtre[":TAHMINI_IADE_SAAT"] 		= $_REQUEST["tahmini_iade_saat"];
			$filtre[":TALEP"] 					= trim($_REQUEST["talep"]);
			$filtre[":SURUCU_IL_ID"] 			= $_REQUEST["surucu_il_id"];
			$filtre[":SURUCU_ILCE_ID"] 			= $_REQUEST["surucu_ilce_id"];
			$filtre[":SURUCU_ADRES"] 			= trim($_REQUEST["surucu_adres"]);
			$filtre[":LASTIK"]					= $_REQUEST["lastik"];
			$filtre[":YEDEK_ANAHTAR"]			= $_REQUEST["yedek_anahtar"];
			$filtre[":ODENECEK_TUTAR"] 			= FormatSayi::sayi2db($_REQUEST["odenecek_tutar"]);
			$filtre[":FATURA_KESIM_TARIH"] 		= FormatTarih::nokta2db($_REQUEST["fatura_kesim_tarih"]);
			$filtre[":ID"] 						= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}	
		
		if($kiralama_id > 0){
			$sonuc["YENI"] 		= 1;
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi. Kiralama No: $kiralama_id";
			$sonuc["URL"] 		= "/kiralama/kiralama.do?route=kiralama/kiralama_takip&id={$row->ID}&kod={$row->KOD}";
		} else if($rowsCount > 0){
			$sonuc["YENI"] 		= 0;
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kiralama Kaydedildi.";
			$sonuc["URL"] 		= "/kiralama/kiralama.do?route=kiralama/kiralama_takip&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["YENI"] 		= 0;
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function kiralama_fatura_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5,8))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		if(strlen($_REQUEST['fatura_no']) != 16){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Fatura No' 16 hane olmalı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM KIRALAMA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama bittiği için değişiklik yapılamaz!";	
			return $sonuc;
		}
			
		$filtre	= array();
		$sql = "UPDATE KIRALAMA SET FATURA_NO				= :FATURA_NO,
									FATURA_TARIH			= :FATURA_TARIH,
									FATURA_TUTAR			= :FATURA_TUTAR,
		                            FATURA_ACIKLAMA			= :FATURA_ACIKLAMA,
		                            FATURA_KES				= :FATURA_KES,
		                            FATURA_ODEME			= :FATURA_ODEME
							WHERE ID = :ID
							";
		$filtre[":FATURA_NO"] 		= trim($_REQUEST["fatura_no"]);
		$filtre[":FATURA_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["fatura_tarih"]);
		$filtre[":FATURA_TUTAR"] 	= FormatSayi::sayi2db($_REQUEST["fatura_tutar"]);
		$filtre[":FATURA_ACIKLAMA"] = trim($_REQUEST["fatura_aciklama"]);
		$filtre[":FATURA_KES"]		= $_REQUEST["fatura_kes"];
		$filtre[":FATURA_ODEME"]	= $_REQUEST["fatura_odeme"];
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "KIRALAMA", "cKayıt");
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Fatura Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function kiralama_bitti(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,5,8))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM KIRALAMA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama bittiği için değişiklik yapılamaz!";	
			return $sonuc;
		}
		
		
		/*
		if(strlen($row->FATURA_NO) <= 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura No girmeden dosya teslim edildiye getirilemez!";	
			return $sonuc;
		}
		
		if($row->FATURA_TARIH == "" OR $row->FATURA_TARIH == "0000-00-00"){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Tarihi giriniz!";	
			return $sonuc;
		}
		*/
		if($row->CARI_ID <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari olmadan 'kiralama bitti' getirilemez!";	
			return $sonuc;
		}
		
		if($row->SON_KM <= $row->ILK_KM){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Son KM, ilk KM den büyük olmalı!";	
			return $sonuc;
		}
		
		/*
		// Cari Hareket ID
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID			= 1,
												FINANS_KALEMI_ID	= 6,
												ODEME_KANALI_ID		= NULL,
												KIRALAMA_ID			= :KIRALAMA_ID,
												ARAC_ID				= :ARAC_ID,
												CARI_ID				= :CARI_ID,
												TUTAR				= :TUTAR,
												FATURA_NO			= :FATURA_NO,
												FATURA_TARIH		= :FATURA_TARIH,
												PLAKA				= :PLAKA,
												DOSYA_NO			= :DOSYA_NO,
												ACIKLAMA			= :ACIKLAMA,
												KAYIT_YAPAN_ID		= :KAYIT_YAPAN_ID,
												KALEM_SAYISI		= 5,
												TARIH				= NOW(),
												KOD					= MD5(NOW())
												";
		$filtre[":KIRALAMA_ID"] 		= $row->ID;
		$filtre[":ARAC_ID"] 			= $row->ARAC_ID;
		$filtre[":CARI_ID"] 			= $row->CARI_ID;
		$filtre[":TUTAR"] 				= $row->FATURA_TUTAR;
		$filtre[":FATURA_NO"] 			= $row->FATURA_NO;
		$filtre[":FATURA_TARIH"] 		= $row->FATURA_TARIH;
		$filtre[":PLAKA"] 				= $row->PLAKA;
		$filtre[":DOSYA_NO"] 			= $row->DOSYA_NO;
		$filtre[":ACIKLAMA"] 			= "Otomatik Kiralama";
		$filtre[":KAYIT_YAPAN_ID"] 		= $_SESSION['kullanici_id'];
		$cari_ch_id = $this->cdbPDO->lastInsertId($sql, $filtre);
		
		// Cari Hareket Detay ID
		$filtre	= array();
		$sql = "DELETE FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :CARI_HAREKET_ID";
		$filtre[":CARI_HAREKET_ID"] 	= $cari_ch_id;
		$this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM PARCA WHERE TALEP_ID = :TALEP_ID";
		$filtre[":TALEP_ID"] 	= $row->ID;
		$rows_parca = $this->cdbPDO->rows($sql, $filtre); 
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET_DETAY SET CARI_HAREKET_ID = :CARI_HAREKET_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, KDV = :KDV, GTARIH = NOW()";
		$filtre[":CARI_HAREKET_ID"] = $cari_ch_id;
		$filtre[":SIRA"] 			= 1;
		$filtre[":PARCA_KODU"] 		= "KIRALAMA". $row->ID;
		$filtre[":PARCA_ADI"] 		= $row->PLAKA ." (".$row->VERILIS_TARIH ." ".$row->VERILIS_SAAT .", ". $row->IADE_TARIH ." ". $row->IADE_SAAT .")";
		$filtre[":ADET"] 			= 1;
		$filtre[":FIYAT"] 			= $row->ODENECEK_TUTAR;
		$filtre[":ISKONTO"] 		= 0;
		$filtre[":ISKONTOLU"] 		= $row->ODENECEK_TUTAR;
		$filtre[":TUTAR"] 			= $row->ODENECEK_TUTAR;
		$filtre[":KDV"] 			= 0;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		*/
		
		// Kiralama
		$filtre	= array();
		$sql = "UPDATE KIRALAMA SET SUREC_ID				= :SUREC_ID,
									KIRALAMA_BITTI_TARIH	= NOW(),	
									GTARIH					= NOW()
							WHERE ID = :ID
							";
		$filtre[":SUREC_ID"] 		= 10;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "KIRALAMA", "cKayıt");
		
		if($row->SON_KM > 0){
			$filtre	= array();
			$sql = "UPDATE ARAC SET SON_KM	= :SON_KM WHERE ID = :ID";
			$filtre[":SON_KM"] 		= $row->SON_KM;
			$filtre[":ID"] 			= $row->ARAC_ID;
			$this->cdbPDO->rowsCount($sql, $filtre);
		}		
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function kiralama_yansitma(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,5,8))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID, CARI_ID, PLAKA FROM KIRALAMA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, YANSITMA_TIP FROM YANSITMA_TIP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["yansitma_tip_id"];
		$row_yansitma_tip = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "INSERT INTO KIRALAMA_YANSITMA SET 	KIRALAMA_ID			= :KIRALAMA_ID,
													SIRA				= :SIRA,
													YANSITMA_TIP_ID		= :YANSITMA_TIP_ID,
													TUTAR				= :TUTAR,
						                            ACIKLAMA			= :ACIKLAMA
													";
		$filtre[":KIRALAMA_ID"] 		= $row->ID;
		$filtre[":SIRA"] 				= $_REQUEST["sira"];
		$filtre[":YANSITMA_TIP_ID"]		= $_REQUEST["yansitma_tip_id"];
		$filtre[":TUTAR"] 				= FormatSayi::sayi2db($_REQUEST["yansitma_tutar"]);
		$filtre[":ACIKLAMA"] 			= trim($_REQUEST["yansitma_aciklama"]);
		$yansitma_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID			= 1,
												FINANS_KALEMI_ID	= :FINANS_KALEMI_ID,
												ODEME_KANALI_ID		= :ODEME_KANALI_ID,
												TALEP_ID			= :TALEP_ID,
												CARI_ID				= :CARI_ID,
												TUTAR				= :TUTAR,
												FATURA_NO			= :FATURA_NO,
												FATURA_TARIH		= CURDATE(),
												PLAKA				= :PLAKA,
												ACIKLAMA			= :ACIKLAMA,
												KIRALAMA_ID			= :KIRALAMA_ID,
												YANSITMA_ID			= :YANSITMA_ID,
												KAYIT_YAPAN_ID		= :KAYIT_YAPAN_ID,
												TARIH				= NOW(),
												KOD					= MD5(NOW())
												";
		$filtre[":FINANS_KALEMI_ID"] 	= $_REQUEST["yansitma_tip_id"];
		$filtre[":ODEME_KANALI_ID"] 	= NULL;			
		$filtre[":TALEP_ID"] 			= 0;
		$filtre[":CARI_ID"] 			= $row->CARI_ID;
		$filtre[":TUTAR"] 				= FormatSayi::sayi2db($_REQUEST["yansitma_tutar"]);
		$filtre[":FATURA_NO"] 			= "Y" . $yansitma_id;
		$filtre[":PLAKA"] 				= $row->PLAKA;
		$filtre[":ACIKLAMA"] 			= trim($_REQUEST["yansitma_aciklama"]);
		$filtre[":KIRALAMA_ID"] 		= $row->ID;
		$filtre[":YANSITMA_ID"] 		= $yansitma_id;
		$filtre[":KAYIT_YAPAN_ID"] 		= $_SESSION['kullanici_id'];
		$this->cdbPDO->rowsCount($sql, $filtre); 
		
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "KIRALAMA", "cKayıt");
		
		if($yansitma_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Yansıtma Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function kiralama_notu_sil(){
		
		if(!in_array($_SESSION['yetki_id'], array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yöneticiden başka kimse silemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID FROM KIRALAMA_NOTU WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["kiralama_notu_id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep Notu bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM KIRALAMA_NOTU WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['kiralama_notu_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function kiralama_notu_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM KIRALAMA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(strlen($_REQUEST['kiralama_notu']) <= 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama notu boş bırakılamaz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO KIRALAMA_NOTU SET 	KIRALAMA_ID		= :KIRALAMA_ID,
												KIRALAMA_NOTU	= :KIRALAMA_NOTU,
												KULLANICI_ID	= :KULLANICI_ID
										 		";
		$filtre[":KIRALAMA_ID"] 	= $_REQUEST['id'];
		$filtre[":KIRALAMA_NOTU"] 	= trim($_REQUEST['kiralama_notu']);
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function arac_notu_sil(){
		
		if(!in_array($_SESSION['yetki_id'], array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yöneticiden başka kimse silemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID FROM ARAC_NOTU WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["arac_notu_id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep Notu bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM ARAC_NOTU WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['arac_notu_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function arac_notu_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM ARAC WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Araç bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(strlen($_REQUEST['arac_notu']) <= 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Araç notu boş bırakılamaz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO ARAC_NOTU SET 	ARAC_ID			= :ARAC_ID,
											ARAC_NOTU		= :ARAC_NOTU,
											KULLANICI_ID	= :KULLANICI_ID
										 		";
		$filtre[":ARAC_ID"] 		= $_REQUEST['id'];
		$filtre[":ARAC_NOTU"] 		= trim($_REQUEST['arac_notu']);
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function arac_personele_ver(){
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM ARAC WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Araç bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, CARI FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["personel_id"];
		$row_personel = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "INSERT INTO ARAC_NOTU SET 	ARAC_ID			= :ARAC_ID,
											ARAC_NOTU		= :ARAC_NOTU,
											KULLANICI_ID	= :KULLANICI_ID
										 		";
		$filtre[":ARAC_ID"] 		= $_REQUEST['id'];
		$filtre[":ARAC_NOTU"] 		= trim($_REQUEST['personel_arac_aciklama']) . "<br>". $row_personel->CARI . " ... " . ($_REQUEST["personel_arac_durum"]==1 ? "Verildi" : "Alındı");
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function ikame_kaydet(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,8))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		if(empty($_REQUEST['tahmini_iade_tarih'])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tahmini İade tarihi giriniz!";	
			return $sonuc;
		}
		
		if(FormatSayi::sayi2db($_REQUEST["son_km"]) > 0 AND FormatSayi::sayi2db($_REQUEST["son_km"]) < FormatSayi::sayi2db($_REQUEST["ilk_km"])){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Son KM, ilk KM den büyük olmalı!";	
			return $sonuc;
		}
		
		if(strlen($_REQUEST['surucu_ad_soyad']) <= 2){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sürücü ad ve soyadını giriniz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, PLAKA FROM ARAC WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["arac_id"];
		$row_arac = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row_arac->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Araç bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["talep_id"];
		$row_talep = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row_talep->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP_IKAME WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if($row->SUREC_ID == 10 AND !in_array($_SESSION['kullanici'], array("ADMIN"))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Teslim Edildi' sürecinde dosya değiştirilemez!";	
			return $sonuc;
		}
		
		if(is_null($row->ID)){
			$filtre	= array();
			$sql = "SELECT ID, KOD, PLAKA, TARIH FROM TALEP_IKAME WHERE TALEP_ID = :TALEP_ID AND SUREC_ID < 10 LIMIT 1";
			$filtre[":TALEP_ID"] 	= $_REQUEST["talep_id"];
			$row_acik = $this->cdbPDO->row($sql, $filtre); 
			
			if($row_acik->ID > 0){
				$sonuc["HATA"] 			= TRUE;
				$sonuc["ACIKLAMA"] 		= "<b>" . $row_acik->PLAKA . "</b> plakanın <b>". FormatTarih::tarih($row_acik->TARIH) ."</b> tarihinde açılmış ikamesi var!";	
				return $sonuc;
			}
		}
		
		if(TRUE){
			$filtre	= array();
			$sql = "SELECT ID, KOD, PLAKA, TARIH FROM TALEP_IKAME WHERE TALEP_ID != :TALEP_ID AND ARAC_ID = :ARAC_ID AND SUREC_ID < 10 LIMIT 1";
			$filtre[":TALEP_ID"] 	= $_REQUEST["talep_id"];
			$filtre[":ARAC_ID"] 	= $_REQUEST["arac_id"];
			$row_acik = $this->cdbPDO->row($sql, $filtre); 
			
			if($row_acik->ID > 0 AND !in_array($_SESSION['kullanici'], array("ADMIN"))){
				$sonuc["HATA"] 			= TRUE;
				$sonuc["ACIKLAMA"] 		= "<b>" . $row_acik->PLAKA . "</b> plakanın <b>". FormatTarih::tarih($row_acik->TARIH) ."</b> tarihinde açılmış ikamesi var!";	
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "SELECT ID, KOD, PLAKA, TARIH FROM KIRALAMA WHERE ARAC_ID = :ARAC_ID AND SUREC_ID < 10";
			$filtre[":ARAC_ID"] 	= $_REQUEST["arac_id"];
			$row_acik = $this->cdbPDO->row($sql, $filtre); 
			
			if($row_acik->ID > 0 AND !in_array($_SESSION['kullanici'], array("ADMIN"))){
				$sonuc["HATA"] 			= TRUE;
				$sonuc["ACIKLAMA"] 		= "<b>" . $row_acik->PLAKA . "</b> plakanın <b>". FormatTarih::tarih($row_acik->TARIH) ."</b> tarihinde bu araç kiralaması bulunmaktadır";	
				return $sonuc;
			}
		}	
		
		if(is_null($row->ID)){
			
			$filtre	= array();
			$sql = "INSERT INTO TALEP_IKAME SET PLAKA				= :PLAKA,
												ARAC_ID				= :ARAC_ID,
												TALEP_ID			= :TALEP_ID,
												SURUCU_AD_SOYAD		= :SURUCU_AD_SOYAD,
												SURUCU_TEL			= :SURUCU_TEL,
												SUREC_ID			= :SUREC_ID,
												ILK_KM				= :ILK_KM,
												SON_KM				= :SON_KM,
												VERILIS_TARIH		= :VERILIS_TARIH,
												VERILIS_SAAT		= :VERILIS_SAAT,
												IADE_TARIH			= :IADE_TARIH,
												IADE_SAAT			= :IADE_SAAT,
												TAHMINI_IADE_TARIH	= :TAHMINI_IADE_TARIH,
												TAHMINI_IADE_SAAT	= :TAHMINI_IADE_SAAT,
				                            	TALEP				= :TALEP,
												LASTIK				= :LASTIK,
												YEDEK_ANAHTAR		= :YEDEK_ANAHTAR,
												EKLEYEN_ID			= :EKLEYEN_ID,
												TARIH				= NOW(),
												KOD					= MD5(NOW()),
												GTARIH				= NOW()											
												";
			$filtre[":PLAKA"] 					= $row_arac->PLAKA;
			$filtre[":ARAC_ID"] 				= $_REQUEST["arac_id"];
			$filtre[":TALEP_ID"] 				= $row_talep->ID;
			$filtre[":SURUCU_AD_SOYAD"] 		= trim($_REQUEST["surucu_ad_soyad"]);
			$filtre[":SURUCU_TEL"] 				= $_REQUEST["surucu_tel"];
			$filtre[":SUREC_ID"] 				= 2;
			$filtre[":ILK_KM"] 					= FormatSayi::sayi2db($_REQUEST["ilk_km"]);
			$filtre[":SON_KM"] 					= FormatSayi::sayi2db($_REQUEST["son_km"]);
			$filtre[":VERILIS_TARIH"] 			= FormatTarih::nokta2db($_REQUEST["verilis_tarih"]);
			$filtre[":VERILIS_SAAT"] 			= $_REQUEST["verilis_saat"];
			$filtre[":IADE_TARIH"] 				= FormatTarih::nokta2db($_REQUEST["iade_tarih"]);
			$filtre[":IADE_SAAT"] 				= $_REQUEST["iade_saat"];
			$filtre[":TAHMINI_IADE_TARIH"] 		= FormatTarih::nokta2db($_REQUEST["tahmini_iade_tarih"]);
			$filtre[":TAHMINI_IADE_SAAT"] 		= $_REQUEST["tahmini_iade_saat"];
			$filtre[":TALEP"] 					= trim($_REQUEST["talep"]);
			$filtre[":LASTIK"]					= $_REQUEST["lastik"] == 1 ? 1 : 0;
			$filtre[":YEDEK_ANAHTAR"]			= $_REQUEST["yedek_anahtar"] == 1 ? 1 : 0;
			$filtre[":EKLEYEN_ID"] 				= $_SESSION["kullanici_id"];
			$ikame_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
			$filtre	= array();
			$sql = "SELECT * FROM TALEP_IKAME WHERE ID = :ID";
			$filtre[":ID"] 	= $ikame_id;
			$row = $this->cdbPDO->row($sql, $filtre); 
			
		} else {
			
			if($row->KOD != $_REQUEST['kod']){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
				return $sonuc;
			}
			
			$filtre	= array();
			$sql = "UPDATE TALEP_IKAME SET 	PLAKA				= :PLAKA,
											ARAC_ID				= :ARAC_ID,
											TALEP_ID			= :TALEP_ID,
											SURUCU_AD_SOYAD		= :SURUCU_AD_SOYAD,
											SURUCU_TEL			= :SURUCU_TEL,
											SUREC_ID			= :SUREC_ID,
											ILK_KM				= :ILK_KM,
											SON_KM				= :SON_KM,
											VERILIS_TARIH		= :VERILIS_TARIH,
											VERILIS_SAAT		= :VERILIS_SAAT,
											IADE_TARIH			= :IADE_TARIH,
											IADE_SAAT			= :IADE_SAAT,
											TAHMINI_IADE_TARIH	= :TAHMINI_IADE_TARIH,
											TAHMINI_IADE_SAAT	= :TAHMINI_IADE_SAAT,
					                        TALEP				= :TALEP,
											LASTIK				= :LASTIK,
											YEDEK_ANAHTAR		= :YEDEK_ANAHTAR,
											GTARIH				= NOW()			
									WHERE ID = :ID
									";
			$filtre[":PLAKA"] 					= $row_arac->PLAKA;
			$filtre[":ARAC_ID"] 				= $_REQUEST["arac_id"];
			$filtre[":TALEP_ID"] 				= $row_talep->ID;
			$filtre[":SURUCU_AD_SOYAD"] 		= trim($_REQUEST["surucu_ad_soyad"]);
			$filtre[":SURUCU_TEL"] 				= $_REQUEST["surucu_tel"];
			$filtre[":SUREC_ID"] 				= 2;
			$filtre[":ILK_KM"] 					= FormatSayi::sayi2db($_REQUEST["ilk_km"]);
			$filtre[":SON_KM"] 					= FormatSayi::sayi2db($_REQUEST["son_km"]);
			$filtre[":VERILIS_TARIH"] 			= FormatTarih::nokta2db($_REQUEST["verilis_tarih"]);
			$filtre[":VERILIS_SAAT"] 			= $_REQUEST["verilis_saat"];
			$filtre[":IADE_TARIH"] 				= FormatTarih::nokta2db($_REQUEST["iade_tarih"]);
			$filtre[":IADE_SAAT"] 				= $_REQUEST["iade_saat"];
			$filtre[":TAHMINI_IADE_TARIH"] 		= FormatTarih::nokta2db($_REQUEST["tahmini_iade_tarih"]);
			$filtre[":TAHMINI_IADE_SAAT"] 		= $_REQUEST["tahmini_iade_saat"];
			$filtre[":TALEP"] 					= trim($_REQUEST["talep"]);
			$filtre[":LASTIK"]					= $_REQUEST["lastik"] == 1 ? 1 : 0;
			$filtre[":YEDEK_ANAHTAR"]			= $_REQUEST["yedek_anahtar"] == 1 ? 1 : 0;
			$filtre[":ID"] 						= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	IKAME_ID				= :IKAME_ID,
									IKAME_ARAC_ID			= :IKAME_ARAC_ID,
									IKAME_PLAKA				= :IKAME_PLAKA,
									IKAME_VERILIS_TARIH		= :IKAME_VERILIS_TARIH,
									IKAME_VERILIS_SAAT		= :IKAME_VERILIS_SAAT,
									IKAME_GELIS_TARIH		= :IKAME_GELIS_TARIH,
									IKAME_KESIN_TARIH		= :IKAME_KESIN_TARIH,
									GTARIH					= NOW()
							WHERE ID = :ID
							";
		$filtre[":IKAME_ID"] 			= $row->ID;
		$filtre[":IKAME_ARAC_ID"] 		= $row_arac->ID;
		$filtre[":IKAME_PLAKA"] 		= $row_arac->PLAKA;
		$filtre[":IKAME_VERILIS_TARIH"] = FormatTarih::nokta2db($_REQUEST["verilis_tarih"]);
		$filtre[":IKAME_VERILIS_SAAT"] 	= $_REQUEST["verilis_saat"];
		$filtre[":IKAME_GELIS_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["tahmini_iade_tarih"]);
		$filtre[":IKAME_KESIN_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["iade_tarih"]);
		$filtre[":ID"] 					= $row_talep->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($ikame_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi. İkame No: $ikame_id";
			$sonuc["URL"] 		= "/ikame/ikame.do?route=ikame/ikame_takip&id={$row->ID}&kod={$row->KOD}";
		} else if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "İkame Kaydedildi.";
			$sonuc["URL"] 		= "/ikame/ikame.do?route=ikame/ikame_takip&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function ikame_sil(){
		
		if(!in_array($_SESSION['yetki_id'], array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Randevuluya çevirme yetkiniz yok!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM TALEP_IKAME WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İkame bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(!in_array($row->SUREC_ID, array(2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Araç Seviste,Araç Bekliyor yada Randevulu' olması gerekiyor!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM TALEP_IKAME WHERE ID = :ID";
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function ikame_notu_sil(){
		
		if(!in_array($_SESSION['yetki_id'], array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yöneticiden başka kimse silemez!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID FROM IKAME_NOTU WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["ikame_notu_id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ikame Notu bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM IKAME_NOTU WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['ikame_notu_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function ikame_notu_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM TALEP_IKAME WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İkame bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(strlen($_REQUEST['ikame_notu']) <= 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İkame notu boş bırakılamaz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO IKAME_NOTU SET 	IKAME_ID		= :IKAME_ID,
											IKAME_NOTU		= :IKAME_NOTU,
											KULLANICI_ID	= :KULLANICI_ID
										 		";
		$filtre[":IKAME_ID"] 		= $_REQUEST['id'];
		$filtre[":IKAME_NOTU"] 	= trim($_REQUEST['ikame_notu']);
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function ikame_bitti(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,4,8))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID, TALEP_ID, PLAKA, ILK_KM, SON_KM, ARAC_ID FROM TALEP_IKAME WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İkame bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if($row->SUREC_ID == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İkame bittiği için değişiklik yapılamaz!";	
			return $sonuc;
		}
		
		if($row->TALEP_ID <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep No olmadan 'ikame bitti' getirilemez!";	
			return $sonuc;
		}
		
		if($row->SON_KM <= $row->ILK_KM){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Son KM, ilk KM den büyük olmalı!";	
			return $sonuc;
		}
		
		if(strlen($row->IADE_TARIH) == 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "İkame bitiş tarihini giriniz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	IKAME_ID				= 0,
									IKAME_ARAC_ID			= 0,
									IKAME_PLAKA				= '',
									IKAME_VERILIS_TARIH		= NULL,
									IKAME_VERILIS_SAAT		= 0,
									IKAME_GELIS_TARIH		= NULL,
									IKAME_GELIS_SAAT		= 0
							WHERE ID = :ID
							";
		$filtre[":ID"] 				= $row->TALEP_ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre	= array();
		$sql = "UPDATE TALEP_IKAME SET 	SUREC_ID			= :SUREC_ID,
										IKAME_BITTI_TARIH	= NOW(),	
										GTARIH				= NOW()
								WHERE ID = :ID
								";
		$filtre[":SUREC_ID"] 		= 10;
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "IKAME", "cKayıt");
		
		if($row->SON_KM > 0){
			$filtre	= array();
			$sql = "UPDATE ARAC SET SON_KM = :SON_KM WHERE ID = :ID";
			$filtre[":SON_KM"] 		= $row->SON_KM;
			$filtre[":ID"] 			= $row->ARAC_ID;
			$this->cdbPDO->rowsCount($sql, $filtre);
		}	
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function ikame_yansitma(){
		
		if(!in_array($_SESSION['yetki_id'],array(1,2,3,8))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kaydetme yetkiniz bulunmamakta!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID, CARI_ID, PLAKA FROM KIRALAMA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, YANSITMA_TIP FROM YANSITMA_TIP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["yansitma_tip_id"];
		$row_yansitma_tip = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "INSERT INTO KIRALAMA_YANSITMA SET 	KIRALAMA_ID			= :KIRALAMA_ID,
													SIRA				= :SIRA,
													YANSITMA_TIP_ID		= :YANSITMA_TIP_ID,
													TUTAR				= :TUTAR,
						                            ACIKLAMA			= :ACIKLAMA
													";
		$filtre[":KIRALAMA_ID"] 		= $row->ID;
		$filtre[":SIRA"] 				= $_REQUEST["sira"];
		$filtre[":YANSITMA_TIP_ID"]		= $_REQUEST["yansitma_tip_id"];
		$filtre[":TUTAR"] 				= FormatSayi::sayi2db($_REQUEST["yansitma_tutar"]);
		$filtre[":ACIKLAMA"] 			= trim($_REQUEST["yansitma_aciklama"]);
		$yansitma_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID			= 1,
												FINANS_KALEMI_ID	= :FINANS_KALEMI_ID,
												ODEME_KANALI_ID		= :ODEME_KANALI_ID,
												TALEP_ID			= :TALEP_ID,
												CARI_ID				= :CARI_ID,
												TUTAR				= :TUTAR,
												FATURA_NO			= :FATURA_NO,
												FATURA_TARIH		= CURDATE(),
												PLAKA				= :PLAKA,
												ACIKLAMA			= :ACIKLAMA,
												KIRALAMA_ID			= :KIRALAMA_ID,
												YANSITMA_ID			= :YANSITMA_ID,
												KAYIT_YAPAN_ID		= :KAYIT_YAPAN_ID,
												TARIH				= NOW(),
												KOD					= MD5(NOW())
												";
		$filtre[":FINANS_KALEMI_ID"] 	= 1;
		$filtre[":ODEME_KANALI_ID"] 	= NULL;			
		$filtre[":TALEP_ID"] 			= $row->ID;
		$filtre[":CARI_ID"] 			= $row->CARI_ID;
		$filtre[":TUTAR"] 				= FormatSayi::sayi2db($_REQUEST["yansitma_tutar"]);
		$filtre[":FATURA_NO"] 			= "Y" . $yansitma_id;
		$filtre[":PLAKA"] 				= $row->PLAKA;
		$filtre[":ACIKLAMA"] 			= trim($_REQUEST["yansitma_aciklama"]);
		$filtre[":KIRALAMA_ID"] 		= $row->ID;
		$filtre[":YANSITMA_ID"] 		= $yansitma_id;
		$filtre[":KAYIT_YAPAN_ID"] 		= $_SESSION['kullanici_id'];
		$this->cdbPDO->rowsCount($sql, $filtre); 
		
		$this->fncIslemLog($row->ID, $this->cdbPDO->getSQL($sql, $filtre), $row, __FUNCTION__, "KIRALAMA", "cKayıt");
		
		if($yansitma_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Yansıtma Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function kiralama_sil(){
		
		if(!in_array($_SESSION['yetki_id'], array(1,2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yetkiniz yok!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, KOD, SUREC_ID FROM KIRALAMA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kiralama bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		if(!in_array($row->SUREC_ID, array(2))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "'Araç Seviste,Araç Bekliyor yada Randevulu' olması gerekiyor!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM KIRALAMA WHERE ID = :ID";
		$filtre[":ID"] 				= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}
	
	public function segment_fiyat_hesapla(){
		
		$filtre	= array();
		$sql = "SELECT ID, SEGMENT, DATEDIFF(:BIT_TARIH, :BAS_TARIH) AS GUN FROM ARAC WHERE ID = :ID";
		$filtre[":BIT_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["iade_tarih"]);
		$filtre[":BAS_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["verilis_tarih"]);
		$filtre[":ID"] 	= $_REQUEST["arac_id"];
		$row_arac = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row_arac->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Araç bulunamadı!";	
			return $sonuc;
		}
		
		if(is_null($row_arac->SEGMENT)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Araç segmenti seçilmemiş!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, (FIYAT * :GUN * (100 - :ISKONTO)/100) AS FIYAT FROM SEGMENT_FIYAT WHERE SEGMENT = :SEGMENT AND :GUN >= GUN ORDER BY GUN DESC LIMIT 1";
		$filtre[":SEGMENT"] 	= $row_arac->SEGMENT;
		$filtre[":GUN"] 		= $row_arac->GUN;
		$filtre[":ISKONTO"]		= $_REQUEST["iskonto"];
		$row_fiyat = $this->cdbPDO->row($sql, $filtre); 
		
		
		if($row_fiyat->FIYAT > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Bulundu.";
			$sonuc["FIYAT"] 	= $row_fiyat->FIYAT;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fiyat 0 TL!";
		}
		
		return $sonuc;
		
	}
	
	public function talep_efatura_entegrasyon(){
		
		if(1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "eFatura Entegrasyon Kapalı!";	
			return $sonuc;
		}
		
		$row 				= $this->cSubData->getTalep($_REQUEST);
		$row_cari			= $this->cSubData->getTalepCari($_REQUEST);
		$rows_parca			= $this->cSubData->getTalepParcalar($_REQUEST);
		$rows_iscilik		= $this->cSubData->getTalepIscilikler($_REQUEST);
		/*
		if(strlen($row->EFATURA_UUID) > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Daha önce entegre edilmiş!";	
			return $sonuc;
		}
		*/
		if($row->FATURA_TUTAR <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Tutar '0' TL olamaz!";	
			return $sonuc;
		}
		
		if(strlen($row->DOSYA_NO) < 3 AND $row->SIGORTA_ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sigorta firması seçili Dosya No giriniz!";	
			return $sonuc;
		}
		
		if(strlen(trim($row_cari->TCK)) < 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari TCK/VKN bilgisi doğru girilmeli!";	
			return $sonuc;
		}
		
		if(strlen($row_cari->TCK) == 10 AND strlen($row_cari->CARI) < 3) {
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari adı girilmemiş!";	
			return $sonuc;
		}
		
		if(strlen($row_cari->TCK) == 11 AND (strlen($row_cari->AD) < 3 OR strlen($row_cari->SOYAD) < 3)) {
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari adı/soyadı 3 karakterden fazla olmalı!";	
			return $sonuc;
		}
		
		if(strlen($row_cari->ADRES) < 5){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cariye adres giriniz!";	
			return $sonuc;
		}
		
		if(strlen($row_cari->VD) < 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Vergi Dairesi giriniz!";	
			return $sonuc;
		}
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if(count($rows_parca) <= 0 AND count($rows_iscilik) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Parça bulunamadı!";	
			return $sonuc;
		}
		
		if($row->TEVKIFAT_ID > 0 AND $row->FATURA_TUTAR <= 2000){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "2.000TL den küçük tevfikat faturası kesilemez!";	
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT * FROM TEVKIFAT WHERE ID = :ID";
		$filtre[":ID"] 	= $row->TEVKIFAT_ID;
		$row_tevkifat = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_tevkifat->ID > 0){
			$KDV_CARPAN = $row_tevkifat->ORAN;
			$KDV_ORAN	= ($row_tevkifat->ORAN - 1) * 100;
		} else {
			$KDV_CARPAN = 1.18;
			$KDV_ORAN	= 18;
		}
		
		$row->KDV_ORAN2 = 18;
		
		// Wsdl Bilgileri
		$row_wsdl->URL 			= "http://efatura.uyumsoft.com.tr/Services/BasicIntegration?singleWsdl";
		$row_wsdl->KULLANICI 	= $this->rSite->UYUMSOFT_WSDL_KULLANICI;
		$row_wsdl->SIFRE		= $this->rSite->UYUMSOFT_WSDL_SIFRE;
		
		// Gönderici Bilgileri
		if($this->rSite->ID == 2){	    
			$row_site->FIRMA_ADI	= "PASHA Motorlu Araçlar San. Tic. Ltd. Şti.";
			$row_site->ADRES		= "Muratpaşa Mh. Rami Kışla Cad. No:97/1-1 Bayrampaşa / İSTANBUL";
			$row_site->TCK			= "7220496921";
			$row_site->VD			= "BAYRAMPAŞA";
			$row_site->FIRMA_NO		= "1/17";
			$row_site->FIRMA_ILCE	= "BAYRAMPAŞA";
			$row_site->FIRMA_IL		= "İSTANBUL";
			
		} else if($this->rSite->ID == 3){
			$row_site->FIRMA_ADI	= "Serdar Motorlu Araçlar San. Tic. Ltd. Şti.";
			$row_site->ADRES		= "Muratpaşa Mh. Rami Kışla Cad. No:97/1-1 Bayrampaşa / İSTANBUL";
			$row_site->TCK			= "7610917706";
			$row_site->VD			= "TUNA";
			$row_site->FIRMA_NO		= "1/17";
			$row_site->FIRMA_ILCE	= "BAYRAMPAŞA";
			$row_site->FIRMA_IL		= "İSTANBUL";
			
			//$row->FATURA_NOT2	="İŞ BANKASI HESAP BİLGİSİ - SERDAR MOTORLU ARAÇLAR - IBAN: TR07 0006 4000 0011 0641 6241 34";
		}
				
		// Fatura Bilgileri
		$row->FATURA_TARIH		= date("Y-m-d");
		$row->FATURA_SAAT		= date("H:i:s");	
		$row->FATURA_KDV		= $KDV_ORAN;
		$row->ACIKLAMA			= $row->ID; 
		$row->FATURA_ISIM		= "{$row->PLAKA}_{$row->ID}_{$this->rSite->BASLIK_KISA}"; 
		$row->FATURA_NOT		= "PLAKA: ". $row->PLAKA . ", KM: ". FormatSayi::sayi($row->KM,0) .", SASI: ". $row->SASI_NO .", DN: ". $row->DOSYA_NO;
		$row->FATURA_KDV_TUTAR	= FormatSayi::nokta2(($row->FATURA_TUTAR / $KDV_CARPAN) * ($row->FATURA_KDV / 100));
			
		if($row->SIGORTA_ID > 0){
			$row->FATURA_NOT	.= ", SİGORTA: {$row->SIGORTA_FIRMA}, EKSPER: {$row->EKSPER}"; 
		}
			
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
		
		if($row_tevkifat->ID > 0){
			$row->FATURA_TIP = "TEVKIFAT";
		} else {
			$row->FATURA_TIP = "SATIS";
		}
		
		//var_dump2($row_cari);die();
		$TOPLAM_BIRIM_ISKONTOLU = 0;
		$TOPLAM_BIRIM_FIYAT = 0;
		$SIRA = 0;
		$row_wsdl->KALEM = "";
		foreach($rows_parca as $key => $row_parca){
			$SIRA++;
			$TOPLAM_BIRIM_FIYAT += $row_parca->FIYAT * $row_parca->ADET;
			$TOPLAM_BIRIM_ISKONTOLU += $row_parca->ISKONTOLU * $row_parca->ADET;
			$row_wsdl->KALEM.= '
							<InvoiceLine xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
								<ID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $SIRA .'</ID>
								<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">Satır Notu</Note>
								<InvoicedQuantity unitCode="NIU" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_parca->ADET.'</InvoicedQuantity>
								<Price>
									<PriceAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($row_parca->FIYAT).'</PriceAmount>
								</Price>
								<AllowanceCharge>
									<ChargeIndicator xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">false</ChargeIndicator>
									<MultiplierFactorNumeric xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. (FormatSayi::iskontoOran($row_parca->FIYAT,$row_parca->ISKONTOLU)/100) .'</MultiplierFactorNumeric>
									<Amount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2(($row_parca->FIYAT - $row_parca->ISKONTOLU) * $row_parca->ADET).'</Amount>
								</AllowanceCharge>
								
								<TaxTotal>
									<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></TaxAmount>
									<TaxSubtotal>
										<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. FormatSayi::nokta2($row_parca->TUTAR - ($row_parca->ISKONTOLU * $row_parca->ADET)) .'</TaxAmount>
										<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row->KDV_ORAN2 .'</Percent>
										<TaxCategory>
											<TaxScheme>
												<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">KDV</Name>
												<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">0015</TaxTypeCode>
											</TaxScheme>
										</TaxCategory>
									</TaxSubtotal>
								</TaxTotal>
								';
								
			if($row_tevkifat->ID > 0){
				$row_wsdl->KALEM.= '
								<WithholdingTaxTotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
									<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row_parca->TUTAR - ($row_parca->ISKONTOLU * $row_parca->ADET)) .'</TaxAmount>
									<TaxSubtotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
										<TaxableAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row_parca->ISKONTOLU * $row_parca->ADET * 0.18) .'</TaxableAmount>
										<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row_parca->TUTAR - ($row_parca->ISKONTOLU * $row_parca->ADET)) .'</TaxAmount>
										<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_ORAN .'</Percent>
										<TaxCategory xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
											<TaxScheme xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
												<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT .'</Name>
												<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_KODU .'</TaxTypeCode>
											</TaxScheme>
										</TaxCategory>
									</TaxSubtotal>
								</WithholdingTaxTotal>
								';
			}
			
			$row_wsdl->KALEM.= '<Item>
									<Description xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_parca->PARCA_KODU.'</Description>
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
								<LineExtensionAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($row_parca->ISKONTOLU * $row_parca->ADET).'</LineExtensionAmount>
							</InvoiceLine>
							';
		}
		
		foreach($rows_iscilik as $key => $row_iscilik){
			$SIRA++;
			$TOPLAM_BIRIM_FIYAT += $row_iscilik->FIYAT * $row_iscilik->ADET;
			$TOPLAM_BIRIM_ISKONTOLU += $row_iscilik->ISKONTOLU * $row_iscilik->ADET;
			$row_wsdl->KALEM.= '
							<InvoiceLine xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
								<ID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $SIRA .'</ID>
								<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">Satır Notu</Note>
								<InvoicedQuantity unitCode="NIU" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_iscilik->ADET.'</InvoicedQuantity>
								<Price>
									<PriceAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($row_iscilik->FIYAT).'</PriceAmount>
								</Price>
								<AllowanceCharge>
									<ChargeIndicator xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">false</ChargeIndicator>
									<MultiplierFactorNumeric xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. (FormatSayi::iskontoOran($row_iscilik->FIYAT,$row_iscilik->ISKONTOLU)/100) .'</MultiplierFactorNumeric>
									<Amount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2(($row_iscilik->FIYAT - $row_iscilik->ISKONTOLU) * $row_iscilik->ADET).'</Amount>
								</AllowanceCharge>
								
								<TaxTotal>
									<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></TaxAmount>
									<TaxSubtotal>
										<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. FormatSayi::nokta2($row_iscilik->TUTAR - ($row_iscilik->ISKONTOLU * $row_iscilik->ADET)) .'</TaxAmount>
										<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row->KDV_ORAN2 .'</Percent>
										<TaxCategory>
											<TaxScheme>
												<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">KDV</Name>
												<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">0015</TaxTypeCode>
											</TaxScheme>
										</TaxCategory>
									</TaxSubtotal>
								</TaxTotal>';
								
			
			if($row_tevkifat->ID > 0){
				$row_wsdl->KALEM.= '
								<WithholdingTaxTotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
									<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row_iscilik->TUTAR - ($row_iscilik->ISKONTOLU * $row_iscilik->ADET)) .'</TaxAmount>
									<TaxSubtotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
										<TaxableAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row_iscilik->ISKONTOLU * $row_iscilik->ADET * 0.18) .'</TaxableAmount>
										<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row_iscilik->TUTAR - ($row_iscilik->ISKONTOLU * $row_iscilik->ADET)) .'</TaxAmount>
										<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_ORAN .'</Percent>
										<TaxCategory xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
											<TaxScheme xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
												<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT .'</Name>
												<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_KODU .'</TaxTypeCode>
											</TaxScheme>
										</TaxCategory>
									</TaxSubtotal>
								</WithholdingTaxTotal>
								';
			}
			
			$row_wsdl->KALEM.= '<Item>
									<Description xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_iscilik->PARCA_KODU.'</Description>
									<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_iscilik->PARCA_ADI.'</Name>
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
								
								<LineExtensionAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($row_iscilik->ISKONTOLU * $row_iscilik->ADET).'</LineExtensionAmount>
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
							<InvoiceTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_TIP.'</InvoiceTypeCode>
							<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_NOT.'</Note>
							<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_NOT2.'</Note>					
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
									<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->KDV_ORAN2.'</Percent>
									<TaxCategory>
										<TaxScheme>
											<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">KDV</Name>
											<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">0015</TaxTypeCode>
										</TaxScheme>
									</TaxCategory>
								</TaxSubtotal>
							</TaxTotal>
							';
								
		if($row_tevkifat->ID > 0){
			$row_wsdl->XML.= '<WithholdingTaxTotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
									<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($TOPLAM_BIRIM_ISKONTOLU * ($row_tevkifat->ORAN - 1)) .'</TaxAmount>
									<TaxSubtotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
										<TaxableAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row->FATURA_KDV_TUTAR) .'</TaxableAmount>
										<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($TOPLAM_BIRIM_ISKONTOLU * ($row_tevkifat->ORAN - 1)) .'</TaxAmount>
										<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_ORAN .'</Percent>
										<TaxCategory xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
											<TaxScheme xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
												<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT .'</Name>
												<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_KODU .'</TaxTypeCode>
											</TaxScheme>
										</TaxCategory>
									</TaxSubtotal>
								</WithholdingTaxTotal>
								';
		}
		
		$row_wsdl->XML.= '<LegalMonetaryTotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
								<LineExtensionAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($TOPLAM_BIRIM_FIYAT).'</LineExtensionAmount>
								<TaxExclusiveAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($TOPLAM_BIRIM_ISKONTOLU).'</TaxExclusiveAmount>
								<TaxInclusiveAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($TOPLAM_BIRIM_ISKONTOLU * ((100 + $row->KDV_ORAN2) / 100)).'</TaxInclusiveAmount>
								<AllowanceTotalAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($TOPLAM_BIRIM_FIYAT - $TOPLAM_BIRIM_ISKONTOLU).'</AllowanceTotalAmount>
								<PayableAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($row->FATURA_TUTAR).'</PayableAmount>
							</LegalMonetaryTotal>
							'. $row_wsdl->KALEM .'
						</Invoice>
						<TargetCustomer '.$row_cari->TCKN_VKN.'="'.$row_cari->TCK.'" Alias="" Title="'.$row->FATURA_ISIM.'"/>
						<EArchiveInvoiceInfo DeliveryType="Electronic"/>
						<Scenario>Automated</Scenario>
					</InvoiceInfo>
				</invoices>
			</SendInvoice>
		</s:Body>
		</s:Envelope>';
		
		//var_dump2($row_wsdl->XML);die();
		
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
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPGET, false);
	    curl_setopt($ch, CURLOPT_VERBOSE, true);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $row_wsdl->XML);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $row_wsdl->BASLIK); 
	   	$result = curl_exec($ch); 
	    curl_close($ch);
		//var_dump2($result);
	    $result = str_replace("<s:Body","<body",$result);
		$result = str_replace("</s:Body","</body>",$result);
	    $result = simplexml_load_string($result);
		
	    $curl_result	= $result->body->SendInvoiceResponse->SendInvoiceResult["IsSucceded"];
		$hata			= $result->body->SendInvoiceResponse->SendInvoiceResult["Message"];
		$efatid			= $result->body->SendInvoiceResponse->SendInvoiceResult->Value["Id"];
		$efatno			= $result->body->SendInvoiceResponse->SendInvoiceResult->Value["Number"];
		
		$this->fncIslemLog($row->ID, $result, $row, __FUNCTION__, "TALEP_EFATURA_ENTEGRASYON", "cKayıt");
		
		if($curl_result == 'true'){
			$filtre	= array();
			$sql = "UPDATE TALEP SET 	FATURA_NO				= :FATURA_NO,
										FATURA_TARIH			= :FATURA_TARIH,
			                            FATURA_ACIKLAMA			= :FATURA_ACIKLAMA,
			                            FATURA_KES				= :FATURA_KES,
			                            EFATURA_UUID			= :EFATURA_UUID                           
								WHERE ID = :ID
								";
			$filtre[":FATURA_NO"] 		= $efatno;
			$filtre[":FATURA_TARIH"] 	= date("Y-m-d");
			$filtre[":FATURA_ACIKLAMA"] = "Efatura entegre edildi.";
			$filtre[":FATURA_KES"]		= 1;
			$filtre[":EFATURA_UUID"] 	= $efatid;
			$filtre[":ID"] 				= $row->ID;
			$this->cdbPDO->rowsCount($sql, $filtre);
			
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET FATURA_NO				= :FATURA_NO,
											FATURA_TARIH			= :FATURA_TARIH,
				                            FATURA_KES				= :FATURA_KES,
				                            EFATURA_UUID			= :EFATURA_UUID                           
									WHERE TALEP_ID = :TALEP_ID
									";
			$filtre[":FATURA_NO"] 		= $efatno;
			$filtre[":FATURA_TARIH"] 	= date("Y-m-d");
			$filtre[":FATURA_KES"]		= 1;
			$filtre[":EFATURA_UUID"] 	= $efatid;
			$filtre[":TALEP_ID"] 		= $row->ID;
			$this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		
		if($curl_result == 'true'){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "<b> $efatno </b> fatura no ile entegre oldu.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Entegre Hata: " . $hata;
		}
		
		return $sonuc;
		
	}
	
	public function satis_efatura_entegrasyon(){
		
		if(1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "eFatura Entegrasyon Kapalı!";	
			return $sonuc;
		}
		
		$row 				= $this->cSubData->getCariHareket($_REQUEST);
		$row_cari			= $this->cSubData->getCariHareketCari($_REQUEST);
		$rows_parca			= $this->cSubData->getCariHareketDetay($_REQUEST);
		/*
		if(strlen($row->EFATURA_UUID) > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Daha önce entegre edilmiş!";	
			return $sonuc;
		}
		*/
		if($row->TUTAR <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Tutar '0' TL olamaz!";	
			return $sonuc;
		}
		
		if(strlen(trim($row_cari->TCK)) < 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari TCK/VKN bilgisi doğru girilmeli!";	
			return $sonuc;
		}
		
		if(strlen($row_cari->TCK) == 10 AND strlen($row_cari->CARI) < 3) {
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari adı girilmemiş!";	
			return $sonuc;
		}
		
		if(strlen($row_cari->TCK) == 11 AND (strlen($row_cari->AD) < 3 OR strlen($row_cari->SOYAD) < 3)) {
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari adı/soyadı 3 karakterden fazla olmalı!";	
			return $sonuc;
		}
		
		if(strlen($row_cari->ADRES) < 5){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cariye adres giriniz!";	
			return $sonuc;
		}
		
		if(strlen($row_cari->VD) < 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Vergi Dairesi giriniz!";	
			return $sonuc;
		}
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura bulunamadı!";	
			return $sonuc;
		}
		
		if(count($rows_parca) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fatura Detay bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM TEVKIFAT WHERE ID = :ID";
		$filtre[":ID"] 	= $row->TEVKIFAT_ID;
		$row_tevkifat = $this->cdbPDO->row($sql, $filtre); 
		
		if($row_tevkifat->ID > 0){
			$KDV_CARPAN = $row_tevkifat->ORAN;
			$KDV_ORAN	= ($row_tevkifat->ORAN - 1) * 100;
		} else {
			$KDV_CARPAN = (100 + $row->KDV) / 100;
			$KDV_ORAN	= $row->KDV;
		}
		
		$row->KDV_ORAN2 = $row->KDV;
		
		// Wsdl Bilgileri
		$row_wsdl->URL 			= "http://efatura.uyumsoft.com.tr/Services/BasicIntegration?singleWsdl";
		$row_wsdl->KULLANICI 	= $this->rSite->UYUMSOFT_WSDL_KULLANICI;
		$row_wsdl->SIFRE		= $this->rSite->UYUMSOFT_WSDL_SIFRE;
		
		// Gönderici Bilgileri
		if($this->rSite->ID == 2){
			$row_site->FIRMA_ADI	= "PASHA Motorlu Araçlar San. Tic. Ltd. Şti.";
			$row_site->ADRES		= "Muratpaşa Mh. Rami Kışla Cad. No:97/1-1 Bayrampaşa / İSTANBUL";
			$row_site->TCK			= "7220496921";
			$row_site->VD			= "BAYRAMPAŞA";
			$row_site->FIRMA_NO		= "1/17";
			$row_site->FIRMA_ILCE	= "BAYRAMPAŞA";
			$row_site->FIRMA_IL		= "İSTANBUL";
			
		} else if($this->rSite->ID == 3){
			$row_site->FIRMA_ADI	= "Serdar Motorlu Araçlar San. Tic. Ltd. Şti.";
			$row_site->ADRES		= "Muratpaşa Mh. Rami Kışla Cad. No:97/1-1 Bayrampaşa / İSTANBUL";
			$row_site->TCK			= "7610917706";
			$row_site->VD			= "TUNA";
			$row_site->FIRMA_NO		= "1/17";
			$row_site->FIRMA_ILCE	= "BAYRAMPAŞA";
			$row_site->FIRMA_IL		= "İSTANBUL";
			
			//$row->FATURA_NOT2	="İŞ BANKASI HESAP BİLGİSİ - SERDAR MOTORLU ARAÇLAR - IBAN: TR07 0006 4000 0011 0641 6241 34";
			
		}
		
		$filtre	= array();
		$sql = "SELECT 
					SUM(IF(CH.TEVKIFAT_ID > 0, CHD.TUTAR / T.ORAN * (T.ORAN-1) , CHD.TUTAR / (100 + CHD.KDV) * CHD.KDV)) AS KDV_TUTAR
				FROM CARI_HAREKET_DETAY AS CHD 
					LEFT JOIN CARI_HAREKET AS CH ON CH.ID = CHD.CARI_HAREKET_ID
					LEFT JOIN TEVKIFAT AS T ON T.ID = CH.TEVKIFAT_ID
				WHERE CHD.CARI_HAREKET_ID = :ID
				";
		$filtre[":ID"] 				= $row->ID;
		$row_fatura_toplam = $this->cdbPDO->row($sql, $filtre); 
				
		// Fatura Bilgileri
		$row->FATURA_TARIH		= date("Y-m-d");
		$row->FATURA_SAAT		= date("H:i:s");	
		$row->FATURA_KDV		= $row->KDV;
		$row->FATURA_ISIM		= "{$row->PLAKA}_{$row->ID}_{$this->rSite->BASLIK_KISA}"; 
		$row->FATURA_NOT		= "PLAKA: ". $row->PLAKA . ", ". $row->ACIKLAMA;
		$row->FATURA_TUTAR		= $row->TUTAR;
		$row->FATURA_KDV_TUTAR	= FormatSayi::nokta2(($row->FATURA_TUTAR / $KDV_CARPAN) * ($row->FATURA_KDV / 100));
		
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
		
		//var_dump2($rows_parca);die();
		$TOPLAM_BIRIM_FIYAT = 0;
		$TOPLAM_BIRIM_ISKONTOLU = 0;
		$SIRA = 0;
		$row_wsdl->KALEM = "";
		foreach($rows_parca as $key => $row_parca){
			$SIRA++;
			$TOPLAM_BIRIM_FIYAT += $row_parca->FIYAT * $row_parca->ADET;
			$TOPLAM_BIRIM_ISKONTOLU += $row_parca->ISKONTOLU * $row_parca->ADET;
			if($row_tevkifat->ID > 0){
				$row->FATURA_TIP = "TEVKIFAT";
			} else if($row_parca->KDV == 0){
				$TAX_EXEMPTON_REASON = '<TaxExemptionReasonCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">350</TaxExemptionReasonCode>
										<TaxExemptionReason xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">350 sayılı kanuna istinaden</TaxExemptionReason>
										';
				$row->FATURA_TIP = "ISTISNA";
			} else {
				$TAX_EXEMPTON_REASON = '';
				$row->FATURA_TIP = "SATIS";
			}
			
			$row_wsdl->KALEM.= '
							<InvoiceLine xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
								<ID xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $SIRA .'</ID>
								<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">Satır Notu</Note>
								<InvoicedQuantity unitCode="NIU" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_parca->ADET.'</InvoicedQuantity>
								<Price>
									<PriceAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($row_parca->FIYAT).'</PriceAmount>
								</Price>
								<AllowanceCharge>
									<ChargeIndicator xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">false</ChargeIndicator>
									<MultiplierFactorNumeric xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. (FormatSayi::iskontoOran($row_parca->FIYAT,$row_parca->ISKONTOLU)/100) .'</MultiplierFactorNumeric>
									<Amount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2(($row_parca->FIYAT - $row_parca->ISKONTOLU) * $row_parca->ADET).'</Amount>
								</AllowanceCharge>
								
								<TaxTotal>
									<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"></TaxAmount>
									<TaxSubtotal>
										<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. FormatSayi::nokta2($row_parca->TUTAR - ($row_parca->ISKONTOLU * $row_parca->ADET)) .'</TaxAmount>
										<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_parca->KDV .'</Percent>
										<TaxCategory>
											'. $TAX_EXEMPTON_REASON .'
											<TaxScheme>
												<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">KDV</Name>
												<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">0015</TaxTypeCode>
											</TaxScheme>
										</TaxCategory>
									</TaxSubtotal>
								</TaxTotal>';
								
			if($row_tevkifat->ID > 0){
				$row_wsdl->KALEM.= '
								<WithholdingTaxTotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
									<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row_parca->TUTAR - ($row_parca->ISKONTOLU * $row_parca->ADET)) .'</TaxAmount>
									<TaxSubtotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
										<TaxableAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row_parca->ISKONTOLU * $row_parca->ADET * 0.18) .'</TaxableAmount>
										<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row_parca->TUTAR - ($row_parca->ISKONTOLU * $row_parca->ADET)) .'</TaxAmount>
										<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_ORAN .'</Percent>
										<TaxCategory xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
											<TaxScheme xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
												<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT .'</Name>
												<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_KODU .'</TaxTypeCode>
											</TaxScheme>
										</TaxCategory>
									</TaxSubtotal>
								</WithholdingTaxTotal>';
			}
			
			$row_wsdl->KALEM.= '<Item>
									<Description xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row_parca->PARCA_KODU.'</Description>
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
								
								<LineExtensionAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($row_parca->ISKONTOLU * $row_parca->ADET).'</LineExtensionAmount>
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
							<InvoiceTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_TIP.'</InvoiceTypeCode>
							<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_NOT.'</Note>
							<Note xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->FATURA_NOT2.'</Note>					
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
								<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row->FATURA_KDV_TUTAR .'</TaxAmount>
								<TaxSubtotal>
									<TaxAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row->FATURA_KDV_TUTAR .'</TaxAmount>
									<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.$row->KDV_ORAN2.'</Percent>
									<TaxCategory>
										'. $TAX_EXEMPTON_REASON .'
										<TaxScheme>
											<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">KDV</Name>
											<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">0015</TaxTypeCode>
										</TaxScheme>
									</TaxCategory>
								</TaxSubtotal>
							</TaxTotal>
							';
							
		if($row_tevkifat->ID > 0){
			$row_wsdl->XML.= '<WithholdingTaxTotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
									<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($TOPLAM_BIRIM_ISKONTOLU * ($row_tevkifat->ORAN - 1)) .'</TaxAmount>
									<TaxSubtotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
										<TaxableAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($row->FATURA_KDV_TUTAR) .'</TaxableAmount>
										<TaxAmount xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" currencyID="TRY">'. FormatSayi::nokta2($TOPLAM_BIRIM_ISKONTOLU * ($row_tevkifat->ORAN - 1)) .'</TaxAmount>
										<Percent xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_ORAN .'</Percent>
										<TaxCategory xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
											<TaxScheme xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
												<Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT .'</Name>
												<TaxTypeCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'. $row_tevkifat->TEVKIFAT_KODU .'</TaxTypeCode>
											</TaxScheme>
										</TaxCategory>
									</TaxSubtotal>
								</WithholdingTaxTotal>
								';
		}
		
		$row_wsdl->XML.= '<LegalMonetaryTotal xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">
								<LineExtensionAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($TOPLAM_BIRIM_FIYAT).'</LineExtensionAmount>
								<TaxExclusiveAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($TOPLAM_BIRIM_ISKONTOLU).'</TaxExclusiveAmount>
								<TaxInclusiveAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($TOPLAM_BIRIM_ISKONTOLU * ((100 + $row->KDV_ORAN2) / 100)).'</TaxInclusiveAmount>
								<AllowanceTotalAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($TOPLAM_BIRIM_FIYAT - $TOPLAM_BIRIM_ISKONTOLU).'</AllowanceTotalAmount>
								<PayableAmount currencyID="TRY" xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">'.FormatSayi::nokta2($row->FATURA_TUTAR).'</PayableAmount>
							</LegalMonetaryTotal>
							'. $row_wsdl->KALEM .'
						</Invoice>
						<TargetCustomer '.$row_cari->TCKN_VKN.'="'.$row_cari->TCK.'" Alias="" Title="'.$row->FATURA_ISIM.'"/>
						<EArchiveInvoiceInfo DeliveryType="Electronic"/>
						<Scenario>Automated</Scenario>
					</InvoiceInfo>
				</invoices>
			</SendInvoice>
		</s:Body>
		</s:Envelope>';
		
		//var_dump2($row_wsdl->XML);die();
	    
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
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
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
		
	    $curl_result	= $result->body->SendInvoiceResponse->SendInvoiceResult["IsSucceded"];
		$hata			= $result->body->SendInvoiceResponse->SendInvoiceResult["Message"];
		$efatid			= $result->body->SendInvoiceResponse->SendInvoiceResult->Value["Id"];
		$efatno			= $result->body->SendInvoiceResponse->SendInvoiceResult->Value["Number"];
		
		if($curl_result == 'true'){
			$filtre	= array();
			$sql = "UPDATE CARI_HAREKET SET FATURA_NO				= :FATURA_NO,
											FATURA_TARIH			= :FATURA_TARIH,
				                            FATURA_KES				= :FATURA_KES,
				                            EFATURA_UUID			= :EFATURA_UUID                           
									WHERE ID = :ID
									";
			$filtre[":FATURA_NO"] 		= $efatno;
			$filtre[":FATURA_TARIH"] 	= date("Y-m-d");
			$filtre[":FATURA_KES"]		= 1;
			$filtre[":EFATURA_UUID"] 	= $efatid;
			$filtre[":ID"] 				= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		
		if($curl_result == 'true'){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "<b> $efatno </b> fatura no ile entegre oldu.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Entegre Hata: " . $hata;
		}
		
		return $sonuc;
		
	}
	
	public function sozlesme_kaydet(){
		
		if($_REQUEST['cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari seçilmemiş!";
			return $sonuc;
		}
		
		if(str_replace('-','',trim($_REQUEST['sozlesme_tarih'])) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sözleşme Tarih giriniz!";
			return $sonuc;
		}
		
		if(str_replace('-','',trim($_REQUEST['sozlesme_bas_tarih'])) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sözleşme Başlangıç Tarih giriniz!";
			return $sonuc;
		}
		
		if(str_replace('-','',trim($_REQUEST['sozlesme_bit_tarih'])) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sözleşme Bitiş Tarih giriniz!";
			return $sonuc;
		}
		
		if($_REQUEST['sozlesme_suresi'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sözleşme süresi giriniz!";
			return $sonuc;
		}
		
		foreach($_REQUEST["plaka"] as $key => $plaka){
			if(strlen(trim($plaka)) <= 0) continue;
			$KALEM_SAYISI++;
			$KALEM_FIYAT += FormatSayi::sayi2db($_REQUEST["fiyat"][$key]);
		}
		
		if($KALEM_SAYISI <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sözleşme Kalem sayısı '0' dan büyük olmalı!";
			return $sonuc;
		}
		
		if($KALEM_FIYAT <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sözleşme tutarı '0' TL olamaz!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT ID, VADE FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["cari_id"];
		$row_cari = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT * FROM SOZLESME WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$filtre	= array();
			$sql = "INSERT INTO SOZLESME SET SOZLESME_NO			= :SOZLESME_NO,	
												CARI_ID				= :CARI_ID,
												SOZLESME_TARIH		= :SOZLESME_TARIH,
												SOZLESME_BAS_TARIH	= :SOZLESME_BAS_TARIH,
												SOZLESME_BIT_TARIH	= :SOZLESME_BIT_TARIH,
												SOZLESME_SURESI		= :SOZLESME_SURESI,
												ACIKLAMA				= :ACIKLAMA,
												KALEM_SAYISI			= :KALEM_SAYISI,
												TUTAR					= :TUTAR,
												TARIH					= NOW(),
												KOD					= MD5(NOW()),
												KAYIT_YAPAN_ID		= :KAYIT_YAPAN_ID
												";
			$filtre[":SOZLESME_NO"] 			= $_REQUEST['sozlesme_no'];
			$filtre[":CARI_ID"] 					= $_REQUEST['cari_id'];
			$filtre[":SOZLESME_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['sozlesme_tarih']);
			$filtre[":SOZLESME_BAS_TARIH"] 	= FormatTarih::nokta2db($_REQUEST['sozlesme_bas_tarih']);
			$filtre[":SOZLESME_BIT_TARIH"] 		= FormatTarih::nokta2db($_REQUEST['sozlesme_bit_tarih']);
			$filtre[":SOZLESME_SURESI"] 		 	= $_REQUEST['sozlesme_suresi'];
			$filtre[":ACIKLAMA"] 				= $_REQUEST['aciklama'];
			$filtre[":KALEM_SAYISI"] 				= $KALEM_SAYISI;
			$filtre[":TUTAR"] 						= $KALEM_FIYAT;
			$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
			$sozlesme_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
			$filtre	= array();
			$sql = "SELECT * FROM SOZLESME WHERE ID = :ID";
			$filtre[":ID"] 	= $sozlesme_id;
			$row = $this->cdbPDO->row($sql, $filtre); 
			
		} else {
			
			if(is_null($row->ID)){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Sözleşme bulunamadı!";	
				return $sonuc;
			}
			
			if($row->KOD != $_REQUEST['kod']){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
				return $sonuc;
			}
			
			$sql = "UPDATE SOZLESME SET	SOZLESME_NO				= :SOZLESME_NO, 
											CARI_ID				= :CARI_ID,
											SOZLESME_TARIH		= :SOZLESME_TARIH,
											SOZLESME_BAS_TARIH	= :SOZLESME_BAS_TARIH,
											SOZLESME_BIT_TARIH	= :SOZLESME_BIT_TARIH,
											SOZLESME_SURESI		= :SOZLESME_SURESI,
											ACIKLAMA			= :ACIKLAMA,
											KALEM_SAYISI		= :KALEM_SAYISI,
											TUTAR				= :TUTAR,
											DURUM				= :DURUM,
											GTARIH				= NOW()
									WHERE ID = :ID
									";
			$filtre[":SOZLESME_NO"] 			= $_REQUEST['sozlesme_no'];
			$filtre[":CARI_ID"] 				= $_REQUEST['cari_id'];
			$filtre[":SOZLESME_TARIH"] 			= FormatTarih::nokta2db($_REQUEST['sozlesme_tarih']);
			$filtre[":SOZLESME_BAS_TARIH"] 		= FormatTarih::nokta2db($_REQUEST['sozlesme_bas_tarih']);
			$filtre[":SOZLESME_BIT_TARIH"] 		= FormatTarih::nokta2db($_REQUEST['sozlesme_bit_tarih']);
			$filtre[":SOZLESME_SURESI"] 		= $_REQUEST['sozlesme_suresi'];
			$filtre[":ACIKLAMA"] 				= $_REQUEST['aciklama'];
			$filtre[":KALEM_SAYISI"] 			= $KALEM_SAYISI;
			$filtre[":TUTAR"] 					= $KALEM_FIYAT;
			$filtre[":DURUM"] 					= $_REQUEST['durum'];
			$filtre[":ID"] 						= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 			
			
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM SOZLESME_DETAY WHERE SOZLESME_ID = :SOZLESME_ID";
		$filtre[":SOZLESME_ID"] 	= $row->ID;
		$rows_detay2 = $this->cdbPDO->rows($sql, $filtre);
		
		foreach($rows_detay2 as $key => $row_detay2){
			$rows_detay[$row_detay2->SIRA]	= $row_detay2;
		}
		
		$sira = 0;
		foreach($_REQUEST["plaka"] as $key => $plaka){
			if(strlen(trim($plaka)) <= 0) continue;
			$sira++;
			
			if(is_null($rows_detay[$sira]->ID)){
				$filtre	= array();
				$sql = "INSERT INTO SOZLESME_DETAY SET SOZLESME_ID = :SOZLESME_ID, SIRA = :SIRA, PLAKA = :PLAKA, KM = :KM, KM_ASIM = :KM_ASIM, KM_ASIM_FIYAT = :KM_ASIM_FIYAT, FIYAT = :FIYAT";
				$filtre[":SOZLESME_ID"] 	= $row->ID;
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PLAKA"] 			= trim($_REQUEST["plaka"][$key]);
				$filtre[":KM"] 				= trim($_REQUEST["km"][$key]);
				$filtre[":KM_ASIM"] 		= FormatSayi::sayi2db($_REQUEST["km_asim"][$key]);
				$filtre[":KM_ASIM_FIYAT"] 	= FormatSayi::sayi2db($_REQUEST["km_asim_fiyat"][$key]);
				$filtre[":FIYAT"] 			= FormatSayi::sayi2db($_REQUEST["fiyat"][$key]);
				$sd_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
				
			} else if($rows_detay[$sira]->ID > 0){
				$filtre	= array();
				$sql = "UPDATE SOZLESME_DETAY SET SIRA = :SIRA, PLAKA = :PLAKA, KM = :KM, KM_ASIM = :KM_ASIM, KM_ASIM_FIYAT = :KM_ASIM_FIYAT, FIYAT = :FIYAT WHERE ID = :ID";
				$filtre[":SIRA"] 			= $sira;
				$filtre[":PLAKA"] 			= trim($_REQUEST["plaka"][$key]);
				$filtre[":KM"] 				= trim($_REQUEST["km"][$key]);
				$filtre[":KM_ASIM"] 		= FormatSayi::sayi2db($_REQUEST["km_asim"][$key]);
				$filtre[":KM_ASIM_FIYAT"] 	= FormatSayi::sayi2db($_REQUEST["km_asim_fiyat"][$key]);
				$filtre[":FIYAT"] 			= FormatSayi::sayi2db($_REQUEST["fiyat"][$key]);
				$filtre[":ID"] 				= $rows_detay[$sira]->ID;
				$this->cdbPDO->rowsCount($sql, $filtre);
				$sd_id	= $rows_detay[$sira]->ID;
			}
			
			$sd_ids[] = $sd_id;
			
		}
		
		$filtre	= array();
		$sql = "DELETE FROM SOZLESME_DETAY WHERE SOZLESME_ID = :SOZLESME_ID AND !FIND_IN_SET(ID, :IDS)";
		$filtre[":SOZLESME_ID"]	 	= $row->ID;
		$filtre[":IDS"] 			= implode(',', $sd_ids);
		$this->cdbPDO->rowsCount($sql, $filtre);
			
		if($sozlesme_id > 0 OR $rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
			$sonuc["URL"] 		= "/kiralama/sozlesme.do?route=kiralama/sozlesme_listesi&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	
	public function sozlesme_sil(){
		
		if(!in_array($_SESSION['kullanici'],array('ADMIN'))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kullanıcı yetkili değil!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM SOZLESME WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Hareket bulunamadı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM SOZLESME WHERE ID = :ID";
		$filtre[":ID"] 		= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function personel_ceza_ekle(){
		
		$filtre	= array();
		$sql = "INSERT INTO PERSONEL_CEZA SET 	ACIKLAMA		= :ACIKLAMA,
												TUTAR			= :TUTAR,
												CEZA_TARIH		= :CEZA_TARIH
												";
		$filtre[":ACIKLAMA"] 	= $_REQUEST["aciklama"];
		$filtre[":TUTAR"] 		= FormatSayi::sayi2db($_REQUEST["tutar"]);
		$filtre[":CEZA_TARIH"] 	= $_REQUEST["yil"] ."-". $_REQUEST["ay"] ."-01";
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Eklendi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function personel_ceza_sil(){
		
		$filtre	= array();
		$sql = "DELETE FROM PERSONEL_CEZA WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
	}
	
	public function fatura_kdv_orani_yuzde_bir(){
		
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
			
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Hareket bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET FINANS_KALEMI_ID = :FINANS_KALEMI_ID WHERE ID = :ID";
		$filtre[":FINANS_KALEMI_ID"] 		= 19;
		$filtre[":ID"] 						= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET_DETAY SET TUTAR = (ADET * FIYAT * ((100 - ISKONTO) / 100) * 1.01), GTARIH = NOW(), KDV = 1 WHERE ID = :ID";
		$filtre[":ID"] 				= $rows_chd[$sira]->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
				
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET TUTAR 				= IF(FINANS_KALEMI_ID = 14, 0, (SELECT SUM(TUTAR) AS TUTAR FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :ID)),
										KDV_TUTAR 			= IF(FINANS_KALEMI_ID IN(11,14) OR FATURA_KES = 2, 0, (SELECT SUM(TUTAR / (100 + KDV) * KDV) AS TUTAR FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :ID)),
										FINANS_KALEMI_ID	= 19
									WHERE ID = :ID
									";
		$filtre[":ID"] 				= $row->ID;
		$this->cdbPDO->rowsCount($sql, $filtre); 
			
		if(true){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
			$sonuc["URL"] 		= "/finans/satis_fatura.do?route=finans/satis_faturalar&id={$row->ID}&kod={$row->KOD}";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function efatura_bagla(){
		
		$filtre	= array();
		$sql = "SELECT * FROM TALEP WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
			
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Talep bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
				
		$filtre	= array();
		$sql = "UPDATE TALEP SET 	EFATURA_UUID	= :EFATURA_UUID,
									FATURA_NO 		= :FATURA_NO,
									FATURA_TUTAR 	= :FATURA_TUTAR,
									FATURA_TARIH 	= :FATURA_TARIH
								WHERE ID = :ID
								";
		$filtre[":EFATURA_UUID"] 	= trim($_REQUEST["efatura_uuid"]);
		$filtre[":FATURA_NO"] 		= trim($_REQUEST["fatura_no"]);
		$filtre[":FATURA_TUTAR"] 	= FormatSayi::sayi($_REQUEST["fatura_tutar"]);
		$filtre[":FATURA_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["fatura_tarih"]);
		$filtre[":ID"] 			= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function efatura_finans_satis_bagla(){
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
			
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Satış Faturası bulunamadı!";	
			return $sonuc;
		}
		
		if($row->KOD != $_REQUEST['kod']){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Kod Hatası!";	
			return $sonuc;
		}
				
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET EFATURA_UUID	= :EFATURA_UUID,
										FATURA_NO 		= :FATURA_NO,
										FATURA_TARIH 	= :FATURA_TARIH
									WHERE ID = :ID
									";
		$filtre[":EFATURA_UUID"] 	= trim($_REQUEST["efatura_uuid"]);
		$filtre[":FATURA_NO"] 		= trim($_REQUEST["fatura_no"]);
		$filtre[":FATURA_TARIH"] 	= FormatTarih::nokta2db($_REQUEST["fatura_tarih"]);
		$filtre[":ID"] 			= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Edildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function parca_bul(){
		global $rows_doviz;
		
		if(strlen($_REQUEST['parca']) < 3 AND $_REQUEST['marka_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Parça kodu en az 3 karakter olmalı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_SESSION["cari_id"];
		$row_cari = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row_cari)){
			$row_cari->KAR_ORANI = 0;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO STOK_ARAMA SET 	KELIME			= :KELIME,
											CARI_ID 		= :CARI_ID,
											KULLANICI_ID	= :KULLANICI_ID
											";
		$filtre[":KELIME"] 			= trim($_REQUEST["parca"]);
		$filtre[":CARI_ID"] 		= $row_cari->ID;
		$filtre[":KULLANICI_ID"] 	= $_SESSION['kullanici_id'];
		$this->cdbPDO->rowsCount($sql, $filtre);		

		$filtre	= array();
		$sql = "SELECT 
					S.*,
					S.SATIS_FIYAT AS FIYAT,
					K.KATEGORI,
					GROUP_CONCAT(DISTINCT CONCAT(KA.MARKA,' ',KA.MODEL)) AS KATALOGS,
					COUNT(DISTINCT KA.ID) AS KATALOG_SAY,
					CONCAT('stok/',YEAR(SR.TARIH),'/',SR.STOK_ID,'/',SR.RESIM_ADI) AS URL,
					PM.PARCA_MARKA
				FROM STOK AS S 
					LEFT JOIN KATEGORI AS K ON K.ID = S.KATEGORI_ID
					LEFT JOIN STOK_KATALOG AS SK ON SK.STOK_ID = S.ID
					LEFT JOIN KATALOG AS KA ON KA.ID = SK.STOK_KATALOG_ID
					LEFT JOIN PARCA_MARKA AS PM ON PM.ID = S.PARCA_MARKA_ID
					LEFT JOIN STOK_RESIM AS SR ON SR.STOK_ID = S.ID AND SR.SIRA = 1
				WHERE S.DURUM = 1
				"; // AND FIND_IN_SET(YP.PARCA_MARKA_ID, TC.PARCA_MARKA_IDS) //OR YP.PARCA_ADI LIKE :PARCA
				// (REPLACE(REPLACE(YP.OEM_KODU,'.',''),' ','') LIKE :PARCA OR REPLACE(REPLACE(YP.PARCA_KODU,'.',''),' ','') LIKE :PARCA)
		//$filtre[":KELIME"] 	= '%'. trim(str_replace(array('.',' ','-'),'',$_REQUEST["parca"])) .'%';
		//$filtre[":KELIME"] 	= trim(str_replace(array('.',' ','-','/','\\'),'',$_REQUEST["parca"]));
		
		$rows_kelime = explode(' ', $_REQUEST["parca"]);		
		
		foreach($rows_kelime as $key => $row_kelime){
			if(strlen(trim($row_kelime)) <= 0){
				unset($rows_kelime[$key]);
			}
		}
		
		foreach($rows_kelime as $key => $row_kelime){
			if($key == 0){
				$sql.= " AND ( ";
			}
			// str_replace(array('.',' ','-','/','\\'),'',);
			$sql.= " CONCAT_WS(' ', S.KODU, S.OEM_KODU, S.MUADIL_KODUS, S.STOK) LIKE :KELIME$key";
			$filtre[":KELIME$key"] 	= '%'. trim($row_kelime) . '%';	
			
			if(count($rows_kelime) == $key+1){
				$sql.= " )";
			} else {
				$sql.= " AND ";
			}
		}
		
		/*
		foreach($rows_kelime as $key => $row_kelime){
			if($key == 0){
				$sql.= " AND ( ";
			}
			
			$sql.= " (REPLACE(REPLACE(REPLACE(REPLACE(S.KODU,'-',''),' ',''),'.',''),' ','') LIKE :KELIME$key OR REPLACE(REPLACE(REPLACE(S.OEM_KODU,'-',''),'.',''),' ','') LIKE :KELIME$key) OR S.STOK LIKE :KELIME$key OR FIND_IN_SET(:KELIME$key,S.MUADIL_KODUS)";
			$filtre[":KELIME$key"] 	= '%'. trim(str_replace(array('.',' ','-','/','\\'),'',$row_kelime)) . '%';	
			
			if(count($rows_kelime) == $key+1){
				$sql.= " )";
			} else {
				$sql.= " AND ";
			}
		}
		*/
		/*
		if(strlen(trim($_REQUEST['parca'])) > 0) {
			//$sql.=" AND (S.KODU REGEXP :KELIME OR S.OEM_KODU REGEXP :KELIME OR S.MUADIL_KODUS REGEXP :KELIME OR FIND_IN_SET(:KELIME,S.OEM_KODU))";
			//$filtre[":KELIME"] 	= trim($_REQUEST["parca"]);
			$sql.=" AND (S.KODU LIKE :KELIME OR S.OEM_KODU LIKE :KELIME OR S.STOK LIKE :KELIME OR FIND_IN_SET(:KELIME2,S.MUADIL_KODUS))";
			$filtre[":KELIME"] 		= "%". trim($_REQUEST["parca"]) . "%";
			$filtre[":KELIME2"] 	= trim($_REQUEST["parca"]);
		}
		*/
		
		if($_REQUEST['marka_id'] > 0) {
			$sql.=" AND KA.MARKA_ID = :MARKA_ID";
			$filtre[":MARKA_ID"] = $_REQUEST['marka_id'];
		}
		
		if($_REQUEST['model_id'] > 0) {
			$sql.=" AND KA.MODEL_ID = :MODEL_ID";
			$filtre[":MODEL_ID"] = $_REQUEST['model_id'];
		}
		
		if($_REQUEST['kategori_id'] > 0) {
			$sql.=" AND S.KATEGORI_ID = :KATEGORI_ID";
			$filtre[":KATEGORI_ID"] = $_REQUEST['kategori_id'];
		}
		
		$sql.=" GROUP BY S.ID LIMIT 100";
		
		$rows = $this->cdbPDO->rows($sql, $filtre); 
		
		//var_dump2($this->cdbPDO->getSQL($sql, $filtre));
				
		foreach($rows as $key => $row){
			if($row->ADET > 2){
				$row->STOK_DURUM = '<i class="far fa-check"></i>';
			} else {
				$row->STOK_DURUM = "<b>?</b>";
			}
			
			if($row->ADET <= 5){
				$cls = "bg-danger-100";
			} else {
				$cls = "";
			}
			
			$row->FIYAT			= $row->FIYAT * ((100 + $row_cari->KAR_ORANI)/100);
			$row->FIYAT_KDVLI	= $row->FIYAT * 1.18;
			
			//$SATIS_FIYAT =  fncCariParaBirimGoster($row->SATIS_FIYAT + ($row->SATIS_FIYAT * ($row_cari->KAR_ORANI / 100)), $row_cari->PARA_BIRIM, $rows_doviz, 1);			
			$row->OEM_KODU2 = str_replace(',','<br>',$row->OEM_KODU);
			$row->KATALOGS2 = str_replace(',','<br>',$row->KATALOGS);
			
			if(in_array(SITE,array(3))){
				
			} else if(is_file($this->cSabit->imgPathFile($row->URL))){
                //$resim = '<a href="'.$this->cSabit->imgPath($row->URL).'" data-toggle="lightbox" data-gallery="example-gallery" data-title="' .$row->KODU .' - '. $row->STOK .'" data-footer="'.$row->KODU.'"> <img class="img-thumbnail lazy" alt="" src="/img/loading2.gif" data-src="'.$this->cSabit->imgPath($row->URL).'" style="width:100px;height: 100px"/> </a>';
                $resim = '<td align="center" class="popup-gallery"><a href="/resim.do?id='.$row->ID.'" data-toggle="lightbox" data-gallery="example-gallery" data-title="' .$row->KODU .' - '. $row->STOK .'" data-footer="'.$row->KODU.'"> <img class="img-thumbnail lazy" alt="" src="/img/loading2.gif" data-src="/resim_thumb.do?id='.$row->ID.'" style="width:100px;height: 100px"/> </a></td>';
	        } else {
	        	$resim = '<td align="center" class="popup-gallery"><a href="/img/100x100.png" data-toggle="lightbox" data-gallery="example-gallery" data-title="A" data-footer="B"> <img src="/img/100x100.png" class="img-responsive center-block " style="width:100px;height: 100px"> </a></td>';
	        }	
			
			$row->MUADIL_KODUS = str_replace(',','<br>',$row->MUADIL_KODUS);
			//<td nowrap id='b{$sira}'>{$row->MUADIL_KODUS}</td>
			$sira++;
			$str.= "<tr class='{$cls}'>
						<td align='center'>{$sira}</td>
						{$resim}
						<td nowrap id='k{$sira}'>{$row->PARCA_MARKA}<br>{$row->KODU}</td>
						<td nowrap id='o{$sira}'>{$row->OEM_KODU2}</td>
						<td nowrap id='s{$sira}'>{$row->STOK}</td>
						<td nowrap id='c{$sira}'>{$row->KATALOGS2}</td>
						<td id='d{$sira}' align='center'>{$row->STOK_DURUM}</td>
						<td id='a{$sira}' align='right'>".FormatSayi::sayi($row->FIYAT,2). " <i class='fal fa-lira-sign'></i></td>
						<td id='a{$sira}' align='right'>".FormatSayi::sayi($row->FIYAT_KDVLI,2)." <i class='fal fa-lira-sign'></i></td>
						<td align='center' data-tableexport-display='none' nowrap>
							<div class='form-group' style='width: 180px'>
	                            <div class='input-group'>
	                                <input type='text' class='form-control text-center' id='adet{$sira}' value='1' style='text-align: right;' data-id='{$sira}'>
	                                <div class='input-group-append'>
	                                    <button class='btn btn-primary waves-effect waves-themed' onclick='fncSepeteEkle(this)' type='button' id='btnSepeteEkle' data-id='{$sira}' data-kodu='{$row->KODU}'>".dil("Sepete Ekle")."</button>
	                                </div>
	                            </div>
	                        </div>
						</td>
					<tr>
					";	
			
		}		
		
		if(TRUE){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= count($rows) . " adet kayıt bulundu.";			
			$sonuc["HTML"] 		= $str;			
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function sepete_urun_ekle(){
		global $rows_doviz;
		//$_SESSION['servis_id'] = 603;
		
		if(!in_array($_SESSION["yetki_id"], array(1,2,3,4,5,6,7,8))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yetkiniz Yok!";
			return $sonuc;
		}
		
		if($_SESSION['cari_id'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Cari Id bulunamadı!";	
			return $sonuc;
		}
		
		if($_REQUEST['adet'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Adet 0 dan bütük giriniz!";	
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "SELECT
					S.*
				FROM STOK AS S
				WHERE S.KODU = :KODU
				";
				
		$filtre[":KODU"] 	= $_REQUEST['kodu'];	
		$row_stok = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row_stok->KODU)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Parça bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 		= $_SESSION['cari_id'];
		$row_cari = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row_cari)){
			$row_cari->KAR_ORANI = 0;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM SEPET WHERE CARI_ID = :CARI_ID AND KODU = :KODU";
		$filtre[":CARI_ID"] 	= $_SESSION['cari_id'];
		$filtre[":KODU"] 		= $_REQUEST['kodu'];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		$row_stok->SATIS_FIYAT	= $row_stok->SATIS_FIYAT * ((100 + $row_cari->KAR_ORANI)/100);
		
		if(is_null($row->ID)){
			$filtre	= array();
			$sql = "INSERT INTO SEPET SET 	CARI_ID 			= :CARI_ID,
											STOK_ID				= :STOK_ID,
											KODU				= :KODU,
											OEM_KODU			= :OEM_KODU,
											STOK				= :STOK,
											ALIS				= :ALIS,
											FIYAT				= :FIYAT,
											ADET				= :ADET,
											ISKONTOLU			= :FIYAT,
											TUTAR				= :TUTAR,
											PARA_BIRIM			= :PARA_BIRIM,
											EKLEYEN_ID			= :EKLEYEN_ID
											";
			$filtre[":CARI_ID"] 			= $row_cari->ID;			
			$filtre[":STOK_ID"] 			= $row_stok->ID;
			$filtre[":KODU"] 				= $row_stok->KODU;
			$filtre[":OEM_KODU"] 			= $row_stok->OEM_KODU;
			$filtre[":STOK"] 				= $row_stok->STOK;
			$filtre[":ALIS"] 				= $row_stok->ALIS_FIYAT;
			$filtre[":FIYAT"] 				= $row_stok->SATIS_FIYAT;
			$filtre[":ADET"] 				= $_REQUEST['adet'];
			$filtre[":TUTAR"] 				= $row_stok->SATIS_FIYAT * $_REQUEST['adet'];
			$filtre[":PARA_BIRIM"] 			= $row_stok->PARA_BIRIM;
			$filtre[":EKLEYEN_ID"] 			= $_SESSION['kullanici_id'];
			$stok_id = $this->cdbPDO->lastInsertId($sql, $filtre);
			
		} else {
			$filtre	= array();
			$sql = "UPDATE SEPET SET 	ADET				= ADET + :ADET,
										TUTAR				= (ADET +:ADET) * ISKONTOLU
									WHERE ID = :ID
									";
			$filtre[":ADET"] 		= $_REQUEST['adet'];
			$filtre[":ID"] 			= $row->ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		
		if($stok_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "<b>".$row_stok->PARCA_KODU."</b> ". $_REQUEST['adet'] ." adet Sepete Eklendi.";
			$sonuc["SEPET_SAY"] = $this->cSubData->getSepetSay()->SAY;
		} else if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Stok Adeti: ".($row->ADET + $_REQUEST['adet'])." güncellendi.";
			$sonuc["SEPET_SAY"]	= $this->cSubData->getSepetSay()->SAY;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hata!";
		}
		
		return $sonuc;
	}
	
	public function sepet_adet_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT * FROM SEPET WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sepette ürün bulunamadı!";	
			return $sonuc;
		}
		
		if($_REQUEST['adet'] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Adet 0'dan büyük olmalı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 		= $_SESSION['cari_id'];
		$row_cari = $this->cdbPDO->row($sql, $filtre);
		
		$rows_doviz			= $this->cSubData->getDoviz();
		
		$filtre	= array();
		$sql = "UPDATE SEPET SET 	ADET				= :ADET,
									TUTAR				= :TUTAR
								WHERE ID = :ID
								";
		$filtre[":ADET"] 		= $_REQUEST['adet'];
		$filtre[":TUTAR"] 		= $row->ISKONTOLU * $_REQUEST['adet'];
		$filtre[":ID"] 			= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= $_REQUEST['adet'] ." adet olarak güncellendi.";
			$sonuc["FIYAT"] 	= fncCariParaBirimGoster($row->ISKONTOLU, $row_cari->PARA_BIRIM, $rows_doviz, 1);
			$sonuc["TUTAR"] 	= fncCariParaBirimGoster($row->ISKONTOLU * $_REQUEST['adet'], $row_cari->PARA_BIRIM, $rows_doviz, 1);
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
	}
	
	public function sepet_iskontolu_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT * FROM SEPET WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sepette ürün bulunamadı!";	
			return $sonuc;
		}
		
		if(FormatSayi::sayi2db($_REQUEST['iskontolu']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Fiyat 0'dan büyük olmalı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 		= $_SESSION['cari_id'];
		$row_cari = $this->cdbPDO->row($sql, $filtre);
		
		$rows_doviz			= $this->cSubData->getDoviz();
		
		$filtre	= array();
		$sql = "UPDATE SEPET SET 	ISKONTOLU		= :ISKONTOLU,
									TUTAR			= :TUTAR
								WHERE ID = :ID
								";
		$filtre[":ISKONTOLU"] 	= FormatSayi::sayi2db($_REQUEST['iskontolu'],2);
		$filtre[":TUTAR"] 		= $row->ADET * FormatSayi::sayi2db($_REQUEST['iskontolu']);
		$filtre[":ID"] 			= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= $_REQUEST['iskontolu'] ." fiyat olarak güncellendi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
	}
	
	public function sepet_iskonto_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT * FROM SEPET WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sepette ürün bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 		= $_SESSION['cari_id'];
		$row_cari = $this->cdbPDO->row($sql, $filtre);
		
		$rows_doviz			= $this->cSubData->getDoviz();
		
		$filtre	= array();
		$sql = "UPDATE SEPET SET 	ISKONTO		= :ISKONTO,
									ISKONTOLU	= FIYAT * ((100 - :ISKONTO) / 100),
									TUTAR		= FIYAT * ADET * ((100 - :ISKONTO) / 100)
								WHERE ID = :ID
								";
		$filtre[":ISKONTO"] 	= $_REQUEST['iskonto'];
		$filtre[":ID"] 			= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "%". $_REQUEST['iskonto'] ." iskonto olarak güncellendi.";
			$sonuc["FIYAT"] 	= FormatSayi::sayi2db($row->FIYAT * ((100 - $_REQUEST['iskonto']) / 100), 2);
			$sonuc["TUTAR"] 	= FormatSayi::sayi2db($row->FIYAT * $row->ADET * ((100 - $_REQUEST['iskonto']) / 100), 2);
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
	}
	
	public function sepet_urun_sil(){
		
		$filtre	= array();
		$sql = "SELECT * FROM SEPET WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sepette ürün bulunamadı!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "DELETE FROM SEPET WHERE ID = :ID";
		$filtre[":ID"] 			 = $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
			$sonuc["SEPET_SAY"] = $this->cSubData->getSepetSay()->SAY;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hata!";
		}
		
		return $sonuc;
	}
	
	public function sepet_urun_secili_sil(){
		
		$filtre	= array();
		$sql = "SELECT * FROM SEPET WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($_REQUEST['secim']) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sepette seçili ürün bulunamadı!";	
			return $sonuc;
		}
		
		foreach($_REQUEST['secim'] as $PARCA_ID => $SECIM){
			$filtre	= array();
			$sql = "DELETE FROM SEPET WHERE ID = :ID";
			$filtre[":ID"] 			 = $PARCA_ID;
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		}
		
		if($rowsCount > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Seçili olanlar Silindi.";
			$sonuc["SEPET_SAY"] = $this->cSubData->getSepetSay()->SAY;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Hata!";
		}
		
		return $sonuc;
	}
	
	public function sepet_siparis_ver(){
		
		if(!in_array($_SESSION["yetki_id"], array(1,2,3,4,5,6,7,8))){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yetkiniz Yok!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI WHERE ID = :ID";
		$filtre[":ID"] 	= $_SESSION['cari_id'];
		$row_cari = $this->cdbPDO->row($sql, $filtre);
		
		$filtre	= array();
		$sql = "SELECT * FROM SEPET WHERE CARI_ID = :CARI_ID";
		$filtre[":CARI_ID"] 	= $_SESSION['cari_id'];
		$rows_parca2 = $this->cdbPDO->rows($sql, $filtre); 
		$rows_parca = arrayIndex($rows_parca2);
		
		foreach($_REQUEST['secim'] as $PARCA_ID => $SECIM){
			$rows_siparis[$PARCA_ID] 		= $rows_parca[$PARCA_ID];
			$rows_parca_fiyat[$PARCA_ID] 	= $rows_parca[$PARCA_ID]->TUTAR;
			$rows_siparis_tutar 			+= $rows_parca[$PARCA_ID]->TUTAR;
			$rows_sepet_ids[] 				= $PARCA_ID;
		}
		
		if(count($rows_siparis) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Ürün Seçmediniz!";	
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "INSERT INTO CARI_HAREKET SET 	HAREKET_ID				= 1,
												FINANS_KALEMI_ID		= :FINANS_KALEMI_ID,
												ODEME_KANALI_ID			= :ODEME_KANALI_ID,
												ODEME_KANALI_DETAY_ID	= :ODEME_KANALI_DETAY_ID,
												FATURA_NO				= :FATURA_NO,
												FATURA_TARIH			= :FATURA_TARIH,
												VADE_TARIH				= DATE_ADD(:FATURA_TARIH, INTERVAL :VADE DAY),
												CARI_ID					= :CARI_ID,
												PLAKA					= :PLAKA,
												ACIKLAMA				= :ACIKLAMA,
												KALEM_SAYISI			= :KALEM_SAYISI,
												FATURA_KES				= :FATURA_KES,
												KAYIT_YAPAN_ID			= :KAYIT_YAPAN_ID,
												TARIH					= NOW(),
												KOD						= MD5(NOW())
												";
		$filtre[":FINANS_KALEMI_ID"] 		= 1;
		$filtre[":ODEME_KANALI_ID"] 		= 0;
		$filtre[":ODEME_KANALI_DETAY_ID"] 	= 0;
		$filtre[":FATURA_NO"] 				= "";
		$filtre[":FATURA_TARIH"] 			= date("Y-m-d");
		$filtre[":VADE"] 					= $row_cari->VADE;
		$filtre[":CARI_ID"] 				= $row_cari->ID;
		$filtre[":PLAKA"] 					= "";
		$filtre[":ACIKLAMA"] 				= trim($_REQUEST['aciklama']);
		$filtre[":KALEM_SAYISI"] 			= $KALEM_SAYISI;
		$filtre[":FATURA_KES"] 				= 2;
		$filtre[":KAYIT_YAPAN_ID"] 			= $_SESSION['kullanici_id'];
		$cari_hareket_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET FATURA_NO = :FATURA_NO WHERE ID = :ID";
		$filtre[":FATURA_NO"] 	= "IRS". str_pad($cari_hareket_id, 13, "0", STR_PAD_LEFT);
		$filtre[":ID"] 			= $cari_hareket_id;
		$this->cdbPDO->rowsCount($sql, $filtre);	
		
		$filtre	= array();
		$sql = "SELECT * FROM CARI_HAREKET WHERE ID = :ID";
		$filtre[":ID"] 	= $cari_hareket_id;
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		$filtre	= array();
		$sql = "SELECT (1 + (KDV / 100)) AS KDV_CARPAN, KDV FROM FINANS_KALEMI WHERE ID = :ID";
		$filtre[":ID"] 	= 1;
		$row_finans_kalemi = $this->cdbPDO->row($sql, $filtre);
		
		$sira = 0;
		foreach($_REQUEST['secim'] as $PARCA_ID => $SECIM){
			//if(strlen(trim($parca_kodu)) <= 0 AND strlen(trim($_REQUEST["yp_parca_adi"][$key])) <= 0) continue;
			$sira++;
			
			$filtre	= array();
			$sql = "INSERT INTO CARI_HAREKET_DETAY SET CARI_HAREKET_ID = :CARI_HAREKET_ID, SIRA = :SIRA, PARCA_KODU = :PARCA_KODU, OEM_KODU = :OEM_KODU, PARCA_ADI = :PARCA_ADI, ADET = :ADET, ALIS = :ALIS, FIYAT = :FIYAT, ISKONTO = :ISKONTO, ISKONTOLU = :ISKONTOLU, TUTAR = :TUTAR, KDV = :KDV, GTARIH = NOW()";
			$filtre[":CARI_HAREKET_ID"] = $row->ID;
			$filtre[":SIRA"] 			= $sira;
			$filtre[":PARCA_KODU"] 		= $rows_parca[$PARCA_ID]->KODU;
			$filtre[":OEM_KODU"] 		= $rows_parca[$PARCA_ID]->OEM_KODU;
			$filtre[":PARCA_ADI"] 		= $rows_parca[$PARCA_ID]->STOK;
			$filtre[":ADET"] 			= $rows_parca[$PARCA_ID]->ADET;
			$filtre[":ALIS"] 			= $rows_parca[$PARCA_ID]->ALIS;
			$filtre[":FIYAT"] 			= $rows_parca[$PARCA_ID]->FIYAT;
			$filtre[":ISKONTO"] 		= $rows_parca[$PARCA_ID]->ISKONTO;
			$filtre[":ISKONTOLU"] 		= $rows_parca[$PARCA_ID]->ISKONTOLU;
			$filtre[":TUTAR"] 			= $rows_parca[$PARCA_ID]->TUTAR * $row_finans_kalemi->KDV_CARPAN;
			$filtre[":KDV"] 			= $row_finans_kalemi->KDV;
			$chd_id = $this->cdbPDO->lastInsertId($sql, $filtre);  
			
			$chd_ids[] = $chd_id;
			
		}
		
		$filtre	= array();
		$sql = "DELETE FROM SEPET WHERE FIND_IN_SET(ID, :IDS)";
		$filtre[":IDS"] 		 = implode(",", $rows_sepet_ids);
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);	
		
		$filtre	= array();
		$sql = "UPDATE CARI_HAREKET SET TUTAR 		= IF(FINANS_KALEMI_ID = 14, 0, (SELECT SUM(TUTAR) AS TUTAR FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :ID)),
										KDV_TUTAR 	= IF(FINANS_KALEMI_ID IN(11,14), 0, (SELECT SUM(TUTAR / (100 + KDV) * KDV) AS TUTAR FROM CARI_HAREKET_DETAY WHERE CARI_HAREKET_ID = :ID))
									WHERE ID = :ID
									";
		$filtre[":ID"] 				= $row->ID;
		$this->cdbPDO->rowsCount($sql, $filtre); 
		
		//fncSiparisMailGonder($row->ID);
		
		if($cari_hareket_id > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= $cari_hareket_id . " nolu sipariş oluşturuldu.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
	}
	
	public function stok_excel_yukle(){
		
		$YOL 			= $this->cSabit->imgPathFolder("excel") . date("/Y/m/");
		$YUKLEME_TARIHI = date("Y-m-d H:i:s");
		$DOSYA_TAM_AD	= $_FILES['excel']['name'];
		$DOSYA 			= explode(".", $DOSYA_TAM_AD); 
	    $DOSYA_AD 		= $DOSYA[0]; 
	    $DOSYA_UZANTI 	= strtolower($DOSYA[sizeof($DOSYA)-1]);
	    
	    if (!file_exists($YOL)) {
		    mkdir($YOL, 0777, true);
		}
		
	    list($usec, $sec)= explode(' ',microtime());  
  		$TIMESTAMP = str_replace('.', '', ( ((float)$usec + (float)$sec) ));
  		$TIMESTAMP = str_pad($TIMESTAMP, 14, "0", STR_PAD_RIGHT); 
	   
	    copy($_FILES['excel']['tmp_name'], $YOL . $TIMESTAMP .".". $DOSYA_UZANTI); 
		chmod($YOL . $TIMESTAMP, 0755);
		unlink($_FILES['excel']['tmp_name']); 
		
		if(file_exists($YOL . $TIMESTAMP .".". $DOSYA_UZANTI)){
			$filtre = array();
			$sql = "INSERT INTO EXCEL SET 	TUR 			= 'STOK',
											EXCEL 			= :EXCEL, 
											EXCEL_ILK 		= :EXCEL_ILK, 
											YUKLEYEN_ID 	= :YUKLEYEN_ID,
											ACIKLAMA		= :ACIKLAMA,
											PARCA_TIPI_ID	= :PARCA_TIPI_ID,
											LISTE_KAR_ORANI	= :LISTE_KAR_ORANI,
											TARIH 			= NOW(),
											KOD				= MD5(NOW())
											";		
			$filtre[":EXCEL"] 			= $TIMESTAMP . "." . $DOSYA_UZANTI;
			$filtre[":EXCEL_ILK"] 		= $DOSYA_TAM_AD;			
			$filtre[":YUKLEYEN_ID"] 	= $_SESSION["kullanici_id"];
			$filtre[":ACIKLAMA"] 		= trim($_REQUEST['aciklama']);
			$filtre[":PARCA_TIPI_ID"] 	= $_REQUEST['parca_tipi_id'];
			$filtre[":LISTE_KAR_ORANI"] = FormatSayi::sayi2db($_REQUEST['liste_kar_orani']);
			$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
		}
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı.";
		}
			
		return $sonuc;
		
	}
	
	public function excel_onay(){
		
		$filtre	= array();
		$sql = "SELECT ID, EXCEL_ILK FROM EXCEL WHERE ID = :ID AND KOD = :KOD";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$filtre[":KOD"] 		= $_REQUEST['kod'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Excel dosyası bulunamadı!";
			return $sonuc;
		}
		
		$filtre	= array();
		$sql = "UPDATE EXCEL SET ONAY = 1, ONAY_TARIH = NOW(), ONAYLAYAN_ID = :ONAYLAYAN_ID WHERE ID = :ID";
		$filtre[":ID"] 				= $_REQUEST['id'];
		$filtre[":ONAYLAYAN_ID"] 	= $_SESSION['kullanici_id'];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Onaylandı.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function excel_sil(){
		
		$YOL 			= $this->cSabit->imgPathFolder("excel") . date("/Y/m/");
		
		$filtre	= array();
		$sql = "SELECT ID, EXCEL_ILK FROM EXCEL WHERE ID = :ID";
		$filtre[":ID"] 			= $_REQUEST['id'];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->ID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Silinecek excel seçilmemiş!";
			return $sonuc;
		}
		
		unlink($YOL . $row->EXCEL_ILK);
		
		$filtre	= array();
		$sql = "DELETE FROM EXCEL WHERE ID = :ID";
		$filtre[":ID"] 			= $row->ID;
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 	
		
		$filtre	= array();
		$sql = "DELETE FROM YP_LISTE WHERE EXCEL_ID = :ID";
		$filtre[":ID"] 			= $row->ID;
		$rowsCount2 = $this->cdbPDO->rowsCount($sql, $filtre); 
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Silindi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function yedek_parca_kaydet(){
		
		$filtre	= array();
		$sql = "SELECT * FROM YP_LISTE WHERE UUID = :UUID";
		$filtre[":UUID"] 		= $_REQUEST['uuid'];		
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(is_null($row->UUID)){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Yedek Parça bulunamadı!";
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "UPDATE YP_LISTE SET MARKA_ID 			= :MARKA_ID, 
									PARCA_KODU 			= :PARCA_KODU, 
									OEM_KODU 			= :OEM_KODU, 
									REFERANS_KODU		= :REFERANS_KODU,
									PARCA_ADI			= :PARCA_ADI,
									ALIS_FIYAT			= :ALIS_FIYAT,
									SATIS_FIYAT 		= :SATIS_FIYAT, 
									PARA_BIRIM			= :PARA_BIRIM, 
									BIRIM 				= :BIRIM, 
									ADET 				= :ADET, 
									DURUM 				= :DURUM,
									PARCA_MARKA 		= :PARCA_MARKA, 
									PARCA_MARKA_ID		= :PARCA_MARKA_ID,
									BASLA_TARIH			= :BASLA_TARIH,
									BITIS_TARIH			= :BITIS_TARIH,
									TEDARIKCI_ID		= :TEDARIKCI_ID,
									STOK				= :STOK,
									KAMPANYALI			= :KAMPANYALI,
									ULKE				= :ULKE,
									ULKE_ID				= :ULKE_ID,
									PARCA_TIPI_ID		= :PARCA_TIPI_ID
								WHERE UUID = :UUID
								";
		$filtre[":MARKA_ID"]		= $_REQUEST["marka_id"];
		$filtre[":PARCA_KODU"]		= trim($_REQUEST["parca_kodu"]);
		$filtre[":OEM_KODU"]		= trim($_REQUEST["oem_kodu"]);
		$filtre[":REFERANS_KODU"]	= trim($_REQUEST["referans_kodu"]);
		$filtre[":PARCA_ADI"]		= trim($_REQUEST["parca_adi"]);
		$filtre[":ALIS_FIYAT"]		= FormatSayi::sayi2db($_REQUEST["alis_fiyat"]); //str_replace(',','.',str_replace('.','',$row_o->F));
		$filtre[":SATIS_FIYAT"]		= FormatSayi::sayi2db($_REQUEST["alis_fiyat"]); //str_replace(',','.',str_replace('.','',$row_o->F));
		$filtre[":PARA_BIRIM"]		= $_REQUEST["para_birim"];
		$filtre[":BIRIM"]			= $_REQUEST["birim"];
		$filtre[":ADET"]			= $_REQUEST["adet"];
		$filtre[":DURUM"]			= $_REQUEST["durum"];
		$filtre[":PARCA_MARKA"]		= $_REQUEST["parca_marka"];
		$filtre[":PARCA_MARKA_ID"]	= 0;
		$filtre[":BASLA_TARIH"]		= FormatTarih::n2db($_REQUEST["basla_tarih"]);
		$filtre[":BITIS_TARIH"]		= FormatTarih::n2db($_REQUEST["bitis_tarih"]);
		$filtre[":TEDARIKCI_ID"]	= $_REQUEST["tedarikci_id"];
		$filtre[":STOK"]			= $_REQUEST["stok"] == 1 ? 1 : 0;
		$filtre[":KAMPANYALI"]		= $_REQUEST["kampanyali"] == 1 ? 1 : 0;
		$filtre[":ULKE"]			= $_REQUEST["ulke"];
		$filtre[":ULKE_ID"]			= $_REQUEST["ulke_id"];
		$filtre[":PARCA_TIPI_ID"]	= $_REQUEST["parca_tipi_id"];
		$filtre[":UUID"]			= $_REQUEST["uuid"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Yapıldı.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
			
		return $sonuc;
		
	}
	
	public function kur_bilgisi_kaydet(){
		
		if(strlen($_REQUEST['tarih']) != 10){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Tarih giriniz!";
			return $sonuc;
		}
		
		if(FormatSayi::sayi2db($_REQUEST['usd_alis']) < 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Dolar kurunu giriniz!";
			return $sonuc;
		}
		
		if(FormatSayi::sayi2db($_REQUEST['eur_alis']) < 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Euro kurunu giriniz!";
			return $sonuc;
		}
		
		if(FormatSayi::sayi2db($_REQUEST['gbp_alis']) < 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Sterlin kurunu giriniz!";
			return $sonuc;
		}
		
		$filtre = array();
		$sql = "REPLACE INTO DOVIZ SET 	TARIH 		= :TARIH,
										DOVIZ 		= 'DOLAR', 
										ALIS 		= :ALIS, 
										SATIS		= :SATIS,
										ALIS_EFEK	= :ALIS_EFEK, 
										SATIS_EFEK	= :SATIS_EFEK
										";
		$filtre[":TARIH"] 			= FormatTarih::nokta2db($_REQUEST['tarih']);
		$filtre[":ALIS"] 			= FormatSayi::sayi2db($_REQUEST['usd_alis']);
		$filtre[":SATIS"] 			= FormatSayi::sayi2db($_REQUEST['usd_satis']);
		$filtre[":ALIS_EFEK"] 		= FormatSayi::sayi2db($_REQUEST['usd_alis']);
		$filtre[":SATIS_EFEK"] 		= FormatSayi::sayi2db($_REQUEST['usd_satis']);
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre = array();
		$sql = "REPLACE INTO DOVIZ SET 	TARIH 		= :TARIH,
										DOVIZ 		= 'EURO', 
										ALIS 		= :ALIS, 
										SATIS		= :SATIS,
										ALIS_EFEK 	= :ALIS_EFEK, 
										SATIS_EFEK	= :SATIS_EFEK
										";
		$filtre[":TARIH"] 			= FormatTarih::nokta2db($_REQUEST['tarih']);
		$filtre[":ALIS"] 			= FormatSayi::sayi2db($_REQUEST['eur_alis']);
		$filtre[":SATIS"] 			= FormatSayi::sayi2db($_REQUEST['eur_satis']);
		$filtre[":ALIS_EFEK"] 		= FormatSayi::sayi2db($_REQUEST['eur_alis']);
		$filtre[":SATIS_EFEK"] 		= FormatSayi::sayi2db($_REQUEST['eur_satis']);
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		$filtre = array();
		$sql = "REPLACE INTO DOVIZ SET 	TARIH 		= :TARIH,
										DOVIZ 		= 'STERLIN', 
										ALIS 		= :ALIS, 
										SATIS		= :SATIS,
										ALIS_EFEK 	= :ALIS_EFEK, 
										SATIS_EFEK	= :SATIS_EFEK
										";
		$filtre[":TARIH"] 			= FormatTarih::nokta2db($_REQUEST['tarih']);
		$filtre[":ALIS"] 			= FormatSayi::sayi2db($_REQUEST['gbp_alis']);
		$filtre[":SATIS"] 			= FormatSayi::sayi2db($_REQUEST['gbp_satis']);
		$filtre[":ALIS_EFEK"] 		= FormatSayi::sayi2db($_REQUEST['gbp_alis']);
		$filtre[":SATIS_EFEK"] 		= FormatSayi::sayi2db($_REQUEST['gbp_satis']);
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
		
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kayıt Yapıldı.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
			
		return $sonuc;
		
	}
	
	public function musteri_cari_id_degistir(){
		
		if($_REQUEST["cari_id"] == -1){
			$_SESSION["cari_id"] = 1;
		} else {
			$_SESSION["cari_id"] = $_REQUEST["cari_id"];
		}
		
		$sonuc["HATA"] 		= FALSE;
		$sonuc["ACIKLAMA"] 	= "Değiştirildi.";
			
		return $sonuc;
		
	}
	
	public function dil_degistir(){
		
		//setcookie("dil", $_REQUEST['dil']);		
		
		$_COOKIE['dil'] 	= $_REQUEST['dil'];
		$_SESSION['dil']	= $_REQUEST['dil'];
		
		$filtre = array();
		$sql = "SELECT ID, TR, ENG, RUS FROM DIL WHERE 1";
		$rows_dil = $this->cdbPDO->rows($sql, $filtre);
		foreach($rows_dil as $key => $row_dil){
			$_SESSION["ENG"][$row_dil->TR]	= $row_dil->ENG;
			$_SESSION["RUS"][$row_dil->TR]	= $row_dil->RUS;
		}
		
		$sonuc["HATA"] 		= FALSE;
		$sonuc["ACIKLAMA"] 	= dil("Değiştirildi");
			
		return $sonuc;
		
	}
	
	public function stok_kaydet(){
		
		if(strlen($_REQUEST["kodu"]) < 3){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "<b>Parça Kodu</b> giriniz!";
			return $sonuc;
		}					
		
		if(strlen($_REQUEST["stok"]) < 1){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "<b>Stok Adını</b> giriniz!";
			return $sonuc;
		}
		
		
		$filtre	= array();
		$sql = "SELECT ID FROM STOK WHERE KODU = :KODU AND ID != :ID";
		$filtre[":KODU"] 			= trim($_REQUEST["kodu"]);
		$filtre[":ID"] 				= $_REQUEST["id"];
		$row_ayni = $this->cdbPDO->row($sql, $filtre);
		
		if($row_ayni->ID > 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Aynı <b>Parça Kodu</b> girilemez!";
			return $sonuc;
		}		
		
		
		$filtre	= array();
		$sql = "SELECT ID, KOD FROM STOK WHERE ID = :ID";
		$filtre[":ID"] 		= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre);
		
		if(is_null($row->ID)){
			 $filtre	= array();
	        $sql = "INSERT INTO STOK SET	PARCA_MARKA_ID		= :PARCA_MARKA_ID,
	        								KODU 				= :KODU,
											OEM_KODU			= :OEM_KODU,
											STOK				= :STOK,
											BARKOD				= :BARKOD,
											KATEGORI_ID			= :KATEGORI_ID,
											MUADIL_KODUS		= :MUADIL_KODUS,
											ACIKLAMA			= :ACIKLAMA,
											GENEL_ACIKLAMA		= :GENEL_ACIKLAMA,
											ADET				= :ADET,
											SATIS_FIYAT 		= :SATIS_FIYAT,											
											DURUM				= :DURUM,
											OZEL_KOD1			= :OZEL_KOD1,
											OZEL_KOD2			= :OZEL_KOD2,
											OZEL_KOD3			= :OZEL_KOD3,
											OZEL_KOD4			= :OZEL_KOD4,
											KOD					= MD5(NOW())
											";
	        $filtre[":PARCA_MARKA_ID"] 		= $_REQUEST["parca_marka_id"];
	        $filtre[":KODU"] 				= trim(strtoupper($_REQUEST["kodu"]));
	        $filtre[":OEM_KODU"] 			= trim($_REQUEST["oem_kodu"]);
	        $filtre[":STOK"] 				= trim($_REQUEST["stok"]);
	        $filtre[":BARKOD"] 				= trim($_REQUEST["barkod"]);
	        $filtre[":KATEGORI_ID"] 		= trim($_REQUEST["kategori_id"]);
	        $filtre[":MUADIL_KODUS"] 		= strtoupper($_REQUEST["muadil_kodus"]);
	        $filtre[":ACIKLAMA"] 			= trim($_REQUEST["aciklama"]);
	        $filtre[":GENEL_ACIKLAMA"] 		= trim($_REQUEST["genel_aciklama"]);	        
	        $filtre[":SATIS_FIYAT"] 		= FormatSayi::sayi2db($_REQUEST["satis_fiyat"]);
	        $filtre[":ADET"] 				= FormatSayi::sayi2db($_REQUEST["adet"]);	        
	        $filtre[":DURUM"] 				= $_REQUEST["durum"] ? 1 : 0;
	        $filtre[":OZEL_KOD1"] 			= trim($_REQUEST["ozel_kod1"]);
	        $filtre[":OZEL_KOD2"] 			= trim($_REQUEST["ozel_kod2"]);
	        $filtre[":OZEL_KOD3"] 			= trim($_REQUEST["ozel_kod3"]);
	        $filtre[":OZEL_KOD4"] 			= trim($_REQUEST["ozel_kod4"]);
	        $STOK_ID = $this->cdbPDO->lastInsertId($sql, $filtre);
        	
			$filtre	= array();
			$sql = "SELECT ID, KOD FROM STOK WHERE ID = :ID";
			$filtre[":ID"] 		= $STOK_ID;
			$row = $this->cdbPDO->row($sql, $filtre);
			
		} else {
			
			if($_REQUEST["kod"] != $row->KOD){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "Kod Hatası!";
				return $sonuc;
			}
			
			$filtre	= array();
	        $sql = "UPDATE STOK SET	PARCA_MARKA_ID		= :PARCA_MARKA_ID,
	        						KODU 				= :KODU,
									OEM_KODU			= :OEM_KODU,
									STOK				= :STOK,
									BARKOD				= :BARKOD,
									KATEGORI_ID			= :KATEGORI_ID,
									MUADIL_KODUS		= :MUADIL_KODUS,
									ACIKLAMA			= :ACIKLAMA,
									GENEL_ACIKLAMA		= :GENEL_ACIKLAMA,
									ADET				= :ADET,
									SATIS_FIYAT 		= :SATIS_FIYAT,
									DURUM				= :DURUM,
									OZEL_KOD1			= :OZEL_KOD1,
									OZEL_KOD2			= :OZEL_KOD2,
									OZEL_KOD3			= :OZEL_KOD3,
									OZEL_KOD4			= :OZEL_KOD4,
									GTARIH				= NOW()
								WHERE ID = :ID
								";
	        $filtre[":PARCA_MARKA_ID"] 		= $_REQUEST["parca_marka_id"];
	        $filtre[":KODU"] 				= trim(strtoupper($_REQUEST["kodu"]));
	        $filtre[":OEM_KODU"] 			= trim($_REQUEST["oem_kodu"]);
	        $filtre[":STOK"] 				= trim($_REQUEST["stok"]);
	        $filtre[":BARKOD"] 				= trim($_REQUEST["barkod"]);
	        $filtre[":KATEGORI_ID"] 		= trim($_REQUEST["kategori_id"]);
	        $filtre[":MUADIL_KODUS"] 		= strtoupper($_REQUEST["muadil_kodus"]);
	        $filtre[":ACIKLAMA"] 			= trim($_REQUEST["aciklama"]);
	        $filtre[":GENEL_ACIKLAMA"] 		= trim($_REQUEST["genel_aciklama"]);
	        $filtre[":ADET"] 				= FormatSayi::sayi2db($_REQUEST["adet"]);	        
	        $filtre[":SATIS_FIYAT"] 		= FormatSayi::sayi2db($_REQUEST["satis_fiyat"]);
	        $filtre[":DURUM"] 				= $_REQUEST["durum"] ? 1 : 0;
	        $filtre[":OZEL_KOD1"] 			= trim($_REQUEST["ozel_kod1"]);
	        $filtre[":OZEL_KOD2"] 			= trim($_REQUEST["ozel_kod2"]);
	        $filtre[":OZEL_KOD3"] 			= trim($_REQUEST["ozel_kod3"]);
	        $filtre[":OZEL_KOD4"] 			= trim($_REQUEST["ozel_kod4"]);
	        $filtre[":ID"] 					= $row->ID;
	        $rowsCount = $this->cdbPDO->rowsCount($sql, $filtre);
			
		}
		
		if($STOK_ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["YENI"]	 	= 1;
			$sonuc["URL"] 		= "/stok/popup_stok.do?route=stok/popup_stok&id={$row->ID}&kod={$row->KOD}";
		} else if($row->ID > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		} else {
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Hatalı!";
		}
		
		return $sonuc;
		
    }

    public function banner_bilgisi(){
		
		$filtre	= array();
		$sql = "SELECT * FROM BANNER_LOGO WHERE ID = :ID";
		$filtre[":ID"] 	= $_REQUEST["id"];
		$row = $this->cdbPDO->row($sql, $filtre); 
		
		if(count($row) > 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
			$sonuc["DUZENLE"]	= $row;
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["DUZENLE"] 	= "Bilgiler Hatalı!";
		}
			
		return $sonuc;
		
	}
	
	public function banner_ekle(){

		if(strlen($_REQUEST["banner_ad"]) <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "<b>Banner Adı</b> giriniz!";
			return $sonuc;
		}

		if($_REQUEST["marka_id"] <= 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "<b>Marka</b> seçiniz!";
			return $sonuc;
		}

		if($_REQUEST["durum_id"] <= 0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "<b>Durum</b> seçiniz!";
			return $sonuc;
		}
		
        $filtre	= array();
        $sql = "INSERT INTO BANNER_LOGO SET		BANNER_AD 	= :BANNER_AD,
        										MARKA_ID	= :MARKA_ID,
        										SIRA 		= :SIRA,
												DURUM		= :DURUM
												";
        $filtre[":BANNER_AD"] 	= trim($_REQUEST["banner_ad"]);
        $filtre[":MARKA_ID"] 	= trim($_REQUEST["marka_id"]);
        $filtre[":SIRA"] 		= trim($_REQUEST["sira"]);
        $filtre[":DURUM"] 		= $_REQUEST["durum_id"];
        $banner_id = $this->cdbPDO->lastInsertId($sql, $filtre);
        
        if($banner_id > 0){
            $sonuc["HATA"] 		= FALSE;
            $sonuc["ACIKLAMA"] 	= "Kaydedildi.";
        }else{
            $sonuc["HATA"] 		= TRUE;
            $sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
        }
        return $sonuc;
		
    }

    public function banner_kaydet(){
		
		if($_REQUEST["durum_id2"] <= 0){
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Durum seçiniz!";
			return $sonuc;
		}

		$filtre	= array();
		$sql = "UPDATE BANNER_LOGO 	SET		BANNER_AD 			= :BANNER_AD,
											MARKA_ID			= :MARKA_ID,
											SIRA 				= :SIRA,
											DURUM 				= :DURUM
											WHERE ID = :ID
											LIMIT 1
											";
		$filtre[":BANNER_AD"] 	= $_REQUEST["banner_ad"];
		$filtre[":MARKA_ID"] 	= $_REQUEST["marka_id2"];
		$filtre[":SIRA"] 		= $_REQUEST["sira"];
		$filtre[":DURUM"] 		= $_REQUEST["durum_id2"];
		$filtre[":ID"] 			= $_REQUEST["id"];
		$rowsCount = $this->cdbPDO->rowsCount($sql, $filtre); 
			
		if($rowsCount>0){
			$sonuc["HATA"] 		= FALSE;
			$sonuc["ACIKLAMA"] 	= "Kaydedildi.";
		}else{
			$sonuc["HATA"] 		= TRUE;
			$sonuc["ACIKLAMA"] 	= "Bilgiler Aynı!";
		}
		
		return $sonuc;
		
	}

}

?>