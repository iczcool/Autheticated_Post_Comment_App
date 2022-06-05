<?php 
	session_start();
	
	include '../../config/database.php';
  include '../../models/comment.php';

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../user-views/login.php");
    exit;
  }else{

	  $db = new Database();
		$comment = new Comment($db);
		$pageTitle = "List Of Comments";
  }
?>

<?php include('../../includes/header.php'); ?>
<!-- Content -->
<div class="col col-lg-12 content">
  <div class="dashboard-wrapper">
    <h1 class="text-center"><?php echo $pageTitle; ?></h1>
    

    
	  <h2>View Records
	    <!-- <a href="comment-create.php" style="float:right;"><button class="btn btn-success"><i class="fas fa-plus"></i></button></a> -->
	  </h2>
	  <table class="table table-hover">
	    <thead>
	      <tr>
	        <th>Id</th>
	        <th>Post_Id</th>
	        <th>User_Id</th>
	        <th>Name</th>
	        <th>Body</th>
	        <th>Date</th>
	      </tr>
	    </thead>
	    <tbody>
        <?php 
          $comments = $comment->showAllComments(); 
          foreach ($comments as $comment) {
          	echo '<tr>
					          <td> '.$comment['id'].'</td>
					          <td> '.$comment['post_id'].'</td>
					          <td> '.$comment['user_id'].'</td>
					          <td> '.$comment['name'].'</td>					          
					          <td> '.$comment['body'].'</td>
					          <td> '.$comment['date'].'</td>

					          <td>
					            <a class="btn btn-primary" href="edit.php?deleteId='.$comment["id"].'">
				                <i class="fa fa-pencil text-white" aria-hidden="true"></i>
				              </a>
					          </td>
					            
					          <td>
				              <a href="delete.php?deleteId='.$comment["id"].'" class="btn btn-danger">
				                <i class="fa fa-trash text-white" aria-hidden="true"></i>
				              </a>
					          </td>
					        </tr>';
          }
        ?>
	    </tbody>
	  </table>

  </div>
</div>
<!-- End Content -->
<?php include('../../includes/footer.php'); ?>