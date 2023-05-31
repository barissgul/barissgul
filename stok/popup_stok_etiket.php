<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row			= $cSubData->getStok($_REQUEST);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/page-invoice.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <?$cBootstrap->getTemaCss()?>
    <style>
    	table tbody tr td{
			font-size: 18px;
			
		}
    </style>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
   
    <main id="js-page-content" role="main" class="page-content">
	 	
	 	<div class="container">
            <div data-size="A4">
                <div class="row">
                    <div class="col-sm-12 text-center">
                		<a href="javascript:window.print()" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1" title=""> <i class="fal fa-print fs-xl"></i></a>
                	</div>
                </div>
                <div class="row">
                	<?for($i = 1; $i <= 4 ; $i++){?>
                    <div class="col-sm-6">
                    	<div class="table-responsive border-left border-right border-top border-bottom p-2 mb-4">
	                    	<table class="table table-clean table-sm w-100 align-self-end">
		                        <tbody>
		                        	<tr>
		                                <td colspan="2" align="center"><span class="fw-500 display-3"><?=$row->KODU?></span></td>
		                            </tr>
		                            <tr>
		                                <td colspan="2" align="center"><span class="fw-500 display-3 color-primary-600"><?=$row->OEM_KODU?></span></td>
		                            </tr>
		                            <tr>
		                                <td align="left"><b><?=dil("Parça Marka")?></b></td>
		                                <td><?=$row->PARCA_MARKA?></td>
		                            </tr>
		                            <tr>
		                                <td align="left"><b><?=dil("Stok Adı")?></b></td>
		                                <td><?=FormatYazi::kisalt($row->STOK,25)?></td>
		                            </tr>
		                            <tr>
		                                <td align="left"><b><?=dil("Muadil Kodu")?></b></td>
		                                <td><?=$row->MUADIL_KODUS?></td>
		                            </tr>
		                            <tr>
		                                <td align="left"><b><?=dil("Barkod")?></b></td>
		                                <td><?=$row->BARKOD?></td>
		                            </tr>
		                            
		                            <tr>
		                                <td align="left"><b><?=dil("Tarih")?></b></td>
		                                <td><?=FormatTarih::tarih($row->TARIH)?></td>
		                            </tr>
		                            <tr>
		                            	<td colspan="2" align="center">
		                            		<div id="barcode<?=$i?>"></div>
		                            	</td>
		                            </tr>
		                        </tbody>
		                    </table>
	                    </div>
                    </div>
                    <?}?>
                </div>
                
            </div>
        </div>
		
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
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/jquery-barcode.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    	
    	var settings = {
          	output: "css",
          	bgColor: "#FFFFFF",
          	color: "#000000",
          	barWidth: 2,
          	barHeight: 50,
          	moduleSize: 5,
          	fontSize: 20,
          	posX: 0,
          	posY: 0,
          	marginHRI: 5,
          	showHRI:true,
          	addQuietZone: true
        };
        
    	$("#barcode1").barcode("<?=$row->BARKOD?>","code128", settings);
    	$("#barcode2").barcode("<?=$row->BARKOD?>","code128", settings);
    	$("#barcode3").barcode("<?=$row->BARKOD?>","code128", settings);
    	$("#barcode4").barcode("<?=$row->BARKOD?>","code128", settings);
        
		$("[data-mask]").inputmask();
		
	</script>
    
</body>
</html>
