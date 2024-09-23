<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
include_once("conex.php");


//FUNCION PARA EVITAR EL GUARDADO DE INFORMACIÓN EN CACHE.
	function noCache() {
		//EL CACHE EXPIRA EN UNA FECHA PASADA
		header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
		//LA FECHA DE LA ULTIMA MODIFICACION ES LA ACTUAL
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		//NO GUARDA CACHE, TIENE QUE REVALIDAR LA PAGINA
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}

//FUNCIÓN PARA REGISTRAR EN BITACORA
	function regBita($cta, $plan, $oper, $result){
		//SOLICITAMOS LA OPERACION QUE SE VA A REALIZAR:
		//A = ALTA
		//B = BAJA
		//I = ACCESO AL SISTEMA
		//O = SALIDA DEL SISTEMA
		//F = FINALIZAR INSCRIPCION
		//EL ESTATUS DE LA OPERACION : ERROR ó EXITO
		//VERIFICAMOS QUE HAYA UNA SESSION ACTIVA
		$ctaPlan = $cta.$plan;
		$fecha = date("d-m-Y H:i:s"); //FECHA TIPO: "1999-12-31 23:59:59" 
		$ip = getIP(); //IP DE LA MAQUINA DEL USUARIO
		
		$conex = conex("p400");
		if(!$conex){
			echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
			exit;
		} else {
			$sentencia = "INSERT INTO bitacora(cve_cuenta_plan, fecha, ip, operacion, resultado, semestre) VALUES ('$ctaPlan', '$fecha', '$ip', '$oper', '$result', (SELECT cve_sem FROM semestre WHERE id_sem = (SELECT max(id_sem) FROM semestre WHERE activo)));";
			$ex = pg_query($sentencia) or die('eL REGISTRO EN BITACORA FALLO: ' . pg_last_error());
			closeConex($ex, $conex);
		}
		
	}
		
//FUNCION PARA LIMPIAR LAS VARIABLES DE POSIBLE CONTENIDO NO DESEADO 
//COMO INYECCION SQL O CROSS ACTION SCRIPT (XSS)
	function limpiarVariable($entrada) {
	
		$busqueda = array(
			'@<script[^>]*?>.*?</script>@si', // javascript
			'@<[\/\!]*?[^<>]*?>@si', // HTML
			'@<style[^>]*?>.*?</style>@siU', // Css
			'@<![\s\S]*?--[ \t\n\r]*>@' // Comentarios multiples
			//''
		);
		
		return preg_replace($busqueda, '', $entrada);
	}
	
//FUNCION QUE DEVUELVE LA IP DE LA MAQUINA CLIENTE
	function getIP() {
		if (isset($_SERVER["HTTP_CLIENT_IP"])){
			return $_SERVER["HTTP_CLIENT_IP"];
		} elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
			return $_SERVER["HTTP_X_FORWARDED"];
		} /*elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		}*/ elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
			return $_SERVER["HTTP_FORWARDED_FOR"];
		} elseif (isset($_SERVER["HTTP_FORWARDED"])){
			return $_SERVER["HTTP_FORWARDED"];
		} else {
			return $_SERVER["REMOTE_ADDR"];
		}
	}
	
//FUNCION PARA ACTUALIZAR LA CONTRASEÑA EN LO SERVIDORES DE INSCRIPCION
function updateContra($contra, $cuenta){
/**/	if(false)
{
		//$cnx40 = conex40('inscripciones');
		$cnx41 = conex41('inscripciones');
		//$cnx43 = conex43('inscripciones');
		//$cnx44 = conex44('inscripciones');
	
		//VERIFICAMOS QUE LAS CONEXIONES SE HAYAN REALIZADO CORRECTAMENTE
		if(!$cnx41)
		{
			echo json_encode("ERROR DE CONEXI&Oacute;N: SERV-40".pg_last_error()); exit;
		}/*else if(!$cnx41)
		{
			echo json_encode("ERROR DE CONEXI&Oacute;N: SERV-41".pg_last_error()); exit;
		} else if(!$cnx43)
		{
			echo json_encode("ERROR DE CONEXI&Oacute;N: SERV-43".pg_last_error()); exit;
		} else if(!$cnx44)
		{
			echo json_encode("ERROR DE CONEXI&Oacute;N: SERV-44".pg_last_error()); exit;
		}*/ 
		else 
		{
			$sentencia1 = "UPDATE alumno SET password = md5('$contra') WHERE id = substring('$cuenta' FROM 1 FOR 9);";

			//SENTENCIA SOBRE EL SERVIDOR 40
			$ex41 = pg_query($cnx41, $sentencia1) or die("LA ACTUALIZACION EN SERVIDOR 41 FALLO: ".pg_last_error());

			//SENTENCIA SOBRE EL SERVIDOR 41
/*			
			$sentencia_2 = "UPDATE alumno SET password = md5('$contra') WHERE id = substring('$cuenta',1,9) and email_dominio is null";
			$ex41 = pg_query($cnx41, $sentencia_2); //actualiza contraseña si no tiene @aragon


			$sentencia_3 = "UPDATE alumno a SET email = resp.correo 
							FROM (SELECT * FROM dblink('host=132.248.44.208 user=escolares password=4l3xdun dbname=p400',
							'select cuenta, email from domi where cuenta=''$cuenta'' ')
							as r(cuenta text, correo text))as resp
							WHERE a.id=resp.cuenta 
							AND cuenta ='$cuenta'; ";

			$ex41 = pg_query($cnx41, $sentencia_3) ; //actualiza correo 
*/
			//SENTENCIA SOBRE EL SERVIDOR 43
			//$ex43 = pg_query($cnx43, $sentencia) or die("LA CONSULTA FALLO: ".pg_last_error()." 43");
			//SENTENCIA SOBRE EL SERVIDOR 44
			//$ex44 = pg_query($cnx44, $sentencia) or die("LA CONSULTA FALLO: ".pg_last_error()." 44");
			
			if( pg_affected_rows ($ex41) > 0 /*or 
				pg_affected_rows ($ex41) > 0 or 
				pg_affected_rows ($ex43) > 0 or 
				pg_affected_rows ($ex44) > 0*/)
			{
				closeConex($ex41, $cnx41);
				//closeConex($ex41, $cnx41);
				//closeConex($ex43, $cnx43);
				//closeConex($ex44, $cnx44);
				return true;
			} else {
				closeConex($ex41, $cnx41);
				//closeConex($ex41, $cnx41);
				//closeConex($ex43, $cnx43);
				//closeConex($ex44, $cnx44);
				return false;
			}
		}
	}
}


//FUNCION GENERAL PARA ENVIAR UN CORREO ELECTRONICO
	function correoElec($destinatario, $asunto, $mensaje){
		//SE DEFINE EL FORMATO GENERAL PARA EL CORREO ELECTRONICO
		$msj = "<html>
					<head>
						<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
						<title>Servicios Escolares F.E.S. Arag&oacute;n</title> 
					</head> 
					<body style=\"font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;font-size:16px; background-color: #f2f8fe; \">
						<div id=\"wrapper\" style=\"width: 850px; margin: auto; border: solid 2px #265795; border-radius: 5px; \">
							<div id=\"header\" style=\"color: #fff; text-align: center; font-size: 18px; font-weight: 900; padding: 5px 15px; background-color: #265795;\"> 
								<table style=\"width: 100%\">
									<tbody>
										<tr>
											<td>
												<img src=\"http://aragon.dgae.unam.mx/imgs/unam_blanco.gif\" height=\"90px\" alt=\"unam\" title=\"unam\" />
											</td>
											<td>
												UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO <br />
												FACULTAD DE ESTUDIOS SUPERIORES ARAG&Oacute;N <br />
												DEPARTAMENTO DE SERVICIOS ESCOLARES ARAG&Oacute;N
											</td>
											<td>
												<img src=\"http://aragon.dgae.unam.mx/imgs/Logos-FES-blanco.gif\" height=\"90px\" style=\"margin:-15px;\" alt=\"FESAragon\" title=\"FESAragon\" />
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div id=\"content\" style=\"padding: 15px 25px; background-color: #eee;\">
								<div style=\"padding: 1px; text-align: justify;\">";
			//--------------------------------------------------------------------------------------------------------------------------------
			//--------------------------------------------------------------------------------------------------------------------------------
			//SE AGREGA EL MENSAJE CON EL FORMATO HTML NECESARIO
			$msj .= $mensaje;
			//--------------------------------------------------------------------------------------------------------------------------------
			//--------------------------------------------------------------------------------------------------------------------------------
			$msj .= "		</div> 
								<p style=\"text-align: center; font-weight: 600;\">
									 ATENTAMENTE: <br /> 
									\"POR MI RAZA HABLAR&Aacute; EL ESP&Iacute;RITU\" <br />
									Nezahualcoyotl, Estado de M&eacute;xico 
								</p> 
							</div> 
							<div id=\"footer\" style=\"color: #fff; font-size: 16px; padding: 3px; border-top: solid 10px #EAC117; background-color: #B39312;\"> 
								<p style=\"font-weight: 700; text-align: right;\">
									Contacto: serviciosescolares@aragon.unam.mx <br />
									Tel.: 56-23-10-66 &oacute; 56-23-10-05 <br />
									Web: http://aragon.dgae.unam.mx 
								</p> 
							</div> 
						</div> 
					</body> 
				</html>";
		
		//SE AGREGAN LAS CABECERAS NECESARIAS PARA HACER LLEGAR EL CORREO
		$cabeceras = "From: Servicios Escolares Aragon <dudasinscripciones@hotmail.com>\r\n".
					"MIME-Version: 1.0\r\n".
					"Return-path: <dudasinscripciones@hotmail.com>\r\n".
					"Content-type: text/html; charset=utf-8";
					
					
		//SE RETORNA EL VALOR PROPORCIONADO POR LA FUNCION mail()
		//RETORNA true SI SE HA ENVIADO CORRECTAMENTE EL CORREO ELECTRONICO, EN OTRO CASO RETORNA false
		//
		//NOTA: ESTA FUNCION .::NO::. VERIFICA SI EL CORREO ELECTRONICO FUE RECIBIDO CORRECTAMENTE
		//SOLO QUE HAYA PODIDO SALIR CORRECTAMENTE DESDE EL SERVIDOR		
		return mail($destinatario, utf8_decode($asunto), $msj, $cabeceras);
		
	}
?>
