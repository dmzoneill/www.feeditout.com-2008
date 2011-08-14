<?php
require_once("../conf.php");

$view = $_GET['view'];
if($_GET['input']) $view = "input";
$letter = strtolower($_GET['letter']);
$term = htmlspecialchars(strtolower($_GET['term']));
$file = $_GET['file'];
$url = $_GET['url']; 




switch($view){

default:

include("../site_header.php");

?>
<script type="text/javascript">
changetitle('Texts');
</script>
</head>
<body>
<?php
print "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Short Documents' class='imghead' alt='Documents' /><br>$sitemenu</legend>";
print "<hr style='color: #666;background-color: #666;height: 1px;border: 0;'><table width='100%'><tr><td>";

$docs = $stream->do_query("select id,named,sized,viewsd from documents order by named asc","array");

for($i=0;$i<count($docs);$i++){

	$tmp = $docs[$i];
	$id = $tmp[0];
	$name = $tmp[1];
	$size = $tmp[2];
	$views = $tmp[3];
	$first = strtolower(substr($name,0,1));
	if("$first"!=="$pass"){
		print "<a href=\"javascript:textsletterurl('" .strtoupper($first) ."')\">" . strtoupper($first) . "</a> | ";
	}
	$pass = strtolower(substr($name,0,1));
}

print "</td><td align='right' class='asholder'>Search : <input id=\"booksearch\" type=\"text\"  style=\"width:180px;\"/><input type=\"hidden\" id=\"testid\" value=\"\"/></td></tr></table><hr style='color: #666;background-color: #666;height: 1px;border: 0;'><br /><br /><div id=\"listing\"></div></fieldset>";
?>


<script language="javascript" type="text/javascript">
	<!--
	var options_xml = {
		script: function (input) {
		return "index.php?input="+input+"&testid="+document.getElementById('testid').value; 
		},
		varname:"input"
	};
	var as_xml = new bsn.AutoSuggest('booksearch', options_xml);
	//-->
</script>
<?php
include("../site_footer.php");

break;

case "input":

	$input = mysql_real_escape_string($_GET['input']);
	$len = strlen($input);
	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 15;
	
	
	$aResults = array();
	$count = 0;	
	
	
	if ($len)
	{
		$books = $stream->do_query("select * from documents where contentd like '%$input%' order by named ASC limit 0,$limit","array");	
		
		for ($i=0;$i<count($books);$i++)
		{
			$tmp = $books[$i];
			$id = $tmp[0];
			$name = substr($tmp[1],0,30);
			
			$count++;
			$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($input), "info"=>htmlspecialchars($name) );

			if ($limit && $count==$limit)
				break;
		}
	}
	
	
	
	ob_start('ob_gzhandler');
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	

	header("Content-Type: text/xml");
		
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
	for ($i=0;$i<count($aResults);$i++)
	{
		echo "<rs id=\"".$aResults[$i]['id']."\" info=\"Found in ".$aResults[$i]['info']."\">".$aResults[$i]['value']."</rs>";
	}
	echo "</results>";


break;


case "letter":
ob_start('ob_gzhandler');
$docs = $stream->do_query("select id,named,sized,viewsd from documents order by named asc","array");

print "<table width='650' cellpadding='0' cellspacing='0' border=0><tr><td><img src='http://dev.feeditout.com/image.php?text=Listing for $letter' class='imghead' /><br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'></td></tr></table>\n";
print "<table width='650' cellpadding='0' cellspacing='0' border=0><tr>
<td align='left' width='400'><b> Name </td>
<td align='right' width='150'><b> Size </td>
<td align='right' width='100'><b> Views </td>
</tr>";

for($i=0;$i<count($docs);$i++){

	$tmp = $docs[$i];
	$id = $tmp[0];
	$name = $tmp[1];
	$size = $tmp[2];
	$views = $tmp[3];

	$first = strtolower(substr($name,0,1));
	
	if("$first"!=="$letter"){
		continue;
	}

$mkurl = rawurlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']);
$kb = round($size /1024);
print "<tr>
<td align='left' width='400'><b> 
<a href=\"javascript:textsloadurl('index.php?view=viewfile&file=$id&url=$mkurl');\">$name</a></td>
<td align='right' width='150'><b> $size ($kb kb)</td>
<td align='right' width='100'><b> $views </td>
</tr>";
			
}
print "</table>";

break;


case "search":
ob_start('ob_gzhandler');
$docs = $stream->do_query("SELECT id,named,sized,viewsd FROM `documents` WHERE `contentd` LIKE '%$term%'","array");

print "<table width='650' cellpadding='0' cellspacing='0' border='0'><tr><td colspan=3><img src='http://dev.feeditout.com/image.php?text=Search results for $term ' class='imghead' /><br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'></td></tr></table>\n";
print "<table width='650' cellpadding='0' cellspacing='0' border='0'><tr>
<td align='left' width='400'><b> Name </td>
<td align='right' width='150'><b> Size </td>
<td align='right' width='100'><b> Views </td>
</tr>";

for($i=0;$i<count($docs);$i++){

	$tmp = $docs[$i];
	$id = $tmp[0];
	$name = $tmp[1];
	$size = $tmp[2];
	$views = $tmp[3];

$mkurl = rawurlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']);

$kb = round($size /1024);

print "<tr>
<td align='left' width='400'><b> 
<a href=\"javascript:textsloadurl('index.php?view=viewfile&file=$id&url=$mkurl');\">$name</a></td>
<td align='right' width='150'><b> $size ($kb kb)</td>
<td align='right' width='100'><b> $views </td>
</tr>";
			
}
print "</table>";

break;


case "viewfile";

ob_start('ob_gzhandler');

$docs = $stream->do_query("SELECT named,contentd FROM `documents` WHERE `id` = '$file'","array");

if($_GET['letter']){
	$url = $url . "&letter=" .$_GET['letter'];
}

if($_GET['term']){
	$url = $url . "&term=" .$_GET['term'];
}

$term = $_GET['term'];

for($i=0;$i<count($docs);$i++){

	$tmp = $docs[$i];
	$name = $tmp[0];
	if($_GET['term']){
		$content = preg_replace("/$term/i","<font style='background-color:#cc3333'>$term</font>",rawurldecode($tmp[1]));
	}
	else {
		$content = rawurldecode($tmp[1]);
	}
	
	$textd = base64_encode($name);
	if(count(@$stream->do_query("select * from logs_texts where text='$textd'","array"))>0){
		$hits = @$stream->do_query("select hits from logs_texts where text='$textd'","one") +1;
		@$stream->do_query("update logs_texts set hits='$hits' where text='$textd'","one");
	}
	else {
		@$stream->do_query("insert into logs_texts values('','$textd','1')","one");
	}

	
print "<table width='650' cellpadding='0' cellspacing='0' border='0'><tr><td colspan='3'><img src='http://dev.feeditout.com/image.php?text=Viewing file $name' class='imghead' alt='file'/><br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'></td></tr></table>\n";	
	
print "<table width='650' cellpadding='0' cellspacing='0' border='0'><tr>
<td align='left' width='650'><a href=\"javascript:textsloadurl('$url')\"> << Back</a></td></tr></table><br /><br />";	
	
print "<table width='650' cellpadding='0' cellspacing='0' border=0><tr>
<td align='left' width='650'>".nl2br($content)."</td></tr></table><br /><br />";

print "<table width='650' cellpadding='0' cellspacing='0' border=0><tr>
<td align='left' width='650'><a href=\"javascript:textsloadurl('$url')\"> << Back</a></td></tr></table>";	
			
}


break;

}

?>
