<?php 
  // Initialize the session
  session_start();

  // Check if the user is already logged in, if yes then redirect him to welcome page
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      header("location: location: ../post-views/index.php");
      exit;
  }

  // Include config file
  require_once "../../config/database.php";
  $db = new Database();
   
  // Define variables and initialize with empty values
  $username = $password = $email = $first_name = $last_name = "";
  $username_err = $password_err = $email_err = $login_err = $other_err = "";

  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){
   
      // Check if username is empty
      if(empty(trim($_POST["username"]))){
          $username_err = "Please enter username.";
      } else{
          $username = trim($_POST["username"]);
      }
      
      // Check if password is empty
      if(empty(trim($_POST["password"]))){
          $password_err = "Please enter your password.";
      } else{
          $password = trim($_POST["password"]);
      }
      
      // Validate credentials
      if(empty($username_err) && empty($password_err)){
          // Prepare a select statement
          $sql = "SELECT id, username, password, first_name, last_name FROM users WHERE username = ?";
          
          if($stmt = $db->con->prepare($sql)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("s", $param_username);
              
              // Set parameters
              $param_username = $username;
              
              // Attempt to execute the prepared statement
              if($stmt->execute()){
                  // Store result
                  $stmt->store_result();
                  
                  // Check if username exists, if yes then verify password
                  if($stmt->num_rows == 1){                    
                      // Bind result variables
                      $stmt->bind_result($id, $username, $hashed_password, $first_name, $last_name);
                      if($stmt->fetch()){
                          if(password_verify($password, $hashed_password)){
                              // Password is correct, so start a new session
                              session_start();
                              
                              // Store data in session variables
                              $_SESSION["loggedin"] = true;
                              $_SESSION["id"] = $id;
                              $_SESSION["username"] = $username;
                              $_SESSION['first_name'] = $first_name;
                              $_SESSION['last_name'] = $last_name;                            
                              
                              // Redirect user to welcome page
                              header("location: /Codebase/Portfolio/PostComment_development/views/post-views/index.php");
                          } else{
                              // Password is not valid, display a generic error message
                              $login_err = "Invalid username or password.";
                          }
                      }
                  } else{
                      // Username doesn't exist, display a generic error message
                      $login_err = "Invalid username or password.";
                  }
              } else{
                  $other_err = "Oops! Something went wrong. Please try again later.";
              }

              // Close statement
              $stmt->close();
          }
      }
      
      // Close connection
      $db->con->close();
  }

?>

<?php include('../../includes/header.php'); ?>
    <style>
      .navigation{
        display: none;
      }
    </style>
    <!-- Content -->
    <div class="col col-lg-12 content">
      <!-- begin form  -->
      <div class="col-md-12" style="width: 40%; margin: 0 auto;">
        <p>Please fill in your credentials to login.</p>
        <?php 
          if ($login_err) {
            echo '<p style="color:red;">'.$login_err.'</p>';
          }
          elseif ($other_err) {
            echo '<p style="color:red;">'.$other_err.'</p>';
          }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <p style="color:red"><?php echo $username_err;?></p>
                <label><i class="fas fa-user"></i> Username</label>               
                <input type="text" name="username" class="form-control" value="">
            </div>    
            <div class="form-group">
                <p style="color:red"><?php echo $password_err; ?></p>
                <label><i class="fas fa-lock"></i> Password</label>               
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-secondary" value="Login">
            </div>
            <p>Don't have an account? <a href="register_test.php">Sign up to join</a></p>
        </form>
      </div>
      <!-- end form -->
    </div>
    <!-- End Content -->
    
    <?php include('../../includes/footer.php'); ?>