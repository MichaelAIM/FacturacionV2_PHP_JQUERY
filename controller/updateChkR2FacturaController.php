<?php 
require_once('../models/FACTURA.php');
$fct = new Factura();
// var_dump($_POST);
$upt = $fct->updateEstadoR2($_POST['id'], $_POST['est']);	
?>