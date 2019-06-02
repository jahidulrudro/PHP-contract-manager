<?php
class Contract extends DB_object
{
    protected static $db_table = "tbl_contract";
    protected static $db_table_field = array('name', 'email', 'body', 'type','signature');

    public $id;
    public $name;
    public $email;
    public $body;
    public $type;
    public $signature;
}