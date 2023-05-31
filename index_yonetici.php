<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$rows_sayisi		= $cSubData->getFaturaDurumSayisi();
	$row_sepet 			= $cSubData->getSepetSay();
	//$rows				= $cSubData->getHizmetTalep();
	$rowa_banner		= $cSubData->getSiteBanner();
	if(in_array(SITE,array(4))){
	$rows_logo 			= $cSubData->getLogoBanner();
	}
	$row_cari 			= $cSubData->getCari(array("id"=>$_SESSION["cari_id"]));
?>
<!DOCTYPE html>
<html lang="tr" data-lang="tr" class="<?=$cBootstrap->getFontBoyut()?>">
<head>
    <meta charset="utf-8">
    <title> <?=$row_site->TITLE?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" media="screen, print" href="/smartadmin/css/vendors.bundle.css">
    <link rel="stylesheet" media="screen, print" href="/smartadmin/css/app.bundle.css">
    <link rel="stylesheet" media="screen, print" href="/smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="/smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="/smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="/smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="/smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="/smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="/smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">                    
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
    	
        <div class="subheader">
            <h1 class="subheader-title">
             	<?=dil("Kontrol Paneli")?>
             	<small><?=$row_site->BASLIK?> <?=dil("Sipariş Yönetim Platformu")?></small>
            </h1>
        </div>
       	
       	<section class="content">
        <div class="row">
        	<div class="col-sm-12 col-xl-12">
        		<? if(in_array(SITE,array(4))){ ?>
        		<div class="row">
        			<? foreach ($rows_logo as $key => $row_logo) {?>
	        			<div class="col-sm-2 text-center mb-2">
				            <a href="javascript:fncPopup('/tanimlama/popup_banner.do?route=tanimlama/popup_banner&id=<?=$row_logo->MARKA_ID?>','POPUP_BANNER',1200,900);" title="">
				            	<img height="65" src="/img/marka/<?=$row_logo->RESIM_URL?>">
				            </a>
				        </div>
			         <?}?>
        		</div>
        		<?}?>
        		<div class="row">
        			<div class="col-md-3">
        			</div>
		       		<div class="col-sm-6 col-xl-6 text-center">
		       			<div id="panel-5" class="panel">
                            <div class="panel-container show">
                                <div class="panel-content" style="padding: 0.3rem 0.3rem;">
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                        	<?foreach($rowa_banner as $key => $row_banner){?>
												<li data-target="#carouselExampleIndicators" data-slide-to="<?=$key?>" class="<?=($key==0?'active':'')?>"></li>  	
											<?}?>
                                        </ol>
                                        <div class="carousel-inner">
                                        	<?foreach($rowa_banner as $key => $row_banner){?>
                                            <div class="carousel-item <?=($key==0?'active':'')?>">
                                                <img class="d-block w-100" src="<?=$cSabit->imgPath($row_banner->URL)?>" alt="<?=$key?>">
                                            </div>
                                            <?}?>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Geri</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">İleri</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
		        	</div>
		        	<div class="col-md-3">
        			</div>
		       	</div>
		        <div class="row mt-1">
		        	<div class="col-sm-6 col-xl-3 mt-3 offset-xl-3">
			        	<a href="/musteri/stok_arama.do?route=musteri/stok_arama" class="btn btn-warning btn-block btn-lg">
			            	<i class="far fa-search fa-2x mr-3"></i> <span class="fa-2x"><?=dil("Stok Arama")?></span>
			        	</a>
			        </div>
			        <div class="col-sm-6 col-xl-3 mt-3">
			        	<a href="/musteri/sepet.do?route=musteri/sepet" class="btn btn-info btn-block btn-lg">
			            	<i class="far fa-shopping-basket fa-2x mr-4"></i>
			            	<span class="badge border border-light rounded-pill bg-danger-500 position-absolute  mt-2 fs-md" style="margin-left: -30px"><?=$row_sepet->SAY?></span> 
			            	<span class="fa-2x"><?=dil("Sepetim")?></span>
			        	</a>
			        </div>
		        </div>		        
		        <div class="row mt-3">
        			<div class="col-sm-4 col-xl-2 offset-xl-3">
			            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
			                <div class="">
			                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
			                        <a href="/finans/cari_hareketler.do?route=finans/cari_hareketler&filtre=1&fatura_durum_id=1" class="text-white"> <?=(int)$rows_sayisi[1]->TOPLAM?> </a>
			                        <small class="m-0 l-h-n"><?=dil("Bekleyen Siparişler")?></small>
			                    </h3>
			                </div>
			                <i class="fal fa-shopping-cart position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1 p-3" style="font-size:4rem"></i>
			            </div>
			        </div>
			        <div class="col-sm-4 col-xl-2">
			            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
			                <div class="">
			                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
			                        <a href="/finans/cari_hareketler.do?route=finans/cari_hareketler&filtre=1&fatura_durum_id=2" class="text-white"> <?=(int)$rows_sayisi[2]->TOPLAM?> </a>
			                        <small class="m-0 l-h-n"><?=dil("Onaylanan Siparişler")?></small>
			                    </h3>
			                </div>
			                <i class="fal fa-check-circle position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1 p-3" style="font-size:4rem"></i>
			            </div>
			        </div>
		       		<div class="col-sm-4 col-xl-2">
			            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
			                <div class="">
			                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
			                        <a href="/finans/cari_hareketler.do?route=finans/cari_hareketler&filtre=1&fatura_durum_id=10" class="text-white"> <?=(int)$rows_sayisi[10]->TOPLAM?> </a>
			                        <small class="m-0 l-h-n"><?=dil("Tamamlanan Sipariler")?></small>
			                    </h3>
			                </div>
			                <i class="fal fa-edit position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1 p-3" style="font-size:4rem"></i>
			            </div>
			        </div>
		        </div>
		        
		        <div class="row">
			    	<div class="col-sm-8 col-xl-2 offset-xl-5">
			    		<table class="table table-sm table-condensed bg-gray-300">
			    			<thead class="bg-primary-300 fw-500">
			    				<tr>
			    					<td align="center"> </td>
			    					<td align="center"><?=dil("Alış")?></td>
			    					<td align="center"><?=dil("Satış")?></td>
			    				</tr>
			    			</thead>
			    			<tbody>
			    				<tr>
			    					<td align="center"><i class="fal fa-dollar-sign"></i></td>
			    					<td align="center"><?=$rows_doviz->DOLAR->ALIS?></td>
			    					<td align="center"><?=$rows_doviz->DOLAR->SATIS?></td>
			    				</tr>
			    				<tr>
			    					<td align="center"><i class="fal fa-euro-sign"></i></td>
			    					<td align="center"><?=$rows_doviz->EURO->ALIS?></td>
			    					<td align="center"><?=$rows_doviz->EURO->SATIS?></td>
			    				</tr>
			    				<tr>
			    					<td align="center"><i class="fal fa-pound-sign"></i></td>
			    					<td align="center"><?=$rows_doviz->STERLIN->ALIS?></td>
			    					<td align="center"><?=$rows_doviz->STERLIN->SATIS?></td>
			    				</tr>
			    			</tbody>
			    		</table>
			    	</div>
				</div>
			</div>
			
        </div>
        </section>
    </main> 
    <?=$cBootstrap->getFooter()?>
    </div>
    </div>
    </div>
    
    <div class="modal fade modalAyarlar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-right">
            <div class="modal-content">
                <div class="modal-header bg-primary-300">
                    <h5 class="modal-title h4"> <i class="fal fa-cog fs-xl mr-3"></i> <?=dil("Ayarlar")?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                	<?if(SITE == 3){?>
	                    <div class="card mb-5">
	                        <div class="card-body p-3">
	                            <h5>
	                                <?=dil("Stok Listesi")?>
	                                <small class="mt-0 mb-3 text-muted">
	                                    <?=dil("Natraya bağlanarak stok listesinin alınması")?>
	                                </small>
	                                <span class="badge badge-primary fw-n position-absolute pos-top pos-right mt-3 mr-3">C</span>
	                            </h5>
	                            <div class="row fw-300">
	                                <div class="col text-left">
	                                  	<a href="javascript:fncPopup('/cron/cron_otoplus_stok.php','POPUP_CRON_STOK',1100,850);" class="btn btn-outline-secondary btn-icon mr-1"> <i class="far fa-download"></i> </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="card mb-g">
	                        <div class="card-body p-3">
	                            <h5 class="text-success">
	                                <?=dil("Cari Listesi")?>
	                                <small class="mt-0 mb-3 text-muted">
	                                    <?=dil("Natraya bağlanarak cari listesinin alınması")?>
	                                </small>
	                                <span class="badge badge-primary fw-n position-absolute pos-top pos-right mt-3 mr-3">C</span>
	                            </h5>
	                            <div class="row fs-b fw-300 text-secondar">
	                                <div class="col text-left">
	                        			<a href="javascript:fncPopup('/cron/cron_otoplus_cari.php','POPUP_CRON_STOK',1100,850);" class="btn btn-outline-secondary btn-icon mr-1"> <i class="far fa-download"></i> </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
                    <?}?>
                </div>
                <div class="modal-footer">
				
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
    <script type="text/javascript">
        //$('#js-page-content').smartPanel();
        /*
        $.i18n.init({
			resGetPath: '/smartadmin/media/data/__lng__.json',
			load: 'unspecific',
			fallbackLng: false,
			lng: 'tr'
		}, function (t){
			$('[data-i18n]').i18n();
		});	
		*/
		
		$('.datatable').DataTable({
            responsive: true,
            dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'colvis',
                    text: 'Başlık Gizle',
                    titleAttr: '',
                    className: 'btn-outline-default'
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    titleAttr: '',
                    className: 'btn-outline-default'
                },
                {
                    extend: 'copyHtml5',
                    text: 'Kopyala',
                    titleAttr: '',
                    className: 'btn-outline-default'
                },
                {
                    extend: 'print',
                    text: '<i class="fal fa-print"></i>',
                    titleAttr: 'Yazdır',
                    className: 'btn-outline-default'
                }
            ],
            columnDefs: [{
                    targets: -1,
                    title: '',
                    orderable: false,
                },
			]
        });
                
		$('.datatable2').DataTable({
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
		
		$('.carousel').carousel({
		  	interval: 3000
		})
		
    </script>
        
</body>
</html>
