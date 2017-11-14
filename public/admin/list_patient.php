<?php
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()){
  redirectTo("login.php");
}
inlcudeLayoutTemplet('admin_header.php');
$analysis = new Analysis;
if (isset($_POST['submit'])  && !empty($_POST['search'])) {
    $per_page = 60;
    Patient::set_patient_table();
    $sql = "";
    $sql = "SELECT * FROM patient ";
    $page = 1;
    $field = htmlspecialchars($_POST['search']);
    $sql .= " WHERE patientLast LIKE '{$field}%'";
    $sql .= " OR chartNum LIKE '{$field}%'";
    $sql .= " LIMIT {$per_page}";
    $patient_list = Patient::find_by_sql($sql);
    $total_count = count($patient_list);
    $pagination = new Pagination($page, $per_page, $total_count);
} else
{
    // 1.current page number
    $page = !empty($_GET['page'])? (int) $_GET ['page'] : 1;
    $id = !empty($_GET['id'])? (int) $_GET ['id'] : '';
    // 2. records per page
    $per_page = 60;
    Patient::set_patient_table();
    $pagination = new Pagination($page,$per_page,180);
    $sql = "SELECT * FROM patient ";
    if ($id != ''){
        $sql .= "WHERE patientID = {$id}";
    }else {
        $sql .= "WHERE dateAdded >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
    }
    $sql .= " ORDER BY dateAdded  DESC ";
    $sql .= " LIMIT {$per_page}";
    $sql .= " OFFSET {$pagination->offset()} ";
    $patient_list = Patient::find_by_sql($sql);
}
 ?>
<h2 class="title" >Patient List</h2>
</br>
<?php
    echo "<h3 style=\"color: rgb(200,45,125);text-align: center; font-size:14px\">";
        if (!empty($message) ){echo  $message;}
        if (!empty($errors) ){ displayErrors($errors); }
    echo "</h2>";
 ?>
</br>
<table class="entrynoborder"  width=850>
    <tr>
        <td align="left">
            <ul class="pagination">
                <?php
                    $maxPages = $pagination->total_pages();
                     if ($maxPages > 1) {
                        $currentPage = $pagination->current_page;
                        $pageNumMax = 6;
                        $start = 1;
                         if ($currentPage > $pageNumMax && $currentPage <= $maxPages  ){
                            if ($currentPage + $pageNumMax-1 <  $maxPages ){
                                if (!$pagination->has_next_page()) {
                                    $pageNumMax = $currentPage;
                                    $start = $currentPage - ($pageNumMax - 1);
                                }else {
                                    $start = $currentPage;
                                    $pageNumMax = $currentPage + $pageNumMax - 1;
                                }
                            }else {
                                $start = $maxPages - (  $pageNumMax - 1) ;
                                $pageNumMax = $maxPages;
                            }
                        }else if ($maxPages < $pageNumMax){
                            $pageNumMax = $maxPages;
                        }
                        echo "<li class='active'><a href='list_patient.php?page={$pagination->previous_page()}'>&laquo;</a></li>";
                        for($i = $start; $i <= $pageNumMax; $i++){
                            if ($i == $page){
                                echo "<li class='active'><a href='list_patient.php?page={$i}'>{$i}</a></li>";
                            }else{
                                echo  "<li><a href='list_patient.php?page={$i}'>{$i}</a></li>";
                            }
                        }
                        echo "<li><a href='list_patient.php?page={$pagination->next_page()}'>&raquo;</a></li>";
                     }
                ?>
            </ul>
        </td>
        <td align="right"  >
            <form  action="list_patient.php"   method ="post" >
                <div>
                    Search:
                    <input type="search" name="search"  placeholder="Last Name or Chart#"  autofocus>
                    <input type="submit" name="submit"  value="Submit">
                </div>
            </form>
        </td>
    </tr>
</table>
<?php //using clear:both so that pagination goes below the float:left style above ?>
<?php Analysis::set_analysis_table();?>
<div class="glossymenu"  >
<?php
foreach($patient_list as $key => $patient) {
    $analysis_count = Analysis::get_max_analysis_count($patient->patientID);
    echo "<a class=\"menuitem submenuheader\" href=\"#\">" .$patient->patientLast." ".$patient->patientFirst."</a>";
    echo "<div class=\"submenu\">";
    echo "<ul>";
    echo "<h3>&nbsp Chart Number:{$patient->chartNum}&nbsp&nbsp&nbsp Sex:{$patient->sex} &nbsp&nbsp&nbsp DOB:{$patient->dateOfBirth}
                   &nbsp&nbsp&nbsp Home Zip:{$patient->zipCodeHome}&nbsp&nbsp&nbsp  Work Zip: {$patient->zipCodeWork}&nbsp&nbsp&nbsp Date Added:{$patient->dateAdded} ";
    echo  "<br/>";
    echo   "&nbsp <a href=\"add_analisys.php?id={$patient->patientID}&aCnt={$analysis_count}\"> Add Analisys</a>";
    echo  "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo    "<a href=\"update_patient.php?id={$patient->patientID}\"> Update Patient</a>";
    echo      "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo      "<button onclick=\"deletePatient({$patient->patientID})\"> Delete Patient</button>";
    echo      "</h3>";
    echo      "<hr>";
    if ($analysis_count >= "") {
        for($i=0; $i <= $analysis_count; $i++){
            $date = Analysis::get_analysis_date($patient->patientID, $i);
            $treatment = Analysis::get_treatment($patient->patientID,$i);
            $dilutionLevel = Analysis::get_dilutionLevel($patient->patientID,$i);
             if ($date){
                echo            "<li>";
                echo            "<h3>&nbsp Analysis performed on: {$date->dateAdded} </h3>";
                echo            "<a href=\"create_patient_report.php?id={$patient->patientID}&aCnt={$i}\"> Patient Report </a>";
                echo            "<a href=\"update_entry_record.php?id={$patient->patientID}&aCnt={$i}&treat={$treatment}&dilution={$dilutionLevel}\">Edit Entry Record </a>";
                if ($treatment == 2){
                    echo            "<a href=\"create_report.php?id={$patient->patientID}&aCnt={$i}&treat={$treatment}\">Immunotherapy Report (Treatment = INJECTION) </a>";
                }elseif ($treatment == 1){
                    echo            "<a href=\"create_report.php?id={$patient->patientID}&aCnt={$i}&treat={$treatment}\">Immunotherapy Report (Treatment = DROPS) </a>";
                }else{
                    echo            "<a href=\"create_report.php?id={$patient->patientID}&aCnt={$i}&treat={$treatment}\">Immunotherapy Report (Note:Treatment is Not Yet Determined (NYD) the report will generate as a Drops treatment.  Use Edit Entry Record to change treatment type.) </a>";
                }
                echo            "<a href=\"delete_analisys.php?id={$patient->patientID}&aCnt={$i}\">Delete Analysis  </a>";

                echo            "</li>";
             }
        }
    }
    echo "</ul>";
    echo "</div>";
}
?>
</div>

<?php inlcudeLayoutTemplet('footer.php');?>