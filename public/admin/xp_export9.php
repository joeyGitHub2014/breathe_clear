<?php
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=export.csv");

// ************************************
//	LOAD MAIN FUNCTIONS FIRST
//	security:
	include "include/s.inc.php";
//	database:
	include "include/db.inc.php";
//	database communication functions:
	include "include/dbQuery.inc.php";
//  page layout
	include "include/XMLtoObject.inc.php";
// ************************************ 

// ************************************
//	DECLARE VARIABLES
	$out 				= "Last Name,First Name,Chart#,Analysis Date,"; // begin column headers
	$allergens 			= array();
	$patAllergens 		= array();
	
	$msp				= array();
	$it					= array();
	$validatedOut		= "";
	
	$patients			= array();
	$allergenCount 		= 0;
	$patientCount		= 0;
	$patAllergenCount 	= 0;
	$matched			= 0;
// ************************************

// ************************************
//	CHECK TO SEE IF SESSION IS VALIDATED
	if ($session == 1) {
// ************************************

/*
1. get a list of all allergens in the database and their respective IDs and put into an array:
SELECT allergenID, antigenName, groupID
FROM allergens
ORDER BY groupID ASC
*/

$fields 		= "allergenID, antigenName, groupID";
$tables 		= "allergens";
$conditions 	= "";
$sort			= "groupID, antigenName";

// dbQuery($dbconn,$mode,$column,$table,$values,$condition,$sort)
$temp = dbQuery($conn,"S",$fields,$tables,"",$conditions,$sort);
$numReturnedAllergens = mysql_num_rows($temp);

if ($temp>0 || $temp>"") {
	while(list($allergenID, $antigenName, $groupID)=mysql_fetch_array($temp)) {  
		// add the rest of the column headers for each antigen
		$allergens[$allergenCount] = array($allergenID, $antigenName, $groupID, "0,");
		$out .= $antigenName." MSP, ";
		$out .= $antigenName." IT, ";
		$out .= $antigenName." Confirmed";
		if ($numReturnedAllergens-1>$allergenCount) { $out .= ","; }
		$allergenCount++;
		}// end while
	}// end if

echo $out."\n";

/*
2. get a distinct list of patients with patient ID

select an.patientID,pa.patientLast,pa.patientFirst,an.analysisCount, an.dateAdded 
from analysis an inner join patient pa on pa.patientID = an.patientID group by an.patientID, an.analysisCount
order by pa.patientLast
*/

$fields 		= "pa.patientID,pa.patientLast,pa.patientFirst,pa.chartNum,an.analysisCount,an.dateAdded";
$tables 		= "analysis an inner join patient pa on pa.patientID = an.patientID 
				   group by an.patientID, an.analysisCount";
$conditions 	= "";
$sort			= "pa.patientLast";

// dbQuery($dbconn,$mode,$column,$table,$values,$condition,$sort)
$temp2 = dbQuery($conn,"S",$fields,$tables,"",$conditions,$sort);
if ($temp2>0 || $temp2>"") {
	while(list($patientID,$patientLast,$patientFirst,$chartNum,$analysisCount,$dateAdded)=mysql_fetch_array($temp2)) {  
		echo "$patientLast, $patientFirst, $chartNum, $dateAdded, ";
		for ($i=0; $i<$numReturnedAllergens; $i++) {
			//$patAllergens[$i] = 0;
			//$msp[$i] = 0;
			//$it[$i] = 0;
			}
/*
3. for each record returned use the patientID and the analysis count to get all recorded allergens for that patient

SELECT al.allergenID, al.antigenName, an.severity
FROM allergens al LEFT JOIN analysis an ON an.allergenID = al.allergenID
WHERE an.patientID =15 AND an.analysisCount =0
ORDER BY al.groupID ASC
*/


		$fields 		= "al.allergenID, al.antigenName, an.MSPScore, an.ITScore, an.validated ";
		$tables 		= "allergens al LEFT JOIN analysis an ON an.allergenID = al.allergenID";
		$conditions 	= "an.patientID = $patientID AND an.analysisCount = $analysisCount";
		$sort			= "al.groupID, al.antigenName";

		// dbQuery($dbconn,$mode,$column,$table,$values,$condition,$sort)
		$temp3 = dbQuery($conn,"S",$fields,$tables,"",$conditions,$sort);
		$numReturnedAnalysis = mysql_num_rows($temp3);

		$arrAllergenID = array($numReturnedAnalysis);
		$arrAntigenName = array($numReturnedAnalysis);
		$arrMSPScore = array($numReturnedAnalysis);
		$arrITScore = array($numReturnedAnalysis);
		$arrValidated = array($numReturnedAnalysis);

		if ($temp3>0 || $temp3>"") {
			$cnt = 0;
			while(list($allergenID, $antigenName, $MSPScore, $ITScore, $validated)= mysql_fetch_array($temp3)) {
				$arrAllergenID[$cnt] 	= $allergenID;
				$arrAntigenName[$cnt]	= $antigenName;
				$arrMSPScore[$cnt]	= $MSPScore;
				$arrITScore[$cnt]		= $ITScore;
				$arrValidated[$cnt]	= $validated;
				$cnt++;
				}// end while
			}// end if


			// create a loop to go 
			// through all of the
			// allergens in the DB

			for ($x=0; $x<=$allergenCount; $x++) {
				// DEBUG
				// echo $x."/".$allergenCount."<br>";

				// start going through
				// the list of returned
				// antigens from analysis

				$match = 0;
				//while(list($allergenID, $antigenName, $MSPScore, $ITScore, $validated)=mysql_fetch_array($temp3)) { 
 
				for ($z=0; $z<=$cnt; $z++) {
					// check the loaded allergen with all allergens from the database

					if ($allergens[$x][0] == $arrAllergenID[$z]) { // a score for the allergen was saved
						//$patAllergens[$x] = $severity; 
						//$msp[$x] = $MSPScore;
						//$it[$x] = $ITScore;
						$match = 1;

						if ($arrMSPScore[$z] > "" || $arrITScore[$z] > "") {
							if ($arrMSPScore[$z] == "") { $arrMSPScore[$z] = 0; }
							if ($arrITScore[$z] == "") { $arrITScore[$z] = 0; }
							if ($arrValidated[$z] == 1) { $arrValidatedOut[$z] = "Yes"; } else { $arrValidatedOut[$z] = "No"; }

							echo $arrMSPScore[$z].",".$arrITScore[$z].",".$arrValidatedOut[$z];
							}// end if

						}// end if

					}// end for

				if ($match < 1) { // a score for the allergen was NOT saved
					echo "0,0,NA"; 
					}

				if ($x < $allergenCount) { 
					echo ","; 
				
					}

				}// end for

			echo "\n";


		//$allergenString = join(",", $msp);
		//$allergenString = join(",", $it);
		//echo $allergenString."\n";
		//echo "\n";
		$patientCount++;
		}// end while
	}// end if



}

// ************************************
//	SESSION IS NOT VALIDATED
else {echo "no session";}
// ************************************
?>