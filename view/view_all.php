<?php
@session_start();
require_once('../controller/todas_mis_facturas.php');

?>
<div class="main-content-container container-fluid px-4 ml-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4 mb-3 border-bottom">
        <div class="col-12 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Listado</span>
            <h3 class="page-title">Todos Mis Documentos</h3>
        </div>
    </div>
</div>
<div class="col-10 offset-1 mt-5">
    <table id="TablaMisFacturas" class="table table-hover table-responsive-xl" style="width:100%">
        <thead class="bg-primary rounded text-white">
            <tr>
                <th>N°</th>
                <th>Numero Factura</th>
                <th style="width: 120px;">Monto</th>
                <th>Rut</th>
                <th>Proveedor</th>
                <th style="width: 110px;">F. de Emision</th>
                <th style="width: 140px;">Estado</th>
                <th>OC Portal</th>
                <th style="width: 140px;">Observación</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // highlight_string(print_r($f,true));
            if ($f != NULL) {
                for ($i=0; $i < count($f); $i++) {
                    ?>
                    <tr class="">
                        <td ><?=$i+1;?></td>
                        <td class="tdselect"><?=$f[$i]['Factura N°'];?></td>
                        <td class="tdselect">$ <?=str_replace(",",".",number_format($f[$i]['monto']));?></td>
                        <td class="tdselect"><?=$f[$i]['proveedor_rut'];?></td>
                        <td class="tdselect"><?=$f[$i]['Proveedor'];?></td>
                        <td class="tdselect"><?=$f[$i]['fecha_factura'];?></td>
                        <td class="tdselect"><?=$f[$i]['estado'];?></td>
                        <td class="tdselect"><?=$f[$i]['ocportal'];?></td>
                        <td class="tdselect"><?=$f[$i]['observacion'];?></td>
                    </tr>
                    <?php 
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>N°</th>
                <th>Numero Factura</th>
                <th>Monto</th>
                <th>Proveedor</th>
                <th>F. de Emision</th>
                <th>Estado</th>
                <th>Observación</th>
            </tr>
        </tfoot>
    </table>
</div>
