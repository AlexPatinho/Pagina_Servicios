<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
include_once("../miscelaneas.php");
include_once("../conex.php");
noCache();
session_start();
if(isset($_SESSION)
	and isset($_SESSION["cta"])
	and isset($_SESSION["plan"])
	and isset($_POST)
	and isset($_POST["cmp"])){
	//SI LOS DATOS DE LA SESSION ESTAN ACTIVOS Y SE HAN ENVIADO DATOS POR POST
	$cta = $_SESSION["cta"];
	$plan = $_SESSION["plan"];

//------ carga horarios y pagos de extras

	$conex_40 = conex41("inscripciones");
	//----- verificamos el estado maestro del sistema de inscripciones y la vuelta de  extras
	$sql_0 = "SELECT (CASE WHEN vuelta = 'PRIMERA VUELTA' THEN '1' WHEN vuelta = 'SEGUNDA VUELTA' THEN '2' ELSE '0'END)AS vuelta, ce.id
			FROM config c, ciclo_escolar ce WHERE actual ='t'; ";
	$rpta = pg_query($conex_40, $sql_0) or die("La consulta fallo: ". pg_last_error());

	$resp = pg_fetch_array($rpta);

	if ($resp[0] != '0') 
	{
		if ($resp[0] == '1') // Primera vuelta
		{
			$vta = '1';
			$tipo_insc = '3';
			$tipo_pago = '2';
			$k = 3;
		}
		if ($resp[0] == '2')
		{
			$vta = '2';
			$tipo_insc = '4';
			$tipo_pago = '6';
		}

		$dia_insc  = '2020-08-19'; // fecha del primer dia de inscripcion
		$ciclo_esc = $resp[1];
		$sem = substr($ciclo_esc,2,3);
	
		$sql_1 = "INSERT INTO horario_inscripcion( alumno_has_alumno_id, alumno_has_plan_estudios_id, tipo_inscripcion_id, realizado, dia_inscripcion, 
		hora_inicio, hora_final,no_movimientos)
		SELECT'$cta', '$plan', '$tipo_insc', 'f','$dia_insc', '00:01:00', '23:59:00','0'
		WHERE NOT EXISTS( SELECT '1' FROM horario_inscripcion WHERE alumno_has_alumno_id= '$cta' AND alumno_has_plan_estudios_id='$plan' 
		AND tipo_inscripcion_id='$tipo_insc'); ";
		$resp=pg_query($conex_40, $sql_1) or die("La consulta fallo: ". pg_last_error());

		if ($vta == 2) 
			{
				$sql_2 = "SELECT * FROM (SELECT extras_permitidos as permisos from alumno_has_plan_estudios where alumno_id = '$cta' and plan_estudios_id='$plan')as 
				permiso, (SELECT count(*)AS inscritos FROM inscripcion i, grupo g WHERE i.grupo_id =g.id and tipo_vuelta='PRIMERA VUELTA' AND 
				ciclo_escolar_id='$ciclo_esc' and alumno_id='$cta' and plan_estudios_id ='$plan')as inscritos";

  				$rpta = pg_query($conex_40, $sql_2) or die("La consulta fallo: ". pg_last_error());
  				$resp = pg_fetch_array($rpta);

  				$k = 3 + $resp[0] - $resp[1]; 
			}
	
		for ($i = 1; $i <= $k; $i++)
		{
			$sql_3 = "INSERT INTO pago(tipo_pago_id, ciclo_escolar_id, plan_estudios_id, alumno_id, status, folio, importe, create_at)
			SELECT'$tipo_pago', '$ciclo_esc','$plan', '$cta', 'PAGADO', '$sem$vta$i', '0.40', substr(now()::text,1,19)::timestamp
			WHERE NOT EXISTS(SELECT '1' FROM pago WHERE alumno_id='$cta' AND plan_estudios_id='$plan' AND folio='$sem$vta$i'); ";
			$resp=pg_query($conex_40, $sql_3) or die("La consulta fallo: ". pg_last_error());
		}
	}
	
//------ termina la carga de horarios y pagos extras


$conex = conex("p400");
$sentencia = "SELECT b.nombre AS \"NOM\", 
CASE WHEN a.sis = 'SUA' THEN '132.247.154.43'
WHEN a.sis = 'ESC' THEN b.ip END AS \"IP\"
FROM diralum AS a JOIN carrera AS b ON a.carr = b.carr 
WHERE cuenta = '$cta' AND exa IS NULL;";
	//SE OBTIENEN LAS CARRERAS ACTIVAS DEL ALUMNO
$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());

$result = array();
while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
	$result[] = $resp;
}

closeConex($ex, $conex);
echo json_encode($result);
} else {
	unset($_POST);
	session_unset();
	session_destroy();
}
?>