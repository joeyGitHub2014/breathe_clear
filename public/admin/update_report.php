<?php
    require_once("../../includes/initialize.php");
    $id = $_GET['id'];
    $value = $_GET['value'];
    $name = substr($_GET['name'],0,4) ;
    $patientId = $_GET['patientId'];
    $anaCnt = $_GET['anaCnt'];
    $message = " ";
//-----------------------
// update  Analysis
//-----------------------
    $report = new Report();
    $report->set_table_fields();
    $report->analysisCount = $anaCnt;
    $report->patientID = $patientId;
    $report->allergenID =  $id;
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

    //echo "Update was a succsess"; 
   // echo "<p>".$id."</br>".$value."</br>".$name."</br>".$treat."</br>".$patientId."</br>".$anaCnt."</p>";



?>