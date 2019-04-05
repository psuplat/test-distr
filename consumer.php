<?php
include_once 'config.php';
 
class Consumer extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    

    public function authenticate($u, $p) 
    { 
        $response = array();
        $query = "SELECT * FROM users WHERE username = '$u' AND password = '$p' AND status = 1";
        
        $result = $this->connection->query($query);

        if ($result == false) {
            $response['result'] = false;
        } else {
            $response['result'] = true;
            $response['rows'] = $result->num_rows;
        }
        $test = json_encode($response);
        
        return $response;
    }
    
    public function recovery($u) 
    { 
        $response = array();
        $query = "SELECT email, password FROM users WHERE username = '$u' AND status = 1";
        
        $result = $this->connection->query($query);

        if ($result == false) {
            $response['result'] = false;
        } else {
            $response['result'] = true;
            $response['rows'] = $result->num_rows;
            $query_data = $result->fetch_assoc();
            $response['email'] = $query_data['email'];
            $response['password'] = $query_data['password'];
        }
        $test = json_encode($response);
        
        return $response;
    }
 
}
?>