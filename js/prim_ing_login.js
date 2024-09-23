// JavaScript Document
$(function()
{
	$('#lgn').remove('#anncs');
	$('#lgn').append('<div id="anncs" style="position: absolute; margin: 10px -5px;"></div>');
		//CONTROLAMOS LAS OPCIONES DE LA ANIMACION DE LOS MENSAJES INFORMATIVOS
		var $efecto = 'drop';
		var $opciones = {direction: 'up', duration: 250};
		
		//DETECTAMOS SI SE HA PRESIONADO O NO EL BOTON ACEPTAR
		$('input').keypress(function(e) 
		{
			//$('#anncs').empty();
			if (e.which == 13) 
			{
				e.preventDefault();	
				$('#anncs').html('<div id="msj" class="warning" >De <i>click</i> en el bot&oacute;n "Aceptar"</div>');
				$('#msj').hide().show($efecto, $opciones);
			}
		});
		//SE CAPTURA EL EVENTO SUBMIT Y SE VALIDADN LOS DATOS ANTES DE ENVIARLOS,
		//ASÍ MISMO DE CAPTURA LA RESPUESTA DEL SERVIDOR Y SE NOTIFICA AL USUARIO
		//LA INFORMACIÓN PERTINENTE.
		$('#login').submit(function(e) 
		{
			e.preventDefault();
			$('.unbl').attr('disabled', 'disabled');
			
			var _us = $("#usr").val();
			var _ps = $("#pass").val();
			//var _se = $("#sec").val();
			
			if (_us == '')
			{
				$('#anncs').html('<div id="msj" class="warning">INGRESE SU N&Uacute;MERO DE CUENTA</div>');
				$('#msj').hide().show($efecto, $opciones);
				$('.unbl').removeAttr("disabled");
			} 
			else if(_ps == '')
			{
				$('#anncs').html('<div id="msj" class="warning" >INGRESE SU CURP</div>');
				$('#msj').hide().show($efecto, $opciones);
				$('.unbl').removeAttr('disabled');
			} 
			else 
			{
				$('#anncs').html('<div id="msj" class="info" ><img style="width: 20px;heigth: 20px; border: none; margin: -10px 0;" alt="load..." src="../imgs/load.gif" />&nbsp;&nbsp;verificando...</div>');
				$('#msj').hide().show($efecto, $opciones);
				
				var retraso = (Math.floor(Math.random() * 3) + 1) * 1000;
				setTimeout(function()
				{
					$.ajax({
						async: false,
						type: 'POST',
						url : '../php/primer_ingreso/login.php',
						dataType : 'json',
					data : {usr: _us, pass: _ps/*, sec: _se*/},
					success : function(results) {
							console.log(results);
							$('#anncs').html('<div id="msj" class="succes" >OK</div>');
							$('#msj').hide().show($efecto, $opciones);	
							if(results == '-2'){
								$('#anncs').html('<div id="msj" class="error" >N&Uacute;MERO DE CUENTA NO EXISTE</div>');
								$('#msj').hide().show($efecto, $opciones);	
								$('#pass').val('');
								
							}else if (results == '-1'){
								$('#anncs').html('<div id="msj" class="error" >CURP INCORRECTA</div>');
								$('#msj').hide().show($efecto, $opciones);	
								$('#pass').val('');
								
							} else if (results =='0'){
								$('#anncs').html('<div id="msj" class="succes" >OK</div>');
								$('#msj').hide().show($efecto, $opciones);	
								window.location.replace('prim_ing.php');
							} else {
								$('#anncs').html('<div id="msj" class="error" >ERROR EN LA CONEXI&Oacute;N.</div>');
								$('#msj').hide().show($efecto, $opciones);	
								$('#pass').val('');
							}
						},
						error: function(xhr, ajaxOptions, thrownError){	
							if(xhr.responseText === 'NULL'){
								$('#anncs').empty();
								//$('#anncs').html('<div id="msj" class="error" >' + ajaxOptions + ': ' + xhr.status + ' - ' + thrownError + '</div>');
								$('#anncs').html('<div id="msj" class="warning" >EL USUARIO NO SE HA REGISTRADO EN EL SISTEMA </div>');
								//console.log(xhr.responseText);
								$('#msj').hide().show($efecto, $opciones);
								//setTimeout(function(){location.reload();}, 3000)
							} else {
								$('#anncs').empty();
								//$('#anncs').html('<div id="msj" class="error" >' + ajaxOptions + ': ' + xhr.status + ' - ' + thrownError + '</div>');
								$('#anncs').html('<div id="msj" class="error" >DATOS INGRESADOS NO VALIDOS.<br />FAVOR DE VERIFICAR.</div>');
								//console.log( ajaxOptions + ': ' + xhr.status + ' - ' + thrownError  + ' :: '+  xhr.responseText);
								$('#msj').hide().show($efecto, $opciones);
								//setTimeout(function(){location.reload();}, 3000)
							}
						}
					});
					$('.unbl').removeAttr('disabled');
				}, retraso);
			}
			//SE UTILIZA return false PARA EVITAR QUE EL NAVEGADOR
			//SE REDIRIJA A OTRA PAGINA.
			return false;
		});
	});