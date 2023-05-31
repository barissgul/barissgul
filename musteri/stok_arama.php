<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	/*
	$excel = new excelSayfasi();
	$excel->sutunEkle("#","SIRA","");
	$excel->sutunEkle("Servis No","ID","");
	$excel->sutunEkle("Plaka","PLAKA","");
	$excel->sutunEkle("Marka","MARKA","");
	$excel->sutunEkle("Model","MODEL","");
	$excel->sutunEkle("Model Yılı","MODEL_YILI","");
	$excel->sutunEkle("Sasi No","SASI_NO","");
	$excel->sutunEkle("Süreç","SUREC","");
	$excel->sutunEkle("Dosya No","DOSYA_NO","");
	$excel->sutunEkle("Fatura No ","FATURA_NO","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("Sorumlu","SORUMLU","");
	$excel->sutunEkle("Servis Bölüm","SERVIS_BOLUM","");
	$excel->sutunEkle("Araç Geliş Tarihi","ARAC_GELIS_TARIH","");
	$excel->sutunEkle("Teslim Tarih","TESLIM_EDILDI_TARIH","");
	$excel->sutunEkle("Talep Tarih","TARIH","");
	$excel->sutunEkle("Son İşlem Tarih","GTARIH","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaTalepler")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows = $Table['rows'];
	$_SESSION['Table'] = $Table;
	//var_dump2($Table['sqls']);
	*/
	//$row_urun_sayisi = $cSubData->getUrunSayisi($_REQUEST);
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/fancybox/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/magnific-popup/magnific-popup.css">
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
            <li class="breadcrumb-item active"><?=dil("Stok Arama")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
        <section class="content">
	    	<div class="row hidden-print">
		    	<div class="col-lg-6 offset-lg-3 col-sm-12 mb-3">
		    		<div class="form-group">
				    	<div class="input-group input-group-lg">
	                        <input type="text" class="form-control" id="parca" name="parca" placeholder="Parça Kodu" aria-label="" value="<?=$_REQUEST['parca']?>">
	                        <div class="input-group-append">
	                            <button class="btn btn-primary waves-effect waves-themed" type="button" id="btnParcaBul" name="btnParcaBul" onclick="fncParcaBul(this)"><i class="fal fa-search"></i></button>
	                        </div>
	                    </div>
	                    <!--
	                    <span class="help-block ml-4"><?=FormatSayi::sayi($row_site->STOK_SAYISI,0)?> <?=dil("adet stok var")?></span>
	                    -->
	                </div>
			    </div>
		    </div>
		    
	    	<div class="row">
	    		<div class="col-md-12">
	    			<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2><i class="fa fa-list mr-3"></i> <?=dil("Arama Sonucu")?> </h2>
                        <div class="panel-toolbar">
                        	<a href="javascript:;" onclick="exportXLS()" title="Excel" class="btn btn-outline-secondary waves-effect waves-themed btn-icon text-white border-white ml-1"> <i class="far fa-table fs-lg"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed datatable" id="tablo1">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center">#</td>
								          	<?if(!in_array(SITE,array(3))){?>
								          	<td align="center"><?=dil("Resim")?></td>
								          	<?}?>
								          	<td><?=dil("Parça Kodu")?></td>
								          	<td><?=dil("OEM Kodu")?></td>
								          	<td><?=dil("Parça Adı")?></td>
								          	<td><?=dil("Uyumlu Araçlar")?></td>
								          	<td align="center"><?=dil("Stok")?></td>
								          	<td align="right"><?=dil("Fiyat")?></td>
								          	<td align="right"><?=dil("Fiyat KDVli")?></td>
								          	<td> </td>
								        </tr>
							        </thead>
							        <tbody id="parcalar">
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center" class="bg-gray-100"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td nowrap> 
									          		<?=$row->PARCA_MARKA?><br>
									          		<?=$row->KODU?>
									          	</td>
									          	<td nowrap> <?=$row->OEM_KODU?></td>
									          	<td nowrap> <?=$row->STOK?></td>
									          	<td> <?=$row->KATEGORI?></td>
									          	<td nowrap> <?=$row->KATALOGS?></td>
									          	<td align="center"><?=FormatSayi::sayi($row->ADET,0)?></td>
									          	<td align="right"><?=FormatSayi::sayi($row->FIYAT)?></td>
									          	<td align="center" class="p-0">
									          		
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
    <script src="../smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/Inputmask-5.x/dist/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/Inputmask-5.x/dist/bindings/inputmask.binding.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
	<script src="../smartadmin/plugin/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <!-- https://github.com/rek72-zz/tableExport!-->
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/FileSaver/FileSaver.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.umd.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/pdfmake/pdfmake.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/pdfmake/vfs_fonts.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/html2canvas/html2canvas.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/tableExport.min.js"></script>
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
            
		$('#randevu_tarih, #arac_gelis_tarih, #tahmini_teslim_tarih, #teslim_tarih').daterangepicker({
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
		
		<?if(strlen($_REQUEST['arama_q']) > 0){?>
			$("#parca").val("<?=$_REQUEST['arama_q']?>");
			fncParcaBul($("#btnParcaBul"));
		<?}?>
		
		$("#parca").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncParcaBul($("#btnParcaBul"));
		    }
		});
		
		/*
		$('.datatable').DataTable({
		  	paging: false,
		  	pageLength: 200,
		 	lengthChange: true,
		  	searching: false,
		  	ordering: true,
		  	info: false,
		  	autoWidth: false,
		  	select: true,
		  	autoFill: false,
		  	responsive: true,
        	columnDefs: [{ targets: 'no-sort', orderable: false }],
			lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Tümü"]],
		});
		*/
		
		function fncParcaBul(obj){
			$(obj).attr("disabled", "disabled").find("i").removeClass("fal fa-search").addClass("fas fa-spinner fa-spin");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "parca_bul", 'parca': $("#parca").val(), "marka_id": $("#marka_id").val(), "model_id": $("#model_id").val(), "kategori_id": $("#kategori_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						$('#parcalar').html("");
						toastr.warning(jd.ACIKLAMA);
					}else{
						$('#parcalar').html(jd.HTML);
						toastr.success(jd.ACIKLAMA);
					}
					
					$("img.lazy").lazy();
					
					$('.popup-gallery').magnificPopup({
			          	delegate: 'a',
			          	type: 'image',
			          	tLoading: 'Resim Yükleniyor #%curr%...',
			          	mainClass: 'mfp-img-mobile',
			          	gallery: {
			            	enabled: true,
			            	navigateByImgClick: true,
			            	preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			          	},
			          	image: {
			            	tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			            	titleSrc: function(item) {
			              		return item.el.attr('data-title');
			            	}
			          	}
			        });
			        
					$(obj).removeAttr("disabled").find("i").removeClass("fas fa-spinner fa-spin").addClass("fal fa-search");
				}
			});
		};
		
		function fncSepeteEkle(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "sepete_urun_ekle", 'kodu' : $(obj).data("kodu"), 'adet' : $("#adet"+$(obj).data("id")).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						$("#sepet_say").html(jd.SEPET_SAY);
					}
				}
			});
		};
		
		
		function exportXLS(){
			/*
			$("#tablo1 tbody").find('td').each (function() {
			  	$(this).find("input[id^='firma']").clone().prependTo(this);
			  	$(this).find(".input-group").hide();
			});   
			*/
			$('#tablo1').tableExport({type:'excel', mso: {fileFormat:'xlsx'}});
		}
		
		function fncModelDoldur(){
			$("#model_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "model_doldur", 'marka_id' : $("#marka_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$('#model_id').html(jd.HTML);
						toastr.success(jd.ACIKLAMA);
					}
					$("#model_id").removeAttr("disabled");
				}
			});
		};
		
	</script>
    
</body>
</html>
