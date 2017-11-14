<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
        //redirectTo("login.php");
    }
?>
<?php if(empty($_GET['id'])){
    $session->message("No photograph ID was provided.");
    redirectTo('list_allergens.php');
}
Photograph::set_table_fields();
$photo= Photograph::find_by_id($_GET['id']);
if ($photo && $photo->destroy() ){
    $session->message("The photo    {$photo->filename}  was deleted.");
    redirectTo('list_allergens.php');
}else{
    $session->message("The photo could not be deleted.");
    redirectTo('list_allergens.php');
}
?>

<?php if(isset($database)){$database->close_connection();  } ?>