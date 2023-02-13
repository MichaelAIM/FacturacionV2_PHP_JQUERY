<?php
set_time_limit(0);
@session_start();
$funcionario = $_SESSION['rut'];
$permisos = $_SESSION['permiso'];

if(strpos(strtoupper($_SERVER['SCRIPT_FILENAME']),'INDEX.PHP') !== FALSE){
	$prefix = '';
}else{
	$prefix = '../';
}
require_once($prefix.'models/FACTURA.php');

$fct = new Factura();

if(in_array(175, $permisos)){
	$facturas = $fct->indexFuncionarioJefatura();
	$facturas_r = $fct->indexFuncionarioJefatura_rechazadas();
	$facturas_extra = $fct->indexFuncionarioTesoreria_extrapresupuestarias();	
	$facturas_factoring = $fct->indexFuncionarioJefatura_factoring();	
}else{
	if(in_array(174, $permisos)){
		$facturas = $fct->indexFuncionarioTesoreria();
		$facturas_extra = $fct->indexFuncionarioTesoreria_extrapresupuestarias();
		$facturas_factoring = $fct->indexFuncionarioTesoreria_factoring();
	}else{
		$facturas = $fct->indexFuncionarioFinanzas($funcionario);
		$facturas_r = $fct->indexFuncionarioFinanzas_rechazadas($funcionario);
		$facturas_factoring = $fct->indexFuncionarioFinanzas_factoring($funcionario);
	}
}
// $Sin_asignar = $fct->kpi_sin_asignar();
// $enPlazo = $fct->kpi_en_plazo();
// $porVencer = $fct->kpi_por_vencer();
// $Vencidas = $fct->kpi_vencidas();
// $Total_F = $fct->kpiTotal();

$f = $facturas['facturas'];
$f_factoring = $facturas_factoring['facturas'];

if ($facturas_r['facturas'] != "") {
	$fr = $facturas_r['facturas'];
}
if ($facturas_extra['facturas'] != "") {
	$f_extra = $facturas_extra['facturas'];
}
?>
