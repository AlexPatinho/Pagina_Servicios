<?php
//	ini_set('display_errors', 1);
//	error_reporting(E_ALL);

//DECLARAMOS EL PERIODO: 1 PARA REINSCRIPCION, 2 PARA ALTAS Y BAJAS
$periodo = '1';
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	session_start();
	
	$bdd = "inscripciones";//BASE DE DATOS DEL NUEVO SISTEMA
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
//SE BUSCA EL ALUMNO EN LA SE DE DATOS
	if(isset($_SESSION) 
	and isset($_SESSION["usrJef"])
	and isset($_SESSION["carr"])
	and isset($_SESSION["nCarr"])
	and isset($_SESSION["serv"])
	and isset($_POST)
	and isset($_POST["cons"])
	and $_POST["cons"] == true
	and isset($_POST["cta"])){
		
		//SE SELECCIONA EL SERVIDOR AL CUAL SE CONECTAR
		$conex = conex41($bdd);
		/*
		switch($_SESSION["serv"]){
			case "40":{ $conex = conex40("escolares"); break; }
			case "41":{ $conex = conex41("escolares"); break; }
			case "43":{ $conex = conex43("escolares"); break; }
			case "44":{ $conex = conex44("escolares"); break; }
		}
		*/
		//SI LA CONEXION NO ES EXITOSA...
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			//409039908
			/*
			$sentencia = "SELECT 
							a.cve_cuenta AS \"CTA\", 
							a.ap_paterno || ' ' || a.ap_materno || ', ' || a.nombre AS \"NOM\", 
							CASE WHEN (b.fecha_inscripcion = '2006-01-01') AND (b.hora_inscripcion = '00:00')
								THEN 'HNA'
								ELSE b.fecha_inscripcion || ' ' || b.hora_inscripcion 
							END AS \"HIN\", 
							CASE WHEN (b.fecha_altas_bajas = '2006-01-01') AND (b.hora_altas_bajas = '00:00')
								THEN 'HNA'
								ELSE b.fecha_altas_bajas || ' ' || b.hora_altas_bajas 
							END AS \"HAB\", 
							c.nombre_plan AS \"NPLN\", 
							c.clave_plan AS \"CPLN\", 
							c.cve_carrera = '".$_SESSION["carr"]."' AS \"OKC\" 
						FROM 
							alumno_plan b, 
							plan c, 
							alumno a 
						WHERE 
							b.cve_cuenta = a.cve_cuenta AND 
							c.clave_plan = b.cve_plan AND 
							a.cve_cuenta = '".$_POST["cta"]."';";
			*/
			$sentencia = "select alumno.id AS \"CTA\", 
							alumno.primer_apellido || ' ' || alumno.segundo_apellido || ' ' || alumno.nombre AS \"NOM\", 
							horario_inscripcion.dia_inscripcion || ' ' ||  horario_inscripcion.hora_inicio AS \"HIN\", 
							plan_estudios.nombre AS \"NPLN\", 
							plan_estudios.id AS \"CPLN\", 
							carrera.id = ".$_SESSION["carr"]." AS \"OKC\"
						FROM 
							alumno LEFT JOIN horario_inscripcion ON alumno.id = horario_inscripcion.alumno_has_alumno_id
							LEFT JOIN alumno_has_plan_estudios ON alumno.id = alumno_id
							LEFT JOIN plan_estudios ON plan_estudios.id = alumno_has_plan_estudios.plan_estudios_id
							LEFT JOIN carrera on carrera.id = carrera_id
						WHERE alumno.id = '".$_POST["cta"]."' and tipo_inscripcion_id='$periodo';";
			
			//echo $sentencia; exit;
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$data = array();
			while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
				$data[] = $resp;
			}
		}
		
		closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
		echo json_encode($data);
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
//SE ACTUALIZA SU HORA DE INSCRIPCION
	} else if(isset($_SESSION) 
	and isset($_SESSION["usrJef"])
	and isset($_SESSION["carr"])
	and isset($_SESSION["nCarr"])
	and isset($_SESSION["serv"])
	and isset($_POST)
	and isset($_POST["ctapln"])
	and isset($_POST["tipo"])){
		
		$cta = substr($_POST["ctapln"], 0, 9);
		$pln = substr($_POST["ctapln"], 9, 4);
		
		/*INI_SENT::208
		$conex = conex("p400");
		
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
		$sentencia = "SELECT extract('year' FROM current_date) || 
						'-' || 
						substring(mdinsc FROM 1 FOR 2) || 
						'-' || 
						substring(mdinsc FROM 3 FOR 2) AS \"DINS\", 
						CASE WHEN horainsc = '0' THEN '0800' 
						WHEN horainsc = '1' THEN '09:00' 
						WHEN horainsc = '2' THEN '10:00' 
						WHEN horainsc = '3' THEN '11:00' 
						WHEN horainsc = '4' THEN '12:00' 
						WHEN horainsc = '5' THEN '15:00' 
						WHEN horainsc = '6' THEN '16:00' 
						WHEN horainsc = '7' THEN '17:00' 
						WHEN horainsc = '8' THEN '18:00' 
						WHEN horainsc = '9' THEN '19:00' 
						WHEN horainsc = 'A' THEN '08:30' 
						WHEN horainsc = 'B' THEN '09:30' 
						WHEN horainsc = 'C' THEN '10:30' 
						WHEN horainsc = 'D' THEN '11:30' 
						WHEN horainsc = 'E' THEN '12:30' 
						WHEN horainsc = 'F' THEN '15:30' 
						WHEN horainsc = 'G' THEN '16:30' 
						WHEN horainsc = 'H' THEN '17:30' 
						WHEN horainsc = 'I' THEN '18:30' 
						WHEN horainsc = 'J' THEN '19:30' 
						WHEN horainsc = 'Z' THEN '22:00' 
						ELSE '2200' END AS \"FINS\" 
					FROM sorteo 
					WHERE cuenta = '$cta' 
					AND plan_e = '$pln'";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		$fins = pg_fetch_result($ex, 0, 0);
		$hins = pg_fetch_result($ex, 0, 1);
		
		closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
		*///INI_SENT::208
		
		//SE SELECCIONA EL SERVIDOR AL CUAL SE CONECTAR
		$conex = conex41($bdd);
		/*
		switch($_SESSION["serv"]){
			case "40":{ $conex = conex40("escolares"); break; }
			case "41":{ $conex = conex41("escolares"); break; }
			case "43":{ $conex = conex43("escolares"); break; }
			case "44":{ $conex = conex44("escolares"); break; }
		}
		*/
		
		//SI LA CONEXION NO ES EXITOSA...
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$aux1 = "";
			$aux2 = "";
			switch($_POST["tipo"]){
				case "HIN": {
					/*$sentencia = "SELECT CASE WHEN fecha_inscripcion = current_date::text 
									THEN TRUE ELSE FALSE END, 
									CASE WHEN hora_inscripcion <= substring(current_time::text FROM 1 FOR 5)
									THEN TRUE ELSE FALSE END 
									FROM alumno_plan
									WHERE cve_cuenta_plan = '".$cta.$pln."';";
					$aux1 = "fecha_inscripcion = current_date::text, 
							hora_inscripcion = substring(current_time::text FROM 1 FOR 5),
							ins_ord = FALSE ";
							
					$aux2 = "AND fecha_inscripcion = '".$fins."' 
							AND hora_inscripcion = '".$hins."';";
					*/
					$sentencia = "SELECT CASE WHEN dia_inscripcion = current_date 
									THEN TRUE ELSE FALSE END, 
									CASE WHEN hora_inicio <= CURRENT_TIME 
									THEN TRUE ELSE FALSE END 
								FROM horario_inscripcion 
								WHERE alumno_has_alumno_id = '$cta' AND 
									alumno_has_plan_estudios_id = '$pln' and tipo_inscripcion_id='$periodo';";
					//echo $sentencia;
					$aux1 = "hora_final = substring((CURRENT_TIME + time '01:00:00')::text FROM 1 FOR 8)::time, 
							realizado = FALSE ";
					$aux2 = "AND (((dia_inscripcion || ' ' || hora_final)::timestamp - (dia_inscripcion || ' ' || hora_inicio)::timestamp = '02:00'::interval) OR
									((dia_inscripcion || ' ' || hora_final)::timestamp - (dia_inscripcion || ' ' || hora_inicio)::timestamp = '12:00'::interval))";
					break;
				}
				case "HAB": {
					/*
					$sentencia = "SELECT CASE WHEN fecha_altas_bajas = current_date::text 
									THEN TRUE ELSE FALSE END, 
									CASE WHEN hora_altas_bajas <= substring(current_time::text FROM 1 FOR 5)
									THEN TRUE ELSE FALSE END 
									FROM alumno_plan
									WHERE cve_cuenta_plan = '".$cta.$pln."';";
									
					$aux1 = "fecha_altas_bajas = current_date::text, 
							hora_altas_bajas = substring(current_time::text FROM 1 FOR 5), 
							ins_ab = FALSE ";
					$aux2 = "AND fecha_altas_bajas = '".$fins."' 
							AND hora_altas_bajas = '".$hins."';";
					*/
					break;
				}
			}
			
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$okf =  pg_fetch_result($ex, 0, 0);
			$okh =  pg_fetch_result($ex, 0, 1);
			
			$val = "";
			
			if($okf === "t"){//SE ENCUENTRA EN EL DIA DE LA INSCRIPCION
				if($okh === "t"){//LA HORA ACTUAL ES MAYOR O IGUAL A LA DE INSCRIPCION
				/*
					$sentencia = "UPDATE alumno_plan 
								SET ".$aux1." 
								WHERE cve_cuenta_plan = '".$cta.$pln."' 
								".$aux2;
					*/
					$sentencia = "UPDATE horario_inscripcion
								SET ".$aux1."
								WHERE alumno_has_alumno_id = '$cta' AND 
									alumno_has_plan_estudios_id = '$pln'
									and tipo_inscripcion_id='$periodo'
								";//.$aux2;
					$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
					
					if(pg_affected_rows($ex) > 0){
						$val = "D";//LA ACTUALIZACION DE HORARIO SE REALIZO CORRECTAMENTE
					} else {
						$val = "C";//YA SE HA HECHO UNA REAPERTURA ANTERIOR
					}
				} else {
					$val = "B";//LA HORA ES ANTERIOR A LA QUE PUEDE INSCRIBIRSE
				}
			} else {
				$val = "A";//FUERA DEL DIA EN QUE PUEDE INSCRIBIRSE
			}
		}
	//}FIN_SENT::208
		
		closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
		echo json_encode($val);
		
//****************************************************************************************
//****************************************************************************************
//****************************************************************************************
	} else {
		//SI LAS VARIABLES NO EXISTEN...
		session_unset();
		session_destroy();
		unset($_POST);
		echo json_encode("Error de conexi&oacute;n con el servidor.");
	}
?>