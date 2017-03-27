<?php

include_once "appdata/sessionHandle.php";
include_once "model/user.php";
include_once "appdata/appConstant.php";
include_once "appdata/singleTon.php";
//include('../database/dbOperation.php');
//include('appdata/appConstant.php');

$session = new sessionHandle();
$db_operation = singleTon :: getInstance() -> getDbInstance();
$error_message = "";

$user = $session->getUser();
if ($user) {
    if ($user->getType() == appConstant:: $USER_TYPE_ADMIN) {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        echo "The page that you have requested could not be found.";
        exit();
    }
    $user->setApproveStatus($db_operation->getUserCurrentApproveStatus($user->getUserId()));
}


$submitRequest = (isset($_POST['submitRequest']) ? $_POST['submitRequest'] : '');
if ($submitRequest) {


    $return_msg = $db_operation->sendRequest($user->getUserId());

    if ($return_msg == dbOperation:: $ALERT_DB_OPERATION_SUCCESS) {
        $user->setApproveStatus(appConstant:: $USER_POST_APPROVE_STATUS_WAITING);
        $session->setUser($user);
    }

    //echo "<font color='red'>This Function Is UnderConstruction</font>";
}


$makePost = (isset($_POST['makepost']) ? $_POST['makepost'] : '');
if ($makePost) {

    $user->setApproveStatus($db_operation->getUserCurrentApproveStatus($user->getUserId()));

    if ($user->getApproveStatus() == appConstant:: $USER_POST_APPROVE_STATUS_APPROVED) {
        $postdesc = (isset($_POST['postdesc']) ? $_POST['postdesc'] : '');

        $insertpost = $db_operation->insertpost($user->getUserId(), $postdesc);
    } else {
        $error_message = "<font color='red'>Your are removed From Approve By Admin! Please Contact With Admin!!</font>";
    }


}


?>
<html>
<head>
    <title> Home </title>
    <link rel="stylesheet" type="text/css" href="css/styles.css"/>
	
</head>

<body>
<?php include('header.php'); ?>
</br>
<?php if (!empty($error_message)) {
    echo $error_message;
} ?>
<?php if ($user) { ?>

    <?php if ($user->getApproveStatus() == appConstant:: $USER_POST_APPROVE_STATUS_APPROVED) { ?>
        <center>
            <div id="postarea">
                <form method="post" action="">
                    <p><textarea name="postdesc" style="width:250px;height:60px" placeholder="Say any thing"></textarea>
                    </p>
                    <input type="hidden" name="user_id" value="<?php echo $user->getUserId(); ?>"/>
                    <p><input type="submit" name="makepost"/></p>
                    <hr width="280px"/>
                </form>
            </div>
        </center>
    <?php } else if ($user->getApproveStatus() == appConstant:: $USER_POST_APPROVE_STATUS_NOTAPPROVE) { ?>

        <center>
            <div>
                <p> You Are NOT Approve</p>
                <p>
                <form action="" method="POST">
                    <input type="submit" name="submitRequest" value="Send Request To Admin"><br>
                </form>
                </p>
            </div>
        </center>

    <?php } else if ($user->getApproveStatus() == appConstant:: $USER_POST_APPROVE_STATUS_WAITING) { ?>
	  
	  <center >
        <p> <font color="yellow">Your Request Is now On Waiting Stage!!</font></p>
	  </center>

    <?php } else { ?>

	<center>
	   <center >
        <p><font color="red"> You Are Blocked!!</font></p>
		<p><font color="black"> You cant Post Now!!</font></p>
	   </center>
    </center>
	
    <?php } ?>

<?php } ?>

<?php include 'user/user_posts.php'; ?>

</body>

</html>