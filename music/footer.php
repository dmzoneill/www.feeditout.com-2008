<?php

	$avg_size = round((($total_size_list / $total_files) /1024) /1024,2);
	$total_size_list = round((($total_size_list / 1024) /1024) /1024,3);

	print "<br /><div id=\"footer\" class=\"shown\"><hr style='color: #666;background-color: #666;height: 1px;border: 0;'>";
	print "Total of $total_files mp3s ($total_size_list gb) - Average size $avg_size mb";
	print "<br><br>It can take up to 10 seconds to enter a directory, due to making of downloadable album archive.<br /> This only happens once per album</div></fieldset>";
	

?>	<script type="text/javascript">

		var so = new SWFObject("mp3player/ep_player.swf", "ep_player", "220", "264", "9", "#C85E35");
		so.addVariable("skin", "mp3player/skins/alien_green/skin.xml");
		so.addVariable("playlist", "./playlist.xml");
		so.addVariable("autoplay", "false");
		so.addVariable("shuffle", "false");
		so.addVariable("repeat", "false");
		so.addVariable("buffertime", "1");
		so.write("flashcontent");


	</script>
<br />
<?php
include("../site_footer.php");
?>