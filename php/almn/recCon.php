<?php
	//ini_set('display_errors', 1);
//	error_reporting(E_ALL);
	include_once("../noCache.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	if(isset($_POST) && 
		isset($_POST["usr"]) && 
		isset($_POST["fNac"])){
			
		$cta = $_POST["usr"];
		$fNac = $_POST["fNac"];
		$conex = conex("p400");
		
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "SELECT ".
						"(d.cuenta = substring('$cta' FROM 1 FOR 9)) AS cue, ".
						"(d.fechnac = substring('$fNac' FROM 1 FOR 8)) AS usr, ".
						"d.email, ".
						"(d.paterno|| ' ' || d.materno|| ', ' || d.nombres) AS noms, ".
						"c.nombre, ".
						"d.contra ".
						"FROM domi AS d, carrera AS c, diralum AS dr ".
						"WHERE d.cuenta = dr.cuenta ".
						"AND dr.cuenta = substring('$cta' FROM 1 FOR 9) ".
						"AND d.cuenta =  substring('$cta' FROM 1 FOR 9) ".
						"AND dr.carr = c.carr ".
						"ORDER BY cue DESC;";
			
			$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
			while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
				 $okCta =  $resp[0];
				 $okFn = $resp[1];
				 $destinatario = $resp[2];
				 $noms = $resp[3];
				 $carr = $resp[4];
				 $contra = $resp[5];
			}
			closeConex($ex, $conex);
			//SE CIERRA LA CONEXION A LA BASE DE DATOS
			
			
			if( $okFn == "f"){
				//SI LA FECHA DE NACIMINETO ES INCORRECTA
				echo json_encode("-2");
			} elseif($contra == ''){
				//SI LA CONTRASEÑA ESTA VACIA
				echo json_encode("-1");
			} else {
				//SI LOS DATOS SON CORRECTOS
				$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
				$meses = array("Enero","Febrero","Marzo","Abril",
								"Mayo","Junio","Julio","Agosto",
								"Septiembre","Octubre","Noviembre","Diciembre");
				
 
				$hoy = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y')." a las ".date("H:i:s A");
				$asunto = "Recuperación de Contraseña Aragón-DGAE UNAM";
				$mensaje = "<html> <head> <title> Recuperaci&oacute;n de Contraseña. </title> </head> ".
							"<body style=\"font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif;font-size:16px; background-color: #f2f8fe; \">".
							"<div id=\"wrapper\" style=\"width: 600px; margin: auto; border: solid 2px #265795; border-radius: 5px; \">".
							"<div id=\"header\" style=\"color: #fff; text-align: center; font-size: 18px; font-weight: 900; padding: 15px 5px; background-color: #265795; \"> ".
							"UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO <br />".
							"FACULTAD DE ESTUDIOS SUPERIORES ARAG&Oacute;N <br />".
							"DEPARTAMENTO DE SERVICIOS ESCOLARES ARAG&Oacute;N </div>".
							"<div id=\"content\" style=\"padding: 15px 25px; background-color: #eee;\">".
							"<div style=\" padding: 1px; text-align: justify;\">Se envía este correo con base en la petición de recuperación de contraseña solicitada: <br />".
							"el d&iacute;a <b>".$hoy.".</b> <br />".
							"para el alumno: <b>".$noms."</b> <br />".
							"con n&uacute;mero de cuenta: <b>".$cta."</b> <br /> ".
							"de la carrera de: <b>".$carr." </b> <br /> <br /> ".
							"<b style=\"font-size: 22px;\"> Contraseña:&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities($contra)." </b> <br /> <br /> <br /> ".
							"</div> <p style=\"text-align: center; font-weight: 600;\"> ATENTAMENTE: <br /> ".
							"\"POR MI RAZA HABLAR&Aacute; EL ESP&Iacute;RITU\" <br /> ".
							"Nezahualcoyotl, Estado de México </p> </div> ".
							"<div id=\"footer\" style=\"color: #fff; font-size: 14px; padding: 3px; border-top: solid 10px #EAC117; background-color: #B39312;\"> <p style=\"font-weight: 600; text-align: right;\">".
							"Contacto: dudasinscripciones@hotmail.com <br />".
							"Tel.: 56-23-10-66 &oacute; 56-23-10-05<br />".
							"Web: http://aragon.dgae.unam.mx ".
							" </p> </div> </div> </body> </html>";
				//$message = "hola";
				$cabeceras = "From: Servicios Escolares Aragon <dudasinscripciones@hotmail.com>\r\n";
				$cabeceras .= "MIME-Version: 1.0\r\n";
				$cabeceras .= "Content-type: text/html; charset=utf-8";
				//SE ENVIA EL MENSAJE
				if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
					//SE AUMENTA UN CONTADOR PARA CONOCER EL NUMERO DE VECES
					//QUE SE HA UTILIZADO EL SCRIPT
						$conex = $conex = conex("newP400");
						$sentencia = "UPDATE cambios_contra ".
						"SET num_cambios = (num_cambios + 1), ".
						"ultimo_cambio = now();";
						$ex = pg_query($sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
						closeConex($ex, $conex);
					//-------------------------------------------------------------------------
					//@updateContra($contra, $cta);
					echo json_encode($destinatario);
				} else {
					echo json_encode("1");
				}
			}
		}
	} else {
		//SI LAS VARIABLES NO EXISTEN...
		unset($_POST["usr"]);
		unset($_POST["fNac"]);
		echo json_encode("Error de conexi&oacute;n con el servidor.");
	}
?>