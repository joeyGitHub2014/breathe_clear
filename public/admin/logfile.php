<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
        redirectTo("index.php");
    }
    $file = SITE_ROOT.DS."/logs/logfile.txt";
    if (isset($_GET['clear'])){ 
        if($_GET['clear']=='true'){
            file_put_contents($file,'');
            logAction('Log Cleared ', "by User ID {$session->user_id}");
            redirectTo('logfile.php');
        }
    }
     
?>
<?php    inlcudeLayoutTemplet('admin_header.php');?>

            <h2 class="header" >Log File Output</h2>
         <?php
            $content = "";
            if(file_exists($file) && is_readable($file) && $handle = fopen($file,'r')){ // appends records
                while(!feof($handle)){
                        $content .= fgets($handle);
                        $content .= "<br/>";
                }
               fclose($handle);
             }else{
                echo   "Could not open file for reading.";
             }
            echo "<br/>";
            echo "<table>".$content."</table>";
            echo "<br/>";
            echo " <hr/>";
            ?>
        <a href="logfile.php?clear=true">Clear Log File</a>
        </div>
        <div id= "footer">Copyright <?php echo date("Y",time())?>, Joseph Orlando</div>
    </body>
</html>
    