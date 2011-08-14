<?php

$ignore = array("index.php","..",".","mp3player","downloads","getid3");
$total_size_list =0;
$total_files = 0; 
$playlist_all = 0;


require_once("../conf.php");


if($_GET['f'])
{

 getFiles( $_GET['f'], 0);

exit;

}


if($_GET['showlist'])
{

 print getDirectory();

exit;

}


if(!$_GET['test'])
{
include("header.php");
include("footer.php");

}

?>