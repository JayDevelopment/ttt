<?php 
if(!isset($_REQUEST['id'])){ 
    header("Location: index.php"); 
} 
 
// Include the database config file 
require_once '/var/www/libs/db.php';
//require_once 'dbConfig.php'; 
 
// Fetch order details from database 
$result = query_db1("SELECT r.*, c.first_name, c.last_name, c.email, c.phone FROM testmerrill.orders as r LEFT JOIN testmerrill.customers as c ON c.id = r.customer_id WHERE r.id = "."({$_REQUEST['id']})"); 
 
if (mysqli_num_rows($result) > 0) {
    $orderInfo = result_db1($result); 
}else{ 
    header("Location: index.php"); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Order Status - PHP Shopping Cart</title>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="shoppingcart.css">
</head>
<body>
<header>
<div class="container">
<nav class = "navbar navbar-light rounded" ><a id='nav-bar' class="nav-item nav-link active ml-auto" href='index.php' target='_blank'>Search for More Devices</a></nav>
</div>
</header>
<br>
<div class="container">
    <h1>ORDER STATUS</h1>
    <hr>
    <br>
    <div class="col-12">
        <?php if(!empty($orderInfo)){ ?>
            <div class="col-md-12">
                <h6 class="alert alert-success">Your order has been placed successfully.</h6>
            </div>
			<br>
            <!-- Order status & shipping info -->
            <div class="row col-lg-12" style="display: block">
                <h4>Order Info</h4>
                <br>
                <p><b>Reference ID:</b> #<?php echo $orderInfo['id']; ?></p>
                <p><b>Total:</b> <?php echo '€'.$orderInfo['grand_total'].' EUR'; ?></p>
                <p><b>Placed On:</b> <?php echo $orderInfo['created']; ?></p>
                <p><b>Buyer Name:</b> <?php echo $orderInfo['first_name'].' '.$orderInfo['last_name']; ?></p>
                <p><b>Email:</b> <?php echo $orderInfo['email']; ?></p>
                <p><b>Phone:</b> <?php echo $orderInfo['phone']; ?></p>
            </div>
			<br>
            <!-- Order items -->
            <div class="row col-lg-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>QTY</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Get order items from the database 
                        $sql = "SELECT i.*, a.article_name, a.article_price FROM testmerrill.order_items as i LEFT JOIN testmerrill.Articles as a ON a.article_id = i.article_id WHERE i.order_id = ".$orderInfo['id']; 
                        $query = query_db1($sql);
                        if (mysqli_num_rows($query) > 0) {
                            while($item=result_db1($query)) {
                                $price = $item["article_price"]; 
                                $quantity = $item["quantity"]; 
                                $sub_total = ($price*$quantity); 
                        ?>
                        <tr>
                            <td><?php echo $item["article_name"]; ?></td>
                            <td><?php echo '€'.$price.' EUR'; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo '€'.$sub_total.' EUR'; ?></td>
                        </tr>
                        <?php } 
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php }  else{ ?>
        <div class="col-md-12">
            <div class="alert alert-danger">Your order submission failed.</div>
        </div>
        <?php } ?>
    </div>
</div>
</body>
</html>