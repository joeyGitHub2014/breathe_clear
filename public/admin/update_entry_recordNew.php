<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
      redirectTo("login.php");
    }
?>
<?php
include_once("../../includes/form_functions.php");
$treatment = 0;
$dilution = 0;
$firstname ="";
$lastname = "";
$dateofbirth ="";
$chartnumber = "";
$homezip ="";
$workzip = "";
$sex = "";
$email = "";
$tester = "";
$batteryNameCurr = "";
$batteryNamePrev = "";
$mspscore = 5;
$itscore = 5;
$alternate = 0;
$analysisCount = 0;
function IsChecked($chkname,$value)
    {
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                if($chkval == $value)
                {   
                    return true;
                }
            }
        }
        return false;
    }
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
        $total_count = Allergen::count_all();
        $sql  = " SELECT allergenID, antigenName  FROM allergens1 ";
        $sql .= " ORDER BY batteryName  ASC, site  ASC  ";
        $allergen_list = Allergen::find_by_sql($sql);
        Analysis::set_analysis_table();
        $sql  = " SELECT *  FROM analysis  WHERE patientID = {$patientId} AND analysisCount = {$analysisCount}";
        $analysis_list = Analysis::find_by_sql($sql);
    /*}*/

 ?>
<?php inlcudeLayoutTemplet('admin_header.php');?>
<script language="javascript" type="text/javascript">
//-----------------
// printpage
//-----------------
function printpage()
{
    window.print();
    var jsVar1 = "<?php echo urlencode($patientId) ?>";
    var jsVar2 = "<?php echo urlencode($analysisCount) ?>";
    var jsVar3 = "<?php echo urlencode($treatment) ?>";   
    document.forms["frm_treatment"].action ="update_entry_record.php?treat="+jsVar3+"&id=" + jsVar1 + "&aCnt=" + jsVar2;
}
//-----------------
// update_refill
//-----------------
function update_refill(){
    var patientId = "<?php echo urlencode($patientId) ?>";
    var anaCnt = "<?php echo urlencode($analysisCount) ?>";
    var ajax = new getXMLHttpRequestObject(); // this method is defined in the other Javascript file called 'ajax.js'
	if (ajax) {
	       //if (document.getElementById(name)) { // 'document' refers to joe.html on which the html form is found
               var treat = 1;
               var refill;
               if (document.getElementById("check1").checked == true){
                    refill = 1;
               }else{
                    refill = 0;
               }
                var url="update_dilutionLevel.php?dilution="+refill+"&patientId="+patientId+"&anaCnt="+anaCnt+"&treat="+treat;
		ajax.open("get", url, true); // open Ajax with the GET method
		ajax.onreadystatechange = function() { // register another annonymous handler function for the 'onreadystatechange' event of the ajax object
		    myHandleResponseFunction(ajax,"refill"); // this annonymous handler delegates the heavy task to my own function, passed to which is the 'ajax' object
		   // document.forms["frm_treatment"].submit();
                }
                ajax.send(null); //used when open Ajax with the GET method
		return false;
		//} // dom
	} // ajax
 
}
//-----------------
// updateDilutionLevel
//-----------------
function updateDilutionLevel(dilution){
    var patientId = "<?php echo urlencode($patientId) ?>";
    var anaCnt = "<?php echo urlencode($analysisCount) ?>";
    var ajax = new getXMLHttpRequestObject(); // this method is defined in the other Javascript file called 'ajax.js'
	if (ajax) {
		//if (document.getElementById(name)) { // 'document' refers to joe.html on which the html form is found
                var treat = document.getElementById("treatment").value;
                var url="update_dilutionLevel.php?dilution="+dilution+"&patientId="+patientId+"&anaCnt="+anaCnt+"&treat="+treat;
		ajax.open("get", url, true); // open Ajax with the GET method
		ajax.onreadystatechange = function() { // register another annonymous handler function for the 'onreadystatechange' event of the ajax object
		    myHandleResponseFunction(ajax,"refill"); // this annonymous handler delegates the heavy task to my own function, passed to which is the 'ajax' object
		   // document.forms["frm_treatment"].submit();
                }
                ajax.send(null); //used when open Ajax with the GET method
		return false;
		//} // dom
	} // ajax
 
}
//-------------------------------------
// SetButtonStatus
//-------------------------------------
function SetButtonStatus(text)
{
    var jsVar1 = "<?php echo urlencode($patientId) ?>";
    var jsVar2 = "<?php echo urlencode($analysisCount) ?>";
    var treat;
    if ( text == "nyd" ){
      document.forms["frm_treatment"].action ="update_entry_record.php?treat=0&id=" + jsVar1 + "&aCnt=" + jsVar2; 
      document.getElementById("submit_report").disabled = true;
      treat = document.getElementById("treatment").value = 0;
    }
    else{
      if (text == "drops"){
        document.forms["frm_treatment"].action ="update_entry_record.php?treat=1&id=" + jsVar1 + "&aCnt=" + jsVar2; 
        treat = document.getElementById("treatment").value = 1;
      }else{
        document.forms["frm_treatment"].action = "update_entry_record.php?treat=2&id=" + jsVar1 + "&aCnt=" + jsVar2; 
        treat = document.getElementById("treatment").value = 2;
      }
      document.getElementById("submit_report").disabled = false;
    }
    updateTreatment(treat,jsVar1,jsVar2,"treatment");
}
//-----------------
// updateTreatment
//-----------------
function updateTreatment(treat, patientId, anaCnt,name){
    //alert(" patientId ---> "+patientId + " treat ---> " + treat + " name --->" + name + " anaCnt ---> " + anaCnt);
	var ajax = new getXMLHttpRequestObject(); // this method is defined in the other Javascript file called 'ajax.js'
	if (ajax) {
		//if (document.getElementById(name)) { // 'document' refers to joe.html on which the html form is found
		var url="update_treatment.php?treat="+treat+"&patientId="+patientId+"&anaCnt="+anaCnt;
		ajax.open("get", url, true); // open Ajax with the GET method
		ajax.onreadystatechange = function() { // register another annonymous handler function for the 'onreadystatechange' event of the ajax object
		    myHandleResponseFunction(ajax,name); // this annonymous handler delegates the heavy task to my own function, passed to which is the 'ajax' object
		    document.forms["frm_treatment"].submit();
                }
                ajax.send(null); //used when open Ajax with the GET method
		return false;
		//} // dom
	} // ajax
}
//-------------------------
// myHandleResponseFunction
//-------------------------
function myHandleResponseFunction(ajax, name, id=null) {
    alert("id -> "+ id)
	if (ajax.readyState == 4) {
		if (ajax.status == 200) {
			var results = document.getElementById("update_result");
			 results.innerHTML = ajax.responseText; //results.style.display = "block";
                         if (id != null){
                            var tableData = document.getElementById("antigen"+id);
                            var wmsp = document.getElementsByName("wmsp"+id);
                            var wisp = document.getElementsByName("wisp"+id);
                            if (wmsp[0].value >=7 || wisp[0].value >=7 ){
                               tableData.style.color = "red";
                            }else{
                               tableData.style.color = "black";
                            }
                         }
                         //alert("ajax response --->" + ajax.responseText); // xml,json
                         //echo "<p>".$id."</p>";// will be echo back
		} // status if
		else {
			document.getElementById("frm_analysis").submit();
		} // status else
	} // readyState
} // myHandleResponseFunction
//-------------------------
// updateField
//-------------------------
function updateField(id, value, name){
    //alert("ID --->"+id + "Value --->" + value + "name --->" + name);
    //var queryString = "?id=" + id + "&value=" + value + "&name=" + name;
    var ajax = new getXMLHttpRequestObject(); // this method is defined in the other Javascript file called 'ajax.js'
	if (ajax) {
		//if (document.getElementById(name)) { // 'document' refers to joe.html on which the html form is found
                //var treat = document.getElementById("treatment").value;
                var patientId = document.getElementById("patientID").value;
                var anaCnt = document.getElementById("analysisCount").value;
		var url="update_analysis.php?id="+id+"&value="+value+"&name="+name+"&patientId="+patientId+"&anaCnt="+anaCnt;
		ajax.open("get", url, true); // open Ajax with the GET method
		ajax.onreadystatechange = function() { // register another annonymous handler function for the 'onreadystatechange' event of the ajax object
		    myHandleResponseFunction(ajax,name,id); // this annonymous handler delegates the heavy task to my own function, passed to which is the 'ajax' object
                }
                ajax.send(null); //used when open Ajax with the GET method
		return false;
		//} // dom
	} // ajax
}
//-------------------------
// getXMLHttpRequestObject
//-------------------------
function getXMLHttpRequestObject()
{
    var ajax = false;
    if (window.XMLHttpRequest) { // most mordern web browsers (IE7+, Firefox, Safari, Opera, Chrome)
            ajax = new XMLHttpRequest(); // true now
    }
    else if (window.ActiveXObject) { // older IE web browsers
            try {
                    ajax = new ActiveXObject("Msxml2.XMLHTTP"); // true now
            }
            catch(e) {
                    try { // much older IE web browsers
                            ajax = new ActiveXObject("Microsoft.XMLHTTP"); // true now			
                    }
                    catch(e2) {
                            window.alert("Get a mordern web browser please!");			
                    }
            }
    }
    return ajax;
}
</script>
	<table id ="structure">
	<tr id ="page">
	    <td>
                <h2 class="title" > Patient Record </h2>
                <?php if (!empty($message) ){echo "<p class=\"message\">". $message . "</p>";}?>
                <?php if (!empty($errors) ){ displayErrors($errors); }?>

                <p> Firstname:   
                    <input type="text" name="firstname"   readonly="readonly"    maxlength="50" value="<?php echo htmlentities($firstname)?>" />
                    Lastname:  
                    <input type="text" name="lastname"  readonly="readonly"   maxlength="50" value="<?php echo htmlentities($lastname)?>" />
                                       Date Of Birth: 
                    <input type="text" name="dateofbirth"   readonly="readonly"   maxlength="20" value="<?php echo htmlentities($dateofbirth)?>" />
                    Chart Number:
                    <input type="text" name="chartnumber"   readonly="readonly"  maxlength="10" value="<?php echo htmlentities($chartnumber)?>" />
                </p>

                <p>Home ZIP:
                    <input type="text" name="homezip"  readonly="readonly"    maxlength="5" value="<?php echo htmlentities($homezip)?>" />
                    Work ZIP:
                    <input type="text" name="workzip" readonly="readonly"    maxlength="5" value="<?php echo htmlentities($workzip)?>" />
                    Sex:
                    <select name="sex">
                        <?php if ($sex == "M"){  
                            echo "<option  selected value=\"M\" >M</option>";
                            echo "<option value=\"F\">F</option>";
                        }else{
                            echo "<option  value=\"M\" >M</option>";
                            echo "<option selected value=\"F\">F</option>";
                        }
                        ?>
                    </select>
                 
                </p>
                <p>
                    Tester:
                    <input type="text" name="tester"  readonly="readonly"    maxlength="50" value="<?php echo htmlentities($tester)?>" />
                </p>
            </td>
	</tr>

    </table>
    <table>
        <div class="" style="color: #02F811; margin-left: 650px; " id="update_result" ></div>
    </table>
    <table class="entry" width=800px>
    <h2 class="title" > Edit Entry Record </h2>

    <form id ="frm_treatment" action="create_report.php" method ="post">
<div style=" "
    </p>
        <p id="page2"> Type of Treatment:</p>
        <p id="page2">
        <?php
            if ($treatment == 0){ 
                echo "<input type=\"radio\"  name=\"treatment\" value=\"nyd\" checked=\"checked\" onclick=\"SetButtonStatus(this.value)\"  />  Not Yet Determined ";
                echo "<input type=\"radio\"  name=\"treatment\" value=\"drops\"   onclick=\"SetButtonStatus(this.value)\"  /> Drops ";
                echo "<input type=\"radio\"  name=\"treatment\" value=\"injection\" onclick=\"SetButtonStatus(this.value)\" /> Injection ";
            } elseif ($treatment == 1){
                echo "<input type=\"radio\"  name=\"treatment\" value=\"nyd\"  onclick=\"SetButtonStatus(this.value)\"  />  Not Yet Determined ";
                echo "<input type=\"radio\"  name=\"treatment\" value=\"drops\" checked=\"checked\" onclick=\"SetButtonStatus(this.value)\"  /> Drops ";
                echo "<input type=\"radio\"  name=\"treatment\" value=\"injection\" onclick=\"SetButtonStatus(this.value)\" /> Injection ";
                echo "<div id=\"dilDrp\">";
                Analysis::set_analysis_table();
                if ( (Analysis::get_refill($patientId,$analysisCount)) == 0){
                    echo  "<input type=\"checkbox\"   id=\"check1\"   onclick=\"update_refill()\"  /> Refill ";
                }else{
                    echo  "<input type=\"checkbox\" checked=\"yes\" id=\"check1\"    onclick=\"update_refill()\"  /> Refill ";
                }
                echo "</div>";
            }elseif ($treatment == 2){
                echo "&nbsp&nbsp&nbsp<input type=\"radio\"  name=\"treatment\" value=\"nyd\"  onclick=\"SetButtonStatus(this.value)\"  />  Not Yet Determined ";
                echo "<input type=\"radio\"  name=\"treatment\" value=\"drops\" onclick=\"SetButtonStatus(this.value)\"  /> Drops ";
                echo "<input type=\"radio\"  name=\"treatment\" value=\"injection\" checked=\"checked\" onclick=\"SetButtonStatus(this.value)\" /> Injection ";
                echo "<div id=\"dilInj\">";
                Analysis::set_analysis_table();
                $dilution = Analysis::get_dilutionLevel($patientId,$analysisCount);    
                if ($dilution == 0){
                    echo   "&nbsp&nbsp&nbsp<input type=\"radio\" id=\"refill0\" name=\"refill\"  value=\"0\" checked=\"checked\" onclick=\"updateDilutionLevel(this.value)\" /> 1st Dilution ";
                    echo   "<input type=\"radio\" id=\"refill1\"  name=\"refill\" value=\"1\" onclick=\"updateDilutionLevel(this.value)\" /> 2nd Dilution ";
                    echo   "<input type=\"radio\" id=\"refill2\"  name=\"refill\" value=\"2\" onclick=\"updateDilutionLevel(this.value)\" /> 3rd Dilution  ";
                    echo   "<input type=\"radio\" id=\"refill3\"  name=\"refill\" value=\"3\" onclick=\"updateDilutionLevel(this.value)\" /> 4th or Final Dilution ";
                }elseif ($dilution == 1){
                    echo   "&nbsp&nbsp&nbsp<input type=\"radio\" id=\"refill0\" name=\"refill\"  value=\"0\"  onclick=\"updateDilutionLevel(this.value)\" /> 1st Dilution ";
                    echo   "<input type=\"radio\" id=\"refill1\"  name=\"refill\" value=\"1\" checked=\"checked\"  onclick=\"updateDilutionLevel(this.value)\" /> 2nd Dilution ";
                    echo   "<input type=\"radio\" id=\"refill2\"  name=\"refill\" value=\"2\" onclick=\"updateDilutionLevel(this.value)\" /> 3rd Dilution  ";
                    echo   "<input type=\"radio\" id=\"refill3\"  name=\"refill\" value=\"3\" onclick=\"updateDilutionLevel(this.value)\" /> 4th or Final Dilution ";
                }elseif ($dilution == 2){
                    echo   "&nbsp&nbsp&nbsp<input type=\"radio\" id=\"refill0\" name=\"refill\"  value=\"0\"  onclick=\"updateDilutionLevel(this.value)\" /> 1st Dilution ";
                    echo   "<input type=\"radio\" id=\"refill1\"  name=\"refill\" value=\"1\" onclick=\"updateDilutionLevel(this.value)\" /> 2nd Dilution ";
                    echo   "<input type=\"radio\" id=\"refill2\"  name=\"refill\" value=\"2\" checked=\"checked\"  onclick=\"updateDilutionLevel(this.value)\" /> 3rd Dilution  ";
                    echo   "<input type=\"radio\" id=\"refill3\"  name=\"refill\" value=\"3\" onclick=\"updateDilutionLevel(this.value)\" /> 4th or Final Dilution ";
                }elseif ($dilution == 3){
                    echo   "&nbsp&nbsp&nbsp<input type=\"radio\" id=\"refill0\" name=\"refill\"  value=\"0\"  onclick=\"updateDilutionLevel(this.value)\" /> 1st Dilution ";
                    echo   "<input type=\"radio\" id=\"refill1\"  name=\"refill\" value=\"1\" onclick=\"updateDilutionLevel(this.value)\" /> 2nd Dilution ";
                    echo   "<input type=\"radio\" id=\"refill2\"  name=\"refill\" value=\"2\" onclick=\"updateDilutionLevel(this.value)\" /> 3rd Dilution  ";
                    echo   "<input type=\"radio\" id=\"refill3\"  name=\"refill\" value=\"3\" checked=\"checked\"  onclick=\"updateDilutionLevel(this.value)\" /> 4th or Final Dilution ";
                }
                echo "</div>";
            }
        echo  "<input type=\"hidden\" id=\"treatment\"     name=\"treatment\" value=\"{$treatment}\" >";
        echo  "<input type=\"hidden\" id=\"treatPatientID\"      name=\"patientID\" value=\"{$patientId}\" >";
        echo  "<input type=\"hidden\" id=\"treatAnalysisCount\"  name=\"analysisCount\" value=\"{$analysisCount}\" >";
        echo "<p id=\"page2\">";
        if ($treatment == 1 ||$treatment == 2){ 
            echo  "<input type=\"submit\" id=\"submit_report\"   name =\"submit_report\" value =\"Generate Immunotherapy Preparation\"      />";
        }else{
            echo  "<input type=\"submit\" id=\"submit_report\" disabled=\"disabled\"  name =\"submit_report\" value =\"Generate Immunotherapy Preparation\"      />";
        }
        echo  "<input type=\"submit\" id=\"print\"   name =\"print\" value =\"Print Entry Record\"  onclick=\"printpage()\"     />";
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "<a   href=\"create_patient_report.php?id={$patientID}&aCnt={$analysisCount}\">click here for Patient Report </a>";
        echo "</p>";
        ?>
    </form>

    <form id ="frm_analysis" action="update_analysis.php" method ="post">
    <p id="page2">

     <?php
    echo  "<input type=\"hidden\" id=\"patientID\"      name=\"patientID\" value=\"{$patientId}\" >";
    echo  "<input type=\"hidden\" id=\"analysisCount\"  name=\"analysisCount\" value=\"{$analysisCount}\" >";

    if ($treatment == 1 || $treatment == 0){ 
            echo "<tr>";
            echo "<th>Allergen</th>";
            echo "<th>Multitest Skin Prick Wheel (mm)</th>";
            echo  "<th>Intradermal Test Wheel (mm)</th>";
            echo "<th>Confirmation</th>";
            echo "</tr>";
            foreach($allergen_list as $key => $antigen){
                foreach($analysis_list as $key => $analysis){
                    if ($antigen->allergenID == $analysis->allergenID){
                        $mspscore =$analysis->MSPScore;
                        $itscore =$analysis->ITScore;
                        if ($alternate==0) {
                            echo " <tr bgcolor = \"#E2E2E2\"     > ";
                            $alternate=1;
                        }
                        else {
                            echo " <tr bgcolor = \"#FFFFFF\"     > ";
                            $alternate = 0;
                        }
                        $id = $antigen->allergenID;
                        $battery = $antigen->batteryName;
                        $groupId = $antigen->groupID;
                        if ($mspscore >= 7 || $itscore >=7){
                            echo "<td style=\"color:red;\" id=\"antigen{$id}\">";
                        }else{
                            echo "<td style=\"color:black;\" id=\"antigen{$id}\">";
                        }
                        echo "  ".$name = $antigen->antigenName;
                        echo "</td>";

                        if (empty($mspscore) || $mspscore == null){
                            $mspscore = 0;
                        }
                        if (empty($itscore) || $itscore == null) {
                            $itscore = 0;
                        }
                        echo "<td>";
                        echo " <select name=\"wmsp{$id}\"  onChange=\"updateField({$id},this.value,this.name)\" >";
                        for($i=0; $i<= 30; $i++){
                            if ($i == $mspscore){
                                echo "<option selected  name=\"msp{$i}\" id=\"{$mspscore}\"    >{$mspscore}  </option>";
                            }else{
                                echo "<option   name=\"msp{$i}\" id=\"{$mspscore}\"   >{$i}   </option> ";
                            }
                        }
                        echo "</select >";
                        echo "</td>";
                        echo "<td>";
                        echo " <select  name=\"wisp{$id}\" onChange=\"updateField({$id},this.value,this.name)\" >";
                        for($j=0; $j<= 30; $j++){
                            if ($j == $itscore){
                                echo "<option selected name=\"isp{$j}\"  id=\"{$itscore}\"   >{$itscore}   </option>   ";
                            }else{
                                echo " <option name=\"isp{$j}\" id=\"{$itscore}\"   >{$j} </option>";
                            }
                        }
                        echo "</select>";
                        //echo  "<input type=\"hidden\" name=\"msp\" value=\"{$mspscore}\" size=8>";
                        //echo  "<input type=\"hidden\" name=\"isp\"  value=\"{$itscore}\" size=8>";
                        echo "</td>";
                        echo "<td>";
                        echo "<input type=\"checkbox\" name=\"confirm[]\" value=\"{$id}\" /> " ;
                        echo "</td>";
                        echo "</tr>";
                        break;
                      }
                  }
     
            }
        }else{
            echo "<tr>";
            echo "<th>Allergen</th>";
            echo "<th>Multitest S P Whl(mm)</th>";
            echo "<th>ID Dilu  </th>";
            echo  "<th>Intra Test Wheel (mm)</th>";
            echo "<th>2nd IDD</th>";
            echo "<th>2nd Whl</th>";
            echo "<th>End P</th>";
            echo "<th>Dilution</th>";
            echo "</tr>";
            foreach($allergen_list as $key => $antigen){
                foreach($analysis_list as $key => $analysis){
                    if ($antigen->allergenID == $analysis->allergenID){
                        $mspscore =$analysis->MSPScore;
                        $itscore =$analysis->ITScore;
                        $id = $antigen->allergenID;
                        if ($alternate==0) {
                            echo " <tr bgcolor = \"#E2E2E2\"     > ";
                            $alternate=1;
                        }
                        else {
                            echo " <tr bgcolor = \"#FFFFFF\"     > ";
                            $alternate = 0;
                        }
                        if ($mspscore >= 7 || $itscore >=7){
                            echo "<td style=\"color:red;\" id=\"antigen{$id}\">";
                        }else{
                            echo "<td style=\"color:black;\" id=\"antigen{$id}\">";
                        }
                        echo "  ".$name = $antigen->antigenName;
                        echo "</td>";
                        echo "<td>";
                        echo " <select name=\"wmsp{$id}\"  onChange=\"updateField({$id},this.value,this.name)\" >";
                        $twoWhl = $analysis->twoWhl;
                         if (empty($mspscore) || $mspscore == null){
                            $mspscore = 0;
                        }
                        if (empty($itscore) || $itscore == null) {
                            $itscore = 0;
                        }
                        for($i=0; $i<= 30; $i++){
                            if ($i == $mspscore){
                                echo "<option selected  name=\"msp{$i}\" id=\"{$mspscore}\"    >{$mspscore}  </option>";
                            }else{
                                echo "<option   name=\"msp{$i}\" id=\"{$mspscore}\"   >{$i}   </option> ";
                            }
                        }
                        echo "</select>";
                        echo "</td>";
                        echo "<td>";
                        if ($mspscore < 7){
                            echo " 2";
                        }
                        echo "</td>";
                        echo "<td>";
                        echo " <select  name=\"wisp{$id}\" onChange=\"updateField({$id},this.value,this.name)\" >";
                        for($j=0; $j<= 30; $j++){
                            if ($j == $itscore){
                                echo "<option selected name=\"isp{$j}\"  id=\"{$itscore}\"   >{$itscore}   </option>   ";
                            }else{
                                echo " <option name=\"isp{$j}\" id=\"{$itscore}\"   >{$j} </option>";
                            }
                        }
                        echo "</select>";
                        echo "</td>";
        
                        echo "<td>";
                            if (($mspscore == 7 || $mspscore == 8) && ($twoWhl < 9)){
                             echo " 5";
                            }
                        echo "</td>";
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
                        break;
                    }
                }

            }
        }
        ?>
    </table>
    <p>&nbsp</p>
   </form>
    </div>
<?php inlcudeLayoutTemplet('footer.php');?>
