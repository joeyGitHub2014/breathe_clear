<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Breathe Clear</title>
	<link href="../css/main.css" media="all" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap/css/bootstrap.min.css"  rel="stylesheet" type="text/css"/>
	<link href="../css/print.css" media="print" rel="stylesheet" type="text/css"/>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"
			integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
			crossorigin="anonymous"></script>
	<script type="text/javascript" src="../js/utils.js"></script>
	<script type="text/javascript" src="../js/ddaccordion.js"></script>
  
            
<!--
/***********************************************
* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/
-->
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	//Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	togglehtml: ["prefix", "<img src='../images/plus.gif' class='statusicon' />", "<img src='../images/minus.gif' class='statusicon' />"],
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>
</head>
    <body>

	<nav class = "navbar navbar-default navbar-fixed-top" >
		<div class="container">
			  <div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					  <span class="sr-only">Toggle navigation</span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="#">BreathClear</a>
			  </div>
			  <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1" >
				  <ul class="nav navbar-nav">
					  <li> <a href=add_patient.php>Add New Patient</a></li>
					  <li> <a href=list_patient.php>List Patients</span> </a></li>
					  <li> <a href=list_allergens.php>Allergen List</a></li>
					  <!--<li> <a href=#>Print Labels</a></li>-->
					  <li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Utils <span class="caret"></span></a>
						  <ul class="dropdown-menu" role="menu">
							  <li> <a  href=new_user.php>Add User</a></li>
							  <li> <a  href=review_testdata.php>Export Patient List</a></li>
						  </ul>
					  </li>
				  </ul>
				  <form class="navbar-form navbar-left" role="search" action="list_patient.php"   method ="post">
					  <div class="form-group">
						  <input type="text" class="form-control" placeholder="Last Name or Chart#"  name="search">
					  </div>
					  <button type="submit"  name="submit" class="btn btn-default">Submit</button>
				  </form>
				  <ul class="nav navbar-nav navbar-left">
					  <li> <a href=#>Patients: <?php
							  Patient::set_patient_table();
							  $total_count = Patient::count_all();
							  echo $total_count; ?></a></li>
					  <li> <a  href=logout.php>Logout</a></li>
				  </ul>
			  </div>
		</div>
	</nav>
	<div class="jumbotron" style="padding-top: 4.5em">
		<img class="displayed"  src="../images/breatheclear_logo.jpg" alt="Breathe Clear Institute"  />
	</div>
	<div id="main">
