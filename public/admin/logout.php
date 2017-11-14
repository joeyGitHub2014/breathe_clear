<?php
    require_once("../../includes/initialize.php");
    $message ="";
    $session->logout();
    redirectTo("login.php");
?>
<?php if (isset($database)){      $database->closeConnection();    } ?>
    