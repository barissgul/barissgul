<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows		= $cSubData->getParcaMarkalar2();
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <?$cBootstrap->getTemaCss()?>
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
            <li class="breadcrumb-item active"><?=dil("Parça Markalar")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	  	<section class="content">
		    <div class="row">
		    	<div class="col-md-8">
					<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <?=dil("Parça Markalar")?> </h2>
                        <div class="panel-toolbar">
                        	<a href="javascript:;" onclick="exportXLS()" title="Excel" class="btn btn-outline-secondary waves-effect waves-themed btn-icon text-white border-white ml-1"> <i class="far fa-table fs-lg"></i> </a>
                        	<!--
                            <a href="javascript:void(0)" class="btn btn-outline-primary text-white border-white btn-icon waves-effect waves-themed" title="Parça Marka Ekle" data-toggle="modal" data-target="#modalMarkaEkle"> <i class="far fa-plus"></i> </a>
                            -->
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover datatable" id="tablo1">
							  		<thead class="thead-themed fw-500">
								    	<tr class="bg-aqua-gradient">
								          	<td align="center" width="5">#</td>
								          	<td> <?=dil("Parça Marka")?> </td>
								          	<td> <?=dil("Tip")?> </td>
								          	<td align="center"> <?=dil("Durum")?> </td>
								          	<td class="no-sort"> </td>
								        </tr>
								    </thead>
								    <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr id="tr<?=$row->ID?>">
									          	<td align="center"><?=($key+1)?></td>
									          	<td><?=$row->PARCA_MARKA?></td>
									          	<td><?=$row->TIP?></td>
									          	<td align="center"><?=$row->DURUM?></td>
									          	<td align="center" class="p-0"> 
									          		<a href="javascript:void(0)" class="btn btn-outline-primary btn-icon" onclick="fncMarkaDuzenle(<?=$row->ID?>)" title="Düzenle"> <i class="far fa-pencil text-green"></i> </a> 
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
	
	<div class="modal fade" id="modalMarkaDuzenle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Marka Düzenle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formMarkaDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="parca_marka_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="row">
			          		<div class="col-md-12">
				            	<div class="form-group">
								  	<label class="form-label"><?=dil("Parça Marka")?></label>
								  	<input type="text" class="form-control" placeholder="" name="parca_marka" id="parca_marka" maxlength="25">
								</div>
							</div>
							<div class="col-md-12 mt-2">							
								<div class="form-group">
								  	<label class="form-label"><?=dil("Tip")?></label>
								  	<select name="tip" id="tip" class="form-control" style="width: 100%;">
								      	<?=$cCombo->ParcaTip()->setSecilen()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
							<div class="col-md-12 mt-2">
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
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncMarkaKaydet()"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalMarkaEkle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Marka Ekle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formMarkaEkle">
	          			<input type="hidden" name="islem" id="islem" value="parca_marka_ekle">
	          			<input type="hidden" name="id" id="id" value="">
	          			<div class="row">
			          		<div class="col-md-12">
				            	<div class="form-group">
								  	<label class="form-label"><?=dil("Marka")?></label>
								  	<input type="text" class="form-control" placeholder="" name="parca_marka" id="parca_marka" maxlength="25">
								</div>
							</div>
							<div class="col-md-6 mt-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Tip")?></label>
								  	<select name="tip" id="tip" class="form-control" style="width: 100%;">
								      	<?=$cCombo->ParcaTip()->setSecilen()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
							<div class="col-md-6 mt-2">
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
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncMarkaEkle()"><?=dil("Kaydet")?></button>
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
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<!-- https://github.com/rek72-zz/tableExport!-->
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/FileSaver/FileSaver.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.umd.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/pdfmake/pdfmake.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/pdfmake/vfs_fonts.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/html2canvas/html2canvas.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/tableExport.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
	<script>
		
		$('.datatable').DataTable({
			columnDefs: [{ targets: 'no-sort', orderable: false }],
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]],
			order: [],
			paging: true,
			pageLength: 50,
			ordering: true
		});
		
		function fncMarkaDuzenle(id){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "parca_marka_bilgisi", 'id' : id },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalMarkaDuzenle #id").val( jd.ROW.ID );
						$("#modalMarkaDuzenle #parca_marka").val( jd.ROW.PARCA_MARKA );
						$("#modalMarkaDuzenle #tip").val( jd.ROW.TIP );
						$("#modalMarkaDuzenle #durum").val( jd.ROW.DURUM );
						$("#modalMarkaDuzenle").modal("show");
					}
				}
			});
			
		}
		
		function fncMarkaKaydet(){
			var id = $("#formMarkaDuzenle #id").val();
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formMarkaDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$("#modalMarkaDuzenle").modal("hide");
						toastr.success(jd.ACIKLAMA);
						$("#tr"+id).find("td:eq(1)").text( jd.ROW.PARCA_MARKA );
						$("#tr"+id).find("td:eq(2)").text( jd.ROW.TIP );
					}
				}
			});
		}
		
		function fncMarkaEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#modalMarkaEkle').serialize(),
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
		
		function exportXLS(){
			/*
			$("#tablo1 tbody").find('td').each (function() {
			  	$(this).find("input[id^='firma']").clone().prependTo(this);
			  	$(this).find(".input-group").hide();
			});   
			*/
			$('#tablo1').tableExport({type:'excel'});
		}
		
	</script>
	
</body>
</html>
