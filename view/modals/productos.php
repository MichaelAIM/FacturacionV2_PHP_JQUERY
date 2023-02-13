<div class="col-12 d-flex">
  <a href="#" class="btn badge-pill badge-success align-self-end btn-addAllProds ml-auto" style="padding: 10px;">Agregar Todos</a>
</div>
<?php 
$cpps = $_POST['data']['prods'];
  for ($i=0; $i < count($cpps); $i++) {
    $PENDIENTES = (((int)$cpps[$i]['pro_cantidad']) - ((int)$cpps[$i]['PRODUCTO_PAGADO']));
?>
<div class="col-12 mb-4 reglon">
  <div class="card card-small card-post card-post--aside card-post--1">
    <div class="card-post__image" style="background-image: url('assets/images/producto.png');background-size: 70%">
      <input type="hidden" class="pronombre-cpp" value="<?=$cpps[$i]['pro_nombre'];?>">      
      <input type="hidden" class="proid-cpp" value="<?=$cpps[$i]['pro_id'];?>">
      <input type="hidden" class="num-cpp" value="<?=$cpps[$i]['cpp_num'];?>">      
      <input type="hidden" class="cant-prodcpp" value="<?=$PENDIENTES;?>">      
      <a href="#" class="card-post__category badge badge-pill badge-success btn-addProds">Agregar</a>
      <div class="card-post__author d-flex">
      </div>
    </div>
    <div class="card-body row">
      <div class="col col-md-2">
        <div class="input-group">
          <span>Cantidad</span>
          <div class="input-group input-group-seamless">                         
            <input type="number" value="<?=$PENDIENTES;?>" onkeyup="validarCantidad(<?=$PENDIENTES;?>,this.value)" class="form-control cantProds" data-toggle="tooltip" data-placement="top" style="font-family: sans-serif;" > 
          </div>
        </div>
      </div>
      <div class="col col-md-3">
        <div class="input-group">
          <span>V. Unitario</span>
          <div class="input-group input-group-seamless">                          
            <input type="text" value="<?=$cpps[$i]['pro_precio'];?>" class="form-control" readonly> 
          </div>
        </div>
      </div>
      <div class="col col-md-7">
        <div class="input-group">
          <span>Producto</span>
          <div class="input-group input-group-seamless">                          
            <input type="text" value="<?=$cpps[$i]['pro_nombre'];?>" class="form-control" readonly> 
          </div>
        </div>
      </div>
      <div class="col col-md-3">
        <div class="input-group">
          <span>Total</span>
          <div class="input-group input-group-seamless">                         
            <input type="text" value="<?=$cpps[$i]['gasto_pre_monto'];?>" class="form-control" readonly> 
          </div>
        </div>
      </div>
      <div class="col col-md-6">
        <div class="input-group">
          <span>Proveedor</span>
          <div class="input-group input-group-seamless">                          
            <input type="text" value="<?=$cpps[$i]['cpp_proveedor_nombre'];?>" class="form-control" readonly> 
          </div>
        </div>
      </div>
      <div class="col col-md-3">
        <div class="input-group">
          <span>Estado Producto</span>
          <div class="input-group input-group-seamless">                          
            <input type="text" value="<?=$cpps[$i]['id_estado_producto_nombre'];?>" class="form-control" readonly> 
          </div>
        </div>
      </div>
      <div class="col col-md-12">
        <div class="input-group">
          <span>Observación</span>
          <div class="input-group input-group-seamless">                          
            <textarea rows="2" class="form-control" readonly><?=$cpps[$i]['pro_descripcion'];?></textarea> 
          </div>
        </div>
      </div>
     </div>
  </div>
</div>
<?php 
}
?>