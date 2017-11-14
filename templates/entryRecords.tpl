<br>
<button  id="showAllergenPanelBtn" class="btn btn-primary center-block">Add Custom Allergen </button>
{if isset($custom_allergen_list)}
    {include(file='customAnalysis.tpl')}
{/if}
<div class="container">
    <div class="row">
        <div class ="col-lg-4"></div>
        <div class ="col-lg-4 update_result center-block" style="color: #02F811;"></div>
        <div class ="col-lg-4"></div>
    </div>
</div>

<table class="entry" width=800px>

    <form id ="frm_analysis" action="update_analysis.php" method ="post">

        <p id="page2">

        <input type="hidden" id="patientID"      name="patientID"     value="{$entryRecordInfo.patientId}" >
        <input type="hidden" id="analysisCount"  name="analysisCount" value="{$entryRecordInfo.analysisCount}">
        {if $entryRecordInfo.treatment eq  1 or $entryRecordInfo.treatment eq  0 }
            <tr><th>Allergen</th><th>Multitest Skin Prick Wheel (mm)</th><th>Intradermal Test Wheel (mm)</th></tr>
            {foreach $analysisList key analysis}
                {$mspscore  = $analysis->MSPScore }
                {$itscore   = $analysis->ITScore}
                {$id        = $analysis->allergenID}
                {if $mspscore == null}{$mspscore = 0}{/if}
                {if $itscore == null}{$itscore = 0}{/if}
                {if $mspscore >= 7 || $itscore >=7}
                    <td style="color:red" class = "print_red" id="antigen{$id}">
                {else}
                    <td style="color:black;" id="antigen{$id}">
                {/if}
                {* Allergen name *}
                {$allergenList[$id]}
                </td>
                {* Multitest Skin Prick Wheel*}
                <td>
                <select class="selectNum"  name="wmsp{$id}" data-wheelvalue="{$mspscore}"   onChange="updateField({$id},this.value,this.name)"></select>
                </td>
                {* Intradermal Test Wheel *}
                <td>
                <select  class="selectNum"   name="wisp{$id}" data-wheelvalue="{$itscore}"  onChange="updateField({$id},this.value,this.name)"></select>
                </td>

        </tr>
             {/foreach}
        {else}
            <tr><th>Allergen</th><th>Multitest S P Whl(mm)</th><th>ID Dilu  </th><th>Intra Test Wheel (mm)</th><th>2nd IDD</th><th>2nd Whl</th>
                <th>End P</th><th>Dilution</th></tr>
            {foreach $analysisList  key  analysis}
                {$mspscore  = $analysis->MSPScore}
                {$itscore   = $analysis->ITScore}
                {$id        = $analysis->allergenID}
                {$twoWhl    = $analysis->twoWhl}

                {if $mspscore eq null}{$mspscore = 0}{/if}
                {if $itscore eq null}{$itscore = 0}{/if}
                {if $mspscore >= 7 or $itscore >=7}
                    <td style="color:red" class = "print_red" id="antigen{$id}">
                {else}
                    <td style="color:black;" id="antigen{$id}">
                {/if}
                {* Allergen name *}
                 {$allergenList[$id]}
                </td>
                {* Multitest S P Whl *}
                <td>
                    <select class="selectNum"  name="wmsp{$id}"  data-wheelvalue="{$mspscore}" onChange="updateField({$id},this.value,this.name)" ></select>
                </td>
                {* ID Dilu *}
                <td>
                {if  $mspscore < 7 }2{/if}
                </td>
                {* Intra Test Wheel *}
                <td>
                    <select class="selectNum" name="wisp{$id}"   data-wheelvalue="{$itscore}"  onChange="updateField({$id},this.value,this.name)" ></select>
                </td>
                <td>
                {* 2nd IDD	 *}
                {if $mspscore == 7 or $mspscore == 8 and $twoWhl < 9} 5 {/if}
                </td>
                <td>
                {* 2nd Whl	 *}
                {if $mspscore == 7 || $mspscore == 8}
                    <select class="selectNum" name="twoWhl{$id}" data-wheelvalue="{$twoWhl}" onChange="updateField({$id},this.value,this.name)">
                    </select>
                {/if}
                </td>
                <td>
                {* End  P *}
                {if $mspscore == 7 || $mspscore == 8}
                    {if $twoWhl >= 9}
                        6
                    {else}
                        4
                    {/if}
                {elseif $mspscore >= 9 || $itscore >= 7}
                      6
                {/if}
                </td>
                <td>
                {* Dilution *}
                {if $mspscore == 7 || $mspscore == 8}
                    {if $twoWhl >= 9}
                         4
                    {else}
                         2
                    {/if}
                {elseif $mspscore >= 9 || $itscore >= 7}
                        4
                {/if}
                </td>
                </tr>
            {/foreach}
        {/if}
</form>
</table>
<div class="container"><b>Patient: {$patientInfo.firstname}  {$patientInfo.lastname}</b></div>

</div>
