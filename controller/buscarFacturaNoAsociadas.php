<?php 
set_time_limit(0);
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$facts = $Factura->facturas_no_asignadas(1);
	echo json_encode($facts);
?>