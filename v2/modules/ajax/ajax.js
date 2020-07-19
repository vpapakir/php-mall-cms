var xhr = getXMLHttpRequest();

xhr.onreadystatechange = function() 
{
	if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) 
        {
		alert("OK");
	}
};

xhr.open("POST", "product_main.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

var totalrooms = encodeURIComponent();

xhr.send();


