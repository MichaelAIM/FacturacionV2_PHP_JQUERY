<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$facts = $Factura->BuscarRecepciones($_POST['id'],$_POST['year']);
	echo json_encode($facts);
?>