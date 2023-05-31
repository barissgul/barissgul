<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("#","SIRA","");
	$excel->sutunEkle("İşlem No","ID","");
	$excel->sutunEkle("Kasa","ODEME_KANALI","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("Plaka","PLAKA","");
	$excel->sutunEkle("Senet/Çek No","SENET_NO","");
	$excel->sutunEkle("Senet/Çek Sahibi","SENET_SAHIBI","");
	$excel->sutunEkle("Senet/Çek Ciro","SENET_BORCLU","");
	$excel->sutunEkle("Senet/Çek No","SENET_NO","");
	$excel->sutunEkle("Hesap No","SENET_HESAP_NO","");
	$excel->sutunEkle("Senet Vade Tarihi","SENET_VADE_TARIH","");
	$excel->sutunEkle("Senet Düzenlenme Tarihi","SENET_TARIH","");
	$excel->sutunEkle("Tutar","TUTAR","");
	$excelOut = $excel->excel();
	$_REQUEST['filtre']		= 1;
	$Table = $cTable->setSayfa("sayfaSenetTakip")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows = $Table['rows'];
	$_SESSION['Table'] = $Table;
	
	//var_dump2($Table['sqls']);
	$rows_firma = $cSubData->getFirmalar($_REQUEST);
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
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
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
            <li class="breadcrumb-item active"><?=dil("Senet/Çek Takip")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
        <section class="content">
		    
	    	<div class="row">
	    		<div class="col-md-12">
	    			<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="far fa-lira-sign mr-3"></i> <?=dil("Senet/Çek Takip")?> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-outline-secondary btn-icon waves-effect waves-themed border-white text-white"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover datatable">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center">#</td>
								          	<td align="center"><?=dil("No")?></td>
								          	<td><?=dil("Hareket")?></td>
								          	<td><?=dil("Kasa")?></td>
								          	<td><?=dil("Cari")?></td>
								          	<td><?=dil("Senet/Çek Hesap")?></td>
								          	<td><?=dil("Senet/Çek Sahibi")?></td>
								          	<td><?=dil("Senet/Çek Ciro")?></td>
								          	<td><?=dil("Senet/Çek No")?></td>
								          	<td><?=dil("Hesap No")?></td>
								          	<td align="center"><?=dil("Senet Düz.Tarihi")?></td>
								          	<td align="center"><?=dil("Senet Vade Tarihi")?></td>
								          	<td align="right"><?=dil("Tutar")?></td>
								          	<td align="center"><?=dil("Durum")?></td>
								          	<td class="no-sort"> </td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center" class="bg-gray-100"><?=($key+1)?></td>									          
									          	<td align="center"> 
									          		<?if($row->HAREKET_ID == 3){?>
									          			<a href="javascript:fncPopup('/finans/tahsilat.do?route=finans/tahsilat&id=<?=$row->ID?>&kod=<?=$row->KOD?>','TAHSILAT',1000,800 )" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-sm"> <?=$row->ID?></a>
									          		<?} else if($row->HAREKET_ID == 4){?>
									          			<a href="javascript:fncPopup('/finans/tediye.do?route=finans/tediye&id=<?=$row->ID?>&kod=<?=$row->KOD?>','TEDIYE',1000,800 )" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-sm"> <?=$row->ID?></a> 
									          		<?}?>
									          	</td>
									          	<td><?=$row->HAREKET?></td>
									          	<td><?=$row->ODEME_KANALI?></td>
									          	<td><?=$row->CARI?></td>
									          	<td><?=$row->SENET_NO?></td>
									          	<td><?=$row->SENET_SAHIBI?></td>
									          	<td><?=$row->SENET_BORCLU?></td>
									          	<td><?=$row->SENET_NO?></td>
									          	<td><?=$row->SENET_HESAP_NO?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->SENET_TARIH)?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->SENET_VADE_TARIH)?></td>
									          	<td align="center"><?=FormatSayi::sayi($row->TUTAR)?></td>
									          	<td align="center">
									          		<?if($row->HAREKET_ID == 3 AND $row->SENET_DURUM == 1){?>
									          			<span class="text-danger fw-700"><?=dil("Verildi")?></span>
									          		<?} else if($row->HAREKET_ID == 4 AND $row->SENET_CARI_HAREKET_ID > 0){?>
									          			<span class="text-info fw-700"><?=$row->SENET_CARI_HAREKET_ID?></span>
									          		<?} else if($row->HAREKET_ID == 3){?>
									          			<span class="text-success fw-700"><?=dil("Bekliyor")?></span>	
									          		<?}?>
									          	</td>
									          	<td align="left">
									          		<a href="<?=fncOdemePopupLink($row)?>" class="btn btn-outline-primary btn-icon waves-effect waves-themed" title=""> <i class="fal fa-print"></i></a>
									          		<?if($row->HAREKET_ID == 3){?>
									          			<a href="javascript:fncPopup('/finans/tediye.do?route=finans/tediye&tahsilat_id=<?=$row->ID?>','TEDIYE',1000,800 )" class="btn btn-warning waves-effect waves-themed btn-sm"> <?=dil("Tediye")?></a>
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
    <script src="/smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
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
		
		function fncHizmetSurecDoldur(obj){
			$("#surec_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "hizmet_surec_doldur", 'hizmet_id' : $(obj).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						$('#surec_id').html("");
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$('#surec_id').html(jd.HTML);
					}
					$("#surec_id").removeAttr("disabled");
				}
			});
		}
				
	</script>
    
</body>
</html>
