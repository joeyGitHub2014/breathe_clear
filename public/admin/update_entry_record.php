<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
      redirectTo("login.php");
    }
    include_once("../../includes/form_functions.php");
    $dwoo = new Dwoo\Core();
    $treatment = 0;
    $dilution = 0;
    $dilutionStrength = 0;
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
    $alternate = 0;
    $analysisCount = 0;
    $refillChecked = '';

    $treatment              = !empty($_GET['treat'])? (int) $_GET['treat'] : 0;
    $patientId              = !empty($_GET['id'])? (int) $_GET['id'] : 0;
    $analysisCount          = !empty($_GET['aCnt'])? (int) $_GET['aCnt'] : 0;
    $dilution               = !empty($_GET['dilution'])? (int) $_GET['dilution'] : 0;
    $customAllergenCount    = !empty($_GET['caCnt'])? (int) $_GET['caCnt'] : null;

    Patient::set_patient_table();
    $sql   = " SELECT *  FROM patient WHERE patientID = {$patientId} LIMIT 1";
    $patient = Patient::find_by_sql($sql);
    $patientID =  $patient[0]->patientID ;
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
    $allergen_list = array();
    $custom_allergen_list = array();

    Allergen::set_allergen_table();
    $sql  = " SELECT allergenID, antigenName  FROM allergens1 ";
    $sql .= " WHERE disabled = 0 ";
    $sql .= " ORDER BY batteryName  ASC, site  ASC ";
    $allergen_list = Allergen::find_by_sql($sql);
    $c = count($allergen_list);
    for ($i=0; $i < $c; $i++ ) {
        $allergenList[$allergen_list[$i]->allergenID ] = $allergen_list[$i]->antigenName;
    }

    Analysis::set_analysis_table();
    $sql  = " SELECT *  FROM analysis  WHERE patientID = {$patientId} AND analysisCount = {$analysisCount}";
    $sql  .= " ORDER BY analysisID ASC";

    $analysisList = Analysis::find_by_sql($sql);
    $refill = Analysis::get_refill($patientId,$analysisCount);

    $patientInfo = array('firstname'=>$firstname, 'lastname'=>$lastname, 'dateofbirth'=>$dateofbirth, 'chartnumber'=>$chartnumber,
                         'homezip'=>$homezip,    'workzip'=>$workzip, 'tester'=>$tester, 'sex'=>$sex );
    // check if the patient has any custom allergens
    CustomAllergens::set_custom_allergens_table();
    $sql  = " SELECT antigenName, allergenID, patientID, ISPScore, MSPScore, twoWhl FROM custom_allergens  ";
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
    // disable printing button when no treatment type is selected
    ($treatment == 0)? $printReport = 'disabled' : $printReport = '';
    // check this is a refill
    ($refill == 1)? $refillChecked = 'checked' : $refillChecked = '';
    $entryRecordInfo = array('patientId' => $patientId, 'treatment' => $treatment, 'dilutionStrength' => $dilutionStrength, 'firstname' => $firstname,
                             'lastname' => $lastname, 'dateofbirth' => $dateofbirth, 'chartnumber' => $chartnumber, 'homezip' => $homezip,
                             'workzip' => $workzip, 'sex' => $sex, 'email' => $email, 'tester' => $tester, 'mspscore' => $mspscore, 'itscore' => $itscore,
                             'refillChecked' => $refillChecked, 'printReport' => $printReport, 'analysisCount' => $analysisCount);
    // treatment types array NYD =>0, Drops=>1, Injection=>2
    $treatmentArray = array('','','');
    $treatmentArray[$treatment] = 'checked';
    // injection level array 0 => 4th Dilution, 1=>3rd Dilution, 2=>2nd Dilution, 3 => 1st Dilution     
    $injectionLevelArray = array('','','','');
    $dilution = Analysis::get_dilutionLevel($patientId,$analysisCount);
    $injectionLevelArray[$dilution] = 'checked';

    $params['analysisList']     = $analysisList;
    $params['allergenList']     = $allergenList;
    $params['patientInfo']      = $patientInfo;
    $params['pageInfo']         = array('patientId' => $patientId, 'analysisCount' => $analysisCount, 'treatment' => $treatment);
    $params['entryRecordInfo']  = $entryRecordInfo;
    $params['treatment']        = $treatmentArray;
    $params['injectionLevel']   = $injectionLevelArray;
    $params['custom_allergen_list']   = $custom_allergen_list_array;
    $params['custom_allergen_list_total']   = $custom_allergen_list_total_array;

    inlcudeLayoutTemplet('admin_header.php');

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
    }
    if (!empty($message) ){echo "<p class=\"message\">". $message . "</p>";}
    if (!empty($errors) ){displayErrors($errors);}
    echo $dwoo->get('../../templates/patientInfo.tpl', $patientInfo);
    echo $dwoo->get('../../templates/treatments.tpl', $params);
    echo $dwoo->get('../../templates/customAllergen.tpl', $params);
    echo $dwoo->get('../../templates/entryRecords.tpl', $params);
    inlcudeLayoutTemplet('footer.php');
?>

<script type="text/javascript">
$(document).ready(function () {
     addRecords();
});
//--------------
// update_refill
//--------------
function  update_refill() {
    var patientId = "<?php echo urlencode($patientId) ?>";
    var anaCnt = "<?php echo urlencode($analysisCount) ?>";
    // this method is defined in the other Javascript file called 'ajax.js'
    var ajax = new getXMLHttpRequestObject();
    if (ajax) {
        var treat = 1;
        var refill;
        if (document.getElementById("check1").checked == true) {
            refill = 1;
        }else {
            refill = 0;
        }
        var url="update_dilutionLevel.php?dilution="+refill+"&patientId="+patientId+"&anaCnt="+anaCnt+"&treat="+treat;

        ajax.open("get", url, true);
        // register another annonymous handler function for the 'onreadystatechange' event of the ajax object
        ajax.onreadystatechange = function() {
            // this annonymous handler delegates the heavy task to my own function, passed to which is the 'ajax' object
            myHandleResponseFunction(ajax,"refill",null,null);
        }
        //used when open Ajax with the GET method
        ajax.send(null);
        return false;
    }
}
//--------------------
// updateDilutionLevel
//--------------------
function updateDilutionLevel(dilution){
    var patientId = "<?php echo urlencode($patientId) ?>";
    var anaCnt = "<?php echo urlencode($analysisCount) ?>";

    var ajax = new getXMLHttpRequestObject();
    if (ajax) {
        var url="update_dilutionLevel.php?dilution="+dilution+"&patientId="+patientId+"&anaCnt="+anaCnt+"&treat="+2;
        ajax.open("get", url, true);
        ajax.onreadystatechange = function() {
            myHandleResponseFunction(ajax,"refill",null,null);
        }
        ajax.send(null);
        return false;
    }

}
//-------------------------------------
// setButtonStatus
//-------------------------------------
function setButtonStatus(text)
{
    var jsVar1 = "<?php echo urlencode($patientId) ?>";
    var jsVar2 = "<?php echo urlencode($analysisCount) ?>";
    var treat;
    console.log(text);
    if ( text == "nyd" ) {
        document.forms["frm_treatment"].action ="update_entry_record.php?treat=0&id=" + jsVar1 + "&aCnt=" + jsVar2;
        document.getElementById("submit_report").disabled = true;
        treat = 0;
    }
    else{
        if (text == "drops") {
            document.forms["frm_treatment"].action ="update_entry_record.php?treat=1&id=" + jsVar1 + "&aCnt=" + jsVar2;
            treat =  1;
        }else {
            document.forms["frm_treatment"].action = "update_entry_record.php?treat=2&id=" + jsVar1 + "&aCnt=" + jsVar2;
            treat =  2;
        }
        document.getElementById("submit_report").disabled = false;
    }
    updateTreatment(treat,jsVar1,jsVar2,"treatment");
}
//-----------------
// updateTreatment
//-----------------
function updateTreatment(treat, patientId, anaCnt,name){
    var ajax = new getXMLHttpRequestObject();
    if (ajax) {
        var url="update_treatment.php?treat="+treat+"&patientId="+patientId+"&anaCnt="+anaCnt;
        ajax.open("get", url, true);
        ajax.onreadystatechange = function() {
            myHandleResponseFunction(ajax,name,null,null);
        }
        ajax.send(null);
        return false;
    }
}

</script>

    