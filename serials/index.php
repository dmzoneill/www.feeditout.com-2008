<?php
require_once("../conf.php");


$view = $_GET['view'];
if($_GET['input']) $view = "input";
$term = $_GET['term'];
$file = $_GET['file'];
$url = $_GET['url']; 


switch($view){

default:

include("../site_header.php");

?>
<script type="text/javascript">
changetitle('Serials');
</script>
</head>
<body>
<?php

print "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Serials' class='imghead' alt='serials' /><br>$sitemenu</legend><hr style='color: #666;background-color: #666;height: 1px;border: 0;'>";
?>
<table cellpadding='0' border='0' width='800'><tr><td class='asholder'>
Search : <input id="booksearch" style="width:500px;" type="text"/><input type="hidden" id="testid" value=""/>
</td></tr></table><hr style='color: #666;background-color: #666;height: 1px;border: 0;'>
<?php
print "<div id=\"search\"></div></fieldset>";	
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
	ob_start('ob_gzhandler');
	$input = mysql_real_escape_string($_GET['input']);
	$len = strlen($input);
	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 15;
	
	
	$aResults = array();
	$count = 0;	
	
	
	if ($len)
	{
		$books = $stream->do_query("select * from serial where contents like '%$input%' limit 0,$limit","array");	
		
		for ($i=0;$i<count($books);$i++)
		{
			$tmp = $books[$i];
			$id = $tmp[0];
			$name = substr(rawurldecode($tmp[1]),0,80);
			$name = eregi_replace(' +',' ',trim($name));
			$name = eregi_replace("[\r\t\n]","",$name);
			if(stristr($name,"s/n")){
				$name = explode("s/n",$name);
				$name = $name[0];
				if(substr($name,0,2)=="PC"){
					$name = substr($name,2,strlen($name));
				}
			}
			
			$count++;
			$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($input), "info"=>htmlspecialchars($name) );

			if ($limit && $count==$limit)
				break;
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
		echo "<rs id=\"".$aResults[$i]['id']."\" info=\"Found ".$aResults[$i]['info']."\">".$aResults[$i]['value']."</rs>";
	}
	echo "</results>";



break;

case "search":
	ob_start('ob_gzhandler');

	$termd = base64_encode($term);
	if(count(@$stream->do_query("select * from logs_serials where ser='$termd'","array"))>0){
		$hits = @$stream->do_query("select hits from logs_serials where ser='$termd'","one") +1;
		@$stream->do_query("update logs_serials set hits='$hits' where ser='$termd'","one");
	}
	else {
		@$stream->do_query("insert into logs_serials values('','$termd','1')","one");
	}

	$docs = $stream->do_query("SELECT DISTINCT contents FROM `serial` where contents like '%$term%'","array");
	

print "<img src='http://dev.feeditout.com/image.php?text=$term' class='imghead'><br />\n";
print "<table width='800' cellpadding='0' cellspacing='0' border='0'><tr>";

	
	for($i=0;$i<count($docs);$i++){
		
		$tmp = $docs[$i];
		$conet = rawurldecode($tmp[0]);
		if($i%2>0)	$bgcolor="#333333";
		else $bgcolor="#222222";			
		$conet = eregi_replace("$term","<font color='#ff9900'>$term</font>",$conet);
		print "<tr><td colspan='2' align='left' width='800'>&nbsp;</td></tr>";
		print "<tr><td width='100'>$i &nbsp;&nbsp; </td><td bgcolor='$bgcolor' align='left' width='700'>$conet</td></tr>";
		
	}

print "<tr><td colspan='2'><hr style='color: #666;background-color: #666;height: 1px;border: 0;'>Total of ".count($docs)."$t results </td></tr></table>";

break;

}

?>
