<?php 
require_once('../models/FACTURA.php');
	$Factura = new Factura();
	if ($_POST['data'] == 0) {
		$facts = $Factura->todas_las_facturas();
	}else if ($_POST['data'] == 1){
		$facts = $Factura->todas_otros_documentos();
	}else if ($_POST['data'] == 2){
        $facts = $Factura->todas_las_factura_antiguas();
    }
// echo " = ".$_POST['data'];
	echo json_encode($facts);
?>
