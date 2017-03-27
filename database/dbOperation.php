<?php
include "dbConnect.php";
//require_once 'dbConnect.php';

 
class dbOperation{
	
	public static $ALERT_DATABASE_ENTRY_PROBLEM = -10;
	public static $ALERT_EMAIL_ALREADY_REGISTERED = -9;
	public static $ALERT_DB_OPERATION_SUCCESS = -8;
	
	public $_rows;
	public $_total;
	
	public $db;
	
	function __construct() {           
        // connecting to database  
         //$db_connect_ob = new dbConnect();
		 //$this->db = $db_connect_ob->getConn();
		$this->db = new mysqli('localhost','root','','jubayer_new');
               
    }  
    // destructor  
	function __destruct() {  
	
		$this->db->close();
              
    }  
	function addUser($fullname,$email,$password,$avatar,$isApprove,$type){
		if(!$this->checkIsUserAlreadyRegister($email)){
			$this->sql ="INSERT INTO `users` (`name`, `email`, `password`, `avatar`, `approveStatus`, `type`) VALUES 
			('$fullname', '$email', '$password', '$avatar', '$isApprove', '$type')";
			
			if($this->db->query($this->sql) == FALSE){
				return dbOperation :: $ALERT_DATABASE_ENTRY_PROBLEM;
			}

			$USER_ID = $this->db->insert_id;;
			
			return $USER_ID;	
				
		}else{
			return dbOperation :: $ALERT_EMAIL_ALREADY_REGISTERED;
		}
	}
	public function checkIsUserAlreadyRegister($email){
		$this->sql="SELECT * FROM `users` WHERE `email`='$email' AND `type`='user'";
		$_query = $this->db->query($this->sql);
		if($_query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	
	function getUser($email,$password){
		
		include('../model/user.php'); 
		
		$this->sql="SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
		$_query = $this->db->query($this->sql);
		
		$user = '';
		
		if($_query->num_rows === 1){	
			
			while($row=$_query->fetch_assoc()){
			
			$user = new user($row['id'],$row['name'],$row['email'],$row['avatar'],$row['approveStatus'],$row['type']);			
				
			}		
			
			return $user;
			
		}else{
			//Logged in False
			return $user;
		}
	}
	
	public $_users;	
	function fetchusers(){
		
		$this->_sql = "SELECT * FROM `users` WHERE `users`.`type`='user'";
		$_query=$this->db->query($this->_sql);
		
		while($rows = $_query->fetch_assoc()){
			$this->_users[] = $rows;
		}
		return $this->_users;
	}
	
	function updateUser($name,$avatar,$user_id){
		
		if(!empty($name) && !empty($avatar)){
			
			$this->_sql = "UPDATE `users` SET `name`='$name',`avatar`='$avatar' WHERE `users`.`id` = '$user_id'";
			$_query=$this->db->query($this->_sql);
		}else if(!empty($name)){
			$this->_sql = "UPDATE `users` SET `name`='$name' WHERE `users`.`id` = '$user_id'";
			$_query=$this->db->query($this->_sql);
		}else if(!empty($avatar)){
			$this->_sql = "UPDATE `users` SET `avatar`='$avatar' WHERE `users`.`id` = '$user_id'";
			$_query=$this->db->query($this->_sql);
		}
		
	
	}
	
	function deleteUserRecord($user_id){
		$this->_sql = "DELETE FROM `users` WHERE `users`.`id` = '$user_id'";
		$_query=$this->db->query($this->_sql);
		if($_query){
			echo "yes";
		}
	}
	
	
	function sendRequest($userid){
		
		$approveStatus = appConstant :: $USER_POST_APPROVE_STATUS_WAITING;
		
		$this->sql = "UPDATE `users` SET `approveStatus` = '$approveStatus'
		WHERE `users`.`id` = '$userid'";
		
		if($this->db->query($this->sql) == FALSE){
				return dbOperation :: $ALERT_DATABASE_ENTRY_PROBLEM;
		}else{
			return dbOperation :: $ALERT_DB_OPERATION_SUCCESS;
		}
	}
	function getUserCurrentApproveStatus($user_id){
		$approveStatus = appConstant :: $USER_POST_APPROVE_STATUS_NOTAPPROVE;
		$this->sql="SELECT `approveStatus` FROM `users` WHERE `users`.`id`='$user_id'";
		$_query = $this->db->query($this->sql);
		
		if($_query->num_rows === 1){	
			
			while($row=$_query->fetch_assoc()){
			
			$approveStatus = $row['approveStatus'];			
				
			}			
		}
		
		return $approveStatus;
			
	}
	
	
	//ADMIN OPERATION
	function approveUserRequest($id){
		
		$approveStatus = appConstant :: $USER_POST_APPROVE_STATUS_APPROVED;
		
		$this->_sql = "UPDATE `users` SET `approveStatus` = '$approveStatus' WHERE `users`.`id` = $id";
		$_query=$this->db->query($this->_sql);
	}
	function removeUserRequest($id){
		
		$approveStatus = appConstant :: $USER_POST_APPROVE_STATUS_NOTAPPROVE;
		
		$this->_sql = "UPDATE `users` SET `approveStatus` = '$approveStatus' WHERE `users`.`id` = $id";
		$_query=$this->db->query($this->_sql);
	}
	function blockUserRequest($id){
		
		$approveStatus = appConstant :: $USER_POST_APPROVE_STATUS_BLOCKED;
		
		$this->_sql = "UPDATE `users` SET `approveStatus` = '$approveStatus' WHERE `users`.`id` = $id";
		$_query=$this->db->query($this->_sql);
	}
	function unblockUserRequest($id){
		
		$approveStatus = appConstant :: $USER_POST_APPROVE_STATUS_WAITING;
		
		$this->_sql = "UPDATE `users` SET `approveStatus` = '$approveStatus' WHERE `users`.`id` = $id";
		$_query=$this->db->query($this->_sql);
	}
	
	
	
	//POST RELEATED COMMAND
	public $_posts;
	
	function fetchposts($start,$limit){
		$this->_sql = "
		SELECT `posts`.*,
			   `users`.`name`,
			   `users`.`avatar`
          FROM       `posts`
          JOIN       `users`
		  ON         `posts`.`user_id` = `users`.`id` ORDER BY `time` DESC LIMIT $start, $limit
		";
	
		$_query=$this->db->query($this->_sql);
				
		while($rows = $_query->fetch_assoc()){
			$this->_posts[] = $rows;
		}
		return $this->_posts;
	}
	function totalNumOfPosts(){
		$this->_sql = "
		SELECT `posts`.*,
			   `users`.`name`,
			   `users`.`avatar`
          FROM       `posts`
          JOIN       `users`
		  ON         `posts`.`user_id` = `users`.`id` 
		";
		
		return mysqli_num_rows($this->db->query($this->_sql));
		
	}
	
	function insertpost($user_id,$postdesc){
		$this->_sql = "INSERT INTO `posts` (`user_id`, `post`) VALUES ('$user_id', '$postdesc')";
		$_query = $this->db->query($this->_sql);
	}
	function updatePost($post_id,$postdesc){
		$this->_sql = "UPDATE `posts` SET `post` = '$postdesc',`can_edit` = '0' WHERE `posts`.`id` = '$post_id'";
		$_query = $this->db->query($this->_sql);
	}
	function deletePost($post_id){
		$this->_sql = "DELETE FROM `posts` WHERE `posts`.`id` = '$post_id'";
		$_query = $this->db->query($this->_sql);
	}
	function getPost($post_id){
		$post = "";
		$this->sql="SELECT `post` FROM `posts` WHERE `posts`.`id`='$post_id'";
		$_query = $this->db->query($this->sql);
		
		if($_query->num_rows === 1){	
			
			while($row=$_query->fetch_assoc()){
			
			$post = $row['post'];			
				
			}			
		}
		
		return $post;
			
	}
	
	
	
}
?>