<?php

//include('../database/dbOperation.php');
include_once "../appdata/singleTon.php";
include_once "../appdata/sessionHandle.php";
//include('appdata/sessionHandle.php');
//include('../appdata/appConstant.php');
include_once "../appdata/appConstant.php";

$loginsubmit = (isset($_POST['loginsubmit'])?$_POST['loginsubmit']:'');

if($loginsubmit){	
	$email =(isset($_POST['email'])?$_POST['email']:'');
	$password =(isset($_POST['password'])?$_POST['password']:'');

	$message = "OK";
	
	$db_operation = singleTon :: getInstance() -> getDbInstance();
	
		
	$user = $db_operation->getUser($email,$password);
		
	if($user){
		$session = new sessionHandle();
		$session->setUser($user);
			
		//echo $user->getName();
			
		//Logged in True
		if($user->getType() == appConstant :: $USER_TYPE_GENERALUSER){
			header('Location: ../user/profile.php');
		}else if($user->getType() == appConstant :: $USER_TYPE_ADMIN){
			header('Location: ../admin/index.php');
		}
	}else{
		$message = "<font color='red'>Error in Email or password please try again</font>";
	}
	

	

}


$sfullname =(isset($_SESSION['fullname'])?$_SESSION['fullname']:'');
if($sfullname){
	header('Location: index.php');
}


?>

<html>
    <head>
        <title> Login </title>
		<link rel="stylesheet" type="text/css" href="../css/styles.css"/>
		<link rel="stylesheet" type="text/css" href="../css/main.css"/>

    </head>
    <body>
		<?php	include('../header.php'); ?>
        <div id="loginmember">
				</br></br>
				<form action="" method="post" class="basic-grey">
					<h1>Login 
						<span>Login with an existing account</span>
					</h1>
					<label>
						<span>Email :</span>
						<input id="name" type="email" name="email" placeholder="Your Email" />
					</label>
					
					<label>
						<span>Password :</span>
						<input id="password" type="password" name="password" placeholder="Your Password" />
					</label>
				   
					<label>
						<span>&nbsp;</span> 
						<input type="submit" class="button" name="loginsubmit" value="Login" /> 
					</label>  
					
					<label>
						 <span>&nbsp;</span> 
						<p> <?php echo (isset($message)?$message:''); ?> </p> 
					</label>					
				</form>


           
        </div>
        
    </body>
</html>