<?php 
session_start();
$permisos = $_SESSION['permiso']; 
?>
<input type="hidden" id="cant_nota_credito" value="<?=$_POST['data']['cantidad'];?>">
<?php 
$doctos = $_POST['data']['documentos'];
if ($doctos!=NULL) {
	for ($i=0; $i< count($doctos); $i++) {  
?>
	<tr>
		<td><?=$doctos[$i]['numero'];?></td>
		<td><?=$doctos[$i]['tipo'];?></td>
		<td>$ <?=$doctos[$i]['monto'];?></td>
		<td><?=$doctos[$i]['fecha_factura'];?></td>
		<td><?=$doctos[$i]['ocportal'];?></td>
		<td>
			<a href="<?=$doctos[$i]['link'];?>" target="_blank">
				<i class="far fa-file-pdf" style="font-size: 26px;"></i>
			</a>
		</td>
		<td><? if( !in_array(213,$permisos)) {?><i class="fa fa-window-close text-danger fa-2x" style="cursor: pointer;" aria-hidden="true" onclick="delete_asoc_documento(<?=$doctos[$i]['id'];?>)"></i><?}?></td>
	</tr>
<?php 
	}
}else{
?>
<tr>
	<td colspan="6">
		No registra Documentos asociados.
	</td>
</tr>
<?php
}
?>
