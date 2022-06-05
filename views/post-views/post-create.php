<?php 
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../user-views/login.php");
    exit;
  }
    
  include '../../config/database.php';
  include '../../models/post.php';  
  include('../../includes/header.php');

  $errorMsg = "";

  // Insert Record in post table
  if(isset($_POST['submit'])){
    $db = new Database();
    $post = new Post($db);
    if (!empty($_FILES["image"]["name"])){
       // File upload path
        $targetDirectory = "../../assets/images/uploads/";
        $image = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDirectory . $image;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif');

        if(in_array($fileType, $allowTypes)){
          // Upload file to server
          if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){ 
            $data = array($_SESSION['id'], $_POST['title'], $_POST['body'], $image);
            $post->createPost($data);
            header("location: posts.php");
          }else{
            $errorMsg = '<p style="color:red;">Sorry, there was an error uploading your file.</p>';
          }
        }else{
          $errorMsg = '<p style="color:red;">Sorry, only JPG, JPEG, PNG and GIF files are allowed.</p>';
        }   
    }elseif (empty($_FILES["image"]["name"])){
      $image = "";
      $data = array($_SESSION['id'], $_POST['title'], $_POST['body'], $image);
      $post->createPost($data);
      header("location: posts.php");
    }
  }
?>
<style>
  .contact-wrapper{
    background: lightgrey;
  }
</style>
<!-- Content -->
<div class="col col-lg-12 content">
  <div class="content-wrapper">
    <h1 class="text-center">Add A Post</h1> 
    <div class="col-md-5 mx-auto">
      <div class="card">
        <div class="card-header bg-dark text-white">
          <h4>Insert Data</h4>
        </div>
        <div class="card-body bg-light">
          <p>
            <!-- Display Error message here -->
            <?php if ($errorMsg) { echo $errorMsg; } ?>
          </p>
          <form action="post-create.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="title">Post Title:</label>
              <input type="text" class="form-control" name="title" placeholder="Post Title" required="">
            </div>
            <div class="form-group">
              <label for="body">Post Description</label>
              <input type="text" class="form-control" name="body" placeholder="Post Description" required="">
            </div>
            <div class="form-group">
              <label for="image">Post Image:</label>
              <input type="file" class="form-control" name="image">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" style="float:right;" value="Send Post">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Content -->

<?php include('../../includes/footer.php'); ?>