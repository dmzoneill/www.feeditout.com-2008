<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="flowplayer-3.2.4.min.js"></script>

	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Justice: A Citizens Guide to the 21st Century</title>

</head><body>

	<div id="page">
		
		<h1>Justice: A Citizens Guide to the 21st Century</h1>
	
		<p>You will need flash to view this video</p>
		
		<a  
			 href="justice.m4v"  
			 style="display:block;width:700px;height:430px"  
			 id="player"> 
		</a> 
	
		<script>
			flowplayer("player", "./flowplayer-3.2.5.swf");
		</script>
		
		<br>
		
		<h1>Download</h1>

		<p>
			Download DRM Free : <a href="justice.m4v">save to disk</a>
		</p>
		
				
		<h1>Issues</h1>
		
		<p>
			Slow download speed, buffering?<br>
            Shared host and is only good for about 8 megs a second, <br>
            roughly about 20 users, but dependant on other traffic on the server.
		</p>
		
	</div>
	
	
</body></html>

<?php

$fp = fopen("hitcounter.txt", "r"); 
$count = fread($fp, 1024); 
fclose($fp); 
$count = $count + 1; 
$fp = fopen("hitcounter.txt", "w"); 
fwrite($fp, $count); 
fclose( $fp );

?>
