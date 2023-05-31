<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$row					= $cSubData->getSessionKullanici($_REQUEST);
	$rows_kul_resim			= $cSubData->getSessionKullaniciResimler($_REQUEST);
	//if($row->YETKI_ID == 1 AND $_SESSION['kullanici_id'] != 1) die("Yetkisiz giriş!");
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/iCheck/square/blue.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
	<div class="page-wrapper">
    <div class="page-inner">
    <?=$cBootstrap->getMenu();?>
	<div class="page-content-wrapper">                    
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
    	
	    <section class="content">
	    	<form name="formHesabim" id="formHesabim">
				<input type="hidden" name="islem" id="islem" value="hesabim_kaydet">
				<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
				<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
		    	<div class="row">
	            	<div class="col-xl-10 offset-xl-1 col-md-12">
	                    <div class="panel">
	                        <div class="panel-hdr bg-primary-300">
	                            <h2> <i class="fas fa-user fa-2x mr-3"></i><?=dil("Hesap Bilgilerim")?> </h2>
	                            <div class="panel-toolbar">
	                                <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
	                                <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
	                                <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
	                            </div>
	                        </div>
	                        <div class="panel-container show">
	                            <div class="panel-content">
	                            	<div class="row">
		                            	<div class="col-md-3 mt-6 text-center">
											<a href="<?=$cSabit->imgPath($row->RESIM_URL)?>" class="magnific-popup-modal">
											  	<img src="<?=$cSabit->imgPath($row->RESIM_URL)?>" class="img-thumbnail shadow" alt="" width="150px">
											</a>
											<br>
											<h3 class="mt-3"> <?=$row->YETKI?> </h3>
											<address class="fs-sm fw-400 mt-4 text-muted" title="Kayıt Tarihi"><i class="far fa-calendar-alt pr-1"></i><?=FormatTarih::tarih($row->TARIH)?></address>
											<address class="fs-sm fw-400 mt-4 text-muted" title="Güncel Tarihi"><i class="far fa-calendar-alt pr-1"></i><?=FormatTarih::tarih($row->GTARIH)?></address>
		                            	</div>
		                            	<div class="col-md-9">
											<ul class="nav nav-tabs justify-content-center" role="tablist">									            	
								            	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_hesap' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_hesap" data-toggle="tab"> <?=dil("Hesap Bilgilerim")?> </a></li>
				                                <li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_resim')?'active':''?>" href="#tab_resim" data-toggle="tab"> <?=dil("Resimler")?> </a></li>
			                                </ul>
			                                <div class="tab-content p-3 shadow">
								          		<div class="tab-pane <?=($_REQUEST['tab']=='tab_hesap' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_hesap">
								          			<div class="row">
												        <div class="col-md-12">
												            <div class="row">
												            	<div class="col-md-12 mb-3">
														            <div class="form-group">
																	  	<label class="form-label"><?=dil("Cari Ünvanı")?></label>
																	  	<input type="text" class="form-control" placeholder="" name="unvan" id="unvan" maxlength="45" value="<?=$row->UNVAN?>">
																	</div>
																</div>
																
																<div class="col-md-6 mb-3">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Vergi Dairesi")?></label>
																	  	<select name="vergi_dairesi_id" id="vergi_dairesi_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
																	      	<?=$cCombo->VergiDairesi()->setSecilen($row->VERGI_DAIRESI_ID)->setSeciniz()->getSelect("ID","AD")?>
																	    </select>
																	</div>
																</div>
																<div class="col-md-6 mb-3">
														        	<div class="form-group">
																	  	<label class="form-label"><?=dil("IBAN")?></label>
																	  	<input type="text" class="form-control" placeholder="" name="iban" id="iban" maxlength="24" value="<?=$row->IBAN?>">
																	</div>
																</div>
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
																	  	<label class="form-label"><?=dil("Kullanıcı Adı")?></label>
																	  	<div class="input-group">
																	  		<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-user"></i></span></div>
																	  		<input type="text" class="form-control" placeholder="" name="kullanici" id="kullanici" maxlength="20" value="<?=$row->KULLANICI?>" disabled>
																	  	</div>
																	</div>
																</div>
																<div class="col-md-6 mb-3">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Şifre")?></label>
																	  	<div class="input-group">
																	      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-key"></i></span></div>
																	      	<input type="password" class="form-control" placeholder="" name="sifre" id="sifre" maxlength="20" value="<?=$row->SIFRE?>">
																	    </div>
																	</div>
																</div>
																<div class="w-100"></div>
																<div class="col-md-12 mb-3">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Mail")?></label>
																	  	<div class="input-group">
																	      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
																	      	<input type="text" class="form-control" placeholder="" name="mail" id="mail" maxlength="100" value="<?=$row->MAIL?>">
																	    </div>
																	</div>
																</div>
																<div class="w-100"></div>
																<div class="col-lg-4 col-md-4 mb-3">        
														            <div class="form-group">
																	    <label class="form-label"><?=dil("Cep Tel")?></label>
																	    <div class="input-group">
																	      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
																	      	<input type="text" class="form-control" name="ceptel" id="ceptel" data-inputmask='"mask": "999(999) 999-9999"' data-mask value="<?=$row->CEPTEL?>">
																	    </div>
																	</div>
														        </div>
														        <div class="col-lg-4 col-md-4 mb-3">        
														            <div class="form-group">
																	    <label class="form-label"><?=dil("Cep Tel2")?></label>
																	    <div class="input-group">
																	      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
																	      	<input type="text" class="form-control" name="ceptel2" id="ceptel2" data-inputmask='"mask": "999(999) 999-9999"' data-mask value="<?=$row->CEPTEL2?>">
																	    </div>
																	</div>
														        </div>
														        <div class="col-lg-4 col-md-4 mb-3">        
														            <div class="form-group">
																	    <label class="form-label"><?=dil("Sabit Tel")?></label>
																	    <div class="input-group">
																	      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
																	      	<input type="text" class="form-control" name="tel" id="tel" data-inputmask='"mask": "999(999) 999-9999"' data-mask value="<?=$row->TEL?>">
																	    </div>
																	</div>
														        </div>
														        <div class="col-lg-3 col-md-3 mb-3">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Mail Gönder")?></label>
																	  	<select name="mail_gonder" id="mail_gonder" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
																	      	<?=$cCombo->MailGondermeDurum()->setSecilen($row->MAIL_GONDER)->getSelect("ID","AD")?>
																	    </select>
																	</div>
																</div>	
																<div class="col-lg-3 col-md-3 mb-3">	
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("SMS Gönder")?></label>
																	  	<select name="sms_gonder" id="sms_gonder" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
																	      	<?=$cCombo->SmsGondermeDurum()->setSecilen($row->SMS_GONDER)->getSelect("ID","AD")?>
																	    </select>
																	</div>
																</div>
																<div class="w-100"></div>
														        <div class="col-lg-3 col-md-3 mb-3">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Yazı Fontu Büyüklüğü")?></label>
																	  	<select name="font_boyut_id" id="font_boyut_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
																	      	<?=$cCombo->FontBoyutlar()->setSecilen($row->FONT_BOYUT_ID)->getSelect("ID","AD")?>
																	    </select>
																	</div>
																</div>
																<div class="col-lg-3 col-md-3 mb-3">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Tema")?></label>
																	  	<select name="tema_id" id="tema_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
																	      	<?=$cCombo->Temalar()->setSecilen($row->TEMA_ID)->getSelect("ID","AD")?>
																	    </select>
																	</div>
																</div>
																<div class="col-md-12 mb-3">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Adres")?></label>
																	  	<textarea name="adres" id="adres" class="form-control" maxlength="255"><?=$row->ADRES?></textarea>
																	</div>
																</div>
															</div>
														</div>
											        </div>
								              	</div>
								              	
								              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_resim')?'active':''?>" id="tab_resim">
								              		<div class="row">
									                	<div class="col-md-6 mb-3">
									    					<div class="panel">
										                    <div class="panel-container show">
										                        <div class="panel-content">
										                        	<div class="panel-tag"><?=dil("Yüklü olan resimler")?></div>
													              	<table class="table table-sm table-condensed">
													              		<thead class="thead-themed">
														                	<tr>
															                  	<th style="width: 10px">#</th>
															                  	<th><?=dil("Resim Adı")?></th>
															                  	<th><?=dil("Tarih")?></th>
															                  	<th> </th>
															                </tr>
															            </thead>
															            <tbody>
															                <?foreach($rows_kul_resim as $key=>$row_resim) {?>
															                <tr>
															                  	<td><?=($key+1)?></td>
															                  	<td><a href="<?=$cSabit->imgPath($row_resim->RESIM_URL)?>" class="magnific-popup-modal" > <?=$row_resim->RESIM_ADI_ILK?> <img src="<?=$row_resim->RESIM_URL?>" style="display:none;" /> </a></td>
															                  	<td><?=FormatTarih::tarih($row_resim->TARIH)?></td>
															                  	<td>
															                  		<a href="javascript:void(0)" onclick="fncResimSil(this)" title="<?=dil("Sil")?>" data-id="<?=$row_resim->ID?>"> <i class="fal fa-trash"></i> </a>
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
									                	<div class="col-md-6 mb-3">
									                		<div class="panel">
										                    <div class="panel-container show">
										                        <div class="panel-content">
													                <div class="form-group">
															           	<div class="col-sm-12 pt-3">
															           		<input id="kullanici_resim" name="kullanici_resim[]" type="file" class="file-loading" data-show-upload="true" data-language="tr" multiple>
															           		<div class="panel-tag mt-2"><?=dil("500x500 boyutunda jpg, png yükleyiniz")?></div>
															           	</div>
															        </div>
															    </div>
															</div>
															</div>
											            </div>
									                </div>
								              	</div>					              	
								            </div>
								            <div class="col-xl-12 mb-3 mt-3 text-center">
												<button type="button" class="btn btn-primary" onclick="fncKullaniciKaydet(this)" title="<?=dil("Kaydet")?>" style="width: 120px;"> <?=dil("Kaydet")?> </button>
											</div>
								        </div>
								    </div>
				      			</div>
				    		</div>
				    	</div>
				    </div>
				    
			    </div>
				
			</form>
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
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    
		$("[data-mask]").inputmask();
		
		
		$("#kullanici_resim").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=kullanici_resim_yukle&id=<?=$row->ID?>',
	        allowedFileExtensions : ['jpg', 'jpeg', 'png'],
	        overwriteInitial: false,
	        maxFileSize: 10000,
	        maxFilesNum: 10,
	        uploadClass: 'btn btn-secondary',
	        removeClass: 'btn btn-secondary',
	        browseClass: 'btn btn-primary btn-file waves-effect waves-themed text-white',
	        uploadAsync: true,
	        //allowedFileTypes: ['image', 'video'],
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#kullanici_resim').on('fileuploaded', function(event, data, previewId, index) {
		   	location.href = "hesabim.do?tab=tab_resim";
		});
		
		function fncKullaniciKaydet(obj){
			$(obj).attr("disabled",true);
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formHesabim').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						toastr.success(jd.ACIKLAMA);
					}
					$(obj).attr("disabled",false);
				}
			});
		}
		
		function fncResimAktif(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "kullanici_resim_aktif", "id": $(obj).data("id") },
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
			bootbox.confirm("<?=dil("Silmek istediğinizden emin misiniz")?>!", function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "kullanici_resim_sil", "id": $(obj).data("id") },
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
		
	</script>
        
</body>
</html>
