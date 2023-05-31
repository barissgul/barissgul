<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("İşlem No","ID","");
	$excel->sutunEkle("Finans Kalemi","FINANS_KALEMI","");
	$excel->sutunEkle("Ödeme Kanalı","ODEME_KANALI","");
	$excel->sutunEkle("Kasa","ODEME_KANALI_DETAY","");
	$excel->sutunEkle("Talep No","TALEP_ID","");
	$excel->sutunEkle("Kiralama No","KIRALAMA_ID","");
	$excel->sutunEkle("Plaka","PLAKA","");
	$excel->sutunEkle("Ödeyen Cari","CARI","");
	$excel->sutunEkle("Ödenen Tutar","TUTAR","");
	$excel->sutunEkle("Ödeme Tarihi","TARIH","");
	$excel->sutunEkle("Kayıt Yapan","KAYIT_YAPAN","");
	$excel->sutunEkle("Açıklama","ACIKLAMA","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaTahsilatlar")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
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
    <link rel="apple-touch-icon" sizes="180x180" href="../smartadmin/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/smartadmin/img/favicon/favicon-32x32.png">
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
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Talep No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="talep_no" id="talep_no" value="<?=$_REQUEST['talep_no']?>" maxlength="10">
									    </div>
									</div>
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Plaka")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$_REQUEST['plaka']?>" maxlength="15">
									    </div>
									</div>
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("İşlem No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="islem_no" id="islem_no" value="<?=$_REQUEST['islem_no']?>" maxlength="15">
									    </div>
									</div>
									<div class="col-xl-4 col-sm-6 mb-2">   
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Cari")?> </label>
										  	<select name="cari_id" id="cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->Cariler()->setSecilen($_REQUEST['cari_id'])->setTumu()->getSelect("ID","AD")?>
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
									      	<label class="form-label"> <?=dil("Ödeme Kanalı")?> </label>
									      	<select name="odeme_kanali_id" id="odeme_kanali_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" onchange="fncOdemeKanali(this)">
										      	<?=$cCombo->OdemeKanallari()->setSecilen($_REQUEST['odeme_kanali_id'])->setSeciniz()->getSelect("ID","AD")?>
										    </select>
									    </div>
									</div>
									<div class="col-md-2 mb-2">       
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Ödeme Kanalı Detay")?> </label>
									      	<select name="odeme_kanali_detay_id" id="odeme_kanali_detay_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->OdemeKanaliDetay(array("odeme_kanali_id"=>$_REQUEST['odeme_kanali_id']))->setSecilen($_REQUEST['odeme_kanali_detay_id'])->setSeciniz()->getSelect("ID","AD")?>
										    </select>
									    </div>
									</div>
								    <div class="col-xl-2 col-sm-4 mb-2">        
								        <div class="form-group">
								        	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="odeme_tarih_var" name="odeme_tarih_var" <?=($_REQUEST['odeme_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="odeme_tarih_var"><?=dil("Ödeme Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="odeme_tarih" name="odeme_tarih" value="<?=$_REQUEST['odeme_tarih']?>" readonly>
									        </div>
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
									<div class="col-md-2">
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
	                        <h2> <i class="fal fa-lira-sign mr-3"></i> <?=dil("Tahsilatlar")?> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
	                        <div class="panel-toolbar">
	                            <a href="javascript:void(0)" onclick="fncPopup('/finans/tahsilat.do?route=finans/tahsilat','TAHSILAT_EKLE',780,730)" class="btn btn-icon btn-light mr-1" title="Tahsilat Ekle"> <i class="far fa-plus"></i> </a>
				            	<a href="../excel_sql.do" title="Excel" class="btn btn-light btn-icon"> <i class="far fa-file-excel"></i> </a>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
								<div class="table-responsive">
							  	<table class="table table-sm table-condensed table-hover">
							  		<thead class="thead-themed">
								    	<tr>
								          	<td align="center">#</td>
								          	<td><?=dil("İşlem No")?></td>
								          	<td><?=dil("Ödeme Kanalı")?></td>
								          	<td><?=dil("Ödeme Kanalı Detay")?></td>
								          	<td><?=dil("Talep No")?></td>
								          	<td><?=dil("Kiralama No")?></td>
								          	<td><?=dil("Plaka")?></td>
								          	<td><?=dil("Cari")?></td>							          	
								          	<td align="right"><?=dil("Tutar")?>(<i class="far fa-lira-sign"></i>)</td>
								          	<td align="center"><?=dil("Ödeme Tarih")?></td>
								          	<td><?=dil("Kayıt Yapan")?></td>
								          	<td><?=dil("Açıklama")?></td>
								          	<td></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?
								        foreach($rows as $key=>$row) {
								        	$TOPLAM["TUTAR"] += $row->TUTAR;
								        	?>
									        <tr>
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td><?=$row->ID?></td>
									          	<td><?=$row->ODEME_KANALI?></td>
									          	<td><?=$row->ODEME_KANALI_DETAY?></td>
									          	<td><?=$row->TALEP_ID?></td>
									          	<td><?=$row->KIRALAMA_ID?></td>
									          	<td><?=$row->PLAKA?></td>
									          	<td> <a href="javascript:fncPopup('/finans/ekstre.do?route=finans/ekstre&kod=<?=$row->CARI_KOD?>&filtre=1','EKSTRE',1000,800);" title="Ektre"> <?=$row->CARI?> </a> </td>		          	
									          	<td align="right"><?=FormatSayi::db2tr($row->TUTAR)?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
									          	<td><?=$row->KAYIT_YAPAN?></td>
									          	<td style="max-width: 250px;"><?=$row->ACIKLAMA?></td>
									          	<td align="center" class="p-0">
									          		<a href="<?=fncOdemePopupLink($row)?>" class="btn btn-outline-primary btn-icon"> <i class="fal fa-eye"></i> </a>
									          		<a href="javascript:void(0)" onclick="fncPopup('/finans/tahsilat.do?route=finans/tahsilat&id=<?=$row->ID?>&kod=<?=$row->KOD?>','TAHSILAT',780,720 )" class="btn btn-outline-primary btn-icon" title="Ödeme"> <i class="far fa-calculator"></i> </a>
									          	</td>	
									        </tr>
								        <?}?>
								        <tr class="thead-themed">
								          	<td colspan="7"> </td>
								          	<td align="right"> <?=dil("Toplam")?> : </td>		          	
								          	<td align="right"> <?=FormatSayi::db2tr($TOPLAM["TUTAR"])?> </td>
								          	<td> </td>
								          	<td> </td>
								          	<td> </td>
								          	<td> </td>
								        </tr>
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
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		var start = moment().subtract(29, 'days');
        var end = moment();
		
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
            
		$('#tarih, #odeme_tarih').daterangepicker({
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
		
		$("#talep_no, #plaka, #islem_no").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
		
		function fncOdemeKanali(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "odeme_kanali_detay_doldur", 'odeme_kanali_id': $(obj).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$("#odeme_kanali_detay_id").html(jd.HTML);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
	</script>
    
</body>
</html>
