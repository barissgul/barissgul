<?
   	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
  	require_once ($_SERVER['DOCUMENT_ROOT'] . '/asset/simple_html_dom/simple_html_dom.php');
  	
	foreach(glob(ini_get("session.save_path") . "/*") as $sessionFile) {
		unlink($sessionFile);
	}