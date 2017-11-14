
<section class="message">
    <div  id="update_result" ></div>
</section>
<div class="container">
    <h2 class="title" > Edit Entry Record </h2>

    <form id ="frm_treatment" action="create_report.php" method ="post">
        <input type="hidden" id="treatment"             name="treatmentType" value="{$entryRecordInfo.treatment}">
        <input type="hidden" id="treatPatientID"        name="patientID" value="{$entryRecordInfo.patientId}">
        <input type="hidden" id="treatAnalysisCount"    name="analysisCount" value="{$entryRecordInfo.analysisCount}">
        <div class=" row panel"  >
            <!-- <div class=" row panel" style="color:#fff; background-color: #0fbdf0;"> -->

            <div class="col-sm-2">
                Type of Treatment:
            </div>
            <div class="col-sm-2">
                <input type="radio"  name="treatment" value="nyd"       {$treatment[0]} onclick="setButtonStatus(value)" /> Not Yet Determined
            </div>
            <div class="col-sm-2">
                <input type="radio"  name="treatment" value="drops"     {$treatment[1]} onclick="setButtonStatus(value)" /> Drops:
                {if $entryRecordInfo.treatment eq 1}
                    <input type="checkbox" {$entryRecordInfo.refillChecked}  id="check1"    onclick="update_refill()"  /> Refill
                {/if}
            </div>
            <div class="col-sm-6">
                <input type="radio"  name="treatment" value="injection" {$treatment[2]} onclick="setButtonStatus(value)" /> Injection:
                {if $entryRecordInfo.treatment eq 2}
                    <input type="radio" id="refill0" {$injectionLevel[0]}  name="refill" value="0" onclick="updateDilutionLevel(value)" /> 1st Dilution
                    <input type="radio" id="refill1" {$injectionLevel[1]}  name="refill" value="1" onclick="updateDilutionLevel(value)" /> 2nd Dilution
                    <input type="radio" id="refill2" {$injectionLevel[2]}  name="refill" value="2" onclick="updateDilutionLevel(value)" /> 3rd Dilution
                    <input type="radio" id="refill3" {$injectionLevel[3]}  name="refill" value="3" onclick="updateDilutionLevel(value)" /> 4th or Final Dilution

                {/if}
            </div>
        </div>
         <div class=" row panel">
             <div class="col-sm-4">
                <input type="submit" id="submit_report" {$entryRecordInfo.printReport}  name ="submit_report" value ="Generate Immunotherapy Preparation" />
             </div>
             <div class="col-sm-4">
                 <input type="submit" id="print" name ="print" value ="Print Entry Record"  onclick="printEntryPage({$entryRecordInfo.patientId},{$entryRecordInfo.analysisCount}, {$entryRecordInfo.treatment})"/>
             </div>
             <div class="col-sm-4">
                     <a href="create_patient_report.php?id={$entryRecordInfo.patientId}&aCnt={$entryRecordInfo.analysisCount}" >click here for Patient Report </a>
             </div>
         </div>
    </form>
    <b>NOTE: 7 or > = positive allergy </b>
</div>


