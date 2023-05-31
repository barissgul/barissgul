<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row			= $cSubData->getCari($_REQUEST);
	$rows_evrak		= $cSubData->getCariEvraklar($_REQUEST);
	fncKodKontrol($row);
	
	if(is_null($row->ID)){
		$row->MUSTERI_TIPI = "K";
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/formplugins/smartwizard/smartwizard.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.min.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-duallistbox-master/src/bootstrap-duallistbox.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <link rel="stylesheet" href="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.css">
    <?$cBootstrap->getTemaCss()?>
    <style>
    	.panel-hdr{
			height: 30px;
		}
    </style>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
    	<ol class="breadcrumb page-breadcrumb breadcrumb-seperator-1">
            <li class="breadcrumb-item"><a href="/"><?=dil("Kontrol Paneli")?></a></li>
            <li class="breadcrumb-item"><a href="/cari/cari_listesi.do?route=cari/cari_listesi"><?=dil("Cari Listesi")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Cari")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-xl-10 offset-xl-1 col-md-12 col-sm-12">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-500">
                        <h2> <i class="fal fa-user mr-3 fs-lg"></i> <?=dil("Cari Bilgileri")?> &nbsp;&nbsp;<span class="badge badge-warning float-right"><?=dil("ID:")?> <?=$row->ID?></span>  &nbsp;&nbsp;<span class="badge badge-warning float-right"><?=dil("CARI_KOD:")?> <?=$row->CARI_KOD?></span> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				        	<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        	<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">                        								
							<div class="row">
								<div class="col-md-12">
									<ul class="nav nav-tabs justify-content-center" role="tablist">
		                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_cari' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_cari" data-toggle="tab"> <?=dil("Cari Bilgisi")?> </a></li>
		                               	<?if($row->CARI_TURU == "ALIM"){?>
		                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_tedarikci')?'active':''?>" href="#tab_tedarikci" data-toggle="tab"> <?=dil("Tedarikçi")?> </a></li>
		                               	<?}?>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_evrak')?'active':''?>" href="#tab_evrak" data-toggle="tab"> <?=dil("Evrak")?> </a></li>
		                            </ul>
		                            <div class="tab-content p-3 shadow-1">
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_cari' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_cari">						          		
							              	<form name="formCariKaydet" id="formCariKaydet">
												<input type="hidden" name="islem" id="islem" value="cari_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
							            	
								            	<div class="row">
								            		<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Cari Türü")?></label>
														  	<select name="cari_turu" id="cari_turu" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->CariTuru()->setSecilen($row->CARI_TURU)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>	
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Vade")?></label>
														  	<select name="vade" id="vade" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->Vade()->setSecilen($row->VADE)->getSelect("ID","AD")?>
														    </select>
														</div>	
													</div>
													<div class="col-md-2 mb-2">   
													    <div class="form-group">
														  	<label class="form-label"> <?=dil("Para Birim")?> </label>
														  	<select name="para_birim" id="para_birim" class="form-control select2 select2-hidden-accessible" style="width: 100%">
														      	<?=$cCombo->ParaBirim()->setSecilen($row->PARA_BIRIM)->setTumu()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-2 mb-2">
													    <div class="form-group">
													      	<label class="form-label"> <?=dil("Kar Oranı")?> </label>
													      	<div class="input-group">
													      		<input type="text" class="form-control" placeholder="" name="kar_orani" id="kar_orani" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->KAR_ORANI,2)?>" maxlength="12">
													      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-tachometer"></i></span></div>
													      	</div>
													    </div>
													</div>
													<div class="col-md-4 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Vergi Dairesi")?></label>
														  	<input type="text" class="form-control" placeholder="" name="vd" id="vd" maxlength="50" value="<?=$row->VD?>"  onchange="this.value=this.value.turkishToUpper();">
														</div>
													</div>	
													
													<div class="w-100"></div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Şirket Türü")?></label>
														  	<select name="musteri_tipi" id="musteri_tipi" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->MusteriTipi()->setSecilen($row->MUSTERI_TIPI)->getSelect("ID","AD")?>
														    </select>
														</div>	
													</div>
								            		<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("TCK / VKN")?></label>
														  	<input type="text" class="form-control" placeholder="" name="tck" id="tck" maxlength="11" value="<?=$row->TCK?>">
														</div>
													</div>
													<div class="col-md-6 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Cari Ünvan")?></label>
														  	<input type="text" class="form-control" placeholder="" name="cari" id="cari" maxlength="100" value="<?=$row->CARI?>">
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Temsilci")?></label>
														  	<select name="temsilci_id" id="temsilci_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->Temsilciler()->setSecilen($row->TEMSILCI_ID)->getSelect("ID","AD")?>
														    </select>
														</div>	
													</div>
													<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Adı")?></label>
														  	<input type="text" class="form-control" placeholder="" name="ad" id="ad" maxlength="45" value="<?=$row->AD?>">
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Soyadı")?></label>
														  	<input type="text" class="form-control" placeholder="" name="soyad" id="soyad" maxlength="45" value="<?=$row->SOYAD?>">
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Banka")?></label>
														  	<select name="banka_id" id="banka_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->Bankalar()->setSecilen($row->BANKA_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>	
													</div>
								            		<div class="col-md-6 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("IBAN")?></label>
														  	<input type="text" class="form-control" placeholder="" data-inputmask='"mask": "TR99 9999 9999 9999 9999 9999 99"' data-mask name="iban" id="iban" value="<?=$row->IBAN?>">
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Logo Cari Kodu")?></label>
														  	<input type="text" class="form-control" placeholder="" name="ozel_kod1" id="ozel_kod1" maxlength="20" value="<?=$row->OZEL_KOD1?>">
														</div>
													</div>
													<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Logo Grup Kodu")?></label>
														  	<input type="text" class="form-control" placeholder="" name="ozel_kod2" id="ozel_kod2" maxlength="20" value="<?=$row->OZEL_KOD2?>">
														</div>
													</div>
													<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Özel Kod3")?></label>
														  	<input type="text" class="form-control" placeholder="" name="ozel_kod3" id="ozel_kod3" maxlength="20" value="<?=$row->OZEL_KOD3?>">
														</div>
													</div>
													<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Özel Kod4")?></label>
														  	<input type="text" class="form-control" placeholder="" name="ozel_kod4" id="ozel_kod4" maxlength="20" value="<?=$row->OZEL_KOD4?>">
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-6 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Mail")?></label>
														  	<div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
														      	<input type="text" class="form-control" placeholder="" name="mail" id="mail" maxlength="100" value="<?=$row->MAIL?>">
														    </div>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-4 mb-2">        
										                <div class="form-group">
														    <label class="form-label"><?=dil("Cep Tel")?></label>
														    <div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														      	<input type="text" class="form-control" name="ceptel" id="ceptel" data-inputmask='"mask": "999(999) 999-9999"' data-mask value="<?=$row->CEPTEL?>">
														    </div>
														</div>
										            </div>
										            <div class="col-md-4 mb-2">        
										                <div class="form-group">
														    <label class="form-label"><?=dil("Cep Tel 2")?></label>
														    <div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														      	<input type="text" class="form-control" name="ceptel2" id="ceptel2" data-inputmask='"mask": "999(999) 999-9999"' data-mask value="<?=$row->CEPTEL2?>">
														    </div>
														</div>
										            </div>
										            <div class="col-md-4 mb-2">        
										                <div class="form-group">
														    <label class="form-label"><?=dil("Sabit Tel")?></label>
														    <div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														      	<input type="text" class="form-control" name="tel" id="tel" data-inputmask='"mask": "999(999) 999-9999"' data-mask value="<?=$row->TEL?>">
														    </div>
														</div>
										            </div>
										            
										            <div class="col-md-12 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Adres")?></label>
														  	<textarea name="adres" id="adres" class="form-control" rows="4" maxlength="255"><?=$row->ADRES?></textarea>
														</div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"> <?=dil("Ülke")?> </label>
														  	<select name="ulke_id" id="ulke_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" onchange="fncIlDoldur($('#ulke_id'),$('#il_id'),$('#ilce_id'))">
														      	<?=$cCombo->Ulkeler()->setSecilen($row->ULKE_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("İl")?></label>
														  	<select name="il_id" id="il_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" onchange="fncIlceDoldur($('#il_id'),$('#ilce_id'))">
														      	<?=$cCombo->Iller(array("ulke_id"=>$row->ULKE_ID,"il_id"=>$row->IL_ID))->setSecilen($row->IL_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("İlçe")?></label>
														  	<select name="ilce_id" id="ilce_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->Ilceler(array("il_id"=>$row->IL_ID))->setSecilen($row->ILCE_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-2 text-center">
														<div class="frame-heading mb-0"><?=dil("Durum")?></div>
														<div class="form-check form-check-switch form-check-switch-left">
															<label class="checkbox-inline">
															  	<input type="checkbox" name="durum" id="durum" class="danger" data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" value="1" <?=($row->DURUM=="0"?'':'checked')?>>
															</label>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Yazı Fontu Büyüklüğü")?></label>
														  	<select name="font_boyut_id" id="font_boyut_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->FontBoyutlar()->setSecilen($row->FONT_BOYUT_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Tema")?></label>
														  	<select name="tema_id" id="tema_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->Temalar()->setSecilen($row->TEMA_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-3 mb-2 mt-2 text-center">
														<div class="frame-heading mb-0"><?=dil("Mail Gönder")?></div>
														<div class="form-check form-check-switch form-check-switch-left">
															<label class="checkbox-inline">
															  	<input type="checkbox" name="mail_gonder" id="mail_gonder" class="danger" data-toggle="toggle" data-on="Gönderilsin" data-off="İstemiyor" data-onstyle="success" data-offstyle="danger" value="1" <?=($row->MAIL_GONDER==1?'checked':'')?>>
															</label>
														</div>
													</div>
													<div class="col-md-3 mb-2 mt-2 text-center">
														<div class="frame-heading mb-0"><?=dil("Sms Gönder")?></div>
														<div class="form-check form-check-switch form-check-switch-left">
															<label class="checkbox-inline">
															  	<input type="checkbox" name="sms_gonder" id="sms_gonder" class="danger" data-toggle="toggle" data-on="Gönderilsin" data-off="İstemiyor" data-onstyle="success" data-offstyle="danger" value="1" <?=($row->SMS_GONDER==1?'checked':'')?>>
															</label>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-12 mb-2 text-center">
														<div class="form-group">
														  	<label></label><br>
															<button type="button" class="btn btn-primary" onclick="fncCariKaydet()" style="width: 150px;"> <?=dil("Kaydet")?> </button>
														</div>
													</div>
												</div>
											</form>
					              		</div>
						              	<?if($row->CARI_TURU == "ALIM"){?>
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_tedarikci')?'active':''?>" id="tab_tedarikci">						          		
							              	<form name="formTedarikciKaydet" id="formTedarikciKaydet">
												<input type="hidden" name="islem" id="islem" value="cari_tedarikci_kaydet">
												<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
												<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
							            		
								            	<div class="row">
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("İskonto1")?></label>
														  	<div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-percent"></i></span></div>
														      	<input type="text" class="form-control" placeholder="" name="iskonto1" id="iskonto1" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->ISKONTO1,2)?>" maxlength="10">
														    </div>
														</div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("İskonto2")?></label>
														  	<div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-percent"></i></span></div>
														      	<input type="text" class="form-control" placeholder="" name="iskonto2" id="iskonto2" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->ISKONTO2,2)?>" maxlength="10">
														    </div>
														</div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("İskonto3")?></label>
														  	<div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-percent"></i></span></div>
														      	<input type="text" class="form-control" placeholder="" name="iskonto3" id="iskonto3" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->ISKONTO3,2)?>" maxlength="10">
														    </div>
														</div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Stoksuz Durum")?></label>
														  	<select name="stoksuz_durum" id="stoksuz_durum" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->StoksuzDurum()->setSecilen($row->STOKSUZ_DURUM)->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="row"></div>
													<div class="col-md-12">
												    	<div class="form-group">
												      		<label class="form-label"> </label>
												        	<select name="parca_marka_ids[]" id="parca_marka_ids" class="form-control" style="width: 100%; height: 250px" data-tags="true" data-placeholder="Kime" data-allow-clear="true" multiple='multiple'>
																<?=$cCombo->ParcaMarkalarTedarikci(array("tedarikci_id"=>$row->ID))->setSecilen($row->PARCA_MARKA_IDS)->getSelect("ID","AD")?>
															</select>
														</div>
												    </div>	
													<div class="w-100"></div>
													<div class="col-md-12 mb-2 text-center">
														<div class="form-group">
														  	<label></label><br>
															<button type="button" class="btn btn-primary" onclick="fncTedarikciKaydet()" style="width: 150px;"> <?=dil("Kaydet")?> </button>
														</div>
													</div>
												</div>
											</form>
					              		</div>
						              	<?}?>
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_evrak')?'active':''?>" id="tab_evrak">
						              		<div class="row">
							                	<div class="col-md-6">
							    					<div class="panel">
							    					<div class="panel-hdr">
						                                <h2> <i class="fal fa-upload fa-2x mr-3"></i> <?=dil("Evrak Yükle")?></h2>
						                                <div class="panel-toolbar">
						                                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						                                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						                                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
						                                </div>
						                            </div>
											    	<div class="panel-container">
								                        <div class="panel-content">
								                        	<div class="panel-tag"><?=dil("Yüklü olan resimler")?></div>
											              	<table class="table table-condensed">
											              		<thead class="thead-themed">
												                	<tr>
													                  	<th style="width: 10px">#</th>
													                  	<th><?=dil("Resim Adı")?></th>
													                  	<th><?=dil("Tarih")?></th>
													                  	<th> </th>
													                </tr>
													            </thead>
													            <tbody>
													                <?foreach($rows_evrak as $key=>$row_evrak) {?>
													                <tr>
													                  	<td><?=($key+1)?></td>
													                  	<td>
													                  		<?if(is_pdf($cSabit->imgPathFile($row_evrak->URL))){?>
														                  		<a href="<?=$cSabit->imgPath($row_evrak->URL)?>" target="_blank">
																               		<i class="fal fa-file-pdf fa-5x" style="width: 150px;"></i>
																               	</a>
														                  	<?} else {?>
																				<a href="<?=$cSabit->imgPath($row_evrak->URL)?>" data-toggle="lightbox" data-gallery="evrak-gallery" data-title="<?=$row_evrak->EVRAK?>" data-footer="">
																				  	<img src="<?=$cSabit->imgPath($row_evrak->URL)?>" class="img-thumbnail" alt="" width="150px">
																				</a>
																			<?}?>
													                  	</td>
													                  	<td><?=FormatTarih::tarih($row_evrak->TARIH)?></td>
													                  	<td>
													                  		<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="fncResimSil(this)" title="Sil" data-id="<?=$row_evrak->ID?>"> <i class="far fa-trash"></i> </a>
													                  		<a href="<?=$cSabit->imgPath($row_evrak->URL)?>" class="btn btn-success btn-sm"> <i class="far fa-download"></i> </a>
													                  	</td>
													                </tr>
													                <?}?>
													            </tbody>
											              	</table>
											            </div>
											        </div>
											        </div>
							    				</div>
							                	<div class="col-md-6">
									                <div class="form-group">
											           	<div class="col-sm-12">
											           		<input id="cari_evrak" name="cari_evrak[]" type="file" class="file-loading" data-show-upload="true" data-language="tr" multiple>
											           		<div class="panel-tag mt-2"><?=dil("1000X1000 boyutunda jpg, png yükleyiniz")?></div>
											           	</div>
											        </div>
									            </div>
							                </div>
						              	</div>		
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
    <script src="../smartadmin/plugin/bootstrap-duallistbox-master/src/jquery.bootstrap-duallistbox.js"></script>
    <script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		var parca_marka_ids = $('select[name="parca_marka_ids[]"]').bootstrapDualListbox({
			nonSelectedListLabel: '<label class="form-label"> Markalar </label>',
  			selectedListLabel: '<label class="form-label"> Yasak Markalar </label>',
		});
		
		$("#cari_evrak").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=cari_evrak_yukle&id=<?=$row->ID?>',
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
		
		$('#cari_evrak').on('filebatchuploadcomplete', function(event, data, previewId, index) {
		   	location.reload(true);
		});
		
		function fncCariKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formCariKaydet').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						location.reload(true);
					}
				}
			});
		}
		
		function fncTedarikciKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formTedarikciKaydet').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
					}
				}
			});
		}
		
		function fncResimAktif(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "cari_evrak_aktif", "id": $(obj).data("id"), "kod": $(obj).data("kod") },
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
		
		function fncSifreSmsGonder(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "sifre_sms_gonder", "id": $(obj).data("id"), "kod": $(obj).data("kod") },
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
		
		function fncResimSil(obj){
			bootbox.confirm('<?=dil("Silmek istediğinizden emin misiniz")?>!', function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "cari_evrak_sil", "id": $(obj).data("id") },
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
		
		function fncIlDoldur(ulke, il, ilce){
			$(il).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "il_doldur", 'ulke_id' : $(ulke).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
						$(il).html("<option value='-1'>-- Seçiniz --</option>");
						$(ilce).html("<option value='-1'>-- Seçiniz --</option>");
					}else{
						toastr.success(jd.ACIKLAMA);
						$(il).html(jd.HTML);
					}
					$(il).removeAttr("disabled");
				}
			});
		};
		
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
						$(ilce).html("<option value='-1'>-- Seçiniz --</option>");
					}else{
						toastr.success(jd.ACIKLAMA);
						$(ilce).html(jd.HTML);
					}
					$(ilce).removeAttr("disabled");
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
