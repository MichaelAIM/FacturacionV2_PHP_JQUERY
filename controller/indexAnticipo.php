<?php 
require_once('../models/ANTICIPOS.php');
$ant = new Anticipo();
$datos = $ant->index();
$ff = $ant->index2();
$data = $datos['anticipo'];
$fondos_fijos = $ff['anticipo'];
$anticipos = array();
if ($data !="") {
	for($i = 0; $i < count($data); $i++){
		$idAnticipo = $data[$i]['id'];
		if(isset($anticipos[$idAnticipo])){
		}else{
			$anticipos[$idAnticipo]['id'] = $data[$i]['id'];
			$anticipos[$idAnticipo]['numero'] = $data[$i]['numero'];
			$anticipos[$idAnticipo]['monto'] = $data[$i]['monto'];
			$anticipos[$idAnticipo]['proveNombre'] = $data[$i]['proveNombre'];
			$anticipos[$idAnticipo]['cpp'] = $data[$i]['id_cpp'];
			$anticipos[$idAnticipo]['year'] = $data[$i]['year'];
			$anticipos[$idAnticipo]['adjuntos'] = array();
		}
		if ($data[$i]['adj_nombre'] != '') {
			if ($data[$i]['mes']<10) {
				$mes = '0'.$data[$i]['mes'];
			}else{
				$mes = $data[$i]['mes'];
			}
			$linea = array(
				'nombre_adjunto'  => $data[$i]['adj_nombre'],
				'mes'  => $mes,
				'year'  => $data[$i]['anio'],
				// 'tipo_doc'  => $data[$i]['tipo_docto'],
			);
			array_push($anticipos[$idAnticipo]['adjuntos'],$linea);			
		}
	}
	$anticipos = array_values($anticipos);
}
// highlight_string(print_r($anticipos,true));

?>