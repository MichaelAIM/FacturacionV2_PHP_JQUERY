<?php
@session_start();
require_once('../models/FACTURA.php');
require_once('../models/LOG_ASOC_DOCUMENTOS.php');

$Log_asoc = new Log_asoc();
$factura = new Factura();
echo "<br> fact = ".$_POST['idf'];
echo "<br> recp = ".$_POST['recp'];
$log = $Log_asoc->Ingresar($_POST['idf'],$_POST['recp'],8,0,$_SESSION['rut']);
$fact = $factura->deleteAsocRecepcion($_POST['idf'], $_POST['recp']);
echo($fact);
?>