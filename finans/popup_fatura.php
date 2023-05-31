<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	//session_kontrol();
	
	$row 				= $cSubData->getCariHareket($_REQUEST);
	$rows_parca			= $cSubData->getCariHareketDetay($_REQUEST);
	$row_cari			= $cSubData->getCari(array("id"=>$row->CARI_ID));
	
	//fncKodKontrol($row);
	
	if($row_cari->PARA_BIRIM == 'USD'){
		$PARA_BIRIM = '<i class="fal fa-dollar-sign"></i>';
	} else if($row_cari->PARA_BIRIM == 'EUR'){
		$PARA_BIRIM = '<i class="fal fa-euro-sign"></i>';
	} else if($row_cari->PARA_BIRIM == 'GBP'){
		$PARA_BIRIM = '<i class="fal fa-pound-sign"></i>';
	} else {
		$PARA_BIRIM = '<i class="fal fa-lira-sign"></i>';
	}
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
    	
    </style>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
    
    <main id="js-page-content" role="main" class="page-content">
	 	
	 	<div class="container">
            <div data-size="A4">
                <div class="row">
                	<div class="col-sm-3">
                		<img src="/img/logo2.png" height="150">
                	</div>
                    <div class="col-sm-7">
                        <div class="d-flex align-items-center mb-5">
                            <h2 class="keep-print-font fw-500 mb-0 text-primary flex-1 position-relative">
                                <?=$row_site->FIRMA_ADI?>
                                <small class="text-muted mb-0 fs-xs">
                                   <?=$row_site->ADRES?><br>
                                   Tel: <?=$row_site->TEL1?> Gsm: <?=$row_site->TEL2?>
                                </small>
                            </h2>
                        </div>
                    </div>
                    <div id="qrcode" class="col-sm-2 mt-4 mb-1">
                    		
                    </div>
                    <div class="col-sm-12">
                    	<h3 class="fw-300 display-4 fw-500 color-primary-600 keep-print-font pt-3 l-h-n m-0 text-center">
                            <?=FormatYazi::buyult($row->HAREKET)?> <?=dil("SİPARİŞİ")?>
                            <a href="javascript:window.print()" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1" title=""> <i class="fal fa-print fs-xl"></i></a>
                            <a href="javascript:;" onclick="exportXLS()" title="Excel" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1"> <i class="far fa-table fs-lg"></i> </a>
                        </h3>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-8 d-flex">
                        <div class="table-responsive">
                            <table class="table table-clean table-sm align-self-end">
                                <tbody>
                                	<tr>
                                        <td class="fw-500"><?=dil("Sipariş Tarihi")?></td>
                                        <td><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-500"><?=dil("Sipariş No")?></td>
                                        <td><?=$row->FATURA_NO?></td>
                                    </tr>
                                	<tr>
                                        <td class="fw-500"><?=dil("Cari")?></td>
                                        <td nowrap><?=$row_cari->CARI?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-500"><?=dil("Adres")?></td>
                                        <td nowrap><?=$row_cari->ADRES?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-500"><?=dil("Ülke")?></td>
                                        <td nowrap><?=$row_cari->ULKE?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center border-top-0 table-scale-border-bottom fw-700">#</th>
                                        <th class="border-top-0 table-scale-border-bottom fw-700"><?=dil("Parça Kodu")?></th>
                                        <th class="border-top-0 table-scale-border-bottom fw-700"><?=dil("Oem Kodu")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("B.Fiyat")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("Adet")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("Fiyat")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("İskonto")?></th>
                                        <th class="text-right border-top-0 table-scale-border-bottom fw-700"><?=dil("Tutar")?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?
									foreach($rows_parca as $key => $row_parca){
										$row_toplam->ADET		+= $row_parca->ADET;
										$row_toplam->FIYAT		+= $row_parca->FIYAT * $row_parca->ADET;
										$row_toplam->ISKONTOLU	+= $row_parca->ISKONTOLU * $row_parca->ADET;
										$row_toplam->TUTAR		+= $row_parca->TUTAR;
										?>
										<tr>
	                                        <td class="text-center fw-700"><?=($key+1)?></td>
	                                        <td class="text-left"><?=$row_parca->PARCA_KODU?></td>
	                                        <td class="text-left"><?=$row_parca->OEM_KODU?></td>
	                                        <td class="text-right" nowrap><?=$PARA_BIRIM?> <?=fncCariParaBirimGoster($row_parca->FIYAT, $row_cari->PARA_BIRIM, $rows_doviz, 1)?> </td>
	                                        <td class="text-right" nowrap><?=FormatSayi::sayi($row_parca->ADET,2)?></td>
	                                        <td class="text-right" nowrap><?=$PARA_BIRIM?> <?=fncCariParaBirimGoster($row_parca->FIYAT * $row_parca->ADET, $row_cari->PARA_BIRIM, $rows_doviz, 1)?> </td>
	                                        <td class="text-right" nowrap><i class="fal fa-percent"></i> <?=fncCariParaBirimGoster($row_parca->ISKONTO, $row_cari->PARA_BIRIM, $rows_doviz, 1)?> </td>
	                                        <!--
	                                        <td class="text-right"><?=$PARA_BIRIM?> <?=FormatSayi::sayi($row_parca->FIYAT * $row_parca->ISKONTO / 100 * $row_parca->ADET,2)?></td>
	                                        -->
	                                        <td class="text-right" nowrap><?=$PARA_BIRIM?> <?=fncCariParaBirimGoster($row_parca->TUTAR, $row_cari->PARA_BIRIM, $rows_doviz, 1)?> </td>
	                                    </tr>
									<?}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-4">
                      
                    </div>
                    <div class="col-sm-4 ml-sm-auto">
                        <table class="table table-clean table-sm">
                            <tbody>
                                <tr>
                                    <td class="text-left">
                                        <strong><?=dil("Alt Toplam")?></strong>
                                    </td>
                                    <td class="text-right"><?=$PARA_BIRIM?> <?=fncCariParaBirimGoster($row_toplam->FIYAT, $row_cari->PARA_BIRIM, $rows_doviz, 1)?> </td>
                                </tr>
                                <tr>
                                    <td class="text-left">
                                        <strong><?=dil("İskonto")?> (% <?=FormatSayi::iskontoOran($row_toplam->FIYAT, $row_toplam->ISKONTOLU)?>) </strong>
                                    </td>
                                    <td class="text-right"><?=$PARA_BIRIM?> <?=fncCariParaBirimGoster($row_toplam->FIYAT - $row_toplam->ISKONTOLU, $row_cari->PARA_BIRIM, $rows_doviz, 1)?> </td>
                                </tr>
                                <tr class="table-scale-border-top border-left-0 border-right-0 border-bottom-0">
                                    <td class="text-left keep-print-font">
                                        <h4 class="m-0 fw-700 h2 keep-print-font color-primary-700"><?=dil("Toplam")?></h4>
                                    </td>
                                    <td class="text-right keep-print-font">
                                        <h4 class="m-0 fw-700 h2 keep-print-font"><?=$PARA_BIRIM?> <?=fncCariParaBirimGoster($row_toplam->TUTAR, $row_cari->PARA_BIRIM, $rows_doviz, 1)?> </h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p class="mt-2 text-muted mb-0">
                            <?=dil("Fatura Doğrulama Kod: ")?> <?=$row->ID?> - <?=$row->KOD?>
                        </p>
                    </div>
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
    <script src="../smartadmin/plugin/jquery-qrcode-master/jquery.qrcode.min.js"></script>
    <!-- https://github.com/rek72-zz/tableExport!-->
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/FileSaver/FileSaver.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.umd.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/pdfmake/pdfmake.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/pdfmake/vfs_fonts.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/html2canvas/html2canvas.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/tableExport.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    
		$("[data-mask]").inputmask();
		
		$('#qrcode').qrcode({width: 128,height: 128,text:"<?=$row_site->URL?>/finans/popup_fatura.do?route=finans/popup_fatura&id=<?=$row->ID?>&kod=<?=$row->KODU?>"});	
		
		function exportXLS(){
			$('table').tableExport({type:'excel'});
		}
		
	</script>
    
</body>
</html>
