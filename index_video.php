<?php
	include_once("php/noCache.php");
    include_once("php/fecha.php");
    noCache();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantilla-externa.dwt" codeOutsideHTMLIsLocked="false" -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Pragma" content="no-cache">
        <!-- InstanceBeginEditable name="KeyWords" -->
        <meta name="Keywords" content="UNAM, servicios, escolares, aragon" />
        <!-- InstanceEndEditable -->
        <meta name="robots" content="INDEX,NOFOLLOW,NOARCHIVE" /> 
        <meta name="description" content="Departamento de Servicios Escolares Aragon" />
        <meta name="country" content="Mexico" />
        
        <link rel="shortcut icon" href="http://recursosweb.unam.mx/imagenes/favicon.ico" />
        <!-- InstanceBeginEditable name="doctitle" -->
		<title>Departamento de Servicios Escolares Arag&oacute;n</title>
		<!-- InstanceEndEditable -->
        
        <link type="text/css" rel="stylesheet" href="css/estilos-internas.css" title="normal"/>
        <link type="text/css" rel="stylesheet" href="css/nav-v.css" />
        <link type="text/css" rel="stylesheet" href="css/estilos-generales.css" />
        <link type="text/css" rel="stylesheet" href="css/custom-theme/jquery-ui-1.10.3.custom.min.css"  />
        <!-- InstanceBeginEditable name="Styles" -->
        <style type="text/css">
			div.noticias>p{
				float: left;
				width: 48%;
				height: 65px;
				margin: 5px;
			}
			div.noticias>p img{
				float: left;
				margin-right: 5px;
			}
        </style>
		<!-- InstanceEndEditable -->
        
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.1.custom.js"></script>
        <script type="text/javascript" src="js/nav-v.js"></script>
        <!-- InstanceBeginEditable name="Scripts" -->
        <script type="text/javascript">
			//SE DETECTA QUE EL NAVEGADOR TENGA LAS "COOKIES" ACTIVADAS
			$(function(){
				
				setInterval(function(){$('#inscOrd').effect('highlight', 1000);}, 1000);
				
				if (navigator.cookieEnabled == 0) {
					//SI ESTAS NO LO ESTAN, SE DESPLIEGA UN MENSAJE INFORMANDOLO
					$('body').append('<p id="dialog" > El navegador tiene las <i>"cookies"</i> desactivadas.'
					+ '<br /><br />Para visualizar correctamente este sitio, es indispensable que las'
					+ ' <i>"cookies"</i> est&eacute;n habilitadas.</p>');
					
					$('#dialog').dialog({
						title: '¡Atención!',
						dialogClass: 'ui-state-highlight',
						modal: true,
                		resizable: false,
						width: '500px',
						buttons: {'Aceptar': function() {$(this).dialog('close');}},
						beforeClose: function() {
							$(this).parent().hide('drop', {direction: 'down'}, 250);
							//console.log($(this).parent().attr('class'));
						},
						close: function() {
							$(this).dialog('destroy').remove();
						}
					});
				}
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
            	<a href="http://www.unam.mx"><img src="imgs/encabezado-unam.gif" border="0" alt="UNAM"/></a>
                <img src="imgs/stock/rotate.php" width="560" height="103" alt="CAMPUS"/>
            </div>
            <!-- termina encabezado -->
            <!-- inicia navegacion -->
            <div class="navegacion">
                <!--inicia navegacion-inicio-->
                <div class="navegacion-inicio">
                <a href="../index.php">
                	<img src="imgs/house.gif" alt="Ir a página principal" title="Ir a página principal" width="16" height="16" border="0"/>
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
                <div class="topinterna">
                    <img src="imgs/titulo-generico.jpg" alt="DGAE-ARAGON" width="980" height="61" border="0" usemap="#Map2" />
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
                                	<a  href="almn/">Tr&aacute;mites Escolares</a>
                                </li>
                                <li>
                                	<a href="https://www.dgae-siae.unam.mx/www_gate.php">Historiales Acad&eacute;micos</a>
                                </li>
                                <li>
                                	<a href="http://www.aragon.unam.mx/horarios2/">Horarios Escolares</a>
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
                                    <!--
                                    <center>
                                    	<h1 class="titulos-noticas-ext"> FACULTAD DE ESTUDIOS SUPERIORES ARAG&Oacute;N</h1>
                                    	<h3>DEPARTAMENTO DE SERVICIOS ESCOLARES ARAG&Oacute;N</h3>
                                    </center>
                                    -->
                                    <br />
									<br />
                                    <!--
									<div style="color: #4F8A10; background-color: #DFF2BF; border: 1px solid; padding: 5px; font-weight: 600; border-radius: 5px;">
                                        	<h1>
                                           LOS ALUMNOS DE PRIMER INGRESO 2014-I PODR&Aacute;N REALIZAR EL REGISTRO Y ACTIVACI&Oacute;N DE CUENTA PARA REINSCRIPCI&Oacute;N A 2014-II, A PARTIR DEL D&Iacute;A 6 DE ENERO DE 2014.
                                            </h1>
                                    </div>
									-->
                                    <div class="info">
                                        	<h2>
                                            	<a href="almn/">
                                                	PARA CONSULTAR EL HORARIO DE REINSCRIPCI&Oacute;N AL SEMESTRE 2014-II, DA CLICK AQU&Iacute;.
                                                </a>
                                            </h2>
                                    </div>
                                    <br />
									<br />
									<!--*********************************************************-->
						
									<div align="center">
									<h3>Video-ejemplo del proceso de reinscripci&oacute;n al semestre 2014-2</h3>
									<p class="titulos-noticas-ext">
									<object type="application/x-shockwave-flash" data="player_flv_maxi.swf" width="720" height="480">
									<param name="movie" value="player_flv_maxi.swf" />
			     					<param name="FlashVars" value="flv=video/videoInscrpcion.flv&amp;autoload=1&amp;showstop=1&amp;showtime=1&amp;showfullscreen=1&amp;showiconplay=1" />
									<param name="allowFullScreen" value="true" />
									
			     					
									</object>
									<br />
									Nota: Si eres de la carrera de Derecho o de Pedagog&iacute;a segundo semestre, la selecci&oacute;n de materias es por bloque.
									S&oacute;lo debes seleccionar un grupo y el sistema muestra todas las materias correspondientes a ese grupo.
									 </p>
									</div>
                                    <p class="titulos-noticas-ext">
                                        <a href="http://www.unam.mx/">
                                            <img src="http://132.248.44.212/ima/unam.gif" border="0" height="30" width="100" alt="UNAM" /><span>Portal de la UNAM  </span>
                                        </a>
                                    </p>
                                    <!--*********************************************************-->                                    <p class="titulos-noticas-ext">
                                        <a href="http://www.aragon.unam.mx/">
                                            <img src="http://132.248.44.212/ima/aragon.jpg" border="0" height="50" width="100" alt="FES Aragon" /><span>P&aacute;gina principal de la FES Arag&oacute;n</span>
                                        </a>
                                    </p>
                                    <!--*********************************************************-->                                    <p class="titulos-noticas-ext">
                                        <a href="http://132.248.44.79/lenguas/">
                                        	<img src="http://132.248.44.212/ima/cle.jpg" border="0" height="30" width="100" alt="CLE Aragon" />CLE - Centro de Lenguas Extranjeras.
                                        </a>
                                    </p>
                                    <!--*********************************************************-->
                                    <p class="titulos-noticas-ext">
                                    	<a href="http://biblioteca-fes.aragon.unam.mx:8991/F">
                                    		<img src="http://132.248.44.212/ima/biblio.gif" height="50" width="100" border="0" alt="Biblioteca" />Biblioteca Jesus Reyes Heroles.
                                        </a>
                                    </p>
                                    <!--*********************************************************-->
                                    <p class="titulos-noticas-ext">
                                        <a href="http://www.pve.unam.mx/">
                                            <img src="http://132.248.44.212/ima/pve.jpg" height="50" width="100" border="0" alt="Credencial de Exalumno" />Tramita tu credencial de ex-alumno.
                                        </a>
                                    </p>
                                    <!--*********************************************************-->
                                    <p class="titulos-noticas-ext">
                                    	<a href="https://www.dgae.unam.mx/noticias/primingr/tramitesescolares/">
                                        	<img src="http://132.248.44.212/ima/tram_serv.gif" border="0" height="30" width="100" alt="Calendario" />Calendario de Tr&aacute;mites.
                                        </a>
                                    </p>
                                   
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
                            Tel.: <b>56-23-10-66 ó 56-23-10-05</b>
                    </div>
                </div>
               	<!--termina pie banners y pie derechos--> 
            </div>
            <!-- termina contenido --> 
        </div>
      <!--termina contenedor-->
    </body>
<!-- InstanceEnd --></html>
