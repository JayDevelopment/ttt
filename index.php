<?php
ini_set ('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE);
//require "mvc_device_search_model.php";
//require "dbConfig.php";
//require_once "Devices.class.php";
//$error_css =  (strlen($_GET['device_search']) >= 3 ? "class='device_search'" : "class='text-danger'");
### THIS SHOPPING CART PROJECT NOT FOR PUBLIC USE, NOR ANY SOURCE CODE TO BE TAKEN FROM IT FOR OTHER PROJECTS. THANK YOU :) ###
?>
<!DOCTYPE html>
<html>
<head>
<title>Device Search</title> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="shoppingcart.css">
</head>
<body>
<header>
<div class="container">
<nav class = "navbar navbar-light rounded" ><a id='nav-bar' class="nav-item nav-link active ml-auto" href='addDevice.php' target='_blank'>Add a Device</a></nav>
</div>
</header>
<br>
<main role="main">
<article class="container">
<h1><strong>Search for Devices</strong></h1>
<hr>
<form> 
<h3><label for="device_number">Device Number</label></h3> 
<input type="text" class="form-control" id="device_number" name="device_number" value="" onmouseenter="disableField('device_number', 'device_search')" oninput="showTable()">
<br>
<br>
<h3><label for="device_search">Device Name</label></h3>
<input type="text" class="form-control" id="device_search" name="device_search" value="" onmouseenter="disableField('device_search', 'device_number')"  oninput="showTable()">
<br>
<!--  <input class="btn btn-success btn-md btn-block" type="submit"> -->
</form> 
</article>
<br>
<article class="container">

<!-- <table class="table table-hover"> -->
<!-- template html tags would be good to use around the JS included, but they are no recognized by Zend  -->
<?php
include_once 'indexScript.js';
/*if(isset($_GET) && $_GET['device_search'] != '' || $_GET['device_number'] != '') {
  $devices = new Devices();
  $devices->search = (isset($_GET['device_search'])) ? $_GET['device_search'] : '';
  $devices->number = (isset($_GET['device_number'])) ? $_GET['device_number'] : '';
  $query = $devices->read();
  if (mysqli_num_rows($query) > 0) {
      echo "<thead><tr><th>Device Number</th>
        <th>Device Name</th>
        <th>Device Manufacturer</th></tr></thead>";
      while($row=result_db1($query)) {
    echo "
    <tr> 
    <td><a href='viewArticles.php?device_number={$row["device_id"]}&device_search=$devices->search' target='_blank'>{$row["device_id"]}</a></td>
    <td>{$row['device_name']}</td>
    <td>{$row['device_manufacturer']}</td>
    </tr>";
    } 
  } 
} */
?>
<!-- </table> -->
<span id="response" style="margin:auto"></span>

</article>

</main>
</body>
</html>