// JavaScript Document
//FUNCION QUE EVITA EL GUARDADO DE LA PAGINA EN EL HISTORIAL
$(function (destino){
	$('#navmenu-v a').click(function(){
		window.location.replace($(this).attr('href'));
	});
});