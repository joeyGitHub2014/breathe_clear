<?php



// ************************************

//	LOAD MAIN FUNCTIONS FIRST

//	security:

	include "include/s.inc.php";

//	database:

	include "include/db.inc.php";

//	form data provider:

	include "include/k.inc.php";

//	database communication functions:

	include "include/dbQuery.inc.php";



// ************************************ 



// ************************************

//	DECLARE VARIABLES

	$pageOut = "";

	$battery = array();

	$i = 0;

	$j = 0;

	$count = 1;

// ************************************



// ************************************

//	CHECK TO SEE IF SESSION IS VALIDATED

	if ($session == 1) {

// ************************************



$query_string = "";

if ($_GET) {

	$kv = array();

	foreach ($_GET as $key => $value) {

		global $$key;

		$$key = $value;

		$kv[] = "$key=$value";

  		}

  	$query_string = join("&", $kv);

	}





$fields 		= "patient.patientFirst,patient.patientLast,patient.dateOfBirth,patient.chartNum,patient.sex,patient.zipCodeHome,patient.zipCodeWork";

$tables 		= "patient";

$conditions 	= "patientID = $patientID";

$sort			= "";



// dbQuery($dbconn,$mode,$column,$table,$values,$condition,$sort)

$temp = dbQuery($conn,"S",$fields,$tables,"",$conditions,$sort);

?>



<html>

<head>

<title> </title>

<META NAME="MS.LOCALE" CONTENT="CS">

<META HTTP-EQUIV="Content-Type" Content="text/html;  charset=Windows-1250">

<link rel="stylesheet" href="styles.css" type="text/css">

<script type=text/javascript src="include/utilities.js"></script>

<style type="text/css">

<!--

td {font-family: Arial, Helvetica, sans-serif;font-size: 12px;}

-->

</style>

</head>

<body bgcolor="#FFFFFF" text="#000000">

<center>



<!-- START HEADER -->

<p>

<img src="i/breatheclear_logo.jpg" width="326" height="75"><br>
<center class="style1">310.372.0700<br>
http://www.bcimmunicenters.com</center>
<br>




<?php



// ****************************

//	GENERATE SESSION VARIABLE

$alphanum = array("A","B","C","D","E","F","G","X","Y","Z","1","2","3","4","5","6","7","8","9","0");

$random = "";

for ($z=1; $z<10; $z++) {

	$r = (rand()%20)-1;

	$random .= $alphanum[$r];

	}



// display patient list link

echo "<a href='allergenform.php?session=$random' style='font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold; text-decoration:none'>Patient List</a>

</p>

<!-- END HEADER -->";

// ****************************



// ************************************

//	DISPLAY PATIENT INFO

if ($temp>0 || $temp>"") {

	while(list($patient_patientFirst,$patient_patientLast,$patient_dateOfBirth,$patient_chartNum,$patient_sex,$patient_zipCodeHome,$patient_zipCodeWork)=mysql_fetch_array($temp)) { 

		echo "<table cellpadding=3 cellspacing=0 border=0 bgcolor='#D2D2D2' width=330>

		<tr><td colspan=2 align='center'><font face='arial' size=1><b>ENTRY RECORD</b></font></td></tr>

		<tr><td width=200>Patient Name:</td>	<td><b>$patient_patientFirst $patient_patientLast</b></td></tr>

		<tr><td width=200>DOB:</td>				<td><b>$patient_dateOfBirth</b></td></tr>

		<tr><td width=200>Gender:</td>			<td><b>$patient_sex</b></td></tr>

		<tr><td width=200>Home ZIP Code:</td>	<td><b>$patient_zipCodeHome</b></td></tr>

		<tr><td width=200>Work ZIP Code:</td>	<td><b>$patient_zipCodeWork</b></td></tr>

		<tr><td width=200>Chart Number:</td>	<td><b>$patient_chartNum</b></td></tr>

		</table>

		<br><br>
		
		(7 or > = Positive allergy)";

		}

	}



// ************************************







// ************************************

//	GET BATTERY AND TOTAL ALLERGENS

$fields 		= "batteryName, count( allergenID ) AS numAllergens";

$tables 		= "allergens GROUP BY batteryName";

$conditions 	= "";

$sort			= "";



$temp = dbQuery($conn,"S",$fields,$tables,"",$conditions,$sort);

if ($temp>0 || $temp>"") {

	while(list($allergens_battery,$allergens_numAllergens)=mysql_fetch_array($temp)) { 

		$battery[$i] = array($allergens_battery => $allergens_numAllergens);

		// DEBUG

		// $test = $allergens_battery;

		// echo $i.") $test = ".$battery[$i][$test]."<br />";

		$i++;

		}// end while

	}// end if

// ************************************







// ************************************

//	GET ALL ALLERGENS FOR FORM

$fields 		= "allergens.allergenID,allergens.antigenName,allergens.batteryName,allergens.site";

$tables 		= "allergens";

$conditions 	= "";

$sort			= "allergens.batteryName, allergens.site";



// dbQuery($dbconn,$mode,$column,$table,$values,$condition,$sort)

$temp = dbQuery($conn,"S",$fields,$tables,"",$conditions,$sort);





// ************************************

//	GET PATIENT'S ANALYSIS



$fields 		= "al.allergenID, al.antigenName, an.MSPScore, an.ITScore, an.validated";

$tables 		= "allergens al LEFT JOIN analysis an ON an.allergenID = al.allergenID";

$conditions 	= "an.patientID=$patientID AND an.analysisCount=$analysisCount";

$sort			= "al.groupID, al.antigenName";



// dbQuery($dbconn,$mode,$column,$table,$values,$condition,$sort)

$temp2 = dbQuery($conn,"S",$fields,$tables,"",$conditions,$sort);



// assign analysis results to an array

if ($temp2>0 && $temp2>"") {

	$analysisResults = array();

	while(list($analysis_allergenID,$analysis_antigenName,$analysis_MSPScore,$analysis_ITScore,$analysis_validated) = mysql_fetch_array($temp2)) { 

		//if ($analysis_MSPScore=="") { $analysis_MSPScore="0"; }

		//if ($analysis_ITScore=="") { $analysis_ITScore="0"; }

		$analysisResults[intval($analysis_allergenID)] = $analysis_MSPScore.",".$analysis_ITScore.",".$analysis_validated;

		// DEBUG

		// echo $analysis_allergenID."=".$analysisResults[intval($analysis_allergenID)]."<br>";

		}// end while

	}// end if





if ($temp>0 || $temp>"") {

	$i = 0;

	echo "<table border=0 cellpadding=5 cellspacing=0 width=500>

			  <tr bgcolor='#D2D2D2'>

			  	<td><b>Allergen</b></td>

			  	<td><b>Multitest Skin Prick<br>Wheal (mm)</b></td>

				<td><b>Intradermal Test<br>Wheal (mm)</b></td>

				<td><b>Confirmed</b></td>

			  </tr>";

	$alternate=1; // for alternating gray and white colored rows


	$fontEnd = "</font>";
	while(list($allergens_allergenID,$allergens_antigenName,$allergens_batteryName,$allergens_site)=mysql_fetch_array($temp)) {  

		if ($alternate==0) { 

			$bgcolor = "bgcolor='#D2D2D2'"; 

			$alternate=1;

			}

		else { 

			$bgcolor = ""; 

			$alternate = 0;

			}

		

		$scoreSet = explode(",",$analysisResults[$allergens_allergenID]); 

		if ($scoreSet[0] >= 7 || $scoreSet[1] >= 7) {
			$font = "<font  color='red'>";
		}else{
			$font = "<font  color='black'>";
		}
		
		echo "<tr $bgcolor>

			  <td> $font ".$allergens_antigenName."$fontEnd </td>

			  <td>$font ";

				if ($scoreSet[0] == "" || $scoreSet[0] == NULL) {

					echo "0";

					}

				else { echo $scoreSet[0]; }

		echo "$fontEnd </td><td>$font ";

				if ($scoreSet[1] == "" || $scoreSet[1] == NULL) {

					echo "0";

					}

				else { echo $scoreSet[1]; }

		echo "$fontEnd</td><td>$font ";		

				if ($scoreSet[2] == "" || $scoreSet[2] == NULL) {

					echo "False";

					}

				else { 

					//echo $scoreSet[2]; 

					if ( $scoreSet[2] == 1 ) { echo "True"; }

					else { echo "False"; }

					}

		echo "$fontEnd</td></tr>";

		}// end while

		

		echo "</table>";

	}

else { echo "No form defined"; }

// ************************************



dbClose();



?>

<br>







</center></body>

</html>



<?php

}



// ************************************

//	SESSION IS NOT VALIDATED

else {echo "no session";}

// ************************************

?>

