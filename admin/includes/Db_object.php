<?php


class Db_object
{
    /* Tonen van alle users */
    public static function find_all(){
        return static::find_this_query("SELECT * FROM " . static::$db_table);
    }

    /* Tonen van user per id */
    public static function find_by_id($id){
        $result = static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE id=$id LIMIT 1");
        /* if(!empty($result)){
            return array_shift($result);
        }else{
            return false;
        }*/
        /*Korte versie van de if functie hierboven */
        return !empty($result) ? array_shift($result) : false;

    }

    /* Vereenvoudigen van functie find all users + user by id */
    public static function find_this_query($sql){
        global $database;
        $result = $database->query($sql);
        $the_object_array = array();
        while($row = mysqli_fetch_array($result)){
            $the_object_array[] = static::instantie($row);
        }
        return $the_object_array;
    }

    /* User tonen als object */
    public static function instantie($result){
        $calling_class = get_called_class(); // late static binding
        $the_object = new $calling_class;
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

    /* Kijken of er een user is, indien 1 aanwezig gaan we die wijzigen anders gaan we die toevoegen */
    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }

    /* Create functie */
    public function create(){
        global $database;
        $properties = $this->clean_properties();

        $ins = "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) .")";
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
        $properties = $this->clean_properties();
        $properties_assoc = array();

        foreach ($properties as $key => $value){
            $properties_assoc[] = "{$key}='{$value}'";
        }

        $upd = "UPDATE " . static::$db_table . " SET ";
        $upd .= implode(",", $properties_assoc);
        $upd .= "WHERE id = " . $database->escape_string($this->id);

        /*$upd .= "username= '" . $database->escape_string($this->username) . "', ";
        $upd .= "paswoord= '" . $database->escape_string($this->paswoord) . "', ";
        $upd .= "voornaam= '" . $database->escape_string($this->voornaam) . "', ";
        $upd .= "familienaam= '" . $database->escape_string($this->familienaam) . "', ";
        $upd .= "email= '" . $database->escape_string($this->email) . "' ";
        $upd .= "WHERE id = " . $database->escape_string($this->id);*/

        $database->query($upd);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    /* Delete functie schrijven om een user te verwijderen */
    public function delete(){
        global $database;

        $del = "DELETE FROM " . static::$db_table;
        $del .= "WHERE id= " . $database->escape_string($this->id);
        $del .= " LIMIT 1";

        $database->query($del);
        return (mysqli_affected_rows($database->connection) ==1) ? true : false;
    }

    /* Functie die alle properties van de class zal inlezen */
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

    protected  function  clean_properties(){
        global $database;
        $clean_properties = array();
        foreach ($this->properties() as $key => $value){
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }


}