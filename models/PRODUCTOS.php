<?php 
require_once('conector.class.php');
	class Productos{
		public function __construct(){ 
		 }
		
		public function Index(){

		}
		
		public function agregarpermiso(){
		$sql="SELECT
		ssalud.funcionario_permiso.per_rut,
		ssalud.funcionario_permiso.per_sistema
		FROM
		ssalud.funcionario_permiso
		where ssalud.funcionario_permiso.per_sistema not in(173,175,193,199,174)";

		$conector = new Conector();
		$conector->conectar('ssalud');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$response = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response,$conector->get_fila());

				
			}
		}else{
			$response = $sql;
		}
		return $response;
		$conector->desconectar();



	}
	public function insertarpermiso($run,$permiso){
		
		$sql="INSERT INTO funcionario_permiso (per_rut,per_sistema) VALUES('$run',$permiso)";
		$conector = new Conector();
		$conector->conectar('ssalud');
		$conector->ejecutar($sql);

	}

		public function Buscar($cpp){
			$sql  = "SELECT PRODS_PAGADOS.pro_id,PRODS_PAGADOS.cpp_num,PRODS_PAGADOS.pro_nombre,PRODS_PAGADOS.id_estado_producto_nombre,PRODS_PAGADOS.pro_descripcion,PRODS_PAGADOS.Total,(PRODS_PAGADOS.pro_cantidad - PRODS_PAGADOS.FACT_PRODUCTO_PAGADO)  AS PENDIENTES FROM (SELECT producto_compra.pro_id,cpp.cpp_proveedor_nombre,cpp.cpp_num,producto_compra.pro_cantidad,producto_compra.pro_nombre,estado_producto.id_estado_producto_nombre,producto_compra.pro_descripcion,producto_compra.pro_costo_unitario_incluye_todo AS Total,SUM(IF(facturacion.facturas_has_producto_compra.cantidad IS NULL,0,facturacion.facturas_has_producto_compra.cantidad)) AS FACT_PRODUCTO_PAGADO FROM cpp INNER JOIN producto_compra ON producto_compra.pro_id_cpp = cpp.cpp_id INNER JOIN estado_producto ON producto_compra.pro_estado_producto = estado_producto.id_estado_producto LEFT JOIN facturacion.facturas_has_producto_compra ON producto_compra.pro_id = facturacion.facturas_has_producto_compra.producto_compra_id WHERE producto_compra.pro_estado_producto <> 11 AND cpp.cpp_id = ".$cpp['CPP']." GROUP BY producto_compra.pro_id) AS PRODS_PAGADOS";

			$conector = new Conector();
			$conector->conectar('ordenes_de_compras');
			$conector->ejecutar($sql);
			$cuantos = $conector->recuperar_afectadas();
			
			if($cuantos > 0){
				$response['prods'] = array();
				for($i = 0; $i < $cuantos; $i++){
					$conector->set_fila();
					array_push($response['prods'],$conector->get_fila());
				}
			}else{
				$response['sql'] = $sql;
			}
			
			$conector->desconectar();
			return($response);
		}

		public function show($id){
			$sql  = "SELECT bodega_inventario.recepcion_producto.cantidad_prod AS cantidad, ordenes_de_compras.cpp.cpp_num, bodega_inventario.recepcion_producto.valor_unitario AS pro_costo_unitario_incluye_todo, ordenes_de_compras.cpp.cpp_proveedor_nombre, ordenes_de_compras.compra.compra_numero, ordenes_de_compras.compra.compra_id, ordenes_de_compras.producto_compra.pro_id_cpp, bodega_inventario.recepcion_bodega.num_recepcion, bodega_inventario.recepcion_producto.id_recepcion, ordenes_de_compras.producto_compra.pro_nombre, facturacionv2.documento_has_recepcion.id_documento AS facturas_id, facturacionv2.documento_has_recepcion.id_recepcion_bodega AS recepcion_id FROM bodega_inventario.recepcion_bodega INNER JOIN bodega_inventario.recepcion_producto ON bodega_inventario.recepcion_producto.id_recepcion = bodega_inventario.recepcion_bodega.id_recepcion INNER JOIN ordenes_de_compras.producto_compra ON bodega_inventario.recepcion_producto.id_producto = ordenes_de_compras.producto_compra.pro_id INNER JOIN ordenes_de_compras.cpp ON ordenes_de_compras.producto_compra.pro_id_cpp = ordenes_de_compras.cpp.cpp_id LEFT JOIN ordenes_de_compras.compra ON ordenes_de_compras.producto_compra.pro_id_oc = ordenes_de_compras.compra.compra_id INNER JOIN facturacionv2.documento_has_recepcion ON facturacionv2.documento_has_recepcion.id_recepcion_bodega = bodega_inventario.recepcion_bodega.id_recepcion WHERE facturacionv2.documento_has_recepcion.id_documento = ".$id;

			$conector = new Conector();
			$conector->conectar('facturacion');
			$conector->ejecutar($sql);
			$cuantos = $conector->recuperar_afectadas();
			
			if($cuantos > 0){
				$response['prods'] = array();
				for($i = 0; $i < $cuantos; $i++){
					$conector->set_fila();
					array_push($response['prods'],$conector->get_fila());
				}
			}else{
				$response['sql'] = $sql;
			}
			
			$conector->desconectar();
			return($response);
		}

		public function buscarxCpp($id){
			$sql  = "SELECT ordenes_de_compras.producto_compra.pro_id,ordenes_de_compras.cpp.cpp_proveedor_nombre,ordenes_de_compras.producto_compra.pro_nombre,presupuesto.gasto_presupuestario.gasto_pre_monto,ordenes_de_compras.producto_compra.pro_cantidad,ordenes_de_compras.producto_compra.pro_precio,ordenes_de_compras.producto_compra.pro_descripcion,ordenes_de_compras.estado_producto.id_estado_producto_nombre,ordenes_de_compras.cpp.cpp_num,SUM(IF(facturacion.facturas_has_producto_compra.cantidad IS NULL,0, facturacion.facturas_has_producto_compra.cantidad)) AS PRODUCTO_PAGADO FROM ordenes_de_compras.cpp INNER JOIN ordenes_de_compras.producto_compra ON ordenes_de_compras.cpp.cpp_id = ordenes_de_compras.producto_compra.pro_id_cpp INNER JOIN presupuesto.gasto_presupuestario ON ordenes_de_compras.producto_compra.pro_id = presupuesto.gasto_presupuestario.gasto_pre_id_producto  INNER JOIN ordenes_de_compras.estado_producto ON ordenes_de_compras.estado_producto.id_estado_producto = ordenes_de_compras.producto_compra.pro_estado_producto LEFT JOIN facturacion.facturas_has_producto_compra ON facturacion.facturas_has_producto_compra.producto_compra_id = ordenes_de_compras.producto_compra.pro_id WHERE ordenes_de_compras.cpp.cpp_id = ".$id." AND ordenes_de_compras.producto_compra.pro_estado_producto IN (7,8,10,11,12) GROUP BY producto_compra.pro_id";

			$conector = new Conector();
			$conector->conectar('facturacion');
			$conector->ejecutar($sql);
			$cuantos = $conector->recuperar_afectadas();
			
			if($cuantos > 0){
				$response['prods'] = array();
				for($i = 0; $i < $cuantos; $i++){
					$conector->set_fila();
					array_push($response['prods'],$conector->get_fila());
				}
			}else{
				$response['sql'] = $sql;
			}
			
			$conector->desconectar();
			return($response);
		}

		public function Ingresar($post,$id){
		 	$sql  = 'INSERT';
			$sql .= ' INTO';
			$sql .= ' facturas_has_producto_compra';
			$sql .= ' (';
			$sql .= ' facturas_id,';
			$sql .= ' producto_compra_id,';
			$sql .= ' cantidad';			
			$sql .= ' )';
			$sql .= ' VALUES';
			$sql .= ' (';
			$sql .= ''.$id.','; 
			$sql .= ''.$post['idpro'].',';
			$sql .= ''.$post['cantidad'];
			$sql .= ')';

			$conector = new Conector();	
			$conector->conectar('facturacion');
			$conector->ejecutar($sql);
			$cuantos = $conector->recuperar_afectadas_insert();
			if($cuantos > 0){
				$respuesta = $conector->recuperar_ultimo_id();
			}else{
				$respuesta = 'false';
			}
			$conector->desconectar();
			return($respuesta);
		}

		public function actualizar_Estado($idProd,$estado){
			$conector = new Conector();			
			$conector->conectar('ordenes_de_compras');
			$sql = "UPDATE producto_compra SET";
			$sql .=" pro_estado_producto = ".$estado;
			$sql .=" WHERE pro_id = ".$idProd;
			$conector->ejecutar($sql);
			$conector->desconectar();
		}

		public function productos_cpp($id){
			$sql = "SELECT Count(producto_compra.pro_id) AS cppPagados FROM `producto_compra` WHERE producto_compra.pro_id_cpp = ".$id." AND producto_compra.pro_estado_producto <> 13";

			$conector = new Conector();
			$conector->conectar('ordenes_de_compras');
			$conector->ejecutar($sql);
			$cuantos = $conector->recuperar_afectadas();

			if($cuantos > 0){
				$conector->set_fila();
				$response = $conector->recuperar_dato('cppPagados');				
			}else{
				$response = NULL;
			}

			$conector->desconectar();
			return($response);
		}

		public function productos_OT($id){
			$sql = "SELECT Count(producto_compra.pro_id) AS PRODotInpagas FROM `producto_compra` WHERE producto_compra.pro_id_oc = ".$id." AND producto_compra.pro_estado_producto <> 13";
			$conector = new Conector();
			$conector->conectar('ordenes_de_compras');		
			$conector->ejecutar($sql);				
			$cuantos = $conector->recuperar_afectadas();
			if($cuantos > 0){
				$response['productos'] = array();
				$conector->set_fila();
				$response['productos'] = $conector->recuperar_dato('PRODotInpagas');
		
			}

			$conector->desconectar();
			return($response);
		}

		public function productos_proceso($id){
			$sql = "SELECT Count(producto_compra.pro_id) AS PRODprocesosImpagas FROM `producto_compra` WHERE producto_compra.pro_id_detalle_compra = ".$id." AND producto_compra.pro_estado_producto <> 13";
			$conector = new Conector();
			$conector->conectar('ordenes_de_compras');		
			$conector->ejecutar($sql);				
			$cuantos = $conector->recuperar_afectadas();
			if($cuantos > 0){
				$response['productos'] = array();
				$conector->set_fila();
				$response['productos'] = $conector->recuperar_dato('PRODprocesosImpagas');		
			}

			$conector->desconectar();
			return($response);
		}

		public function Eliminar($id){
		
		}
	}
?>