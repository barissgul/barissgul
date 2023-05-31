<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$SIFRE = fncSifreUret();
	
	$filtre = array();
	$sql = "UPDATE KULLANICI SET SIFRE = :SIFRE, SIFRE_TARIH = NOW() WHERE ID = :ID";
	$filtre[":SIFRE"] 	= fncSifreUret(6);
	$filtre[":ID"] 		= $_REQUEST['id'];
	$cdbPDO->rowsCount($sql, $filtre);
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title> <?=$row_site->TITLE?> </title>
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
  	<link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
  	<link rel="stylesheet" href="/bootstrap/fonts/font-awesome.min.css">
  	<link rel="stylesheet" href="/bootstrap/fonts/ionicons.min.css">  
  	<link rel="stylesheet" href="/plugins/select2/select2.min.css">
  	<link rel="stylesheet" href="/plugins/iCheck/flat/blue.css">
  	<link rel="stylesheet" href="/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  	<link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
  	<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
  	<link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  	<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
  	<link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  	<link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
  	<link rel="stylesheet" href="../asset/flag-icon-css-master/css/flag-icon.min.css">
  	<link rel="stylesheet" href="/asset/1.css">
</head>
<body class="<?=$cBootstrap->getTema()?> sidebar-collapse">
	<div class="wrapper">
	  	
	  	<div class="content-wrapper">
		    <section class="content">
		      	<div class="error-page">
		        	<h2 class="headline text-yellow"> <?=$filtre[":SIFRE"]?> </h2>
		        	<div class="error-content">
		          		<h3><i class="fa fa-warning text-yellow"></i> <?=dil("Şifreyi kimse ile paylaşmayınız")?>! </h3>
		        	</div>
		      	</div>
		    </section>	    	
	  	</div>  		
	</div>	

	<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="/plugins/jQueryUI/jquery-ui.min.js"></script>
	<script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="/plugins/select2/select2.full.min.js"></script>
	<script src="/plugins/raphael/2.1.0/raphael-min.js"></script>
	<script src="/plugins/sparkline/jquery.sparkline.min.js"></script>
	<script src="/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="/plugins/knob/jquery.knob.js"></script>
	<script src="/plugins/moment/2.11.2/moment.min.js"></script>
	<script src="/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="/plugins/iCheck/icheck.min.js"></script>
	<script src="/asset/bootbox/bootbox.min.js"></script>
	<script src="/plugins/fastclick/fastclick.js"></script>
	<script src="/plugins/input-mask/jquery.inputmask.js"></script>
	<script src="/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="/dist/js/app.min.js"></script>
	<script src="../asset/jquery.cookie.js"></script>
	<script src="/asset/1.js"></script>
	
	<script>
	  	$("[data-mask]").inputmask();
	  	
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
	</script>
	
</body>
</html>
