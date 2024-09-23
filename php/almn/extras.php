<?php
include_once("../noCache.php");
require_once("../conex.php");

noCache();
session_start();

if(isset($_SESSION) 
&& isset($_SESSION["cta"]) 
&& isset($_GET) 
&& isset($_GET["cta"])  
&& isset($_GET["sem"])
&& ($_GET["cta"] === $_SESSION["cta"])){
	
	$cta = $_GET["cta"];
	$pln = $_GET["pln"];
	$conex = conex("p400");
	
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
	}
} else {
	unset($_GET);
	session_unset();
	session_destroy();
	header("Location: ../");
}
?>
