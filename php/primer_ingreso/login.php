<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
//	include_once("../noCache.php");
include_once("../miscelaneas.php");
require_once("../conex.php");

//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
noCache();

//*************************************************************************************

session_start();

if(isset($_POST) 
	&& isset($_POST["usr"]) 
	&& isset($_POST["pass"]))
{
	$usr   = $_POST["usr"];
	$passw = strtoupper($_POST["pass"]);
	$conex = conex("p400");

	if(!$conex)
	{
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} 
	else 
	{
		$sentencia = "SELECT cuenta, 
		(paterno || ' ' || materno || ', ' || nombre) AS nomComp, 
		plan_est AS planEst, 
		(substr(curp,1,16) = substr('$passw',1,16)) AS okPass,
		carrera as cve_carr
		FROM pi20222 AS d
		WHERE cuenta = '$usr';";

		$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
		$cta = "-1";
		$okP = "-1";
		if (pg_num_rows($ex) < 1)
		{
			closeConex($ex, $conex);
			echo "-2";
		} 
		else 
		{
			while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM))
			{
				$cta  = $resp[0];
				$nom  = $resp[1];
				$plan = $resp[2];
				$okP  = $resp[3];
			}
			closeConex($ex, $conex);

			if($okP == "f")
			{
				regBita($cta, $plan, "I", "error");
				echo "-1";
			} 
			else if($okP == "t")
			{
				$_SESSION["cta"] = $cta; //NUMERO DE CUENTA DEL ALUMNO EN BDD
				$_SESSION["plan"] = $plan; //PLAN DE ESTUDIOS
				$_SESSION["nomComp"] = $nom; //NOMBRE COMPLETO DEL ALUMNO
				$_SESSION["usr"] = $usr; //NUMERO DE CUENTA PROPORCIONADO POR EL ALUMNO
				$_SESSION["passw"] = $passw; //CURP PROPORCIONADA POR EL ALUMNO
				regBita($cta, $plan, "I", "exito");
				echo "0";
			} 
			else 
			{
				unset($_POST);	
				echo "NULL";
			}
		}
	}
	//***********************************************************************************************************************
} 
else 
{
	unset($_POST);
	echo json_encode("Error de conexi&oacute;n con el servidor.");
}
?>