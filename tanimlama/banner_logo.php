<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$_REQUEST['filtre'] = 1;
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("ID","ID","");
	$excel->sutunEkle("Sigorta","FIRMA","");
	$excel->sutunEkle("Marka","MARKA","");
	$excel->sutunEkle("Servis","CARI","");
	$excel->sutunEkle("İşçilik İskonto","ISC","");
	$excel->sutunEkle("Yedek Parça","YP","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaBanner")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows = $Table['rows'];//echo json_encode($rows);die();
	$_SESSION['Table'] = $Table;

?>
<!DOCTYPE html>
<html lang="tr" class="<?=$cBootstrap->getFontBoyut()?>">
<head>
    <meta charset="utf-8">
    <title> <?=$row_site->TITLE?> <?=dil("Banner Logo")?></title>
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
            <li class="breadcrumb-item"><a href="/tanimlama/sigorta_anlasma.do?route=tanimlama/sigorta_anlasma"><?=dil("Bannerlar")?></a></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	  	<section class="content">
	  		<div class="row hidden-print">
		    	<div class="col-md-12">
			    	<div class="panel">
			    	<div class="panel-container show">
                        <div class="panel-content">
							<form name="form" id="form" class="app-forms" enctype="multipart/form-data" method="GET">
								<input type="hidden" name="route" value="<?=$_REQUEST['route']?>">
								<input type="hidden" name="sayfa" id="sayfa">
								<input type="hidden" name="filtre" value="1">
								<div class="row">
									<div class="col-lg-2 col-md-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Banner Adı")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="logo" id="logo" value="<?=$_REQUEST['logo']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-md-2 mb-2">
										<div class="form-group">
										  	<label class="form-label">&nbsp;</label><br>
									  		<button type="button" class="btn btn-primary" onclick="fncFiltrele()"><?=dil("Filtrele")?></button>
									  	</div>
									</div>
								</div>
							</form>			
						</div>
					</div>
					</div>
			    </div>
		    </div>
		    <div class="row">
		    	<div class="col-md-12">
					<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <?=dil("Banner Logo")?> </h2>
                        <div class="panel-toolbar">
                            <a href="javascript:void(0)" class="btn btn-light btn-sm btn-icon mr-1 waves-effect waves-themed" title="Logo Ekle" data-toggle="modal" data-target="#modalBannerEkle"> <i class="far fa-plus"></i> </a>
                            <a href="/excel_sql.do?" class="btn btn-outline-secondary btn-icon waves-effect waves-themed text-white border-white" title="Excel" > <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover datatable">
							  		<thead class="thead-themed fw-500">
								    	<tr class="bg-aqua-gradient">
								          	<td align="center">#</td>
								          	<td class="text-center"> <?=dil("Resim")?> </td>
								          	<td> <?=dil("Banner Ad")?> </td>
								          	<td> <?=dil("Marka")?> </td>
								          	<td> <?=dil("Parça")?> </td>
								          	<td> <?=dil("Durum")?> </td>
								          	<td class="no-sort"> </td>
								        </tr>
								    </thead>
								    <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center"><?=($key+1)?></td>
									          	<td class="text-center"><img height="45" src="/img/marka/<?=$row->RESIM?>"></td>
									          	<td><?=$row->BANNER_AD?></td>
									          	<td><?=$row->MARKA?></td>
									          	<td><?=$row->DURUM?></td>
									          	<td align="center"> 
									          		<a href="javascript:void(0)" class="btn btn-outline-primary btn-icon" onclick="fncBannerDuzenle(<?=$row->ID?>)" title="Banner Düzenle"> <i class="far fa-pencil text-green"></i> </a>
									          		<a href="javascript:fncPopup('/tanimlama/popup_banner_parca.do?route=tanimlama/popup_banner_parca&id=<?=$row->MARKA_ID?>','POPUP_BANNER_PARCA',1200,900);" class="btn btn-outline-primary btn-icon" title=""><i class="far fa-cogs"></i></a>
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


    <div class="modal fade" id="modalBannerEkle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Banner Ekle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formBannerEkle">
	          			<input type="hidden" name="islem" id="islem" value="banner_ekle">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="row">
		          			<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Banner Adı")?></label>
								  	<input type="text" class="form-control form-control-sm px-sm-1" name="banner_ad" id="banner_ad"  value="">
								</div>
							</div>
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Marka Seç")?></label>
								  	<select name="marka_id" id="marka_id" class="form-control select2" style="width: 100%;">
									    <?=$cCombo->Markalar()->setSecilen()->setSeciniz()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Banner Sıra")?></label>
								  	<input type="text" class="form-control form-control-sm px-sm-1" name="sira" id="sira"  value="">
								</div>
							</div>
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Durum")?></label>
								  	<select name="durum_id" id="durum_id" class="form-control select2" style="width: 100%;">
									    <?=$cCombo->Durumlar()->setSecilen()->setSeciniz()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncBannerEkle()"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalBannerDuzenle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h4 class="modal-title"> <?=dil("Banner Düzenle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formBannerDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="banner_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="row">
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Banner Adı")?></label>
								  	<input type="text" class="form-control form-control-sm px-sm-1" name="banner_ad" id="banner_ad"  value="">
								</div>
							</div>
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Marka")?></label>
								  	<select name="marka_id2" id="marka_id2" class="form-control select2" style="width: 100%;">
									    <?=$cCombo->Markalar()->setSecilen($row->MARKA_ID)->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Banner Sıra")?></label>
								  	<input type="text" class="form-control form-control-sm px-sm-1" name="sira" id="sira"  value="">
								</div>
							</div>
							<div class="col-md-12 mb-3">
				            	<div class="form-group">
								  	<label><?=dil("Durum")?></label>
								  	<select name="durum_id2" id="durum_id2" class="form-control select2" style="width: 100%;">
									    <?=$cCombo->Durumlar()->setSecilen()->getSelect("ID","AD")?>
									</select>
								</div>
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncBannerKaydet()"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
	
	<script src="/smartadmin/js/vendors.bundle.js"></script>
    <script src="/smartadmin/js/app.bundle.js"></script>
    <script src="/smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="/smartadmin/js/dependency/moment/moment.js"></script>
    <script src="/smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="/smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="/smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
    <script src="/smartadmin/js/notifications/toastr/toastr.js"></script>
    <script src="/smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="/smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="/smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="/smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
    <script src="/smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="/smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="/smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="/smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="/smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="/smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="/smartadmin/js/i18n/i18n.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.7/holder.min.js"></script>
    <script src="/smartadmin/plugin/1.js"></script>
    <script>

    	$("#modalBannerEkle select[name='marka_id']").select2({
			dropdownParent: $("#modalBannerEkle")});
    	
    	$("#modalBannerEkle select[name='durum_id']").select2({
			dropdownParent: $("#modalBannerEkle")});

    	$("#modalBannerDuzenle select[name='marka_id2']").select2({
			dropdownParent: $("#modalBannerDuzenle")});

    	$("#modalBannerDuzenle select[name='durum_id2']").select2({
			dropdownParent: $("#modalBannerDuzenle")});

		function fncBannerDuzenle(id){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "banner_bilgisi", 'id' : id },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalBannerDuzenle #id").val( jd.DUZENLE.ID );
						$("#modalBannerDuzenle #banner_ad").val( jd.DUZENLE.BANNER_AD );
						$("#modalBannerDuzenle select[name='marka_id2']").val( jd.DUZENLE.MARKA_ID );
						$("#modalBannerDuzenle #sira").val( jd.DUZENLE.SIRA );
						$("#modalBannerDuzenle select[name='durum_id2']").val( jd.DUZENLE.DURUM ).trigger("change");
						$("#modalBannerDuzenle").modal("show");
					}
				}
			});
			
		}
		
		function fncBannerKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBannerDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#modalBannerDuzenle").modal("hide");
							location.reload(true);
						});
					}
				}
			});
		}
		
		function fncBannerEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBannerEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#modalBannerEkle").modal("hide");
							location.reload(true);
						});
					}
				}
			});
		}
		
		function fncFiltrele(){
			$("#form").submit();
		}

	</script>
	
</body>
</html>