<?php 
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../user-views/login.php");
    exit;
  }
  
  include('../../config/database.php'); 
  include('../../models/post.php'); 
  include('../../includes/header.php');

  $db = new Database();
  $post = new Post($db);
?>
<style>
  .contact-wrapper{
    background: lightgrey;
  }
</style>
<!-- Content -->
<div class="col col-lg-12 content">
  <div class="content-wrapper">
    <h1 class="text-center">Dashboard</h1>
    <!-- <a href="template.php?id=123&fruit=Orange" style="margin-top:400px;">Send variables via URL!</a> -->
    
    <?php
      $posts = $post->showAllPosts();
      foreach($posts as $post){
        $link = '<a href="template.php?id='.$post['id'].'">'.$post["title"].'  '.$post["id"].'</a>';
        echo $link;
        echo '<br>';
      }

      echo '<br><br><br><br>';
      echo 'Current id is: ' . $_GET['id'];
    ?>
  </div>
</div>
<!-- End Content -->

<?php include('../../includes/footer.php'); ?>