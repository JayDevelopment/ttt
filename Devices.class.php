<?php
require_once '/var/www/libs/db.php';
class Devices {
    //private $conn;
    private $table_name = "testmerrill.Devices";
    public $number;
    public $search;
    public $manufacturer;
    public $article;
    public $result;
    public $sql;
    //public $sessionStart = session_start();
    //public $error_css =  (strlen($this->search) >= 3 ? "class='device_search'" : "class='red'");
    /*public function __construct(){

    }*/
    // string as type set because it is being run through json encode
    private function validate(string $number, string $search, $result/*, $stmt*/) {
        if(isset($number) && $number != '' && empty($search) && $result->num_rows == 0/*&& $stmt->rowCount() == false*/) {
            $this->dieMessage('text-danger',"*The device number {$number} is invalid");
     
        } elseif(isset($search) && $search != '' && empty($number) && $result->num_rows == 0/*&& $stmt->rowCount() == false*/) {
            //$this->check_string_length($search);
            $this->dieMessage('text-danger',"*There were no matches for {$search}");
  
        } 
    }
    private function check_string_length (string $string) {
        if(strlen($string) < 3) {
            //$error_css = 'error';
            $this->dieMessage('text-danger', 'Not enough characters');
        }
    }
    public function dieMessage(string $class, string $string){
        
        echo "<h2 class = {$class}>{$string}</h2>";
        die();
        
    }
  public function test_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
  public function read() {

      if(isset($this->number) && $this->number != '' && empty($this->search)) {
          /*$sql = "SELECT device_id, device_name, device_manufacturer
          FROM {$this->table_name}
          WHERE device_id = :number LIMIT 1";
          $stmt = $this->conn->prepare($sql);
          $this->number=htmlspecialchars(strip_tags($this->number));
          $stmt->bindParam(':number', $this->number);*/
          $this->number=$this->test_data($this->number);
          $sql = "SELECT device_id, device_name, device_manufacturer
          FROM {$this->table_name}
          WHERE device_id = '{$this->number}' LIMIT 1";
      }  elseif (isset($this->search) && $this->search != '' && empty($this->number)) {
          /*$sql = "SELECT device_id, device_name, device_manufacturer
          FROM {$this->table_name}
          WHERE device_name LIKE :search LIMIT 50";
          $stmt = $this->conn->prepare($sql);
          $this->search=htmlspecialchars(strip_tags($this->search))."%";
          $this->check_string_length($this->search);
          $stmt->bindParam(':search', $this->search);*/
          $this->search=$this->test_data($this->search);
          $sql = "SELECT device_id, device_name, device_manufacturer
          FROM {$this->table_name}
          WHERE device_name LIKE '{$this->search}%' LIMIT 50";
          $this->check_string_length($this->search);
      } elseif($this->number == '' && $this->search == '') {
          $this->dieMessage('text-info', "Search above to view devices");
      } else {
          $this->dieMessage('text-danger','*Please search by only number or name!');
      }
      //$this->result = $this->conn->query($sql);
      $this->result = query_db1($sql);
      $this->validate($this->number, $this->search, $this->result);
      return $this->result;
         /* $stmt->execute();
          $this->validate($this->number, $this->search, $stmt);
          return $stmt;*/
  }

  public function create(string $device_name, string $device_manufacturer, $articles) {
      //echo $device_name . $device_manufacturer . $articles;
      /*if(isset($device_name) && isset($device_manufacturer) && isset($articles)) {*/
          
          /*$sql_update1 = "INSERT INTO {$this->table_name} (device_name, device_manufacturer) 
                          VALUES (:name, :manufacturer)";
          $stmt = $this->conn->prepare($sql_update1);
          $this->name=htmlspecialchars(strip_tags($device_name));
          $this->manufacturer=htmlspecialchars(strip_tags($device_manufacturer));
          $stmt->bindParam(":name", $this->name);
          $stmt->bindParam(":manufacturer", $this->manufacturer);
          $stmt->execute();
          $last_id = $this->conn->lastInsertId();
          
          $sql_update2 = "INSERT INTO testmerrill.Device_Article_Connection (device_id, article_id)
              VALUES (:last_id,:article)";
          $stmt = $this->conn->prepare($sql_update2);
         // $this->article=htmlspecialchars(strip_tags($article));
          $stmt->bindParam(":last_id", $last_id);
          $stmt->bindParam(":article", $article);
          
          foreach ($articles as $article) {
              $stmt->execute();
          } */
            //var_dump($articles);
            //$articles = str_split($articles, 1);
          //$articles = explode(',', $articles);
          /*if(preg_match('/^[\w]+\s?[0-9]*?\\.?[0-9]*?$/', $device_name) && preg_match('/^[\w]+\s?[0-9]*?\\.?[0-9]*?$/', $device_manufacturer)) {*/
      
              $this->name=$this->test_data($device_name);
              $this->manufacturer=$this->test_data($device_manufacturer);
              $sql_update1 = "INSERT INTO {$this->table_name} (device_name, device_manufacturer)
              VALUES ('{$this->name}', '{$this->manufacturer}')";
              query_db1($sql_update1);
              $last_id = "LAST_INSERT_ID()";
          
          foreach ($articles as $article) {
              $article = (int) $article;
              /*if(preg_match('/[1-9]+/i', $article)) {*/
                  $this->article=$this->test_data($article);
                  $sql_update2 = "INSERT INTO testmerrill.Device_Article_Connection (device_id, article_id)
                  VALUES ($last_id, '{$article}')";
                  query_db1($sql_update2);
              }/* else {
                $this->dieMessage('text-danger',"*Please insert valid articles."); 
            } */
          //}
      
         //$this->dieMessage('text-success', 'Device Created');
      //} 
      /*else {
          $this->dieMessage('text-danger','*Please insert valid data');
      } */
      } 
      
      
}

//}

?>