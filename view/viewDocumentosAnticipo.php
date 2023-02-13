<?php 
$doctos = $_POST['data']['documentos'];
$bdr = 0;
if ($doctos!=NULL) {
	$bdr = 1;
	for ($i=0; $i< count($doctos); $i++) {  
		?>
		<tr>
			<td><?=$doctos[$i]['numero'];?></td>
			<td>$ <?=$doctos[$i]['monto'];?></td>
			<td><?=$doctos[$i]['fecha_pago'];?></td>
			<td><?=$doctos[$i]['sigfe_pago'];?></td>
			<td><i class="fa fa-window-close text-danger fa-2x" style="cursor: pointer;" aria-hidden="true" onclick="delete_asoc_anticipo(<?=$doctos[$i]['idHas'];?>)"></i></td>
		</tr>
		<?php 
	}
}else{
	?>
	<tr>
		<td colspan="5">		
			No registra Anticipos asociados.
		</td>
	</tr>
	<?php
}
?>
<input type="hidden" value="<?=$bdr;?>" id="cnAnticipo">