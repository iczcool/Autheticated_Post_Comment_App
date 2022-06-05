<?php //include "../config/database.php"; ?>
<?php 
	/**
	 * 
	 */
	class User{
		private $id;
		public $fname;
		public $lname;
		public $username;
		public $password;
		public $email;
		public $db;

    public function __construct($db){
      $this->db = $db;
    }

		/* VALIDATION FUNCTIONS */
		// validate username
		public function validateUsername($username){
			// $this->db = new Database();
			// Prepare a select statement
          	$sql = "SELECT id FROM users WHERE username = ?";
          	if($stmt = $this->db->con->prepare($sql)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("s", $this->username);
              
              // Set parameters
              $this->username = $username;
              
              // Attempt to execute the prepared statement
              if($stmt->execute()){
                  // store result
                  $stmt->store_result();
                  
                  if($stmt->num_rows == 1){
                      $username_err = "This username is already taken.";
                  } else{
                      $this->username = $username;
                      return $username;
                  }
              } else{
                  echo "Oops! Something went wrong. Please try again later.";
              }

              // Close statement
              $stmt->close();
              $this->db->con->close();
          }          
		}

		//CRUD user
		public function createUser($data){
			// $this->db = new Database();
			// Prepare an insert statement
          	$sql = "INSERT INTO users (first_name, last_name, username, password, email) VALUES (?, ?, ?, ?, ?)";
          	if($stmt = $this->db->con->prepare($sql)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("sssss", $this->fname, $this->lname, $this->username, $this->password, $this->email);
              
              // Set parameters
              $this->fname = $data[0];
              $this->lname = $data[1];
              $this->username = $data[2];
              $this->password = password_hash($data[3], PASSWORD_DEFAULT); // Creates a password hash
              $this->email = $data[4];
              
              // Attempt to execute the prepared statement
              if($stmt->execute()){
                  // Redirect to login page
                  header("location: login_test.php");
              } else{
                  echo "Oops! Something went wrong. Please try again later.";
              }

              // Close statement
              $stmt->close();
              $this->db->con->close();
          }
		}

    public function showOneUser($id){
      $query = "SELECT first_name,last_name FROM users WHERE id = '$id'";
      $result = $this->db->con->query($query);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
          $name = $row['first_name']. ' ' .$row['last_name'];
          return $name;
        
      }else{
          echo "Record not found";
      }
      $this->db->con->close();
    }
	}
?>