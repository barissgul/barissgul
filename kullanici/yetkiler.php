<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	yetki_kontrol();
	$rows_yetki			= $cSubData->getYetkiler();
	$rows_menu			= $cSubData->getMenuler();
	$rows_gorev			= $cSubData->getGorevler();
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
				<div class="col-md-6">
					<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="fal fa-key mr-3"></i> <?=dil("Yetkiler")?> </h2>
                        <div class="panel-toolbar">
                            <a href="javascript:void(0)" class="btn btn-outline-secondary text-white border-white btn-icon" data-toggle="modal" data-target="#modalYetkiEkle"> <i class="far fa-plus"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table m-0 table-sm table-hover table-striped table-bordered datatable">
						  		<thead class="thead-themed font-weight-bold">
							    	<tr>
							          	<td align="center">#</td>
							          	<td><?=dil("Yetki")?></td>
							          	<td align="center"><?=dil("Durum")?></td>
							          	<td class="no-sort"><?=dil("Açıklama")?></td>
							          	<td class="no-sort"> </td>
							        </tr>
						        </thead>
						        <tbody>
							        <?foreach($rows_yetki as $key=>$row_yetki) {?>
								        <tr>
								          	<td align="center"><?=($key+1)?></td>
								          	<td><?=$row_yetki->YETKI?></td>
								          	<td align="center"><?=$row_yetki->DURUM?></td>
								          	<td><?=$row_yetki->ACIKLAMA?></td>
								          	<td class="text-right p-0 text-center"> 
								          		<a href="javascript:void(0)" class="btn btn-outline-primary btn-icon" data-id="<?=$row_yetki->ID?>" onclick="fncYetkiDuzenle(this)"> <i class="far fa-edit"></i> </a> 
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
		    	<div class="col-md-6">
					<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="fal fa-key mr-3"></i> <?=dil("Görevler")?> </h2>
                        <div class="panel-toolbar">
                            <a href="javascript:void(0)" class="btn btn-outline-secondary text-white border-white btn-icon" data-toggle="modal" data-target="#modalGorevEkle"> <i class="far fa-plus"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table m-0 table-sm table-hover table-striped table-bordered datatable">
						  		<thead class="thead-themed font-weight-bold">
							    	<tr>
							          	<td align="center">#</td>
							          	<td><?=dil("Görev")?></td>
							          	<td align="center"><?=dil("Durum")?></td>
							          	<td class="no-sort"><?=dil("Prim Oran")?></td>
							          	<td class="no-sort"> </td>
							        </tr>
						        </thead>
						        <tbody>
							        <?foreach($rows_gorev as $key=>$row_gorev) {?>
								        <tr>
								          	<td align="center"><?=($key+1)?></td>
								          	<td><?=$row_gorev->GOREV?></td>
								          	<td align="center"><?=$row_gorev->DURUM?></td>
								          	<td><?=$row_gorev->PRIM_ORAN?></td>
								          	<td class="text-right p-0 text-center"> 
								          		<a href="javascript:void(0)" class="btn btn-outline-primary btn-icon" data-id="<?=$row_gorev->ID?>" onclick="fncGorevDuzenle(this)"> <i class="far fa-edit"></i> </a> 
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
		    	<div class="col-md-12">
		    		<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="fal fa-list mr-3"></i> <?=dil("Menüler")?> </h2>
                        <div class="panel-toolbar">
                            <a href="javascript:void(0)" class="btn btn-outline-secondary text-white border-white btn-icon" data-toggle="modal" data-target="#modalMenuEkle"> <i class="far fa-plus"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table m-0 table-sm table-hover table-striped table-bordered datatable">
						  		<thead class="thead-themed font-weight-bold">
							    	<tr>
							          	<td align="center">#</td>
							          	<td><?=dil("Menü")?></td>
							          	<td><?=dil("Link")?></td>
							          	<td><?=dil("Title")?></td>
							          	<td><?=dil("Sıra")?></td>
							          	<td><?=dil("Route")?></td>
							          	<td><?=dil("Roller")?></td>
							          	<td align="center"><?=dil("Durum")?></td>
							          	<td class="no-sort"> </td>
							        </tr>
							    </thead>
								<tbody>
							        <?foreach($rows_menu as $key=>$row_menu) {?>
								        <tr>
								          	<td align="center"><?=($key+1)?></td>
								          	<td><?=$row_menu->MENU?></td>
								          	<td><?=$row_menu->LINK?></td>
								          	<td><?=$row_menu->TITLE?></td>
								          	<td><?=$row_menu->SIRA?></td>
								          	<td><?=$row_menu->ROUTE?></td>
								          	<td><?=$row_menu->YETKIS?></td>
								          	<td align="center"><?=$row_menu->DURUM?></td>
								          	<td class="text-right p-0 text-center"> <a href="javascript:void(0)" class="btn btn-outline-primary btn-icon" data-id="<?=$row_menu->ID?>" onclick="fncMenuDuzenle(this)"> <i class="far fa-edit"></i> </a> </td>
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
    
    <div class="modal fade" id="modalYetkiDuzenle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Yetki Düzenle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formYetkiDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="yetki_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="col-md-12">
			            	<div class="form-group">
							  	<label><?=dil("Yetki Adı")?></label>
							  	<input type="text" class="form-control" placeholder="" name="yetki" id="yetki">
							</div>
							<div class="form-group">
							  	<label><?=dil("Durum")?></label>
							  	<select name="durum" id="durum" class="form-control" style="width: 100%;">
							      	<?=$cCombo->Durumlar()->setSecilen()->getSelect("ID","AD")?>
							    </select>
							</div>
							<div class="form-group">
							  	<label><?=dil("Açıklama")?></label>
							  	<input type="text" class="form-control" placeholder="" name="aciklama" id="aciklama">
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncYetkiKaydet()"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalYetkiEkle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Yetki Ekle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formYetkiEkle">
	          			<input type="hidden" name="islem" id="islem" value="yetki_ekle">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="col-md-12">
			            	<div class="form-group">
							  	<label><?=dil("Yetki Adı")?></label>
							  	<input type="text" class="form-control" placeholder="" name="yetki" id="yetki">
							</div>
							<div class="form-group">
							  	<label><?=dil("Durum")?></label>
							  	<select name="durum" id="durum" class="form-control" style="width: 100%;">
							      	<?=$cCombo->Durumlar()->setSecilen()->getSelect("ID","AD")?>
							    </select>
							</div>
							<div class="form-group">
							  	<label><?=dil("Açıklama")?></label>
							  	<input type="text" class="form-control" placeholder="" name="aciklama" id="aciklama">
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
    
    <div class="modal fade" id="modalGorevDuzenle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Görev Düzenle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formGorevDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="gorev_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
	          			<div class="row">
			          		<div class="col-md-12 mb-2">
				            	<div class="form-group">
								  	<label class="form-label"><?=dil("Görev")?></label>
								  	<input type="text" class="form-control" placeholder="" name="gorev" id="gorev">
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
							<div class="col-md-12 mb-2">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Prim Oran")?> </label>
							      	<div class="input-group">
							      		<input type="text" class="form-control" placeholder="" name="prim_oran" id="prim_oran" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 0" data-mask style="text-align: right;" value="" maxlength="10">
							      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-percent"></i></span></div>
							      	</div>
							    </div>
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncGorevkKaydet()"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalGorevEkle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Görev Ekle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formGorevEkle">
	          			<input type="hidden" name="islem" id="islem" value="gorev_ekle">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="row">
		          			<div class="col-md-12 mb-2">
				            	<div class="form-group">
								  	<label class="form-label"><?=dil("Görev")?></label>
								  	<input type="text" class="form-control" placeholder="" name="gorev" id="gorev">
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
							<div class="col-md-12 mb-2">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Prim Oran")?> </label>
							      	<div class="input-group">
							      		<input type="text" class="form-control" placeholder="" name="prim_oran" id="prim_oran" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 0" data-mask style="text-align: right;" value="" maxlength="10">
							      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-percent"></i></span></div>
							      	</div>
							    </div>
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncGorevEkle()"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalMenuDuzenle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Menü Düzenle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formMenuDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="menu_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
	          			<div class="row">
			          		<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Menü")?></label>
								  	<input type="text" class="form-control" placeholder="" name="menu" id="menu">
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
								  	<label><?=dil("Title")?></label>
								  	<input type="text" class="form-control" placeholder="" name="title" id="title">
								</div>
							</div>
							<div class="col-md-12 mb-3">
								<div class="form-group">
								  	<label><?=dil("Link")?></label>
								  	<input type="text" class="form-control" placeholder="" name="link" id="link">
								</div>
							</div>
							<div class="col-md-12 mb-3">
								<div class="form-group">
								  	<label><?=dil("Route")?></label>
								  	<input type="text" class="form-control" placeholder="" name="route" id="route">
								</div>
							</div>
							<div class="col-md-12 mb-3">
								<div class="form-group">
								  	<label><?=dil("Rol")?></label>
								  	<select name="yetki_ids[]" id="yetki_ids" class="form-control select2 select2-hidden-accessible" style="width: 100%;" multiple>
									    <?=$cCombo->Yetkiler()->setSecilen()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
								  	<label><?=dil("Sıra")?></label>
								  	<select name="sira" id="sira" class="form-control" style="width: 100%;">
								      	<?=$cCombo->MenuSira()->setSecilen()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
							<div class="col-md-6 mb-3">
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
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncMenuKaydet()"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalMenuEkle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Menü Ekle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formMenuDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="menu_ekle">
	          			<input type="hidden" name="id" id="id" value="">
	          			<div class="row">
			          		<div class="col-md-6 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Menü")?></label>
								  	<input type="text" class="form-control" placeholder="" name="menu" id="menu">
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
								  	<label><?=dil("Title")?></label>
								  	<input type="text" class="form-control" placeholder="" name="title" id="title">
								</div>
							</div>
							<div class="col-md-12 mb-3">
								<div class="form-group">
								  	<label><?=dil("Link")?></label>
								  	<input type="text" class="form-control" placeholder="" name="link" id="link">
								</div>
							</div>
							<div class="col-md-12 mb-3">
								<div class="form-group">
								  	<label><?=dil("Route")?></label>
								  	<input type="text" class="form-control" placeholder="" name="route" id="route">
								</div>
							</div>
							<div class="col-md-12 mb-3">
								<div class="form-group">
								  	<label><?=dil("Rol")?></label>
								  	<select name="yetki_ids[]" id="yetki_ids2" class="form-control select2 select2-hidden-accessible" multiple="" style="width: 100%;" tabindex="-1">
									    <?=$cCombo->Yetkiler()->setSecilen()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
								  	<label><?=dil("Sıra")?></label>
								  	<select name="sira" id="sira" class="form-control" style="width: 100%;">
								      	<?=$cCombo->MenuSira()->setSecilen()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
							<div class="col-md-6 mb-3">
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
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncMenuEkle()"><?=dil("Kaydet")?></button>
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
		
		$("#modalMenuEkle #yetki_ids2").select2({
	    	dropdownParent: $("#modalMenuEkle")
	  	});
	  	$("#modalMenuDuzenle #yetki_ids").select2({
	    	dropdownParent: $("#modalMenuDuzenle")
	  	});
	  	
		function fncYetkiDuzenle(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "yetki_bilgisi", 'id' : $(obj).data("id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalYetkiDuzenle #id").val( jd.YETKI.ID );
						$("#modalYetkiDuzenle #yetki").val( jd.YETKI.YETKI );
						$("#modalYetkiDuzenle #durum").val( jd.YETKI.DURUM );
						$("#modalYetkiDuzenle #aciklama").val( jd.YETKI.ACIKLAMA );
						$("#modalYetkiDuzenle").modal("show");
					}
				}
			});
		}
		
		function fncYetkiKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formYetkiDuzenle').serialize(),
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
		
		function fncYetkiEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formYetkiEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//$("#modalYetkiEkle").modal("hide");
							location.reload(true);
						});
					}
				}
			});
		}
		
		function fncGorevDuzenle(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "gorev_bilgisi", 'id' : $(obj).data("id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalGorevDuzenle #id").val( jd.GOREV.ID );
						$("#modalGorevDuzenle #gorev").val( jd.GOREV.GOREV );
						$("#modalGorevDuzenle #durum").val( jd.GOREV.DURUM );
						$("#modalGorevDuzenle #prim_oran").val( jd.GOREV.PRIM_ORAN );
						$("#modalGorevDuzenle").modal("show");
					}
				}
			});
		}
		
		function fncGorevkKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formGorevDuzenle').serialize(),
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
		
		function fncGorevEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formGorevEkle').serialize(),
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
		
		function fncMenuDuzenle(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "menu_bilgisi", 'id' : $(obj).data("id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalMenuDuzenle #id").val( jd.MENU.ID );
						$("#modalMenuDuzenle #menu").val( jd.MENU.MENU );
						$("#modalMenuDuzenle #link").val( jd.MENU.LINK );
						$("#modalMenuDuzenle #title").val( jd.MENU.TITLE );
						$("#modalMenuDuzenle #sira").val( jd.MENU.SIRA );
						$("#modalMenuDuzenle #route").val( jd.MENU.ROUTE );
						$("#modalMenuDuzenle #yetki_ids").val(jd.MENU.YETKI_IDS.split(',')).trigger('change');
						$("#modalMenuDuzenle #durum").val( jd.MENU.DURUM );
						$("#modalMenuDuzenle").modal("show");
					}
				}
			});
		}
		
		function fncMenuKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formMenuDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//$("#modalYetkiDuzenle").modal("hide");
							location.reload(true);
						});
					}
				}
			});
		}
		
		function fncMenuEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formMenuEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//$("#modalYetkiEkle").modal("hide");
							location.reload(true);
						});
					}
				}
			});
		}
		
		$('.datatable').DataTable({
		  	"paging": true,
		 	"lengthChange": true,
		  	"searching": true,
		  	"ordering": true,
		  	"info": false,
		  	"autoWidth": false,
		  	"select": true,
		  	"autoFill": false,
		  	"responsive": true,
        	"columnDefs": [{
		          "targets": 'no-sort',
		          "orderable": false,
		    }]
		});
	
	</script>
    
</body>
</html>
