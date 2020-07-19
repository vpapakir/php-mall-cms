function submitonce(theform){
	//if IE 4+ or NS 6+
	if (document.all||document.getElementById)
	{
		//screen thru every element in the form, and hunt down "submit" and "reset"
		for (i=0;i<theform.length;i++)
		{
			var tempobj=theform.elements[i]
			if(tempobj.type.toLowerCase()=="submit"||tempobj.type.toLowerCase()=="reset")
			//disable em
			tempobj.disabled=true
		}
	}
}

function popup(url,w,h,sb)
{
	atr = '';
	atr = atr + 'toolbar=no,';
	if (sb)
	{
		atr = atr + 'scrollbars=no,';
	}
	else
	{
		atr = atr + 'scrollbars=yes,';
	}
	atr = atr + 'location=no,';
	atr = atr + 'statusbar=no,';
	atr = atr + 'menubar=no,';
	atr = atr + 'resizable=yes,';
	if (w) {
	atr = atr + 'width='+w+',';
	atr = atr + 'height='+h;
	}
	else{
	atr = atr + 'width=700,';
	atr = atr + 'height=500';
	}
	new_window=window.open(url,'_blank',atr);
	new_window.focus();
}

function popupimg (url)
{
	popup(url,1,1);
}

function goopener (url)
{
window.opener.focus();
window.opener.location=url;
window.close();
}
function closepopup ()
{
window.opener.focus();
window.close();
}
function goback (url) {
window.location=url;
}

function gosearch (module,url)
{
	if (document.searchform.searchword.value)
		{
			if (module == 'article')
			{
				window.location=url+'&filtr='+document.searchform.searchword.value;
			}
		}
}


function SetFocus() {
  if (document.forms.length > 0) {
    var field = document.forms[0];
    for (i=0; i<field.length; i++) {
      if ( (field.elements[i].type != "image") && 
           (field.elements[i].type != "hidden") && 
           (field.elements[i].type != "reset") && 
           (field.elements[i].type != "submit") ) {

        document.forms[0].elements[i].focus();

        if ( (field.elements[i].type == "text") || 
             (field.elements[i].type == "password") )
          document.forms[0].elements[i].select();
        
        break;
      }
    }
  }
}


function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v3.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

// end images rollover efects functions

/**
 * Displays an confirmation box beforme to submit a "DROP/DELETE/ALTER" query.
 * This function is called while clicking links
 *
 * @param   object   the link
 * @param   object   the sql query to submit
 onclick="return confirmlink(this, 'DROP TABLE `tslc_oeuvre`')
 *
 * @return  boolean  whether to run the query or not
 */

function confirmlink(theLink, theSqlQuery)
{
    // Confirmation is not required in the configuration file
alert ('test');
    var is_confirmed = confirm(theSqlQuery);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

    return is_confirmed;
} // end of the 'confirmLink()' function

function selectLink(formName, formField, confirmText, positions){
//Redirect browser to the link in the VALUE of the formFiled of the formName

//positions - comma separated option ids, like: 2,3,5, which will be confirmed
//in case if you have more options to delete...
	var val = document.forms[formName].elements[formField].value;
	var del = document.forms[formName].elements[formField].selectedIndex;
	
	var optionsToConfirm = positions.split(",");
	var conf=0;
	
	for(i=0; i<optionsToConfirm.length; i++)
	{
		if(del == parseInt(optionsToConfirm[i])) { conf=1; }
	}

	if(confirmText && conf )
	{
		if(confirm(confirmText)) {location.replace(val);} else { return false; }
	}
	else
	{
		location.replace(val);
	}
}

function confirmDelete(form, text)
{
    var is_confirmed = confirm(text);
	var formName=form;
    if (is_confirmed) {
        document.forms[formName].submit();
    }
} 


function convertToAlias(fieldInput,fieldResult){
	fieldInputObj = document.getElementById(fieldInput);
	fieldResultObj = document.getElementById(fieldResult);
	if(fieldResultObj.value==""){
		var ref=fieldInputObj.value;
		var i=0;
		while(ref.length > i){
			ref=ref.replace(' ','-');
			ref=ref.replace('&','-');
			i=i+1;
		}
		ref=ref.substring(0,50);
		//fieldResultObj.value=ref.toUpperCase();
		fieldResultObj.value = ref;
	}
}

var gClientIsGecko = (window.controllers) ? true : false;
var gClientIsOpera = (window.opera) ? true : false;
var gClientIsIE    = (document.all && !gClientIsOpera) ? true : false;
var gClientIsIE5   = (gClientIsIE && /MSIE 5\.0/.test(navigator.appVersion)) ? true : false;
var gClientIsMac   = (/Mac/.test(navigator.appVersion)) ? true : false;

function showDiv (el, div, alignX, alignY) {
	// (i) popups etc
	if (document.getElementById){
    	var i = document.getElementById(el);
		var c = document.getElementById(div);
        if (c.style.display != "block"){
			
			//var l=0; var t=0;
            //aTag = i;
            //do {
            //    aTag = aTag.offsetParent;
            //    l += aTag.offsetLeft;
            //    t += aTag.offsetTop;
			//} while (aTag.offsetParent && aTag.tagName != 'BODY');
	        //var left =  i.offsetLeft + l;
    	    //var top = i.offsetTop + t + i.offsetHeight + 2;
			var box = getDimensions(i);
			var left = box.x, top = box.y;
			//if (alignX == 'left' && c.style.width){
			//	left = left - parseInt(c.style.width);
			//}
			//if (alignY == 'top' && c.style.height){
			//	top = top - parseInt(c.style.height) -25;
			//}
			c.style.visibility = 'hidden'; // Needed to measure
			c.style.display = "block";     // Needed to measure
			if(alignX == 'left')
				left -= c.offsetWidth;
			else
				left += i.offsetWidth;
			if(alignY == 'top')
				top -= c.offsetHeight;
			else
				top += i.offsetHeight;
			if(top<10)
				top = 10;
			// XXX: Don't know why IE5 needs this here and not for calendar
			if(gClientIsIE5) {
				left += document.body.scrollLeft;
				top += document.body.scrollTop;
			}
        	c.style.left = left+'px';
	        c.style.top = top+'px';
			c.style.visibility = 'visible';
		} else {
			c.style.display="none";
		}
	}
}

function hideDiv (div) {
	if (document.getElementById){
		var c=document.getElementById(div);
		c.style.display="none";
	}
}

var hide  = true;

// Getting element dimensions
function getDimensions( elm ) {
	var box = { x:0, y:0, w:0, h:0 };
	if(document.getBoxObjectFor) {
		var boxRef = document.getBoxObjectFor(elm);
		box.x = boxRef.x;
		box.y = boxRef.y;
		box.w = boxRef.width;
		box.h = boxRef.height;
	}
	else if(elm.getBoundingClientRect) {
		var rxIE50 = /MSIE 5\.0/g;
		//alert(rxIE50 + '.test("' + navigator.appVersion + '" = ' + rxIE50.test(navigator.appVersion));
		var boxRef = elm.getBoundingClientRect();
		box.x = boxRef.left;
		box.y = boxRef.top;
		box.w = (boxRef.right - boxRef.left);
		box.h = (boxRef.bottom - boxRef.top);
		//var s='';for(p in boxRef) s+=p+'    '; alert(s);
		// Damn IE...
		if(document.compatMode && document.compatMode != 'BackCompat') {
			// IE6/compliance mode
			box.x += document.documentElement.scrollLeft - 2;
			box.y += document.documentElement.scrollTop - 2;
		}
		else if(!gClientIsIE5) {
			// IE5.5
			box.x += document.body.scrollLeft - 2;
			box.y += document.body.scrollTop - 2;
		}
	}
	else {
		// No known box information available, walking
		// manually through offsetParents to calculate x/y coordinates
		box.w = elm.offsetWidth;
		box.h = elm.offsetHeight;
		while(elm) {
			box.x += elm.offsetLeft;
			box.y += elm.offsetTop;
			elm = elm.offsetParent;
		}
	}
	//var bodyDiv = document.getElementById('body');
	//box.x -= bodyDiv.offsetLeft;
	return box;
}