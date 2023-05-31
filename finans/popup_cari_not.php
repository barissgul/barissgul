<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row				= $cSubData->getCari($_REQUEST);
	$rows_cari_notu		= $cSubData->getCariNotlari($_REQUEST);
	//fncKodKontrol($row);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <link rel="stylesheet" href="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.css">
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
    
    <main id="js-page-content" role="main" class="page-content">        
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-xl-8 offset-xl-2 col-lg-12 col-md-12 col-sm-12">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <i class="far fa-clipboard-list mr-3"></i> <?=dil("Cari Notu")?> &nbsp; <span class="badge badge-primary float-right"><?=$row->CARI?></span> </h2>
                        <div class="panel-toolbar">                        	
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
		              		<div class="panel-content">
                                <div class="input-group mb-2">							                			
				                    <input type="text" class="form-control form-control" placeholder="Mesaj yaz" name="cari_notu" id="cari_notu" value="" maxlength="255">
				                    <div class="input-group-append">
				                        <button type="button" class="btn btn-success" id="btnKaydet" onclick="fncCariNotuKaydet(this)" data-id="<?=$row->ID?>" data-onay="1" data-kod="<?=$row->KOD?>" title="Kaydet"> <?=dil("Yaz")?> </button>
				                    </div>
				                </div>
                                <div class="bg-warning-100 border border-warning rounded">
                                    <div class="input-group p-2 mb-0">
                                        <input type="text" class="form-control shadow-inset-2 bg-warning-50 border-warning" id="js-list-msg-filter" placeholder="Filtrele">
                                        <div class="input-group-append">
                                            <div class="input-group-text bg-warning-500 border-warning">
                                                <i class="fal fa-search fs-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <ul id="js-list-msg" class="list-group px-2 pb-2 js-list-filter">
                                    	<?foreach($rows_cari_notu as $key => $row_cari_notu){?>
                                    		<li class="list-group-item px-1 py-1">
	                                            <span data-filter-tags="<?=strtolower($row_cari_notu->CARI_NOTU)?>">
							            			<div class="d-flex align-items-center m-0">
			                                            <div class="d-inline-block align-middle mr-2">
			                                                <span class="profile-image-md rounded-circle d-block" style="background-image:url('/img/kullanici_yesil.jpg'); background-size: cover;"></span>
			                                            </div>
			                                            <div class="flex-1 min-width-0">
			                                                <span class="text-truncate"><?=$row_cari_notu->CARI_NOTU?></span>
			                                                <div class="text-muted small">
			                                                	<?=FormatTarih::tarih($row_cari_notu->TARIH)?>, <?=$row_cari_notu->EKLEYEN?> 
			                                                </div>
			                                            </div>
			                                            <div class="flex-1 min-width-0">
			                                            	<a href="javascript:void(0)" class="btn btn-outline-danger btn-sm float-right" onclick="fncCariNotuSil(this)" data-id="<?=$row_cari_notu->ID?>" title="<?=dil("Notu Sil")?>"> <i class="far fa-trash"></i> </a>
			                                            </div>
			                                        </div>
		                                        </span>
		                                    </li>
							    		<?}?>
                                    </ul>
                                    <div class="filter-message js-filter-message mt-0 fs-sm"></div>
                                </div>
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
            
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
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
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		$("#cari_notu").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncCariNotuKaydet($('#btnKaydet'));
		    }
		});
		
		function fncCariNotuKaydet(obj){
			if($('#cari_notu').val() == null || $('#cari_notu').val() == ""){
				alert('Notu giriniz!');
				return;
			}
			
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "cari_notu_kaydet", 'id': $(obj).data("id"), 'kod': $(obj).data("kod"), 'cari_notu': $('#cari_notu').val()},
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
		
		function fncCariNotuSil(obj){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem" : "cari_notu_sil", 'cari_notu_id' : $(obj).data("id"), 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>", },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
							}else{
								toastr.success(jd.ACIKLAMA);
								$(obj).parents("li").hide();
							}
						}
					});
				}
			});
		}
		
	</script>
    
</body>
</html>
