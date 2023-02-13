<?php 
require_once('../models/FUNCIONARIOS.php');
$func = new Funcionarios();
$funcionario = $func->index();
?>
<div class="modal fade" id="mdlAsignarB" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
		<input type="hidden" id="idDBH">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="asg-btn">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>