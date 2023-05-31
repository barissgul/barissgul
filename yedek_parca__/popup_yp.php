<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row = $cSubData->getYedekParca($_REQUEST);
	
	if(is_null($row->ID)){
		
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
   
    <main id="js-page-content" role="main" class="page-content">
    	
        <section class="content">
        	<div class="panel">
				<div class="panel-hdr bg-primary-300">
                    <h2> <i class="fal fa-cog mr-3"></i> <?=dil("Yedek Parça")?> - <?=$row->UUID?> </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
						<form name="formTahsilatEkle" id="formYedekParca" class="" enctype="multipart/form-data" method="POST">
						<input type="hidden" name="islem" value="yedek_parca_kaydet">
						<input type="hidden" name="uuid" value="<?=$row->UUID?>">
						
						<div class="row">
							<div class="col-md-3 col-xs-3 mb-2">       
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Parca Tipi")?> </label>
							      	<select name="parca_tipi_id" id="parca_tipi_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
								      	<?=$cCombo->ParcaTipi()->setSecilen($row->PARCA_TIPI_ID)->setSeciniz()->getSelect("ID","AD")?>
								    </select>
							    </div>
							</div>
							<div class="col-md-3 col-xs-3 mb-2 senet0">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("OEM Kodu")?> </label>
							      	<input type="text" class="form-control" placeholder="" name="oem_kodu" id="oem_kodu" value="<?=$row->OEM_KODU?>" maxlength="25">
							    </div>
							</div>
							<div class="col-md-3 col-xs-3 mb-2 senet0">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Parça Kodu")?> </label>
							      	<input type="text" class="form-control" placeholder="" name="parca_kodu" id="parca_kodu" value="<?=$row->PARCA_KODU?>" maxlength="25">
							    </div>
							</div>
							<div class="col-md-3 col-xs-3 mb-2 senet0">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Referans Kodu")?> </label>
							      	<input type="text" class="form-control" placeholder="" name="referans_kodu" id="referans_kodu" value="<?=$row->REFERANS_KODU?>" maxlength="25">
							    </div>
							</div>
							<div class="col-md-6 col-xs-6 mb-2 senet0">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Parça Adı")?> </label>
							      	<input type="text" class="form-control" placeholder="" name="parca_adi" id="parca_adi" value="<?=$row->PARCA_ADI?>" maxlength="255">
							    </div>
							</div>
							<div class="col-md-6 col-xs-6 mb-2">       
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Marka")?> </label>
							      	<select name="marka_id" id="marka_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
								      	<?=$cCombo->Markalar()->setSecilen($row->MARKA_ID)->setSeciniz()->getSelect("ID","AD")?>
								    </select>
							    </div>
							</div>
							<div class="col-md-3 col-xs-3 mb-2">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Adet")?> </label>
							      	<div class="input-group">
							      		<input type="text" class="form-control" placeholder="" name="adet" id="adet" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 0" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->ADET,0)?>" maxlength="10">
							      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-tachometer"></i></span></div>
							      	</div>
							    </div>
							</div>
							<div class="col-md-3 col-xs-3 mb-2 senet0">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Parça Marka")?> </label>
							      	<input type="text" class="form-control" placeholder="" name="parca_marka" id="parca_marka" value="<?=$row->PARCA_MARKA?>" maxlength="45">
							    </div>
							</div>
							<div class="col-md-3 col-xs-3 mb-2">
								<div class="form-group">
							        <label class="form-label"><?=dil("Başlangıç Tarihi")?></label>
							        <div class="input-group date">
							          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300"><i class="far fa-calendar-alt"></i></span></div>
							          	<input type="text" class="form-control datepicker datepicker-inline" name="basla_tarih" id="basla_tarih" value="<?=FormatTarih::tarih($row->BASLA_TARIH)?>" readonly>
							        </div>
							    </div>
							</div>
							<div class="col-md-3 mb-2">
								<div class="form-group">
							        <label class="form-label"><?=dil("Bitiş Tarihi")?></label>
							        <div class="input-group date">
							          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300"><i class="far fa-calendar-alt"></i></span></div>
							          	<input type="text" class="form-control datepicker datepicker-inline" name="bitis_tarih" id="bitis_tarih" value="<?=FormatTarih::tarih($row->BITIS_TARIH)?>" readonly>
							        </div>
							    </div>
							</div>
							<div class="col-md-9 col-xs-9 mb-2">   
							    <div class="form-group">
								  	<label class="form-label"> <?=dil("Tedarikçi")?> </label>
								  	<select name="tedarikci_id" id="tedarikci_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
								      	<?=$cCombo->Cariler()->setSecilen($row->TEDARIKCI_ID)->setTumu()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
							<div class="col-md-3 col-xs-3 mb-2">   
							    <div class="form-group">
								  	<label class="form-label"> <?=dil("Ülkeler")?> </label>
								  	<select name="ulke_id" id="ulke_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
								      	<?=$cCombo->Ulkeler()->setSecilen($row->ULKE_ID)->setTumu()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
							<div class="col-md-3 col-xs-3 mb-2">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Fiyat")?> </label>
							      	<div class="input-group">
							      		<input type="text" class="form-control" placeholder="" name="alis_fiyat" id="alis_fiyat" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->ALIS_FIYAT,2)?>" maxlength="12">
							      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-tachometer"></i></span></div>
							      	</div>
							    </div>
							</div>
							<div class="col-md-3 col-xs-3 mb-2">   
							    <div class="form-group">
								  	<label class="form-label"> <?=dil("Para Birim")?> </label>
								  	<select name="para_birim" id="para_birim" class="form-control select2 select2-hidden-accessible" style="width: 100%">
								      	<?=$cCombo->ParaBirim()->setSecilen($row->PARA_BIRIM)->setTumu()->getSelect("ID","AD")?>
								    </select>
								</div>
							</div>
							<div class="col-md-2 col-xs-2 mb-2 senet0">
							    <div class="form-group">
							      	<label class="form-label"> <?=dil("Birim")?> </label>
							      	<input type="text" class="form-control" placeholder="" name="birim" id="birim" value="<?=$row->BIRIM?>" maxlength="5">
							    </div>
							</div>
							<div class="col-md-2 col-xs-2 mb-2 senet0">
								<div class="frame-heading mb-0"><?=dil("Stok Durum")?></div>
								<div class="form-check form-check-switch form-check-switch-left">
									<label class="checkbox-inline">
									  	<input type="checkbox" name="stok" id="stok" class="danger" data-toggle="toggle" data-on="VAR" data-off="YOK" data-onstyle="success" data-offstyle="danger" value="1" <?=($row->STOK==1?'checked':'')?>>
									</label>
								</div>
							</div>
							<div class="col-md-2 col-xs-2 mb-2 senet0">
								<div class="frame-heading mb-0"><?=dil("Kampanyalı")?></div>
								<div class="form-check form-check-switch form-check-switch-left">
									<label class="checkbox-inline">
									  	<input type="checkbox" name="kampanyali" id="kampanyali" class="danger" data-toggle="toggle" data-on="VAR" data-off="YOK" data-onstyle="success" data-offstyle="danger" value="1" <?=($row->KAMPANYALI==1?'checked':'')?>>
									</label>
								</div>
							</div>				
							<div class="col-md-12 col-xs-12 text-center mt-3">
								<div class="form-group">
							      	<label class="form-label"></label>   
							    	<button type="button" class="btn btn-primary waves-effect waves-themed" style="width: 150px" onclick="fncKaydet()"><?=dil("Kaydet")?></button>
							    </div>
							</div>							
						</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12 text-right">
					<div class="help-block"><?=dil("Kayıt Yapan")?>: <span class="fw-700"><?=$row->KAYIT_YAPAN?></span>, <?=dil("Kayıt Tarih")?>: <span class="fw-700"><?=FormatTarih::tarih($row->TARIH)?></span></div>	
				</div>
			</div>
		</section>
		
    </main>    
    </div>
    </div>
            
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
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
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();		
		
		function fncFinansKalemi(){
			if($("#finans_kalemi_id").val() == 1){
				$("#ihale_id").parent().parent().hide();
				$("#cari_id").parent().parent().show();
			} else if($("#finans_kalemi_id").val() == 2){
				$("#ihale_id").parent().parent().show();
				$("#cari_id").parent().parent().hide();
			} else if($("#finans_kalemi_id").val() == 3){
				$("#ihale_id").parent().parent().hide();
				$("#cari_id").parent().parent().show();
			}
			
		}
		
		function fncKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formYedekParca').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						//window.opener.location.reload(false);
						//window.close();
					}
				}
			});	
		}
		
	</script>
    
</body>
</html>
