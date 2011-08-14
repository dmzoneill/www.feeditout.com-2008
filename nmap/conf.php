<?php

error_reporting( E_ALL ); 
ini_set( "display_errors" , 1 );

date_default_timezone_set ('Europe/Dublin');

define ( "__SITE_ROOT" , dirname( __FILE__ ) );
define ( "__DEBUG" , true );

ob_start( "ob_gzhandler" );

//require_once( __SITE_ROOT . '/adLDAP.php');
//$adldap = new adLDAP();

$db = new PDO( "sqlite:" . __SITE_ROOT . "/db.sqlite" );
$exists = $db->prepare( "SELECT count(*) FROM sqlite_master WHERE type='table' AND name='nmaplogs';" );
$exists->execute();

if( $exists->fetchColumn() == 0 )
{
	$db->beginTransaction();
	$db->exec( "CREATE TABLE nmaplogs(id INTEGER PRIMARY KEY, scanoptions CHAR(255), dateint CHAR(255), datestr CHAR(255), file CHAR(255))" );
	$db->commit();

	$db->beginTransaction();
	$db->exec( "CREATE TABLE addresses(scanid INTEGER, hostid INTEGER, addr CHAR(255), addrtype CHAR(255), vendor CHAR(255))" );
	$db->commit();

	$db->beginTransaction();
	$db->exec( "CREATE TABLE hostnames(scanid INTEGER, hostid INTEGER, name CHAR(255), type CHAR(255))" );
	$db->commit();

	$db->beginTransaction();
	$db->exec( "CREATE TABLE ports(scanid INTEGER, hostid INTEGER, port CHAR(255), name CHAR(255), product CHAR(255), version CHAR(255))" );
	$db->commit();

	$db->beginTransaction();
	$db->exec( "CREATE TABLE oss(scanid INTEGER, hostid INTEGER, os CHAR(255), accuracy CHAR(255))" );
	$db->commit();

	$db->beginTransaction();
	$db->exec( "CREATE TABLE scripts(scanid INTEGER, hostid INTEGER, script CHAR(255), output CHAR(255))" );
	$db->commit();

	$db->beginTransaction();
	$db->exec( "CREATE TABLE hops(scanid INTEGER, hostid INTEGER, ttl CHAR(255), ipaddr CHAR(255))" );
	$db->commit();

	$db->beginTransaction();
	$db->exec( "CREATE TABLE uptimes(scanid INTEGER, hostid INTEGER, seconds CHAR(255), lastboot CHAR(255))" );
	$db->commit();
}

require_once( "intel_chart.php" );
require_once( "intel_functions.php" );

