<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	$facts = $Factura->documentos_por_funcionario('18313287-3');
	echo json_encode($facts);
?>