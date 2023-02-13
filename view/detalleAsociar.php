<?php 
// highlight_string(print_r($_POST,true));
require_once('../../principal/Control/seguridad.php');
$Recep = $_POST['data']['recepciones']['recep'];
$doctos = $_POST['data']['documentos']['documentos'];
$anticipos = $_POST['data']['anticipos']['anticipo'];
?>
<div class="container">
	<input type="hidden" id="idDetalleFacturaAsoc" value="<?=$_POST['data']['id_factura'];?>">
	<div class="row mb-4">
		<div class="col-md-4 text-center">
			<button class="btn btn-primary" id="showRecepciones">Mostrar Recepción</button>			
		</div>
		<div class="col-md-4 text-center">
			<button class="btn btn-primary" id="showAnticipos">Mostrar Anticipos</button>			
		</div>
		<div class="col-md-4 text-center">
			<button class="btn btn-primary" id="showDocumentos">Mostrar Documento</button>			
		</div>


		<div id="divAsociaciones" class="mt-3" style="width: 100%;">
			<div class="col-12 pr-3  pb-1" style="text-align: end;">
				<button type="button" id="closedViewRecepciones" class="btn btn-danger">X</button></th>
			</div>
			<div class="col-12" id="viewAllRecepciones">
				<table class="table table-bordered table-hover text-center" id="tblrecepcion_asoc">
					<thead>
						<th>N°</th>
						<th>Año</th>
						<th>OC Portal</th>
						<th>Ver</th>
						<th style="width: 100px;"></th>
						<!-- <th style="width: 120px;"></th> -->
					</thead>
					<tbody>
						<?php 
						if ($Recep!=NULL) {
							for ($i=0; $i< count($Recep); $i++) {  
								?>
								<tr class="trRecepcion">
									<td><?=$Recep[$i]['num_recepcion'];?></td>
									<td><?=$Recep[$i]['year_recepcion'];?></td>
									<td><?=$Recep[$i]['n_lic'];?></td>
									<td>
										<a href="../admin_bodega/Control/regenerarRecepcionID.ctrl.php?dato=<?=rawurlencode(encrypt($Recep[$i]['id_recepcion']));?>" target="_blank">
											<i class="far fa-file-pdf" style="font-size: 26px;"></i>
										</a>
										<!-- <a class="prodCircle" href="/RECPDF?dato=<?=rawurlencode(encrypt($Recep[$i]['id_recepcion']));?>" target="_blank">RECEPCIÓN</a> -->
									</td>
									<td>
										<input type="hidden" class="idRecepcionAsoc" value="<?=$Recep[$i]['id_recepcion'];?>">		
										<button class="btn btn-sm btn-success btnAsocRecep" type="button">Asociar</button>
									</td>
									<!-- <td><button class="btn btn-sm btn-primary" type="button">Seleccionar</button></td> -->
								</tr>
								<?php 
							}
						}else{
							?>
							<tr>
								<td>No tiene recepciones para asociar.</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<?php
						} 
						?>
					</tbody>
				</table>
			</div>
			<div class="col-12" id="viewAllDocumentos">
				<table class="table table-bordered table-hover" id="tbldocumentos_asoc">
					<thead>
						<th>N°</th>
						<th>Tipo</th>
						<th>Monto</th>
						<th>Fecha</th>
						<th>OC Portal</th>
						<th></th>
						<th></th>
					</thead>
					<tbody>
						<?php 
						if ($doctos!=NULL) {
							for ($i=0; $i< count($doctos); $i++) {  
								?>
								<tr class="trDocumento">
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
									<td>
										<input type="hidden" class="idDOCTOAsoc" value="<?=$doctos[$i]['id'];?>">		
										<button class="btn btn-sm btn-success btnAsocDocumento" type="button">Asociar</button>			
									</td>
								</tr>
								<?php 
							}
						}else{
							?>
							<tr>
								<td> No tiene documentos para asociar.</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="col-12" id="viewAllAnticipos">
				<table class="table table-bordered table-hover" id="tblAnti_asoc">
					<thead>
						<th>N°</th>
						<th>Monto</th>
						<th>Fecha de pago</th>
						<th>Sigfe Pago</th>
						<th></th>
					</thead>
					<tbody>
						<?php 
						if ($anticipos!=NULL) {
							for ($i=0; $i< count($anticipos); $i++) {  
								?>
								<tr class="trAnticipo">
									<td><?=$anticipos[$i]['numero'];?></td>
									<td>$ <?=$anticipos[$i]['monto'];?></td>
									<td class="anticipoFPago"><?=$anticipos[$i]['fecha_pago'];?></td>
									<td class="anticipoSPago"><?=$anticipos[$i]['sigfe_pago'];?></td>
									<td>
										<input type="hidden" class="idAnticipoAsoc" value="<?=$anticipos[$i]['id'];?>">		
										<button class="btn btn-sm btn-success btnAsocAnticipo" type="button">Asociar</button>			
									</td>
								</tr>
								<?php 
							}
						}else{
							?>
							<tr>
								<td colspan="4"> No tiene documentos para asociar.</td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="col-12 mt-3 border border-primary rounded">	
			<h4 class="mt-2">Recepciones</h4>	
			<div class="p-2" style="display: inline-flex;" id="detalleRecepciones"></div>
		</div>
		<div class="col-12 border border-primary rounded">
			<h4 class="mt-2">Documentos</h4>			
			<table class="table table-bordered table-hover ">
				<thead>
					<tr>
						<th>N°</th>
						<th>Tipo</th>
						<th>Monto</th>
						<th>Fecha</th>
						<th>OC Portal</th>
						<th>PDF</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="tblFacturaDoc"></tbody>
			</table>
		</div>
		<div class="col-12 border border-primary rounded">
			<h4 class="mt-2">Anticipos</h4>			
			<table class="table table-bordered table-hover ">
				<thead>
					<th>N°</th>
					<th>Monto</th>
					<th>Fecha Pago</th>
					<th>N° Sigfe</th>
					<th>PDF</th>
				</thead>
				<tbody id="tblAnticiposDoc"></tbody>
			</table>
		</div>		
	</div>
</div>