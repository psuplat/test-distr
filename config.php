<?php
class Database{
    private $host = "localhost";
    private $db_name = "helloprint";
    private $username = "root";
    private $password = "Pa55w0rd";
    
    protected $connection;
  
    public function __construct()
    {
        if (!isset($this->connection)) {
            
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            if (!$this->connection) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
        
        return $this->connection;
    }
}
?>