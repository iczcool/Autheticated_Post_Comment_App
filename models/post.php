<?php 
    //require_once "../config/Database.php";
?>
<?php
	class Post{
		// private $id;
		// public $userId;
		// public $title;
		// public $body;
		// public $image;
		// public $datePosted;
        public $db;

        public function __construct($db){
            $this->db = $db;
        } 

        // Insert customer data into customer table
        public function createPost($data){
            $userId = $this->db->con->real_escape_string($data[0]);
            $title = $this->db->con->real_escape_string($data[1]);
            $body = $this->db->con->real_escape_string($data[2]);
            $image = $this->db->con->real_escape_string($data[3]);

            $query="INSERT INTO posts(user_id,title,body,image,date_posted) VALUES('$userId','$title','$body','$image',NOW())";
            $sql = $this->db->con->query($query);
            if ($sql==true) {
                header("Location:index.php?msg1=insert");
            }else{
                echo '<p style="color:red">Your post failed, try again!</p>';
            }
            $this->db->con->close();
        }

        public function showAllPosts(){
            $query = "SELECT * FROM posts ORDER BY date_posted DESC";
            $result = $this->db->con->query($query);
        
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                   $data[] = $row;
                }
                return $data;
            }else{
             exit("No record found!");
            }
            $this->db->con->close();
        }
        public function showLatestPost(){
            $query = "SELECT * FROM posts ORDER BY date_posted DESC";
            $result = $this->db->con->query($query);
        
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                   $data[] = $row;
                }
                return $data;
            }else{
             exit("No record found!");
            }
            $this->db->con->close();
        }

        // Fetch single data for edit from post table
        public function showOnePost($id){
            // $this->db = new Database();
            $query = "SELECT * FROM posts WHERE id = '$id'";
            $result = $this->db->con->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row;
            }else{
                echo "Record not found";
            }
            $this->db->con->close();
        }

        public function deletePost($postId){
            // $this->db = new Database();
            $query = "DELETE FROM posts WHERE id = '$postId'";
            $sql = $this->db->con->query($query);
            if ($sql==true) {
                header("Location:index.php?msg3=delete");
            }else{
                echo "Post wasn't deleted, please try again!";
            }
            $this->db->con->close();
        }

        public function updatePost($postData){
            // $this->db = new Database();
            $id = $this->db->con->real_escape_string($_POST['id']);
            $userId = $this->db->con->real_escape_string($_SESSION['userId']);
            $imagePath = $this->db->con->real_escape_string($_SESSION['imagePath']);
            $title = $this->db->con->real_escape_string($_POST['title']);
            $description = $this->db->con->real_escape_string($_POST['description']);
            $postDate = date('d/m/Y');

            if (!empty($id) && !empty($postData)) {
                $query = "UPDATE posts SET user_id = '$userId', image_path = '$imagePath', title = '$title', description = '$description', post_date = '$postDate' WHERE id = '$id'";
                $sql = $this->db->con->query($query);
                if ($sql==true) {
                    header("Location:index.php?msg2=update");
                }else{
                    echo "Registration updated failed try again!";
                }
            }
            $this->db->con->close();
        }
	}
?>