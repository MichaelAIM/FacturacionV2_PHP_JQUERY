<?php 
require_once('../models/PRODUCTOS.php');
	$cpp = new Productos();
	$prods = $cpp->agregarpermiso();

	for ($i=0; $i <count($prods) ; $i++) { 
		$c=$prods[$i]['per_rut'];

		$cpp->insertarpermiso($c,213);
	}
	echo json_encode($prods);
?>