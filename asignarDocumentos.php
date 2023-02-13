<?php 
  require_once('models/conector.class.php');
  $sql  = "SELECT asignaciones.id_documentos FROM asignaciones INNER JOIN documentos ON asignaciones.id_documentos = documentos.id WHERE documentos.docto_estado_id = 3 AND asignaciones.funcionario = '18313287-3' AND asignaciones.estado = 1";
  $conector = new Conector();
  $conector->conectar('facturacionv2');
  $conector->ejecutar($sql);
  $cuantos = $conector->recuperar_afectadas();
  if($cuantos > 0){
    $response['asoc'] = array();
    for($i = 0; $i < $cuantos; $i++){
      $conector->set_fila();
      array_push($response['asoc'],$conector->get_fila());
    }
  }else{
    $response = NULL;
  }
  $asociaciones = $response['asoc'];
  for ($i=0; $i < count($asociaciones); $i++) { 
    $sql = "INSERT INTO asignaciones(asignador, funcionario, id_documentos, estado) VALUES ('16467901-2','19868689-1',".$asociaciones[$i]['id_documentos'].",1)";
    $conector->ejecutar($sql);
  }
  highlight_string(print_r($asociaciones,true));
  $conector->desconectar();
?>