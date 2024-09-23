<?php
	include_once("../miscelaneas.php");
	include_once("../fecha.php");
	require_once("../conex.php");
	
	noCache();
	session_start();
	
	/*if(true){
		echo json_encode($_POST["chk"]);
	} else*/
	if(isset($_SESSION) 
	&& isset($_SESSION["cta"]) 
	&& isset($_POST) 
	&& isset($_POST["cta"])
	&& ($_POST["cta"] === $_SESSION["cta"])   
	&& isset($_POST["pln"])
	&& ($_POST["pln"] === $_SESSION["plan"]) 
	&& isset($_POST["chk"])
	&& $_POST["chk"] == true ){
/*----------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------*/
//SE OBTIENEN LOS DATOS DEL ALUMNO
		$cta = $_POST["cta"];
		$pln = $_POST["pln"];
		$conex = conex("p400");
		
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "SELECT 
							domi.email, 
							semes.plan_e, 
							semes.nombre, 
							semes.gen, 
							diralum.sis, 
							consta.turno,
							count(cuespi20171.*)
						FROM 
							public.domi, 
							public.semes, 
							public.diralum, 
							public.consta 
						LEFT JOIN public.cuespi20171 
							ON consta.cuenta = cuespi20171.cuenta AND consta.plan_e = cuespi20171.plan
						WHERE 
							domi.cuenta = diralum.cuenta AND
							domi.cuenta = consta.cuenta AND
							diralum.plan_e = semes.plan_e AND
							diralum.plan_e = consta.plan_e AND 
							domi.cuenta = '$cta' AND
							diralum.plan_e = '$pln' AND
							diralum.gen = '2017'
						GROUP BY domi.email, 
							semes.plan_e, 
							diralum.sis, 
							consta.turno;";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC);
			
			closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
			echo json_encode($resp);//SE ENVIAN LOS DATOS AL CLIENTE	
		}
/*----------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------*/
//SE INGRESAN LAS RESPUESTAS A LA BDD
	} elseif(isset($_SESSION) 
	&& isset($_SESSION["cta"]) 
	&& isset($_POST) 
	&& isset($_POST["cta"])
	&& ($_POST["cta"] === $_SESSION["cta"])   
	&& isset($_POST["pln"])
	&& ($_POST["pln"] === $_SESSION["plan"]) 
	&& isset($_POST["ques"])
	&& $_POST["ques"] == true ) {
		//echo json_encode($_POST);
		
		$cta = isset($_POST["cta"]) ? $_POST["cta"] : "";
		$pln = isset($_POST["pln"]) ? $_POST["pln"] : "";
		$con = date('Y-m-d H:s:i');
		
		$q1 = isset($_POST["q1"]) ? $_POST["q1"] : "";
		$q1_1 = isset($_POST["q1_1"]) ? $_POST["q1_1"] : "";
		
		$q2 = isset($_POST["q2"]) ? $_POST["q2"] : "";
		$q2_1 = isset($_POST["q2_1"]) ? $_POST["q2_1"] : "";
		
		$q3 = isset($_POST["q3"]) ? $_POST["q3"] : "";
		
		$q4_1 = isset($_POST["q4_1"]) ? $_POST["q4_1"] : "";
		$q4_2 = isset($_POST["q4_2"]) ? $_POST["q4_2"] : "";
		$q4_3 = isset($_POST["q4_3"]) ? $_POST["q4_3"] : "";
		$q4_4 = isset($_POST["q4_4"]) ? $_POST["q4_4"] : "";
		$q4_5 = isset($_POST["q4_5"]) ? $_POST["q4_5"] : "";
		$q4_6 = isset($_POST["q4_6"]) ? $_POST["q4_6"] : "";
		$q4_7 = isset($_POST["q4_7"]) ? $_POST["q4_7"] : "";
		$q4_8 = isset($_POST["q4_8"]) ? $_POST["q4_8"] : "";
		$q4_9 = isset($_POST["q4_9"]) ? $_POST["q4_9"] : "";
		$q4_10 = isset($_POST["q4_10"]) ? $_POST["q4_10"] : "";
		$q4_11 = isset($_POST["q4_11"]) ? $_POST["q4_11"] : "";
		$q4_12 = isset($_POST["q4_12"]) ? $_POST["q4_12"] : "";
		$q4_13 = isset($_POST["q4_13"]) ? $_POST["q4_13"] : "";
		$q4_14 = isset($_POST["q4_14"]) ? $_POST["q4_14"] : "";
		$q4_15 = isset($_POST["q4_15"]) ? $_POST["q4_15"] : "";
		$q4_16 = isset($_POST["q4_16"]) ? $_POST["q4_16"] : "";
		$q4_17 = isset($_POST["q4_17"]) ? $_POST["q4_17"] : "";
		$q4_18 = isset($_POST["q4_18"]) ? $_POST["q4_18"] : "";
		$q4_19 = isset($_POST["q4_19"]) ? $_POST["q4_19"] : "";
		$q4_20 = isset($_POST["q4_20"]) ? $_POST["q4_20"] : "";
		
		$q5_1 = isset($_POST["q5_1"]) ? $_POST["q5_1"] : "";
		$q5_2 = isset($_POST["q5_2"]) ? $_POST["q5_2"] : "";
		$q5_3 = isset($_POST["q5_3"]) ? $_POST["q5_3"] : "";
		$q5_4 = isset($_POST["q5_4"]) ? $_POST["q5_4"] : "";
		
		$q6_1 = isset($_POST["q6_1"]) ? $_POST["q6_1"] : "";
		$q6_2 = isset($_POST["q6_2"]) ? $_POST["q6_2"] : "";
		$q6_2_1 = isset($_POST["q6_2_1"]) ? $_POST["q6_2_1"] : "";
		$q6_3 = isset($_POST["q6_3"]) ? $_POST["q6_3"] : "";
		
		$q7_1 = isset($_POST["q7_1"]) ? $_POST["q7_1"] : "";
		$q7_2 = isset($_POST["q7_2"]) ? $_POST["q7_2"] : "";
		$q7_3 = isset($_POST["q7_3"]) ? $_POST["q7_3"] : "";
		$q7_4 = isset($_POST["q7_4"]) ? $_POST["q7_4"] : "";
		$q7_5 = isset($_POST["q7_5"]) ? $_POST["q7_5"] : "";
		$q7_6 = isset($_POST["q7_6"]) ? $_POST["q7_6"] : "";
		$q7_7 = isset($_POST["q7_7"]) ? $_POST["q7_7"] : "";
		$q7_8 = isset($_POST["q7_8"]) ? $_POST["q7_8"] : "";
		$q7_9 = isset($_POST["q7_9"]) ? $_POST["q7_9"] : "";
		
		$q8_1 = isset($_POST["q8_1"]) ? $_POST["q8_1"] : "";
		$q8_2 = isset($_POST["q8_2"]) ? $_POST["q8_2"] : "";
		$q8_3 = isset($_POST["q8_3"]) ? $_POST["q8_3"] : "";
		$conex = conex("p400");
		
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "INSERT INTO cuespi20171 values(
							'$cta', 
							'$pln', 
							'$con', 
							'$q1', 
							'$q1_1', 
							'$q2', 
							'$q2_1', 
							'$q3', 
							'$q4_1', 
							'$q4_2', 
							'$q4_3', 
							'$q4_4', 
							'$q4_5', 
							'$q4_6', 
							'$q4_7', 
							'$q4_8', 
							'$q4_9', 
							'$q4_10', 
							'$q4_11', 
							'$q4_12', 
							'$q4_13', 
							'$q4_14', 
							'$q4_15', 
							'$q4_16', 
							'$q4_17',  
							'$q4_18',  
							'$q4_19',  
							'$q4_20', 
							'$q5_1', 
							'$q5_2', 
							'$q5_3', 
							'$q5_4', 
							'$q6_1', 
							'$q6_2', 
							'$q6_2_1', 
							'$q6_3', 
							'$q7_1', 
							'$q7_2', 
							'$q7_3', 
							'$q7_4', 
							'$q7_5', 
							'$q7_6', 
							'$q7_7', 
							'$q7_8', 
							'$q7_9', 
							'$q8_1', 
							'$q8_2', 
							'$q8_3');";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$resp = pg_affected_rows($ex);
		}
		closeConex($ex, $conex);//CIERRE DE CONEXION A LA BDD
		echo json_encode($resp);//SE ENVIAN LOS DATOS AL CLIENTE	
/*----------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------*/
	} else {
		unset($_GET);
		session_unset();
		session_destroy();
		header("Location: ../");
	}
?>