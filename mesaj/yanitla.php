<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$mesaj_okunmamis_say 	= $cSubData->getMesajOkumamisSay();
	$mesaj_gelen_say 		= $cSubData->getMesajGelenSay();
	$mesaj_giden_say 		= $cSubData->getMesajGidenSay();
	$mesaj_cop_say 			= $cSubData->getMesajCopSay();
	$row_mesaj				= $cSubData->getMesaj();
	//var_dump2($row_mesaj);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-solid.css">
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
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
        
        <div class="d-flex flex-grow-1 p-0">
            <div id="js-inbox-menu" class="flex-wrap position-relative bg-white slide-on-mobile slide-on-mobile-left">
                <div class="position-absolute pos-top pos-bottom w-100">
                    <div class="d-flex h-100 flex-column">
                        <div class="px-3 px-sm-4 px-lg-5 py-4 align-items-center">
                            <div class="btn-group btn-block" role="group" aria-label="Button group with nested dropdown ">
                                <button type="button" class="btn btn-danger btn-block fs-md" data-action="toggle" data-class="d-flex" onclick="location.href = '/mesaj/yaz.do?route=mesaj/yaz'"><?=dil("Mesaj Yaz")?></button>
                            </div>
                        </div>
                        <div class="flex-1 pr-3">
                            <a href="/mesaj/gelen_kutusu.do?route=mesaj/gelen_kutusu&sayfa=1" class="px-3 px-sm-4 pr-lg-3 pl-lg-5 py-2 fs-md d-flex justify-content-between rounded-pill border-top-left-radius-0 border-bottom-left-radius-0 ">
                                <div> <i class="fas fa-folder-open width-1"></i><?=dil("Gelen Kutusu")?> </div>
                                <div class="fw-400 fs-xs js-unread-emails-count">(<?=$mesaj_gelen_say?>/<?=$mesaj_okunmamis_say?>)</div>
                            </a>
                            <a href="/mesaj/giden_kutusu.do?route=mesaj/giden_kutusu&sayfa=1" class="px-3 px-sm-4 pr-lg-3 pl-lg-5 py-2 fs-md d-flex justify-content-between rounded-pill border-top-left-radius-0 border-bottom-left-radius-0">
                                <div> <i class="fas fa-paper-plane width-1"></i><?=dil("Giden Kutusu")?> </div>
                                <div class="fw-400 fs-xs js-unread-emails-count">(<?=$mesaj_gelen_say?>)</div>
                            </a>
                            <a href="/mesaj/cop_kutusu.do?route=mesaj/cop_kutusu&sayfa=1" class="px-3 px-sm-4 pr-lg-3 pl-lg-5 py-2 fs-md d-flex justify-content-between rounded-pill border-top-left-radius-0 border-bottom-left-radius-0">
                                <div> <i class="fas fa-trash width-1"></i><?=dil("Çöp Kutusu")?> </div>
                                <div class="fw-400 fs-xs js-unread-emails-count">(<?=$mesaj_cop_say?>)</div>
                            </a>
                        </div>
                        <div class="px-5 py-3 fs-nano fw-500">
                            1.5 GB (10%) da 15 GB kullanımda
                            <div class="progress mt-1" style="height: 7px;">
                                <div class="progress-bar" role="progressbar" style="width: 11%;" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide-backdrop" data-action="toggle" data-class="slide-on-mobile-left-show" data-target="#js-inbox-menu"></div>            
            <div class="d-flex flex-column flex-grow-1 bg-white pt-4 pr-4">
            	<div class="row">
            		<div class="col-xl-10 offset-xl-1">
		                <div class="panel">
				            <div class="panel-hdr bg-danger-gradient">
				                <h2> <?=dil("Mesaj Yanıtla")?> </h2>
				                <div class="panel-toolbar">
				                    <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
				                    <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
				                    <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
				                </div>
				            </div>
				            <div class="panel-container show">
				                <div class="panel-content">
									<form name="form" id="form" class="" enctype="multipart/form-data" method="GET">
			          					<input type="hidden" name="islem" value="mesaj_ilet">
			          					<input type="hidden" name="ilet_mesaj_id" value="<?=$row_mesaj->ID?>">
										<input type="hidden" name="form_key" value="<?=fncFormKey()?>">
										
										<div class="row">
											<div class="col-md-12 mb-3">
												<div class="form-group">
								              		<label class="form-label"><?=dil("Kimden")?></label>
								                	<input name="kimden" id="kimden" class="form-control" value="<?=$_SESSION['kullanici_adsoyad']?>" readonly>
								              	</div>
								            </div>
								            <div class="col-md-12 mb-3">
								              	<div class="form-group">
								              		<label class="form-label"><?=dil("Kime")?></label>
								                	<select name="kime_id" id="kime_id" class="form-control select2" style="width: 100%;" data-tags="true" data-placeholder="<?=dil("Kime")?>" data-allow-clear="true">
								                		<?if($_SESSION['yetki_id'] > 3 ){?>
														<?=$cCombo->Sorumlular()->setSecilen($row_mesaj->KIMDEN_ID)->setSeciniz()->getSelect("ID","ADSOYAD2")?>
														<?}else if($_SESSION['yetki_id'] < 4){?>
														<?=$cCombo->Kullanicilar()->setSecilen($row_mesaj->KIMDEN_ID)->setSeciniz()->getSelect("ID","ADSOYAD2")?>
														<?}?>
													</select>
								              	</div>
								            </div>
								            <div class="col-md-12 mb-3">
								              	<div class="form-group">
								              		<label class="form-label"><?=dil("Başlık")?></label>
								                	<input name="baslik" id="baslik" class="form-control" placeholder="<?=dil("Başlık")?>" value="RE: <?=$row_mesaj->BASLIK?>">
								              	</div>
								            </div>
								            <div class="col-md-12 mb-3">
								              	<div class="form-group">
								              		<label class="form-label"><?=dil("Konu")?></label>
								                    <textarea name="konu" id="konu" class="form-control" style="height: 300px">
								                    	<br>
									                    <hr>
									                    <b><?=dil("Kimden")?>:</b> <?=$row_mesaj->KIMDEN?>, <br><b><?=dil("Kime")?>:</b> <?=$row_mesaj->KIME?>, <br><b><?=dil("Mesaj Tarihi")?>:</b> <?=FormatTarih::tarih($row_mesaj->TARIH)?>
									                    <hr>
									                    <h3><b><?=$row_mesaj->BASLIK?></b></h3>
									                    <?=$row_mesaj->KONU?>
								                    </textarea>
								              	</div>
								            </div>
											<div class="col-md-12 text-center">        
												<button type="button" class="btn btn-danger btn-ozel" onclick="fncMesajIlet()"><?=dil("Gönder")?></button>
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
        
    </main>  
    <?=$cBootstrap->getFooter()?>
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
	<script src="../smartadmin/plugin/ckeditor/ckeditor.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		CKEDITOR.replace('konu');
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		  	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
	  	
	  	function fncTemizle(){
	  		$('#kime_id').val(-1).trigger('change');
	  		$('#baslik').val("");
	  		$('#konu').val("").trigger('change');
			CKEDITOR.instances.konu.updateElement();
		}
		
	  	function fncMesajIlet(){
	  		CKEDITOR.instances["konu"].updateElement();
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#form').serialize(),
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
	
	</script>
    
</body>
</html>
