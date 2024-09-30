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
    .pdf {color: #D8000C; font-size: 18px;}
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
                    <!-- InstanceBeginEditable name="Contenido" --><br />
                    <p class="titulos-noticas-ext">	<img src="../imgs/SS.jpg" alt="ss" width="100" height="80" longdesc="Preguntas frecuentes" />PREGUNTAS FRECUENTES DE SERVICIO SOCIAL</p>
                    
                    <p>¡Importante! Todos los trámites implican tiempo de elaboración y revisión, por lo que no son automáticos.</p>
                    
                    <p>Todo el proceso del Registro del Servicio Social es de manera digital y debes realizarlo en la siguiente plataforma: <a href="http://132.248.44.97/serviciosocial/">Sistema de Servicio Social</a></p>

                  <div id="informacion">

                    <span>PREMIO AL SERVICIO SOCIAL "DR. GUSTAVO BAZ PRADA"</span>
                    <div class="Datos">
                       <p> Consulta la convocatoria en el siguiente enlace: <br>

                        <a href="tram_ss_gustavo.html">PREMIO AL SERVICIO SOCIAL "DR. GUSTAVO BAZ PRADA" 2023</a></p>								
                   </div>
                   <span>Enlace para solicitudes</span>
                    <div class="Datos">
                       <p>Sistema de Servicio Social <a href="http://132.248.44.97/serviciosocial">http://132.248.44.97/serviciosocial</a>/</p>                              
                   </div>
                   
                <span>1. ¿Qué  requisitos necesito tener para comenzar mi servicio social?</span>
                <div class="Datos">
                  <p>70% de créditos del  plan de estudios de tu carrera.</p>
              </div>
              <span>2. ¿En dónde puedo realizar mi servicio social?</span>
              <div class="Datos">
                <p>En cualquier dependencia gubernamental, asociación civil sin fines de lucro  (A.C.), Instituciones de Asistencia Privada (IAP) o instituciones educativas públicas, siempre y cuando tengan programa y clave vigente.</p>
            </div>

            <span>3. ¿En  dónde puedo consultar los programas de servicio social vigentes?</span>
            <div class="Datos">
                <p>En la página <a href="https://www.siass.unam.mx">https://www.siass.unam.mx</a> con tu número de  cuenta.</p>
            </div>
            <span>4. ¿Cuántas  horas debo cubrir del servicio social y en cuánto tiempo?</span>
            <div class="Datos">
              <p>Por reglamento, debes cubrir un total de 480 horas en un plazo no menor a seis  meses ni mayor a dos años. </p>
          </div>
          <span>5. ¿Cuándo  y dónde puedo tramitar la carta de presentación que me solicita la institución?</span>
          <div class="Datos">
            <p>El trámite es en línea y puedes realizarlo en la siguiente plataforma: <b><a href="http://132.248.44.97/serviciosocial/">Sistema de Servicio Social</a></b></p>
        </div>
        <span>6. ¿En  cuánto tiempo me entregan la carta de presentación?</span>
        <div class="Datos">
            <p>Una vez que te aparezca el registro de "aprobado" en la plataforma, podrás descargar la carta de presentación a más tardar al siguiente día hábil de la fecha que realizaste la solicitud.</p>

        </div>
        
        <span>7. Una vez iniciado el servicio social ¿qué trámite tengo que realizar?</span>
        <div class="Datos">
            <p>La institución te debe entregar la carta de aceptación en la página del <b><a href="http://132.248.44.97/serviciosocial/">Sistema de Servicio Social</a></b>, misma que deberás escanear y subir en un archivo PDF en el apartado con este nombre.</p>
        </div>

        <span>8. ¿ConcluÍ  el servicio social y ya cuento con la carta de término emitida por la institución, junto con el informe global sellado por el área donde lo realicé ¿Cómo y dónde puedo  entregar mis documentos? </span>
        <div class="Datos">
            <p>R.  Tienes que subir ambos documentos en archivo PDF en la plataforma del <b><a href="http://132.248.44.97/serviciosocial/">Sistema de Servicio Social</a></b> en el apartado correspondiente para proceder a su revisión y proseguir con el trámite de liberación</p>
        </div>

        <span>9. ¿Cómo debo elaborar el informe global de actividades?</span>
        <div class="Datos">
            <p><br />
            R.  Es un formato libre, debe estar dirigido a la Lic. Guadalupe Mendieta Bello, Jefa del Departamento de Servicio Social, anotando tus datos y los del programa donde participaste, además describir las actividades que realizaste durante tu servicio social, el documento debe estar firmado por el prestador del servicio y por la persona que supervisó las actividades, así como el sello de la institución o del área donde prestaste tu servicio.</p>
     
        </div>

        <span>10. Para  darme de baja del programa de servicio social en el que me registré ¿Qué debo  hacer?</span>
        <div class="Datos">
         <p>Enviar al correo <a href="mailto:serviciosocial@aragon.unam.mx">serviciosocial@aragon.unam.mx</a> o presentar de manera física en el Departamento de Servicio Social, un escrito dirigido a la Lic. Guadalupe Mendieta Bello, Jefa del Departamento de Servicio Social de la FES Aragón, donde señales la fecha, tu nombre, número de cuenta y carrera, así como nombre y clave del programa, además de anotar una breve exposición del motivo por el cual solicitas la baja del servicio social, y deberá estar avalada con tu firma. Debes de enviar el documento en un archivo PDF.</p>
     </div>

     <p>Es responsabilidad del alumno proporcionar la información completa y verídica que se 
     solicita para cada trámite y de esta forma se expidan lo más pronto posible.</p>
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
<!-- InstanceEnd --></html>
