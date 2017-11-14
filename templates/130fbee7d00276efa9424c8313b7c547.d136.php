<?php
/* template head */
if (class_exists('Dwoo\Plugins\Functions\PluginInclude')===false)
	$this->getLoader()->loadPlugin('PluginInclude');
/* end template head */ ob_start(); /* template body */ ?></br>
<div class="container" id>
    <div class="row">
        <div class="col-sm-3 pull-left" id="selCustHeader" style="padding-bottom: 10px">
            <span><b>Select existing Custom Allergen:</b></span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 pull-left" style="padding-bottom: 10px">
            <select class="selectpicker" id="selectAllergen"  data-currentpatientid="<?php echo $this->scope["pageInfo"]["patientId"];?>">
                    <option allergenid="0" selected> Select From List... </option>
                    <?php 
$_fh0_data = (isset($this->scope["custom_allergen_list_total"]) ? $this->scope["custom_allergen_list_total"] : null);
if ($this->isTraversable($_fh0_data) == true)
{
	foreach ($_fh0_data as $this->scope['key']=>$this->scope['allergen'])
	{
/* -- foreach start output */
?>
                        <option  data-allergenid="<?php echo $this->scope["allergen"]["allergenID"];?>" data-patientid="<?php echo $this->scope["allergen"]["patientID"];?>" >
                            <?php echo $this->scope["allergen"]["antigenName"];?>
                        </option>
                    <?php 
/* -- foreach end output */
	}
}?>
            </select>
        </div>
        <div class="col-sm-2 pull-left">
            <button id="addAllergenBtn" class="btn btn-primary btn-xs">Add</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 pull-left" id="allergenAddedMsg"> </div>
    </div>
    <table   class="table table-striped table-hover ">
        <?php if ((isset($this->scope["pageInfo"]["treatment"]) ? $this->scope["pageInfo"]["treatment"]:null) == 1 || (isset($this->scope["pageInfo"]["treatment"]) ? $this->scope["pageInfo"]["treatment"]:null) == 0) {
?>
            <thead style="background-color:#2fa4e7">
            <tr>
                <th>Custom Allergen Name</th>
                <th>Multitest Skin Prick Wheel (mm)</th>
                <th>Intradermal Test Wheel (mm)</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php 
$_fh1_data = (isset($this->scope["custom_allergen_list"]) ? $this->scope["custom_allergen_list"] : null);
if ($this->isTraversable($_fh1_data) == true)
{
	foreach ($_fh1_data as $this->scope['key']=>$this->scope['allergen'])
	{
/* -- foreach start output */
?>
                <?php $this->scope["id"]=(isset($this->scope["allergen"]["allergenID"]) ? $this->scope["allergen"]["allergenID"]:null)?>
                <tr class="success">
                    <td style="color:black"><?php echo $this->scope["allergen"]["antigenName"];?></td>
                    <td>
                        <select class="selectNum" style="color:black" data-wheelvalue="<?php echo $this->scope["allergen"]["mspscore"];?>"  data-allergenid="<?php echo $this->scope["id"];?>"  data-patientid="<?php echo $this->scope["pageInfo"]["patientId"];?>"
                                onChange="updateCustomField(this,this.value,'wmsp')"></select >
                    </td>
                    <td>
                        <select class="selectNum"  style="color:black" data-wheelvalue="<?php echo $this->scope["allergen"]["ispscore"];?>" data-allergenid="<?php echo $this->scope["id"];?>"  data-patientid="<?php echo $this->scope["pageInfo"]["patientId"];?>"
                                onChange="updateCustomField(this,this.value,'wisp')"> </select>
                    </td>
                    <td>
                        <a data-patientid="<?php echo $this->scope["pageInfo"]["patientId"];?>" data-allergenid="<?php echo $this->scope["allergen"]["allergenID"];?>" class="btn btn-primary btn-xs"
                                onclick="editCustomAllergen(this)">Edit</a>
                    </td>
                    <td>
                    <a  class="btn btn-primary btn-xs" data-patientid="<?php echo $this->scope["pageInfo"]["patientId"];?>"
                       data-allergenid="<?php echo $this->scope["allergen"]["allergenID"];?>" onclick="deleteCustomAllergen(this)">Del</a>
                    </td>
                </tr>
            <?php 
/* -- foreach end output */
	}
}?>
        <?php 
}
else {
?>
            <?php echo $this->classCall('Dwoo\Plugins\Functions\Plugininclude', 
                        array('customAnalysisInjection.tpl', null, null, null, '_root', null));?>
        <?php 
}?>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function () {
    var modal = document.getElementById("myModal");
    var showPanelBtn = document.getElementById("showAllergenPanelBtn");
    var addAllFromSelection = document.getElementById("addAllergenBtn");
    var editBtn = document.getElementsByName("editCustomBtn");
    $("#addBtn").show();
    $("#editCusAllergenBtn").hide();
    // When the user clicks the button, open the modal
    showPanelBtn.onclick = function (e) {
        e.preventDefault();
        modal.style.display = "block";
        $("#addBtn").show();
        $("#editCusAllergenBtn").hide();
    }
    addAllFromSelection.onclick = function (e) {
        e.preventDefault();
        $("#allergenAddedMsg").empty();
        var s = $("#selectAllergen").find("option:selected");

        if (s.data("allergenid") != undefined) {
            var allergenID = s.data("allergenid");
            var patientID = s.data("patientid");
            var currentpatientID = $("#selectAllergen").data("currentpatientid");
            $.ajax({
                type: 'POST',
                url: 'dup_custom_allergen.php',
                data: {
                    "patientID": patientID,
                    "allergenID": allergenID,
                    "currentpatientID": currentpatientID
                },
                success: function (response) {
                    json = JSON.parse(response);
                    $("#allergenAddedMsg").empty().append(json.msg).css("color","lightgreen");
                },
                error: function (xhr, status, response) {
                    console.log('status->' + status);
                    console.log('response->' + response);
                }
            });
        }
    }
});
</script>
<?php  /* end template body */
return $this->buffer . ob_get_clean();
?>