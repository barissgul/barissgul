<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
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
    <link rel="stylesheet" href="../smartadmin/css/miscellaneous/fullcalendar/fullcalendar.bundle.css">
    <link rel="stylesheet" href="../smartadmin/plugin/timepicker/bootstrap-timepicker.min.css">
    <?$cBootstrap->getTemaCss()?>
</head>
<body class="<?=$cBootstrap->getBody()?>">
    <div class="page-wrapper">
    <div class="page-inner">
    <?=$cBootstrap->getMenu();?>
    <div class="page-content-wrapper">
    <?=$cBootstrap->getHeader();?>
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-globe'></i> Takvim
                <small><?=dil("Sipariş tarihlerine göre hesaplanmaktadır.")?></small>
            </h1>
        </div>
        <form name="form" id="form" class="app-forms" enctype="multipart/form-data" method="GET">
	        <div class="row">
	            <div class="col-xl-12">
	                <div id="panel-1" class="panel">
	                    <div class="panel-hdr">
	                        <h2>
	                            <?=dil("Takvim")?> <span class="fw-300"><i><?=dil("Sipariş Takip")?></i></span>
	                        </h2>
	                        <div class="panel-toolbar">
	                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Küçült"></button>
	                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Tam Ekran"></button>
	                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Kapat"></button>
	                        </div>
	                    </div>
	                    <div class="panel-container show">
	                        <div class="panel-content">
	                            <div id="calendar"></div>
	                            <!-- Modal : TODO -->
	                            <!-- Modal end -->
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
      	</form>
    </main>    
    </div>
    </div>
    </div>
        
    <script src="../smartadmin/js/vendors.bundle.js"></script>
    <script src="../smartadmin/js/app.bundle.js"></script>
    <script src="../smartadmin/js/holder.js"></script>
    <script src="../smartadmin/js/formplugins/select2/select2.bundle.js"></script>
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
    <script src="../smartadmin/plugin/locales-all.js"></script>
    <script src="../smartadmin/js/dependency/moment/moment.js"></script>
    <script src="../smartadmin/js/miscellaneous/fullcalendar/fullcalendar.bundle.js"></script>
    <?$cBootstrap->getTemaJs()?>
    <script src="../smartadmin/plugin/1.js"></script>
        
    <script>
        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
		
        var calendarEl = document.getElementById('calendar');
	
        var calendar = new FullCalendar.Calendar(calendarEl,
        {
        	locale: 'tr',
        	defaultView: 'dayGridMonth',
            plugins: ['dayGrid', 'list', 'timeGrid', 'interaction', 'bootstrap'],
            themeSystem: 'bootstrap',
            timeZone: 'UTC',
            dayMaxEvents: true,
            buttonText:
            {
                today: 'Bugün',
                month: 'Ay',
                week: 'Hafta',
                day: 'Gün',
                list: 'Liste'
            },
            eventTimeFormat:
            {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            },
            navLinks: true,
            header:
            {
                left: 'prev,next, today, addEventButton',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' //
            },
            views: {
			    timeGridFourDay: {
			      type: 'timeGrid',
			      duration: { days: 7 },
			    }
			},
			duration: { days: 7 },
            footer:
            {
                left: '',
                center: '',
                right: ''
            },
            titleFormat: { // will produce something like "Tuesday, September 18, 2018"
			    month: 'long',
			    year: 'numeric',
			    day: 'numeric',
			    weekday: 'long'
			},
            eventSources: [
		    	{
			      	url: '/musteri/takvim_json.do',
			      	method: 'POST',
			      	extraParams: function(){
			      		return {
			        		servis_id: "<?=$_REQUEST['servis_id']?>",
			        		servis_yeri: "<?=$_REQUEST['servis_yeri']?>"
						}
			      	},
			      	failure: function() {
			        	alert('Takvim JSON hatalı!');
			      	}
		    	}
		    ],
            customButtons:
            {
                addEventButton:
                {
                    text: '+',
                    click: function()
                    {
                        location.href = "/musteri/stok_arama.do?route=musteri/stok_arama";
                    },
                }
            },
            eventClick: function(event) {
			   	if (event.event.url) {
			      	event.jsEvent.preventDefault()
			      	window.open(event.event.url, "_blank");
			    }
			},
            //height: 700,
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: "",
		
        });
		
        calendar.render();
        
        function fncServisSec(obj){
			$("#form").submit();
		}
	
    </script>
</body>
</html>
