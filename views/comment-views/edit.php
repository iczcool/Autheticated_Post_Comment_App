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
    <h1 class="text-center">Update Comment</h1>

    <div class="card">
      <div class="card-body">
        <!-- Begin Form -->
        <div class="form-area">
          <p class="card-text"><em><b>Are you sure you want to delete this comment?</b></em></p>
          <form action="index.php" method="POST">
            <div class="mb-3">
              <input type="hidden" name="id" value="<?php echo isset($_GET['currentId']) ? $_GET['currentId'] : $currentPost['id']; ?>">
              <label class="form-label">Your comment:</label>
              <textarea class="form-control" name="body"></textarea>
            </div>
            <div class="button">
              <button type="submit" name="submit" class="btn btn-primary">Post Comment</button>
            </div>
          </form>
        </div>
        <!-- End Form -->  
      </div>
    </div>

  </div>
</div>
<!-- End Content -->

<?php include('../../includes/footer.php'); ?>