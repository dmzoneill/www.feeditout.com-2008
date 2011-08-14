<?php

$mysql_host = "localhost"; // mysql.feeditout.com
$mysql_username = "root"; // books
$mysql_password = ""; 
$mysql_dbname = "elearning";
$site_root = "/home/www";

$userlevel = 0;

if(stristr($site_root,"feeditout.com/"))
{
	$gb = explode("/",$site_root);
	$gcount = count($gb) - 1;
	header("Location: http://dev.feeditout.com/".$gb[$gcount]);
}

require_once($site_root."/db_mysql.php");
require_once($site_root."/functions.php");
