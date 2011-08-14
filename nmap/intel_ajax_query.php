<?php

require_once( "conf.php" );

if( isset( $_GET['hostdataLog'] ) && isset( $_GET['scanid'] ) && isset( $_GET['hostid'] ) )
{
	$data = $db->prepare( 'SELECT * from addresses where scanid = :scanid and hostid = :hostid' );
	$data->bindParam( ':scanid' , $_GET['scanid'] , PDO::PARAM_INT );
	$data->bindParam( ':hostid' , $_GET['hostid'] , PDO::PARAM_INT );
	$data->execute(); 

	print "<div align='right'> <a onclick=\"javascript:$( '#hostDetails' ).slideUp('fast');$( '#errorDetails' ).slideUp('fast');\"><img width='12' src='images/close.gif'></a></div>";
	$i = 0;
	foreach( $data->fetchAll() as $address )
	{
		if( $i == 0 )
		{
			print "<h2>" . $address['addr'] . " (" . netBiosName( $_GET['hostid'] , $_GET['scanid'] ) . ") </h2><a href=\"javascript:launchRemoteDesktop('" . $address['addr'] . "')\"><img width='15' src='images/remote-desktop.gif' /></a><br /><br />";
			$i++;
		}		
	}

	$data = $db->prepare( 'SELECT * from addresses where scanid = :scanid and hostid = :hostid' );
	$data->bindParam( ':scanid' , $_GET['scanid'] , PDO::PARAM_INT );
	$data->bindParam( ':hostid' , $_GET['hostid'] , PDO::PARAM_INT );
	$data->execute(); 	

	print "<h3>Network Addresses</h3>";
	
	print "<table style='width:600px'>";
	print "<tr><th>Address</th><th>Type</th><th>Vendor</th></tr>";
	foreach( $data->fetchAll() as $address )
	{
		print "<tr><td width='150'>" .$address['addr'] . "</td><td width='150'>" . $address['addrtype'] . "</td><td>" . $address['vendor'] . "</td></tr>";	
	}
	print "</table>";

	$data = $db->prepare( 'SELECT * from ports where scanid = :scanid and hostid = :hostid' );
	$data->bindParam( ':scanid' , $_GET['scanid'] , PDO::PARAM_INT );
	$data->bindParam( ':hostid' , $_GET['hostid'] , PDO::PARAM_INT );
	$data->execute(); 

	print "<h3>Network Ports</h3>";
	
	print "<table style='width:600px'>";
	print "<tr><th>Port</th><th>Name</th><th>Product</th><th>Version</th></tr>";
	foreach( $data->fetchAll() as $port )
	{
		print "<tr><td width='150'>" .$port['port'] . "</td><td width='150'>" . $port['name'] . "</td><td width='150'>" . $port['product'] . "</td><td width='150'>" . $port['version'] . "</td></tr>";	
	}
	print "</table>";
	
	$data = $db->prepare( 'SELECT * from oss where scanid = :scanid and hostid = :hostid' );
	$data->bindParam( ':scanid' , $_GET['scanid'] , PDO::PARAM_INT );
	$data->bindParam( ':hostid' , $_GET['hostid'] , PDO::PARAM_INT );
	$data->execute(); 

	print "<h3>OS Detection</h3>";

	print "<table style='width:600px'>";
	print "<tr><th>OS</th><th>Accuracy</th></tr>";
	foreach( $data->fetchAll() as $os )
	{
		print "<tr><td width='450'>" .$os['os'] . "</td><td>" . $os['accuracy'] . "%</td></tr>";	
	}
	print "</table>";

	$data = $db->prepare( 'SELECT * from scripts where scanid = :scanid and hostid = :hostid' );
	$data->bindParam( ':scanid' , $_GET['scanid'] , PDO::PARAM_INT );
	$data->bindParam( ':hostid' , $_GET['hostid'] , PDO::PARAM_INT );
	$data->execute(); 

	print "<h3>Service Scan</h3>";

	print "<table style='width:600px'>";
	print "<tr><th>Script</th><th>Output</th></tr>";
	foreach( $data->fetchAll() as $script )
	{
		print "<tr><td width='150'>" . $script['script'] . "</td><td>" . $script['output'] . "</td></tr>";
	}
	print "</table>";

	$data = $db->prepare( 'SELECT * from hops where scanid = :scanid and hostid = :hostid' );
	$data->bindParam( ':scanid' , $_GET['scanid'] , PDO::PARAM_INT );
	$data->bindParam( ':hostid' , $_GET['hostid'] , PDO::PARAM_INT );
	$data->execute(); 

	print "<h3>Hop Trace</h3>";

	print "<table style='width:600px'>";
	print "<tr><th>TTL</th><th>Ip address</th></tr>";
	foreach( $data->fetchAll() as $hop )
	{
		print "<tr><td width='150'>" . $hop['ttl'] . "</td><td>" . $hop['ipaddr'] . "</td></tr>";
	}
	print "</table>";

	$data = $db->prepare( 'SELECT * from uptimes where scanid = :scanid and hostid = :hostid' );
	$data->bindParam( ':scanid' , $_GET['scanid'] , PDO::PARAM_INT );
	$data->bindParam( ':hostid' , $_GET['hostid'] , PDO::PARAM_INT );
	$data->execute(); 

	print "<h3>Uptime</h3>";
	
	print "<table style='width:600px'>";
	print "<tr><th>Uptime</th><th>Boot Time</th></tr>";
	foreach( $data->fetchAll() as $uptime )
	{
		print "<tr><td width='150'>" . $uptime['seconds'] . "</td><td>" . $uptime['lastboot'] . "</td></tr>";
	}
	print "</table><br/><br/>";

}



if( isset( $_GET['remoteDesktop'] ) && isset( $_GET['target'] ) )
{
	
	$WshShell = new COM("WScript.Shell");
   	$oExec = $WshShell->Run( "psexec \\" . $_SERVER['REMOTE_ADDR'] . " mstsc.exe /v:" .$_GET['target'] , 0, false );
   	print ($oExec == 0) ? "Error: Success" : "Error: Unable to start Remote Desktop on your computer<br/>"; 
}

?>
