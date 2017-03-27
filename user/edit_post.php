<?php

//include_once "../database/dbOperation.php";
include_once "../appdata/singleTon.php";

$post_id = (isset($_GET['id'])?$_GET['id']:'');
$user_type = (isset($_GET['type'])?$_GET['type']:'');


$db_operation = singleTon :: getInstance() -> getDbInstance();
$post = $db_operation->getPost($post_id);

$makeedit = (isset($_POST['makeedit'])?$_POST['makeedit']:'');
if($makeedit){
	
	$postdesc=(isset($_POST['postdesc'])?$_POST['postdesc']:'');

	$insertpost = $db_operation->updatePost($post_id,$postdesc);
	
	if($user_type){
		header("Location:../admin/blog_manage.php");
	}else{
		header("Location:../index.php");
	}
	
}


?>


<html>
<body>

<center>
	<div id="postarea">
		<form method="post" action="">
			<p><textarea name="postdesc" style="width:250px;height:60px" placeholder="Say any thing"><?php echo $post ?></textarea></p>
				
				<p><input type="submit" name="makeedit"/></p>
				<hr width="280px"/>
		</form>
	</div>
</center>	


</body>
</html>