<?php
	include_once("../miscelaneas.php");
	require_once("../conex.php");
	//EVITA EL GUARDADO DE DATOS POR PARTE DEL NAVEGADOR.
	noCache();
	
	//INICIAMOS/VERIFICAMOS UNA SESION
	session_start();
	
	if(isset($_SESSION)
	and isset($_SESSION["usrBib"])
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
							b.semfin AS \"UIN\", 
							a.cuenta AS \"CTA\", 
							a.paterno AS \"PAT\", 
							a.materno AS \"MAT\", 
							a.nombres AS \"NOM\", 
							c.nombre AS \"CRR\", 
							j.exa AS \"EXA\", 
						CASE WHEN (fk_id_col IS NULL OR fk_id_col = 0)THEN 
							upper(a.calleynum)||' '||
							upper(a.colopobla)||' '||
							upper(a.deleomuni)||' '||
							upper(d.noment)
						ELSE 
							upper(a.calleynum)||' '||
							upper('COL. '||e.nom_col)||' '||
							upper('DEL. '||f.nom_del_mun)||' '||
							upper('C.P. '||g.codigo::varchar)||' '||
							upper(i.nom_estado)
						END AS \"DOM\", 
							(b.credb::INT + b.credp::INT) AS \"CRO\", 
							(c.creobl::INT + c.creopt::INT) AS \"CRT\", 
							(((b.credb::FLOAT + b.credp::FLOAT) * 100) / (c.creobl::FLOAT + c.creopt::FLOAT))::NUMERIC(8, 2) AS \"PCT\"
						FROM domi AS a 
							JOIN consta AS b ON a.cuenta = b.cuenta 
							JOIN semes AS c ON b.plan_e = c.plan_e 
							JOIN entfed AS d ON a.entidad = d.entidad
							JOIN dom_col AS e ON a.fk_id_col = e.id_col
							JOIN dom_cod_post AS g ON e.fk_id_cod_post = g.id_cod_post
							JOIN dom_ciu_pob AS h ON g.fk_id_ciu_pob = h.id_ciu_pob
							JOIN dom_del_mun AS f ON h.fk_id_del_mun = f.id_del_mun
							JOIN dom_estado AS i ON f.fk_id_estado = i.id_estado
							JOIN diralum AS j ON j.cuenta = a.cuenta
						WHERE a.cuenta ILIKE '%".$_POST["cta"]."%' 
							AND a.paterno ILIKE '%".$_POST["apPat"]."%' 
							AND a.materno ILIKE '%".$_POST["apMat"]."%' 
							AND a.nombres ILIKE '%".$_POST["nom"]."%' 
							AND j.plan_e = b.plan_e
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