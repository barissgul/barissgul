<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row 				= $cSubData->getTalep($_REQUEST);
	$row_cari			= $cSubData->getTalepCari($_REQUEST);
	$rows_talep_notu	= $cSubData->getTalepNotlari($_REQUEST);
	$rows_sikayet		= $cSubData->getTalepSikayetler($_REQUEST);
	$rows_sikayet		= arrayIndex($rows_sikayet);	
	
	$rows_parca			= $cSubData->getTalepParcalar($_REQUEST);
	if(count($rows_parca) == 0) {
		$row_parca->SIRA = 1;
		$row_parca->KDV = 18;
		$row_parca->ALIS = 0;
		$rows_parca[] = $row_parca;
	} 
	$rows_iscilik		= $cSubData->getTalepIscilikler($_REQUEST);
	if(count($rows_iscilik) == 0) {
		$row_iscilik->SIRA = 1;
		$row_iscilik->KDV = 18;
		$row_iscilik->ALIS = 0;
		$rows_iscilik[] = $row_iscilik;
	} 
	
	$rows_ikame			= $cSubData->getTalepIkameler($_REQUEST);	
	
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/smartwizard/smartwizard.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.min.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <link rel="stylesheet" href="../smartadmin/plugin/fancybox/dist/jquery.fancybox.min.css">
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
                        	<?if($row->UST_TALEP_ID == 0){?>
                        		<a href="javascript:fncAltDosyaAc(this)" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1 text-white border-white" title="Alt dosya aç"> <i class="fal fa-copy fs-xl"></i></a>
                        	<?} else if($row->UST_TALEP_ID > 0){?>
                        		<span class="badge badge-success ml-3 fs-md mr-1"><?=dil("UstTalepNo")?>: <?=$row->UST_TALEP_ID?></span>
                        	<?}?>
                        	<a href="<?=fncOzetPopupLink($row)?>" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1 text-white border-white" title="Özet"> <i class="fal fa-eye fs-xl"></i></a>
                        	<a href="<?=fncKabulFormuPopupLink($row)?>" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1 text-white border-white" title="Araç Kabul Formu"> <i class="fal fa-car fs-xl"></i></a>
                        	<a href="<?=fncIsEmriPopupLink($row)?>" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1 text-white border-white" title="İş Emri"> <i class="fal fa-list-alt fs-xl"></i></a>
			                <a href="<?=fncTeslimIbraPopupLink($row)?>" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-1 text-white border-white" title="Teslim İbra"> <i class="fal fa-print fs-xl"></i></a>
						    <?if(strlen($row->EFATURA_UUID) > 1){?>
								<a href="<?=fncEFaturaPopupLink($row)?>" class="btn btn-outline-primary btn-icon waves-effect waves-themed text-white border-white mr-1" title="Efatura PDF"> <i class="fal fa-bullseye"></i> </a>
							<?}?>
						    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
						</div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<?if($row->ID > 0){?>
							<h5 class="panel-tag"><span class=""><?=$row->PLAKA?> <?=$row->MARKA?> <?=$row->MODEL?> <?=$row->MODEL_YILI?>, <?=$row->SORUMLU?></span> <span class="float-right"><?=$row->SUREC?> - <?=$row->TALEP_ACAN?> - <?=FormatTarih::tarih($row->TARIH)?> <a href="javascript:void(0)" class="" data-container="body" data-toggle="popover" data-placement="auto" data-html="true" data-trigger="focus" data-content="<?=(dil("Talep Açan:&nbsp;") . $row->TALEP_ACAN)?>" data-original-title="" title="" aria-describedby="popover423209"><i class="fal fa-info"></i> </a></span> </h5>
                        	<?}?>
                        	<div class="row">
                        		<div class="col-md-12">
                        			<ul class="nav nav-tabs justify-content-center" role="tablist">
		                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_talep')?'active':''?>" href="#tab_talep" data-toggle="tab"> <?=dil("Talep")?> </a></li>
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
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_talep')?'active':''?>" id="tab_talep">	
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
													      		<input type="text" class="form-control fs-xl" placeholder="" name="plaka" id="plaka" maxlength="15" value="<?=$row->PLAKA?>" onchange="fncPlakaBul(this)">
													      		<!--
													      		<div class="input-group-append"><button class="btn btn-success waves-effect waves-themed" type="button" title="Plakadan Bul" onclick="fncPlakaBul(this)"><i class="fal fa-search"></i></button></div>
													      		-->
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
													      	<label class="form-label"> <?=dil("Cari")?> 
													      		<a href="javascript:void(0)" onclick="<?=fncCariPopupLink(array())?>" class="ml-3"><i class="far fa-plus-hexagon"></i></a> 
													      		<a href="javascript:void(0)" onclick="fncCariDoldur()" class="ml-3"><i class="far fa-repeat-alt"></i></a> 
													      		<a href="javascript:void(0)" onclick="<?=fncCariPopupLink($row_cari)?>" class="ml-3"><i class="far fa-pencil"></i></a> 
													      	</label>
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
													<div class="col-md-2 mb-2">
														<div class="form-group">
													      	<label class="form-label"> <?=dil("İkame Talebi")?> </label>
													      	<select name="ikame_talebi" id="ikame_talebi" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->IkameTalebi()->setSecilen($row->IKAME_TALEBI)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-2 mb-2">        
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("İkame Veren")?> </label>
													      	<select name="ikame_veren_id" id="ikame_veren_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->IkameVeren()->setSecilen($row->IKAME_VEREN_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
													      	<label class="form-label"> <?=dil("Öncelik")?> (1:Az ... 10:Çok) </label>
													      	<select name="oncelik" id="oncelik" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->Oncelik()->setSecilen($row->ONCELIK)->getSelect("ID","AD")?>
														    </select>
													    </div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
													      	<label class="form-label"> <?=dil("Şikayet Sayısı")?> </label>
													      	<select name="sikayet_sayisi" id="sikayet_sayisi" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->ParcaSayisi()->setSecilen($row->SIKAYET_SAYISI)->getSelect("ID","AD")?>
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
														<?if(in_array($_SESSION['yetki_id'], array(1,2)) AND !in_array($row->SUREC_ID, array(11))){?>
															<div class="col-md-2 text-center">
																<button type="button" class="btn btn-danger waves-effect waves-themed btn-block mt-2" onclick="fncTalepIptal(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Talep İptal")?></button>
															</div>
														<?}?>
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
															          		<input type="text" class="form-control" placeholder="" name="sikayet[]" maxlength="255" value="<?=$rows_sikayet[$i]->SIKAYET?>" onchange="this.value=this.value.turkishToUpper();">
															          	</td>
															          	<td align="center">
															          		<input type="text" class="form-control" placeholder="" name="cozum[]" maxlength="255" value="<?=$rows_sikayet[$i]->COZUM?>" onchange="this.value=this.value.turkishToUpper();">
															          	</td>
															          	<td align="center">
															          		<label class="checkbox-inline">
																			  	<input type="checkbox" class="danger" name="durum[]" data-toggle="toggle" data-on="Çözüldü" data-off="Yok" data-onstyle="success" data-offstyle="danger" data-width="80" data-size="sm" value="1" <?=($rows_sikayet[$i]->DURUM=='1'?'checked':'')?>>
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
															<button type="button" class="btn btn-outline-secondary waves-effect waves-themed mt-2" onclick="fncPopup('/talep/popup_kontrol.do?route=talep/popup_kontrol&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_KONTROL',1100,850);" title="Yazdır"><i class="fal fa-print fs-xl"></i></button>
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
												<input type="hidden" name="parca_sira" id="parca_sira" value="<?=count($rows_parca)?>">
												<input type="hidden" name="iscilik_sira" id="iscilik_sira" value="<?=count($rows_iscilik)?>">
													
												<div class="row">
								            		<div class="col-md-12">
								            			<div class="panel-tag">
			                                                <?=dil("Yedek Parça Listesi ve Fiyatları")?>
			                                            </div>
														<div class="table-responsive">
												  		<table class="table table-sm table-condensed table-hover" id="parcalar">
													  		<thead class="thead-themed fw-500">
														    	<tr>
														          	<td align="center" style="width: 3%;">#</td>
														          	<td align="center" style="width: 12%;"><?=dil("Parça Kodu")?></td>
														          	<td align="center" style="width: 15%;"><?=dil("Parça Adı")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Tedarikçi")?></td>
														          	<td align="center" style="width: 10%;"><?=dil("Sipariş Tarih")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("Adet")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("Alış")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("Fiyat")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("İskonto")?></td>
														          	<td align="center" style="width: 4%;" onclick="fncKdv(1)"><?=dil("Kdv")?></td>
														          	<td align="center" style="width: 8%;"><?=dil("Tutar")?></td>
														          	<td align="center" style="width: 3%;"></td>
														        </tr>
													        </thead>
													        <tbody>
														        <?
														        foreach($rows_parca as $key => $row_parca){
														        	$row_toplam->ADET			+= $row_parca->ADET;
														        	$row_toplam->ALIS			+= $row_parca->ALIS * $row_parca->ADET;
														        	$row_toplam->FIYAT			+= $row_parca->FIYAT * $row_parca->ADET;
														        	$row_toplam->ISKONTOLU		+= $row_parca->ISKONTOLU * $row_parca->ADET;
														        	$row_toplam->TUTAR			+= $row_parca->TUTAR;
														        	?>
															        <tr>
															          	<td align="center" class="bg-gray-100"><?=($row_parca->SIRA)?></td>
															          	<td align="center">
															          		<div class="input-group">
															          			<input type="text" class="form-control form-control-sm" placeholder="" name="yp_parca_kodu[<?=$row_parca->SIRA?>]" id="yp_parca_kodu<?=$row_parca->SIRA?>" maxlength="25" value="<?=$row_parca->PARCA_KODU?>" onchange="this.value=this.value.turkishToUpper();">
															          			<div class="input-group-append hidden-md" data-sira="<?=$row_parca->SIRA?>" onclick="fncParcaBul(this)"><span class="input-group-text fs-sm px-1"><i class="fal fa-plus"></i></span></div>
															          		</div>
															          	</td>
															          	<td align="center">
															          		<input type="text" class="form-control form-control-sm px-sm-1" placeholder="" name="yp_parca_adi[<?=$row_parca->SIRA?>]" id="yp_parca_adi<?=$row_parca->SIRA?>" maxlength="255" value="<?=$row_parca->PARCA_ADI?>" onchange="this.value=this.value.turkishToUpper();">
															          	</td>
															          	<td align="center">
																		    <select name="yp_tedarikci[<?=$row_parca->SIRA?>]" id="yp_tedarikci<?=$row_parca->SIRA?>" class="form-control form-control-sm select2 select2-hidden-accessible" style="width: 100%">
																			  	<?=$cCombo->Tedarikci()->setSecilen($row_parca->TEDARIKCI)->setSeciniz("-1","---")->getSelect("ID","AD")?>
																			</select>
															          	</td>
															          	<td align="center">
															          		<div class="input-group">
																	          	<div class="input-group-prepend"><span class="input-group-text fs-sm px-sm-1"><i class="far fa-calendar-alt"></i></span></div>
																	          	<input type="text" class="form-control form-control-sm datepicker datepicker-inline px-sm-1" id="yp_siparis_tarih<?=$row_parca->SIRA?>" name="yp_siparis_tarih[<?=$row_parca->SIRA?>]" value="<?=FormatTarih::tarih($row_parca->SIPARIS_TARIH)?>" readonly>
																	        </div>
															          	</td>
															          	<td align="center">
																		    <input type="text" class="form-control form-control-sm px-sm-1" placeholder="" name="yp_adet[<?=$row_parca->SIRA?>]" id="yp_adet<?=$row_parca->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_parca->ADET ?: 1, 2)?>" onchange="fncParcaHesap()">
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 bg-transparent pr-0" placeholder="" name="yp_alis[<?=$row_parca->SIRA?>]" id="yp_alis<?=$row_parca->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_parca->ALIS,2)?>" onchange="fncParcaHesap()" onkeyup="fncKdvsiz(event, this)">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 bg-transparent border-left-0"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 bg-transparent pr-0" placeholder="" name="yp_fiyat[<?=$row_parca->SIRA?>]" id="yp_fiyat<?=$row_parca->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_parca->FIYAT,2)?>" onchange="fncParcaHesap()" onkeyup="fncKdvsiz(event, this)">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 bg-transparent border-left-0"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 bg-transparent pr-0" placeholder="" name="yp_iskonto[<?=$row_parca->SIRA?>]" id="yp_iskonto<?=$row_parca->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_parca->ISKONTO,2)?>" onchange="fncParcaHesap()" onkeyup="fncKdvsiz(event, this)">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 bg-transparent border-left-0"><i class="fal fa-percent"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
															          		<div class="custom-control custom-checkbox custom-checkbox-circle">
												                                <input type="checkbox" class="custom-control-input yp_kdv" id="yp_kdv<?=$row_parca->SIRA?>" name="yp_kdv[<?=$row_parca->SIRA?>]" value="18" <?=(($row_parca->KDV > 0)?'checked':'')?> onchange="fncParcaHesap()">
												                                <label class="custom-control-label" for="yp_kdv<?=$row_parca->SIRA?>"></label>
												                            </div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 pr-0" placeholder="" name="yp_tutar[<?=$row_parca->SIRA?>]" id="yp_tutar<?=$row_parca->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_parca->TUTAR,2)?>" readonly>
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 border-left-0"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td class="p-0" nowrap>
															          		<button type="button" class="btn btn-outline-danger btn-icon rounded-circle waves-effect waves-themed" id="btnSatirSil" onclick="fncParcaSatirSil(this)" title="Satır Sil" data-sira="<?=$row_parca->SIRA?>"><i class="fal fa-minus p-2"></i></button>
															          		<?if($row_parca->ID > 0) {?>
															          			<?if(is_null($row_parca->GELDI_TARIH)) {?>
															          				<button type="button" class="btn btn-xs btn-success waves-effect waves-themed" data-parca_id="<?=$row_parca->PARCA_ID?>" onclick="fncEkspertizParcaGeldi(this)" title="Parça Geldi"><i class="fal fa-download"></i></button>
															          				<button type="button" class="btn btn-xs btn-danger waves-effect waves-themed" data-parca_id="<?=$row_parca->PARCA_ID?>" onclick="fncEkspertizParcaSil(this)" title="Parça Sil"><i class="fal fa-times"></i></button>
															          			<?} else {?>
															          				<small><?=FormatTarih::tarih($row_parca->GELDI_TARIH)?></small>
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
														          	<td align="right">
														          		<span id="toplam_parca_adet" class="mr-2"><?=FormatSayi::sayi($row_toplam->ADET,2)?> </span>
														          	</td>
														          	<td align="right">
														          		<span id="toplam_parca_alis" class="mr-1"><?=FormatSayi::sayi($row_toplam->ALIS,2)?> </span> <i class="fal fa-lira-sign mr-0"></i>
														          	</td>
														          	<td align="right">
														          		<span id="toplam_parca_fiyat" class="mr-1"><?=FormatSayi::sayi($row_toplam->FIYAT,2)?> </span> <i class="fal fa-lira-sign mr-0"></i>
														          	</td>
														          	<td align="right">
														          		<span id="toplam_parca_iskontolu" class="mr-1"><?=FormatSayi::sayi(FormatSayi::iskontoOran($row_toplam->FIYAT2, $row_toplam->ISKONTOLU),2)?> </span> <i class="fal fa-percent mr-0"></i>
														          	</td>
														          	<td align="right"></td>
														          	<td align="right">
														          		<span id="toplam_parca_tutar" class="mr-1"><?=FormatSayi::sayi($row_toplam->TUTAR,2)?> </span> <i class="fal fa-lira-sign mr-0"></i>
														          	</td>
														          	<td class="p-0"> 
														          		<button type="button" class="btn btn-outline-primary btn-icon rounded-circle waves-effect waves-themed" id="btnParcaSatirEkle" onclick="fncParcaSatirEkle(this,1)" title="Satır Ekle"><i class="fal fa-plus p-2"></i></button>
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
	                                                    			<button class="btn btn-primary waves-effect waves-themed" <?=(($row->SUREC_ID == 10)?'disabled':'')?> type="button" title="Uygula" onclick="fncTopluIskonto(this)"><i class="fal fa-save"></i></button>
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
	                                                    			<button class="btn btn-primary waves-effect waves-themed" <?=(($row->SUREC_ID == 10)?'disabled':'')?> type="button" title="Uygula" onclick="fncTopluSiparisTarih(this)"><i class="fal fa-save"></i></button>
	                                                			</div>
															</div>
														</td>
													</div>
													<div class="col-md-4 mb-2 text-center">
														<button type="button" class="btn btn-primary waves-effect waves-themed mt-4" <?=(($row->SUREC_ID == 10)?'disabled':'')?> style="width: 120px" onclick="fncEkspertizParcaKaydet(this)"><?=dil("Kaydet")?></button>
													</div>
													<div class="col-md-4">
														<div class="row">
														<div class="col-md-12">
															<div id="ekspetiz_panel" class="panel panel-collapsed mb-0">
							                                    <div class="panel-hdr">
							                                        <h2>
							                                            <?=dil("Ekspertiz")?> <span class="fw-300"><i><?=dil("kopyala çöz")?></i></span>
							                                        </h2>
							                                        <div class="panel-toolbar">
							                                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
							                                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
							                                        </div>
							                                    </div>
							                                    <div class="panel-container collapse" style="">
							                                        <div class="panel-content">
							                                            <div class="form-group">
							                                                <div class="input-group">
							                                                    <textarea name="ekspertiz_kopyala" id="ekspertiz_kopyala" class="form-control" rows="3"></textarea>
							                                                </div>
							                                            </div>
							                                            <div class="form-group text-center">
							                                                <button type="button" class="btn btn-success waves-effect waves-themed mt-4" onclick="fncEkspertizKopyalaCoz(this)"><?=dil("Çöz")?></button>
							                                            </div>
							                                        </div>
							                                    </div>
							                                </div>
							                            </div>
							                            </div>
							                            <div class="row">
														<div class="col-md-12">
															<div id="maintenarena_panel" class="panel panel-collapsed mb-0">
							                                    <div class="panel-hdr">
							                                        <h2>
							                                            <?=dil("Maintenance Arena")?> <span class="fw-300"><i><?=dil("kopyala çöz")?></i></span>
							                                        </h2>
							                                        <div class="panel-toolbar">
							                                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
							                                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
							                                        </div>
							                                    </div>
							                                    <div class="panel-container collapse" style="">
							                                        <div class="panel-content">
							                                            <div class="form-group">
							                                                <div class="input-group">
							                                                    <textarea name="maintenarena_kopyala" id="maintenarena_kopyala" class="form-control" rows="3"></textarea>
							                                                </div>
							                                            </div>
							                                            <div class="form-group text-center">
							                                                <button type="button" class="btn btn-success waves-effect waves-themed mt-4" onclick="fncMaintenarenaKopyalaCoz(this)"><?=dil("Çöz")?></button>
							                                            </div>
							                                        </div>
							                                    </div>
							                                </div>
							                            </div>
							                            </div>
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-md-12">
														<div class="panel-tag">
			                                                <p><?=dil("İşçilik Listesi ve Fiyatları")?></p>
			                                            </div>
														<div class="table-responsive">
												  		<table class="table table-sm table-condensed table-hover" id="iscilikler">
													  		<thead class="thead-themed fw-500">
														    	<tr>
														          	<td align="center" style="width: 3%;">#</td>
														          	<td align="center" style="width: 9%;"><?=dil("Parça Kodu")?></td>
														          	<td align="center" style="width: 15%;"><?=dil("İşçilik Adı")?></td>
														          	<td align="center" style="width: 7%;"><?=dil("Mini Onarım")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Alış")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Onarım")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Boya")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Söktak")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("Fiyat")?></td>
														          	<td align="center" style="width: 9%;"><?=dil("İskonto")?></td>
														          	<td align="center" style="width: 3%;" onclick="fncKdv(2)"><?=dil("Kdv")?></td>
														          	<td align="center" style="width: 12%;"><?=dil("Tutar")?></td>
														          	<td align="center"></td>
														        </tr>
													        </thead>
													        <tbody>
														        <?
														        foreach($rows_iscilik as $key => $row_iscilik){
														        	$row_toplam_is->ALIS		+= $row_iscilik->ALIS;
														        	$row_toplam_is->ONARIM		+= $row_iscilik->ONARIM;
														        	$row_toplam_is->BOYA		+= $row_iscilik->BOYA;
														        	$row_toplam_is->SOKTAK		+= $row_iscilik->SOKTAK;
														        	$row_toplam_is->FIYAT		+= $row_iscilik->FIYAT;
														        	$row_toplam_is->ISKONTOLU	+= $row_iscilik->ISKONTOLU;
														        	$row_toplam_is->TUTAR		+= $row_iscilik->TUTAR;
														        	?>
															        <tr>
															          	<td align="center" class="bg-gray-100"><?=($row_iscilik->SIRA)?></td>
															          	<td align="center" >
															          		<input type="text" class="form-control form-control-sm px-sm-1" placeholder="" name="is_parca_kodu[<?=$row_iscilik->SIRA?>]" id="is_parca_kodu<?=$row_iscilik->SIRA?>" maxlength="25" value="<?=$row_iscilik->PARCA_KODU?>" onchange="this.value=this.value.turkishToUpper();">
															          	</td>
															          	<td align="center">
															          		<input type="text" class="form-control form-control-sm px-sm-1" placeholder="" name="is_parca_adi[<?=$row_iscilik->SIRA?>]" id="is_parca_adi<?=$row_iscilik->SIRA?>" maxlength="255" value="<?=$row_iscilik->PARCA_ADI?>" onchange="this.value=this.value.turkishToUpper();">
															          	</td>
															          	<td align="center">
																		    <select name="is_minionarim_id[<?=$row_iscilik->SIRA?>]" id="is_minionarim_id<?=$row_iscilik->SIRA?>" class="form-control form-control-sm select2 select2-hidden-accessible sm" style="width: 100%">
																			  	<?=$cCombo->MiniOnarımFirmalari()->setSecilen($row_iscilik->MINIONARIM_ID)->setSeciniz("-1","---")->getSelect("ID","AD")?>
																			</select>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 bg-transparent pr-0" placeholder="" name="is_alis[<?=$row_iscilik->SIRA?>]" id="is_alis<?=$row_iscilik->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_iscilik->ALIS,2)?>" onchange="fncIscilikHesap()" onkeyup="fncKdvsiz(event, this)">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 bg-transparent border-left-0"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 bg-transparent pr-0" placeholder="" name="is_onarim[<?=$row_iscilik->SIRA?>]" id="is_onarim<?=$row_iscilik->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_iscilik->ONARIM,2)?>" onchange="fncIscilikHesap()" onkeyup="fncKdvsiz(event, this)">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 bg-transparent border-left-0"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 bg-transparent pr-0" placeholder="" name="is_boya[<?=$row_iscilik->SIRA?>]" id="is_boya<?=$row_iscilik->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_iscilik->BOYA,2)?>" onchange="fncIscilikHesap()" onkeyup="fncKdvsiz(event, this)">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 bg-transparent border-left-0"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 bg-transparent pr-0" placeholder="" name="is_soktak[<?=$row_iscilik->SIRA?>]" id="is_soktak<?=$row_iscilik->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_iscilik->SOKTAK,2)?>" onchange="fncIscilikHesap()" onkeyup="fncKdvsiz(event, this)">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 bg-transparent border-left-0"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 pr-0" placeholder="" name="is_fiyat[<?=$row_iscilik->SIRA?>]" id="is_fiyat<?=$row_iscilik->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_iscilik->FIYAT,2)?>" readonly>
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 border-left-0"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 bg-transparent pr-0" placeholder="" name="is_iskonto[<?=$row_iscilik->SIRA?>]" id="is_iskonto<?=$row_iscilik->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_iscilik->ISKONTO,2)?>" onchange="fncIscilikHesap()">
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 bg-transparent border-left-0"><i class="fal fa-percent"></i></span></div>
																			</div>
															          	</td>
															          	<td align="center">
															          		<div class="custom-control custom-checkbox custom-checkbox-circle">
												                                <input type="checkbox" class="custom-control-input is_kdv" id="is_kdv<?=$row_iscilik->SIRA?>" name="is_kdv[<?=$row_iscilik->SIRA?>]" value="18" <?=(($row_iscilik->KDV > 0)?'checked':'')?> onchange="fncIscilikHesap()">
												                                <label class="custom-control-label" for="is_kdv<?=$row_iscilik->SIRA?>"></label>
												                            </div>
															          	</td>
															          	<td align="center">
																		    <div class="input-group">
																			  	<input type="text" class="form-control form-control-sm px-sm-1 border-right-0 pr-0" placeholder="" name="is_tutar[<?=$row_iscilik->SIRA?>]" id="is_tutar<?=$row_iscilik->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_iscilik->TUTAR,2)?>" readonly>
																			  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-sm-0 border-left-0"><i class="fal fa-lira-sign"></i></span></div>
																			</div>
															          	</td>
															          	<td class="p-0" nowrap>
															          		<button type="button" class="btn btn-outline-danger btn-icon rounded-circle waves-effect waves-themed" id="btnSatirSil" onclick="fncIscilikSatirSil(this)" title="Satır Sil" data-sira="<?=$row_iscilik->SIRA?>"><i class="fal fa-minus p-2"></i></button>
															          		<?if($row_iscilik->ID > 0) {?>
															          			<button type="button" class="btn btn-xs btn-danger waves-effect waves-themed" data-parca_id="<?=$row_iscilik->PARCA_ID?>" onclick="fncEkspertizIscilikSil(this)" title="İşçilik Sil"><i class="fal fa-times"></i></button>
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
														          	<td align="right">
														          		<span id="toplam_iscilik_alis" class="mr-1"><?=FormatSayi::sayi($row_toplam_is->ALIS,2)?> </span> <i class="fal fa-lira-sign mr-0"></i>
														          	</td>
														          	<td align="right">
														          		<span id="toplam_iscilik_onarim" class="mr-1"><?=FormatSayi::sayi($row_toplam_is->ONARIM,2)?> </span> <i class="fal fa-lira-sign mr-0"></i>
														          	</td>
														          	<td align="right">
														          		<span id="toplam_iscilik_boya" class="mr-1"><?=FormatSayi::sayi($row_toplam_is->BOYA,2)?> </span> <i class="fal fa-lira-sign mr-0"></i>
														          	</td>
														          	<td align="right">
														          		<span id="toplam_iscilik_soktak" class="mr-1"><?=FormatSayi::sayi($row_toplam_is->SOKTAK,2)?> </span> <i class="fal fa-lira-sign mr-0"></i>
														          	</td>
														          	<td align="right">
														          		<span id="toplam_iscilik_fiyat" class="mr-1"><?=FormatSayi::sayi($row_toplam_is->FIYAT,2)?> </span> <i class="fal fa-lira-sign mr-0"></i>
														          	</td>
														          	<td align="right">
														          		<span id="toplam_iscilik_iskontolu" class="mr-1"><?=FormatSayi::sayi(FormatSayi::iskontoOran($row_toplam_is->FIYAT, $row_toplam_is->ISKONTOLU),2)?> </span> <i class="fal fa-percent mr-0"></i>
														          	</td>
														          	<td align="right"></td>
														          	<td align="right">
														          		<span id="toplam_iscilik_tutar" class="mr-1"><?=FormatSayi::sayi($row_toplam_is->TUTAR,2)?> </span> <i class="fal fa-lira-sign mr-0"></i>
														          	</td>
														          	<td class="p-0"> 
														          		<button type="button" class="btn btn-outline-primary btn-icon rounded-circle waves-effect waves-themed" id="btnIscilikSatirEkle" onclick="fncIscilikSatirEkle(this)" title="Satır Ekle"><i class="fal fa-plus p-2"></i></button>
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
															<td><?=dil("Toplam İskonto")?> (% <?=FormatSayi::iskontoOran($row_toplam->FIYAT + $row_toplam_is->FIYAT, $row_toplam->ISKONTOLU + $row_toplam_is->ISKONTOLU)?>) </td>
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
														  	<input type="text" class="form-control" placeholder="" name="dosya_no" id="dosya_no" maxlength="40" value="<?=$row->DOSYA_NO?>">
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
															<div class="input-group">	
															  	<input type="text" class="form-control" placeholder="" name="ruhsat_sahibi" id="ruhsat_sahibi" maxlength="100" value="<?=$row->RUHSAT_SAHIBI?>">
															  	<div class="input-group-append"><button class="btn btn-success waves-effect waves-themed" type="button" title="Cari Bilgileri Getir" onclick="fncRuhsatSahibiBul(this)"><i class="fal fa-download"></i></button></div>
														  	</div>
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
															<div class="input-group">	
																<input type="text" class="form-control" placeholder="" name="sigortali_tck" id="sigortali_tck" maxlength="11" value="<?=$row->SIGORTALI_TCK?>">
																<div class="input-group-append"><button class="btn btn-success waves-effect waves-themed" type="button" title="Eksper Bul" onclick="fncSigortaliBul(this)"><i class="fal fa-search"></i></button></div>
														  	</div>
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
													<div class="col-md-8 offset-md-2">
														<table class="table table-bordered table-condensed table-sm fs-md border border-info bg-info-100 mt-3">
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
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_tutar1" id="sigorta_odeme_tutar1" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SIGORTA_ODEME_TUTAR1,2)?>">
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
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_tutar2" id="sigorta_odeme_tutar2" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SIGORTA_ODEME_TUTAR2,2)?>">
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
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_tutar3" id="sigorta_odeme_tutar3" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SIGORTA_ODEME_TUTAR3,2)?>">
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
																<tr>
																	<td align="center">4</td>
																	<td>
																		<div class="input-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_tutar4" id="sigorta_odeme_tutar4" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SIGORTA_ODEME_TUTAR4,2)?>">
																		  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
																		</div>
																	</td>
																	<td>
																		<div class="input-group date">
																          	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
																          	<input type="text" class="form-control datepicker datepicker-inline" name="sigorta_odeme_tarih4" value="<?=FormatTarih::tarih($row->SIGORTA_ODEME_TARIH4)?>" readonly>
																        </div>
																	</td>
																	<td>
																		<div class="form-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_aciklama4" id="sigorta_odeme_aciklama4" maxlength="255" value="<?=$row->SIGORTA_ODEME_ACIKLAMA4?>">
																		</div>
																	</td>
																	
																</tr>
																<tr>
																	<td align="center">5</td>
																	<td>
																		<div class="input-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_tutar5" id="sigorta_odeme_tutar5" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SIGORTA_ODEME_TUTAR5,2)?>">
																		  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
																		</div>
																	</td>
																	<td>
																		<div class="input-group date">
																          	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
																          	<input type="text" class="form-control datepicker datepicker-inline" name="sigorta_odeme_tarih5" value="<?=FormatTarih::tarih($row->SIGORTA_ODEME_TARIH5)?>" readonly>
																        </div>
																	</td>
																	<td>
																		<div class="form-group">
																		  	<input type="text" class="form-control" placeholder="" name="sigorta_odeme_aciklama5" id="sigorta_odeme_aciklama5" maxlength="255" value="<?=$row->SIGORTA_ODEME_ACIKLAMA5?>">
																		</div>
																	</td>
																	
																</tr>
																<tr>
																	<td></td>
																	<td class="text-right fw-900" style="padding-right: 50px;"><?=FormatSayi::sayi($row->SIGORTA_ODEME_TUTAR1+$row->SIGORTA_ODEME_TUTAR2+$row->SIGORTA_ODEME_TUTAR3+$row->SIGORTA_ODEME_TUTAR4+$row->SIGORTA_ODEME_TUTAR5,2)?></td>
																	<td></td>
																	<td></td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="col-2 offset-5 mb-2">
														<div class="form-group">
													        <label class="form-label"><?=dil("Ödeme Talimat Tarihi")?></label>
													        <div class="input-group date">
													          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300"><i class="far fa-calendar-alt"></i></span></div>
													          	<input type="text" class="form-control datepicke4 datepicker-inline" name="sigorta_odeme_talimat_tarih" value="<?=FormatTarih::tarih($row->SIGORTA_ODEME_TALIMAT_TARIH)?>" readonly>
													        </div>
													    </div>
													</div>
													<div class="w-100"></div>
													<div class="col-2 offset-5 text-center">
												        <button type="button" class="btn btn-primary waves-effect waves-themed btn-block mt-2" onclick="fncSigortaBilgileriKaydet(this)"><?=dil("Kaydet")?></button>
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
													<div class="col-md-6 offset-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Açıklama")?></label>
														  	<textarea name="kontrol_aciklama" id="kontrol_aciklama" class="form-control maxlength" maxlength="500" rows="3"><?=$row->KONTROL_ACIKLAMA?></textarea>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-4 offset-md-4 text-center">
														<div class="form-group">
												        	<button type="button" class="btn btn-outline-primary waves-effect waves-themed mt-2" style="width: 120px;" onclick="fncKontrolKaydet(this)"><?=dil("Kaydet")?></button>
												        	<button type="button" class="btn btn-outline-secondary waves-effect waves-themed mt-2" onclick="fncPopup('/talep/popup_kontrol.do?route=talep/popup_kontrol&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_KONTROL',1100,850);" title="Yazdır"><i class="fal fa-print fs-xl"></i></button>
												        	<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncTeslimeHazir(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Araç Bitti ve Sms Gönder")?></button>
												        	<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncTeslimeHazirSmsYok(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Teslime Hazır")?></button>
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
												                    	<div class="col-md-4 mb-2">
																			<div class="form-group">
																			  	<label class="form-label"><?=dil("Fatura No")?></label>
																			  	<div class="input-group">
																			  		<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" maxlength="16" value="<?=$row->FATURA_NO?>">
																			  		<div class="input-group-append"><button class="btn btn-success waves-effect waves-themed" type="button" title="Eksper Bul" onclick="fncYeniFaturaNoBul(this)"><i class="fal fa-search"></i></button></div>
																  				</div>
																			</div>
																		</div>
																		<div class="col-md-4 mb-2 text-center">        
																		    <div class="form-group">
																		      	<label class="form-label"> <?=dil("Tevkifat Oran")?> </label>
																		      	<select name="tevkifat_id" id="tevkifat_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" >
																			      	<?=$cCombo->Tevkifatkar()->setSecilen($row->TEVKIFAT_ID)->setSeciniz()->getSelect("ID","AD")?>
																			    </select>
																		    </div>
																		</div>
																		<div class="col-md-4 mb-2 text-center">        
																		    <div class="form-group">
																		      	<label class="form-label"> <?=dil("Fatura Kes")?> </label>
																		      	<select name="fatura_kes" id="fatura_kes" class="form-control select2 select2-hidden-accessible" style="width: 100%" onchange="fncFaturaKes(this)">
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
												<div class="row mt-3">
													<div class="col-md-12 text-center">
														<a href="javascript:void(0)" onclick="fncPopup('/finans/tahsilat.do?route=finans/tahsilat&cari_id=<?=$row->CARI_ID?>&plaka=<?=$row->PLAKA?>&fatura_tarih=<?=date('Y-m-d')?>','TAHSILAT_EKLE',780,730)" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-2" title="Tahsilat Ekle"> <i class="fal fa-plus"></i></a>
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-md-2 text-center">
														<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncTeslimEdildi(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Teslim Edildi")?></button>
													</div>
													<div class="col-md-2 text-center">
														<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncOdemeYapildi(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("Ödeme Yapıldı")?></button>
													</div>
													<div class="col-md-2 text-center">
														<button type="button" class="btn btn-success waves-effect waves-themed btn-block mt-2" onclick="fncEFaturaEntegrasyon(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("EFatura Entegrasyonu")?></button>
													</div>
													<?if($row->SUREC_ID == 6 AND in_array($_SESSION['yetki_id'],array(1,2))){?>
													<div class="col-md-2 text-center">
														<button type="button" class="btn btn-danger waves-effect waves-themed btn-block mt-2" onclick="fncFaturaBaginiKopar(this)" data-id="<?=$row->ID?>"> <i class="fal fa-angle-double-right"></i> <?=dil("Fatura Bağını Kopar")?></button>
														<button type="button" class="btn btn-danger waves-effect waves-themed btn-block mt-2" data-toggle="modal" data-target="#modalEFaturaDuzenle"> <i class="fal fa-angle-double-right"></i> <?=dil("EFatura Bağla")?></button>
													</div>
													<?}?>
												</div>
			            					</form>
			            				</div>
			            				<div class="tab-pane <?=($_REQUEST['tab']=='tab_ikame')?'active':''?>" id="tab_ikame">	
											<?if($row->IKAME_VEREN_ID == 2){?>
												<form name="formIkameDisardan" id="formIkameDisardan">
												<input type="hidden" name="islem" id="islem" value="talep_ikame_disardan_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
													<div class="row">
														<div class="col-md-3 mb-2">
															<div class="form-group">
															    <label class="form-label"><?=dil("Gün")?></label>
																<input type="text" class="form-control form-control-sm px-sm-1" placeholder="" name="ikame_gun" id="ikame_gun" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->IKAME_GUN,0)?>">
															</div>
														</div>
														<div class="col-md-3 mb-2">
														 	<div class="form-group">
															    <label class="form-label"><?=dil("Maliyet")?></label>
																<div class="input-group">
																  	<input type="text" class="form-control" placeholder="" name="ikame_maliyet" id="ikame_maliyet" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->IKAME_MALIYET,2)?>">
																  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
																</div>
															</div>
														</div>
														<div class="col-md-2 mt-3">
														    <button type="button" class="btn btn-primary waves-effect waves-themed mt-2 w-50" onclick="fncIkameDisardanKaydet(this)"><?=dil("Kaydet")?></button>
														</div>
													</div>
												</form>
											<?}?>
							                <div class="row">
							                	<div class="col-md-12">
							                		<div class="table-responsive">
											  		<table class="table table-sm table-condensed table-hover">
												  		<thead class="thead-themed fw-500">
													    	<tr>
													          	<td align="center">#</td>
													          	<td><?=dil("İkame Araç")?></td>
													          	<td align="center"><?=dil("Veriliş Tarihi")?></td>
													          	<td align="center"><?=dil("Tah.İade Tarihi")?></td>
													          	<td align="center"><?=dil("İade Tarihi")?></td>
													          	<td></td>
													        </tr>
												        </thead>
												        <tbody>
													        <?foreach($rows_ikame as $key => $row_ikame){?>
														        <tr>
														          	<td align="center" class="bg-gray-100" style="width: 3%;"><?=($key+1)?> </td>
														          	<td><?=$row_ikame->PLAKA?> <?=$row_ikame->MARKA?> <?=$row_ikame->MODEL?></td>
														          	<td align="center"><?=FormatTarih::tarih($row_ikame->VERILIS_TARIH)?></td>
														          	<td align="center"><?=FormatTarih::tarih($row_ikame->TAHMINI_IADE_TARIH)?></td>
														          	<td align="center"><?=FormatTarih::tarih($row_ikame->IADE_TARIH)?></td>
														          	<td align="center" style="width: 10%;">
														          		<a href="/ikame/ikame.do?route=ikame/ikame_takip&id=<?=$row_ikame->ID?>&kod=<?=$row_ikame->KOD?>" class="btn btn-outline-primary btn-icon waves-effect waves-themed" title="İkame Düzenle"> <i class="fal fa-edit"></i></a>
														          	</td>
														        </tr>
													        <?}?>
												        </tbody>
												    </table>
												    </div>
							                	</div>
											</div>
											<div class="row mt-3">
												<div class="col-md-12 text-center">
													<a href="/ikame/ikame.do?route=ikame/ikame_takip&talep_id=<?=$row->ID?>&talep_kod=<?=$row->KOD?>" class="btn btn-outline-secondary btn-icon waves-effect waves-themed mr-2" title="İkame Ver"> <i class="fal fa-plus"></i></a>
												</div>
											</div>
			            				</div>
			            				<div class="tab-pane <?=($_REQUEST['tab']=='tab_talep_notu')?'active':''?>" id="tab_talep_notu">
			            					<div class="row">
				                            	<div class="col-md-12">
				                            		<a href="javascript:void()" onclick="fncHazirTalepNotu(this)"><?=dil("ARAÇ PARÇA BEKLİYOR GELİNCE İŞLEM DEVAM EDECEK")?></a>
				                            		&nbsp;&nbsp;&nbsp;
				                            		<a href="javascript:void()" onclick="fncHazirTalepNotu(this)"><?=dil("ARAÇ BOYAYA VERİLDİ")?></a>
				                            		&nbsp;&nbsp;&nbsp;
				                            		<a href="javascript:void()" onclick="fncHazirTalepNotu(this)"><?=dil("ARAÇ BOYANDI TOPLANACAK")?></a>
				                            		&nbsp;&nbsp;&nbsp;
				                            		<a href="javascript:void()" onclick="fncHazirTalepNotu(this)"><?=dil("ARAÇ İŞİ BİTTİ YIKAMA SIRASINDA")?></a>
				                            		&nbsp;&nbsp;&nbsp;
				                            	</div>
				                            </div>
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
							                                                <span class="text-truncate1"><?=$row_talep_notu->TALEP_NOTU?></span>
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
							                                	<a href="javascript:void(0)" onclick="fncPopup('/talep/zip.do?route=talep/zip&id=<?=$row->ID?>','TAHSILAT_EKLE',780,730)" class="btn btn-outline-secondary btn-sm" title="Toplu İndir"> <i class="far fa-download"></i> </a>
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
														                  		<?if(is_pdf($cSabit->imgPathFile($row_resim->URL))){?>
														                  			<i class="fal fa-file-pdf fa-4x"></i>
														                  		<?} else if(is_file($cSabit->imgPathFile($row_resim->URL))){?>
																	                <a href="<?=$cSabit->imgPath($row_resim->URL)?>" data-fancybox="resim-gallery" data-title="<?=$row_resim->EVRAK?> - <?=$row_resim->RESIM_ADI_ILK?>" data-footer="<?=FormatTarih::tarih($row_resim->TARIH)?>">
																			          	<img class="img-thumbnail lazy" alt="" src="/img/loading2.gif" data-src="<?=$cSabit->imgPath($row_resim->URL)?>" width="100"/>
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
														                  		<a href="<?=$cSabit->imgPath($row_resim->URL)?>" target="_blank" class="btn btn-success btn-sm"> <i class="far fa-download"></i> </a>
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
						                                <h2> <i class="fal fa-upload fa-2x mr-3"></i> <?=dil("Resim Yükle")?></h2>
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
													           		<label class="form-label"> <?=dil("Resim Türü")?> <span class="text-danger">*</span> </label>
													           		<select name="resim_turu_id" id="resim_turu_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" data-id="<?=$row_resim->ID?>" onchange="fncResimTuruSec(this)">
																		<?=$cCombo->ResimTurleri()->setSecilen($_REQUEST['resim_turu_id'])->setSeciniz()->getSelect("ID","AD")?>
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
														                  	<td align="center">
														                  		<a href="javascript:$('.eevrak').removeAttr('checked')" title="Hiçbiri">Hiçbiri</a> 
														                  		<a href="javascript:$('.eevrak2').attr('checked',true)" title="Onarım Öncesi">Ö</a> 
														                  		<a href="javascript:$('.eevrak3').attr('checked',true)" title="Onarım Aşaması">A</a> 
														                  		<a href="javascript:$('.eevrak4').attr('checked',true)" title="Onarım Sonrası">S</a>
														                  		<a href="javascript:$('.eevrak').attr('checked', true)" title="Tümü">Tümü</a>  
														                  	</td>
														                </tr>
														            </thead>
														            <tbody>
														                <?foreach($rows_evrak as $key=>$row_evrak) {?>
														                <tr>
														                  	<td align="center"><?=($key+1)?></td>
														                  	<td align="center">
														                  		<?if(is_pdf($cSabit->imgPathFile($row_evrak->URL))){?>
														                  			<a href="<?=$cSabit->imgPath($row_evrak->URL)?>" target="_blank">
																	               		<i class="fal fa-file-pdf fa-5x" style="width: 150px;"></i>
																	               	</a>
														                  		<?} else if(is_file($cSabit->imgPathFile($row_evrak->URL))){?>
																	                <a href="<?=$cSabit->imgPath($row_evrak->URL)?>" data-fancybox="evrak-gallery" data-title="<?=$row_evrak->EVRAK?>" data-footer="">
																			          	<img src="<?=$cSabit->imgPath($row_evrak->URL)?>" class="img-thumbnail" alt="" width="150px">
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
																	            <div class="custom-control custom-checkbox custom-checkbox-circle mb-2">	
												                                    <input type="checkbox" class="custom-control-input eevrak eevrak<?=$row_evrak->EVRAK_ID?>" id="evrak_sec<?=$row_evrak->ID?>" name="evrak_sec[<?=$row_evrak	->ID?>]" value="1">
												                                    <label class="custom-control-label" for="evrak_sec<?=$row_evrak	->ID?>"></label>
												                                </div>
														                  		<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="fncResimSil(this)" title="Sil" data-id="<?=$row_evrak->ID?>"> <i class="far fa-trash"></i> </a>
														                  		<a href="<?=$cSabit->imgPath($row_evrak->URL)?>" target="_blank" class="btn btn-success btn-sm"> <i class="far fa-download"></i> </a>
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
														            			<a href="javascript:fncEvrakSec(this)" class="btn btn-outline-secondary btn-sm" title="Toplu Seç İndir"> <i class="far fa-download"></i> </a>
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
													           		<label class="form-label"> <?=dil("Evrak Türü")?> <span class="text-danger">*</span> </label>
													           		<select name="evrak_turu_id" id="evrak_turu_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" data-id="<?=$row_resim->ID?>" onchange="fncEvrakTuruSec(this)">
																		<?=$cCombo->EvrakTurleri(array("HASAR"=>1))->setSecilen(3)->setSeciniz()->getSelect("ID","AD")?>
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
    
    <div class="modal fade" id="modalEFaturaDuzenle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-500">
                    <h4 class="modal-title"> <?=dil("EFatura Bilgileri Düzenle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formEFaturaDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="efatura_bagla">
	          			<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
	          			<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
	          			<div class="row">
			          		<div class="col-md-12 mb-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Efatura UUID")?> </label>
								  	<input type="text" class="form-control" placeholder="" name="efatura_uuid" id="efatura_uuid" maxlength="100" value="<?=$row->EFATURA_UUID?>">
								</div>
							</div>
							<div class="col-md-12 mb-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Fatura No")?> </label>
								  	<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" maxlength="100" value="<?=$row->FATURA_NO?>">
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
									  	<input type="text" class="form-control" placeholder="" name="fatura_tutar" id="fatura_tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->FATURA_TUTAR,2)?>">
									  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
									</div>
								</div>
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
                	<button type="button" class="btn btn-secondary waves-effect waves-themed" data-dismiss="modal"><?=dil("İptal")?></button>
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncEFaturaKaydet(this)"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
           
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/formplugins/smartwizard/smartwizard.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
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
    <script src="../smartadmin/plugin/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    	
		$("[data-mask]").inputmask();
		$("img.lazy").lazy();
		initdata = $('#formTalep').serialize();
        
        $(window).on( "load", function() {
	        if (<?=$_REQUEST['tab']?1:0?>) {
				$('[href="#' + "<?=$_REQUEST['tab']?>" + '"]').tab('show');
			} 
		});
		
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
		
		$('#talep_evrak').fileinput('disable');
		
		$('#talep_evrak').on('filebatchuploadcomplete', function(event, data, previewId, index) {
		   	location.href = "/talep/talep.do?route=talep/servis&tab=tab_evrak&id=<?=$row->ID?>&kod=<?=$row->KOD?>";
		});
		
		function fncEvrakTuruSec(obj){
			if($(obj).val() > 0){
				$('#talep_evrak').fileinput('enable');
			} else {
				$('#talep_evrak').fileinput('disable');
			}
		}
		
		$("#talep_resim").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=talep_resim_yukle&id=<?=$row->ID?>',
	        allowedFileExtensions : ['jpg', 'jpeg', 'png', 'pdf'],
	        overwriteInitial: false,
	        maxFileSize: 20000,
	        maxFilesNum: 20,
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
		
		window.addEventListener('paste', e => {
		  	$('#talep_resim').files = e.clipboardData.files;
		});
		
		$('#talep_resim').fileinput('disable');
		
		function fncResimTuruSec(obj){
			if($(obj).val() > 0){
				$('#talep_resim').fileinput('enable');
			} else {
				$('#talep_resim').fileinput('disable');
			}
		}
		
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
		
		function fncEFaturaKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formEFaturaDuzenle').serialize(),
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
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
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
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
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
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
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
						toastr.warning(jd.ACIKLAMA);
					}else{
						$(obj).hide();
						toastr.success(jd.ACIKLAMA);
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
								toastr.warning(jd.ACIKLAMA);
							}else{
								$(obj).hide();
								toastr.success(jd.ACIKLAMA);
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
								toastr.warning(jd.ACIKLAMA);
							}else{
								$(obj).hide();
								toastr.success(jd.ACIKLAMA);
							}
							$(obj).removeAttr("disabled");
						}
					});
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
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
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
						toastr.warning(jd.ACIKLAMA);
					}else{
						$(ilce).html(jd.HTML);
						toastr.success(jd.ACIKLAMA);
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
						toastr.warning(jd.ACIKLAMA);
					}else{
						$('#model_id').html(jd.HTML);
						toastr.success(jd.ACIKLAMA);
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
		
		function fncTalepIptal(obj){
			bootbox.confirm("Talep İptal istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "talep_iptal", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
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
			if(initdata != $('#formTalep').serialize()){
				bootbox.alert("Değişiklik yapılmış. Önce kaydet yapıp sonra 'Teslime Hazır' yapınız!", function() {});
			}
			
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_teslime_hazir", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>", 'sms': "1" },
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
		
		function fncTeslimeHazirSmsYok(obj){
			if(initdata != $('#formTalep').serialize()){
				bootbox.alert("Değişiklik yapılmış. Önce kaydet yapıp sonra 'Teslime Hazır' yapınız!", function() {});
			}
			
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_teslime_hazir", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>", 'sms': "0" },
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
		
		function fncEFaturaEntegrasyon(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "talep_efatura_entegrasyon", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
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
						toastr.warning(jd.ACIKLAMA);
					}else{
						$('#cari_id').html(jd.HTML);
						toastr.success(jd.ACIKLAMA);
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
			//$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "plaka_arac_bul", 'plaka': $("#plaka").val(), 'id': "<?=$row->ID?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
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
						toastr.success(jd.ACIKLAMA);
					}
					//$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncSigortaliBul(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "sigortali_bilgilerini_bul", 'sigortali_tck': $("#sigortali_tck").val(), 'id': "<?=$row->ID?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$("#sigortali_tel").val(jd.SIGORTALI_TEL);
						$("#ruhsat_sahibi").val(jd.RUHSAT_SAHIBI);
						toastr.success(jd.ACIKLAMA);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncRuhsatSahibiBul(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "ruhsat_sahibi_bilgilerini_bul", 'id': "<?=$row->ID?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$("#sigortali_tel").val(jd.SIGORTALI_TEL);
						$("#ruhsat_sahibi").val(jd.RUHSAT_SAHIBI);
						$("#sigortali_tck").val(jd.SIGORTALI_TCK);
						toastr.success(jd.ACIKLAMA);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncYeniFaturaNoBul(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "yeni_fatura_no_bul" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$("#fatura_no").val(jd.FATURA_NO);
						toastr.success(jd.ACIKLAMA);
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
		
		function fncEvrakSec(obj){
			fncPopup('/talep/zip_resim_sec.do?route=talep/zip_resim_sec'+$('#formEvrakSec').serialize(),'POPUP_RESIM_SEC',1100,850);
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
		
		function fncEkspertizKopyalaCoz(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "ekspertiz_kopyala_coz", "data": $("#ekspertiz_kopyala").val() },
				dataType: 'json',
				async: false,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						for (i=0; i<jd.DATA.length; i++) {
							k = i + 1;
						 	$("#is_parca_kodu"+k).val(jd.DATA[i].PARCA_KODU);
						 	$("#is_parca_adi"+k).val(jd.DATA[i].PARCA);
						 	$("#is_onarim"+k).val(jd.DATA[i].TAMIR);
						 	$("#is_soktak"+k).val(jd.DATA[i].SOKTAK);
						 	$("#is_boya"+k).val(jd.DATA[i].BOYA);
						 	$("#is_iskonto"+k).val(jd.DATA[i].ISKONTO);
						 	if(i != jd.DATA.length-1 ){
								fncIscilikSatirEkle($("#btnIscilikSatirEkle"),2);
							}
						}
						fncIscilikSirala();
						$("[data-mask]").inputmask();	
						toastr.success(jd.ACIKLAMA);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		
		function fncMaintenarenaKopyalaCoz(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "ekspertiz_maintenarena_kopyala_coz", "data": $("#maintenarena_kopyala").val() },
				dataType: 'json',
				async: false,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						for (i=0; i<jd.DATA_YP.length; i++) {
							k = i + 1;
						 	$("#yp_parca_kodu"+k).val(jd.DATA_YP[i].PARCA_KODU);
						 	$("#yp_parca_adi"+k).val(jd.DATA_YP[i].PARCA);
						 	$("#yp_adet"+k).val(jd.DATA_YP[i].ADET);
						 	$("#yp_fiyat"+k).val(jd.DATA_YP[i].FIYAT);
						 	$("#yp_iskonto"+k).val(jd.DATA_YP[i].ISKONTO);
						 	$("#yp_tutar"+k).val(jd.DATA_YP[i].TUTAR);
						 	if(i != jd.DATA_YP.length-1 ){
								fncParcaSatirEkle($("#btnParcaSatirEkle"),2);
							}
						}						
						for (i=0; i<jd.DATA_IS.length; i++) {
							k = i + 1;
						 	$("#is_parca_kodu"+k).val(jd.DATA_IS[i].PARCA_KODU);
						 	$("#is_parca_adi"+k).val(jd.DATA_IS[i].PARCA);
						 	$("#is_onarim"+k).val(jd.DATA_IS[i].TAMIR);
						 	$("#is_soktak"+k).val(jd.DATA_IS[i].SOKTAK);
						 	$("#is_boya"+k).val(jd.DATA_IS[i].BOYA);
						 	$("#is_fiyat"+k).val(jd.DATA_IS[i].FIYAT);
						 	$("#is_iskonto"+k).val(jd.DATA_IS[i].ISKONTO);
						 	$("#is_tutar"+k).val(jd.DATA_IS[i].TUTAR);
						 	if(i != jd.DATA_IS.length-1 ){
								fncIscilikSatirEkle($("#btnIscilikSatirEkle"),2);
							}
						}
						fncParcaSirala();
						fncIscilikSirala();
						$("[data-mask]").inputmask();	
						toastr.success(jd.ACIKLAMA);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncSayiDb(sayi){
			if(sayi == "NaN" || sayi == "") return 0;
			yeni = sayi.replace('.','').replace(',','.');
			yeni = parseFloat(yeni).toFixed(2);
			return yeni;
		}
		
		function fncSayiTr(sayi){
			yeni = parseFloat(sayi).toFixed(2);
			yeni = yeni.replace(".",",");
			return yeni;
		}
		/*
		$(".kdvsiz").on('keyup', function (e) {
		    if (e.keyCode == 32) {
		        var tutar = fncSayiDb($(this).val());
				tutar = tutar / 1.18;
				$(this).val(fncSayiTr(tutar));
		    }
		});
		*/
		function fncKdvsiz(e, obj){
			if (e.keyCode == 32) {
		        var tutar = fncSayiDb($(obj).val());
				tutar = tutar / 1.18;
				$(obj).val(fncSayiTr(tutar));
		    }
		}
		
		function fncYazdır(obj){
			var divName= "tab_kontrol";
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
		}
		
		function fncKdv(yp_is){
			if(yp_is == 1){
				$(".yp_kdv").attr("checked", !$(".yp_kdv").attr("checked"));
			} else if(yp_is == 2){
				$(".is_kdv").attr("checked", !$(".is_kdv").attr("checked"));
			}
		}
		
		function fncHazirTalepNotu(obj){
			$("#talep_notu").val($(obj).text());
		}
		
		fncFaturaKes($("#fatura_kes"));
		function fncFaturaKes(obj){
			if($(obj).val() == 2){
				$("#fatura_no").attr("readonly",true);
			} else {
				$("#fatura_no").removeAttr("readonly");
			}
		}
		
		function fncIkameDisardanKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formIkameDisardan').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		//Parça
		function fncParcaHesap(obj){
			var toplam_tutar = 0.00;
			var toplam_adet = 0.0;
			var toplam_alis = 0.0; 
			var toplam_fiyat = 0.0; 
			var toplam_isk = 0.0;
			var toplam_kdv = 0.0;
			
			$('#parcalar tbody tr').each(function() {
				var adet = fncSayiDb($(this).find('td:eq(5) input').val());
				var alis = fncSayiDb($(this).find('td:eq(6) input').val());
				var fiyat = fncSayiDb($(this).find('td:eq(7) input').val());
				var isk = (100 - fncSayiDb($(this).find('td:eq(8) input').val())) / 100;
				var kdv = $(this).find('td:eq(9) input').is(":checked") ? 1.18 : 1;
				//console.log(isk);
				isk = ($(this).find('td:eq(8) input').val() == "") ? 1 : isk;
				var tutar = adet * fiyat * isk * kdv;
				
				if(adet > 0 && fiyat > 0) { toplam_fiyat += fiyat * adet; }
				if(adet > 0 && alis > 0) { toplam_alis += alis * adet; }
				if(adet > 0 && fiyat > 0 && isk > 0) { toplam_isk += fiyat * adet * (1.0 - isk); }
				if(adet > 0 && fiyat > 0 && kdv > 1) { toplam_kdv += fiyat * adet * isk * 0.18; }
				if(adet > 0 && fiyat > 0) { toplam_tutar += tutar; }
				if(adet > 0) { toplam_adet += adet * 1;}
				
				$(this).find('td:eq(10) input').val(fncSayiTr(tutar));
				
			});
			$("#toplam_parca_adet").text(fncSayiTr(toplam_adet));
			$("#toplam_parca_alis").text(fncSayiTr(toplam_alis));
			$("#toplam_parca_fiyat").text(fncSayiTr(toplam_fiyat));
			$("#toplam_parca_isk").text(fncSayiTr(toplam_isk));
			$("#toplam_parca_kdv").text(fncSayiTr(toplam_kdv));
			$("#toplam_parca_tutar").text(fncSayiTr(toplam_tutar));
		}
		
		function fncParcaSatirEkle(obj, tek=1) {            
            $('#yp_tedarikci1').select2("destroy");
            var sira = parseInt($("#parca_sira").val()) + 1;
            var tr = $('#parcalar tbody tr:first').clone();
            
            $("#parcalar tbody").append(tr);
            $('#parcalar tbody tr:last').find("#yp_parca_kodu1").attr("name", "yp_parca_kodu[" + sira + "]").attr("id", "yp_parca_kodu" + sira).val("");
            $('#parcalar tbody tr:last').find("div").attr("data-sira", sira);
            $('#parcalar tbody tr:last').find("#yp_parca_adi1").attr("name", "yp_parca_adi[" + sira + "]").attr("id", "yp_parca_adi" + sira).val("");
            $('#parcalar tbody tr:last').find("#yp_tedarikci1").attr("name", "yp_tedarikci[" + sira + "]").attr("id", "yp_tedarikci" + sira).attr("data-select2-id", "yp_tedarikci" + sira);
            $('#parcalar tbody tr:last').find("#yp_siparis_tarih1").attr("name", "yp_siparis_tarih[" + sira + "]").attr("id", "yp_siparis_tarih" + sira).val("");
            $('#parcalar tbody tr:last').find("#yp_adet1").attr("name", "yp_adet[" + sira + "]").attr("id", "yp_adet" + sira).val(1);
            $('#parcalar tbody tr:last').find("#yp_alis1").attr("name", "yp_alis[" + sira + "]").attr("id", "yp_alis" + sira).val(0);
            $('#parcalar tbody tr:last').find("#yp_fiyat1").attr("name", "yp_fiyat[" + sira + "]").attr("id", "yp_fiyat" + sira).val(0);
            $('#parcalar tbody tr:last').find("#yp_iskonto1").attr("name", "yp_iskonto[" + sira + "]").attr("id", "yp_iskonto" + sira).val(0);
            $('#parcalar tbody tr:last').find("#yp_kdv1").attr("name", "yp_kdv[" + sira + "]").attr("id", "yp_kdv" + sira).attr("checked",true);
            $('#parcalar tbody tr:last').find("label").attr("for", "yp_kdv" + sira);
            $('#parcalar tbody tr:last').find("#yp_tutar1").attr("name", "yp_tutar[" + sira + "]").attr("id", "yp_tutar" + sira).val(0);
            $('#yp_tedarikci1').select2();
            $('#yp_tedarikci'+sira).select2();
            $("#parca_sira").val(sira);
            
            if(tek == 1){
				fncParcaSirala();
				$("[data-mask]").inputmask();	
				
				$('.datepicker').datepicker({
				  	format: 'dd.mm.yyyy',
				  	startDate: '-1y',
				  	endDate: '+1y',
				  	minDate: 0,
				  	language: 'tr',
				  	autoclose: true,
				  	todayHighlight: true,
				  	clearBtn: true,
			        orientation: "bottom left",
			        weekStart: 1
				});
			}
        }
        
		function fncParcaSirala() {
            var sira = 1;
            $('#parcalar tbody tr').each(function () {
                $(this).find('td:eq(0)').text(sira++);
            });
        }
        
        function fncParcaSatirSil(obj) {
            if ($('#parcalar tbody tr').length == 1) {
                toastr.warning("Birinci satır silinemez!");
                return false;
            }
            $(obj).parent().parent().remove();
            fncParcaSirala();
        }
        
        //İşçilik 
        function fncIscilikHesap(obj){
			var toplam_tutar = 0.00;
			var toplam_alis = 0.0;
			var toplam_onarim = 0.0;
			var toplam_boya = 0.0;
			var toplam_soktak = 0.0;
			var toplam_fiyat = 0.0; 
			var toplam_isk = 0.0;
			var toplam_kdv = 0.0;
			
			$('#iscilikler tbody tr').each(function() {
				var alis = 1 * fncSayiDb($(this).find('td:eq(4) input').val());
				var onarim = 1 * fncSayiDb($(this).find('td:eq(5) input').val());
				var boya = 1 * fncSayiDb($(this).find('td:eq(6) input').val());
				var soktak = 1 * fncSayiDb($(this).find('td:eq(7) input').val());
				var fiyat = onarim + boya + soktak;
				var isk = (100 - fncSayiDb($(this).find('td:eq(9) input').val())) / 100;
				var kdv = $(this).find('td:eq(10) input').is(":checked") ? 1.18 : 1;
				//console.log(isk);
				isk = ($(this).find('td:eq(9) input').val() == "") ? 1 : isk;
				var tutar = fiyat * isk * kdv;
				
				if(alis > 0) { toplam_alis += alis; }
				if(onarim > 0) { toplam_onarim += onarim; }
				if(boya > 0) { toplam_boya += boya; }
				if(soktak > 0) { toplam_soktak += soktak; }
				if(fiyat > 0) { toplam_fiyat += fiyat; }
				if(fiyat > 0 && isk > 0) { toplam_isk += fiyat * (1.0 - isk); }
				if(fiyat > 0 && kdv > 1) { toplam_kdv += fiyat * isk * 0.18; }
				if(fiyat > 0) { toplam_tutar += tutar; }
				
				$(this).find('td:eq(8) input').val(fncSayiTr(fiyat));
				$(this).find('td:eq(11) input').val(fncSayiTr(tutar));
				
			});
			$("#toplam_iscilik_alis").text(toplam_alis);
			$("#toplam_iscilik_onarim").text(toplam_onarim);
			$("#toplam_iscilik_boya").text(toplam_boya);
			$("#toplam_iscilik_soktak").text(toplam_soktak);
			$("#toplam_iscilik_fiyat").text(fncSayiTr(toplam_fiyat));
			$("#toplam_iscilik_isk").text(fncSayiTr(toplam_isk));
			$("#toplam_iscilik_kdv").text(fncSayiTr(toplam_kdv));
			$("#toplam_iscilik_tutar").text(fncSayiTr(toplam_tutar));
		}
		
		function fncIscilikSatirEkle(obj, tek=1) {
			//$('#is_minionarim_id1').select2("destroy");
            var sira = parseInt($("#iscilik_sira").val()) + 1;
            var tr = $('#iscilikler tbody tr:first').clone();
            $("#iscilikler tbody").append(tr);
            $('#iscilikler tbody tr:last td:eq()').find("#is_parca_kodu1").attr("name", "is_parca_kodu[" + sira + "]").attr("id", "is_parca_kodu" + sira).val("");
            $('#iscilikler tbody tr:last').find("#is_parca_kodu1").attr("name", "is_parca_kodu[" + sira + "]").attr("id", "is_parca_kodu" + sira).val("");
            $('#iscilikler tbody tr:last').find("#is_parca_adi1").attr("name", "is_parca_adi[" + sira + "]").attr("id", "is_parca_adi" + sira).val("");
            $('#iscilikler tbody tr:last').find("#is_minionarim_id1").attr("name", "is_minionarim_id[" + sira + "]").attr("id", "is_minionarim_id" + sira).attr("data-select2-id", "is_minionarim_id" + sira);
            $('#iscilikler tbody tr:last').find("#is_alis1").attr("name", "is_alis[" + sira + "]").attr("id", "is_alis" + sira).val(0);
            $('#iscilikler tbody tr:last').find("#is_onarim1").attr("name", "is_onarim[" + sira + "]").attr("id", "is_onarim" + sira).val(0);
            $('#iscilikler tbody tr:last').find("#is_boya1").attr("name", "is_boya[" + sira + "]").attr("id", "is_boya" + sira).val(0);
            $('#iscilikler tbody tr:last').find("#is_soktak1").attr("name", "is_soktak[" + sira + "]").attr("id", "is_soktak" + sira).val(0);
            $('#iscilikler tbody tr:last').find("#is_fiyat1").attr("name", "is_fiyat[" + sira + "]").attr("id", "is_fiyat" + sira).val(0);
            $('#iscilikler tbody tr:last').find("#is_iskonto1").attr("name", "is_iskonto[" + sira + "]").attr("id", "is_iskonto" + sira).val(0);
            $('#iscilikler tbody tr:last').find("#is_kdv1").attr("name", "is_kdv[" + sira + "]").attr("id", "is_kdv" + sira).attr("checked",true);
            $('#iscilikler tbody tr:last').find("label").attr("for", "is_kdv" + sira);
            $('#iscilikler tbody tr:last').find("#is_tutar1").attr("name", "is_tutar[" + sira + "]").attr("id", "is_tutar" + sira).val(0);
            //$('#is_minionarim_id1').select2();
            //$('#is_minionarim_id'+sira).select2();
            $("#iscilik_sira").val(sira);
            if(tek == 1){
				fncIscilikSirala();
				$("[data-mask]").inputmask();	
			}
        }
        
		function fncIscilikSirala() {
            var sira = 1;
            $('#iscilikler tbody tr').each(function () {
                $(this).find('td:eq(0)').text(sira++);
            });
        }
        
        function fncIscilikSatirSil(obj) {
            if ($('#iscilikler tbody tr').length == 1) {
                toastr.warning("Birinci satır silinemez!");
                return false;
            }
            $(obj).parent().parent().remove();
            fncIscilikSirala();
        }
        
        function fncAltDosyaAc(obj){
			bootbox.confirm("Alt dosya açmak istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "alt_dosya_ac", "id": $("#id").val(), "kod": $("#kod").val() },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
								$(obj).removeAttr("disabled");
							}else{
								toastr.success(jd.ACIKLAMA);
								location.href = jd.URL;
							}
						
						}
					});
				}
			});
		}
		
		function fncParcaBul(obj){
			var parca_kodu = $(obj).parent().children("input").val();
			fncPopup('/finans/popup_stok.do?route=finans/popup_stok&sayfa=servis&parca_kodu='+parca_kodu+"&sira="+$(obj).data("sira"),'POPUP_STOK',1100,850);
		}
		
		function fncFaturaBaginiKopar(obj){
			bootbox.prompt("Silmek için muhasebe şifreni giriniz!", function(sifre){ 
				$.ajax({
					url: '/class/db_kayit.do?',
					type: "POST",
					data: { "islem": "talep_fatura_bagini_kopar", "id": $(obj).data("id"), "sifre": sifre },
					dataType: 'json',
					async: true,
					success: function(jd) {
						if(jd.HATA){
							toastr.warning(jd.ACIKLAMA);
						}else{
							toastr.success(jd.ACIKLAMA);
						}
						$(obj).parent().hide();
					}
				});
			});
			
		}
	</script>
    
</body>
</html>
