<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row 				= $cSubData->getTalep($_REQUEST);
	$rows_kontrol		= $cSubData->getTalepKontroller($_REQUEST);	
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
                                   <?=$row_site->ADRES?><br>
                                   Tel: <?=$row_site->TEL1?> Gsm: <?=$row_site->TEL2?>
                                </small>
                            </h2>
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-12 mt-1">
                		<h3 class="fw-700 text-white keep-print-font p-4 l-h-n m-0 bg-warning text-center">
                            <?=dil("Talep Kontrol")?> - <?=$row->PLAKA?> - <?=$row->ID?>
                        </h3>
                	</div>
                    <div class="col-sm-12 mt-4">
	                    <div class="table-responsive">
	                        <table class="table table-sm table-condensed table-hover">
								<thead class="thead-themed fw-500">
							    	<tr>
							          	<td align="center">#</td>
							          	<td><?=dil("Kontrol Adı")?></td>
							          	<td align="center"><?=dil("İşlem Sonrası")?></td>
							          	<td align="center" width="100px"><?=dil("Son Kontrol")?></td>
							        </tr>
							    </thead>
							    <tbody>
							        <?foreach($rows_kontrol as $key => $row_kontrol){?>
								        <tr>
								          	<td align="center" class="bg-gray-100"><?=($key+1)?></td>
								          	<td>
								          		<?=$row_kontrol->KONTROL?>
								          	</td>
								          	<td align="center">
								          		<?=$row_kontrol->ISLEM_SONRASI?>
								          	</td>
								          	<td align="center">
												<?=($row_kontrol->DURUM == 1 ? 'Çözüldü' : '')?>
								          	</td>
								        </tr>
							        <?}?>
							    </tbody>
							</table>
							<table class="table table-sm table-condensed table-hover">
								<thead class="thead-themed fw-500">
							    	<tr>
							          	<td align="center">#</td>
							          	<td><?=dil("Şikayet")?></td>
							          	<td align="center"><?=dil("Çözüm")?></td>
							          	<td align="center" width="100px"><?=dil("Durum")?></td>
							        </tr>
							    </thead>
							    <tbody>
							        <?foreach($rows_sikayet as $key => $row_sikayet){?>
								        <tr>
								          	<td align="center" class="bg-gray-100"><?=($key+1)?></td>
								          	<td>
								          		<?=$row_sikayet->SIKAYET?>
								          	</td>
								          	<td align="center">
								          		<?=$row_sikayet->COZUM?>
								          	</td>
								          	<td align="center">
												<?=($row_sikayet->DURUM == 1 ? 'Çözüldü' : '')?>
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
