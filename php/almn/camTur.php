<?php
if(!(time() >= strtotime("2023-01-09 00:01:00")
  && time() <= strtotime("2023-01-10 23:59:59"))){
//		header("Location: ../../");
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
&& isset($_POST["ver"]) 
&& $_POST["ver"] == true
&& $_SESSION["cta"] === $_POST["cta"]){
//SE VERIFICAN LOS DATOS DEL ALUMNO Y SI HA HECHO ALGUNA SOLICITUD EN EL PERIODO ACTUAL
	$conex = conex("p400");
	
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		
		$sentencia = "SELECT 
						a.cuenta AS \"CTA\", 
						a.paterno AS \"PAT\", 
						a.materno AS \"MAT\", 
						a.nombres AS \"NOM\", 
						b.ter AS \"TER\", 
						b.turno AS \"TUR\", 
						c.exa AS \"EXA\", 
						b.esta AS \"INS\", 
						d.plan_e AS \"PLN\", 
						d.nombre AS \"CRR\"
					FROM 
						public.consta b, 
						public.diralum c, 
						public.domi a, 
						public.semes d
					WHERE 
						b.cuenta = c.cuenta 
						AND b.plan_e = c.plan_e 
						AND c.plan_e = d.plan_e 
						AND a.cuenta = b.cuenta 
						AND a.cuenta = '".$_SESSION["cta"]."' 
						AND b.plan_e = '".$_SESSION["plan"]."';";
						
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		
		$data = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){ $data["ALM"][] = $resp; }
		
		$sentencia = "SELECT cve_sem AS \"SEM\", 
					substring(f_soli::text FROM 1 FOR 19) AS \"SOL\", 
					CASE WHEN tur_ori = 'M' THEN 'MATUTINO'
						WHEN tur_ori = 'V' THEN 'VESPERTINO'
						ELSE tur_ori END AS \"ORI\", 
					CASE WHEN tur_des = 'M' THEN 'MATUTINO'
						WHEN tur_des = 'V' THEN 'VESPERTINO'
						ELSE tur_des END AS \"DES\", 
					CASE WHEN cam_tur.causa = 'DOM' THEN 'DOMICILIO' 
						WHEN cam_tur.causa = 'SAL' THEN 'SALUD'
						WHEN cam_tur.causa = 'LAB' THEN 'LABORAL'
						WHEN cam_tur.causa = 'ACA' THEN 'ACADEMICO'
						WHEN cam_tur.causa = 'OTR' THEN 'OTRO MOTIVO' END AS \"CAU\", 
					motivos AS \"MOT\", 
					CASE WHEN estatus IS NULL THEN 'PENDIENTE'
						WHEN estatus = FALSE THEN 'RECHAZADA'
						WHEN estatus = TRUE THEN 'APROBADA' END AS \"STA\" 
					FROM cam_tur 
					WHERE cuenta = '".$_POST["cta"]."' 
						AND plan = '".$_SESSION["plan"]."' 
						AND cve_sem ='20232';";
			
			//(SELECT cve_sem FROM semestre WHERE activo);";
							
			$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
			
			while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){ $data["SOL"][] = $resp; }
			//SERVIDOR DE PRUEBAS
			//if(!empty($data["SOL"])){
				//$data["SOL"][0]["ARC"] = glob("../../../208/almn/ctf/".$data["ALM"][0]["CTA"]."_".$_SESSION["plan"]."_".$data["SOL"][0]["SEM"].".*");
			//SERVIDOR DE PRODUCCION
			if(!empty($data["SOL"])){
				$data["SOL"][0]["ARC"] = glob("../../almn/ctf/".$data["ALM"][0]["CTA"]."_".$_SESSION["plan"]."_".$data["SOL"][0]["SEM"].".*");
			} else {
				$sentencia = "SELECT count(*) 
						FROM cam_tur 
						WHERE cve_sem = '20232'
						AND NOT estatus IS NULL;";
				$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
				$resp = pg_fetch_row($ex, 0, PGSQL_NUM);
				if($resp[0] > 0){
					$data["SOL"][0]["ARC"] = "OUTDATE";
				}
			}
		@closeConex($ex, $conex);
		echo json_encode($data);
	}
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
} elseif(isset($_SESSION)
&& isset($_SESSION["cta"]) 
&& isset($_SESSION["plan"]) 
&& isset($_POST)
&& isset($_POST["agree"]) 
&& $_POST["agree"] == "on"
&& isset($_POST["cta"])
&& isset($_POST["tor"]) 
&& isset($_POST["tds"]) 
&& isset($_POST["cau"]) 
&& isset($_POST["mot"])
&& $_POST["cta"] === $_SESSION["cta"]
&& isset($_FILES)
&& isset($_FILES["jus"])){
//SE REGISTRA LA SOLICITUD DE CAMBIO DE TURNO
	$conex = conex("p400");
	
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$sentencia = "SELECT cve_sem FROM semestre WHERE cve_sem='20232' ";
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		$sem_act = pg_fetch_result ($ex, 0, 0);
		
		//(SELECT cve_sem FROM semestre WHERE activo),
		$sentencia = "INSERT INTO cam_tur 
						VALUES ('".$_POST["cta"]."', 
								'".$_SESSION["plan"]."', 
								 '20232',
								now(), 
								'".$_POST["tor"]."', 
								'".$_POST["tds"]."', 
								'".$_POST["cau"]."', 
								'A quien corresponda:\n\n".pg_escape_string(limpiarVariable($_POST["mot"]))."', 
								NULL)";
		
		$onom = $_FILES['jus']['tmp_name'];
		//DIRECTORIO SERVIDOR PRUEBAS
		//$dnom = $_SERVER['DOCUMENT_ROOT']."/208/almn/ctf/".$_POST["cta"]."_".$_SESSION["plan"]."_".$sem_act.".".pathinfo($_FILES['jus']['name'], PATHINFO_EXTENSION);
		
		//DIRECTORIO SERVIDOR PRODUCCION
		$dnom = $_SERVER['DOCUMENT_ROOT']."/almn/ctf/".$_POST["cta"]."_".$_SESSION["plan"]."_".$sem_act.".".pathinfo($_FILES['jus']['name'], PATHINFO_EXTENSION);
		if(move_uploaded_file ($onom, $dnom)){
			chmod($dnom, 0755);
			$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
			
			if(pg_affected_rows($ex) > 0){
				$sentencia = "SELECT cve_sem AS \"SEM\", 
							substring(f_soli::text FROM 1 FOR 19) AS \"SOL\", 
							CASE WHEN tur_ori = 'M' THEN 'MATUTINO'
								WHEN tur_ori = 'V' THEN 'VESPERTINO'
								ELSE tur_ori END AS \"ORI\", 
							CASE WHEN tur_des = 'M' THEN 'MATUTINO'
								WHEN tur_des = 'V' THEN 'VESPERTINO'
								ELSE tur_des END AS \"DES\", 
							CASE  WHEN cam_tur.causa = 'DOM' THEN 'DOMICILIO' 
								WHEN cam_tur.causa = 'SAL' THEN 'SALUD'
								WHEN cam_tur.causa = 'LAB' THEN 'LABORAL'
								WHEN cam_tur.causa = 'ACA' THEN 'ACADEMICO'
								WHEN cam_tur.causa = 'OTR' THEN 'OTRO MOTIVO' END AS \"CAU\", 
							motivos AS \"MOT\", 
							CASE WHEN estatus IS NULL THEN 'PENDIENTE'
								WHEN estatus = FALSE THEN 'RECHAZADO'
								WHEN estatus = TRUE THEN 'APROBADO' END AS \"STA\" 
							FROM cam_tur 
							WHERE cuenta = '".$_POST["cta"]."' 
								AND plan = '".$_SESSION["plan"]."' 
								AND cve_sem ='20232';"; 
								//(SELECT cve_sem FROM semestre WHERE activo);";
						
				$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
				$data = array();
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){ $data[] = $resp; }
				//SERVIDOR LOCAL/PRUEBAS
				//if(!empty($data)){$data[0]["ARC"] = glob("../../../208/almn/ctf/".$_POST["cta"]."_".$_SESSION["plan"]."_".$sem_act.".*");}
				//SERVIDOR PRODUCCION
				if(!empty($data)){$data[0]["ARC"] = glob("../../almn/ctf/".$_POST["cta"]."_".$_SESSION["plan"]."_".$sem_act.".*");}
				
				//SE CIERRAN LAS CONEXIONES Y SE ENVIAN LOS RESULTADOS
				@closeConex($ex, $conex);
				//unset($_POST);
				echo json_encode($data);
			}
		}
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