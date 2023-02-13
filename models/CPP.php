<?PHP
require_once('conector.class.php');	 

	class CPP{

		public function __construct(){ 
		}

		public function Index(){

		}

		public function Buscar($id,$dato){
			$sql  = 'SELECT producto_compra.pro_id_cpp,cpp.cpp_num,cpp.cpp_amio, CASE cpp.cpp_ajuste IS NOT NULL WHEN true THEN cpp.cpp_total_con_ajuste ELSE cpp.cpp_total_neto_mas_otros_gastos END as Total FROM producto_compra LEFT JOIN compra ON producto_compra.pro_id_oc = compra.compra_id INNER JOIN cpp ON producto_compra.pro_id_cpp = cpp.cpp_id WHERE cpp.cpp_estado IN (3,6,7,8,9,10) AND';
				switch($id){
					case 'CPP':
						$sql .= ' cpp.cpp_num = '.$dato;
						$sql .= ' GROUP BY cpp.cpp_id';
						break;
					case 'OCP':
						$sql .= ' cpp.cpp_id_oc_portal = "'.$dato.'"';
						break;
					case 'OT':
						$sql .= ' compra.compra_numero = '.$dato;
						$sql .= ' GROUP BY cpp.cpp_id';								
						break;
				}
			$sql .= ' ORDER BY cpp.cpp_amio DESC';

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

		public function actualizar_Estado($idProd,$estado){
			$conector = new Conector(true);			
			$conector->conectar('ordenes_de_compras');
			$sql = "UPDATE cpp SET";
			$sql .=" cpp_estado = ".$estado;
			$sql .=" WHERE cpp_id = ".$idProd;
			$conector->ejecutar($sql);
			$conector->desconectar();
		}

		public function actualizar_Estado_Proceso($idProd,$estado){
			$conector = new Conector(true);			
			$conector->conectar('ordenes_de_compras');
			$sql = "UPDATE proceso_de_compra SET";
			$sql .=" detalle_compra_situacion = ".$estado;
			$sql .=" WHERE detalle_compra_id = ".$idProd;
			$conector->ejecutar($sql);
			$conector->desconectar();
		}

		public function buscar_adjuntos_facturasCpp($idDoc){

			$sql = "SELECT ordenes_de_compras.adjuntos_cpp.adj_nombre, YEAR(ordenes_de_compras.adjuntos_cpp.adj_fecha) AS anio, MONTH(ordenes_de_compras.adjuntos_cpp.adj_fecha) AS mes, ordenes_de_compras.adjuntos_cpp.adj_nombre_subio FROM facturacionv2.documento_has_recepcion  INNER JOIN bodega_inventario.recepcion_bodega ON facturacionv2.documento_has_recepcion.id_recepcion_bodega = bodega_inventario.recepcion_bodega.id_recepcion  INNER JOIN ordenes_de_compras.adjuntos_cpp ON bodega_inventario.recepcion_bodega.id_cpp = ordenes_de_compras.adjuntos_cpp.adj_id_cpp WHERE facturacionv2.documento_has_recepcion.id_documento = ".$idDoc." AND ordenes_de_compras.adjuntos_cpp.adj_adjuntado = 'V'";

			$conector = new Conector();
			$conector->conectar('facturacionv2');		
			$conector->ejecutar($sql);				
			$cuantos = $conector->recuperar_afectadas();
			if($cuantos > 0){
				$response['cpp'] = array();
				for($i = 0; $i < $cuantos; $i++){
					$conector->set_fila();
					array_push($response['cpp'],$conector->get_fila());
				}
			}else{
				$response = NULL;
			}

			$conector->desconectar();
			return($response);
		}

		public function Eliminar($id){
		 
		}

	}