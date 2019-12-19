<script>
var deviceSearch = document.getElementById('device_search');
var deviceNumber = document.getElementById('device_number');
//toggle the search option on and off
function disableField(id,id2){
	var disabled = (document.getElementById(id).disabled = false) ? document.getElementById(id).disabled = true : document.getElementById(id2).disabled = true;
	}
function disableError(id){
	document.getElementById(id).disabled = false;
	} 

// generate table requested by ajax showTable() below
function generateDynamicTable(data){
	var noOfArticles = data.length;
	
	if(noOfArticles>0){
		

		// CREATE DYNAMIC TABLE.
		var table = document.createElement("table");
		table.style.width = '100%';
		table.setAttribute('class', 'table table-hover table-border');
		/*table.setAttribute('border', '1');
		table.setAttribute('cellspacing', '0');
		table.setAttribute('cellpadding', '5');*/
		
		// retrieve column header

		var col = []; // define an empty array
		for (var i = 0; i < noOfArticles; i++) {
			for (var key in data[i]) {
				if (col.indexOf(key) === -1) {
					col.push(key);
				}
			}
		}
		
		// CREATE TABLE HEAD .
		var tHead = document.createElement("thead");	
			
		
		// CREATE ROW FOR TABLE HEAD .
		var hRow = document.createElement("tr");
		
		// ADD COLUMN HEADER TO ROW OF TABLE HEAD.
		for (var i = 0; i < col.length; i++) {
				var th = document.createElement("th");
				th.innerHTML = col[i];
				hRow.appendChild(th);
		}
		tHead.appendChild(hRow);
		table.appendChild(tHead);
		
		// CREATE TABLE BODY .
		var tBody = document.createElement("tbody");	
		
		// ADD COLUMN HEADER TO ROW OF TABLE HEAD.
		for (var i = 0; i < noOfArticles; i++) {
		
				var bRow = document.createElement("tr"); // CREATE ROW FOR EACH RECORD .
				
				
				for (var j = 0; j < col.length; j++) {
					var td = document.createElement("td");
					td.innerHTML = data[i][col[j]];
					bRow.appendChild(td);
				}
				tBody.appendChild(bRow)

		}
		table.appendChild(tBody);	
		
		
		// FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
		document.getElementById("response").appendChild(table);
	}	
	
}

function showTable() {
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    	//console.log(this.responseText);
	    if(/<\/h2>/.test(this.responseText)) {
    	document.getElementById("response").innerHTML = this.responseText;
	    } else {
	    //console.log(this.responseText);
	    parsedResponse = JSON.parse(this.responseText);
	    //console.log(parsedResponse);
	   generateDynamicTable(parsedResponse);
	    }
    }
  };
  xhttp.open("GET", "deviceAction.php?action=search&device_search="+deviceSearch.value+"&device_number="+deviceNumber.value+"&device_radio=on", true);
  xhttp.send();
  document.getElementById("response").innerHTML = '';
}

</script>