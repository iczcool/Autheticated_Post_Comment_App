<?php
  // Include config file
  include "../config/database.php";
  include "../models/user.php";
   
  // Define variables and initialize with empty values
  $fname_err = $lname_err = $username_err = $password_err = $confirm_password_err = "";
   
  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // validation function
    function validateInput($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

      //validate first name
      if (empty($_POST["fname"])) {
        $fname_err = "Please enter your first name!";
      }else{
        $fname = validateInput($_POST["fname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
          $fname_err = "Only letters spaces allowed!";
        }
      }

      //validate last name
      if (empty($_POST["lname"])) {
        $lname_err = "Please enter your last name!";
      }else{
        $lname = validateInput($_POST["lname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
          $lname_err = "Only letters spaces allowed!";
        }
      }

      //validate email
      if (empty($_POST["email"])) {
        $email_err = "Please enter your email!";
      }else{
        $email = validateInput($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $email_err = "Invalid email format";
        }
      }

      // Validate username
      if(empty(trim($_POST["username"]))){
          $username_err = "Please enter a username.";
      } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
          $username_err = "Username can only contain letters, numbers, and underscores.";
      } else{
          $db = new Database();
          $user = new User($db);
          $username = $user->validateUsername($_POST['username']);
      }
      
      // Validate password
      if(empty(trim($_POST["password"]))){
          $password_err = "Please enter a password.";     
      } elseif(strlen(trim($_POST["password"])) < 6){
          $password_err = "Password must have atleast 6 characters.";
      } else{
          $password = trim($_POST["password"]);
      }
      
      // Validate confirm password
      if(empty(trim($_POST["confirm_password"]))){
          $confirm_password_err = "Please confirm password.";     
      } else{
          $confirm_password = trim($_POST["confirm_password"]);
          if(empty($password_err) && ($password != $confirm_password)){
              $confirm_password_err = "Password did not match.";
          }
      }
      
      // Check input errors before inserting in database
      if(empty($fname_err) && empty($lname_err) && empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
          $data = array($fname, $lname, $username, $password, $email);
          $db = new Database();
          $user = new User($db);
          $user->createUser($data);
      }
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
        <h1 class="page-title">Live Comment System: Sign Up</h1>
      </div>
      <!-- end page-header --> 

      <div class="col-md-12" style="width:40%; margin:0 auto;">
        <p>Please fill this form to create an account.</p>
        <form action="" method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control" value="">
                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lname" class="form-control" value="">
                <span class="invalid-feedback"><?php echo $lname_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login_test.php">Login here</a></p>
        </form>
      </div>




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