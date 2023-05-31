<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle(dil("ID"),"ID","");
	$excel->sutunEkle(dil("İhale No"),"IHALE_NO","");
	$excel->sutunEkle(dil("Dosya No"),"DOSYA_NO","");
	$excel->sutunEkle(dil("Plaka"),"PLAKA","");
	$excel->sutunEkle(dil("Firma"),"FIRMA","");
	$excel->sutunEkle(dil("Marka"),"MARKA","");
	$excel->sutunEkle(dil("Model"),"MODEL","");
	$excel->sutunEkle(dil("Model Yılı"),"MODEL_YILI","");
	$excel->sutunEkle(dil("Süreç"),"SUREC","");
	$excel->sutunEkle(dil("Birinci"),"ENB1","");
	$excel->sutunEkle(dil("1.Sovtaj"),"ENB1_SOVTAJ","");
	$excel->sutunEkle(dil("İkinci"),"ENB2","");
	$excel->sutunEkle(dil("2.Sovtaj"),"ENB2_SOVTAJ","");
	$excel->sutunEkle(dil("Üçüncü"),"ENB3","");
	$excel->sutunEkle(dil("3.Sovtaj"),"ENB3_SOVTAJ","");
	$excel->sutunEkle(dil("Dördüncü"),"ENB4","");
	$excel->sutunEkle(dil("4.Sovtaj"),"ENB4_SOVTAJ","");
	$excel->sutunEkle(dil("Beşinci"),"ENB5","");
	$excel->sutunEkle(dil("5.Sovtaj"),"ENB5_SOVTAJ","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaIhaleGunlukListe")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
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
								    <div class="col-lg-2 col-md-4 mb-2">        
								        <div class="form-group"> 
									      	<label class="form-label"> <?=dil("İhale Bit Tarihi")?> </label>
									      	<div class="input-group">
									          	<input type="text" class="form-control pull-right" id="ihale_bit_tarih" name="ihale_bit_tarih" value="<?=$_REQUEST['ihale_bit_tarih']?>">
									          	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									        </div>
									    </div>
								    </div>
								    <div class="col-md-2 col-sm-6 mb-2">        
								        <div class="form-group">
								          	<label class="form-label"> <?=dil("Firma")?>  </label>
								          	<select name="firma_id" id="firma_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->Firmalar2()->setSecilen($_REQUEST['firma_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
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
                        <h2> <?=dil("İhale Günlük Liste")?> <span style="font-size: 10px;">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                            <a href="javascript:void(0)" class="btn btn-light btn-sm btn-icon mr-1" data-toggle="modal" data-target="#modalLinkEkle" title="<?=dil("Link ekle")?>"> <i class="far fa-link"></i> </a>
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-outline-secondary btn-icon waves-effect waves-themed border-white text-white"> <i class="far fa-file-excel"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed">
							    	<tr class="text-bold">
							          	<td align="center">#</td>
							          	<td align="center"><?=dil("Resim")?></td>
							          	<td nowrap><?=dil("İhale No")?></td>								          	
							          	<td><?=dil("Plaka")?></td>
							          	<td><?=dil("Firma")?></td>
							          	<td><?=dil("Marka Model")?></td>
							          	<td><?=dil("Süreç")?></td>
							          	<td align="center" title="Teklif Sayısı"><?=dil("TS")?></td>
							          	<td align="center"><?=dil("Son Rakam")?></td>
							          	<td align="center"><?=dil("Liste")?> </td>
							          	<td> </td>
							        </tr>
						        </thead>
						        <tbody>
							        <?
							        $row_toplam->SON_RAKAM = 0;
							        foreach($rows_ihale as $key=>$row_ihale) {
							        	$rows_teklif	= $cSubData->getIhaleTeklifler(['id'=>$row_ihale->ID]);
							        	if(($row_ihale->SON_RAKAM > $row_ihale->ENB1_SOVTAJ * 0.90) AND ($row_ihale->SON_RAKAM < $row_ihale->ENB1_SOVTAJ * 1.10)){
											$row_toplam->SON_RAKAM++;
										}
							        	?>
								        <tr>
								          	<td align="center" class="align-middle"><?=($Table['sayfaIlk']+$key+1)?></td>
								          	<td align="center" class="align-middle">
										    	<?if(file_exists($_SERVER['DOCUMENT_ROOT'].$row_ihale->RESIM_URL)) {?>
										    		<a href="javascript:fncPopup('/ihale/index.do?route=ihale/ihale&id=<?=$row_ihale->ID?>&kod=<?=$row_ihale->KOD?>','IHALE',1200,700)"> <img class="lazy" data-src="<?=$row_ihale->RESIM_URL?>" width="100" height="100"> </a>
										    	<?} else {?>
										    		<a href="javascript:fncPopup('/ihale/index.do?route=ihale/ihale&id=<?=$row_ihale->ID?>&kod=<?=$row_ihale->KOD?>','IHALE',1200,700)"> <img class="lazy" data-src="/img/100x100.png" width="100" height="100"> </a>
										    	<?}?>
										    </td>
								          	<td class="align-middle"> <a href="javascript:fncPopup('/ihale/index.do?route=ihale/ihale&id=<?=$row_ihale->ID?>&kod=<?=$row_ihale->KOD?>','IHALE',1200,700)"> <?=$row_ihale->IHALE_NO?> </a> </td>
								          	<td class="align-middle"><?=$row_ihale->PLAKA?></td>
								          	<td class="align-middle">
								          		<?=$row_ihale->DOSYA_NO?><br>
								          		<?=$row_ihale->FIRMA?><br>
								          		<?if($row_ihale->IHALE_SEKLI_ID == 1){?>
	                                            	<span class="text-blue"> [<?=$row_ihale->IHALE_SEKLI?>] </span>
	                                            <?} else {?>
	                                            	<span class="text-red"> [<?=$row_ihale->IHALE_SEKLI?>] </span>
	                                            <?}?>
								          	</td>
								          	<td class="align-middle">
								          		<?=$row_ihale->MARKA?><br>
								          		<?=$row_ihale->MODEL?><br>
								          		<?=$row_ihale->MODEL_YILI?><br>
								          		<?=FormatSayi::sayi($row_ihale->KM)?> [<?=$row_ihale->VITES?>]<br>
								          	</td>
								          	<td class="align-middle"><?=$row_ihale->SUREC?></td>
								          	<td align="center" class="align-middle"><?=count($rows_teklif)?></td>
								          	<td align="center" class="align-middle">
								          		<?=FormatSayi::sayi($row_ihale->SON_RAKAM)?>
								          		<?if($_SESSION['kullanici'] == 'ADMIN'){?>
								          			<br><br>
								          			<span class="text-red"> [<?=FormatSayi::sayi($row_ihale->RAKIP_ENB)?>] </span>
								          		<?}?>
								          	</td>
								          	<td>
								          		<table class="table-condensed table-sm" width="100%">
								          			<tr> <td width="10px">1.</td><td> <?=$row_ihale->ENB1?></td><td align="right"><?=FormatSayi::sayi($row_ihale->ENB1_SOVTAJ)?></td> </tr>
								          			<tr> <td>2.</td><td> <?=$row_ihale->ENB2?></td><td align="right"><?=FormatSayi::sayi($row_ihale->ENB2_SOVTAJ)?></td> </tr>
								          			<tr> <td>3.</td><td> <?=$row_ihale->ENB3?></td><td align="right"><?=FormatSayi::sayi($row_ihale->ENB3_SOVTAJ)?></td> </tr>
								          			<tr> <td>4.</td><td> <?=$row_ihale->ENB4?></td><td align="right"><?=FormatSayi::sayi($row_ihale->ENB4_SOVTAJ)?></td> </tr>
								          			<tr> <td>5.</td><td> <?=$row_ihale->ENB5?></td><td align="right"><?=FormatSayi::sayi($row_ihale->ENB5_SOVTAJ)?></td> </tr>
								          		</table>
								          	</td>
								          	<td align="center" class="align-middle" style="padding: 0px;">
								          		<a href="javascript:void(0)" onclick="fncPopup('/ihale/popup_benzer_ihale.do?route=ihale/benzer_ihale&id=<?=$row_ihale->ID?>&kod=<?=$row_ihale->KOD?>','BENZER_ARACLAR',900,600)" class="" title="<?=dil("Benzer Araçlar")?>"> <img src="/img/cars.png" height="30"/> </a>									          		
								          		<a href="javascript:void(0)" onclick="fncPopup('/ihale/sonuc.do?route=ihale/sonuc&id=<?=$row_ihale->ID?>&kod=<?=$row_ihale->KOD?>','SONUC',1100,900)" class="btn btn-outline-primary btn-icon" title="<?=dil("Sonuç")?>"> <i class="far fa-flag"></i> </a> 
								          		<a href="javascript:void(0)" onclick="fncPopup('/ihale/popup_ozet.do?route=ihale/ozet&id=<?=$row_ihale->ID?>&kod=<?=$row_ihale->KOD?>','OZET',1000,800)" class="btn btn-outline-primary btn-icon" title="<?=dil("Özet")?>"> <i class="far fa-search"></i> </a> 
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
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		//$("type='checkbox'").show();
		$('.lazy').lazy();
	  	$("[data-mask]").inputmask();
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		function fncFiltrele(){
			$("#form").submit();
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
