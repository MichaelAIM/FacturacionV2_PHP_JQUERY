<?php 
require_once('../models/ADJUNTOS.php');
require_once('../models/CPP.php');
require_once('../models/recepciones.php');
require_once('../models/FACTORING.php');
	$obs = new Adjuntos();
	$recep = new recepciones();
	$cpp = new CPP();
	$factoring = new Factoring();

	$adj = $obs->buscar($_POST['id']);
	$rc = $recep->buscar_adjuntos_facturasRC($_POST['id']);
	$cp = $cpp->buscar_adjuntos_facturasCpp($_POST['id']);
	$factor = $factoring->buscar_factoring($_POST['id']);

	$ob = array_merge(((count($adj) > 0) ? $adj : array()), ((count($rc) > 0) ? $rc : array()), ((count($cp) > 0) ? $cp : array()), ((count($factor) > 0) ? $factor : array()));

	echo json_encode($ob);
?>