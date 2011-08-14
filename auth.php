<?php
	require_once("conf.php");

$regsiterform = "<form action='$_POST[requestUrl]?register=true' method='post'>
		<b> Username </b> <input type='text' name='username'><br><br>
		<b> Password </b> <input type='password' name='password' id='password' onkeyup='return passwordChanged();'> &nbsp;&nbsp;&nbsp;<span id=\"strength\" style='font-size:8pt;'></span><br><br>
		<input type='hidden' name='requestUrl' value='$_POST[requestUrl]'>
		<input type='submit' class='submit' value='Register'><br><br>	
		</form>	";

$ban = "<br><br><center><font style='font-size:16pt;color:#ff0000;'>Banning Policy Notice</font><br><br>Note : For <font style='font-size:10pt;color:#ff0000;'>ssh</font>, <font style='font-size:10pt;color:#ff0000;'>ftp</font> and other private services, a <font style='font-size:10pt;color:#ff0000;'>single failed login attempt</font><br> will result in a <font style='font-size:10pt;color:#ff0000;'>permanent iptables reject</font> of your subnet <font style='font-size:10pt;color:#ff0000;'>permanently</font>.<br>If you get banned accidently, contact me directly.</h3></center>";

	if(!$_POST['requestUrl'])
	{
		$_POST['requestUrl'] = "http://dev.feeditout.com".$_SERVER['REQUEST_URI'];
	}

	$register_message = "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Registration Complete' class='imghead' alt='title' />
			<br>$sitemenu</legend><hr id='headerHr' style='color: #666;background-color: #666;height: 1px;border: 0;'><br><br>";

	$register_message .= "<table cellpadding=50 border=0 width='100%'><tr>

		<td valign='top' width='100%' align='left' style='border-right:1px solid #666666;border-left:1px solid #666666; padding-left:20px;'>
		<div id='resgistration' style='margin-left:120px;'>Thanks for registering, <b>$_POST[username]</b><br><br>
		<img src='http://dev.feeditout.com/letter-image.php?text=L o g i n&size=90x20' class='imghead' alt='login'><br><br>
		<form action='$_POST[requestUrl]' method='post'>
		<b> Username </b> <input type='text' name='username'><br><br>
		<b> Password </b> <input type='password' name='password'><br><br>
		<input type='hidden' name='requestUrl' value='$_POST[requestUrl]'>
		<input type='submit' value='Login'><br><br>
		</form>	
		</div>
		</td>

		</tr><table>$ban";

	$register_message .= "</fieldset>";


	$register_fmessage = "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Registration Failed' class='imghead' alt='title' />
			<br>$sitemenu</legend><hr id='headerHr' style='color: #666;background-color: #666;height: 1px;border: 0;'><br><br>";

	$register_fmessage .= "<table cellpadding=50 border=0 width='100%'><tr>

		<td valign='top' width='50%' align='left' style='border-right:1px solid #666666;border-left:1px solid #666666; padding-left:20px;'>
		<div id='login' style='margin-left:75px;'>
		<img src='http://dev.feeditout.com/letter-image.php?text=L o g i n&size=120x20' class='imghead' alt='Search'><br><br>
		<form action='$_POST[requestUrl]' method='post'>
		<b> Username </b> <input type='text' name='username'><br><br>
		<b> Password </b> <input type='password' name='password'><br><br>
		<input type='hidden' name='requestUrl' value='$_POST[requestUrl]'>
		<input type='submit' class='submit' value='Login'><br><br>
		</form>	
		</div>
		</td>

		<td valign='top' width='50%' align='left' style='border-right:1px solid #666666;'>
		<div id='login' style='margin-left:75px;'><b>Username already taken</b><br><br>
		<img src='http://dev.feeditout.com/letter-image.php?text=R e g i s t e r&size=120x20' class='imghead' alt='Search'><br><br>
		Not for public use
		</div>
		</td>

		</tr><table>$ban";

	$register_fmessage .= "</fieldset>";


	$login_fmessage = "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=login Failed' class='imghead' alt='title' />
			<br>$sitemenu</legend><hr id='headerHr' style='color: #666;background-color: #666;height: 1px;border: 0;'><br><br>";

	$login_fmessage .= "<table cellpadding=50 border=0 width='100%'><tr>

		<td valign='top' width='50%' align='left' style='border-right:1px solid #666666;border-left:1px solid #666666; padding-left:20px;'>
		<div id='login' style='margin-left:120px;'>
		<img src='http://dev.feeditout.com/letter-image.php?text=T r y  A g a i n&size=170x20' class='imghead' alt='login'><br><br>
		<form action='$_POST[requestUrl]' method='post'>
		<b> Username </b> <input type='text' name='username'><br><br>
		<b> Password </b> <input type='password' name='password'><br><br>
		<input type='hidden' name='requestUrl' value='$_POST[requestUrl]'>
		<input type='submit' class='submit' value='Login'><br><br>
		</form>	
		</div>
		</td>
		</tr><table>$ban";

	$login_fmessage .= "</fieldset>";




	$login_message = "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=login' class='imghead' alt='title' />
			<br>$sitemenu</legend><hr id='headerHr' style='color: #666;background-color: #666;height: 1px;border: 0;'><br><br>";

	$login_message .= "<table cellpadding=50 border=0 width='100%'><tr>

		<td valign='top' width='50%' align='left' style='border-right:1px solid #666666;border-left:1px solid #666666; padding-left:20px;'>
		<div id='login' style='margin-left:75px;'>
		<img src='http://dev.feeditout.com/letter-image.php?text=L o g i n&size=120x20' class='imghead' alt='login'><br><br>
		<form action='$_POST[requestUrl]' method='post'>
		<b> Username </b> <input type='text' name='username'><br><br>
		<b> Password </b> <input type='password' name='password'><br><br>
		<input type='hidden' name='requestUrl' value='$_POST[requestUrl]'>
		<input type='submit' class='submit' value='Login'><br><br>
		</form>	
		</div>
		</td>

		<td valign='top' width='50%' align='left' style='border-right:1px solid #666666;'>
		<div id='login' style='margin-left:75px;'>
		<img src='http://dev.feeditout.com/letter-image.php?text=R e g i s t e r&size=120x20' class='imghead' alt='register'><br><br>
		Not for public use
		</div>
		</td>

		</tr><table>$ban";

	$login_message .= "</fieldset>";

	if($_POST['username'] && $_POST['password'] && $_GET['register'])
	{
		$userName = @mysql_real_escape_string($_POST['username']);
		$passWord = md5($_POST['password']);

		$db_pass = count($stream->do_query("select * from users where username='$userName'","array"));
		if($db_pass<1)
		{
			$Name = "$userName"; //senders name
			$email = "$userName@feeditout.com"; //senders e-mail adress
			$recipient = "dave@feeditout.com"; //recipient
			$mail_body = "$userName has signed up on the site..."; //mail body
			$subject = "$userName registered on feeditout"; //subject
			$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields

			ini_set('sendmail_from', 'webmster@feeditout.com'); //Suggested by "Some Guy"

			mail($recipient, $subject, $mail_body, $header); //mail command :)
			$stream->do_query("insert into users values('','$userName','$passWord','1','')","one");
			print $t_header;
			print $register_message;
			include("../site_footer.php");
			exit;	
		}	
		else
		{
			print $t_header;
			print $register_fmessage;
			include("../site_footer.php");
			exit;	
		}
		
	}

	if($_POST['username'] && $_POST['password'] && $_POST['requestUrl'])
	{
		$userName = @mysql_real_escape_string($_POST['username']);
		$passWord = md5($_POST['password']);

		$db_pass = $stream->do_query("select password from users where username='$userName'","one");

		if($db_pass!=$passWord)
		{
			print $t_header;
			print $login_fmessage;
			include("../site_footer.php");
			exit;	
		}	
		else
		{
			$value = $_POST['username'].":".md5($_POST['password']);
			setcookie("feeditoutCookie", $value, time()+100800, "/", ".feeditout.com");
			header("Location: $_POST[requestUrl]");
		}
		
	}

	if($_GET['logout'])
	{
		setcookie("feeditoutCookie", "####", time() - 100800, "/", ".feeditout.com");	
		header("Location: http://dev.feeditout.com/index.php");	
	}

	else if(stristr($_COOKIE["feeditoutCookie"],":"))
	{
		$userInfo = explode(":",$_COOKIE["feeditoutCookie"]);
		$userName = @mysql_real_escape_string($userInfo[0]);
		$passWord = $userInfo[1];
		$userlevel = $stream->do_query("select lvl from users where username='$userName'","one");

		$db_pass = $stream->do_query("select password from users where username='$userName'","one");

		if($db_pass!=$passWord)
		{
			setcookie("feeditoutCookie", $value, time()-100800, "/", ".feeditout.com");
			print $t_header;
			print $login_message;
			include("../site_footer.php");
			exit;
		}	
		else
		{
			$thetime = time();
			$update = $stream->do_query("update users set activity='$thetime' where username='$userName'","one");
			$value = $userInfo[0].":".$passWord;			
			setcookie("feeditoutCookie", $value, time()+100800, "/", ".feeditout.com");
		}
	}
	else
	{
		print $t_header;
		print $login_message;
		@include("../site_footer.php");
		@include("site_footer.php");
		
		exit;
	}
