<?php

require_once("../conf.php");

if($_GET['search']){
print "<table width='700' border='0'><tr><td>";

if ($handle = opendir('./files')) 
{

    while (false !== ($file = readdir($handle))) 
    {
    	if(is_dir($file))
    	{
    		continue;
    	}
    	else 
    	{	
			if($file=="index.html") continue;
			if($file=="index.php") continue;
			if(stristr($file,$_GET['search'])){
    			$files[] = $file;
			}
    	}
	}	
	closedir($handle);
	if(count($files)>0){	
	sort($files);
	reset($files);
	}
	$p=0;
	print "<img src='http://dev.feeditout.com/image.php?text=$_GET[search]' class='imghead' alt='search'/><br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'><br />";
	if(count($files)>0){
	foreach($files as $k => $n_file) 
	{ 	
		$sizet = "bytes";
		$size = filesize("./files/$n_file");
		if($size>1024) 
		{
			$sizet = "kb";
			$size = round($size/1024,2);
		}
		if($size>1024) 
		{
			$sizet = "mb";
			$size = round($size / 1024,2);			
		}
		
		$download = base64_encode($n_file);
		print "<a href='download.php?file=$download' name='$n_file'>$n_file</a>  $size $sizet  <br />";
		$p++;
	}
	}
	if($p==0){
		print "O Matches Found!";
	} 	
}
print "</td></tr></table>";
exit;
}

if($_GET['input']){

	ob_start('ob_gzhandler');
	$input = $_GET['input'];
	$len = strlen($input);
	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 15;
	
	
	$aResults = array();
	$count = 0;	
	
	
	if ($len)	
	{
		if ($handle = opendir('./files')) 
		{
			while (false !== ($file = readdir($handle)))    
			{
    			if(is_dir($file))
    			{
    				continue;
    			}
    			else 
    			{	
					if($file=="index.html") continue;
					if($file=="index.php") continue;
					if(stristr($file,$input)){
    					$files[] = $file;
					}
    			}
			}	
		}	
		closedir($handle);
		if(count($files)>0){	
			sort($files);
			reset($files);
		}
		$p=0;
		if(count($files)>0){
			foreach($files as $k => $n_file) 
			{ 	
				$sizet = "bytes";
				$size = filesize("./files/$n_file");
				if($size>1024) 
				{
					$sizet = "kb";
					$size = round($size/1024,2);
				}
			if($size>1024) 
			{
					$sizet = "mb";
				$size = round($size / 1024,2);			
			}
		
			$count++;
			$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($n_file), "info"=>"$size $sizet");

			if ($limit && $count==$limit)
				break;

			}
		}
	}
	
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	

	header("Content-Type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
	for ($i=0;$i<count($aResults);$i++)
	{
		echo "<rs id=\"".$aResults[$i]['id']."\" info=\"Size : ".$aResults[$i]['info']."\">".$aResults[$i]['value']."</rs>";
	}
	echo "</results>";
	
	exit;

}

include("../site_header.php");

?>
<script type="text/javascript">
changetitle('Stuff');
</script>
</head>

<body>



<?php
print "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Stuff!!!' class='imghead' alt='stuff' /><br>$sitemenu</legend><hr style='color: #666;background-color: #666;height: 1px;border: 0;'><table width='100%'><tr><td class='asholder'><a href=\"javascript:stuffshowdiv('uploads','files');\">Upload Files</a> | Search for file : <input id=\"filessearch\"  type=\"text\" style='width:400px;'/><input type=\"hidden\" id=\"testid\" value=\"\"/><br /><br />";

print "<div id='files' class='hidden'></div>";

print "<div id='uploads' class='hidden'><img src='http://dev.feeditout.com/image.php?text=Upload Files' class='imghead' alt='upload files' /><br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'><br />";

print "<table width='700' border='0'>";
for($x=1;$x<11;$x++){
print "<tr><td width='150'>
<form name=\"upload$x\" enctype=\"multipart/form-data\" action=\"uploader.php\" method=\"post\" target=\"fileupload$x\">
<input type=\"button\" class=\"red\" id=\"pseudobutton$x\" value=\"Upload File\" /><input type=\"file\" class=\"hide\" id=\"openssme$x\" name='uploadedfile' onchange=\"fileupload('$x','0');document.upload$x.submit();\" onmousedown=\"buttonPush('depressed','pseudobutton$x');\" onmouseup=\"buttonPush('normal','pseudobutton$x');\" onmouseout=\"buttonPush('phased','pseudobutton$x');\" /></form></td><td width='550'><div id='status$x'></div></td><td><iframe class='fileiframe' width='1' height='1' scrolling=\"no\" name=\"fileupload$x\" id=\"fileupload$x\"></iframe>
</td></tr>";
}
print "</table></div>";
?>
</td></tr></table></fieldset>
<script type="text/javascript">
<!--
	
	var options_xml = {
		script: function (input) {
		return "index.php?input="+input+"&testid="+document.getElementById('testid').value; 
		},
		varname:"input"
	};
	var as_xml = new bsn.AutoSuggest('filessearch', options_xml);
//-->	
</script>
<?php
include("../site_footer.php");
?>
