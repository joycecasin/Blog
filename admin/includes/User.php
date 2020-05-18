<?php


class User extends Db_object
{
    // Om over meerdere classe te kunnen gebruiken
    protected static $db_table = "user";
    // Alle variabelen declareren in een aparte variabele
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name','user_image');
    // Aanmaken van variabelen, om dit te wijzigen van Array naar Object.
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    //Propertie aanmaken voor nieuwe tabel in database
    public $user_image;
    // Directory klaar zetten waar de foto wordt upgeload
    public $upload_directory = 'img'. DS .'users';
    // Wanneer er geen foto geupload wordt van de user gaan we een placeholder tonen
    public $image_placeholder = 'http://place-hold.it/400x400&text=image';
    public $tmp_path;

    // Gaat specifiek over een user
    public static function verify_user($user, $pass){
        global $database;
        $username = $database->escape_string($user);
        $password = $database->escape_string($pass);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $the_result_array = self::find_this_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false ;
    }

    // Functie voor foto users toe te voegen
    public function image_path_and_placeholder(){
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
    }

    // Methode die de error zal opvangen
    public function set_file($file){
        $date = date('Y-m-d-H-i-s');
        if (empty($file) || !$file || !is_array($file)){
            $this->errors[] = "No file uploaded";
            return false;
        }elseif ($file['error'] != 0){
            $this->errors[]= $this->upload_error_array[$file['error']];
            return false;
        }  else{
            $this->user_image = $date . basename($file['name']);
            $this->tmp_path = $file['tmp_name'];

        }
    }

  // Save methode om de foto's op te laden naar de database
   public function save_user_and_image(){
        $target_path = SITE_ROOT . DS . "admin" . DS . $this->upload_directory . DS . $this->user_image;
       if($this->id){
           move_uploaded_file($this->tmp_path, $target_path);
           $this->update();
           unset($this->tmp_path);
           return true;
       }else {
           if (!empty($this->errors)) {
               return false;
           }
           if (empty($this->user_image) || empty($this->tmp_path)) {
               $this->errors[] = "File not available";
               return false;
           }
           if (file_exists($target_path)) {
               $this->errors[] = "File {$this->user_image} exists";
               return false;
           }
           if (move_uploaded_file($this->tmp_path, $target_path)) {
               if ($this->create()) {
                   unset($this->tmp_path);
                   return true;
               }
           } else {
               $this->errors[] = "This folder has no write rights";
               return false;
           }
       }
    }




}