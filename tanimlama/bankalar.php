<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$rows_banka			= $cSubData->getBankalar();
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
	                        <h2> <?=dil("Bankalar")?> </h2>
	                        <div class="panel-toolbar">
	                            <a href="javascript:void(0)" class="btn btn-light btn-icon" data-toggle="modal" data-target="#modalBankaEkle"> <i class="far fa-plus text-green"></i> </a>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed">
							    	<tr>
							          	<td align="center">#</td>
							          	<td><?=dil("Banka")?></td>
							          	<td><?=dil("Banka Mali Kodu")?></td>
							          	<td><?=dil("Durum")?></td>
							          	<td align="center"><?=dil("Sıralama")?></td>
							          	<td> </td>
							        </tr>
						        </thead>
						        <tbody>
							        <?foreach($rows_banka as $key=>$row_banka) {?>
								        <tr>
								          	<td align="center"><?=($key+1)?></td>
								          	<td><?=$row_banka->BANKA?></td>
								          	<td><?=$row_banka->MALI_KODU?></td>
								          	<td><?=$row_banka->DURUM?></td>
								          	<td align="center"><?=$row_banka->SIRA?></td>
								          	<td> <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm btn-icon float-right" onclick="fncBankaDuzenle(<?=$row_banka->ID?>)"> <i class="far fa-edit"></i> </a> </td>
								        </tr>
							        <?}?>
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
    </div>
    
    <div class="modal fade" id="modalBankaDuzenle" role="dialog">
      	<div class="modal-dialog">
	        <div class="modal-content">
	          	<div class="modal-header bg-blue-gradient">
	            	<button type="button" class="close" data-dismiss="modal">
	              		<span>&times;</span></button>
	            	<h4 class="modal-title"> <?=dil("Banka Düzenle")?> </h4>
	          	</div>
	          	<div class="modal-body">
	          		<form class="form-horizontal" id="formBankaDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="banka_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="col-md-12">
			            	<div class="form-group">
							  	<label><?=dil("Banka Adı")?></label>
							  	<input type="text" class="form-control" placeholder="" name="banka" id="banka">
							</div>
							<div class="form-group">
							  	<label><?=dil("Banka Mali Kodu")?></label>
							  	<select name="mali_kodu_id" id="mali_kodu_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" >
							      	<?=$cCombo->HizmetMaliKodu()->setSecilen()->setSeciniz()->getSelect("ID","AD")?>
							    </select>
							</div>
							<div class="form-group">
							  	<label><?=dil("Durum")?></label>
							  	<select name="durum" id="durum" class="form-control" style="width: 100%;">
							      	<?=$cCombo->Durumlar()->setSecilen()->getSelect("ID","AD")?>
							    </select>
							</div>
							<div class="form-group">
							  	<label>Sıra</label>
							  	<input type="text" class="form-control" placeholder="" name="sira" id="sira">
							</div>
						</div>
					</form>
	          	</div>
	          	<div class="modal-footer">
	            	<button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><?=dil("Kapat")?></button>
	            	<button type="button" class="btn btn-primary" onclick="fncBankaKaydet()"><?=dil("Kaydet")?></button>
	          	</div>
	        </div>
      	</div>
    </div>
    
    <div class="modal fade" id="modalBankaEkle" tabindex="-1" role="dialog">
      	<div class="modal-dialog">
	        <div class="modal-content">
	          	<div class="modal-header bg-blue-gradient">
	            	<button type="button" class="close" data-dismiss="modal">
	              		<span>&times;</span></button>
	            	<h4 class="modal-title"> <?=dil("Banka Ekle")?> </h4>
	          	</div>
	          	<div class="modal-body">
	          		<form class="form-horizontal" id="formBankaEkle">
	          			<input type="hidden" name="islem" id="islem" value="banka_ekle">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="col-md-12">
			            	<div class="form-group">
							  	<label><?=dil("Banka Adı")?></label>
							  	<input type="text" class="form-control" placeholder="" name="banka" id="banka">
							</div>
							<div class="form-group">
							  	<label><?=dil("Mali Kodu")?></label>
							  	<input type="text" class="form-control" placeholder="" name="mali_kodu_id" id="mali_kodu_id">
							</div>
							<div class="form-group">
							  	<label><?=dil("Durum")?></label>
							  	<select name="durum" id="durum" class="form-control" style="width: 100%;">
							      	<?=$cCombo->Durumlar()->setSecilen()->getSelect("ID","AD")?>
							    </select>
							</div>
							<div class="form-group">
							  	<label><?=dil("Sıra")?></label>
							  	<input type="text" class="form-control" placeholder="" name="sira" id="sira">
							</div>
						</div>
					</form>
	          	</div>
	          	<div class="modal-footer">
	            	<button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><?=dil("Kapat")?></button>
	            	<button type="button" class="btn btn-primary" onclick="fncBankaEkle()"><?=dil("Kaydet")?></button>
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
		
		function fncBankaDuzenle(id){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "banka_bilgisi", 'id' : id },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalBankaDuzenle #id").val( jd.BANKA.ID );
						$("#modalBankaDuzenle #banka").val( jd.BANKA.BANKA );
						$("#modalBankaDuzenle #mali_kodu_id").val( jd.BANKA.MALI_KODU_ID );
						$("#modalBankaDuzenle #durum").val( jd.BANKA.DURUM );
						$("#modalBankaDuzenle #sira").val( jd.BANKA.SIRA );
						$("#modalBankaDuzenle").modal("show");
					}
				}
			});
			
		}
		
		function fncBankaKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBankaDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//$("#modalBankaDuzenle").modal("hide");
							location.reload(true);
						});
					}
				}
			});
		}
		
		function fncBankaEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBankaEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//$("#modalBankaEkle").modal("hide");
							location.reload(true);
						});
					}
				}
			});
		}
	
	</script>
    
</body>
</html>
