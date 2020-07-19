<tr>
<td align="left" colspan="2"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseFontsetInfo"
<?php
                if(empty($_SESSION['expand_editstructure_fontset_info']) || $_SESSION['expand_editstructure_fontset_info'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseFontsetInfo', 'img_expand_collapseFontsetInfo', 'expand_editstructure_fontset_info', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseFontsetInfo');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_editstructure_fontset_info']) || $_SESSION['expand_editstructure_fontset_info'] == 'false')
                        {
?>
                            <img id="img_expand_collapseFontsetInfo" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseFontsetInfo" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('edit_structure.blocktitle_info_font', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_editstructure_fontset_info" style="display: none;" type="hidden" name="expand_editstructure_fontset_info" value="<?php if(empty($_SESSION['expand_editstructure_fontset_info']) || $_SESSION['expand_editstructure_fontset_info'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseFontsetInfo"
<?php
        if(empty($_SESSION['expand_editstructure_fontset_info']) || $_SESSION['expand_editstructure_fontset_info'] == 'false')
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
                    include('modules/structure/main/style/main_font/info/info1.php');
                    include('modules/structure/main/style/main_font/info/info2.php');
                    include('modules/structure/main/style/main_font/info/info3.php');
                    include('modules/structure/main/style/main_font/info/info4.php');
                    include('modules/structure/main/style/main_font/info/info5.php');
?>
                </table></td>
            </tr>
        </table>
    </td>
</tr>
