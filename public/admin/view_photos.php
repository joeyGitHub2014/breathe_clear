<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
        redirectTo("login.php");
    }
?>
<?php
    $max_file_size = 2048576;
    //$photo = new Photograph();
    //$photo->set_table_fields();
    //$photo_list = $photo->find_all();
        // 1.current page number
    $page = !empty($_GET['page'])? (int) $_GET ['page'] : 1;
    // 2. records per page
    $per_page = 4;
    // 3. total record coun
    Photograph::set_table_fields();
    $total_count = Photograph::count_all();
    $pagination = new Pagination($page,$per_page,$total_count);
    $sql = "SELECT * FROM photographs ";
    $sql .= " LIMIT {$per_page}";
    $sql .= " OFFSET {$pagination->offset()}";
    $photo_list = Photograph::find_by_sql($sql);
 ?>
<?php inlcudeLayoutTemplet('admin_header.php');?>
        <h2>View Photos</h2>
        </br>
        <div id="pagination"  style="clear:both">
            <?php
                if ($pagination->total_pages() > 1){
                    if ($pagination->has_previous_page()){
                        echo " <a href=\"view_photos.php?page=";
                        echo $pagination->previous_page();
                        echo "\">&laquo Prev</a> ";
                    }else{
                        echo "<span class=\"notselected\">&laquo Prev </span> ";
                    }
                    for($i = 1; $i <= $pagination->total_pages(); $i++){
                        if ($i == $page){
                            echo "<span class=\"selected\">{$i}</span> ";
                        }else{
                            echo " <a href=\"view_photos?page={$i}\">{$i}</a>";
                        }
                    }
                    if ($pagination->has_next_page()){
                        echo " <a href=\"view_photos.php?page=";
                        echo $pagination->next_page();
                        echo "\">Next &raquo</a> ";
                    }else{
                        echo "<span class=\"notselected\">Next &raquo</span> ";
                    }
                }
                
            ?>
         </div>
        <table class="bordered" width=800px>
        <tr>
        <th>Image/Filename</th>
        <th>Caption</th>
        <th>Type</th>
        <th>Size</th>
        <th>Comments</th>
         <th>&nbsp</th>
        </tr>
        <?php echo outputMessage($message) ?>
         <br/>
         <br/>
         <?php //using clear:both so that pagination goes below the float:left style above ?>

        <?php foreach($photo_list as $key => $photo){
            echo "<tr   >";
            echo "<td>";
            $name = $photo->filename;
            $target_path = '../'. $photo->upload_dir .'/'. $photo->filename;
            echo "<img src=\"{$target_path}\" alt=\"{$photo->filename}\" height=\"70\" width=\"70\" />";
            echo  $target_path;
            echo "</td>";
            echo "<td>";
            echo "  ".$photo->caption;
            echo "</td>";
            echo "<td>";
            echo  "  ".$photo->type;
            echo "</td>";
            echo "<td>";
            echo "  ".$photo->size_as_text();
            echo "</td>";
            echo "<td>";
            echo  "<a href=\"comments.php?id={$photo->id}\">".  count($photo->comments()) ."</a>";
            echo "</td>";
            echo "<td>";
            echo "<a href=\"delete_photos.php?id={$photo->id}\"> Delete </a>";
            echo "</td>";
            echo "<tr/>";
        }?>
        </table>
        <p>&nbsp</p>
        <div id= "footer">Copyright <?php echo date("Y",time())?>, Joseph Orlando</div>
    </body>
</html>
    