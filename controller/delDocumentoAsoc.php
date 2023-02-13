<?php
@session_start();
require_once('../models/FACTURA.php');
require_once('../models/LOG_ASOC_DOCUMENTOS.php');

$factura = new Factura();
$Log_asoc = new Log_asoc();


$tipo = $Log_asoc->BuscarTipoDoc($_POST['doc']);
if ($tipo) {
	$log = $Log_asoc->Ingresar($_POST['idf'],$_POST['doc'],$tipo,0,$_SESSION['rut']);
}

$fact = $factura->deleteAsocDocumento($_POST['idf'], $_POST['doc']);

echo($fact);
?>