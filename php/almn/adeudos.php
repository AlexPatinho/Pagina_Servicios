<?php
include_once("../miscelaneas.php");
require_once("../conex.php");

noCache();
session_start();
if(isset($_GET) and 
	isset($_GET["cta"]) and 
	isset($_SESSION) and 
	isset($_SESSION["cta"]) and 
	($_GET["cta"] === $_SESSION["cta"])){
		
	$_cta = $_GET["cta"];
	$conex = conex("p400");
	
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$sentencia = "SELECT a.id_addo AS  \"I\", ".
					"CASE WHEN t.descr IS NULL THEN '***' ".
						"ELSE t.descr END AS \"DT\", ".
					"CASE WHEN a.descr IS NULL THEN '***' ".
						"ELSE a.descr END AS \"DA\", ".
					"CASE WHEN a.activo = TRUE THEN 'PENDIENTE' ".
						"ELSE 'SALDADO' END AS \"P\", ".
					"a.fechapag AS \"F\", ".
					"a.mto_addo AS \"MT\" ".
					"FROM adeudo AS a, tipoAddo AS t ".
					"WHERE a.fk_tipo_addo = t.id_tipo_addo ".
						"AND a.cuenta = substring('$_cta' FROM 1 FOR 9) ".
					"ORDER BY a.id_addo ASC;";
					
		$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		$adeudos = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$adeudos[] = $resp;
		}
		closeConex($ex, $conex);
		
		echo json_encode($adeudos);
	}
} else {
	unset($_GET);
	session_unset();
	session_destroy();
	header("Location: ../");
}
?>