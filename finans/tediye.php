<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row = $cSubData->getTediye($_REQUEST);
	
	if($_REQUEST['tahsilat_id'] > 0){
		$row = $cSubData->getTahsilat(array('id'=>$_REQUEST['tahsilat_id']));
		$row->ID = NULL;
	}
	
	if(is_null($row->ID)){
		$row->CARI_ID	= $_REQUEST['cari_id'];
	}
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
   
    <main id="js-page-content" role="main" class="page-content">
    	
        <section class="content">
        	<div class="panel">
				<div class="panel-hdr bg-primary-300 text-white">
                    <h2> <i class="fal fa-lira-sign mr-3"></i> <?=dil("Cari Hesap - Tediye Girişi")?> </h2>
                    <div class="panel-toolbar">
                    	<?if($row->ID > 0){?>
							<a class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> btn-icon rounded-circle waves-effect waves-themed text-white border-white mr-1" href="javascript:fncPopup('/finans/popup_cari_hareket_resim_yukle.do?route=finans/popup_cari_hareket_resim_yukle&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_CARI_HAREKET_RESIM_YUKLE',1100,850);"> <i class="fal fa-upload"></i> </a>
							<a href="<?=fncOdemePopupLink($row)?>" class="btn btn-outline-primary btn-icon rounded-circle waves-effect waves-themed text-white border-white mr-1"> <i class="fal fa-eye"></i>  </a> 
						<?}?>
                    	<button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
						<form name="formTahsilatEkle" id="formTahsilatEkle" class="" enctype="multipart/form-data" method="POST">
							<input type="hidden" name="islem" value="finans_tediye_kaydet">
							<input type="hidden" name="id" value="<?=$row->ID?>">
							<input type="hidden" name="kod" value="<?=$row->KOD?>">
							<input type="hidden" name="form_key" value="<?=fncFormKey()?>">
							
							<div class="row">
								<div class="col-md-3 mb-2 offset-9">
									<div class="form-group">
									  	<div class="input-group">
								      		<input type="text" class="form-control fs-xl" placeholder="" name="talep_np" id="talep_no" maxlength="15" value="" onchange="fncTalepBul(this)">
								      	</div>
									</div>
								</div>
								<div class="w-100"></div>
								<div class="col-md-12 mb-2">   
								    <div class="form-group">
									  	<label class="form-label"> <?=dil("Cari")?> </label>
									  	<select name="cari_id" id="cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
									      	<?=$cCombo->Cariler()->setSecilen($row->CARI_ID)->setTumu()->getSelect("ID","AD")?>
									    </select>
									</div>
								</div>
								<div class="col-md-6 mb-2">       
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Ödeme Kanalı")?> </label>
								      	<select name="odeme_kanali_id" id="odeme_kanali_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" onchange="fncOdemeKanali(this)">
									      	<?=$cCombo->OdemeKanallari()->setSecilen($row->ODEME_KANALI_ID)->setSeciniz()->getSelect("ID","AD")?>
									    </select>
								    </div>
								</div>
								<div class="col-md-6 mb-2">       
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Ödeme Kanalı Detay")?> </label>
								      	<select name="odeme_kanali_detay_id" id="odeme_kanali_detay_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" onchange="fncOdemeKanaliDetay(this)">
									      	<?=$cCombo->OdemeKanaliDetay(array("odeme_kanali_id"=>$row->ODEME_KANALI_ID))->setSecilen($row->ODEME_KANALI_DETAY_ID)->setSeciniz()->getSelect("ID","AD")?>
									    </select>
								    </div>
								</div>
								<div class="col-md-6 mb-2 senet0">
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Plaka")?> </label>
								      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$row->PLAKA?>" maxlength="15">
								    </div>
								</div>
								<div class="col-md-6 mb-2 senet0"> 
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Fatura No")?> </label>
								      	<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" value="<?=$row->FATURA_NO?>" maxlength="16">
								    </div>
								</div>
								<div class="w-100"></div>
								<div class="col-md-6 mb-2 senet1" style="display: none;"> 
									<div class="form-group">
									    <label class="form-label"><?=dil("Senet/Çek Vade Tarihi")?></label>
									    <div class="input-group date">
									    	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									      	<input type="text" class="form-control pull-right datepicker" name="senet_vade_tarih" id="senet_vade_tarih" value="<?=FormatTarih::tarih($row->SENET_VADE_TARIH)?>" readonly>
									    </div>
									</div>
								</div>
								<div class="col-md-6 mb-2 senet1" style="display: none;"> 
									<div class="form-group">
									    <label class="form-label"><?=dil("Senet Düzenlenme Tarih")?></label>
									    <div class="input-group date">
									    	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									      	<input type="text" class="form-control pull-right datepicker" name="senet_tarih" id="senet_tarih" value="<?=FormatTarih::tarih($row->SENET_TARIH)?>" readonly>
									    </div>
									</div>
								</div>
								<div class="col-md-6 mb-2 senet1" style="display: none;"> 
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Senet/Çek Sahibi")?> </label>
								      	<input type="text" class="form-control" placeholder="" name="senet_sahibi" id="senet_sahibi" value="<?=$row->SENET_SAHIBI?>" maxlength="100">
								    </div>
								</div>
								<div class="col-md-6 mb-2 senet1" style="display: none;"> 
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Senet/Çek Ciro")?> </label>
								      	<input type="text" class="form-control" placeholder="" name="senet_borclu" id="senet_borclu" value="<?=$row->SENET_BORCLU?>" maxlength="100">
								    </div>
								</div>
								<div class="col-md-6 mb-2 senet1" style="display: none;"> 
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Senet/Çek No")?> </label>
								      	<input type="text" class="form-control" placeholder="" name="senet_no" id="senet_no" value="<?=$row->SENET_NO?>" maxlength="100">
								    </div>
								</div>
								<div class="col-md-6 mb-2 senet1" style="display: none;"> 
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Hesap No")?> </label>
								      	<input type="text" class="form-control" placeholder="" name="senet_hesap_no" id="senet_hesap_no" value="<?=$row->SENET_HESAP_NO?>" maxlength="100">
								    </div>
								</div>
								<div class="w-100"></div>
								<div class="col-md-6 mb-2"> 
									<div class="form-group">
									    <label class="form-label"><?=dil("Ödeme Tarih")?></label>
									    <div class="input-group date">
									    	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									      	<input type="text" class="form-control pull-right datepicker" name="fatura_tarih" id="fatura_tarih" value="<?=FormatTarih::tarih($row->FATURA_TARIH)?>" readonly>
									    </div>
									</div>
								</div>
								<div class="col-md-6 mb-2">
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Tutar")?></label>
								      	<div class="input-group date">
									      	<input type="text" class="form-control" placeholder="" name="tutar" id="tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->TUTAR)?>" maxlength="10">
									      	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
									    </div>
								    </div>
								</div>
								<div class="col-md-6 mb-2">					            
								    <div class="form-group">
									  	<label class="form-label"><?=dil("Finans Kalemi")?></label>
									  	<select name="finans_kalemi_id" id="finans_kalemi_id" class="form-control select2" style="width: 100%;">
									      	<?=$cCombo->FinansKalemiGider()->setSecilen($_REQUEST['finans_kalemi_id'])->setTumu()->getSelect("ID","AD")?>
									    </select>
									</div>
								</div>
								<div class="col-md-12 mb-2">        
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Açıklama")?> </label>
								      	<textarea name="aciklama" id="aciklama" rows="4" cols="80" class="form-control" maxlength="500"><?=$row->ACIKLAMA?></textarea>
								    </div>
								</div>
								<div class="col-md-12 text-center">
									<div class="form-group">
								      	<label class="form-label"></label>   
								    	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncKaydet()"><?=dil("Kaydet")?></button>
								    </div>
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-right">
					<div class="help-block"><?=dil("Kayıt Yapan")?>: <span class="fw-700"><?=$row->KAYIT_YAPAN?></span>, <?=dil("Kayıt Tarih")?>: <span class="fw-700"><?=FormatTarih::tarih($row->TARIH)?></span></div>	
				</div>
			</div>
		</section>
		
    </main>    
    </div>
    </div>
            
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
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
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();		
		
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		function fncFinansKalemi(){
			if($("#finans_kalemi_id").val() == 1){
				$("#ihale_id").parent().parent().hide();
				$("#cari_id").parent().parent().show();
			} else if($("#finans_kalemi_id").val() == 2){
				$("#ihale_id").parent().parent().show();
				$("#cari_id").parent().parent().hide();
			} else if($("#finans_kalemi_id").val() == 3){
				$("#ihale_id").parent().parent().hide();
				$("#cari_id").parent().parent().show();
			}
			
		}
		
		function fncKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formTahsilatEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else if(jd.YENI){
						$("#tutar").val(0);
						toastr.success(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						//window.opener.location.reload(false);
						//window.close();
					}
				}
			});	
		}
		
		function fncSenetGosterGizle(){
			if($("#odeme_kanali_id").val() == 4 || $("#odeme_kanali_id").val() == 5){
				//$(".senet0").hide();
				$(".senet1").show();
			} else {
				//$(".senet0").show();
				$(".senet1").hide();
			}
		}
		fncSenetGosterGizle();
		
		function fncOdemeKanali(obj){
			fncSenetGosterGizle();
			
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "odeme_kanali_detay_doldur2", 'odeme_kanali_id': $(obj).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$("#odeme_kanali_detay_id").html(jd.HTML);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncTalepBul(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_talep_bul", 'talep_no': $("#talep_no").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$("#cari_id").val(jd.CARI_ID).select2();
						$("#plaka").val(jd.PLAKA);
						toastr.success(jd.ACIKLAMA);
					}
				}
			});
		}
		
		function fncOdemeKanaliDetay(obj){
			if($("#odeme_kanali_id").val() == 4 || $("#odeme_kanali_id").val() == 5){
				$(obj).attr("disabled", "disabled");
				$.ajax({
					url: '/class/db_kayit.do?',
					type: "POST",
					data: { "islem": "senet_doldur", 'cari_hareket_id': $(obj).val() },
					dataType: 'json',
					async: true,
					success: function(jd) {
						if(jd.HATA){
							toastr.warning(jd.ACIKLAMA);
						}else{
							$("#senet_vade_tarih").val(jd.SENET_VADE_TARIH);
							$("#senet_tarih").val(jd.SENET_TARIH);
							$("#senet_sahibi").val(jd.SENET_SAHIBI);
							$("#senet_borclu").val(jd.SENET_BORCLU);
							$("#senet_no").val(jd.SENET_NO);
							$("#senet_hesap_no").val(jd.SENET_HESAP_NO);
							$("#fatura_tarih").val(jd.FATURA_TARIH);
							$("#tutar").val(jd.TUTAR);
						}
						$(obj).removeAttr("disabled");
					}
				});
			}
		}
		
	</script>
    
</body>
</html>
