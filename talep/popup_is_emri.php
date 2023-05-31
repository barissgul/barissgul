<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row 				= $cSubData->getTalep($_REQUEST);
	$rows_parca			= $cSubData->getTalepParcalar($_REQUEST);
	$rows_sikayet		= $cSubData->getTalepSikayetler($_REQUEST);
	
	
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
                	
                	<div class="col-sm-12 mt-2">
                		<h3 class="fw-700 text-white keep-print-font p-4 l-h-n m-0 bg-warning text-center border">
                            <?=dil("İŞ EMRİ")?>
                            <a href="javascript:window.print()" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1" title=""> <i class="fal fa-print fs-xl"></i></a>
                        </h3>
                	</div>
                    <div class="col-sm-8 mt-2">
	                    <div class="table-responsive">
	                        <table class="table table-clean table-sm align-self-end">
	                            <tbody>
	                            	<tr>
	                                    <td><b><?=dil("Servis No")?></b></td>
	                                    <td><?=$row->ID?></td>
	                                </tr>
	                            	<tr>
	                                    <td><b><?=dil("Müşteri")?></b></td>
	                                    <td><?=$row->CARI?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Plaka")?></b></td>
	                                    <td><?=$row->PLAKA?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Şasi No")?></b></td>
	                                    <td><?=$row->SASI_NO?></td>
	                                </tr>
	                                 <tr>
	                                    <td><b><?=dil("KM")?></b></td>
	                                    <td><?=FormatSayi::sayi($row->KM,0)?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Dosya No")?></b></td>
	                                    <td><?=$row->DOSYA_NO?> - <?=$row->SIGORTA_SEKLI?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Talep Tarihi")?></b></td>
	                                    <td><?=FormatTarih::tarih($row->TARIH)?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Araç Geliş Tarihi")?></b></td>
	                                    <td><?=FormatTarih::tarih($row->ARAC_GELIS_TARIH)?> <?=FormatTarih::sayi2saat($row->ARAC_GELIS_SAAT)?></td>
	                                </tr>
	                                <tr>
	                                    <td><b><?=dil("Tahmini Teslim Tarihi")?></b></td>
	                                    <td><?=FormatTarih::tarih($row->TAHMINI_TESLIM_TARIH)?> <?=FormatTarih::sayi2saat($row->TAHMINI_TESLIM_SAAT)?></td>
	                                </tr>
	                                
	                            </tbody>
	                        </table>
	                    </div>                      
                    </div>
                    <div class="col-sm-4 text-center">
                    	<div id="qrcode" class="mt-4 mb-1">
                    		
                    	</div>
                    	<span class="fa-3x fw-500"> <?=$row->PLAKA?></span><br>
                    	<span> <?=$row->MARKA?></span> - <span> <?=$row->MODEL_YILI?></span><br>
                    	<span> <?=$row->MODEL?></span>
                    	
                    </div>
                    <div class="col-sm-12">
                    	<div class="table-responsive ">
	                        <table class="table table-clean table-sm w-100 align-self-end">
	                            <tbody>
	                            	<tr>
	                                    <td width="20%"><b><?=dil("Sürücü")?></b></td>
	                                    <td width="30%"><?=$row->SURUCU_AD_SOYAD?></td>
	                                    <td width="20%"><b><?=dil("Sürücü Tel")?></b></td>
	                                    <td width="30%"><?=$row->SURUCU_TEL?></td>
	                                </tr>
	                            	<tr>
	                                    <td width="20%"><b><?=dil("Sigorta Firması")?></b></td>
	                                    <td width="30%"><?=$row->SIGORTA_FIRMASI?></td>
	                                    <td width="20%"><b><?=dil("Sigorta Şekli")?></b></td>
	                                    <td width="30%"><?=$row->SIGORTA_SEKLI?></td>
	                                </tr>
	                            	<tr>
	                                    <td><b><?=dil("Eksper")?></b></td>
	                                    <td><?=$row->EKSPER?></td>
	                                    <td><b><?=dil("Eksper Tel")?> / <?=dil("Mail")?></b></td>
	                                    <td><?=$row->EKSPER_TEL?> / <?=$row->EKSPER_MAIL?></td>
	                                </tr>
	                            </tbody>
	                        </table>
	                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table mt-1">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="border-top-0 table-scale-border-bottom fw-700"><?=dil("Müşteri Talepleri")?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?foreach($rows_sikayet as $key => $row_sikayet){?>
										<tr>
	                                        <td class="text-center fw-700"><?=($key+1)?></td>
	                                        <td class="text-left"><?=$row_sikayet->SIKAYET?></td>
	                                        <td class="text-left p-0"><i class="fal fa-square fa-2x"></i></td>
	                                    </tr>
									<?}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table mt-5">
                                <thead>
                                    <tr>
                                        <th class="border-top-0 table-scale-border-bottom fw-700"><?=dil("Tahmini Fatura Bedeli")?></th>
                                    </tr>
                                </thead>
                                <tbody>
									<tr>
	                                    <td class="text-center fw-700"> </td>
	                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <p class="mt-6 text-muted mb-0">
                            <?=dil("Onarım emrini imzalamakla, müşteri genel onarım şartlarını peşinen kabul etmiş sayılır. İş bu form eklerde kayıtlı olan onarımlarla ilgili gereken bütün işlemleri yapınız.")?>
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
                                	<td align="center"><h3><?=$row->SURUCU_AD_SOYAD?></h3></td>
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
    
		$('#qrcode').qrcode({width: 128,height: 128,text:"<?=$row_site->URL?>/talep/talep.do?route=talep/talep_listesi&id=<?=$row->ID?>&kod=<?=$row->KODU?>&tab=tab_talep_notu"});
		
	</script>
	
</body>
</html>
