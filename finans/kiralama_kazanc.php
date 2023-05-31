<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("ID","ID","");
	$excel->sutunEkle("Plaka","PLAKA","");
	$excel->sutunEkle("Marka","MARKA","");
	$excel->sutunEkle("Model","MODEL","");
	$excel->sutunEkle("Model Yılı","MODEL_YILI","");
	$excel->sutunEkle("Segment","SEGMENT","");
	$excel->sutunEkle("Vites","VITES","");
	$excel->sutunEkle("Yakıt","YAKIT","");
	$excel->sutunEkle("Sasi No","SASI_NO","");
	$excel->sutunEkle("Notor No","MOTOR_NO","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("İlk KM","ILK_KM","");
	$excel->sutunEkle("Son KM","SON_KM","");
	$excel->sutunEkle("Fark KM","FARK_KM","");
	$excel->sutunEkle("Veriliş Tarih","VERILIS_TARIH","");
	$excel->sutunEkle("Tahmini İade Tarih","TAHMINI_IADE_TARIH","");
	$excel->sutunEkle("İade Tarih","IADE_TARIH","");
	$excel->sutunEkle("Kalan Gün","KALAN_GUN","");
	$excel->sutunEkle("Süreç","SUREC","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaKiralamalar")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows = $Table['rows'];//echo json_encode($rows);die();
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
    	<ol class="breadcrumb page-breadcrumb breadcrumb-seperator-1">
            <li class="breadcrumb-item"><a href="/"><?=dil("Kontrol Paneli")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Kiralama Kazanç")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
        <section class="content">
	    	<div class="row hidden-print">
		    	<div class="col-md-12">
			    	<div class="panel">
			    	<div class="panel-container show">
                        <div class="panel-content">
							<form name="form" id="form" class="app-forms" enctype="multipart/form-data" method="GET">
								<input type="hidden" name="route" value="<?=$_REQUEST['route']?>">
								<input type="hidden" name="sayfa" id="sayfa">
								<input type="hidden" name="filtre" value="1">
								<div class="row">
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Plaka")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$_REQUEST['plaka']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Marka")?></label>
										  	<select name="yetki_id" id="yetki_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Markalar()->setSecilen($_REQUEST['marka_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">   
								        <div class="form-group">
									      	<label class="form-label"> <?=dil("Vites")?> </label>
									      	<select name="vites_id" id="vites_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->VitesTuru()->setSecilen($_REQUEST['vites_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
									    </div>
								    </div>
								    <div class="col-md-2 mb-2">   
								        <div class="form-group">
									      	<label class="form-label"> <?=dil("Yakıt")?> </label>
									      	<select name="yakit_id" id="yakit_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->YakitTuru()->setSecilen($_REQUEST['yakit_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
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
                                                    <input type="checkbox" class="custom-control-input" id="verilis_tarih_var" name="verilis_tarih_var" <?=($_REQUEST['verilis_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="verilis_tarih_var"><?=dil("Veriliş Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="verilis_tarih" name="verilis_tarih" value="<?=$_REQUEST['verilis_tarih']?>" readonly>
									        </div>
									    </div>
								    </div>								
								    <div class="col-xl-2 col-sm-4 mb-2">        
								        <div class="form-group">
								        	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="tahmini_iade_tarih_var" name="tahmini_iade_tarih_var" <?=($_REQUEST['tahmini_iade_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="tahmini_iade_tarih_var"><?=dil("Tahmini İade Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="tahmini_iade_tarih" name="tahmini_iade_tarih" value="<?=$_REQUEST['tahmini_iade_tarih']?>" readonly>
									        </div>
									    </div>
								    </div>
								    <div class="col-xl-2 col-sm-4 mb-2">        
								        <div class="form-group">
								        	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="iade_tarih_var" name="iade_tarih_var" <?=($_REQUEST['iade_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="iade_tarih_var"><?=dil("İade Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="iade_tarih" name="iade_tarih" value="<?=$_REQUEST['iade_tarih']?>" readonly>
									        </div>
									    </div>
								    </div>
								    <div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Kiralama Süreç")?></label>
										  	<select name="surec_id" id="surec_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->KiralamaSurec()->setSecilen($_REQUEST['surec_id'])->setTumu()->getSelect("ID","AD")?>
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
                        <h2> <i class="fal fa-car mr-3 fa-2x"></i> <?=dil("Kiralama Kazanç")?> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-outline-secondary btn-icon waves-effect waves-themed border-white text-white"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover datatable">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center" class="no-sort">#</td>
								          	<td><?=dil("Plaka")?></td>
								          	<td><?=dil("Marka - Model")?></td>
								          	<td><?=dil("Cari")?></td>
								          	<td align="right"><?=dil("İlk KM")?></td>
								          	<td align="right"><?=dil("Son KM")?></td>
								          	<td align="right"><?=dil("Fark KM")?></td>
								          	<td align="center"><?=dil("Veriliş Tarih")?></td>
								          	<td align="center"><?=dil("Tah.İade Tarih")?></td>
								          	<td align="center"><?=dil("İade Tarih")?></td>
								          	<td align="center"><?=dil("Fatura Tutar")?></td>
								          	<td align="center"><?=dil("Süreç")?></td>
								          	<td> </td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td><?=$row->PLAKA?></td>
									          	<td>
									          		<?=$row->MARKA?><br>
									          		<?=FormatYazi::kisalt($row->MODEL,25)?>
									          	</td>
									          	<td><?=$row->CARI?></td>
									          	<td align="center"><?=FormatSayi::sayi($row->ILK_KM,0)?></td>
									          	<td align="center"><?=FormatSayi::sayi($row->SON_KM,0)?></td>
									          	<td align="center"><?=FormatSayi::sayi($row->FARK_KM,0)?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->VERILIS_TARIH)?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->TAHMINI_IADE_TARIH)?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->IADE_TARIH)?></td>
									          	<td align="center"><?=FormatSayi::sayi($row->FATURA_TUTAR,2)?></td>
									          	<td align="center"><?=$row->SUREC?></td>
									          	<td align="center"> 
									          		<a href="/kiralama/kiralama.do?route=<?=$_REQUEST['route']?>&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn btn-outline-primary btn-icon" title="Araç Düzenle"> <i class="far fa-edit"></i> </a> 
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
    <script src="../smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
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
    
		$("[data-mask]").inputmask();
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
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
		
		$('#tarih, #verilis_tarih, #tahmini_iade_tarih, #iade_tarih').daterangepicker({
			timePicker: false,
			timePicker24Hour: true,
			timePickerIncrement: 30, 
			locale: {
		        "format": "DD-MM-YYYY",
		        "separator": " , ",
		        "applyLabel": "Tamam",
		        "cancelLabel": "İptal",
		        "fromLabel": "From",
		        "toLabel": "To",
		        "customRangeLabel": "Custom",
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
		});
		
		
		$("#kullanici, #ad, #soyad, #unvan").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
				
	</script>
    
</body>
</html>
