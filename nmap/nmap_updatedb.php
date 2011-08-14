<?php 

require_once( "conf.php" );
$db = null;

$db1 = new PDO( "sqlite:" . __SITE_ROOT . "/db.sqlite.new" );
$exists = $db1->prepare( "SELECT count(*) FROM sqlite_master WHERE type='table' AND name='nmaplogs';" );
$exists->execute();

if( $exists->fetchColumn() == 0 )
{
	$db1->beginTransaction();
	$db1->exec( "CREATE TABLE nmaplogs(id INTEGER PRIMARY KEY, scanoptions CHAR(255), dateint CHAR(255), datestr CHAR(255), file CHAR(255))" );
	$db1->commit();

	$db1->beginTransaction();
	$db1->exec( "CREATE TABLE addresses(scanid INTEGER, hostid INTEGER, addr CHAR(255), addrtype CHAR(255), vendor CHAR(255))" );
	$db1->commit();

	$db1->beginTransaction();
	$db1->exec( "CREATE TABLE hostnames(scanid INTEGER, hostid INTEGER, name CHAR(255), type CHAR(255))" );
	$db1->commit();

	$db1->beginTransaction();
	$db1->exec( "CREATE TABLE ports(scanid INTEGER, hostid INTEGER, port CHAR(255), name CHAR(255), product CHAR(255), version CHAR(255))" );
	$db1->commit();

	$db1->beginTransaction();
	$db1->exec( "CREATE TABLE oss(scanid INTEGER, hostid INTEGER, os CHAR(255), accuracy CHAR(255))" );
	$db1->commit();

	$db1->beginTransaction();
	$db1->exec( "CREATE TABLE scripts(scanid INTEGER, hostid INTEGER, script CHAR(255), output CHAR(255))" );
	$db1->commit();

	$db1->beginTransaction();
	$db1->exec( "CREATE TABLE hops(scanid INTEGER, hostid INTEGER, ttl CHAR(255), ipaddr CHAR(255))" );
	$db1->commit();

	$db1->beginTransaction();
	$db1->exec( "CREATE TABLE uptimes(scanid INTEGER, hostid INTEGER, seconds CHAR(255), lastboot CHAR(255))" );
	$db1->commit();
}

$items = glob( "./nmaplogs/*.xml" );

for ( $i = 0; $i < count( $items ); $i++ ) 
{
	$log = simplexml_load_file( $items[ $i ] );
	$scan_args = $log['args'];
	$scan_start = $log['start'];
	$scan_startstr = $log['startstr'];
	$hosts = $log->xpath('//host');	
		
	$exists = $db1->prepare( "SELECT count(*) from nmaplogs where dateint='" . $scan_start . "'" );
	$exists->execute();
	
	if( $exists->fetchColumn() == 0 )
	{
		$db1->beginTransaction();
		$db1->exec( "INSERT INTO nmaplogs values( NULL , '" . $scan_args . "' , '" . $scan_start . "' , '" . $scan_startstr ."' , '" . $items[$i] . "' )" );
		$db1->commit();

		$scanid = $db1->lastInsertId();
		$hostid = 1;
	
		foreach($hosts as $host)
		{ 
	    	$hostinfo = simplexml_load_string($host->asXML()); 
	    	$addresses = $hostinfo->xpath('/host/address'); 
			$hostnames = $hostinfo->xpath('/host/hostnames/hostname'); 
			$ports = $hostinfo->xpath('/host/ports/port');
			$oss = $hostinfo->xpath('/host/os/osmatch');
			$uptime = $hostinfo->xpath('/host/uptime');
			$scripts = $hostinfo->xpath('/host/hostscript/script');
			$hops = $hostinfo->xpath('/host/trace/hop');

			foreach( $addresses as $addr )
			{
				$db1->beginTransaction();
				$db1->exec( "INSERT INTO addresses values( $scanid , $hostid , '" . $addr['addr'] . "' , '" . $addr['addrtype'] ."' , '" . $addr['vendor'] . "' )" );
				$db1->commit();
			}

			foreach( $hostnames as $hostname )
			{
				$db1->beginTransaction();
				$db1->exec( "INSERT INTO hostnames values( $scanid , $hostid , '" . $hostname['name'] . "' , '" . $hostname['type'] ."' )" );
				$db1->commit();
			}

			foreach( $ports as $port )
			{
				$portinfo = simplexml_load_string($port->asXML()); 
				$serviceInfo = $portinfo->xpath('/port/service'); 
				$name = isset( $serviceInfo[0]['name'] ) ? $serviceInfo[0]['name'] : "";
				$product = isset( $serviceInfo[0]['product'] ) ? $serviceInfo[0]['product'] : "";
				$version = isset( $serviceInfo[0]['version'] ) ? $serviceInfo[0]['version'] : "";

				$db1->beginTransaction();
				$db1->exec( "INSERT INTO ports values( $scanid , $hostid , '" . $port['portid'] . "' , '" . $name ."' , '" . $product . "' , '" . $version . "' )" );
				$db1->commit();	
			}

			foreach( $oss as $os )
			{
				$db1->beginTransaction();
				$db1->exec( "INSERT INTO oss values( $scanid , $hostid , '" . $os['name'] . "' , '" . $os['accuracy'] ."' )" );
				$db1->commit();
			}

			foreach( $scripts as $script )
			{
				$db1->beginTransaction();
				$db1->exec( "INSERT INTO scripts values( $scanid , $hostid , '" . $script['id'] . "' , '" . $script['output'] ."' )" );
				$db1->commit();
			}

			foreach( $hops as $hop )
			{
				$db1->beginTransaction();
				$db1->exec( "INSERT INTO hops values( $scanid , $hostid , '" . $hop['ttl'] . "' , '" . $hop['ipaddr'] ."' )" );
				$db1->commit();
			}

			$seconds = isset( $uptime[0]['seconds'] ) ? $uptime[0]['seconds'] : "";
			$uptime = isset( $uptime[0]['lastboot'] ) ? $uptime[0]['lastboot'] : "";	

			$db1->beginTransaction();
			$db1->exec( "INSERT INTO uptimes values( $scanid , $hostid , '" . $seconds . "' , '" . $uptime ."' )" );
			$db1->commit();

			$hostid++;	
		}	

		print "Processed : " . $items[ $i ] . "<br />\n";	
	} 		
}

$db = null;
$db1 = null;

usleep(500000);

@unlink( __SITE_ROOT . "/db.sqlite" );
@rename( __SITE_ROOT . "/db.sqlite.new" , __SITE_ROOT . "/db.sqlite" );
@chmod( __SITE_ROOT . "/db.sqlite" , 0777 );


?>
