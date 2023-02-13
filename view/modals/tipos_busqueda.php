<!-- recorrer  -->
<?php 
$cpps = $_POST['data']['prods'];
for ($i=0; $i < count($cpps); $i++) { 
?>
<div class="col-12 mb-4">
  <div class="card card-small card-post card-post--aside card-post--1">
    <div class="card-post__image" style="background-image: url('assets/images/doc.jpg');min-height:auto;min-width: 100px;background-size: 90%;">
      <input type="hidden" value="<?=$cpps[$i]['pro_id_cpp'];?>" class="tpidcpp">
      <a class="card-post__category badge badge-pill badge-warning ver-prodcuto">Ver Productos</a>
      <div class="card-post__author d-flex">
      </div>
    </div>
    <div class="card-body row">
      <!-- content Modal-->
      <div class="col col-md-4">
        <div class="input-group">
          <span>N° CPP</span>
          <div class="input-group input-group-seamless">                        
            <input type="text" disabled value="<?=$cpps[$i]['cpp_num'];?>" class="form-control"> 
          </div>
        </div>
      </div>

      <div class="col col-md-4">
        <div class="input-group">
          <span>AÑO</span>
          <div class="input-group input-group-seamless">                        
            <input type="text" disabled  value="<?=$cpps[$i]['cpp_amio'];?>" class="form-control"> 
          </div>
        </div>
      </div>

      <div class="col col-md-4">
        <div class="input-group">
          <span>MONTO</span>
          <div class="input-group input-group-seamless">                       
            <input type="text"  disabled value="<?=$cpps[$i]['Total'];?>" class="form-control"> 
          </div>
        </div>
      </div>
      <!-- end content -->
     </div>
  </div>
</div>
<?php 
}
?>