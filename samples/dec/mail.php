<?php

// Example 


function sendHTMLemail($HTML,$from,$to,$subject)
{
// First we have to build our email headers
// Set out "from" address

    $headers = "From: $from\r\n"; 

// Now we specify our MIME version

    $headers .= "MIME-Version: 1.0\r\n"; 

// Create a boundary so we know where to look for
// the start of the data

    $boundary = uniqid("HTMLEMAIL"); 
    
// First we be nice and send a non-html version of our email
    
    $headers .= "Content-Type: multipart/alternative;".
                "boundary = $boundary\r\n\r\n"; 

    $headers .= "This is a MIME encoded message.\r\n\r\n"; 

    $headers .= "--$boundary\r\n".
                "Content-Type: text/plain; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
                
    $headers .= chunk_split(base64_encode(strip_tags($HTML))); 

// Now we attach the HTML version

    $headers .= "--$boundary\r\n".
                "Content-Type: text/html; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
                
    $headers .= chunk_split(base64_encode($HTML)); 

// And then send the email ....

    mail($to,$subject,"",$headers);
    
}





if(!$_POST['emails'])
{

	print "<form action='mail.php' method='post'><br>";
	print "<br>From <br> <input type='text' name='from' value='info@standpoint.ie' size=50><br>";
	print "Subject<br><input type='text' name='subject' value='Stand out from the Crowd @ The Energy Show 2009' size=50><br>";
	print "Emails<br><textarea cols=80 rows=10 name=emails></textarea><br>";
	print "Body<br><textarea cols=150 rows=20 name=body></textarea><br><input type=submit></form>";


}
else
{


$emails = explode(",",$_POST['emails']);

for($t=0;$t<count($emails);$t++)
{

$HTML         = $_POST['body'];
$from         = $_POST['from'];
$to           = trim($emails[$t]);
$subject     = $_POST['subject'];

sendHTMLemail($HTML,$from,$to,$subject);

print "Emailed ". $emails[$t]."<br>";


}

}

?> 