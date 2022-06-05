<?php 
	class Database{
		
		private $servername = "localhost";
        private $username = "root";
        private $password = "password_here";
        private $database = "database_name";
        public  $con;

        // Database Connection 
        public function __construct(){
            $this->con = new mysqli($this->servername, $this->username,$this->password,$this->database);
            if(mysqli_connect_error()) {
            	trigger_error("Failed to connect to MySQL: " . mysqli_connect_error());
            }else{
            	return $this->con;
            }
        }
	}
?>
