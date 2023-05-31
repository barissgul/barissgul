<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$row				= $cSubData->getModel($_REQUEST);
	$rows_bakim_paket	= $cSubData->getBakimPaketleri(array("model_id"=>$row->ID));	
	
	foreach($rows_bakim_paket as $key => $row_bakim_paket){
		$rows_bakim[$row_bakim_paket->SIRA]	= $row_bakim_paket;
	}
	
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
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
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
            <li class="breadcrumb-item"><a href="/tanimlama/markalar.do?route=tanimlama/markalar"><?=dil("Markalar")?></a></li>
            <li class="breadcrumb-item"><a href="/tanimlama/modeller.do?route=tanimlama/modeller&marka_id=<?=$row->MARKA_ID?>"><?=dil("Modeller")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Model")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-xl-10 offset-xl-1 col-md-12">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-gradient">
                        <h2> <?=$row->MARKA?> <?=$row->MODEL?> </h2>
                        <div class="panel-toolbar">
                        	<a href="/kullanici/ekle.do?route=kullanici/kullanicilar&yetki_id=<?=$row->YETKI_ID?>" class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" title="Kullanıcı Ekle"><i class="far fa-plus-circle"></i></a>
                        	<a href="/kullanici/ekle.do?route=kullanici/kullanicilar&yetki_id=<?=$row->YETKI_ID?>" class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" title="Kullanıcı Ekle"><i class="far fa-plus-circle"></i></a>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<form name="formBakimPaket" id="formBakimPaket">
								<input type="hidden" name="islem" id="islem" value="model_bakim_paket_kaydet">
								<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
								
								<div class="row">
									<div class="col-xl-12">
										<ul class="nav nav-tabs justify-content-center" role="tablist">
			                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_model' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_model" data-toggle="tab"> <?=dil("Bakım Bilgileri")?> </a></li>
			                            </ul>
			                            <div class="tab-content p-3 shadow">
							              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_model' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_model">						          		
								            	<div class="row">
													<div class="col-md-12">
										            	<div class="table-responsive">
													  	<table class="table m-0 table-sm table-hover table-striped table-bordered table-condensed">
													  		<thead class="thead-themed font-weight-bold">
														    	<tr>
														          	<td align="center">#</td>
														          	<td align="center"><?=dil("Kilometre")?></td>
														          	<td align="center"><?=dil("Bakım Adı")?></td>
														          	<td align="center"><?=dil("Detay")?></td>
														        </tr>
														    </thead>
															<tbody>
														        <?for($i = 1; $i <= 25; $i++){?>
															        <tr>
															          	<td align="center"><?=($i)?></td>
															          	<td width="20%">
															          		<div class="input-group">
																	      		<input type="text" class="form-control" placeholder="" name="km[<?=$i?>]" id="km" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 0" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_bakim[$i]->KM,0)?>" maxlength="10">
																	      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-tachometer"></i></span></div>
																	      	</div>
															          	</td>
															          	<td>
															          		<div class="input-group">
																	      		<input type="text" class="form-control" placeholder="" name="bakim_paket[<?=$i?>]" id="bakim_paket" maxlength="255" value="<?=$rows_bakim[$i]->BAKIM_PAKET?>">
																	      	</div>
															          	</td>
															          	<td>
															          		<div class="input-group">
																	      		<input type="text" class="form-control" placeholder="" name="aciklama[<?=$i?>]" id="aciklama" maxlength="1000" value="<?=$rows_bakim[$i]->ACIKLAMA?>">
																	      	</div>
															          	</td>
															        </tr>
														        <?}?>
														    </tbody>
													  	</table>
													  	</div>
													</div>
													<div class="col-md-12 mb-3 text-center">
														<div class="form-group">
															<button type="button" class="btn btn-primary mt-3 w-25" onclick="fncBakimPaketKaydet()"> <?=dil("Kaydet")?> </button>
														</div>
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
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		function fncBakimPaketKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBakimPaket').serialize(),
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
	
	</script>
    
</body>
</html>
