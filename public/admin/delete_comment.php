<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
        redirectTo("login.php");
    }
?>
<?php if(empty($_GET['id'])){
    $session->message("No comment ID was provided.");
    redirectTo('index.php');
}
Comment::set_table_fields();
$comment = Comment::find_by_id($_GET['id']);
if ($comment && $comment->delete() ){
    $session->message("The comment was deleted.");
    redirectTo("comments.php?id={$comment->photograph_id}");
}else{
    $session->message("The comment could not be deleted.");
    redirectTo('index.php');
}
?>

<?php if(isset($database)){$database->close_connection();  } ?>