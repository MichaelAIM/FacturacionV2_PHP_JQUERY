<?php 
require_once('../models/CPP.php');
	$cpp = new CPP();
	$prods = $cpp->buscar($_POST['id'],$_POST['dato']);
	echo json_encode($prods);
?>