<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("#","SIRA","");
	$excel->sutunEkle("Talep No","ID","");
	$excel->sutunEkle("Plaka","PLAKA","");
	$excel->sutunEkle("Süreç","SUREC","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("Dosya No","DOSYA_NO","");
	$excel->sutunEkle("Fatura No","FATURA_NO","");
	$excel->sutunEkle("Fatura Kes","FATURA_KES","");
	$excel->sutunEkle("Fatura Tarih","FATURA_TARIH","");
	$excel->sutunEkle("Fatura Tutar","FATURA_TUTAR","");
	$excel->sutunEkle("Fatura Kdv","FATURA_KDV","");
	$excel->sutunEkle("Açıklama","ACIKLAMA","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaSatisFaturaRapor")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
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
    	<ol class="breadcrumb page-breadcrumb breadcrumb-seperator-1">
            <li class="breadcrumb-item"><a href="/"><?=dil("Kontrol Paneli")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Satış Fatura Rapor")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
        <section class="content">
	    	<div class="row hidden-print">
		    	<div class="col-md-12">
			    	<div class="panel" id="panel1">
			    		<div class="panel-hdr bg-primary-300">
                            <h2><i class="fa fa-filter mr-3"></i> <?=dil("Filtrele")?></h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
                            </div>
                        </div>
                        <div class="panel-container show">
                        <div class="panel-content">
							<form name="form" id="form" class="app-forms" enctype="multipart/form-data" method="GET">
								<input type="hidden" name="route" value="<?=$_REQUEST['route']?>">
								<input type="hidden" name="sayfa" id="sayfa">
								<input type="hidden" name="filtre" value="1">
								<div class="row">
									<div class="col-xl-2 col-sm-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Talep No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="talep_no" id="talep_no" value="<?=$_REQUEST['talep_no']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-xl-2 col-sm-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Plaka")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$_REQUEST['plaka']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-xl-2 col-sm-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Dosya No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="dosya_no" id="dosya_no" value="<?=$_REQUEST['dosya_no']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-xl-2 col-sm-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Fatura No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" value="<?=$_REQUEST['fatura_no']?>" maxlength="20">
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
								    <div class="col-xl-2 col-sm-4 mb-2">        
								        <div class="form-group">
								        	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="tarih_var" name="tarih_var" <?=($_REQUEST['tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="tarih_var"><?=dil("Kayıt Tarihi")?></label>
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
									<div class="col-md-2 col-sm-4 mb-2">
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
                        <h2><i class="fa fa-list mr-3"></i> <?=dil("Satış Fatura Rapor")?> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-outline-secondary btn-icon waves-effect waves-themed border-white text-white"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								    		<td align="center">#</td>
								          	<td align="center"><?=dil("İşlem No")?></td>
								          	<td align="center"><?=dil("Fatura Tarih")?></td>
								          	<td><?=dil("Fatura No")?></td>
								          	<td><?=dil("Finans Kalemi")?></td>
								          	<td><?=dil("Fatura Kes")?></td>
								          	<td><?=dil("Talep No")?></td>
								          	<td><?=dil("Plaka")?></td>
											<td><?=dil("Cari Kodu")?></td>
								          	<td><?=dil("Cari")?></td>
								          	<td align="right"><?=dil("Tutar")?>(<i class="far fa-lira-sign"></i>)</td>
								          	<td align="right"><?=dil("KDV")?>(<i class="far fa-lira-sign"></i>)</td>
								          	<td><?=dil("Kayıt Yapan")?></td>
								          	<td><?=dil("Açıklama")?></td>
								          	<td class="no-sort"></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									        	<td align="center" class="bg-gray-100"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td align="center"> 
									          		<?if($row->FINANS_KALEMI_ID == 14) {?>
									          			<a href="javascript:void()" class="btn <?=($row->RESIM_VAR == 1)?'btn-danger':'btn-outline-danger'?> waves-effect waves-themed btn-xs"> <?=$row->FATURA_ID?></a> 
									          		<?}else{?>
									          			<a href="javascript:void()" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs"> <?=$row->FATURA_ID?></a>
									          		<?}?>
									          	</td>
									          	<td align="center"><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
									          	<td><?=$row->FATURA_NO?></td>
									          	<td><?=$row->FINANS_KALEMI?></td>
									          	<td align="center"><?=$row->FATURA_KES?></td>
									          	<td><?=$row->TALEP_ID?></td>
									          	<td><?=$row->PLAKA?></td>
									          	<td><?=$row->CARI_KODU?></td>
									          	<td> <a href="<?=fncEkstrePopupLink($row)?>" title="Ektre"> <?=$row->CARI?> </a> </td>									          	
									          	<td align="right"><?=FormatSayi::db2tr($row->FATURA_TUTAR)?></td>
									          	<td align="right"><?=FormatSayi::db2tr($row->FATURA_KDV)?></td>
									          	<td><?=$row->KAYIT_YAPAN?></td>
									          	<td style="max-width: 250px"><?=$row->ACIKLAMA?></td>
									          	<td align="left" class="p-0">
									          		<a href="javascript:fncPopup('/finans/popup_fatura.do?route=finans/popup_fatura&id=<?=$row->FATURA_ID?>&kod=<?=$row->FATURA_KOD?>','POPUP_FATURA',1100,850);" class="btn btn-outline-primary btn-icon"> <i class="fal fa-list"></i> </a>
			                            			<a href="<?=fncOzetPopupLink($row)?>" class="btn btn-outline-primary btn-icon waves-effect waves-themed" title="Özet"> <i class="fal fa-eye"></i></a>
			                            			<a href="/finans/satis_fatura.do?route=finans/satis_faturalar&id=<?=$row->FATURA_ID?>&kod=<?=$row->FATURA_KOD?>" class="btn btn-outline-primary btn-icon" title="Düzenle"> <i class="far fa-edit"></i> </a>
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
    		
		function fncFiltrele(){
			$("#form").submit();
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
		
		$("#talep_no, #plaka, #dosya_no, #fatura_no").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
		
		function fncHizmetSurecDoldur(obj){
			$("#surec_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "hizmet_surec_doldur", 'hizmet_id' : $(obj).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						$('#surec_id').html("");
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$('#surec_id').html(jd.HTML);
					}
					$("#surec_id").removeAttr("disabled");
				}
			});
		}
				
	</script>
    
</body>
</html>
