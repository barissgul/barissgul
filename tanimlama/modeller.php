<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$rows		= $cSubData->getModeller($_REQUEST);
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
            <li class="breadcrumb-item"><a href="/tanimlama/markalar.do?route=tanimlama/markalar"><?=dil("Markalar")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Modeller")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	  	<section class="content">
		    <div class="row">
		    	<div class="col-md-12">
					<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <?=dil("Modeller")?> </h2>
                        <div class="panel-toolbar">
                            <a href="javascript:void(0)" class="btn btn-light btn-sm btn-icon mr-1 waves-effect waves-themed" title="Araç Ekle" data-toggle="modal" data-target="#modalModelEkle"> <i class="far fa-plus"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover datatable">
							  		<thead class="thead-themed fw-500">
								    	<tr class="bg-aqua-gradient">
								          	<td align="center">#</td>
								          	<td> <?=dil("Marka")?> </td>
								          	<td> <?=dil("Grup")?> </td>
								          	<td> <?=dil("Model")?> </td>
								          	<td> <?=dil("Vites")?> </td>
								          	<td> <?=dil("Yakıt")?> </td>
		                                    <td align="center" class="no-sort"> <?=dil("Resim")?> </td>
		                                    <td align="center"> <?=dil("TSRB Marka Kodu")?> </td>
		                                    <td align="center"> <?=dil("TSRB Tip Kodu")?> </td>
		                                    <td align="center"> <?=dil("Baş Yıl")?> </td>
		                                    <td align="center"> <?=dil("Bit Yıl")?> </td>
								          	<td align="center"> <?=dil("Durum")?> </td>
								          	<td class="no-sort"> </td>
								        </tr>
								    </thead>
								    <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center"><?=($key+1)?></td>
									          	<td><?=$row->MARKA?></td>
									          	<td><?=$row->GRUP?></td>
									          	<td><?=$row->MODEL?></td>
									          	<td><?=$row->VITES?></td>
									          	<td><?=$row->YAKIT?></td>
		                                        <td align="center" style="padding: 0px;">
		                                        	<?if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/img/model/{$row->RESIM_URL}") AND strlen($row->RESIM_URL) > 4){?>
			                                        	<a href="javascript:fncPopup('/img/model/<?=$row->RESIM_URL?>','RESIM',800,750)">
			                                        		<img height="35" src="/img/model/<?=$row->RESIM_URL?>">
			                                        	</a>
		                                        	<?} else {?>
		                                        		<?=$row->RESIM_URL?>
		                                        	<?}?>
		                                        </td>
		                                        <td align="center"><?=$row->TSRB_MARKA_KODU?></td>
		                                        <td align="center"><?=$row->TSRB_TIP_KODU?></td>
									          	<td align="center"><?=$row->BAS_YIL?></td>
									          	<td align="center"><?=$row->BIT_YIL?></td>
									          	<td align="center"><?=$row->DURUM?></td>
									          	<td style="padding: 0px;" align="center"> 
									          		<a href="javascript:void(0)" class="btn btn-outline-primary btn-icon" onclick="fncModelDuzenle(<?=$row->ID?>)" title="Model Düzenle"> <i class="far fa-pencil text-green"></i> </a> 
									          		<a href="/tanimlama/model.do?route=tanimlama/model&id=<?=$row->ID?>" class="btn btn-outline-primary btn-icon" title="Modeller"> <i class="far fa-list-alt"></i> </a>
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
	
	<div class="modal fade" id="modalModelDuzenle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Model Düzenle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formModelDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="model_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="row">
		          			<div class="col-md-12 mb-3">
								<div class="form-group">
								  	<label><?=dil("Marka")?></label>
								  	<select name="marka_id" id="marka_id2" class="form-control select2" style="width: 100%;">
									    <?=$cCombo->Markalar()->setSecilen()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Model")?></label>
								  	<input type="text" class="form-control" placeholder="" name="model" id="model" maxlength="255">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Grup")?></label>
								  	<input type="text" class="form-control" placeholder="" name="grup" id="grup" maxlength="25">
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
								  	<label><?=dil("Vites")?></label>
								  	<select name="vites_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
									    <?=$cCombo->VitesTuru()->setSecilen()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
								  	<label><?=dil("Yakit")?></label>
								  	<select name="yakit_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
									    <?=$cCombo->YakitTuru()->setSecilen()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Resim")?></label>
								  	<input type="text" class="form-control" placeholder="" name="resim_url" id="resim_url" maxlength="255">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("TSRB Marka Kodu")?></label>
								  	<input type="text" class="form-control" placeholder="" name="tsrb_marka_kodu" id="tsrb_marka_kodu" maxlength="4">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("TSRB Tip Kodu")?></label>
								  	<input type="text" class="form-control" placeholder="" name="tsrb_tip_kodu" id="tsrb_tip_kodu" maxlength="4">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Baş Yıl")?></label>
								  	<input type="text" class="form-control" placeholder="" name="bas_yil" id="bas_yil" maxlength="4">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Bit Yıl")?></label>
								  	<input type="text" class="form-control" placeholder="" name="bit_yil" id="bit_yil" maxlength="4">
								</div>
							</div>
							<div class="col-md-12 mb-3">
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
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncModelKaydet()"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalModelEkle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Model Ekle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formModelEkle">
	          			<input type="hidden" name="islem" id="islem" value="model_ekle">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="row">
		          			<div class="col-md-12 mb-3">
								<div class="form-group">
								  	<label><?=dil("Marka")?></label>
								  	<select name="marka_id" class="form-control select2" style="width: 100%;">
									    <?=$cCombo->Markalar()->setSecilen()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Model")?></label>
								  	<input type="text" class="form-control" placeholder="" name="model" id="model" maxlength="255">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Grup")?></label>
								  	<input type="text" class="form-control" placeholder="" name="grup" id="grup" maxlength="25">
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
								  	<label><?=dil("Vites")?></label>
								  	<select name="vites_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
									    <?=$cCombo->VitesTuru()->setSecilen()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
								  	<label><?=dil("Yakit")?></label>
								  	<select name="yakit_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
									    <?=$cCombo->YakitTuru()->setSecilen()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Resim")?></label>
								  	<input type="text" class="form-control" placeholder="" name="resim_url" id="resim_url" maxlength="255">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("TSRB Marka Kodu")?></label>
								  	<input type="text" class="form-control" placeholder="" name="tsrb_marka_kodu" id="tsrb_marka_kodu" maxlength="4">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("TSRB Tip Kodu")?></label>
								  	<input type="text" class="form-control" placeholder="" name="tsrb_tip_kodu" id="tsrb_tip_kodu" maxlength="4">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Baş Yıl")?></label>
								  	<input type="text" class="form-control" placeholder="" name="bas_yil" id="bas_yil" maxlength="4">
								</div>
							</div>
							<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Bit Yıl")?></label>
								  	<input type="text" class="form-control" placeholder="" name="bit_yil" id="bit_yil" maxlength="4">
								</div>
							</div>
							<div class="col-md-12 mb-3">
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
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncModelEkle()"><?=dil("Kaydet")?></button>
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
		
		$('.datatable').DataTable({
			columnDefs: [{ targets: 'no-sort', orderable: false }],
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]],
			order: [],
			paging: true,
			pageLength: 50,
			ordering: true
		});
		
		$("#modalModelDuzenle select[name='marka_id']").select2({
	    	dropdownParent: $("#modalModelDuzenle")
	  	});
	  	
	  	$("#modalModelDuzenle select[name='vites_id']").select2({
	    	dropdownParent: $("#modalModelDuzenle")
	  	});
	  	
	  	$("#modalModelDuzenle select[name='yakit_id']").select2({
	    	dropdownParent: $("#modalModelDuzenle")
	  	});
	  	
	  	$("#modalModelEkle select[name='marka_id']").select2({
	    	dropdownParent: $("#modalModelEkle")
	  	});
	  	
	  	$("#modalModelEkle select[name='vites_id']").select2({
	    	dropdownParent: $("#modalModelEkle")
	  	});
	  	
	  	$("#modalModelEkle select[name='yakit_id']").select2({
	    	dropdownParent: $("#modalModelEkle")
	  	});
	  	
		function fncModelDuzenle(id){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "model_bilgisi", 'id' : id },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalModelDuzenle #id").val( jd.DATA.ID );
						$("#modalModelDuzenle select[name='marka_id']").val( jd.DATA.MARKA_ID ).trigger("change");
						$("#modalModelDuzenle #model").val( jd.DATA.MODEL );
						$("#modalModelDuzenle #grup").val( jd.DATA.GRUP );
						$("#modalModelDuzenle #resim_url").val( jd.DATA.RESIM_URL );
						$("#modalModelDuzenle select[name='vites_id']").val( jd.DATA.VITES_ID ).trigger("change");
						$("#modalModelDuzenle select[name='yakit_id']").val( jd.DATA.YAKIT_ID ).trigger("change");
						$("#modalModelDuzenle #model").val( jd.DATA.MODEL );
						$("#modalModelDuzenle #tsrb_tip_kodu").val( jd.DATA.TSRB_TIP_KODU );
						$("#modalModelDuzenle #tsrb_marka_kodu").val( jd.DATA.TSRB_MARKA_KODU );
						$("#modalModelDuzenle #bas_yil").val( jd.DATA.BAS_YIL );
						$("#modalModelDuzenle #bit_yil").val( jd.DATA.BIT_YIL );
						$("#modalModelDuzenle select[name='durum']").val( jd.DATA.DURUM ).trigger("change");
						$("#modalModelDuzenle").modal("show");
					}
				}
			});
			
		}
		
		function fncModelKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formModelDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#modalModelDuzenle").modal("hide");
						});
					}
				}
			});
		}
		
		function fncModelEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formModelEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#modalModelEkle").modal("hide");
							//location.reload();
						});
					}
				}
			});
		}
		
		function fncModelSil(id){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "model_sil", 'id': id },
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
	</script>
	
</body>
</html>
