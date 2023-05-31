<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title> <?=$row_site->TITLE?> </title>
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  	<link rel="stylesheet" href="../bootstrap/fonts/font-awesome.min.css">
  	<link rel="stylesheet" href="../bootstrap/fonts/ionicons.min.css">  
  	<link rel="stylesheet" href="../plugins/select2/select2.min.css">
  	<link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
  	<link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  	<link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
  	<link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  	<link rel="stylesheet" href="../plugins/colorpicker/bootstrap-colorpicker.min.css">
  	<link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
  	<link rel="stylesheet" href="../asset/bootstrap-fileinput-master/css/fileinput.css"/>
  	<link rel="stylesheet" href="../asset/bootstrap-touchspin-master/src/jquery.bootstrap-touchspin.css">
  	<link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  	<link rel="stylesheet" href="../plugins/iCheck/square/blue.css">
  	<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  	<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  	<link rel="stylesheet" href="../asset/flag-icon-css-master/css/flag-icon.min.css">
  	<link rel="stylesheet" href="../asset/croppic/croppic.css">
  	<link rel="stylesheet" href="../asset/flag-icon-css-master/css/flag-icon.min.css">
  	<link rel="stylesheet" href="../asset/1.css">
  	<style>
  		
  	</style>
</head>
<body class="<?=$cBootstrap->getTema()?> sidebar-collapse">	
	
	<div class="wrapper">
		
		<?=$cBootstrap->getHeaderPopup();?>
	  	
	  	<div class="content-wrapper">
		    <section class="content">
		    	<form name="formYpListe" id="formYpListe" class="" enctype="multipart/form-data" method="POST">
					<input type="hidden" name="islem" value="yeni_ihale">
					<input type="hidden" name="form_key" value="<?=fncFormKey()?>">
		    				
		    		<div class="row">
		    			<div class="col-lg-12 col-md-12 col-xs-12">
			          		<div class="nav-tabs-custom">
				            	<ul class="nav nav-tabs" id="myTabs">
					            	<li class="active"><a href="#tab_liste1" data-toggle="tab"> <?=dil("Liste 1")?> </a></li>
				            	</ul>
				            	<div class="tab-content">
				              		<div class="active tab-pane" id="tab_liste1">
				              			<div class="row">
								            <div class="col-md-6">
												<div class="form-group">
												  	<label><?=dil("Tedarikçi")?></label>
												  	<select name="tedarikci_id" id="tedarikci_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
												      	<?=$cCombo->Tedarikciler()->setSecilen($_REQUEST['tedarikci_id'])->setSeciniz()->getSelect("ID","AD")?>
												    </select>
												</div>
											</div>
								            <div class="col-md-3">        
								                <div class="form-group">
									              	<label> <?=dil("Vites Türü")?> </label>
									              	<select name="vites_id" id="vites_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
												      	<?=$cCombo->VitesTuru()->setSecilen($_REQUEST['vites_id'])->setSeciniz()->getSelect("ID","AD")?>
												    </select>
									            </div>
								            </div>
								            <div class="row"></div>
											<div class="col-md-12">        
										        <div class="form-group">
											      	<label> <?=dil("Açıklama")?> </label>
											      	<textarea name="aciklama" id="aciklama" rows="4" cols="80" class="form-control" maxlength="500"><?=$_REQUEST['aciklama']?></textarea>
											    </div>
										    </div>
								        </div>
					              	</div>
					            </div>
				          	</div>
				        </div>
			    	</div>
			    	<div class="row">
			    		<div class="col-lg-12 col-md-12 col-xs-12 text-center">
						   	<button type="button" class="btn btn-success btn-ozel" onclick="fncYpListeYukle()" style="width: 300px;"><?=dil("Listeyi Yükle")?></button>
						</div>
			    	</div>
			    </form>
			</section>
	  	</div>
	  	
	  	<?=$cBootstrap->getFooter()?>
  		
	</div>

	<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="../plugins/jQueryUI/jquery-ui.min.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../plugins/select2/select2.full.min.js"></script>
	<script src="../plugins/raphael/2.1.0/raphael-min.js"></script>
	<script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
	<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../plugins/knob/jquery.knob.js"></script>
	<script src="../plugins/moment/2.11.2/moment.min.js"></script>
	<script src="../plugins/daterangepicker/daterangepicker.js"></script>
	<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="../plugins/datepicker/locales/bootstrap-datepicker.tr.js"></script>
	<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="../plugins/ckeditor/ckeditor.js"></script>
	<script src="../plugins/iCheck/icheck.min.js"></script>
	<script src="../plugins/fastclick/fastclick.js"></script>
	<script src="../asset/bootbox/bootbox.min.js"></script>
	<script src="../dist/js/app.min.js"></script>
	<script src="../asset/bootstrap-maxlength.js"></script>
	<script src="../asset/croppic/jquery.mousewheel.min.js"></script>
	<script src="../asset/croppic/croppic.js"></script>
	<script src="../asset/jquery.cookie.js"></script>
	<script src="../asset/1.js"></script>
	<script>
		$("[data-mask]").inputmask();
		
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		$('.datepicker').datepicker({
	      	format: 'yyyy-mm-dd',
	      	language: 'tr',
	      	autoclose: true,
	      	startDate: '-3d'
	    });
	    
		function fncYpListeYukle(){
			$("#formYpListe").submit();
			/*
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formYpListe').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							window.close();
						});
					}
				}
			});
			*/
		}
		
	</script>
	
</body>
</html>
