<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapsePageURL"
<?php
                if(empty($_SESSION['expand_page_url']) || $_SESSION['expand_page_url'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapsePageURL', 'img_expand_collapsePageURL', 'expand_page_url', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapsePageURL');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_page_url']) || $_SESSION['expand_page_url'] == 'false')
                        {
?>
                            <img id="img_expand_collapsePageURL" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapsePageURL" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('page_edit.block_title_rewriting', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_page_url" style="display: none;" type="hidden" name="expand_page_url" value="<?php if(empty($_SESSION['expand_page_url']) || $_SESSION['expand_page_url'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapsePageURL"
<?php
        if(empty($_SESSION['expand_page_url']) || $_SESSION['expand_page_url'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        >
                <td><table width="100%" cellpadding="0" cellspacing="1">
<?php
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {       
?>        
            <tr>
                <td><table width="100%">
                    <tr>        
                        <td>
                            <div class="font_subtitle"><?php give_translation($main_activatedcodelang[$i]); ?></div>
                        </td> 
                        <td align="right">
                            <span class="font_main">Frontend</span>          
                        </td>
                        <td width="<?php echo($right_column_width); ?>">
                            <input style="width: 100%;" type="text" name="txtPageURLRewritingF<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['page_url_txtPageURLRewritingF'.$main_activatedidlang[$i]])){ echo($_SESSION['page_url_txtPageURLRewritingF'.$main_activatedidlang[$i]]); } ?>"></input>
                        </td>
                    </tr>
                    <tr>        
                        <td>
                        </td> 
                        <td align="right">
                            <span class="font_main">Backoffice</span>
                        </td>
                        <td>
                            <input style="width: 100%;" type="text" name="txtPageURLRewritingB<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['page_url_txtPageURLRewritingB'.$main_activatedidlang[$i]])){ echo($_SESSION['page_url_txtPageURLRewritingB'.$main_activatedidlang[$i]]); } ?>"></input>
                        </td>
                    </tr> 
                </table></td>
            </tr>
<?php
        }
?>   
            <tr>
                <td colspan="2" style="border-top: 1px solid lightgrey;"><table width="100%" style="margin-top: 4px;">
                    <tr>        
                        <td></td> 
                        <td></td>
                        <td width="<?php echo($right_column_width); ?>">
                            <input type="submit" name="bt_save_page" value="<?php give_translation('page_edit.main_bt_save', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>
            </table></td>
        </tr>    
            
        
        </table>
    </td>
</tr>
