<?PHP
require_once('conector.class.php');	 

class CUENTAS{

	public function __construct(){ 
	}

	public function Index(){

	}
   	public function BuscarCuentas()
   	{
      $sql="SELECT * FROM anticipos_por_ff.cuenta_contable ";
      $conector = new Conector();
			$conector->conectar('anticipos_por_ff');
			$conector->ejecutar($sql);
			$cuantos = $conector->recuperar_afectadas();
			
			if($cuantos > 0){
				$response= array();
				for($i = 0; $i < $cuantos; $i++){
					$conector->set_fila();
					array_push($response,$conector->get_fila());
				}
			}else{
				$response = $sql;
			}
			
			$conector->desconectar();
			return($response);	

   	}
   	public function agregarcuenta($id)
   	{
   		$conector = new Conector();
		$conector->conectar('anticipos_por_ff');
   		$sql="INSERT INTO cuenta_contable(cuenta) VALUES($id)";
   		$conector->ejecutar($sql);

   		$id=$conector->recuperar_ultimo_id();
        $conector->desconectar();
   		return $id;


   	}

   	public function updatecuenta($id,$anticipo)
   	{ 
   		$conector = new Conector();
		$conector->conectar('facturacionv2');
   		$sql="UPDATE fondos_fijos SET u_ingresa_c_contable=$id where id=$anticipo";
   		$conector->ejecutar($sql);
   		$conector->desconectar();

   	}





}


?>