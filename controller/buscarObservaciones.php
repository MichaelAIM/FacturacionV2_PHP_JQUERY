<?php 
require_once('../models/OBSERVACIONES.php');
	$obs = new Observacion();
	$ob = $obs->buscar($_POST['id']);
	echo json_encode($ob);
?>