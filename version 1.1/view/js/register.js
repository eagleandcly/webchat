var $user=$('.user');
var $pwd=$('.pwd');
var $repwd=$('.repwd');
var $re_user=$('#re_user');

//用户名验证
$user.blur(function(){
if($user.val() == ''){
	$('#error1').html('用户名不能为空');
}else{
	$('#error1').html('');
}	
});

//密码验证
$pwd.blur(function(){
	if($pwd.val().length <= 6){
		$('#error2').html('密码不能小于6位');
	}else{
		$('#error2').html('');
	}
	
})

//确认密码验证
$repwd.blur(function(){
	if($pwd.val() != $repwd.val()){
		$('#error3').html('密码不一致');
	}else{
		$('#error3').html('');
	}
})

$re_user.blur(function(){
	var user=$re_user.val();
	$.post("register.php",{act:'usercheck',user:user},function(result){
		if (result.sucess) {
			$('#error1').html(result.msg);
		}
	})
})