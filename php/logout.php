<?php
	//ELIMINA LA SESION INICIADA POR EL USUARIO,
	//SI SE ENVIA EL PARAMETRO loc COMO true
	//SE REDIRACCIONA AL INDEX DEL SITIO, DE LO CONTRARIO
	//SOLO CIERRA LA SESION
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	include_once("miscelaneas.php");
	noCache();
	
	
	if(isset($_GET) and isset($_GET["loc"])){
		session_start();
		foreach ( $_COOKIE as $key => $value ){
			setcookie( $key, "", time() - 3600, '/' );
		}
		if(isset($_SESSION["cta"]) and isset($_SESSION["plan"])){
			regBita($_SESSION["cta"], $_SESSION["plan"], "O", "exito");
		}
		session_unset();
		session_destroy();
		if($_GET["loc"] == 'true'){
			header("Location: ../");
		}
	} else {
		header("Location: ../");
	}
?>