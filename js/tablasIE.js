// JavaScript Document
//FUNCION QUE ALTERNA LOS COLORES DE LAS FILAS DE LAS TABLAS
//FUNCIONALIDAD PARA COMPATIBILIDAD CON EL NAVEGADOR INTERNET EXPLORER.
$(function(){
	hoverTabla();
	///////////////////////////////////////////////////////////////////////////
	tablaCebra();
});

///////////////////////////////////////////////////////////////////////////
function hoverTabla(){
	$('#contenido-central tbody tr').each(function(index) {
        if((index%2) == 0 && ($(this).attr('style') == null)){
			$(this).css('background-color', '#fff');
		} else if($(this).attr('style') == null){
			$(this).css('background-color', '#dff');
		}
    });
}

///////////////////////////////////////////////////////////////////////////
function tablaCebra(){
	//CAMBIA EL COLOR DE LAFILA AL PASAR EL PUNTERO SOBRE ELLA.
	$('tbody>tr').hover(function(){
	  var $this = $(this);
	  $this.data('bgcolor', $this.css('background-color')).css('background-color', '#FEEFB3');
	},
	function(){
	  var $this = $(this);
	  $this.css('background-color', $this.data('bgcolor'));
	});
}
