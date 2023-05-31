<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	//error_reporting(E_ALL);
	
	$row_fatura			= $cSubData->getFatura($_REQUEST);
	$row_cari			= $cSubData->getCari(array("id"=>$row_fatura->CARI_ID));
	$row_tekne			= $cSubData->getTekne(array("id"=>$row_fatura->TEKNE_ID));
	$rows_cari_hareket	= $cSubData->getFaturaCariHareket($_REQUEST);
	
	$FATURA_NO = $row_fatura->FATURA_NO;
	
	// <img src="img/kullanici.jpg" width="150px"/>
	$html ='<html>
				<body>
				<div class="content">
					<div class="row">
						<div class="col-xs-5">
							<div class="form-group">
								<label class="col-xs-4"> '.dil("Fatura No").' : </label>
								<span>' . $row_fatura->FATURA_NO . '<span>
							</div>
						</div>
						<div class="col-xs-5">
							<div class="form-group">
								<label> '.dil("Fatura Tarih").' : </label>
								<span>' . FormatTarih::tarih(FormatTarih::Date($row_fatura->TARIH)) . '<span>
							</div>
						</div>
						<div class="col-xs-5">
							<div class="form-group">
								<label> '.dil("Cari Kodu").' : </label>
								<span>' . $row_cari->CARI_KODU . '<span>
							</div>
						</div>
						<div class="col-xs-5">
							<div class="form-group">
								<label> '.dil("Tekne Kodu").' : </label>
								<span>' . $row_tekne->TEKNE_KODU . '<span>
							</div>
						</div>
					</div>
					<div class="row">
						<span> <b> '.dil("Alınan Hizmetler").' </b> <span>
					</div>
					<div class="row">
						<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<td>  </td>
								<td> '.dil("Hizmet Kodu").' </td>
								<td> '.dil("Hizmet").' </td>
								<td> '.dil("Tutar").' </td>							
							</tr>
						</thead>
						<tbody>';
	foreach($rows_cari_hareket as $key=>$row_cari_hareket) {
		$html.='			<tr>
								<td align="right">'.($key+1).'</td>
								<td>'.$row_cari_hareket->MALI_KODU.'</td>
								<td>'.$row_cari_hareket->HIZMET.'</td>
								<td>'.$row_cari_hareket->UCRET.'</td>
							</tr>';
	}	
	$html.='			</tbody>
						</table>
					</div>
				</div>
				</body>
			</html>
			';
	
	//echo $html; die();
	$mpdf = new mPDF('utf-8-s','A4'); 
	$mpdf->SetDisplayMode('fullpage');
	
	$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
	
	// LOAD a stylesheet
	//$stylesheet = file_get_contents('mpdfstyletables.css');
	//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
	$mpdf->WriteHTML('<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">',1);
	$mpdf->WriteHTML('<link rel="stylesheet" href="/bootstrap/fonts/font-awesome.min.css">',1);
	$mpdf->WriteHTML('<link rel="stylesheet" href="/bootstrap/fonts/ionicons.min.css">',1);
	$mpdf->WriteHTML('<link rel="stylesheet" href="/asset/flag-icon-css-master/css/flag-icon.min.css">',1);
	$mpdf->WriteHTML('<link rel="stylesheet" href="/dist/css/AdminLTE.min.css.css">',1);
	$mpdf->WriteHTML('<link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">',1);
	$mpdf->WriteHTML('<link rel="stylesheet" href="/asset/1.css">',1);
	$mpdf->WriteHTML('<title> '.$FATURA_NO.'.pdf </title>',1);
	
	$mpdf->WriteHTML($html,2);
	
	$mpdf->Output("$FATURA_NO.pdf",'I');
	exit;
	
	
?>