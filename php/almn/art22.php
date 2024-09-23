<?php
include_once("../noCache.php");
require_once("../conex.php");

noCache();
session_start();
if(isset($_GET) && isset($_GET["cta"]) and isset($_SESSION) and isset($_SESSION["cta"]) and ($_GET["cta"] === $_SESSION["cta"])){
	$cta = $_GET["cta"];
	$pln = $_GET["pln"];
//        $art22 = {0,0};
	$conex = conex("p400");
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$sentencia = "select 'C' as tipo, 
						d.cuenta, 
						d.plan_e, 
						nombre,
						art22, 
						c.ter 
					from consta c, 
						semes s, 
						diralum d 
					where d.cuenta=c.cuenta 
						and d.plan_e=c.plan_e 
						and d.plan_e=s.plan_e 
						and d.cuenta = '$cta' 
						and d.plan_e='$pln';";
//		echo $sentencia;
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		$art22 = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$art22[] = $resp;
     		$a22=$resp["art22"];
			$ter=$resp["ter"];
		}
		// RETORNA TIPO=´C´ PARA LA CONSULTA DE AFECTACION DE PERMISO
		if($ter == "0"){
			if($a22<='20231'){
				$sentencia = "select 'P' as tipo,
								p.cuenta, 
								p.plan_e, 
								nombre, 
								art22, 
								p.permiso, 
								fechae 
							from permiso p, 
								semes s, 
								diralum d 
							where d.cuenta=p.cuenta 
								and d.plan_e=p.plan_e 
								and p.plan_e=s.plan_e 
								and p.cuenta = '$cta' 
								and p.plan_e='$pln';";
	//		 echo $sentencia;
			 $ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
			 $art221 = array();
			 while($resp1 = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
				$art221[] = $resp1;
				$ctat=$resp1["cuenta"];
			 }
	//		 if($ctat!=null)
			  $art22=$art221;
			 // RETURNA VACIO EL ARREGLO CUANDO NO ESTA CAPTURADO
			 // RETORNA CAMPOS DE PERMISO SI ESTA CAPTURADO
			}

		} else {
			$art22 = FALSE;
		}
		closeConex($ex, $conex);	
		echo json_encode($art22);
	}
} else {
	unset($_GET);
	session_unset();
	session_destroy();
	header("Location: ../");
}
?>