<?php
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	/////////////////////////////////////////////////////
	if(isset($_POST) and 
		isset($_POST["usr"]) and 
		isset($_POST["pass"])/* and isset($_POST["sec"])*/){
		//if(md5($_SERVER['REMOTE_ADDR'].",".substr($_SERVER['HTTP_REFERER'], 0, 22)) == $_POST["sec"]){
			$usr = $_POST["usr"];
			$passw = strtolower ($_POST["pass"]);
			$conex = conex("usuarios");
			if(!$conex){
				echo "ERROR DE CONEXI&Oacute;N: ".pg_last_error();
				exit;
			} else {
				$sentencia = "SELECT CASE WHEN login = 'BIBLIOTECA' THEN TRUE".
							" WHEN login = 'BIBADM' THEN TRUE".
							" ELSE FALSE END AS okLogin, ".
							" (passmd5 = md5('$passw')) AS okPass,".
							" (permiso = '100000000000') AS okperm".
							" FROM usuario ".
							" WHERE login ILIKE '$usr';";
				$ex = pg_query($conex, $sentencia) or die('LA CONSULTA FALLO: ' . pg_last_error());
				$usrBib = "-1";
				$okP = "-1";
				if (pg_num_rows($ex) < 1){
					closeConex($ex, $conex);
					echo json_encode("A");//EL USUARIO ES INCORRECTO
				} else {
					while($resp = pg_fetch_array($ex, NULL, PGSQL_NUM)){
						 $usrBib = $resp[0];
						 $okPass = $resp[1];
						 $okPerm = $resp[2];
					}
					closeConex($ex, $conex);
					if($okPass == "f"){
						unset($_POST);
						echo json_encode("B");//LA CONTRASEÑA ES INCORRECTA
					} else if($usrBib == "f"){
						unset($_POST);
						echo json_encode("C");//EL USUARIO NO ES EL DE BIBLIOTECA
					} else if($okPerm == "f"){
						unset($_POST);
						echo json_encode("D");//EL NIVEL DE PERMISOS ES INSUFICIENTE
					} else  {
						session_start();
						$_SESSION["usrBib"] = strtoupper($usr);
						echo json_encode("E");//PEREMISOS Y CONTRASEÑA CORRECTOS
					}
				}
			}
	}else{
		echo "Error de conexi&oacute;n con el servidor.";
	}
?>