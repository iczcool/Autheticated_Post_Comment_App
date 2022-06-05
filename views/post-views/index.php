<?php
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: ../user-views/login.php");
      exit;
  }

  require_once '../../config/database.php';
  include('../../models/post.php');
  include('../../models/comment.php');
  include('../../models/user.php');
  $db = new Database();
  $post = new Post($db);
  $user = new User($db);
  $comment = new Comment($db);

  //LOAD LATEST POST FROM DATABASE
  $posts = $post->showAllPosts();
  $currentPost = $posts[0];
  if (isset($_GET['currentId'])){ 
    $currentId = $_GET['currentId'];
    for ($i=0; $i<count($posts); $i++) { 
      if ($posts[$i]['id'] == $currentId) {
        $currentPost = $posts[$i];
      }
    }
  }

  //LOAD THE USER WHO CREATED THE POST
  $id = $currentPost['user_id'];
  $user = $user->showOneUser($id);

  //INSERT COMMENT INTO DATABASE IF USER MAKES A COMMENT
  if (isset($_POST['submit']) && !empty($_POST['body'])){
    
    $postId = $_POST['id'];
    $userId = $_SESSION['id'];
    $name = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
    $body = $_POST['body'];
    $comment->createComment($userId, $postId, $name, $body);
    
  }
?>

<?php include('../../includes/header.php'); ?>
        
    <!-- Content -->
    <div class="col col-lg-12 content">
      <div class="row">
        <div class="col col-12 col-lg-8 col-md-8 col-sm-12 col-xs-12 new-post">
          
          <!-- Post Area -->
          <div class="post-area">
            <!-- Title -->
            <h1 class="post-title text-center"><?php echo $currentPost['title']; ?></h1>
              <div class="post-image">
                <!-- Image -->
                <img src="<?php echo '../../assets/images/uploads/'.$currentPost['image']; ?>">
              </div>
              <div class="post-description">
                <p><?php echo $currentPost['body']; ?></p>
              </div>
              <div class="row post-date" style="padding:0;margin:0;">
                <div class="col-6"><p><em><?php echo '<b>Posted by:</b> '.$user; ?></em></p></div>
                <div class="col-6"><p><em><?php echo $currentPost['date_posted']; ?></em></p></div>
              </div>
          </div>
          <!-- End Post Area -->

          <hr>
          
          <!-- Comment Area -->
          <div class="comment-area">
            <h3>Comments...</h3>
            <div class="comment-thread">
              <!-- Comment Item -->
              <?php 
                $comments = $comment->showPostComments($currentPost['id']); 
                if ($comments) {
                  foreach($comments as $comment){
                    $date = date_create($comment['date']);
                    $date = date_format($date,"H:m d/m/Y");
                    echo'<div class="row comment-item">
                          <div class="col-1 comment-item-image"><div class="image"><i class="fa fa-user fa-4x"></i></div></div>
                          <div class="col-11 comment-item-body">
                            <p><b>'.$comment['name'].'</b> said..<br> '.$comment['body'].' &nbsp;&nbsp;&nbsp; '.$date.'</p>
                          </div>
                        </div>';
                  }
                }
              ?>
              <!-- End Comment Item -->
            </div>

            <!-- Begin Form -->
            <div class="form-area">
              <h3>Express Yourself About The Post..</h3>
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
          <!-- End Comment Area -->
        </div>

        <!-- Old Posts -->
        <div class="col col-12 col-lg-4 col-md-4 col-sm-12 col-xs-12 old-post">
          <div style="border:1px solid lightgrey; min-height: 100%; padding:20px;">
            <h4>Recent Posts</h4>
            <?php 
              foreach($posts as $post){
                echo '<li>
                        <a href="index.php?currentId='.$post['id'].'"><b>'.$post['title'].'</b></a>
                      </li>';
              }
            ?>
          </div>
        </div>
      <!-- End Old Posts -->
      </div>    
    </div>
    <!-- End Content -->
    
   <?php include('../../includes/footer.php'); ?>
