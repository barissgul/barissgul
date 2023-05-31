<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	if($_REQUEST['filtre'] == 1){
		$rows_aylik_talep				= $cSubData->getAylikTalepSayisi($_REQUEST);
		$rows_aylik_talep_teslim		= $cSubData->getAylikTalepTeslimSayisi($_REQUEST);
		$row->TALEP_SAYISI 				= $cSubData->getTalepSayisi($_REQUEST);
		$row->TESLIM_EDILDI 			= $cSubData->getTeslimEdildiSayisi($_REQUEST);
		/*
	 	$row->IHALE_SAYISI 				= $cSubData->getIhaleSayisi($_REQUEST);
		
		$row->TEKLIF_SAYISI				= $cSubData->getIhaleCevapSayisi($_REQUEST);
		$row->RED_SAYISI				= $cSubData->getRedSayisi($_REQUEST);
		$row->ONARIM_SAYISI				= $cSubData->getOnarimSayisi($_REQUEST);
		$row->DIGER_ALICI_FIRMA_SAYISI	= $cSubData->getDigerAliciFirmaSayisi($_REQUEST);
		$rows->KAZANANMA_ADET_ILKON		= $cSubData->getKazanmaAdetIlkOn($_REQUEST);
		$rows->KAZANANMA_TUTAR_ILKON	= $cSubData->getKazanmaTutarIlkOn($_REQUEST);
		$rows->KAZANMA_IL_ILKON			= $cSubData->getKazanmaIlIlkOn($_REQUEST);
		$rows->KAYBETME_IL_ILKON		= $cSubData->getKaybetmeIlIlkOn($_REQUEST);
		$rows_aylik_talep_teslim				= $cSubData->getAylikKazanmaSayisi($_REQUEST);
		*/
		
		$PARAMETRE['talep_no'] 					= $_REQUEST['talep_no'];
		$PARAMETRE['marka_id'] 					= $_REQUEST['marka_id'];
		$PARAMETRE['cari_id'] 					= $_REQUEST['cari_id'];
		$PARAMETRE['sorumlu_id'] 				= $_REQUEST['sorumlu_id'];
		$PARAMETRE['arac_gelis_tarih_var']		= $_REQUEST['arac_gelis_tarih_var'];
		$PARAMETRE['arac_gelis_tarih'] 			= $_REQUEST['arac_gelis_tarih'];
		$PARAMETRE['teslim_edildi_tarih_var'] 	= $_REQUEST['teslim_edildi_tarih_var'];
		$PARAMETRE['teslim_edildi_tarih'] 		= $_REQUEST['teslim_edildi_tarih'];
		$URL = http_build_query($PARAMETRE);
	}
	
	foreach($rows_aylik_talep as $key => $row_aylik_talep){
		$arr_aylik_ihale[$key]->y	= $row_aylik_talep->YIL ." ". Tarih::ay($row_aylik_talep->AY); //str_pad($row_aylik_talep->AY,2,"0",STR_PAD_LEFT)
		$arr_aylik_ihale[$key]->a	= $row_aylik_talep->SAY;
		$arr_aylik_ihale[$key]->b	= $rows_aylik_talep_teslim[$key]->SAY;
		
		$arr_aylik_chart->y[]		= $row_aylik_talep->YIL ." ". Tarih::ay($row_aylik_talep->AY);
		$arr_aylik_chart->a[]		= $row_aylik_talep->SAY;
		$arr_aylik_chart->b[]		= $rows_aylik_talep_teslim[$key]->SAY;
	}
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
    <link rel="stylesheet" media="screen, print" href="../smartadmin/css/statistics/chartjs/chartjs.css">
    <link rel="stylesheet" href="../smartadmin/css/datagrid/datatables/datatables.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/select2/select2.bundle.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="../smartadmin/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="../smartadmin/plugin/morris/morris.css">
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
									<div class="col-lg-2 mb-2">        
									    <div class="form-group">
									      	<label class="form-label"> <?=dil("Talep No")?> </label>
									      	<input type="text" class="form-control" placeholder="" name="talep_no" id="talep_no" value="<?=$_REQUEST['talep_no']?>" maxlength="45">
									    </div>
									</div>
									<div class="col-md-2 mb-2">		            
									    <div class="form-group">
										  	<label class="form-label"> <?=dil("Marka")?> </label>
										  	<select name="marka_id" id="marka_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
										      	<?=$cCombo->Markalar2()->setSecilen($_REQUEST['marka_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
										</div>
									</div>
									<div class="col-md-4 mb-2">        
								        <div class="form-group">
								          	<label class="form-label"> <?=dil("Cari")?>  </label>
								          	<select name="cari_id" id="cari_id" class="form-control select2 select2-hidden-accessible" style="width: 100%">
										      	<?=$cCombo->Cariler()->setSecilen($_REQUEST['cari_id'])->setTumu()->getSelect("ID","AD")?>
										    </select>
								        </div>
								    </div>
								    <div class="col-lg-2 mb-2">        
								        <div class="form-group">
									      	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="arac_gelis_tarih_var" name="arac_gelis_tarih_var" <?=($_REQUEST['arac_gelis_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="arac_gelis_tarih_var"><?=dil("Araç Geliş Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									          	<div class="input-group-append"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="arac_gelis_tarih" name="arac_gelis_tarih" value="<?=$_REQUEST['arac_gelis_tarih']?>">
									        </div>
									    </div>
								    </div>
								    <div class="col-lg-2 mb-2">        
								        <div class="form-group">
									      	<label class="form-label">
									      		<div class="custom-control custom-switch custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="teslim_edildi_tarih_var" name="teslim_edildi_tarih_var" <?=($_REQUEST['teslim_edildi_tarih_var'])?' checked':''?>>
                                                    <label class="custom-control-label" for="teslim_edildi_tarih_var"><?=dil("Teslim Edildi Tarihi")?></label>
                                                </div>
                                            </label>
									      	<div class="input-group">
									          	<div class="input-group-append"><span class="input-group-text fs-sm"><i class="far fa-calendar-alt"></i></span></div>
									          	<input type="text" class="form-control pull-right" id="teslim_edildi_tarih" name="teslim_edildi_tarih" value="<?=$_REQUEST['teslim_edildi_tarih']?>">
									        </div>
									    </div>
								    </div>
									<div class="col-md-2 mb-2">
										<div class="form-group">
										  	<label class="form-label">&nbsp;</label><br>
									  		<button type="button" class="btn btn-warning" onclick="fncFiltrele()"><?=dil("Filtrele")?></button>
									  	</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					</div>
			    </div>
		    	
		    	<div class="col-md-6">
			    	<div class="panel">
		                <div class="panel-hdr bg-primary-300 text-white">
		                    <h2> <i class="fal fa-battery-empty mr-3"></i> <b><?=dil("Talep Tarihine göre talep sayısı ")?></b> </h2>
		                    <div class="panel-toolbar">
		                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
							    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
							    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
		                    </div>
		                </div>
		                <div class="panel-container show">
		                    <div class="panel-content">
					            <div class="row">
					            	<?
					            	foreach($rows_aylik_talep as $key => $row_aylik_talep){
					            		$ay_sonu = date('d', strtotime('last day of this month', strtotime( "01-" . str_pad($row_aylik_talep_teslim->AY,2,"0",STR_PAD_LEFT) ."-". $row_aylik_talep_teslim->YIL )));
					            		$row_aylik_talep->TARIH2 = "01-" . str_pad($row_aylik_talep->AY,2,"0",STR_PAD_LEFT) ."-". $row_aylik_talep->YIL ." , ". "$ay_sonu-" . str_pad($row_aylik_talep->AY,2,"0",STR_PAD_LEFT) ."-". $row_aylik_talep->YIL;
					            		?>
						                <div class="col-lg-2 col-md-2 text-center">
						                  	<input type="text" class="knob" data-thickness="0.25" data-angleArc="270" data-angleOffset="-90" value="<?=$row_aylik_talep->SAY?>" data-width="80" data-height="90" data-max="500" data-fgColor="#00c0ef">
						                  	<div class="knob-label"><b> <a href="/rapor/talep_genis.do?route=rapor/talep_genis&filtre=1&arac_gelis_tarih_var=1&arac_gelis_tarih=<?=$row_aylik_talep->TARIH2?>"> <?=$row_aylik_talep->YIL?> <?=Tarih::ay($row_aylik_talep->AY)?> </a> </b></div>
						                </div>
					                <?}?>
					            </div>
							</div>
						</div>
			    	</div>
			    	<div class="panel">
		                <div class="panel-hdr bg-primary-300 text-white">
		                    <h2> <i class="fal fa-battery-full mr-3"></i> <b><?=dil("Teslim Tarihine göre talep sayısı")?></b> </h2>
		                    <div class="panel-toolbar">
		                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
							    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
							    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
		                    </div>
		                </div>
		                <div class="panel-container show">
		                    <div class="panel-content">
					            <div class="row">
					            	<?
					            	foreach($rows_aylik_talep_teslim as $key => $row_aylik_talep_teslim){
					            		$ay_sonu = date('d', strtotime('last day of this month', strtotime( "01-" . str_pad($row_aylik_talep_teslim->AY,2,"0",STR_PAD_LEFT) ."-". $row_aylik_talep_teslim->YIL )));
					            		$row_aylik_talep_teslim->TARIH2 = "01-" . str_pad($row_aylik_talep_teslim->AY,2,"0",STR_PAD_LEFT) ."-". $row_aylik_talep_teslim->YIL ." , ". "$ay_sonu-" . str_pad($row_aylik_talep_teslim->AY,2,"0",STR_PAD_LEFT) ."-". $row_aylik_talep_teslim->YIL;
					            		?>
						                <div class="col-lg-2 col-md-2 text-center">
						                  	<input type="text" class="knob" data-thickness="0.25" data-angleArc="270" data-angleOffset="-90" value="<?=$row_aylik_talep_teslim->SAY?>" data-width="80" data-height="90" data-max="500" data-fgColor="#39cccc">
						                  	<div class="knob-label"><b> <a href="/rapor/talep_genis.do?route=rapor/talep_genis&filtre=1&teslim_tarih_var=1&teslim_tarih=<?=$row_aylik_talep_teslim->TARIH2?>"> <?=$row_aylik_talep_teslim->YIL?> <?=Tarih::ay($row_aylik_talep_teslim->AY)?> </a> </b></div>
						                </div>
					                <?}?>
					            </div>
							</div>
						</div>
			    	</div>
		    	</div>
		    	
		    	<div class="col-md-6">
		    		<div class="panel">
		                <div class="panel-hdr bg-primary-300 text-white">
		                    <h2> <i class="fal fa-list mr-3"></i> <b> <?=dil("Teslim Edildi - Araç Serviste Bar")?> </b> </h2>
		                    <div class="panel-toolbar">
		                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
							    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
							    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
		                    </div>
		                </div>
		                <div class="panel-container show">
		                    <div class="panel-content">
			              		<div id="barChart">
                                    <canvas style="width:100%; height:300px;"></canvas>
                                </div>
			              	</div>
			            </div>
			        </div>
		    	</div>
		    	
	    		<div class="col-md-12">
		    		<div class="panel">
		                <div class="panel-container show">
		                    <div class="panel-content">
					            <div class="row">
					            	<div class="col-md-4 col-sm-4 col-xs-12 text-center">
					            		<div class="knob-label"> Max.5000 </div>
					                  	<input type="text" class="knob" value="<?=$row->TALEP_SAYISI?>" data-thickness="0.25" data-width="150" data-height="180" data-fgColor="#932ab6" data-max="5000" data-readonly="true">
					                  	<div class="knob-label"> 
					                  		<h3> <?if(in_array($_SESSION['yetki_id'], array(1,2,3))){?> <a href="/rapor/talep_genis.do?route=rapor/talep_genis&filtre=1&<?=$URL?>" style="color: #932ab6;"> <?}?> <?=dil("Talep Sayısı")?> </a> </h3>
					                  	</div>
					                </div>
					                <div class="col-md-4 col-sm-4 col-xs-12 text-center">
					                	<div class="knob-label"> Max.5000 </div>
					                  	<input type="text" class="knob" value="<?=$row->TESLIM_EDILDI?>" data-thickness="0.25" data-width="150" data-height="180" data-fgColor="#39CCCC" data-max="5000" data-readonly="true">
					                  	<div class="knob-label"> 
					                  		<h3> <a href="/rapor/talep_genis.do?route=rapor/talep_genis&filtre=1&<?=$URL?>" style="color: #39CCCC;"> <?=dil("Teslim Edildi")?> </a> </h3>
					                  	</div> 
					                </div>
					                <div class="col-md-4 col-sm-4 col-xs-12 text-center">
					                	<div class="knob-label"> Max.5000 </div>
					                  	<input type="text" class="knob" value="<?=($row->TALEP_SAYISI - $row->TESLIM_EDILDI)?>" data-thickness="0.25" data-width="150" data-height="180" data-fgColor="#306fd6" data-max="5000" data-readonly="true">
					                  	<div class="knob-label"> 
					                  		<h3> <a href="/rapor/talep_genis.do?route=rapor/talep_genis&filtre=1&<?=$URL?>" style="color: #306fd6;"> <?=dil("Servisteki Araç")?> </a> </h3>
					                  	</div>
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
    <script src="../smartadmin/js/statistics/chartjs/chartjs.bundle.js"></script>
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
	<script src="../smartadmin/plugin/countdown/jquery.countdown.min.js"></script>
	<script src="../smartadmin/plugin/knob/jquery.knob.js"></script>
    <script src="../smartadmin/plugin/1.js"></script>
    <script>
		
		$(".knob").knob({
	      	draw: function () {
	        	// "tron" case
		        if (this.$.data('skin') == 'tron') {
		          	var a = this.angle(this.cv)  // Angle
			              , sa = this.startAngle          // Previous start angle
			              , sat = this.startAngle         // Start angle
			              , ea                            // Previous end angle
			              , eat = sat + a                 // End angle
			              , r = true;
			              
		          	this.g.lineWidth = this.lineWidth;
		          
		          	this.o.cursor
		          	&& (sat = eat - 0.3)
		          	&& (eat = eat + 0.3);
		          	
		          	if (this.o.displayPrevious) {
			            ea = this.startAngle + this.angle(this.value);
			            this.o.cursor
			            && (sa = ea - 0.3)
			            && (ea = ea + 0.3);
			            this.g.beginPath();
			            this.g.strokeStyle = this.previousColor;
			            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
			            this.g.stroke();
		          	}
		          	
		          	this.g.beginPath();
		         	this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
		         	this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
		          	this.g.stroke();
		          	
		          	this.g.lineWidth = 2;
		          	this.g.beginPath();
		          	this.g.strokeStyle = this.o.fgColor;
		          	this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
		          	this.g.stroke();
		          
		          	return false;
		        }
	      	}
	    });
	    
	  	$("[data-mask]").inputmask();
		
		
		$('#tarih, #arac_gelis_tarih, #teslim_edildi_tarih').daterangepicker({
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
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
		var barChart = function()
        {
            var barChartData = {
                labels: <?=json_encode($arr_aylik_chart->y)?>,
                datasets: [
                {
                    label: "Teslim Edildi",
                    backgroundColor: myapp_get_color.success_300,
                    borderColor: myapp_get_color.success_500,
                    borderWidth: 1,
                    data: <?=json_encode($arr_aylik_chart->a)?>
                },
                {
                    label: "Araç Serviste",
                    backgroundColor: myapp_get_color.primary_300,
                    borderColor: myapp_get_color.primary_500,
                    borderWidth: 1,
                    data: <?=json_encode($arr_aylik_chart->b)?>
                }]

            };
            var config = {
                type: 'bar',
                data: barChartData,
                options:
                {
                    responsive: true,
                    legend:
                    {
                        position: 'top',
                    },
                    title:
                    {
                        display: false,
                        text: 'Bar Chart'
                    },
                    scales:
                    {
                        xAxes: [
                        {
                            display: true,
                            scaleLabel:
                            {
                                display: false,
                                labelString: '6 months forecast'
                            },
                            gridLines:
                            {
                                display: true,
                                color: "#f2f2f2"
                            },
                            ticks:
                            {
                                beginAtZero: true,
                                fontSize: 11
                            }
                        }],
                        yAxes: [
                        {
                            display: true,
                            scaleLabel:
                            {
                                display: false,
                                labelString: 'Profit margin (approx)'
                            },
                            gridLines:
                            {
                                display: true,
                                color: "#f2f2f2"
                            },
                            ticks:
                            {
                                beginAtZero: true,
                                fontSize: 11
                            }
                        }]
                    }
                }
            }
            new Chart($("#barChart > canvas").get(0).getContext("2d"), config);
        }
        barChart();
        /*
		var bar = new Morris.Bar({
	      	element: 'bar-chart',
	      	resize: true,
	      	data: <?=json_encode($arr_aylik_ihale)?>,
	      	barColors: ['#00c0ef', '#39cccc'],
	      	xkey: 'y',
	      	ykeys: ['a', 'b'],
	      	labels: ['IHALE', 'KAZANMA'],
	      	hideHover: 'auto'
	    });
		*/
		
		$("#talep_no").on('keyup', function (e) {
		    if (e.keyCode == 13) {
		        fncFiltrele();
		    }
		});
		
		function fncFiltrele(){
			$("#form").submit();
		}
		
	</script>
    
</body>
</html>
