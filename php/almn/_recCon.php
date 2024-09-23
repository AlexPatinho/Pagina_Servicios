<?php
	//ini_set('display_errors', 1);
//	error_reporting(E_ALL);
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
	if(isset($_POST)
	&& isset($_POST["usr"])
	&& isset($_POST["fNac"])
	&& isset($_POST["email"])){
			
		$cta = substr($_POST["usr"], 0, 9);
		$fNac = $_POST["fNac"];
		$email = $_POST["email"];
		$conex = conex("p400");
		
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "SELECT (d.fechnac = substring('$fNac' FROM 1 FOR 8)) AS usr, 
						CASE WHEN (d.email IS NULL OR d.email = '') THEN FALSE ELSE TRUE END AS nnEmail, 
						d.email ILIKE '$email' AS ema, 
						CASE WHEN (d.nip5 IS NULL OR d.nip5 = '') THEN FALSE ELSE TRUE END AS nip5, 
						d.nip5, 
						d.email, 
						(d.paterno|| ' ' || d.materno|| ', ' || d.nombres) AS noms, 
						c.nombre 
						FROM domi AS d JOIN diralum AS dr ON d.cuenta = dr.cuenta 
						JOIN carrera AS c ON dr.carr = c.carr 
						WHERE d.cuenta = '$cta' 
						AND dr.exa IS NULL;";
			
			$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
			//SI EL NUMERO DE CUENTA EXISTE...
			if(pg_num_rows($ex) > 0){
				while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
					 $okFn = $resp[0];//VALIDA FECHA DE NACIMIENTO
					 $notNullEmail = $resp[1];//VALIDA QUE EL CORREO ELECTRONICO NO SEA NULO
					 $okEmail = $resp[2];//VALIDA QUE EL CORREO ELECTRONICO SEA EL REGISTRADO
					 $okPass = $resp[3];//VALIDA SI EL MD5 DE LA CONTRASEÑA ES O NO NULO
					 $oldPass = $resp[4];//MD5 DE LA CONTRASEÑA ANTERIOR
					 $destinatario = $resp[5];//CORRERO ELECTRONICO DEL ALUMNO
					 $noms = $resp[6];//NOMBRE COMPLETO DEL ALUMNO
					 $carr = $resp[7];//CARRERA ACTIVA DEL ALUMNO
				}
				closeConex($ex, $conex);
				//SE CIERRA LA CONEXION A LA BASE DE DATOS
				
				if(strtotime(substr($oldPass, 0, 20))){
					//SI LOS PRIMEROS 20 CARACTERES DEL PASSWORD ANTERIOR SE VALIDAN COMO FECHA
					echo json_encode("1");
				} else if($notNullEmail == "f"){
					//SI NO SE TIENE REGISTRADO UN CORREO ELECTRONICO
					echo json_encode("-1");
				}else if($okFn == "f"){
					//SI LA FECHA DE NACIMINETO ES INCORRECTA
					echo json_encode("-2");
				} else if($okPass == "f"){
					//SI LA CONTRASEÑA ESTA VACIA
					echo json_encode("-1");
				} else if($okEmail == "f"){
					//SI EL CORREO ELECTRONICO ES INCORRECTO
					echo json_encode("0");
				} else {
					//SI LOS DATOS SON CORRECTOS
					$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
					$meses = array("Enero","Febrero","Marzo","Abril",
									"Mayo","Junio","Julio","Agosto",
									"Septiembre","Octubre","Noviembre","Diciembre");
					
	 
					$hoy = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y')." a las ".date("H:i:s A");
					/**************************************************************************/
					/**************************************************************************/
					//VALORES QUE SE ENVIARAN POR CORREO AL ALUMNO
					
					$dt = date("Y-m-d H:m:s");
					//FECHA Y HORA ACTUAL
					$cr = strrev($cta);
					//STRING INVERTIDO DEL NUMERO DE CUENTA
					$ch = substr(md5($cta), 0, 5).substr(md5($cta), -5);
					//5 PRIMEROS Y 5 ULTIMOS CARACTERES DEL MD5 DEL NUMERO DE CUENTA
					$fh = substr(md5($fNac), 0, 5).substr(md5($fNac), -5);
					//5 PRIMEROS Y 5 ULTIMOS CARACTERES DEL MD5 DE LA FECHA DE NACIMIENTO
					$ph = substr($oldPass, 0, 3).substr($oldPass, 8, 3).substr($oldPass, 16, 3).substr($oldPass, 24, 3);
					//CONTIENE SECCIONES DEL MD5 DE LA CONTRASEÑA ANTIGUA EN GRUPOS DE 3 CARACTERES
					
					/**************************************************************************/
					$liga = "http://aragon.dgae.unam.mx/php/almn/_recCon.php?".
							"dt=".strtotime($dt).//CONVERTIMOS LA FECHA A MILISEGUNDOS
							"&cr=".$cr.
							"&ch=".$ch.
							"&fh=".$fh.
							"&ph=".$ph;
					
					/**************************************************************************/
					
					$conex = conex("p400");
					$sentencia = "UPDATE DOMI SET nip5 = '$dt $ph' WHERE cuenta = '$cta';";
					$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
					
					/**************************************************************************/
					if(pg_affected_rows($ex) < 1){
					//if(false){
						//SI NO SE AFECTARON COLUMNAS
						closeConex($ex, $conex);//SE CIERRA LA CONEXION
						echo json_encode("-1");
					} else {
						closeConex($ex, $conex);//SE CIERRA LA CONEXION
						/**************************************************************************/
						/**************************************************************************/
						$asunto = "Recuperación de Contraseña Aragón-DGAE UNAM";
						
						$mensaje =	"				<div style=\"padding: 1px; text-align: justify;\">
														Se env&iacute;a este correo con base en la petici&oacute;n de cambio de contrase&ntilde;a solicitada: <br />
														el d&iacute;a <b>".$hoy.".</b> <br />
														para el alumno: <b>".$noms."</b> <br />
														con n&uacute;mero de cuenta: <b> ".$cta." </b> <br />
														de la carrera de: <b>".$carr." </b> <br /> <br /> 
														<b style=\"color: #C00;\"> 
															POR FAVOR DE CLICK EN LA SIGUIENTE LIGA, O C&Oacute;PIELA Y P&Eacute;GUELA EN LA BARRA DE DIRECCIONES DE SU NAVEGADOR DE INTERNET PARA REALIZAR EL CAMBIO DE CONTRASE&Ntilde;A. 
														</b> <br /> <br /> 
														<div style=\"overflow: auto; font-weight: 900;\">
															<a href=\"".$liga."\">".$liga."</a> 
														</div>
														<br /> <br /> <br /> 
													</div>";
						$cabeceras = "From: Servicios Escolares Aragon <dudasinscripciones@hotmail.com>\r\n";
						$cabeceras .= "MIME-Version: 1.0\r\n";
						$cabeceras .= "Return-path: <dudasinscripciones@hotmail.com>\r\n";
						$cabeceras .= "Content-type: text/html; charset=utf-8";
						
						//SE ENVIA EL CORREO ELECTRONICO
						if (correoElec($destinatario, $asunto, $mensaje)) {
						//if(TRUE){
							//SE ENVIA EL CORREO A LA DIRECCION QUE FUE REGISTRADA
							echo json_encode($destinatario);
							//echo json_encode($cabeceras);
						} else {
							//EL CORREO ELECTRONICO NO PUDO SER ENVIADO
							echo json_encode("1");
						}
					}
				}
			} else {
				//SI EL NUMERO DE CUENTA NO EXISTE SE INFORMA
				closeConex($ex, $conex);//SE CIERRA LA CONEXION
				echo json_encode("-1");
			}
		}
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
	}else if(isset($_GET)
	and isset($_GET["dt"]) and !is_null($_GET["dt"])
	and isset($_GET["cr"]) and !is_null($_GET["cr"])
	and isset($_GET["ch"]) and !is_null($_GET["ch"])
	and isset($_GET["fh"]) and !is_null($_GET["fh"])
	and isset($_GET["ph"]) and !is_null($_GET["ph"])){
		
		$dt = $_GET["dt"];//FECHA EN MILISEGUNDOS
		$cr = $_GET["cr"];//STRING INVERTIDO DEL NUMERO DE CUENTA
		$ch = $_GET["ch"];//5 PRIMEROS Y 5 ULTIMOS CARACTERES DEL MD5 DEL NUMERO DE CUENTA
		$fh = $_GET["fh"];//5 PRIMEROS Y 5 ULTIMOS CARACTERES DEL MD5 DE LA FECHA DE NACIMIENTO
		$ph = $_GET["ph"];//CONTIENE SECCIONES DEL MD5 DE LA CONTRASEÑA ANTIGUA EN GRUPOS DE 3 CARACTERES
		
		if((time() - 86400)< $dt){//SI LA FECHA ACTUAL ES AL MENOS 24 HORAS MAYOR QUE LA FECHA DE SOLICITUD
			$conex = $conex = conex("p400");
			$sentencia = "SELECT cuenta, fechnac, contra , nip5
							FROM domi WHERE cuenta = '".substr(strrev($cr), 0, 9)."';";
			$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
			if(pg_num_rows($ex) > 0){//SI EL NUMERO DE CUENTA EXISTE
				//---
				$cta = "";
				$fNac = "";
				$ctr = "";
				$nip5 = "";
				
				while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
					 $cta = $resp[0];//NUMERO DE CUENTA EN LA BDD
					 $fNac = $resp[1];//FECHA DE NACIMIENTO
					 $ctr = $resp[2];//CONTRASEÑA EN TEXTO PLANO
					 $nip5 = $resp[3];//VALORES ALMACENADOS EN EL CAMPO DE LA CONTRASEÑA
				}
				closeConex($ex, $conex);//SE CIERRA LA CONEXION
				if($dt == strtotime(substr($nip5, 0, 20))){
					//SE VERIFICA QUE LA FECHA DE LA LIGA SEA IGUAL A LA REGISTRADA
					$a = substr(md5($cta), 0, 5).substr(md5($cta), -5);
					$b = substr(md5($fNac), 0, 5).substr(md5($fNac), -5);
					$c = substr(md5($ctr), 0, 3).substr(md5($ctr), 8, 3).substr(md5($ctr), 16, 3).substr(md5($ctr), 24, 3);
					if($ch == $a and $fh == $b and $ph == $c){
						//SI LAS CLAVES ENVIADAS POR URL SON VALIDAS
						header("Location: ../../almn/_recCon.php?cta=".strrev($cr));
					} else {
						//ALGUNA DE LAS CLAVES ENVIADAS NO ES VALIDA
						header("Location: ../../almn/_recCon.php?nhss=".$ch."-".$fh."-".$ph);
					}
				} else {
					//LA FECHA DE SOLICITUD NO COINCIDE CON LA ENVIADA POR MEDIO DE LA LIGA
					header("Location: ../../almn/_recCon.php?td=".$dt."-".strtotime(substr($nip5, 0, 20)));
				}
			} else {
				//EL NUMERO DE CUENTA NO EXISTE
				closeConex($ex, $conex);//SE CIERRA LA CONEXION
				header("Location: ../../almn/_recCon.php?nc=".md5($cr));
			}
		} else {
			//HA PASADO MAS DE 1 DIA DESDE LA SOLICITUD DE CAMBIO DE CONTRASEÑA
			///*--------------------------------------------------------------------------------
			$conex = $conex = conex("p400");
			$sentencia = "UPDATE domi SET nip5 = MD5(contra) WHERE cuenta = '".strrev($cr)."';";
			//$sentencia = "UPDATE domi SET nip5 = MD5('') WHERE cuenta = '".strrev($cr)."';";
			//SE CAMBIA LA CONTRASEÑA POR LA CONTRASEÑA ANTERIOR
			$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
			closeConex($ex, $conex);//SE CIERRA LA CONEXION
			//--------------------------------------------------------------------------------*/
			header("Location: ../../almn/_recCon.php?nt=".$dt);
		}
		
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
	} else if(isset($_POST)
	and isset($_POST["cta"]) and !is_null($_POST["cta"])
	and isset($_POST["rPass"]) and !is_null($_POST["rPass"])){
		
		$cta = $_POST["cta"];
		$pass = $_POST["rPass"];
		
		$conex = conex("p400");
		$sentencia = "SELECT nip5 FROM domi WHERE cuenta = '$cta';";
		$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
		while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
			 $fech = $resp[0];//VALIDA FECHA DE NACIMIENTO
		}
		//SI LO SPRIMEROS 20 CARACTERES DEL MD5 DE LA CONTRASEÑA EN SISTEMA
		//SE VALIDASN COMO FECHA
		if(strtotime(substr($fech, 0, 20))){
			//$sentencia = "UPDATE domi SET nip5 = MD5('$pass'), contra = '$pass' WHERE cuenta = '$cta';";
			$sentencia = "UPDATE domi SET nip5 = MD5('$pass'), contra = '$pass', nip = '$pass' WHERE cuenta = '$cta';";
			$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
			
			$aux = 'ola';
			if(pg_affected_rows($ex) > 0){
				//EL CAMBIO DE CONTRASEÑA SE REALIZO CORRECTAMENTE
				@updateContra($pass, $cta);//SE ACTUALIZA LA CONTRASEÑA EN TODOS LOS SERVIDORES
				$aux = 2;
			} else {
				//EL CAMBIO DE CONTRASEÑA NO SE PUDO REALIZAR
				$aux = 1;
			}
		} else {
			//LA CONTRASEÑA YA FUE CAMBIADA, EL LINK ES INVALIDO
			$aux = 0;
		}
		
		
		closeConex($ex, $conex);//SE CIERRA LA CONEXION
		echo $aux;
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
	} else {
		//SI LAS VARIABLES NO EXISTEN...
		unset($_POST);
		unset($_GET);
		echo json_encode("Error de conexi&oacute;n con el servidor.");
	}
?>