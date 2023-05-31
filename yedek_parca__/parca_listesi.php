<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	if($_REQUEST['arama_q']) {
		$_REQUEST['filtre'] 	= 1;
	}
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("#","SIRA","");
	$excel->sutunEkle("Marka","PARCA_MARKA","");
	$excel->sutunEkle("Parça Kodu","PARCA_KODU","");
	$excel->sutunEkle("Oem Kodu","OEM_KODU","");
	$excel->sutunEkle("Referans Kodu","REFERANS_KODU","");
	$excel->sutunEkle("Parça","PARCA_ADI","");
	$excel->sutunEkle("Araç","MARKA","");
	$excel->sutunEkle("Alış Fiyat","ALIS_FIYAT","");
	$excel->sutunEkle("Satış Fiyat","SATIS_FIYAT","");
	$excel->sutunEkle("Para Birim","PARA_BIRIM","");
	$excel->sutunEkle("Birim","BIRIM","");
	$excel->sutunEkle("Adet","ADET","");
	$excel->sutunEkle("Stok","STOK","");
	$excel->sutunEkle("Kampanyalı","KAMPANYALI","");
	$excel->sutunEkle("Parça Tipi","PARCA_TIPI","");
	if($_SESSION['hizmet_noktasi'] == "0"){
		$excel->sutunEkle("Tedarikçi ID","TEDARIKCI_ID","");
		$excel->sutunEkle("Tedarikçi","TEDARIKCI","");
	}
	$excel->sutunEkle("UUID","UUID","");
	$excel->sutunEkle("Tarih","TARIH","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaParcaListesi")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows = $Table['rows'];
	$_SESSION['Table'] = $Table;
	//var_dump2($Table['sqls']);
	//var_dump2($_SESSION);
?>
<!DOCTYPE html>
<html lang="tr" class="<?=$cBootstrap->getFontBoyut()?>">
<head>
    <meta charset="utf-8">
    <title> <?=$row_site->TITLE?> <?=dil("Parça Listesi")?></title>
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
            <li class="breadcrumb-item active"><?=dil("Parça Listesi")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
        <section class="content">
	    	<div class="row hidden-print">
		    	<div class="col-md-12">
			    	<div class="panel" id="panel1">
			    		<!--
			    		<div class="panel-hdr bg-primary-300">
                            <h2><i class="fa fa-filter mr-3"></i> <?=dil("Filtrele")?></h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
								<button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
								<button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                            </div>
                        </div>
                        -->
                        <div class="panel-container show">
                        <div class="panel-content">
							<form name="form" id="form" class="app-forms" enctype="multipart/form-data" method="GET">
								<input type="hidden" name="route" value="<?=$_REQUEST['route']?>">
								<input type="hidden" name="sayfa" id="sayfa">
								<input type="hidden" name="filtre" value="1">
								<div class="row">
									<div class="col-xl-2 col-sm-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Oem Kodu")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="oem_kodu" id="oem_kodu" value="<?=$_REQUEST['oem_kodu']?>" maxlength="25">
									    </div>
									</div>
									<div class="col-xl-2 col-sm-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Parça Kodu")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="parca_kodu" id="parca_kodu" value="<?=$_REQUEST['parca_kodu']?>" maxlength="25">
									    </div>
									</div>
									<div class="col-xl-2 col-sm-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Parça Adı")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="parca_adi" id="parca_adi" value="<?=$_REQUEST['parca_adi']?>" maxlength="100">
									    </div>
									</div>
									<div class="col-xl-2 col-sm-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("UUID")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="uuid" id="uuid" value="<?=$_REQUEST['uuid']?>" maxlength="50">
									    </div>
									</div>
									<div class="col-md-4 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Tedarikci")?></label>
										  	<select name="tedarikci_id" id="tedarikci_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->Tedarikciler()->setSecilen($_REQUEST['tedarikci_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Marka")?></label>
										  	<select name="parca_marka_id" id="parca_marka_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->ParcaMarkalar()->setSecilen($_REQUEST['parca_marka_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>	
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Araç")?></label>
										  	<select name="marka_id" id="marka_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->Markalar()->setSecilen($_REQUEST['marka_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>	
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Parça Tipi")?></label>
										  	<select name="parca_tipi_id" id="parca_tipi_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->ParcaTipi()->setSecilen($_REQUEST['parca_tipi_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-xl-2 col-sm-4 mb-2">        
										<div class="custom-control custom-switch custom-control-inline mt-3">
                                            <input type="checkbox" class="custom-control-input" id="stok_var" name="stok_var" <?=($_REQUEST['stok_var'])?' checked':''?>>
                                            <label class="custom-control-label" for="stok_var"><?=dil("Stokda Var")?></label>
                                        </div>
                                        <br>
								        <div class="custom-control custom-switch custom-control-inline mt-2">
                                            <input type="checkbox" class="custom-control-input" id="kampanyali" name="kampanyali" <?=($_REQUEST['kampanyali'])?' checked':''?>>
                                            <label class="custom-control-label" for="kampanyali"><?=dil("Kampanyalı")?></label>
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
                        <h2><i class="fa fa-list mr-3"></i> <?=dil("Parça Listesi")?> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
		            		<a href="../excel_sql.do?" title="Excel" class="btn btn-outline-primary waves-effect waves-themed text-white border-white btn-icon mr-1"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center">#</td>	
								          	<td><?=dil("Marka")?></td>
								          	<td><?=dil("Parça Kodu")?></td>
								          	<td><?=dil("Oem Kodu")?></td>
								          	<td><?=dil("Referans Kodu")?></td>
								          	<td><?=dil("Parça Adı")?></td>
								          	<td><?=dil("Araç")?></td>
								          	<td align="right"><?=dil("Gelen Fiyat")?></td>
								          	<td align="right"><?=dil("Alış Fiyat")?></td>
								          	<td align="right"><?=dil("Satış Fiyat")?></td>
								          	<td align="center"><?=dil("Birim")?></td>
								          	<td align="right"><?=dil("Adet")?></td>
								          	<td align="center"><?=dil("Stok")?></td>
								          	<td align="center"><?=dil("Kampanyalı")?></td>
								          	<td><?=dil("Parça Tipi")?></td>
								          	<?if($_SESSION['hizmet_noktasi'] == "0"){?>
								          	<td><?=dil("Tedarikçi")?></td>
								          	<?}?>
								          	<td><?=dil("Durum")?></td>
								          	<td align="center"><?=dil("Kayıt Tarih")?></td>
								          	<td> </td>
								        </tr>
							        </thead>
							        <tbody>
								        <?
								        foreach($rows as $key=>$row) {								        	
								        	?>
									        <tr>
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td><?=$row->PARCA_MARKA?></td>
									          	<td><?=$row->PARCA_KODU?></td>
									          	<td><?=$row->OEM_KODU?></td>
									          	<td><?=$row->REFERANS_KODU?></td>
									          	<td style="max-width: 300px"><?=$row->PARCA_ADI?></td>
									          	<td><?=$row->MARKA?></td>
									          	<td align="right"><?=FormatSayi::sayi($row->ALIS_FIYAT_ILK)?> </td>
									          	<td align="right"><?=FormatSayi::sayi($row->ALIS_FIYAT)?> </td>
									          	<td align="right"><?=FormatSayi::sayi($row->SATIS_FIYAT)?> </td>
									          	<td align="center"><?=$row->BIRIM?></td>
									          	<td align="right"><?=$row->ADET?></td>
									          	<td align="center"><?=$row->STOK?></td>
									          	<td align="center"><?=($row->KAMPANYALI == 1) ? "KAMPANYALI" : ""?></td>
									          	<td><?=$row->PARCA_TIPI?></td>
									          	<?if($_SESSION['hizmet_noktasi'] == "0"){?>
									          	<td><?=FormatYazi::kisalt($row->TEDARIKCI,25)?></td>
									          	<?}?>
									          	<td><?=$row->DURUM?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->TARIH)?></td>
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
            
		$('#tarih, #arac_gelis_tarih, #tahmini_teslim_tarih, #teslim_tarih').daterangepicker({
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
		
		$("#oem_kodu, #parca_kodu").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
		
	</script>
    
</body>
</html>
