<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$row				= $cSubData->getUyeIsyeri($_REQUEST);
	$rows_resim			= $cSubData->getUyeIsyeriResimler($_REQUEST);
	kod_kontrol($row);
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
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
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
            <li class="breadcrumb-item"><a href="/kullanici/uye_islerleri.do?route=kullanici/uye_islerleri"><?=dil("Üye İşyeri Listesi")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Üye İşyeri Düzenle")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-xl-10 offset-xl-1 col-md-12">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-gradient">
                        <h2> <?=dil("Üye İşyeri Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                        	<a href="/kullanici/uye_isyeri_ekle.do?route=kullanici/uye_islerleri&yetki_id=<?=$row->YETKI_ID?>" class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" title="Üye İşyeri Ekle"><i class="far fa-plus-circle"></i></a>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<form name="formUyeDuzenle" id="formUyeDuzenle">
							<input type="hidden" name="islem" id="islem" value="uye_isyeri_kaydet">
							<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
							<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
							
							<div class="row">
								<div class="col-xl-3 col-md-2 text-center mt-5">							        
									<?if(file_exists ($_SERVER['DOCUMENT_ROOT'].$row->RESIM_URL) AND !is_null($row->RESIM_URL)){?>
										<a href="<?=$row->RESIM_URL?>" class="magnific-popup-modal"> <img src="<?=$row->RESIM_URL?>" class="img-responsive center-block" alt="<?=$row->RESIM_ADI?>" width="150px"> </a>
									<?}else{?>
										<img src="/img/150x150.png" width="150px">
									<?}?>
									<br>
									<h3 class="mt-3"> <?=$row->KULLANICI?> </h3>
									<h5> (<?=$row->YETKI?>) </h5>
									<address class="fs-sm fw-400 mt-4 text-muted" title="Kayıt Tarihi"><i class="far fa-calendar-alt pr-1"></i><?=FormatTarih::tarih($row->TARIH)?></address>
									<address class="fs-sm fw-400 mt-4 text-muted" title="Güncel Tarihi"><i class="far fa-calendar-alt pr-1"></i><?=FormatTarih::tarih($row->GTARIH)?></address>
									<br>
								</div>
								<div class="col-xl-9 col-md-10">
									<ul class="nav nav-tabs justify-content-center" role="tablist">
		                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_site' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_site" data-toggle="tab"> <?=dil("Üye İşyeri Bilgileri")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_resim')?'active':''?>" href="#tab_resim" data-toggle="tab"> <?=dil("Resim")?> </a></li>
		                            </ul>
		                            <div class="tab-content p-3 shadow">
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_site' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_site">						          		
							            	<div class="row">
							            		<?if(in_array($row->YETKI_ID, array(5))){?>
									            <div class="col-md-12 mt-3 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Müsteri")?></label>
													  	<select name="musteri_id" id="musteri_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
													      	<?=$cCombo->Musteriler()->setSecilen($row->MUSTERI_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
												</div>
												<?}?>
												<?if(in_array($row->YETKI_ID, array(10,11,17))){?>
												<div class="col-md-3 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Şirket Türü")?></label>
													  	<select name="sahis_sirket" id="sahis_sirket" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
													      	<?=$cCombo->FirmaTuru()->setSecilen($row->SAHIS_SIRKET)->getSelect("ID","AD")?>
													    </select>
													</div>	
												</div>
												<?}?>
							            		<div class="col-md-3 mb-3">
									            	<div class="form-group">
													  	<label class="form-label"><?=dil("TCK / VKN")?></label>
													  	<input type="text" class="form-control" placeholder="" name="tck" id="tck" maxlength="11" value="<?=$row->TCK?>">
													</div>
												</div>
												<div class="col-md-6 mb-3">
									            	<div class="form-group">
													  	<label class="form-label"><?=dil("Ünvan")?></label>
													  	<input type="text" class="form-control" placeholder="" name="unvan" id="unvan" maxlength="50" value="<?=$row->UNVAN?>">
													</div>
												</div>
												<div class="row"></div>
												<div class="col-md-6 mb-3">
									            	<div class="form-group">
													  	<label class="form-label"><?=dil("Adı")?></label>
													  	<input type="text" class="form-control" placeholder="" name="ad" id="ad" maxlength="45" value="<?=$row->AD?>">
													</div>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Soyadı")?></label>
													  	<input type="text" class="form-control" placeholder="" name="soyad" id="soyad" maxlength="45" value="<?=$row->SOYAD?>">
													</div>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Mail")?></label>
													  	<div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
													      	<input type="text" class="form-control" placeholder="" name="mail" id="mail" maxlength="100" value="<?=$row->MAIL?>">
													    </div>
													</div>
												</div>
												<div class="w-100"></div>
												<div class="col-md-4 mb-3">        
									                <div class="form-group">
													    <label class="form-label"><?=dil("Cep Tel")?></label>
													    <div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
													      	<input type="text" class="form-control" name="ceptel" id="ceptel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->CEPTEL?>">
													    </div>
													</div>
									            </div>
									            <div class="col-md-4 mb-3">        
									                <div class="form-group">
													    <label class="form-label"><?=dil("Cep Tel2")?></label>
													    <div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
													      	<input type="text" class="form-control" name="ceptel2" id="ceptel2" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->CEPTEL2?>">
													    </div>
													</div>
									            </div>
									            <div class="col-md-4 mb-3">        
									                <div class="form-group">
													    <label class="form-label"><?=dil("Sabit Tel")?></label>
													    <div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
													      	<input type="text" class="form-control" name="tel" id="tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->TEL?>">
													    </div>
													</div>
									            </div>
												<div class="w-100"></div>													
									            <div class="col-md-12 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Adres")?></label>
													  	<textarea name="adres" id="adres" class="form-control" maxlength="255"><?=$row->ADRES?></textarea>
													</div>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("İl")?></label>
													  	<select name="il_id" id="il_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" onchange="fncIlceDoldur()">
													      	<?=$cCombo->Iller()->setSecilen($row->IL_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("İlçe")?></label>
													  	<select name="ilce_id" id="ilce_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
													      	<?=$cCombo->Ilceler(array("il_id"=>$row->IL_ID))->setSecilen($row->ILCE_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
												</div>
												<div class="w-100"></div>
												<div class="col-md-3 mb-2 mt-2 text-center">
													<div class="frame-heading mb-0"><?=dil("Durum")?></div>
													<div class="form-check form-check-switch form-check-switch-left">
														<label class="checkbox-inline">
														  	<input type="checkbox" name="durum" id="durum" class="danger" data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" value="1" <?=($row->DURUM==1?'checked':'')?>>
														</label>
													</div>
												</div>
												<div class="col-md-3 mb-2 mt-2 text-center">
													<div class="frame-heading mb-0"><?=dil("Mail Gönder")?></div>
													<div class="form-check form-check-switch form-check-switch-left">
														<label class="checkbox-inline">
														  	<input type="checkbox" name="mail_gonder" id="mail_gonder" class="danger" data-toggle="toggle" data-on="Gönderilsin" data-off="İstemiyor" data-onstyle="success" data-offstyle="danger" value="1" <?=($row->MAIL_GONDER==1?'checked':'')?>>
														</label>
													</div>
												</div>
												<div class="col-md-3 mb-2 mt-2 text-center">
													<div class="frame-heading mb-0"><?=dil("Sms Gönder")?></div>
													<div class="form-check form-check-switch form-check-switch-left">
														<label class="checkbox-inline">
														  	<input type="checkbox" name="sms_gonder" id="sms_gonder" class="danger" data-toggle="toggle" data-on="Gönderilsin" data-off="İstemiyor" data-onstyle="success" data-offstyle="danger" value="1" <?=($row->SMS_GONDER==1?'checked':'')?>>
														</label>
													</div>
												</div>
												<div class="w-100"></div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Yazı Fontu Büyüklüğü")?></label>
													  	<select name="font_boyut_id" id="font_boyut_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
													      	<?=$cCombo->FontBoyutlar()->setSecilen($row->FONT_BOYUT_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
												</div>
												<div class="col-md-6 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Tema")?></label>
													  	<select name="tema_id" id="tema_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
													      	<?=$cCombo->Temalar()->setSecilen($row->TEMA_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
												</div>
												<div class="col-md-12 mb-3 text-center">
													<div class="form-group">
														<button type="button" class="btn btn-primary mt-3 w-25" onclick="fncUyeKaydet()"> <?=dil("Kaydet")?> </button>
													</div>
												</div>
											</div>
					              		</div>
					              		
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_resim')?'active':''?>" id="tab_resim">
						              		<div class="row">
							                	<div class="col-md-6">
							    					<div class="panel">
											    	<div class="panel-container">
								                        <div class="panel-content">
								                        	<div class="panel-tag"><?=dil("Yüklü olan resimler")?></div>
											              	<table class="table table-condensed">
											              		<thead class="thead-themed">
												                	<tr>
													                  	<th style="width: 10px">#</th>
													                  	<th><?=dil("Resim Adı")?></th>
													                  	<th><?=dil("Tarih")?></th>
													                  	<th> </th>
													                </tr>
													            </thead>
													            <tbody>
													                <?foreach($rows_resim as $key=>$row_resim) {?>
													                <tr>
													                  	<td><?=($key+1)?></td>
													                  	<td><a href="<?=$row_resim->RESIM_URL?>" class="magnific-popup-modal" data-gallery> <?=$row_resim->RESIM_ADI_ILK?> </a></td>
													                  	<td><?=FormatTarih::tarih($row_resim->TARIH)?></td>
													                  	<td>
													                  		<a href="javascript:void(0)" onclick="fncResimSil(this)" title="Sil" data-id="<?=$row_resim->ID?>"> <i class="far fa-trash text-danger"></i> </a>
													                  		&nbsp;&nbsp;
													                  		<a href="javascript:void(0)" onclick="fncResimAktif(this)" title="<?=($row_resim->DURUM==1) ? 'Aktif' : 'Aktif Et'?>" data-id="<?=$row_resim->ID?>"> <i class="<?=$row_resim->DURUM==1 ? 'ion-checkmark-circled' : 'ion-checkmark-round'?>"></i> </a>
													                  	</td>
													                </tr>
													                <?}?>
													            </tbody>
											              	</table>
											            </div>
											        </div>
											        </div>
							    				</div>
							                	<div class="col-md-6">
									                <div class="form-group">
											           	<div class="col-sm-12">
											           		<input id="uye_resim" name="uye_resim[]" type="file" class="file-loading" data-show-upload="true" data-language="tr" multiple>
											           		<div class="panel-tag mt-2"><?=dil("500x500 boyutunda jpg, png yükleyiniz")?></div>
											           	</div>
											        </div>
									            </div>
							                </div>
						              	</div>		
				            		</div>
				            		
			            		</div>
			            	</div>
			            	
			            	</form>
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
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		$("#uye_resim").fileinput({
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=uye_isyeri_resim_yukle&id=<?=$row->ID?>',
	        allowedFileExtensions : ['jpg', 'png'],
	        overwriteInitial: false,
	        maxFileSize: 10000,
	        maxFilesNum: 10,
	        uploadAsync: true,
	        //allowedFileTypes: ['image', 'video'],
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#uye_resim').on('fileuploaded', function(event, data, previewId, index) {
		   	location.reload(true);
		});
		
		function fncUyeKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formUyeDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
				}
			});
		}
		
		function fncResimAktif(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "uye_resim_aktif", "id": $(obj).data("id"), "kod": $(obj).data("kod") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							window.location.reload();
						});
					}
				}
			});
		}
		
		function fncSifreSmsGonder(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "sifre_sms_gonder", "id": $(obj).data("id"), "kod": $(obj).data("kod") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							window.location.reload();
						});
					}
				}
			});
		}
		
		function fncResimSil(obj){
			bootbox.confirm('<?=dil("Silmek istediğinizden emin misiniz")?>!', function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "uye_resim_sil", "id": $(obj).data("id") },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {
									window.location.reload();
								});
							}
						}
					});
				}
			});
			
		}
		
		function fncSifreGoster(){
			if ($("#sifre").attr('type') == "password") {
				$("#sifre").attr("type",'input');
			} else {
				$("#sifre").attr("type",'password');
			}
		}
		
		$('.magnific-popup-modal').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
			mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
			image: {
				verticalFit: true
			}
		});
		
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
		
		function fncTurEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formTurEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$('#modalTurEkle').modal('toggle');
							$('#arac_alim_turu_id').append('<option value="'+jd.ARAC_ALIM_TURU.ID+'" title="">'+jd.ARAC_ALIM_TURU.TUR+'</option>');
							$('#arac_alim_turu_id option').last().attr('selected','selected');
						});
					}
				}
			});
		}
		
		$( "#formTurEkle" ).submit(function( event ) {
		  	event.preventDefault();
		  	fncTurEkle();
		});
	
	</script>
    
</body>
</html>
