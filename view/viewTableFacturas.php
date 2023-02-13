<input type="hidden" id="min" value=""/>
<input type="hidden" id="max" value=""/>
<table id="TablaEnPLazo" class="table table-hover table-responsive-xl" style="width:100%">
	<thead class="bg-primary rounded text-white">
		<tr>
			<th>N°</th>
			<th>Numero de Factura</th>
			<th>Proveedor</th>
			<th>Monto</th>
			<th style="width: 60px;">Fecha</th>
			<th>Días</th>
			<th>Estado</th>
			<th>Responsable</th>
			<th></th>
		</tr>
	</thead>
	<tbody>		
			<?php
	    	// highlight_string(print_r($_POST,true));
			$facturas_enplazo = json_decode($_POST['datos'],true);
			if ($facturas_enplazo != NULL) {
			 	for ($i=0; $i < count($facturas_enplazo); $i++) {
			 		$date2 = new DateTime('NOW');
					$date1 = new DateTime($facturas_enplazo[$i]['fecha_factura']);
					$diff = $date1->diff($date2);      
					$dias = $diff->days;
					if ($dias > 29) {
						$colorDa = 'table-danger';
					}else if ($dias < 30 && $dias > 19) {
						$colorDa = 'table-warning';
					}else{
						$colorDa = "";
					}					
			?>
			 		<tr class="<?=$colorDa;?>">
			 			<td><?=$i+1;?></td>
			 			<td><?=$facturas_enplazo[$i]['numero'];?></td>
			 			<td><?=$facturas_enplazo[$i]['proveedor'];?></td>
			 			<td><?=$facturas_enplazo[$i]['monto'];?></td>
			 			<td><?=$facturas_enplazo[$i]['fecha_factura'];?></td>
			 			<td><?=$dias;?></td>
			 			<td><?=$facturas_enplazo[$i]['estado'];?></td>
			 			<td><?=$facturas_enplazo[$i]['per_nombre'];?></td>
			 			<td><a href="<?=$facturas_enplazo[$i]['link'];?>" target="_blank"><i class="far fa-file-pdf"></i></a></td>
			 		</tr>
			<?php
				}
			}else{
			?>
			 	<tr>
			 		<td>No hay data</td>
			 	</tr>
			<?php 	
			}
			?>
	</tbody>
</table>