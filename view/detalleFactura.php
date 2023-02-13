<?php
session_start();
$permisos = $_SESSION['permiso']; 
$dtFactura = $_POST['data']['facturas'][0];
// highlight_string(print_r($dtFactura,true));
?>
<input type="hidden" value="<?=$dtFactura['docto_estado_id'];?>" id="dtestadofac">
<?php if ($dtFactura['docto_estado_id'] == 3) { ?>
  <div class="col-12 text-center">
    <a href="dataCompromisoSigfe.php?data=<?=$dtFactura['id'];?>" id="capaDCS" target="_blank" class="btn btn-primary my-3">Ver Datos para crear el compromiso sigfe</a>  
  </div>
<?php } ?>
<div class="col-md-3">
  <div class="input-group mb-3">
    <span>Numero de Documento</span>
    <div class="input-group input-group-seamless">
      <span class="input-group-prepend">
        <span class="input-group-text">
          <i class="material-icons">format_line_spacing</i>
        </span>
      </span>
      <input type="text" class="form-control" id="dtnumfac" value="<?=$dtFactura['numero'];?>"> 
    </div>
  </div>
</div>

<div class="col-md-3">
  <div class="input-group mb-3">
    <span>Monto</span>
    <div class="input-group input-group-seamless">
      <span class="input-group-prepend">
        <span class="input-group-text">
          <i class="material-icons">attach_money</i>
        </span>
      </span>
      <input type="number" id="dtvalor" value="<?=$dtFactura['monto'];?>" class="form-control"> 
    </div>
  </div>
</div>

<div class="col-md-6">
  <div class="input-group mb-3">
    <span>Proveedor</span>
    <div class="input-group input-group-seamless">
      <span class="input-group-prepend">
        <span class="input-group-text">
          <i class="material-icons">supervised_user_circle</i>
        </span>
      </span>
      <input type="text" class="form-control" readonly id="dtProveedor" value="<?=$dtFactura['proveNombre'];?>"> 
    </div>
  </div>
</div>

<div class="col-md-3">
  <div class="input-group mb-3">
    <span>Fecha de Factura</span>
    <div class="input-group input-group-seamless">
      <span class="input-group-prepend">
        <span class="input-group-text">
          <i class="material-icons">date_range</i>
        </span>
      </span>
      <input type="date" class="form-control" value="<?=$dtFactura['fecha_factura'];?>" id="dtfecfac"> 
    </div>
  </div>
</div>

<div class="col-md-3">
  <div class="input-group mb-3">
    <span>Fecha de Recepción</span>
    <div class="input-group input-group-seamless">
      <span class="input-group-prepend">
        <span class="input-group-text">
          <i class="material-icons">today</i>
        </span>
      </span>
      <input type="date" class="form-control" value="<?=$dtFactura['fecha_recepcion'];?>" id="dtfecRec"> 
    </div>
  </div>
</div>

<div class="col-md-3">
  <div class="input-group mb-3">
    <span>Fecha de Pago</span>
    <div class="input-group input-group-seamless">
      <span class="input-group-prepend">
        <span class="input-group-text">
          <i class="material-icons">date_range</i>
        </span>
      </span>
      <input type="date" class="form-control" value="<?=$dtFactura['fecha_pago'];?>" id="dtfechpago"> 
    </div>
  </div>
</div>

<div class="col-md-3" style="display: block;">
  <label class="mt-4" style="display: inline-block; cursor: pointer;">
    <?php if ($dtFactura['extra_presupuestaria'] == "") { ?>
      <input type="checkbox" id="extraPresup" style="cursor: pointer;">
    <?php }else{ ?>
      <input type="checkbox" id="extraPresup" checked disabled style="cursor: pointer;">
    <?php } ?>
    <span>Extrapresupuestaria</span>
  </label>
<!-- <br>
  <?php if ($dtFactura['n_sigfe_devengo'] == "") { ?>    
    <label class="" style="display: inline-block; cursor: pointer;">
      <input type="checkbox" id="sinfoliosigfe" style="cursor: pointer;">
      <span>Sin Devengo Sigfe</span>
    </label>
  <?php } ?>
  <br>
  <?php if ($dtFactura['n_sigfe_cpp'] == "") { ?>
    <label class="" style="display: inline-block; cursor: pointer;">
      <input type="checkbox" id="sinCppsigfe" style="cursor: pointer;">
      <span>Sin Compromiso Sigfe</span>
    </label>
    <?php } ?> -->
  </div>

  <div class="col-md-3">
    <div class="input-group mb-3">
      <span>N° Compromiso Sigfe</span>
      <div class="input-group input-group-seamless">
        <span class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">format_list_numbered</i>
          </span>
        </span>
        <?php if ($dtFactura['n_sigfe_cpp'] != "") { ?>
          <input type="text" class="form-control inputSigfeDTF" id="dtsigfeCpp" readonly value="<?=$dtFactura['n_sigfe_cpp'];?>">
        <?php }else{ ?>
          <input type="text" class="form-control inputSigfeDTF" id="dtsigfeCpp"> 
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="input-group mb-3">
      <span>N° Devengo Sigfe</span>
      <div class="input-group input-group-seamless">
        <span class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">format_list_numbered</i>
          </span>
        </span>
        <?php if ($dtFactura['n_sigfe_devengo'] != "") { ?>
          <input type="text" class="form-control" id="dtsigfeDev" readonly value="<?=$dtFactura['n_sigfe_devengo'];?>">
        <?php }else{ ?>
          <input type="text" class="form-control" id="dtsigfeDev"> 
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="input-group mb-3">
      <span>N° Pago Sigfe</span>
      <div class="input-group input-group-seamless">
        <span class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">format_list_numbered</i>
          </span>
        </span>
        <?php if ($dtFactura['n_sigfe_pago'] != "") { ?>
          <input type="text" class="form-control inputSigfeDTF" id="dtsigfePago" readonly value="<?=$dtFactura['n_sigfe_pago'];?>">
        <?php }else{ ?>
          <input type="text" class="form-control inputSigfeDTF" id="dtsigfePago"> 
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="input-group mb-3">
      <span>N° Compensatorio Sigfe</span>
      <div class="input-group input-group-seamless">
        <span class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">format_list_numbered</i>
          </span>
        </span>
        <?php if ($dtFactura['n_sigfe_compensatorio'] != "") { ?>
          <input type="text" class="form-control" id="dtsigfecomp" readonly value="<?=$dtFactura['n_sigfe_compensatorio'];?>">
        <?php }else{ ?>
          <input type="text" class="form-control" id="dtsigfecomp"> 
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="input-group mb-3">
      <span>OC del Portal</span>
      <div class="input-group input-group-seamless">
        <span class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">format_list_numbered</i>
          </span>
        </span>
        <?php if ($dtFactura['ocportal'] != "") { ?>
          <input type="text" class="form-control" readonly id="dtOcp" value="<?=$dtFactura['ocportal'];?>">
        <?php }else{ ?>
          <input type="text" class="form-control" id="dtOcp"> 
        <?php } ?>
      </div>
    </div>
  </div>


  <div class="col-md-3">
    <div class="input-group mb-3">
      <span>Sistema de Ingreso</span>
      <div class="input-group input-group-seamless">
        <span class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">format_list_numbered</i>
          </span>
        </span>
        <?php if ($dtFactura['sistema'] != "") { ?>
          <input type="text" class="form-control inputSigfeDTF" readonly value="<?=$dtFactura['sistema'];?>">
        <?php }else{ ?>
          <input type="text" class="form-control inputSigfeDTF" readonly id="dtSistema"> 
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="input-group mb-3">
      <span>URL</span>
      <div class="input-group input-group-seamless">
        <span class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">format_list_numbered</i>
          </span>
        </span>
        <?php if ($dtFactura['link'] != "") { ?>
          <input type="text" class="form-control" id="dtLink" readonly value="<?=$dtFactura['link'];?>">
        <?php }else{ ?>
          <input type="text" class="form-control" id="dtLink"> 
        <?php } ?>
      </div>
    </div>
  </div>