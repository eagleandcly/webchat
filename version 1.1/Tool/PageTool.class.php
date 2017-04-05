<?php
// class PageTool{
// 	protected $total=0;
// 	protected $perpage=10;
// 	protected $page=0;

// 	public function __construct($total,$perpage=null,$page=null){
// 		$this->total=$total;
// 		if($perpage){
// 			$this->perpage=$perpage;
// 		}
// 		if($page){
// 			$this->page=$page;
// 		}
// 	}

// 	public function show(){
// 		$cnt=ceil($this->total/$this->perpage); //计算总页数
// 		$uri=$_SERVER['REQUEST_URI']; //获取地址

// 		$parse=parse_url($uri); //获取地址信息，并转化为数组
// 		$param=array(); 
// 		if(isset($parse['query'])){
// 			parse_str($parse['query'],$param); //将通过GET方式传递的参数转化为关联数组
// 		}

// 		unset($param['page']); //去掉传递参数中的page
// 		//重新拼接地址
// 		$url=$parse['path']."?";
// 		if(!empty($param)){
// 			$url.=http_build_query($param);
// 			$url.="&";
// 		}
// 		//开始创建分页效果
// 		$nav[]='<span class="page_now">'.$this->page.'</span>';
// 		for($left=$this->page-1,$right=$this->page+1;($left >=1 || $right <=$cnt )&&count($nav)<5;){
// 			if($left > 0){
// 				array_unshift($nav, '<a href="'.$url.'page='
// 					.$left.'">['.$left.']</a>');
// 				$left-=1;
// 			}
// 			if($right <=$cnt){
// 				array_push($nav, '<a href="'.$url.'page='
// 					.$right.'">['.$right.']</a>');
// 				$right+=1;
// 			}
// 		}

// 		return implode("", $nav);

// 	}
// }
defined('ACC') || exit("ACC deny");
class PageTool{
	protected $total=0;
	protected $perpage=10;
	protected $page=0;

	public function __construct($total,$page=false,$perpage=false){
        $this->total=$total;
        if($perpage){
        	$this->perpage=$perpage;
        }   
        if($page){
        	$this->page=$page;
        } 
	}

	public function show(){
		$cnt=ceil($this->total/$this->perpage);

		$uri=$_SERVER['REQUEST_URI'];

		$parse=parse_url($uri);
		$param=array();
		if(isset($parse['query'])){
			parse_str($parse['query'],$param);
		}

		unset($param['page']);
		$url=$parse['path']."?";
		if(!empty($param)){
			$url.= http_build_query($param);
			$url.="&";
		}
		$nav[]='<span class="page_now" >'.$this->page.'</span>';
		for ($left=$this->page-1,$right=$this->page+1;($left>=1||$right<=$cnt) && count($nav)< 5;) { 
			if($left>0){
				array_unshift($nav, '<a href="'.$url.'page='.$left.'">['.$left.']</a>');
				$left -= 1;
			}
			if($right<=$cnt){
				array_push($nav, '<a href="'.$url.'page='.$right.'">['.$right.']</a>');
				$right += 1;
			}
		}

		return implode('',$nav);

	}

}
?>