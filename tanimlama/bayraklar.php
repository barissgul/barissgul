<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$rows_bayrak			= $cSubData->getBayraklar();
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
    <link rel="stylesheet" href="../smartadmin/plugin/flag-icon-css-master/css/flag-icon.min.css">
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
				<div class="col-md-7">
		    		<div class="panel">
	                    <div class="panel-hdr bg-primary-300 text-white">
	                        <h2> <?=dil("Bayraklar")?> </h2>
	                        <div class="panel-toolbar">
							  	<a href="javascript:void(0)" class="btn btn-light btn-icon" data-toggle="modal" data-target="#modalBayrakEkle"> <i class="far fa-plus text-green"></i> </a>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
						  		<table class="table table-sm table-condensed table-hover">
						  			<thead class="thead-themed">
								    	<tr>
								          	<td align="center">#</td>
								          	<td></td>
								          	<th><?=dil("Bayrak")?></th>
								          	<th><?=dil("Bayrak İcon")?></th>
								          	<th><?=dil("Durum")?></th>
								          	<th> </th>
								        </tr>
							        </thead>
							        <?foreach($rows_bayrak as $key=>$row_bayrak) {?>
								        <tr>
								          	<td align="center"><?=($key+1)?></td>
								          	<td align="center"><span class="<?=$row_bayrak->ICON?>" title="<?=$row_bayrak->BAYRAK?>"></span></td>
								          	<td><?=$row_bayrak->BAYRAK?></td>
								          	<td><?=$row_bayrak->ICON?></td>
								          	<td><?=$row_bayrak->DURUM?></td>
								          	<td> <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm btn-icon float-right" onclick="fncBayrakDuzenle(<?=$row_bayrak->ID?>)"> <i class="far fa-edit"></i> </a> </td>
								        </tr>
							        <?}?>
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
    </div>
    
    <div class="modal fade" id="modalBayrakDuzenle" tabindex="-1" role="dialog">
    	<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      	<div class="modal-header bg-primary-gradient">
		      		<h5 class="modal-title"><?=dil("Bayrak Düzenle")?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fal fa-times"></i></span></button>
		      	</div>
		      	<div class="modal-body">
	          		<form class="form-horizontal" id="formBayrakDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="bayrak_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="col-md-12">
			            	<div class="form-group">
							  	<label><?=dil("Bayrak Adı")?></label>
							  	<input type="text" class="form-control" placeholder="" name="bayrak" id="bayrak">
							</div>
							<div class="form-group">
							  	<label><?=dil("Bayrak İcon")?></label>
							  	<input type="text" class="form-control pull-right" placeholder="" name="icon" id="icon">
							</div>
							<div class="form-group">
							  	<label><?=dil("Durum")?></label>
							  	<select name="durum" id="durum" class="form-control" style="width: 100%;">
							      	<?=$cCombo->Durumlar()->setSecilen()->getSelect("ID","AD")?>
							    </select>
							</div>
						</div>
					</form>
	          	</div>
	          	<div class="modal-footer">
	            	<button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><?=dil("Kapat")?></button>
	            	<button type="button" class="btn btn-primary" onclick="fncBayrakKaydet()"><?=dil("Kaydet")?></button>
	          	</div>
	        </div>
      	</div>
    </div>
    
    <div class="modal fade" id="modalBayrakEkle" tabindex="-1" role="dialog">
    	<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      	<div class="modal-header bg-primary-gradient">
		      		<h5 class="modal-title"><?=dil("Bayrak Ekle")?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fal fa-times"></i></span></button>
		      	</div>
		      	<div class="modal-body">
	          		<form class="form-horizontal" id="formBayrakEkle">
	          			<input type="hidden" name="islem" id="islem" value="bayrak_ekle">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="col-md-12">
			            	<div class="form-group">
							  	<label><?=dil("Bayrak Adı")?></label>
							  	<input type="text" class="form-control" placeholder="" name="bayrak" id="bayrak">
							</div>
							<div class="form-group">
							  	<label><?=dil("Bayrak İcon")?></label>
							  	<input type="text" class="form-control pull-right" placeholder="" name="icon" id="icon">
							</div>
							<div class="form-group">
							  	<label><?=dil("Durum")?></label>
							  	<select name="durum" id="durum" class="form-control" style="width: 100%;">
							      	<?=$cCombo->Durumlar()->setSecilen()->getSelect("ID","AD")?>
							    </select>
							</div>
						</div>
					</form>
	          	</div>
	          	<div class="modal-footer">
	            	<button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><?=dil("Kapat")?></button>
	            	<button type="button" class="btn btn-primary" onclick="fncBayrakEkle()"><?=dil("Kaydet")?></button>
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
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		function fncBayrakDuzenle(id){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "bayrak_bilgisi", 'id' : id },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalBayrakDuzenle #id").val( jd.BAYRAK.ID );
						$("#modalBayrakDuzenle #bayrak").val( jd.BAYRAK.BAYRAK );
						$("#modalBayrakDuzenle #icon").val( jd.BAYRAK.ICON );
						$("#modalBayrakDuzenle #durum").val( jd.BAYRAK.DURUM );
						$("#modalBayrakDuzenle").modal("show");
					}
				}
			});
			
		}
		
		function fncBayrakKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBayrakDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//$("#modalBayrakDuzenle").modal("hide");
							location.reload(true);
						});
					}
				}
			});
		}
		
		function fncBayrakEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBayrakEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#modalBayrakEkle").modal("hide");
							location.reload(true);
						});
					}
				}
			});
		}
	
	</script>
    
</body>
</html>
