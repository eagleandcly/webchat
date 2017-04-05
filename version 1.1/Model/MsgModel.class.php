<?php
/**
* 
*/
class MsgModel extends Model
{
	protected $table='msg';
	protected $pk='msg_id';

	public function getById($user_id,$ruser_id){
		$sql="select * from msg where (user_id=".$user_id.
			" and ruser_id=".$ruser_id.") or (user_id=".
			$ruser_id." and ruser_id=".$user_id.")";
		$row=$this->db->getAll($sql);
		if(empty($row)){
			return false;
		}
		//对得到的数据进行拼接处理
		$result='{"sucess":true,"msg":[';
		foreach ($row as $v) {
			if($v['user_id'] == $user_id){
				$result.='{"me":true,"msg":"'.$v['content'].'"},';				
			}else{
				$result.='{"me":false,"msg":"'.$v['content'].'"},';
			}
		}
		$result=rtrim($result,",");
		$result.=']}';				
		return $result;
	}
}
?>