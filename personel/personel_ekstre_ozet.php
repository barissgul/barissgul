<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$_REQUEST["filtre"] = 1;
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("Durum","DURUM","");
	$excel->sutunEkle("Maaş Dönem","MAAS_DONEM","");
	$excel->sutunEkle("Cari Kod","CARI_KOD","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("Departman","DEPARTMAN","");
	$excel->sutunEkle("Görev","GOREV","");
	$excel->sutunEkle("Maaş","MAAS","");
	$excel->sutunEkle("Bakiye","TUTAR","");
	$excel->sutunEkle("Son Hareket Tarih","TARIH","");
	$excel->sutunEkle("Bu Ay Verilen Avans","VERILEN_AVANS","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaPersonelEkstreOzet")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
	$rows = $Table['rows'];
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
    	
    	<section class="content">		    
	    	<div class="row">
		    	<div class="col-xl-12">
		    		<div class="panel">
                    <div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="fal fa-users mr-3"></i> <b> <?=dil("Pesonel Ekstre Özet")?> </b> <span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
			            	<a href="../excel_sql.do?" title="Excel" class="btn btn-light btn-icon"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed fw-500">
							    	<tr>
							          	<td align="center">#</td>
							          	<td align="center"><?=dil("Durum")?></td>
							          	<td align="center"><?=dil("Maaş Dönem")?></td>
							          	<td><?=dil("Cari Kod")?></td>
							          	<td><?=dil("Cari")?></td>
							          	<td><?=dil("Departman")?></td>
							          	<td><?=dil("Görev")?></td>
							          	<td align="right"><?=dil("Maaş")?></td>
							          	<td align="right"><?=dil("Bakiye")?> </td>
							          	<td align="center"><?=dil("Son Hareket Tarih")?></td>
							          	<td align="right"><?=dil("Bu Ay Verilen Avans")?> </td>
							          	<td></td>
							        </tr>
						        </thead>
						        <tbody>
							        <?
							        foreach($rows as $key=>$row) {
							        	$row_toplam->TUTAR 		+= -1 * $row->TUTAR;
							        	$row_toplam->MAAS 		+= $row->MAAS;
							        	?>
								        <tr>
								          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
								          	<td align="center">
								          		<?if($row->DURUM == "Aktif"){?>
								          			<span class="text-success"> <?=dil("Aktif")?> </span>
								          		<?} else {?>
								          			<span class="text-danger"> <?=dil("Pasif")?> </span>
								          		<?}?>
								          	</td>
								          	<td align="center"><?=$row->MAAS_DONEM?></td>
								          	<td> <a href="/personel/personel.do?route=personel/personel&id=<?=$row->ID?>&kod=<?=$row->KOD?>" title="Ektre"> <?=$row->CARI_KOD?> </a> </td>
								          	<td> <a href="javascript:fncPopup('/finans/ekstre.do?route=finans/ekstre&kod=<?=$row->KOD?>&filtre=1&finans_kalemi_id=<?=$_REQUEST["finans_kalemi_id"]?>&talep_no=<?=$_REQUEST["talep_no"]?>','EKSTRE',1000,800);" title="Ektre"> <?=$row->CARI?> </a> </td>		          	
								          	<td> <?=$row->DEPARTMAN?> </td>
								          	<td> <?=$row->GOREV?> </td>
								          	<td align="right"><?=FormatSayi::sayi($row->MAAS)?> <i class="far fa-lira-sign"></i></td>
								          	<td align="right"><?=FormatSayi::sayi($row->TUTAR)?> <i class="far fa-lira-sign"></i></td>
								          	<td align="center"><?=FormatTarih::tarih($row->TARIH)?></td>
								          	<td align="right"><?=FormatSayi::sayi($row->VERILEN_AVANS)?> <i class="far fa-lira-sign"></i></td>
								          	<td align="center">
								          		<a href="javascript:fncPopup('/finans/tediye.do?route=finans/tediye&cari_id=<?=$row->ID?>','TEDIYE',1000,800);" class="btn btn-secondary btn-icon waves-effect waves-themed" title="Personel Ödeme"> <i class="fal fa-plus"></i></a>
								          		<a href="javascript:fncPopup('/finans/tahsilat.do?route=finans/tahsilat&cari_id=<?=$row->ID?>','TAHSILAT',1000,800);" class="btn btn-primary btn-icon waves-effect waves-themed" title="Personel Maaş"> <i class="fal fa-plus"></i></a>
								          	</td>
								        </tr>
							        <?}?>
							        <tr class="thead-themed">
							          	<td colspan="6"> </td>
							          	<td align="right"> <?=dil("Toplam")?> : </td>
							          	<td align="right"><?=FormatSayi::sayi($row_toplam->MAAS)?> <i class="far fa-lira-sign"></i></td>
							          	<td align="right"><?=FormatSayi::sayi($row_toplam->TUTAR)?> <i class="far fa-lira-sign"></i></td>
							          	<td> </td>
							          	<td> </td>
							          	<td></td>
							        </tr>
						        </tbody>
						  	</table>
						  	<div class="frame-wrap text-center">
		                        <nav> 
		                            <ul class="pagination justify-content-center">
		                            	<?=$Table["sayfaAltYazi"];?>
		                            </ul>
		                        </nav>
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
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		var start = moment().subtract(29, 'days');
        var end = moment();
		
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
            
		$('#tarih, #odeme_tarih').daterangepicker({
			timePicker: false,
			timePicker24Hour: true,
			timePickerIncrement: 30, 
			locale: {
		        "format": "DD-MM-YYYY",
		        "separator": " , ",
		        "applyLabel": "Uygula",
		        "cancelLabel": "Vazgeç",
		        "fromLabel": "Dan",
		        "toLabel": "a",
		        "customRangeLabel": "Seç",
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
		    ranges: {
                'Bugün': [moment(), moment()],
                'Dün': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Son 7 gün': [moment().subtract(6, 'days'), moment()],
                'Son 30 gün': [moment().subtract(29, 'days'), moment()],
                'Bu Ay': [moment().startOf('month'), moment().endOf('month')],
                'Geçen Ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }, 
		}, cb);
		
		cb(start, end);
		
		$("#talep_no, #plaka, #dosya_no").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
		
	</script>
    
</body>
</html>
