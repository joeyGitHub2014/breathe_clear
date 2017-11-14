<h2 class="title" > Patient Record </h2>
<br>
<section class ="patientInfo ">
    <table>
        <tr>
            <td class="clearfix">
                <div class="col1 ">
                    <p> Firstname:
                        <input type="text" name="firstname"   readonly="readonly"    maxlength="50" value="{$firstname}"/>
                    <p>Lastname:
                        <input type="text" name="lastname"  readonly="readonly"   maxlength="50" value="{$lastname}" />
                    <p>Date Of Birth:
                        <input type="text" name="dateofbirth"   readonly="readonly"   maxlength="20" value="{$dateofbirth}" />
                    <p>Chart Number:
                        <input type="text" name="chartnumber"   readonly="readonly"  maxlength="10" value="{$chartnumber}" />
                </div>
                <div class="col2 ">
                    <p>Home ZIP:
                        <input type="text" name="homezip"  readonly="readonly"    maxlength="5" value="{$homezip}" />
                    <p>Work ZIP:
                        <input type="text" name="workzip" readonly="readonly"    maxlength="5" value="{$workzip}" />
                    </p>
                    <p>Sex:
                        {if $sex eq "M"}
                            M
                        {else}
                            F
                        {/if}
                     </p>
                    <p>
                        Tester:
                        <input type="text" name="tester"  readonly="readonly"    maxlength="50" value="{$tester}" />
                    </p>
                </div>
            </td>
        </tr>
    </table>
</section>