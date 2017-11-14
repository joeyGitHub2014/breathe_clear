<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
        redirectTo("login.php");
    }
    $allergenname = "";
    $lotnumber = "";
    $expdate = "";
    $groupid = "";
    $caption = "";
    $batteryname = "";
    $groupname ="";
    $disabled ="";

    $groups = array("Food","Mold","Trees","Grass","Weeds","Animals etc.");
    include_once("../../includes/form_functions.php");
    $max_file_size = 2048576;
    $page = !empty($_GET['page'])? (int) $_GET ['page'] : 1;
    $per_page = 50;
    Allergen::set_allergen_table();
    $total_count = Allergen::count_all();
    $pagination = new Pagination($page,$per_page,$total_count);
    $sql = "SELECT * FROM allergens1 WHERE customID = 0";
    $sql .= " LIMIT {$per_page}";
    $sql .= " OFFSET {$pagination->offset()}";
    $allergen_list = Allergen::find_by_sql($sql);
    $count = 1;

    if(isset($_POST['submit'])|| isset($_POST['update'])){
        Allergen::set_allergen_table();
        $allergens = new Allergen();
        $errors = array();
        $items = array('allergenname','lotnumber','expdate','batteryname' );
        $errors =  array_merge($errors, checkRequiredFields($items,$_POST));
	    $fieldLengthArray = array('allergenname' => 50, 'lotnumber' => 10, 'expdate' => 5,'batteryname' => 1, 'groupid' => 1 );
        $errors =  array_merge($errors, checkMaxFieldLengths($fieldLengthArray,$_POST));
        $errors =  array_merge($errors, checkGroupID($_POST['groupid']));
        if (empty($errors)){
            $allergens->set_allergen_table();
            $allergens->antigenName = $_POST['allergenname'];
            $allergens->lotNumber = $_POST['lotnumber'];
            $allergens->expDate = $_POST['expdate'];
            $allergens->batteryName = $_POST['batteryname'];
            $allergens->caption = $_POST['caption'];
            $allergens->groupID = $_POST['groupid'];
            $allergens->disabled = $_POST['disabled'];

            strip_tags($allergens->caption,'<strong><em><p> <b>');
            if(isset($_POST['submit'])){
                if (!empty($_FILES['file_upload'])){
                    $allergens->attach_file($_FILES['file_upload']);
                    if ($allergens->save()){
                        $session->message("Allergen created.");
                        redirectTo('list_allergens.php');
                    }else{
                        $message = join("<br/>", $allergens->errors);
                    }
                }
            }
            else{
                  $allergens->allergenID = $_POST['allergenid'];
                   if (isset($_FILES['file_upload'])){
                        $allergens->attach_file($_FILES['file_upload']);
                        if($allergens->move_image()){
                            if ($allergens->update()){
                                $file_message = "Allergen and image updated!";
                            }
                        }else{
                            if ($allergens->update()){
                                $file_message = "Allergen updated but not image.";
                            }else{
                                $file_message = "Update failed. (Nothing may have changed)";
                            }
                        }
                   }elseif ($allergens->update()){
                        $file_message = "Allergen updated.";
                    }else{
                        $file_message = "Update failed. ";
                    }
                $session->message($file_message);
                redirectTo('list_allergens.php');
            }
        }else{
            if (count($errors) == 1){
                $message =  "There was 1 error in the form";
            }else{
                $message =  "There were ". count($errors) . " errors in the form";
            }
        }
    } else{
        $allergenname = "";
        $lotnumber = "";
        $expdate = "";
        $groupid = "";
        $caption = "";
        $batteryname = "";
        $groupname ="";
        $disabled ="";

    }
 ?>
<?php inlcudeLayoutTemplet('admin_header.php');?>
<h2 class="title">Allergen List</h2>
<table class="allergenUpdate" >
    <tr>
    <h3 class="message"> <?php

         echo outputMessage($message); echo  "</h3>"; if (!empty($errors) ){ displayErrors($errors); }?>
    <form id="frm_allergen"  enctype="multipart/form-data"  method ="post">
    <td>
        <?php //MAX_FILE_SIZE - set to 2M  in this case. Can not exxceed the setting in phpinfo file
        // which is 8M i.e. upload_max_filesize = 8M. If file exceeds 2M php will complain ?>
        <p > Allergen Name:   
        <input type="text" id= "allergenname"  name="allergenname"     maxlength="50" value="<?php echo htmlentities($allergenname)?>" />
        &nbsp&nbsp Lot number:  
        <input type="text" id= "lotnumber"  name="lotnumber"    maxlength="10" value="<?php echo htmlentities($lotnumber)?>" />
        </p>
        <p> 
        Exp. Date:  
        <input  type="text" id= "expdate"  name="expdate"    maxlength="5" value="<?php echo htmlentities($expdate)?>" />
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Battery Name (A,B,C,D):  
        <input type="text"  id= "batteryname" name="batteryname"  size="1"   maxlength="1" value="<?php echo htmlentities($batteryname)?>" />
        </p>
        <p>
        Group ID: 
        <input type="text"  id="groupid" name="groupid"  size="1"   maxlength="1" value="<?php echo htmlentities($groupid)?>" />
        <input type="text"  id="groupname" name="groupname" readonly="readonly"  size="15" style="color: #c3c3c3"   maxlength="20" value="<?php echo htmlentities($groupname)?>" />
    </p>
    <p>
       0 = Foods, 1 = Mold, 2 = Trees, 3 = Grass, 4 = Weeds, 5 = Animals etc
    </p>
    </td>
    </tr>
    <tr> 
    <td style="color:rgb(ff00d2) " ><p>Select Allergen photo (if available):</p>
       <input type="hidden" name="MAX_FILE_SIZE" value="2000000" /> 
       <input id="filename" style="color: rgb(255,0,0)"  type="file" name="file_upload" value=""/>
       <p>Enter allergen Infromation:</p> <textarea  id= "caption" rows="10" cols="80" name="caption"  > </textarea> 
    </td>
    </tr>
    <tr> 
    <td>           
        <input type="submit" id="submit"     name ="submit"      value = "Submit New Allergen" />
        <input type="submit" id="update"     name ="update"      value = "Update Allergen" disabled="disabled" />
        <input type="submit" id="cancel"     name ="cancel"      value = "Cancel" disabled="disabled" />
        <input type="hidden" id="allergenid" name ="allergenid"  value = " " />;
    </td>
    <tr>
      <td>
        <hr>
      </td>
    </tr>
    <?php
    foreach($allergen_list as $key => $allergen){
        if ($count == 1){
         echo "<tr>";
         echo "<td>";
        }
        echo "<input type=\"button\" style=\"color:black\" name=\"updateAllergenButton\" value=\"{$allergen->antigenName}\" onclick=\"updateAllergen({$allergen->allergenID})\"  />" ;
        $count += 1;
        if ($count == 5){
            echo "</tr>";
            echo "</td>";
            $count = 1;
        }
    }
    ?>
    </tr>
    </form>
</table>
<br>
<div id="pagination"  style="clear:both">
<?php
    if ($pagination->total_pages() > 1){
        if ($pagination->has_previous_page()){
            echo " <a href=\"list_allergens.php?page=";
            echo $pagination->previous_page();
            echo "\">&laquo Prev</a> ";
        }else{
            echo "<span class=\"notselected\">&laquo Prev </span> ";
        }
        for($i = 1; $i <= $pagination->total_pages(); $i++){
            if ($i == $page){
                echo "<span class=\"selected\">{$i}</span> ";
            }else{
                echo " <a href=\"list_allergens?page={$i}\">{$i}</a>";
            }
        }
        if ($pagination->has_next_page()){
            echo " <a href=\"list_allergens.php?page=";
            echo $pagination->next_page();
            echo "\">Next &raquo</a> ";
        }else{
            echo "<span class=\"notselected\">Next &raquo</span> ";
        }
    }
    
    ?>
</div>
<table class="allergen" >
<tr>
<th style="width:110px">Allergen</th>
<th style="width:70px">Image</th>
<th style="width:270px">Caption</th>
<th>Lot Number</th>
<th >Exp. Date</th>
<th >Group ID</th>
<th>Update</th>
    <th>Disable</th>

</tr>
 <br/>
 <br/>
<?php

//using clear:both so that pagination goes below the float:left style above ?>
<?php foreach($allergen_list as $key => $allergen){
    echo $allergen->disabled == 0 ? "<tr>" : "<tr style='background: darkgrey;'>"  ;

    echo "<td>";
    echo "  ".$allergen->antigenName;
    echo "</td>";
    echo "<td>";
    $name = $allergen->fileName;
    $target_path = '../'. $allergen->upload_dir .'/'. $allergen->fileName;
    echo "<img src=\"{$target_path}\" alt=\"{$allergen->fileName}\" height=\"67\" width=\"67\" />";
    echo "</td>";
    echo "<td style=\"word-wrap:break-word;overflow:hidden\" >";
    echo  "  ".$allergen->caption;
    echo "</td>";
    echo "<td>";
    echo "  ".$allergen->lotNumber;
    echo "</td>";
    echo "<td>";
    echo "  ".$allergen->expDate;
    echo "</td>";
    echo "<td>";
    echo "  ".$groups[$allergen->groupID];
    echo "</td>";
    echo "<td>";
    echo "<input type=\"radio\" id=\"allergenID{$allergen->allergenID}\"  name=\"updateAllergen\" value=\"{$allergen->allergenID}\" onclick=\"updateAllergen(this.value)\"  />" ;
    echo  "<input type=\"hidden\" id=\"antigenname{$allergen->allergenID}\"    name=\"antigenname\" value=\"{$allergen->antigenName}\" >";
    echo  "<input type=\"hidden\" id=\"caption{$allergen->allergenID}\"    name=\"caption\" value=\"{$allergen->caption}\" >";
    echo  "<input type=\"hidden\" id=\"lotNumber{$allergen->allergenID}\"    name=\"lotNumber\" value=\"{$allergen->lotNumber}\" >";
    echo  "<input type=\"hidden\" id=\"expDate{$allergen->allergenID}\"    name=\"expDate\" value=\"{$allergen->expDate}\" >";
    echo  "<input type=\"hidden\" id=\"groupID{$allergen->allergenID}\"    name=\"groupID\" value=\"{$allergen->groupID}\" >";
    //echo  "<input type=\"hidden\" id=\"fileName{$allergen->allergenID}\"    name=\"fileName\" value=\"{$allergen->fileName}\" >";
    echo  "<input type=\"hidden\" id=\"batteryName{$allergen->allergenID}\"    name=\"batteryName\" value=\"{$allergen->batteryName}\" >";
    echo  "<input type=\"hidden\" id=\"groupName{$allergen->allergenID}\"    name=\"groupName\" value=\"{$groups[$allergen->groupID]}\" >";
    echo "</td>";
    echo "<td>";
    echo "<input type=\"checkbox\" id=\"disabled{$allergen->allergenID}\"  name=\"disableAllergen\" value=\"{$allergen->allergenID}\" onclick=\"updateDisable(this.value)\" " ;
    echo $allergen->disabled == 0 ? "/>" : " checked=\"yes\"  /> ";
    echo "</td>";
    echo "</tr>";

}?>
</table>
<?php inlcudeLayoutTemplet('footer.php');?>

    