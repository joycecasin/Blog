<?php

// Dit is onze parent class, Alle gemeenschappelijke methodes in een basis class steken
class Db_object
{
    // Alle users weergeven
    public static function find_all(){
        return static::find_this_query("SELECT * FROM " . static::$db_table);
    }

    // User weergeven per ID
    public static function find_by_id($id){
        $result = static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE id=$id LIMIT 1");
        /*  if (!empty($result)){
              return array_shift($result);
          }else{
              return false;
          }*/
        //Korte if functie van hierboven
        return !empty($result) ? array_shift($result) : false;
    }

    // Static maken van de code. Door global en result bovenaan te gebruiken (werden anders meerdere keren vermeld in de verschillende functies)
    public static function find_this_query($sql){
        global $database;
        $result = $database->query($sql);
        $the_object_array = array();
        while ($row = mysqli_fetch_array($result)){
            $the_object_array[] = static::instantie($row);
        }
        return $the_object_array;
    }

    // vereenvoudigen van code om alles van de users in een variabel te plaatsen. Een Object maken.
    public static function instantie($result){
        //Late static binding
        $calling_class = get_called_class();
        $the_object = new $calling_class();
        foreach ($result as $the_attribute => $value){
            if ($the_object->has_the_attribute($the_attribute)){
                $the_object->$the_attribute = $value;
            }
        }
        return $the_object;
    }

    private function has_the_attribute($the_attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute,$object_properties);
    }

    // kijkt of er een user is. Wanneer deze user er is dan gaan we deze wijzigen, zoniet dan gaan we de user aanmaken.
    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }

    // Insert INTO query opmaken om data toe te voegen in onze database
    public function create()
    {
        global $database;
        $properties = $this->clean_properties();
        /*// array_keys($properties) is hetzelfde als username, password,...
        $sql = "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) . ")";
        $sql .= " VALUES ('";
        $sql .= $database->escape_string($this->username) . "', '";
        $sql .= $database->escape_string($this->password) . "', '";
        $sql .= $database->escape_string($this->first_name) . "', '";
        $sql .= $database->escape_string($this->last_name) . "', '";
        $sql .= $database->escape_string($this->user_image) . "')";*/
        $sql = "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) . ")
        VALUES ('" . implode("','", array_values($properties)) . "');
        ";

        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }

        $database->query($sql);
    }

    // Update query om data te wijzigen in onze database
    public function update(){
        global $database;
        // Alle properties van de class in een associatieve array plaatsen. Deze wordt gevuld met het veld en de value zoals sql verwacht.
        $properties = $this->clean_properties();
        $properties_assoc = array();

        foreach ($properties as $key => $value){
            $properties_assoc[] = "{$key}='{$value}'";
        }

        $upd = "UPDATE " . static::$db_table . " SET ";
        $upd .= implode(",", $properties_assoc);
        $upd .= " WHERE id = " . $database->escape_string($this->id);

        /*$sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= "username= '" . $database->escape_string($this->username) . "', ";
        $sql .= "password= '" . $database->escape_string($this->password) . "', ";
        $sql .= "first_name= '" . $database->escape_string($this->first_name) . "', ";
        $sql .= "last_name= '" . $database->escape_string($this->last_name) . "' ";
        $sql .= "WHERE id= " . $database->escape_string($this->id);*/

        $database->query($upd);
        return (mysqli_affected_rows($database->connection) == 1)? true : false;
    }

    //Data uit onze database verwijderen
    public function delete(){
        global $database;
        $sql = "DELETE FROM " . static::$db_table . " ";
        $sql .= " WHERE id= " . $database->escape_string($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);
        return(mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    //Functie die alle properties van de class zal inlezen
    protected function properties(){
        //return get_object_vars($this);
        $properties = array();
        foreach (static::$db_table_fields as $db_field){
            if (property_exists($this, $db_field)){
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    // de value gaan we opschonen met de escape_string en steken we in de array $clean_properties
    protected function clean_properties(){
        global $database;
        $clean_properties = array();
        foreach ($this->properties() as $key => $value){
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }

    //Locatie properties om een afbeelding in te laden
    // Nodig om een foto even op te slaan in een temporary pad
    public $errors = array();
    public $upload_error_array = array(
        UPLOAD_ERR_OK =>"There is no error",
        UPLOAD_ERR_INI_SIZE =>"The upload file exceed the upload max_filesize from php.ini",
        UPLOAD_ERR_FORM_SIZE =>"The upload file exceed MAX_FILE_SIZE in php.ini for html form",
        UPLOAD_ERR_NO_FILE => "No file uploaded",
        UPLOAD_ERR_PARTIAL => "The file was partially uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write to disk",
        UPLOAD_ERR_EXTENSION => "A php extension stopped your upload"
    );

    // aantal records telt in onze database
    public static function count_all(){
        global $database;
        $count = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($count);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);
    }
}