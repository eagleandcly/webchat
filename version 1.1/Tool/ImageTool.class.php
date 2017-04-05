<?php
defined('ACC') || exit("ACC deny");
class ImageTool{
	//imageinfo分析图片信息
	protected static function imageInfo($image){
		$img=array(); //存放图片信息
		if(!file_exists($image)){
			return false;
		}
		$info=getimagesize($image);
		if($info == false){
			return false;
		}

		$img['width']=$info[0];
		$img['height']=$info[1];
		$img['ext']=substr($info['mime'],strpos($info['mime'],'/')+1);

		return $img;
	}

	public static function water($dst,$water,$save=NULL,$alpha=50,$pos=0){
		$dinfo=self::imageInfo($dst);
		$winfo=self::imageInfo($water);
		//判断读取信息是否成功
		if($dinfo == false || $winfo == false){
			return false;
		}
		//判断水印的大小是否超过目标图
		if($winfo['width'] > $dinfo['width'] || $winfo['height'] > $dinfo['height']){
			return false;
		}

		//创建图
		$dfunc='imagecreatefrom'.$dinfo['ext'];
		$wfunc='imagecreatefrom'.$winfo['ext'];

		if(!function_exists($dfunc) || !function_exists($wfunc)){
			return false;
		}		

		$dim=$dfunc($dst);
		$wim=$wfunc($water);

		//加水印
		switch ($pos) {
			case 0:
				$pos_x=0;
				$pos_y=0;
				break;
			case 1:
				$pos_x=$dinfo['width']-$winfo['width'];
				$pos_y=0;
				break;
			case 2:
				$pos_x=0;
				$pos_y=$dinfo['height']-$winfo['height'];
				break;
			case 3:
				$pos_x=$dinfo['width']-$winfo['width'];
				$pos_y=$dinfo['height']-$winfo['height'];
				break;
			default:
				return false;
				break;
		}
		imagecopymerge($dim, $wim, $pos_x, $pos_y, 0, 0, $winfo['width'], $winfo['height'], $alpha);

		//保存图片
		if(!$save){
			$save=$dst;
			unlink($dst);
		}

		$createfunc= 'image'.$dinfo['ext'];
		$createfunc($dim,$save);

		//销毁
		imagedestroy($dim);
		imagedestroy($wim);

		return true;
	}

	public static function thumb($dst,$save=NULL,$width=200,$height=200){
		$dinfo=self::imageInfo($dst);

		if($dinfo == false){
			return false;
		}

		$calc=min($width/$dinfo['width'],$height/$dinfo['height']); //取缩列图和原图的比例

		//创建原始图
		$dfunc='imagecreatefrom'.$dinfo['ext'];
		$dim=$dfunc($dst);
		//创建缩略图画布
		$tim=imagecreatetruecolor($width,$height);

		//填充白色
		$white=imagecolorallocate($tim,255,255,255);
		imagefill($tim,0,0,$white);

		//数据处理
		$twidth=(int)$dinfo['width']*$calc;
		$theight=(int)$dinfo['height']*$calc;

		$paddingx=(int)($width-$twidth)/2;
		$paddingy=(int)($height-$theight)/2;

		//创建缩略图
		imagecopyresampled($tim, $dim, $paddingx,$paddingy, 0, 0, $twidth, $theight, $dinfo['width'], $dinfo['height']);
		
		//保存图片
		if(!$save){
			$save=$dst;
			unlink($dst);
		}

		
		$createfunc='image'.$dinfo['ext'];
		$createfunc($tim,$save);

		//销毁
		imagedestroy($tim);
		imagedestroy($dim);

		return true;
	}

	//验证码
	public static function captcha($width=50,$height=25){
		$im=imagecreate($width,$height);
		//背景颜料
		$bgcolor=imagecolorallocate($im,200,200,200);
		//填充背景
		imagefill($im,0,0,$bgcolor);

		//字体随机颜料
		$strcolor=imagecolorallocate($im,mt_rand(0,125),mt_rand(0,125),mt_rand(0,125));
		//在画布上写字
		$sub_str='abcdefghijklmnopqrstuvwxyz2345689';
		$str=substr(str_shuffle($sub_str),0,4);
		imagestring($im,5,7,5,$str,$strcolor);
		//扭曲验证码
		$im=self::code($width,$height,$im);

		//随机线颜料
		$randcolor1=imagecolorallocate($im,mt_rand(100,125),mt_rand(100,125),mt_rand(100,125));
		$randcolor2=imagecolorallocate($im,mt_rand(100,125),mt_rand(100,125),mt_rand(100,125));
		$randcolor3=imagecolorallocate($im,mt_rand(100,125),mt_rand(100,125),mt_rand(100,125));
		//在画布上画线
		imageline($im,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),
			$randcolor1);
		imageline($im,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),
			$randcolor2);
		imageline($im,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),
			$randcolor3);


		//显示、销毁
		header("Content-type:image/gif");
		imagegif($im);
		imagedestroy($im);
		return $str;
	}

	//扭曲验证码
	static private function code($width,$height,$src){
		//创建目标画布
		$dst=imagecreatetruecolor(65,25);
		$dgray=imagecolorallocate($dst,200,200,200);

		//填充画布
		// imagefill($src,0,0,$sgray);
		imagefill($dst,0,0,$dgray);

		//扭曲验证码
		for ($i=0; $i <60 ; $i++) { 
			$offset=3; //设置波动最大像素数为3
			$round=2;   //设置周期为2
			$pos_y=round(sin($i*$round*2*M_PI/60)*$offset);
			imagecopy($dst,$src,$i,$pos_y,$i,0,65,25);
		}
		return $dst;

		imagedestory($dst);
}
}
?>