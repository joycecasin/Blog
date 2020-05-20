<?php



class User
{
    /* Variabelen */
    public $id;
    public $username;
    public $paswoord;
    public $voornaam;
    public $familienaam;
    public $email;

    /* User tonen als object */
    public static function instantie($result){
        $the_object = new self();
       foreach ($result as $the_attribute => $value){
           if($the_object->has_the_attribute($the_attribute)){
            $the_object->$the_attribute = $value;
           }
       }
        return $the_object;
    }

    public function has_the_attribute($the_attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }

    /* Vereenvoudigen van functie find all users + user by id */
    public static function find_this_query($sql){
        global $database;
        $result = $database->query($sql);
        $the_object_array = array();
        while($row = mysqli_fetch_array($result)){
            $the_object_array[] = self::instantie($row);
        }
        return $the_object_array;
    }
    /* Tonen van alle users */ 
    public static function find_all_users(){
        return self::find_this_query("SELECT * FROM user");
    }

    /* Tonen van user per id */
    public static function find_user_by_id($user_id){
        $result = self::find_this_query("SELECT * FROM user WHERE id=$user_id");
        /* if(!empty($result)){
            return array_shift($result);
        }else{
            return false;
        }*/
        /*Korte versie van de if functie hierboven */
        return !empty($result) ? array_shift($result) : false;
        
    }
    /* Controleren of username aanwezig is in database  */
    public static function verify_user($user, $pas){
        global $database;
        $username = $database->escape_string($user);
        $paswoord = $database->escape_string($pas);

        $sql = "SELECT * FROM user WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND paswoord = '{$paswoord}' ";
        $sql .= "LIMIT 1";

        $the_result_array = self::find_this_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }

    /* Create functie */
    public function create(){
        global $database;

        $ins = "INSERT INTO user(username, paswoord, voornaam, familienaam, email)";
        $ins .= "VALUES ('";
        $ins .= $database->escape_string($this->username) . "', '";
        $ins .= $database->escape_string($this->paswoord) . "', '";
        $ins .= $database->escape_string($this->voornaam) . "', '";
        $ins .= $database->escape_string($this->familienaam) . "', '";
        $ins .= $database->escape_string($this->email) . "')";

        if ($database->query($ins)){
            $this->id = $database->the_insert_id();
            return true;
        }else{
            return false;
        }
        $database->query($ins);
    }

    /* Update functie, wijzigen van user in database */
    public function update(){
        global $database;

        $upd = "UPDATE user SET ";
        $upd .= "username= '" . $database->escape_string($this->username) . "', ";
        $upd .= "paswoord= '" . $database->escape_string($this->paswoord) . "', ";
        $upd .= "voornaam= '" . $database->escape_string($this->voornaam) . "', ";
        $upd .= "familienaam= '" . $database->escape_string($this->familienaam) . "', ";
        $upd .= "email= '" . $database->escape_string($this->email) . "' ";
        $upd .= "WHERE id = " . $database->escape_string($this->id);

        $database->query($upd);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    /* Delete functie schrijven om een user te verwijderen */
    public function delete(){
        global $database;

        $del = "DELETE FROM user ";
        $del .= "WHERE id= " . $database->escape_string($this->id);
        $del .= " LIMIT 1";

        $database->query($del);
        return (mysqli_affected_rows($database->connection) ==1) ? true : false;

    }
}

?>