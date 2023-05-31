<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$rows_sepet			= $cSubData->getSepet($_REQUEST);
	$row_cari			= $cSubData->getCari(array("id"=>$_SESSION['cari_id']));
	$rows_doviz			= $cSubData->getDoviz();
	//$rows_siparis		= $cSubData->getSiparisler10($_REQUEST);
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
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="<?=$cBootstrap->getBody()?>">
    <div class="page-wrapper">
    <div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
    	<ol class="breadcrumb page-breadcrumb breadcrumb-seperator-1">
            <li class="breadcrumb-item"><a href="/"><?=dil("Kontrol Paneli")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Sepet Bilgileri")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
        <section class="content">		    	
	    	<div class="row hidden-print">
		    	<div class="col-md-12">
		    		<div class="panel">
                    <div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="fal fa-shopping-basket fs-xxl mr-3"></i> <?=dil("Sepet Bilgileri")?> </h2>
                        <div class="panel-toolbar">
                        	<span class="mr-2" id="secili_ozet"></span>
                        	<a href="javascript:;" onclick="exportXLS()" title="Excel" class="btn btn-outline-secondary waves-effect waves-themed btn-icon text-white border-white ml-1 mr-1"> <i class="far fa-table fs-lg"></i> </a>
                        	<button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
					        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
					        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">		
                        	<form name="formSiparis" id="formSiparis" class="app-forms" enctype="multipart/form-data" method="GET">
								<input type="hidden" name="islem" id="islem" value="sepet_siparis_ver">
								
								<div class="row">
						    		<div class="col-md-12 pl-0">
						    			<div class="table-responsive">
								  		<table class="table table-sm table-condensed table-hover mb-0" id="tableParca">
									  		<thead class="thead-themed fw-500">
										    	<tr>
										          	<td align="center">#</td>
										          	<td align="center"><a href="javascript:;" onclick="fncSecim(1)" title=""><?=dil("Tümü")?></a> / <a href="javascript:;" onclick="fncSecim(0)" title=""><?=dil("Hiçbiri")?></a></td>
										          	<td><?=dil("Parça Kodu")?></td>
										          	<td><?=dil("Oem Kodu")?></td>
										          	<td><?=dil("Parça")?></td>
										          	<td align="right"><?=dil("Birim Fiyat")?></td>
										          	<td><?=dil("Para Birimi")?></td>
										          	<td align="center"><?=dil("Adet")?></td>
										          	<td align="right"><?=dil("Birim Tutar")?></td>
										          	<td align="right"><?=dil("KDV")?></td>
										          	<td align="right"><?=dil("Toplam Tutar(KDV'li)")?></td>
										          	<td> </td>
										        </tr>
									        </thead>
									        <tbody>
										        <?
										        foreach($rows_sepet as $key=>$row_sepet) {										        	
										        	$row_toplam->ADET 			+= $row_sepet->ADET;
										        	$row_toplam->FIYAT		 	+= $row_sepet->ISKONTOLU * $row_sepet->ADET;
										        	$row_toplam->KDV 			+= $row_sepet->ISKONTOLU * $row_sepet->ADET * 0.18;
										        	$row_toplam->TUTAR 			+= $row_sepet->TUTAR * 1.18;
										        	?>
											        <tr>
											          	<td align="center" class="bg-gray-100"><?=($Table['sayfaIlk']+$key+1)?></td>
											          	<td align="center">
															<div class="custom-control custom-checkbox custom-checkbox-circle">
								                                <input type="checkbox" class="custom-control-input secim" id="secim<?=$row_sepet->ID?>" name="secim[<?=$row_sepet->ID?>]" value="1">
								                                <label class="custom-control-label" for="secim<?=$row_sepet->ID?>"></label>
								                            </div>
														</td>
														<td class=""><?=$row_sepet->PARCA_MARKA?><br><?=$row_sepet->KODU?></td>
														<td class=""><?=$row_sepet->OEM_KODU?></td>
														<td class=""><?=$row_sepet->STOK?></td>
														<td align="right" style="padding: 0px;" data-tableexport-value="<?=FormatSayi::sayi($row_sepet->ADET,0)?>"> 
															<?if($_SESSION['hizmet_noktasi'] == "0"){?>
															<div class="input-group" style="width: 150px">
									                    		<input type="text" class="form-control " name="iskontolu[<?=$row_sepet->ID?>]" id="iskontolu<?=$row_sepet->ID?>" value="<?=FormatSayi::sayi($row_sepet->ISKONTOLU,2)?>" value="0" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" data-id="<?=$row_sepet->ID?>">
									                    		<div class="input-group-append" onclick="fncFiyatKaydet(this)" data-id="<?=$row_sepet->ID?>"><span class="btn bg-primary-500 waves-effect waves-themed px-2"><i class="fal fa-save"></i></span></div>
									                    	</div>
									                    	<?} else {?>
									                    	<div class="input-group" style="width: 150px">
									                    		<input type="text" class="form-control " name="iskontolu[<?=$row_sepet->ID?>]" id="iskontolu<?=$row_sepet->ID?>" value="<?=FormatSayi::sayi($row_sepet->ISKONTOLU,2)?>" value="0" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" data-id="<?=$row_sepet->ID?>" disabled>
									                    	</div>
															<?}?>
														</td>
														<td><?=$row_sepet->PARA_BIRIM?> </td>
														<td align="center" style="padding: 0px;" data-tableexport-value="<?=FormatSayi::sayi($row_sepet->ADET,0)?>"> 
															<div class="input-group" style="width: 120px">
									                    		<input type="text" class="form-control text-center" name="adet[<?=$row_sepet->ID?>]" id="adet<?=$row_sepet->ID?>" value="<?=FormatSayi::sayi($row_sepet->ADET,0)?>" value="0" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true" data-mask style="text-align: right;" data-id="<?=$row_sepet->ID?>">
									                    		<div class="input-group-append" onclick="fncAdetKaydet(this)" data-id="<?=$row_sepet->ID?>"><span class="btn bg-primary-500 waves-effect waves-themed px-2"><i class="fal fa-save"></i></span></div>
									                    	</div>
														</td>
														<td class="text-right"><?=FormatSayi::sayi($row_sepet->ISKONTOLU * $row_sepet->ADET,2)?> </td>
														<td class="text-right"><?=FormatSayi::sayi($row_sepet->ISKONTOLU * $row_sepet->ADET * 0.18,2)?> </td>
														<td class="text-right"><?=FormatSayi::sayi($row_sepet->TUTAR * 1.18,2)?> </td>
														<td align="center">
															<a href="javascript:;" onclick="fncSepetSil(this)" data-id="<?=$row_sepet->ID?>" class="btn btn-outline-danger btn-icon waves-effect waves-themed" title="Parça Sil"> <i class="fal fa-trash-alt"></i></a>
														</td>
											        </tr>
										        <?}?>
									        </tbody>
									        <?if(count($rows_sepet) > 0){?>
									        <tfoot>
									        	<tr class="thead-themed">
									        		<td colspan="5"></td>
									        		<td class="text-right"></td>
									        		<td></td>
									        		<td class="text-center"><span id="toplam_adet"><?=FormatSayi::sayi($row_toplam->ADET,0)?></span></td>
									        		<td class="text-right"><span id="toplam_fiyat"><?=FormatSayi::sayi($row_toplam->FIYAT, 2)?></span></td>
									        		<td class="text-right"><span id="toplam_kdv"><?=FormatSayi::sayi($row_toplam->KDV, 2)?></span></td>
									        		<td class="text-right"><span id="toplam_tutar"><?=FormatSayi::sayi($row_toplam->TUTAR, 2)?></span></td>
									        		<td></td>
									        	</tr>
									        </tfoot>
									        <?} else {?>
									        <tfoot>
									        	<tr>
									        		<td colspan="100%" align="center" class="fs-xxl text-danger">
									        			<?=dil("Sepetiniz boş ürün ekleme için Yedek Parça Ara kısmını kullanınız.")?>
									        		</td>
									        	</tr>
									        </tfoot>
									        <?}?>
									  	</table>
									  	</div>
								  	</div>
								  	<?if(count($rows_sepet) > 0) {?>
								  		<div class="col-md-12 mt-2">
									  		<div class="form-group">
											  	<label class="form-label"><?=dil("Sipariş Notu")?></label>
											  	<textarea name="aciklama" id="aciklama" class="form-control maxlength" maxlength="500" rows="2"></textarea>
											</div>
										</div>
										<div class="col-md-12 text-center mt-4">
											<button type="button" class="btn btn-primary" onclick="fncSiparisVer(this)" style="width: 150px"><?=dil("Sipariş Oluştur")?></button>
											<button type="button" class="btn btn-danger" onclick="fncSeciliOlanlariSil(this)" style="width: 150px"><?=dil("Seçili olanları Sil")?></button>
								  		</div>
								  	<?}?>
							    </div>
							</form>
						
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
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
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
	 <!-- https://github.com/rek72-zz/tableExport!-->
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/FileSaver/FileSaver.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.umd.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/pdfmake/pdfmake.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/pdfmake/vfs_fonts.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/libs/html2canvas/html2canvas.min.js"></script>
	<script src="../smartadmin/plugin/tableExport.jquery.plugin-master/tableExport.min.js"></script>
    <?$cBootstrap->getTemaJs()?>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    	
    	$("[data-mask]").inputmask();
    	
		function fncFiltrele(){
			$("#form").submit();
		}
		
		var start = moment().subtract(29, 'days');
        var end = moment();
		
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
            
		$('#tarih, #randevu_tarih, #teslim_tarih').daterangepicker({
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
		
		$("#talep_no, #plaka, #dosya_no, #cari").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
		
		function fncSecim(durum){
			if(durum == 1){
				$("input[name^='secim']").attr("checked",true);
			} else {
				$("input[name^='secim']").attr("checked",false);
			}
			
			fncSeciliHesapla();
		}
		
		$('.datatable').DataTable({
		  	paging: false,
		  	pageLength: 100,
		 	lengthChange: true,
		  	searching: false,
		  	ordering: false,
		  	info: false,
		  	autoWidth: false,
		  	select: true,
		  	autoFill: false,
		  	responsive: true,
        	columnDefs: [{ targets: 'no-sort', orderable: false }],
			lengthMenu: [[10, 20, 50, 100, 500, -1], [10, 20, 50, 100, 500, "Tümü"]],
		});
		
		function fncSiparisVer(obj){
			bootbox.confirm('<?=dil("Sipariş vermek istediğimizden emin misiniz")?>!', function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: $('#formSiparis').serialize(),
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
							}else{
								toastr.success(jd.ACIKLAMA);
								window.location.reload(true);
							}
						}
					});
				}
			});
		}
		
		function fncSeciliOlanlariSil(obj){
			bootbox.confirm('<?=dil("Seçili olanları silmek istediğimizden emin misiniz")?>!', function(result){
				if(result == true){
					var tmp_islem = $("#islem").val();
					$("#islem").val("sepet_urun_secili_sil");
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: $('#formSiparis').serialize(),
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
							}else{
								toastr.success(jd.ACIKLAMA);
								$("#sepet_say").html(jd.SEPET_SAY);
								$('#tableParca tbody tr').each(function(table_sira) {									
									if($(this).find("input[name^='secim']").is(":checked")){
										$(this).hide();
									}
								});
								
							}
						}
					});
					
					$("#islem").val(tmp_islem);
					
				}
			});
		}
		
			
		function fncSepetSil(obj){
			bootbox.confirm('<?=dil("Silmek istediğimizden emin misiniz")?>!', function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: { "islem" : "sepet_urun_sil", 'id' : $(obj).data("id") },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								toastr.warning(jd.ACIKLAMA);
							}else{
								$(obj).closest("tr").hide();
								toastr.success(jd.ACIKLAMA);
								$("#sepet_say").html(jd.SEPET_SAY);
							}
						}
					});
				}
			});
		};
		
		function fncAdetKaydet(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "sepet_adet_kaydet", 'id' : $(obj).data("id"), 'adet' : $("#adet"+$(obj).data("id")).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						$(obj).parents("tr").find("td:eq(8)").text((jd.TUTAR));
						//location.reload(true);
					}
					fncHesapla();
				}
			});
		}
		
		function fncFiyatKaydet(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "sepet_iskontolu_kaydet", 'id' : $(obj).data("id"), 'iskontolu' : $("#iskontolu"+$(obj).data("id")).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						//location.reload(true);
					}
					fncHesapla();
				}
			});
		}
		
		function fncIskonto(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "sepet_iskonto_kaydet", 'id' : $(obj).data("id"), 'iskonto' : $("#iskonto"+$(obj).data("id")).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						$(obj).parents("tr").find("input[name^='iskontolu").val((jd.FIYAT));
						$(obj).parents("tr").find("td:eq(8)").text((jd.TUTAR));
						//location.reload(true);
					}
					fncHesapla();
				}
			});
			
		}
		
		function fncSiparisMailGonder(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "siparis_mail_gonder", 'id' : $(obj).data("id")},
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
					}
				}
			});
		}
		
		function fncSayiDb(sayi){
			yeni = sayi.replace('.','').replace(',','.');
			yeni = parseFloat(yeni).toFixed(2);
			return yeni;
		}
		
		function fncSayiTr(sayi){
			yeni = parseFloat(sayi).toFixed(2);
			yeni = yeni.replace(".",",");
			return yeni;
		}
		
		
		$("input[name^='secim']").change(function() {
			fncSeciliHesapla();
			
		});
		
		function fncSeciliHesapla(){
			var toplam = 0;
			var kalem = 0;
			var adet = 0;
			var toplam_adet = 0;
			
		  	$('#tableParca tbody tr').each(function(table_sira) {
				var fiyat = fncSayiDb($(this).find("td:eq(9)").text()) * 1;
				var adet = fncSayiDb($(this).find("input[name^='adet']").val()) * 1;
				
				if($(this).find("input[name^='secim']").is(":checked") && fiyat > 0){
					toplam += fiyat;
					toplam_adet += adet;
					kalem++;
				}
			});
			
			$("#secili_ozet").text(kalem +" kalemde " + toplam_adet + " adet ürün " + fncSayiTr(toplam) +" TL");
		}
		
		function fncHesapla(){
			var toplam_adet = 0;
			var toplam_fiyat = 0;
			var toplam_kdv = 0;
			var toplam_tutar = 0;
			
		  	$('#tableParca tbody tr').each(function(table_sira) {
		  		var fiyat = fncSayiDb($(this).find("input[name^='iskontolu").val()) * 1;
				var adet = fncSayiDb($(this).find("input[name^='adet']").val()) * 1;
				//var tutar = fncSayiDb($(this).find("td:eq(9)").text()) * 1;
				
				toplam_fiyat += fiyat * adet;
				toplam_adet  += adet;
				toplam_kdv  += fiyat * adet * 0.18;
				toplam_tutar += fiyat * adet * 1.18;
				$(this).find("td:eq(8)").text(fncSayiTr(fiyat * adet));
				$(this).find("td:eq(9)").text(fncSayiTr(fiyat * adet * 0.18));
				$(this).find("td:eq(10)").text(fncSayiTr(fiyat * adet * 1.18));
			});
			
			$("#toplam_adet").text(fncSayiTr(toplam_adet));
			$("#toplam_fiyat").text(fncSayiTr(toplam_fiyat));
			$("#toplam_kdv").text(fncSayiTr(toplam_kdv));
			$("#toplam_tutar").text(fncSayiTr(toplam_tutar));
			
		}
		
		function exportXLS(){
			/*
			$("#tablo1 tbody").find('td').each (function() {
			  	$(this).find("input[id^='firma']").clone().prependTo(this);
			  	$(this).find(".input-group").hide();
			});   
			*/
			$('#tableParca').tableExport({type:'excel', mso: {fileFormat:'xlsx'}});
		}
		
	</script>
    
</body>
</html>
