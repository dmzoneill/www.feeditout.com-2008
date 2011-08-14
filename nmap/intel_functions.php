<?php

function osImage( $os )
{
	global $linux , $windows , $mac , $modem , $printer , $other;
	if( stristr( $os, 'linux' ) )
	{
		$linux++;
		return 'linux.gif';
	}	
	else if( stristr( $os, 'windows' ) )
	{
		$windows++;
		return 'windows.gif';
	}
	else if( stristr( $os, 'adsl' ) || stristr( $os, 'modem' ) )
	{
		$modem++;
		return 'modem.gif';
	}
	else if( stristr( $os, 'mac' ) )
	{
		$mac++;
		return 'printer.gif';
	}
	else if( stristr( $os, 'printer' ) )
	{
		$printer++;
		return 'printer.gif';
	}
	else
	{
		$other++;
		return 'card.gif';
	}
}


function osType( $host , $log )
{
	global $db;
	$os = $db->prepare( 'SELECT os from oss where scanid = :scanid and hostid = :hostid and accuracy = (select max(accuracy) from oss where scanid = :scanid and hostid = :hostid)' );
	$os->bindParam( ':scanid' , $log , PDO::PARAM_INT );
	$os->bindParam( ':hostid' , $host , PDO::PARAM_INT );
	$os->execute();	

	return $os->fetchColumn();
}

function netBiosName( $host , $log )
{
	global $db;
	$script = "nbstat";
	$os = $db->prepare( 'SELECT output from scripts where scanid = :scanid and hostid = :hostid and script=:script' );
	$os->bindParam( ':scanid' , $log , PDO::PARAM_INT );
	$os->bindParam( ':hostid' , $host , PDO::PARAM_INT );
	$os->bindParam( ':script' , $script );
	$os->execute();	

	$name = $os->fetchColumn();

	if( strlen( $name ) > 0 )
	{
		preg_match( "/\b(?<=: )([0-9a-zA-Z-.]{3,60})\b/" , $name , $match );
		return $match[0];
	}
	else
	{
		$os = $db->prepare( 'SELECT name from hostnames where scanid = :scanid and hostid = :hostid' );
		$os->bindParam( ':scanid' , $_GET['log'] , PDO::PARAM_INT );
		$os->bindParam( ':hostid' , $host , PDO::PARAM_INT );
		$os->execute();	

		return $os->fetchColumn();
	}
}


function getStats()
{
	global $linux , $windows , $mac , $modem , $printer , $other;
	$stats = "<table><tr><td valign='top'>";
	$stats .= "<img width='20' src='images/linux.gif'/ style='vertical-align:middle;margin:2px'> Linux ($linux) </td><td>";
	$stats .= "<img width='20' src='images/windows.gif'/ style='vertical-align:middle;margin:2px'> Windows ($windows) </td><td>";
	$stats .= "<img width='20' src='images/mac.gif'/ style='vertical-align:middle;margin:2px'> Macintosh ($mac) </td></tr><tr><td>";
	$stats .= "<img width='20' src='images/printer.gif'/ style='vertical-align:middle;margin:2px'> Printers ($printer) </td><td>";
	$stats .= "<img width='20' src='images/modem.gif'/ style='vertical-align:middle;margin:2px'> Network Infrastructure ($modem) </td><td>";
	$stats .= "<img width='20' src='images/card.gif'/ style='vertical-align:middle;margin:2px'> Unknown Devices ($other)";
	$stats .= "<td></tr><tr><td colspan='3'><div id=\"pie_container\" style=\"width: 650px; height: 450px; margin: 0 auto\"></div></td></tr></table>";
	$data = array();
	$all = ($linux + $windows + $mac + $modem + $printer + $other);
	$data[] = array( 'Linux' , round(($linux / $all) * 100) );
	$data[] = array( 'Windows' , round(($windows / $all) * 100) , 1 );
	$data[] = array( 'Macintosh' , round(($mac / $all) * 100) );
	$data[] = array( 'Infrastruture' , round(($modem / $all) * 100) );
	$data[] = array( 'Printers' , round(($printer / $all) * 100) );
	$data[] = array( 'Unknown Devices' , round(($other / $all) * 100) );
	$stats .= "<script language='javascript'>" . pie_chart( '' , 'Device' , $data ) . "</script>";
	print $stats;
}

?>
