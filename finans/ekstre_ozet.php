<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$_REQUEST["filtre"] = 1;
	
	$_REQUEST['vade_tarih'] = ($_REQUEST['vade_tarih'] ? $_REQUEST['vade_tarih'] : date("d.m.Y"));
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("Cari Kod","CARI_KODU","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("Satış Hareket","SATIS_SAY","");
	$excel->sutunEkle("Alış Hareket","ALIS_SAY","");
	$excel->sutunEkle("Son Hareket Tarih","TARIH","");
	$excel->sutunEkle("Bakiye","FATURA_TUTAR","");
	$excel->sutunEkle("Vade Tarihi Geçmiş","GECMIS_TUTAR","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaEkstreOzet")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <script src='../smartadmin/plugin/pdfmake-master/build/pdfmake.min.js'></script>
 	<script src='../smartadmin/plugin/pdfmake-master/build/vfs_fonts.js'></script>
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
									      	<label class="form-label"> <?=dil("Plaka")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$_REQUEST['plaka']?>" maxlength="15">
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
										  	<label class="form-label"><?=dil("Ödeme Kanalı")?></label>
										  	<select name="odeme_kanali_id" id="odeme_kanali_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->OdemeKanallari()->setSecilen($_REQUEST['odeme_kanali_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Finans Kalemi")?></label>
										  	<select name="finans_kalemi_id" id="finans_kalemi_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->FinansKalemi()->setSecilen($_REQUEST['finans_kalemi_id'])->setTumu()->getSelect("ID","AD")?>
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
                                                    <input type="checkbox" class="custom-control-input" id="odeme_tarih_var" name="odeme_tarih_var" <?=($_REQUEST['odeme_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="odeme_tarih_var"><?=dil("Ödeme/Fatura Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="odeme_tarih" name="odeme_tarih" value="<?=$_REQUEST['odeme_tarih']?>" readonly>
									        </div>
									    </div>
								    </div>
								    <div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Borç / Alacak")?></label>
										  	<select name="borc_alacak" id="borc_alacak" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->BorcAlacak()->setSecilen($_REQUEST['borc_alacak'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-1">
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
                        <h2> <i class="fal fa-list mr-3"></i> <b> <?=dil("Ekstre Özet")?> </b> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                        	<?if($_REQUEST['hizmet_noktasi'] == 1){?>
                        	<a href="javascript:void(0)" onclick="fncPopup('/finans/tahsilat.do?route=finans/tahsilat','TAHSILAT',780,780)" class="btn btn-icon btn-light mr-1 btn-sm" title="Tahsilat Ekle"> <i class="far fa-plus"></i> </a>
                        	<?}?>
			            	<a href="../excel_sql.do?" title="Excel" class="btn btn-outline-primary btn-icon waves-effect waves-themed text-white border-white mr-1"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
						  	<table class="table table-sm table-condensed table-hover datatable">
						  		<thead class="thead-themed fw-500">
							    	<tr>
							          	<td align="center">#</td>
							          	<td class="no-sort"><?=dil("Not")?></td>
							          	<td><?=dil("Cari Kod")?></td>
							          	<td><?=dil("Cari")?></td>
							          	<td align="center"><?=dil("Borç Hareket")?></td>
							          	<td align="center"><?=dil("Alacak Hareket")?></td>
							          	<td align="center"><?=dil("Son Hareket Tarih")?></td>
							          	<td align="right"><?=dil("Bakiye")?> </td>
							          	<td align="right"><?=dil("Vade Tarihi Geçmiş")?> </td>
							        </tr>
						        </thead>
						        <tbody>
							        <?
							        foreach($rows as $key=>$row) {
							        	$row_toplam->FATURA_TUTAR 	+= -1 * $row->FATURA_TUTAR;
							        	$row_toplam->SATIS_SAY 		+= $row->SATIS_SAY;
							        	$row_toplam->ALIS_SAY 		+= $row->ALIS_SAY;
							        	
							        	//if($row->GECMIS_TUTAR > 0) $row->GECMIS_TUTAR = "0.00";
							        	$row_toplam->GECMIS_TUTAR 	+= -1 * $row->GECMIS_TUTAR;
							        	?>
								        <tr>
								          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
								          	<td> <a href="javascript:void(0)" class="btn btn-info btn-xs btn-icon" onclick="<?=fncCariNotPopupLink((object)array("ID"=>$row->CARI_ID, "KOD"=>$row->CARI_KOD))?>"><i class="far fa-clipboard-list"></i></a> </td>
								          	<td> <a href="javascript:void(0)" onclick="<?=fncCariPopupLink((object)array("ID"=>$row->CARI_ID, "KOD"=>$row->CARI_KOD))?>"><?=$row->CARI_KODU?></a></td>
								          	<td> <a href="javascript:fncPopup('/finans/ekstre.do?route=finans/ekstre&kod=<?=$row->KOD?>&filtre=1&finans_kalemi_id=<?=$_REQUEST["finans_kalemi_id"]?>&talep_no=<?=$_REQUEST["talep_no"]?>&fatura_tarih=<?=$_REQUEST["odeme_tarih"]?>&fatura_tarih_var=<?=$_REQUEST["odeme_tarih_var"]?>','EKSTRE',1200,850);" title="Ektre"> <?=(is_null($row->CARI)?"...":$row->CARI)?> </a> </td>		          	
								          	<td align="center"><?=$row->SATIS_SAY?></td>
								          	<td align="center"><?=$row->ALIS_SAY?></td>
								          	<td align="center"><?=FormatTarih::tarih($row->TARIH)?></td>
								          	<td align="right" nowrap><?=FormatSayi::db2tr($row->FATURA_TUTAR)?> <i class="far fa-lira-sign"></i></td>
								          	<td align="right" nowrap><?=FormatSayi::db2tr($row->GECMIS_TUTAR)?> <i class="far fa-lira-sign"></i></td>
								        </tr>
							        <?}?>
						        </tbody>
						        <thead class="thead-themed fw-500">
						        	 <tr>
							          	<td> </td>
							          	<td> </td>
							          	<td> </td>
							          	<td align="right"> <?=dil("Toplam")?>: </td>
							          	<td align="center"><?=$row_toplam->SATIS_SAY?></td>
							          	<td align="center"><?=$row_toplam->ALIS_SAY?></td>
							          	<td> </td>
							          	<td align="right"><?=FormatSayi::db2tr($row_toplam->FATURA_TUTAR)?> <i class="far fa-lira-sign"></i></td>
							          	<td align="right"><?=FormatSayi::db2tr($row_toplam->GECMIS_TUTAR)?> <i class="far fa-lira-sign"></i></td>
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
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		$('.datepicker_vade').datepicker({
		  	format: 'dd.mm.yyyy',
		  	startDate: '-1y',
		  	endDate: '+1y',
		  	minDate: 0,
		  	language: 'tr',
		  	autoclose: true,
		  	todayHighlight: true,
		  	clearBtn: false,
	        orientation: "bottom left",
	        weekStart: 1
		  	
		});
		
		
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
            dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'colvis',
                    text: 'Başlık Gizle',
                    titleAttr: '',
                    className: 'btn-outline-default'
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    titleAttr: 'aaa',
                    className: 'btn-outline-default',
                    filename: 'Ektre ' +  moment().format("YYYY-MM-DD h.mm"),
                },
                {
			        extend: 'pdfHtml5',
			        text: 'PDF',
			        exportOptions: {
			            modifier: {
			                page: 'current'
			            }
			        },
			        header: true,
			        className: 'btn-outline-default',
			        title: 'Ekstre Özet',
			        orientation: 'landscape'
			    }, 
                {
                    extend: 'copyHtml5',
                    text: 'Kopyala',
                    titleAttr: '',
                    className: 'btn-outline-default'
                },
                {
                    extend: 'print',
                    text: '<i class="fal fa-print"></i>',
                    titleAttr: 'Yazdır',
                    className: 'btn-outline-default'
                }
            ],
            pageLength: 100,
           
        });
		
	</script>
    
</body>
</html>
