<?php

$security_overide = true;

require_once("../conf.php");


if($_GET['changeViewStatus'])
{
	$user = explode(":",$_COOKIE["feeditoutCookie"]);
	$user = $user[0];
	$video = mysql_real_escape_string($_GET['changeViewStatus']);
	$stream->do_query("delete from logs_videos_watched where user='$user' and video='$video'","one");
	print " ";
	exit;

}

if($_GET['url'])
{
	shell_exec("/usr/bin/php /home/dave/www/video/google.php \"".$_GET['url']."\""); 
	
	exit;
}

if($_GET['file'])
{
	print shell_exec("/usr/bin/php /home/dave/www/video/google.php \"".$_GET['file']."\" name"); 
	
	exit;
}


if($_GET['filesize'])
{
	
	print filesize($_GET['filesize']);

	exit;
}


if($_GET['getMovie'])
{
	$file = $_GET['getMovie'];
	$pp = explode(".",$file);
	$ext = strtolower($pp[count($pp) -1]);

	if($ext!="flv")
		$movie = avifilm("video/".$file);
	else 
		$movie = flvfilm("video/".$file);

	print $movie;
	
	exit;

}


if($_GET['getMovieInfo'])
{
	$file = $_GET['getMovieInfo'];
	if(!file_exists("./video/".$file)){
		print "Unknown Video";
		exit;
	}
	$pp = explode(".",$file);
	$ext = strtolower($pp[count($pp) -1]);
	$name = ereg_replace("[^A-Za-z0-9]", " ", $file );
	$name = substr($name,0,(strlen($name)-3));
	$name = preg_replace("/\d{19}/","",$name);
	$name = preg_replace("/\d{18}/","",$name);
	$name = preg_replace("/\d{20}/","",$name);
	$name = preg_replace("/\d{17}/","",$name);	
	$e_name = $name;

	if(count(@$stream->do_query("select * from logs_videos where video='$name'","array"))>0){
		$hits = @$stream->do_query("select hits from logs_videos where video='$name'","one") +1;
		@$stream->do_query("update logs_videos set hits='$hits' where video='$name'","one");
	}
	else {
		@$stream->do_query("insert into logs_videos values('','$name','1')","one");
	}

	$hname =$stream->do_query("select video from logs_videos where video='$name'","one");
	$hits =$stream->do_query("select hits from logs_videos where video='$name'","one");

	$link = "<a href='./video/$file'>Download</a> \n";
	//$name = "<font style='font-size:12pt; font-weight:bold;'>".$name."</font><br><br>\n";
	$name = "<br><br><img src='http://dev.feeditout.com/letter-image.php?text=$name&size=400x20' class='imghead' alt='$name'><br><br>";
	// <img src='http://dev.feeditout.com/letter-image.php?text=$first' class='imghead' alt='$first'>
	$images = showthumbs($file);	

	$e_url = rawurlencode("http://dev.feeditout.com/video/index.php?video=$file");
	$e_name = rawurlencode("$e_name");

	$digg = "<br>
	<a href=\"http://digg.com/submit?url=$e_url&title=$e_name&bodytext=$e_name&media=video&topic=political_opinion\" target=\"_blank\">
	<img src=\"flowplayer/little-digg.gif\" class=\"imghead\" alt=\"\" width=\"20\" height=\"20\" align='top'>
	<span>Digg</span>
	</a>
	";

	$vidlink = "<a href=\"javascript:linktovid('$file');\">Link To</a>";

	print $name . $images . "<br>Viewed ".$hits." times<br>";
	print "$digg | $vidlink | $link\n <br><br>";	
	
	$style = "<img src='http://dev.feeditout.com/images/star.png' width=12 height=12 style=\"opacity:0.4;filter:alpha(opacity=40)\" onmouseover=\"this.style.opacity=1;this.filters.alpha.opacity=100\" onmouseout=\"this.style.opacity=0.4;this.filters.alpha.opacity=40\" class='imghead'>";

	print "<div id='votingbox'>Vote : ";

	for($m=1;$m<6;$m++)
	{
		print "<a href=\"javascript:vote('$hname','$m')\">$style</a>";
	}
	
	print "</div><br><a href=\"javascript:playerView();\">Player View</a> | <a href='javascript:hideVideo();'>Close Preview</a><br>";
	
	$user = explode(":",$_COOKIE["feeditoutCookie"]);
	$user = $user[0];
	$watched = $stream->do_query("select * from logs_videos_watched where user='$user' and video='$file'","array");
	if(count($watched)>0)
	{
		// all reayd there
	}
	else
	{
		$watched = $stream->do_query("insert into logs_videos_watched values('','$user','$file')","one");
	}

	exit;
}


if($_GET['showList'])
{	
	print filmListing();
	exit;
}


if($_GET['vote'])
{

	if(count(@$stream->do_query("select * from videos where video='".$_GET['votename']."'","array"))>0){
		$total = @$stream->do_query("select total from videos where video='".$_GET['votename']."'","one") + $_GET['vote'];
		$votes = @$stream->do_query("select votes from videos where video='".$_GET['votename']."'","one") +1;
		@$stream->do_query("update videos set votes='$votes', total='$total' where video='".$_GET['votename']."'","one");
	}
	else {
		@$stream->do_query("insert into videos values('','$_GET[votename]','$_GET[vote]','1')","one");
	}
	print $_GET['vote'];
	exit;
}


include("../site_header.php");

?>

<script type="text/javascript">
changetitle('Documentaries');

<?php

if($_GET['video'])
{
	$video = rawurldecode($_GET['video']);
	print "function init() {\n
		getFilm('$video','');\n
		}\n
		window.onload = init; \n\n";
}

?>

</script>
</head>
<body>
<?php
	print "<a name='watchVideo'></a>";
	print "<fieldset><legend id='videoHeader'><img src='http://dev.feeditout.com/image.php?text=Documentaries' class='imghead' alt='title' /><br>$sitemenu</legend><hr id='headerHr' style='color: #666;background-color: #666;height: 1px;border: 0;'>\n";
	print "<table cellpadding=10 border=0 width='100%'><tr><td valign='top' width='50%' align='center'>\n";
	print "<div id='movie'></div>\n";
	print "</td><td valign='top' width='50%' align='center'>\n";
	print "<div id='movieinfo' align='center'></div>";	
	print "</td></tr><table>";

	print "<center><div id='speech' style='display:none;'></div></center>";

	print "<center><div id='linktothisvid'></div><div id='searchBox' align='left' style='margin-left:60px;'>";
	print "<img src='http://dev.feeditout.com/letter-image.php?text=S e a r c h&size=90x20' class='imghead' alt='Search'><br><input type='text' id='hterm' onKeyUp=\"highLightSearch(this.value);\" onclick=\"this.value='';highLightSearch(this.value);\" style='margin-top:5px;width:400px' value='Search'> &nbsp;&nbsp; <b id='vidMatches'></b> &nbsp;&nbsp; <b class='searchOpt'> &nbsp;&nbsp; >40 </b> >40 mb &nbsp;&nbsp; <b class='searchOpt'> &nbsp;&nbsp; <60 </b> <60mb &nbsp;&nbsp; <b class='searchOpt'> &nbsp;&nbsp; *3 </b> 3 stars &nbsp;&nbsp; <b class='searchOpt'> &nbsp;&nbsp; ? </b> omit unmatched<br></div></center>";

	print "<div id='videoListContainer'>".filmListing()."</div>";	

	print "</fieldset>\n\n<br><input type='hidden' id='totalVideos' value='$numVideos'>\n\n<br>";
	include("../site_footer.php");
?>
