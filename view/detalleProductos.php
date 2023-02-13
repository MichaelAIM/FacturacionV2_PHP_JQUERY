<?php 
  require_once('../../principal/Control/seguridad.php');
  $dtFactura = $_POST['data']['prods'];
  // highlight_string(print_r($dtFactura,true));
  for ($i=0; $i < count($dtFactura); $i++) { 
?>
<div class="col-md-4">
  <div class="card card-small card-post mb-4">
    <div class="card-footer border-top d-flex">
      <div class="card-post__author d-flex">
        <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('assets/images/producto.png');"></a>
        <div class="d-flex flex-column justify-content-center ml-3 mr-1">
          <span class="card-post__author-name" style="font-size: 10px;"><?=$dtFactura[$i]['pro_nombre'];?></span>
          <small class="small" style="font-family: sans-serif;">CANT: <?=$dtFactura[$i]['cantidad'];?> - PRECIO: <?=$dtFactura[$i]['pro_costo_unitario_incluye_todo'];?></small>
          <small class="mt-1 text-center">
            <a class="prodCircle" href="../ordenes_de_compra_1.2/Control/cpp_PDF.php?dato=<?=rawurlencode(encrypt($dtFactura[$i]['pro_id_cpp']));?>" target="_blank">CPP</a>
            <!-- <a class="prodCircle" href="/CPP?dato=<?=rawurlencode(encrypt($dtFactura[$i]['pro_id_cpp'])); ?>" target="_blank">CPP</a> -->
<?php if ($dtFactura[$i]['compra_id'] != '') { ?>
            <a class="prodCircle" href="../ordenes_de_compra_1.2/Control/orden_de_compra_PDF.php?dato=<?=rawurlencode(encrypt($dtFactura[$i]['compra_id']));?>" target="_blank">ORDEN</a>
            <!-- <a class="prodCircle" href="/OT?dato=<?=rawurlencode(encrypt($dtFactura[$i]['compra_id']));?>" target="_blank">ORDEN</a> -->
<?php } ?>
            <a class="prodCircle" href="../admin_bodega/Control/regenerarRecepcionID.ctrl.php?dato=<?=rawurlencode(encrypt($dtFactura[$i]['id_recepcion']));?>" target="_blank">RECEPCIÓN</a>
            <!-- <a class="prodCircle" href="/RECPDF?dato=<?=rawurlencode(encrypt($dtFactura[$i]['id_recepcion']));?>" target="_blank">RECEPCIÓN</a> -->
          </small>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
  }
?>   