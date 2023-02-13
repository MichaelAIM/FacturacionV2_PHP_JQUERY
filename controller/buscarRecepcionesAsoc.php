<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$facts = $Factura->facturas_has_recepcion($_POST['id']);
	echo json_encode($facts);
?>