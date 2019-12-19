<script>
var deviceName = document.getElementById('device_name');
var deviceManufacturer = document.getElementById('device_manufacturer');
var x = document.getElementById("articleSelect");
var deviceArticles = new Array();
function selectOnChange(){
	//console.log(x[x.options.selectedIndex]); 
	// try an if statement to unselect when clicked again. try the code below with a terany operator 
	//var testi = (x[x.options.selectedIndex].selected != true) ?  x[x.options.selectedIndex].selected = true : x[x.options.selectedIndex].selected = false;
	x[x.options.selectedIndex].selected = true;
	x[x.options.selectedIndex].style.color = "red";
	for (i = 0; i < x.length; i++) {
		if(x.options[i].selected == true && deviceArticles.includes(x.options[i].value) == false) {
			console.log(deviceArticles.includes(x.options[i].selected));
			deviceArticles.push(x.options[i].value);
			
	} else if(x.options[i].selected == true && deviceArticles.includes(x.options[i].value) == true) {
		deviceArticles = arrayRemove(deviceArticles, x.options[i].value)
		x[x.options.selectedIndex].style.color = "";
		}
	}
	//console.log(deviceArticles);
}
for (i = 0; i < x.length; i++) {
	//x.options[i].selected = false;
	x.options[i].addEventListener("mouseup", selectOnChange);
}
function arrayRemove(arr, value) {

   return arr.filter(function(ele){
       return ele != value;
   });

}
function displayMessage() {
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
	  //document.getElementById("response").innerHTML = 'waiiiting';
    if (this.readyState == 4 && this.status == 200) {
    	console.log(this.getAllResponseHeaders());
    	console.log(this.responseText);
    	document.getElementById("response").innerHTML = this.responseText;
	    
	    } 
  };
  xhttp.open("POST", "deviceAction.php?action=create&device_name="+deviceName.value+"&device_manufacturer="+deviceManufacturer.value+"&articles="+deviceArticles, true);
  xhttp.send();
}
</script>