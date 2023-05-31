<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("ID","ID","");
	$excel->sutunEkle("Şahıs/Şirket","SAHIS_SIRKET","");
	$excel->sutunEkle("Ad","AD","");
	$excel->sutunEkle("Soyad","SOYAD","");
	$excel->sutunEkle("Ünvan","UNVAN","");
	$excel->sutunEkle("Cep Tel","CEPTEL","");
	$excel->sutunEkle("Sabit Tel","TEL","");
	$excel->sutunEkle("Yetki","YETKI","");
	$excel->sutunEkle("Araç Alım Türü","ARAC_ALIM_TURLERI","");
	$excel->sutunEkle("Mail","MAIL","");
	$excel->sutunEkle("Adres","ADRES","");
	$excel->sutunEkle("Adres İli","IL","");
	$excel->sutunEkle("Durum","DURUM","");
	$excel->sutunEkle("Sozlesme","SOZLESME","");
	$excel->sutunEkle("Kayıt Tarih","TARIH","");
	$excel->sutunEkle("Güncel Tarih","GTARIH","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaAraclar")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows = $Table['rows'];//echo json_encode($rows);die();
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
							<form name="form" id="form" class="app-forms" enctype="multipart/form-data" method="GET">
								<input type="hidden" name="route" value="<?=$_REQUEST['route']?>">
								<input type="hidden" name="sayfa" id="sayfa">
								<input type="hidden" name="filtre" value="1">
								<div class="row">
									<div class="col-lg-2 col-md-3 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Marka")?></label>
										  	<select name="yetki_id" id="yetki_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Markalar()->setSecilen($_REQUEST['marka_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Plaka")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="plaka" id="plaka" value="<?=$_REQUEST['plaka']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 mb-2">   
								        <div class="form-group">
									      	<label class="form-label"> <?=dil("Vites")?> </label>
									      	<select name="vites_id" id="vites_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->VitesTuru()->setSecilen($_REQUEST['vites_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
									    </div>
								    </div>
								    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 mb-2">   
								        <div class="form-group">
									      	<label class="form-label"> <?=dil("Yakıt")?> </label>
									      	<select name="yakit_id" id="yakit_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->YakitTuru()->setSecilen($_REQUEST['yakit_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
									    </div>
								    </div>
									<div class="col-lg-2 col-md-3 mb-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Sürücü")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="kullanici" id="kullanici" value="<?=$_REQUEST['kullanici']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Durum")?></label>
										  	<select name="durum" id="durum" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Durumlar()->setSecilen($_REQUEST['durum'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
								    <div class="col-lg-2 col-md-3 mb-2">        
								        <div class="form-group">
									      	<label class="form-label"> <input type="checkbox" name="tarih_var" id="tarih_var" value="1" <?=($_REQUEST['tarih_var'])?' checked':''?>> <?=dil("Kayıt Tarihi")?> </label>
									      	<div class="input-group">
									          	<input type="text" class="form-control pull-right" id="tarih" name="tarih" value="<?=$_REQUEST['tarih']?>">
									          	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									        </div>
									    </div>
								    </div>
									<div class="col-md-2 mb-2">
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
                        <h2> <?=dil("Araç Listesi")?> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                            <a href="/tanimlama/arac.do?route=<?=$_REQUEST['route']?>" class="btn btn-light btn-md btn-icon mr-1" title="Araç Ekle"> <i class="far fa-plus"></i> </a>
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-light btn-md btn-icon"> <i class="far fa-file-excel"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover">
							  		<thead class="thead-themed fw-500">
								    	<tr>
								          	<td></td>
								          	<td align="center">#</td>
								          	<td><?=dil("Plaka")?></td>
								          	<td><?=dil("Marka - Model")?></td>
								          	<td><?=dil("M.Yılı")?></td>
								          	<td><?=dil("Vites")?></td>
								          	<td><?=dil("Yakıt")?></td>
								          	<td><?=dil("Müşteri")?></td>
								          	<td><?=dil("Sürücü Bilgileri")?></td>
								          	<td><?=dil("Araç Sahibi")?></td>
								          	<td align="center"><?=dil("Durum")?></td>
								          	<td align="center"><?=dil("Tarih")?></td>
								          	<td> </td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center"><span class="rounded-circle profile-image d-block" style="background-image:url('/img/araba/araba_yesil.png'); background-size: cover;"></span></td>
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td><?=$row->PLAKA?></td>
									          	<td>
									          		<?=$row->MARKA?><br>
									          		<?=$row->MODEL?>
									          	</td>
									          	<td><?=$row->MODEL_YILI?></td>
									          	<td><?=$row->VITES?></td>
									          	<td><?=$row->YAKIT?></td>
									          	<td>
									          		<?=$row->MUSTERI?><br>
									          		<?=$row->MUSTERI_TIPI?>
									          	</td>
									          	<td>
									          		<div class="d-flex w-100 text-dark hover-white cursor-pointer show-child-on-hover">
                                                        <div class="profile-image-md rounded-circle" style="background-image:url('/img/kullanici.png'); background-size: cover;"></div>
                                                        <div class=" flex-1">
                                                            <div class="text-truncate text-truncate-md">
                                                               	<?=$row->SURUCU_AD?> <?=$row->SURUCU_SOYAD?>
                                                                <small class="d-block text-muted text-truncate text-truncate-md"><a href=""><?=dil("Değiştir")?></a></small>
                                                            </div>
                                                        </div>
                                                    </div>
									          	</td>
									          	<td>
									          		<div class="d-flex w-100 text-dark hover-white cursor-pointer show-child-on-hover">
                                                        <div class="profile-image-md rounded-circle" style="background-image:url('/img/kullanici.png'); background-size: cover;"></div>
                                                        <div class=" flex-1">
                                                            <div class="text-truncate text-truncate-md">
                                                               	<?=$row->SAHIBI_AD?> <?=$row->SAHIBI_SOYAD?>
                                                                <small class="d-block text-muted text-truncate text-truncate-md"><a href=""><?=dil("Değiştir")?></a></small>
                                                            </div>
                                                        </div>
                                                    </div>
									          	</td>
									          	<td align="center"><?=$row->DURUM?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->TARIH)?></td>
									          	<td align="center"> 
									          		<a href="/tanimlama/arac.do?route=<?=$_REQUEST['route']?>&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn btn-outline-primary btn-icon" title="Kullanıcı Düzenle"> <i class="far fa-edit"></i> </a> 
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
    
		$("[data-mask]").inputmask();
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		$('#tarih, #gtarih').daterangepicker({
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
		
		function fncSifreResetle(id){
			bootbox.confirm("Şifre resetlemek istediğinizden emin misiniz!", function(result){
				if(result){
					fncPopup('/kullanici/sifre_reset.php?id='+id,'SIFRE_RESET',600,400);
				}
			});
		}
		
		$("#kullanici, #ad, #soyad, #unvan").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
				
	</script>
    
</body>
</html>
