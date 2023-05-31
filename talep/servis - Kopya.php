<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row 				= $cSubData->getTalep($_REQUEST);
	$rows_talep_notu	= $cSubData->getTalepNotlari($_REQUEST);
	$rows_sikayet		= $cSubData->getTalepSikayetler($_REQUEST);
	$rows_sikayet		= arrayIndex($rows_sikayet);	
	
	$rows_parca			= $cSubData->getTalepParcalar($_REQUEST);
	$rows_parca			= arrayIndex($rows_parca);
	$rows_iscilik		= $cSubData->getTalepIscilikler($_REQUEST);
	$rows_iscilik		= arrayIndex($rows_iscilik);
	
	$rows_ikame			= $cSubData->getTalepIkameler($_REQUEST);;
	$rows_ikame			= arrayIndex($rows_ikame);
	
	$rows_resim			= $cSubData->getTalepResimler($_REQUEST);
	$rows_evrak			= $cSubData->getTalepEvraklar($_REQUEST);
	$rows_kontrol		= $cSubData->getTalepKontroller($_REQUEST);
	//fncKodKontrol($row);
	//var_dump2($rows_ikame);
	
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/smartwizard/smartwizard.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.min.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <link rel="stylesheet" href="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.css">
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
	    		<div class="col-lg-12 col-md-12 col-sm-12">		          	
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <i class="fas fa-car fa-2x	 mr-3"></i><?=dil("Servis Talep Bilgisi")?> <span class="badge badge-success ml-3 fs-md"><?=dil("No")?>: <?=$row->ID?></span> </h2>
                        
                        <div class="panel-toolbar">
                        	<a href="<?=fncOzetPopupLink($row)?>" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1 text-white border-white" title="Özet"> <i class="fal fa-eye fs-xl"></i></a>
                        	<a href="<?=fncKabulFormuPopupLink($row)?>" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1 text-white border-white" title="Araç Kabul Formu"> <i class="fal fa-car fs-xl"></i></a>
                        	<a href="<?=fncIsEmriPopupLink($row)?>" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1 text-white border-white" title="İş Emri"> <i class="fal fa-list-alt fs-xl"></i></a>
			                <a href="<?=fncTeslimIbraPopupLink($row)?>" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1 text-white border-white" title="Teslim İbra"> <i class="fal fa-print fs-xl"></i></a>
						    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
						</div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<?if($row->ID > 0){?>
							<h5 class="panel-tag"><span class=""><?=$row->PLAKA?> <?=$row->MARKA?> <?=$row->MODEL?> <?=$row->MODEL_YILI?>, <?=$row->SORUMLU?></span> <span class="float-right"><?=$row->SUREC?> - <?=$row->TALEP_ACAN?> - <?=FormatTarih::tarih($row->TARIH)?></span></h5>
                        	<?}?>
                        	<div class="row">
                        		<div class="col-md-12">
                        			<ul class="nav nav-tabs justify-content-center" role="tablist">
		                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_talep' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_talep" data-toggle="tab"> <?=dil("Talep")?> </a></li>
		                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_randevu')?'active':''?>" href="#tab_randevu" data-toggle="tab"> <?=dil("Randevu")?> </a></li>
						            	<?if($row->ID > 0){?>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_sikayet')?'active':''?>" href="#tab_sikayet" data-toggle="tab"> <?=dil("Şikayet")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_ekspertiz')?'active':''?>" href="#tab_ekspertiz" data-toggle="tab"> <?=dil("Ekspertiz")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_sigorta')?'active':''?>" href="#tab_sigorta" data-toggle="tab"> <?=dil("Sigorta")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_kontrol')?'active':''?>" href="#tab_kontrol" data-toggle="tab"> <?=dil("Kontrol")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_fatura')?'active':''?>" href="#tab_fatura" data-toggle="tab"> <?=dil("Fatura")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_ikame')?'active':''?>" href="#tab_ikame" data-toggle="tab"> <?=dil("İkame")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_talep_notu')?'active':''?>" href="#tab_talep_notu" data-toggle="tab"> <?=dil("Talep Notu")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_resim')?'active':''?>" href="#tab_resim" data-toggle="tab"> <?=dil("Resim")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_evrak')?'active':''?>" href="#tab_evrak" data-toggle="tab"> <?=dil("Evrak")?> </a></li>
						            	<?}?>
		                            </ul>
		                            <div class="tab-content p-3 shadow">
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_talep' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_talep">	
						              		<form name="formTalep" id="formTalep">
												<input type="hidden" name="islem" id="islem" value="talep_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
												<input type="hidden" name="ayni_plaka" id="ayni_plaka" value="<?=$row->ID>0?1:0?>">
												
							                    <div class="row">
							                    	<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Plaka")?></label>
														  	<div class="input-group">
													      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm color-blue">TR</span></div>
													      		<input type="text" class="form-control fs-xl" placeholder="" name="plaka" id="plaka" maxlength="15" value="<?=$row->PLAKA?>">
													      		<div class="input-group-append"><button class="btn btn-success waves-effect waves-themed" type="button" title="Plakadan Bul" onclick="fncPlakaBul(this)"><i class="fal fa-search"></i></button></div>
													      	</div>
														</div>
													</div>
													<div class="col-md-3 mb-2">        
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("Servis Bölüm")?> </label>
													      	<select name="servis_bolum" id="servis_bolum" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->ServisBolum()->setSecilen($row->SERVIS_BOLUM)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-6 mb-2">        
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("Cari")?> <a href="javascript:void(0)" onclick="<?=fncCariPopupLink(array())?>" class="ml-3"><i class="far fa-plus-hexagon"></i></a> <a href="javascript:void(0)" onclick="fncCariDoldur()"><i class="far fa-repeat-alt"></i></a> </label>
													      	<select name="cari_id" id="cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->Cariler()->setSecilen($row->CARI_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="w-100"></div>
							                    	<div class="col-md-3 mb-2">
														<div class="form-group">
													      	<label class="form-label"> <?=dil("Marka")?> </label>
													      	<select name="marka_id" id="marka_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" onchange="fncModelDoldur()">
														      	<?=$cCombo->Markalar()->setSecilen($row->MARKA_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-9 mb-2">        
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("Model")?> </label>
													      	<select name="model_id" id="model_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->MarkaModeller(array("marka_id"=>$row->MARKA_ID))->setSecilen($row->MODEL_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-3 mb-2">
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("KM")?> </label>
													      	<div class="input-group">
													      		<input type="text" class="form-control" placeholder="" name="km" id="km" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 0" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->KM,0)?>" maxlength="10">
													      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-tachometer"></i></span></div>
													      	</div>
													    </div>
													</div>
													<div class="col-md-3 mb-2">        
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("Model Yılı")?> </label>
													      	<select name="model_yili" id="model_yili" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->ModelYillari()->setSecilen($row->MODEL_YILI)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Sürücü Adı Soyadı")?></label>
														  	<input type="text" class="form-control" placeholder="" name="surucu_ad_soyad" id="surucu_ad_soyad" maxlength="100" value="<?=$row->SURUCU_AD_SOYAD?>">
														</div>
													</div>
													<div class="col-md-3 mb-3">        
											            <div class="form-group">
														    <label class="form-label"><?=dil("Sürücü Tel")?></label>
														    <div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														      	<input type="text" class="form-control" name="surucu_tel" id="surucu_tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->SURUCU_TEL?>">
														    </div>
														</div>
											        </div>
													<div class="w-100"></div>
													<div class="col-md-3 mb-2">        
												        <div class="form-group">
													      	<label class="form-label"> <?=dil("Yakıt Türü")?> </label>
													      	<select name="yakit_turu" id="yakit_turu" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->YakitTuru()->setSecilen($row->YAKIT_TURU)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
												    </div>
												    <div class="col-md-3 mb-2">        
												        <div class="form-group">
													      	<label class="form-label"> <?=dil("Vites Türü")?> </label>
													      	<select name="vites_turu" id="vites_turu" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->VitesTuru()->setSecilen($row->VITES_TURU)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
												    </div>
												    <div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Şasi No")?></label>
														  	<input type="text" class="form-control" placeholder="" name="sasi_no" id="sasi_no" maxlength="20" value="<?=$row->SASI_NO?>">
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Motor No")?></label>
														  	<input type="text" class="form-control" placeholder="" name="motor_no" id="motor_no" maxlength="20" value="<?=$row->MOTOR_NO?>">
														</div>
													</div>													
													<div class="w-100"></div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
													        <label class="form-label"><?=dil("Araç Geliş Tarihi")?></label>
													        <div class="input-group date">
													          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300"><i class="far fa-calendar-alt"></i></span></div>
													          	<input type="text" class="form-control datepicker datepicker-inline" name="arac_gelis_tarih" value="<?=FormatTarih::tarih($row->ARAC_GELIS_TARIH)?>" readonly>
													        </div>
													    </div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Araç Geliş Saati")?></label>
														  	<select name="arac_gelis_saat" id="arac_gelis_saat" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->CalismaSaatler()->setSecilen($row->ARAC_GELIS_SAAT)->setSeciniz()->getSelect("ID","AD2")?>
														    </select>
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
													        <label class="form-label"><?=dil("Tah.Teslim Tarihi")?></label>
													        <div class="input-group date">
													          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300"><i class="far fa-calendar-alt"></i></span></div>
													          	<input type="text" class="form-control datepicker datepicker-inline" name="tahmini_teslim_tarih" value="<?=FormatTarih::tarih($row->TAHMINI_TESLIM_TARIH)?>" readonly>
													        </div>
													    </div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Tah.Teslim Saati")?></label>
														  	<select name="tahmini_teslim_saat" id="tahmini_teslim_saat" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->CalismaSaatler()->setSecilen($row->TAHMINI_TESLIM_SAAT)->setSeciniz()->getSelect("ID","AD2")?>
														    </select>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-6 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Şikayet ve Talep")?></label>
														  	<textarea name="talep" id="talep" class="form-control maxlength" maxlength="500" rows="4"><?=$row->TALEP?></textarea>
														</div>
													</div>
													<div class="col-md-6 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Adres")?></label>
														  	<textarea name="adres" id="adres" class="form-control maxlength" maxlength="500" rows="4"><?=$row->ADRES?></textarea>
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
													      	<label class="form-label"> <?=dil("İkame Talebi")?> </label>
													      	<select name="ikame_talebi" id="ikame_talebi" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->IkameTalebi()->setSecilen($row->IKAME_TALEBI)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
													      	<label class="form-label"> <?=dil("Öncelik")?> (1:Az ... 10:Çok) </label>
													      	<select name="oncelik" id="oncelik" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->Oncelik()->setSecilen($row->ONCELIK)->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
													      	<label class="form-label"> <?=dil("Şikayet Sayısı")?> </label>
													      	<select name="sikayet_sayisi" id="sikayet_sayisi" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->ParcaSayisi()->setSecilen($row->SIKAYET_SAYISI)->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
													      	<label class="form-label"> <?=dil("Parça Sayısı")?> </label>
													      	<select name="parca_sayisi" id="parca_sayisi" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->ParcaSayisi()->setSecilen($row->PARCA_SAYISI)->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-4 offset-md-4 text-center">
												        <button type="button" class="btn btn-primary waves-effect waves-themed btn-block mt-2" <?=(($row->SUREC_ID == 10)?'disabled':'')?> id="btnTalepKaydet" onclick="fncTalepKaydet(this)"><?=dil("Kaydet")?></button>
													</div>
													<?if($row->ID > 0){?>
														<div class="w-100 pb-6"></div>
														<?if(in_array($_SESSION['yetki_id'], array(1,2)) AND in_array($row->SUREC_ID, array(1,2,3))){?>
															<div class="col-md-2 text-center">
																<button type="button" class="btn btn-danger waves-effect waves-themed btn-block mt-2" onclick="fncTalepSil(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Talebi Sil")?></button>
															</div>
															<div class="col-md-2 text-center">
																<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncRandevulu(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Randevulu")?></button>
															</div>
														<?}?>
														<div class="col-md-2 text-center">
																<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncAracServiste(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Araç Serviste")?></button>
															</div>
														<div class="col-md-2 text-center">
															<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncTamireBaslandi(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Tamire Başlandı")?></button>
														</div>
														<div class="col-md-2 text-center">
															<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fnTamirBitti(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Tamir Bitti Kontrol Et")?></button>
														</div>
														<div class="col-md-2 text-center">
															<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncTeslimeHazir(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Teslime Hazır")?></button>
														</div>
														<div class="col-md-2 text-center">
															<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncTeslimEdildi(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Teslim Edildi")?></button>
														</div>
														<div class="col-md-2 text-center">
															<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncOdemeYapildi(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Ödeme Yapıldı")?></button>
														</div>
													<?}?>
												</div>
			            					</form>
			            				</div>	
			            				<div class="tab-pane <?=($_REQUEST['tab']=='tab_randevu')?'active':''?>" id="tab_randevu">	
							                <div class="row">
							                	<div class="col-md-6">
							                	<form name="formRandevu" id="formRandevu">
													<input type="hidden" name="islem" id="islem" value="talep_randevu_kaydet">
													<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
													<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
								                	
								                	<div class="row">
									                	<div class="col-md-6 mb-2">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Plaka")?></label>
															  	<div class="input-group">
														      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm color-blue">TR</span></div>
														      		<input type="text" class="form-control fs-xl" placeholder="" name="plaka" id="plaka" maxlength="15" value="<?=$row->PLAKA?>">
														      	</div>
															</div>
														</div>
														<div class="w-100"></div>
														<div class="col-md-6 mb-2">
															<div class="form-group">
														        <label class="form-label"><?=dil("Randevu Tarihi")?></label>
														        <div class="input-group date">
														          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300"><i class="far fa-calendar-alt"></i></span></div>
														          	<input type="text" class="form-control datepicker datepicker-inline" name="randevu_tarih" value="<?=FormatTarih::tarih($row->RANDEVU_TARIH)?>" readonly>
														        </div>
														    </div>
														</div>
														<div class="col-md-6 mb-2">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Randevu Saati")?></label>
															  	<select name="randevu_saat" id="randevu_saat" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
															      	<?=$cCombo->CalismaSaatler()->setSecilen($row->RANDEVU_SAAT)->setSeciniz()->getSelect("ID","AD2")?>
															    </select>
															</div>
														</div>
														<div class="w-100"></div>
														<div class="col-md-12 mb-2">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Randevu Açıklama")?></label>
															  	<textarea name="randevu_aciklama" id="randevu_aciklama" class="form-control maxlength" maxlength="500" rows="4"><?=$row->RANDEVU_ACIKLAMA?></textarea>
															</div>
														</div>
														<div class="w-100"></div>
														<div class="col-md-4 offset-md-4 text-center">
													        <button type="button" class="btn btn-primary waves-effect waves-themed btn-block mt-2" <?=(($row->SUREC_ID == 10)?'disabled':'')?> onclick="fncRandevuKaydet(this)"><?=dil("Kaydet")?></button>
														</div>
													</div>
													</form>
												</div>
												<div class="col-md-6">
												<?if($row->ID > 0){?>
													<form name="formSorumlu" id="formSorumlu">
														<input type="hidden" name="islem" id="islem" value="talep_sorumlu_kaydet">
														<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
														<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
														
									                	<div class="row">
															<div class="col-md-6 mb-2">
																<div class="form-group">
																  	<label class="form-label"><?=dil("Talep Sorumlusu")?></label>
																  	<select name="sorumlu_id" id="sorumlu_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
																      	<?=$cCombo->Sorumlular()->setSecilen($row->SORUMLU_ID)->setSeciniz()->getSelect("ID","ADSOYAD2")?>
																    </select>
																</div>
															</div>
															<div class="col-md-6">
														        <button type="button" class="btn btn-primary waves-effect waves-themed mt-4" <?=(($row->SUREC_ID == 10)?'disabled':'')?> onclick="fncSorumluKaydet(this)"><?=dil("Kaydet")?></button>
															</div>
														</div>
													</form>
												<?}?>
												</div>
											</div>
			            				</div>	
			            				<?if($row->ID > 0){?>
			            				<div class="tab-pane <?=($_REQUEST['tab']=='tab_sikayet')?'active':''?>" id="tab_sikayet">	
					              			<form name="formSikayet" id="formSikayet">
												<input type="hidden" name="islem" id="islem" value="talep_sikayet_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
												
								            	<div class="row">
								            		<div class="col-md-12">
														<div class="table-responsive">
												  		<table class="table table-sm table-condensed table-hover">
													  		<thead class="thead-themed fw-500">
														    	<tr>
														          	<td align="center">#</td>
														          	<td align="center"><?=dil("Şikayet")?></td>
														          	<td align="center"><?=dil("Çözüm")?></td>
														          	<td align="center"><?=dil("Durum")?></td>
														          	<td align="center"><?=dil("Tarih")?></td>
														        </tr>
													        </thead>
													        <tbody>
														        <?for($i = 1; $i <= $row->SIKAYET_SAYISI; $i++){?>
															        <tr>
															          	<td align="center" class="bg-gray-100"><?=($i)?></td>
															          	<td align="center" >
															          		<input type="text" class="form-control" placeholder="" name="sikayet[]" id="sikayet" maxlength="255" value="<?=$rows_sikayet[$i]->SIKAYET?>">
															          	</td>
															          	<td align="center">
															          		<input type="text" class="form-control" placeholder="" name="cozum[]" id="cozum" maxlength="255" value="<?=$rows_sikayet[$i]->COZUM?>">
															          	</td>
															          	<td align="center">
															          		<label class="checkbox-inline">
																			  	<input type="checkbox" class="danger" name="durum[]" id="durum" data-toggle="toggle" data-on="Çözüldü" data-off="Yok" data-onstyle="success" data-offstyle="danger" data-width="80" data-size="sm" value="1" <?=($rows_sikayet[$i]->DURUM=='1'?'checked':'')?>>
																			</label>
															          	</td>
															          	<td align="center" class="fs-xs"><?=FormatTarih::tarih($rows_sikayet[$i]->TARIH)?></td>
															        </tr>
														        <?}?>
													        </tbody>
													  	</table>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-4 offset-md-4 text-center">
														<div class="form-group">
												        	<button type="button" class="btn btn-primary waves-effect waves-themed btn-block mt-2" onclick="fncSikayetKaydet(this)"><?=dil("Kaydet")?></button>
												        </div>
													</div>
								            	</div>
							            	</form>
							            </div>
							            <div class="tab-pane <?=($_REQUEST['tab']=='tab_ekspertiz')?'active':''?>" id="tab_ekspertiz">													
								            <form name="formEkspertiz" id="formEkspertiz">
												<input type="hidden" name="islem" id="islem" value="talep_ekspertiz_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
													
												<div class="row">
								            		<div class="col-md-12">
								            			<div class="panel-tag">
			                                                <?=dil("Yedek Parça Listesi ve Fiyatları")?>
			                                            </div>
														<div class="table-responsive">
												  		<table class="table table-sm table-condensed table-hover">
													  		<thead class="thead-themed fw-500">
														    	<tr>
														          	<td align="center" style="width: 3%;">#</td>
														          	<td align="center" style="width: 9%;"><?=dil("Parça Kodu")?></td>
														          	<td align="center" style="width: 17%;"><?=dil("Parça Adı")?></td>
														          	<td align="center" style="width: 10%;"><?=dil("Tedarikçi")?></td>
														          	<td align="center" style="width: 10%;"><?=dil("Sipariş Tarih")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("Adet")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("Alış")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("Fiyat")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("İskonto")?></td>
														          	<td align="center" style="width: 4%;"><?=dil("Kdv")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("Tutar")?></td>
														          	<td align="center" style="width: 3%;"></td>
														        </tr>
													        </thead>
													        <tbody>
														        <?
														        for($i = 1; $i <= $row->PARCA_SAYISI; $i++){
														        	$row_toplam->ADET			+= $rows_parca[$i]->ADET;
														        	$row_toplam->ALIS			+= $rows_parca[$i]->ALIS * $rows_parca[$i]->ADET;
														        	$row_toplam->FIYAT			+= $rows_parca[$i]->FIYAT * $rows_parca[$i]->ADET;
														        	$row_toplam->ISKONTOLU		+= $rows_parca[$i]->ISKONTOLU * $rows_parca[$i]->ADET;
														        	$row_toplam->TUTAR			+= $rows_parca[$i]->TUTAR;
														        	?>
															        <tr>
															          	<td align="center" class="bg-gray-100"><?=($i)?></td>
															          	<td align="center">
															          		<input type="text" class="form-control form-control-sm" placeholder="" name="yp_parca_kodu[<?=$i?>]" id="yp_parca_kodu" maxlength="25" value="<?=$rows_parca[$i]->PARCA_KODU?>" onchange="this.value=this.value.turkishToUpper();">
															          	</td>
															          	<td align="center">
															          		<input type="text" class="form-control form-control-sm" placeholder="" name="yp_parca_adi[<?=$i?>]" id="yp_parca_adi" maxlength="255" value="<?=$rows_parca[$i]->PARCA_ADI?>" onchange="this.value=this.value.turkishToUpper();">
															          	</td>
															          	<td align="center">
																		    <select name="yp_tedarikci[]" id="yp_tedarikci" class="form-control form-control-sm select2 select2-hidden-accessible" style="width: 100%">
																			  	<?=$cCombo->Tedarikci()->setSecilen($rows_parca[$i]->TEDARIKCI)->setSeciniz("-1","")->getSelect("ID","AD")?>
																			</select>
															          	</td>
															          	<td align="center">
															          		<div class="input-group date">
																	          	<div class="input-group-prepend"><span class="input-group-text fs-sm px-1"><i class="far fa-calendar-alt"></i></span></div>
																	          	<input type="text" class="form-control form-control-sm datepicker datepicker-inline" name="yp_siparis_tarih[<?=$i?>]" value="<?=FormatTarih::tarih($rows_parca[$i]->SIPARIS_TARIH)?>" readonly>
																	        </div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm" placeholder="" name="yp_adet[<?=$i?>]" id="yp_adet" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_parca[$i]->ADET,2)?>">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-plus"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm kdvsiz" placeholder="" name="yp_alis[<?=$i?>]" id="yp_alis" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_parca[$i]->ALIS,2)?>">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm kdvsiz" placeholder="" name="yp_fiyat[<?=$i?>]" id="yp_fiyat" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_parca[$i]->FIYAT,2)?>">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm kdvsiz" placeholder="" name="yp_iskonto[<?=$i?>]" id="yp_iskonto" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_parca[$i]->ISKONTO,2)?>">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-percent"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
															          		<div class="custom-control custom-checkbox custom-checkbox-circle">
												                                <input type="checkbox" class="custom-control-input" id="yp_kdv<?=$i?>" name="yp_kdv[<?=$i?>]" value="1" <?=(($rows_parca[$i]->KDV == "1")?'checked':'')?> >
												                                <label class="custom-control-label" for="yp_kdv<?=$i?>"></label>
												                            </div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm" placeholder="" name="yp_tutar[<?=$i?>]" id="yp_tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_parca[$i]->TUTAR,2)?>" readonly>
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center" nowrap>
															          		<?if($rows_parca[$i]->ID > 0) {?>
															          			<?if(is_null($rows_parca[$i]->GELDI_TARIH)) {?>
															          				<button type="button" class="btn btn-xs btn-success waves-effect waves-themed" data-parca_id="<?=$rows_parca[$i]->PARCA_ID?>" onclick="fncEkspertizParcaGeldi(this)" title="Parça Geldi"><i class="fal fa-download"></i></button>
															          				<button type="button" class="btn btn-xs btn-danger waves-effect waves-themed" data-parca_id="<?=$rows_parca[$i]->PARCA_ID?>" onclick="fncEkspertizParcaSil(this)" title="Parça Geldi"><i class="fal fa-times"></i></button>
															          			<?} else {?>
															          				<small><?=FormatTarih::tarih($rows_parca[$i]->GELDI_TARIH)?></small>
															          			<?}?>
															          		<?}?>
															          	</td>
															        </tr>
														        <?}?>
													        </tbody>
													        <tfoot class="bg-gray-300 fw-500">
														    	<tr>
														          	<td align="center"></td>
														          	<td align="center"></td>
														          	<td align="right"></td>
														          	<td align="right"></td>
														          	<td align="right"></td>
														          	<td align="center">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam->ADET,0)?> </span>
														          	</td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam->ALIS,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
														          	</td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam->FIYAT,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
														          	</td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi(FormatSayi::iskontoOran($row_toplam->FIYAT2, $row_toplam->ISKONTOLU),2)?> </span> <i class="fal fa-percent mr-1"></i>
														          	</td>
														          	<td align="right"></td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam->TUTAR,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
														          	</td>
														        </tr>
													        </tfoot>
													  	</table>
														</div>
													</div>
													<div class="col-md-2">
														<td align="center" style="width: 10%;">
															<label class="form-label"> <?=dil("YP Toplu İskonto")?> </label>
														    <div class="input-group">
															  	<input type="text" class="form-control" placeholder="" name="toplu_iskonto" id="toplu_iskonto" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->TOPLU_ISKONTO,2)?>">
															  	<div class="input-group-append">
	                                                    			<button class="btn btn-primary waves-effect waves-themed" <?=(($row->SUREC_ID == 10)?'disabled':'')?> type="button" id="button-addon5" title="Uygula" onclick="fncTopluIskonto(this)"><i class="fal fa-save"></i></button>
	                                                			</div>
															</div>
														</td>
													</div>
													<div class="col-md-2">
														<td align="center" style="width: 10%;">
															<label class="form-label"> <?=dil("YP Toplu Sipariş Tarihi")?> </label>
														    <div class="input-group date">
															  	<div class="input-group-prepend"><span class="input-group-text fs-sm hidden-md-up"><i class="far fa-calendar-alt"></i></span></div>
															  	<input type="text" class="form-control datepicker datepicker-inline" id="toplu_siparis_tarih" name="toplu_siparis_tarih" value="<?=FormatTarih::tarih($row->TOPLU_SIPARIS_TARIH)?>" readonly>
															  	<div class="input-group-append">
	                                                    			<button class="btn btn-primary waves-effect waves-themed" <?=(($row->SUREC_ID == 10)?'disabled':'')?> type="button" id="button-addon5" title="Uygula" onclick="fncTopluSiparisTarih(this)"><i class="fal fa-save"></i></button>
	                                                			</div>
															</div>
														</td>
													</div>
													<div class="col-md-4 mb-2 text-center">
														<button type="button" class="btn btn-primary waves-effect waves-themed mt-4" <?=(($row->SUREC_ID == 10)?'disabled':'')?> style="width: 120px" onclick="fncEkspertizParcaKaydet(this)"><?=dil("Kaydet")?></button>
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-md-12">
														<div class="panel-tag">
			                                                <p><?=dil("İşçilik Listesi ve Fiyatları")?></p>
			                                            </div>
														<div class="table-responsive">
												  		<table class="table table-sm table-condensed table-hover">
													  		<thead class="thead-themed fw-500">
														    	<tr>
														          	<td align="center" style="width: 3%;">#</td>
														          	<td align="center" style="width: 10%;"><?=dil("Parça Kodu")?></td>
														          	<td align="center" style="width: 17%;"><?=dil("İşçilik Adı")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Alış")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Onarım")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Boya")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Söktak")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Fiyat")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("İskonto")?></td>
														          	<td align="center" style="width: 4%;"><?=dil("Kdv")?></td>
														          	<td align="center" style="width: 10%;"><?=dil("Tutar")?></td>
														          	<td align="center"></td>
														        </tr>
													        </thead>
													        <tbody>
														        <?
														        for($i = 1; $i <= $row->PARCA_SAYISI; $i++){
														        	$row_toplam_is->ALIS		+= $rows_iscilik[$i]->ALIS;
														        	$row_toplam_is->ONARIM		+= $rows_iscilik[$i]->ONARIM;
														        	$row_toplam_is->BOYA		+= $rows_iscilik[$i]->BOYA;
														        	$row_toplam_is->SOKTAK		+= $rows_iscilik[$i]->SOKTAK;
														        	$row_toplam_is->FIYAT		+= $rows_iscilik[$i]->FIYAT;
														        	$row_toplam_is->ISKONTOLU	+= $rows_iscilik[$i]->ISKONTOLU;
														        	$row_toplam_is->TUTAR		+= $rows_iscilik[$i]->TUTAR;
														        	?>
															        <tr>
															          	<td align="center" class="bg-gray-100"><?=($i)?></td>
															          	<td align="center" >
															          		<input type="text" class="form-control form-control-sm" placeholder="" name="is_parca_kodu[<?=$i?>]" id="is_parca_kodu" maxlength="25" value="<?=$rows_iscilik[$i]->PARCA_KODU?>" onchange="this.value=this.value.turkishToUpper();">
															          	</td>
															          	<td align="center">
															          		<input type="text" class="form-control form-control-sm" placeholder="" name="is_parca_adi[<?=$i?>]" id="is_parca_adi" maxlength="255" value="<?=$rows_iscilik[$i]->PARCA_ADI?>" onchange="this.value=this.value.turkishToUpper();">
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm kdvsiz" placeholder="" name="is_alis[<?=$i?>]" id="is_alis" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_iscilik[$i]->ALIS,2)?>">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm kdvsiz" placeholder="" name="is_onarim[<?=$i?>]" id="is_onarim" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_iscilik[$i]->ONARIM,2)?>">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm kdvsiz" placeholder="" name="is_boya[<?=$i?>]" id="is_boya" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_iscilik[$i]->BOYA,2)?>">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm kdvsiz" placeholder="" name="is_soktak[<?=$i?>]" id="is_soktak" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_iscilik[$i]->SOKTAK,2)?>">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm" placeholder="" name="is_fiyat[<?=$i?>]" id="is_fiyat" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_iscilik[$i]->FIYAT,2)?>" readonly>
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm" placeholder="" name="is_iskonto[<?=$i?>]" id="is_iskonto" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_iscilik[$i]->ISKONTO,2)?>">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-percent"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
															          		<div class="custom-control custom-checkbox custom-checkbox-circle">
												                                <input type="checkbox" class="custom-control-input" id="is_kdv<?=$i?>" name="is_kdv[<?=$i?>]" value="1" <?=(($rows_iscilik[$i]->KDV == "1")?'checked':'')?> >
												                                <label class="custom-control-label" for="is_kdv<?=$i?>"></label>
												                            </div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm" placeholder="" name="is_tutar[<?=$i?>]" id="is_tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($rows_iscilik[$i]->TUTAR,2)?>" readonly>
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td>
															          		<?if($rows_iscilik[$i]->ID > 0) {?>
															          			<button type="button" class="btn btn-xs btn-danger waves-effect waves-themed" data-parca_id="<?=$rows_iscilik[$i]->PARCA_ID?>" onclick="fncEkspertizIscilikSil(this)" title="Parça Geldi"><i class="fal fa-times"></i></button>
															          		<?}?>
															          	</td>
															        </tr>
														        <?}?>
													        </tbody>
													        <tfoot class="bg-gray-300 fw-500">
														    	<tr>
														          	<td align="center"></td>
														          	<td align="center"></td>
														          	<td align="right"></td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam_is->ALIS,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
														          	</td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam_is->ONARIM,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
														          	</td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam_is->BOYA,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
														          	</td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam_is->SOKTAK,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
														          	</td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam_is->FIYAT,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
														          	</td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi(FormatSayi::iskontoOran($row_toplam_is->FIYAT, $row_toplam_is->ISKONTOLU),2)?> </span> <i class="fal fa-percent mr-1"></i>
														          	</td>
														          	<td align="right"></td>
														          	<td align="right">
														          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam_is->TUTAR,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
														          	</td>
														        </tr>
													        </tfoot>
													  	</table>
														</div>
													</div>
												</div>
											</form>
											<div class="row mt-3 text-right">
												<div class="col-md-3">
													<table class="table table-condensed">
														<tr>
															<td><?=dil("Toplam Alış")?> </td>
															<td><?=$row_toplam->ALIS + $row_toplam_is->ALIS?> <i class="fal fa-lira-sign"></i> </td>
														</tr>
													</table>
												</div>
												<div class="col-md-3 offset-md-6 pr-6">
													<table class="table table-condensed table-hover">
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
														<tr>
															<td><?=dil("Toplam Tutar")?> </td>
															<td><?=FormatSayi::sayi($row_toplam->TUTAR + $row_toplam_is->TUTAR)?> <i class="fal fa-lira-sign"></i> </td>
														</tr>
													</table>
												</div>
											</div>
							            </div>
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_sigorta')?'active':''?>" id="tab_sigorta">	
						              		<form name="formSigortaBilgileri" id="formSigortaBilgileri">
												<input type="hidden" name="islem" id="islem" value="sigorta_bilgileri_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
												
							                    <div class="row">
							                    	<div class="col-md-4 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Sigorta Dosya No")?></label>
														  	<input type="text" class="form-control" placeholder="" name="dosya_no" id="dosya_no" maxlength="15" value="<?=$row->DOSYA_NO?>">
														</div>
													</div>
													<div class="col-md-4 mb-2">        
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("Sigorta Firması")?> </label>
													      	<select name="sigorta_id" id="sigorta_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->SigortaFirmalari()->setSecilen($row->SIGORTA_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-4 mb-2">        
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("Sigorta Şekli")?> </label>
													      	<select name="sigorta_sekli" id="sigorta_sekli" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->SigortaSekli()->setSecilen($row->SIGORTA_SEKLI)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-4 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Ruhsat Sahibi")?></label>
														  	<input type="text" class="form-control" placeholder="" name="ruhsat_sahibi" id="ruhsat_sahibi" maxlength="100" value="<?=$row->RUHSAT_SAHIBI?>">
														</div>
													</div>
													<div class="col-md-4 mb-2">        
											            <div class="form-group">
														    <label class="form-label"><?=dil("Sigortalı Tel")?></label>
														    <div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														      	<input type="text" class="form-control" name="sigortali_tel" id="sigortali_tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->SIGORTALI_TEL?>">
														    </div>
														</div>
											        </div>
											        <div class="col-md-4 mb-2">
											        	<div class="form-group">
															<label class="form-label"><?=dil("Sigortalı TCK")?></label>
															<input type="text" class="form-control" placeholder="" name="sigortali_tck" id="sigortali_tck" maxlength="11" value="<?=$row->SIGORTALI_TCK?>">
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-4 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Eksper")?></label>
														  	<div class="input-group">
														  		<input type="text" class="form-control" placeholder="" name="eksper" id="eksper" maxlength="50" value="<?=$row->EKSPER?>">
														  		<div class="input-group-append"><button class="btn btn-success waves-effect waves-themed" type="button" title="Eksper Bul" onclick="fncEksperBul(this)"><i class="fal fa-search"></i></button></div>
														  	</div>
														</div>
													</div>
													<div class="col-md-4 mb-2">        
											            <div class="form-group">
														    <label class="form-label"><?=dil("Eksper Tel")?></label>
														    <div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														      	<input type="text" class="form-control" name="eksper_tel" id="eksper_tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->EKSPER_TEL?>">
														    </div>
														</div>
											        </div>
											        <div class="col-md-4 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Eksper Mail")?></label>
														  	<div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
														      	<input type="text" class="form-control" placeholder="" name="eksper_mail" id="eksper_mail" maxlength="100" value="<?=$row->EKSPER_MAIL?>">
														    </div>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-8 offset-md-2 mb-3">
														<table class="table table-bordered table-condensed table-sm fs-md border border-info bg-info-100">
															<thead>
																<tr>
																	<td align="center" width="2%">#</td>
																	<td align="center" width="25%"><b><?=dil("Sigorta Ödeme Tutarı")?></b></td>
																	<td align="center" width="25%"><b><?=dil("Sigorta Ödeme Tarihi")?></b></td>
																	<td align="center" width="48%"><b><?=dil("Sigorta Ödeme Açıklama")?></b></td>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td align="center">1</td>
																	<td>
																		<div class="input-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_tutar1" id="sigorta_odeme_tutar1" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SIGORTA_ODEME_TUTAR1,0)?>">
																		  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
																		</div>
																	</td>
																	<td>
																		<div class="input-group date">
																          	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
																          	<input type="text" class="form-control datepicker datepicker-inline" name="sigorta_odeme_tarih1" value="<?=FormatTarih::tarih($row->SIGORTA_ODEME_TARIH1)?>" readonly>
																        </div>
																	</td>
																	<td>
																		<div class="form-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_aciklama1" id="sigorta_odeme_aciklama1" maxlength="255" value="<?=$row->SIGORTA_ODEME_ACIKLAMA1?>">
																		</div>
																	</td>
																	
																</tr>
																<tr>
																	<td align="center">2</td>
																	<td>
																		<div class="input-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_tutar2" id="sigorta_odeme_tutar2" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SIGORTA_ODEME_TUTAR2,0)?>">
																		  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
																		</div>
																	</td>
																	<td>
																		<div class="input-group date">
																          	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
																          	<input type="text" class="form-control datepicker datepicker-inline" name="sigorta_odeme_tarih2" value="<?=FormatTarih::tarih($row->SIGORTA_ODEME_TARIH2)?>" readonly>
																        </div>
																	</td>
																	<td>
																		<div class="form-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_aciklama2" id="sigorta_odeme_aciklama2" maxlength="255" value="<?=$row->SIGORTA_ODEME_ACIKLAMA2?>">
																		</div>
																	</td>
																</tr>
																<tr>
																	<td align="center">3</td>
																	<td>
																		<div class="input-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_tutar3" id="sigorta_odeme_tutar3" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SIGORTA_ODEME_TUTAR3,0)?>">
																		  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
																		</div>
																	</td>
																	<td>
																		<div class="input-group date">
																          	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
																          	<input type="text" class="form-control datepicker datepicker-inline" name="sigorta_odeme_tarih3" value="<?=FormatTarih::tarih($row->SIGORTA_ODEME_TARIH3)?>" readonly>
																        </div>
																	</td>
																	<td>
																		<div class="form-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_aciklama3" id="sigorta_odeme_aciklama3" maxlength="255" value="<?=$row->SIGORTA_ODEME_ACIKLAMA3?>">
																		</div>
																	</td>
																	
																</tr>
															</tbody>
														</table>
													</div>
													<div class="w-100"></div>
													<div class="col-md-4 offset-md-4 text-center">
														<div class="form-group">
												        	<button type="button" class="btn btn-primary waves-effect waves-themed btn-block mt-2" onclick="fncSigortaBilgileriKaydet(this)"><?=dil("Kaydet")?></button>
												        </div>
													</div>
												</div>
			            					</form>
			            				</div>
			            				<div class="tab-pane <?=($_REQUEST['tab']=='tab_kontrol')?'active':''?>" id="tab_kontrol">	
					              			<form name="formKontrol" id="formKontrol">
												<input type="hidden" name="islem" id="islem" value="talep_kontrol_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
												
								            	<div class="row">
								            		<div class="col-xl-10 offset-xl-1 col-md-12">
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
															          		<input type="text" class="form-control form-control-sm" placeholder="" name="islem_sonrasi[<?=$row_kontrol->ID?>]" id="islem_sonrasi<?=$row_kontrol->ID?>" maxlength="255" value="<?=$row_kontrol->ISLEM_SONRASI?>">
															          	</td>
															          	<td align="center">
																			<input type="checkbox" class="danger" name="durum[<?=$row_kontrol->ID?>]" id="durum<?=$row_kontrol->ID?>" data-toggle="toggle" data-on="Çözüldü" data-off="Yok" data-onstyle="success" data-offstyle="danger" data-width="80" data-size="sm" value="1" <?=($row_kontrol->DURUM=='1'?'checked':'')?>>
															          	</td>
															        </tr>
														        <?}?>
													        </tbody>
													  	</table>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-4 offset-md-4 text-center">
														<div class="form-group">
												        	<button type="button" class="btn btn-outline-primary waves-effect waves-themed mt-2" style="width: 120px;" onclick="fncKontrolKaydet(this)"><?=dil("Kaydet")?></button>
												        	<button type="button" class="btn btn-outline-secondary waves-effect waves-themed mt-2" onclick="fncPopup('/talep/popup_kontrol.do?route=talep/popup_kontrol&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_KONTROL',1100,850);" title="Yazdır"><i class="fal fa-print fs-xl"></i></button>
												        </div>
													</div>
								            	</div>
							            	</form>
							            </div>
			            				<div class="tab-pane <?=($_REQUEST['tab']=='tab_fatura')?'active':''?>" id="tab_fatura">	
						              		<form name="formFatura" id="formFatura">
												<input type="hidden" name="islem" id="islem" value="talep_fatura_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
												
												<div class="row">
												<div class="col-md-6 offset-md-3">
												<div class="panel shadow p-3">
													<div class="panel-hdr bg-primary-gradient">
														<h2><?=dil("Fatura")?></h2>
														<div class="panel-toolbar">
				                                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				                                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				                                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
				                                        </div>
													</div>
													<div class="panel-container show">
														<div class="panel-content">
										                    <div class="row">
										                    	<div class="col-md-6 mb-2">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Fatura No")?></label>
																	  	<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" maxlength="20" value="<?=$row->FATURA_NO?>">
																	</div>
																</div>
																<div class="col-md-6 mb-2 text-center">        
																    <div class="form-group">
																      	<label class="form-label"> <?=dil("Fatura Kes")?> </label>
																      	<select name="fatura_kes" id="fatura_kes" class="form-control select2 select2-hidden-accessible" style="width: 100%">
																	      	<?=$cCombo->FaturaKes()->setSecilen($row->FATURA_KES)->getSelect("ID","AD")?>
																	    </select>
																    </div>
																</div>
																<div class="col-md-6 mb-2">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Fatura Tarih")?></label> 
																	   	<div class="input-group date">
																		  	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
																		  	<input type="text" class="form-control datepicker datepicker-inline" name="fatura_tarih" value="<?=FormatTarih::tarih($row->FATURA_TARIH)?>" readonly>
																		</div>
																	</div>
																</div>
																<div class="col-md-6 mb-2">
																 	<div class="form-group">
																	    <label class="form-label"><?=dil("Fatura Tutar")?></label>
																		<div class="input-group">
																		  	<input type="text" class="form-control" placeholder="" name="fatura_tutar" id="fatura_tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->ODENECEK_TUTAR,2)?>" readonly>
																		  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
																		</div>
																	</div>
																</div>
																<div class="w-100"></div>
																<div class="col-md-12 mb-2">
																	<div class="form-group">
																	  	<label class="form-label"><?=dil("Açıklama")?></label>
																	  	<textarea name="fatura_aciklama" id="fatura_aciklama" class="form-control maxlength" maxlength="500" rows="3"><?=$row->FATURA_ACIKLAMA?></textarea>
																	</div>
																</div>
																<div class="w-100"></div>
																<div class="col-md-12 mt-3 text-center">
															        <button type="button" class="btn btn-primary waves-effect waves-themed mt-2 w-50" onclick="fncFaturaKaydet(this)"><?=dil("Kaydet")?></button>
																</div>
															</div>
														</div>
													</div>
												</div>
												</div>
												</div>
			            					</form>
			            				</div>
			            				<div class="tab-pane <?=($_REQUEST['tab']=='tab_ikame')?'active':''?>" id="tab_ikame">	
						              		<form name="formSigortaBilgileri" id="formIkameArac">
												<input type="hidden" name="islem" id="islem" value="talep_ikame_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
												
												<div class="row mb-3">
													<div class="col-md-4 offset-md-4 mb-2 text-center">        
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("İkame Veren")?> </label>
													      	<select name="ikame_veren_id" id="ikame_veren_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->IkameVeren()->setSecilen($row->IKAME_VEREN_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
												</div>
							                    <div class="row">
							                    	<div class="col-md-12">
							                    		<div class="table-responsive">
												  		<table class="table table-sm table-condensed table-hover">
													  		<thead class="thead-themed fw-500">
														    	<tr>
														          	<td align="center">#</td>
														          	<td align="center"><?=dil("İkame Araç")?></td>
														          	<td align="center"><?=dil("Araç Veriliş Tarihi")?></td>
														          	<td align="center"><?=dil("Araç Veriliş Saati")?></td>
														          	<td align="center"><?=dil("Araç Geliş Tarihi")?></td>
														          	<td align="center"><?=dil("Araç Geliş Saat")?></td>
														          	<td align="center"><?=dil("Kesin Geliş Tarihi")?></td>
														        </tr>
													        </thead>
													        <tbody>
														        <?for($i = 1; $i <= 3; $i++){?>
															        <tr>
															          	<td align="center" class="bg-gray-100" style="width: 3%;"><?=($i)?> <a href="javascript:void(0)" onclick="fncTalepTarihiKopyala(<?=$i?>)"><i class="far fa-clone"></i></a></td>
															          	<td style="width: 30%;">
																	      	<select name="arac_id[<?=$i?>]" id="arac_id<?=$i?>" class="form-control form-control-sm select2 select2-hidden-accessible" style="width: 100%">
																		      	<?=$cCombo->IkameAraclar()->setSecilen($rows_ikame[$i]->ARAC_ID)->setSeciniz()->getSelect("ID","AD")?>
																		    </select>
															          	</td>
															          	<td align="center" style="width: 10%;">
															          		<div class="input-group date">
																	          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300 px-1"><i class="far fa-calendar-alt"></i></span></div>
																	          	<input type="text" class="form-control form-control-sm datepicker datepicker-inline" name="ikame_verilis_tarih[<?=$i?>]" id="ikame_verilis_tarih<?=$i?>" value="<?=FormatTarih::tarih($rows_ikame[$i]->IKAME_VERILIS_TARIH)?>" readonly>
																	        </div>
															          	</td>
															          	<td align="center" style="width: 10%;">
																		    <select name="ikame_verilis_saat[<?=$i?>]" id="ikame_verilis_saat<?=$i?>" class="form-control form-control-sm select2 select2-hidden-accessible" style="width: 100%;">
																		      	<?=$cCombo->CalismaSaatler()->setSecilen($rows_ikame[$i]->IKAME_VERILIS_SAAT)->setSeciniz()->getSelect("ID","AD2")?>
																		    </select>
															          	</td>
															          	<td align="center" style="width: 10%;">
															          		<div class="input-group date">
																	          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300 px-1"><i class="far fa-calendar-alt"></i></span></div>
																	          	<input type="text" class="form-control form-control-sm datepicker datepicker-inline" name="ikame_gelis_tarih[<?=$i?>]" id="ikame_gelis_tarih<?=$i?>" value="<?=FormatTarih::tarih($rows_ikame[$i]->IKAME_GELIS_TARIH)?>" readonly>
																	        </div>
															          	</td>
															          	<td align="center" style="width: 10%;">
																		    <select name="ikame_gelis_saat[<?=$i?>]" id="ikame_gelis_saat<?=$i?>" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
																		      	<?=$cCombo->CalismaSaatler()->setSecilen($rows_ikame[$i]->IKAME_GELIS_SAAT)->setSeciniz()->getSelect("ID","AD2")?>
																		    </select>
															          	</td>
															          	<td align="center" style="width: 10%;">
															          		<div class="input-group date">
																	          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300 px-1"><i class="far fa-calendar-alt"></i></span></div>
																	          	<input type="text" class="form-control form-control-sm datepicker datepicker-inline" name="ikame_kesin_tarih[<?=$i?>]" id="ikame_kesin_tarih<?=$i?>" value="<?=FormatTarih::tarih($rows_ikame[$i]->IKAME_KESIN_TARIH)?>" readonly>
																	        </div>
															          	</td>
															        </tr>
														        <?}?>
													        </tbody>
													    </table>
													    </div>
							                    	</div>
							                    	
													<div class="col-md-4 offset-md-4 text-center">
														<div class="form-group">
												        	<button type="button" class="btn btn-primary waves-effect waves-themed btn-block mt-2" <?=(($row->SUREC_ID == 10)?'disabled':'')?> onclick="fncIkameKaydet(this)"><?=dil("Kaydet")?></button>
												        </div>
													</div>
												</div>
			            					</form>
			            				</div>
			            				<div class="tab-pane <?=($_REQUEST['tab']=='tab_talep_notu')?'active':''?>" id="tab_talep_notu">
						              		<div class="panel-content">
				                                <div class="input-group mb-2">							                			
								                    <input type="text" class="form-control form-control" placeholder="Mesaj yaz" name="talep_notu" id="talep_notu" value="" maxlength="255">
								                    <div class="input-group-append">
								                        <button type="button" class="btn btn-success" id="talep_kaydet" onclick="fncTalepNotuKaydet(this)" data-id="<?=$row->ID?>" data-onay="1" data-kod="<?=$row->KOD?>" title="Kaydet"> <?=dil("Yaz")?> </button>
								                    </div>
								                </div>
				                                <div class="bg-warning-100 border border-warning rounded">
				                                    <div class="input-group p-2 mb-0">
				                                        <input type="text" class="form-control shadow-inset-2 bg-warning-50 border-warning" id="js-list-msg-filter" placeholder="Filtrele">
				                                        <div class="input-group-append">
				                                            <div class="input-group-text bg-warning-500 border-warning">
				                                                <i class="fal fa-search fs-xl"></i>
				                                            </div>
				                                        </div>
				                                    </div>
				                                    <ul id="js-list-msg" class="list-group px-2 pb-2 js-list-filter">
				                                    	<?foreach($rows_talep_notu as $key => $row_talep_notu){?>
				                                    		<li class="list-group-item">
					                                            <span data-filter-tags="<?=strtolower($row_talep_notu->TALEP_NOTU)?>">
											            			<div class="d-flex align-items-center m-0">
							                                            <div class="d-inline-block align-middle mr-2">
							                                                <span class="profile-image-md rounded-circle d-block" style="background-image:url('/img/kullanici_yesil.jpg'); background-size: cover;"></span>
							                                            </div>
							                                            <div class="flex-1 min-width-0">
							                                                <span class="text-truncate"><?=$row_talep_notu->TALEP_NOTU?></span>
							                                                <div class="text-muted small">
							                                                	<?=FormatTarih::tarih($row_talep_notu->TARIH)?>, <?=$row_talep_notu->EKLEYEN?> 
							                                                </div>
							                                            </div>
							                                            <div class="flex-1 min-width-0">
							                                            	<a href="javascript:void(0)" class="btn btn-outline-danger btn-sm float-right" onclick="fncTalepNotuSil(this)" data-id="<?=$row_talep_notu->ID?>" title="<?=dil("Notu Sil")?>"> <i class="far fa-trash"></i> </a>
							                                            </div>
							                                        </div>
						                                        </span>
						                                    </li>
											    		<?}?>
				                                    </ul>
				                                    <div class="filter-message js-filter-message mt-0 fs-sm"></div>
				                                </div>
				                            </div>
						              	</div>
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_resim')?'active':''?>" id="tab_resim">
						              		<div class="row">
							                	<div class="col-lg-6 col-md-6 mb-3">
							                		<form name="formResimSec" id="formResimSec">
														<input type="hidden" name="islem" id="islem" value="talep_resim_sec">
														<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
														<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
															
								                		<div class="panel">
								                		<div class="panel-hdr">
							                                <h2> <i class="fal fa-image fa-2x mr-3"></i> <?=dil("Resim Listesi (Yüklü)")?></h2>
							                                <div class="panel-toolbar">
							                                	<a href="/talep/zip.do?route=talep/zip&id=<?=$row->ID?>" class="btn btn-outline-secondary btn-sm" title="Toplu İndir"> <i class="far fa-download"></i> </a>
							                                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
							                                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
							                                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
							                                </div>
							                            </div>
									                    <div class="panel-container show">
									                        <div class="panel-content">
												              	<table class="table table-sm table-condensed">
												              		<thead class="thead-themed">
													                	<tr>
														                  	<td align="center"><b>#</b></td>
														                  	<td align="center"><b><?=dil("Resim")?></b> </td>
														                  	<td><b><?=dil("Resim Türü")?></b></td>
														                  	<td align="center">
														                  		<a href="javascript:$('.evrak').removeAttr('checked')" title="Hiçbiri">Hiçbiri</a> 
														                  		<a href="javascript:$('.evrak2').attr('checked',true)" title="Onarım Öncesi">Ö</a> 
														                  		<a href="javascript:$('.evrak3').attr('checked',true)" title="Onarım Aşaması">A</a> 
														                  		<a href="javascript:$('.evrak4').attr('checked',true)" title="Onarım Sonrası">S</a>
														                  		<a href="javascript:$('.evrak').attr('checked', true)" title="Tümü">Tümü</a>  
														                  	</td>
														                </tr>
														            </thead>
														            <tbody>
														                <?foreach($rows_resim as $key=>$row_resim) {?>
														                <tr>
														                  	<td align="center"><?=($key+1)?></td>
														                  	<td align="center">													                  	
														                  		<?if(is_file($_SERVER['DOCUMENT_ROOT'].$row_resim->URL)){?>
																	                <a href="<?=$row_resim->URL?>" data-toggle="lightbox" data-gallery="resim-gallery" data-title="<?=$row_resim->EVRAK?>" data-footer="">
																			          	<img src="<?=$row_resim->URL?>" class="img-thumbnail" alt="" width="100px">
																			        </a>
																		        <?} else {?>
																		        	<a href="/img/100x100.png"> <img src="/img/100x100.png" class="img-responsive center-block " style="width:152px;height: 100px"> </a>
																		        <?}?>
																		    </td>
														                  	<td style="padding: 0;"> <?=$row_resim->EVRAK?><br><small><?=$row_resim->RESIM_ADI_ILK?></small><br><?=FormatTarih::tarih($row_resim->TARIH)?> </td>
														                  	<td align="center"> 
														                  		<div class="custom-control custom-checkbox custom-checkbox-circle mt-2">
												                                    <input type="checkbox" class="custom-control-input evrak evrak<?=$row_resim->EVRAK_ID?>" id="resim_sec<?=$row_resim->ID?>" name="resim_sec[<?=$row_resim->ID?>]" value="1">
												                                    <label class="custom-control-label" for="resim_sec<?=$row_resim->ID?>"></label>
												                                </div>
														                  		<br>
														                  		<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="fncResimSil(this)" title="Sil" data-id="<?=$row_resim->ID?>"> <i class="far fa-trash"></i> </a>
														                  		<a href="<?=$row_resim->URL?>" class="btn btn-success btn-sm"> <i class="far fa-download"></i> </a>
														                  		<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="fncTalepResimDondur90(this)" title="90 derece döndür" data-id="<?=$row_resim->ID?>"> <i class="far fa-redo"></i> </a>	
														                  	</td>
														                </tr>
														                <?}?>
														            </tbody>
														            <tbody>
														            	<tr>
														            		<td colspan="100%" align="right">
														            			<a href="javascript:fncResimSecSil(this)" class="btn btn-outline-danger btn-sm" title="Toplu Seç Sil"> <i class="far fa-trash"></i> </a>
														            			<a href="javascript:fncResimSec(this)" class="btn btn-outline-secondary btn-sm" title="Toplu Seç İndir"> <i class="far fa-download"></i> </a>
														            		</td>
														            	</tr>
														            </tbody>
												              	</table>
												            </div>
												        </div>
												        </div>
												    </form>
							    				</div>
							                	<div class="col-lg-6 col-md-6 mb-1">
							                		<div class="panel">
							                		<div class="panel-hdr">
						                                <h2> <i class="fal fa-upload fa-2x mr-3"></i> <?=dil("Evrak Listesi (Yüklü)")?></h2>
						                                <div class="panel-toolbar">
						                                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						                                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						                                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
						                                </div>
						                            </div>
								                    <div class="panel-container show">
								                        <div class="panel-content">
											                <div class="form-group">
													           	<div class="col-sm-12 mb-2">
													           		<label class="form-label"> <?=dil("Resim Türü")?> </label>
													           		<select name="resim_turu_id" id="resim_turu_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" data-id="<?=$row_resim->ID?>">
																		<?=$cCombo->ResimTurleri()->setSecilen($_REQUEST['resim_turu_id'])->getSelect("ID","AD")?>
																	</select>
																</div>
																<div class="col-sm-12">
													           		<input type="file" name="talep_resim[]" id="talep_resim" class="file-loading" data-show-upload="true" data-language="tr" multiple>
													           		<div class="panel-tag mt-2"><?=dil("1000x1000 boyutunda jpg, jpeg, png yükleyiniz.")?></div>
													           	</div>
													        </div>
													    </div>
													</div>
													</div>
									            </div>
							                </div>
						              	</div>	
							            <div class="tab-pane <?=($_REQUEST['tab']=='tab_evrak')?'active':''?>" id="tab_evrak">
						              		<div class="row">
							                	<div class="col-lg-6 col-md-6 mb-1">
							                		<form name="formEvrakSec" id="formEvrakSec">
														<input type="hidden" name="islem" id="islem" value="talep_evrak_sec">
														<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
														<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
							                			
								                		<div class="panel">
								                		<div class="panel-hdr">
							                                <h2> <i class="fal fa-image fa-2x mr-3"></i> <?=dil("Evrak Listesi (Yüklü)")?></h2>
							                                <div class="panel-toolbar">
							                                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
							                                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
							                                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
							                                </div>
							                            </div>
									                    <div class="panel-container show">
									                        <div class="panel-content">
												              	<table class="table table-sm table-condensed">
												              		<thead class="thead-themed">
													                	<tr>
														                  	<td align="center"><b>#</b></td>
														                  	<td align="center"><b><?=dil("Evrak")?></b> </td>
														                  	<td><b><?=dil("Evrak Türü")?></b></td>
														                  	<td> </td>
														                </tr>
														            </thead>
														            <tbody>
														                <?foreach($rows_evrak as $key=>$row_evrak) {?>
														                <tr>
														                  	<td align="center"><?=($key+1)?></td>
														                  	<td align="center">
														                  		<?if(is_file($_SERVER['DOCUMENT_ROOT'].$row_evrak->URL)){?>
																	                <a href="<?=$row_evrak->URL?>" data-toggle="lightbox" data-gallery="evrak-gallery" data-title="<?=$row_evrak->EVRAK?>" data-footer="">
																			          	<img src="<?=$row_evrak->URL?>" class="img-thumbnail" alt="" width="150px">
																			        </a>
																		        <?} else {?>
																		        	<a href="/img/100x100.png" data-gallery="evrak-gallery" data-title="<?=$row_evrak->EVRAK?>" data-footer=""> <img src="/img/100x100.png" class="img-responsive center-block " style="width:152px;height: 100px"> </a>
																		        <?}?>
																		    </td>
														                  	<td style="padding: 0;"> <?=$row_evrak->EVRAK?><br><small><?=$row_evrak->RESIM_ADI_ILK?></small><br><?=FormatTarih::tarih($row_evrak->TARIH)?> </td>
														                  	<td align="center"> 
												                  				<div class="form-group">
																	              	<select name="resim_evrak_id<?=$row_evrak->ID?>" id="resim_evrak_id<?=$row_evrak->ID?>" class="form-control select2 select2-hidden-accessible" style="width: 100%" data-id="<?=$row_evrak->ID?>" onchange="fncEvrakTuruDegistir(this)">
																						<?=$cCombo->EvrakTurleri(array("HASAR"=>1))->setSecilen($row_evrak->EVRAK_ID)->setSeciniz()->getSelect("ID","AD")?>
																					</select>
																	            </div>
														                  		<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="fncResimSil(this)" title="Sil" data-id="<?=$row_evrak->ID?>"> <i class="far fa-trash"></i> </a>
														                  		<a href="<?=$row_evrak->URL?>" class="btn btn-success btn-sm"> <i class="far fa-download"></i> </a>
														                  		<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="fncTalepResimDondur90(this)" title="90 derece döndür" data-id="<?=$row_evrak->ID?>"> <i class="far fa-redo"></i> </a>	
														                  		<br><br><span class="mt-3"><?=FormatTarih::tarih($row_evrak->TARIH)?></span>
														                  	</td>
														                </tr>
														                <?}?>
														            </tbody>
														            <tbody>
														            	<tr>
														            		<td colspan="100%" align="right">
														            			<a href="javascript:fncResimSecSil(this)" class="btn btn-outline-danger btn-sm" title="Toplu Seç Sil"> <i class="far fa-trash"></i> </a>
														            			<a href="javascript:fncResimSec(this)" class="btn btn-outline-secondary btn-sm" title="Toplu Seç İndir"> <i class="far fa-download"></i> </a>
														            		</td>
														            	</tr>
														            </tbody>
												              	</table>
												            </div>
												        </div>
											        	</div>
											        </form>
							    				</div>
							                	<div class="col-lg-6 col-md-6 mb-3">
							                		<div class="panel">
							                		<div class="panel-hdr">
						                                <h2> <i class="fal fa-upload fa-2x mr-3"></i> <?=dil("Evrak Yükle")?></h2>
						                                <div class="panel-toolbar">
						                                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						                                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						                                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
						                                </div>
						                            </div>
								                    <div class="panel-container show">
								                        <div class="panel-content">
											                <div class="form-group">
													           	<div class="col-sm-12 mb-2">
													           		<label class="form-label"> <?=dil("Evrak Türü")?> </label>
													           		<select name="evrak_turu_id" id="evrak_turu_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" data-id="<?=$row_resim->ID?>">
																		<?=$cCombo->EvrakTurleri()->setSecilen($_REQUEST['evrak_turu_id'])->getSelect("ID","AD")?>
																	</select>
																</div>
																<div class="col-sm-12">
													           		<input id="talep_evrak" name="talep_evrak[]" type="file" class="file-loading" data-show-upload="true" data-language="tr" multiple>
													           		<div class="panel-tag mt-2"><?=dil("1000x1000 boyutunda jpg, jpeg, png, pdf yükleyiniz.")?></div>
													           	</div>
													        </div>
													    </div>
													</div>
													</div>
									            </div>
							                </div>
						              	</div>		
						              	<?}?>
						              	
		          					</div>
		          				</div>
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
    </div>
           
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/formplugins/smartwizard/smartwizard.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/piexif.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/purify.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    	
		$("[data-mask]").inputmask();
		
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
        
        if (<?=$_REQUEST['tab']?1:0?>) {
			$('[href="#' + "<?=$_REQUEST['tab']?>" + '"]').tab('show');
		} 
        
		$("#talep_evrak").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=talep_evrak_yukle&id=<?=$row->ID?>',
	        allowedFileExtensions : ['jpg', 'jpeg', 'png', 'pdf'],
	        overwriteInitial: false,
	        maxFileSize: 10000,
	        maxFilesNum: 10,
	        uploadClass: 'btn btn-secondary',
	        removeClass: 'btn btn-secondary',
	        browseClass: 'btn btn-primary btn-file waves-effect waves-themed text-white',
	        uploadAsync: true,
	        //allowedFileTypes: ['image', 'video'],
	        uploadExtraData: function() {
			    return {
			        evrak_id: $('#evrak_turu_id').val(),
			    };
			},
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#talep_evrak').on('filebatchuploadcomplete', function(event, data, previewId, index) {
		   	location.href = "/talep/talep.do?route=talep/servis&tab=tab_evrak&id=<?=$row->ID?>&kod=<?=$row->KOD?>";
		});
		
		$("#talep_resim").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=talep_resim_yukle&id=<?=$row->ID?>',
	        allowedFileExtensions : ['jpg', 'jpeg', 'png', 'pdf'],
	        overwriteInitial: false,
	        maxFileSize: 10000,
	        maxFilesNum: 10,
	        uploadClass: 'btn btn-secondary',
	        removeClass: 'btn btn-secondary',
	        browseClass: 'btn btn-primary btn-file waves-effect waves-themed text-white',
	        uploadAsync: true,
	        //allowedFileTypes: ['image', 'video'],
	        uploadExtraData: function() {
			    return {
			        evrak_id: $('#resim_turu_id').val(),
			    };
			},
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#talep_resim').on('filebatchuploadcomplete', function(event, data, previewId, index) {
		   location.href = "/talep/talep.do?route=talep/servis&tab=tab_resim&id=<?=$row->ID?>&kod=<?=$row->KOD?>";
		});
		
		
		function fncEvrakTuruDegistir(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_evrak_turu_degistir", "id": $(obj).data("id"), "evrak_id": $(obj).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {});
					}
				}
			});
		}
		
		function fncResimSil(obj){
			bootbox.confirm('<?=dil("Silmek istediğinizden emin misiniz")?>!', function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "talep_resim_sil", "id": $(obj).data("id") },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {
									window.location.reload();
								});
							}
						}
					});
				}
			});
			
		}
		
		function fncTalepNotuSil(obj){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem" : "talep_notu_sil", 'talep_notu_id' : $(obj).data("id"), 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>", },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {
									location.reload(true);
								});
							}
						}
					});
				}
			});
		}
		
		$("#talep_notu").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncTalepNotuKaydet($('#talep_kaydet'));
		    }
		});
		
		function fncTalepNotuKaydet(obj){
			if($('#talep_notu').val() == null || $('#talep_notu').val() == ""){
				alert('Notu giriniz!');
				return;
			}
			
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "talep_notu_kaydet", 'id' : $(obj).data("id"), 'kod' : $(obj).data("kod"), 'talep_notu' : $('#talep_notu').val()},
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//location.href = "/talep/popup_servis.do?route=talep/popup_servis&tab=tab_talep_notu&id="+$(obj).data("id")+"&kod="+$(obj).data("kod");
							location.reload();
						});
					}
				}
			});
		}
		
		function fncRandevuKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formRandevu').serialize(),
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
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fncTalepKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formTalep').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA && jd.AYNI_PLAKA){
						$("#ayni_plaka").val(1);
						bootbox.alert(jd.ACIKLAMA, function() {});
					} else if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					} else {
						bootbox.alert(jd.ACIKLAMA, function() {
							window.location.href = jd.URL;
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncSikayetKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formSikayet').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//window.location.href = jd.URL;
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncKontrolKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formKontrol').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncEkspertizParcaKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formEkspertiz').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
							//window.location.href = jd.URL;
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncSigortaBilgileriKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formSigortaBilgileri').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//window.location.href = jd.URL;
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncEkspertizParcaGeldi(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "ekspertiz_parca_geldi", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>", 'parca_id' : $(obj).data("parca_id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$(obj).hide();
						});
					}
					$(obj).removeAttr("disabled");
				}
			});	
		}
		
		function fncEkspertizParcaSil(obj){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "ekspertiz_parca_sil", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>", 'parca_id' : $(obj).data("parca_id") },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {
									$(obj).hide();
								});
							}
							$(obj).removeAttr("disabled");
						}
					});
				}
			});
		}
		
		function fncEkspertizIscilikSil(obj){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "ekspertiz_iscilik_sil", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>", 'parca_id' : $(obj).data("parca_id") },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {
									$(obj).hide();
								});
							}
							$(obj).removeAttr("disabled");
						}
					});
				}
			});	
		}
		
		function fncIkameKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formIkameArac').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							//window.location.href = jd.URL;
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncFaturaKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formFatura').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {});
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncSorumluKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formSorumlu').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {});
					}
					$(obj).removeAttr("disabled");
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
		
		function fncTalepSil(obj){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "talep_sil", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {
									location.href = "/talep/talep_listesi.do?route=talep/talep_listesi&talep_no=<?=$row->ID?>";
								});
							}
							$(obj).removeAttr("disabled");
						}
					});
				}
			});
		}
		
		function fncRandevulu(obj){
			bootbox.confirm("Randevuluya almak istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "talep_randevulu", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {
									location.reload(true);
								});
							}
							$(obj).removeAttr("disabled");
						}
					});
				}
			});
		}
		
		function fncAracServiste(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_arac_serviste", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fncTamireBaslandi(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_tamire_baslandi", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fnTamirBitti(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_tamir_bitti", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fncTeslimeHazir(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_teslime_hazir", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fncTeslimEdildi(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_teslim_edildi", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fncOdemeYapildi(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_odeme_yapildi", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fncTopluIskonto(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_toplu_iskonto_uygula", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>", "toplu_iskonto": $("#toplu_iskonto").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fncTopluSiparisTarih(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_toplu_siparis_tarih_uygula", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>", "toplu_siparis_tarih": $("#toplu_siparis_tarih").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fncCariDoldur(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "cari_doldur" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$("#cari_id").html(jd.HTML);
					}
				}
			});
		}
		
		function fncTalepTarihiKopyala(id){
			$("#ikame_verilis_tarih"+id).val($("input[name='arac_gelis_tarih']").val());
			$("#ikame_verilis_saat"+id).val($("#arac_gelis_saat").val()).trigger("change");
			
			$("#ikame_gelis_tarih"+id).val($("input[name='tahmini_teslim_tarih']").val());
			$("#ikame_gelis_saat"+id).val($("#tahmini_teslim_saat").val()).trigger("change");
		}
		
		function fncPlakaBul(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "plaka_arac_bul", 'plaka': $("#plaka").val(), 'id': "<?=$row->ID?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#cari_id").val(jd.CARI_ID).select2();
							$("#marka_id").val(jd.MARKA_ID).trigger("change");
							$("#model_id").val(-1).select2();
							setTimeout(function(){ $("#model_id").val(jd.MODEL_ID).select2(); }, 3000);
							$("#model_yili").val(jd.MODEL_YILI).select2();
							$("#surucu_ad_soyad").val(jd.SURUCU_AD_SOYAD);
							$("#surucu_tel").val(jd.SURUCU_TEL);
							$("#yakit_turu").val(jd.YAKIT_TURU).select2();
							$("#vites_turu").val(jd.VITES_TURU).select2();
							$("#sasi_no").val(jd.SASI_NO);
							$("#motor_no").val(jd.MOTOR_NO);
							$("#adres").val(jd.ADRES);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncEksperBul(obj){
			fncPopup('/talep/popup_eksper.do?route=talep/popup_eksper&id=:ID&kod=:KOD&eksper='+$('#eksper').val(),'POPUP_EKSPER',900,750);
		}
		
		function fncResimSec(obj){
			fncPopup('/talep/zip_resim_sec.do?route=talep/zip_resim_sec'+$('#formResimSec').serialize(),'POPUP_RESIM_SEC',1100,850);
		}
		
		function fncResimSecSil(obj){
			bootbox.confirm("Silmek istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: $('#formResimSec').serialize() + "&islem=talep_toplu_resim_sil",
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {
									location.reload(true);
								});
							}
							$(obj).removeAttr("disabled");
						}
					});
				}
			});
		}
		
		function fncSayiDb(sayi){
			yeni = sayi.replace('.','').replace(',','.');
			yeni = parseFloat(yeni).toFixed(2);
			return yeni;
		}
		
		function fncSayiTr(sayi){
			yeni = parseFloat(sayi).toFixed(2);
			yeni = yeni.replace(".",",");
			return yeni;
		}
		
		$(".kdvsiz").on('keyup', function (e) {
		    if (e.keyCode == 32) {
		        var tutar = fncSayiDb($(this).val());
				tutar = tutar / 1.18;
				$(this).val(fncSayiTr(tutar));
		    }
		});
		
		
		function fncYazdır(obj){
			var divName= "tab_kontrol";
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
		}
		
	</script>
    
</body>
</html>
