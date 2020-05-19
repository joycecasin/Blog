<?php

class Session
{
    /* Automatisch starten van sessie */
    private $signed_in = false;
    public $user_id;

    function __construct()
    {
        session_start();
        $this->check_the_login();
    }

     /* Login methode */ 
    public function is_signed_in(){
        return $this->signed_in;
    }

    public function login($user){
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }

    /* Logout methode */ 
    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    /* Kijken of het userid wel degelijk word geset door de sessie*/
    private function check_the_login(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        }else{
            unset($this->user_id);
            $this->signed_in = false;
        }
    }

   

}

$session = new Session();

?>
