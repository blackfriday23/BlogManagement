<?php

include('../model/user.php');
include_once "../appdata/sessionHandle.php";
include_once "../appdata/appConstant.php";

//include('appdata/sessionHandle.php');

$session = new sessionHandle();

$user = $session->getUser();
if(!$user){
	header("Location: ". appConstant :: $ROOT_DIR); /* Redirect browser */
	exit();
}

?>

<html>
<head>
	<title> Home  </title>
	<link rel="stylesheet" type="text/css" href="../css/styles.css"/>
	<link rel="stylesheet" type="text/css" href="../css/main.css"/>
</head>
<body>

	<?php	include('../header.php'); ?>
	</br>
	
	<?php if($user){ ?>
		<center>
		 
		  
			<div class="divprofile"> 
				<p><b><u>Member Area</u></b></p>
				<p><img class="circle" src="<?php echo appConstant :: $ROOT_DIR . $user->getAvatar(); ?>" width="100px"/></p>
				<p>Name :  <u><?php echo $user->getName(); ?></u></p> 
				<p>Email :  <u><?php echo $user->getEmail(); ?></u></p>
				<p><a href="edit_profile.php">Edit Profile</a></p>
				
			</div>
		 
			
		</center>
        
    <?php }else{
		
	     header( "Location: ../index.php");	
		 exit();
		
	}?>
        
            
		

	
</body>

</html>