<?php 
require_once('models/conector.class.php');

$dato = $_GET['data'];

$sql  = "SELECT facturacionv2.documentos.numero, aba.proveedor.proveNombre, facturacionv2.documentos.proveedor_rut, facturacionv2.documentos.monto, facturacionv2.documentos.fecha_factura, bodega_inventario.recepcion_bodega.id_cpp FROM facturacionv2.documentos INNER JOIN facturacionv2.documento_has_recepcion ON facturacionv2.documentos.id = facturacionv2.documento_has_recepcion.id_documento INNER JOIN bodega_inventario.recepcion_bodega ON facturacionv2.documento_has_recepcion.id_recepcion_bodega = bodega_inventario.recepcion_bodega.id_recepcion INNER JOIN aba.proveedor ON aba.proveedor.proveRUT = facturacionv2.documentos.proveedor_rut WHERE facturacionv2.documentos.id = ".$dato;
//echo $sql.'<br />';
$conector = new Conector();
$conector->conectar('facturacionv2');
$conector->ejecutar($sql);
$cuantos = $conector->recuperar_afectadas();
if($cuantos > 0){
	$response['data'] = array();
	for($i = 0; $i < $cuantos; $i++){
		$conector->set_fila();
		array_push($response['data'],$conector->get_fila());
	}
}else{
	$response['data'] = NULL;
}
$datosFactura = $response['data'];
$data = array();

for ($x=0; $x < count($datosFactura); $x++) {

	$sql2 = "SELECT ordenes_de_compras.cpp.cpp_id, ordenes_de_compras.cpp.cpp_num, ordenes_de_compras.cpp.cpp_amio, presupuesto.gasto_presupuestario.gasto_pre_sigfe, presupuesto.gasto_presupuestario.gasto_pre_sub_sigfe, presupuesto.centro_de_responsabilidad.cr_nombre, presupuesto.centro_de_costo.cc_nombre, presupuesto.gasto_presupuestario.gasto_pre_monto, presupuesto.cuentas_sigfe.sigfe_nombre FROM ordenes_de_compras.cpp INNER JOIN presupuesto.gasto_presupuestario ON ordenes_de_compras.cpp.cpp_id = presupuesto.gasto_presupuestario.gasto_pre_id_cpp INNER JOIN presupuesto.centro_de_costo ON presupuesto.gasto_presupuestario.gasto_pre_id_cc = presupuesto.centro_de_costo.cc_id INNER JOIN presupuesto.centro_de_responsabilidad ON presupuesto.gasto_presupuestario.gasto_pre_id_cr = presupuesto.centro_de_responsabilidad.cr_id INNER JOIN presupuesto.cuentas_sigfe ON presupuesto.gasto_presupuestario.gasto_pre_sigfe = presupuesto.cuentas_sigfe.sigfe_id AND presupuesto.gasto_presupuestario.gasto_pre_sub_sigfe = presupuesto.cuentas_sigfe.sigfe_id_sub_item WHERE ordenes_de_compras.cpp.cpp_id = ".$datosFactura[$x]['id_cpp'];
//echo $sql2.'<br />';
	echo "<br>";	
	$conector->ejecutar($sql2);
	$cuantos2 = $conector->recuperar_afectadas();

	if($cuantos2 > 0){
		for($i = 0; $i < $cuantos2; $i++){
			$conector->set_fila();
			array_push($data,$conector->get_fila());
		}
	}

}
$dataPresupuestaria = array();
if ($data !="") {
	for($i = 0; $i < count($data); $i++){
		$idData = $data[$i]['cpp_id'];
		if(isset($dataPresupuestaria[$idData])){
		}else{
			$dataPresupuestaria[$idData]['cpp_id'] = $data[$i]['cpp_id'];
			$dataPresupuestaria[$idData]['cpp_num'] = $data[$i]['cpp_num'];
			$dataPresupuestaria[$idData]['cpp_amio'] = $data[$i]['cpp_amio'];
			$dataPresupuestaria[$idData]['presupuesto'] = array();
		}
		if (isset($dataPresupuestaria[$idData]['presupuesto'])) {
			$linea = array(
				'gasto_pre_sigfe'  => $data[$i]['gasto_pre_sigfe'],
				'gasto_pre_sub_sigfe'  => $data[$i]['gasto_pre_sub_sigfe'],
				'cr_nombre'  => $data[$i]['cr_nombre'],
				'cc_nombre'  => $data[$i]['cc_nombre'],
				'gasto_pre_monto'  => $data[$i]['gasto_pre_monto'],
				'sigfe_nombre'  => $data[$i]['sigfe_nombre']
			);
			array_push($dataPresupuestaria[$idData]['presupuesto'],$linea);		
		}
	}
}
$dataPresupuestaria = array_values($dataPresupuestaria);

// highlight_string(print_r($datosFactura,true));
// highlight_string(print_r($data,true));
// highlight_string(print_r($dataPresupuestaria,true));
$conector->desconectar();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
	<title>Document</title>
</head>
<body>
	<?php 
	if ($datosFactura != NULL) {
		$fecha_factura = date("d/m/Y", strtotime($datosFactura[0]['fecha_factura']));
		?>
		<div class="container">
			<div class="row">
				<div class="col-10 offset-1">
					<h3>Datos para crear compromiso sigfe</h3>					
					<div class="card my-4">
						<div class="card-header bg-primary text-white">
							Datos del Documento
						</div>
						<div class="card-body">
							<div class="row g-3 align-items-center">
								<div class="col-3">
									<label class="col-form-label">Numero de documento</label>
								</div>
								<div class="col-3">
									<input class="form-control" value="<?=$datosFactura[0]['numero'];?>">
								</div>
								<div class="col-3">
									<label class="col-form-label">Total del documento</label>
								</div>
								<div class="col-3">
									<input class="form-control" value="<?=$datosFactura[0]['monto'];?>">
								</div>					
								<div class="col-3">
									<label class="col-form-label">Rut Proveedor</label>
								</div>
								<div class="col-3">
									<input class="form-control" value="<?=$datosFactura[0]['proveedor_rut'];?>">
								</div>
								<div class="col-3">
									<label class="col-form-label">Fecha Documento</label>
								</div>
								<div class="col-3">
									<input class="form-control" value="<?=$fecha_factura;?>">
								</div>					
								<div class="col-3">
									<label class="col-form-label">Nombre Proveedor</label>
								</div>
								<div class="col-9">
									<input class="form-control" value="<?=$datosFactura[0]['proveNombre'];?>">
								</div>								
							</div>
						</div>
					</div>
					<div class="card my-4">
						<div class="card-header bg-primary text-white">
							Datos del CPP
						</div>
						<div class="card-body">
							<?php for ($i=0; $i < count($dataPresupuestaria); $i++) { 
								$Total = 0;
							?>
								<div class="row g-3 align-items-center">
									<legend class="text-center"> CPP : <?=$dataPresupuestaria[$i]['cpp_num'];?>  -  AÑO: <?=$dataPresupuestaria[$i]['cpp_amio'];?></legend>
									<table class="table table-striped table-hover mb-5">
										<thead>
											<tr>
												<th>ITEM</th>
												<th>SUB. ITEM</th>
												<th>NOMBRE CUENTA</th>
												<th>C.R.</th>
												<th>C.C.</th>
												<th>$ GASTO</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($x=0; $x < count($dataPresupuestaria[$i]['presupuesto']); $x++) { ?>
												<tr>
													<td><?=$dataPresupuestaria[$i]['presupuesto'][$x]['gasto_pre_sigfe'];?></td>
													<td><?=$dataPresupuestaria[$i]['presupuesto'][$x]['gasto_pre_sub_sigfe'];?></td>
													<td><?=$dataPresupuestaria[$i]['presupuesto'][$x]['sigfe_nombre'];?></td>
													<td><?=$dataPresupuestaria[$i]['presupuesto'][$x]['cr_nombre'];?></td>
													<td><?=$dataPresupuestaria[$i]['presupuesto'][$x]['cc_nombre'];?></td>
													<td><?=str_replace(",",".",number_format($dataPresupuestaria[$i]['presupuesto'][$x]['gasto_pre_monto']));?></td>
												</tr>
											<?php 
										$Total = $Total + $dataPresupuestaria[$i]['presupuesto'][$x]['gasto_pre_monto'];
										}
											?>
										</tbody>
										<tfoot>
											<tr>
												<th colspan="5" style="text-align: right;">Total</th>
												<th><?=str_replace(",",".",number_format($Total));?></th>
											</tr>
										</tfoot>
									</table>
								</div>
								<?php 
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}else{
	?>
	<h4>No existen datos</h4>
.</h4>
<?php 
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(document).ready( function () {
		$('#table_id').DataTable();
	} );
</script>
</body>
</html>