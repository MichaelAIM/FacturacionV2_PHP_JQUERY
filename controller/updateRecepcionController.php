<?php
	session_start();
	// highlight_string(print_r($_POST,true));
	$proveedor = explode('-',$_POST['proveedor']);
	require_once('../models/FACTURA.php');
	require_once('../models/LOG_CAMBIOSDEESTADOS.php');
	$log = new log();
	$Factura = new Factura();
	$facts = $Factura->CompararFacturas($_POST['numfac'],$_POST['fecfac'],$proveedor[0],$_POST['valor']);
	// var_dump($facts);
	$linea = array(
		"tipo_documento" => 33,
		"n_documento" => $_POST['numfac'],
		"proveedor" => $_POST['proveedor'],
		"fecha_registro" => $_POST['fecRec'],
		"fecha_factura" => $_POST['fecfac'],
		"monto" => $_POST['valor'],
		"url" => '',
		"n_oc_portal" => '',
		"n_sigfe" => ''
	);
	if ($facts === false) {
		echo "La factura no esta ingresada";
		// $idFact = $Factura->registrar_factura($_POST,$_SESSION['rut'],$_SESSION['sesion']);
		$idFact = $Factura->registrar_factura($linea,5);	
		if ($idFact != '') {
			$log->Ingresar($idFact,$_SESSION['rut'],0,1,'NO');	
			$Factura->updateRecepcion($_POST['id_recepcion'],$idFact,$_POST['numfac']);
			$Factura->insert_log_recepcion($idFact,$_POST['numFOLD'],$_POST['id_recepcion'],$_SESSION['rut']);
			return true;
		}
	}else if($facts === 'error'){
		echo "La factura existe diferentes datos";
		return false;
	}else{
		echo "existe la factura";
		$Factura->updateRecepcion($_POST['id_recepcion'],$facts,$_POST['numfac']);
		$Factura->insert_log_recepcion($facts,$_POST['numFOLD'],$_POST['id_recepcion'],$_SESSION['rut']);
		return true;
	}
?>
