<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
        redirectTo("login.php");
    }
?>
<?php
    $max_file_size = 2048576;
    if(isset($_POST['submit'])){
        $photo = new Photograph();
        $photo->set_table_fields();
        $photo->caption = $_POST['caption'];
        $photo->attach_file($_FILES['file_upload']);
        if ($photo->save()){
            $session->message("Photograph uploaded successfully.");
            redirectTo('view_photos.php');
        }else{
            $message = join("<br/>", $photo->errors);
        }
    }
?>
<?php inlcudeLayoutTemplet('admin_header.php');?>
        <h2>Photo Upload</h2>
        <?php echo outputMessage($message) ?>
 	<form action="photo_upload.php" enctype="multipart/form-data"  method ="post">
        <?php //MAX_FILE_SIZE - set to 2M  in this case. Can not exxceed the setting in phpinfo file
              // which is 8M i.e. upload_max_filesize = 8M. If file exceeds 2M php will complain ?>
           <input type="hidden" name="MAX_FILE_SIZE" value="2000000" /> 
            <p><input type="file" name="file_upload" value=""/></p>
            <p>Caption: </p><input type="text" name="caption" value=""/>
            <input type="submit"  name ="submit" value ="Upload" />
        </form>
        <div id= "footer">Copyright <?php echo date("Y",time())?>, Joseph Orlando</div>
    </body>
</html>
    