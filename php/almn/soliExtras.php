<?php
if(!(time() >= strtotime("2022-11-24 00:10:00") 
  && time() <= strtotime("2022-11-25 23:59:00"))){
	header("Location: ../../");
}
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
include_once("../miscelaneas.php");
require_once("../conex.php");

noCache();
session_start();
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
if(isset($_SESSION)
&& isset($_SESSION["cta"]) 
&& isset($_SESSION["plan"]) 
&& isset($_POST) 
&& isset($_POST["cta"]) 
&& isset($_POST["crr"]) 
&& isset($_POST["chk"]) 
&& $_POST["chk"] === "ok"
&& $_SESSION["cta"] == $_POST["cta"]){
//SE VERIFICA SI EXISTE UN TRAMITE PREVIO DE EXTRAORDINARIOS
	$conex = conex("p400");
	
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {	
		$sentencia = "SELECT 
						domi.cuenta AS \"CTA\", 	
						domi.paterno AS \"PAT\", 
						domi.materno AS \"MAT\", 
						domi.nombres AS \"NOM\", 
						\"soliExtras\".cve_sem AS \"SEM\", 
						\"soliExtras\".num_ext AS \"NUM\", 
						\"soliExtras\".fech_soli AS \"FEC\", 
						semes.plan_e AS \"PLN\", 
						semes.nombre AS \"CRR\"
					FROM 
						public.domi, 
						public.semes, 
						public.\"soliExtras\"
					WHERE 
						domi.cuenta = \"soliExtras\".cuenta AND
						\"soliExtras\".plan = semes.plan_e AND
						\"soliExtras\".cve_sem = (SELECT cve_sem FROM semestre WHERE activo) AND 
						domi.cuenta = '".$_POST["cta"]."' AND 
						\"soliExtras\".plan = '".$_POST["crr"]."';";
						
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		
		$data = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){ $data[] = $resp; }
		
		$data = empty($data)? false : $data;
		closeConex($ex, $conex);
		echo json_encode($data);
	}
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
}else if(isset($_SESSION)
&& isset($_SESSION["cta"]) 
&& isset($_SESSION["plan"]) 
&& isset($_POST) 
&& isset($_POST["cta"]) 
&& isset($_POST["ver"]) 
&& $_POST["ver"] == true
&& $_SESSION["cta"] == $_POST["cta"]){
//BUSCAMOS LAS TRAYECTORIAS ACTIVAS DEL ALUMNO
	$conex = conex("p400");
	
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$sentencia = "SELECT 
						consta.plan_e AS \"PLN\", 
						consta.ter AS \"TER\", 
						semes.nombre AS \"NOM\", 
					CASE WHEN diralum.art22 <= (SELECT cve_sem FROM semestre WHERE activo) 
						THEN 1 ELSE 0 
					END AS \"ART\"
					FROM 
						public.domi, 
						public.semes, 
						public.consta, 
						public.diralum
					WHERE 
						domi.cuenta = consta.cuenta 
						AND domi.cuenta = diralum.cuenta
						AND consta.plan_e = semes.plan_e
						AND consta.plan_e = diralum.plan_e  
						AND domi.cuenta = '".$_SESSION["cta"]."';";
						
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		$data = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){ $data[] = $resp; }
		
		//CIERRE DE CONEXION Y ENVIO DE DATOS
		closeConex($ex, $conex);
		echo json_encode($data);
	}
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
} else if(isset($_SESSION)
&& isset($_SESSION["cta"]) 
&& isset($_SESSION["plan"]) 
&& isset($_POST) 
&& isset($_POST["cta"])
&& isset($_POST["carr"])
&& isset($_POST["num"])
&& isset($_POST["reg"])
&& $_POST["cta"] == $_SESSION["cta"]
&& $_POST["reg"] === 't'){
//SE REGISTRA EL NUMERO DE EXTRAORDINARIOS SOLICITADOS
	$conex = conex("p400");
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$sentencia = "INSERT INTO \"soliExtras\"(cuenta, plan, cve_sem, num_ext, fech_soli)
						SELECT '".$_POST["cta"]."',
								'".$_POST["carr"]."', 
								(SELECT cve_sem FROM semestre WHERE activo), 
								".$_POST["num"].", 
								now()
						WHERE NOT EXISTS (SELECT 1
								FROM \"soliExtras\" 
								WHERE cuenta = '".$_POST["cta"]."' 
									AND plan = '".$_POST["carr"]."' 
									AND cve_sem = (SELECT cve_sem FROM semestre WHERE activo));";
								
		$val = NULL;
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		pg_affected_rows($ex) > 0 ? $val = true : $val = false;//VERDADERO SI SE REGISTRO CORRECTAMENTE FALSO EN CASO CONTRARIO
		
		//CIERRE DE CONEXION Y ENVIO DE DATOS
		closeConex($ex, $conex);						
		echo json_encode($val);
	}
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
} else {
	unset($_POST);
	session_unset();
	session_destroy();
	header("Location: ../../");
}
?>