<?php 
ini_set ('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE);
//require_once 'dbConfig.php'; 
require_once '/var/www/libs/db.php';
include_once 'Cart.class.php'; 
include_once "Articles.class.php";
$cart = new Cart; 
$articles = new Articles();
$articles->number = (isset($_GET['device_number'])) ? $_GET['device_number'] : '';
$_SESSION['device_number'] = $articles->number;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Shopping Cart</title>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="shoppingcart.css">
</head>
<body>
<div class="container">
    <h1>ARTICLES</h1>
	
    <!-- Cart basket -->
    <div class="cart-view">
        <a href="viewCart.php" title="View Cart"><i class="icart"></i> (<?php echo ($cart->total_items() > 0)?$cart->total_items().' Items':'Empty'; ?>)</a>
    </div>
    <br>
    <!-- Product list -->
    <div class="row col-lg-12">
        <?php 
        // Get articles from database 
        $query = $articles->viewDeviceConnections();
        if (mysqli_num_rows($query) > 0) {
            while($row=result_db1($query)) {
        ?>
        <div class="card col-lg-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row["article_name"]; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Price: <?php echo '€'.$row["article_price"].' EUR'; ?></h6>
                <a href="cartAction.php?action=addToCart&id=<?php echo $row["article_id"]; ?>" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
        <?php } }else{ ?>
        <p>Product(s) not found...</p>
        <?php } ?>
    </div>
</div>
</body>
</html>