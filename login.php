<?php

include("conf.php");


if($_GET['logout'])
{
$session_time = time() - 36000;
setcookie("site_cookie", $data, $session_time, "/", ".feeditout.com");
print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Untitled Document</title>
</head>
<body>
<div id='result'>You have been successfully logged out, <a href=\"javascript:reset_logon()\">login Again?</a></div>
<div id='resultid'>$usr_msgid</div>
</body>
</html>";

exit;
}

$tryagain = "<a href=\"javascript:reset_logon()\">Try Again</a>";

if($_POST['user_login_user'] && $_POST['user_login_pass']){

	$pass = mysql_real_escape_string(md5($_POST['user_login_pass']));
	$user = mysql_real_escape_string($_POST['user_login_user']);

	if(count($stream->do_query("select * from users where username='$user'","array"))>0){
		$info = $stream->do_query("select * from users where username='$user'","array");
		$tmp = $info[0];
		$iid = $tmp[0];
		$iuser = $tmp[1];
		$ipass = $tmp[2];
		
		if($ipass == $pass)
		{
			$data = "$user:$pass";
			$session_time = time() + 36000;
			if(setcookie("site_cookie", $data, $session_time, "/", ".feeditout.com"))
			{
				$usr_msg = "Welcome $user, You have been successfully logged in. <a href=\"javascript:user_logout('1')\">Logout</a>";
				$usr_msgid = 0;
			}
			else 
			{
				$usr_msg = "Cookies my man, cookies!";
			}
		}
		else 
		{
			$usr_msg = "Password incorrect $tryagain";
			$usr_msgid =1;
		}
		
	}
	else {
		$usr_msg = "That User does not exist $tryagain";
		$usr_msgid = 2;
	}


}
else 
{
	$usr_msg = "Your login credentials where not received $tryagain";
	$usr_msgid = 3;
}


print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Untitled Document</title>
</head>
<body>
<div id='result'>$usr_msg</div>
<div id='resultid'>$usr_msgid</div>
</body>
</html>";

?>