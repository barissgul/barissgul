<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();

	$_REQUEST["filtre"] = 1;
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("Parça Kodu","PARCA_KODU","");
	$excel->sutunEkle("Parça Adı","PARCA_ADI","");
	$excel->sutunEkle("Adet","ADET","");
	$excel->sutunEkle("Son Fiyat","ADET","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaStoklar")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
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
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="<?=$cBootstrap->getBody()?>">
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
									      	<label class="form-label"> <?=dil("Parça Kodu")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="parca_kodu" id="parca_kodu" value="<?=$_REQUEST['parca_kodu']?>" maxlength="30">
									    </div>
									</div>
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Parça Adı")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="parca_adi" id="parca_adi" value="<?=$_REQUEST['parca_adi']?>" maxlength="100">
									    </div>
									</div>
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Plaka")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$_REQUEST['plaka']?>" maxlength="15">
									    </div>
									</div>
									<div class="col-xl-6 col-sm-6 mb-2">   
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
                                                    <label class="custom-control-label" for="tarih_var"><?=dil("Alış Tarih")?></label>
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
		    	<div class="col-xl-12">
		    		<div class="panel">
                    <div class="panel-hdr bg-primary-300 text-white">
                        <h2> <b> <?=dil("Stoklar")?> </b> <span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
			            	<a href="../excel_sql.do?" title="Excel" class="btn btn-light btn-icon btn-sm"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed">
							    	<tr>
							          	<td align="center">#</td>
							          	<td><?=dil("Parça Kodu")?></td>
							          	<td><?=dil("Parça Adı")?></td>
							          	<td align="right"><?=dil("Adet")?></td>
							        </tr>
						        </thead>
						        <tbody>
							        <?
							        foreach($rows as $key=>$row) {
							        	$row_toplam->ADET 	+= $row->ADET;
							        	?>
								        <tr>
								          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
								          	<td> <a href="javascript:fncPopup('/finans/stok_detay.do?route=finans/stok_detay&parca_kodu=<?=$row->PARCA_KODU?>&filtre=1','STOK_DETAY',1000,800);" title="Ektre"> <?=$row->PARCA_KODU?> </a> </td>
								          	<td><?=$row->PARCA_ADI?></td>
								          	<td align="right"><?=FormatSayi::db2tr($row->ADET)?></td>
								        </tr>
							        <?}?>
							        <tr class="thead-themed">
							          	<td colspan="2"> </td>
							          	<td align="right"> <?=dil("Toplam")?>: </td>
							          	<td align="right"> <?=FormatSayi::db2tr($row_toplam->ADET)?></td>
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
		
		$("#talep_no, #plaka, #dosya_no").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
		
	</script>
    
</body>
</html>
