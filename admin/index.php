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

$admin = $session->getUser();
if(!$admin){
	header("Location: ". appConstant :: $ROOT_DIR); /* Redirect browser */
	exit();
}


$approve = (isset($_GET['approve'])?$_GET['approve']:'');
$decline = (isset($_GET['decline'])?$_GET['decline']:'');
$block = (isset($_GET['block'])?$_GET['block']:'');
$unblock = (isset($_GET['unblock'])?$_GET['unblock']:'');
$delete = (isset($_GET['delete'])?$_GET['delete']:'');
$update = 0;
if($approve){
	$update = $db_operation->approveUserRequest($approve);
	$update = 1;
}else if ($decline){
	$update = $db_operation->removeUserRequest($decline);
	$update = 1;
}else if($block){
	$update = $db_operation->blockUserRequest($block);
	$update = 1;
}else if($unblock){
	$update = $db_operation->unblockUserRequest($unblock);
	$update = 1;
}else if($delete){
	$update = $db_operation->deleteUserRecord($delete);
	$update = 1;
}
if($update == 1){
	header("Location: ". appConstant :: $ROOT_DIR . "admin/");
}

$users = $db_operation->fetchusers();

?>
<html>
	<head>
		<title> Admin </title>
		<link rel="stylesheet" type="text/css" href="../css/styles.css"/>
		<style>
			table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%;
			}

			td, th {
				border: 1px solid #dddddd;
				text-align: left;
				padding: 8px;
			}

			tr:nth-child(even) {
				background-color: #dddddd;
			}
		</style>
		<script type="text/javascript">
			function remove(id)
			{
				if(confirm('Are You Sure To Remove This User ?')){
					window.location.href='?decline='+id;
				}
			}
			function block(id)
			{
				if(confirm('Are You Sure To Block This User ?')){
					window.location.href='?block='+id;
				}
			}
			function delete_user(id)
			{
				
				if(confirm('Are You Sure To Delete This User ?')){
					window.location.href='?delete='+id;
				}
			}
		</script>
	</head>
	<body>
	<?php	include('../header.php'); ?>
	</br>

	<center>
			<table>
			  <tr>
				<th>id</th>
				<th>User</th>
				<th>Request</th>
				<th>Approve</th>
				<th>Delete User</th>
				
			  </tr>
			  <?php $i=1; foreach($users as $showusers){  ?>
			  
			  <tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $showusers['name']; ?></td>
				
				<?php if($showusers['approveStatus'] == appConstant :: $USER_POST_APPROVE_STATUS_NOTAPPROVE){ ?>
					<td> 
						<font color="red">Not Approved</font> 
					</td>
				<?php }else if($showusers['approveStatus'] == appConstant :: $USER_POST_APPROVE_STATUS_APPROVED){ ?>
					<td>
						<font color="green">Approved</font>
					</td>
				<?php }else if($showusers['approveStatus'] == appConstant :: $USER_POST_APPROVE_STATUS_WAITING){ ?>
					<td>
						<font color="orange">Wating to Approve (Request Sent)</font>
					</td>
				<?php }else if($showusers['approveStatus'] == appConstant :: $USER_POST_APPROVE_STATUS_BLOCKED){ ?>
					<td>
						<font color="red">USER IS BLOCKED</font>
					</td>
				<?php } ?>
				
				<?php if($showusers['approveStatus'] == appConstant :: $USER_POST_APPROVE_STATUS_WAITING) { ?>
					<td>
					<a href="?approve=<?php echo $showusers['id']; ?>">
					Yes
					</a> 
					/ 
					<a href="?decline=<?php echo $showusers['id']; ?>">
					No
					</a>
					</td>
				<?php }else if($showusers['approveStatus'] == appConstant :: $USER_POST_APPROVE_STATUS_NOTAPPROVE) { ?>
					<td> 
						No Request Sent
					</td>
				<?php }else if($showusers['approveStatus'] == appConstant :: $USER_POST_APPROVE_STATUS_APPROVED) { ?>
					<td>
					     
						<a href="javascript:remove(<?php echo $showusers['id'];  ?>)">
						Remove
						</a>
						/
						<a href="javascript:block(<?php echo $showusers['id'];  ?>)">
							Block
						</a>
					</td>
				<?php }else if($showusers['approveStatus'] == appConstant :: $USER_POST_APPROVE_STATUS_BLOCKED){ ?>
					<td>
						<a href="?unblock=<?php echo $showusers['id']; ?>">
							UnBlock
						</a>
					</td>
				<?php } ?>
				
				<td align="center"><a href="javascript:delete_user(<?php echo $showusers['id']; ?>)"><img src="delete.png" width="30px"/></a></td>
			  
			  </tr>
			  <?php $i=$i+1; } ?>
			  
			</table>

	</center>
	</body>
</html>


















































