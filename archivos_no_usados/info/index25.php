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
            	<img src="imgs/encabezado.png" style="width:100%;" alt="FES-ARAGON" title="DEPARTAMENTO DE SERVICIOS ESCOLARES" />
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
                <a href= "../index.php">
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
                <div class="topinterna" style=" display: none;" >
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
							<a href="http://www.imss.gob.mx/faq/seguro-estudiantes"><img src="imgs/banner5.png" alt="IMSS" longdesc="IMSS" /></a>
                            <div class="info-contenido" id="contenido-central">
                                <!-- InstanceBeginEditable name="Contenido" -->
                                <div class="noticias">
			<?php
			//SUSPENSION TEMPORAL DE ESTUDIOS
                            $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("21-05-2020 00:01:00");
                            $f_fin = strtotime("29-05-2020 23:59:59");
                            //$f_com = strtotime("17-10-2014 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
			    ?>
				<br />
                                    <div class="info">
                                        	<h2><center>
                                            	<a href="susp_temp/">
                                                    Convocatoria extraordinaria para <br> SUSPENSI&Oacute;N TEMPORAL DE ESTUDIOS <br>
                                                    Debido a la contingencia sanitaria.
				                </a>
                                            </center></h2>
                                    </div> 
                            <?php
				}

			//HORARIO DE REINSCRIPCION
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("27-01-2020 00:01:00");
                            $f_fin = strtotime("04-02-2020 23:59:59");
                            //$f_com = strtotime("26-08-2014 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
			    ?>
				<br />
                                    <div class="info">
                                        	<h2>
                                            	<a href="almn/">
                                            	
                                            	<!--

                                            	     	CONSULTA TU HORARIO DE REINSCRIPCI&Oacute;N AL SEMESTRE 2020-II AQU&Iacute;.
															-->                                            	
                                                    CONSULTA TU HORARIO DE ALTAS Y BAJAS DEL SEMESTRE 2020-II.
															
                                                </a>
                                            </h2>
                                    </div> 
                            <?php
				}

			//HORARIO DE EXTRAORDINARIOS
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("17-08-2020 00:01:00");
                            $f_fin = strtotime("21-08-2020 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
			    ?>
                <br />
                <div class="info">
                   <a href="http://132.248.44.207/almn/">
                       <h3>
                        <p align="center"> REGISTRO DE EXTRAORDINARIOS</p>
                        El registro estar&aacute; disponible del 19 de Agosto a las 00:01 hrs. 
                        hasta el 21 de Agosto a las 23:59 hrs.  
                        <br />
                        Indicaciones:<br /><br />
                        1.- Acceder al sitio AQU&Iacute; <br />
                        2.- Seleccionar la opci&oacute;n: Registro de extraordinarios e iniciar inscripci&oacute;n. <br />
                        3.- Seleccionar asignatura y jurado.<br />
                        4.- Dar clic en INSCRIBIR.<br />
                        5.- Repetir los pasos 2 y 3 las veces que sean necesarias.<br />
                        6.- Finalizar  la inscripci&oacute;n. <br />
                        7.- Imprimir comprobante para cualquier aclaraci&oacute;n. <br />
                    </a>
                    <h3><a href="http://132.248.44.207/almn/">Recuerda que ya NO es necesario el pago para tus extraordinarios, s&oacute;lo reg&iacute;stralos. <br/></a></h3>
                    <h4>Recuerda que para que el sistema funcione correctamente debes ingresar a trav&eacute;s de este sitio y no directamente al sistema de inscripciones.</h4>
                </div>
                <br />

                <?php
				}

		//PERMISO PARA MAYOR NUMERO DE EXTRAS
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("25-06-2020 00:00:00");
                            $f_fin = strtotime("01-07-2020 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
			    ?>
                <br />
                <div class="info">
                   <h3>
                       <a href="almn/">
                        <p  align="center">SOLICITUD PARA MAYOR N&Uacute;MERO DE EX&Aacute;MENES EXTRAORDINARIOS <br /></p>
                        <p align="justify">Alumnos que desean presentar un mayor número de  ex&aacute;menes extraordinarios en la 2a. vuelta y alumnos afectados por art&iacute;culo 22.</p>

                    Solicitar el permiso los d&iacute;as 29, 30 de junio y 01 de julio de 2020</p>
                    <p align="center"> AQU&Iacute;.</p>
                    <p>Nota: Este proceso es complementario al realizado en marzo de 2020, por lo que si ya realizaste el tr&aacute;mite este semestre, no es necesario que lo vuelvas a realizar.</p>
                    <p>El máximo número de asignaturas que puedes registrar en extraordinario es de 6 incluyendo las dos vueltas del semestre.</p>

                </a>
            </h3>
        </div> 
        <?php
    }

//
        //Calendario de tramites escolares
                $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("20-07-2020 00:00:00");
                            $f_fin = strtotime("07-08-2020 23:59:59");
                            if($f_act > $f_ini and $f_act <= $f_fin)
                {
                ?>
                <br />
                <div class="info">
                    <h3 align="center">
                       Consulta el calendario de trámites escolares <a href="https://www.escolar.unam.mx/calendarios_tramites.html">AQUI</a><br>
                       Consulta el procedimiento <a href="https://www.dgae-siae.unam.mx/actividades/tramites/procedimientos/"> AQUI</a>
                    </h3>
        </div> 
        <?php
    }

//


			//CONVOCATORIA CAMBIO DE TURNO PRIMER INGRESO
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("22-07-2019 00:00:00");
                            $f_fin = strtotime("02-08-2019 23:59:59");
                            //$f_com = strtotime("21-06-2018 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                                    <div class="info">
                                        	<h2>
                                            	<a href="info/convocatoria_pi_2020.pdf">
                                                    Convocatoria para Cambio de Turno Primer Ingreso semestre 2020-I

                                                </a>
                                            </h2>
                                    </div> 
                    	 <?php
				}



			//CAMBIO DE TURNO PRIMER INGRESO
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("25-07-2019 00:00:00");
                            $f_fin = strtotime("02-08-2019 23:59:59");
                            //$f_com = strtotime("21-06-2018 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                                    <div class="info">
                                        	<h2>
                                            	<a href="camTur/">
                                                    Cambio de Turno Primer ingreso 2020

                                                </a>
                                            </h2>
                                    </div> 
                    	 <?php
				}



			//RESULTADOS CAMBIO DE TURNO PRIMER INGRESO
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("02-08-2019 10:00:00");
                            $f_fin = strtotime("05-08-2019 23:59:59");
                            //$f_com = strtotime("21-06-2018 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                                    <div class="info">
                                        	<h2>
                                            	<a href="camTur/">
                                                    Resultados de Cambio de Turno Primer Ingreso 2020


                                                </a>
                                            </h2>
                                    </div> 
                    	 <?php
				}


			//CONVOCATORIA PARA CAMBIO DE TURNO REINGRESO
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("22-11-2019 00:00:00");
                            $f_fin = strtotime("09-01-2020 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                        	        <div class="info">
                        	            <h2>
                        	               	<a href="/info/convocatoria_reingreso_20-II.pdf">
						Convocatoria Cambio de Turno Reingreso 2020-II.
                        	                </a>
                        	            </h2>
                        	        </div> 
                            <?php
				} 

			//CAMBIO DE TURNO REINGRESO
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("09-12-2019 00:01:00");
                            $f_fin = strtotime("10-12-2019 23:59:59");
                            //$f_com = strtotime("21-06-2018 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                                    <div class="info">
                                        	<h2>
                                            	<a href="almn/">
                                                    Cambio de Turno Reingreso semestre 2020-II

                                                </a>
                                            </h2>
                                    </div> 
                    	 <?php
				}

			//RESULTADOS CAMBIO DE TURNO
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("09-01-2020 12:00:00");
                            $f_fin = strtotime("13-01-2020 23:59:59");
                            //$f_com = strtotime("21-06-2018 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                                    <div class="info">
                                        	<h2>
                                            	<a href="almn/">
                                                    Resultados de Cambio de Turno Reingreso semestre 2020-II

                                                </a>
                                            </h2>
                                    </div> 
                    	 <?php
				}

				//PROCESO BAJAS POR COVID-19
				    $f_act = strtotime(date("d-m-Y H:i:00",time()));
				    $f_ini = strtotime("25-05-2020 00:01:00");
				    $f_fin = strtotime("29-05-2020 23:59:00");
				                //$f_com = strtotime("21-06-2018 23:59:59");
				    $f_com = '';
				    if($f_act > $f_ini and $f_act <= $f_fin)
				    {
				        ?>
				        <br />
				        <div class="info">
				            <h2 align="center">
				                <a href="http://132.247.154.41">
				                 Para ingresar al proceso de baja de asignaturas da clic AQU&Iacute;
				             </a>
				         </h2>
				     </div> 
				     <?php
				 }   


            //BAJAS POR COVID-19
                $f_act = strtotime(date("d-m-Y H:i:00",time()));
                $f_ini = strtotime("18-05-2020 00:01:00");
                $f_fin = strtotime("29-05-2020 23:59:00");
                            //$f_com = strtotime("21-06-2018 23:59:59");
                $f_com = '';
                if($f_act > $f_ini and $f_act <= $f_fin)
                {
                    ?>
                    <br />
                    <div class="info">
                        <h2 align="center">
                            <a href="info/bajas_20202.html">
                             Debido a la contingencia sanitaria la FES Arag&oacute;n te brinda la opci&oacute;n de dar de baja asignatura(s) inscrita(s) en el semestre 2020-2, m&aacute;s informaci&oacute;n AQUI
                         </a>
                     </h2>
                 </div> 
                 <?php
             }   


            //INSCRIPCION A REMEDIALES
                $f_act = strtotime(date("d-m-Y H:i:00",time()));
                $f_ini = strtotime("17-06-2020 00:01:00");
                $f_fin = strtotime("26-06-2020 23:59:00");
                            //$f_com = strtotime("21-06-2018 23:59:59");
                $f_com = '';
                if($f_act > $f_ini and $f_act <= $f_fin)
                {
                    ?>
                    <br />
                    <div class="info">
                        <h2 align="center">
                            <a href="almn/">
                                Inscripción de Cursos Remediales<br><br>
                             Consulta tu fecha y hora de sorteo a partir del 18 de junio de 2020, AQUI
                         </a>
                     </h2>
                 </div> 
                 <?php
             }   




			//SELECCION DE AREA
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("06-05-2020 00:01:00");
                            $f_fin = strtotime("20-05-2020 23:59:00");
                            //$f_com = strtotime("21-06-2018 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                                    <div class="info">
                                        	<h2 align="center">
                                            	<a href="almn/">
                                                    La selecci&oacute;n de &aacute;rea para las carreras de:<br>
                                                    Comunicaci&oacute;n y Periodismo,<br>
                                                    Econom&iacute;a,<br>
                                                    Ing. El&eacute;ctrica Electr&oacute;nica,<br>
                                                    Ing. Industrial,<br>
                                                    Ing. Mec&aacute;nica<br>
                                                    Ser&aacute; los d&iacute;as: 18 y 19 de Mayo, AQUI.
                                                    

                                                </a>
                                            </h2>
                                    </div> 
                    	 <?php
				}				
				

				
			//SUSPENSION DEL SERVICIO
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("28-08-2019 12:00:00");
                            $f_fin = strtotime("30-08-2019 23:59:59");
                            //$f_com = strtotime("21-06-2018 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                                    <div class="info">
                                    	<h2 align="center">AVISO</h2>
                                        	<p>
                                            	El Centro Integral de Servicios Estudiantiles no dar&aacute; servicio el d&iacute;a 30 de Agosto de 2019, el personal de base asistir&aacute; al Congreso de su Sindicato, se reanudar&aacute; la atenci&oacute;n el d&iacute;a 02 de Septiembre de 2019.
                                            </p>
                                            <p align="center">
                                            	Atentemente <br> El CISE
                                            </p>
                                    </div> 
                    	 <?php
				}

			//PAGO DE CUOTA ANUAL
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("06-05-2019 00:01:00");
                            $f_fin = strtotime("28-07-2019 23:59:59");
                            //$f_com = strtotime("17-10-2014 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                                  <div class="info">
                                        	<h2 align="center">REINSCRIPCI&Oacute;N AL SEMESTRE 2020-1</h2> <br>

													<p>El per&iacute;odo para realizar el pago y entrega de comprobante es del 06 de mayo al 07 de junio de 2019, bajo el siguiente procedimiento:</p>

													1. Pagar en las cajas del plantel o en instituci&oacute;n bancaria.<br>
													2. Entregar el comprobante de pago en el CISE, una vez entregado se reflejará el pago hasta el 24 de Junio.  <br>
													3. Revisar el d&iacute;a 24 de junio tu horario de reinscripci&oacute;n en <a href="/almn">http://aragon.dgae.unam.mx</a>.<br><br>
                                                       En caso de no realizar y entregar el pago en estas fechas, tendr&aacute;s que reinscribirte en el periodo de altas y bajas, ingresa el día 29 de Julio a ésta p&aacute;gina y sigue el procedimiento que se indicará. 
													   
									                      
													<br>
									   <h5>Consideraciones:</h5>
												  <h5>Conserva tu comprobante de pago sellado para cualquier aclaración. <br>
												    El horario de cajas de la FES es de 09:45 a 13:00 y de 16:00 a 19:00hrs.<br>
												    El horario del CISE es de 09:30 a 13:30 y de 16:00 a 20:00hrs.<br>
												    Si quieres pagar en instituci&oacute;n bancaria, los n&uacute;meros de convenio est&aacute;n publicados en el apartado de reinscripci&oacute;n de la p&aacute;gina:
									                <a href="/info/tram.html">http://aragon.dgae.unam.mx/info/tram.html</a>. </h5>
                                  </div> 
                    	          <?php
				}							
						
			//PAGO DE CUOTA ANUAL
			    $f_act = strtotime(date("d-m-Y H:i:00",time()));
                            $f_ini = strtotime("29-07-2019 00:01:00");
                            $f_fin = strtotime("04-08-2019 23:59:59");
                            //$f_com = strtotime("17-10-2014 23:59:59");
                            $f_com = '';
                            if($f_act > $f_ini and $f_act <= $f_fin)
				{
				?>
				<br />
                                  <div class="info">
                                        	<h2 align="center">PAGO DE CUOTA ANUAL  2020-1</h2> <br>

													<p>Este procedimiento aplica s&oacute;lo para alumnos que no entregaron su pago de cuota anual en tiempo y forma.</p>
													
													<p>El per&iacute;odo para realizar el procedimiento son los d&iacute;as 30 y 31 de julio de 2019</p>

													1. Pagar en las cajas de Ciudad Universitaria o en instituci&oacute;n bancaria.<br>
													2. Enviar un s&oacute;lo correo a la direccion <a href="mailto:serviciosescolares@aragon.unam.mx">serviciosescolares@aragon.unam.mx</a>, 
													   anexando comprobante de pago, nombre completo, no. de cuenta y carrera.<br>
													3. Revisar el d&iacute;a 05 de agosto tu horario de sorteo en <a href="/almn">http://aragon.dgae.unam.mx</a>.<br><br>
                                                       En caso de no realizar este procedimiento ya no podr&aacute;s inscribirte en el semestre 20201. 
													   
									                      
													<br>
									   <h5>Consideraciones:</h5>
												  <h5>
												    Si quieres pagar en instituci&oacute;n bancaria, los n&uacute;meros de convenio est&aacute;n publicados en el apartado de reinscripci&oacute;n de la p&aacute;gina:
									                <a href="/info/tram.html">http://aragon.dgae.unam.mx/info/tram.html</a>.</h5>
                                  </div> 
                    	          <?php
				}

			    ?>

<!-- TERMINAN ALERTAS  -->

									<!--*********************************************************--
                                    <p class="titulos-noticas-ext">
                                        <a href="/info/tram.html">
                                            <span>Información de Trámites para Alumnos</span>
                                        </a>
                                    </p>
                                    <!--*********************************************************--   
                                    <p class="titulos-noticas-ext">
                                        <a href="/info/tramEgre.html">
                                            <span>Información de Trámites para Egresados</span>
                                        </a>
                                    </p>
									<!--*********************************************************--
									          <p class="titulos-noticas-ext">
                                    	<a href="/cal_esc">
                                        	<img src="ima/tram_serv.gif" border="0" height="30" width="100" alt="Calendario" />Calendario de Escolar
                                        </a>
                                    </p>
     								<!--*********************************************************--
                                    <p class="titulos-noticas-ext">     								
                                        <a href="http://www.aragon.unam.mx/">
                                            <img src="ima/aragon.jpg" border="0" height="50" width="100" alt="FES Aragon" /><span>P&aacute;gina principal de la FES Arag&oacute;n</span>
                                        </a>
                                    </p>
                                    <!--*********************************************************--
                                    <p class="titulos-noticas-ext">
                                    	<a href="http://www.aragon.unam.mx/aragon/biblioteca.html"><a href="http://www.aragon.unam.mx/aragon/biblioteca.html"></a><a href="http://www.aragon.unam.mx/aragon/biblioteca.html"><img src="ima/biblio.gif" height="50" width="100" border="0" alt="Biblioteca" /></a>Biblioteca Jesus Reyes Heroles.                                        </a>                                    </p>
                                    <!--*********************************************************--
                                    <p class="titulos-noticas-ext">
                                        <a href="http://www.unam.mx/">
                                            <img src="ima/unam.gif" border="0" height="30" width="100" alt="UNAM" /><span>Portal de la UNAM  </span>
                                        </a>
                                    </p>
                                    <!--*********************************************************--
                                    <p class="titulos-noticas-ext">
                                        <a href="http://www.pve.unam.mx/">
                                            <a href="http://www.pve.unam.mx/"><img src="ima/pve.jpg" height="50" width="100" border="0" alt="Credencial de Exalumno" /></a>Tramita tu credencial de ex-alumno.                                        </a>                                    </p>
                                    <!--*********************************************************-->
 <p class="info-contenido-15">
									    <a href="info/tram_preguntas.html">
										    <img src="ima/projo.png" alt="projo" width="100" height="70" border="0" longdesc="Preguntas frecuentes" />
PREGUNTAS FRECUENTES DE TRAMITES											</a>								
                            
                                   
                                </div>
          					<!-- InstanceEndEditable -->
							 <p class="titulos-noticas-ext">
									    <a href="info/tram_preguntas.html">
										    <img src="ima/projo.png" alt="projo" width="100" height="70" border="0" longdesc="Preguntas frecuentes" />
PREGUNTAS FRECUENTES DE TRAMITES EN CONTINGENCIA COVID
											<img src="ima/coronavirus.png" alt="img" width="100" height="70" /></a>
								</p>
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
