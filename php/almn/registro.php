<?php
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	
	//SE VALIDA LA URL QUE SE ENVIA AL CORREO DE ALUMNO.
	if(isset($_GET) and 
		isset($_GET["tt"]) and 
		isset($_GET["rt"]) and 
		isset($_GET["cc"]) and 
		isset($_GET["nc"]) and 
		isset($_GET["fr"])){
			
		$_tt = $_GET["tt"];// 10 PRIMEROS DIGITOS DEL MD5 DEL NUMERO DE CUENTA
		$_rt = $_GET["rt"];// 10 PRIMEROS DIGITOS DEL MD5 DEL NUMERO DE CUENTA AL REVEZ EJ.: '123456789' > '987654321'.
		$_cc = $_GET["cc"];// 10 PRIMEROS DIGITOS DEL MD5 DE LA CONTRASEÑA AL REVEZ.
		$_nc = $_GET["nc"];// 9 DIGITOS DEL NUMERO DE CUENTA AL REVEZ EJ '123456789' > '987654321'.
		$_tiempo1 = $_GET["fr"];// FECHA EN MILISEGUNDOS DE CUANDO SE REALIZO LA SOLIDITUD DE REGISTRO.
		$_tiempo2 = $_tiempo1 + 86400;// FECHA EN MILISEGUNDOS 24HRS SUPERIOR AL LA FECHA DE SOLICITUD DE REGISTRO.
		date_default_timezone_set("America/Mexico_City");// SE CONFIGURA LA ZONA HORARIA PARA LA CIUDAD DE MEXICO.
		$_ahora = time();//FECHA ACTUAL DEL SISTEMA EN MILISEGUNDOS.
		
		$conex = conex("p400");
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "SELECT cuenta AS \"CTA\", ".
				"contra AS \"NIP\", ".
				"email as \"EM\" ".
				"FROM domi ".
				"WHERE cuenta = substring('".strrev($_nc)."' FROM 1 FOR 9);";
	
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				
			if (pg_num_rows($ex) < 1){//EL NUMERO DE CUENTA NO EXISTE EN LA BDD
				closeConex($ex, $conex);
				header("Location: http://aragon.dgae.unam.mx/almn/registro.php?t=".substr(strrev($_nc), 0, 9));
			} else {
				while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
					$_cta = $resp[0];
					$_nip = $resp[1];
					$_email = $resp[2];
				}
										
				if(strpos($_email, "#") !== false){//EL REGISTRO NO SE HA COMPLETADO
					if($_tt === substr(md5($_cta), 0,10)){//COINCIDEN LOS HASH DE CUENTA
						if($_rt === substr(md5(strrev($_cta)), 0,10)){//COINCIDEN LOS HASH DE CUENTA AL REVEZ
							if($_cc === substr(md5(strrev($_nip)), 0, 10)){//COINCIDEN LOS HASH DE CONTRASEÑA
								if($_nc === strrev($_cta)){//COINCIDE EL NUMERO DE CUENTA
								//VALIDAMOS QUE EL LINK NO TENGA MAS DE 24 HORAS DE HABER SIDO GENERADO
									if($_ahora > $_tiempo1){
										if($_ahora < $_tiempo2){
											$_email = substr($_email, 0, strpos($_email, "#"))."@".substr($_email, (strpos($_email, "#") + 1));
											//SE ACTUALIZAN LOS DATOS DEL ALUMNO.
											$sentencia = "UPDATE domi ".
													"SET nip5 = md5(contra), ".
													"email = substring('$_email' FROM 1 FOR 45) ".
													"WHERE cuenta = substring('$_cta' FROM 1 FOR 9);";
													
											$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
											closeConex($ex, $conex);
											header("Location: http://aragon.dgae.unam.mx/almn/registro.php?t=".$_cta);
											//------------------------------------------------------------------
										} else {//SI LA LIGA TIENE MAS DE 24HRS DE HABERSE GENERADO...
										//SE ELIMINAN LOS DATOS QUE SE HAYAN INGRESADO.
										$sentencia = "UPDATE domi ".
											"SET nip5 = NULL, ".
											"contra = NULL, ".
											"nip = NULL, ".
											"email = NULL ".
											"WHERE cuenta = substring('".strrev($_nc)."' FROM 1 FOR 9);";
											
										$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: '.pg_last_error());
										closeConex($ex, $conex);
										header("Location: http://aragon.dgae.unam.mx/almn/registro.php?f=".
										date("YmdGis", $_tiempo1));//fecha mayor al rango de 24 horas
										}
									} else {//SI LA FECHA DE LA LIGA ES ANTERIOR A LA FECHA DE SOLICITUD...
										//SE ELIMINAN LOS DATOS QUE SE HAYAN INGRESADO.
										$sentencia = "UPDATE domi ".
											"SET nip5 = NULL, ".
											"contra = NULL, ".
											"nip = NULL, ".
											"email = NULL ".
											"WHERE cuenta = substring('".strrev($_nc)."' FROM 1 FOR 9);";
											
										$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: '.pg_last_error());
										closeConex($ex, $conex);
										header("Location: http://aragon.dgae.unam.mx/almn/registro.php?f=".
										date("YmdGis", $_tiempo1));//fecha por debajo deL TIEMPO
									}
								} else {
									closeConex($ex, $conex);
									header("Location: http://aragon.dgae.unam.mx/almn/registro.php?t=w".
									substr(md5(strrev($_nc)), 0, 8));
								}
							} else {
								closeConex($ex, $conex);
								header("Location: http://aragon.dgae.unam.mx/almn/registro.php?t=z".
								substr(md5(strrev($_nc)), 0, 8));
							}
						} else {
							//EL NUMERO DE CUENTA NO EXISTE EN LA BDD
							closeConex($ex, $conex);
							header("Location: http://aragon.dgae.unam.mx/almn/registro.php?t=y".
							substr(md5(strrev($_nc)), 0, 8));
						}
					} else {
						//EL NUMERO DE CUENTA NO EXISTE EN LA BDD
						closeConex($ex, $conex);
						header("Location: http://aragon.dgae.unam.mx/almn/registro.php?t=x".
						substr(md5(strrev($_nc)), 0, 8));
					}	
				} else {
					//EL NUMERO YA SE REGISTRO EN LA BDD
					closeConex($ex, $conex);
					header("Location: http://aragon.dgae.unam.mx/almn/registro.php?reg=a".strpos($_email, "#"));
				}
			}
		}
//------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------
//SE VERIFICA QUE LOS DATOS REQUERIDOS SEAN NULOS PARA PODER ACTIVAR LA CUENTA.
	} else if(isset($_POST) && 
			isset($_POST["cta"]) && 
			isset($_POST["fnac"])){
				
		sleep(1);
		$_cta = $_POST["cta"];
		$_fnac = $_POST["fnac"];
		
		if($_cta == ''){
			echo json_encode("-3");
		}else if ($_fnac == ''){
			echo json_encode("-2");
		} else {
			//COMPARAMOS #CUENTA, FECHA NACIMIENTO, Y QUE LA CONTRASEÑA SEA NULA
			$sentencia = "SELECT cuenta = substring('$_cta' FROM 1 FOR 9) AS \"CTA\", ".
						"fechnac = substring('$_fnac' FROM 1 FOR 8) AS \"NAC\", ".
						"CASE WHEN (contra = '' OR contra IS NULL) THEN true ELSE false END AS \"OKCTR\", ".
						"CASE WHEN (nip5 = '' OR nip5 IS NULL) THEN true ELSE false END AS \"OKN5\", ".
						"email ilike '%#%' AS \"EMREG\" ".
						"FROM domi ".
						"WHERE cuenta = substring('$_cta' FROM 1 FOR 9);";
			
			$conex = conex("p400");
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			if (pg_num_rows($ex) < 1){
				closeConex($ex, $conex);
				//EL NUMERO DE CUENTA NO EXISTE EN LA BDD
				echo json_encode("A");
			} else {
				//SI EL NUMERO DE CUENTA EXISTE VACIAMOS LOS DATOS QUE REGRESA LA BDD
				while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
					 $_cta = $resp[0];
					 $_nac = $resp[1];
					 $_okctr = $resp[2];
					 $_okn5 = $resp[3];
					 $_emreg = $resp[4];
				}
				closeConex($ex, $conex);
				
				if($_cta == "f"){//EL #CUENTA ES INCORRECTO PERO EL REGISTRO COINCIDE CON FECHA DE NACIMIENTO
					unset($_POST["cta"]);
					unset($_POST["fnac"]);
					echo json_encode("B");
				} else if($_nac == "f"){//LA FECHA DE NACIMIENTO ES INCORRECTA
					unset($_POST["cta"]);
					unset($_POST["fnac"]);
					echo json_encode("C");
				} else if($_okctr == "f" and $_okn5 == "f"){//LA CONTRASEÑA NO ES NULA, POR LO TANTO EL USUARIO YA SE ENCUENTRA REGISTRADO
					unset($_POST["cta"]);
					unset($_POST["fnac"]);
					echo json_encode("D");
				} else if($_emreg == "t"){//EL EMAIL TIENE UNCARACTER # QUE INDICA QUE EL REGISTRO NO HA SIDO COMPLETADO
					unset($_POST["cta"]);
					unset($_POST["fnac"]);
					echo json_encode("E");
				} else{//LOS DATOS SON VALIDOS, Y LA CONTRASEÑA ES NULA, POR LO TANTO EL USUARIO NO ESTA REGISTRADO
					unset($_POST["cta"]);
					unset($_POST["fnac"]);
					echo json_encode("F");
				}
			}
		}
	} else if(isset($_POST) and 
				isset($_POST["email"]) and 
				isset($_POST["pass"]) and 
				isset($_POST["cth"])){
		//SI NO ES VALIDACION DE DATOS, VERIFICAMOS QUE SEA REGISTRO
		$_cta = $_POST["cth"];
		$_destinatario = $_POST["email"];
		
		$_pass = $_POST["pass"];
		$conex = conex("p400");
		
		//SE BUSCAN LOS DATOS EN LA BDD PARA ENSAMBLAR EL CORREO QUE SE LE ENVIARA AL ALUMNO
		$sentencia = "SELECT (d.paterno|| ' '|| d.materno|| ', '|| d.nombres) AS noms, ".
			"c.nombre ".
			"FROM domi AS d, carrera AS c, diralum AS dr ".
			"WHERE d.cuenta = dr.cuenta ".
			"AND d.cuenta = substring('$_cta' FROM 1 FOR 9) ".
			"AND dr.carr = c.carr;";
			
		$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
		while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
			 $_noms = $resp[0];
			 $_carr = $resp[1];
		}
		//closeConex($ex, $conex);
		
		$_liga = "http://aragon.dgae.unam.mx/php/almn/registro.php?".
				"tt=".substr(md5($_cta), 0, 10).//10 CARACTERES DEL MD5 DEL No DE CUENTA
				"&rt=".substr(md5(strrev($_cta)), 0, 10).//10 CARACTERES DEL MD5 DEL No DE CUENTA INVERTIDO
				"&cc=".substr(md5(strrev($_pass)), 0, 10).//10 CARACTERES DEL MD5 DE LA CONTRASEÑA INVERTIDA
				"&nc=".strrev($_cta).//NUMERO DE CUENTA INVERTIDO
				"&fr=".time();//VALOR EN MILISEGUNDOS DE LA FECHA Y HORA ACTUAL
		
		//SE ACTUALIZAN LOS DATOS EN LA BDD CON LOS PROPORCIONADOS POR EL USUARIO
		//$conex = conex("p400");
		$_email = substr($_destinatario, 0, strpos($_destinatario, "@"))."#".substr($_destinatario, (strpos($_destinatario, "@")+1));
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$sentencia = "UPDATE domi ".
			"SET email = substring( '$_email' FROM 1 FOR 45), ".
			"nip = substring('$_pass' FROM 1 FOR 25), ".
			"contra = substring('$_pass' FROM 1 FOR 25) ".
			"WHERE cuenta = substring('$_cta' FROM 1 FOR 9);";
			@updateContra($_pass, $_cta);//SE ACTUALIZA LA CONTRASEÑA EN TODOS LOS SERVIDORES
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
		closeConex($ex, $conex);
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$_dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
		$_meses = array("Enero", "Febrero", "Marzo", 
						"Abril", "Mayo", "Junio", 
						"Julio", "Agosto", "Septiembre", 
						"Octubre", "Noviembre", "Diciembre");
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$_hoy = $_dias[date('w')]." ".
				date('d')." de ".
				$_meses[date('n')-1]." del ".
				date('Y')." a las ".
				date("H:i:s A");
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$_asunto = "Registro Aragon-DGAE UNAM";
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$_mensaje = "<html> <head> <title> Registro Arag&oacute;n-DGAE. </title> </head> ".
					"<body style=\"font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif;font-size:16px; background-color: #f2f8fe; \">".
					"<div id=\"wrapper\" style=\"width: 600px; margin: auto; border: solid 2px #265795; border-radius: 5px; \">".
					"<div id=\"header\" style=\"color: #fff; text-align: center; font-size: 18px; font-weight: 900; padding: 15px 5px; background-color: #265795; \"> ".
					"UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO. <br />".
					"FACULTAD DE ESTUDIOS SUPERIORES ARAG&Oacute;N. <br />".
					"DEPARTAMENTO DE SERVICIOS ESCOLARES ARAG&Oacute;N. </div>".
					"<div id=\"content\" style=\"padding: 15px 25px; background-color: #eee;\">".
					"<div style=\" padding: 1px; text-align: justify;\">".
					"Se env&iacute;a este correo con base en la petici&oacute;n de registro solicitada: <br />".
					"el d&iacute;a <b>".$_hoy.".</b> <br />".
					"para el alumno:  <b>".$_noms.".</b> <br />".
					"con n&uacute;mero de cuenta:  <b>".$_cta.".</b> <br />".
					"de la carrera:  <b>".$_carr.".</b> <br /> <br />".
					"Por favor de click en la siguiente liga, o c&oacute;piela y p&eacute;guela en la barra de direcciones ".
					"de su navegador de Internet para finalizar su registro.<br /> <br /> ".
					"<b style=\"font-size: 16px;\"> <a href=\"".$_liga."\">".$_liga."</a> </b> ".
					"<br /> <br /> ".
					"</div> <p style=\"text-align: center; font-weight: 600;\"> ATENTAMENTE: <br /> ".
					"\"POR MI RAZA HABLAR&Aacute; EL ESP&Iacute;RITU\" <br /> ".
					"Nezahualc&oacute;yotl, Estado de M&eacute;xico. </p> </div> ".
					"<div id=\"footer\" style=\"color: #fff; font-size: 14px; padding: 3px; border-top: solid 10px #EAC117; background-color: #B39312;\"> <p style=\"font-weight: 600; text-align: right;\">".
					"Contacto: serviciosescolares@aragon.unam.mx <br />".
					"Tel.: 56-23-10-66 &oacute; 56-23-10-05<br />".
					"Web: http://aragon.dgae.unam.mx ".
					" </p> </div> </div> </body> </html>";
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$_cabeceras = "From: Servicios Escolares Aragon<serviciosescolares@aragon.unam.mx>".
					"MIME-Version: 1.0\r\n".
					"Return-path: <serviciosescolares@aragon.unam.mx>\r\n".
					"Content-type: text/html; charset=utf-8\r\n";
		//SE ENVIA EL MENSAJE
		if (mail($_destinatario, $_asunto, $_mensaje, $_cabeceras)) {
			echo json_encode("0");
		} else {
			echo json_encode("-1");
		}
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	} else {
		//SI LAS VARIABLES NO EXISTEN...
		unset($_POST);
		header("Location: ../../");
	}
?>