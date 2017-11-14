<br>
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
        <input type="hidden" name="treatment" value="{$pageInfo.treatment}" />
        <input type="hidden" name="patientID" value="{$pageInfo.patientId}" />
        <input type="hidden" name="analysisCount" value="{$pageInfo.analysisCount}"/>
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
    {if isset($custom_allergen_list)}
        {include(file='customAnalysis.tpl')}
    {/if}
    <table class="entry " width=800px>
        <thead>
            <tr>
                <th>Allergen</th>
                <th>Multitest Skin Prick Wheel (mm)</th>
                <th>Intradermal Test Wheel (mm)</th>
            </tr>
        </thead>
        {foreach $allergen_list key allergen}
            <tr/>
            <td>{$allergen['antigenName']}</td>
            <td>
                <select class="selectNum" data-wheelvalue="{$pageInfo.mspscore}"  id="Wheelmspid{counter name=count1}"   name="Wheelmsp{$allergen['allergenID']}">
                </select >
            </td>
            <td>
                <select class="selectNum"  data-wheelvalue="{$pageInfo.itscore}"  id="Wheelispid{counter name=count2}" name="Wheelisp{$allergen['allergenID']}">
                </select>
            </td>
            <td>
                <input type="checkbox" class="checkbox_check" name="deleteAllergen[{$allergen['allergenID']}]" value="" onclick="deleteRecord(this)"/>
            </td>
        {/foreach}
        </tbody>
    </table>
</form>

{include(file='customAllergen.tpl')}
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
</script>