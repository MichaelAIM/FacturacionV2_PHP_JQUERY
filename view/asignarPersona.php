<div class="main-content-container container-fluid px-4 ml-4">
	<div class="page-header row no-gutters py-4 mb-3 border-bottom">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
		  <span class="text-uppercase page-subtitle">Lista de facturas Acepta</span>
		  <h3 class="page-title">Asignar a funcionarios</h3>
		</div>
	</div>
	<div class="row mb-2 mt-5 w-100">	
		<div class="col-sm-12">
			<button type="button" class="btn btn-lg btn-primary" style="position: fixed; bottom: 30px; right: 50px;z-index: 1;" id="arrFacturasASG">Asignar</button>			
		</div>	
		<table class="table table-striped table-responsive rounded" style="width:100%" id="tblAsignfac">
			<thead>
				<tr>
					<th>N°</th>		
					<th></th>
					<!-- <th style="display: none;"></th> -->
					<th>Numero Factura</th>
					<th>Fecha Factura</th>
					<th style="min-width: 754px;">Proveedor</th>
					<th>Valor</th>					
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>

<!-- The Modal aaa-->

<?php 
  require_once('../models/FUNCIONARIOS.php');
  $func = new Funcionarios();
  $funcionario = $func->index();
?>

<div class="modal fade" id="mdlAsignar" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 350px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Seleccionar Funcionario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <select id="func_select">
			<?php 
				$funcionarios = $funcionario['funcionarios'];
			  	for ($i=0; $i < count($funcionarios); $i++) { 
			  		if ($funcionarios[$i]['revision'] == 1) {
			?>
				<option value="<?=$funcionarios[$i]['rut'];?>"><?=$funcionarios[$i]['nombre'];?></option>
			<?php
					}
			  	}
			?>
		</select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="asg-btn">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>