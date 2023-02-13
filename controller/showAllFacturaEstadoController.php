<?php
@session_start();
	$permisos = $_SESSION['permiso'];
	if(strpos(strtoupper($_SERVER['SCRIPT_FILENAME']),'INDEX.PHP') !== FALSE){
		$prefix = '';
	}else{
		$prefix = '../';
	}
	require_once($prefix.'models/FACTURA.php');
	$arr_estados = array();
	array_push($arr_estados, 1);
	
	if(in_array(172, $permisos)){
		array_push($arr_estados, 2);
	}
	if(in_array(173, $permisos)){
		array_push($arr_estados, 3);
	}
	if(in_array(174, $permisos)){
		array_push($arr_estados, 4);
	}
	$esp = implode(',',$arr_estados); // "1,2,3"
	$fct = new Factura();
	$facturas = $fct->index($esp);
	$f = $facturas['facturas'];
	$arr_rojas = array();
	$cfr = 0;
	for ($i=0; $i <count($f) ; $i++) { 
		$estFact = $f[$i]['estados_facturas_id'];
		$time1= $f[$i]['fecha_factura'];
		$time2= date('Y-m-d'); 
		$epoch1 = strtotime($time1);
		$epoch2 = strtotime($time2); 
		$diff_seconds = $epoch2-$epoch1; 
		$diff_days = floor($diff_seconds/86400);
		if ($diff_days > 30 && $estFact < 5){
			$cfr  = $cfr + 1;
			array_push($arr_rojas, $f[$i]);
		} 
	}
?>