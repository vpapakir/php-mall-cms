function requestGEOEDITDepartmentGetinfo()
{
    var xhr = getXMLHttpRequest();
    var resulttag = document.getElementsByName('SearchCDRgeoDepartmentResultListID');
    var li = document.getElementsByTagName('li');
    var expandCity = document.getElementById('expand_collapseCDRgeoCity');
    expandCity = expandCity.value;
    var expandCountry = document.getElementById('expand_collapseCDRgeoCountry');
    expandCountry = expandCountry.value;
    var expandDepartment = document.getElementById('expand_collapseCDRgeoDepartment');
    expandDepartment = expandDepartment.value;
    var expandDistrict = document.getElementById('expand_collapseCDRgeoDistrict');
    expandDistrict = expandDistrict.value;
    var expandRegion = document.getElementById('expand_collapseCDRgeoRegion');
    expandRegion = expandRegion.value;
    var total_li = li.length;  

    for(var i = 0; i < total_li; i++)
    { 
        if(li[i].id == 'thisoption')
        {
           var chosenoption = resulttag[i].value;
           i = total_li;
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
        }
    };    
    
    xhr.open("POST", $COOBOX_BASE_URL."modules/cdr/cdrgeo/department/department_ajaxlist_getinfo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    if (window.XMLHttpRequest || window.ActiveXObject) 
    {
        
    }
    else
    {
        xhr.withCredentials = true; //send actuals sessions value
    }

    xhr.send("SearchCDRgeoDepartmentValue="+chosenoption+
        "&ExpandCDRgeoCityValue="+expandCity+
        "&ExpandCDRgeoCountryValue="+expandCountry+
        "&ExpandCDRgeoDepartmentValue="+expandDepartment+
        "&ExpandCDRgeoDistrictValue="+expandDistrict+
        "&ExpandCDRgeoRegionValue="+expandRegion);
}


