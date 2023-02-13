<?php 
// highlight_string(print_r($_POST,true));
require_once('../../principal/Control/seguridad.php');
if ($_POST['data']['documentos'] != '') {
	$recep = $_POST['data']['documentos'];
}
if ($recep!=NULL) {
?>
<input type="hidden" value="<?=count($recep);?>" id="countRecepcionesAsoc">
<?php
	for ($i=0; $i < count($recep); $i++) { 
?>
	<div class="text-center" style="display: grid;">

		<i class="fa fa-window-close text-danger fa-2x btnDelRecepAsoc" style="cursor: pointer;" aria-hidden="true" onclick="delete_asoc_recepcion(<?=$recep[$i]['id_recepcion'];?>)"></i>

		<a href="../admin_bodega/Control/regenerarRecepcionID.ctrl.php?dato=<?=rawurlencode(encrypt($recep[$i]['id_recepcion']));?>" class="mx-4 text-center" target="_blank">
			<img src="assets/images/archivo.png" width="40" alt="" style="">
			<p><?=$recep[$i]['num_recepcion']." - ".$recep[$i]['year_recepcion'];?></p>		
		</a>
		<!-- <a class="prodCircle" href="/RECPDF?dato=<?=rawurlencode(encrypt($recep[$i]['id_recepcion']));?>" target="_blank">RECEPCIÓN</a> -->
	</div>
<?php 
	}
}else{
?>
<p>No registra Recepciones asociadas.</p>
<?php 
} 
?>