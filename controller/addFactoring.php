<?php 
session_start();
require_once('../models/FACTORING.php');
require_once('seguridad.php');
$factoring = new Factoring();
$adj = 1;
$filename = date('d-m-Y H-i-s');
$filename = $filename.'.pdf';
$carpeta = "../factoring";
if (!file_exists($carpeta)) {
	mkdir($carpeta, 0777, true);
}
$location = "../factoring/".$filename;
$_POST['session'] = $_SESSION['rut'];
$_POST['filename'] = $filename;
$idPROVFact = $factoring->buscar_Proveedor_factoring($_POST['cesionario'], $_POST['nombreCesionario'],$_SESSION['rut']);
if ($idPROVFact != "") {
	$_POST['idPROVFact'] = $idPROVFact;
	$new_factoring = $factoring->ingresar_factoring($_POST);
	if ($new_factoring != "") {
		$factoring->asociar_factoring($new_factoring, $_POST['inputNumFAct'], $_POST['inputProvFAct'], $_POST['inputMomFAct'], $_SESSION['rut']);
		echo json_encode(true);
	}else{
		echo json_encode(false);
		$adj == 0;	
	}
}else{
	echo json_encode(false);
	$adj == 0;
}

if ($adj == 1) {
	move_uploaded_file($_FILES['file']['tmp_name'], $location);
}
?>