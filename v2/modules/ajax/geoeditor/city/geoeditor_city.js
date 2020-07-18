function requestGEOEDITCity()
{
    var xhr = getXMLHttpRequest();
    var inputform = document.getElementById('txtSearchCDRgeoCity').value;
    var results = document.getElementById('SearchResultCDRgeoCity');  
    var resultsDIV = document.getElementById('SearchDIVCDRgeoCity'); 
    //var otherinfo = document.getElementById('KprodimmoCityOtherInfo');
    
    //otherinfo.style.display = 'none';
    
    if(inputform.length <= 0)
    {
        results.style.display = 'none';                    
        document.getElementById("ajaxloaderCDRgeoCity").style.display = 'none';
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
                    document.getElementById("ajaxloaderCDRgeoCity").style.display = 'none';
                    results.innerHTML = callback;
            }
            else
            {
                if(xhr.readyState < 4)
                {
                    document.getElementById("ajaxloaderCDRgeoCity").style.display = 'inline';    
                }
            }
    };    
    
    xhr.open("POST", $COOBOX_BASE_URL."modules/cdr/cdrgeo/city/city_ajaxlist.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    if (window.XMLHttpRequest || window.ActiveXObject) 
    {
        
    }
    else
    {
        xhr.withCredentials = true; //send actuals sessions value
    }
    
    xhr.send("txtSearchCDRgeoCity="+inputform);
}


