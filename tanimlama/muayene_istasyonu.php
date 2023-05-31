<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row	= $cSubData->getMuayeneIstasyonu($_REQUEST);
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
            <li class="breadcrumb-item"><a href="/tanimlama/muayene_istasyonlari.do?route=tanimlama/muayene_istasyonlari"><?=dil("Muayene İstasyonaları")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Muayene İstasyonu")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        	
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-gradient">
                        <h2> <?=dil("Muayene İstasyon Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<form name="formMusteriKaydet" id="formMusteriKaydet">
							<input type="hidden" name="islem" id="islem" value="muayene_istasyonu_kaydet">
							<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
							<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
							
							<div class="row p-2">
								<div class="col-md-12 mb-3">
							    	<div class="form-group">
									  	<label class="form-label"><?=dil("Muayene İstasyonu")?></label>
									  	<input type="text" class="form-control" placeholder="" name="muayene_istasyonu" id="muayene_istasyonu" maxlength="50" value="<?=$row->MUAYENE_ISTASYONU?>">
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group">
									  	<label class="form-label"><?=dil("Mail")?></label>
									  	<div class="input-group">
									      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
									      	<input type="text" class="form-control" placeholder="" name="mail" id="mail" maxlength="100" value="<?=$row->MAIL?>">
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
							    <div class="col-md-4 mb-3">        
							        <div class="form-group">
									    <label class="form-label"><?=dil("Sabit Tel2")?></label>
									    <div class="input-group">
									      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
									      	<input type="text" class="form-control" name="tel2" id="tel2" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->TEL2?>">
									    </div>
									</div>
							    </div>
								<div class="col-md-4 mb-3">
									<div class="form-group">
									  	<label class="form-label"><?=dil("İl")?></label>
									  	<select name="il_id" id="il_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" onchange="fncIlceDoldur()">
									      	<?=$cCombo->Iller()->setSecilen($row->IL_ID)->setSeciniz()->getSelect("ID","AD")?>
									    </select>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="form-group">
									  	<label class="form-label"><?=dil("İlçe")?></label>
									  	<select name="ilce_id" id="ilce_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
									      	<?=$cCombo->Ilceler(array("il_id"=>$row->IL_ID))->setSecilen($row->ILCE_ID)->setSeciniz()->getSelect("ID","AD")?>
									    </select>
									</div>
								</div>
								<div class="w-100"></div>												
							    <div class="col-md-12 mb-3">
									<div class="form-group">
									  	<label class="form-label"><?=dil("Adres")?></label>
									  	<textarea name="adres" id="adres" class="form-control" maxlength="255"><?=$row->ADRES?></textarea>
									</div>
								</div>
								<div class="col-md-3 mb-3">	
									<div class="form-group">
									  	<label class="form-label"><?=dil("Durum")?></label>
									  	<select name="durum" id="durum" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
									      	<?=$cCombo->Durumlar()->setSecilen($row->DURUM)->getSelect("ID","AD")?>
									    </select>
									</div>
								</div>
								<div class="col-md-12 mb-3 text-center">
									<div class="form-group">
									  	<label></label><br>
										<button type="button" class="btn btn-primary" onclick="fncMusteriKaydet()"> <?=dil("Kaydet")?> </button>
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
		
		$("#musteri_resim").fileinput({
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=musteri_resim_yukle&id=<?=$row->ID?>',
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
		
		$('#musteri_resim').on('fileuploaded', function(event, data, previewId, index) {
		   	location.reload(true);
		});
		
		function fncMusteriKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formMusteriKaydet').serialize(),
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
		
	</script>
    
</body>
</html>
