<?php  require_once("../../includes/initialize.php"); ?>
<?php  include_once("../../includes/form_functions.php"); ?>
<?php     if (!$session->is_logged_in()){
      redirectTo("login.php");
    };?>
<?php
	if(isset($_POST['submit'])){
		$errors = array();
		$items = array('username','password');
		$errors =  array_merge($errors, checkRequiredFields($items,$_POST));
		$fieldLengthArray = array('username' => 30, 'password' => 30 );
		$errors =  array_merge($errors, checkMaxFieldLengths($fieldLengthArray,$_POST));
		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		// creates a 40/32? char long encrpted string
		$hashed_password = md5($password);
		$hashed_username = md5($username);
		if (empty($errors)){
		        $user = new User();
				$user::set_user_table();
                        if ($user->haveUser($hashed_username)){;
			    $message =  "User ".$username." already exsits. Please enter a new user.";
                        }else{
                            $user->u1 = $hashed_username;
                            $user->p2  = $hashed_password;
                            // Perform Update
                            if ($user->create()){
                                    // Success
                                    $message =  "User was successfully created.";
                            }else{
                                    // failed
                                    $message =  "User creation failed.";
                                    $message .= "<br/>" . mysql_error();
                            }
                        }
		}else{  //Errors
			if (count($errors) == 1){
				$message =  "There was 1 error in the form";
			}else{
				$message =  "There were ". count($errors) . " errors in the form";
			}
		}
	}else{
		$username ="";
		$password = "";
		
	}
?>
<?php inlcudeLayoutTemplet('admin_header.php');?>
        <h2 class="title"> Create New User </h2>
	<table CLASS ="general">
		<tr>
		<td id = "page">
		<?php if (!empty($message) ){echo "<p class=\"message\">". $message . "</p>";}?>
		<?php if (!empty($errors) ){ displayErrors($errors); }?>
		<form action="new_user.php" method ="post">
		<p>Username:
		    <input type="text" name="username"     maxlength="30" value="<?php
			echo htmlentities($username)?>" />
		    </p>
                    <p>Password:
                            <input type="text" name="password"    maxlength="30" value="<?php
                            echo htmlentities($password)?>" />
                    </p>
                            <input type="submit"  name ="submit" value ="Create User" />
		</form>
		<br/>
		</td>
		</tr>
	</table>
    </div>
<?php inlcudeLayoutTemplet('footer.php');?>

