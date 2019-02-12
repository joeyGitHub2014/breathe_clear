<?php

    require_once("../../includes/initialize.php");
    $encryptData  = new EncryptPatientInfo;

     $encryptData::loadData();

	$query_string_post = "";
	$query_string_get = "";
	$process="";
    $key = 'a2d9gsdgSt^!3fdndf^&5gdgdsgFe23879456y#@109w6';
    $crypted_token;
    $firstnameEnc = ""; 
    $lastnameEnc ="" ; 
    $sexEnc     ="" ;  
    $dobEnc     = "";   
    $emailEnc   ="";   
    $zipWorkEnc ="";   
    $homezipEnc  =""; 
    $chartnumberEnc = "";

    $firstnameDec = ""; 
    $lastnameDec ="" ; 
    $sexDec     ="" ;  
    $dobDec     = "";   
    $emailDec   ="";   
    $zipWorkDec ="";   
    $homezipDec  =""; 
    $chartnumberDec = "";

     function encrypt($data, $key) {
        $cipher_method = 'AES-128-CTR';
        $enc_key = openssl_digest($key , 'SHA256', TRUE);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
        $crypted_token = openssl_encrypt($data, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
        return $crypted_token;
    }

     function decrypt($crypted_token, $key) {
        list($crypted_token, $enc_iv) = explode("::", $crypted_token);;
        $cipher_method = 'AES-128-CTR';
        $enc_key = openssl_digest($key, 'SHA256', TRUE);
        $token = openssl_decrypt($crypted_token, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        return $token;

     }

if (isset($_POST) && !empty($_POST)) {

    print_r ($_POST);

    //$count  = EncryptPatientInfo::loadData();
    //print_r($count);

           // IMPLODE TO ARRAY 

          // CALL FUNCTION 

          // store data
        /*
          $firstnameEnc = (!empty($_POST['firstname'])) ? encrypt($_POST['firstname'], $key) : '';
          $lastnameEnc  = (!empty($_POST['lastname'])) ? encrypt($_POST['lastname'],$key) : '' ; 
          $sexEnc       = (!empty($_POST['sex'])) ? encrypt($_POST['sex'],$key) : '' ;  
          $dobEnc       = (!empty($_POST['dateofbirth'])) ? encrypt($_POST['dateofbirth'],$key) : '' ; 
          $emailEnc    = (!empty($_POST['email'])) ? encrypt($_POST['email'],$key) : '' ;  
          $zipWorkEnc  = (!empty($_POST['workzip'])) ? encrypt($_POST['workzip'],$key) : '' ;  
          $homezipEnc  = (!empty($_POST['homezip'])) ? encrypt($_POST['homezip'],$key) : '' ;
          $chartnumberEnc  = (!empty($_POST['chartnumber'])) ? encrypt($_POST['chartnumber'],$key) : '' ;

          $isEncoded = mb_detect_encoding ($firstnameEnc);

          $firstnameDec = decrypt($firstnameEnc, $key);
          $lastnameDec = decrypt($lastnameEnc, $key);
          $sexDec = decrypt($sexEnc, $key);
          $dobDec = decrypt($dobEnc, $key);
          $emailDec = decrypt($emailEnc, $key);
          $zipWorkDec = decrypt($zipWorkEnc, $key);
          $homezipDec = decrypt($homezipEnc, $key);
          $chartnumberDec  = decrypt($chartnumberEnc, $key);

           $isDecoded = mb_detect_encoding ($firstnameDec);

        	//$kv = array();
        	//$process = "post";
        	//foreach ($_POST as $key => $value) {
        		//global $$key;
        		//$$key = $value;
        		//if ($value == "") { $value=0; }
        		//$kv[] = "$key=$value";
          		//}
          	//$query_string_post = join("<br>", $kv);
        	// DEBUG
        	//echo "query_string_post:<br>".$query_string_post."<br><br>";
            //$wheelmsp = $_POST['Wheelmsp0'];
            //$msp = $_POST['msp'];
            //$id = $_POST['id'];
            //print_r($_POST['Wheelmsp']);
            //echo "</br>";
            // print_r($kv);

            //print_r($_POST['msp']);
            //print_r($_POST);
           // echo "</br>";
           */
  }else{
    echo "<p> not posted </p>";
    $values = array();
  }

?>
<html>
<head>
        <title>Test</title>
</head>
<body>
    <section class="patientInfo">
    <div class="titlebox"><span><b>Add Patient</b></span></div>
        <form action="test.php" method ="post" name ="add_patient">
        <p>
        <input type="submit"  name ="submit" value ="Add Patient" />
        </p>
        <table>
        <tr>
        <td>
        <div class="col1">
            <p>
            <lable>Firstname:    </lable >
            <input type="text" name="firstname"     maxlength="50" value="" />
            <p>
            Lastname:  
            <input type="text" name="lastname"    maxlength="50" value="" />
            </p>
            <p> 
            Date Of Birth: 
            <input type="date" name="dateofbirth"     maxlength="20" value="" />
            </p>
            <p>
            Chart Number:
            <input type="text" name="chartnumber"    maxlength="10" value="" />
            </p>
        </div>
        <div class="col2">
            <p>Home ZIP:
            <input type="text" name="homezip"     maxlength="5" value="" />
            </p>
            <p>
             Work ZIP:
            <input type="text" name="workzip"    maxlength="5" value="" />
            </p>
            <p>
            Sex:
            <select name="sex" >
            <option name="male" value="M">M</option>
            <option name="female" value="F">F</option>
            </select>
            </p>
            <p > Tester:   
            <input type="text" name="tester"     maxlength="50" value="" />
            </p>
            <p> 
            Email:
            <input type="text" name="email"     maxlength="100" value="" />
            </p>
        </div>
        </td>
        </tr>
        </table>
        </form>
    </section>
    <section>
        <div class="titlebox"><span><b>Encrypted Text</b></span></div>
         <textarea  rows="10" cols="100"> <?php echo  "Encrypted First Name : $firstnameEnc  \n"; 
                                                echo  "Encrypted Last Name :  $lastnameEnc  \n"; 
                                                echo  "Encrypted Sex : $sexEnc \n";                                          
                                                echo  "Encrypted DOB :$dobEnc \n";                                          
                                                echo  "Encrypted Email : $emailEnc \n";                                          
                                                echo  "Encrypted Zip Work : $zipWorkEnc \n";                                          
                                                echo  "Encrypted zip Home: $homezipEnc \n"; ?>
 </textarea> 
    </section>
    <section>
        <div class="titlebox"><span><b>Decrypted Text</b></span></div>
        <div id="decryptedText"><textarea  rows="10" cols="100">
 <?php                                          echo  "Decrypted First Name : $firstnameDec \n"; 
                                                echo  "Decrypted Last Name :  $lastnameDec \n"; 
                                                
                                                echo  "Decrypted Sex : $sexDec \n";                                          
                                                echo  "Decrypted DOB :$dobDec \n";                                          
                                                echo  "Decrypted Email : $emailDec \n";                                          
                                                echo  "Decrypted Zip Work : $zipWorkDec \n";                                          
                                                echo  "Decrypted zip Home: $homezipDec \n"; ?>
        </textarea> </div>
    </section>
<form action="test.php" method ="post">
<?php

            $values = array();

            for ($k=0; $k <= 30;  $k++){
                $mspscore = rand(0, 30);
                echo " <select name=\"Wheelmsp{$k}\">";
                for($i=0; $i<= 30; $i++){
                    if ($i == $mspscore){
                        echo "<option selected  name=\"msp{$i}\" id=\"{$mspscore}\" >{$mspscore}</option>";
                    }else{
                        echo "<option   name=\"msp{$i}\" id=\"{$mspscore}\">{$i}</option>  ";
                    }
                }
                echo "</select >";
            }
                

//echo "<p>".date('l jS F (Y-m-d)', strtotime('120 days'))."</p>";
//$user = new User();
//$user->username = "Mike";
//$user->password = "john";
//$user->first_name = "xxxx";
//$user->last_name = "xxx";
//$user->save();

//$user = User::find_by_id(17);
 //$user->username = "Junk";
//$user->password = "Junk";
//$user->first_name = "Junk";
 //$user->last_name = "Junk";
//$user->save();
 
 //$user = User::find_by_id(5);
 //$user->delete();
 //array('bill','mike','fred','tom','joe');
 // $junk = join("', '", array_values($attributes));
 //echo "'".$junk."'";
?>
    <input type="submit" name="submit"/>

    </form>
        <div id= "footer">Copyright <?php echo date("Y",time())?>, Joseph Orlando</div>
</body>
</html>
    