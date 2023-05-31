<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	yetki_kontrol();
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("".dil("ID")."","ID","");
	$excel->sutunEkle("".dil("Kullanıcı")."","KULLANICI","");
	$excel->sutunEkle("".dil("Ad")."","AD","");
	$excel->sutunEkle("".dil("Soyad")."","SOYAD","");
	$excel->sutunEkle("".dil("Yetki")."","YETKI","");
	$excel->sutunEkle("".dil("Ülke")."","ULKE","");
	$excel->sutunEkle("".dil("İl")."","IL","");
	$excel->sutunEkle("".dil("Durum")."","DURUM","");
	$excel->sutunEkle("".dil("Tarih")."","TARIH","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaKullanicilarLog")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();	
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
									<div class="col-md-2 mb-3">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Kulanıcı")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="kullanici" id="kullanici" value="<?=$_REQUEST['kullanici']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-md-2 mb-3">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Ad")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="ad" id="ad" value="<?=$_REQUEST['ad']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-md-2 mb-3">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Soyad")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="soyad" id="soyad" value="<?=$_REQUEST['soyad']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-md-2 mb-3">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Durum")?></label>
										  	<select name="durum" id="durum" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Durumlar()->setSecilen($_REQUEST['durum'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-3">						            
									    <div class="form-group">
										  	<label class="form-label"><?=dil("Yetki")?></label>
										  	<select name="yetki" id="yetki_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Yetkiler()->setSecilen($_REQUEST['yetki'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-3">
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
                        <h2> <?=dil("Kullanıcılar Log")?>&nbsp;<span style="font-size: 10px;">(<?=$Table['sayfaUstYazi']?>)</span> </h2>
                        <div class="panel-toolbar">
                           <a href="/excel_sql.do?" title="Excel" class="btn btn-outline-secondary btn-icon waves-effect waves-themed border-white text-white"> <i class="far fa-table"></i> </a>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
							<div class="table-responsive">
						  		<table class="table table-sm table-condensed table-hover table-bordered">
							  		<thead class="thead-themed font-weight-bold">
								    	<tr>
								          	<td align="center">#</td>
								          	<td><?=dil("Kullanıcı")?></td>
								          	<td><?=dil("Ad")?></td>
								          	<td><?=dil("Soyad")?></td>
								          	<td><?=dil("Şifre")?></td>
								          	<td><?=dil("Yetki")?></td>
								          	<td><?=dil("Ülke")?></td>
								          	<td><?=dil("İl")?></td>
								          	<td align="center"><?=dil("Durum")?></td>
								          	<td align="center"><?=dil("Tarih")?></td>
								        </tr>
							        </thead>
							        <tbody>
								        <?foreach($rows as $key=>$row) {?>
									        <tr>
									          	<td align="center"><?=($key+1)?></td>
									          	<td><?=$row->KULLANICI?></td>
									          	<td><?=$row->AD?></td>
									          	<td><?=$row->SOYAD?></td>
									          	<td><?=$row->SIFRE?></td>
									          	<td><?=$row->YETKI?></td>
									          	<td><?=$row->ULKE?></td>
									          	<td><?=$row->IL?></td>
									          	<td align="center"><?=$row->DURUM?></td>
									          	<td align="center"><?=FormatTarih::tarih($row->TARIH)?></td>
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
		
		$('.datatable').DataTable({
		  	"paging": true,
		 	"lengthChange": true,
		  	"searching": true,
		  	"ordering": true,
		  	"info": true,
		  	"autoWidth": true,
		  	"select":true,
		  	"autoFill": true,
		  	"language": {
        		//"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
        		"url": "/asset/Datatable_Turkish.json"
        	},
        	"columnDefs": [{
		          "targets": 'no-sort',
		          "orderable": false,
		    }]
		});
		
		function fncKullaniciEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formKullaniciEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#modalKullaniciEkle").modal("hide");
						});
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
