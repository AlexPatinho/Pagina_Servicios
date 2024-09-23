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
							count(cuespi20161.*)
						FROM 
							public.domi, 
							public.semes, 
							public.diralum, 
							public.consta 
						LEFT JOIN public.cuespi20161 
							ON consta.cuenta = cuespi20161.cuenta AND consta.plan_e = cuespi20161.plan
						WHERE 
							domi.cuenta = diralum.cuenta AND
							domi.cuenta = consta.cuenta AND
							diralum.plan_e = semes.plan_e AND
							diralum.plan_e = consta.plan_e AND 
							domi.cuenta = '$cta' AND
							diralum.plan_e = '$pln' AND
							diralum.gen = '2016'
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
		$q5_1 = isset($_POST["q5_1"]) ? $_POST["q5_1"] : "";
		$q5_2 = isset($_POST["q5_2"]) ? $_POST["q5_2"] : "";
		$q5_3 = isset($_POST["q5_3"]) ? $_POST["q5_3"] : "";
		$q5_4 = isset($_POST["q5_4"]) ? $_POST["q5_4"] : "";
		$q5_5 = isset($_POST["q5_5"]) ? $_POST["q5_5"] : "";
		$q5_6 = isset($_POST["q5_6"]) ? $_POST["q5_6"] : "";
		$q5_7 = isset($_POST["q5_7"]) ? $_POST["q5_7"] : "";
		$q5_8 = isset($_POST["q5_8"]) ? $_POST["q5_8"] : "";
		$q5_9 = isset($_POST["q5_9"]) ? $_POST["q5_9"] : "";
		$q5_10 = isset($_POST["q5_10"]) ? $_POST["q5_10"] : "";
		$q5_11 = isset($_POST["q5_11"]) ? $_POST["q5_11"] : "";
		$q5_12 = isset($_POST["q5_12"]) ? $_POST["q5_12"] : "";
		$q5_13 = isset($_POST["q5_13"]) ? $_POST["q5_13"] : "";
		$q6_1 = isset($_POST["q6_1"]) ? $_POST["q6_1"] : "";
		$q6_2 = isset($_POST["q6_2"]) ? $_POST["q6_2"] : "";
		$q6_3 = isset($_POST["q6_3"]) ? $_POST["q6_3"] : "";
		$q6_4 = isset($_POST["q6_4"]) ? $_POST["q6_4"] : "";
		$q6_5 = isset($_POST["q6_5"]) ? $_POST["q6_5"] : "";
		$q7 = isset($_POST["q7"]) ? $_POST["q7"] : "";
		$q8 = isset($_POST["q8"]) ? $_POST["q8"] : "";
		$q8_1 = isset($_POST["q8_1"]) ? $_POST["q8_1"] : "";
		$q9_1 = isset($_POST["q9_1"]) ? $_POST["q9_1"] : "";
		$q9_2 = isset($_POST["q9_2"]) ? $_POST["q9_2"] : "";
		$q9_3 = isset($_POST["q9_3"]) ? $_POST["q9_3"] : "";
		$q9_4 = isset($_POST["q9_4"]) ? $_POST["q9_4"] : "";
		$q9_5 = isset($_POST["q9_5"]) ? $_POST["q9_5"] : "";
		$q9_6 = isset($_POST["q9_6"]) ? $_POST["q9_6"] : "";
		$q9_7 = isset($_POST["q9_7"]) ? $_POST["q9_7"] : "";
		$q9_8 = isset($_POST["q9_8"]) ? $_POST["q9_8"] : "";
		$q9_9 = isset($_POST["q9_9"]) ? $_POST["q9_9"] : "";
		$q9_9_1 = isset($_POST["q9_9_1"]) ? $_POST["q9_9_1"] : "";
		$q10_1 = isset($_POST["q10_1"]) ? $_POST["q10_1"] : "";
		$q10_2 = isset($_POST["q10_2"]) ? $_POST["q10_2"] : "";
		$q10_2_1 = isset($_POST["q10_2_1"]) ? $_POST["q10_2_1"] : "";
		$q10_3 = isset($_POST["q10_3"]) ? $_POST["q10_3"] : "";
		$q11 = isset($_POST["q11"]) ? $_POST["q11"] : "";
		$q12_1 = isset($_POST["q12_1"]) ? $_POST["q12_1"] : "";
		$q12_2 = isset($_POST["q12_2"]) ? $_POST["q12_2"] : "";
		$q12_3 = isset($_POST["q12_3"]) ? $_POST["q12_3"] : "";
		$q12_4 = isset($_POST["q12_4"]) ? $_POST["q12_4"] : "";
		$q12_5 = isset($_POST["q12_5"]) ? $_POST["q12_5"] : "";
		$q12_5_1 = isset($_POST["q12_5_1"]) ? $_POST["q12_5_1"] : "";
		$q13_1 = isset($_POST["q13_1"]) ? $_POST["q13_1"] : "";
		$q13_2 = isset($_POST["q13_2"]) ? $_POST["q13_2"] : "";
		$q13_3 = isset($_POST["q13_3"]) ? $_POST["q13_3"] : "";
		$q13_4 = isset($_POST["q13_4"]) ? $_POST["q13_4"] : "";
		$q13_5 = isset($_POST["q13_5"]) ? $_POST["q13_5"] : "";
		$q13_6 = isset($_POST["q13_6"]) ? $_POST["q13_6"] : "";
		$q13_7 = isset($_POST["q13_7"]) ? $_POST["q13_7"] : "";
		$q13_7_1 = isset($_POST["q13_7_1"]) ? $_POST["q13_7_1"] : "";
		$q14_1 = isset($_POST["q14_1"]) ? $_POST["q14_1"] : "";
		$q14_2 = isset($_POST["q14_2"]) ? $_POST["q14_2"] : "";
		$q14_3 = isset($_POST["q14_3"]) ? $_POST["q14_3"] : "";
		$q14_4 = isset($_POST["q14_4"]) ? $_POST["q14_4"] : "";
		$q14_5 = isset($_POST["q14_5"]) ? $_POST["q14_5"] : "";
		$q14_6 = isset($_POST["q14_6"]) ? $_POST["q14_6"] : "";
		$q14_7 = isset($_POST["q14_7"]) ? $_POST["q14_7"] : "";
		$q14_8 = isset($_POST["q14_8"]) ? $_POST["q14_8"] : "";
		$q15_1 = isset($_POST["q15_1"]) ? $_POST["q15_1"] : "";
		$q15_2 = isset($_POST["q15_2"]) ? $_POST["q15_2"] : "";
		$q15_3 = isset($_POST["q15_3"]) ? $_POST["q15_3"] : "";
		$conex = conex("p400");
		
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "INSERT INTO cuespi20161 values(
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
							'$q5_1', 
							'$q5_2', 
							'$q5_3', 
							'$q5_4', 
							'$q5_5', 
							'$q5_6', 
							'$q5_7', 
							'$q5_8', 
							'$q5_9', 
							'$q5_10', 
							'$q5_11', 
							'$q5_12', 
							'$q5_13', 
							'$q6_1', 
							'$q6_2', 
							'$q6_3', 
							'$q6_4', 
							'$q6_5', 
							'$q7', 
							'$q8', 
							'$q8_1', 
							'$q9_1', 
							'$q9_2', 
							'$q9_3', 
							'$q9_4', 
							'$q9_5', 
							'$q9_6', 
							'$q9_7', 
							'$q9_8', 
							'$q9_9', 
							'$q9_9_1', 
							'$q10_1', 
							'$q10_2', 
							'$q10_2_1', 
							'$q10_3', 
							'$q11', 
							'$q12_1', 
							'$q12_2', 
							'$q12_3', 
							'$q12_4', 
							'$q12_5', 
							'$q12_5_1', 
							'$q13_1', 
							'$q13_2', 
							'$q13_3', 
							'$q13_4', 
							'$q13_5', 
							'$q13_6', 
							'$q13_7', 
							'$q13_7_1', 
							'$q14_1', 
							'$q14_2', 
							'$q14_3', 
							'$q14_4', 
							'$q14_5', 
							'$q14_6', 
							'$q14_7', 
							'$q14_8', 
							'$q15_1', 
							'$q15_2', 
							'$q15_3');";
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