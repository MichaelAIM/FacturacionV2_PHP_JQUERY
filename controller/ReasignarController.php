<?php
session_start();
require_once('../models/ASIGNACIONES.php');
$asg = new Asignar();
$doc = $_POST['data'];
$funcionario = $_POST['fun'];
// var_dump(($_POST));
$asignados = $asg->buscar_IDFactura($doc);
highlight_string(print_r($asignados,true));

for ($i=0; $i < count($asignados['asign']); $i++) { 
	$asg->actualizar_estado($asignados['asign'][$i]['id'],0);	
}

$asoc_existe = $asg->buscar_por_rut_doc($funcionario,$doc); 
if ($asoc_existe != null) {
	$asg->actualizar_estado($asoc_existe,1);
}else{
	$data = $asg->Ingresar($_SESSION['rut'],$funcionario,$doc);
}

?>