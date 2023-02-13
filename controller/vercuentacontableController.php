<?
@session_start();
require_once('../models/CUENTAS.php');

$cuenta=new CUENTAS();
$c=$cuenta->BuscarCuentas();

echo json_encode($c);


?>