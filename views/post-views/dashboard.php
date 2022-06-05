<?php 
  session_start();
  
  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../user-views/login.php");
    exit;
  }
  
  include('../../includes/header.php');
?>
    <style>
    .dashboard-wrapper{
      background: yellow;
      max-width: 600px;
      height: 300px;
      margin: 200px auto;
    }
    .dashboard-wrapper li{
      list-style: none;
      display: inline-block;
      border: 1px solid lightgrey;
    }
    .dashboard-wrapper li a{
      text-decoration: none;
      padding: 20px 100px;
    }
  </style>
    <!-- Content -->
    <div class="col col-lg-12 content">
      <div class="dashboard-wrapper">
        <h1>Dashboard</h1>
        <ul>
          <li><a href="posts.php">Posts</a></li>
          <li><a href="../comment-views/comments.php">Comments</a></li>
        </ul>    
      </div>
    </div>
    <!-- End Content -->
    
    <?php include('../../includes/footer.php'); ?>