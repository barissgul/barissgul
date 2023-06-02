<?
	error_reporting();
	//ini_set('max_input_vars', 5000);
	//buraya max_inputs_var = 10000
	//error_reporting( error_reporting() & ~E_NOTICE );
	@session_start();
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/dbPDO.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cBasic.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cComboData.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cTableData.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cSubData.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cExcelSayfasi.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cTarih.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cFormat.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cBootstrap.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cKayit.php');
	//require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cCrypt.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cSifre.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cSabit.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cGuvenlik.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cEntegrasyon.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cTY.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cBasbug.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cUyumsoft.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cSms.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/asset/PHPExcel/Classes/PHPExcel.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/asset/PHPMailer/class.phpmailer.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cMail.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cCurl.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/SqlFormatter.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/asset/mpdf60/mpdf.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/functions.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/SimpleImage.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/cHgs.php');
	
	// Db bağlantısı
	$cdbPDO 	= new dbPDO();
	$cdbMsql	= new dbMsql();
	if($_SERVER['SERVER_NAME'] == "auto.com"){
		define("HOST","localhost");
		define("DB","auto");
		define("USR","root");
		define("PSW","");
		define("SITE",1);
	} else {
		die("Yasak Giriş!");
		
	}
	
	$dbPDO 			= $cdbPDO->dbBaglan(HOST, DB, USR, PSW); 
	//$dbMsql			= $cdbMsql->dbBaglan(MSSQL_HOST, MSSQL_DB, MSSQL_USR, MSSQL_PSW);
	$cMail	 		= new Mail($cdbPDO);
	$cCurl	 		= new Curl($cdbPDO, $cMail);
	$cSms	 		= new Sms($cdbPDO, $cMail);
	
	// Bu sınıflar ekrana basılacak dataların belirlenmesinde kullanılıyor. 
	$cSimpleImage	= new SimpleImage();
	$cCombo 		= new comboData($cdbPDO);
	$cTable 		= new tableData($cdbPDO);
	$cSubData 		= new subData($cdbPDO, $cMail, $cCurl);
	//$cCrypt			= new Crypt();
	//$cSifre			= new Sifre($cCrypt);
	$cGuvenlik 		= new Guvenlik($cdbPDO);
	$cEntegrasyon	= new Entegrasyon($cdbPDO, $cMail, $cSubData);
	$cBasbug		= new Basbug($cdbPDO, $cMail);
	
	$row_kullanici 	= $cSubData->getSessionKullanici();
	$row_site 		= $cSubData->getSite();
	$rows_menu 		= $cSubData->getMenu();
	$rows_anamenu	= $cSubData->getAnaMenu();
	$rows_linklerim	= $cSubData->getLinklerim();
	$rows_doviz		= $cSubData->getDoviz();
	
	$cHgs 			= new Hgs();
	$cUyumsoft		= new Uyumsoft($cdbPDO, $cMail, $cSubData, $row_site);
	$cSabit			= new Sabit($row_site);
	$cKayit 		= new dbKayit();
	$cTY	 		= new TY();
	$cBootstrap		= new Bootstrap($cdbPDO, $cSubData, $cCombo, $cSabit, $row_site, $row_kullanici, $rows_anamenu, $rows_menu, $rows_linklerim);
	
	date_default_timezone_set('Europe/Istanbul');
	
	
	
	