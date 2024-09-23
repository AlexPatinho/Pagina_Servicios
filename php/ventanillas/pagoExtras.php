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
	
	if(	isset($_SESSION) 
	&& isset($_SESSION["usrVent"])
	&& isset($_POST) 
	&& isset($_POST["check"]) 
	&& $_POST["check"] == true ){
	//VERIFICAMOS QUE SE ENCUENTRE EN UN PERIODO DE INSCRIPCION DE EXTRAORDINARIOS VALIDO
		$conex = conex40('inscripciones');
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
		} else {
			$sentencia = "SELECT inscripcion_estado AS \"IE\", vuelta AS \"VTA\", nombre AS \"SEM\" 
						FROM config, ciclo_escolar
						WHERE actual;";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$data = pg_fetch_array($ex, NULL, PGSQL_ASSOC);
			
			$_SESSION["IE"] = $data["IE"];
			$_SESSION["VTA"] = $data["VTA"];
		}
		
		echo json_encode($data);
		/*******************************************************************************************/
		/*******************************************************************************************/
		/*******************************************************************************************/
	 }elseif(isset($_POST) 
		&& isset($_POST["cta"]) 
		&& isset($_POST["consulta"]) 
		&& $_POST["consulta"] == true 
		&& isset($_SESSION) 
		&& isset($_SESSION["usrVent"])){
		//SE VERIFICA QUE EXISTAN LOS DATOS DEL ALUMNO
		//CREAMOS UNA NUEVA CONEXION A LA BASE DE DATOS
		//$conex = conex("p400");
		$conex = conex40('inscripciones');
		
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
		} else {
			$cta = substr($_POST["cta"], 0, 9);
			
			$sentencia = "SELECT 
							alumno.id = '$cta'
						FROM 
							public.alumno
						WHERE 
							alumno.id = '$cta';";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$resp = pg_fetch_array($ex, NULL, PGSQL_NUM);
			//VERIFICAMOS SI EL NUMERO DE CUENTA EXISTE...
			//echo json_encode($resp);
			if($resp[0] == "t"){
				$sentencia = "SELECT 
								alumno.id AS \"CTA\", 
								alumno.primer_apellido || ' ' || alumno.segundo_apellido || ', ' || alumno.nombre AS \"NOM\"
							FROM 
								public.alumno
							WHERE 
								alumno.id = '$cta';";
				$data = array();
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC);
				$data["ALUM"] = $resp;
				
				if($_SESSION["VTA"] === "PRIMERA VUELTA"){ $vta = '2'; } elseif($_SESSION["VTA"] === "SEGUNDA VUELTA"){ $vta = '6'; }
				//IDENTIFICAMOS LA VUELTA CORRESPONDIENTE
				
				//BUSCAMOS LOS PAGOS REALIZADOS
				$sentencia = "SELECT 
								pago.id AS \"ID\", 
								pago.alumno_id AS \"CTA\", 
								carrera.nombre AS \"CRR\", 
								tipo_pago.tipo AS \"VUE\", 
								pago.folio AS \"FOL\", 
								pago.create_at AS \"FCH\"
							FROM 
								public.pago, 
								public.tipo_pago, 
								public.ciclo_escolar, 
								public.plan_estudios, 
								public.carrera
							WHERE 
								pago.tipo_pago_id = tipo_pago.id AND
								pago.ciclo_escolar_id = ciclo_escolar.id AND
								pago.plan_estudios_id = plan_estudios.id AND
								plan_estudios.carrera_id = carrera.id AND
								--tipo_pago.id IN (2, 6) AND 
								tipo_pago.id IN ($vta) AND 
								pago.alumno_id = '$cta'
							ORDER BY pago.id;";
								
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$data["PAGO"][] = $resp;
				}
				
				closeConex($ex, $conex);
				unset($_POST["cta"]);
				unset($_POST["consulta"]);
				unset($_POST);		
				
				echo json_encode($data);
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
	} elseif(isset($_POST)
	&& isset($_POST["cta"]) 
	&& isset($_POST["carr"]) 
	&& $_POST["carr"] == true 
	and isset($_SESSION)
	and isset($_SESSION["usrVent"])){
	//SE BUSCAN LAS TRAYECTORIAS/CARRERAS DEL ALUMNO
		//CREAMOS UNA NUEVA CONEXION A LA BASE DE DATOS
		//$conex = conex("p400");
		$conex = conex40('inscripciones');
		
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
			$cta = substr($_POST["cta"], 0, 9);
			
			//IDENTIFICAMOS LA VUELTA CORRESPONDIENTE
			if($_SESSION["VTA"] === "PRIMERA VUELTA"){
				$vta = '2';
				$per = "3";
			} elseif($_SESSION["VTA"] === "SEGUNDA VUELTA"){
				$vta = '6'; 
				$per = "(SELECT 3 + 
									(SELECT extras_permitidos 
										FROM alumno_has_plan_estudios 
										WHERE alumno_id = '$cta' 
											AND (causa_exalumno = '00' OR causa_exalumno = '20')) - count(inscripcion.*)
							FROM public.grupo LEFT JOIN public.inscripcion ON grupo.id = inscripcion.grupo_id
							WHERE inscripcion.alumno_id = '$cta'
								AND grupo.tipo_vuelta = 'PRIMERA VUELTA'
								AND grupo.ciclo_escolar_id = (SELECT id FROM ciclo_escolar WHERE actual))";
			}
			
			//BUSCAMOS LAS TRAYECTORIAS DES ALUMNO 308287990
			$sentencia = "SELECT 
							d.id AS \"PLN\",
							a.generacion AS \"GEN\", 
							a.causa_exalumno AS \"CAU\", 
							c.causa AS \"NOM\", 
							e.nombre AS \"CRR\",
							".$per." - count(b.*) AS \"PER\"
						FROM 
							alumno_has_plan_estudios AS a 
							LEFT JOIN pago AS b 
								ON (a.alumno_id = b.alumno_id AND a.plan_estudios_id = b.plan_estudios_id AND b.tipo_pago_id in('$vta')), 
							causas_ingreso_exalumno c, 
							plan_estudios d, 
							public.carrera e
						WHERE a.alumno_id = '$cta' 
							AND (a.causa_exalumno = '00' OR a.causa_exalumno = '20')
							AND a.causa_exalumno = c.id 
							AND a.plan_estudios_id = d.id 
							AND d.carrera_id = e.id 
						GROUP BY d.id, a.generacion, a.causa_exalumno, c.causa, e.nombre;";
							
				//echo json_encode($sentencia); exit; 
				$data = array();
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$data[] = $resp;
				}
				
				closeConex($ex, $conex);
				unset($_POST);		
				
				echo json_encode($data);
		}
		/*******************************************************************************************/
		/*******************************************************************************************/
		/*******************************************************************************************/
	} elseif(isset($_POST)
	&& isset($_POST["cta"]) 
	&& isset($_POST["crr"])
	&& isset($_POST["fol"])
	&& isset($_POST["imp"])
	&& isset($_POST["per"])
	and isset($_SESSION)
	and isset($_SESSION["usrVent"])){
	//SE CARGAN LOS PAGOS PARA REALIZAR LA INSCRIPCION DE EXTRAORDINARIOS
		//CREAMOS UNA NUEVA CONEXION A LA BASE DE DATOS
		//$conex = conex("p400");
		$conex = conex40('inscripciones');
		
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
			$cta = substr($_POST["cta"], 0, 9);
			
			if($_SESSION["VTA"] === "PRIMERA VUELTA"){
				$vta = '2';
			} elseif($_SESSION["VTA"] === "SEGUNDA VUELTA"){
				$vta = '6';
			}
			
			$pln = $_POST["crr"];
			$sentencia = "SELECT count(*) 
						FROM pago 
						WHERE alumno_id = '$cta'
							AND plan_estudios_id = '$pln'
							AND ciclo_escolar_id = (SELECT id FROM ciclo_escolar WHERE actual)
							AND tipo_pago_id IN ($vta);";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$resp = pg_fetch_array($ex, NULL, PGSQL_NUM);
			
			//SE CUENTAN CUANTOS EXTRAS TIENE PERMITIDO
			//$resp = (count($_POST["fol"]) - intval($resp[0]));
			//$resp = 3 - intval($resp[0]);
			$resp = $_POST["per"];
			//echo json_encode($resp); exit;
			if($resp <= 0){
				closeConex($ex, $conex);
				unset($_POST);		
				echo json_encode("AA");//NO PUEDE INSCRIBIR MAS EXTRAS
			} else {
				//$sentencia = "INSERT INTO pago(tipo_pago_id, ciclo_escolar_id, plan_estudios_id, alumno_id, status, folio, importe, create_at)
				//				VALUES";
				
				$sentencia = "";
				for($i=0; $i<$resp; $i++){
					//SI EL INDICE EXISTE...
					if(array_key_exists($i, $_POST["fol"]) && array_key_exists($i, $_POST["imp"])){
						$sentencia .= "INSERT INTO pago(tipo_pago_id, ciclo_escolar_id, plan_estudios_id, alumno_id, status, folio, importe, create_at) VALUES ($vta, (SELECT id FROM ciclo_escolar WHERE actual), '$pln', '$cta', 'PAGADO', '".$_POST["fol"][$i]."', ".$_POST["imp"][$i].", (current_date || ' ' || substring(current_time::text FROM 1 FOR 8))::timestamp);";
					}
				}
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				if(pg_affected_rows($ex)<1){
					echo json_encode("BB"); exit;//LOS PAGOS NO SE PUDIERON REGISTRAR
				}
				$data = array();
				$sentencia = "SELECT 
								pago.id AS \"ID\", 
								pago.alumno_id AS \"CTA\", 
								carrera.nombre AS \"CRR\", 
								tipo_pago.tipo AS \"VUE\", 
								pago.folio AS \"FOL\", 
								pago.create_at AS \"FCH\"
							FROM 
								public.pago, 
								public.tipo_pago, 
								public.ciclo_escolar, 
								public.plan_estudios, 
								public.carrera
							WHERE 
								pago.tipo_pago_id = tipo_pago.id AND
								pago.ciclo_escolar_id = ciclo_escolar.id AND
								pago.plan_estudios_id = plan_estudios.id AND
								plan_estudios.carrera_id = carrera.id AND
								tipo_pago.id IN (2, 6) AND 
								--tipo_pago.id IN (1) AND 
								pago.alumno_id = '$cta'
							ORDER BY pago.id ;";
								
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$data[] = $resp;
				}
				echo json_encode($data);//LOS PAGOS SE REGISTRARON CORRECTAMENTE
			}
		}
		/*******************************************************************************************/
		/*******************************************************************************************/
		/*******************************************************************************************/
		//echo json_encode($sentencia);
		//echo json_encode("nop");
	} else {
	//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		unset($_POST);
		session_unset();
		session_destroy();
		header("Location: ../");
	}
?>