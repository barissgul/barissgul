<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$row_kullanici				= $cSubData->getProfil($_REQUEST);
	//echo json_encode($row_kullanici);die();

	//if($row_kul->YETKI_ID == 1 AND $_SESSION['kullanici_id'] != 1) die("Yetkisiz giriş!");
	if($_SESSION['yetki_id'] == 10 AND $_SESSION['kullanici_id'] != $row_kullanici->PERT_YONETICI_ID) die("Yetkisiz giriş!");
	
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
    <link rel="stylesheet" href="../smartadmin/plugin/iCheck/square/blue.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
	<div class="page-wrapper">
    <div class="page-inner">
    <div class="page-content-wrapper">                    
    <?=$cBootstrap->getHeaderPopup();?>
    <main id="js-page-content" role="main" class="page-content">
       
        <section class="content">
        	<div class="row">
        		<div class="col-xl-6 offset-xl-3">
			    	<div class="panel">
			            <div class="panel-hdr bg-primary-gradient">
			                <h2> <?=dil("Kullanıcı Bilgisi")?> </h2>
			                <div class="panel-toolbar">
			                    <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
			                    <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
			                    <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
			                </div>
			            </div>
			            <div class="panel-container show">
			                <div class="panel-content">
				    			<div class="row">
					            	<?if(in_array($_SESSION['yetki_id'], array(1,2,3))){?>
						          	<div class="col-md-6 col-sm-6 mb-3">
						            	<div class="form-group">
										  	<label class="form-label"><?=dil("Kullanıcı")?></label>
										  	<input type="text" class="form-control" placeholder="" name="kullanici" id="kullanici" maxlength="45" value="<?=$row_kullanici->KULLANICI?>" readonly>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 mb-3">
						            	<div class="form-group">
										  	<label class="form-label"><?=dil("Ünvan")?></label>
										  	<input type="text" class="form-control" placeholder="" name="unvan" id="unvan" maxlength="45" value="<?=$row_kullanici->UNVAN?>" readonly>
										</div>
									</div>
									<?}?>
									<div class="col-md-12 col-sm-12 mb-3">
						            	<div class="form-group">
										  	<label class="form-label"><?=dil("Adı Soyadı")?></label>
										  	<input type="text" class="form-control" placeholder="" name="ad" id="ad" maxlength="45" value="<?=$row_kullanici->ADSOYAD?>" readonly>
										</div>
									</div>
									<div class="col-md-12 col-sm-12 mb-3">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Mail")?></label>
										  	<div class="input-group">
										      	<div class="input-group-append"><span class="input-group-text fs-sm"><i class="far fa-envelope"></i></span></div>
										      	<input type="text" class="form-control" placeholder="" name="mail" id="mail" value="<?=$row_kullanici->MAIL?>" readonly="">
										    </div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 mb-3">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Cep Telefon")?></label>
										  	<div class="input-group">
										      	<div class="input-group-prepend"><span class="input-group-text fs-sm"><i class="far fa-phone"></i></span></div>
										      	<input type="text" class="form-control" placeholder="" name="ceptel" id="ceptel" value="<?=$row_kullanici->CEPTEL?>" readonly="">
										    </div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 mb-3">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Sabit Telefon")?></label>
										  	<div class="input-group">
										      	<div class="input-group-append"><span class="input-group-text fs-sm"><i class="far fa-phone"></i></span></div>
										      	<input type="text" class="form-control" placeholder="" name="tel" id="tel" value="<?=$row_kullanici->TEL?>" readonly="">
										    </div>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Adres")?></label>
										  	<textarea class="form-control" placeholder="" name="adres" id="adres" readonly><?=$row_kullanici->ADRES?></textarea>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Kargo")?></label>
										  	<textarea class="form-control" placeholder="" name="kargo" id="kargo" readonly><?=$row_kullanici->KARGO?></textarea>
										</div>
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
    
    </script>
        
</body>
</html>
