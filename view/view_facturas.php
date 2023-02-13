<?php
@session_start();
require_once('../controller/misFacturasController.php');
require_once('../../intranet2.0/controller/seguridad.php');
?>
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
	@media(min-width:768px) {
		div.dataTables_wrapper div.dataTables_length label {
			margin-left: 75px !important;
		}
	}
	.stats-small {
		min-height: auto;
	}
	.stats-small--1 .stats-small__value {
		font-size: 1.3rem;
	}
	.table-purple{
		background-color: #e4beee;
	}
	.table-rosa{
		background-color: #FE59E0;
	}
	.table-verde{
		background-color: #6EF75B;
	}
</style>
<input type="hidden" id="sessionRut" value="<?=$_SESSION['rut'];?>">
<div class="main-content-container container-fluid px-4 ml-4">
	<!-- Page Header -->
	<div class="page-header row no-gutters py-4 mb-3 border-bottom">
		<div class="col-12 text-center text-sm-left mb-0">
			<span class="text-uppercase page-subtitle">Listado de Tareas</span>
			<h3 class="page-title">Mis Documentos</h3>
		</div>
	</div>
</div>
<div class="row m-5" style="min-height: 60vh;">
	<div class="row">
<!-- 		<div class="col-12">
			<div class="row"> -->
<!-- 				<div class="col-lg col-md-4 col-sm-6 px-4 mb-1">
					<div class="stats-small stats-small--1 card card-small" style="background-color: #eebec8;">
						<div class="card-body p-0 d-flex">
							<div class="d-flex flex-column mx-auto my-1">
								<div class="stats-small__data text-center">
									<span class="stats-small__label text-uppercase">Mayores a 30 Días</span>
									<h6 class="count mt-1 mb-0">N° <?=$Vencidas['cantidad'];?></h6>
									<h6 class="mb-0">$ <?=str_replace(",",".",number_format($Vencidas['suma']));?></h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg col-md-4 col-sm-6 px-4 mb-1">
					<div class="stats-small stats-small--1 card card-small" style="background-color: #ffeab8;">
						<div class="card-body p-0 d-flex">
							<div class="d-flex flex-column mx-auto my-1">
								<div class="stats-small__data text-center">
									<span class="stats-small__label text-uppercase">Entre 20 y 30 Días</span>
									<h6 class="count mt-1 mb-0">N° <?=$porVencer['cantidad'];?></h6>
									<h6 class="mb-0">$ <?=str_replace(",",".",number_format($porVencer['suma']));?></h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg col-md-4 col-sm-6 px-4 mb-1">
					<div class="stats-small stats-small--1 card card-small">
						<div class="card-body p-0 d-flex">
							<div class="d-flex flex-column mx-auto my-1">
								<div class="stats-small__data text-center">
									<span class="stats-small__label text-uppercase">Menores a 20 Días</span>
									<h6 class="count mt-1 mb-0">N° <?=$enPlazo['cantidad'];?></h6>
									<h6 class="mb-0">$ <?=str_replace(",",".",number_format($enPlazo['suma']));?></h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg col-md-4 col-sm-6 px-4 mb-1">
					<div class="stats-small stats-small--1 card card-small" style="background-color: #beeecd;">
						<div class="card-body p-0 d-flex">
							<div class="d-flex flex-column mx-auto my-1">
								<div class="stats-small__data text-center">
									<span class="stats-small__label text-uppercase">Total</span>
									<h6 class="count mt-1 mb-0">N° <?=$Total_F['cantidad'];?></h6>
									<h6 class="mb-0">$ <?=str_replace(",",".",number_format($Total_F['suma']));?></h6>
								</div>
							</div>
						</div>
					</div>
				</div> -->
<!-- 				<div class="col-lg col-md-4 col-sm-6 px-4 mb-1">
					<div class="stats-small stats-small--1 card card-small" style="background-color: #bee3ee;">
						<div class="card-body p-0 d-flex">
							<div class="d-flex flex-column mx-auto my-1">
								<div class="stats-small__data text-center">
									<span class="stats-small__label text-uppercase">Sin asignar</span>
									<h6 class="count mt-1 mb-0">N° <?=$Sin_asignar['cantidad'];?></h6>
									<h6 class="mb-0">$ <?=str_replace(",",".",number_format($Sin_asignar['suma']));?></h6>
								</div>
							</div>
						</div>
					</div>
				</div> -->
<!-- 			</div>
		</div> -->
		<div class="col-12">
			<div role="tabpanel">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active nav-item">
						<a href="#activos" class="nav-link active" aria-controls="" data-toggle="tab" role="tab">ACTIVOS</a>   
					</li>
					<?php if(in_array(173, $permisos) || in_array(175, $permisos)){ ?>
						<li role="presentation" class="nav-item">
							<a href="#rechazadas" class="nav-link" aria-controls="" data-toggle="tab" role="tab">RECHAZADOS</a>
						</li>
					<?php } ?>					
					<?php if(in_array(174, $permisos) || in_array(175, $permisos)){ ?>
						<li role="presentation" class="nav-item">
							<a href="#extra_presup" class="nav-link" aria-controls="" data-toggle="tab" role="tab">EXTRAPRESUPUESTARIOS</a>
						</li>
					<?php } ?>
					<li role="presentation" class="nav-item">
						<a href="#tab_factoring" class="nav-link" aria-controls="" data-toggle="tab" role="tab">FACTORING</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane mtareas active" role="tabpanel" id="activos">
						<br>
						<table id="TablaFacturas" class="table table-hover table-responsive-xl" style="width:100%">
							<thead class="bg-primary rounded text-white">
								<tr>
									<th style="background-color: #F5F6F8;width: 22px;"></th>
									<th>N°</th>
									<th>Numero Factura</th>
									<th style="width: 120px;">Monto</th>
									<th>Proveedor</th>
									<th style="width: 110px;">F. de Emision</th>
									<th>Días</th>
									<th>Documento</th>
									<?php 
									if(in_array(173, $permisos) || in_array(175, $permisos)){
										?>
										<th style="width: 140px;">Estado</th>

									<?php } ?>			            
									<?php 
									if(in_array(175, $permisos)){
										?>
										<th style="width: 120px;">Asignada</th>
										<?php
									}
									?>
									<th></th>
									<?php 
									if(in_array(174, $permisos)){
										?>
										<th> TGR </th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php
			    				// highlight_string(print_r($f,true));
								if ($f != NULL) {
									for ($i=0; $i < count($f); $i++) {
										$date2 = new DateTime('NOW');
										$date1 = new DateTime($f[$i]['fecha_factura']);
										$diff = $date1->diff($date2);      
										$dias = $diff->days;
										if ($f[$i]['devolucion'] == 1) {
											$colorDa = 'table-purple';
										}else{
											if ($dias > 29) {
												$colorDa = 'table-danger';
											}else if ($dias < 30 && $dias > 19) {
												$colorDa = 'table-warning';
											}else{
												$colorDa = "";
											}
										}
										if ($f[$i]['proveNombre'] == 'MICHAEL AGUIRRE SAAVEDRA') {
											$colorDa = 'table-verde';						
										}
										if ($f[$i]['proveNombre'] == 'ALEJANDRO ANTONIO VARGAS PEREZ') {
											$colorDa = 'table-rosa';						
										}
										?>
										<tr class="<?=$colorDa;?>">
											<td class="tdselect" style="background-color: #F5F6F8;text-align: center;">
												<?php if ($f[$i]['id_recepcion_bodega']!='') {		?>
													<i style="color: #31B404;" class="far fa-check-square"></i>
													<?php
												}
												?>					            	
											</td>
											<td onclick="modalDetalleFactura(<?=$f[$i]['id'];?>,1)" ><?=$i+1;?></td>
											<td onclick="modalDetalleFactura(<?=$f[$i]['id'];?>,1)" class="tdselect classINFO" id="<?=$f[$i]['id'];?>"><?=$f[$i]['numero'];?></td>
											<td onclick="modalDetalleFactura(<?=$f[$i]['id'];?>,1)" class="tdselect">$ <?=str_replace(",",".",number_format($f[$i]['monto']));?></td>
											<td onclick="modalDetalleFactura(<?=$f[$i]['id'];?>,1)" class="tdselect">
												<?php if ($f[$i]['proveNombre']!='') {
													echo $f[$i]['proveNombre'];
												}else{
													echo "No Existe";
												} ?>					            	
											</td>
											<td onclick="modalDetalleFactura(<?=$f[$i]['id'];?>,1)" class="tdselect"><?=$f[$i]['fecha_factura'];?></td>
											<td onclick="modalDetalleFactura(<?=$f[$i]['id'];?>,1)" class="tdselect"><?=$dias;?></td>
											<td onclick="modalDetalleFactura(<?=$f[$i]['id'];?>,1)" class="tdselect"><?=$f[$i]['tipo'];?></td>	
											<?php 
											if(in_array(173, $permisos) || in_array(175, $permisos)){
												if ($f[$i]['docto_estado_id'] == 3 && array_key_exists('r2', $f[$i])) {
													?>
													<td class="tdselect chkEstadoRev" style="text-align: center;">
														<input type="hidden" class="idDocumento" value="<?=$f[$i]['id'];?>">
														<?php 
														$imgR2 = '';
														if ($f[$i]['r2'] == 1) {		
															$imgR2 = "assets/img/chkA.png";
														}else if($f[$i]['r2'] == 2){ 
															$imgR2 = "assets/img/chkD.png";
														}else{
															$imgR2 = "assets/img/chk0.png";											
														}
														?>
														<img src="<?=$imgR2;?>" style="width: 20px" class="chkR2">
													</td>
													<?php
												}else{
													?>	            
													<td onclick="modalDetalleFactura(<?=$f[$i]['id'];?>,1)" class="tdselect"><?=$f[$i]['estado'];?></td>
													<?php 
												}
											} 
											?>
											<?php 
											if(in_array(175, $permisos)){
												?>
												<td class="tdselect"><?=$f[$i]['nombre'];?></td>			            	
												<?php
											}
											?>
											<td class="tdselect">
												<?php if ($f[$i]['link']!='') {		?>
													<a href="<?=$f[$i]['link'];?>" target="_blank"><i class="far fa-file-pdf"></i></a>
													<?php
												}else{
													echo "-";
												} ?>					            	
											</td>
											<?php 
											if(in_array(174, $permisos)){
												?>
												<td class="tdselect" style="text-align: center;">
													<input type="hidden" class="idDocumento" value="<?=$f[$i]['id'];?>">
													<?php if ($f[$i]['tgr'] == 1) {		?>
														<input type="checkbox" class="form-check-input chkTGR" checked="true">
														<?php
													}else{
														?>
														<input type="checkbox" class="form-check-input chkTGR">
														<?php
													}
													?>					            	
												</td>
											<?php } ?>
										</tr>
										<?php 
									}
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>N°</th>
									<th>Numero Factura</th>
									<th>Monto</th>
									<th>Proveedor</th>
									<th>F. de Emision</th>
									<th>Días</th>
									<th>Documento</th>
									<?php 
									if(in_array(173, $permisos) || in_array(175, $permisos)){
										?>
										<th>Estado</th>

									<?php } ?>			            
									<?php 
									if(in_array(175, $permisos)){
										?>
										<th>Asignada</th>
										<?php
									}
									?>
									<th></th>
									<?php 
									if(in_array(174, $permisos)){
										?>
										<th> TGR </th>
									<?php } ?>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="tab-pane mtareas" role="tabpanel" id="rechazadas">
						<br>
						<table id="TablaFacturas_r" class="table table-hover table-responsive-xl" style="width:100%">
							<thead class="bg-primary rounded text-white">
								<tr>
									<th style="background-color: #F5F6F8;width: 22px;"></th>
									<th>N°</th>
									<th>Numero Factura</th>
									<th style="width: 120px;">Monto</th>
									<th>Proveedor</th>
									<th style="width: 110px;">F. de Emision</th>
									<th>Días</th>
									<th>Documento</th>
									<?php 
									if(in_array(173, $permisos) || in_array(175, $permisos)){
										?>
										<th style="width: 140px;">Estado</th>

									<?php } ?>			            
									<?php 
									if(in_array(175, $permisos)){
										?>
										<th style="width: 120px;">Asignada</th>
										<?php
									}
									?>
									<th></th>									
								</tr>
							</thead>
							<tbody>
								<?php
			    				// highlight_string(print_r($f,true));
								if ($fr != NULL) {
									for ($i=0; $i < count($fr); $i++) {
										$date2 = new DateTime('NOW');
										$date1 = new DateTime($fr[$i]['fecha_factura']);
										$diff = $date1->diff($date2);      
										$dias = $diff->days;
										if ($fr[$i]['devolucion'] == 1) {
											$colorDa = 'table-purple';
										}else{
											if ($dias > 29) {
												$colorDa = 'table-danger';
											}else if ($dias < 30 && $dias > 19) {
												$colorDa = 'table-warning';
											}else{
												$colorDa = "";
											}
										}
										?>
										<tr class="<?=$colorDa;?>">
											<td class="tdselect" style="background-color: #F5F6F8;text-align: center;">
												<?php if ($fr[$i]['id_recepcion_bodega']!='') {		?>
													<i style="color: #31B404;" class="far fa-check-square"></i>
													<?php
												}
												?>					            	
											</td>
											<td onclick="modalDetalleFactura(<?=$fr[$i]['id'];?>,1)" ><?=$i+1;?></td>
											<td onclick="modalDetalleFactura(<?=$fr[$i]['id'];?>,1)" class="tdselect classINFO" id="<?=$f[$i]['id'];?>"><?=$fr[$i]['numero'];?></td>
											<td onclick="modalDetalleFactura(<?=$fr[$i]['id'];?>,1)" class="tdselect">$ <?=str_replace(",",".",number_format($fr[$i]['monto']));?></td>
											<td onclick="modalDetalleFactura(<?=$fr[$i]['id'];?>,1)" class="tdselect">
												<?php if ($fr[$i]['proveNombre']!='') {
													echo $fr[$i]['proveNombre'];
												}else{
													echo "No Existe";
												} ?>					            	
											</td>
											<td onclick="modalDetalleFactura(<?=$fr[$i]['id'];?>,1)" class="tdselect"><?=$fr[$i]['fecha_factura'];?></td>
											<td onclick="modalDetalleFactura(<?=$fr[$i]['id'];?>,1)" class="tdselect"><?=$dias;?></td>
											<td onclick="modalDetalleFactura(<?=$fr[$i]['id'];?>,1)" class="tdselect"><?=$fr[$i]['tipo'];?></td>	
											<?php 
											if(in_array(173, $permisos) || in_array(175, $permisos)){
												if ($fr[$i]['docto_estado_id'] == 3 && array_key_exists('r2', $fr[$i])) {
													?>
													<td class="tdselect chkEstadoRev" style="text-align: center;">
														<input type="hidden" class="idDocumento" value="<?=$f[$i]['id'];?>">
														<?php 
														$imgR2 = '';
														if ($fr[$i]['r2'] == 1) {		
															$imgR2 = "assets/img/chkA.png";
														}else if($f[$i]['r2'] == 2){ 
															$imgR2 = "assets/img/chkD.png";
														}else{
															$imgR2 = "assets/img/chk0.png";											
														}
														?>
														<img src="<?=$imgR2;?>" style="width: 20px" class="chkR2">
													</td>
													<?php
												}else{
													?>	            
													<td onclick="modalDetalleFactura(<?=$fr[$i]['id'];?>,1)" class="tdselect"><?=$fr[$i]['estado'];?></td>
													<?php 
												}
											} 
											?>
											<?php 
											if(in_array(175, $permisos)){
												?>
												<td class="tdselect"><?=$fr[$i]['nombre'];?></td>			            	
												<?php
											}
											?>
											<td class="tdselect">
												<?php if ($fr[$i]['link']!='') {		?>
													<a href="<?=$fr[$i]['link'];?>" target="_blank"><i class="far fa-file-pdf"></i></a>
													<?php
												}else{
													echo "-";
												} ?>					            	
											</td>
										</tr>
										<?php 
									}
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>N°</th>
									<th>Folio</th>
									<th>Monto</th>
									<th>Proveedor</th>
									<th>F. de Emision</th>
									<th>Días</th>			            
									<th>Estado</th>
									<?php 
									if(in_array(175, $permisos)){
										?>
										<th>Asignada</th>
										<?php
									}
									?>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="tab-pane mtareas" role="tabpanel" id="extra_presup">
						<br>
						<table id="TablaFacturas_extra" class="table table-hover table-responsive-xl" style="width:100%">
							<thead class="bg-primary rounded text-white">
								<tr>
									<th style="background-color: #F5F6F8;width: 22px;"></th>
									<th>N°</th>
									<th>Numero Factura</th>
									<th style="width: 120px;">Monto</th>
									<th>Proveedor</th>
									<th style="width: 110px;">F. de Emision</th>
									<th>Días</th>
									<th>Documento</th>
									<?php 
									if(in_array(173, $permisos) || in_array(175, $permisos)){
										?>
										<th style="width: 140px;">Estado</th>
									<?php } ?>			            
									<?php 
									if(in_array(175, $permisos)){
										?>
										<th style="width: 120px;">Asignada</th>
										<?php
									}
									?>
									<th></th>									
								</tr>
							</thead>
							<tbody>
								<?php
			    				// highlight_string(print_r($f,true));
								if ($f_extra != NULL) {
									for ($i=0; $i < count($f_extra); $i++) {
										$date2 = new DateTime('NOW');
										$date1 = new DateTime($f_extra[$i]['fecha_factura']);
										$diff = $date1->diff($date2);      
										$dias = $diff->days;
										if ($f_extra[$i]['devolucion'] == 1) {
											$colorDa = 'table-purple';
										}else{
											if ($dias > 29) {
												$colorDa = 'table-danger';
											}else if ($dias < 30 && $dias > 19) {
												$colorDa = 'table-warning';
											}else{
												$colorDa = "";
											}
										}
										?>
										<tr class="<?=$colorDa;?>">
											<td class="tdselect" style="background-color: #F5F6F8;text-align: center;">
												<?php if ($f_extra[$i]['id_recepcion_bodega']!='') {		?>
													<i style="color: #31B404;" class="far fa-check-square"></i>
													<?php
												}
												?>					            	
											</td>
											<td onclick="modalDetalleFactura(<?=$f_extra[$i]['id'];?>,1)" ><?=$i+1;?></td>
											<td onclick="modalDetalleFactura(<?=$f_extra[$i]['id'];?>,1)" class="tdselect classINFO" id="<?=$f[$i]['id'];?>"><?=$f_extra[$i]['numero'];?></td>
											<td onclick="modalDetalleFactura(<?=$f_extra[$i]['id'];?>,1)" class="tdselect">$ <?=str_replace(",",".",number_format($f_extra[$i]['monto']));?></td>
											<td onclick="modalDetalleFactura(<?=$f_extra[$i]['id'];?>,1)" class="tdselect">
												<?php if ($f_extra[$i]['proveNombre']!='') {
													echo $f_extra[$i]['proveNombre'];
												}else{
													echo "No Existe";
												} ?>					            	
											</td>
											<td onclick="modalDetalleFactura(<?=$f_extra[$i]['id'];?>,1)" class="tdselect"><?=$f_extra[$i]['fecha_factura'];?></td>
											<td onclick="modalDetalleFactura(<?=$f_extra[$i]['id'];?>,1)" class="tdselect"><?=$dias;?></td>
											<td onclick="modalDetalleFactura(<?=$f_extra[$i]['id'];?>,1)" class="tdselect"><?=$f_extra[$i]['tipo'];?></td>	
											<?php 
											if(in_array(173, $permisos) || in_array(175, $permisos)){
												if ($f_extra[$i]['docto_estado_id'] == 3 && array_key_exists('r2', $f_extra[$i])) {
													?>
													<td class="tdselect chkEstadoRev" style="text-align: center;">
														<input type="hidden" class="idDocumento" value="<?=$f[$i]['id'];?>">
														<?php 
														$imgR2 = '';
														if ($f_extra[$i]['r2'] == 1) {		
															$imgR2 = "assets/img/chkA.png";
														}else if($f[$i]['r2'] == 2){ 
															$imgR2 = "assets/img/chkD.png";
														}else{
															$imgR2 = "assets/img/chk0.png";											
														}
														?>
														<img src="<?=$imgR2;?>" style="width: 20px" class="chkR2">
													</td>
													<?php
												}else{
													?>	            
													<td onclick="modalDetalleFactura(<?=$f_extra[$i]['id'];?>,1)" class="tdselect"><?=$f_extra[$i]['estado'];?></td>
													<?php 
												}
											} 
											?>
											<?php 
											if(in_array(175, $permisos)){
												?>
												<td class="tdselect"><?=$f_extra[$i]['nombre'];?></td>			            	
												<?php
											}
											?>
											<td class="tdselect">
												<?php if ($f_extra[$i]['link']!='') {		?>
													<a href="<?=$f_extra[$i]['link'];?>" target="_blank"><i class="far fa-file-pdf"></i></a>
													<?php
												}else{
													echo "-";
												} ?>					            	
											</td>
										</tr>
										<?php 
									}
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>N°</th>
									<th>Folio</th>
									<th>Monto</th>
									<th>Proveedor</th>
									<th>F. de Emision</th>
									<th>Días</th>			            
									<th>Estado</th>
									<?php 
									if(in_array(175, $permisos)){
										?>
										<th>Asignada</th>
										<?php
									}
									?>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="tab-pane mtareas" role="tabpanel" id="tab_factoring">
						<br>
						<table id="TablaFacturas_factoring" class="table table-hover table-responsive-xl" style="width:100%">
							<thead class="bg-primary rounded text-white">
								<tr>
									<th style="background-color: #F5F6F8;width: 22px;"></th>
									<th>N°</th>
									<th>Numero Factura</th>
									<th style="width: 120px;">Monto</th>
									<th>Proveedor</th>
									<th style="width: 110px;">F. de Emision</th>
									<th>Días</th>
									<th>Documento</th>
									<?php 
									if(in_array(173, $permisos) || in_array(175, $permisos)){
										?>
										<th style="width: 140px;">Estado</th>

									<?php } ?>			            
									<?php 
									if(in_array(175, $permisos)){
										?>
										<th style="width: 120px;">Asignada</th>
										<?php
									}
									?>
									<th></th>
									<?php 
									if(in_array(174, $permisos)){
										?>
										<th> TGR </th>
									<?php } ?>							
								</tr>
							</thead>
							<tbody>
								<?php
			    				// highlight_string(print_r($f,true));
								if ($f_factoring != NULL) {
									for ($i=0; $i < count($f_factoring); $i++) {
										$date2 = new DateTime('NOW');
										$date1 = new DateTime($f_factoring[$i]['fecha_factura']);
										$diff = $date1->diff($date2);      
										$dias = $diff->days;
										if ($f_factoring[$i]['devolucion'] == 1) {
											$colorDa = 'table-purple';
										}else{
											if ($dias > 29) {
												$colorDa = 'table-danger';
											}else if ($dias < 30 && $dias > 19) {
												$colorDa = 'table-warning';
											}else{
												$colorDa = "";
											}
										}
										if ($f_factoring[$i]['proveNombre'] == 'MICHAEL AGUIRRE SAAVEDRA') {
											$colorDa = 'table-success';						
										}
										?>
										<tr class="<?=$colorDa;?>">
											<td class="tdselect" style="background-color: #F5F6F8;text-align: center;">
												<?php if ($f_factoring[$i]['id_recepcion_bodega']!='') {		?>
													<i style="color: #31B404;" class="far fa-check-square"></i>
													<?php
												}
												?>					            	
											</td>
											<td onclick="modalDetalleFactura(<?=$f_factoring[$i]['id'];?>,1)" ><?=$i+1;?></td>
											<td onclick="modalDetalleFactura(<?=$f_factoring[$i]['id'];?>,1)" class="tdselect classINFO" id="<?=$f_factoring[$i]['id'];?>"><?=$f_factoring[$i]['numero'];?></td>
											<td onclick="modalDetalleFactura(<?=$f_factoring[$i]['id'];?>,1)" class="tdselect">$ <?=str_replace(",",".",number_format($f_factoring[$i]['monto']));?></td>
											<td onclick="modalDetalleFactura(<?=$f_factoring[$i]['id'];?>,1)" class="tdselect">
												<?php if ($f_factoring[$i]['proveNombre']!='') {
													echo $f_factoring[$i]['proveNombre'];
												}else{
													echo "No Existe";
												} ?>					            	
											</td>
											<td onclick="modalDetalleFactura(<?=$f_factoring[$i]['id'];?>,1)" class="tdselect"><?=$f_factoring[$i]['fecha_factura'];?></td>
											<td onclick="modalDetalleFactura(<?=$f_factoring[$i]['id'];?>,1)" class="tdselect"><?=$dias;?></td>
											<td onclick="modalDetalleFactura(<?=$f_factoring[$i]['id'];?>,1)" class="tdselect"><?=$f_factoring[$i]['tipo'];?></td>	
											<?php 
											if(in_array(173, $permisos) || in_array(175, $permisos)){
												if ($f_factoring[$i]['docto_estado_id'] == 3 && array_key_exists('r2', $f_factoring[$i])) {
													?>
													<td class="tdselect chkEstadoRev" style="text-align: center;">
														<input type="hidden" class="idDocumento" value="<?=$f_factoring[$i]['id'];?>">
														<?php 
														$imgR2 = '';
														if ($f_factoring[$i]['r2'] == 1) {		
															$imgR2 = "assets/img/chkA.png";
														}else if($f_factoring[$i]['r2'] == 2){ 
															$imgR2 = "assets/img/chkD.png";
														}else{
															$imgR2 = "assets/img/chk0.png";											
														}
														?>
														<img src="<?=$imgR2;?>" style="width: 20px" class="chkR2">
													</td>
													<?php
												}else{
													?>	            
													<td onclick="modalDetalleFactura(<?=$f_factoring[$i]['id'];?>,1)" class="tdselect"><?=$f_factoring[$i]['estado'];?></td>
													<?php 
												}
											} 
											?>
											<?php 
											if(in_array(175, $permisos)){
												?>
												<td class="tdselect"><?=$f_factoring[$i]['nombre'];?></td>			            	
												<?php
											}
											?>
											<td class="tdselect">
												<?php if ($f_factoring[$i]['link']!='') {		?>
													<a href="<?=$f_factoring[$i]['link'];?>" target="_blank"><i class="far fa-file-pdf"></i></a>
													<?php
												}else{
													echo "-";
												} ?>					            	
											</td>
											<?php 
											if(in_array(174, $permisos)){
												?>
												<td class="tdselect" style="text-align: center;">
													<input type="hidden" class="idDocumento" value="<?=$f_factoring[$i]['id'];?>">
													<?php if ($f_factoring[$i]['tgr'] == 1) {		?>
														<input type="checkbox" class="form-check-input chkTGR" checked="true">
														<?php
													}else{
														?>
														<input type="checkbox" class="form-check-input chkTGR">
														<?php
													}
													?>					            	
												</td>
											<?php } ?>
										</tr>
										<?php 
									}
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>N°</th>
									<th>Numero Factura</th>
									<th>Monto</th>
									<th>Proveedor</th>
									<th>F. de Emision</th>
									<th>Días</th>
									<th>Documento</th>
									<?php 
									if(in_array(173, $permisos) || in_array(175, $permisos)){
										?>
										<th>Estado</th>

									<?php } ?>			            
									<?php 
									if(in_array(175, $permisos)){
										?>
										<th>Asignada</th>
										<?php
									}
									?>
									<th></th>
									<?php 
									if(in_array(174, $permisos)){
										?>
										<th> TGR </th>
									<?php } ?>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
include('modals/modalDetalleFactura.php');  
include('modals/modalDevolucion.php');  
?>
