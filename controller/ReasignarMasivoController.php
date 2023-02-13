<?php
session_start();
require_once('../models/ASIGNACIONES.php');
$asg = new Asignar();
$docs = $_POST['data'];
$funcionario = $_POST['fun'];
// // var_dump(($_POST));
for ($x=0; $x < count($docs); $x++) { 
	$asignados = $asg->buscar_IDFactura($docs[$x]);
	for ($i=0; $i < count($asignados['asign']); $i++) { 
		$asg->actualizar_estado($asignados['asign'][$i]['id'],0);	
	}
	$asoc_existe = $asg->buscar_por_rut_doc($funcionario,$docs[$x]); 
	if ($asoc_existe != null) {
		$asg->actualizar_estado($asoc_existe,1);
	}else{
		$data = $asg->Ingresar($_SESSION['rut'],$funcionario,$docs[$x]);
	}
}
highlight_string(print_r($_POST,true));
?>