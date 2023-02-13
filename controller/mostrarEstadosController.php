<?php 
require_once('../models/LOG_CAMBIOSDEESTADOS.php');
	$log = new Log();
	$facts = $log->BuscarEstadosFacturas();
	echo json_encode($facts);
?>