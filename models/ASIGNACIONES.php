<?php
require_once('conector.class.php');
class Asignar{
	public function __construct(){ 
	}

	public function Index(){

	}

	public function buscar_por_factura($id){
		$sql  = "SELECT asignaciones.id, asignaciones.asignador, asignaciones.funcionario, asignaciones.id_documentos, asignaciones.created_at, asignaciones.estado, funcionario_facturacion.nombre, funcionario_facturacion.revision FROM asignaciones INNER JOIN funcionario_facturacion ON asignaciones.funcionario = funcionario_facturacion.rut WHERE asignaciones.id_documentos = ".$id;
		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$response['asign'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['asign'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);				 
	} 

	public function buscar_IDFactura($id){
		$sql  = "SELECT facturacionv2.asignaciones.id,facturacionv2.asignaciones.id_documentos,facturacionv2.asignaciones.created_at,facturacionv2.asignaciones.estado,funcionario2.nombre AS Funcionario,Asignador2.nombre AS Asignador FROM facturacionv2.asignaciones INNER JOIN facturacionv2.funcionario_facturacion AS funcionario2 ON facturacionv2.asignaciones.funcionario=funcionario2.rut INNER JOIN facturacionv2.funcionario_facturacion AS Asignador2 ON facturacionv2.asignaciones.asignador=Asignador2.rut WHERE facturacionv2.asignaciones.id_documentos = ".$id." GROUP BY asignaciones.id ORDER BY facturacionv2.asignaciones.created_at DESC";
		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();

		if($cuantos > 0){
			$response['asign'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['asign'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}

		$conector->desconectar();
		return($response);				 
	}


	public function buscar_por_rut_doc($rut,$doc){

		$sql = "SELECT asignaciones.id FROM asignaciones WHERE asignaciones.id_documentos = ".$doc." AND asignaciones.funcionario = '".$rut."' ORDER BY asignaciones.created_at DESC";

		$conector = new Conector();
		$conector->conectar('facturacionv2');		
		$conector->ejecutar($sql);				
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$conector->set_fila();
			$response = $conector->recuperar_dato('id');
		}else{			
			$response = NULL;
		}

		$conector->desconectar();
		return($response);				 
	}

	public function Ingresar($RESP,$FUNC,$ID_DOC){
		$sql  = 'INSERT INTO asignaciones(asignador, funcionario, id_documentos) VALUES ("'.$RESP.'","'.$FUNC.'",'.$ID_DOC.')';

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

	public function actualizar_estado($id,$est){
		$conector = new Conector(true);			
		$conector->conectar('facturacionv2');
		$sql = "UPDATE asignaciones SET asignaciones.estado = ".$est." WHERE asignaciones.id =".$id;
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function Eliminar($id){		 
	}
}
?>
