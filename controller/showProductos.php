<?php 
require_once('../models/PRODUCTOS.php');
	$cpp = new Productos();
	$prods = $cpp->show($_POST['id']);
	echo json_encode($prods);
?>