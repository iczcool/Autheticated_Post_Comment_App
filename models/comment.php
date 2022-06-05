<?php 
    //require_once "../config/Database.php";

	class Comment{
		//private $id;
		private $postId;
        private $userId;
        public $name;
		public $body;
		public $date;

		public $db;

        public function __construct($db){
            $this->db = $db;
        }

		// Insert data into ccomment table
        public function createComment($userId, $postId, $name, $body){
            $this->postId = $this->db->con->real_escape_string($postId);
            $this->userId = $this->db->con->real_escape_string($userId);
            $this->name = $this->db->con->real_escape_string($name);
            $this->body = $this->db->con->real_escape_string($body);
            // $this->date = $this->db->con->real_escape_string($date);

            $query="INSERT INTO comments(user_id,post_id,name,body,date) VALUES('$this->userId','$this->postId','$this->name','$this->body',NOW())";
            $sql = $this->db->con->query($query);
            if ($sql==true) {
                header("Location:index.php?msg2=comment");
            }else{
                echo '<p style="color:red">Could not post comment, try again!</p>';
            }
            $this->db->con->close();
        }

        public function showAllComments(){
            $query = "SELECT * FROM comments ORDER BY date DESC";
            $result = $this->db->con->query($query);
        
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                   $data[] = $row;
                }
                return $data;
            }else{
             exit("No comments found!");
            }
            $this->db->con->close();
        }

        public function showPostComments($postId){
            $query = "SELECT * FROM comments 
            WHERE post_id = '$postId' 
            ORDER BY date DESC";
            $result = $this->db->con->query($query);
        
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                   $data[] = $row;
                }
                return $data;
            }else{
             echo "No comments found!";
            }
            $this->db->con->close();
        }

        public function deleteComment($deleteId){
            $query = "DELETE FROM comments WHERE id = '$deleteId'";
            $sql = $this->db->con->query($query);
            if ($sql==true) {
                header("Location:index.php?successMsg=delete");
            }else{
                echo "Comment wasn't deleted, please try again!";
            }
            $this->db->con->close();
        }
	}
?>