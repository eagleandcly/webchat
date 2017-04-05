<?php
define('ACC',true);
include("./include/init.php");
session_start();
if(!isset($_SESSION['user'])){
	header("Content-type:text/html;charset=utf-8");
	redirect("login.php",1,"还未登录");
}
$user=new UserModel();
$userRow=$user->getByName($_SESSION['user']);
$friend=array();
$friend=$user->getFriend($userRow['user_id'])?
			$user->getFriend($userRow['user_id']):$friend;

include("./view/index.html");
?>