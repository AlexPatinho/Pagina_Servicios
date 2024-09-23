<?php
include_once("../miscelaneas.php");
require_once("../conex.php");

noCache();

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

session_start();
/*----------------------------------------------------------------*/
/*----------------------------------------------------------------*/
if(isset($_SESSION) && 
	isset($_SESSION["usr"]) && 
	isset($_SESSION["passw"]) && 
	isset($_POST) && 
	isset($_POST["tmp"])){//SI ES LA HORA DE INSCRIPCION DEL ALUMNO
	if($_POST["tmp"] == true){
		echo json_encode(//"<input type=\"hidden\" name=\"usuario\" value=\"".$_SESSION["usr"]."\" />".
						//"<input type=\"hidden\" name=\"contra\" value=\"" . $_SESSION["passw"]."\" />".
						"<input type=\"hidden\" name=\"_username\" value=\"".$_SESSION["usr"]."\" />".
						"<input type=\"hidden\" name=\"_password\" value=\"" . $_SESSION["passw"]."\" />".
						//"<input type=\"hidden\" name=\"_password\" value=\"developPassAltas\" />".
						//"<input type=\"hidden\" name=\"contra\" value=\"" . md5($_SESSION["passw"])."\" />".
						"<input type=\"hidden\" name=\"Accion\" value=\"Login\" />".
						"<input type=\"button\" class=\"lgout\" value=\"INICIAR SESI&Oacute;N\" />");
	} else {
		echo json_encode("");
	}
/*----------------------------------------------------------------*/
/*----------------------------------------------------------------*/
} else if(isset($_POST) && 
		isset($_POST["cta"])){
	$_cta = $_POST["cta"];
	
	$conex = conex("p400");
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		//VERIFICAMOS SI EL ALUMNO SE ENCUENTRA AFECTADO POR ARTICULO 22
		$sentencia = "SELECT CASE 
						WHEN dr.art22 <= (
							SELECT MAX(cve_sem) 
								FROM semestre 
								WHERE activo = true)
						THEN TRUE 
						ELSE FALSE END 
						FROM diralum AS dr 
						WHERE dr.cuenta = '$_cta' 
						AND dr.exa IS NULL 
						ORDER BY dr.gen, dr.exa DESC;";
		$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
		while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
			 $art22 =  $resp[0];
		}
		if($art22 == "t"){
			closeConex($ex, $conex);
			echo json_encode(22);
		} else {
			//SE SELECCIONAN LOS ADEUDOS CUOTA ANUAL Y DE ELLOS SE VERIFICAN LOS QUE ESTAN ACTIVOS
			
			$baucher = '2018-05-13';//FECHA DE INICIO DE ENTREGA DE BAUCHER DE PAGO
			
			$sentencia = "SELECT ".
						"CASE WHEN COUNT(*) > 0 THEN ".
							"(SELECT COUNT(*) ".
							"FROM adeudo ".
							"WHERE fk_tipo_addo = 1 ".
							"AND cuenta = substring('$_cta' FROM 1 FOR 9) ".
							"AND activo = true) ".
						"ELSE -1 END ".
						"FROM adeudo ".
						"WHERE fk_tipo_addo = 1 ".
						"AND NOT fechaadc IS NULL ".
						"AND fechaadc >= '$baucher' ".
						"AND cuenta = substring('$_cta' FROM 1 FOR 9);";
						
			$ex = pg_query($conex, $sentencia) or die("00-LA CONSULTA FALLO: ".pg_last_error());
			
			while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
				 $noInsc =  $resp[0];
			}
			
			if(intval($noInsc) == -1){//NO SE HA REGISTRADO EL PAGO DE CUOTA ANUAL
				closeConex($ex, $conex);
				echo json_encode(-1);
			} else if(intval($noInsc) == 1){//NO HA REALIZADO EL PAGO DE CUOTA ANUAL
				closeConex($ex, $conex);
				echo json_encode(1);
			} else {//PAGO REGISTRADO Y SALDADO
				$annio = date("Y");
				$sentencia = "SELECT random() AS \"RND\", 
				s.carr AS \"NCRR\",".
				" c.nombre AS \"CRR\",".
				" CASE WHEN dr.sis = 'SUA' THEN '132.247.154.43'".
					" WHEN dr.sis = 'ESC' THEN c.ip END AS \"IPCRR\",".
					//" '2014' || s.mdinsc ||".
					" '$annio' || s.mdinsc ||".
					" CASE WHEN s.horainsc = '0' THEN '0800'".
					" WHEN s.horainsc = '1' THEN '0900'".
					" WHEN s.horainsc = '2' THEN '1000'".
					" WHEN s.horainsc = '3' THEN '1100'".
					" WHEN s.horainsc = '4' THEN '1200'".
					" WHEN s.horainsc = '5' THEN '1500'".
					" WHEN s.horainsc = '6' THEN '1600'".
					" WHEN s.horainsc = '7' THEN '1700'".
					" WHEN s.horainsc = '8' THEN '1800'".
					" WHEN s.horainsc = '9' THEN '1900'".
					" WHEN s.horainsc = 'A' THEN '0830'".
					" WHEN s.horainsc = 'B' THEN '0930'".
					" WHEN s.horainsc = 'C' THEN '1030'".
					" WHEN s.horainsc = 'D' THEN '1130'".
					" WHEN s.horainsc = 'E' THEN '1230'".
					" WHEN s.horainsc = 'F' THEN '1530'".
					" WHEN s.horainsc = 'G' THEN '1630'".
					" WHEN s.horainsc = 'H' THEN '1730'".
					" WHEN s.horainsc = 'I' THEN '1830'".
					" WHEN s.horainsc = 'J' THEN '1930'".
					" WHEN s.horainsc = 'Z' THEN '2200'".
				" ELSE '2200' END AS \"FCHINSC\"".
				" FROM sorteo s, carrera c, diralum dr ".
				" WHERE dr.cuenta = substring('$_cta' FROM 1 FOR 9)".//EL NUMERO DE CUENTA EXISTE
				" AND dr.cuenta = s.cuenta ".//EL NUMERO DE CUENTA EN LA TRAYECTORIA COINCIDE CON EL DE SORTEO
				" AND s.carr = c.carr".	//LA CARRERA EN SORTEO COINCIDE CON LAS CARRERAS REGISTRADAS
				" AND dr.carr = s.carr".//LA CARRERA EN LA TRAYECTORIA DEL ALUMNO COINCIDE CON LA CARRERA EN SORTEO
				" AND dr.exa IS NULL;";//EL ALUMNO ESTA ACTIVO EN EL PLANTEL
				
				$ex = pg_query($conex, $sentencia) or die("01-LA CONSULTA FALLO: " . pg_last_error());
				
				$_SESSION["hrInsc"] = array();
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$_SESSION["hrInsc"][] = $resp;
				}
				
				closeConex($ex, $conex);
				echo json_encode($_SESSION["hrInsc"]);
			}
		}
	}
	
/*----------------------------------------------------------------*/
/*----------------------------------------------------------------*/
} elseif(isset($_POST) && 
		isset($_POST["hrInsc"]) && 
		isset($_POST["nCrr"]) && 
		isset($_SESSION["hrInsc"])){
	$r = false;
	for($i = 0; $i < 5; $i++){
		if($_POST["nCrr"] == $_SESSION["hrInsc"][$i]["NCRR"] &&  $_POST["hrInsc"] == $_SESSION["hrInsc"][$i]["FCHINSC"]){//SE VERIFICA QUE LA(S) HORA(S) DE INSCRIPCION DEL ALUMNO SEAN VALIDAS
			$r = true;
			break;
		}
	}
	
	echo json_encode($r);
} else {
	unset($_POST["tmp"]);
	unset($_POST["cta"]);
	unset($_POST["hrInsc"]);
	unset($_POST["nCrr"]);
	session_unset();
	session_destroy();
}
?>