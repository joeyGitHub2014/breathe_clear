
function getLabel() {

   $.getJSON( "label.json", {

    format: "json"

  })
    .done(function( data ) {

        if (data.treatment == 0 || data.treatment == 1 ) {

			$('.ingredants').append(data.ingredients);
			$('.label').attr("style", "background : url('../images/AllergyDrops411x225.jpg') !important; background-size: 246px 137px !important;");
  
	      	if (data.refill == 0){

	      		$('.yellow').attr("style", "color : yellow !important;");

	      		$('.red').attr("style", "color : red !important;");

	      		$('.green').attr("style", "color : green !important;");

	      	}

        }else {
        	
 			$('.label').attr("style", "background : url('../images/AllergyInjection411x225.jpg') !important; background-size: 246px 137px !important;");

			$('.dl').append(data.dilutionLevel);

	      	(data.vialA != "") ? $('#label0 .ingredants').append(data.vialA) : $("#label0").css("display", "none");
	      		
	      	(data.vialB != "") ? $('#label1 .ingredants').append(data.vialB) : $("#label1").css("display", "none");

	      	(data.vialC != "") ? $('#label2 .ingredants').append(data.vialC) : $("#label2").css("display", "none");

	      	$("#label3").attr("style", "display: none" );
  
        }
 
		$('.name').append(data.name);

		$('.dob').append(data.dob);

		$('.lotNum').append(data.lotNum);

		$('.exp').append(data.exp);

		//Make the DIV's element draggagle:
		for(i=0; i <=3; i++) {

			dragElement("label"+ i);

		}


	    }) 

	    .fail(function(){

	    	console.log( "Error with JSON file. " );

	    });

};

function dragElement(elmnt) {
	
	var offset = 0,

		can = document.getElementById("canvas"),

		gridWidth = 740, gridHeight = 958,

		label = document.getElementById(elmnt),

		pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;

	//TweenLite.set(can, {height: gridHeight + 1, width: gridWidth + 1});

	//TweenLite.set(label, { width:246, height:137, lineHeight:137 + "px"});

	label.onmousedown = dragMouseDown;

	function dragMouseDown(e) {

	    e = e || window.event;

	    pos3 = e.clientX;

	    pos4 = e.clientY;

	    document.onmouseup = closeDragElement;

	    document.onmousemove = elementDrag;

	}

	function elementDrag(e) {

	    e = e || window.event;

	    // calculate the new cursor position:

	    pos1 = pos3 - e.clientX;

	    pos2 = pos4 - e.clientY;

	    pos3 = e.clientX;

	    pos4 = e.clientY;

	    // set the element's new position:

	    label.style.top = (label.offsetTop - pos2) + "px";

	    label.style.left = (label.offsetLeft - pos1) + "px";

	}

	function closeDragElement(e) {
	 
	    /* stop moving when mouse button is released:*/
	     
	    document.onmouseup = null;

	    document.onmousemove = null;

	    topPos = label.offsetTop;

	    leftPos = label.offsetLeft; 
	    
	 	TweenLite.to(label, 0.2, {

	      left:(Math.round(leftPos / 246) * 246) + offset,

	 	  top:(Math.round(topPos / 137) * 137) + offset,ease:Power2.easeInOut});
	 
	}

}