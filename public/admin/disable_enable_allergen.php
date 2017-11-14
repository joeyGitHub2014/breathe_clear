<?php
require_once("../../includes/initialize.php");
    if (!$session->is_logged_in()){
    //redirectTo("login.php");
}

if(empty($_POST['id'])){
    $session->message("No Allergen ID was provided.");
    redirectTo('list_allergens.php');
}
Allergen::set_allergen_table();
$allergen= Allergen::getAllergen($_POST['id']);
Allergen::update_disabled(($allergen->disabled)?$r=0:$r=1, $allergen->allergenID);
if(isset($database)){$database->closeConnection();  }
