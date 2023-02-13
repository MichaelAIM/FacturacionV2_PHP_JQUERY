<?php
if(strpos(strtoupper($_SERVER['SCRIPT_FILENAME']),'INDEX.PHP') !== FALSE){
	$prefix = '';
}else{
	$prefix = '../';
}
require_once($prefix.'models/FACTURA.php');
$fct = new Factura();
$facturas = $fct->solo_facturas();
$enPlazo = $fct->kpi_en_plazo_facturas();
$porVencer = $fct->kpi_por_vencer_facturas();
$Vencidas = $fct->kpi_vencidas_facturas();
$Total_F = $fct->kpiTotal_facturas();
$f = $facturas['facturas'];


	$ep_cant = obtenerPorcentaje($enPlazo['cantidad'], $Total_F['cantidad']);
	$pv_cant = obtenerPorcentaje($porVencer['cantidad'], $Total_F['cantidad']);
	$ve_cant = obtenerPorcentaje($Vencidas['cantidad'], $Total_F['cantidad']);

	$ep_monto = obtenerPorcentaje($enPlazo['suma'], $Total_F['suma']);
	$pv_monto = obtenerPorcentaje($porVencer['suma'], $Total_F['suma']);
	$ve_monto = obtenerPorcentaje($Vencidas['suma'], $Total_F['suma']);

	$todo = array(
		"facturas" => $f,
		"enPlazo_monto" => $ep_monto,
		"porVencer_monto" => $pv_monto,
		"vencidas_monto" => $ve_monto,
		"enPlazo_cant" => $ep_cant,
		"porVencer_cant" => $pv_cant,
		"vencidas_cant" => $ve_cant,
		"enPlazo" => $enPlazo['cantidad'],
		"porVencer" => $porVencer['cantidad'],
		"vencidas" => $Vencidas['cantidad'],
		"enPlazo_m" => str_replace(",",".",number_format($enPlazo['suma'])),
		"porVencer_m" => str_replace(",",".",number_format($porVencer['suma'])),
		"vencidas_m" => str_replace(",",".",number_format($Vencidas['suma'])),
		"total_F_cant" => $Total_F['cantidad'],
		"total_F_monto" => str_replace(",",".",number_format($Total_F['suma']))
	);


function obtenerPorcentaje($cantidad, $total) {
    $porcentaje = ((float)$cantidad * 100) / $total; // Regla de tres
    $porcentaje = round($porcentaje, 2);  // Quitar los decimales
    return $porcentaje;
}

echo json_encode($todo);
?>