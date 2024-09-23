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
					title: '¡Atenci&oacute;n!',
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
			<!-- inicia contenedor que centra la p&aacute;gina -->
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
				<a href= "./index.php">
					<img src="imgs/house.gif" alt="Ir a p&aacute;gina principal" title="Ir a p&aacute;gina principal" width="16" height="16" border="0"/>
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
					<img src="../imgs/email.gif" alt="Cont&aacute;ctanos por e-mail" width="16" height="13" />
					<a href="#"> Contacto</a>
				</div>
			-->
			<!--termina navegacion-mapa-->
			
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
			<!-- inicia t&iacute;tulos im&aacute;genes  -->
			<div class="topinterna" style=" display: none;" >
				<img src="imgs/titulo-generico.jpg" alt="DGAE-ARAGON" width="980" height="61" border="0" usemap="#Map2" />
				<map name="Map2" id="Map2">
					<area shape="rect" coords="61,18,553,47" href="./" alt="DGAE-ARAGON"/>
				</map>
			</div>
			<!-- termina t&iacute;tulos im&aacute;genes  -->
			<!--inicia menu-interna-->

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
							<div >
								<h2>
									<center>
										<p>Esta página es de caracter informativo</p>
									</center>
								</h2>
								<p>Para realizar tr&aacute;mites escolares por favor ingresa a <a href="http://tramifes.aragon.unam.mx"> http://tramifes.aragon.unam.mx</a> o acude al Departamento de Servicios Escolares, ubicado en el CISE (Edificio A1, planta baja) en el horario de atenci&oacute;n:<p>  
									<center><b>lunes a viernes:</b> de 9:30 a 13:30 y de 16:00 a 20:00hrs.</center>
								</div>
								<div class="noticias">
									<?php
//------------------Inician los avisos programados --------------------------
			//AVISO POR CIERRE DE INSTALACIONES
									$f_act = strtotime(date("d-m-Y H:i:00",time()));
									$f_ini = strtotime("15-12-2021 00:01:00");
									$f_fin = strtotime("09-01-2022 23:59:00");
							//$f_com = strtotime("21-06-2018 23:59:59");
									$f_com = '';
									if($f_act > $f_ini and $f_act <= $f_fin)
									{
										?>
										<br />
										<div class="info">
											<h1 align="center">A LA COMUNIDAD ESTUDIANTIL</h1>
											<h2 align="justify">

												Con motivo del Segundo periodo vacacional (del 18 de diciembre de 2021 al 05 de enero de 2022)
												se suspenden las actividades del Centro Integral de Servicios Estudiantiles (CISE).<br><br>

												El servicio se reanudar&aacute; el d&iacute;a 10 de enero en el siguiente horario:<br><br>

												Matutino:   09:30hrs a 13:30hrs<br>
												Vespertino: 16:00hrs a 20:00hrs<br><br>

												Para agendar una cita comunicate con tu Jefatura de Carrera a partir del 06 de enero de 2022.


											</h2>

										</div> 
										<?php
									}

			//INSTRUCCIONES PARA CUENTA @aragon
									$f_act = strtotime(date("d-m-Y H:i:00",time()));
									$f_ini = strtotime("02-08-2021 01:00:00");
									$f_fin = strtotime("30-08-2021 23:59:59");
							//$f_com = strtotime("21-06-2018 23:59:59");
									$f_com = '';
									if($f_act > $f_ini and $f_act <= $f_fin)
									{
										?>
										<br />
										<div class="info">
											<h2 align="center">
											Pasos para generar tu cuenta @aragon</h2>
											<ol>
												<li>1.- Date de alta en <a href="/almn/registro.php">Servicios Escolares.</a> </li>
												<li>2.- Genera tu cuenta @aragon en la <a href="https://plataformaeducativa.aragon.unam.mx/cuentas/">Plataforma Educativa Arag&oacute;n</a></li>
												<li>3.- Genera tu contraseña  de tu cuenta @aragon <a href="https://plataformaeducativa.aragon.unam.mx/contrasenia/">AQU&Iacute;</a></li>
											</ol>
										</h2>
									</div> 
									<?php
								}

			//INSCRIPCION DE PRIMER INGRESO
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("20-01-2022 01:00:00");
								$f_fin = strtotime("26-01-2022 23:59:59");
							//$f_com = strtotime("21-06-2018 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h2 align="center">
											<a href="primer_ingreso/">
												BIENVENIDA GENERACI&Oacute;N 2022<br>
												Realiza tu proceso de inscripci&oacute;n a partir del 21 de 
												enero a las 10:00 hrs. y hasta el 25 de enero a las 23:59<br>
												AQUI.
											</a>
										</h2>
									</div> 
									<?php
								}

			//CONVOCATORIA CAMBIO DE TURNO PRIMER INGRESO
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("29-07-2024 00:01:00");
								$f_fin = strtotime("12-08-2024 23:59:59");
							//$f_com = strtotime("21-06-2018 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h2>
											<a href="info/convocatoria_pi_2025.pdf" target="_blank">
												Convocatoria para Cambio de Turno Primer Ingreso 2025-I

											</a>
										</h2>
									</div> 
									<?php
								}

			//CAMBIO DE TURNO PRIMER INGRESO
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("31-06-2024 10:00:00");
								$f_fin = strtotime("06-08-2024 11:59:59");
							//$f_com = strtotime("21-06-2018 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h2 align="center">
											<a href="camTur/">
												Cambio de Turno Primer ingreso 2025

											</a>
										</h2>
									</div> 
									<?php
								}

			//RESULTADOS CAMBIO DE TURNO PRIMER INGRESO
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("09-08-2024 18:00:00");
								$f_fin = strtotime("12-08-2024 23:59:59");
							//$f_com = strtotime("21-06-2018 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h2>
											<a href="camTur/">
												Resultados de Cambio de Turno Primer Ingreso 2025
											</a>
										</h2>
									</div> 
									<?php
								}


	//PREMIO AL SERVICIO SOCIAL DR. GUSTAVO BAZ PRADA
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("18-04-2024 09:00:00");
								$f_fin = strtotime("09-05-2024 23:59:59");
							//$f_com = strtotime("17-10-2014 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h2><center>

											<a href="info/tram_ss_gustavo.html">
												Convocatoria <br> Premio al Servicio Social "Dr. Gustavo Baz Prada" 2024<br><br>
												Consulta la convocatoria aqu&iacute;

											</a>
										</center></h2>
									</div> 
									<?php
								}

			//SUSPENSION TEMPORAL DE ESTUDIOS
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("16-08-2024 10:00:00");
								$f_fin = strtotime("25-08-2024 23:59:59");
 							//$f_fin = strtotime("17-02-2023 23:59:59");
							//$f_com = strtotime("17-10-2014 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h2><center>
											<a href="susp_temp/">
												<!--Cancelaci&oacute;n de--> Consulta la convocatoria para la SUSPENSI&Oacute;N TEMPORAL DE ESTUDIOS disponible a partir de las 10:00h del 21 de agosto de 2024 hasta las 23:59h del 23 de agosto de 2024 <br>

											</a>
										</center></h2>
									</div> 


									<?php
								}

	//CUESTIONARIO DE OPINION DE SERVICIOS DE LA UNAM
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("07-08-2024 09:00:00");
								$f_fin = strtotime("27-11-2024 23:59:59");
							//$f_com = strtotime("17-10-2014 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h2><center>

											<a href="https://cuestionario.planeacion.unam.mx/FES_Aragon/datos.php" target="_blank">
												CUESTIONARIO DE OPINI&Oacute;N DE SERVICIOS DE LA UNAM
										</center></h2>
										<p>Recuerda que cada semestre debes contestar el cuestionario de opini&oacute;n acerca de los servcios que ofrece la UNAM</p>
											</a>
									</div> 
									<?php
								}

			//HORARIO DE REINSCRIPCION
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("17-01-2022 00:01:00");
								$f_fin = strtotime("28-01-2022 23:59:59");
							//$f_com = strtotime("26-08-2014 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h2 align="center">
											<a href="almn/">
												CONSULTA TU HORARIO DE REINSCRIPCION <br>
												DEL SEMESTRE 2022-II <br>
												a partir del d&iacute;a 17 de Enero del 2022 a las 13:00hrs. <br>
												AQU&Iacute;.
											</a>
										</h2>
									</div> 

									<?php
								}

	 //HORARIO DE ALTAS Y BAJAS
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("30-01-2023 00:01:00");
								$f_fin = strtotime("03-02-2023 23:59:59");
							//$f_com = strtotime("26-08-2014 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h2 align="center">
											<a href="almn/">
												CONSULTA TU HORARIO DE ALTAS Y BAJAS <br>
												DEL SEMESTRE 2023-II <br>
												a partir del d&iacute;a 30 de enero de 2023 a las 12:00hrs. <br>
												AQU&Iacute;.
											</a>
										</h2>
									</div> 

									<?php
								}

	//HORARIO DE EXTRAORDINARIOS
								$f_act = strtotime(date("d-m-Y H:i:00",time()));
								$f_ini = strtotime("09-09-2024 00:01:00");
								$f_fin = strtotime("12-09-2024 23:59:59");
								$f_com = '';
								if($f_act > $f_ini and $f_act <= $f_fin)
								{
									?>
									<br />
									<div class="info">
										<h3 align="center"> REGISTRO DE EXTRAORDINARIOS<br> 2025-1 EA</h3>
										<h4 align="justify"> Reglamento General De Ex&aacute;menes, art&iacute;culo 16.- Los estudiantes tendr&aacute;n derecho a presentar hasta dos materias por semestre mediante ex&aacute;menes extraordinarios... . </h4>
										<p>El registro estar&aacute; disponible desde el 09 de septiembre de 2024 a las 00:01 hrs. 
											y <br />hasta el 11 de septiembre de 2024 a las 23:59 hrs. </p>
											<br />
											Indicaciones:<br /><br />
											<a href="http://132.247.154.41/" target="_blank">
												1.- Acceder al sitio de inscripciones AQU&Iacute; <br />
												2.- Iniciar sesi&oacute;n con no. de cuenta y contrase&ntilde;a e inicar inscripci&oacute;n<br />
												3.- Seleccionar asignatura y jurado.<br />
												4.- Dar clic en INSCRIBIR.<br />
												5.- Repetir los pasos 3 y 4 las veces que sean necesarias.<br />
												6.- Finalizar la inscripci&oacute;n. <br />
												7.- Imprimir comprobante para cualquier aclaraci&oacute;n. <br />
											</a>
											<h5>Recuerda que ya NO es necesario el pago para tus extraordinarios, s&oacute;lo reg&iacute;stralos e imprime tu comprobante.</h5>
										</div>
										<br />

										<?php
									}

 //PERMISO PARA MAYOR NUMERO DE EXTRAS
									$f_act = strtotime(date("d-m-Y H:i:00",time()));
									$f_ini = strtotime("01-03-2024 00:01:00");
									$f_fin = strtotime("25-04-2024 23:59:00");
									$f_com = '';
									if($f_act > $f_ini and $f_act <= $f_fin)
									{
										?>
										<br />
										<div class="info">
											<h2  align="center">SOLICITUD PARA MAYOR N&Uacute;MERO DE <br>EX&Aacute;MENES EXTRAORDINARIOS </h2> <br />

											<p align="justify">Alumnos afectados por art&iacute;culo 22 y alumnos que desean presentar un mayor n&uacute;mero de  ex&aacute;menes extraordinarios en la 2a. vuelta de acuerdo con el</p>

											<h3 align="justify"> Regramento General de Ex&aacute;menes, art 16.-  ...Solamente el Secretario General de la Universidad podr&aacute; conceder un n&uacute;mero mayor de ex&aacute;menes extraordinarios, previo informe favorable de la direcci&oacute;n de la Facultad o Escuela y de la Coordinaci&oacute;n de la Administraci&oacute;n Escolar. </h3>
											<a href="http://tramifes.aragon.unam.mx" target="_blank">
												<p>Podrán ingresar al sistema para realizar la solicitud a partir del 22 de abril de 2024 a las 10:00hrs <br>y hasta el 23 de abril de 2024 a las 23:59hrs </p>
												<p align="center"> AQU&Iacute;.</p>
											</a>
											<h5>Nota: El n&uacute;mero m&aacute;ximo de asignaturas que puedes solicitar por permiso es de 4, haciendo un total de 6 por semestre.</h5>

										</div> 
										<?php
									}

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
												Consulta el calendario de tr&aacute;mites escolares <a href="https://www.escolar.unam.mx/calendarios_tramites.html">AQUI</a><br>
												Consulta el procedimiento <a href="https://www.dgae-siae.unam.mx/actividades/tramites/procedimientos/"> AQUI</a>
											</h3>
										</div> 
										<?php
									}

//REPOSICION DE CREDENCIAL
									$f_act = strtotime(date("d-m-Y H:i:00",time()));
									$f_ini = strtotime("12-08-2024 00:00:00");
									$f_fin = strtotime("28-11-2024 23:59:59");
									if($f_act > $f_ini and $f_act <= $f_fin)
									{
										?>
										<br />
										<div class="info">
												<h3 align="center">
												REPOSICI&Oacute;N DE CREDENCIAL</h3>
											<a href="https://tramifes.aragon.unam.mx/">
												<p>Por favor ingresa AQU&Iacute; para solicitar la reposici&oacute;n de tu credencial UNAM.</a></p>
												<ul>
													<li>- La solicitud se realiza los d&iacute;as lunes y martes</li>
													<li>- Puedes recogerla en el CISE, de lunes a viernes en horario de atenci&oacute;n, a partir del siguiente lunes al que realizaste el tr&aacute;mite.</li>
													<li>- Deber&aacute;s presentar comprobante de inscripci&oacute;n y</li>
													<li>- Comprobante del Cuestionario de Opini&oacute;n de Servicios de la UNAM</li>
												</ul>
													 
											

											</div> 
											<?php
										}

//CONVOCATORIA PARA CAMBIO DE TURNO REINGRESO
										$f_act = strtotime(date("d-m-Y H:i:00",time()));
										$f_ini = strtotime("14-06-2024 00:01:00");
										$f_fin = strtotime("23-07-2024 23:59:59");
										$f_com = '';
										if($f_act > $f_ini and $f_act <= $f_fin)
										{
											?>
											<br />
											<div class="info">
												<h2>
													<a href="/info/convocatoria_reingreso_25-I.pdf">
														Convocatoria Cambio de Turno Reingreso 2025-I.
													</a>
												</h2>
											</div> 
											<?php
										} 

//CAMBIO DE TURNO REINGRESO
										$f_act = strtotime(date("d-m-Y H:i:00",time()));
										$f_ini = strtotime("17-06-2024 00:01:00");
										$f_fin = strtotime("22-06-2024 23:59:59");
							//$f_com = strtotime("21-06-2018 23:59:59");
										$f_com = '';
										if($f_act > $f_ini and $f_act <= $f_fin)
										{
											?>
											<br />
											<div class="info">
												<h2>
													<a href="/info/cam_tur.html">
														Cambio de Turno Reingreso semestre 2025-I.

													</a>
												</h2>
											</div> 
											<?php
										}

//RESULTADOS CAMBIO DE TURNO
										$f_act = strtotime(date("d-m-Y H:i:00",time()));
										$f_ini = strtotime("13-01-2023 12:00:00");
										$f_fin = strtotime("16-01-2023 23:59:59");
							//$f_com = strtotime("21-06-2018 23:59:59");
										$f_com = '';
										if($f_act > $f_ini and $f_act <= $f_fin)
										{
											?>
											<br />
											<div class="info">
												<h2>
													<a href="almn/">
														Resultados de Cambio de Turno Reingreso semestre 2023-II.

													</a>
												</h2>
											</div> 
											<?php
										}

//PROCESO PERIODO ESPECIAL PARA BAJAS DE ASIGNATURAS
										$f_act = strtotime(date("d-m-Y H:i:00",time()));
										$f_ini = strtotime("02-08-2021 00:01:00");
										$f_fin = strtotime("04-08-2021 21:59:00");
								//$f_com = strtotime("21-06-2018 23:59:59");
										$f_com = '';
										if($f_act > $f_ini and $f_act <= $f_fin)
										{
											?>
											<br />
											<div class="info">
												<h2 align="center">Per&iacute;odo especial para bajas de asignaturas</h2>
												<h3 align="justify">
													<a href="http://132.247.154.41/inscripciones/login">
														El sistema estar&aacute; abierto desde el 02 de Agosto 2021 a las 13:00 hras y hasta el 04 de Agosto 2021 a las 23:59 hrs. 
													</a>
												</h3>
											</div> 
											<?php
										}   

//BAJAS POR COVID-19
										$f_act = strtotime(date("d-m-Y H:i:00",time()));
										$f_ini = strtotime("07-12-2020 00:01:00");
										$f_fin = strtotime("10-12-2020 23:59:00");
							//$f_com = strtotime("21-06-2018 23:59:59");
										$f_com = '';
										if($f_act > $f_ini and $f_act <= $f_fin)
										{
											?>
											<br />
											<div class="info">
												<h2 align="center">
													<a href="info/bajas_20211.html">
														Debido a la contingencia, la FES Arag&oacute;n te brinda la opci&oacute;n de dar de baja asignatura(s) inscrita(s) en el semestre 2021-1, los d&iacute;as 8 y 9 de Diciembre 2020. Toma en consideraci&oacute;n que no habr&aacute; cursos remediales, da clic aqui para m&aacute;s informaci&oacute;n.  
													</a>
												</h2>
											</div> 
											<?php
										}   

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
														Inscripci&oacute;n de Cursos Remediales<br><br>
														Consulta tu fecha y hora de sorteo a partir del 18 de junio de 2020, AQUI
													</a>
												</h2>
											</div> 
											<?php
										}   

//SELECCION DE AREA
										$f_act = strtotime(date("d-m-Y H:i:00",time()));
										$f_ini = strtotime("01-05-2022 00:01:00");
										$f_fin = strtotime("06-05-2022 23:59:00");
							//$f_com = strtotime("21-06-2018 23:59:59");
										$f_com = '';
										if($f_act > $f_ini and $f_act <= $f_fin)
										{
											?>
											<br />
											<div class="info">
												<h2 align="center">
													<a href="almn/">
														La selecci&oacute;n de &aacute;rea del ciclo 2022-2 para las carreras de:<br>
														Comunicaci&oacute;n y Periodismo,<br>
														Econom&iacute;a,<br>
														Ing. El&eacute;ctrica Electr&oacute;nica,<br>
														Ing. Industrial,<br>
														Ing. Mec&aacute;nica<br>
														Ser&aacute; los d&iacute;as: 05 y 06 de Mayo de 2022, AQUI.
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


	//PROCESO DE REINCRIPCION
										$f_act = strtotime(date("d-m-Y H:i:00",time()));
										$f_ini = strtotime("23-07-2024 00:01:00");
										$f_fin = strtotime("12-08-2024 23:59:59");
										$f_com = '';
										if($f_act > $f_ini and $f_act <= $f_fin)
										{
											?>
											<br />
											<div class="info">
												<h3 align="center"> REINSRIPCI&Oacute;N AL SEMESTRE 2025-1 </h3>

												<h5>Realizar el pago de cuota anual y subir el comprobante a <a href="http://tramifes.aragon.unam.mx" target="_blank">http://tramifes.aragon.unam.mx</a>.

												<h5>Llena el  <a href="https://cuestionario.planeacion.unam.mx/FES_Aragon/" target="_blank">cuestionario de opini&oacute;n de servicios de la unam aqu&iacute;</a></h5>
												
												<h5> Revisa tu horario de inscripción en <a href="http://tramifes.aragon.unam.mx" target="_blank">http://tramifes.aragon.unam.mx </a> a partir del miercoles 24 de julio a las 13:00hrs.</h5>


												Indicaciones:<br /><br />
												A partir de la fecha y hora asignada para tu reinscripci&oacute;n:<br>
												<a href="http://132.247.154.41/" target="_blank">
												1.- Acceder al sistema de inscripciones AQU&Iacute; </a><br />
												2.- Iniciar sesi&oacute;n con no. de cuenta y contrase&ntilde;a e inicar inscripci&oacute;n<br />
												3.- Seleccionar asignatura y grupo.<br />
												4.- Dar clic en INSCRIBIR.<br />
												5.- Repetir los pasos 3 y 4 las veces que sean necesarias.<br />
												6.- Finalizar la inscripci&oacute;n. <br />
												7.- Imprimir y guardar el comprobante para cualquier aclaraci&oacute;n. <br />
												<p>Notas:</p>
												<p>No puedes inscribir una asigntura m&aacute;s de 2 ocasiones en ordinario.<br />
													Debes cumplir con la seriación correspondiente de tu plan de estudios (si aplica).<br />
													Consulta tu Historial Académico en <a href="https://www.dgae-siae.unam.mx/www_gate.php" target="_blank">https://www.dgae-siae.unam.mx/</a><br />
													Consulta tu plan de estudios en  <a href="https://www.dgae-siae.unam.mx/educacion/planes.php" target="_blank">https://www.dgae-siae.unam.mx/educacion/planes.php</a></p>
												</div>
												<br />

												<?php
											}


	//PROCESO DE ALTAS Y BAJAS
											$f_act = strtotime(date("d-m-Y H:i:00",time()));
											$f_ini = strtotime("27-01-2024 00:01:00");
											$f_fin = strtotime("02-02-2024 23:59:59");
											$f_com = '';
											if($f_act > $f_ini and $f_act <= $f_fin)
											{
												?>
												<br />
												<div class="info">
													<h3 align="center"> ALTAS Y BAJAS DEL SEMESTRE 2024-2 </h3>
													<h5> Revisa tu horario de altas y bajas en <a href="http://tramifes.aragon.unam.mx" target="_blank">http://tramifes.aragon.unam.mx </a> a partir del lunes 29 de enero a las 13:00hrs.</h5>

													<h5>Llena el  <a href="https://cuestionario.planeacion.unam.mx/FES_Aragon/" target="_blank">cuestionario de opini&oacute;n de servicios de la unam aqu&iacute;</a></h5>

													Indicaciones:<br /><br />
													<a href="http://132.247.154.41/" target="_blank">
													1.- Acceder al sistema de inscripciones AQU&Iacute; </a><br />
													2.- Iniciar sesi&oacute;n con no. de cuenta y contrase&ntilde;a e inicar inscripci&oacute;n<br />
													3.- Realizar los ajustes deseados a la inscripci&oacute;n.<br />
													4.- Finalizar la inscripci&oacute;n. <br />
													5.- Imprimir comprobante para cualquier aclaraci&oacute;n. <br />
													<p>Notas:</p>
													<p>No puedes inscribir una asigntura m&aacute;s de 2 ocasiones en ordinario.<br />
														Debes cumplir con la seriación correspondiente de tu plan de estudios (si aplica).<br />
														Consulta tu Historial Académico en <a href="https://www.dgae-siae.unam.mx/www_gate.php" target="_blank">https://www.dgae-siae.unam.mx/</a><br />
														Consulta tu plan de estudios en  <a href="https://www.dgae-siae.unam.mx/educacion/planes.php" target="_blank">https://www.dgae-siae.unam.mx/educacion/planes.php</a></p>
													</div>
													<br />

													<?php
												}

//PAGO DE CUOTA ANUAL
												$f_act = strtotime(date("d-m-Y H:i:00",time()));
												$f_ini = strtotime("28-06-2024 00:01:00");
												$f_fin = strtotime("16-08-2024 23:59:59");
//$f_com = strtotime("17-10-2014 23:59:59");
												$f_com = '';
												if($f_act > $f_ini and $f_act <= $f_fin)
												{
													?>
													<br />
													<div class="info">
														<h2 align="center">PAGO DE CUOTA ANUAL 2025-1 Y 2025-2</h2>

														<p>-> Los alumnos que deseen pagar en cajas de la Facultad, lo podr&aacute;n realizar:<br>
															<center>del 24 de julio al 02 de agosto de 2024 en un horario de 9:00 a 14:00 hrs y de 15:00 a 20:00 hrs.</center>
														</p>
														<br>
														<p>-> Si quieres pagar en instituci&oacute;n bancaria, los n&uacute;meros de convenio son los siguientes: </p>
												<table>
													<tr>
														<th>Banco</th>
														<th>Referencia del depósito</th>
														<th>Número del convenio</th>
														<th>Clabe interbancaria</th>
													</tr>
													<tr>
														<td>SCOTIABANK, S.A.</td>
														<td>No. de cuenta de alumno</td>
														<td>3751</td>
														<td>No disponible</td>
													</tr>
													<tr>
														<td>SANTANDER, S.A.</td>
														<td>No. de cuenta de alumno</td>
														<td>6102</td>
														<td>014180655015221193</td>
													</tr>
													<tr>
														<td>BBVA, S.A.</td>
														<td>No. de cuenta de alumno</td>
														<td>1300962</td>
														<td>012914002013009620</td>
													</tr>
												</table>
												<br>
														<p>-> A partir del 23 de julio de 2024 se deberá cargar el comprobante de manera digital en la página de TramiFES <a href="https://tramifes.aragon.unam.mx/" target="_blank">(https://tramifes.aragon.unam.mx/)</a>, en la sección: “Pago de cuota anual” .
															<!-- <li>3. Se publicará el sorteo para la reinscripción para el ciclo escolar 2023-1 el día 16 de enero a las 10:00hrs en la siguiente URL: <a href="http://aragon.dgae.unam.mx" target="_blank">http://aragon.dgae.unam.mx</a></li> -->
														</p>

														Consideraciones: <br>

														- Conserva tu comprobante de pago para cualquier aclaraci&oacute;n.<br>


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
											<span>Informaci&oacute;n de Tr&aacute;mites para Alumnos</span>
										</a>
									</p>
									<!--*********************************************************--   
									<p class="titulos-noticas-ext">
										<a href="/info/tramEgre.html">
											<span>Informaci&oacute;n de Tr&aacute;mites para Egresados</span>
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
										<a href="http://www.aragon.unam.mx/aragon/biblioteca.html">
											<img src="ima/biblio.gif" height="50" width="100" border="0" alt="Biblioteca" />Biblioteca Jesus Reyes Heroles.
										</a>
									</p>
									<!--*********************************************************--
									<p class="titulos-noticas-ext">
										<a href="http://www.unam.mx/">
											<img src="ima/unam.gif" border="0" height="30" width="100" alt="UNAM" /><span>Portal de la UNAM  </span>
										</a>
									</p>
									<!--*********************************************************--
									<p class="titulos-noticas-ext">
										<a href="http://www.pve.unam.mx/">
											<img src="ima/pve.jpg" height="50" width="100" border="0" alt="Credencial de Exalumno" />Tramita tu credencial de ex-alumno.
										</a>
									</p>
									<!--*********************************************************-->


								</div>
								<!-- InstanceEndEditable -->


								<p class="titulos-noticas-ext">
									<a href="info/tram_preguntas.php">
										<img src="imgs/projo.png" alt="img" width="100" height="70" border="0" longdesc="Preguntas frecuentes" />
										PREGUNTAS SOBRE TRAMITES ESCOLARES
									</a>
								</p>
								<p class="titulos-noticas-ext">
									<a href="info/tram_ss.php">
										<img src="imgs/SS.jpg" alt="img" width="100" height="70" border="0" longdesc="Preguntas frecuentes" />
										PREGUNTAS SOBRE EL SERVICIO SOCIAL
									</a>
								</p>
								<p class="titulos-noticas-ext">
									<a href="info/tram_titulacion.php">
										<img src="imgs/birrete2.jpg" alt="img" width="100" height="70" border="0" longdesc="Preguntas frecuentes" />
										PREGUNTAS SOBRE EL PROCESO DE TITULACION
									</a>
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
						Contacto: <b>serviciosescolares@aragon.unam.mx</b><br />
					</div>
				</div>
				<!--termina pie banners y pie derechos--> 
			</div>
			<!-- termina contenido --> 
		</div>
		<!--termina contenedor-->
	</body>
	<!-- InstanceEnd --></html>
