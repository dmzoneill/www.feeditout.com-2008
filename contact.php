<?php
session_start();
include("conf.php");
include("site_header.php");

?>
<script type="text/javascript">
changetitle('Contact');
</script>
</head>
<body onLoad="return focuson();">
<script type="text/javascript" language="javascript">
function focuson()
{ 
	if(document.getElementById('thef'))
	{
		document.form1.number.focus();
	}
}

function check()
{
	if(document.form1.number.value==0)
	{
		alert("Please enter the Validation string");
		document.form1.number.focus();
		return false;
	}
}

</script>
<?php


function conform(){

echo <<< EOH
<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Contact' alt='contact' class='imghead' /></legend><br /><br />
<form id='thef' name='form1' action='contact.php' method='post'  onsubmit="return check();">
<table>
<tr><td width='150'>Name</td><td colspan="2"><input type='text' name='m_name' value='$_POST[m_name]'/><br /></td></tr>
<tr><td width='150'>Email Address</td><td colspan="2"><input type='text' name='m_email' value='$_POST[m_email]' /><br /></td></tr>
<tr><td width='150'>Subject</td><td colspan="2"><input type='text' name='m_sub' value='$_POST[m_sub]' /><br /></td></tr>
<tr><td width='150'>Message</td><td colspan="2"><textarea rows='10' cols='60' name='m_msg'>$_POST[m_msg]</textarea><br /></td></tr>
<tr><td width='150'>Validation string</td><td><input name="number" type="text" align="middle" id='number' /></td><td align="left"><img src="php_captcha.php" alt='security string' class='imghead' /></td></tr>
<tr><td width='150'>&nbsp;</td><td colspan="2"><input class='submit' name="Submit" type="submit" value='Feed It Out' /></td></tr>
</table>
</form>

</fieldset>
EOH;

}

$error = "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Feedback Error' alt='error' class='imghead' /></legend><br /><br />Look if your not going to fill out the form correctly, then i'm not going to take you seriously.<br /><br />I'm also not going to tell you where you went wrong because if you can't fill that form correctly, then i really don't care what you have to say! <br /><br />Your message has not been sent!<br /><br /></fieldset>";

$error2 =  "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Validation Error' class='imghead'></legend><br /><br />
		   Validation string was incorrect, please go back and try again! <br /><br /></fieldset>";

if(isset($_REQUEST['Submit']))
{
	$key=substr($_SESSION['key'],0,5);
	$number = $_REQUEST['number'];
    
	if($number==$key)
	{
		if($_POST['m_name'] && $_POST['m_email'] && $_POST['m_sub'] && $_POST['m_msg'])
		{

			if(stristr($_POST['m_email'],"@"))
			{
				if(strlen($_POST['m_sub'])>3)
				{
					if(strlen($_POST['m_msg'])>5)
					{
						$to      = "dave@feeditout.com";
						$subject = "$_POST[m_sub]";
						$message = "$_POST[m_msg]";
						$headers = "From: $_POST[m_email]";

						mail($to, $subject, $message, $headers);
					?>
						<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Feedback Received' alt='success' class='imghead' /></legend>
						<br /><br />
						Thanks for feeding it out, i might reply shortly!
						<br /><br />
						</fieldset>	
						<?php 
						include("site_footer.php");
						exit;
					}
					else { print $error; conform(); include("site_footer.php"); exit;}
				}
				else { print $error; conform(); include("site_footer.php"); exit;}
			}
			else { print $error; conform(); include("site_footer.php"); exit;}
		}
		else { print $error; conform(); include("site_footer.php"); exit;}
	} 
	else { print $error2; conform(); include("site_footer.php"); exit;}
}
else 
{
echo <<< EOH


<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Feeditout Synopsis' alt='synopsis' class='imghead' /><br>$sitemenu</legend>
<hr id='headerHr' style='color: #666;background-color: #666;height: 1px;border: 0;'>\n
<br />
Feeditout.com was initially set up 02/26/2003 as a get well card for a friend who had a serious bike accident.<br /> Since then feeditout has gone through many different changes.<br /><br />Feeditout today is a playground for my boredom,<br /> a place where i can try out new web technologies and keep content available to me from anywhere on the globe.<br /><br />I also host friends websites<br /><br />
Feeditout is not in the business of actively sharing copyrighted materials to any and all,<br /> but i do acknowledge the fact that this may be true in some cases<br /><br />If anybody has a problem with '<b>named</b>' content,<br /> please free to contact me and i will '<b>secure/remove</b>' any offending materials.<br /><br />
<p>
<a href="http://jigsaw.w3.org/css-validator/">
    <img src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!" class='imghead' />
</a>
<a href="http://validator.w3.org/check?uri=referer">
	<img src="http://www.w3.org/Icons/valid-xhtml10-blue" alt="Valid XHTML 1.0 Transitional" class='imghead' />
</a>
  </p></fieldset>

EOH;
	conform();
}	 
	 

include("site_footer.php");
?>