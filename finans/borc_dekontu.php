<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row->CARI_ID	= $_REQUEST['cari_id'];
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
	<div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
        <section class="content">
        
	    	<div class="panel">
	            <div class="panel-hdr bg-primary-300">
	                <h2> <i class="fal fa-lira-sign mr-3"></i> <?=dil("Borç Dekontu")?> </h2>
	                <div class="panel-toolbar">
	                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                </div>
	            </div>
	            <div class="panel-container show">
	                <div class="panel-content">
	                	<form name="formBorcEkle" id="formBorcEkle" class="" enctype="multipart/form-data" method="POST">
							<input type="hidden" name="islem" value="finans_borc_dekontu_kaydet">
							<input type="hidden" name="id" value="<?=$row->ID?>">
							<input type="hidden" name="kod" value="<?=$row->KOD?>">
							<input type="hidden" name="form_key" value="<?=fncFormKey()?>">
							
							<div class="row">
								<div class="col-xl-12 col-sm-12 mb-2">   
								    <div class="form-group">
									  	<label class="form-label"> <?=dil("Cari")?> </label>
									  	<select name="cari_id" id="cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
									      	<?=$cCombo->Cariler()->setSecilen($row->CARI_ID)->setTumu()->getSelect("ID","AD")?>
									    </select>
									</div>
								</div>
								<div class="col-md-3 mb-2">
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Plaka")?> </label>
								      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$row->PLAKA?>" maxlength="15">
								    </div>
								</div>
								<div class="col-md-3 mb-2"> 
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Fatura No")?> </label>
								      	<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" value="<?=$row->FATURA_NO?>" maxlength="16">
								    </div>
								</div>
								<div class="col-md-3 mb-2"> 
									<div class="form-group">
									    <label class="form-label"><?=dil("Borç Tarih")?></label>
									    <div class="input-group date">
									    	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									      	<input type="text" class="form-control pull-right datepicker" name="fatura_tarih" id="fatura_tarih" value="<?=FormatTarih::tarih($row->FATURA_TARIH)?>" readonly>
									    </div>
									</div>
								</div>
								<div class="col-md-3 mb-2">
								    <div class="form-group">
								      	<label class="form-label"> <?=dil("Tutar")?></label>
								      	<div class="input-group date">
									      	<input type="text" class="form-control" placeholder="" name="tutar" id="tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->TUTAR)?>" maxlength="10">
									      	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
									    </div>
								    </div>
								</div>
								<div class="col-md-3 mb-2">
								    <div class="form-group">
									  	<label class="form-label"> <?=dil("Taksit")?> </label>
									  	<select name="taksit" id="taksit" class="form-control select2 select2-hidden-accessible" style="width: 100%">
									      	<?=$cCombo->Taksit()->setSecilen($row->TAKSIT)->getSelect("ID","AD")?>
									    </select>
									</div>
								</div>
								<div class="col-md-3 mb-2">					            
								    <div class="form-group">
									  	<label class="form-label"><?=dil("Finans Kalemi")?></label>
									  	<select name="finans_kalemi_id" id="finans_kalemi_id" class="form-control select2" style="width: 100%;">
									      	<?=$cCombo->FinansKalemiGider()->setSecilen($row->FINANS_KALEMI_ID)->setTumu()->getSelect("ID","AD")?>
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
								    <button type="button" class="btn btn-success btn-ozel" onclick="fncKaydet()"><?=dil("Kaydet")?></button>
								</div>
							</div>
						</form>
					</div>
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
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    
		$("[data-mask]").inputmask();		
		
		function fncKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBorcEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//location.href = jd.URL;
						});
						location.reload();
					}
					$(obj).removeAttr("disabled");
				}
			});	
		}
		
	</script>
        
</body>
</html>
