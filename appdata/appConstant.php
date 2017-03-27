<?php

class appConstant{
	public static $ROOT_DIR = "http://localhost/jubayerBlog5/";
	
	//public static $USER_AVATAR_DIR =  appConstant :: $ROOT_DIR . "user/avatar/";
	//public static $USER_AVATAR_DEFAULT_URL = appConstant :: $USER_AVATAR_DIR . "default.png";
	public static $USER_AVATAR_DIR = "user/avatar/";
	public static $USER_AVATAR_DEFAULT_URL = "user/avatar/default.png";
	
	public static $USER_POST_APPROVE_STATUS_NOTAPPROVE = 0;
	public static $USER_POST_APPROVE_STATUS_WAITING = 1;
	public static $USER_POST_APPROVE_STATUS_APPROVED = 2;
	public static $USER_POST_APPROVE_STATUS_BLOCKED = 3;
	
	public static $USER_TYPE_GENERALUSER = 'user';
	public static $USER_TYPE_ADMIN = 'admin';
	
}
?>