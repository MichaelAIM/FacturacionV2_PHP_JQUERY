<?php
session_start();
$receptor = $_SESSION['rut'];
//$receptor = '16467901-2';
require_once('../models/OBSERVACIONES.php');
$obs = new Observacion();
$observacion = $_POST['observacion'];
$tipo_obs = 1;
if ($_POST['tp'] != '') {
	$tipo_obs = $_POST['tp'];
}
$id = $_POST['factura'];
$send = array(
	"observacion" => $observacion,
	"responsable" => $receptor,
	"facturas_id" => $id,
	"tipo_obs" => $tipo_obs
);
$prods = $obs->Ingresar($send);
?>