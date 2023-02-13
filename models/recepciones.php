<?php 
require_once('conector.class.php');
class recepciones{

	public function __construct(){ 
	 }

	public function buscar($prov, $año){

		$sql = "SELECT recepcion_bodega.num_recepcion, recepcion_bodega.id_recepcion, recepcion_bodega.fecha_ingreso, recepcion_bodega.year_recepcion, recepcion_bodega.n_lic FROM recepcion_bodega WHERE recepcion_bodega.esta_pagada IS NULL AND  recepcion_bodega.proveedor = '".$prov."' AND recepcion_bodega.year_recepcion IN (".$año.")";

		$conector = new Conector();
		$conector->conectar('bodega_inventario');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['recep'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['recep'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function buscar_facturas_impagas($idProd){

		$sql = "SELECT Count(facturacionv2.documentos.id) AS facturas_impagas FROM bodega_inventario.recepcion_producto INNER JOIN facturacionv2.documento_has_recepcion ON bodega_inventario.recepcion_producto.id_recepcion = facturacionv2.documento_has_recepcion.id_recepcion_bodega INNER JOIN facturacionv2.documentos ON facturacionv2.documento_has_recepcion.id_documento = facturacionv2.documentos.id INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id WHERE bodega_inventario.recepcion_producto.id_producto = ".$idProd." AND facturacionv2.documentos.docto_estado_id < 6 AND facturacionv2.documentos.docto_tipo_id = 1 GROUP BY bodega_inventario.recepcion_producto.id_recepcion";

		$conector = new Conector();
		$conector->conectar('bodega_inventario');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0 && $cuantos != NULL){
			$response['recep'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['recep'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function buscar_adjuntos_facturasRC($idDoc){

		$sql = "SELECT bodega_inventario.adjuntos.adj_nombre, YEAR(bodega_inventario.adjuntos.adj_fecha) AS anio, MONTH(bodega_inventario.adjuntos.adj_fecha) AS mes, bodega_inventario.adjuntos.adj_id, bodega_inventario.recepcion_bodega.tipo_docto FROM facturacionv2.documento_has_recepcion  INNER JOIN bodega_inventario.recepcion_bodega ON facturacionv2.documento_has_recepcion.id_recepcion_bodega = bodega_inventario.recepcion_bodega.id_recepcion  LEFT JOIN bodega_inventario.adjuntos ON bodega_inventario.recepcion_bodega.id_recepcion = bodega_inventario.adjuntos.adj_id_registro WHERE facturacionv2.documento_has_recepcion.id_documento = ".$idDoc."  AND bodega_inventario.adjuntos.adj_adjuntado = 'V'";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['recep'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['recep'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function buscarReacepcionesCompletas(){

		$sql = "SELECT bodega_inventario.recepcion_bodega.id_recepcion FROM bodega_inventario.recepcion_bodega INNER JOIN ordenes_de_compras.cpp ON bodega_inventario.recepcion_bodega.id_cpp=ordenes_de_compras.cpp.cpp_id WHERE recepcion_bodega.estado_docto=1 AND bodega_inventario.recepcion_bodega.esta_pagada IS NULL AND ordenes_de_compras.cpp.cpp_estado=11 ORDER BY bodega_inventario.recepcion_bodega.id_cpp ASC";

		$conector = new Conector(true);
		$conector->conectar('bodega_inventario');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$ids = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($ids,$conector->recuperar_dato('id_recepcion'));
			}

			$sql = "UPDATE recepcion_bodega SET esta_pagada = 1 WHERE recepcion_bodega.id_recepcion IN  ( ".implode(',',$ids)." )";
			$conector->ejecutar($sql);

		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

}
?>
