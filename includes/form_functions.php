<?php
require_once("config.php");
function mysql_prep($value){

	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysql_real_escape_string"); //i.e. PHP >= v4.3.0
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	if ($new_enough_php){ //i.e. PHP  v4.3.0 or higher
		//undo any magic quote effects so msqk_real_escape_string can do the work
		if($magic_quotes_active){
		  $value = stripslashes($value);

		}
		 // mysql_real_escape_string — Escapes special characters in a string for use in an SQL statement
		$value = mysqli_real_escape_string($connection,$value);

	} else{//before PHP  v4.3.0  
			if(!$magic_quotes_active){
				$value = addslashes($value);
			}
		}

	return ($value);
}
	//----------------------------
	//function checkRequiredFields
	//----------------------------
	function checkRequiredFields($menuItems){
		$errors = array();
		foreach($menuItems as $value){
			//Form validation
			if (!isset($_POST[$value]) || (empty($_POST[$value])&& !is_numeric($_POST[$value]))){
				$errors[] = $value;
				
			}
		}
		return $errors;
	}
	//----------------------------
	//function checkZip
	//----------------------------
	function checkZip($value){
	    $errors = array();
	    if(!empty($value)){
	      if (!is_numeric($value)){
		  $errors[] = "Zip code must be Numeric";
		}
	    }
	    return $errors;
	}
	//----------------------------
	//function checkGroupID
	//----------------------------
	function checkGroupID($value){
	    $errors = array();
	    if(!empty($value)){
	      if (!is_numeric($value)){
		  $errors[] = "Group ID must be Numeric i.e. 1,2,3,4,5";
		}
	       else{
		 if ($value < 1 || $value > 5){
		  $errors[] = "Group ID must be between 1 and 5";
		 }
	       }
	    }
	    return $errors;
	}
	//----------------------------
	//function checkMaxFieldLengths
	//----------------------------
	function checkMaxFieldLengths($fieldLengthArray){
		$errors = array();
		foreach($fieldLengthArray as $value => $maxlength){
			//Form validation
			if (strlen(trim(mysql_prep($_POST[$value]))) > $maxlength){
				$errors[] = $value;
			}
		}
		return $errors;
	}
	//----------------------------
	//function checkEmail
	//----------------------------
	function checkEmail($email){
		$errors = array();
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$errors[] = $email.' email is invalide. ';
		}
		return $errors;
	}
	//----------------------------
	//function displayErrors
	//----------------------------
	function displayErrors($errorArray){
		echo "<p class=\"errors\">";
 		foreach($errorArray as $value => $error){
			echo " - " . $error . "<br/>";	
		}
		echo "</p>";
	}
	//----------------------------
	//function checkHiLowScore
	//----------------------------
	function checkHiLowScore($mspscore,$itscore,$twoWhl){
		if ($mspscore == 7 || $mspscore == 8){
		    if ($twoWhl >= 9){
			return "hi";
		    }else{
			return "low";
		    }
		}elseif ($mspscore >= 9 || $itscore >= 7){
		    return "hi";
		}else{
		    return null;	
		}
	}
?>