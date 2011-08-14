<?php

$file = fopen("/home/dave/.conky/light/human/.conkyrc","r");

$break = 0;

while(!feof($file))
{
	$line = fgets($file);

	if(trim($line) == "TEXT")
	{
		$break = 1;
		continue;
	}

	if(substr(trim($line),0,1) == "#")
	{
		continue;
	}

	if(trim($line) == "")
	{
		continue;
	}

	if($break == 0)
	{
		$config[] = $line;
	}
	else
	{
		$markup[] = $line;
	}	
}

fclose($file);

print_r($config);

print_r($markup);



?>