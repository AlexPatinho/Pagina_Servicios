<?php
include_once("../php/noCache.php");
include_once("../php/fecha.php");
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
	<title>Informaci&oacute;n sobre tr&aacute;mites para egresados</title>
	<!-- InstanceEndEditable -->

	<link type="text/css" rel="stylesheet" href="../css/estilos-internas.css" title="normal"/>
	<link type="text/css" rel="stylesheet" href="../css/nav-v.css" />
	<link type="text/css" rel="stylesheet" href="../css/estilos-generales.css" />
	<link type="text/css" rel="stylesheet" href="../css/custom-theme/jquery-ui-1.10.3.custom.min.css"  />
	<!-- InstanceBeginEditable name="Styles" -->
	<style type="text/css">
		#informacion span{
			text-transform:uppercase;
			font-weight: 600;
		}

		#informacion div.Datos ul li{
			list-style-type: disc;
		}
		.pdf {
			color: #D8000C; font-size: 18px;
		}
	</style>
	<!-- InstanceEndEditable -->

	<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.10.1.custom.js"></script>
	<script type="text/javascript" src="../js/nav-v.js"></script>
	<!-- InstanceBeginEditable name="Scripts" -->
	<script type="text/javascript">
		$(function(){
			$('#informacion').accordion({
				header: 'span', 
				heightStyle: 'content'
			});
		});
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
					<a href="http://www.unam.mx"><img src="../imgs/encabezado.png" border="0" alt="UNAM"/></a>

				</div>
				<!-- termina encabezado -->
				<!-- inicia navegacion -->
				<div class="navegacion">
					<!--inicia navegacion-inicio-->
					<div class="navegacion-inicio">
						<a href="../index.php">
							<img src="../imgs/house.gif" alt="Ir a p&aacute;gina principal" title="Ir a p&aacute;gina principal" width="16" height="16" border="0"/>
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
			<!-- inicia t&iacute;tulos im&aacute;genes  -->
			<div class="topinterna">
				<img src="../imgs/titulo-generico.jpg" alt="DGAE-ARAGON" width="980" height="61" border="0" usemap="#Map2" />
				<map name="Map2" id="Map2">
					<area shape="rect" coords="61,18,553,47" href="../index.php" alt="DGAE-ARAGON"/>
				</map>
			</div>
			<!-- termina t&iacute;tulos im&aacute;genes  -->
			<!--inicia menu-interna-->

			<!--inicia info-estudiantes-->
			<div class="info-estudiantes">
				<!--inicia info-contenido-->
				<div class="info-contenido" id="contenido">
					<!--inicia noticias-->
					<div class="noticias">
						<!--inicia contenido-central-->
						<div class="info-contenido" id="contenido-central">
							<!-- InstanceBeginEditable name="Contenido" -->

							<p class="titulos-noticas-ext">	
								<!-- <img src="../ima/projo.png" alt="projo" width="70" height="50" longdesc="Preguntas frecuentes" /> -->
							PREGUNTAS FRECUENTES ACERCA DE TRAMITES</p>

							<p>Aquí encontrarás información sobre los trámites escolares disponibles en el Departamento de Servicios Escolares.</p>

							<div id="informacion">
								<span>¿C&oacute;MO SOLICITO UNA CONSTANCIA DE CR&Eacute;DITOS O DE ESTUDIOS?</span>
								<div class="Datos">
									<ul>
										<li>&gt;&gt; <a href="https://tramifes.aragon.unam.mx">Solic&iacute;tala aqu&iacute; en el Sistema TRAMIFES &lt;&lt;. </a>
											<blockquote>
												<p>Para entrar a TRAMIFES requieres de tu cuenta@aragon.</p>
												<p>Importante: Toma en consideraci&oacute;n que, si estamos en periodo de calificación, tenemos evaluaciones que est&aacute;n siendo asentadas recientemente, por lo que podr&iacute;an no estar reflejadas a&uacute;n en el Sistema, así que tendr&iacute;as que esperar a la carga de &eacute;stas. </p>

											</blockquote>
										</li>
									</ul>
									<p></p>
								</div>
								<span>¿C&oacute;mo solicito una constancia de Historial Acad&eacute;mico?</span>
								<div class="Datos">
									<!-- <p>Debido al paro estudiantil, el tramite queda suspendido hasta que se regularicen las actividades en el plantel.</p> -->
									<p>Acude al Departamento de Servicios Escolares con una identificación. Se genera y entrega al momento.</p>
									<p>El horario de atención es de lunes a viernes de 9:30h a 13:30h y de 16:00h a 20:00h.</p>
								</div>
								<span>¿C&oacute;mo solicito una Constancia para Carta Pasante?</span>
								<div class="Datos">
									<!--p>Este tr&aacute;mite no disponible por el momento ya que dependemos de otra Instituci&oacute;n para su elaboraci&oacute;n, pregunta en  donde te la solicitan si puedes entregar otro documento.</p-->
									<p>Si quiere tramitar una constancia para carta pasante, es preciso que se presente en la Secretar&iacute;a Acad&eacute;mica con los siguientes documentos:
										<ul>
											<li>Solicitud de autorizaci&oacute;n provisional para ejercer como pasante</li>
											<ul>
												<li>Se consigue en la pagina de la Direccion General de Profesiones: <a href="https://www.gob.mx/tramites/ficha/solicitud-de-autorizacion-provisional-para-ejercer-como-pasante/SEP1239" target="_blank">https://www.gob.mx/tramites/ficha/solicitud-de-autorizacion-provisional-para-ejercer-como-pasante/SEP1239</a></li>
												<li>Llenar y firmar el documento (son dos caras) firmado por la persona solicitante y la persona profesionista responsable</li>
											</ul>
											<li>Copia de la c&eacute;dula de la persona profesionista que firma la solicitud (debe ser de la misma carrera que la persona solicitante)</li>
											<li>Historia Acad&eacute;mica de la persona solicitante</li>
											<li>Identificaci&oacute;n oficial con fotograf&iacute;a de la persona solicitante</li>
										</ul>
										Adem&aacute;s, se tienen que cumplir con los requisitos: 
										<br>    
										Para los/las estudiantes:
										<ul>
											<li>Planes de 10 semestres</li>
											<ul><li>Haber acreditado todas las asignaturas de primero a sexto semestre</li></ul>
											<li>Planes de 9 semestres</li>
											<ul><li>Haber acreditado todas las asignaturas de primero a quinto semestre</li></ul>
											<li>Planes de 8 semestres</li>
											<ul><li>Haber acreditado todas las asignaturas de primero a cuarto semestre</li></ul>
											<li>75% m&iacute;nimo de cr&eacute;ditos y estar inscrito o</li>
										</ul>
										Para los/las egresados/as:
										<ul>
											<li>Ser egresado de no m&aacute;s de 1 a&ntilde;o</li>
										</ul>
										Para entregar los documentos, gestionar una cita a la Secretar&iacute;a Acad&eacute;mica a trav&eacute;s del correo estudiantes.secretariaacademica@aragon.unam.mx 
									</p>
								</div>

								<span>informaci&oacute;n referente al Certificado de Estudios</span>
								<div class="Datos">
									<!--p>Este tr&aacute;mite no est&aacute; disponible por el momento.</p>
									<p>Si solicitaste tu certificado antes de la contingencia, podemos enviartelo en formato pdf, 
										posteriormente podr&aacute;s recoger el original cuando las condiciones mejoren y la escuela abra sus puertas. &gt;&gt; <a href="https://forms.gle/bpHVjYsbPdz14d4t5" target="_blank">Solic&iacute;talo aqu&iacute; en este enlace&lt;&lt;</a>, tendr&aacute;s que ingresar tu comprobante de solicitud del certificado y tener una cuenta de google. </p-->

										<!-- <p>El <b>Certificado de Estudios</b> es un documento oficial que emite la Facultad de Estudios Superiores Arag&oacute;n en el que se describen las materias, calificaciones y periodos en los que se inscribieron las materias de la Licenciatura.</p>
										<p><b>Costo</b>: Para el primer Certificado es aportaci&oacute;n voluntaria (por el momento no aplica), a partir del segundo tiene un costo de 100 pesos y la referencia bancaria se descarga desde <a href="https://sigerel.dgae.unam.mx" target="_blank">SIGEREL en https://sigerel.dgae.unam.mx</a></p>
										<p><b>Tiempo estimado para el tr&aacute;mite</b>: 25 d&iacute;as h&aacute;biles</p>
										<p>
											<b>Requisitos:</b>
											<ul>
												<li>Historia Acad&eacute;mica (con datos de contacto en la primera hoja)</li>
												<li>Fotograf&iacute;as tama&ntilde;o ovalo credencial, ovaladas (3.5 x 5 cm), recientes, (cumpliendo los requisitos especificados por la DGAE en el URL: <a href='https://www.dgae.unam.mx/tramites/fotos.html' target:'_blank'> https://www.dgae.unam.mx/tramites/fotos.html </a> )</li>
												<li>Comprobante de pago, en caso de haber solicitado un Certificado de Estudios anteriormente</li>
											</ul>
										</p> -->

										<p>
											<a href="tram_certificado.html">Revisa los requisitos dando clic aqu&iacute;.</a>
										</p>

									</div>
									<span>ALTA O BAJA DE MI SEGURO (imss) </span>
									<div class="Datos">
										<ul>
											<li>Realiza tu solicitud  <a href="https://forms.gle/jLo3BU5mXL2FwZMp6" target="_blank">&gt;&gt;  aqu&iacute; en este enlace &gt;&gt; </a>,  por favor tener tu comprobante de inscripci&oacute;n, tu Constancia de Vigencia de Derechos <a href="https://forms.gle/jLo3BU5mXL2FwZMp6" target="_blank">(Puedes consultar tu constancia dando click aquí)</a> y una identificaci&oacute;n. </li>
										</ul>
										<p>&nbsp;</p>
									</div>
									<span>¿c&oacute;mo  recupero mi nip de la plataforma www.dgae-siae.unam.mx?</span>
									<div class="Datos">
										<p>Intenta recuperarla directamente en la misma plataforma, si por alguna raz&oacute;n no la obtienes, entonces acude al Departamento de Servicios Escolares con una identificación con fotografía, ubicado en el CISE en la planta baja del Edificio A1 en un horario de lunes a viernes de 9:30h a 13:30h y de 16:00h a 20:00h</p>
									</div>
									<!-- <span>¿c&oacute;mo  recupero mi CONTRASE&Ntilde;A de la plataforma http://aragon.dgae.unam.mx?</span>
									<div class="Datos">
										<p>Intenta recuperarla directamente en la misma plataforma, si por alguna raz&oacute;n no la obtienes, entonces escribe un correo a serviciosescolares@aragon.unam.mx con las siguientes caracter&iacute;sticas:</p>
										<p>1.  En el ASUNTO del correo escribe RECUPERACION CONTRASE&Ntilde;A ESCOLARES</p>
										<p>2.  Anexa tu n&uacute;mero de cuenta, nombre completo,  fecha de nacimiento, plantel, y carrera.</p>
										<p>3.Incluye: </p>
										<blockquote>
											<p>a) Una identificaci&oacute;n oficial vigente con firma, escaneada por ambos lados </p>
											<p>b) Tu solicitud de cambio de contrase&ntilde;a (Un breve texto con tu petici&oacute;n) y firma tu solicitud, la firma debe coincidir con la de tu identificaci&oacute;n. Anexa  la pantalla donde no puedes ingresar con el mensaje que te muestre el sistema.</p>
										</blockquote>
										<p>&nbsp;</p>
									</div> -->
									<span>¿c&oacute;mo  recupero mi CONTRASE&Ntilde;A del correo institucional @aragon?</span>
									<div class="Datos">
										<p>La contrase&ntilde;a de la cuenta de correo institucional @aragon.unam.mx se recupera desde la página de Plataforma Educativa Arag&oacute;n. <a href="https://plataformaeducativa.aragon.unam.mx/contrasenia/" target="blank">Da click aqu&iacute; en este enlace</a> y sigue las instrucciones que se indican. </p>
										<p>
											Revisa la <a href="Recuperación contraseña del Correo Aragón.pdf" target="_blank">Guía para la Recuperación de la contraseña del Correo Aragón dando click aquí</a>
										</p>
									</div>

									<span>¿d&oacute;nde me informo sobre segunda carrera, carrera simult&aacute;nea, cambio de sistema, cambio interno de carrera, cambio plantel reingreso? </span>
									<div class="Datos">
										<p><a href="https://www.dgae-siae.unam.mx/actividades/tramites/" target="blank">Da click aqu&iacute; en este enlace  </a>encontrar&aacute;s las fechas, requisitos y una gu&iacute;a de las especificaciones en general de la UNAM.</p>
										<p>&nbsp;</p>
									</div>                                


									<p>¡Importante! Es responsabilidad del alumno proporcionar y verificar que su informaci&oacute;n  sea completa y ver&iacute;dica para realizar sus tr&aacute;mites. </p>
								</div>
								<!-- InstanceEndEditable -->                            </div>
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
							previo por escrito de la instituci&oacute;n.Cr&eacute;ditos
						</div>
						<div class="administrado">
							Sitio web administrado por: <b>Departamento de Servicios Escolares Arag&oacute;n</b><br />                          
						</div>
					</div>
					<!--termina pie banners y pie derechos--> 
				</div>
				<!-- termina contenido --> 
			</div>
			<!--termina contenedor-->
		</body>
		<!-- InstanceEnd --></html>
