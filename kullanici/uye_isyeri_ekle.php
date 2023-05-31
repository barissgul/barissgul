<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	if(in_array($_REQUEST['yetki_id'], array(2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21))){
		$row = $cSubData->getSayKullanici(array('yetki_id'=>$_REQUEST['yetki_id']));
		$_REQUEST['kullanici']	= $row->KULLANICI;
		$_REQUEST['sifre'] 		= $row->SIFRE;
		$_REQUEST['sifre2'] 	= $row->SIFRE;
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <?$cBootstrap->getTemaCss()?>
    <style>
    	.panel-hdr{
			height: 30px;
		}
    </style>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
    	<ol class="breadcrumb page-breadcrumb breadcrumb-seperator-1">
            <li class="breadcrumb-item"><a href="/"><?=dil("Kontrol Paneli")?></a></li>
            <li class="breadcrumb-item"><a href="/kullanici/uye_isyerleri.do?route=kullanici/uye_isyerleri"><?=dil("Üye İşyeri Listesi")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Üye İşyeri Ekle")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        	
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-gradient">
                        <h2> <?=dil("Üye İşyeri Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="panel-container">
                        <div class="panel-content">
		              		<div class="col-12">
		              		<form name="formUyeEkle" id="formUyeEkle">
				          		<input type="hidden" name="islem" id="islem" value="uye_isyeri_ekle">
				          		<input type="hidden" name="okudum" id="okudum" value="1">
					        	<div class="row">
					          		<div class="col-md-12 pb-3 pt-1 bg-primary">
										<div class="form-group">
										  	<label class="form-label h3 text-white"><?=dil("Üye İşyeri Tipi")?></label>
										  	<select name="yetki_id" id="yetki_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Yetkiler1()->setSecilen($_REQUEST['yetki_id'])->setSeciniz()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<?if(in_array($_REQUEST['yetki_id'], array(10,11,17))){?>
									<div class="col-md-3 mb-2 mt-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Şirket Türü")?></label>
										  	<select name="sahis_sirket" id="sahis_sirket" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->FirmaTuru()->setSecilen($_REQUEST['yetki_id'])->getSelect("ID","AD")?>
										    </select>
										</div>	
									</div>
									<?}?>
									<div class="col-md-3 mb-2 mt-2">
						            	<div class="form-group">
										  	<label class="form-label"><?=dil("TCK / VKN")?></label>
										  	<input type="text" class="form-control maxlength" placeholder="" name="tck" id="tck" maxlength="11" value="<?=$_REQUEST['tck']?>">
										</div>
									</div>
									<div class="col-md-6 mb-2 mt-2">
								        <div class="form-group">
											<label class="form-label"><?=dil("Ünvan")?></label>
											<input type="text" class="form-control maxlength" placeholder="" name="unvan" id="unvan" maxlength="100" value="<?=$_REQUEST['unvan']?>">
										</div>
									</div>
									<div class="w-100"></div>
					          		<div class="col-md-4 mb-2">
						            	<div class="form-group">
										  	<label class="form-label"><?=dil("Adı")?></label>
										  	<input type="text" class="form-control maxlength" placeholder="" name="ad" id="ad" maxlength="45" value="<?=$_REQUEST['ad']?>" onchange="this.value=this.value.toUpperCase();">
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Soyadı")?></label>
										  	<input type="text" class="form-control maxlength" placeholder="" name="soyad" id="soyad" maxlength="45" value="<?=$_REQUEST['soyad']?>" onchange="this.value=this.value.toUpperCase();">
										</div>
									</div>
									<div class="w-100"></div>						
									<div class="col-md-4 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Kullanıcı Adı")?></label>
										  	<div class="input-group">
										      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-user"></i></span></div>
										  		<input type="text" class="form-control" placeholder="" name="kullanici" id="kullanici" maxlength="25" value="<?=$_REQUEST['kullanici']?>" onchange="this.value=this.value.toUpperCase();" <?=$row->DISABLED?>>
										  	</div>
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Mail")?></label>
										  	<div class="input-group">
										      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
										      	<input type="text" class="form-control" placeholder="" name="mail" id="mail" maxlength="100" value="<?=$_REQUEST['mail']?>">
										    </div>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-md-4 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Şifre")?></label>
										  	<div class="input-group">
										      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-key"></i></span></div>
										  		<input type="text" class="form-control" placeholder="" name="sifre" id="sifre" maxlength="20" value="<?=$_REQUEST['sifre']?>" <?=$row->DISABLED?>>
										  	</div>
										</div>
									</div>
									<div class="col-md-4 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Şifre Tekrar")?></label>
										  	<div class="input-group">
										      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-key"></i></span></div>
										  		<input type="text" class="form-control" placeholder="" name="sifre2" id="sifre2" maxlength="20" value="<?=$_REQUEST['sifre2']?>" <?=$row->DISABLED?>>
										  	</div>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-md-4 mb-2">        
						                <div class="form-group">
										    <label class="form-label"><?=dil("Cep Tel")?></label>
										    <div class="input-group">
										      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
										      	<input type="text" class="form-control" name="ceptel" id="ceptel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$_REQUEST['ceptel']?>">
										    </div>
										</div>
						            </div>
						            <div class="col-md-4 mb-2">        
						                <div class="form-group">
										    <label class="form-label"><?=dil("Cep Tel2")?></label>
										    <div class="input-group">
										      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
										      	<input type="text" class="form-control" name="ceptel2" id="ceptel2" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$_REQUEST['ceptel2']?>">
										    </div>
										</div>
						            </div>
						            <div class="col-md-4 mb-2">        
								        <div class="form-group">
										    <label class="form-label"><?=dil("Sabit Tel")?></label>
										    <div class="input-group">
										      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
										      	<input type="text" class="form-control" name="tel" id="tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$_REQUEST['tel']?>">
										    </div>
										</div>
								    </div>
									<div class="row"></div>
						            <div class="col-md-12 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Adres")?></label>
										  	<input type="text" class="form-control" placeholder="" name="adres" id="adres" maxlength="255" value="<?=$_REQUEST['adres']?>">
										</div>
									</div>
									<div class="col-md-6 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("İl")?></label>
										  	<select name="il_id" id="il_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" onchange="fncIlceDoldur()">
										      	<?=$cCombo->Iller()->setSecilen($_REQUEST['il_id'])->setSeciniz()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-6 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("İlçe")?></label>
										  	<select name="ilce_id" id="ilce_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Ilceler(array("il_id"=>$_REQUEST['il_id']))->setSecilen($_REQUEST['ilce_id'])->setSeciniz()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-3 mb-2 mt-2 text-center">
										<div class="frame-heading mb-0"><?=dil("Durum")?></div>
										<div class="form-check form-check-switch form-check-switch-left">
											<label class="checkbox-inline">
											  	<input type="checkbox" name="durum" id="durum" class="danger" data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" value="1" checked>
											</label>
										</div>
									</div>
									<div class="col-md-3 mb-2 mt-2 text-center">
										<div class="frame-heading mb-0"><?=dil("Mail Gönder")?></div>
										<div class="form-check form-check-switch form-check-switch-left">
											<label class="checkbox-inline">
											  	<input type="checkbox" name="mail_gonder" id="mail_gonder" class="danger" data-toggle="toggle" data-on="Gönderilsin" data-off="İstemiyor" data-onstyle="success" data-offstyle="danger" value="1" checked>
											</label>
										</div>
									</div>
									<div class="col-md-3 mb-2 mt-2 text-center">
										<div class="frame-heading mb-0"><?=dil("Sms Gönder")?></div>
										<div class="form-check form-check-switch form-check-switch-left">
											<label class="checkbox-inline">
											  	<input type="checkbox" name="sms_gonder" id="sms_gonder" class="danger" data-toggle="toggle" data-on="Gönderilsin" data-off="İstemiyor" data-onstyle="success" data-offstyle="danger" value="1" checked>
											</label>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-md-3 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Yazı Fontu Büyüklüğü")?></label>
										  	<select name="font_boyut_id" id="font_boyut_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->FontBoyutlar()->setSecilen(1)->setSeciniz()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-3 mb-2">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Tema")?></label>
										  	<select name="tema_id" id="tema_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Temalar()->setSecilen(1)->setSeciniz()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-md-2 mb-2 offset-5">
										<div class="form-group">
										  	<label class="form-label">&nbsp;</label><br>
											<button type="button" class="btn btn-primary pull-right form-control" onclick="fncUyeEkle()"><?=dil("Kaydet")?></button>
										</div>
									</div>								
					        	</div>
		              		</form>
		              		</div>
			            </div>
		          	</div>
		          	</div>
		        </div>
		    </div>
		</section>        
		
    </main>    
    </div>
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
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    
		$("[data-mask]").inputmask();
		
		function fncUyeEkle(){			
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formUyeEkle').serialize()+'&'+$.param({ 'arac_alim_turu_id': $('#arac_alim_turu_id').val() }),
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
		
		function fncIlceDoldur(){
			$("#ilce_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "ilce_doldur", 'il_id' : $("#il_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$('#ilce_id').html(jd.HTML);
					}
					$("#ilce_id").removeAttr("disabled");
				}
			});
		};
		
		function fncYetki(){
			$('#formUyeEkle').submit();
		}
		/*
		$( "#sahis_sirket" ).change(function() {
			if($(this).val() == 2){
				$('#soyad').parent().parent().hide();
				$('#soyad').parent().parent().hide();
			}else{
				$('#soyad').parent().parent().show();
			}
		});
		*/	
	</script>
    
</body>
</html>
