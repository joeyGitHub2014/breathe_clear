<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
        redirectTo("login.php");
    }
?>
<?php
    inlcudeLayoutTemplet('admin_header.php');?>
    
        <?php echo outputMessage($message) ?>
    
            <h2 class="header" >Menu</h2>
            <p><a href="view_photos.php">Veiw Photos</a></p>
        </div>
        <div id= "footer">Copyright <?php echo date("Y",time())?>, Joseph Orlando</div>
    </body>
</html>
    