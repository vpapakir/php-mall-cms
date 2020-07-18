function requestKprodimmoPiecesOutGeneral()
{
    var xhr = getXMLHttpRequest();
    var totalrooms = document.getElementById('txtKprodimmoNumOutHousesGeneral').value;
    var totalrooms_msg = document.getElementById('KprodimmoNumOutHousesGeneralMSG');
    
    
    
    if(isNaN(totalrooms) || totalrooms == '')
    {
        if(totalrooms == '')
        {
           totalrooms_msg.style.display = 'none';     
        }
        else
        {
           totalrooms_msg.style.display = 'inline';     
        }
        
        document.getElementById("ajaxloaderOutHousesGeneral").style.display = 'none';
        return;
    }
    else
    {
        totalrooms_msg.style.display = 'none';
    }    
    
//    if(xhr && xhr.readyState != 0)
//    {
//        xhr.abort();
//    }
//    
//    
//    
//    xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() 
    {              
            // readyState == 4 means "DONE"
            // status = 200 means "Everything is OK (Server Code like 404 or 500)"
            // status = 0 means for local test only
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) 
            {
                    //alert(xhr.responseText);
                    var callback = xhr.responseText;
                    document.getElementById("ajaxloaderOutHousesGeneral").style.display = 'none';
                    document.getElementById('ajax_incelement_KprodimmoExterior').innerHTML = callback;
            }
            else
            {
                if(xhr.readyState < 4)
                {
                    document.getElementById("ajaxloaderOutHousesGeneral").style.display = 'inline';    
                }
            }
    };    
    
    xhr.open("POST", $COOBOX_BASE_URL."modules/custom/immo/modules/Kprodimmo/exterior/exterior_ajaxoutrooms.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("nbroomsout="+totalrooms);
}








