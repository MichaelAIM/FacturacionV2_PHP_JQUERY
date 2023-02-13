<?php
	require_once('conector.class.php');
	class Observacion{
		public function __construct(){ 
		}
		
		public function Index(){
		}

		public function Buscar($id){
			$sql  = "SELECT facturacionv2.observaciones.detalle, facturacionv2.observaciones.created_at, facturacionv2.observaciones.id_tipo_obs, facturacionv2.tipo_obs.tipo_obs, ssalud.persona.per_nombre FROM facturacionv2.observaciones INNER JOIN facturacionv2.tipo_obs ON facturacionv2.observaciones.id_tipo_obs = facturacionv2.tipo_obs.id INNER JOIN ssalud.persona ON facturacionv2.observaciones.responsable = ssalud.persona.per_rut COLLATE'utf8_general_ci' WHERE facturacionv2.observaciones.id_documento = ".$id." ORDER BY facturacionv2.observaciones.created_at DESC";

			$conector = new Conector();
			$conector->conectar('facturacionv2');
			$conector->ejecutar($sql);
			$cuantos = $conector->recuperar_afectadas();
			
			if($cuantos > 0){
				$response['obs'] = array();
				for($i = 0; $i < $cuantos; $i++){
					$conector->set_fila();
					array_push($response['obs'],$conector->get_fila());
				}
			}else{
				$response['sql'] = '';
			}
			
			$conector->desconectar();
			return($response);		 
		} 

		public function Ingresar($post){
		 	$sql  = 'INSERT';
			$sql .= ' INTO';
			$sql .= ' observaciones';
			$sql .= ' (';
			$sql .= ' detalle,';
			$sql .= ' responsable,';
			$sql .= ' id_documento,';			
			$sql .= ' id_tipo_obs';			
			$sql .= ' )';
			$sql .= ' VALUES';
			$sql .= ' (';
			$sql .= '"'.$post['observacion'].'",'; 
			$sql .= '"'.$post['responsable'].'",';
			$sql .= ''.$post['facturas_id'].',';
			$sql .= ''.$post['tipo_obs'];
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