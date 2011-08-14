<?php
require_once("../conf.php");

include("../site_header.php");

?>
<script type="text/javascript">
changetitle('Training');
</script>
<style>
/* these two settings will remove borders from playlist entries */
a:active {  outline:none; }
:focus   { -moz-outline-style:none; }


/* container has a background image */
a.trainingplayer {	
	margin-top:40px;
	display:block;
	width:650px;
	height:498px;
	padding:0 126px 75px 127px;	
	text-align:center;
	color:#fff;
	text-decoration:none;
	cursor:pointer;
}

/* splash image */
a.trainingplayer img {
	margin-top:115px;
	border:0;	
}



/*{{{ general playlist settings, light gray */
div.playlist {

	position:relative;
	overflow:hidden;	 	
	height:505px !important;
}

div.playlist div.clips {	
	position:absolute;
	height:20000em;
}

div.playlist, div.clips {
	width:260px;	
}

div.clips a {
	background:url(http://dev.feeditout.com/video/flowplayer/h80.png);
	display:block;
	background-color:#fefeff;
	padding:12px 15px;
	height:46px;
	width:195px;
	font-size:12px;
	border:1px outset #ccc;		
	text-decoration:none;
	letter-spacing:-1px;
	color:#000;
}

div.clips a.first {
	border-top-width:1px;
}

div.clips a.playing, div.clips a.paused, div.clips a.progress {
	background:url(http://dev.feeditout.com/video/flowplayer/light.png) no-repeat 0px -69px;
	width:225px;
	border:0;
}
	
div.clips a.progress {
	opacity:0.6;		
}

div.clips a.paused {
	background-position:0 0;	
}

div.clips a span {
	display:block;		
	font-size:11px;
	color:#666;
}

div.clips a em {
	font-style:normal;
	color:#f00;
}	

div.clips a:hover {
	background-color:#f9f9fa;		
}

div.clips a.playing:hover, div.clips a.paused:hover, div.clips a.progress:hover {
	background-color:transparent !important;		 
}
/*}}}*/


/*{{{ petrol colored */

div.clips.petrol a {
	background-color:#193947;
	color:#fff;
	border:1px outset #193947;
}

div.clips.petrol a.playing, div.clips.petrol a.paused, div.clips.petrol a.progress {
	background:url(http://dev.feeditout.com/video/flowplayer/dark.png) no-repeat 0px -69px;
	border:0;
}

div.clips.petrol a.paused {
	background-position:0 0;	
}

div.clips.petrol a span {
	color:#aaa;
}

div.clips.petrol a em {
	color:#FCA29A;
	font-weight:bold;
}	

div.clips.petrol a:hover {
	background-color:#274D58;		
} 

div.clips.petrol a.playing:hover, div.clips.petrol a.paused:hover, div.clips.petrol a.progress:hover {
	background-color:transparent !important;		 
}
/*}}}*/


/*{{{ low version */

div.clips.low a {	
	height:31px;
}

div.clips.low a.playing, div.clips.low a.paused, div.clips.low a.progress {
	background-image:url(http://dev.feeditout.com/video/flowplayer/light_small.png);
	background-position:0 -55px;
}

div.clips.low a.paused {
	background-position:0 0;	
}


/*}}}*/


/*{{{ go buttons */

a.go {
	display:block;
	width:18px;
	height:18px;
	background:url(http://dev.feeditout.com/video/flowplayer/gup.png) no-repeat;
	margin:5px 0 5px 105px;
	cursor:pointer;
}

a.go:hover, a.go.down:hover {
	background-position:0px -18px;		
}

a.go.down {
	background-image:url(http://dev.feeditout.com/video/flowplayer/gdown.png);	
}

div.petrol a.go {
	background-image:url(http://dev.feeditout.com/video/flowplayer/gup.png);		
}

div.petrol a.go.down {
	background-image:url(http://dev.feeditout.com/video/flowplayer/gdown.png);		
}

a.go.disabled {
	visibility:hidden;		
}

/*}}}*/




</style>
</head>
<body>

<?php
	print "<fieldset><legend id='trainingVideoHeader'><img src='http://dev.feeditout.com/image.php?text=Training Videos' class='imghead' alt='title' /><br>$sitemenu</legend><hr id='headerHr' style='color: #666;background-color: #666;height: 1px;border: 0;'>\n";
?>

<script>

$(function() {
	// setup scrolling for the playlist elements
	$("div.playlist").scrollable({
		items:'div.clips',
		vertical:true,
		next:'a.down',
		prev:'a.up'
	});
	
	// setup player 
	$f("trainingplayer", "http://dev.feeditout.com/video/flowplayer/flowplayer-3.1.3.swf", {}).playlist("div.clips",{ loop:true,playOnClick: true });		
});


</script>

<div style="float:left;width:190px">
	
	<a class="go up"></a>
	
	<div class="playlist">	
		
		<div class="clips petrol">

				
<?php

if ($handle = opendir('./vids')) 
{
	/* This is the correct way to loop over the directory. */
	while (false !== ($file = readdir($handle))) 
	{
		if($file=="." || $file=="..")
		{
			continue;
		}
		$filen = explode(".",$file);
		echo "<a href=\"http://dev.feeditout.com/training/vids/$file\">$filen[0]</a>";
	}
	closedir($handle);
}
?>
		</div>

		 
	</div>
	
	<a class="go down"></a>
	
</div>
	

<a id="trainingplayer" class="trainingplayer " style="float:left;margin-top:25px">
	<img src="http://dev.feeditout.com/video/flowplayer/play.png" />
</a>

<br clear="all" />





<?php

	print "</fieldset>";

	include("../site_footer.php");
?>



