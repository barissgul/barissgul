<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$_REQUEST['yil'] = $_REQUEST['yil'] ? $_REQUEST['yil'] : date("Y");
	$_REQUEST['ay']	 = $_REQUEST['ay'] ? $_REQUEST['ay'] : date("m");
	
	$rows_fatura 			= $cSubData->getAylikPrim($_REQUEST);
	$rows_fatura_serdar		= $cSubData->getAylikPrimSerdar($_REQUEST);
	
	foreach($rows_fatura as $key => $row_fatura){
		$row_toplam->TAHSILAT_PASHA	+= $row_fatura->TUTAR;
	}
	
	foreach($rows_fatura_serdar as $key => $row_fatura){
		$row_toplam->TAHSILAT_SERDAR	+= $row_fatura->TUTAR;
	}
	
	$row_toplam->TAHSILAT	= $row_toplam->TAHSILAT_PASHA + $row_toplam->TAHSILAT_SERDAR;
	
	$rows_personel 			= $cSubData->getPersoneller($_REQUEST);
	$rows_personel_ceza		= $cSubData->getAylikPersonelCezalar($_REQUEST);
	
	foreach($rows_personel_ceza as $key => $row_fatura){
		$row_toplam->CEZA_TUTAR	+= $row_fatura->TUTAR;
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
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
		    	<div class="col-lg-6 col-md-6 offset-3">
		    		<div class="panel">
	                    <div class="panel-hdr bg-primary-300 text-white">
	                        <h2> <?=dil("PERSONEL PRİM")?> </h2>
	                        <div class="panel-toolbar">
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
							  	<table class="table table-sm table-condensed table-hover">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center">#</td>
								          	<td align="center"><?=dil("Cari KOD")?></td>
								          	<td><?=dil("TCK")?></td>
								          	<td><?=dil("Personel")?></td>
								          	<td><?=dil("Departman")?></td>
								          	<td><?=dil("Görev")?></td>
								          	<td align="right"><?=dil("Prim")?></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?
								        foreach($rows_personel as $key=>$row) {
								        	$row->PRIM = ($row_toplam->TAHSILAT - $row_toplam->CEZA_TUTAR) * $row->PRIM_ORAN / 100;
								        	if($row->PRIM < 0) $row->PRIM = 0;
								        	?>
									        <tr>
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td align="center"> <a href="javascript:fncPopup('/finans/ekstre.do?route=finans/ekstre&kod=<?=$row->KOD?>&filtre=1&finans_kalemi_id=<?=$_REQUEST["finans_kalemi_id"]?>&talep_no=<?=$_REQUEST["talep_no"]?>','EKSTRE',1000,800);" title="Ektre"> <?=$row->CARI_KOD?> </a> </td>
									          	<td><?=$row->TCK?></td>
									          	<td><?=$row->CARI?></td>
									          	<td><?=$row->DEPARTMAN?></td>
									          	<td><?=$row->GOREV?></td>
									          	<td align="right"><?=FormatSayi::sayi($row->PRIM)?></td>
									        </tr>
								        <?}?>
							        </tbody>
							  	</table>
							</div>
						</div>
					</div>
			    </div>
			    <div class="col-lg-6 col-md-6 offset-3">
		    		<div class="panel">
	                    <div class="panel-hdr bg-primary-300 text-white">
	                        <h2> <?=dil("PRİM CEZA")?> </h2>
	                        <div class="panel-toolbar">
	                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				       			<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
	                        	<div class="alert alert-info" role="alert">
                                	<strong><?=dil("Toplam")?>:</strong> <?=FormatSayi::sayi($row_toplam->CEZA_TUTAR)?> TL
                                </div>
							  	<table class="table table-sm table-condensed table-hover">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center" width="3%">#</td>
								          	<td align="center" width="55%"><?=dil("Açıklama")?></td>
								          	<td align="right" width="20%"><?=dil("Ceza Tutar")?></td>
								          	<td align="center" width="15%"><?=dil("Tarih")?></td>
								          	<td width="8%"></td>
								          	<td></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?
								        foreach($rows_personel_ceza as $key=>$row) {
								        	?>
									        <tr>
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td><?=$row->ACIKLAMA?></td>
									          	<td align="right"><?=FormatSayi::sayi($row->TUTAR)?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->TARIH)?></td>
									          	<td></td>
									          	<td>
									          		<button type="button" class="btn btn-danger waves-effect waves-themed" onclick="fncCezaSil(this)" data-id="<?=$row->ID?>"><?=dil("Sil")?></button>
									          	</td>
									        </tr>
								        <?}?>
							        </tbody>
							        <tfoot>
							        	<tr>
							        		<td></td>
							        		<td>
							        			<input type="text" class="form-control" placeholder="" name="aciklama" id="aciklama" maxlength="100" value="">
							        		</td>
							        		<td>
							        			<input type="text" class="form-control" placeholder="" name="tutar" id="tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 0" data-mask style="text-align: right;" value="" maxlength="10">
							        		</td>
							        		<td colspan="3">
							        			<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncCezaEkle(this)"><?=dil("Ekle")?></button>
							        		</td>
							        	</tr>
							        </tfoot>
							  	</table>
							</div>
						</div>
					</div>
			    </div>
			    <div class="col-lg-6 col-md-6">
		    		<div class="panel">
	                    <div class="panel-hdr bg-primary-300 text-white">
	                        <h2> <?=dil("Talep Listesi Pasha")?> </h2>
	                        <div class="panel-toolbar">
	                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				       			<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
	                        	<div class="alert alert-info" role="alert">
                                	<strong><?=dil("Toplam")?>:</strong> <?=FormatSayi::sayi($row_toplam->TAHSILAT_PASHA)?> TL
                                </div>
							  	<table class="table table-sm table-condensed table-hover">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center">#</td>
								          	<td><?=dil("Talep No")?></td>
								          	<td><?=dil("Fatura No")?></td>
								          	<td><?=dil("Fatura Tarih")?></td>
								          	<td><?=dil("İşçilik Tutar")?></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?
								        foreach($rows_fatura as $key=>$row) {
								        	?>
									        <tr>
									          	
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td><?=$row->TALEP_ID?></td>
									          	<td><?=$row->FATURA_NO?></td>
									          	<td><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
									          	<td><?=FormatSayi::sayi($row->TUTAR)?></td>
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
	                        <h2> <?=dil("Talep Listesi Serdar")?> </h2>
	                        <div class="panel-toolbar">
	                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				       			<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
	                        	<div class="alert alert-info" role="alert">
                                	<strong><?=dil("Toplam")?>:</strong> <?=FormatSayi::sayi($row_toplam->TAHSILAT_SERDAR)?> TL
                                </div>
							  	<table class="table table-sm table-condensed table-hover">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center">#</td>
								          	<td><?=dil("Talep No")?></td>
								          	<td><?=dil("Fatura No")?></td>
								          	<td><?=dil("Fatura Tarih")?></td>
								          	<td><?=dil("İşçilik Tutar")?></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?
								        foreach($rows_fatura_serdar as $key=>$row) {
								        	?>
									        <tr>
									          	
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td><?=$row->TALEP_ID?></td>
									          	<td><?=$row->FATURA_NO?></td>
									          	<td><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
									          	<td><?=FormatSayi::sayi($row->TUTAR)?></td>
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
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
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
    	$("[data-mask]").inputmask();
    	
    	function fncCezaEkle(obj){
			bootbox.confirm("Eklemek istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "personel_ceza_ekle", 'yil': "<?=$_REQUEST['yil']?>", 'ay': "<?=$_REQUEST['ay']?>", 'aciklama' : $("#aciklama").val(), 'tutar' : $("#tutar").val() },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
							}else{
								toastr.success(jd.ACIKLAMA);
								location.reload(true);
							}
							$(obj).removeAttr("disabled");
						}
					});
				}
			});
		}
		
		function fncCezaSil(obj){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "personel_ceza_sil", 'id': $(obj).data("id") },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
							}else{
								toastr.success(jd.ACIKLAMA);
								location.reload(true);
							}
							$(obj).removeAttr("disabled");
						}
					});
				}
			});
		}
		
    </script>
    
</body>
</html>