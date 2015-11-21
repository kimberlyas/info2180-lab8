// JavaScript File

window.onload = function() 
 {
    // Listen for clicks on the button with id of lookup
    document.getElementById("lookup").onclick = fetchData;
               
 };
               
function fetchData() // fetch data from world.php
   {
        // Lookup any word entered into the textbox
        var searchText = document.getElementById("term").value;
        // Opening an Ajax connection
        /*new Ajax.Request("world.php?lookup="+searchText,
        {
            method: "get",
            onSuccess: displayResult
        } );*/
        // Validate checkboxes
        if (document.getElementById("all").checked)
        {
            if(document.getElementById("xml").checked)
            {
                // return in xml
                new Ajax.Request('world.php?all=true&format=xml',{method: 'get',onSuccess: displayResult});
            }
            else
            {
                // fetch all data
                new Ajax.Updater('result','world.php',{method: 'get', parameters:'?all=true'});
            }        
        }
        else
        {
            // Place in div
            new Ajax.Updater({success:'result'},'world.php?lookup='+searchText,{method: 'get'});
        }
        
   }
                
function displayResult(data)
 {
    //alert(data.responseText);
    
     // Create an ordered list
    var ordList = document.createElement('ol');
                    
    // Get elements
    var xml = data.responseXML;
    var countryArray = xml.getElementsByTagName('name');
    var rulerArray = xml.getElementsByTagName('ruler');

    // For each country add an item to the list
    for ( var i = 0; i < countryArray.length; i++)
    {
        // Create <li> tags
        var listItem = document.createElement('li'); 
        // The inner text
        var listText = document.createTextNode(countryArray[i].innerHTML + ", ruled by " + rulerArray[i].innerHTML);               
        // Add text to <li>
        listItem.appendChild(listText);
        // Append <li> to <ol>
        ordList.appendChild(listItem);
    }
    console.log(ordList);
    // Add to div
    document.getElementById('result').appendChild(ordList);
 }
 