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
    $sex = "";
    $email = "";
    $tester = "";
    $batteryNameCurr = "";
    $batteryNamePrev = "";
    $mspscore = 5;
    $itscore = 5;
    $alternate = 0;
    $treatment = !empty($_GET['treat'])? (int) $_GET ['treat'] : 0;
    $patientId = !empty($_GET['id'])? (int) $_GET ['id'] : 0;
    $analysisCount =    !empty($_GET['aCnt'])? (int) $_GET ['aCnt'] : 0;
    Patient::set_patient_table();
    $sql   = " SELECT *  FROM patient WHERE patientID = {$patientId} LIMIT 1";
    $patient = Patient::find_by_sql($sql);
    $patientID =  $patient[0] ->patientID ;
    $lastname = $patient[0]->patientLast ;
    $firstname = $patient[0] ->patientFirst ;
    $lastname = $patient[0]->patientLast ;
    $chartnumber = $patient[0]->chartNum ;
    $dateofbirth =  $patient[0]->dateOfBirth;
    $sex  =  $patient[0]->sex;
    $homezip = $patient[0]->zipCodeHome;
    $workzip = $patient[0]->zipCodeWork;
    $tester = $patient[0]->tester;
    $email = $patient[0]->email;
    Allergen::set_allergen_table();
    $total_count = Allergen::count_all();
    $sql  = " SELECT allergenID, antigenName  FROM allergens1 ";
    $sql .= " ORDER BY batteryName ASC ";
    $allergen_list = Allergen::find_by_sql($sql);
    Analysis::set_analysis_table();
    $sql  = " SELECT *  FROM analysis  WHERE patientID = {$patientId} AND analysisCount = {$analysisCount} ";
    $analysis_list = Analysis::find_by_sql($sql);
    inlcudeLayoutTemplet('admin_header.php');?>

<script language="javascript" type="text/javascript">
function SetButtonStatus(text)
{
    var jsVar1 = "<?php echo urlencode($patientId) ?>";
    var jsVar2 = "<?php echo urlencode($analysisCount) ?>";
    if ( text == "nyd" ){
      //document.getElementById("submit_report").disabled = true;
      document.forms["treatment"].action = "entry_record.php?treat=0&id=" + jsVar1 + "&aCnt=" + jsVar2; 
      document.forms["treatment"].submit();
    }
    else{
      if (text == "drops"){
        document.forms["treatment"].action ="entry_record.php?treat=1&id=" + jsVar1 + "&aCnt=" + jsVar2; 
        document.forms["treatment"].submit();
      }else{
        document.forms["treatment"].action = "entry_record.php?treat=2&id=" + jsVar1 + "&aCnt=" + jsVar2; 
        document.forms["treatment"].submit();
      }
     //document.getElementById("submit_report").disabled = false;
    
    }
}

</script>
	<table id ="structure">
	<tr id ="page">
	    <td>
                <h2 class="title" > Patient Record </h2>
                <?php if (!empty($message) ){echo "<p class=\"message\">". $message . "</p>";}?>
                <?php if (!empty($errors) ){ displayErrors($errors); }?>

                <p > Firstname:   
                    <input type="text" name="firstname"   readonly="readonly"    maxlength="50" value="<?php echo htmlentities($firstname)?>" />
                    Lastname:  
                    <input type="text" name="lastname"  readonly="readonly"   maxlength="50" value="<?php echo htmlentities($lastname)?>" />
                </p>
                <p> 
                    Date Of  Date: 
                    <input type="text" name="dateofbirth"   readonly="readonly"   maxlength="20" value="<?php echo htmlentities($dateofbirth)?>" />
                    Chart Number:
                    <input type="text" name="chartnumber"   readonly="readonly"  maxlength="10" value="<?php echo htmlentities($chartnumber)?>" />
                </p>
                <p>Home ZIP:
                    <input type="text" name="homezip"  readonly="readonly"    maxlength="5" value="<?php echo htmlentities($homezip)?>" />
                    Work ZIP:
                    <input type="text" name="workzip" readonly="readonly"    maxlength="5" value="<?php echo htmlentities($workzip)?>" />
                    Sex:
                    <select name="sex">
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
                <p>
                    Tester:
                    <input type="text" name="tester"  readonly="readonly"    maxlength="50" value="<?php echo htmlentities($tester)?>" />
                </p>
            </td>
	</tr>
        <tr >
            <td>
            	<form id="treatment"  method ="post">

                <p id="page2"> Type of Treatment:</p>
                <p id="page2">
                <?php
                if ($treatment == 0){ 
                    echo "<input type=\"radio\"  name=\"treatment\" value=\"nyd\" checked=\"checked\" onclick=\"SetButtonStatus(this.value)\"  />  Not Yet Determined ";
                    echo "<input type=\"radio\"  name=\"treatment\" value=\"drops\"   onclick=\"SetButtonStatus(this.value)\"  /> Drops ";
                    echo "<input type=\"radio\"  name=\"treatment\" value=\"injection\" onclick=\"SetButtonStatus(this.value)\" /> Injection ";
                    echo "</form>";
                } elseif ($treatment == 1){
                    echo "<input type=\"radio\"  name=\"treatment\" value=\"nyd\"  onclick=\"SetButtonStatus(this.value)\"  />  Not Yet Determined ";
                    echo "<input type=\"radio\"  name=\"treatment\" value=\"drops\" checked=\"checked\" onclick=\"SetButtonStatus(this.value)\"  /> Drops ";
                    echo "<input type=\"radio\"  name=\"treatment\" value=\"injection\" onclick=\"SetButtonStatus(this.value)\" /> Injection ";
                    echo "</form>";
                }else{
                    echo "<input type=\"radio\"  name=\"treatment\" value=\"nyd\"  onclick=\"SetButtonStatus(this.value)\"  />  Not Yet Determined ";
                    echo "<input type=\"radio\"  name=\"treatment\" value=\"drops\" onclick=\"SetButtonStatus(this.value)\"  /> Drops ";
                    echo "<input type=\"radio\"  name=\"treatment\" value=\"injection\" checked=\"checked\" onclick=\"SetButtonStatus(this.value)\" /> Injection ";
                    echo "</form>";
                
                }?>

            </td>
        </tr>
    </table>
    <form action="create_report.php" method ="post">

    <table class="entry" width=800px>
    <p id="page2">
    <?php
        if ($treatment == 1 ||$treatment == 2){ 
            echo  "<input type=\"submit\"   name =\"submit_report\" value =\"Generate Immunotherapy Preparation\"      />";
        } ?>
    </p>


    <?php
    echo  "<input type=\"hidden\" name=\"treatment\" value=\"{$treatment}\" >";
    echo  "<input type=\"hidden\" name=\"patientID\" value=\"{$patientId}\" >";
    echo  "<input type=\"hidden\" name=\"analysisCount\" value=\"{$analysisCount}\" >";

    if ($treatment == 1 || $treatment == 0){ 
            echo "<tr>";
            echo "<th>Allergen</th>";
            echo "<th>Multitest Skin Prick Wheal (mm)</th>";
            echo  "<th>Intradermal Test Wheal (mm)</th>";
            echo "<th>Conformation</th>";
            echo "</tr>";
            foreach($allergen_list as $key => $antigen){
                if ($alternate==0) { 
                    echo " <tr bgcolor = \"#D2D2D2\"     > ";
                    $alternate=1;
                }
                else { 
                    echo " <tr bgcolor = \"#FFFFFF\"     > ";
                    $alternate = 0;
                }
                $id = $antigen->allergenID;
                $battery = $antigen->batteryName;
                $groupId = $antigen->groupID;
                echo "<td>";
                echo "  ".$name = $antigen->antigenName;
                echo "</td>";
                echo "<td>";
                echo " <select name=\"Wheelmsp\">";
                foreach($analysis_list as $key => $analysis){
                    if ($antigen->allergenID == $analysis->allergenID){
                        $mspscore =$analysis->MSPScore;
                        $itscore =$analysis->ITScore;
                        break;
                    }
                }
                if (empty($mspscore)){
                    $mspscore = 0;
                }
                if (empty($itscore)){
                    $itscore = 0;
                } 
                for($i=0; $i<= 30; $i++){
                    if ($i == $mspscore){
                        echo "   <option selected value=\"msp\" id=\"{$mspscore}\" >{$mspscore}</option>   ";
                    }else{
                        echo "  <option  value=\"msp\" id=\"{$mspscore}\">{$i}</option>  ";
                    }
                }
                echo "</select >";
                echo "</td>";
                echo "<td>";
                echo " <select  name=\"Wheelispp\">";
                for($j=0; $j<= 30; $j++){
                    if ($j == $itscore){
                        echo "<option selected value=\"isp\" id=\"{$itscore}\" >{$itscore}</option>   ";
                    }else{
                        echo " <option value=\"isp\" id=\"{$itscore}\" >{$j}</option>";
                    }
                }
                echo "</select>";
                //echo  "<input type=\"hidden\" name=\"msp\" value=\"{$mspscore}\" size=8>";
                //echo  "<input type=\"hidden\" name=\"isp\"  value=\"{$itscore}\" size=8>";
                echo "</td>";
                echo "<td>";
                echo "<input type=\"checkbox\" name=\"confirm\" value=\"true\" /> " ;
                echo "</td>";
                echo "<tr/>";
            }
    }else{
            echo "<tr>";
            echo "<th>Allergen</th>";
            echo "<th>Multitest S P Whl(mm)</th>";
            echo "<th>ID Dilu  </th>";
            echo  "<th>Intra Test Wheal (mm)</th>";
            echo "<th>2nd IDD</th>";
            echo "<th>2nd Whl</th>";
            echo "<th>End P</th>";
            echo "<th>Dilution</th>";
            echo "</tr>";
            foreach($allergen_list as $key => $antigen){
                $id = $antigen->allergenID;
                if ($alternate==0) { 
                    echo " <tr bgcolor = \"#D2D2D2\"     > ";
                    $alternate=1;
                }
                else { 
                    echo " <tr bgcolor = \"#FFFFFF\"     > ";
                    $alternate = 0;
                }
                echo "<td>";
                echo "  ".$name = $antigen->antigenName;
                echo "</td>";
                echo "<td>";
                echo " <select>";
                foreach($analysis_list as $key => $analysis){
                    if ($antigen->allergenID == $analysis->allergenID){
                        $mspscore =$analysis->MSPScore;
                        $itscore =$analysis->ITScore;
                        break;
                    }
                }
                if (empty($mspscore)){
                    $mspscore = 0;
                }
                if (empty($itscore)){
                    $itscore = 0;
                } 
                for($i=0; $i<= 30; $i++){
                    if ($i == $mspscore){
                        echo "   <option selected value=\"msp\" id=\"{$mspscore}\" >{$mspscore}</option>   ";
                    }else{
                        echo "  <option  value=\"msp\" id=\"{$mspscore}\">{$i}</option>  ";
                    }
                }
                echo "</select>";
                echo "</td>";
                echo "<td>";
                if ($mspscore < 7){
                    echo " 2";
                }
                echo "</td>";
                echo "<td>";
                echo " <select>";
                for($j=0; $j<= 30; $j++){
                    if ($j == $itscore){
                        echo "<option selected value=\"isp\" id=\"{$itscore}\" >{$itscore}</option>   ";
                    }else{
                        echo " <option value=\"isp\" id=\"{$itscore}\" >{$j}</option>";
                    }
                }
                echo "</select>";
                echo "</td>";

                echo "<td>";
                    if ($mspscore == 7 || $mspscore == 8){
                     echo " 5";
                    }
                echo "</td>";
                echo "<td>";
                if ($mspscore == 7 || $mspscore == 8){

                    echo " <select>";
                        for($j=0; $j<= 30; $j++){
                            if ($j == 5){
                                echo "<option selected value=\"twoWhl\" id=\"{ $id}\" >{$j}</option>   ";
                            }else{
                                echo " <option value=\"twoWhl\" id=\"{$id}\" >{$j}</option>";
                            }
                        }
                     
                    echo "</select>";
                } else{
                    echo "";
                }
                echo "</td>";
                echo "<td>";
                    if ($mspscore == 7 || $mspscore == 8){
                     echo " 4";
                    }elseif ($mspscore >= 9){
                     echo " 6";
                    }
                echo "</td>";
                echo "<td>";
                    if ($mspscore == 7 || $mspscore == 8){
                      echo " 2";
                    }elseif ($mspscore >= 9){
                      echo " 4";
                    }
                    echo "</td>";
                echo "<tr/>";
            }
        }
        ?>
        </table>
    </form>
    <?php
        echo "<p><b> Patient: ".$firstname." ".$lastname."<b></p>";
    ?>    
    </div>
    <?php inlcudeLayoutTemplet('footer.php');?>
