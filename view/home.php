<?php 
require_once('../controller/KPIsController.php');
?>
<script src="assets/scripts/app/app-blog-overview.1.1.0.js"></script>
<div class="main-content-container container-fluid px-4" style="min-height: auto;">
	<!-- Page Header -->
	<div class="page-header row no-gutters py-4">
	  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
	    <span class="text-uppercase page-subtitle">PANEL DE CONTROL</span>
	    <h3 class="page-title">Estadisticas de Facturas impagas</h3>
	    <input type="hidden" id="g30" value="<?=$G30;?>">
	    <input type="hidden" id="g3040" value="<?=$G3040;?>">
	    <input type="hidden" id="g40" value="<?=$G40;?>">
	  </div>
	</div>
	<!-- End Page Header -->
	<!-- Small Stats Blocks -->
	<div class="row">
	    <div class="col-lg col-md-6 col-sm-6 mb-4">
	        <div class="stats-small stats-small--1 card card-small">
	          <div class="card-body p-0 d-flex">
	            <div class="d-flex flex-column m-auto">
	              <div class="stats-small__data text-center">
	                <span class="stats-small__label text-uppercase">Menores a 30 días</span>
	                <h6 class="stats-small__value count my-3">$ <?=str_replace(",",".",number_format($kpi2['facturas'][0]['total']));?></h6>
	              </div>
	              <div class="stats-small__data">
	                <span class="stats-small__percentage stats-small__percentage--increase" style="font-size: 12PX;"><?=$kpi2['facturas'][0]['cantidad'];?></span>
	              </div>
	            </div>
	            <canvas height="120" class="blog-overview-stats-small-2"></canvas>
	          </div>
	        </div>
	    </div>
	    <div class="col-lg col-md-6 col-sm-6 mb-4">
	        <div class="stats-small stats-small--1 card card-small">
	          <div class="card-body p-0 d-flex">
	            <div class="d-flex flex-column m-auto">
	              <div class="stats-small__data text-center">
	                <span class="stats-small__label text-uppercase">Entre 30 y 40 días</span>
	                <h6 class="stats-small__value count my-3">$ <?=str_replace(",",".",number_format($kpi3['facturas'][0]['total']));?></h6>
	              </div>
	              <div class="stats-small__data">
	                <span class="stats-small__percentage stats-small__percentage--decrease"><?=$kpi3['facturas'][0]['cantidad'];?></span>
	              </div>
	            </div>
	            <canvas height="120" class="blog-overview-stats-small-3"></canvas>
	          </div>
	        </div>
	    </div>
	    <div class="col-lg col-md-6 col-sm-6 mb-4">
	        <div class="stats-small stats-small--1 card card-small">
	          <div class="card-body p-0 d-flex">
	            <div class="d-flex flex-column m-auto">
	              <div class="stats-small__data text-center">
	                <span class="stats-small__label text-uppercase">Superiores a 40 días</span>
	                <h6 class="stats-small__value count my-3">$ <?=str_replace(",",".",number_format($kpi4['facturas'][0]['total']));?></h6>
	              </div>
	              <div class="stats-small__data">
	                <span class="stats-small__percentage stats-small__percentage--increase"><?=$kpi4['facturas'][0]['cantidad'];?></span>
	              </div>
	            </div>
	            <canvas height="120" class="blog-overview-stats-small-4"></canvas>
	          </div>
	        </div>
	    </div>
	    <div class="col-lg col-md-6 col-sm-6 mb-4">
	        <div class="stats-small stats-small--1 card card-small">
	          <div class="card-body p-0 d-flex">
	            <div class="d-flex flex-column m-auto">
	              <div class="stats-small__data text-center">
	                <span class="stats-small__label text-uppercase">totales hoy</span>
	                <h6 class="stats-small__value count my-3">$ <?=str_replace(",",".",number_format($kpiT['facturas'][0]['total']));?></h6>
	              </div>
	              <div class="stats-small__data">
	                <span class="stats-small__percentage stats-small__percentage--increase"><?=$kpiT['facturas'][0]['cantidad'];?></span>
	              </div>
	            </div>
	            <canvas height="120" class="blog-overview-stats-small-1"></canvas>
	          </div>
	        </div>
	    </div>	             
	  </div>
	</div>
	<!-- End Small Stats Blocks -->
	<div class="row">
	  <!-- Users Stats -->
		<div class="col-lg-8 col-md-12 col-sm-12 mb-4" style="padding-left: 2.5rem !important;">
			<div class="card card-small">
				<div class="card-header border-bottom">
					<h6 class="m-0">Comportamiento de pago </h6>
				</div>
				<div class="card-body pt-0">
					<div class="row border-bottom py-2 bg-light">
				  		<div class="col-12 col-sm-6">
				    		<div id="blog-overview-date-range" class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 350px;">
				      			<input type="text" class="input-sm form-control" name="start" placeholder="Start Date" id="blog-overview-date-range-1">
			      				<input type="text" class="input-sm form-control" name="end" placeholder="End Date" id="blog-overview-date-range-2">
				      			<span class="input-group-append">
				        			<span class="input-group-text">
					          			<i class="material-icons"></i>
					        		</span>
				      			</span>
				    		</div>
				  		</div>                      
					</div>
					<canvas height="130" style="max-width: 100% !important;" class="blog-overview-users"></canvas>
				</div>
			</div>
		</div>
	  <!-- End Users Stats -->
	  <!-- Users By Device Stats -->
	  <div class="col-lg-4 col-md-6 col-sm-12 mb-4" style="padding-right: 2.5rem !important;">
	    <div class="card card-small h-100">
	      <div class="card-header border-bottom">
	        <h6 class="m-0">Facturas impagas según grupo</h6>
	      </div>
	      <div class="card-body d-flex py-0">
	        <canvas height="220" class="blog-users-by-device m-auto"></canvas>
	      </div>
	    </div>
	  </div>
	</div>
</div>