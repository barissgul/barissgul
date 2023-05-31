<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row 				= $cSubData->getTalep($_REQUEST);
	$rows_parca			= $cSubData->getTalepParcalar($_REQUEST);
	$rows_iscilik		= $cSubData->getTalepIscilikler($_REQUEST);
	$row_ikame			= $cSubData->getTalepIkame($_REQUEST);
	
	$rows_resim			= $cSubData->getTalepResimler($_REQUEST);
	
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
   
    <main id="js-page-content" role="main" class="page-content">
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-xl-10 offset-xl-1 col-md-12 col-sm-12">		          	
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <?=dil("Talep Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover table-striped mb-0">
										<thead>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Talep No")?></td>
												<td class="" width="32%"><?=$row->ID?></td>
												<td class="bg-gray-100" width="18%"><?=dil("Süreç")?></td>
												<td class="" width="32%"><?=$row->SUREC?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Talep Tarihi")?></td>
												<td class=""><?=FormatTarih::tarih($row->TARIH)?></td>
												<td class="bg-gray-100"><?=dil("Araç Geliş Tarihi")?></td>
												<td class=""><?=FormatTarih::tarih($row->ARAC_GELIS_TARIH)?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Tamir Başlandı Tarihi")?></td>
												<td class=""><?=FormatTarih::tarih($row->TAMIR_BAS_TARIH)?></td>
												<td class="bg-gray-100"><?=dil("Tamir Bitti Tarihi")?></td>
												<td class=""><?=FormatTarih::tarih($row->TAMIR_BIT_TARIH)?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Teslim Hazır Tarihi")?></td>
												<td class=""><?=FormatTarih::tarih($row->TESLIME_HAZIR_TARIH)?></td>
												<td class="bg-gray-100"><?=dil("Teslim Edildi Tarihi")?></td>
												<td class=""><?=FormatTarih::tarih($row->TESLIM_EDILDI_TARIH)?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Ödeme Yapıldı Tarihi")?></td>
												<td class=""><?=FormatTarih::tarih($row->ODEME_YAPILDI_TARIH)?></td>
											</tr>
										</thead>
									</table>
			            		</div>
			            	</div>
			            </div>
		          	</div>
		          	</div>
		          	
		          	<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <?=dil("Araç Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover table-striped mb-0">
										<thead>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Plaka")?></td>
												<td class="" width="32%"><?=$row->PLAKA?></td>
												<td class="bg-gray-100" width="18%"><?=dil("Model Yılı")?></td>
												<td class="" width="32%"><?=$row->MODEL_YILI?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Marka - Model")?></td>
												<td class="" colspan="3"><?=$row->MARKA?> <?=$row->MODEL?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Sasi No")?></td>
												<td class=""><?=$row->SASI_NO?></td>
												<td class="bg-gray-100"><?=dil("Motor No")?></td>
												<td class=""><?=$row->MOTOR_NO?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Yakıt Türü")?></td>
												<td class=""><?=$row->YAKIT?></td>
												<td class="bg-gray-100"><?=dil("Vites Türü")?></td>
												<td class=""><?=$row->VITES?></td>
											</tr>
										</thead>
									</table>
			            		</div>
			            	</div>
			            </div>
		          	</div>
		          	</div>
		          	
		          	<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <?=dil("Cari Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover table-striped mb-0">
										<thead>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Cari")?></td>
												<td class="" width="32%" colspan="3"><?=$row->CARI?></td>
											</tr>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Vergi No")?> </td>
												<td class="" width="32%"><?=$row->TCK?></td>
												<td class="bg-gray-100" width="18%"><?=dil("Vergi Dairesi")?></td>
												<td class="" width="32%"><?=$row->VD?></td>
											</tr>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Adres")?></td>
												<td class="" width="32%" colspan="3"><?=$row->CARI_ADRES?></td>
											</tr>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Tel")?> </td>
												<td class="" width="32%"><?=$row->CARI_TEL?></td>
												<td class="bg-gray-100" width="18%"><?=dil("Cep Tel")?></td>
												<td class="" width="32%"><?=$row->CARI_CEPTEL?></td>
											</tr>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Sürücü Ad Soyad")?> </td>
												<td class="" width="32%"><?=$row->SURUCU_AD_SOYAD?></td>
												<td class="bg-gray-100" width="18%"><?=dil("Sürücü Tel")?></td>
												<td class="" width="32%"><?=$row->SURUCU_TEL?></td>
											</tr>
										</thead>
									</table>
			            		</div>
			            	</div>
			            </div>
		          	</div>
		          	</div>
		          	
		          	<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <?=dil("Fatura Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover table-striped mb-0">
										<thead>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Fatura No")?></td>
												<td class="" width="32%"><?=$row->FATURA_NO?></td>
												<td class="bg-gray-100" width="18%"><?=dil("Fatura Türü")?></td>
												<td class="" width="32%"><?=$row->FATURA_KES_TEXT?></td>
											</tr>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Fatura Tutar")?></td>
												<td class="" width="32%"><?=FormatSayi::sayi($row->FATURA_TUTAR,2)?> <i class="far fa-lira-sign"></i></td>
												<td class="bg-gray-100" width="18%"><?=dil("Fatura Tarih")?></td>
												<td class="" width="32%"><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
											</tr>
										</thead>
									</table>
			            		</div>
			            	</div>
			            </div>
		          	</div>
		          	</div>
		          	
		          	<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <?=dil("İkame Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover table-striped mb-0">
										<thead>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Plaka")?></td>
												<td class="" width="32%"><?=$row_ikame->PLAKA?></td>
												<td class="bg-gray-100" width="18%"><?=dil("Model Yılı")?></td>
												<td class="" width="32%"><?=$row_ikame->MODEL_YILI?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Marka - Model")?></td>
												<td class="" colspan="3"><?=$row_ikame->MARKA?> <?=$row_ikame->MODEL?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Araç Veriliş Tarihi")?></td>
												<td class=""><?=FormatTarih::tarih($row->IKAME_VERILIS_TARIH)?> <?=$row->IKAME_VERILIS_SAAT?><?=(is_null($row->IKAME_VERILIS_SAAT)?'':':00')?></td>
												<td class="bg-gray-100"><?=dil("Araç Geliş Tarihi")?></td>
												<td class=""><?=FormatTarih::tarih($row->IKAME_GELIS_TARIH)?> <?=$row->IKAME_GELIS_SAAT?><?=(is_null($row->IKAME_GELIS_SAAT)?'':':00')?></td>
											</tr>
										</thead>
									</table>
			            		</div>
			            	</div>
			            </div>
		          	</div>
		          	</div>
		          	
		          	<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <?=dil("Sigorta Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover table-striped mb-0">
										<thead>
											<tr>
												<td class="bg-gray-100" width="18%"><?=dil("Sigorta Dosya No")?></td>
												<td class="" width="32%"><?=$row->DOSYA_NO?></td>
												<td class="bg-gray-100" width="18%"><?=dil("Sigorta Firması")?></td>
												<td class="" width="32%"><?=$row->SIGORTA_FIRMASI?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Sigorta Şekli")?></td>
												<td class=""><?=$row->SIGORTA_SEKLI?></td>
												<td class="bg-gray-100"><?=dil("Ruhsat Sahibi")?></td>
												<td class=""><?=$row->RUHSAT_SAHIBI?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Sigortalı Tel")?></td>
												<td class=""><?=$row->SIGORTALI_TEL?></td>
												<td class="bg-gray-100"><?=dil("Sigortalı TCK")?></td>
												<td class=""><?=$row->SIGORTALI_TCK?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Eksper")?></td>
												<td class=""><?=$row->EKSPER?></td>
												<td class="bg-gray-100"><?=dil("Eksper Tel")?></td>
												<td class=""><?=$row->EKSPER_TEL?></td>
											</tr>
											<tr>
												<td class="bg-gray-100"><?=dil("Eksper Mail")?></td>
												<td class=""><?=$row->EKSPER_MAIL?></td>
												<td class="bg-gray-100"> </td>
												<td class=""> </td>
											</tr>
										</thead>
									</table>
			            		</div>
			            	</div>
			            </div>
		          	</div>
		          	</div>
		          	
		          	<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <?=dil("Ekspertiz Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<div class="panel-tag"><?=dil("İşçilikler")?></div>
							<div class="row">
								<div class="col-md-12">
									<table class="table table-sm table-condensed table-hover">
										<thead>
											<tr class="fw-500">
												<td class="bg-gray-100" width="2%">#</td>
												<td class="bg-gray-100" width="10%"><?=dil("Kodu")?></td>
												<td class="bg-gray-100" width="43%"><?=dil("Parça")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("B.Fiyat")?></td>
												<td class="bg-gray-100 text-center" width="5%"><?=dil("Adet")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("Fiyat")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("İskonto")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("Kdv")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("Tutar")?></td>
												
											</tr>
										</thead>
										<tbody>
											<?
											foreach($rows_parca as $key => $row_parca){
												$row_toplam->ADET			+= $row_parca->ADET;
												$row_toplam->ALIS			+= $row_parca->ALIS * $row_parca->ADET;
												$row_toplam->FIYAT			+= $row_parca->FIYAT * $row_parca->ADET;
												$row_toplam->FIYAT2			+= $row_parca->FIYAT;
												$row_toplam->ISKONTOLU		+= $row_parca->ISKONTOLU * $row_parca->ADET;
												$row_toplam->TUTAR			+= $row_parca->TUTAR;
												?>
												<tr>
													<td class=""><?=($key+1)?></td>
													<td class=""><?=$row_parca->PARCA_KODU?></td>
													<td class=""><?=$row_parca->PARCA_ADI?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_parca->FIYAT,2)?></td>
													<td class="text-center"><?=FormatSayi::sayi($row_parca->ADET,2)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_parca->FIYAT * $row_parca->ADET,2)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_parca->FIYAT - $row_parca->ISKONTOLU,2)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_parca->TUTAR - $row_parca->ISKONTOLU,2)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_parca->TUTAR)?></td>
												</tr>
											<?}?>
										</tbody>
										<thead>
											<tr>
												<td class="bg-gray-100"></td>
												<td class="bg-gray-100"></td>
												<td class="bg-gray-100"></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam->FIYAT)?></td>
												<td class="bg-gray-100 text-center"><?=FormatSayi::sayi($row_toplam->ADET,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam->FIYAT,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam->FIYAT - $row_toplam->ISKONTOLU,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam->TUTAR - $row_toplam->ISKONTOLU,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam->TUTAR,2)?></td>
											</tr>
										</thead>
									</table>
			            		</div>
			            	</div>
			            	<div class="panel-tag"><?=dil("İşçilikler")?></div>
							<div class="row">
								<div class="col-md-12">
									<table class="table table-sm table-condensed table-hover">
										<thead>
											<tr class="fw-500">
												<td class="bg-gray-100" width="2%">#</td>
												<td class="bg-gray-100" width="10%"><?=dil("Kodu")?></td>
												<td class="bg-gray-100" width="43%"><?=dil("İşçilik")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("Onarım")?></td>
												<td class="bg-gray-100 text-right" width="5%"><?=dil("Boya")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("Söktak")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("Fiyat")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("İskonto")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("Kdv")?></td>
												<td class="bg-gray-100 text-right" width="10%"><?=dil("Tutar")?></td>
											</tr>
										</thead>
										<tbody>
											<?
											foreach($rows_iscilik as $key => $row_iscilik){
												$row_toplam_is->ONARIM		+= $row_iscilik->ONARIM;
												$row_toplam_is->BOYA		+= $row_iscilik->BOYA;
												$row_toplam_is->SOKTAK		+= $row_iscilik->SOKTAK;
												$row_toplam_is->FIYAT		+= $row_iscilik->FIYAT;
												$row_toplam_is->ISKONTOLU	+= $row_iscilik->ISKONTOLU;
												$row_toplam_is->TUTAR		+= $row_iscilik->TUTAR;
												?>
												<tr>
													<td class=""><?=($key+1)?></td>
													<td class=""><?=$row_iscilik->PARCA_KODU?></td>
													<td class=""><?=$row_iscilik->PARCA_ADI?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_iscilik->ONARIM)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_iscilik->BOYA)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_iscilik->SOKTAK)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_iscilik->FIYAT)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_iscilik->FIYAT * $row_iscilik->ISKONTO / 100,2)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_iscilik->TUTAR - $row_iscilik->ISKONTOLU,2)?></td>
													<td class="text-right"><?=FormatSayi::sayi($row_iscilik->TUTAR)?></td>
												</tr>
											<?}?>
										</tbody>
										<thead>
											<tr>
												<td class="bg-gray-100"></td>
												<td class="bg-gray-100"></td>
												<td class="bg-gray-100"></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam_is->ONARIM,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam_is->BOYA,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam_is->SOKTAK,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam_is->FIYAT,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam_is->ISKONTOLU,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam_is->TUTAR - $row_toplam_is->ISKONTOLU,2)?></td>
												<td class="bg-gray-100 text-right"><?=FormatSayi::sayi($row_toplam_is->TUTAR,2)?></td>
												
											</tr>
										</thead>
									</table>
			            		</div>
			            	</div>
			            	<div class="row mt-3 text-right">
								<div class="col-md-4 offset-md-8">
									<table class="table table-sm table-condensed table-hover">
										<tr>
											<td><?=dil("Toplam Fiyat")?> </td>
											<td><?=FormatSayi::sayi($row_toplam->FIYAT + $row_toplam_is->FIYAT)?> <i class="fal fa-lira-sign"></i> </td>
										</tr>
										<tr>
											<td><?=dil("Toplam İskonto")?> </td>
											<td><?=FormatSayi::sayi(($row_toplam->FIYAT - $row_toplam->ISKONTOLU) + ($row_toplam_is->FIYAT - $row_toplam_is->ISKONTOLU))?> <i class="fal fa-lira-sign"></i> </td>
										</tr>
										<tr>
											<td><?=dil("Toplam Kdv")?> </td>
											<td><?=FormatSayi::sayi(($row_toplam->TUTAR - $row_toplam->ISKONTOLU) + ($row_toplam_is->TUTAR - $row_toplam_is->ISKONTOLU))?> <i class="fal fa-lira-sign"></i> </td>
										</tr>
										<tr class="h4">
											<td><?=dil("Toplam Tutar")?> </td>
											<td><?=FormatSayi::sayi($row_toplam->TUTAR + $row_toplam_is->TUTAR)?> <i class="fal fa-lira-sign"></i> </td>
										</tr>
									</table>
								</div>
							</div>
			            </div>
		          	</div>
		          	</div>
		          	
		          	<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <?=dil("Resimler")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="row">
								<?foreach($rows_resim as $k => $row_resim){?>
								<div class="col-md-3 text-center" style="margin-bottom: 20px;">
									<?if(is_file($cSabit->imgPathFile($row_resim->URL))){?>
										<a href="<?=$cSabit->imgPath($row_resim->URL)?>" data-toggle="lightbox" data-gallery="example-gallery" data-title="<?=$row_resim->EVRAK?> - <?=$row_resim->RESIM_ADI_ILK?>" data-footer="<?=FormatTarih::tarih($row_resim->TARIH)?>"> 
											<img class="img-thumbnail lazy" alt="" src="/img/loading2.gif" data-src="<?=$cSabit->imgPath($row_resim->URL)?>" style="width:152px;height: 100px"/>
										</a>
						            <?} else {?>
						                <a href="/img/100x100.png" data-toggle="lightbox" data-gallery="example-gallery" data-title="A" data-footer="B"> <img src="/img/100x100.png" class="img-responsive center-block " style="width:152px;height: 100px"> </a>
						            <?}?>
						            <br><?=$row_resim->EVRAK?>
						            <br><?=FormatTarih::tarih($row_resim->TARIH)?>
								</div>
								<?}?>
							</div>
						</div>	
					</div>
					</div>
			        
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
    <script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    
		$("[data-mask]").inputmask();	
		$("img.lazy").lazy();
		
		function fncAracKaydet (){
			/*
			if (window.opener && window.opener !== window) {
			 	window.opener.document.getElementById("musteri_id").trigger("change");
			}
			return false;
			*/
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formAracKaydet').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							window.location.href = jd.URL;
						});
					}
				}
			});
		}
		
		function fncIlceDoldur(il, ilce){
			$(ilce).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "ilce_doldur", 'il_id' : $(il).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$(ilce).html(jd.HTML);
					}
					$(ilce).removeAttr("disabled");
				}
			});
		};
		
		function fncModelDoldur(){
			$("#model_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "model_doldur", 'marka_id' : $("#marka_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$('#model_id').html(jd.HTML);
					}
					$("#model_id").removeAttr("disabled");
				}
			});
		};
		
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
		
	</script>
    
</body>
</html>
