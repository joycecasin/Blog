
<?php


class Session
{
    // sessies van users automatisch te laten starten
    private $signed_in = false;
    public $user_id;
    public $count;

    function __construct()
    {
        session_start();
        // Pagina views
        $this->visitor_count();
        // kijken of we ingelogd zijn, dit automatisch starten
        $this->check_the_login();
        $this->check_message();
    }
    // Aantal sessies tellen
    public function visitor_count(){
        if (isset($_SESSION['count'])){
            return $this->count = $_SESSION['count']++;
        }else{
            return $_SESSION['count'] = 1;
        }
    }
    //Login methode, kijken of de user ingelogd is, enkel true of false teruggeven
    public function is_signed_in(){
        return $this->signed_in;
    }
    // Wanneer er een user is, dan gaan we die session toekennen en die object variabele toekennen
    public function login($user){
        if ($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }
    // Logout methode
    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    // Kijken of die username aanwezig is en indien deze aanwezig is wordt deze in user_id geplaatst en signed_in op true geplaatst.
    private function check_the_login(){
        if (isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        }else{
            // Geen user_id aanwezig in de Session.
            unset($this->user_id);
            $this->signed_in = false;
        }
    }

    //
    public function message($msg=""){
        if(!empty($msg)){
            $_SESSION['message']=$msg;
        } else{
            return $this->message;
        }
    }
    // Bekijkt of er reeds een vorig bericht als sessie in het geheugen is geladen. Indien geval, gaan we die leeg maken
    private function check_message(){
        if (isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else{
            $this->message = "";
        }
    }

}
$session = new Session();
?>