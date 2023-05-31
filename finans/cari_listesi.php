<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("ID","ID","");
	$excel->sutunEkle("Müşteri","UNVAN","");
	$excel->sutunEkle("Müşteri Tipi","MUSTERI_TIPI","");
	$excel->sutunEkle("Vergi No","TCK","");
	$excel->sutunEkle("Adres İl","IL","");
	$excel->sutunEkle("Adres İlçe","ILCE","");
	$excel->sutunEkle("Vergi Dairesi","VD","");
	$excel->sutunEkle("CepTel","CEPTEL","");
	$excel->sutunEkle("Asistan","ASISTAN_HIZMETI","");
	$excel->sutunEkle("Durum","DURUM","");
	$excel->sutunEkle("Kayıt Tarih","TARIH","");
	$excel->sutunEkle("Güncel Tarih","GTARIH","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaMusteriler")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
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
    	<ol class="breadcrumb page-breadcrumb breadcrumb-seperator-1">
            <li class="breadcrumb-item"><a href="/"><?=dil("Kontrol Paneli")?></a></li>
            <li class="breadcrumb-item active"><?=dil("Cari Listesi")?></li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        
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
										  	<label class="form-label"><?=dil("Cari Türü")?></label>
										  	<select name="cari_turu" id="cari_turu" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->CariTuru()->setSecilen($_REQUEST['cari_turu'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Cari Kod")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="cari_kod" id="cari_kod" value="<?=$_REQUEST['cari_kod']?>" maxlength="100">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Cari")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="cari" id="cari" value="<?=$_REQUEST['cari']?>" maxlength="100">
									    </div>
									</div>
									<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("TCK / VKN")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="tck" id="tck" value="<?=$_REQUEST['tck']?>" maxlength="11">
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
								    <div class="col-xl-2 col-sm-4 mb-2">        
								        <div class="form-group">
								        	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="tarih_var" name="tarih_var" <?=($_REQUEST['tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="tarih_var"><?=dil("Kayıt Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									      		<div class="input-group-prepend hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="tarih" name="tarih" value="<?=$_REQUEST['tarih']?>" readonly>
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
                        <h2> <i class="fal fa-users mr-3"></i> <?=dil("Cari Listesi")?> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                        	<a href="/finans/cari_aktarma.do?route=cari/cari_aktarma" class="btn btn-icon btn-outline-secondary text-white border-white mr-1" title="Cari Aktarma"> <i class="far fa-user-times"></i> </a>
                            <a href="/finans/cari.do?route=<?=$_REQUEST['route']?>" class="btn btn-icon btn-outline-secondary text-white border-white mr-1" title="Cari Ekle"> <i class="far fa-plus"></i> </a>
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-icon btn-light mr-1"> <i class="far fa-table"></i> </a>
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
								          	<td align="center"><?=dil("Cari KOD")?></td>
								          	<td><?=dil("TCK / VKN")?></td>
								          	<td><?=dil("Cari")?></td>
								          	<td><?=dil("Vergi Dairesi")?></td>
								          	<td><?=dil("Adres İl / İlçe")?></td>
								          	<td><?=dil("CepTel")?></td>
								          	<td align="center"><?=dil("Durum")?></td>
								          	<td align="center"><?=dil("Tarih")?></td>
								          	<td> </td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center" class="p-0">
									          		<?if($row->MUSTERI_TIPI == 'B') {?>
									          			<img src="/img/araba/bireysel.png" style="height: 30px"/>
									          		<?} else {?>
									          			<img src="/img/araba/kurumsal.png" style="height: 30px"/>
									          		<?}?>
									          	</td>
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td align="center"> <a href="javascript:fncPopup('/finans/ekstre.do?route=finans/ekstre&kod=<?=$row->KOD?>&filtre=1&finans_kalemi_id=<?=$_REQUEST["finans_kalemi_id"]?>&talep_no=<?=$_REQUEST["talep_no"]?>','EKSTRE',1000,800);" title="Ektre"> <?=$row->CARI_KOD?> </a> </td>
									          	<td><?=$row->TCK?></td>
									          	<td><?=$row->CARI?></td>
									          	<td><?=$row->VD?></td>
									          	<td><?=$row->IL?> / <?=$row->ILCE?></td>
									          	<td><?=$row->CEPTEL?></td>
									          	<td align="center"><?=$row->DURUM?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->TARIH)?></td>
									          	<td align="right"> 
									          		<a href="javascript:fncPopup('/finans/ekstre.do?route=finans/ekstre&kod=<?=$row->KOD?>&filtre=1','EKSTRE',1000,800);" class="btn btn-outline-warning btn-icon"  title="Ektre"> <i class="far fa-list-ul"></i> </a>
									          		<a href="/finans/cari.do?route=<?=$_REQUEST['route']?>&id=<?=$row->ID?>&kod=<?=$row->KOD?>" class="btn btn-outline-primary btn-icon" title="Müşteri Düzenle"> <i class="far fa-edit"></i> </a> 
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
		
		$("#cari_kod, #cari, #tck").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
				
	</script>
    
</body>
</html>
