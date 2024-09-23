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
    	<!-- inicia contenedor que centra la página -->
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
                </div>-->
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
                </div>-->
            <!--termina navegacion-buscador-->
        </div>  
        <!-- termina navegacion -->
        <!-- inicia contenido -->
        <div class="contenido">
        	<!-- inicia títulos imágenes  -->
        	<div class="topinterna">
        		<img src="../imgs/titulo-generico.jpg" alt="DGAE-ARAGON" width="980" height="61" border="0" usemap="#Map2" />
        		<map name="Map2" id="Map2">
        			<area shape="rect" coords="61,18,553,47" href="../index.php" alt="DGAE-ARAGON"/>
        		</map>
        	</div>
        	<!-- termina títulos imágenes  -->
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
        					<p class="titulos-noticas-ext">	<img src="../imgs/birrete2.jpg" alt="__" width="70" height="50" longdesc="Preguntas frecuentes" /> TRÁMITES DE TITULACIÓN</p>
        					<p>
        						<span>En esta página te ofrecemos la información que requieres para avanzar en tu proceso de titulación. </span>
        					</p>
        					<p>
        						Todos los trámites implican tiempo de elaboración y revisión, por lo que no son automáticos. Por otro lado, cada expediente  tiene que ser revisado para verificar que contenga todos los documentos que marcan los   lineamientos de Titulación de la UNAM.
        					</p>
        					<p> 
        						Es responsabilidad del alumno proporcionar la información completa y verídica que se solicita para que cada trámite se expida lo más pronto posible.
        					</p>

        					<div id="informacion">
        						<span>Identifica qué modalidad de titulación elegirás</span>
        						<div class="Datos">
        							<p>
        								Lee detalladamente la siguiente información e identifica la modalidad de titulación que prefieras para que puedas avanzar en tu proceso de Titulación, si aún te surge alguna duda escribe al correo de Titulación que le corresponda a tu Jefatura. 
        							</p>
											<p>Las modalidades de titulación disponibles dependerán de la carrera a la que pertenezcas</p>
        							<p align="center"><img src="../imgs/correos.png" alt="Correos"  longdesc="Correos titulacion" /></p>
											
        						</div>
        						<span>
        							Modalidad 1: <strong> </strong> <strong>TITULACIÓN POR TRABAJO ESCRITO CON RÉPLICA ORAL</strong>
        						</span>
        						<div class="Datos">											
        							<p><strong>Lista de opciones para la modalidad 1</strong></p>
        							<!-- <blockquote>
        								<p> Recopila y escanea los documentos para iniciar tu opción de Titulación. </p>
        							</blockquote> -->
        							<ul>
        								<li>Tesis o tesina y examen profesional</li>
        								<li>Actividad de investigación en su alternativa de tesis o tesina</li>
        								<li>Seminario de tesis o tesina</li>
        							</ul>
											<p>Para realizar tu registro, consulta la guía para la conformación del expediente de titulación</p>

        							<!-- <blockquote>
        								<p>
        									Tus documentos deben estar escaneados en el orden solicitado  en<strong> un sólo archivo </strong>  con formato PDF, con  tamaño máximo de 10 MB,<strong> NO</strong> se aceptarán documentos en archivos sueltos, ilegibles o en orden diferente al requerido. Es importante que todos los documentos originales los guardes, ya que en su momento te serán requeridos.<br />
        								</p>
        							</blockquote>
        							<p><strong>2 . Registrar opción  de Titulación. </strong></p>
        							<blockquote>
        								<p>
        									Envía  al correo de Titulación de tu Jefatura de Carrera un email  con el ASUNTO: INICIO OPCIÓN TITULACIÓN anexando el archivo con la documentación inicial que preparaste anteriormente, tu nombre, número de cuenta, y teléfono. <br />
        									<br />
        									&gt;&gt;&gt; La Jefatura te  proporcionará el <em>formato de Registro de la opción de Titulación,</em> el  <em>formato de conclusión de trabajo escrito</em> y te dará indicaciones.<br />
        								</p>
        								<p>
        									****No tienes que solicitar Revisión de Estudios. Si se requiere algún documento (actas de  nacimiento o certificados de estudio), el área correspondiente te notificará para entregar  dicho documento.  
        								</p>
        							</blockquote>
        							<p><strong>3. Realizar trabajo escrito.</strong></p>
        							<blockquote>
        								<p>                                            a) Al terminar tu trabajo escrito,llena el <em>formato de conclusión de trabajo escrito </em>y pide a  tu asesor que lo firme. <br />
        									b) Envía el <em>formato de conclusión de trabajo escrito </em>  al correo de Titulación de tu Jefatura de Carrera con el Asunto: CONCLUSION DE TRABAJO ESCRITO <br />
        								</p>
        								<p>&gt;&gt;&gt; Tu Jefatura  te devolverá la Asignación de jurado, el formato de votos aprobatorios y los  correos de contacto de tus sínodos.</p>
        							</blockquote>
        							<p><strong>4. Recabar Votos aprobatorios</strong>. </p>
        							<blockquote>
        								<p>a) Envía tu  trabajo escrito a cada uno de tus sínodos y anexa el<em> formato de votos  aprobatorios.</em> <br />&gt;&gt;&gt;Cada Sínodo te  dará sus observaciones del trabajo o su Voto Aprobatorio, el cual firmará en el<em> formato de votos  aprobatorios. </em><br />
        									<br />
        									b) Envía el  <em>formato de Votos Aprobatorios</em> con la firma de cada uno de los sínodos (son cinco sinodos) a tu  Jefatura de Carrera para su Visto Bueno. </p>
        								</blockquote>

        								<p><strong>5. Reunir y escaneardocumentación complementaria.</strong>                                        </p>
        								<blockquote>
        									<p>Encontrarás cómo realizar cada trámite en PREGUNTAS FRECUENTES DE TITULACIÓN </p>
        									<ol>
        										<li>1) Pago de  solicitud de Título.<br />
        											2) Autorización  de Transferencia de información<br />
        											3) CURP (ya no se solicita)<br />
        										4) Fotografías de  acuerdo al título elegido</li>
        										<li>5) Formato de no  adeudo de biblioteca <br />
        											6)Cuestionario de Egresado <br />
        										</li>
        									</ol>
        									<p>Tus documentos deben estar escaneados en el orden solicitado  en<strong> un sólo archivo</strong> con formato PDF, con  tamaño máximo de 10 MB,<strong> NO</strong> se aceptarán documentos en archivos sueltos, ilegibles o en orden diferente al requerido. Es importante que todos los documentos originales los guardes, ya que en su momento te serán requeridos.<br />
        									</p>
        								</blockquote>
        								<p><strong>6. Programar fecha de examen profesional.</strong></p>

        								<blockquote>
        									<p>Envía  al correo de Titulación de tu Jefatura de Carrera un email  con ASUNTO: PROGRAMAR EXAMEN  PROFESIONAL, anexando:  documentación complementaria  y Votos aprobatorios firmados.</p>
        									<p>&gt;&gt;&gt; Después de la revisión de tus documentos originales físicos por parte de Servicios Escolares, tu Jefatura te informará  la fecha y hora de programación. </p>
        								</blockquote>
        								<p><strong>7. Realizar examen profesional</strong>.</p>
        								<blockquote>
        									<p>Préparate para estar en tiempo y forma en tu ¡examen profesional! </p>
        								</blockquote>
        								<p><strong>8. Recibir Título y tramitar Cédula</strong>.</p>
        								<ol>
        									<li> a) Da seguimiento a tu título, revisando en  preguntas frecuentes el procedimiento. </li>
        									<li>b) Una vez que DGAE te notifique a través de la página sobre el proceso de emisión de tu título<a href="https://www.gob.mx/tramites/ficha/expedicion-de-cedula-profesional-electronica/SEP6534"> trámita tu cédula.</a> </li>
        								</ol> -->
        							</div>
        							<span>MODALIDAD 2: TITULACIÓN POR TRABAJO ESCRITO SIN RÉPLICA ORAL</span>
        							<div class="Datos">

        								<div class="Datos">

        									<p><strong>Lista de opciones para la modalidad 2</strong>.</p>
													<ul>
        										<li>Apoyo a la docencia</li>
        										<li>Trabajo profesional</li>
        										<li>Servicio social</li>
        										<li>Actividad de investigación (Articulo académico)</li>
        										<li>Servicio social</li>
        									</ul>
												<p>Para realizar tu registro, consulta la guía para la conformación del expediente de titulación</p>

        									<!-- <blockquote>
        										<ol>
        											<ol>
        												<li>                                                    1. Constancia  de créditos </li>
        												<li>2. Historia académica </li>
        												<li>3. Carta de término(ya no se solicita) </li>
        												<li>4. Liberación del servicio  social </li>
        												<li>5. Constancia de idioma y Cómputo (sólo si lo requiere tu  Plan de Estudios). </li>
        											</ol>
        										</ol>
        										<p>Tus documentos deben estar escaneados en el orden solicitado  en<strong> un sólo archivo</strong> con formato PDF, con  tamaño máximo de 10 MB,<strong> NO</strong> se aceptarán documentos en archivos sueltos, ilegibles o en orden diferente al requerido. Es importante que todos los documentos originales los guardes, ya que en su momento te serán requeridos.<br />
        										</p>
        									</blockquote>
        									<p><strong>2 . Registrar  opción  de Titulación. </strong></p>
        									<blockquote>
        										<p>a)  Envía  al correo de Titulación de tu Jefatura de Carrera un email  con el ASUNTO: INICIO OPCIÓN TITULACIÓN DIPLOMADO, 
        											anexando el archivo con la documentación inicial que preparaste anteriormente.<br />
        										&gt;&gt;&gt; La Jefatura te  proporcionará el formato de Registro de la opción de Titulación, para que te den el visto bueno y te puedas inscribir al Diplomado. </p>
        										<p>&gt;&gt;Revisión de Estudios.  Esta se llevará a cabo durante la realización del Diplomado, la solicita tu Jefatura de Carrera, NO tienes que pedirla.</p>
        									</blockquote>
        									<p><br />
        										<strong>3. Cursa el Diplomado. </strong></p>
        										<blockquote>
        											<p>Cursa el Diplomado cumpliendo los requisitos de aprobación por la Opción de Titulación. </p>
        										</blockquote> -->
														<!--p><strong>4. Obtener Oficio de Registro. </strong></p>
														<blockquote>
															<p> &gt;&gt; Una vez que Educación Continua o el Centro Los Galeana informen a la Secretaría Académica que has terminado tu Diplomado y  tu revisión de estudios esté autorizada, ésta te enviará por correo el Oficio de Autorización de tu Registro.</p>
													</blockquote-->
													<!-- <p><strong> </strong> <br />
														<strong>4. Reunir y escanear la documentación complementaria</strong> </p>
														<blockquote>
															<p>Encontrarás cómo realizar cada trámite en PREGUNTAS FRECUENTES DE TITULACIÓN</p>
															<p>1) Pago de  solicitud de Título.<br />
																2) Autorización  de Transferencia de información<br />
																3) CURP(ya no se solicita)<br />
																4) Fotografías de  acuerdo al título elegido<br />
																5) Formato de no  adeudo de biblioteca <br />
																6)Cuestionario de Egresado <br />
															</p>
															<p>Tus documentos deben estar escaneados en el orden solicitado  en<strong> un sólo archivo</strong> con formato PDF, con  tamaño máximo de 10 MB,<strong> NO</strong> se aceptarán documentos en archivos sueltos, ilegibles o en orden diferente al requerido. Es importante que todos los documentos originales los guardes, ya que en su momento te serán requeridos.<br />
															</p>
														</blockquote>
														<p><strong>5. Programar fecha de Toma de protesta </strong></p>
														<blockquote>
															<p>Envía al correo de titulación de tu Jefatura un email con el ASUNTO: SOLICITUD FECHA DE PROTESTA, anexando:   la documentación  complementaria</p>
															<p>&gt;&gt;&gt; Después de la revisión de tu documentación por Servicios Escolares, tu Jefatura te informará  la fecha y hora de programación de la Toma de protesta.</p>
														</blockquote>
														<p><strong>6. Realizar toma de protesta. </strong></p>
														<blockquote>
															<p> Préparate para estar en tiempo y forma en tu ¡Toma de protestal! </p>
														</blockquote>
														<p><strong>7. Recibir Titulo y tramitar Cédula</strong>.</p>
														<ol>
															<li>a) Da seguimiento a tu título, revisando en  preguntas frecuentes el procedimiento. </li>
															<li>b) Una vez que DGAE te notifique a través de la página sobre el proceso de emisión de tu título<a href="https://www.gob.mx/tramites/ficha/expedicion-de-cedula-profesional-electronica/SEP6534"> trámita tu cédula</a>.</li>
														</ol> -->
													</div>                                       
											</div>

											<span>MODALIDAD 3: TITULACIÓN SIN TRABAJO ESCRITO</span>
											<div class="Datos">
												<p><strong>Lista de opciones para la modalidad 2</strong></p>
												<ul>
        										<li>Examen general de conocimientos externo</li>
        										<li>Totalidad de créditos y alto nivel académico</li>
        										<li>Estudios en posgrado</li>
        										<li>Ampliación y profundización de conocimientos</li>
        										<li>Cursos o diplomados de educación contínua</li>
        									</ul>
												<p>Para realizar tu registro, consulta la guía para la conformación del expediente de titulación</p>
												<!-- <blockquote>
													<p>Recopila y escanea los documentos para iniciar tu opción de Titulación.</p>
													<ol>
														<li>                                                1. Constancia  de créditos </li>
														<li>2. Historia académica </li>
														<li>3. Carta de término(ya no se solicita) </li>
														<li>4. Liberación del servicio  social </li>
														<li>5. Constancia de idioma y Cómputo (sólo si lo requiere tu  Plan de Estudios). </li>
													</ol>
													<p>Tus documentos deben estar escaneados en el orden solicitado  en<strong> un sólo archivo</strong> con formato PDF, con  tamaño máximo de 10 MB,<strong> NO</strong> se aceptarán documentos en archivos sueltos, ilegibles o en orden diferente al requerido. Es importante que todos los documentos originales los guardes, ya que en su momento te serán requeridos.<br />
													</p>
												</blockquote>
												<p><strong>2. Cursa tu Diplomado </strong></p>
												<p> Cursa el Diplomado cumpliendo los requsitos de aprobación por la Opción de Titulación, cuando lo hayas terminado envía a tu Jefatura tu Diploma y el oficio de tus calificaciones. </p>
												<p><br />
													<strong> 3. Registro de la opción de titulación </strong></p>
													<blockquote>
														<p>&gt;&gt;&gt; Tu  Jefatura de Carrera te proporcionará la solicitud de registro y enviará tu información a  Secretaría Académica. </p>
												<p>&gt;&gt;&gt;Una vez que Jefatura de Carrera le envía tu documentación y previa Revisión de Estudios de tus documentos, Secretaría  Académica te enviará un correo con tu <em>Oficio de Registro</em>.</p>
													<p>&gt;&gt; Ya generado tu Oficio de registro,  Secretaría Académica solicitará tu Revisión de Estudios.  </p
													<p>**No tienes que solicitar Revisión de Estudios. Si se requiere algún documento (actas de  nacimiento o certificados de estudio), el área te notificará para entregar  dicho documento. </p>
												</blockquote>
												<p><strong>4. Reunir y escanear la documentación complementaria</strong> </p>
												<blockquote>
													<p>Encontrarás cómo realizar cada trámite en PREGUNTAS FRECUENTES DE TITULACIÓN </p>
													<blockquote>
														<p>                                        1) Pago de  solicitud de Título.<br />
															2) Autorización  de Transferencia de información<br />
															3) CURP(ya no se solicita)<br />
															4) Fotografías de  acuerdo al título elegido<br />
															5) Formato de no  adeudo de biblioteca <br />
															6)Cuestionario de Egresado <br />
														7) Diploma y Oficio de calificaciones</p>
													</blockquote>
													<p>Tus documentos deben estar escaneados en el orden solicitado  en<strong> un sólo archivo</strong> con formato PDF, con  tamaño máximo de 10 MB,<strong> NO</strong> se aceptarán documentos en archivos sueltos, ilegibles o en orden diferente al requerido. Es importante que todos los documentos originales los guardes, ya que en su momento te serán requeridos.<br />
													</p>
												</blockquote>
												<p><strong>5. Programar fecha de Toma de protesta </strong></p>
												<blockquote>
													<p>    Envía  al correo de Titulación de tu Jefatura de Carrera un email  con el ASUNTO: SOLICITUD FECHA DE PROTESTA, anexando los 2 archivos que preparaste previamente y que contienen la documentación inicial, y la complementaria</p>
													<p>&gt;&gt;&gt; Después de la revisión de tu documentación por Servicios Escolares, tu Jefatura de Carrera te informará  la fecha y hora de programación de la Toma de protesta.</p>
												</blockquote>
												<p><strong>6. Realizar toma de protesta. </strong></p>
												<blockquote>
													<p align="left"> a) Préparate para estar en tiempo y forma en tu ¡Toma de protestal! </p>
												</blockquote>
												<p><strong>7. Recibir Titulo y tramitar Cédula</strong></p>
												<ol>
													<li>a) Da seguimiento a tu título, revisando en  preguntas frecuentes el procedimiento. </li>
													<li>b) Una vez que DGAE te notifique a través de la página sobre el proceso de emisión de tu título<a href="https://www.gob.mx/tramites/ficha/expedicion-de-cedula-profesional-electronica/SEP6534"> trámita tu cédula</a>.</li>
												</ol> -->
											</div>

											<!-- <span>Situación 4. Opciones de titulación sin réplica oral ni  trabajo escrito (como por ejemplo, Estudios de posgrado, alto nivel académico, créditos adicionales, examen general de conocimientos, etc.) </span>									 

											<div class="Datos">
												<p><strong>1. Preparar documentación inicial</strong>.</p>
												<blockquote>Recopila y escanea los documentos para iniciar tu opción de Titulación.
													<ol>
														<li><br />
														1. Constancia  de créditos </li>
														<li>2. Historia académica</li>
														<li>3. Carta de término(ya no se solicita) </li>
														<li>4. Liberación del servicio  social </li>
														<li>5. Constancia de idioma y Cómputo (sólo si lo requiere tu  Plan de Estudios). </li>
													</ol>
													<p>                                        Adicional a la documentación inicial debes incluir el  documento que corresponda, según tu Opción de Titulación:</p>
													<ul>
														<ul>
															<li><strong>Examen general  de conocimientos. En el caso de Ingenierías</strong> se requiere constancia de CENEVAL previa  validación en Sria. Académica</li>
															<li><strong>Estudios de posgrado, especialidad o  maestrías. O</strong>ficio de aceptación y constancia de calificaciones. </li>
															<li><strong>Asignaturas adicionales. </strong>Constancia de  acreditación de todas las asignaturas adicionales con promedio mínimo de 9.</li>
															<li><strong>Totalidad  de créditos y alto nivel académico. </strong>Promedio mínimo de 9.5 con tu  Constancia de Historia Académica. </li>
														</ul>
													</ul>
													<p>Tus documentos deben estar escaneados en el orden solicitado  en<strong> un sólo archivo</strong> con formato PDF, con  tamaño máximo de 10 MB,<strong> NO</strong> se aceptarán documentos en archivos sueltos, ilegibles o en orden diferente al requerido. Es importante que todos los documentos originales los guardes, ya que en su momento te serán requeridos.<br />
													</p>
												</blockquote>
												<p><strong>2. Registrar mi opción de Titulación. </strong></p>
												<blockquote>
													<p>Envía  al correo de Titulación de tu Jefatura de Carrera un email  con el ASUNTO: SOLICITUD FECHA DE PROTESTA, con el ASUNTO: INICIO OPCIÓN TITULACIÓN (El nombre de tu Opción), anexando el archivo con la  documentación inicial que preparaste anteriormente.</p>
													<p>&gt;&gt;&gt; La Jefatura de Carrera te proporcionará el formato de Registro  de la opción de Titulación y te dará indicaciones.</p>
													<p>&gt;&gt;&gt;Una vez que Jefatura de Carrera le envía tu documentación y  previa Revisión de Estudios de tus documentos, Secretaría Académica te enviará  un correo con tu Oficio de Registro.</p
													<p>**No tienes que solicitar Revisión de Estudios. Si se requiere algún documento (actas de  nacimiento o certificados de estudio), el área te notificará para entregar  dicho documento. </p>
												</blockquote>
												<p><strong>3. Reunir y escanear la documentación complementaria. </strong></p>
												<blockquote>
													<p>Encontrarás cómo realizar cada trámite en PREGUNTAS FRECUENTES DE TITULACIÓN </p>
													<blockquote>
														<p>1) Pago de  solicitud de Título.<br />
															2) Autorización  de Transferencia de información<br />
															3) CURP(ya no se solicita)<br />
															4) Fotografías de  acuerdo al título elegido<br />
															5) Formato de no  adeudo de biblioteca <br />
														6)Cuestionario de Egresado </p>
													</blockquote>
													<p>Tus documentos deben estar escaneados en el orden solicitado  en<strong> un sólo archivo</strong> con formato PDF, con  tamaño máximo de 10 MB,<strong> NO</strong> se aceptarán documentos en archivos sueltos, ilegibles o en orden diferente al requerido. Es importante que todos los documentos originales los guardes, ya que en su momento te serán requeridos.<br />
													</p>
												</blockquote>
												<p><strong>4. Programar fecha de Toma de protesta </strong><strong>o exámen en el caso de Derecho</strong>.</p>
												<blockquote>
													<p>Envía  al correo de Titulación de tu Jefatura de Carrera un email  con el ASUNTO: SOLICITUD FECHA DE PROTESTA, anexando los 2 archivos que preparaste previamente y que contienen la documentación inicial, y la complementaria.</p>
													<p><br />
													&gt;&gt;&gt; Después de la verificación de tu documentación  por Servicios Escolares, tu Jefatura de Carrera te informará fecha, día y hora  de la Toma de protesta. </p>
													<p><strong>Para el Examen general  de conocimientos. En el caso de Derecho </strong>en cuanto se tenga la revisión de estudios autorizada<strong>, </strong>Jefatura de Carrera programará el exámen. </p>
												</blockquote>
												<p><strong>5. Realizar toma de protesta o exámen en el caso de Derecho. </strong></p>
												<blockquote>
													<p>Prepárate para estar en tiempo y forma en tu ¡Toma de protesta! </p>
												</blockquote>
												<p><strong>6. Recibir Titulo y tramitar Cédula</strong></p>
												<ol>
													<li>a) Da seguimiento a tu título, revisando en  preguntas frecuentes el procedimiento. </li>
													<li>b) Una vez que DGAE te notifique a través de la página sobre el proceso de emisión de tu título<a href="https://www.gob.mx/tramites/ficha/expedicion-de-cedula-profesional-electronica/SEP6534"> trámita tu cédula</a>.</li>
												</ol>

											</div> -->

											<DIV> <blockquote>
												<div class="titulos-noticas-ext">PREGUNTAS FRECUENTES DE TITULACIÓN  </div>
											</blockquote></DIV>
											<span>Guía para la entrega de documentos en Servicios Escolares</span>
											<div class="Datos">
												<p>En la siguiente guía puedes conocer el procedimiento de titulación y los documentos que debes llevar, así como dónde los puedes obtener. 
													<p><a href="Expediente de titulacion_v8.pdf" target="_blank">  Guía para la entrega de documentos en Servicios Escolares</a></p>
													
												</div>

									<span>Si cursé y aprobé optativas de más y superé el 100% de créditos optativos ¿cuáles se toman en cuenta para el cálculo del promedio final?</span>
                                  	<div class="Datos">

                                  		<p>Cuando se cursan y aprueban optativas en exceso, se ajustan lo más próximo al 100 por ciento de créditos mínimos. Para ello, se toman las primeras optativas aprobadas en orden cronológico hasta completar el mínimo de créditos optativos y son esas las que se consideran para el cálculo del promedio. El resto se marcan como no requeridas y se omiten en el cálculo.<br>
Para saber cuáles son las primeras aprobadas, se ordenan por semestre lectivo. Si son del mismo semestre lectivo, entonces se ordenan por periodo (Ext. 1ra vuelta , Ordinario y Ext. 2da vuelta. Si son del mismo semestre lectivo y periodo, entonces se toman las de más alta calificación.</p>


                                  	</div>

                                  	<span>¿Dónde pago mi titulo?</span>
                                  	<div class="Datos">

                                  		<p>Solicita tu referencia bancaria y sigue los pasos proporcionados <a href="https://sigerel.dgae.unam.mx/alumnos/login">aquí en este enlace </a></p>


                                  	</div>
                                  	<span>FORMATOS SOLICITADOS PARA EL EXPEDIENTE DE TITULACIÓN</span>                                 
                                  	<div class="Datos">

                                  		<p>a) <a target="_blank" href="Formato acuerdo de confidencialidad.pdf">Formato de confidencialidad, toma en consideración  que la fecha no se debe llenar,  ésta se escribe hasta la toma de protesta. </a></p>
                                  		<p>b) <a target="_blank" href="Formato de solicitud de aula virtual.pdf">Formato de solicitud de aula virtual, toma en consideración  que la fecha no se debe llenar,  ésta se escribe hasta la toma de protesta. </a></p>
                                  		<p>c) <a target="_blank" href="Formato de medidas de prevención sanitaria.pdf">Formato de medidas de prevención sanitaria, toma en consideración  que la fecha no se debe llenar,  ésta se escribe hasta la toma de protesta. </a></p>
                                  		<p>d) <a target="_blank" href="https://siicana.dgb.unam.mx/">Formato de no adeudo de la biblioteca </a> </p>
                                  		<p>e) <a target="_blank" href="https://www.dgae.unam.mx/titulosgrados/registro_titulo_grado_cedula.html">Formato de transferencia de información </a></p>
                                  		<p>f) <a target="_blank" href="Formato solicitud de titulo.pdf">Formato de solicitud de título</a></p>
                                  		<p>g) <a target="_blank" href="https://cuestionario.planeacion.unam.mx/egresados/">Cuestionario de egresados</a></p>
                                  		<p>h) <a target="_blank" href="http://aragon.dgae.unam.mx/info/protesta_universitaria.html">Protesta Universitaria</a></p>
                                  		
                                  	</div>

                                  	<span>¿CÓMO va la emisión deL título en dirección general administración escolar DGAE?</span>
                                  	<div class="Datos">
                                  		<p>1. Ingresa a la liga -&gt;&gt;&gt; <a href="https://ingreso.dgae.unam.mx:8020/consulta_avance_sl">PROCESO DE EMISIÓN DE TITULO</a> </p>
                                  		<p>2. Elige la opción que te corresponda &quot;Alumnos UNAM&quot; o &quot;Alumnos Sistema Incorporado&quot; </p>
                                  		<p>3. Verifica el final del renglón 15 de Datos del alumno, aparecerá si ya ha sido emitido tu título y cuándo puedes ir por él</p>
                                  		<p>Los títulos serán entregados en el Departamento de Tramitel, de la Dirección  General de Administración Escolar, para lo anterior deberás solicitar una cita en este mismo apartado.
                                  			
																		</div>


																		<span>¿CÓMO DEBEN SER LAS FOTOGRAFÍAS PARA MI TÍTULO?</span>
																		<div class="Datos">
																			<p>A) Para el TÍTULO O GRADO EN PERGAMINO PIEL DE CABRA con medidas de 28 x 40.5 cm:
																			</p>
																			<p>6 fotografías tamaño Título</p>
																			<ul type="disc">
																				<li>Recientes</li>
																				<li>Ovaladas (6 x 9cm)</li>
																				<li>En Blanco y Negro, con fondo gris claro sin retoque, impresas en papel mate revelado tradicional, debidamente recortadas.</li>
																				<li>De frente, rostro serio, el tamaño de la cara deberá medir 3.5 x 5 cm. a fin de que esté en proporción con la medida de la fotografía.</li>
																				<li>No deben ser tomadas de otras fotografías.</li>
																			</ul>
																			<p>B) Para el TÍTULO O GRADO EN CARTULINA IMITACIÓN PERGAMINO con medidas de seguridad de 28 x 40.5 cm:</p>
																			<p>6 fotografías tamaño Título</p>
																			<ul type="disc">
																				<li>Recientes</li>
																				<li>Ovaladas (6 x 9cm)</li>
																				<li>En Blanco y Negro, con fondo gris claro sin retoque, impresas en papel mate (no digitales), debidamente recortadas.</li>
																				<li>De frente, rostro serio, el tamaño de la cara deberá medir 3.5 x 5 cm. a fin de que esté en proporción con la medida de la fotografía.</li>
																				<li>No deben ser tomadas de otras fotografías.</li>
																			</ul>
																			<p>C) Para el DIPLOMA, TÍTULO O GRADO EN PAPEL SEGURIDAD de 21.5 x 28 cm (tamaño carta)
																			</p>
																			<p>6 fotografías tamaño Título</p>
																			<ul type="disc">
																				<li>Recientes</li>
																				<li>Ovaladas (5 x 7cm)</li>
																				<li>En Blanco y Negro, con fondo gris claro sin retoque, impresas en papel mate (no digitales), debidamente recortadas.</li>
																				<li>De frente, rostro serio, el tamaño de la cara deberá ser en proporción con la medida de la fotografía.</li>
																				<li>No deben ser tomadas de otras fotografías.</li>
																			</ul>
																			<p>CONSIDERACIONES IMPORTANTES</p>
																			<ol>
																				<li>MUJERES: Vestimenta formal, sin escote, maquillaje muy discreto, frente y orejas descubiertas, aretes pequeños, sin lentes obscuros o pupilentes de color.</li>
																				<li>HOMBRES: Saco y corbata, sin cabello largo, frente y orejas descubiertas, barba y/o bigote recortados (deben verse los labios), sin lentes obscuros o pupilentes de color.</li>
																				<li>Anotar únicamente con lápiz su nombre completo al reverso de cada fotografía, hágalo suavemente (no recargue la punta) para evitar marcarlas;</li>
																				<li>Para todos los casos, las fotografías deben ser con vestimenta formal, frente y orejas descubiertas, sin lentes obscuros o pupilentes de color; en su caso barba y/o bigote recortados (deben verse los labios); y</li>
																				<li>No se aceptarán fotografías que no cubran íntegramente estas características, por favor comuníquelas a su fotógrafo, antes de contratar el servicio.</li>
																			</ol>

																		</div>
																																				
																		<span>¿DÓNDE CONTESTO EL CUESTIONARIO DE EGRESADOS? </span>                                 
																		<div class="Datos">
																			<p>
																				1. Ingresa  a  <a href="https://cuestionario.planeacion.unam.mx/egresados/">cuestionario para egresados</a>
																				<p>2. Contesta el cuestionario y al final de éste, obtendrás tu registro.                          
																				<p>3. Guarda el documento original para cuando te sea requerido                                
																		</div>

																		<span>¿cómo puedo obtener una prórroga? </span>                                 
																		<div class="Datos">
																			<p>1. Solicitar en formato libre a tu jefatura de carrera exponiendo los motivos de la solicitud, debidamente firmada por tu asesor y por ti.
																			</p> 
																			<p>2. Enviar un correo a titulacion.[carrera]@aragon.unam.mx con el ASUNTO: PRÓRROGA, anexando la documentación del punto anterior, (el documento  debe estar firmado por ti)
																			</p>                                    
																		</div>

																		<span>Cambio de Opción de Titulación</span>
																		<div class="Datos">
																			<p>
																				Solicita la cancelación de tu registro de titulación desde el Sistema de Seguimiento del Proceso de Titulación Universitaria  [poner ejemplos o los pasos a seguir] 
																			</p>
																		</div>

																		<span><strong>Cambio de tema de tesis </strong></span>
																		<div class="Datos">
																			<p>
																				Solicita la cancelación de tu registro de titulación desde el Sistema de Seguimiento del Proceso de Titulación Universitaria [poner ejemplos o los pasos a seguir] y registra tu nueva opción de titulación con el nuevo trabajo escrito
																			</p>                           
																		</div>

																		<span>¿DÓNDE puedo verificar  el avance del proceso de la Revisión de Estudios Documental? </span>                                 
																		<div class="Datos">
																			<p>
																				1. Ingresa a la liga <a href="https://ingreso.dgae.unam.mx:8020/consulta_form_sl">DE REVISIÓN DE ESTUDIO DOCUMENTAL
																				</a>
																				<p>2. Elige la opción que te corresponda &quot;Alumnos UNAM&quot; o &quot;Alumnos Sistema Incorporado&quot; </p>
																				<p>3. Ingresa  tu número de cuenta y NIP; la página abrirá la opción “Consulta Trámite de  Titulación” y revisa si aparece alguna  irregularidad en la documentación (renglones 9 y 10). 
																				En caso de que se te notifique un adeudo, notificalo al correo revisiondeestudios@aragon.unam.mx
																				</p>
																				
																		</div>

																		<span><strong>¿Cómo realizo un Cambio  de asesor? </strong></span>
																		<div class="Datos">
																			<p>
																				a) Solicitar en formato libre al correo de Titulación de tu  Jefatura de Carrera el cambio de Asesor exponiendo los motivos de la solicitud. 
																			</p>
																			<p>b) Enviar un correo a Secretaría Académica con el  ASUNTO: CAMBIO ASESOR, anexando la documentación del punto anterior, (el documento  debe estar firmado por ti, el jefe de Carrera y el nuevo asesor).
																			</p>
																			<p>&gt;&gt;&gt;La Secretaría Académica registrará en tu  expediente el cambio solicitado. </p>
																		</div>

																		<span>¿cómo  recupero mi nip de la plataforma www.siae-dgae.unam?</span>
																		<div class="Datos">
																			<p>Intenta recuperarla directamente en la misma plataforma, si por alguna razón no la obtienes, entonces  acude al Departamento de Servicios Escolares en el Edificio A1, planta baja en un horario de 9:30h a 13:30 y de 16:00h a 20:00h.</p>
																			<p>&nbsp;</p>
																		</div>
																																	
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
																	previo por escrito de la instituci&oacute;n.<!-- <a href="#">Cr&eacute;ditos</a>-->
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
													<!-- InstanceEnd -->
</html>
