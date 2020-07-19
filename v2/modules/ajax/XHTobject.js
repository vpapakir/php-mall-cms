function getXMLHttpRequest() 
{
    var xhr = null;

    if (window.XMLHttpRequest || window.ActiveXObject) 
    {
        if (window.ActiveXObject) //if visitor use IE < 7
        {
            try 
            {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } 
            catch(e) 
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } 
        else 
        {
            xhr = new XMLHttpRequest(); 
        }
    } 
    else 
    {
        alert("Your browser doesn't support XMLHTTPRequest object, please update it or install another one like Firefox, Opera or Chrome");
        return null;
    }

    return xhr;
}


