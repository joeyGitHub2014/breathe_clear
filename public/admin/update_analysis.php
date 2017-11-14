<?php
    require_once("../../includes/initialize.php");
    $message = " ";
    $id = $_GET["id"];
    $value = $_GET["value"];
    $name = substr($_GET["name"],0,4) ;
    $patientId = $_GET["patientId"];
    $anaCnt = $_GET["anaCnt"];

    //-----------------------
    // update  Analysis
    //-----------------------
    $analysis = new Analysis();
    $analysis::set_analysis_table();
    $analysis->analysisCount = $anaCnt;
    $analysis->patientID = $patientId;
    $analysis->allergenID =  $id;
    if ($name == "wmsp"){
        $analysis->MSPScore = $value;
        if ($analysis->update_msp()){
            echo "MSPScore Update was a Succsess!";
        }
        else{
            echo "MSPScore Update Failed";
        }
    }
    elseif($name == "wisp"){
        $analysis->ITScore  = $value;
        if ($analysis->update_isp()){
            echo "ITScore Update was a Succsess!";
        }
        else{
            echo "ITScore Update Failed";
        }
    }else{
        $analysis->twoWhl  = $value;
        if ($analysis->update_twoWhl()){
            echo "2nd Wheel Update was a Succsess!";
        }
        else{
            echo "2nd Wheel Update Failed";
        }
    }
?>