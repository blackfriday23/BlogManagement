<?php
class user{
	private  $userId;
	private  $name;
	private  $email;
	private  $avatar;
	private  $approveStatus;
	private  $type;
	
	
	
	function __construct( $userId,$name,$email,$avatar,$approveStatus,$type ) {
		$this->userId = $userId;
		$this->name = $name;
		$this->email = $email;
		$this->avatar = $avatar;
		$this->approveStatus = $approveStatus;
		$this->type = $type;
	}
	function setUserId($userId){
		$this->userId=$userId;
	}
	function getUserId(){
		return $this->userId;
	}
	function setName($name){
		$this->name=$name;
	}
	function getName(){
		return $this->name;
	}
	
	function setEmail($email){
		$this->email=$email;
	}
	function getEmail(){
		return $this->email;
	}
	function setAvatar($avatar){
		$this->avatar=$avatar;
	}
	function getAvatar(){
		return $this->avatar;
	}
	
	function setApproveStatus($approveStatus){
		$this->approveStatus=$approveStatus;
	}
	function getApproveStatus(){
		return $this->approveStatus;
	}
	
	function setType($type){
		$this->type=$type;
	}
	function getType(){
		return $this->type;
	}
}
?>