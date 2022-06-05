<?php 
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../user-views/login.php");
    exit;
  }
  
  include('../../config/database.php'); 
  include('../../models/comment.php'); 
  include('../../includes/header.php');

  $db = new Database();
  $comment = new Comment($db);
?>
<style>
  .contact-wrapper{
    background: lightgrey;
  }
  .card{
    width: 60%;
    margin: 0 auto;
  }
  .card h5{ color: red; }
  form .btn{
    width: 80px;
  }
</style>
<!-- Content -->
<div class="col col-lg-12 content">
  <div class="content-wrapper">
    <h1 class="text-center">Delete Comment</h1>    
    
    <div class="card">
      <div class="card-body">
        <?php 
          echo '<h5 class="card-title">Deleting comment with id '.$_GET['deleteId'].'!</h5>';
          $db = new Database();
          $comment = new Comment($db);
          if (isset($_POST['submit']) && !empty($_POST['deleteId'])) {
            $comment->deleteComment($_POST['deleteId']);
            header("location: comments.php");
          }
        ?>
        <p class="card-text"><em>Are you sure you want to delete this comment?</em></p>
        <form action="delete.php" method="POST">
          <input type="hidden" value="<?php echo $_GET['deleteId']; ?>" name="deleteId">

          <!-- submit buttons -->
          <input class="btn btn-danger" type="submit" value="Ok" name="submit">
          <a href="comments.php" class="btn btn-primary">Cancel</a>
        </form> 

        <!-- <a href="delete.php?response=ok" class="card-link">Ok</a> -->
        <!-- <a href="comments.php" class="card-link">Cancel</a> -->


      </div>
    </div>

  </div>
</div>
<!-- End Content -->

<?php include('../../includes/footer.php'); ?>