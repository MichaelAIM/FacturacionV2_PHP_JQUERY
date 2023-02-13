<?php
@session_start();
require_once('conector.class.php');
class Factura{
	public function __construct(){ 
	}

	public function solo_mis_facturas($rut){

		$sql = 'SELECT "FACTURA" AS "TIPO",facturacionv2.documentos.numero AS "Factura N°",aba.proveedor.proveNombre AS "Proveedor",facturacionv2.documentos.monto,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.fecha_recepcion AS "fecha_recepcion",facturacionv2.documento_estado.estado,facturacionv2.observaciones.detalle AS "observacion",facturacionv2.funcionario_facturacion.nombre AS per_nombre, facturacionv2.documentos.ocportal, facturacionv2.documentos.proveedor_rut FROM facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.documentos.id=facturacionv2.asignaciones.id_documentos AND facturacionv2.asignaciones.estado=1 INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario=facturacionv2.funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut LEFT JOIN facturacionv2.observaciones ON documentos.id=facturacionv2.observaciones.id_documento WHERE facturacionv2.documentos.docto_tipo_id=1 AND facturacionv2.documentos.docto_estado_id IN (2,3,4,5,6) AND facturacionv2.funcionario_facturacion.rut = "'.$rut.'" GROUP BY facturacionv2.documentos.id';
		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexFuncionarioFinanzas($rut){

		$sql = "SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, facturacionv2.documentos.monto, facturacionv2.documentos.fecha_factura, facturacionv2.documentos.r2, facturacionv2.documentos.fecha_recepcion, facturacionv2.documentos.ocportal, facturacionv2.documento_estado.estado, facturacionv2.documentos.n_sigfe_devengo, facturacionv2.documento_has_recepcion.id_recepcion_bodega, aba.proveedor.proveNombre,facturacionv2.documentos.link, facturacionv2.documento_tipo.tipo, facturacionv2.documentos.devolucion, facturacionv2.documentos.docto_estado_id FROM facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.asignaciones.id_documentos = facturacionv2.documentos.id INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario = facturacionv2.funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id = facturacionv2.documentos.docto_tipo_id LEFT JOIN facturacionv2.documento_has_recepcion ON facturacionv2.documento_has_recepcion.id_documento = facturacionv2.documentos.id LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT WHERE facturacionv2.asignaciones.funcionario = '".$rut."' AND facturacionv2.documentos.docto_tipo_id IN (1,14,5,6,7,9,10,12,15) AND facturacionv2.documentos.docto_estado_id < 6 AND facturacionv2.asignaciones.estado = 1 AND ISNULL(facturacionv2.documentos.factoring) GROUP BY facturacionv2.documentos.id ORDER BY facturacionv2.documentos.fecha_factura ASC";
		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexFuncionarioFinanzas_rechazadas($rut){

		$sql = "SELECT 	facturacionv2.documentos.id, 	facturacionv2.documentos.numero, 	facturacionv2.documentos.monto, 	facturacionv2.documentos.fecha_factura, 	facturacionv2.documentos.r2, 	facturacionv2.documentos.fecha_recepcion, 	facturacionv2.documentos.ocportal, 	facturacionv2.documento_estado.estado, 	facturacionv2.documentos.n_sigfe_devengo, 	facturacionv2.documento_has_recepcion.id_recepcion_bodega, 	aba.proveedor.proveNombre, 	facturacionv2.documentos.link, 	facturacionv2.documento_tipo.tipo, 	facturacionv2.documentos.devolucion, 	facturacionv2.documentos.docto_estado_id FROM 	facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.asignaciones.id_documentos = facturacionv2.documentos.id INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario = facturacionv2.funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id = facturacionv2.documentos.docto_tipo_id LEFT JOIN facturacionv2.documento_has_recepcion ON facturacionv2.documento_has_recepcion.id_documento = facturacionv2.documentos.id LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT WHERE 	facturacionv2.asignaciones.funcionario = '".$rut."' AND facturacionv2.documentos.docto_tipo_id IN (1, 14, 5, 6, 7, 9, 10, 12, 15) AND facturacionv2.documentos.docto_estado_id = 6 AND facturacionv2.asignaciones.estado = 1 GROUP BY 	facturacionv2.documentos.id ORDER BY 	facturacionv2.documentos.fecha_factura ASC";
		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexFuncionarioTesoreria(){

		$sql = "SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, facturacionv2.documentos.monto,  facturacionv2.documentos.fecha_factura, facturacionv2.documentos.fecha_recepcion, facturacionv2.documentos.ocportal,  facturacionv2.documento_estado.estado, facturacionv2.documentos.n_sigfe_devengo,  facturacionv2.documento_has_recepcion.id_recepcion_bodega, aba.proveedor.proveNombre,  facturacionv2.documentos.docto_estado_id,facturacionv2.documentos.link, facturacionv2.documento_tipo.tipo, facturacionv2.documentos.tgr   FROM facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.asignaciones.id_documentos = facturacionv2.documentos.id  INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario = facturacionv2.funcionario_facturacion.rut  INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id  INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id = facturacionv2.documentos.docto_tipo_id  LEFT JOIN facturacionv2.documento_has_recepcion ON facturacionv2.documento_has_recepcion.id_documento = facturacionv2.documentos.id  LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT  WHERE facturacionv2.documentos.docto_tipo_id IN (1,14,5,6,7,9,10,12,15) AND ISNULL(facturacionv2.documentos.extra_presupuestaria) AND facturacionv2.documentos.docto_estado_id = 5  AND facturacionv2.documentos.mostrarEnBandeja = 1 AND ISNULL(facturacionv2.documentos.factoring) GROUP BY facturacionv2.documentos.id ORDER BY facturacionv2.documentos.fecha_factura ASC";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexFuncionarioFinanzas_factoring($rut){

		$sql = "SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, facturacionv2.documentos.monto, facturacionv2.documentos.fecha_factura, facturacionv2.documentos.r2, facturacionv2.documentos.fecha_recepcion, facturacionv2.documentos.ocportal, facturacionv2.documento_estado.estado, facturacionv2.documentos.n_sigfe_devengo, facturacionv2.documento_has_recepcion.id_recepcion_bodega, aba.proveedor.proveNombre,facturacionv2.documentos.link, facturacionv2.documento_tipo.tipo, facturacionv2.documentos.devolucion, facturacionv2.documentos.docto_estado_id FROM facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.asignaciones.id_documentos = facturacionv2.documentos.id INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario = facturacionv2.funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id = facturacionv2.documentos.docto_tipo_id LEFT JOIN facturacionv2.documento_has_recepcion ON facturacionv2.documento_has_recepcion.id_documento = facturacionv2.documentos.id LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT WHERE facturacionv2.asignaciones.funcionario = '".$rut."' AND facturacionv2.documentos.docto_tipo_id IN (1,14,5,6,7,9,10,12,15) AND facturacionv2.documentos.docto_estado_id < 6 AND facturacionv2.asignaciones.estado = 1 AND facturacionv2.documentos.factoring = 1 GROUP BY facturacionv2.documentos.id ORDER BY facturacionv2.documentos.fecha_factura ASC";
		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexFuncionarioTesoreria_factoring(){

		$sql = "SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, facturacionv2.documentos.monto,  facturacionv2.documentos.fecha_factura, facturacionv2.documentos.fecha_recepcion, facturacionv2.documentos.ocportal,  facturacionv2.documento_estado.estado, facturacionv2.documentos.n_sigfe_devengo,  facturacionv2.documento_has_recepcion.id_recepcion_bodega, aba.proveedor.proveNombre,  facturacionv2.documentos.docto_estado_id,facturacionv2.documentos.link, facturacionv2.documento_tipo.tipo, facturacionv2.documentos.tgr   FROM facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.asignaciones.id_documentos = facturacionv2.documentos.id  INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario = facturacionv2.funcionario_facturacion.rut  INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id  INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id = facturacionv2.documentos.docto_tipo_id  LEFT JOIN facturacionv2.documento_has_recepcion ON facturacionv2.documento_has_recepcion.id_documento = facturacionv2.documentos.id  LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT  WHERE facturacionv2.documentos.docto_tipo_id IN (1,14,5,6,7,9,10,12) AND facturacionv2.documentos.docto_estado_id = 5  AND facturacionv2.documentos.mostrarEnBandeja = 1 AND facturacionv2.documentos.factoring = 1 GROUP BY facturacionv2.documentos.id ORDER BY facturacionv2.documentos.fecha_factura ASC";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexFuncionarioTesoreria_extrapresupuestarias(){

		$sql = "SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, facturacionv2.documentos.monto,  facturacionv2.documentos.fecha_factura, facturacionv2.documentos.fecha_recepcion, facturacionv2.documentos.ocportal,  facturacionv2.documento_estado.estado, facturacionv2.documentos.n_sigfe_devengo,  facturacionv2.documento_has_recepcion.id_recepcion_bodega, aba.proveedor.proveNombre,  facturacionv2.documentos.docto_estado_id,facturacionv2.documentos.link, facturacionv2.documento_tipo.tipo, facturacionv2.documentos.tgr   FROM facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.asignaciones.id_documentos = facturacionv2.documentos.id  INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario = facturacionv2.funcionario_facturacion.rut  INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id  INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id = facturacionv2.documentos.docto_tipo_id  LEFT JOIN facturacionv2.documento_has_recepcion ON facturacionv2.documento_has_recepcion.id_documento = facturacionv2.documentos.id  LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT  WHERE facturacionv2.documentos.docto_tipo_id IN (1,14,5,6,7,9,10,12,15) AND facturacionv2.documentos.extra_presupuestaria = 1 AND facturacionv2.documentos.docto_estado_id = 5  AND facturacionv2.documentos.mostrarEnBandeja = 1 AND ISNULL(facturacionv2.documentos.factoring) GROUP BY facturacionv2.documentos.id ORDER BY facturacionv2.documentos.fecha_factura ASC";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexFuncionarioJefatura(){

		$sql = "SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,facturacionv2.documentos.monto,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.fecha_recepcion,facturacionv2.documentos.ocportal,facturacionv2.documento_estado.estado,facturacionv2.documentos.n_sigfe_devengo,aba.proveedor.proveNombre,facturacionv2.documentos.docto_estado_id,facturacionv2.documentos.link,facturacionv2.documento_tipo.tipo,facturacionv2.documentos.devolucion FROM facturacionv2.documentos INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id=facturacionv2.documentos.docto_tipo_id LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut=aba.proveedor.proveRUT WHERE facturacionv2.documentos.docto_tipo_id IN (1,14,5,6,7,9,10,12,15) AND facturacionv2.documentos.docto_estado_id IN (1,2,3,4,5,9) AND ISNULL(facturacionv2.documentos.factoring) GROUP BY facturacionv2.documentos.id ORDER BY facturacionv2.documentos.fecha_factura ASC";

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			$ids = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$row = $conector->get_fila();
				$row['id_recepcion_bodega'] = '';
				array_push($response['facturas'],$row);
				array_push($ids,$conector->recuperar_dato('id'));
			}
			$asociaciones = $this->documentos_asociados_funcionarios(implode(',',$ids));
			for ($i=0; $i < count($response['facturas']); $i++) { 
				if(in_array($response['facturas'][$i]['id'],array_keys($asociaciones))){
					$response['facturas'][$i]['nombre'] = $asociaciones[$response['facturas'][$i]['id']];
				}else{
					$response['facturas'][$i]['nombre'] = " - ";
				}
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexFuncionarioJefatura_rechazadas(){

		$sql = "SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,facturacionv2.documentos.monto,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.fecha_recepcion,facturacionv2.documentos.ocportal,facturacionv2.documento_estado.estado,facturacionv2.documentos.n_sigfe_devengo,aba.proveedor.proveNombre,facturacionv2.documentos.docto_estado_id,facturacionv2.documentos.link,facturacionv2.documento_tipo.tipo,facturacionv2.documentos.devolucion FROM facturacionv2.documentos INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id=facturacionv2.documentos.docto_tipo_id LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut=aba.proveedor.proveRUT WHERE facturacionv2.documentos.docto_tipo_id IN (1,14,5,6,7,9,10,12,15) AND facturacionv2.documentos.docto_estado_id=6 GROUP BY facturacionv2.documentos.id ORDER BY facturacionv2.documentos.fecha_factura ASC";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			$ids = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$row = $conector->get_fila();
				$row['id_recepcion_bodega'] = '';
				array_push($response['facturas'],$row);
				array_push($ids,$conector->recuperar_dato('id'));
			}
			$asociaciones = $this->documentos_asociados_funcionarios(implode(',',$ids));
			for ($i=0; $i < count($response['facturas']); $i++) { 
				if(in_array($response['facturas'][$i]['id'],array_keys($asociaciones))){
					$response['facturas'][$i]['nombre'] = $asociaciones[$response['facturas'][$i]['id']];
				}else{
					$response['facturas'][$i]['nombre'] = " - ";
				}
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexFuncionarioJefatura_factoring(){
		
		$sql = "SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,facturacionv2.documentos.monto,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.fecha_recepcion,facturacionv2.documentos.ocportal,facturacionv2.documento_estado.estado,facturacionv2.documentos.n_sigfe_devengo,aba.proveedor.proveNombre,facturacionv2.documentos.docto_estado_id,facturacionv2.documentos.link,facturacionv2.documento_tipo.tipo,facturacionv2.documentos.devolucion FROM facturacionv2.documentos INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id=facturacionv2.documentos.docto_tipo_id LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut=aba.proveedor.proveRUT WHERE facturacionv2.documentos.docto_tipo_id IN (1,14,5,6,7,9,10,12) AND facturacionv2.documentos.docto_estado_id IN (1,2,3,4,5,9) AND facturacionv2.documentos.factoring=1 GROUP BY facturacionv2.documentos.id ORDER BY facturacionv2.documentos.fecha_factura ASC";

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			$ids = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$row = $conector->get_fila();
				$row['id_recepcion_bodega'] = '';
				array_push($response['facturas'],$row);
				array_push($ids,$conector->recuperar_dato('id'));
			}
			$asociaciones = $this->documentos_asociados_funcionarios(implode(',',$ids));
			for ($i=0; $i < count($response['facturas']); $i++) { 
				if(in_array($response['facturas'][$i]['id'],array_keys($asociaciones))){
					$response['facturas'][$i]['nombre'] = $asociaciones[$response['facturas'][$i]['id']];
				}else{
					$response['facturas'][$i]['nombre'] = " - ";
				}
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function documentos_asociados_funcionarios($array){

		$sql = "SELECT asignaciones.id_documentos,funcionario_facturacion.nombre FROM asignaciones INNER JOIN funcionario_facturacion ON asignaciones.funcionario=funcionario_facturacion.rut WHERE asignaciones.id_documentos IN (".$array.") AND asignaciones.estado=1 GROUP BY asignaciones.id_documentos";

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$response[$conector->recuperar_dato('id_documentos')] = $conector->recuperar_dato('nombre');
				// array_push($response,$conector->get_fila());
			}
		}else{
			$response = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function indexBoletasHonorarios(){

		$sql = "SELECT  facturacionv2.documentos.id,  facturacionv2.documentos.numero,  facturacionv2.documentos.monto,  facturacionv2.documentos.fecha_factura,  facturacionv2.documentos.fecha_recepcion,  facturacionv2.documentos.ocportal,  facturacionv2.documento_estado.estado,  facturacionv2.documentos.n_sigfe_devengo,  facturacionv2.documento_has_recepcion.id_recepcion_bodega,  aba.proveedor.proveNombre, facturacionv2.documentos.docto_estado_id,  facturacionv2.funcionario_facturacion.nombre,facturacionv2.documentos.link  FROM facturacionv2.documentos  LEFT JOIN facturacionv2.asignaciones ON facturacionv2.asignaciones.id_documentos = facturacionv2.documentos.id  LEFT JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario = facturacionv2.funcionario_facturacion.rut  INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id  INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documento_tipo.id = facturacionv2.documentos.docto_tipo_id  LEFT JOIN facturacionv2.documento_has_recepcion ON facturacionv2.documento_has_recepcion.id_documento = facturacionv2.documentos.id  LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT  WHERE facturacionv2.documentos.docto_tipo_id IN (7)  AND facturacionv2.documentos.docto_estado_id < 7  GROUP BY facturacionv2.documentos.id ORDER BY facturacionv2.documentos.fecha_factura ASC";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function mostrarDocumentosProveedor($rut){

		$sql = "SELECT documentos.id, documentos.numero, documentos.monto, documentos.fecha_factura, documentos.link, documentos.ocportal, documento_tipo.tipo FROM documentos INNER JOIN documento_tipo ON documentos.docto_tipo_id = documento_tipo.id WHERE documentos.proveedor_rut = '".$rut."' AND documentos.docto_tipo_id IN (2,3,4) ORDER BY documentos.fecha_factura DESC";
		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['documentos'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['documentos'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function facturas_has_documentos($id){

		$sql = "SELECT documentos.id, documentos.numero, documentos.monto, documentos.fecha_factura, documentos.link, documentos.ocportal, documento_tipo.tipo FROM documentos INNER JOIN documento_tipo ON documentos.docto_tipo_id = documento_tipo.id INNER JOIN factura_has_documento ON factura_has_documento.id_documento = documentos.id WHERE factura_has_documento.id_factura = ".$id." AND documentos.docto_tipo_id IN (2, 3, 4) ORDER BY documentos.fecha_factura DESC";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$response['documentos'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['documentos'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function count_notas_credito($id){

		$sql = "SELECT Count(factura_has_documento.id) AS count_id FROM factura_has_documento INNER JOIN documentos ON factura_has_documento.id_documento = documentos.id WHERE documentos.docto_tipo_id = 4 AND factura_has_documento.id_factura = ".$id;

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$conector->recuperar_afectadas();
		$conector->set_fila();
		$cantidad = $conector->recuperar_dato('count_id');
		$conector->desconectar();
		return($cantidad);
	}
	
	public function anticipos_has_documentos($id){

		$sql = "SELECT anticipos.*, documento_has_anticipo.id AS idHas FROM anticipos INNER JOIN documento_has_anticipo ON anticipos.id = documento_has_anticipo.id_anticipo WHERE documento_has_anticipo.id_documento = ".$id." AND documento_has_anticipo.activo = 1";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$response['documentos'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['documentos'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function updateEstadoDEVOLUCION($id, $devol = NULL){
		$conector = new Conector();			
		$conector->conectar('facturacionv2');
		$sql = "UPDATE documentos SET documentos.devolucion = ".$devol." WHERE documentos.id = ".$id;
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function facturas_has_recepcion($id){

		$sql = "SELECT bodega_inventario.recepcion_bodega.num_recepcion, bodega_inventario.recepcion_bodega.year_recepcion, bodega_inventario.recepcion_bodega.id_recepcion FROM facturacionv2.documento_has_recepcion INNER JOIN bodega_inventario.recepcion_bodega ON facturacionv2.documento_has_recepcion.id_recepcion_bodega = bodega_inventario.recepcion_bodega.id_recepcion WHERE facturacionv2.documento_has_recepcion.id_documento = ".$id;
		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['documentos'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['documentos'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function productos_a_pago($id){

		$sql = "SELECT bodega_inventario.recepcion_producto.id_producto, ordenes_de_compras.producto_compra.pro_estado_producto, ordenes_de_compras.estado_producto.id_estado_producto_nombre, ordenes_de_compras.producto_compra.pro_id_oc, ordenes_de_compras.producto_compra.pro_id_detalle_compra, ordenes_de_compras.producto_compra.pro_id_cpp FROM facturacionv2.documento_has_recepcion  INNER JOIN bodega_inventario.recepcion_producto ON facturacionv2.documento_has_recepcion.id_recepcion_bodega = bodega_inventario.recepcion_producto.id_recepcion  LEFT JOIN ordenes_de_compras.producto_compra ON bodega_inventario.recepcion_producto.id_producto = ordenes_de_compras.producto_compra.pro_id  INNER JOIN ordenes_de_compras.estado_producto ON ordenes_de_compras.producto_compra.pro_estado_producto = ordenes_de_compras.estado_producto.id_estado_producto WHERE facturacionv2.documento_has_recepcion.id_documento = ".$id;
		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['productos'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['productos'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function facturas_no_asignadas($id){
		if($id == 1) {
			$list = '1,14';
		}else{
			$list = $id;
		}

		// $sql = "SELECT  facturacionv2.documentos.id,  facturacionv2.documentos.numero,  facturacionv2.documentos.fecha_factura,  TRIM(aba.proveedor.proveNombre) as proveedor,  facturacionv2.documentos.monto FROM facturacionv2.documentos  LEFT JOIN facturacionv2.asignaciones ON facturacionv2.documentos.id = facturacionv2.asignaciones.id_documentos LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT WHERE facturacionv2.asignaciones.id_documentos IS NULL AND facturacionv2.documentos.docto_tipo_id IN (".$list.")";

		// $sql = "SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,facturacionv2.documentos.fecha_factura,TRIM(aba.proveedor.proveNombre) AS proveedor,facturacionv2.documentos.monto FROM facturacionv2.documentos LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut=aba.proveedor.proveRUT WHERE facturacionv2.documentos.docto_tipo_id IN (".$list.") AND NOT EXISTS ( SELECT*FROM facturacionv2.asignaciones a WHERE facturacionv2.documentos.id=a.id_documentos)";

		$sql = "SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,facturacionv2.documentos.fecha_factura,TRIM(aba.proveedor.proveNombre) AS proveedor,facturacionv2.documentos.monto FROM facturacionv2.documentos LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut=aba.proveedor.proveRUT WHERE documentos.asignada IS NULL AND documentos.docto_tipo_id IN (".$list.")";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		$response['data'] = array();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila[] = $i+1;
				$fila[] = $conector->recuperar_dato('id');
				$fila[] = $conector->recuperar_dato('numero');
				$fila[] = $conector->recuperar_dato('fecha_factura');
				$fila[] = $conector->recuperar_dato('proveedor');
				$fila[] = $conector->recuperar_dato('monto');
				array_push($response['data'],$fila);
			}
		}
		$conector->desconectar();
		return($response);
	}

	public function documentos_por_funcionario($rut){
		$sql = "SELECT  facturacionv2.documentos.id,  facturacionv2.documentos.numero,   facturacionv2.documentos.fecha_factura,  TRIM(aba.proveedor.proveNombre) as proveedor,   facturacionv2.documentos.monto  FROM facturacionv2.documentos   LEFT JOIN facturacionv2.asignaciones ON facturacionv2.documentos.id = facturacionv2.asignaciones.id_documentos AND facturacionv2.asignaciones.estado = 1  LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT  WHERE facturacionv2.asignaciones.funcionario = '".$rut."' AND facturacionv2.documentos.docto_tipo_id IN (1,5,6,7,8,9,10,11,12)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['data'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila[] = $i+1;
				$fila[] = $conector->recuperar_dato('id');
				$fila[] = $conector->recuperar_dato('numero');
				$fila[] = $conector->recuperar_dato('fecha_factura');
				$fila[] = $conector->recuperar_dato('proveedor');
				$fila[] = $conector->recuperar_dato('monto');
				array_push($response['data'],$fila);
			}
		}else{			
			$response['data'] = array();
		}

		$conector->desconectar();
		return($response);
	}

	public function todas_las_facturas(){

		$sql = '(SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,facturacionv2.funcionario_facturacion.nombre AS per_nombre,facturacionv2.documentos.ocportal FROM facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.documentos.id=facturacionv2.asignaciones.id_documentos AND facturacionv2.asignaciones.estado=1 INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario=facturacionv2.funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut WHERE facturacionv2.documentos.docto_tipo_id=1 AND facturacionv2.documentos.docto_estado_id IN (2,3,4,6) GROUP BY facturacionv2.documentos.id) UNION (SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,"SIN ASIGNAR",facturacionv2.documentos.ocportal FROM documentos INNER JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id WHERE documentos.docto_tipo_id=1 AND documentos.docto_estado_id=1) UNION (SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,facturacionv2.funcionario_facturacion.nombre AS per_nombre,facturacionv2.documentos.ocportal FROM documentos INNER JOIN log_estados_documentos ON documentos.id=log_estados_documentos.id_documento AND log_estados_documentos.id_docto_estado=5 INNER JOIN funcionario_facturacion ON log_estados_documentos.responsable=funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut WHERE documentos.docto_tipo_id=1 AND documentos.docto_estado_id IN (5,7) GROUP BY documentos.id) UNION (SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,facturacionv2.funcionario_facturacion.nombre AS per_nombre,facturacionv2.documentos.ocportal FROM documentos INNER JOIN log_estados_documentos ON documentos.id=log_estados_documentos.id_documento AND log_estados_documentos.id_docto_estado=3 INNER JOIN funcionario_facturacion ON log_estados_documentos.responsable=funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut WHERE documentos.docto_tipo_id=1 AND documentos.docto_estado_id=9 GROUP BY documentos.id) UNION (SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,facturacionv2.funcionario_facturacion.nombre AS per_nombre,facturacionv2.documentos.ocportal FROM documentos INNER JOIN log_estados_documentos ON documentos.id=log_estados_documentos.id_documento AND log_estados_documentos.id_docto_estado=6 INNER JOIN funcionario_facturacion ON log_estados_documentos.responsable=funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id LEFT JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut WHERE documentos.docto_tipo_id=1 AND documentos.docto_estado_id=8 GROUP BY documentos.id)';
		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['data'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila[] = $i+1;
				$fila[] = $conector->recuperar_dato('id');
				$fila[] = $conector->recuperar_dato('numero');
				$fila[] = $conector->recuperar_dato('proveedor');
				$fila[] = $conector->recuperar_dato('ocportal');
				$fila[] = $conector->recuperar_dato('fecha_factura');
				$fila[] = $conector->recuperar_dato('monto');
				$fila[] = $conector->recuperar_dato('estado');
				$fila[] = $conector->recuperar_dato('per_nombre');
				array_push($response['data'],$fila);
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function todas_las_factura_antiguas(){

		$sql = "SELECT '0' AS id,pago_proveedores.facturas.factura_fecha_factura AS fecha_factura,pago_proveedores.facturas.factura_numero AS numero,pago_proveedores.facturas.factura_monto AS monto,pago_proveedores.estado_factura.estadoFactura_nombre AS estado,aba.proveedor.proveNombre AS proveedor,CONCAT(aba.proveedor.proveRUT,' - ',aba.proveedor.proveDV) AS rut_proveedor,pago_proveedores.facturas.factura_fecha_de_pago AS fecha_de_pago FROM pago_proveedores.facturas INNER JOIN aba.proveedor ON pago_proveedores.facturas.factura_proveedor=aba.proveedor.proveRUT INNER JOIN pago_proveedores.estado_factura ON pago_proveedores.facturas.factura_estado=pago_proveedores.estado_factura.estadoFactura_id WHERE pago_proveedores.facturas.factura_fecha_factura< '2021-01-01' ORDER BY pago_proveedores.facturas.factura_fecha_factura DESC";
		$conector = new Conector();
		$conector->conectar('pago_proveedores');
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['data'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila[] = $i+1;
				$fila[] = $conector->recuperar_dato('id');
				$fila[] = $conector->recuperar_dato('numero');
				$fila[] = $conector->recuperar_dato('monto');
				$fila[] = $conector->recuperar_dato('rut_proveedor');
				$fila[] = $conector->recuperar_dato('proveedor');
				$fila[] = $conector->recuperar_dato('fecha_factura');
				$fila[] = $conector->recuperar_dato('fecha_de_pago');
				$fila[] = $conector->recuperar_dato('estado');
				array_push($response['data'],$fila);
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function todas_otros_documentos(){

		$sql = '(SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,facturacionv2.funcionario_facturacion.nombre AS per_nombre,facturacionv2.documento_tipo.tipo,facturacionv2.documentos.ocportal FROM facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.documentos.id=facturacionv2.asignaciones.id_documentos AND facturacionv2.asignaciones.estado=1 INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario=facturacionv2.funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documentos.docto_tipo_id=facturacionv2.documento_tipo.id WHERE facturacionv2.documentos.docto_tipo_id IN (5,6,7,9,10,12) AND facturacionv2.documentos.docto_estado_id IN (2,3,4,6) GROUP BY facturacionv2.documentos.id) UNION (SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,"SIN ASIGNAR",facturacionv2.documento_tipo.tipo,facturacionv2.documentos.ocportal FROM documentos INNER JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documentos.docto_tipo_id=facturacionv2.documento_tipo.id WHERE documentos.docto_tipo_id IN (5,6,7,9,10,12) AND documentos.docto_estado_id=1) UNION (SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,facturacionv2.funcionario_facturacion.nombre AS per_nombre,facturacionv2.documento_tipo.tipo,facturacionv2.documentos.ocportal FROM documentos INNER JOIN log_estados_documentos ON documentos.id=log_estados_documentos.id_documento AND log_estados_documentos.id_docto_estado=5 INNER JOIN funcionario_facturacion ON log_estados_documentos.responsable=funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documentos.docto_tipo_id=facturacionv2.documento_tipo.id WHERE documentos.docto_tipo_id IN (5,6,7,9,10,12) AND documentos.docto_estado_id IN (5,7) GROUP BY documentos.id) UNION (SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,facturacionv2.funcionario_facturacion.nombre AS per_nombre,facturacionv2.documento_tipo.tipo,facturacionv2.documentos.ocportal FROM documentos INNER JOIN log_estados_documentos ON documentos.id=log_estados_documentos.id_documento AND log_estados_documentos.id_docto_estado=3 INNER JOIN funcionario_facturacion ON log_estados_documentos.responsable=funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documentos.docto_tipo_id=facturacionv2.documento_tipo.id WHERE documentos.docto_tipo_id IN (5,6,7,9,10,12) AND documentos.docto_estado_id=9 GROUP BY documentos.id) UNION (SELECT facturacionv2.documentos.id,facturacionv2.documentos.numero,aba.proveedor.proveNombre AS proveedor,facturacionv2.documentos.fecha_factura,facturacionv2.documentos.monto,facturacionv2.documento_estado.estado,facturacionv2.funcionario_facturacion.nombre AS per_nombre,facturacionv2.documento_tipo.tipo,facturacionv2.documentos.ocportal FROM documentos INNER JOIN log_estados_documentos ON documentos.id=log_estados_documentos.id_documento AND log_estados_documentos.id_docto_estado=6 INNER JOIN funcionario_facturacion ON log_estados_documentos.responsable=funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id=facturacionv2.documento_estado.id LEFT JOIN aba.proveedor ON aba.proveedor.proveRUT=facturacionv2.documentos.proveedor_rut INNER JOIN facturacionv2.documento_tipo ON facturacionv2.documentos.docto_tipo_id=facturacionv2.documento_tipo.id WHERE documentos.docto_tipo_id IN (5,6,7,9,10,12) AND documentos.docto_estado_id=8 GROUP BY documentos.id)';
		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['data'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila[] = $i+1;
				$fila[] = $conector->recuperar_dato('id');
				$fila[] = $conector->recuperar_dato('numero');
				$fila[] = $conector->recuperar_dato('proveedor');
				$fila[] = $conector->recuperar_dato('ocportal');
				$fila[] = $conector->recuperar_dato('fecha_factura');
				$fila[] = $conector->recuperar_dato('monto');
				$fila[] = $conector->recuperar_dato('estado');
				$fila[] = $conector->recuperar_dato('per_nombre');
				$fila[] = $conector->recuperar_dato('tipo');
				array_push($response['data'],$fila);
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);
	}

	public function solo_facturas(){

		// $sql = 'SELECT * FROM ( ( SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, TRIM( aba.proveedor.proveNombre ) AS proveedor, facturacionv2.documentos.fecha_factura, facturacionv2.documentos.monto, facturacionv2.documento_estado.estado, ssalud.persona.per_nombre, facturacionv2.documentos.link FROM facturacionv2.documentos INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id LEFT JOIN aba.proveedor ON aba.proveedor.proveRUT = facturacionv2.documentos.proveedor_rut LEFT JOIN facturacionv2.asignaciones ON facturacionv2.documentos.id = facturacionv2.asignaciones.id_documentos INNER JOIN ssalud.persona ON facturacionv2.asignaciones.funcionario = ssalud.persona.per_rut COLLATE "UTF8_GENERAL_CI" WHERE facturacionv2.documentos.docto_tipo_id = 1 AND facturacionv2.documentos.docto_estado_id IN ( 1, 2, 3, 4, 5, 9 ) GROUP BY facturacionv2.documentos.id ) UNION ( SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, TRIM( aba.proveedor.proveNombre ) AS proveedor, facturacionv2.documentos.fecha_factura, facturacionv2.documentos.monto, facturacionv2.documento_estado.estado, "SIN ASIGNAR" AS per_nombre, facturacionv2.documentos.link FROM facturacionv2.documentos INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id LEFT JOIN aba.proveedor ON aba.proveedor.proveRUT = facturacionv2.documentos.proveedor_rut LEFT JOIN facturacionv2.asignaciones ON facturacionv2.documentos.id = facturacionv2.asignaciones.id_documentos WHERE facturacionv2.documentos.docto_tipo_id = 1 AND facturacionv2.documentos.docto_estado_id IN ( 1, 2, 3, 4, 5, 9 ) AND facturacionv2.asignaciones.funcionario IS NULL GROUP BY facturacionv2.documentos.id ) ) AS REPORTE';

				$sql = "( SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, aba.proveedor.proveNombre AS proveedor, facturacionv2.documentos.fecha_factura, facturacionv2.documentos.monto, facturacionv2.documento_estado.estado, facturacionv2.funcionario_facturacion.nombre AS per_nombre, facturacionv2.documentos.link FROM facturacionv2.documentos INNER JOIN facturacionv2.asignaciones ON facturacionv2.documentos.id = facturacionv2.asignaciones.id_documentos AND facturacionv2.asignaciones.estado = 1 INNER JOIN facturacionv2.funcionario_facturacion ON facturacionv2.asignaciones.funcionario = facturacionv2.funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT = facturacionv2.documentos.proveedor_rut WHERE facturacionv2.documentos.docto_tipo_id = 1 AND facturacionv2.documentos.docto_estado_id IN (2, 3, 4) GROUP BY facturacionv2.documentos.id ) UNION ( SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, aba.proveedor.proveNombre AS proveedor, facturacionv2.documentos.fecha_factura, facturacionv2.documentos.monto, facturacionv2.documento_estado.estado, 'SIN ASIGNAR', facturacionv2.documentos.link FROM documentos INNER JOIN aba.proveedor ON aba.proveedor.proveRUT = facturacionv2.documentos.proveedor_rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id WHERE documentos.docto_tipo_id = 1 AND documentos.docto_estado_id = 1 ) UNION ( SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, aba.proveedor.proveNombre AS proveedor, facturacionv2.documentos.fecha_factura, facturacionv2.documentos.monto, facturacionv2.documento_estado.estado, facturacionv2.funcionario_facturacion.nombre AS per_nombre, facturacionv2.documentos.link FROM documentos INNER JOIN log_estados_documentos ON documentos.id = log_estados_documentos.id_documento AND log_estados_documentos.id_docto_estado = 5 INNER JOIN funcionario_facturacion ON log_estados_documentos.responsable = funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT = facturacionv2.documentos.proveedor_rut WHERE documentos.docto_tipo_id = 1 AND documentos.docto_estado_id IN (5) GROUP BY documentos.id ) UNION ( SELECT facturacionv2.documentos.id, facturacionv2.documentos.numero, aba.proveedor.proveNombre AS proveedor, facturacionv2.documentos.fecha_factura, facturacionv2.documentos.monto, facturacionv2.documento_estado.estado, facturacionv2.funcionario_facturacion.nombre AS per_nombre, facturacionv2.documentos.link FROM documentos INNER JOIN log_estados_documentos ON documentos.id = log_estados_documentos.id_documento AND log_estados_documentos.id_docto_estado = 3 INNER JOIN funcionario_facturacion ON log_estados_documentos.responsable = funcionario_facturacion.rut INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id INNER JOIN aba.proveedor ON aba.proveedor.proveRUT = facturacionv2.documentos.proveedor_rut WHERE documentos.docto_tipo_id = 1 AND documentos.docto_estado_id = 9 GROUP BY documentos.id )";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function Index($est){

		// $sql = "SELECT facturacion.facturas.id,facturacion.facturas.numero,facturacion.facturas.fecha_factura,facturacion.facturas.monto,facturacion.estados_facturas.estado,bodega_inventario.recepcion_bodega.id_recepcion,ordenes_de_compras.cpp.cpp_proveedor_nombre,facturacion.facturas.estados_facturas_id FROM facturacion.facturas INNER JOIN facturacion.estados_facturas ON facturacion.facturas.estados_facturas_id = facturacion.estados_facturas.id INNER JOIN facturacion.facturas_has_recepcion ON facturacion.facturas_has_recepcion.facturas_id = facturacion.facturas.id INNER JOIN bodega_inventario.recepcion_bodega ON bodega_inventario.recepcion_bodega.id_recepcion = facturacion.facturas_has_recepcion.recepcion_id INNER JOIN ordenes_de_compras.cpp ON bodega_inventario.recepcion_bodega.id_cpp = ordenes_de_compras.cpp.cpp_id WHERE facturacion.facturas.estados_facturas_id IN (".$est.") AND YEAR(facturacion.facturas.fecha_factura) > 2019 ORDER BY facturacion.facturas.fecha_factura DESC";

		$sql = "SELECT facturacion.facturas.id,facturacion.facturas.numero,facturacion.facturas.fecha_factura,facturacion.facturas.monto,facturacion.facturas.estados_facturas_id,aba.proveedor.proveNombre AS cpp_proveedor_nombre,facturacion.estados_facturas.estado FROM facturacion.facturas INNER JOIN aba.proveedor ON aba.proveedor.proveRUT = facturacion.facturas.rut_proveedor INNER JOIN facturacion.estados_facturas ON facturacion.estados_facturas.id = facturacion.facturas.estados_facturas_id WHERE facturacion.facturas.estados_facturas_id IN (".$est.") AND YEAR(facturacion.facturas.fecha_factura) = 2020 ORDER BY facturacion.facturas.fecha_factura DESC";

		$conector = new Conector();
		$conector->conectar('facturacion');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}

		$conector->desconectar();
		return($response);
	}

	public function Buscar($id){ 
		/**  Sql LocalHost  ***/
		if ($_SERVER['SERVER_NAME'] == "localhost") {
			$sql = "SELECT facturacionv2.documentos.*, aba.proveedor.proveNombre, facturacionv2.documento_estado.estado, facturacionv2.sistemas.sistema  FROM facturacionv2.documentos  LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = CONCAT(aba.proveedor.proveRUT,'-',aba.proveedor.proveDV) COLLATE 'utf8_general_ci' INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id  LEFT JOIN facturacionv2.sistemas ON facturacionv2.documentos.docto_sistema_id = facturacionv2.sistemas.id WHERE documentos.id = ".$id;
		}else{
			$sql = "SELECT facturacionv2.documentos.*, aba.proveedor.proveNombre, facturacionv2.documento_estado.estado, facturacionv2.sistemas.sistema  FROM facturacionv2.documentos  LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = CONCAT(aba.proveedor.proveRUT,'-',aba.proveedor.proveDV) INNER JOIN facturacionv2.documento_estado ON facturacionv2.documentos.docto_estado_id = facturacionv2.documento_estado.id  LEFT JOIN facturacionv2.sistemas ON facturacionv2.documentos.docto_sistema_id = facturacionv2.sistemas.id WHERE documentos.id = ".$id;
		}

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response['sql'] = false;
		}
		
		$conector->desconectar();
		
		return($response);
	} 

	public function ListarCC(){
		$sql = "SELECT centro_de_costo.cc_id,centro_de_costo.cc_nombre FROM centro_de_costo WHERE centro_de_costo.cc_eliminado IS NULL AND centro_de_costo.cc_otros_fondos IS NULL";

		$conector = new Conector();
		$conector->conectar('presupuesto');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$response['cc'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['cc'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}
		
		$conector->desconectar();
		
		return($response);
	}

	public function BuscarRecepciones($id, $year){ 

		if ($year == 1) {
			$sql = "SELECT bodega_inventario.recepcion_bodega.num_recepcion, bodega_inventario.recepcion_bodega.fecha_recepcion, bodega_inventario.tipo_documento.nombre_documento, bodega_inventario.recepcion_bodega.num_docto, ordenes_de_compras.cpp.cpp_num, ordenes_de_compras.cpp.cpp_proveedor_nombre, ordenes_de_compras.cpp.cpp_id_oc_portal, ordenes_de_compras.compra.compra_numero, bodega_inventario.recepcion_bodega.proveedor,bodega_inventario.recepcion_bodega.id_cpp FROM bodega_inventario.recepcion_bodega INNER JOIN bodega_inventario.tipo_documento ON bodega_inventario.recepcion_bodega.tipo_docto = bodega_inventario.tipo_documento.id_tipo_documento INNER JOIN ordenes_de_compras.cpp ON bodega_inventario.recepcion_bodega.id_cpp = ordenes_de_compras.cpp.cpp_id INNER JOIN ordenes_de_compras.producto_compra ON ordenes_de_compras.producto_compra.pro_id_cpp = ordenes_de_compras.cpp.cpp_id LEFT JOIN ordenes_de_compras.compra ON ordenes_de_compras.producto_compra.pro_id_oc = ordenes_de_compras.compra.compra_id WHERE ordenes_de_compras.cpp.cpp_id_oc_portal = '".$id."' GROUP BY num_recepcion";
		}else{
			$sql = "SELECT bodega_inventario.recepcion_bodega.num_recepcion, bodega_inventario.recepcion_bodega.fecha_recepcion, ordenes_de_compras.cpp.cpp_proveedor_nombre, bodega_inventario.recepcion_bodega.num_docto, bodega_inventario.tipo_documento.nombre_documento, ordenes_de_compras.cpp.cpp_num, ordenes_de_compras.cpp.cpp_id_oc_portal, ordenes_de_compras.compra.compra_numero, bodega_inventario.recepcion_bodega.id_recepcion, bodega_inventario.recepcion_bodega.proveedor,bodega_inventario.recepcion_bodega.id_cpp FROM bodega_inventario.recepcion_bodega INNER JOIN bodega_inventario.tipo_documento ON bodega_inventario.tipo_documento.id_tipo_documento = bodega_inventario.recepcion_bodega.tipo_docto INNER JOIN ordenes_de_compras.cpp ON bodega_inventario.recepcion_bodega.id_cpp = ordenes_de_compras.cpp.cpp_id INNER JOIN ordenes_de_compras.producto_compra ON ordenes_de_compras.cpp.cpp_id = ordenes_de_compras.producto_compra.pro_id_cpp LEFT JOIN ordenes_de_compras.compra ON ordenes_de_compras.producto_compra.pro_id_oc = ordenes_de_compras.compra.compra_id WHERE bodega_inventario.recepcion_bodega.year_recepcion = ".$year." AND bodega_inventario.recepcion_bodega.num_recepcion = ".$id." GROUP BY num_recepcion";
		}
		$conector = new Conector();
		$conector->conectar('facturacion');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}
		
		$conector->desconectar();
		
		return($response);
	}

	public function CompararFacturas($num, $fecha, $prov, $monto){ 

		$sql = "SELECT facturas.factura_id FROM facturas WHERE facturas.factura_numero = ".$num."  AND facturas.factura_proveedor = ".$prov;

		$conector = new Conector(true);
		$conector->conectar('pago_proveedores');
		$conector->ejecutar($sql);
		$conector->recuperar_afectadas();
		$conector->set_fila();
		$response = $conector->recuperar_dato('factura_id');
		echo 'Respuesta existe factura= '.$response;

		if ($response != '') {
			$sql2 = "SELECT facturas.factura_id FROM facturas WHERE facturas.factura_id = ".$response." AND DATE(facturas.factura_fecha_factura) = DATE('".$fecha."') AND facturas.factura_monto = ".$monto;
			$conector->ejecutar($sql2);
			$conector->recuperar_afectadas();
			$conector->set_fila();
			$response2 = $conector->recuperar_dato('factura_id');
			echo 'Respuesta sql igua monto y fecha = '.$response2;
			if ($response2 == '') {
				$response = 'error';
			}			
		}else{
			$response = false;
		}

		$conector->desconectar();
		return($response);
	}

	public function registrar_factura($array, $sys){

		$sql = 'INSERT INTO documentos(numero, monto, fecha_factura, fecha_recepcion, n_sigfe_devengo, proveedor_rut, docto_tipo_id, docto_sistema_id, ocportal, link) VALUES ('.$array['n_documento'].','.$array['monto'].',"'.$array['fecha_factura'].'","'.$array['fecha_registro'].'",';
		if ($array['n_sigfe'] != "") {
			$sql .=$array['n_sigfe'].',';
		}else{
			$sql.='NULL,';
		}
		$sql.='"'.$array['proveedor'].'",';
		if($array['tipo_documento'] != ""){
			$sql .= '(SELECT documento_tipo.id FROM documento_tipo WHERE documento_tipo.id_acepta = '.$array['tipo_documento'].'),';
		}else{
			$sql.='NULL';
		}
		$sql.=$sys.',"'.$array['n_oc_portal'].'","'.$array['url'].'")';

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas_insert();

		if($cuantos > 0){
			$respuesta = $conector->recuperar_ultimo_id();
		}else{
			$respuesta = false;
		}
		$conector->desconectar();

		return($respuesta);
	}

	public function registrar_factura2($array, $sys){

		$sql = 'INSERT INTO documentos(numero, monto, fecha_factura, fecha_recepcion, n_sigfe_devengo, proveedor_rut, docto_tipo_id, docto_sistema_id, ocportal, link) SELECT '.$array['n_documento'].','.$array['monto'].',"'.$array['fecha_factura'].'","'.$array['fecha_registro'].'",';
		if ($array['n_sigfe'] != "") {
			$sql .=$array['n_sigfe'].',';
		}else{
			$sql.='NULL,';
		}
		$sql.='"'.$array['proveedor'].'",';
		$sql.='IF(documento_tipo.id = 14,1,documento_tipo.id),';
		$sql.=$sys.',"'.$array['n_oc_portal'].'","'.$array['url'].'" ';
		$sql.='FROM documento_tipo WHERE documento_tipo.id_acepta = '.$array['tipo_documento'];

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas_insert();

		if($cuantos > 0){
			$respuesta = $conector->recuperar_ultimo_id();
		}else{
			$respuesta = false;
		}
		$conector->desconectar();

		return($respuesta);
	}

	public function registrar_fact_recep($recep, $docto, $resp, $miniRecep = 0){

		$sql = 'INSERT INTO documento_has_recepcion( id_documento, id_recepcion_bodega, responsable, id_mini_recepcion) VALUES ('.$docto.','.$recep.',"'.$resp.'",'.$miniRecep.')';

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas_insert();

		if($cuantos > 0){
			$respuesta = $conector->recuperar_ultimo_id();
		}else{
			$respuesta = NULL;
		}
		$conector->desconectar();

		return($respuesta);
	}

	public function registrar_fact_doc($fact, $docto, $resp){

		$sql = 'INSERT INTO factura_has_documento(id_factura, id_documento, responsable) VALUES ('.$fact.','.$docto.',"'.$resp.'")';

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas_insert();

		if($cuantos > 0){
			$respuesta = $conector->recuperar_ultimo_id();
		}else{
			$respuesta = NULL;
		}
		$conector->desconectar();

		return($respuesta);
	}

	public function registrar_anticipo_doc($fact, $docto, $resp){

		$sql = 'INSERT INTO documento_has_anticipo(id_documento, id_anticipo, responsable,activo) VALUES ('.$fact.','.$docto.',"'.$resp.'",1)';

		$conector = new Conector(true);
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas_insert();

		if($cuantos > 0){
			$respuesta = $conector->recuperar_ultimo_id();
		}else{
			$respuesta = NULL;
		}
		$conector->desconectar();

		return($respuesta);
	}

	public function deleteAsocRecepcion($idf, $id2){
		$conector = new Conector();			
		$conector->conectar('facturacionv2');
		$delete = 'DELETE FROM  documento_has_recepcion WHERE id_documento = '.$idf.' AND id_recepcion_bodega = '.$id2;
		$conector->ejecutar($delete);
		$conector->desconectar();
	}

	public function deleteAsocDocumento($idf ,$id2){
		$conector = new Conector();			
		$conector->conectar('facturacionv2');
		$delete = 'DELETE FROM factura_has_documento WHERE 	id_factura = '.$idf.' AND id_documento = '.$id2;
		$conector->ejecutar($delete);
		$conector->desconectar();
	}

	public function deleteAsocAnticipo($idf){
		$conector = new Conector(true);			
		$conector->conectar('facturacionv2');
		$delete = 'UPDATE documento_has_anticipo set activo = 0 WHERE id = '.$idf;
		$conector->ejecutar($delete);
		$conector->desconectar();
	}

	public function updateAsignar($idf){
		$conector = new Conector(true);			
		$conector->conectar('facturacionv2');
		$delete = 'UPDATE documentos set asignada = 1 WHERE id = '.$idf;
		$conector->ejecutar($delete);
		$conector->desconectar();
	}

	public function registrar_factura_old($array, $rut, $depto){

		$conector = new Conector(true);
		
		$conector->conectar('pago_proveedores');

		$sql_ultimo_id = "SELECT
		Max(facturas.factura_id) as mayor
		FROM
		facturas";
		
		$conector->ejecutar($sql_ultimo_id);
		
		$conector->set_fila();
		
		$ultimo_id = $conector->recuperar_dato('mayor');
		
		$ultimo_id++;
		
		$sql = 'INSERT INTO';
		$sql .= ' facturas';
		$sql .= ' (factura_id,';
		$sql .= ' factura_numero,';					   
		$sql .= ' factura_fecha_factura,';					   
		$sql .= ' factura_dias,';					   
		$sql .= ' factura_fecha_recepcion,';					   
		$sql .= ' factura_monto,';					   
		$sql .= ' factura_proveedor,';					   
		$sql .= ' factura_centro_costo,';					   
		$sql .= ' factura_estado,';				
		$sql .= ' factura_estado_actual,';	
		$sql .= ' factura_accion_pendiente_por_desarrollar,';	
		$sql .= ' factura_registra_departamento,';	
		$sql .= ' factura_registra_rut,';
		$sql .= ' factura_registra_ip,';
		$sql .= ' factura_fecha_registro_sistema,';
		$sql .= ' factura_eliminado,';
		$sql .= ' factura_numero_sigfe,';		
		$sql .= ' factura_fecha_de_pago,';
		$sql .= ' factura_correspondencia,';
		$sql .= ' factura_fecha_pago)';
		$sql .= ' VALUES ("'.$ultimo_id.'",';
		$sql .= ' "'.$array['numfac'].'",';			
		$sql .= ' "'.$array['fecfac'].'",';
		// $dias = DATEDIFF(DATE($array['fecfac']),DATE($array['fecRec']));
		$dias = 10;	
		$sql .= ' "'.$dias.'",';			
		$sql .= ' "'.$array['fecRec'].'",';			
		$sql .= ' "'.$array['valor'].'",';
		$proveedor = explode('-',$array['proveedor']);
		$sql .= ' "'.$proveedor[0].'",';
		$sql .= ' "'.$array['ccosto'].'",';
		$sql .= ' "1",';
		$sql .= ' NULL,';
		$sql .= ' NULL,';
		$sql .= ' "'.$depto.'",';
		$sql .= ' "'.$rut.'",';
		$sql .= ' "'.$_SERVER['REMOTE_ADDR'].'",';
		$sql .= ' "'.date('Y-m-d H:i:s').'",';
		$sql .= ' "1",';
		$sql .= ' NULL,';
		$sql .= ' NULL,';
		if($array['corres'] == ""){
			$sql .= ' NULL,';			
		}else{
			$sql .= ' "'.$array['corres'].'",';
		}
		$sql .= ' "1")';
		
		$conector->ejecutar($sql);
		
		$valor = $conector->recuperar_afectadas_insert();
		
		$conector->desconectar();
		
		if($valor == 1){				
			$a = $ultimo_id;				
		}else{
			$a = "false"; 				
		}
		return($a);		
	}

	public function insert_log_recepcion($new, $old, $rc, $rut){

		$conector = new Conector();
		
		$conector->conectar('bodega_inventario');


		$sql = 'INSERT INTO';
		$sql .= ' log_recepcion_factura';
		$sql .= ' (responsable,';					   
		$sql .= ' ip,';					   
		$sql .= ' fecha,';					   
		$sql .= ' id_recepcion,';					   
		$sql .= ' id_factura_new,';					   
		$sql .= ' id_factura_old)';
		$sql .= ' VALUES ("'.$rut.'",';
		$sql .= ' "'.$_SERVER['REMOTE_ADDR'].'",';
		$sql .= ' NOW(),';		
		$sql .= ' '.$rc.',';
		$sql .= ' '.$new.',';
		$sql .= ' '.$old.')';
		
		$conector->ejecutar($sql);
		
		$valor = $conector->recuperar_afectadas_insert();
		
		$conector->desconectar();
		
		if($valor == 1){				
			$a = true;				
		}else{
			$a = "false"; 				
		}
		return($a);		
	}

	public function updateRecepcion($id_recepcion, $id_factura, $numfac){
		$conector = new Conector(true);			
		$conector->conectar('bodega_inventario');
		$sql = "UPDATE recepcion_bodega SET";
		$sql .= " id_factura = '".$id_factura."'";
		$sql .= ", num_docto = '".$numfac."'";
		$sql .= ", tipo_docto = 1";
		$sql .=" WHERE id_recepcion = ".$id_recepcion;
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function Ingresar($post){
		//var_dump($post);
		$sql  = 'INSERT';
		$sql .= ' INTO';
		$sql .= ' facturas';
		$sql .= ' (';
		$sql .= ' numero,';
		$sql .= ' fecha_factura,';
		$sql .= ' fecha_recibo,';
		$sql .= ' dias,';
		$sql .= ' monto,';
		$sql .= ' sistema_id,';
		$sql .= ' estados_facturas_id';			
		$sql .= ' )';
		$sql .= ' VALUES';
		$sql .= ' (';
		$sql .= ''.$post['numero'].','; 
		$sql .= '"'.$post['ffactura'].'",';
		$sql .= '"'.$post['frecepcion'].'",';
		$sql .= ''.$post['dias'].',';
		$sql .= ''.$post['monto'].',';
		$sql .= ''.$post['sistema'].',';
		$sql .= ''.$post['estado'];
		$sql .= ')';

		$conector = new Conector();	
		$conector->conectar('pago_proveedores');
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

	public function kpi_sin_asignar(){

		$sql = "SELECT  Count(facturacionv2.documentos.id) AS Cantidad, Sum(facturacionv2.documentos.monto) AS Total FROM facturacionv2.documentos   LEFT JOIN facturacionv2.asignaciones ON facturacionv2.documentos.id = facturacionv2.asignaciones.id_documentos  LEFT JOIN aba.proveedor ON facturacionv2.documentos.proveedor_rut = aba.proveedor.proveRUT  WHERE facturacionv2.asignaciones.id_documentos IS NULL AND facturacionv2.documentos.docto_tipo_id IN (1, 5, 6, 7, 9, 10, 12, 14)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila['cantidad'] = $conector->recuperar_dato('Cantidad');
				$fila['suma'] = $conector->recuperar_dato('Total');
			}
		}else{
			$fila['sql'] = $sql;
		}
		$conector->desconectar();
		return($fila);
	}
	
	public function kpiTotal(){

		$sql = "SELECT Count(documentos.id) AS Cantidad, Sum(documentos.monto) AS Total FROM `documentos` WHERE docto_estado_id IN (1,2,3,4,5,9)  AND `fecha_factura` BETWEEN '2020-12-31' AND NOW() AND `docto_tipo_id` IN (1, 5, 6, 7, 9, 10, 12, 14)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila['cantidad'] = $conector->recuperar_dato('Cantidad');
				$fila['suma'] = $conector->recuperar_dato('Total');
			}
		}else{
			$fila['sql'] = $sql;
		}
		$conector->desconectar();
		return($fila);
	}

	public function kpi_en_plazo(){

		$sql = "SELECT Count(documentos.id) AS Cantidad, Sum(documentos.monto) AS Total FROM documentos WHERE docto_estado_id IN (1,2,3,4,5,9)  AND fecha_factura BETWEEN NOW() - INTERVAL 20 DAY AND NOW() AND docto_tipo_id IN (1, 5, 6, 7, 9, 10, 12, 14)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila['cantidad'] = $conector->recuperar_dato('Cantidad');
				$fila['suma'] = $conector->recuperar_dato('Total');
			}
		}else{
			$fila = NULL;
		}

		$conector->desconectar();
		return($fila);
	}

	public function kpi_por_vencer(){

		$sql = "SELECT Count(documentos.id) AS Cantidad, Sum(documentos.monto) AS Total FROM `documentos` WHERE docto_estado_id IN (1,2,3,4,5,9)  AND `fecha_factura` BETWEEN NOW() - INTERVAL 30 DAY AND NOW()- INTERVAL 20 DAY AND `docto_tipo_id` IN (1, 5, 6, 7, 9, 10, 12, 14)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila['cantidad'] = $conector->recuperar_dato('Cantidad');
				$fila['suma'] = $conector->recuperar_dato('Total');
			}
		}else{
			$fila = NULL;
		}

		$conector->desconectar();
		return($fila);
	}

	public function kpi_vencidas(){

		$sql = "SELECT Count(documentos.id) AS Cantidad, Sum(documentos.monto) AS Total FROM `documentos` WHERE docto_estado_id IN (1,2,3,4,5,9)  AND `fecha_factura` BETWEEN '2020-12-31' AND NOW()- INTERVAL 30 DAY AND `docto_tipo_id` IN (1, 5, 6, 7, 9, 10, 12, 14)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila['cantidad'] = $conector->recuperar_dato('Cantidad');
				$fila['suma'] = $conector->recuperar_dato('Total');
			}
		}else{
			$fila = NULL;
		}

		$conector->desconectar();
		return($fila);
	}

	public function kpiTotal_facturas(){

		$sql = "SELECT Count(documentos.id) AS Cantidad, Sum(documentos.monto) AS Total FROM `documentos` WHERE docto_estado_id IN (1,2,3,4,5,9)  AND `fecha_factura` BETWEEN '2015-12-31' AND NOW() AND `docto_tipo_id` IN (1, 14)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila['cantidad'] = $conector->recuperar_dato('Cantidad');
				$fila['suma'] = $conector->recuperar_dato('Total');
			}
		}else{
			$fila['sql'] = $sql;
		}
		$conector->desconectar();
		return($fila);
	}

	public function kpi_en_plazo_facturas(){

		$sql = "SELECT Count(documentos.id) AS Cantidad, Sum(documentos.monto) AS Total FROM documentos WHERE docto_estado_id IN (1,2,3,4,5,9)  AND fecha_factura BETWEEN NOW() - INTERVAL 20 DAY AND NOW() AND docto_tipo_id IN (1, 14)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila['cantidad'] = $conector->recuperar_dato('Cantidad');
				$fila['suma'] = $conector->recuperar_dato('Total');
			}
		}else{
			$fila = NULL;
		}

		$conector->desconectar();
		return($fila);
	}

	public function kpi_por_vencer_facturas(){

		$sql = "SELECT Count(documentos.id) AS Cantidad, Sum(documentos.monto) AS Total FROM `documentos` WHERE docto_estado_id IN (1,2,3,4,5,9)  AND `fecha_factura` BETWEEN NOW() - INTERVAL 30 DAY AND NOW()- INTERVAL 20 DAY AND `docto_tipo_id` IN (1, 14)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila['cantidad'] = $conector->recuperar_dato('Cantidad');
				$fila['suma'] = $conector->recuperar_dato('Total');
			}
		}else{
			$fila = NULL;
		}

		$conector->desconectar();
		return($fila);
	}

	public function kpi_vencidas_facturas(){

		$sql = "SELECT Count(documentos.id) AS Cantidad, Sum(documentos.monto) AS Total FROM `documentos` WHERE docto_estado_id IN (1,2,3,4,5,9)  AND `fecha_factura` BETWEEN '2015-12-31' AND NOW()- INTERVAL 30 DAY AND `docto_tipo_id` IN (1,14)";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$fila = array();
				$fila['cantidad'] = $conector->recuperar_dato('Cantidad');
				$fila['suma'] = $conector->recuperar_dato('Total');
			}
		}else{
			$fila = NULL;
		}

		$conector->desconectar();
		return($fila);
	}

	public function updateEstado($id, $est){
		$conector = new Conector();			
		$conector->conectar('facturacionv2');
		$sql = "UPDATE documentos SET documentos.docto_estado_id = ".$est." WHERE documentos.id = ".$id;
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function updateDays(){
		$conector = new Conector();			
		$conector->conectar('facturacion');
		$sql = "UPDATE facturas SET facturas.dias = DATEDIFF(DATE(NOW()),DATE(facturas.fecha_factura)) WHERE facturas.estados_facturas_id < 5 AND YEAR(facturas.fecha_factura) > 2018";
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function updateFactura($array){
		
		$sql = "UPDATE documentos SET";
		$sql .= " documentos.numero = ".$array['num'];
		$sql .= ", documentos.monto = ".$array['monto'];
		$sql .= ", documentos.fecha_factura = '".$array['ffac']."'";
		$sql .= ", documentos.fecha_recepcion = '".$array['FRfac']."'";
		if ($array['link'] != '') {
			$sql .= ", documentos.link = '".$array['link']."'";
		}else{
			$sql .= ", documentos.link = NULL";			
		}
		if ($array['ocp'] != '') {
			$sql .= ", documentos.ocportal = '".$array['ocp']."'";
		}else{
			$sql .= ", documentos.ocportal = NULL";			
		}
		if ($array['sigfeDev'] != '') {
			$sql .= ", documentos.n_sigfe_devengo = '".$array['sigfeDev']."'";
		}else{
			$sql .= ", documentos.n_sigfe_devengo = NULL";
		}
		if ($array['sigfecpp']!='') {
			$sql .= ", documentos.n_sigfe_cpp = '".$array['sigfecpp']."'";			
		}else{
			$sql .= ", documentos.n_sigfe_cpp = NULL";
		}
		if ($array['sigfeComp']!='') {
			$sql .= ", documentos.n_sigfe_compensatorio = ".$array['sigfeComp'];			
		}else{
			$sql .= ", documentos.n_sigfe_compensatorio = NULL";
		}
		if ($array['sigfePago']!='') {
			$sql .= ", documentos.n_sigfe_pago = ".$array['sigfePago'];			
		}else{
			$sql .= ", documentos.n_sigfe_pago = NULL";
		}
		if ($array['fpago']!='') {
			$sql .= ", documentos.fecha_pago = '".$array['fpago']."'";			
		}else{
			$sql .= ", documentos.fecha_pago = NULL";
		}
		if ($array['extra']!='') {
			$sql .= ", documentos.extra_presupuestaria = '".$array['extra']."'";			
		}else{
			$sql .= ", documentos.extra_presupuestaria = NULL";
		}
		$sql .=" WHERE id = ".$array['id'];
		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function updateEstadoTGR($id, $est){
		$conector = new Conector(true);			
		$conector->conectar('facturacionv2');
		$sql = "UPDATE documentos SET documentos.tgr = ".$est." WHERE documentos.id = ".$id;
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function updateEstadoR2($id, $est){
		$conector = new Conector(true);			
		$conector->conectar('facturacionv2');
		$sql = "UPDATE documentos SET documentos.r2 = ".$est." WHERE documentos.id = ".$id;
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function insertFacturaPg($id, $fpag, $sigfe){
		$conector = new Conector(true);			
		$conector->conectar('facturacion');
		$sql = "UPDATE facturas SET";
		$sql .= " facturacion.facturas.fecha_pago = '".$fpag."'";
		$sql .= ", facturacion.facturas.sigfe = '".$sigfe."'";
		$sql .=" WHERE id = ".$id;
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function pagarFactura($id){

		$sql = 'SELECT facturacion.facturas_has_recepcion.recepcion_id,ordenes_de_compras.producto_compra.pro_cantidad_unitario,ordenes_de_compras.producto_compra.pro_id_cpp,ordenes_de_compras.producto_compra.pro_id_oc,ordenes_de_compras.producto_compra.pro_id FROM facturacion.facturas_has_recepcion INNER JOIN bodega_inventario.recepcion_producto ON facturacion.facturas_has_recepcion.recepcion_id = bodega_inventario.recepcion_producto.id_recepcion INNER JOIN ordenes_de_compras.producto_compra ON bodega_inventario.recepcion_producto.id_producto = ordenes_de_compras.producto_compra.pro_id WHERE facturacion.facturas_has_recepcion.facturas_id = '.$id;
		$conector = new Conector();
		$conector->conectar('facturacion');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$response['facturas'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['facturas'],$conector->get_fila());
			}
			for ($i=0; $i < count($response['facturas']); $i++) { 
				$sqlA = 'SELECT bodega_inventario.recepcion_producto.id_producto,Sum(bodega_inventario.recepcion_producto.cantidad_prod) FROM bodega_inventario.recepcion_producto INNER JOIN bodega_inventario.recepcion_bodega ON bodega_inventario.recepcion_producto.id_recepcion = bodega_inventario.recepcion_bodega.id_recepcion INNER JOIN pago_proveedores.facturas ON bodega_inventario.recepcion_bodega.id_factura = pago_proveedores.facturas.factura_id WHERE bodega_inventario.recepcion_producto.id_producto = '.$response['facturas'][$i]['pro_id'].' AND factura_estado = 3 AND factura_id NOT IN ('.$id.') GROUP BY bodega_inventario.recepcion_producto.id_producto';	

				$conector->ejecutar($sqlA);
				$cuantosA = $conector->recuperar_afectadas();

				if($cuantosA > 0){
					$resp['cantidades'] = array();
					for($i = 0; $i < $cuantosA; $i++){
						$conector->set_fila();
						array_push($resp['cantidades'],$conector->get_fila());
					}

				}else{
					//comparar cpp y ot
				}
			}
		}else{
			$response['sql'] = $sql;
		}
		
		$conector->desconectar();
		
		return($response);
	}

	public function Eliminar($id){
	}
}
?>
