<?php
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	
	//INICIAMOS/VERIFICAMOS UNA SESION
	session_start();
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
	if(isset($_POST)
		and isset($_POST["cta"])
		and isset($_POST["cons"])
		and isset($_SESSION)
		and isset($_SESSION["usrBib"])){
		//VERIFICAMOS QUE EL NUMERO DE CUENTA EXISTA
		$conex = conex("p400");//SE CREA LA CONEXION A LA BDD
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$_cta = substr($_POST["cta"], 0, 9);
			$sentencia = "SELECT cuenta = '$_cta' FROM domi WHERE cuenta = '$_cta';";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$resp = pg_fetch_array($ex, NULL, PGSQL_NUM);
			//VERIFICAMOS SI EL NUMERO DE CUENTA EXISTE...
			unset($_POST["cta"]);
			unset($_POST["cons"]);
			if($resp[0] == "f"){
				closeConex($ex, $conex);//CERRAMOS LA CONEXION,
				echo json_encode(false);//Y SE MANDA UN ESTATUS DE FALSO
			} else {
				$sentencia = "SELECT a.id_addo AS \"I\",  
				CASE WHEN a.activo = TRUE THEN 'PENDIENTE' ELSE 'SALDADO' END AS \"P\", 
				a.fechaadc AS \"FR\", 
				a.fechapag AS \"FP\", 
				a.mto_addo AS \"M\"
				FROM adeudo AS a, tipoAddo AS t
				WHERE a.fk_tipo_addo = t.id_tipo_addo 
				AND a.fk_tipo_addo = 2 ".//ADEUDOS DE BIBLIOTECA
				"AND a.cuenta = '$_cta' 
				ORDER BY a.id_addo DESC;";
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$addoBib = array();
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$addoBib[] = $resp;
				}
				closeConex($ex, $conex);
				
				//DESTRUIMOS LAS VARIABLES Y CERRAMOS LA CONEXION
				unset($_POST["cta"]);
				unset($_POST["cons"]);
				
				//ENVIAMOS LOS DATOS OBTENIDOS DE LA BDD.
				echo json_encode($addoBib);
			}
		}
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------		
	} else if(isset($_POST)
		and isset($_POST["cta"])
		and isset($_POST["idAddo"])
		and isset($_SESSION)
		and isset($_SESSION["usrBib"])){
		//QUITAMOS EL ADEUDO DEL ALUMNO
		$conex = conex("p400");//SE CREA LA CONEXION A LA BDD
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$_cta = substr($_POST["cta"], 0, 9);
			$idAddo = $_POST["idAddo"];
			$sentencia = "UPDATE adeudo 
						SET activo = FALSE, 
						fechapag = now()
						WHERE cuenta = '$_cta' AND 
						id_addo = $idAddo 
						AND fk_tipo_addo = 2;";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			//VERIFICAMOS SI SE REALIZO EL CAMBIO...
			if(pg_affected_rows($ex) > 0){
				//INFORMAMOS QUE EL CAMBIO NO FUE REALIZADO.
				closeConex($ex, $conex);
				echo json_encode(true);
			} else {
				//INFORMAMOS QUE EL CAMBIO NO FUE REALIZADO.
				closeConex($ex, $conex);
				echo json_encode(false);
			}
		}
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------
	} else {
		//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		session_unset();
		session_destroy();
		unset($_POST);
		header("Location: ../");
	}
?>