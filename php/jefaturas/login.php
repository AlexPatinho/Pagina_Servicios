<?php
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	/////////////////////////////////////////////////////
	if(isset($_POST) and 
	isset($_POST["usr"]) and 
	isset($_POST["pass"])){
		$user = limpiarVariable(strtoupper($_POST["usr"]));
		$pass = limpiarVariable($_POST["pass"]);
		//$ip = getIP();
		$ip = "132.248.44.207";
		
		$conex = conex("p400");
		
		if(!$conex){
			echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
			exit;
		} else {
			$sentencia = "SELECT a.usuario, 
							a.pass = md5('$pass'), 
							a.dir_ip = '$ip', 
							a.sis, 
							b.ip, 
							a.carr, 
							b.nombre 
						FROM 
							usuario_jefatura AS a 
							JOIN carrera AS b ON a.carr = b.carr 
						WHERE a.usuario = '$user' 
						AND a.activo;";
			$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
			
			if (pg_num_rows($ex) > 0){//EL USUARIO EXISTE EN LA BDD
				
				$userJef = NULL;
				$okPassw = NULL;
				$okDirIp = NULL;
				$ipGpos = NULL;
				$cveCarr = NULL;
				$nomCarr = NULL;

				while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
					$userJef = $resp[0];
					$okPassw = $resp[1];
					$okDirIp = $resp[2];
					$sistema = $resp[3];
					$ipGpos = explode(".", $resp[4]);
					$cveCarr = $resp[5];
					$nomCarr = $resp[6];
				}
				
				closeConex($ex, $conex);
				
				//**********************************************************************************
				//**********************************************************************************
				//**********************************************************************************
				//DIRECCIONES IP SERVESC
				switch($ip){
					case "132.248.44.210":
					case "132.248.44.213":
					case "132.248.44.213":
					case "132.248.44.207":{
						$okDirIp = "t";
						break;
					}
				}
				//**********************************************************************************
				//**********************************************************************************
				//**********************************************************************************
				$okDirIp = "t";
				if($okDirIp === "t"){//LA DIRECCION IP ES LA REGISTRADA
					if($okPassw === "t"){//LA CONTRASEÑA ES CORRECTA
						session_start();
						
						$_SESSION["usrJef"] = $userJef;
						$_SESSION["carr"] = $cveCarr;
						$_SESSION["nCarr"] = $nomCarr;
						$_SESSION["serv"] = $ipGpos[3];
						$_SESSION["sis"] = $sistema;
						
						echo json_encode("D");
					} else {//LA CONTRASEÑA ES INCORRECTA
						unset($_POST);
						echo json_encode("C");
					}
				} else {//LA DIRECCION IP NO ES LA ASIGNADA PARA ESTE USUSARIO
					unset($_POST);
					echo json_encode("B");
				}
			} else {//EL USUARIO ES INCORRECTO
				closeConex($ex, $conex);
				echo json_encode("A");
			}
		}
	}else{
		echo "Error de conexi&oacute;n con el servidor.";
	}
?>