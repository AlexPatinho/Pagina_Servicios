<?php
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	
	//INICIAMOS/VERIFICAMOS UNA SESION
	session_start();
	
	if(isset($_SESSION)
	and isset($_SESSION["usrAdmin"])
	and isset($_POST)
	and isset($_POST["cta"])
	and isset($_POST["apPat"])
	and isset($_POST["apMat"])
	and isset($_POST["nom"])){
	//SI LOS DATOS DE SESION Y LAS VARIABLES DE BUSQUEDA EXISTEN...
		$conex = conex("p400");
		//SI LA CONEXION NO FUE EXITOSA DESTRUIMOS LA CONEXION E INFORMAMOS DEL ERROR...
		if(!$conex and $_POST["consulta"]){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		//EN CASO QUE LA CONEXION HAYA SIDO VALIDA...
		} else {
			$sentencia = "SELECT b.esta AS \"EST\", 
							a.cuenta AS \"CTA\", 
							a.paterno AS \"PAT\", 
							a.materno AS \"MAT\", 
							a.nombres AS \"NOM\", 
							substring(a.fechnac FROM 1 FOR 2) || ' / ' || 
						CASE WHEN substring(a.fechnac FROM 3 FOR 2) = '01' THEN 'ENE'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '02' THEN 'FEB'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '03' THEN 'MAR'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '04' THEN 'ABR'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '05' THEN 'MAY'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '06' THEN 'JUN'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '07' THEN 'JUL'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '08' THEN 'AGS'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '09' THEN 'SEP'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '10' THEN 'OCT'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '11' THEN 'NOV'
							WHEN substring(a.fechnac FROM 3 FOR 2) = '11' THEN 'DIC'
							ELSE substring(a.fechnac FROM 3 FOR 2)
							END || ' / ' || substring(a.fechnac FROM 5 FOR 4) AS \"NAC\",
							c.plan_e || ' :: ' ||c.nombre || ' (' || f.gen || ')' AS \"CRR\", 
						CASE WHEN (fk_id_col IS NULL OR fk_id_col = 0) THEN upper(d.noment) 
							ELSE upper(j.nom_estado) END AS \"EDO\",
						CASE WHEN (fk_id_col IS NULL OR fk_id_col = 0) THEN upper(a.deleomuni) 
							ELSE upper(i.nom_del_mun) END AS \"DEL\",
						CASE WHEN (fk_id_col IS NULL OR fk_id_col = 0) THEN a.codigo 
							ELSE g.codigo::text END AS \"COP\",
						CASE WHEN (fk_id_col IS NULL OR fk_id_col = 0) THEN upper(a.colopobla) 
							ELSE upper(e.nom_col) END AS \"COL\",
						a.calleynum AS \"CYN\",
						CASE WHEN a.telefono IS NULL THEN '------------' ELSE a.telefono END AS \"TCA\",
						CASE WHEN a.telefono2 IS NULL THEN '------------' ELSE a.telefono2 END AS \"TOF\",
						CASE WHEN a.telefono3 IS NULL THEN '------------' ELSE a.telefono3 END AS \"TCE\",
						CASE WHEN a.email IS NULL THEN '------------' ELSE a.email END AS \"EMA\",
						CASE WHEN a.semactdom IS NULL THEN '------------' ELSE a.semactdom END AS \"SEM\", 
						CASE WHEN b.semfin IS NULL THEN '------------' ELSE b.semfin END AS \"USE\"
						FROM domi AS a 
							JOIN consta AS b ON a.cuenta = b.cuenta 
							JOIN semes AS c ON b.plan_e = c.plan_e 
							JOIN entfed AS d ON a.entidad = d.entidad
							JOIN dom_col AS e ON a.fk_id_col = e.id_col
							JOIN diralum AS f on a.cuenta = f.cuenta
							JOIN dom_cod_post AS g ON e.fk_id_cod_post = g.id_cod_post
							JOIN dom_ciu_pob AS h ON g.fk_id_ciu_pob = h.id_ciu_pob
							JOIN dom_del_mun AS i ON h.fk_id_del_mun = i.id_del_mun
							JOIN dom_estado AS j ON i.fk_id_estado = j.id_estado
						WHERE a.cuenta ILIKE '%".$_POST["cta"]."%' 
							AND a.paterno ILIKE '%".$_POST["apPat"]."%' 
							AND a.materno ILIKE '%".$_POST["apMat"]."%' 
							AND a.nombres ILIKE '%".$_POST["nom"]."%' 
							AND c.plan_e = f.plan_e
						ORDER BY \"PAT\", \"MAT\", \"NOM\";";
			$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
			$datos = array();
			while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
				$datos[] = $resp;
			}
			closeConex($ex, $conex);
			
			//SE ENVIAN LOS DATOS AL CLIENTE
			echo json_encode($datos);
		}
	} else {
	//...EN CASO CONTRARIO ELIMINAMOS LOS DATOS Y REDIRIGIMOS A LA PAGINA PRINCIPAL.
		session_unset();
		session_destroy();
		unset($_POST);
		header("Location: ../");
	}
?>