

function showMovie()
{
    var selectedFile = document.getElementById("DVDMenu").value;
    
    var request = false;
    
    if (window.ActiveXObject) { //IE
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) { //other browsers
        request = new XMLHttpRequest();
    }
    
    request.onreadystatechange = function() 
    {
        if (request.readyState == 4) 
        {
            // clear the od, data first
            document.getElementById("maincontent").innerHTML = "";
            document.getElementById("dvdImage").innerHTML = "";
            document.getElementById("extracontent").innerHTML = "";
            
            
            // start generating the new data
            var xmlDoc = request.responseXML; // data in the file XML tree
            var xml_title = xmlDoc.getElementsByTagName('title').item(0).firstChild.nodeValue; // gets the name of the xml title <title> </title>
            
            
            var txt_title = document.createTextNode(xml_title); // create text node            
            var html_header_title = document.createElement('h2');
            html_header_title.appendChild(txt_title);   
            document.getElementById("maincontent").appendChild(html_header_title);
            
            var xml_picture = xmlDoc.getElementsByTagName('picture').item(0).firstChild.nodeValue;                    
            var html_img = document.createElement('img');
            html_img.setAttribute("src","pics/"+xml_picture);  
            document.getElementById("dvdImage").appendChild(html_img);
            
            // DIRECTOR
            var txt_director = document.createTextNode("Director"); // create text node            
            var html_director_header = document.createElement('h4');
            html_director_header.appendChild(txt_director);   
            document.getElementById("maincontent").appendChild(html_director_header);
            
            var xml_director = xmlDoc.getElementsByTagName('director').item(0);
            var xml_firstname = xml_director.getElementsByTagName('firstname').item(0).firstChild.nodeValue;
            var xml_surname = xml_director.getElementsByTagName('surname').item(0).firstChild.nodeValue;
            var txt_name = document.createTextNode(xml_firstname+" "+xml_surname); // create text node            
            var html_dir = document.createElement('p');
            html_dir.appendChild(txt_name); 

            document.getElementById("maincontent").appendChild(html_dir);
            // END DIRECTOR
            
            // ACTORS
            var txt_actor = document.createTextNode("Actors"); // create text node            
            var html_actor_header = document.createElement('h4');
            html_actor_header.appendChild(txt_actor);   
            document.getElementById("maincontent").appendChild(html_actor_header);
            
            
            var xml_actor = xmlDoc.getElementsByTagName('actors');
            for(var i=0 ; i < xml_actor.length ; i++)
            {
                var curr = xml_actor.item(i);
                var xml_firstname = curr.getElementsByTagName('firstname').item(0).firstChild.nodeValue;
                var xml_surname = curr.getElementsByTagName('surname').item(0).firstChild.nodeValue;
                var txt_name = document.createTextNode(xml_firstname+" "+xml_surname); // create text node            
                var html_act = document.createElement('p');
                html_act.appendChild(txt_name); 

                document.getElementById("maincontent").appendChild(html_act);
            }
            // END ACTORS
            
            
            // PLOT
            var txt_plot = document.createTextNode("Plot"); // create text node            
            var html_plot_header = document.createElement('h4');
            html_plot_header.appendChild(txt_plot);   
            document.getElementById("maincontent").appendChild(html_plot_header);
            var xml_plot= xmlDoc.getElementsByTagName('plot').item(0).firstChild.nodeValue; 
            var txt_plot = document.createTextNode(xml_plot); // create text node            
            var html_plot_txt = document.createElement('p');
            html_plot_txt.appendChild(txt_plot);   
            document.getElementById("maincontent").appendChild(html_plot_txt);
            // END PLOT
            
            
            // EXTRA CONTENT LINK
            var txt_link = document.createTextNode("more info"); // create text node            
            var html_link = document.createElement('a');
            html_link.appendChild(txt_link);   
            document.getElementById("maincontent").appendChild(html_link);
            
            html_link.setAttribute("href" , "javascript:getMoreInfo('"+selectedFile+"')");
            
            // END EXTRA CONTENT LINK
            
            
            
                     
            
            
            
            
            
            
        }
    }
    request.open("GET", selectedFile, true); 
    request.send(null);
  
}



function getMoreInfo(file)
{
    
    var request = false;
    
    if (window.ActiveXObject) { //IE
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) { //other browsers
        request = new XMLHttpRequest();
    }
    
    request.onreadystatechange = function() 
    {
        if (request.readyState == 4) 
        {
            var xmlDoc = request.responseXML;
            document.getElementById("extracontent").innerHTML = "";

             // PRODUCTION
            var txt_production = document.createTextNode("Production"); // create text node            
            var html_production_header = document.createElement('h4');
            html_production_header.appendChild(txt_production);   
            document.getElementById("extracontent").appendChild(html_production_header);
            var xml_production= xmlDoc.getElementsByTagName('production').item(0).firstChild.nodeValue; 
            var txt_production = document.createTextNode(xml_production); // create text node            
            var html_production_txt = document.createElement('p');
            html_production_txt.appendChild(txt_production);   
            document.getElementById("extracontent").appendChild(html_production_txt);
            // END PRODUCTION
            
       
            // PRODUCER
            var txt_producer = document.createTextNode("Producer"); // create text node            
            var html_producer_header = document.createElement('h4');
            html_producer_header.appendChild(txt_producer);   
            document.getElementById("extracontent").appendChild(html_producer_header);
            
            var xml_producer = xmlDoc.getElementsByTagName('producers').item(0);
            var xml_firstname = xml_producer.getElementsByTagName('firstname').item(0).firstChild.nodeValue;
            var xml_surname = xml_producer.getElementsByTagName('surname').item(0).firstChild.nodeValue;
            var txt_name = document.createTextNode(xml_firstname+" "+xml_surname); // create text node            
            var html_producer = document.createElement('p');
            html_producer.appendChild(txt_name); 

            document.getElementById("extracontent").appendChild(html_producer);
            // END PRODUCER
            
            
            // COPYRIGHT
            var txt_copyright = document.createTextNode("Copyright"); // create text node            
            var html_copyright_header = document.createElement('h4');
            html_copyright_header.appendChild(txt_copyright);   
            document.getElementById("extracontent").appendChild(html_copyright_header);
            var xml_copyright= xmlDoc.getElementsByTagName('copyright').item(0).firstChild.nodeValue; 
            var xml_date= xmlDoc.getElementsByTagName('released').item(0).firstChild.nodeValue; 
            var txt_copyright = document.createTextNode(xml_copyright + " " + xml_date); // create text node            
            var html_copyright_txt = document.createElement('p');
            html_copyright_txt.appendChild(txt_copyright);   
            document.getElementById("extracontent").appendChild(html_copyright_txt);
            // END COPYRIGHT
            
            var runtime = xmlDoc.getElementsByTagName('dvd').item(0).getAttribute("runtime");
            var viewing = xmlDoc.getElementsByTagName('dvd').item(0).getAttribute("viewing");
            var genre = xmlDoc.getElementsByTagName('dvd').item(0).getAttribute("genre");
            // 
            var txt_runtime = document.createTextNode("Runtime : " + runtime + " "); // create text node     
            var txt_viewing = document.createTextNode("Viewing : " + viewing + " "); // create text node            
            var txt_genre = document.createTextNode("Genre : " + genre); // create text node            
            var html_extra = document.createElement('p');
            html_extra.appendChild(txt_runtime);   
            html_extra.appendChild(txt_viewing);
            html_extra.appendChild(txt_genre);
            document.getElementById("extracontent").appendChild(html_extra);
            
            // END 
            
            
            
            
            
        }
    }
    request.open("GET", file, true); 
    request.send(null);
  

}



















function createMenu()
{
    var films = new Array("m1.xml","m2.xml","m3.xml");
    for(var i=0 ; i<films.length; i++)
    {
        getTitle(films[i]);
    }
}


function getTitle(xmlFile)
{
    var request = false;
    
    if (window.ActiveXObject) { //IE
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) { //other browsers
        request = new XMLHttpRequest();
    }
    
    request.onreadystatechange = function() 
    {
        if (request.readyState == 4) 
        {
            var xmlDoc = request.responseXML; // data in the file XML tree
            var title = xmlDoc.getElementsByTagName('title').item(0).firstChild.nodeValue; // gets the name of the xml title <title> SABRINA </title>
            
            var textdata = document.createTextNode(title); // create text node            
            var option = document.createElement('option');
            option.appendChild(textdata);   
            option.setAttribute("value",xmlFile); // <option value='filename'>title</option>     
            document.mainForm.DVDMenu.appendChild(option);
        }
    }
    request.open("GET", xmlFile, true); 
    request.send(null);
}