<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows				= $cSubData->getSiteBanner();
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
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/plugin/iCheck/square/blue.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
	<div class="page-wrapper">
    <div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">                    
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
    	
	    <section class="content">
	    	<div class="row">
	    		<div class="col-md-12">
	    			<div class="panel">
                        <div class="panel-hdr bg-primary-300 text-white">
                            <h2> <?=dil("Site Banner")?> - <?=$row_site->ID?> </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				       			<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                            </div>
                            
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
			              		<div class="row pt-3">
				                	<div class="col-sm-6">
				    					<div class="panel">
				    					<div class="panel-hdr">
						    				<h2> <i class="fal fa-image fa-2x mr-3"></i> <?=dil("Resim Listesi (Yüklü)")?></h2>
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
										                  	<th style="width: 10px">#</th>
										                  	<th><?=dil("Resim Adı")?></th>
										                  	<th><?=dil("Tarih")?></th>
										                  	<th> </th>
										                </tr>
									                </thead>
									                <tbody>
										                <?foreach($rows as $key=>$row) {?>
										                <tr>
										                  	<td><?=($key+1)?></td>
										                  	<td>
										                  		<?if(is_pdf($cSabit->imgPathFile($row->URL))){?>
										                  			<i class="fal fa-file-pdf fa-4x"></i>
										                  		<?} else if(is_file($cSabit->imgPathFile($row->URL))){?>
													                <a href="<?=$cSabit->imgPath($row->URL)?>" data-fancybox="resim-gallery" data-title="<?=$row->EVRAK?> - <?=$row->RESIM_ADI_ILK?>" data-footer="<?=FormatTarih::tarih($row->TARIH)?>">
															          	<img class="img-thumbnail lazy" alt="" src="/img/loading2.gif" data-src="<?=$cSabit->imgPath($row->URL)?>" width="100"/>
															        </a>
														        <?} else {?>
														        	<a href="/img/100x100.png" title="<?=$cSabit->imgPathFile($row->URL)?>"> <img src="/img/100x100.png" class="img-responsive center-block " style="width:152px;height: 100px"> </a>
														        <?}?>
										                  	</td>
										                  	<td><?=FormatTarih::tarih($row->TARIH)?></td>
										                  	<td>
										                  		<a href="javascript:void(0)" onclick="fncSiteBannerSil(this)" title="<?=dil("Sil")?>" class="btn btn-danger btn-icon" data-id="<?=$row->ID?>"> <i class="fal fa-trash"></i> </a>
										                  		&nbsp;&nbsp;
										                  		<a href="javascript:void(0)" onclick="fncSiteBannerAktif(this)"  class="btn btn-danger btn-icon" title="<?=($row->DURUM==1) ? dil("Aktif") : dil("Aktif Et")?>" data-id="<?=$row->ID?>"> <i class="<?=$row->DURUM==1 ? 'ion-checkmark-circled' : 'ion-checkmark-round'?> fa-lg"></i> </a>
										                  	</td>
										                </tr>
										                <?}?>
									                </tbody>
								              	</table>
								            </div>
								        </div>
								        </div>
				    				</div>
				                	<div class="col-sm-6">
						                <div class="form-group">
								           	<div class="col-sm-12">
								           		<input id="site_banner" name="site_banner[]" type="file" class="file-loading" data-show-upload="true" data-language="tr" multiple>
								           		<div class="panel-tag mt-2"><?=dil("jpg, jpeg, png, webp formatında yükleyiniz!")?></div>
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
	</div>

	<script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
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
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/piexif.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/purify.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.js"></script>
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/ckeditor/ckeditor.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
	<script>
		
		$("[data-mask]").inputmask();
		$("img.lazy").lazy();
		
		$("#site_banner").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=site_banner_yukle',
	        allowedFileExtensions : ['jpg', 'jpeg', 'png', 'webp'],
	        overwriteInitial: false,
	        maxFileSize: 10000,
	        maxFilesNum: 10,
	        uploadAsync: true,
	        uploadClass: 'btn btn-secondary',
	        removeClass: 'btn btn-secondary',
	        browseClass: 'btn btn-primary btn-file waves-effect waves-themed text-white',
	        //allowedFileTypes: ['image', 'video'],
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#site_banner').on('fileuploaded', function(event, data, previewId, index) {
		   	location.reload(true);
		});
		
		
		function fncSiteBannerSil(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "site_banner_sil", "id": $(obj).data("id") },
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
		
		function fncSiteBannerAktif(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "site_banner_aktif", "id": $(obj).data("id") },
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
