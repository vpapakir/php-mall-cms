/*------------ All Javascript Codes have been created here -------------------*/
function popup(url, width, height)
{
    window.open(url, '','toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0, width='+width+', height='+height+'');
}

function reloadPage()
{
    document.location.reload(); 
}
/*-------------------------BEGIN LANGUAGE_EDIT--------------------------------*/

/*this function does a mouse's click simulation on a button*/
function OnChange(id_button)
{
    var button = document.getElementById(id_button); //button's tag included into a variable
    
    button.click(); //click on the button      
}
    

/*-------------------------END LANGUAGE_EDIT----------------------------------*/


/*----------------------------BEGIN SITEMAP-----------------------------------*/


/*------------------------------END SITEMAP-----------------------------------*/

/*----------------------------BEGIN PAGE_LISTING------------------------------*/

/*return default sentence value which is in Textarea*/
function default_sentence()
{
    /*gets tag element*/
    var tag = document.getElementById('txtTagSearch');
    
    /*gets value which is in this tag*/
    var get_sentence = tag.value;    

    return get_sentence;/*return the value*/
}

/*display or hidden a tag according to the selected option's tag*/
function check_dropdown(dropdown, tag, index)
{
    /*concerned dropdown included into a variable*/
    var select_tag = document.getElementById(dropdown);
    
    /*concerned tag included into a variable*/
    var hidden_tag = document.getElementById(tag);
    
    if(index == 0)/*if index value is == 0*/
    {
        if(select_tag.options.selectedIndex == index)/*if selected value is the first option's tag*/
        {
            hidden_tag.style.display = 'inline-block'; /*then, display concerned tag*/         
        }
        else
        {
            hidden_tag.style.display = 'none'; /*else, hidden concerned tag*/ 
        }
    }
    else /*else, if index value is != 0*/
    {
        if(select_tag.options.selectedIndex != index)/*if typed index value isn't == selected option's tag*/
        {
            hidden_tag.style.display = 'inline-block'; /*then, displays tag*/        
        }
        else
        {
            hidden_tag.style.display = 'none';  /*else, hidden tag*/   
        }
    }      
}

/*disabled dropdowns or textfields according checked radio button*/
function disable_dropdown(radio)
{   
    /*include radio's input according to it name into an array*/
    var selected_radio = document.getElementsByName(radio);
    
    var select_tag = new Array();/*an array created*/
    
    /*insert SELECT's tag into the array*/
    select_tag[0] = document.getElementById('page_listing_cboGroup');
    select_tag[1] = document.getElementById('page_listing_cboCateg');
    select_tag[2] = document.getElementById('areaSearch');

    
    for(var i = 0; i < 3; i++)/*this loop does 3 tours because the biggest array have got 3 indexes*/
    {  
        if(selected_radio[i].checked == true)/*if the selected radio button is checked*/
        {
            select_tag[i].disabled = false;/*the tag at i index is enabled*/
            
            if(select_tag[i].options.selectedIndex == -1)/*and first option selected*/
            {
               select_tag[i].options.selectedIndex = 0;
            }          
        }
        else
        {
            select_tag[i].disabled = true; /*the tag at i index is disabled*/
            
            if(i <= 1)/*and if 'i' value is < or == 2*/
            {
              select_tag[i].options.selectedIndex = -1;/*the selectedIndex tag at 'i' index becomes again to 0*/
            }
            
        }
    }         
}

/*checked radio button when user click specified tag*/
function check_radio(radio, tag)
{
    /*include concerned radio in a variable*/
    var check_radio = document.getElementById(radio);
    
    /*include concerned tag in a variable*/
    var click_tag = document.getElementById(tag);

    /*if dropdown has an option which selected*/
    if(click_tag.options.selectedIndex >= 0) 
    {       
        check_radio.checked = true;/*then radio button is checked*/
        disable_dropdown('rad_page_list');/*call function disable_dropdown*/
    }
    else
    {
        check_radio.checked = false;/*else, radio button unchecked*/
        disable_dropdown('rad_page_list');/*call function disable_dropdown*/
    }
}

function check_radio_textarea(radio, txt)
{
    /*gets concerned radio tag and includes it in a variable*/
    var check_radio = document.getElementById(radio);

    /*gets concerned textArea tag and includes it in a variable*/
    var click_txtarea = document.getElementById(txt);     
   
    /*radio becomes checked*/
    check_radio.checked = true;
    
    /*if value in textArea == to value return by default_sentence() function*/
    if(click_txtarea.value == default_sentence())
    {
       click_txtarea.innerHTML = null; /*all values which are in textarea erased*/
       disable_dropdown('rad_page_list'); /*calls function to disabled others dropdown*/
    }       
}

function display_arrow(block, index)
{
    var img_tag = document.getElementsByName(block);
           
    img_tag[index].hidden = false;

}

function hide_arrow(block, index)
{
    var img_tag = document.getElementsByName(block);
    
    img_tag[index].hidden = true;
}

//function upload_button_mouseover(button)
//{
//  var concerned_button = document.getElementById(button);
//    
//    concerned_button.className = 'upload_button2';
//}

//function upload_button_mouseout(button)
//{
// var concerned_button = document.getElementById(button);
//   
//   concerned_button.className = 'upload_button';
//}

function upload_insert_value(txt, pickon)
{
   var concerned_txt = document.getElementById(txt);
   
   var pickon_txt = document.getElementById(pickon);

   concerned_txt.value = pickon_txt.value; 
}

function popup(url, width, height)
{
    window.open(url, '','toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0, width='+width+', height='+height+'');
}




/*----------------------------END PAGE_LISTING--------------------------------*/

/*----------------------- TEXTFIELD FRONTEND SEARCH --------------------------*/
function txt_frontend_search()
{
    var textfield = document.getElementById('txtNavbarSearch');
    
    if(textfield.value == null)
    {     
        textfield.value = 'ex: aspirateur d711...';
        textfield.style.color = 'grey';
        textfield.style.fontStyle = 'oblique';
    }
    else
    {
        textfield.style.color = 'black';
        textfield.style.fontStyle = 'normal';
    }
}

function txt_frontend_search_onfocus()
{
   var textfield = document.getElementById('txtNavbarSearch');
   
   if(textfield.value == 'ex: aspirateur d711...')
   {
       textfield.value = '';
       textfield.style.color = 'black';
       textfield.style.fontStyle = 'normal';
   }
   
}

function txt_frontend_search_onblur()
{
   var textfield = document.getElementById('txtNavbarSearch');

   if(textfield.value.length == 0)
   {  
       textfield.value = 'ex: aspirateur d711...';
       textfield.style.color = 'grey';
       textfield.style.fontStyle = 'oblique';
   }
   else
   {
       textfield.style.color = 'black';
       textfield.style.fontStyle = 'normal';
   }
}

/*------------------ TEXTFIELD FRONTEND PRODUCT QUANTITY ---------------------*/

function add_qty()
{
   var txtQty = document.getElementById('txtQtyProduct');

   var notnumber = new RegExp("[^0-9]"); 
   
   if(txtQty.value.match(notnumber))
   {
      txtQty.value = 1; 
   }
   else
   {
      if(txtQty.value >= 99)
      {
         txtQty.value = 99; 
      }
      else
      {
         if(txtQty.value < 1)
         {
            txtQty.value = 1; 
         }
         
         txtQty.value++; 
      }  
   }
     
}

function remove_qty()
{
    var txtQty = document.getElementById('txtQtyProduct');
     
    var notnumber = new RegExp("[^0-9]"); 
   
    if(txtQty.value.match(notnumber))
    {
       txtQty.value = 1; 
    }
    else
    {
        if(txtQty.value <= 1)
        {
           txtQty.value = 1; 
        }
        else
        {
           if(txtQty.value > 99)
           {
              txtQty.value = 99;  
           }
           txtQty.value--; 
        }
    }
}

/*-------------------------- PRINT CENTRAL PAGE ------------------------------*/

function print_central_page(id)
{
    var page = document.getElementById(id);
    
    window.print();
}

/*-------------------------- SHIPMENT DESINATION -----------------------------*/

//function select_destination(index)
//{
//    var array_div = document.getElementsByName('shipment_destination');
//    
//    alert(array_div.length);
//    for(var i = 0; i < array_div.length; i++)
//    {
//       if(array_div[i].onclick())
//       {
//           array_div[i].style.backgroundColor = 'green';
//       }
//    }
//}

/*----*/

/*display or hidden a tag according to the selected option's tag*/
function check_dropdown_registration(dropdown, tag1, tag2, index)
{
    /*concerned dropdown included into a variable*/
    var select_tag = document.getElementById(dropdown);
    
    /*concerned tag included into a variable*/
    var hidden_tag1 = document.getElementById(tag1);
    var hidden_tag2 = document.getElementById(tag2);

    //alert(select_tag.options.selectedIndex);

    if(select_tag.options.selectedIndex == index)/*if selected value is the first option's tag*/
    {
        hidden_tag1.style.display = 'table'; /*then, display concerned tag*/  
        hidden_tag2.style.display = 'table-row';
    }
    else
    {
        hidden_tag1.style.display = 'none'; /*else, hidden concerned tag*/
        hidden_tag2.style.display = 'none';
        
    }      
}

function check_dropdown_registration_onload(dropdown, tag1, tag2, index)
{
    /*concerned dropdown included into a variable*/
    var select_tag = document.getElementById(dropdown);
    
    /*concerned tag included into a variable*/
    var hidden_tag1 = document.getElementById(tag1);
    var hidden_tag2 = document.getElementById(tag2);

    //alert(index);

    if(select_tag.options.selectedIndex == index)/*if selected value is the first option's tag*/
    {
        hidden_tag1.style.display = 'table'; /*then, display concerned tag*/  
        hidden_tag2.style.display = 'table-row';
    }
    else
    {
        hidden_tag1.style.display = 'none'; /*else, hidden concerned tag*/
        hidden_tag2.style.display = 'none';
        
    }      
}

function check_dropdown_registration_onsubmit(dropdown, tag1, tag2, index)
{
    /*concerned dropdown included into a variable*/
    var select_tag = document.getElementById(dropdown);
    
    /*concerned tag included into a variable*/
    var hidden_tag1 = document.getElementById(tag1);
    var hidden_tag2 = document.getElementById(tag2);

    //alert(index);
    

    if(select_tag.options.selectedIndex == index)/*if selected value is the first option's tag*/
    {
        hidden_tag1.style.display = 'table'; /*then, display concerned tag*/  
        hidden_tag2.style.display = 'table-row';
    }
    else
    {
        hidden_tag1.style.display = 'none'; /*else, hidden concerned tag*/
        hidden_tag2.style.display = 'none';
        
    }
}

function display_column_onkeypress(column, tag)
{
    var concerned_column = document.getElementById(column);    
    var concerned_tag = document.getElementById(tag);
    
    if(concerned_tag.value.length <= 1)
    {
        concerned_column.style.display = 'none';
    }
    else
    {
        concerned_column.style.display = 'table';
    }
    
}

function display_column_onload(column, tag)
{
    var concerned_column = document.getElementById(column);    
    var concerned_tag = document.getElementById(tag);
    
    if(concerned_tag.value.length <= 0)
    {
        concerned_column.style.display = 'none';
    }
    else
    {
        concerned_column.style.display = 'table';
    }
    
}

function check_all(chk_main, tag, chk_class)
{
    var main_checkbox = document.getElementById(chk_main);
    var checkboxes = document.getElementsByTagName(tag);
    
    var count_array = checkboxes.length;

    if(main_checkbox.checked == true)
    {
        for(var i = 0; i < count_array; i++)
        {
            if(checkboxes[i].className == chk_class)
            {
                checkboxes[i].checked = true;
            }
        }
        main_checkbox.checked = true;
    }
    else
    {
        for(i = 0; i < count_array; i++)
        {
            if(checkboxes[i].className == chk_class)
            {
                checkboxes[i].checked = false;
            }
        } 
        main_checkbox.checked = false;
    }
}

function onchange_color(select, div)
{
    var select_tag = document.getElementById(select);
    var div_tag = document.getElementById(div);
    
    div_tag.style.backgroundColor = select_tag.value;
}

/*--------- Preview Button/Block ---------------*/

function preview_button_show(bt, tags, css, name)
{
    var button = document.getElementById(bt);
    var tag = document.getElementById(tags);
    var isname = document.getElementsByName(name);

    if(css == 'fontsize' && tag.value < 99 && tag.value > 8)
    {
        button.style.fontSize = tag.value + 'px';
    }
    
    if(css == 'fontfamily')
    {
        button.style.fontFamily = tag.value;
    }
    
    if(css == 'fontweight')
    {
        button.style.fontWeight = tag.value;
    }
    
    if(css == 'fontcolor')
    {
        button.style.color = tag.value;
    }
    
    if(css == 'textalign')
    {
        button.style.textAlign = tag.value;
    }
    
    if(css == 'border')
    {
        button.style.border = tag.value + 'px solid';
    }
    
    if(css == 'bordercolor')
    {
        button.style.borderColor = tag.value;
    }
    
    if(css == 'bgcolor')
    {
        button.style.backgroundColor = tag.value;
    }
    
    if(css == 'width')
    {
        button.style.width = tag.value;
    }
    
    if(css == 'height')
    {
        button.style.height = tag.value;
    }
    
    if(css == 'padding')
    {
        button.style.padding = tag.value + 'px';
    }

    if(css == 'fontblock')
    {
        //isname[0].id = tag.value;
        isname[0].className = ' '+tag.value;
    }
}

function preview_show_hover(bt, tags)
{
    var button = document.getElementById(bt);
    var tag = document.getElementById(tags);
    
    button.style.backgroundColor = tag.value;
}

function preview_button_show_radius(bt, tags1, tags2, tags3, tags4)
{
    var button = document.getElementById(bt);
    var LT = document.getElementById(tags1);
    var RT = document.getElementById(tags2);
    var RB = document.getElementById(tags3);
    var LB = document.getElementById(tags4);
    
    if(LT.value == 'undefined' || LT.value == '')
    {
        LT.value = 0;    
    }
    
    if(RT.value == 'undefined' || RT.value == '')
    {
        RT.value = 0;    
    }
    
    if(RB.value == 'undefined' || RB.value == '')
    {
        RB.value = 0;    
    }
    
    if(LB.value == 'undefined' || LB.value == '')
    {
        LB.value = 0;    
    }
    
    button.style.borderRadius = LT.value+'px '+RT.value+'px '+RB.value+'px '+LB.value+'px'; // standard
    button.style.MozBorderRadius = LT.value+'px '+RT.value+'px '+RB.value+'px '+LB.value+'px'; // Mozilla
    button.style.WebkitBorderRadius = LT.value+'px '+RT.value+'px '+RB.value+'px '+LB.value+'px'; // WebKit
}

function insert_hover_active(original, tags1, tags2)
{
    var origin_tag = document.getElementById(original);
    var tagH = document.getElementById(tags1);
    var tagA = document.getElementById(tags2);
    
    tagH.value = origin_tag.value;
    tagA.value = origin_tag.value;
}

function language_add(select, inputtxt)
{
    var dropdown = document.getElementById(select);
    var txt = document.getElementById(inputtxt);
    
    txt.value = dropdown.value.toLowerCase();
}

function translation_code(select, inputtxt)
{
    var dropdown = document.getElementById(select);
    var txt = document.getElementById(inputtxt);

    txt.value = dropdown.value.toLowerCase() + '.';
    
}

function onkeyup_set(origin, destination)
{
    var getvalue = document.getElementById(origin);
    var setvalue = document.getElementById(destination);

    var regex = new RegExp("^[0-9a-zA-Z_-]{1,}$");
    
    if(getvalue.value.match(regex))
    {
        setvalue.value = getvalue.value.toLowerCase();
    }
    
    if(getvalue.value == '')
    {
        setvalue.value = '';
    }
}

function onkeyup_check(input)
{
//    var getvalue = document.getElementById(input);
//
//    var regex = new RegExp("^[0-9a-zA-Z- ]{1,}$");
//
//    var i = getvalue.value.length - 1;
//    alert(getvalue.value.charAt(i));
//    if(getvalue.value.charAt(i).match(regex))
//    {
//        alert(getvalue.value.charAt(i).toLowerCase());
//        getvalue.value.charAt(i) = getvalue.value.charAt(i).toLowerCase();
//    }
//    else
//    {
//        getvalue.value.charAt(i) = '';
//    }
    
}

function onkeyup_setnolimit(origin, destination)
{
    var getvalue = document.getElementById(origin);
    var setvalue = document.getElementById(destination);

    setvalue.value = getvalue.value;    
    
    if(getvalue.value == '')
    {
        setvalue.value = '';
    }
}

//function expand_collapse(block, img, img_expand, img_collapse)
//{
//    var get_block = document.getElementsByName(block);
//    var get_img = document.getElementById(img);
//    
//    var total_block = get_block.length;
//    
//    for(var i = 0; i < total_block; i++)
//    {       
//        if(get_block[i].style.display != 'none')
//        {
//           get_block[i].style.display = 'none';
//           get_img.innerHTML = '+';
//        }
//        else
//        {
//           get_block[i].style.display = '';
//           get_img.innerHTML = '-'; 
//        }
//    }
//}

function expand_collapse(block, img, hidden, img_expand, img_collapse, alt_expand, alt_collapse)
{
    var get_block = document.getElementById(block);
    var get_img = document.getElementById(img);

    var hiddenvalue = document.getElementById(hidden);
           
    if(get_block.style.display != 'none')
    {
       get_block.style.display = 'none';
       get_img.src = img_expand;
       if(hiddenvalue != null)
       {
           hiddenvalue.value = 'false';
       }
       if(alt_expand != null)
       {
           get_img.innerHTML = alt_expand;
       }
    }
    else
    {
       get_block.style.display = '';
       get_img.src = img_collapse; 
       if(hiddenvalue != null)
       {
           hiddenvalue.value = 'true';
       }
       if(alt_collapse != null)
       {
           get_img.innerHTML = alt_collapse;
       }
    }
}

function expand_collapse_tab(block, img, hidden, img_expand_src, img_collapse_src, img_expand_alt, img_collapse_alt, img_expand_title, img_collapse_title, collclass, expclass, tableexcol)
{
    var get_block = document.getElementById(block);
    var get_img = document.getElementById(img);
    var table = document.getElementById(tableexcol);

    var hiddenvalue = document.getElementById(hidden);
           
    if(get_block.style.display != 'none')
    {
       table.className = collclass;
       get_block.style.display = 'none';
       if(img_expand_src != null)
       {
           get_img.src = img_expand_src;
           get_img.alt = img_expand_alt;
           get_img.title = img_expand_title;
       }
       else
       {
           get_img.innerHTML = img_expand_alt;
       }
       hiddenvalue.value = 'false';
    }
    else
    {
       table.className = expclass;
       get_block.style.display = '';
       if(img_collapse_src != null)
       {
           get_img.src = img_collapse_src;
           get_img.alt = img_collapse_alt;
           get_img.title = img_collapse_title;
       }
       else
       {
           get_img.innerHTML = img_collapse_alt;
       }
       get_img.src = img_collapse_src;
       get_img.alt = img_collapse_alt;
       get_img.title = img_collapse_title;
       hiddenvalue.value = 'true';
    }
}

function charcountdown(input, result, max)
{
    var text = document.getElementById(input);
    var show_result = document.getElementsByName(result);

    show_result[0].innerHTML = max - text.value.length;
    
    if(show_result[0].innerHTML <= 0)
    {
        //show_result[0].innerHTML = 0;
        text.style.border='2px solid red'; 
    }
    else
    {
        text.style.border='';
    }
}

function include_generated_text(origin, target)
{
    var origin_txt = document.getElementById(origin);
    var target_txt = document.getElementById(target);
    
    target_txt.value = target_txt.value + ' ' + origin_txt.value;
}

function copyandpaste(getter, setter, prefix, suffix, tolower, txtinput, setterinput)
{
    var getthis = document.getElementById(getter);
    var setthis = document.getElementById(setter);
    
    if(txtinput != null && txtinput == 'true')
    {
        getthis = getthis.value;
    }
    else
    {
        getthis = getthis.innerHTML;
    }

    if(tolower != null && tolower == 'true')
    {
        prefix = prefix.toLowerCase();
        suffix = suffix.toLowerCase();
        getthis = getthis.toLowerCase();
    }
    
    if(prefix != null || suffix != null)
    {
        if(prefix == null)
        { 
            prefix = '';
        }
        
        if(suffix == null)
        { 
            suffix = '';
        }
        
        if(setterinput != null && setterinput == 'true')
        {
            setthis.value = prefix + getthis + suffix; 
        }
        else
        {
            setthis.innerHTML = prefix + getthis + suffix; 
        }
    }
    else
    {
        if(setterinput != null && setterinput == 'true')
        {
            setthis.value = getthis; 
        }
        else
        {
            setthis.innerHTML = getthis; 
        }
    }
     
}

function CopyPasteDisappear(getter, setter, hidden, result)
{
    var getthis = document.getElementById(getter);
    var setthis = document.getElementById(setter);
    var hiddentag = document.getElementById(hidden);
    var noresult = result;
    
    if(noresult == false)
    {
        setthis.value = getthis.value;  
        hiddentag.style.display ='none';   
    }
    
     
}

function langimage(tag, background)
{
    var selected_tag = document.getElementById(tag);
    var background_img = background;
    
    selected_tag.src = background_img;
}

function touppercase(input)
{
    var getthis = document.getElementById(input);
    
    getthis.value = getthis.value.toUpperCase();
}

function userdatatitle(id, hidden)
{
    var select = document.getElementById(id);
    var hiddentag = document.getElementById(hidden);

    if(select.options[select.options.selectedIndex].value == 9)
    {
        hiddentag.style.display = '';    
    }
    else
    {
        hiddentag.style.display = 'none';    
    } 
}

function userdatatype(id, hidden)
{
    var select = document.getElementById(id);
    var hiddentag = document.getElementById(hidden);

    if(select.value == 'professional')
    {
        hiddentag.style.display = '';    
    }
    else
    {
        hiddentag.style.display = 'none';    
    } 
}

function hideshow(hidden, link, hidevalue, showvalue)
{
    var linktag = document.getElementById(link);  
    var hiddentag = document.getElementById(hidden);  

    if(hiddentag.style.display == 'none')
    {
        if(hidevalue.length > 0)
        {
           linktag.innerHTML = hidevalue; 
        }   
        hiddentag.style.display = '';  
    }
    else
    {
        if(showvalue.length > 0)
        {
           linktag.innerHTML = showvalue;
        }
        hiddentag.style.display = 'none';    
    }
}

function yesno_button(mainbt, hidden)
{
    var button_main = document.getElementById(mainbt); 
    var hiddentag = document.getElementById(hidden); 
    
    if(hiddentag.style.display == '')
    {
        hiddentag.style.display = 'none';
        button_main.style.display = '';
    }
    else
    {
        hiddentag.style.display = '';
        button_main.style.display = 'none';
    }
}