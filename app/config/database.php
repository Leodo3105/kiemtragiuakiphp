<?php

class Database
{
    private static $instance = null;
    private $connection;

    // Thông tin kết nối database
    private $host = "localhost";
    private $username = "root";  
    private $password = "";      
    private $database = "test1"; 
    private $charset = "utf8";

    private function __construct()
    {
        try {
            $this->connection = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->database
            );
            
            if ($this->connection->connect_error) {
                throw new Exception("Kết nối CSDL thất bại: " . $this->connection->connect_error);
            }
            
            $this->connection->set_charset($this->charset);
            
        } catch (Exception $e) {
            die("Lỗi kết nối database: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}