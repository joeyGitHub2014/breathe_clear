<?php
require_once("../../includes/initialize.php");
$message ="";
if ($session->is_logged_in()){
    redirectTo("index.php");
}

if(isset($_POST['submit'])){
    $username = trim( $_POST['username'] );
    $password = trim( $_POST['password'] );
    // check database to see if username/password exist
    User::set_user_table();
    $hashed_username = md5($username);
    $hashed_password = md5($password);
    $found_user = User::authenticate($hashed_username, $hashed_password);
    if ($found_user){
        $session->login($found_user);
        logAction("Login: ","{$username} logged in.");
        redirectTo("index.php");
    }else{
        $message = "Username/Password combination incorrect";
    }
}else{
    echo "<p>OUT SUBMIT</p>";
    $username = "";
    $password = "";
}
?>
     <?php inlcudeLayoutTemplet('header.php');?>
        <h2 class="header" > Staff Login</h2>
        &nbsp
        <?php echo outputMessage($message, 'red'); ?>
        <form action="login.php"  method ="post">
            <table style="padding-left:20px">
                <tr>
                   <td style="color:#000">Username:</td>
                   <td>
                       <input type="text" name="username"   required  maxlength="30" value="<?php echo htmlentities($username);?>" />
                   </td>
                </tr>
                <tr> 
                    <td style="color:#000">Password:</td>
                    <td>
                       <input type="password" name="password"  required  maxlength="30" value="<?php echo htmlentities($password);?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit"  name ="submit" value ="Login" />
                    </td>
                </tr>
            </table>
        </form>
<?php inlcudeLayoutTemplet('footer.php');

var_dump(PDO::getAvailableDrivers());
?>
