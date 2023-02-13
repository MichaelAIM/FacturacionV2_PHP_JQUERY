<?php
@session_start();
require_once('../models/CUENTAs.php');
$cuenta=new CUENTAS();
$c=$cuenta->updatecuenta($_POST['cuenta'],$_POST['anticipo']);


?>