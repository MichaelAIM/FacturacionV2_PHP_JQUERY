<?php 
@session_start();
$permisos = $_SESSION['permiso'];
// highlight_string(print_r($_POST,true));
?>
 <? for ($i=0; $i < count($_SESSION['permiso']); $i++) { 
                 $numero=0;
                if($_SESSION['permiso'][$i]===213 ){
                  $numero=1;

                  ?>

               


                <? }
              } ?>
               <input type="hidden" name="" value="<?=$numero?>" id="id_man_modal">
<!-- The Modal -->
<div class="modal hide fade" id="mdlFactura" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable" style="width:100%;max-width: 1000px;">
    <div class="modal-content">    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title tituloModalFactura">Documento : ( en <span id="estadofctmodal" style="font-weight: 800;"></span> )</h4>
        <input type="hidden" id="dtFacturaEST">
        <button type="button" class="close text-white bg-danger" style="font-weight: bold;" data-dismiss="modal">x</button>
      </div>      
      <!-- Modal body -->
      <div class="modal-body" id="tbl-mdlFactura">
        <div class="row">          
          <section class="design-process-section" id="process-tab" style="width: 100%;">
            <div class="container">
              <div class="row">
                <div class="col-12"> 
                  <!-- design process steps--> 
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
                    <li role="presentation" class="active"><a href="#discover" aria-controls="discover" role="tab" data-toggle="tab"><i class="fa fa-clipboard" aria-hidden="true"></i>
                      <p>DOCUMENTO</p>
                    </a></li>
                    <li role="presentation"><a href="#asosiation" aria-controls="asosiation" role="tab" data-toggle="tab"><i class="far fa-object-ungroup" aria-hidden="true"></i>
                      <p>ASOCIACIONES</p>
                    </a></li> 
                    <li role="presentation"><a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                      <p>PRODUCTOS</p>
                    </a></li>
                    <li role="presentation"><a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab"><i class="fa fa-qrcode" aria-hidden="true"></i>
                      <p>ADJUNTOS</p>
                    </a></li>
                    <li role="presentation"><a href="#content" aria-controls="content" role="tab" data-toggle="tab"><i class="fa fa-newspaper-o" aria-hidden="true"></i>
                      <p>OBSERVACIONES</p>
                    </a></li>
                    <li role="presentation"><a href="#reporting" aria-controls="reporting" role="tab" data-toggle="tab"><i class="fa fa-history" aria-hidden="true"></i>
                      <p>HISTORIAL</p>
                    </a></li>
                  </ul>
                  <!-- end design process steps--> 
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="discover">
                      <div class="design-process-content">                                                 
                        <div class="row" id="datosFactura" style="margin-left: 5px;">
                        </div>
                        <div class="row">
                          <button id="btnUpdateDTFactura" class="bg-primary rounded text-white text-center pl-3 pr-3 pt-2 pb-2 mb-2 mt-2"  style="box-shadow: inset 0 0 5px rgba(0,0,0,.2); margin: auto;">Actualizar Datos</button>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="strategy">
                      <div class="design-process-content">
                        <h3 class="semi-bold">Productos</h3>
                        <div class="row" id="productosFactura">
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="asosiation">
                      <div class="design-process-content">
                        <h3 class="semi-bold"></h3>
                        <div id="asociarFacturas">
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="optimization">
                      <div class="design-process-content text-center">
                        <h3 class="semi-bold">Adjuntos</h3>
                        <div class="row text-center" id="adjuntosfactura" style="display: inline-flex;cursor: pointer;margin: auto;">
                        </div>
                        <div class="row">
                          <div class="col-md-6 offset-md-3">
                            <div class="input-group">
                              <span style="padding-top: 5px;margin-right: 20px;">Subir Archivo:</span>
                              <form action="controller/uploadFileController.php" method="post" enctype="multipart/form-data" id="frm_adjunto_doc">
                                <div class="input-group input-group-seamless">
                                  <div class="custom-file mb-3">
                                    <input type="file" name="file[]" id="fileAdjuntoDoc" multiple>
                                    <input type="hidden" id="dtFacturaID" name="idDocto">
                                  </div>
                                </div>
                                <? if( !in_array(213,$permisos)) {?>
                                <button class="bg-primary rounded text-white text-center pl-3 pr-3 pt-2 pb-2"  style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);" id="dtBtnAdjunto">Subir Archivo</button>
                                <?}?>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="content">
                      <div class="design-process-content">
                        <h3 class="semi-bold">Observaciones</h3>
                        <div class="row">
                          <div class="col-md-4">
                            <textarea class="form-control" name="" id="dtTxtObservacion" rows="5">Escribe una nueva Observación...</textarea>
                                 <? if( !in_array(213,$permisos)) {?>
                            <button id="btnAddObservacion" class="bg-primary rounded text-white text-center pl-3 pr-3 pt-2 pb-2 mb-2 mt-2"  style="box-shadow: inset 0 0 5px rgba(0,0,0,.2); margin: auto;">Guardar Observación</button>
                            <?}?>
                          </div>
                          <div class="col-md-8">
                            <div class="row" id="observacionesFactura"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="reporting">
                      <div class="design-process-content">
                        <div class="row text-center" id="historialF">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>  
      </div>      
      <!-- Modal footer -->
      <div class="modal-footer" id="footerDetalleFactura">

        <?php if(in_array(193, $permisos) || in_array(194, $permisos)){ ?>
          <button id="buttonReasignar" class="bg-secondary rounded text-white text-center pl-3 pr-3 pt-2 pb-2" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Reasignar</button>
        <?php } ?>

        <button id="buttonReversarEstado" class="bg-warning rounded text-white text-center pl-3 pr-3 pt-2 pb-2" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Reversar</button>

        <button id="buttonRechazarEstado" class="bg-danger rounded text-white text-center pl-3 pr-3 pt-2 pb-2" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Rechazar</button>

        <button id="buttonR1Estado" class="bg-success rounded text-white text-center pl-3 pr-3 pt-2 pb-2" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Aceptar</button>

        <button id="buttonAcompraEstado" class="bg-info rounded text-white text-center pl-3 pr-3 pt-2 pb-2 mr-2" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Enviar a compra</button>

        <button id="buttonR2Estado" class="bg-success rounded text-white text-center pl-3 pr-3 pt-2 pb-2 mr-2" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Enviar a Devengo</button>

        <button id="buttonDVEstado" class="bg-primary rounded text-white text-center pl-3 pr-3 pt-2 pb-2" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Enviar a pago</button>

        <button id="buttonQuitarEstado" class="bg-danger rounded text-white text-center pl-3 pr-3 pt-2 pb-2" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Quitar de la bandeja</button>

        <button id="buttonPagadoEstado" class="bg-primary rounded text-white text-center pl-3 pr-3 pt-2 pb-2" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Pagar</button>

        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button> -->
      </div>      
    </div>
  </div>
</div>  


<?php 
require_once('../models/FUNCIONARIOS.php');
$func = new Funcionarios();
$funcionario = $func->index();
?>

<div class="modal fade" id="mdlAsignar2" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 350px;">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLongTitle">Seleccionar Funcionario</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <select id="func_select2">
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
        <button type="button" class="btn btn-primary" id="asg-btn2">Asignar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>