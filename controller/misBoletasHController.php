<?php
@session_start();
	$funcionario = $_SESSION['rut'];
	$permisos = $_SESSION['permiso'];
	$index = explode("/", $_SERVER['PHP_SELF']);
	if($index[3] === "index.php"){
		require_once('models/FACTURA.php');
	}else{
		require_once('../models/FACTURA.php');
	}

	$fct = new Factura();
	$facturas = $fct->indexBoletasHonorarios();

	$f = $facturas['facturas'];
?>