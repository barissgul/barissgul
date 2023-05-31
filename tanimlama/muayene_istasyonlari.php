<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("ID","ID","");
	$excel->sutunEkle("Muayene İstasyonu","MUAYENE_ISTASYONU","");
	$excel->sutunEkle("İl","IL","");
	$excel->sutunEkle("İlçe","ILCE","");
	$excel->sutunEkle("Durum","DURUM","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaMuayeneIstasyonlari")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
	$rows = $Table['rows'];
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
            <li class="breadcrumb-item active"><?=dil("Muayene İstasyonlari")?></li>
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
									<div class="col-md-3 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Muayene İstasyonu")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="muayene_istasyonu" id="muayene_istasyonu" value="<?=$_REQUEST['muayene_istasyonu']?>" maxlength="100">
									    </div>
									</div>
									<div class="col-md-2 mb-3">
										<div class="form-group">
										  	<label class="form-label"><?=dil("İl")?></label>
										  	<select name="il_id" id="il_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Iller()->setSecilen($_REQUEST['il_id'])->setSeciniz()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Durum")?></label>
										  	<select name="durum" id="durum" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Durumlar()->setSecilen($_REQUEST['durum'])->setTumu()->getSelect("ID","AD")?>
										    </select>
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
                        <h2> <?=dil("Muayene İstasyonları")?> &nbsp;<span class="small">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                            <a href="/tanimlama/muayene_istasyonu.do?route=<?=$_REQUEST['route']?>" class="btn btn-light btn-sm btn-icon mr-1" title="Ekle"> <i class="far fa-plus"></i> </a>
		            		<a href="/excel_sql.do?" title="Excel" class="btn btn-outline-secondary btn-icon waves-effect waves-themed border-white text-white"> <i class="far fa-table"></i> </a>
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
								          	<td><?=dil("Muayene İstasyonu")?></td>
								          	<td><?=dil("İl")?></td>
								          	<td><?=dil("İlçe")?></td>
								          	<td align="center"><?=dil("Durum")?></td>
								          	<td> </td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center" class="p-0">
									          		<img src="/img/araba/harita.png" style="height: 30px"/>
									          	</td>
									          	<td align="center"><?=($Table['sayfaIlk']+$key+1)?></td>
									          	<td><?=$row->MUAYENE_ISTASYONU?></td>
									          	<td><?=$row->IL?></td>
									          	<td><?=$row->ILCE?></td>
									          	<td align="center"><?=$row->DURUM?></td>
									          	<td align="right" class="p-0"> 
									          		<a href="/tanimlama/muayene_istasyonu.do?route=<?=$_REQUEST['route']?>&id=<?=$row->ID?>" class="btn btn-outline-primary btn-icon" title="Düzenle"> <i class="far fa-edit"></i> </a> 
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
