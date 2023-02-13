<?php 
require_once('../controller/listarCCController.php');
$Scc= $cc['cc'];
?>
<div class="modal hide fade" id="mdlAddFactura">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">    
      <!-- Modal Header -->
      <div class="modal-header">
        <h3 class="modal-title">Facturas</h3>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>      
            <!-- Modal body -->
      <form action="controller/updateRecepcionController.php" method="post" id="frmFact">
        <div class="modal-body">
          <div class="row mt-3">
            <div class="col-md-4" id="newFactura">
              <div class="input-group mb-3">
                <span>Numero de Factura</span>
                <div class="input-group input-group-seamless">
                  <span class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">format_line_spacing</i>
                    </span>
                  </span>
                  <input type="text" class="form-control" id="numfac" name="numfac" placeholder="0"> 
                  <input type="hidden" name="id_recepcion" id="id_recepcion">
                  <input type="hidden" name="yearR" id="year_recepcion">                  
                  <input type="hidden" name="numR" id="num_recepcion">                  
                  <input type="hidden" name="numFOLD" id="num_fold">                  
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group mb-3">
                <span>Fecha de Factura</span>
                <div class="input-group input-group-seamless">
                  <span class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">date_range</i>
                    </span>
                  </span>
                  <input type="date" class="form-control" id="fecfac" name="fecfac" onblur="CountDias()"> 
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group mb-3">
                <span>Fecha de Recepción</span>
                <div class="input-group input-group-seamless">
                  <span class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">today</i>
                    </span>
                  </span>
                  <input type="date" class="form-control" name="fecRec" id="fecRec" onblur="CountDias()"> 
                </div>
              </div>
            </div>            
            <div class="col-md-3">
              <div class="input-group">
                <span>Monto</span>
                <div class="input-group input-group-seamless">
                  <span class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">attach_money</i>
                    </span>
                  </span>
                  <input type="number" id="valor" name="valor" class="form-control" placeholder="Monto"> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-group mb-3">
                <span>Proveedor</span>
                <div class="input-group input-group-seamless">
                  <span class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">account_box</i>
                    </span>
                  </span>
                  <input type="text" class="form-control" name="proveedor" id="proveedor" placeholder="76258987-8"> 
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="ccosto" class="mb-0">Centro de Costos</label>
                <select class="form-control" id="ccosto" name="ccosto">
                  <?php
                    for ($i=0; $i < count($Scc); $i++) { 
                  ?>
                      <option value="<?=$Scc[$i]['cc_id'];?>"><?=$Scc[$i]['cc_nombre'];?></option>                    
                  <?php 
                    } 
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </form>      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="saveFactura">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>       
    </div>
  </div>
</div>  