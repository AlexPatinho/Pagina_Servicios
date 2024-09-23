//javascript
//FUNCION QUE GENERA LOS EFECTOS DE OCULTAMINETO Y MUESTRA
//DE LOS MENUS LATERALES.
$(function(){
	$('li').hover(function(ev) {
		$('>ul', this).stop().show('drop', { direction : 'right'}, 250);
		ev.stopPropagation();
	}, function(){
		$('ul', this).delay(250).hide('drop', { direction : 'right'}, 250);
	});
});