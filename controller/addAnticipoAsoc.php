<?php
@session_start();
require_once('../models/FACTURA.php');

$factura = new Factura();

$fact = $factura->registrar_anticipo_doc($_POST['idf'], $_POST['doc'], $_SESSION['rut']);

echo($fact);
?>