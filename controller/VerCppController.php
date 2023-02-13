<?php 
require_once('../models/ANTICIPOS.php');
require_once('../../intranet2.0/controller/seguridad.php');
$cpp= new Anticipo();






   if( rawurlencode(encrypt($_POST['id'])) == 'sbDMuxC7Zc8%3D'){
    	$r=0;

       echo json_encode($r);
    }else{

    	echo json_encode(rawurlencode(encrypt($_POST['id'])));
    }









?>