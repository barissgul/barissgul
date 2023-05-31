<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row			= $cSubData->getVale($_REQUEST);
	$rows_gun		= $cSubData->getGunler($_REQUEST);
	$rows_saat		= $cSubData->getSaatler($_REQUEST);
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
            <li class="breadcrumb-item"><a href="/tanimlama/vale_listesi.do?route=tanimlama/vale_listesi"><?=dil("Vale Listesi")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Vale")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-lg-12">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-gradient">
                        <h2> <?=dil("Vale Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<form name="formVale" id="formVale">
							<input type="hidden" name="islem" id="islem" value="kullanici_vale_kaydet">
							<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
							<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
							
							<div class="row">
								<div class="col-md-12">
									<ul class="nav nav-tabs justify-content-center" role="tablist">
		                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_site' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_site" data-toggle="tab"> <?=dil("Çalışma Saatleri")?> </a></li>
		                            </ul>
		                            <div class="tab-content p-3 shadow">
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_site' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_site">						          		
							            	<div class="row">
												<div class="col-md-12 mb-3">	
													<table class="table table-condensed table-sm">
														<thead class="thead-themed"">
															<tr>
																<td colspan="100%" align="center"> <?=dil("Çalışma Saatleri")?> <a href="javascript:void(0);" class="btn btn-default btn-xs btn-icon waves-effect waves-themed" onclick="fncSec()"><i class="fal fa-check"></i></a> </td>
															</tr>
															<tr>
																<td></td>
																<?foreach($rows_saat as $key => $row_saat){?>
																<td align="center"><?=$row_saat->CALISMA_SAAT?></td>
																<?}?>
															</tr>
														</thead>
														<tbody>
															<?foreach($rows_gun as $key => $row_gun){?>
															<tr>
																<td class="bg-gray-100"><?=$row_gun->CALISMA_GUN?></td>
																<?
																foreach($rows_saat as $key2 => $row_saat){
																	$key2 = $row_gun->ID2 . $row_saat->ID2;
																	?>
																	<td align="center">
																		<div class="custom-control custom-switch custom-control-inline mr-0">
								                                            <input type="checkbox" class="custom-control-input" name="calisma_gunsaat[<?=$key2?>]" id="calisma_gunsaat<?=$key2?>" value="<?=$key2?>" <?=(in_array($key2,$row->CALISMA_GUNSAAT)?'checked':'')?>>
				                                                        	<label class="custom-control-label" for="calisma_gunsaat<?=$key2?>"> </label>
								                                        </div>
																	</td>
																<?}?>
															</tr>
															<?}?>
														</tbody>
													</table>
												</div>
												
												<div class="col-md-12 text-center mt-3">
													<button type="button" class="btn btn-primary" onclick="fncValeKaydet()" style="width: 120px;"> <?=dil("Kaydet")?> </button>
												</div>
											</div>
					              		</div>
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
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-duallistbox-master/src/jquery.bootstrap-duallistbox.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		function fncValeKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formVale').serialize(),
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
		
		function fncSec(){
			$("[type=checkbox]").attr("checked","checked");
		}
		
	</script>
    
</body>
</html>
