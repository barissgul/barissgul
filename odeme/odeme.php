<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	//session_kontrol();
	$row_cari 	= $cSubData->getCari(array("id"=>$_SESSION["cari_id"]));
	$rows		= $cSubData->getCariBakiye(array("cari_kod"=>$row_cari->OZEL_KOD1, "grup_kod"=>$row_cari->OZEL_KOD2));
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
	    		<div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12">		          	
	    			<div class="panel">
                    <div class="panel-hdr bg-primary-500">
                        <h2> <i class="far fa-lira-sign mr-3"></i> <?=dil("Ödeme Bilgileri")?> <span class="badge badge-secondary ml-2"></span> </h2>
                        <div class="panel-toolbar">
                        	<button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"><i class="fal fa-angle-double-down fa-2x"></i></button>
						</div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                        	<div class="row">
                        		<div class="col-md-12">
							        <form name="formOdeme" id="formOdeme">
										<input type="hidden" name="islem" id="islem" value="talep_odeme_al">
										<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
										<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
								    	
								    	<div class="row">
											<div class="col-md-12">
					                        	<div class="panel-tag py-2"><?=dil("Güvenli Ödeme")?><i class="fal fa-lock-alt ml-3 mr-1 text-success"></i> <span class="text-success">SSL</span> </div>
												<div class="row">
													<div class="col-md-4 py-2 mb-4">
														<div class="form-group">
															<label class="form-label"> <?=dil("Dövizli Tutar")?> </label>
														  	<input type="text" class="form-control" placeholder="" name="dovizli" id="dovizli" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_parca->ALIS,2)?>" onchange="fncHesap()">
														</div>
													</div>
													<div class="col-md-2 py-2 mb-4">   
													    <div class="form-group">
														  	<label class="form-label"> <?=dil("Para Birim")?> </label>
														  	<select name="para_birim" id="para_birim" class="form-control select2 select2-hidden-accessible" style="width: 100%" onchange="fncHesap()">
														      	<?=$cCombo->ParaBirim()->setSecilen()->setSeciniz()->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="w-100"></div>
													<div class="col-md-6 mb-2 mt-lg-4 mt-md-0">        
											            <div class="form-group">
														    <input type="text" class="form-control" name="kart_no" id="kart_no" data-inputmask='"mask": "9999 9999 9999 9999"' data-mask value="" placeholder="<?=dil("Kart Numarası")?>">
														</div>
											        </div>
											        <div class="col-md-6 mb-2 mt-lg-4 mt-md-0">
														<div class="form-group">
														  	<input type="text" class="form-control" placeholder="<?=dil("Kart Üzerindeki İsim")?>" name="kart_isim" id="kart_isim" maxlength="100" value="" onkeyup="this.value=this.value.turkishToUpper();">
														</div>
													</div>
											        <div class="col-md-6 mb-2 mt-lg-4 mt-md-0">
														<div class="form-group">
														  	<select name="kart_ay" id="kart_ay" class="form-control" style="width: 100%;">
														      	<?=$cCombo->Ay()->setSecilen()->setSeciniz("-1", dil("AY"))->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-6 mb-2 mt-lg-4 mt-md-0">
														<div class="form-group">
														  	<select name="kart_yil" id="kart_yil" class="form-control" style="width: 100%;">
														      	<?=$cCombo->Yil2()->setSecilen()->setSeciniz("-1", dil("YIL"))->getSelect("ID","AD")?>
														    </select>
														</div>
													</div>
													<div class="col-md-6 mb-2 mt-lg-4 mt-md-0">       
											            <div class="form-group">
														    <input type="text" class="form-control" name="kart_cvc" id="kart_cvc" data-inputmask='"mask": "999"' data-mask value="" placeholder="CVC">
														</div>
											        </div>
											        <div class="col-md-6 mb-2 mt-lg-4 mt-md-0">
														<div class="form-group">
														  	<div class="input-group">
														  		<input type="text" class="form-control" placeholder="" name="tutar" id="tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="0" onchange="fncHesap()" readonly>
														  		<div class="input-group-append"><span class="input-group-text bg-transparent border-left-0"><i class="fal fa-lira-sign"></i></span></div>
														  	</div>
														</div>
													</div>
											    </div>
											</div>
											<div class="col-md-12">
												<div class="panel">
							    				<div class="panel-hdr bg-primary-300 text-white">
							                        <h2> <i class="fal fa-lira-sign mr-3"></i> <?=dil("Ektre Özeti")?> </h2>
							                        <div class="panel-toolbar">
							                        	<button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"><i class="fal fa-angle-double-down fa-2x"></i></button>
							                        </div>
							                    </div>
							                    <div class="panel-container show">
							                        <div class="panel-content">
							                        	<div class="col-md-12">
													  		<table class="table table-sm table-condensed table-hover datatable" id="tablo1">
														  		<thead class="thead-themed fw-500">
															    	<tr>
															          	<td align="center">#</td>
															          	<td align="center"><?=dil("Cari Kod")?></td>
															          	<td><?=dil("Cari")?></td>
															          	<td align="center"><?=dil("Grup Kod")?></td>
															          	<td><?=dil("Grup Cari")?></td>
															          	<td align="right"><?=dil("Dövizli Tutar")?></td>
															          	<td><?=dil("Para Birimi")?></td>
															          	<td class="no-sort"> </td>
															        </tr>
														        </thead>
														        <tbody>
															        <?foreach($rows as $key=>$row) {?>
																        <tr>
																          	<td align="center" class="bg-gray-100"><?=($key+1)?></td>									          
																          	<td align="center"><?=$row->CariKod?></td>
																          	<td><?=$row->CariUnvan?></td>
																          	<td align="center"><?=$row->GrupSirketiKodu?></td>
																          	<td><?=$row->GrupSirketiUnvan?></td>
																          	<td align="right"><?=FormatSayi::sayi($row->DovizliTutar)?></td>
																          	<td><?=$row->DovizCinsi?></td>
																          	<td align="center" class="p-0">
																          	
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
											<div class="col-md-4 offset-md-4 text-center">
												<button type="button" class="btn btn-warning waves-effect waves-themed btn-block mt-2 btn-lg" onclick="fncOdemeYap(this)"><?=dil("Ödeme Yap")?></button>
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
    
     <p id="js-color-profile" class="d-none">
        <span class="color-primary-50"></span>
        <span class="color-primary-100"></span>
        <span class="color-primary-200"></span>
        <span class="color-primary-300"></span>
        <span class="color-primary-400"></span>
        <span class="color-primary-500"></span>
        <span class="color-primary-600"></span>
        <span class="color-primary-700"></span>
        <span class="color-primary-800"></span>
        <span class="color-primary-900"></span>
        <span class="color-info-50"></span>
        <span class="color-info-100"></span>
        <span class="color-info-200"></span>
        <span class="color-info-300"></span>
        <span class="color-info-400"></span>
        <span class="color-info-500"></span>
        <span class="color-info-600"></span>
        <span class="color-info-700"></span>
        <span class="color-info-800"></span>
        <span class="color-info-900"></span>
        <span class="color-danger-50"></span>
        <span class="color-danger-100"></span>
        <span class="color-danger-200"></span>
        <span class="color-danger-300"></span>
        <span class="color-danger-400"></span>
        <span class="color-danger-500"></span>
        <span class="color-danger-600"></span>
        <span class="color-danger-700"></span>
        <span class="color-danger-800"></span>
        <span class="color-danger-900"></span>
        <span class="color-warning-50"></span>
        <span class="color-warning-100"></span>
        <span class="color-warning-200"></span>
        <span class="color-warning-300"></span>
        <span class="color-warning-400"></span>
        <span class="color-warning-500"></span>
        <span class="color-warning-600"></span>
        <span class="color-warning-700"></span>
        <span class="color-warning-800"></span>
        <span class="color-warning-900"></span>
        <span class="color-success-50"></span>
        <span class="color-success-100"></span>
        <span class="color-success-200"></span>
        <span class="color-success-300"></span>
        <span class="color-success-400"></span>
        <span class="color-success-500"></span>
        <span class="color-success-600"></span>
        <span class="color-success-700"></span>
        <span class="color-success-800"></span>
        <span class="color-success-900"></span>
        <span class="color-fusion-50"></span>
        <span class="color-fusion-100"></span>
        <span class="color-fusion-200"></span>
        <span class="color-fusion-300"></span>
        <span class="color-fusion-400"></span>
        <span class="color-fusion-500"></span>
        <span class="color-fusion-600"></span>
        <span class="color-fusion-700"></span>
        <span class="color-fusion-800"></span>
        <span class="color-fusion-900"></span>
    </p>
           
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
    <script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <?$cBootstrap->getTemaJs()?>
    <script src="../smartadmin/plugin/1.js"></script>

    <script>
    	
    	$("[data-mask]").inputmask();
    	
		function fncOdemeYap(obj){
			//$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formOdeme').serialize(),
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
		};
		
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
		
		function fncHesap(obj){
			var dovizli = fncSayiDb($("#dovizli").val()) * 1;
			var para_birim = $("#para_birim").val();
			var tutar = 0.0; 
			
			if(para_birim == "USD"){
				tutar = dovizli * <?=$rows_doviz->DOLAR->SATIS?>; 	
			} else if(para_birim == "EUR"){
				tutar = dovizli * <?=$rows_doviz->EURO->SATIS?>;
			} else if(para_birim == "GBP"){
				tutar = dovizli * <?=$rows_doviz->STERLIN->SATIS?>;
			} else if(para_birim == "TRY"){
				tutar =  dovizli;
			}
			
			$("#tutar").val( fncSayiTr(tutar) );	
		}
		
	</script>
    
</body>
</html>
