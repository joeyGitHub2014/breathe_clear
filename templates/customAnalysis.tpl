</br>
<div class="container" id>
    <div class="row">
        <div class="col-sm-3 pull-left" id="selCustHeader" style="padding-bottom: 10px">
            <span><b>Select existing Custom Allergen:</b></span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 pull-left" style="padding-bottom: 10px">
            <select class="selectpicker" id="selectAllergen"  data-currentpatientid="{$pageInfo.patientId}">
                    <option allergenid="0" selected> Select From List... </option>
                    {foreach $custom_allergen_list_total key allergen}
                        <option  data-allergenid="{$allergen['allergenID']}" data-patientid="{$allergen['patientID']}" >
                            {$allergen['antigenName']}
                        </option>
                    {/foreach}
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
        {if $pageInfo.treatment eq  1 or $pageInfo.treatment eq  0 }
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
            {foreach $custom_allergen_list key allergen}
                {$id = $allergen['allergenID']}
                <tr class="success">
                    <td style="color:black">{$allergen['antigenName']}</td>
                    <td>
                        <select class="selectNum" style="color:black" data-wheelvalue="{$allergen['mspscore']}"  data-allergenid="{$id}"  data-patientid="{$pageInfo.patientId}"
                                onChange="updateCustomField(this,this.value,'wmsp')"></select >
                    </td>
                    <td>
                        <select class="selectNum"  style="color:black" data-wheelvalue="{$allergen['ispscore']}" data-allergenid="{$id}"  data-patientid="{$pageInfo.patientId}"
                                onChange="updateCustomField(this,this.value,'wisp')"> </select>
                    </td>
                    <td>
                        <a data-patientid="{$pageInfo.patientId}" data-allergenid="{$allergen['allergenID']}" class="btn btn-primary btn-xs"
                                onclick="editCustomAllergen(this)">Edit</a>
                    </td>
                    <td>
                    <a  class="btn btn-primary btn-xs" data-patientid="{$pageInfo.patientId}"
                       data-allergenid="{$allergen['allergenID']}" onclick="deleteCustomAllergen(this)">Del</a>
                    </td>
                </tr>
            {/foreach}
        {else}
            {include(file='customAnalysisInjection.tpl')}
        {/if}
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
