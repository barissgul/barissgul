<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row 				= $cSubData->getTalep($_REQUEST);
	$rows_parca			= $cSubData->getTalepParcalar($_REQUEST);
	$rows_iscilik		= $cSubData->getTalepIscilikler($_REQUEST);
	
	//fncKodKontrol($row);
?>
<!DOCTYPE html>
<html lang="tr" class="<?=$cBootstrap->getFontBoyut()?>">
<head>
    <meta charset="utf-8">
    <title> <?=$row_site->TITLE?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/vendors.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/app.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/page-invoice.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <?$cBootstrap->getTemaCss()?>
    <style>
    	
    </style>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
    
    <main id="js-page-content" role="main" class="page-content">
	 	
	 	<div class="container">
            <div data-size="A4">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-3">
                            <h2 class="keep-print-font fw-500 mb-0 text-primary flex-1 position-relative">
                                <?=$row_site->FIRMA_ADI?>
                                <small class="text-muted mb-0 fs-xs">
                                	<?=$row_site->ADRES?> <br>
                                	<?=dil("TEL")?>: <?=$row_site->TEL1?> <?=dil("GSM")?>: <?=$row_site->TEL2?><br>
                                	<?=$row_site->MAIL?><br>
                                	<?=dil("VKN")?>: <?=$row_site->TCK?> 
                                </small>
                            </h2>
                        </div>
                        <h3 class="fw-300 display-4 fw-500 color-primary-600 keep-print-font pt-1 l-h-n m-0 text-center bg-warning border">
                            <?=dil("EKSPERTİZ HESAP DÖKÜMÜ")?>
                            <a href="javascript:window.print()" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1" title=""> <i class="fal fa-print fs-xl"></i></a>
                        </h3>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-8 d-flex">
                        <table class="table table-clean table-sm">
                            <tbody>
                            	<tr>
                                    <td width="25%"><?=dil("Servis Talep No")?></td>
                                    <td><?=$row->ID?></td>
                                </tr>
                            	<tr>
                                    <td><?=dil("Müşteri")?></td>
                                    <td nowrap><?=$row->CARI?> - <?=$row->CARI_KOD?></td>
                                </tr>
                                <tr>
                                    <td><?=dil("Plaka")?></td>
                                    <td><?=$row->PLAKA?></td>
                                </tr>
                                <tr>
                                    <td><?=dil("Şasi")?> / <?=dil("Motor")?></td>
                                    <td><?=$row->SASI_NO?> / <?=$row->MOTOR_NO?></td>
                                </tr>
                                <tr>
                                    <td><?=dil("Araç")?></td>
                                    <td><?=$row->MARKA?> <?=$row->MODEL?> <?=$row->MODEL_YILI?></td>
                                </tr>
                                <tr>
                                    <td><?=dil("Talep Tarihi")?></td>
                                    <td><?=FormatTarih::tarih($row->TARIH)?></td>
                                </tr>
                                <tr>
                                    <td><?=dil("Tahmini Teslim Tarihi")?></td>
                                    <td><?=FormatTarih::tarih($row->TAHMINI_TESLIM_TARIH)?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--
                    <div class="col-sm-4 ml-sm-auto">
                        <div class="table-responsive">
                            <table class="table table-sm table-clean text-right">
                                <tbody>
                                    <tr>
										<td colspan="2" class="text-center"> <strong><?=dil("Müşteri")?>:</strong> </td>
                                    </tr>
                                    <tr> 
                                    	<td><?=dil("Renk")?></td>
                                    	<td> <?=$row->RENK?> </td> 
                                    </tr>
                                    <tr> 
                                    	<td> <?=$row->MUSTERI_TEL?> </td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    -->
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center border-top-0 table-scale-border-bottom fw-700">#</th>
                                        <th class="border-top-0 table-scale-border-bottom fw-700"><?=dil("Kodu")?></th>
                                        <th class="border-top-0 table-scale-border-bottom fw-700"><?=dil("Parça")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("B.Fiyat")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("Adet")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("Fiyat")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("İskonto")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("Tutar")?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?
									foreach($rows_parca as $key => $row_parca){
										$row_toplam->ADET		+= $row_parca->ADET;
										$row_toplam->FIYAT		+= $row_parca->FIYAT * $row_parca->ADET;
										$row_toplam->ISKONTOLU	+= $row_parca->ISKONTOLU * $row_parca->ADET;
										$row_toplam->TUTAR		+= $row_parca->TUTAR;
										?>
										<tr>
	                                        <td class="text-center fw-700"><?=($key+1)?></td>
	                                        <td class="text-left"><?=$row_parca->PARCA_KODU?></td>
	                                        <td class="text-left"><?=$row_parca->PARCA_ADI?></td>
	                                        <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_parca->FIYAT,2)?></td>
	                                        <td class="text-right"><?=FormatSayi::sayi($row_parca->ADET)?></td>
	                                        <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_parca->FIYAT * $row_parca->ADET,2)?></td>
	                                        <td class="text-right">% <?=FormatSayi::iskontoOran($row_parca->FIYAT, $row_parca->ISKONTOLU)?></td>
	                                        <!--
	                                        <td class="text-right"><i class="fal fa-lira-sign"></i> <?=(float)FormatSayi::sayi($row_parca->FIYAT * $row_parca->ISKONTO / 100 * $row_parca->ADET,2)?></td>
	                                        -->
	                                        <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_parca->TUTAR,2)?></td>
	                                    </tr>
									<?}?>
									<tr>
	                                    <td class="text-right" colspan="7">
	                                        <strong><?=dil("Yedek Parça Toplam")?></strong>
	                                    </td>
	                                    <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_toplam->TUTAR)?></td>
	                                </tr>
									<tr>
                                        <th class="text-center border-top-0 table-scale-border-bottom fw-700">#</th>
                                        <th class="border-top-0 table-scale-border-bottom fw-700"><?=dil("Kodu")?></th>
                                        <th class="border-top-0 table-scale-border-bottom fw-700"><?=dil("İşçilik")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("B.Fiyat")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("Adet")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("Fiyat")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("İskonto")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("Tutar")?></th>
                                    </tr>
									<?
									foreach($rows_iscilik as $key => $row_iscilik){
										$row_toplam_is->ADET		+= $row_iscilik->ADET;
										$row_toplam_is->FIYAT		+= $row_iscilik->FIYAT;
										$row_toplam_is->ISKONTOLU	+= $row_iscilik->ISKONTOLU;
										$row_toplam_is->TUTAR		+= $row_iscilik->TUTAR;
										?>
										<tr>
	                                        <td class="text-center fw-700"><?=($key+1)?></td>
	                                        <td class="text-left"><?=$row_iscilik->PARCA_KODU?></td>
	                                        <td class="text-left"><?=$row_iscilik->PARCA_ADI?></td>
	                                        <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_iscilik->FIYAT,2)?></td>
	                                        <td class="text-right">1,00</td>
	                                        <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_iscilik->FIYAT,2)?></td>
	                                        <td class="text-right">% <?=FormatSayi::iskontoOran($row_iscilik->FIYAT, $row_iscilik->ISKONTOLU)?></td>
	                                        <!--
	                                        <td class="text-right"><i class="fal fa-lira-sign"></i> <?=(float)FormatSayi::sayi($row_iscilik->FIYAT * $row_iscilik->ISKONTO / 100 * $row_iscilik->ADET,2)?></td>
	                                        -->
	                                        <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_iscilik->TUTAR,2)?></td>
	                                    </tr>
									<?}?>
									<tr>
	                                    <td class="text-right" colspan="7">
	                                        <strong><?=dil("İşçilik Toplam")?></strong>
	                                    </td>
	                                    <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_toplam_is->ISKONTOLU)?></td>
	                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-4">
                        
                    </div>
                    <div class="col-sm-4 ml-sm-auto">
                        <table class="table table-clean table-sm">
                            <tbody>
                                <tr>
                                    <td class="text-left">
                                        <strong><?=dil("Alt Toplam")?></strong>
                                    </td>
                                    <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_toplam->FIYAT + $row_toplam_is->FIYAT)?></td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <strong><?=dil("İskonto")?> (% <?=FormatSayi::iskontoOran($row_toplam->FIYAT + $row_toplam_is->FIYAT, $row_toplam->ISKONTOLU + $row_toplam_is->ISKONTOLU)?>) </strong>
                                    </td>
                                    <td class="text-right"><i class="fal fa-lira-sign"></i> <?=(float)FormatSayi::sayi(($row_toplam->FIYAT - $row_toplam->ISKONTOLU) + ($row_toplam_is->FIYAT - $row_toplam_is->ISKONTOLU))?></td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <strong><?=dil("Alt Toplam 2")?></strong>
                                    </td>
                                    <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_toplam->ISKONTOLU + $row_toplam_is->ISKONTOLU)?></td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <strong><?=dil("KDV")?> (%18) </strong>
                                    </td>
                                    <td class="text-right"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi(($row_toplam->TUTAR - $row_toplam->ISKONTOLU) + ($row_toplam_is->TUTAR - $row_toplam_is->ISKONTOLU))?></td>
                                </tr>
                                <tr class="table-scale-border-top border-left-0 border-right-0 border-bottom-0">
                                    <td class="text-left keep-print-font">
                                        <h4 class="m-0 fw-700 h2 keep-print-font color-primary-700"><?=dil("Toplam")?></h4>
                                    </td>
                                    <td class="text-right keep-print-font">
                                        <h4 class="m-0 fw-700 h2 keep-print-font"><i class="fal fa-lira-sign"></i> <?=FormatSayi::sayi($row_toplam->TUTAR + $row_toplam_is->TUTAR)?></h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p class="mt-2 text-muted mb-0">
                            <?=dil("Aracımı eksiksiz olarak teslim aldım.")?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
		
    </main>    
    </div>
    </div>
            
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/jquery-qrcode-master/jquery.qrcode.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    	
    	//$('#qrcode').qrcode({width: 128,height: 128,text:"<?=$row->ID?> - <?=$row->PLAKA?>"});
    	
		$("[data-mask]").inputmask();
		
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});		
		
		
		function fncAracKaydet (){
			/*
			if (window.opener && window.opener !== window) {
			 	window.opener.document.getElementById("musteri_id").trigger("change");
			}
			return false;
			*/
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formAracKaydet').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							window.location.href = jd.URL;
						});
					}
				}
			});
		}
		
		function fncIlceDoldur(il, ilce){
			$(ilce).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "ilce_doldur", 'il_id' : $(il).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$(ilce).html(jd.HTML);
					}
					$(ilce).removeAttr("disabled");
				}
			});
		};
		
		function fncModelDoldur(){
			$("#model_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "model_doldur", 'marka_id' : $("#marka_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$('#model_id').html(jd.HTML);
					}
					$("#model_id").removeAttr("disabled");
				}
			});
		};
		
	</script>
    
</body>
</html>
