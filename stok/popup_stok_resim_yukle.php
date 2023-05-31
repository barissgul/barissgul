<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row 				= $cSubData->getStok($_REQUEST);
	$rows_resim			= $cSubData->getStokResimler($_REQUEST);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/smartwizard/smartwizard.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.min.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="<?=$cBootstrap->getBody()?>">
    <div class="page-wrapper">
    <div class="page-inner">
    
    <main id="js-page-content" role="main" class="page-content">
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-lg-12 col-md-12 col-sm-12">		          	
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <i class="fas fa-car mr-3"></i><?=dil("Stok Resim Yükle")?> - <?=$row->KODU?> - <?=$row->STOK?> <span class="badge badge-info ml-1"><?=$row->ID?></span></h2>
                        <div class="panel-toolbar">
						    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
						</div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
		              		<div class="row">
			                	<div class="col-lg-6 col-md-6 mb-3">
			                		<div class="panel">
			                		<div class="panel-hdr">
		                                <h2><i class="fal fa-images mr-3"></i> <?=dil("Resimler")?></h2>
		                                <div class="panel-toolbar">
		                                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
		                                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
		                                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
		                                </div>
		                            </div>
				                    <div class="panel-container show">
				                        <div class="panel-content">
							              	<table class="table table-sm table-condensed">
							              		<thead class="thead-themed">
								                	<tr>
									                  	<td align="center"><b>#</b></td>
									                  	<td align="center"><b><?=dil("Resim")?></b> </td>
									                  	<td> </td>
									                </tr>
									            </thead>
									            <tbody>
									                <?foreach($rows_resim as $key=>$row_resim) {?>
									                <tr>
									                  	<td align="center"><?=($key+1)?></td>
									                  	<td align="center">
									                  		<?if(is_file($cSabit->imgPathFile($row_resim->URL))){?>
												                <a href="javascript:fncPopup('<?=$cSabit->imgPath($row_resim->URL)?>','STOK_RESIM',1100,800);" class="magnific-popup-modal">
														          	<img src="<?=$cSabit->imgPath($row_resim->URL)?>" class="img-thumbnail" alt="" width="100px">
														        </a>
													        <?} else {?>
													        	<img src="/img/100x100.png" class="img-thumbnail" alt="" width="100px">
													        <?}?>
													    </td>
									                  	<td align="center"> 
									                  		<a href="javascript:void(0)" class="mr-3" onclick="fncResimSil(this)" title="Sil" data-id="<?=$row_resim->ID?>"> <i class="far fa-trash text-danger fa-2x"></i> </a>
														    <a href="<?=$cSabit->imgPath($row_resim->URL)?>" class="mr-3"> <i class="far fa-download fa-2x"></i> </a>
														    <a href="javascript:void(0)" onclick="fncResimAktif(this)" title="<?=($row_resim->SIRA==1) ? 'Aktif' : 'Aktif Et'?>" data-id="<?=$row_resim->ID?>"> <i class="fa-2x <?=$row_resim->SIRA==1 ? 'ion-checkmark-circled' : 'ion-checkmark-round'?>"></i> </a>
									                  		<br><span class="mt-3"><?=FormatTarih::tarih($row_resim->TARIH)?></span>
									                  	</td>
									                </tr>
									                <?}?>
									            </tbody>
							              	</table>
							            </div>
							        </div>
							        </div>
			    				</div>
			                	<div class="col-lg-6 col-md-6 mb-1">
					                <div class="form-group">
										<div class="col-sm-12">
							           		<input id="stok_resim" name="stok_resim[]" type="file" class="file-loading" data-show-upload="true" data-language="tr">
							           		<div class="panel-tag mt-2"><?=dil("Maksimum 1000x1000 boyutunda jpg, jpeg, png, gif, webp yükleyiniz.")?></div>
							           	</div>
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
            
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
    <script src="../smartadmin/js/formplugins/smartwizard/smartwizard.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/piexif.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/purify.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.js"></script>
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("#stok_resim").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=stok_resim_yukle&id=<?=$row->ID?>&kod=<?=$row->KOD?>',
	        allowedFileExtensions : ['jpg', 'jpeg', 'png', 'gif', 'webp'],
	        overwriteInitial: false,
	        maxFileSize: 10000,
	        maxFilesNum: 10,
	        uploadClass: 'btn btn-secondary',
	        removeClass: 'btn btn-secondary',
	        browseClass: 'btn btn-primary btn-file waves-effect waves-themed text-white',
	        uploadAsync: true,
	        //allowedFileTypes: ['image', 'video'],
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#stok_resim').on('filebatchuploadcomplete', function(event, data, previewId, index) {
		   	location.reload(true);
		});
		
		function fncResimSil(obj){
			bootbox.confirm('<?=dil("Silmek istediğinizden emin misiniz")?>!', function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "stok_resim_sil", "id": $(obj).data("id") },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
								$(obj).removeAttr("disabled");
							}else{
								toastr.success(jd.ACIKLAMA);
								$(obj).parents("tr").hide();
							}
						}
					});
				}
			});
			
		}
		
		
		function fncResimAktif(obj){
			bootbox.confirm('<?=dil("Kapak resmi yapmak istediğinizden emin misiniz")?>!', function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "stok_resim_aktif", "id": $(obj).data("id") },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
							}else{
								toastr.success(jd.ACIKLAMA);
							}
							location.reload(true);
						}
					});
				}
			});
			
		}
		
	</script>
    
</body>
</html>
