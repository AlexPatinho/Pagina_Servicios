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
	//if(isset($_SESSION["ran"]) and isset($_GET["ran"]) and (floatval($_SESSION["ran"]) === floatval($_GET["ran"]))){ echo json_encode($_GET); exit;}//EVITA MULTIEJECUCUION DEL SCRIPT
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
	if(isset($_SESSION)
	&& isset($_SESSION["usrAdmin"]) 
	&& isset($_POST) 
	&& isset($_POST["cta"])
	&& isset($_POST["chk"])
	&& $_POST["chk"] === 'check'){
	//SE BUSCAN LAS CARTAS PASANTE SOLOCITADAS POR EL ALUMNO	
	//unset($_SESSION["ran"]);
		$conex = conex("p400");
		
		if(!$conex){
			echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
			exit;
		} else {
			$sentencia = "SELECT 			
				d.cuenta AS \"CTA\", 
				d.paterno || ' ' || d.materno || ', ' || d.nombres AS \"NOM\", 
				p.carrera AS \"CRR\", 
				CASE WHEN p.sem IS NULL THEN '******' ELSE p.sem END AS \"SEM\", 
				p.folio AS \"FOL\", 
				p.fecha_elab AS \"FCE\", 
				p.elab AS \"ELA\", 
				CASE WHEN p.repo IS NULL THEN '******' ELSE p.repo END AS \"REP\",
				CASE WHEN (date_part('year', age(current_date, p.fecha_elab))*12) + date_part('month', age(current_date, fecha_elab)) < 12
					THEN TRUE ELSE FALSE END AS \"VAL\"
			FROM 
				public.domi d, 
				public.pasante p
			WHERE 
				d.cuenta = p.cuenta AND
				d.cuenta = '".$_POST["cta"]."';";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				
			$data = array();
			while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){ $data[] = $resp; }
			if(empty($data)){$data = 'NULL';}
		}
		
		closeConex($ex, $conex);//CERRAMOS LA CONEXION A LA BDD
		echo json_encode($data);//INFORMAMOS EL RESULTADO OBTENIDO
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
	} elseif(isset($_SESSION)
	and (isset($_SESSION["usrVent"]) or (isset($_SESSION["usrAdmin"])))
	and isset($_POST)
	and isset($_POST["chk"])
	and isset($_POST["cta"])
	and $_POST["chk"] === "gen"){
	//SE BUSCAN LA(S) TRAYECTORIAS VALIDAS DEL ALUMNO
		$conex = conex("p400");
		
		if(!$conex){
			echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
			exit;
		} else {
			$sentencia = "SELECT 
				domi.cuenta AS \"CTA\", 
				domi.paterno AS \"PAT\", 
				domi.materno AS \"MAT\", 
				domi.nombres AS \"NOM\", 
				semes.nombre AS \"CRR\", 
				diralum.plan_e AS \"PLN\", 
				diralum.exa AS \"CAU\", 
				CASE WHEN NOT diralum.exa IS NULL THEN exalum.texto ELSE 'ACTIVO' END AS \"NCA\"
			FROM 
				public.domi, 
				public.semes,
				public.diralum left join public.exalum ON diralum.exa = exalum.exa
			WHERE 
				domi.cuenta = diralum.cuenta AND
				diralum.plan_e = semes.plan_e AND
				domi.cuenta = '".$_POST["cta"]."' AND
				(diralum.exa IS NULL OR diralum.exa IN ('06', '11', '14', '20', '23'))
				GROUP BY domi.cuenta, 
				domi.paterno, 
				domi.materno, 
				domi.nombres, 
				semes.nombre, 
				diralum.plan_e, 
				diralum.exa, 
				exalum.texto;";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				
			$data = array();
			while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){ $data[] = $resp; }
			if(empty($data)){
				$data = 'NULL';
			}
		}
		
		closeConex($ex, $conex);//CERRAMOS LA CONEXION A LA BDD
		echo json_encode($data);//INFORMAMOS EL RESULTADO OBTENIDO
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
	} elseif(isset($_SESSION)
	and (isset($_SESSION["usrVent"]) or (isset($_SESSION["usrAdmin"])))
	and isset($_POST)
	and isset($_POST["cta"])
	and isset($_POST["pln"])
	and isset($_POST["val"])
	and $_POST["val"] === "validar"){
	//SE VALIDA SI EL ALUMNO PUEDE TRAMITAR UNA CARTA PASANTE
		$conex = conex("p400");
		if(!$conex){
			echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
			exit;
		} else {
			$_POST["cta"] = trim($_POST["cta"], "\'");
			$_POST["pln"] = trim($_POST["pln"], "\'");
			$data = NULL;
			$sentencia = "SELECT ((c.credb::int + c.credp::int)*100)/(s.creobl::int + s.creopt::int) AS \"CRD\", 
								c.esta AS \"INS\", 
								c.ter AS \"TER\", 
								c.prom AS \"PRM\", 
								CASE WHEN split_part(t.fecha, ' ', 1) ILIKE 'ENERO' THEN (date_part('year', age(current_date, ('01-01-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-01-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'FEBRERO' THEN (date_part('year', age(current_date, ('01-02-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-02-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'MARZO' THEN (date_part('year', age(current_date, ('01-03-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-03-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'ABRIL' THEN (date_part('year', age(current_date, ('01-04-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-04-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'MAYO' THEN (date_part('year', age(current_date, ('01-05-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-05-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'JUNIO' THEN (date_part('year', age(current_date, ('01-06-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-06-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'JULIO' THEN (date_part('year', age(current_date, ('01-07-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-07-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'AGOSTO' THEN (date_part('year', age(current_date, ('01-08-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-08-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'SEPTIEMBRE' THEN (date_part('year', age(current_date, ('01-08-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-09-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'OCTUBRE' THEN (date_part('year', age(current_date, ('01-10-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-10-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'NOVIEMBRE' THEN (date_part('year', age(current_date, ('01-11-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-11-' || split_part(t.fecha, ' ', 2))::date))
									WHEN split_part(t.fecha, ' ', 1) ILIKE 'DICIEMBRE' THEN (date_part('year', age(current_date, ('01-12-' || split_part(t.fecha, ' ', 2))::date))*12) + date_part('month', age(current_date, ('01-12-' || split_part(t.fecha, ' ', 2))::date))
								ELSE NULL END AS \"TMP\" 
							FROM  consta c JOIN semes s on c.plan_e = s.plan_e 
								JOIN termino t ON (t.semestre = c.semfin AND t.periodo = c.exf) 
							WHERE c.cuenta = '".trim ($_POST["cta"], "\'")."' 
								AND c.plan_e = '".trim ($_POST["pln"], "\'")."';";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$resp = pg_fetch_row($ex, NULL, PGSQL_ASSOC);
			$aux = $resp;
			if(intval($resp["CRD"]) < 70){
				$data = "CC"; //EL ALUMNO NO CUENTA CON LOS CREDITOS SUFICIENTES
			} elseif((intval($resp["CRD"]) < 100 && intval($resp["INS"]) == 0)){
				$data = "II"; //EL ALUMNO NO SE ENCUENTRA INSCRITO
			} elseif((intval($resp["CRD"]) >= 100 && intval($resp["TER"]) == 0)){
				$data = "II"; //EL ALUMNO NO SE ENCUENTRA INSCRITO (NO SE HA ACTUALIZADO EL ESTATUS DE TERMINO)
			} elseif(intval($resp["PRM"]) < 7){
				$data = "PP"; //NO CUENTA CON EL PROMEDIO MINIMO PARA EL TRAMITE
			} elseif(intval($resp["TMP"]) > 26){//************************************ Regresar a 11 despues de la pandemia ********************
				$data = "TT"; //HA PASADO MAS DE UN AÑO DESDE LA ACREDITACION DE LA OBTENCION DEL 100%
			} elseif(intval($resp["CRD"]) >= 70 && intval($resp["PRM"]) >= 7 && (intval($resp["INS"]) === 1 || intval($resp["TER"]) === 1)){
				
				closeConex($ex, $conex);//CERRAMOS LA CONEXION A LA BDD
				$conex = conex41('inscripciones');//CONEXION A LA BDD DE INSCRIPCIONES
				$sentencia = "SELECT * FROM (SELECT DISTINCT ON (nombre) nombre, semestre_id, 
								calificacion, 
								ciclo_escolar_id 
							FROM (SELECT pp.plan_estudios_id, 
								pp.semestre_id, 
								a.nombre, 
								ins.*  
							FROM  plan_estudios_has_asignatura pp 
								LEFT JOIN asignatura A on pp.asignatura_id = a.id 
								LEFT JOIN (SELECT g.asignatura_id, 
										g.ciclo_escolar_id, 
										g.tipo_evaluacion, 
										i.calificacion, 
										i.created_at  
									FROM grupo g 
										LEFT JOIN inscripcion i ON g.id = i.grupo_id 
									WHERE i.alumno_id = '".$_POST["cta"]."' AND calificacion NOT IN ('NP')) ins 
									ON pp.asignatura_id = ins.asignatura_id
							WHERE pp.plan_estudios_id = '".$_POST["pln"]."' 
								AND pp.semestre_id > '00' 
								AND pp.semestre_id <= '06'
								AND pp.tipo_credito_id = 0
							ORDER BY pp.semestre_id, a.nombre, ins.calificacion desc) lista 
							GROUP BY nombre, semestre_id, calificacion, ciclo_escolar_id
							ORDER BY nombre, ciclo_escolar_id desc, calificacion desc, semestre_id) lista
							WHERE (calificacion IN('05', 'NP') OR calificacion IS NULL);";
							
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				//$resp = pg_fetch_array($ex, NULL, PGSQL_NUM);
				$aux = array();
				while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){ $aux[] = $resp; }
				
				closeConex($ex, $conex);//CERRAMOS LA CONEXION A LA BDD
				
				if(!empty($aux)){
					$data["AA"] = "AA";
					$data["MT"] = $aux;//EL ALUMNO ADEUDA MATERIAS DE 1ER A 6o SEMESTE
				} else {
					$conex = conex("p400");
					$sentencia = "SELECT 
								domi.sexo AS \"GEN\", 
								domi.paterno AS \"PAT\",
								domi.materno AS \"MAT\",
								domi.nombres \"NOM\", 
								domi.cuenta AS \"CTA\", 
								semes.nombre \"CRR\", 
								semes.creobl::int + semes.creopt::int AS \"CRC\", 
								round(consta.prom::numeric, 2) AS \"PRM\", 
								consta.credb::int + consta.credp::int AS \"ACM\", 
								round((consta.credb::int + consta.credp::numeric) * 100 / (semes.creobl::int + semes.creopt::numeric), 2) AS \"CRO\", 
								termino.fecha AS \"FTR\", 
								semestre.fecha_ini AS \"FCI\", 
								semestre.fecha_fin AS \"FCT\",
								consta.esta AS \"INS\",
								consta.ter AS \"TER\", 
								consta.sem AS \"SEM\", 
								-- consta.semfin AS \"ULT\",
								substring(consta.semfin FROM 1 FOR 4) || '-' || substring(consta.semfin FROM 5 FOR 1) AS \"ULT\" 
							FROM 
								public.consta, 
								public.diralum, 
								public.semes, 
								public.domi,
								public.semestre,
								public.termino
							WHERE 
								consta.plan_e = diralum.plan_e AND
								consta.plan_e = semes.plan_e AND
								domi.cuenta = consta.cuenta AND
								domi.cuenta = diralum.cuenta AND
								semestre.cve_sem = consta.semfin AND
								termino.semestre = consta.semfin AND
								termino.periodo = consta.exf AND
								domi.cuenta = '".$_POST["cta"]."' AND 
								consta.plan_e = '".$_POST["pln"]."';";
					$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
					$data = array();
					while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){ $data[] = $resp; }
					if(empty($data)){ $data = 'NULL'; }
				}
			}
		}
		
		//closeConex($ex, $conex);//CERRAMOS LA CONEXION A LA BDD
		echo json_encode($data);//INFORMAMOS EL RESULTADO OBTENIDO
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
	} elseif(isset($_SESSION)
	and (isset($_SESSION["usrVent"]) or (isset($_SESSION["usrAdmin"])))
	and isset($_GET)
	and isset($_GET["gen"])
	and $_GET["gen"] === "gen"){
	//SE GENERA UNA CARTA O REPOCICION
		$conex = conex("p400");
		$MES = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 
					5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 
					9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 =>"Diciembre");
			
		if(!$conex){
			echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
			exit;
		} else {			
			if(isset($_GET["fol"]) || (isset($_SESSION["ufo"]) and isset($_SESSION["ran"]) and isset($_GET["ran"])and (floatval($_SESSION["ran"]) === floatval($_GET["ran"])))){
				//SE SOLICITA UNA REPOSICION DE CARTA PASANTE
				$fo = (isset($_SESSION["ufo"])) ? $_SESSION["ufo"]: $_GET["fol"];
				//EVITA QUE EL SCRIPT SE EJECUTE MULTIPLES VECES
				//if(isset($_GET["fol"]) && (!$_GET["fol"] == NULL || !$_GET["fol"] == "") ){unset($_SESSION["unico"]);}
				
				$sentencia = "SELECT 
					d.cuenta, 
					d.paterno, 
					d.materno, 
					d.nombres, 
					CASE WHEN NOT d.sexo = 'F' THEN 'M' ELSE d.sexo END , 
					p.carrera, 
					p.cred_tot, 
					p.prom, 
					p.porce, 
					p.cred_obt, 
					p.fecha_fin, 
					p.sem, 
					p.fecha_elab, 
					u.firma
				FROM 
					public.pasante p, 
					public.domi d,
					public.usuarios u
				WHERE 
					p.cuenta = d.cuenta AND 
					u.login = p.elab AND 
					p.folio = '".$fo."';";
					//echo json_encode($sentencia); exit;
					
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$resp = pg_fetch_array($ex, NULL, PGSQL_NUM);
				//echo json_encode($resp); exit;
				
				$folio = (isset($_SESSION["ufo"])) ? $_SESSION["ufo"]: $_GET["fol"];//FOLIO DE LA CARTA PASANTE
				$strCue = $resp[0];												//NUMERO DE CUENTA DEL ALUMNO
				$APa = $resp[1];												//APELLIDO PATERNO DEL ALUMNO
				$AMa = $resp[2];												//APELLIDO MATERNO DEL ALUMNO
				$Nom = $resp[3];												//NOMBRES DEL ALUMNO
				
				$gen = $resp[4];												//SEXO DEL ALUMNO
				$NoP = $resp[5];												//NOMBRE DE LA CARRERA DEL ALUMNO
				$CTP = $resp[6];												//CREDITOS DE LA CARRERA
				$Pro = $resp[7];												//PROMEDIO DEL ALUMNO
				$PTot= $resp[8];												//PORCENTAJE DE CREDITOS OBTENIDOS
				$CTA = $resp[9];												//CREDITOS ACUMULADOS POR EL ALUMNO
				$dia = substr($resp[10], strrpos($resp[10], '(')+1, 2); 		//DIA DE TERMINO
				$nota_fin = substr($resp[10], (strrpos($resp[10], '(')+3)); 	//FECHA EN LA QUE ACREDITO EL TOTAL DE CREDITOS
				$ciclo = $resp[10];												//FECHAS DE INICIO Y FIN EN CASO DE ESTAR INSCRITO
				$sem = $resp[11];												//SEMESTRE AL QUE ESTA(UVO) INSCRITO
				$yy = substr($resp[12], 0, 4);									//AÑO 
				$mm = intval(substr($resp[12], 5, 2));							//MES
				$dd = substr($resp[12], 8, 2);									//DIA
				$fir = "MTLS/".$resp[13];										//USUARIO QUE GENERA LA CARTA PASANTE
				
				if(($_SESSION["ran"] !== $_GET["ran"]) or isset($_GET["fol"])){
					$sentencia = "UPDATE pasante SET repo = '".$_SESSION["usrAdmin"]."' WHERE folio = '".$_GET["fol"]."'";
					$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				}
				
				closeConex($ex, $conex);//CERRAMOS LA CONEXION A LA BDD
			} elseif(isset($_GET["new"]) && $_GET["new"] === "val") {
				//SE SOLICITA UNA CARTA PASANTE NUEVA
				//$folio = $_GET["fol"];										//FOLIO DE LA CARTA PASANTE
				$strCue = $_GET["cta"];											//NUMERO DE CUENTA DEL ALUMNO
				$APa = $_GET["pat"];											//APELLIDO PATERNO DEL ALUMNO
				$AMa = $_GET["mat"];											//APELLIDO MATERNO DEL ALUMNO
				$Nom = $_GET["nom"];											//NOMBRES DEL ALUMNO
				$gen = $_GET["sex"];											//SEXO DEL ALUMNO
				$NoP = $_GET["crr"];											//NOMBRE DE LA CARRERA DEL ALUMNO
				$CTP = $_GET["tot"];											//CREDITOS DE LA CARRERA
				$Pro = $_GET["pro"];											//PROMEDIO DEL ALUMNO
				$PTot= $_GET["por"];											//PORCENTAJE DE CREDITOS OBTENIDOS
				$CTA = $_GET["acu"];											//CREDITOS ACUMULADOS POR EL ALUMNO
				//FECHAS DE INICIO Y TERMINO EN CASO DE ESTAR INSCRITO
				
				$dia = isset($_GET["dtr"]) ? $_GET["dtr"]." DE" : "00"; 		//DIA DE TERMINO EN LA QUE ACREDITO EL TOTAL DE CREDITOS
				$nota_fin = isset($_GET["ftr"]) ? $_GET["ftr"].")" : "NULL"; 	//FECHA EN LA QUE ACREDITO EL TOTAL DE CREDITOS
				
				//FECHA EN LA QUE SE OBTUVO EL 100% DE CREDITOS
				$ciclo = (isset($_GET["ini"]) && isset($_GET["fin"])) ? "que inici&oacute; el ".date("d", strtotime($_GET["ini"]))." de ".$MES[intval(date("m", strtotime($_GET["ini"])))]." de ".date("Y", strtotime($_GET["ini"]))." y concluye el ".date("d", strtotime($_GET["fin"]))." de ".$MES[intval(date("m", strtotime($_GET["fin"])))]." de ".date("Y", strtotime($_GET["fin"])) : NULL;				//FECHAS DE INICIO Y FIN EN CASO DE ESTAR INSCRITO
				$sem = isset($_GET["ult"]) ? $_GET["ult"] : NULL;				//SEMESTRE AL QUE ESTA(UVO) INSCRITO
				
				$nota = "EL ALUMNO CONCLUYO EN EL SEMESTRE ".$sem." (" .$dia." ".$nota_fin.")";
				
				//FECHA DE ALEBORACION DE LA CARTA
				$yy = date("Y");												//AÑO 
				$mm = intval(date("m"));										//MES
				$dd = date("d");												//DIA
				//$fir = "MTLS/".$_SESSION["usrAdmin"];							//USUARIO QUE GENERA LA CARTA PASANTE
				//	unset($_GET);//SE LIMPIA LA VARIABLE GET
				//*************************************************************************************************************************
				//*************************************************************************************************************************
				//SE GENERA EL FOLIO DE LA CARTA PASANTE
				//echo json_encode(intval(substr($PTot, 0, -1))); exit;
				if(intval(substr($PTot, 0, -1)) < 100){//ALUMNO INSCRITO ACTUALMENTE
					$sentencia = "SELECT max(folio), firma  
								FROM pasante, usuarios 
								WHERE folio LIKE 'PA' || substring(CURRENT_DATE::text FROM 3 FOR 2) || '%'
									AND login = '".$_SESSION["usrAdmin"]."' 
								GROUP BY firma;";
					//$rscon = pg_query($sql) or die("Error al consultar permisos");
					$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
					$rpta = pg_fetch_row($ex);
					//pg_free_result($rscon);
					$fir = "MTLS/".$rpta[1];									//SIGLAS DEL USUARIO QUE GENERA LA CARTA PASANTE
					
					if(($rpta[0] == '') || ($rpta[0] == NULL)){//NO HAY FOLIO DEL AÑO EN CURSO EN ALUMNOS INSCRITOS
						$folio = "PA".date("y")."0001";
					} else {//SE ENCONTRO UN FOLIO DEL AÑO EN CURSO
						//$fol++;
						$folio = substr($rpta[0], 0, 4).str_pad((intval(substr($rpta[0], 4))+1), 4, '0', STR_PAD_LEFT );
					}
					//echo substr($rpta[0], 4);
					$sentencia = "INSERT INTO pasante(folio, cuenta, carrera, cred_tot, prom, porce, cred_obt, fecha_fin, sem, fecha_elab, elab)
					VALUES ('$folio', 
								'$strCue', 
								'$NoP', 
								'$CTP', 
								'$Pro', 
								'$PTot', 
								'$CTA',  
								'$ciclo', 
								'$sem', 
								'$yy-$mm-$dd',
								'".$_SESSION["usrAdmin"]."');";
					//************************************************************************************************************************
					//************************************************************************************************************************
				} else if(intval(substr($PTot, 0, -1)) >= 100){//ALUMNO CON 100% DE CREDITOS
					$sentencia = "SELECT max(folio), firma  
								FROM pasante, usuarios 
								WHERE folio LIKE 'PE' || substring(CURRENT_DATE::text FROM 3 FOR 2) || '%'
									AND login = '".$_SESSION["usrAdmin"]."' 
								GROUP BY firma;";
					
					$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
					$rpta = pg_fetch_row($ex);
					//echo json_encode($rpta); exit;
					//pg_free_result($ex);
					
					$fir = "MTLS/".$rpta[1];									//SIGLAS DEL USUARIO QUE GENERA LA CARTA PASANTE
					
					if($rpta[0] == '' || $rpta[0] == NULL){//NO HAY FOLIO DEL AÑO EN CURSO DE ALUMNOS CON 100%
						$folio = "PE".date("y")."0001";
					} else {//SE ENCONTRO UN FOLIO DEL AÑO EN CURSO
						$folio = substr($rpta[0], 0, 4).str_pad((intval(substr($rpta[0], 4))+1), 4, '0', STR_PAD_LEFT);
					}
					$sentencia = "INSERT INTO pasante(folio, cuenta, carrera, cred_tot, prom, porce, cred_obt, fecha_fin, fecha_elab, elab)
							VALUES ('$folio', 
								'$strCue', 
								'$NoP', 
								'$CTP', 
								'$Pro', 
								'$PTot', 
								'$CTA',  
								'$nota', 
								'$yy-$mm-$dd',
								'".$_SESSION["usrAdmin"]."');";
					
					//$_SESSION["unico"] = $folio;//EVITA QUE EL SCRIPT SE EJECUTE MULTIPLES VECES
				}
				//echo json_encode($sentencia); exit;
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$_SESSION["ran"] = $_GET["ran"];
				$_SESSION["ufo"] = $folio;
				@closeConex($ex, $conex);//CERRAMOS LA CONEXION A LA BDD
				//************************************************************************************************************************
				//************************************************************************************************************************
			}
			
			include_once("../../php/mpdf/mpdf.php");//LLAMAMOS A LA LIBRERIA QUE RENERARA EL PDF
			ob_start();//SE INICIA EL BUFFER DE SALIDA DE DATOS PARA CAPTURAR EL FORMATO ANTES DE GENERAR EL PDF
?>
<!Doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="content-language" content="es-MX" />
        <meta http-equiv="robots" content="NOINDEX, NOFOLLOW" />
        
        <title>CARTA PASANTE</title>
        
        <style type="text/css">
			@page{margin: 60px 90px 10px 60px;}
			body{ font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; }
			
			#header, #folio{ text-align: right; font-weight: bold; }
			#folio{ margin: 75px 0 30px 0; font-size: 18px; }
			#folio span{ font-size: 12px; }
			#saludo{ font-weight: bold; }
			#consta{ margin-top: 20px; }
			#consta span{ text-decoration: underline; font-weight: bold; }
			#alumno, #egresado{ text-decoration: none; font-weight: normal; }
			#consta, #nota, #acreditacion{ text-align: justify; margin-top: 20px; }
			#acreditacion span { font-family: Georgia, "Times New Roman", Times, serif; font-style: italic; }
			#fecha{ margin: 70px 0 120px 0; font-weight: bold; text-align: center}
			#firma1, #firma2{ float: left; width: 46%; border-top: 2px solid; margin: 0 0 0 4%; text-align: center; }
			#firma1 span, #firma2 span{ font-size: 11px; }
			#rubrica{ position: absolute; font-size: 10px; top: 1015px; left: 25px;}
        </style>
    </head>
<!--*****************************************************************************************************--><!--*****************************************************************************************************-->
    <body>
    	<div id="header">
        	UNIVERSIDAD NACIONAL AUTONÓMA DE MÉXICO<br>
            SECRETARÍA GENERAL<br>
            DIRECCIÓN GENERAL DE ADMINISTRACIÓN ESCOLAR<br>
            <br>
            FACULTAD DE ESTUDIOS SUPERIORES ARAGÓN<br>
            SECRETARÍA ACADÉMICA<br>
        </div>
        <div id="folio">
        	C O N S T A N C I A<br>
        	<span>con número de folio: <?=$folio?></span>
        </div>
        <div id="saludo">
        	C. DIRECTOR GENERAL DE PROFESIONES<br>
            SECRETARÍA DE EDUCACIÓN PÚBLICA<br>
            P R E S E N T E
        </div>
        <div id="consta">
        	Se hace constar que <?=($gen==='F')?'la':'el'?> alumn<?=($gen==='F')?'a':'o'?>: <span><?=$APa?> <?=$AMa?>, <?=$Nom?></span> 
            con número de cuenta <span><?=$strCue?></span>, de la carrera de: <span><?=$NoP?></span> 
            la cual consta de <span><?=$CTP?></span> créditos y de acuerdo al <i>Sistema Integral de Administración Escolar</i> 
            presenta un promedio de: <span><?=$Pro?></span>. 
            El avance académico actual de <?=($gen==='F')?'la':'el'?> alumn<?=($gen==='F')?'a':'o'?> 
            es de <span><?=$CTA?></span> créditos acumulados que corresponden al
			<?php
			if(intval (substr($PTot, 0, -1)) < 100){
			?>
            <!--CONTENIDO PARA LOS ALUMNOS INSCRITOS AL SEMESTRE EN CURSO-->
            <a id="alumno">
            	<span><?=$PTot?></span> del total de la carrera. 
                Se encuentra actualmente inscrit<?=($gen==='F')?'a':'o'?> en el periodo <span><?=$sem?> <?=$ciclo?></span>.
            </a>
            <?php
			} else {
			?>
            <!--*********************************************************-->
            <!--CONTENIDO PARA LOS ALUMNOS EGRESADOS-->
            <a id="egresado">
            	<!--<span><?=$PTot?></span> del total de la carrera y concluyó la totalidad de los créditos el <span><?=$dia?> <?=substr($nota_fin, 0, -1)?></span>.-->
                100% del total de la carrera y concluyó la totalidad de los créditos el <span><?=$dia?> <?=substr($nota_fin, 0, -1)?></span>.
            </a>
            <!--***/********************************-->
            <?php
			}
			?>
        </div>
        <div id="nota">
        	Así mismo, no ha cometido falta grave en contra de la disciplina universitaria que hubiere sido sancionada.
        </div>
        <div id="acreditacion">
        	Considerando lo anterior, reúne los requisitos para la autorización de la práctica profesional conforme lo establecido 
            en el Artículo 52 del Reglamento de la <span> Ley Reglamentaria del Articulo 5&ordm; Constitucional, 
            relativo al ejercicio de las profesiones en la Ciudad de México</span> y se extiende la presente en apego
            al Artículo 30 de la <span>Ley Reglamentaria del Artículo 5&ordm; Constitucional</span>.
        </div>
        <div id="fecha">
        	A t e n t a m e n t e<br>
            "POR MI RAZA HABLARÁ EL ESPÍRITU"<br>
            Nezahualcóyotl, Estado de México, a <?=$dd?> de <?=$MES[$mm]?> de <?=$yy?>.
        </div>
        <div id="firma1">
        	ING. ALEXIS SAMPEDRO PINTO<br>
            <span>Secretario Académico</span>
        </div>
        <div id="firma2">
        	LIC. DIANA GONZÁLEZ NIETO<br>
            <span>Directora de Certificación y Control Documental</span>
        </div>
        <div id="rubrica"><?=$fir?><br><?=date('ymd')?></div>
    </body>
<!--*****************************************************************************************************-->
</html>
<?php
			//SE VACIA EL CONTENIDO DEL DOCUMENTO EN UNA VARIABLE
			$html = ob_get_clean();
			
			//SE DEFINE UN NUEVO OBJETO DE LA CLASE PDF Y SE CONFIGURA
			$mpdf = new mPDF("c", "letter", "", "", 0, 0, 0, 0, 0, 0);
			
			//SE INDICA QUE EL DOCUMENTO SE DEBE MANDAR IMPRIMIR AUTOMATICAMENTE
			//$mpdf->SetJS("this.print();");
			
			//$mpdf -> SetWatermarkText("NO SE ACEPTE FOTOCOPIA DE ESTE DOCUMENTO");
			//$mpdf -> watermarkTextAlpha = 0.25;
			//$mpdf -> watermark_font = "Arial";
			//$mpdf -> showWatermarkText = true;
			
			//SE ESCRIBE EL CONTENIDO DEL DOCUMENTO
			$mpdf -> WriteHTML($html);			
			
			//SE ENVIA AL NAVEGADOR (COMPORTAMIENTO POR DEFECTO)
			header("Content-type: application/pdf");
			$mpdf->Output("CARTA_PASANTE_".$CTA.".pdf", "I");
			//exit;
		}
		//echo json_encode("ola k ase???");
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
	}else {
		//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		//echo json_encode($_GET["gen"]);
		session_unset();
		session_destroy();
		header("Location: ../../");
	}
?>