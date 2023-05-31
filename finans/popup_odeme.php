<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row 				= $cSubData->getCariHareket($_REQUEST);
	$rows_parca			= $cSubData->getCariHareketDetay($_REQUEST);
	
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
                    <div class="col-sm-12">
                        <div class="d-flex align-items-center mb-5">
                            <h2 class="keep-print-font fw-500 mb-0 text-primary flex-1 position-relative">
                                <?=$row_site->FIRMA_ADI?>
                                <small class="text-muted mb-0 fs-xs">
                                   <?=$row_site->ADRES?><br>
                                   Tel: <?=$row_site->TEL1?> Gsm: <?=$row_site->TEL2?>
                                </small>
                                <img id="barcode" alt="" class="position-absolute pos-top pos-right height-10 mt-1 hidden-md-down" src="../img/otokonfor_logo1.png">
                            </h2>
                        </div>
                        <h3 class="fw-300 display-4 fw-500 color-primary-600 keep-print-font pt-3 l-h-n m-0 text-center ">
                            <?=FormatYazi::buyult($row->HAREKET)?> <?=dil("MAKBUZU")?>
                        </h3>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12 d-flex">
                        <div class="table-responsive">
                            <table class="table table-clean table-sm align-self-end">
                                <tbody>
                                	<tr>
                                        <td> </td>
                                        <td class="text-right"><?=dil("İşlem No")?>: <span class="fw-500"> <?=$row->ID?> </span> </td>
                                    </tr>
                                	<tr>
                                        <td width="23%"><?=dil("Cari")?></td>
                                        <td nowrap>: <?=$row->CARI?> - <?=$row->CARI_KOD?></td>
                                    </tr>
                                    <tr>
                                        <td><?=dil("Ödeme Kanalı")?></td>
                                        <td>: <?=$row->ODEME_KANALI?> - <?=$row->ODEME_KANALI_DETAY?></td>
                                    </tr>
                                    <tr>
                                        <td><?=dil("Plaka")?></td>
                                        <td>: <?=$row->PLAKA?></td>
                                    </tr>
                                    <tr>
                                        <td><?=dil("Fatura No")?></td>
                                        <td>: <?=$row->FATURA_NO?></td>
                                    </tr>
                                    <tr>
                                        <td><?=dil("Ödeme Tarihi")?></td>
                                        <td>: <?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
                                    </tr>
                                    <tr>
                                        <td><?=dil("Ödeme Tutar")?></td>
                                        <td>: <i class="fal fa-lira-sign"></i> <?=FormatSayi::db2tr($row->TUTAR)?> </td>
                                    </tr>
                                    <tr>
                                        <td><?=dil("Açıklama")?></td>
                                        <td>: <?=$row->ACIKLAMA?></td>
                                    </tr>
                                    <?if(in_array($row->ODEME_KANALI_ID, array(4))){?>
	                                    <tr>
	                                        <td><?=dil("Çek No")?></td>
	                                        <td>: <?=$row->SENET_NO?></td>
	                                    </tr>
	                                     <tr>
	                                        <td><?=dil("Çek Hesap No")?></td>
	                                        <td>: <?=$row->SENET_HESAP_NO?></td>
	                                    </tr>
	                                    <tr>
	                                        <td><?=dil("Çek Sahibi")?></td>
	                                        <td>: <?=$row->SENET_SAHIBI?></td>
	                                    </tr>
	                                    <tr>
	                                        <td><?=dil("Çek Ciro")?></td>
	                                        <td>: <?=$row->SENET_SAHIBI?></td>
	                                    </tr>
	                                    <tr>
	                                        <td><?=dil("Çek Düzenlenme Tarihi")?></td>
	                                        <td>: <?=FormatTarih::tarih($row->SENET_TARIH)?></td>
	                                    </tr>
	                                    <tr>
	                                        <td><?=dil("Çek Vade Tarihi")?></td>
	                                        <td>: <?=FormatTarih::tarih($row->SENET_VADE_TARIH)?></td>
	                                    </tr>
                                    <?} else if(in_array($row->ODEME_KANALI_ID, array(5))){?>
	                                    <tr>
	                                        <td><?=dil("Senet No")?></td>
	                                        <td>: <?=$row->SENET_NO?></td>
	                                    </tr>
	                                    <tr>
	                                        <td><?=dil("Senet Hesap No")?></td>
	                                        <td>: <?=$row->SENET_HESAP_NO?></td>
	                                    </tr>
	                                    <tr>
	                                        <td><?=dil("Senet Sahibi")?></td>
	                                        <td>: <?=$row->SENET_SAHIBI?></td>
	                                    </tr>
	                                    <tr>
	                                        <td><?=dil("Senet Ciro")?></td>
	                                        <td>: <?=$row->SENET_SAHIBI?></td>
	                                    </tr>
	                                    <tr>
	                                        <td><?=dil("Senet Düzenlenme Tarihi")?></td>
	                                        <td>: <?=FormatTarih::tarih($row->SENET_TARIH)?></td>
	                                    </tr>
	                                    <tr>
	                                        <td><?=dil("Senet Vade Tarihi")?></td>
	                                        <td>: <?=FormatTarih::tarih($row->SENET_VADE_TARIH)?></td>
	                                    </tr>
                                    <?}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                
                <div class="row">
                    <div class="col-sm-12">
                        <p class="mt-2 text-muted mb-0">
                            <?=dil("Ödeme Doğrulama Kod: ")?> <?=$row->ID?> - <?=$row->KOD?>
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
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    
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
