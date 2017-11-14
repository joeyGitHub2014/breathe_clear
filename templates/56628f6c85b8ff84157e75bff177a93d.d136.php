<?php
/* template head */
if (class_exists('Dwoo\Plugins\Functions\PluginInclude')===false)
	$this->getLoader()->loadPlugin('PluginInclude');
if (class_exists('Dwoo\Plugins\Functions\PluginCounter')===false)
	$this->getLoader()->loadPlugin('PluginCounter');
/* end template head */ ob_start(); /* template body */ ?><br>
<br>
<h2 class="title" > Add New Analysis</h2>
<form  action="add_analisys.php" method ="post">
    <section class= "treatment">
        <input type="submit" name="submit"/>
        <p> Type of Treatment:
            <input type="radio"  name="treatmenttype" value="nyd" />  Not Yet Determined
            <input type="radio"  name="treatmenttype" value="drops" /> Drops
            <input type="radio"  name="treatmenttype" value="injection" /> Injection
        </p>
        <input type="hidden" name="treatment" value="<?php echo $this->scope["pageInfo"]["treatment"];?>" />
        <input type="hidden" name="patientID" value="<?php echo $this->scope["pageInfo"]["patientId"];?>" />
        <input type="hidden" name="analysisCount" value="<?php echo $this->scope["pageInfo"]["analysisCount"];?>"/>
        <div>
            <input type="button"  name="resetmsp" value="Reset MSP to 5"     onclick="resetV(5,'mspid')" />
            <input type="button"  name="resetmsp" value="Reset MSP to 0"     onclick="resetV(0,'mspid')" />
            &nbsp&nbsp|&nbsp&nbsp&nbsp
            <input type="button"  name="resetisp" value="Reset ISP to 5"     onclick="resetV(5,'ispid')" />
            <input type="button"  name="resetisp" value="Reset ISP to 0"     onclick="resetV(0,'ispid')" />
        </div>
    </section>
    </br>
    <button  id="showAllergenPanelBtn" class="btn btn-primary center-block">Add Custom Allergen </button>
    <?php if (((isset($this->scope["custom_allergen_list"]) ? $this->scope["custom_allergen_list"] : null) !== null)) {
?>
        <?php echo $this->classCall('Dwoo\Plugins\Functions\Plugininclude', 
                        array('customAnalysis.tpl', null, null, null, '_root', null));?>
    <?php 
}?>
    <table class="entry " width=800px>
        <thead>
            <tr>
                <th>Allergen</th>
                <th>Multitest Skin Prick Wheel (mm)</th>
                <th>Intradermal Test Wheel (mm)</th>
            </tr>
        </thead>
        <?php 
$_fh0_data = (isset($this->scope["allergen_list"]) ? $this->scope["allergen_list"] : null);
if ($this->isTraversable($_fh0_data) == true)
{
	foreach ($_fh0_data as $this->scope['key']=>$this->scope['allergen'])
	{
/* -- foreach start output */
?>
            <tr/>
            <td><?php echo $this->scope["allergen"]["antigenName"];?></td>
            <td>
                <select class="selectNum" data-wheelvalue="<?php echo $this->scope["pageInfo"]["mspscore"];?>"  id="Wheelmspid<?php echo $this->classCall('Dwoo\Plugins\Functions\Plugincounter', 
                        array('count1', null, null, null, null, null));?>"   name="Wheelmsp<?php echo $this->scope["allergen"]["allergenID"];?>">
                </select >
            </td>
            <td>
                <select class="selectNum"  data-wheelvalue="<?php echo $this->scope["pageInfo"]["itscore"];?>"  id="Wheelispid<?php echo $this->classCall('Dwoo\Plugins\Functions\Plugincounter', 
                        array('count2', null, null, null, null, null));?>" name="Wheelisp<?php echo $this->scope["allergen"]["allergenID"];?>">
                </select>
            </td>
            <td>
                <input type="checkbox" class="checkbox_check" name="deleteAllergen[<?php echo $this->scope["allergen"]["allergenID"];?>]" value="" onclick="deleteRecord(this)"/>
            </td>
        <?php 
/* -- foreach end output */
	}
}?>
        </tbody>
    </table>
</form>

<?php echo $this->classCall('Dwoo\Plugins\Functions\Plugininclude', 
                        array('customAllergen.tpl', null, null, null, '_root', null));?>
<script>
$(document).ready(function () {
    addRecords();

});
function deleteRecord(e) {
    val1 = e;
    val1Parent = e.parentElement.parentElement;
    if ($(val1).prop("checked")) {
        $( val1 ).attr("checked", true);
        $(val1Parent).css("background", "darkgrey");
    }else{
        $(val1Parent).css("background", "white");
        $(val1).attr( "checked", false );
    }
};
</script><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>