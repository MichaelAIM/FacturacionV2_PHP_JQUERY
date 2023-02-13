<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$facts = $Factura->facturas_has_documentos($_POST['id']);
	$facts['cantidad'] = $Factura->count_notas_credito($_POST['id']);
	// highlight_string(print_r($facts,true));
	echo json_encode($facts);
?>