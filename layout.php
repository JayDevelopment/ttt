<?php ini_set ('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE); ?>
<!doctype html>
<html lang="en">
<head>
<title><?php echo $data['page']?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>
<body>
  <div id="wrapper" class="toggled">

    <div id="page-content-wrapper">

      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <?=$MASTER_CONTENT?>
          </div>
        </div>
      </div>
    </div>
  </div>
<footer>
	<div class='container'>
  		<p style="float:right;">Jay Merrill ©<?php echo date('Y'); ?></p>
  	</div>
</footer>
</body>

</html>