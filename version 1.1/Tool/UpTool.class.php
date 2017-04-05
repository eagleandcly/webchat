<?php
defined('ACC') || exit("ACC deny");
class UpTool{
	protected $allowExt="jpg,jpeg,bmp,png";
	protected $maxSize=1;
	protected $errono=0; 	//错误代码
	protected $error=array(
		1=>'上传文件大小超过服务器允许上传的最大值',
		2=>'上传文件大小超过HTML表单中隐藏域MAX_FILE_SIZE选项指定的值',
		3=>'文件只有部分被上传', 
		4=>'没有文件被上传',
		5=>'文件后缀名获取失败',
		6=>'没有找不到临时文件夹',
		7=>'文件写入失败',
		8=>'php文件上传扩展没有打开',
		9=>'文件扩展名出错',
		10=>'文件大小超出最大值',
		11=>'创建目录不成功',
		12=>'创建文件名不成功',
		13=>'文件移动失败'
		);	//错误代码对应的文字信息
	public function getError(){
		return $this->error[$this->errono];
	}
	//上传文件
	public function up($key){
		$file=$_FILES[$key];
		
		//判断上传是否出错
		if($file['error']){
			return $file[error];
		}

		//判断后缀名
		if (!$ext=$this->getExt($file['name'])) {
			$this->errono=5;
			return false;
		}
		if (!$this->isAllowExt($ext)) {
			$this->errono=9;
			return false;
		}
		//判断大小
		if(!$this->isAllowSize($file['size'])){
			$this->errono=10;
			return false;
		}

		if(!$dir=$this->mk_dir()){
			$this->errono=11;
			return false;
		}

		if(!$newName=$this->randName().".".$ext){
			$this->errono=12;
			return false;
		}

		$dir.="/".$newName;

		if(!move_uploaded_file($file['tmp_name'],$dir)){
			$this->errono=13;
			return false;
		}
		$dir=str_replace(ROOT,"", $dir);
		return $dir;

	}
	//set方法
	public function setExt($ext){
		$this->allowExt=$ext;
	}
	public function setSize($size){
		$this->maxSize=$size;
	}
	//获取后缀名
	public function getExt($file){
		$tmp=explode(".",$file);
		return end($tmp);
	}
	public function isAllowExt($ext){
		$arr=explode(",",strtolower($this->allowExt));
		return in_array(strtolower($ext),$arr);
	}

	//判断文件大小
	public function isAllowSize($size){
		return $size <=$this->maxSize*1024*1024;
	}
	//随机文件名
	public function randName($length=6){
		$str="asdfghjklzxcvbnmqwertyuiop1234567890";
		return substr(str_shuffle($str),0,$length);
	}
	//创建目录
	public function mk_dir(){
		$dir=ROOT."data/image/".date("Ym/d",time());
		if(is_dir($dir) || mkdir($dir,0777,true)){
			return $dir;
		}else{
			return false;
		}
	}

}
?>