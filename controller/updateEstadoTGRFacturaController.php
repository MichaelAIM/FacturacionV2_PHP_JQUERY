<?php 
require_once('../models/FACTURA.php');
$fct = new Factura();
// var_dump($_POST);
$upt = $fct->updateEstadoTGR($_POST['id'], $_POST['est']);	
?>