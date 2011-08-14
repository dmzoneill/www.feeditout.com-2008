<?php

class Pstools
{
	
	
	private $settings = array();
	private $error;
	private $result = array();
	private $command;
		
	
	
	public function __construct()
	{
				
	}
	
	
	
	public function __get( $var )
	{
		print "get " . $var;
		if( isset( $this->settings[ $var ] ) )
		{
			print "get " . $this->settings[ $var ];
			return $this->settings[ $var ];
		}
		else
		{
			return NULL;
		}
	}
	
	
	
	public function __set( $var , $value )
	{
		$this->settings[ $var ] = $value;		
	}
	
	
	
	public function getError()
	{
		return $this->error;		
	}
	
	
	
	public function getResult()
	{
		return $this->result;		
	}
	
	
	
	private function execute( &$out , &$retval )
	{
		$return_var = 0;
		$ret = exec( $this->command , $out , $return_var );		
		$out[] = $ret;
		$retval = $return_var;		
		return true;				
	}
	
	
	
	public function psexec( &$out , &$retval )
	{
		$a = isset( $this->settings[ 'a' ] ) ? $this->settings[ 'a' ] : NULL;
		$c = isset( $this->settings[ 'c' ] ) ? $this->settings[ 'c' ] : NULL;
		$d = isset( $this->settings[ 'd' ] ) ? $this->settings[ 'd' ] : NULL;
		$e = isset( $this->settings[ 'e' ] ) ? $this->settings[ 'e' ] : NULL;
		$f = isset( $this->settings[ 'f' ] ) ? $this->settings[ 'f' ] : NULL;
		$i = isset( $this->settings[ 'i' ] ) ? $this->settings[ 'i' ] : NULL;
		$h = isset( $this->settings[ 'h' ] ) ? $this->settings[ 'h' ] : NULL;
		$l = isset( $this->settings[ 'l' ] ) ? $this->settings[ 'l' ] : NULL;
		$n = isset( $this->settings[ 'n' ] ) ? $this->settings[ 'n' ] : NULL;
		$p = isset( $this->settings[ 'p' ] ) ? $this->settings[ 'p' ] : NULL;
		$s = isset( $this->settings[ 's' ] ) ? $this->settings[ 's' ] : NULL;
		$u = isset( $this->settings[ 'u' ] ) ? $this->settings[ 'u' ] : NULL;
		$v = isset( $this->settings[ 'v' ] ) ? $this->settings[ 'v' ] : NULL;
		$w = isset( $this->settings[ 'w' ] ) ? $this->settings[ 'w' ] : NULL;
		$x = isset( $this->settings[ 'x' ] ) ? $this->settings[ 'x' ] : NULL;	
		$priority = isset( $this->settings[ 'priority' ] ) ? $this->settings[ 'priority' ] : NULL;
		$computer = isset( $this->settings[ 'computer' ] ) ? $this->settings[ 'computer' ] : NULL;
		$file = isset( $this->settings[ 'file' ] ) ? $this->settings[ 'file' ] : NULL;
		$program = isset( $this->settings[ 'program' ] ) ? $this->settings[ 'program' ] : NULL;
		$arguments = isset( $this->settings[ 'arguments' ] ) ? $this->settings[ 'arguments' ] : NULL;
		
		if( !isset( $computer ) )
		{
			$this->error = "No target computer specified";
			return false;
		}
		
		if( isset( $c ) && !file_exists( "temp/" . $c ) )
		{
			$this->error = "Copy specified program failed as program does not exist 'temp/" . $c . "'";
			return false;
		}
		
		if( !isset( $c ) && isset( $f ) )
		{
			$this->error = "Force copy failed as there was no program specified";
			return false;
		}
		
		if( isset( $c ) && isset( $program ) )
		{
			$this->error = "Specify either a program to transfer over or a program to execute on the remote machine";
			return false;
		}	

		$command = "psexec \\\\$computer ";
		$command .= ( $a != NULL ) ? "-a " . $a : "";
		$command .= ( $c != NULL ) ? "-c " . $c : "";
		$command .= ( $d != NULL ) ? "-d " . $d : "";
		$command .= ( $e != NULL ) ? "-e " . $e : "";
		$command .= ( $f != NULL ) ? "-f " . $f : "";
		$command .= ( $i != NULL ) ? "-i " . $i : "";
		$command .= ( $h != NULL ) ? "-h " . $h : "";
		$command .= ( $l != NULL ) ? "-l " . $l : "";
		$command .= ( $n != NULL ) ? "-n " . $n : "";
		$command .= ( $p != NULL ) ? "-p " . $p : "";
		$command .= ( $s != NULL ) ? "-s " . $s : "";
		$command .= ( $u != NULL ) ? "-u " . $u : "";
		$command .= ( $v != NULL ) ? "-v " . $v : "";
		$command .= ( $w != NULL ) ? "-w " . $w : "";
		$command .= ( $x != NULL ) ? "-x " . $x : "";
		$command .= ( $priority != NULL ) ? "-priority " . $priority : "";
		$command .= ( $file != NULL ) ? "@file " . $file : "";
		$command .= ( $program != NULL ) ? $program : "";
		$command .= ( $arguments != NULL ) ? $arguments : "";
		
		$this->command = $command;
		
		return $this->execute( $out , $retval );
	}

	
	
	public function psfile( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}

	
	
	public function psinfo( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}
	
	
	
	public function pslist( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}
	
	
	
	public function psloglist( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}
	
	
	
	public function psservice( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}
	
	
	
	public function pssuspend( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}
	
	
	
	public function psgetsid( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}
	
	
	
	public function pskill( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}
	
	
		
	public function psloggedon( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}
	
	
	
	public function pspasswd( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}
	
	
	
	public function psshutdown( &$out , &$retval )
	{
		return $this->execute( $out , $retval );
	}	

		
}