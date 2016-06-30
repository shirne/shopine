<?php
class Captcha {
	protected $code;
	protected $width;
	protected $height;

	public $noisep=80;
	public $noisel=5;

	public $font="tahomabd.ttf";

	function __construct($len=6,$w=150,$h=32) {
		$this->width=$w;
		$this->height=$h; 
		$this->code = substr(sha1(mt_rand()), 17, $len); 
	}

	function getCode(){
		return $this->code;
	}

	function showImage($type='One'){
		$type='show'.$type;
		$this->$type();
	}

	function showOne(){
		$l = strlen($this->code);
		$w=$this->width;
		$h=$this->height;
		$w= max($h * $l,$w);
		$fscale=.5;
		$fsize=$h*$fscale;
		

		//创建图片，定义颜色值
		Header("Content-type: image/PNG");
		$im = imagecreatetruecolor($w, $h);


		//每个字一种颜色
		for($i=0;$i<$l;$i++){
			$black[$i] = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
		}
		//$gray = imagecolorallocate($im, 118, 151, 199);
		$bgcolor = imagecolorallocate($im, 235, 236, 237);

		//画背景
		imagefilledrectangle($im, 0, 0, $w, $h, $bgcolor);
		//画边框
		//imagerectangle($im, 0, 0, $w-1, $h-1, $gray);

		//在画布上随机生成大量点，起干扰作用;
		for ($i = 0; $i < $this->noisep; $i++) {
			imagesetpixel($im, rand(0, $w), rand(0, $h), $black[rand(0,$l-1)]);
		}

		//在画布上随机生成干扰线;
		for ($i = 0; $i < $this->noisel; $i++) {
			imageline($im, rand(0, $w*.5), rand(0, $h),rand($w*.5, $w), rand(0, $h), $black[rand(0,$l-1)]);
		}

		//将字符随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成
		for ($i = 0; $i < $l; $i++) {
			$xpos[$i]=rand($fsize, $h);
		}
		$strx = ($w-array_sum($xpos))*.5;
		for ($i = 0; $i < $l; $i++) {
			$strpos = rand(1, $h*(1-$fscale)-1)+$fsize;
			imagettftext($im, $fsize, rand(-20,20), $strx + rand(0, $xpos[$i]-$fsize), $strpos, $black[$i], dirname(__FILE__).'/'.$this->font, substr($this->code, $i, 1));
			$strx +=  $xpos[$i];
		}
		imagepng($im);
		imagedestroy($im);
	}

	function showTwo() {
        $image = imagecreatetruecolor($this->width, $this->height);

        $width = imagesx($image); 
        $height = imagesy($image);
		
        $black = imagecolorallocate($image, 0, 0, 0); 
        $white = imagecolorallocate($image, 255, 255, 255); 
        $red = imagecolorallocatealpha($image, 255, 0, 0, 75); 
        $green = imagecolorallocatealpha($image, 0, 255, 0, 75); 
        $blue = imagecolorallocatealpha($image, 0, 0, 255, 75); 
         
        imagefilledrectangle($image, 0, 0, $width, $height, $white); 
         
        imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $red); 
        imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $green); 
        imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $blue); 

        imagefilledrectangle($image, 0, 0, $width, 0, $black); 
        imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $black); 
        imagefilledrectangle($image, 0, 0, 0, $height - 1, $black); 
        imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $black); 
         
        imagestring($image, 10, intval(($width - (strlen($this->code) * 9)) / 2),  intval(($height - 15) / 2), $this->code, $black);
	
		header('Content-type: image/jpeg');
		
		imagejpeg($image);
		
		imagedestroy($image);		
	}
}
?>