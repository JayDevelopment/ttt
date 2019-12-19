<?php 
if(!session_id()){
    session_start();
} 
//$redirectLoc = 'index.php'; 
//if($_REQUEST['action'] == 'render') {
require 'Book.class.php';
$book = new Book();
//$mysqli = new mysqli('localhost', 'root', '', 'edms');
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    //$book->read($date);
//}
/*if($_REQUEST['action'] == 'submit') {
require 'Book.class.php';
$book = new Book();
*/
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $timeslot = $_POST['timeslot'];
    //book->insert($name, $email, $date, $timeslot)
    }
    /*$_SESSION['msg'] = $msg;
    $redirectLoc = 'book.php';
    header("Location: $redirectLoc");
}*/
?>