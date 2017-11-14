<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?>
<div class="container" style=" font-size: large">
    <h2 class="title"> Patient Record </h2>
    <div class="row " style="background-color:#14b3e6;"   >
        <div class="col-sm-3">First name: <b><?php echo $this->scope["firstname"];?></b></div>
        <div class="col-sm-3">Last name: <b> <?php echo $this->scope["lastname"];?></b> </div>
        <div class="col-sm-3">Date Of Birth: <b>  <?php echo $this->scope["dateofbirth"];?> </b> </div>
        <div class="col-sm-3">Chart Number:<b><?php echo $this->scope["chartnumber"];?></b>  </div>
    </div>
    <div class="row " style="background-color:#74e6c6;"  >
        <div class="col-sm-3">Home ZIP:<b> <?php echo $this->scope["homezip"];?></b> </div>
        <div class="col-sm-3">Work ZIP: <b><?php echo $this->scope["workzip"];?></b> </div>
        <div class="col-sm-3">Sex:<b> <?php if ((isset($this->scope["sex"]) ? $this->scope["sex"] : null) == 'M') {
?>M<?php 
}
else {
?>F<?php 
}?></b></div>
        <div class="col-sm-3">Tester:<b><?php echo $this->scope["tester"];?></b> </div>
    </div>
</div>
<?php  /* end template body */
return $this->buffer . ob_get_clean();
?>