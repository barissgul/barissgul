<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row			= $cSubData->getStok($_REQUEST);
	if(is_null($row->ID) AND strlen($_REQUEST['kodu']) > 2){
		$filtre = array();
        $sql = "SELECT
        			S.*,
        			PM.PARCA_MARKA
				FROM STOK AS S
					LEFT JOIN PARCA_MARKA AS PM ON PM.ID = S.PARCA_MARKA_ID
				WHERE S.KODU = :KODU
				";
		$filtre[":KODU"]	 = $_REQUEST['kodu'];
		$row = $cdbPDO->row($sql, $filtre);
		
		if($row->ID > 0){
			echo "<script> location.href = '/stok/popup_stok.do?route=stok/popup_stok&id={$row->ID}&kod={$row->KOD}' </script>";	
			die();
		}
				
	}
	$rows_resim				= $cSubData->getStokResimler($_REQUEST);
	//$rows_stok_katalog		= $cSubData->getStokKataloglar($_REQUEST);
	fncKodKontrol($row);
	
?>
<!DOCTYPE html>
<html lang="tr" class="<?=$cBootstrap->getFontBoyut()?>">
<head>
    <meta charset="utf-8">
    <title> <?=$row_site->TITLE?> <?=dil("Stok")?></title>
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
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/css/fileinput.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.css"/>
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/fonts/ionicons.min.css">  
    <link rel="stylesheet" href="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-tagsinput-master/tagsinput.css">
    <link rel="stylesheet" href="../smartadmin/plugin/fancybox/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
    <?$cBootstrap->getTemaCss()?>
    <style>
    	
    </style>
</head>
<body class="mod-bg-1">
    <div class="page-wrapper">
    <div class="page-inner">
    
    <main id="js-page-content" role="main" class="page-content">        
	 	<section class="content">
	    	<div class="row">
	    		<div class="col-xl-8 offset-xl-2 col-lg-12 col-md-12 col-sm-12">
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-300">
                        <h2> <i class="fal fa-cog fa-2x mr-3"></i> <?=dil("Stok Bilgileri")?> &nbsp; <span class="badge badge-primary float-right"><?=dil("ID:")?> <?=$row->ID?></span> </h2>
                        <div class="panel-toolbar">
                        	<a href="javascript:fncPopup('/stok/popup_stok_cikti.do?route=stok/popup_stok_cikti&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_YAZDIR',1100,800);" class="btn btn-outline-primary btn-icon waves-effect waves-themed text-white border-white mr-1" title="Teslim İbra"> <i class="fal fa-print"></i></a>
			                <a href="javascript:fncPopup('/stok/popup_stok_etiket.do?route=stok/popup_stok_etiket&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_YAZDIR_ETIKET',1100,800);" class="btn btn-outline-primary btn-icon waves-effect waves-themed text-white border-white mr-1" title="Stok Etiket"> <i class="fal fa-barcode"></i></a>
			                <!--
			                <a href="javascript:fncPopup('/stok/popup_stok_resim_yukle.do?route=stok/popup_stok_resim_yukle&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_STOK_RESIM_YUKLE',1100,800);" class="btn btn-outline-primary text-white border-white btn-icon <?=($row->RESIM_VAR==1?'bg-success-100':'')?>" title="Resim Yükle"> <i class="fal fa-images"></i></a>
			                -->
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">                        	
                        	<form name="formStok" id="formStok">
							<input type="hidden" name="islem" id="islem" value="stok_kaydet">
							<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
							<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
							
							<div class="row">
								<div class="col-md-12">
									<ul class="nav nav-tabs justify-content-center" role="tablist">
		                               	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_stok' OR !isset($_REQUEST['tab']))?'active':''?>" href="#tab_stok" data-toggle="tab"> <?=dil("Stok Bilgisi")?> </a></li>
						            	<?if($row->ID > 0){?>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-5 <?=($_REQUEST['tab']=='tab_resim')?'active':''?>" href="#tab_resim" data-toggle="tab"> <?=dil("Resim")?> </a></li>
						            	<li class="nav-item"><a class="nav-link fs-md py-3 px-4 <?=($_REQUEST['tab']=='tab_arac')?'active':''?>" data-toggle="tab" href="#tab_arac" role="tab" aria-selected="true"><?=dil("Uyumlu Araçlar")?></a></li>
						            	<?}?>
		                            </ul>
		                            <div class="tab-content p-3 shadow">
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_stok' OR !isset($_REQUEST['tab']))?'active':''?>" id="tab_stok">						          		
							            	<div class="row">
							            		<div class="col-md-3 text-center popup-gallery">
							                  		<?if(is_file($cSabit->imgPathFile($row->URL))){?>
										                <a href="/resim.do?id=<?=$row->ID?>" data-toggle="lightbox" data-gallery="example-gallery" data-title="<?=$row->KODU?> - <?=$row->STOK?>" data-footer="<?=FormatTarih::tarih($row->TARIH)?>"> 
															<img class="img-thumbnail lazy" alt="" src="/img/loading2.gif" data-src="/resim.do?id=<?=$row->ID?>" style="width:300px;height: 300px"/>
														</a>
											        <?} else {?>
											        	<a href="/img/300x300.png" data-toggle="lightbox" data-gallery="example-gallery" data-title="A" data-footer="B"> <img src="/img/300x300.png" class="img-responsive center-block " width="100%"> </a>
											        <?}?>					            
												</div>
												<div class="col-md-9">
													<div class="row">
														<div class="col-md-4 mb-2">						            
														    <div class="form-group input-group-lg">
															  	<label class="form-label"><?=dil("Parça  Marka")?></label>
															  	<select name="parca_marka_id" id="parca_marka_id" class="form-control select2" style="width: 100%;">
															      	<?=$cCombo->ParcaMarkalar()->setSecilen($row->PARCA_MARKA_ID)->setSeciniz()->getSelect("ID","AD")?>
															    </select>
															</div>
														</div>	
									            		<div class="col-md-4 mb-2">
											            	<div class="form-group">
															  	<label class="form-label"><?=dil("Parça Kodu")?></label>
															  	<input type="text" class="form-control" placeholder="" name="kodu" id="kodu" maxlength="25" value="<?=$row->KODU?>" onchange="this.value=this.value.plakaToUpper();">
															</div>
														</div>
														<div class="col-md-4 mb-2">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Oem Kodu")?></label>
															  	<input type="text" class="form-control" placeholder="" name="oem_kodu" id="oem_kodu" maxlength="255" value="<?=$row->OEM_KODU?>" onchange="this.value=this.value.plakaToUpper();">
															</div>
														</div>
														<div class="col-md-4 mb-2">
											            	<div class="form-group">
															  	<label class="form-label"><?=dil("Barkod")?></label>
															  	<input type="text" class="form-control" placeholder="" name="barkod" id="barkod" maxlength="25" value="<?=$row->BARKOD?>" onchange="this.value=this.value.plakaToUpper();">
															</div>
														</div>
														<div class="col-md-8 mb-2">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Parça Adı")?></label>
															  	<input type="text" class="form-control" placeholder="" name="stok" id="stok" maxlength="100" value="<?=$row->STOK?>">
															</div>
														</div>
														<div class="col-md-12 mb-2">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Muadil Kodları")?></label>
															  	<input type="text" name="muadil_kodus" id="muadil_kodus" value="<?=$row->MUADIL_KODUS?>" maxlength="255">
															</div>
														</div>
														<div class="w-100"></div>
														<div class="col-md-12 mb-2">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Genel Açıklama (Genel açıklama sadece siz görebilirsiniz)")?></label>
															  	<textarea name="genel_aciklama" id="genel_aciklama" class="form-control maxlength" maxlength="500" rows="4"><?=$row->GENEL_ACIKLAMA?></textarea>
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
														<div class="col-md-3 mb-2">						            
														    <div class="form-group input-group-lg">
															  	<label class="form-label"><?=dil("Kategori")?></label>
															  	<select name="kategori_id" id="kategori_id" class="form-control select2" style="width: 100%;">
															      	<?=$cCombo->Kategoriler()->setSecilen($row->KATEGORI_ID)->setSeciniz()->getSelect("ID","AD")?>
															    </select>
															</div>
														</div>	
														<div class="col-md-3 mb-2">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Durum")?></label>
															  	<select name="durum" id="durum" class="form-control select2 select2-hidden-accessible" style="width: 100%">
															      	<?=$cCombo->Durumlar()->setSecilen($row->DURUM)->getSelect("ID","AD")?>
															    </select>
															</div>
														</div>
														<div class="col-md-3 mb-2" id="satis_fiyat_div">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Adet")?></label>
																<input type="text" class="form-control" placeholder="" name="adet" id="adet" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" maxlength="10" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->ADET,0)?>">
															</div>
														</div>
														<div class="col-md-3 mb-2" id="satis_fiyat_div">
															<div class="form-group">
															  	<label class="form-label"><?=dil("Sabit Satış Fiyatı (KDVsiz)")?></label>
																<div class="input-group">
																  	<input type="text" class="form-control" placeholder="" name="satis_fiyat" id="satis_fiyat" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" maxlength="10" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->SATIS_FIYAT,2)?>">
																  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
																</div>
															</div>
														</div>
														<div class="w-100"></div>
														<div class="col-md-12 mb-2 mt-2 text-center">
															<button type="button" class="btn btn-primary" onclick="fncKaydet()" style="width: 120px;"> <?=dil("Kaydet")?> </button>
														</div>
													</div>
												</div>
											</div>
					              		</div>
						              	<div class="tab-pane <?=($_REQUEST['tab']=='tab_resim')?'active':''?>" id="tab_resim">
						              		<div class="row">
							                	<div class="col-md-6">
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
												              	<table class="table table-condensed table-sm evrak-gallery" >
												              		<thead class="thead-themed">
													                	<tr>
														                  	<th style="width: 10px">#</th>
														                  	<th><?=dil("Evrak")?></th>
														                  	<th><?=dil("Açıklama")?></th>														                  	
														                  	<th> </th>
														                </tr>
														            </thead>
														            <tbody>
														                <?foreach($rows_resim as $key=>$row_resim) {?>
														                <tr>
														                  	<td><?=($key+1)?></td>
														                  	<td>
														                  		<?if(is_pdf($cSabit->imgPathFile($row_resim->URL))){?>
														                  			<a href="<?=$cSabit->imgPath($row_resim->URL)?>" target="_blank">
																	               		<i class="fal fa-file-pdf fa-2x" style="width: 50px;"></i>
																	               	</a>
														                  		<?} else if(is_file($cSabit->imgPathFile($row_resim->URL))){?>
																	                <a href="<?=$cSabit->imgPath($row_resim->URL)?>" data-toggle="lightbox" data-gallery="evrak-gallery" data-title="<?=$row_resim->EVRAK?>" data-footer="">
																			          	<img src="<?=$cSabit->imgPath($row_resim->URL)?>" class="img-thumbnail" alt="" width="150px">
																			        </a>
																		        <?} else {?>
																		        	<a href="/img/100x100.png" data-gallery="evrak-gallery" data-title="<?=$row_resim->EVRAK?>" data-footer=""> <img src="/img/100x100.png" class="img-responsive center-block " style="width:152px;height: 100px"> </a>
																		        <?}?>
																		    </td>
																		    <td><?=$row_resim->RESIM_ACIKLAMA?></td>														                  	
														                  	<td>
														                  		<button type="button" class="btn px-0 mr-3" onclick="fncResimSil(this)" title="Sil" data-id="<?=$row_resim->ID?>"> <i class="far fa-trash text-danger fa-2x"></i> </button>
																			    <button type="button" class="btn px-0 mr-3" onclick="location.href='<?=$cSabit->imgPath($row_resim->URL)?>'"> <i class="far fa-download text-primary fa-2x"></i> </button>
																			    <button type="button" class="btn px-0 mr-3" onclick="fncResimAktif(this)" title="<?=($row_resim->SIRA==1) ? 'Aktif' : 'Aktif Et'?>" data-id="<?=$row_resim->ID?>"> <i class="fa-2x text-success <?=$row_resim->SIRA==1 ? 'ion-checkmark-circled' : 'ion-checkmark-round'?>"></i> </button>
														                  		<br><span class="mt-3"><?=FormatTarih::tarih($row_resim->TARIH)?></span>
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
									                <div class="row">
									                	<div class="col-md-12 mb-2">
											            	<div class="form-group">
															  	<label class="form-label"><?=dil("Açıklama")?></label>
															  	<input type="text" class="form-control" placeholder="" name="resim_aciklama" id="resim_aciklama" maxlength="100" value="">
															</div>
														</div>
											           	<div class="col-sm-12">
												           	<div class="form-group">
												           		<input id="stok_resim" name="stok_resim[]" type="file" class="file-loading" data-show-upload="true" data-language="tr" multiple>
												           		<div class="panel-tag mt-2"><?=dil("1000X1000 boyutunda jpg, jpeg, png, pdf yükleyiniz")?></div>
												           	</div>
											           	</div>
											        </div>
									            </div>
							                </div>
						              	</div>	
						              	<div class="tab-pane fade active" id="tab_arac" >
                                            <div class="row">
                                            	<div class="col-md-12 text-right">
                                            		<button type="button" class="btn btn-primary" onclick="javascript:fncPopup('/stok/popup_katalog.do?route=stok/popupkatalog&stok_id=<?=$row->ID?>','POPUP_YENI_ARAC',1200,800);" style="width: 120px;"> <?=dil("Yeni")?> </button>
                                            	</div>
                                            	<div class="col-md-12">
                                            		<table class="table table-bordered table-hover table-striped w-100 table-sm table-condensed" id="tab12">
		                                               <thead class="thead-themed fw-500">
		                                                	<tr>
																<td>#</td>
																<td><?=dil("Katalog ID")?></td>
																<td><?=dil("Marka")?></td>
																<td><?=dil("Model")?></td>
																<td><?=dil("Model Tipi")?></td>
																<td><?=dil("Yıl")?></td>
																<td></td>
															</tr>
														</thead>
														<tbody>
															<?foreach($rows_stok_katalog as $key => $row_stok_katalog){?>
																<tr>
																	<td><?=($key+1)?></td>
																	<td><?=$row_stok_katalog->STOK_KATALOG_ID?></td>
																	<td><?=$row_stok_katalog->MARKA?></td>
																	<td><?=$row_stok_katalog->MODEL?></td>
																	<td><?=$row_stok_katalog->MODEL_TIPI?></td>
																	<td><?=$row_stok_katalog->YIL_BAS ." - ". $row_stok_katalog->YIL_BIT?></td>
																	<td class="p-0">
																		<button type="button" class="btn btn-outline-primary btn-sm" onclick="fncSil(this)" title="Sil" data-stok_id="<?=$row_stok_katalog->STOK_ID?>" data-katalog_id="<?=$row_stok_katalog->STOK_KATALOG_ID?>"><i class="fal fa-trash-alt fw-900"></i></button>
																	</td>
																</tr>
															<?}?>
														</tbody>
													</table>		
                                            	</div>
                                            	
                                            </div>
                                            
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
            
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
    <script src="../smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/locales/tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/piexif.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/js/plugins/purify.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap-fileinput-master/themes/explorer-fas/theme.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
    <script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-tagsinput-master/tagsinput.js"></script>
    <script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
	<script src="../smartadmin/plugin/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		$("img.lazy").lazy();
		
		$('#tab1').dataTable({
            //responsive: true, // not compatible
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false
           
        });
        
        $('#muadil_kodus').tagsinput({
	    	confirmKeys: [13, 188]
	  	});
		
	  	$('#muadil_kodus').on('keypress', function(e){
		    if (e.keyCode == 13){
		     	e.keyCode = 188;
		      	e.preventDefault();
		    };
	  	});
  
		/*
		$('.popup-gallery').magnificPopup({
          	delegate: 'a',
          	type: 'image',
          	tLoading: 'Resim Yükleniyor #%curr%...',
          	mainClass: 'mfp-img-mobile',
          	gallery: {
            	enabled: true,
            	navigateByImgClick: true,
            	preload: [0,1] // Will preload 0 - before current, and 1 after the current image
          	},
          	image: {
            	tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            	titleSrc: function(item) {
              		return item.el.attr('data-title');
            	}
          	}
        });
        */
		$("#stok_resim").fileinput({
			theme: 'explorer-fas',
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=stok_resim_yukle&id=<?=$row->ID?>',
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
			        aciklama: $('#resim_aciklama').val(),
			    };
			},
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#stok_resim').on('filebatchuploadcomplete', function(event, data, previewId, index) {
		   	location.reload(true);
		});
		
		function fncKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formStok').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					} else if(jd.YENI){
						toastr.success(jd.ACIKLAMA);
						window.location.href = jd.URL;
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
				data: { "islem": "stok_resim_aktif", "id": $(obj).data("id"), "kod": $(obj).data("kod"), "stok_id": "<?=$row->ID?>" },
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
		
		function fncResimSil(obj){
			bootbox.confirm('<?=dil("Silmek istediğinizden emin misiniz")?>!', function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem": "stok_resim_sil", "id": $(obj).data("id") },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
							}else{
								toastr.success(jd.ACIKLAMA);
								$(obj).parent().parent().hide();
							}
						}
					});
				}
			});
			
		}
		/*
		$('.magnific-popup-modal').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
			mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
			image: {
				verticalFit: true
			}
		});
		*/
		
		$('.popup-gallery').magnificPopup({
          	delegate: 'a',
          	type: 'image',
          	tLoading: 'Resim Yükleniyor #%curr%...',
          	mainClass: 'mfp-img-mobile',
          	gallery: {
            	enabled: true,
            	navigateByImgClick: true,
            	preload: [0,1] // Will preload 0 - before current, and 1 after the current image
          	},
          	image: {
            	tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            	titleSrc: function(item) {
              		return item.el.attr('data-title');
            	}
          	}
        });	
        
        $('.evrak-gallery').magnificPopup({
          	delegate: 'a',
          	type: 'image',
          	tLoading: 'Resim Yükleniyor #%curr%...',
          	mainClass: 'mfp-img-mobile',
          	gallery: {
            	enabled: true,
            	navigateByImgClick: true,
            	preload: [0,1] // Will preload 0 - before current, and 1 after the current image
          	},
          	image: {
            	tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            	titleSrc: function(item) {
              		return item.el.attr('data-title');
            	}
          	}
        });	
        
        function fncRafSiraDoldur(){
			$("#raf_yer_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "raf_sira_doldur", 'raf_id' : $("#raf_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						$('#raf_yer_id').html(jd.HTML);
					}
					$("#raf_yer_id").removeAttr("disabled");
				}
			});
		};
		
		function fncSatisFiyatSecim(){
			if($("#satis_fiyat_secim_id").val() == 2){
				$("#satis_fiyat_div").fadeIn();
			} else {
				$("#satis_fiyat_div").fadeOut();
			}
		}
		
		function fncRafSiraDegistir(){
			//location.href = "/depolama/popup_depola.do?route=depolama/depolama&raf_if="+ $("#raf_if").val() + "&sira=" + $("#sira").val() + "&talep_id=" + $("#talep_id").val();
		}
		
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
		
		function fncSil(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "stok_katalog_sil", 'stok_id' : $(obj).data("stok_id"), 'katalog_id' : $(obj).data("katalog_id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						$(obj).parent().parent().hide();
					}
				}
			});
		}
		
	</script>
    
</body>
</html>
