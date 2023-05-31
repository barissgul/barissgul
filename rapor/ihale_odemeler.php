<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("".dil("ID")."","ID","");
	$excel->sutunEkle("".dil("İhale No")."","IHALE_NO","");
	$excel->sutunEkle("".dil("Dosya No")."","DOSYA_NO","");
	$excel->sutunEkle("".dil("Plaka")."","PLAKA","");
	$excel->sutunEkle("".dil("Marka")."","MARKA","");
	$excel->sutunEkle("".dil("Model")."","MODEL","");
	$excel->sutunEkle("".dil("Model Yılı")."","MODEL_YILI","");
	$excel->sutunEkle("".dil("Süreç")."","SUREC","");
	$excel->sutunEkle("".dil("Metod")."","IHALE_METODU","");
	$excel->sutunEkle("".dil("Firma")."","FIRMA","");
	$excel->sutunEkle("".dil("Piyasa Değeri")."","PIYASA_DEGERI","");
	$excel->sutunEkle("".dil("İhale Bit Tarih")."","IHALE_BIT_TARIH","");
	$excel->sutunEkle("".dil("Kayıt Tarih")."","TARIH","format1");
	$excel->sutunEkle("".dil("Sasi No")."","SASI_NO","");
	$excel->sutunEkle("".dil("Servis Adı")."","SERVIS_ADI","");
	$excel->sutunEkle("".dil("Servis İl")."","SERVIS_IL","");
	$excel->sutunEkle("".dil("Servis İlçe")."","SERVIS_ILCE","");
	$excel->sutunEkle("".dil("Kazanan")."","KAZANAN","");
	$excel->sutunEkle("".dil("Kazanan Tarih")."","KAZANAN_TARIH","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaIhaleOdemeler")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows_ihale = $Table['rows'];
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
									<div class="col-lg-2 col-md-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("İhale No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="ihale_no" id="ihale_no" value="<?=$_REQUEST['ihale_no']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Dosya No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="dosya_no" id="dosya_no" value="<?=$_REQUEST['dosya_no']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Plaka")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$_REQUEST['plaka']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Süreç")?> </label>
										  	<select name="surec_id" id="surec_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Surecler()->setSecilen($_REQUEST['surec_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">		            
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Marka")?> </label>
										  	<select name="marka_id" id="marka_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Markalar2()->setSecilen($_REQUEST['marka_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">        
								        <div class="form-group">
								          	<label class="form-label"> <?=dil("Firma")?>  </label>
								          	<select name="firma_id" id="firma_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->Firmalar()->setSecilen($_REQUEST['firma_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
								        </div>
								    </div>
								    <div class="col-md-2 mb-2">        
								        <div class="form-group">
								          	<label class="form-label"> <?=dil("Kazanan")?>  </label>
								          	<select name="kazanan_id" id="kazanan_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->PertKullanicilar()->setSecilen($_REQUEST['kazanan_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
								        </div>
								    </div>
								    <div class="col-lg-2 col-md-4 mb-2">
								    	<div class="form-group">
										    <label class="form-label"> <?=dil("İhale Bitiş Tarihi")?> </label>
										    <div class="input-group date">
										      	<input type="text" class="form-control datepicker" name="ihale_bit_tarih" value="<?=$_REQUEST['ihale_bit_tarih']?>" readonly="">
										      	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
										    </div>
										</div>
									</div>
								    <div class="col-lg-2 col-md-4 mb-2">
								    	<div class="form-group">
										    <label class="form-label"> <?=dil("Pertçi Ödeme Tarihi")?> </label>
										    <div class="input-group date">
										      	<input type="text" class="form-control datepicker" name="pertci_odeme_tarih" value="<?=$_REQUEST['pertci_odeme_tarih']?>" readonly="">
										      	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
										    </div>
										</div>
									</div>
									<div class="col-lg-2 col-md-4 mb-2">
								    	<div class="form-group">
										    <label class="form-label"> <?=dil("Sigorta Ödeme Tarihi")?> </label>
										    <div class="input-group date">
										      	<input type="text" class="form-control datepicker" name="sigorta_odeme_tarih" value="<?=$_REQUEST['sigorta_odeme_tarih']?>" readonly="">
										      	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
										    </div>
										</div>
									</div>
									<div class="col-md-2 mb-2">
										<div class="form-group">
										  	<label class="form-label">&nbsp;</label><br>
									  		<button type="button" class="btn btn-warning" onclick="fncFiltrele()"><?=dil("Filtrele")?></button>
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
                        <h2> <?=dil("İhale Ödeme Raporu")?> <span style="font-size: 10px;">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-light btn-sm btn-icon"> <i class="far fa-file-excel"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  	<table class="table table-sm table-hover table-bordered">
						  		<thead class="thead-themed">
							    	<tr>
							          	<td align="center">#</td>
							          	<td nowrap><?=dil("İhale No")?></td>
							          	<td nowrap><?=dil("Dosya No")?></td>
							          	<td><?=dil("Plaka")?></td>
							          	<td><?=dil("Firma")?></td>
							          	<td><?=dil("Marka")?></td>
							          	<td><?=dil("Süreç")?></td>
							          	<td align="center"><?=dil("İhale Bit Tarih")?></td>
							          	<td><?=dil("Kazanan")?></td>
							          	<td align="center"><?=dil("Pertçi Ödeme")?></td>
							          	<td align="center"><?=dil("Sigorta Ödeme")?></td>
							          	<td><?=dil("Ödeme TCK")?></td>
							          	<td><?=dil("Ödeme Kişi")?></td>
							          	<td><?=dil("Ödeme IBAN")?></td>
							          	<td> </td>
							        </tr>
						        </thead>
						        <tbody>
							        <?foreach($rows_ihale as $key=>$row_ihale) {?>
								        <tr>
								          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
								          	<td><?=$row_ihale->IHALE_NO?></td>
								          	<td><?=$row_ihale->DOSYA_NO?></td>
								          	<td><?=$row_ihale->PLAKA?></td>
								          	<td><?=$row_ihale->FIRMA?></td>
								          	<td><?=$row_ihale->MARKA?> (<?=$row_ihale->MODEL_YILI?>) </td>
								          	<td><?=$row_ihale->SUREC?></td>
								          	<td align="center"><?=FormatTarih::tarih(FormatTarih::Date($row_ihale->IHALE_BIT_TARIH))?></td>
								          	<td><?=$row_ihale->KAZANAN?></td>
								          	<td align="center"><?=FormatTarih::tarih($row_ihale->PERTCI_ODEME_TARIH)?></td>
								          	<td align="center"><?=FormatTarih::tarih($row_ihale->SIGORTA_ODEME_TARIH)?></td>
								          	<td><?=$row_ihale->ODEME_TCK?></td>
								          	<td><?=$row_ihale->ODEME_KISI?></td>
								          	<td><?=$row_ihale->ODEME_IBAN?></td>
								          	<td class="p-0 text-center">									          		
								          		<a href="javascript:void(0)" onclick="fncPopup('/ihale/sonuc.do?route=ihale/sonuc&id=<?=$row_ihale->ID?>&kod=<?=$row_ihale->KOD?>','OZET',1100,900)" class="btn btn-outline-primary btn-icon" title="<?=dil("Sonuç")?>"> <i class="far fa-flag"></i> </a> 
								          		<a href="javascript:void(0)" onclick="fncPopup('/ihale/popup_ozet.do?route=ihale/ozet&id=<?=$row_ihale->ID?>&kod=<?=$row_ihale->KOD?>','OZET',1000,800)" class="btn btn-outline-primary btn-icon" title="<?=dil("Özet")?>"> <i class="far fa-search"></i> </a> 
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
		  	checkboxClass: 'icheckbox_square-orange',
		 	radioClass: 'iradio_square-orange',
		  	increaseArea: '20%' // optional
		});
		
		function fncFiltrele(){
			$("#form").submit();
		}
	
	</script>
    
</body>
</html>
