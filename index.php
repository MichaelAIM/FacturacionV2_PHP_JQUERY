<?php 
session_start();
$permisos = $_SESSION['permiso']; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Sistema de gestión de pagos</title>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
  <link href="assets/fonts/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="assets/fonts/icon.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/sweetalert2.css">
	<link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="assets/styles/shards-dashboards.1.1.0.css">
  <link rel="stylesheet" href="assets/styles/extras.1.1.0.min.css">
  <link rel="stylesheet" href="assets/DataTables/datatables.css">
  <link rel="stylesheet" href="assets/toatstr/toastr.min.css">  
  <link rel="stylesheet" href="assets/css/app.css">
</head>
<?php #require_once('controller/showAllFacturaEstadoController.php'); ?>
<body class="h-100" id="body" style="font-size: 14px;">
	<div class="container-fluid">
      <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0 bg-primary">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0 bg-primary" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <img id="main-logo" class="d-inline-block align-top mr-2" style="max-width: 25px;" src="assets/images/shards-dashboards-logo-info.svg" alt="Shards Dashboard">
                  <span class="d-none d-md-inline ml-1" style="letter-spacing: 0.3em;color: #fff;">SGP</span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
          <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">    
          </form>
          <div class="nav-wrapper">
            <ul class="nav flex-column">
<!--               <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/home.php">
                  <i class="material-icons">home</i>
                  <span>Inicio</span>
                </a>
              </li> -->
              <?php 
              // if(in_array(172, $permisos)){
              ?>
<!--               <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/add_factura.php">
                  <i class="material-icons">note_add</i>
                  <span>Agregar Factura</span>
                </a>
              </li> -->
              <?php 
              // } 
              ?> 
              
              
              <? for ($i=0; $i < count($_SESSION['permiso']); $i++) { 
                 $numero=0;
                if($_SESSION['permiso'][$i]===213 ){
                  $numero=1;

                  ?>

               


                <? }
              } ?>
               <input type="hidden" name="" value="<?=$numero?>" id="id_man">
                 <? if( !in_array(213,$permisos)) {?>
              <li class="nav-item opciones">
                <a class="nav-link active menu_option" href="view/view_facturas.php">
                  <i class="material-icons">list</i>
                  <span>Mis Tareas</span>
                </a>
              </li>
              <?}?>
<?php if(in_array(174, $permisos) ||in_array(175, $permisos) ||in_array(229, $permisos)){ ?>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/view_anticipos.php">
                  <i class="material-icons">note_add</i>
                  <span>Anticipos</span>
                </a>
              </li>
<?php } ?>
<?php if(in_array(173, $permisos)||in_array(175, $permisos)){ ?>

  <?php if(in_array(193, $permisos)){ ?>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/asignarPersona.php">
                  <i class="material-icons">note_add</i>
                  <span>Facturas</span>
                </a>
              </li>
  <?php } ?>
  <?php if(in_array(194, $permisos)){ ?>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/view_boletas.php">
                  <i class="material-icons">receipt</i>
                  <span>Boletas de Honorarios</span>
                </a>
              </li>
  <?php } ?>

  <?php if(in_array(173, $permisos)||in_array(175, $permisos) || in_array(193, $permisos) || in_array(199, $permisos) || in_array(194, $permisos) || in_array(174, $permisos) ){ ?>
    <? if( !in_array(213,$permisos)) {?>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/view_transferencias.php">
                  <i class="material-icons">credit_card</i>
                  <span>Transferencias</span>
                </a>
              </li>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/view_arriendos.php">
                  <i class="material-icons">store</i>
                  <span>Arriendos</span>
                </a>
              </li>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/view_basicos.php">
                  <i class="material-icons">wb_incandescent</i>
                  <span>Gastos Basicos</span>
                </a>
              </li>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/view_comunes.php">
                  <i class="material-icons">local_atm</i>
                  <span>Gastos Comunes</span>
                </a>
              </li>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/view_dev.php">
                  <i class="material-icons">shopping_cart</i>
                  <span>Devoluciones</span>
                </a>
              </li>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/view_fondo_dev.php">
                  <i class="material-icons">shopping_cart</i>
                  <span>Devoluciones Fondo Fijo</span>
       
                </a>
              </li>
               <?php } ?>
              <?php } ?>
  <?php if (in_array(193, $permisos)) { ?>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/uploadExcel.php">
                  <i class="material-icons">backup</i>
                  <span>Subir Excel Acepta</span>
                </a>
              </li>
  <?php } ?>
<?php } ?>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/search.php">
                  <i class="material-icons">search</i>
                  <span>Busqueda de Documentos</span>
                </a>
              </li>
  <?php if (in_array(199, $permisos)) { ?>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/graficas.php">
                  <i class="material-icons">insert_chart</i>
                  <span>Reportes</span>
                </a>
              </li> 
<!--               <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/ReasignarPersona.php">
                  <i class="material-icons">insert_chart</i>
                  <span>Reasignar Masivo</span>
                </a>
              </li>  --> 
<?php } ?>
<?php if (in_array(199, $permisos)) { ?>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/factoring.php">
                  <i class="material-icons">supervisor_account</i>
                  <span>Factoring</span>
                </a>
              </li> 
<?php } ?>
    <?php if(in_array(173, $permisos)||in_array(175, $permisos) || in_array(193, $permisos) || in_array(199, $permisos) || in_array(194, $permisos) || in_array(174, $permisos) ){ ?>
    <? if( !in_array(213,$permisos)) {?>
              <li class="nav-item opciones">
                <a class="nav-link menu_option" href="view/view_all.php">
                  <i class="material-icons">insert_chart</i>
                  <span>Todas mis facturas</span>
                </a>
              </li>
               <?php } ?>
              <?php } ?>
            </ul>
          </div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0 bg-primary">
             <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex"></form>
              <ul class="navbar-nav border-left flex-row ">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-white text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <!-- <img class="user-avatar rounded-circle mr-2" src="assets/images/avatars/1.jpg" alt="User Avatar"> -->
                    <span class="d-none d-md-inline-block"><?=$_SESSION['nom'];?></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item text-danger" href="javascript:window.close()">
                      <i class="material-icons text-danger">&#xE879;</i>Salir</a>
                  </div>
                </li>
              </ul>
              <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                  <i class="material-icons">&#xE5D2;</i>
                </a>
              </nav>
            </nav>
          </div>
          <!-- / .main-navbar -->
           	<!-- Contenido -->
            <div id="idcontent">
            </div>
            <!-- / Contenido -->
          <footer class="main-footer d-flex p-2 px-3 bg-white border-top mt-5">
            <span class="copyright ml-auto my-auto mr-2">Copyright © 2020
              <a href="#" rel="nofollow">Servicio de Salud Arica</a>
            </span>
          </footer>
        </main>
      </div>
    </div>
	<script type="text/javascript" src="assets/js/popper.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-3.4.1.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/js/vue.js"></script>
	<script type="text/javascript" src="assets/js/axios.min.js"></script>
	<script type="text/javascript" src="assets/js/sweetalert2.min.js"></script>	
	<script type="text/javascript" src="assets/js/bigSlide.min.js"></script>
	<script src="assets/js/Chart.js"></script>
  <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
  <!-- <script src="assets/scripts/extras.1.1.0.min.js"></script> -->
  <!-- <script src="assets/scripts/shards-dashboards.1.1.0.js"></script> -->
  <script type="text/javascript" src="assets/toatstr/toastr.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery-sortable.js"></script>
  <script src="assets/DataTables/datatables.js"></script> 
  <script src="../Script_New/jQuery/jquery.form-4.2.2.js"></script> 
	<script type="text/javascript" src="assets/js/app.js"></script>
</body>
</html>
