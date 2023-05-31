<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows			= $cSubData->getStokDetaylar($_REQUEST);
	
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
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
   
    <main id="js-page-content" role="main" class="page-content">
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-lg-12 col-md-12 col-sm-12">		          	
	    			
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <i class="fal fa-list mr-3"></i> <?=dil("Stok Hareket Detayı")?> </h2>
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
										<thead class="thead-themed fw-500">
											<tr>
												<td width="3%"></td>
												<td><?=dil("Cari")?></td>
												<td><?=dil("Talep No")?></td>
												<td><?=dil("Fatura No")?></td>
												<td align="center"><?=dil("Fatura Tarih")?></td>
												<td><?=dil("Parça Kodu")?></td>
												<td><?=dil("Stok Kodu")?></td>
												<td><?=dil("Stok Adı")?></td>
												<td align="right"><?=dil("Alış Fiyatı")?></td>
												<td align="right"><?=dil("Satış Fiyatı")?></td>
												<td><?=dil("Adet")?></td>
												<td><?=dil("Hareket")?></td>
											</tr>
										</thead>
										<tbody>
										<?foreach($rows as $key => $row){?>
											<tr>
												<td align="center"><?=($key+1)?></td>
												<td><?=FormatYazi::kisalt($row->CARI,25)?></td>
												<td><?=$row->TALEP_ID?><br>
													<?=$row->PLAKA?>
												</td>
												<td><?=$row->FATURA_NO?></td>
												<td align="center"><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
												<td><?=$row->PARCA_KODU?></td>	
												<td><?=$row->STOK_KODU?></td>	
												<td><?=$row->PARCA_ADI?></td>
												<td align="right"><?=$row->ALIS?> <i class="fal fa-lira-sign"></i></td>
												<td align="right"><?=$row->SATIS?> <i class="fal fa-lira-sign"></i></td>
												<td><?=FormatSayi::sayi($row->ADET,0)?></td>
												<td>
													<?if($row->HAREKET_ID == 1){?>
									          			<a href="/finans/satis_fatura.do?route=finans/satis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" target="_blank" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs"> <?=$row->HAREKET?></a> 
									          		<?} else if($row->HAREKET_ID == 2){?>
									          			<a href="/finans/alis_fatura.do?route=finans/alis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" target="_blank" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs"> <?=$row->HAREKET?></a> 
									          		<?}?>
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
			 	close();
			}
			return false;
		}
		
		$('.datatable').DataTable({
		  	paging: true,
		  	pageLength: 100,
		 	lengthChange: true,
		  	searching: true,
		  	ordering: true,
		  	info: false,
		  	autoWidth: false,
		  	select: true,
		  	autoFill: false,
		  	responsive: true,
        	columnDefs: [{ targets: 'no-sort', orderable: false }],
			lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Tümü"]],
		});
		
		
		
	</script>
    
</body>
</html>
