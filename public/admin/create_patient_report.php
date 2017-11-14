<?php
    require_once("../../includes/initialize.php");
    if (!$session->is_logged_in()){
      redirectTo("login.php");
    }

include_once("../../includes/form_functions.php");
$dwoo = new Dwoo\Core();

if(isset($POST['save_report'])){
    echo "HI";
} elseif(!empty($_GET)) {
    $patientID = !empty($_GET['id'])? (int) $_GET ['id'] : 0;
    $treatment = !empty($_GET['treat'])? (int) $_GET ['treat'] : 0;
    $analysisCount = !empty($_GET['aCnt'])? (int) $_GET ['aCnt'] : 0;
} elseif(isset($POST['print_report'])){
         redirectTo('create_report.php');
} else{
     $session->message("No patient information was found so a report could not be created");
     redirectTo('list_patient.php');
}
Patient::set_patient_table();
$sql   = " SELECT *  FROM patient WHERE patientID = {$patientID} LIMIT 1";
$patient = Patient::find_by_sql($sql);
$lastname = $patient[0]->patientLast ;
$firstname = $patient[0] ->patientFirst ;
$lastname = $patient[0]->patientLast ;
$chartnumber = $patient[0]->chartNum ;
$dateofbirth =  $patient[0]->dateOfBirth;
$sex  =  $patient[0]->sex;
$homezip = $patient[0]->zipCodeHome;
$workzip = $patient[0]->zipCodeWork;
$tester = $patient[0]->tester;
$email = $patient[0]->email;
Allergen::set_allergen_table();
$total_count = Allergen::count_all();
$sql  = " SELECT batteryName, count( allergenID ) AS numAllergens  FROM allergens1 ";
$sql .= " GROUP BY batteryName ";
$allergen_list = Allergen::find_by_sql($sql);
$sql  = " SELECT *  FROM analysis  WHERE patientID = {$patientID} AND analysisCount = {$analysisCount} ";
Analysis::set_analysis_table();
$analysis_list = Analysis::find_by_sql($sql);
$allergic =  array();

if ($allergen_list>0 || $allergen_list>"") {
    Allergen::set_allergen_table();
     foreach($analysis_list as $key => $analysis) {
        if  (( $analysis->allergenID != 41 && $analysis->allergenID != 42)&&
            ( $analysis->MSPScore>= 7 || $analysis->ITScore >= 7 || $analysis->twoWhl>= 9)) {
            $sql  = " SELECT antigenName, groupID, fileName,  caption  FROM allergens1 ";
            $sql .= " WHERE allergenID = {$analysis->allergenID}  ";
            $allergic_list = Allergen::find_by_sql($sql);
            if (!empty($allergic_list)){
                array_push($allergic, array (
                                    "name" => $allergic_list[0]->antigenName,
                                    "caption" =>  $allergic_list[0]->caption,
                                    "filename" =>  $allergic_list[0]->fileName,
                                    "groupid" => $allergic_list[0]->groupID));
             }
        }
    }
}
// check if the patient has any custom allergens
CustomAllergens::set_custom_allergens_table();
$sql  = " SELECT antigenName, groupID, fileName, $patientID, caption, MSPScore, ISPScore, twoWhl FROM custom_allergens  ";
$sql .= " WHERE  patientID = ".$patientID;
$sql .= " ORDER BY groupID ASC  ";
$custom_allergen_list = CustomAllergens::find_by_sql($sql);
$custom_allergen_list_array = array();
if (!empty($custom_allergen_list)) {
    foreach ($custom_allergen_list as $key) {
        if ($key->MSPScore >= 7 || $key->ISPScore >= 7 || $key->twoWhl >= 9) {
            $arr1 = array(
                'name' => $key->antigenName,
                'caption' => $key->caption,
                'filename' => $key->fileName,
                'groupid' => $key->groupID);

            array_push($allergic, $arr1);
        }

    }
}
?>
<?php inlcudeLayoutTemplet('admin_header.php');?>
</br>
</br>
<div class="container">
    <div class="row">
        <div class="col-xs-4 col-centered col-min">
        </div>
        <div class="col-xs-4 col-centered col-min text-center">
            <h3 style="color:#0fbdf0"><b>www.breatheclearinstitute.com</h3>
        </div>
        <div class="col-xs-4 col-centered col-min">
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4 col-centered col-min">
        </div>
        <div class="col-xs-4 col-centered col-min text-center">
             <h3>Torrance Office</h3><br />
            20911 Earl St, Suite 470<br />
            Torrance, CA  90503<br />
            Phone 310.372.0700
        </div>
        <div class="col-xs-4 col-centered col-min">
        </div>
    </div>
</div>
<?php
$patientInfo = array('firstname'=>$firstname, 'lastname'=>$lastname, 'dateofbirth'=>$dateofbirth, 'chartnumber'=>$chartnumber,
    'homezip'=>$homezip, 'workzip'=>$workzip, 'tester'=>$tester, 'sex'=>$sex );
    echo $dwoo->get('../../templates/patientInfo.tpl', $patientInfo);

?>
    <form id ="frm_report"   method ="post">
    <table class="patientreport"  >

        <?php
            echo "<tr>";
            
            echo "<td id=\"print\">";             
            echo  "<input type=\"submit\" id=\"print_report\"   name =\"print_report\" value =\"Print Report\"   onclick=\"printpage()\"   />";
            echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
            Analysis::set_analysis_table();
            $treatment =  Analysis::get_treatment($patientID,$analysisCount);
            $dilutionLevel = Analysis::get_dilutionLevel($patientID,$analysisCount);
            echo "<a   href=\"update_entry_record.php?id={$patientID}&aCnt={$analysisCount}&treat={$treatment}&dilution={$dilutionLevel}\" class=\"linkButton\">click here for Entry Record </a>";
            echo "&nbsp&nbsp";
            echo "<a   href=\"create_report.php?id={$patientID}&aCnt={$analysisCount}&treat={$treatment}\" class=\"linkButton\">click here for Immunotherapy Report </a>";
            echo "</td>";
            echo "</tr>";
            echo "</br>";
            echo "<tr>";
            echo "<td>";             
            echo "<h4 class=\"title\" style=\"text-align:left;\"> Patient is Allergic to the following:  </h4>";
            echo "</td>";             
            echo "</tr>";
            echo "</br> </br>";
            $groups = array("Food","Mold","Trees","Grass","Weeds","Animals etc.");
            if (!empty($allergic)){
                $allergen = new Allergen;
                $allergen::set_allergen_table();
                $dir = $allergen->upload_dir;
                for ($i=0; $i <= sizeof($allergic)-1;$i++) {
                    $allergic[$i];
                    echo "<tr>";
                    echo "<td style=\"word-wrap:break-word;overflow:hidden\">";
                    echo "<hr>";
                    echo "<b>".$allergic[$i]['name']."</b>  ";
                    echo "</br>";
                    echo "</br>";
                    echo "<b> Group: ".$groups[$allergic[$i]['groupid']]."</b>  ";
                    echo "</br>";
                    echo "</br>";
                    echo  "  ".$allergic[$i]['caption'];
                    $name = $allergic[$i]['filename'];
                    $target_path = '../'.$dir.'/'.$name;
                    echo "</br>";
                    echo "</br>";
                    echo "<img src=\"{$target_path}\" alt=\"{$name}\" height=\"200\" width=\"200\" />";
                    echo "</br>";
                    echo "</td>";
                    echo "</tr>";
                }
        }
        
        ?>
        </table>
    </form>
<?php inlcudeLayoutTemplet('footer.php');?>
