<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
include_once("../miscelaneas.php");
include_once("../conex.php");
noCache();
session_start();
if(isset($_SESSION)
	and isset($_SESSION["cta"])
	and isset($_POST)
	and isset($_POST["cmp"])){
	//SI LOS DATOS DE LA SESSION ESTAN ACTIVOS Y SE HAN ENVIADO DATOS POR POST
	$cta = $_SESSION["cta"];
	$conex = conex("p400");
	$sentencia = "SELECT b.nombre AS \"NOM\", 
				CASE WHEN a.sis = 'SUA' THEN '132.247.154.41'
				WHEN a.sis = 'ESC' THEN b.ip END AS \"IP\"
				FROM diralum AS a JOIN carrera AS b ON a.carr = b.carr 
				WHERE cuenta = '$cta' AND exa IS NULL;";
	//SE OBTIENEN LAS CARRERAS ACTIVAS DEL ALUMNO
	$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
	
	$result = array();
	while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
		$result[] = $resp;
	}
	
	closeConex($ex, $conex);
	echo json_encode($result);
} else {
	unset($_POST);
	session_unset();
	session_destroy();
}
?>