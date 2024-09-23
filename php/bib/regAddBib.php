<?php
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	
	//INICIAMOS/VERIFICAMOS UNA SESION
	session_start();
	if(isset($_POST)
		and isset($_POST["cta"])
		and isset($_POST["consulta"])
		and isset($_SESSION)
		and isset($_SESSION["usrBib"])){//VERIFICAMOS QUE EL NUMERO DE CUENTA DEL ALUMNO EXISTA
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
			unset($_POST["cta"]);
			unset($_POST["consulta"]);
			if($resp[0] == "t"){
				closeConex($ex, $conex);//CERRAMOS LA CONEXION
				echo json_encode(true);//Y SE MANDA UN ESTATUS DE VERDADERO
			} else {
				closeConex($ex, $conex);//CERRAMOS LA CONEXION,
				echo json_encode(false);//Y SE MANDA UN ESTATUS DE FALSO
			}
		}
	} else if(isset($_POST)
		and isset($_POST["cta"])
		and isset($_POST["fech"])
		and isset($_SESSION)
		and isset($_SESSION["usrBib"])){//SI SE RECIBEN LOS DATOS PARA EL REGISTRO DEL ADEUDO
		
		$conex = conex("p400");
		if(!$conex){
			unset($_POST["cta"]);
			unset($_POST["fech"]);
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else{
			$_cta = $_POST["cta"];
			$_fech = $_POST["fech"].":00";
			//$_mto = $_POST["mto"];
			$_user = $_SESSION["usrBib"];
			
			$sentencia = "INSERT INTO adeudo 
							(cuenta, activo, descr, fk_tipo_addo, fk_login_vent, fechaadc)
						VALUES('$_cta', true, 'ADEUDO MATERIAL BIBLIOTECA', 2, '$_user', '$_fech');";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			unset($_POST["cta"]);
			unset($_POST["fech"]);
			unset($_POST["mto"]);
			
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
	} else{
	//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		session_unset();
		session_destroy();
		unset($_POST);
		header("Location: ../");
	}
?>