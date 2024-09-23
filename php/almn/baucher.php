<?php
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	include_once("../miscelaneas.php");
	include_once("../conex.php");
	include_once("../mpdf/mpdf.php");
	
	noCache();
	//INICIAMOS/VERIFICAMOS UNA SESION
	ini_set("session.cookie_lifetime", "10800");
	ini_set("session.gc_maxlifetime", "10800");
	session_start();
	/*
	if(isset($_SESSION)
	and isset($_SESSION["usrVent"])
	and isset($_POST)
	and isset($_POST["lis"])
	and $_POST["lis"] == true
	and isset($_POST["cta"])){
	//LISTADO DE CONSTANCIAS PENDIENTES DE ENTREGA
	//----------------------------------------------------
		$cta = $_POST["cta"];
		$conex = conex("p400");
		
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "SELECT cuenta = '$cta' 
							FROM domi 
							WHERE cuenta = '$cta';";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			$resp = pg_fetch_array($ex, NULL, PGSQL_NUM);
			
			if($resp[0] == "t"){
				$sentencia = "SELECT 
								a.cuenta AS \"CTA\", 
								a.paterno || ' ' || a.materno || ', ' || a.nombres AS \"NOM\", 
								c.nombre || '(' || c.plan_e || ')' AS \"CRR\", 
								b.fecha_soli AS \"SOL\", 
								'C' || lpad(b.id_soli::text, 7, '0')  AS \"FOL\" 
							FROM 
								domi a, 
								soli_const b ,
								semes c 
							WHERE 
								a.cuenta = b.cuenta 
								AND b.plan = c.plan_e 
								AND b.elab IS NOT NULL 
								AND b.fecha_elab IS NOT NULL 
								AND b.entre IS NULL 
								AND b.fecha_entre IS NULL 
								AND b.tipo = 'CRD' 
								AND a.cuenta = '$cta'
							ORDER BY
								b.id_soli;";
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				
				$data = array();
				
				while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$data[] = $resp;
				}
				
				closeConex($ex, $conex);
				echo json_encode($data);
				
			} else {
				//SI EL NUMERO DE CUENTA NO EXISTE DESTRUIMOS LAS VARIABLES Y CERRAMOS LA CONEXION
				closeConex($ex, $conex);
				echo json_encode(false);
			}
		}
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
	} elseif(isset($_SESSION)
	and isset($_SESSION["usrVent"])
	and isset($_POST)
	and isset($_POST["ent"])
	and $_POST["ent"] == true
	and isset($_POST["folio"])){
	//SE ACTUALIZAN LOS DATOS DE ENTREGA DE LA CONSTANCIA
		$folio = intval(substr($_POST["folio"], 1));
		$conex = conex("p400");
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "UPDATE soli_const SET entre = '".$_SESSION["usrVent"]."', fecha_entre = now() WHERE id_soli = $folio;";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			if(pg_affected_rows($ex) < 1){
				echo json_encode("B");//NO SE PUDO ACTUALIZAR LA ENTREGA DE CONSTANCIA
			} else {
				echo json_encode("A");//SE ACTUALIZO LA ENTREGA DE CONSTANCIA
			}
		}
		//echo json_encode($sentencia);
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
	} elseif(isset($_SESSION)
	and isset($_SESSION["usrVent"])
	and isset($_POST)
	and isset($_POST["con"])
	and $_POST["con"] == true
	and isset($_POST["turno"])){
	//LISTADO DE CONSTANCIAS PENDIENTES DE ELABORACION
	//----------------------------------------------------
		$conex = conex("p400");
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			if($_POST["turno"] == "M"){
				$turno = "AND d.fecha_soli < to_timestamp('".date("Y-m-d 14:00:00", time())."', 'YYYY-MM-DD HH24:MI:SS')";
			} elseif($_POST["turno"] == "V"){
				$turno = "AND d.fecha_soli >= to_timestamp('".date("Y-m-d 14:00:00", time())."', 'YYYY-MM-DD HH24:MI:SS')";
			}
			$sentencia = "SELECT 
							'C' || lpad(d.id_soli::text, 7, '0') AS \"FOL\", 
							a.cuenta AS \"CTA\", 
							c.nombre || '(' || c.plan_e || ')' AS \"CRR\",
							a.paterno || ' ' || a.materno || ', ' || a.nombres AS \"NOM\", 
							e.credb AS \"OBL\", 
							e.credp AS \"OPT\", 
							(c.creobl::float + c.creopt::float) AS \"TOT\", 
							d.fecha_soli AS \"SOL\"
						FROM 
							domi AS a, 
							diralum AS b, 
							semes AS c, 
							soli_const AS d, 
							consta AS e
						WHERE 
							a.cuenta = b.cuenta 
							AND b.cuenta = e.cuenta
							AND b.plan_e = c.plan_e 
							AND b.plan_e = e.plan_e 
							AND a.cuenta = d.cuenta 
							AND d.tipo = 'CRD'
							AND d.elab IS NULL
							AND d.fecha_elab IS NULL
							AND d.fecha_entre IS NULL
							".$turno."
						ORDER BY d.id_soli;";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			$data = array();
			
			while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
				$data[] = $resp;
			}
		}
		
		closeConex($ex, $conex);
		echo json_encode($data);
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
	} elseif(isset($_SESSION)
	and (isset($_SESSION["usrVent"]) or (isset($_SESSION["usrAdmin"])))
	and isset($_GET)
	and isset($_GET["gen"])
	and $_GET["gen"] == true){
	*/
	if(true){
	//CONSTANCIAS GENERADAS
	//----------------------------------------------------
	/*
		$conex = conex("p400");
		
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {*/
		if  (true){	
		/*
			$aux = "";//CONDICION DE ACTUALIZACION
			$fo = "";//FOLIO(S) DE LA(S) CONSTANCIA(S)
			
			if(isset($_GET["folios"])){
				$aux .= "AND d.entre IS NULL 
						AND d.fecha_entre IS NULL 
						AND d.id_soli IN(";
				$i = 0;
				foreach($_GET["folios"] as $val){
					$fo .=  ($i == 0) ? intval(substr($val, 1)) :  ", ". intval(substr($val, 1));
					$i += 1;
				}
				$aux .= $fo.") ORDER BY c.nombre, a.paterno, a.materno, a.nombres, d.id_soli ";
			} elseif(isset($_GET["fol"])){
				$fo = intval(substr($_GET["fol"], 1));
				$aux .= "AND d.entre IS NULL 
						AND d.fecha_entre IS NULL 
						AND d.id_soli = $fo 
					ORDER BY c.nombre, a.paterno, a.materno, a.nombres, d.id_soli ";
			}
			
			$sentencia = "UPDATE soli_const SET elab = '".$_SESSION["usrVent"]."', fecha_elab = now() WHERE id_soli IN (".$fo.");";
			$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
			
			if( pg_affected_rows($ex) < 1 && !isset($_GET["cta"])){
				echo "ERROR AL GENERAR LAS CONSTANCIAS.";
				exit; 
			} else {*/
			if(true){
				/*
				$sentencia = "SELECT d.id_soli AS \"FOLI\", 
									a.cuenta AS \"CNTA\", 
									a.paterno || ' ' || a.materno || ', ' || a.nombres AS \"NOMB\", 
									c.nombre AS \"CARR\", 
									c.plan_e AS \"PLAN\", 
									d.esta AS \"INSC\", 
									CASE WHEN (d.sem = '01') OR (d.sem = '1') THEN 'PRIMER' 
										WHEN (d.sem = '02') OR (d.sem = '2') THEN 'SEGUNDO' 
										WHEN (d.sem = '03') OR (d.sem = '3') THEN 'TERCER' 
										WHEN (d.sem = '04') OR (d.sem = '4') THEN 'CUARTO' 
										WHEN (d.sem = '05') OR (d.sem = '5') THEN 'QUINTO' 
										WHEN (d.sem = '06') OR (d.sem = '6') THEN 'SEXTO' 
										WHEN (d.sem = '07') OR (d.sem = '7') THEN 'SEPTIMO' 
										WHEN (d.sem = '08') OR (d.sem = '8') THEN 'OCTAVO' 
										WHEN (d.sem = '09') OR (d.sem = '9') THEN 'NOVENO' 
										WHEN (d.sem = '10') OR (d.sem = '10') THEN 'DECIMO' 
									END AS \"PERI\", 
									CASE WHEN d.ter = '1' THEN f.semestre || ' (' || f.fecha || ')'	ELSE NULL END AS \"USEM\", 
									c.semes AS \"TSEM\", 
									d.prom AS \"PROM\", 
									d.mat AS \"MATA\", 
									c.totmat AS \"MATT\", 
									d.cred_ob AS \"OBLO\", 
									round(((d.cred_ob::numeric * 100) / c.creobl::numeric), 2) AS \"OBLP\", 
									c.creobl AS \"OBLT\", 
									d.cred_op AS \"OPTO\", 
									round(((d.cred_op::numeric * 100) / c.creopt::numeric), 2) AS \"OPTP\", 
									c.creopt AS \"OPTT\", 
									(d.cred_ob::numeric + d.cred_op::numeric) AS \"COBT\", 
									round((((d.cred_ob::numeric + d.cred_op::numeric) * 100) / (c.creobl::numeric + c.creopt::numeric)), 2) AS \"COBP\",
									(c.creobl::numeric + c.creopt::numeric) AS \"CRDT\",
									d.ter AS \"FINA\", 
									d.fecha_elab AS \"FEEL\", 
									g.firma AS \"FIRM\"
								FROM 
									domi AS a, 
									diralum AS b, 
									semes AS c, 
									soli_const AS d, 
									consta AS e, 
									termino AS f,
									usuarios AS g
								WHERE 
									a.cuenta = b.cuenta 
									AND b.cuenta = d.cuenta 
									AND a.cuenta = e.cuenta 
									AND b.plan_e = c.plan_e 
									AND b.plan_e = e.plan_e 
									AND (e.semfin = f.semestre 
									AND e.exf = f.periodo) 
									AND d.tipo = 'CRD'
									AND g.login = '".$_SESSION["usrVent"]."'
									".$aux.";";
				
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				//$data = array();
				*/
				ob_start();//SE INICIA EL BUFFER DE SALIDA DE DATOS PARA CAPTURAR EL FORMATO ANTES DE GENERAR EL PDF
			
	?>
<!Doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="content-language" content="es-MX" />
        <meta http-equiv="robots" content="NOINDEX, NOFOLLOW" />
        
        <title>PAGO DE CUOTA ANUAL FES ARAGON</title>
        
        <style type="text/css">
			/*
				grey = <?php $grey = "#CCC";?>
			*/
			@page{margin: 5px;}
			
			body{ font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; 
			/*background-image: url('../../imgs/hoja_sello.png');
			background-image-resize: 1; */
			}
			
			#copia{ height:28%; border: 1px solid; }
			#unam{ border: 1px solid #6F0; width: 8%; height: 6.5%; margin-left: 4%; float: left; }
			#text-unam{ border: 1px solid #00F; width: 70%; height: 6.5%; float: left; font-size: 12px; padding-left: 1%; }
			#fes{ border: 1px solid #C0F; height: 6.5%; float: left; }
			#tram{ border: 1px solid #F90; width: 18%; height: 21%; text-align: center;  float: left; }
			#tram div{ margin-top: 95px; font-size: 16px; font-weight: bold; color: <?=$grey?>; }
			#titulo{ border: 1px solid #39F; width:65%; float: left; }
			#folio{ border: 1px solid #F6C; float: left; }
        </style>
    </head>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************--><!--*****************************************************************************************************-->
	
    <body>
		<div style="width: 100%; height: 100%;">
        <?php
			for($i = 0; $i<3; $i++){
		?>
        	<div id="copia" style=" <?php if($i != 0){ ?>border-top: 2px dashed #888;<?php } ?>">
            	<div id="wrapper">
                	<div id="unam"></div> <div id="text-unam">
                    	Universidad Nacional<br />
                        Autonoma de México<br /><br />
                        Patronato Universitario</div>
                    <div id="fes">
                    FES
                    </div>
                    <div id="tram">
                    	<div>REINSCRIPCIÓN</div>
                    </div>
                    <div id="titulo">Orden de Pago</div>
                    <div id="folio">123abc</div>
                </div>
            </div>
        <?php
			}
		?>
            <div style="height:15%; background-color:#FF0;"></div>
        </div>
    </body>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
</html>
<?php
				//SE VACIA EL CONTENIDO DEL DOCUMENTO EN UNA VARIABLE
				$html = ob_get_clean();
				
				//SE DEFINE UN NUEVO OBJETO DE LA CLASE PDF Y SE CONFIGURA
				$mpdf = new mPDF("c", "letter", "", "", 0, 0, 0, 0, 0, 0);
				
				//SE INDICA QUE EL DOCUMENTO SE DEBE MANDAR IMPRIMIR AUTOMATICAMENTE
				//$mpdf->SetJS("this.print();");
				
				//$mpdf -> SetWatermarkText("NO SE ACEPTE FOTOCOPIA DE ESTE DOCUMENTO");
				//$mpdf -> watermarkTextAlpha = 0.25;
				//$mpdf -> watermark_font = "Arial";
				//$mpdf -> showWatermarkText = true;
				
				//SE ESCRIBE EL CONTENIDO DEL DOCUMENTO
				$mpdf -> WriteHTML($html);			
				
				//SE ENVIA AL NAVEGADOR (COMPORTAMIENTO POR DEFECTO)
				header('Content-type: application/pdf');
				$mpdf->Output("CUOTA_ANUAL_".$cta.".pdf", "I");
			}
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
		}
	} else {
		header("Location: ../../");
	}
?>