<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows_odeme_kanali			= $cSubData->getOdemeKanaliDetaylari();
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
                        <h2> <i class="fal fa-lira-sign mr-3"></i> <?=dil("Ödeme Kanalı Detay")?> </h2>
                        <div class="panel-toolbar">
                            <a href="javascript:void(0)" class="btn btn-outline-secondary text-white border-white btn-icon" data-toggle="modal" data-target="#modalOdemeKanaliEkle"> <i class="far fa-plus"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table m-0 table-sm table-hover table-striped table-bordered datatable">
						  		<thead class="thead-themed font-weight-bold">
							    	<tr>
							          	<td align="center">#</td>
							          	<td><?=dil("Ödeme Kanalı")?></td>
							          	<td><?=dil("Ödeme Kanalı Detay")?></td>
							          	<td align="center"><?=dil("Sıra")?></td>
							          	<td align="right"><?=dil("Limit")?></td>
							          	<td align="center"><?=dil("Durum")?></td>
							          	<td class="no-sort"></td>
							        </tr>
						        </thead>
						        <tbody>
							        <?foreach($rows_odeme_kanali as $key=>$row_odeme_kanali) {?>
								        <tr>
								          	<td align="center"><?=($key+1)?></td>
								          	<td><?=$row_odeme_kanali->ODEME_KANALI?></td>
								          	<td><?=$row_odeme_kanali->ODEME_KANALI_DETAY?></td>
								          	<td align="center"><?=$row_odeme_kanali->SIRA?></td>
								          	<td align="center"><?=$row_odeme_kanali->LIMIT?></td>
								          	<td align="center"><?=$row_odeme_kanali->DURUM?></td>
								          	<td class="text-right p-0 text-center"> 
								          		<a href="javascript:void(0)" class="btn btn-outline-primary btn-icon" data-id="<?=$row_odeme_kanali->ID?>" onclick="fncOdemeKanaliDetayDuzenle(this)"> <i class="far fa-edit"></i> </a> 
								          	</td>
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
		</section>
		
    </main>    
    </div>
    </div>
    </div>
    
    <div class="modal fade" id="modalOdemeKanaliDuzenle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Ödeme Kanalı Detay Düzenle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formOdemeKanaliDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="odeme_kanali_detay_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
	          			<div class="row">
			          		<div class="col-md-12 mb-2">
				            	<div class="form-group">
								  	<label class="form-label"><?=dil("Ödeme Kanalı Detay")?></label>
								  	<input type="text" class="form-control" placeholder="" name="odeme_kanali_detay" id="odeme_kanali_detay">
								</div>
							</div>
							<div class="col-md-6 mb-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Sıra")?></label>
								  	<input type="text" class="form-control" placeholder="" name="sira" id="sira">
								</div>
							</div>
							<div class="col-md-6 mb-2">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Limit")?> </label>
							      	<div class="input-group">
							      		<input type="text" class="form-control" placeholder="" name="limit" id="limit" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 0" data-mask style="text-align: right;" value="" maxlength="10">
							      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
							      	</div>
							    </div>
							</div>
							<div class="col-md-12 mb-2">
								<div class="form-group">
								  	<label><?=dil("Durum")?></label>
								  	<select name="durum" id="durum" class="form-control" style="width: 100%;">
								      	<?=$cCombo->Durumlar()->setSecilen()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncOdemeKanaliDetayKaydet()"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalOdemeKanaliEkle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Ödeme Kanalı Detay Ekle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formYetkiEkle">
	          			<input type="hidden" name="islem" id="islem" value="odeme_kanali_detay_ekle">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="row">
		          			<div class="col-md-12 mb-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Ödeme Kanalı")?></label>
								  	<select name="odeme_kanali_id" id="odeme_kanali_id" class="form-control" style="width: 100%;">
								      	<?=$cCombo->OdemeKanallari()->setSecilen()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
			          		<div class="col-md-12 mb-2">
				            	<div class="form-group">
								  	<label class="form-label"><?=dil("Ödeme Kanalı Detay")?></label>
								  	<input type="text" class="form-control" placeholder="" name="odeme_kanali_detay" id="odeme_kanali_detay">
								</div>
							</div>
							<div class="col-md-6 mb-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Sıra")?></label>
								  	<input type="text" class="form-control" placeholder="" name="sira" id="sira">
								</div>
							</div>
							<div class="col-md-6 mb-2">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Limit")?> </label>
							      	<div class="input-group">
							      		<input type="text" class="form-control" placeholder="" name="limit" id="limit" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 0" data-mask style="text-align: right;" value="" maxlength="10">
							      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
							      	</div>
							    </div>
							</div>
							<div class="col-md-12 mb-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Durum")?></label>
								  	<select name="durum" id="durum" class="form-control" style="width: 100%;">
								      	<?=$cCombo->Durumlar()->setSecilen()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncYetkiEkle()"><?=dil("Kaydet")?></button>
                </div>
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
		
		$("#modalMenuEkle #yetki_ids2").select2({
	    	dropdownParent: $("#modalMenuEkle")
	  	});
	  	$("#modalMenuDuzenle #yetki_ids").select2({
	    	dropdownParent: $("#modalMenuDuzenle")
	  	});
	  	
		function fncOdemeKanaliDetayDuzenle(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "odeme_kanali_detay_bilgisi", 'id' : $(obj).data("id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalOdemeKanaliDuzenle #id").val( jd.ROW.ID );
						$("#modalOdemeKanaliDuzenle #odeme_kanali_detay").val( jd.ROW.ODEME_KANALI_DETAY );
						$("#modalOdemeKanaliDuzenle #sira").val( jd.ROW.SIRA );
						$("#modalOdemeKanaliDuzenle #limit").val( jd.ROW.LIMIT );
						$("#modalOdemeKanaliDuzenle #durum").val( jd.ROW.DURUM );
						$("#modalOdemeKanaliDuzenle").modal("show");
					}
				}
			});
		}
		
		function fncOdemeKanaliDetayKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formOdemeKanaliDuzenle').serialize(),
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
		
		function fncOdemeKanaliEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formOdemeKanaliEkle').serialize(),
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
