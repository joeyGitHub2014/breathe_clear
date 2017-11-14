<?php
    require_once("../../includes/initialize.php");
    $treat = $_GET['treat'];
    $patientId = $_GET['patientId'];
    $anaCnt = $_GET['anaCnt'];
//------------------------------
// update  treatment in Analysis
//------------------------------
    $analysis = new Analysis();
    $analysis::set_analysis_table();
    $analysis->analysisCount = $anaCnt;
    $analysis->patientID = $patientId;
    $analysis->treatment = $treat;
       if  ($analysis->update_treat($patientId, $anaCnt)) {
            echo " Treatment Update was a Succsess!";
        }else{
           echo " Treatment Update Failed";
        }
   //echo "Update was a succsess"; 
   // echo "<p>".$id."</br>".$value."</br>".$name."</br>".$treat."</br>".$patientId."</br>".$anaCnt."</p>";
?>