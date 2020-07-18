<?php
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{       
?>
<tr>
    <td align="left"><table class="block_expandmain1" width="100%" border="0">
        <tr>
            <td align="left">
                <table id="collapseAdvertLang<?php echo($main_activatedidlang[$i]); ?>"
<?php
                    if(empty($_SESSION['expand_advertedit_lang'.$main_activatedidlang[$i]]) || $_SESSION['expand_advertedit_lang'.$main_activatedidlang[$i]] == 'false')
                    {
                        echo('class="block_collapsetitle1"');
                    }
                    else
                    {
                        echo('class="block_expandtitle1"');
                    }
?>
                     width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseAdvertLang<?php echo($main_activatedidlang[$i]); ?>', 'img_expand_collapseAdvertLang<?php echo($main_activatedidlang[$i]); ?>', 'expand_advertedit_lang<?php echo($main_activatedidlang[$i]); ?>', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseAdvertLang<?php echo($main_activatedidlang[$i]); ?>');" style="cursor: pointer;">
                    <td align="left">                    
<?php
                            if(empty($_SESSION['expand_advertedit_lang'.$main_activatedidlang[$i]]) || $_SESSION['expand_advertedit_lang'.$main_activatedidlang[$i]] == 'false')
                            {
?>
                                <img id="img_expand_collapseAdvertLang<?php echo($main_activatedidlang[$i]); ?>" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                            }
                            else
                            {
?>
                                <img id="img_expand_collapseAdvertLang<?php echo($main_activatedidlang[$i]); ?>" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                            }
?>                    
                    </td>
                    <td width="100%" align="center">
                        <span><?php give_translation($main_activatedcodelang[$i]); ?></span>
                    </td>
                    <td align="left"></td>
                </table>
                <input id="expand_advertedit_lang<?php echo($main_activatedidlang[$i]); ?>" style="display: none;" type="hidden" name="expand_advertedit_lang<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(empty($_SESSION['expand_advertedit_lang'.$main_activatedidlang[$i]]) || $_SESSION['expand_advertedit_lang'.$main_activatedidlang[$i]] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
            </td>
        </tr>
        <tr id="block_expand_collapseAdvertLang<?php echo($main_activatedidlang[$i]); ?>"
<?php
            if(empty($_SESSION['expand_advertedit_lang'.$main_activatedidlang[$i]]) || $_SESSION['expand_advertedit_lang'.$main_activatedidlang[$i]] == 'false')
            {
                echo('style="display: none;"');
            }
            else
            {
                echo(null);
            }
?>
            >
            <td><table width="100%">
<?php
                include('modules/advertising/content/advert_content.php');
?>
            </table></td>
        </tr>
    </table></td>
</tr>
<?php
}
?>