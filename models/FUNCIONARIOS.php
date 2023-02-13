<?php
	require_once('conector.class.php');
	class Funcionarios{
		public function __construct(){ 
		}
		
		public function index(){
			$sql  = "SELECT * FROM funcionario_facturacion";

			$conector = new Conector();
			$conector->conectar('facturacionv2');
			$conector->ejecutar($sql);
			$cuantos = $conector->recuperar_afectadas();
			
			if($cuantos > 0){
				$response['funcionarios'] = array();
				for($i = 0; $i < $cuantos; $i++){
					$conector->set_fila();
					array_push($response['funcionarios'],$conector->get_fila());
				}
			}else{
				$response['sql'] = $sql;
			}
			
			$conector->desconectar();
			return($response);				 
		} 

	}
?>