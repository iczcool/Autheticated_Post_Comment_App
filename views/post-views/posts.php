<?php 
	session_start();
	
	include '../../config/database.php';
  include '../../models/post.php';

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../user-views/login.php");
    exit;
  }else{

	  $db = new Database();
		$post = new Post($db);
		$pageTitle = "List Of Posts";

		//Delete record from table
	  if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
	      $deleteId = $_GET['deleteId'];
	      $post->deletePost($deleteId);
	  }
  }
?>

<?php include('../../includes/header.php'); ?>
<!-- Content -->
<div class="col col-lg-12 content">
  <div class="dashboard-wrapper">
    <h1>Posts</h1>
    

    
	  <h2>View Records
	    <a href="post-create.php" style="float:right;"><button class="btn btn-success"><i class="fas fa-plus"></i></button></a>
	  </h2>
	  <table class="table table-hover">
	    <thead>
	      <tr>
	        <th>Id</th>
	        <th>User_Id</th>
	        <th>Title</th>
	        <th>Description</th>
	        <th>Image</th>
	        <th>Date</th>
	      </tr>
	    </thead>
	    <tbody>
        <?php 
          $posts = $post->showAllPosts(); 
          foreach ($posts as $post) {

          	echo '<tr>
					          <td> '.$post['id'].'</td>
					          <td> '.$post['user_id'].'</td>
					          <td> '.$post['title'].'</td>
					          <td> '.$post['body'].'</td>
					          <td> '.$post['image'].'</td>
					          <td> '.$post['date_posted'].'</td>

					          <td>
					            <button class="btn btn-primary mr-2"><a href="edit.php?editId=$post["id"]">
					              <i class="fa fa-pencil text-white" aria-hidden="true"></i></a>
					            </button>
					          </td>
					            
					          <td>
					            <button class="btn btn-danger">
					              <a href="index.php?deleteId=<?php echo $post["id"]">
					                <i class="fa fa-trash text-white" aria-hidden="true"></i>
					              </a>
					            </button>
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