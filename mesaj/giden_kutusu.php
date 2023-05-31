<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$mesaj_okunmamis_say 	= $cSubData->getMesajOkumamisSay();
	$mesaj_gelen_say 		= $cSubData->getMesajGelenSay();
	$mesaj_giden_say 		= $cSubData->getMesajGidenSay();
	$mesaj_cop_say 			= $cSubData->getMesajCopSay();//bak yine
	$rows_mesaj 			= $cSubData->getMesajGiden();
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
                                <div> <i class="fas fa-folder width-1"></i><?=dil("Gelen Kutusu")?> </div>
                                <div class="fw-400 fs-xs js-unread-emails-count">(<?=$mesaj_gelen_say?>/<?=$mesaj_okunmamis_say?>)</div>
                            </a>
                            <a href="/mesaj/giden_kutusu.do?route=mesaj/giden_kutusu&sayfa=1" class="px-3 px-sm-4 pr-lg-3 pl-lg-5 py-2 fs-md d-flex bg-primary-300 justify-content-between rounded-pill border-top-left-radius-0 border-bottom-left-radius-0">
                                <div> <i class="fas fa-paper-plane width-1"></i><?=dil("Giden Kutusu")?> </div>
                                <div class="fw-400 fs-xs js-unread-emails-count">(<?=$mesaj_giden_say?>)</div>
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
            <div class="d-flex flex-column flex-grow-1 bg-white">
                <div class="flex-grow-0">
                    <div class="d-flex align-items-center pl-2 pr-3 py-3 pl-sm-3 pr-sm-4 py-sm-4 px-lg-5 py-lg-4  border-faded border-top-0 border-left-0 border-right-0 flex-shrink-0">
                        <a href="javascript:void(0);" class="pl-3 pr-3 py-2 d-flex d-lg-none align-items-center justify-content-center mr-2 btn" data-action="toggle" data-class="slide-on-mobile-left-show" data-target="#js-inbox-menu">
                            <i class="fal fa-ellipsis-v h1 mb-0 "></i>
                        </a>
                        <h1 class="subheader-title ml-1 ml-lg-0">
                            <i class="fas fa-plane-alt mr-2 hidden-lg-down"></i><?=dil("Giden Kutusu")?>
                        </h1>
                        <div class="d-flex position-relative ml-auto" style="max-width: 23rem;">
                            <i class="fas fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
                            <input type="text" class="form-control bg-subtlelight pl-6" placeholder="Filter emails">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center pl-3 pr-1 py-2 px-sm-4 px-lg-5 border-faded border-top-0 border-left-0 border-right-0">
                        <div class="flex-1 d-flex align-items-center">
                            <div class="custom-control custom-checkbox mr-2 mr-lg-2 d-inline-block">
                                <input type="checkbox" class="custom-control-input checkbox-toggle" id="js-msg-select-all" onclick="fncSecim(this)">
                                <label class="custom-control-label bolder" for="js-msg-select-all"></label>
                            </div>
                            <a href="javascript:void(0);" id="js-delete-selected" class="btn btn-icon rounded-circle mr-1" title="<?=dil("Sil")?>" onclick="fncMesajSil();"><i class="fas fa-trash fs-md"></i></a>
                            <a href="javascript:void(0);" class="btn btn-icon rounded-circle mr-1" title="<?=dil("Yenile")?>" onclick="fncYenile(this);"><i class="fas fa-redo fs-md"></i></a>
                        </div>
                        <div class="text-muted mr-1 mr-lg-3 ml-auto">
                            1 - 50 <span class="hidden-lg-down"> of 135 </span>
                        </div>
                        <div class="d-flex flex-wrap">
                            <button class="btn btn-icon rounded-circle"><i class="fal fa-chevron-left fs-md"></i></button>
                            <button class="btn btn-icon rounded-circle"><i class="fal fa-chevron-right fs-md"></i></button>
                        </div>
                    </div>
                </div>
                <div class="flex-wrap align-items-center flex-grow-1 position-relative bg-gray-50">
                    <div class="position-absolute pos-top pos-bottom w-100 custom-scroll">
                        <div class="d-flex h-100 flex-column">
                            <ul id="js-emails" class="notification notification-layout-2">
                                <?foreach($rows_mesaj as $key => $row_mesaj) {?>
                                <li class="<?=(($row_mesaj->OKUNDU==1)?'':'unread')?>">
                                    <div class="d-flex align-items-center px-3 px-sm-4 px-lg-5 py-1 py-lg-0 height-4 height-mobile-auto">
                                        <div class="custom-control custom-checkbox mr-3 order-1">
                                            <input type="checkbox" class="custom-control-input" id="msg-1">
                                            <label class="custom-control-label" for="msg-1"></label>
                                        </div>
                                        <a href="#" title="starred" class="d-flex align-items-center py-1 ml-2 mt-4 mt-lg-0 ml-lg-0 mr-lg-4 fs-lg color-warning-500 order-3 order-lg-2"><i class="fas fa-star"></i></a>
                                        <div class="d-flex flex-row flex-wrap flex-1 align-items-stretch align-self-stretch order-2 order-lg-3">
                                            <div class="row w-100">
                                                <a href="/mesaj/oku.do?route=mesaj/oku&id=<?=$row_mesaj->ID?>" class="name d-flex width-sm align-items-center pt-1 pb-0 py-lg-1 col-12 col-lg-auto"><?=$row_mesaj->KIME?></a>
                                                <a href="/mesaj/oku.do?route=mesaj/oku&id=<?=$row_mesaj->ID?>" class="name d-flex align-items-center pt-0 pb-1 py-lg-1 flex-1 col-12 col-lg-auto"><?=$row_mesaj->BASLIK?></a>
                                            </div>
                                        </div>
                                        <div class="fs-sm text-muted ml-auto hide-on-hover-parent order-4 position-on-mobile-absolute pos-top pos-right mt-2 mr-3 mr-sm-4 mt-lg-0 mr-lg-2">
                                        	<b><?=dil("Gön")?>:</b> <?=FormatTarih::tarih($row_mesaj->TARIH)?><br>
                                        	<b><?=dil("Oku")?>:</b> <?=FormatTarih::tarih($row_mesaj->OKUNDU_TARIH)?>
                                        </div>
                                    </div>
                                </li>
                                <?}?>
                            </ul>
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
    
		function fncSecim(obj){			
		    if ($(obj).attr("checked")) {
		    	$("input[type='checkbox']").attr("checked", false);
		    } else {
		    	$("input[type='checkbox']").attr("checked", true);
		    }
		}
	  	
		function fncMesajSil(obj){
			var datastr = "";
			$(".mesaj_ckeck:checked").each(function() {
			    datastr += "&id[]=" + this.value
			});
			
		    //console.log(datastr);
		    
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?islem=mesajlari_sil',
				type: "POST",				
				data : datastr,
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
						$(obj).removeAttr("disabled");
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							window.location.reload();
						});
						
					}
				}
			});
		};
		function fncYenile(obj) {
			window.location.reload();
		}
	
	</script>
    
</body>
</html>
