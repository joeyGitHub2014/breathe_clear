<?php
require_once("../../includes/initialize.php");
if (isset($_POST)){
    $allergens = new CustomAllergens();
    $allergens::set_custom_allergens_table();

    $allergens->antigenName = $_POST['antigenName'];
    $allergens->lotNumber = $_POST['lotNumber'];
    $allergens->expDate = $_POST['expDate'];
    $allergens->batteryName = $_POST['batteryName'];
    $allergens->caption = $_POST['caption'];
    $allergens->groupID = $_POST['groupID'];
    $result = $allergens->update($_POST['allergenID'],$_POST['patientID'] );

    if (!$result){
        $msg = "Custom Allergen NOT updated. Nothing was changed!";
        echo json_encode(array('msg'=>$msg));
    }else {
        $msg = "Custom Allergen was edited!";
         echo json_encode(array('msg'=>$msg));
    }
}
