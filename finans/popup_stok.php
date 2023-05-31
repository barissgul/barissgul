<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows			= $cSubData->getStoklar($_REQUEST);
	
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
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="<?=$cBootstrap->getBody()?>">
    <div class="page-wrapper">
    <div class="page-inner">
   
    <main id="js-page-content" role="main" class="page-content">
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-lg-10 offset-lg-1 col-md-12 col-sm-12">		          	
	    			
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <i class="fal fa-plus mr-3"></i> <?=dil("Stoklar")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover table-sm table-striped datatable mb-0">
										<thead>
											<tr>
												<td width="5%"></td>
												<td><?=dil("Stok Kodu")?></td>
												<td><?=dil("Stok Adı")?></td>
												<td><?=dil("Adet")?></td>
												<td align="right"><?=dil("Alış Fiyatı")?></td>
											</tr>
										</thead>
										<tbody>
										<?foreach($rows as $key => $row){?>
											<tr>
												<td><button class="btn btn-outline-primary btn-sm" onclick="fncSec(this)" data-id="<?=($key+1)?>"><?=dil("Seç")?></button></td>
												<td id="k<?=($key+1)?>"><?=$row->PARCA_KODU?></td>	
												<td id="p<?=($key+1)?>"><?=$row->PARCA_ADI?></td>
												<td id="a<?=($key+1)?>"><?=$row->ADET?></td>
												<td id="f<?=($key+1)?>" align="right"><?=FormatSayi::sayi($row->FIYAT)?> <i class="fal fa-lira-sign"></i></td>
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
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
    <script src="../smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    
		$("[data-mask]").inputmask();	
		
		function fncSec(obj){
			if (window.opener && window.opener !== window) {
			 	window.opener.document.getElementById("yp_parca_kodu<?=$_REQUEST['sira']?>").value = $("#k"+$(obj).data("id")).text();
			 	window.opener.document.getElementById("yp_parca_adi<?=$_REQUEST['sira']?>").value = $("#p"+$(obj).data("id")).text();
			 	<?if($_REQUEST['sayfa'] == "servis"){?>
			 	window.opener.document.getElementById("yp_alis<?=$_REQUEST['sira']?>").value = $("#f"+$(obj).data("id")).text();
			 	<?}?>
			 	close();
			}
			return false;
		}
		
		$('.datatable').DataTable({
		  	paging: true,
		  	pageLength: 100,
		 	lengthChange: true,
		  	searching: true,
		  	search:{
				search:"<?=$_REQUEST['parca_kodu']?>"
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
		
		function fncSayiDb(sayi){
			if(sayi == "NaN" || sayi == "") return 0;
			yeni = sayi.replace('.','').replace(',','.');
			yeni = parseFloat(yeni).toFixed(2);
			return yeni;
		}
		
		function fncSayiTr(sayi){
			yeni = parseFloat(sayi).toFixed(2);
			yeni = yeni.replace(".",",");
			return yeni;
		}
		
	</script>
    
</body>
</html>
