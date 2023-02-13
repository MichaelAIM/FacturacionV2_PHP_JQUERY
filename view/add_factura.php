<div class="main-content-container container-fluid px-4">
  <!-- Page Header -->
  <div class="page-header row no-gutters py-4 mb-3 border-bottom">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
      <span class="text-uppercase page-subtitle">nueva factura</span>
      <h3 class="page-title">Crear o Asociar</h3>
    </div>
  </div>
  <!-- /Page Header -->
  <div class="row">
    <div class="col-12">
      <h4 class="text-center mb-5">Buscador de Recepciónes</h4>
      <div class="row mb-2" style="justify-content: center;">
        <div class="card card-small mb-4 ">
          <div class="card-header border-bottom collapsed" data-toggle="collapse" href="#collapseTwo">
            <a class="pt-2">Buscar x N° OC PORTAL:</a>
            <form class="form-inline mt-2">
              <input type="text" class="form-control m-2" id="nOCP" placeholder="Numero">
              <button type="button" class="btn btn-primary" id="searchOC">Buscar</button>
            </form>
          </div>
        </div>
        <div class="card card-small mb-4 ml-5">
          <div class="card-header border-bottom collapsed" data-toggle="collapse" href="#collapseTwo">
            <a class="pt-2">Buscar x N° RECEPCIÓN:</a>
            <form class="form-inline mt-2">
              <input type="text" class="form-control m-2" id="nRECP" placeholder="Numero">
              <input type="text" class="form-control m-2" id="yRECP"  placeholder="Año">
              <button type="button" class="btn btn-primary" id="searchR">Buscar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="selectR"></div>
</div>
<?php 
include('modals/modalAddFactura.php');
?>
