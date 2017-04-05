<?php
class Model{
	protected $table=NULL;
	protected $pk=NULL;
	protected $db=NULL;
	
	public function __construct(){
		$this->db=Mysql::getIns();
	}

	public function table($table){
		$this->table=$table;
	}
	//增
	public function add($data){
		$rs=$this->db->autoExecute($this->table,$data);
		if($rs){
			return $rs;
		}else{
			return false;
		}
	}
	//删
	public function delete($id){
		$sql="delete from ".$this->table." where ".$this->pk."=".$id;

		if($this->db->query($sql)){
			return $this->db->affected_rows();
		}else{
			return false;
		}
	}

	//改
	public function update($data,$id){
		$rs=$this->db->autoExecute($this->table,$data,'update',$this->pk."=".$id);

		if($rs){
			return $this->db->affected_rows();
		}else{
			return false;
		}
	}

	//查
	//取全部数据
	public function select(){
		$sql="select * from ".$this->table;
		return $this->db->getAll($sql);

	}

	//取单行数据
	public function find($id){
		$sql="select * from ".$this->table." where ".$this->pk."=".$id;
		return $this->db->getRow($sql);
	}
}
?>