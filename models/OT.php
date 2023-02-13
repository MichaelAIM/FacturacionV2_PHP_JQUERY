<?php 
require_once('conector.class.php');
	class ot{
		public function __construct(){ 
		 }
		
		public function Index(){

		}

		public function Buscar($id){			
			
		} 

		public function Ingresar($post){
		 
		}

		public function Actualizar($post){
		 
		}

		public function actualizar_Estado($idProd,$estado){
			$conector = new Conector(true);			
			$conector->conectar('ordenes_de_compras');
			$sql = "UPDATE compra SET";
			$sql .=" compra_estado = ".$estado;
			$sql .=" WHERE compra_id = ".$idProd;
			$conector->ejecutar($sql);
			$conector->desconectar();
		}

		public function Eliminar($id){
		 
		}
	}
?>