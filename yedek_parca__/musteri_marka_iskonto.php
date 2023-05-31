<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	if($_REQUEST['arama_q']) {
		$_REQUEST['filtre'] 	= 1;
	}
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("#","SIRA","");
	$excel->sutunEkle("Firma","FIRMA","");
	$excel->sutunEkle("Dosya No","DOSYA_NO","");
	$excel->sutunEkle("İhale No","IHALE_NO","");
	$excel->sutunEkle("Plaka","PLAKA","");
	$excel->sutunEkle("Marka","MARKA","");
	$excel->sutunEkle("Model","MODEL","");
	$excel->sutunEkle("Model Yılı","MODEL_YILI","");
	$excel->sutunEkle("Servis İl","SERVIS_IL","");
	$excel->sutunEkle("Servis İlçe","SERVIS_ILCE","");
	$excel->sutunEkle("Parça Sayısı","SIPARIS_SAYISI","");
	$excel->sutunEkle("İhale Baş Tarih","IHALE_BAS_TARIH","");
	$excel->sutunEkle("İhale Bit Tarih","IHALE_BIT_TARIH","");
	$excel->sutunEkle("Sorumlu","SORUMLU","");
	$excel->sutunEkle("Sipariş Tarihi","SIPARIS_TARIH","");
	$excel->sutunEkle("Sevk Tarihi","SEVK_TARIH","");
	$excel->sutunEkle("Teslim Tarihi","TESLIM_TARIH","");
	$excel->sutunEkle("Sipariş Süreç","SIPARIS_SUREC","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaCariMarkaIskonto")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows = $Table['rows'];
	$_SESSION['Table'] = $Table;
	//var_dump2($Table['sqls']);
	//var_dump2($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title> <?=$row_site->TITLE?> </title>
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  	<link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
  	<link rel="stylesheet" href="../bootstrap/fonts/font-awesome.min.css">
  	<link rel="stylesheet" href="../bootstrap/fonts/ionicons.min.css">  
  	<link rel="stylesheet" href="../plugins/select2/select2.min.css">
  	<link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
  	<link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  	<link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
  	<link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  	<link rel="stylesheet" href="../asset/bootstrap-touchspin-master/src/jquery.bootstrap-touchspin.css">
  	<link rel="stylesheet" href="../plugins/colorpicker/bootstrap-colorpicker.min.css">
  	<link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
  	<link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  	<link rel="stylesheet" href="../plugins/iCheck/square/blue.css">
  	<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  	<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  	<link rel="stylesheet" href="../asset/1.css">
</head>
<body class="<?=$cBootstrap->getTema()?>">
	<div class="wrapper">
		
		<?=$cBootstrap->getHeader();?>
	  	
	  	<div class="content-wrapper">
		    <section class="content-header">
		      	<h1> <i class="glyphicon glyphicon-shopping-cart"></i> <?=dil("Marka İskonto")?> </h1>		      	
		      	<ol class="breadcrumb">
			        <li><a href="/index.do"><i class="fa fa-dashboard"></i> <?=dil("Dashboard")?> </a></li>
			        <li class="active"> <?=dil("Marka İskonto")?> </li>
		      	</ol>
		    </section>
		    <section class="content">
		    	<div class="row hidden-print">
			    	<div class="col-md-12">
				    	<div class="box box-warning small">
							<div class="box-body">
								<form name="form" id="form" class="" enctype="multipart/form-data" method="GET">
									<input type="hidden" name="route" value="<?=$_REQUEST['route']?>">
									<input type="hidden" name="sayfa" id="sayfa">
									<input type="hidden" name="filtre" value="1">
									<div class="col-lg-4 col-md-4">						            
									    <div class="form-group">
										  	<label> <?=dil("Müşteri Cari")?> </label>
										  	<select name="cari_id" id="cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->MusteriCarileri()->setSecilen($_REQUEST['cari_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-lg-4 col-md-4">		            
									    <div class="form-group">
										  	<label> <?=dil("Marka")?> </label>
										  	<select name="marka_id" id="marka_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Markalar()->setSecilen($_REQUEST['marka_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group">
										  	<label> &nbsp; </label><br>
									  		<button type="button" class="btn btn-primary" onclick="fncFiltrele()"> <?=dil("Filtrele")?> </button>
									  	</div>
									</div>
								</form>
							</div>
						</div>
				    </div>
			    </div>
			    
		    	<div class="row">
		    		<div class="col-md-12">
			    		<div class="box box-info small">
							<div class="box-header">
							  	<h3 class="box-title"> <?=dil("Marka İskonto")?> <span class="" style="font-size: 10px;">(<?=$Table['sayfaUstYazi']?>)</span> </h3>
							</div>
							<div class="box-body">
								<div class="table-responsive">
							  	<table class="table table-condensed table-hover">
							  		<thead>
								    	<tr class="bg-aqua">
								          	<td align="center">#</td>								          	
								          	<td><?=dil("Marka")?></td>
								          	<td><?=dil("Cari")?></td>
								          	<td align="center"><?=dil("Tarih")?></td>
								          	<td class="text-center"><?=dil("İskonto(Orj)")?></td>
								          	<td class="text-center"><?=dil("İskonto(Lo)")?></td>
								          	<td class="text-center"><?=dil("İskonto(Eşd)")?></td>
								          	<td> </td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center"><?=($key+1)?></td>
									          	<td><?=$row->MARKA?></td>
									          	<td><?=$row->UNVAN?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->TARIH)?></td>
									          	<td style="width: 200px; padding-bottom: 2px; padding-top: 2px;" class="text-center">
									          		<input type="text" class="form-control touchspin" placeholder="" name="adet[<?=$row->KOD?>]" id="adet<?=$row->KOD?>" value="<?=$row->ISKONTO?>" maxlength="5" style="text-align: center;" data-bts-init-val="" data-bts-max="100" data-bts-step="1" data-bts-mousewheel="true" readonly>
									          	</td>
									          	<td style="width: 200px; padding-bottom: 2px; padding-top: 2px;" class="text-center">
									          		<input type="text" class="form-control touchspin" placeholder="" name="adet[<?=$row->KOD?>]" id="adet<?=$row->KOD?>" value="<?=$row->ISKONTO?>" maxlength="5" style="text-align: center;" data-bts-init-val="" data-bts-max="100" data-bts-step="1" data-bts-mousewheel="true" readonly>
									          	</td>
									          	<td style="width: 200px; padding-bottom: 2px; padding-top: 2px;" class="text-center">
									          		<input type="text" class="form-control touchspin" placeholder="" name="adet[<?=$row->KOD?>]" id="adet<?=$row->KOD?>" value="<?=$row->ISKONTO?>" maxlength="5" style="text-align: center;" data-bts-init-val="" data-bts-max="100" data-bts-step="1" data-bts-mousewheel="true" readonly>
									          	</td>
									          	<td align="center" style="padding: 0px;">
									          		<button class="btn btn-success btn-sm"> Kaydet </button>
									          	</td>
									        </tr>
								        <?}?>
							        </tbody>
							        <tfoot>
								        <tr>
								        	<td colspan="100%" align="center">
								        		<div class="sortPagiBar">
								                    <div class="bottom-pagination">
								                        <nav>
								                          	<ul class="pagination">
									                            <?=$Table["sayfaAltYazi"];?>
								                          	</ul>
								                        </nav>
								                    </div>
								                </div>
								        	</td>
								        </tr>
							        </tfoot>
							  	</table>
								</div>
							</div>
						</div>
			    	</div>
			    </div>
			</section>
	  	</div>
	  	
	  	<?=$cBootstrap->getFooter()?>
  		
	</div>

	<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="../plugins/jQueryUI/jquery-ui.min.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="../plugins/select2/select2.full.min.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../plugins/raphael/2.1.0/raphael-min.js"></script>
	<script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
	<script src="../asset/bootstrap-touchspin-master/src/jquery.bootstrap-touchspin.js"></script>
	<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../plugins/knob/jquery.knob.js"></script>
	<script src="../plugins/moment/2.11.2/moment.min.js"></script>
	<script src="../plugins/daterangepicker/daterangepicker.js"></script>
	<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="../plugins/iCheck/icheck.min.js"></script>
	<script src="../asset/bootbox/bootbox.min.js"></script>
	<script src="../asset/bootstrap-maxlength.js"></script>
	<script src="../plugins/fastclick/fastclick.js"></script>
	<script src="../dist/js/app.min.js"></script>
	<script src="../asset/1.js"></script>
	<script>
		
	  	$("[data-mask]").inputmask();
	  	
	  	$(".touchspin").TouchSpin({ });
	  	
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		$('#ihale_bas_tarih, #ihale_bit_tarih, #siparis_tarih, #sevk_tarih, #teslim_tarih').daterangepicker({
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
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
	</script>
	
</body>
</html>
