<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	//error_reporting(E_ALL);
	
	$excel = new excelSayfasi();
	$excel->sutunEkle("Sıra","SIRA","");
	$excel->sutunEkle("Hareket","HAREKET","");
	$excel->sutunEkle("Finans Kalemi","FINANS_KALEMI","");
	$excel->sutunEkle("Fatura No","FATURA_NO","");
	$excel->sutunEkle("Fatura Tarih","FATURA_TARIH","");	
	$excel->sutunEkle("Plaka","PLAKA","");
	$excel->sutunEkle("Cari Kod","CARI_KOD","");
	$excel->sutunEkle("Cari","CARI","");
	$excel->sutunEkle("Borç","BORC","");
	$excel->sutunEkle("Alacak","ALACAK","");
	$excel->sutunEkle("Bakiye","BAKIYE","Bakiye",);
	$excel->sutunEkle("Tarih","TARIH","");
	$excel->sutunEkle("Açıklama","ACIKLAMA","");
	$excelOut = $excel->excel();
	$Table = $cTable->setSayfa("sayfaEktre")->setExcel($excelOut)->setPost($_REQUEST)->Uygula()->getTable();
	$rows = $Table['rows'];
	$_SESSION['Table'] = $Table;
	//var_dump2($Table['sqls']);
	
	$row_cari = $cSubData->getCariKod($_REQUEST);
	ob_start();
	?>
	<html>
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
		<body>
			<div class="content">
				<div class="row">
					<div class="col-md-12 text-center" style="margin-bottom: 10px;">
						<?=$row_cari->CARI?> - <?=$row_cari->CARI_KOD?>
					</div>
				</div>
				<div class="row">
					<table class="table table-sm table-condensed table-hover border-bottom">
				  		<thead class="thead-themed">
					    	<tr class="fw-500">
					          	<td width="5%" align="center" class="text-primary" style="border-bottom: 2px solid black;">#</td>
					          	<td width="10%" align="center" class="text-primary" style="border-bottom: 2px solid black;"><?=dil("Fatura Tarih")?></td>
					          	<td width="10%" align="center" class="text-primary" style="border-bottom: 2px solid black;"><?=dil("Vade Tarih")?></td>
					          	<td width="10%" align="center" class="text-primary" style="border-bottom: 2px solid black;"><?=dil("Hareket")?></td>
					          	<td width="12%" class="text-primary" style="border-bottom: 2px solid black;"><?=dil("Finans Kalemi")?></td>
					          	<td width="15%" class="text-primary" style="border-bottom: 2px solid black;"><?=dil("Fatura No")?></td>
					          	<td width="10%" align="center" class="text-primary" style="border-bottom: 2px solid black;"><?=dil("Plaka")?></td>
					          	<td width="15%" align="right" class="text-primary" style="border-bottom: 2px solid black;"><?=dil("Borç")?></td>
					          	<td width="15%" align="right" class="text-primary" style="border-bottom: 2px solid black;"><?=dil("Alacak")?></td>
					          	<td width="15%" align="right" class="text-primary" style="border-bottom: 2px solid black;"><?=dil("Bakiye")?></td>
					        </tr>
				        </thead>
				        <tbody>
				        <?
				        foreach($rows as $key=>$row) {
				        	if(in_array($row->HAREKET_ID, array(1,4))){
								$TOPLAM_TUTAR += $row->TUTAR;
							} else {
								$TOPLAM_ODENEN += $row->TUTAR;
							}
							$TOPLAM_BAKIYE = $TOPLAM_ODENEN + $TOPLAM_TUTAR;
				        	?>
					        <tr class="border_bottom">
					          	<td align="center" style="border-bottom: 1px solid #EEE6E4;"><?=$row->ID?></td>
					          	<td align="center" style="border-bottom: 1px solid #EEE6E4;"><?=FormatTarih::tarih($row->FATURA_TARIH)?></td>
					          	<td align="center" style="border-bottom: 1px solid #EEE6E4;">
						          	<?if(str_replace('-','',$row->VADE_TARIH) <= str_replace('-','',date('Ymd'))){?>
						          		<i class="text-danger"> <?=FormatTarih::tarih($row->VADE_TARIH)?> </i>
						          	<?} else {?>
						          		<i class="text-success"> <?=FormatTarih::tarih($row->VADE_TARIH)?> </i>
						          	<?}?>
					          	</td>
					          	
					          	<td align="center" style="border-bottom: 1px solid #EEE6E4;"><?=$row->HAREKET?></td>
					          	<td style="border-bottom: 1px solid #EEE6E4;"><?=$row->FINANS_KALEMI?></td>
					          	<td style="border-bottom: 1px solid #EEE6E4;"><?=$row->FATURA_NO?></td>
					          	<td align="center" style="border-bottom: 1px solid #EEE6E4;"><?=$row->PLAKA?></td>
					          	<td align="right" class="text-danger" style="border-bottom: 1px solid #EEE6E4;"><?=FormatSayi::db2tr(in_array($row->HAREKET_ID, array(1,4)) ? $row->TUTAR : 0)?></td>
					          	<td align="right" class="" style="border-bottom: 1px solid #EEE6E4;"><?=FormatSayi::sayi(in_array($row->HAREKET_ID, array(1,4)) ? 0 : $row->TUTAR)?></td>
					          	<td align="right" class="" style="border-bottom: 1px solid #EEE6E4;"><?=FormatSayi::sayi($TOPLAM_BAKIYE)?></td>					          	
					        </tr>
				        <?}?>
				        </tbody>
				        <tfoot class="thead-themed">
				        	<tr>
					          	<td> </td>
					          	<td> </td>
					          	<td> </td>
					          	<td> </td>
					          	<td> </td>	
					          	<td class="hidden-xs-down"> </td>	
					          	<td class="text-right fw-500"> <?=dil("Toplam")?> :</td>
					          	<td align="right" class="text-primary"><?=FormatSayi::sayi($TOPLAM_TUTAR)?></td>
					          	<td align="right" class="text-primary"><?=FormatSayi::sayi($TOPLAM_ODENEN)?></td>
					          	<td align="right" class="text-primary"><?=FormatSayi::sayi($TOPLAM_ODENEN + $TOPLAM_TUTAR)?></td>
					          	<td> </td>
					        </tr>
				        </tfoot>
				  	</table>
				</div>
			</div>
			</body>
	</html>
	
	<?
	$html = ob_get_contents();
	ob_end_clean();
	
	//echo $html; die();
	$mpdf = new mPDF('utf-8-s','A4-L'); 
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
	$mpdf->WriteHTML('<title> '. $row_cari->CARI ."_". date("d.m.Y") .'.pdf </title>',1);
	
	$mpdf->WriteHTML($html,2);
	
	$mpdf->Output($row_cari->CARI ."_". date("d.m.Y") . ".pdf",'I');
	exit;
	
	
?>