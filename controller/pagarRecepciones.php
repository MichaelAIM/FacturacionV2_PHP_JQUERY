<?php 
require_once('../models/recepciones.php');
	$rep = new recepciones();
	$recep = $rep->buscarReacepcionesCompletas();
?>
