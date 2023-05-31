<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	
	//$_REQUEST["payload"] = '{"status":true,"error":"","paymentId":"124548645","forwardedData":{"id":"843","kod":"9c30305c53ad2d8ab9d914fb7c115a6f"}}';
	
	$row 				= $cSubData->getTalep($_REQUEST);
	$row_tahsilat		= $cSubData->getSonTahsilat($_REQUEST);
	
?>
<!DOCTYPE html>
<html lang="tr" class="<?=$cBootstrap->getFontBoyut()?>">
<head>
    <meta charset="utf-8">
    <title> <?=$row_site->TITLE?> <?=dil("Ödeme")?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/vendors.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/app.bundle.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-regular.css">
    <link rel="stylesheet" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="<?=$cBootstrap->getBody()?>">
	<div class="container" style="padding: 0">
		<nav class="navbar navbar-dark shadow-inset-5">
	    	<a class="navbar-brand d-flex align-items-center fw-500" href="#">
		        <img src="/img/logo2.png" alt="logo" aria-roledescription="logo" style="height: 35px;">
	    	</a>
	    	<span class="fs-xl fw-500">
	    		<?=dil("Talep No")?> : <?=$row->ID?>
	    	</span>
	    </nav>
	</div>
	
    <div class="page-wrapper">
    <div class="page-inner">
    
    <main id="js-page-content" role="main" class="page-content pt-1">
        <section class="container p-0">
        	
        	<div class="row">
        		<div class="col-md-12 px-0">
					<div class="panel">
    				<div class="panel-hdr bg-primary-300 text-white">
                        <h2> <i class="fal fa-lira-sign mr-3"></i> <?=dil("Ödeme Durumu")?> </h2>
                        <div class="panel-toolbar">
                        	<button class="btn btn-panel bg-transparent fs-xl w-auto h-auto rounded-0 waves-effect waves-themed text-white" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"><i class="fal fa-angle-double-down fa-2x"></i></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content pb-6">
                        	<div class="row">
                        		<div class="col-md-12 text-center">
                        			<span style="font-size: 50px; color: #71b830"><?=dil("Ödemeniz Başarılı ile alınmıştır!")?></span><br>
                        			<table class="table ">
                        				<tr>
                        					<td>
                        						<?=dil("Tahsilat Mahbuzu")?>
                        					</td>
                        				</tr>
                        				<tr>
                        					<td>
                        						<a href="<?=fncOdemePopupLink($row_tahsilat)?>" class="btn btn-outline-primary btn-icon rounded-circle waves-effect waves-themed mr-1"> <i class="fal fa-print"></i>  </a> 
                        					</td>
                        				</tr>
                        			</table>
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
            
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../smartadmin/js/datagrid/datatables/datatables.bundle.js"></script>
    <script src="../smartadmin/js/notifications/toastr/toastr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-datepicker.tr.js"></script>
    <script src="../smartadmin/plugin/bootstrap-maxlength.js"></script>
    <script src="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../smartadmin/plugin/jquery.lazy-master/jquery.lazy.min.js"></script>
    <script src="../smartadmin/plugin/input-mask/jquery.inputmask.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.numeric.extensions.js"></script>
	<script src="../smartadmin/plugin/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="../smartadmin/plugin/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js"></script>
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
    	
    	$("[data-mask]").inputmask();
    	
		function fncFiltrele(){
			$("#form").submit();
		}
		
		function fncFaturaAyni(obj){
			$("#fatura_isim").val($("#isim_soyisim").val());
			$("#fatura_tck").val($("#tck").val());
			$("#fatura_adres").val($("#adres").val());
			$("#fatura_il_id").val($("#il_id").val()).trigger('change');
			setTimeout(function(){ $("#fatura_ilce_id").val($("#ilce_id").val()).trigger('change'); }, 3000);
			
		}
		
		fncAdres();
		function fncAdres(){
			$("#td_adres").text($("#adres").val());
		}
		
		function fncOdeme(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#form').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncIlceDoldur(){
			$("#ilce_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "ilce_doldur", 'il_id' : $("#il_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$('#ilce_id').html(jd.HTML);
					}
					$("#ilce_id").removeAttr("disabled");
				}
			});
		};
		
		function fncFaturaIlceDoldur(){
			$("#fatura_ilce_id").attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "ilce_doldur", 'il_id' : $("#fatura_il_id").val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						$('#fatura_ilce_id').html(jd.HTML);
					}
					$("#fatura_ilce_id").removeAttr("disabled");
				}
			});
		};
		
	</script>
    
</body>
</html>
