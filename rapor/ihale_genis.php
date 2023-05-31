<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("".dil("ID")."","ID","");
	$excel->sutunEkle("".dil("İhale No")."","IHALE_NO","");
	$excel->sutunEkle("".dil("Dosya No")."","DOSYA_NO","");
	$excel->sutunEkle("".dil("Plaka")."","PLAKA","");
	$excel->sutunEkle("".dil("Marka")."","MARKA","");
	$excel->sutunEkle("".dil("Model")."","MODEL","");
	$excel->sutunEkle("".dil("Model Yılı")."","MODEL_YILI","");
	$excel->sutunEkle("".dil("Süreç")."","SUREC","");
	$excel->sutunEkle("".dil("Metod")."","IHALE_METODU","");
	$excel->sutunEkle("".dil("İhale Şekli")."","IHALE_SEKLI","");
	$excel->sutunEkle("".dil("Sorumlu")."","SORUMLU","");
	$excel->sutunEkle("".dil("Firma")."","FIRMA","");
	$excel->sutunEkle("".dil("Piyasa Değeri")."","PIYASA_DEGERI","");
	$excel->sutunEkle("".dil("İhale Baş Tarih")."","IHALE_BAS_TARIH","");
	$excel->sutunEkle("".dil("İhale Bit Tarih")."","IHALE_BIT_TARIH","");
	$excel->sutunEkle("".dil("Kayıt Tarih")."","TARIH","format1");
	$excel->sutunEkle("".dil("Sasi No")."","SASI_NO","");
	$excel->sutunEkle("".dil("Servis Adı")."","SERVIS_ADI","");
	$excel->sutunEkle("".dil("Servis İl")."","SERVIS_IL","");
	$excel->sutunEkle("".dil("Servis İlçe")."","SERVIS_ILCE","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaIhaleler")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows_ihale = $Table['rows'];
	$_SESSION['Table'] = $Table;
	//var_dump2($Table['sqls']);
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
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
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
    	
    	<section class="content">
	    	<div class="row hidden-print">
		    	<div class="col-md-12">
			    	<div class="panel">
			    	<div class="panel-container show">
                        <div class="panel-content">
							<form name="form" id="form" class="" enctype="multipart/form-data" method="GET">
								<input type="hidden" name="route" value="<?=$_REQUEST['route']?>">
								<input type="hidden" name="sayfa" id="sayfa">
								<input type="hidden" name="filtre" value="1">
								<div class="row">
									<div class="col-lg-2 col-md-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("İhale No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="ihale_no" id="ihale_no" value="<?=$_REQUEST['ihale_no']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Dosya No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="dosya_no" id="dosya_no" value="<?=$_REQUEST['dosya_no']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Plaka")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$_REQUEST['plaka']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Süreç")?> </label>
										  	<select name="surec_id" id="surec_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Surecler()->setSecilen($_REQUEST['surec_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 col-sm-6 mb-2">        
								        <div class="form-group">
								          	<label class="form-label"> <?=dil("Firma")?>  </label>
								          	<select name="firma_id" id="firma_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->Firmalar()->setSecilen($_REQUEST['firma_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
								        </div>
								    </div>
									<div class="col-lg-2 col-md-3 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Firma Red Nedeni")?> </label>
										  	<select name="firma_red_nedeni_id" id="firma_red_nedeni_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->FirmaRedNedeni()->setSecilen($_REQUEST['firma_red_nedeni_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-lg-2 col-md-3 mb-2">   
								        <div class="form-group">
									      	<label class="form-label"> <?=dil("İhale Metodu")?> </label>
									      	<select name="ihale_metodu_id" id="ihale_metodu_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->IhaleMetodu()->setSecilen($_REQUEST['ihale_metodu_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
									    </div>
								    </div>
								    <div class="col-lg-2 col-md-3 mb-2">   
								        <div class="form-group">
									      	<label class="form-label"> <?=dil("İhale Şekli")?> </label>
									      	<select name="ihale_sekli_id" id="ihale_sekli_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->IhaleSekli()->setSecilen($_REQUEST['ihale_sekli_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
									    </div>
								    </div>
									<div class="col-md-2 mb-2">		            
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Marka")?> </label>
										  	<select name="marka_id" id="marka_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Markalar()->setSecilen($_REQUEST['marka_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">        
								        <div class="form-group">
								          	<label class="form-label"> <?=dil("Servis İl")?>  </label>
								          	<select name="servis_il_id" id="servis_il_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->Iller()->setSecilen($_REQUEST['servis_il_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
								        </div>
								    </div>
								    <div class="col-md-2 mb-2">        
								        <div class="form-group">
								          	<label class="form-label"> <?=dil("Sorumlu")?>  </label>
								          	<select name="sorumlu_id" id="sorumlu_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->Sorumlular()->setSecilen($_REQUEST['sorumlu_id'])->setTumu()->getSelect("ID","ADSOYAD")?>
										    </select>
								        </div>
								    </div>
								    <div class="col-lg-2 col-md-4 mb-2">        
								        <div class="form-group">
									      	<label class="form-label">  
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="tarih_var" name="tarih_var" <?=($_REQUEST['tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="tarih_var"><?=dil("Kayıt Tarihi")?></label>
                                                </div>
									      	</label>
									      	<div class="input-group">
									          	<input type="text" class="form-control pull-right" id="tarih" name="tarih" value="<?=$_REQUEST['tarih']?>">
									          	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									        </div>
									    </div>
								    </div>
								    <div class="col-lg-2 col-md-4 mb-2">        
								        <div class="form-group">
									      	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="ihale_bas_tarih_var" name="ihale_bas_tarih_var" <?=($_REQUEST['ihale_bas_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="ihale_bas_tarih_var"><?=dil("İhale Baş Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									          	<input type="text" class="form-control pull-right" id="ihale_bas_tarih" name="ihale_bas_tarih" value="<?=$_REQUEST['ihale_bas_tarih']?>">
									          	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									        </div>
									    </div>
								    </div>
								    <div class="col-lg-2 col-md-4 mb-2">        
								        <div class="form-group">
									      	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="ihale_bit_tarih_var" name="ihale_bit_tarih_var" <?=($_REQUEST['ihale_bit_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="ihale_bit_tarih_var"><?=dil("İhale Bit Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									          	<input type="text" class="form-control pull-right" id="ihale_bit_tarih" name="ihale_bit_tarih" value="<?=$_REQUEST['ihale_bit_tarih']?>">
									          	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									        </div>
									    </div>
								    </div>
									<div class="col-md-2 mb-2">
										<div class="form-group">
										  	<label class="form-label">&nbsp;</label><br>
									  		<button type="button" class="btn btn-primary" onclick="fncFiltrele()"><?=dil("Filtrele")?></button>
									  	</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					</div>
			    </div>
		    </div>
		    
	    	<div class="row">
	    		<div class="col-md-12">
	    			<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <?=dil("İhale Geniş Rapor")?> <span style="font-size: 10px;">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                            <a href="javascript:void(0)" class="btn btn-light btn-sm btn-icon mr-1" data-toggle="modal" data-target="#modalLinkEkle" title="<?=dil("Link ekle")?>"> <i class="far fa-link"></i> </a>
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-light btn-sm btn-icon"> <i class="far fa-file-excel"></i> </a>
		            		<button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimize"><i class="far fa-window-minimize"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Maksimize"><i class="far fa-expand"></i></button>
                            <button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"><i class="far fa-times"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed">
							    	<tr>
							          	<td align="center" nowrap>#</td>
							          	<td nowrap><?=dil("İhale No")?></td>
							          	<td nowrap><?=dil("Dosya No")?></td>
							          	<td><?=dil("Plaka")?></td>
							          	<td><?=dil("Marka")?></td>
							          	<td><?=dil("Model")?></td>
							          	<td nowrap><?=dil("M.Yılı")?></td>
							          	<td><?=dil("Süreç")?></td>
							          	<td nowrap><?=dil("İhale Şekli")?></td>
							          	<td><?=dil("Firma")?></td>
							          	<td align="right" nowrap><?=dil("Piyasa Değeri")?></td>
							          	<td nowrap><?=dil("İhale Baş Tarih")?></td>
							          	<td nowrap><?=dil("İhale Bit Tarih")?></td>
							          	<td><?=dil("Sasi No")?></td>
							          	<td><?=dil("Servis Adı")?></td>
							          	<td><?=dil("Servis İl/İlçe")?></td>
							          	<td> </td>
							        </tr>
						        </thead>
						        <tbody>
							        <?foreach($rows_ihale as $key=>$row_ihale) {?>
								        <tr>
								          	<td align="center" nowrap><?=($Table['sayfaIlk']+$key+1)?></td>
								          	<td><?=$row_ihale->IHALE_NO?></td>
								          	<td><?=$row_ihale->DOSYA_NO?></td>
								          	<td nowrap=""><?=$row_ihale->PLAKA?></td>
								          	<td><?=$row_ihale->MARKA?></td>
								          	<td><?=$row_ihale->MODEL?></td>
								          	<td><?=$row_ihale->MODEL_YILI?></td>
								          	<td><?=$row_ihale->SUREC?></td>
								          	<td><?=$row_ihale->IHALE_SEKLI?></td>
								          	<td><?=$row_ihale->FIRMA?></td>
								          	<td align="right"><?=FormatSayi::sayi($row_ihale->PIYASA_DEGERI)?></td>
								          	<td><?=FormatTarih::tarih($row_ihale->IHALE_BAS_TARIH)?></td>
								          	<td><?=FormatTarih::tarih($row_ihale->IHALE_BIT_TARIH)?></td>
								          	<td><?=$row_ihale->SASI_NO?></td>
								          	<td><?=$row_ihale->SERVIS_ADI?></td>
								          	<td><?=$row_ihale->SERVIS_IL?> / <?=$row_ihale->SERVIS_ILCE?></td>
								          	<td style="padding: 0px;">									          		
								          		<a href="/ihale/sonuc.do?route=ihale/sonuc&id=<?=$row_ihale->ID?>" class="btn btn-outline-primary btn-sm btn-icon" title="<?=dil("Sonuç")?>"> <i class="far fa-flag"></i> </a> 
								          	</td>
								        </tr>
							        <?}?>
						        </tbody>
						  	</table>
						  	<div class="frame-wrap text-center">
		                        <nav> 
		                            <ul class="pagination justify-content-center">
		                            	<?=$Table["sayfaAltYazi"];?>
		                            </ul>
		                        </nav>
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
    <script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$("[data-mask]").inputmask();
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		function fncLinkEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formLinkEkle').serialize(),
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
		
		var start = moment().subtract(29, 'days');
        var end = moment();
		
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
            
		$('#tarih, #ihale_bas_tarih, #ihale_bit_tarih').daterangepicker({
			timePicker: false,
			timePicker24Hour: true,
			timePickerIncrement: 30, 
			locale: {
		        "format": "DD-MM-YYYY",
		        "separator": " , ",
		        "applyLabel": "Uygula",
		        "cancelLabel": "Vazgeç",
		        "fromLabel": "Dan",
		        "toLabel": "a",
		        "customRangeLabel": "Seç",
		        "weekLabel": "W",
		        "daysOfWeek": [
		            "Pa",
		            "Pz",
		            "Sa",
		            "Ça",
		            "Pe",
		            "Cu",
		            "Ct"
		        ],
		        "monthNames": [
		            "Ocak",
		            "Şubat",
		            "Mart",
		            "Nisan",
		            "Mayıs",
		            "Haziran",
		            "Temmuz",
		            "Ağustos",
		            "Eylül",
		            "Ekim",
		            "Kasım",
		            "Aralık"
		        ],
		        "firstDay": 1
		    },
		    ranges: {
                'Bugün': [moment(), moment()],
                'Dün': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Son 7 gün': [moment().subtract(6, 'days'), moment()],
                'Son 30 gün': [moment().subtract(29, 'days'), moment()],
                'Bu Ay': [moment().startOf('month'), moment().endOf('month')],
                'Geçen Ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }, 
		}, cb);
		
		cb(start, end);
		
	</script>
    
</body>
</html>