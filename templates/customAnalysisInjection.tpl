<thead style="background-color:#2fa4e7">
    <tr><th>Custom Allergen Name</th><th>Multitest S P Whl(mm)</th><th>ID Dilu  </th><th>Intra Test Wheel (mm)</th><th>2nd IDD</th><th>2nd Whl</th>
    <th>End P</th><th>Dilution</th><th></th><th></th></tr>
</thead>
{foreach $custom_allergen_list key allergen}
    {$mspscore  = $allergen['mspscore']}
    {$ispscore   = $allergen['ispscore']}
    {$id        = $allergen['allergenID']}
    {$twoWhl    = $allergen['twoWhl']}

    <tr class="success"/>
        {* Allergen name *}
        <td style="color:black">{$allergen['antigenName']}</td>
        {* Multitest S P Whl *}
        <td>
            <select class="selectNum" style="color:black" data-wheelvalue="{$mspscore}" data-allergenid="{$id}"  data-patientid="{$pageInfo.patientId}" onChange="updateCustomField(this,this.value,'wmsp')"></select >    </td>
        {* ID Dilu *}
        <td>
            {if  $mspscore < 7 }2{/if}
        </td>
        {* Intra Test Wheel *}
        <td>
            <select class="selectNum" style="color:black" data-wheelvalue="{$ispscore}"   data-allergenid="{$id}"  data-patientid="{$pageInfo.patientId}" onChange="updateCustomField(this,this.value,'wisp')"> </select>
        </td>
        <td>
            {* 2nd IDD	 *}
            {if $mspscore == 7 or $mspscore == 8 and $twoWhl < 9} 5 {/if}
        </td>
        <td>
            {* 2nd Whl	 *}
            {if $mspscore == 7 || $mspscore == 8}
                <select class="selectNum"  style="color:black"  data-wheelvalue="{$twoWhl}"  data-allergenid="{$id}" data-patientid="{$pageInfo.patientId}"  onChange="updateCustomField(this,this.value,'customTwoWhl')"></select>
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
        <td>
            <a data-patientid="{$pageInfo.patientId}" data-allergenid="{$allergen['allergenID']}" class="btn btn-primary btn-xs"
            onclick="editCustomAllergen(this)">Edit</a>
        </td>
        <td>
            <a  class="btn btn-primary btn-xs"  data-allergenid="{$id}" data-patientid="{$allergen['patientID']}" onclick="deleteCustomAllergen(this)">Del</a>
        </td>
    </tr>
{/foreach}
