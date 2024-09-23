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
	
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
	if(isset($_SESSION)
	&& isset($_SESSION["usrAdmin"]) 
	&& isset($_POST) 
	&& isset($_POST["cta"])){
		
		$conex = conex("p400");
		
		if(!$conex){
			echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
			exit;
		} else {
			$cta = $_POST["cta"];
			if (substr($cta,0,1) > '4')	{
				$cta = "0".substr($cta, 0, 8);
			}
			$usr = $_SESSION["usrAdmin"];
			$fch = date("dmY");
			$resp = NULL;
			
			$sentencia = "SELECT count(a.*) 
						FROM credencial AS a
						JOIN semestre AS b ON a.semestre = b.cve_sem 
						WHERE a.cuenta = '$cta' 
						AND a.fenvio IS NULL 
						AND a.uenvio IS NULL 
						AND a.frecibe IS NULL 
						AND a.urecibe IS NULL 
						AND a.fentrega IS NULL 
						AND a.uentrega IS NULL
						AND b.cve_sem = (SELECT max(cve_sem) FROM semestre WHERE activo);";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			$credPend = intval(pg_fetch_result($ex, 0, 0));//OBTENEMOS EL NUMERO DE TRAMITES PENCIENTES DEL ALUMNO
			
			if($credPend > 0){
				$sentencia = "UPDATE credencial 
							SET fenvio = '$fch', 
								uenvio = '$usr', 
								frecibe = '$fch', 
								urecibe	= '$usr'
							WHERE cuenta = '$cta'
							AND semestre = (SELECT max(cve_sem) FROM semestre WHERE activo)
							AND fenvio IS NULL 
							AND uenvio IS NULL 
							AND frecibe IS NULL 
							AND urecibe IS NULL 
							AND fentrega IS NULL 
							AND uentrega IS NULL;";
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				if(pg_affected_rows($ex) > 0){
					$resp = "C";//LA ACTUALIZACION FUE REALIZADA CON EXITO
				} else {
					$resp = "B";//NO SE PUDO REALIZAR LA ACTUALIZACION; ERROR AL REALIZAR LA CONSULTA
				}
			} else {
				$resp = "A";//NO HAY TRAMITES PENDIENTES EN EL SEMESTRE ACTUAL
			}
		}
		
		closeConex($ex, $conex);//CERRAMOS LA CONEXION A LA BDD
		echo json_encode($resp);//INFORMAMOS EL RESULTADO OBTENIDO
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
	} else {
		//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		session_unset();
		session_destroy();
		header("Location: ../../");
	}
?>