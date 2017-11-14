<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?><div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Add Custom Allergen</h2>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="customAllergen" >
                <input type="hidden" name="patientID" value="<?php echo $this->scope["pageInfo"]["patientId"];?>" />
                <input type="hidden" name="analysisCount" value="<?php echo $this->scope["pageInfo"]["analysisCount"];?>"/>
                <input type="hidden" id="allergenID" name="allergenID"/>
                <div id = "result_msg"> </div>
                <legend>Enter Allergen Information:</legend>
                <fieldset>
                    <div class="form-group">
                        <label for="allergenName" class="col-lg-1 control-label">Name:</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" id="allergenName" name="antigenName"  placeholder="">
                        </div>
                        <label for="expDate" class="col-lg-1 control-label">Exp. Date:</label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control"  id="expDate" name="expDate"  placeholder="mm-yy">
                        </div>
                        <label for="lotNumber" class="col-lg-1 control-label">Lot Number:</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" id="lotNumber" name="lotNumber"  placeholder="">
                        </div>
                        <label for="battery" class="col-lg-1 control-label">Battery: </label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" id="battery"  name="batteryName"  pattern="A|B|C|D|E"  placeholder="A,B,C,D,E">
                        </div>
                        <label for="groupID" class="col-lg-1 control-label">Group ID:</label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" id="groupID"  name="groupID" pattern="0|1|2|3|4|5"  placeholder="0 = Foods, 1 = Mold, 2 = Trees, 3 = Grass, 4 = Weeds, 5 = Animal">
                            <div  style="font-size: xx-small">
                                0 = Foods, 1 = Mold, 2 = Trees, 3 = Grass, 4 = Weeds, 5 = Animals
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textArea" class="col-lg-1 control-label">Description:</label>
                        <div class="col-lg-6">
                            <textarea class="form-control" rows="3" id="textArea"  name="caption" ></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group">
                    <button  id="addBtn"                name="add_custom_allergen"      class="btn btn-primary">Add Allergen</button>
                    <button  id="editCusAllergenBtn"    name="edit_custom_allergen"   style="display:none"  class="btn btn-primary" >Edit Allergen</button>
                    <button  id="clearBtn"                                              class="btn btn-primary">Reset </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    var modal = document.getElementById("myModal");
    var custEditBtn = document.getElementById("editCusAllergenBtn");
    var addBtn = document.getElementById("addBtn");
    var clearBtn = document.getElementById("clearBtn");
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
        location.reload();
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
            location.reload();
        }
    }

    clearBtn.onclick =  function(e) {
        e.preventDefault();
        $("#customAllergen")[0].reset();
        $("#result_msg").empty();
    }
    custEditBtn.onclick =  function(e) {
        //e.preventDefault();
        url = "edit_custom_allergen.php"
        addEditAllergen(e,url);
    }
    addBtn.onclick =  function(e) {
       // e.preventDefault();
        url = "add_custom_allergen.php"
        addEditAllergen(e,url);
    }
    function addEditAllergen (e, url) {
         $('#customAllergen').validate({
             rules: {
                 antigenName: {
                     required: true,
                     maxlength: 50
                 },
                 expDate: {
                     pattern: /^(1[0-2]|0[1-9]|\d)\-([2-9]\d[1-9]\d|[1-9]\d)+$/,
                     required: true,
                     maxlength: 5
                 },
                 lotNumber: {
                     required: true,
                     maxlength: 10
                 },
                 batteryName: {
                     pattern: /^[A-E]$/,
                     required: true,
                     maxlength: 5
                 },
                 groupID: {
                     pattern: /^[0-5]$/,
                     required: true,
                     maxlength: 1
                 }
             },
             messages: {
                 allergenName: {
                     required: 'The Allergen name is required.',
                     maxlength: 'Allergen Name can only be 50 chacters long.'

                 },
                 expDate: {
                     pattern: 'Date is mm-yy ex. 03-17 for March 2017.',
                     required: 'The Experation Date is required.',
                     maxlength: 'Allergen Name can only be 50 chacters long.'
                 },
                 lotNumber: {
                     required: 'The Lot Number is required.',
                     maxlength: 'Lot Number can be a maximum of 10 long.'
                 },
                 battery: {
                     pattern: 'Only A, B, C, D, E are valid',
                     required: 'The Battery is required.',
                     maxlength: 'Battery is 1 character long.'
                 },
                 groupID: {
                     pattern: 'Please enter 0 = Foods, 1 = Mold, 2 = Trees, 3 = Grass, 4 = Weeds, 5 = Animals',
                     required: 'The Group ID is required.',
                     maxlength: 'Group ID is 1 character long.'
                 }
             },
             submitHandler: function(form) {
                 $.ajax({
                     type: 'POST',
                     url: url,
                     data: $(form).serialize(),
                     success: function (response) {
                         if (response != '') {
                             console.log('response'+response);
                             json = JSON.parse(response);
                             console.log('json'+json);
                             $("#result_msg").empty().append(json.msg).css("color", "lightgreen");
                         }
                     },
                     error: function(xhr, status,response) {
                         console.log('status->'+status);
                         console.log('response->'+response);
                     }
                 });
             }

         });
    }
});
</script>


<?php  /* end template body */
return $this->buffer . ob_get_clean();
?>