<?php 
if(!session_id()){
    session_start();
}
?>
<div class="container" style="margin-bottom:1em;">
        <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($data['date'])); ?></h1><hr>
        <div class="row">
        	<div class="col-md-12">
        	
        		<button class="btn btn-success book" value='' onclick="getDescription(this);">Create New Event</button><br>
        		
        		<?php 
        		$bookings = $MODEL->read($_SESSION['email'], 'date', $data['date'], false, 'timeslot');
        		foreach ($bookings as $booked) {
        		?>
        		<button  id="<?php echo $MODEL->readOne($_SESSION['email'], 'timeslot', $booked, 'id');?>" class="btn btn-success book" value="<?php echo $booked;?>" onclick="getDescription(this)" style="margin-top: 1em"><?php echo $booked?></button>
        		<?php }?>
				
			</div>
      </div>
</div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
          	<h4 class="modal-title">Booking: <?php echo $data['date']?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
          <h5 id="response"></h5>
            <div class="row">
            	<div class="col-md-12">
            		<form id="mform">
            			<div class="form-group">
							<?php ?>
            				<label for="timeslotbegin">Begin</label>
            				<select required name="timeslotbegin" id="timeslotbegin" class="form-control">
            					<?php 
            					$timeslots = $MODEL->timeslots($duration=30, $cleanup=0, $start="00:00", $end="24:30");
            					//var_dump($timeslots);
            					echo '00:00AM';
                                  foreach ($timeslots as $ts){
                               
                                 ?>
                                 <option id="" value=""><?php echo $ts?></option>
                                 <?php }?>
            				</select>
            				
            				
            				<label for="timeslotend">End</label>
            				<select required name="timeslotend" id="timeslotend" class="form-control">
            				<?php 
                                  $timeslots = $MODEL->timeslots($duration=30, $cleanup=0, $start="00:00", $end="24:30");
                                  foreach ($timeslots as $ts){
                                 ?>
                                 <option id="" value=""><?php echo $ts?></option>
                                 <?php }?>
            				</select>
            				
            			</div>
            			<div class="form-group">
            				<label for="description">Description</label>
            				<textarea required form='mform' name="description" id="description" class="form-control" maxlength="150"></textarea>
            			</div>
            			<div class="form-group">
            				<button class="btn btn-primary"  id='send' value="" type="button" name="send" onclick="insertData()">Submit</button>
            				<button class="btn btn-danger"  id='eraseIt' value="" type="button" name="eraseIt" onclick="erase(this.value)">Delete</button>
            			</div>
            		</form>
            	</div>
            </div>
          </div>
        </div>
	  </div>
    </div>
<script type="text/javascript">

function getDescription(e) {
	var id = e.id;
	//var test=document.getElementById("timeslotbegin").options.add(new Option(e.value.substr(0,7)), '0');
	//var test1=document.getElementById("timeslotend").options.add(new Option(e.value.substr(8,13)), '0');
	//console.log(test);
	//console.log(test1);
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		  //document.getElementById("description").innerHTML = 'waitingggg';
	    if (this.readyState == 4 && this.status == 200) {
	    	console.log(this.responseText);
	    	document.getElementById("description").innerHTML = this.responseText;
	    	// WELCOME BACK! Keep trying to make this functionality below work :)

	    	document.getElementById("timeslotbegin").options[timeslotbegin.selectedIndex].innerHTML = e.value.substr(0,7);
	    	document.getElementById("timeslotend").options[timeslotend.selectedIndex].innerHTML = e.value.substr(8,13);
	    	//console.log(test);
	    	//console.log(document.getElementById("timeslotend").options[0].innerHTML);
	    	document.getElementById("send").value = e.id;
	    	document.getElementById("eraseIt").value = e.id;
	    	//console.log(e.id); 
		    } 
	  };
	  xhttp.open("GET", "readOne?detail=description&searchBy=id&searchByData="+id+"&email="<?php $_SESSION['email']?>, true);
	  xhttp.send();
	  //document.getElementById("description").innerHTML = '';
	}

function insertData() {
	var timeslotbegin = document.getElementById("timeslotbegin");
	console.log(timeslotbegin);
	var timeslotbeginValue = timeslotbegin.options[timeslotbegin.selectedIndex].innerHTML;
	console.log(timeslotbeginValue);
	var timeslotend = document.getElementById("timeslotend");
	var timeslotendValue = timeslotend.options[timeslotend.selectedIndex].innerHTML;
	//console.log(timeslotendValue+1);
	var description= document.getElementById("description").value;
	var send = document.getElementById("send").value;
	//console.log(send); 
	//var time = e.id;
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		  //document.getElementById("description").innerHTML = 'waitingggg';
	    if (this.readyState == 4 && this.status == 200) {
	    	console.log(this.responseText);
	    	document.getElementById("response").innerHTML = this.responseText;
	    	setTimeout(function() 
	    			  {
	    			    location.reload();  //Refresh page
	    			  }, 700);
	    			}

	  };
	  xhttp.open("POST", "create?id="+send+"&date=<?php echo $data['date']?>&timeslotbegin="+timeslotbeginValue+"&timeslotend="+timeslotendValue+"&description="+description, true);
	  xhttp.send();
	  //location.reload();
	  //document.getElementById("description").innerHTML = '';
	}
function erase(en) {
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	console.log(this.responseText);
	    	document.getElementById("response").innerHTML = this.responseText;
	    	setTimeout(function() 
	    			  {
	    			    location.reload();  //Refresh page
	    			  }, 700);
	    	//var eraseNote = document.getElementById("erase").value;
	    	//console.log(eraseNote); 
		    } 
	  };
	  xhttp.open("GET", "delete?id="+en+"&email="<?php $_SESSION['email']?>, true);
	  xhttp.send();
	  //document.getElementById("description").innerHTML = '';
	}
$(".book").click(function(){
	//var timeslot = $(this).attr('data-timeslot');
	//$("#slot").html(timeslot);
	//$("#timeslot").val(timeslot);
	//$("#description").val();
	$("#myModal").modal("show");
});
</script>    