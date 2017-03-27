<?php
require_once __DIR__."/../config.php";
require_once SITE_ROOT."/database/dbOperation.php";
//include_once "../database/dbOperation.php";
//require_once(__ROOT__.'/database/dbOperation.php'); 
class singleTon {
	
private static $instance = null;
private static $dbOperation = null;

private function __clone(){}
 


private function __construct()
  {
    self::$dbOperation = new dbOperation();
  } 
public static function getInstance()
 {
    if (!self::$instance)
    {
      self::$instance = new self();
    }
    return self::$instance;
 }
public static function getDbInstance(){
	return self::$dbOperation;
} 

}
?>