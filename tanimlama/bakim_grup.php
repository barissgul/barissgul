<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row			= $cSubData->getBakimGrup($_REQUEST);
	$rows_model		= $cSubData->getBakimGrupModeller($_REQUEST);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-duallistbox-master/src/bootstrap-duallistbox.css">
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
            <li class="breadcrumb-item"><a href="/tanimlama/bakim_grup_listesi.do?route=tanimlama/bakim_grup_listesi"><?=dil("Bakım Grup Listesi")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Bakım Grup")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-lg-8 offset-lg-2">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-gradient">
                        <h2> <?=dil("Bakım Grup Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">								
							<div class="panel-tag p-3"><?=$row->BAKIM_GRUP?> - <?=$row->BAKIM_GRUP_ALTYAZI?> <span class="badge badge-primary float-right"><?=dil("ID:")?> <?=$row->ID?></span> </div>	
							
							<form name="formBakimGrupModel" id="formBakimGrupModel">
								<input type="hidden" name="islem" id="islem" value="bakim_grup_model_ekle">
								<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
								<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
								
								<div class="row">
									<div class="col-md-3 mb-3 text-center">        
								        <div class="form-group">
									      	<label class="form-label"> <?=dil("Marka")?> </label>
									      	<select name="marka_id" id="marka_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" onchange="fncModelDoldur()">
										      	<?=$cCombo->Markalar()->setSecilen($_REQUEST['marka_id'])->setSeciniz()->getSelect("ID","AD")?>
										    </select>
									    </div>
								    </div>
								    <div class="col-md-8 mb-3 text-center">        
								        <div class="form-group">
									      	<label class="form-label"> <?=dil("Model")?> </label>
									      	<select name="model_id" id="model_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->MarkaModeller(array("marka_id"=>$_REQUEST['marka_id']))->setSecilen($_REQUEST['model_id'])->setSeciniz()->getSelect("ID","AD")?>
										    </select>
									    </div>
								    </div>										
									<div class="col-md-1 mt-3">
										<button type="button" class="btn btn-secondary form-control mt-2" onclick="fncKaydet()" title="<?=dil("Ekle")?>"> <i class="far fa-plus"></i> </button>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="table-responsive">
									  		<table class="table table-sm table-condensed table-hover">
										  		<thead class="thead-themed fw-500">
											    	<tr>
											          	<td align="center">#</td>
											          	<td><?=dil("Marka")?></td>
											          	<td><?=dil("Model")?></td>
											          	<td> </td>
											        </tr>
										        </thead>
										        <tbody>
											        <?foreach($rows_model as $key=>$row_model) {?>
												        <tr>
												          	<td align="center"><?=($key+1)?></td>
												          	<td><?=$row_model->MARKA?></td>
												          	<td><?=$row_model->MODEL?></td>
												          	<td align="right"> 
												          		<button type="button" class="btn btn-danger btn-sm" onclick="fncBakimGrupModelSil(this)" data-id="<?=$row_model->BAKIM_GRUP_ID?>" data-model_id="<?=$row_model->MODEL_ID?>"> <i class="far fa-trash"></i> </button>
												          	</td>
												        </tr>
											        <?}?>
										        </tbody>
										  	</table>
										  	<div class="frame-wrap text-center">
					                            <nav> 
					                                <ul class="pagination justify-content-center">
					                                	<?=$Table["sayfaAltYazi"];?>
					                                </ul>
					                            </nav>
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
    <script src="../smartadmin/plugin/bootstrap-duallistbox-master/src/jquery.bootstrap-duallistbox.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		function fncKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBakimGrupModel').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#formBakimGrupModel").submit();
						});
					}
				}
			});
		}
		
		function fncModelDoldur(){
			$("#model_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "model_doldur", 'marka_id': $("#marka_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$('#model_id').html(jd.HTML);
					}
					$("#model_id").removeAttr("disabled");
				}
			});
		};
		
		function fncBakimGrupModelSil(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "bakim_grup_model_sil", 'id': $(obj).data("id"), 'model_id': $(obj).data("model_id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#formBakimGrupModel").submit();
						});
					}
					
				}
			});
		};
		
	</script>
    
</body>
</html>
