<?php
include_once('simple_html_dom.php');

class ConkyOptions
{
	public $lua;
	public $settings;
	public $variables;

	function ConkyOptions()
	{
		$html = file_get_html('http://conky.sourceforge.net/variables.html');
		foreach($html->find('tr') as $variable) 
		{
			$item = array();

			foreach($variable->find('td') as $details) 
			{
				$details = eregi_replace("\n", " ", trim(strip_tags($details->innertext)));
				$details = eregi_replace(" +", " ", $details);		
				array_push($item, $details);	
			}
			if(count($item) > 0)
			{	
				$conky_variables[] = $item;
			}
		}
		$this->variables = $conky_variables;


		$html = file_get_html('http://conky.sourceforge.net/config_settings.html');
		foreach($html->find('tr') as $variable) 
		{
			$item = array();

			foreach($variable->find('td') as $details) 
			{
				$details = eregi_replace("\n", " ", trim(strip_tags($details->innertext)));
				$details = eregi_replace(" +", " ", $details);		
				array_push($item, $details);	
			}
			if(count($item) > 0)
			{	
				$conky_config_settings[] = $item;
			}
		}		
		$this->settings = $conky_config_settings;


		$html = file_get_html('http://conky.sourceforge.net/lua.html');
		foreach($html->find('tr') as $variable) 
		{
			$item = array();
			foreach($variable->find('td') as $details) 
			{
				$details = eregi_replace("\n", " ", trim(strip_tags($details->innertext)));
				$details = eregi_replace(" +", " ", $details);		
				array_push($item, $details);	
			}
			if(count($item) > 0)
			{	
				$conky_lua[] = $item;
			}
		}
		$this->lua = $conky_lua;		
	}

	
	public function searchVariables($str)
	{
		$results;
		foreach ($this->variables as &$value) 
		{			
			if(stristr($value[0],$str) || stristr($value[1],$str) || stristr($value[2],$str))
			{
				$results[] = $value;
			}
		}
		return $results;
	}


	public function searchSettings($str)
	{
		$results;
		foreach ($this->settings as &$value) 
		{			
			if(stristr($value[0],$str) || stristr($value[1],$str))
			{
				$results[] = $value;
			}
		}
		return $results;
	}


	public function searchLua($str)
	{
		$results;
		foreach ($this->lua as &$value) 
		{			
			if(stristr($value[0],$str) || stristr($value[1],$str) || stristr($value[2],$str))
			{
				$results[] = $value;
			}
		}
		return $results;
	}


	public function printDetails()
	{
		print count($this->lua) . " lua settings \n";
		print count($this->settings) . " config settings \n";
		print count($this->variables) . " variables \n";		
	}
}


class ConkyEditor extends ConkyOptions
{
	private $conkySettings;
	private $conkyMarkup;
	
	function ConkyEditor()
	{
		$this->loadConkyMarkup();
		parent::ConkyOptions();
	}


	private function loadConkyMarkup()
	{
		if(!file_exists("/home/dave/www/conky/temp"))
		{
			$fp = fopen("/home/dave/www/conky/temp",'w');
			$fp1 = fopen("/home/dave/www/conky/default",'r');
			fwrite($fp,fread($fp1,filesize("/home/dave/www/conky/default")));
			fclose($fp);
			fclose($fp1);
		}		
		
		$file = fopen("/home/dave/www/conky/temp","r");
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
				continue;

			if($break == 0)
				$config[] = $line;
			else
				$markup[] = $line;
		}

		fclose($file);

		$this->conkySettings = $config;
		$this->conkyMarkup = $markup;
	}


	public function getConkyMarkup()
	{
		return $this->conkyMarkup;
	}


	public function getConkySettings()
	{
		return $this->conkySettings;
	}
	

	public function testbed()
	{
		$results = parent::searchVariables("xmms2");
		foreach($results as &$val)
		{
			print $val[0] . "\n";
		}

		$results = parent::searchSettings("xft");
		foreach($results as &$val)
		{
			print $val[0] . "\n";
		}

		$results = parent::searchLua("build");
		foreach($results as &$val)
		{
			print $val[0] . "\n";
		}
	}	
}


class ConkyDisplayer extends ConkyEditor
{
	private $conkyHtml;	

	function ConkyDisplayer()
	{
		parent::ConkyEditor();
		print_r(parent::getConkyMarkup());
	}	
}


$conky = new ConkyDisplayer();


?>
