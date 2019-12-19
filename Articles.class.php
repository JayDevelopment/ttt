<?php 
class Articles {
    //public $conn;
    private $table_name = "testmerrill.Articles";
    public $number;
    public $name;
    public $price;
    public $errorMessage;
    public $error = false;
    public $result;
    public $sql;
    /*public function __construct(){
        
    }*/
 //reads all articles
  public function readAll() {
          //select all data
          $query = "SELECT
                    article_id, article_name
                FROM {$this->table_name} 
                ";
          $this->result = query_db1($query);
          return $this->result;
          //$this->result = $this->conn->query( $query );
          //return $this->result;
          
          /*$stmt = $this->conn->prepare( $query );
           * $stmt->execute();
          return $stmt;*/
  }
  //connects chosen device to articles and queries for all articles connected
  public function viewDeviceConnections() {
      $query = "SELECT Articles.article_id, article_name, article_price
      FROM {$this->table_name}
      INNER JOIN testmerrill.Device_Article_Connection ON Device_Article_Connection.article_id=Articles.article_id
      WHERE device_id = '{$this->number}'";
      $this->result = query_db1( $query );
      return $this->result;
      /*$stmt = $this->conn->prepare( $query );
      $stmt->execute();
      return $stmt;*/
  }
  // This method was for a different version of the program, not currently in use
  /*public function verifyArticleQuantity() {
      $counter = 0;
      foreach ($_POST['article_qty'] as $article) {
          if(!is_numeric($article) || $article < 0) { $article='';}
          if($article == '') { $counter++; }
          if($counter == count($_POST['article_qty'])) { 
              $this->errorMessage = "<p class='error'>Please choose some articles</p>";
              $this->error = true;
          } else {
              $_SESSION['article_qty'] = $_POST['article_qty'];
          }
      } 
  } */
  
}
?>