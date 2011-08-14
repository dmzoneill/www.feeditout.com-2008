<?php

$site_url = "http://".$_SERVER['HTTP_HOST'];
$breaker = "<font style='font-size:10pt; color:#999999; margin-left:6px;margin-right:6px;'>|</font>";
$sitemenu = "&nbsp;&nbsp;&nbsp;<a href=\"$site_url/code/\">Code / Projects</a> $breaker 
	<!--- <a href=\"$site_url/texts/\">Short Documents</a> $breaker // -->
	<a href=\"$site_url/books/\">Books</a> $breaker 
	<!--- <a href=\"$site_url/serials/\">Serials</a> $breaker  // -->
	<!--- <a href=\"$site_url/music/\">Music</a> $breaker  // -->
	<a href=\"$site_url/video/\">Documentaries</a> $breaker 
	<!--- <a href=\"$site_url/photos/\">Photos</a> $breaker  // -->
	<a href=\"$site_url/wallpaper/\">Desktop Wallpaper</a>  
	<!--- $breaker <a href=\"$site_url/stuff/\">File Hosting</a> $breaker  // -->
	<!--- <a href=\"$site_url/email/\">Email</a> $breaker // -->
	<!--- <a href=\"$site_url/contact.php\">Contact</a> // -->";

if($_COOKIE["feeditoutCookie"])
{
	$username = explode(":",$_COOKIE["feeditoutCookie"]);
	$username = $username[0];
	$sitemenu .= " $breaker <a href=\"$_POST[requestUrl]?logout=true\">Logout $username</a>";
}

$t_header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Feeditout</title>
<link rel="stylesheet" href="http://dev.feeditout.com/style.css" type="text/css" />

<!--[if IE]>
	<style type="text/css">
	.hide
		{
			position:absolute;
			left:40px;
			filter:alpha(opacity=0);
			opacity: 0;
			z-index: 2;
			width:0px;
			border-width:0px;
		}
	</style>
<![endif]-->
<script type="text/javascript" src="http://dev.feeditout.com/music/mp3player/swfobject.js"></script>
<script type="text/javascript" src="http://dev.feeditout.com/js/ajax.js"></script>
<script type="text/javascript" src="http://dev.feeditout.com/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://dev.feeditout.com/video/flowplayer/flowplayer-3.1.3.min.js"></script>
<script type="text/javascript" src="http://dev.feeditout.com/video/flowplayer/swfobject.js"></script>
<script type="text/javascript" src="http://dev.feeditout.com/music/mp3player/ep_player.js"></script>
<script src="http://dev.feeditout.com/video/flowplayer/jquery.mousewheel.js"></script>
<script src="http://dev.feeditout.com/video/flowplayer/playlist.js"></script>
<script src="http://dev.feeditout.com/video/flowplayer/scrollable.js"></script>
';

if($security_overide!="true")
{
	include($site_root."/auth.php");
}

ob_start('ob_gzhandler');


print $t_header;


?>
