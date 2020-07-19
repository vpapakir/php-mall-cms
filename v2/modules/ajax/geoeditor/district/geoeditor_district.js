function requestGEOEDITDistrict()
{
    var xhr = getXMLHttpRequest();
    var inputform = document.getElementById('txtSearchCDRgeoDistrict').value;
    var results = document.getElementById('SearchResultCDRgeoDistrict');  
    var resultsDIV = document.getElementById('SearchDIVCDRgeoDistrict'); 
    //var otherinfo = document.getElementById('KprodimmoDistrictOtherInfo');
    
    //otherinfo.style.display = 'none';
    
    if(inputform.length <= 0)
    {
        results.style.display = 'none';                    
        document.getElementById("ajaxloaderCDRgeoDistrict").style.display = 'none';
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
                    document.getElementById("ajaxloaderCDRgeoDistrict").style.display = 'none';
                    results.innerHTML = callback;
            }
            else
            {
                if(xhr.readyState < 4)
                {
                    document.getElementById("ajaxloaderCDRgeoDistrict").style.display = 'inline';    
                }
            }
    };    
    
    xhr.open("POST", $COOBOX_BASE_URL."modules/cdr/cdrgeo/district/district_ajaxlist.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    if (window.XMLHttpRequest || window.ActiveXObject) 
    {
        
    }
    else
    {
        xhr.withCredentials = true; //send actuals sessions value
    }
    
    xhr.send("txtSearchCDRgeoDistrict="+inputform);
}


