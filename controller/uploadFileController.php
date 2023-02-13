<?php   
session_start();
$receptor = $_SESSION['rut'];
require_once('../models/ADJUNTOS.php');

$adj = new Adjuntos();

$id = $_POST['idDocto']; 

/* Location */
$carpeta = "../adjuntos/".$id;

if (!file_exists($carpeta)) {
	mkdir($carpeta, 0777, true);
}

$countfiles = count($_FILES['file']['name']);
 // Looping all files
for($i=0;$i<$countfiles;$i++){
	$filename = $_FILES['file']['name'][$i];
	$location = "../adjuntos/".$id."/".$filename; 
	$ruta = "adjuntos/".$id."/".$filename; 
   // Upload file
	if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $location)){ 
		$send = array(
			"nombre" => $filename,
			"ruta" => $ruta,
			"responsable" => $receptor,
			"ip" => $_SERVER['REMOTE_ADDR'],
			"facturas_id" => $id,
		);
		$prods = $adj->Ingresar($send);      
	}
}
?>



