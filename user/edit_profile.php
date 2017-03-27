<?php
include('../model/user.php');
include_once "../appdata/sessionHandle.php";
include_once "../appdata/appConstant.php";
include_once "../appdata/singleTon.php";

$session = new sessionHandle();
$db_operation = singleTon :: getInstance() -> getDbInstance();

$user = $session->getUser();

if(!$user){
	header("Location: ". appConstant :: $ROOT_DIR); /* Redirect browser */
	exit();
}



$submitupdate = (isset($_POST['submitupdate'])?$_POST['submitupdate']:'');

if($submitupdate){
	$fullname = (isset($_POST['fullname'])?$_POST['fullname']:'');
	
	$avatar =  "";
	
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
		
		$previous_avatar = "../" .  $user->getAvatar();
		unlink($previous_avatar);
		
		if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
			
			$avatar = appConstant :: $USER_AVATAR_DIR . $_FILES["profilepic"]["name"];
			//echo $avatar;
			
		} else {
			
		}
	}
	
	
	$update = 0;
	if(!empty($fullname) && !empty($avatar)){
		$db_operation->updateUser($fullname,$avatar,$user->getUserId());
		$user->setName($fullname);
		$user->setAvatar($avatar);
		$update = 1;
		
	}else if(!empty($fullname)){
		$db_operation->updateUser($fullname,$avatar,$user->getUserId());
		$user->setName($fullname);
		$update = 1;
	}else if(!empty($avatar)){
		$db_operation->updateUser($fullname,$avatar,$user->getUserId());
		$user->setAvatar($avatar);
		$update = 1;
	}else{
		$message = "<font color='red'>Nothing to update!!</font>";
	}
	if($update == 1){
		$session->setUser($user);
		header("Location:../user/profile.php");
	}
}


?>

<html>
<head>
	<title> Edit Profile  </title>
	<link rel="stylesheet" type="text/css" href="../css/styles.css"/>
	<link rel="stylesheet" type="text/css" href="../css/main.css"/>
</head>



<body>
	
	<form action="" method="post" class="basic-grey" enctype="multipart/form-data">
					<h1>Edit Profile 
						<span>Edit Your Personal Information</span>
					</h1>
					<label>
						<span>Name :</span>
						<input id="name" type="text" name="fullname" placeholder="Your Name" />
					</label>	
				   
				   <label>
						Profile Picture : <input type="file" name="profilepic" id="profilepic"/>
					</label>
					</br></br>
					<label>
						<span>&nbsp;</span> 
						<input type="submit" class="button" name="submitupdate" value="Update" /> 
					</label>  
					
					<label>
						 <span>&nbsp;</span> 
						<p> <?php echo (isset($message)?$message:''); ?> </p> 
					</label>					
					
					
	</form>
	
</body>
</html>