<?php
/**
* 数据库抽象类，为数据库编写提供标准
* connect()连接数据库
* query()数据库查询
* getAll()取所有的数据
* getRow()取单行数据
* getOne()去单个数据
* autoExecute()自动拼接插入和修改sql语句
*/
abstract class Db
{
	abstract public function connect($h,$u,$p,$d);
	abstract public function getAll($sql);
	abstract public function getRow($sql);
	abstract public function getOne($sql);
	
	/**
	* 增改功能
	*自动生成sql语句;
	*$this->auto('user',array('a'=>'1','b'=>'2'),'insert')将自动生成insert into user (a,b) values('1','2');
	*$table选择要操作的表
	*$data要插入数据库的数据
	*$act选择增还是改
	*$where条件 
	*/
	abstract public function autoExecute($table,
		$data,$act='insert',$where);
}
?>