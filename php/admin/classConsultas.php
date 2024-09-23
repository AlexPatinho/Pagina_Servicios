<?php
 class classConsultas{
 	 /*ÉZTA CLASE CUENTA CON DOS FUNCIONES PRINCIPALES:
   1. consultaAlumnosNombre()
   2. datosAlumnoCuenta()
  
   NOTA: datosAlumnoCuenta() SOLO SE PUEDE EJECUTAR DESPUES DE consultaAlumnosNombre()
   */
 function __construct(){}
 
 public function conexion127001(){
 	/*FUNCIÓN QUE ABRE UNA CONEXIÓN AL HOST 127.0.0.1 Y RETORNA LA VAIRABLE $con CON LA CONEXIÓN O RETORNA UN 
 	  "false" SI ÉSTA NO SE REALIZA*/ 
  $host = '127.0.0.1';
  //$host = '132.248.44.208';
		$user = 'escolares';
		$password = '4l3xdun';	
		$strDB='p400';
		$strCnx = "host=$host user=$user dbname=$strDB password=$password";

		//SE REALIZA LA CONEXIÓN A LA BDD O SE INFORMA LA CAUSA
		//POR LA QUE NO SE PUDO REALIZAR LA CONEXIÓN.
		if(!$con = pg_connect($strCnx)){
         return false;			 
			 //die("No se pudo realizar la conexi&oacute;n: ".pg_last_error());
		}else {
		   return $con;	//SE RETORNA $con CON LA CONEXIÓN A LA BASE 
		}	 
 }
 
 public function arrayRemplazoVacio($arrayConsulta,$strRemplazo){
 	/*FUNCIÓN QUE REMPLAZA LOS ELEMENTOS VACIOS EN UN ARRAY $arrayConsulta POR EL PARAMETRO $strRemplazo*/
 		
 	//echo''.count($arrayConsulta);
 	$i=0;
	while($i< count($arrayConsulta)){
		if($arrayConsulta[$i] == ""){
			$arrayConsulta[$i]=$strRemplazo;
		}
		$i++;
	}
	return $arrayConsulta; //SE RETORNA EL ARRAY CON LOS REMPLAZOS REALIZADOS
 }
 
 public function imprimeTablaAlumno($arrayConsulta){
 	
 	 $strRemplazo='...............';// STRING DE REMPLAZO PARA EL ARRY DE LA CONSULTA
	 $fila=$this->arrayRemplazoVacio($arrayConsulta,$strRemplazo);
 	 
 		$fotoAlumno='../../208/fotos/'.$fila[0].'.jpg';
			     
			        if(file_exists($fotoAlumno)){
			        	$foto=$fotoAlumno;	
			        }else{ $foto='../../208/fotos/sinFoto.jpg';}	
					//IMPRESIÓN DE LA TABLA CON LOS DATOS DEL ALUMNO	
	                  echo'
			           <img src="../php/admin/encabezado.jpg" id="imgEncabezadoAlumno" />
	                     <table id="tableAlumnoPrint">                  	
			                 
			                 <tbody >
			                 	<tr>
			                     	<td rowspan="20" style=" vertical-align:top">
			                         	<img width="150" src="'.$foto.'"/><br />
			                             <input id="imprimir" type="button" value="IMPRIMIR" />
			                         </td>
			                     </tr>
			                     <tr>
			                     	<th colspan="3">
			                         	.::DATOS PERSONALES::.
			                         </th>
			                     </tr>
			                     <tr>
			                         <td>N&uacute;mero de cuenta:</td>
			                         <td>'.$fila[0].'</td>
			                     </tr>
			                     <tr>
			                     	<td>Nombre(s) y apellidos:</td>
			                         <td>'.$fila[1].'  '.$fila[2].'  '.$fila[3].'</td>
			                     </tr>
			                     <tr>
			                     	<td>Fecha de nacimiento:</td>
			                         <td>'.$fila[5].'</td>
			                     </tr>
			                     <tr>
			                        <td>Carrera:</td>
			                         <td>'.$fila[4].'</td>
			                     	
			                     </tr>
			                 
			                 	<tr>
			                     	<th colspan="2">
			                         	.:DOMICILIO:.
			                         </th>
			                     </tr>
			                 	<tr>
			                     	<td>ESTADO:</td>
			                         <td>'.$fila[6].'</td>
			                     </tr>
			                     <tr>
			                         <td>DELEGACI&Oacute;N / MUNICIPIO:</td>
			                         <td>'.$fila[7].'</td>
			                     </tr>
			                     
			                     <tr>
			                         <td>CODIGO POSTAL:</td>
			                         <td>'.$fila[10].'</td>
			                     </tr>
			                     <tr>
			                         <td>COLONIA:</td>
			                         <td>'.$fila[8].'</td>
			                     </tr>
			                     <tr>
			                         <td>CALLE Y N&Uacute;MERO:</td>
			                         <td>'.$fila[9].'</td>
			                     </tr>
			                 	<tr>
			                     	<th colspan="3">
			                         	.:CONTACTO:.
			                         </th>
			                     </tr>
			                     <tr>
			                     	<td>Telefono (casa):</td>
			                         <td>'.$fila[11].'</td>
			                     </tr>
			                     <tr>
			                     	<td>Telefono (oficina/recados):</td>
			                         <td>'.$fila[12].'</td>
			                     </tr>
			                     <tr>
			                     	<td>Telefono (celular):</td>
			                         <td>'.$fila[13].'</td>
			                     </tr>
			                     <tr>
			                     	<td>Correo electr&oacute;nico:</td>
			                         <td>'.$fila[14].'</td>
			                     </tr>
			                     <tr>
			                     	<td>Semestre de Actualizaci&oacute;n</td>
			                         <td>'.$fila[15].'</td>
			                     </tr>
			                 </tbody>
			             </table>';
	
	
 }    
 public function datosAlumnoCuenta($cta){
 	//******FUNCIÓN PRINCIPAL*********
 	 $conexion = $this->conexion127001();
    if($conexion){
    	/* CONSULTA A LOS ALUMNOS QUE HAN ACTUALIZADO LOS DATOS EN domi. 
	 EL PARAMETRO $cta (NÚMERO DE CUENTA DEL ALUMNO) SE AGREGA A $sql PARA LA CONSULTA*/
       $sql="SELECT 
							  domi.cuenta,
							  domi.paterno,
							  domi.materno,
							  domi.nombres,
							  carrera.nombre,
							  domi.fechnac,
							  
							  dom_estado.nom_estado,
							  dom_del_mun.nom_del_mun,
							  dom_col.nom_col,
							  domi.calleynum,
							  dom_cod_post.codigo,
							
							  domi.telefono,
							  domi.telefono2,
							  domi.telefono3,
							  domi.email,
							  domi.semactdom
							  
							  --dom_ciu_pob.nom_ciu_pob    
							 FROM domi, diralum , carrera, dom_col, dom_cod_post , dom_ciu_pob, dom_del_mun , dom_estado
							
							 WHERE
							 domi.cuenta='".$cta."'
							 AND
							 domi.cuenta=diralum.cuenta
							 AND
							 diralum.carr=carrera.carr
							 AND
							  
							 domi.fk_id_col=dom_col.id_col
							 AND 
							 dom_col.fk_id_cod_post=dom_cod_post.id_cod_post
							 AND
							 dom_cod_post.fk_id_ciu_pob=dom_ciu_pob.id_ciu_pob
							 AND
							 dom_ciu_pob.fk_id_del_mun=dom_del_mun.id_del_mun
							 AND
							 dom_del_mun.fk_id_estado=dom_estado.id_estado  
							 ORDER BY diralum.gen DESC
							 LIMIT 1"; 
			      $consulta=pg_query($conexion,$sql); 
			      $arrayConsulta=pg_fetch_array($consulta,null,PGSQL_NUM);
			      $registros=pg_num_rows($consulta);
			      if($registros>0){
			       	
			       $this->imprimeTablaAlumno($arrayConsulta);
	
			          
			      }else{
				   
				   /* CONSULTA A LOS ALUMNOS QUE "NO HAN ACTUALIZADO LOS DATOS EN domi" 
	                  EL PARAMETRO $cta (NÚMERO DE CUENTA DEL ALUMNO) SE AGREGA A $sql PARA LA CONSULTA*/
			      		
			      		
			      	
			      	   $sql2="SELECT 
							  domi.cuenta,
							  domi.paterno,
							  domi.materno,
							  domi.nombres,
							  carrera.nombre,
							  domi.fechnac,
							  
							  domi.entidad,
							  domi.deleomuni,
							  domi.codigo,
							  domi.colopobla,
							  domi.calleynum,
							  
							  domi.telefono,
							  domi.telefono2,
							  domi.telefono3,
							  domi.email,
							  domi.semactdom
							 FROM domi, diralum , carrera
							
							 WHERE
							 domi.cuenta='".$cta."'
							 AND
							 domi.cuenta=diralum.cuenta
							 AND
							 diralum.carr=carrera.carr ";
			           $consulta2=pg_query($conexion,$sql2); 
			           $arrayConsulta=pg_fetch_array($consulta2,null,PGSQL_NUM);
			           $registros2=pg_num_rows($consulta2);
			           if($registros2>0){
			           		$this->imprimeTablaAlumno($arrayConsulta);
	
			           	
			           	
			           }else{  echo'<label class="classLabel">NO HAY REGISTRO DEL ALUMNO</label>';} }//if $sql2	              
		}else {		      
			      die("No se pudo realizar la conexi&oacute;n: ".pg_last_error()); 
			     }
    pg_close($conexion); 
  }

 public function consultaAlumnosNombre($pNombres,$pApellidoPaterno,$pApellidoMaterno){
    //*FUNCIÓN QUE IMPRIME UN FORMULARIO CON LOS RESULTADOS DE LOS NOMBRES Y NUMEROS DE CUENTA COINCIDENTES CON LAS CADENAS DE ENTRADA
	$conexion = $this->conexion127001();
    if($conexion){
    	
     $nombres=strtoupper($pNombres);
     $apellidoPaterno=strtoupper($pApellidoPaterno);
	 $apellidoMaterno=strtoupper($pApellidoMaterno);
	 
     $sql="SELECT domi.cuenta, domi.paterno, domi.materno, domi.nombres
                        FROM domi
                        WHERE 
                        domi.nombres LIKE '%".$nombres."%' AND 
                        domi.paterno LIKE '%".$apellidoPaterno."%' AND 
                        domi.materno LIKE '%".$apellidoMaterno."%'
                        ORDER BY domi.paterno ASC , domi.materno ASC , domi.nombres ASC
                        "; 
	 //echo''.$sql;				
	  $consulta=pg_query($conexion,$sql); 
	  $registros=pg_num_rows($consulta);
			      if($registros > 0){//VALIDADCIÓN DE REGISTROS EN $sql
			      //IMPRESIÓN DE UN FORMULARIO  CON LOS RESULTADOS DE LA CONSULTA 
			       echo'<form  id="formListaAlumnos" name="formListaAlumnos" method="post" action="contactoAlm.php" >
			             <select id="cta" name="cta" required="required" size="5" class="classSelect">';	
			          
			       while($fila=pg_fetch_array($consulta,null,PGSQL_NUM)){
			       	 
					echo'<option value="'.$fila[0].'" >'.$fila[0].' '.$fila[1].' '.$fila[2].' '.$fila[3].'</option>';
			       }	
				   echo'</select> <br> 
				         <input name="inpformListaAlumnos" id="inpformListaAlumnos" type="submit" value="Consultar...">  
				       </form>';
				 	
			      }else{echo'<label class="classLabel">NO HAY REGISTRO DEL ALUMNO</label>';}  
    
    }else { die("No se pudo realizar la conexi&oacute;n: ".pg_last_error());}  
     pg_close($conexion);  
}
 

}
?>