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
	if(isset($_SESSION) && 
		isset($_SESSION["usrAdmin"]) && 
		isset($_POST) && 
		isset($_POST["cta"])){
		
		//CREAMOS UNA NUEVA CONEXION A LA BASE DE DATOS
		$conex = conex("p400");
		
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
		} else {
			$_cta = $_POST["cta"];
			//BUSCAMOS LOS DATOS DEL ALUMNO EN LA BDD
			$sentencia = "SELECT d.paterno AS \"PAT\", d.materno AS \"MAT\", d.nombres AS \"NOM\", c.nombre AS \"CRR\"".
						"FROM carrera AS c, diralum AS dr RIGHT JOIN domi AS d ON dr.cuenta = d.cuenta ".
						"WHERE c.carr = dr.carr ".
						"AND d.cuenta = substring('$_cta' FROM 1 FOR 9);";
						
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			
			if (pg_num_rows($ex) < 1){
				//SI NO SE ENCONTRARON INFORMAMOS QUE LOS DATOS NO EXISTEN
				closeConex($ex, $conex);
				echo "-2";
			} else {
				//EN CASO CONTRARIO...
				$bitacora = array();
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$bitacora["alumno"] = $resp;
				}
				
				$sentencia = "SELECT id_log AS \"IDL\", ".
				"CASE WHEN cve_grupo_plan_asignatura IS NULL THEN '*****' ".
				"ELSE cve_grupo_plan_asignatura END AS \"GPA\", ".
				"fecha AS \"FEC\", ip AS \"IPO\", ".
				"CASE WHEN operacion = 'A' THEN 'ALTA' ".
				"WHEN operacion = 'B' THEN 'BAJA' ".
				"WHEN operacion = 'I' THEN 'INGRESO AL SISTEMA' ".
				"WHEN operacion = 'O' THEN 'SALIDA DEL SISTEMA' ".
				"WHEN operacion = 'F' THEN 'FINALIZAR INSCRIPCI&Oacute;N' ".
				"ELSE 'NO DEFINIDO' END AS \"OPE\", resultado AS \"RES\", ".
				"semestre AS \"SEM\"".
				"FROM bitacora ".
				"WHERE cve_cuenta_plan like '".substr($_cta, 0, 9)."%' ".
				"ORDER BY id_log DESC;";
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$bitacora["datos"][] = $resp;
				}
				closeConex($ex, $conex);
				
				unset($_POST["cta"]);
				unset($_POST["consulta"]);
				echo json_encode($bitacora);
			}
			
		}
	} else {
		//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		session_unset();
		session_destroy();
		header("Location: ../../");
	}
?>