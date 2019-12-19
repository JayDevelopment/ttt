<?php
if(!session_id()){
    session_start();
} 
ini_set ('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE);
require 'bookAction.controller.php';
?>
<!DOCTYPE HTML>
<html lang="en">

 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Appointment</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
      	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
 </head>
 <body>
    <div class="container">
        <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); ?></h1><hr>
        <div class="row">
        	<div class="col-md-12">
        		<?php echo isset($_SESSION['msg'])?$_SESSION['msg']:"";?>
       	 	</div>
            <?php 
              $timeslots = $book->timeslots($duration=30, $cleanup=0, $start="00:00", $end="24:00");
              foreach ($timeslots as $ts){
            ?>
            <div class="col-md-2">
            	<div class="form-group">
            	<?php if(in_array($ts, $bookings)){?>
            	          <button class="btn btn-danger book"><?php echo $ts;?></button>
            	
            	<?php } else { ?>
            	          <button class="btn btn-success book" data-timeslot="<?php echo $ts;?>"><?php echo $ts;?></button>
            	
            	<?php } ?>
            	</div>
            </div>
            <?php 
              }
               
            ?>
        </div>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
          	<h4 class="modal-title">Booking: <span id="slot"></span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="row">
            	<div class="col-md-12">
            		<form action="bookAction.php" method="post">
            			<div class="form-group">
            				<label for="">Timeslot</label>
            				<input type="text" readonly name="timeslot" id="timeslot" class="form-control">
            			</div>
            			<div class="form-group">
            				<label for="">Name</label>
            				<input required type="text" value="" name="name" id="name" class="form-control">
            			</div>
            			<div class="form-group">
            				<label for="">Email</label>
            				<input required type="text" value="" name="email" id="email" class="form-control">
            			</div>
            			<input type="hidden" name="action" value="submit"/>
            			<div class="form-group">
            				<button class="btn btn-primary" type="submit" name="submit">Submit</button>
            			</div>
            		</form>
            	</div>
            </div>
          </div>
        </div>
	  </div>
    </div>
<script type="text/javascript">
/*function renderBookDays() {
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	console.log(this.responseText);
	    	//document.getElementById("response").innerHTML = this.responseText;
		    
		    } 
	  };
	  xhttp.open("GET", "bookAction.controller.php?action=render", true);
	  xhttp.send();
	}*/

$(".book").click(function(){
	var timeslot = $(this).attr('data-timeslot');
	$("#slot").html(timeslot);
	$("#timeslot").val(timeslot);
	$("#myModal").modal("show");
})
</script>    
</body>
</html>