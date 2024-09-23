<?php
//FUNCION QUE INICIA LA CONEXION A LA BASE DE DATOS RESIVE EL NOMBRE
//DE LA BASE DE DATOS A LA QUE SE CONECTARA

	function conex($bdd){
		//INFORMACION PARA LA CONEXION A LA BASE DE DATOS
		//$host = '132.247.154.178';
		$host = '132.248.44.208';
		//$host = '127.0.0.1';
		$user = 'escolares';
		$password = '4l3xdun';		
		$strCnx = "host=$host user=$user dbname=$bdd password=$password";

		//SE REALIZA LA CONEXIÓN A LA BDD O SE INFORMA LA CAUSA
		//POR LA QUE NO SE PUDO REALIZAR LA CONEXIÓN.
		if(!$con = pg_connect($strCnx)){
			 die("208 - No se pudo realizar la conexi&oacute;n: ".pg_last_error());
		} else {
			return $con;
		}
	}
	
//CONECTA A LA IP 132.247.154.40
//RESIVE EL NOMBRE DE LA BASE DE DATOS A LA QUE SE CONECTARA
	function conex40($bdd){
		//INFORMACION PARA LA CONEXION A LA BASE DE DATOS
		//$host = '127.0.0.1';
		//$user = 'escolares';
		//$password = '4l3xdun';
		$host = '132.247.154.40';
		$user = 'postgres';
		$password = 'ptw293AqL';
		$strCnx = "host=$host user=$user dbname=$bdd password=$password";

		//SE REALIZA LA CONEXIÓN A LA BDD O SE INFORMA LA CAUSA
		//POR LA QUE NO SE PUDO REALIZAR LA CONEXIÓN.
		if(!$con = pg_connect($strCnx)){
			 die("040 - No se pudo realizar la conexi&oacute;n: ".pg_last_error());
		} else {
			return $con;
		}
	}


//CONECTA A LA IP 132.247.154.41
//RESIVE EL NOMBRE DE LA BASE DE DATOS A LA QUE SE CONECTARA
	function conex41($bdd){
		//INFORMACION PARA LA CONEXION A LA BASE DE DATOS
		$host = '132.247.154.41';
		$user = 'postgres';
		$password = 'ptw293AqL';
		$strCnx = "host=$host user=$user dbname=$bdd password=$password";

		//SE REALIZA LA CONEXIÓN A LA BDD O SE INFORMA LA CAUSA
		//POR LA QUE NO SE PUDO REALIZAR LA CONEXIÓN.
		if(!$con = pg_connect($strCnx)){
			 die("041 - No se pudo realizar la conexi&oacute;n: ".pg_last_error());
		} else {
			return $con;
		}
	}


//CONECTA A LA IP 132.247.154.43
//RESIVE EL NOMBRE DE LA BASE DE DATOS A LA QUE SE CONECTARA
	function conex43($bdd){
		//INFORMACION PARA LA CONEXION A LA BASE DE DATOS
		//$host = '127.0.0.1';
		$host = '132.247.154.43';
		$user = 'escolares';
		$password = '4l3xdun';		
		$strCnx = "host=$host user=$user dbname=$bdd password=$password";

		//SE REALIZA LA CONEXIÓN A LA BDD O SE INFORMA LA CAUSA
		//POR LA QUE NO SE PUDO REALIZAR LA CONEXIÓN.
		if(!$con = pg_connect($strCnx)){
			 die("043 - No se pudo realizar la conexi&oacute;n: ".pg_last_error());
		} else {
			return $con;
		}
	}


//CONECTA A LA IP 132.247.154.44
//RESIVE EL NOMBRE DE LA BASE DE DATOS A LA QUE SE CONECTARA
	function conex44($bdd){
		//INFORMACION PARA LA CONEXION A LA BASE DE DATOS
		//$host = '127.0.0.1';
		$host = '132.247.154.44';
		$user = 'escolares';
		$password = '4l3xdun';		
		$strCnx = "host=$host user=$user dbname=$bdd password=$password";

		//SE REALIZA LA CONEXIÓN A LA BDD O SE INFORMA LA CAUSA
		//POR LA QUE NO SE PUDO REALIZAR LA CONEXIÓN.
		if(!$con = pg_connect($strCnx)){
			 die("044 - No se pudo realizar la conexi&oacute;n: ".pg_last_error());
		} else {
			return $con;
		}
	}
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

//FUNCION QUE CIERRA LAS CONEXIONES A BDD Y LIMPIA LA MEMORIA DE LOS RESULTS
//DE LAS CONSULTAS A BDD.
	function closeConex($rsts, $cnx){
		//SE LIBERA LA VARIABLE QUE ALMACENA LOS RESULTADOS DE LA BDD.
		if(isset($rsts)){ pg_free_result($rsts); unset($rsts);}
		//SE LIBERA Y SE CIERRA LA CONEXION A LA BDD.
		//echo get_resource_type($cnx);
		if(isset($cnx) && get_resource_type($cnx) == "pgsql link"){ pg_close($cnx); unset($cnx);}
	}
?>