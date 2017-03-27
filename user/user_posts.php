<?php 


$session = new sessionHandle();

$user = $session->getUser();

$start=0;
$limit=2;
(isset($_GET['id'])?$id=$_GET['id']:$id=1);
$start=($id-1)*$limit;

$db_operation = singleTon :: getInstance() -> getDbInstance();
//$fetchpost = $db_operation->fetchposts();
$fetchpost = $db_operation->fetchposts($start,$limit);
$total_posts=$db_operation->totalNumOfPosts();
$total_pages = ceil($total_posts/$limit);

//$fetchpost = $post->fetchposts();

?>

<html>

<head>
	
	
<link rel="stylesheet" type="text/css" href="<?php echo appConstant :: $ROOT_DIR ?>user/css/user_posts.css"/>

</head>

	<body>
	
	<center>
		<h2> Latest Posts </h2>
		<hr width="400px">
		<?php if($fetchpost){ ?>
		<?php foreach($fetchpost as $showpost){ ?>
		<div class="basic-grey">
			<p> 
			   <img class="circle" src="<?php echo appConstant :: $ROOT_DIR . $showpost['avatar']; ?>" width="60px"/>
		       
					<b> <u><?php echo $showpost['name'] ?></u> </b></br>
					<i> <?php echo $showpost['time'] ?> </i>
			   
			</p>
			<p class="post"> <?php echo $showpost['post']; ?> </p>
			
			<?php if($user){ ?>
				<?php if($user->getType() == appConstant :: $USER_TYPE_GENERALUSER) { ?>
					<?php if($showpost['user_id'] == $user->getUserId()){ ?>
						<?php if ($showpost['can_edit'] == '1'){?>
							<p> <a href="user/edit_post.php?id=<?php echo $showpost['id']; ?>">Edit</a> </p>
						<?php }else{ ?>
							<p> Edited </p>
						<?php } ?>
					<?php } ?>				
				<?php } else { ?>
						<p> 
						<a href="../user/edit_post.php?id=<?php echo $showpost['id']; ?>&&type=<?php echo $user->getType()?>">Edit</a>
						<a href="javascript:delete_post(<?php echo $showpost['id'];  ?>)">
							Delete
						</a>
						
						</p>
				<?php } ?>

			<?php }?>
			
			
			
			<hr width="150px"/>
		</div>
		<?php } ?>
		<?php }else{ ?>
		<p>No Post Yet </p>
		<?php } ?>
		
		<span class="pages">Page <?php echo (isset($_GET['id'])?($_GET['id']):'1') ?> From <?php echo $total_pages ?></span>
	    </br></br>
		
			   <?php
			   
				for($i=1;$i<=$total_pages;$i++)
				{
					
					if($i==(isset($id)?$id:'')) { echo " <span class='active'>" .$i. "</span>"; }
					
					else { echo "<a href='?&id=".$i."'>" .$i. "</a>"; }
					
				}
				
				?>
			  <?php
				if((isset($id)?$id:'')>1)
				{
					echo "<a href='?id=".((isset($id)?$id:'')-1)."' >Previous &nbsp;</a>";
				}
				if((isset($id)?$id:'')!=$total_pages)
				{
					echo "<a href='?&id=".((isset($id)?$id:'1')+1)."' >Next</a>";
				}
			   ?>
		
	</center>

	</body>

</html>