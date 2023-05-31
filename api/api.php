<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/api/kontrol.php');
	header('Content-type: application/json; charset=utf-8');
	header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Max-Age: 1000");
	header("Access-Control-Allow-Headers: X-Custom-Header, X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
	header('Access-Control-Allow-Origin: *');
	set_time_limit(120);
	
	class api extends kontrol{
		
		function __construct() {
			parent::__construct(__CLASS__);
			//var_dump2(__LINE__);
			
		}
		
		function sorguCalistir(){
			self::kontrolId("SQL");
						
			$sql = $_REQUEST['SQL'];
			$this->cdbPDO->rows($sql);
			echo json_encode($rows);
			
		}
		
		//https://order.tr.parts/api/api.do?KEY=f57b0e103c26735ae640efa685e2f871&ISLEM=apiMailGonder&KIME=baris@boryaz.com&KONU=Önemli&ICERIK=Merhaba
		function apiMailGonder(){	
		 	
		 	if(strlen($_REQUEST['KIME']) <= 0 ){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "KIME kısmını doldurunuz!";
				echo json_encode($sonuc);die();
			}
		 	
		 	if(strlen($_REQUEST['KONU']) <= 0 ){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "KONU kısmını doldurunuz!";
				echo json_encode($sonuc);die();
			}
			
			if(strlen($_REQUEST['ICERIK']) <= 0 ){
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= "ICERIK kısmını doldurunuz!";
				echo json_encode($sonuc);die();
			}
			
		 	$result = $this->cMail->Gonder($_REQUEST['KIME'], $_REQUEST['KONU'], $_REQUEST['ICERIK']);
		 	
		 	if($result){
				$sonuc["HATA"] 		= FALSE;
				$sonuc["ACIKLAMA"] 	= "Mail gönderildi.";
				$sonuc["DATA"] 		= $rows;
			} else {
				$sonuc["HATA"] 		= TRUE;
				$sonuc["ACIKLAMA"] 	= $result;
			}		
			
			echo json_encode($sonuc);
			
		}
		
	}
	
	$cApi = new api();
	