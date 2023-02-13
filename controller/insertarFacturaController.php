<?php
session_start();
$resp = $_SESSION['rut'];

require_once('../models/FACTURA.php');
require_once('../models/LOG_CAMBIOSDEESTADOS.php');

$factura = new Factura();
$log = new log();

$recep = $datos['facturas'][0]['fecha_recibo'];
$start = new DateTime($recep);
$end = new DateTime();
$days = round(($end->format('U') - $start->format('U')) / (60*60*24));

$fact = $factura->Ingresar($_POST);
$log->Ingresar($fact,$resp,$days,1);
echo($fact);
?>