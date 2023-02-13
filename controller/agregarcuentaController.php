<?php
@session_start();
require_once('../models/CUENTAs.php');
$cuenta=new CUENTAS();
$c=$cuenta->agregarcuenta($_POST['cuenta']);

echo json_encode($c);
?>