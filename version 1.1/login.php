<?php
define('ACC',true);
include("./include/init.php");
$act=isset($_POST['act'])?$_POST['act']:'';
$msg1='';
$msg2='';
if($act=='login'){
	session_start();
	header("Content-type:application/json;charset=utf-8");
	$name=$_POST['user'];
	$password=$_POST['password'];
	$user=new UserModel();
	if(!$user->checkUser($name)){
		$msg1='用户名不存在';
		include("./view/login.html");
		exit;
	}
	if(!$user->checkUser($name,$password)){
		$msg2='密码不正确';
		include("./view/login.html");
		exit;		
	}
	$user_id=$user->checkUser($name);
	$_SESSION['user']=$name;
	$_SESSION['id']=$user_id;
	redirect("index.php",1,'登录成功');
}
include("./view/login.html");
?>