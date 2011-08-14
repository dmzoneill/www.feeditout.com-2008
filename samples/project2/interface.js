/*

    Written by David O Neill
    Student Id 0813001
    Document Arhitectures
    
    Interface for Jquery
    
    1. Wait for document ready event
    2. Call LoadCatalog()
       
       2.1. Perform a HttpRequest for catalog.xml       
       2.2. parse catalog for dvdentries       
       2.3. call addMenuOption() with each (XXX.xml)   
       
            2.3.1 addMenuOption() Fetches XXX.xml
            2.3.2 addMenuOption reads XXX.xml's title
            2.3.3 add <option> to <select>
    
    3. connect signal onChange to the onSelectChange() event handler.    
    
*/


// wait for DOM Ready event
$(document).ready(function()
{   
    loadCatalog();    
    // connect the signal event handler
    $("#dvdMenu").change(onSelectChange);     

});  

       


// load and parse the catalog of xml files
function loadCatalog()
{
    // http request for catlog.xml
    $.ajax({ type: "GET", url: "catalog.xml", dataType: "xml", success: function(xml) 
        {      
            // iterate the catalog
            $(xml).find('dvdEntry').each(function()
            {     
                // pass the xml entry file name to the addMenuOption() 
                addMenuOption($(this).text());
            });                            
        }
    });
}
        
       
       
// read xml dvd file and add it to select box            
function addMenuOption(dvdFile)
{
    // http request for dvdFile (xxx.xml)
    $.ajax({ type: "GET", url: dvdFile, dataType: "xml", success: function(xml) 
        {
             // locate the dvd(s)
             $(xml).find('dvd').each(function()
             {           
                  // grab the title of the dvd for the title node
                  var title = $(this).find('title').text();
                  // append a new option into the select box
                  $("#dvdMenu").append($("<option></option>").attr("value",dvdFile).text(title)); 
             });                            
         }                    
    });         
}


var extraInfo = false;

// parse the selected xml file from the signal event
function parseXmlDoc(xml, name)
{    
    $(xml).find('dvd').each(function()
    {
        // Dvd Presenter
        $("#dvdPresenter").empty();        
        $(xml).find('presenter').each(function()
        {
            $(this).find('companyname').each(function()
            {
                $("#dvdPresenter").append($("<p></p>").attr("style","font-weight:bold;").attr("id","pPresent").text($(this).text()));              
            });
        });
        $("#pPresent").append(" presents a "); 
        
        // Dvd Production
        $("#dvdProduction").empty();
        $(xml).find('production').each(function()
        {
            $(this).find('companyname').each(function()
            {
                //$("#dvdProduction").append($("<p></p>").text($(this).text())); 
                $("#pPresent").append($(this).text() + " production. "); 
            });
        });
        $("#dvdProduction").append($("<br/>"));
        
        // Dvd directors
        $("#dvdDirectors").empty();
        $("#dvdDirectors").append("<b>Directed by :</b> <br/><br/>");
        $("#dvdDirectors").append($("<p></p>").attr("id","pDirectors"))
        $(xml).find('directors').each(function()
        {
            $(this).find('person').each(function()
            {
                var firstName = $(this).find('firstname').text();
                var surName = $(this).find('surname').text();
                
                $("#pDirectors").append("<i>" + firstName + " " + surName + "</i> ");              
            });
        });
        $("#dvdDirectors").append($("<br/>"));
        
        // Dvd releasedate
        $("#dvdReleaseDate").empty();
        $(xml).find('released').each(function()
        {
            $(this).find('date').each(function()
            {
                var year = $(this).find('year').text();
                
                $("#dvdReleaseDate").append($("<p></p>").text(year));              
            });
        });
        $("#dvdReleaseDate").prepend($("<p></p>").attr("style","font-weight:bold;").text("Released : "));
        $("#dvdReleaseDate").append($("<br/>"));
        
        // Dvd producers
        $("#dvdProducers").empty();
        $(xml).find('dvdProducers').each(function()
        {
            $(this).find('person').each(function()
            {
                var firstName = $(this).find('firstname').text();
                var surName = $(this).find('surname').text();
                
                $("#dvdProducers").append($("<p></p>").text(firstName + " " + surName));              
            });
        });
        $("#dvdProducers").append($("<br/>"));
        
        // Dvd coproducers
        $("#dvdCoProducers").empty();        
        $(xml).find('dvdCoProducers').each(function()
        {
            $(this).find('person').each(function()
            {
                var firstName = $(this).find('firstname').text();
                var surName = $(this).find('surname').text();
                
                $("#dvdCoProducers").append($("<p></p>").text(firstName + " " + surName));              
            });
        });
        $("#dvdCoProducers").prepend($("<p></p>").attr("style","font-weight:bold;").text("Co Producers : "));
        $("#dvdCoProducers").append($("<br/>"));
        
        // Dvd actors
        $("#dvdActors").empty();
        $("#dvdActors").append("<b>Starring :</b> <br/><br/>");
        $("#dvdActors").append($("<p></p>").attr("id","pActors"));
        $(xml).find('actors').each(function()
        {
            $(this).find('person').each(function()
            {
                var firstName = $(this).find('firstname').text();
                var surName = $(this).find('surname').text();
                $("#pActors").append("<i>" + firstName + " " + surName + ", </i>");
                              
            });
        });  
        $("#dvdActors").append($("<br/>"));
        
        
        
        
        // Dvd Description
        $("#dvdDescriptionShort").empty();
        $("#dvdDescription").empty();
        
        var plot = $(this).find('plot').text();
        var plotshort = plot.substr(0,250);
        
        $("#dvdDescription").html($("<p></p>").text(plot));        
        $("#dvdDescription").append($("<br/>"));
        $("#dvdDescription").append($("<a></a>").attr("href","#").attr("id","fullSynopsys").text("Short synopsys"));
        $("#dvdDescription").append($("<br/><br/>"));
        $("#dvdDescription").prepend($("<p></p>").attr("style","font-weight:bold; margin-bottom:15px; margin-top:0px;").text("Synopsys"));
        $("#dvdDescription").hide();        
                
        $("#dvdDescriptionShort").html($("<p></p>").text(plotshort + " ..."));
        $("#dvdDescriptionShort").append($("<br/>"));
        $("#dvdDescriptionShort").append($("<a></a>").attr("href","#").attr("id","shortSynopsys").text("Full synopsys"));
        $("#dvdDescriptionShort").append($("<br/><br/>"));
        $("#dvdDescriptionShort").prepend($("<p></p>").attr("style","font-weight:bold; margin-bottom:15px; margin-top:0px;").text("Synopsys"));
        $("#dvdDescriptionShort").slideDown("fast");
                
        // Setup click event handler for full synopsis link
        $("#shortSynopsys").click(function () { 
            $("#dvdDescriptionShort").hide();
            $("#dvdDescription").slideDown("fast");
        }); 
        
        // Setup click event handler for full synopsis link
        $("#fullSynopsys").click(function () { 
            $("#dvdDescription").hide();
            $("#dvdDescriptionShort").slideDown("fast");            
        }); 
        
        
        
        
        
        
        // Dvd music producers
        $("#dvdMusicProducers").empty();
        $(xml).find('musicProducers').each(function()
        {
            $(this).find('person').each(function()
            {
                var firstName = $(this).find('firstname').text();
                var surName = $(this).find('surname').text();
                
                $("#dvdMusicProducers").append($("<p></p>").text(firstName + " " + surName));              
            });
        }); 
        $("#dvdMusicProducers").prepend($("<p></p>").attr("style","font-weight:bold;").text("Music Producers : "));
        $("#dvdMusicProducers").append($("<br/>"));
        
        // Dvd costume designers
        $("#dvdCostumeDesigners").empty();
        $(xml).find('dvdCostumeDesigners').each(function()
        {
            $(this).find('person').each(function()
            {
                var firstName = $(this).find('firstname').text();
                var surName = $(this).find('surname').text();
                
                $("#dvdCostumeDesigners").append($("<p></p>").text(firstName + " " + surName));              
            });
        }); 
        $("#dvdCostumeDesigners").prepend($("<p></p>").attr("style","font-weight:bold;").text("Costume Designers : "));
        $("#dvdCostumeDesigners").append($("<br/>"));
        
        // Dvd copyright
        $("#dvdCopyright").empty();
        $(xml).find('copyright').each(function()
        {
            var companyname = $(this).find('companyname').text();
            var date = $(this).find('date:first-child').text();
            $("#dvdCopyright").append($("<p></p>").text(companyname + " " + date));              
        }); 
        $("#dvdCopyright").prepend($("<p></p>").attr("style","font-weight:bold;").text("Copyright : "));
        $("#dvdCopyright").append($("<br/>"));        
        
        // Dvd price
        $("#dvdPrice").empty();
        $(xml).find('price').each(function()
        {
            var price = $(this).text();
            $("#dvdPrice").append($("<p></p>").text(price));              
        }); 
        $("#dvdPrice").prepend($("<p></p>").attr("style","font-weight:bold;").text("Price : "));
        $("#dvdPrice").append($("<br/>"));
               
        
        var name_text = $(this).find('title').text();  
        var pic_text = $(this).find('picture').text();  
        var imdb_text = $(this).find('imdblink').text();
        
        $("#dvdImage").html("<a href='" + imdb_text + "'><img class='cover' src='pics/" + pic_text +"' /></a>");
        $("#dvdTitle").html($("<h1></h1>").text(name_text));
        $("#dvdTitle").append($("<br/>"));

        $("#other").empty();
        $("#other").append($("<p></p>").attr("id","pExtra"));
        $(xml).find('dvd').each(function()
        {
            var rating = $(this).attr("viewing");
            var genre = $(this).attr("genre");
            var runtime = $(this).attr("runtime");
            $("#pExtra").append("<b>Genre : </b>" + genre + "<br><br><b>Audience : </b>" + rating + "<br><br><b>Runtime : </b>" + runtime + "");              
        }); 
        $("#pExtra").prepend("<br/><br/>"); 
                       
                
        // Setup click event handler for moreinfo link
        $("#moreinfo").click(function () { 
            if (extraInfo==false) 
            {               
                $("#dvdProducers").slideDown("fast");   
                $("#dvdCoProducers").slideDown("fast"); 
                $("#dvdMusicProducers").slideDown("fast"); 
                $("#dvdCostumeDesigners").slideDown("fast"); 
                $("#dvdCopyright").slideDown("fast"); 
                $("#dvdPrice").slideDown("fast"); 
                $("#dvdReleaseDate").slideDown("fast"); 
                $("#other").slideDown("fast");
                extraInfo = true;
            } 
            else 
            {
                $("#dvdProducers").hide();   
                $("#dvdCoProducers").hide();   
                $("#dvdMusicProducers").hide();   
                $("#dvdCostumeDesigners").hide();   
                $("#dvdCopyright").hide();   
                $("#dvdPrice").hide();   
                $("#dvdReleaseDate").hide();   
                $("#other").hide();  
                extraInfo = false;
            }
        });        
    });  
    $("#loading").html("Done parsing " + name);
    // fade in the view      
    $("#dvdMain").fadeIn(2500); 
}
     
     

var splashPage = true; // initial view     
      
// handler for the onchange signal           
function onSelectChange()
{           
    if(splashPage==true)
    {
        $("#collection").hide();
        $("#dvdMenu").animate({"top": "15px"}, "fast");
        splashPage = false;
    }        
    
    $("#dvdProducers").hide();   
    $("#dvdCoProducers").hide();   
    $("#dvdMusicProducers").hide();   
    $("#dvdCostumeDesigners").hide();   
    $("#dvdCopyright").hide();   
    $("#dvdPrice").hide();   
    $("#dvdReleaseDate").hide();   
    $("#other").hide(); 
    extraInfo = false;
    
    // fade out the last view
    $("#dvdMain").fadeOut(1500, function(){
        // grab the selected entry
        var selected = $("#dvdMenu option:selected");       
        // check to see if its not 0 (first entry)
        if(selected.val() != 0)
        {  
            // start fetching the XML File
            $.ajax({ type: "GET", url: selected.val(), dataType: "xml", success: function(xml) 
                {
                    // parse the xml object
                    parseXmlDoc(xml,selected.text());                            
                }
            });
        } 
    });    
} 