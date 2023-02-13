<?php 
	if(strpos(strtoupper($_SERVER['SCRIPT_FILENAME']),'INDEX.PHP') !== FALSE){
		$prefix = '';
	}else{
		$prefix = '../';
	}
	require_once($prefix.'models/FACTURA.php');
	$Factura = new Factura();
	$facts = $Factura->Buscar($_POST['id']);
	echo json_encode($facts);
?>