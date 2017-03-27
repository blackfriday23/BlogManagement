<?php
include_once "appdata/sessionHandle.php";
include_once "appdata/appConstant.php";
//include('appdata/sessionHandle.php');

$session = new sessionHandle();

$user = $session->getUser();

?>
<div id="header">
    <ul>

        <?php if ($user) { ?>

            <?php if ($user->getType() == appConstant:: $USER_TYPE_GENERALUSER) { ?>
                <li><a href=<?php echo appConstant:: $ROOT_DIR; ?>>Home</a></li>
                <li><a href=<?php echo appConstant:: $ROOT_DIR . "user/profile.php"; ?>>Profile</a></li>
				<li><a href=<?php echo appConstant:: $ROOT_DIR . "loginRegistration/logout.php"; ?>>Logout</a></li>
            <?php } else { ?>
                <li><a href=<?php echo appConstant:: $ROOT_DIR . "admin/index.php"; ?>>Dashboard</a></li>
                <li><a href=<?php echo appConstant:: $ROOT_DIR . "admin/blog_manage.php"; ?>>Blog</a></li>
                <li><a href=<?php echo appConstant:: $ROOT_DIR . "loginRegistration/logout.php"; ?>>Logout</a></li>
            <?php } ?>


        <?php } else { ?>
            <li><a href=<?php echo appConstant:: $ROOT_DIR; ?>>Home</a></li>
            <li><a href=<?php echo appConstant:: $ROOT_DIR . "loginRegistration/login.php"; ?>>Login</a></li>
            <li><a href=<?php echo appConstant:: $ROOT_DIR . "loginRegistration/register.php"; ?>>Sign up</a></li>
        <?php } ?>
    </ul>
</div>