<?php 
	require_once('conector.class.php');
	class Proveedores{
		public function __construct(){ 
		 }
		
		public function Index(){

		}

		public function Buscar($id,$anio,$total){
			$sql  = 'SELECT cpp.cpp_id AS pro_id_cpp,cpp.cpp_num,cpp.cpp_amio,cpp.cpp_observacion,cpp.cpp_proveedor_nombre,CASE cpp.cpp_ajuste IS NOT NULL WHEN true THEN cpp.cpp_total_con_ajuste ELSE cpp.cpp_total_neto_mas_otros_gastos END as Total FROM cpp WHERE cpp_estado IN (3,6,7,8,9,10) AND cpp.cpp_proveedor = '.$id;
				switch(isset($anio) && $anio != ''){
					case TRUE:
						$sql .= ' AND cpp.cpp_amio = '.$anio;						
					break;
				}
				switch(isset($total) && $total != ''){
					case TRUE:
						$sql .= ' HAVING total = '.$total;						
						break;
				}

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

		public function Ingresar($post){
		 
		}

		public function Actualizar($post){
		 
		}

		public function Eliminar($id){
		 
		}
	}
 ?>