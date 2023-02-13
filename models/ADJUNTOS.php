<?php
	require_once('conector.class.php');
	class Adjuntos{
		public function __construct(){ 
		}
		
		public function Index(){

		}

		public function Buscar($id){
			$sql  = "SELECT * FROM adjuntos WHERE adjuntos.id_documento =".$id;

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
				$response = null;
			}
			
			$conector->desconectar();
			return($response);				 
		} 

		public function Ingresar($post){
		 	$sql  = 'INSERT';
			$sql .= ' INTO';
			$sql .= ' adjuntos';
			$sql .= ' (';
			$sql .= ' nombre,';
			$sql .= ' ruta,';
			$sql .= ' responsable,';
			$sql .= ' ip,';
			$sql .= ' id_documento';			
			$sql .= ' )';
			$sql .= ' VALUES';
			$sql .= ' (';
			$sql .= '"'.$post['nombre'].'",'; 
			$sql .= '"'.$post['ruta'].'",';
			$sql .= '"'.$post['responsable'].'",';
			$sql .= '"'.$post['ip'].'",';
			$sql .= ''.$post['facturas_id'];
			$sql .= ')';

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