<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$rows_excel	= $cSubData->getExceller();
?>
<!DOCTYPE html>
<html lang="tr" class="<?=$cBootstrap->getFontBoyut()?>">
<head>
    <meta charset="utf-8">
    <title> <?=$row_site->TITLE?> <?=dil("Ektsre Özet")?></title>
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/smartwizard/smartwizard.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-duallistbox-master/src/bootstrap-duallistbox.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.min.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <link rel="stylesheet" href="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="<?=$cBootstrap->getBody()?>">
    <div class="page-wrapper">
    <div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
    	
    	<section class="content">
	    	<div class="row">
		    	<div class="col-md-8">
			    	<div class="panel">
			    	<div class="panel-hdr bg-primary-300 text-white">
	                    <h2> <i class="fal fa-archive mr-3"></i> <?=dil("Excel Listesi")?> </h2>
	                    <div class="panel-toolbar">
	                    	<button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
					        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
					        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                    </div>
	                </div>
	                <div class="panel-container show">
                        <div class="panel-content">
                        	 <table class="table table-sm table-condensed table-hover">
                        	 	<thead class="thead-themed fw-500">
							    	<tr>
							          	<td align="center">#</td>
							          	<td> <?=dil("Dosya Adı")?> </td>
							          	<td> <?=dil("Açıklama")?> </td>
							          	<td align="center"> <?=dil("Yükleyen")?> </td>
							          	<td align="center"> <?=dil("Onaylayan")?> </td>
							          	<td align="center"> <?=dil("Çalışma Tarih")?> </td>
							          	<!--
							          	<td> <?=dil("Tedarikçi")?> </td>
							          	-->
							          	<td> <?=dil("Tür")?> </td>
							          	<td align="center"> <?=dil("Say")?> </td>
							          	<td> </td>
							        </tr>
							    </thead>
							    <tbody>
							        <?foreach($rows_excel as $key=>$row_excel) {?>
							        <tr>
							          	<td align="center"><?=($key+1)?></td>
							          	<td><a href="<?=$cSabit->imgPath($row_excel->URL)?>" target="_blank"> <?=$row_excel->EXCEL_ILK?> </a></td>
							          	<td><?=$row_excel->ACIKLAMA?></td>
							          	<td align="center"><?=FormatTarih::tarih($row_excel->TARIH)?><br><?=$row_excel->YUKLEYEN?></td>
							          	<td align="center"><?=FormatTarih::tarih($row_excel->ONAY_TARIH)?><br><?=$row_excel->ONAYLAYAN?></td>
							          	<td align="center"><?=FormatTarih::tarih($row_excel->CALISMA_TARIH)?> </td>
							          	<!--
							          	<td><?=$row_excel->TEDARIKCI?></td>
							          	-->
							          	<td><?=$row_excel->TUR?></td>
							          	<td align="center"><?=$row_excel->SAY?></td>
							          	<td style="padding: 0px;" align="center">								          		
							          		<?if($row_gezi->KULLANICI_ID == $_SESSION['kullanici_id'] OR in_array($_SESSION['yetki_id'], array(1,2))) { ?>
							          			<a href="javascript:;" class="btn btn-danger btn-sm" onclick="fncExcelSil(this)" title="Sil" data-id="<?=$row_excel->ID?>" data-kod="<?=$row_excel->KOD?>"> <i class="fas fa-trash"></i> </a>
							          			<a href="javascript:;" class="btn btn-primary btn-sm" onclick="fncExcelOnay(this)" title="Onayla" data-id="<?=$row_excel->ID?>" data-kod="<?=$row_excel->KOD?>"> <i class="fas <?=($row_excel->ONAY==1?'fa-check-circle':'fa-circle')?>"></i> </a>
							          		<?}?>
							          		<a href="javascript:fncPopup('/yedek_parca/excel_in.php?id=<?=$row_excel->ID?>&kod=<?=$row_excel->KOD?>','EXCEL_IN',1250,800)" class="btn btn-success btn-sm" title="Uygula"><i class="fas fa-play"></i></a> 
							          	</td>
							        </tr>
							        <?}?>
							    </tbody>
						    </table>
	  	 				</div>
					</div>
					</div>
			    </div>
			    <div class="col-md-4">
		    		<div class="panel">
				    	<div class="panel-hdr bg-primary-300 text-white">
		                    <h2> <i class="fal fa-upload mr-3"></i> <?=dil("Excel Yükleme")?> </h2>
		                    <div class="panel-toolbar">
		                    	<button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
		                    </div>
		                </div>
		                <div class="panel-container show">
	                        <div class="panel-content">
	                        	<div class="row">
	                        		<!--
						    		<div class="col-lg-12 col-md-12">
										<div class="form-group">
										  	<label class="form-label"><?=dil("Tedarikçi")?></label>
										  	<select name="tedarikci_id" id="tedarikci_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										  		<?if($_SESSION['yetki_id'] == 3){?>
										  			<?=$cCombo->Tedarikciler(array("id"=>$_SESSION['tedarikci_id']))->setSecilen($_REQUEST['tedarikci_id'])->getSelect("ID","AD")?>
										      	<?} else {?>
										      		<?=$cCombo->Tedarikciler()->setSecilen($_REQUEST['tedarikci_id'])->setSeciniz()->getSelect("ID","AD")?>
										      	<?}?>
										    </select>
										</div>
									</div>
									-->
									<div class="col-lg-12 col-md-12 mt-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Açıklama")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="aciklama" id="aciklama" value="<?=$_REQUEST['aciklama']?>" maxlength="255">
									    </div>
									</div>
									<div class="col-md-12 mt-2">
								    	<div class="form-group">
								       		<input id="excel" name="excel" type="file" class="file-loading" data-show-upload="true" data-language="tr">
								    	</div>
									</div>
									<div class="col-md-12 mt-2">
										<div class="panel-tag">
								            <h4>Yüklenecek Dosya:</h4>
								            <p>.xls, .xlsx dosya uzantısı Microsoft Office Excel dosyası yüklenebilir.</p>
								            <p>Örnek Excel dosyası: <a href="/yedek_parca/YP_LISTE.xlsx"> <i class="fas fa-download fa-2x"></i> </a></p>
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
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/formplugins/smartwizard/smartwizard.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
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
    <script src="../smartadmin/plugin/bootstrap-duallistbox-master/src/jquery.bootstrap-duallistbox.js"></script>
    <script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
    <script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("#excel").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=yp_liste_yukle',
	        allowedFileExtensions : ['xls', 'xlsx'],
	        overwriteInitial: false,
	        maxFileSize: 25000,
	        maxFilesNum: 10,
	        uploadClass: 'btn btn-secondary',
	        removeClass: 'btn btn-secondary',
	        browseClass: 'btn btn-primary btn-file waves-effect waves-themed text-white',
	        uploadAsync: true,
	        //allowedFileTypes: ['image', 'video'],
	        uploadExtraData: function() {
			    return {
			        tedarikci_id: $('#tedarikci_id').val(),
			        aciklama: $('#aciklama').val(),
			    };
			},
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#excel').on('filebatchuploadcomplete', function(event, data, previewId, index) {
		   	location.href = "/yedek_parca/excel_yukle.do?route=yedek_parca/excel_yukle";
		});
		
		function fncExcelSil(obj){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: {"islem": "excel_sil", "id": $(obj).data("id"), "kod": $(obj).data("kod")},
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
			});
		}
		
		function fncExcelOnay(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: {"islem": "excel_onay", "id": $(obj).data("id"), "kod": $(obj).data("kod")},
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
