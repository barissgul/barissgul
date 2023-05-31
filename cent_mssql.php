<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/class/function.php');
	ini_set('max_execution_time', 300);

	
	$dbMsql			= $cdbMsql->dbBaglan(MSSQL_HOST, MSSQL_DB, MSSQL_USR, MSSQL_PSW);
	
	$row_cari->OZEL_KOD1	= "E.0002";
	
	$filtre = array();
	$sql = "SELECT * FROM LOGO.dbo.B2B_CariBakiye WHERE CariKod = :CARI_KOD";
	$filtre[":CARI_KOD"]	= $row_cari->OZEL_KOD1;
	$rows = $cdbMsql->rows($sql, $filtre);
	
	var_dump2($rows);