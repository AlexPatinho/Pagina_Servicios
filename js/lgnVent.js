// JavaScript Document
$(function(){
		$('#lgn').remove('#anncs');
		$('#lgn').append('<div id="anncs" style="position: absolute; margin: 10px -5px;"></div>');
		//CONTROLAMOS LAS OPCIONEES DE LA ANIMASCION DE LOS MENSAJES INFORMATIVOS
		var $efecto = 'drop';
		var $opciones = {direction: 'up', duration: 250};
		
		//DETECTAMOS SI SE HA PRESIONADO O NO EL BOTON ACEPTAR
		/*
		$('input').keypress(function(e) {
			//$('#anncs').empty();
			if (e.which == 13) {
				e.preventDefault();	
				$('#anncs').html('<div id="msj" class="warning" >De <i>click</i> en el bot&oacute;n "Aceptar"</div>');
				$('#msj').hide().show($efecto, $opciones);
			}
		});
		*/
		//SE CAPTURA EL EVENTO SUBMIT Y SE VALIDADN LOS DATOS ANTES DE ENVIARLOS,
		//ASÍ MISMO DE CAPTURA LA RESPUESTA DEL SERVIDOR Y SE NOTIFICA AL USUARIO
		//LA INFORMACIÓN PERTINENTE.
		$('#login').submit(function(e) {
			e.preventDefault();
			$('.unbl').attr('disabled', 'disabled');
			
			var _us = $("#usr").val();
			var _ps = $("#pass").val();
			//var _se = $("#sec").val();
			
			if (_us == ''){
				$('#anncs').html('<div id="msj" class="warning">INGRESE UN USUARIO</div>');
				$('#msj').hide().show($efecto, $opciones);
				$('.unbl').removeAttr("disabled");
				
			} else if(_ps == ''){
				$('#anncs').html('<div id="msj" class="warning" >INGRESE UNA CONTRASE&Ntilde;A</div>');
				$('#msj').hide().show($efecto, $opciones);
				$('.unbl').removeAttr('disabled');
				
			} else {
				$('#anncs').html('<div id="msj" class="info" ><img style="width: 20px;heigth: 20px; border: none; margin: -10px 0;" alt="load..." src="../imgs/load.gif" />&nbsp;&nbsp;verificando...</div>');
				$('#msj').hide().show($efecto, $opciones);			
				setTimeout(function(){
					$.ajax({
						async: false,
						type: 'POST',
						url : '../php/ventanillas/login.php',
						dataType : 'json',
						data : {usr: _us, pass: _ps/*, sec: _se*/},
						success : function(results) {
							//console.log(results);
							$('#anncs').html('<div id="msj" class="succes" >OK</div>');
							$('#msj').hide().show($efecto, $opciones);	
							if(results == 'A'){
								$('#anncs').html('<div id="msj" class="error" >USUARIO INCORRECTO</div>');
								$('#msj').hide().show($efecto, $opciones);	
								$('#pass').val('');
								
							}else if (results == 'B'){
								$('#anncs').html('<div id="msj" class="error" >CONTRASE&Ntilde;A INCORRECTA</div>');
								$('#msj').hide().show($efecto, $opciones);	
								$('#pass').val('');
								
							} else if (results =='C'){
								$('#anncs').html('<div id="msj" class="succes" >OK</div>');
								$('#msj').hide().show($efecto, $opciones);	
								window.location.replace('usr.php');
							} else {
								$('#anncs').html('<div id="msj" class="error" >' + results + '</div>');
								$('#msj').hide().show($efecto, $opciones);	
								$('#pass').val('');
							}
						},
						error: function(xhr, ajaxOptions, thrownError){	
							$('#anncs').empty();
							$('#anncs').html('<div id="msj" class="error" >' + ajaxOptions + ': ' + xhr.status + ' - ' + thrownError + ':::' + xhr.responseText + '</div>');
							$('#msj').hide().show($efecto, $opciones);	
						}
					});
					$('.unbl').removeAttr('disabled');
				}, 500);
			}
			//SE UTILIZA return false PARA EVITAR QUE EL NAVEGADOR
			//SE REDIRIJA A OTRA PAGINA.
			return false;
		});
	});