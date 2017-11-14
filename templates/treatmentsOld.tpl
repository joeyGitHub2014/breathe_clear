
<section class="message">
    <div  id="update_result" ></div>
    <h2 class="title" > Edit Entry Record </h2>
    <br>
</section>
<section class="treatment">
    <form id ="frm_treatment" action="create_report.php" method ="post">
        <div>
            <p> Type of Treatment:</p>
            <p>
            &nbsp&nbsp&nbsp
            <input type="radio"  name="treatment" value="nyd"       {$treatment[0]} onclick="SetButtonStatus(value)" /> Not Yet Determined
            <input type="radio"  name="treatment" value="drops"     {$treatment[1]} onclick="SetButtonStatus(value)" /> Drops
            <input type="radio"  name="treatment" value="injection" {$treatment[2]} onclick="SetButtonStatus(value)" /> Injection
            {if $entryRecordInfo.treatment eq 1}
                <div id="dilDrp">
                    <input type="checkbox" {$entryRecordInfo.refillChecked}  id="check1"    onclick="update_refill()"  /> Refill
                </div>
            {elseif $entryRecordInfo.treatment eq 2}
                <div id="dilInj">
                    <input type="radio" id="refill0" {$injectionLevel[0]}  name="refill" value="0" onclick="updateDilutionLevel(value)" /> 1st Dilution
                    <input type="radio" id="refill1" {$injectionLevel[1]}  name="refill" value="1" onclick="updateDilutionLevel(value)" /> 2nd Dilution
                    <input type="radio" id="refill2" {$injectionLevel[2]}  name="refill" value="2" onclick="updateDilutionLevel(value)" /> 3rd Dilution
                    <input type="radio" id="refill3" {$injectionLevel[3]}  name="refill" value="3" onclick="updateDilutionLevel(value)" /> 4th or Final Dilution
                </div>
            {/if}
            <input type="hidden" id="treatment"             name="treatment" value="{$entryRecordInfo.treatment}">
            <input type="hidden" id="treatPatientID"        name="patientID" value="{$entryRecordInfo.patientId}">
            <input type="hidden" id="treatAnalysisCount"    name="analysisCount" value="{$entryRecordInfo.analysisCount}">
            <p>
            <input type="submit" id="submit_report" {$entryRecordInfo.printReport}  name ="submit_report" value ="Generate Immunotherapy Preparation" />
            <input type="submit" id="print" name ="print" value ="Print Entry Record"  onclick="printEntryPage({$entryRecordInfo.patientId},
            {$entryRecordInfo.analysisCount}, {$entryRecordInfo.treatment})"/>
           &nbsp&nbsp&nbsp
            <a href="create_patient_report.php?id={$entryRecordInfo.patientId}&aCnt={$entryRecordInfo.analysisCount}" class="linkButton">click here for Patient Report </a>
            </p>
        </div>
    </form>
    <b>NOTE: 7 or > = positive allergy </b>
</section>


