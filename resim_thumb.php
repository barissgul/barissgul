<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	session_kontrol();
	
	
	$row			= $cSubData->getStok($_REQUEST);
	//var_dump2($cSabit->imgPath($row->URL));die();
	
	//->overlay($_SERVER['DOCUMENT_ROOT'].'/img/fligram_thumb.png', 'center', 0.05)
	//->flip('x')   
	$cSimpleImage	->fromFile( $cSabit->imgPathFile($row->URL))           
    				->bestFit(100, 100)          
    				->autoOrient()               
    				->toScreen();                
	