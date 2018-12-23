<div id="container" >
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div style="background:lightblue" id="canvas" > 
                <div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>  
                <div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>  
                <div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>  
                <div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>  
                <div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>  
                <div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>  
                <div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>
     
                <div class ="label"  id="label0" >
                    <div class="yellow ingredants"></div> 
                    <div class="yellow rotatedText name"> </div>
                    <div class="yellow rotatedText dob"> </div>
                    <div class="yellow rotatedText lotNum"> </div>
                    <div class="yellow exp">EXP:  </div>
                    <div class="yellow  dl"></div>              
                </div>  

                <div class ="label"  id="label1"> 
                    <div class="green ingredants"></div> 
                    <div class="green rotatedText name"> </div>
                    <div class="green rotatedText dob"> </div>
                    <div class="green rotatedText lotNum"> </div>
                    <div class="green exp">EXP: </div>
                    <div class="green dl"></div>                
                </div> 

                <div class ="label"  id="label2"> 
                    <div class="red ingredants"></div> 
                    <div class="red rotatedText name"> </div>
                    <div class="red rotatedText dob"> </div>
                    <div class="red rotatedText lotNum"> </div>
                    <div class="red exp">EXP:  </div>
                    <div class="red dl"></div>              
                </div> 

                <div class ="label"  id="label3"> 
                    <div class="ingredants"></div> 
                    <div class="rotatedText name"> </div>
                    <div class="rotatedText dob"> </div>
                    <div class="rotatedText lotNum"> </div>
                    <div class="exp">EXP:  </div>
                    <div class="dl"></div>              
                </div> 
            </div>

        </div>
        <button class = "prtBtn" onclick="window.print(); return false;">
            <b>PRINT </b>
        </button>    
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenLite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/plugins/CSSPlugin.min.js""></script>
<script src="../js/printLabels.js"></script>
<script>
 
$(document).ready(function () {
        var showPanelBtn = document.getElementById("showLabelPanelBtn");
        var modal = document.getElementById("myModal");
        getLabel();

        // When the user clicks the button, open the modal
        showPanelBtn.onclick = function (e) {
            e.preventDefault();
            modal.style.display = "block";
        }      

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
                location.reload();
            }
        }

    });
</script>


