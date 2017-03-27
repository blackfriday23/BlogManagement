<?php
class sessionHandle{
	
	
	//include('appdata/sessionHandle.php');
	//include('../model/user.php');
	  
	
	
	function __construct() {            
        if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}      
    }  
	
	function setUser($user){
		$_SESSION['user']=$user;
		
	}
	
	function getUser(){
		
		
		return $user =(isset($_SESSION['user'])?$_SESSION['user']:'');
		
		
		 
	}
	function destroy_session(){
		session_unset(); 
		session_destroy();	
	}
}
?>