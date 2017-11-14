<?php

require_once("../../includes/initialize.php");
if (!$session->is_logged_in()){
    redirectTo("login.php");
}
if(empty($_GET['id'])){
    $session->message("No Patient ID was provided.");
    redirectTo('list_patient.php');
}

 /* if(empty($_GET['aCnt']) && !is_numeric($_GET['aCnt'])){*/
if(empty($_GET['aCnt'])){
    $session->message("No analisys count  was provided.");
    redirectTo('list_patient.php');
}

$analysis = new Analysis();
$analysis::set_analysis_table();
if ($analysis->delete_analysis($_GET['id'],$_GET['aCnt']) ){
    $session->message("The Analysis  was deleted.");
    redirectTo('list_patient.php?id='.$_GET['id']);
}else{
    $session->message("The Analysis could not be deleted.");
    redirectTo('list_patient.php');
}

if(isset($database)){$database->close_connection();  }