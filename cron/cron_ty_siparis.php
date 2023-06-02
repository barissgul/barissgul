<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	ini_set('max_execution_time', 300);
	//err();
	/*
	"orderDate": Müşterinin trendyol.com üzerinde siparişi oluşturduğu zaman dönmektedir.
	“Awaiting”: Müşterinin trendyol.com üzerinde siparişi oluşturduktan sonra ödeme onayından bekleyen siparişler için bu statü dönmektedir.
	“Created”: Sipariş gönderime hazır statüsünde olduğu zaman dönmektedir.
	“Picking”: Sizin tarafınızdan iletilebilecek bir statüdür. Siparişi toplamaya başladığınız zaman veya paketi hazırlamaya başladığınız zaman iletebilirsiniz.
	“Invoiced”: Siparişin faturasını kestiğiniz zaman bize iletebileceğiniz statüdür.
	“Shipped”: Taşıma durumuna geçen siparişler bu statüde belirtilmektedir.
	“Cancelled”: İptal edilen siparişlerdir.
	“Delivered”: Teslim edilen siparişlerdir.
	“UnDelivered”: Sipariş müşteriye ulaştırılamadığı zaman dönen bilgisidir.
	“UnDeliveredAndReturned”: Müşteriye ulaşmayan siparişin tedarikçiye geri döndüğü bilgisidir.
	*/
	
	$bas_tarih	= strtotime('-2 week', strtotime(date("Y-m-d"))) . "000";
	$bit_tarih	= strtotime(date("Y-m-d")) . "000";
	$surec		= "Picking"; // Created,Picking
	$rows = $cTY->getSiparislerFiltreli($bas_tarih, $bit_tarih, $surec);
	
	if(false){
		var_dump2($rows);die();
	}
	
	foreach($rows->content as $key => $row){
		
		$filtre	= array();
		$sql = "SELECT ID FROM SIPARIS WHERE SIPARIS_KODU = :SIPARIS_KODU";
		$filtre[":SIPARIS_KODU"] 	= $row->orderNumber;
		$row_kontrol 	= $cdbPDO->row($sql, $filtre);
		
		if($row_kontrol->ID > 0) continue;		
		if(is_null($row->orderNumber)) continue;
		
		foreach($row->lines as $key2 => $row_sip){
			
			$row_sd = "";
			if(substr($row_sip->merchantSku, 7, 1) == "A" AND strlen($row_sip->merchantSku) == 8){
				$filtre	= array();
				$sql = "SELECT
							UK.URUN_ID,
							U.URUN_KODU,
	                        UC.SON_EK
						FROM URUN_KASA AS UK
							LEFT JOIN URUN AS U ON U.ID = UK.URUN_ID
							LEFT JOIN URUN_MARKA AS UM ON UM.ID = U.URUN_MARKA_ID
							LEFT JOIN URUN_CINSI AS UC ON UC.ID = U.URUN_CINSI_ID
						WHERE UK.YER_ID = 3 AND U.URUN_MARKA_ID = 1 
							AND CONCAT(LPAD(UK.MARKA_ID,3,0), LPAD(UK.KASA_ID,4,0), UC.SON_EK) = :MAGAZA_KODU
						";
				$filtre[":MAGAZA_KODU"] 	= $row_sip->merchantSku;
				$row_sd 	= $cdbPDO->row($sql, $filtre);
				
			} else if(in_array(substr($row_sip->merchantSku, 7, 1),array("E","T","H","M")) AND strlen($row_sip->merchantSku) == 8){
				$filtre	= array();
				$sql = "SELECT
							UK.URUN_ID,
							U.URUN_KODU,
	                        UC.SON_EK
						FROM URUN_KASA AS UK
							LEFT JOIN URUN AS U ON U.ID = UK.URUN_ID
							LEFT JOIN URUN_MARKA AS UM ON UM.ID = U.URUN_MARKA_ID
							LEFT JOIN URUN_CINSI AS UC ON UC.ID = U.URUN_CINSI_ID
						WHERE UK.YER_ID = 4 AND U.URUN_MARKA_ID = 1 
							AND CONCAT(LPAD(UK.MARKA_ID,3,0), LPAD(UK.KASA_ID,4,0), UC.SON_EK) = :MAGAZA_KODU
						";
				$filtre[":MAGAZA_KODU"] 	= substr($row_sip->merchantSku, 0, 7) . "T";
				$row_sd 	= $cdbPDO->row($sql, $filtre);
				
			}
			
			$filtre = array();
			$sql = "INSERT INTO SIPARIS SET CARI_ID 		= 5,
											URUN_SAYISI		= 1,
											URUN_ADETI		= :URUN_ADETI,
											URUN			= :URUN,
											MAGAZA_KODU		= :MAGAZA_KODU,
											KDV				= 18,
											FIYAT			= :FIYAT,
											TUTAR			= :TUTAR,
											KOMISYON		= :KOMISYON,
											KARGO			= :KARGO,
											KARGO_TAKIP_NO	= :KARGO_TAKIP_NO,
											KARGO_NO		= :KARGO_NO,
											KARGO_LINK		= :KARGO_LINK,
											TAKIP_NO		= :TAKIP_NO,
											SATICI_KODU		= :SATICI_KODU,
											SIPARIS_TARIH	= :SIPARIS_TARIH,
											TARIH			= NOW(),
											KOD				= MD5(NOW()),
											SIPARIS_KODU	= :SIPARIS_KODU,
											ODEME_TIPI		= :ODEME_TIPI,
											SIPARIS_YERI	= :SIPARIS_YERI,
											STATUS			= :STATUS,
											SIPARIS_SUREC_ID= 1
											";
			$filtre[":URUN_ADETI"] 		= $row_sip->quantity;
			$filtre[":URUN"] 			= $row_sip->productName;
			$filtre[":MAGAZA_KODU"] 	= $row_sd->URUN_KODU;
			$filtre[":FIYAT"] 			= $row_sip->amount;
			$filtre[":TUTAR"] 			= $row_sip->price * $row_sip->quantity;
			$filtre[":KOMISYON"] 		= $row_sip->price * $row_sip->quantity * 0.20;
			$filtre[":KARGO"] 			= $row->cargoProviderName;
			$filtre[":KARGO_TAKIP_NO"] 	= $row->cargoTrackingNumber;
			$filtre[":KARGO_NO"] 		= $row->cargoSenderNumber;
			$filtre[":KARGO_LINK"] 		= $row->cargoTrackingLink;
			$filtre[":TAKIP_NO"] 		= $row->cargoSenderNumber; // update()
			$filtre[":SATICI_KODU"] 	= $row_sip->merchantSku;
			$filtre[":ODEME_TIPI"] 		= 0;
			$filtre[":SIPARIS_YERI"] 	= $row->customerId;
			$filtre[":STATUS"] 			= $row->shipmentPackageStatus;
			$filtre[":SIPARIS_TARIH"] 	= date('Y-m-d H:i:s', substr($row->orderDate,0,10));
			$filtre[":SIPARIS_KODU"] 	= $row->orderNumber;
			$SIP_ID = $cdbPDO->lastInsertId($sql, $filtre);
			$arr_sip[] = $SIP_ID;
			
		}	
			
	}
	
	if(@count($arr_sip) > 0){
		$cMail->Gonder("fatihgulgs@gmail.com", "N11 Sipariş" . date("Y-m-d H:i:s"), implode(',', $arr_sip));
	}
	