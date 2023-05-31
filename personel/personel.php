<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row			= $cSubData->getCari($_REQUEST);
	$rows_araba		= $cSubData->getCariArabalar($_REQUEST);
	$rows_evrak		= $cSubData->getCariEvraklar($_REQUEST);
	fncKodKontrol($row);
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
            <li class="breadcrumb-item"><a href="/personel/personel_listesi.do?route=personel/personel_listesi"><?=dil("Personel Listesi")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Personel")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-xl-10 offset-xl-1 col-md-12 col-sm-12">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-gradient">
                        <h2> <?=dil("Personel Bilgileri")?> &nbsp;&nbsp;<span class="badge badge-primary float-right"><?=dil("ID:")?> <?=$row->ID?></span>  &nbsp;&nbsp;<span class="badge badge-primary float-right"><?=dil("CARI_KOD:")?> <?=$row->CARI_KOD?></span> </h2>
                        <div class="panel-toolbar">
                        	<button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
					        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
					        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">							
                        	<form name="formPersonel" id="formPersonel">
								<input type="hidden" name="islem" id="islem" value="personel_kaydet">
								<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
								<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
								
								<div class="row">
									<div class="col-md-12">
										<ul class="nav nav-tabs justify-content-center" role="tablist">
			                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_cari' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_cari" data-toggle="tab"> <?=dil("Personel Bilgisi")?> </a></li>
			                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_maas')?'active':''?>" href="#tab_maas" data-toggle="tab"> <?=dil("Maaş Bilgisi")?> </a></li>
							            	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_evrak')?'active':''?>" href="#tab_evrak" data-toggle="tab"> <?=dil("Evrak")?> </a></li>
			                            </ul>
			                            <div class="tab-content p-3 shadow-1">
						              		<div class="tab-pane <?=($_REQUEST['tab']=='tab_cari' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_cari">						          		
								            	<div class="row">
								            		<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("TCK")?></label>
														  	<input type="text" class="form-control" placeholder="" name="tck" id="tck" maxlength="11" value="<?=$row->TCK?>">
														</div>
													</div>
													<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Ünvan")?></label>
														  	<input type="text" class="form-control" placeholder="" name="cari" id="cari" maxlength="100" value="<?=$row->CARI?>">
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Departman")?></label>
														  	<select name="departman_id" id="departman_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->Departmanlar()->setSecilen($row->DEPARTMAN_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Görev")?></label>
														  	<select name="gorev_id" id="gorev_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->Gorevler()->setSecilen($row->GOREV_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-6 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Adı")?></label>
														  	<input type="text" class="form-control" placeholder="" name="ad" id="ad" maxlength="45" value="<?=$row->AD?>">
														</div>
													</div>
													<div class="col-md-6 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Soyadı")?></label>
														  	<input type="text" class="form-control" placeholder="" name="soyad" id="soyad" maxlength="45" value="<?=$row->SOYAD?>">
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Özel Kod1")?></label>
														  	<input type="text" class="form-control" placeholder="" name="ozel_kod1" id="ozel_kod1" maxlength="20" value="<?=$row->OZEL_KOD1?>">
														</div>
													</div>
													<div class="col-md-3 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Özel Kod2")?></label>
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
														      	<input type="text" class="form-control" name="ceptel" id="ceptel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->CEPTEL?>">
														    </div>
														</div>
										            </div>
										            <div class="col-md-4 mb-2">        
										                <div class="form-group">
														    <label class="form-label"><?=dil("Cep Tel 2")?></label>
														    <div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														      	<input type="text" class="form-control" name="ceptel2" id="ceptel2" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->CEPTEL2?>">
														    </div>
														</div>
										            </div>
										            <div class="col-md-4 mb-2">        
										                <div class="form-group">
														    <label class="form-label"><?=dil("Sabit Tel")?></label>
														    <div class="input-group">
														      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														      	<input type="text" class="form-control" name="tel" id="tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->TEL?>">
														    </div>
														</div>
										            </div>
										            
										            <div class="col-md-12 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Adres")?></label>
														  	<textarea name="adres" id="adres" class="form-control" rows="4" maxlength="255"><?=$row->ADRES?></textarea>
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("İl")?></label>
														  	<select name="il_id" id="il_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" onchange="fncIlceDoldur()">
														      	<?=$cCombo->Iller()->setSecilen($row->IL_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-3 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("İlçe")?></label>
														  	<select name="ilce_id" id="ilce_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->Ilceler(array("il_id"=>$row->IL_ID))->setSecilen($row->ILCE_ID)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-3 text-center">
														<div class="frame-heading mb-0"><?=dil("Durum")?></div>
														<div class="form-check form-check-switch form-check-switch-left">
															<label class="checkbox-inline">
															  	<input type="checkbox" name="durum" id="durum" class="danger" data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" value="1" <?=($row->DURUM=="0"?'':'checked')?>>
															</label>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-sm-3 mb-2"> 
														<div class="form-group">
														    <label class="form-label"><?=dil("İşe Giriş Tarihi")?></label>
														    <div class="input-group date">
														    	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
														      	<input type="text" class="form-control pull-right datepicke5" name="is_bas_tarih" id="is_bas_tarih" value="<?=FormatTarih::tarih($row->IS_BAS_TARIH)?>" readonly>
														    </div>
														</div>
													</div>
													<div class="col-sm-3 mb-2"> 
														<div class="form-group">
														    <label class="form-label"><?=dil("İşden Çıkış Tarihi")?></label>
														    <div class="input-group date">
														    	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
														      	<input type="text" class="form-control pull-right datepicke5" name="is_bit_tarih" id="is_bit_tarih" value="<?=FormatTarih::tarih($row->IS_BIT_TARIH)?>" readonly>
														    </div>
														</div>
													</div>
												</div>
					              			</div>
					              			
					              			<div class="tab-pane <?=($_REQUEST['tab']=='tab_maas')?'active':''?>" id="tab_maas">							            		
								            	<div class="row">
								            		<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Medeni Durumu")?></label>
														  	<select name="evli" id="evli" class="form-control select2 select2-hidden-accessible" style="width: 100%;" onchange="fncMedeniDurum()">
														      	<?=$cCombo->Evli()->setSecilen($row->EVLI)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Eşi Çalışıyor")?></label>
														  	<select name="esi_calisiyor" id="esi_calisiyor" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->EsiCalisiyor()->setSecilen($row->ESI_CALISIYOR)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Çoçuk Sayısı")?></label>
														  	<select name="cocuk_sayisi" id="cocuk_sayisi" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->CocukSayisi()->setSecilen($row->COCUK_SAYISI)->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-2 mb-2">
														<div class="form-group">
														  	<label class="form-label"><?=dil("Dönem")?></label>
														  	<select name="maas_donem" id="maas_donem" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
														      	<?=$cCombo->MaasDonem()->setSecilen($row->MAAS_DONEM)->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-2 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Maaş Net")?></label>
														  	<div class="input-group">
																<input type="text" class="form-control" placeholder="" name="maas_net" id="maas_net" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->MAAS_NET,0)?>">
																<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
															</div>
														</div>
													</div>
													<div class="col-md-2 mb-2">
										            	<div class="form-group">
														  	<label class="form-label"><?=dil("Maaş")?></label>
														  	<div class="input-group">
																<input type="text" class="form-control" placeholder="" name="maas" id="maas" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->MAAS,0)?>" readonly>
																<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
															</div>
														</div>
													</div>													
												</div>
					              			</div>
					              			
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
														                  		<a href="<?=$cSabit->imgPath($row_evrak->URL)?>" data-toggle="lightbox" data-gallery="evrak-gallery" data-title="<?=$row_evrak->EVRAK?>" data-footer="">
																				  	<img src="<?=$cSabit->imgPath($row_evrak->URL)?>" class="img-thumbnail" alt="" width="150px">
																				</a>
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
												           		<div class="panel-tag mt-2"><?=dil("500x500 boyutunda jpg, png yükleyiniz")?></div>
												           	</div>
												        </div>
										            </div>
								                </div>
							              	</div>	
				            			</div>
			            			</div>
			            		</div>
			            		<div class="row">
			            			<div class="col-md-12 mb-2 text-center">
										<div class="form-group">
										  	<label></label><br>
											<button type="button" class="btn btn-primary" onclick="fncPesonelKaydet()" style="width: 120px;"> <?=dil("Kaydet")?> </button>
										</div>
									</div>
			            		</div>
			            	</form>
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
		
		function fncPesonelKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formPersonel').serialize(),
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
		
		function fncIlceDoldur(){
			$("#ilce_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "ilce_doldur", 'il_id' : $("#il_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$('#ilce_id').html(jd.HTML);
					}
					$("#ilce_id").removeAttr("disabled");
				}
			});
		};
		
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
        
        fncMedeniDurum();
        function fncMedeniDurum(){
			if($("#evli").val() == "0"){
				$("#esi_calisiyor").attr("disabled",true);
				$("#cocuk_sayisi").attr("disabled",true);
			} else {
				$("#esi_calisiyor").removeAttr("disabled");
				$("#cocuk_sayisi").removeAttr("disabled");
			}
		}
		
	</script>
    
</body>
</html>
