<?php 
if(!session_id()){
    session_start();
} 
ini_set ('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE);
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calendar App</title> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="calendar.css">
</head>
<body onload="displayCalendar()">
<div class="container">
<div class="row">
<div id="response" class="col-md-12">
</div>
</div>
</div>
<?php include 'calendarScript.js';?>
</body>
</html>