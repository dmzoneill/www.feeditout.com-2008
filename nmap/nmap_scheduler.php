<?php

require_once( "conf.php" );

function linux_schedule()
{
	$time = time();

	$command1 = "crontab -l > ./tempCronLynx$time.txt &";
	exec($command1);
	chmod ( "./tempCronLynx$time.txt" , 0777 );
	sleep(1);

	$forFile = "10 * * * * /home/dave/www/nmap/nmap_start.sh 2>&1 \n*/15 * * * * lynx -dump http://www.feeditout.com/index.php > /dev/null 2>&1 \n";

	$fp1 = fopen( "./tempCronLynx$time.txt", "r" );
	$crons = fread( $fp1 , filesize("./tempCronLynx$time.txt") );
	fclose( $fp1 );

	$forFile .= $crons;

	$fp2 = fopen( "./tempCronLynx2$time.txt", "w" );
	fwrite( $fp2 , $forFile );
	fclose( $fp2 );

	$command1 = "crontab tempCronLynx2$time.txt ";
	exec( $command1 );
	echo "Scheduled Sucessfully.";

}


function windows_schedule()
{
	$command1 = "at 00:00 /every:M,T,W,Th,F,S,Su \"C:\\Program Files\\nmap\\nmap.exe\" c:\\inetpub\\wwwroot\\nmap_scanner.php";
	exec( $command1 );
	echo "Scheduled Sucessfully.";

}

crontab();
