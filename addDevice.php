<?php
ini_set ('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE);
/*require "mvc_device_search_model.php";
 $model = new Model();
 $db = $model->getConnection();
 $devices = new Devices($db);
 $articles = new Articles($db);*/
//require "dbConfig.php";
require "Articles.class.php";
require "Devices.class.php";
$device = new Devices();
$article = new Articles();
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Device</title> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="shoppingcart.css">
</head>
<body>
<header>
<div class="container">
<nav class = "navbar navbar-light rounded" ><a id='nav-bar' class="nav-item nav-link active ml-auto" href='index.php' target='_blank'>Search For A Device</a></nav>
</div>
</header>
<br>
<main role="main">
<article class="container">
<h1><strong>Add a Device</strong></h1>
<hr>
<form>
 <h3><label for="device_name" class=''>Device Name:</label></h3> 
<input type="text" id="device_name" name="device_name" class="form-control" value="<?php echo $_POST['device_name']?>" required>
<br>
<h3><label for="device_manufacturer" class=''>Device Manufacturer:</label></h3>
<input type="text" id="device_manufacturer" name="device_manufacturer" class="form-control" value="<?php echo $_POST['device_manufacturer']?>" required>
<br>
 <h3><label for="articleSelect" class=''>Select Article Connections:</label></h3> 
<div class="contactselect">
<?php 
    $query = $article->readAll();
    if (mysqli_num_rows($query) > 0) { ?>
<select id="articleSelect" name="articles[]" multiple size='4' class="form-control" required>
<?php
    while($row=result_db1($query)) {
?>
<option id="<?php echo "{$row['article_id']}"?>" value="<?php echo "{$row['article_id']}"?>"><?php echo "{$row['article_name']}"?> </option>
<?php } } else { $device->dieMessage('text-info', 'Please contact our support team'); }?>
</select>
</div>
<br>
<!--<label class='responsive'>Add a Picture:</label>
<input type="file" name="image"> -->
<br>
<input type="button" value="Create Device" class="btn btn-success btn-md" onclick="displayMessage()">
<br>
</form>
<?php require_once 'addDeviceScript.js';?>
<br>
<span id="response" style="margin:auto"></span>
</article>
</main>
</body>
</html>