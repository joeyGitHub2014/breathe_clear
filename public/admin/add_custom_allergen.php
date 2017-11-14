<?php
require_once("../../includes/initialize.php");
if (isset($_POST)){
    $allergens = new CustomAllergens();
    $allergens::set_custom_allergens_table();
    $allergens->antigenName     = $_POST['antigenName'];
    $allergens->analysisCount   = $_POST['analysisCount'];
    $allergens->lotNumber       = $_POST['lotNumber'];
    $allergens->expDate         = $_POST['expDate'];
    $allergens->batteryName     = $_POST['batteryName'];
    $allergens->caption         = $_POST['caption'];
    $allergens->groupID         = $_POST['groupID'];
    $allergens->site            = $_POST['groupID'];
    $allergens->fileName        = 'nopicture.jpg';
    $allergens->patientID       =  $_POST['patientID'];
    $allergens->MSPScore        =  5;
    $allergens->ISPScore        =  5;
    $allergens->disabled        =  0;
    $allergens->twoWhl          =  0;

    if (!$allergens->create()){
        $msg = "Custom Allergen was Failed! Bad SQL query";
        $results = array('msg'=>$msg);
        echo json_encode($results);
    }else {
        $msg = "Custom Allergen was added!";
        $results = array('msg'=>$msg);
        echo json_encode($results);
    }
}
