<?php  
class dbConnect {  
	
    public function __construct() {  
        //include 'config.php';  
		//include('config.php');
		//include "core.php";
		$DB_HOST = 'localhost';
		$DB_USER = 'root';
		$DB_PASSWORD = '';
		$DB_DATABSE = 'jubayer_new';
       
		$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABSE);			
          
        if ($conn->connect_error) {
		
			die("Error connecting database: " . $this->conn->connect_error);
		}
		return $conn;  
    }  
	public function getConn(){
		return $this->conn;
	}
    function close($conn){
		$conn->close();
	}
}  
?>