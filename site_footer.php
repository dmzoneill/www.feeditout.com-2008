
</body>
</html>
<?php

require_once("conf.php");
require_once("browser.php");

$br = new Browser;

$ip = $_SERVER['REMOTE_ADDR'];
$platform = $br->Platform;
$browser = $br->Name;
$version = $br->Version;
$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$rtime = $_SERVER['REQUEST_TIME'];

if(count($stream->do_query("select * from logs where ipadd='$ip'","array"))<1){

	$stream->do_query("insert into logs values('','$ip','$platform','$browser','$version','$lang','$rtime','1')","one");

}
else {
	$hits = $stream->do_query("select hits from logs where ipadd='$ip'","one");
	$hits = $hits + 1;
	$stream->do_query("update logs set rtime='$rtime', hits='$hits' where ipadd='$ip'","one");
}


ob_end_flush();

?>
