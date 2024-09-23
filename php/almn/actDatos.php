<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
include_once("../miscelaneas.php");
require_once("../conex.php");

noCache();
session_start();
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
if(isset($_POST)
//VERIFICAMOS QUE EXISTAN LOS DATOS DEL ALUMNO
	&& isset($_POST["cve"])
	&& isset($_SESSION)
	&& isset($_SESSION["cta"])
	&& ($_POST["cve"] === md5($_SESSION["cta"].$_SESSION["plan"]))){
		
	$_cta = $_SESSION["cta"];
	$conex = conex("p400");
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$datos = array();
		$sentencia = "SELECT a.cuenta AS \"CTA\", 
							a.paterno AS \"PAT\", 
							a.materno AS \"MAT\", 
							a.nombres AS \"NOM\",
							a.fechnac AS \"FCH\",
							CASE WHEN NOT a.contra IS NULL THEN a.contra ELSE '' END AS \"PAS\",
							a.email AS \"EMA\",
							CASE WHEN NOT a.telefono IS NULL THEN a.telefono ELSE '' END AS \"TL1\",
							CASE WHEN NOT a.telefono2 IS NULL THEN a.telefono2 ELSE '' END AS \"TL2\",
							CASE WHEN NOT a.telefono3 IS NULL THEN a.telefono3 ELSE '' END AS \"TL3\"
					FROM domi AS a
					WHERE a.cuenta = substring('$_cta' FROM 1 FOR 9);";
					//DATOS DEL ALUMNO
		
		$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$datos["alm"][] = $resp;
		}
		
		$sentencia = "SELECT a.calleynum  AS \"CYN\", 
							a.fk_id_col as \"COL\", 
							b.nom_estado AS \"EDO\", 
							c.nom_del_mun AS \"DEL\", 
							e.codigo AS \"COD\"
					FROM domi AS a, 
						dom_estado AS b
					JOIN dom_del_mun AS c on b.id_estado = c.fk_id_estado
					JOIN dom_ciu_pob AS d on c.id_del_mun = d.fk_id_del_mun
					JOIN dom_cod_post AS e on d.id_ciu_pob = e.fk_id_ciu_pob
					JOIN dom_col as f on e.id_cod_post = f.fk_id_cod_post
					WHERE f.id_col = (SELECT fk_id_col FROM domi WHERE cuenta = '$_cta')
					AND  a.cuenta = substring('$_cta' FROM 1 FOR 9);";
		//DATOS DEL DOMICILIO DEL ALUMNO
		$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$datos["dom"][] = $resp;
		}
		
		$sentencia =  "SELECT b.id_col AS \"IDC\", 
							b.nom_col AS \"NCL\"
						FROM dom_cod_post AS a 
						JOIN dom_col AS b ON a.id_cod_post = b.fk_id_cod_post
						WHERE a.codigo = (SELECT a.codigo 
										FROM dom_cod_post AS a 
										JOIN dom_col AS b ON a.id_cod_post = b.fk_id_cod_post 
										WHERE b.id_col = (SELECT fk_id_col 
															FROM domi 
															WHERE cuenta = substring('$_cta' FROM 1 FOR 9)))
						ORDER BY b.nom_col;";
		//SE OBTIENE LA LISTA DE COLONIAS QUE PERTENECEN AL CODIGO POSTAL DE LA DIRECCION
		//DEL ALUMNO, EN CASO QUE ESTE YA HAYA ACTUALIZADO DATOS ALGUNA VEZ.
		$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
		while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
			$datos["col"][] = $resp;
		}
		
		//SE CIERRA LA CONEXION Y SE ENVIAN LOS DATOS
		closeConex($ex, $conex);
		echo json_encode($datos);
	}
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
} else if(isset($_POST)//VERIFICAMOS EL CODIGO POSTAL INGRESADO POR EL ALUMNO
		&& isset($_POST["cpp"])
		&& isset($_SESSION)
		&& isset($_SESSION["cta"])){
			
	$_cpp = intval($_POST["cpp"]);
	//VERIFICAMO SQUE EL CODIGO POSTAL SEA UN NUMERO ENTERO VALIDO
	if($_cpp === 0){
		//SI NO LO ES INFOEMAMOS CON UN VALOR NULO
		echo json_encode(false);
	} else {
		//EN CASO CONTRARIO GENERAMOS LA CONSULTA A LA BDD
		$conex = conex("p400");
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			//OBTENEMOS LOS DATOS GENERALES DEL DOMICILIO:
			//ESTADO, DELEGACION O MUNICIPIO, Y CIUDAD
			$sentencia = "SELECT a.nom_estado AS \"EDO\", 
							b.nom_del_mun AS \"DEL\"
							FROM dom_estado AS a 
							JOIN dom_del_mun AS b ON a.id_estado = b.fk_id_estado
							JOIN dom_ciu_pob AS c ON b.id_del_mun = c.fk_id_del_mun
							JOIN dom_cod_post AS d ON c.id_ciu_pob = d.fk_id_ciu_pob
							WHERE d.codigo = $_cpp;";
			
			$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
			
			if (pg_num_rows($ex) < 1){//EL CODIGO POSTAL NO EXISTE
				closeConex($ex, $conex);
				echo json_encode(false);
				
			} else {//EL CODIGO POSTAL ES VALIDO Y EXISTE
				$direccion = array();
				
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$direccion["gen"][] = $resp;//SE LLENA ESTADO Y DELEGACION-MUNICIPIO
				}
				
				//OBTENEMOS LA(S) COLONIA(S) QUE SE IDENTIFICA(N) POR EL CODIGO POSTAL
				$sentencia = "SELECT b.id_col AS \"IDC\", 
							b.nom_col AS \"NCL\"
							FROM dom_cod_post AS a 
							JOIN dom_col AS b ON a.id_cod_post = b.fk_id_cod_post
							WHERE a.codigo = $_cpp
							ORDER BY b.nom_col;";
							
				$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: " . pg_last_error());
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$direccion["col"][] = $resp;//SE LLENA COLONIAS
				}
				closeConex($ex, $conex);//CIERRA LA CONEXION A LA BDD
				echo json_encode($direccion);//ENVIA LOS DATOS AL USUARIO
			
			}
		}
	}
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
} else if(isset($_POST)
		&& isset($_POST["col"]) 
		&& isset($_POST["cyn"])
		&& isset($_POST["email"])
		&& isset($_POST["tel"])
		&& isset($_SESSION)
		&& isset($_SESSION["cta"])){

	$_cta = $_SESSION["cta"];
	$_pas = isset($_POST["pass"]) ? $_POST["pass"] : "NULL";//CONTRASEÑA DEL ALUMNO
	$_col = $_POST["col"]; //ID DE LA COLONIA
	$_cyn = substr(strtoupper($_POST["cyn"]), 0, 80); //CALLE Y NUMERO, 80 CARACTERES MAXIMO
	$_ema = substr($_POST["email"], 0, 45); //CORREO ELECTRONICO 45 CARACTERES MAXIMO
	$_tel = substr($_POST["tel"], 0, 8); //TELEFONO DE CASA/RECADOS
	$_ofi = isset($_POST["ofi"]) ? substr($_POST["ofi"], 0, 13) : "NULL"; //TELEFONO DE OFICINA/CONTACTO
	$_cel = isset($_POST["cel"]) ? substr($_POST["cel"], 0, 13) : "NULL"; //TELEFONO CELULAR
	
	$conex = conex("p400");
	if(!$conex){
		echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
		exit;
	} else {
		$sentencia = "UPDATE domi ".
					"SET fk_id_col = $_col, ".
					"calleynum = '$_cyn', ".
					"email = '$_ema', ".
					"semactdom = '20232', ".
					"telefono = '$_tel', ". 
					"telefono2 = CASE WHEN '$_ofi' = 'NULL' THEN NULL ELSE '$_ofi' END, ".
					"telefono3 = CASE WHEN '$_cel' = 'NULL' THEN NULL ELSE '$_cel' END, ".
					"contra = CASE WHEN '$_pas' = 'NULL' THEN contra	ELSE '$_pas' END, ".
					"nip = CASE WHEN '$_pas' = 'NULL' THEN nip	ELSE '$_pas' END, ".
					"nip5 = CASE WHEN '$_pas' = 'NULL' THEN nip5	ELSE md5('$_pas') END ".
					"WHERE cuenta = '$_cta';";
					
		$ex = pg_query($conex, $sentencia) or die("LA CONSULTA FALLO: ".pg_last_error());
		if(pg_affected_rows($ex) == 0){
			closeConex($ex, $conex);
			unset($_POST);
			echo json_encode("0");//NO SE AFECTARON COLUMNAS - No. DE CUENTA INCORRECTO.
		} else if(pg_affected_rows($ex) == 1){
			if(isset($_POST["pass"])){@updateContra($_pas, $_cta);
				if(isset($_SESSION["passw"])){$_SESSION["passw"] = $_pas;}
			}
			unset($_POST);
			closeConex($ex, $conex);
			echo json_encode("1");//SE REALIZO EL CAMBIO.
		} else if(pg_affected_rows($ex) > 1){
			unset($_POST);
			closeConex($ex, $conex);
			echo "NULL";//SE AFECTO MAS DE UNA COLUMNA.
		}
	}
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------*/
} else {
	unset($_POST);
	session_unset();
	session_destroy();
	header("Location: ../../");
}
?>