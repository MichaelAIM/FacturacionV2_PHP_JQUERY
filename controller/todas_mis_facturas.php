<?php
@session_start();
$funcionario = $_SESSION['rut'];
// $funcionario = '17557295-3';
$permisos = $_SESSION['permiso'];
if(strpos(strtoupper($_SERVER['SCRIPT_FILENAME']),'INDEX.PHP') !== FALSE){
    $prefix = '';
}else{
    $prefix = '../';
}
require_once($prefix.'models/FACTURA.php');
$fct = new Factura();
$facturas = $fct->solo_mis_facturas($funcionario);
$f = $facturas['facturas'];
?>
