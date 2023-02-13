<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
	<div class="page-header row no-gutters py-4 mb-3 border-bottom">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
			<span class="text-uppercase page-subtitle">Ingresar Nuevo</span>
			<h3 class="page-title">Factoring</h3>
		</div>
	</div>
	<form action="controller/addFactoring.php" method="post" id="factoring-form">
		<div class="row">
			<div class="col-lg-10 offset-lg-1 mb-2">
				<div class="card card-small mb-4">
					<div class="card-header border-bottom">
						<h6 class="m-0">Datos de Factura</h6>
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item px-3">
							<div class="row g-3">
								<div class="col-md-2">
									<label for="inputNumFAct" class="form-label required">* Número:</label>
									<input type="number" name="inputNumFAct" required class="form-control mb-3" id="inputNumFAct">
								</div>
								<div class="col-md-4">
									<label for="inputProvFAct" class="form-label">* Rut Proveedor:</label>
									<input type="text" name="inputProvFAct" placeholder="12345678-9" class="form-control mb-3" id="inputProvFAct">
								</div>
								<div class="col-md-3">
									<label for="inputMomFAct" class="form-label">* Monto: </label>
									<input type="number" name="inputMomFAct" placeholder="10000" class="form-control mb-3" id="inputMomFAct">
								</div>
								<div class="col-md-3">
									<label for="fcedido" class="form-label">* Fecha de recepción:</label>
									<input type="date" name="frecep" class="form-control" id="frecep_fact">
								</div>

								<div class="col-md-4">
									<label for="fcedido" class="form-label">* Fecha de Cesión:</label>
									<input type="date" name="fcedido" class="form-control" id="fcedido">
								</div>
								<div class="col-md-8">
									<div class="input-group">
										<label class="form-label">* Subir Archivo:</label>
										<div class="input-group input-group-seamless">
											<div class="custom-file mb-3">
												<input type="file" name="file" multiple class="custom-file-input" id="customFile3">
												<label class="custom-file-label" for="customFile3" data-browse="Buscar Archivo" style="border:1px solid #b3bdcc;">Seleccionar archivo</label>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<label for="cesionario" class="form-label">* Rut Cesionario:</label>
									<input type="text" name="cesionario" placeholder="12345678-9" class="form-control mb-3" id="cesionario">
								</div>
								<div class="col-md-6">
									<label for="nombreCesionario" class="form-label">* Nombre Proveedor Cesionario:</label>
									<input type="text" name="nombreCesionario" placeholder="Empresa Ltda." class="form-control mb-3" id="nombreCesionario">
								</div>

								<div class="col-12 my-4">
									<button type="submit" class="btn-info col-4 offset-4 rounded text-white text-center p-3" id="sendFactoring" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);cursor: pointer;">Ingresar Factoring</button>									
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</form>
</div>