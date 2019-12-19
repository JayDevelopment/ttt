<?php 
require_once '/var/www/libs/db.php';
class Book {
    public $user;
    public $timeslot;
    public $description;
    public $date;
    public $tableName = 'testmerrill.bookings';
    public $email;
    public $password;
    

    public function timeslots($duration, $cleanup, $start, $end)
    {
        $start = new DateTime($start);
        $end = new DateTime($end);
        $interval = new DateInterval("PT".$duration."M");
        $cleanupInterval = new DateInterval("PT".$cleanup."M");
        $slots = array();
        for ($intStart=$start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval))
        {
            
            /*$endPeriod = '24:00';
            if($endPeriod==$end)
            {
                $endPeriod->add($interval);
            }*/
            $slots[] = $intStart->format("H:iA");
        }
        //$slots[] = $intStart->add($end);
        return $slots;
    }
    public function read($email, $searchBy, $searchByData, $searchMultiple, $returnResult=0)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE email = '{$email}' AND $searchBy = '{$searchByData}'";
            $query = query_db1($sql);
            if (mysqli_num_rows($query) > 0 && !$searchMultiple) {
                while($row=result_db1($query)) {
                    $data[] = $row[$returnResult];
                
                }
                return $data;
            } else {
                if (mysqli_num_rows($query) > 0) {
                while($row=result_db1($query)) {
                    $subArray['description'] = $row['description'];
                    $subArray['timeslot'] = $row['timeslot'];
                }
                //$row = $subArray;
                return $subArray;
            }
            
        }
    }
    public function checkId($id)
    {
        $sql = "SELECT id FROM {$this->tableName} WHERE id = '{$id}'";
        $query = query_db1($sql);
        if (mysqli_num_rows($query) > 0) {
            while($row=result_db1($query)) {
                $id = $row['id'];
            }
            return $id;
        } else { return false; }
    }
    public function readOne($email, $searchBy, $searchByData, $detail)
    {
        //echo $id;
        $sql = "SELECT $detail FROM {$this->tableName} WHERE email = '{$email}' AND $searchBy = '{$searchByData}'";
        //echo $user;
        $query = query_db1($sql);
        if (mysqli_num_rows($query) > 0) {
            while($row=result_db1($query)) {
                $description = $row[$detail];
            }
            return $description;
        } else { return false; }
    }
    public function create($user, $email, $description, $date, $timeslot)
    {
        /*$this->readOne($timeslot);
        if(!in_array($timeslot, $bookings)){*/
        $this->user=$user;
        $this->email=$email;
        $this->description=$description;
        $this->date=$date;
        $this->timeslot=$timeslot;
       // $this->user = 'Jay';
        $sql = "INSERT INTO {$this->tableName} (user, email, description, date, timeslot)
        VALUES ('{$this->user}','{$this->email}','{$this->description}', '{$this->date}', '{$this->timeslot}')";
        query_db1($sql);
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
    public function delete($id, $email)
    {
        $sql = "DELETE FROM {$this->tableName}
                WHERE id = '{$id}' AND email = '{$email}' LIMIT 1";
                query_db1($sql);
    }
    public function update($id, $email, $description, $timeslot)
    {
        $sql= "UPDATE {$this->tableName}
        SET description = '{$description}',
        timeslot = '{$timeslot}'
        WHERE id = '{$id}' AND email = '{$email}'";
        query_db1($sql);
        //echo $id;
    }
 public function countBookings($email, $date)
 {
     $sql = "SELECT COUNT(date)
     FROM {$this->tableName} 
     WHERE date = '{$date}' AND email = '{$email}'"; //when you add the login functionality, select from where date = $date and user = $user
     $query = query_db1($sql);
     if (mysqli_num_rows($query) > 0) {
         while($row=result_db1($query)) {
             $count = $row['COUNT(date)'];
         }
         return $count;
     }
 }
 public function newUser($user, $emailu, $password)
 {
     $this->user = $user;
     $this->email=$emailu;
     $this->password=$password;
     // $this->user = 'Jay';
     $sql = "INSERT INTO testmerrill.users (user, email, password)
     VALUES ('{$this->user}','{$this->email}', '{$this->password}')";
     query_db1($sql);
 }
 public function authenticate($emailu, $password, $detail)
 {
     //echo $detail;
     $this->email=$emailu;
     $this->password=$password;
     $sql = "SELECT $detail FROM testmerrill.users WHERE email = '{$this->email}' AND password = '{$this->password}'";
     $query = query_db1($sql);
     if (mysqli_num_rows($query) > 0) {
         while($row=result_db1($query)) {
             $detailfinal = $row[$detail];
         }
         //echo $detailfinal;
         return $detailfinal;
     } else {
         return false;
     }
    }
}
?>