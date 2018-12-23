// Util functions
// Open flash file
function openLabel() {
   // var theWin = "'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,width=612,height=792'";
//	littleWin = window.open('../swf/labels.swf','opened',theWin);
	//littleWin.resizeTo(612,792);
	//littleWin.focus();

    var theWin = "'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,width=812,height=992'";
    littleWin = window.open("../html/printLabel.html","opened",theWin);
    window.resizeTo(812,992);
    littleWin.focus();
}

function printpage() {
    window.print();
    document.forms["frm_report"].submit;
}

function printEntryPage(jsVar1,jsVar2,jsVar3) {
    window.print();
    document.forms["frm_treatment"].action ="update_entry_record.php?treat="+jsVar3+"&id=" + jsVar1 + "&aCnt=" + jsVar2;
}

function updateAllergen(id) {
    document.getElementById("submit").disabled = true;
    document.getElementById("update").disabled = false;
    document.getElementById("cancel").disabled = false;
    document.getElementById("allergenname").value = document.getElementById("antigenname"+id).value;
    document.getElementById("lotnumber").value = document.getElementById("lotNumber"+id).value;
    document.getElementById("expdate").value = document.getElementById("expDate"+id).value;
    document.getElementById("batteryname").value = document.getElementById("batteryName"+id).value;
    document.getElementById("caption").value= document.getElementById("caption"+id).value;
    document.getElementById("allergenid").value= document.getElementById("allergenID"+id).value;
    document.getElementById("groupid").value= document.getElementById("groupID"+id).value;
    document.getElementById("groupname").value= document.getElementById("groupName"+id).value;
    document.forms["frm_allergen"].submit;
}

function resetV(v,n) {
  var j = document.getElementsByTagName('select').length/2;
    for(var i=1; i <= j; i++) {
      var x = document.getElementById("Wheel"+n+i);
      x.selectedIndex  = v;
    }
}

function  deletePatient(id) {
    var r=confirm("Are your sure you want to Delete Patient?" );
    if (r===true) {
        var patientId = id;
        var ajax = new getXMLHttpRequestObject(); // this method is defined in the other Javascript file called 'ajax.js'
        alert(ajax);
        if (ajax) {
            var url="delete_patient.php?id="+patientId;
            ajax.open("get", url, true); // open Ajax with the GET method
            ajax.send(null);
            return false;
        }
     }else{
        alert('Patient Infromation NOT Deleted! ' + id );
    }
};

function updateDisable(id) {
    $(".message").empty();
    $.ajax({
        type: "POST",
        url: "disable_enable_allergen.php",
        data: {"id": id},
        success: function () {
            if ($("#disabled" + id).prop("checked")) {
                $("#disabled" + id).parent().parent().css("background", "darkgrey");
            } else {
                $("#disabled" + id).parent().parent().css("background", "white");
            }
            $(".message").append("Allergen updated.");
        },
        error: function (xhr, desc, err) {
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}

function deleteCustomAllergen(e) {
    patientID = $(e).data("patientid");
    allergenID = $(e).data("allergenid");
    $(".message").empty();
     $.ajax({
         type:"POST",
         url:"delete_custom_allergen.php",
         data: { "patientID": patientID,
                 "allergenID":allergenID},
         success: function(response) {
             json = JSON.parse(response);
             $("#allergenAddedMsg").empty().append(json.msg).css("color","red");
             $(e).closest("tr").remove();
         },
         error: function(xhr, desc, err) {
             console.log("Details: " + desc + "\nError:" + err);

         }
     });
}

function editCustomAllergen(e) {
    // e.preventDefault();
    var modal = document.getElementById("myModal");
    var allergenID = $(e).data("allergenid");
    var patientID  = $(e).data("patientid");
    $("#addBtn").hide();
    $("#editCusAllergenBtn").show();
    $.ajax({
     type: 'POST',
     url: 'get_custom_allergen.php',
     data: {
     "patientID": patientID,
     "allergenID": allergenID
     },
     success: function (response) {
         json = JSON.parse(response);
         $("#allergenID").val(json.allergenID);
         $("#allergenName").val(json.antigenName);
         $("#expDate").val(json.expDate);
         $("#lotNumber").val(json.lotNumber);
         $("#battery").val(json.batteryName);
         $("#groupID").val(json.groupID);
         $("#textArea").val(json.caption);
     },
     error: function (xhr, status, response) {
         console.log('status->' + status);
         console.log('response->' + response);
     }
     });
     modal.style.display = "block";
}
function getXMLHttpRequestObject() {
    var ajax = false;
    if (window.XMLHttpRequest) { // most mordern web browsers (IE7+, Firefox, Safari, Opera, Chrome)
        ajax = new XMLHttpRequest(); // true now
    }
    else if (window.ActiveXObject) { // older IE web browsers
        try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP"); // true now
        }
        catch(e) {
            try { // much older IE web browsers
                ajax = new ActiveXObject("Microsoft.XMLHTTP"); // true now
            }
            catch(e2) {
                window.alert("Get a mordern web browser please!");
            }
        }
    }
    return ajax;
};


function updateCustomField(e,s,name) {
    patientID   = $(e).data("patientid");
    allergenID  = $(e).data("allergenid");
    score       = s;
    fieldName   = name;
    $.ajax({
        type:"POST",
        url:"update_custom_analysis.php",
        data: { "patientID": patientID,
                "allergenID":allergenID,
                "score":score,
                "fieldName":fieldName
        },
        success: function() {
            console.log("Record updated!");

        },
        error: function(xhr, desc, err) {
            console.log("Details: " + desc + "\nError:" + err);
        }
    });

}

function updateField(id, value, name) {
    var ajax = new getXMLHttpRequestObject();
    if (ajax) {
        var patientId = document.getElementById("patientID").value;
        var anaCnt = document.getElementById("analysisCount").value;
        var url="update_analysis.php?id="+id+"&value="+value+"&name="+name+"&patientId="+patientId+"&anaCnt="+anaCnt;
        ajax.open("get", url, true);
        ajax.onreadystatechange = function() {
            myHandleResponseFunction(ajax,name,id,value);
        }
        ajax.send(null);
        return false;
    }
}

function myHandleResponseFunction(ajax, name, id, value) {
    if (ajax.readyState == 4) {
        if (ajax.status == 200) {
            $(".update_result").empty();
            $(".update_result").append(ajax.responseText);
            if(id != null) {
                var tableData = document.getElementById("antigen"+id);
                var wmsp = document.getElementsByName("wmsp"+id);
                var wisp = document.getElementsByName("wisp"+id);
                console.log(wmsp[0]);
                if (wmsp[0].value >=7 || wisp[0].value >=7 ){
                     tableData.style.color = "red"
                     $(tableData).addClass("print_red");
                }else{
                    tableData.style.color = "black";
                }
            } else if (name == "treatment") {
                document.forms["frm_treatment"].submit();
            }
        }
        else {
            document.getElementById("frm_analysis").submit();
        }
    }
}

function addRecords () {
    $('tr:nth-child(even)').css("background", "lightgrey");
    var optionOpen = "<option>";
    var optionOpenSelected = "<option selected>";
    var optionClose = "</option>";
    var selectItems = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];
    $(".selectNum").each(function () {
        for (key in selectItems) {
            if ($(this).data("wheelvalue") == selectItems[key]) {
                $(this).append(optionOpenSelected + $(this).data("wheelvalue") + optionClose);
            }
            else {
                $(this).append(optionOpen + selectItems[key] + optionClose);
            }
        }
    });
};

