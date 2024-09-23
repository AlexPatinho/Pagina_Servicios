// JavaScript Document
//ESTA FUNCION REDIRECCIONA LA PAGINA AL SCRIPT DE PHP
//QUE CIERRA LA SESION, EVITANDO QUE SE ALMACENE LA PAGINA
//EN EL HISTORIAL DEL NAVEGADOR.
function logout(){
	window.location.replace('../php/logout.php?loc=true');
}