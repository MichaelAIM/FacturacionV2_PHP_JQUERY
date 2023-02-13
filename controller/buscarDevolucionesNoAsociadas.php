<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$facts = $Factura->facturas_no_asignadas(9);
	echo json_encode($facts);
?>