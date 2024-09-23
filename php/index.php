<?php header("Location: http://aragon.dgae.unam.mx/"); ?>

<?php
//ini_set('display_errors', 1);

//header("Location:http://132.248.44.207/almn");

//error_reporting(E_ALL);
include_once("../php/noCache.php");
include_once("../php/fecha.php");
noCache();
//$sec = $_SERVER["REMOTE_ADDR"].",".substr($_SERVER["HTTP_REFERER"], 0, 22);
session_start();
if(isset($_SESSION) && isset($_SESSION["cta"]) && isset($_SESSION["plan"]) && isset($_SESSION["nomComp"]) && isset($_SESSION["usr"]) && isset($_SESSION["passw"])){
	session_unset();
	session_destroy();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantilla-externa.dwt" codeOutsideHTMLIsLocked="false" -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Pragma" content="no-cache">
        <!-- InstanceBeginEditable name="KeyWords" -->
        <meta name="Keywords" content="UNAM, fes, aragon, comprobante, inscripcion, tramites, escolares, alumnos" />
        <!-- InstanceEndEditable -->
        <meta name="robots" content="INDEX,NOFOLLOW,NOARCHIVE" /> 
        <meta name="description" content="Departamento de Servicios Escolares Aragon" />
        <meta name="country" content="Mexico" />
        
        <link rel="shortcut icon" href="http://recursosweb.unam.mx/imagenes/favicon.ico" />
        <!-- InstanceBeginEditable name="doctitle" -->
		<title>Departamento de Servicios Escolares Arag&oacute;n</title>
		<!-- InstanceEndEditable -->
        
        <link type="text/css" rel="stylesheet" href="../css/estilos-internas.css" title="normal"/>
        <link type="text/css" rel="stylesheet" href="../css/nav-v.css" />
        <link type="text/css" rel="stylesheet" href="../css/estilos-generales.css" />
        <link type="text/css" rel="stylesheet" href="../css/custom-theme/jquery-ui-1.10.3.custom.min.css"  />
        <!-- InstanceBeginEditable name="Styles" -->
		<!-- InstanceEndEditable -->
        
        <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.1.custom.js"></script>
        <script type="text/javascript" src="../js/nav-v.js"></script>
        <!-- InstanceBeginEditable name="Scripts" -->
		<script type="text/javascript" src="../js/login.js"></script>
        <script type="text/javascript">
			$(function(){
					
				/**************************************************************************/
				if($.browser.device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()))){ $('.menu-interna').hide(); $('.info-estudiantes').html('<div class="info"><span style="font-size: 20px; font-weight: 900;">ESTA P&Aacute;GINA NO ESTA DISPONIBLE PARA DISPOSITIVOS MOVILES.</span></div>')
}
				/**************************************************************************/
				/**************************************************************************/
				
			})
        </script>
		<!-- InstanceEndEditable -->
        
        <!--[if IE]>
            <script type="text/javascript" src="../js/tablasIE.js"></script>
		<![endif]-->
        
        <!-- InstanceBeginEditable name="head" -->
	<!-- InstanceEndEditable -->
    </head>
    <body>
    <!-- inicia contenedor que centra la página -->
        <div class="contenedor">
            <!-- inicia encabezado -->
            <div class="encabezado">
            	<img src="../imgs/encabezado.png" style="width:100%;" alt="FES-ARAGON" title="DEPARTAMENTO DE SERVICIOS ESCOLARES" />
            	<!--
            	<a href="http://www.unam.mx"><img src="../imgs/encabezado-unam.gif" border="0" alt="UNAM"/></a>
                <img src="../imgs/stock/rotate.php" width="560" height="103" alt="CAMPUS"/>
                -->
            </div>
            <!-- termina encabezado -->
            <!-- inicia navegacion -->
            <div class="navegacion">
                <!--inicia navegacion-inicio-->
                <div class="navegacion-inicio">
                <a href="../index.php"./">
                	<img src="../imgs/house.gif" alt="Ir a página principal" title="Ir a página principal" width="16" height="16" border="0"/>
                </a>
                </div>
                <!--termina navegacion-inicio-->
                <!--inicia navegacion-fecha-->
                <div class="navegacion-fecha">
                	<b><?php echo getFecha(); ?></b>
                </div>
                <!--termina navegacion-fecha-->
                
                 <!--inicia navegacion-mapa-->
                 <!--
                <div class="navegacion-mapa">
                    <img src="../imgs/sitemap_color.gif" alt="Sitemap" width="16" height="16" align="left" />
                    <a href="../mapa-sitio.html"> Mapa de sitio</a>
                    <img src="../imgs/help.gif" alt="Ayuda" width="16" height="16" />
                    <a href="#">Preguntas frecuentes </a>
                    <img src="../imgs/email.gif" alt="Contáctanos por e-mail" width="16" height="13" />
                    <a href="#"> Contacto</a>
                </div>
                -->
                <!--termina navegacion-mapa-->
                <!--inicia navegacion-banderas-->
                <div class="navegacion-banderas">
                </div>
                <!--termina navegacion-banderas-->
                <!--inicia navegacion-buscador-->
                <!--
                <div class="navegacion-buscador">
                <input type="text"  class="campo" />
                <input name="submit" src="../imgs/buscar-2.gif" alt="Buscar" align="middle" type="image" />
                </div>
                -->
                <!--termina navegacion-buscador-->
            </div>  
            <!-- termina navegacion -->
            <!-- inicia contenido -->
            <div class="contenido">
            	<!-- inicia títulos imágenes  -->
                <div class="topinterna" style=" display: none;" >
                    <img src="../imgs/titulo-generico.jpg" alt="DGAE-ARAGON" width="980" height="61" border="0" usemap="#Map2" />
                    <map name="Map2" id="Map2">
                        <area shape="rect" coords="61,18,553,47" href="./" alt="DGAE-ARAGON"/>
                    </map>
                </div>
            	<!-- termina títulos imágenes  -->
            	<!--inicia menu-interna-->
            	<div class="menu-interna"> 
                    <ul id="navmenu-v">
                        <li><h2><a href="http://aragon.dgae.unam.mx/"><b>INICIO</b></a></h2></li>
                        <!--
                        <li><h2><a href="http://aragon.dgae.unam.mx/vent/">Ventanillas</a></h2></li>
                        <li><h2><a href="#">Egresados</a></h2></li>
                        <li><h2><a href="#">Actas</a></h2></li>
                        <li><h2><a href="#">Revisi&oacute;n de Estudios</a></h2></li>
                        <li><h2><a href="#">&Aacute;rea de Computo</a></h2></li><li>
                        -->
                        <li><h2><a href="./">Alumnos &gt;&gt;</a></h2>
                            <ul>
                                <li>
                                	<a  href="../almn/">Tr&aacute;mites Escolares</a>
                                </li>
                                <li>
                                	<a href="https://www.dgae-siae.unam.mx/www_gate.php">Historiales Acad&eacute;micos</a>
                                </li>
                                <li>
                                	<a href="http://www.aragon.unam.mx/horarios/horarios/horarios/">Horarios Escolares</a>
                                </li>
                                
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--termina menu-interna-->
                <!--inicia info-estudiantes-->
                <div class="info-estudiantes">
                	<!--inicia info-contenido-->
                    <div class="info-contenido" id="contenido">
                   		<!--inicia noticias-->
                        <div class="noticias">
                        	<!--inicia contenido-central-->
                            <div class="info-contenido" id="contenido-central">
                                <!-- InstanceBeginEditable name="Contenido" -->
                                <div class="noticias">
                                	<br	 />
                                	<br	 />
									<p class="titulos-noticas-ext">Si el sistema te menciona que no est&aacute;s registrado, por favor vuelve a realizar el proceso de <a href="./registro.php">registro de nuevos usuarios</a></p>
                                    <form id="login" name="login" action="" method="post">
                                        <fieldset id="lgn">
                                            <legend>INGRESAR AL SISTEMA</legend><br />
                                            <label for="usr">No. DE CUENTA: </label>
                                            <input class="unbl" id="usr" name="usr" type="text" size="15"/><br />
                                            <label for="pass">CONTRASE&Ntilde;A: </label>
                                            <input class="unbl" id="pass" name="pass" type="password" size="15" /><br /><br />
                                            <input id="sbmt" class="unbl" type="submit" value="Aceptar"/>
											<br />
                                            <br />
                                            <a href="./recCon.php">RECUPERA TU CONTRASE&Ntilde;A AQU&Iacute;</a>
                                            <br /><br />
                                            <a href="./registro.php">REGISTRO DE NUEVOS USUARIOS</a>
                                        </fieldset>
                                    </form>
                                  <!-- img src="imgs/consid.png" / -->
                                </div>
          					<!-- InstanceEndEditable -->
                            </div>
                            <!--termina contenido central-->
                        </div>
                        <!--termina noticias-->
                    </div>
                    <!--termina info-contenido-->
                </div>
                <!--termina info-estudiantes-->
                <!--inicia pie banners y pie derechos-->
                <div class="pie-banners">
                </div>
                <div class="pie-derechos">
                    <div>
                       Hecho en M&eacute;xico, todos los derechos reservados  <?php echo date("Y");?>. Esta p&aacute;gina puede ser
                        reproducida con fines no lucrativos, siempre y cuando no se mutile, se cite la 
                        fuente completa y su direcci&oacute;n electr&oacute;nica. De otra forma requiere permiso
                         previo por escrito de la instituci&oacute;n.<!-- <a href="#">Cr&eacute;ditos</a>-->
                    </div>
                    <div class="administrado">
                        Sitio web administrado por: <b>Departamento de Servicios Escolares Arag&oacute;n</b><br />
                            Contacto: <b>dudasinscripciones@hotmail.com</b><br />
                            Tel.: <b>56-23-10-66</b> ó <b>56-23-10-05</b>
                    </div>
                </div>
               	<!--termina pie banners y pie derechos--> 
            </div>
            <!-- termina contenido --> 
        </div>
      <!--termina contenedor-->
    </body>
<!-- InstanceEnd --></html>
