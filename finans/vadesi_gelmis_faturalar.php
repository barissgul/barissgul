<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	if(!isset($_REQUEST["filtre"])) {
		$_REQUEST['vade_tarih_var'] = 1;
		$_REQUEST['vade_tarih'] 	= date("d-m-Y , d-m-Y");
	}
	
	$_REQUEST["filtre"] = 1;
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("İşlem No","ID","");
	$excel->sutunEkle("Fatura Tarih","FATURA_TARIH","format1");
	$excel->sutunEkle("Vade Tarih","VADE_TARIH","format1");
	$excel->sutunEkle("Fatura No","FATURA_NO","");
	$excel->sutunEkle("Finans Kalemi","FINANS_KALEMI","");
	$excel->sutunEkle("Hareket","HAREKET","");
	$excel->sutunEkle("Talep No","TALEP_ID","");
	$excel->sutunEkle("Plaka","PLAKA","");	
	$excel->sutunEkle("Dosya No","DOSYA_NO","");
	$excel->sutunEkle("Cari Kodu","CARI_KODU","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("Tutar","TUTAR","");
	$excel->sutunEkle("Kayıt Yapan","KAYIT_YAPAN","");
	$excel->sutunEkle("Açıklama","ACIKLAMA","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaVadesiGelmisFaturalar")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
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
									      	<label class="form-label"> <?=dil("Fatura No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" value="<?=$_REQUEST['fatura_no']?>" maxlength="16">
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
								    <div class="col-xl-2 col-sm-4 mb-2">        
								        <div class="form-group">
								        	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="vade_tarih_var" name="vade_tarih_var" <?=($_REQUEST['vade_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="vade_tarih_var"><?=dil("Vade Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="vade_tarih" name="vade_tarih" value="<?=$_REQUEST['vade_tarih']?>" readonly>
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
                        <h2> <b> <?=dil("Vadesi Gelmiş Faturalar")?> </b> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                        	<a href="javascript:void(0)" onclick="fncPopup('/finans/tahsilat.do?route=finans/tahsilat','TAHSILAT',780,780)" class="btn btn-icon btn-light mr-1 btn-sm" title="Tahsilat Ekle"> <i class="far fa-plus"></i> </a>
			            	<a href="../excel_sql.do?" title="Excel" class="btn btn-light btn-icon btn-sm"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed fw-500">
							    	<tr>
							          	<td align="center">#</td>
							          	<td align="center"><?=dil("İşlem No")?></td>
							          	<td align="center"><?=dil("Fatura Tarih")?></td>
							          	<td align="center"><?=dil("Vade Tarih")?></td>
							          	<td><?=dil("Fatura No")?></td>
							          	<td><?=dil("Hareket")?></td>
							          	<td><?=dil("Finans Kalemi")?></td>
							          	<td><?=dil("Plaka")?></td>
							          	<td><?=dil("Cari Kodu")?></td>
							          	<td><?=dil("Cari")?></td>
							          	<td align="right"><?=dil("Tutar")?>(<i class="far fa-lira-sign"></i>)</td>
							          	<td><?=dil("Kayıt Yapan")?></td>
							          	<td><?=dil("Açıklama")?></td>
							          	<td></td>
							        </tr>
						        </thead>
						        <tbody>
							        <?
							        foreach($rows as $key=>$row) {
							        	$row_toplam->TUTAR += $row->TUTAR;
							        	?>
								        <tr>
								          	<td align="center" class="bg-gray-100"><?=($Table['sayfaIlk']+$key+1)?></td>
								          	<td align="center"> <a href="/finans/alis_fatura.do?route=finans/alis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> waves-effect waves-themed btn-xs"> <?=$row->ID?></a> </td>
								          	<td align="center"><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
								          	<td align="center"><?=FormatTarih::tarih($row->VADE_TARIH)?></td>
								          	<td><?=$row->FATURA_NO?></td>
								          	<td><?=$row->HAREKET?></td>
								          	<td><?=$row->FINANS_KALEMI?></td>
								          	<td><?=$row->PLAKA?></td>
								          	<td><?=$row->CARI_KODU?></td>
								          	<td><?=$row->CARI?></td>
								          	<td align="right"><?=FormatSayi::db2tr($row->TUTAR)?></td>
								          	<td><?=$row->KAYIT_YAPAN?></td>
								          	<td style="max-width: 250px"><?=$row->ACIKLAMA?></td> 
								          	<td align="left" class="p-0">
								          		<a href="<?=fncFaturaPopupLink($row)?>" class="btn btn-outline-primary btn-icon"> <i class="fal fa-eye"></i> </a>
								          		<a href="/finans/alis_fatura.do?route=finans/alis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn btn-outline-primary btn-icon" title="Düzenle"> <i class="far fa-edit"></i> </a>
								          		<?if(strlen($row->EFATURA_UUID) > 1){?>
								          		<a href="<?=fncEFaturaPopupLink($row)?>" class="btn btn-outline-primary btn-icon"> <i class="fal fa-bullseye" title="Efatura PDF"></i> </a>
								          		<?}?>
								          	</td>	
								        </tr>
							        <?}?>
						        </tbody>
						        <thead>
						        	<tr class="thead-themed fw-500">
							          	<td colspan="9"> </td>
							          	<td align="right"> <?=dil("Toplam")?> : </td>		          	
							          	<td align="right"> <?=FormatSayi::db2tr($row_toplam->TUTAR)?> </td>
							          	<td colspan="3"> </td>
							        </tr>
						        </thead>
						  	</table>
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
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		var start = moment().subtract(29, 'days');
        var end = moment();
		
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
            
		$('#fatura_tarih, #vade_tarih').daterangepicker({
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
