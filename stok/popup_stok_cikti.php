<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row			= $cSubData->getRafSira($_REQUEST);
	
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
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
    
    <main id="js-page-content" role="main" class="page-content">
	 	
	 	<div class="container">
            <div data-size="A4">
                <div class="row">
                	<div class="col-sm-4">
                		<img id="logo" alt="<?=$row_site->LOGO?>" class="height-10" src="<?=$row_site->LOGO?>">
                	</div>
                    <div class="col-sm-8">
                        <div class="d-flex align-items-center mb-5">
                            <h2 class="keep-print-font fw-500 mb-0 text-primary flex-1 position-relative">
                               	<?=$row_site->FIRMA_ADI?>
                                <small class="text-muted mb-0 fs-xs">
                                	<?=$row_site->ADRES?> <br>
                                	<?=dil("Tel")?>: <?=$row_site->TEL1?> <?=dil("Gsm")?>: <?=$row_site->TEL2?> <br>
                                	<?=$row_site->MAIL?>
                                </small>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-12 text-center">
                		<a href="javascript:window.print()" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1" title=""> <i class="fal fa-print fs-xl"></i></a>
                	</div>
                </div>
                <div class="row">
                	<div class="col-sm-12 mt-2">
                		<h3 class="fw-700 text-white keep-print-font p-4 l-h-n m-0 bg-warning text-center">
                            <?=dil("İŞ EMRİ")?>
                        </h3>
                	</div>
                    <div class="col-sm-8 mt-2">
	                    <div class="table-responsive">
	                        <table class="table table-clean table-sm align-self-end">
	                            <tbody>
	                            	<tr>
	                                    <td><b><?=dil("Kayıt No")?></b></td>
	                                    <td><?=$row->ID?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Plaka")?></b></td>
	                                    <td><?=$row->PLAKA?></td>
	                                </tr>
	                            	<tr>
	                                    <td><b><?=dil("Cari")?></b></td>
	                                    <td><?=$row->CARI?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Sürücü")?></b></td>
	                                    <td><?=$row->SURUCU?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Başlama Tarihi")?></b></td>
	                                    <td><?=FormatTarih::tarih($row->BAS_TARIH)?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Bitiş Tarihi")?></b></td>
	                                    <td><?=FormatTarih::tarih($row->BIT_TARIH)?></td>
	                                </tr>
	                            </tbody>
	                        </table>
	                    </div>                      
                    </div>
                    <div class="col-sm-4 text-center">
                    	<div id="qrcode" class="mt-4 mb-1">
                    		
                    	</div>
                    	<span class="fa-3x fw-500"> <?=$row->SIRA_KOD?></span><br>                    	
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table mt-1">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="border-top-0 table-scale-border-bottom fw-700"><?=dil("Lastik Bilgileri")?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<tr>
	                                    <td><b><?=dil("Lastik Sayısı")?></b></td>
	                                    <td><?=$row->LASTIK_SAYISI?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Lastik Markası")?></b></td>
	                                    <td><?=$row->ANA_MARKA?> - <?=$row->LASTIK_MARKA?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Lastik Ön Sağ Derinlik")?></b></td>
	                                    <td><?=$row->ON_SAG_DERINLIK?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Lastik Ön Sol Derinlik")?></b></td>
	                                    <td><?=$row->ON_SOL_DERINLIK?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Lastik Arka Sağ Derinlik")?></b></td>
	                                    <td><?=$row->ARKA_SAG_DERINLIK?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Lastik Arka Sol Derinlik")?></b></td>
	                                    <td><?=$row->ARKA_SOL_DERINLIK?></td>
	                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <p class="mt-6 text-muted mb-0">
                            <?=dil("Depolama emrini imzalamakla, müşteri genel depolama şartlarını peşinen kabul etmiş sayılır. İş bu form kayıtlı olan lastikleri depolama işlemlerini yapınız.")?>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table table-clean">
                            <tbody>
                                <tr class="table-scale-border-top border-left-0 border-right-0 border-bottom-0">
                                    <td class="text-center keep-print-font bg-warning">
                                        <h4 class="m-0 fw-700 h2 keep-print-font text-white"><?=dil("Servis Danışmanı")?></h4>
                                    </td>
                                </tr>
                                <tr>
                                	<td align="center"><h3><?=$row->SORUMLU?></h3></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                     <div class="col-sm-6">
                        <table class="table table-clean">
                            <tbody>
                                <tr class="table-scale-border-top border-left-0 border-right-0 border-bottom-0">
                                    <td class="text-center keep-print-font bg-warning">
                                        <h4 class="m-0 fw-700 h2 keep-print-font text-white"><?=dil("Müşteri Onayı")?></h4>
                                    </td>
                                </tr>
                                <tr>
                                	<td align="center"><h3><?=$row->SURUCU?></h3></td>
                                </tr>
                            </tbody>
                        </table>
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
    <script src="../smartadmin/plugin/1.js"></script>
    
    <script>
    
		$('#qrcode').qrcode({width: 128,height: 128,text:"<?=$row->SIRA_KOD?>"});
		
	</script>
	
</body>
</html>
