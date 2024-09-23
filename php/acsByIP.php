<?php
function acsByIP($perm){
	include_once('noCache.php');
	require_once('conex.php');
	
	noCache();
	$conex = conex();
	
	if(!$conex){
		echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
		exit;
	} else {
		$eIP = getIP();
		$sentencia = "SELECT algo FROM aLgunlugar WHERE algunarestriccion";
		$ex = pg_query($sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
		
		if (pg_num_rows($ex) < 1){
			header("Location: 127.0.0.1/index.php");
		} else {
			while($res = pg_fetch_array($ex, NULL, PGSQL_NUM)){
				//VARIABLES A SACAR DE LA CONSULTA
			}
		}
		closeConex($ex, $conex);
	}
}		
?>