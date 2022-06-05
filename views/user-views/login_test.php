<?php 
  // Initialize the session
  session_start();

  // Check if the user is already logged in, if yes then redirect him to welcome page
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      header("location: location: ../post_views/index.php");
      exit;
  }

  // Include config file
  require_once "../config/database.php";
  $db = new Database();
   
  // Define variables and initialize with empty values
  $username = $password = $email = "";
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
          $sql = "SELECT id, username, password FROM users WHERE username = ?";
          
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
                      $stmt->bind_result($id, $username, $hashed_password);
                      if($stmt->fetch()){
                          if(password_verify($password, $hashed_password)){
                              // Password is correct, so start a new session
                              session_start();
                              
                              // Store data in session variables
                              $_SESSION["loggedin"] = true;
                              $_SESSION["id"] = $id;
                              $_SESSION["username"] = $username;                            
                              
                              // Redirect user to welcome page
                              header("location: ../post_views/index.php");
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



<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .page-title{
      padding: 0 0 40px 0;
    }
    .container{
      position: relative;
      background: ;
      min-height: 90vh;
      border: 1px solid lightgrey;
      margin: 20px auto;
      /*padding: 64px;*/
      border-radius: 10px;

      /*border: 1px solid;*/
      /*padding: 10px;*/
      box-shadow: 2px 2px 10px 2px #888888;
    }
    .avatar{
      background: red;
      width: 30%;
      height: 60px;
    }
    .comment-object-wrapper{
      border: 1px solid lightgrey;
      margin: 40px 0;
      padding: 10px;
    }
    .comment-object{
      border: 0px solid lightgrey;
      margin: 0;
      padding: 0;
    }

    .footer{
      position: absolute;
      bottom: 0;
      color: ;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row" style="margin: 32px;">

      <!-- begin page-header -->
      <div class="col-md-12 text-center">
        <h1 class="page-title">Live Comment System: Login</h1>
      </div>
      <!-- end page-header -->

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

    <!-- begin footer -->
    <div class="row">
      <div class="footer">
        <footer class="">
          <p class="text-center">&copy; 2022 Talk Your Own <small>by<i> <a href="#0">iczcool</a></i></small></p>
        </footer>
      </div>
    </div>
    <!-- end footer -->


  </div>
</tbody>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>