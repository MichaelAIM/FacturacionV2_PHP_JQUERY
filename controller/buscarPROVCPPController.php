<?php 
require_once('../models/PROVEEDORES.php');
	$cpp = new Proveedores();
	$prods = $cpp->buscar($_POST['dato'],$_POST['anio'],$_POST['monto']);
	echo json_encode($prods);
?>