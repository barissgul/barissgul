<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows_cari_aktarma = $cSubData->getCariAktarmalar($_REQUEST);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/iCheck/square/blue.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
	<div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
        <section class="content">
        
	    	<div class="panel">
	            <div class="panel-hdr bg-primary-300 bg-primary-gradient">
	                <h2> <i class="fal fa-user mr-3"></i> <?=dil("Cari Aktarma")?> </h2>
	                <div class="panel-toolbar">
	                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                </div>
	            </div>
	            <div class="panel-container show">
	                <div class="panel-content">
						<form name="formCariAktar" id="formCariAktar" class="" enctype="multipart/form-data" method="POST">
							<input type="hidden" name="islem" value="finans_cari_aktar">
							<input type="hidden" name="sifre" id="sifre" value="">
							<div class="row">
	                        	<div class="col-sm-12">
									<div class="row">
										<div class="col-sm-6 col-xs-6 mb-2"> 					            
										    <div class="form-group">
											  	<label class="form-label"><?=dil("Eski Cari")?></label>
											  	<select name="eski_cari_id" id="eski_cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
											      	<?=$cCombo->Cariler()->setSecilen($row->ESKI_CARI_ID)->setTumu()->getSelect("ID","AD")?>
											    </select>
											</div>
										</div>
										<div class="col-sm-6 col-xs-6 mb-2"> 					            
										    <div class="form-group">
											  	<label class="form-label"><?=dil("Yeni Cari")?></label>
											  	<select name="yeni_cari_id" id="yeni_cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
											      	<?=$cCombo->Cariler()->setSecilen($row->YENI_CARI_ID)->setTumu()->getSelect("ID","AD")?>
											    </select>
											</div>
										</div>
										<div class="w-100"></div>
										<div class="col-sm-12 col-xs-4 mb-2">        
										    <div class="form-group">
										      	<label class="form-label"> <?=dil("Açıklama")?> </label>
										      	<textarea name="aciklama" id="aciklama" rows="2" cols="80" class="form-control" maxlength="500"><?=$row->ACIKLAMA?></textarea>
										    </div>
										</div>									
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 text-center mt-3">
									<div class="form-group">
								      	<label class="form-label"></label>
								    	<button type="button" class="btn btn-success btn-ozel" onclick="fncKaydet()"><?=dil("Aktar")?></button>
								    </div>
								</div>
							</div>										
						</form>
					</div>
				</div>
			</div>
			<div class="panel panel-collapsed">	
				<div class="panel-hdr bg-primary-300 bg-primary-gradient">
	                <h2> <i class="fal fa-list mr-3"></i> <?=dil("Cari Aktarma Listesi")?> </h2>
	                <div class="panel-toolbar">
	                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                </div>
	            </div>
	            <div class="panel-container collapse">
	                <div class="panel-content">
						<div class="row">
	                		<div class="col-sm-12">
								<table class="table table-sm table-condensed table-hover" id="parcalar">
									<thead class="thead-themed fw-500">
										<tr>
											<td><?=dil("Eski Cari")?></td>
											<td><?=dil("Yeni Cari")?></td>
											<td><?=dil("Kayıt Tarih")?></td>
											<td><?=dil("Kayıt Yapan")?></td>
											<td><?=dil("Açıklama")?></td>
											<td><?=dil("Aktarılan Cari Hareketler")?></td>
											<td><?=dil("Aktarılan Talepler")?></td>
										</tr>
									</thead>
									<tbody>
										<?foreach($rows_cari_aktarma as $key => $row_cari_aktarma){?>
										  	<td><?=$row_cari_aktarma->ESKI_CARI?></td>
										  	<td><?=$row_cari_aktarma->YENI_CARI?></td>
										  	<td><?=$row_cari_aktarma->KAYIT_YAPAN?></td>
										  	<td><?=$row_cari_aktarma->TARIH?></td>
										  	<td><?=FormatTarih::tarih($row_cari_aktarma->ACIKLAMA)?></td>
										  	<td><?=$row_cari_aktarma->CARI_HAREKET_IDS?></td>
										  	<td><?=$row_cari_aktarma->TALEP_IDS?></td>
										<?}?>
										<tr></tr>
									</tbody>
								</table>
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
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
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
    
		$("[data-mask]").inputmask();		
		
		function fncKaydet(obj){
			bootbox.prompt("Cari Hareket Aktarmak için muhasebe şifreni giriniz!", function(sifre){ 
				$(obj).attr("disabled", "disabled");
				$("#sifre").val(sifre);
				$.ajax({
					url: '/class/db_kayit.do?',
					type: "POST",
					data: $('#formCariAktar').serialize(),
					dataType: 'json',
					async: true,
					success: function(jd) {
						if(jd.HATA){
							toastr.warning(jd.ACIKLAMA);
						}else{
							location.href = jd.URL;
						}
						$(obj).removeAttr("disabled");
					}
				});
			});
			
		}
	</script>
        
</body>
</html>
