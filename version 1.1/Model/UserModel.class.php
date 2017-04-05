<?php
class UserModel extends Model{
	protected $table='user';
	protected $pk='user_id';

	public function checkUser($name,$passwd=''){
		if ($passwd !='') {
			$sql="select username,password from ".$this->table.
				" where username='".$name."'";
			$row=$this->db->getRow($sql);
			if(empty($row)){
				return false;
			}
			if($row['password'] != $passwd){
				return false;
			}

			unset($row['password']);
			return $row;
		}else{
			$sql="select * from ".$this->table." where username='".$name."'";
			return $this->db->getOne($sql);			
		}

	}
	public function getByName($name){
		$sql="select * from ".$this->table.
			" where username='".$name."'";
		$row=$this->db->getRow($sql);
		if(empty($row)){
			return false;
		}

		unset($row['password']);
		unset($row[2]);
		return $row;			
	}

	public function getFriend($id){
		//取得好友信息
		$sql="select relate.*,user.username,user.is_login,user.hpot from ";
		$sql.=" relate left join ".$this->table." on relate.ruser_id=";
		$sql.="user.".$this->pk." where relate.user_id=".$id;
		$row1=$this->db->getAll($sql);
		$sql="select relate.*,user.username,user.is_login,user.hpot from ";
		$sql.=" relate left join ".$this->table." on relate.user_id=";
		$sql.="user.".$this->pk." where relate.ruser_id=".$id;
		$row2=$this->db->getAll($sql);
		foreach ($row2 as $k=>$v) {	
			$temp=$v['user_id'];
			$row2[$k]['user_id']=$v['ruser_id'];
			$row2[$k]['ruser_id']=$temp;
		}
		$row=array_merge($row1,$row2);		
		if(empty($row)){
			return false;
		}
		return $row;	
	} 
}
?>