<?php 
ini_set ('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE);
require_once '/var/www/libs/db.php';
class Calendar {
    
public function buildCalendar($month, $year) {
    
    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0,0,0, (int) $month, 1, (int) $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');
    
    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    
    $calendar .= "<a class='btn btn-sm btn-primary' href='?month="
        .date('m', mktime(0,0,0,(int) ($month-1),1,(int) $year))
        ."&year=".date('Y', mktime(0,0,0,(int) ($month-1),1,(int) $year))
                  ."'>Previous Month</a>";
    
    $calendar .= "<a class='btn btn-sm btn-primary' href='?month="
                  .date('m')."&year=".date('Y')."'>Current Month</a>";
    
    $calendar .= "<a class='btn btn-sm btn-primary' href='?month="
        .date('m', mktime(0,0,0,(int) ($month+1),1,(int) $year))
        ."&year=".date('Y', mktime(0,0,0,(int) ($month+1),1,(int) $year))
                  ."'>Next Month</a></center><br>";
   
    $calendar .= "<tr>";
    
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }
    $calendar .= "</tr><tr>";
    
    if($dayOfWeek > 0) {
        for($k=0;$k<$dayOfWeek;$k++){
            $calendar .= "<td class='empty'></td>";
        }
    }
    
    $currentDay = 1;
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    
    while($currentDay <= $numberDays) {
        
        if($dayOfWeek == 7){
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }
        
        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        
        $dayname = strtolower(date('l', strtotime($date)));
        $eventNum = 0;
        $today = $date==date('Y-m-d')? "today" : "";
        if($date<date('Y-m-d')) {
            $calendar .= "<td><h4>$currentDay</h4>";
        } /*elseif(in_array($date, $bookings)){
            $calendar.="<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-sm'>Already Booked</button>";
        }*/else {
            $calendar .= "<td class='$today'><h4>$currentDay</h4><a href='book.php?date=".$date."' class='btn btn-success btn-sm'>Book</a>";
        }
      
        $calendar .= "</td>";
        
        $currentDay++;
        $dayOfWeek++;
    }
    
    if($dayOfWeek != 7){
        $remainingDays = 7-$dayOfWeek;
        for($i=0; $i<$remainingDays; $i++){
            $calendar .= "<td class='empty'></td>";
        }
    }
    $calendar .="</tr>";
    $calendar .="</table>";
    
    echo $calendar;
    
    }
}
?>