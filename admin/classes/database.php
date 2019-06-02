<?php

require_once("config.php");

class Database
{

    public $connection;

    function __construct()
    {
        $this->open_db_connection();
    }

    public function open_db_connection()
    {
        try {
            $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (mysqli_connect_errno()) {
                die("Database connection failed badly " . mysqli_error());
            }
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public function query($sql)
    {
        try {
            $result = mysqli_query($this->connection, $sql);
            return $result;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    private function confirm_query($result)
    {
        try {
            if (!$result) {
                die("Query Failed");
            }
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    public function escape_string($string)
    {
        try {
            $escaped_string = mysqli_real_escape_string($this->connection, $string);
            return $escaped_string;
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }

    //return last inserted id
    public function the_insert_id()
    {
        try {
            return mysqli_insert_id($this->connection);
        } catch (Exception $exception) {
            echo "Error " . $exception->getMessage();
        }
    }
}

$database = new Database();

?>