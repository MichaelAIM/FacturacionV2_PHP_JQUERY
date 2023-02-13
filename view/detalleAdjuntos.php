<?php 
// highlight_string(print_r($_POST['data'],true));
if ( $_POST['data']['facturas'] != '') {
	$dtFactura = $_POST['data']['facturas'];
	for ($i=0; $i < count($dtFactura); $i++) { 
?>
<div class="p-2" >
	<a href="<?=$dtFactura[$i]['ruta'];?>" target="_blank">
		<img src="assets/images/archivo.png" width="40" alt="" style="">
		<p><?=$dtFactura[$i]['nombre'];?></p>
	</a>
</div>
<?php 
	}
}
if ( $_POST['data']['cpp'] != '') {
	$adjCpp = $_POST['data']['cpp'];
	for ($i=0; $i < count($adjCpp); $i++) { 
		if ($adjCpp[$i]['mes'] < 10) {
			$mes = '0'.$adjCpp[$i]['mes'];
		}else{
			$mes = $adjCpp[$i]['mes'];
		}
?>
<div class="p-2" >
	<a href="/PDFCPP/<?= $adjCpp[$i]['anio'].'/'.$mes.'/'.rawurlencode($adjCpp[$i]['adj_nombre']); ?>" target="_blank">
		<img src="assets/images/archivo.png" width="40" alt="" style="">
		<p><?=$adjCpp[$i]['adj_nombre_subio'];?></p>
	</a>
</div>
<?php 
	}
}
if ( $_POST['data']['recep'] != '') {
	$adjrecep = $_POST['data']['recep'];
	for ($i=0; $i < count($adjrecep); $i++) { 
		if ($adjrecep[$i]['mes'] < 10) {
			$mes = '0'.$adjrecep[$i]['mes'];
		}else{
			$mes = $adjrecep[$i]['mes'];
		}
?>
<div class="p-2" >
	<a href="/BOD/<?= $adjrecep[$i]['tipo_docto'].'/'.$adjrecep[$i]['anio'].'/'.$mes.'/'.rawurlencode($adjrecep[$i]['adj_nombre']); ?>" target="_blank">
		<img src="assets/images/archivo.png" width="40" alt="" style="">
		<p>Adj_Recepción_<?=$adjrecep[$i]['adj_id'];?></p>
	</a>
</div>
<?php 
	}
}
?>