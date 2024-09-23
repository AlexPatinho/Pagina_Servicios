<?php
include_once("../noCache.php");
require_once("../conex.php");

noCache();
session_start();
if(isset($_GET) && isset($_GET["cta"]) and isset($_SESSION) and isset($_SESSION["cta"]) and ($_GET["cta"] === $_SESSION["cta"])){
	$cta = $_GET["cta"];
	$pln = $_GET["pln"];
	$conex = conex("p400");
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$sentencia = "select 'C' as tipo,d.cuenta,d.plan_e,nombre,d.gen,esta,nota as foto,ter from domi d0,consta c, semes s, diralum d where d0.cuenta=d.cuenta and d.cuenta=c.cuenta and d.plan_e=c.plan_e and d.plan_e=s.plan_e and d.cuenta = '$cta' and d.plan_e='$pln';";
//		echo "\n<br>".$sentencia."<br><br>";
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		$arreglo = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$arreglo[] = $resp;
     		        $plan=$resp["plan_e"];
			$ter=$resp["ter"];
			$gen=$resp["gen"];
			$fot=$resp["foto"];
			$Est=$resp["esta"];
		}
//		echo "plan:".$plan." - ter:".$ter." - gen:".$gen." - Esta:".$Est." - fot:".$fot."<br><br>";
        if( $Est=='1' and $ter=='0' and $fot=='1'){     //esta dentro de las reglas para tramite
          $sentencia = "select count(*) from credencial where cuenta='$cta' and plan_e='$pln' and (semestre=='20151' or fentrega is null)"; 
//          echo $sentencia."<br><br>";
          $ex=pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
          if(pg_result($ex,0)>0){    //tiene tramite en proceso
//	     echo "Tiene tramite<br><br>";
             $sentencia = "select 'T' as tipo,cuenta,c.plan_e,foto,ftramite,fenvio,frecibe,fentrega,semestre,nombre from credencial c,semes s where c.plan_e=s.plan_e and cuenta='$cta' and c.plan_e='$pln' and (substring(semestre,0,4)=='2015' or fentrega is null)"; 
//	     echo "\n<br>".$sentencia."<br><br>";
	     $ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
 	     $arreglo = array();
	     while($resp1 = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
	       $arreglo[] = $resp1;
	       $ctat=$resp1["cuenta"];
	     }
	  }
	  else{     //no tiene tramite
	   $sentencia = "select 'I' as tipo,d.cuenta,d.plan_e,nombre,d.gen,esta,nota,ter,d.carr from domi d0,consta c, semes s, diralum d where d0.cuenta=d.cuenta and d.cuenta=c.cuenta and d.plan_e=c.plan_e and d.plan_e=s.plan_e and d.cuenta = '$cta' and d.plan_e='$pln';";
//	   echo "\n<br>".$sentencia."<br><br>";
	   $ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
           $arreglo = array();
	   while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
	     $arreglo[] = $resp;
	   }
	  }
	}
//	else{
//		   echo "<br>No<br>";
//          $arreglo=array();
//	}
	closeConex($ex, $conex);	
	echo json_encode($arreglo);
	}
} else {
	unset($_GET);
	session_unset();
	session_destroy();
	header("Location: ../");
}
?>
