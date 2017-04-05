var $user=$('.user');
var $pwd=$('.pwd');
var $repwd=$('.repwd');

$user.blur(function(){
if($user.val() == ''){
	$('#error1').html('用户名不能为空');
}else{
	$('#error1').html('');
}	
})
$pwd.blur(function(){
	if($pwd.val().length <= 6){
		$('#error2').html('密码不能小于6位');
	}else{
		$('#error2').html('');
	}
	
})
$repwd.blur(function(){
	if($pwd.val() != $repwd.val()){
		$('#error3').html('密码不一致');
	}else{
		$('#error3').html('');
	}
})