<?php
//	ini_set('display_errors', 1);
//	error_reporting(E_ALL);
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
session_start();
//VERIFICAMOS LA(S) CARRERA(S) QUE TIENE EL ALUMNO
if(isset($_SESSION)
and isset($_SESSION["cta"])
and isset($_SESSION["plan"])
and isset($_POST)
and isset($_POST["check"])
and $_POST["check"] == true){
	
	$cta = $_SESSION["cta"];
	$conex = conex("p400");
	
	if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
	} else {
		$sentencia = "SELECT a.plan_e AS \"PLN\", b.nombre AS \"CRR\"
			FROM consta AS a JOIN semes AS b ON a.plan_e = b.plan_e 
			WHERE a.cuenta = '$cta';";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
		$result = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$result[] = $resp;//CARRERA(S) QUE CURSA(O) EL ALUMNO
		}
		
		closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
		
		echo json_encode($result);//SE ENVIAN LOS DATOS AL CLIENTE
	}
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
//VERIFICAMOS QUE TIPO DE CONSTANCIA(S) PUEDE TRAMITAR
} else if(isset($_SESSION)
and isset($_SESSION["cta"])
and isset($_SESSION["plan"])
and isset($_POST)
and isset($_POST["pln"])
and isset($_POST["tct"])
and $_POST["tct"] == true){
	
	$cta = $_SESSION["cta"];
	$plan = $_POST["pln"];
	$conex = conex("p400");
	if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
	} else {
		
		$sentencia = "SELECT CASE WHEN (c.esta = '0' or c.esta IS NULL) THEN 0 ELSE 1 END AS \"TIPO\"
						FROM consta AS c 
						WHERE c.cuenta = '$cta' 
						AND c.plan_e = '$plan';";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		$result = pg_fetch_row($ex, 0);
		
		closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
		echo json_encode($result);//SE ENVIAN LOS DATOS AL CLIENTE
	}

//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
//OBTENEMOS LOS DATOS DE LA CONSTANCIA Y LOS MOSTRAMOS AL ALUMNO PARA VERIFICACION
} else if(isset($_SESSION)
and isset($_SESSION["cta"])
and isset($_SESSION["plan"])
and isset($_POST)
and isset($_POST["plan"])
and isset($_POST["tipo"])
and isset($_POST["cdc"])
and $_POST["cdc"] == true){
	
	//$cta = $_SESSION["cta"];
	//$plan = $_POST["plan"];
	$tipo = $_POST["tipo"];
	
	$conex = conex("p400");
	$datos = array();
	
	if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
	} else {
		$sentencia = "SELECT count(*) AS \"NUM\"
					FROM soli_const 
					WHERE cuenta = '".$_SESSION["cta"]."' 
						AND plan = '".$_POST["plan"]."' 
						AND tipo = '$tipo';";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$datos["CONS"][] = $resp;
		}
		switch($tipo){
			case 'CRD': { //CONSTANCIA DE CREDITOS
				$sentencia = "SELECT a.paterno || ' ' || a.materno || ', ' || a.nombres AS \"NOM\", 
								a.cuenta AS \"CTA\", 
								c.nombre AS \"CRR\", 
								b.sem::int AS \"SIN\", 
								c.semes::int AS \"TSM\", 
								b.prom AS \"PRM\",
								b.mats::int AS \"TMA\",
								c.totmat::int AS \"TMP\",
								b.plan_e AS \"PLN\",
								b.credb::int AS \"COB\",
								b.credp::int AS \"COP\",
								c.creobl::int AS \"TOB\",
								c.creopt::int AS \"TOP\", 
								b.esta AS \"INS\", 
								b.ter AS \"TER\"
							FROM domi AS a
							JOIN consta AS b ON a.cuenta = b.cuenta
							JOIN semes AS c ON b.plan_e = c.plan_e
							WHERE a.cuenta = '".$_SESSION["cta"]."'
							AND b.plan_e = '".$_POST["plan"]."';";
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
				$datos["ALM"] = pg_fetch_row($ex, 0, PGSQL_ASSOC);
				$datos["ALM"]["PRM"] = substr($datos["ALM"]["PRM"], 0, -2);
				
				break;
			}
			case 'EST': { //CONSTANCIA DE ESTUDIOS
				//$datos = array();
				$sentencia = "SELECT a.cuenta, 
									a.paterno || ' ' || a.materno || ', ' || a.nombres, 
									c.nombre, 
									b.plan_e, 
									b.turno,
									b.sem, 
									b.esta, 
									b.ter
								FROM domi AS a 
									JOIN consta AS b ON a.cuenta = b.cuenta
									JOIN semes AS c ON b.plan_e = c.plan_e
									JOIN carrera AS d ON c.carr = d.carr
								WHERE a.cuenta = '".$_SESSION["cta"]."'
									AND b.plan_e = '".$_POST["plan"]."';";
				
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$datos["ALMN"] = pg_fetch_row($ex, 0, PGSQL_NUM);
				closeConex($ex, $conex);
				
				/*
				switch(substr($datos["ALMN"][0], -2)){
					case "41":{
						$conex = conex41("escolares");
						break;
					}
					case "43":{
						$conex = conex43("escolares");
						break;
					}
					case "44":{
						$conex = conex44("escolares");
						break;
					}
				}
				*/
				$conex = conex40('inscripciones');
				/*
				$sentencia = "SELECT 'inscripcion' || clave_semestre, 
									'grupo' || clave_semestre 
								FROM semestre 
								WHERE actual;";//EL CAMPO INDICADO ES BOOLEAN
				
				
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$aux = pg_fetch_row($ex, 0, PGSQL_NUM);
				
				$sentencia = "SELECT a.clave_asignatura AS \"CVE\", 
								a.nombre_asignatura AS \"NOM\", 
								a.creditos AS \"CRD\", 
								a.ciclo AS \"SEM\", 
								b.id_grupo AS \"GPO\"
							FROM $aux[0] AS c
							JOIN $aux[1] AS b ON b.cve_grupo_plan_asignatura = c.cve_grupo_plan_asignatura
							JOIN asignatura AS a ON b.cve_plan_asignatura = a.cve_plan_asignatura
							WHERE c.cve_cuenta_plan = '$cta$plan'
							ORDER BY a.nombre_asignatura ASC;";
				*/
				$sentencia = "SELECT 
								c.clave AS \"CVE\", 
								c.nombre AS \"NOM\", 
								b.credito AS \"CRD\", 
								b.semestre_id AS \"SEM\", 
								e.clave AS \"GPO\"
							FROM 
								public.alumno_has_plan_estudios a, 
								public.asignatura c, 
								public.inscripcion d, 
								public.ciclo_escolar f, 
								public.grupo e, 
								public.plan_estudios_has_asignatura b
							WHERE 
								a.alumno_id = d.alumno_id 
								AND a.plan_estudios_id = d.plan_estudios_id 
								AND a.plan_estudios_id = b.plan_estudios_id 
								AND d.grupo_id = e.id 
								AND e.asignatura_id = c.id 
								AND e.ciclo_escolar_id = f.id 
								AND b.asignatura_id = c.id 
								AND a.alumno_id = '".$_SESSION["cta"]."' 
								AND a.plan_estudios_id = '".$_POST["plan"]."' 
								AND f.actual 
								AND e.tipo_evaluacion = 'O'
							ORDER BY
								d.created_at ASC;";
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$mats = 0;
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$datos["MATS"][] = $resp;
					$mats++;
				}
				$datos["ALMN"][] = $mats;
				break;
			}
		}
	}
	
	closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
	echo json_encode($datos);
	
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
//SE VERIFICA SI LA CONSTANCIA PROCEDE Y DE SER CORRECTO SE REGISTRA
} else if(isset($_SESSION)
and isset($_SESSION["cta"])
and isset($_SESSION["plan"])
and isset($_POST)
and isset($_POST["CTA"])
and $_POST["CTA"] === $_SESSION["cta"]
and isset($_POST["PLN"])
and $_POST["PLN"] === $_SESSION["plan"]
and isset($_POST["TPO"])
and isset($_POST["NUM"])){
	
	$cta = $_SESSION["cta"];
	$plan = $_POST["PLN"];
	$tipo = $_POST["TPO"];
	$num = intval($_POST["NUM"]);
	
	$conex = conex("p400");
	
	
	if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N p400: ".pg_last_error());
			exit;
	} else {
		$sentencia = "SELECT CASE WHEN (SELECT count(*) 
							FROM soli_const 
							WHERE fecha_soli::date = CURRENT_DATE  
							AND cuenta = '$cta' 
							AND tipo = '$tipo'
							AND plan = '$plan') < 2 THEN TRUE 
					ELSE FALSE END AS \"CDA\", 
					count(*) AS \"NUM\", 
					CASE WHEN(SELECT count(*) 
							FROM soli_const 
							WHERE fecha_entre IS NULL 
							AND cuenta = '$cta' 
							AND tipo = '$tipo' 
							AND plan = '$plan') < 4 THEN TRUE 
					ELSE FALSE END AS \"CPA\", 
					CASE WHEN (SELECT count(*) 
							FROM soli_const 
							WHERE fecha_soli::date = CURRENT_DATE) < 100 THEN TRUE
					ELSE FALSE END AS \"CDT\"
					FROM soli_const 
					WHERE cuenta = '$cta' 
						AND plan = '$plan' 
						AND tipo = '$tipo' 
						AND fecha_entre IS NULL;";
		
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		
		$result = pg_fetch_row($ex, 0, PGSQL_ASSOC);
		
		$aux = "";
		if($result["CDT"] == "t"){
		//NO SE HA LLEGADO AL LIMITE DE CONSTANCIAS DIARIAS TOTALES
			if($result["CPA"] == "t"){
			//NO SE HA LLEGADO AL LIMITE DE CONSTANCIAS PENDIENTES DE ENTREGA DEL ALUMNO
				if($result["CDA"] == "t"){
				//NO SE HA LLEGADO AL LIMITE DE CONSTANCIAS DIARIAS DEL ALUMNO
					if(intval($num) <= (4 - intval($result["NUM"]))){
						//EL NUMERO DE CONSTANCIAS SOLICITADAS ES MENOR O IGUAL QUE EL DE 
						//TRAMITES RESTANTES PERMITIDOS
						//-----------------------------------------------------------------------
						$sentencia = "INSERT INTO soli_const VALUES ";
						for($i = 1; $i <= $num; $i++){
							if($tipo === 'CRD'){
								$sentencia.= "(DEFAULT, 
												'$cta', 
												'$plan', 
												'".getIP()."',	
												now(), 
												".$_POST["TMA"].", 
												".$_POST["INS"].", 
												".$_POST["TER"].", 
												".$_POST["PRM"].", 
												".$_POST["COB"].", 
												".$_POST["COP"].", 
												".$_POST["SIN"].", 
												DEFAULT, 
												NULL, 
												NULL, 
												NULL, 
												NULL, 
												'$tipo')";
							} elseif($tipo === 'EST'){
								$sentencia.= "(DEFAULT, 
												'$cta', 
												'$plan', 
												'".getIP()."',	
												now(), 
												".$_POST["TMA"].", 
												".$_POST["INS"].", 
												".$_POST["TER"].", 
												DEFAULT, 
												DEFAULT, 
												DEFAULT, 
												".$_POST["SIN"].", 
												'".$_POST["TUR"]."', 
												NULL, 
												NULL, 
												NULL, 
												NULL, 
												'$tipo')";
							}
							if($i != $num){
								$sentencia.= ", ";
							}
						}
						//-----------------------------------------------------------------------
						$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
						if(pg_affected_rows($ex) > 0){
							$aux = "F";//TRAMITE REALIZADO CORRECTAMENTE
						} else {
							$aux = "E";//NO SE PUDIERON INGRESAR LAS SOLICITUDES
						}
					} else {
						$aux = "D";//NUMERO DE TRAMITES SOLICITADOS MAYOR AL NUMERO PERMITIDO
					}
				} else {
					$aux = "C";//LIMITE DE TRAMITES DIARIOS EXCEDIDO
				}
			} else {
				$aux = "B";//LIMITE DE CONSTANCIAS PENDIENTES EXCEDIDO
			}
		} else {
			$aux = "A";//LIMITE DIARIO EXCEDIDO
		}
		
		closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
		
		echo json_encode($aux);//SE ENVIAN LOS DATOS AL CLIENTE
	}
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
} else {
	//SI LAS VARIABLES NO EXISTEN...
	session_unset();
	session_destroy();
	unset($_POST);
	echo json_encode("Error de conexi&oacute;n con el servidor.");
}
?>