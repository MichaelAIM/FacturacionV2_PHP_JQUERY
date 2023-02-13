<?php
	function ingresarLog($id){
		$resp = $_SESSION['rut'];
		require_once('../models/LOG_CAMBIOSDEESTADOS.php');
		$log = new log();
		$datos = $factura->buscar($id);
		$est = $datos['facturas'][0]['estados_facturas_id'];
		$recep = $datos['facturas'][0]['fecha_recibo'];
		$start = new DateTime($recep);
		$end = new DateTime();
		$days = round(($end->format('U') - $start->format('U')) / (60*60*24));
		$log->Ingresar($id,$resp,$days,$est);
	}
?>