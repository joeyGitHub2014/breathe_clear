<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
        redirectTo("login.php");
    }
 if(empty($_GET['id'])){
    $session->message("No Patient ID was provided.");
    redirectTo('list_patient.php');
}
    $patient =  new Patient();
    $patient::set_patient_table();
    $patient->patientID = $_GET['id'];
    if ($patient->delete()){
        $analysis = new Analysis();
        $analysis->set_table_fields();
        if ($analysis->delete_all_analysis($_GET['id']) ){
            $session->message("The Patient and their analysis were deleted.");
            redirectTo('list_patient.php');
        }else{
            $session->message("The Patient was deleted but could not delete analysis.");
            redirectTo('list_patient.php');
        }
    }else{
            $session->message("The Patient  was NOT deleted.");
            redirectTo('list_patient.php');
    }
 if(isset($database)){$database->close_connection();  }
?>