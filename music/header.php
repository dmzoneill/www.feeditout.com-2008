<?php
include("../site_header.php");
?>
<script type="text/javascript">
changetitle('Music');
</script>
</head>
<body>
<?php



	print "<fieldset>";
	print "<legend id='contentname' class='legendshown'><img src='http://dev.feeditout.com/image.php?text=Albums' class='imghead' alt='album name' /></legend><div id=\"headeralbum\" class=\"shown\">$sitemenu<br><br><hr style='color: #666;background-color: #666;height: 1px;border: 0;'><br /></div><table cellpadding='5' border='0'><tr><td valign='top' align='center'><div style='margin-left:20px;' id=\"flashcontent\" align=\"left\"></div><br /><br /><div id=\"menuhide\" class=\"shown\"><a href=\"javascript:EP_loadPlayList('ep_player', './playlist.xml');\">Load All Albums</a><br /><br /><a href=\"javascript:musicloadurl('index.php?showlist=true','Albums')\">Show Directory Listing</a><br /><br /><a href='javascript:mini()'>Mini Mode</a><br /><br /></div><div id=\"menushow\" class=\"hidden\"><a href='javascript:full()'>Full Mode</a></div>";
	print "	<script type=\"text/javascript\">\n
		// <![CDATA[\n"; ?>

		var so = new SWFObject("mp3player/ep_player.swf", "ep_player", "220", "264", "9", "#C85E35");
		so.addVariable("skin", "mp3player/skins/alien_green/skin.xml");
		so.addVariable("playlist", "./playlist.xml");
		so.addVariable("autoplay", "false");
		so.addVariable("shuffle", "false");
		so.addVariable("repeat", "false");
		so.addVariable("buffertime", "1");
		so.write("flashcontent");
		<?php
		print "
		// ]]>\n
	</script></td><td width='600' valign='top'><div class=\"shown\" id='content'>";
	print getDirectory();
	print "</div><br /><div id='loading' class='lhidden' align='center'><img class='imghead' src='http://dev.feeditout.com/images/ajax.gif' alt='loading' /> Requesting Content ...</div></td></tr></table>\n";
	
	?>