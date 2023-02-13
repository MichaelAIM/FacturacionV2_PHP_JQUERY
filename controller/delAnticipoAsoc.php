<?php
@session_start();
require_once('../models/FACTURA.php');
$factura = new Factura();
$fact = $factura->deleteAsocAnticipo($_POST['idf']);
echo($fact);
?>