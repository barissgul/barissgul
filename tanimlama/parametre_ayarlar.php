<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
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
	    				
	    	<div class="row">
	    		<div class="col-lg-8 offset-lg-2">
	    			<div id="panel-1" class="panel">
                        <div class="panel-hdr bg-primary-300 text-white">
                            <h2> <?=dil("Parametre Ayarları")?> </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="fal fa-window-minimize"></i></button>
                       			<button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="fal fa-expand"></i></button>
                        		<button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="fal fa-times"></i></button>
                            </div>
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
                        		<ul class="nav nav-tabs justify-content-center" role="tablist">	
					            	<li class="nav-item active"><a class="nav-link" href="#tab_bilgiler" data-toggle="tab"> <?=dil("Parametre Ayarları")?> </a></li>
		                          	<li class="nav-item"><a class="nav-link" href="#tab_kur" data-toggle="tab"> <?=dil("Kur Güncelle")?> </a></li>
							        <li class="nav-item"><a class="nav-link" href="#tab_ihale" data-toggle="tab"> <?=dil("İhaleleri Sonlandır")?> </a></li>
							        <li class="nav-item"><a class="nav-link" href="#tab_model" data-toggle="tab"> <?=dil("Model Ekle")?> </a></li>
                                </ul>
                                <div class="tab-content p-3">
					              	<div class="tab-pane active" id="tab_bilgiler">
					              		<form name="formCari" id="formCari" class="" enctype="multipart/form-data" method="POST">
								            <input type="hidden" name="islem" value="site_parametre_kaydet">
								            <input type="hidden" name="id" value="1">	
						          			<div class="row">
										        <div class="col-md-4">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Pert Komisyon Ücreti")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="pert_komisyon_ucreti" id="risk_limiti" value="<?=FormatSayi::nokta2($row_site->PERT_KOMISYON_UCRETI)?>" maxlength="45">
										            </div>
									            </div>
									            <div class="col-md-4">        
									                <div class="form-group">
													  	<label class="form-label"> <?=dil("İhbar süresi")?> </label>
													  	<select name="ihbar_suresi" id="ihbar_suresi" class="form-control select2" style="width: 100%;">
													      	<?=$cCombo->IhbarSuresi()->setSecilen($row_site->IHBAR_SURESI)->getSelect("ID","AD")?>
													    </select>
													</div>
									            </div>
									            <div class="col-md-4">
									            	<div class="form-group">
									            		<label class="form-label">&nbsp;</label><br>
									            		<button type="button" class="btn btn-primary" onclick="fncParametreDuzenle()"><?=dil("Kaydet")?></button>
									            	</div>
									            </div>
								        	</div>
							        	</form>
					              	</div>
					              	<div class="tab-pane" id="tab_kur">
					              		<div class="row">
								            <div class="col-md-12 text-center">
								            	<label class="form-label">&nbsp;</label><br>
								            	<button type="button" class="btn btn-primary" onclick="fncPopup('/cron/cron_doviz_kur_guncelle.do','KUR_GUNCELLE',600,500)"> <?=dil("Kurları Güncelle")?> </button>
								            </div>
							        	</div>
				              		</div>
				              		<div class="tab-pane" id="tab_ihale">
				              			<div class="row">
								            <div class="col-md-12 text-center">
								            	<label class="form-label">&nbsp;</label><br>
								            	<button type="button" class="btn btn-danger" onclick="fncPopup('/cron/cron_ihaleyi_bitir.do','IHALELERI_SONLANDIR',600,500)"> <?=dil("İhaleleri Sonlandır")?> </button>
								            </div>
							        	</div>
					              	</div>
					              	<div class="tab-pane" id="tab_model">
					          			<form name="formModelEkle" id="formModelEkle" class="" enctype="multipart/form-data" method="POST">
							            <input type="hidden" name="islem" value="manuel_model_ekle">
					          			<div class="row">
					          				<div class="col-md-4">        
								                <div class="form-group">
												  	<label class="form-label"> <?=dil("Marka")?> </label>
												  	<select name="marka_id" id="marka_id" class="form-control select2" style="width: 100%;">
												      	<?=$cCombo->Markalar()->setSecilen()->setSeciniz()->getSelect("ID","AD")?>
												    </select>
												</div>
								            </div>
								            <div class="col-md-4">        
								                <div class="form-group">
									              	<label class="form-label"> <?=dil("Model")?> </label>
									              	<input type="text" class="form-control" placeholder="" name="model_adi" id="model_adi" value="" maxlength="45">
									            </div>
								            </div>								            									            
								            <div class="col-md-4">
								            	<div class="form-group">
									            	<label class="form-label">&nbsp;</label><br>
								            		<button type="button" class="btn btn-primary" onclick="fncModelEkle()"><?=dil("Ekle")?></button>
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
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
	<script>
	
		$("[data-mask]").inputmask();
	  	
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		function fncParametreDuzenle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formCari').serialize(),
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
		
		function fncModelEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formModelEkle').serialize(),
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
		
	</script>
	
</body>
</html>
