<?php
    require_once("../../includes/initialize.php");
    if (!$session->is_logged_in()){
      redirectTo("login.php");
    }
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
    $email="";
    $id = "";
    if (isset($_GET['id'])){ 
		if (empty($_GET['id'])){
			$session->message("Patient not found.");
			redirectTo("list_patient.php");
		}else{
				$patient = new Patient();
				$patient::set_patient_table();
				$patient_list = $patient->find_by_patientID($_GET['id']);
				if (!empty($patient_list)){
				$firstname = $patient_list->patientFirst;
				$lastname= $patient_list->patientLast;
				$dateofbirth= $patient_list->dateOfBirth;
				$chartnumber = $patient_list->chartNum;
				$homezip = $patient_list->zipCodeHome;
				$workzip= $patient_list->zipCodeWork;
				$sex   = $patient_list->sex;
				$tester = $patient_list->tester;
				$email = $patient_list->email;
				$id = $patient_list->patientID;
			}else{
				$session->message("No information found on patient.");
				redirectTo("list_patient.php");
			}
		}
    }elseif (isset($_POST['submit'])){
		$errors = array();
		$items = array('firstname','lastname','chartnumber');
		$errors =  array_merge($errors, checkRequiredFields($items,$_POST));
		$errors =  array_merge($errors, checkZip($_POST['homezip']));
		$errors =  array_merge($errors, checkZip($_POST['workzip']));

		$fieldLengthArray = array('firstname' => 50, 'lastname' => 50, 'chartnumber' => 10);
		$errors =  array_merge($errors, checkMaxFieldLengths($fieldLengthArray,$_POST));
	if (empty($errors)){
		$patient = new Patient();
		$patient::set_patient_table();
		$patient->patientLast = trim(mysql_prep($_POST['lastname']));
		$patient->patientFirst = trim(mysql_prep($_POST['firstname']));
		$patient->chartNum = trim(mysql_prep($_POST['chartnumber']));
		$patient->dateOfBirth = trim(mysql_prep($_POST['dateofbirth']));
		$patient->sex =  trim(mysql_prep($_POST['sex']));
		$patient->zipCodeHome  =trim(mysql_prep($_POST['homezip']));
		$patient->zipCodeWork = trim(mysql_prep($_POST['workzip']));
		$patient->email = trim(mysql_prep($_POST['email']));
		$patient->tester  = trim(mysql_prep($_POST['tester']));
		$patient->patientID  = trim(mysql_prep($_POST['id']));
		if ($patient->update()){
			// Success
			$session->message("Patient was successfully updated.");
			$send_to = "update_patient.php?id=".$patient->patientID;
			redirectTo($send_to);
		}else{
			// failed
			$session->message("Patient update failed. Nothing may not have been changed.");
			$send_to = "list_patient.php";
			redirectTo($send_to);
		}
	}else{  //Errors
		
		if (count($errors) == 1){
			$message =  "There was 1 error in the form:  ".$errors[0]. " my have been blank.";
		}else{
			$message =  "There were ". count($errors) . " errors in the form";
		}
		$session->message($message);
		$patient->patientID  = trim(mysql_prep($_POST['id']));
		$send_to = "update_patient.php?id=".$patient->patientID;
		redirectTo($send_to);
	}
    }
?>
<?php inlcudeLayoutTemplet('admin_header.php');?>
	<h2 class="title"> Edit Patient Information </h2>
	</br>
	<section class ="patientInfo">
	<form id="frm_patient" action="update_patient.php" method ="post">
	<table>
	<tr>
	    <td><input type="submit"  name ="submit" value ="Update Patient" /></td>
	</tr>

	<tr>

	    <td>
                <?php if (!empty($message) ){echo "<p class=\"message\">". $message . "</p>";}?>
                <?php if (!empty($errors) ){ displayErrors($errors); }?>

		<div class="col1">

                <p> Firstname:   
                    <input type="text" name="firstname"     maxlength="50" value="<?php echo htmlentities($firstname)?>" />
		</p>
		<p>
                    Lastname:  
                    <input type="text" name="lastname"    maxlength="50" value="<?php echo htmlentities($lastname)?>" />
		</p>
		<p>Date Of Birth: 
                    <input type="date" name="dateofbirth"     maxlength="20" value="<?php echo htmlentities($dateofbirth)?>" />
		</p>
		<p>
		Chart Number:
                    <input type="text" name="chartnumber"    maxlength="10" value="<?php echo htmlentities($chartnumber)?>" />
                </p>
		</div>
		<div class="col2">
                <p>Home ZIP:
                    <input type="text" name="homezip"     maxlength="10" value="<?php echo htmlentities($homezip)?>" />
		     </p>
                     <p>Work ZIP:
                    <input type="text" name="workzip"    maxlength="10" value="<?php echo htmlentities($workzip)?>" />
		     </p>
                     <p>Sex:
                    <select name="sex" >
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
                <p> Tester:   
                    <input type="text" name="tester"     maxlength="50" value="<?php echo htmlentities($tester)?>" />
		    </p>
		    <p> 
		    Email:
		    <input type="text" name="email"     maxlength="100" value="<?php echo htmlentities($email)?>" />
		    <input type="hidden" name="id"     value="<?php echo htmlentities($id)?>" />
                </p>
		</div>
            </td>
	</tr>
	</table>
	</section>
        </form>
	
        <p>&nbsp</p>
    </div>
<?php inlcudeLayoutTemplet('footer.php');?>

    