<?php

include_once "../appdata/sessionHandle.php";
include_once "../model/user.php";
include_once "../appdata/appConstant.php";
include_once "../appdata/singleTon.php";
//include_once "../database/dbOperation.php";
//include('../database/dbOperation.php');
//include('appdata/appConstant.php');

$session = new sessionHandle();
$db_operation = singleTon :: getInstance() -> getDbInstance();

$user = $session->getUser();
if (!$user) {
    header("Location: " . appConstant:: $ROOT_DIR); /* Redirect browser */
    exit();
}

$delete = (isset($_GET['delete']) ? $_GET['delete'] : '');

if ($delete) {
	
    $update = $db_operation->deletePost($delete);
	header("Location: ". appConstant :: $ROOT_DIR . "admin/blog_manage.php");
    //echo $delete;
}


?>

<html>
<head>
    <title> Home </title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
	<script type="text/javascript">
		function delete_post(id)
			{
				if(confirm('Are You Sure To Delete This Post ?')){
					window.location.href='?delete='+id;
				}
			}
		
	</script>
</head>

<body>
<?php include('../header.php'); ?>
</br>
<?php include '../user/user_posts.php'; ?>
</body>
</html>











