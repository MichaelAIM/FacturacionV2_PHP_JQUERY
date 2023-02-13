<?php 
$data = $_POST['data']['facturas'];
?>
<div class="container mt-5">
  <table class="table table-sm">
    <thead>
      <tr>
        <th scope="col">Numero recepción</th>
        <th scope="col">Fecha</th>
        <th scope="col">Proveedor</th>
        <th scope="col">Tipo Documento</th>
        <th scope="col">Numero Documento</th>
        <th scope="col">OC PORTAL</th>        
        <th scope="col">CPP</th>
        <th scope="col">OT</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (count($data) > 0) {
        for ($i=0; $i < count($data); $i++) { ?>
          <tr>
            <th scope="row" class=""><?=$data[$i]['num_recepcion'];?></th>
            <td><?=$data[$i]['fecha_recepcion'];?></td>
            <td><?=$data[$i]['cpp_proveedor_nombre'];?></td>
            <td><?=$data[$i]['nombre_documento'];?></td>
            <td><?=$data[$i]['num_docto'];?></td>
            <td><?=$data[$i]['cpp_id_oc_portal'];?></td>
            <td><?=$data[$i]['cpp_num'];?></td>
            <td><?=$data[$i]['compra_numero'];?></td>
            <td>
              <input type="hidden" class="numFacturaOLD" value="<?=$data[$i]['id_cpp'];?>">
              <input type="hidden" class="idRecepcion" value="<?=$data[$i]['id_recepcion'];?>">
              <button class="btnaddRecp btn btn-info">Actualizar</button>
            </td>
          </tr>
          <?php 
        } 
      }else{
      ?>
      <tr>
        <th></th>
        <td colspan=9>NO Existen recepciones con ese numero.</td>
      </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>