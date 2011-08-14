<?php

require_once( "conf.php" );
require_once( "intel_header.php" );


$logs = $db->prepare("SELECT * FROM nmaplogs ORDER BY id DESC");
$logs->execute();
$rows = $logs->fetchAll();

$today = date( "l" , time() - 1000000);

foreach( $rows as $row )
{					
	if( date( 'l' , $row['dateint'] ) != $today ) 
	{						
		print "<h2>" . date('l jS \of F Y' , $row['dateint'] ) . "</h2>";
		$today = date( 'l' , $row['dateint'] );
	}
	
	preg_match( "/\b -([0-9a-zA-Z\- ])*\b/" , $row['scanoptions'] , $ops );
	preg_match( "/(([2]([0-4][0-9]|[5][0-5])|[0-1]?[0-9]?[0-9])[.]){3}(([2]([0-4][0-9]|[5][0-5])|[0-1]?[0-9]?[0-9]))\/([0-9]{1,2})|(([2]([0-4][0-9]|[5][0-5])|[0-1]?[0-9]?[0-9])[.]){3}(([2]([0-4][0-9]|[5][0-5])|[0-1]?[0-9]?[0-9]))/" , $row['scanoptions'] , $net );
	print "<a class='small' href='intel_viewlog.php?log=" . $row['id'] . "'>" . $row['datestr'] . "</a>&nbsp;&nbsp;&nbsp; " . $ops[0] . " " . $net[0] . "<br />";	
}

require_once( "intel_footer.php" );

?>
