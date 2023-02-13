<?php
require_once('conector.class.php');
class Anticipo{
	public function __construct(){ 
	}

	public function Index(){
		$sql  = "SELECT  facturacionv2.anticipos.id,  facturacionv2.anticipos.numero,  facturacionv2.anticipos.year,  facturacionv2.anticipos.monto,  facturacionv2.anticipos.estado,  aba.proveedor.proveNombre,  ordenes_de_compras.adjuntos_cpp.adj_nombre,  YEAR(ordenes_de_compras.adjuntos_cpp.adj_fecha) AS anio,  MONTH(ordenes_de_compras.adjuntos_cpp.adj_fecha) AS mes, ordenes_de_compras.adjuntos_cpp.adj_nombre_subio,  ordenes_de_compras.adjuntos_cpp.adj_adjuntado, facturacionv2.anticipos.id_cpp  FROM facturacionv2.anticipos  INNER JOIN aba.proveedor ON facturacionv2.anticipos.proveedor = aba.proveedor.proveRUT  LEFT JOIN ordenes_de_compras.adjuntos_cpp ON facturacionv2.anticipos.id_cpp = ordenes_de_compras.adjuntos_cpp.adj_id_cpp AND ordenes_de_compras.adjuntos_cpp.adj_adjuntado = 'V' WHERE facturacionv2.anticipos.estado = 1";
		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['anticipo'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['anticipo'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}
		$conector->desconectar();
		return($response);		
	}
	public  function  verCpp($id){
		$sql="SELECT
		anticipos_por_ff.anticipos_cpp.` id`,
		facturacionv2.fondos_fijos.fiador,
		facturacionv2.fondos_fijos.numero,
		facturacionv2.fondos_fijos.`year`,
		anticipos_por_ff.anticipos_cpp.estado,
		anticipos_por_ff.fiadores.run,
		anticipos_por_ff.anticipos_cpp.id_cpp
		FROM
		anticipos_por_ff.fiadores
		INNER JOIN facturacionv2.fondos_fijos ON anticipos_por_ff.fiadores.id = facturacionv2.fondos_fijos.fiador
		INNER JOIN anticipos_por_ff.anticipos_cpp ON facturacionv2.fondos_fijos.id =anticipos_cpp.id_anticipos
		where anticipos_por_ff.anticipos_cpp.estado=0 and anticipos_por_ff.fiadores.id=$id
		ORDER BY anticipos_por_ff.anticipos_cpp.` id` DESC
		LIMIT 1";
		$conector = new Conector();
		$conector->conectar('anticipos_por_ff');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response,$conector->get_fila());
			}
		}else{
			$response = NULL;
		}
		$conector->desconectar();
		return($response);	



	}
	public function Reversarfondo_fijo($id,$motivo,$usuario,$id_anticipos,$firma)
	{
		$fecha=date("Y-m-d h:m:s");
		$sql="UPDATE firma_solicitudes SET estado=1,firma='$usuario'  WHERE id_solicitud=$id and estado=0";
		$sql1="INSERT INTO firma_solicitudes(unidad_negocio,fecha,updated_at,estado,id_solicitud)VALUES (4,'$fecha','$fecha',0,$id)";
		$sql2="UPDATE solicitudes SET estado=3,motivo_rechazo='$motivo' WHERE id=$id";
		$sql4="DELETE  FROM anticipo_solicitud WHERE id=$firma";
		$conector = new Conector();
		$conector->conectar('anticipos');
		$conector->ejecutar($sql);
		$conector->ejecutar($sql1);
		$conector->ejecutar($sql2);
		$conector->ejecutar($sql4);

		$sql3="UPDATE fondos_fijos SET estado=8 WHERE id=$id_anticipos";
		$conector1 = new Conector();
		$conector1->conectar('facturacionv2');
		$conector1->ejecutar($sql3);
		

		

		$conector->desconectar();
		$conector1->desconectar();	

	}

	public function Index2(){
		$sql  = "SELECT
		facturacionv2.fondos_fijos.id,
		facturacionv2.fondos_fijos.numero,
		facturacionv2.fondos_fijos.`year`,
		facturacionv2.fondos_fijos.fiador,
		facturacionv2.fondos_fijos.monto,
		facturacionv2.fondos_fijos.estado as estado_fondo,
		facturacionv2.fondos_fijos.memo_pdf,
		facturacionv2.fondos_fijos.fecha_pago,
		facturacionv2.fondos_fijos.fecha_pago_sistema,
		facturacionv2.fondos_fijos.comprobante,
		facturacionv2.fondos_fijos.sigfe_devengo,
		facturacionv2.fondos_fijos.sigfe_compensatorio,
		facturacionv2.fondos_fijos.id_cpp,
		facturacionv2.fondos_fijos.pagado_por,
		facturacionv2.fondos_fijos.sigfe_pago,
		facturacionv2.fondos_fijos.sigfe_compromiso,
		facturacionv2.fondos_fijos.motivo_rechazo,
		facturacionv2.fondos_fijos.cpp_pagado_anterior,
		facturacionv2.fondos_fijos.cc_id,
		facturacionv2.fondos_fijos.revision,
		facturacionv2.fondos_fijos.ultima_rendicion,
		facturacionv2.fondos_fijos.created_at,
		facturacionv2.fondos_fijos.updated_at,
		anticipos.adjuntos.url,
		anticipos.fiadores.nombre AS proveNombre,
		anticipos.solicitudes.id AS id_soli,
		anticipos.anticipo_solicitud.id AS id_firma,
		anticipos.firma_anticipos.unidad_negocio,
		anticipos.firma_anticipos.estado,
		anticipos.firma_anticipos.fecha,
		presupuesto.centro_de_costo.cc_nombre,
		anticipos.firma_anticipos.id as id_firma_anticipo
		FROM
		facturacionv2.fondos_fijos
		INNER JOIN presupuesto.centro_de_costo ON facturacionv2.fondos_fijos.cc_id = presupuesto.centro_de_costo.cc_id
		INNER JOIN anticipos.anticipo_solicitud ON facturacionv2.fondos_fijos.id = anticipos.anticipo_solicitud.id_anticipo
		INNER JOIN anticipos.solicitudes ON anticipos.anticipo_solicitud.id_solicitud = anticipos.solicitudes.id
		INNER JOIN anticipos.adjuntos ON anticipos.solicitudes.adjuntos_id = anticipos.adjuntos.id
		INNER JOIN anticipos.fiadores ON facturacionv2.fondos_fijos.fiador = anticipos.fiadores.id
		LEFT JOIN ordenes_de_compras.cpp ON facturacionv2.fondos_fijos.id_cpp = ordenes_de_compras.cpp.cpp_id
		INNER JOIN anticipos.firma_anticipos ON facturacionv2.fondos_fijos.id = anticipos.firma_anticipos.id_anticipo
		where facturacionv2.fondos_fijos.estado=1";
		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['anticipo'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['anticipo'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}
		$conector->desconectar();
		return($response);		
	}
	public function index3(){
		$sql  = "SELECT
		DATE_FORMAT(
		anticipos_por_ff.fondo_dcto.fecha_at,
		'%Y'
		) AS `year`,
		facturacionv2.documentos.monto,
		facturacionv2.documentos.numero,
		facturacionv2.documentos.id,
		facturacionv2.documentos.proveedor_rut,
		aba.proveedor.proveNombre,
		anticipos_por_ff.fondo_dcto.fecha_at,
		anticipos_por_ff.fondo_dcto.id_fondo,
		anticipos_por_ff.fondo_dcto.estado_doc,
		anticipos_por_ff.fondo_dcto.url_codificada,
		anticipos_por_ff.adjuntos.url
		FROM
		facturacionv2.documentos
		INNER JOIN aba.proveedor ON aba.proveedor.proveRUT = facturacionv2.documentos.proveedor_rut
		INNER JOIN anticipos_por_ff.fondo_dcto ON anticipos_por_ff.fondo_dcto.id_documento = facturacionv2.documentos.id
		INNER JOIN anticipos_por_ff.adjuntos ON anticipos_por_ff.adjuntos.id = anticipos_por_ff.fondo_dcto.url_solicitud
		WHERE
		anticipos_por_ff.fondo_dcto.estado_doc = 1
		";
		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['anticipo'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['anticipo'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}
		$conector->desconectar();
		return($response);		
	}

	public function BuscarAnticiposProveedor($proveedor){
		$sql  = "SELECT facturacionv2.anticipos.*, aba.proveedor.proveNombre FROM facturacionv2.anticipos INNER JOIN aba.proveedor ON facturacionv2.anticipos.proveedor = aba.proveedor.proveRUT LEFT JOIN facturacionv2.documento_has_anticipo ON facturacionv2.documento_has_anticipo.id_anticipo = facturacionv2.anticipos.id AND facturacionv2.documento_has_anticipo.activo = 0 WHERE facturacionv2.anticipos.proveedor = '".$proveedor."'  			AND facturacionv2.anticipos.estado = 7";
		$conector = new Conector();
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$cuantos = $conector->recuperar_afectadas();
		if($cuantos > 0){
			$response['anticipo'] = array();
			for($i = 0; $i < $cuantos; $i++){
				$conector->set_fila();
				array_push($response['anticipo'],$conector->get_fila());
			}
		}else{
			$response = NULL;
		}
		$conector->desconectar();
		return($response);		
	}

	public function updateEstadoAnticipo($data){
		$conector = new Conector(true);			
		$conector->conectar('facturacionv2');
		$sql = "UPDATE anticipos SET estado = 7, fecha_pago = '".$data['fecha']."', sigfe_pago = ".$data['sigfe'].", pagado_por = '".$data['resp']."', fecha_pagado = now(), comprobante = '".$data['comprobante']."' WHERE id =".$data['id'];
		$conector->ejecutar($sql);
		$conector->desconectar();
	}

	public function updateEstadoFFijo($data){
		$fecha=date("Y-m-d h:m:s");
		
		$sql = "UPDATE fondos_fijos SET estado = 7,revision=0,ultima_rendicion=0,fecha_pago = '".$data['fecha']."', sigfe_pago = ".$data['sigfe'].", pagado_por = '".$data['resp']."', fecha_pago_sistema = now(), comprobante = '".$data['comprobante']."' WHERE id =".$data['id'];
		$conector = new Conector();			
		$conector->conectar('facturacionv2');
		$conector->ejecutar($sql);
		$sql1="UPDATE firma_anticipos SET estado=1,firma='".$data['resp']."' WHERE estado=0 and id_anticipo=".$data['id_firma_anticipo'];

		$sql2="UPDATE solicitudes SET estado=6 WHERE id=".$data['id_soli'];
		$sql3="INSERT INTO firma_anticipos(unidad_negocio,fecha,updated_at,estado,id_anticipo)values(6,'$fecha','$fecha',0,".$data['id_firma_anticipo'].")";

		$conector1 = new Conector();			
		$conector1->conectar('anticipos');
		$conector1->ejecutar($sql1);
		$conector1->ejecutar($sql2);
		$conector1->ejecutar($sql3);
		$conector->desconectar();
	}
}