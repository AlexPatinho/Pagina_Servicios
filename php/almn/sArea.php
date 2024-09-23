<?php
include_once("../noCache.php");
require_once("../conex.php");

noCache();
session_start();
if(isset($_GET) && isset($_GET["cta"]) and isset($_SESSION) and isset($_SESSION["cta"]) and ($_GET["cta"] === $_SESSION["cta"])){
	
//----Las siguientes variables se tienen que acutalizar cada semestre----------------
	$gen_eco = 2020; //ECONOMIA A PARTIR DE 8vo SEMESTRE, EL TRAMITE LO REALIZAN EN 7mo
	$gen_ing = 2020; //IME, IEE, IIND A PARTIR DE 7mo SEM, EL TRAMITE LO REALIZAN EN 6to
	$gen_com = 2021; //COMyPER  A PARTIR DE 6to SEMESTRE, EL TRAMITE LO REALIZAN EN 5to
//-----------------------------------------------------------------------------------

	$cta = $_GET["cta"];
	$pln = $_GET["pln"];
	$conex = conex("p400");
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$sentencia = "select 'C' as tipo,
						d.cuenta,
						d.plan_e,
						nombre,
						d.gen,
						c.ter 
					from consta c, 
						semes s, 
						diralum d 
					where d.cuenta=c.cuenta 
						and d.plan_e=c.plan_e 
						and d.plan_e=s.plan_e 
						and d.cuenta = '$cta' 
						and d.plan_e='$pln';";
//		echo "\n<br>".$sentencia."<br><br>";
		$ex = pg_query($sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		$arreglo = array();
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$arreglo[] = $resp;
     		$plan=$resp["plan_e"];
			$ter=$resp["ter"];
			$gen=$resp["gen"];
		}
//		echo "plan:".$plan." - ter:".$ter." - gen:".$gen."<br><br>";
        if(( (($plan == "1274" or $plan == "1612") and $gen <= $gen_com)
		or (($plan == "1382" or $plan=="0076") and $gen <= $gen_eco)
		or (($plan == "1291") and $gen <= $gen_eco)
		or (($plan == "1312" or $plan == "1313" or $plan == "1314") and $gen <= $gen_ing) )
		and $ter=='0' ){
//         echo "<br>SI<br>";
          $sentencia = "select count(*) from sarea where cuenta='$cta' and plan_o='$pln'"; 
//          echo $sentencia."<br><br>";
		  $ex=pg_query($sentencia) or die("LA CONSULTA LINEA 54 FALLO: " . pg_last_error());
		  if(pg_result($ex,0)>0){
//			  echo "Tiene tramite<br><br>";
 	        $sentencia = "select 'P' as tipo,
							a.cuenta,
							a.plan_o,
							a.plan_d,
							nombre,
							d.gen,
							fechae 
						from sarea a, 
							semes s, 
							diralum d 
						where d.cuenta=a.cuenta 
							and d.plan_e=a.plan_o 
							and a.plan_d=s.plan_e 
							and a.cuenta = '$cta' 
							and a.plan_o='$pln';";
//		    echo "\n<br>".$sentencia."<br><br>";
		    $ex = pg_query($sentencia) or die("LA CONSULTA LINEA 73 FALLO: " . pg_last_error());
 		    $arreglo = array();
		    while($resp1 = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			 $arreglo[] = $resp1;
			 $ctat=$resp1["cuenta"];
		    }
		  }
		  else{
//			  echo "Sin tramite<br><br>";
		  }
		 }
		 else{
//		   echo "<br>No<br>";
           $arreglo=array();
		 }
//		 if($ctat!=null)
//		  $art22=$art221;
		 // RETURNA VACIO EL ARREGLO CUANDO NO ESTA CAPTURADO
		 // RETORNA CAMPOS DE PERMISO SI ESTA CAPTURADO
        
//		}
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