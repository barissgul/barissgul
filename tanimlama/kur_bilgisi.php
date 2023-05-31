<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows_gecmis	= $cSubData->getDovizGecmis();
	$row->TARIH 	= date("Y-m-d");
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
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
    	
        <section class="content">
			<div class="row">
				<div class="col-md-8">
					<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="fal fa-lira-sign mr-3"></i> <?=dil("Kur Bilgisi")?> </h2>
                        <div class="panel-toolbar">
                            
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<form name="formKur" id="formKur" class="" enctype="multipart/form-data" method="POST">
								<input type="hidden" name="islem" value="kur_bilgisi_kaydet">
								<input type="hidden" name="form_key" value="<?=fncFormKey()?>">
							
								<div class="row">
									<div class="col-md-3 col-xs-3 mb-2">
										<div class="form-group">
									        <label class="form-label"><?=dil("Kur Tarihi")?></label>
									        <div class="input-group date">
									          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control datepicker datepicker-inline" name="tarih" id="tarih" value="<?=FormatTarih::tarih($row->TARIH)?>" readonly>
									        </div>
									    </div>
									</div>
									<div class="col-md-3 col-xs-3 mb-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("DOLAR ALIŞ")?> </label>
									      	<div class="input-group">
									      		<input type="text" class="form-control" placeholder="" name="usd_alis" id="usd_alis" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 4" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->DOLAR,4)?>" maxlength="12">
									      	</div>
									    </div>
									</div>
									<div class="col-md-3 col-xs-3 mb-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("EURO ALIŞ")?> </label>
									      	<div class="input-group">
									      		<input type="text" class="form-control" placeholder="" name="eur_alis" id="eur_alis" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 4" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->EURO,4)?>" maxlength="12">
									      	</div>
									    </div>
									</div>
									<div class="col-md-3 col-xs-3 mb-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("STERLIN ALIŞ")?> </label>
									      	<div class="input-group">
									      		<input type="text" class="form-control" placeholder="" name="gbp_alis" id="gbp_alis" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 4" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->STERLIN,4)?>" maxlength="12">
									      	</div>
									    </div>
									</div>
									<div class="col-md-3 col-xs-3 mb-2">
									
									</div>
									<div class="col-md-3 col-xs-3 mb-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("DOLAR SATIŞ")?> </label>
									      	<div class="input-group">
									      		<input type="text" class="form-control" placeholder="" name="usd_satis" id="usd_satis" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 4" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->DOLAR,4)?>" maxlength="12">
									      	</div>
									    </div>
									</div>
									<div class="col-md-3 col-xs-3 mb-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("EURO SATIŞ")?> </label>
									      	<div class="input-group">
									      		<input type="text" class="form-control" placeholder="" name="eur_satis" id="eur_satis" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 4" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->EURO,4)?>" maxlength="12">
									      	</div>
									    </div>
									</div>
									<div class="col-md-3 col-xs-3 mb-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("STERLIN SATIŞ")?> </label>
									      	<div class="input-group">
									      		<input type="text" class="form-control" placeholder="" name="gbp_satis" id="gbp_satis" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 4" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->STERLIN,4)?>" maxlength="12">
									      	</div>
									    </div>
									</div>
									<div class="col-md-12 col-xs-12 text-center mt-3">
										<div class="form-group">
									      	<label class="form-label"></label>   
									    	<button type="button" class="btn btn-primary waves-effect waves-themed" style="width: 150px" onclick="fncKaydet()"><?=dil("Kaydet")?></button>
									    </div>
									</div>
									<div class="col-md-12 mt-5">
										<table class="table table-sm table-condensed">
											<thead class="thead-themed fw-500">
												<tr>
													<td width="25%" align="center" valign="middle" rowspan="2"><?=dil("TARİH")?></td>
													<td width="25%" colspan="2" align="center"><?=dil("DOLAR")?></td>
													<td width="25%" colspan="2" align="center"><?=dil("EURO")?></td>
													<td width="25%" colspan="2" align="center"><?=dil("STERLIN")?></td>
												</tr>
												<tr>
													<td align="center"><?=dil("ALIŞ")?></td>
													<td align="center"><?=dil("SATIŞ")?></td>
													<td align="center"><?=dil("ALIŞ")?></td>
													<td align="center"><?=dil("SATIŞ")?></td>
													<td align="center"><?=dil("ALIŞ")?></td>
													<td align="center"><?=dil("SATIŞ")?></td>
												</tr>
											</thead>
											<tbody>
												<?foreach($rows_gecmis as $key => $row_gecmis){?>
												<tr>
													<td align="center"><?=FormatTarih::tarih($key)?></td>
													<td align="center"><?=$row_gecmis->DOLAR_ALIS?></td>
													<td align="center"><?=$row_gecmis->DOLAR_SATIS?></td>
													<td align="center"><?=$row_gecmis->EURO_ALIS?></td>
													<td align="center"><?=$row_gecmis->EURO_SATIS?></td>
													<td align="center"><?=$row_gecmis->STERLIN_ALIS?></td>
													<td align="center"><?=$row_gecmis->STERLIN_SATIS?></td>
												</tr>
												<?}?>
											</tbody>
										</table>
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
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		function fncKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formKur').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						location.reload(true);
					}
				}
			});
		}
		
		$('.datatable').DataTable({
		  	paging: true,
		  	pageLength: 100,
		 	lengthChange: true,
		  	searching: true,
		  	search:{
				search:"<?=$_REQUEST['q']?>"
			},
		  	ordering: true,
		  	info: false,
		  	autoWidth: false,
		  	select: true,
		  	autoFill: false,
		  	responsive: true,
        	columnDefs: [{ targets: 'no-sort', orderable: false }],
			lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Tümü"]],
		});
	
	</script>
    
</body>
</html>
