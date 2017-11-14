<?php
    require_once("../../includes/initialize.php");
     if (!$session->is_logged_in()){
      redirectTo("login.php");
    }
include_once("../../includes/form_functions.php");
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=export.csv");
$out  = "Last Name,First Name,Chart#,Analysis Date,";
$validatedOut	= "";
$allergenCount 	= 0;
$patientCount	= 0;
$patAllergenCount = 0;
$matched	  = 0;
/*
1. get a list of all allergens in the database and their respective IDs and put into an array:
SELECT allergenID, antigenName, groupID
FROM allergens
ORDER BY groupID AS
*/
$sql = "SELECT allergenID, antigenName, groupID, lotNumber, expDate FROM allergens1 ";
$sql .= " ORDER BY groupID ASC";
Allergen::set_allergen_table();
$allergen_list = Allergen::find_by_sql($sql);
$numReturnedAllergens = Allergen::count_all();
foreach($allergen_list as $key => $allergen){
    $out .= $allergen->antigenName." MSP, ";
    $out .= $allergen->antigenName." IT, ";
    $out .= $allergen->antigenName." Confirmed,";
    $out .= $allergen->antigenName." Lot Number,";
    $out .= $allergen->antigenName." Exp date";
    if ($numReturnedAllergens-1>$allergenCount) {
	$out .= ",";
	}
    $allergenCount++;
} 
echo  $out."\n";
/*
2. get a distinct list of patients with patient ID
select an.patientID,pa.patientLast,pa.patientFirst,an.analysisCount, an.dateAdded 
from analysis an inner join patient pa on pa.patientID = an.patientID group by an.patientID, an.analysisCount
order by pa.patientLast
*/
    $sql = "SELECT pa.patientID,pa.patientLast,pa.patientFirst,pa.chartNum,an.analysisCount,an.dateAdded";
    $sql  .= " FROM analysis an ";
    $sql .= " INNER JOIN patient pa ON pa.patientID = an.patientID ";
    $sql .= " GROUP BY an.patientID, an.analysisCount";
    $sql .= " ORDER BY pa.patientLast";
    //Analysis::set_table_fields();
    //$analysis_list = Analysis::find_by_sql($sql);
    $result_set  = $database->query($sql);
    while($row = $database->fetch_array($result_set)){
        echo "{$row['patientLast']}, {$row['patientFirst']}, {$row['chartNum']}, {$row['dateAdded']}, ";
	/*3. for each record returned use the patientID and the analysis count to get all recorded allergens for that patient
	SELECT al.allergenID, al.antigenName, an.severity
	FROM allergens al LEFT JOIN analysis an ON an.allergenID = al.allergenID
	WHERE an.patientID =15 AND an.analysisCount =0
	ORDER BY al.groupID ASC
	*/
	 $sql = "SELECT al.allergenID, al.antigenName, al.lotNumber, al.expDate, an.MSPScore, an.ITScore, an.validated FROM allergens1 al ";
	 $sql .= " LEFT JOIN analysis an ON an.allergenID = al.allergenID";
	 $sql .= " WHERE an.patientID = {$row['patientID']} AND an.analysisCount = {$row['analysisCount']}";
	 $sql .= " ORDER BY al.groupID, al.antigenName";
	 $analysis_result = $database->query($sql);
	 $cnt = 0;
	  while($analysis_row = $database->fetch_array($analysis_result)){
		$arrAllergenID[$cnt] = $analysis_row['allergenID'];
		$arrAntigenName[$cnt]= $analysis_row['antigenName'];
		$arrMSPScore[$cnt]	= $analysis_row['MSPScore'];
		$arrITScore[$cnt]	= $analysis_row['ITScore'];
		$arrValidated[$cnt]	= $analysis_row['validated'];
		$arrLotNum[$cnt]	= $analysis_row['lotNumber'];
		$arrExpDate[$cnt]	= $analysis_row['expDate'];
		$cnt++;
	    }
	 $x = 0;
	 foreach($allergen_list as $key => $allergen){
	    $match = 0; 
	    for ($i = 0; $i <= $cnt-1; $i++){
	    // check the loaded allergen with all allergens from the database
		if ($arrAllergenID[$i]  == $allergen->allergenID) {
		    // a score for the allergen was saved
		    $match = 1;
		     if ($arrMSPScore[$i] > "" || $arrITScore[$i] > "") {
			   if ($arrMSPScore[$i]== "") {
			       $arrMSPScore[$i] = 0;
			    }
			    if ($arrITScore[$i] == "") {
				$arrITScore[$i] = 0;
			    }
			    if ($arrValidated[$i] == 1) {
				$yesNo = "Yes"; } else {$yesNo = "No";
			    }
			    echo "{$arrMSPScore[$i]},{$arrITScore[$i]},{$yesNo},{$arrLotNum[$i]},{$arrExpDate[$i]}";
			    } 
		} 
	    }  
	    if ($match < 1) {  
		    echo "0,0,NA,NA,NA";
	    }
	    $x += 1; 
	     if ($x < $allergenCount) {
		echo ",";
	    }
	}
	 echo "\n";
	 $patientCount++;
     }
?>