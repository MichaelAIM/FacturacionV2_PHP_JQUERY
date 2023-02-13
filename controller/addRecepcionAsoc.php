<?php
@session_start();
require_once('../models/FACTURA.php');
require_once('../models/LOG_ASOC_DOCUMENTOS.php');

$Log_asoc = new Log_asoc();
$factura = new Factura();
$fact = $factura->registrar_fact_recep($_POST['recp'], $_POST['idf'], $_SESSION['rut']);
$log = $Log_asoc->Ingresar($_POST['idf'],$_POST['recp'],13,1,$_SESSION['rut']);
echo($fact);
?>