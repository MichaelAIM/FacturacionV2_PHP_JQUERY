<?php
session_start();
setlocale(LC_TIME,'spanish');
date_default_timezone_set('America/Santiago');
ini_set("memory_limit","512M");
set_time_limit(0);
require_once('../Excel/simplexlsx.class.php');
require_once('../models/FACTURA.php');
require_once('../models/LOG_CAMBIOSDEESTADOS.php');
require_once('../models/ASIGNACIONES.php');
require_once('../models/FACTORING.php');

$Factura = new Factura();
$log = new Log();
$asignar = new Asignar();
$factor = new Factoring();
// highlight_string(print_r($_FILES,true));
$archivo = explode(".", $_FILES['acepta']['name']);
if ($archivo[1] != 'xlsx') {
	$new_facturas = false;	
}else{
	move_uploaded_file($_FILES['acepta']['tmp_name'],'../Excel/PlanillasExcel/'.$_FILES['acepta']['name']);
	$xlsx = new SimpleXLSX('../Excel/PlanillasExcel/'.$_FILES['acepta']['name']);
	list($num_cols, $num_rows) = $xlsx->dimension(); 
	$datos = array_values(array_slice($xlsx->rows(),1));
	$new_facturas = array();
	for ($i=0; $i < count($datos); $i++) { 
		if (trim($datos[$i][5]) == "61.606.000-7") {
			$rut = str_replace('.', '', trim($datos[$i][3]));
			$ndoc = str_replace('.', '', trim($datos[$i][2]));
			$linea = array(
				"tipo_documento" => $datos[$i][0],
				"n_documento" => $ndoc,
				"proveedor" => $rut,
				"nombre_proveedor" => $datos[$i][4],
				"fecha_registro" =>unixstamp($datos[$i][6]),
				"fecha_factura" => unixstamp($datos[$i][7]),
				"monto" => $datos[$i][11],
				"url" => $datos[$i][17],
				"n_oc_portal" => $datos[$i][36],
				"n_sigfe" => $datos[$i][41]
			);
			if ($rut != '') {
				$idfactura = $Factura->registrar_factura2($linea,4);
			}
			if ($idfactura != '') {
				$log->Ingresar($idfactura,$_SESSION['rut'],0,1,'NO');
				$factor->asociar_factoring_2($idfactura, $ndoc, $rut, $datos[$i][11], $_SESSION['rut']);
				$linea['id'] = $idfactura;
				array_push($new_facturas, $linea);
			}
		}
	}
}

function unixstamp($excelDateTime) {
	$UNIX_DATE = ($excelDateTime - 25569) * 86400;
    return gmdate("Y-m-d", $UNIX_DATE);
}
echo json_encode($new_facturas);
?>
