<script>
function displayCalendar() {
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	console.log(this.responseText);
	    	document.getElementById("response").innerHTML = this.responseText;
		    
		    } 
	  };
	  xhttp.open("GET", "calendarAction.controller.php?action=render&month=<?php echo $_GET['month']?>&year=<?php echo $_GET['year']?>", true);
	  xhttp.send();
	}
</script>