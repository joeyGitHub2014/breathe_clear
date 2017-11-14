<?php
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()){
    redirectTo("login.php");
}
$analysis = new Analysis();
$analysis::set_analysis_table();
if ($analysis->delete_analysis($_POST['patientID'],$_POST['analysisCount']) ){
    $session->message("The Analysis Record was deleted.");
    redirectTo('list_patient.php');
}else{
    $session->message("The Analysis Record could not be deleted.");
    redirectTo('list_patient.php');
}

if(isset($database)){$database->close_connection();  }