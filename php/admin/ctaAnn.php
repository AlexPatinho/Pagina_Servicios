<?php
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	//DESCOMENTAR LAS LINEAS DE ARRIBA PARA MOSTRAR LOS ERRORES DE PHP
	
	include_once("../miscelaneas.php");
	include_once("../conex.php");
	
	//INDICAMOS QUE NO SE GUARDE INFORMACION DEL DOCUMENTO EN EL NAVEGADOR
	noCache();
	//INICIAMOS/VERIFICAMOS UNA SESION
	session_start();
	
	//COMPROBAMOS QUE EXISTAN LOS DATOS GENERADOS POR UN ACCESO VALIDO...
	if(isset($_POST) && 
		isset($_POST["cta"]) && 
		isset($_POST["consulta"]) && 
		isset($_SESSION) && 
		isset($_SESSION["usrAdmin"])){
		//CREAMOS UNA NUEVA CONEXION A LA BASE DE DATOS
		$conex = conex("p400");
		
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
		} else {
			$_cta = substr($_POST["cta"], 0, 9);
			$sentencia = "SELECT cuenta = '$_cta' FROM domi WHERE cuenta = '$_cta';";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$resp = pg_fetch_array($ex, NULL, PGSQL_NUM);
			//VERIFICAMOS SI EL NUMERO DE CUENTA EXISTE...
			if($resp[0] == "t"){
				//SI EXISTE VERIFICAMOS QUE NO SE ENCUENTRE AFECTADO POR ART.22...
				$sentencia = "SELECT CASE WHEN dr.art22 <= (SELECT MAX(cve_sem) FROM semestre WHERE activo = true) THEN dr.art22 ELSE '1' END FROM diralum AS dr WHERE dr.cuenta = '$_cta' ORDER BY dr.exa DESC;";
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$resp = pg_fetch_array($ex, NULL, PGSQL_NUM);
				if($resp[0] !== "1"){
					closeConex($ex, $conex);
					//SI SE ENCUENTRA AFECTADO POR ARTICULO 22 DESTRUIMOS LAS VALRIABLES
					unset($_POST["cta"]);
					unset($_POST["consulta"]);				
					//...INFORMAMOS.
					echo json_encode($resp[0]);
				} else {
					//SI EL ALUMNO NO SE ENCUENTRA AFECTADO POR ARTICULO 22 BUSCAMOS SUS ADEUDOS
					$sentencia = "SELECT a.id_addo AS \"I\", 
					CASE WHEN t.descr IS NULL THEN '***' ELSE t.descr END AS \"DT\", 
					CASE WHEN a.activo = TRUE THEN 'PENDIENTE' ELSE 'SALDADO' END AS \"P\", 
					a.fechapag AS \"F\", 
					a.monto_cta_ann AS \"M\",
					a.fk_login_vent AS \"R\" 
					FROM adeudo AS a, tipoAddo AS t
					WHERE a.fk_tipo_addo = t.id_tipo_addo 
					AND a.fk_tipo_addo = 1 ".//ADEUDOS DE CUOTA ANUAL
					"AND a.cuenta = '$_cta' 
					AND a.sem = '20231'".//ULTIMO SEMESTRE EN QUE SE PAGO LA CUOTA ANUAL
					"ORDER BY a.id_addo DESC LIMIT 1;";
					$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
					$addoCtaAnn = array();
					while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
						$addoCtaAnn[] = $resp;
					}
					closeConex($ex, $conex);
					
					//DESTRUIMOS LAS VARIABLES Y CERRAMOS LA CONEXION
					unset($_POST["cta"]);
					unset($_POST["consulta"]);
					
					//ENVIAMOS LOS DATOS OBTENIDOS DE LA BDD.
					echo json_encode($addoCtaAnn);
				}
			} else {
				
				//SI EL NUMORO DE CUENTA NO EXISTE DESTRUIMOS LAS VARIABLES Y CERRAMOS LA CONEXION
				unset($_POST["cta"]);
				unset($_POST["consulta"]);				
				//...INFORMAMOS.
				echo json_encode(false);
			}
		}
		//VERIFICAMOS SI SE HA ENVIADO DATOS PARA SAKDAR EL ADEUDO DE CUOTA ANULA DE MANERA VALIDA...
	} else if(isset($_POST) && 
			isset($_POST["cta"]) && 
			isset($_POST["monto"]) && 
			isset($_POST["id_addo"]) && 
			isset($_POST["reg"]) && 
			isset($_SESSION) && 
			isset($_SESSION["usrAdmin"])){
		//GENERAMOS UNA CONEXION A LA BDD
		$conex = conex("p400");
		
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex){
			unset($_POST["cta"]);
			unset($_POST["monto"]);
			unset($_POST["id_addo"]);
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
		} else {
			$_cta = $_POST["cta"];
			$_monto = $_POST["monto"];
			$_id_addo = $_POST["id_addo"];
			$_login = $_SESSION["usrAdmin"];
			
			if(intval($_POST["reg"]) == 0){
				$sentencia = "UPDATE adeudo ".
							"SET activo = false, ".
							"fechaadc = now(), ".
							"fechapag = now(), ".
							"descr = '***', ".
							"sem = (SELECT cve_sem FROM semestre WHERE activo), ".
							"monto_cta_ann = $_monto, ".
							"fk_login_vent = '$_login' ".
							"WHERE cuenta = '$_cta' ".
							"AND id_addo = $_id_addo;";
							
			} else if(intval($_POST["reg"]) == 1){
				$sentencia = "INSERT ".
							"INTO adeudo (cuenta, activo, fechaadc, fechapag, ".
										"descr, fk_tipo_addo, monto_cta_ann, ".
										"fk_login_vent, sem) ".
							"VALUES ('$_cta', false, now(), now(), '***', 1, $_monto, '$_login', (SELECT cve_sem FROM semestre WHERE activo));";
			}
			
			//INTENTAMOS ACTUALIZAR LOS CAMPOS CORRESPONDIENTES AL ADEUDO DE LA CUOTA ANUAL
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			//DESTRUIMOS LAS VARIABLES QUE ALMACENABAN LOS DATOS
			unset($_POST["cta"]);
			unset($_POST["monto"]);
			unset($_POST["id_addo"]);
			unset($_POST["reg"]);
			
			//VERIFICAMOS SI SE REALIZO EL CAMBIO...
			if(pg_affected_rows($ex) > 0){
				//INFORMAMOS QUE EL CAMBIO FUE REALIZADO
				closeConex($ex, $conex);
				echo json_encode(true);
			} else{
				//INFORMAMOS QUE EL CAMBIO NO FUE REALIZADO.
				closeConex($ex, $conex);
				echo json_encode(false);
			}
		}
		
	} else {
	//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		session_unset();
		session_destroy();
		header("Location: ../");
	}
?>