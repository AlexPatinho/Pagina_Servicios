<?php
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	//DESCOMENTAR LAS LINEAS DE ARRIBA PARA MOSTRAR LOS ERRORES DE PHP
	
	include_once("../miscelaneas.php");
	include_once("../conex.php");
	
	//INDICAMOS QUE NO SE GUARDE INFORMACION DEL DOCUMENTO EN EL NAVEGADOR
	noCache();
	//INICIAMOS/VERIFICAMOS UNA SESION
	ini_set("session.cookie_lifetime", "10800");
	ini_set("session.gc_maxlifetime", "10800");
	session_start();
	
	//COMPROBAMOS QUE EXISTAN LOS DATOS GENERADOS POR UN ACCESO VALIDO...
	if(isset($_POST) && 
		isset($_POST["cta"]) && 
		isset($_POST["consulta"]) && 
		$_POST["consulta"] == true && 
		isset($_SESSION) && 
		isset($_SESSION["usrVent"])){
		//CREAMOS UNA NUEVA CONEXION A LA BASE DE DATOS
		$conex = conex("p400");
		
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
		} else {
			$_cta = substr($_POST["cta"], 0, 9);
			
			$sentencia = "SELECT cuenta = '$_cta' 
							FROM domi 
							WHERE cuenta = '$_cta';";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$resp = pg_fetch_array($ex, NULL, PGSQL_NUM);
			//VERIFICAMOS SI EL NUMERO DE CUENTA EXISTE...
			//echo json_encode($resp);
			if($resp[0] == "t"){
				$sentencia = "SELECT a.paterno || ' ' || a.materno || ', ' || a.nombres AS \"NOM\", 
									b.nombre AS \"CRR\", 
									c.plan_e AS \"PLN\"
							FROM domi AS a 
								RIGHT JOIN diralum AS c ON a.cuenta = c.cuenta 
								JOIN carrera AS b ON b.carr = c.carr 
							WHERE a.cuenta = '$_cta'
							ORDER BY c.gen
							LIMIT 1;";
				$tramites = array();
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC);
				$tramites["INFO"] = $resp;
				
				$sentencia = "SELECT substr(ftramite, 5, 4) || 
									substr(ftramite, 3, 2) || 
									substr(ftramite, 1, 2) AS \"TRA\", 
									utramite AS \"UST\", 
								CASE WHEN (fenvio IS NOT NULL AND uenvio IS NOT NULL)
									THEN substr(fenvio, 5, 4) || 
										substr(fenvio, 3, 2) || 
										substr(fenvio, 1, 2) 
									ELSE ''
								END AS \"ENV\",
								CASE WHEN (frecibe IS NOT NULL AND urecibe IS NOT NULL)
									THEN substr(frecibe, 5, 4) || 
										substr(frecibe, 3, 2) || 
										substr(frecibe, 1, 2)
									ELSE ''
								END AS \"IMP\",
								substr(fentrega, 5, 4) || 
								substr(fentrega, 3, 2) || 
								substr(fentrega, 1, 2) AS \"ENT\",
								uentrega AS \"USE\",
								cuenta || plan_e || ftramite AS \"IDE\"
								FROM credencial
								WHERE cuenta = '$_cta'
								ORDER BY \"TRA\" DESC;";
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$tramites["TRAM"][] = $resp;
				}
				
				closeConex($ex, $conex);
				unset($_POST["cta"]);
				unset($_POST["consulta"]);
				unset($_POST);		
				
				echo json_encode($tramites);
			} else {
				closeConex($ex, $conex);
				//SI EL NUMERO DE CUENTA NO EXISTE DESTRUIMOS LAS VARIABLES Y CERRAMOS LA CONEXION
				unset($_POST["cta"]);
				unset($_POST["consulta"]);
				unset($_POST);		
				//...INFORMAMOS.
				echo json_encode(false);
			}
		}
		/*******************************************************************************************/
		/*******************************************************************************************/
		/*******************************************************************************************/
	} else if(isset($_POST)
	and isset($_POST["ent"])
	and isset($_POST["key"])
	and $_POST["ent"] == true
	and isset($_SESSION)
	and isset($_SESSION["usrVent"])){
	/*******************************************************************************************/
	/*******************************************************************************************/
		//CREAMOS UNA NUEVA CONEXION A LA BASE DE DATOS
		$_cta = substr($_POST["key"], 0, 9);
		$_plan = substr($_POST["key"], 9, 4);
		$_ftram = substr($_POST["key"], 13);
		$_fentr = date("dmY", time());
		$_uent = $_SESSION["usrVent"];
		
		$conex = conex("p400");
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "UPDATE credencial SET fentrega = '$_fentr', uentrega = '$_uent'
							WHERE cuenta = '$_cta' 
							AND plan_e = '$_plan' 
							AND ftramite = '$_ftram';";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			if(pg_affected_rows($ex) > 0){
				@closeConex($ex, $conex);
				unset($_POST["ent"]);
				unset($_POST["key"]);
				unset($_POST);
				$_fentr = substr($_fentr, 4, 4).substr($_fentr, 2, 2).substr($_fentr, 0, 2);
				//SE REGISTRO CORRECTAMENTE LA ENTREGA
				$result = array("FENT" => $_fentr, 
								"UENT" => $_uent, 
								"ENTR" => true);
				echo json_encode($result);
			} else {
				@closeConex($ex, $conex);
				unset($_POST["ent"]);
				unset($_POST["key"]);
				unset($_POST);
				//FALLO LA ENTREGA DE CREDENCIAL
				echo json_encode(false);
			}
		}
	/*******************************************************************************************/
	/*******************************************************************************************/
	} else {
	//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		unset($_POST);
		session_unset();
		session_destroy();
		header("Location: ../");
	}
?>