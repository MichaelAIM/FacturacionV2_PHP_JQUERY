<?php 
date_default_timezone_set('America/Santiago');
$fechaActual = date('d/m/Y -  G:i:s');
?>
<style>
	@media only screen and (max-width: 1601px) {
		#enPLZ_m,#porV_m,#ven_m,#enPLZ_c,#porV_c,#ven_c{
			font-size: 13px;
		}
		#TablaEnPLazo tbody{
			font-size: 12px;
		}
	}
</style>
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
	<div class="page-header row no-gutters py-4 mb-3 border-bottom">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
			<span class="text-uppercase page-subtitle">Reportes</span>
			<h3 class="page-title">Facturas pendientes de pago</h3>
		</div>
	</div>
	<!-- End Page Header -->
	<div class="row" style="justify-content: center;">
		<h6><?=$fechaActual.' Hrs.';?></h6>		
	</div>
	<div class="row mb-2">
		<div class="col-lg-4 offset-lg-1 col-md-6 col-sm-12 mb-4">
			<div class="card card-small h-100">
				<div class="card-header border-bottom">
					<h6 class="m-0">Facturas según Cantidad</h6>
				</div>
				<div class="card-body d-flex py-0">
					<!-- <span>Total 176 Facturas</span> -->
					<canvas height="220" class="blog-users-by-device my-2"></canvas>
				</div>
				<div class="card-footer border-top">
					<div class="row text-white text-center">
						<div class="col-4 ">
							<div class="col-12 rounded p-2 enPLZ" style="background-color: rgba(31,188,64,0.9); box-shadow: inset 0 0 5px rgba(0,0,0,.2);  cursor: pointer;" id="enPLZ_c"></div>
						</div>
						<div class="col-4">
							<div class="col-12 rounded bg-warning p-2 porV" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);  cursor: pointer;" id="porV_c"></div>
						</div>
						<div class="col-4">
							<div class="col-12 rounded bg-danger p-2 ven_m" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);  cursor: pointer;" id="ven_c"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 offset-lg-1 col-md-6 col-sm-12 mb-4">
			<div class="card card-small h-100">
				<div class="card-header border-bottom">
					<h6 class="m-0">Facturas según Monto</h6>
				</div>
				<div class="card-body d-flex py-0">
					<canvas height="220" class="blog-users-by-device1 m-auto"></canvas>
				</div>
				<div class="card-footer border-top">
					<div class="row text-white text-center">
						<div class="col-4 ">
							<div class="col-12 rounded p-2 enPLZ" style="background-color: rgba(31,188,64,0.9);box-shadow: inset 0 0 5px rgba(0,0,0,.2); cursor: pointer;" id="enPLZ_m"></div>
						</div>
						<div class="col-4">
							<div class="col-12 bg-warning rounded p-2 porV" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2); cursor: pointer;" id="porV_m"></div>
						</div>
						<div class="col-4">
							<div class="col-12 rounded bg-danger p-2 ven_m" style="box-shadow: inset 0 0 5px rgba(0,0,0,.2);  cursor: pointer;" id="ven_m"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-5 ml-5" id="divTableFactura">

	</div>
</div>