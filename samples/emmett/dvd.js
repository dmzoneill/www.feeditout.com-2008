
/*

From the html file <body onload="">
We call this function start

start has an array for xml files
which we pass to the getDvdTitles(xSets) function

*/

function start()
{
    var dvds = [ "FilmSabrina.xml", "FilmThe Holiday.xml", "FilmTitanic.xml" ];  
    getDvdTitles(dvds); // pass the entire array
}


/*

getDvdTitles(xSets) loops through each xml file in the array
and passes it to the getFilmTitle(filename) function

*/

function getDvdTitles(xSets) 
{
   for(var i = 0; i < xSets.length; i++) 
   {
       // first iteration sarbine.xml
       // second iteration titanic.xml
       // so on
       getFilmTitle(xSets[i]);  
       //alert(xSets[i]);
   }
}


/*

getFilmTitle(filename) creates a new XML http request
reads the titles from the xml object

creates a new <option> element 
when then create a text element which is appeneded to the child node of <option>

using get document by id (javascript method) we access the slect box in the html page
finally we append this new option to the select box

*/

function getFilmTitle(filename) // sabinra.xml ...
{
    var request;
    var capable = true;
    
    try  { request = new ActiveXObject("Msxml2.XMLHTTP.6.0");  }
    catch(e) 
    {
        try { request = new ActiveXObject("Msxml2.XMLHTTP.3.0");  }
        catch(e) 
        {
            try { request = new ActiveXObject("Msxml2.XMLHTTP");  }
            catch(e) 
            {
		try { request = new ActiveXObject("Microsoft.XMLHTTP");  }
                catch(e) 
                {
                    try { request = new XMLHttpRequest(); }
                    catch(e) 
                    {
                        capable = false;
                    }                      
                }
            }
        }
    }

    if(capable == false)
    {
        alert("Unable to create a new http Xml request");
        return;
    }
    
    request.onreadystatechange = function() 
    {
        if (request.readyState == 4) 
        {
            var xmlDoc = request.responseXML; // data in the file XML tree
            var setTitle = xmlDoc.getElementsByTagName('title').item(0).firstChild.nodeValue; // gets the name of the xml title <title> SABRINA </title>
            
            var textdata = document.createTextNode(setTitle); // create text node            
            var selectBox = document.getElementById('dvdMenu');
            
            var option = document.createElement('option');
            option.setAttribute("value",filename);

            var theText = document.createTextNode(setTitle);            
            option.appendChild(theText);     
                        
            // <option value="sabrina.xml"> Sabrina </option>
            document.dvdForm.mySelect.appendChild(option); // works in both browswers
            //document.getElementById('dvdMenu').appendChild(option); // doesn't work in internet explorer 
        }
    }
    request.open("GET", filename, true); 
    request.send(null);
}


/* 

Sees which option that has been selected in the <select> box on the hmtl page
loads this selected object
displays information to the user

*/


function loadDVdContent()
{
    var selectedFile = document.getElementById("dvdMenu").value;
  
    var request = false;
    
    if (window.ActiveXObject) { //IE
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) { //other browsers
        request = new XMLHttpRequest();
    }
    
    request.open('GET', selectedFile, true);
    request.onreadystatechange = function() 
    {
        if (request.readyState == 4) 
        {
            var xmlDoc = request.responseXML; // data in the file XML tree
            document.getElementById('mainContent').innerHTML = "";
            
            // get the title
            var setTitle = xmlDoc.getElementsByTagName('title').item(0).firstChild.nodeValue;  
            
            // get the description
            var description = xmlDoc.getElementsByTagName('description').item(0).firstChild.nodeValue; 
            
            var director = xmlDoc.getElementsByTagName('director').item(0); //
            
            // get actors
            var actors = xmlDoc.getElementsByTagName('actor'); // "john wilson", "micky mouse", ""
            
            // get actresses
            var actresses = xmlDoc.getElementsByTagName('actress'); // "john wilson", "micky mouse", ""
            
           
            // Get the title 
            // <h1> the name of the films </h1>
            var titleTextData = document.createTextNode(setTitle);            
            var titleHeader = document.createElement('h1');
            titleHeader.appendChild(titleTextData);            
            document.getElementById('mainContent').appendChild(titleHeader);  
            
            // description of the film
            // <p> description </p>
            var descriptionTextdata = document.createTextNode(description);              
            var paragraph = document.createElement('p');
            paragraph.appendChild(descriptionTextdata);                 
            document.getElementById('mainContent').appendChild(paragraph);        
              
            
            // header for director             
            var directorHeaderTextNode = document.createTextNode("Director");            
            var directorHeader = document.createElement('h3');
            directorHeader.appendChild(directorHeaderTextNode);            
            document.getElementById('mainContent').appendChild(directorHeader);
            
             var firstname =  director.getElementsByTagName('firstname').item(0).firstChild.nodeValue;        
             var lastname =  director.getElementsByTagName('surname').item(0).firstChild.nodeValue;
             var nameTextdata = document.createTextNode(firstname + " " + lastname);              
             var paragraph = document.createElement('p');
             paragraph.appendChild(nameTextdata);                 
             document.getElementById('mainContent').appendChild(paragraph);
            
            // header for actors             
            var actorHeaderTextNode = document.createTextNode("Actors");            
            var actorsHeader = document.createElement('h3');
            actorsHeader.appendChild(actorHeaderTextNode);            
            document.getElementById('mainContent').appendChild(actorsHeader);  
            
            // now add all the actors to a paragraph below this header
            for(var i = 0; i < actors.length; i++)
            {
                var firstname =  actors[i].getElementsByTagName('firstname').item(0).firstChild.nodeValue;        
                var lastname =  actors[i].getElementsByTagName('surname').item(0).firstChild.nodeValue;
                var nameTextdata = document.createTextNode(firstname + " " + lastname);              
                var paragraph = document.createElement('p');
                paragraph.appendChild(nameTextdata);                 
                document.getElementById('mainContent').appendChild(paragraph);
            }           
            
            // now add all the actresses to a paragraph below this header
            for(var i = 0; i < actresses.length; i++)
            {
                var firstname =  actresses[i].getElementsByTagName('firstname').item(0).firstChild.nodeValue;        
                var lastname =  actresses[i].getElementsByTagName('surname').item(0).firstChild.nodeValue;
                var nameTextdata = document.createTextNode(firstname + " " + lastname);              
                var paragraph = document.createElement('p');
                paragraph.appendChild(nameTextdata);                 
                document.getElementById('mainContent').appendChild(paragraph);
            }
            
            var picture = xmlDoc.getElementsByTagName('DVDCoverDetails').item(0).getAttribute("DVDCoverDesign");
            document.getElementById('filmImage').src='pictures/'+ picture;  
            
            var linkValue = document.createTextNode("click here for more information");  
            var moreInfoLink = document.createElement('a');
            moreInfoLink.appendChild(linkValue);            

            moreInfoLink.setAttribute('href',"javascript:getMoreInfo('"+selectedFile+"')");
            document.getElementById('mainContent').appendChild(moreInfoLink);
            
        }
    }
    request.send(null);
}


function getMoreInfo(filename)
{
    var request = false;
    
    if (window.ActiveXObject) { //IE
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) { //other browsers
        request = new XMLHttpRequest();
    }
    
    request.open('GET', filename, true);
    request.onreadystatechange = function() 
    {
        if (request.readyState == 4) 
        {
            var xmlDoc = request.responseXML; // data in the file XML tree
            var directorHeaderTextNode = document.createTextNode("Characters");            
            var directorHeader = document.createElement('h3');
            directorHeader.appendChild(directorHeaderTextNode);            
            document.getElementById('mainContent').appendChild(directorHeader);
                        // get characters
            var characters = xmlDoc.getElementsByTagName('character');
            for(var i = 0; i < characters.length; i++)
            {
                var name =  characters[i].firstChild.nodeValue;       
                var nameTextdata = document.createTextNode(name);              
                var paragraph = document.createElement('p');
                paragraph.appendChild(nameTextdata);                 
                document.getElementById('mainContent').appendChild(paragraph);
            }
            var releaseYear = xmlDoc.getElementsByTagName('title').item(0).getAttribute("year");
            var yearTextdata = document.createTextNode("Released : " + releaseYear);   
            document.getElementById('mainContent').appendChild(yearTextdata);
            
            var runTime = xmlDoc.getElementsByTagName('title').item(0).getAttribute("time");
            var runTextdata = document.createTextNode(" Run time : " + runTime);   
            document.getElementById('mainContent').appendChild(runTextdata);
         }
    }
    request.send(null);

}
