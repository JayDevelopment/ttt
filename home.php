<?php 
class Home extends Controller 
{
    public function index($msg='')
    {
        $model = $this->model('Book');
        $this->view('login/login', ['page' => 'Login', 'msg' => $msg, 'base' => $this->base],
        'layout.php', $model);
    }
    public function redirectToRegister()
    {
        $model = $this->model('Book');
        $this->view('login/register', ['page' => 'Register', 'base' => $this->base],
            'layout.php', $model);
    }
    public function redirectToCalendar()
    {
        if(!session_id()){
            session_start();
        } 
        $dateComponents = getdate();
        if(isset($_REQUEST['month']) && isset($_REQUEST['year'])){
            $month = htmlspecialchars(strip_tags($_REQUEST['month']));
            $year = htmlspecialchars(strip_tags($_REQUEST['year']));
        }else{
            $month = $dateComponents['mon'];
            $year = $dateComponents['year'];
        }
        $model = $this->model('Book');
        $this->view('home/index', ['page' => 'Home', 'base' => $this->base, 'month' => $month, 'year' => $year, 'msg' => $msg], 
        'layout.php', $model);
    }
    public function redirectToBook()
    {
        if(!session_id()){
            session_start();
        } 
        $model = $this->model('Book');
        $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $this->view('home/book', ['page' => 'Book', 'date' => $date, 'base' => $this->base], 'layout.php', $model);
    }
    public function create()
    {
        if(!session_id()){
            session_start();
        } 
        $date = isset($_GET['date']) ? htmlspecialchars(strip_tags($_GET['date'])) : date('Y-m-d');
        $email = htmlspecialchars(strip_tags($_SESSION['email']));
        $user = htmlspecialchars(strip_tags($_SESSION['user']));
        $description = htmlspecialchars(strip_tags($_REQUEST['description']));
        $timeslot = htmlspecialchars(strip_tags($_REQUEST['timeslotbegin'])).'-'.htmlspecialchars(strip_tags($_REQUEST['timeslotend']));
        //echo $_REQUEST['timeslotbegin'];
        $id = htmlspecialchars(strip_tags($_REQUEST['id']));
        $model = $this->model('Book');
        $idChecked = $model->checkId($id);
        //echo var_dump($_REQUEST);
        //echo $id;
        //$bookings = $model->readOne($email, $date);
        //var_dump($bookings); //var_dump($timeslot);
        if($idChecked === false && $description != '' && $date != ''){
        $model->create($user, $email, $description, $date, $timeslot);
        $msg = "<div class='alert alert-success'>Booking Successful</div>";
        } else {
            $model->update($id, $email, $description, $timeslot);
            $msg = "<div class='alert alert-success'>Updated</div>";
        }
        echo $msg;
        //$this->view('home/book', ['page' => 'Book', 'date' => $date, 'msg' => $msg], 'layout.php', $model);
    }
    public function delete()
    {
        if(!session_id()){
            session_start();
        } 
        $id = htmlspecialchars(strip_tags($_REQUEST['id']));
        $email = htmlspecialchars(strip_tags($_SESSION['email']));
        $model = $this->model('Book');
        $model->delete($id, $email);
        $msg = "<div class='alert alert-danger'>Deleted</div>";
        echo $msg;
    }
    public function readOne()
    {
        if(!session_id()){
            session_start();
        } 
        $detail = htmlspecialchars(strip_tags($_REQUEST['detail']));
        $searchBy = htmlspecialchars(strip_tags($_REQUEST['searchBy']));
        $searchByData = htmlspecialchars(strip_tags($_REQUEST['searchByData']));
        $email = htmlspecialchars(strip_tags($_SESSION['email']));
        $user = htmlspecialchars(strip_tags($_SESSION['user']));
        //echo $user;
        $model = $this->model('Book');
        $descript = $model->readOne($email, $searchBy, $searchByData, $detail);
        echo $descript;
    }
    public function read()
    {
        if(!session_id()){
            session_start();
        }
       
        $searchBy = htmlspecialchars(strip_tags($_REQUEST['searchBy']));
        $searchByData = htmlspecialchars(strip_tags($_REQUEST['searchByData']));
        echo $searchByData;
        $searchMultiple = htmlspecialchars(strip_tags($_REQUEST['searchMultiple']));
        $returnResult = htmlspecialchars(strip_tags($_REQUEST['returnResult']));
        $email = htmlspecialchars(strip_tags($_SESSION['email']));
        //echo "$email, $searchBy, $searchByData, $searchMultiple";
        $model = $this->model('Book');
        $descript[] = $model->read($email, $searchBy, $searchByData, $searchMultiple, 0);
        //var_dump($descript);
    }
    public function authenticate()
    {
        if(!session_id()){
            session_start();
        } 
        $emailu = htmlspecialchars(strip_tags($_REQUEST['email']));
        $password = htmlspecialchars(strip_tags($_REQUEST['password']));
        $model = $this->model('Book');
        $_SESSION['user'] = $user = $model->authenticate($emailu, $password, 'user');
        $_SESSION['email'] = $email = $model->authenticate($emailu, $password, 'email');
        if($email){
            $dateComponents = getdate();
            if(isset($_REQUEST['month']) && isset($_REQUEST['year'])){
                $month = htmlspecialchars(strip_tags($_REQUEST['month']));
                $year = htmlspecialchars(strip_tags($_REQUEST['year']));
            }else{
                $month = $dateComponents['mon'];
                $year = $dateComponents['year'];
            }
            $this->view('home/index', ['page' => 'Home', 'month' => $month, 'year' => $year, 'msg' => $msg, 'user' => $_SESSION['user'], 'base' => $this->base],
                'layout.php', $model);
        } else {
            $msg = "<div class='alert alert-danger'>Account not found</div>";
            $this->index($msg);  
        }
    }
    public function newUser()
    { // create functionality letting only unique emails create accounts
        $user = htmlspecialchars(strip_tags($_REQUEST['user']));
        $emailu = htmlspecialchars(strip_tags($_REQUEST['email']));
        $password = htmlspecialchars(strip_tags($_REQUEST['password']));
        $model = $this->model('Book');
        $email = $model->authenticate($emailu, $password, 'email');
        if($email) { $msg .= "Email already in use<br/>"; }
        if(!preg_match('/^[A-Za-z]+$/', $user)){
            $msg .= 'Please enter a valid name.<br/>';
        }
        if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $emailu)){
            $msg .= "Please enter a valid email address.<br/>";
        } 
        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,50}$/', $password)) {
            $msg .= "Please enter a valid password with at least eight characters including one letter, number, and special character.<br/>";
        }
        if(empty($msg)){ 
        $model->newUser($user, $emailu, $password);
        $msg = "<div class='alert alert-success'>Account Created!</div>";
        $this->view('login/login', ['page' => 'Login', 'msg' => $msg, 'base' => $this->base], 'layout.php', $model);
        } else {
            $this->view('login/register', ['page' => 'Register', 'msg' => "<div class='alert alert-danger'>{$msg}</div>", 'base' => $this->base], 'layout.php', $model);
        }
    }
}
?>