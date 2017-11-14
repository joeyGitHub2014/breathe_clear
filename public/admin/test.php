<?php
	$query_string_post = "";
	$query_string_get = "";
	$process="";
  if ($_POST){
	$kv = array();
	$process = "post";
	foreach ($_POST as $key => $value) {
		global $$key;
		$$key = $value;
		if ($value == "") { $value=0; }
		$kv[] = "$key=$value";
  		}
  	//$query_string_post = join("<br>", $kv);
	// DEBUG
	//echo "query_string_post:<br>".$query_string_post."<br><br>";
    //$wheelmsp = $_POST['Wheelmsp0'];
    //$msp = $_POST['msp'];
    //$id = $_POST['id'];
    //print_r($_POST['Wheelmsp']);
    echo "</br>";
            print_r($kv);

    //print_r($_POST['msp']);
    //print_r($_POST);
    echo "</br>";
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
    