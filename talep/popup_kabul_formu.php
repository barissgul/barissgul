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
    
   
	 	<div class="container">
            <div data-size="A4">
                <div class="row">
                	<div class="col-sm-3">
                		<img id="logo" alt="<?=$row_site->LOGO?>" class="height-10" src="<?=$row_site->LOGO?>">
                	</div>
                    <div class="col-sm-6 text-center">
                        <div class="d-flex align-items-center mb-5 mt-3">
                            <h1 class="keep-print-font fw-900 mb-0 text-primary flex-1 position-relative">
                                <?=dil("ARAÇ KABUL FORMU")?>
                            </h1>
                        </div>
                    </div>
                    <div class="col-sm-3 text-center">
                		<h1 class="fw-500">
                		<?=FormatYazi::buyult($row_site->BASLIK)?><br>
                		<?=$row_site->ILCE?>
                		</h1>
                	</div>
                </div>
                <div class="row">
                    <div class="col-sm-7 mt-1">
                    	<div class="row">
	                    	<div class="col-sm-12">
		                        <table class="table align-self-end table-bordered">
		                            <tbody>
		                            	<tr>
		                                    <td style="width: 28%"><b><?=dil("Firma Ünvanı No")?></b></td>
		                                    <td><?=$row->CARI?></td>
		                                </tr>
		                            	<tr>
		                                    <td><b><?=dil("Kullanıcı Adı-Soyadı")?></b></td>
		                                    <td><?=$row->SURUCU_AD_SOYAD?></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("Kullanıcı Tel")?></b></td>
		                                    <td><?=$row->SURUCU_TEL?></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("Kullanıcı E-mail")?></b></td>
		                                    <td><?=$row->SURUCU_MAIL?></td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-sm-12">
		                        <table class="table align-self-end table-bordered">
		                            <tbody>
		                            	<tr>
		                                    <td colspan="2"><b><?=dil("Teslim Alınan Araç Bilgileri")?></b></td>
		                                </tr>
		                            	<tr>
		                                    <td style="width: 28%"><b><?=dil("Plaka")?></b></td>
		                                    <td><span class="fw-700 fs-xxl"><?=$row->PLAKA?></span></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("Marka")?></b></td>
		                                    <td><?=$row->MARKA?> - <?=$row->MODEL_YILI?></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("Model")?></b></td>
		                                    <td><?=$row->MODEL?></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("Renk")?></b></td>
		                                    <td><?=$row->RENK?></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("KM")?></b></td>
		                                    <td><?=$row->KM?></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("Yakıt")?></b></td>
		                                    <td><?=$row->YAKIT?></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("Tarih - Saat")?></b></td>
		                                    <td><?=FormatTarih::tarih($row->ARAC_GELIS_TARIH)?></td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-sm-12">
		                        <table class="table align-self-end table-bordered">
		                            <tbody>
		                            	<tr>
		                                    <td colspan="3"><b><?=dil("Mevcut Döküman ve Ekipmanları")?></b></td>
		                                </tr>
		                            	<tr>
		                                    <td><i class="fal fa-square p-0" style="font-size: 1.5em"> </i> <b> <?=dil("Ruhsat")?> </b> </td>
		                                    <td><i class="fal fa-square p-0" style="font-size: 1.5em"> </i> <b> <?=dil("Trafik Seti")?> </b></td>
		                                    <td><i class="fal fa-square p-0" style="font-size: 1.5em"> </i> <b> <?=dil("Yangın Tüpü")?> </b> </td>
		                                </tr>
		                                <tr>
		                                    <td><i class="fal fa-square p-0" style="font-size: 1.5em"> </i> <b> <?=dil("Stepne")?> </b> </td>
		                                    <td><i class="fal fa-square p-0" style="font-size: 1.5em"> </i> <b> <?=dil("Kriko")?> </b> </td>
		                                    <td><i class="fal fa-square p-0" style="font-size: 1.5em"> </i> <b> <?=dil("Paspas")?> </b> </td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-sm-12">
		                        <table class="table align-self-end table-bordered">
		                            <tbody>
		                            	<tr>
		                                    <td colspan="2"><b><?=dil("Araç Hasar Bilgileri")?></b></td>
		                                </tr>
		                                <tr>
		                                	<td colspan="2">
		                                		<img src="../img/kroki.png" style="height: 260px"/>
		                                	</td>
		                                </tr>
		                            	<tr>
		                                    <td><b><?=dil("Muadil sraç talebi yok")?></b></td>
		                                    <td><?=$row->IKAME_DURUM?></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("Kısa süreli işlem Muadil araç verilmeli")?></b> <small>[<?=dil("Teslim zamanı belirtiniz")?>]</small></td>
		                                    <td><?=$row->IKAME_DURUM?></td>
		                                </tr>
		                                <tr>
		                                    <td><b><?=dil("Parça sipariş cerildi, ulaşınca haber verilecek")?></b></td>
		                                    <td><?=$row->IKAME_DURUM?></td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
	                    </div>
                    </div>
                    <div class="col-sm-5 mt-1">
                    	<div class="row">
	                    	<div class="col-sm-12">
		                        <table class="table align-self-end table-bordered">
		                            <tbody>
		                            	<tr>
		                                    <td colspan="3"><b><?=dil("Araç Giriş Durumu")?></b></td>
		                                </tr>
		                            	<tr>
		                                    <td><i class="far fa-square p-0" style="font-size: 1.5em"> </i> <b> <?=dil("Çekici")?> </b> </td>
		                                    <td><i class="far fa-square p-0" style="font-size: 1.5em"> </i> <b> <?=dil("Sürücü")?> </b> </td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-sm-12">
		                        <div class="table-responsive">
		                            <table class="table align-self-end table-bordered">
		                                <tbody>
		                                    <tr>
		                                        <td colspan="2"><b><?=dil("Hasarlı Bölge")?></b></td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2">
		                                        	<br>
		                                        	<br>
		                                        	<br>
		                                        	<br>
		                                        	<br>
		                                        	<br>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2"><b><?=dil("Harici Hasarlar")?></b></td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2">
		                                        	<br>
		                                        	<br>
		                                        	<br>
		                                        	<br>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2"><b><?=dil("Özel Eşya Bulunmamaktadır")?></b></td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2">
		                                        	<h5 class="frame-heading"><?=dil("İmza")?></h5>
		                                        	<br>
		                                        	<br>
		                                        </td>
		                                    </tr>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-sm-12">
		                        <div class="table-responsive">
		                            <table class="table align-self-end table-bordered">
		                                <tbody>
		                                	<tr>
		                                        <td colspan="2"><b><?=dil("Teslimat Bilgileri (Müşteri)")?></b></td>
		                                    </tr>
		                                	<tr>
		                                        <td colspan="2">
		                                        	<h5 class="frame-heading"><?=dil("İsim ve Soyisim")?></h5>
		                                        	<br>
		                                        	<br>
		                                        	<h5 class="frame-heading"><?=dil("Tarih ve Saat")?></h5>
		                                        	<br>
		                                        	<br>
		                                        	<h5 class="frame-heading"><?=dil("İmza")?></h5>
		                                        	<br>
		                                        	<br>
		                                        	<br>
		                                        </td>
		                                    </tr>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-sm-12">
		                        <div class="table-responsive">
		                            <table class="table align-self-end table-bordered">
		                                <tbody>
		                                	<tr>
		                                        <td colspan="2"><b><?=dil("İkame Araç Bilgileri")?></b></td>
		                                    </tr>
		                                	<tr>
		                                        <td style="width: 32%"><b><?=dil("Plaka")?></b></td>
		                                        <td><?=$row_ikama->PLAKA?></td>
		                                    </tr>
		                                    <tr>
		                                        <td><b><?=dil("Marka")?></b></td>
		                                        <td><?=$row_ikama->MARKA?> - <?=$row_ikama->MODEL_YILI?></td>
		                                    </tr>
		                                    <tr>
		                                        <td><b><?=dil("Model")?></b></td>
		                                        <td><?=$row_ikama->MODEL?></td>
		                                    </tr>
		                                    <tr>
		                                        <td><b><?=dil("KM")?></b></td>
		                                        <td><?=$row_ikama->KM?></td>
		                                    </tr>
		                                    <tr>
		                                        <td><b><?=dil("Yakıt")?></b></td>
		                                        <td><?=$row_ikama->YAKIT?></td>
		                                    </tr>
		                                    <tr>
		                                        <td><b><?=dil("Çıkış Tarih")?></b></td>
		                                        <td><?=FormatTarih::tarih($row_ikame->TARIH)?></td>
		                                    </tr>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
	                    </div>
                    </div>
                    <div class="col-md-12">
                    	<div class="row mt-3">
		                    <div class="col-sm-4">
		                        <table class="table table-clean">
		                            <tbody>
		                                <tr class="table-scale-border-top border-left-0 border-right-0 border-bottom-0">
		                                    <td class="text-center keep-print-font bg-warning">
		                                        <h4 class="m-0 fw-700 h2 keep-print-font text-white"><?=dil("Teslim Alan")?></h4>
		                                    </td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
		                    <div class="col-sm-4">
		                        <table class="table table-clean">
		                            <tbody>
		                                <tr class="table-scale-border-top border-left-0 border-right-0 border-bottom-0">
		                                    <td class="text-center keep-print-font bg-warning">
		                                        <h4 class="m-0 fw-700 h2 keep-print-font text-white"><?=dil("Teslim Eden (Müşteri)")?></h4>
		                                    </td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
		                    <div class="col-sm-4">
		                        <table class="table table-clean">
		                            <tbody>
		                                <tr class="table-scale-border-top border-left-0 border-right-0 border-bottom-0">
		                                    <td class="text-center keep-print-font bg-warning">
		                                        <h4 class="m-0 fw-700 h2 keep-print-font text-white"><?=dil("Teslim Eden (Danışman)")?></h4>
		                                    </td>
		                                </tr>
		                            </tbody>
		                        </table>
		                    </div>
		                </div>
                    </div>
                </div>
               
            </div>
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
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/jquery-qrcode-master/jquery.qrcode.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    
    <script>
    
		//$('#qrcode').qrcode({width: 128,height: 128,text:"<?=$row->ID?> - <?=$row->PLAKA?>"});
		
	</script>
	
</body>
</html>
