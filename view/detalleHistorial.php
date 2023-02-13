<?php
// highlight_string(print_r($_POST,true));
setlocale(LC_TIME, 'spanish'); 
if ($_POST['data']['facturas'] != '') {
   $data = $_POST['data']['facturas'];
   $lineEstado = $_POST['est']["estados"];
}
if ($_POST['data']['asign'] != '') {
   $asg = $_POST['data']['asign'];
}else{
   $asg[0]['Funcionario'] = 'NO Registra Asignaciones';   
}
?>
<div class="container">
   <?php if ($_POST['data']['factoring'] != '') { 
   $factoring = $_POST['data']['factoring'];
   ?>
   <div class="row mt-2">
      <div class="col-12">
         <table class="table">
            <thead style="background-color: #65aee0; color: #fff; font-weight: 600;">
               <tr>
                  <th colspan="5">
                     <!-- <p class="tracking-status text-tight">FACTORING</p> -->
                     <p class="text-white" style="font-weight: 600;font-size: 1.1rem;">FACTORING</p>                     
                     </th>
                  </tr>
                  <tr>
                     <th>Rut factoring:</th>
                     <th>Proveedor factoring:</th>
                     <th>Fecha de la cesion:</th>
                     <th>Fecha de recepción:</th>
                     <th>Adjunto</th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
               // highlight_string(print_r($asg,true));
                  for ($i=0; $i < count($factoring); $i++) { ?>
                     <tr>
                        <td><?=$factoring[$i]['prov_rut'];?></td>
                        <td><?=$factoring[$i]['prov_fact'];?></td>
                        <td><?=$factoring[$i]['fecha_cedido'];?></td>
                        <td><?=$factoring[$i]['fecha_recepcion'];?></td>
                        <td><a href="factoring/<?=$factoring[$i]['adjunto'];?>" target="_blank">
                           <img src="assets/images/archivo.png" width="20" alt="" style="">
                        </a></td>
                     </tr>
                  <?php } ?>
               </tbody>       
            </table>
         </div>
      </div>
   <?php } ?>

   <div class="row mt-2"> 
      <div class="col-md-12 col-lg-12">
         <div id="tracking-pre"></div>
         <div id="tracking">
            <div class="text-center tracking-status-intransit">
               <p class="tracking-status text-tight">Historial de la Factura</p>
            </div>
            <div class="progress mb-2">
               <?php 
               if ($data[0]['estado_id'] !='') {
                  $estadoF = $data[0]['estado_id'];
                  if($estadoF == 6 || $estadoF == 8){ 
                     ?>
                     <div class="progress-bar bg-danger" style="width:100%">
                        RECHAZADA
                     </div>
                     <?php
                  }else{
                     for ($i=0; $i < $estadoF; $i++) {    
                        ?>
                        <div class="progress-bar bg-primary" style="width:16.6%">
                           <?php echo $lineEstado[$i]["estado"]; ?>
                        </div>
                        <?php
                     } 
                  }
               }            
               ?>
            </div>
            <div class="tracking-list" style="font-size: 12px;">
               <?php 
               if ($data != '') {
                  for ($i=0; $i < count($data) ; $i++) { 
                     $miFecha = date('j F, Y',strtotime($data[$i]['created_at']));
                     $bg = 'bg-info';
                     $dev = "PASO A ";
                     switch ($data[$i]['estado_id']) {
                        case 1:
                        $estado = "IN";
                        $bg = 'bg-success';                  
                        break;
                        case 2:
                        $estado = "R1";
                        break;
                        case 3:
                        $estado = "R2";
                        break;
                        case 4:
                        $estado = "CP";
                        $bg = 'bg-warning';                           
                        break;
                        case 5:
                        $estado = "TE";
                        break;
                        case 6:
                        $estado = "RE";
                        $bg = 'bg-danger';
                        $dev = 'ES ';
                        break;
                        case 7:
                        $estado = "PA";
                        $bg = 'bg-primary';
                        break;
                        case 8:
                        $estado = "QB";
                        $bg = 'bg-danger';
                        $dev = 'SE ';
                        break;
                     }
                     ?>
                     <div class="tracking-item">
                        <div class="tracking-icon status-intransit <?=$bg;?>">
                           <p><?=$estado;?></p>
                        </div>
                        <div class="tracking-date"><?=strtoupper(strftime("%d %B, %Y", strtotime($data[$i]['created_at'])));?><span><?=date('g:i A',strtotime($data[$i]['created_at']));?></span></div>
                        <div class="tracking-content">LA FACTURA <?=$dev?> <?=$data[$i]['estado'];?> Y DEMORÓ <?=$data[$i]['dias'];?> DÍAS<span>POR <?=$data[$i]['per_nombre'];?></span></div>
                     </div>
                     <?php 
                  }
               }
               ?>
            </div>
         </div>
      </div>
   </div>

   <div class="row mt-2">
      <div class="col-12">
         <table class="table">
            <thead style="background-color: #65aee0; color: #fff; font-weight: 600;">
               <tr>
                  <th colspan="2">
                     <p class="text-white" style="font-weight: 600;font-size: 1.1rem;">Historial de Asociaciones</p>                     
                  </th>
               </tr>
               <tr>
                  <th>Funcionario</th>
                  <th>Fecha</th>
               </tr>
            </thead>
            <tbody>
               <?php 
               // highlight_string(print_r($asg,true));
               for ($i=0; $i < count($asg); $i++) { ?>
                  <tr>
                     <td><?=$asg[$i]['Funcionario'];?></td>
                     <td><?=$asg[$i]['created_at'];?></td>
                  </tr>
               <?php } ?>
            </tbody>       
         </table>
      </div>
   </div>
</div>