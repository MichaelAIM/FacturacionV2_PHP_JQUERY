<?php
require_once('conector.class.php');
class Log{
	public function __construct(){ 
	}
	
	public function Index(){
		$sql  = "";

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
			$response['sql'] = '';
		}
		
		$conector->desconectar();
		return($response);

	}

	public function BuscarEstadosFacturas(){
		$sql  = "SELECT * FROM documento_estado";

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		
		if($cuantos > 0){
			$response['estados'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['estados'],$conector->get_fila());
			}
		}else{
			$response['sql'] = $sql;
		}
		
		$conector->desconectar();
		return($response);

	}

	public function buscar($id){
		
		$sql  = "SELECT facturacionv2.log_estados_documentos.id, facturacionv2.log_estados_documentos.id_documento, facturacionv2.log_estados_documentos.created_at, facturacionv2.log_estados_documentos.dias, facturacionv2.log_estados_documentos.devolucion, facturacionv2.documento_estado.estado, ssalud.persona.per_nombre, facturacionv2.documento_estado.id AS estado_id, facturacionv2.documentos.docto_estado_id AS estadoFactura FROM facturacionv2.log_estados_documentos INNER JOIN facturacionv2.documento_estado ON facturacionv2.log_estados_documentos.id_docto_estado = facturacionv2.documento_estado.id INNER JOIN ssalud.persona ON facturacionv2.log_estados_documentos.responsable = ssalud.persona.per_rut COLLATE 'utf8_general_ci' INNER JOIN facturacionv2.documentos ON facturacionv2.documentos.id = facturacionv2.log_estados_documentos.id_documento WHERE facturacionv2.log_estados_documentos.id_documento = ".$id." ORDER BY facturacionv2.log_estados_documentos.created_at DESC";

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

	public function BuscarLastFecha($id){
		
		$sql  = "SELECT log_estados_documentos.created_at FROM log_estados_documentos WHERE log_estados_documentos.id_documento = ".$id." ORDER BY log_estados_documentos.created_at DESC LIMIT 1";

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$conector->set_fila();
			$l_tipos = $conector->recuperar_dato('created_at');				
		}else{
			$l_tipos = false;
		}
		$conector->desconectar();
		return($l_tipos);
	} 


	public function BuscarLOGenR1($id){
		$sql  = "SELECT asignaciones.id FROM log_estados_documentos INNER JOIN asignaciones ON log_estados_documentos.responsable = asignaciones.funcionario AND log_estados_documentos.id_documento = asignaciones.id_documentos WHERE log_estados_documentos.id_documento = ".$id." AND log_estados_documentos.id_docto_estado = 3 ORDER BY log_estados_documentos.created_at DESC LIMIT 1";

		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$conector->set_fila();
			$l_tipos = $conector->recuperar_dato('id');				
		}else{
			$sqlB  = "SELECT asignaciones.id FROM log_estados_documentos INNER JOIN asignaciones ON log_estados_documentos.responsable = asignaciones.funcionario AND log_estados_documentos.id_documento = asignaciones.id_documentos WHERE log_estados_documentos.id_documento = ".$id." AND log_estados_documentos.id_docto_estado = 5 ORDER BY log_estados_documentos.created_at DESC LIMIT 1";

			$conector->ejecutar($sqlB);
			$cuantosB = $conector->recuperar_afectadas();
			if($cuantosB > 0){
				$conector->set_fila();
				$l_tipos = $conector->recuperar_dato('id');				
			}else{
				$l_tipos = false;			
			}
		}
		$conector->desconectar();
		return($l_tipos);
	} 

	public function Ingresar($id,$resp,$dias,$est,$b){

		$sql  = 'INSERT';
		$sql .= ' INTO';
		$sql .= ' log_estados_documentos';
		$sql .= ' (';
		$sql .= ' id_documento,';
		$sql .= ' id_docto_estado,';
		$sql .= ' responsable,';
		$sql .= ' dias,';
		$sql .= ' ip,';			
		$sql .= ' devolucion';			
		$sql .= ' )';
		$sql .= ' VALUES';
		$sql .= ' (';
		$sql .= ''.$id.','; 
		$sql .= ''.$est.','; 
		$sql .= '"'.$resp.'",';
		$sql .= ''.$dias.',';
		$sql .= '"'.$_SERVER['REMOTE_ADDR'].'",';
		$sql .= '"'.$b.'")';

		$conector = new Conector(true);	
		$conector->conectar('facturacionv2');
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

	public function Actualizar($post){
		
	}

	public function Eliminar($id){
		
	}
}
?>
