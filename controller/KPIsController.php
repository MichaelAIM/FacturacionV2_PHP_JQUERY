<?php 
require_once('../models/FACTURA.php');
$fct = new Factura();
$kpiT = $fct->kpiTotal();
$kpi2 = $fct->kpi30();
$kpi3 = $fct->kpi31();
$kpi4 = $fct->kpi40();

$G30 = $kpi2['facturas'][0]['cantidad']*100/$kpiT['facturas'][0]['cantidad'];
$G3040 = $kpi3['facturas'][0]['cantidad']*100/$kpiT['facturas'][0]['cantidad'];
$G40 = $kpi4['facturas'][0]['cantidad']*100/$kpiT['facturas'][0]['cantidad'];

?>