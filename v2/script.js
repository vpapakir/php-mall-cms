/*------------ All Javascript Codes have been created here -------------------*/


/*---------------------------BEGIN USER_ADD CHECKED SCRIPT--------------------*/

/*I create an img's tag which will display according to values written by user
            *in textfield are correct or incorrect*/
var k = 0;
var image_valid = []; //creation of array
for(k = 0; k < 5; k++)//loop 'for' which creates an index to 'image_valid's array
{
    image_valid[k] = document.createElement('img');/*create the tag*/
    image_valid[k].id = 'imgvalid'; /*give a tag's id*/
    image_valid[k].alt = 'validated';/*give a tag's alt if the .png didn't find*/
    image_valid[k].src = 'graphics/icons/check2.png';/*give location of the .png which insert
                                            *into the img's tag*/
}

/*insert and display the img's tag call 'image_valid[k]' before another tag,
                    *here call 'beforetag' */
function imageOK(k, getElementTag, beforetag)
{
    /*insert the img's tag at 'k' index before the tag call 'beforetag'
     *between the 'getElementTag's tag (<td></td>)*/
    getElementTag.insertBefore(image_valid[k], beforetag);
    image_valid[k].style.display = 'inline-block'; /*display img's tag call 'image_valid' at 'k' index*/
}


/* hide the img's tag call 'image_valid' at 'k' index */
function imageNotOK(k)
{
    image_valid[k].style.display = 'none';
}




/*----------------------------------------------------------------------------*/

/*disable tooltips display*/
function tooltip_disable()
{
    var spans = document.getElementsByTagName('span'); //all span's tags included in array

    for(var i = 0; i < spans.length; i++)/*loop 'for' which goes through the array 'spans'*/
    {
        if(spans[i].className == 'tooltip') /*if a span's class call 'tooltip'...*/
            {
                spans[i].style.display = 'none'; /*span's display at i index disabled*/
            }
    }
}
/*----------------------------------------------------------------------------*/

/*get tooltip which correspond to the input's tag*/
function getTooltip(element) /*arg's an input's tag*/
{
    while((element = element.nextSibling)) /*loop 'while' check all tags after an input's tag*/
    {
        if(element.className == 'tooltip') /*if an element which call 'tooltip' found... */
            {
                return element; //function return this tag's value
            }
    }

    return false;
}

/*----------------------------------------------------------------------------*/

/*an array created call 'check'*/
var check = [];

/*----------------------------------------------------------------------------*/

/*check chars whiches wrote by user into the textbox 'txtPseudo'*/
check['txtPseudo'] = function()
{
    /*create a new REGEX's object which check if Pseudo began by 4 alpha chars
     *and continued by a '-' special char or not after the fourth char it could be
     *alphanum chars*/
    var regex = new RegExp("^[a-zA-Z]{2,}[-]?[a-zA-Z0-9]+$");
    var pseudo = document.getElementById('txtPseudo'); /*tag call 'txtPseudo'
                                                       *included in a variable*/

    /* get tag call 'tooltip_pseudo' and included it in a variable */
    var tooltypeValue = document.getElementById('tooltip_pseudo');

    /* get tag call 'br_pseudo' and included it in a variable */
    var getBR = document.getElementById('br_pseudo');

    /* get tag call 'td_user_add_input1' and included it in a variable */
    var getTagElement = document.getElementById('td_user_add_input1');
    

    var tooltypeStyle = getTooltip(pseudo).style; /*function 'getTooltip().style'
                                                  *included in a variable*/

    /*if pseudo's value length is upper than 4 chars and REGEX's true*/
    if(pseudo.value.length > 2 && pseudo.value.match(regex)) 
        {
            pseudo.className = 'correct'; /*add class '.correct' to the input
                                          *which correspond to the id 'txtPseudo'*/
            
            tooltypeStyle.display = 'none';//tooltip didn't display

            imageOK(0, getTagElement, getBR); /*use imageOK function to display the img's
                                    *tag before the "br_pseudo"'s tag*/
            return true;
        }
        else
        {
            if(pseudo.value.length == 0)/*if pseudo's length value == 0*/
            {
                pseudo.className = 'incorrect';
                tooltypeStyle.display = 'inline-block';

                /*we change the value which's between the 'tooltypeValue's tag*/
                tooltypeValue.innerHTML = 'Veuillez saisir un Pseudo';


                imageNotOK(0);/*we call 'imageNotOK(k)' function which hide the
                                *'image_valid's icon before the 'getBR's tag*/

                return false;
            }

            if(pseudo.value.length <= 2)
            {
                pseudo.className = 'incorrect';/*add class '.incorrect' to the input
                                               *which correspond to the id 'txtPseudo' here*/
                tooltypeStyle.display = 'inline-block';//tooltip display inline-block
                tooltypeValue.innerHTML = 'Votre Pseudo doit faire plus de 4 caractères';

                imageNotOK(0);
                return false;

            }
            
            if(!pseudo.value.match(regex))
            {
                pseudo.className = 'incorrect';
                tooltypeStyle.display = 'inline-block';
                tooltypeValue.innerHTML = 'Votre pseudo doit être composer de caractères de type A-Z, a-z ou 0-9';

                imageNotOK(0);
                return false;               
            }           
        }
};

/*----------------------------------------------------------------------------*/

/*check chars whiches wrote by user into the textbox 'txtMail' and 'txtConfirmMail'*/
check['txtMail'] = function()
{
    var regex = new RegExp("^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\\.[a-z]{2,6}$");

    var txtMail = document.getElementById('txtMail');
    var tooltypeStyle = getTooltip(txtMail).style;

    var tooltypeValue = document.getElementById('tooltip_mail');

    var getBR = document.getElementById('br_mail');

    var getTagElement = document.getElementById('td_user_add_input2');

        if(txtMail.value.match(regex))
        {
            txtMail.className = 'correct';
            tooltypeStyle.display = 'none';

            imageOK(1, getTagElement, getBR);

            return true;
        }
        else
        {
            if(txtMail.value.length == 0)
            {
                txtMail.className = 'incorrect';
                tooltypeStyle.display = 'inline-block';

                tooltypeValue.innerHTML = 'Veuillez saisir une adresse EMail'

                imageNotOK(1);

                return false;
            }

            if(!txtMail.value.match(regex))
            {
                txtMail.className = 'incorrect';
                tooltypeStyle.display = 'inline-block';

                tooltypeValue.innerHTML = 'Veuillez saisir un format d\'E-Mail valide'

                imageNotOK(1);

                return false;
            }
        }
};

check['txtConfirmMail'] = function()
{
    var txtMail = document.getElementById('txtMail');
    var txtConfirmMail = document.getElementById('txtConfirmMail');
    var tooltypeStyle = getTooltip(txtConfirmMail).style;

    var tooltypeValue = document.getElementById('tooltip_confirmMail');

    var getBR = document.getElementById('br_confirmMail');

    var getTagElement = document.getElementById('td_user_add_input3');

/*if the txtMail's value is equal to the txtConfirmMail's value
                *AND txtConfirmMail isn't empty*/
    if(txtMail.value == txtConfirmMail.value && txtConfirmMail.value != '')
        {
            txtConfirmMail.className = 'correct';
            tooltypeStyle.display = 'none';

            imageOK(2, getTagElement, getBR);

            return true;
        }
        else
        {
            if(txtConfirmMail.value.length == 0)
            {
                txtConfirmMail.className = 'incorrect';
                tooltypeStyle.display = 'inline-block';

                tooltypeValue.innerHTML = 'Veuillez saisir la confirmation de votre E-Mail';

                imageNotOK(2);

                return false;
            }

            if(txtMail.value != txtConfirmMail.value)
            {
                txtConfirmMail.className = 'incorrect';
                tooltypeStyle.display = 'inline-block';
                
                tooltypeValue.innerHTML = 'Veuillez confirmer votre E-Mail';
                
                imageNotOK(2);
                
                return false;
            }
        }
};

/*function which doesn't allow to paste value where in textbox 'txtMail' above
                    *in textbox 'txtConfirmMail'  */

//document.getElementById('txtConfirmMail').onpaste = function()
//                                                {
//                                                    return false;
//                                                };

/*----------------------------------------------------------------------------*/

/*check chars whiches wrote by user into the textbox 'pwd' and 'confirmPwd'*/

check['pwd'] = function()
{
    var pwd = document.getElementById('pwd');
    var tooltypeStyle = getTooltip(pwd).style;

    var tooltypeValue = document.getElementById('tooltip_pwd');

    var getBR = document.getElementById('br_pwd');

    var getTagElement = document.getElementById('td_user_add_input4');

    if(pwd.value.length >= 6 && pwd.value.length <= 12)
        {
            pwd.className = 'correct';

            tooltypeStyle.display = 'none';

            imageOK(3, getTagElement, getBR);

            return true;
        }
        else
        {
            if(pwd.value.length == 0)
            {
                pwd.className = 'incorrect';
                tooltypeStyle.display = 'inline-block';

                tooltypeValue.innerHTML = 'Veuillez saisir un mot de passe';

                imageNotOK(3);

                return false;
            }

            if(pwd.value.length < 6)
            {
                pwd.className = 'incorrect';
                tooltypeStyle.display = 'inline-block';

                tooltypeValue.innerHTML = 'Veuillez saisir un mot de passe de 6 caractères alphanumériques minimum';

                imageNotOK(3);

                return false;
            }

            if(pwd.value.length > 12)
            {
                pwd.className = 'incorrect';
                tooltypeStyle.display = 'inline-block';

                tooltypeValue.innerHTML = 'Veuillez saisir un mot de passe de 6 à 12caractères alphanumériques maximum';

                imageNotOK(3);

                return false;
            }


        }
};

check['confirmPwd'] = function()
{
    var pwd = document.getElementById('pwd');
    var pwd2 = document.getElementById('confirmPwd');
    var tooltypeStyle = getTooltip(pwd2).style;

    var tooltypeValue = document.getElementById('tooltip_confirmPwd');

    var getBR = document.getElementById('br_confirmPwd');

    var getTagElement = document.getElementById('td_user_add_input5');

    if(pwd.value == pwd2.value && pwd2.value != '')
    {
        pwd2.className = 'correct';
        tooltypeStyle.display = 'none';

        imageOK(4, getTagElement, getBR);
        
        return true;
    }
    else
    {
        if(pwd2.value.length == 0)
        {
            pwd2.className = 'incorrect';
            tooltypeStyle.display = 'inline-block';

            tooltypeValue.innerHTML = 'Veuillez saisir la confirmation de votre Mot de Passe';

            imageNotOK(4);

            return false;
        }

        if(pwd2.value != pwd.value)
        {
            pwd2.className = 'incorrect';
            tooltypeStyle.display = 'inline-block';

            tooltypeValue.innerHTML = 'Veuillez confirmer votre Mot de Passe';

            imageNotOK(4);

            return false;
        }

    }
};

/*function which doesn't allow to paste value where in textbox 'pwd' above
                    *in textbox 'confirmPwd'  */
//document.getElementById('confirmPwd').onpaste = function()
//                                                {
//                                                    return false;
//                                                };                                             
                                                
/*----------------------------------------------------------------------------*/

/*EVENTS*/

(function()  // using anonymous function to avoid globals variables.
{

/*get all tags call 'form_user_add' and included them into a variable*/
  var form_user_add = document.getElementById('form_user_add');

/*get all input's tags and included them into a variable*/
  var inputs = document.getElementsByTagName('input');

/*there are 6 input's tags in 'user_add.php' script*/
  for (var i = 0; i < inputs.length; i++)
  {
    /*if input's tag at 'i' index is a text or password's type*/
    if (inputs[i].type == 'text' || inputs[i].type == 'password')
    {

      inputs[i].onkeyup = function()/*when user press key on his keyboard*/
      {
        //this function call the differents check functions
        check[this.id](this.id); // "this" represent actually modified input

      };

    }
  }
  
  bt_submit_user = document.getElementById('bt_submit_user');
  /*this function run when user clicked on submit button*/

  

  bt_submit_user.onclick = function()
  {
    var result = true; //creation of boolean variable

    for (var i in check) /*loop 'for' which goes through the array 'check'*/
    {
      result = check[i](i) && result; /*check [i](i)'s function has a
                                     *true or false value at 'i' index*/
    }

    if (result)/*if var result == true...*/
    {
        return true /*...the form can be submited...*/
    }
    else
    {
        return false; /*...else, inputs ,whiches are false, are indicated*/
    }

  };
  

})();


/* now that everything has initialized, tooltip's display can be disable
                * when 'script.js' has been loaded"*/

tooltip_disable();

/*-----------------------------END USER_ADD CHECKED SCRIPT--------------------*/

/*-------------------------BEGIN LANGUAGE_EDIT--------------------------------*/

function submitTnumber(id_select) {
	var idselect = document.getElementById(id_select);
	if(idselect) {
		var x=document.getElementById(id_select).selectedIndex;
		var y=document.getElementById(id_select).options;
		if(y[x] == "sent") {
			var retVal = prompt("Enter the tracking number: ", "tracking  number");
			var data = 'tnumber=' + retVal;
			$.ajax({
				url: 'passtnumber.php',
				//GET method is used
				type: "GET",
				//pass the data
				data: data,
				//Do not cache the page
				cache: false,
				//success
				success: function (html) {
					alert("The tracking number you have entered is: "+html);
				}
			});
		}
	}
}

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
            else
            {
                checkboxes[i].checked = false;
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
            else
            {
                checkboxes[i].checked = true;
            }
        } 
        main_checkbox.checked = false;
    }
}

function randomString(input) 
{
    var textfield = document.getElementById(input);
    var chars = "34679ACEFGHJKLMNPRSTUWXTZabcdefghikmnopqrstuwxyz";
    var string_length = 8;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum,rnum+1);
    }
    
    textfield.value = randomstring;
}