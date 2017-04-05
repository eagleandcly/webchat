<?php
define('ACC',true);
include("./include/init.php");

$act=isset($_POST['act'])?$_POST['act']:'';
if($act=='register'){
	header("Content-type:text/html;charset=utf-8");
	$data=array();
	$data['username']=$_POST['user'];
	$data['password']=$_POST['password'];
	$data['sex']=$_POST['sex'];
	$uptool=new UpTool();
	$hpot=$uptool->up('hpot');
	if($hpot){
		$data['hpot']=$hpot;
	}
	$data['time']=time();
	$user=new UserModel();
	if($user->add($data)){
		redirect('login.php',1,'注册成功');
	}else{
		redirect('register.php',1,'注册失败');
	}

}elseif ($act=='usercheck') {
	header("Content-type:application/json;charset=utf-8");
	$name=$_POST['user'];
	$user=new UserModel();
	if($user->checkUser($name)){
		echo '{"sucess":true,"msg":"用户名已存在"}';
		exit;
	}	
}

include("./view/register.html");
?>