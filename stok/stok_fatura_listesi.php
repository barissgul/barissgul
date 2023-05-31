<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$_REQUEST['filtre'] = 1;
	$_REQUEST['kod'] = "5f86b5d76d50ac25d0703a25e5fb8929";
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("Finans Kalemi","FINANS_KALEMI","");
	$excel->sutunEkle("Fatura No","FATURA_NO","");
	$excel->sutunEkle("Fatura Tarih","FATURA_TARIH","");
	$excel->sutunEkle("Talep No","TALEP_ID","");
	$excel->sutunEkle("Plaka","PLAKA","");
	$excel->sutunEkle("Cari Kod","CARI_KOD","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("Tutar","TUTAR","");
	$excel->sutunEkle("Tarih","TARIH","");
	$excel->sutunEkle("Kayıt Yapan","KAYIT_YAPAN","");
	$excel->sutunEkle("Açıklama","ACIKLAMA","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaStokEktre")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
	$rows = $Table['rows'];//echo json_encode($rows);die();
	$_SESSION['Table'] = $Table;
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
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
            <li class="breadcrumb-item active"><?=dil("Stok Fatura Listesi")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
        <section class="content">
	    	<div class="row">
	    		<div class="col-md-12">
	    			<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="fal fa-users mr-3"></i> <?=dil("Stok Fatura Listesi")?> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                        	<a href="/finans/cari_aktarma.do?route=cari/cari_aktarma" class="btn btn-icon btn-outline-secondary text-white border-white mr-1" title="Cari Aktarma"> <i class="far fa-user-times"></i> </a>
                            <a href="/finans/cari.do?route=<?=$_REQUEST['route']?>" class="btn btn-icon btn-outline-secondary text-white border-white mr-1" title="Cari Ekle"> <i class="far fa-plus"></i> </a>
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-icon btn-light mr-1"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
					  		<table class="table table-sm table-condensed table-hover datatable">
						  		<thead class="thead-themed fw-500">
							    	<tr class="fw-500">
							          	<td align="center"><?=dil("İşlem No")?></td>
							          	<td align="center"><?=dil("Fatura Tarih")?></td>
							          	<td align="center"><?=dil("Vade Tarih")?></td>
							          	<td><?=dil("Finans Kalemi")?></td>
							          	<td><?=dil("Fatura No")?></td>
							          	<td><?=dil("Plaka")?></td>
							          	<td align="center"><?=dil("Stok Sayısı")?></td>
							          	<td><?=dil("Açıklama")?></td>
							        </tr>
						        </thead>
						        <tbody>
							        <?foreach($rows as $key=>$row) {?>
								        <tr>
								          	<td align="center">
								          		<a href="/finans/alis_fatura.do?route=finans/alis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs"> <?=$row->ID?></a> 
								          	</td>
								          	<td align="center"><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
								          	<td align="center">
									          	<?if(str_replace('-','',$row->VADE_TARIH) <= str_replace('-','',date('Ymd'))){?>
									          		<i class="text-danger"> <?=FormatTarih::tarih($row->VADE_TARIH)?> </i>
									          	<?} else {?>
									          		<i class="text-success"> <?=FormatTarih::tarih($row->VADE_TARIH)?> </i>
									          	<?}?>
								          	</td>
								          	<td><?=$row->FINANS_KALEMI?></td>
								          	<td><?=$row->FATURA_NO?></td>
								          	<td><?=$row->PLAKA?></td>
								          	<td align="center" class=""><?=FormatSayi::sayi($row->TUTAR,0)?></td>								          	
								          	<td><?=FormatYazi::satir($row->ACIKLAMA,50)?></td>
								        </tr>
							        <?}?>
						        </tbody>
						  	</table>
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
    
		$("[data-mask]").inputmask();
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		$('#tarih, #gtarih').daterangepicker({
			timePicker: false,
			timePicker24Hour: true,
			timePickerIncrement: 30, 
			locale: {
		        "format": "DD-MM-YYYY",
		        "separator": " , ",
		        "applyLabel": "Tamam",
		        "cancelLabel": "İptal",
		        "fromLabel": "From",
		        "toLabel": "To",
		        "customRangeLabel": "Custom",
		        "weekLabel": "W",
		        "daysOfWeek": [
		            "Pa",
		            "Pz",
		            "Sa",
		            "Ça",
		            "Pe",
		            "Cu",
		            "Ct"
		        ],
		        "monthNames": [
		            "Ocak",
		            "Şubat",
		            "Mart",
		            "Nisan",
		            "Mayıs",
		            "Haziran",
		            "Temmuz",
		            "Ağustos",
		            "Eylül",
		            "Ekim",
		            "Kasım",
		            "Aralık"
		        ],
		        "firstDay": 1
		    },
		});
		
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
		
		$("#cari_kod, #cari, #tck").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
				
	</script>
    
</body>
</html>
