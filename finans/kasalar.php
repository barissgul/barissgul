<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows 	= $cSubData->getHesapOzet($_REQUEST);
	$rows2 	= $cSubData->getKasaOzet($_REQUEST);
	
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
                        <h2> <b> <?=dil("Ödeme Kanalı - Hesaplar")?> </b></h2>
                        <div class="panel-toolbar">
			            	
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed">
							    	<tr>
							          	<td align="center">#</td>
							          	<td><?=dil("Ödeme Kanalı")?></td>
							          	<td><?=dil("Ödeme Kanalı Detay")?></td>
							          	<td align="right"><?=dil("Tahsilat")?></td>
							          	<td align="right"><?=dil("Tediye")?></td>
							          	<td align="right"><?=dil("Bakiye")?> </td>
							        </tr>
						        </thead>
						        <tbody>
							        <?
							        foreach($rows as $key=>$row) {
							        	$row_toplam->TAHSILAT 	+= $row->TAHSILAT;
							        	$row_toplam->TEDIYE 	+= $row->TEDIYE;
							        	$row_toplam->BAKIYE 	+= $row->BAKIYE;
							        	?>
								        <tr>
								          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
								          	<td><?=$row->ODEME_KANALI?></td>
								          	<td><?=$row->ODEME_KANALI_DETAY?></td>
								          	<td align="right"><?=FormatSayi::db2tr($row->TAHSILAT)?> <i class="far fa-lira-sign"></i></td>
								          	<td align="right"><?=FormatSayi::db2tr($row->TEDIYE)?> <i class="far fa-lira-sign"></i></td>
								          	<td align="right"><?=FormatSayi::db2tr($row->BAKIYE)?> <i class="far fa-lira-sign"></i></td>
								        </tr>
							        <?}?>
							        <tr class="thead-themed">
							          	<td colspan="2"> </td>
							          	<td align="right"> <?=dil("Toplam")?>: </td>
							          	<td align="right"><?=FormatSayi::db2tr($row_toplam->TAHSILAT)?> <i class="far fa-lira-sign"></i></td>
							          	<td align="right"><?=FormatSayi::db2tr($row_toplam->TEDIYE)?> <i class="far fa-lira-sign"></i></td>
							          	<td align="right"><?=FormatSayi::db2tr($row_toplam->BAKIYE)?> <i class="far fa-lira-sign"></i></td>
							        </tr>
						        </tbody>
						  	</table>
						  	</div>
						</div>
					</div>
					</div>
					
					<div class="panel">
                    <div class="panel-hdr bg-primary-300 text-white">
                        <h2> <b> <?=dil("Kasa")?> </b></h2>
                        <div class="panel-toolbar">
			            	
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed">
							    	<tr>
							          	<td align="center"><?=dil("Tahsilat - Satış Fatura")?></td>
							          	<td align="center"><?=dil("Tediye - Alış Fatura")?></td>
							          	<td align="center"><?=dil("Bakiye")?> </td>
							        </tr>
						        </thead>
						        <tbody>
							        <?
							        foreach($rows2 as $key=>$row) {
							        	$row_toplam->TAHSILAT 	+= $row->TAHSILAT;
							        	$row_toplam->TEDIYE 	+= $row->TEDIYE;
							        	$row_toplam->BAKIYE 	+= $row->BAKIYE;
							        	?>
								        <tr>								          	
								          	<td align="center"><?=FormatSayi::db2tr($row->TAHSILAT)?> <i class="far fa-lira-sign"></i></td>
								          	<td align="center"><?=FormatSayi::db2tr($row->TEDIYE)?> <i class="far fa-lira-sign"></i></td>
								          	<td align="center"><?=FormatSayi::db2tr($row->BAKIYE)?> <i class="far fa-lira-sign"></i></td>
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
