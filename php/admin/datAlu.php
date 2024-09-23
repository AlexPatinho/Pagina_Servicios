<?php
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	//DESCOMENTAR LAS LINEAS DE ARRIBA PARA MOSTRAR LOS ERRORES DE PHP
	
	include_once("../noCache.php");
	include_once("../conex.php");
	
	//INDICAMOS QUE NO SE GUARDE INFORMACION DEL DOCUMENTO EN EL NAVEGADOR
	noCache();
	//INICIAMOS/VERIFICAMOS UNA SESION
	session_start();
	
	//COMPROBAMOS QUE EXISTAN LOS DATOS GENERADOS POR UN ACCESO VALIDO...
	if(isset($_SESSION) && 
	isset($_SESSION["usrAdmin"]) && 
	isset($_POST) && 
	isset($_POST["cta"]) && 
	isset($_POST["consulta"]) && 
	$_POST["consulta"] == true){
	//SE SOLICITAN DATOS BASICOS DEL USUARIO
		
		//CREAMOS UNA NUEVA CONEXION A LA BASE DE DATOS
		$conex = conex("p400");
		
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
		} else {
			$_cta = $_POST["cta"];
			$annio = date('Y');
			$sentencia = "SELECT d.cuenta AS \"CTA\", ".
			"c.nombre AS \"CRR\", ".
			"dr.sis AS \"SIS\", ".
			"d.email AS \"EMA\", ".
			"('$annio-' || substring(s.mdinsc FROM 1 FOR 2) || '-' || substring(s.mdinsc FROM 3 FOR 2) || ".
			"CASE WHEN s.horainsc = '0' THEN ' 08:00:00' ".
			"WHEN s.horainsc = '1' THEN ' 09:00:00' ".
			"WHEN s.horainsc = '2' THEN ' 10:00:00' ".
			"WHEN s.horainsc = '3' THEN ' 11:00:00' ".
			"WHEN s.horainsc = '4' THEN ' 12:00:00' ".
			"WHEN s.horainsc = '5' THEN ' 15:00:00' ".
			"WHEN s.horainsc = '6' THEN ' 16:00:00' ".
			"WHEN s.horainsc = '7' THEN ' 17:00:00' ".
			"WHEN s.horainsc = '8' THEN ' 18:00:00' ".
			"WHEN s.horainsc = '9' THEN ' 19:00:00' ".
			"WHEN s.horainsc = 'A' THEN ' 08:30:00' ".
			"WHEN s.horainsc = 'B' THEN ' 09:30:00' ".
			"WHEN s.horainsc = 'C' THEN ' 10:30:00' ".
			"WHEN s.horainsc = 'D' THEN ' 11:30:00' ".
			"WHEN s.horainsc = 'E' THEN ' 12:30:00' ".
			"WHEN s.horainsc = 'F' THEN ' 15:30:00' ".
			"WHEN s.horainsc = 'G' THEN ' 16:30:00' ".
			"WHEN s.horainsc = 'H' THEN ' 17:30:00' ".
			"WHEN s.horainsc = 'I' THEN ' 18:30:00' ".
			"WHEN s.horainsc = 'J' THEN ' 19:30:00' ".
			"WHEN s.horainsc = 'Z' THEN ' 22:00' ELSE ' 00:00:00' END) AS \"HRI\", ".
			"d.paterno AS \"PAT\", ".
			"d.materno AS \"MAT\", ".
			"d.nombres AS \"NOM\", ".
			"d.contra AS \"CON\", 
			CASE WHEN (position('#' IN d.email) > 0 AND d.nip5 IS NULL) 
				THEN TRUE ELSE FALSE END AS \"OKREG\" ".
			"FROM carrera AS c, ".
			"domi AS d, diralum AS dr ".
			"LEFT JOIN sorteo AS s ON (s.cuenta = dr.cuenta and s.plan_e = dr.plan_e) ".
			"WHERE d.cuenta = substring('$_cta' FROM 1 FOR 9) ".
			"AND dr.cuenta = d.cuenta ".
//			"AND dr.exa IS NULL ".
			"AND dr.carr = c.carr ".
			"ORDER BY dr.exa DESC;";
						
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$datos = array();
			while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
				$datos[] = $resp;
			}
			closeConex($ex, $conex);
			
			unset($_POST["cta"]);
			unset($_POST["consulta"]);
			//SI LA BASE DE DATOS NO REGRESO NINGUN DATO
			if(empty($datos)){
				//INFORMAMOS QUE NO EXISTE EL NUMERO DE CUENTA..
				echo json_encode("-2");
			} else {
				//...EN CASO QUE EXISTA, MANDAMOS LOS DATOS
				echo json_encode($datos);
			}
		}
//*****************************************************************************************************************************
//*****************************************************************************************************************************
//*****************************************************************************************************************************
	} elseif(isset($_SESSION) && 
	isset($_SESSION["usrAdmin"]) && 
	isset($_POST) && 
	isset($_POST["cta"]) && 
	isset($_POST["rre"]) && 
	$_POST["rre"] == true){
	//SE REINICIA EL REGISTRO DE USUSARIO PARA QUELLOS UUSARIOS QUE NO ALLAN LOGRADO CMPLETARLO
	
		//CREAMOS UNA NUEVA CONEXION A LA BASE DE DATOS
		$conex = conex("p400");
		
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
		} else {
			$cta = $_POST["cta"];
			$sentencia = "UPDATE domi 
							SET email = NULL, semactdom = NULL, nip = NULL, contra = NULL, nip5 = NULL 
							WHERE cuenta = '$cta'";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$data = pg_affected_rows($ex);
			closeConex($ex, $conex);
		}
		unset($_POST);
		echo json_encode($data);
//*****************************************************************************************************************************
//*****************************************************************************************************************************
//*****************************************************************************************************************************
	} else {
		//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		session_unset();
		session_destroy();
		header("Location: ../../");
	}
?>