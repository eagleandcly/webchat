<?php
/**
 * 对特殊字符进行转义，从而插入到数据库中。
 * @param  Array $arr 	需要转义的数组
 * @return Array      返回转义后的数组
 */
function _addslashes($arr){
	foreach ($arr as $k => $v) {
		if(is_string($v)){
			$arr[$k]=addslashes($v);
		}else if(is_array($v)){
			$arr[$k]=_addslashes($v);
		}
	}

	return $arr;
}

function redirect($url, $time=0, $msg='') {  
    //多行URL地址支持  
    $url = str_replace(array("\n", "\r"), '', $url);  
    if ( empty($msg) )  
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";  
    if (!headers_sent()) {  
        // redirect  
        if (0 === $time) {  
            header('Location: ' . $url);  
        } else {  
            header("refresh:{$time};url={$url}");  
            echo($msg);  
        }  
        exit();  
    } else {  
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";  
        if ($time != 0)  
            $str .= $msg;  
        exit($str);  
    }  
}   
?>