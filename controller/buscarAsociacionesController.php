<?php 
require_once('../models/recepciones.php');
require_once('../models/FACTURA.php');
require_once('../models/ANTICIPOS.php');
$rcp = new recepciones();
$ant = new Anticipo();
$fac = new Factura();

$año_en_curso = date('Y');
$año_anterior = $año_en_curso-1;
$rut = explode("-", $_POST['proveedor']);
$fechas = $año_anterior.",".$año_en_curso;
$recepciones = $rcp->buscar($rut[0],$fechas);
$documentos = $fac->mostrarDocumentosProveedor($_POST['proveedor']);
$anticipos = $ant->BuscarAnticiposProveedor($_POST['proveedor']);
$dataR = array(
	"recepciones" => $recepciones,
	"documentos" => $documentos,
	"anticipos" => $anticipos,
	"id_factura" => $_POST['id']
);
echo json_encode($dataR);
?>