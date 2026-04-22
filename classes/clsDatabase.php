<?php

class clsDatabase
{
    private $host = "localhost";
    private $user = "userHodoor";
    private $password = "passHodoor";
    private $dbname = "Hodoor";
    private $conn = null;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
    }

    public function connect()
    {
        return $this->conn;
    }

}