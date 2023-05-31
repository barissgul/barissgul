<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$rows_basvuru 		= $cSubData->getBasvurular($_REQUEST);
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
    <style>
    	.panel-hdr{
			height: 30px;
		}
    </style>
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
    						<div class="table table-responsive">
							  	<table class="table table-sm table-bordered">
							  		<thead class="thead-themed">
							  			<tr class="text-bold">
							                <td align="center"> # </td>
							                <td><?=dil("Ad Soyad")?></td>
							                <td><?=dil("E Posta")?></td>
							                <td><?=dil("Telefon")?></td>
							                <td nowrap=""><?=dil("Firma Türü")?></td>
							                <td><?=dil("Adres")?></td>
							                <td><?=dil("Açıklama")?></td>
							                <td align="center"><?=dil("Kayıt Tarih")?></td>
							                <td><?=dil("Durum")?></td>
							                <td> </td>
					                	</tr>
							  		</thead>		    
					                <tbody>
					                	<?foreach($rows_basvuru as $key => $row_basvuru){?>
						            	<tr>
						            		<td align="center"><?=($key+1)?></td>
						                	<td><?=$row_basvuru->AD_SOYAD?></td>
						                	<td><?=$row_basvuru->EPOSTA?></td>
						                	<td nowrap=""><?=$row_basvuru->TELEFON?></td>
						                	<td><?=$row_basvuru->FIRMA_TURU?></td>
						                	<td><?=$row_basvuru->ADRES?></td>
						                	<td><?=$row_basvuru->ACIKLAMA?></td>
						                	<td align="center"><?=FormatTarih::tarih($row_basvuru->TARIH)?></td>
						                	<td><?=$row_basvuru->BASVURU_DURUM?></td>
						                	<td style="padding: 2px;">
						                		<button class="btn btn-outline-danger btn-icon rounded-circle hover-effect-dot waves-effect waves-themed" onclick="fncBasvuruSil(<?=$row_basvuru->ID?>, this)"><i class="far fa-trash"></i></button>
						                	</td>
						                </tr>
						                <tr class="bg-gray-200">
						                	<td colspan="4"> </td>
						                	<td colspan="4">
						                		<div class="col-sm-12" style="padding: 0px;">
								            		<div class="input-group" style="width: 100%">
												        <input type="text" class="form-control input-sm" placeholder="" name="cevap<?=$row_basvuru->ID?>" id="cevap<?=$row_basvuru->ID?>" value="<?=$row_basvuru->CEVAP?>" maxlength="255" >
														<div class="input-group-btn"> <button type="button" class="btn btn-outline-primary hover-effect-dot waves-effect waves-themed" onclick="fncCevapKaydet(this)" data-id="<?=$row_basvuru->ID?>"> <?=dil("Kaydet")?> </button> </div>
													</div>
								            	</div>
						                	</td>
						                	<td colspan="2"> </td>
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
		
		$("#mesaj_alani").scrollTop(500);
		
		$("[data-mask]").inputmask();		
		
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		function fncBasvuruSil(id, e){
			bootbox.confirm("<?=dil('Silmek istediğinizden emin misiniz')?>!", function(result){
				if(result == true){
					$.ajax({
						url: '/class/db_kayit.do?',
						type: "POST",
						data: {islem : 'basvuru_sil', id : id},
						dataType: 'json',
						async: true,
						success: function(jd) {
							if(jd.HATA){
								bootbox.alert(jd.ACIKLAMA, function() {});
							}else{
								bootbox.alert(jd.ACIKLAMA, function() {});
								$(e).closest('tr').fadeOut(700);
							}
						}
					});
				}
			});
		}
		
		function fncCevapKaydet(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "basvuru_cevap_kaydet", "id": $(obj).data("id"), "cevap": $("#cevap"+$(obj).data("id")).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {});
					}
				}
			});
		}
		
	
	</script>
    
</body>
</html>
