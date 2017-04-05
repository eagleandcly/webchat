<?php
	defined('ACC') || exit("ACC deny");
	/**
	*  配置文件读取
	*  通过单例模式调用配置文件
	*  配置魔术方法 __get和__set配置不能私有属性(private)和保护属性(protected)
	*/
	class Conf
	{
		protected static $ins=null; //用于存放自身的类
		protected $data;	//存放数据库配置
		
		final function __construct()
		{
			include(ROOT."include/config.inc.php");
			$this->data=$DATABASE;
		}

		//单例模式
		public static function getIns(){
			if(self::$ins==null){
				self::$ins=new self();
			}
			return self::$ins;
		}

		//__get方法获取配置
		public function __get($key){
			if(array_key_exists($key,$this->data)){
				return $this->data[$key];
			}else{
				return false;
			}
		}

		//__set方法设置配置
		public function __set($key,$value){
			$this->data[$key]=$value;
		}

	}
?>