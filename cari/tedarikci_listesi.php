<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows = $cSubData->getTedarikciListesi($_REQUEST);
	
	//var_dump2($Table['sqls']);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-brands.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
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
    	<ol class="breadcrumb page-breadcrumb breadcrumb-seperator-1">
            <li class="breadcrumb-item"><a href="/"><?=dil("Kontrol Paneli")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Tedarikçi Listesi")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
        <section class="content">
		    
	    	<div class="row">
	    		<div class="col-md-12">
	    			<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="fal fa-users fa-2x mr-3"></i> <?=dil("Tedarikçi Listesi")?> </h2>
                        <div class="panel-toolbar" role="menu">
                        	<a href="javascript:fncPopup('/curl/curl_tumu.do?','POPUP_TUMU',1000,400)" class="btn btn-outline-secondary btn-icon waves-effect waves-themed text-white border-white mr-2" title="Tüm Firmalar Curl"> <i class="fal fa-cogs"></i></a>
                        	<button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover datatable">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center"><?=dil("T.ID")?></td>
								          	<td><?=dil("Tedarikçi")?></td>
								          	<td><?=dil("İskonto")?></td>
								          	<td><?=dil("Cron Tarih Baş")?></td>
								          	<td><?=dil("Cron Tarih Bit")?></td>
								          	<td align="center"><?=dil("Cron Durum")?></td>
								          	<td align="center"><?=dil("Ürün Sayısı")?></td>
								          	<td align="center"><?=dil("Cron Yeni")?></td>
								          	<td align="center"><?=dil("Cron Güncel")?></td>
								          	<td align="center">#</td>
								          	<td class="no-sort"></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center" class="bg-gray-100"><?=$row->ID?></td>
									          	<td><?=FormatYazi::kisalt($row->CARI,35)?></td>
									          	<td><?=$row->ISKONTO1?> + <?=$row->ISKONTO2?> + <?=$row->ISKONTO3?></td>
									          	<td><?=FormatTarih::tarih($row->CURL_BAS_TARIH)?></td>
									          	<td><?=FormatTarih::tarih($row->CURL_TARIH)?></td>
									          	<td align="center"><?=$row->CURL_BASARILI?></td>
									          	<td align="center"><?=FormatSayi::sayi($row->URUN_SAYISI,0)?></td>
									          	<td align="center"><?=FormatSayi::sayi($row->CURL_YENI,0)?></td>
									          	<td align="center"><?=FormatSayi::sayi($row->CURL_ESKI,0)?></td>
									          	<td> 
									          		<!--
									          		<form name="form<?=$row->ID?>" id="form<?=$row->ID?>" class="app-forms" enctype="multipart/form-data" method="GET">
														<input type="hidden" name="islem" value="firma_oturum_kaydet">
														<input type="hidden" name="id" value="<?=$row->ID?>">
														<input type="hidden" name="kod" value="<?=$row->KOD?>">
										          		<div class="row">
											          		<div class="col-md-3 px-1">
												          		<div class="form-group">
													          		<div class="input-group">
													          			<div class="input-group-prepend"><span class="input-group-text px-1"><i class="fal fa-user"></i></span></div>
															            <input type="text" class="form-control" name="kullanici" id="kullanici" placeholder="" value="<?=$row->KULLANICI?>" maxlength="25">
															        </div>
															    </div>
														    </div>
														    <div class="col-md-3 px-1">
												          		<div class="form-group">
													          		<div class="input-group">
													          			<div class="input-group-prepend"><span class="input-group-text px-1"><i class="fal fa-key"></i></span></div>
															            <input type="text" class="form-control" name="sifre" id="sifre" placeholder="" value="<?=$row->SIFRE?>" maxlength="25">
															        </div>
															    </div>
															</div>
															<div class="col-md-4">
													          	<button class="btn btn-primary btn-icon waves-effect waves-themed" type="button" id="button-addon5" data-id="<?=$row->ID?>" onclick="fncKaydet(this)" title="Kaydet"><i class="fal fa-save"></i></button>
															</div>
														</div>
													</form>
													-->
									          	</td>
									          	<td class="p-0">
									          		<a href="/cari/cari.do?route=cari/cari_listesi&id=<?=$row->ID?>&kod=<?=$row->KOD?>" target="_blank" class="btn btn-outline-primary btn-icon" title="Cari Bilgileri"> <i class="far fa-edit"></i> </a>	
									          		<a href="/cron/<?=$row->CURL_URL?>" target="_blank" class="btn btn-outline-danger btn-icon" title="Cron Çalıştır"> <i class="far fa-alarm-clock"></i> </a>	
									          		<a href="/yedek_parca/parca_listesi.do?route=yedek_parca/parca_listesi&tedarikci_id=<?=$row->ID?>&filtre=1" target="_blank" class="btn btn-outline-success btn-icon" title="Parça Listesi"> <i class="far fa-arrow-alt-right"></i> </a>	
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
            
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
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
    		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		$('.datatable').DataTable({
		  	paging: false,
		  	pageLength: 100,
		 	lengthChange: true,
		  	searching: true,
		  	ordering: true,
		  	info: false,
		  	autoWidth: false,
		  	select: true,
		  	autoFill: false,
		  	responsive: true,
		  	order: [],
		  	scrollY: '60vh',
        	scrollCollapse: true,
        	columnDefs: [{ targets: 'no-sort', orderable: false }],
			lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Tümü"]],
		});
		
		function fncKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $("#form"+$(obj).data("id")).serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						$(obj).parents("tr").addClass("bg-gray");
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncOptimumTek(obj){
			var str;
			bootbox.prompt({
			    title: "Optimum Dosya No", 
			    centerVertical: true,
			    callback: function(result){ 
			    	if(result){
						fncPopup('/curl/curl_optimum2.do?dosya_no='+result,'OPTIMUM_TEK',800,770);	
					}
			    }
			});
		}
				
	</script>
    
</body>
</html>
