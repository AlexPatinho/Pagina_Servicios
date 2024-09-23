<?php
//********************************************************
//********************************************************
include_once("../miscelaneas.php");
require_once("../conex.php");
$bdd = "inscripciones";//BASE DE DATOS DEL NUEVO SISTEMA
//********************************************************
//********************************************************
session_start();
if (!$_SESSION){
	header("location:index.php");	
}
$Host='132.248.44.208';
$Usu='escolares';
$Clave='4l3xdun';
$Base='p400';
$Ano='20231';
$Tipo=$_POST['Tipo'];

if($Tipo=='listaa'){
	?>
	<script>
		$(document).ready(function(){
			function ListaA(){
				$('#listado').empty();
				$.post("../php/jefaturas/camtur.php","Tipo=listaa",function(respuesta){
					$("#listado").html(respuesta);
				}).fail(function(xhr, ajaxOptions, thrownError){ 
					console.log(+ ajaxOptions + ' : '
						+ xhr.status + ' - '
						+ thrownError + ' ::: ' + xhr.responseText); });
			}
			function Ogrupos(){
				$('#cupos').empty();
				$.post("../php/jefaturas/camtur.php","Tipo=grupos",function(respuesta){
					$("#cupos").html(respuesta);
				}).fail(function(xhr, ajaxOptions, thrownError){ 
					console.log(+ ajaxOptions + ' : '
						+ xhr.status + ' - '
						+ thrownError + ' ::: ' + xhr.responseText); });
			}

			$(".DatosA").click(function(){
				var campo=$(this).val();
				$("#datos").empty();
				$("#datos").show();
				$.post("../php/jefaturas/camtur.php","Tipo=datos&cuenta="+campo,function(respuesta){
					console.log(respuesta);
					$("#datos").html(respuesta);
				}).fail(function(xhr, ajaxOptions, thrownError){ 
					console.log(+ ajaxOptions + ' : '
						+ xhr.status + ' - '
						+ thrownError + ' ::: ' + xhr.responseText); });
				$("#listado").hide();  
			});

			$(".Eliminar").click(function(){
				var campo=$(this).val();
				$.post("../php/jefaturas/camtur.php","Tipo=eliminar&cuenta="+campo,function(respuesta){
					alert(respuesta);
					Ogrupos();
					ListaA();
				}).fail(function(xhr, ajaxOptions, thrownError){ 
					console.log(+ ajaxOptions + ' : '
						+ xhr.status + ' - '
						+ thrownError + ' ::: ' + xhr.responseText); });
			});

		});
	</script>
	<?php
//********************************************************
	//$conex = conex40($bdd);
	$conex = conex("p400");
//********************************************************
	$carr=$_SESSION['carr'];
	//if(!$con = pg_connect("host=$Host user=$Usu dbname=$Base password=$Clave")){
	if(!$conex){
		die("No se pudo realizar la conexi&oacute;n: ".pg_last_error());
	}
	
	$sql="select cuenta, 
	paterno, 
	materno, 
	nombre, 
	grupo_asig, 
	grupo_fin, 
	resulta, 
	tipo 
	from pi".$Ano." 
	where avance='7' 
	and carrera='".$carr."' 
	order by grupo_fin,tipo desc,sexo desc, 
	paterno,
	materno, 
	nombre";

	$Query1=pg_query($sql) or die(pg_last_error());
	$resultado="<table><tr><th>No.</th><th>CUENTA</th><th>NOMBRE</th><th>GRUPO</th><th>CAMBIO</th><th>TIPO</th><th>RESULTADO</th><th>ACCION</th></tr>";
	$i=0;
	while($row=pg_fetch_row($Query1)){
		$resultado=$resultado."<tr>	<td>".++$i."</td><td>".$row[0]."</td> <td>".$row[1]." ".$row[2]." ".$row[3]."</td><td>".$row[5]."</td>";
		if($row[7]=='1') $Mov='Domicilio';
		elseif($row[7]=='2') $Mov='Enfermedad';
		elseif($row[7]=='3') $Mov='Trabajo';
		if($row[6]==NULL or $row[6]=='')
			$status='<td>-</td><td>'.$Mov.'</td><td>-</td><td><button type="button" class="DatosA" value="'.$row[0].'">Ver Detalles</button></td>';
		elseif($row[6]=='0')
			$status='<td>0000</td><td>'.$Mov.'</td><td>Denegado</td><td><button type="button" class="Eliminar" value="'.$row[0].'">Eliminar</button></td>';
		elseif($row[6]=='9')
			$status='<td>'.$row[4].'</td><td>'.$Mov.'</td><td>Aceptado</td><td><button type="button" class="Eliminar" value="'.$row[0].'">Eliminar</button></td>';
		$resultado=$resultado.$status."</tr>";
//		$i++;
	}
	$resultado=$resultado."</table>";
	echo $resultado;
	pg_close();
} elseif ($Tipo=='grupos'){
	$carr=$_SESSION['carr'];
	
//********************************************************
	//$conex = conex40($bdd);
	$conex = conex("p400");
//********************************************************
	//if(!$con = pg_connect("host=$Host user=$Usu dbname=$Base password=$Clave")){
	if(!$conex){
		die("No se pudo realizar la conexi&oacute;n: ".pg_last_error());
	}
	$sql="select 
	grupo_fin, 
	count(*) 
	from pi".$Ano." 
	where carrera='".$carr."' 
	and grupo_fin !='0000' 
	and substring(grupo_fin,1,1)!='9' 
	and ins='1' 
	group by grupo_fin 
	order by grupo_fin";
	//echo json_encode($sql);	
	$Query1=pg_query($sql) or die(pg_last_error());
	$i=0;
	while($row=pg_fetch_row($Query1)){
		$grupos[]=$row;
		$i++;
	}
	$resultado="<table>";
	//**************************************************************************
	if($i>10){
		$magpo=1;
		$maxre=2;
		$inter=10;	
		$ini=0;
	}
	else{
		$magpo=1;
		$maxre=1;
		$inter=$i;
		$ini=0;
	}
	for($nr=0;$nr<$maxre;$nr++)
	{
		if($nr==1){
			$ini=$inter;
			$inter=$i;
			//$resultado=$resultado."<tr><td colspan=11 ></td></tr>";
		}
		for($b=-1; $b<2; $b++){
			$resultado=$resultado."<tr>";
			if($b==-1){
				if($i>10){
					if($nr==0)
						$resultado=$resultado."<th>MATU</th>";
					else
						$resultado=$resultado."<th>VESP</th>";
				}
				else
					$resultado=$resultado."<th> - </th>";
			}
			if($b==0)
				$resultado=$resultado."<th>GRUPO</th>";
			if($b==1)
				$resultado=$resultado."<th>CUPO</th>";

			for($a=$ini; $a<$inter; $a++){
				if($b==-1){
					$G=$a+1;
					$resultado=$resultado."<th>GPO. ".$G."</th>";
				}
				else
					$resultado=$resultado."<td>".$grupos[$a][$b]."</td>";
			}
			$resultado=$resultado."</tr>";
		}
	}
	//**************************************************************************
	$resultado=$resultado."</table>";
	echo $resultado;
	pg_close();
} elseif($Tipo=='autoriza'){
	$carr=$_SESSION['carr'];
	$cuenta=$_POST['cuenta'];
	$grupo=$_POST['grupo'];
	$resulta=$_POST['resulta'];
	
//********************************************************
	//$conex = conex40($bdd);
	$conex = conex("p400");
//********************************************************
	//if(!$con = pg_connect("host=$Host user=$Usu dbname=$Base password=$Clave")){
	if(!$conex){
		die("No se pudo realizar la conexi&oacute;n: ".pg_last_error());
	}
	$sql="update pi".$Ano." set resulta='$resulta'";
	if($resulta=='9'){
		$sql=$sql.",grupo_fin = '$grupo'";
	}
	$sql=$sql." where cuenta='$cuenta' and carrera='$carr'";
	$Query1=pg_query($sql) or die(pg_last_error());
	$sql="select grupo_fin,paterno,materno,nombre,grupo_asig from pi".$Ano." where cuenta='$cuenta' and carrera='$carr'";
	$Query1=pg_query($sql) or die(pg_last_error());
	$row=pg_fetch_row($Query1);
	if($resulta=='9')
		echo "El alumno $cuenta ".$row[1]." ".$row[2]." ".$row[3]." se ha cambiado del grupo ".$row[4]." al grupo -> ".$row[0];
	else
		echo "El alumno $cuenta ".$row[1]." ".$row[2]." ".$row[3]." NO HA CAMBIADO de GRUPO ->".$row[0];
	pg_close();
} elseif($Tipo=='datos'){
	?>
	<script>
		$(document).ready(function(){
			function Ogrupos(){
				$('#cupos').empty();
				$.post("../php/jefaturas/camtur.php","Tipo=grupos",function(respuesta){
					$("#cupos").html(respuesta);
				}).fail(function(xhr, ajaxOptions, thrownError){ 
					console.log(+ ajaxOptions + ' : '
						+ xhr.status + ' - '
						+ thrownError + ' ::: ' + xhr.responseText); });
			}
			function ListaA(){
				$('#listado').empty();
				$.post("../php/jefaturas/camtur.php","Tipo=listaa",function(respuesta){
					$("#listado").html(respuesta);
				}).fail(function(xhr, ajaxOptions, thrownError){ 
					console.log(+ ajaxOptions + ' : '
						+ xhr.status + ' - '
						+ thrownError + ' ::: ' + xhr.responseText); });
			}
	//***************************************************************************
	$(".Autoriza").click(function(){
		var campo=$(this).val();
		var cuenta=$("#fcuenta").val();
		var grupo=$("#fgrupo").val();
		$.post("../php/jefaturas/camtur.php","Tipo=autoriza&cuenta="+cuenta+"&grupo="+grupo+"&resulta="+campo,function(respuesta){
			alert(respuesta);
			Ogrupos();
			ListaA();
			$("#datos").hide();
			$("#listado").show();

		}).fail(function(xhr, ajaxOptions, thrownError){ 
			console.log(+ ajaxOptions + ' : '
				+ xhr.status + ' - '
				+ thrownError + ' ::: ' + xhr.responseText); });
	});
	//***************************************************************************
	$("#cancela").click(function(){
		$("#datos").hide();
		$("#listado").show();
	});
	//***************************************************************************
});
</script>
<?php
$carr=$_SESSION['carr'];
$cuenta=$_POST['cuenta'];

//********************************************************
	//$conex = conex40($bdd);
$conex = conex("p400");
//********************************************************
	//if(!$con = pg_connect("host=$Host user=$Usu dbname=$Base password=$Clave")){
if(!$conex){
	die("No se pudo realizar la conexi&oacute;n: ".pg_last_error());
}
$sql = " SELECT cuenta, paterno, materno, nombre, grupo_fin, grupo_asig, tipo, motivos, fechsol, domi_canu, domi_colo, domi_demu, domi_copo, telefono, email FROM pi$Ano WHERE cuenta='$cuenta' and carrera='$carr'; ";
	//echo json_encode("$sql");
$Query1 = pg_query($sql);
//echo json_encode(pg_last_error());

//echo json_encode($Query1[0]);

$sqlG="select grupo from gpos_cam where carr='$carr'";
$anexo='';
$turno=substr(pg_result($Query1,4),2,1)+0;
	//echo json_encode($turno);
if($turno>=0 and $turno<=4){
	$anexo=' and cast(substr(grupo,3,1) as int)>=5 and cast(substr(grupo,3,1) as int)<=9';
	$tur='VESPERTINO';
} elseif($turno>=5 and $turno<=9){
	$anexo=' and cast(substr(grupo,3,1) as int)>=0 and cast(substr(grupo,3,1) as int)<=4';
	$tur='MATUTINO';
}
$sqlG=$sqlG.$anexo;
	//echo json_encode($sqlG);
$Gpos=pg_query($sqlG) or die(pg_last_error());
$TipT=pg_result($Query1,6);

//echo json_encode($TipT);

$resultado="<table>";
$resultado=$resultado."<tr> <th>CUENTA</th><th>NOMBRE</th><th>GRUPO</th><th>SOLICITA</th></tr>";
$resultado=$resultado."<tr>	<td>".pg_result($Query1,0)."</td> <td>".pg_result($Query1,1)." ".pg_result($Query1,2)." ".pg_result($Query1,3)."</td><td>".pg_result($Query1,4)."</td><td>".$tur."</td> </tr>";
$resultado=$resultado."<tr><th colspan=4>MOTIVOS</th></tr><tr>	<td colspan=4>".pg_result($Query1,7)."</td> </tr>";
$resultado=$resultado."</table><br><br>";

$Direc="../../camTur/archivos/".$carr."/";
$archivos[1]=$archivos[2]=$archivos[3]=0;
if($gd=opendir($Direc))
{
	while(($File=readdir($gd)) !== false)
	{
		if(strpos(" ".$File,$cuenta)>0){
			$index=substr($File,10,1);
			$archivos[$index]=$File;
		}
	}
	closedir($gd);
}
$Titulo="";
$Texto1="";
$Texto2="";
$resultado=$resultado."<table>";

if($TipT=='1')
{
	$Titulo="Trámite por Domicilio";
	$Texto1="Comprobante de Domicilio o contrato de arrendamiento:";
	$Texto2="Credencial de Elector del titular del inmueble o contratante, identificando el parentesco:";
} elseif($TipT=='2')
{
	$Titulo="Trámite por Enfermedad";
	$Texto1="Resumen Medico no mayor a 6 meses con sello de la institución médica perteneciente al sector salud (IMSS, ISSSTE, SSA):";
	$Texto2="Carta del médico especificando el tratamiento a seguir y en su caso la terapia y los horarios de la misma:";
} elseif($TipT=='3')
{
	$Titulo="Trámite por Trabajo";
	$Texto1="Recibo de nómina: (2 últimos)";
	$Texto2="Carta membreteada del lugar de trabajo especificando horario:";
	$Texto3="Credencial o identificación de su lugar de trabajo:";
}
$resultado=$resultado."<tr><th colspan=2>".$Titulo."</th></tr>";
$resultado=$resultado."<tr> <td>".$Texto1."</td><td><a href='".$Direc.$archivos[1]."' target=_blank>".substr($archivos[1],12,200)."</a></td></tr>";
$resultado=$resultado."<tr> <td>".$Texto2."</td><td><a href='".$Direc.$archivos[2]."' target=_blank>".substr($archivos[2],12,200)."</a></td></tr>";

if($TipT=='3')
{
	$resultado=$resultado."<tr> <td>".$Texto3."</td><td><a href='".$Direc.$archivos[3]."' target=_blank>".substr($archivos[3],12,200)."</a></td></tr>";

}
$resultado=$resultado."</table><br><br>";

if($TipT=='1')
{
	$resultado=$resultado."<table>";
	$resultado=$resultado."<tr> <th>CALLE Y NUM</th><th>COLONIA</th><th>DELEGACION</th><th>C.P.</th></tr>";
	$resultado=$resultado."<tr>	<td>".pg_result($Query1,9)."</td> <td>".pg_result($Query1,10)."</td><td>".pg_result($Query1,11)."</td><td>".pg_result($Query1,12)."</td> </tr>";
	$resultado=$resultado."</table><br><br>";
}

$resultado=$resultado."<table style=\"float: left; margin-right: 40px;\"><tr><td>Grupos de Cambio</td><td><select id='fgrupo'>";
while($row=pg_fetch_row($Gpos))
{
	$resultado=$resultado."<option value='".$row[0]."'>".$row[0]."</option>";
}
$resultado=$resultado."</select></td><td><input type='hidden' name='cuenta' id='fcuenta' value='$cuenta'><button type='button' class='Autoriza' value='9'>Cambiar</button></td></tr></table>";
$resultado=$resultado."<table style=\"float: left; margin-right: 40px;\"><tr><td><button type='button' class='Autoriza' value='0'>Denegar</button></td></tr></table>";
$resultado=$resultado."<table><tr><td><button type='button' id='cancela'>Cancelar</button></td></tr></table>";

echo $resultado;
pg_close();
} elseif($Tipo=='eliminar'){
	$carr=$_SESSION['carr'];
	$cuenta=$_POST['cuenta'];
	
//********************************************************
	//$conex = conex40($bdd);
	$conex = conex("p400");
//********************************************************
	//if(!$con = pg_connect("host=$Host user=$Usu dbname=$Base password=$Clave")){
	if(!$conex){
		die("No se pudo realizar la conexi&oacute;n: ".pg_last_error());
	}
	$sql="update pi".$Ano." set grupo_fin=grupo_asig,resulta='' where cuenta='$cuenta' and carrera='$carr'";
	$Query1=pg_query($sql) or die(pg_last_error());

	$sql="select grupo_fin,paterno,materno,nombre from pi".$Ano." where cuenta='$cuenta' and carrera='$carr'";
	$Query1=pg_query($sql) or die(pg_last_error());
	$row=pg_fetch_row($Query1);
	echo "El alumno $cuenta ".$row[1]." ".$row[2]." ".$row[3]." ha vuelto al grupo ".$row[0];
	pg_close();
}
?>