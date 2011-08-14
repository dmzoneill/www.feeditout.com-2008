<?php
include("conf.php");
$security_overide = "true";
include("site_header.php");
?>

<script type="text/javascript">
window.onload = function(){
	var loading = document.getElementById("loading");				 
	loading.setAttribute("class", "hidden");
	loading.setAttribute("className", "hidden");
		
	var menu = document.getElementById("menuindex");
	menu.setAttribute("class", "menuindex");
	menu.setAttribute("className", "menuindex");
};
</script>

</head>
<body class="bodyindex">
<center>

<div id="container">
<div id="position">	
<div id="menuindex" class="hidden">
	<img class='imghead' src='http://dev.feeditout.com/images/feeditout.jpg' border='0' alt="Logo" /><br />
	<a href="/code/index.php" onMouseOver="showdiv('mh8');" onMouseOut="hidediv('mh8');">Code / Projects</a> # 
<!---
	<a href="/texts/index.php" onMouseOver="showdiv('mh1');" onMouseOut="hidediv('mh1');">Short Documents</a> # 
// -->
	<a href="/books/index.php" onMouseOver="showdiv('mh2');" onMouseOut="hidediv('mh2');">Books</a> # 
<!---
	<a href="/serials/index.php" onMouseOver="showdiv('mh3');" onMouseOut="hidediv('mh3');">Serials</a> # 
	<a href="/music/index.php" onMouseOver="showdiv('mh4');" onMouseOut="hidediv('mh4');">Music</a> # 
// -->
	<a href="/video/index.php">Videos</a> # 
<!---
	<a href="/photos/index.php" onMouseOver="showdiv('mh5');" onMouseOut="hidediv('mh5');">Photos</a> # 
// --->
	<a href="/wallpaper/index.php" onMouseOver="showdiv('mh6');" onMouseOut="hidediv('mh6');">Desktop Wallpaper</a>
<!---
	<a href="/stuff/index.php" onMouseOver="showdiv('mh7');" onMouseOut="hidediv('mh7');">File Hosting</a> #
	<a href="/email/index.php">Email</a>
// -->
	
	<br /><br /><br />
	<div id='mh1' class="hidden"><img class='imghead' src="images/doc.gif" alt='docs' /><br /><br /><?php echo "Last Update : ".date( "F d Y", filemtime("texts/index.php") );?></div> 
	<div id='mh2' class="hidden"><img class='imghead' src="images/pdf.gif" alt='books' /><br /><br /><?php echo "Last Update : ".date( "F d Y", filemtime("books/index.php") );?></div> 
	<div id='mh3' class="hidden"><img class='imghead' src="images/key..jpg" alt='serials' /><br /><br /><?php echo "Last Update : ".date( "F d Y", filemtime("serials/index.php") );?></div> 
	<div id='mh4' class="hidden"></div> 
	<div id='mh5' class="hidden"><img class='imghead' src="images/collage.jpg" alt='photos' /><br /><br /><?php echo "Last Update : ".date( "F d Y", filemtime("photos/index.php") );?></div> 
	<div id='mh6' class="hidden"><img class='imghead' src="images/wallpaper.jpg" alt='wallpaper' /><br /><br /><?php echo "Last Update : ".date( "F d Y ", filemtime("wallpaper/index.php") );?></div> 
	<div id='mh7' class="hidden"><img class='imghead' src="images/files.png" alt='files' /><br /><br /><?php echo "Last Update : ".date( "F d Y", filemtime("stuff/index.php") );?></div> 
	<div id='mh8' class="hidden"><img class='imghead' src="images/code.gif" alt='code' /><br /><br /><?php echo "Last Update : ".date( "F d Y", filemtime("code/index.php") );?></div> 
</div>
</div>
</div>



<div id="loading" class="menuindex">
	<img class='imghead' src='http://dev.feeditout.com/images/ajax-loader.gif' alt='loading' /> Content Loading ...
</div>


</center>

<?php
include("site_footer.php");
?>

