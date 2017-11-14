<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
        //redirectTo("login.php");
    }
?>
<?php if(empty($_GET['id'])){
    $session->message("No Allergen ID was provided.");
    redirectTo('list_allergens.php');
}
Allergen::set_allergen_table();
$allergen= Allergen::getAllergen($_GET['id']);
if ($allergen && $allergen->delete() ){
    $session->message("The Allergen  was deleted.");
    redirectTo('list_allergens.php');
}else{
    $session->message("The allergen could not be deleted.");
    redirectTo('list_allergens.php');
}
?>

<?php if(isset($database)){$database->close_connection();  } ?>