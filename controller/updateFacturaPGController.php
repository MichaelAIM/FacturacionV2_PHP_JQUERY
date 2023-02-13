<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$Factura->insertFacturaPg($_POST['data']['id'],$_POST['data']['fpag'],$_POST['data']['movimiento']);
?>