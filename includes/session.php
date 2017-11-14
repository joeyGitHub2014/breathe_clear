<?php
// A class to help work with Sessions 
// In our case, primarily to manage logging users in and out.
// Keep in mind when working with sessions that it is generally 
// inadvisable to store DB - related objects in sessions 

 class Session{
    private $logged_in = false;
    public $user_id;
    public $message;
    function __construct(){
        // Initialize session, create/recreate new cookie
        session_start();
        session_regenerate_id(true);
       // $this->check_message();
        if (!$this->check_login()){
          //redirectTo("login.php");
        }
    }
    public function is_logged_in(){
      return $this->logged_in;
    }
    public function login($user){
        // database should find user based on username/password
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id0;
            $this->logged_in = true;
        }
    }
    public function logout(){
        unset($_SESSION['user_id'] );
        unset($this->user_id );
        $this->logged_in = false;
     }
     public function message($msg=""){
        if (!empty($msg)){ 
            // make sure you understand $this->message=$msg wouldn't work
            // set message
            $_SESSION['message'] = $msg;
        }else{
            //get message
            return $this->message;
        }
        
     }
    private function check_login(){
        if (isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        }else{
            unset($this->user_id );
            $this->logged_in = false;

        }
        return ($this->logged_in);
    }
    private function check_message(){
        if (isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
            unset($_SESSION['message'] );
        }else{
            $this->message = "";
        }
    }
    
 }
 $session = new Session();
 $message = $session->message();
?>