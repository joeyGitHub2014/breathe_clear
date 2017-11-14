<?php
    require_once("../../includes/initialize.php");
    $patientID  = $_POST["patientID"];
    $allergenID = $_POST["allergenID"];
    $score      = $_POST["score"];
    $name       = $_POST["fieldName"] ;

    //------------------------------------------
    // update Custom Analysis isp or msp score
    //------------------------------------------
    $analysis = new CustomAllergens();
    $analysis::set_custom_allergens_table();
    $analysis->patientID = $patientID;
    $analysis->allergenID =  $allergenID ;
    if ($name == "wmsp"){
        $analysis->MSPScore = $score;
        if ($analysis->update_msp()){
            echo "MSP Score Update was a Succsess!";
        }
        else{
            echo "MSP Score Update Failed";
        }
    }
    elseif($name == "wisp"){
        $analysis->ISPScore  = $score;
        if ($analysis->update_isp()){
            echo "ISP Score Update was a Succsess!";
        }
        else{
            echo "ISP Score Update Failed";
        }
    }elseif ($name == "customTwoWhl"){
        $analysis->twoWhl  = $score;
        if ($analysis->update_twoWhl()){
            echo "2nd Wheel Update was a Succsess!";
        }
        else{
            echo "2nd Wheel Update Failed";
        }
    }
?>