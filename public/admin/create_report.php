<?php
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()){
  redirectTo("login.php");
}
include_once("../../includes/form_functions.php");
$quantity = .2;
$ingredients  = "";
$totalSolution = 5;
$totalVolume = 5;
$allergicAnimals = array();
$allergicPollens = array();
$allergicCockroch = array();
$custom_allergens_list = array();
$custom_allergens_list = null;

$dwoo = new Dwoo\Core();


if (isset($_POST['submit_report']) || !empty($_POST['print_report']) ) {
    $patientID = $_POST['patientID'];
    $treatment = $_POST['treatment'];
    $analysisCount = $_POST['analysisCount'];
}
elseif(!empty($_GET)) {
    $patientID = !empty($_GET['id'])? (int) $_GET ['id'] : 0;
    $treatment = !empty($_GET['treat'])? (int) $_GET ['treat'] : 0;
    $analysisCount = !empty($_GET['aCnt'])? (int) $_GET ['aCnt'] : 0;
 }
else{
    if(empty($_POST)) {
        $session->message("No patient information was found so a report could not be created");
        redirectTo('list_patient.php');
    }
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
$vials = 0;
$vialA = "";
$vialB = "";
$vialC= "";
$dilutionLevel = "";
$labelAr = []; 

Allergen::set_allergen_table();
$total_count = Allergen::count_all();
$sql  = " SELECT batteryName, count( allergenID ) AS numAllergens  FROM allergens1 ";
$sql .= " GROUP BY batteryName ";
$allergen_list = Allergen::find_by_sql($sql);
$sql  = " SELECT *  FROM analysis  WHERE patientID = {$patientID} AND analysisCount = {$analysisCount} ";
Analysis::set_analysis_table();
$analysis_list = Analysis::find_by_sql($sql);

if (isset($allergen_list)) {
    $allergic =  array();
    Allergen::set_allergen_table();
    foreach($analysis_list as $key => $analysis){
        if (( $analysis->allergenID != 41 && $analysis->allergenID != 42)&&
            ($analysis->MSPScore>= 7 || $analysis->ITScore >= 7 || $analysis->twoWhl>= 9)){
            $sql  = " SELECT antigenName, groupID, batteryName, lotNumber, expDate  FROM allergens1 ";
            $sql .= " WHERE allergenID = {$analysis->allergenID}  ";
            $allergic_list = Allergen::find_by_sql($sql);
            if (!empty($allergic_list)){
                if (($allergic_list[0]->groupID != 0)) {
                    $a = getArray( $analysis, $allergic_list);
                    if ( $a['id'] == 8  || $a['id']   == 14  ||($a['id'] >= 24 && $a['id'] <= 25) ||
                         $a['id'] == 27  || $a['id']   == 28  ||($a['id'] >= 32 && $a['id'] <= 34) ){
                         array_push($allergicAnimals, $a);

                    }elseif($a['id'] == 23) {
                        array_push($allergicCockroch, $a);

                    }
                    else
                    {
                        array_push($allergicPollens, $a);
                    }
                    array_push($allergic, $a);
                }
            }
        }
    }
}
// check for custom allergens
$sql  = " SELECT *  FROM custom_allergens  WHERE patientID = {$patientID}";
CustomAllergens::set_custom_allergens_table();
$custom_allergens_list = CustomAllergens::find_by_sql($sql);

if (isset($custom_allergens_list)) {
    if ($treatment == 2)
        $dilution = isset($analysis_list)? $analysis_list[0]->dilutionLevel: 0;
    else {
        $dilution = 0;
    }
    foreach ($custom_allergens_list as $key ) {
        $a = array( "id"        => $key->allergenID,
                    "mspscore"  => $key->MSPScore,
                    "itscore"   => $key->ISPScore,
                    "twowhl"    => $key->twoWhl,
                    "expdate"   => $key->expDate,
                    "name"      => $key->antigenName,
                    "lotnumber" => $key->lotNumber,
                    "group"     => $key->groupID,
                    "battery"   => $key->batteryName,
                    "dilutionLevel" => $dilution );
        if (($a["mspscore"] >= 7 || $a["itscore"] >= 7 || $a["twowhl"] >= 9) && ($a["group"] != 0)) {
            if ($treatment != 2) {
                array_push($allergic, $a);
            } else {
                if ($a["group"] == 5) {
                    array_push($allergicAnimals, $a);
                }else {
                    array_push($allergicPollens, $a);
                }
            }
        }
    }
}
function getArray( $analysis, $allergic_list ){
    return (array(  "id"            => $analysis->allergenID,
                    "mspscore"      => $analysis->MSPScore,
                    "itscore"       => $analysis->ITScore,
                    "twowhl"        => $analysis->twoWhl,
                    "lotnumber"     => $allergic_list[0]->lotNumber,
                    "expdate"       => $allergic_list[0]->expDate,
                    "name"          => $allergic_list[0]->antigenName,
                    "group"         => $allergic_list[0]->groupID,
                    "battery"       => $allergic_list[0]->batteryName,
                    "dilutionLevel" => $analysis->dilutionLevel));
};
inlcudeLayoutTemplet("admin_header.php");
        if ($treatment == 2){
            echo "<h2 class=\"title\"> IMMUNOTHERAPY VIAL PREPARATION  </h2>";
            echo "<h2 class=\"title\"> INJECTION </h2>";
            echo "</br>";
        }else{
            echo "<h2 class=\"title\"> IMMUNOTHERAPY VIAL PREPARATION  </h2>";
            echo "<h2 class=\"title\"> SUBLINGUAL </h2>";
            echo "</br>";
        }
        $dt = date("dmY") ;
        $expDate =  date('l jS F Y (Y-m-d)', strtotime('120 days'));
        $f = substr($firstname, 0, 1);
        $l = substr($lastname, 0, 1);
        $lotNumber =  "#".$f.$l.$dt;
         echo "<table class=\"entrynoborder\"       width=800>
                <tr>
                    <th  style=\"text-align:center\">Patient Information</th>
                    <th>  </th>
                </tr>
                <tr border =0 ><td border=0px  width=200>Patient Name:</td>		<td border=0 ><b>$firstname $lastname</b> </td></tr>
                <tr><td border=0 width=200>DOB:</td>					<td border=0><b>$dateofbirth</b></td></tr>
                <tr><td border=0 width=200>Gender:</td>				<td border=0><b>$sex</b></td></tr>
                <tr><td border=0 width=200>Home ZIP Code:</td>		<td><b>$homezip</b></td></tr>
                <tr><td border=0 width=200>Work ZIP Code:</td>		<td border=0><b>$workzip</b></td></tr>
                <tr><td border=0 width=200>Tester:</td>		<td border=0><b>$tester</b></td></tr>
                <tr><td border=0 width=200>Email:</td>		<td border=0><b>$email</b></td></tr>
                <tr><td border=0 width=200>Lot Number:</td>          <td border=0><b>$lotNumber</b></td></tr>
		</table>";
        ?>
        </br>
        </br>
    <form id ="frm_report"   method ="post">
    
    <table class="entry" width=800px>

    <?php
        echo "<p id=\"page2\">";
        if(!empty($allergic)) {
            echo  "<input type=\"button\" id=\"print_labels\"   name =\"print_labels\" value =\"Print Labels\"   onclick=\"openLabel()\" />";
        }else {
            echo  "<input type=\"button\" id=\"print_labels\"   name =\"print_labels\" value =\"Print Labels\"  disabled=\"disabled\"  />";
        }
        /* echo  "<input type=\"submit\" id=\"email_report\"   name =\"email_report\" value =\"Email Report\"  onclick=\"emailReport()\"     />"; */
        echo  "<input type=\"submit\" id=\"print_report\"   name =\"print_report\" value =\"Print Report\"   onclick=\"printpage()\"   />";

        echo  "<input type=\"hidden\" id=\"treatment\"     name=\"treatment\" value=\"{$treatment}\" >";
        echo  "<input type=\"hidden\" id=\"patientID\"      name=\"patientID\" value=\"{$patientID}\" >";
        echo  "<input type=\"hidden\" id=\"analysisCount\"  name=\"analysisCount\" value=\"{$analysisCount}\" >";
       // echo  "<input type=\"hidden\" id=\"allergic\"  name=\"allergic\" value=\"{$allergic}\" >";
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "<a   href=\"create_patient_report.php?id={$patientID}&aCnt={$analysisCount}\"  class=\"linkButton\">click here for Patient Report </a>";

        echo "</p>";
     if ($treatment != 2){ 
            echo "<tr>";
            echo "<th>Antigen</th>";
            echo "<th>Pure Antigen </th>";
            echo "<th>Quantity (cc)</th>";
            echo "<th>Lot Number </th>";
            echo "<th>Exp. Date</th>";
            echo "</tr>";
            $alternate=1;
            if (!empty($allergic)){
                for ($i=0; $i <= sizeof($allergic)-1;$i++) {
                    if ($alternate==0) { 
                        echo " <tr bgcolor = \"#D2D2D2\"     > ";
                        $alternate=1;
                    }
                    else { 
                        echo " <tr bgcolor = \"#FFFFFF\"     > ";
                        $alternate = 0;
                    }
                    $ingredients = $ingredients .  $allergic[$i]['name'].",";
                    echo "<td>";
                    echo "  ".$allergic[$i]['name'];
                    echo "</td>";
                    echo "<td> Pure ";
                    echo "</td>";
                    echo "<td>";
                    echo "  ".$quantity;
                    echo "<td>";
                    echo "  ".$allergic[$i]['lotnumber'];
                    echo "</td>";
                    echo "<td>";
                    echo "  ".$allergic[$i]['expdate'];
                    echo "</td>";
                    echo "</tr>";
                }
                    echo "<tr>";
                    echo "<td>";
                    echo "  " ;
                    echo "</td>";
                    echo "</tr>";
                if ($alternate ==0){
                    echo "<tr bgcolor = \"#FFFFFF\">";
                    $alternate = 1;
                }else{
                    echo "<tr bgcolor = \"#D2D2D2\">";
                    $alternate = 0;
                }
                echo "<td>";
                echo "Total Antigen = " ;
                echo "</td>";
                echo "<td>";
                echo "" ;
                echo "</td>";
                $totalAntigen = $quantity * sizeOf($allergic);
                echo "<td>";
                echo "  ".$totalAntigen;
                echo "</td>";
                echo "<td>";
                echo "" ;
                echo "</td>";
                echo "<td>";
                echo "" ;
                echo "</td>";
                echo "</tr>";
                if ($alternate ==0){
                    echo "<tr bgcolor = \"#FFFFFF\">";
                    $alternate = 1;
    
                }else{
                    echo "<tr bgcolor = \"#D2D2D2\">";
                    $alternate = 0;
                }
                echo "<td>";
                echo "Glycerine 50% = " ;
                echo "</td>";
                echo "<td>";
                echo "" ;
                echo "</td>";
                $glycerin = $totalSolution - $totalAntigen;
                $ingredients = $ingredients . "Glycerine";
                echo "<td>";
                echo "  ".$glycerin;
                echo "</td>";
                echo "<td>";
                echo "" ;
                echo "</td>";
                echo "<td>";
                echo "" ;
                echo "</td>";
                echo "</tr>";
                if ($alternate ==0){
                    echo "<tr bgcolor = \"#FFFFFF\">";
                    $alternate = 1;
    
                }else{
                    echo "<tr bgcolor = \"#D2D2D2\">";
                    $alternate = 0;
                }
                echo "<td>";
                echo "Total Solution = " ;
                echo "</td>";
                echo "<td>";
                echo "" ;
                echo "</td>";
                echo "<td>";
                echo "  ".$totalSolution;
                echo "</td>";
                echo "<td>";
                echo "" ;
                echo "</td>";
                echo "<td>";
                echo "" ;
                echo "</td>";
                echo "</tr>";
            }
            
    }else{
        if (!empty($allergic)){
                
                $alternate=1;
                if (!empty($allergicAnimals)){
                    $vials += 1; 
                    echo "<h2 class=\"title\"> VIAL A <h2>";
                    echo "<th>Antigen</th>";
                    echo "<th>Dilution</th>";
                    echo "<th>Quantity (cc)</th>";
                    echo "<th>Lot Number </th>";
                    echo "<th>Exp. Date</th>";
                    echo "</tr>";
                    for ($i=0; $i <= sizeof($allergicAnimals)-1;$i++) {
                         if ($alternate==0) {
                            echo " <tr bgcolor = \"#D2D2D2\"     > ";
                            $alternate=1;
                        }
                        else { 
                            echo " <tr bgcolor = \"#FFFFFF\"     > ";
                            $alternate = 0;
                        }
                        echo "<td>";
                        echo "  ".$allergicAnimals[$i]["name"];
                        echo "</td>";
                        if ($allergicAnimals[$i]['mspscore']>= 9 || $allergicAnimals[$i]['itscore']>= 7 || $allergicAnimals[$i]['twowhl']>= 9){
                            $dilution = 4 - $allergicAnimals[$i]['dilutionLevel'];
                        }else{
                            if ($allergicAnimals[$i]['dilutionLevel'] >= 1 ){
                                $dilution = 1;
                            }else{
                                $dilution = 2;
                            }
                        }
                        $vialA = $vialA . $allergicAnimals[$i]['name'].",";

                        echo "<td>";
                        echo "  ".$dilution;
                        echo "</td>";
                        echo "<td>";
                        echo "  ".$quantity;
                        echo "</td>";
                        echo "<td>";
                        echo "  ".$allergicAnimals[$i]['lotnumber'];;
                        echo "</td>";
                        echo "<td>";
                        echo "  ".$allergicAnimals[$i]['expdate'];
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "<tr>";
                    echo "<td>";
                    echo "  " ;
                    echo "</td>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    echo "<td>";
                    echo "Total Antigen = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    $totalAntigen = $quantity * sizeOf($allergicAnimals);
                    echo "<td>";
                    echo "  ".$totalAntigen;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
        
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    echo "<td>";
                    echo "Glycerine 50% = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    $glycerin = 1;
                     $vialA = $vialA . "Glycerine, "   ;

                    echo "<td>";
                    echo "  ".$glycerin;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    echo "<td>";
                    echo "Phenol = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    $phenol = 5 - ($glycerin + $totalAntigen);
                     $vialA = $vialA . "Phenol";
                    echo "<td>";
                    echo "  ".$phenol;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                    echo "</tr>";
                                if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    echo "<td>";
                    echo "Total Volume = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "  ".$totalVolume;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                }
                if (!empty($allergicPollens)){
                        $vials += 1; 
                         if ($allergicAnimals!=null){
                            echo "</table>";
                            echo "<table class=\"entry\" width=800px>";
                            echo "<h2 class=\"title\"> VIAL B <h2>";
                        }else{
                            echo "<table class=\"entry\" width=800px>";
                            echo "<h2 class=\"title\"> VIAL A <h2>";
                        }
                        echo "<th>Antigen</th>";
                        echo "<th>Dilution</th>";
                        echo "<th>Quantity (cc)</th>";
                        echo "<th>Lot Number </th>";
                        echo "<th>Exp. Date</th>";
                    for ($i=0; $i <= sizeof($allergicPollens)-1;$i++) {
                           if ($alternate==0) { 
                               echo " <tr bgcolor = \"#D2D2D2\"     > ";
                               $alternate=1;
                           }
                           else { 
                               echo " <tr bgcolor = \"#FFFFFF\"     > ";
                               $alternate = 0;
                           }
                           echo "<td>";
                           echo "  ".$allergicPollens[$i]["name"];
                           echo "</td>";
                            if ($allergicPollens[$i]['mspscore']>= 9 || $allergicPollens[$i]['itscore']>= 7 || $allergicPollens[$i]['twowhl']>= 9){
                               $dilution = 4 - $allergicPollens[$i]['dilutionLevel'];
                            }else{
                                if ($allergicPollens[$i]['dilutionLevel'] >= 1 ){
                                    $dilution = 1;
                                }else{
                                    $dilution = 2;
                                }
                            }
                            $vialB = $vialB . $allergicPollens[$i]['name'].",";


                            echo "<td>";
                            echo "  ".$dilution;
                            echo "</td>";
                            echo "<td>";
                            echo "  ".$quantity;
                            echo "</td>";
                            echo "<td>";
                            echo "  ".$allergicPollens[$i]['lotnumber'];
                            echo "</td>";
                            echo "<td>";
                            echo "  ".$allergicPollens[$i]['expdate'];
                            echo "</td>";
                            echo "</tr>";
                       }
                           echo "<tr>";
                           echo "<td>";
                           echo "  " ;
                           echo "</td>";
                           echo "</tr>";
                       if ($alternate ==0){
                           echo "<tr bgcolor = \"#FFFFFF\">";
                           $alternate = 1;
                       }else{
                           echo "<tr bgcolor = \"#D2D2D2\">";
                           $alternate = 0;
                       }
                       echo "<td>";
                       echo "Total Antigen = " ;
                       echo "</td>";
                       echo "<td>";
                       echo "" ;
                       echo "</td>";
                       $totalAntigen = $quantity * sizeOf($allergicPollens);
                       echo "<td>";
                       echo "  ".$totalAntigen;
                       echo "</td>";
                       echo "<td>";
                       echo " " ;
                       echo "</td>";
                        echo "<td>";
                       echo " " ;
                       echo "</td>";
                       echo "</tr>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
        
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    echo "<td>";
                    echo "Glycerine 50% = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    $glycerin = 1;
                    echo "<td>";
                    echo "  ".$glycerin;
                    $vialB = $vialB . "Glycerine,";

                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                     
                    echo "<td>";
                    echo "Phenol = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    $phenol = 5 - ($glycerin + $totalAntigen);
                    $vialB = $vialB . "Phenol" ;
                    echo "<td>";
                    echo "  ".$phenol;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    echo "<td>";
                    echo "Total Volume = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "  ".$totalVolume;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                }
             if (!empty($allergicCockroch)){
                    $vials += 1; 
                    echo "</table>";
                    echo "<table class=\"entry\" width=800px>";
                    if ($vials == 3){
                        echo "<h2 class=\"title\"> VIAL C <h2>";
                    }else if ($vials == 2){
                        echo "<h2 class=\"title\"> VIAL B <h2>";
                    }else{
                        echo "<h2 class=\"title\"> VIAL A <h2>";
                    }
                    echo "<th>Antigen</th>";
                    echo "<th>Dilution</th>";
                    echo "<th>Quantity (cc)</th>";
                    echo "<th>Lot Number </th>";
                    echo "<th>Exp. Date</th>";
                    if ($alternate==0) { 
                        echo " <tr bgcolor = \"#D2D2D2\"     > ";
                        $alternate=1;
                    }
                    else { 
                        echo " <tr bgcolor = \"#FFFFFF\"     > ";
                        $alternate = 0;
                    }
                    ;
                    echo "<td>";
                    echo "  ".$allergicCockroch[0]["name"];
                    echo "</td>";
                    if ($allergicCockroch[0]['mspscore']>= 9 || $allergicCockroch[0]['itscore']>= 7 || $allergicCockroch[0]['twowhl']>= 9){
                        $dilution = 4 - $allergicCockroch[0]['dilutionLevel'];
                    }else{
                         if ($allergicCockroch[0]['dilutionLevel'] >= 1 ){
                             $dilution = 1;
                        }else{
                             $dilution = 2;
                        }
                    }
                    $vialC = $vialC . $allergicCockroch[0]['name']. ",";

                    echo "<td>";
                    echo "  ".$dilution;
                    echo "</td>";
                    echo "<td>";
                    echo "  ".$quantity;
                    echo "</td>";
                    echo "<td>";
                    echo "  ".$allergicCockroch[0]['lotnumber'];
                    echo "</td>";
                    echo "<td>";
                    echo "  ".$allergicCockroch[0]['expdate'];
                    echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>";
                    echo "  " ;
                    echo "</td>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    echo "<td>";
                    echo "Total Antigen = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    $totalAntigen = $quantity ;
                    echo "<td>";
                    echo "  ".$totalAntigen;
                    echo "</td>";
                    echo "<td>";
                    echo " " ;
                    echo "</td>";
                    echo "<td>";
                    echo " " ;
                    echo "</td>";
                    echo "</tr>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
        
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    echo "<td>";
                    echo "Glycerine 50% = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    $glycerin = 1;
                    echo "<td>";
                    echo "  ".$glycerin;
                    $vialC = $vialC . "Glycerine,";

                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                     
                    echo "<td>";
                    echo "Phenol = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    $phenol = 5 - ($glycerin + $totalAntigen);
                    echo "<td>";
                    echo "  ".$phenol;
                    $vialC = $vialC . "Phenol";
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                    echo "</tr>";
                    if ($alternate ==0){
                        echo "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        echo "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    echo "<td>";
                    echo "Total Volume = " ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "  ".$totalVolume;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "<td>";
                    echo "" ;
                    echo "</td>";
                    echo "</tr>";
                }
                }else{
                    echo "</br>";
                    echo "</br>";
                    echo "<table class=\"entrynoborder\"  width=800  >";
                    echo "<tr>";
                    echo "<td padding='5px' style-color='#000000'>";
                    echo "<p class=\"outset\"  >";
                    echo  "Nothing to report. No allergies.";
                    echo "</p>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
            }
        }
        ?>
        </table>
        <?php
           /* $doc = new DOMDocument('1.0','UTF-8');
            $doc->formatOutput = true;
            $root = $doc->createElement('root');
            $root = $doc->appendChild($root);
            $labels = $doc->createElement('labels');
            $root = $root->appendChild($labels);
            $name = $doc->createElement('name',$firstname.' '.$lastname);
            $dob = $doc->createElement('dob',$dateofbirth);
            $treat = $doc->createElement('treatment',$treatment);
            $lot = $doc->createElement('lot',$lotNumber);
            $expD =  date('m-d-Y', strtotime('120 days'));
            $exp = $doc->createElement('exp',$expD);
            $ingrd = $doc->createElement('ingredients',$ingredients);
            $vA = $doc->createElement('vialA',$vialA);
            $vB = $doc->createElement('vialB',$vialB);
            $vC = $doc->createElement('vialC',$vialC);
             */
            switch ($analysis->dilutionLevel){
                case 0:
                    $dilutionLevel = '1st Dilution';

                    //$dil = $doc->createElement('dilutionLevel','1st Dilution');
                    break;
                case 1:
                    $dilutionLevel = '2nd Dilution';

                    //$dil = $doc->createElement('dilutionLevel','2nd Dilution');
                    break;
                case 2:
                       $dilutionLevel = '3rd Dilution';

                    //$dil = $doc->createElement('dilutionLevel','3rd Dilution');
                    break;
                case 3:
                    $dilutionLevel = '4th Dilution';

                    //$dil = $doc->createElement('dilutionLevel','4th Dilution');
                    break;
                default:
                    $dilutionLevel = '1st Dilution';

                   // $dil = $doc->createElement('dilutionLevel','1st Dilution');
                    break;
            } 

            Analysis::set_analysis_table();
            $ref = Analysis::get_refill($patientID,$analysisCount);
            if ($ref == null){
                $ref = 0;
            }
            /*$refill = $doc->createElement('refill',$ref);
            $labels->appendChild($name);
            $labels->appendChild($dob);
            $labels->appendChild($treat);
            $labels->appendChild($lot);
            $labels->appendChild($exp);
            $labels->appendChild($refill);
            $v = $doc->createElement('numVials',$vials);
            $labels->appendChild($v);
            $labels->appendChild($ingrd);

            $labels->appendChild($vA);
            $labels->appendChild($vB);
            $labels->appendChild($vC);
            $labels->appendChild($dil);
            $doc->save("../xml/label.xml") ;*/
            $name = $firstname.' '.$lastname;
            $expD =  date('m-d-Y', strtotime('120 days'));

            $labelArr = [
                    "name"        => $name,
                    "dob"         => $dateofbirth,
                    "treatment"   => $treatment,
                    "lotNum"      => $lotNumber,
                    "exp"         => $expD,
                    "refill"      => $ref,
                    "ingredients" => $ingredients,
                    "vialA"       => $vialA,
                    "vialB"       => $vialB,
                    "vialC"       => $vialC,
                    "dilutionLevel" => $dilutionLevel ];
            
            file_put_contents('../html/label.json', json_encode($labelArr), LOCK_EX);

            if ($treatment == 1 || $treatment == 0  ){
                if (!empty($allergic)){
                    echo "</br>";
                    echo "</br>";
                    echo "<table class=\"entrynoborder\"  width=800  >";
                    echo "<tr>";
                    echo "<td padding='5px' style-color='#000000'>";
                    echo "<p class=\"outset\"  >";
                    if ($ref == 0){
                        echo  "1 cc of solution was pulled out of a glass vial containing the antigens listed above and ";
                        echo  "added to 4 cc' of 50% Glycerine then placed into the red dropper vial and mixed, 1 cc was ";
                        echo  "then pulled from the red dropper vial and added to 4 cc' of 50% Glycerine into a green ";
                        echo  "dropper vial then mixed. 1 cc was then pulled from the green dropper vial and added to 4 ";
                        echo  "cc' of 50% Glycerine into yellow dropper vial, and mixed, then labeled with patient's ";
                        echo  "name experation date {$expDate} and Lot Number {$lotNumber}. The dropper's were given to the ";
                        echo  "patient as a three month supply.";
                    }else{
                        echo  "1 cc of solution was pulled out of a glass vial containing the antigens listed above and added ";
                        echo  "to 4 cc' of 50% Glycerine then placed into each of three dropper vials, and mixed, then labeled with ";
                        echo  "patient's name and expiration date {$expDate} and Lot Number {$lotNumber}. The dropper's were given ";
                        echo  " to the patient as a three month supply.";
                    }
                    echo "</p>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                }else{
                    echo "</br>";
                    echo "</br>";
                    echo "<table class=\"entrynoborder\"  width=800  >";
                    echo "<tr>";
                    echo "<td padding='5px' style-color='#000000'>";
                    echo "<p class=\"outset\"  >";
                    echo  "Nothing to report. No allergies.";
                    echo "</p>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                }

            }
        ?>
    </form>
    </div>

    <?php 

    inlcudeLayoutTemplet('footer.php');?>

    