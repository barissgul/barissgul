<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	$row			= $cSubData->getStok($_REQUEST);
	
	// ->overlay($_SERVER['DOCUMENT_ROOT'].'/img/fligram.png', 'center', 0.05)
	// ->flip('x')   
	$cSimpleImage	->fromFile($cSabit->imgPathFile($row->URL))        
    				->autoOrient()                        
    				                        
    				->toScreen();                         
	