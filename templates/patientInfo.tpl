
<div class="container" style=" font-size: large">
    <h2 class="title"> Patient Record </h2>
    <div class="row " style="background-color:#14b3e6;"   >
        <div class="col-sm-3">First name: <b>{$firstname}</b></div>
        <div class="col-sm-3">Last name: <b> {$lastname}</b> </div>
        <div class="col-sm-3">Date Of Birth: <b>  {$dateofbirth} </b> </div>
        <div class="col-sm-3">Chart Number:<b>{$chartnumber}</b>  </div>
    </div>
    <div class="row " style="background-color:#74e6c6;"  >
        <div class="col-sm-3">Home ZIP:<b> {$homezip}</b> </div>
        <div class="col-sm-3">Work ZIP: <b>{$workzip}</b> </div>
        <div class="col-sm-3">Sex:<b> {if $sex eq 'M'}M{else}F{/if}</b></div>
        <div class="col-sm-3">Tester:<b>{$tester}</b> </div>
    </div>
</div>
