<?php
require_once( "conf.php" );

$linux = 0;
$windows = 0;
$mac = 0;
$printer = 0;
$other = 0;
$modem = 0;


if( !isset( $_GET['log'] ) )
{
	header( 'Location: intel_main.php' );
}
if( strlen( $_GET['log'] ) == 0 )
{
	header( 'Location: intel_main.php' );
}
else
{
	$exists = $db->prepare( 'SELECT count(*) FROM nmaplogs where id = :id' );
	$exists->bindParam( ':id' , $_GET['log'] , PDO::PARAM_INT );
	$exists->execute();
	
	if( $exists->fetchColumn() == 0 )
	{
		header( 'Location: intel_main.php' );
	}	
}

require_once( "intel_header.php" );

$data = $db->prepare( 'SELECT DISTINCT hostid from addresses where scanid = :scanid' );
$data->bindParam( ':scanid' , $_GET['log'] , PDO::PARAM_INT );
$data->execute();

$rows = $data->fetchAll();
$hosts = array();

foreach( $rows as $row )
{
	$hosts[] = $row['hostid'];  
}

print "<div id='errorDetails' style='vertical-align:top;border-bottom:1px dashed #99f;margin-bottom:30px;padding-bottom:10px'></div><br />";
print "<div id='hostDetails' style='vertical-align:top;border-bottom:1px dashed #99f;margin-bottom:30px'></div>";
print "<h2>Detected Hosts</h2><table style='width:600px;' ><tr>";

$i = 0;
		
foreach( $hosts as $host )
{
	if( $i > 0 && $i % 2 == 0)
	{
		print "</tr><tr>";
	} 
	$data = $db->prepare( 'SELECT * from addresses where scanid = :scanid and hostid = :hostid' );
	$data->bindParam( ':scanid' , $_GET['log'] , PDO::PARAM_INT );
	$data->bindParam( ':hostid' , $host , PDO::PARAM_INT );
	$data->execute(); 

	foreach( $data->fetchAll() as $address )
	{
		if( $address['addrtype'] == "ipv4" )
		{			
			print "<td><img width='20' src='images/" . osImage( osType( $host , $_GET['log'] ) ) . "'/ style='vertical-align:middle;margin:2px'> ";
			print "<a class='small' href=\"javascript:hostDetails('" . $_GET['log'] . "' , '$host')\">" . $address['addr'] . " (" . netBiosName( $host , $_GET['log'] ) . ")</a></td>";	
		}
		
	}
	
	$i++;
}

print "</tr><table>";

print "<div style='margin-bottom:30px;border-top:1px dashed #99f;margin-top:30px'></div>";
print "<h2>Statistics</h2>";

getStats();

require_once( "intel_footer.php" );

?>
