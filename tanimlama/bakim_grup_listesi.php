<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$rows		= $cSubData->getBakimGruplari();
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-brands.css">
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
            <li class="breadcrumb-item active"><?=dil("Bakım Grupları")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	  	<section class="content">
		    <div class="row">
		    	<div class="col-md-12">
					 <main id="js-page-content" role="main" class="page-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="border-faded bg-faded p-3 mb-g d-flex">
                                    <input type="text" id="js-filter-contacts" name="filter-contacts" class="form-control shadow-inset-2 form-control-lg" placeholder="">
                                    <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                            <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="js-contacts">
                        	<?foreach($rows as $key => $row){?>
                            <div class="col-xl-4">
                                <div id="c_<?=$key?>" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?=fncYaziKucult($row->UNVAN)?>">
                                    <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                                        <div class="d-flex flex-row align-items-center">
                                            <span class="status status-success mr-3">
                                                <span class="rounded-circle profile-image d-block " style="background-image:url('/img/kullanici_yesil.jpg'); background-size: cover;"></span>
                                            </span>
                                            <div class="info-card-text flex-1">
                                                <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                                    <?=$row->BAKIM_GRUP?>
                                                    <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="/tanimlama/bakim_grup.do?route=tanimlama/bakim_grup&id=<?=$row->ID?>"><?=dil("Düzenle")?></a>
                                                </div>
                                                <span class="text-truncate text-truncate-xl"><?=$row->BAKIM_GRUP_ALTYAZI?></span>
                                            </div>
                                            <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_<?=$key?> > .card-body + .card-body" aria-expanded="false">
                                                <span class="collapsed-hidden">+</span>
                                                <span class="collapsed-reveal">-</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?}?>
                            
                        </div>
                    </main>
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
                    <form class="form-horizontal " id="formMarkaDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="marka_kaydet">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="col-md-12">
			            	<div class="form-group">
							  	<label><?=dil("Marka")?></label>
							  	<input type="text" class="form-control" placeholder="" name="marka" id="marka" maxlength="45">
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
	          			<input type="hidden" name="islem" id="islem" value="marka_ekle">
	          			<input type="hidden" name="id" id="id" value="">
		          		<div class="col-md-12">
			            	<div class="form-group">
							  	<label><?=dil("Marka")?></label>
							  	<input type="text" class="form-control" placeholder="" name="marka" id="marka" maxlength="45">
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
		
		initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
		
		$('input[type=radio][name=contactview]').change(function()
        {
            if (this.value == 'grid')
            {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                $('#js-contacts .js-expand-btn').addClass('d-none');
                $('#js-contacts .card-body + .card-body').addClass('show');
		
            }
            else if (this.value == 'table')
            {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                $('#js-contacts .js-expand-btn').removeClass('d-none');
                $('#js-contacts .card-body + .card-body').removeClass('show');
            }
		
        });
                
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
				data: { "islem" : "marka_bilgisi", 'id' : id },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalMarkaDuzenle #id").val( jd.MARKA.ID );
						$("#modalMarkaDuzenle #marka").val( jd.MARKA.MARKA );
						$("#modalMarkaDuzenle #durum").val( jd.MARKA.DURUM );
						$("#modalMarkaDuzenle").modal("show");
					}
				}
			});
			
		}
		
		function fncMarkaKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formMarkaDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//$("#modalMarkaDuzenle").modal("hide");
							location.reload();
						});
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
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//$("#modalMarkaEkle").modal("hide");
							location.reload();
						});
					}
				}
			});
		}
		
		function fncMarkaSil(id){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "marka_sil", 'id': id },
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
