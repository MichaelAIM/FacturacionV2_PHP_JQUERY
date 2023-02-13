<?php 
require_once('../models/LOG_CAMBIOSDEESTADOS.php');
require_once('../models/ASIGNACIONES.php');
require_once('../models/FACTORING.php');

$log = new Log();
$asg = new Asignar();
$factor = new Factoring();

$facts = $log->buscar($_POST['id']);
$asignar = $asg->buscar_IDFactura($_POST['id']);
$Factoring = $factor->buscar_factoring($_POST['id']);

$send = array_merge_recursive(((count($facts) > 0) ? $facts : array()), ((count($asignar) > 0) ? $asignar : array()), ((count($Factoring) > 0) ? $Factoring : array()));

echo json_encode($send);
?>