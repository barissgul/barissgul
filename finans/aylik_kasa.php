<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$_REQUEST['yil'] = $_REQUEST['yil'] ? $_REQUEST['yil'] : date("Y");
	$_REQUEST['ay']	 = $_REQUEST['ay'] ? $_REQUEST['ay'] : date("m");
	
	$rows_tahsilat 			= $cSubData->getAylikTahsilat($_REQUEST);
	$rows_toplam_tahsilat 	= $cSubData->getAylikTahsilatToplam($_REQUEST);
	
	$rows_tediye			= $cSubData->getAylikTediye($_REQUEST);
	$rows_toplam_tediye		= $cSubData->getAylikTediyeToplam($_REQUEST);
	
	foreach($rows_toplam_tahsilat as $key => $row_toplam_tahsilat){
		$row_toplam->TAHSILAT	+= $row_toplam_tahsilat->TUTAR;
	}
	
	foreach($rows_toplam_tediye as $key => $row_toplam_tediye){
		$row_toplam->TEDIYE		+= $row_toplam_tediye->TUTAR;
	}
	
	$rows_kasa			= $cSubData->getKasalar($_REQUEST);
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
	    		<div class="col-lg-6 col-md-6 offset-3">
		    		<div class="panel">
	                    <div class="panel-hdr bg-warning-300 text-white">
	                        <h2> <?=dil("TOPLAM KASA")?> </h2>
	                        <div class="panel-toolbar">
	                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				       			<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
							  	<table class="table table-sm table-condensed table-hover">
							  		<thead class="thead-themed">
								  		<tr>
											<td align="left"> <b><?=dil("Ödeme Kanalı")?></b> </td>
											<td align="left"> <b><?=dil("Kasa")?></b> </td>
											<td align="right"> <b><?=dil("Tahsilat")?></b> </td>
											<td align="right"> <b><?=dil("Tediye")?></b> </td>
											<td align="right"> <b><?=dil("Bakiye")?></b> </td>
										</tr>
									</thead>
									<tbody>
								  		<?
								  		foreach($rows_kasa as $key => $row_kasa){
								  			$row_kasa_toplam->TAHSILAT 	+= $row_kasa->TAHSILAT;
								  			$row_kasa_toplam->TEDIYE 	+= $row_kasa->TEDIYE;
								  			$row_kasa_toplam->BAKIYE 	+= $row_kasa->BAKIYE;
								  			?>
											<tr>
												<td align="left"> <?=$row_kasa->ODEME_KANALI?> </td>
												<td align="left"> <?=$row_kasa->ODEME_KANALI_DETAY?> </td>
												<td align="right"> <a href="/finans/tahsilatlar.do?route=finans/tahsilatlar&filtre=1&odeme_kanali_id=<?=$row_kasa->ODEME_KANALI_ID?>&odeme_kanali_detay_id=<?=$row_kasa->ODEME_KANALI_DETAY_ID?>"> <?=FormatSayi::sayi($row_kasa->TAHSILAT)?> </a> </td>
												<td align="right"> <a href="/finans/tediyeler.do?route=finans/tediyeler&filtre=1&odeme_kanali_id=<?=$row_kasa->ODEME_KANALI_ID?>&odeme_kanali_detay_id=<?=$row_kasa->ODEME_KANALI_DETAY_ID?>"> <?=FormatSayi::sayi($row_kasa->TEDIYE)?> </a> </td>
												<td align="right"> <?=FormatSayi::sayi($row_kasa->BAKIYE)?> </td>
											</tr>
										<?}?>
									</tbody>
									<tfoot class="thead-themed">
										<tr>
											<td align="left"> </td>
											<td align="left"> </td>
											<td align="right"> <?=FormatSayi::sayi($row_kasa_toplam->TAHSILAT)?> </td>
											<td align="right"> <?=FormatSayi::sayi($row_kasa_toplam->TEDIYE)?> </td>
											<td align="right"> <?=FormatSayi::sayi($row_kasa_toplam->BAKIYE)?> </td>
										</tr>
									</tfoot>
							  	</table>
							</div>
						</div>
					</div>
			    </div>
			    <div class="w-100"></div>
			    <div class="col-6 offset-3 hidden-print">
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
			    <div class="w-100"></div>
		    	<div class="col-lg-6 col-md-6">
		    		<div class="panel">
	                    <div class="panel-hdr bg-primary-300 text-white">
	                        <h2> <?=dil("TAHSİLATLAR")?> </h2>
	                        <div class="panel-toolbar">
	                        	<a href="javascript:void(0)" onclick="fncPopup('/finans/tahsilat.do?route=finans/tahsilat','TAHSILAT_EKLE',780,730)" class="btn btn-icon btn-light mr-1" title="Gelir Ekle"> <i class="far fa-plus"></i> </a>
	                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				       			<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
	                        	<div class="alert alert-info" role="alert">
                                	<strong><?=dil("Toplam")?>:</strong> <?=FormatSayi::sayi($row_toplam->TAHSILAT)?> TL
                                </div>
                                <div class="panel-tag">
						        	<?foreach($rows_toplam_tahsilat as $key => $row_toplam_tahsilat){?>
							        	<p style="font-size: 14px"> <?=$row_toplam_tahsilat->ODEME_KANALI_DETAY?>: <?=FormatSayi::sayi($row_toplam_tahsilat->TUTAR)?> TL </p>
							        <?}?>
						        </div>
							  	<table class="table table-sm table-condensed table-hover fs-xs">
							  		<thead>
								  		<tr class="bg-primary-gradient">
											<td align="center"> <b><?=dil("No")?></b> </td>
											<td> <b><?=dil("Cari")?></b> </td>
											<td> <b><?=dil("Plaka")?></b> </td>
											<td align="center"> <b><?=dil("Tarih")?></b> </td>
											<td> <b><?=dil("Ö.Kanalı")?></b> </td>
											<td> <b><?=dil("Açıklama")?></b> </td>
											<td align="center"> <b><?=dil("Kayıt Tarih")?></b> </td>
											<td align="right"> <b><?=dil("Tutar")?></b> </td>
										</tr>
									</thead>
									<tbody>
								  		<?foreach($rows_tahsilat as $key => $row_tahsilat){?>
										<tr>
											<td align="center"> <a href="javascript:fncPopup('/finans/tahsilat.do?route=finans/tahsilat&id=<?=$row_tahsilat->ID?>&kod=<?=$row_tahsilat->KOD?>','TAHSILAT',780,720 )" class="btn <?=($row_tahsilat->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-sm p-1"> <?=$row_tahsilat->ID?></a> </td>
											<td> <?=FormatYazi::kisalt($row_tahsilat->CARI,15)?> </td>
											<td> <?=$row_tahsilat->PLAKA?> </td>
											<td align="center"> <?=FormatTarih::tarih($row_tahsilat->FATURA_TARIH)?> </td>
											<td> <a href="<?=fncOdemePopupLink($row_tahsilat)?>"> <?=$row_tahsilat->ODEME_KANALI_DETAY?> </a> </td>
											<td> <?=FormatYazi::kisalt($row_tahsilat->ACIKLAMA,20)?> </td>
											<td align="center"> <?=FormatTarih::tarih($row_tahsilat->TARIH)?> </td>
											<td align="right"> <?=FormatSayi::sayi($row_tahsilat->TUTAR)?> </td>
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
	                        <h2> <?=dil("TEDİYELER")?> </h2>
	                        <div class="panel-toolbar">
	                        	<a href="javascript:void(0)" onclick="fncPopup('/finans/tediye.do?route=finans/tediyeler','TEDIYE_EKLE',780,730)" class="btn btn-icon btn-light mr-1" title="Gider Ekle"> <i class="far fa-plus"></i> </a>
	                           	<button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
								<div class="alert alert-info" role="alert">
							        <strong><?=dil("Toplam")?>:</strong> <?=FormatSayi::sayi($row_toplam->TEDIYE)?> <i class="fal fa-lira-sign"></i>
						        </div>
						        <div class="panel-tag">
						        	<?foreach($rows_toplam_tediye as $key => $row_toplam_tediye){?>
							        	<p style="font-size: 14px"> <?=$row_toplam_tediye->ODEME_KANALI_DETAY?>: <?=FormatSayi::sayi($row_toplam_tediye->TUTAR)?> <i class="fal fa-lira-sign"></i> </p>
							        <?}?>
						        </div>    
							  	<table class="table table-sm table-condensed table-hover fs-xs">
							  		<thead>
								  		<tr class="bg-primary-gradient">								  			
											<td align="center"> <b><?=dil("No")?></b> </td>
											<td> <b><?=dil("Cari")?></b> </td>
											<td> <b><?=dil("Plaka")?></b> </td>
											<td align="center"> <b><?=dil("Tarih")?></b> </td>
											<td> <b><?=dil("Ö.Kanalı")?></b> </td>
											<td> <b><?=dil("Açıklama")?></b> </td>
											<td align="center"> <b><?=dil("Kayıt Tarih")?></b> </td>
											<td align="right"> <b><?=dil("Tutar")?></b> </td>
										</tr>
									</thead>
									<tbody>
								  		<?foreach($rows_tediye as $key => $row_tediye){?>
										<tr>
											<td align="center"> <a href="javascript:fncPopup('/finans/tediye.do?route=finans/tediye&id=<?=$row_tediye->ID?>&kod=<?=$row_tediye->KOD?>','TEDIYE',780,720 )" class="btn <?=($row_tediye->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-sm p-1"> <?=$row_tediye->ID?></a> </td>
											<td> <?=FormatYazi::kisalt($row_tediye->CARI,15)?> </td>
											<td> <?=$row_tediye->PLAKA?> </td>
											<td align="center"> <?=FormatTarih::tarih($row_tediye->FATURA_TARIH)?> </td>
											<td> <a href="<?=fncOdemePopupLink($row_tediye)?>"> <?=$row_tediye->ODEME_KANALI_DETAY?> </a> </td>
											<td> <?=$row_tediye->ACIKLAMA?> </td>
											<td align="center" nowrap> <?=FormatTarih::tarih($row_tediye->TARIH)?> </td>
											<td align="right"> <?=FormatSayi::sayi($row_tediye->TUTAR,2)?> </td>
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
    
    </script>
    
</body>
</html>