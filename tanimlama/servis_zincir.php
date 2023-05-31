<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row			= $cSubData->getServisZincir($_REQUEST);
	
	fncKodKontrol($row);
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
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-duallistbox-master/src/bootstrap-duallistbox.css">
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
            <li class="breadcrumb-item"><a href="/tanimlama/servis_zincir_listesi.do?route=tanimlama/servis_zincir_listesi"><?=dil("Servis Zimcir Listesi")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Servis")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-lg-8 offset-lg-2">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-gradient">
                        <h2> <?=dil("Servis Zincir Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<form name="formServis" id="formServis">
								<input type="hidden" name="islem" id="islem" value="kullanici_servis_zincir_kaydet">
								<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
								<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
								
								<div class="panel-tag">
									<?=$row->UNVAN?> - <?=$row->YETKI?> 
									<span class="badge badge-primary float-right" title="<?=dil("ID")?>"> <?=$row->ID?></span>
									<span class="badge badge-primary float-right mr-1" title="<?=dil("KULLANICI")?>"> <?=$row->KULLANICI?></span>
								</div>	
								<div class="row">
									<div class="col-md-4 mb-3">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Servis Zincir Türü")?></label>
										  	<select name="servis_turu" id="servis_turu" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->ServisTuru()->setSecilen($row->SERVIS_TURU)->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-12">
								    	<div class="form-group">
								      		<label class="form-label"> </label>
								        	<select name="servis_ids[]" id="servis_ids" class="form-control" style="width: 100%; height: 250px" data-tags="true" data-placeholder="Kime" data-allow-clear="true" multiple='multiple'>
								        		<?if($row->YETKI_ID == 20){?>
													<?=$cCombo->Servisler(array("bakim_hizmeti"=>1))->setSecilen($row->SERVIS_IDS)->getSelect("ID","AD")?>
												<?} else if($row->YETKI_ID == 21){?>
													<?=$cCombo->Servisler(array("aku_hizmeti"=>1))->setSecilen($row->SERVIS_IDS)->getSelect("ID","AD")?>
												<?}?>
											</select>
										</div>
								    </div>											
									<div class="col-md-12 text-center mt-3">
										<button type="button" class="btn btn-primary" onclick="fncKaydet()" style="width: 120px;"> <?=dil("Kaydet")?> </button>
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
    <script src="../smartadmin/plugin/bootstrap-duallistbox-master/src/jquery.bootstrap-duallistbox.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		var servis_ids = $('select[name="servis_ids[]"]').bootstrapDualListbox({
			nonSelectedListLabel: '<label class="form-label"> Servisler </label>',
  			selectedListLabel: '<label class="form-label"> Seçili Servisler </label>',
		});
		
		function fncKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formServis').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//location.reload(true);
						});
					}
				}
			});
		}
		
	</script>
    
</body>
</html>
