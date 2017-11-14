<?php
    require_once("../../includes/initialize.php");
    $dilution = $_GET['dilution'];
    $patientId = $_GET['patientId'];
    $anaCnt = $_GET['anaCnt'];
    $treat = $_GET['treat'];
//---------------------------------------
// update  Dilution or Refill in Analysis
//---------------------------------------
    $analysis = new Analysis();
    $analysis::set_analysis_table();
    $analysis->analysisCount = $anaCnt;
    $analysis->patientID = $patientId;
    if ($treat != 1){
       $analysis->dilutionLevel = $dilution;
       if  ($analysis->update_dilutionLevel()) {
            echo " Dilution Update was a Succsess";
        }else{
           echo " Dilution Update Failed";
        }
    }else{
       $analysis->refill = $dilution;
       if  ($analysis->update_refill()) {
            echo " Refill Update was a Succsess";
        }else{
            echo " Refill Update Failed";
        }
    }
?>