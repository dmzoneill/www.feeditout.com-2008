<?php

function is_admin()
{
	global $stream;
	if($_COOKIE['site_cookie'])
	{
		$data = explode(":",$_COOKIE['site_cookie']);
		$user = mysql_real_escape_string($data[0]);
		$pass = $data[1];
				
		$info = $stream->do_query("select * from users where username='$user'","array");
		$tmp = $info[0];
		$iid = $tmp[0];
		$iuser = $tmp[1];
		$ipass = $tmp[2];
		$lvl = $tmp[3];
		
		if($ipass==$pass)
		{
			if($lvl=="5"){
				return 1;
			}
			else {
				return 0;
			}
		}
		else {
			return 0;
		}
	}
	else {
		return 0;
	}
}


function playDirectory( $path = '/home/.ornice/proxykillah/feeditout.com/music', $level = 4 ){
		global  $playlist_all,$entries,$pls_all,$ignore;
   
    $dh = @opendir( $path );
   while( false !== ( $file = readdir( $dh ) ) ){
		$files[] = $file;
	}
	closedir($dh);
	sort($files);
	reset($files);

	foreach($files as $k => $file) { 
        if( !in_array( $file, $ignore ) ){
            if( is_dir( "$path/$file" ) ){
                playDirectory( "$path/$file", ($level+1) );
        	 }    
			 else {
			 if(!stristr($file,".mp3")) {
				 continue;
			 }
			  require_once('/home/.ornice/proxykillah/feeditout.com/music/getid3/getid3.php');
			$getID3 = new getID3;
			$ThisFileInfo = $getID3->analyze("$path/$file");
			getid3_lib::CopyTagsToComments($ThisFileInfo);
			  
			  $tr_title = "";
			  if(strlen($ThisFileInfo['tags']['id3v2']['title'][0])>2){
			  	 $tr_title = $ThisFileInfo['tags']['id3v2']['title'][0];
			  }
			  else {
			  	$tr_title = $ThisFileInfo['tags']['id3v1']['title'][0];
			  }
			  if(stristr($path,"feeditout.com/music")){
			  	$nwpath = explode("feeditout.com/music",$path);
				$nwpath = ".".$nwpath[1];
			  }
			  else {
			  	$nwpath = $path;
			  }
			  $pls_all = $pls_all ."File$entries=http://music.feeditout.com/$nwpath/$file\n";
			  $entries++;
			  $playlist_all .="<track>\n
            <location>$nwpath/$file</location>\n
            <title>$tr_title</title>\n
            <creator>". $ThisFileInfo['comments_html']['artist'][0] ."</creator>\n
            <image>mp3/demo.jpg</image>\n
        </track>\n";
			 }
        }    
    }    
}


function getDirectory( $path = '.', $level = 2 ){
	
	global $total_size_list, $total_files, $playlist_all,$ignore;
    $dh = @opendir( $path );
   while( false !== ( $file = readdir( $dh ) ) ){
		$files[] = $file;
	}
	closedir($dh);
	sort($files);
	reset($files);

	foreach($files as $k => $file) { 
        if( !in_array( $file, $ignore ) ){
            $spaces = str_repeat( '&nbsp;', ( $level * 4 ) );
            if( is_dir( "$path/$file" ) ){
           	 echo "$spaces <a href=\"javascript:musicloadurl('index.php?f=$path/$file','$file')\">$file</a><br />\n";
                getDirectory( "$path/$file", ($level+1) );
        	 }    
			 else {
			 	 if(!stristr($file,".mp3")) {
				 	continue;
				 }
			 	$total_files = $total_files + 1;
				$total_size_list = $total_size_list + filesize("$path/$file");
			 }
        }    
    }    
}


function getFiles( $path, $level){
ob_start('ob_gzhandler');
global $ignore,$stream;
//print "<hr /><br /><table><tr><td valign=top align=center><div style='margin-left:20px;' id=\"flashcontent\" align=\"left\">	</div><br /><br /><a href='$path/playlist.pls'>Download Playlist</a></td><td>";
	if(stristr($path,"/")) {
		$textd = explode("/",$path);
		$textb = count($textd) -1;
		$textd = base64_encode($textd[$textb]);
	}else {
		$textd = base64_encode($path); 
	}
	if(count(@$stream->do_query("select * from logs_music where album='$textd'","array"))>0){
		$hits = @$stream->do_query("select hits from logs_music where album='$textd'","one") +1;
		@$stream->do_query("update logs_music set hits='$hits' where album='$textd'","one");
	}
	else {
		@$stream->do_query("insert into logs_music values('','$textd','1')","one");
	}
	
	$entries = 1;
	$pls_all = "";	
	$xml= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n
	<playlist version=\"1\" xmlns = \"http://xspf.org/ns/0/\">\n
    <trackList>\n";

    $dh = @opendir( $path );
	$t=0;
	
	while( false !== ( $file = readdir( $dh ) ) ){
		$files[] = $file;
	}
	closedir($dh);
	sort($files);
	reset($files);
	echo "<table cellpadding='1' border='0' width='800'>\n";
	$total = 0;
	foreach($files as $k => $file) { 
        if( !in_array( $file, $ignore ) ){
            $spaces = str_repeat( '&nbsp;', ( $level * 4 ) );
            if( is_dir( "$path/$file" ) ){
           	     echo "$spaces <a href=\"javascript:musicloadurl('index.php?f=$path/$file','$file')\">$file</a><br />\n";
        	 } else {
			 if(!stristr($file,"mp3")){
// jj
			 }
			 else {
			 $size = filesize("./$path/$file") ;
			 
			 $total = $total + $size;
			 $kb_size = round($size / 1024) ;
			 if($kb_size>1024){
			 	$type_size = round(($kb_size / 1024),2) . " mb";
			 }
			 else {
			 	$type_size = $kb_size . " kb";
			 }
			  
			  require_once('/home/.ornice/proxykillah/feeditout.com/music/getid3/getid3.php');
			$getID3 = new getID3;
			$ThisFileInfo = $getID3->analyze("./$path/$file");
			getid3_lib::CopyTagsToComments($ThisFileInfo);
			
			 $tr_title = "";
			  if(strlen($ThisFileInfo['tags']['id3v2']['title'][0])>2){
			  	 $tr_title = $ThisFileInfo['tags']['id3v2']['title'][0];
			  }
			  else {
			  	$tr_title = $ThisFileInfo['tags']['id3v1']['title'][0];
			  }
			  $pls_all = $pls_all ."File$entries=http://music.feeditout.com/$path/$file\n";
			  $entries++;
			  $xml.="<track>\n
            <location>$path/$file</location>\n
            <title>$tr_title</title>\n
            <creator>". $ThisFileInfo['comments_html']['artist'][0] ."</creator>\n
            <image>mp3/demo.jpg</image>\n
        </track>\n";
			




		
            	 echo "<tr><td align='left' width='150'>$spaces $type_size</td><td align='left' width='50'>". $ThisFileInfo['playtime_string']  ."</td>
				 <td align='left' width='110'>". $ThisFileInfo['audio']['bitrate_mode'] ." ". round($ThisFileInfo['audio']['bitrate'] / 1000) ." kbps</td><td align='left'> <a href='$path/$file'>". $ThisFileInfo['comments_html']['artist'][0] ."  - $tr_title</a><br /></td>";
				 //echo "<td><a href=\"javascript:EP_loadMP3('ep_player', '<location>$path/$file</location><creator>".$ThisFileInfo['comments_html']['artist'][0]."</creator><title>".$tr_title."</title>');\">Add to playlist</a></td>";
				 echo "</tr>\n";
				 }
            }        
        }    
    }    
	
	$xml.="</trackList>\n
</playlist>\n";
	
	$entries--;
	$pls_all = "[playlist]\nNumberOfEntries=$entries\n$pls_all";

$handle = fopen("$path/playlist.pls","w");
fwrite($handle,$pls_all);
fclose($handle);	

	
	$handle = fopen("$path/playlist.xml","w");
fwrite($handle,$xml);
fclose($handle);

	$show_play = filesize("$path/playlist.xml");
	
	$total = round(($total / 1024) /1024,2);
	
			$pathn = md5($path);
	 $name = "album-".$pathn.".tar";
	 if($total >150) $dt = "Sorry Alittle too big for an archive! $total megs";
	 else $dt = "<a href='downloads/$name'>".$ThisFileInfo['comments_html']['artist'][0]." - ".$ThisFileInfo['comments_html']['album'][0] ." [$total megs]</a>";
	 	
	
	if($show_play>139){
	print "<tr><td colspan='4'>&nbsp;</td></tr><tr><td colspan='4'>$spaces Genre : ". $ThisFileInfo['comments_html']['genre'][0] ."<br /><br />$spaces Download :  $dt</td></tr>\n";
	print "<tr><td colspan='4'>&nbsp;</td></tr><tr><td colspan='4'>$spaces Play : <a href=\"javascript:EP_loadPlayList('ep_player', '$path/playlist.xml');\">Load Album In Player</a></td></tr>\n";
	print "<tr><td colspan='4'>&nbsp;</td></tr><tr><td colspan='4'>$spaces Stream : <a href='$path/playlist.pls'>Download Playlist</a></td></tr>\n";
	print "<tr><td colspan='4'>&nbsp;</td></tr><tr><td colspan='4'></td></tr>\n";
	}
	
	print "</table><script language='javascript' type='text/javascript'>\n <!-- \n";
	print "function loadartistalbum(){\n";
	print "EP_loadPlayList('ep_player', '$path/playlist.xml');\n";
	print "}\n //-->\n</script>";
		
		
		if($show_play>139){

	 if(!file_exists("downloads/$name")){
	 if($total <150){
	 	$bah = shell_exec("tar -czvf 'downloads/$name' '$path'");
		}
	 }
	}
		

	
}


function ftpmanager(){
	ob_start('ob_gzhandler');
	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	if(stristr($user_agent,"konqueror") || stristr($user_agent,"macintosh") || stristr($user_agent,"opera"))
	{
		echo '<applet name="Rad FTP"
				archive="ftpicons.zip,ftp.jar"
				code="com.radinks.ftp.FTPApplet"
				width="710"
				height="412">
			 </applet>';
	}
	else
	{
		if(strstr($user_agent,"MSIE"))
		{
			echo '<object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93"
				width= "710" height= "412"
				codebase="http://java.sun.com/products/plugin/autodl/jinstall-1_4-windows-i586.cab#version=1,4,2">';

		} 
		else 
		{
			echo '<object type="application/x-java-applet;version=1.4.2"
				width= "710" height= "412" >';
		}
		
		echo '<param name="archive" value = "ftpicons.zip,ftp.jar">
				<param name="code" value = "com.radinks.ftp.FTPApplet.class">
				<param name="name" value = "Rad FTP Applet">
				<param name="bgcolor" value = "#E0E0E0">
				';
			
		echo '</object>';
	}
}


function project_listing( $path = '.', $level = 0 ){

    $ignore = array( 'cgi-bin', '.', '..','downloads' );
    $dh = @opendir( $path );
    
    while( false !== ( $file = readdir( $dh ) ) ){
    
        if( !in_array( $file, $ignore ) ){
            
            $spaces = str_repeat( '&nbsp;', ( $level * 2 ) );
            
            if( is_dir( "$path/$file" ) ){
      
                echo "<strong>$spaces $file</strong><br />";
               project_listing( "$path/$file", ($level+1) );
           
            } else {
            	$projfile =base64_encode($path."/".$file);
				$ext = explode(".",$file);
				$num = count($ext) -1;
				$ext = $ext[$num];
				if($ext=="exe" || $ext=="png" || $ext=="ico" || $ext=="db" || $ext=="txt" || $ext=="cache" || $ext=="Cache" || $ext=="dll" || $ext=="resources" || $ext=="gif" || $ext=="suo" || $ext=="pyc" || $ext=="bak" || $ext=="pdb") continue;
                echo "$spaces <a href=\"javascript:loadprojectfile('index.php?p_code=$projfile')\">$file</a><br />";
                // Just print out the filename
            
            }
        
        }
    
    }
    
    closedir( $dh );
    // Close the directory handle
} 

$p_divs = 0;

function projects_list( $path = '.', $level = 0 ){
	global $p_divs;
    $ignore = array( 'cgi-bin', '.', '..','downloads','geshi','code' );
    $dh = @opendir( $path );
    
    while( false !== ( $file = readdir( $dh ) ) ){
    
        if( !in_array( $file, $ignore ) ){
            
            $spaces = str_repeat( '&nbsp;', ( $level * 4 ) );
            if($level>1) continue;
            if( is_dir( "$path/$file" ) ){
      			if($level==0)
				{
					echo "<strong>$spaces $file</strong><br />\n";
				}
				else {
					$projdiv =base64_encode($path."/".$file);
                	echo "<strong>$spaces <a href=\"javascript:loadprojectmenu('$projdiv','index.php?project=$projdiv');\">$file</a></strong>\n";
					echo "<br /><div style='margin-left:30px;' id='$projdiv'></div>\n";
					print "<script language='javascript'> \n project_divs[$p_divs] = \"$projdiv\"; \n </script>";
					$p_divs = $p_divs + 1;
					
				}
                projects_list( "$path/$file", ($level+1) );
           
            }         
        }
    
    }
    
    closedir( $dh );
    // Close the directory handle

} 


function addMailAddress($fake,$real,$hours,$days)
{
	global $stream;
		
	if(!$stream->do_query("select fake FROM mailaddresses where fake='$fake'","one")==$fake)
	{
		$timeout = time() + ($hours * 3600) + ($days * 86400);
		$stream->do_query("insert into mailaddresses values('','','$fake','$real','$timeout')","one");
		return 1;
	}
	else
	{
		return 0;
	}
}


function checkMailAddress($fake)
{
	global $stream;
		
	if(!$stream->do_query("select fake FROM mailaddresses where fake='$fake'","one")==$fake)
	{
		return 0;
	}
	else
	{
		return 1;
	}
}


function galleryListing()
{
	if ($handle = opendir('./')) 
	{
		while (false !== ($file = readdir($handle))) 
		{
			if(is_dir($file))
			{
				if($file==".") continue;
				if($file=="..") continue;
				if($file=="images") continue;
			
				$files[] = $file;
			}
			else 
			{
				continue;
			}
		}	
	}

	closedir($handle);
	sort($files);
	reset($files);



	print "<table cellpadding='5' width='100%'><tr>";
	$p=0;
	foreach($files as $k => $n_file) 
	{ 		
		if(($p>0) && ($p%8==0))
		{
			print "</tr><tr><td colspan=8><hr style='color: #666;background-color: #333;height: 1px;border: 0; margin-left:15px; margin-right: 15px;'></td></tr><tr>";
		}
		if($n_file=="Angelicas place") continue;
		if($n_file=="Colins pics") continue;
		if($n_file=="Userpics") continue;

		//$directorytotal = explode(".",shell_exec("du -hs './$n_file'"));
		$filecount = ceil((shell_exec("ls './$n_file' | wc -l") -2) / 2);

		$thumb = "./$n_file/cover.png";	
		print "<td align='center'><a href=\"javascript:getGallery('index.php?f=$n_file');\"><img src='$thumb' border='0' alt='picture' /></a><br /><b>$n_file</b><br> $filecount photos</td>";
		$p++;
	}   
	print "</tr></table><hr style='color: #666;background-color: #333;height: 1px;border: 0; margin-left:15px; margin-right: 15px;'>";

}


function undo_htmlspecialchars($string)
{
	$string = preg_replace("/&amp;/i",'&',$string);
	$string = preg_replace("/&#039;/i","'",$string);
	$string = preg_replace("/&quot;/i",'"',$string);
	$string = preg_replace("/&lt;/i",'<',$string);
	$string = preg_replace("/&gt;/i",'>',$string);

	return $string;

}



function indexOf($needle, $haystack) {                // conversion of JavaScripts most awesome
        for ($i=0;$i<count($haystack);$i++) {         // indexOf function.  Searches an array for
                if ($haystack[$i] == $needle) {       // a value and returns the index of the *first*
                        return $i;                    // occurance
                }
        }
        return -1;
}



$th = 1;
$numVideos = 0;

function filmListing()
{
	global $stream,$numVideos;
	$u = 0;
	$t = 0;
	$b = 1;
	$menu = "";
 
	$dh = @opendir('./video');
	while( false !== ( $file = readdir( $dh ) ) )
	{
		if(is_dir("./video/".$file) || $file=="index.php" || $file=="index.php.bak" || $file=="google.php") 
			continue;

		$files[] = $file;
	}

	closedir($dh);
	natsort($files);
	reset($files);

	$menu .= "<table id='ShowListView' cellpadding=5 border=0 width='100%'><tr><td width='50%' valign='top' style='border-right:1px solid #666666;border-left:1px solid #666666; padding-left:20px;'>\n";

	$all = 0;
	
	$letter = "";

	$user = explode(":",$_COOKIE["feeditoutCookie"]);
	$user = $user[0];
	$watched = $stream->do_query("select video from logs_videos_watched where user='$user' order by id ASC","array");

	for($k=0;$k<count($watched);$k++)
	{
		$tmp = $watched[$k];
		$videosWatched[] = $tmp[0];
	}
	$videosWatched[] = "";

	
	foreach($files as $k => $file) 
	{ 
		$u++;
		$insert = "";
		$name = ereg_replace("[^A-Za-z0-9]", " ", $file );
		$file_size = round((filesize("./video/".$file) /1024) / 1024);
		$all = $all + $file_size;
		$len = strlen($file_size);
		if($len<3) $file_size = "&nbsp;". $file_size;
		if($len<2) $file_size = "&nbsp;". $file_size;
		$title = substr($name,0,(strlen($name)-3));
		$title = preg_replace("/\d{19}/","",$title);
		$title = preg_replace("/\d{18}/","",$title);
		$title = preg_replace("/\d{20}/","",$title);
		$title = preg_replace("/\d{17}/","",$title);
		$first = ucfirst(substr($title,0,1));
		$ext = substr($file,(strlen($file)-3),strlen($file));

		if(strtolower($ext)!="flv")
			$icon = "<img src='http://dev.feeditout.com/images/VLC.png' class='imghead'>";
		else
			$icon = "&nbsp;&nbsp;&nbsp;";

		if($first=="J" && $t==0)
		{
			$menu .= "</td><td valign='top' style='border-right:1px solid #666666; padding-left:15px;'>\n";
			$t++;
		}

		if(count(@$stream->do_query("select * from videos where video='".$title."'","array"))>0){
			$total = @$stream->do_query("select total from videos where video='".$title."'","one");
			$votes = @$stream->do_query("select votes from videos where video='".$title."'","one");
			$avg = ceil($total / $votes);
			$stars = str_repeat("<img src='http://dev.feeditout.com/images/star.png' width=8 height=8 class='imghead'> ",$avg);	
		}

		if($first == $letter) { $insert = ""; }
		
		
		else  { $insert = "<br><span id='letter_$first'><img src='http://dev.feeditout.com/letter-image.php?text=$first' class='imghead' alt='$first'> <hr style='margin-right:15px;color: #333;background-color: #333;height: 1px;border: 0;'></span> "; }
		
		if(strlen($title)>55)
		{ 
			$pu = " ..";
		} 
		else 
		{
			$pu = "";
		}
		

		if(in_array($file,$videosWatched))
		{
			$index = indexOf($file,$videosWatched);
			if($index>-1)
				$index = $index + 1;
			else
				$index = "";

			$stf = "<span id='watched$u'>[ <a style='color: #cc9b19; font-family:verdana; font-size: 6pt;' onMouseOver=\"this.innerHTML='Mark as unviewed';\" onMouseOut=\"this.innerHTML='". $index . "';\" href=\"javascript:changeViewStatus('watched$u','$file');\">". $index . "</a> ]</span>";
			$b++;
		}
		else
		{
			$stf = "<span id='watched$u'></span>";
		}

		$menu .= "$insert <span id='videoLinkSpan$u' class='videoMenu'> $icon &nbsp;&nbsp;&nbsp;$u&nbsp;- $stf <a id='videoLinks$u' href=\"javascript:getFilm('$file','watched$u');\">".substr($title,0,53)."$pu</a> [ $file_size mb ] $stars<br></span>\n";

		$letter = $first;
		$stars = "";
		
	}
	$size = explode(".",round(($all / 1024),2));
	$menu .= "<br></td></tr><tr><td colspan='2' align='center'><br><img src='http://dev.feeditout.com/letter-image.php?text=T o t a l   $size[0] . $size[1]   g b&size=170x20' class='imghead' alt='Total". round(($all / 1024),2)." gb'></td></tr><table>";
	$numVideos = $u;
	return $menu;
}

function avifilm($file)
{
	if(file_exists($file)){
		$stuff = "<br><a href=\"$file\" id=\"player\"  style=\"display:block; width:100%; height:90%; text-align:center; border:1px solid #cccccc; margin: 2px 2px 2px 2px;\">
		<img src=\"./flowplayer/down.png\" id='playIcon' alt=\"Download this video\" style=\"margin-top:138px;border:0\" /> </a><br><div id='exitViewer' style='display:none;'><a href='javascript:playerView();'>Exit Player View</a><br><br></div>";
	}
	else {
		$stuff = "Unknown Video";
	}
	return $stuff;
}


function flvfilm($file)
{	
	if(file_exists($file)){
		$stuff = "<br><a href=\"$file\" id=\"player\" style=\"display:block; width:100%; height:90%; text-align:center; border:1px solid #cccccc; margin: 2px 2px 2px 2px;\">
		<img src=\"./flowplayer/play.png\" id='playIcon' alt=\"Play this video\" style=\"margin-top:138px;border:0\" /> </a><br><div id='exitViewer' style='display:none;'><a href='javascript:playerView();'>Exit Player View</a><br><br></div>\n";
	}
	else {
		$stuff = "Unknown Video";
	}
	return $stuff;
}

function showthumbs($file)
{
	$imgs = "";
	$thumb = $file . "_0.jpg";
	if(filesize("./video/".$file)>10000000)
		$t = 300;
	else
		$t = 3;

	if(!file_exists("thumbs/$thumb"))
	{
		
		$q = 1;
		while($q<6)
		{
			$thumb = $file . "_". ($q -1) . ".jpg";
			$tnum = $q * $t;
			shell_exec("ffmpeg  -itsoffset -$tnum  -i './video/$file' -vcodec mjpeg -vframes 1 -an -f rawvideo -s 120x90 'thumbs/$thumb'");
			$imgs .= "<img src='thumbs/$thumb' class='thumb'>";
			$q++;
		}
	}
	else
	{
		$q = 1;
		for($u=0;$u<5;$u++)
		{
			$tnum = $q * $t;
			$thumb = $file . "_". $u . ".jpg";
			if(!file_exists("thumbs/$thumb") || filesize("thumbs/$thumb")==0) 
			{				
				if($_GET['th'])
				{
					shell_exec("ffmpeg  -itsoffset -$tnum  -i './video/$file' -vcodec mjpeg -vframes 1 -an -f rawvideo -s 120x90 'thumbs/$thumb'");
				}
			}
			else
			{
				$imgs .= "<img src='thumbs/$thumb' class='thumb'>";
			}
			if($u==2)
				$imgs .= "<br>";

			$q++;
		}
	}
	return $imgs;
}



function most_popular($size){

	global $stream;
	$pop = $stream->do_query("SELECT * from logs_wallpaper order by hits DESC limit 0,25","array");
	
	print "<br /><img src='http://dev.feeditout.com/image.php?text=Most Downloaded' class='imghead' alt='image' /><br /><br /><table cellpadding='3'><tr>";
	
	if($size=="smallThumbs"){
		$mod = 9;
	}
	if($size=="Thumbs"){
		$mod = 5;
	}
	if($size=="largeThumbs"){
		$mod = 3;
	}
	
	for($y=0;$y<count($pop);$y++){
		$tmp = $pop[$y];
		$pic = base64_decode($tmp[1]);
		
		if($y%$mod==0){
			print "</tr><tr>";
		}
		
		print "<td> <a href=\"index.php?viewimage=$tmp[1]\"><img border='0' src='$size/$pic.png' alt='image' /></a><br /> </td>";
		
	}
	
	print "</tr></table>";
}



function im_form($m_amount,$size,$dimensions){

	global $stream;
	$dis = $stream->do_query("SELECT DISTINCT width,height FROM wallpaper","array");

	sort($dis);
	reset($dis);	

	print "<form method='get' action='index.php' name='jumpto'><table width='100%'><tr><td>";
	
	print "Show <select name='amount'>";
	print "<option ";
	if($m_amount==50) print "selected='selected'";
	print  " value='50'>50</option>";
	print "<option ";
	if($m_amount==100) print "selected='selected'";
	print  "  value='100'>100</option>";
	print "<option ";
	if($m_amount==200) print "selected='selected'";
	print  "  value='200'>200</option>";
	print "</select> ";
	
	
	print "Dimensions <select name='dimensions'>";
	print "<option value='all'> All Sizes </option>\n";
	for($x=count($dis);$x>0;$x--){

		$tmp = $dis[$x];
		$width = $tmp[0];
		$height = $tmp[1];
	
		$curdim = $width."x".$height;
		
		if($width>799){
			print "<option value='$curdim'";
			if("$dimensions"=="$curdim") print " selected='selected'";
			print "> $width x $height </option>\n";
		}

	}
	print "</select>\n";


	print "Thumbnails Size <select name='size'>";
	print "<option ";
	if($size=="smallThumbs") print "selected='selected'";
	print  " value='smallThumbs'>Small</option>";
	print "<option ";
	if($size=="Thumbs") print "selected='selected'";
	print  " value='Thumbs'>Medium</option>";
	print "<option ";
	if($size=="largeThumbs") print "selected='selected'";
	print  " value='largeThumbs'>Large</option>";
	print "</select>";
	
	print " <input class='submit' type='submit' value='Change Browsing Preferences' /> </td><td align=center>";
	print "<input id='cpics' class='submit' type='button' value='Show Popular' onclick=\"pwallpapershowdiv('ppics','pics')\" />";
	print "<input id='cppics' class='hidden' type='button' value='View Wallpapers' onclick=\"pwallpapershowdiv('pics','ppics')\" />";
	print "</td><td align='right'>";
	print "<input id='bpics' class='submit' type='button' value='Upload Wallpapers' onclick=\"wallpapershowdiv('uploadpics','pics')\" />";
	print "<input id='buploadpics' class='hidden' type='button' value='View Wallpapers' onclick=\"wallpapershowdiv('pics','uploadpics')\" />";


	print "</td></tr></table></form>";

}



function show_thumbs($dimensions,$size,$start,$amount,$pg){

	global $stream;
	if($dimensions=="all")
	{	
		$dis_all = $stream->do_query("SELECT * FROM wallpaper Order by id ASC","array");
		$dis = $stream->do_query("SELECT * FROM wallpaper Order by id ASC limit $start,$amount","array");
	}
	else {	
		$res = explode("x",$dimensions);
		$dis_all = $stream->do_query("SELECT * FROM wallpaper where width='$res[0]' and height='$res[1]'","array");
		$dis = $stream->do_query("SELECT * FROM wallpaper where width='$res[0]' and height='$res[1]' Order by id ASC limit $start,$amount","array");

	}	

	sort($dis);
	reset($dis);
	
	$crums = ceil(count($dis_all) / $amount);
	
	if($crums>1){
		print "<hr style='color: #666;background-color: #666;height: 1px;border: 0;'>Page :";
		for($x=0;$x<$crums;$x++){	
			if($x==0) $nstart = 0;
			else $nstart = $x * $amount;
			if($dimension=="all"){
				print " <a href='index.php?position=$nstart&amp;size=$size&amp;amount=$amount&amp;pg=page$x'>";
			}
			else {
				print " <a href='index.php?position=$nstart&amp;size=$size&amp;amount=$amount&amp;pg=page$x&amp;dimensions=$dimensions'>";
			}
			if("$pg"=="page$x") print "<font color='#ffffff'>";
			print $x+1;
			if("$pg"=="page$x") print "</font>";
			print "</a> ";
		}
	}
	else {
		print "<hr style='color: #666;background-color: #666;height: 1px;border: 0;'>Page : <a href=''><font color='ffffff'>1</font></a>";
	}
	

	print "<br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'><table cellpadding='3'><tr>";
	
	if($size=="smallThumbs"){
		$mod = 9;
	}
	if($size=="Thumbs"){
		$mod = 5;
	}
	if($size=="largeThumbs"){
		$mod = 3;
	}
	$f=0;

	for($x=0;$x<count($dis);$x++){

		if($f>0){
			if($f%$mod==0){
				print "</tr><tr>";
			}
		}
	
		$tmp = $dis[$x];
		$id = $tmp[0];
		$name = rawurldecode($tmp[1]);
		$nameg = base64_encode($name);
		print "<td> <a href=\"index.php?viewimage=$nameg\"><img border='0' src='$size/$name.png' alt='image' /></a><br /> </td>";
		$f++;

	}

	print "</tr></table>";
	
	if($crums>1){
		print "<br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'>Page :";
		for($x=0;$x<$crums;$x++){		
			if($x==0) $nstart = 0;
			else $nstart = $x * $amount;
			if($dimension=="all"){
				print " <a href='index.php?position=$nstart&amp;size=$size&amp;amount=$amount&amp;pg=page$x'>";
			}
			else {
				print " <a href='index.php?position=$nstart&amp;size=$size&amp;amount=$amount&amp;pg=page$x&amp;dimensions=$dimensions'>";
			}
			if("$pg"=="page$x") print "<font color='#ffffff'>";
			print $x+1;
			if("$pg"=="page$x") print "</font>";
			print "</a> ";
		}
		print "<br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'>";
	}
	else {
		print "<br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'>Page : <a href=''><font color='ffffff'>1</font></a><br /><hr style='color: #666;background-color: #666;height: 1px;border: 0;'>";
	}

}


function uploadform(){

	print "<br /><img src='http://dev.feeditout.com/image.php?text=Upload Wallpapers' class='imghead' alt='image' /><br /><br /><table width='700' border='0'>\n";
	for($x=1;$x<11;$x++){
	print "<tr><td width='150'>\n";
	print "<form name=\"upload$x\" enctype=\"multipart/form-data\" action=\"uploader.php\" method=\"post\" target=\"fileupload$x\">\n";
	print "<input type=\"button\" class=\"red\" id=\"pseudobutton$x\" value=\"Upload File\" />\n";
	print "<input type=\"file\" class=\"hide\" id=\"openssme$x\" name='uploadedfile' onchange=\"fileupload('$x','0');document.upload$x.submit();\" onmousedown=\"buttonPush('depressed','pseudobutton$x');\" onmouseup=\"buttonPush('normal','pseudobutton$x');\" onmouseout=\"buttonPush('phased','pseudobutton$x');\" />\n";
	print "</form></td><td width='550'>\n";
	print "<div id='status$x'></div>\n";
	print "</td><td><iframe class='fileiframe' width='1' height='1' scrolling=\"no\" name=\"fileupload$x\" id=\"fileupload$x\">\n";
	print "</iframe></td></tr>\n";
	}
	print "</table>\n";
}

function viewimage($image){ 
	$image = base64_decode($image);
	global $stream;
	$img = mysql_real_escape_string($image);
	$dis = $stream->do_query("SELECT * FROM wallpaper where name='$img'","array");
	$tmp = $dis[0];
	$wid = $tmp[2];
	$hei = $tmp[3];
	$imge = base64_encode($image);
	
	$sc43 = array('640x480','800x600','1024x768','1280x1024','1600x1200','2048x1536');
	$sc169 = array('852x480','1280x720','1365x768','1600x900','1920x1080');
	$sc1610 = array('1440x900','1680x1050','1920x1200','2560x1600');
	
	print "<hr style='color: #666;background-color: #666;height: 1px;border: 0;'><br /><table width='700' border='0'>\n";
	//http://dev.feeditout.com/Wallpaper/preview.php?image=00282_kaikourasunrise_2560x1600.jpg
	print "<tr><td align='center'><img border='0' src='preview.php?image=$imge' class=imghead><br /><br /><b>$image</b><br /><br />Dimensions : $wid x $hei<br /><br />\n";
	print "<a href='getimage.php?img=$imge&size=original'>Download Original</a><br /><br />";
	print "<input type=button class='submit' value='Continue Browsing' onclick=\"document.location.href='$_SERVER[HTTP_REFERER]'\"><br /><br /></td>\n";
	
	print "<td valign='top'>Aspect Ratio 4:3<br /><br />\n";
	for($t=0;$t<count($sc43);$t++){
		print "<a href='getimage.php?img=$imge&size=$sc43[$t]'>Download & Resize to $sc43[$t]</a><br />\n";
	}
	
	print "<br />Aspect Ratio 16:9<br /><br />";
	for($t=0;$t<count($sc169);$t++){
		print "<a href='getimage.php?img=$imge&size=$sc169[$t]'>Download & Resize to $sc169[$t]</a><br />\n";
	}
	
	print "<br />Aspect Ratio 16:10<br /><br />";
	for($t=0;$t<count($sc1610);$t++){
		print "<a href='getimage.php?img=$imge&size=$sc1610[$t]'>Download & Resize to $sc1610[$t]</a><br />\n";
	}
	print "</td>\n";	
	
	
	print "</tr></table>\n";

}
