<?php 

function getFecha()
{
$meses['01']="enero";
$meses['02']="febrero";
$meses['03']="marzo";
$meses['04']="abril";
$meses['05']="mayo";
$meses['06']="junio";
$meses['07']="julio";
$meses['08']="agosto";
$meses['09']="septiembre";
$meses['10']="octubre";
$meses['11']="noviembre";
$meses['12']="diciembre";

$dias['01'] = "1";
$dias['02'] = "2";
$dias['03'] = "3";
$dias['04'] = "4";
$dias['05'] = "5";
$dias['06'] = "6";
$dias['07'] = "7";
$dias['08'] = "8";
$dias['09'] = "9";

$dia = date("d");
$mes = date("m");
$mes = $meses[$mes];
$anio = date("Y");

if($dia < 10)
$dia = $dias[$dia];

$fecha =$dia." de ".$mes." del ".$anio;

return $fecha;
}
?>

