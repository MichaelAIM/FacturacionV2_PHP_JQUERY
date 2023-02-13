<?php 
session_start();
$permisos = $_SESSION['permiso']; 
$fin = date(Y)+1; 
$inicio = 2012;
$recorre = $fin - $inicio;
?>


<div class="main-content-container container-fluid px-4">
	<div class="page-header row no-gutters py-4 mb-3 border-bottom">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
			<span class="text-uppercase page-subtitle">Busquedas de factura</span>
			<h3 class="page-title">Buscador</h3>
		</div>
	</div>
	<div class="row mb-2 mt-5">
		<?php for ($i=0; $i < $recorre; $i++) { ?>
<!-- 		<div class="col mb-4">
			<div class="btn-info rounded text-white text-center p-3 btnAnio" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);"><?#=$inicio+$i;?></div>
		</div> -->
	<?php } ?>
	<input type="hidden" name="" id="id_man2">
	<div class="col-3 mx-auto mb-4">
		<input type="hidden" value="0" class="idtipolistado">
		<div class="btn-info rounded text-white text-center p-3 btnMasFact" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);cursor: pointer;">Listado de Facturas</div>
	</div>
	<div class="col-3 mx-auto mb-4">
		<input type="hidden" value="1" class="idtipolistado">		
		<div class="btn-info rounded text-white text-center p-3 btnMasFact" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);cursor: pointer;">Listado Otros Documentos</div>
	</div>
	<div class="col-3 mx-auto mb-4">
		<input type="hidden" value="2" class="idtipolistado">		
		<div class="btn-info rounded text-white text-center p-3 btnMasFact" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);cursor: pointer;">Facturas Antiguas</div>
	</div>
</div>
<div class="row mt-5">
	<div class="col-12">
		<table id="tableSearch" class="table table-striped table-bordered table-hover table-responsive-lg" style="width:100%">
			<thead class="bg-primary rounded text-white"></thead>
		</table>
		<table id="tableSearch2" class="table table-striped table-bordered table-hover table-responsive-lg" style="width:100%">
			<thead class="bg-primary rounded text-white"></thead>
		</table>
	</div>
</div> 
</div>
<?php 
include('modals/modalDetalleFactura.php');
?>
