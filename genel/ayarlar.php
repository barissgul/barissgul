<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$rows_site_resim	= $cSubData->getSiteResimler();
	$rows_giris_resim	= $cSubData->getGirisResimler();
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
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/plugin/iCheck/square/blue.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">
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
	    		<div class="col-md-12">
	    			<div class="panel">
                        <div class="panel-hdr bg-primary-300 text-white">
                            <h2> <?=dil("Genel Ayarlar")?> - <?=$row_site->ID?> </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				       			<button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        		<button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                            </div>
                            
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
                        		<ul class="nav nav-tabs justify-content-center" role="tablist">	
                        			<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_site' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_site" data-toggle="tab"> <?=dil("Site Bilgileri")?> </a></li>
						            <li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_logo')?'active':''?>" href="#tab_logo" data-toggle="tab"> <?=dil("Logo")?> </a></li>
						            <li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_arkaplan')?'active':''?>" href="#tab_arkaplan" data-toggle="tab"> <?=dil("Giriş Resim")?> </a></li>
						            <li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_iletisim')?'active':''?>" href="#tab_iletisim" data-toggle="tab"> <?=dil("İletişim")?> </a></li>					            
						            <li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_aciklama')?'active':''?>" href="#tab_aciklama" data-toggle="tab"><?=dil("Açıklamalar")?>  </a></li>
                                </ul>
                                <div class="tab-content p-3">
					              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_site' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_site">
					              		
				              			<form name="formSite" id="formSite" class="" enctype="multipart/form-data" method="POST">
				              				<input type="hidden" name="islem" value="site_kaydet">
				              				<div class="row pt-3">
							              		<div class="col-md-4 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Site Başlık")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="baslik" id="baslik" value="<?=$row_site->BASLIK?>" maxlength="100">
										            </div>
									            </div>						            
									            <div class="col-md-4 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Site Alt Başlık")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="altbaslik" id="altbaslik" value="<?=$row_site->ALTBASLIK?>" maxlength="255">
										            </div>
									            </div>
									            <div class="col-md-4 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Site URL")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="url" id="url" value="<?=$row_site->URL?>" maxlength="45">
										            </div>
									            </div>
									            <div class="col-md-12 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Site Tanımı")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="tanim" id="tanim" value="<?=$row_site->TANIM?>" maxlength="255">
										            </div>
									            </div>
									            <div class="col-md-12 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Site Alt Yazısı")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="altyazi" id="altyazi" value="<?=htmlentities($row_site->ALTYAZI)?>" maxlength="255">
										            </div>
									            </div>
									            <div class="w-100"></div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Firma Adı")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="firma_adi" id="firma_adi" value="<?=$row_site->FIRMA_ADI?>" maxlength="100">
										            </div>
									            </div>						            
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Website URL")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="website_url" id="website_url" value="<?=$row_site->WEBSITE_URL?>" maxlength="100">
										            </div>
									            </div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Logo")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="logo" id="logo" value="<?=$row_site->LOGO?>" maxlength="50">
										            </div>
									            </div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Logos")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="logo2" id="logo2" value="<?=$row_site->LOGO2?>" maxlength="50">
										            </div>
									            </div>
									            <div class="w-100"></div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Site Sahibi")?> </label>
										              	<div class="input-group">
										                  	<div class="input-group-append"><span class="input-group-text fs-sm"><i class="far fa-user"></i></span></div>
										              		<input type="text" class="form-control" placeholder="" name="sahibi" id="sahibi" value="<?=$row_site->SAHIBI?>" maxlength="45">
										              	</div>
										            </div>
									            </div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Vergi Kimlik No")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="tck" id="tck" value="<?=$row_site->TCK?>" maxlength="11">
										            </div>
									            </div>	
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Kuruluş Tarihi")?> </label>
										              	<div class="input-group date">
													       	<div class="input-group-prepend"><span class="input-group-text bg-primary-300"><i class="far fa-calendar-alt"></i></span></div>
													       	<input type="text" class="form-control datepicker datepicker-inline" name="kurulus_tarihi" id="kurulus_tarihi" value="<?=FormatTarih::tarih($row_site->KURULUS_TARIHI)?>" readonly>
													    </div>
										            </div>
									            </div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Tema")?> </label>
										              	<select name="tema_id" id="tema_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;"">
										                  	<?=$cCombo->Temalar()->setSecilen($row_site->TEMA_ID)->getSelect("ID","AD")?>
										                </select>
										            </div>
									            </div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Fatura No")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" value="<?=$row_site->FATURA_NO?>" maxlength="16">
										            </div>
									            </div>
									            <div class="w-100"></div>
									            <div class="col-md-12 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Çalışma Saatleri")?> </label>
										              	<textarea id="calisma_saatleri" name="calisma_saatleri" rows="4" cols="80" class="form-control"><?=$row_site->CALISMA_SAATLERI?></textarea>
										            </div>
									            </div>
									            <div class="col-md-4 offset-4 text-center">
									            	<a href="/cron/cron_oturumlari_sil.do" class="btn btn-danger form-control" style="width: 180px;"><?=dil("Tüm Oturumları Sil")?></a>
									            	<button type="button" class="btn btn-primary form-control" style="width: 180px;" onclick="fncSiteKaydet()"><?=dil("Kaydet")?></button>
									            </div>
									        </div>
							        	</form>
					              	</div>
				              		
					              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_logo')?'active':''?>" id="tab_logo">
					              		<div class="row pt-3">
						                	<div class="col-sm-6">
						    					<div class="panel">
						    					<div class="panel-hdr">
								    				<h2> <i class="fal fa-image fa-2x mr-3"></i> <?=dil("Resim Listesi (Yüklü)")?></h2>
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
												                  	<th style="width: 10px">#</th>
												                  	<th><?=dil("Resim Adı")?></th>
												                  	<th><?=dil("Tarih")?></th>
												                  	<th> </th>
												                </tr>
											                </thead>
											                <tbody>
												                <?foreach($rows_site_resim as $key=>$row_site_resim) {?>
												                <tr>
												                  	<td><?=($key+1)?></td>
												                  	<td><a href="<?=$row_site_resim->RESIM_URL?>" target="_blank" data-gallery> <?=$row_site_resim->RESIM_ADI_ILK?> </a></td>
												                  	<td><?=FormatTarih::tarih($row_site_resim->TARIH)?></td>
												                  	<td>
												                  		<a href="javascript:void(0)" onclick="fncLogoResimSil(this)" title="<?=dil("Sil")?>" data-id="<?=$row_site_resim->ID?>"> <i class="fa fa-trash-o"></i> </a>
												                  		&nbsp;&nbsp;
												                  		<a href="javascript:void(0)" onclick="fncLogoResimAktif(this)" title="<?=($row_site_resim->DURUM==1) ? dil("Aktif") : dil("Aktif Et")?>" data-id="<?=$row_site_resim->ID?>"> <i class="<?=$row_site_resim->DURUM==1 ? 'ion-checkmark-circled' : 'ion-checkmark-round'?>"></i> </a>
												                  	</td>
												                </tr>
												                <?}?>
											                </tbody>
										              	</table>
										            </div>
										        </div>
										        </div>
						    				</div>
						                	<div class="col-sm-6">
								                <div class="form-group">
										           	<div class="col-sm-12">
										           		<input id="site_resim" name="site_resim[]" type="file" class="file-loading" data-show-upload="true" data-language="tr" multiple>
										           		<div class="panel-tag mt-2"><?=dil("1000x1000 boyutunda jpg, jpeg, png yükleyiniz")?></div>
										           	</div>
										        </div>
								            </div>
						                </div>
					              	</div>
					              	
					              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_arkaplan')?'active':''?>" id="tab_arkaplan">
						    			<div class="row pt-3">
							    			<div class="col-sm-6">
								    			<div class="panel">
								    				<div class="panel-hdr">
								    					<h2><?=dil("Resimler")?></h2>
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
													                  	<th style="width: 10px">#</th>
													                  	<th><?=dil("Resim Adı")?></th>
													                  	<th><?=dil("Tarih")?></th>
													                  	<th> </th>
													                </tr>
													            </thead>
													        	<tbody>
													                <?foreach($rows_giris_resim as $key=>$row_giris_resim) {?>
													                <tr>
													                  	<td><?=($key+1)?></td>
													                  	<td><a href="<?=$row_giris_resim->RESIM_URL?>" target="_blank" data-gallery> <?=$row_giris_resim->RESIM_ADI_ILK?> </a></td>
													                  	<td><?=FormatTarih::tarih($row_giris_resim->TARIH)?></td>
													                  	<td>
													                  		<a href="javascript:void(0)" onclick="fncGirisResimSil(this)" title="<?=dil("Sil")?>" data-id="<?=$row_giris_resim->ID?>"> <i class="fa fa-trash-o"></i> </a>
													                  		&nbsp;&nbsp;
													                  		<a href="javascript:void(0)" onclick="fncGirisResimAktif(this)" title="<?=($row_giris_resim->DURUM==1) ? dil("Aktif") : dil("Aktif Et")?>" data-id="<?=$row_giris_resim->ID?>"> <i class="<?=$row_giris_resim->DURUM==1 ? 'ion-checkmark-circled' : 'ion-checkmark-round'?>"></i> </a>
													                  	</td>
													                </tr>
													                <?}?>
													            </tbody>
											              	</table>
											            </div>
											        </div>
											    </div>
								    		</div>
							            	<div class="col-sm-6">
									            <div class="form-group">
										           	<div class="col-sm-12">
										           		<input id="giris_resim" name="giris_resim[]" type="file" class="file-loading" data-show-upload="true" data-language="tr" multiple>
										           		<div class="panel-tag mt-2"><?=dil("1000x1000 boyutunda jpg, png yükleyiniz")?></div>
										           	</div>
										        </div>
									        </div>
						    			</div>
					              	</div>
					              	
					              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_iletisim')?'active':''?>" id="tab_iletisim">					              	
						              	<form name="formIletisim" id="formIletisim" class="" enctype="multipart/form-data" method="POST">
					              			<input type="hidden" name="islem" value="iletisim_kaydet">
					              			
					              			<div class="row">
								          		<div class="col-md-6 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Adres")?> </label>
										              	<input type="text" class="form-control" placeholder="" name="adres" id="adres" value="<?=$row_site->ADRES?>">
										            </div>
									            </div>
									            <div class="col-md-6 mb-2">        
									                <div class="form-group">
													  	<label class="form-label"><?=dil("İl")?> - <?=dil("İlçe")?></label>
													  	<select name="ililce_id" id="ililce_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
													      	<?=$cCombo->UlkedeIlIlceler()->setSecilen($row_site->ILILCE_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
									            </div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Tel1")?> </label>
										              	<div class="input-group">
														    <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														    <input type="text" class="form-control" name="tel1" id="tel1" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row_site->TEL1?>">
														</div>
										            </div>
									            </div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Tel2")?> </label>
										              	<div class="input-group">
														    <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														    <input type="text" class="form-control" name="tel2" id="tel2" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row_site->TEL2?>">
														</div>
										            </div>
									            </div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("Faks")?> </label>
										              	<div class="input-group">
														    <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
														    <input type="text" class="form-control" name="faks" id="faks" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row_site->FAKS?>">
														</div>
										            </div>
									            </div>
									            <div class="col-md-3 mb-2">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("E-mail")?> </label>
										              	<div class="input-group">
										                  	<div class="input-group-prepend"><span class="input-group-text fs-sm"><i class="far fa-envelope"></i></span></div>
										                  	<input type="text" class="form-control pull-right" id="mail" name="mail" value="<?=$row_site->MAIL?>">
										                </div>
										            </div>
									            </div>
									            <div class="col-md-4 offset-4 text-center">
									            	<div class="form-group">
										              	<label class="form-label">&nbsp;</label><br>
									            		<button type="button" class="btn btn-primary form-control" style="width: 120px;" onclick="fncIletisimKaydet()"><?=dil("Kaydet")?></button>
									            	</div>	
									            </div>
									        </div>
								    	</form>
					              	</div>
				              			
					              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_aciklama')?'active':''?>" id="tab_aciklama">
						    			<form name="formAciklama" id="formAciklama" class="" enctype="multipart/form-data" method="POST">
						    				<input type="hidden" name="islem" value="genel_ayarlar_aciklama_kaydet">
						    				
						    				<div class="row pt-3">
								    			<div class="col-lg-6 mb-2">
									                <div class="form-group">
											            <label class="form-label"><?=dil("Sözleşme")?></label>
											            <textarea id="kullanici_sozlesmesi" name="kullanici_sozlesmesi" rows="10" cols="80" class="form-control"><?=$row_site->KULLANICI_SOZLESMESI?></textarea>
											        </div>
									            </div>							                
								    			<div class="col-lg-6 mb-2">
									                <div class="form-group">
											            <label class="form-label"> <?=dil("Hakkında")?> </label>
											            <textarea id="hakkinda" name="hakkinda" rows="10" cols="80" class="form-control"><?=$row_site->HAKKINDA?></textarea>
											        </div>
									            </div>
									            <div class="col-lg-12 mb-2">
									                <div class="form-group">
											            <label class="form-label"> <?=dil("Dikkat Edilmesi Gereken Önemli Hususlar")?> </label>
											            <textarea id="dikkat_edilmesi_gerekenler" name="dikkat_edilmesi_gerekenler" rows="10" cols="80" class="form-control"><?=$row_site->DIKKAT_EDILMESI_GEREKENLER?></textarea>
											        </div>
									            </div>
									            <div class="col-lg-12 mb-2">
									                <div class="form-group">
											            <label class="form-label"> <?=dil("Süreç Açıklaması")?> </label>
											            <textarea id="surec_aciklamasi" name="surec_aciklamasi" rows="10" cols="80" class="form-control"><?=$row_site->SUREC_ACIKLAMASI?></textarea>
											        </div>
									            </div>
									            <div class="col-md-4 offset-4 text-center mb-2">
										           	<button type="button" class="btn btn-primary form-control" onclick="fncAciklamaKaydet()"><?=dil("Kaydet")?></button>
										        </div>
										    </div>
									    </form>
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
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/piexif.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/purify.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.js"></script>
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/ckeditor/ckeditor.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
	<script>
		
		$("[data-mask]").inputmask();
		
		CKEDITOR.replace('kullanici_sozlesmesi');
	  	CKEDITOR.replace('hakkinda');
	  	CKEDITOR.replace('dikkat_edilmesi_gerekenler');
	  	CKEDITOR.replace('surec_aciklamasi');
		
		$('#kurulus_tarihi').datepicker({
			autoclose: true,
			language: 'tr',
			format: 'dd-mm-yyyy',
			keyboardNavigation: true,
		});
	        
		$("#site_resim").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=site_resim_yukle',
	        allowedFileExtensions : ['jpg', 'jpeg', 'png'],
	        overwriteInitial: false,
	        maxFileSize: 10000,
	        maxFilesNum: 10,
	        uploadAsync: true,
	        uploadClass: 'btn btn-secondary',
	        removeClass: 'btn btn-secondary',
	        browseClass: 'btn btn-primary btn-file waves-effect waves-themed text-white',
	        //allowedFileTypes: ['image', 'video'],
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$("#giris_resim").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=giris_resim_yukle',
	        allowedFileExtensions : ['jpg', 'jpeg', 'png'],
	        overwriteInitial: false,
	        maxFileSize: 10000,
	        maxFilesNum: 10,
	        uploadAsync: true,
	        uploadClass: 'btn btn-secondary',
	        removeClass: 'btn btn-secondary',
	        browseClass: 'btn btn-primary btn-file waves-effect waves-themed text-white',
	        //allowedFileTypes: ['image', 'video'],
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#giris_resim, #site_resim').on('fileuploaded', function(event, data, previewId, index) {
		   	location.reload(true);
		});
		
		//$(document).ajaxStart(function() { Pace.restart(); });
		
		function fncIlceDoldur(obj){
			$("#ililce_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "ilce_doldur", 'ulke_id' : $(obj).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$('#ililce_id').html(jd.HTML);
					}
					$("#ililce_id").removeAttr("disabled");
				}
			});
		};
		
		function fncSiteKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formSite').serialize(),
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
		
		function fncTemaKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formTema').serialize(),
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
		
		function fncAciklamaKaydet(){
			CKEDITOR.instances["kullanici_sozlesmesi"].updateElement();
			CKEDITOR.instances["hakkinda"].updateElement();
			CKEDITOR.instances["dikkat_edilmesi_gerekenler"].updateElement();
			CKEDITOR.instances["surec_aciklamasi"].updateElement();
			
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formAciklama').serialize(),
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
		
		function fncIletisimKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formIletisim').serialize(),
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
		
		function fncSeoKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formSeo').serialize(),
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
		
		function fncSosyalAgKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formSosyalAg').serialize(),
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
		
		function fncLogoResimSil(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "logo_resim_sil", "id": $(obj).data("id") },
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
		
		function fncLogoResimAktif(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "logo_resim_aktif", "id": $(obj).data("id") },
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
		
		function fncGirisResimSil(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "giris_resim_sil", "id": $(obj).data("id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.href = "/genel_ayarlar.do?route=genel/ayarlar&tab=tab_arkaplan";
						});
					}
				}
			});
		}
		
		function fncGirisResimAktif(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "giris_resim_aktif", "id": $(obj).data("id") },
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
		
	</script>
	
</body>
</html>
