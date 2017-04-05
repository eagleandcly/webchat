<?php
defined('ACC') || exit("ACC deny");
/**
* 用于存储网站运行日志
* write()用于输入日志内容
* bak()通过对文件进行重命名的方式达到备份效果
* isBak()判断日志是否需要备份
*/
class Log
{
	const LOGFILE='curr.log';   //创建一个用于存放日志名称的常量

	public static function write($cont,$pre=''){
		$cont.="\r\n";
		$log=self::isBak($pre); //判断日志是否需要备份

		//文件操作
		$fh=fopen($log,'ab');
		fwrite($fh,$cont);
		fclose($fh);
	}

	public static function bak(){
		$log=ROOT.'data/log/'.$pre.'_'.self::LOGFILE;
		$bak=ROOT.'data/log/'.$pre.'_'.date('ymd').
			mt_rand(10000,99999).'.bak';
		return rename($log, $bak);                   
	}

	public static function isBak($pre){
		$log=ROOT.'data/log/'.$pre.'_'.self::LOGFILE;

		//判断文件是否存在，如果不存在则创建文件。
		if(!file_exists($log)){
			touch($log);
			return $log;
		}

		//判断文件大小
		clearstatcache(true,$log);
		$size=filesize($log);
		if($size <= 1024*1024){
			return $log;
		}

		//判断文件是否需要备份
		if(!self::bak($pre)){
			return $log;
		}else{
			touch($log);
			return $log;
		}

	}
}
?>