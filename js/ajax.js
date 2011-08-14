// JavaScript Document


var wall_pos = 0;
var wall_show = 50;
var wall_size = "smallThumbs";
var previewbooka = 0;
var bookmode = 0;

function showdiv(div){
	var block = document.getElementById(div);
	block.setAttribute("class", "shown");
	block.setAttribute("className", "shown");
	if(div=="mh4"){
		var so = new SWFObject("music/mp3player/ep_player.swf", "ep_player", "301", "16", "9", "#FFFFFF");
		so.addVariable("skin", "http://dev.feeditout.com/music/mp3player/skins/micro_player/skin.xml");
		so.addVariable("file", "<location>http://dev.feeditout.com/music/Pendulum Hold your colour/02-pendulum_-_slam-boss.mp3</location><creator>Pendulum</creator><title>Slam Boss</title>");
		so.addVariable("autoplay", "true");
		so.addVariable("shuffle", "false");
		so.addVariable("repeat", "false");
		so.addVariable("buffertime", "1");
		so.write("mh4");	
	}
}

function hidediv(div){
	var block = document.getElementById(div);
	block.setAttribute("class", "hidden");
	block.setAttribute("className", "hidden");
	if(div=="mh4"){
		document.getElementById(div).innerHTML = ""; 
	}
}



jx = {
	http:false, //HTTP Object
	format:'text',
	callback:function(data){},
	error:false,
	getHTTPObject : function() {
		var http = false;
		if(typeof ActiveXObject != 'undefined') {
			try {http = new ActiveXObject("Msxml2.XMLHTTP");}
			catch (e) {
				try {http = new ActiveXObject("Microsoft.XMLHTTP");}
				catch (E) {http = false;}
			}
		} else if (XMLHttpRequest) {
			try {http = new XMLHttpRequest();}
			catch (e) {http = false;}
		}
		return http;
	},
	load : function (url,callback,format) {
		this.init(); 
		if(!this.http||!url) return;
		if (this.http.overrideMimeType) this.http.overrideMimeType('text/xml');

		this.callback=callback;
		if(!format) var format = "text";
		this.format = format.toLowerCase();
		var ths = this;
		
		if (this.http.overrideMimeType) this.http.overrideMimeType('text/xml');

		var now = "uid=" + new Date().getTime();
		url += (url.indexOf("?")+1) ? "&" : "?";
		url += now;

		this.http.open("GET", url, true);

		this.http.onreadystatechange = function () {
			if(!ths) return;
			var http = ths.http;
			if (http.readyState == 4) {
				if(http.status == 200) {
					var result = "";
					if(http.responseText) result = http.responseText;
					if(ths.format.charAt(0) == "j") {
						result = result.replace(/[\n\r]/g,"");
						result = eval('('+result+')'); 
					}
	
					if(ths.callback) ths.callback(result);
				} else { 
					if(ths.error) ths.error()
				}
			}
		}
		this.http.send(null);
	},
	init : function() {this.http = this.getHTTPObject();}
}


function booksdo_search(){
	var book = document.getElementById("booksearch");
	var val = book.value;
	dest = "index.php?search="+val;
	booksloadurl(dest);

}

function booksdo_search_popular(book){
	
	var block = document.getElementById("books");
	block.setAttribute("class", "shown");
	block.setAttribute("className", "shown");
	
	var block2 = document.getElementById("preview");
	block2.setAttribute("class", "hidden");
	block2.setAttribute("className", "hidden");
	
	dest = "index.php?search="+book;
	booksloadurl(dest);

}

function scribed(url){

	var block = document.getElementById("books");
	block.setAttribute("class", "hidden");
	block.setAttribute("className", "hidden");
	
	var block2 = document.getElementById("preview");
	block2.setAttribute("class", "shown");
	block2.setAttribute("className", "shown");
	
    //pub-23661249872460288013 ms2 freedomfighrt
	//pub-83270563026473809784 ms
	//pub-38029622817288544865 fio
    var newurl = Base64.decode(url);
	var file = "http://dev.feeditout.com/books/pdf/" + newurl;
    var scribd_doc = scribd.Document.getDocFromUrl(file, 'pub-38029622817288544865');
	scribd_doc.addParam("public", false);
    scribd_doc.write('embedded_doc');
	}

function bookpagejump(book){
	var block = document.getElementById("pagejump");
	var page = block.value;
	var url = "index.php?preview="+ book + "&bookpage=" + page;
	prevbooksloadurl(url);	
	
}


function bookletter(letter){

	var block = document.getElementById("books");
	block.setAttribute("class", "shown");
	block.setAttribute("className", "shown");
	
	var block2 = document.getElementById("preview");
	block2.setAttribute("class", "hidden");
	block2.setAttribute("className", "hidden");
	
	var url = "index.php?view=letter&letter=" + letter;
	booksloadurl(url);
	
}

function allbooks(dest){
	var block = document.getElementById("books");
	block.setAttribute("class", "shown");
	block.setAttribute("className", "shown");
	
	var block2 = document.getElementById("preview");
	block2.setAttribute("class", "hidden");
	block2.setAttribute("className", "hidden");
	
	booksloadurl(dest);
}



function delete_book(book){
	var url = "index.php?delete=" + book;
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("preview").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = deletebookstriggeredoutput; 

	xmlhttp.open("GET", url, true); 
	xmlhttp.send(null); 
}

function deletebookstriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("book_admin").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("book_admin").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("book_admin").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("book_admin").innerHTML = xmlhttp.responseText; 
	} 
}



function prevbooksloadurl(dest) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("preview").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = prevbookstriggeredoutput; 

	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 



function prevbookstriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("preview").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("preview").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("preview").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("preview").innerHTML = xmlhttp.responseText; 
	} 
}



function booksloadurl(dest) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("books").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = bookstriggeredoutput; 

	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 



function bookstriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("books").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("books").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("books").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("books").innerHTML = xmlhttp.responseText; 
	} 
}


function musicloadurl(dest,name) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("content").innerHTML = "<dd><h3>There was a problem fetching the page</h3>"; 
	} 
	xmlhttp.onreadystatechange = musictriggeredoutput; 
	document.getElementById("contentname").innerHTML = "<img src='http://dev.feeditout.com/image.php?size=900x60&text=" + name + "' class='imghead'>";
	var loading = document.getElementById("loading");
	loading.setAttribute("class", "lshown");
	loading.setAttribute("className", "lshown");
	
	var content = document.getElementById("content");
	content.setAttribute("class", "lhidden");
	content.setAttribute("className", "lhidden");
	
	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 



function musictriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		var loading = document.getElementById("loading");
		loading.setAttribute("class", "lshown");
		loading.setAttribute("className", "lshown");
	
		var content = document.getElementById("content");
		content.setAttribute("class", "lhidden");
		content.setAttribute("className", "lhidden");
	} 
	if ((xmlhttp.readyState == 2)) { 
		var loading = document.getElementById("loading");
		loading.setAttribute("class", "lshown");
		loading.setAttribute("className", "lshown");
	
		var content = document.getElementById("content");
		content.setAttribute("class", "lhidden");
		content.setAttribute("className", "lhidden");
	} 
	if ((xmlhttp.readyState == 3)) { 
		var loading = document.getElementById("loading");
		loading.setAttribute("class", "lshown");
		loading.setAttribute("className", "lshown");
	
		var content = document.getElementById("content");
		content.setAttribute("class", "lhidden");
		content.setAttribute("className", "lhidden");
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		var loading = document.getElementById("loading");
		loading.setAttribute("class", "lhidden");
		loading.setAttribute("className", "lhidden");
	
		var content = document.getElementById("content");
		content.setAttribute("class", "lshown");
		content.setAttribute("className", "lshown");
		document.getElementById("content").innerHTML = xmlhttp.responseText; 
	} 
}


function mini(){
	var ids = Array();
	ids[0] = document.getElementById("headeralbum");
	ids[1] = document.getElementById("content");
	ids[2] = document.getElementById("footer");
	ids[3] = document.getElementById("menuhide");
	ids[4] = document.getElementById("contentname");
	

	for(var x=0;x<ids.length;x++){
	if(x==4){
	ids[x].setAttribute("class", "legendhidden");
	ids[x].setAttribute("className", "legendhidden");
	}
	else {
	ids[x].setAttribute("class", "hidden");
	ids[x].setAttribute("className", "hidden");
	}
	}
	
	var menu = document.getElementById("menushow");
	menu.setAttribute("class", "shown");
	menu.setAttribute("className", "shown");
	
}

function full(){
	var ids = Array();
	ids[0] = document.getElementById("headeralbum");
	ids[1] = document.getElementById("content");
	ids[2] = document.getElementById("footer");
	ids[3] = document.getElementById("menuhide");
	ids[4] = document.getElementById("contentname");
	
	
	for(var x=0;x<ids.length;x++){
	if(x==4){
	ids[x].setAttribute("class", "legendshown");
	ids[x].setAttribute("className", "legendshown");
	}
	else {
	ids[x].setAttribute("class", "shown");
	ids[x].setAttribute("className", "shown");
	}
	}
	
	var menu = document.getElementById("menushow");
	menu.setAttribute("class", "hidden");
	menu.setAttribute("className", "hidden");
	
}



function toggleview()
{
	var state = document.getElementById("content");
	var value = state.getAttribute("class");

	if(value=="shown"){
		mini();
	}
	else {
		full();
	}
}



function serialloadurl(dest) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("search").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = serialtriggeredoutput; 

	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 



function serialtriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("search").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("search").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("search").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("search").innerHTML = xmlhttp.responseText; 
	} 
}


function serialdo_search(){
	var book = document.getElementById("booksearch");
	var val = book.value;
	dest = "index.php?view=search&term="+val;
	serialloadurl(dest);
}
	
	


function avi(file)
{
	document.getElementById('avifilmname').src=file;

}


function filmloadurl(dest) { 

	var block = document.getElementById("film");
	block.setAttribute("class", "shown");
	block.setAttribute("className", "shown");

	var ext = dest.split(".");
	var extlen = ext.length;
	var tt = ext[extlen -1];

	var block2 = document.getElementById("flashfilm");
	var block3 = document.getElementById("avifilm");

	if(tt=="flv")
	{		
		block2.setAttribute("class", "shown");
		block2.setAttribute("className", "shown");
		block3.setAttribute("class", "hidden");
		block3.setAttribute("className", "hidden");
	}
	else
	{		
		block3.setAttribute("class", "shown");
		block3.setAttribute("className", "shown");	
		block2.setAttribute("class", "hidden");
		block2.setAttribute("className", "hidden");
	}

	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("search").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = filmloadurltriggeredoutput; 
	var url = "index.php?showFilm="+dest;
	xmlhttp.open("GET", url, true); 
	xmlhttp.send(null); 
} 



function filmloadurltriggeredoutput() { 
		
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("film").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("film").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("film").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("film").innerHTML = xmlhttp.responseText; 
		// get all links that are inside div#clips 
		if(document.getElementById("clips").getElementsByTagName("a"))
		{
		var links = document.getElementById("clips").getElementsByTagName("a"); 
 
		for (var i = 0; i < links.length; i++) { 
		links[i].onclick = function() {          
        
			$f().play(this.getAttribute("href", 2)); 
         
		// by returning false normal link behaviour is skipped 
		return false; 
		} 
		}
		}
	} 
}













function stuffloadurl(dest) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("files").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = stufftriggeredoutput; 

	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 



function stufftriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("files").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("files").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("files").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("files").innerHTML = xmlhttp.responseText; 
	} 
}

function stuffdo_search(){
	var book = document.getElementById("filessearch");
	var val = book.value;
	dest = "index.php?search="+val;
	stuffloadurl(dest);
}



function buttonPush (buttonStatus,id)
  {
	 if (buttonStatus == "depressed")
		document.getElementById(id).style.borderStyle = "inset";

	 else
		document.getElementById(id).style.borderStyle = "outset";
  }
  
function fileupload(id,check)
{
	var statusid = "status" + id;
	var fileid = "openssme" + id;
	
	var file = document.getElementById(fileid).value;	
	
	var splitter;
	if (navigator.appVersion.indexOf("Win")!=-1) 
	{
		splitter="\\";
	}
	else 
	{
		splitter="/";
	}
	
	var temp = new Array();
	temp = file.split(splitter);
	
	var filename = temp[temp.length -1];
		
	if(check=="0")
	{	
		document.getElementById(statusid).innerHTML = filename + " uploading <img width=15 src='http://dev.feeditout.com/images/ajax.gif' class='imghead'>";	
		setTimeout("fileupload('"+id+"','1');", 5000);
	}
	else 
	{
		var frameid = "fileupload" + id;
		var complete = "";
		var iframeEl = document.getElementById(frameid);
		if (iframeEl.contentDocument) { // DOM
    		if(iframeEl.contentDocument.getElementById('result')){
				complete = iframeEl.contentDocument.getElementById('result').innerHTML;
			}
		
		} 
		else if (iframeEl.contentWindow) 
		{ // IE win
    		if(iframeEl.contentWindow.document.getElementById('result')){
				complete = iframeEl.contentWindow.document.getElementById('result').innerHTML;
			}
		}

		if(complete.length >1 )
		{
			document.getElementById(statusid).innerHTML = complete;	
		}
		else {
			setTimeout("fileupload('"+id+"','1');", 5000);
		}
	}	
}  

function stuffshowdiv(div,div2){
	stuffhidediv(div2);
	var block = document.getElementById(div);
	block.setAttribute("class", "shown");
	block.setAttribute("className", "shown");	
}

function stuffhidediv(div){
	var block = document.getElementById(div);
	block.setAttribute("class", "hidden");
	block.setAttribute("className", "hidden");
}




function textsloadurl(dest) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("listing").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = textstriggeredoutput; 

	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 


function textsletterurl(letter) { 
	var dest = "index.php?view=letter&letter="+letter;
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("listing").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = textstriggeredoutput; 

	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 


function textstriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("listing").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("listing").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("listing").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("listing").innerHTML = xmlhttp.responseText; 
	} 
}

function textsdo_search(){
	var book = document.getElementById("booksearch");
	var val = book.value;
	dest = "index.php?view=search&term="+val;
	textsloadurl(dest);

}
	
	


function wallpaperloadurl(dest) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("files").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = wallpapertriggeredoutput; 

	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 



function wallpapertriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("files").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("files").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("files").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("files").innerHTML = xmlhttp.responseText; 
	} 
}



function wallpapershowdiv(div,div2){
	wallpaperhidediv(div2);
	var block = document.getElementById(div);
	block.setAttribute("class", "shown");
	block.setAttribute("className", "shown");	
	
	var bdiv = "b" + div;
	
	var block = document.getElementById(bdiv);
	block.setAttribute("class", "submit");
	block.setAttribute("className", "submit");
}

function wallpaperhidediv(div){
	var block = document.getElementById(div);
	block.setAttribute("class", "hidden");
	block.setAttribute("className", "hidden");
	
	var bdiv = "b" + div;
	
	var block = document.getElementById(bdiv);
	block.setAttribute("class", "hidden");
	block.setAttribute("className", "hidden");
	
}

//'ppics','pics'
function pwallpapershowdiv(div,div2){
	pwallpaperhidediv(div2);
	var block = document.getElementById(div);
	block.setAttribute("class", "shown");
	block.setAttribute("className", "shown");	
	
	var bdiv = "c" + div;
	
	var block = document.getElementById(bdiv);
	block.setAttribute("class", "submit");
	block.setAttribute("className", "submit");
}

function pwallpaperhidediv(div){
	var block = document.getElementById(div);
	block.setAttribute("class", "hidden");
	block.setAttribute("className", "hidden");
	
	var bdiv = "c" + div;
	
	var block = document.getElementById(bdiv);
	block.setAttribute("class", "hidden");
	block.setAttribute("className", "hidden");
	
}



function set_cookie ( name, value, exp_y, exp_m, exp_d, path, domain, secure )
{
  var cookie_string = name + "=" + escape ( value );
  if ( exp_y )
  {
    var expires = new Date ( exp_y, exp_m, exp_d );
    cookie_string += "; expires=" + expires.toGMTString();
  }
  if ( path )
  	cookie_string += "; path=" + escape ( path );

  if ( domain )
     cookie_string += "; domain=" + escape ( domain );
  
  if ( secure )
     cookie_string += "; secure";
	
document.cookie = cookie_string;
}

function books_mode(mode)
{
	if(bookmode==0){
		alert("Change to "+ mode + " mode will take after your next request!");	
		bookmode=1;
	}
	var cookieb = document.getElementById('dcookie');
	if(mode=="text")
	{	  		
		cookieb.innerHTML = " Switch to <a href=\"javascript:books_mode('images')\">Image Mode</a>";
		set_cookie('books','text');
	}
	else {
		cookieb.innerHTML = "Switch to <a href=\"javascript:books_mode('text')\">Text Mode</a>";
		set_cookie('books','images');
	}
	
}


function changetitle (title){
	if(title==""){
		title = "Feeditout";
	}
	else {
		title = "Feeditout - " + title;	
	}
	if (top.frames.length==0){
		document.title = title;
	}
	else {
		parent.document.title = title;
	}	
}


var Base64 = {

    _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

    encode : function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;

        input = Base64._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
            this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
            this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

        }

        return output;
    },

    decode : function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {

            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }

        }

        output = Base64._utf8_decode(output);

        return output;

    },

    _utf8_encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    _utf8_decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while ( i < utftext.length ) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}

var projdiv= "";
var project_divs = [];


function loadprojectmenu(div,project) { 

	for (var i=0;i<project_divs.length;i++)
	{
		var block = document.getElementById(project_divs[i]);
		block.innerHTML = "";
	}

	projdiv = div;
	
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById(projdiv).innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = projectmenutriggeredoutput; 

	xmlhttp.open("GET", project, true); 
	xmlhttp.send(null); 
} 



function projectmenutriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById(projdiv).innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById(projdiv).innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById(projdiv).innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById(projdiv).innerHTML = xmlhttp.responseText; 
			var url = "index.php?projectintro=" + projdiv;
			loadprojectintro(url);
	} 
}




function loadprojectfile(project) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("code").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = projectfiletriggeredoutput; 

	xmlhttp.open("GET", project, true); 
	xmlhttp.send(null); 
} 



function projectfiletriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("code").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("code").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("code").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("code").innerHTML = xmlhttp.responseText; 
	} 
}


function checkEmailAvail(mail) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("avail").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = checkEmailAvailtriggeredoutput; 

	xmlhttp.open("GET", mail, true); 
	xmlhttp.send(null); 
} 



function checkEmailAvailtriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("avail").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("avail").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("avail").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		if(parseInt(xmlhttp.responseText)==0)
		{
			document.getElementById("avail").innerHTML = "<font color='Green'>Available!</font>"; 
		}
		else
		{
			document.getElementById("avail").innerHTML = "<font color='ff0000'>Already in use!</font>"; 
		}
	} 
}

function doMailCheck()
{
	var ail = document.getElementById("mailchecker");
	var val = ail.value;
	dest = "index.php?fakemailcheck="+val;
	checkEmailAvail(dest);
}










function addEmail(mail) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("confirmation").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = addMailtriggeredoutput; 

	xmlhttp.open("GET", mail, true); 
	xmlhttp.send(null); 
} 



function addMailtriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("confirmation").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("confirmation").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("confirmation").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		if(parseInt(xmlhttp.responseText)==1)
		{
			document.getElementById("confirmation").innerHTML = "Your Email alias has been set up you can now proceed to use " + document.getElementById("mailchecker").value; 
		}
		else
		{
			document.getElementById("confirmation").innerHTML = "There was an error setting up your email alias, go back and try again"; 
		}
	} 
}

function addmail()
{
	
	var content = document.getElementById("confirmation");
	content.setAttribute("class", "lshown");
	content.setAttribute("className", "lshown");
	var ail = document.getElementById("mailchecker");
	var val = ail.value;
	var rail = document.getElementById("realmail");
	var rval = rail.value;

	var dail = document.getElementById("emaildays");
	var dval = dail.value;
	var trail = document.getElementById("emailtime");
	var trval = trail.value;


	dest = "index.php?fakemail="+val+"&realmail="+rval+"&hours="+trval+"&days="+dval;
	addEmail(dest);
}









function loadprojectintro(project) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("code").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = projectintrotriggeredoutput; 

	xmlhttp.open("GET", project, true); 
	xmlhttp.send(null); 
} 



function projectintrotriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("code").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("code").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("code").innerHTML = "<img class='imghead' width='20' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		document.getElementById("code").innerHTML = xmlhttp.responseText; 
	} 
}


function passwordChanged() {
	var strength = document.getElementById("strength");
	var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
	var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
	var enoughRegex = new RegExp("(?=.{6,}).*", "g");
	var pwd = document.getElementById("password");
	if (pwd.value.length==0) {
		strength.innerHTML = '';
	} else if (false == enoughRegex.test(pwd.value)) {
		strength.innerHTML = 'More Characters';
	} else if (strongRegex.test(pwd.value)) {
		strength.innerHTML = '<span style="color:green">Strong!</span>';
	} else if (mediumRegex.test(pwd.value)) {
		strength.innerHTML = '<span style="color:orange">Medium!</span>';
	} else {
		strength.innerHTML = '<span style="color:red">Weak!</span>';
	}
}


var pp = 0;

function loadurl(dest) { 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("result").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = stufftriggeredoutput; 

	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 

function stufftriggeredoutput() { 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("result").innerHTML = "Downloading ... " + document.getElementById("file").value;
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("result").innerHTML = "Downloading .... " + document.getElementById("file").value;
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("result").innerHTML = "Downloading .... " + document.getElementById("file").value;
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 
		var nam = document.getElementById("file").value;
		document.getElementById("result").innerHTML = "Download <a href='" + nam + "'>" + nam + "</a>";	
	} 
}

function download()
{
	
	var book = document.getElementById("url");
	var val = book.value;
	var dest = "index.php?url="+val;
	getName(val);
	loadurl(dest);
}

function linktovid(vid)
{
	$("#linktothisvid").animate({ height: "60px", opacity: 1.0 }, 800 );
	var vidiv = document.getElementById("linktothisvid");
	var linkto = "http://dev.feeditout.com/video/index.php?video=" + vid;
	var url = "<br><a href='"+linkto+"'>"+linkto+"</a>";
	vidiv.innerHTML = url + "<br><br>" + "<a href='#' onclick=\"javascript:document.getElementById('linktothisvid').innerHTML = '';$('#linktothisvid').animate({ height: '0px', opacity: 1.0 }, 800 );\">Close</a><br>";
}

function getName(val)
{
	var dest = "index.php?file="+val;
	filenam(dest);
}

function filenam(dest) { 
	try { 
		xmlhttpg = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("bytes").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttpg.onreadystatechange = triggeredoutput; 

	xmlhttpg.open("GET", dest, true); 
	xmlhttpg.send(null); 
} 

function triggeredoutput() { 
	if ((xmlhttpg.readyState == 4) && (xmlhttpg.status == 200)) { 
		document.getElementById("file").value = xmlhttpg.responseText; 
		document.getElementById("result").innerHTML = "Downloading .... " + document.getElementById("file").value;
		var filee = document.getElementById("file").value;
		setTimeout("getsize('" + filee + "');", 5000);
	} 
}

function voteMovie(dest) 
{ 
	try { 
		xmlhttppg = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("votingbox").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttppg.onreadystatechange = voteMovieoutput; 

	xmlhttppg.open("GET", dest, true); 
	xmlhttppg.send(null); 
} 

function voteMovieoutput() 
{ 
	if ((xmlhttppg.readyState == 1)) { 
		document.getElementById("votingbox").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttppg.readyState == 2)) { 
		document.getElementById("votingbox").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttppg.readyState == 3)) { 
		document.getElementById("votingbox").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'>"; 
	} 
	if ((xmlhttppg.readyState == 4) && (xmlhttppg.status == 200)) 
	{ 		
		var stuff = parseInt(xmlhttppg.responseText);
		var backf = "";
		
		for(var r=0;r<stuff;r++)
		{
			backf += " <img src='http://dev.feeditout.com/images/star.png' width=12 height=12 class='imghead'> ";
		}
		document.getElementById("votingbox").innerHTML =backf;
		
	}
}

function vote(vidname,vote)
{
	var dest = "index.php?vote="+ vote+ "&votename=" + vidname;
	voteMovie(dest);
}

function getsize(fileee)
{
	var dest = "index.php?filesize="+fileee;
	sizenam(dest);

}

function sizenam(dest) { 
	try { 
		xmlhttpf = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("bytes").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttpf.onreadystatechange = striggeredoutput; 

	xmlhttpf.open("GET", dest, true); 
	xmlhttpf.send(null); 
}

function striggeredoutput() { 
	if(document.getElementById("result").innerHTML!="done")
	{
		if ((xmlhttpf.readyState == 4) && (xmlhttpf.status == 200)) { 
				
			document.getElementById("bytes").innerHTML = "Downloaded " + (parseInt(xmlhttpf.responseText) / 1024) + " kb"; 
		
			var filee = document.getElementById("file").value;
			setTimeout("getsize('" + filee + "');", 5000);
		}
	} 
}

function getMovie(dest) 
{ 
	try { 
		xmlhttpp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("movie").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttpp.onreadystatechange = getMovieoutput; 

	xmlhttpp.open("GET", dest, true); 
	xmlhttpp.send(null); 
} 

var t = 1;

function getMovieoutput() 
{ 
	if ((xmlhttpp.readyState == 1)) { 
		document.getElementById("movie").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttpp.readyState == 2)) { 
		document.getElementById("movie").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttpp.readyState == 3)) { 
		document.getElementById("movie").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttpp.readyState == 4) && (xmlhttpp.status == 200)) 
	{ 
		var stuff = xmlhttpp.responseText.split("\"");
		var html = xmlhttpp.responseText.replace("player","player" + t);
		document.getElementById("movie").innerHTML = html; 
		$f("player"+t, "http://dev.feeditout.com/video/flowplayer/flowplayer-3.1.3.swf", stuff[1]); 
		t++;
	}
}

function getMovieInfo(dest) 
{ 
	try { 
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("movieinfo").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttp.onreadystatechange = getMovieInfooutput; 

	xmlhttp.open("GET", dest, true); 
	xmlhttp.send(null); 
} 

function getMovieInfooutput() 
{ 
	if ((xmlhttp.readyState == 1)) { 
		document.getElementById("movieinfo").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 2)) { 
		document.getElementById("movieinfo").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 3)) { 
		document.getElementById("movieinfo").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) { 

		document.getElementById("movieinfo").innerHTML = xmlhttp.responseText; 
	} 
}


function getFilm(film,watchedSpan)
{
	if(watchedSpan!="")
	{
		var viewerLink = "[ <a style='color: #ffac1c; font-weight:bold; font-family:verdana; font-size: 6pt;'  onMouseOver=\"this.innerHTML='Mark as unviewed';\" onMouseOut=\"this.innerHTML='viewed';\" href=\"javascript:changeViewStatus('" + watchedSpan + "','" + film +"');\">viewed</a> ]";
		document.getElementById(watchedSpan).innerHTML = viewerLink;
	}

	var vidiv = document.getElementById("linktothisvid");
	vidiv.innerHTML = "";

	document.location.href = '#watchVideo';

	$("#movie").animate({ height: "380px", opacity: 1.0 }, 800 );
	$("#movieinfo").animate({ height: "380px", opacity: 1.0 }, 800 );
	
	getMovie("index.php?getMovie=" + film);
	getMovieInfo("index.php?getMovieInfo=" + film);
	
}


function hideVideo()
{
	var vidiv = document.getElementById("linktothisvid");
	vidiv.innerHTML = "";
	document.getElementById("movieinfo").innerHTML = "";
	document.getElementById("movie").innerHTML = "";
	var ShowListView = document.getElementById("movie");
	ShowListView.style.width='100%';
	ShowListView.style.height='100%';
	$("#movie").animate({ height: "0px", opacity: 1.0 }, 800 );
	$("#movieinfo").animate({ height: "0px", opacity: 1.0 }, 800 );
}


var playerStatus = 1;

function playerView()
{

	var blocks = new Array("ShowListView","googledownload","result","bytes","googletable","videoHeader","headerHr","linktothisvid","speech","movieinfo","searchBox");

	if(playerStatus==1)
	{
		for(var c=0;c<blocks.length;c++)
		{
			if(document.getElementById(blocks[c])!=null)
			{
				var ShowListView = document.getElementById(blocks[c]);
				ShowListView.style.display = 'none';
			}
		}
		var ShowListView = document.getElementById("exitViewer");
		ShowListView.style.display = 'block';

		
		var myWidth = 0, myHeight = 0;
		if( typeof( window.innerWidth ) == 'number' ) {
			myWidth = window.innerWidth;
			myHeight = window.innerHeight;
		} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
			myWidth = document.documentElement.clientWidth;
			myHeight = document.documentElement.clientHeight;
		} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			myWidth = document.body.clientWidth;
			myHeight = document.body.clientHeight;
		}
		var nmyWidth = (myWidth - 150) + "px";
		var nmyHeight = (myHeight - 150) + "px";

		var ShowListView = document.getElementById("movie");
		ShowListView.style.width=nmyWidth;
		ShowListView.style.height=nmyHeight;

		if(document.getElementById("playIcon"))
		{
			var playIcon = document.getElementById("playIcon");
			playIcon.style.marginTop=((myHeight / 2) - 150) +"px";
			playIcon.style.border='0px';
		}

		playerStatus = 0;
	}
	else
	{
		var ShowListView = document.getElementById("movie");
		if(ShowListView!=null)
		{
			ShowListView.style.width='500px';
			ShowListView.style.height='330px';
		}

		for(var c=0;c<blocks.length;c++)
		{
			if(document.getElementById(blocks[c])!=null)
			{
				var ShowListView = document.getElementById(blocks[c]);
				ShowListView.style.display = 'block';
			}
		}
		var ShowListView = document.getElementById("speech");
		ShowListView.style.display = 'none';

		var ShowListView = document.getElementById("exitViewer");
		ShowListView.style.display = 'none';

		if(document.getElementById("playIcon"))
		{
			var playIcon = document.getElementById("playIcon");
			playIcon.style.marginTop='138px';
			playIcon.style.border='0px';
		}

		playerStatus = 1;
	}	
}




function getVideoList() 
{ 
	try { 
		xmlhttpa = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		document.getElementById("videoListContainer").innerHTML = "There was a problem fetching the search results"; 
	} 
	xmlhttpa.onreadystatechange = getVideoListoutput; 

	xmlhttpa.open("GET", "index.php?showList=true", true); 
	xmlhttpa.send(null); 
} 

function getVideoListoutput() 
{ 
	if ((xmlhttpa.readyState == 1)) { 
		document.getElementById("videoListContainer").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttpa.readyState == 2)) { 
		document.getElementById("videoListContainer").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttpa.readyState == 3)) { 
		document.getElementById("videoListContainer").innerHTML = "<img class='imghead' src='http://dev.feeditout.com/images/ajax.gif'> Requesting Content ..."; 
	} 
	if ((xmlhttpa.readyState == 4) && (xmlhttpa.status == 200)) { 

		document.getElementById("videoListContainer").innerHTML = xmlhttpa.responseText; 
	} 
}

function trim(s)
{
    var l=0; var r=s.length -1;
    while(l < s.length && s[l] == ' ')
    {     l++; }
    while(r > l && s[r] == ' ')
    {     r-=1;     }
    return s.substring(l, r+1);
} 


function genHex()
{	
	var colors = new Array(14);
	colors[0]="666666";
	colors[1]="ffec19";
	colors[2]="ffec33";
	colors[3]="ffec55";

	var color = colors[Math.round(Math.random()*3)];

	return "3px solid #" + color;// #ffec19
}



function highLightSearch(searchTerm)
{
	var breakers = ['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

	var videoLink;
	var videoLinkSpan;
	var watchedSpan;
	var k = 0;
	var pipe = searchTerm.indexOf("?");
	//var pipe2 = searchTerm.indexOf("^");
	var hidden = "";
	if(pipe > -1)
	{
		searchTerm = searchTerm.replace(/\?/,"");
		hidden = "none";
	}
	else
	{
		hidden = "block";
	}

	for(var i=1; i < parseInt(document.getElementById("totalVideos").value) +1; i++)
	{
		var menuLink = "videoLinks" + i;
		var spanLink = "videoLinkSpan" + i;
		var viewed = "watched" + i;
		videoLink = document.getElementById(menuLink);
		videoLinkSpan  = document.getElementById(spanLink);
		watchedSpan = document.getElementById(viewed);
		var hrefA = videoLink.innerHTML.toLowerCase();

		if(searchTerm.substring(0,1).toLowerCase()==">")
		{
			var spanC = videoLinkSpan.innerHTML.split("[");
			var bCount = spanC.length -1;
			var spanD = spanC[bCount].split("]");
			spanD[0] = spanD[0].replace(/&nbsp;/,"");
			spanD[0] = spanD[0].replace(/&nbsp;/,"");
			var vidmb = spanD[0].replace(/mb/,"");
			vidmb = trim(vidmb);
				
			var mb = searchTerm.substring(1,5);
			if(parseInt(mb) && parseInt(vidmb))
			{	
				var checkMB = parseInt(mb);
				var vidMb = parseInt(vidmb);
				if(vidMb>checkMB)
				{	
					
					videoLinkSpan.style.display = 'block';
					$("#"+spanLink).fadeTo("slow", 1.00);	
					videoLinkSpan.style.margin = '1px';
					videoLinkSpan.style.borderLeft = '3px solid #ffec19';	
					videoLinkSpan.style.borderBottom = '1px solid #222222';
					videoLinkSpan.style.textDecoration = 'none';	
					k++;
				}
				else
				{
					$("#"+spanLink).fadeTo("slow", 0.33);
					if(hidden=="none")
					{
						$("#"+spanLink).slideUp("slow");
					}
					else
					{
						$("#"+spanLink).slideDown("slow");
					}
					videoLinkSpan.style.margin = '1px';
					videoLinkSpan.style.borderLeft = '3px solid #222222';
					videoLinkSpan.style.borderBottom = '1px solid #222222';
					videoLinkSpan.style.textDecoration = 'line-through';
				}	
					
			}
			else
			{
				$("#"+spanLink).fadeTo("slow", 0.33);
				if(hidden=="none")
				{
					$("#"+spanLink).slideUp("slow");
				}
				else
				{
					$("#"+spanLink).slideDown("slow");
				}
				videoLinkSpan.style.margin = '1px';
				videoLinkSpan.style.borderLeft = '3px solid #222222';
				videoLinkSpan.style.borderBottom = '1px solid #222222';
				videoLinkSpan.style.textDecoration = 'line-through';
			}
		}

		else if(searchTerm.substring(0,1).toLowerCase()=="<")
		{
			var spanC = videoLinkSpan.innerHTML.split("[");
			var bCount = spanC.length -1;
			var spanD = spanC[bCount].split("]");
			spanD[0] = spanD[0].replace(/&nbsp;/,"");
			spanD[0] = spanD[0].replace(/&nbsp;/,"");
			var vidmb = spanD[0].replace(/mb/,"");
			vidmb = trim(vidmb);
			
			var mb = searchTerm.substring(1,5);
			if(parseInt(mb) && parseInt(vidmb))
			{	
				var checkMB = parseInt(mb);
				var vidMb = parseInt(vidmb);
				if(vidMb<checkMB)
				{	
					videoLinkSpan.style.display = 'block';
					$("#"+spanLink).fadeTo("slow", 1.00);	
					videoLinkSpan.style.margin = '1px';
					videoLinkSpan.style.borderLeft = '3px solid #ffec19';	
					videoLinkSpan.style.borderBottom = '1px solid #222222';
					videoLinkSpan.style.textDecoration = 'none';	
					k++;
				}
				else
				{
					$("#"+spanLink).fadeTo("slow", 0.33);
					if(hidden=="none")
					{
						$("#"+spanLink).slideUp("slow");
					}
					else
					{
						$("#"+spanLink).slideDown("slow");
					}
					videoLinkSpan.style.margin = '1px';
					videoLinkSpan.style.borderLeft = '3px solid #222222';
					videoLinkSpan.style.borderBottom = '1px solid #222222';
					videoLinkSpan.style.textDecoration = 'line-through';
				}						
			}
			else
			{
				$("#"+spanLink).fadeTo("slow", 0.33);
				if(hidden=="none")
				{
					$("#"+spanLink).slideUp("slow");
				}
				else
				{
					$("#"+spanLink).slideDown("slow");
				}
				videoLinkSpan.style.margin = '1px';
				videoLinkSpan.style.borderLeft = '3px solid #222222';
				videoLinkSpan.style.borderBottom = '1px solid #222222';
				videoLinkSpan.style.textDecoration = 'line-through';
			}
		}

		else if(searchTerm.substring(0,1).toLowerCase()=="*")
		{			
			var spanC = videoLinkSpan.innerHTML.split("<img");
			var starCount = spanC.length -1;						
			var showCount = parseInt(searchTerm.substring(1,2));

			if(showCount == starCount)
			{	
				videoLinkSpan.style.display = 'block';
				$("#"+spanLink).fadeTo("slow", 1.00);	
				videoLinkSpan.style.margin = '1px';
				videoLinkSpan.style.borderLeft = '3px solid #ffec19';	
				videoLinkSpan.style.borderBottom = '1px solid #222222';
				videoLinkSpan.style.textDecoration = 'none';	
				k++;
			}
			else
			{
				$("#"+spanLink).fadeTo("slow", 0.33);
				if(hidden=="none")
				{
					$("#"+spanLink).slideUp("slow");
				}
				else
				{
					$("#"+spanLink).slideDown("slow");
				}
				videoLinkSpan.style.margin = '1px';
				videoLinkSpan.style.borderLeft = '3px solid #222222';
				videoLinkSpan.style.borderBottom = '1px solid #222222';
				videoLinkSpan.style.textDecoration = 'line-through';					
			}
		}

		else
		{			
			if(hrefA.indexOf(searchTerm.toLowerCase())>-1 && searchTerm.length>0)
			{
				videoLinkSpan.style.display = 'block';
				$("#"+spanLink).fadeTo("slow", 1.00);	
				videoLinkSpan.style.margin = '1px';
				videoLinkSpan.style.borderLeft = '3px solid #ffec19';	
				videoLinkSpan.style.borderBottom = '1px solid #222222';
				videoLinkSpan.style.textDecoration = 'none';
				k++;
			}
			else if(hrefA.indexOf(searchTerm.toLowerCase())<0 && searchTerm.length>0)
			{
				$("#"+spanLink).fadeTo("slow", 0.33);
				videoLinkSpan.style.margin = '1px';
				videoLinkSpan.style.borderLeft = '3px solid #222222';	
				videoLinkSpan.style.borderBottom = '1px solid #222222';
				if(hidden=="none")
				{
					$("#"+spanLink).slideUp("slow");
				}
				else
				{
					$("#"+spanLink).slideDown("slow");
				}
				videoLinkSpan.style.textDecoration = 'line-through';
			}		
			else
			{
				$("#"+spanLink).fadeTo("slow", 1.00);
				videoLinkSpan.style.display = 'block';
				videoLinkSpan.style.margin = '1px';
				videoLinkSpan.style.borderLeft = '3px solid #222222';
				videoLinkSpan.style.borderBottom = '1px solid #222222';
				videoLinkSpan.style.textDecoration = 'none';
			}		
		}
	}
	if(k>0)
	{
		document.getElementById("vidMatches").innerHTML = "<b class='searchOpt'> &nbsp;&nbsp;" + k + "</b> matches";
	}
	else
	{
		document.getElementById("vidMatches").innerHTML = "";
	}
}


function getViewStatus(dest) 
{ 
	try { 
		xmlhttpa = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	catch (e) 
	{ 
		
	} 
	xmlhttpa.onreadystatechange = getViewStatusoutput;

	xmlhttpa.open("GET", dest, true); 
	xmlhttpa.send(null); 
} 

function getViewStatusoutput() 
{ 
	if ((xmlhttpa.readyState == 4) && (xmlhttpa.status == 200)) { 
		// fail
	} 
}

function changeViewStatus(element,file)
{
	document.getElementById(element).innerHTML = "";
	var dest = "index.php?changeViewStatus=" + file;
	getViewStatus(dest,element);
}

function request_access(){
	var email = document.getElementById('request_email').value;
	if(email.indexOf('@')>0)
	{
		var query = "requesturl=true&email=" + email;
		document.location.href="http://dev.feeditout.com/photos/index.php?" + query;
	}
}