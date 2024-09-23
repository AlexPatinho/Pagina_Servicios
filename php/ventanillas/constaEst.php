<?php
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	//DESCOMENTAR LAS LINEAS DE ARRIBA PARA MOSTRAR LOS ERRORES DE PHP
	
	include_once("../miscelaneas.php");
	include_once("../conex.php");
	include("../mpdf/mpdf.php");
	
	//INDICAMOS QUE NO SE GUARDE INFORMACION DEL DOCUMENTO EN EL NAVEGADOR
	noCache();
	//INICIAMOS/VERIFICAMOS UNA SESION
	ini_set("session.cookie_lifetime", "10800");
	ini_set("session.gc_maxlifetime", "10800");
	session_start();
	
	//COMPROBAMOS QUE EXISTAN LOS DATOS GENERADOS POR UN ACCESO VALIDO...
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
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
								'E' || lpad(b.id_soli::text, 7, '0')  AS \"FOL\" 
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
								AND b.tipo = 'EST' 
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
	} elseif(isset($_SESSION) && 
	isset($_SESSION["usrVent"]) &&
	isset($_POST) && 
	isset($_POST["con"]) && 
	$_POST["con"] == true &&
	isset($_POST["turno"]) ){
	//LSITADO DE CONSTANCIAS PENDIENTES DE ELABORACION
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
							'E' || lpad(d.id_soli::text, 7, '0') AS \"FOL\", 
							a.cuenta AS \"CTA\", 
							c.nombre || '(' || c.plan_e || ')' AS \"CRR\",
							a.paterno || ' ' || a.materno || ', ' || a.nombres AS \"NOM\", 
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
							AND d.tipo = 'EST'
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
		
		closeConex($ex, $conex);//SE CIERRA LA CONEXION A LA BDD
		echo json_encode($data);//SE ENVIAN LOS DATOS EXTRAIDOS DE LA BDD	
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
	} elseif(isset($_SESSION)
	and (isset($_SESSION["usrVent"]) or (isset($_SESSION["usrAdmin"])))
	and isset($_GET)
	and isset($_GET["gen"])
	and $_GET["gen"] == true){
	//CONSTANCIAS GENERADAS
	//----------------------------------------------------
		
		$conex = conex("p400");
		
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			
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
			} else {
				
				$sentencia = "SELECT d.id_soli AS \"FOLI\", 
									a.paterno || ' ' || a.materno || ', ' || a.nombres AS \"NOMB\", 
									a.cuenta AS \"CNTA\", 
									c.nombre AS \"CARR\", 
									c.plan_e AS \"PLAN\", 
									CASE WHEN e.turno = 'M' THEN 'MATUTINO'
										WHEN e.turno = 'V' THEN 'VESPERTINO'
										WHEN e.turno = 'X' THEN 'MIXTO'
										END AS \"TURN\", 
									h.cve_sem AS \"LECT\", 
									h.fecha_ini AS \"SINI\", 
									h.fecha_fin AS \"SFIN\", 
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
									d.mat AS \"MATI\", 
									d.fecha_elab AS \"FEEL\", 
									g.firma AS \"FIRM\" 
								FROM domi AS a, 
									diralum AS b, 
									semes AS c, 
									soli_const AS d, 
									consta AS e, 
									termino AS f, 
									usuarios AS g,  
									semestre AS h
								WHERE a.cuenta = b.cuenta 
									AND b.cuenta = d.cuenta 
									AND a.cuenta = e.cuenta 
									AND b.plan_e = c.plan_e 
									AND b.plan_e = e.plan_e 
									AND (e.semfin = f.semestre 
									AND e.exf = f.periodo) 
									AND d.tipo = 'EST' 
									AND h.activo 
									AND g.login = '".$_SESSION["usrVent"]."'
									".$aux.";";
				$ex = pg_query($conex, $sentencia) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
				//$data = array();
			
				/**************************************************************************************************
				/**************************************************************************************************/
				ob_start();
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
?>
<!Doctype html>
<html>
    <head>
        <!--INDICA INFORACION DEL DOCUMENTO-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="content-language" content="es-MX" />
        <meta http-equiv="robots" content="NOINDEX, NOFOLLOW" />
        
        <title>CONSTANCIA DE ESTUDIOS</title>
        
        <style type="text/css">
            @page{ margin: 60px 65px 0px 65px; }
            
            body{ font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; 
            /*
            background-image: url('../../imgs/hoja_sello.png');
            background-image-resize: 1; */}
            
            thead tr th{ background-color: #A5A5A5; color: #fff; }
            
            span.underline{ text-decoration: underline; }
            
            .aux1{ text-align: left; }
            
            #folio{ font-size: 8px; text-align: right; width: 685px; }
            
            #escudo-unam{ width:20%; height: 135px; padding-left: 5px; float: left; }
            
            #titulos{ width: 59%; text-align: center; font-size: 13px; font-weight: bold; float: left; }
            
            #titulo-unam{ width: 370px; margin: 0 0 5px 0; }
            
            #escudo-fes{ width: 20%; float: left; text-align: right; }
            
            #titulo-comprobante{ text-align: center; font-size: 22px; font-weight: bold; }
            
            #contenido{ clear: both; margin-top: 10px; font-size: 12px;}
            
            #contenido p{ text-align: justify; }
            
            #contenido div table{padding: 0; background-color: #ccc; text-align: center; font-weight: bold;  width: 100%; }
            
            #contenido div th, #contenido div td{ padding: 3px; margin: 0; }
            
            #contenido div thead tr th{ font-size: 12px; }
            
            #contenido div tbody tr td{ font-size: 10px; }
            
            #contenido div tr:nth-child(odd){ background-color: #fff; }
            
            #contenido div tr:nth-child(even){ background-color: #E8E8E8; }
            
            #datos-alumno{ width: 100%; text-align: center; border-collapse: collapse; }
            
            #datos-alumno td{ border: 1px solid #888; padding-top: 3px;  font-size: 12px; font-weight: bold; }
            
            #datos-alumno th{ font-size: 10px; font-weight: normal; }
            
            #rubrica { text-align: left; font-weight: bold; padding-top: 10px; }
            
            #firma{ width: 50%; float: left;  padding-top: 80px; }
            
            #firma div{ width: 280px; font-weight: bold; text-align: center; border-top: 2px solid; padding-top: 5px; }
            
            #firma div span{ font-weight: normal; font-size: 12px; }
            
            #elabora{ width: 100%; padding-top: px; float: left; font-size: 9px;  }
            
            #codbar{ position: absolute; top: 970px; left: 480px; text-align: right; width: 280px; }
            
            #watermark{ width: 710px; height: 950px; background-image: url('../../imgs/marca_negro.png'); background-image-opacity: 0.15; background-size: 159px auto; position: absolute; top: 50px; left: 50px; }
        </style>
    </head>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
    <body>
    <?php
				$pb = false; //BANDERA QUE INDICA UN SALTO DE PAGINA
		        while($resp = pg_fetch_array($ex, NULL, PGSQL_ASSOC)){
					$meses = array("Enero", "Febrero", "Marzo", "Abril", 
									"Mayo", "Junio", "Julio", "Agosto", 
									"Septiembre", "Octubre", "Noviembre", "Diciembre");
									
				//******************************************************************************************************
					$folio = (isset($_GET["folio"])) ? str_pad($_GET["folio"], 7, '0', STR_PAD_LEFT) : str_pad($resp["FOLI"], 7, '0', STR_PAD_LEFT);//FOLIO DE LA CONSTANCIA
					$nombre = $resp["NOMB"];//NOMBRE COMPLETO DEL ALUMNO
					$cta = $resp["CNTA"];//NUMERO DE CUENTA DEL ALUMNO
					$carr = $resp["CARR"];//NOMBRE DE LA CARRERA DEL ALUMNO
					$plan = $resp["PLAN"];//PLAN DE ESTUDIOS DEL ALUMNO
					
					$sem = substr($resp["LECT"], 0, 4)."-".((substr($resp["LECT"], 4, 1) == "1") ? "I" : "II");//SEMESTRE LECTIVO
					$fini =  date("d", strtotime($resp["SINI"]))." de ".$meses[date("m", strtotime($resp["SINI"])) - 1].((date("Y", strtotime($resp["SINI"])) == date("Y", strtotime($resp["SFIN"]))) ? "" : " de ".date("Y", strtotime($resp["SINI"])));//FECHA DE INICIO DEL SEMESTRE;
					$ffin = date("d", strtotime($resp["SFIN"]))." de ".$meses[date("m", strtotime($resp["SFIN"])) - 1]." de ".date("Y", strtotime($resp["SFIN"]));//FECHA DE FIN DEL SEMESTRE
					$semins = $resp["PERI"];//SEMESTRE AL QUE SE ENCUENTRA INSCRITO
					$mat = $resp["MATI"];//NUMERO DE MATERIAS INSCRITAS
					
					$inter = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";//FECHAS DEL PERIODO INTERSEMESTRAL
					$vac = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";//FECHAS DEL PERIODO VACACIONAL
					
					$felab = (isset($_GET["fecha"])) ? strtotime($_GET["fecha"]) : strtotime(substr($resp["FEEL"], 0, 19));//FECHA DE ELABORACION
					if($_GET["firma"]){ $exp = explode($_GET["firma"], "#"); }		
					$nomFirma = (isset($_GET["firma"])) ? $exp[2] : "Lic. Maria Teresa Luna Sánchez";
					$cargo = (isset($_GET["firma"])) ? $exp[1] : "Jefe del Departamento";
					$elab = (isset($_GET["firma"])) ? $exp[0]."/".$resp["FIRM"] : "MTLS/".$resp["FIRM"];
				//******************************************************************************************************
    ?>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
    	<?php if($pb){ ?> <pagebreak /> <?php } else { $pb = !$pb; } ?>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
    	<div id="folio">FOLIO: E<?php echo $folio; ?></div>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
        <div id="escudo-unam">
            &nbsp;
            <!--<img style="width: 100%;" src="../../imgs/unam_azul.png" />-->
        </div>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
        <div id="titulos">
            <!--
            <span style="font-size: 16px;">UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO</span>
            -->
            <img id="titulo-unam" src="../../imgs/titulo-unam-negro.png" /><br />
            FACULTAD DE ESTUDIOS SUPERIORES ARAG&Oacute;N<br />
            SECRETAR&Iacute;A ACAD&Eacute;MICA<br />
            DEPARTAMENTO DE SERVICIOS ESCOLARES
        </div>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
        <div id="escudo-fes">
            <img style="width: 90%;"  src="../../imgs/escudo_fes_negro.jpg" />
        </div>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
        <div id="titulo-comprobante">
            <span>
                Constancia de Estudios
            </span>
        </div>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
        <div id="contenido">
            <p>A QUIEN CORRESPONDA:</p>
<!--*****************************************************************************************************-->
            <table id="datos-alumno">
                <tbody>
                    <tr>
                        <td>Nombre: </td>
                        <td class="bold"><?php echo $nombre; ?></td>
                        <td>N&uacute;mero de cuenta: </td>
                        <td class="bold"><?php echo substr($cta, 0, 8)."-".substr($cta, 8, 9); ?></td>
                    </tr>
                    <tr>
                        <td>Carrera: </td>
                        <td class="bold"><?php echo $carr."(".$plan.")"; ?></td>
                        <td>Turno: </td>
                        <td class="bold">Matutino</td>
                    </tr>
                </tbody>
            </table>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
            <p>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Por medio de la presente se hace constar que el alumno citado est&aacute; inscrito 
                en el semestre escolar <b><?php echo $sem; ?></b> mismo que inicia el d&iacute;a <b><?php echo $fini ?></b> 
                y concluye el d&iacute;a <b><?php echo $ffin ?></b>. 
                Cursando un m&aacute;ximo de materias de <b><?php echo $semins; ?></b> semestre, 
                como lo muestra la tira de materias:
            
            </p>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
            <div style="padding: 0 50px;">
                <table>
                    <thead>
                        <tr>
                            <th colspan="5">
                                <i>N&uacute;mero de materias inscritas: <?php echo $mat; ?></i>
                            </th>
                        </tr>
                        <tr>
                            <th>CLAVE</th>
                            <th>NOMBRE DE LA ASIGNATURA</th>
                            <th>CREDITOS</th>
                            <th>SEMESTRE</th>
                            <th>GRUPO</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
						$s1 = "SELECT 
							b.cvemat AS \"CVE\", 
							b.nombre AS \"NOM\", 
							b.creditos AS \"CRD\", 
							CASE WHEN b.ciclo = '40' THEN 'OPT'
								ELSE b.ciclo END AS \"SEM\", 
							a.grupo AS \"GPO\"
						FROM 
							tiras AS a, 
							asg AS b
						WHERE 
						  a.plan_e = b.plan_e AND
						  a.asig = b.cvemat AND
						  a.cuenta = '$cta' AND 
						  a.plan_e = '$plan'
						ORDER BY
						  b.nombre ASC;";
						  //echo $s1; exit;
						$e = pg_query($conex, $s1) or die(json_encode("LA CONSULTA FALLO: " . pg_last_error()));
						
                        for($i = 0; $i < 14; $i++){
							$rs = pg_fetch_array($e, NULL, PGSQL_ASSOC);
                    ?>
                        <tr>
                            <td><?php echo (isset($rs["CVE"])) ? $rs["CVE"] : "******"; ?></td>
                            <td class="aux1"><?php echo (isset($rs["NOM"])) ? $rs["NOM"] : "***************************************************************************"; ?></td>
                            <td><?php echo (isset($rs["CRD"])) ? $rs["CRD"] : "****"; ?></td>
                            <td><?php echo (isset($rs["SEM"])) ? $rs["SEM"] : "******"; ?></td>
                            <td><?php echo (isset($rs["GPO"])) ? $rs["GPO"] : "******"; ?></td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
<!--*****************************************************************************************************-->
            <p>
				<ul>
					<li>
						Periodo intersemestral <?php echo $inter; ?> 
					</li>
					<li>
						Periodo vacacional <?php echo $vac; ?>
					</li>
				</ul>
			</p>
		</div>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
		<div id="rubrica">
			ATENTAMENTE<br />
			"POR MI RAZA HABLAR&Aacute; EL ESP&Iacute;RITU"<br />
				Nezahualc&oacute;yotl, Estado de M&eacute;xico a 
				<?php echo date("d", $felab)." de ".$meses[date("m", $felab) - 1]." de ".date("Y", $felab); ?>
		</div>
<!--*****************************************************************************************************-->
		<div id="firma">
			<div>
				<?php echo $nomFirma; ?>
				<br />
				<span><?php echo $cargo; ?></span>
			</div>
		</div>
<!--*****************************************************************************************************-->
		<div id="elabora">
			<?php echo $elab; ?>
		</div>
<!--*****************************************************************************************************-->
		<div id="codbar">
			<barcode code="<?php echo $folio; ?>" type="C39" height="0.7" />
		</div>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
		<div id="watermark">
			<!--ESTA AREA DE RELLENA AUTOMATICAMENTE CON LA MARCA DE AGUA DE SEGURIDAD-->
		</div>
	<?php
				}
	?>
	</body>
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
<!--*****************************************************************************************************-->
</html>
	
	<?php
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
				//SE VACIA EL CONTENIDO DEL DOCUMENTO EN UNA VARIABLE
				$html = ob_get_clean();
				
				//SE DEFINE UN NUEVO OBJETO DE LA CLASE PDF Y SE CONFIGURA
				$mpdf = new mPDF("c", "letter", "", "", 0, 0, 0, 0, 0, 0);
				
				//SE INDICA QUE EL DOCUMENTO SE DEBE MANDAR IMPRIMIR AUTOMATICAMENTE
				//$mpdf->SetJS("this.print();");
				
				//$mpdf -> SetWatermarkText("NO SE ACEPTE FOTOCOPIA DE ESTE DOCUMENTO");
				$mpdf -> watermarkTextAlpha = 0.25;
				$mpdf -> watermark_font = "Arial";
				$mpdf -> showWatermarkText = true;
				
				//SE ESCRIBE EL CONTENIDO DEL DOCUMENTO
				$mpdf -> WriteHTML($html);			
				
				//SE ENVIA AL NAVEGADOR (COMPORTAMIENTO POR DEFECTO)
				header('Content-type: application/pdf');
				$mpdf->Output("CONSTA_ESTU_".date("Y-m-d_H-s-i", time()).".PDF", "I");
			}	
		}
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
//*****************************************************************************************************************************************
	} elseif(isset($_SESSION)
	and isset($_SESSION["usrVent"])
	and isset($_POST)
	and isset($_POST["bus"])
	and $_POST["bus"] == true
	and isset($_POST["cta"])){
	//LISTADO DE COSNTANCIAS QUE PUEDEN SER REPUESTAS
	
		$conex = conex("p400");
		$cta = $_POST["cta"];
		if(!$conex){
			echo json_encode("ERROR DE CONEXI&Oacute;N: ".pg_last_error());
			exit;
		} else {
			$sentencia = "SELECT 
				a.cuenta AS \"CTA\", 
				a.paterno || ' ' || a.materno || ' ' || a.nombres AS \"NOM\", 
				c.nombre || '(' || c.plan_e || ')'  AS \"CRR\", 
				'E' || lpad(b.id_soli::text, 7, '0')   AS \"FOL\", 
				b.fecha_soli AS \"FSO\", 
				CASE WHEN b.elab IS NULL THEN '**********' ELSE b.elab END AS \"ELA\", 
				CASE WHEN b.fecha_elab IS NULL THEN 'PENDIENTE' ELSE b.fecha_elab::text END AS \"FEL\" 
			FROM 
				domi a, 
				soli_const b, 
				semes c
			WHERE 
				a.cuenta = b.cuenta
				AND a.cuenta = b.cuenta 
				AND b.plan = c.plan_e 
				AND b.plan = c.plan_e 
				AND b.entre IS NULL 
				AND b.fecha_entre IS NULL 
				AND a.cuenta = '$cta' 
				AND b.tipo = 'EST'
			ORDER BY
				b.id_soli;";
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
	} else {
		header("Location: ../../");
	}
?>