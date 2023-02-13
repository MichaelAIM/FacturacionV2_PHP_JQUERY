<?php 
session_start();
require_once('../models/ASIGNACIONES.php');
require_once('../models/LOG_CAMBIOSDEESTADOS.php');
require_once('../models/FACTURA.php');
require_once('../models/FUNCIONARIOS.php');
require_once('../models/PRODUCTOS.php');
require_once('../models/recepciones.php');
require_once('../models/CPP.php');
require_once('../models/OT.php');

$fct = new Factura();
$log = new log();
$asg = new Asignar();
$func = new Funcionarios();
$productos = new Productos();
$recepciones = new recepciones();
$cpp = new CPP();
$ot = new ot();

$funcionarios = $func->index();

$func_r2 = array();
for ($i=0; $i < count($funcionarios['funcionarios']); $i++) { 
	if ($funcionarios['funcionarios'][$i]['revision'] == 2) {
		array_push($func_r2, $funcionarios['funcionarios'][$i]['rut']);
	}
}

$est = $_POST['estado'];
$factura = $_POST['id'];
$rev = $_POST['reversar'];

$date2 = new DateTime('NOW');

if ($factura != '' && $est !='') {
	$date = $log->BuscarLastFecha($factura);
	$per = $asg->buscar_por_factura($factura);

	$func_asoc_1 = array(); //funvionarios tipo 1
	$func_asoc_2 = array(); //funvionarios tipo 2
	for ($i=0; $i < count($per['asign']); $i++) { 
		if ($per['asign'][$i]['revision'] == 1) {
			array_push($func_asoc_1, $per['asign'][$i]);
		}else{
			array_push($func_asoc_2, $per['asign'][$i]);
		}
	}

	if ($date) {
		$date1 = new DateTime($date);
		$diff = $date1->diff($date2);      
		$dias = $diff->days;
		$upt = $fct->updateEstado($factura, $est);
		if (isset($rev)) {
			if ($rev == 1) {
				$fct->updateEstadoDEVOLUCION($factura,1);
			}
		}else{
			$fct->updateEstadoDEVOLUCION($factura,"NULL");
		}

		$log->Ingresar($factura, $_SESSION['rut'], $dias, $est, 'NO');

		if ($per != NULL) {	
			if ($est == 2 || $est == 4) {
				for ($i=0; $i < count($func_asoc_2); $i++) { 
					$asg->actualizar_estado($func_asoc_2[$i]['id'],0);
				}
				if (count($func_asoc_1) < 1) {
					$data = $asg->Ingresar($_SESSION['rut'],$func_r2[$i],$factura);
				}else{
					for ($i=0; $i < count($func_asoc_1); $i++) {
						$funcR1 = $log->BuscarLOGenR1($factura); //vuelve al funcionario que mando a R2
						$asg->actualizar_estado($funcR1,1);
					}
				}
			}	
			if ($est == 3) {
				for ($i=0; $i < count($func_asoc_1); $i++) { 
					$asg->actualizar_estado($func_asoc_1[$i]['id'],0);
				}
				echo "Fr2 = ".count($func_asoc_2);
				if (count($func_asoc_2) < 1) {
					for ($i=0; $i < count($func_r2); $i++) { 
						$data = $asg->Ingresar($_SESSION['rut'],$func_r2[$i],$factura);
					}
				}else{
					for ($i=0; $i < count($func_asoc_2); $i++) { 
						$asg->actualizar_estado($func_asoc_2[$i]['id'],1);
					}
				}
			}
			if ($est == 5 || $est == 8 || $est == 9) {
				for ($i=0; $i < count($func_asoc_1); $i++) { 
					$asg->actualizar_estado($func_asoc_1[$i]['id'],0);
				}
				for ($i=0; $i < count($func_asoc_2); $i++) { 
					$asg->actualizar_estado($func_asoc_2[$i]['id'],0);
				}
			}
			if ($est == 7) {
				$ProdRCfacts = $fct->productos_a_pago($factura);
				$prod_has_fact = $ProdRCfacts['productos'];
				// highlight_string(print_r($prod_has_fact,true));
				$CPPs = array();
				$OTs = array();
				$Procesos = array();

				if ($prod_has_fact != NULL) {
					for ($i=0; $i < count($prod_has_fact); $i++) {
						$idProd = $prod_has_fact[$i]['id_producto'];

						if($prod_has_fact[$i]['pro_estado_producto'] == 7 || $prod_has_fact[$i]['pro_estado_producto'] == 11  || $prod_has_fact[$i]['pro_estado_producto'] == 12){	

							$rfi = $recepciones->buscar_facturas_impagas($idProd);
							echo $rfi;

							if($rfi != NULL){
								$productos->actualizar_Estado($idProd,12);							
							}
							else{
								$productos->actualizar_Estado($idProd,13);							
							} 

						}else if ($prod_has_fact[$i]['pro_estado_producto'] == 8 || $prod_has_fact[$i]['pro_estado_producto'] == 10){
							$productos->actualizar_Estado($idProd,12);
						}else{
							echo json_encode('error de sistema');
						}

						array_push($CPPs, $prod_has_fact[$i]['pro_id_cpp']);

						if ($prod_has_fact[$i]['pro_id_oc'] != '') {
							array_push($OTs, $prod_has_fact[$i]['pro_id_oc']);							
						}

						if ($prod_has_fact[$i]['pro_id_detalle_compra'] != '') {
							array_push($Procesos, $prod_has_fact[$i]['pro_id_detalle_compra']);							
						}
					}
				}

				$arrOTs = array_values(array_unique($OTs));
				$arrProcesos = array_values(array_unique($Procesos));
				$arrCPPs = array_values(array_unique($CPPs));
				
				// highlight_string(print_r($arrOTs,true));
				// highlight_string(print_r($arrProcesos,true));
				// highlight_string(print_r($arrCPPs,true));

				for ($i=0; $i < count($arrCPPs); $i++) { 
					$cpp_p = $productos->productos_cpp($arrCPPs[$i]);
					if ($cpp_p > 0) {
						$cpp->actualizar_Estado($arrCPPs[$i],10);
						echo "<br> entro cpp ".$arrCPPs[$i]." estado = 10 <br>";
					}else{
						$cpp->actualizar_Estado($arrCPPs[$i],11);
						echo "<br> entro cpp ".$arrCPPs[$i]." estado = 11 <br>";
					}
				}

				for ($i=0; $i < count($arrProcesos); $i++) { 
					$prod_proc = $productos->productos_proceso($arrProcesos[$i]);
					$proc_p = $prod_proc['productos'];
					if ($proc_p > 0) {
						$cpp->actualizar_Estado_Proceso($arrProcesos[$i],2);
						echo "<br> entro proceso ".$arrProcesos[$i]." estado = 2 <br>";
					}else{
						$cpp->actualizar_Estado_Proceso($arrProcesos[$i],3);
						echo "<br> entro proceso ".$arrProcesos[$i]." estado = 3 <br>";
					}
				}

				for ($i=0; $i < count($arrOTs); $i++) { 
					$prod_ot = $productos->productos_OT($arrOTs[$i]);
					$ot_p = $prod_ot['productos'];				
					if ($ot_p > 0) {
						$ot->actualizar_Estado($arrOTs[$i],13);
						echo "<br> entro OT ".$arrOTs[$i]." estado = 13 <br>";					
					}else{
						$ot->actualizar_Estado($arrOTs[$i],14);
						echo "<br> entro OT ".$arrOTs[$i]." estado = 14 <br>";
					}
				}
			}
		}
	}
}
?>
