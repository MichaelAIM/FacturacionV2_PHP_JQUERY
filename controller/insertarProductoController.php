<?php
require_once('../models/PRODUCTOS.php');
$pro = new Productos();

$productos = $_POST['productos'];
$id = $_POST['factura'];
for ($i=0; $i < count($productos); $i++) { 
	$prods = $pro->Ingresar($productos[$i],$id);
}
?>