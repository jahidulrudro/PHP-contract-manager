<?php

class Admin extends DB_object
{
    protected static $db_table = "tbl_admin";
    protected static $db_table_field = array('name', 'admin_id', 'email', 'password', 'status');

    public $id;
    public $name;
    public $admin_id;
    public $email;
    public $password;
    public $status;

    /*login function start*/
    public static function verify_admin($username, $password)
    {
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE email = '{$username}' OR admin_id = '{$username}' AND status = 1";
        $result = $database->query($sql);
        //print_r($result);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
                    $the_result_array = self::find_by_query($sql);
                    //print_r($the_result_array);
                    return !empty($the_result_array) ? array_shift($the_result_array) : false;
                }
            }
        } else {
            return false;
        }
    }
    /*login function finish*/
}