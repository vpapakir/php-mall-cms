function requestKprodimmoCityGetinfo()
{
    var xhr = getXMLHttpRequest();
    var resulttag = document.getElementsByName('KprodimmoCityResultList');
    var li = document.getElementsByTagName('li');
    var otherinfo = document.getElementById('KprodimmoCityOtherInfo');
    
    //var chosenoption = '';
    var total_li = li.length;  

    for(var i = 0; i < total_li; i++)
    { 
        if(li[i].id == 'thisoption')
        {
           var chosenoption = resulttag[i].value;
           otherinfo.style.display = '';
           i = total_li;
        }
        else
        {
           otherinfo.style.display = 'none';
        }
    }

    xhr.onreadystatechange = function() 
    {              
            // readyState == 4 means "DONE"
            // status = 200 means "Everything is OK (Server Code like 404 or 500)"
            // status = 0 means for local test only
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) 
            {
                    
                    var callback = xhr.responseText;
                    //alert(xhr.responseText);
                    document.getElementById("ajaxloaderKprodimmoCity").style.display = 'none';
                    otherinfo.innerHTML = callback;
            }
            else
            {
                if(xhr.readyState < 4)
                {
                    document.getElementById("ajaxloaderKprodimmoCity").style.display = 'inline';    
                }
            }
    };    
    
	var baseURL = "http://fp-distribution.com/";
	var filePath = "modules/custom/multishop/modules/Kprodimmo/situation/situation_ajaxcity_getinfo.php";

    xhr.open("POST", baseURL.concat(filePath), true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    if (window.XMLHttpRequest || window.ActiveXObject) 
    {
        
    }
    else
    {
        xhr.withCredentials = true; //send actuals sessions value
    }

    xhr.send("txtKprodimmoCityResultList="+chosenoption); 
}


