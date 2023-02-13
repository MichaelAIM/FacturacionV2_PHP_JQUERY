<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$cc = $Factura->ListarCC();
?>