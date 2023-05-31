<?

	class Bootstrap{
		private $cdbPDO;
		private $cSubData;
		private $cCombo;
		private $rSite;
		private $rKullanici;
		private $rAnaMenu;
		private $rMenu;
		private $rLink;
		
		function __construct($cdbPDO = "", $cSubData = "", $cCombo = "", $cSabit = "", $row_site = "", $row_kullanici = "", $rows_anamenu = "", $rows_menu = "", $rows_linklerim = ""){
			$this->cdbPDO 			= $cdbPDO;
			$this->cdbPDO 			= $cdbPDO;
			$this->cSubData 		= $cSubData;
			$this->cCombo			= $cCombo;
			$this->cSabit			= $cSabit;
			$this->rSite 			= $row_site;
			$this->rKullanici		= $row_kullanici;
			$this->rAnaMenu			= $rows_anamenu;
			$this->rMenu 			= $rows_menu;
			$this->rLink 			= $rows_linklerim;
		}
		
		public function getHeader(){
			if($_SESSION['kullanici_id'] > 0) {
				$rows_mesaj_okunmamis 						= $this->cSubData->getMesajGelenOkunmamis();
				$rows_bildirim								= $this->cSubData->getIhaleOkunmamisMesaj($_REQUEST);
				$_SESSION['count_okunmamis_ihale_mesaj'] 	= count($rows_bildirim);
				$_SESSION['rows_okunmamis_ihale_mesaj']		= $rows_bildirim;//echo json_encode($_SESSION['rows_okunmamis_ihale_mesaj']);die();
				$rows_mesaj 								= $this->cSubData->getMesajGelen();
				$row_sepet 									= $this->cSubData->getSepetSay();
				//$rows_basvuru 								= $this->cSubData->getBasvurular();
				
				?>
				<header class="page-header" role="banner">
	                
	                <div class="page-logo">
	                    <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
	                        <img src="../smartadmin/img/logo.png" alt="logo">
	                        <span class="page-logo-text mr-1"> <?=$this->rSite->BASLIK?> </span>
	                        <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
	                        <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
	                    </a>
	                </div>
	                
	                <div class="hidden-md-down dropdown-icon-menu position-relative">
	                    <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Yönlendirme"> <i class="ni ni-menu"></i> </a>
	                    <ul>
	                        <li> <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minify Navigation"> <i class="ni ni-minify-nav"></i> </a> </li>
	                        
	                    </ul>
	                </div>
	                <div class="hidden-lg-up">
	                    <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on"> <i class="ni ni-menu"></i> </a>
	                </div>
	                <div class="search">
	                	<div class="row">
	                	<div class="col-md-12">
		                	<?if($_SESSION['hizmet_noktasi'] == 0){?>
		                	<select name="musteri_cari_id" id="musteri_cari_id" class="form-control select2 select2-hidden-accessible" onchange="fncMusteriCariDegistir(this)">
						      	<?=$this->cCombo->Musteriler()->setSecilen($_SESSION['cari_id'])->setSeciniz()->getSelect("ID","AD")?>
						    </select>
		                	<?}?>
	                	</div>
	                	</div>
	                </div>
	                
	                <div class="ml-auto d-flex">
	                	<div class="hidden-md-down">
                            <a href="#" class="header-icon" data-toggle="modal" data-target=".modalAyarlar">
                                <i class="fal fa-cog"></i>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="header-icon" data-toggle="dropdown">
                                <i class="fal fa-globe"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-animated w-auto h-auto"> 
                                <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top">
                                    <h4 class="m-0 text-center color-white">
                                        <?=dil("Dil Seçimi")?>
                                    </h4>
                                </div>
                                <div class="custom-scroll bg-gray-200" style="height: 130px;">
                                    <ul class="app-list">
                                        <li>
                                            <a href="#" class="app-list-item hover-white" onclick="fncDilDegistir('TR')">
                                            	<i class="flag flag-icon flag-icon-tr fs-xxl mt-3" title="Türkiye"></i>
                                                <span class="app-list-name fw-500">
                                                    TR
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="app-list-item hover-white" onclick="fncDilDegistir('ENG')">
                                               	<i class="flag flag-icon flag-icon-gb fs-xxl mt-3" title="Türkiye"></i>
                                                <span class="app-list-name fw-500">
                                                    EN
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="app-list-item hover-white" onclick="fncDilDegistir('RUS')">
                                               	<i class="flag flag-icon flag-icon-ru fs-xxl mt-3" title="Türkiye"></i>
                                                <span class="app-list-name fw-500">
                                                    RU
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--
	                    <div class="hidden-sm-up">
	                        <a href="#" class="header-icon" data-action="toggle" data-class="mobile-search-on" data-focus="search-field" title="Search"> <i class="fal fa-search"></i> </a>
	                    </div>
	                    -->
	                    <a href="/musteri/stok_arama.do?route=musteri/stok_arama" class="header-icon" tabindex="Stok Arama"> 
	                    	<i class="fas fa-search icon-stack-1x opacity-100 color-primary-500"></i>
                        </a>
	                    <a href="/musteri/sepet.do?route=musteri/sepet" title="Sepetim" class="header-icon"> 
	                    	<i class="fas fa-shopping-basket icon-stack-1x opacity-100 color-primary-500"></i>
	                    	<span class="badge border border-light rounded-pill bg-danger-500 position-absolute pos-top pos-right mt-2 fs-md" id="sepet_say"><?=$row_sepet->SAY?></span>
                        </a>
	                    <a href="/musteri/takvim.do" class="header-icon"> <i class="fal fa-calendar"></i> </a>
	                    
	                   
	                    <div>
	                        <a href="#" data-toggle="dropdown" class="header-icon d-flex align-items-center justify-content-center ml-2">
	                            <img src="<?=$this->cSabit->imgPath($this->rKullanici->RESIM_URL)?>" class="profile-image rounded-circle" alt="">
	                        </a>
	                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
	                            <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
	                                <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
	                                    <span class="mr-2">
	                                        <img src="<?=$this->cSabit->imgPath($this->rKullanici->RESIM_URL)?>" class="rounded-circle profile-image" alt="">
	                                    </span>
	                                    <div class="info-card-text">
	                                        <div class="fs-lg text-truncate text-truncate-lg"><?=$this->rKullanici->ADSOYAD?></div>
	                                        <span class="text-truncate text-truncate-md opacity-80"><?=$this->rKullanici->YETKI?></span>
	                                        <span class="d-inline-block text-truncate text-truncate-sm"><?=$this->rKullanici->KULLANICI?></span>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="dropdown-divider m-0"></div>
	                            <a href="/kullanici/hesabim.do" class="dropdown-item">
	                                <span data-i18n="drpdwn.settings"><?=dil2("Kullanıcı Ayarları")?></span>
	                            </a>
	                            <div class="dropdown-divider m-0"></div>
	                            <a href="#" class="dropdown-item" data-action="app-fullscreen">
	                                <span data-i18n="drpdwn.fullscreen"><?=dil2("Tam Ekran")?></span>
	                                <i class="float-right text-muted fw-n">F11</i>
	                            </a>
	                            <a href="#" class="dropdown-item" data-action="app-print">
	                                <span data-i18n="drpdwn.print"><?=dil2("Yazdır")?></span>
	                                <i class="float-right text-muted fw-n">Ctrl + P</i>
	                            </a>
	                            <div class="dropdown-divider m-0"></div>
	                            <a class="dropdown-item fw-500 pt-3 pb-3" href="/giris.do">
	                                <span> Çıkış </span>
	                            </a>
	                        </div>
	                    </div>
	                </div>
	            </header>
				<?
			}
			
		}
		
		public function getMenu(){
			//var_dump2($this->rKullanici->RESIM_URL);
			if($_SESSION['kullanici_id'] > 0) {
				$rows_mesaj_okunmamis 						= $this->cSubData->getMesajGelenOkunmamis();
				$rows_okunmamis_ihale_mesaj					= $this->cSubData->getIhaleOkunmamisMesaj($_REQUEST);
				$_SESSION['count_okunmamis_ihale_mesaj'] 	= count($rows_okunmamis_ihale_mesaj);
				$_SESSION['rows_okunmamis_ihale_mesaj']		= $rows_okunmamis_ihale_mesaj;//echo json_encode($_SESSION['rows_okunmamis_ihale_mesaj']);die();
				$rows_mesaj 								= $this->cSubData->getMesajGelen();
				//$rows_basvuru 								= $this->cSubData->getBasvurular();
				?>
				
				<aside class="page-sidebar">
                    <div class="page-logo" style="height: 100px;">
                        <a href="/" class="page-logo-link press-scale-down align-items-center" >
                            <img src="<?=$this->rSite->LOGO2?>" alt="logo" aria-roledescription="logo" style="height: 80px; width: 140px">
                            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                        </a>
                    </div>
                    <nav id="js-primary-nav" class="primary-nav" role="navigation">
                        <div class="nav-filter">
                            <div class="position-relative">
                                <input type="text" id="nav_filter_input" placeholder="Filter Menü" class="form-control" tabindex="0">
                                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                                    <i class="fal fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="info-card">
                            <img src="<?=$this->cSabit->imgPath($this->rKullanici->RESIM_URL)?>" class="profile-image rounded-circle" alt="">
                            <div class="info-card-text">
                                <a href="/kullanici/hesabim.do" class="d-flex align-items-center text-white">
                                    <span class="text-truncate text-truncate-sm d-inline-block"><?=$this->rKullanici->ADSOYAD?></span>
                                </a>
                                <?if($this->rKullanici->CARI_ID > 0){?>
                                <span class="d-inline-block text-truncate text-truncate-sm"><?=$this->rKullanici->CARI?></span><br>
                                <?}?>
                                <span class="d-inline-block text-truncate text-truncate-sm"><?=$this->rKullanici->YETKI?></span>
                            </div>
                            <img src="../smartadmin/img/card-backgrounds/cover-2-lg.png" class="cover" alt="cover">
                            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                                <i class="fal fa-angle-down"></i>
                            </a>
                        </div>
                        <ul id="js-nav-menu" class="nav-menu">
                           <?foreach($this->rAnaMenu as $key => $row_anamenu){
                           		$row_anamenu->CLASS = str_replace('fa fa', 'fal fa', $row_anamenu->CLASS);
                           		?>
						        <?if(count($this->rMenu[$row_anamenu->ROUTE]) > 0){?>
						        <li class="<?=routeActive($row_anamenu->ROUTE)?>">
						          	<a href="#" class="waves-effect waves-themed">
							            <i class="<?=$row_anamenu->CLASS?> <?=$this->getTextColor()?>"></i>
							            <span class="nav-link-text" data-i18n="nav.application_intel"> <?=dil($row_anamenu->ANAMENU)?> </span>
						          	</a>
						          	<ul>
						          	<?foreach($this->rMenu[$row_anamenu->ROUTE] as $key2 => $row){?>
										<li class="<?=routeActive($row->ROUTE)?>" title="<?=$row->TITLE?>"><a href="<?=$row->LINK?>" data-filter-tags="<?=$row->FILTRE?>" style="padding-left: 30px;"><i class="fal"></i> <?=dil($row->MENU)?> </a></li>
						          	<?}?>	
						          	</ul>
						        </li>
					        	<?}?>
					        <?}?>
					        <li>
						      	<a href="#" data-filter-tags="">
							        <i class="fal fa-link <?=$this->getTextColor()?>"></i>
							        <span class="nav-link-text"> <?=dil("Linklerim")?> </span>
						      	</a>
						      	<ul>
						      	<?foreach($this->rLink as $key => $row){?>
							        <li><a href="<?=$row->LINK?>" target="_blank" data-filter-tags="" style="padding-left: 30px;"> <?=$row->LINK_ADI?> </a> 
							        <!-- <a href="javascript:void(0)" data-id="<?=$row->ID?>" onclick="fncLinkSil(this)" class="pull-right" style="padding-right: 5px;"> <i class="fal fa-trash text-red"></i> </a> --> </li>
						      	<?}?>	
						      	</ul>
						    </li>
						    <li>
						    	<a href="#" title="Pages" data-filter-tags="tema" class=" waves-effect waves-themed">
                                    <i class="fal fa-plus-circle"></i>
                                    <span class="nav-link-text" data-i18n="nav.pages"><?=dil("Tema Seçimi")?></span>
                                </a>
                                <div class="settings-panel">
						    	<div class="expanded theme-colors pl-5 pr-3">
	                                <ul class="m-0">
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-0" data-id="0" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Wisteria (base css)"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-1" data-id="1" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tapestry"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-2" data-id="2" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Atlantis"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-3" data-id="3" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Indigo"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-4" data-id="4" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Dodger Blue"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-5" data-id="5" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tradewind"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-6" data-id="6" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cranberry"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-7" data-id="7" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Oslo Gray"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-8" data-id="8" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Chetwode Blue"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-9" data-id="9" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Apricot"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-10" data-id="10" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Blue Smoke"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-11" data-id="11" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Green Smoke"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-12" data-id="12" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Wild Blue Yonder"></a></li>
	                                    <li><a href="javascript:void(0)" onclick="fncTema(this)" id="myapp-13" data-id="13" data-action="theme-update" data-toggle="tooltip" data-placement="top" title="" data-original-title="Emerald"></a></li>
	                                </ul>
	                            </div>
	                            </div>
						    </li>
                        </ul>
                        <div class="filter-message js-filter-message bg-success-600"></div>
                    </nav>
                </aside>
                
		  	<?}
		  	
		}
		
		public function getHeaderPopup(){
			
			/*
			<header class="page-header" role="banner">
				<a href="/index.do" class="logo">
			  		<span class="logo-mini"><b><?=$this->rSite->BASLIK?></b></span>
				</a>
            </header>
            */
            
		}
		
		public function getFooter(){			
			?>
			<p id="js-color-profile" class="d-none">
                        <span class="color-primary-50"></span>
                        <span class="color-primary-100"></span>
                        <span class="color-primary-200"></span>
                        <span class="color-primary-300"></span>
                        <span class="color-primary-400"></span>
                        <span class="color-primary-500"></span>
                        <span class="color-primary-600"></span>
                        <span class="color-primary-700"></span>
                        <span class="color-primary-800"></span>
                        <span class="color-primary-900"></span>
                        <span class="color-info-50"></span>
                        <span class="color-info-100"></span>
                        <span class="color-info-200"></span>
                        <span class="color-info-300"></span>
                        <span class="color-info-400"></span>
                        <span class="color-info-500"></span>
                        <span class="color-info-600"></span>
                        <span class="color-info-700"></span>
                        <span class="color-info-800"></span>
                        <span class="color-info-900"></span>
                        <span class="color-danger-50"></span>
                        <span class="color-danger-100"></span>
                        <span class="color-danger-200"></span>
                        <span class="color-danger-300"></span>
                        <span class="color-danger-400"></span>
                        <span class="color-danger-500"></span>
                        <span class="color-danger-600"></span>
                        <span class="color-danger-700"></span>
                        <span class="color-danger-800"></span>
                        <span class="color-danger-900"></span>
                        <span class="color-warning-50"></span>
                        <span class="color-warning-100"></span>
                        <span class="color-warning-200"></span>
                        <span class="color-warning-300"></span>
                        <span class="color-warning-400"></span>
                        <span class="color-warning-500"></span>
                        <span class="color-warning-600"></span>
                        <span class="color-warning-700"></span>
                        <span class="color-warning-800"></span>
                        <span class="color-warning-900"></span>
                        <span class="color-success-50"></span>
                        <span class="color-success-100"></span>
                        <span class="color-success-200"></span>
                        <span class="color-success-300"></span>
                        <span class="color-success-400"></span>
                        <span class="color-success-500"></span>
                        <span class="color-success-600"></span>
                        <span class="color-success-700"></span>
                        <span class="color-success-800"></span>
                        <span class="color-success-900"></span>
                        <span class="color-fusion-50"></span>
                        <span class="color-fusion-100"></span>
                        <span class="color-fusion-200"></span>
                        <span class="color-fusion-300"></span>
                        <span class="color-fusion-400"></span>
                        <span class="color-fusion-500"></span>
                        <span class="color-fusion-600"></span>
                        <span class="color-fusion-700"></span>
                        <span class="color-fusion-800"></span>
                        <span class="color-fusion-900"></span>
                    </p>
			<footer class="page-footer" role="contentinfo">
                <div class="d-flex align-items-center flex-1 text-muted">
                    <span class="hidden-md-down fw-700"> <?=$this->rSite->ALTYAZI?> </span>&nbsp;
                </div>
                <div class="float-right hidden-xs"> <span class="js-get-date"></span> | <b>Version</b> 2.0.0 </div>
            </footer>
		  	<?
		}
		
		public function getTemaCss(){
			if($this->rKullanici->TEMA_ID > 0){
				?>
				<link rel="stylesheet" media="screen, print" href="../smartadmin/css/fa-solid.css"/>
				<link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon.png"/>
        		<link rel="icon" type="image/png" sizes="32x32" href="../img/favicon<?=$this->rSite->ID?>.png"/>
				<link id="mytheme" rel="stylesheet" href="../smartadmin/css/themes/cust-theme-<?=$this->rKullanici->TEMA_ID?>.css"/>
				<link rel="stylesheet" href="../smartadmin/plugin/flag-icon-css-master/css/flag-icon.min.css"/>
				<link rel="stylesheet" href="../smartadmin/plugin/1.css"/>
				<?
			}
		}
		
		public function getFontBoyut(){
			return $this->rKullanici->FONT_BOYUT_CLASS;
		}
		
		public function getBody(){
			return "mod-bg-1"; //nav-function-fixed
		}
		
		public function getTema(){
			if(is_null($this->rKullanici->ID)){
				return "hold-transition fixed skin-yellow sidebar-collapse sidebar-collapse";
			} else {
				return "hold-transition fixed " . $this->rKullanici->TEMA . ($_COOKIE['menu']=="0" ? " sidebar-collapse" : ""); // sidebar-collapse sidebar-mini skin-green fixed layout-boxed control-sidebar-open	
			}			
		}
		
		public function getTextColor(){
			return "text-white";
			return $this->rKullanici->TEXT_COLOR;
			
		}
		
		public function getTemaArkaPlan(){
			return $this->rKullanici->ARKA_PLAN;
			
		}
		
		public function getTemaJs(){
			
		}
		
	}
	
?>