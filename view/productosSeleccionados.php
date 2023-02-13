<?php 
$cpps = $_POST['data'];
  for ($i=0; $i < count($cpps); $i++) {
?>
<div class="col-lg-3">
  <div class="card card-small card-post mb-4">
    <div class="card-footer border-top d-flex">
      <div class="card-post__author d-flex">
        <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('assets/images/producto.png');"></a>
        <div class="d-flex flex-column justify-content-center ml-3 mr-1">
          <span class="card-post__author-name" style="font-size: 10px;"><?=$cpps[$i]["nombrePro"]; ?></span>
          <small class="small" style="font-family: sans-serif;">CANTIDAD: <?=$cpps[$i]["cantidad"]; ?>  - CPP : <?=$cpps[$i]["numcpp"]; ?></small>
        </div>
      </div>
      <div class="my-auto ml-auto">
      	<input type="hidden" class="productoid" value="<?=$cpps[$i]["idpro"]; ?>">
        <a class="btn btn-sm btn-danger borrarProducto" href="#" style="line-height: 0;padding: 10px">
          <i class="fa fa-trash mr-1"></i></a>
      </div>
    </div>
  </div>
</div>
<?php 
}
?>