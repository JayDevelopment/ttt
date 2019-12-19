<?php 
ini_set ('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE);
require_once '/var/www/libs/db.php';
class Book {
        public $timeslot;
        public $description;
        public $date;
        public $tableName = 'testmerrill.bookings';
        
    
    public function timeslots($duration, $cleanup, $start, $end)
    {
        $start = new DateTime($start);
        $end = new DateTime($end);
        $interval = new DateInterval("PT".$duration."M");
        $cleanupInterval = new DateInterval("PT".$cleanup."M");
        $slots = array();
        
        for ($intStart=$start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval))
        {
            $endPeriod = clone $intStart;
            $endPeriod->add($interval);
            if($endPeriod>$end)
            {
                break;
            }
            $slots[] = $intStart->format("H:iA")."-".$endPeriod->format("H:iA");
        }
        return $slots;
    }
    public function read()
    {
            $query = "SELECT timeslot FROM {$this->tableName}";
            if (mysqli_num_rows($query) > 0) {
                while($row=result_db1($query)) {
                    $bookings[] = $row['timeslot'];
                }
            }
            return $bookings[];
    }
    public function insert($user, $timeslot, $description)
    {
        /*$stmt = $mysqli->prepare("select * from testmerrill.bookings where date = ? AND timeslot = ?");
        $stmt->bind_param('ss', $date, $timeslot);
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows>0){
                $msg = "<div class='alert alert-danger'>Already Booked</div>";
            } else {
                $stmt = $mysqli->prepare("INSERT INTO testmerrill.bookings (name, email, date, timeslot) VALUES (?,?,?,?)");
                
                $stmt->bind_param('ssss', $name, $email, $date, $timeslot);
                $stmt->execute();
                //var_dump($stmt);
                $msg = "<div class='alert alert-success'>Booking Successful</div>";
                $bookings[]=$timeslot;

            }
        }*/
    }

}
?>