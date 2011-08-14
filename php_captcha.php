<?php
session_start();

$RandomStr = md5(microtime());// md5 to generate the random string

$ResultStr = substr($RandomStr,0,5);//trim 5 digit 

$NewImage =imagecreatefromjpeg("images/img.jpg");//image create by existing image and as back ground 

$cr = rand(150,255);
$cg = rand(150,255);
$cb = rand(150,255);
$LineColor = imagecolorallocate($NewImage,$cr,$cg,$cb);//line color 
$TextColor = imagecolorallocate($NewImage, $cr, $cg, $cb);//text color-white

imageline($NewImage,1,1,40,40,$LineColor);//create line 1 on image 
imageline($NewImage,1,100,60,0,$LineColor);//create line 2 on image 

imagestring($NewImage, 5, 8, 2, $ResultStr, $TextColor);// Draw a random string horizontally 

$_SESSION['key'] = $ResultStr;// carry the data through session

header("Content-type: image/jpeg");// out out the image 

imagejpeg($NewImage);//Output image to browser 

?>
