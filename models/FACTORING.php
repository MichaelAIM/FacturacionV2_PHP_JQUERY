<?php
require_once('conector.class.php');
class Factoring{
	public function __construct(){ 
	}

	public function Index(){

	}

	public function buscar_factoring($id){
		$sql  = "SELECT factoring.*, proveedor_factoring.nombre as prov_fact, proveedor_factoring.rut as prov_rut FROM factoring INNER JOIN proveedor_factoring ON factoring.proveedor_factoring = proveedor_factoring.id WHERE id_documento = ".$id;
		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();		
		if($cuantos > 0){
			$response['factoring'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['factoring'],$conector->get_fila());
			}
		}else{
			$response = null;
		}

		$conector->desconectar();
		return($response);			
	}

	public function buscar_proveedor_factoring($rut, $nombre, $session){
		$sql  = "SELECT proveedor_factoring.id FROM proveedor_factoring WHERE rut = '".$rut."'";
		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$id_prov_factoring = $conector->recuperar_dato('id');
			}
		}else{
			$id_prov_factoring = $this->ingresar_proveedor_factoring($rut, $nombre, $session);
		}
		// echo $id_prov_factoring;
		$conector->desconectar();
		return($id_prov_factoring);			
	}

	public function ingresar_proveedor_factoring($rut, $nombre, $session){

		$sqlB  = "INSERT INTO proveedor_factoring (rut, nombre, responsable) VALUES ('".$rut."','".$nombre."','".$session."')";
		$conectorB = new Conector();
		$conectorB->conectar('facturacionv2');
		$conectorB->ejecutar($sqlB);
		$cuantos = $conectorB->recuperar_afectadas_insert();
		if($cuantos > 0){
			$respuesta = $conectorB->recuperar_ultimo_id();
		}else{
			$respuesta = NULL;
		}
		// echo($respuesta);
		$conectorB->desconectar();
		return($respuesta);
	}

	public function ingresar_factoring($array){
		$conector = new Conector(true);	
		$conector->conectar('facturacionv2');
		$sql_verficar  = "SELECT factoring.id AS count_id FROM factoring WHERE factoring.numero_factura = ".$array['inputNumFAct']." AND factoring.proveedor  = '".$array['inputProvFAct']."' AND factoring.proveedor_factoring = ".$array['idPROVFact']." AND factoring.monto = ".$array['inputMomFAct'];
		$conector->ejecutar($sql_verficar);
		$conector->recuperar_afectadas();
		$conector->set_fila();
		$existe_prov = $conector->recuperar_dato('count_id');

		if ($existe_prov != "") {
			$factoring_id = $existe_prov;
		}else{
			$sql  = "INSERT INTO factoring (numero_factura, fecha_recepcion, proveedor, monto, proveedor_factoring, fecha_cedido, adjunto, responsable) VALUES (".$array['inputNumFAct'].",'".$array['frecep']."','".$array['inputProvFAct']."',".$array['inputMomFAct'].",'".$array['idPROVFact']."','".$array['fcedido']."','".$array['filename']."','".$array['session']."')";
			$conector->ejecutar($sql);
			$cuantos = $conector->recuperar_afectadas_insert();
			if($cuantos > 0){
				$factoring_id = $conector->recuperar_ultimo_id();
			}else{
				$factoring_id = false;
			}
		}

		$conector->desconectar();
		return($factoring_id);
	}

	// asociar factoring cuando ingresan los factoting
	public function asociar_factoring($idFactoring, $num, $proveedor, $monto, $session){
		$conector = new Conector();	
		$conector->conectar('facturacionv2');

		$sql_verficar  = "SELECT documentos.id AS id_doc FROM documentos WHERE documentos.docto_tipo_id = 1 AND documentos.numero = ".$num." AND documentos.proveedor_rut = '".$proveedor."' AND documentos.monto = ".$monto;
		$conector->ejecutar($sql_verficar);
		$conector->recuperar_afectadas();
		$conector->set_fila();
		$existe_docto = $conector->recuperar_dato('id_doc');

		if ($existe_docto != "") {
			$this->update_factoring_docto($existe_docto);
			$this->update_factoring($existe_docto, $idFactoring, $session);
		}
		$conector->desconectar();
		return($existe_docto);
	}

	// asociar factoring cuando ingresan los documentos
	public function asociar_factoring_2($idDocumento, $num, $proveedor, $monto, $session){

		$sql  = "SELECT factoring.id FROM factoring WHERE factoring.numero_factura = ".$num." AND factoring.proveedor  = '".$proveedor."' AND factoring.monto = ".$monto;
		$conector = new Conector();	
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				$this->update_factoring($idDocumento, $conector->recuperar_dato('id'), $session);
			}
			$this->update_factoring_docto($idDocumento);			
		}else{
			$response = null;
		}
		$conector->desconectar();
		return($existe_docto);
	}

	public function update_factoring_docto($idDoc){
		$conector = new Conector();			
		$conector->conectar('facturacionv2');
		$sql = "UPDATE documentos SET documentos.factoring = 1 WHERE documentos.id = ".$idDoc;
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function update_factoring($idDoc, $idFact, $session){
		$conector = new Conector();			
		$conector->conectar('facturacionv2');
		$sql = "UPDATE factoring SET factoring.id_documento = ".$idDoc.", factoring.fecha_asoc = NOW(), rut_asoc = '".$session."' WHERE factoring.id = ".$idFact;
		$conector->ejecutar($sql);
		$conector->desconectar();
	}
}
?>