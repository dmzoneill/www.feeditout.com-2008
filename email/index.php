<?php

require_once("../conf.php");

	if($_GET['fakemailcheck'])
	{	
		print checkMailAddress($_GET['fakemailcheck']);	
		exit;
	}

	if($_GET['fakemail'] && $_GET['realmail'])
	{		
		print addMailAddress($_GET['fakemail'],$_GET['realmail'],$_GET['hours'],$_GET['days']);		
		exit;
	}

include("../site_header.php");

?>
<script type="text/javascript">
changetitle('Email Forwarding');
</script>
</head>
<body>
<?php

print "<fieldset><legend><img src='http://dev.feeditout.com/image.php?text=Email' class='imghead' alt='title' /><br>$sitemenu</legend><hr style='color: #666;background-color: #666;height: 1px;border: 0;'>";


?>
<table width='100%'><tr>
<div>
<div class='shown' id='setup'>
<table cellpadding='10'>
<TR><TD colspan='2'>Step 1 :</td></tr>
<tr><TD>Fake Email Address : </td><td> <input id="mailchecker" type="text" style="width:350px;" onkeypress='javascript:doMailCheck();'/> @feeditout.com <div id='avail'></div></td></tr>

<TR><TD colspan='2'>Step 2 :</td></tr>
<tr><TD>Your Email Address : </td><td> <input id="realmail" type="text" style="width:350px;"/></td></tr>

<TR><TD colspan='2'>Step 3 :</td></tr>
<tr><TD>Expire in : </td><td> <select id='emaildays' name='emaildays'>
<?php

for($x=0;$x<366;$x++)
{
	print "<option value='$x' ";
	if($x==0) print "selected";
	print ">$x days(s)</option>";

}

?>
</select> Days
<select id='emailtime' name='emailtime'>
<?php

for($x=0;$x<25;$x++)
{
	print "<option value='$x' ";
	if($x==12) print "selected";
	print ">$x hour(s)</option>";

}

?>
</select> Hours
</TD></TR>

<TR><TD colspan='2'>Finish :</td></tr>
<tr><TD></td><td> <input type='button' onclick='javascript:addmail();' value='Submit'></td></tr>

</table>
</div>

<div class=='hidden' id='confirmation'></div>



</td></tr></table><br />

</fieldset>

<?php

include("../site_footer.php");
?>
