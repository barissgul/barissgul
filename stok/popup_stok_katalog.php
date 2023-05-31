<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row					= $cSubData->getStok($_REQUEST);
	$rows_stok_katalog		= $cSubData->getStokKataloglar($_REQUEST);
	$rows_stok_katalog_oem	= $cSubData->getStokKataloglarOem($_REQUEST);
	//fncKodKontrol($row);
	
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <link rel="stylesheet" href="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.css">
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
    <div class="page-content-wrapper">
    
    <main id="js-page-content" role="main" class="page-content">        
	 	
	    	<div class="row">
	    		<div class="col-md-12">
	    			<div class="panel" id="panel-1">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <i class="fal fa-cog mr-3"></i> <?=dil("Stok Katalog Bilgileri")?> &nbsp; <span class="badge badge-primary float-right fs-lg"><?=dil("ID:")?> <?=$row->ID?></span> <span class="badge badge-primary float-right ml-2 fs-lg"><?=dil("Parça Kodu:")?> <?=$row->KODU?></span> </h2>
                        <div class="panel-toolbar">
                        	<a href="javascript:fncPopup('/cron/cron_stok_katalog.do?route=stok/cron_stok_katalog&id=<?=$row->ID?>','POPUP_STOK_KATALOG',1100,850);" class="btn btn-outline-danger text-white border-white mr-1" title=""> <?=dil("Parça Kodu")?> </a>
                        	<a href="javascript:fncPopup('/cron/cron_stok_katalog_oem.do?route=stok/cron_stok_katalog&id=<?=$row->ID?>','POPUP_STOK_KATALOG_OEM',1100,850);" class="btn btn-outline-danger text-white border-white mr-1" title=""> <?=dil("Oem Kodu")?> </a>
                        	<a href="javascript:fncPopup('/cron/cron_stok_katalog_resim.do?route=stok/cron_stok_katalog_resim&id=<?=$row->ID?>','POPUP_STOK_KATALOG',1100,850);" class="btn btn-outline-danger text-white border-white btn-icon mr-1" title="Tecdoc Katalog"> <i class="far fa-image fs-xl"></i> </a>
                        	
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content"> 
                        	<div class="row">
                        		<div class="col-md-12">
                        			<div class="panel-tag py-2 mt-1 panel-locked">
										<?=$row->STOK ." - ". $row->ACIKLAMA?> <br>
										<?=dil("Oem Kodu:")?> <?=$row->OEM_KODU?>										
									</div>
                        		</div>
                        		<div class="col-md-12 mt-2">
                                    <ul class="nav nav-tabs  justify-content-center" role="tablist">
                                        <li class="nav-item"><a class="nav-link fs-md py-3 px-4  active" data-toggle="tab" href="#tab_stok" role="tab" aria-selected="true"><?=dil("Uyumlu Araçlar")?></a></li>
                                        <li class="nav-item"><a class="nav-link fs-md py-3 px-4 " data-toggle="tab" href="#tab_oem" role="tab" aria-selected="false"><?=dil("TekDoc Gelen Bilgiler")?></a></li>
                                    </ul>
                                    <div class="tab-content p-1">
                                        <div class="tab-pane fade active show" id="tab_stok" >
                                            <table class="table table-bordered table-hover table-striped w-100 table-sm table-condensed" id="tab1">
                                               <thead class="thead-themed fw-500">
                                                	<tr>
														<td>#</td>
														<td><?=dil("Katalog ID")?></td>
														<td><?=dil("Marka")?></td>
														<td><?=dil("Model")?></td>
														<td><?=dil("Model Tipi")?></td>
														<td><?=dil("Yıl")?></td>
													</tr>
												</thead>
												<tbody>
													<?foreach($rows_stok_katalog as $key => $row_stok_katalog){?>
														<tr>
															<td><?=($key+1)?></td>
															<td><?=$row_stok_katalog->STOK_KATALOG_ID?></td>
															<td><?=$row_stok_katalog->MARKA?></td>
															<td><?=$row_stok_katalog->MODEL?></td>
															<td><?=$row_stok_katalog->MODEL_TIPI?></td>
															<td><?=$row_stok_katalog->YIL_BAS ." - ". $row_stok_katalog->YIL_BIT?></td>
														</tr>
													<?}?>
												</tbody>
											</table>
                                        </div>
                                        <div class="tab-pane fade  active" id="tab_oem">
											<table class="table table-bordered table-hover table-striped w-100 table-sm table-condensed" id="tab2">
                                                <thead class="thead-themed fw-500">
													<tr>
														<td>#</td>
														<td nowrap><?=dil("Katalog ID")?></td>
														<td><?=dil("Marka")?></td>
														<td><?=dil("Model")?></td>
														<td><?=dil("Model Tipi")?></td>
														<td><?=dil("Yıl")?></td>
														<td><?=dil("Parça Markalar")?></td>
													</tr>
												</thead>
												<tbody>
													<?foreach($rows_stok_katalog_oem as $key => $row_stok_katalog){?>
														<tr>
															<td><?=($key+1)?></td>
															<td><?=$row_stok_katalog->ID?></td>
															<td><?=$row_stok_katalog->MARKA?></td>
															<td><?=$row_stok_katalog->MODEL?></td>
															<td><?=$row_stok_katalog->MODEL_TIPI?></td>
															<td><?=$row_stok_katalog->YIL_BAS ." - ". $row_stok_katalog->YIL_BIT?></td>
															<td><?=$row_stok_katalog->PARCA_MARKALAR?></td>
														</tr>
													<?}?>
												</tbody>
											</table>
                                        </div>
                                    </div>
		          				</div>
                        	</div>
                        	                       	
                        	
			            </div>
		          	</div>
		          	</div>
		        </div>
		    </div>
		    
		
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
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
    <script src="../smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
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
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/piexif.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/purify.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		$('#tab1').dataTable({
            //responsive: true, // not compatible
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: false
           
        });
        
        $('#tab2').dataTable({
            //responsive: true, // not compatible
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: false
        });
		
	</script>
    
</body>
</html>
