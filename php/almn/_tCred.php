<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
include_once("../miscelaneas.php");
require_once("../conex.php");

noCache();
if(!(time() >= strtotime("2023-02-07 00:01:00") && 
     time() <= strtotime("2023-05-26 23:59:59"))){
	header("Location: ../../");
}
session_start();
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
if(isset($_SESSION) && 
	isset($_SESSION["cta"]) && 
	isset($_SESSION["plan"]) &&
	isset($_POST) &&
	isset($_POST["cta"]) &&
	isset($_POST["plan"]) &&
	isset($_POST["key"])){
	
	$conex = conex("p400");
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		if(($_SESSION["cta"] == $_POST["cta"]) && 
		($_SESSION["plan"] == $_POST["plan"]) && 
		(md5($_SESSION["passw"]) == $_POST["key"])){
			
			$cta = $_POST["cta"];
			$plan = $_POST["plan"];
			$sent = "SELECT 
						a.cuenta AS \"CTA\", 
						a.paterno || ' ' || a.materno || ', ' || a.nombres AS \"NOM\",
					CASE WHEN b.ftramite IS NULL
						THEN 'PENDIENTE'
						ELSE substring(b.ftramite FROM 1 FOR 2) || '-' || substring(b.ftramite FROM 3 FOR 2) || '-' || substring(b.ftramite FROM 5 FOR 4)
					END AS \"FTR\",
					CASE WHEN b.frecibe IS NULL
						THEN 'PENDIENTE'
						ELSE substring(b.frecibe FROM 1 FOR 2) || '-' || substring(b.frecibe FROM 3 FOR 2) || '-' || substring(b.frecibe FROM 5 0FOR 4)
					END AS \"FIM\",
					CASE WHEN b.fentrega IS NULL
						THEN 'PENDIENTE'
						ELSE substring(b.fentrega FROM 1 FOR 2) || '-' || substring(b.fentrega FROM 3 FOR 2) || '-' || substring(b.fentrega FROM 5 FOR 4)
					END AS \"FEN\",
						c.nombre AS \"CRR\"
					FROM 
						domi AS a
						JOIN credencial AS b ON a.cuenta = b.cuenta 
						JOIN carrera AS c ON b.carr = c.carr
					WHERE
						a.cuenta = '$cta' AND 
						b.plan_e = '$plan' AND
						b.fentrega IS NULL
					LIMIT 1;";
			$ex = pg_query($sent) or die("LA CONSULTA FALLO: " . pg_last_error());
			if(pg_num_rows($ex) > 0){
				//SI EXISTE AL MENOS UN REGISTRO DE CREDENCIAL DEL SEMESTRE ACTUAL
				$data = array();
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$data[] = $resp;
				}
				$data["0"]["TRA"] = true;
				closeConex($ex, $conex);
				echo json_encode($data);
			} else {
				if(date("N") == 1 or date("N") == 2 or date("N") == 0){ //SI ES LUNES[1] O MARTES[2] U OTRO DIA EN PRUEBA[0]
					//SI NO EXISTEN REGISTROS DE CREDENCIAL DEL SEMESTRE EN CURSO
					$sent = "SELECT 
								a.cuenta  AS \"CTA\", 
								a.paterno AS \"PAT\", 
								a.materno AS \"MAT\", 
								a.nombres AS \"NOM\", 
								c.nombre  AS \"CRR\"
							FROM domi AS a 
								JOIN diralum AS b ON a.cuenta = b.cuenta
								JOIN semes AS c ON b.carr = c.carr
							WHERE
								a.cuenta = '$cta' AND 
								b.plan_e = '$plan' AND
								c.plan_e = b.plan_e;";
					$ex = pg_query($sent) or die("LA CONSULTA FALLO: " . pg_last_error());
					$data = array();
					while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
						$data[] = $resp;
					}
					closeConex($ex, $conex);
					
					//$foto = "http://132.248.44.212/FOTOS/".$cta.".jpg";
					$foto = "http://aragon.dgae.unam.mx/208/fotos/".$cta.".jpg";
					$file_headers = @get_headers($foto);
					if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
						$data["0"]["OKP"] = 0;//NO TIENE FOTOGRAFIA EN EL SISTEMA
						$data["0"]["PIC"] = "../imgs/noDisponible.jpg";
					} else {
						$data["0"]["OKP"] = 1;//TIENE FOTOGRAFIA EN EL SISTEMA
						$data["0"]["PIC"] = $foto;
						//$data["0"]["PIC"] = "../imgs/noDisponible.jpg";
					}
					//SE ENVIA LA INFORMACION CON LA QUE SERA TRAMITADA LA CREDENCIAL
					echo json_encode($data);
				} else {
					//NO ES EL DIA PARA EL TRAMITE
					closeConex($ex, $conex);
					echo json_encode(0);
				}
			}
		} else {
			//LOS DATOS ENVIADOS NO SON CORRECTOS
			closeConex($ex, $conex);
			echo json_encode("Z");
		}
	}

/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
} else if(isset($_SESSION) && 
	isset($_SESSION["cta"]) && 
	isset($_SESSION["plan"]) &&
	isset($_POST) &&
	isset($_POST["cta"]) &&
	isset($_POST["plan"]) &&
	isset($_POST["agree"]) &&
	isset($_POST["okp"])){
		
	$conex = conex("p400");
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		if(($_SESSION["cta"] == $_POST["cta"]) and ($_SESSION["plan"] == $_POST["plan"]) ){
			//SI LOS DATO MANDADOS COINCIDEN CON LOS DATOS DE LA SESION
			if($_POST["okp"] == "1"){//SI CUENTA CON FOTOGRAFIA EN EL SISTEMA
				$cta = $_POST["cta"];
				$plan = $_POST["plan"];
				$sem = '20232';
				
				//---------------------------------------------------------------
				//VALIDA EL NO DE TRAMITES QUE SE HAN GENERADO EN LA SEMANA
				$sql  = "SELECT count(*) FROM credencial WHERE fenvio IS NULL;";
				$result = pg_query($sql);
				$resp = pg_fetch_row($result);
				if ($resp[0] >='500')
				{
					echo json_encode("G");
					exit;
				}
				//---------------------------------------------------------------
/*				// SE CANCELA EL TRÁMITE PARA ALUMNOS QUE RENOVARAN BIOMETRICOS
				$sql_2 = "SELECT cuenta FROM biometricos WHERE cuenta ='$cta' AND plan_e='$plan' ";
				$result_2 = pg_query($sql_2);
				$resp_2 = pg_fetch_row($result_2);
				if ($resp_2[0] >'0') 
				{
					echo json_encode("H");
					exit;
				}
				//---------------------------------------------------------------
				
				//---------------------------------------------------------------
				// ALUMNOS QUE NO HAN RECOGIDO CREDENCIAL DE PRIMER INGRESO
				$sql_3 = "SELECT cuenta FROM diralum WHERE cuenta ='$cta' AND plan_e='$plan' and gen in ('2023') ";
				$result_3 = pg_query($sql_3);
				$resp_3 = pg_fetch_row($result_3);
				if ($resp_3[0] > '0') 
				{
					echo json_encode("I");
					exit;
				}
*/				//---------------------------------------------------------------


				$sent = "SELECT 
						CASE 
							WHEN esta = '1' AND (ter = '0' OR ter IS NULL) 
							THEN TRUE 
							ELSE FALSE
						END
						FROM consta
						WHERE cuenta = '$cta'AND
							plan_e = '$plan'
						LIMIT 1;";
				$ex = pg_query($sent) or die("LA CONSULTA FALLO: " . pg_last_error());
				while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
					$insc = $resp[0];
				}
				closeConex($ex, $conex);
				if($insc == "t"){
					//SE ENCUENTRA INSCRITO EN EL SEMESTRE
					$conex = conex("p400");
					$sent = "SELECT count(*) 
							FROM credencial 
							WHERE cuenta = '$cta' AND 
								plan_e = '$plan' AND 
								semestre = '$sem';";
					$ex = pg_query($sent) or die("LA CONSULTA FALLO: " . pg_last_error());
					while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
						$tra = $resp[0];
					}
					closeConex($ex, $conex);
					if(intval($tra) < 5){ //NUMERO DE TRAMITES PERMITIDOS POR SEMESTRE
						$conex = conex("p400");
						//TIENE PERMITIDO TRAMITAR CREDENCIAL EN EL SEMESTRE EN CURSO
						$fecha = date("dmY");
						$hora = date("H:i:s");
						$sent = "INSERT INTO 
									credencial(cuenta, carr, plan_e, ftramite, utramite, foto, semestre)
								VALUES('$cta', (SELECT carr FROM diralum WHERE cuenta = '$cta' AND plan_e = '$plan' LIMIT 1), '$plan', '$fecha', '$hora', '1', '$sem');";
						$ex = pg_query($sent) or die("LA CONSULTA FALLO: " . pg_last_error());
						if(pg_affected_rows($ex) == 1){
							//SE REALIZO LA SOLICITUD DE TRAMITE CORRECTAMENTE
							closeConex($ex, $conex);
							echo json_encode("F");
						} else {
							//NO SE PUDO REALIZAR EL TRAMITE
							closeConex($ex, $conex);
							echo json_encode("E");
						}
					} else {
						//YA HA LLEGADO AL MAXIMO DE TRAMITES EN EL SEMESTRE EN CURSO
						echo json_encode("D");
					}
				} else {
					//NO ESTA INSCRITO EN EL SEMESTRE
					echo json_encode("C");
				}
			} else {
				//NO CUENTA CON FOTOGRAFIA EN EL SISTEMA
				echo json_encode("B");
			}
		} else {
			//LOS DATOS MADADOS NO CORRESPONDEN CON LOS DATOS DE SESION
			echo json_encode("A");
		}
	}
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
} else {
	unset($_POST);
	session_unset();
	session_destroy();
	header("Location: ../../");
}
?>
