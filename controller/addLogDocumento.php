<?php
@session_start();
require_once('../models/LOG_CAMBIOSDEESTADOS.php');
$log = new log();

if ($_POST['idf'] != '' && $_POST['est'] != '') {
       $fact = $log->Ingresar($_POST['idf'], $_SESSION['rut'], 0, $_POST['est'], 'NO');
}
echo($fact);
?>
