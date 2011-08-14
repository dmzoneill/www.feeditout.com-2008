function dislpayTVShowTitle(filename)
{

  var xmlDoc = new XMLHttpRequest();
  xmlDoc.open("GET",filename,false);
  xmlDoc.send("");
  xmlDoc=xmlDoc.responseXML;
  var tvShowTitle = xmlDoc.getElementsByTagName('title').item(0).firstChild.nodeValue;
  var textdata = document.createTextNode(tvShowTitle);
  var newParagraph = document.createElement('p');
  newParagraph.appendChild(textdata);
  document.getElementById('title_container').appendChild(newParagraph);
}

