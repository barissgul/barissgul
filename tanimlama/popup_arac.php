<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row = $cSubData->getArac($_REQUEST);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
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
    	<!--
    	<ol class="breadcrumb page-breadcrumb breadcrumb-seperator-1">
            <li class="breadcrumb-item"><a href="/"><?=dil("Kontrol Paneli")?></a></li>
            <li class="breadcrumb-item"><a href="/kiralama/arac_listesi.do?route=kiralama/arac_listesi"><?=dil("Araç Listesi")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Araç")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        -->
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12">		          	
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-gradient">
                        <h2> <?=dil("Araç Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<form name="formAracKaydet" id="formAracKaydet">
							<input type="hidden" name="islem" id="islem" value="arac_kaydet">
							<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
							<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
							
							<div class="row">
								<div class="col-md-12">
									<?if($_SESSION["hizmet_noktasi"] === "0"){?>
										<?if($row->ID > 0){?>
											<div class="panel-tag"><?=$row->MUSTERI?> <button type="button" class="btn btn-sm btn-outline-primary waves-effect waves-themed float-right"><?=dil("Tüm Araçları")?></button> </div>
										<?} else {?>
											<div class="form-group text-center fs-lg">
											  	<label class="form-label"> <?=dil("Müşteri")?> </label>
											  	<select name="musteri_id" id="musteri_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
											      	<?=$cCombo->Musteriler()->setSecilen($_REQUEST['musteri_id'])->setSeciniz()->getSelect("ID","AD")?>
											    </select>
											</div>
										<?}?>
									<?}?>
									<ul class="nav nav-tabs justify-content-center" role="tablist">
		                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_arac' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_arac" data-toggle="tab"> <i class="fal fa-car text-success"></i> <span class="hidden-sm-down ml-1"><?=dil("Araç Bilgisi")?></span> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_surucu')?'active':''?>" href="#tab_surucu" data-toggle="tab"> <i class="fal fa-user text-success"></i> <span class="hidden-sm-down ml-1"><?=dil("Sürücü Bilgisi")?></span> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_ruhsat')?'active':''?>" href="#tab_ruhsat" data-toggle="tab"> <i class="fal fa-book text-success"></i> <span class="hidden-sm-down ml-1"><?=dil("Ruhsat Sahibi")?></span> </a></li>
		                            </ul>
		                            <div class="tab-content p-3 shadow-1">
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_arac' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_arac">						          		
							            	<div class="row">
							            		<div class="col-md-4 mb-3">
									            	<div class="form-group">
													  	<label class="form-label"><?=dil("Plaka")?></label>
													  	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" maxlength="15" value="<?=$row->PLAKA?>">
													</div>
												</div>
												<div class="w-100"></div>
								          		<div class="col-md-4 mb-3">
													<div class="form-group">
												      	<label class="form-label"> <?=dil("Marka")?> </label>
												      	<select name="marka_id" id="marka_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" onchange="fncModelDoldur()">
													      	<?=$cCombo->Markalar()->setSecilen($row->MARKA_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
												    </div>
												</div>
												<div class="col-md-8 mb-3">        
											        <div class="form-group">
												      	<label class="form-label"> <?=dil("Model")?> </label>
												      	<select name="model_id" id="model_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
													      	<?=$cCombo->MarkaModeller(array("marka_id"=>$row->MARKA_ID))->setSecilen($row->MODEL_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
												    </div>
											    </div>
											    <div class="col-md-4 mb-3">        
											        <div class="form-group">
												      	<label class="form-label"> <?=dil("Model Yılı")?> </label>
												      	<select name="model_yili" id="model_yili" class="form-control select2 select2-hidden-accessible" style="width: 100%">
													      	<?=$cCombo->ModelYillari()->setSecilen($row->MODEL_YILI)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
												    </div>
											    </div>
											    <div class="col-md-4 mb-3">        
											        <div class="form-group">
												      	<label class="form-label"> <?=dil("Yakıt Türü")?> </label>
												      	<select name="yakit_id" id="yakit_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
													      	<?=$cCombo->YakitTuru()->setSecilen($row->YAKIT_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
												    </div>
											    </div>
											    <div class="col-md-4 mb-3">        
											        <div class="form-group">
												      	<label class="form-label"> <?=dil("Vites Türü")?> </label>
												      	<select name="vites_id" id="vites_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
													      	<?=$cCombo->VitesTuru()->setSecilen($row->VITES_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
												    </div>
											    </div>
											    <div class="w-100"></div>
											    <div class="col-md-4 mb-3">
									            	<div class="form-group">
													  	<label class="form-label"><?=dil("Şasi No")?></label>
													  	<input type="text" class="form-control" placeholder="" name="sasi_no" id="sasi_no" maxlength="20" value="<?=$row->SASI_NO?>">
													</div>
												</div>
												<div class="col-md-4 mb-3">
									            	<div class="form-group">
													  	<label class="form-label"><?=dil("Motor No")?></label>
													  	<input type="text" class="form-control" placeholder="" name="motor_no" id="motor_no" maxlength="10" value="<?=$row->MOTOR_NO?>">
													</div>
												</div>
												<div class="col-md-4 mb-3">        
									                <div class="form-group">
										              	<label class="form-label"> <?=dil("KM")?> </label>
										              	<div class="input-group">
												      		<input type="text" class="form-control" placeholder="" name="son_km" id="son_km" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 0" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SON_KM,0)?>" maxlength="10">
												      		<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-tachometer"></i></span></div>
												      	</div>
										            </div>
									            </div>
											</div>
					              		</div>
					              		
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_surucu')?'active':''?>" id="tab_surucu">
						              		<div class="row">
						              			<div class="col-md-4 mb-3">
										        	<div class="form-group">
														<label class="form-label"><?=dil("TCK")?></label>
														<input type="text" class="form-control" placeholder="" name="surucu_tck" id="surucu_tck" maxlength="11" value="<?=$row->SURUCU_TCK?>">
													</div>
												</div>
							                	<div class="col-md-4 mb-3">
										        	<div class="form-group">
													  	<label class="form-label"><?=dil("Adı")?></label>
													  	<input type="text" class="form-control" placeholder="" name="surucu_ad" id="surucu_ad" maxlength="50" value="<?=$row->SURUCU_AD?>">
													</div>
												</div>
												<div class="col-md-4 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Soyadı")?></label>
													  	<input type="text" class="form-control" placeholder="" name="surucu_soyad" id="surucu_soyad" maxlength="50" value="<?=$row->SURUCU_SOYAD?>">
													</div>
												</div>
												<div class="col-md-4 mb-3">        
										            <div class="form-group">
													    <label class="form-label"><?=dil("Sabit Tel")?></label>
													    <div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
													      	<input type="text" class="form-control" name="surucu_tel" id="surucu_tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->SURUCU_TEL?>">
													    </div>
													</div>
										        </div>
										        <div class="col-md-4 mb-3">        
										            <div class="form-group">
													    <label class="form-label"><?=dil("Cep Tel")?></label>
													    <div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
													      	<input type="text" class="form-control" name="surucu_ceptel" id="surucu_ceptel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->SURUCU_CEPTEL?>">
													    </div>
													</div>
										        </div>
										        <div class="col-md-4 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Mail")?></label>
													  	<div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
													      	<input type="text" class="form-control" placeholder="" name="surucu_mail" id="surucu_mail" maxlength="100" value="<?=$row->SURUCU_MAIL?>">
													    </div>
													</div>
												</div>
												<div class="col-md-4 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("İl")?></label>
													  	<select name="surucu_il_id" id="surucu_il_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" onchange="fncIlceDoldur('#surucu_il_id', '#surucu_ilce_id')">
													      	<?=$cCombo->Iller()->setSecilen($row->SURUCU_IL_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
												</div>
												<div class="col-md-4 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("İlçe")?></label>
													  	<select name="surucu_ilce_id" id="surucu_ilce_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
													      	<?=$cCombo->Ilceler(array("il_id"=>$row->SURUCU_IL_ID))->setSecilen($row->SURUCU_ILCE_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
												</div>
												<div class="col-md-4 mb-3">        
											        <div class="form-group">
												      	<label class="form-label"> <?=dil("Meslek")?> </label>
												      	<select name="surucu_meslek_id" id="surucu_meslek_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
													      	<?=$cCombo->Meslekler()->setSecilen($row->SURUCU_MESLEK_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
												    </div>
											    </div>
												<div class="col-md-12 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Adres")?></label>
													  	<textarea name="surucu_adres" id="surucu_adres" class="form-control" maxlength="255"><?=$row->SURUCU_ADRES?></textarea>
													</div>
												</div>
							                </div>
						              	</div>
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_ruhsat')?'active':''?>" id="tab_ruhsat">
						              		<div class="row">
						              			<div class="col-md-1 mb-3">
										        	<div class="form-group">
													  	<label class="form-label"><?=dil("Seri No")?></label>
													  	<input type="text" class="form-control" placeholder="" name="ruhsat_seri_no" id="ruhsat_seri_no" maxlength="2" value="<?=$row->RUHSAT_SERI_NO?>">
													</div>
												</div>
												<div class="col-md-3 mb-3">
										        	<div class="form-group">
													  	<label class="form-label"><?=dil("Sıra No")?></label>
													  	<input type="text" class="form-control" placeholder="" name="ruhsat_sira_no" id="ruhsat_sira_no" maxlength="6" value="<?=$row->RUHSAT_SIRA_NO?>">
													</div>
												</div>
												<div class="w-100"></div>
						              			<div class="col-md-4 mb-3">
										        	<div class="form-group">
													  	<label class="form-label"><?=dil("TCK")?></label>
													  	<input type="text" class="form-control" placeholder="" name="sahibi_tck" id="sahibi_tck" maxlength="11" value="<?=$row->SAHIBI_TCK?>">
													</div>
												</div>
							                	<div class="col-md-4 mb-3">
										        	<div class="form-group">
													  	<label class="form-label"><?=dil("Adı")?></label>
													  	<input type="text" class="form-control" placeholder="" name="sahibi_ad" id="sahibi_ad" maxlength="50" value="<?=$row->SAHIBI_AD?>">
													</div>
												</div>
												<div class="col-md-4 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Soyadı")?></label>
													  	<input type="text" class="form-control" placeholder="" name="sahibi_soyad" id="sahibi_soyad" maxlength="50" value="<?=$row->SAHIBI_SOYAD?>">
													</div>
												</div>
												<div class="col-md-4 mb-3">        
										            <div class="form-group">
													    <label class="form-label"><?=dil("Sabit Tel")?></label>
													    <div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
													      	<input type="text" class="form-control" name="sahibi_tel" id="sahibi_tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->SAHIBI_TEL?>">
													    </div>
													</div>
										        </div>
										        <div class="col-md-4 mb-3">        
										            <div class="form-group">
													    <label class="form-label"><?=dil("Cep Tel")?></label>
													    <div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-phone"></i></span></div>
													      	<input type="text" class="form-control" name="sahibi_ceptel" id="sahibi_ceptel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?=$row->SAHIBI_CEPTEL?>">
													    </div>
													</div>
										        </div>
										        <div class="col-md-4 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Mail")?></label>
													  	<div class="input-group">
													      	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
													      	<input type="text" class="form-control" placeholder="" name="sahibi_mail" id="sahibi_mail" maxlength="100" value="<?=$row->SAHIBI_MAIL?>">
													    </div>
													</div>
												</div>
												<div class="col-md-4 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("İl")?></label>
													  	<select name="sahibi_il_id" id="sahibi_il_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" onchange="fncIlceDoldur('#sahibi_il_id', '#sahibi_ilce_id')">
													      	<?=$cCombo->Iller()->setSecilen($row->SAHIBI_IL_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
												</div>
												<div class="col-md-4 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("İlçe")?></label>
													  	<select name="sahibi_ilce_id" id="sahibi_ilce_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
													      	<?=$cCombo->Ilceler(array("il_id"=>$row->SAHIBI_IL_ID))->setSecilen($row->SAHIBI_ILCE_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
													</div>
												</div>
												<div class="col-md-4 mb-3">        
											        <div class="form-group">
												      	<label class="form-label"> <?=dil("Meslek")?> </label>
												      	<select name="sahibi_meslek_id" id="sahibi_meslek_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
													      	<?=$cCombo->Meslekler()->setSecilen($row->SAHIBI_MESLEK_ID)->setSeciniz()->getSelect("ID","AD")?>
													    </select>
												    </div>
											    </div>
												<div class="col-md-12 mb-3">
													<div class="form-group">
													  	<label class="form-label"><?=dil("Adres")?></label>
													  	<textarea name="sahibi_adres" id="sahibi_adres" class="form-control" maxlength="255"><?=$row->SAHIBI_ADRES?></textarea>
													</div>
												</div>
							                </div>
						              	</div>		
				            		</div>
				            		<div class="col-md-12 mb-3 text-center">
										<div class="form-group">
										  	<label></label><br>
											<button type="button" class="btn btn-primary" onclick="fncAracKaydet()"> <?=dil("Kaydet")?> </button>
										</div>
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
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    
		$("[data-mask]").inputmask();
		
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
		
	</script>
    
</body>
</html>
