<?php
require_once("../../includes/initialize.php");
if (isset($_POST)){
    $allergens = new CustomAllergens();
    $allergens::set_custom_allergens_table();
    $result = $allergens::getCustomAllergen($_POST['allergenID'],$_POST['patientID'] );

    if (!$result){
        $session->message("ERROR: Could  GET Custom Allergen.");
    }else {
          echo json_encode($result);
    }
}
