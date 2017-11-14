<?php
require_once("../../includes/initialize.php");
if (!$session->is_logged_in()){
    redirectTo("login.php");
}
include_once("../../includes/form_functions.php");

// Create the controller, it is reusable and can render multiple templates
$dwoo = new Dwoo\Core();

$firstname ="";
$lastname = "";
$dateofbirth ="";
$chartnumber = "";
$homezip ="";
$workzip = "";
$sex = "";
$email = "";
$tester = "";
$mspscore = 5;
$itscore = 5;
$analysisCount = 0;

if (isset($_POST['submit'])) {
    if (isset($_POST['deleteAllergen'])) {
        $result=array_keys($_POST['deleteAllergen']);
        $result = implode(",", $result);
    }

    Allergen::set_allergen_table();
    $total_count = Allergen::count_all();
    $sql  = " SELECT allergenID FROM allergens1";

    if (isset($result)){
        $sql .= " WHERE allergenID NOT IN (".$result.") AND disabled != 1";
    } else {
        $sql .= " WHERE disabled != 1 ";
    }
    $sql .= " ORDER BY batteryName  ASC, site  ASC ";
    $allergen_list = Allergen::find_by_sql($sql);
    $allergen_allergenIDs = array();

    foreach ($allergen_list as $key ){
        $arr1 = array('allergenID' => $key -> allergenID  );
        array_push ($allergen_allergenIDs, $arr1);
    }
    $analysisCount = $_POST['analysisCount'] + 1;
    $analysis = new Analysis();
    $analysis::set_analysis_table();

    date_default_timezone_set('America/Los_Angeles');
    $dt = time();
    $mysql_datetime = strftime("%Y-%m-%d %H:%M:%S",$dt);
    $type = (isset($_POST["treatmenttype"]))? $_POST["treatmenttype"] : 0;

    if($type == "drops"){
        $treatment = 1;
    }elseif ($type == "injection"){
        $treatment = 2;
    }else{
        $treatment = 0;
    }

    foreach($allergen_allergenIDs as  $key=>$value ) {
        $analysis->allergenID       = $allergen_allergenIDs[$key]['allergenID'];
        $analysis->analysisCount    = $analysisCount;
        $analysis->patientID        = $_POST['patientID'];
        $analysis->MSPScore         = $_POST['Wheelmsp'.$allergen_allergenIDs[$key]['allergenID']];
        $analysis->ITScore          = $_POST['Wheelisp'.$allergen_allergenIDs[$key]['allergenID']];
        $analysis->dateAdded        = $mysql_datetime;
        $analysis->treatment        = $treatment;
        $analysis->dilutionLevel    = 0;
        $analysis->twoWhl           = 0;
        $analysis->refill           = 0;
        $analysis->validated = isChecked('confirm', $allergen_allergenIDs[$key]['allergenID']) ? 1 : 0;
        if (!$analysis->create()) {
            $session->message("ERROR: Could not create Analysis record.");
            redirectTo('list_patient.php');
        }
    }

    $session->message("Analysis added successfully.");
    redirectTo("update_entry_record.php?id={$analysis->patientID}&aCnt={$analysis->analysisCount}&treat={$treatment}&dilution=0");
} elseif (!empty($_GET)) {
    $treatment      = !empty($_GET['treat'])? (int) $_GET ['treat'] : 0;
    $patientId      = !empty($_GET['id'])? (int) $_GET ['id'] : 0;
    $analysisCount  = !empty($_GET['aCnt'])? (int) $_GET ['aCnt'] : 0;
    $mspscore       = !empty($_GET['msp'])? (int) $_GET ['msp'] : 5;
    $itscore        = !empty($_GET['its'])? (int) $_GET ['its'] : 5;

    Patient::set_patient_table();
    $sql            = " SELECT *  FROM patient WHERE patientID = {$patientId} LIMIT 1";
    $patient        = Patient::find_by_sql($sql);
    $patientID      = $patient[0]->patientID ;
    $lastname       = $patient[0]->patientLast ;
    $firstname      = $patient[0]->patientFirst ;
    $lastname       = $patient[0]->patientLast ;
    $chartnumber    = $patient[0]->chartNum ;
    $dateofbirth    = $patient[0]->dateOfBirth;
    $sex            = $patient[0]->sex;
    $homezip        = $patient[0]->zipCodeHome;
    $workzip        = $patient[0]->zipCodeWork;
    $tester         = $patient[0]->tester;
    $email          = $patient[0]->email;
    Allergen::set_allergen_table();
    $total_count = Allergen::count_all();
    $sql  = " SELECT antigenName, allergenID  FROM allergens1  ";
    $sql .= " WHERE disabled = 0";
    $sql .= " ORDER BY batteryName  ASC, site  ASC  ";
    $allergen_list = Allergen::find_by_sql($sql);
    $allergen_list_array = array();
    foreach ($allergen_list as $key ){
        $arr1 = array('antigenName' => $key -> antigenName, 'allergenID' => $key -> allergenID  );
        array_push ($allergen_list_array, $arr1);
    }
    // check if the patient has any custom allergens
    CustomAllergens::set_custom_allergens_table();
    $sql  = " SELECT antigenName, allergenID, patientID, MSPScore, ISPScore, twoWhl FROM custom_allergens  ";
    $sql .= " ORDER BY groupID ASC  ";
    $custom_allergen_list = CustomAllergens::find_by_sql($sql);
    $custom_allergen_list_array = array();
    $custom_allergen_list_total_array = array();
    foreach ($custom_allergen_list as $key ){
        $arr1 = array('antigenName' => $key->antigenName,
            'allergenID' => $key->allergenID,
            'patientID' => $key->patientID,
            'mspscore' => $key->MSPScore,
            'ispscore' => $key->ISPScore,
            'twoWhl' => $key->twoWhl);
        if ($key -> patientID == $patientID) {
            array_push($custom_allergen_list_array, $arr1);
        }else {
            array_push($custom_allergen_list_total_array, $arr1);
        }
    }
    
    
 } else {
    $session->message("Nothing to display.");
    redirectTo('list_patient.php');
}


function isChecked($chkname,$value) {
    if(!empty($_POST[$chkname])) {
        foreach($_POST[$chkname] as $chkval) {
            if($chkval == $value) {
                return true;
            }
        }
    }
    return false;
}

if (!empty($message) ){
    echo "<p class=\"message\">". $message . "</p>";
}

if (!empty($errors) ) {
    displayErrors($errors);
}

$params = array();
$patientInfo = array( 'firstname'=>$firstname,
                      'lastname'=>$lastname,
                      'dateofbirth'=>$dateofbirth,
                      'chartnumber'=>$chartnumber,
                      'homezip'=>$homezip,
                      'workzip'=>$workzip,
                      'tester'=>$tester,
                      'sex'=>$sex );
$pageInfo = array( 'treatment'=>$treatment,
                   'patientId'=>$patientId,
                   'analysisCount'=>$analysisCount,
                   'mspscore'=>$mspscore,
                   'itscore'=>$itscore);

$params['allergen_list']                = $allergen_list_array;
$params['pageInfo']                     = $pageInfo;
$params['custom_allergen_list']         = $custom_allergen_list_array;
$params['custom_allergen_list_total']   = $custom_allergen_list_total_array;
// Configure directories
$dwoo->setCompileDir('../../templates/');
$dwoo->setTemplateDir('../../templates/');


inlcudeLayoutTemplet('admin_header.php');
echo $dwoo->get('patientInfo.tpl', $patientInfo);
echo $dwoo->get('analysys.tpl', $params);
inlcudeLayoutTemplet('footer.php');
?>
