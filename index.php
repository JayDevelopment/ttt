<?php 
    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0,0,0, (int) $data['month'], 1, (int) $data['year']);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');
    ?>
<div class="container">
<div style='margin:auto; text-align:center;'>
<h1> <?php echo "Hello, {$_SESSION['user']}!"; ?> </h1>
<h2> <?php echo "{$monthName} {$data['year']}"; ?></h2>
<a class='btn btn-sm btn-primary' href='./redirectToCalendar?month=<?php echo date('m', mktime(0,0,0,(int) ($data['month']-1),1,(int) $data['year'])); ?>&year=<?php echo date('Y', mktime(0,0,0,(int) ($data['month']-1),1,(int) $data['year']));?>'>Previous Month</a>
<a class='btn btn-sm btn-primary' href='./redirectToCalendar?month=<?php echo date('m')?>&year=<?php echo date('Y')?>'>Current Month</a>           
<a class='btn btn-sm btn-primary' href='./redirectToCalendar?month=<?php echo date('m', mktime(0,0,0,(int) ($data['month']+1),1,(int) $data['year'])) ?>&year=<?php echo date('Y', mktime(0,0,0,(int) ($data['month']+1),1,(int) $data['year'])) ?>'>Next Month</a>           
</div>
<br>
<table class='table table-bordered'>
<tr>
<?php 
foreach ($daysOfWeek as $day) {
?> 
<th class='header'><?php echo $day ?></th>
<?php } ?>
</tr><tr>
<?php 
if($dayOfWeek > 0) {
for($k=0;$k<$dayOfWeek;$k++){
?>
<td class='empty'></td>
<?php }
}
                
$currentDay = 1;
$month = str_pad($month, 2, "0", STR_PAD_LEFT);
                
while($currentDay <= $numberDays) {
                    
if($dayOfWeek == 7){
$dayOfWeek = 0;
?> 
</tr><tr>
<?php }                
$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
$date = "{$data['year']}-{$data['month']}-$currentDayRel";
$dayname = strtolower(date('l', strtotime($date)));
$eventNum = 0;
$today = $date==date('Y-m-d')? "today" : "";
if($date<date('Y-m-d')) {
?>
<td><h4>
<?php echo $currentDay?></h4>
<?php } else { ?>
<td class='<?php echo $today?>'><h6 style="color:red;float:right;"><?php echo "{$MODEL->countBookings($_SESSION['email'], $date)} booked";?></h6><h4><?php echo $currentDay?></h4><a href='redirectToBook?date=<?php echo $date?>' class='btn btn-success btn-sm' target='_blank'>Book</a>
<?php } ?>
</td>
<?php 
$currentDay++;
$dayOfWeek++;
}
if($dayOfWeek != 7){
$remainingDays = 7-$dayOfWeek;
for($i=0; $i<$remainingDays; $i++){
?>     
<td class='empty'></td>
<?php } } ?>
</tr>
</table>
</div>
