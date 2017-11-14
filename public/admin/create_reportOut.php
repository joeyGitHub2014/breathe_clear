<?php
    require_once("../../includes/initialize.php");
    if (!$session->is_logged_in()){
      redirectTo("login.php");
    }
?>
<?php
include_once("../../includes/form_functions.php");
?>
<?php
$output;
$quantity = .2;
$totalSolution = 5;
$totalVolume = 5;
$allergicAnimals = array();
$allergicAnimals = null;
$allergicPollens = array();
$allergicPollens = null;
if (isset($_POST['submit_report'])) {
    $patientID = $_POST['patientID'];
    $treatment = $_POST['treatment'];
    $analysisCount = $_POST['analysisCount'];
}elseif(isset($POST['save_report'])){
    echo "HI";
} elseif(!empty($_GET)) {
    $patientID = !empty($_GET['id'])? (int) $_GET ['id'] : 0;
    $treatment = !empty($_GET['treat'])? (int) $_GET ['treat'] : 0;
    $analysisCount = !empty($_GET['aCnt'])? (int) $_GET ['aCnt'] : 0;
}elseif(isset($POST['print_report'])){
         redirectTo('create_report.php');
}
else{
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
if ($allergen_list>0 || $allergen_list>"") {
    $allergic =  array();
    Allergen::set_allergen_table();
    $i = 0;
    $j = 0;
    $k = 0;
    foreach($analysis_list as $key => $analysis){
        if ( $analysis->allergenID != 41 && $analysis->allergenID != 42){
            $sql  = " SELECT antigenName, groupID, batteryName, lotNumber, expDate  FROM allergens1 ";
            $sql .= " WHERE allergenID = {$analysis->allergenID}  ";
            $allergic_list = Allergen::find_by_sql($sql);
            if ( $analysis->MSPScore>= 7 || $analysis->ITScore >= 7 || $analysis->twoWhl>= 9){
                if (!empty($allergic_list)){
                    $allergic[$i] = array ( "id"  => array ( $i => $analysis->allergenID),
                                        "mspscore"  => array ( $i => $analysis->MSPScore),
                                        "itscore"  => array ( $i => $analysis->ITScore),
                                        "twowhl"  => array ( $i => $analysis->twoWhl),
                                        "lotnumber" => array ( $i => $allergic_list[0]->lotNumber),
                                        "expdate" => array ( $i => $allergic_list[0]->expDate),
                                        "name" => array ( $i => $allergic_list[0]->antigenName),
                                        "group" => array ( $i => $allergic_list[0]->groupID),
                                        "battery" => array ( $i => $allergic_list[0]->batteryName),
                                        "dilutionLevel" => array ( $i => $analysis->dilutionLevel)
                    );
                    $a = $allergic[$i];
                    if ( $a['id'] [$i] == 8  || $a['id'] [$i] == 14  ||($a['id'][$i] >= 23 && $a['id'][$i] <= 25) ||
                         $a['id'] [$i] == 27 || $a['id'] [$i] == 28  ||($a['id'][$i] >= 32 && $a['id'][$i] <= 34) ){
                        $allergicAnimals[$j] = array ( "id"  => array ( $j => $analysis->allergenID),
                                        "mspscore"  => array ( $j => $analysis->MSPScore),
                                        "itscore"  => array ( $j => $analysis->ITScore),
                                        "twowhl"  => array ( $j => $analysis->twoWhl),
                                        "lotnumber" => array ( $j => $allergic_list[0]->lotNumber),
                                        "expdate" => array ( $j => $allergic_list[0]->expDate),
                                        "name" => array ( $j => $allergic_list[0]->antigenName),
                                        "group" => array ( $j => $allergic_list[0]->groupID),
                                        "battery" => array ( $j => $allergic_list[0]->batteryName),
                                        "dilutionLevel" => array ( $j => $analysis->dilutionLevel)
    
                                        );
                        $j++;
                    }else{
                        $allergicPollens[$k] = array ( "id"  => array ( $k => $analysis->allergenID),
                                        "mspscore"  => array ( $k => $analysis->MSPScore),
                                        "itscore"  => array ( $k => $analysis->ITScore),
                                        "twowhl"  => array ( $k => $analysis->twoWhl),
                                        "lotnumber" => array ( $k => $allergic_list[0]->lotNumber),
                                        "expdate" => array ( $k => $allergic_list[0]->expDate),
                                        "name" => array ( $k => $allergic_list[0]->antigenName),
                                        "group" => array ( $k => $allergic_list[0]->groupID),
                                        "battery" => array ( $k => $allergic_list[0]->batteryName),
                                        "dilutionLevel" => array ( $k => $analysis->dilutionLevel)
                                        );
                        $k++;
                    }
                    $i++;
                }
            }
        }
    }
}


?>
<?php
inlcudeLayoutTemplet('admin_header.php');
        

?>

<script language="javascript" type="text/javascript">
//-----------------
// printpage
//-----------------
function printpage()
{
    window.print();
    document.forms["frm_report"].submit;

}
//-----------------
// saveReport
//-----------------
function saveReport(treat, patientId, anaCnt,name){
    //alert(" patientId ---> "+patientId + " treat ---> " + treat + " name --->" + name + " anaCnt ---> " + anaCnt);
	var ajax = new getXMLHttpRequestObject(); // this method is defined in the other Javascript file called 'ajax.js'
	if (ajax) {
		//if (document.getElementById(name)) { // 'document' refers to joe.html on which the html form is found
		var url="save_report.php?treat="+treat+"&patientId="+patientId+"&anaCnt="+anaCnt;
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
function myHandleResponseFunction(ajax, name) {
	if (ajax.readyState == 4) {
		if (ajax.status == 200) {
			var joe_results = document.getElementById("update_result");
			joe_results.innerHTML = ajax.responseText; //results.style.display = "block";
                         //alert("ajax response --->" + ajax.responseText); // xml,json
                         //     echo "<p>".$id."</p>" will be echo back
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
    var queryString = "?id=" + id + "&value=" + value + "&name=" + name;
    //alert("queryString --->" + queryString);
	var ajax = new getXMLHttpRequestObject(); // this method is defined in the other Javascript file called 'ajax.js'
	
	if (ajax) {
		//if (document.getElementById(name)) { // 'document' refers to joe.html on which the html form is found
                //var treat = document.getElementById("treatment").value;
                var patientId = document.getElementById("patientID").value;
                var anaCnt = document.getElementById("analysisCount").value;
		var url="update_analysis.php?id="+id+"&value="+value+"&name="+name+"&patientId="+patientId+"&anaCnt="+anaCnt;
		ajax.open("get", url, true); // open Ajax with the GET method
		ajax.onreadystatechange = function() { // register another annonymous handler function for the 'onreadystatechange' event of the ajax object
		    myHandleResponseFunction(ajax,name); // this annonymous handler delegates the heavy task to my own function, passed to which is the 'ajax' object
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
function emailReport() {
    	if (window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			alert(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET",window.location.href,true);
	xmlhttp.send();
}
</script>
    <?php

        if ($treatment == 2){
            $output =  "<h2 class=\"title\"> IMMUNOTHERAPY VIAL PREPARATION  </h2>";
            $output .=  "<h2 class=\"title\"> INJECTION </h2>";
            $output .=  "</br>";
        }else{
            $output = "<h2 class=\"title\"> IMMUNOTHERAPY VIAL PREPARATION  </h2>";
            $output .=  "<h2 class=\"title\"> SUBLINGUAL </h2>";
            $output .=  "</br>";
        }
                        echo $output;

        ?>
    <?php    
         $output =  "<table class=\"entrynoborder\"       width=800>
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

		</table>";
                echo $output;
        ?>
        </br>
        </br>
    <form id ="frm_report"   method ="post">
    
    <table class="entry" width=800px>

    <?php
        $output =  "<p id=\"page2\">";
        $output .=   "<input type=\"submit\" id=\"save_report\"   name =\"save_report\" value =\"Save Report\"      />";
        $output .=   "<input type=\"submit\" id=\"email_report\"   name =\"email_report\" value =\"Email Report\"  onclick=\"emailReport()\"      />";
        $output .=   "<input type=\"submit\" id=\"print_report\"   name =\"print_report\" value =\"Print Report\"   onclick=\"printpage()\"   />";

        $output .=   "<input type=\"hidden\" id=\"treatment\"     name=\"treatment\" value=\"{$treatment}\" >";
        $output .=   "<input type=\"hidden\" id=\"patientID\"      name=\"patientID\" value=\"{$patientID}\" >";
        $output .=   "<input type=\"hidden\" id=\"analysisCount\"  name=\"analysisCount\" value=\"{$analysisCount}\" >";
        $output .=   "<input type=\"hidden\" id=\"allergic\"  name=\"allergic\" value=\"{$allergic}\" >";

        $output .=  "</p>";
     if ($treatment != 2){ 
            $output .=  "<tr>";
            $output .=  "<th>Antigen</th>";
            $output .=  "<th>Pure Antigen </th>";
            $output .=   "<th>Quantity (cc)</th>";
            $output .=  "<th>Lot Number </th>";
            $output .=  "<th>Exp. Date</th>";
            $output .=  "</tr>";
            $alternate=1;
            if (!empty($allergic)){
                for ($i=0; $i <= sizeof($allergic)-1;$i++) {
                    if ($alternate==0) { 
                        $output .=  " <tr bgcolor = \"#D2D2D2\"     > ";
                        $alternate=1;
                    }
                    else { 
                        $output .=  " <tr bgcolor = \"#FFFFFF\"     > ";
                        $alternate = 0;
                    }
                    $a = $allergic[$i];
                    $output .=  "<td>";
                    $output .=  "  ".$a['name'][$i];
                    $output .=  "</td>";
                    $output .=  "<td> Pure ";
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "  ".$quantity;
                    $output .=  "<td>";
                    $output .=  "  ".$a['lotnumber'] [$i];
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "  ".$a['expdate'][$i];
                    $output .=  "</td>";
                    $output .=  "</tr>";
                }
                    $output .=  "<tr>";
                    $output .=  "<td>";
                    $output .=  "  " ;
                    $output .=  "</td>";
                    $output .=  "</tr>";
                if ($alternate ==0){
                    $output .=  "<tr bgcolor = \"#FFFFFF\">";
                    $alternate = 1;
                }else{
                    $output .=  "<tr bgcolor = \"#D2D2D2\">";
                    $alternate = 0;
                }
                $output .=  "<td>";
                $output .=  "Total Antigen = " ;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "" ;
                $output .=  "</td>";
                $totalAntigen = $quantity * sizeOf($allergic);
                $output .=  "<td>";
                $output .=  "  ".$totalAntigen;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "" ;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "" ;
                $output .=  "</td>";
                $output .=  "</tr>";
                if ($alternate ==0){
                    $output .=  "<tr bgcolor = \"#FFFFFF\">";
                    $alternate = 1;
    
                }else{
                    $output .=  "<tr bgcolor = \"#D2D2D2\">";
                    $alternate = 0;
                }
                $output .=  "<td>";
                $output .=  "Glycerin 50% = " ;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "" ;
                $output .=  "</td>";
                $glycerin = $totalSolution - $totalAntigen;
                $output .=  "<td>";
                $output .=  "  ".$glycerin;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "" ;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "" ;
                $output .=  "</td>";
                $output .=  "</tr>";
                if ($alternate ==0){
                    $output .=  "<tr bgcolor = \"#FFFFFF\">";
                    $alternate = 1;
    
                }else{
                    $output .=  "<tr bgcolor = \"#D2D2D2\">";
                    $alternate = 0;
                }
                $output .=  "<td>";
                $output .=  "Total Solution = " ;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "" ;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "  ".$totalSolution;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "" ;
                $output .=  "</td>";
                $output .=  "<td>";
                $output .=  "" ;
                $output .=  "</td>";
                $output .=  "</tr>";
            }
            
    }else{
        if (!empty($allergic)){
                $output .=  "<h2 class=\"title\"> VIAL A <h2>";
                $output .=  "<th>Antigen</th>";
                $output .=  "<th>Dilution</th>";
                $output .=  "<th>Quantity (cc)</th>";
                $output .=  "<th>Lot Number </th>";
                $output .=  "<th>Exp. Date</th>";
                $output .=  "</tr>";
                $alternate=1;
                if (isset($allergicAnimals)){
                    for ($i=0; $i <= sizeof($allergicAnimals)-1;$i++) {
                        $a = $allergicAnimals[$i];
                        if ($alternate==0) { 
                            $output .=  " <tr bgcolor = \"#D2D2D2\"     > ";
                            $alternate=1;
                        }
                        else { 
                            $output .=  " <tr bgcolor = \"#FFFFFF\"     > ";
                            $alternate = 0;
                        }
                        $output .=  "<td>";
                        $output .=  "  ".$a["name"][$i];
                        $output .=  "</td>";
                        if ($a['mspscore'][$i]>= 9 || $a['itscore'][$i]>= 7 || $a['twowhl'][$i]>= 9){
                            $dilution = 4 - $a['dilutionLevel'][$i];
                        }else{
                            if ($a['dilutionLevel'][$i] >= 1 ){
                                $dilution = 1;
                            }else{
                                $dilution = 2;
                            }
                        }
                        $output .=  "<td>";
                        $output .=  "  ".$dilution;
                        $output .=  "</td>";
                        $output .=  "<td>";
                        $output .=  "  ".$quantity;
                        $output .=  "</td>";
                        $output .=  "<td>";
                        $output .=  "  ".$a['lotnumber'][$i];;
                        $output .=  "</td>";
                        $output .=  "<td>";
                        $output .=  "  ".$a['expdate'][$i];
                        $output .=  "</td>";
                        $output .=  "</tr>";
                    }
                    $output .=  "<tr>";
                    $output .=  "<td>";
                    $output .=  "  " ;
                    $output .=  "</td>";
                    $output .=  "</tr>";
                    if ($alternate ==0){
                        $output .=  "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        $output .=  "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    $output .=  "<td>";
                    $output .=  "Total Antigen = " ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $totalAntigen = $quantity * sizeOf($allergicAnimals);
                    $output .=  "<td>";
                    $output .=  "  ".$totalAntigen;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "</tr>";
                    if ($alternate ==0){
                        $output .=  "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
        
                    }else{
                        $output .=  "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    $output .=  "<td>";
                    $output .=  "Glycerin 50% = " ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $glycerin = 1;
                    $output .=  "<td>";
                    $output .=  "  ".$glycerin;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "</tr>";
                    if ($alternate ==0){
                        $output .=  "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        $output .=  "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    $output .=  "<td>";
                    $output .=  "Phenol = " ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $phenol = 5 - ($glycerin + $totalAntigen);
                    $output .=  "<td>";
                    $output .=  "  ".$phenol;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "</tr>";
                    $output .=  "</tr>";
                                if ($alternate ==0){
                        $output .=  "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        $output .=  "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    $output .=  "<td>";
                    $output .=  "Total Volume = " ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "  ".$totalVolume;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "</tr>";
                }
                if (isset($allergicPollens)){
                    if ($allergicAnimals!=null){
                        $output .=  "</table>";
                        $output .=  "<table class=\"entry\" width=800px>";
                        $output .=  "<h2 class=\"title\"> VIAL B <h2>";
                        $output .=  "<th>Antigen</th>";
                        $output .=  "<th>Dilution</th>";
                        $output .=  "<th>Quantity (cc)</th>";
                        $output .=  "<th>Lot Number </th>";
                        $output .=  "<th>Exp. Date</th>";
                    }
                    for ($i=0; $i <= sizeof($allergicPollens)-1;$i++) {
                           if ($alternate==0) { 
                               $output .=  " <tr bgcolor = \"#D2D2D2\"     > ";
                               $alternate=1;
                           }
                           else { 
                               $output .=  " <tr bgcolor = \"#FFFFFF\"     > ";
                               $alternate = 0;
                           }
                            $a = $allergicPollens[$i];
                           $output .=  "<td>";
                           $output .=  "  ".$a["name"][$i];
                           $output .=  "</td>";
                            if ($a['mspscore'][$i]>= 9 || $a['itscore'][$i]>= 7 || $a['twowhl'][$i]>= 9){
                               $dilution = 4 - $a['dilutionLevel'][$i];
                            }else{
                                if ($a['dilutionLevel'][$i] >= 1 ){
                                    $dilution = 1;
                                }else{
                                    $dilution = 2;
                                }
                            }
                            $output .=  "<td>";
                            $output .=  "  ".$dilution;
                            $output .=  "</td>";
                            $output .=  "<td>";
                            $output .=  "  ".$quantity;
                            $output .=  "</td>";
                            $output .=  "<td>";
                            $output .=  "  ".$a['lotnumber'][$i];
                            $output .=  "</td>";
                            $output .=  "<td>";
                            $output .=  "  ".$a['expdate'][$i];
                            $output .=  "</td>";
                            $output .=  "</tr>";
                       }
                           $output .=  "<tr>";
                           $output .=  "<td>";
                           $output .=  "  " ;
                           $output .=  "</td>";
                           $output .=  "</tr>";
                       if ($alternate ==0){
                           $output .=  "<tr bgcolor = \"#FFFFFF\">";
                           $alternate = 1;
                       }else{
                           $output .=  "<tr bgcolor = \"#D2D2D2\">";
                           $alternate = 0;
                       }
                       $output .=  "<td>";
                       $output .=  "Total Antigen = " ;
                       $output .=  "</td>";
                       $output .=  "<td>";
                       $output .=  "" ;
                       $output .=  "</td>";
                       $totalAntigen = $quantity * sizeOf($allergicPollens);
                       $output .=  "<td>";
                       $output .=  "  ".$totalAntigen;
                       $output .=  "</td>";
                       $output .=  "<td>";
                       $output .=  " " ;
                       $output .=  "</td>";
                        $output .=  "<td>";
                       $output .=  " " ;
                       $output .=  "</td>";
                       $output .=  "</tr>";
                    $output .=  "</tr>";
                    if ($alternate ==0){
                        $output .=  "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
        
                    }else{
                        $output .=  "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    $output .=  "<td>";
                    $output .=  "Glycerin 50% = " ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $glycerin = 1;
                    $output .=  "<td>";
                    $output .=  "  ".$glycerin;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "</tr>";
                    if ($alternate ==0){
                        $output .=  "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        $output .=  "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                     
                    $output .=  "<td>";
                    $output .=  "Phenol = " ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $phenol = 5 - ($glycerin + $totalAntigen);
                    $output .=  "<td>";
                    $output .=  "  ".$phenol;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "</tr>";
                    $output .=  "</tr>";
                                if ($alternate ==0){
                        $output .=  "<tr bgcolor = \"#FFFFFF\">";
                        $alternate = 1;
                    }else{
                        $output .=  "<tr bgcolor = \"#D2D2D2\">";
                        $alternate = 0;
                    }
                    $output .=  "<td>";
                    $output .=  "Total Volume = " ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "  ".$totalVolume;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "<td>";
                    $output .=  "" ;
                    $output .=  "</td>";
                    $output .=  "</tr>";
                }
            }else{
                $output =  "</br>";
                $output .=  "</br>";
                $output .=  "<table class=\"entrynoborder\"  width=800  >";
                $output .=  "<tr>";
                $output .=  "<td padding='5px' style-color='#000000'>";
                $output .=  "<p class=\"outset\"  >";
                $output .=   "Nothing to report. No allergies.";
                $output .=  "</p>";
                $output .=  "</td>";
                $output .=  "</tr>";
                $output .=  "</table>";
            }
            echo $output;

        }

        ?>
        </table>
        <?php
            if ($treatment == 1 || $treatment == 0  ){
                if (!empty($allergic)){
                    $dt = date("dmY") ;
                    $expDate =  date('l jS F Y (Y-m-d)', strtotime('120 days'));
                    $f = substr($firstname, 0, 1);
                    $l = substr($lastname, 0, 1);
                    $lotNumber =  "#".$f.$l.$dt;
                    $output =  "</br>";
                    $output .=  "</br>";
                    $output .=  "<table class=\"entrynoborder\"  width=800  >";
                    $output .=  "<tr>";
                    $output .=  "<td padding='5px' style-color='#000000'>";
                    $output .=  "<p class=\"outset\"  >";
                    $output .=   "1 cc of solution was pulled out of a glass vial containing the antigens listed above and ";
                    $output .=   "added to 4 cc' of 50% glycerin then placed into the red dropper vial and mixed, 1 cc was ";
                    $output .=   "then pulled from the red dropper vial and added to 4 cc' of 50% glycerin into a green ";
                    $output .=   "dropper vial then mixed. 1 cc was then pulled from the green dropper vial and added to 4 ";
                    $output .=   "cc' of 50% glycerin into yellow dropper vial, and mixed, then labeled with patient's ";
                    $output .=   "name experation date {$expDate} and Lot Number {$lotNumber}. The dropper's were given to the ";
                    $output .=   "patient as a three month supply.";
                    $output .=  "</p>";
                    $output .=  "</td>";
                    $output .=  "</tr>";
                    $output .=  "</table>";
                }else{
                    $output =  "</br>";
                    $output .=  "</br>";
                    $output .=  "<table class=\"entrynoborder\"  width=800  >";
                    $output .=  "<tr>";
                    $output .=  "<td padding='5px' style-color='#000000'>";
                    $output .=  "<p class=\"outset\"  >";
                    $output .=   "Nothing to report. No allergies.";
                    $output .=  "</p>";
                    $output .=  "</td>";
                    $output .=  "</tr>";
                    $output .=  "</table>";
                }
                echo $output;

            }

        ?>

    </form>
    </div>
    <?php inlcudeLayoutTemplet('footer.php');?>

    