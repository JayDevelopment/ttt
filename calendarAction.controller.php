<?php 
if($_REQUEST['action'] == 'render') {
require 'Calendar.class.php';
$calendar = new Calendar();
$dateComponents = getdate();
if(isset($_REQUEST['month']) && isset($_REQUEST['year'])){
    $month = htmlspecialchars(strip_tags($_REQUEST['month']));
    $year = htmlspecialchars(strip_tags($_REQUEST['year']));
}else{
    $month = $dateComponents['mon'];
    $year = $dateComponents['year'];
}
$calendar->buildCalendar($month,$year);
}
?>