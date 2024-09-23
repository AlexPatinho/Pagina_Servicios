<?php
if(!  (time() >= strtotime("2022-01-20 11:00:00")
	&& time() <= strtotime("2022-02-03 23:59:00")))
{
	header("Location: ../../");
}

//ini_set('display_errors', 1);
//error_reporting(E_ALL);
include_once("../miscelaneas.php");
require_once("../conex.php");

noCache();
session_start();
/*-----------------------------------------------------------------------------*/
$sem_act ='20222';

if(isset($_SESSION)
	&& isset($_SESSION["cta"]) 
	&& isset($_SESSION["plan"]) 
	&& isset($_POST)
	&& isset($_POST["cta"]) 
	&& isset($_POST["ver"]) 
	&& $_POST["ver"] == true
	&& $_SESSION["cta"] === $_POST["cta"])
{
	consolo.log("linea 27");
//SE VERIFICAN LOS DATOS DEL ALUMNO Y SI YA GENERO SU INSCRIPCION
	$conex = conex("p400");
	if(!$conex)
	{
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} 
	else 
	{
		$sentencia = " SELECT 
		a.cuenta     AS \"CTA\", 
		a.paterno    AS \"PAT\", 
		a.materno    AS \"MAT\", 
		a.nombre     AS \"NOM\", 
		a.sistema    AS \"SIST\", 
		a.carrera    AS \"CRR\",
		s.NOMBRE     AS \"NOM_CARR\", 
		a.plan_est   AS \"PLAN\", 
		a.grupo_fin  AS \"GPO\",
		a.fecha_insc AS \"F_INS\",
		a.ins        AS \"INS\"
		FROM 
		public.pi$sem_act a,
		semes s
		WHERE 
		a.plan_est=s.plan_e
		and a.cuenta = '".$_SESSION["cta"]."' 
		AND a.plan_est = '".$_SESSION["plan"]."'
		";	
		
		$ex = pg_query($sentencia) or die(json_encode("LA CONSULTA FALLO: ".pg_last_error()));
		$data = array();

		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC))
		{ 
			$data["ALM"][] = $resp; 
		}

		$sentencia="SELECT h.cvemat as cve, 
		m.nombre as materia,lunes,martes,miercoles,jueves,viernes,sabado,salon
		FROM 
		public.asg m, 
		public.horarios h,
		public.pi$sem_act p
		WHERE 
		h.cvemat = m.cvemat
		and p.plan_est=m.plan_e
		and p.carrera=h.carrera
		and p.grupo_fin=h.grupo
		and cuenta = '".$_SESSION["cta"] ."'
		and (cuenta,plan_e, m.cvemat) in 
		(select cuenta, plan_e,m.cvemat from tirasp 
		where cuenta ='".$_SESSION["cta"]."') 
		order by m.cvemat; ";

		$ex = pg_query($sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));

		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC))
		{ 
			$data["INSC"][] = $resp; 
		}
		if(!empty($data["INSC"]))
		{
			//$data["SOL"][0]["ARC"] = glob("../../almn/ctf/".$data["ALM"][0]["CTA"]."_".$_SESSION["plan"]."_".$sem_act.".*");
		} 
		else 
		{
			/*
			$sentencia = "SELECT count(*) 
			FROM pi$sem_act 
			WHERE ins IS NOT NULL;";
			$ex = pg_query($sentencia) or die(json_encode("FALLO CONSULTA LINEA 98 : " . pg_last_error()));
			$resp = pg_fetch_row($ex, 0, PGSQL_NUM);
			json_encode($sentencia);
			if($resp[0] > 0)
			{
				$data["INSC"][0]["ARC"] = "OUTDATE";
			}
			*/
		}
		@closeConex($ex, $conex);
		echo json_encode($data);
	}
	/*-----------------------------------------------------------------------------*/
}
elseif(isset($_SESSION)
	&& isset($_SESSION["cta"]) 
	&& isset($_SESSION["plan"]) 
	&& isset($_POST)
	&& isset($_POST["agree"])
	&& isset($_POST["cta"])
	&& isset($_FILES)
	&& $_POST["agree"] == "on"
	&& isset($_FILES["jus"])) //SE REGISTRA LA INSCRIPCION
{
	$conex = conex("p400");
	consolo.log("linea 123");
	
	if(!$conex)
	{
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} 
	else 
	{	
		$sentencia = "INSERT INTO tirasp SELECT 
		cuenta,plan_est, cvemat, grupo_fin, plantel, carrera
		FROM 
		asg m, 
		pi$sem_act pi
		where pi.plan_est=m.plan_e
		and ciclo='01'
		and cuenta='".$_SESSION["cta"]."'
		and plan_est='".$_SESSION["plan"]."'; ";

		$firma = crc32( $_SESSION["cta"] + $_SESSION["plan"] );

		$sql_insc="UPDATE pi$sem_act 
		SET ins = '1', fecha_insc = now(), 
		atendioi = 'web', fol = '$firma' 
		WHERE cuenta ='".$_SESSION["cta"]."' 
		and plan_est = '".$_SESSION["plan"]."'; 
		";

		$onom = $_FILES['jus']['tmp_name'];
		$dnom = $_SERVER['DOCUMENT_ROOT']."/primer_ingreso/docs/20222/".$_POST["cta"]."_".$_SESSION["plan"]."_".$sem_act.".".pathinfo($_FILES['jus']['name'], PATHINFO_EXTENSION);
		if(move_uploaded_file ($onom, $dnom))
		{
			chmod($dnom, 0755);
			$ex = pg_query($sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			if(pg_affected_rows($ex) > 0)
			{
				$ex_insc = pg_query($sql_insc) or die(json_encode("Eror al actualizar PI: ".pg_last_error()));

				$sentencia = "SELECT h.cvemat as cve, m.nombre as materia,  lunes,martes,miercoles,jueves,viernes,sabado,salon
				FROM 
				public.asg m, 
				public.horarios h,
				public.pi$sem_act p
				WHERE 
				h.cvemat = m.cvemat
				and p.plan_est=m.plan_e
				and p.carrera=h.carrera
				and p.grupo_fin=h.grupo
				and cuenta ='".$_SESSION["cta"]."'
				order by m.cvemat; "; 

				$ex = pg_query($sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				$data = array();
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC))
				{ 
					$data[] = $resp; 
				}
				if(!empty($data))
				{
					$data[0]["ARC"] = glob("../../primer_ingreso/docs/202222/".$_POST["cta"]."_".$_SESSION["plan"]."_".$sem_act.".*");
				}
				
				//SE CIERRAN LAS CONEXIONES Y SE ENVIAN LOS RESULTADOS
				@closeConex($ex, $conex);
				//unset($_POST);
				echo json_encode($data);
			}
		}
	}
	/*-----------------------------------------------------------------------------*/
} 
else 
{
	unset($_POST);
	session_unset();
	session_destroy();
	header("Location: ../../");
}
?>