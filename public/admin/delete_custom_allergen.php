<?php
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()){
    //redirectTo("login.php");
}
if(empty($_POST['patientID']) || empty($_POST['allergenID'] ) ){
    $session->message("No Allergen ID or Patient ID  provided.");
    redirectTo('list_patient.php');
}

$customAllergens =  new CustomAllergens();
$customAllergens::set_custom_allergens_table();
$customAllergens->allergenID =  $_POST['allergenID'];
$customAllergens->patientID  =  $_POST['patientID'];
$result = $customAllergens->delete();
if (!$result){
    $msg = "Custom Allergen NOT deleted.";
    echo json_encode(array('msg'=>$msg));
}else {
    $msg = "Custom Allergen was deleted!";
    echo json_encode(array('msg'=>$msg));
}
if(isset($database)){
    $database->closeConnection();
}
