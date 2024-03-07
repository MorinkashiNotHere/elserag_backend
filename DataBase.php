<?php

class DataBase {

    private static $db;
    private $connection;

    public function __construct()
    {
        require_once './config.php';
        $this->connection = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public static function getConnection(){

        if(self::$db == null){
            self::$db = new DataBase();
        }

        return self::$db->connection;

    }


}