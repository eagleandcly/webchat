<?php
define('ACC',true);
include("./include/init.php");
session_start();
$msg=new MsgModel();

$act=isset($_POST['act'])?$_POST['act']:'';
if($act=='add'){
	$data=array();
	$data['user_id']=$_SESSION['id'];
	$data['ruser_id']=$_POST['ruser_id'];
	$data['content']=$_POST['content'];
	$data['time']=time();
	
	if($msg->add($data)){
		$result='{"sucess":false,"msg":""}';
		$result=$msg->getById($data['user_id'],$data['ruser_id'])?
				$msg->getById($data['user_id'],$data['ruser_id']):$result;
		echo $result;		
	}
}else{
	$result='{"sucess":false,"msg":""}';
	$user_id=$_SESSION['id'];
	$ruser_id=$_POST['ruser_id'];
	
	$result=$msg->getById($user_id,$ruser_id)?$msg->getById($user_id,$ruser_id):$result;
	echo $result;

}
?>