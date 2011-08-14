<?php

require_once( "conf.php" );

$networks = array();
$networks[] = "192.168.1.0/24";

$logs_dir = __SITE_ROOT . "/nmaplogs";
$log_name = time() . ".xml";

$log_path = $logs_dir . "/" . $log_name;

if( stristr ( PHP_OS , 'WIN' ) ) 
{ 
	$scanargs = "c:\\Program Files\\nmap\\nmap.exe ";
}
else
{
	$scanargs = "sudo /usr/local/bin/nmap ";
}

$scanargs .= "-R -PR -A -O -F -T5 -oX \"" . $log_path . "\" ";

foreach( $networks as $network )
{
	$scanargs .= $network . " ";
}

$scanargs .= " 2>&1";
exec( $scanargs );

require_once( __SITE_ROOT . "/nmap_updatedb.php" );

?>
