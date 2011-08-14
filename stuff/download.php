<?php
	
include("../conf.php");

if($_GET['file']){
	$filer = mysql_real_escape_string($_GET['file']);
	if(count(@$stream->do_query("select * from logs_files where file='$filer'","array"))>0){
		$hits = @$stream->do_query("select hits from logs_files where file='$filer'","one") +1;
		@$stream->do_query("update logs_files set hits='$hits' where file='$filer'","one");
	}
	else {
		@$stream->do_query("insert into logs_files values('','$filer','1')","one");
	}
	$file = base64_decode($_GET['file']);
	$codename =$file;
	if(stristr($codename,"..")) die("Hacking attempt");
	if(stristr($codename,";")) die("Hacking attempt");
	if(stristr($codename,"\"")) die("Hacking attempt");
	if(stristr($codename,"'")) die("Hacking attempt");
	if(stristr($codename,",")) die("Hacking attempt");
	if(stristr($codename,"-exec")) die("Hacking attempt");	
	header("Content-Disposition: attachment; filename=feeditout-$file");
	readfile("files/$file");	
}

?>