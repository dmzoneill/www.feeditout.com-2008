<?php

if($userlevel<=1 && $_GET['requesturl']=="true")
{
	print "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Account Authorization' class='imghead' alt='picture' /><br>$sitemenu</legend>
		<hr style='color: #666;background-color: #666;height: 1px;border: 0;'><br>
		<div width='100%' id='gallery' class='shown' style='border-left:1px solid #666666; border-right:1px solid #666666;padding:10px;'>";
		
		$Name = "$userName"; //senders name
		$email = $_GET['email']; //senders e-mail adress
		$recipient = "dave@feeditout.com"; //recipient
		$mail_body = "$userName requested higher access level..."; //mail body
		$subject = "$userName requested higher access level"; //subject
		$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields

		ini_set('sendmail_from', 'webmster@feeditout.com'); //Suggested by "Some Guy"

		mail($recipient, $subject, $mail_body, $header); //mail command :)

		print "Processing request, you will be contacted shorlty..";

		print "	</div></fieldset>";
	include("../site_footer.php");	
	exit;
}

	

if($userlevel<=1)
{
	print "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Account Authorization' class='imghead' alt='picture' /><br>$sitemenu</legend>
		<hr style='color: #666;background-color: #666;height: 1px;border: 0;'><br>
		<div width='100%' id='gallery' class='shown' style='border-left:1px solid #666666; border-right:1px solid #666666;padding:10px;'>";
		print "Sorry $userName ($userlevel) but these gallerys are private, if your a friend you can request access.<br><br> Its simple just put your email address in here for account confirmation.<br><br>
		<input type='text' id='request_email'><br><br><input type='button' value='Request access' onclick=\"request_access();\">
		
	</div></fieldset>";
	include("../site_footer.php");	
	exit;
}


?>