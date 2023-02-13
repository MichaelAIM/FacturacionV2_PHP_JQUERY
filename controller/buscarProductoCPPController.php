<?php 
require_once('../models/PRODUCTOS.php');
	$cpp = new Productos();
	$prods = $cpp->buscarxCpp($_POST['CPP']);
	echo json_encode($prods);
?>