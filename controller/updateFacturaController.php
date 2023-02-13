<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$Factura->updateFactura($_POST);
?>