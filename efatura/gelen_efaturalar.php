<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	if($_REQUEST['filtre'] == 1){
		if($_REQUEST['fatura_tarih_var']){
			$fatura_tarih 	= explode(",", $_REQUEST['fatura_tarih']);	
		}
		if($_REQUEST['olusturma_tarih_var']){
			$olusturma_tarih = explode(",", $_REQUEST['olusturma_tarih']);	
		}	
		
		$rows 	= $cUyumsoft->fncGelenFaturalarList(
									$_REQUEST['fatura_sayisi'],         
									trim(FormatTarih::tre2db(trim($fatura_tarih[0]))),
									trim(FormatTarih::tre2db(trim($fatura_tarih[1]))),
									trim(FormatTarih::tre2db(trim($olusturma_tarih[0]))),
									trim(FormatTarih::tre2db(trim($olusturma_tarih[1]))),
									$_REQUEST['fatura_no'],
									$_REQUEST['fatura_uuid']
							);
		//var_dump2($rows);
		foreach($rows as $key => $row){
			$arr_fatura_no[]	= $row->FATURA_NO;
		}
		
		if(count($arr_fatura_no) > 0){
			$rows_entegre = $cSubData->getEfaturaNatra(array("fatura_nolar"=>implode(',', $arr_fatura_no)));			
		}
		
		if(count($arr_fatura_no) > 0){
			$rows_iptal = $cSubData->getEfaturaGelenIptal(array("fatura_nolar"=>implode(',', $arr_fatura_no)));			
		}
	}
	
	if($_REQUEST['filtre'] != 1){
		$_REQUEST['olusturma_tarih_var'] = 1;
	}
	
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
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
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
            <li class="breadcrumb-item active"><?=dil("Gelen eFaturalar")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
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
									<!--
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Fatura Kesen VKN/TCK")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="gonderen_vkn" id="gonderen_vkn" value="<?=$_REQUEST['gonderen_vkn']?>" maxlength="11">
									    </div>
									</div>
									-->
									<div class="col-xl-2 col-sm-4 mb-2">        
								        <div class="form-group">
								        	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="olusturma_tarih_var" name="olusturma_tarih_var" <?=($_REQUEST['olusturma_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="olusturma_tarih_var"><?=dil("Oluşturma Tarih")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="olusturma_tarih" name="olusturma_tarih" value="<?=$_REQUEST['olusturma_tarih']?>" readonly>
									        </div>
									    </div>
								    </div>
								    <!--
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
								    -->
								    <div class="col-md-2 mb-2">
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Fatura Sayısı")?> </label>
										  	<select name="fatura_sayisi" id="fatura_sayisi" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->FaturaSayisi()->setSecilen($_REQUEST['fatura_sayisi'] ?: 100 )->setTumu()->getSelect("ID","AD")?>
										    </select>
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
	    		<div class="col-md-12">
	    			<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="far fa-list mr-3"></i> <?=dil("Gelen eFaturalar")?> </h2>
                        <div class="panel-toolbar">
                        
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover datatable">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center">#</td>
								          	<td><?=dil("Gönderen")?></td>
								          	<td><?=dil("Gönderen VKN")?></td>
								          	<td align="center"><?=dil("Fatura Tarih")?></td>
								          	<td><?=dil("Fatura No")?></td>
								          	<td align="right"><?=dil("Tutar")?></td>
								          	<td><?=dil("Statü")?></td>
								          	<td align="center"><?=dil("Oluşturma Tarih")?></td>
								          	<td></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?
								        foreach($rows as $key=>$row) {
								        	if(is_null($row->FATURA_NO)) continue;
								        	$row->HAREKET_ID = 2;
								        	$row->EFATURA_UUID = $row->FATURA_UUID;
								        	//$cdbPDO->rowsCount("UPDATE CARI_HAREKET SET EFATURA_UUID = :EFATURA_UUID WHERE FATURA_NO = :FATURA_NO LIMIT 1", array(":EFATURA_UUID"=>$row->EFATURA_UUID,":FATURA_NO"=>$row->FATURA_NO,));
								        	//$cdbPDO->rowsCount("UPDATE CARI_HAREKET SET VADE_TARIH = :VADE_TARIH WHERE FATURA_NO = :FATURA_NO LIMIT 1", array(":VADE_TARIH"=>$row_efatura->VADE_TARIH,":FATURA_NO"=>$row->FATURA_NO,));
								        	?>
									        <tr>
									          	<td align="center"><?=($key+1)?></td>
												<td><?=$row->GONDEREN?></td>
												<td><?=$row->GONDEREN_VKN?></td>
												<td align="center"><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
												<td title="<?=$row->FATURA_UUID?>"><?=$row->FATURA_NO?></td>
												<td align="right"><?=FormatSayi::sayi($row->FATURA_TUTAR)?> TL</td>
												<td title="<?=$row->DURUM?>"><?=$row->ACIKLAMA?></td>
												<td align="center"><?=FormatTarih::tarih($row->KAYIT_TARIH)?></td>
									          	<td align="left" class="p-0">
									          		<input type="hidden" id="<?=$row->FATURA_NO?>" value="<?=htmlentities(json_encode($row))?>"/>
									          		<a href="<?=fncEFaturaPopupLink($row)?>" class="btn btn-outline-primary btn-icon"> <i class="fal fa-bullseye" title="Efatura PDF"></i> </a>
									          		<?if($rows_entegre[$row->FATURA_NO]){?>
													 	<span class="text-green"><?=dil("Aktarıldı")?> <?=$rows_entegre[$row->FATURA_NO]->EVRAK_NO?></span>
													<?} else if($rows_iptal[$row->FATURA_NO]){?>
													 	<span class="text-danger"><?=dil("İptal Edildi")?> <?=$rows_entegre[$row->FATURA_NO]->EVRAK_NO?></span>
													<?} else {?>
													 	<button type="button" class="btn btn-outline-primary btn-icon" onclick="fncEfaturaAktar(this, '<?=$row->FATURA_UUID?>', '<?=$row->FATURA_NO?>', '<?=$row->GONDEREN_VKN?>')" class="btn btn-default bg-aqua-gradient btn-sm" title="İçeri Aktar"> <i class="fal fa-arrow-circle-right"></i> </button>
													 	<button type="button" class="btn btn-outline-danger btn-icon" onclick="fncEfaturaIptal(this, '<?=$row->FATURA_UUID?>', '<?=$row->FATURA_NO?>', '<?=$row->GONDEREN_VKN?>')" class="btn btn-default btn-sm" title="İptal Et"> <i class="fal fa-times"></i> </button>
													<?}?>
									          	</td>
									        </tr>
								        <?}?>
							        </tbody>
							  	</table>
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
        
		$("#fatura_no, #tck").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
            
		$('#olusturma_tarih, #fatura_tarih').daterangepicker({
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
		
		function fncEfaturaAktar(obj, uuid, fatura_no, vkn){
			$(obj).attr("disabled", "disabled");			
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: {"islem": "gelen_efatura_aktar", "uuid": uuid, "fatura_no": fatura_no, "vkn": vkn, "data": $("#"+fatura_no).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
						$(obj).removeAttr("disabled");	
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {});
						$(obj).hide().after("<b>"+ jd.FATURA_NO +"</b>");
					}
				}
			});
			
		}
		
		function fncEfaturaIptal(obj, uuid, fatura_no, vkn){
			bootbox.confirm("İptal etmek istediğinizden emin misiniz!", function(result){
				if(result){
					$(obj).attr("disabled", "disabled");			
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: {"islem": "gelen_efatura_iptal", "uuid": uuid, "fatura_no": fatura_no, "vkn": vkn, "data": $("#"+fatura_no).val() },
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
								$(obj).removeAttr("disabled");	
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {});
								$(obj).hide().after("<b>"+ jd.FATURA_NO +"</b>");
							}
						}
					});
				}
			});
		}
				
	</script>
    
</body>
</html>
