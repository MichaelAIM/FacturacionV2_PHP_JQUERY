<?php 
require_once('../models/ANTICIPOS.php');
require_once('../../intranet2.0/controller/seguridad.php');
$ant = new Anticipo();
$indice = explode(".", $_FILES['file']['name']);
$filename = encrypt($indice[0]).".".$indice[1];
// $filename = $_FILES['file']['name'];
/* Location */
$carpeta = "../comprobantes/";
if (!file_exists($carpeta)) {
	mkdir($carpeta, 0777, true);
}
$location = "../comprobantes/".$filename; 
$ruta = "comprobantes/".$filename;
$_POST['comprobante'] = $ruta;
/* Upload file */
if(move_uploaded_file($_FILES['file']['tmp_name'], $location)){ 
	if ($_POST['tipo'] == 1) {
		$ant->updateEstadoAnticipo($_POST);	
	}else{
		$ant->updateEstadoFFijo($_POST);
	}
}
?>