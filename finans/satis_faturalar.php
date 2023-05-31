<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("İşlem No","ID","");
	$excel->sutunEkle("Fatura Tarih","FATURA_TARIH","format1");
	$excel->sutunEkle("Vade Tarih","VADE_TARIH","format1");
	$excel->sutunEkle("Fatura No","FATURA_NO","");
	$excel->sutunEkle("Finans Kalemi","FINANS_KALEMI","");
	$excel->sutunEkle("Talep No","TALEP_ID","");	
	$excel->sutunEkle("Plaka","PLAKA","");	
	$excel->sutunEkle("Dosya No","DOSYA_NO","");
	$excel->sutunEkle("Cari Kodu","CARI_KODU","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("KDVsiz Tutar","KDVSIZ_TUTAR","");
	$excel->sutunEkle("KDV Tutar","KDV_TUTAR","");
	$excel->sutunEkle("Fatura Tutar","TUTAR","");
	$excel->sutunEkle("Kayıt Tarihi","TARIH","");
	$excel->sutunEkle("Kayıt Yapan","KAYIT_YAPAN","");
	$excel->sutunEkle("Açıklama","ACIKLAMA","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaSatisFaturalar")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
	$rows = $Table['rows'];
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
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Fatura No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" value="<?=$_REQUEST['fatura_no']?>" maxlength="16">
									    </div>
									</div>
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Sipariş No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="islem_no" id="islem_no" value="<?=$_REQUEST['islem_no']?>" maxlength="11">
									    </div>
									</div>
									<div class="col-xl-4 col-sm-6 mb-2">   
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Cari")?> </label>
										  	<select name="cari_id" id="cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->Cariler(array("alim_satis"=>1))->setSecilen($_REQUEST['cari_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Finans Kalemi")?></label>
										  	<select name="finans_kalemi_id" id="finans_kalemi_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->FinansKalemiGelir()->setSecilen($_REQUEST['finans_kalemi_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Fatura Kes")?></label>
										  	<select name="fatura_kes" id="fatura_kes" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->FaturaKes()->setSecilen($_REQUEST['fatura_kes'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Sipariş Durumu")?></label>
										  	<select name="fatura_durum_id" id="fatura_durum_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->FaturaDurumlar()->setSecilen($_REQUEST['fatura_durum_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-xl-2 col-sm-4 mb-2">        
								        <div class="form-group">
								        	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="tarih_var" name="tarih_var" <?=($_REQUEST['tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="tarih_var"><?=dil("Kayıt Tarih")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="tarih" name="tarih" value="<?=$_REQUEST['tarih']?>" readonly>
									        </div>
									    </div>
								    </div>								
								    <div class="col-xl-2 col-sm-4 mb-2">        
								        <div class="form-group">
								        	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="fatura_tarih_var" name="fatura_tarih_var" <?=($_REQUEST['fatura_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="fatura_tarih_var"><?=dil("Fatura Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="fatura_tarih" name="fatura_tarih" value="<?=$_REQUEST['fatura_tarih']?>" readonly>
									        </div>
									    </div>
								    </div>
								    <div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Sıralama")?></label>
										  	<select name="siralama" id="siralama" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->FaturaSiralama()->setSecilen($_REQUEST['siralama'])->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
										  	<label class="form-label">&nbsp;</label><br>
									  		<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncFiltrele()"><?=dil("Filtrele")?></button>
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
	                        <h2> <i class="fal fa-list mr-3"></i> <?=dil("Satış Faturaları")?>&nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
	                        <div class="panel-toolbar">
	                            <a href="/finans/satis_fatura.do?route=finans/satis_faturalar" class="btn btn-icon btn-outline-secondary text-white border-white mr-1" title="Ekle"> <i class="far fa-plus"></i> </a>
				            	<a href="../excel_sql.do?" title="Excel" class="btn btn-icon btn-outline-secondary text-white border-white"> <i class="far fa-table"></i> </a>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
								<div class="table-responsive">
							  	<table class="table table-condensed table-hover table-sm">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center">#</td>
								          	<td align="center"><?=dil("İşlem No")?></td>
								          	<td align="center"><?=dil("Fatura Tarih")?></td>
								          	<td align="center"><?=dil("Vade Tarih")?></td>
								          	<td><?=dil("Fatura No")?></td>
								          	<td><?=dil("Finans Kalemi")?></td>
											<td><?=dil("Cari Kodu")?></td>
								          	<td><?=dil("Cari")?></td>
								          	<td align="right" nowrap><?=dil("KDVsiz Tutar")?></td>
								          	<td align="right" nowrap><?=dil("KDV Tutar")?></td>
								          	<td align="right" nowrap><?=dil("Fatura Tutar")?></td>
								          	<td><?=dil("Kayıt Yapan")?></td>
								          	<td><?=dil("Açıklama")?></td>
								          	<td class="no-sort"></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?
								        foreach($rows as $key=>$row) {
								        	$TOPLAM["KDVSIZ_TUTAR"] += $row->KDVSIZ_TUTAR;
								        	$TOPLAM["KDV_TUTAR"]	+= $row->KDV_TUTAR;
								        	$TOPLAM["TUTAR"] 		+= $row->TUTAR;
								        	?>
									        <tr>
									          	<td align="center" class="bg-gray-100"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td align="center"> 
									          		<?if($row->FINANS_KALEMI_ID == 14) {?>
									          			<a href="/finans/satis_fatura.do?route=finans/satis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn <?=($row->RESIM_VAR == 1)?'btn-danger':'btn-outline-danger'?> waves-effect waves-themed btn-xs fs-lg"> <?=$row->ID?></a> 
									          		<?}else{?>
									          			<a href="/finans/satis_fatura.do?route=finans/satis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs fs-lg"> <?=$row->ID?></a>
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
									          	<td><?=$row->FATURA_NO?></td>
									          	<td><?=$row->FINANS_KALEMI?></td>
									          	<td><?=$row->CARI_KODU?></td>
									          	<td> <a href="<?=fncEkstrePopupLink($row)?>" title="Ektre"> <?=FormatYazi::kisalt($row->CARI,25)?> </a> </td>									          	
									          	<td align="right"><?=FormatSayi::db2tr($row->KDVSIZ_TUTAR)?></td>
									          	<td align="right"><?=FormatSayi::db2tr($row->KDV_TUTAR)?></td>
									          	<td align="right"><?=FormatSayi::db2tr($row->TUTAR)?></td>
									          	<td><?=$row->KAYIT_YAPAN?></td>
									          	<td style="max-width: 250px"><?=$row->ACIKLAMA?></td>
									          	<td align="left" class="p-0" nowrap>
									          		<a href="<?=fncFaturaPopupLink($row)?>" class="btn btn-outline-primary btn-icon"> <i class="fal fa-eye"></i> </a>
									          		<a href="/finans/satis_fatura.do?route=finans/satis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn btn-outline-primary btn-icon" title="Düzenle"> <i class="far fa-edit"></i> </a>
									          		<?if(strlen($row->EFATURA_UUID) > 1){?>
									          		<a href="<?=fncEFaturaPopupLink($row)?>" class="btn btn-outline-primary btn-icon"> <i class="fal fa-bullseye" title="Efatura PDF"></i> </a>
									          		<?}?>
									          	</td>
									        </tr>
								        <?}?>
							        </tbody>
							        <thead class="thead-themed fw-500">
							        	<tr>
								          	<td colspan="7"> </td>
								          	<td align="right"> <?=dil("Toplam")?> : </td>		          	
								          	<td align="right"> <?=FormatSayi::db2tr($TOPLAM["KDVSIZ_TUTAR"])?> </td>
								          	<td align="right"> <?=FormatSayi::db2tr($TOPLAM["KDV_TUTAR"])?> </td>
								          	<td align="right"> <?=FormatSayi::db2tr($TOPLAM["TUTAR"])?> </td>
								          	<td> </td>
								          	<td> </td>
								          	<td> </td>
								        </tr>
								    </thead>
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
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
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
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		$("#fatura_no, #islem_no, #talep_no, #plaka").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
        
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
		
		$('.datatable').DataTable({
		  	paging: true,
		  	pageLength: 100,
		 	lengthChange: true,
		  	searching: true,
		  	ordering: true,
		  	info: false,
		  	autoWidth: false,
		  	select: true,
		  	autoFill: false,
		  	responsive: true,
        	columnDefs: [{ targets: 'no-sort', orderable: false }],
			lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Tümü"]],
		});
		
	</script>
    
</body>
</html>
