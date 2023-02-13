<!-- The Modal aaa-->
<?php 
  require_once('models/FUNCIONARIOS.php.php');
  $func = new Funcionarios();
  $funcionarios = $func->index();
?>
<div class="modal hide fade" id="mdlAsignar">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">    
      <!-- Modal Header -->
      <div class="modal-header">
        <h1 class="modal-title"></h1>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>      
            <!-- Modal body -->
      <div class="modal-body">
        <h3>Selecionar</h3>
          <div class="row" id="masg-body">
            <form action="">
              <select name="func_select">
                <?php 
                  for ($i=0; $i < count($funcionarios); $i++) { 
                ?>
                <option value="<?=$funcionarios[$i]['rut'];?>"><?=$funcionarios[$i]['nombre'];?></option>
                <?php
                  }
                ?>
              </select>
               <button type="button" class="btn btn-danger" id="asg-btn">Guardar Datos</button>
            </form>
          </div>  
      </div>      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>       
    </div>
  </div>
</div>  