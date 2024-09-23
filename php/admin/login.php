<?php
	include_once("../noCache.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	/////////////////////////////////////////////////////
	if(isset($_POST) and 
		isset($_POST["usr"]) and 
		isset($_POST["pass"])/* and isset($_POST["sec"])*/){
		//if(md5($_SERVER['REMOTE_ADDR'].",".substr($_SERVER['HTTP_REFERER'], 0, 22)) == $_POST["sec"]){
			$usr = $_POST["usr"];
			$passw = $_POST["pass"];
			$conex = conex("usuarios");
			if(!$conex){
				echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
				exit;
			} else {
				$sentencia = "SELECT login, ".
							"(passmd5 = md5('$passw')) AS okPass, ".
							"(permiso = '100000000000') AS okperm, ".
							"nombre ".
							"FROM usuario ".
							"WHERE login ILIKE '$usr';";
				$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
				$usrVent = "-1";
				$okP = "-1";
				if (pg_num_rows($ex) < 1){
					//EL USUARIO ES INCORRECTO
					closeConex($ex, $conex);
					echo json_encode("A");
				} else {
					while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
						 $usrVent = $resp[0];
						 $okPass = $resp[1];
						 $okPerm = $resp[2];
						 $usrNom = $resp[3];
					}
					closeConex($ex, $conex);
					
					if($okPass == "f"){
						//LA CONTRASEÑA ES INCORRECTA
						unset($_POST);
						echo json_encode("B");
					} else if($okPerm == "f"){
						//EL NIVEL DE PERMISOS ES INSUFICIENTE
						unset($_POST);
						echo json_encode("C");
					} else {
						//PEREMISOS Y CONTRASEÑA CORRECTOS
						session_start();
						$_SESSION["usrAdmin"] = $usrVent;
						$_SESSION["usrNom"] = $usrNom;
						echo json_encode("D");
					}
				}
			}
	}else{
		echo "Error de conexi&oacute;n con el servidor.";
	}
?>