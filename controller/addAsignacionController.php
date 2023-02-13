<?php
session_start();
require_once('../models/ASIGNACIONES.php');
require_once('../models/LOG_CAMBIOSDEESTADOS.php');
require_once('../models/FACTURA.php');
$fct = new Factura();
$log = new log();
$asg = new Asignar();
$docs = $_POST['data'];
$funcionarios = $_POST['fun'];
$date2 = new DateTime('NOW');
// var_dump(($_POST));
for ($i=0; $i < count($docs); $i++) { 
	$date = $log->BuscarLastFecha($docs[$i]);
	if ($date) {
		$data = $asg->Ingresar($_SESSION['rut'],$funcionarios,$docs[$i]);
        $fct->updateAsignar($docs[$i]);
		$date1 = new DateTime($date);
		$diff = $date1->diff($date2);
		$dias = $diff->days;
		$log->Ingresar($docs[$i], $_SESSION['rut'], $dias, 2, 'NO');
		$fct->updateEstado($docs[$i], 2);
	}
}
?>
