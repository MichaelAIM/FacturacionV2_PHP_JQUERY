<?php 
require_once('../models/ANTICIPOS.php');
$ant = new Anticipo();

$m=$ant->Reversarfondo_fijo($_POST['id'],$_POST['motivo']);

?>