// JavaScript Document
//FUNCION PARA CREAR CUADROS DE DIALOGO DE MENSAJE

function dlgMensaje(_titulo, _mensaje, _tipo){
	var _t = 'alert';
	switch(_tipo){
		case 'warning' : { _t = 'ui-state-highlight'; break;}
		case 'error' : { _t = 'ui-state-error'; break; }
		default : { _t = 'alert'; break; }
	}
	//SE CREA EL CUADRO DE DIALOGO.
	$('body').append('<div id="dialog">' + _mensaje + '</div>');
	//SE INICIALIZA EL DIALOGO CON SUS FUNCIONALIDADES.
	$('#dialog').dialog({
		title: _titulo,
		height: 200,
		show: {effect: 'drop', direction: 'up', duration : 250},
		hide: {effect: 'drop', direction: 'down', duration : 250},
		dialogClass: _t,
		modal: true,
		resizable: false,
		buttons: {'Aceptar': function() {$(this).dialog('close');}},
		close: function() {$(this).dialog('destroy').remove();}
	});
}