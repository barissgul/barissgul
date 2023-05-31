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
	$Table = $cTable->setSayfa("sayfaCariParcaTipiYas")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
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
		      	<h1> <i class="glyphicon glyphicon-shopping-cart"></i> <?=dil("Yedek Parça Tipi ve Yaş Kuralı")?> </h1>		      	
		      	<ol class="breadcrumb">
			        <li><a href="/index.do"><i class="fa fa-dashboard"></i> <?=dil("Dashboard")?> </a></li>
			        <li class="active"> <?=dil("Yedek Parça ve Tipi Yaş Kuralı")?> </li>
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
										  	<label> <?=dil("Yaş")?> </label>
										  	<select name="yas" id="yas" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Yas()->setSecilen($_REQUEST['yas'])->setTumu()->getSelect("ID","AD")?>
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
							  	<h3 class="box-title"> <?=dil("Yedek Parça Tipi ve Yaş Kuralı")?> <span class="" style="font-size: 10px;">(<?=$Table['sayfaUstYazi']?>)</span> </h3>
							</div>
							<div class="box-body">
								<div class="table-responsive">
							  	<table class="table table-condensed table-hover">
							  		<thead>
								    	<tr class="bg-aqua">
								          	<td align="center">#</td>								          	
								          	<td><?=dil("Cari")?></td>
								          	<td><?=dil("Sigorta Türü")?></td>
								          	<td><?=dil("Yaş Aralığı")?></td>
								          	<td class="text-center"><?=dil("ORJ - Endex - Sıra")?></td>
								          	<td class="text-center"><?=dil("LO - Endex - Sıra")?></td>
								          	<td class="text-center"><?=dil("EŞD - Endex - Sıra")?></td>
								          	<td class="text-center"><?=dil("ÇIK - Endex - Sıra")?></td>
								          	<td align="center"><?=dil("Tarih")?></td>
								          	<td> </td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr id="tr<?=$row->ID?>">
									        <form name="form<?=$row->ID?>" id="form<?=$row->ID?>" class="" enctype="multipart/form-data" method="GET">
												<input type="hidden" name="islem" value="parca_tipi_yas_kurali_kaydet">
												<input type="hidden" name="id" value="<?=$row->ID?>">
											    
											    <td align="center"><?=($key+1)?></td>
											    <td><?=$row->UNVAN?></td>
											    <td><?=$row->SIGORTA_TURU?></td>
											    <td><?=$row->YAS_ILK?> - <?=$row->YAS_SON?></td>
											    <td class="text-center" style="width: 170px;">
											    	<div class="input-group">
									                  	<div class="input-group-addon" style="padding-top: 0; padding-bottom: 0px;"> <label style="margin-bottom: 0px;"> <input type="checkbox" name="orj<?=$row->ID?>" id="orj<?=$row->ID?>" value="1" <?=($row->ORJ)?' checked':''?>> </label> </div>
									                  	<input type="text" class="form-control" placeholder="" name="orj_oran<?=$row->ID?>" id="orj_oran<?=$row->ID?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: center;" value="<?=$row->ORJ_ORAN?>" maxlength="3">
									                  	<div class="input-group-addon" style="padding-top: 0; padding-bottom: 0px;"> 
									                  		<input type="text" class="" placeholder="" name="orj_sira<?=$row->ID?>" id="orj_sira<?=$row->ID?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: center; width: 30px;" value="<?=$row->ORJ_SIRA?>" maxlength="1">
									                  	</div>
									                </div>											    	
											    </td>
											    <td class="text-center" style="width: 170px;">
											    	<div class="input-group">
											    		<div class="input-group-addon" style="padding-top: 0; padding-bottom: 0px;"> <label style="margin-bottom: 0px;"> <input type="checkbox" name="lo<?=$row->ID?>" id="lo<?=$row->ID?>" value="1" <?=($row->LO)?' checked':''?>> </label> </div>
											    		<input type="text" class="form-control" placeholder="" name="lo_oran<?=$row->ID?>" id="lo_oran<?=$row->ID?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: center;" value="<?=$row->LO_ORAN?>" maxlength="3">
											    		<div class="input-group-addon" style="padding-top: 0; padding-bottom: 0px;"> 
									                  		<input type="text" class="" placeholder="" name="lo_sira<?=$row->ID?>" id="lo_sira<?=$row->ID?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: center; width: 30px;" value="<?=$row->LO_SIRA?>" maxlength="1">
									                  	</div>
									                </div>	
											    </td>
											    <td class="text-center" style="width: 170px;">
											    	<div class="input-group">
											    		<div class="input-group-addon" style="padding-top: 0; padding-bottom: 0px;"> <label style="margin-bottom: 0px;"> <input type="checkbox" name="esd<?=$row->ID?>" id="esd<?=$row->ID?>" value="1" <?=($row->ESD)?' checked':''?>> </label> </div>
											    		<input type="text" class="form-control" placeholder="" name="esd_oran<?=$row->ID?>" id="esd_oran<?=$row->ID?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: center;" value="<?=$row->ESD_ORAN?>" maxlength="3">
											    		<div class="input-group-addon" style="padding-top: 0; padding-bottom: 0px;"> 
									                  		<input type="text" class="" placeholder="" name="esd_sira<?=$row->ID?>" id="esd_sira<?=$row->ID?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: center; width: 30px;" value="<?=$row->ESD_SIRA?>" maxlength="1">
									                  	</div>
									                </div>	
											    </td>
											    <td class="text-center" style="width: 170px;">
											    	<div class="input-group">
											    		<div class="input-group-addon" style="padding-top: 0; padding-bottom: 0px;"> <label style="margin-bottom: 0px;"> <input type="checkbox" name="cik<?=$row->ID?>" id="cik<?=$row->ID?>" value="1" <?=($row->CIK)?' checked':''?>> </label> </div>
											    		<input type="text" class="form-control" placeholder="" name="cik_oran<?=$row->ID?>" id="cik_oran<?=$row->ID?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: center;" value="<?=$row->CIK_ORAN?>" maxlength="3">
											    		<div class="input-group-addon" style="padding-top: 0; padding-bottom: 0px;"> 
									                  		<input type="text" class="" placeholder="" name="cik_sira<?=$row->ID?>" id="cik_sira<?=$row->ID?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: center; width: 30px;" value="<?=$row->CIK_SIRA?>" maxlength="1">
									                  	</div>
									                </div>	
											    </td>
											    <td align="center"><?=FormatTarih::tarih($row->TARIH)?></td>
											    <td align="center" style="padding: 0px;">
											    	<button type="button" class="btn btn-success btn-sm" onclick="fncKaydet(this)" data-id="<?=$row->ID?>"> <?=dil("Kaydet")?> </button>
											    </td>
										    </form>
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
	<script src="../asset/bootstrap-maxlength.js"></script>
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
		
		function fncKaydet(obj){
			var id	= $(obj).data("id");
			var orj = $("#orj"+id).is(":checked") ? 1 : 0;
			var lo 	= $("#lo"+id).is(":checked") ? 1 : 0;
			var esd = $("#esd"+id).is(":checked") ? 1 : 0;
			var cik = $("#cik"+id).is(":checked") ? 1 : 0;
			
			var orj_oran 	= $("#orj_oran"+id).val();
			var lo_oran 	= $("#lo_oran"+id).val();
			var esd_oran 	= $("#esd_oran"+id).val();
			var cik_oran 	= $("#cik_oran"+id).val();
			
			var orj_sira 	= $("#orj_sira"+id).val();
			var lo_sira 	= $("#lo_sira"+id).val();
			var esd_sira	= $("#esd_sira"+id).val();
			var cik_sira 	= $("#cik_sira"+id).val();
			
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: {"islem": "parca_tipi_yas_kurali_kaydet", "id": id, "orj": orj, "lo": lo, "esd": esd, "cik": cik, "orj_oran": orj_oran, "lo_oran": lo_oran, "esd_oran": esd_oran, "cik_oran": cik_oran, "orj_sira": orj_sira, "lo_sira": lo_sira, "esd_sira": esd_sira, "cik_sira": cik_sira },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$(obj).removeClass("btn-success").addClass("btn-info");
					}
				}
			});
		}
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
	</script>
	
</body>
</html>
