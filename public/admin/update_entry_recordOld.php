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

    $treatment = !empty($_GET['treat'])? (int) $_GET['treat'] : 0;
    $patientId = !empty($_GET['id'])? (int) $_GET['id'] : 0;
    $analysisCount =    !empty($_GET['aCnt'])? (int) $_GET['aCnt'] : 0;
    $dilution =    !empty($_GET['dilution'])? (int) $_GET['dilution'] : 0;
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
    Allergen::set_allergen_table();
    $sql  = " SELECT allergenID, antigenName  FROM allergens1 ";
    $sql .= " ORDER BY batteryName  ASC, site  ASC  ";
    $allergen_list = Allergen::find_by_sql($sql);
    $c = count($allergen_list);
    for ($i=0; $i < $c; $i++ ){
        $allergenList[$allergen_list[$i]->allergenID ] = $allergen_list[$i]->antigenName;
    }

    Analysis::set_analysis_table();
    $sql  = " SELECT *  FROM analysis  WHERE patientID = {$patientId} AND analysisCount = {$analysisCount}";
    $analysisList = Analysis::find_by_sql($sql);

    $refill = Analysis::get_refill($patientId,$analysisCount);

    inlcudeLayoutTemplet('admin_header.php');

    if (!empty($message) ){echo "<p class=\"message\">". $message . "</p>";}
    if (!empty($errors) ){ displayErrors($errors); }

    $patientInfo = array('firstname'=>$firstname,
                         'lastname'=>$lastname,
                         'dateofbirth'=>$dateofbirth,
                         'chartnumber'=>$chartnumber,
                         'homezip'=>$homezip,
                         'workzip'=>$workzip,
                         'tester'=>$tester,
                         'sex'=>$sex );

    ($treatment == 0)? $printReport = 'disabled' : $printReport = '';
    ($refill == 1)? $refillChecked = 'checked' : $refillChecked = '';

    $entryRecordInfo = array('patientId' => $patientId,
                             'treatment' => $treatment,
                             'dilutionStrength' => $dilutionStrength,
                             'firstname' => $firstname,
                             'lastname' => $lastname,
                             'dateofbirth' => $dateofbirth,
                             'chartnumber' => $chartnumber,
                             'homezip' => $homezip,
                             'workzip' => $workzip,
                             'sex' => $sex,
                             'email' => $email,
                             'tester' => $tester,
                             'mspscore' => $mspscore,
                             'itscore' => $itscore,
                             'refillChecked' => $refillChecked,
                             'printReport' => $printReport,
                             'analysisCount' => $analysisCount);
    // treatment array NYD =>0, Drops=>1, Injection=>2
    $treatmentArray = array('','','');
    $treatmentArray[$treatment] = 'checked';

    // injection level array 0 => 1st Dilution , 1=>2nd Dilution   2=>3rd Dilution, 3=> 4th Dilution
    $injectionLevelArray = array('','','','');
    $dilution = Analysis::get_dilutionLevel($patientId,$analysisCount);
    $injectionLevelArray[$dilution] = 'checked';

    $params['analysisList']     = $analysisList;
    $params['allergenList']     = $allergenList;
    $params['patientInfo']      = $patientInfo;
    $params['entryRecordInfo']  = $entryRecordInfo;
    $params['treatment']        = $treatmentArray;
    $params['injectionLevel']   = $injectionLevelArray;

    echo $dwoo->get('../../templates/patientInfo.tpl', $patientInfo);
    echo $dwoo->get('../../templates/treatments.tpl', $params);
    echo $dwoo->get('../../templates/entryRecords.tpl', $params);

?>
<?php /*
<table class="entry" width=800px>
<form id ="frm_analysis" action="update_analysis.php" method ="post">
<p id="page2">

/*
echo  "<input type=\"hidden\" id=\"patientID\"      name=\"patientID\" value=\"{$patientId}\" >";
echo  "<input type=\"hidden\" id=\"analysisCount\"  name=\"analysisCount\" value=\"{$analysisCount}\" >";

if ($treatment == 1 || $treatment == 0){
    echo "<tr>";
    echo "<th>Allergen</th>";
    echo "<th>Multitest Skin Prick Wheel (mm)</th>";
    echo "<th>Intradermal Test Wheel (mm)</th>";
    echo "</tr>";
    foreach($analysisList as $key => $analysis){
        $mspscore = $analysis->MSPScore;
        $itscore  = $analysis->ITScore;
        $id       = $analysis->allergenID;
        (empty($mspscore) || $mspscore == null)? $mspscore = 0 :  $mspscore;
        (empty($itscore) || $itscore == null)?   $itscore = 0 : $itscore;
        if ($mspscore >= 7 || $itscore >=7){
            echo "<td style=\"color:red;\" id=\"antigen{$id}\">";
        }else{
            echo "<td style=\"color:black;\" id=\"antigen{$id}\">";
        }
        // Allergen name
        echo "  ".$name = $allergenList[$id]  ;
        echo "</td>";
        //Multitest Skin Prick Wheel
        echo "<td>";
        echo " <select class=\"selectNum\"  name=\"wmsp{$id}\" data-wheelvalue=\"{$mspscore}\"   onChange=\"updateField({$id},this.value,this.name)\" >";
        echo "</select >";
        echo "</td>";
        //Intradermal Test Wheel
        echo "<td>";
        echo " <select  class=\"selectNum\"   name=\"wisp{$id}\" data-wheelvalue=\"{$itscore}\"  onChange=\"updateField({$id},this.value,this.name)\" >";
        echo "</select>";
        echo "</td>";
        echo "</tr>";
    }
}else{
    echo "<tr>";
    echo "<th>Allergen</th>";
    echo "<th>Multitest S P Whl(mm)</th>";
    echo "<th>ID Dilu  </th>";
    echo "<th>Intra Test Wheel (mm)</th>";
    echo "<th>2nd IDD</th>";
    echo "<th>2nd Whl</th>";
    echo "<th>End P</th>";
    echo "<th>Dilution</th>";
    echo "</tr>";
    foreach($analysisList as $key => $analysis){
        $mspscore =$analysis->MSPScore;
        $itscore =$analysis->ITScore;
        $id = $analysis->allergenID;
        $twoWhl = $analysis->twoWhl;

        (empty($mspscore) || $mspscore == null)? $mspscore = 0 :  $mspscore;
        (empty($itscore) || $itscore == null)?   $itscore = 0 : $itscore;

        if ($mspscore >= 7 || $itscore >=7){
            echo "<td style=\"color:red;\" id=\"antigen{$id}\">";
        }else{
            echo "<td style=\"color:black;\" id=\"antigen{$id}\">";
        }
        // Allergen name
        echo "  ".$name = $allergenList[$id];
        echo "</td>";
        // Multitest Wheel
        echo "<td>";
        echo " <select class=\"selectNum\"  name=\"wmsp{$id}\"  data-wheelvalue=\"{$mspscore}\" onChange=\"updateField({$id},this.value,this.name)\" >";
       // for($i=0; $i<= 30; $i++){
            //if ($i == $mspscore){
               // echo "<option selected  name=\"msp{$i}\" id=\"{$mspscore}\"    >{$mspscore}  </option>";
           // }else{
                //echo "<option   name=\"msp{$i}\" id=\"{$mspscore}\"   >{$i}   </option> ";
           // }
        //}
        echo "</select>";
        echo "</td>";
        //ID Dilu
        echo "<td>";
        if ($mspscore < 7){
            echo " 2";
        }
        echo "</td>";
        // Intra Test Wheel
        echo "<td>";
        echo " <select class=\"selectNum\" name=\"wisp{$id}\"   data-wheelvalue=\"{$itscore}\"  onChange=\"updateField({$id},this.value,this.name)\" >";
        echo "</select>";
        echo "</td>";
        // 2nd IDD
        echo "<td>";
            if (($mspscore == 7 || $mspscore == 8) && ($twoWhl < 9)){
             echo " 5";
            }
        echo "</td>";
        //2d Wheel
        echo "<td>";
            if ($mspscore == 7 || $mspscore == 8){
                echo " <select  name=\"twoWhl{$id}\" onChange=\"updateField({$id},this.value,this.name)\" >";
                        for($j=0; $j<= 30; $j++){
                            if ($j == $twoWhl){
                                echo "<option selected name=\"twoWhl{$j}\"   id=\"{$twoWhl}\" >{$twoWhl}</option>   ";
                            }else{
                                echo " <option name=\"twoWhl{$j}\"  id=\"{$twoWhl}\" >{$j}</option>";
                            }
                        }
                echo "</select>";
            } else{
                echo "";
        }

        echo "</td>";

        //End P
        echo "<td>";
            if ($mspscore == 7 || $mspscore == 8){
                if ($twoWhl >= 9){
                    echo " 6";
                }else{
                    echo " 4";
                }
            }elseif ($mspscore >= 9 || $itscore >= 7){
                echo " 6";
            }
        echo "</td>";

        //Dilution
        echo "<td>";
            if ($mspscore == 7 || $mspscore == 8){
                if ($twoWhl >= 9){
                    echo " 4";
                }else{
                    echo " 2";
                }
            }elseif ($mspscore >= 9 || $itscore >= 7){
                echo " 4";
            }
        echo "</td>";
        echo "</tr>";
    }
}
    ?>
<p>&nbsp</p>

</form>
</table>

<?php
    echo "<p id=\"page2\"><b> Patient: ".$firstname." ".$lastname."<b></p>"; ?>
</div> */
inlcudeLayoutTemplet('footer.php');?>

<script type="text/javascript">
    $(document).ready(function () {
        $('tr:nth-child(even)').css("background", "lightgrey");
        var optionOpen = "<option>";
        var optionOpenSelected = "<option selected>";
        var optionClose = "</option>";
        var selectItems = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];
        $(".selectNum").each(function () {
            for (key in selectItems) {
                if ($(this).data("wheelvalue") == selectItems[key]) {
                    $(this).append(optionOpenSelected + $(this).data("wheelvalue") + optionClose);
                }
                else {
                    $(this).append(optionOpen + selectItems[key] + optionClose);
                }
            }
        });
    });
    //-----------------
    // printEntryPage
    //-----------------
    function printEntryPage()
    {
        window.print();
        var jsVar1 = "<?php echo urlencode($patientId) ?>";
        var jsVar2 = "<?php echo urlencode($analysisCount) ?>";
        var jsVar3 = "<?php echo urlencode($treatment) ?>";
        document.forms["frm_treatment"].action ="update_entry_record.php?treat="+jsVar3+"&id=" + jsVar1 + "&aCnt=" + jsVar2;
    }
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
    // SetButtonStatus
    //-------------------------------------
    function SetButtonStatus(text)
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
    //-------------------------
    // myHandleResponseFunction
    //-------------------------
    function myHandleResponseFunction(ajax, name, id, value) {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                var results = document.getElementById("update_result");
                results.innerHTML = ajax.responseText;

                if(id != null) {
                    var tableData = document.getElementById("antigen"+id);
                    var wmsp = document.getElementsByName("wmsp"+id);
                    var wisp = document.getElementsByName("wisp"+id);
                    if (wmsp[0].value >=7 || wisp[0].value >=7 ){
                        tableData.style.color = "red";
                    }else{
                        tableData.style.color = "black";
                    }
                } else if (name == "treatment") {
                    document.forms["frm_treatment"].submit();
                }
            }
            else {
                document.getElementById("frm_analysis").submit();
            }
        }
    }
    //-------------------------
    // updateField
    //-------------------------
    function updateField(id, value, name) {
        var ajax = new getXMLHttpRequestObject();
        if (ajax) {
            var patientId = document.getElementById("patientID").value;
            var anaCnt = document.getElementById("analysisCount").value;
            var url="update_analysis.php?id="+id+"&value="+value+"&name="+name+"&patientId="+patientId+"&anaCnt="+anaCnt;
            ajax.open("get", url, true);
            ajax.onreadystatechange = function() {
                myHandleResponseFunction(ajax,name,id,value);
            }
            ajax.send(null);
            return false;
        }
    }

</script>

    