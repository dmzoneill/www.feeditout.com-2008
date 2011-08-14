<?php


 $dh = @opendir( "./video" );
   while( false !== ( $file = readdir( $dh ) ) ){
		$files[] = $file;
	}
	closedir($dh);
	sort($files);
	reset($files);

	foreach($files as $k => $file) { 

$imgs = "";
	$thumb = $file . "_0.jpg";
	if(filesize("./video/".$file)>10000000)
		$t = 300;
	else
		$t = 3;

	if(!file_exists("thumbs/$thumb"))
	{		
		$q = 1;
		while($q<6)
		{
			$thumb = $file . "_". ($q -1) . ".jpg";
			$tnum = $q * $t;
			shell_exec("ffmpeg  -itsoffset -$tnum  -i './video/$file' -vcodec mjpeg -vframes 1 -an -f rawvideo -s 120x90 'thumbs/$thumb'");
			$q++;
		}
	}
}

?>