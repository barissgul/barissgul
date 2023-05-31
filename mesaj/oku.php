<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	//var_dump2($_SESSION);
	$row_mesaj				= $cSubData->getMesaj();
	$mesaj_okunmamis_say 	= $cSubData->getMesajOkumamisSay();
	$mesaj_gelen_say 		= $cSubData->getMesajGelenSay();
	$mesaj_giden_say 		= $cSubData->getMesajGidenSay();
	$mesaj_cop_say 			= $cSubData->getMesajCopSay();
	
	$cKayit->mesaj_okundu();
	//$cdbPDO->rowsCount("UPDATE MESAJ SET OKUNDU = 1, OKUMA_TARIH = NOW() WHERE ID = :ID", array(":ID"=>$row_mesaj->ID) );
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
                                <div class="fw-400 fs-xs js-unread-emails-count">(<?=$mesaj_giden_say?>)</div>
                            </a>
                            <a href="/mesaj/cop_kutusu.do?route=mesaj/cop_kutusu&sayfa=1" class="px-3 px-sm-4 pr-lg-3 pl-lg-5 py-2 fs-md d-flex justify-content-between rounded-pill border-top-left-radius-0 border-bottom-left-radius-0">
                                <div> <i class="fas fa-trash width-1"></i><?=dil("Çöp Kutusu")?> </div>
                                <div class="fw-400 fs-xs js-unread-emails-count">(<?=$mesaj_cop_say?>)</div>
                            </a>
                        </div>
                        <div class="px-5 py-3 fs-nano fw-500">
                            1.5 GB (10%) of 15 GB used
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
				                <h2> <?=dil("Mesaj Oku")?> </h2>
				                <div class="panel-toolbar">
				                    <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
				                    <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
				                    <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
				                </div>
				            </div>
				            <div class="panel-container show">
				                <div class="panel-content">
									<form name="formFisEkle" id="formFisEkle" class="" enctype="multipart/form-data" method="POST">
										<input type="hidden" name="islem" value="finans_fis_ekle">
										<input type="hidden" name="form_key" value="<?=fncFormKey()?>">
										
										<div class="row">
											<div class="col-md-6 mb-3">
												<div class="form-group">
										      		<label class="form-label"><?=dil("Kimden")?></label>
										        	<input name="kimden" id="kimden" class="form-control" value="<?=$row_mesaj->KIMDEN?>" readonly>
										      	</div>
										    </div>
										    <div class="col-md-6 mb-3">
												<div class="form-group">
										      		<label class="form-label"><?=dil("Kime")?></label>
										        	<input name="kimden" id="kimden" class="form-control" value="<?=$row_mesaj->KIME?>" readonly>
										      	</div>
										    </div>
											<div class="col-md-12 mb-3">
												<div class="color-fusion-200 fs-sm float-right" title="<?=dil("Gönderim tarihi")?>"> <b><?=dil("Gön")?>:</b> <?=FormatTarih::tarih($row_mesaj->TARIH)?> </div>
												<h3> <?=$row_mesaj->BASLIK?> </h3>
								                <p> <?=$row_mesaj->KONU?> </p>
								                <div class="color-fusion-200 fs-sm float-right" title="<?=dil("Okuma tarihi")?>"> <b><?=dil("Oku")?>:</b> <?=FormatTarih::tarih($row_mesaj->OKUNDU_TARIH)?> </div>
											</div>
											<div class="col-md-12 text-center">
												<?if($row_mesaj->ALICI_DURUM == 1){?>
												<button type="button" class="btn bg-primary-50" data-id="<?=$row_mesaj->ID?>" onclick="fncYanitla(this)" title="<?=dil("Yanıtla")?>"><i class="far fa-reply"></i></button>
												<button type="button" class="btn bg-primary-300 " data-id="<?=$row_mesaj->ID?>" onclick="fncIlet(this)" title="<?=dil("İlet")?>"><i class="far fa-share"></i></button>
												<button type="button" class="btn btn-danger" data-id="<?=$row_mesaj->ID?>" onclick="fncSil(this)" title="<?=dil("Sil")?>"><i class="far fa-trash"></i></button>
												<?}?>
												<button type="button" class="btn btn-success" data-id="<?=$row_mesaj->ID?>" onclick="fncYazdir(this)" title="<?=dil("Yazdır")?>"><i class="far fa-print"></i></button>
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
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		function fncSil(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "mesaj_sil", 'id' : $(obj).data("id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.href = "/mesaj/giden_kutusu.do?route=mesaj/giden_kutusu&sayfa=<?=$_REQUEST['sayfa']?>";
						});
					}
					
				}
			});
		}
		
		function fncIlet(obj){
			location.href = "/mesaj/ilet.do?route=mesaj/ilet&id=" + $(obj).data("id");
		}
		
		function fncYanitla(obj){
			location.href = "/mesaj/yanitla.do?route=mesaj/yanitla&id=" + $(obj).data("id");
		}
		
		function fncYazdir(obj){
			window.print();
		}
		
		function fncOncekiMesaj(){
			<?if($row_mesaj->ONCEKI_MESAJ_ID > 0){?>
				location.href = "/mesaj/oku.do?route=kart/tekneler&id=<?=$row_mesaj->ONCEKI_MESAJ_ID?>";
			<?} else {?>	
				bootbox.alert('<?=dil("İlk Mesaj")?>!', function() {});
				return false;
			<?}?>
			
		}
		
		function fncSonrakiMesaj(){
			<?if($row_mesaj->SONRAKI_MESAJ_ID > 0){?>
				location.href = "/mesaj/oku.do?route=kart/tekneler&id=<?=$row_mesaj->SONRAKI_MESAJ_ID?>";
			<?} else {?>	
				bootbox.alert('<?=dil("Son Mesaj")?>!', function() {});
				return false;
			<?}?>
		}
	
	</script>
    
</body>
</html>
