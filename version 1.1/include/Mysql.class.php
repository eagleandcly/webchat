<?php
defined('ACC') || exit("ACC deny");
/**
* 使用Mysqli类连接数据库
* 采用单例模式来调用Mysql类
* 通过构造函数初始化连接数据库和设置字符集
* connect()连接数据库
* setChar()设置字符集
* query()执行sql语句
* getAll()取所有的数据
* getRow()取一行的数据
* getOne()取一个数据
* autoExecute()增改数据
*/
class Mysql extends Db
{
	private static $ins=null;
	private $conn=null;
	private $conf=array();

	
	function __construct()
	{ 
		$this->conf=Conf::getIns(); //获取数据库的配置信息
		$this->connect($this->conf->host,$this->conf->user,
			$this->conf->pwd,$this->conf->db);  //连接数据库
		$this->setChar($this->conf->char);	//设置数据库的字符集
	}

	//单例模式
	public static function getIns(){
		if(self::$ins==null){
			self::$ins=new self();
		}

		return self::$ins;
	}

	//连接数据库
	public function connect($h,$u,$p,$d){
		$this->conn=mysqli_connect($h,$u,$p,$d);
		if(!$this->conn){
			$err=new Exception("连接数据库出错，错误是：".mysqli_connect_error(),101);
			throw $err;
		}
	}

	//设置字符集
	private function setChar($c){
		$sql="set names ".$c;
		$this->query($sql);
	}

	//查询
	public function query($sql){
		$rs=mysqli_query($this->conn,$sql);
		$sql="[ Mysql ".date("Y-m-d H:i:s")."] ".$sql;
		Log::write($sql,'mysql');
		return $rs;
	}

	//取所有数据
	public function getAll($sql){
		$list=array();

		$rs=$this->query($sql);
		if(!$rs){
			return false;
		}

		while ($row=mysqli_fetch_array($rs)){
			$list[]=$row;
		}
		mysqli_free_result($rs);
		return $list;
	}
	//取单行数据
	public function getRow($sql){
		$rs=$this->query($sql);
		if(!$rs){
			return false;
		}

		$row=mysqli_fetch_array($rs);
		mysqli_free_result($rs);
		return $row;
	}

	//取单个数据
	public function getOne($sql){
		$rs=$this->query($sql);
		if(!$rs){
			return false;
		}

		$row=mysqli_fetch_array($rs);
		mysqli_free_result($rs);
		return $row[0];
	}
	/**
	*设置list数组来存放取出的结果
	*用$rs来存放取出的数据的指针
	*通过$row介质将数据存放在$list里，返回$list
	 */
	public function autoExecute($table,$data,
		$act='insert',$where=''){
		if(!is_array($data)){
			return false;
		}
		$sql='';
		if($act == 'update'){
			$sql=$act.' '.$table." set ";
			foreach ($data as $k => $v) {
				$sql.=$k.'=\''.$v.'\',';
			}
			$sql=rtrim($sql,',');
			$sql.=' where '.$where;
		}else{
			$sql=$act.' into '.$table.'(';
			$sql.=implode(',',array_keys($data)).") values('";
			$sql.=implode('\',\'',$data)."')";
		}
		return $this->query($sql);

	}
	//返回上次操作中有影响的列数
	public function affected_rows(){
		return mysqli_affected_rows($this->conn);
	}

	//返回自增长的列
	public function insert_id(){
		return mysqli_insert_id($this->conn);
	}

}
?>