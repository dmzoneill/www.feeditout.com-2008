<?php
if($_GET['text']){
	$name = md5($_GET['text']) . ".png";
	$fpath = "images/dynamic3/$name";
	
	if(file_exists("$fpath")){
		header("Location: http://dev.feeditout.com/$fpath");
	}
	else
	{
		header("Content-type: image/png");
		$name = md5($_GET['text']) . ".png";
		$string = ucfirst($_GET['text']);	
		if($_GET['size'])
		{
			$dim = explode("x",$_GET['size']);
			$im = imagecreate ($dim[0], $dim[1]);
		}
		else 
		{
			$im = imagecreate (20, 20);
		}
		if($_GET['color']) 
		{
			$black = ImageColorAllocate ($im, 0, 0, 0);
		}	
		else 
		{ 
			$black = ImageColorAllocate ($im, 34, 34, 34);
		}
		if($_GET['font'])
		{
			$font = "fonts/base.ttf";
		}
		else 
		{
			$font = "fonts/street.ttf";
		}
		if($_GET['pt'])
		{
			$pt = $_GET['pt'];
			$xp1 = 4;
			$xp2 = 2;
			$yp1 = 14;
			$yp2 = 16;
		}
		else 
		{
			$pt = 14;
			$xp1 = 4;
			$xp2 = 2;
			$yp1 = 18;
			$yp2 = 18;
		}
		$white = ImageColorAllocate ($im, 255, 255, 255);
		$green = ImageColorAllocate ($im, 0, 100, 0);
		ImageTTFText($im, $pt, 0, $xp1, $yp1, $green, "$font", "$string");
		ImageTTFText($im, $pt, 0, $xp2, $yp2, $white, "$font", "$string");
		ImagePNG($im);
		
		if($_GET['pt']){
			if(!file_exists("./images/dynamic3/$name")){
				ImagePNG($im,"./images/dynamic3/$name");
			}
		}
		else 
		{
			if(!file_exists("./images/dynamic3/$name")){
				ImagePNG($im,"./images/dynamic3/$name");
			}
		}
	}	
}	
?> 