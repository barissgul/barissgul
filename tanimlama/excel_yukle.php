<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	$rows_excel	= $cSubData->getTopluUrunExceller();
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title> <?=$row_site->TITLE?> </title>
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" type="image/png" href="../php.png" />
  	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  	<link rel="stylesheet" href="../bootstrap/fonts/font-awesome.min.css">
  	<link rel="stylesheet" href="../bootstrap/fonts/ionicons.min.css">  
  	<link rel="stylesheet" href="../plugins/select2/select2.min.css">
  	<link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
  	<link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  	<link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
  	<link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  	<link rel="stylesheet" href="../asset/bootstrap-fileinput-master/css/fileinput.css"/>
  	<link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  	<link rel="stylesheet" href="../plugins/iCheck/square/blue.css">
  	<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  	<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  	<link rel="stylesheet" href="../asset/1.css">
</head>
<body class="hold-transition <?=$cBootstrap->getTema()?>">
	<div class="wrapper">
		
		<?=$cBootstrap->getHeader();?>
	  	
	  	<div class="content-wrapper">
		    <section class="content-header">
		      	<h1> <?=dil("Excel Yükle")?> </h1>     	
		      	<ol class="breadcrumb">
			        <li><a href="/index.do"><i class="fa fa-dashboard"></i> <?=dil("Kontrol Paneli")?> </a></li>
			        <li class="active"> <?=dil("Excel Yükle")?> </li>
		      	</ol>
		    </section>
		    <section class="content">
		    	<div class="row">
		    		<div class="col-md-12">
			    		<div class="box box-warning">
							<div class="box-header">
							  	<h3 class="box-title"> <?=dil("Excel Yükle")?> </h3>
							  	<div class="box-tools pull-right">
				                	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				              	</div>				              	
							</div>
							<div class="box-body">
								<div class="row">
					                <div class="col-md-8">
								        <table class="table table-condensed">
								        	<tr>
									          	<th style="width: 10px">#</th>
									          	<th> <?=dil("Dosya Adı")?> </th>
									          	<th> <?=dil("Yükleyen")?></th>
									          	<th> <?=dil("Tarih")?> </th>
									          	<th> <?=dil("Tür")?> </th>
									          	<th> </th>
									        </tr>
									        <?foreach($rows_excel as $key=>$row_excel) {?>
									        <tr>
									          	<td><?=($key+1)?></td>
									          	<td><a href="<?=$row_excel->RESIM_URL?>" target="_blank"> <?=$row_excel->EXCEL_ILK?> </a></td>
									          	<td><?=$row_excel->YUKLEYEN?></td>
									          	<td><?=FormatTarih::tarih($row_excel->TARIH)?></td>
									          	<td>
									          		<?if($row_gezi->KULLANICI_ID == $_SESSION['kullanici_id']) { ?>
									          			<a href="javascript:void(0)" onclick="fncResimSil(this)" title="Sil" data-id="<?=$row_excel->ID?>"> <i class="fa fa-trash-o"></i> </a>
									          		<?}?>
									          	</td>
									          	<td><?=$row_excel->TUR?></td>
									          	<td> <a href="/tanimlama/excel_in.do?EXCEL_YOL=<?=$row_excel->EXCEL?>&TUR=ARAC_DEGER_LISTESI" class="btn btn-default btn-sm bittersweet" title="Uygula"><i class="glyphicon glyphicon-play"></i></a> </td>
									        </tr>
									        <?}?>
								        </table>
					    			</div>
									<div class="col-md-4">
										<div class="row">
											<div class="col-md-12">
									        	<div class="form-group">
									           		<input id="excel" name="excel" type="file" class="file-loading" data-show-upload="true" data-language="tr">
									        	</div>
								    		</div>
								    		<div class="col-md-12">
								    			<div class="callout callout-warning">
									                <h4>Yüklenecek Dosya:</h4>
									                <p>.xls, .xlsx dosya uzantısı Microsoft Office Excel dosyası yüklenebilir.</p>
									            </div>
								    		</div>
								    	</div>
								    </div>
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
	<script src="../plugins/select2/select2.full.min.js"></script>
	<script src="../plugins/raphael/2.1.0/raphael-min.js"></script>
	<script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
	<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../plugins/knob/jquery.knob.js"></script>
	<script src="../plugins/moment/2.11.2/moment.min.js"></script>
	<script src="../plugins/daterangepicker/daterangepicker.js"></script>
	<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="../asset/bootstrap-fileinput-master/js/fileinput.js"></script>
    <script src="../asset/bootstrap-fileinput-master/js/locales/tr.js"></script>
	<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="../plugins/iCheck/icheck.min.js"></script>
	<script src="../asset/bootbox/bootbox.min.js"></script>
	<script src="../plugins/fastclick/fastclick.js"></script>
	<script src="../dist/js/app.min.js"></script>
	<script src="../asset/1.js"></script>
	<script>
	  	 
		$('input').iCheck({
		  	checkboxClass: 'icheckbox_square-blue',
		 	radioClass: 'iradio_square-blue',
		  	increaseArea: '20%' // optional
		});
		
		$("#excel").fileinput({
	    	language: 'tr',
	        uploadUrl: '/class/db_kayit.do?islem=excel_yukle',
	        allowedFileExtensions : ['xls', 'xlsx'],
	        overwriteInitial: false,
	        maxFileSize: 25000,
	        maxFilesNum: 1,
	        uploadAsync: true,
	        //allowedFileTypes: ['image', 'video'],
	        slugCallback: function(filename) {
	            return filename.replace('(', '_').replace(']', '_');
	        }
		});
		
		$('#excel').on('fileuploaded', function(event, data, previewId, index) {
		   	location.href = "/tanimlama/excel_yukle.do?route=tanimlama/excel";
		});
		
		function fncKategoriEkle(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formKategoriEkle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							$("#modalKategoriEkle").modal("hide");
						});
					}
				}
			});
		}
		
	</script>
	
</body>
</html>
