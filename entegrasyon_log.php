<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("ID","ID","");
	$excel->sutunEkle("Ad","AD","");
	$excel->sutunEkle("Soyad","SOYAD","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaEntegrasyonLog")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows_entegrasyon = $Table['rows'];
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
									<div class="col-md-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("İhale No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="ihale_no" id="ihale_no" value="<?=$_REQUEST['ihale_no']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-md-2">						            
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Tip")?> </label>
										  	<select name="tip_id" id="tip_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->EntegrasyonTipleri()->setSecilen($_REQUEST['tip_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2">						            
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Durum")?> </label>
										  	<select name="durum" id="durum" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Durumlar()->setSecilen($_REQUEST['durum'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>									
									<div class="col-md-2">        
								        <div class="form-group">
									      	<label class="form-label"> <input type="checkbox" name="tarih_var" id="tarih_var" value="1" <?=($_REQUEST['tarih_var'])?' checked':''?>> <?=dil("İşlem Tarihi")?> </label>
									      	<div class="input-group">
									          	<input type="text" class="form-control pull-right" id="tarih" name="tarih" value="<?=$_REQUEST['tarih']?>">
									          	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									        </div>
									    </div>
								    </div>
									<div class="col-md-2">
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
                        <h2> <?=dil("Entegrasyon Log")?> <span style="font-size: 10px;">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-outline-secondary btn-icon waves-effect waves-themed border-white text-white"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-condensed table-hover">
						  		<thead class="thead-themed">
							    	<tr>
							          	<td align="center">#</td>
							          	<th><?=dil("No")?></th>
							          	<th><?=dil("Tip")?></th>
							          	<th><?=dil("Durum")?></th>
							          	<th><?=dil("Kullanıcı")?></th>
							          	<th><?=dil("Tarih")?></th>
							          	<th><?=dil("Giden")?></th>
							          	<th><?=dil("Gelen")?></th>
							        </tr>
						        </thead>
						        <tbody>
							        <?foreach($rows_entegrasyon as $key=>$row_entegrasyon) {?>
								        <tr>
								          	<td align="center"><?=($key+1)?></td>
								          	<td><?=$row_entegrasyon->NO?></td>
								          	<td><?=$row_entegrasyon->TIP?></td>									          	
								          	<td><?=$row_entegrasyon->DURUM?></td>
								          	<td><?=$row_entegrasyon->KULLANICI?></td>
								          	<td><?=FormatTarih::tarih($row_entegrasyon->TARIH)?></td>
								          	<td class="small">
								          		<div class="col-md-12">
										        <div class="box box-warning collapsed-box" style="margin-bottom: 0px;">
										            <div class="box-header with-border">
										              	<h3 class="box-title">XML</h3>
										              	<div class="box-tools pull-right">
										                	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="far fa-plus"></i></button>
										            	</div>
										            </div>											            
										            <div class="box-body" style="display: none;">
										              	<?=htmlentities($row_entegrasyon->GIDEN_XML)?>
										            </div>
										        </div>
										        </div>
								          	</td>
								          	<td class="small">
								          		<div class="col-md-12">
									          	<div class="box box-info collapsed-box" style="margin-bottom: 0px;">
											        <div class="box-header with-border">
											          	<h3 class="box-title">XML</h3>
											          	<div class="box-tools pull-right">
											            	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="far fa-plus"></i></button>
											        	</div>
											        </div>											            
											        <div class="box-body" style="display: none;">
											          	<?=htmlentities($row_entegrasyon->GELEN_XML)?>
											        </div>
											    </div>
										        </div>
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
		
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		$('#tarih').daterangepicker({
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
