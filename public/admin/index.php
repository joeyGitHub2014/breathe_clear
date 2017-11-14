<?php
    require_once("../../includes/initialize.php");
    // Include the main class, the rest will be automatically loaded

    if (!$session->is_logged_in()){
        redirectTo("login.php");
    }
    inlcudeLayoutTemplet("admin_header.php");
    echo outputMessage($message);

    echo "</div>";
    inlcudeLayoutTemplet("footer.php");
?>
