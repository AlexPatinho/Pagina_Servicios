<?php
//	ini_set('display_errors', 1);
//	error_reporting(E_ALL);
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	session_start();
	
	//$bdd = "inscripciones";//BASE DE DATOS DEL NUEVO SISTEMA
	$bdd = "p400";
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
	if(isset($_SESSION) 
	and isset($_SESSION["usrJef"])
	and isset($_SESSION["carr"])
	and isset($_SESSION["nCarr"])
	and isset($_SESSION["serv"])
	and isset($_POST)
	and isset($_POST["cons"])
	and $_POST["cons"] === 'true'
	and isset($_POST["tipo"])
	and isset($_POST["cr"])){
	//SE OBTIENE EL LISTADO DE LAS SOLICITUDES DE CAMBIO DE TURNO SEGÚN EL CRITERIO SELECCIONADO POR EL USUARIO
		$conex = conex($bdd);
		//SI LA CONEXION NO ES EXITOSA...
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$aux = "";
			if($_POST["tipo"]==="CAU"){
				$aux = "AND cam_tur.causa = '".$_POST["cr"]."'";
			} elseif($_POST["tipo"]==="DES"){
				$aux = "AND cam_tur.tur_des = '".$_POST["cr"]."'";
			}
			$sentencia = "SELECT 
							domi.cuenta AS \"CTA\", 
							domi.paterno || ' ' || domi.materno || ', ' || domi.nombres AS \"NOM\",
							CASE WHEN cam_tur.causa = 'SAL' THEN 1
								WHEN cam_tur.causa = 'LAB' THEN 2
								WHEN cam_tur.causa = 'DOM' THEN 3 
							END AS \"C\", 
							CASE WHEN cam_tur.causa = 'DOM' THEN 'DOMICILIO' 
								WHEN cam_tur.causa = 'SAL' THEN 'SALUD'
								WHEN cam_tur.causa = 'LAB' THEN 'LABORAL'
								WHEN cam_tur.causa = 'ACA' THEN 'ACADEMICO'
								WHEN cam_tur.causa = 'OTR' THEN 'OTRO MOTIVO'
							END AS \"CAU\", 
							CASE WHEN cam_tur.tur_ori = 'M' THEN 'MATUTINO'
								WHEN cam_tur.tur_ori = 'V' THEN 'VESPERTINO' 
							END AS \"TOR\",
							CASE WHEN cam_tur.tur_des = 'M' THEN 'MATUTINO'
								WHEN cam_tur.tur_des = 'V' THEN 'VESPERTINO' 
							END AS \"TDS\", 
							cam_tur.estatus AS \"STA\"
						FROM 
							public.carrera, 
							public.semes, 
							public.cam_tur, 
							public.domi,
							public.diralum
						WHERE 
							semes.carr = carrera.carr 
							AND cam_tur.plan = semes.plan_e 
							AND domi.cuenta = cam_tur.cuenta 
							AND diralum.cuenta=domi.cuenta
							AND cam_tur.cve_sem = '20232'
							".$aux."
							AND carrera.carr = '".$_SESSION["carr"]."'
							AND semes.sis = '".$_SESSION["sis"]."'
						ORDER BY \"C\", \"TOR\", domi.paterno, domi.materno, domi.nombres;";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$data = array();
			while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
				$data[] = $resp;
			}
			closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
			echo json_encode($data);
		}
		
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
	} elseif(isset($_SESSION) 
	and isset($_SESSION["usrJef"])
	and isset($_SESSION["carr"])
	and isset($_SESSION["nCarr"])
	and isset($_SESSION["serv"])
	and isset($_POST)
	and isset($_POST["det"])
	and $_POST["det"] === 'true'
	and isset($_POST["cta"])){
	//SE OBTIENE LA INFORMACION RELATIVA A LA SOLICITUD SELECCIONADA
	$conex = conex($bdd);
	//SI LA CONEXION NO ES EXITOSA...
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		//DATOS DE LA SOLICITUD
		$sentencia = "SELECT 
							domi.cuenta AS \"CTA\", 
							domi.paterno || ' ' || domi.materno || ', ' || domi.nombres AS \"NOM\",
							CASE WHEN domi.telefono IS NULL THEN '********' ELSE domi.telefono END AS \"TL1\", 
							CASE WHEN domi.telefono2 IS NULL THEN '********' ELSE domi.telefono2 END AS \"TL2\", 
							CASE WHEN domi.telefono3 IS NULL THEN '********' ELSE domi.telefono3 END AS \"TL3\", 
							CASE WHEN domi.email IS NULL THEN '********' ELSE domi.email END AS \"EMA\", 
							CASE WHEN cam_tur.causa = 'DOM' THEN 'DOMICILIO' 
								WHEN cam_tur.causa = 'SAL' THEN 'SALUD'
								WHEN cam_tur.causa = 'LAB' THEN 'LABORAL'
								WHEN cam_tur.causa = 'ACA' THEN 'ACADEMICO'
								WHEN cam_tur.causa = 'OTR' THEN 'OTRO MOTIVO'
							END AS \"CAU\", 
							carrera.nombre AS \"CRR\", 
							semes.plan_e AS \"PLN\", 
							cam_tur.motivos AS \"MOT\", 
							substring( cam_tur.f_soli::text FROM 1 FOR 19) AS \"FEC\", 
							cve_sem AS \"SEM\", 
							CASE WHEN cam_tur.tur_ori = 'M' THEN 'MATUTINO'
								WHEN cam_tur.tur_ori = 'V' THEN 'VESPERTINO' 
							END AS \"TOR\",
							CASE WHEN cam_tur.tur_des = 'M' THEN 'MATUTINO'
								WHEN cam_tur.tur_des = 'V' THEN 'VESPERTINO' 
							END AS \"TDS\", 
							consta.prom AS \"PRM\", 
							diralum.gen AS \"GEN\", 
							consta.credb::int + consta.credp::int AS \"AVC\",
							semes.creobl::int + semes.creopt::int AS \"CCR\"
						FROM 
							public.carrera, 
							public.semes, 
							public.cam_tur, 
							public.domi, 
							public.consta, 
							public.diralum 
						WHERE 
							domi.cuenta = '".$_POST["cta"]."'
							AND semes.carr = carrera.carr 
							AND cam_tur.plan = semes.plan_e
							AND consta.plan_e = cam_tur.plan
							AND diralum.plan_e = consta.plan_e
							AND domi.cuenta = cam_tur.cuenta 
							AND consta.cuenta = domi.cuenta
							AND diralum.cuenta = consta.cuenta
							AND cam_tur.cve_sem = '20232'
							AND carrera.carr = '".$_SESSION["carr"]."'
							AND semes.sis = '".$_SESSION["sis"]."';";
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		$data = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$data[] = $resp;
		}
		//NUMERO DE VECES QUE SE HA SOLICITADO EL CAMBIO DE TURNO
		$sentencia = "SELECT
						(SELECT count(*) 
							FROM cam_tur a 
							JOIN diralum b ON a.cuenta = b.cuenta 
							JOIN semes c ON b.plan_e = c.plan_e 
							WHERE a.cuenta = '".$_POST["cta"]."' 
								AND a.plan = b.plan_e
								AND c.carr = '".$_SESSION["carr"]."'
								AND NOT cve_sem = '20232') AS \"SOLI\", 
						(SELECT count(*) 
							FROM cam_tur a 
							JOIN diralum b ON a.cuenta = b.cuenta 
							JOIN semes c ON b.plan_e = c.plan_e 
							WHERE a.cuenta = '".$_POST["cta"]."' 
								AND a.plan = b.plan_e
								AND c.carr = '".$_SESSION["carr"]."'
								AND NOT cve_sem = '20232'
								AND a.estatus) AS \"APRO\", 
						(SELECT count(*) 
							FROM cam_tur a 
							JOIN diralum b ON a.cuenta = b.cuenta 
							JOIN semes c ON b.plan_e = c.plan_e 
							WHERE a.cuenta = '".$_POST["cta"]."' 
								AND a.plan = b.plan_e
								AND c.carr = '".$_SESSION["carr"]."'
								AND NOT cve_sem = '20232'
								AND NOT a.estatus) AS \"RECH\";";
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$data[0]["TRA"] = $resp;
		}
		//SE BUSCAN LOS ARCHIVOS QUE EL ALUMNO HAYA SUBIDO
		if(!empty($data)){
			//SERVIDOR DE PRUEBAS
			//$data[0]["FIL"] = glob("../../../208/almn/ctf/".$data[0]["CTA"]."_*_".$data[0]["SEM"].".*");
			//SERVIDOR PRODUCCION
			//$data[0]["FIL"] = glob("../../almn/ctf/".$data[0]["CTA"]."_*_".$data[0]["SEM"].".*");
			$data[0]["FIL"] = glob("../../almn/ctf/".$data[0]["CTA"]."_*_".$data[0]["SEM"].".*");

			
		}
		closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
		echo json_encode($data);
	}
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
	} elseif(isset($_SESSION) 
	and isset($_SESSION["usrJef"])
	and isset($_SESSION["carr"])
	and isset($_SESSION["nCarr"])
	and isset($_SESSION["serv"])
	and isset($_POST)
	and isset($_POST["cta"])
	and isset($_POST["pln"])
	and isset($_POST["sta"])
	and isset($_POST["act"])
	and $_POST["act"]==='true'){
	//SE ACTUALIZA EL ESTAUS DE LA SOLICITUD DE CAMBIO DE TURNO
	$conex = conex($bdd);
	//SI LA CONEXION NO ES EXITOSA...
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$sta = ($_POST["sta"] === 'ACEPT') ? 'TRUE' : 'FALSE';
		$sentencia = "UPDATE cam_tur 
						SET estatus = '".$sta."' 
						WHERE cuenta = '".$_POST["cta"]."' 
						AND plan = '".$_POST["pln"]."' 
						AND estatus IS NULL 
						AND cve_sem = '20232';";
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		$data = pg_affected_rows($ex);
		@closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
		echo json_encode($data);
	}
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
	} else {
		//SI LAS VARIABLES NO EXISTEN...
		session_unset();
		session_destroy();
		//unset($_POST);
		echo json_encode($_POST);
	}
?>