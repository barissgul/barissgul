<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$_REQUEST['yil'] = $_REQUEST['yil'] ? $_REQUEST['yil'] : date("Y");
	$_REQUEST['ay']	 = $_REQUEST['ay'] ? $_REQUEST['ay'] : date("m");
	
	$rows_satis 		= $cSubData->getAylikSatis($_REQUEST);
	$rows_toplam_satis 	= $cSubData->getAylikSatisToplam($_REQUEST);
	
	$rows_alis 			= $cSubData->getAylikAlis($_REQUEST);
	$rows_toplam_alis 	= $cSubData->getAylikAlisToplam($_REQUEST);
	
	foreach($rows_toplam_satis as $key => $row_toplam_satis){
		$row_toplam->GELIR			+= $row_toplam_satis->TUTAR;
		$row_toplam->ODEME_TUTAR	+= $row_toplam_satis->ODEME_TUTAR;
	}
	
	foreach($rows_toplam_alis as $key => $row_toplam_alis){
		$row_toplam->GIDER	+= $row_toplam_alis->TUTAR;
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
	    	<div class="row hidden-print">
		    	<div class="col-6 offset-3">
			    	<div class="panel">
	                    <div class="panel-container show">
	                        <div class="panel-content">
								<form name="form" id="form" class="" enctype="multipart/form-data" method="GET">
									<input type="hidden" name="route" value="<?=$_REQUEST['route']?>">
									<input type="hidden" name="sayfa" id="sayfa">
									<input type="hidden" name="filtre" value="1">
									<div class="row">
										<div class="col-xl-5">
										    <div class="form-group">
											  	<label class="form-label"> <?=dil("Yıl")?> </label>
											  	<select name="yil" id="yil" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
											      	<?=$cCombo->Yil()->setSecilen($_REQUEST['yil'])->getSelect("ID","AD")?>
											    </select>
											</div>
										</div>
										<div class="col-xl-5">
										    <div class="form-group">
											  	<label class="form-label"><?=dil("Ay")?></label>
											  	<select name="ay" id="ay" class="form-control select2" style="width: 100%;">
											      	<?=$cCombo->Ay()->setSecilen($_REQUEST['ay'])->getSelect("ID","AD")?>
											    </select>
											</div>
										</div>
										<div class="col-xl-2">
											<div class="form-group">
											  	<label> &nbsp; </label><br>
										  		<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncFiltrele()"><?=dil("Filtrele")?></button>
										  	</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
			    </div>
		    </div>
		    
	    	<div class="row">
			    <div class="col-lg-6 col-md-6">
			    	<div class="panel">
	                    <div class="panel-hdr bg-primary-300 text-white">
	                        <h2> <?=dil("ALIŞ FATURALARI")?> </h2>
	                        <div class="panel-toolbar">
	                        	<a href="/finans/alis_fatura.do?route=finans/alis_faturalar" class="btn btn-icon btn-light mr-1" title="Alış Faturası Ekle"> <i class="far fa-plus"></i> </a>
	                           	<button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
								<div class="alert alert-info" role="alert">
							        <strong><?=dil("Toplam")?>:</strong> <?=FormatSayi::sayi($row_toplam->GIDER)?> TL
						        </div>
						        <div class="panel-tag">
						        	<?foreach($rows_toplam_alis as $key => $row_toplam_alis){?>
							        	<p style="font-size: 14px"> <?=$row_toplam_alis->FINANS_KALEMI?>: <?=FormatSayi::sayi($row_toplam_alis->TUTAR)?> TL </p>
							        <?}?>
						        </div>    
							  	<table class="table table-sm table-condensed table-hover fs-xs">
							  		<thead>
								  		<tr class="bg-primary-300">
											<td align="center"> <b><?=dil("No")?></b> </td>
											<td align="center"> <b><?=dil("Fatura No")?></b> </td>
											<td align="center"> <b><?=dil("Fatura Tarih")?></b> </td>
											<td align="center"> <b><?=dil("Talep No")?></b> </td>	
											<td> <b><?=dil("Plaka")?></b> </td>
											<td> <b><?=dil("F.Kalemi")?></b> </td>
											<td> <b><?=dil("Açıklama")?></b> </td>
											<td align="center"> <b><?=dil("Kayıt Tarih")?></b> </td>
											<td align="right"> <b><?=dil("Tutar")?></b> </td>
										</tr>
									</thead>
									<tbody>
								  		<?foreach($rows_alis as $key => $row_alis){?>
										<tr>
											<td align="center"> <a href="/finans/alis_fatura.do?route=finans/alis_faturalar&id=<?=$row_alis->ID?>&kod=<?=$row_alis->KOD?>" class="btn <?=($row_alis->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-sm p-1"> <?=$row_alis->ID?></a> </td>
											<td align="center"> <a href="<?=fncFaturaPopupLink($row_alis)?>"> <?=$row_alis->FATURA_NO?></a> </td>
											<td align="center"> <?=FormatTarih::tarih($row_alis->FATURA_TARIH)?> </td>
											<td align="center"> <?=$row_alis->TALEP_ID?> </td>
											<td> <?=$row_alis->PLAKA?> </td>
											<td> <?=$row_alis->FINANS_KALEMI?> </td>
											<td> <?=$row_alis->ACIKLAMA?> </td>
											<td align="center" nowrap> <?=FormatTarih::tarih($row_alis->TARIH)?> </td>
											<td align="right"> <?=FormatSayi::sayi($row_alis->TUTAR,2)?> </td>
										</tr>
										<?}?>
									</tbody>
							  	</table>
							</div>
						</div>
			    	</div>
		    	</div>
		    	<div class="col-lg-6 col-md-6">
		    		<div class="panel">
	                    <div class="panel-hdr bg-primary-300 text-white">
	                        <h2> <?=dil("SATIŞ FATURALARI")?> </h2>
	                        <div class="panel-toolbar">
	                            <a href="/finans/satis_fatura.do?route=finans/satis_faturalar" class="btn btn-icon btn-light mr-1" title="Satış Faturası Ekle"> <i class="far fa-plus"></i> </a>
	                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
	                        	<div class="alert alert-info" role="alert">
                                	<strong><?=dil("Toplam")?>:</strong> <?=FormatSayi::sayi($row_toplam->GELIR)?> TL
                                </div>
                                <div class="panel-tag">
						        	<?foreach($rows_toplam_satis as $key => $row_toplam_satis){?>
							        	<p style="font-size: 14px"> <?=$row_toplam_satis->FINANS_KALEMI?>: <?=FormatSayi::sayi($row_toplam_satis->TUTAR)?> TL </p>
							        <?}?>
						        </div>
							  	<table class="table table-sm table-condensed table-hover fs-xs">
							  		<thead>
								  		<tr class="bg-primary-300">
											<td align="center"> <b><?=dil("No")?></b> </td>
											<td align="center"> <b><?=dil("Fatura No")?></b> </td>
											<td align="center"> <b><?=dil("Fatura Tarih")?></b> </td>
											<td align="center"> <b><?=dil("Talep No")?></b> </td>
											<td> <b><?=dil("Plaka")?></b> </td>
											<td> <b><?=dil("F.Kalemi")?></b> </td>
											<td> <b><?=dil("Açıklama")?></b> </td>
											<td align="center"> <b><?=dil("Kayıt Tarih")?></b> </td>
											<td align="right"> <b><?=dil("Tutar")?></b> </td>
										</tr>
									</thead>
									<tbody>
								  		<?foreach($rows_satis as $key => $row_satis){?>
										<tr>
											<td align="center"> <a href="/finans/satis_fatura.do?route=finans/satis_faturalar&id=<?=$row_satis->ID?>&kod=<?=$row_satis->KOD?>" class="btn <?=($row_satis->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-sm p-1"> <?=$row_satis->ID?></a> </td>
											<td align="center"> <a href="<?=fncFaturaPopupLink($row_satis)?>"> <?=$row_satis->FATURA_NO?> </a> </td>
											<td align="center"> <?=FormatTarih::tarih($row_satis->FATURA_TARIH)?> </td>
											<td align="center"> <?=$row_satis->TALEP_ID?> </td>
											<td> <?=$row_satis->PLAKA?> </td>
											<td> <?=$row_satis->FINANS_KALEMI?> </td>
											<td> <?=FormatYazi::kisalt($row_satis->ACIKLAMA,20)?> </td>
											<td align="center"> <?=FormatTarih::tarih($row_satis->TARIH)?> </td>
											<td align="right"> <?=FormatSayi::sayi($row_satis->TUTAR)?> </td>
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
	
	</script>
    
</body>
</html>
