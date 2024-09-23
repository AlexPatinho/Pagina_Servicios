<?php

	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
//	include_once("../noCache.php");
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	
	session_start();
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	if(isset($_POST) && 
		isset($_POST["usr"]) && 
		isset($_POST["pass"])/* && isset($_POST["sec"])*/){
		//if(md5($_SERVER['REMOTE_ADDR'].",".substr($_SERVER['HTTP_REFERER'], 0, 22)) == $_POST["sec"]){
			
			$usr = $_POST["usr"];
			//$passw = strtolower($_POST["pass"]);
			$passw = $_POST["pass"];
			$conex = conex("p400");
			
			if(!$conex){
				echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
				exit;
			} else {
				//2016-04-25 :: SE AGREGAN SEMESTRE DE ART.22 Y SI ESTA AFECTADO POR ART.22 A $_SESSION
				$sentencia = "SELECT d.cuenta, (d.paterno || ' ' || d.materno || ', ' || d.nombres) AS nomComp, 
								da.plan_e AS planEst, 
								(d.nip5 = md5('$passw')) AS okPass, 
								art22,
								CASE WHEN art22 <= (SELECT cve_sem FROM semestre WHERE activo) 
									THEN TRUE ELSE FALSE 
								END AS afArt22,
								da.carr as cve_carr,
								da.sis as sistema
							FROM domi AS d, 
								diralum AS da 
							WHERE (exa IS NULL 
									OR exa = '06' 
									OR exa = '11' 
									OR exa = '14' 
									OR exa = '20' 
									OR exa = '23') 
							AND d.cuenta = da.cuenta 
							AND d.cuenta = '$usr' 
							LIMIT 1;";
				$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
				$cta = "-1";
				$okP = "-1";
				if (pg_num_rows($ex) < 1){
					closeConex($ex, $conex);
					echo "-2";
				} else {
					while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
						 $cta      = $resp[0];
						 $nom      = $resp[1];
						 $plan     = $resp[2];
						 $okP      = $resp[3];
						 $art22    = $resp[4];
						 $afArt22  = $resp[5];
						 $cve_carr = $resp[6];
						 $sistema  = $resp[7];
					}
					closeConex($ex, $conex);
					
					if($okP == "f"){
						regBita($cta, $plan, "I", "error");
						echo "-1";
					} else if($okP == "t"){
						$_SESSION["cta"]         = $cta;      //NUMERO DE CUENTA DEL ALUMNO EN BDD
						$_SESSION["plan"]        = $plan;     //PLAN DE ESTUDIOS ACTIVO ACTUAL
						$_SESSION["sistema"]     = $sistema;  //SISTEMA DEL ALUMNO
						$_SESSION["cve_carr"]    = $cve_carr; //CLAVE DE LA CARRERA
						$_SESSION["nomComp"]     = $nom;      //NOMBRE COPLETO DEL ALUMNO
						$_SESSION["usr"]         = $usr;      //NUMERO DE CUENTA PROPORCIONADO POR EL ALUMNO
						$_SESSION["passw"]       = $passw;    //CONTRASEÑA DEL ALUMNO
						$_SESSION["art22"]["sm"] = $art22;    //SEMESTRE A PARTIR DEL CUAL SE ENCUEMTRA AFECTADO POR ART.22
						$_SESSION["art22"]["af"] = $afArt22;  //SI SE ENCUENTRA O NO ACTUALMENTE AFECTADO POR ART.22
						regBita($cta, $plan, "I", "exito");
						echo "0";
					} else {
						unset($_POST);	
						echo "NULL";
					}
				}
			}
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	} else if(isset($_SESSION)
	&& isset($_SESSION["cta"]) 
	&& isset($_SESSION["plan"]) 
	&& isset($_SESSION["nomComp"]) 
	&& isset($_SESSION["usr"]) 
	&& isset($_SESSION["passw"]) 
	&& isset($_POST) 
	&& isset($_POST["con"]) 
	&& $_POST["con"] == true 
	&& isset($_POST["cta"]) 
	&& $_POST["cta"] == $_SESSION["cta"]){
	//SE BUSCAN TODAS LAS TRAYECTORIAS ACTIVAS DEL ALUMNO
		
		$cta = $_SESSION["cta"];
		$conex = conex("p400");
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "SELECT b.nombre AS \"NOM\", 
								b.plan_e AS \"PLN\", 
								art22 AS \"SM\",
								CASE WHEN art22 <= (SELECT cve_sem FROM semestre WHERE activo) 
									THEN TRUE ELSE FALSE 
								END AS \"AF\" 
							FROM diralum AS a 
							JOIN semes AS b ON a.plan_e = b.plan_e
							WHERE a.cuenta = '$cta'
								AND (a.exa IS NULL
									OR exa = '06' 
									OR exa = '11' 
									OR exa = '14' 
									OR exa = '20' 
									OR exa = '23');";
			$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
			$carr = array();
			while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
				$carr[] = $resp;
			}
			closeConex($ex, $conex);
			echo json_encode($carr);
		}
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	} else if(isset($_SESSION) && 
	isset($_SESSION["cta"]) && 
	isset($_SESSION["plan"]) && 
	isset($_SESSION["nomComp"]) && 
	isset($_SESSION["usr"]) && 
	isset($_SESSION["passw"]) &&
	isset($_POST) &&
	isset($_POST["con"]) &&
	isset($_POST["plan"]) &&
	isset($_POST["af"]) &&
	isset($_POST["sm"]) &&
	$_POST["con"] == true){
	//SE ACTUALIZA EL PLAN DE ESTUDIOS ACTUAL DEL ALUMNO Y SU ESTATUS 
		$_SESSION["plan"] = $_POST["plan"];
		$_SESSION["art22"]["af"] = $_POST["af"];
		$_SESSION["art22"]["sm"] = $_POST["sm"];
		echo json_encode(true);
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	//***********************************************************************************************************************
	} else {
		unset($_POST);
		echo json_encode("Error de conexi&oacute;n con el servidor.");
	}
?>