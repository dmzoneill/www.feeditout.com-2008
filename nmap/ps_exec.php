<?php

require_once( "conf.php" );
require_once( "intel_header.php" );
require_once( "Pstools.php" );

$ps = new Pstools();

$output = array();
$retval = 0;

$ps->computer = "10.243.19.7";

if( $ps->psexec( $output , $retval ) )
{
	print_r( $output );
}
else
{
	print $ps->getError() . "<br />";
	print "fail";	
}




require_once( "intel_footer.php" );

?>
