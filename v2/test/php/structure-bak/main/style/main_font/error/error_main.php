<tr>
<td align="left" colspan="2"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseFontsetError"
<?php
                if(empty($_SESSION['expand_editstructure_fontset_error']) || $_SESSION['expand_editstructure_fontset_error'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseFontsetError', 'img_expand_collapseFontsetError', 'expand_editstructure_fontset_error', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseFontsetError');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_editstructure_fontset_error']) || $_SESSION['expand_editstructure_fontset_error'] == 'false')
                        {
?>
                            <img id="img_expand_collapseFontsetError" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseFontsetError" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('edit_structure.blocktitle_error_font', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_editstructure_fontset_error" style="display: none;" type="hidden" name="expand_editstructure_fontset_error" value="<?php if(empty($_SESSION['expand_editstructure_fontset_error']) || $_SESSION['expand_editstructure_fontset_error'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseFontsetError"
<?php
        if(empty($_SESSION['expand_editstructure_fontset_error']) || $_SESSION['expand_editstructure_fontset_error'] == 'false')
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
                    include('modules/structure/main/style/main_font/error/error1.php');
                    include('modules/structure/main/style/main_font/error/error2.php');
                    include('modules/structure/main/style/main_font/error/error3.php');
?>
                </table></td>
            </tr>
        </table>
    </td>
</tr>
