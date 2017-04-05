<?php
defined('ACC') || exit("ACC deny");
define('ROOT',str_replace('\\', '/', 
	dirname(dirname(__FILE__))).'/'); //定义网站的根目录 
define('DEBUG', true);
include(ROOT."include/lib_base.php");


function __autoload($class){
	if(strtolower(substr($class, -5)) == 'model'){
		require(ROOT."Model/".$class.".class.php");
	}else if(strtolower(substr($class, -4)) == 'tool'){
		require(ROOT."Tool/".$class.".class.php");
	}else{
		require(ROOT."include/".$class.".class.php");
	}
}


//如果定义了DEBUG,则把报错等级调到最高
if(defined('DEBUG')){
	error_reporting(E_ALL);
}else{
	error_reporting(0);
}
?>