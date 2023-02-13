<?php
require_once('../models/conector.class.php');
date_default_timezone_set('America/Santiago');
$anio = $_GET['anio'];
// echo "año = ".$anio;
	$sql = 'SELECT pago_proveedores.facturas.factura_id AS id,pago_proveedores.facturas.factura_numero AS numero,pago_proveedores.facturas.factura_fecha_factura AS ffac,pago_proveedores.facturas.factura_fecha_pago AS fpago,pago_proveedores.facturas.factura_monto AS monto,TRIM(aba.proveedor.proveNombre) AS prov,CONVERT(GROUP_CONCAT( DISTINCT ordenes_de_compras.cpp.cpp_num SEPARATOR "-") USING "UTF8") AS cpp,CONVERT(GROUP_CONCAT( DISTINCT ordenes_de_compras.compra.compra_numero SEPARATOR "-") USING "UTF8") AS ot,CONVERT(GROUP_CONCAT( DISTINCT bodega_inventario.recepcion_bodega.num_recepcion SEPARATOR "-") USING "UTF8") AS recep FROM pago_proveedores.facturas INNER JOIN aba.proveedor ON pago_proveedores.facturas.factura_proveedor = aba.proveedor.proveRUT LEFT JOIN bodega_inventario.recepcion_bodega ON bodega_inventario.recepcion_bodega.id_factura = pago_proveedores.facturas.factura_id LEFT JOIN bodega_inventario.recepcion_producto ON bodega_inventario.recepcion_bodega.id_recepcion = bodega_inventario.recepcion_producto.id_recepcion LEFT JOIN ordenes_de_compras.cpp ON bodega_inventario.recepcion_bodega.id_cpp = ordenes_de_compras.cpp.cpp_id LEFT JOIN ordenes_de_compras.producto_compra ON bodega_inventario.recepcion_producto.id_producto = ordenes_de_compras.producto_compra.pro_id LEFT JOIN ordenes_de_compras.compra ON ordenes_de_compras.producto_compra.pro_id_oc = ordenes_de_compras.compra.compra_id WHERE DATE_FORMAT(facturas.factura_fecha_factura, "%Y") = '.$anio.' AND pago_proveedores.facturas.factura_eliminado = 1 GROUP BY pago_proveedores.facturas.factura_id';	
			
	$conector = new Conector();
	
	$conector->conectar('pago_proveedores');

	$conector->ejecutar($sql);
	
	$cuantos = $conector->recuperar_afectadas();
	if($cuantos > 0){
		$response['data'] = array();
		for($i = 0; $i < $cuantos; $i++){
			$conector->set_fila();
			array_push($response['data'],$conector->get_fila());
		}
	}else{
		$response['sql'] = $sql;
	}
	$conector->desconectar();

	$myJSON = json_encode($response);
	// highlight_string(print_r($myJSON,true));

	$filece = fopen($anio.".txt", "w+");
	fwrite($filece, $myJSON);
	fclose($filece);
	header("Content-Type: application/force-download");
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename = '.$anio.'.txt'); 
	readfile($anio.".txt");
?>