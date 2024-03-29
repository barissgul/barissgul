<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	//$_REQUEST["filtre"] = 1;
	if($_SESSION['hizmet_noktasi'] == 1){
		$_REQUEST['tedarikci_id'] = $_SESSION['tedarikci_id'];	
	}
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("Parça Marka","PARCA_MARKA","");
	$excel->sutunEkle("Stok Kodu","KODU","");
	$excel->sutunEkle("Oem Kodu","OEM_KODU","");
	$excel->sutunEkle("Parça Açıklama","STOK","");
	$excel->sutunEkle("Muadil Kodları","MUADIL_KODUS","");
	$excel->sutunEkle("Barkod","BARKOD","");
	$excel->sutunEkle("Katalog Parça","KATALOG_PARCA","");
	$excel->sutunEkle("Raf Yer","RAF_YER","");
	$excel->sutunEkle("Adet","ADET","");
	$excel->sutunEkle("Satış Fiyat","SATIS_FIYAT","");
	$excel->sutunEkle("Son Hareket Tarihi","STOK_HAREKET_TARIH","");
	$excel->sutunEkle("Stok Katalog","STOK_KATALOG","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaStokStoklar")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
	$rows = $Table['rows'];
	$_SESSION['Table'] = $Table;
	//var_dump2($Table['sqls']);
	
?>
<!DOCTYPE html>
<html lang="tr" class="<?=$cBootstrap->getFontBoyut()?>">
<head>
    <meta charset="utf-8">
    <title> <?=$row_site->TITLE?> <?=dil("Stoklar")?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/vendors.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/app.bundle.css">
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
									      	<input type="text" class="form-control" placeholder="" name="kodu" id="kodu" value="<?=$_REQUEST['kodu']?>" maxlength="30">
									    </div>
									</div>
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Oem Kodu")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="oem_kodu" id="oem_kodu" value="<?=$_REQUEST['oem_kodu']?>" maxlength="30">
									    </div>
									</div>
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Parça Adı")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="stok" id="stok" value="<?=$_REQUEST['stok']?>" maxlength="50">
									    </div>
									</div>
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Barkod")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="barkod" id="barkod" value="<?=$_REQUEST['barkod']?>" maxlength="30">
									    </div>
									</div>
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Kategori")?></label>
										  	<select name="kategori_id" id="kategori_id" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->Kategoriler()->setSecilen($_REQUEST['kategori_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Durum")?></label>
										  	<select name="durum" id="durum" class="form-control select2" style="width: 100%;">
										      	<?=$cCombo->Durumlar()->setSecilen($_REQUEST['durum'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">
										<div class="form-group">
									        <label class="form-label"><?=dil("Stok Hareket Tarihi")?></label>
									        <div class="input-group date">
									          	<div class="input-group-prepend"><span class="input-group-text bg-primary-300"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control datepicker datepicker-inline" name="tarih" value="<?=$_REQUEST['tarih']?>" readonly>
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
                        <h2> <i class="fal fa-cog fa-2x mr-3"></i> <b> <?=dil("Stoklar")?> </b> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                        	<a href="javascript:fncPopup('/stok/popup_stok.do?route=stok/popup_stok','POPUP_STOK',1100,850);" class="btn btn-outline-secondary text-white border-white btn-icon mr-1"> <i class="far fa-plus"></i> </a>
			            	<a href="../excel_sql.do?" title="Excel" class="btn btn-outline-secondary text-white border-white btn-icon"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed fw-500">
							    	<tr>
							          	<td align="center">#</td>
							          	<td align="center"><?=dil("Resim")?></td>
							          	<td><?=dil("Parça Marka")?></td>
							          	<td><?=dil("Parça Kodu")?></td>
							          	<td><?=dil("Oem Kodu")?></td>
							          	<td><?=dil("Parça Adı")?></td>
							          	<td><?=dil("Muadil Kodları")?></td>
							          	<td><?=dil("Barkod")?></td>
							          	<td align="center"><?=dil("Adet")?></td>
							          	<td align="right"><?=dil("Fiyat")?></td>
							          	<td align="center"><?=dil("Durum")?></td>
							          	<td></td>
							        </tr>
						        </thead>
						        <tbody>
							        <?
							        foreach($rows as $key=>$row) {
							        	$row_toplam->ADET 	+= $row->ADET;
							        	?>
								        <tr>
								          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
								          	<td align="center" class="resim-gallery">
								          		<?if(is_file($cSabit->imgPathFile($row->URL))){?>
									                <a href="/resim.do?id=<?=$row->ID?>" data-toggle="lightbox" data-gallery="resim-gallery" data-title="<?=$row->KODU?> - <?=$row->STOK?>" data-footer="<?=FormatTarih::tarih($row->TARIH)?>"> 
														<img class="img-thumbnail lazy" alt="" src="/img/loading2.gif" data-src="/resim_thumb.do?id=<?=$row->ID?>" style="width:100px;height: 100px"/>
													</a>
										        <?} else {?>
										        	<a href="/img/100x100.png" data-toggle="lightbox" data-gallery="resim-gallery" data-title="A" data-footer="B"> <img src="/img/100x100.png" class="img-responsive center-block " style="width:100px;height: 100px"> </a>
										        <?}?>
								          	</td>
								          	<td><?=$row->PARCA_MARKA?></td>
								          	<td> <a href="javascript:fncPopup('/stok/stok_detay.do?route=stok/stok_detay&parca_kodu=<?=$row->KODU?>&servis_id=<?=$row->SERVIS_ID?>&filtre=1','STOK_DETAY',1200,800);" title="Ektre"> <?=$row->KODU?> </a> </td>
								          	<td style="max-width: 200px"><?=$row->OEM_KODU?></td>
								          	<td><?=$row->STOK?></td>
								          	<td><?=$row->MUADIL_KODUS?></td>
								          	<td><?=$row->BARKOD?></td>
								          	<td align="center"><?=FormatSayi::sayi($row->ADET,0)?></td>
								          	<td align="right"><?=FormatSayi::sayi($row->SATIS_FIYAT,2)?></td>
								          	<td align="center"><?=fncDurumSpan($row->DURUM)?> </td>
								          	<td class="text-right p-0 text-center" nowrap> 
								          		<a href="javascript:fncPopup('/stok/popup_stok.do?route=stok/popup_stok&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_STOK',1200,850);" class="btn btn-md btn-outline-primary btn-icon"> <i class="far fa-pencil"></i> </a> 
								          		<a href="javascript:fncPopup('/stok/popup_stok_cikti.do?route=stok/popup_stok_cikti&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_YAZDIR',1200,800);" class="btn btn-md btn-outline-primary btn-icon" title="Yazdır"> <i class="fal fa-print"></i></a>
			                					<a href="javascript:fncPopup('/stok/popup_stok_etiket.do?route=stok/popup_stok_etiket&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_YAZDIR_ETIKET',1200,800);" class="btn btn-md btn-outline-primary btn-icon" title="Etiket"> <i class="fal fa-barcode"></i></a>
								          	</td>
								        </tr>
							        <?}?>
							        <tr class="thead-themed fw-500">
							          	<td colspan="9"> </td>
							          	<td align="right"> &nbsp; </td>
							          	<td></td>
							          	<td></td>
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
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/iCheck/icheck.min.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
	<script src="../smartadmin/plugin/lightbox-master/dist/ekko-lightbox.min.js"></script>
    <script src="../smartadmin/plugin/bootstrap4-tagsinput-master/tagsinput.js"></script>    
	<script src="../smartadmin/plugin/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src="../smartadmin/plugin/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		function fncFiltrele(){
			if($("#katalog").val() == "" && $("#oem_kodu").val() == "" && $("#stok").val() == "" && $("#tedarikci_id").val() <= 0){
				bootbox.alert("<b>Stok Kodu, Oem Kodu, Stok Adı, Barkod, Tedarikci</b> alanlarından birini giriniz!", function() {});
			} else {
				$("#form").submit();	
			}
		}
		
		$("img.lazy").lazy();
		$('.resim-gallery').magnificPopup({
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
		
		$("#marka, #kodu, #oem_kodu, #stok, #barkod").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
		
		function fncStokDuzenle(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "stok_bilgisi", 'id' : $(obj).data("id") },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						//bootbox.alert(jd.ACIKLAMA, function() {});
						$("#modalStokDuzenle #id").val( jd.STOK.ID );
						$("#modalStokDuzenle #kodu").val( jd.STOK.KODU );
						$("#modalStokDuzenle #marka").val( jd.STOK.MARKA );
						$("#modalStokDuzenle #ebat").val( jd.STOK.EBAT );
						$("#modalStokDuzenle #yuk").val( jd.STOK.YUK );
						$("#modalStokDuzenle #desen").val( jd.STOK.DESEN );
						$("#modalStokDuzenle #mevsim_id").val( jd.STOK.MEVSIM_ID );
						$("#modalStokDuzenle #etiket").val( jd.STOK.ETIKET );
						$("#modalStokDuzenle").modal("show");
					}
				}
			});
		}
		
		function fncStokKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formStokDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						$("#modalStokDuzenle").modal("hide");
					}
				}
			});
		}
		
		function fncStokEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formStokEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						$("#modalStokEkle").modal("hide");
					}
				}
			});
		}
		
	</script>
    
</body>
</html>
