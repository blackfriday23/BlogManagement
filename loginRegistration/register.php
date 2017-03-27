<?php
include('../model/user.php');
//include('../database/dbOperation.php');
include_once "../appdata/singleTon.php";
include_once "../appdata/sessionHandle.php";
//include('appdata/sessionHandle.php');
include('../appdata/appConstant.php');

$submitregister = (isset($_POST['submitregister'])?$_POST['submitregister']:'');

if($submitregister){
	
	$fullname = (isset($_POST['fullname'])?$_POST['fullname']:'');
	$email = (isset($_POST['email'])?$_POST['email']:'');
	$password = (isset($_POST['password'])?$_POST['password']:'');
	$confpassword = (isset($_POST['confpassword'])?$_POST['confpassword']:'');
	
	if(!empty($fullname) && !empty($email) && !empty($password) && !empty($confpassword)){
		$avatar =  appConstant :: $USER_AVATAR_DEFAULT_URL;
	
	$target_dir =  "../" . appConstant :: $USER_AVATAR_DIR;
	$target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["profilepic"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	
	if ($uploadOk == 0) {
	
	} else {
		if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
			
			$avatar = appConstant :: $USER_AVATAR_DIR . $_FILES["profilepic"]["name"];
			echo $avatar;
			
		} else {
			
		}
	}
	
	if($password == $confpassword){
		
		$db_operation = singleTon :: getInstance() -> getDbInstance();
		$return_msg = $db_operation->addUser($fullname,$email,$password,$avatar,false,"user");
		
		if($return_msg == dbOperation :: $ALERT_EMAIL_ALREADY_REGISTERED){
			
			$message = "<font color='red'>User With This Email Id Already Registered</font>";
			
		}else if($return_msg == dbOperation :: $ALERT_DATABASE_ENTRY_PROBLEM){
			
			$message = "<font color='red'>Something wrong during database insert operation!!!</font>";
			
		}else{
			
			$user_id = $return_msg;
			
			$user = new user($user_id,$fullname,$email,$avatar,false,"user");
			
			

			$session = new sessionHandle();
			$session->setUser($user);
			
			//echo $avatar;
			
			//echo $user->getName();
			
			//Logged in True
			header('Location: ../user/profile.php');
		}
		
	}else{
		$message = "<font color='red'>Password Don't Match !</font>";
	}
	}else{
		$message = "<font color='red'>Please Fill All The Field</font>";
	}
	
	
	
	
}

?>

<html>
    <head>
        <title> Register a new account </title>
		<link rel="stylesheet" type="text/css" href="../css/styles.css"/>
		<link rel="stylesheet" type="text/css" href="../css/main.css"/>
    </head>
    <body>
		<?php	include('../header.php'); ?>
        <div id="registermember">
          			
			</br></br>
				<form action="" method="post" class="basic-grey" enctype="multipart/form-data">
					<h1>Sign up 
						<span>Signup a new account</span>
					</h1>
					<label>
						<span>Name :</span>
						<input id="name" type="text" name="fullname" placeholder="Your Name" />
					</label>
					
					<label>
						<span>Email :</span>
						<input id="name" type="email" name="email" placeholder="Your Email" />
					</label>
					
					
					
					<label>
						<span>Password :</span>
						<input id="password" type="password" name="password" placeholder="Your Password" />
					</label>
					
					<label>
						<span>Confirm Password :</span>
						<input id="confpassword" type="password" name="confpassword" placeholder="Confirm Password" />
					</label>
				   
				   <label>
						Profile Picture : <input type="file" name="profilepic" id="profilepic"/>
					</label>
					</br></br>
					<label>
						<span>&nbsp;</span> 
						<input type="submit" class="button" name="submitregister" value="Sign up" /> 
					</label>  
					
					<label>
						 <span>&nbsp;</span> 
						<p> <?php echo (isset($message)?$message:''); ?> </p> 
					</label>					
					
					
				</form>
				
        </div>

        
    </body>
</html>