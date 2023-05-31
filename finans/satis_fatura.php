<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row 				= $cSubData->getSatisFatura($_REQUEST);
	$rows_chd			= $cSubData->getCariHareketDetay($_REQUEST);
	
	if(is_null($row->ID)){
		$row->FINANS_KALEMI_ID		= $_REQUEST["finans_kalemi_id"];
		$row->CARI_ID				= $_REQUEST["cari_id"];
		$row->ODEME_KANALI_ID		= $_REQUEST["odeme_kanali_id"];
		$row->ODEME_KANALI_DETAY_ID	= $_REQUEST["odeme_kanali_detay_id"];
		$row->PLAKA					= $_REQUEST["plaka"];
		$row->FATURA_NO				= $_REQUEST["fatura_no"];
		$row->FATURA_TARIH			= FormatTarih::nokta2db($_REQUEST["fatura_tarih"]);
		$row->TUTAR					= $_REQUEST["tutar"];
		$row->ACIKLAMA				= $_REQUEST["aciklama"];
	}
	
	if(count($rows_chd) == 0) {
		$row_chd->SIRA = 1;
		$rows_chd[] = $row_chd;
	} 
	
	if($row->ID > 0 AND $_REQUEST["kalem_sayisi"] > 0){
		$row->KALEM_SAYISI	= $_REQUEST["kalem_sayisi"];
	} else if($row->ID <= 0 AND $_REQUEST["kalem_sayisi"] <= 0) {
		$row->KALEM_SAYISI	= 10;
	}
	
	if($_REQUEST["kopyala"] == 1){
		$row->ID 	= NULL;
		$row->KOD 	= NULL;
	}
	
	$filtre = array();
	$sql = "SELECT
				FK.ID,
				FK.FINANS_KALEMI AS AD,
				FK.KDV
			FROM FINANS_KALEMI AS FK
			WHERE GELIR IN(1,3)
            ORDER BY FK.SIRA
            ";
		
	$rows_finans_kalemi = $cdbPDO->rows($sql, $filtre);
	
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/notifications/toastr/toastr.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/plugin/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="mod-bg-1">
    <div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
    	
        <section class="content">
        	<div class="panel">
				<div class="panel-hdr bg-primary-300 text-white">
                    <h2> <i class="fal fa-list mr-3"></i> <?=dil("Cari Hesap - Satış Faturası")?> &nbsp;<span class="badge badge-warning">ID: <?=$row->ID?></span> </h2>
                    <div class="panel-toolbar">
                    	<?if($row->ID > 0){?>
							<a href="/finans/satis_fatura.do?route=finans/satis_faturalar" class="btn btn-outline-primary btn-icon rounded-circle waves-effect waves-themed text-white border-white mr-1"> <i class="fal fa-plus"></i>  </a> 
							<a href="/finans/satis_fatura.do?route=finans/satis_faturalar&id=<?=$row->ID?>&kod=<?=$row->KOD?>&kopyala=1" class="btn btn-outline-primary btn-icon rounded-circle waves-effect waves-themed text-white border-white mr-1"> <i class="fal fa-copy"></i>  </a> 
							<a class="btn <?=($row->RESIM_VAR == 1)?'btn-primary':'btn-outline-primary'?> btn-icon rounded-circle waves-effect waves-themed text-white border-white mr-1" href="javascript:fncPopup('/finans/popup_cari_hareket_resim_yukle.do?route=finans/popup_cari_hareket_resim_yukle&id=<?=$row->ID?>&kod=<?=$row->KOD?>','POPUP_CARI_HAREKET_RESIM_YUKLE',1100,850);"> <i class="fal fa-upload"></i> </a>
							<a href="<?=fncFaturaPopupLink($row)?>" class="btn btn-outline-primary btn-icon rounded-circle waves-effect waves-themed text-white border-white mr-1"> <i class="fal fa-eye"></i>  </a> 
							<?if(strlen($row->EFATURA_UUID) > 1){?>
								<a href="<?=fncEFaturaPopupLink($row)?>" class="btn btn-outline-primary btn-icon rounded-circle waves-effect waves-themed text-white border-white mr-1" title="Efatura PDF"> <i class="fal fa-bullseye"></i> </a>
							<?}?>
						<?}?>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
				        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
				    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                    	
						<form name="formSatis" id="formSatis" class="" enctype="multipart/form-data" method="POST">
						<input type="hidden" name="islem" value="finans_satis_fatura_kaydet">
						<input type="hidden" name="id" value="<?=$row->ID?>">
						<input type="hidden" name="kod" value="<?=$row->KOD?>">
						<input type="hidden" name="form_key" value="<?=fncFormKey()?>">
						<input type="hidden" name="sira" id="sira" value="<?=count($rows_chd)?>">
						<div class="row">
                        	<div class="col-md-12">
								<div class="row">
									<div class="col-md-6 mb-2">   
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Cari")?> <a href="javascript:void(0)" onclick="<?=fncCariPopupLink(array())?>" class="ml-3"><i class="far fa-plus-hexagon"></i></a> <a href="javascript:void(0)" onclick="fncCariDoldur()"><i class="far fa-repeat-alt"></i></a> </label>
										  	<select name="cari_id" id="cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->Cariler(array("alim_satis"=>1))->setSecilen($row->CARI_ID)->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Sipariş Durumu")?> </label>
									      	<select name="fatura_durum_id" id="fatura_durum_id" class="form-control select2 select2-hidden-accessible" style="width: 100%" >
										      	<?=$cCombo->FaturaDurumlar()->setSecilen($row->FATURA_DURUM_ID)->getSelect("ID","AD")?>
										    </select>
									    </div>
									</div>
									<div class="col-md-2 mb-2 text-center">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Fatura Kes")?> </label>
									      	<select name="fatura_kes" id="fatura_kes" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->FaturaKes()->setSecilen($row->FATURA_KES)->getSelect("ID","AD")?>
										    </select>
									    </div>
									</div>
									<div class="col-md-2 mb-2 text-center">      
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Finans Kalemi")?> </label>
									      	<select name="finans_kalemi_id" id="finans_kalemi_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<option value="-1"><?=dil("-- Seçiniz --")?></option>
										      	<?foreach($rows_finans_kalemi as $key => $row_finans_kalemi){?>
													<option value="<?=$row_finans_kalemi->ID?>" data-kdv="<?=$row_finans_kalemi->KDV?>" <?=($row->FINANS_KALEMI_ID==$row_finans_kalemi->ID)?'selected':''?>><?=$row_finans_kalemi->AD?></option>	
												<?}?>
										    </select>
									    </div>
									</div>
									<div class="w-100"></div>
									<div class="col-sm-3 col-xs-3 mb-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Fatura No")?> </label>
									      	<div class="input-group">
									      		<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" value="<?=$row->FATURA_NO?>" maxlength="16">
									      		<div class="input-group-append"><button class="btn btn-success waves-effect waves-themed" type="button" title="Eksper Bul" onclick="fncYeniFaturaNoBul(this)"><i class="fal fa-search"></i></button></div>
											</div>
									    </div>
									</div>
									<div class="col-sm-3 col-xs-3 mb-2">
										<div class="form-group">
										    <label class="form-label"><?=dil("Fatura Tarih")?></label>
										    <div class="input-group date">
										    	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
										      	<input type="text" class="form-control pull-right datepicker" name="fatura_tarih" id="fatura_tarih" value="<?=FormatTarih::tarih($row->FATURA_TARIH)?>" readonly>
										    </div>
										</div>
									</div>
									<div class="col-sm-2 col-xs-2 mb-2 text-center">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("KDV Tutar")?></label>
									      	<div class="input-group date">
										      	<input type="text" class="form-control" placeholder="" name="kdv_tutar" id="kdv_tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->KDV_TUTAR)?>" maxlength="10" readonly>
										      	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
										    </div>
									    </div>
									</div>
									<div class="col-sm-2 col-xs-2 mb-2 text-center">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Fatura Tutar")?></label>
									      	<div class="input-group date">
										      	<input type="text" class="form-control" placeholder="" name="tutar" id="tutar" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row->TUTAR)?>" maxlength="10" readonly>
										      	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm"><i class="far fa-lira-sign"></i></span></div>
										    </div>
									    </div>
									</div>
									<div class="col-sm-6 col-xs-6 mb-2">
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Açıklama")?> </label>
									      	<textarea name="aciklama" id="aciklama" rows="1" cols="80" class="form-control" maxlength="500"><?=$row->ACIKLAMA?></textarea>
									    </div>
									</div>
								</div>
							</div>
							
							<div class="col-md-12">
								<div class="table-responsive">
								<table class="table table-sm table-condensed table-hover" id="parcalar">
									<thead class="thead-themed fw-500">
								    	<tr>
								          	<td align="center" style="width: 3%;">#</td>
								          	<td align="center" style="width: 11%;"><?=dil("Parça Kodu")?></td>
								          	<td align="center" style="width: 11%;"><?=dil("Oem Kodu")?></td>
								          	<td align="center" style="width: 29%;"><?=dil("Parça Adı")?></td>								          	
								          	<td align="center" style="width: 6%;"><?=dil("Adet")?></td>
								          	<td align="center" style="width: 8%;"><?=dil("Alış")?></td>
								          	<td align="center" style="width: 8%;" onclick="fncFiyat()"><?=dil("Fiyat")?></td>
								          	<td align="center" style="width: 7%;"><?=dil("İskonto")?></td>
								          	<td align="center" style="width: 7%;" onclick="fncKdv()"><?=dil("Kdv")?></td>
								          	<td align="center" style="width: 10%;"><?=dil("Tutar")?></td>
								          	<td></td>
								        </tr>
								    </thead>
								    <tbody>
								        <?
								        foreach($rows_chd as $key => $row_chd){
										    $row_toplam->ADET			+= $row_chd->ADET;
										    $row_toplam->FIYAT			+= $row_chd->FIYAT * $row_chd->ADET;
										    $row_toplam->ISKONTOLU		+= $row_chd->ISKONTOLU * $row_chd->ADET;
										    $row_toplam->TUTAR			+= $row_chd->TUTAR;
								        	?>
									        <tr>
									          	<td align="center" class="bg-gray-100"><?=($row_chd->SIRA)?></td>
									          	<td align="center">
									          		<div class="input-group">
									          			<input type="text" class="form-control" placeholder="" name="yp_parca_kodu[<?=$row_chd->SIRA?>]" id="yp_parca_kodu<?=$row_chd->SIRA?>" maxlength="25" value="<?=$row_chd->PARCA_KODU?>" onchange="this.value=this.value.turkishToUpper();">
									          			<div class="input-group-append hidden-md" data-sira="<?=$row_chd->SIRA?>" onclick="fncParcaBul(this)"><span class="input-group-text fs-sm px-1"><i class="fal fa-plus"></i></span></div>
									          		</div>
									          	</td>
									          	<td align="center">
									          		<input type="text" class="form-control" placeholder="" name="yp_oem_kodu[<?=$row_chd->SIRA?>]" id="yp_oem_kodu<?=$row_chd->SIRA?>" maxlength="25" value="<?=$row_chd->OEM_KODU?>" onchange="this.value=this.value.turkishToUpper();">
									          	</td>
									          	<td align="center">
											    	<input type="text" class="form-control" placeholder="" name="yp_parca_adi[<?=$row_chd->SIRA?>]" id="yp_parca_adi<?=$row_chd->SIRA?>" maxlength="255" value="<?=$row_chd->PARCA_ADI?>" onchange="this.value=this.value.turkishToUpper();">
											    </td>
									          	<td align="center">
													<input type="text" class="form-control" placeholder="" name="yp_adet[<?=$row_chd->SIRA?>]" id="yp_adet<?=$row_chd->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_chd->ADET,2)?>" onchange="fncHesap(this)">
											    </td>
											    <td align="center">
												    <input type="text" class="form-control" placeholder="" name="yp_alis[<?=$row_chd->SIRA?>]" id="yp_alis<?=$row_chd->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_chd->ALIS,2)?>" onchange="fncHesap(this)">
									          	</td>
									          	<td align="center">
												    <input type="text" class="form-control" placeholder="" name="yp_fiyat[<?=$row_chd->SIRA?>]" id="yp_fiyat<?=$row_chd->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_chd->FIYAT,2)?>" onchange="fncHesap(this)" onkeyup="fncKdvsiz(event, this)">
									          	</td>
									          	<td align="center">
												    <div class="input-group">
													  	<input type="text" class="form-control" placeholder="" name="yp_iskonto[<?=$row_chd->SIRA?>]" id="yp_iskonto<?=$row_chd->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 2" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_chd->ISKONTO,2)?>" onchange="fncHesap(this)" onkeyup="fncKdvsiz(event, this)">
													  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-percent"></i></span></div>
													</div>
									          	</td>
									          	<td align="center">
									          		<select name="yp_kdv[<?=$row_chd->SIRA?>]" id="yp_kdv<?=$row_chd->SIRA?>" class="form-control" style="width: 100%" onchange="fncHesap(this)">
													   	<?=$cCombo->Kdv()->setSecilen($row_chd->KDV)->getSelect("ID","AD")?>
													</select>	
									          	</td>
									          	<td align="center">
												    <div class="input-group">
													  	<input type="text" class="form-control" placeholder="" name="yp_tutar[<?=$row_chd->SIRA?>]" id="yp_tutar<?=$row_chd->SIRA?>" data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'radixPoint': ',', 'digits': 4" data-mask style="text-align: right;" value="<?=FormatSayi::sayi($row_chd->TUTAR,2)?>" readonly>
													  	<div class="input-group-append hidden-md"><span class="input-group-text fs-sm px-1"><i class="fal fa-lira-sign"></i></span></div>
													</div>
									          	</td>
									          	<td nowrap>
													<button type="button" class="btn btn-outline-danger btn-icon rounded-circle waves-effect waves-themed" id="btnSatirEkle" onclick="fncSatirSil(this)" title="Satır Sil" data-sira="<?=$row_chd->SIRA?>"><i class="fal fa-minus p-2"></i></button>
												</td>
									        </tr>
								        <?}?>
								    </tbody>
								    <tfoot class="bg-gray-300 fw-500">
								    	<tr>
								          	<td align="center"></td>
								          	<td align="center"></td>
								          	<td align="right"></td>
								          	<td align="right"></td>								          	
								          	<td align="right"></td>
								          	<td align="right">
								          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam->ADET,2)?> </span>
								          	</td>
								          	<td align="right">
								          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam->FIYAT,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
								          	</td>
								          	<td align="right">
								          		<span class="mr-2"><?=FormatSayi::sayi(FormatSayi::iskontoOran($row_toplam->FIYAT2, $row_toplam->ISKONTOLU),2)?> </span> <i class="fal fa-percent mr-1"></i>
								          	</td>
								          	<td align="right"></td>
								          	<td align="right">
								          		<span class="mr-2"><?=FormatSayi::sayi($row_toplam->TUTAR,2)?> </span> <i class="fal fa-lira-sign mr-1"></i>
								          	</td>
								          	<td class="py-0"> 
										    	<button type="button" class="btn btn-outline-primary btn-icon rounded-circle waves-effect waves-themed" id="btnSatirEkle" onclick="fncSatirEkle(this)" title="Satır Ekle"><i class="fal fa-plus p-2"></i></button>
										    </td>
								        </tr>
								    </tfoot>
								</table>
								</div>
								<div class="row mt-3 text-right">
									<div class="col-md-3 offset-md-9 pr-6">
										<table class="table table-condensed table-hover table-sm">
											<tr>
												<td class="fw-500"><?=dil("Toplam Fiyat")?> </td>
												<td><span id="toplam_fiyat"><?=FormatSayi::sayi($row_toplam->FIYAT)?></span> <i class="fal fa-lira-sign"></i> </td>
											</tr>
											<tr>
												<td class="fw-500"> <?=dil("Toplam İskonto")?> </td>
												<td><span id="toplam_isk"><?=FormatSayi::sayi(($row_toplam->FIYAT - $row_toplam->ISKONTOLU))?></span> <i class="fal fa-lira-sign"></i> </td>
											</tr>
											<tr>
												<td class="fw-500"><?=dil("Toplam Kdv")?> </td>
												<td><span id="toplam_kdv"><?=FormatSayi::sayi(($row_toplam->TUTAR - $row_toplam->ISKONTOLU))?></span> <i class="fal fa-lira-sign"></i> </td>
											</tr>
											<tr>
												<td class="fw-500"><?=dil("Toplam Tutar")?> </td>
												<td><span id="toplam_tutar"><?=FormatSayi::sayi($row_toplam->TUTAR)?></span> <i class="fal fa-lira-sign"></i> </td>
											</tr>
										</table>
									</div>
								</div>		
							</div>	
							<div class="col-md-12 col-sm-12 col-xs-12 text-center mt-3">								
							    <button type="button" class="btn btn-success btn-ozel" style="width: 120px" onclick="fncKaydet()"><?=dil("Kaydet")?></button>
							    <?if($row->ID>0){?>
								    <?if(in_array($_SESSION['yetki_id'],array(1))){?>								
										<button type="button" class="btn btn-danger waves-effect waves-themed float-right mr-1" data-toggle="modal" data-target="#modalEFaturaDuzenle"> <i class="fal fa-angle-double-right"></i> <?=dil("EFatura Bağla")?></button>
									<?}?>
							    	<button type="button" class="btn btn-success waves-effect waves-themed float-right mr-1" onclick="fncEFaturaEntegrasyon(this)"> <i class="fal fa-angle-double-right"></i> <?=dil("EFatura Entegrasyonu")?></button>
							    <?}?>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
			
		</section>
		
    </main>    
    </div>
    </div>
    
    <div class="modal fade" id="modalEFaturaDuzenle" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-500">
                    <h4 class="modal-title"> <?=dil("EFatura Bilgileri Düzenle")?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="formEFaturaDuzenle">
	          			<input type="hidden" name="islem" id="islem" value="efatura_finans_satis_bagla">
	          			<input type="hidden" name="id" id="id" value="<?=$row->ID?>">
	          			<input type="hidden" name="kod" id="kod" value="<?=$row->KOD?>">
	          			<div class="row">
			          		<div class="col-md-12 mb-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Efatura UUID")?> </label>
								  	<input type="text" class="form-control" placeholder="" name="efatura_uuid" id="efatura_uuid" maxlength="100" value="<?=$row->EFATURA_UUID?>">
								</div>
							</div>
							<div class="col-md-12 mb-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Fatura No")?> </label>
								  	<input type="text" class="form-control" placeholder="" name="fatura_no" id="fatura_no" maxlength="100" value="<?=$row->FATURA_NO?>">
								</div>
							</div>
							<div class="col-md-6 mb-2">
								<div class="form-group">
								  	<label class="form-label"><?=dil("Fatura Tarih")?></label> 
								   	<div class="input-group date">
									  	<div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
									  	<input type="text" class="form-control datepicker datepicker-inline" name="fatura_tarih" value="<?=FormatTarih::tarih($row->FATURA_TARIH)?>" readonly>
									</div>
								</div>
							</div>
						</div>
					</form>
                </div>
                <div class="modal-footer">
                	<button type="button" class="btn btn-secondary waves-effect waves-themed" data-dismiss="modal"><?=dil("İptal")?></button>
	            	<button type="button" class="btn btn-primary waves-effect waves-themed" onclick="fncEFaturaKaydet(this)"><?=dil("Kaydet")?></button>
                </div>
            </div>
        </div>
    </div>
           
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../smartadmin/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
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
		
		function fncKaydet(){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formSatis').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						location.href = jd.URL;
					}
				}
			});	
		}
		
		function fncOdemeKanali(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem" : "odeme_kanali_detay_doldur", 'odeme_kanali_id' : $(obj).val() },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$("#odeme_kanali_detay_id").html(jd.HTML);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncParcaBul(obj){
			var parca_kodu = $(obj).parent().children("input").val();
			fncPopup('/finans/popup_stok.do?route=finans/popup_stok&parca_kodu='+parca_kodu+"&sira="+$(obj).data("sira"),'POPUP_STOK',1100,850);
		}
		
		function fncCariDoldur(obj){
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "cari_doldur" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$("#cari_id").html(jd.HTML);
					}
				}
			});
		}
		
		function fncYeniFaturaNoBul(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "yeni_fatura_no_bul" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						$("#fatura_no").val(jd.FATURA_NO);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
		function fncKdv(){
			$(".yp_kdv").attr("checked", !$(".yp_kdv").attr("checked"));
		}
		
		function fncKalemSayisi(obj){
			//$(obj).attr("disabled", "disabled");
			$("#formSatis").submit();
		}
		
		function fncSayiDb4(sayi){
			yeni = sayi.replace('.','').replace(',','.');
			yeni = parseFloat(yeni).toFixed(4);
			return yeni;
		}
		
		function fncSayiTr4(sayi){
			yeni = parseFloat(sayi).toFixed(4);
			yeni = yeni.replace(".",",");
			return yeni;
		}
		
		function fncSayiDb(sayi){
			yeni = sayi.replace('.','').replace(',','.');
			yeni = parseFloat(yeni).toFixed(2);
			return yeni;
		}
		
		function fncSayiTr(sayi){
			yeni = parseFloat(sayi).toFixed(2);
			yeni = yeni.replace(".",",");
			return yeni;
		}
		
		function fncEFaturaEntegrasyon(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: { "islem": "satis_efatura_entegrasyon", 'id': "<?=$row->ID?>", 'kod': "<?=$row->KOD?>" },
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						bootbox.alert(jd.ACIKLAMA, function() {});
					}else{
						bootbox.alert(jd.ACIKLAMA, function() {
							location.reload(true);
						});
					}
					$(obj).removeAttr("disabled");
				}
			});
		};
		
		function fncHesap(obj){
			var toplam_tutar = 0.00;
			var toplam_adet = 0.0;
			var toplam_fiyat = 0.0; 
			var toplam_isk = 0.0;
			var toplam_kdv = 0.0;
			//var kdv_oran = $("#finans_kalemi_id option:selected").data("kdv") / 100;
			
			$('#parcalar tbody tr').each(function() {
				var adet = fncSayiDb($(this).find('td:eq(3) input').val());
				var fiyat = fncSayiDb($(this).find('td:eq(4) input').val());
				var isk = (100 - fncSayiDb($(this).find('td:eq(5) input').val())) / 100;
				var kdv_oran = fncSayiDb($(this).find('td:eq(6) select').val()) / 100
				var kdv = kdv_oran > 0 ? (1+kdv_oran) : 1;
				
				//console.log(isk);
				isk = ($(this).find('td:eq(5) input').val() == "") ? 1 : isk;
				var tutar = adet * fiyat * isk * kdv;
				
				if(adet > 0 && fiyat > 0) { toplam_fiyat += fiyat * adet; }
				if(adet > 0 && fiyat > 0 && isk > 0) { toplam_isk += fiyat * adet * (1.0 - isk); }
				if(adet > 0 && fiyat > 0 && kdv > 1) { toplam_kdv += fiyat * adet * isk * kdv_oran; }
				if(adet > 0 && fiyat > 0) { toplam_tutar += tutar; }
				if(adet > 0) { toplam_adet = toplam_adet + adet;}
				
				$(this).find('td:eq(7) input').val(fncSayiTr(tutar));
				
			});
			$("#toplam_adet").text(toplam_adet);
			$("#toplam_fiyat").text(fncSayiTr(toplam_fiyat));
			$("#toplam_isk").text(fncSayiTr(toplam_isk));
			$("#toplam_kdv").text(fncSayiTr(toplam_kdv));
			$("#toplam_tutar").text(fncSayiTr(toplam_tutar));
			
			if($(obj).attr("id") == "yp_kdv1") $("select[id^='yp_kdv'").val( $("#yp_kdv1").val() ); 
		}
		
		function fncSatirEkle(obj) {
            var sira = parseInt($("#sira").val()) + 1;
            var tr = $('#parcalar tbody tr:first').clone();
            $("#parcalar tbody").append(tr);
            $('#parcalar tbody tr:last').find("#yp_parca_kodu1").attr("name", "yp_parca_kodu[" + sira + "]").attr("id", "yp_parca_kodu" + sira).val("");
            $('#parcalar tbody tr:last').find("button").attr("data-sira", sira);
            $('#parcalar tbody tr:last').find("#yp_parca_adi1").attr("name", "yp_parca_adi[" + sira + "]").attr("id", "yp_parca_adi" + sira).val("");
            $('#parcalar tbody tr:last').find("#yp_adet1").attr("name", "yp_adet[" + sira + "]").attr("id", "yp_adet" + sira).val(1);
            $('#parcalar tbody tr:last').find("#yp_fiyat1").attr("name", "yp_fiyat[" + sira + "]").attr("id", "yp_fiyat" + sira).val(0);
            $('#parcalar tbody tr:last').find("#yp_iskonto1").attr("name", "yp_iskonto[" + sira + "]").attr("id", "yp_iskonto" + sira).val(0);
            $('#parcalar tbody tr:last').find("#yp_kdv1").attr("name", "yp_kdv[" + sira + "]").attr("id", "yp_kdv" + sira).val(0);
            $('#parcalar tbody tr:last').find("label").attr("for", "yp_kdv" + sira);
            $('#parcalar tbody tr:last').find("#yp_tutar1").attr("name", "yp_tutar[" + sira + "]").attr("id", "yp_tutar" + sira).val(0);
            $("#sira").val(sira);
            fncSirala();
            $("[data-mask]").inputmask();	
        }
        
		function fncSirala() {
            var sira = 1;
            $('#parcalar tbody tr').each(function () {
                $(this).find('td:eq(0)').text(sira++);
            });
        }
        
        function fncSatirSil(obj) {
            if ($('#parcalar tbody tr').length == 1) {
                toastr.warning("Birinci satır silinemez!");
                return false;
            }
            $(obj).parent().parent().remove();
            fncSirala();
        }
		
		function fncKdvsiz(e, obj){
			if (e.keyCode == 32) {
		        var tutar = fncSayiDb($(obj).val());
				tutar = tutar / 1.18;
				$(obj).val(fncSayiTr(tutar));
		    }
		}
		
		function fncFiyat(){
			$('#parcalar tbody tr').each(function() {
		    	var fiyat = fncSayiDb($(this).find('td:eq(4) input').val());
		    	fiyat = fiyat / 1.18;
		    	$(this).find('td:eq(4) input').val(fncSayiTr(fiyat));
		    });
		}
		
		function fncEFaturaKaydet(obj){
			$(obj).attr("disabled", "disabled");
			$.ajax({
				url: '/class/db_kayit.do?',
				type: "POST",
				data: $('#formEFaturaDuzenle').serialize(),
				dataType: 'json',
				async: true,
				success: function(jd) {
					if(jd.HATA){
						toastr.warning(jd.ACIKLAMA);
					}else{
						toastr.success(jd.ACIKLAMA);
						location.reload(true);
					}
					$(obj).removeAttr("disabled");
				}
			});
		}
		
	</script>
    
</body>
</html>
