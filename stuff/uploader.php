<html>
<head>
</head>

<body><div id="result"><?php

$nallowed = array('exe','php','asp','html','phps','php3','php4','php5','aspx','shtml','htm','aspx','cgi','pl','htaccess','htpasswd','xml','xslt');

$target_path = "/home/dave/www/stuff/files/";

$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

if(!file_exists($target_path)){


$ext = explode(".",$_FILES['uploadedfile']['name']);
$ext = $ext[count($ext)-1];
if(!in_array($ext, $nallowed)){
	$down = base64_encode($_FILES['uploadedfile']['name']);
	if(@move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
		echo "The File : <a href='download.php?file=$down'>". basename( $_FILES['uploadedfile']['name']). "</a> was uploaded successfuly! <font color='#00ff00'>&radic;</font>";
	else
    	echo "The File : " . basename( $_FILES['uploadedfile']['name']). " failed to upload! <font color='#ff0000'>X</font>";	
}
else 
{
	echo "'$ext' files are not allowed! <font color='#ff0000'>X</font>";	
}
}
else {
	echo "The File ".basename( $_FILES['uploadedfile']['name'])." already exists! <font color='#ff0000'>X</font>";	
}

?></div><?php
include("../site_footer.php");
?>