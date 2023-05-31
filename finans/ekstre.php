<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("Hareket","HAREKET","");
	$excel->sutunEkle("Finans Kalemi","FINANS_KALEMI","");
	$excel->sutunEkle("Fatura No","FATURA_NO","");
	$excel->sutunEkle("Fatura Tarih","FATURA_TARIH","");	
	$excel->sutunEkle("Plaka","PLAKA","");
	$excel->sutunEkle("Cari Kod","CARI_KOD","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("Borç","BORC","");
	$excel->sutunEkle("Alacak","ALACAK","");
	$excel->sutunEkle("Bakiye","BAKIYE","Bakiye",);
	$excel->sutunEkle("Tarih","TARIH","");
	$excel->sutunEkle("Açıklama","ACIKLAMA","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaEktre")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
	$rows = $Table['rows'];
	$_SESSION['Table'] = $Table;
	//var_dump2($Table['sqls']);
	
	$row_ektre_cari 	= $cSubData->getCariKod($_REQUEST);
	//$rows_ektre_gecmis 	= $cSubData->getCariEkstreYil($_REQUEST);
	//var_dump2($rows_ektre_yil);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-solid.css">
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
   
    <main id="js-page-content" role="main" class="page-content">
    	
    	<section class="content">
    		<div class="row">
				<div class="col-md-12 text-center">
					<h2> <?=$row_ektre_cari->CARI?> - <?=$row_ektre_cari->TCK?> </h2>
					<h3> <?=$row_ektre_cari->CARI_KOD?> - <?=$row_ektre_cari->VADE?> <?=dil("Gün")?> </h3>
				</div>
			</div>
			    
	    	<div class="row hidden-print hidden-xs-down">
		    	<div class="col-md-12">
			    	<div class="panel">
			    	<!--
			    	<div class="panel-hdr bg-primary-300">
                        <h2> <?=dil("Arama")?> </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
						    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
						    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    -->
			    	<div class="panel-container show">
                        <div class="panel-content">
							<form name="form" id="form" class="" enctype="multipart/form-data" method="GET">
								<input type="hidden" name="route" value="<?=$_REQUEST['route']?>">
								<input type="hidden" name="kod" id="kod" value="<?=$_REQUEST['kod']?>">
								<input type="hidden" name="sayfa" id="sayfa">
								<input type="hidden" name="filtre" value="1">
								
								<div class="row">
									<div class="col-lg-3 mb-3">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Talep No")?> </label>
									      	<input type="text" class="form-control formara" placeholder="" name="talep_no" id="talep_no" value="<?=$_REQUEST['talep_no']?>" maxlength="10">
									    </div>
									</div>
									<div class="col-lg-3 mb-3">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Finans Kalemi")?></label>
										  	<select name="finans_kalemi_id" id="finans_kalemi_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->FinansKalemi()->setSecilen($_REQUEST['finans_kalemi_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-lg-3 mb-3">        
								        <div class="form-group">
									      	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="fatura_tarih_var" name="fatura_tarih_var" <?=($_REQUEST['fatura_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="fatura_tarih_var"><?=dil("Ödeme/Fatura Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									          	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="fatura_tarih" name="fatura_tarih" value="<?=$_REQUEST['fatura_tarih']?>">
									        </div>
									    </div>
								    </div>
									<div class="col-md-2 mb-3">
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
                    <div class="panel-hdr bg-primary-300">
                        <h2> <i class="fal fa-list mr-3"></i> <b> <?=dil("Ekstre")?> </b> &nbsp;<span class="small">(<?=count($rows)?> <?=dil("Kayıt bulundu")?>)</span> </h2>
                        <div class="panel-toolbar">
			            	<a href="../finans/ekstre_pdf.do?<?=$_SERVER['QUERY_STRING']?>" title="PDF" class="btn btn-outline-primary text-white border-white btn-icon mr-1"> <i class="fas fa-file-pdf"></i> </a>
			            	<a href="../excel_sql.do?" title="Excel" class="btn btn-outline-primary text-white border-white btn-icon"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed">
							    	<tr class="fw-500">
							          	<td align="center"></td>
							          	<td align="center"><?=dil("Fatura Tarih")?></td>
							          	<td align="center"><?=dil("Vade Tarih")?></td>
							          	<td><?=dil("Hareket")?></td>
							          	<td><?=dil("Finans Kalemi")?></td>
							          	<td><?=dil("Fatura No")?></td>
							          	<td align="center" class="hidden-xs-down"><?=dil("Talep No")?></td>
							          	<td><?=dil("Plaka")?></td>
							          	<td align="right"><?=dil("Borç")?></td>
							          	<td align="right"><?=dil("Alacak")?></td>
							          	<td align="right"><?=dil("Bakiye")?></td>
							          	<td><?=dil("Kayıt Yapan")?></td>
							          	<td><?=dil("Açıklama")?></td>
							          	<td align="center"> </td>
							        </tr>
						        </thead>
						        <tbody>
						        <?
						        foreach($rows_ektre_gecmis as $key=>$row) {
						        	if(in_array($row->HAREKET_ID, array(1,4))){
										$TOPLAM_TUTAR += $row->TUTAR;
									} else {
										$TOPLAM_ODENEN += $row->TUTAR;
									}
									$TOPLAM_BAKIYE = $TOPLAM_ODENEN + $TOPLAM_TUTAR;
						        	?>
						        	<tr>
							          	<td align="center"><?=dil("Geçmiş")?></td>
							          	<td align="center"><?=$row->YIL?></td>
							          	<td align="center"></td>
							          	<td><?=$row->HAREKET?></td>
							          	<td></td>
							          	<td></td>
							          	<td align="center" class="hidden-xs-down"></td>
							          	<td></td>
							          	<td align="right" class="text-danger"><?=FormatSayi::db2tr(in_array($row->HAREKET_ID, array(1,4)) ? $row->TUTAR : 0)?></td>
							          	<td align="right" class=""><?=FormatSayi::sayi(in_array($row->HAREKET_ID, array(1,4)) ? 0 : $row->TUTAR)?></td>
							          	<td align="right" class=""><?=FormatSayi::sayi($TOPLAM_BAKIYE)?></td>
							          	<td><?=$row->KAYIT_YAPAN?></td>
							          	<td><?=FormatYazi::satir($row->ACIKLAMA,50)?></td>
							          	<td align="center">
								          	<?if(strlen($row->EFATURA_UUID) > 1){?>
										        <a href="<?=fncEFaturaPopupLink($row)?>"> <i class="fal fa-bullseye" title="Efatura PDF"></i> </a>
											<?}?>
										</td>
							        </tr>
						        <?}?>
						        
						        <?
						        foreach($rows as $key=>$row) {
						        	if(in_array($row->HAREKET_ID, array(1,4))){
										$TOPLAM_TUTAR += $row->TUTAR;
									} else {
										$TOPLAM_ODENEN += $row->TUTAR;
									}
									$TOPLAM_BAKIYE = $TOPLAM_ODENEN + $TOPLAM_TUTAR;
						        	?>
							        <tr>
							          	<td align="center">
							          		<?if($row->HAREKET_ID == 1){?>
							          			<a href="/finans/satis_fatura.do?route=finans/satis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs px-1"> <?=$row->ID?></a> 
							          		<?} else if($row->HAREKET_ID == 2){?>
							          			<a href="/finans/alis_fatura.do?route=finans/alis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs px-1"> <?=$row->ID?></a> 
							          		<?} else if($row->HAREKET_ID == 3){?>
							          			<a href="/finans/tahsilat.do?route=finans/tahsilatlar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs px-1"> <?=$row->ID?></a> 
							          		<?} else if($row->HAREKET_ID == 4){?>
							          			<a href="/finans/tediye.do?route=finans/tediyeler&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs px-1"> <?=$row->ID?></a> 
							          		<?}?>
							          	</td>
							          	<td align="center"><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
							          	<td align="center">
								          	<?if(str_replace('-','',$row->VADE_TARIH) <= str_replace('-','',date('Ymd'))){?>
								          		<i class="text-danger"> <?=FormatTarih::tarih($row->VADE_TARIH)?> </i>
								          	<?} else {?>
								          		<i class="text-success"> <?=FormatTarih::tarih($row->VADE_TARIH)?> </i>
								          	<?}?>
							          	</td>
							          	
							          	<td><?=$row->HAREKET?></td>
							          	<td><?=$row->FINANS_KALEMI?></td>
							          	<td>
							          		<?if(in_array($row->HAREKET_ID, array(1,4))){?>
							          			<a href="<?=fncFaturaPopupLink($row)?>"> <?=$row->FATURA_NO?> </a>
							          		<?} else {?>
							          			<a href="<?=fncOdemePopupLink($row)?>"> <?=$row->FATURA_NO?> </a>
							          		<?}?>
							          	</td>
							          	<td align="center" class="hidden-xs-down"><?=$row->TALEP_ID?></td>
							          	<td><?=$row->PLAKA?></td>
							          	<td align="right" class="text-danger"><?=FormatSayi::db2tr(in_array($row->HAREKET_ID, array(1,4)) ? $row->TUTAR : 0)?></td>
							          	<td align="right" class=""><?=FormatSayi::sayi(in_array($row->HAREKET_ID, array(1,4)) ? 0 : $row->TUTAR)?></td>
							          	<td align="right" class=""><?=FormatSayi::sayi($TOPLAM_BAKIYE)?></td>
							          	<td><?=$row->KAYIT_YAPAN?></td>
							          	<td><?=FormatYazi::satir($row->ACIKLAMA,50)?></td>
							          	<td align="center">
								          	<?if(strlen($row->EFATURA_UUID) > 1){?>
										        <a href="<?=fncEFaturaPopupLink($row)?>"> <i class="fal fa-bullseye" title="Efatura PDF"></i> </a>
											<?}?>
										</td>
							        </tr>
						        <?}?>
						        </tbody>
						        <tfoot class="thead-themed">
						        	<tr>
							          	<td> </td>
							          	<td> </td>
							          	<td> </td>
							          	<td> </td>
							          	<td> </td>	
							          	<td> </td>	
							          	<td class="hidden-xs-down"> </td>	
							          	<td class="text-right fw-500"> <?=dil("Toplam")?> :</td>
							          	<td align="right"><?=FormatSayi::sayi($TOPLAM_TUTAR)?></td>
							          	<td align="right"><?=FormatSayi::sayi($TOPLAM_ODENEN)?></td>
							          	<td align="right"><?=FormatSayi::sayi($TOPLAM_ODENEN + $TOPLAM_TUTAR)?></td>
							          	<td> </td>
							          	<td> </td>
							          	<td> </td>	
							        </tr>
						        </tfoot>
						  	</table>
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
		
		$("#ihale_no, #adi1").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		function fncKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formBorcEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							close();
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
            
		$('#tarih, #fatura_tarih').daterangepicker({
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
