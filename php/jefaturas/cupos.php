<?php
//	ini_set('display_errors', 1);
//	error_reporting(E_ALL);
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
session_start();

$bdd = "inscripciones";//BASE DE DATOS DEL NUEVO SISTEMA
//$bdd = "kernelaragon";//BASE DE DATOS DEL NUEVO SISTEMA

//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
//SE SOLICITAN LOS SEMESTRES, TURNOS, GRUPOS Y MATERIAS DISPONIBLES LA CARRERA
if(isset($_SESSION) 
and isset($_SESSION["usrJef"])
and isset($_SESSION["carr"])
and isset($_SESSION["nCarr"])
and isset($_SESSION["serv"])
and isset($_POST)
and isset($_POST["trn"])
and $_POST["trn"] == true
and isset($_POST["sem"])
and $_POST["sem"] == true){
	
	
	//SE SELECCIONA EL SERVIDOR AL CUAL SE CONECTAR
	$conex = conex40($bdd);
	/*
	switch($_SESSION["serv"]){
		case "40":{ $conex = conex40("escolares"); break; }
		case "41":{ $conex = conex41("escolares"); break; }
		case "43":{ $conex = conex43("escolares"); break; }
		case "44":{ $conex = conex44("escolares"); break; }
	}*/
	
	//SI LA CONEXION NO ES EXITOSA...
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
	//... EN CASO QUE LA CONEXION SE HAYA REALIZADO CORRECTAMENTE...
		/*
		$sentencia = "SELECT clave_semestre FROM semestre WHERE actual;";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		$sem = pg_fetch_result($ex, 0, 0);
		*/
		$data = array();
		//----------------------------------------------------------------------------------------------
		//----------------------------------------------------------------------------------------------
		//TURNOS DISPONIBLES EN LA CARRERA
		/*
		$sentencia = "SELECT DISTINCT b.id_turno AS \"TRN\", 
						b.nombre_turno AS \"NOM\" 
					FROM grupo".$sem." AS a 
						JOIN turno AS b ON a.id_turno = b.id_turno
					WHERE a.carr = '".$_SESSION["carr"]."';";
		*/
		$sentencia = "SELECT DISTINCT
						turno.id AS \"TRN\",
						turno.nombre AS \"NOM\"   
					FROM 
						public.grupo, 
						public.turno, 
						public.ciclo_escolar, 
						public.carrera
					WHERE 
						grupo.turno_id = turno.id AND
						grupo.ciclo_escolar_id = ciclo_escolar.id AND
						grupo.carrera_id = carrera.id AND
						carrera.id = ".$_SESSION["carr"]." AND 
						ciclo_escolar.actual
					ORDER BY 
						turno.nombre ASC;";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$data["TURN"][] = $resp;
		}
		
		//----------------------------------------------------------------------------------------------
		//----------------------------------------------------------------------------------------------
		//SEMESTRES DISPONIBLES EN LA CARRERA
		/*
		$sentencia = "SELECT DISTINCT a.ciclo AS \"CIC\", 
					CASE WHEN a.ciclo = '1' or a.ciclo = '01' THEN '1°'
						WHEN a.ciclo = '2' or a.ciclo = '02' THEN '2°'
						WHEN a.ciclo = '3' or a.ciclo = '03' THEN '3°'
						WHEN a.ciclo = '4' or a.ciclo = '04' THEN '4°'
						WHEN a.ciclo = '5' or a.ciclo = '05' THEN '5°'
						WHEN a.ciclo = '6' or a.ciclo = '06' THEN '6°'
						WHEN a.ciclo = '7' or a.ciclo = '07' THEN '7°'
						WHEN a.ciclo = '8' or a.ciclo = '08' THEN '8°'
						WHEN a.ciclo = '9' or a.ciclo = '09' THEN '9°'
						WHEN a.ciclo = '10' or a.ciclo = '10' THEN '10°'
						ELSE a.ciclo
					END AS \"SEM\" 
					FROM asignatura AS a 
						JOIN grupo".$sem." AS b ON a.cve_plan_asignatura = b.cve_plan_asignatura
					WHERE b.carr = '".$_SESSION["carr"]."'
					ORDER BY \"SEM\";";
		*/
		$sentencia = "SELECT DISTINCT  
							semestre.id AS \"CIC\", 
							semestre.nombre \"SEM\" 
						FROM 
							public.grupo, 
							public.ciclo_escolar, 
							public.carrera, 
							public.asignatura, 
							public.tipo_curso, 
							public.semestre, 
							public.plan_estudios_has_asignatura
						WHERE 
							grupo.ciclo_escolar_id = ciclo_escolar.id AND
							grupo.carrera_id = carrera.id AND
							grupo.asignatura_id = asignatura.id AND
							asignatura.tipo_curso_id = tipo_curso.id AND
							asignatura.id = plan_estudios_has_asignatura.asignatura_id AND
							plan_estudios_has_asignatura.semestre_id = semestre.id AND
							carrera.id = ".$_SESSION["carr"]." AND 
							ciclo_escolar.actual
						ORDER BY
							semestre.id ASC;";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$data["SEME"][] = $resp;
		}
		
		//----------------------------------------------------------------------------------------------
		//----------------------------------------------------------------------------------------------
	}
	
	closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
	echo json_encode($data);
	
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
//SE SELECCIONAN LOS GRUPOS DE LA CARRERA SEGUN EL CRITERIO SELECCIONADO
} else if(isset($_SESSION) 
and isset($_SESSION["usrJef"])
and isset($_SESSION["carr"])
and isset($_SESSION["nCarr"])
and isset($_SESSION["serv"])
and isset($_POST)
and isset($_POST["cons"])
and $_POST["cons"] == true
and isset($_POST["ord"])){
	
	//SE SELECCIONA EL SERVIDOR AL CUAL SE CONECTARA
	$conex = conex40($bdd);
	/*
	switch($_SESSION["serv"]){
		case "40":{ $conex = conex40("escolares"); break; }
		case "41":{ $conex = conex41("escolares"); break; }
		case "43":{ $conex = conex43("escolares"); break; }
		case "44":{ $conex = conex44("escolares"); break; }
	}
	*/
	//SI LA CONEXION NO ES EXITOSA...
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
	//... EN CASO QUE LA CONEXION SE HAYA REALIZADO CORRECTAMENTE...
		/*	
		$sentencia = "SELECT clave_semestre FROM semestre WHERE actual;";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		$sem = pg_fetch_result($ex, 0, 0);
		*/
		$ord = " ";
		switch($_POST["ord"]){
			case "1": { 
				//if(isset($_POST["trn"])){ $ord = " a.id_turno = '".$_POST["trn"]."' AND "; }
				if(isset($_POST["trn"])){ $ord = "turno.id = ".$_POST["trn"]." AND "; }
				break;
			}
			case "2": {
				//if(isset($_POST["sem"])){ $ord = " e.ciclo = '".$_POST["sem"]."' AND "; }
				//if(isset($_POST["sem"])){ $ord = "semestre.id = '".$_POST["sem"]."' AND "; }
				//echo json_encode(intval ($_POST["sem"])); exit;
				if(isset($_POST["sem"])){ 
					$ord = "substring(grupo.clave FROM 2 FOR 1) = '".intval ($_POST["sem"])."' AND "; 
				}
				break;
			}
		}
		
		//----------------------------------------------------------------------------------------------
		//----------------------------------------------------------------------------------------------
		/*
		$sentencia = "SELECT 
						e.clave_asignatura AS \"CVE\", 
						e.nombre_asignatura AS \"ASG\", 
						a.clave_grupo AS \"GPO\", 
						substring(f.nombre_turno FROM 1 FOR 3) AS \"TRN\", 
						e.ciclo AS \"SEM\", 
						a.cupo_total AS \"CPO\", 
						a.cupo AS \"INS\", 
						c.ap_materno || ' ' || c.ap_paterno || ', ' || c.nombre AS \"NOM\", 
						d.nombre_salon AS \"SAL\",
						a.id_grupo AS \"IDG\" 
					FROM 
						asignatura e, 
						grupo".$sem." a, 
						profesor c, 
						profesor_plantel b, 
						salon d, 
						turno f
					WHERE ".$ord." 
						e.cve_plan_asignatura = a.cve_plan_asignatura AND 
						a.id_salon = d.id_salon AND 
						c.id_profesor = b.id_profesor AND 
						b.id_profesor_plantel = a.id_profesor_plantel AND 
						a.id_turno = f.id_turno AND 
						a.carr = '".$_SESSION["carr"]."'
					ORDER BY
						a.clave_grupo, 
						e.nombre_asignatura;";
		*/
		if($_SESSION["carr"] == 2 || $_SESSION["carr"] == 3){
			$semes = "'00' AS \"SEM\", "; 
			$plan_has_asig ="";
			$semestre = "";
			$plan_where = "";
		} else {
			/*
			$semes = "semestre.id AS \"SEM\", ";
			$plan_has_asig = "public.plan_estudios_has_asignatura, ";
			$semestre = "public.semestre, ";
			$plan_where = "plan_estudios_has_asignatura.plan_estudios_id = plan_estudios.id AND
							plan_estudios_has_asignatura.asignatura_id = asignatura.id AND
							plan_estudios_has_asignatura.semestre_id = semestre.id AND
							plan_estudios_has_asignatura.tipo_asignatura_id = tipo_asignatura.id AND";
			*/
			$semes = "CASE WHEN substring(grupo.clave FROM 2 FOR 1) = '1' THEN '01'
						WHEN substring(grupo.clave FROM 2 FOR 1) = '2' THEN '02'
						WHEN substring(grupo.clave FROM 2 FOR 1) = '3' THEN '03'
						WHEN substring(grupo.clave FROM 2 FOR 1) = '4' THEN '04'
						WHEN substring(grupo.clave FROM 2 FOR 1) = '5' THEN '05'
						WHEN substring(grupo.clave FROM 2 FOR 1) = '6' THEN '06'
						WHEN substring(grupo.clave FROM 2 FOR 1) = '7' THEN '07'
						WHEN substring(grupo.clave FROM 2 FOR 1) = '8' THEN '08'
						WHEN substring(grupo.clave FROM 2 FOR 1) = '9' THEN '09'
						WHEN substring(grupo.clave FROM 2 FOR 1) = '0' THEN '10'
						END AS \"SEM\", ";
			$plan_has_asig = " ";
			$semestre = " ";
			$plan_where = " ";
		}
		
		$sentencia = "SELECT DISTINCT
							asignatura.clave AS \"CVE\", 
							asignatura.nombre AS \"ASG\", 
							grupo.clave AS \"GPO\", 
							turno.nombre AS \"TRN\", 
							".$semes."
							grupo.cupo AS \"CPO\", 
							grupo.inscritos AS \"INS\", 
							profesor.apellido_paterno || ' ' || profesor.apellido_materno || ' ' || profesor.nombre AS \"NOM\", 
							salon.id AS \"SAL\", 
							grupo.id AS \"IDG\"
						FROM 
							public.asignatura, 
							public.carrera, 
							public.turno, 
							public.ciclo_escolar, 
							public.plantel, 
							public.tipo_curso, 
							".$plan_has_asig."
							public.plan_estudios, 
							".$semestre."
							public.tipo_asignatura, 
							public.grupo 
						LEFT JOIN
							public.profesor_has_grupo
							ON grupo.id = profesor_has_grupo.grupo_id
						LEFT JOIN 
							public.profesor
							ON profesor.id = profesor_has_grupo.profesor_id
						LEFT JOIN
							(public.horario LEFT JOIN public.salon ON horario.salon_id = salon.id) 
							ON grupo.id 	= horario.grupo_id 
						WHERE 
							asignatura.plantel_id = plantel.id AND
							asignatura.tipo_curso_id = tipo_curso.id AND
							grupo.asignatura_id = asignatura.id AND
							grupo.carrera_id = carrera.id AND
							grupo.turno_id = turno.id AND
							grupo.ciclo_escolar_id = ciclo_escolar.id AND
							grupo.plantel_id = plantel.id AND
							grupo.sistema = '".$_SESSION["sis"]."' AND 
							carrera.plantel_id = plantel.id AND
							".$plan_where."
							ciclo_escolar.actual = TRUE AND 
							".$ord."
							carrera.id = ".$_SESSION["carr"]."
						ORDER BY
							grupo.clave ASC, 
							asignatura.nombre ASC;";
		//echo json_encode($sentencia); exit;
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		
		
		$grupos = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$grupos[] = $resp;
		}
	}
	
	closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
	echo json_encode($grupos);
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
//SE ACTUALIZA EL GRUPO(S) SEGUN EL CRITERIO
} else if(isset($_SESSION) 
and isset($_SESSION["usrJef"])
and isset($_SESSION["carr"])
and isset($_SESSION["nCarr"])
and isset($_SESSION["serv"])
and isset($_POST)
and isset($_POST["modi"])
and $_POST["modi"] == true
and isset($_POST["tipo"])
and isset($_POST["cnd"])
and isset($_POST["cupo"])){
	
	
	
	//SE SELECCIONA EL SERVIDOR AL CUAL SE CONECTARA
	$conex = conex40($bdd);
	/*
	switch($_SESSION["serv"]){
		case "40":{ $conex = conex40("escolares"); break; }
		case "41":{ $conex = conex41("escolares"); break; }
		case "43":{ $conex = conex43("escolares"); break; }
		case "44":{ $conex = conex44("escolares"); break; }
	}
	*/
	//SI LA CONEXION NO ES EXITOSA...
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
	//... EN CASO QUE LA CONEXION SE HAYA REALIZADO CORRECTAMENTE...
		
		/*
		$sentencia = "SELECT clave_semestre FROM semestre WHERE actual;";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		$sem = pg_fetch_result($ex, 0, 0);
		*/
		//----------------------------------------------------------------------------------------------
		//----------------------------------------------------------------------------------------------
		$cnd = NULL;
		switch($_POST["tipo"]){
			//case "ASG":{ $cnd = "id_grupo = ".$_POST["cnd"]; break; }
			case "ASG":{ $cnd = "id = ".$_POST["cnd"]; break; }
			//case "BQE":{ $cnd = "clave_grupo = '".$_POST["cnd"]."'"; break; }
			case "BQE":{ $cnd = "clave = '".$_POST["cnd"]."'"; break; }
			default:{ $cnd = ""; }
		}
		/*
		$sentencia = "UPDATE grupo".$sem." 
					SET cupo_total = '".$_POST["cupo"]."' 
					WHERE carr = '".$_SESSION["carr"]."' 
					AND ".$cnd.";";
		*/
		$sentencia = "UPDATE grupo 
					SET cupo = ".$_POST["cupo"]." 
					WHERE carrera_id = ".$_SESSION["carr"]."
					AND ".$cnd.";";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		
		$data = "X";
		//SE SE AFECTARON COLUMNAS INFORMAMOS
		if(pg_affected_rows($ex) > 0){
			$data = "O";
		}
	}
	
	//$data = $_POST["modi"].$_POST["tipo"].$_POST["cnd"].$_POST["cupo"];
	closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
	//echo json_encode($sentencia);
	echo json_encode($data);
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