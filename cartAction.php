<?php 
ini_set ('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE);
require_once 'Cart.class.php'; 
$cart = new Cart; 
require_once '/var/www/libs/db.php';
//require_once 'dbConfig.php'; 
 
// Default redirect page 
$redirectLoc = 'index.php'; 
 
// Process request based on the specified action 
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){ 
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){ 
        $articleID = $_REQUEST['id']; 
         
        // Get article details 
        $sql = "SELECT * FROM testmerrill.Articles WHERE article_id = ".$articleID;
        $query = query_db1($sql);
        $row = result_db1($query);
        $itemData = array( 
            'id' => $row['article_id'], 
            'name' => $row['article_name'], 
            'price' => $row['article_price'], 
            'qty' => 1 
        ); 
         
        // Insert item to cart 
        $insertItem = $cart->insert($itemData); 
         
        // Redirect to cart page 
        $redirectLoc = $insertItem?'viewCart.php':'index.php'; 
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){ 
        // Update item data in cart 
        $itemData = array( 
            'rowid' => $_REQUEST['id'], 
            'qty' => $_REQUEST['qty'] 
        ); 
        $updateItem = $cart->update($itemData); 
         
        // Return status 
        echo $updateItem?'ok':'err';die; 
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){ 
        // Remove item from cart 
        $deleteItem = $cart->remove($_REQUEST['id']); 
         
        // Redirect to cart page 
        $redirectLoc = 'viewCart.php'; 
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0){ 
        $redirectLoc = 'checkout.php'; 
         
        // Store post data 
        $_SESSION['postData'] = $_POST; 
     
        $first_name = strip_tags($_POST['first_name']); 
        $last_name = strip_tags($_POST['last_name']); 
        $email = strip_tags($_POST['email']); 
        $phone = strip_tags($_POST['phone']); 
        $address = strip_tags($_POST['address']); 
         
        $errorMsg = ''; 
        if(!preg_match('/^[A-Za-z]+$/', $first_name)){ 
            $errorMsg .= 'Please enter a valid first name.<br/>'; 
        } 
        if(!preg_match('/^[A-Za-z]+$/', $last_name)){ 
            $errorMsg .= 'Please enter a valid last name.<br/>'; 
        } 
        if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)){ 
            $errorMsg .= "Please enter a valid email address.<br/>"; 
        } 
        if(!preg_match('/^[0-9\-]+$/', $phone)){ 
            $errorMsg .= 'Please enter a valid phone number.<br/>'; 
        } 
        if(!preg_match('/[A-Za-z0-9\-\\,.]+/', $address)){ 
            $errorMsg .= 'Please enter a valid address.<br/>'; 
        } 
        
        if(empty($errorMsg)){ 
            // Insert customer data in the database 
            $insertCust = query_db1("INSERT INTO testmerrill.customers (first_name, last_name, email, phone, address) VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$phone."', '".$address."')"); 
             //error here on checkout --FIXED
            
            if($insertCust){ 
                // ASK ABOUT THIS with their DB abstraction 
                $custID = 'SELECT id FROM testmerrill.customers ORDER BY id DESC LIMIT 1';
               // $custID = $db->insert_id; 
               // $custID = "SELECT id FROM testmerrill.customers ORDER BY id DESC LIMIT 1";
                // Insert order info in the database 
                $insertOrder = query_db1("INSERT INTO testmerrill.orders (customer_id, grand_total, created, status) VALUES (($custID), '".$cart->total()."', NOW(), 'Pending')"); 
             
                
                if($insertOrder){ 
                    // ASK ABOUT THIS with their DB abstraction 
                    $orderID = 'SELECT id FROM testmerrill.orders ORDER BY id DESC LIMIT 1';
                    //$orderID = $db->insert_id; 
                    //$orderID = "SELECT customer_id FROM testmerrill.orders ORDER BY customer_id DESC LIMIT 1";
                    // Retrieve cart items 
                    $cartItems = $cart->contents(); 
                     
                    // Prepare SQL to insert order items 
                    //$sql = ''; 
                    foreach($cartItems as $item){ 
                        $sql = "INSERT INTO testmerrill.order_items (order_id, article_id, quantity) VALUES (($orderID), '".$item['id']."', '".$item['qty']."');"; 
                        query_db1($sql);
                        $test_true = true;
                    } 
                     
                    // Insert order items in the database 
                    // ASK ABOUT THIS with their DB abstraction (multiple queries??)
                    //$insertOrderItems = query_db1($sql); 
                     
                    if($test_true){ 
                        // Remove all items from cart 
                        $cart->destroy(); 
                         
                        // Redirect to the status page 
                        $redirectLoc = 'orderSuccess.php?id='.$orderID; 
                    }else{ 
                        $sessData['status']['type'] = 'error'; 
                        $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
                    } 
                }else{ 
                    $sessData['status']['type'] = 'error'; 
                    $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
                } 
            }else{ 
                $sessData['status']['type'] = 'error'; 
                $sessData['status']['msg'] = 'Some problem occurred, please try again.'; 
            } 
        }else{ 
            $sessData['status']['type'] = 'error'; 
            $sessData['status']['msg'] = 'Please fix all the mandatory fields:<br>'.$errorMsg;  
        } 
        $_SESSION['sessData'] = $sessData; 
    } 
} 
 
// Redirect to the specific page 
header("Location: $redirectLoc"); 
exit();