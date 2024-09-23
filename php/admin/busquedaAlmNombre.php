<?php
	session_start();
	if(isset($_SESSION) && isset($_SESSION["usrAdmin"])){
		//DO SOMETHING...
	} else {
		session_unset();
		session_destroy();
		header("Location: ../");
	}
?>
<html>
	<head>
		 <title></title>	
		  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		   
    <script type="text/javascript"  src="js/jquery-2.0.2.js"></script>
    <script type="text/javascript">
         function navegadores(){
       	
       	   if ($.browser.msie && $.browser.version <= 8 ){
       		listaAlumnosIE();
       	   }else{
       		listaAlumnos();
       	   }
         }
          function listaAlumnosIE(){
          	
            $("#cta option , #inpformListaAlumnos").click(function(evento){
                var parametros=$('#formListaAlumnos').serialize();
                $.post("../php/admin/contactoAlm.php",parametros,function(datos){
                    
                     $("#divTableAlumno").hide().html(datos).show(200);
                        
                    });
                evento.preventDefault();
                
                });    
          	
          }
          function listaAlumnos(){
          	
           $("#inpformListaAlumnos").hide();
            $("#cta option , #inpformListaAlumnos").click(function(evento){
                var parametros=$('#formListaAlumnos').serialize();
                $.post("../php/admin/contactoAlm.php",parametros,function(datos){
                    
                     $("#divTableAlumno").hide().html(datos).show(200);
                        
                    });
                evento.preventDefault();
                
                });    
          	
          }
        $(document).ready(function(){
           
            navegadores();
  
            }); 
     </script>
	</head>

	<body>
		<?php
        include_once'classConsultas.php';
		
        if(isset($_POST["nombres"])      && !is_numeric($_POST["nombres"])          && strlen($_POST["nombres"]) > 2 ||
        isset($_POST["apellidoPaterno"]) && !is_numeric($_POST["apellidoPaterno"])  && strlen($_POST["apellidoPaterno"]) > 2 ||
        isset($_POST["apellidoMaterno"]) && !is_numeric($_POST["apellidoPaterno"])  && strlen($_POST["apellidoMaterno"]) > 2 ){
      	
        $objConsulta= new classConsultas();
	    $objConsulta->consultaAlumnosNombre($_POST["nombres"],$_POST["apellidoPaterno"],$_POST["apellidoMaterno"]);
          
        }else{ echo ('<label class="classLabel">RELLENA UN CAMPO CON LETRAS Y LONGITUD MÍNIMA DE 3</label>');  }
        ?>
 	</body>
</html>