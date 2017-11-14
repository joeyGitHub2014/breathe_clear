<?php
require_once("../../includes/initialize.php");
if (isset($_POST)){
    $allergens = new CustomAllergens();
    $allergens::set_custom_allergens_table();
    $result = $allergens::getCustomAllergen($_POST['allergenID'],$_POST['patientID'] );
    $allergens->antigenName     = $result->antigenName;
    $allergens->analysisCount   = $result->analysisCount;
    $allergens->lotNumber       = $result->lotNumber;
    $allergens->expDate         = $result->expDate;
    $allergens->batteryName     = $result->batteryName;
    $allergens->caption         = $result->caption;
    $allergens->groupID         = $result->groupID;
    $allergens->site            = $result->site;
    $allergens->fileName        = 'nopicture.jpg';
    $allergens->patientID       =  $_POST['currentpatientID'];
    $allergens->MSPScore        =  5;
    $allergens->ISPScore        =  5;

    if (!$allergens->create()){
        $session->message("ERROR: Could not create Custom Allergen record.");
    }else {
        $msg = "Custom Allergen was added!";
        $results = array('msg'=>$msg);
        echo json_encode($results);
    }
}
