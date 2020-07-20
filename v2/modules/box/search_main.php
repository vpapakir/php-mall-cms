<?php
    $searchmainbox_defaultvalue = give_translation('search_main.box_defaultvalue', 'false', $config_showtranslationcode);
    include('modules/search/searchmain/bt_main_search.php');   
?>
<form method="post"><table width="100%" border="0" cellpadding="0" cellspacing="0" 
                           style="border-radius: 8px 8px 8px 8px; 
/*                         -moz-border-radius: 8px 8px 8px 8px;*/
                          -webkit-border-radius: 8px 8px 8px 8px;
                          background-color: white;">
    <tr>
    <td>
        <input style="border-radius: 6px 0px 0px 6px; 
/*                      -moz-border-radius: 6px 0px 0px 6px;*/
                      -webkit-border-radius: 6px 0px 0px 6px;
                      border: none; padding: 4px;
                      <?php if(empty($_SESSION['searchmain_txtMainSearch'])){ ?> color: lightgrey; font-style: italic; <?php } ?>"
                      <?php if(empty($_SESSION['searchmain_txtMainSearch'])){ ?> onfocus="this.value = ''; this.style.color = 'black'; this.style.fontStyle = 'normal';" onblur="if(this.value.length == 0){ this.value = '<?php echo($searchmainbox_defaultvalue); ?>'; this.style.color = 'lightgrey'; this.style.fontStyle = 'italic'; }" <?php } ?>
                      type="text" name="txtMainSearch" value="<?php if(!empty($_SESSION['searchmain_txtMainSearch'])){ echo($_SESSION['searchmain_txtMainSearch']); }else{ echo($searchmainbox_defaultvalue); } ?>"></input>
    </td>
    <td>
        <input style="border-radius: 0px 6px 6px 0px; 
/*                      -moz-border-radius: 0px 6px 6px 0px;*/
                      -webkit-border-radius: 0px 6px 6px 0px; padding: 4px;" type="submit" name="bt_main_search" value="<?php give_translation('main.bt_search', "true", $config_showtranslationcode); ?>"></input>
    </td>
    </tr>
    
</table></form>
