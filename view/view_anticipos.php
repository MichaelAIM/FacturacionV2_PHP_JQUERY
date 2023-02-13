<?php
@session_start();
require_once('../controller/indexAnticipo.php');
require_once('../../intranet2.0/controller/seguridad.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
			color: #fff;
			background-color: #007bff ;
			border-color: #ddd;
		}
		.nav-tabs .nav-link {
			background-color: #fff ;
			border-color: #ddd;
		}
		fieldset.scheduler-border {
			border: 1px groove #ddd !important;
			padding: 0 1.4em 1.4em 1.4em !important;
			margin: 0 0 1.5em 0 !important;
			-webkit-box-shadow:  0px 0px 0px 0px #000;
			box-shadow:  0px 0px 0px 0px #000;
		}
		legend.scheduler-border {
			font-size: 1.2em !important;
			font-weight: bold !important;
			text-align: left !important;
			width:auto;
			padding:0 10px;
			border-bottom:none;
		}
	</style>




</head>





<body>
	<input type="hidden" value="<?=$_SESSION['rut'];?>" id="rutQuePaga">
	<div class="main-content-container container-fluid px-4 ml-4">
		<!-- Page Header -->
		<div class="page-header row no-gutters py-4 mb-3 border-bottom">
			<div class="col-12 text-center text-sm-left mb-0">
				<span class="text-uppercase page-subtitle">Listado de Anticipos</span>
				<h3 class="page-title">Anticipos Disponibles para Pago</h3>
			</div>
		</div>
	</div>
	<div class="row m-5" style="min-height: 60vh;">
		<div class="row">
			<div class="col-sm-12 mt-2">
				<div role="tabpanel">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active nav-item">
							<a href="#Aproveedores" class="nav-link active" aria-controls="" data-toggle="tab" role="tab">A PROVEEDORES</a>   
						</li>
						<li role="presentation" class="nav-item">
							<a href="#fondoFijo" class="nav-link" aria-controls="" data-toggle="tab" role="tab">FONDO FIJO</a>
						</li>
						<!-- <li role="presentation" class="nav-item">
							<a href="#fondoFijodev" class="nav-link" aria-controls="" data-toggle="tab" role="tab">FONDO FIJO DEVOLUCIONES</a>
						</li> -->
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" role="tabpanel" id="Aproveedores">
							<br><br>
							<table id="tblAprovedores" class="table table-striped table-hover table-responsive-xl" style="width:100%">
								<thead class="bg-primary rounded text-white">
									<tr>
										<th>Numero</th>
										<th>Año</th>
										<th style="min-width: 150px;">Proveedor</th>
										<th>Monto</th>
										<th>Cpp</th>
										<th>Adjuntos</th>
										<th style="min-width: 210px;"></th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i=0; $i < count($anticipos); $i++) {  ?>
										<tr>
											<td><?=$anticipos[$i]['numero'];?></td>
											<td><?=$anticipos[$i]['year'];?></td>
											<td><?=$anticipos[$i]['proveNombre'];?></td>
											<td>$ <?=str_replace(",",".",number_format($anticipos[$i]['monto']));?></td>
											<td><a href="/CPP?dato=<?=rawurlencode(encrypt($anticipos[$i]['cpp'])); ?>" target="_blank"><img src="assets/img/pdf.png" alt=""></a></td>
											<td>						
												<?php for ($z=0; $z < count($anticipos[$i]['adjuntos']); $z++) { ?>
													<a href="/PDFCPP/<?= $anticipos[$i]['adjuntos'][$z]['year'].'/'.$anticipos[$i]['adjuntos'][$z]['mes'].'/'.rawurlencode($anticipos[$i]['adjuntos'][$z]['nombre_adjunto']); ?>" target="_blank"><img src="assets/img/detalle.png" alt=""></a>
												<?php }	?>
											</td>
											<td>
												<input type="hidden" value="1" class="idTipoAnticipo">
												<input type="hidden" value="<?=$anticipos[$i]['id'];?>" class="idAnticipo">
												<button class="bg-primary rounded text-white text-center px-3 py-1 btnPagarAnticipo" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Procesar</button> 
												<button class="bg-warning rounded text-white text-center px-3 py-1" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Reversar</button>
											</td>
										</tr>
									<?php } ?>	
								</tbody>
							</table>
						</div>
						<div class="tab-pane" role="tabpanel" id="fondoFijo">
							<br><br>
							<table id="tblFondoFijo" class="table table-striped table-hover" cellspacing="0" width="100%">
								<thead class="bg-primary rounded text-white">
									<tr>
										<th>Numero</th>
										<th>Año</th>
										<th>Centro de Costo</th>
										<th>Proveedor</th>
										<th>Monto</th>
										<th>Resolución</th>		
										<th>Documento Pagado</th>																	
										<th>Procesar</th>
										<th>Reversar</th>

									</tr>
								</thead>
								<tbody>
									<?php for ($i=0; $i < count($fondos_fijos); $i++) {  ?>

										<tr>
											<td><?=$fondos_fijos[$i]['numero'];?></td>
											<td><?=$fondos_fijos[$i]['year'];?></td>
											<td><?=$fondos_fijos[$i]['cc_nombre'];?></td>
											<td><?=$fondos_fijos[$i]['proveNombre'];?></td>

											<td>$ <?=str_replace(",",".",number_format($fondos_fijos[$i]['monto']));?></td>
											<td class="text-center"><a href="../anticipos/storage/app/<?=$fondos_fijos[$i]['url'];?>" target="_blank"><img src="assets/img/pdf.png" alt=""></a></td>										
											<td class="text-center"><a href="#" onclick="vercpp(<?=$fondos_fijos[$i]['cpp_pagado_anterior'];?>)"><img src="assets/img/pdf.png" alt=""></a></td>
										
											<td>
												<input type="hidden" value="<?=$fondos_fijos[$i]['id'];?>" class="idAnticipo">
												<input type="hidden" value="2" class="idTipoAnticipo">
												<input type="hidden" name="" value="<?=$fondos_fijos[$i]['id_soli'];?>" id="id">
												<input type="hidden" name="" value="<?=$fondos_fijos[$i]['id_cpp'];?>" id="id_cpp">
												<input type="hidden" name="" value="<?=$fondos_fijos[$i]['id_firma'];?>" id="id_firma">

												
												<button class="bg-primary rounded text-white text-center px-3 py-1 btnPagarAnticipo" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Procesar</button> 
												
											</td>
											<td>
												<button class="bg-warning rounded text-white text-center px-3 py-1" id="devolver_fondo" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Reversar</button>
											</td>
											
										</tr>
									<?php } ?>	
								</tbody>
							</table>
						</div>
						<div class="tab-pane" role="tabpanel" id="fondoFijodev">
							<br><br>
							<table id="tblFondoFijodevolucion" class="table table-striped table-hover" cellspacing="0" width="100%">
								<thead class="bg-primary rounded text-white">
									<tr>
										<th>Numero</th>
										<th>Año</th>
										<th>Proveedor</th>
										<th>Monto</th>
										<th>Resolución</th>	
										<th>Rendiciones</th>										
										<th>Procesar</th>
										<th>Reversar</th>
									</tr>
								</thead>
								<tbody> 
									<?php for ($i=0; $i < count($devo); $i++) {  ?>
										<tr>
											<td><?=$devo[$i]['numero'];?></td>
											<td><?=$devo[$i]['year'];?></td>
											<td><?=$devo[$i]['proveNombre'];?></td>
											<td>$ <?=str_replace(",",".",number_format($devo[$i]['monto']));?></td>
											<td class="text-center"><a href="../fondo_fijo/<?=$devo[$i]['url'];?>" target="_blank"><img src="assets/img/pdf.png" alt=""></a></td>
											<td class="text-center">
												<a href="../fondo_fijo/solicitudes/vistarendicion.php?id=<?=$devo[$i]['url_codificada'];?>" target="_blank"><img src="assets/img/pdf.png" alt=""></a>
											</td>
											
											<td>
												<input type="hidden" value="<?=$devo[$i]['id'];?>" class="idAnticipodev">
												<input type="hidden" value="15" class="idTipoAnticipodev">
												
												<button class="bg-primary rounded text-white text-center px-3 py-1 btnPagardevolucion" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Procesar</button> 
												
											</td>
											<td>
												<button class="bg-warning rounded text-white text-center px-3 py-1" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);">Reversar</button>
											</td>
										</tr>
									<?php } ?>	
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" tabindex="-1" role="dialog" id="modal_agregar_cuenta">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"> <div id="tituloan"></div></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-2">
							<label>Elegir Una Cuenta :</label>

						</div>
						<div class="col-4">
							<select data-live-search="true" data-live-search-style="startsWith" class="selectpicker form-control" id="selectorcuenta">
								<option value="1" selected="selected">Seleccione..</option>
								
								<option value="0">Otro</option>
							</select>
						</div>
						<div class="col-2" id="cc_n">
							<label>Cuenta contable Nueva:</label>
						</div>
						<div class="col-4" >
							<input type="" name="" class="form-control" id="cc_i">
							
						</div>
						

					</div>
					<input type="hidden" name="" id="anti_cc">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="guardarcuenta()">Guardar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="ModalPagoAnticipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Pagar Documento</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="controller/updateAnticipo.php" method="post" id="frmPagarAnticipo">		
						<div class="form-row mt-3">
							<div class="col">
								<input type="hidden" id="docto_id" name="id">
								<input type="hidden" id="docto_tipo" name="tipo">
								<input type="hidden" id="docto_responsable" name="resp">
								<input type="hidden" name="id_soli" id="id_soli">
								<input type="text" name="sigfe" id="nsifgep" class="form-control" placeholder="N° Sigfe Pago">
							</div>
							<div class="col">
								<input type="date" id="fpagoAnt" name="fecha" class="form-control" placeholder="Fecha de pago">
							</div>
						</div>
						<div class="form-row mt-4 mb-2">						
							<div class="col">
								<fieldset  class="scheduler-border">
									<legend  class="scheduler-border">Subir Comprobante:</legend>
									<div class="file-loading">
										<input id="input-b9" name="file" type="file">
									</div>
									<div id="kartik-file-errors"></div>
								</fieldset>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
					<button type="button" class="btn btn-primary" id="btnSendPagoAnticipo" title="presione para pagar">Pagar</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>