<?php



class User extends Db_object
{
    /* Variabelen */
    protected static $db_table = "user";
    protected static $db_table_fields = array('username', 'paswoord', 'voornaam', 'familienaam', 'email');
    public $id;
    public $username;
    public $paswoord;
    public $voornaam;
    public $familienaam;
    public $email;

    /* Controleren of username aanwezig is in database  */
    public static function verify_user($user, $pas){
        global $database;
        $username = $database->escape_string($user);
        $paswoord = $database->escape_string($pas);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND paswoord = '{$paswoord}' ";
        $sql .= "LIMIT 1";

        $the_result_array = self::find_this_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }
}

?>