function requestKprodimmoCity()
{
    var xhr = getXMLHttpRequest();
    var inputform = document.getElementById('txtKprodimmoCity').value;
    var results = document.getElementById('KprodimmoCityResult');  
    var resultsDIV = document.getElementById('KprodimmoCityDIV'); 
    var otherinfo = document.getElementById('KprodimmoCityOtherInfo');
    
    otherinfo.style.display = 'none';
    
    if(inputform.length <= 0)
    {
        results.style.display = 'none';                    
        document.getElementById("ajaxloaderKprodimmoCity").style.display = 'none';
        resultsDIV.style.display = 'none';
        return;
        
    }
    else
    {
        resultsDIV.style.display = 'block';
        results.style.display = 'inline';
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
                    results.innerHTML = callback;
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
	var filePath = "modules/custom/multishop/modules/Kprodimmo/situation/situation_ajaxcity.php";
    
    xhr.open("POST", baseURL.concat(filePath), true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    if (window.XMLHttpRequest || window.ActiveXObject) 
    {
        
    }
    else
    {
        xhr.withCredentials = true; //send actuals sessions value
    }
    
    xhr.send("txtKprodimmoCity="+inputform);    
}


