<?php

	include("conf.php");

	function mailer()
	{
		global $stream;

		$imap = imap_open("{mail.feeditout.com:143/imap/notls}INBOX", "catch-all@feeditout.com", "qw12qw12");
		$messages = imap_sort($imap, SORTFROM, 1);

		foreach ($messages as $message) {
			
			$header = imap_header($imap, $message);
			$limit = time();
			$fake = explode("@",$header->toaddress);
			$fake = $fake[0];
			$to = $stream->do_query("SELECT actual FROM mailaddresses WHERE fake='$fake' AND timeout > '$limit' ORDER BY id DESC","one");
			if(stristr($to,'@'))
			{	
				
				$full = imap_fetchheader($imap, $header->Msgno);
				$full = eregi_replace($header->toaddress, $to, $full);
				$body = imap_body($imap, $header->Msgno);
	
				if(mail($to, $header->subject, $body, $full))
				{
					imap_delete($imap, $header->Msgno);
					print "Emailed : $to\n";
				}				
			}

		}

		imap_expunge($imap);
		imap_close($imap);
		
	}

	function cleanEmailList()
	{
		global $stream;
		$limit = time();
		$to = $stream->do_query("DELETE FROM mailaddresses where timeout<$limit","one");
	}


	mailer();
	cleanEmailList();

?>

