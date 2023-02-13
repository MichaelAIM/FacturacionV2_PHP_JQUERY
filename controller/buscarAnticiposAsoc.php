<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$facts = $Factura->anticipos_has_documentos($_POST['id']);
	echo json_encode($facts);
?>