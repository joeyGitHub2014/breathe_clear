<?php
    require_once("../../includes/initialize.php");
    if (!$session->is_logged_in()){
      redirectTo("login.php");
    }
 ?>
<?php
include_once("../../includes/form_functions.php");
$firstname ="";
$lastname = "";
$dateofbirth ="";
$chartnumber = "";
$homezip ="";
$workzip = "";
$tester  = "";
$treatment = 1;
$sex ="";
$email = "";
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['submit'])){
	$errors = array();
    $items = array('firstname','lastname','chartnumber','dateofbirth');
    $errors =  array_merge($errors, checkZip($_POST['homezip']));
    $errors =  array_merge($errors, checkZip($_POST['workzip']));
    $errors =  array_merge($errors, checkRequiredFields($items,$_POST));
    $fieldLengthArray = array('firstname' => 50, 'lastname' => 50, 'chartnumber' => 10);
    $errors =  array_merge($errors, checkMaxFieldLengths($fieldLengthArray,$_POST));
	if (!empty($_POST['email'])){
		$errors =  array_merge($errors, checkEmail($_POST['email']));
 	}
    if (empty($errors)){
		$patient = new Patient();
		$patient->set_patient_table();
		$patient->patientLast = trim(mysql_prep($_POST['lastname']));
		$patient->patientFirst = trim(mysql_prep($_POST['firstname']));
		$patient->chartNum = trim(mysql_prep($_POST['chartnumber']));
		$patient->dateOfBirth = trim(mysql_prep($_POST['dateofbirth']));
		$patient->sex =  trim(mysql_prep($_POST['sex']));
		$patient->zipCodeHome  =trim(mysql_prep($_POST['homezip']));
		$patient->zipCodeWork = trim(mysql_prep($_POST['workzip']));
		$patient->email = trim(mysql_prep($_POST['email']));
		$patient->tester  = trim(mysql_prep($_POST['tester']));
		date_default_timezone_set('America/Los_Angeles');
		$dt = time();
		// my sql formate my sql understands
		$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S",$dt);
		$patient->dateAdded  = $mysql_datetime;
		if ($patient->create()){
			// Success
			$sql = " SELECT patientID FROM patient ";
			$sql .= " WHERE dateAdded = '{$patient->dateAdded}'  ";
			$sql .= " LIMIT 1";
			$idArray = $patient::find_by_sql($sql);
			$id =  $idArray[0]->patientID;
			/******************/
			Allergen::set_allergen_table();
			$sql  = " SELECT allergenID FROM allergens1";
			$sql .= " WHERE disabled != 1 ";
			$sql .= " ORDER BY batteryName  ASC, site  ASC ";
			$allergen_list = Allergen::find_by_sql($sql);
			$allergen_allergenIDs = array();

			foreach ($allergen_list as $key ){
				$arr1 = array('allergenID' => $key -> allergenID  );
				array_push ($allergen_allergenIDs, $arr1);
			}
			$analysisCount = 1;
			$treatment = 0;
			$analysis = new Analysis();
			$analysis::set_analysis_table();

			date_default_timezone_set('America/Los_Angeles');
			$dt = time();
			$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S",$dt);

			foreach($allergen_allergenIDs as  $key=>$value ) {
				$analysis->allergenID = $allergen_allergenIDs[$key]['allergenID'];
				$analysis->analysisCount = $analysisCount;
				$analysis->patientID = $id;
				$analysis->MSPScore = 5;
				$analysis->ITScore = 5;
				$analysis->dateAdded = $mysql_datetime;
				$analysis->treatment = $treatment;
				$analysis->dilutionLevel = 0;
				$analysis->twoWhl = 0;
				$analysis->refill = 0;
				$analysis->validated =  0;
				if (!$analysis->create()) {
					$session->message("ERROR: Could not create Analysis record.");
					redirectTo('add_patient.php');
				}
			}
			$send_to = "update_entry_record.php?id=" .$id."&aCnt=".$analysisCount."&treat=".$treatment;
			redirectTo($send_to);
			$session->message("Patient and Analysis was successfully created!!");

		}else{
			// failed
			$message =  "Patient creation failed.";
			$message .= "<br/>" . mysqli_error();
		}
    }else{  //Errors
		if (count($errors) == 1){
			$message =  "There was 1 error in the form";
		}else{
			$message =  "There were ". count($errors) . " errors in the form";
	}
	$firstname =$_POST['firstname'];
	$lastname = $_POST['lastname'];
	$dateofbirth =$_POST['dateofbirth'];
	$chartnumber = $_POST['chartnumber'];
	$homezip = $_POST['homezip'];
	$workzip = $_POST['workzip'];
	$tester = $_POST['tester'];
	$email = $_POST['email'];
    }
}
else{
	$firstname ="";
	$lastname = "";
	$dateofbirth ="";
	$chartnumber = "";
	$homezip ="";
	$workzip = "";
	$tester  = "";
	$email  = "";
	$treatment = 0;
}
?>
<?php inlcudeLayoutTemplet('admin_header.php');?>
	<h2 class="title"> Add Patient </h2>
	</br>
	<section class="patientInfo">
	<div class="titlebox"><span><b>Add Patient</b></span></div>
	    <form action="add_patient.php" method ="post">
		<?php if (!empty($message) ){echo "<p>";  outputMessage($message, 'red'); echo  "</p>";}?>
		<?php if (!empty($errors) ){ displayErrors($errors); }?>
		<p>
		<input type="submit"  name ="submit" value ="Add Patient" />
		</p>
		<table>
		<tr>
		<td>
		<div class="col1">
		    <p>
		    <lable>Firstname:    </lable >
		    <input type="text" name="firstname"     maxlength="50" value="<?php echo htmlentities($firstname)?>" />
		    <p>
		    Lastname:  
		    <input type="text" name="lastname"    maxlength="50" value="<?php echo htmlentities($lastname)?>" />
		    </p>
		    <p> 
		    Date Of Birth: 
		    <input type="date" name="dateofbirth"     maxlength="20" value="<?php echo htmlentities($dateofbirth)?>" />
		    </p>
		    <p>
		    Chart Number:
		    <input type="text" name="chartnumber"    maxlength="10" value="<?php echo htmlentities($chartnumber)?>" />
		    </p>
		</div>
		<div class="col2">
		    <p>Home ZIP:
		    <input type="text" name="homezip"     maxlength="5" value="<?php echo htmlentities($homezip)?>" />
		    </p>
		    <p>
		     Work ZIP:
		    <input type="text" name="workzip"    maxlength="5" value="<?php echo htmlentities($workzip)?>" />
		    </p>
		    <p>
		    Sex:
		    <select name="sex" >
		    <option name="male" value="M">M</option>
		    <option name="female" value="F">F</option>
		    </select>
		    </p>
		    <p > Tester:   
		    <input type="text" name="tester"     maxlength="50" value="<?php echo htmlentities($tester)?>" />
		    </p>
		    <p> 
		    Email:
		    <input type="text" name="email"     maxlength="100" value="<?php echo htmlentities($email)?>" />
		    </p>
		</div>
		</td>
		</tr>
		</table>
	    </form>
	</section>
        <p>&nbsp</p>
    </div>
	<?php inlcudeLayoutTemplet('footer.php');?>

    